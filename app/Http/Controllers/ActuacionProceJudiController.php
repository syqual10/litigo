<?php
namespace SQ10\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Session;
use SQ10\Models\PasoProceso;
use SQ10\Models\Responsable;
use SQ10\Models\Paso;
use SQ10\Models\Solicitante;
use SQ10\Models\Involucrado;
use SQ10\Models\EstadoEtapa;
use SQ10\helpers\Util as Util;

class ActuacionProceJudiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function actionIndexActuacionProceJudi($idEstadoEtapa)
    {
        $idUsuario     = Session::get('idUsuario');
        $idResponsable = Util::idResponsable($idUsuario);
        $permisoResponsable  = Responsable::find($idResponsable);
        $procesoEstados = EstadoEtapa::find($idEstadoEtapa);

        $estadoResp = DB::table('juriestadosetapas')
                ->select('idEstadoEtapa')
                ->where('juriradicados_vigenciaRadicado', '=', $procesoEstados->juriradicados_vigenciaRadicado)
                ->where('juriradicados_idRadicado', '=', $procesoEstados->juriradicados_idRadicado)
                ->where('juriresponsables_idResponsable', '=', $idResponsable)
                ->where('juritipoestadosetapas_idTipoEstadoEtapa', '=', 1)
                ->where('juritiposestados_idTipoEstado', '=', 3)
                ->get();

        if(count($estadoResp) > 0)
        {
            $idEstadoEtapa = $estadoResp[0]->idEstadoEtapa;
        }

        $proceso = DB::table('juriradicados')
                      ->join('juriestadosetapas', function ($join) {
                          $join->on('juriradicados.vigenciaRadicado', '=', 'juriestadosetapas.juriradicados_vigenciaRadicado')
                          ->on('juriradicados.idRadicado', '=', 'juriestadosetapas.juriradicados_idRadicado');
                      })
                      ->join('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                      ->join('juriresponsables', 'juriestadosetapas.juriresponsables_idResponsable', '=', 'juriresponsables.idResponsable')
                      ->join('juriestadosradicados', 'juriradicados.juriestadosradicados_idEstadoRadicado', '=', 'juriestadosradicados.idEstadoRadicado')
                      ->leftJoin('usuarios', 'juriresponsables.usuarios_idUsuario', '=', 'usuarios.idUsuario')
                      ->leftJoin('jurijuzgados', 'juriradicados.jurijuzgados_idJuzgado', '=', 'jurijuzgados.idJuzgado')
                      ->leftJoin('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
                      ->leftJoin('jurimedioscontrol', 'juriradicados.jurimedioscontrol_idMediosControl', '=', 'jurimedioscontrol.idMediosControl')
                      ->leftJoin('juriacciones', 'juriradicados.juriacciones_idAccion', '=', 'juriacciones.idAccion')
                      ->where('idEstadoEtapa', '=', $idEstadoEtapa)
                      ->get();

         //Consulta los módulos que tiene activos el tipo de proceso
        $modsAct = DB::table('jurimodulostipoproceso')
                    ->select('jurimodulos_idModulo')
                    ->where('juritipoprocesos_idTipoProcesos', $proceso[0]->juritipoprocesos_idTipoProceso)
                    ->get();

        $modulosActivos = array();
        foreach($modsAct as $modulo)
        {
            $modulosActivos[] = $modulo->jurimodulos_idModulo;
        }
        //---------------------------------------------------------

        $agendas  = Util::agendasRadicado($proceso[0]->vigenciaRadicado, $proceso[0]->idRadicado);

        $responsableRadicado = Util::responsableRadicado($proceso[0]->vigenciaRadicado, $proceso[0]->idRadicado, $idResponsable);

        if($responsableRadicado == 1 || $permisoResponsable->permiso == 1 || $permisoResponsable->juriperfiles_idPerfil == 7)
        {
            $responsable = 1;
        }
        else
        {
            $responsable = 0;
        }

        $archivoCausa = DB::table('juriarchivos')
                    ->where('juriradicados_vigenciaRadicado', '=', $proceso[0]->vigenciaRadicado)
                    ->where('juriradicados_idRadicado',  '=', $proceso[0]->idRadicado)
                    ->first();

        $instancias = DB::table('juriinstancias')
                    ->where('juritipoprocesos_idTipoProcesos', '=', $proceso[0]->juritipoprocesos_idTipoProceso)
                    ->get();

        //diferente a reparto y sin buzón especial
        if($proceso[0]->juritiposestados_idTipoEstado != 2 && $permisoResponsable->buzonEspecial == 0)
        {
            DB::table('juriestadosetapas')
                    ->where('idEstadoEtapa', $idEstadoEtapa)
                    ->update([
                            'leidoEstado'      => 1,
                            'fechaLeidoEstado' => date("Y-m-d H:i:s")]);
        }

        return view('actuacionProcesoJudi/index')
                ->with('proceso', $proceso)
                ->with('idEstadoEtapa', $idEstadoEtapa)
                ->with('idResponsable', $idResponsable)
                ->with('archivoCausa', $archivoCausa)
                ->with('instancias', $instancias)
                ->with('responsable', $responsable)
                ->with('agendas', $agendas)
                ->with('datosResponsable', $permisoResponsable)
                ->with('modulosActivos', $modulosActivos);
    }

    public function actionPasosAbogado(Request $request)
    {
        $idUsuario           = Session::get('idUsuario');
        $idResponsable       = Util::idResponsable($idUsuario);
        $responsableRadicado = Util::responsableRadicado($request->input('vigenciaRadicado'), $request->input('idRadicado'), $idResponsable);

        if($idResponsable == $responsableRadicado)
        {
            $responsable = 1;
        }
        else
        {
            $responsable = 0;
        }

        $arrayPasosCompletados = array();

        $pasos = DB::table('juripasos')
                ->where('pasoActivo', '=', 1)// pasos activos
                ->where('juritipoprocesos_idTipoProcesos', '=', $request->input('idTipoProceso'))
                ->where('juripasos_idPaso', '=', Null)
                ->orderBy('ordenPaso', 'asc')
                ->get();

        if(count($pasos) > 0)
        {
            foreach ($pasos as $paso)
            {
                $pasosHijos = DB::table('juripasos')
                                ->where('juripasos_idPaso', '=', $paso->idPaso)
                                ->get();

                if(count($pasosHijos) > 0)
                {
                    foreach ($pasosHijos as $pasoHijo)
                    {
                        $pasosPendientes = DB::table('juripasosproceso')
                                        ->where('juripasos_idPaso', '=', $pasoHijo->idPaso)
                                        ->where('juriradicados_vigenciaRadicado', '=', $request->input('vigenciaRadicado'))
                                        ->where('juriradicados_idRadicado', '=', $request->input('idRadicado'))
                                        ->get();

                        if(count($pasosPendientes) > 0)//están en la tabla de pasos del radicado, se agrega a los completados
                        {
                            $datos = array('idPaso'           => $pasoHijo->idPaso,
                                           'textoPaso'        => $pasoHijo->textoPaso,
                                           'comentarioPaso'   => $pasosPendientes[0]->comentarioPaso,
                                           'fechaPasoProceso' => $pasosPendientes[0]->fechaPasoProceso);

                            array_push($arrayPasosCompletados, $datos);
                        }
                    }
                }
            }
        }

        return view('ajax_actuacionProceJudi.ajaxPasosAbogado')
                    ->with('arrayPasosCompletados', $arrayPasosCompletados)
                    ->with('vigenciaRadicado', $request->input('vigenciaRadicado'))
                    ->with('idRadicado', $request->input('idRadicado'))
                    ->with('pasos', $pasos)
                    ->with('responsable', $responsable);
    }

    public function actionModalMarcarPaso(Request $request)
    {
        $paso = Paso::find($request->input('idPaso'));

        return view('ajax_actuacionProceJudi.ajaxModalMarcarPaso')
                    ->with('paso', $paso)
                    ->with('accion', $request->input('accion'));
    }

    public function actionMarcarPaso(Request $request)
    {
        if($request->input('accion') == 1)
        {
            $idUsuario = Session::get('idUsuario');
            $idResponsable = Util::idResponsable($idUsuario);
            $fechaPaso =  $request->input('fechaPaso');

            $pasoProceso  = new PasoProceso;
            $pasoProceso->comentarioPaso = $request->input('comentarioPaso');
            $pasoProceso->juriresponsables_idResponsable = $idResponsable;
            $pasoProceso->juriradicados_vigenciaRadicado = $request->input('vigenciaRadicado');
            $pasoProceso->juriradicados_idRadicado       = $request->input('idRadicado');
            $pasoProceso->juripasos_idPaso               = $request->input('idPaso');
            $pasoProceso->fechaPasoProceso               = $fechaPaso;
            $pasoProceso->save();
        }
        else
        {
            DB::table('juripasosproceso')
                ->where('juriradicados_vigenciaRadicado', '=', $request->input('vigenciaRadicado'))
                ->where('juriradicados_idRadicado', '=', $request->input('idRadicado'))
                ->where('juripasos_idPaso', '=', $request->input('idPaso'))
                ->delete();
        }

        return;
    }

    public function actionNuevoDemandante(Request $request)
    {
        $listaTipoDocumentos = DB::table('tiposidentificacion')
            ->orderBy('idTipoIdentificacion', 'asc')
            ->pluck('nombreTipoIdentificacion', 'idTipoIdentificacion');

        $listaDepartamentos = DB::table('departamentos')
                            ->get();

        return view('ajax_procesoJudicial.ajaxNuevoDemandante')
                    ->with('listaDepartamentos', $listaDepartamentos)
                    ->with('listaTipoDocumentos', $listaTipoDocumentos);
    }

    public function actionValidarGuardarDemandante(Request $request)
    {
        $validarCorreoNoRepetido = [];
        if($request->input('correoDemandante') !='')
        {
            $validarCorreoNoRepetido = DB::table('solicitantes')
                ->where('correoSolicitante', '=', $request->input('correoDemandante'))
                ->get();
        }

        $validarDocumentoRepetido = DB::table('solicitantes')
            ->where('documentoSolicitante', '!=',  '')
            ->where('documentoSolicitante', '=', $request->input('documentoDemandanteNuevo'))
            ->get();

        if (count($validarCorreoNoRepetido) > 0) 
        {
            return 1;// correo repetido
        } 
        else if (count($validarDocumentoRepetido) > 0) 
        {
            return 2;// documento repetido
        }
        else
        {
            $solicitante   = new Solicitante;
            $solicitante->documentoSolicitante   = $request->input('documentoDemandanteNuevo');
            $solicitante->nombreSolicitante    = $request->input('nombreDemandante');
            $solicitante->correoSolicitante     = $request->input('correoDemandante');
            $solicitante->telefonoSolicitante   = $request->input('telefonoDemandante');
            $solicitante->direccionSolicitante    = $request->input('direccionDemandante');
            $solicitante->password    = Hash::make($request->input('documentoDemandanteNuevo'));
            $solicitante->creadoVentanilla   = 1; //0 Creado en ventanilla
            $solicitante->tiposidentificacion_idTipoIdentificacion = $request->input('selecTipoDocumento');
            $solicitante->subterritorios_idSubTerritorio  = $request->input('selectBarrioDemandante');
            $solicitante->ciudades_idCiudad      = $request->input('selectCiudadDemandante');
            $solicitante->celularSolicitante    = $request->input('celularDemandante');
            $solicitante->save();

            $demandanteInvolucrado = new Involucrado;
            $demandanteInvolucrado->juritipoinvolucrados_idTipoInvolucrado      = 1;// Demandante
            $demandanteInvolucrado->solicitantes_idSolicitante  = $solicitante->idSolicitante;
            $demandanteInvolucrado->juriradicados_vigenciaRadicado  =$request->input('vigenciaRadicado');
            $demandanteInvolucrado->juriradicados_idRadicado  = $request->input('idRadicado');
            $demandanteInvolucrado->save();

            return ;
        }
    }

    public function actionDemandantes(Request $request)
    {
        $demandantes = DB::table('juriinvolucrados')
                    ->join('solicitantes', 'juriinvolucrados.solicitantes_idSolicitante', '=', 'solicitantes.idSolicitante')
                    ->leftJoin('tiposidentificacion', 'solicitantes.tiposidentificacion_idTipoIdentificacion', '=', 'tiposidentificacion.idTipoIdentificacion')
                    ->where('juritipoinvolucrados_idTipoInvolucrado', '=', 1)//demandante
                    ->where('juriradicados_vigenciaRadicado', '=', $request->input('vigenciaRadicado'))
                    ->where('juriradicados_idRadicado', '=', $request->input('idRadicado'))
                    ->get();

        return view('ajax_actuacionProceJudi.ajaxDemandantes')
                    ->with('demandantes', $demandantes)
                    ->with('responsable', $request->input('responsable')); 
    }

    public function actionInvolucradoProceso(Request $request)
    {
        if($request->input('tipoInvolucrado') == 1)//Demandante
        {
            $involucrado = DB::table('solicitantes')
                            ->where('documentoSolicitante', '=', $request->input('documentoDemandanteNuevo'))
                            ->get();
        }
        else if($request->input('tipoInvolucrado') == 6)//entidad externa
        {
            $involucrado = DB::table('juriconvocadosexternos')
                            ->where('nombreConvocadoExterno', '=', $request->input('nombreNuevoExterno'))
                            ->get();
        }
        else if($request->input('tipoInvolucrado') == 2)//abogado externo
        {
            $involucrado = DB::table('juriabogados')
                            ->where('documentoAbogado', '=', $request->input('documentoAbogadoExt'))
                            ->get();
        }
        
        if(count($involucrado) > 0)
        {
            if($request->input('tipoInvolucrado') == 1)//Demandante
            {
                $enProceso = DB::table('juriinvolucrados')
                        ->where('juriradicados_vigenciaRadicado', '=', $request->input("vigenciaRadicado"))
                        ->where('juriradicados_idRadicado', '=', $request->input("idRadicado"))
                        ->where('solicitantes_idSolicitante', '=', $involucrado[0]->idSolicitante)
                        ->count();
            }
            else if($request->input('tipoInvolucrado') == 6)//entidad externa
            {
                $enProceso = DB::table('juriinvolucrados')
                            ->where('juriradicados_vigenciaRadicado', '=', $request->input("vigenciaRadicado"))
                            ->where('juriradicados_idRadicado', '=', $request->input("idRadicado"))
                            ->where('juriconvocadosexternos_idConvocadoExterno', '=', $involucrado[0]->idConvocadoExterno)
                            ->count();
            }
            else if($request->input('tipoInvolucrado') == 2)//abogado externo
            {
                $enProceso = DB::table('juriinvolucrados')
                            ->where('juriradicados_vigenciaRadicado', '=', $request->input("vigenciaRadicado"))
                            ->where('juriradicados_idRadicado', '=', $request->input("idRadicado"))
                            ->where('juriabogados_idAbogado', '=', $involucrado[0]->idAbogado)
                            ->count();
            }

            if($enProceso > 0)
            {
                return 2;//persona ya se encuentra en el proceso
            }
            else
            {
                if($request->input('tipoInvolucrado') == 1)//Demandante
                {
                    $convocanteInvolucrado = new Involucrado;
                    $convocanteInvolucrado->juritipoinvolucrados_idTipoInvolucrado = 1;// Demandante
                    $convocanteInvolucrado->solicitantes_idSolicitante             = $involucrado[0]->idSolicitante;
                    $convocanteInvolucrado->juriradicados_vigenciaRadicado         = $request->input("vigenciaRadicado");
                    $convocanteInvolucrado->juriradicados_idRadicado               = $request->input("idRadicado");
                    $convocanteInvolucrado->save(); 
                }
                else if($request->input('tipoInvolucrado') == 6)//entidad externa
                {
                    $entidadExterna = new Involucrado;
                    $entidadExterna->juritipoinvolucrados_idTipoInvolucrado     = 6;// entidad externo
                    $entidadExterna->juriconvocadosexternos_idConvocadoExterno  = $involucrado[0]->idConvocadoExterno;
                    $entidadExterna->juriradicados_vigenciaRadicado             = $request->input("vigenciaRadicado");
                    $entidadExterna->juriradicados_idRadicado                   = $request->input("idRadicado");
                    $entidadExterna->save();
                }
                else if($request->input('tipoInvolucrado') == 2)//abogado externo
                {
                    $abogadoInvolucrado = new Involucrado;
                    $abogadoInvolucrado->juritipoinvolucrados_idTipoInvolucrado  = 2;//abogado externo
                    $abogadoInvolucrado->juriabogados_idAbogado  = $involucrado[0]->idAbogado;
                    $abogadoInvolucrado->juriradicados_vigenciaRadicado  = $request->input('vigenciaRadicado');
                    $abogadoInvolucrado->juriradicados_idRadicado  = $request->input('idRadicado');
                    $abogadoInvolucrado->save();
                }

                return 1;//guarda el involucrado al proceso
            }
        }

        return 0;//deja crear invlucrado
    }

    public function actionValidarEliminarDemandante(Request $request)
    {
        $canInvlucrados  = Util::cantidadInvolucrado(1, $request->input('vigenciaRadicado'), $request->input('idRadicado'));
        
        if($canInvlucrados == 1)//solo queda un demandante
        {
            return 0;
        }
        else
        {
            Involucrado::where('idInvolucrado', '=', $request->input('idInvolucrado'))->delete();
            return 1;
        }
    }

    public function actionDemandados(Request $request)
    {
        $demandados = DB::table('juriinvolucrados')
                    ->join('dependencias', 'juriinvolucrados.dependencias_idDependencia', '=', 'dependencias.idDependencia')
                    ->where('juritipoinvolucrados_idTipoInvolucrado', '=', 3)//dependencia demandada
                    ->where('juriradicados_vigenciaRadicado', '=', $request->input('vigenciaRadicado'))
                    ->where('juriradicados_idRadicado', '=', $request->input('idRadicado'))
                    ->get();

        return view('ajax_actuacionProceJudi.ajaxDemandados')
                        ->with('demandados', $demandados)
                        ->with('responsable', $request->input('responsable'));
    }

    public function actionValidarRemoverDemandado(Request $request)
    {
        $canInvlucrados  = Util::cantidadInvolucrado(3, $request->input('vigenciaRadicado'), $request->input('idRadicado'));
        
        if($canInvlucrados == 1)//solo queda un demandado interno
        {
            return 0;
        }
        else
        {
            Involucrado::where('idInvolucrado', '=', $request->input('idInvolucrado'))->delete();
            return 1;
        }
    }

    public function actionAccionadosExternos(Request $request)
    {
        $accionadosExt = DB::table('juriinvolucrados')
                    ->join('juriconvocadosexternos', 'juriinvolucrados.juriconvocadosexternos_idConvocadoExterno', '=', 'juriconvocadosexternos.idConvocadoExterno')
                    ->where('juritipoinvolucrados_idTipoInvolucrado', '=', $request->input('tipoInvolucrado'))//accionado externo
                    ->where('juriradicados_vigenciaRadicado', '=', $request->input('vigenciaRadicado'))
                    ->where('juriradicados_idRadicado', '=', $request->input('idRadicado'))
                    ->get();

        return view('ajax_actuacionProceJudi.ajaxAccionadosExternos')
                        ->with('accionadosExt', $accionadosExt)
                        ->with('responsable', $request->input('responsable'))
                        ->with('tipoInvolucrado', $request->input('tipoInvolucrado'));
    }

    public function actionAbogadosExternos(Request $request)
    {
        $abogados = DB::table('juriinvolucrados')
                    ->join('juriabogados', 'juriinvolucrados.juriabogados_idAbogado', '=', 'juriabogados.idAbogado')
                    ->leftJoin('tiposidentificacion', 'juriabogados.tiposidentificacion_idTipoIdentificacion', '=', 'tiposidentificacion.idTipoIdentificacion')
                    ->where('juritipoinvolucrados_idTipoInvolucrado', '=', 2)//abogado demandante
                    ->where('juriradicados_vigenciaRadicado', '=', $request->input('vigenciaRadicado'))
                    ->where('juriradicados_idRadicado', '=', $request->input('idRadicado'))
                    ->get();

        return view('ajax_actuacionConciPreju.ajaxAbogadosExternos')
                        ->with('abogados', $abogados)
                        ->with('responsable', $request->input('responsable'))
                        ->with('tipoInvolucrado', $request->input('tipoInvolucrado'));
    }

    public function actionModificarDatosGenerales(Request $request)
    {
        $proceso = DB::table('juriradicados')
                    ->where('vigenciaRadicado', '=', $request->input('vigenciaRadicado'))
                    ->where('idRadicado', '=', $request->input('idRadicado'))
                    ->get();

        $procaduriaConocedora = DB::table('juriautoridadconoce')
                    ->orderBy('idAutoridadConoce', 'asc')
                    ->pluck('nombreAutoridadConoce', 'idAutoridadConoce');

        $temas = DB::table('juritemas')
                    ->orderBy('idTema', 'asc')
                    ->pluck('nombreTema', 'idTema');

        $juzgados = DB::table('jurijuzgados')
                    ->orderBy('idJuzgado', 'asc')
                    ->pluck('nombreJuzgado', 'idJuzgado');

        $mediosControl = DB::table('jurimedioscontrol')
                    ->orderBy('idMediosControl', 'asc')
                    ->pluck('nombreMedioControl', 'idMediosControl');

        return view('ajax_actuacionProceJudi.ajaxModificarDatos')
                ->with('proceso', $proceso)
                ->with('procaduriaConocedora', $procaduriaConocedora)
                ->with('temas', $temas)
                ->with('mediosControl', $mediosControl)
                ->with('juzgados', $juzgados); 
    }

    public function actionValidarEditarDatosGenerales(Request $request)
    {
        $juzgado = DB::table('jurijuzgados')
                    ->where('idJuzgado', '=', $request->input('selectJuzgado'))
                    ->get();

        $codigoProceso = $juzgado[0]->codigoUnicoJuzgado.$request->input('radicadoJuzgado');

        DB::table('juriradicados')
                    ->where('vigenciaRadicado', $request->input('vigenciaRadicado'))
                    ->where('idRadicado',       $request->input('idRadicado'))
                    ->update([
                            'jurijuzgados_idJuzgado'    => $request->input('selectJuzgado'),
                            'codigoProceso'             => $codigoProceso,
                            'radicadoJuzgado'           => $request->input('radicadoJuzgado'),
                            'jurimedioscontrol_idMediosControl' => $request->input('selectMedioControl'),
                            'juritemas_idTema'          => $request->input('selectTema')]);

        return response()->json(['codigoProceso' => $codigoProceso]);
    }
}