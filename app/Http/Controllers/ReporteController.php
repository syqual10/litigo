<?php
namespace SQ10\Http\Controllers;

use DB;
use Excel;
use Illuminate\Http\Request;
use Session;
use SQ10\Models\Usuario;
use SQ10\Models\Entidad;
use SQ10\helpers\Util as Util;

class ReporteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function actionIndexReportes($reporte)
    {
        $listaTipoMediosControl  = [];
        $listaAcciones           = [];
        $listaUsuarios           = [];
        $listaEstadosRadicados   = [];
        $listaProcesos           = [];
        $listaAbogadosApoderados = [];
        $listaJuzgados           = [];
        $listaSecretarias        = [];
        $listaTipoActuaciones    = [];

        if($reporte == 1)
        {
            $listaTipoMediosControl = DB::table('jurimedioscontrol')
                ->orderBy('idMediosControl', 'asc')
                ->pluck('nombreMedioControl', 'idMediosControl');

            $titulo = "Medios de control";
        }

        if($reporte == 2)
        {
            $listaAcciones = DB::table('juriacciones')
                ->orderBy('idAccion', 'asc')
                ->pluck('nombreAccion', 'idAccion');

            $titulo = "Acciones";
        }

        if($reporte == 3)
        {
            $listaUsuarios = DB::table('juriresponsables')
                ->join('usuarios', 'juriresponsables.usuarios_idUsuario', '=', 'usuarios.idUsuario')
                ->orderBy('idUsuario', 'asc')
                ->pluck('nombresUsuario', 'idUsuario');

            $titulo = "Funcionarios";
        }

        if($reporte == 4)
        {
            $listaEstadosRadicados = DB::table('juriestadosradicados')
                ->orderBy('idEstadoRadicado', 'asc')
                ->pluck('nombreEstadoRadicado', 'idEstadoRadicado');

            $listaProcesos = DB::table('juritipoprocesos')
                ->orderBy('idTipoProcesos', 'asc')
                ->pluck('nombreTipoProceso', 'idTipoProcesos');

            $titulo = "Estados Radicados";
        }

        if($reporte == 5)
        {
            $listaAbogadosApoderados = DB::table('juriabogados')
                ->orderBy('idAbogado', 'asc')
                ->pluck('nombreAbogado', 'idAbogado');

            $titulo = "Abogados demandantes";
        }

        if($reporte == 6)
        {
            $titulo = "Demandantes";
        }

        if($reporte == 7)
        {
            $listaJuzgados = DB::table('jurijuzgados')
                ->orderBy('idJuzgado', 'asc')
                ->pluck('nombreJuzgado', 'idJuzgado');

            $titulo = "Juzgados";
        }

        if($reporte == 8)
        {
            $listaSecretarias = DB::table('dependencias')
                ->orderBy('idDependencia', 'asc')
                ->pluck('nombreDependencia', 'idDependencia');

            $titulo = "Secretarías";
        }

        if($reporte == 9)
        {
            $listaTipoActuaciones = DB::table('juritiposactuaciones')
                ->orderBy('idTipoActuacion', 'asc')
                ->pluck('nombreActuacion', 'idTipoActuacion');

            $titulo = "Tipos de actuaciones";
        }

        if($reporte == 10)
        {
            $titulo = "Valoraciones del fallo";
        }


        if($reporte == 11)
        {
            $titulo = "Temas";
        }

        if($reporte == 12)
        {
            $listaTipoActuaciones = DB::table('juritiposactuaciones')
                ->orderBy('idTipoActuacion', 'asc')
                ->whereIn('idTipoActuacion',[44, 48])
                ->pluck('nombreActuacion', 'idTipoActuacion');

            $listaProcesos = DB::table('juritipoprocesos')
                ->orderBy('idTipoProcesos', 'asc')
                ->pluck('nombreTipoProceso', 'idTipoProcesos');

            $titulo = "Fallos instancias";
        }

        if($reporte == 13)
        {
            $titulo = "Terminados";
        }

        if($reporte == 14)
        {
            $titulo = "Asuntos";
        }

        return view('reportes/index')
                ->with('titulo', $titulo)
                ->with('reporte', $reporte)
                ->with('listaTipoMediosControl', $listaTipoMediosControl)
                ->with('listaAcciones', $listaAcciones)
                ->with('listaUsuarios', $listaUsuarios)
                ->with('listaEstadosRadicados', $listaEstadosRadicados)
                ->with('listaAbogadosApoderados', $listaAbogadosApoderados)
                ->with('listaJuzgados', $listaJuzgados)
                ->with('listaSecretarias', $listaSecretarias)
                ->with('listaTipoActuaciones', $listaTipoActuaciones)
                ->with('listaProcesos', $listaProcesos);
    }

    public function actionReporteTablaOLD(Request $request)
    {

        $fechaInicial = str_replace("/","-",$request->input('fechaInicial'));
        $fechaFinal = str_replace("/","-",$request->input('fechaFinal'));
        $tipoReporte = $request->input('reporte');

        /* TIPO PROCESO  REPORTE 1 Medios de control*/
        $ingresadasEne  = 0;
        $ingresadasFeb  = 0;
        $ingresadasMar  = 0;
        $ingresadasAbr  = 0;
        $ingresadasMay  = 0;
        $ingresadasJun  = 0;
        $ingresadasJul  = 0;
        $ingresadasAgo  = 0;
        $ingresadasSep  = 0;
        $ingresadasOct  = 0;
        $ingresadasNov  = 0;
        $ingresadasDic  = 0;
        $totalMediosControl = 0;
        /* TIPO PROCESO  REPORTE 1 Medios de control*/

        /* ACCIONES 2*/
        $acciones  = [];
        /* ACCIONES 2*/

        /* Usuarios 3*/
        $usuarios  = [];
        /* Usuarios 3*/

        /* Estados Radicados 4*/
        $estadoRadicados  = [];
        /* Estados Radicados 4*/

        /* Abogados demandantes 5*/
        $abogadosDemandantes  = [];
        /* Abogados demandantes 5*/

        /* Solicitantes 6*/
        $solicitantes  = [];
        /* Solicitantes 6*/

        /* Juzgados 7*/
        $juzgados  = [];
        /* Juzgados 7*/

        /* Secretarías 8*/
        $secretarias  = [];
        /* Secretarías 8*/

        /* tiposActuacion 9*/
        $tiposActuacion  = [];
        /* tiposActuacion 9*/

        
        if($request->input('selectMedioControl') == '' && $request->input('selectUsuario') == '' &&  $request->input('selectEstadoRadicado') == '' && $request->input('selectAbogadoDemandante') == '' &&  $request->input('selectJuzgado') == '' && $request->input('selectSecretaria') == '' && $request->input('selectTipoActuacion') == '')
        {
            $reportes = DB::table('juriradicados')
                ->select('idRadicado', 'vigenciaRadicado', 'fechaRadicado', 'nombreTipoProceso', 'nombreTema')
                ->join('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                ->leftJoin('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
                ->whereBetween(DB::raw('substr(fechaRadicado, -19, 10)'),
                array($fechaInicial, $fechaFinal))
                ->get();
        }

        if($tipoReporte == 1 && $request->input('selectMedioControl') != '')//Tipos de medios de control
        {
            $reportes = DB::table('juriradicados')
                ->select('idRadicado', 'vigenciaRadicado', 'fechaRadicado', 'nombreTipoProceso', 'nombreTema')
                ->join('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                ->leftJoin('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
                ->whereBetween(DB::raw('substr(fechaRadicado, -19, 10)'),
                array($fechaInicial, $fechaFinal))
                ->where('jurimedioscontrol_idMediosControl', '=', $request->input('selectMedioControl'))
                ->get();
        }# //Tipos de medios de control

        if($tipoReporte == 2 && $request->input('selectAccion') != '')//Acciones
        {
            $reportes = DB::table('juriradicados')
                ->select('idRadicado', 'vigenciaRadicado', 'fechaRadicado', 'nombreTipoProceso', 'nombreTema')
                ->join('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                ->leftJoin('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
                ->whereBetween(DB::raw('substr(fechaRadicado, -19, 10)'),
                array($fechaInicial, $fechaFinal))
                ->where('juriacciones_idAccion', '=', $request->input('selectAccion'))
                ->get();
        }# //Acciones

        if($tipoReporte == 3 && $request->input('selectUsuario') != '')//Usuarios
        {
            $reportes = DB::table('juriradicados')
                ->select('idRadicado', 'vigenciaRadicado', 'fechaRadicado', 'nombreTipoProceso', 'nombreTema')
                ->join('juriestadosetapas', function ($join) {
                    $join->on('juriradicados.vigenciaRadicado', '=', 'juriestadosetapas.juriradicados_vigenciaRadicado')
                    ->on('juriradicados.idRadicado', '=', 'juriestadosetapas.juriradicados_idRadicado');
                })
                ->join('juriresponsables', 'juriestadosetapas.juriresponsables_idResponsable', '=', 'juriresponsables.idResponsable')
                ->join('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                ->leftJoin('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
                ->whereBetween(DB::raw('substr(fechaRadicado, -19, 10)'),
                array($fechaInicial, $fechaFinal))
                ->groupBY('juriestadosetapas.juriradicados_idRadicado')
                ->groupBY('juriestadosetapas.juriradicados_vigenciaRadicado')
                ->where('usuarios_idUsuario', '=', $request->input('selectUsuario'))
                ->get();
        }# //Usuarios

        if($tipoReporte == 4 && $request->input('selectEstadoRadicado') != '')//Estado de radicados
        {
            $reportes = DB::table('juriradicados')
                ->select('idRadicado', 'vigenciaRadicado', 'fechaRadicado', 'nombreTipoProceso', 'nombreTema')
                ->join('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                ->leftJoin('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
                ->whereBetween(DB::raw('substr(fechaRadicado, -19, 10)'),
                array($fechaInicial, $fechaFinal))
                ->where('juriestadosradicados_idEstadoRadicado', '=', $request->input('selectEstadoRadicado'))
                ->get();
        }#// Estado de radicados

        if($tipoReporte == 5 && $request->input('selectAbogadoDemandante') != '')//Abogados demandantes
        {
            $reportes = DB::table('juriradicados')
                ->select('idRadicado', 'vigenciaRadicado', 'fechaRadicado', 'nombreTipoProceso', 'nombreTema')
                ->join('juriestadosetapas', function ($join) {
                    $join->on('juriradicados.vigenciaRadicado', '=', 'juriestadosetapas.juriradicados_vigenciaRadicado')
                    ->on('juriradicados.idRadicado', '=', 'juriestadosetapas.juriradicados_idRadicado');
                })
                ->join('juriinvolucrados', function ($join) {
                    $join->on('juriradicados.vigenciaRadicado', '=', 'juriinvolucrados.juriradicados_vigenciaRadicado')
                    ->on('juriradicados.idRadicado', '=', 'juriinvolucrados.juriradicados_idRadicado');
                })
                ->join('juriresponsables', 'juriestadosetapas.juriresponsables_idResponsable', '=', 'juriresponsables.idResponsable')
                ->join('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                ->leftJoin('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
                ->whereBetween(DB::raw('substr(fechaRadicado, -19, 10)'),
                array($fechaInicial, $fechaFinal))
                ->groupBY('juriestadosetapas.juriradicados_idRadicado')
                ->groupBY('juriestadosetapas.juriradicados_vigenciaRadicado')
                ->where('juriabogados_idAbogado', '=', $request->input('selectAbogadoDemandante'))
                ->get();
        }# //Abogados demandantes

        if($tipoReporte == 6 && $request->input('documentoDemandante') != '')//POR DEMANDANTE
        {
            $reportes = DB::table('juriradicados')
                ->select('idRadicado', 'vigenciaRadicado', 'fechaRadicado', 'nombreTipoProceso', 'nombreTema')
                ->join('juriestadosetapas', function ($join) {
                    $join->on('juriradicados.vigenciaRadicado', '=', 'juriestadosetapas.juriradicados_vigenciaRadicado')
                    ->on('juriradicados.idRadicado', '=', 'juriestadosetapas.juriradicados_idRadicado');
                })
                ->join('juriinvolucrados', function ($join) {
                    $join->on('juriradicados.vigenciaRadicado', '=', 'juriinvolucrados.juriradicados_vigenciaRadicado')
                    ->on('juriradicados.idRadicado', '=', 'juriinvolucrados.juriradicados_idRadicado');
                })
                ->join('solicitantes', 'juriinvolucrados.solicitantes_idSolicitante', '=', 'solicitantes.idSolicitante')
                ->join('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                ->leftJoin('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
                ->whereBetween(DB::raw('substr(fechaRadicado, -19, 10)'),
                array($fechaInicial, $fechaFinal))
                ->groupBY('juriestadosetapas.juriradicados_idRadicado')
                ->groupBY('juriestadosetapas.juriradicados_vigenciaRadicado')
                ->where('documentoSolicitante', '=', $request->input('documentoDemandante'))
                ->get();
        }# //POR DEMANDANTE

        if($tipoReporte == 7 && $request->input('selectJuzgado') != '')//Juzgados
        {
            $reportes = DB::table('juriradicados')
                ->select('idRadicado', 'vigenciaRadicado', 'fechaRadicado', 'nombreTipoProceso', 'nombreTema')
                ->join('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                ->leftJoin('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
                ->whereBetween(DB::raw('substr(fechaRadicado, -19, 10)'),
                array($fechaInicial, $fechaFinal))
                ->where('jurijuzgados_idJuzgado', '=', $request->input('selectJuzgado'))
                ->get();
           
        }# //Juzgados

        if($tipoReporte == 8 && $request->input('selectSecretaria') != '')//Secretarias
        {
            $reportes = DB::table('juriradicados')
                ->select('idRadicado', 'vigenciaRadicado', 'fechaRadicado', 'nombreTipoProceso', 'nombreTema')
                ->join('juriestadosetapas', function ($join) {
                    $join->on('juriradicados.vigenciaRadicado', '=', 'juriestadosetapas.juriradicados_vigenciaRadicado')
                    ->on('juriradicados.idRadicado', '=', 'juriestadosetapas.juriradicados_idRadicado');
                })
                ->join('juriinvolucrados', function ($join) {
                    $join->on('juriradicados.vigenciaRadicado', '=', 'juriinvolucrados.juriradicados_vigenciaRadicado')
                    ->on('juriradicados.idRadicado', '=', 'juriinvolucrados.juriradicados_idRadicado');
                })
                ->join('dependencias', 'juriinvolucrados.dependencias_idDependencia', '=', 'dependencias.idDependencia')
                ->join('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                ->leftJoin('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
                ->whereBetween(DB::raw('substr(fechaRadicado, -19, 10)'),
                array($fechaInicial, $fechaFinal))
                ->where('idDependencia', '=', $request->input('selectSecretaria'))
                ->groupBY('juriestadosetapas.juriradicados_idRadicado')
                ->groupBY('juriestadosetapas.juriradicados_vigenciaRadicado')
                ->get();
        }# //Secretarias

        if($tipoReporte == 9 && $request->input('selectTipoActuacion') != '')//Tipos de actuación
        {
            $reportes = DB::table('juriradicados')
                ->select('idRadicado', 'vigenciaRadicado', 'fechaRadicado', 'nombreTipoProceso', 'nombreTema', 'codigoProceso')
                ->join('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                ->leftJoin('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
                ->whereBetween(DB::raw('substr(fechaRadicado, -19, 10)'),
                array($fechaInicial, $fechaFinal))
                ->get();
        }# //Tipos de actuación

        if($tipoReporte == 10)//Valoraciones del fallo
        {

            $reportes = [];
            /*
            $reportes = DB::table('juriradicados')
                ->select('idRadicado', 'vigenciaRadicado', 'fechaRadicado', 'nombreMedioControl', 'codigoProceso', 'nombreEstadoRadicado' ,'fechaNotificacion', 'nombreAccion' , 'juriresponsables.usuarios_idUsuario' ,'nombreJuzgado', 'nombreTipoProceso', 'nombreTema')
                ->leftJoin('juriestadosetapas', function ($join) {
                    $join->on('juriradicados.vigenciaRadicado', '=', 'juriestadosetapas.juriradicados_vigenciaRadicado')
                    ->on('juriradicados.idRadicado', '=', 'juriestadosetapas.juriradicados_idRadicado');
                })
                ->leftJoin('juriinvolucrados', function ($join) {
                    $join->on('juriradicados.vigenciaRadicado', '=', 'juriinvolucrados.juriradicados_vigenciaRadicado')
                    ->on('juriradicados.idRadicado', '=', 'juriinvolucrados.juriradicados_idRadicado');
                })
                ->leftJoin('jurivaloracionesfallomzl', function ($join) {
                    $join->on('juriradicados.vigenciaRadicado', '=', 'jurivaloracionesfallomzl.juriradicados_vigenciaRadicado')
                    ->on('juriradicados.idRadicado', '=', 'jurivaloracionesfallomzl.juriradicados_idRadicado');
                })
                ->leftJoin('juriresponsables', 'juriestadosetapas.juriresponsables_idResponsable', '=', 'juriresponsables.idResponsable')
                ->leftJoin('jurimedioscontrol', 'juriradicados.jurimedioscontrol_idMediosControl', '=', 'jurimedioscontrol.idMediosControl')
                ->leftJoin('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                ->leftJoin('juriacciones', 'juriradicados.juriacciones_idAccion', '=', 'juriacciones.idAccion')
                ->leftJoin('juriestadosradicados', 'juriradicados.juriestadosradicados_idEstadoRadicado', '=', 'juriestadosradicados.idEstadoRadicado')
                ->leftJoin('jurijuzgados', 'juriradicados.jurijuzgados_idJuzgado', '=', 'jurijuzgados.idJuzgado')
                ->leftJoin('dependencias', 'juriinvolucrados.dependencias_idDependencia', '=', 'dependencias.idDependencia')
                ->leftJoin('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
                ->whereBetween(DB::raw('substr(fechaRadicado, -19, 10)'),
                array($fechaInicial, $fechaFinal))
                ->groupBY('juriestadosetapas.juriradicados_idRadicado')
                ->groupBY('juriestadosetapas.juriradicados_vigenciaRadicado')
                ->get();*/
        }# //Valoraciones del fallo

        if($tipoReporte == 11 && $request->input('tema') != '')//POR DEMANDANTE
        {
            $reportes = DB::table('juriradicados')
                ->select('idRadicado', 'vigenciaRadicado', 'fechaRadicado', 'nombreTipoProceso', 'nombreTema')
                ->join('juriestadosetapas', function ($join) {
                    $join->on('juriradicados.vigenciaRadicado', '=', 'juriestadosetapas.juriradicados_vigenciaRadicado')
                    ->on('juriradicados.idRadicado', '=', 'juriestadosetapas.juriradicados_idRadicado');
                })
                ->join('juriinvolucrados', function ($join) {
                    $join->on('juriradicados.vigenciaRadicado', '=', 'juriinvolucrados.juriradicados_vigenciaRadicado')
                    ->on('juriradicados.idRadicado', '=', 'juriinvolucrados.juriradicados_idRadicado');
                })
                ->join('solicitantes', 'juriinvolucrados.solicitantes_idSolicitante', '=', 'solicitantes.idSolicitante')
                ->join('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                ->leftJoin('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
                ->groupBY('juriestadosetapas.juriradicados_idRadicado')
                ->groupBY('juriestadosetapas.juriradicados_vigenciaRadicado')
                ->where('nombreTema', 'LIKE', '%'.$request->input('tema').'%')
                ->get();
        }# //POR TEMA

        if($tipoReporte == 12 )//Demandas por fallo instancia
        {
            /*
                Se realiza una validacion con los tipos de actuaciones al 
                no contar con un datos exactos en la bd, esto sucede por que el usuario que
                ingresa los tipos de actuaciones no se fija en que tipo es 
            */
            if($request->input('selectTipoActuacion') == 48)
            {
                // 47 =>  Fallo de segunda instancia tutelas
                // 48 =>  Fallo de segunda instancia proceso judicial
                // 168 => Finaliza en segunda  instancia tutelas
                $tipoActuacion = [48, 47 , 168 ];
            }
            elseif($request->input('selectTipoActuacion') == 44)
            {
                //44 =>  Fallo de primera instancia proceso judicial
                //46 =>  Fallo de primera instancia tutelas
                //51 =>  Finaliza en primera instancia tutelas
                //206 => Sentencia de primera instancia
                //207 => Sentencia de primera instancia tutelas
                $tipoActuacion = [44, 46, 51, 206, 207 ]; 

            }
            
            $reportes = DB::table('juriradicados')
                                ->select('idRadicado', 'vigenciaRadicado', 'fechaRadicado', 'idTipoProcesos', 'nombreTipoProceso', 'nombreMedioControl', 'radicadoJuzgado', 'codigoUnicoJuzgado', 'nombreJuzgado', 'nombreTema', 'nombreEstadoRadicado', 'codigoProceso')
                                ->leftJoin('juriactuaciones', function ($join) {
                    $join->on('juriradicados.vigenciaRadicado', '=', 'juriactuaciones.juriradicados_vigenciaRadicado')
                    ->on('juriradicados.idRadicado', '=', 'juriactuaciones.juriradicados_idRadicado');
                })
                ->leftJoin('juritiposactuaciones', 'juriactuaciones.juritiposactuaciones_idTipoActuacion', '=', 'juritiposactuaciones.idTipoActuacion')
                                ->leftJoin('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                                ->leftJoin('jurimedioscontrol', 'juriradicados.jurimedioscontrol_idMediosControl', '=', 'jurimedioscontrol.idMediosControl')
                                ->leftJoin('jurijuzgados', 'juriradicados.jurijuzgados_idJuzgado', '=', 'jurijuzgados.idJuzgado')
                                ->leftJoin('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
                                ->leftJoin('juriestadosradicados', 'juriradicados.juriestadosradicados_idEstadoRadicado', '=', 'juriestadosradicados.idEstadoRadicado')
                                ->whereBetween('juriactuaciones.fechaActuacion', [$fechaInicial, $fechaFinal])
                                ->whereIn('juritiposactuaciones_idTipoActuacion',$tipoActuacion)
                                ->where('juriradicados.juritipoprocesos_idTipoProceso',$request->input('selectTipoProceso'))
                                ->get();  

            
        }# //Demandas por fallo instancia


        /* Para el gráfico de tipos de procesos  */
        if($tipoReporte == 1)
        {   
            if(count($reportes) > 0)
            {
                foreach ($reportes as $radicado) 
                {
                    switch (substr($radicado->fechaRadicado, 5, 2)) 
                    {
                        case '01':
                            $ingresadasEne++;
                        break;

                        case '02':
                            $ingresadasFeb++;
                        break;

                        case '03':
                            $ingresadasMar++;
                        break;

                        case '04':
                            $ingresadasAbr++;
                        break;

                        case '05':
                            $ingresadasMay++;
                        break;

                        case '06':
                            $ingresadasJun++;
                        break;

                        case '07':
                            $ingresadasJul++;
                        break;

                        case '08':
                            $ingresadasAgo++;
                        break;

                        case '09':
                            $ingresadasSep++;
                        break;

                        case '10':
                            $ingresadasOct++;
                        break;

                        case '11':
                            $ingresadasNov++;
                        break;

                        case '12':
                            $ingresadasDic++;
                        break;
                    }
                    $totalMediosControl = $ingresadasEne + $ingresadasFeb + $ingresadasMar + $ingresadasAbr + $ingresadasMay + $ingresadasJun
                    + $ingresadasJul + $ingresadasAgo + $ingresadasSep + $ingresadasOct + $ingresadasNov + $ingresadasDic;
                }
            }
        }
        /* Para el gráfico de tipos de procesos  */

        /* Para el gráfico de acciones  */
        if($tipoReporte == 2)
        {
            $acciones = DB::table('juriacciones')
                ->get();
        }
        /* Para el gráfico de acciones  */

        /* Para el gráfico de usuarios  */
        if($tipoReporte == 3)
        {
            $usuarios = DB::table('juriresponsables')
                ->select('usuarios_idUsuario', 'nombresUsuario')
                ->join('usuarios', 'juriresponsables.usuarios_idUsuario', '=', 'usuarios.idUsuario')
                ->get();
        }
        /* Para el gráfico de usuarios  */

        /* Para el gráfico de estado radicado  */
        if($tipoReporte == 4)
        {
            $estadoRadicados = DB::table('juriestadosradicados')
                ->get();
        }
        /* Para el gráfico de estado radicado  */

        /* Para el gráfico de abogados demandantes  */
        if($tipoReporte == 5)
        {
            $abogadosDemandantes = DB::table('juriabogados')
                ->get();
        }
        /* Para el gráfico de abogados demandantes  */

        /* Para el gráfico de demandantes  */
        if($tipoReporte == 6)
        {
            $solicitantes = DB::table('solicitantes')
                ->where('documentoSolicitante', '=', $request->input('documentoDemandante'))
                ->get();
        }
        /* Para el gráfico de demandantes  */

        /* Para el gráfico de juzgados  */
        if($tipoReporte == 7)
        {
            $juzgados = DB::table('jurijuzgados')
                ->where('idJuzgado', '=', $request->input('selectJuzgado'))
                ->get();
        }
        /* Para el gráfico de juzgados  */

        /* Para el gráfico de secretarías  */
        if($tipoReporte == 8)
        {
            $secretarias = DB::table('dependencias')
                ->get();
        }
        /* Para el gráfico de secretarías  */

        /* Para el gráfico de tipos de actuación  */
        if($tipoReporte == 9)
        {
            $tiposActuacion = DB::table('juritiposactuaciones')
                ->get();
        }
        /* Para el gráfico de tipos de actuación  */


        if($tipoReporte == 13)//Terminados
        {
            $reportes = [];//jhonatan

        }    
        

        return view('ajax_reportes.ajaxTablaReporte')
                    ->with('reportes', $reportes)
                    ->with('tipoReporte', $tipoReporte)
                    ->with('ingresadasEne', $ingresadasEne)
                    ->with('ingresadasFeb', $ingresadasFeb)
                    ->with('ingresadasMar', $ingresadasMar)
                    ->with('ingresadasAbr', $ingresadasAbr)
                    ->with('ingresadasMay', $ingresadasMay)
                    ->with('ingresadasJun', $ingresadasJun)
                    ->with('ingresadasJul', $ingresadasJul)
                    ->with('ingresadasAgo', $ingresadasAgo)
                    ->with('ingresadasSep', $ingresadasSep)
                    ->with('ingresadasOct', $ingresadasOct)
                    ->with('ingresadasNov', $ingresadasNov)
                    ->with('ingresadasDic', $ingresadasDic)
                    ->with('totalMediosControl', $totalMediosControl)
                    ->with('acciones', $acciones)
                    ->with('usuarios', $usuarios)
                    ->with('estadoRadicados', $estadoRadicados)
                    ->with('abogadosDemandantes', $abogadosDemandantes)
                    ->with('solicitantes', $solicitantes)
                    ->with('juzgados', $juzgados)
                    ->with('secretarias', $secretarias)
                    ->with('tiposActuacion', $tiposActuacion)
                    ->with('fechaInicial', $fechaInicial)
                    ->with('fechaFinal', $fechaFinal);
    }

    public function actionReporteTabla(Request $request)
    {

        $fechaInicial = str_replace("/","-",$request->input('fechaInicial'));
        $fechaFinal = str_replace("/","-",$request->input('fechaFinal'));
        $tipoReporte = $request->input('reporte');

        /* TIPO PROCESO  REPORTE 1 Medios de control*/
        $ingresadasEne  = 0;
        $ingresadasFeb  = 0;
        $ingresadasMar  = 0;
        $ingresadasAbr  = 0;
        $ingresadasMay  = 0;
        $ingresadasJun  = 0;
        $ingresadasJul  = 0;
        $ingresadasAgo  = 0;
        $ingresadasSep  = 0;
        $ingresadasOct  = 0;
        $ingresadasNov  = 0;
        $ingresadasDic  = 0;
        $totalMediosControl = 0;
        /* TIPO PROCESO  REPORTE 1 Medios de control*/

        /* ACCIONES 2*/
        $acciones  = [];
        /* ACCIONES 2*/

        /* Usuarios 3*/
        $usuarios  = [];
        /* Usuarios 3*/

        /* Estados Radicados 4*/
        $estadoRadicados  = [];
        /* Estados Radicados 4*/

        /* Abogados demandantes 5*/
        $abogadosDemandantes  = [];
        /* Abogados demandantes 5*/

        /* Solicitantes 6*/
        $solicitantes  = [];
        /* Solicitantes 6*/

        /* Juzgados 7*/
        $juzgados  = [];
        /* Juzgados 7*/

        /* Secretarías 8*/
        $secretarias  = [];
        /* Secretarías 8*/

        /* tiposActuacion 9*/
        $tiposActuacion  = [];
        /* tiposActuacion 9*/

        
        if($request->input('selectMedioControl') == '' && $request->input('selectUsuario') == '' &&  $request->input('selectEstadoRadicado') == '' && $request->input('selectAbogadoDemandante') == '' &&  $request->input('selectJuzgado') == '' && $request->input('selectSecretaria') == '' && $request->input('selectTipoActuacion') == '')
        {
            $reportes = [];
        }

        if($tipoReporte == 1 && $request->input('selectMedioControl') != '')//Tipos de medios de control
        {
            $reportes = [];
        }# //Tipos de medios de control

        if($tipoReporte == 2 && $request->input('selectAccion') != '')//Acciones
        {
            $reportes = [];
        }# //Acciones

        if($tipoReporte == 3 && $request->input('selectUsuario') != '')//Usuarios
        {
            $reportes = DB::table('juriradicados')
                ->select('idRadicado', 'vigenciaRadicado', 'fechaRadicado', 'nombreTipoProceso', 'nombreTema')
                ->join('juriestadosetapas', function ($join) {
                    $join->on('juriradicados.vigenciaRadicado', '=', 'juriestadosetapas.juriradicados_vigenciaRadicado')
                    ->on('juriradicados.idRadicado', '=', 'juriestadosetapas.juriradicados_idRadicado');
                })
                ->join('juriresponsables', 'juriestadosetapas.juriresponsables_idResponsable', '=', 'juriresponsables.idResponsable')
                ->join('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                ->leftJoin('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
                ->whereBetween(DB::raw('substr(fechaRadicado, -19, 10)'),
                array($fechaInicial, $fechaFinal))
                ->groupBY('juriestadosetapas.juriradicados_idRadicado')
                ->groupBY('juriestadosetapas.juriradicados_vigenciaRadicado')
                ->where('usuarios_idUsuario', '=', $request->input('selectUsuario'))
                ->get();
        }# //Usuarios

        if($tipoReporte == 4 && $request->input('selectEstadoRadicado') != '')//Estado de radicados
        {
            $reportes = DB::table('juriradicados')
                ->select('idRadicado', 'vigenciaRadicado', 'fechaRadicado', 'nombreTipoProceso', 'nombreTema')
                ->join('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                ->leftJoin('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
                ->whereBetween(DB::raw('substr(fechaRadicado, -19, 10)'),
                array($fechaInicial, $fechaFinal))
                ->where('juriestadosradicados_idEstadoRadicado', '=', $request->input('selectEstadoRadicado'))
                ->get();
        }#// Estado de radicados

        if($tipoReporte == 5 && $request->input('selectAbogadoDemandante') != '')//Abogados demandantes
        {
            $reportes = DB::table('juriradicados')
                ->select('idRadicado', 'vigenciaRadicado', 'fechaRadicado', 'nombreTipoProceso', 'nombreTema')
                ->join('juriestadosetapas', function ($join) {
                    $join->on('juriradicados.vigenciaRadicado', '=', 'juriestadosetapas.juriradicados_vigenciaRadicado')
                    ->on('juriradicados.idRadicado', '=', 'juriestadosetapas.juriradicados_idRadicado');
                })
                ->join('juriinvolucrados', function ($join) {
                    $join->on('juriradicados.vigenciaRadicado', '=', 'juriinvolucrados.juriradicados_vigenciaRadicado')
                    ->on('juriradicados.idRadicado', '=', 'juriinvolucrados.juriradicados_idRadicado');
                })
                ->join('juriresponsables', 'juriestadosetapas.juriresponsables_idResponsable', '=', 'juriresponsables.idResponsable')
                ->join('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                ->leftJoin('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
                ->whereBetween(DB::raw('substr(fechaRadicado, -19, 10)'),
                array($fechaInicial, $fechaFinal))
                ->groupBY('juriestadosetapas.juriradicados_idRadicado')
                ->groupBY('juriestadosetapas.juriradicados_vigenciaRadicado')
                ->where('juriabogados_idAbogado', '=', $request->input('selectAbogadoDemandante'))
                ->get();
        }# //Abogados demandantes

        if($tipoReporte == 6 && $request->input('documentoDemandante') != '')//POR DEMANDANTE
        {
            $reportes = DB::table('juriradicados')
                ->select('idRadicado', 'vigenciaRadicado', 'fechaRadicado', 'nombreTipoProceso', 'nombreTema')
                ->join('juriestadosetapas', function ($join) {
                    $join->on('juriradicados.vigenciaRadicado', '=', 'juriestadosetapas.juriradicados_vigenciaRadicado')
                    ->on('juriradicados.idRadicado', '=', 'juriestadosetapas.juriradicados_idRadicado');
                })
                ->join('juriinvolucrados', function ($join) {
                    $join->on('juriradicados.vigenciaRadicado', '=', 'juriinvolucrados.juriradicados_vigenciaRadicado')
                    ->on('juriradicados.idRadicado', '=', 'juriinvolucrados.juriradicados_idRadicado');
                })
                ->join('solicitantes', 'juriinvolucrados.solicitantes_idSolicitante', '=', 'solicitantes.idSolicitante')
                ->join('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                ->leftJoin('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
                ->whereBetween(DB::raw('substr(fechaRadicado, -19, 10)'),
                array($fechaInicial, $fechaFinal))
                ->groupBY('juriestadosetapas.juriradicados_idRadicado')
                ->groupBY('juriestadosetapas.juriradicados_vigenciaRadicado')
                ->where('documentoSolicitante', '=', $request->input('documentoDemandante'))
                ->get();
        }# //POR DEMANDANTE

        if($tipoReporte == 7 && $request->input('selectJuzgado') != '')//Juzgados
        {
            $reportes = DB::table('juriradicados')
                ->select('idRadicado', 'vigenciaRadicado', 'fechaRadicado', 'nombreTipoProceso', 'nombreTema')
                ->join('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                ->leftJoin('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
                ->whereBetween(DB::raw('substr(fechaRadicado, -19, 10)'),
                array($fechaInicial, $fechaFinal))
                ->where('jurijuzgados_idJuzgado', '=', $request->input('selectJuzgado'))
                ->get();
           
        }# //Juzgados

        if($tipoReporte == 8 && $request->input('selectSecretaria') != '')//Secretarias
        {
            $reportes = DB::table('juriradicados')
                ->select('idRadicado', 'vigenciaRadicado', 'fechaRadicado', 'nombreTipoProceso', 'nombreTema')
                ->join('juriestadosetapas', function ($join) {
                    $join->on('juriradicados.vigenciaRadicado', '=', 'juriestadosetapas.juriradicados_vigenciaRadicado')
                    ->on('juriradicados.idRadicado', '=', 'juriestadosetapas.juriradicados_idRadicado');
                })
                ->join('juriinvolucrados', function ($join) {
                    $join->on('juriradicados.vigenciaRadicado', '=', 'juriinvolucrados.juriradicados_vigenciaRadicado')
                    ->on('juriradicados.idRadicado', '=', 'juriinvolucrados.juriradicados_idRadicado');
                })
                ->join('dependencias', 'juriinvolucrados.dependencias_idDependencia', '=', 'dependencias.idDependencia')
                ->join('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                ->leftJoin('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
                ->whereBetween(DB::raw('substr(fechaRadicado, -19, 10)'),
                array($fechaInicial, $fechaFinal))
                ->where('idDependencia', '=', $request->input('selectSecretaria'))
                ->groupBY('juriestadosetapas.juriradicados_idRadicado')
                ->groupBY('juriestadosetapas.juriradicados_vigenciaRadicado')
                ->get();
        }# //Secretarias

        if($tipoReporte == 9 && $request->input('selectTipoActuacion') != '')//Tipos de actuación
        {
            $reportes = DB::table('juriradicados')
                ->select('idRadicado', 'vigenciaRadicado', 'fechaRadicado', 'nombreTipoProceso', 'nombreTema', 'codigoProceso')
                ->join('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                ->leftJoin('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
                ->whereBetween(DB::raw('substr(fechaRadicado, -19, 10)'),
                array($fechaInicial, $fechaFinal))
                ->get();
        }# //Tipos de actuación

        if($tipoReporte == 10)//Valoraciones del fallo
        {

            $reportes = [];
            /*
            $reportes = DB::table('juriradicados')
                ->select('idRadicado', 'vigenciaRadicado', 'fechaRadicado', 'nombreMedioControl', 'codigoProceso', 'nombreEstadoRadicado' ,'fechaNotificacion', 'nombreAccion' , 'juriresponsables.usuarios_idUsuario' ,'nombreJuzgado', 'nombreTipoProceso', 'nombreTema')
                ->leftJoin('juriestadosetapas', function ($join) {
                    $join->on('juriradicados.vigenciaRadicado', '=', 'juriestadosetapas.juriradicados_vigenciaRadicado')
                    ->on('juriradicados.idRadicado', '=', 'juriestadosetapas.juriradicados_idRadicado');
                })
                ->leftJoin('juriinvolucrados', function ($join) {
                    $join->on('juriradicados.vigenciaRadicado', '=', 'juriinvolucrados.juriradicados_vigenciaRadicado')
                    ->on('juriradicados.idRadicado', '=', 'juriinvolucrados.juriradicados_idRadicado');
                })
                ->leftJoin('jurivaloracionesfallomzl', function ($join) {
                    $join->on('juriradicados.vigenciaRadicado', '=', 'jurivaloracionesfallomzl.juriradicados_vigenciaRadicado')
                    ->on('juriradicados.idRadicado', '=', 'jurivaloracionesfallomzl.juriradicados_idRadicado');
                })
                ->leftJoin('juriresponsables', 'juriestadosetapas.juriresponsables_idResponsable', '=', 'juriresponsables.idResponsable')
                ->leftJoin('jurimedioscontrol', 'juriradicados.jurimedioscontrol_idMediosControl', '=', 'jurimedioscontrol.idMediosControl')
                ->leftJoin('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                ->leftJoin('juriacciones', 'juriradicados.juriacciones_idAccion', '=', 'juriacciones.idAccion')
                ->leftJoin('juriestadosradicados', 'juriradicados.juriestadosradicados_idEstadoRadicado', '=', 'juriestadosradicados.idEstadoRadicado')
                ->leftJoin('jurijuzgados', 'juriradicados.jurijuzgados_idJuzgado', '=', 'jurijuzgados.idJuzgado')
                ->leftJoin('dependencias', 'juriinvolucrados.dependencias_idDependencia', '=', 'dependencias.idDependencia')
                ->leftJoin('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
                ->whereBetween(DB::raw('substr(fechaRadicado, -19, 10)'),
                array($fechaInicial, $fechaFinal))
                ->groupBY('juriestadosetapas.juriradicados_idRadicado')
                ->groupBY('juriestadosetapas.juriradicados_vigenciaRadicado')
                ->get();*/
        }# //Valoraciones del fallo

        if($tipoReporte == 11 && $request->input('tema') != '')//POR DEMANDANTE
        {
            $reportes = DB::table('juriradicados')
                ->select('idRadicado', 'vigenciaRadicado', 'fechaRadicado', 'nombreTipoProceso', 'nombreTema')
                ->join('juriestadosetapas', function ($join) {
                    $join->on('juriradicados.vigenciaRadicado', '=', 'juriestadosetapas.juriradicados_vigenciaRadicado')
                    ->on('juriradicados.idRadicado', '=', 'juriestadosetapas.juriradicados_idRadicado');
                })
                ->join('juriinvolucrados', function ($join) {
                    $join->on('juriradicados.vigenciaRadicado', '=', 'juriinvolucrados.juriradicados_vigenciaRadicado')
                    ->on('juriradicados.idRadicado', '=', 'juriinvolucrados.juriradicados_idRadicado');
                })
                ->join('solicitantes', 'juriinvolucrados.solicitantes_idSolicitante', '=', 'solicitantes.idSolicitante')
                ->join('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                ->leftJoin('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
                ->groupBY('juriestadosetapas.juriradicados_idRadicado')
                ->groupBY('juriestadosetapas.juriradicados_vigenciaRadicado')
                ->where('nombreTema', 'LIKE', '%'.$request->input('tema').'%')
                ->get();
        }# //POR TEMA

        if($tipoReporte == 12 )//Demandas por fallo instancia
        {
            /*
                Se realiza una validacion con los tipos de actuaciones al 
                no contar con un datos exactos en la bd, esto sucede por que el usuario que
                ingresa los tipos de actuaciones no se fija en que tipo es 
            */
            if($request->input('selectTipoActuacion') == 48)
            {
                // 47 =>  Fallo de segunda instancia tutelas
                // 48 =>  Fallo de segunda instancia proceso judicial
                // 168 => Finaliza en segunda  instancia tutelas
                $tipoActuacion = [48, 47 , 168 ];
            }
            elseif($request->input('selectTipoActuacion') == 44)
            {
                //44 =>  Fallo de primera instancia proceso judicial
                //46 =>  Fallo de primera instancia tutelas
                //51 =>  Finaliza en primera instancia tutelas
                //206 => Sentencia de primera instancia
                //207 => Sentencia de primera instancia tutelas
                $tipoActuacion = [44, 46, 51, 206, 207 ]; 

            }
            
            $reportes = DB::table('juriradicados')
                                ->select('idRadicado', 'vigenciaRadicado', 'fechaRadicado', 'idTipoProcesos', 'nombreTipoProceso', 'nombreMedioControl', 'radicadoJuzgado', 'codigoUnicoJuzgado', 'nombreJuzgado', 'nombreTema', 'nombreEstadoRadicado', 'codigoProceso')
                                ->leftJoin('juriactuaciones', function ($join) {
                    $join->on('juriradicados.vigenciaRadicado', '=', 'juriactuaciones.juriradicados_vigenciaRadicado')
                    ->on('juriradicados.idRadicado', '=', 'juriactuaciones.juriradicados_idRadicado');
                })
                ->leftJoin('juritiposactuaciones', 'juriactuaciones.juritiposactuaciones_idTipoActuacion', '=', 'juritiposactuaciones.idTipoActuacion')
                                ->leftJoin('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                                ->leftJoin('jurimedioscontrol', 'juriradicados.jurimedioscontrol_idMediosControl', '=', 'jurimedioscontrol.idMediosControl')
                                ->leftJoin('jurijuzgados', 'juriradicados.jurijuzgados_idJuzgado', '=', 'jurijuzgados.idJuzgado')
                                ->leftJoin('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
                                ->leftJoin('juriestadosradicados', 'juriradicados.juriestadosradicados_idEstadoRadicado', '=', 'juriestadosradicados.idEstadoRadicado')
                                ->whereBetween('juriactuaciones.fechaActuacion', [$fechaInicial, $fechaFinal])
                                ->whereIn('juritiposactuaciones_idTipoActuacion',$tipoActuacion)
                                ->where('juriradicados.juritipoprocesos_idTipoProceso',$request->input('selectTipoProceso'))
                                ->get();  

            
        }# //Demandas por fallo instancia
        if($tipoReporte == 14 && $request->input('asunto') != '')//POR DEMANDANTE
        {
            $reportes = DB::table('juriradicados')
                ->select('idRadicado', 'vigenciaRadicado', 'fechaRadicado', 'nombreTipoProceso', 'nombreTema')
                ->join('juriestadosetapas', function ($join) {
                    $join->on('juriradicados.vigenciaRadicado', '=', 'juriestadosetapas.juriradicados_vigenciaRadicado')
                    ->on('juriradicados.idRadicado', '=', 'juriestadosetapas.juriradicados_idRadicado');
                })
                ->join('juriinvolucrados', function ($join) {
                    $join->on('juriradicados.vigenciaRadicado', '=', 'juriinvolucrados.juriradicados_vigenciaRadicado')
                    ->on('juriradicados.idRadicado', '=', 'juriinvolucrados.juriradicados_idRadicado');
                })
                ->join('solicitantes', 'juriinvolucrados.solicitantes_idSolicitante', '=', 'solicitantes.idSolicitante')
                ->join('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                ->leftJoin('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
                ->groupBY('juriestadosetapas.juriradicados_idRadicado')
                ->groupBY('juriestadosetapas.juriradicados_vigenciaRadicado')
                ->where('asunto', 'LIKE', '%'.$request->input('asunto').'%')
                ->get();
        }


        /* Para el gráfico de tipos de procesos  */
        if($tipoReporte == 1)
        {   
            if(count($reportes) > 0)
            {
                foreach ($reportes as $radicado) 
                {
                    switch (substr($radicado->fechaRadicado, 5, 2)) 
                    {
                        case '01':
                            $ingresadasEne++;
                        break;

                        case '02':
                            $ingresadasFeb++;
                        break;

                        case '03':
                            $ingresadasMar++;
                        break;

                        case '04':
                            $ingresadasAbr++;
                        break;

                        case '05':
                            $ingresadasMay++;
                        break;

                        case '06':
                            $ingresadasJun++;
                        break;

                        case '07':
                            $ingresadasJul++;
                        break;

                        case '08':
                            $ingresadasAgo++;
                        break;

                        case '09':
                            $ingresadasSep++;
                        break;

                        case '10':
                            $ingresadasOct++;
                        break;

                        case '11':
                            $ingresadasNov++;
                        break;

                        case '12':
                            $ingresadasDic++;
                        break;
                    }
                    $totalMediosControl = $ingresadasEne + $ingresadasFeb + $ingresadasMar + $ingresadasAbr + $ingresadasMay + $ingresadasJun
                    + $ingresadasJul + $ingresadasAgo + $ingresadasSep + $ingresadasOct + $ingresadasNov + $ingresadasDic;
                }
            }
        }
        /* Para el gráfico de tipos de procesos  */

        /* Para el gráfico de acciones  */
        if($tipoReporte == 2)
        {
            $acciones = DB::table('juriacciones')
                ->get();
        }
        /* Para el gráfico de acciones  */

        /* Para el gráfico de usuarios  */
        if($tipoReporte == 3)
        {
            $usuarios = DB::table('juriresponsables')
                ->select('usuarios_idUsuario', 'nombresUsuario')
                ->join('usuarios', 'juriresponsables.usuarios_idUsuario', '=', 'usuarios.idUsuario')
                ->get();
        }
        /* Para el gráfico de usuarios  */

        /* Para el gráfico de estado radicado  */
        if($tipoReporte == 4)
        {
            $estadoRadicados = DB::table('juriestadosradicados')
                ->get();
        }
        /* Para el gráfico de estado radicado  */

        /* Para el gráfico de abogados demandantes  */
        if($tipoReporte == 5)
        {
            $abogadosDemandantes = DB::table('juriabogados')
                ->get();
        }
        /* Para el gráfico de abogados demandantes  */

        /* Para el gráfico de demandantes  */
        if($tipoReporte == 6)
        {
            $solicitantes = DB::table('solicitantes')
                ->where('documentoSolicitante', '=', $request->input('documentoDemandante'))
                ->get();
        }
        /* Para el gráfico de demandantes  */

        /* Para el gráfico de juzgados  */
        if($tipoReporte == 7)
        {
            $juzgados = DB::table('jurijuzgados')
                ->where('idJuzgado', '=', $request->input('selectJuzgado'))
                ->get();
        }
        /* Para el gráfico de juzgados  */

        /* Para el gráfico de secretarías  */
        if($tipoReporte == 8)
        {
            $secretarias = DB::table('dependencias')
                ->get();
        }
        /* Para el gráfico de secretarías  */

        /* Para el gráfico de tipos de actuación  */
        if($tipoReporte == 9)
        {
            $tiposActuacion = DB::table('juritiposactuaciones')
                ->get();
        }
        /* Para el gráfico de tipos de actuación  */


        if($tipoReporte == 13)//Terminados
        {
            $reportes = [];//jhonatan

        }    
        

        return view('ajax_reportes.ajaxTablaReporte')
                    ->with('reportes', $reportes)
                    ->with('tipoReporte', $tipoReporte)
                    ->with('ingresadasEne', $ingresadasEne)
                    ->with('ingresadasFeb', $ingresadasFeb)
                    ->with('ingresadasMar', $ingresadasMar)
                    ->with('ingresadasAbr', $ingresadasAbr)
                    ->with('ingresadasMay', $ingresadasMay)
                    ->with('ingresadasJun', $ingresadasJun)
                    ->with('ingresadasJul', $ingresadasJul)
                    ->with('ingresadasAgo', $ingresadasAgo)
                    ->with('ingresadasSep', $ingresadasSep)
                    ->with('ingresadasOct', $ingresadasOct)
                    ->with('ingresadasNov', $ingresadasNov)
                    ->with('ingresadasDic', $ingresadasDic)
                    ->with('totalMediosControl', $totalMediosControl)
                    ->with('acciones', $acciones)
                    ->with('usuarios', $usuarios)
                    ->with('estadoRadicados', $estadoRadicados)
                    ->with('abogadosDemandantes', $abogadosDemandantes)
                    ->with('solicitantes', $solicitantes)
                    ->with('juzgados', $juzgados)
                    ->with('secretarias', $secretarias)
                    ->with('tiposActuacion', $tiposActuacion)
                    ->with('fechaInicial', $fechaInicial)
                    ->with('fechaFinal', $fechaFinal);
    }


    public function actionReporteExcel($vector)
    {
        $datos = json_decode($vector, true);
        $titulo = "Reporte Jurídica";

        $fechaInicial = $datos['fechaInicial'];
        $fechaFinal = $datos['fechaFinal'];
        $tipoReporte = $datos['reporte'];
        $selectMedioControl = $datos['selectMedioControl'];
        $selectAccion = $datos['selectAccion'];
        $selectUsuario = $datos['selectUsuario'];
        $selectEstadoRadicado = $datos['selectEstadoRadicado'];
        $selectTipoProceso = $datos['selectTipoProceso'];
        $selectAbogadoDemandante = $datos['selectAbogadoDemandante'];
        $documentoDemandante = $datos['documentoDemandante'];
        $selectJuzgado = $datos['selectJuzgado'];
        $selectSecretaria = $datos['selectSecretaria'];
        $selectTipoActuacion = $datos['selectTipoActuacion'];
        $tema = $datos['tema'];
        $asunto = $datos['asunto'];
        
        
        Excel::create($titulo, function($excel) use ($titulo, $fechaInicial,$fechaFinal,$tipoReporte, $selectMedioControl, $selectAccion, $selectUsuario, $selectEstadoRadicado, $selectAbogadoDemandante, $documentoDemandante, $selectJuzgado, $selectSecretaria, $selectTipoActuacion, $tema, $selectTipoProceso, $asunto) {
        //Busca la entidad

        $entidad = Entidad::find(1);
        // Set the title
        if($tipoReporte == 1)
        {
            $excel->setTitle('Medios de control');
        }
        else if($tipoReporte == 2)
        {
            $excel->setTitle('Acciones');
        }
        else if($tipoReporte == 3)
        {
            $excel->setTitle('Usuarios');
        }
        else if($tipoReporte == 4)
        {
            $excel->setTitle('Estados radicados');
        }
        else if($tipoReporte == 5)
        {
            $excel->setTitle('Abogados demandantes');
        }
        else if($tipoReporte == 6)
        {
            $excel->setTitle('Demandantes');
        }
        else if($tipoReporte == 7)
        {
            $excel->setTitle('Juzgados');
        }
        else if($tipoReporte == 8)
        {
            $excel->setTitle('Secretarías');
        }
        else if($tipoReporte == 9)
        {
            $excel->setTitle('Tipo de actuación');
        }
        else if($tipoReporte == 10)
        {
            $excel->setTitle('Valoraciones del fallo');
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
            $excel->setDescription('Medios de control - '.$entidad->nombreEntidad);
        }
        else if($tipoReporte == 2)
        {
            $excel->setDescription('Acciones - '.$entidad->nombreEntidad);
        }
        else if($tipoReporte == 3)
        {
            $excel->setDescription('Usuarios - '.$entidad->nombreEntidad);
        }
        else if($tipoReporte == 4)
        {
            $excel->setDescription('Estados radicados - '.$entidad->nombreEntidad);
        }
        else if($tipoReporte == 5)
        {
            $excel->setDescription('Abogados demandantes - '.$entidad->nombreEntidad);
        }
        else if($tipoReporte == 6)
        {
            $excel->setDescription('Demandantes - '.$entidad->nombreEntidad);
        }
        else if($tipoReporte == 7)
        {
            $excel->setDescription('Juzgados - '.$entidad->nombreEntidad);
        }
        else if($tipoReporte == 8)
        {
            $excel->setDescription('Secretarías - '.$entidad->nombreEntidad);
        }
        else if($tipoReporte == 9)
        {
            $excel->setDescription('Tipo de actuación - '.$entidad->nombreEntidad);
        }
        else if($tipoReporte == 10)
        {
            $excel->setDescription('Valoraciones del fallo - '.$entidad->nombreEntidad);
        }
        else 
        {
            $excel->setDescription('Reporte Jurídica - '.$entidad->nombreEntidad);
        }

        $excel->sheet('Reporte rango fechas', function($sheet) use ($titulo, $entidad,$fechaInicial,$fechaFinal,$tipoReporte, $selectMedioControl, $selectAccion, $selectUsuario, $selectEstadoRadicado, $selectAbogadoDemandante, $documentoDemandante, $selectJuzgado, $selectSecretaria, $selectTipoActuacion,
            $tema, $selectTipoProceso, $asunto){

        $actuacion = 0;
        $valoraciones = 0;

        if($selectMedioControl == '' &&  $selectUsuario == '' &&  $selectEstadoRadicado == '' && $selectAbogadoDemandante == '' && $selectAccion == '' && $selectJuzgado == '' && $selectSecretaria == ''
            && $selectTipoActuacion == '' && $selectTipoProceso == '')
        {
            $reportes = DB::table('juriradicados')
                ->select('idRadicado', 'vigenciaRadicado', 'fechaRadicado', 'nombreMedioControl', 'codigoProceso' ,'fechaNotificacion' , 'juriresponsables.usuarios_idUsuario' ,'nombreJuzgado', 'nombreTipoProceso', 'nombreTema', 'idTipoProcesos', 'radicadoJuzgado', 'codigoUnicoJuzgado', 'fechaValoracionFallo', 'puntajeValoracionFallo', 'nombreEstadoRadicado', 'codigoProceso', 'juriradicados.mzlConsecutivo', 'asunto')
                ->leftJoin('juriestadosetapas', function ($join) {
                    $join->on('juriradicados.vigenciaRadicado', '=', 'juriestadosetapas.juriradicados_vigenciaRadicado')
                    ->on('juriradicados.idRadicado', '=', 'juriestadosetapas.juriradicados_idRadicado');
                })
                ->leftJoin('juriinvolucrados', function ($join) {
                    $join->on('juriradicados.vigenciaRadicado', '=', 'juriinvolucrados.juriradicados_vigenciaRadicado')
                    ->on('juriradicados.idRadicado', '=', 'juriinvolucrados.juriradicados_idRadicado');
                })
                ->leftJoin('jurivaloracionesfallomzl', function ($join) {
                    $join->on('juriradicados.vigenciaRadicado', '=', 'jurivaloracionesfallomzl.juriradicados_vigenciaRadicado')
                    ->on('juriradicados.idRadicado', '=', 'jurivaloracionesfallomzl.juriradicados_idRadicado');
                })
                ->leftJoin('juriresponsables', 'juriestadosetapas.juriresponsables_idResponsable', '=', 'juriresponsables.idResponsable')
                ->leftJoin('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                ->leftJoin('jurimedioscontrol', 'juriradicados.jurimedioscontrol_idMediosControl', '=', 'jurimedioscontrol.idMediosControl')
                ->leftJoin('jurijuzgados', 'juriradicados.jurijuzgados_idJuzgado', '=', 'jurijuzgados.idJuzgado')
                ->leftJoin('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
                ->leftJoin('juriestadosradicados', 'juriradicados.juriestadosradicados_idEstadoRadicado', '=', 'juriestadosradicados.idEstadoRadicado')
                ->whereBetween(DB::raw('substr(fechaRadicado, -19, 10)'),
                array($fechaInicial, $fechaFinal))
                ->groupBY('juriestadosetapas.juriradicados_idRadicado')
                ->groupBY('juriestadosetapas.juriradicados_vigenciaRadicado')
                ->get();


            /* 
                OLD JSON 

            $reportes = DB::table('juriradicados')
                                ->select('idRadicado', 'vigenciaRadicado', 'fechaRadicado', 'idTipoProcesos', 'nombreTipoProceso', 'nombreMedioControl', 'radicadoJuzgado', 'codigoUnicoJuzgado', 'nombreJuzgado', 'nombreTema', 'nombreEstadoRadicado')
                                ->leftJoin('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                                ->leftJoin('jurimedioscontrol', 'juriradicados.jurimedioscontrol_idMediosControl', '=', 'jurimedioscontrol.idMediosControl')
                                ->leftJoin('jurijuzgados', 'juriradicados.jurijuzgados_idJuzgado', '=', 'jurijuzgados.idJuzgado')
                                ->leftJoin('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
                                ->leftJoin('juriestadosradicados', 'juriradicados.juriestadosradicados_idEstadoRadicado', '=', 'juriestadosradicados.idEstadoRadicado')
                                ->whereBetween(DB::raw('substr(fechaRadicado, -19, 10)'),
                                array($fechaInicial, $fechaFinal))
                                ->get(); 
            */
        }

        if($tipoReporte == 1 && $selectMedioControl != '')//Tipos de medios de control
        {
            $reportes = DB::table('juriradicados')
                ->select('idRadicado', 'vigenciaRadicado', 'fechaRadicado', 'nombreMedioControl', 'codigoProceso' ,'fechaNotificacion' , 'juriresponsables.usuarios_idUsuario' ,'nombreJuzgado', 'nombreTipoProceso', 'nombreTema', 'idTipoProcesos', 'radicadoJuzgado', 'codigoUnicoJuzgado', 'fechaValoracionFallo', 'puntajeValoracionFallo', 'nombreEstadoRadicado', 'codigoProceso', 'juriradicados.mzlConsecutivo', 'asunto')
                ->leftJoin('juriestadosetapas', function ($join) {
                    $join->on('juriradicados.vigenciaRadicado', '=', 'juriestadosetapas.juriradicados_vigenciaRadicado')
                    ->on('juriradicados.idRadicado', '=', 'juriestadosetapas.juriradicados_idRadicado');
                })
                ->leftJoin('juriinvolucrados', function ($join) {
                    $join->on('juriradicados.vigenciaRadicado', '=', 'juriinvolucrados.juriradicados_vigenciaRadicado')
                    ->on('juriradicados.idRadicado', '=', 'juriinvolucrados.juriradicados_idRadicado');
                })
                ->leftJoin('jurivaloracionesfallomzl', function ($join) {
                    $join->on('juriradicados.vigenciaRadicado', '=', 'jurivaloracionesfallomzl.juriradicados_vigenciaRadicado')
                    ->on('juriradicados.idRadicado', '=', 'jurivaloracionesfallomzl.juriradicados_idRadicado');
                })
                ->leftJoin('juriresponsables', 'juriestadosetapas.juriresponsables_idResponsable', '=', 'juriresponsables.idResponsable')
                ->leftJoin('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                ->leftJoin('jurimedioscontrol', 'juriradicados.jurimedioscontrol_idMediosControl', '=', 'jurimedioscontrol.idMediosControl')
                ->leftJoin('jurijuzgados', 'juriradicados.jurijuzgados_idJuzgado', '=', 'jurijuzgados.idJuzgado')
                ->leftJoin('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
                ->leftJoin('juriestadosradicados', 'juriradicados.juriestadosradicados_idEstadoRadicado', '=', 'juriestadosradicados.idEstadoRadicado')
                ->whereBetween(DB::raw('substr(fechaRadicado, -19, 10)'),
                array($fechaInicial, $fechaFinal))
                ->where('jurimedioscontrol_idMediosControl', '=', $selectMedioControl)
                ->groupBY('juriestadosetapas.juriradicados_idRadicado')
                ->groupBY('juriestadosetapas.juriradicados_vigenciaRadicado')
                ->get();

            /*

            $reportes = DB::table('juriradicados')
                                ->select('idRadicado', 'vigenciaRadicado', 'fechaRadicado', 'idTipoProcesos', 'nombreTipoProceso', 'nombreMedioControl', 'radicadoJuzgado', 'codigoUnicoJuzgado', 'nombreJuzgado', 'nombreTema', 'nombreEstadoRadicado','codigoProceso')
                                ->leftJoin('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                                ->leftJoin('jurimedioscontrol', 'juriradicados.jurimedioscontrol_idMediosControl', '=', 'jurimedioscontrol.idMediosControl')
                                ->leftJoin('jurijuzgados', 'juriradicados.jurijuzgados_idJuzgado', '=', 'jurijuzgados.idJuzgado')
                                ->leftJoin('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
                                ->leftJoin('juriestadosradicados', 'juriradicados.juriestadosradicados_idEstadoRadicado', '=', 'juriestadosradicados.idEstadoRadicado')
                                ->whereBetween(DB::raw('substr(fechaRadicado, -19, 10)'),
                                array($fechaInicial, $fechaFinal))
                                ->where('jurimedioscontrol_idMediosControl', '=', $selectMedioControl)
                                ->get();

            */

        }# //Tipos de medios de control

        if($tipoReporte == 2 && $selectAccion != '')//Acciones
        {

            $reportes = DB::table('juriradicados')
                                ->select('idRadicado', 'vigenciaRadicado', 'fechaRadicado', 'idTipoProcesos', 'nombreTipoProceso', 'nombreMedioControl', 'radicadoJuzgado', 'codigoUnicoJuzgado', 'nombreJuzgado', 'nombreTema', 'nombreEstadoRadicado','codigoProceso', 'asunto')
                                ->leftJoin('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                                ->leftJoin('jurimedioscontrol', 'juriradicados.jurimedioscontrol_idMediosControl', '=', 'jurimedioscontrol.idMediosControl')
                                ->leftJoin('jurijuzgados', 'juriradicados.jurijuzgados_idJuzgado', '=', 'jurijuzgados.idJuzgado')
                                ->leftJoin('juriacciones', 'juriradicados.juriacciones_idAccion', '=', 'juriacciones.idAccion')
                                ->leftJoin('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
                                ->leftJoin('juriestadosradicados', 'juriradicados.juriestadosradicados_idEstadoRadicado', '=', 'juriestadosradicados.idEstadoRadicado')
                                ->whereBetween(DB::raw('substr(fechaRadicado, -19, 10)'),
                                array($fechaInicial, $fechaFinal))
                                ->where('juriacciones_idAccion', '=', $selectAccion)
                                ->get();

        }# //Acciones

        if($tipoReporte == 3 && $selectUsuario != '')//Usuarios
        {

            
            $reportes = DB::table('juriradicados')
                                ->select('idRadicado', 'vigenciaRadicado', 'fechaRadicado', 'idTipoProcesos', 'nombreTipoProceso', 'nombreMedioControl', 'radicadoJuzgado', 'codigoUnicoJuzgado', 'nombreJuzgado', 'nombreTema', 'nombreEstadoRadicado','codigoProceso', 'asunto')
                                ->join('juriestadosetapas', function ($join) {
                                    $join->on('juriradicados.vigenciaRadicado', '=', 'juriestadosetapas.juriradicados_vigenciaRadicado')
                                    ->on('juriradicados.idRadicado', '=', 'juriestadosetapas.juriradicados_idRadicado');
                                })
                                ->join('juriresponsables', 'juriestadosetapas.juriresponsables_idResponsable', '=', 'juriresponsables.idResponsable')
                                ->join('usuarios', 'juriresponsables.usuarios_idUsuario', '=', 'usuarios.idUsuario')
                                ->leftJoin('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                                ->leftJoin('jurimedioscontrol', 'juriradicados.jurimedioscontrol_idMediosControl', '=', 'jurimedioscontrol.idMediosControl')
                                ->leftJoin('jurijuzgados', 'juriradicados.jurijuzgados_idJuzgado', '=', 'jurijuzgados.idJuzgado')
                                ->leftJoin('juriacciones', 'juriradicados.juriacciones_idAccion', '=', 'juriacciones.idAccion')
                                ->leftJoin('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
                                ->leftJoin('juriestadosradicados', 'juriradicados.juriestadosradicados_idEstadoRadicado', '=', 'juriestadosradicados.idEstadoRadicado')
                                ->whereBetween(DB::raw('substr(fechaRadicado, -19, 10)'),
                                array($fechaInicial, $fechaFinal))
                                ->where('idUsuario', '=', $selectUsuario)
                                ->groupBY('juriestadosetapas.juriradicados_idRadicado')
                                ->groupBY('juriestadosetapas.juriradicados_vigenciaRadicado')
                                ->get();
        }# //Usuarios

        if($tipoReporte == 4)//Estado de radicados
        {

            

            if($selectTipoProceso == '' && $selectEstadoRadicado != '')//todos los procesos con un estado en particular
            {
                $reportes = DB::table('juriradicados')
                                ->select('idRadicado', 'vigenciaRadicado', 'fechaRadicado', 'idTipoProcesos', 'nombreTipoProceso', 'nombreMedioControl', 'radicadoJuzgado', 'codigoUnicoJuzgado', 'nombreJuzgado', 'nombreTema', 'nombreEstadoRadicado', 'codigoProceso', 'asunto')
                                ->leftJoin('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                                ->leftJoin('jurimedioscontrol', 'juriradicados.jurimedioscontrol_idMediosControl', '=', 'jurimedioscontrol.idMediosControl')
                                ->leftJoin('jurijuzgados', 'juriradicados.jurijuzgados_idJuzgado', '=', 'jurijuzgados.idJuzgado')
                                ->leftJoin('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
                                ->leftJoin('juriestadosradicados', 'juriradicados.juriestadosradicados_idEstadoRadicado', '=', 'juriestadosradicados.idEstadoRadicado')
                                ->whereBetween(DB::raw('substr(fechaRadicado, -19, 10)'),
                                array($fechaInicial, $fechaFinal))
                                ->where('juriestadosradicados_idEstadoRadicado', '=', $selectEstadoRadicado)
                                ->get();  
                   
            }
            elseif($selectEstadoRadicado == '' && $selectTipoProceso != '')//todos los estados con un proceso en particular
            {
                $reportes = DB::table('juriradicados')
                                ->select('idRadicado', 'vigenciaRadicado', 'fechaRadicado', 'idTipoProcesos', 'nombreTipoProceso', 'nombreMedioControl', 'radicadoJuzgado', 'codigoUnicoJuzgado', 'nombreJuzgado', 'nombreTema', 'nombreEstadoRadicado','codigoProceso', 'asunto')
                                ->leftJoin('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                                ->leftJoin('jurimedioscontrol', 'juriradicados.jurimedioscontrol_idMediosControl', '=', 'jurimedioscontrol.idMediosControl')
                                ->leftJoin('jurijuzgados', 'juriradicados.jurijuzgados_idJuzgado', '=', 'jurijuzgados.idJuzgado')
                                ->leftJoin('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
                                ->leftJoin('juriestadosradicados', 'juriradicados.juriestadosradicados_idEstadoRadicado', '=', 'juriestadosradicados.idEstadoRadicado')
                                ->whereBetween(DB::raw('substr(fechaRadicado, -19, 10)'),
                                array($fechaInicial, $fechaFinal))
                                ->where('juritipoprocesos_idTipoProceso', '=', $selectTipoProceso)
                                ->get();  
            }
            elseif($selectEstadoRadicado != '' && $selectTipoProceso != '')//un proceso con un estado en particular
            {
                $reportes = DB::table('juriradicados')
                                ->select('idRadicado', 'vigenciaRadicado', 'fechaRadicado', 'idTipoProcesos', 'nombreTipoProceso', 'nombreMedioControl', 'radicadoJuzgado', 'codigoUnicoJuzgado', 'nombreJuzgado', 'nombreTema', 'nombreEstadoRadicado','codigoProceso', 'asunto')
                                ->leftJoin('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                                ->leftJoin('jurimedioscontrol', 'juriradicados.jurimedioscontrol_idMediosControl', '=', 'jurimedioscontrol.idMediosControl')
                                ->leftJoin('jurijuzgados', 'juriradicados.jurijuzgados_idJuzgado', '=', 'jurijuzgados.idJuzgado')
                                ->leftJoin('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
                                ->leftJoin('juriestadosradicados', 'juriradicados.juriestadosradicados_idEstadoRadicado', '=', 'juriestadosradicados.idEstadoRadicado')
                                ->whereBetween(DB::raw('substr(fechaRadicado, -19, 10)'),
                                array($fechaInicial, $fechaFinal))
                                ->where('juriestadosradicados_idEstadoRadicado', '=', $selectEstadoRadicado)
                                ->where('juritipoprocesos_idTipoProceso', '=', $selectTipoProceso)
                                ->get();  
            }

            

        }#// Estado de radicados

        if($tipoReporte == 5 && $selectAbogadoDemandante != '')//Abogados demandantes
        {
            $reportes = DB::table('juriradicados')
                                ->select('idRadicado', 'vigenciaRadicado', 'fechaRadicado', 'idTipoProcesos', 'nombreTipoProceso', 'nombreMedioControl', 'radicadoJuzgado', 'codigoUnicoJuzgado', 'nombreJuzgado', 'nombreTema', 'nombreEstadoRadicado', 'codigoProceso', 'asunto')
                                ->join('juriinvolucrados', function ($join) {
                                    $join->on('juriradicados.vigenciaRadicado', '=', 'juriinvolucrados.juriradicados_vigenciaRadicado')
                                    ->on('juriradicados.idRadicado', '=', 'juriinvolucrados.juriradicados_idRadicado');
                                })
                                ->leftJoin('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                                ->leftJoin('jurimedioscontrol', 'juriradicados.jurimedioscontrol_idMediosControl', '=', 'jurimedioscontrol.idMediosControl')
                                ->leftJoin('jurijuzgados', 'juriradicados.jurijuzgados_idJuzgado', '=', 'jurijuzgados.idJuzgado')
                                ->leftJoin('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
                                ->leftJoin('juriestadosradicados', 'juriradicados.juriestadosradicados_idEstadoRadicado', '=', 'juriestadosradicados.idEstadoRadicado')
                                ->where('juriabogados_idAbogado', '=', $selectAbogadoDemandante)
                                ->groupBY('juriinvolucrados.juriradicados_idRadicado')
                                ->groupBY('juriinvolucrados.juriradicados_vigenciaRadicado')
                                ->get();
        }# //Abogados demandantes

        if($tipoReporte == 6 && $documentoDemandante != '')//POR DEMANDANTE
        {
            $reportes = DB::table('juriradicados')
                            ->select('idRadicado', 'vigenciaRadicado', 'fechaRadicado', 'idTipoProcesos', 'nombreTipoProceso', 'nombreMedioControl', 'radicadoJuzgado', 'codigoUnicoJuzgado', 'nombreJuzgado', 'nombreTema', 'nombreEstadoRadicado','codigoProceso', 'asunto')
                            ->join('juriinvolucrados', function ($join) {
                                $join->on('juriradicados.vigenciaRadicado', '=', 'juriinvolucrados.juriradicados_vigenciaRadicado')
                                ->on('juriradicados.idRadicado', '=', 'juriinvolucrados.juriradicados_idRadicado');
                            })
                            ->join('solicitantes', 'juriinvolucrados.solicitantes_idSolicitante', '=', 'solicitantes.idSolicitante')
                            ->leftJoin('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                            ->leftJoin('jurimedioscontrol', 'juriradicados.jurimedioscontrol_idMediosControl', '=', 'jurimedioscontrol.idMediosControl')
                            ->leftJoin('jurijuzgados', 'juriradicados.jurijuzgados_idJuzgado', '=', 'jurijuzgados.idJuzgado')
                            ->leftJoin('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
                            ->leftJoin('juriestadosradicados', 'juriradicados.juriestadosradicados_idEstadoRadicado', '=', 'juriestadosradicados.idEstadoRadicado')
                            ->where('documentoSolicitante', '=', $documentoDemandante)
                            ->groupBY('juriinvolucrados.juriradicados_idRadicado')
                            ->groupBY('juriinvolucrados.juriradicados_vigenciaRadicado')
                            ->get();
            
        }# //POR DEMANDANTE

        if($tipoReporte == 7 && $selectJuzgado != '')//Juzgados
        {
            $reportes = DB::table('juriradicados')
                                ->select('idRadicado', 'vigenciaRadicado', 'fechaRadicado', 'idTipoProcesos', 'nombreTipoProceso', 'nombreMedioControl', 'radicadoJuzgado', 'codigoUnicoJuzgado', 'nombreJuzgado', 'nombreTema', 'nombreEstadoRadicado', 'codigoProceso', 'asunto')
                                ->leftJoin('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                                ->leftJoin('jurimedioscontrol', 'juriradicados.jurimedioscontrol_idMediosControl', '=', 'jurimedioscontrol.idMediosControl')
                                ->leftJoin('jurijuzgados', 'juriradicados.jurijuzgados_idJuzgado', '=', 'jurijuzgados.idJuzgado')
                                ->leftJoin('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
                                ->leftJoin('juriestadosradicados', 'juriradicados.juriestadosradicados_idEstadoRadicado', '=', 'juriestadosradicados.idEstadoRadicado')
                                ->whereBetween(DB::raw('substr(fechaRadicado, -19, 10)'),
                                array($fechaInicial, $fechaFinal))
                                ->where('jurijuzgados_idJuzgado', '=', $selectJuzgado)
                                ->get();
        }# //Juzgados

        if($tipoReporte == 8 && $selectSecretaria != '')//Secretarias
        {
            $reportes = DB::table('juriradicados')
                                ->select('idRadicado', 'vigenciaRadicado', 'fechaRadicado', 'idTipoProcesos', 'nombreTipoProceso', 'nombreMedioControl', 'radicadoJuzgado', 'codigoUnicoJuzgado', 'nombreJuzgado', 'nombreTema', 'nombreEstadoRadicado', 'codigoProceso', 'asunto')
                                ->join('juriinvolucrados', function ($join) {
                                    $join->on('juriradicados.vigenciaRadicado', '=', 'juriinvolucrados.juriradicados_vigenciaRadicado')
                                    ->on('juriradicados.idRadicado', '=', 'juriinvolucrados.juriradicados_idRadicado');
                                })
                                ->leftJoin('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                                ->leftJoin('jurimedioscontrol', 'juriradicados.jurimedioscontrol_idMediosControl', '=', 'jurimedioscontrol.idMediosControl')
                                ->leftJoin('jurijuzgados', 'juriradicados.jurijuzgados_idJuzgado', '=', 'jurijuzgados.idJuzgado')
                                ->leftJoin('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
                                ->join('dependencias', 'juriinvolucrados.dependencias_idDependencia', '=', 'dependencias.idDependencia')
                                ->leftJoin('juriestadosradicados', 'juriradicados.juriestadosradicados_idEstadoRadicado', '=', 'juriestadosradicados.idEstadoRadicado')
                                ->whereBetween(DB::raw('substr(fechaRadicado, -19, 10)'),
                                array($fechaInicial, $fechaFinal))
                                ->where('idDependencia', '=', $selectSecretaria)
                                ->groupBY('juriinvolucrados.juriradicados_idRadicado')
                                ->groupBY('juriinvolucrados.juriradicados_vigenciaRadicado')
                                ->get();
        }# //Secretarias

        if($tipoReporte == 9 && $selectTipoActuacion != '')//Tipos de actuación
        {
            $actuacion = 1;
            
            $reportes = DB::table('juriradicados')
                                ->select('idRadicado', 'vigenciaRadicado', 'fechaRadicado', 'idTipoProcesos', 'nombreTipoProceso', 'nombreMedioControl', 'radicadoJuzgado', 'codigoUnicoJuzgado', 'nombreJuzgado', 'nombreTema', 'nombreEstadoRadicado', 'codigoProceso', 'asunto')
                                ->leftJoin('juriactuaciones', function ($join) {
                    $join->on('juriradicados.vigenciaRadicado', '=', 'juriactuaciones.juriradicados_vigenciaRadicado')
                    ->on('juriradicados.idRadicado', '=', 'juriactuaciones.juriradicados_idRadicado');
                })
                ->leftJoin('juritiposactuaciones', 'juriactuaciones.juritiposactuaciones_idTipoActuacion', '=', 'juritiposactuaciones.idTipoActuacion')
                                ->leftJoin('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                                ->leftJoin('jurimedioscontrol', 'juriradicados.jurimedioscontrol_idMediosControl', '=', 'jurimedioscontrol.idMediosControl')
                                ->leftJoin('jurijuzgados', 'juriradicados.jurijuzgados_idJuzgado', '=', 'jurijuzgados.idJuzgado')
                                ->leftJoin('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
                                ->leftJoin('juriestadosradicados', 'juriradicados.juriestadosradicados_idEstadoRadicado', '=', 'juriestadosradicados.idEstadoRadicado')
                                ->whereBetween('juriactuaciones.fechaActuacion', [$fechaInicial, $fechaFinal])
                ->where('juritiposactuaciones_idTipoActuacion', '=', $selectTipoActuacion)
                                ->get();  
        }# //Tipos de actuación

        if($tipoReporte == 10)//Valoraciones del Excel
        {
            $valoraciones = 1;

            /* Consulta anterior jeison (se debe corregir) 
            $reportes = DB::table('juriradicados')
                ->select('idRadicado', 'vigenciaRadicado', 'fechaRadicado', 'nombreMedioControl', 'codigoProceso' ,'fechaNotificacion' , 'juriresponsables.usuarios_idUsuario' ,'nombreJuzgado', 'nombreTipoProceso', 'nombreTema', 'idTipoProcesos', 'radicadoJuzgado', 'codigoUnicoJuzgado', 'fechaValoracionFallo', 'puntajeValoracionFallo', 'nombreEstadoRadicado', 'codigoProceso')
                ->leftJoin('juriestadosetapas', function ($join) {
                    $join->on('juriradicados.vigenciaRadicado', '=', 'juriestadosetapas.juriradicados_vigenciaRadicado')
                    ->on('juriradicados.idRadicado', '=', 'juriestadosetapas.juriradicados_idRadicado');
                })
                ->leftJoin('juriinvolucrados', function ($join) {
                    $join->on('juriradicados.vigenciaRadicado', '=', 'juriinvolucrados.juriradicados_vigenciaRadicado')
                    ->on('juriradicados.idRadicado', '=', 'juriinvolucrados.juriradicados_idRadicado');
                })
                ->leftJoin('jurivaloracionesfallomzl', function ($join) {
                    $join->on('juriradicados.vigenciaRadicado', '=', 'jurivaloracionesfallomzl.juriradicados_vigenciaRadicado')
                    ->on('juriradicados.idRadicado', '=', 'jurivaloracionesfallomzl.juriradicados_idRadicado');
                })
                ->leftJoin('juriresponsables', 'juriestadosetapas.juriresponsables_idResponsable', '=', 'juriresponsables.idResponsable')
                ->leftJoin('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                ->leftJoin('jurimedioscontrol', 'juriradicados.jurimedioscontrol_idMediosControl', '=', 'jurimedioscontrol.idMediosControl')
                ->leftJoin('jurijuzgados', 'juriradicados.jurijuzgados_idJuzgado', '=', 'jurijuzgados.idJuzgado')
                ->leftJoin('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
                ->leftJoin('juriestadosradicados', 'juriradicados.juriestadosradicados_idEstadoRadicado', '=', 'juriestadosradicados.idEstadoRadicado')
                ->whereBetween(DB::raw('substr(fechaRadicado, -19, 10)'),
                array($fechaInicial, $fechaFinal))
                ->groupBY('juriestadosetapas.juriradicados_idRadicado')
                ->groupBY('juriestadosetapas.juriradicados_vigenciaRadicado')
                ->get();
                */


                //consulta tablas diana valoraciones

                $reportes = DB::table('juriradicados')
                ->select('idRadicado', 'vigenciaRadicado', 'fechaRadicado', 'nombreMedioControl', 'codigoProceso' ,'fechaNotificacion' , 'juriresponsables.usuarios_idUsuario' ,'nombreJuzgado', 'nombreTipoProceso', 'nombreTema', 'idTipoProcesos', 'radicadoJuzgado', 'codigoUnicoJuzgado', 'fechaValoracionFallo', 'puntajeValoracionFallo', 'nombreEstadoRadicado', 'codigoProceso', 'juriradicados.mzlConsecutivo', 'asunto')
                ->leftJoin('juriestadosetapas', function ($join) {
                    $join->on('juriradicados.vigenciaRadicado', '=', 'juriestadosetapas.juriradicados_vigenciaRadicado')
                    ->on('juriradicados.idRadicado', '=', 'juriestadosetapas.juriradicados_idRadicado');
                })
                ->leftJoin('juriinvolucrados', function ($join) {
                    $join->on('juriradicados.vigenciaRadicado', '=', 'juriinvolucrados.juriradicados_vigenciaRadicado')
                    ->on('juriradicados.idRadicado', '=', 'juriinvolucrados.juriradicados_idRadicado');
                })
                ->leftJoin('jurivaloracionesfallomzl', function ($join) {
                    $join->on('juriradicados.vigenciaRadicado', '=', 'jurivaloracionesfallomzl.juriradicados_vigenciaRadicado')
                    ->on('juriradicados.idRadicado', '=', 'jurivaloracionesfallomzl.juriradicados_idRadicado');
                })
                ->leftJoin('juriresponsables', 'juriestadosetapas.juriresponsables_idResponsable', '=', 'juriresponsables.idResponsable')
                ->leftJoin('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                ->leftJoin('jurimedioscontrol', 'juriradicados.jurimedioscontrol_idMediosControl', '=', 'jurimedioscontrol.idMediosControl')
                ->leftJoin('jurijuzgados', 'juriradicados.jurijuzgados_idJuzgado', '=', 'jurijuzgados.idJuzgado')
                ->leftJoin('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
                ->leftJoin('juriestadosradicados', 'juriradicados.juriestadosradicados_idEstadoRadicado', '=', 'juriestadosradicados.idEstadoRadicado')
                ->whereBetween(DB::raw('substr(fechaRadicado, -19, 10)'),
                array($fechaInicial, $fechaFinal))
                ->where('juriestadosradicados_idEstadoRadicado', '=', 1) //1 pendiente, 2 terminado
                ->where('juriradicados.juritipoprocesos_idTipoProceso',1)// 1 demandas 2 conciliacion 3 tutelas
                ->groupBY('juriestadosetapas.juriradicados_idRadicado')
                ->groupBY('juriestadosetapas.juriradicados_vigenciaRadicado')
                ->get();


        }# //Valoraciones del fallo

        if($tipoReporte == 11)//POR TEMA
        {
            $reportes = DB::table('juriradicados')
                            ->select('idRadicado', 'vigenciaRadicado', 'fechaRadicado', 'idTipoProcesos', 'nombreTipoProceso', 'nombreMedioControl', 'radicadoJuzgado', 'codigoUnicoJuzgado', 'nombreJuzgado', 'nombreTema', 'nombreEstadoRadicado','codigoProceso', 'asunto')
                            ->join('juriinvolucrados', function ($join) {
                                $join->on('juriradicados.vigenciaRadicado', '=', 'juriinvolucrados.juriradicados_vigenciaRadicado')
                                ->on('juriradicados.idRadicado', '=', 'juriinvolucrados.juriradicados_idRadicado');
                            })
                            ->leftJoin('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                            ->leftJoin('jurimedioscontrol', 'juriradicados.jurimedioscontrol_idMediosControl', '=', 'jurimedioscontrol.idMediosControl')
                            ->leftJoin('jurijuzgados', 'juriradicados.jurijuzgados_idJuzgado', '=', 'jurijuzgados.idJuzgado')
                            ->leftJoin('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
                            ->join('dependencias', 'juriinvolucrados.dependencias_idDependencia', '=', 'dependencias.idDependencia')
                            ->leftJoin('juriestadosradicados', 'juriradicados.juriestadosradicados_idEstadoRadicado', '=', 'juriestadosradicados.idEstadoRadicado')
                            ->where('nombreTema', 'LIKE', '%'.$tema.'%')
                            ->orderBy('juriradicados.fechaRadicado', 'asc')
                            ->groupBY('juriinvolucrados.juriradicados_idRadicado')
                            ->groupBY('juriinvolucrados.juriradicados_vigenciaRadicado')
                            ->get();
        }# //POR TEMA

        if($tipoReporte == 12 && $selectTipoActuacion != '')//Sentencias instancias
        {            
            /*
                Se realiza una validacion con los tipos de actuaciones al 
                no contar con un datos exactos en la bd, esto sucede por que el usuario que
                ingresa los tipos de actuaciones no se fija en que tipo es 
            */
            if($selectTipoActuacion == 48)
            {
                // 47 =>  Fallo de segunda instancia tutelas
                // 48 =>  Fallo de segunda instancia proceso judicial
                // 168 => Finaliza en segunda  instancia tutelas
                $tipoActuacion = [48, 47 , 168 ];
            }
            elseif($selectTipoActuacion == 44)
            {
                //44 =>  Fallo de primera instancia proceso judicial
                //46 =>  Fallo de primera instancia tutelas
                //51 =>  Finaliza en primera instancia tutelas
                //206 => Sentencia de primera instancia
                //207 => Sentencia de primera instancia tutelas
                $tipoActuacion = [44, 46, 51, 206, 207 ]; 

            }
            
            $reportes = DB::table('juriradicados')
                                ->select('idRadicado', 'vigenciaRadicado', 'fechaRadicado', 'idTipoProcesos', 'nombreTipoProceso', 'nombreMedioControl', 'radicadoJuzgado', 'codigoUnicoJuzgado', 'nombreJuzgado', 'nombreTema', 'nombreEstadoRadicado', 'codigoProceso', 'asunto')
                                ->leftJoin('juriactuaciones', function ($join) {
                    $join->on('juriradicados.vigenciaRadicado', '=', 'juriactuaciones.juriradicados_vigenciaRadicado')
                    ->on('juriradicados.idRadicado', '=', 'juriactuaciones.juriradicados_idRadicado');
                })
                ->leftJoin('juritiposactuaciones', 'juriactuaciones.juritiposactuaciones_idTipoActuacion', '=', 'juritiposactuaciones.idTipoActuacion')
                                ->leftJoin('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                                ->leftJoin('jurimedioscontrol', 'juriradicados.jurimedioscontrol_idMediosControl', '=', 'jurimedioscontrol.idMediosControl')
                                ->leftJoin('jurijuzgados', 'juriradicados.jurijuzgados_idJuzgado', '=', 'jurijuzgados.idJuzgado')
                                ->leftJoin('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
                                ->leftJoin('juriestadosradicados', 'juriradicados.juriestadosradicados_idEstadoRadicado', '=', 'juriestadosradicados.idEstadoRadicado')
                                ->whereBetween('juriactuaciones.fechaActuacion', [$fechaInicial, $fechaFinal])
                                ->whereIn('juritiposactuaciones_idTipoActuacion',$tipoActuacion)
                                ->where('juriradicados.juritipoprocesos_idTipoProceso',$selectTipoProceso)
                                ->get(); 

        }# //Sentencias instancias



        if($tipoReporte == 13)//Terminados
        {
            $actuacion = 1;
            
            $reportes = DB::table('juriradicados')
                                ->select('idRadicado', 'vigenciaRadicado', 'fechaRadicado', 'idTipoProcesos', 'nombreTipoProceso', 'nombreMedioControl', 'radicadoJuzgado', 'codigoUnicoJuzgado', 'nombreJuzgado', 'nombreTema', 'nombreEstadoRadicado', 'codigoProceso', 'asunto')
                                ->leftJoin('juriactuaciones', function ($join) {
                    $join->on('juriradicados.vigenciaRadicado', '=', 'juriactuaciones.juriradicados_vigenciaRadicado')
                    ->on('juriradicados.idRadicado', '=', 'juriactuaciones.juriradicados_idRadicado');
                })
                ->leftJoin('juritiposactuaciones', 'juriactuaciones.juritiposactuaciones_idTipoActuacion', '=', 'juritiposactuaciones.idTipoActuacion')
                                ->leftJoin('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                                ->leftJoin('jurimedioscontrol', 'juriradicados.jurimedioscontrol_idMediosControl', '=', 'jurimedioscontrol.idMediosControl')
                                ->leftJoin('jurijuzgados', 'juriradicados.jurijuzgados_idJuzgado', '=', 'jurijuzgados.idJuzgado')
                                ->leftJoin('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
                                ->leftJoin('juriestadosradicados', 'juriradicados.juriestadosradicados_idEstadoRadicado', '=', 'juriestadosradicados.idEstadoRadicado')
                                ->whereBetween('juriactuaciones.fechaActuacion', [$fechaInicial, $fechaFinal])
                                ->where('juritiposactuaciones.tipoActuacionFinaliza', 1)
                                ->where('juriradicados.juritipoprocesos_idTipoProceso', 1)//1 demandas 2 conciliacion 3 tutela 
                                ->groupBy('juriradicados.idRadicado')
                                ->get();  


        }# //Terminados
        if($tipoReporte == 14)//POR TEMA
        {
            $reportes = DB::table('juriradicados')
                            ->select('idRadicado', 'vigenciaRadicado', 'fechaRadicado', 'idTipoProcesos', 'nombreTipoProceso', 'nombreMedioControl', 'radicadoJuzgado', 'codigoUnicoJuzgado', 'nombreJuzgado', 'nombreTema', 'nombreEstadoRadicado','codigoProceso', 'asunto')
                            ->join('juriinvolucrados', function ($join) {
                                $join->on('juriradicados.vigenciaRadicado', '=', 'juriinvolucrados.juriradicados_vigenciaRadicado')
                                ->on('juriradicados.idRadicado', '=', 'juriinvolucrados.juriradicados_idRadicado');
                            })
                            ->leftJoin('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                            ->leftJoin('jurimedioscontrol', 'juriradicados.jurimedioscontrol_idMediosControl', '=', 'jurimedioscontrol.idMediosControl')
                            ->leftJoin('jurijuzgados', 'juriradicados.jurijuzgados_idJuzgado', '=', 'jurijuzgados.idJuzgado')
                            ->leftJoin('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
                            ->join('dependencias', 'juriinvolucrados.dependencias_idDependencia', '=', 'dependencias.idDependencia')
                            ->leftJoin('juriestadosradicados', 'juriradicados.juriestadosradicados_idEstadoRadicado', '=', 'juriestadosradicados.idEstadoRadicado')
                            ->where('asunto', 'LIKE', '%'.$asunto.'%')
                            ->orderBy('juriradicados.fechaRadicado', 'asc')
                            ->groupBY('juriinvolucrados.juriradicados_idRadicado')
                            ->groupBY('juriinvolucrados.juriradicados_vigenciaRadicado')
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
            
            if($tipoReporte == 10)//valoraciones del fallo
            {
               $vista = "reportes.excelReporteValoracion2";
            }
            else
            {
               $vista = "reportes.excelReportes";
            }

            $sheet->loadView($vista)
                            ->with('reportes', $reportes)
                            ->with('fechaReporte', date('Y-m-d'))
                            ->with('actuacion', $actuacion)
                            ->with('valoraciones', $valoraciones);
        });

        })->export('xls');
    }

    public function actionCrearReporte()
    {
        return view('reportes.crearReporte');
    }

    public function actionCrearReporteExcel($vector)
    {
        /*
        //Recupera los vectores formato JSON
		$inscritos = json_decode($jsonInscritos, true);

		//Almacena las personas seleccionadas para inscribir al programa
		for($i=0; $i < count($inscritos); $i++) 
		{

        }
        */

        $datos = json_decode($vector, true);        

        $titulo = "Reporte juridica";

        Excel::create($titulo, function($excel) use ($titulo, $datos ) {

            $entidad = Entidad::find(1);
            $excel->setTitle('Reporte juridica');
            //Busca la entidad
            $reportes = DB::table('juriradicados')
                            ->select('idRadicado', 'vigenciaRadicado', 'fechaRadicado', 'nombreMedioControl', 'codigoProceso' ,'fechaNotificacion' , 'juriresponsables.usuarios_idUsuario' ,'nombreJuzgado', 'nombreTipoProceso', 'nombreTema', 'idTipoProcesos', 'radicadoJuzgado', 'codigoUnicoJuzgado', 'fechaValoracionFallo', 'puntajeValoracionFallo', 'nombreEstadoRadicado', 'codigoProceso', 'juriradicados.mzlConsecutivo', 'asunto')
                            ->leftJoin('juriestadosetapas', function ($join) {
                                $join->on('juriradicados.vigenciaRadicado', '=', 'juriestadosetapas.juriradicados_vigenciaRadicado')
                                ->on('juriradicados.idRadicado', '=', 'juriestadosetapas.juriradicados_idRadicado');
                            })
                            ->leftJoin('juriinvolucrados', function ($join) {
                                $join->on('juriradicados.vigenciaRadicado', '=', 'juriinvolucrados.juriradicados_vigenciaRadicado')
                                ->on('juriradicados.idRadicado', '=', 'juriinvolucrados.juriradicados_idRadicado');
                            })
                            ->leftJoin('jurivaloracionesfallomzl', function ($join) {
                                $join->on('juriradicados.vigenciaRadicado', '=', 'jurivaloracionesfallomzl.juriradicados_vigenciaRadicado')
                                ->on('juriradicados.idRadicado', '=', 'jurivaloracionesfallomzl.juriradicados_idRadicado');
                            })
                            ->leftJoin('juriactuaciones', function ($join) {
                                $join->on('juriradicados.vigenciaRadicado', '=', 'juriactuaciones.juriradicados_vigenciaRadicado')
                                ->on('juriradicados.idRadicado', '=', 'juriactuaciones.juriradicados_idRadicado');
                            })
                            ->leftJoin('dependencias', 'juriinvolucrados.dependencias_idDependencia', '=', 'dependencias.idDependencia')
                            ->leftJoin('juriresponsables', 'juriestadosetapas.juriresponsables_idResponsable', '=', 'juriresponsables.idResponsable')
                            ->leftJoin('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                            ->leftJoin('jurimedioscontrol', 'juriradicados.jurimedioscontrol_idMediosControl', '=', 'jurimedioscontrol.idMediosControl')
                            ->leftJoin('jurijuzgados', 'juriradicados.jurijuzgados_idJuzgado', '=', 'jurijuzgados.idJuzgado')
                            ->leftJoin('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
                            ->leftJoin('juritiposactuaciones', 'juriactuaciones.juritiposactuaciones_idTipoActuacion', '=', 'juritiposactuaciones.idTipoActuacion')
                            ->leftJoin('juriestadosradicados', 'juriradicados.juriestadosradicados_idEstadoRadicado', '=', 'juriestadosradicados.idEstadoRadicado');
                        
            if(!in_array(0, $datos['tipoProceso'] ))// tipo proceso => 1 Proceso Judicial 2 Conciliación Extrajudicial 3 Tutelas
            {
                $reportes->whereIn('juriradicados.juritipoprocesos_idTipoProceso', $datos['tipoProceso']);
            }

            if(!in_array(0, $datos['estadoRadicado'] ))// estadoRadicado => 1 Pendiente 2 terminado 3 cancelado
            {
                $reportes->whereIn('juriradicados.juriestadosradicados_idEstadoRadicado', $datos['estadoRadicado']);
            }

            if(!in_array(0, $datos['medioControl'] ))// medios de control
            {
                $reportes->whereIn('juriradicados.jurimedioscontrol_idMediosControl', $datos['medioControl']);
            }

            if(!in_array(0, $datos['accion'] ))// medios de control
            {
                $reportes->whereIn('juriradicados.juriacciones_idAccion', $datos['accion']);
            }

            if(!in_array(0, $datos['usuario'] ))// funcionarios
            {
                $reportes->whereIn('juriresponsables.usuarios_idUsuario', $datos['usuario']);
            }

            if(!in_array(0, $datos['abogadoDemandante'] ))// Abogados demandantes
            {
                $reportes->whereIn('juriinvolucrados.juriabogados_idAbogado', $datos['abogadoDemandante']);
            }

            if(!in_array(0, $datos['juzgado'] ))// Juzgados
            {
                $reportes->whereIn('juriradicados.jurijuzgados_idJuzgado', $datos['juzgado']);
            }

            if(!in_array(0, $datos['secretaria'] ))// Secretaria
            {
                $reportes->whereIn('juriinvolucrados.dependencias_idDependencia', $datos['secretaria']);
            }

            if(!in_array(0, $datos['tipoActuacion'] ))// Tipos de actuación
            {
                $reportes->whereIn('juriactuaciones.juritiposactuaciones_idTipoActuacion', $datos['tipoActuacion']);
            }

            if(!in_array(0, $datos['falloInstancia'] ))// FALLOS instancias
            {
                $reportes->whereIn('juriactuaciones.juritiposactuaciones_idTipoActuacion', $datos['falloInstancia']);
            }

            $reportes->whereBetween('juriradicados.fechaRadicado', [$datos['fechaInicial'], $datos['fechaFinal']]);
            $reportes->groupBY('juriestadosetapas.juriradicados_idRadicado');
            $reportes->groupBY('juriestadosetapas.juriradicados_vigenciaRadicado');
            $result = $reportes->get();

            $columnas = $datos["columnasSeleccionadas"];

            $excel->sheet('Reporte rango fechas', function($sheet) use ($titulo, $result, $entidad, $columnas) {

                $sheet->mergeCells('C1:E1');
                $sheet->mergeCells('C2:E2');
                $sheet->mergeCells('C3:E3');

                $sheet->cells('C1:E3', function($cells){
                    $cells->setAlignment('center');
                });

                $sheet->setColumnFormat(array('D'=>'0'));
                $sheet->setColumnFormat(array('E'=>'0'));

                //$sheet->setColumnFormat(array('L'=>['alignment' => ['wrapText' => true]]));


                $sheet->fromArray(array(array($entidad->nombreEntidad, ''), array($titulo, '')), null, 'C1', false, false)
                    ->getStyle('K:L')
                    ->getAlignment()
                    ->setWrapText(true);
                
                $sheet->loadView('reportes.excelCrearReportes')
                                ->with('reportes', $result)
                                ->with('columnas', $columnas)
                                ->with('fechaReporte', date('Y-m-d'));
            });
        })->export('xls');
    }

    public function actionFormularioCrearReportes()
    {
        $listaTipoMediosControl =  DB::table('jurimedioscontrol')
                                      ->orderBy('idMediosControl', 'asc')
                                      ->pluck('nombreMedioControl', 'idMediosControl');

        $listaAcciones           = DB::table('juriacciones')
                                     ->orderBy('idAccion', 'asc')
                                     ->pluck('nombreAccion', 'idAccion');

        $listaUsuarios           = DB::table('juriresponsables')
                                     ->join('usuarios', 'juriresponsables.usuarios_idUsuario', '=', 'usuarios.idUsuario')
                                     ->orderBy('idUsuario', 'asc')
                                     ->pluck('nombresUsuario', 'idUsuario');

        $listaEstadosRadicados   = DB::table('juriestadosradicados')
                                     ->orderBy('idEstadoRadicado', 'asc')
                                     ->pluck('nombreEstadoRadicado', 'idEstadoRadicado');

        $listaProcesos           = DB::table('juritipoprocesos')
                                     ->orderBy('idTipoProcesos', 'asc')
                                     ->pluck('nombreTipoProceso', 'idTipoProcesos');

        $listaAbogadosApoderados = DB::table('juriabogados')
                                     ->orderBy('idAbogado', 'asc')
                                     ->pluck('nombreAbogado', 'idAbogado');

        $listaJuzgados           = DB::table('jurijuzgados')
                                     ->orderBy('idJuzgado', 'asc')
                                     ->pluck('nombreJuzgado', 'idJuzgado');

        $listaSecretarias        = DB::table('dependencias')
                                     ->orderBy('idDependencia', 'asc')
                                     ->pluck('nombreDependencia', 'idDependencia');

        $listaTipoActuaciones    = DB::table('juritiposactuaciones')
                                     ->orderBy('idTipoActuacion', 'asc')
                                     ->pluck('nombreActuacion', 'idTipoActuacion');

        $listaFallosInstancias   = DB::table('juritiposactuaciones')
                                     ->orderBy('idTipoActuacion', 'asc')
                                     ->whereIn('idTipoActuacion',[44, 48])
                                     ->pluck('nombreActuacion', 'idTipoActuacion');
                            
        //Columnas
        $columnas = array(
            array("id" => 1, "columna" => "Número Interno del sistema"),
            array("id" => 2, "columna" => "Fecha Radicado"),
            array("id" => 3, "columna" => "Estado Radicado"),
            array("id" => 4, "columna" => "Código Proceso"),
            array("id" => 5, "columna" => "Radicado del juzgado"),
            array("id" => 6, "columna" => "Tipo de proceso"),
            array("id" => 7, "columna" => "Medio de control"),
            array("id" => 8, "columna" => "Apoderado"),
            array("id" => 9, "columna" => "Dependencia afectada"),
            array("id" => 10, "columna" => "Juzgado"),
            array("id" => 11, "columna" => "Demandantes"),
            array("id" => 20, "columna" => "Demandantes con cedula"),
            array("id" => 12, "columna" => "Tema"),
            array("id" => 13, "columna" => "Cuantías"),
            array("id" => 14, "columna" => "Último estado"),
            array("id" => 15, "columna" => "Sentido del fallo de primera instancia"),
            array("id" => 16, "columna" => "Fecha sentencia de primera instancia"),
            array("id" => 17, "columna" => "Sentido del fallo de segunda instancia"),
            array("id" => 18, "columna" => "Fecha sentencia de segunda instancia"),
            array("id" => 19, "columna" => "Asunto")
        );

        return view('ajax_reportes.ajaxFormularioCrearReporte')
                   ->with('listaTipoMediosControl',$listaTipoMediosControl)
                   ->with('listaAcciones',$listaAcciones)
                   ->with('listaUsuarios',$listaUsuarios)
                   ->with('listaEstadosRadicados',$listaEstadosRadicados)
                   ->with('listaProcesos',$listaProcesos)
                   ->with('listaAbogadosApoderados',$listaAbogadosApoderados)
                   ->with('listaJuzgados',$listaJuzgados)
                   ->with('listaSecretarias',$listaSecretarias)
                   ->with('listaFallosInstancias',$listaFallosInstancias)
                   ->with('listaTipoActuaciones',$listaTipoActuaciones)
                   ->with('columnas',$columnas);
    }
}
