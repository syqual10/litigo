<?php
namespace SQ10\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Session;
use SQ10\Models\Usuario;
use SQ10\Models\Responsable;
use SQ10\Models\PuntoAtencion;
use SQ10\Models\ResponsablePunto;
use SQ10\helpers\Util as Util;

class PuntoAtencionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function actionIndex()
    {
        return view('puntoatencion/index');
    }

    public function actionPuntosAtencion(Request $request)
    {
        $puntosAtencion = DB::table('juripuntosatencion')
                        ->get();

        return view('ajax_puntoAtencion.ajaxTablaPuntoAtencion')
                        ->with('puntosAtencion', $puntosAtencion);
    }

    public function actionAgregarPuntoAtencion()
    {
        return view('ajax_puntoAtencion.ajaxAgregarPuntoAtencion');
    }

    public function actionValidarGuardarPunto(Request $request)
    {
        $punto  = new PuntoAtencion;
        $punto->nombrePuntoAtencion = $request->input('nombrePunto');
        $punto->direccionPuntoAtencion=$request->input('direccionPunto');
        $punto->save();

        return;
    }

    public function actionEditarPunto(Request $request)
    {
        $puntoAtencion = DB::table('juripuntosatencion')
                        ->where('idPuntoAtencion', '=', $request->input('idPunto'))
                        ->get();

        return view('ajax_puntoAtencion.ajaxEditarPuntoAtencion')
                        ->with('puntoAtencion', $puntoAtencion);
    }

    public function actionValidarEditarPunto(Request $request)
    {
        DB::table('juripuntosatencion')
                ->where('idPuntoAtencion', $request->input('idPunto'))
                ->update([
                    'nombrePuntoAtencion' => $request->input('nombrePuntoEditar'),
                    'direccionPuntoAtencion' => $request->input('direccionPuntoEditar')]);

        return;
    }

    public function actionValidarEliminarPunto(Request $request)
    {
        $responsablesPunto = DB::table('juriresponsablespunto')
                                ->where('juripuntosatencion_idPuntoAtencion', '=',$request->input('idPunto'))
                                ->count();

        if($responsablesPunto == 0)
        {
            PuntoAtencion::where('idPuntoAtencion', '=', $request->input('idPunto'))->delete();
        }

        return $responsablesPunto;
    }
}