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

class ActuacionConciPrejuController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function actionIndexActuacionConciPreju($idEstadoEtapa)
    {
        $idUsuario           = Session::get('idUsuario');
        $idResponsable       = Util::idResponsable($idUsuario);
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
                ->leftJoin('juriacciones', 'juriradicados.juriacciones_idAccion', '=', 'juriacciones.idAccion')
                ->leftJoin('jurimedioscontrol', 'juriradicados.jurimedioscontrol_idMediosControl', '=', 'jurimedioscontrol.idMediosControl')
                ->leftJoin('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                ->leftJoin('juriresponsables', 'juriestadosetapas.juriresponsables_idResponsable', '=', 'juriresponsables.idResponsable')
                ->leftJoin('usuarios', 'juriresponsables.usuarios_idUsuario', '=', 'usuarios.idUsuario')
                ->leftJoin('juriestadosradicados', 'juriradicados.juriestadosradicados_idEstadoRadicado', '=', 'juriestadosradicados.idEstadoRadicado')
                ->leftJoin('juriautoridadconoce', 'juriradicados.juriautoridadconoce_idAutoridadConoce', '=', 'juriautoridadconoce.idAutoridadConoce')
                ->leftJoin('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
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

        //diferente a reparto y sin buzón especial
        if($proceso[0]->juritiposestados_idTipoEstado != 2 && $permisoResponsable->buzonEspecial == 0)
        {
            DB::table('juriestadosetapas')
                    ->where('idEstadoEtapa', $idEstadoEtapa)
                    ->update([
                            'leidoEstado'      => 1,
                            'fechaLeidoEstado' => date("Y-m-d H:i:s")]);  
        }

        return view('actuacionConciPrej/index')
                ->with('proceso', $proceso)
                ->with('idEstadoEtapa', $idEstadoEtapa)
                ->with('idResponsable', $idResponsable)
                ->with('archivoCausa', $archivoCausa)
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

    public function actionAgregarConvocante(Request $request)
    {
        $listaTipoDocumentos = DB::table('tiposidentificacion')
            ->orderBy('idTipoIdentificacion', 'asc')
            ->pluck('nombreTipoIdentificacion', 'idTipoIdentificacion');

        $listaDepartamentos = DB::table('departamentos')
                            ->get();

        return view('ajax_conciPreju.ajaxNuevoConvocante')
                    ->with('listaDepartamentos', $listaDepartamentos)
                    ->with('listaTipoDocumentos', $listaTipoDocumentos);
    }

    public function actionValidarGuardarConvocante(Request $request)
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
            ->where('documentoSolicitante', '=', $request->input('documentoConvocanteNuevo'))
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
            $solicitante->documentoSolicitante   = $request->input('documentoConvocanteNuevo');
            $solicitante->nombreSolicitante    = $request->input('nombreConvocante');
            $solicitante->correoSolicitante     = $request->input('correoConvocante');
            $solicitante->telefonoSolicitante   = $request->input('telefonoConvocante');
            $solicitante->direccionSolicitante    = $request->input('direccionConvocante');
            $solicitante->password    = Hash::make($request->input('documentoConvocanteNuevo'));
            $solicitante->creadoVentanilla   = 1; //0 Creado en ventanilla
            $solicitante->tiposidentificacion_idTipoIdentificacion = $request->input('selecTipoDocumento');
            $solicitante->subterritorios_idSubTerritorio  = $request->input('selectBarrioConvocante');
            $solicitante->ciudades_idCiudad      = $request->input('selectCiudadConvocante');
            $solicitante->celularSolicitante    = $request->input('celularConvocante');
            $solicitante->save();

            $convocanteInvolucrado = new Involucrado;
            $convocanteInvolucrado->juritipoinvolucrados_idTipoInvolucrado   = 4;// Convocante
            $convocanteInvolucrado->solicitantes_idSolicitante  = $solicitante->idSolicitante;
            $convocanteInvolucrado->juriradicados_vigenciaRadicado  = $request->input('vigenciaRadicado');
            $convocanteInvolucrado->juriradicados_idRadicado  = $request->input('idRadicado');
            $convocanteInvolucrado->save();

            return;
        }
    }

    public function actionConvocantes(Request $request)
    {
        $convocantes = DB::table('juriinvolucrados')
                    ->join('solicitantes', 'juriinvolucrados.solicitantes_idSolicitante', '=', 'solicitantes.idSolicitante')
                    ->leftJoin('tiposidentificacion', 'solicitantes.tiposidentificacion_idTipoIdentificacion', '=', 'tiposidentificacion.idTipoIdentificacion')
                    ->where('juritipoinvolucrados_idTipoInvolucrado', '=', 4)//convocante
                    ->where('juriradicados_vigenciaRadicado', '=', $request->input('vigenciaRadicado'))
                    ->where('juriradicados_idRadicado', '=', $request->input('idRadicado'))
                    ->get();

        return view('ajax_actuacionConciPreju.ajaxConvocantes')
                ->with('convocantes', $convocantes)
                ->with('responsable', $request->input('responsable')); 
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

        $mediosControl = DB::table('jurimedioscontrol')
                    ->orderBy('idMediosControl', 'asc')
                    ->pluck('nombreMedioControl', 'idMediosControl');

        $temas = DB::table('juritemas')
                    ->orderBy('idTema', 'asc')
                    ->pluck('nombreTema', 'idTema');

        return view('ajax_actuacionConciPreju.ajaxModificarDatos')
                ->with('proceso', $proceso)
                ->with('procaduriaConocedora', $procaduriaConocedora)
                ->with('mediosControl', $mediosControl)
                ->with('temas', $temas); 
    }

    public function actionValidarEditarDatosGenerales(Request $request)
    {
        DB::table('juriradicados')
                    ->where('vigenciaRadicado', $request->input('vigenciaRadicado'))
                    ->where('idRadicado',       $request->input('idRadicado'))
                    ->update([
                            'juriautoridadconoce_idAutoridadConoce'  => $request->input('selectProcuraduria'),
                            'jurimedioscontrol_idMediosControl'      => $request->input('selectMedioControl'),
                            'juritemas_idTema'                       => $request->input('selectTema')]);

        return ;
    }

    public function actionInvolucradoProceso(Request $request)
    {
        if($request->input('tipoInvolucrado') == 4)//convocante
        {
            $involucrado = DB::table('solicitantes')
                            ->where('documentoSolicitante', '=', $request->input('documentoConvocanteNuevo'))
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
            if($request->input('tipoInvolucrado') == 4)//convocante
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
                            ->where('juriconvocadosexternos_idConvocadoExterno', '=', $involucrado[0]->idAbogado)
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
                if($request->input('tipoInvolucrado') == 4)//convocante
                {
                    $convocanteInvolucrado = new Involucrado;
                    $convocanteInvolucrado->juritipoinvolucrados_idTipoInvolucrado = 4;// Convocante
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

    public function actionValidarEliminarConvocante(Request $request)
    {
        $canInvlucrados  = Util::cantidadInvolucrado(4, $request->input('vigenciaRadicado'), $request->input('idRadicado'));
        
        if($canInvlucrados == 1)//solo queda un convocante
        {
            return 0;
        }
        else
        {
            Involucrado::where('idInvolucrado', '=', $request->input('idInvolucrado'))->delete();
            return 1;
        }
    }

    public function actionConvocadosInternos(Request $request)
    {
        $convocadoInt = DB::table('juriinvolucrados')
                    ->join('dependencias', 'juriinvolucrados.dependencias_idDependencia', '=', 'dependencias.idDependencia')
                    ->where('juritipoinvolucrados_idTipoInvolucrado', '=', 5)//convocado interno
                    ->where('juriradicados_vigenciaRadicado', '=', $request->input('vigenciaRadicado'))
                    ->where('juriradicados_idRadicado', '=', $request->input('idRadicado'))
                    ->get();

        return view('ajax_actuacionConciPreju.ajaxConvocadosInternos')
                        ->with('convocadoInt', $convocadoInt)
                        ->with('responsable', $request->input('responsable'));
    }

    public function actionValidarRemoverConvocadoInt(Request $request)
    {
        $canInvlucrados  = Util::cantidadInvolucrado(5, $request->input('vigenciaRadicado'), $request->input('idRadicado'));
        
        if($canInvlucrados == 1)//solo queda un convocado interno
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

        return view('ajax_actuacionConciPreju.ajaxAccionadosExternos')
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
}