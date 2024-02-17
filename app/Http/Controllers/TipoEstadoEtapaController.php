<?php
namespace SQ10\Http\Controllers;

use DB;
use Excel;
use Illuminate\Http\Request;
use Session;
use SQ10\Models\Entidad;
use SQ10\Models\TipoEstadoEtapa;
use SQ10\Models\Usuario;

class TipoEstadoEtapaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function actionIndextipoestadoEtapa()
    {
        return view('tipoEstadoEtapa/index');
    }

    public function actionTablaTipoEstadoEtapa(Request $request)
    {
        $tipoEstadoEtapa = DB::table('juritipoestadoetapa')
                ->get();

        return view('ajax_tiposEstadoEtapa.ajaxTablaTipoEstadoEtapa')
                    ->with('tipoEstadoEtapa', $tipoEstadoEtapa);  
    }

    public function actionAgregarTipoEstadoEtapa(Request $request)
    {
        return view('ajax_tiposEstadoEtapa.ajaxAgregarTipoEstadoEtapa');  
    }

    public function actionValidarGuardarTipoEstadoEtapa(Request $request)
    {
        $tipoEstadoEtapa  = new TipoEstadoEtapa;
        $tipoEstadoEtapa->nombreTipoEstadoEtapa = $request->input('nombreTipoEstadoEtapa');
        $tipoEstadoEtapa->save();

        return 1;// guarda tipo Estado Etapa
    }

    public function actionEditarTipoEstadoEtapa(Request $request)
    {
        $tipoEstadoEtapa = DB::table('juritipoestadoetapa')
                ->where('idTipoEstadoEtapa', '=', $request->input('idTipoEstadoEtapa'))
                ->get();

        return view('ajax_tiposEstadoEtapa.ajaxEditarTipoEstadoEtapa')
                ->with('tipoEstadoEtapa', $tipoEstadoEtapa);  
    }

    public function actionValidarEditarTipoEstadoEtapa(Request $request)
    {
        DB::table('juritipoestadoetapa')
                ->where('idTipoEstadoEtapa', $request->input('idTipoEstadoEtapa'))
                ->update([
                    'nombreTipoEstadoEtapa' => $request->input('nombreTipoEstadoEtapaEditar')]);

        return 1; // se modificaron los datos del tipo estado etapa
    }

    public function actionValidarEliminarTipoEstadoEtapa(Request $request)
    {
        $tipoEstadoEtapaEnProceso = DB::table('juriestadosetapas')
                ->where('juritipoestadosetapas_idTipoEstadoEtapa', '=', $request->input('idTipoEstadoEtapa'))
                ->count();

        if($tipoEstadoEtapaEnProceso == 0)
        {
            TipoEstadoEtapa::where('idTipoEstadoEtapa', '=', $request->input('idTipoEstadoEtapa'))->delete();
            return 1;// eliminar tipo estado etapa 
        }
        else
        {
            return 2;// no se puede eliminar porque lo utiliza al menos un proceso
        }
    }
}