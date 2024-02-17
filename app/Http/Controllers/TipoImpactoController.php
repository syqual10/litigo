<?php
namespace SQ10\Http\Controllers;

use DB;
use Excel;
use Illuminate\Http\Request;
use Session;
use SQ10\Models\Entidad;
use SQ10\Models\TipoImpacto;
use SQ10\Models\Usuario;

class TipoImpactoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function actionIndextipoimpacto()
    {
        return view('tiposImpacto/index');
    }

    public function actionTablaImpactos(Request $request)
    {
        $impactos = DB::table('juriimpactos')
                ->get();

        return view('ajax_tiposImpactos.ajaxTablaImpactos')
                    ->with('impactos', $impactos);  
    }

    public function actionAgregarImpacto(Request $request)
    {
        return view('ajax_tiposImpactos.ajaxAgregarImpacto');  
    }

    public function actionValidarGuardarImpacto(Request $request)
    {
        $impacto  = new TipoImpacto;
        $impacto->nombreImpacto = $request->input('nombreImpacto');
        $impacto->save();

        return 1;// guarda el impacto
    }

    public function actionEditarImpacto(Request $request)
    {
        $impacto = DB::table('juriimpactos')
                ->where('idImpacto', '=', $request->input('idImpacto'))
                ->get();

        return view('ajax_tiposImpactos.ajaxEditarImpacto')
                ->with('impacto', $impacto);  
    }

    public function actionValidarEditarImpacto(Request $request)
    {
        DB::table('juriimpactos')
                ->where('idImpacto', $request->input('idImpacto'))
                ->update([
                    'nombreImpacto' => $request->input('nombreImpactoEditar')]);

        return 1; // se modificaron los datos del impacto
    }

    public function actionValidarEliminarImpacto(Request $request)
    {
        $impactoEnProceso = DB::table('juriradicados')
                ->where('juriimpactos_idImpacto', '=', $request->input('idImpacto'))
                ->count();

        if($impactoEnProceso == 0)
        {
            TipoImpacto::where('idImpacto', '=', $request->input('idImpacto'))->delete();
            return 1;// eliminar impacto
        }
        else
        {
            return 2;// no se puede eliminar porque lo utiliza al menos un radicado
        }
    }
}