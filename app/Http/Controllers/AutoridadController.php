<?php
namespace SQ10\Http\Controllers;

use DB;
use Excel;
use Illuminate\Http\Request;
use Session;
use SQ10\Models\Autoridad;
use SQ10\Models\Entidad;
use SQ10\Models\Cargo;
use SQ10\Models\Usuario;

class AutoridadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function actionIndexautoridad()
    {
        return view('autoridad/index');
    }

    public function actionTablaAutoridades(Request $request)
    {
        $autoridades = DB::table('juriautoridadconoce')
                ->get();

        return view('ajax_autoridad.ajaxTablaAutoridad')
                    ->with('autoridades', $autoridades);  
    }

    public function actionAgregarAutoridad(Request $request)
    {
        return view('ajax_autoridad.ajaxAgregarAutoridad');  
    }

    public function actionValidarGuardarAutoridad(Request $request)
    {
        $autoridad  = new Autoridad;
        $autoridad->nombreAutoridadConoce = $request->input('nombreAutoridad');
        $autoridad->save();

        return 1;// guarda autoridad
    }

    public function actionEditarAutoridad(Request $request)
    {
        $autoridad = DB::table('juriautoridadconoce')
                ->where('idAutoridadConoce', '=', $request->input('idAutoridad'))
                ->get();

        return view('ajax_autoridad.ajaxEditarAutoridad')
                ->with('autoridad', $autoridad);  
    }

    public function actionValidarModificarAutoridad(Request $request)
    {
        DB::table('juriautoridadconoce')
                ->where('idAutoridadConoce', $request->input('idAutoridad'))
                ->update([
                    'nombreAutoridadConoce' => $request->input('nombreAutoridadEditar')]);

        return 1; // se modificaron los datos de la autoridad
    }

    public function actionValidarEliminarAutoridad(Request $request)
    {
        Autoridad::where('idAutoridadConoce', '=', $request->input('idAutoridad'))->delete();
        return;// eliminar autoridad 
       
    }
}