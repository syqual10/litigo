<?php
namespace SQ10\Http\Controllers;

use DB;
use Excel;
use Illuminate\Http\Request;
use Session;
use SQ10\Models\Entidad;
use SQ10\Models\AccionDefensa;

class AccionDefensaController extends Controller
{
  	public function __construct()
    {
        $this->middleware('auth');
    }

    public function actionIndexaccionesDefensa()
    {
        return view('accionDefensa/index');
    }

    public function actionTablaAccionDefensa(Request $request)
    {
        $accionesDefensa = DB::table('juriacciones')
                ->get();

        return view('ajax_accionesDefensa.ajaxTablaAccionesDefensa')
                    ->with('accionesDefensa', $accionesDefensa);  
    }

    public function actionAgregarAccionDefensa(Request $request)
    {
        return view('ajax_accionesDefensa.ajaxAgregarAccionDefensa');  
    }

    public function actionValidarGuardarAccionDefensa(Request $request)
    {
        $accionDefensa  = new AccionDefensa;
        $accionDefensa->nombreAccion=$request->input('nombreAccionDefensa');
        $accionDefensa->save();

        return 1;// guarda acción de defensa
    }

    public function actionEditarAccionDefensa(Request $request)
    {
    	$accionDefensa = DB::table('juriacciones')
                ->where('idAccion', '=', $request->input('idAccionDefensa'))
                ->get();

        return view('ajax_accionesDefensa.ajaxEditarAccionDefensa')
        			->with('accionDefensa', $accionDefensa);  ;  
    }

    public function actionValidarEditarAccionDefensa(Request $request)
    {
        DB::table('juriacciones')
                ->where('idAccion', $request->input('idAccionDefensa'))
                ->update([
                    'nombreAccion' => $request->input('nombreAccionDefensaEditar')]);

        return 1; // se modificaron los datos de la acción de defensa
    }

    public function actionValidarEliminarAccionDefensa(Request $request)
    {
        $accionDefensaEnRadicado = DB::table('juriradicados')
                ->where('juriacciones_idAccion', '=', $request->input('idAccionDefensa'))
                ->count();

        if($accionDefensaEnRadicado == 0)
        {
            AccionDefensa::where('idAccion', '=', $request->input('idAccionDefensa'))->delete();
            return 1;// eliminar acción defensa 
        }
        else
        {
            return 2;// no se puede eliminar porque esta siendo utilizado por un radicado
        }
    }
}