<?php

namespace SQ10\Console\Commands;

use SQ10\helpers\Util as Util;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use SQ10\Mail\NotificacionAntesAgenda;
use DB;

class RecordarAntesAgenda extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recordar:antesagenda';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando que recuerda la agenda con días de antelación';

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
      $diaHoy = date('Y-m-d');

      $responsables = DB::table('juriresponsables')
                    ->join('usuarios', 'juriresponsables.usuarios_idUsuario', '=', 'usuarios.idUsuario')
                    ->where('estadoResponsable', '=', 1)
                    ->get();

      if(count($responsables) > 0)
      {
        foreach ($responsables as $responsable) 
        {
          //Enviar notificaciones
          $agendas = DB::table('juriagendas')
                            ->leftJoin('juriradicados', function ($leftJoin) {
                              $leftJoin->on('juriagendas.juriradicados_vigenciaRadicado', '=', 'juriradicados.vigenciaRadicado')
                              ->on('juriagendas.juriradicados_idRadicado', '=', 'juriradicados.idRadicado');
                            })
                            ->leftJoin('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                            ->leftJoin('jurimedioscontrol', 'juriradicados.jurimedioscontrol_idMediosControl', '=', 'jurimedioscontrol.idMediosControl')
                            ->leftJoin('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
                            ->leftJoin('jurijuzgados', 'juriradicados.jurijuzgados_idJuzgado', '=', 'jurijuzgados.idJuzgado')
                            ->where('juriagendas.notificacionAgenda', '!=', 0)
                            ->where('juriagendas.juriresponsables_idResponsable', '=', $responsable->idResponsable)
                            ->orderBy('fechaInicioAgenda', 'asc')
                            ->get();

          if(count($agendas) > 0)
          {
            foreach ($agendas as $agenda) 
            { 
              $dateIni = date_create($agenda->fechaInicioAgenda); 
              $dateIni = date_format($dateIni, 'Y-m-d');

              $dias = (strtotime($diaHoy)-strtotime($dateIni))/86400;
              $dias = abs($dias); $dias = floor($dias);

              if($dias == $agenda->tiempoNotificacion)
              {
                if($agenda->notificacionAgenda == 1)//CORREO
                {
                  $arrayCorreoAgenda = array();
                  
                  $datos = array('critico'                => $agenda->critico,
                                 'fechaInicioAgenda'      => $agenda->fechaInicioAgenda,
                                 'asuntoAgenda'           => $agenda->asuntoAgenda,
                                 'vigenciaRadicado'       => $agenda->vigenciaRadicado,
                                 'idRadicado'             => $agenda->idRadicado,
                                 'nombreTipoProceso'      => $agenda->nombreTipoProceso,
                                 'nombreMedioControl'     => $agenda->nombreMedioControl,
                                 'nombreTema'             => $agenda->nombreTema,
                                 'nombreJuzgado'          => $agenda->nombreJuzgado);

                  array_push($arrayCorreoAgenda, $datos);


                  if (count($arrayCorreoAgenda) > 0 && $responsable->emailUsuario !='' && Util::valid_email_address($responsable->emailUsuario))//CORREO
                  {
                    Util::guardarEmail($responsable->emailUsuario, $agenda->vigenciaRadicado."-".$agenda->idRadicado, 3);// proyecto 3 jurídica
                    
                    $data = array('agendas'       => $arrayCorreoAgenda,
                                  'nombreUsuario' => $responsable->nombresUsuario,
                                  'diaAgenda'     => $diaHoy);

                    Mail::to($responsable->emailUsuario, 'xxxxx')
                        ->queue(new NotificacionAntesAgenda($data));
                  }
                }
                if($agenda->notificacionAgenda == 2)//SMS
                {
                  if($responsable->celularUsuario !='')
                  {
                    $expresion = '/^[3][0-9]{9}+$/';
                    if(preg_match($expresion, $responsable->celularUsuario))
                    {
                      $nombreUsu = explode(" ", $responsable->nombresUsuario);
                      if($agenda->radicadoJuzgado != '')
                      {
                        $radJuzgado = $agenda->radicadoJuzgado;
                      }
                      else
                      {
                        $radJuzgado = ""; 
                      }
                      $fecha = Util::formatearFecha(date_format(date_create($agenda->fechaInicioAgenda), 'Y-m-d'));
                      $hora = date_format(date_create($agenda->fechaInicioAgenda), 'h:i A');                          
                      $fechaSms = $fecha." a las ".$hora;

                      $mensaje = "Hola ".$nombreUsu[0].", Recuerde la agenda del proceso interno ".$agenda->vigenciaRadicado."-".$agenda->idRadicado." Para el día ".$fechaSms.", Radicado Juzgado: ".$radJuzgado;

                      $resp = Util::enviarSms($responsable->celularUsuario, $mensaje);
                    }
                  }
                }
              }
            }
          }
        }
      }
    }
}
