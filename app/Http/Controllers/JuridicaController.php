<?php
namespace SQ10\Http\Controllers;

use DB;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Session;
use SQ10\Models\Archivo;
use SQ10\Models\Usuario;
use SQ10\Models\Responsable;
use SQ10\Models\EstadoEtapa;
use SQ10\Models\CuantiaRadicado;
use SQ10\Models\Involucrado;
use SQ10\Models\ConvocadoExterno;
use SQ10\Models\Abogado;
use SQ10\Models\Tema;
use SQ10\Models\Radicado;
use SQ10\Models\Juzgado;
use SQ10\helpers\Util as Util;

class JuridicaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function actionVerArchivoPdf($idArchivo, $vigenciaRadicado, $idRadicado)
    {
        $archivoRadicado = Archivo::find($idArchivo);

        $filename = 'juriArch/archivos/'.$idRadicado.'-'.$vigenciaRadicado.'/'.mb_convert_encoding($archivoRadicado->nombreArchivo, 'UTF-8');

        $path = public_path($filename);

        return response(file_get_contents($path), 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
        ]);
    }

    public function actionVerArchivoMigradoPdf($consecutivo)
    {
        $archivo = DB::table('jurianexosmigrados')
                        ->where('id', '=', $consecutivo)
                        ->get();

        $filename = '/mnt/disks/particion3/files_demandas/'.mb_convert_encoding($archivo[0]->nombreArchivo, 'UTF-8');
        $path = $filename;

        return response(file_get_contents($path), 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $archivo[0]->nombreArchivo . '"',
        ]);
    }


    public function actionDescargarArchivo($idArchivo)
    {
        $archivoRadicado = Archivo::find($idArchivo);

        $rutaArchivo = "juriArch/archivos/".$archivoRadicado->juriradicados_idRadicado."-".$archivoRadicado->juriradicados_vigenciaRadicado."/".utf8_decode($archivoRadicado->nombreArchivo); 

        header("Content-type: application/octet-stream");
        header("Content-Disposition: attachment; filename=\"$archivoRadicado->nombreArchivo\"\n");
        $fp=fopen("$rutaArchivo", "r");
        fpassthru($fp);
    }

    public function actionDescargarArchivoMigrado($consecutivo)
    {
        $archivo = DB::table('jurianexosmigrados')
            ->where('id', '=', $consecutivo)
            ->first();

        $rutaArchivo = '/mnt/disks/particion3/files_demandas/'.mb_convert_encoding($archivo->nombreArchivo, 'UTF-8');

        //var_dump($rutaArchivo);return;

        header("Content-type: application/octet-stream");
        header("Content-Disposition: attachment; filename=\"$archivo->nombreArchivo\"\n");
        $fp=fopen("$rutaArchivo", "r");
        fpassthru($fp);
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
                                          ->with('noAgregar', $request->input('noAgregar'))
                                          ->with('etapas', $etapas)
                                          ->render(),
                                'etapaInicial' => $etapaInicial]);
    }

    public function actionActuacionesEtapa(Request $request)
    {
        $actuacionesEtapa = DB::table('juriactuaciones')
                            ->leftJoin('jurijuzgados', 'juriactuaciones.jurijuzgados_idJuzgado', '=', 'jurijuzgados.idJuzgado')
                            ->leftJoin('juritiposactuaciones', 'juriactuaciones.juritiposactuaciones_idTipoActuacion', '=', 'juritiposactuaciones.idTipoActuacion')
                            ->leftJoin('juriautoridadconoce', 'juriactuaciones.juriautoridadconoce_idAutoridadConoce', '=', 'juriautoridadconoce.idAutoridadConoce')
                            ->where('jurietapas_idEtapa', '=', $request->input('idEtapa'))
                            ->where('juriradicados_vigenciaRadicado', '=', $request->input('vigenciaRadicado'))
                            ->where('juriradicados_idRadicado', '=', $request->input('idRadicado'))
                            ->get();

        return view('ajax_actuacionProcesal.ajaxActuaciones')
                ->with('actuacionesEtapa', $actuacionesEtapa)
                ->with('idEtapa', $request->input('idEtapa'))
                ->with('ver', $request->input('ver'))
                ->with('noAccion', 1);
    }

    public function actionExpedienteDigital(Request $request)
    {
        $expedienteDigital = DB::table('juriarchivos')
                                    ->leftJoin('juriactuaciones', 'juriarchivos.juriactuaciones_idActuacion', 'juriactuaciones.idActuacion')
                                    ->leftJoin('jurietapas', 'juriactuaciones.jurietapas_idEtapa', 'jurietapas.idEtapa')
                                    ->leftJoin('juriresponsables', 'juriarchivos.juriresponsables_idResponsable', 'juriresponsables.idResponsable')
                                    ->leftJoin('usuarios', 'juriresponsables.usuarios_idUsuario', 'usuarios.idUsuario')
                                    ->where('juriarchivos.juriradicados_vigenciaRadicado', '=', $request->input('vigenciaRadicado'))
                                    ->where('juriarchivos.juriradicados_idRadicado', '=', $request->input('idRadicado'))
                                    ->orderby('fechaAportado','desc')
                                    ->get();

        return view('ajax_comunes.ajaxTablaExpedienteDigital')
                ->with('expedienteDigital', $expedienteDigital)
                ->with('vigenciaRadicado', $request->input('vigenciaRadicado'))
                ->with('idRadicado', $request->input('idRadicado'));
    }

    public function expedienteDigitalMigrados(Request $request)
    {
        $expedienteDigitalMigrado = DB::table('jurianexosmigrados')
                                      ->where('consecutivo', '=', $request->input('mzlConsecutivo'))
                                        ->get();

        return view('ajax_comunes.ajaxTablaExpedienteDigitalMigrados')
             ->with('expedienteDigitalMigrado', $expedienteDigitalMigrado);
    }

    public function actionDescargarPoder($vector)
    {
        //Decodifica el vector json
        $datos = json_decode($vector, true);
        $idUsuario = Session::get('idUsuario');
        $fechaHoy  = Util::formatearFecha(date("Y-m-d"));
        //------------------------------------------------------      
 
        $proceso = DB::table('juriradicados')
                    ->leftJoin('jurimedioscontrol', 'juriradicados.jurimedioscontrol_idMediosControl', '=', 'jurimedioscontrol.idMediosControl')
                    ->join('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                    ->leftJoin('juriautoridadconoce', 'juriradicados.juriautoridadconoce_idAutoridadConoce', '=', 'juriautoridadconoce.idAutoridadConoce')
                    ->leftJoin('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
                    ->leftJoin('jurijuzgados', 'juriradicados.jurijuzgados_idJuzgado', '=', 'jurijuzgados.idJuzgado')
                    ->where('vigenciaRadicado', '=', $datos['vigenciaRadicado'])
                    ->where('idRadicado', '=', $datos['idRadicado'])
                    ->first();
                    
        //$dependenciaUsuario = Session::get('responsable')->idDependencia; 
        $demandante = Util::personaDemandante($datos['vigenciaRadicado'], $datos['idRadicado'], $proceso->juritipoprocesos_idTipoProceso);

        if($proceso->juritipoprocesos_idTipoProceso == 1)
        {
            //$templateWord = new \PhpOffice\PhpWord\TemplateProcessor('juriArch/'.$dependenciaUsuario.'/poderes/proceso-judicial.docx');
            return;
        }
        else if($proceso->juritipoprocesos_idTipoProceso == 2)
        {
            //$templateWord = new \PhpOffice\PhpWord\TemplateProcessor('juriArch/'.$dependenciaUsuario.'/poderes/conciliacion.docx');
            return;
        }
        else if($proceso->juritipoprocesos_idTipoProceso == 3)
        {
            //$templateWord = new \PhpOffice\PhpWord\TemplateProcessor('juriArch/'.$dependenciaUsuario.'/poderes/tutela.docx');
            $templateWord = new \PhpOffice\PhpWord\TemplateProcessor('juriArch/poderes/tutela.docx');
        }

        $dependenciasInvolucradas = Util::dependenciaDemandada($datos['vigenciaRadicado'], $datos['idRadicado'], $proceso->juritipoprocesos_idTipoProceso);
        $entidadesExternasInvolucradas = Util::entidadExternaDemandada($datos['vigenciaRadicado'], $datos['idRadicado'], $proceso->juritipoprocesos_idTipoProceso);
        $demandados = $dependenciasInvolucradas." ".$entidadesExternasInvolucradas;
        $abogado = Util::datosUltimoUsuarioRadicado($datos['idEstadoEtapa']);

        $nombrePlantilla = "Poder - Radicado ".$proceso->radicadoJuzgado." del ".$proceso->nombreJuzgado;        
    
        $templateWord->setValue('fechaHoy',              strtolower(utf8_decode($fechaHoy)));
        $templateWord->setValue('nombreJuzgado',         $proceso->nombreJuzgado);
        $templateWord->setValue('direccionJuzgado',      $proceso->direccionJuzgado);
        $templateWord->setValue('municipioJuzgado',      ucfirst(strtolower($proceso->municipioJuzgado)));
        $templateWord->setValue('radicadoJuzgado',       $proceso->radicadoJuzgado); 
        $templateWord->setValue('medioControl',          strtoupper($proceso->nombreMedioControl)); 
        $templateWord->setValue('demandante',            strtoupper($demandante)); 
        $templateWord->setValue('demandados',            strtoupper($demandados)); 
        $templateWord->setValue('nombreAbogado',         strtoupper($abogado->nombresUsuario)); 
        $templateWord->setValue('cargoAbogado',          $abogado->nombreCargo); 
        $templateWord->setValue('dependenciaAbogado',    $abogado->nombreDependencia); 
        $templateWord->setValue('documentoAbogado',      $abogado->documentoUsuario); 
        $templateWord->setValue('expedicionAbogado',     $abogado->expedicionSolicitante); 
        $templateWord->setValue('tarjetaAbogado',        $abogado->tarjetaProfesional); 

        //Guarda la bitácora de la acción realizada por el usuario
        $observacion = "Genera el poder del proceso: ".$datos['vigenciaRadicado']."-".$datos['idRadicado'];
        Util::guardarLog($observacion, $datos['vigenciaRadicado'], $datos['idRadicado'], 11);//11 Genera el poder del proceso
        // -------
               
        // --- Se guarda el documento
        $templateWord->saveAs($nombrePlantilla.'.docx');

        header("Content-Disposition: attachment; filename=".$nombrePlantilla.".docx; charset=iso-8859-1");
        echo file_get_contents($nombrePlantilla.'.docx');
        //Elimina el archivo temporal
        Unlink($nombrePlantilla.'.docx');
    }

    public function actionCambiarPass(Request $request)
    {
        $idUsuario = Session::get('idUsuario');
        $usuario = Usuario::find($idUsuario);

        $documento  = $usuario->documentoUsuario;
        $passActual = $usuario->password;

        return view('ajax_comunes.ajaxCambiarPass')
                    ->with('documento', $documento)
                    ->with('passActual', $passActual)
                    ->with('idUsuario', $idUsuario);  
    }

    public function actionValidarNuevaPass(Request $request)
    {
        $usuario = Usuario::find($request->input('idUsuario'));

        if(!Hash::check($request->input('actualPass'), $usuario->password))
        {
            return 0;//la contraseña actual no coincide
        }

        //Actualiza los datos de la contraseña
        $usu = DB::table('usuarios')
                  ->where('idUsuario', '=', $request->input('idUsuario'))
                  ->update(array('password' => Hash::make($request->input('nuevaPass'))));

        return 1;
    }

    public function actionActualizarPerfil(Request $request)
    {
        $idUsuario = Session::get('idUsuario');
        $usuario = Usuario::find($idUsuario);
        $idResponsable = Util::idResponsable($idUsuario);

        $responsable = DB::table('juriresponsables')
                    ->where('idResponsable', '=', $idResponsable)
                    ->get();

        return view('ajax_comunes.ajaxActualizarPerfil')
                    ->with('usuario', $usuario)
                    ->with('responsable', $responsable);  
    }

    public function actionValidarModificarUsuario(Request $request)
    {
        $idResponsable = Util::idResponsable(Session::get('idUsuario'));

        $documento = DB::table('usuarios')
                    ->where('idUsuario', '!=', Session::get('idUsuario'))
                    ->where('documentoUsuario', '=', $request->input('documentoUsuario'))
                    ->count();

        if($documento > 0)
        {
            return 0;//documento se encuentra registrado
        }

        DB::table('usuarios')
                ->where('idUsuario', Session::get('idUsuario'))
                ->update([
                    'documentoUsuario'   => $request->input('documentoUsuario'),
                    'nombresUsuario'     => $request->input('nombreUsuario'),
                    'loginUsuario'       => $request->input('documentoUsuario'),
                    'celularUsuario'     => $request->input('celularUsuario'),
                    'emailUsuario'       => $request->input('emailUsuario')]);

        DB::table('juriresponsables')
                ->where('idResponsable', $idResponsable)
                ->update([
                    'notifiCorreo'   => $request->input('notificacionCorreo'),
                    'notifiSms'      => $request->input('notificacionSms')]);

        return 1; // se modificaron los datos del usuario
    }

    public function actionBuscarProceso(Request $request)
    {
        /*
            selectMetodoBusqueda es 1 radicado interno
            selectMetodoBusqueda es 2 documento demandante
            selectMetodoBusqueda es 3 nombre demandante
            selectMetodoBusqueda es 4 tema
            selectMetodoBusqueda es 5 radicado juzgado
            selectMetodoBusqueda es 6 radicado anterior
        */

        $arrayProcesos = array();

        if($request->input('selectMetodoBusqueda') == 1 || $request->input('selectMetodoBusqueda') == 6)
        {
            if($request->input('selectMetodoBusqueda') == 1)
            {
                $proceso = DB::table('juriradicados')
                            ->join('juriestadosradicados', 'juriradicados.juriestadosradicados_idEstadoRadicado', '=', 'juriestadosradicados.idEstadoRadicado')
                            ->join('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                            ->leftJoin('jurimedioscontrol', 'juriradicados.jurimedioscontrol_idMediosControl', '=', 'jurimedioscontrol.idMediosControl')
                            ->leftJoin('juriautoridadconoce', 'juriradicados.juriautoridadconoce_idAutoridadConoce', '=', 'juriautoridadconoce.idAutoridadConoce')
                            ->leftJoin('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
                            ->leftJoin('jurijuzgados', 'juriradicados.jurijuzgados_idJuzgado', '=', 'jurijuzgados.idJuzgado')
                            ->where('vigenciaRadicado', '=', $request->input('vigenciaProcesoBuscar'))
                            ->where('idRadicado', '=', $request->input('criterioBusqueda'))
                            ->groupBy('juriradicados.vigenciaRadicado')
                            ->groupBy('juriradicados.idRadicado')
                            ->get();

                $estadosEtapas = DB::table('juriestadosetapas')
                            ->select('idEstadoEtapa', 'fechaInicioEstado', 'comentarioEstadoEtapa', 'nombreTipoEstado', 'documentoUsuario', 'nombresUsuario', 'juriresponsables_idResponsable')
                            ->leftJoin('juriresponsables', 'juriestadosetapas.juriresponsables_idResponsable', '=', 'juriresponsables.idResponsable')
                            ->leftJoin('juritiposestados', 'juriestadosetapas.juritiposestados_idTipoEstado', '=', 'juritiposestados.idTipoEstado')
                            ->leftJoin('usuarios', 'juriresponsables.usuarios_idUsuario', '=', 'usuarios.idUsuario')
                            ->where('juriradicados_vigenciaRadicado', '=',  $request->input('vigenciaProcesoBuscar'))
                            ->where('juriradicados_idRadicado', '=', $request->input('criterioBusqueda'))
                            //->orderby('idEstadoEtapa','desc')
                            //->take(1)// último registro en estado etapa
                            ->get(); 
            }
            else if($request->input('selectMetodoBusqueda') == 6)
            {
                $proceso = DB::table('juriradicados')
                            ->leftJoin('juriestadosradicados', 'juriradicados.juriestadosradicados_idEstadoRadicado', '=', 'juriestadosradicados.idEstadoRadicado')
                            ->leftJoin('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                            ->leftJoin('jurimedioscontrol', 'juriradicados.jurimedioscontrol_idMediosControl', '=', 'jurimedioscontrol.idMediosControl')
                            ->leftJoin('juriautoridadconoce', 'juriradicados.juriautoridadconoce_idAutoridadConoce', '=', 'juriautoridadconoce.idAutoridadConoce')
                            ->leftJoin('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
                            ->leftJoin('jurijuzgados', 'juriradicados.jurijuzgados_idJuzgado', '=', 'jurijuzgados.idJuzgado')
                            ->where('mzlConsecutivo', '=', $request->input('criterioBusqueda'))
                            ->groupBy('juriradicados.vigenciaRadicado')
                            ->groupBy('juriradicados.idRadicado')
                            ->get();

                $estadosEtapas = DB::table('juriestadosetapas')
                            ->select('idEstadoEtapa', 'fechaInicioEstado', 'comentarioEstadoEtapa', 'nombreTipoEstado', 'documentoUsuario', 'nombresUsuario', 'juriresponsables_idResponsable')
                            ->leftJoin('juriresponsables', 'juriestadosetapas.juriresponsables_idResponsable', '=', 'juriresponsables.idResponsable')
                            ->leftJoin('juritiposestados', 'juriestadosetapas.juritiposestados_idTipoEstado', '=', 'juritiposestados.idTipoEstado')
                            ->leftJoin('usuarios', 'juriresponsables.usuarios_idUsuario', '=', 'usuarios.idUsuario')
                            ->where('juriradicados_vigenciaRadicado', '=',  $proceso[0]->vigenciaRadicado)
                            ->where('juriradicados_idRadicado', '=', $proceso[0]->idRadicado)
                            //->orderby('idEstadoEtapa','desc')
                            //->take(1)// último registro en estado etapa
                            ->get(); 
            }   
        }
        else if($request->input('selectMetodoBusqueda') == 2 || $request->input('selectMetodoBusqueda') == 3 || $request->input('selectMetodoBusqueda') == 4 || $request->input('selectMetodoBusqueda') == 5 || $request->input('selectMetodoBusqueda') == 7)
        {
            if($request->input('selectMetodoBusqueda') == 2)
            {
                $proceso = DB::table('juriradicados')
                            ->leftJoin('juriinvolucrados', function ($leftJoin) {
                                $leftJoin->on('juriradicados.vigenciaRadicado', '=', 'juriinvolucrados.juriradicados_vigenciaRadicado')
                                    ->on('juriradicados.idRadicado', '=', 'juriinvolucrados.juriradicados_idRadicado');
                            })
                            ->leftJoin('solicitantes', 'juriinvolucrados.solicitantes_idSolicitante', '=', 'solicitantes.idSolicitante')
                            ->leftJoin('jurimedioscontrol', 'juriradicados.jurimedioscontrol_idMediosControl', '=', 'jurimedioscontrol.idMediosControl')
                            ->leftJoin('juriestadosradicados', 'juriradicados.juriestadosradicados_idEstadoRadicado', '=', 'juriestadosradicados.idEstadoRadicado')
                            ->leftJoin('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                            ->leftJoin('juriautoridadconoce', 'juriradicados.juriautoridadconoce_idAutoridadConoce', '=', 'juriautoridadconoce.idAutoridadConoce')
                            ->leftJoin('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
                            ->leftJoin('jurijuzgados', 'juriradicados.jurijuzgados_idJuzgado', '=', 'jurijuzgados.idJuzgado')
                            ->where('documentoSolicitante', '=', $request->input('criterioBusqueda'))
                            ->orderBy('juriradicados.vigenciaRadicado', 'asc')
                            ->orderBy('juriradicados.idRadicado', 'asc')
                            ->groupBy('juriradicados.vigenciaRadicado')
                            ->groupBy('juriradicados.idRadicado')
                            ->get();
            }
            else if($request->input('selectMetodoBusqueda') == 3)
            {
                $proceso = DB::table('juriradicados')
                            ->leftJoin('juriinvolucrados', function ($leftJoin) {
                                $leftJoin->on('juriradicados.vigenciaRadicado', '=', 'juriinvolucrados.juriradicados_vigenciaRadicado')
                                    ->on('juriradicados.idRadicado', '=', 'juriinvolucrados.juriradicados_idRadicado');
                            })
                            ->leftJoin('solicitantes', 'juriinvolucrados.solicitantes_idSolicitante', '=', 'solicitantes.idSolicitante')
                            ->leftJoin('jurimedioscontrol', 'juriradicados.jurimedioscontrol_idMediosControl', '=', 'jurimedioscontrol.idMediosControl')
                            ->leftJoin('juriestadosradicados', 'juriradicados.juriestadosradicados_idEstadoRadicado', '=', 'juriestadosradicados.idEstadoRadicado')
                            ->leftJoin('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                            ->leftJoin('juriautoridadconoce', 'juriradicados.juriautoridadconoce_idAutoridadConoce', '=', 'juriautoridadconoce.idAutoridadConoce')
                            ->leftJoin('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
                            ->leftJoin('jurijuzgados', 'juriradicados.jurijuzgados_idJuzgado', '=', 'jurijuzgados.idJuzgado')
                            ->where('nombreSolicitante', 'LIKE', '%'.$request->input('criterioBusqueda').'%')
                            ->orderBy('juriradicados.vigenciaRadicado', 'asc')
                            ->orderBy('juriradicados.idRadicado', 'asc')
                            ->groupBy('juriradicados.vigenciaRadicado')
                            ->groupBy('juriradicados.idRadicado')
                            ->get();
            }
            else if($request->input('selectMetodoBusqueda') == 4)
            {
                $proceso = DB::table('juriradicados')
                            ->leftJoin('juriinvolucrados', function ($leftJoin) {
                                $leftJoin->on('juriradicados.vigenciaRadicado', '=', 'juriinvolucrados.juriradicados_vigenciaRadicado')
                                    ->on('juriradicados.idRadicado', '=', 'juriinvolucrados.juriradicados_idRadicado');
                            })
                            ->leftJoin('solicitantes', 'juriinvolucrados.solicitantes_idSolicitante', '=', 'solicitantes.idSolicitante')
                            ->leftJoin('jurimedioscontrol', 'juriradicados.jurimedioscontrol_idMediosControl', '=', 'jurimedioscontrol.idMediosControl')
                            ->leftJoin('juriestadosradicados', 'juriradicados.juriestadosradicados_idEstadoRadicado', '=', 'juriestadosradicados.idEstadoRadicado')
                            ->leftJoin('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                            ->leftJoin('juriautoridadconoce', 'juriradicados.juriautoridadconoce_idAutoridadConoce', '=', 'juriautoridadconoce.idAutoridadConoce')
                            ->leftJoin('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
                            ->leftJoin('jurijuzgados', 'juriradicados.jurijuzgados_idJuzgado', '=', 'jurijuzgados.idJuzgado')
                            ->where('nombreTema', 'LIKE', '%'.$request->input('criterioBusqueda').'%')
                            ->orderBy('juriradicados.vigenciaRadicado', 'asc')
                            ->orderBy('juriradicados.idRadicado', 'asc')
                            ->groupBy('juriradicados.vigenciaRadicado')
                            ->groupBy('juriradicados.idRadicado')
                            ->get();
            }
            else if($request->input('selectMetodoBusqueda') == 7)
            {
                $proceso = DB::table('juriradicados')
                            ->leftJoin('juriinvolucrados', function ($leftJoin) {
                                $leftJoin->on('juriradicados.vigenciaRadicado', '=', 'juriinvolucrados.juriradicados_vigenciaRadicado')
                                    ->on('juriradicados.idRadicado', '=', 'juriinvolucrados.juriradicados_idRadicado');
                            })
                            ->leftJoin('solicitantes', 'juriinvolucrados.solicitantes_idSolicitante', '=', 'solicitantes.idSolicitante')
                            ->leftJoin('jurimedioscontrol', 'juriradicados.jurimedioscontrol_idMediosControl', '=', 'jurimedioscontrol.idMediosControl')
                            ->leftJoin('juriestadosradicados', 'juriradicados.juriestadosradicados_idEstadoRadicado', '=', 'juriestadosradicados.idEstadoRadicado')
                            ->leftJoin('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                            ->leftJoin('juriautoridadconoce', 'juriradicados.juriautoridadconoce_idAutoridadConoce', '=', 'juriautoridadconoce.idAutoridadConoce')
                            ->leftJoin('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
                            ->leftJoin('jurijuzgados', 'juriradicados.jurijuzgados_idJuzgado', '=', 'jurijuzgados.idJuzgado')
                            ->where('asunto', 'LIKE', '%'.$request->input('criterioBusqueda').'%')
                            ->orderBy('juriradicados.vigenciaRadicado', 'asc')
                            ->orderBy('juriradicados.idRadicado', 'asc')
                            ->groupBy('juriradicados.vigenciaRadicado')
                            ->groupBy('juriradicados.idRadicado')
                            ->get();
            }
            else if($request->input('selectMetodoBusqueda') == 5)
            {
                $radicadoJuzgado = str_replace("-","",$request->input('criterioBusquedaJuz'));
                $q = "+".preg_replace( '/\s(\w+)/', ' +\\1', $radicadoJuzgado);

                $proceso = DB::table('juriradicados')
                            ->leftJoin('juriinvolucrados', function ($leftJoin) {
                                $leftJoin->on('juriradicados.vigenciaRadicado', '=', 'juriinvolucrados.juriradicados_vigenciaRadicado')
                                    ->on('juriradicados.idRadicado', '=', 'juriinvolucrados.juriradicados_idRadicado');
                            })
                            ->leftJoin('solicitantes', 'juriinvolucrados.solicitantes_idSolicitante', '=', 'solicitantes.idSolicitante')
                            ->leftJoin('juriestadosradicados', 'juriradicados.juriestadosradicados_idEstadoRadicado', '=', 'juriestadosradicados.idEstadoRadicado')
                            ->leftJoin('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                            ->leftJoin('juriautoridadconoce', 'juriradicados.juriautoridadconoce_idAutoridadConoce', '=', 'juriautoridadconoce.idAutoridadConoce')
                            ->leftJoin('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
                            ->leftJoin('jurijuzgados', 'juriradicados.jurijuzgados_idJuzgado', '=', 'jurijuzgados.idJuzgado')
                            ->leftJoin('jurimedioscontrol', 'juriradicados.jurimedioscontrol_idMediosControl', '=', 'jurimedioscontrol.idMediosControl')
                            ->whereRaw('MATCH(radicadoJuzgado) AGAINST(? IN BOOLEAN MODE)', array($q))
                            ->orWhere("radicadoJuzgado", $radicadoJuzgado)
                            ->orWhere("radicadoJuzgado", 'like' , '%'.$radicadoJuzgado.'%')
                            ->orderBy('juriradicados.vigenciaRadicado', 'asc')
                            ->orderBy('juriradicados.idRadicado', 'asc')
                            ->groupBy('juriradicados.vigenciaRadicado')
                            ->groupBy('juriradicados.idRadicado')
                            ->get();

            }

            if(count($proceso) > 0)
            {
                foreach ($proceso as $proces) 
                {
                    $idEstadoEtapa = DB::table('juriestadosetapas')
                        ->select('idEstadoEtapa', 'nombresUsuario')
                        ->join('juriresponsables', 'juriestadosetapas.juriresponsables_idResponsable', '=', 'juriresponsables.idResponsable')
                        ->join('usuarios', 'juriresponsables.usuarios_idUsuario', '=', 'usuarios.idUsuario')
                        ->where('juriradicados_vigenciaRadicado', '=',  $proces->vigenciaRadicado)
                        ->where('juriradicados_idRadicado', '=', $proces->idRadicado)
                        ->orderby('idEstadoEtapa','desc')
                        ->take(1)// último registro en estado etapa
                        ->get();

                    if(count($idEstadoEtapa) > 0)
                    {
                        if($proces->juritipoprocesos_idTipoProceso == 1)
                        {
                            $rutaProceso = 'actuacionProc-judi/index/'.$idEstadoEtapa[0]->idEstadoEtapa;
                        }
                        else if($proces->juritipoprocesos_idTipoProceso == 2)
                        {
                            $rutaProceso = 'actuacionConci-prej/index/'.$idEstadoEtapa[0]->idEstadoEtapa;
                        }
                        else if($proces->juritipoprocesos_idTipoProceso == 3)
                        {
                            $rutaProceso = 'actuacionTutelas/index/'.$idEstadoEtapa[0]->idEstadoEtapa;
                        }

                        $datos = array('vigenciaRadicado'       => $proces->vigenciaRadicado,
                                       'idRadicado'             => $proces->idRadicado,
                                       'responsableTitular'             
                                                                => $proces->juriresponsables_idResponsable_titular,
                                       'fechaRadicado'          => $proces->fechaRadicado,
                                       'nombreJuzgado'          => $proces->nombreJuzgado,
                                       'nombreEstadoRadicado'   => $proces->nombreEstadoRadicado,
                                       'fechaNotificacion'      => $proces->fechaNotificacion,
                                       'nombreMedioControl'     => $proces->nombreMedioControl,
                                       'nombreTipoProceso'      => $proces->nombreTipoProceso,
                                       'nombreTema'             => $proces->nombreTema,
                                       'radicadoJuzgado'        => $proces->radicadoJuzgado,
                                       'idTipoProcesos'         => $proces->juritipoprocesos_idTipoProceso,
                                       'idEstadoEtapa'          => $idEstadoEtapa[0]->idEstadoEtapa,
                                       'asunto'                 => $proces->asunto,
                                       'nombresUsuario'         => $idEstadoEtapa[0]->nombresUsuario,
                                       'ruta'                   => $rutaProceso);

                        array_push($arrayProcesos, $datos);
                    }
                }
            }
        }
        
        if(count($proceso) > 0)
        {
           if($request->input('selectMetodoBusqueda') == 1 || $request->input('selectMetodoBusqueda') == 6)
            { 
                return view('ajax_comunes.ajaxBuscarProceso')
                     ->with('proceso', $proceso)
                     ->with('estadosEtapas', $estadosEtapas);
            }
            else if(count($proceso) > 0 && ($request->input('selectMetodoBusqueda') == 2 || $request->input('selectMetodoBusqueda') == 3 || $request->input('selectMetodoBusqueda') == 4 || $request->input('selectMetodoBusqueda') == 5 || $request->input('selectMetodoBusqueda') == 7))
            {
                return view('ajax_comunes.ajaxTablaBuscarProceso')
                                ->with('proceso', $arrayProcesos);  
            } 
        }
        else
        {
            return 0;//no encuentra proceso
        }
    }

    public function actionTareasInformativas(Request $request)
    {
        $idUsuario = Session::get('idUsuario');
        $idResponsable = Util::idResponsable($idUsuario);
        $fechaActual  = date("d-m-Y");

        if($request->input('parametroFecha') == 1)
        {
            $fecha = date( 'Y-m-d');
            $texto = "hoy";
        }
        else if($request->input('parametroFecha') == 2)
        {
            $fecha = date("Y-m-d",strtotime($fechaActual."+ 1 days"));
            $texto = "mañana";
        }
        else if($request->input('parametroFecha') == 3)
        {
            $fecha = date("Y-m-d",strtotime($fechaActual."+ 2 days"));
            $texto = "pasado mañana";
        }

        $tareasAgenda = array();

        $agendas = DB::table('juriagendas')
            ->where('juriresponsables_idResponsable', '=', $idResponsable)
            ->where(DB::raw('substr(fechaInicioAgenda, -19, 10)'), '=', $fecha)
            ->where('agendaFinalizada', '=', 0)
            ->get();

        if(count($agendas) > 0)
        {
            foreach ($agendas as $agenda)
            {
                $datos = array('agendaFinalizada'               => $agenda->agendaFinalizada,
                               'fechaInicioAgenda'              => $agenda->fechaInicioAgenda,
                               'asuntoAgenda'                   => $agenda->asuntoAgenda,
                               'juriradicados_vigenciaRadicado' => $agenda->juriradicados_vigenciaRadicado,
                               'juriradicados_idRadicado'       => $agenda->juriradicados_idRadicado,
                               'Id'                             => $agenda->Id);

                array_push($tareasAgenda, $datos);
            }
        }

        $tareasH = DB::table('juriagendas')
                ->where('juriresponsables_idResponsable', '=', $idResponsable)
                ->where(DB::raw('substr(fechaInicioAgenda, -19, 10)'), '=', date( 'Y-m-d'))
                ->where('agendaFinalizada', '=', 0)
                ->count();

        $tareasM = DB::table('juriagendas')
                ->where('juriresponsables_idResponsable', '=', $idResponsable)
                ->where(DB::raw('substr(fechaInicioAgenda, -19, 10)'), '=', date("Y-m-d",strtotime($fechaActual."+ 1 days")))
                ->where('agendaFinalizada', '=', 0)
                ->count();

        $tareasDosDias = DB::table('juriagendas')
                ->where('juriresponsables_idResponsable', '=', $idResponsable)
                ->where(DB::raw('substr(fechaInicioAgenda, -19, 10)'), '=', date("Y-m-d",strtotime($fechaActual."+ 2 days")))
                ->where('agendaFinalizada', '=', 0)
                ->count();

        return response()->json(['vista'     => view('ajax_comunes.ajaxTareasInformativas')
                                                ->with('tareas', $tareasAgenda)
                                                ->with('texto', $texto)
                                                ->render(),
                                'cantTareasH'       => $tareasH,
                                'cantTareasM'       => $tareasM,
                                'cantTareasDosDias' => $tareasDosDias]);
    }

    public function actionNuevoArchivo(Request $request)
    {
        return view('ajax_comunes.ajaxNuevoArchivo');
    }

    public function actionUploadNuevoArchivo(Request $request)
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
            $archivo->save();

            return 1;// subió correctamente
        }
        else
        {
            return 2;// no subió
        }
    }

    public function actionArchivosIniciales(Request $request)
    {
        $idUsuario = Session::get('idUsuario');
        $idResponsable = Util::idResponsable($idUsuario);

        $archivosCausas = DB::table('juriarchivos')
                        ->where('juriradicados_vigenciaRadicado', '=', $request->input('vigenciaRadicado'))
                        ->where('juriradicados_idRadicado',  '=', $request->input('idRadicado'))
                        ->where('juriposteos_idPosteo',  '=', NULL)
                        ->where('juriactuaciones_idActuacion',  '=', NULL)
                        ->get();

        return view('ajax_comunes.ajaxArchivosCausa')
                ->with('archivosCausas', $archivosCausas)
                ->with('vigenciaRadicado', $request->input('vigenciaRadicado'))
                ->with('idRadicado', $request->input('idRadicado'))
                ->with('responsable', $request->input('responsable'))
                ->with('idResponsable', $idResponsable);
    }

    public function actionRepartoInterno(Request $request)
    {
        $idUsuario = Session::get('idUsuario');
        $idResponsable = Util::idResponsable($idUsuario);

        $listaResponsablesInt = DB::table('juriresposanblesinternos')
                            ->join('juriresponsables' , 'juriresposanblesinternos.juriresponsables_idResponsable_interno', 'juriresponsables.idResponsable')
                            ->join('usuarios' , 'juriresponsables.usuarios_idUsuario', 'usuarios.idUsuario')
                            ->where('juriresponsables_idResponsable', '=', $idResponsable)
                            ->where('estadoResponsable', '=', 1)
                            ->orderBy('idResponsable', 'asc')
                            ->pluck('nombresUsuario', 'idResponsable');

        return view('ajax_comunes.ajaxResponsablesInternos')
                ->with('listaResponsablesInt', $listaResponsablesInt)
                ->with('idResponsable', $idResponsable);
    }

    public function actionValidarGuardarRespInterno(Request $request)
    {
        $idUsuario = Session::get('idUsuario');
        $idResponsableActual = $request->input('idResponsable');

        $estadoActual = EstadoEtapa::find($request->input('idEstadoEtapa'));

        DB::table('juriestadosetapas')
                ->where('idEstadoEtapa', $request->input('idEstadoEtapa'))
                ->update([
                    'fechaFinalEstado' => date("Y-m-d H:i:s"),
                    'comentarioEstadoEtapa' => $request->input('comentarioReparto'),
                    'juritipoestadosetapas_idTipoEstadoEtapa' => 2]);//gestionado
        
        Util::modificarObservacion($estadoActual->juriradicados_vigenciaRadicado, $estadoActual->juriradicados_idRadicado, $request->input('comentarioReparto'));

        $estadoEtapa = new EstadoEtapa;
        $estadoEtapa->fechaInicioEstado                        = date("Y-m-d H:i:s");
        $estadoEtapa->fechaFinalEstado                         = date("Y-m-d H:i:s");
        $estadoEtapa->juritipoestadosetapas_idTipoEstadoEtapa  = 2;// Gestionado etapa de reparto interno
        $estadoEtapa->juriradicados_vigenciaRadicado           = $estadoActual->juriradicados_vigenciaRadicado;
        $estadoEtapa->juriradicados_idRadicado                 = $estadoActual->juriradicados_idRadicado;
        $estadoEtapa->comentarioEstadoEtapa                    = "Se realiza el reparto interno";
        $estadoEtapa->juriresponsables_idResponsable           = $idResponsableActual;//el id actual, quien hace reparto
        $estadoEtapa->juritiposestados_idTipoEstado            = 4;//tipo estado de reparto interno
        $estadoEtapa->save();

        Util::guardarObservacion(date("Y-m-d H:i:s"), date("Y-m-d H:i:s"), 2, $estadoActual->juriradicados_vigenciaRadicado, $estadoActual->juriradicados_idRadicado, 'Se realiza el reparto interno', $idResponsableActual, 4, $estadoEtapa->idEstadoEtapa, 3);

        $estadoEtapa = new EstadoEtapa;
        $estadoEtapa->fechaInicioEstado                        = date("Y-m-d H:i:s");
        $estadoEtapa->juritipoestadosetapas_idTipoEstadoEtapa  = 1;// Actual estado
        $estadoEtapa->juriradicados_vigenciaRadicado           = $estadoActual->juriradicados_vigenciaRadicado;
        $estadoEtapa->juriradicados_idRadicado                 = $estadoActual->juriradicados_idRadicado;
        $estadoEtapa->juriresponsables_idResponsable           = $request->input('selectRespInterno');//el id de la persona A QUIEN SE LE HACE REPARTO
        $estadoEtapa->juritiposestados_idTipoEstado            = 3;//actuación
        $estadoEtapa->save();

        Util::guardarObservacion(date("Y-m-d H:i:s"), Null, 1, $estadoActual->juriradicados_vigenciaRadicado, $estadoActual->juriradicados_idRadicado, '', $request->input('selectRespInterno'), 3, $estadoEtapa->idEstadoEtapa, 4);

        //ENVIAR EMAIL
        $clase = "SQ10\Mail\NotificacionInt";
        $usuario = Usuario::find($idUsuario);

        $proceso = DB::table('juriradicados')
            ->select('nombreTipoProceso', 'descripcionHechos')
            ->join('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
            ->where('vigenciaRadicado', '=', $estadoActual->juriradicados_vigenciaRadicado)
            ->where('idRadicado', '=', $estadoActual->juriradicados_idRadicado)
            ->get();

        if(count($proceso) > 0)
        {
            $nombreProceso = $proceso[0]->nombreTipoProceso;
            $descHechos    = $proceso[0]->descripcionHechos;
        }
        else
        {
            $nombreProceso = "";
            $descHechos    = "";
        }

        $emailUsuario = DB::table('juriresponsables')
            ->select('emailUsuario', 'idUsuario')
            ->join('usuarios', 'juriresponsables.usuarios_idUsuario', '=', 'usuarios.idUsuario')
            ->where('idResponsable', '=', $request->input('selectRespInterno'))
            ->get();

        $data = array('idRadicado'              => $estadoActual->juriradicados_idRadicado, 
                      'vigenciaRadicado'        => $estadoActual->juriradicados_vigenciaRadicado, 
                      'nombreTipoProceso'       => $nombreProceso,
                      'causasHechos'            => $descHechos,
                      'usuarioActual'           => $usuario->nombresUsuario);

        if(count($emailUsuario) > 0)
        {
            $idUsuarioSiguiente = $emailUsuario[0]->idUsuario;
            //#ENVIAR EMAIL
            Util::enviarEmail($data, $emailUsuario[0]->emailUsuario, $clase, $estadoActual->juriradicados_vigenciaRadicado, $estadoActual->juriradicados_idRadicado);
            //#ENVIAR EMAIL
        }
        else
        {
            $idUsuarioSiguiente = 0;
        }
        
        $observacion = "Realiza el reparto Interno";
        Util::guardarLog($observacion, $estadoActual->juriradicados_vigenciaRadicado, $estadoActual->juriradicados_idRadicado, 4);

        return $idUsuarioSiguiente;
    }

    public function actionValidarEliminarArchivoCausa(Request $request)
    {
        //Se busca el documento
        $archivo = Archivo::find($request->input('idArchivo'));
        //Se procede a quitar del servidor
        $rutaArchivo = 'juriArch/archivos/'.$archivo->juriradicados_idRadicado."-".$archivo->juriradicados_vigenciaRadicado."/".utf8_decode($archivo->nombreArchivo); //Ruta completa a la imagen a borrar

        // 1. Borra la imagen del servidor
        unlink($rutaArchivo);

        Archivo::where('idArchivo', '=', $request->input('idArchivo'))->delete();

        return;
    }

    public function actionCuantiasRadicado(Request $request)
    {
        $idUsuario = Session::get('idUsuario');
        $idResponsable = Util::idResponsable($idUsuario);
        $responsable = Responsable::find($idResponsable);
        
        $cuantias = DB::table('juricuantiaradicado')
                    ->where('juriradicados_vigenciaRadicado', '=', $request->input('vigenciaRadicado'))
                    ->where('juriradicados_idRadicado', '=', $request->input('idRadicado'))
                    ->get();

        return view('ajax_comunes.ajaxCuantiasRadicado')
                    ->with('cuantias', $cuantias)
                    ->with('responsable', $responsable);
    }

    public function actionNuevaCuantia(Request $request)
    {
        $slv = Util::valorParametro(28);

        return view('ajax_comunes.ajaxNuevaCuantia')
                    ->with('slv', $slv);
    }

    public function actionValidarGuardarCuantia(Request $request)
    {
        $cuantia = new CuantiaRadicado;
        $cuantia->unidadMonetaria                     = $request->input('selectUnidadMonetaria');
        $cuantia->valor                               = $request->input('valor');
        $cuantia->valorPesos                          = str_replace(".","",$request->input('valorPesos'));
        $cuantia->juriradicados_vigenciaRadicado      = $request->input('vigenciaRadicado');
        $cuantia->juriradicados_idRadicado            = $request->input('idRadicado');
        $cuantia->save();

        return;
    }

    public function actionNuevaDependenciaProceso(Request $request)
    {
        $dependencias = DB::table('dependencias')
                            ->orderBy('idDependencia', 'asc')
                            ->pluck('nombreDependencia', 'idDependencia');

        return view('ajax_comunes.ajaxDependenciaProceso')
                    ->with('dependencias', $dependencias)
                    ->with('tipoInvolucrado', $request->input('tipoInvolucrado'));
    }

    public function actionValidarGuardarInvolucradoDepen(Request $request)
    {
        $enProceso = DB::table('juriinvolucrados')
                        ->where('juriradicados_vigenciaRadicado', '=', $request->input("vigenciaRadicado"))
                        ->where('juriradicados_idRadicado', '=', $request->input("idRadicado"))
                        ->where('dependencias_idDependencia', '=', $request->input("selectDepenProceso"))
                        ->count();

        if($enProceso > 0)
        {
            return 0;//dependencia ya se encuentra en el proceso
        }
        else
        {
            $dependenciaInvolucrada = new Involucrado;
            $dependenciaInvolucrada->juritipoinvolucrados_idTipoInvolucrado = $request->input("tipoInvolucrado");// dependencias internas
            $dependenciaInvolucrada->dependencias_idDependencia     = $request->input("selectDepenProceso");
            $dependenciaInvolucrada->juriradicados_vigenciaRadicado = $request->input("vigenciaRadicado");
            $dependenciaInvolucrada->juriradicados_idRadicado       = $request->input("idRadicado");
            $dependenciaInvolucrada->save();

            return $request->input("tipoInvolucrado");//guarda el involucrado al proceso
        }
    }

    public function actionNuevoExterno(Request $request)
    {
        return view('ajax_comunes.ajaxNuevoExterno')
                    ->with('tipoInvolucrado', $request->input('tipoInvolucrado'));
    }

    public function actionValidarGuardarNuevoExt(Request $request)
    {
        $accionadoExt   = new ConvocadoExterno;
        $accionadoExt->nombreConvocadoExterno       = $request->input('nombreNuevoExterno');
        $accionadoExt->direccionConvocadoExterno    = $request->input('direccionNuevoExterno');
        $accionadoExt->telefonoConvocadoExterno     = $request->input('telefonoNuevoExterno');
        $accionadoExt->save();

        $entidadExterna = new Involucrado;
        $entidadExterna->juritipoinvolucrados_idTipoInvolucrado     = $request->input("tipoInvolucrado");// entidad externo
        $entidadExterna->juriconvocadosexternos_idConvocadoExterno  = $accionadoExt->idConvocadoExterno;
        $entidadExterna->juriradicados_vigenciaRadicado             = $request->input("vigenciaRadicado");
        $entidadExterna->juriradicados_idRadicado                   = $request->input("idRadicado");
        $entidadExterna->save();

        return $request->input("tipoInvolucrado");
    }

    public function actionEditarExt(Request $request)
    {
        $externo = DB::table('juriconvocadosexternos')
                        ->where('idConvocadoExterno', '=', $request->input("idExterno"))
                        ->get();

        return view('ajax_comunes.ajaxEditarExterno')
                    ->with('externo', $externo)
                    ->with('tipoInvolucrado', $request->input("tipoInvolucrado"));
    }

    public function actionValidarEditarExt(Request $request)
    {
        DB::table('juriconvocadosexternos')
                ->where('idConvocadoExterno', $request->input('idExterno'))
                ->update([
                    'nombreConvocadoExterno'    => $request->input('nombreNuevoExternoEdit'),
                    'direccionConvocadoExterno' => $request->input('direccionNuevoExternoEdit'),
                    'telefonoConvocadoExterno'  => $request->input('telefonoNuevoExternoEdit')]);

        return;
    }

    public function actionValidarEliminarAccionante(Request $request)
    {
        Involucrado::where('idInvolucrado', '=', $request->input('idInvolucrado'))->delete();

        return;
    }

    public function actionNuevoAbogadoExt(Request $request)
    {
        $listaTipoDocumentos = DB::table('tiposidentificacion')
            ->orderBy('idTipoIdentificacion', 'asc')
            ->pluck('nombreTipoIdentificacion', 'idTipoIdentificacion');

        return view('ajax_comunes.ajaxNuevoAbogadoExt')
                    ->with('listaTipoDocumentos', $listaTipoDocumentos)
                    ->with('tipoInvolucrado', $request->input("tipoInvolucrado"));
    }

    public function actionValidarGuardarAbogadoExt(Request $request)
    {
        $abogado   = new Abogado;
        $abogado->documentoAbogado           = $request->input('documentoAbogado');
        $abogado->nombreAbogado              = $request->input('nombreAbogado');
        $abogado->tarjetaAbogado             = $request->input('tarjetaAbogado');
        $abogado->tiposidentificacion_idTipoIdentificacion   = $request->input('selecTipoDocumentoAbogado');
        $abogado->save();

        $abogadoInvolucrado = new Involucrado;
        $abogadoInvolucrado->juritipoinvolucrados_idTipoInvolucrado  = $request->input('tipoInvolucrado');
        $abogadoInvolucrado->juriabogados_idAbogado  = $abogado->idAbogado;
        $abogadoInvolucrado->juriradicados_vigenciaRadicado  = $request->input('vigenciaRadicado');
        $abogadoInvolucrado->juriradicados_idRadicado  = $request->input('idRadicado');
        $abogadoInvolucrado->save();

        return $abogado->idAbogado;
    }

    public function actionEditarAbogadoExt(Request $request)
    {
        $abogado = DB::table('juriabogados')
                    ->where('idAbogado', '=', $request->input('idAbogadoExt'))
                    ->get();

        $listaTipoDocumentos = DB::table('tiposidentificacion')
            ->orderBy('idTipoIdentificacion', 'asc')
            ->pluck('nombreTipoIdentificacion', 'idTipoIdentificacion');

        return view('ajax_comunes.ajaxEditarAbogadoExt')
                    ->with('listaTipoDocumentos', $listaTipoDocumentos)
                    ->with('abogado', $abogado)
                    ->with('tipoInvolucrado', $request->input('tipoInvolucrado'));
    }

    public function actionValidarEditarAbogadoExt(Request $request)
    {
        $validarDocumentoRepetido = DB::table('juriabogados')
            ->where('documentoAbogado', '=', $request->input('documentoAbogadoDemandanteEditar'))
            ->where('idAbogado', '!=', $request->input('idAbogadoExt'))
            ->get();

        if (count($validarDocumentoRepetido) > 0) 
        {
            return 0;// documento repetido
        }
        else
        {
            DB::table('juriabogados')
                    ->where('idAbogado', $request->input('idAbogadoExt'))
                    ->update([
                            'documentoAbogado' => $request->input('documentoAbogadoDemandanteEditar'),
                            'nombreAbogado' => $request->input('nombreAbogadoEditar'),
                            'tarjetaAbogado' => $request->input('tarjetaAbogadoEditar'),
                            'tiposidentificacion_idTipoIdentificacion' => $request->input('selecTipoDocumentoAbogadoEditar')]);

            return 1; // abogado modificado
        }
    }

    public function actionValidarEliminarAbogadoExt(Request $request)
    {
        Involucrado::where('idInvolucrado', '=', $request->input('idInvolucrado'))->delete();

        return;
    }
    
    public function actionCaratula($vector)
    {
        //Decodifica el vector json
        $datos = json_decode($vector, true);

        $templateWord = new \PhpOffice\PhpWord\TemplateProcessor('juriArch/Caratula.docx');

        $radicado = Util::datosRadicado($datos['vigenciaRadicado'], $datos['idRadicado']);
        $demandante = Util::traerSolicitanteBuzon($datos['vigenciaRadicado'], $datos['idRadicado']);
        $nombreArchivo = $radicado->radicadoJuzgado." - litíGo ".$radicado->vigenciaRadicado."-".$radicado->idRadicado;
        // --- Se asignan valores a la plantilla

        $templateWord->setValue('demandante', strtoupper($demandante));
        $templateWord->setValue('radicadoLitiGo', $radicado->vigenciaRadicado."-".$radicado->idRadicado);
        $templateWord->setValue('radicadoJuzgado', $radicado->radicadoJuzgado);  
        $templateWord->setValue('tema', strtoupper($radicado->nombreMedioControl)); 
        $templateWord->setValue('vigenciaActual', date('Y'));  

        // --- Se guarda el documento
        $templateWord->saveAs("Carátula".' '.$nombreArchivo.'.docx');

        header("Content-Disposition: attachment; filename="."Carátula"." ".$nombreArchivo.".docx; charset=iso-8859-1");
        echo file_get_contents("Carátula".' '.$nombreArchivo. '.docx');
        //Elimina el archivo temporal
        Unlink("Carátula".' '.$nombreArchivo.'.docx');
    }

    public function actionBuscar()
    {
        return view('buscar/index');
    }

    public function actionAgregarApoderado()
    {
        $listaResponsables = DB::table('usuarios')
            ->join('juriresponsables', 'usuarios.idUsuario', 'juriresponsables.usuarios_idUsuario')
            ->where('juriroles_idRol', '=', 3)//actuación
            ->where('estadoResponsable', '=', 1)//activo
            ->pluck('nombresUsuario', 'idResponsable');

        return view('ajax_comunes.ajaxAgregarApoderado')
                    ->with('listaResponsables', $listaResponsables);
    }

    public function actionValidarGuardarApoderadoNuevo(Request $request)
    {
        $idUsuario = Session::get('idUsuario');
        $idResponsableActual = Util::idResponsable($idUsuario);
        $vectorAsignados   = json_decode($request->input('jsonResponsables'), true);

        $estadoActual = EstadoEtapa::find($request->input('idEstadoEtapa'));
        $comentarioReparto = "Se realiza el reparto correspondiente a :";

        $finalizaReparto = DB::table('juriestadosetapas')
                ->where('juritiposestados_idTipoEstado', 2);

            if($estadoActual->juritiposestados_idTipoEstado == 2 && $estadoActual->fechaFinalEstado == NULL){
                $finalizaReparto = $finalizaReparto->update([
                    'fechaFinalEstado' => date("Y-m-d H:i:s"),
                    'comentarioEstadoEtapa' => $comentarioReparto,
                    'juritipoestadosetapas_idTipoEstadoEtapa' => 2]);
            } else{
                $finalizaReparto = $finalizaReparto->update(['juritipoestadosetapas_idTipoEstadoEtapa' => 2]);
            }

                

        for($i=0; $i < count($vectorAsignados); $i++)
        {
            $estadoEtapa = new EstadoEtapa;
            $estadoEtapa->fechaInicioEstado                        = date("Y-m-d H:i:s");
            $estadoEtapa->juritipoestadosetapas_idTipoEstadoEtapa  = 1;// Actual estado
            $estadoEtapa->juriradicados_vigenciaRadicado           = $estadoActual->juriradicados_vigenciaRadicado;
            $estadoEtapa->juriradicados_idRadicado                 = $estadoActual->juriradicados_idRadicado;
            $estadoEtapa->juriresponsables_idResponsable           = $vectorAsignados[$i];//el id de la persona que se le hace reparto
            $estadoEtapa->juritiposestados_idTipoEstado            = 3;
            $estadoEtapa->save();

            Util::guardarObservacion(date("Y-m-d H:i:s"), Null, 1, $estadoActual->juriradicados_vigenciaRadicado, $estadoActual->juriradicados_idRadicado, '', $vectorAsignados[$i], 3, $estadoEtapa->idEstadoEtapa, 4);

            //ENVIAR EMAIL
            $clase = "SQ10\Mail\NotificacionInt";
            $usuario = Usuario::find($idUsuario);

            $proceso = DB::table('juriradicados')
                    ->select('nombreTipoProceso', 'descripcionHechos', 'idTipoProcesos')
                    ->join('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                    ->where('vigenciaRadicado', '=', $estadoActual->juriradicados_vigenciaRadicado)
                    ->where('idRadicado', '=', $estadoActual->juriradicados_idRadicado)
                    ->get();

            $nombreProceso  = "";
            $descHechos     = "";
            $idTipoProceso  = "";
            if(count($proceso) > 0)
            {
                $nombreProceso = $proceso[0]->nombreTipoProceso;
                $descHechos    = $proceso[0]->descripcionHechos;
                $idTipoProceso = $proceso[0]->idTipoProcesos;
            }

            if($idTipoProceso == 1)
            {
                $rutaEmail   = "actuacionProc-judi/index/".$estadoEtapa->idEstadoEtapa;
            }
            else if($idTipoProceso == 2)
            {
                $rutaEmail   = "actuacionConci-prej/index/".$estadoEtapa->idEstadoEtapa;
            }
            else if($idTipoProceso == 3)
            {
                $rutaEmail   = "actuacionTutelas/index/".$estadoEtapa->idEstadoEtapa;
            }

            $emailUsuario = DB::table('juriresponsables')
                ->select('emailUsuario')
                ->join('usuarios', 'juriresponsables.usuarios_idUsuario', '=', 'usuarios.idUsuario')
                ->where('idResponsable', '=', $vectorAsignados[$i])
                ->get();

            $data = array('idRadicado'              => $estadoActual->juriradicados_idRadicado, 
                          'vigenciaRadicado'        => $estadoActual->juriradicados_vigenciaRadicado, 
                          'nombreTipoProceso'       => $nombreProceso,
                          'causasHechos'            => $descHechos,
                          'usuarioActual'           => $usuario->nombresUsuario,
                          'rutaEmail'               => $rutaEmail);

            if(count($emailUsuario) > 0)
            {
                //#ENVIAR EMAIL
                Util::enviarEmail($data, $emailUsuario[0]->emailUsuario, $clase, $estadoActual->juriradicados_vigenciaRadicado, $estadoActual->juriradicados_idRadicado);
                //#ENVIAR EMAIL
            }
            //## ENVIAR EMAIL
        }

        $observacion = "Realiza el reparto";
        Util::guardarLog($observacion, $estadoActual->juriradicados_vigenciaRadicado, $estadoActual->juriradicados_idRadicado, 4);

        return;
    }

    public function actionSearchTema(Request $request)
    {
        $q = "+".preg_replace( '/\s(\w+)/', ' +\\1', $request->input('criterioTema'));

        $temas = Tema::whereRaw("MATCH(nombreTema) AGAINST(? IN BOOLEAN MODE)", array($q))
            ->orderBy(DB::raw('nombreTema'), 'asc')
            ->get();

        return view("ajax_comunes.ajaxBusquedaTema")
            ->with("temas", $temas)
            ->with("criterioTema", $q);
    }

    public function actionActuacionesProceso(Request $request)
    {
        $actuacionesEtapa = DB::table('juriactuaciones')
                            ->leftJoin('juritiposactuaciones', 'juriactuaciones.juritiposactuaciones_idTipoActuacion', '=', 'juritiposactuaciones.idTipoActuacion')
                            ->leftJoin('juriresponsables', 'juriactuaciones.juriresponsables_idResponsable', '=', 'juriresponsables.idResponsable')
                            ->leftJoin('usuarios', 'juriresponsables.usuarios_idUsuario', '=', 'usuarios.idUsuario')
                            ->where('juriradicados_vigenciaRadicado', '=', $request->input('vigenciaRadicado'))
                            ->where('juriradicados_idRadicado', '=', $request->input('idRadicado'))
                            ->orderby('fechaActuacion','desc')
                            ->get();

        return view('ajax_comunes.ajaxActuacionesTabla')
                ->with('actuacionesEtapa', $actuacionesEtapa);
    }

    public function actionValidarEliminarCuantia(Request $request)
    {
        CuantiaRadicado::where('idCuantia', '=', $request->input('idCuantia'))->delete();

        return;
    }

    public function actionModalAsociarProceso(Request $request)
    {
        return view('ajax_comunes.ajaxAsociarProceso')
                ->with('idRadicado',$request->input('idRadicado'))
                ->with('vigenciaRadicado',$request->input('vigenciaRadicado'));

    }

    
    public function actionAsociarProceso(Request $request)
    {
        $demandantes = [];

         if($request->input('tipoProceso') == 0)//asociar por radicado litigo
        {

            $radicadoHijo = Radicado::where('idRadicado',$request->input('criterioBusqueda'))
                                ->where('vigenciaRadicado',$request->input('vigencia'))
                                ->first();
                   
            if(count($radicadoHijo)>0)
            {

                $radicadoPadre = Radicado::where('idRadicado',$request->input('idRadicado'))
                                            ->where('vigenciaRadicado',$request->input('vigenciaRadicado'))
                                            ->first();
                                            
                //contar caracteres
                if(strlen($radicadoPadre->radicadoJuzgado."-".$radicadoHijo->radicadoJuzgado) <= 255 &&
                   strlen($radicadoPadre->codigoProceso."-".$radicadoHijo->codigoProceso) <= 255 )
                {

                    $textoRadicadoPadre = $radicadoHijo->radicadoPadre.",".$request->input('idRadicado')."-".$request->input('vigenciaRadicado');

                    //Radicado hijo**********************************************
                    DB::table('juriradicados')
                        ->where('idRadicado',$request->input('criterioBusqueda'))
                        ->where('vigenciaRadicado',$request->input('vigencia'))
                        ->update(['radicadoPadre' => $textoRadicadoPadre  ]);
                    
                        //Cerrar Radicado
                        $idUsuario = Session::get('idUsuario');
                        $idResponsable  = Util::idResponsable($idUsuario);

                        $estadoEtapa = new EstadoEtapa;
                        $estadoEtapa->fechaInicioEstado                        = date("Y-m-d H:i:s");
                        $estadoEtapa->fechaFinalEstado                         = date("Y-m-d H:i:s");
                        $estadoEtapa->juritipoestadosetapas_idTipoEstadoEtapa  = 2;// Gestionado-Terminado
                        $estadoEtapa->juriradicados_vigenciaRadicado           = $request->input('vigencia');
                        $estadoEtapa->juriradicados_idRadicado                 = $request->input('criterioBusqueda');
                        $estadoEtapa->comentarioEstadoEtapa                    = "Se finaliza el proceso por que se asocia al radicado: ".$request->input('idRadicado')."-".$request->input('vigenciaRadicado');
                        $estadoEtapa->juriresponsables_idResponsable           = $idResponsable;
                        $estadoEtapa->juritiposestados_idTipoEstado            = 1;
                        $estadoEtapa->save();

                        DB::table('juriestadosetapas')
                                    ->where('juriradicados_vigenciaRadicado', $request->input('vigencia'))
                                    ->where('juriradicados_idRadicado', $request->input('criterioBusqueda'))
                                    ->update(['juritipoestadosetapas_idTipoEstadoEtapa'   => 2]);//gestionado
                        
                        DB::table('juriradicados')
                                ->where('vigenciaRadicado', $request->input('vigencia'))
                                ->where('idRadicado', $request->input('criterioBusqueda'))
                                ->update([
                                        'juriestadosradicados_idEstadoRadicado'     => 2]);// terminado  
                        //Cerrar Radicado                  


                    //Radicado Hijo***********************************************    

                    //Radicado Padre
                    DB::table('juriradicados')
                      ->where('idRadicado',$request->input('idRadicado'))
                      ->where('vigenciaRadicado',$request->input('vigenciaRadicado'))
                     ->update(['radicadoHijo'    => $radicadoPadre->radicadoHijo.",".$request->input('criterioBusqueda')."-".$request->input('vigencia'),
                               'radicadoJuzgado' => $radicadoPadre->radicadoJuzgado."-".$radicadoHijo->radicadoJuzgado,
                               'codigoProceso'   =>  $radicadoPadre->codigoProceso."-".$radicadoHijo->codigoProceso ]);
                    $error = 0;  
                    
                      
                    $demandantes = DB::table('juriinvolucrados')
                                        ->select('idSolicitante','nombreSolicitante','documentoSolicitante')
                                        ->join('solicitantes', 'juriinvolucrados.solicitantes_idSolicitante', '=', 'solicitantes.idSolicitante')
                                        ->where('juritipoinvolucrados_idTipoInvolucrado', 7)//accionante
                                        ->where('juriradicados_idRadicado',$request->input('criterioBusqueda'))
                                        ->where('juriradicados_vigenciaRadicado',$request->input('vigencia'))
                                        ->get();
                    
                }
                else //Exede el varchar 255  
                {
                    $error = 2; 
                }    

            }
            else // no encontro ningun radicado
            {
                $error = 1;
            }                    

        }else//asociar por radicado juzgado
        {
            $radicado = Radicado::where('idRadicado',$request->input('idRadicado'))
                                ->where('vigenciaRadicado',$request->input('vigenciaRadicado'))
                                ->first();
                                

            //echo $radicado->codigoProceso." - ".$request->input('criterioBusqueda');return;                 

            if(count($radicado)>0)
            {  
                //contar caracteres
                if(strlen($radicado->codigoProceso."-".$request->input('criterioBusqueda')) <= 255 &&
                   strlen($radicado->codigoProceso."-".$request->input('criterioBusqueda')) <= 255 )
                {

                    DB::table('juriradicados')
                        ->where('idRadicado',$request->input('idRadicado'))
                        ->where('vigenciaRadicado',$request->input('vigenciaRadicado'))
                        ->update([
                            'radicadoJuzgado'   => $radicado->radicadoJuzgado."-".$request->input('criterioBusqueda'),
                            'codigoProceso'     => $radicado->codigoProceso."-".$request->input('criterioBusqueda')
                        ]);

                 

                    $error = 0; 
                }
                else //Exede el varchar 255  
                {
                    $error = 2; 
                }    

                   
            }  
            else // no encontro ningun radicado
            {
                $error = 1;
            }      


        }

        return response()->json(['vista' => view('ajax_comunes.ajaxTrasladarDemandantes')
                                          ->with('demandantes', $demandantes)
                                          ->with('idRadicado', $request->input('idRadicado'))
                                          ->with('vigenciaRadicado', $request->input('vigenciaRadicado'))
                                        ->render(),
                                 'error' => $error]); 

    }

    public function actionTrasladarAccionante(Request $request)
    {
        $dependenciaInvolucrada = new Involucrado;
        $dependenciaInvolucrada->juritipoinvolucrados_idTipoInvolucrado = 7;// Accionante
        $dependenciaInvolucrada->solicitantes_idSolicitante             = $request->input("idSolicitante");
        $dependenciaInvolucrada->juriradicados_vigenciaRadicado         = $request->input("vigenciaRadicado");
        $dependenciaInvolucrada->juriradicados_idRadicado               = $request->input("idRadicado");
        $dependenciaInvolucrada->save();

        return 1;

    }

    /* Juzgados */
    public function actionJuzgados(){

        $juzgados = DB::table('jurijuzgados')
        ->select('jurisdiccionJuzgado', 'distritoJuzgado','circuitoJuzgado','departamentoJuzgado', 'municipioJuzgado');

        $jurisdiccion = $juzgados->groupBy('jurisdiccionJuzgado')->get();
        $distrito = $juzgados->groupBy('distritoJuzgado')->get();
        $circuito = $juzgados->groupBy('circuitoJuzgado')->get();
        $departamentos = $juzgados->groupBy('departamentoJuzgado')->get();
        $ciudad = $juzgados->groupBy('municipioJuzgado')->get();

        return view('juzgados.index')
        ->with('jurisdiccion', $jurisdiccion)
        ->with('distrito', $distrito)
        ->with('circuito', $circuito)
        ->with('departamentos', $departamentos)
        ->with('ciudad', $ciudad);
    }

    public function actionTablaJuzgados(Request $request){
        $juzgados = DB::table('jurijuzgados');
            
            if($request->input('filtro_jurisdiccion') != "all"){
                $juzgados = $juzgados->where('jurisdiccionJuzgado', '=', $request->input('filtro_jurisdiccion'));
            }

            if($request->input('filtro_distrito') != "all"){
                $juzgados = $juzgados->where('distritoJuzgado', '=', $request->input('filtro_distrito'));
            } 

            if($request->input('filtro_circuito') != "all"){
                $juzgados = $juzgados->where('circuitoJuzgado', '=', $request->input('filtro_circuito'));
            } 

            if($request->input('filtro_departamento') != "all"){
                $juzgados = $juzgados->where('departamentoJuzgado', '=', $request->input('filtro_departamento'));
            } 

            if($request->input('filtro_municipio') != "all"){
                $juzgados = $juzgados->where('municipioJuzgado', '=', $request->input('filtro_municipio'));
            } 

            if($request->input('filtro_estado') != "all"){
                $juzgados = $juzgados->where('activoJuzgado', '=', $request->input('filtro_estado'));
            } 
            if($request->input('filtro_codigo') != ""){
                $juzgados = $juzgados->where('codigoUnicoJuzgado', 'LIKE', '%'.$request->input('filtro_codigo').'%');
            } 
            if($request->input('filtro_nombre') != ""){
                $juzgados = $juzgados->where('nombreJuzgado', 'LIKE', '%'.$request->input('filtro_nombre').'%');
            } 
                
        
                $juzgados = $juzgados->skip($request->input('inicio'))						
                ->take($request->input('limite'))
                ->orderBy('idJuzgado', 'desc')
                ->get();

        return view('juzgados.tabla')
                    ->with('juzgados', $juzgados); 
    }

    public function actionCreateJuzgados(){
        $departamentos = DB::table('departamentos')
        //->pluck('nombreDepartamento', 'idDepartamento');
        ->get();
        return view('juzgados.create')
        ->with('departamentos', $departamentos);

    }

    public function actionUpdateJuzgados(Request $request){
        $juzgado = DB::table('jurijuzgados')
        ->where('idJuzgado', '=', $request->input('idJuzgado'))
        ->first();

        $departamentos = DB::table('departamentos')
        ->get();

        return view('juzgados.update')
        ->with('juzgado', $juzgado)
        ->with('departamentos', $departamentos);
    }

    public function actionExecuteUpdateJuzgados(Request $request){
        
        DB::table('jurijuzgados')
        ->where('idJuzgado', $request->input('idJuzgado'))
        ->update([
            'activoJuzgado'=> $request->input('estadoJuzgado')]);
     
        return $request->input('estadoResponsable');
        
    }

    public function actionCiudad(Request $request){
        return view('juzgados.ciudad')
            ->with('departamento', $request->input('departamento'))
            ->with('valor', $request->input('valor'))
            ->with('input', $request->input('input'));  
    }

    public function actionValidarGuardarJuzgado(Request $request)
    {
        $codigoExiste = DB::table('jurijuzgados')
        ->where('codigoUnicoJuzgado', '=', $request->input('codigo'))
        ->first();

        if(count($codigoExiste) == 1){
            return 0;
        }


        $juzgado  = new Juzgado;
        $juzgado->jurisdiccionJuzgado                  = $request->input('jurisdiccionJuzgado');
        $juzgado->distritoJuzgado                     = $request->input('distrito');
        $juzgado->circuitoJuzgado               = $request->input('circuito');
        $juzgado->municipioJuzgado                      = $request->input('municipio');
        $juzgado->codigoUnicoJuzgado  = $request->input('codigo');
        $juzgado->nombreJuzgado  = $request->input('nombreJuzgado');
        $juzgado->correoJuzgado  = $request->input('correo');
        $juzgado->direccionJuzgado  = $request->input('direccion');
        $juzgado->telefonoJuzgado  = $request->input('telefono');
        $juzgado->horarioJuzgado  = $request->input('horario');
        $juzgado->areaJuzgado  = $request->input('area');
        $juzgado->departamentoJuzgado	  = $request->input('departamento');
        $juzgado->save();

        return 1;// guarda responsable
    }

    public function actionValidarEditarJuzgado(Request $request){
        $update =    DB::table('jurijuzgados')
                ->where('idJuzgado', $request->input('idJuzgado'))
                ->update([
                    'jurisdiccionJuzgado' => $request->input('jurisdiccionJuzgado'),
                    'distritoJuzgado' => $request->input('distrito'),
                    'circuitoJuzgado' => $request->input('circuito'),
                    'municipioJuzgado' => $request->input('municipio'),
                    'codigoUnicoJuzgado' => $request->input('codigo'),
                    'nombreJuzgado' => $request->input('nombreJuzgado'),
                    'correoJuzgado' => $request->input('correo'),
                    'direccionJuzgado' => $request->input('direccion'),
                    'telefonoJuzgado' => $request->input('telefono'),
                    'horarioJuzgado' => $request->input('horario'),
                    'areaJuzgado' => $request->input('area'),
                    'departamentoJuzgado' => $request->input('departamento'),
                    'activoJuzgado' => $request->input('estado')]);

        if($update){
            return 1;
        }
    }





    public function actionBuscadorProcesos(Request $request)
    {
        /*
            selectMetodoBusqueda es 1 radicado interno
            selectMetodoBusqueda es 2 documento demandante
            selectMetodoBusqueda es 3 nombre demandante
            selectMetodoBusqueda es 4 tema
            selectMetodoBusqueda es 5 radicado juzgado
            selectMetodoBusqueda es 6 radicado anterior
        */

        $arrayProcesos = array();

        $radicadoJuzgado = str_replace("-","",$request->input('criterioBusquedaJuz'));
        $q = "+".preg_replace( '/\s(\w+)/', ' +\\1', $request->input('criterioBusqueda'));

        $proceso = DB::table('juriradicados')
                      ->join('juriestadosradicados', 'juriradicados.juriestadosradicados_idEstadoRadicado', '=', 'juriestadosradicados.idEstadoRadicado')
                      ->join('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                  ->leftJoin('jurimedioscontrol', 'juriradicados.jurimedioscontrol_idMediosControl', '=', 'jurimedioscontrol.idMediosControl')
                  ->leftJoin('juriautoridadconoce', 'juriradicados.juriautoridadconoce_idAutoridadConoce', '=', 'juriautoridadconoce.idAutoridadConoce')
                  ->leftJoin('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
                  ->leftJoin('jurijuzgados', 'juriradicados.jurijuzgados_idJuzgado', '=', 'jurijuzgados.idJuzgado')
                  ->leftJoin('juriinvolucrados', function ($leftJoin) {
               $leftJoin->on('juriradicados.vigenciaRadicado', '=', 'juriinvolucrados.juriradicados_vigenciaRadicado')
                        ->on('juriradicados.idRadicado', '=', 'juriinvolucrados.juriradicados_idRadicado');
                    })
                  ->leftJoin('solicitantes', 'juriinvolucrados.solicitantes_idSolicitante', '=', 'solicitantes.idSolicitante');


        if($request->input('selectMetodoBusqueda') == 1)
        {
            $proceso->where('vigenciaRadicado', '=', $request->input('vigenciaProcesoBuscar'));
            $proceso->where('idRadicado', '=', $request->input('criterioBusqueda'));
        }

        if($request->input('selectMetodoBusqueda') == 2)
        {
            $proceso->where('documentoSolicitante', '=', $request->input('criterioBusqueda'));
        }
        if($request->input('selectMetodoBusqueda') == 3)
        {
            $proceso->where('nombreSolicitante', 'LIKE', '%'.$request->input('criterioBusqueda').'%');
        }
        if($request->input('selectMetodoBusqueda') == 4)
        {   
            $proceso->whereRaw('MATCH(nombreTema) AGAINST(? IN BOOLEAN MODE)', array($q));
            ///$proceso->where('nombreTema', 'LIKE', '%'.$request->input('criterioBusqueda').'%');
        }
        if($request->input('selectMetodoBusqueda') == 5)
        {
            //$proceso->whereRaw('MATCH(radicadoJuzgado) AGAINST(? IN BOOLEAN MODE)', array($q));
            $proceso->where("radicadoJuzgado", 'LIKE', '%'.$radicadoJuzgado.'%');
        }

        if($request->input('selectMetodoBusqueda') == 6)
        {
            $proceso->where('mzlConsecutivo', '=', $request->input('criterioBusqueda'));
        }
        if($request->input('selectMetodoBusqueda') == 7)
        {
            $proceso->whereRaw('MATCH(juriradicados.asunto) AGAINST(? IN BOOLEAN MODE)', array($q));
        }

        $proceso->groupBy('juriradicados.vigenciaRadicado');
        $proceso->groupBy('juriradicados.idRadicado');
        $pro = $proceso->get();

        $estadosEtapas = DB::table('juriestadosetapas')
                          ->select('idEstadoEtapa', 'fechaInicioEstado', 'comentarioEstadoEtapa', 'nombreTipoEstado', 'documentoUsuario', 'nombresUsuario', 'juriresponsables_idResponsable')
                        ->leftJoin('juriresponsables', 'juriestadosetapas.juriresponsables_idResponsable', '=', 'juriresponsables.idResponsable')
                        ->leftJoin('juritiposestados', 'juriestadosetapas.juritiposestados_idTipoEstado', '=', 'juritiposestados.idTipoEstado')
                        ->leftJoin('usuarios', 'juriresponsables.usuarios_idUsuario', '=', 'usuarios.idUsuario');

        if($request->input('selectMetodoBusqueda') == 1)
        {
            $estadosEtapas->where('juriradicados_vigenciaRadicado', '=',  $request->input('vigenciaProcesoBuscar'));
            $estadosEtapas->where('juriradicados_idRadicado', '=', $request->input('criterioBusqueda'));
            $estados = $estadosEtapas->get(); 
        }
        if($request->input('selectMetodoBusqueda') == 6)
        {
            $estadosEtapas->where('juriradicados_vigenciaRadicado', '=',  $pro[0]->vigenciaRadicado);
            $estadosEtapas->where('juriradicados_idRadicado', '=', $pro[0]->idRadicado);
            $estados = $estadosEtapas->get(); 
        }


        if(count($pro) > 0)
        {
            foreach ($pro as $proces) 
            {
                $idEstadoEtapa = DB::table('juriestadosetapas')
                    ->select('idEstadoEtapa', 'nombresUsuario')
                    ->join('juriresponsables', 'juriestadosetapas.juriresponsables_idResponsable', '=', 'juriresponsables.idResponsable')
                    ->join('usuarios', 'juriresponsables.usuarios_idUsuario', '=', 'usuarios.idUsuario')
                    ->where('juriradicados_vigenciaRadicado', '=',  $proces->vigenciaRadicado)
                    ->where('juriradicados_idRadicado', '=', $proces->idRadicado)
                    ->orderby('idEstadoEtapa','desc')
                    ->take(1)// último registro en estado etapa
                    ->get();

                if(count($idEstadoEtapa) > 0)
                {
                    if($proces->juritipoprocesos_idTipoProceso == 1)
                    {
                        $rutaProceso = 'actuacionProc-judi/index/'.$idEstadoEtapa[0]->idEstadoEtapa;
                    }
                    else if($proces->juritipoprocesos_idTipoProceso == 2)
                    {
                        $rutaProceso = 'actuacionConci-prej/index/'.$idEstadoEtapa[0]->idEstadoEtapa;
                    }
                    else if($proces->juritipoprocesos_idTipoProceso == 3)
                    {
                        $rutaProceso = 'actuacionTutelas/index/'.$idEstadoEtapa[0]->idEstadoEtapa;
                    }

                    $datos = array('vigenciaRadicado'       => $proces->vigenciaRadicado,
                                    'idRadicado'             => $proces->idRadicado,
                                    'responsableTitular'     => $proces->juriresponsables_idResponsable_titular,
                                    'fechaRadicado'          => $proces->fechaRadicado,
                                    'nombreJuzgado'          => $proces->nombreJuzgado,
                                    'nombreEstadoRadicado'   => $proces->nombreEstadoRadicado,
                                    'fechaNotificacion'      => $proces->fechaNotificacion,
                                    'nombreMedioControl'     => $proces->nombreMedioControl,
                                    'nombreTipoProceso'      => $proces->nombreTipoProceso,
                                    'nombreTema'             => $proces->nombreTema,
                                    'radicadoJuzgado'        => $proces->radicadoJuzgado,
                                    'idTipoProcesos'         => $proces->juritipoprocesos_idTipoProceso,
                                    'idEstadoEtapa'          => $idEstadoEtapa[0]->idEstadoEtapa,
                                    'asunto'                 => $proces->asunto,
                                    'nombresUsuario'         => $idEstadoEtapa[0]->nombresUsuario,
                                    'ruta'                   => $rutaProceso);

                    array_push($arrayProcesos, $datos);
                    
                }
            }
        }
        
        if(count($pro) > 0)
        {
            if($request->input('selectMetodoBusqueda') == 1 || $request->input('selectMetodoBusqueda') == 6)
            { 
                return view('ajax_comunes.ajaxBuscarProceso')
                     ->with('proceso', $pro)
                     ->with('estadosEtapas', $estados);
            }
            else
            {
                return view('ajax_comunes.ajaxTablaBuscarProceso')
                     ->with('proceso', $arrayProcesos);  
            } 
        }
        else
        {
            return 0; //no encuentra proceso
        }
    }
}