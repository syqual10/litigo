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
use SQ10\helpers\Util as Util;

class MisProcesosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function actionindexmisprocesos($tablaConsolidado, $tipoProceso, $idResponsable)
    {
        return view('misProcesos/index')
                ->with('tablaConsolidado', $tablaConsolidado)
                ->with('tipoProceso', $tipoProceso)
                ->with('idResponsable', $idResponsable);
    }

    public function actionConsolidado(Request $request)
    {
      $tiposProceso = DB::table('juritipoprocesos')
                      ->orderBy('ordenProceso', 'asc')
                      ->get();

      return view('ajax_misProcesos.ajaxConsolidado')
           ->with('tiposProceso', $tiposProceso)
           ->with('idResponsable', $request->input('idResponsable'));
    }

    public function actionTablaProcesosConsolidado(Request $request)
    {
        //$arrayActuaciones = array();
        $arrayDemandantes = array();

        $procesosAbogado = DB::table('juriestadosetapas')
                ->select('vigenciaRadicado', 'idRadicado', 'nombreTema', 'idEstadoEtapa', 'fechaInicioEstado', 'idTipoProcesos', 'nombreTipoProceso', 'nombreJuzgado', 'codigoProceso', 'fechaRadicado')
                ->join('juriradicados', function ($join) {
                    $join->on('juriestadosetapas.juriradicados_idRadicado', '=', 'juriradicados.idRadicado')
                        ->on('juriestadosetapas.juriradicados_vigenciaRadicado', '=', 'juriradicados.vigenciaRadicado');
                })
                ->join('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                ->leftJoin('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
                ->leftJoin('jurijuzgados', 'juriradicados.jurijuzgados_idJuzgado', '=', 'jurijuzgados.idJuzgado')
                ->where('juritipoprocesos_idTipoProceso', '=', $request->input('idTipoProceso'))
                ->where('juriresponsables_idResponsable', '=', $request->input('idResponsable'))
                ->where('leidoEstado', '=', 1)//ya leídos
                ->where('juritipoestadosetapas_idTipoEstadoEtapa', '=', 1)// tipo estado actual
                ->orderBy('juriestadosetapas.juriradicados_vigenciaRadicado', 'desc')
                ->orderBy('juriestadosetapas.juriradicados_idRadicado', 'desc')
                ->get();

        if(count($procesosAbogado) > 0)
        {
            foreach ($procesosAbogado as $proceso) 
            {   
                /*
                $nombreActuacion = Util::ultimoTipoActuacion($proceso->vigenciaRadicado, $proceso->idRadicado);*/

                $demandantes = Util::personaDemandante($proceso->vigenciaRadicado, $proceso->idRadicado, $proceso->idTipoProcesos);

                //$datos  = array('nombreActuacion'  => $nombreActuacion);
                $datos2 = array('demandantes'      => $demandantes);

                //array_push($arrayActuaciones, $datos);
                array_push($arrayDemandantes, $datos2);
            }
        }

        return view('ajax_consolidado.ajaxTablaConsolidado')
                    ->with('procesosAbogado', $procesosAbogado)
                    //->with('arrayActuaciones', $arrayActuaciones)
                    ->with('arrayDemandantes', $arrayDemandantes)
                    ->with('idResponsable', $request->input('idResponsable'));
    }
}
