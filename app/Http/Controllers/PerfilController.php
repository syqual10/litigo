<?php
namespace SQ10\Http\Controllers;

use DB;
use Excel;
use Illuminate\Http\Request;
use Session;
use SQ10\Models\Entidad;
use SQ10\Models\Perfil;
use SQ10\Models\Usuario;

class PerfilController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

    public function actionIndexperfil()
    {
        return view('perfiles/index');
    }

    public function actionTablaPerfiles(Request $request)
    {
        $perfiles = DB::table('juriperfiles')
                ->get();

        return view('ajax_perfiles.ajaxTablaPerfiles')
                    ->with('perfiles', $perfiles);  
    }

    public function actionAgregarPerfiles(Request $request)
    {
        return view('ajax_perfiles.ajaxAgregarPerfil');  
    }

    public function actionValidarGuardarPerfiles(Request $request)
    {
        $perfil  = new Perfil;
        $perfil->nombrePerfil=$request->input('nombrePerfil');
        $perfil->save();

        return 1;// guarda perfil
    }

    public function actionEditarPerfiles(Request $request)
    {
        $perfil = DB::table('juriperfiles')
                ->where('idPerfil', '=', $request->input('idPerfil'))
                ->get();

        return view('ajax_perfiles.ajaxEditarPerfil')
                ->with('perfil', $perfil);  
    }

    public function actionValidarEditarPerfiles(Request $request)
    {
        DB::table('juriperfiles')
                ->where('idPerfil', $request->input('idPerfil'))
                ->update([
                    'nombrePerfil' => $request->input('nombrePerfilEditar')]);

        return 1; // perfil modificado
    }

    public function actionValidarEliminarPerfiles(Request $request)
    {
        $perfilEnResponsable = DB::table('juriresponsables')
                ->where('juriperfiles_idPerfil', '=', $request->input('idPerfil'))
                ->count();

        if($perfilEnResponsable == 0)
        {
            Perfil::where('idPerfil', '=', $request->input('idPerfil'))->delete();
            return 1;// eliminar perfil 
        }
        else
        {
            return 2;// no se puede eliminar porque lo utiliza un usuario
        }
    }
}