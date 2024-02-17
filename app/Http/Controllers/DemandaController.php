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

class DemandaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function actionIndexDemandas()
    {
    	$tiposProceso = DB::table('juritipoprocesos')
                        ->orderBy('ordenProceso', 'asc')
                        ->get();

        return view('demandas/index')
        		->with('tiposProceso', $tiposProceso);
    }
}
