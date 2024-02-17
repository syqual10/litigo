<?php

namespace SQ10\Console\Commands;

use SQ10\helpers\Util as Util;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use SQ10\Mail\NotificacionAgendaJuri;
use DB;

class RecordarAgenda extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recordar:agenda';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envía recordatorio con las agendas diarias a los usuarios del sistema';

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
        $diaHoy = date ( 'Y-m-d');

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
                                ->where(DB::raw('substr(juriagendas.fechaInicioAgenda, -19, 10)'), '=', $diaHoy)
                                ->where('juriagendas.juriresponsables_idResponsable', '=', $responsable->idResponsable)
                                ->orderBy('fechaInicioAgenda', 'asc')
                                ->get();

                if(count($agendas) > 0)
                {
                    if ($responsable->emailUsuario !='' && Util::valid_email_address($responsable->emailUsuario) && $responsable->notifiCorreo == 1)
                    {
                      foreach ($agendas as $agenda) 
                      {
                        Util::guardarEmail($responsable->emailUsuario, $agenda->vigenciaRadicado."-".$agenda->idRadicado, 3);// proyecto 3 jurídica
                      }

                      $data = array('diaAgenda'           => $diaHoy, 
                                    'agendas'             => $agendas,
                                    'nombreUsuario'       => $responsable->nombresUsuario,
                                  );

                      Mail::to($responsable->emailUsuario, 'xxxxx')
                          ->queue(new NotificacionAgendaJuri($data));
                    }

                    foreach ($agendas as $agenda) 
                    {
                        $usuariosNotificados = DB::table('juriusuariosnotificar')
                                                ->join('usuarios', 'juriusuariosnotificar.usuarios_idUsuario', '=', 'usuarios.idUsuario')
                                                ->where('juriagendas_Id', '=', $agenda->Id)
                                                ->get();

                        if(count($usuariosNotificados) > 0)
                        {
                            foreach ($usuariosNotificados as $usuarioNotificar) 
                            {
                                $datosNotificar = DB::table('juriagendas')
                                                ->leftJoin('juriradicados', function ($leftJoin) {
                                                  $leftJoin->on('juriagendas.juriradicados_vigenciaRadicado', '=', 'juriradicados.vigenciaRadicado')
                                                  ->on('juriagendas.juriradicados_idRadicado', '=', 'juriradicados.idRadicado');
                                                })
                                                ->leftJoin('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                                                ->leftJoin('jurimedioscontrol', 'juriradicados.jurimedioscontrol_idMediosControl', '=', 'jurimedioscontrol.idMediosControl')
                                                ->leftJoin('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
                                                ->leftJoin('jurijuzgados', 'juriradicados.jurijuzgados_idJuzgado', '=', 'jurijuzgados.idJuzgado')
                                                ->where('juriagendas.Id', '=', $agenda->Id)
                                                ->get();

                                if ($usuarioNotificar->emailUsuario !='' && Util::valid_email_address($usuarioNotificar->emailUsuario))
                                {
                                  Util::guardarEmail($usuarioNotificar->emailUsuario, $agenda->vigenciaRadicado."-".$agenda->idRadicado, 3);// proyecto 3 jurídica
                                  
                                  $data = array('diaAgenda'           => $diaHoy, 
                                                'agendas'             => $datosNotificar,
                                                'nombreUsuario'       => $responsable->nombresUsuario,
                                  );

                                  Mail::to($usuarioNotificar->emailUsuario, 'xxxxx')
                                      ->queue(new NotificacionAgendaJuri($data));
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
