<?php
namespace SQ10\Http\Controllers;

use DB;
use Excel;
use Illuminate\Http\Request;
use Session;
use SQ10\Models\MedioControl;
use SQ10\Models\Entidad;
use SQ10\Models\Cargo;
use SQ10\Models\Usuario;

class MedioControlController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function actionIndexmedioControl()
    {
        return view('medioControl/index');
    }

    public function actionTablaMediosControl(Request $request)
    {
        $mediosControl = DB::table('jurimedioscontrol')
                ->get();

        return view('ajax_mediosControl.ajaxTablasMediosControl')
                    ->with('mediosControl', $mediosControl);  
    }

    public function actionAgregarMediosControl(Request $request)
    {
        return view('ajax_mediosControl.ajaxAgregarMedioControl');  
    }

    public function actionValidarGuardarMedioControl(Request $request)
    {
        $medioControl  = new MedioControl;
        $medioControl->nombreMedioControl = $request->input('nombreMedioControl');
        $medioControl->save();

        return 1;// guarda medio de control
    }

    public function actionEditarMedioControl(Request $request)
    {
        $medioControl = DB::table('jurimedioscontrol')
                ->where('idMediosControl', '=', $request->input('idMedioControl'))
                ->get();

        return view('ajax_mediosControl.ajaxEditarMedioControl')
                ->with('medioControl', $medioControl);  
    }

    public function actionValidarEditarMedioControl(Request $request)
    {
        DB::table('jurimedioscontrol')
                ->where('idMediosControl', $request->input('idMedioControl'))
                ->update([
                    'nombreMedioControl' => $request->input('nombreMedioControlEditar')]);

        return 1; // se modificaron los datos del medio de control
    }

    public function actionValidarEliminarMedioControl(Request $request)
    {
        MedioControl::where('idMediosControl', '=', $request->input('idMedioControl'))->delete();

        return; // eliminado el medio de control
    }
}