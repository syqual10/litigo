<?php
namespace SQ10\Http\Controllers;

use DB;
use Excel;
use Illuminate\Http\Request;
use Session;
use SQ10\Models\Entidad;
use SQ10\Models\Usuario;
use SQ10\Models\Responsable;
use SQ10\helpers\Util as Util;

class BuzonController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function actionIndexBuzon()
    {
        $idUsuario = Session::get('idUsuario');
        $idResponsable = Util::idsResponsableBuzon($idUsuario);

        $cantidadBuzon = DB::table('juriestadosetapas')
                            ->whereIn('juriresponsables_idResponsable', $idResponsable)
                            ->where('juritipoestadosetapas_idTipoEstadoEtapa', '=', 1)// tipo estado actual
                            ->where('leidoEstado', '=', 0)// no se ha leído
                            ->count();

        $cantidadUltimosLeidos = DB::table('juriestadosetapas')
                            ->whereIn('juriresponsables_idResponsable', $idResponsable)
                            ->where('leidoEstado', '=', 1)//no ha sido leído
                            ->where('juritipoestadosetapas_idTipoEstadoEtapa', '=', 1)// tipo estado actual
                            ->skip(0)
                            ->take(10)
                            ->orderBy('fechaLeidoEstado', 'desc')
                            ->get();

        $cantActuNoLeidos = DB::table('juriactuacionesresponsables')
                            ->join('juriactuaciones', 'juriactuacionesresponsables.juriactuaciones_idActuacion', '=', 'juriactuaciones.idActuacion')
                            ->whereIn('juriresponsables_idResponsable_apoderado', $idResponsable)
                            ->where('juriactuaciones.leido', '=', 1)//no ha sido leído
                            ->count();

        return view('buzon/index')
                ->with('cantidadBuzon', $cantidadBuzon)
                ->with('cantidadUltimosLeidos', count($cantidadUltimosLeidos))
                ->with('cantActuNoLeidos', $cantActuNoLeidos);
    }

    public function actionTrasladarMisProcesos(Request $request)
    {
        $idUsuario = Session::get('idUsuario');
        $idResponsable = Util::idsResponsableBuzon($idUsuario);

        DB::table('juriestadosetapas')
                    ->where('idEstadoEtapa', $request->input('idEstado'))
                    ->update([
                            'leidoEstado'      => 1,
                            'fechaLeidoEstado' => date("Y-m-d H:i:s")]);  


        $cantidadBuzon = DB::table('juriestadosetapas')
                            ->whereIn('juriresponsables_idResponsable', $idResponsable)
                            ->where('juritipoestadosetapas_idTipoEstadoEtapa', '=', 1)// tipo estado actual
                            ->where('leidoEstado', '=', 0)// no se ha leído
                            ->count();

        return $cantidadBuzon;
    }

    public function actionBuzonProcesos(Request $request)
    {
        $idUsuario = Session::get('idUsuario');
        $pagina = $request->input('pagina');
        $idResponsable = Util::idResponsable($idUsuario);
        
        if($pagina >= 1)
        {
            $inicio = $pagina*100;
        } 
        else
        {
            $inicio = 0;
        }

        $procesosBuzon = DB::table('juriestadosetapas')
                        ->select('vigenciaRadicado', 'idRadicado', 'nombreMedioControl', 'nombreAccion', 'nombreTema', 'leidoEstado', 'idEstadoEtapa', 'fechaInicioEstado', 'idTipoProcesos', 'nombreTipoProceso', 'nombreJuzgado', 'codigoProceso', 'juritiposestados_idTipoEstado', 'buzonEspecial')
                        ->join('juriradicados', function ($join) {
                            $join->on('juriestadosetapas.juriradicados_idRadicado', '=', 'juriradicados.idRadicado')
                                ->on('juriestadosetapas.juriradicados_vigenciaRadicado', '=', 'juriradicados.vigenciaRadicado');
                        })
                        ->join('juriresponsables', 'juriestadosetapas.juriresponsables_idResponsable', '=', 'juriresponsables.idResponsable')
                        ->join('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                        ->join('usuarios', 'juriresponsables.usuarios_idUsuario', '=', 'usuarios.idUsuario')
                        ->leftJoin('jurimedioscontrol', 'juriradicados.jurimedioscontrol_idMediosControl', '=', 'jurimedioscontrol.idMediosControl')
                        ->leftJoin('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
                        ->leftJoin('juriacciones', 'juriradicados.juriacciones_idAccion', '=', 'juriacciones.idAccion')
                        ->leftJoin('jurijuzgados', 'juriradicados.jurijuzgados_idJuzgado', '=', 'jurijuzgados.idJuzgado')
                        ->where('juriresponsables_idResponsable', $idResponsable)
                        //->where('leidoEstado', '=', 0)//no ha sido leído
                        ->where('juritipoestadosetapas_idTipoEstadoEtapa', '=', 1)// tipo estado actual
                        ->skip($inicio)
                        ->take(100)
                        ->orderBy('idEstadoEtapa', 'desc')
                        ->get();

        $vista =  view('ajax_buzon.ajaxBuzon')
                    ->with('procesosBuzon', json_decode($procesosBuzon, true))
                    ->render();

    
                                
        $cantidadBuzon = DB::table('juriestadosetapas')
                    ->where('juriresponsables_idResponsable', '=', $idResponsable)
                    ->where('juritipoestadosetapas_idTipoEstadoEtapa', '=', 1)// tipo estado actual
                    //->where('leidoEstado', '=', 0)// no se ha leído
                    ->count();
                
        $fin = $inicio == 0 ? 100 : ($pagina*100)+100;
        $ini = $inicio == 0 ? 1 : $pagina*100;
            

        return response()->json(['vista' => $vista, 'total' => $cantidadBuzon, 'cantidad' => $ini .' - '.$fin]);
    }



    public function actionUltimosLeidos()
    {
        $idUsuario = Session::get('idUsuario');
        $idsResponsables = Util::idsResponsableBuzon($idUsuario);

        $procesosBuzon = DB::table('juriestadosetapas')
                        ->select('vigenciaRadicado', 'idRadicado', 'nombreMedioControl', 'nombreAccion', 'nombreTema', 'idEstadoEtapa', 'fechaInicioEstado', 'idTipoProcesos', 'nombreTipoProceso', 'nombreJuzgado', 'codigoProceso', 'juritiposestados_idTipoEstado')
                        ->join('juriradicados', function ($join) {
                            $join->on('juriestadosetapas.juriradicados_idRadicado', '=', 'juriradicados.idRadicado')
                                ->on('juriestadosetapas.juriradicados_vigenciaRadicado', '=', 'juriradicados.vigenciaRadicado');
                        })
                        ->join('juriresponsables', 'juriestadosetapas.juriresponsables_idResponsable', '=', 'juriresponsables.idResponsable')
                        ->join('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                        ->join('usuarios', 'juriresponsables.usuarios_idUsuario', '=', 'usuarios.idUsuario')
                        ->leftJoin('jurimedioscontrol', 'juriradicados.jurimedioscontrol_idMediosControl', '=', 'jurimedioscontrol.idMediosControl')
                        ->leftJoin('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
                        ->leftJoin('juriacciones', 'juriradicados.juriacciones_idAccion', '=', 'juriacciones.idAccion')
                        ->leftJoin('jurijuzgados', 'juriradicados.jurijuzgados_idJuzgado', '=', 'jurijuzgados.idJuzgado')
                        ->whereIn('juriresponsables_idResponsable', $idsResponsables)
                        ->where('leidoEstado', '=', 1)//no ha sido leído
                        ->where('juritipoestadosetapas_idTipoEstadoEtapa', '=', 1)// tipo estado actual
                        ->skip(0)
                        ->take(10)
                        ->orderBy('fechaLeidoEstado', 'desc')
                        ->get();


        return view('ajax_buzon.ajaxBuzon')
                    ->with('procesosBuzon', json_decode($procesosBuzon, true)); 
    }

    public function actionBuzonActuaciones()
    {
        $idUsuario = Session::get('idUsuario');
        $idsResponsables = Util::idsResponsableBuzon($idUsuario);
        
        $procesosBuzon  = DB::table('juriactuacionesresponsables')
                            ->join('juriactuaciones', 'juriactuacionesresponsables.juriactuaciones_idActuacion', '=', 'juriactuaciones.idActuacion')
                            ->join('juriradicados', function ($join) {
                               $join->on('juriactuaciones.juriradicados_vigenciaRadicado', '=', 'juriradicados.vigenciaRadicado')
                               ->on('juriactuaciones.juriradicados_idRadicado', '=', 'juriradicados.idRadicado');
                            })
                            ->join('juriestadosetapas', function ($join) {
                                $join->on('juriradicados.vigenciaRadicado', '=', 'juriestadosetapas.juriradicados_vigenciaRadicado')
                                ->on('juriradicados.idRadicado', '=', 'juriestadosetapas.juriradicados_idRadicado');
                             })

                            ->join('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                            ->leftJoin('juritiposactuaciones', 'juriactuaciones.juritiposactuaciones_idTipoActuacion', '=', 'juritiposactuaciones.idTipoActuacion')
                            ->leftJoin('jurimedioscontrol', 'juriradicados.jurimedioscontrol_idMediosControl', '=', 'jurimedioscontrol.idMediosControl')
                            ->whereIn('juriresponsables_idResponsable_apoderado', $idsResponsables)
                            ->where('juriactuaciones.leido', '=', 1)//no ha sido leído
                            ->groupBY('juriactuaciones.idActuacion')
                             ->orderBy('juriactuaciones.fechaActuacion', 'desc')
                            ->get();

        return view('ajax_buzon.ajaxBuzonActuaciones')
                    ->with('procesosBuzon', json_decode($procesosBuzon, true));
    }

    public function actionRemoverActuacionBuzon(Request $request)
    {
        $idUsuario = Session::get('idUsuario');
        $idResponsable = Util::idsResponsableBuzon($idUsuario);

        DB::table('juriactuaciones')
                    ->where('idActuacion', $request->input('idActuacion'))
                    ->update([
                            'leido' => 0]);

        $cantActuNoLeidos = DB::table('juriactuacionesresponsables')
                            ->join('juriactuaciones', 'juriactuacionesresponsables.juriactuaciones_idActuacion', '=', 'juriactuaciones.idActuacion')
                            ->whereIn('juriresponsables_idResponsable_apoderado', $idResponsable)
                            ->where('juriactuaciones.leido', '=', 1)//no ha sido leído
                            ->count();

        return $cantActuNoLeidos;
    }

    /* LA FUNCIÓN QUE TRAE LOS ANTERIORES 30 O ANTERIORES 30 PROCESOS DEL BUZÓN */
    public function actionBuzonSiguAnte(Request $request)
    {
        $idUsuario = Session::get('idUsuario');
        $pagina = $request->input('pagina');
        $idResponsable = Util::idResponsable($idUsuario);
        $responsable = Responsable::find($idResponsable);
        
        if($pagina >= 1){
            $inicio = $pagina*30;
        } else{
            $inicio = 0;
        }

            $procesosBuzon = DB::table('juriestadosetapas')
                            ->select('vigenciaRadicado', 'idRadicado', 'nombreMedioControl', 'nombreAccion', 'nombreTema', 'idEstadoEtapa', 'fechaInicioEstado', 'nombreTipoProceso')
                            ->join('juriradicados', function ($join) {
                                $join->on('juriestadosetapas.juriradicados_idRadicado', '=', 'juriradicados.idRadicado')
                                    ->on('juriestadosetapas.juriradicados_vigenciaRadicado', '=', 'juriradicados.vigenciaRadicado');
                            })
                            ->join('juriresponsables', 'juriestadosetapas.juriresponsables_idResponsable', '=', 'juriresponsables.idResponsable')
                            ->join('usuarios', 'juriresponsables.usuarios_idUsuario', '=', 'usuarios.idUsuario')
                            ->join('jurimedioscontrol', 'juriradicados.jurimedioscontrol_idMediosControl', '=', 'jurimedioscontrol.idMediosControl')
                            ->join('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                            ->join('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
                            ->join('juriacciones', 'juriradicados.juriacciones_idAccion', '=', 'juriacciones.idAccion')
                            ->where('juriresponsables_idResponsable', '=', $idResponsable)
                            //->where('leidoEstado', '=', 0)//no ha sido leído
                            ->where('juritipoestadosetapas_idTipoEstadoEtapa', '=', 1)// tipo estado actual
                            ->skip($inicio)
                            ->take(30)
                            ->orderBy('idEstadoEtapa', 'asc')
                            ->get();
      

       
            return view('ajax_buzon.ajaxBuzon')
                    ->with('procesosBuzon', json_decode($procesosBuzon, true))
                    ->with('responsable',   $responsable);
    }

    public function actionCantidadBuzon(Request $request)
    {
        $idUsuario = Session::get('idUsuario');
        $idResponsable = Util::idResponsable($idUsuario);
                
        $cantidadBuzon = DB::table('juriestadosetapas')
                    ->where('juriresponsables_idResponsable', '=', $idResponsable)
                    ->where('juritipoestadosetapas_idTipoEstadoEtapa', '=', 1)// tipo estado actual
                    ->where('leidoEstado', '=', 0)// no se ha leído
                    ->count();

        return $cantidadBuzon;
    }

    public function actionMisReportes(Request $request)
    {
        return view('ajax_buzon.ajaxMisReportes')
                        ->with('tipoReporte',   $request->input('tipoReporte'));
    }

    public function actionValidarMisReportes(Request $request)
    {
        $idUsuario = Session::get('idUsuario');
        $idResponsable = Util::idResponsable($idUsuario);

        $fechaInicial = str_replace("/","-",$request->input('fechaInicial'));
        $fechaFinal = str_replace("/","-",$request->input('fechaFinal'));

        if($request->input('tipoReporte') == 1)//terminados
        {
            $reportes = DB::table('juriradicados')
                    ->select('idRadicado', 'vigenciaRadicado', 'fechaRadicado', 'nombreMedioControl', 'codigoProceso' ,'fechaNotificacion' ,'nombreJuzgado', 'nombreTipoProceso')
                    ->join('juriestadosetapas', function ($join) {
                        $join->on('juriradicados.vigenciaRadicado', '=', 'juriestadosetapas.juriradicados_vigenciaRadicado')
                        ->on('juriradicados.idRadicado', '=', 'juriestadosetapas.juriradicados_idRadicado');
                    })
                    ->join('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                    ->join('jurimedioscontrol', 'juriradicados.jurimedioscontrol_idMediosControl', '=', 'jurimedioscontrol.idMediosControl')
                    ->leftJoin('jurijuzgados', 'juriradicados.jurijuzgados_idJuzgado', '=', 'jurijuzgados.idJuzgado')
                    ->whereBetween(DB::raw('substr(fechaRadicado, -19, 10)'),
                    array($fechaInicial, $fechaFinal))
                    ->where('juriestadosetapas.juriresponsables_idResponsable', '=', $idResponsable)
                    ->where('juriestadosradicados_idEstadoRadicado', '=', 2)//terminados
                    ->groupBY('juriestadosetapas.juriradicados_idRadicado')
                    ->groupBY('juriestadosetapas.juriradicados_vigenciaRadicado')
                    ->get();
        }
        else if($request->input('tipoReporte') == 2)//enviados
        {
            $reportes = DB::table('juriradicados')
                    ->select('idRadicado', 'vigenciaRadicado', 'fechaRadicado', 'nombreMedioControl', 'codigoProceso' ,'fechaNotificacion' ,'nombreJuzgado', 'nombreTipoProceso')
                    ->join('juriestadosetapas', function ($join) {
                        $join->on('juriradicados.vigenciaRadicado', '=', 'juriestadosetapas.juriradicados_vigenciaRadicado')
                        ->on('juriradicados.idRadicado', '=', 'juriestadosetapas.juriradicados_idRadicado');
                    })
                    ->join('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                    ->join('jurimedioscontrol', 'juriradicados.jurimedioscontrol_idMediosControl', '=', 'jurimedioscontrol.idMediosControl')
                    ->leftJoin('jurijuzgados', 'juriradicados.jurijuzgados_idJuzgado', '=', 'jurijuzgados.idJuzgado')
                    ->whereBetween(DB::raw('substr(fechaRadicado, -19, 10)'),
                    array($fechaInicial, $fechaFinal))
                    ->where('juriresponsables_idResponsable', '=', $idResponsable)
                    ->where('juriestadosradicados_idEstadoRadicado', '=', 1)//radicado pendiente
                    ->where('juritipoestadosetapas_idTipoEstadoEtapa', '=', 2)//en mi bandeja gestionado
                    ->groupBY('juriestadosetapas.juriradicados_idRadicado')
                    ->groupBY('juriestadosetapas.juriradicados_vigenciaRadicado')
                    ->get();
        }
        else if($request->input('tipoReporte') == 3)//cancelados
        {
            $reportes = DB::table('juriradicados')
                    ->select('idRadicado', 'vigenciaRadicado', 'fechaRadicado', 'nombreMedioControl', 'codigoProceso' ,'fechaNotificacion' ,'nombreJuzgado', 'nombreTipoProceso')
                    ->join('juriestadosetapas', function ($join) {
                        $join->on('juriradicados.vigenciaRadicado', '=', 'juriestadosetapas.juriradicados_vigenciaRadicado')
                        ->on('juriradicados.idRadicado', '=', 'juriestadosetapas.juriradicados_idRadicado');
                    })
                    ->join('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                    ->join('jurimedioscontrol', 'juriradicados.jurimedioscontrol_idMediosControl', '=', 'jurimedioscontrol.idMediosControl')
                    ->leftJoin('jurijuzgados', 'juriradicados.jurijuzgados_idJuzgado', '=', 'jurijuzgados.idJuzgado')
                    ->whereBetween(DB::raw('substr(fechaRadicado, -19, 10)'),
                    array($fechaInicial, $fechaFinal))
                    ->where('juriresponsables_idResponsable', '=', $idResponsable)
                    ->where('juriestadosradicados_idEstadoRadicado', '=', 3)//radicado cancelado
                    ->groupBY('juriestadosetapas.juriradicados_idRadicado')
                    ->groupBY('juriestadosetapas.juriradicados_vigenciaRadicado')
                    ->get();
        }

        return view('ajax_buzon.ajaxTablaMisReportes')
                    ->with('reportes',   $reportes)
                    ->with('fechaInicialSeleccionada',   $fechaInicial)
                    ->with('fechaFinalSeleccionada',   $fechaFinal);
    }

    public function actionMiReporteExcel($vector)
    {
        $idUsuario = Session::get('idUsuario');
        $idResponsable = Util::idResponsable($idUsuario);

        $datos = json_decode($vector, true);
        $titulo = "Reporte Jurídica";

        $fechaInicial = $datos['fechaInicial'];
        $fechaFinal = $datos['fechaFinal'];
        $tipoReporte = $datos['tipoReporte'];

        Excel::create($titulo, function($excel) use ($titulo, $fechaInicial,$fechaFinal,$tipoReporte, $idResponsable) {
        //Busca la entidad

        $entidad = Entidad::find(1);
        // Set the title
        if($tipoReporte == 1)//terminados
        {
            $excel->setTitle('Terminados');
        }
        else if($tipoReporte == 2)//enviados
        {
            $excel->setTitle('Enviados');
        }
        else if($tipoReporte == 3)//cancelados
        {
            $excel->setTitle('Cancelados');
        }
        else
        {
            $excel->setTitle('Reporte Jurídica');
        }
        // Chain the setters
        $excel->setCreator('SyQual 10');
        $excel->setCompany('SyQual 10 S.A.S');

        // Call them separately
        if($tipoReporte == 1)
        {
            $excel->setDescription('Terminados - '.$entidad->nombreEntidad);
        }
        else if($tipoReporte == 2)
        {
            $excel->setDescription('Enviados - '.$entidad->nombreEntidad);
        }
        else if($tipoReporte == 3)
        {
            $excel->setDescription('Cancelados - '.$entidad->nombreEntidad);
        }
        else
        {
            $excel->setDescription('Reporte Jurídica - '.$entidad->nombreEntidad);
        }

        $excel->sheet('Reporte rango fechas', function($sheet) use ($titulo, $entidad,$fechaInicial,$fechaFinal,$tipoReporte, $idResponsable){

        if($tipoReporte == 1)//terminados
        {
            $reportes = DB::table('juriradicados')
                    ->select('idRadicado', 'vigenciaRadicado', 'fechaRadicado', 'nombreMedioControl', 'codigoProceso' ,'fechaNotificacion' ,'nombreJuzgado', 'nombreTipoProceso')
                    ->join('juriestadosetapas', function ($join) {
                        $join->on('juriradicados.vigenciaRadicado', '=', 'juriestadosetapas.juriradicados_vigenciaRadicado')
                        ->on('juriradicados.idRadicado', '=', 'juriestadosetapas.juriradicados_idRadicado');
                    })
                    ->join('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                    ->join('jurimedioscontrol', 'juriradicados.jurimedioscontrol_idMediosControl', '=', 'jurimedioscontrol.idMediosControl')
                    ->leftJoin('jurijuzgados', 'juriradicados.jurijuzgados_idJuzgado', '=', 'jurijuzgados.idJuzgado')
                    ->whereBetween(DB::raw('substr(fechaRadicado, -19, 10)'),
                    array($fechaInicial, $fechaFinal))
                    ->where('juriestadosetapas.juriresponsables_idResponsable', '=', $idResponsable)
                    ->where('juriestadosradicados_idEstadoRadicado', '=', 2)//terminados
                    ->groupBY('juriestadosetapas.juriradicados_idRadicado')
                    ->groupBY('juriestadosetapas.juriradicados_vigenciaRadicado')
                    ->get();
        }
        else if($tipoReporte == 2)//enviados
        {
            $reportes = DB::table('juriradicados')
                    ->select('idRadicado', 'vigenciaRadicado', 'fechaRadicado', 'nombreMedioControl', 'codigoProceso' ,'fechaNotificacion' ,'nombreJuzgado', 'nombreTipoProceso')
                    ->join('juriestadosetapas', function ($join) {
                        $join->on('juriradicados.vigenciaRadicado', '=', 'juriestadosetapas.juriradicados_vigenciaRadicado')
                        ->on('juriradicados.idRadicado', '=', 'juriestadosetapas.juriradicados_idRadicado');
                    })
                    ->join('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                    ->join('jurimedioscontrol', 'juriradicados.jurimedioscontrol_idMediosControl', '=', 'jurimedioscontrol.idMediosControl')
                    ->leftJoin('jurijuzgados', 'juriradicados.jurijuzgados_idJuzgado', '=', 'jurijuzgados.idJuzgado')
                    ->whereBetween(DB::raw('substr(fechaRadicado, -19, 10)'),
                    array($fechaInicial, $fechaFinal))
                    ->where('juriresponsables_idResponsable', '=', $idResponsable)
                    ->where('juriestadosradicados_idEstadoRadicado', '=', 1)//radicado pendiente
                    ->where('juritipoestadosetapas_idTipoEstadoEtapa', '=', 2)//en mi bandeja gestionado
                    ->groupBY('juriestadosetapas.juriradicados_idRadicado')
                    ->groupBY('juriestadosetapas.juriradicados_vigenciaRadicado')
                    ->get();
        }
        else if($tipoReporte == 3)//cancelados
        {
            $reportes = DB::table('juriradicados')
                    ->select('idRadicado', 'vigenciaRadicado', 'fechaRadicado', 'nombreMedioControl', 'codigoProceso' ,'fechaNotificacion' ,'nombreJuzgado', 'nombreTipoProceso')
                    ->join('juriestadosetapas', function ($join) {
                        $join->on('juriradicados.vigenciaRadicado', '=', 'juriestadosetapas.juriradicados_vigenciaRadicado')
                        ->on('juriradicados.idRadicado', '=', 'juriestadosetapas.juriradicados_idRadicado');
                    })
                    ->join('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                    ->join('jurimedioscontrol', 'juriradicados.jurimedioscontrol_idMediosControl', '=', 'jurimedioscontrol.idMediosControl')
                    ->leftJoin('jurijuzgados', 'juriradicados.jurijuzgados_idJuzgado', '=', 'jurijuzgados.idJuzgado')
                    ->whereBetween(DB::raw('substr(fechaRadicado, -19, 10)'),
                    array($fechaInicial, $fechaFinal))
                    ->where('juriresponsables_idResponsable', '=', $idResponsable)
                    ->where('juriestadosradicados_idEstadoRadicado', '=', 3)//radicado cancelado
                    ->groupBY('juriestadosetapas.juriradicados_idRadicado')
                    ->groupBY('juriestadosetapas.juriradicados_vigenciaRadicado')
                    ->get();
        }

            $sheet->mergeCells('C1:E1');
            $sheet->mergeCells('C2:E2');
            $sheet->mergeCells('C3:E3');

            $sheet->cells('C1:E3', function($cells)
            {
                $cells->setAlignment('center');
            });

            $sheet->fromArray(array(
                array($entidad->nombreEntidad, ''),
                array($titulo, '')), null, 'C1', false, false);
            $sheet->loadView('buzon.excelMisReportes')
                            ->with('reportes', $reportes)
                            ->with('fechaReporte', date('Y-m-d'));
        });

        })->export('xls');
    }
}