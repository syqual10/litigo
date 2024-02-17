<?php

namespace SQ10\Console\Commands;

use SQ10\helpers\Util as Util;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use SQ10\Mail\NotificacionTutela;
use DB;

class RecordarTutela extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recordar:tutela';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envía con las tutelas que vencen, tanto por email como por sms';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
      $diaHoy = date ('Y-m-d');

      $tutelasVencen = DB::table('juriplazoradicado')
                        ->where('fechaVence', '=', $diaHoy)
                        ->get();

      if(count($tutelasVencen) > 0)
      {
        foreach ($tutelasVencen as $tutela) 
        {
          $procesos = DB::table('juriradicados')
                    ->join('juriestadosetapas', function ($join) {
                        $join->on('juriradicados.vigenciaRadicado', '=', 'juriestadosetapas.juriradicados_vigenciaRadicado')
                        ->on('juriradicados.idRadicado', '=', 'juriestadosetapas.juriradicados_idRadicado');
                    })
                    ->join('juriresponsables', 'juriestadosetapas.juriresponsables_idResponsable', '=', 'juriresponsables.idResponsable')
                    ->join('usuarios', 'juriresponsables.usuarios_idUsuario', '=', 'usuarios.idUsuario')
                    ->join('jurijuzgados', 'juriradicados.jurijuzgados_idJuzgado', '=', 'jurijuzgados.idJuzgado')
                    ->join('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
                    ->where('juritipoestadosetapas_idTipoEstadoEtapa', '=', 1)
                    ->where('juritiposestados_idTipoEstado', '=', 3)
                    ->where('vigenciaRadicado', '=', $tutela->radicados_vigenciaRadicado)
                    ->where('idRadicado', '=', $tutela->radicados_idRadicado)
                    ->get();

          if(count($procesos) > 0)
          {
            foreach ($procesos as $proceso) 
            {
              if ($proceso->emailUsuario !='' && Util::valid_email_address($proceso->emailUsuario))
              {
                Util::guardarEmail($proceso->emailUsuario, $tutela->radicados_vigenciaRadicado."-".$tutela->radicados_idRadicado, 3);// proyecto 3 jurídica
                
                $data = array('nombreUsuario'    => $proceso->nombresUsuario,
                              'radicadoJuzgado'  => $proceso->radicadoJuzgado,
                              'juzgado'          => $proceso->nombreJuzgado,
                              'fechaVence'       => 
                                                    ucfirst(utf8_encode(strftime("%A %d de %B de %Y", strtotime($diaHoy)))),
                              'vigenciaRadicado' => $tutela->radicados_vigenciaRadicado,
                              'idRadicado'       => $tutela->radicados_idRadicado,
                              'tema'             => $proceso->nombreTema
                             );

                Mail::to($proceso->emailUsuario, 'xxxxx')
                    ->queue(new NotificacionTutela($data));
              }

              if($proceso->celularUsuario !='')
              {
                  $expresion = '/^[3][0-9]{9}+$/';
                  if(preg_match($expresion, $proceso->celularUsuario))
                  {
                      $nombreUsu = explode(" ", $proceso->nombresUsuario);
                      

                      $mensaje = "Hola ".$nombreUsu[0]." hoy ".ucfirst(utf8_encode(strftime("%A %d de %B de %Y", strtotime($diaHoy))))."vence la tutela, radicado juzgado ".$proceso->radicadoJuzgado.", Juzgado ".$proceso->nombreJuzgado." ,proceso interno litígo ".$tutela->radicados_idRadicado."-".$tutela->radicados_vigenciaRadicado;

                      Util::enviarSms($proceso->celularUsuario, $mensaje);
                  }
              }
            }
          }
        }                  
      }
    }
}
