<?php
namespace SQ10\Http\Controllers;

use DB;
use Excel;
use Illuminate\Http\Request;
use Session;
use SQ10\Models\Entidad;
use SQ10\Models\CuantiaRadicado;
use SQ10\Models\CalificacionRiesgo;
use SQ10\Models\CalificacionFallo;
use SQ10\Models\ValoracionFallo;
use SQ10\helpers\Util as Util;
setlocale(LC_MONETARY,"es_ES");

class ProviCalificaController extends Controller
{
  	public function __construct()
    {
        $this->middleware('auth');
    }

    public function actionIndexPoviCalifica($idEstadoEtapa)
    {
        $vigenciaActual = date('Y');

        $listaVigencias = DB::table('jurivigenciaindices')
            ->orderBy('idVigenciaIndice', 'asc')
            ->pluck('vigenciaIndice', 'idVigenciaIndice');

        $listaMeses = DB::table('meses')
            ->orderBy('idMes', 'asc')
            ->pluck('nombreMes', 'idMes');


        $criterios = DB::table('juricriterios')
                    ->get();

        $valorTipoCalificaciones = DB::table('juritipocalificaciones')
                                    ->get();

        $listaTipoCalificaciones = DB::table('juritipocalificaciones')
                                ->orderBy('idTipoCalificacion', 'asc')
                                ->pluck('nombreTipoCalificacion', 'idTipoCalificacion');

    	$proceso = DB::table('juriradicados')
                ->join('juriestadosetapas', function ($join) {
                    $join->on('juriradicados.vigenciaRadicado', '=', 'juriestadosetapas.juriradicados_vigenciaRadicado')
                    ->on('juriradicados.idRadicado', '=', 'juriestadosetapas.juriradicados_idRadicado');
                })
                ->where('idEstadoEtapa', '=', $idEstadoEtapa)
                ->get();

    	return view('proviCalifica/index')
                    ->with('idEstadoEtapa', $idEstadoEtapa)
                    ->with('listaVigencias', $listaVigencias)
                    ->with('listaMeses', $listaMeses)
                    ->with('vigenciaActual', $vigenciaActual)
                    ->with('criterios', $criterios)
                    ->with('valorTipoCalificaciones', $valorTipoCalificaciones)
                    ->with('listaTipoCalificaciones', $listaTipoCalificaciones)
                    ->with('proceso', $proceso);  
    }

    public function actionCuantiasRadicado(Request $request)
    {
    	$slv = Util::valorParametro(28);

    	$cuantias = DB::table('juricuantiaradicado')
                ->where('juriradicados_vigenciaRadicado', '=', $request->input('vigenciaRadicado'))
                ->where('juriradicados_idRadicado', '=', $request->input('idRadicado'))
                ->get();

        return view('ajax_provicalifica.ajaxCuantias')
                    ->with('cuantias', $cuantias)
                    ->with('slv', $slv);  
    }

    public function actionTablaCuantias(Request $request)
    {
    	$cuantias = DB::table('juricuantiaradicado')
                ->where('juriradicados_vigenciaRadicado', '=', $request->input('vigenciaRadicado'))
                ->where('juriradicados_idRadicado', '=', $request->input('idRadicado'))
                ->get();

        $sumaCuantias = DB::table('juricuantiaradicado')
                ->where('juriradicados_vigenciaRadicado', '=', $request->input('vigenciaRadicado'))
                ->where('juriradicados_idRadicado', '=', $request->input('idRadicado'))
                ->sum('valorPesos');

        return view('ajax_provicalifica.ajaxTablaCuantias')
                    ->with('cuantias', $cuantias)
                    ->with('sumaCuantias', $sumaCuantias);  
    }


	public function actionValidarEliminarCuantia(Request $request)
	{
		CuantiaRadicado::where('idCuantia', '=', $request->input('idCuantia'))->delete();
        return 1;// eliminar cuantía 
	}

    public function actionValidarGuardarCuantia(Request $request)
    {
       	$valorUnidadesMonetarias =  str_replace(".", "", $request->input('selectUnidadMonetaria'));
		$valorPesos =  str_replace(".", "", $request->input('valorPesos'));

		$cuantia = new CuantiaRadicado;
		$cuantia->unidadMonetaria      			  = $valorUnidadesMonetarias;
		$cuantia->valor                			  = $request->input('valorUnidadMonetaria');
		$cuantia->valorPesos           		      = $valorPesos;
		$cuantia->juriradicados_vigenciaRadicado  = $request->input('vigenciaRadicado');
		$cuantia->juriradicados_idRadicado        = $request->input('idRadicado');
		$cuantia->save();

		$cuantias = DB::table('juricuantiaradicado')
                ->where('juriradicados_vigenciaRadicado', '=', $request->input('vigenciaRadicado'))
                ->where('juriradicados_idRadicado', '=', $request->input('idRadicado'))
                ->sum('valorPesos');

		DB::table('juricuantiaradicado')
                ->where('juriradicados_vigenciaRadicado', '=', $request->input('vigenciaRadicado'))
                ->where('juriradicados_idRadicado', '=', $request->input('idRadicado'))
                ->update([
                    'valorTotalProceso' => $cuantias]);

		return;// guarda cuantía
    }

    public function actionValorIpcInicial(Request $request)
    {
    	$valorInicial = DB::table('juriindicesprecios')
                ->where('jurivigenciaindices_idVigenciaIndice', '=', $request->input('selectVigenciaInicialIpc'))
                ->where('meses_idmes', '=', $request->input('selectMesInicialIpc'))
                ->get();

    	if(count($valorInicial) > 0)
    	{
    		return $valorInicial[0]->valorIndice;
    	}
    	else
    	{
    		return 0;
    	}
    }

    public function actionValorIpcFinal(Request $request)
    {
    	$valorFinal = DB::table('juriindicesprecios')
                ->where('jurivigenciaindices_idVigenciaIndice', '=', $request->input('selectVigenciaFinalIpc'))
                ->where('meses_idmes', '=', $request->input('selectMesFinalIpc'))
                ->get();

    	if(count($valorFinal) > 0)
    	{
    		return $valorFinal[0]->valorIndice;
    	}
    	else
    	{
    		return 0;
    	}
    }

    public function actionCalcularIPC(Request $request)
    {
        $valor             = $request->input('valorCalcular');
        $ipcInicial        = $request->input('ipcInicial');
        $ipcFinal          = $request->input('ipcFinal');
        $porcentajeCondena = $request->input('porcentajeCondena')/100;
        $resultadoIndexado =  number_format((float)$valor*$porcentajeCondena*$ipcFinal/$ipcInicial , 0, ',', '.'); 
        
        DB::table('juricuantiaradicado')
                ->where('juriradicados_vigenciaRadicado', '=', $request->input('vigenciaRadicado'))
                ->where('juriradicados_idRadicado', '=', $request->input('idRadicado'))
                ->update([
                    'valorIndexado' => $resultadoIndexado]);

        return $resultadoIndexado;
    }

    public function actionValidarGuardarCalificacion(Request $request)
    {
        $factorIndexado         = pow(1+Util::valorParametro(8), $request->input('yearsFallo')) ;
        $tasaDescuento          = pow(1+Util::valorParametro(9), $request->input('yearsFallo')) ;
        $pretensionContingencia = $request->input('valorIndexado')*$factorIndexado/$tasaDescuento;
        
        $porcentaje1 = $request->input('valorCriterio1')/100;
        $porcentaje2 = $request->input('valorCriterio2')/100;
        $porcentaje3 = $request->input('valorCriterio3')/100;
        $porcentaje4 = $request->input('valorCriterio4')/100;

        $califca1 = $request->input('valorRangoCriterio1')*$porcentaje1;
        $califca2 = $request->input('valorRangoCriterio2')*$porcentaje2;
        $califca3 = $request->input('valorRangoCriterio3')*$porcentaje3;
        $califca4 = $request->input('valorRangoCriterio4')*$porcentaje4;

        $probabilidadCondena = $califca1 + $califca2 + $califca3 + $califca4;

        if($probabilidadCondena > 50)
        {
            $probabilidadPerderCaso = 1;//alta
        }
        else if($probabilidadCondena > 25 && $probabilidadCondena <= 50)
        {
            $probabilidadPerderCaso = 2;//media
        }
        else if($probabilidadCondena >= 10 && $probabilidadCondena <= 25)
        {
            $probabilidadPerderCaso = 3;//baja
        }
        else if($probabilidadCondena < 10)
        {
            $probabilidadPerderCaso = 4;//remota
        }

        if($probabilidadCondena > 50)
        {
            $registroPretension      = 1;//provisión contable
        }
        else if($probabilidadCondena <= 10)
        {
            $registroPretension      = 2;//no se registra
        }
        else if($probabilidadCondena > 10 && $probabilidadCondena <= 50)
        {
            $registroPretension      = 3;//cuentas de orden
        }

        if($registroPretension == 1)
        {
            $provisionContable = str_replace(".","",$pretensionContingencia);
        }
        else
        {
            $provisionContable = 0;
        }

        $cuantia = new CalificacionRiesgo;
        $cuantia->fechaActualizacion                         = $request->input('fechaActualizacion');
        $cuantia->yearsFallo                                 = $request->input('yearsFallo');
        $cuantia->juritipocalificaciones_idTipoCalificacion1 = $request->input('selectCriterio1');
        $cuantia->juritipocalificaciones_idTipoCalificacion2 = $request->input('selectCriterio2');
        $cuantia->juritipocalificaciones_idTipoCalificacion3 = $request->input('selectCriterio3');
        $cuantia->juritipocalificaciones_idTipoCalificacion4 = $request->input('selectCriterio4');
        $cuantia->porcentajeCondena                          = $request->input('porcentajeCondena');
        $cuantia->valorPonderacionCriterio1                  = $request->input('valorCriterio1');
        $cuantia->valorRangoCriterio1                        = $request->input('valorRangoCriterio1');
        $cuantia->valorPonderacionCriterio2                  = $request->input('valorCriterio2');
        $cuantia->valorRangoCriterio2                        = $request->input('valorRangoCriterio2');
        $cuantia->valorPonderacionCriterio3                  = $request->input('valorCriterio3');
        $cuantia->valorRangoCriterio3                        = $request->input('valorRangoCriterio3');
        $cuantia->valorPonderacionCriterio4                  = $request->input('valorCriterio4');
        $cuantia->valorRangoCriterio4                        = $request->input('valorRangoCriterio4');
        $cuantia->probabilidadCondena                        = $probabilidadCondena;
        $cuantia->provisionContable                          = $provisionContable;
        $cuantia->juritipoperdercaso_idPerderCaso            = $probabilidadPerderCaso;
        $cuantia->juritiporegistropretension_idRegistroPretension = $registroPretension;
        $cuantia->valorPresenteContingencia                  = $pretensionContingencia;
        $cuantia->juriradicados_vigenciaRadicado             = $request->input('vigenciaRadicado');
        $cuantia->juriradicados_idRadicado                   = $request->input('idRadicado');
        $cuantia->save();

        return; // guarda calificación
    }

    public function actionPretensiones(Request $request)
    {
        $calificaciones = DB::table('juricalificaciones')
                    ->select('idCalificacion', 'fechaActualizacion', 'criterio1.nombreTipoCalificacion as criterio1', 'criterio2.nombreTipoCalificacion as criterio2', 'criterio3.nombreTipoCalificacion as criterio3', 'criterio4.nombreTipoCalificacion as criterio4', 'provisionContable', 'probabilidadCondena', 'nombrePerderCaso', 'nombreRegistroPretension')
                    ->join('juritipocalificaciones as criterio1', 'juricalificaciones.juritipocalificaciones_idTipoCalificacion1', 'criterio1.idTipoCalificacion')
                    ->join('juritipocalificaciones as criterio2', 'juricalificaciones.juritipocalificaciones_idTipoCalificacion2', 'criterio2.idTipoCalificacion')
                    ->join('juritipocalificaciones as criterio3', 'juricalificaciones.juritipocalificaciones_idTipoCalificacion3', 'criterio3.idTipoCalificacion')
                    ->join('juritipocalificaciones as criterio4', 'juricalificaciones.juritipocalificaciones_idTipoCalificacion4', 'criterio4.idTipoCalificacion')
                    ->join('juritipoperdercaso', 'juricalificaciones.juritipoperdercaso_idPerderCaso', 'juritipoperdercaso.idPerderCaso')
                    ->join('juritiporegistropretension', 'juricalificaciones.juritiporegistropretension_idRegistroPretension', 'juritiporegistropretension.idRegistroPretension')
                    ->where('juriradicados_vigenciaRadicado', '=', $request->input('vigenciaRadicado'))
                    ->where('juriradicados_idRadicado',       '=', $request->input('idRadicado'))
                    ->get();

        return view('ajax_provicalifica.ajaxTablaPretensiones')
                    ->with('calificaciones', $calificaciones); 
    }

    public function actionDescripcionCriterio(Request $request)
    {
        $descripcion = DB::table('juricriterios')
                ->where('idCriterio', '=', $request->input('idCriterio'))
                ->get();

        return view('ajax_provicalifica.ajaxDescripcion')
                    ->with('descripcion', $descripcion);  
    }
}