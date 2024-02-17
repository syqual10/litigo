<?php
namespace SQ10\Http\Controllers;

use DB;
use Excel;
use Illuminate\Http\Request;
use Session;
use SQ10\Models\Entidad;
use SQ10\Models\TipoProceso;
use SQ10\Models\Usuario;
use SQ10\Models\Etapa;
use SQ10\Models\ResponsableEtapa;
use SQ10\Models\Instancia;
use SQ10\Models\Paso;
use SQ10\Models\TipoActuacion;
use SQ10\Models\ModuloProceso;

class ConfigurarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function actionIndexConfigurar($tipoProceso)
    {
        $datosTipoProceso = TipoProceso::find($tipoProceso);         

        return view('configurar/index')
                ->with('datosTipoProceso', $datosTipoProceso);
    }

    public function actionIsntanciasTipoProceso(Request $request)
    {
        $instancias = DB::table('juriinstancias')
                ->where('juritipoprocesos_idTipoProcesos', '=', $request->input('idTipoProceso'))
                ->get();

        return view('ajax_configurar.ajaxInstanciasTipoProceso')
                ->with('instancias', $instancias);  
    }

    public function actionAgregarInstancia(Request $request)
    {
        return view('ajax_configurar.ajaxAgregarInstancia');  
    }

    public function actionValidarGuardarInstancia(Request $request)
    {
        $instancia  = new Instancia;
        $instancia->nombreInstancia=$request->input('nombreInstancia');
        $instancia->juritipoprocesos_idTipoProcesos=$request->input('idTipoProceso');
        $instancia->save();

        return 1;// guarda instancia del tipo de proceso
    }

    public function actionEditarInstancia(Request $request)
    {
        $instancia = DB::table('juriinstancias')
                ->where('idInstancia', '=', $request->input('idInstancia'))
                ->get();

        return view('ajax_configurar.ajaxEditarInstancia')
                        ->with('instancia', $instancia); 
    }

    public function actionValidarEditarInstancia(Request $request)
    {
        DB::table('juriinstancias')
                ->where('idInstancia', $request->input('idInstancia'))
                ->update([
                    'nombreInstancia' => $request->input('nombreInstanciaEditar')]);

        return 1; // se modificaron los datos de la instancia
    }

    public function actionValidarEliminarInstancia(Request $request)
    {
        $cargoEnUsuario = DB::table('jurietapas')
                        ->where('juriinstancias_idInstancia', '=', $request->input('idInstancia'))
                        ->count();

        if($cargoEnUsuario == 0)
        {
            Instancia::where('idInstancia', '=', $request->input('idInstancia'))->delete();
            return 1;// eliminar instancia 
        }
        else
        {
            return 2;// no se puede eliminar porque lo utiliza al menos una etapa
        }
    }

    public function actionEtapasInstancia(Request $request)
    {
        $etapas = DB::table('jurietapas')
                    ->where('juriinstancias_idInstancia', '=', $request->input('idInstancia'))
                    ->get();

        return view('ajax_configurar.ajaxEtapasInstancia')
                        ->with('idInstancia', $request->input('idInstancia'))
                        ->with('etapas', $etapas); 
    }

    public function actionAgregarEtapa(Request $request)
    {
        return view('ajax_configurar.ajaxAgregarEtapaInstancia')
                    ->with('idInstancia', $request->input('idInstancia')); 
    }

    public function actionValidarGuardarEtapaInstancia(Request $request)
    {
        $etapa  = new Etapa;
        $etapa->nombreEtapa = $request->input('nombreEtapa');
        $etapa->juriinstancias_idInstancia = $request->input('idInstancia');
        $etapa->save();

        return 1;// guarda la etapa de la instancia
    }

    public function actionEditarEtapa(Request $request)
    {
        $etapa = DB::table('jurietapas')
                ->where('idEtapa', '=', $request->input('idEtapa'))
                ->get();

        return view('ajax_configurar.ajaxEditarEtapaInstancia')
                        ->with('etapa', $etapa); 
    }

    public function actionValidarEditarEtapaInstancia(Request $request)
    {
        DB::table('jurietapas')
                ->where('idEtapa', $request->input('idEtapa'))
                ->update([
                    'nombreEtapa' => $request->input('nombreEtapaEditar')]);

        return 1; // se modificaron los datos d la etapa
    }

    public function actionValidarEliminarEtapa(Request $request)
    {
        $etapaEnActuacion = DB::table('juriactuaciones')
                        ->where('jurietapas_idEtapa', '=', $request->input('idEtapa'))
                        ->count();

        if($etapaEnActuacion == 0)
        {
            Etapa::where('idEtapa', '=', $request->input('idEtapa'))->delete();
            return 1;// eliminar etapa
        }
        else
        {
            return 2;// no se puede eliminar porque la etapa está en la actuación 
        }
    }

    public function actionPasosPadre(Request $request)
    {
        $pasosPadre = DB::table('juripasos')
                ->join('juritipoprocesos', 'juripasos.juritipoprocesos_idTipoProcesos', 'juritipoprocesos.idTipoProcesos')
                ->where('juritipoprocesos_idTipoProcesos', '=', $request->input('idTipoProceso'))
                ->where('juripasos_idPaso', '=', Null)
                ->orderBy('ordenPaso', 'asc')
                ->get();

        return view('ajax_configurar.ajaxTablaPasosPadre')
                    ->with('pasosPadre', $pasosPadre);
    }

    public function actionPasosHijo(Request $request)
    {
        $pasosPadre = DB::table('juripasos')
                    ->select('idPaso', 'textoPaso', 'pasoActivo')
                    ->where('juritipoprocesos_idTipoProcesos', '=', $request->input('idTipoProceso'))
                    ->where('juripasos_idPaso', '=', Null)
                    ->where('pasoActivo', '=', 1)
                    ->orderBy('ordenPaso', 'asc')
                    ->get();

        return response()->json([
            'vistaHijo'  => view('ajax_configurar.ajaxTablaPasosHijo')
                ->with('pasosPadre', $pasosPadre)  
                ->render(),
            'pasosPadre'  => $pasosPadre,
        ]);

        return view('ajax_configurar.ajaxTablaPasosHijo')
                    ->with('pasosPadre', $pasosPadre);
    }

    public function actionAgregarPasoPadre(Request $request)
    {
        return view('ajax_configurar.ajaxAgregarQueHace'); 
    }

    public function actionAgregarPasoHijo(Request $request)
    {
        $listaPasoPadre = DB::table('juripasos')
            ->where('juritipoprocesos_idTipoProcesos', '=', $request->input('idTipoProceso'))
            ->where('juripasos_idPaso', '=', Null)
            ->orderBy('idPaso', 'asc')
            ->pluck('textoPaso', 'idPaso');        

        return view('ajax_configurar.ajaxAgregarComoHace')
                ->with('listaPasoPadre', $listaPasoPadre);   
    }

    public function actionValidarGuardarPaso(Request $request)
    {
        $cantPasoPadre = DB::table('juripasos')
                    ->where('juritipoprocesos_idTipoProcesos', '=', $request->input('idTipoProceso'))
                    ->where('juripasos_idPaso', '=', Null)
                    ->count();

        $cantPasoHijo = DB::table('juripasos')
                    ->where('juripasos_idPaso', '=', $request->input('selectPasoPadre'))
                    ->count();

        $paso  = new Paso;
        $paso->textoPaso = $request->input('textoPaso');
        if($request->input('padreHijo') == 1)// si se va guardar un padre, que se hace
        {
            $paso->juritipoprocesos_idTipoProcesos = $request->input('idTipoProceso');  
            $paso->ordenPaso = $cantPasoPadre + 1;  
        }
        else
        {
            $paso->juripasos_idPaso = $request->input('selectPasoPadre');  
            $paso->ordenPaso = $cantPasoHijo + 1;
        }
        $paso->save();

        return 1;// guarda paso
    }

    public function actionEditarPasoPadre(Request $request)
    {
        $paso = DB::table('juripasos')
                ->where('idPaso', '=', $request->input('idPaso'))
                ->get();

        return view('ajax_configurar.ajaxEditarPasoPadre')
                ->with('paso', $paso);  
    }

    public function actionEditarPasoHijo(Request $request)
    {
        $paso = DB::table('juripasos')
                ->where('idPaso', '=', $request->input('idPaso'))
                ->get();

        $listaPasoPadre = DB::table('juripasos')
            ->where('juritipoprocesos_idTipoProcesos', '=', $request->input('idTipoProceso'))
            ->where('juripasos_idPaso', '=', Null)
            ->orderBy('idPaso', 'asc')
            ->pluck('textoPaso', 'idPaso');   

        return view('ajax_configurar.ajaxEditarPasoHijo')
                ->with('paso', $paso)
                ->with('listaPasoPadre', $listaPasoPadre);  
    }

    public function actionValidarEditarPaso(Request $request)
    {
        if($request->input('padreHijo') == 1)// que hacen padres
        {
            DB::table('juripasos')
                ->where('idPaso', $request->input('idPaso'))
                ->update([
                    'textoPaso' => $request->input('textoPasoEditar')]);
        }
        else// como hacen padres
        {
            DB::table('juripasos')
                ->where('idPaso', $request->input('idPaso'))
                ->update([
                    'textoPaso' => $request->input('textoPasoEditar'),
                    'juripasos_idPaso' => $request->input('selectPasoPadreEditar')]);
        }

        return 1; // se modificaron los datos del paso
    }

    public function actionValidarEstadoPaso(Request $request)
    {
        DB::table('juripasos')
                ->where('idPaso', $request->input('idPaso'))
                ->update([
                    'pasoActivo' => $request->input('estadoPaso')]);

        return 1;// se modificó el estado del paso
    }

    public function actionValidarOrdenaPadre(Request $request)
    {
        $pasos = json_decode($request->input('jsonPasosPadre'), true);
        $contador = 1;
        
        foreach ($pasos as $paso) 
        {
            DB::table('juripasos')
                ->where('idPaso', $paso)
                ->update([
                    'ordenPaso' => $contador]);

            $contador ++;
        }
    }

    public function actionValidarOrdenaHijo(Request $request)
    {
        $pasos = json_decode($request->input('jsonPasosHijos'), true);
        $contador = 1;
        
        foreach ($pasos as $paso) 
        {
            DB::table('juripasos')
                ->where('idPaso', $paso)
                ->update([
                    'ordenPaso' => $contador]);

            $contador ++;
        }
    }

    public function actionTiposActuaciones(Request $request)
    {
        $tipoActuaciones = DB::table('juritiposactuaciones')
                ->where('juritipoprocesos_idTipoProcesos', '=', $request->input('idTipoProceso'))
                ->get();

        return view('ajax_configurar.ajaxTablaTipoActuaciones')
                ->with('tipoActuaciones', $tipoActuaciones);  
    }

    public function actionAgregarTipoActuacion(Request $request)
    {
        return view('ajax_configurar.ajaxAgregarTipoActuacion');  
    }

    public function actionValidarGuardarTipoActuacion(Request $request)
    {
        $tipoActuacion  = new TipoActuacion;
        $tipoActuacion->nombreActuacion=$request->input('nombreTipoActuacion');
        $tipoActuacion->tipoActuacionFinaliza=$request->input('selectFinaliza');
        $tipoActuacion->juritipoprocesos_idTipoProcesos=$request->input('idTipoProceso');
        $tipoActuacion->tipoFallo=$request->input('selectFallo');
        $tipoActuacion->save();

        return 1;// guarda tipo de actuación
    }

    public function actionEditarTipoActuacion(Request $request)
    {
        $tipoActuacion = DB::table('juritiposactuaciones')
                ->where('idTipoActuacion', '=', $request->input('idTipoActuacion'))
                ->get();

        return view('ajax_configurar.ajaxEditarTipoActuacion')
                ->with('tipoActuacion', $tipoActuacion);  
    }

    public function actionValidarEditarTipoActuacion(Request $request)
    {
        DB::table('juritiposactuaciones')
                ->where('idTipoActuacion', $request->input('idTipoActuacion'))
                ->update([
                    'nombreActuacion'       => $request->input('nombreTipoActuacionEditar'),
                    'tipoActuacionFinaliza' => $request->input('selectFinalizaEditar'),
                    'tipoFallo'             => $request->input('selectFalloEditar')]);

        return 1; // se modificaron los datos del tipo de actuación
    }

    public function actionValidarEstadoTipoActuacion(Request $request)
    {
        DB::table('juritiposactuaciones')
                ->where('idTipoActuacion', $request->input('idTipoActuacion'))
                ->update([
                    'activo' => $request->input('estado')]);

        return 1; // se modificó el estado del tipo de actuación
    }

    public function actionModulosTiposProceso(Request $request)
    {
        $activosTipoProceso = array();
        $inativosTipoProceso = array();

        $modulos = DB::table('jurimodulos')
                ->where('activo', '=', 1)//módulos activos
                ->get();

        if(count($modulos) > 0)
        {
            foreach ($modulos as $modulo) 
            {
                $moduloActivo = DB::table('jurimodulostipoproceso')
                        ->where('jurimodulos_idModulo', '=', $modulo->idModulo)
                        ->where('juritipoprocesos_idTipoProcesos', '=', $request->input('idTipoProceso'))
                        ->get();

                if(count($moduloActivo) > 0)
                {
                    $datosAct = array('nombreModuloAct' => $modulo->nombreModulo,
                                      'idModuloActivo' => $modulo->idModulo);

                    array_push($activosTipoProceso, $datosAct);
                }
                else
                {
                    $datosInac = array('nombreModuloInac' => $modulo->nombreModulo,
                                       'idModuloInactivo' => $modulo->idModulo);

                    array_push($inativosTipoProceso, $datosInac);
                }
            }
        }

        //return dd($activosTipoProceso);

        return view('ajax_configurar.ajaxModulos')
                ->with('activosTipoProceso', $activosTipoProceso)
                ->with('inativosTipoProceso', $inativosTipoProceso);  
    }

    public function actionEstadoModulo(Request $request)
    {
        $modulos = json_decode($request->input('jsonModulos'), true);
        
        if($request->input('estadoModulo') == 1)
        {
            foreach ($modulos as $modulo) 
            {
                $moduloProceso  = new ModuloProceso; 
                $moduloProceso->jurimodulos_idModulo            = $modulo;
                $moduloProceso->juritipoprocesos_idTipoProcesos = $request->input('idTipoProceso');
                $moduloProceso->save();
            }
        }
        else
        {
            foreach ($modulos as $modulo) 
            {
                DB::table('jurimodulostipoproceso')
                    ->where('jurimodulos_idModulo', '=', $modulo)
                    ->where('juritipoprocesos_idTipoProcesos', '=', $request->input("idTipoProceso"))
                    ->delete();
            }
        }

        return;
    }
}