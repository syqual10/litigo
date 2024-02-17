<?php
namespace SQ10\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Session;
use SQ10\Models\Usuario;
use SQ10\helpers\Util as Util;
use Barryvdh\DomPDF\Facade as PDF;

class TerminadoController extends Controller
{
  	public function __construct()
    {
        $this->middleware('auth');
    }

    public function actionIndex()
    {
        return view('terminados/index');
    }

    public function actionTerminados(Request $request)
    {
        $fechaTerminado = $request->input('fechaTerminado');

        //Terminados
        $terminados = DB::table('juriradicados')
                         ->join('juriestadosetapas', function ($join) {
                            $join->on('juriradicados.vigenciaRadicado', '=', 'juriestadosetapas.juriradicados_vigenciaRadicado')
                            ->on('juriradicados.idRadicado', '=', 'juriestadosetapas.juriradicados_idRadicado');
                         })
                        ->leftJoin('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                        ->leftJoin('jurijuzgados', 'juriradicados.jurijuzgados_idJuzgado', '=', 'jurijuzgados.idJuzgado')
                        ->where('juriestadosradicados_idEstadoRadicado', '=', 2)//Terminado
                        ->whereYear('fechaFinalEstado', '=', $fechaTerminado)
                        ->get();

        //Archivados
        $archivados = DB::table('juriradicados')
            ->join('juriestadosetapas', function ($join) {
               $join->on('juriradicados.vigenciaRadicado', '=', 'juriestadosetapas.juriradicados_vigenciaRadicado')
               ->on('juriradicados.idRadicado', '=', 'juriestadosetapas.juriradicados_idRadicado');
            })
            ->leftJoin('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
            ->leftJoin('jurijuzgados', 'juriradicados.jurijuzgados_idJuzgado', '=', 'jurijuzgados.idJuzgado')
            ->where('juriestadosradicados_idEstadoRadicado', '=', 2)//Terminado
            ->whereYear('fechaFinalEstado', '=', $fechaTerminado)
            ->where('juriradicados.archivado', '=', 1)//1 Archivados
            ->get();


        if(count($archivados) > 0) 
        {
            $porcentaje = (count($archivados) / count($terminados)) * 100;
        }
        else
        {
            $porcentaje = 0;
        }
              
        return view('ajax_terminados.ajaxBandejaTerminados')
                        ->with('terminados', $terminados)
                        ->with('fechaTerminado', $fechaTerminado)
                        ->with('porcentaje', $porcentaje);
                        
    }

    public function actionArchivaProceso(Request $request)
    {
        list($vigenciaRadicado, $idRadicado) = explode("-", $request->input('idRadicado'));

        DB::table('juriradicados')
                ->where('vigenciaRadicado', $vigenciaRadicado)
                ->where('idRadicado', $idRadicado)
                ->update(['archivado' => $request->input('accion')]);
        
        if($request->input('accion') == 1)
        {        
            //Guarda la bitácora de la acción realizada por el usuario
            $observacion = "Indica que ha archivado el expediente físico del proceso: ".$request->input('idRadicado');
            Util::guardarLog($observacion, $vigenciaRadicado, $idRadicado, 9);//9 Archiva el expediente físico de un proceso
            // -------
        }
        else
        {
            //Guarda la bitácora de la acción realizada por el usuario
            $observacion = "Indica que desarchiva el expediente físico del proceso: ".$request->input('idRadicado');
            Util::guardarLog($observacion, $vigenciaRadicado, $idRadicado, 10);//10 Desarchiva el expediente físico de un proceso
            // -------
        }

        return; // se modificó el estado del archivado
    }

}