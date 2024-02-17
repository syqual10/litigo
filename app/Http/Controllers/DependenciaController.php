<?php
namespace SQ10\Http\Controllers;

use DB;
use Excel;
use Illuminate\Http\Request;
use Session;
use SQ10\Models\Dependencia;
use SQ10\Models\Entidad;
use SQ10\Models\Cargo;
use SQ10\Models\Usuario;

class DependenciaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function actionIndexdependencias()
    {
        return view('dependencias/index');
    }

    public function actionTablaDependencias(Request $request)
    {
        $dependencias = DB::table('dependencias')
                ->get();

        return view('ajax_dependencias.ajaxTablaDependencias')
                    ->with('dependencias', $dependencias);  
    }

    public function actionAgregarDependencia(Request $request)
    {
        $listaDependencias = DB::table('dependencias')
            ->orderBy('idDependencia', 'asc')
            ->pluck('nombreDependencia', 'idDependencia');

        return view('ajax_dependencias.ajaxAgregarDependencia')
                    ->with('listaDependencias', $listaDependencias); 
    }

    public function actionValidarGuardarDependencia(Request $request)
    {
        $dependencia  = new Dependencia;
        $dependencia->codigoDependencia = $request->input('codigoDependencia');
        $dependencia->nombreDependencia=$request->input('nombreDependencia');
        $dependencia->propositoDependencia=$request->input('propositoDependencia');
        $dependencia->dependencias_idDependencia=$request->input('selectDependencia');// acá cuando capture el select
        $dependencia->save();

        return 1;// guarda dependencia
    }

    public function actionEditarDependencia(Request $request)
    {
        $dependencia = DB::table('dependencias')
                ->where('idDependencia', '=', $request->input('idDependencia'))
                ->get();

        $listaDependencias = DB::table('dependencias')
            ->orderBy('idDependencia', 'asc')
            ->pluck('nombreDependencia', 'idDependencia');

        return view('ajax_dependencias.ajaxEditarDependencia')
                ->with('dependencia', $dependencia)
                ->with('listaDependencias', $listaDependencias);  
    }

    public function actionValidarEditarDependencia(Request $request)
    {
        DB::table('dependencias')
                ->where('idDependencia', $request->input('idDependencia'))
                ->update([
                    'codigoDependencia' => $request->input('codigoDependenciaEditar'),
                    'nombreDependencia' => $request->input('nombreDependenciaEditar'),
                    'propositoDependencia' => $request->input('propositoDependenciaEditar'),
                    'dependencias_idDependencia' => $request->input('selectDependenciaEditar')]);

        return 1; // se modificaron los datos de la dependencia
    }

    public function actionValidarEliminarDependencia(Request $request)
    {
        $cargoEnUsuario = DB::table('usuarios')
                        ->where('dependencias_idDependencia', '=', $request->input('idDependencia'))
                        ->count();

        if($cargoEnUsuario == 0)
        {
            Dependencia::where('idDependencia', '=', $request->input('idDependencia'))->delete();
            return 1;// eliminar dependencia 
        }
        else
        {
            return 2;// no se puede eliminar porque lo utiliza al menos un usuario
        }
    }
}