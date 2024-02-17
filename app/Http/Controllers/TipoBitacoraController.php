<?php
namespace SQ10\Http\Controllers;

use DB;
use Excel;
use Illuminate\Http\Request;
use Session;
use SQ10\Models\Entidad;
use SQ10\Models\TipoBitacora;
use SQ10\Models\Usuario;

class TipoBitacoraController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function actionIndextipoBitacora()
    {
        return view('tipoBitacora/index');
    }

    public function actionTablaTipoBitacora(Request $request)
    {
        $tiposBitacora = DB::table('juritipobitacoras')
                ->get();

        return view('ajax_tipoBitacoras.ajaxTablaTipoBitacora')
                    ->with('tiposBitacora', $tiposBitacora);  
    }

    public function actionAgregarTipoBitacora(Request $request)
    {
        return view('ajax_tipoBitacoras.ajaxAgregarTipoBitacora');  
    }

    public function actionValidarGuardarTipoBitacora(Request $request)
    {
        $tipoBitacora  = new TipoBitacora;
        $tipoBitacora->nombreTipoBitacora = $request->input('nombreTipoBitacora');
        $tipoBitacora->save();

        return 1;// guarda tipo bitácora
    }

    public function actionEditarTipoBitacora(Request $request)
    {
        $tipoBitacora = DB::table('juritipobitacoras')
                ->where('idTipoBitacora', '=', $request->input('idTipoBitacora'))
                ->get();

        return view('ajax_tipoBitacoras.ajaxEditarTipoBitacora')
                ->with('tipoBitacora', $tipoBitacora);  
    }

    public function actionValidarEditarTipoBitacora(Request $request)
    {
        DB::table('juritipobitacoras')
                ->where('idTipoBitacora', $request->input('idTipoBitacora'))
                ->update([
                    'nombreTipoBitacora' => $request->input('nombreTipoBitacoraEditar')]);

        return 1; // se modificaron los datos del tipo de bitácora
    }

    public function actionValidarEliminarTipoBitacora(Request $request)
    {
        $tipoBitacoraEnBitacora = DB::table('juribitacoras')
                ->where('juritiposbitacoras_idTipoBitacora', '=', $request->input('idTipoBitacora'))
                ->count();

        if($tipoBitacoraEnBitacora == 0)
        {
            TipoBitacora::where('idTipoBitacora', '=', $request->input('idTipoBitacora'))->delete();
            return 1;// eliminar tipo bitácora 
        }
        else
        {
            return 2;// no se puede eliminar porque lo utiliza al menos una bitácora
        }
    }
}