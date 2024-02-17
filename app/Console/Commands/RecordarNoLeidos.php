<?php

namespace SQ10\Console\Commands;

use SQ10\helpers\Util as Util;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use SQ10\Mail\NotificacionNoLeido;
use DB;

class RecordarNoLeidos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recordar:noleidos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envía correo y sms con los procesos que no se han ledído en el buzón';

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
      $responsables = DB::table('juriresponsables')
                    ->join('usuarios', 'juriresponsables.usuarios_idUsuario', '=', 'usuarios.idUsuario')
                    ->where('estadoResponsable', '=', 1)
                    ->get();

      if(count($responsables) > 0)
      {
        foreach ($responsables as $responsable) 
        {
          $procesosNoLeidos = DB::table('juriradicados')
                ->join('juriestadosetapas', function ($join) {
                    $join->on('juriradicados.vigenciaRadicado', '=', 'juriestadosetapas.juriradicados_vigenciaRadicado')
                    ->on('juriradicados.idRadicado', '=', 'juriestadosetapas.juriradicados_idRadicado');
                })
                ->leftJoin('jurijuzgados', 'juriradicados.jurijuzgados_idJuzgado', '=', 'jurijuzgados.idJuzgado')
                ->leftJoin('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
                ->join('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                ->where('juritipoestadosetapas_idTipoEstadoEtapa', '=', 1)// en proceso
                ->where('juritiposestados_idTipoEstado', '=', 3)// actuación
                ->where('leidoEstado', '=', 0)// sin leer en el buzón
                ->where('juriestadosetapas.juriresponsables_idResponsable', '=', $responsable->idResponsable)
                ->get();

          if(count($procesosNoLeidos) > 0)
          {
            $arraySinLeer = array();

            foreach ($procesosNoLeidos as $noLeido) 
            {
              if ($responsable->emailUsuario !='' && Util::valid_email_address($responsable->emailUsuario))
              {
                Util::guardarEmail($responsable->emailUsuario, $noLeido->vigenciaRadicado."-".$noLeido->idRadicado, 3);// proyecto 3 jurídica

                $rutaEmail = "";

                if($noLeido->idTipoProcesos == 1)
                {
                    $rutaEmail   = "actuacionProc-judi/index/".$noLeido->idEstadoEtapa;
                }
                else if($noLeido->idTipoProcesos == 2)
                {
                    $rutaEmail   = "actuacionConci-prej/index/".$noLeido->idEstadoEtapa;
                }
                else if($noLeido->idTipoProcesos == 3)
                {
                    $rutaEmail   = "actuacionTutelas/index/".$noLeido->idEstadoEtapa;
                }

                $datos = array('radicadoJuzgado'   => $noLeido->radicadoJuzgado,
                               'juzgado'           => $noLeido->nombreJuzgado,
                               'fechaReparto'      => 
                                                    ucfirst(utf8_encode(strftime("%A %d de %B de %Y", strtotime($noLeido->fechaInicioEstado)))),
                               'vigenciaRadicado'  => $noLeido->vigenciaRadicado,
                               'idRadicado'        => $noLeido->idRadicado,
                               'tema'              => $noLeido->nombreTema,
                               'nombreTipoProceso' => $noLeido->nombreTipoProceso,
                               'rutaEmail'         => $rutaEmail
                              );

                array_push($arraySinLeer, $datos);
              }
            }

            if(count($arraySinLeer) > 0)
            {
              $data = array('arraySinLeer'  => $arraySinLeer,
                            'nombreUsuario' => $responsable->nombresUsuario);

              Mail::to($responsable->emailUsuario, 'xxxxx')
                    ->queue(new NotificacionNoLeido($data));


              if($responsable->celularUsuario !='')
              {
                $expresion = '/^[3][0-9]{9}+$/';
                if(preg_match($expresion, $responsable->celularUsuario))
                {
                    $nombreUsu = explode(" ", $responsable->nombresUsuario);

                    $mensaje = "Hola ".$nombreUsu[0]." Recuerde los ".count($arraySinLeer)." procesos nuevos sin leer en el buzón de litígo que aún no se han empezado a trabajar.";

                    Util::enviarSms($responsable->celularUsuario, $mensaje);
                }
              }
            }
          }
        }
      }
    }
}
