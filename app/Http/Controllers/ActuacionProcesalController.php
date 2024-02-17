<?php
namespace SQ10\Http\Controllers;

use DB;
use Excel;
use Illuminate\Http\Request;
use Session;
use SQ10\Models\Entidad;
use SQ10\Models\ActuacionProcesal;
use SQ10\Models\ActuacionResponsable;
use SQ10\Models\TipoActuacion;
use SQ10\Models\Archivo;
use SQ10\Models\FalloRadicado;
use SQ10\Mail\NotificacionActuacion;
use SQ10\Mail\NotificacionTerminado;
use SQ10\helpers\Util as Util;
use Illuminate\Support\Facades\Mail;

class ActuacionProcesalController extends Controller
{
  	public function __construct()
    {
        $this->middleware('auth');
    }

    public function actionIndexActuProcesal($idEstadoEtapa)
    {
        $proceso = DB::table('juriradicados')
                ->join('juriestadosetapas', function ($join) {
                    $join->on('juriradicados.vigenciaRadicado', '=', 'juriestadosetapas.juriradicados_vigenciaRadicado')
                    ->on('juriradicados.idRadicado', '=', 'juriestadosetapas.juriradicados_idRadicado');
                })
                ->join('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                ->join('juriresponsables', 'juriestadosetapas.juriresponsables_idResponsable', '=', 'juriresponsables.idResponsable')
                ->leftJoin('usuarios', 'juriresponsables.usuarios_idUsuario', '=', 'usuarios.idUsuario')
                ->where('idEstadoEtapa', '=', $idEstadoEtapa)
                ->get();

        return view('actuacionProcesal/index')
                ->with('proceso', $proceso)
                ->with('idEstadoEtapa', $idEstadoEtapa);
    }

    public function actionInstanciasProceso(Request $request)
    {
        $instancias = DB::table('juriinstancias')
                    ->where('juritipoprocesos_idTipoProcesos', '=', $request->input('idTipoProceso'))
                    ->get();

        if (count($instancias) > 0)
        {
          $instanciaInicial = $instancias[0]->idInstancia;
        }
        else
        {
          $instanciaInicial = 0;
        }

        return response()->json(['vista' => view('ajax_actuacionProcesal.ajaxInstanciasProceso')
                                          ->with('instancias', $instancias)
                                          ->render(),
                                'instanciaInicial' => $instanciaInicial]);
    }

    public function actionEtapasInstancia(Request $request)
    {
        $etapas = DB::table('jurietapas')
                    ->where('juriinstancias_idInstancia', '=', $request->input('idInstancia'))
                    ->get();

        if (count($etapas) > 0)
        {
          $etapaInicial = $etapas[0]->idEtapa;
        }
        else
        {
          $etapaInicial = 0;
        }
        
        return response()->json(['vista' => view('ajax_actuacionProcesal.ajaxEtapasProceso')
                                          ->with('etapas', $etapas)
                                          ->render(),
                                'etapaInicial' => $etapaInicial]);
    }

    public function actionAgregarActuacion(Request $request)
    {
        $tipoProceso = 0;
        $despachos   = [];
        $despacho    = '';

        $proceso = DB::table('juriradicados')
                    ->select('jurijuzgados_idJuzgado', 'juritipoprocesos_idTipoProceso', 'juriautoridadconoce_idAutoridadConoce')
                    ->where('vigenciaRadicado', '=', $request->input('vigenciaRadicado'))
                    ->where('idRadicado', '=', $request->input('idRadicado'))
                    ->get();

        if(count($proceso) > 0)
        {
            $tipoProceso = $proceso[0]->juritipoprocesos_idTipoProceso;
        }

        if($tipoProceso == 2)//procuradurías conciliaciones
        {
            $despacho = $proceso[0]->juriautoridadconoce_idAutoridadConoce;

            $despachos = DB::table('juriautoridadconoce')
                            ->orderBy('idAutoridadConoce', 'asc')
                            ->pluck('nombreAutoridadConoce', 'idAutoridadConoce');
        }
        else if($tipoProceso == 1 || $tipoProceso == 3)// demandas o tutelas
        {
            $despacho = $proceso[0]->jurijuzgados_idJuzgado;

            $despachos = DB::table('jurijuzgados')
                            ->orderBy('idJuzgado', 'asc')
                            ->pluck('nombreJuzgado', 'idJuzgado');
        }
        

        $tiposEstadosActuaciones = DB::table('juritiposestadosactuaciones')
                            ->orderBy('idTipoEstadoActuacion', 'asc')
                            ->pluck('nombreTipoEstadoActuacion', 'idTipoEstadoActuacion');

        return view('ajax_actuacionProcesal.ajaxAgregarActuProces')
                ->with('tiposEstadosActuaciones', $tiposEstadosActuaciones)
                ->with('despachos', $despachos)
                ->with('despacho', $despacho)
                ->with('tipoProceso', $tipoProceso)
                ->with('idEtapa', $request->input('idEtapa'));
    }

    public function actionConfiguracionTipoActuacion(Request $request)
    {
        $tipoActuacion = TipoActuacion::find($request->input('selectTipoActuacion'));

        if(count($tipoActuacion) > 0)
        {
            return response()->json(['tipoFinal' => $tipoActuacion->tipoActuacionFinaliza,
                                'tipoFallo'  => $tipoActuacion->tipoFallo]);// acá cuando tenga el campo fallo
        }
        else
        {
            return 0;
        }
    }

    public function actionAgregarTipoFallo(Request $request)
    {
        $tiposFallos = DB::table('juritiposfallos')
                            ->orderBy('idTipoFallo', 'asc')
                            ->pluck('nombreTipoFallo', 'idTipoFallo');

        $tipoActuacion = TipoActuacion::find($request->input('idTipoActuacion'));

        return response()->json(['vista'    => view('ajax_actuacionProcesal.ajaxAgregarTipoFallo')
                                  ->with('tiposFallos', $tiposFallos)
                                  ->render(),
                                'tipoFallo' => $tipoActuacion->tipoFallo]);
    }

    public function actionValidarGuardarActuProce(Request $request)
    {
        $idUsuario = Session::get('idUsuario');
        $idResponsable = Util::idResponsable($idUsuario);
        $despacho = $request->input('tipoProceso');

        $apoderados = Util::apoderadosActivosRadicado($request->input('vigenciaRadicado'), $request->input('idRadicado'));

        $apoderadosTodos = Util::apoderadosRadicado($request->input('vigenciaRadicado'), $request->input('idRadicado'));
        
        if(count($apoderadosTodos) > 0)
        {
            $nombreDespacho = '';

            if($despacho == 2)
            {
                $oficinaDespacho = DB::table('juriautoridadconoce')
                                    ->where('idAutoridadConoce', '=', $request->input('selectJuzgado'))
                                    ->get();
                if(count($oficinaDespacho) > 0)
                {
                    $nombreDespacho  = $oficinaDespacho[0]->nombreAutoridadConoce;
                }
            }
            else
            {
                $oficinaDespacho = DB::table('jurijuzgados')
                                ->where('idJuzgado', '=', $request->input('selectJuzgado'))
                                ->get(); 
                if(count($oficinaDespacho) > 0)
                {
                    $nombreDespacho  = $oficinaDespacho[0]->nombreJuzgado;    
                }
            }

            $actuacion = DB::table('juritiposactuaciones')
                        ->where('idTipoActuacion', '=', $request->input('selectTipoActuacion'))
                        ->get();

            $proceso = DB::table('juriradicados')
                        ->leftJoin('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
                        ->leftJoin('jurimedioscontrol', 'juriradicados.jurimedioscontrol_idMediosControl', '=', 'jurimedioscontrol.idMediosControl')
                        ->where('vigenciaRadicado', '=', $request->input('vigenciaRadicado'))
                        ->where('idRadicado', '=', $request->input('idRadicado'))
                        ->get();

            $fechaActuProce = ucfirst(utf8_encode(strftime("%A %d de %B de %Y", strtotime($request->input('fechaActuProce')))));

            //GUARDA ACTUACIÓN
            $actuProcesal   = new ActuacionProcesal;
            $actuProcesal->jurietapas_idEtapa                        = $request->input('idEtapa');
            $actuProcesal->fechaActuacion                            = $request->input('fechaActuProce');
            $actuProcesal->comentarioActuacion                       = $request->input('comentarioActuacion');
            $actuProcesal->juritiposactuaciones_idTipoActuacion      = $request->input('selectTipoActuacion');
            if($despacho == 2)
            {
                $actuProcesal->juriautoridadconoce_idAutoridadConoce = $request->input('selectJuzgado');
            }
            else if($despacho == 1 || $despacho == 3)
            {
                $actuProcesal->jurijuzgados_idJuzgado                = $request->input('selectJuzgado');
            }
            $actuProcesal->juriresponsables_idResponsable            = $idResponsable;
            $actuProcesal->juriradicados_vigenciaRadicado            = $request->input('vigenciaRadicado');
            $actuProcesal->juriradicados_idRadicado                  = $request->input('idRadicado');
            $actuProcesal->save(); 
            //#GUARDA ACTUACIÓN
             
            foreach ($apoderadosTodos as $apoderado) 
            {   
                //GUARDA LA RELACIÓN ENTRE LA ACTUACIÓN Y EL RESPONSABLE
                $actuResponsable                                            = new ActuacionResponsable;
                $actuResponsable->juriactuaciones_idActuacion               = $actuProcesal->idActuacion;
                $actuResponsable->juriresponsables_idResponsable_apoderado  = $apoderado->idResponsable;
                $actuResponsable->save();
                //#GUARDA LA RELACIÓN ENTRE LA ACTUACIÓN Y EL RESPONSABLE
            }

            foreach ($apoderados as $apoderado) 
            {   
                ###ENVIAR EMAIL
                if ($apoderado->emailUsuario !='' && Util::valid_email_address($apoderado->emailUsuario) && $apoderado->idResponsable != $idResponsable)
                {
                    Util::guardarEmail($apoderado->emailUsuario, $request->input('vigenciaRadicado')."-".$request->input('idRadicado'), 3);// proyecto 3 jurídica

                    $data = array('fechaActuProce'      => $fechaActuProce,
                                  'comentarioActuacion' => $request->input('comentarioActuacion'),
                                  'despacho'            => $nombreDespacho,
                                  'actuacion'           => $actuacion[0]->nombreActuacion,
                                  'radicadoJuzgado'     => $proceso[0]->radicadoJuzgado,
                                  'tema'                => $proceso[0]->nombreTema,
                                  'medioControl'        => $proceso[0]->nombreMedioControl,
                                  'vigenciaRadicado'    => $request->input('vigenciaRadicado'),
                                  'idRadicado'          => $request->input('idRadicado')
                                );

                    Mail::to($apoderado->emailUsuario, 'xxxxx')
                      ->queue(new NotificacionActuacion($data));

                    if($apoderado->datosCopiaActuacion != '')
                    {
                        $datosCopia = explode("*", $apoderado->datosCopiaActuacion);
                        for ($i=0; $i < count($datosCopia) ; $i++) 
                        { 
                            $datos = explode("-", $datosCopia[$i]);
                            Mail::to($datos[0], 'xxxxx')
                                ->queue(new NotificacionActuacion($data)); 

                            Util::guardarEmail($datos[0], $request->input('vigenciaRadicado')."-".$request->input('idRadicado'), 3);// proyecto 3 jurídica
                        }
                    }
                }
                ###ENVIAR EMAIL

                ###ENVIAR SMS
                if($apoderado->celularUsuario !='' && $apoderado->idResponsable != $idResponsable)
                {
                    if($proceso[0]->radicadoJuzgado != '')
                    {
                        $radiJuzgado = "Radicado del juzgado ".$proceso[0]->radicadoJuzgado;
                    }
                    else
                    {
                        $radiJuzgado = "";
                    }

                    $expresion = '/^[3][0-9]{9}+$/';
                    if(preg_match($expresion, $apoderado->celularUsuario))
                    {
                        $nombreUsu = explode(" ", $apoderado->nombresUsuario);
                        $mensaje = " Hola ".$nombreUsu[0].", Nueva actuación, ".$radiJuzgado." ".$nombreDespacho." hr".date('H:i')." litígo ".$request->input('idRadicado')."-".$request->input('vigenciaRadicado');

                        Util::enviarSms($apoderado->celularUsuario, $mensaje);

                        if($apoderado->datosCopiaActuacion != '')
                        {
                            $datosCopia = explode("*", $apoderado->datosCopiaActuacion);
                            for ($i=0; $i < count($datosCopia) ; $i++) 
                            { 
                                $datos = explode("-", $datosCopia[$i]);
                                Util::enviarSms($datos[1], $mensaje);
                            }
                        }
                    }
                }
                ###ENVIAR SMS
            }
        }

        $tipoActuacion = DB::table('juritiposactuaciones')
                    ->select('tipoActuacionFinaliza')
                    ->where('idTipoActuacion', '=', $request->input('selectTipoActuacion'))
                    ->get();

        if($tipoActuacion[0]->tipoActuacionFinaliza == 1)// si es un tipo de actuación marcado como finalizar
        {
            DB::table('juriestadosetapas')
                    ->where('idEstadoEtapa', $request->input('idEstadoEtapa'))
                    ->update([
                            'fechaFinalEstado'                          => date("Y-m-d H:i:s"),
                            'comentarioEstadoEtapa'                     => "Se finaliza el proceso",
                            'juritipoestadosetapas_idTipoEstadoEtapa'   => 2]);//gestionado

            $estadosActuaciones = DB::table('juriestadosetapas')
                                ->where('juriradicados_vigenciaRadicado', '=', $request->input('vigenciaRadicado'))
                                ->where('juriradicados_idRadicado', '=', $request->input('idRadicado'))
                                ->where('juritiposestados_idTipoEstado', '=', 3)
                                ->where('juritipoestadosetapas_idTipoEstadoEtapa', '=', 1)
                                ->count();

            //termina el proceso 
            DB::table('juriradicados')
            ->where('vigenciaRadicado', $request->input('vigenciaRadicado'))
            ->where('idRadicado', $request->input('idRadicado'))
            ->update([
                    'juriestadosradicados_idEstadoRadicado'     => 2]);// terminado

            if($estadosActuaciones == 0)//si ya todos los apoderados respondieron
            {
                $notificados = DB::table('juriresponsables')
                                    ->join('usuarios', 'juriresponsables.usuarios_idUsuario', '=', 'usuarios.idUsuario')
                                    ->where('notificarTerminados', '=', 1)//para notificar del radicado terminado
                                    ->get();

                ###ENVIAR EMAIL
                if(count($notificados) > 0)
                {
                    foreach ($notificados as $notificado) 
                    {
                        if ($notificado->emailUsuario !='' && Util::valid_email_address($notificado->emailUsuario))
                        {
                            Util::guardarEmail($notificado->emailUsuario, $request->input('vigenciaRadicado')."-".$request->input('idRadicado'), 3);// proyecto 3 jurídica

                            $data = array('fechaActuProce'      => $fechaActuProce,
                                          'comentarioActuacion' => $request->input('comentarioActuacion'),
                                          'despacho'            => $nombreDespacho,
                                          'actuacion'           => $actuacion[0]->nombreActuacion,
                                          'radicadoJuzgado'     => $proceso[0]->radicadoJuzgado,
                                          'tema'                => $proceso[0]->nombreTema,
                                          'medioControl'        => $proceso[0]->nombreMedioControl,
                                          'vigenciaRadicado'    => $request->input('vigenciaRadicado'),
                                          'idRadicado'          => $request->input('idRadicado')
                                        );

                            Mail::to($apoderado->emailUsuario, 'xxxxx')
                              ->queue(new NotificacionTerminado($data));
                        }
                    }
                }
                ###ENVIAR EMAIL

                DB::table('juriradicados')
                    ->where('vigenciaRadicado', $request->input('vigenciaRadicado'))
                    ->where('idRadicado', $request->input('idRadicado'))
                    ->update([
                            'juriestadosradicados_idEstadoRadicado'     => 2]);// terminado
            }
        }

        if($request->input('fallo') == 1)
        {
            $actuFallo   = new FalloRadicado;
            $actuFallo->juriradicados_vigenciaRadicado  = $request->input('vigenciaRadicado');
            $actuFallo->juriradicados_idRadicado        = $request->input('idRadicado');
            $actuFallo->juritiposfallos_idTipoFallo     = $request->input('selectTipoFallo');
            $actuFallo->juriactuaciones_idActuacion     = $actuProcesal->idActuacion;
            $actuFallo->save();
        }

        return response()->json(['idActuacion'   => $actuProcesal->idActuacion,//guarda actuación de la etapa
                                 'tipoFinaliza'  => $tipoActuacion[0]->tipoActuacionFinaliza,
                                 'idResponsable' => $idResponsable]);
    }

    public function actionactuacionesEtapa(Request $request)
    {
        $idUsuario = Session::get('idUsuario');
        $idResponsable = Util::idResponsable($idUsuario);

        $actuacionesEtapa = DB::table('juriactuaciones')
                            ->leftJoin('juriresponsables', 'juriactuaciones.juriresponsables_idResponsable', '=', 'juriresponsables.idResponsable')
                            ->leftJoin('usuarios', 'juriresponsables.usuarios_idUsuario', '=', 'usuarios.idUsuario')
                            ->leftJoin('jurijuzgados', 'juriactuaciones.jurijuzgados_idJuzgado', '=', 'jurijuzgados.idJuzgado')
                            ->leftJoin('juritiposactuaciones', 'juriactuaciones.juritiposactuaciones_idTipoActuacion', '=', 'juritiposactuaciones.idTipoActuacion')
                            ->leftJoin('juriautoridadconoce', 'juriactuaciones.juriautoridadconoce_idAutoridadConoce', '=', 'juriautoridadconoce.idAutoridadConoce')
                            ->where('jurietapas_idEtapa', '=', $request->input('idEtapa'))
                            ->where('juriradicados_vigenciaRadicado', '=', $request->input('vigenciaRadicado'))
                            ->where('juriradicados_idRadicado', '=', $request->input('idRadicado'))
                            ->where('fechaActuacion', '!=', '0000-00-00')
                            ->where('comentarioActuacion', '!=', '')
                            ->orderby('fechaActuacion','desc')
                            ->get();

        return view('ajax_actuacionProcesal.ajaxActuaciones')
                ->with('idResponsable', $idResponsable)
                ->with('actuacionesEtapa', $actuacionesEtapa)
                ->with('idEtapa', $request->input('idEtapa'))
                ->with('ver', $request->input('ver'));
    }

    public function actionUploadArchivoActuacion(Request $request)
    {
        $idUsuario = Session::get('idUsuario');
        $idResponsable = Util::idResponsable($idUsuario);

        //El nombre temporal del archivo en el que se guarda el archivo cargado en el servidor
        $temporalFile = isset($_FILES['file']['tmp_name']) ? $_FILES['file']['tmp_name'] : null;
        //Nombre del archivo
        $fileName = isset($_FILES['file']['name']) ? $_FILES['file']['name'] : null;
        $fileName = Util::replace_specials_characters($fileName);
        //Extensión Archivo
        $trozos  = explode(".", $fileName);
        $fileExt = end($trozos);

        $newFileName = time().rand(100, 999).'_'.$fileName;
        $path = "/juriArch/archivos/".$request->input('idRadicado')."-".$request->input('vigenciaRadicado')."/";

        //Si no exite la carpeta la crea
        if (!file_exists(public_path() . $path))
        {
            mkdir(public_path() . $path, 0777, true);
        }

        //Si el archivo se copió correctamente en el servidor
        if (move_uploaded_file($temporalFile, public_path() . $path . utf8_decode($newFileName)))
        {
            $archivo  = new Archivo;
            $archivo->nombreArchivo                     = $newFileName;
            $archivo->extensionArchivo                  = $fileExt;
            $archivo->juriradicados_vigenciaRadicado    = $request->input('vigenciaRadicado');
            $archivo->juriradicados_idRadicado          = $request->input('idRadicado');
            $archivo->juriresponsables_idResponsable    = $idResponsable;
            $archivo->juriactuaciones_idActuacion       = $request->input('idActuacion');
            $archivo->save();

            return 1;// subió correctamente
        }
        else
        {
            return 2;// no subió
        }
    }

    public function actionValidarEliminarArchivo(Request $request)
    {
        //Se busca el documento
        $archivo = Archivo::find($request->input('idArchivo'));
        //Se procede a quitar del servidor
        $rutaArchivo = "juriArch/archivos/".$archivo->juriradicados_idRadicado."-".$archivo->juriradicados_vigenciaRadicado."/".utf8_decode($archivo->nombreArchivo);

        // 1. Borra la imagen del servidor
        unlink($rutaArchivo);

        Archivo::where('idArchivo', '=', $request->input('idArchivo'))->delete();

        return 1;
    }

    public function actionValidarEliminarActuacion(Request $request)
    {
        $archivosActuacion = DB::table('juriarchivos')
                                    ->where('juriactuaciones_idActuacion', '=', $request->input('idActuacion'))
                                    ->get();

        if(count($archivosActuacion) > 0)
        {
            foreach ($archivosActuacion as $archivoActuacion) 
            {
                //Se procede a quitar del servidor
                $rutaArchivo = "juriArch/archivos/".$archivoActuacion->juriradicados_idRadicado."-".$archivoActuacion->juriradicados_vigenciaRadicado."/".utf8_decode($archivoActuacion->nombreArchivo);

                // 1. Borra la imagen del servidor
                unlink($rutaArchivo);

                Archivo::where('idArchivo', '=', $archivoActuacion->idArchivo)->delete();
            } 
        }

        FalloRadicado::where('juriactuaciones_idActuacion', '=', $request->input('idActuacion'))->delete();
        ActuacionResponsable::where('juriactuaciones_idActuacion', '=', $request->input('idActuacion'))->delete();
        ActuacionProcesal::where('idActuacion', '=', $request->input('idActuacion'))->delete();

        return 1;
    }

    public function actionTipoActuacionSeleccionada(Request $request)
    {
        $observacionActuacion = DB::table('juritiposestadosactuaciones')
                                ->where('idTipoEstadoActuacion', '=', $request->input('idTipoEstadoActuacion'))
                                ->get();

        if($request->input('idTipoEstadoActuacion') == 1)//terminados
        {
            $tiposActuaciones = DB::table('juritiposactuaciones')
                            ->where('juritipoprocesos_idTipoProcesos', '=', $request->input('idTipoProceso'))
                            ->where('activo', '=', 1)
                            ->where('tipoActuacionFinaliza', '=', 1)
                            ->orderBy('idTipoActuacion', 'asc')
                            ->pluck('nombreActuacion', 'idTipoActuacion');
        }
        else if($request->input('idTipoEstadoActuacion') == 2)//fallos
        {
            $tiposActuaciones = DB::table('juritiposactuaciones')
                            ->where('juritipoprocesos_idTipoProcesos', '=', $request->input('idTipoProceso'))
                            ->where('activo', '=', 1)
                            ->where('tipoFallo', '=', 1)
                            ->orderBy('idTipoActuacion', 'asc')
                            ->pluck('nombreActuacion', 'idTipoActuacion');
        }
        else if($request->input('idTipoEstadoActuacion') == 3)//cambios de estados historial
        {
            $tiposActuaciones = DB::table('juritiposactuaciones')
                            ->where('juritipoprocesos_idTipoProcesos', '=', $request->input('idTipoProceso'))
                            ->where('activo', '=', 1)
                            ->where('tipoActuacionFinaliza', '=', 0)
                            ->where('tipoFallo', '=', 0)
                            ->orderBy('idTipoActuacion', 'asc')
                            ->pluck('nombreActuacion', 'idTipoActuacion');
        }
        else
        {
            $tiposActuaciones = DB::table('juritiposactuaciones')
                            ->where('juritipoprocesos_idTipoProcesos', '=', $request->input('idTipoProceso'))
                            ->where('activo', '=', 1)
                            ->where('cumplimiento', '=', 1)
                            ->orderBy('idTipoActuacion', 'asc')
                            ->pluck('nombreActuacion', 'idTipoActuacion');
        }

        return view('ajax_actuacionProcesal.ajaxTiposActuaciones')
                ->with('tiposActuaciones', $tiposActuaciones)
                ->with('observacionActuacion', $observacionActuacion[0]->observacionEstadoActuacion)
                ->with('idTipoEstadoActuacion', $request->input('idTipoEstadoActuacion'));
    }

    public function actionEditarActuacion(Request $request)
    {
        $tipoProceso = 0;
        $despachos   = [];
        $despacho    = '';

        $actuacion = DB::table('juriactuaciones')
                        ->select('juriactuaciones.comentarioActuacion', 'juriactuaciones.fechaActuacion', 'juriactuaciones.jurijuzgados_idJuzgado', 'juriactuaciones.juriautoridadconoce_idAutoridadConoce', 'juriradicados.juritipoprocesos_idTipoProceso')
                        ->join('juriradicados', function ($join) {
                            $join->on('juriactuaciones.juriradicados_vigenciaRadicado', '=', 'juriradicados.vigenciaRadicado')
                            ->on('juriactuaciones.juriradicados_idRadicado', '=', 'juriradicados.idRadicado');
                        })
                        ->where('idActuacion', '=', $request->input('idActuacion'))
                        ->get();

        if(count($actuacion) > 0)
        {
            $tipoProceso = $actuacion[0]->juritipoprocesos_idTipoProceso;
        }

        if($tipoProceso == 2)//procuradurías conciliaciones
        {
            $despacho = $actuacion[0]->juriautoridadconoce_idAutoridadConoce;

            $despachos = DB::table('juriautoridadconoce')
                            ->orderBy('idAutoridadConoce', 'asc')
                            ->pluck('nombreAutoridadConoce', 'idAutoridadConoce');
        }
        else if($tipoProceso == 1 || $tipoProceso == 3)// demandas o tutelas
        {
            $despacho = $actuacion[0]->jurijuzgados_idJuzgado;

            $despachos = DB::table('jurijuzgados')
                            ->orderBy('idJuzgado', 'asc')
                            ->pluck('nombreJuzgado', 'idJuzgado');
        }

        return view('ajax_actuacionProcesal.ajaxEditarActuacion')
                ->with('actuacion', $actuacion)
                ->with('despachos', $despachos)
                ->with('despacho', $despacho)
                ->with('tipoProceso', $tipoProceso)
                ->with('idActuacion', $request->input('idActuacion'))
                ->with('idEtapa', $request->input('idEtapa'));
    }

    public function actionValidarEditarActuacion(Request $request)
    {
        if($request->input('tipoProceso') == 2)
        {
            DB::table('juriactuaciones')
                    ->where('idActuacion', $request->input('idActuacion'))
                    ->update([
                            'juriautoridadconoce_idAutoridadConoce' => $request->input('selectJuzgadoEdit'),
                            'fechaActuacion'        => $request->input('fechaActuProceEdit'),
                            'comentarioActuacion'   => $request->input('comentarioActuacionEdit')]);

        }
        else if($request->input('tipoProceso') == 1 || $request->input('tipoProceso') == 3)
        {
            DB::table('juriactuaciones')
                    ->where('idActuacion', $request->input('idActuacion'))
                    ->update([
                            'jurijuzgados_idJuzgado'   => $request->input('selectJuzgadoEdit'),  
                            'fechaActuacion'           => $request->input('fechaActuProceEdit'),
                            'comentarioActuacion'      => $request->input('comentarioActuacionEdit')]);
  
        }
        
        return;
    }
}