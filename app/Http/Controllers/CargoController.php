<?php
namespace SQ10\Http\Controllers;

use DB;
use Excel;
use Illuminate\Http\Request;
use Session;
use SQ10\Models\Entidad;
use SQ10\Models\Cargo;
use SQ10\Models\Usuario;

class CargoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function actionIndexcargos()
    {
        return view('cargos/index');
    }

    public function actionTablaCargos(Request $request)
    {
        $cargos = DB::table('cargos')
                ->get();

        return view('ajax_cargos.ajaxTablaCargos')
                    ->with('cargos', $cargos);  
    }

    public function actionAgregarCargo(Request $request)
    {
        return view('ajax_cargos.ajaxAgregarCargo');  
    }

    public function actionValidarGuardarCargo(Request $request)
    {
        $cargo  = new Cargo;
        $cargo->codigoCargo = $request->input('codigoCargo');
        $cargo->nombreCargo=$request->input('nombreCargo');
        $cargo->save();

        return 1;// guarda cargo
    }

    public function actionEditarCargo(Request $request)
    {
        $cargo = DB::table('cargos')
                ->where('idCargo', '=', $request->input('idCargo'))
                ->get();

        return view('ajax_cargos.ajaxEditarCargo')
                ->with('cargo', $cargo);  
    }

    public function actionValidarEditarCargo(Request $request)
    {
        DB::table('cargos')
                ->where('idCargo', $request->input('idCargo'))
                ->update([
                    'codigoCargo' => $request->input('codigoCargoEditar'),
                    'nombreCargo' => $request->input('nombreCargoEditar')]);

        return 1; // se modificaron los datos del cargo
    }

    public function actionValidarEliminarCargo(Request $request)
    {
        $cargoEnUsuario = DB::table('usuarios')
                ->where('cargos_idCargo', '=', $request->input('idCargo'))
                ->count();

        if($cargoEnUsuario == 0)
        {
            Cargo::where('idCargo', '=', $request->input('idCargo'))->delete();
            return 1;// eliminar cargo 
        }
        else
        {
            return 2;// no se puede eliminar porque lo utiliza al menos un usuario
        }
    }
}