<?php
namespace SQ10\Http\Controllers;

use DB;
use Excel;
use Illuminate\Http\Request;
use Session;
use SQ10\Models\TipoActoAdministrativo;
use SQ10\Models\Entidad;
use SQ10\Models\Usuario;

class TipoActoAdministrativoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function actionIndextipoacto()
    {
        return view('tiposactosadministrativos/index');
    }

    public function actionTablaTiposActos(Request $request)
    {
        $tiposActosAdministrativos = DB::table('juritiposactosadministrativos')
                ->get();

        return view('ajax_tiposActodAdministrativos.ajaxTablaTiposActosAdministrativos')
                    ->with('tiposActosAdministrativos', $tiposActosAdministrativos);  
    }

    public function actionAgregarTipoActoAdministrativo(Request $request)
    {
        return view('ajax_tiposActodAdministrativos.ajaxAgregarTipoActoAdministrativo');  
    }

    public function actionValidarGuardarTipoActo(Request $request)
    {
        $tipoActo  = new TipoActoAdministrativo;
        $tipoActo->nombreTipoActo = $request->input('nombreTipoActo');
        $tipoActo->save();

        return 1;// guarda tipo acto administrativo
    }

    public function actionEditarTipoActo(Request $request)
    {
        $tipoActo = DB::table('juritiposactosadministrativos')
                ->where('idTipoActo', '=', $request->input('idTipoActo'))
                ->get();

        return view('ajax_tiposActodAdministrativos.ajaxEditarTipoActoAdministrativo')
                ->with('tipoActo', $tipoActo);  
    }

    public function actionValidarEditarTipoActo(Request $request)
    {
        DB::table('juritiposactosadministrativos')
                ->where('idTipoActo', $request->input('idTipoActo'))
                ->update([
                    'nombreTipoActo' => $request->input('nombreTipoActoEditar')]);

        return 1; // se modificaron los datos del tipo de acto
    }

    public function actionValidarEliminarTipoActo(Request $request)
    {
        $tipoActoEnProceso = DB::table('juriradicadoacto')
                        ->where('juritiposactosadministrativos_idTipoActo', '=', $request->input('idTipoActo'))
                        ->count();

        if($tipoActoEnProceso == 0)
        {
            TipoActoAdministrativo::where('idTipoActo', '=', $request->input('idTipoActo'))->delete();
            return 1;// eliminar dependencia 
        }
        else
        {
            return 2;// no se puede eliminar porque lo utiliza al menos un proceso
        }
    }
}