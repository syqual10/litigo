<?php
namespace SQ10\Http\Controllers;

use DB;
use Excel;
use Illuminate\Http\Request;
use Session;
use SQ10\Models\Dependencia;
use SQ10\Models\Entidad;
use SQ10\Models\Causa;
use SQ10\Models\Usuario;

class CausaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function actionIndexcausa()
    {
        return view('causas/index');
    }

    public function actionTablaCausa(Request $request)
    {
        $causas = DB::table('juricausas')
                ->get();

        return view('ajax_causas.ajaxTablaCausas')
                    ->with('causas', $causas);  
    }

    public function actionAgregarCausa(Request $request)
    {
        return view('ajax_causas.ajaxAgregarCausa');  
    }

    public function actionValidarGuardarCausa(Request $request)
    {
        $causa  = new Causa;
        $causa->nombreCausa = $request->input('nombreCausa');
        $causa->save();

        return 1;// guarda causa
    }

    public function actionEditarCausa(Request $request)
    {
        $causa = DB::table('juricausas')
                ->where('idCausa', '=', $request->input('idCausa'))
                ->get();

        return view('ajax_causas.ajaxEditarCausa')
                ->with('causa', $causa);  
    }

    public function actionValidarEditarCausa(Request $request)
    {
        DB::table('juricausas')
                ->where('idCausa', $request->input('idCausa'))
                ->update([
                    'nombreCausa' => $request->input('nombreCausaEditar')]);

        return 1; // se modificaron los datos de la causa
    }

    public function actionValidarEliminarCausa(Request $request)
    {
        $causaEnRadicado = DB::table('juricausasradicados')
                        ->where('juricausas_idCausa', '=', $request->input('idCausa'))
                        ->count();

        if($causaEnRadicado == 0)
        {
            Causa::where('idCausa', '=', $request->input('idCausa'))->delete();
            return 1;// eliminar causa 
        }
        else
        {
            return 2;// no se puede eliminar porque lo utiliza al menos un radicado
        }
    }
}