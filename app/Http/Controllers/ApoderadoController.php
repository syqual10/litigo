<?php
namespace SQ10\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Session;
use SQ10\helpers\Util as Util;
use SQ10\Models\EstadoEtapa;

class ApoderadoController extends Controller
{
  	public function __construct()
    {
        $this->middleware('auth');
    }

    public function actionIndex()
    {
        return view('apoderados/index');
    }

    public function actionBuscarProcesoApoderado(Request $request)
    {
        if($request->input('selectMetodoBusquedaApoderado') == 1)// por radicado interno
        {
            $procesos = DB::table('juriradicados')
                ->leftJoin('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                ->leftJoin('jurijuzgados', 'juriradicados.jurijuzgados_idJuzgado', '=', 'jurijuzgados.idJuzgado')
                ->where('vigenciaRadicado', '=', $request->input('vigenciaProcesoBuscarApoderado'))
                ->where('idRadicado', '=', $request->input('criterioBusquedaApoderado'))
                ->get();
        }
        else//por radicado del juzgado
        {

            $radicadoJuzgado = str_replace("-","",$request->input('criterioBusquedaApoderado'));
            $q = "+".preg_replace( '/\s(\w+)/', ' +\\1', $radicadoJuzgado);

            $procesos = DB::table('juriradicados')
                ->leftJoin('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                ->leftJoin('jurijuzgados', 'juriradicados.jurijuzgados_idJuzgado', '=', 'jurijuzgados.idJuzgado')
                ->whereRaw('MATCH(radicadoJuzgado) AGAINST(? IN BOOLEAN MODE)', array($q))
                ->orWhere("radicadoJuzgado", $radicadoJuzgado)
                ->orWhere("radicadoJuzgado", 'like' , '%'.$radicadoJuzgado.'%')
                ->get();
        }

        return view('ajax_apoderados.ajaxTablaProcesoApoderados')
                    ->with('procesos', $procesos);
    }

    public function actionApoderadosRadicado(Request $request)
    {
        $apoderados  = Util::apoderadosActivosRadicado($request->input('vigenciaRadicado'), $request->input('idRadicado'));

        return view('ajax_apoderados.ajaxTablaApoderados')
                    ->with('apoderados', $apoderados)
                    ->with('idRadicado', $request->input('idRadicado'))
                    ->with('vigenciaRadicado', $request->input('vigenciaRadicado'));  
    }

    public function actionValidarEliminarApoderado(Request $request)
    {
        $idUsuario = Session::get('idUsuario');
        $responsable = Util::datosResponsable($idUsuario);
        $comentario = " Apoderado eliminado en el proceso por ".$responsable->nombresUsuario;

        $responsableTitular = DB::table('juriradicados')
                ->where('juriresponsables_idResponsable_titular', '=', $responsable->idResponsable)
                ->where('vigenciaRadicado', '=',  $request->input('vigenciaRadicado'))
                ->where('idRadicado', '=',  $request->input('idRadicado'))
                ->count();

        if(count($responsableTitular) > 0)
        {
            DB::table('juriradicados')
                    ->where('vigenciaRadicado', $request->input('vigenciaRadicado'))
                    ->where('idRadicado', $request->input('idRadicado'))
                    ->update([
                            'juriresponsables_idResponsable_titular' => Null]);
        }

        DB::table('juriestadosetapas')
                    ->where('idEstadoEtapa', $request->input('idEstadoEtapa'))
                    ->update([
                            'fechaFinalEstado'                          => date("Y-m-d H:i:s"),
                            'comentarioEstadoEtapa'                     
                                                                        => $comentario,
                            'juritipoestadosetapas_idTipoEstadoEtapa'   => 2]);//gestionado

        return; 
    }

    public function actionAgregarApoderado(Request $request)
    {
        $listaApoderados = DB::table('juriresponsables')
                            ->join('usuarios' , 'juriresponsables.usuarios_idUsuario', 'usuarios.idUsuario')
                            ->where('estadoResponsable', '=', 1)
                            ->orderBy('idResponsable', 'asc')
                            ->pluck('nombresUsuario', 'idResponsable');

        return view('ajax_apoderados.ajaxAgregarApoderado')
                    ->with('idRadicado', $request->input('idRadicado'))
                    ->with('vigenciaRadicado', $request->input('vigenciaRadicado'))
                    ->with('listaApoderados', $listaApoderados);  
    }

    public function actionValidarGuardarNuevoApoderado(Request $request)
    {
        $idUsuario = Session::get('idUsuario');
        $responsable = Util::datosResponsable($idUsuario);

        $estadoEtapa = new EstadoEtapa;
        $estadoEtapa->fechaInicioEstado                        = date("Y-m-d H:i:s");
        $estadoEtapa->juritipoestadosetapas_idTipoEstadoEtapa  = 2;// Etapa de admin
        $estadoEtapa->comentarioEstadoEtapa                    = $request->input('comentarioApoderado');
        $estadoEtapa->juriradicados_vigenciaRadicado           = $request->input('vigenciaRadicado');
        $estadoEtapa->juriradicados_idRadicado                 = $request->input('idRadicado');
        $estadoEtapa->juriresponsables_idResponsable           = $responsable->idResponsable;
        $estadoEtapa->juritiposestados_idTipoEstado            = 5;//apoderado agregado
        $estadoEtapa->save();

        if($request->input('selectPrincipal') == 1)
        {
            DB::table('juriradicados')
                    ->where('vigenciaRadicado', $request->input('vigenciaRadicado'))
                    ->where('idRadicado', $request->input('idRadicado'))
                    ->update([ 'juriresponsables_idResponsable_titular' 
                                                => $request->input('selectApoderadoNuevo')]);
        }

        $estadoEtapa = new EstadoEtapa;
        $estadoEtapa->fechaInicioEstado                        = date("Y-m-d H:i:s");
        $estadoEtapa->juritipoestadosetapas_idTipoEstadoEtapa  = 1;// Actual estado
        $estadoEtapa->juriradicados_vigenciaRadicado           = $request->input('vigenciaRadicado');
        $estadoEtapa->juriradicados_idRadicado                 = $request->input('idRadicado');
        $estadoEtapa->juriresponsables_idResponsable           = $request->input('selectApoderadoNuevo');
        $estadoEtapa->juritiposestados_idTipoEstado            = 3;
        $estadoEtapa->save();

        return;
    }
}