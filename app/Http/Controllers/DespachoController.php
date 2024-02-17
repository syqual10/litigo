<?php
namespace SQ10\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Session;
use SQ10\Models\Usuario;
use SQ10\Models\Responsable;
use SQ10\helpers\Util as Util;
use Barryvdh\DomPDF\Facade as PDF;

class DespachoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function actionIndexDespacho()
    {
        return view('despacho/index');
    }

    public function actionDespachos(Request $request)
    {
        $fechaDespacho        = $request->input('fechaDespachado');
        $arrayDespachados     = array();
        $despachos            = [];
        $despachosActuaciones = [];

        if($request->input('selectTipoDespacho') == 1)// despachos de repartos
        {
            $despachos = DB::table('juriradicados')
                        ->join('juriestadosetapas', function ($join) {
                            $join->on('juriradicados.vigenciaRadicado', '=', 'juriestadosetapas.juriradicados_vigenciaRadicado')
                            ->on('juriradicados.idRadicado', '=', 'juriestadosetapas.juriradicados_idRadicado');
                        })
                        ->join('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                        ->leftJoin('jurijuzgados', 'juriradicados.jurijuzgados_idJuzgado', '=', 'jurijuzgados.idJuzgado')
                        ->where('juritiposestados_idTipoEstado', '=', 3)//actuaciones
                        ->whereDate('fechaInicioEstado', '=', $fechaDespacho)
                        ->get();
        }

        if($request->input('selectTipoDespacho') == 2)// despachos de actuaciones
        {
            $despachosActuaciones = DB::table('juriradicados')
                            ->join('juriactuaciones', function ($join) {
                                $join->on('juriradicados.vigenciaRadicado', '=', 'juriactuaciones.juriradicados_vigenciaRadicado')
                                ->on('juriradicados.idRadicado', '=', 'juriactuaciones.juriradicados_idRadicado');
                            })
                            ->join('juriactuacionesresponsables', 'juriactuaciones.idActuacion', '=', 'juriactuacionesresponsables.juriactuaciones_idActuacion')
                            ->join('juriresponsables', 'juriactuacionesresponsables.juriresponsables_idResponsable_apoderado', '=', 'juriresponsables.idResponsable')
                            ->join('usuarios', 'juriresponsables.usuarios_idUsuario', '=', 'usuarios.idUsuario')
                            ->join('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                            ->leftJoin('jurijuzgados', 'juriradicados.jurijuzgados_idJuzgado', '=', 'jurijuzgados.idJuzgado')
                            ->whereDate('fechaRegistro', '=', $fechaDespacho)
                            ->get();
        }

        if(count($despachos) > 0)
        {
            foreach ($despachos as $despacho)
            {
                $datos = array('vigenciaRadicado'   => $despacho->juriradicados_vigenciaRadicado,
                               'idRadicado'         => $despacho->juriradicados_idRadicado,
                               'radicadoJuzgado'    => $despacho->radicadoJuzgado,
                               'nombreTipoProceso'  => $despacho->nombreTipoProceso,
                               'fechaNotificacion'  => $despacho->fechaNotificacion,
                               'idTipoProceso'      => $despacho->juritipoprocesos_idTipoProceso,
                               'nombreJuzgado'      => $despacho->nombreJuzgado,
                               'idEstadoEtapa'      => $despacho->idEstadoEtapa,
                               'idResponsable'      => 0,
                               'idActuacion'        => 0,
                               'idActuacionResponsable'        => 0);

                array_push($arrayDespachados, $datos);
            }
        }

        if(count($despachosActuaciones) > 0)
        {
            foreach ($despachosActuaciones as $despachoActuacion)
            {
                $datos2 = array('vigenciaRadicado'   => $despachoActuacion->juriradicados_vigenciaRadicado,
                               'idRadicado'         => $despachoActuacion->juriradicados_idRadicado,
                               'radicadoJuzgado'    => $despachoActuacion->radicadoJuzgado,
                               'nombreTipoProceso'  => $despachoActuacion->nombreTipoProceso,
                               'fechaNotificacion'  => $despachoActuacion->fechaNotificacion,
                               'idTipoProceso'      => $despachoActuacion->juritipoprocesos_idTipoProceso,
                               'nombreJuzgado'      => $despachoActuacion->nombreJuzgado,
                               'idEstadoEtapa'      => 0,
                               'idUsuario'          => $despachoActuacion->idUsuario,
                               'idActuacion'        => $despachoActuacion->idActuacion,
                               'idActuacionResponsable'        => $despachoActuacion->idActuacionResponsable);

                array_push($arrayDespachados, $datos2);
            }
        }

        return view('ajax_despachos.ajaxBandejaDespachos')
                        ->with('despachos', $arrayDespachados)
                        ->with('fechaDespacho', $fechaDespacho)
                        ->with('selectTipoDespacho', $request->input('selectTipoDespacho'));
    }

    public function actionPdf($fechaDespachado, $seleccionados, $seleccionadosIDS)
    {
        $idUsuario = Session::get('idUsuario');
        $usuario   = Usuario::find($idUsuario);

        $numeros = json_decode($seleccionados, true);       
        $numerosIDS = json_decode($seleccionadosIDS, true);       
        //-----------------------------------------------------------------     
        $cant = count($numeros);

        //Recorre el array -------------------------------------------
        if($cant > 0)
        {
            $anexosDespacho = array();
            
            for($i = 0; $i < $cant; $i++)
            {    
                $reparto = 1;  
                $anexo = DB::table('juriradicados')
                                ->join('juriestadosetapas', function ($join) {
                                    $join->on('juriradicados.vigenciaRadicado', '=', 'juriestadosetapas.juriradicados_vigenciaRadicado')
                                    ->on('juriradicados.idRadicado', '=', 'juriestadosetapas.juriradicados_idRadicado');
                                })
                                ->join('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                                ->leftJoin('jurijuzgados', 'juriradicados.jurijuzgados_idJuzgado', '=', 'jurijuzgados.idJuzgado')
                                ->where('idEstadoEtapa', '=', $numeros[$i])
                                ->get();


                if(count($anexo) == 0)//si el registro no está en estados etapas, que busque por actuaciones
                {
                    $reparto = 0;

                    $anexo = DB::table('juriradicados')
                                ->join('juriactuaciones', function ($join) {
                                    $join->on('juriradicados.vigenciaRadicado', '=', 'juriactuaciones.juriradicados_vigenciaRadicado')
                                    ->on('juriradicados.idRadicado', '=', 'juriactuaciones.juriradicados_idRadicado');
                                })
                                ->join('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                                ->leftJoin('jurijuzgados', 'juriradicados.jurijuzgados_idJuzgado', '=', 'jurijuzgados.idJuzgado')
                                ->where('idActuacion', '=', $numeros[$i])
                                ->get();

                    $responsable = DB::table('juriactuacionesresponsables')
                                ->join('juriresponsables', 'juriactuacionesresponsables.juriresponsables_idResponsable_apoderado', '=', 'juriresponsables.idResponsable')
                                ->join('usuarios', 'juriresponsables.usuarios_idUsuario', '=', 'usuarios.idUsuario')
                                ->where('idActuacionResponsable', '=', $numerosIDS[$i])
                                ->get();
                }

                $vigenciaRadicado = $anexo[0]->juriradicados_vigenciaRadicado;
                $idRadicado       = $anexo[0]->juriradicados_idRadicado;

                if($reparto == 1)
                {
                    $usuarioRadicado = Util::ultimoUsuarioRadicado($anexo[0]->idEstadoEtapa);
                    $comentarioActuacion = "";
                    $nombresUsuario = "";
                }
                else
                {
                    $usuarioRadicado = $responsable[0]->nombresUsuario;
                    $comentarioActuacion = $anexo[0]->comentarioActuacion;
                }

                $anexosDespacho[$i] =   array('radicado'      
                                                              => $vigenciaRadicado."-".$idRadicado, 
                                            'radicadoJuzgado' => $anexo[0]->radicadoJuzgado,
                                            'tipoProceso'     => $anexo[0]->nombreTipoProceso,
                                            'fechaNotifi'     
                                                              => ucfirst(utf8_encode(strftime("%A %d de %B de %Y", strtotime($anexo[0]->fechaNotificacion)))),
                                            'remitente'       
                                                              =>  Util::personaDemandante($vigenciaRadicado, $idRadicado, $anexo[0]->juritipoprocesos_idTipoProceso)."-"
                                                                  .$anexo[0]->nombreJuzgado,
                                            'destinatario'    
                                                              => $usuarioRadicado,
                                            'reparto'         => $reparto,
                                            'observacion'     => $comentarioActuacion
                                        );
            }  
        }  

        $fechaDes = ucfirst(utf8_encode(strftime("%A %d de %B de %Y", strtotime($fechaDespachado))));

        $pdf = PDF::loadView('despacho/pdfDespacho', array('anexosDespacho' => $anexosDespacho, 'usuario' => $usuario, 'fechaDes' => $fechaDes))->setPaper('a4', 'landscape');
        return $pdf->stream('Despachos '.$fechaDes.'.pdf');

    }
}