<?php
namespace SQ10\Http\Controllers;

use DB;
use Excel;
use Illuminate\Http\Request;
use Session;
use SQ10\Models\TipoProceso;

class TipoProcesoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function actionIndextipoproceso()
    {
        return view('tiposProceso/index');
    }

    public function actionTablaTipoProcesos(Request $request)
    {
        $tiposProcesos = DB::table('juritipoprocesos')
                ->get();

        return view('ajax_tiposProceso.ajaxTablaTiposProceso')
                    ->with('tiposProcesos', $tiposProcesos);  
    }

    public function actionAgregarTipoProceso(Request $request)
    {
        return view('ajax_tiposProceso.ajaxAgregarTipoProceso');  
    }

    public function actionValidarGuardarTipoProceso(Request $request)
    {
        $tipoProceso  = new TipoProceso;
        $tipoProceso->nombreTipoProceso = $request->input('nombreTipoProceso');
        $tipoProceso->ordenProceso = $request->input('ordenTipoProceso');
        $tipoProceso->save();

        return 1;// guarda el tipo de proceso
    }

    public function actionEditarTipoProceso(Request $request)
    {
        $tipoProceso = DB::table('juritipoprocesos')
                ->where('idTipoProcesos', '=', $request->input('idTipoProceso'))
                ->get();

        return view('ajax_tiposProceso.ajaxEditarTipoProceso')
                ->with('tipoProceso', $tipoProceso);  
    }

    public function actionValidarEditarTipoProceso(Request $request)
    {
        DB::table('juritipoprocesos')
                ->where('idTipoProcesos', $request->input('idTipoProceso'))
                ->update([
                    'nombreTipoProceso' => $request->input('nombreTipoProcesoEditar'),
                    'ordenProceso' => $request->input('ordenTipoProcesoEditar')]);

        return 1; // se modificaron los datos del tipo de proceso
    }

    public function actionValidarEliminarTipoProceso(Request $request)
    {
        $tipoProcesoEnRadicado = DB::table('juriradicados')
                ->where('juritipoprocesos_idTipoProceso', '=', $request->input('idTipoProceso'))
                ->count();

        if($tipoProcesoEnRadicado == 0)
        {
            TipoProceso::where('idTipoProcesos', '=', $request->input('idTipoProceso'))->delete();
            return 1;// eliminar tipo Proceso 
        }
        else
        {
            return 2;// no se puede eliminar porque lo utiliza al menos un radicado
        }
    }
}