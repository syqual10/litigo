<?php
namespace SQ10\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Session;
use SQ10\Models\CalificacionFallo;
use SQ10\Models\ValoracionFallo;
use Barryvdh\DomPDF\Facade as PDF;
use SQ10\helpers\Util as Util;

class ValoraFalloController extends Controller
{
  	public function __construct()
    {
        $this->middleware('auth');
    }

    public function actionValoraFallo($idEstadoEtapa)
    {
    	$proceso = DB::table('juriradicados')
                ->join('juriestadosetapas', function ($join) {
                    $join->on('juriradicados.vigenciaRadicado', '=', 'juriestadosetapas.juriradicados_vigenciaRadicado')
                    ->on('juriradicados.idRadicado', '=', 'juriestadosetapas.juriradicados_idRadicado');
                })
                ->where('idEstadoEtapa', '=', $idEstadoEtapa)
                ->get();

    	return view('valoraFallo/index')
                    ->with('idEstadoEtapa', $idEstadoEtapa)
                    ->with('proceso', $proceso);  
    }

    public function actionCargarValoracionesFallo(Request $request)
    {
        $valoraciones = DB::table('jurivaloracionesfallomzl')
                        ->join('usuarios', 'jurivaloracionesfallomzl.usuarios_idUsuario', '=', 'usuarios.idUsuario')
                        ->where('juriradicados_vigenciaRadicado', '=',  $request->input('vigenciaRadicado'))
                        ->where('juriradicados_idRadicado', '=',  $request->input('idRadicado'))
                        ->get();
        
        return view('ajax_valoraFallo.ajaxValoraciones')
             ->with('valoraciones', $valoraciones)
             ->with('administrar', $request->input('administrar'));
    }

    public function actionCargarValoracionFallo()
    {
        $criterios = DB::table('juricriteriosmzl')
                    ->get();

        return view('ajax_valoraFallo.ajaxValoracion')
             ->with('criterios', $criterios);
    }

    public function actionSeleccionaRango(Request $request)
    {
    	$criterio = DB::table('juricriteriosmzl')
                        ->where('idCriterio', '=',  $request->input('idCriterio'))
                        ->first();

    	return view('ajax_valoraFallo.ajaxSeleccionaRango')
             ->with('criterio', $criterio)
             ->with('escala', $request->input('escala'));
    }

    public function actionGuardarValoracionFallo(Request $request)
    {
    	$criterios     = json_decode($request->input('jsonCriterios'), true);
        $valoraciones  = json_decode($request->input('jsonValoraciones'), true);
        $escalas       = json_decode($request->input('jsonEscalas'), true);

        $fechaActual = date("Y-m-d H:i:s");
        $idUsuario = Session::get('idUsuario');
        $total = 0;

        //Tabla jurivaloracionesfallomzl
        $valoracion = new ValoracionFallo;
        $valoracion->fechaValoracionFallo = $fechaActual;
        $valoracion->puntajeValoracionFallo = 0;
        $valoracion->juriradicados_vigenciaRadicado = $request->input('vigenciaRadicado');
        $valoracion->juriradicados_idRadicado = $request->input('idRadicado');
        $valoracion->usuarios_idUsuario = $idUsuario;
        $valoracion->save();

        // Guarda las calificaciones individuales de cada criterio
        for ($i = 0; $i < count($criterios); $i++) 
        {            
            //Tabla juricalificacionesmzl
            $calificacion = new CalificacionFallo;
            $calificacion->valorCriterio = $valoraciones[$i];
            $calificacion->juricriteriosmzl_idCriterio = $criterios[$i];
            $calificacion->jurivaloracionesfallomzl_idValoracionFallo = $valoracion->idValoracionFallo;
            $calificacion->escala = $escalas[$i];
            $calificacion->save();   
            //Lleva la cuenta del total de los criterios
            $total += $valoraciones[$i];
        }

        //Actualiza el valor total
        DB::table('jurivaloracionesfallomzl')
                ->where('idValoracionFallo', '=', $valoracion->idValoracionFallo)
                ->update(['puntajeValoracionFallo' => $total]); 

        //Guarda la bitácora de la acción realizada por el usuario
        $observacion = "Valora la probabilidad de fallo en contra obteniendo un puntaje de ".$total;
        Util::guardarLog($observacion, $request->input('vigenciaRadicado'), $request->input('idRadicado'), 5);//5 Realiza valoración de la probabilidad de fallo en contra
        // -------

        return 1;
    }
    
    public function actionPdfValoracion($idValoracion)
    {
        $valoracion = DB::table('juricalificacionesmzl')
                         ->leftJoin('jurivaloracionesfallomzl', 'juricalificacionesmzl.jurivaloracionesfallomzl_idValoracionFallo', '=', 'jurivaloracionesfallomzl.idValoracionFallo')
                         ->leftJoin('juricriteriosmzl', 'juricalificacionesmzl.juricriteriosmzl_idCriterio', '=', 'juricriteriosmzl.idCriterio')
                         ->join('juriradicados', function ($join) {
                            $join->on('juriradicados.vigenciaRadicado', '=', 'jurivaloracionesfallomzl.juriradicados_vigenciaRadicado')
                                 ->on('juriradicados.idRadicado', '=', 'jurivaloracionesfallomzl.juriradicados_idRadicado');
                        })
                        ->leftJoin('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                        ->leftJoin('jurimedioscontrol', 'juriradicados.jurimedioscontrol_idMediosControl', '=', 'jurimedioscontrol.idMediosControl')
                        ->where('jurivaloracionesfallomzl.idValoracionFallo', '=',  $idValoracion)
                          ->get();
        
        if(count($valoracion) > 0)                  
        {
            //Guarda la bitácora de la acción realizada por el usuario
            $observacion = "Genera el formato PSI-SJM-FR-09 de la probabilidad de fallo en contra. idValoracion ".$idValoracion;
            Util::guardarLog($observacion, $valoracion[0]->vigenciaRadicado, $valoracion[0]->idRadicado, 6);//6 Genera el formato de la valoración de la probabilidad de fallo en contra
            // -------
        }

        $pdf = PDF::loadView('valoraFallo/pdfValoracion', array('valoracion' => $valoracion))->setPaper('a4', 'portrait');
        return $pdf->stream('Valoración fallo en contra.pdf');
    }
    
    public function actionEditarValoracion(Request $request)
    {
        $criterios = DB::table('juricriteriosmzl')
                    ->get();

        return view('ajax_valoraFallo.ajaxEditarValoracion')
             ->with('criterios', $criterios)
             ->with('idValoracion', $request->input('idValoracion'));
    }

    public function actionModificarValoracionFallo(Request $request)
    {
    	$criterios     = json_decode($request->input('jsonCriterios'), true);
        $valoraciones  = json_decode($request->input('jsonValoraciones'), true);
        $escalas       = json_decode($request->input('jsonEscalas'), true);

        $total = 0;

         //Borra todas las calificaciones previas
         DB::table('juricalificacionesmzl')
           ->where('jurivaloracionesfallomzl_idValoracionFallo', '=', $request->input('idValoracion'))
          ->delete(); 
        
        // Guarda las calificaciones individuales de cada criterio
        for ($i = 0; $i < count($criterios); $i++) 
        {            
            //Tabla juricalificacionesmzl
            $calificacion = new CalificacionFallo;
            $calificacion->valorCriterio = $valoraciones[$i];
            $calificacion->juricriteriosmzl_idCriterio = $criterios[$i];
            $calificacion->jurivaloracionesfallomzl_idValoracionFallo = $request->input('idValoracion');
            $calificacion->escala = $escalas[$i];
            $calificacion->save();   
            //Lleva la cuenta del total de los criterios
            $total += $valoraciones[$i];
        }

        //Actualiza el valor total
        DB::table('jurivaloracionesfallomzl')
                ->where('idValoracionFallo', '=', $request->input('idValoracion'))
                ->update(['puntajeValoracionFallo' => $total]); 

        //Guarda la bitácora de la acción realizada por el usuario
        $observacion = "Modifica la probabilidad de fallo en contra obteniendo un nuevo puntaje de ".$total.".  idValoracion: ".$request->input('idValoracion');
        Util::guardarLog($observacion, $request->input('vigenciaRadicado'), $request->input('idRadicado'), 7);//7 Modifica valoración de la probabilidad de fallo en contra
        // -------

        return 1;

    }
    
    public function actionEliminarValoracionFallo(Request $request)
    {
        //Borra todas las calificaciones de la valoración
        DB::table('juricalificacionesmzl')
          ->where('jurivaloracionesfallomzl_idValoracionFallo', '=', $request->input('idValoracion'))
         ->delete(); 

        //Borra la valoración general
        DB::table('jurivaloracionesfallomzl')
          ->where('idValoracionFallo', '=', $request->input('idValoracion'))
         ->delete(); 

        //Guarda la bitácora de la acción realizada por el usuario
        $observacion = "Elimina una valoración de la probabilidad de fallo en contra. idValoracion: ".$request->input('idValoracion');
        Util::guardarLog($observacion, $request->input('vigenciaRadicado'), $request->input('idRadicado'), 8);//8 Elimina valoración de la probabilidad de fallo en contra
        // -------

        return 1;

    }

}