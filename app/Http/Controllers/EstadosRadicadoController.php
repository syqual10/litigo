<?php
namespace SQ10\Http\Controllers;

use DB;
use Excel;
use Illuminate\Http\Request;
use Session;
use SQ10\Models\Entidad;
use SQ10\Models\EstadosRadicado;

class EstadosRadicadoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function actionIndexestadosRadicado()
    {
        return view('estadosRadicado/index');
    }

    public function actionTablaEstadosRadicado(Request $request)
    {
        $estadosRadicado = DB::table('juriestadosradicados')
                ->get();

        return view('ajax_estadosRadicado.ajaxTablaEstadosRadicado')
                    ->with('estadosRadicado', $estadosRadicado);  
    }

    public function actionAgregarEstadosRadicado(Request $request)
    {
        return view('ajax_estadosRadicado.ajaxAgregarEstadoRadicado');  
    }

    public function actionValidarGuardarEstadosRadicado(Request $request)
    {
        $estadoRadicado  = new EstadosRadicado;
        $estadoRadicado->nombreEstadoRadicado=$request->input('nombreEstadoRadicado');
        $estadoRadicado->save();

        return 1;// guarda estado del radicado
    }

    public function actionEditarEstadosRadicado(Request $request)
    {
        $estadosRadicado = DB::table('juriestadosradicados')
                ->where('idEstadoRadicado', '=', $request->input('idEstadoRadicado'))
                ->get();

        return view('ajax_estadosRadicado.ajaxEditarEstadosRadicado')
                ->with('estadosRadicado', $estadosRadicado);  
    }

    public function actionValidarEditarEstadosRadicado(Request $request)
    {
        DB::table('juriestadosradicados')
                ->where('idEstadoRadicado', $request->input('idEstadoRadicado'))
                ->update([
                    'nombreEstadoRadicado' => $request->input('nombreEstadoRadicadoEditar')]);

        return 1; // se modificaron los datos del estado del radicado
    }

    public function actionValidarEliminarEstadosRadicado(Request $request)
    {
        $estadoRadicadoEnProceso = DB::table('juriradicados')
                ->where('juriestadosradicados_idEstadoRadicado', '=', $request->input('idEstadoRadicado'))
                ->count();

        if($estadoRadicadoEnProceso == 0)
        {
            EstadosRadicado::where('idEstadoRadicado', '=', $request->input('idEstadoRadicado'))->delete();
            return 1;// eliminar estado de radicado 
        }
        else
        {
            return 2;// no se puede eliminar porque lo utiliza al menos un proceso
        }
    }
}