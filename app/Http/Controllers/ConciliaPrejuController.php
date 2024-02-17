<?php
namespace SQ10\Http\Controllers;

use DB;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Session;
use SQ10\Models\Entidad;
use SQ10\Models\Dependencia;
use SQ10\Models\Solicitante;
use SQ10\Models\ConvocadoExterno;
use SQ10\Models\Radicado;
use SQ10\Models\Involucrado;
use SQ10\Models\EstadoEtapa;
use SQ10\Models\Archivo;
use SQ10\Models\Usuario;
use SQ10\Models\CuantiaRadicado;
use SQ10\Models\Abogado;
use SQ10\helpers\Util as Util;
use Barryvdh\DomPDF\Facade as PDF;

class ConciliaPrejuController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function actionIndex($idTipoProceso)
    {
        $vigenciaActual = date("Y");

        $slv = Util::valorParametro(28);

        $acciones = DB::table('juriacciones')
        			->where('juritipoprocesos_idTipoProcesos', '=', $idTipoProceso)
                    ->orderBy('idAccion', 'asc')
                    ->get();

        $listaMediosControl = DB::table('jurimedioscontrol')
            ->orderBy('idMediosControl', 'asc')
            ->pluck('nombreMedioControl', 'idMediosControl');

        return view('conciPreju/index')
            ->with('acciones', $acciones)
            ->with('listaMediosControl', $listaMediosControl)
            ->with('idTipoProceso', $idTipoProceso)
            ->with('slv', $slv);
    }

    public function actionBusquedaConvocante(Request $request)
    {
        $q = "+".preg_replace( '/\s(\w+)/', ' +\\1', $request->input('criterioConvocante'));

        $solicitantes = Solicitante::whereRaw("MATCH(nombreSolicitante) AGAINST(? IN BOOLEAN MODE)", array($q))
            ->orWhere("documentoSolicitante", $request->input('criterioConvocante'))
            ->orderBy(DB::raw('documentoSolicitante+nombreSolicitante'), 'asc')
            ->get();

        return view("ajax_conciPreju.ajaxBusquedaConvocante")
            ->with("solicitantes", $solicitantes)
            ->with("criterioConvocante", $q);
    }

    public function actionBusquedaConvocadoInt(Request $request)
    {
    	$q = "+".preg_replace( '/\s(\w+)/', ' +\\1', $request->input('criterioConvocadoInt'));

        $convocados = Dependencia::whereRaw("MATCH(nombreDependencia) AGAINST(? IN BOOLEAN MODE)", array($q))
            ->orderBy(DB::raw('codigoDependencia+nombreDependencia'), 'asc')
            ->get();

        return view("ajax_conciPreju.ajaxBusquedaConvocadoInt")
            ->with("convocados", $convocados)
            ->with("criterioConvocadoInt", $q);
    }

    public function actionBusquedaConvocadoExt(Request $request)
    {
    	$q = "+".preg_replace( '/\s(\w+)/', ' +\\1', $request->input('criterioConvocadoExt'));

        $convocadosExt = ConvocadoExterno::whereRaw("MATCH(nombreConvocadoExterno) AGAINST(? IN BOOLEAN MODE)", array($q))
            ->orderBy(DB::raw('direccionConvocadoExterno+nombreConvocadoExterno'), 'asc')
            ->get();

        return view("ajax_conciPreju.ajaxBusquedaConvocadoExt")
            ->with("convocadosExt", $convocadosExt)
            ->with("criterioConvocadoExt", $q);
    }

    public function actionSeleccioneConvocante(Request $request)
    {
    	$convocantes = json_decode($request->input('jsonConvocantes'), true);

        $convocante = DB::table('solicitantes')
                    ->leftJoin('tiposidentificacion', 'solicitantes.tiposidentificacion_idTipoIdentificacion', '=', 'tiposidentificacion.idTipoIdentificacion')
                    ->leftJoin('ciudades', 'solicitantes.ciudades_idCiudad', '=', 'ciudades.idCiudad')
                    ->leftJoin('departamentos', 'ciudades.departamentos_idDepartamento', '=', 'departamentos.idDepartamento')
                    ->whereIn('idSolicitante', $convocantes)
                    ->get();

        return view('ajax_conciPreju.ajaxConvocantesSeleccionados')
                    ->with('convocante', $convocante);
    }

    public function actionSeleccioneConvocadoInt(Request $request)
    {
    	$convocadosInt = json_decode($request->input('jsonConvocadosInt'), true);

        $convocadoInt = DB::table('dependencias')
                    ->whereIn('idDependencia', $convocadosInt)
                    ->get();

        return view('ajax_conciPreju.ajaxConvocadosIntSeleccionados')
                    ->with('convocadoInt', $convocadoInt);
    }

    public function actionSeleccioneConvocadoExt(Request $request)
    {
    	$convocadosExt = json_decode($request->input('jsonConvocadosExt'), true);

        $convocadoExt = DB::table('juriconvocadosexternos')
                    ->whereIn('idConvocadoExterno', $convocadosExt)
                    ->get();

        return view('ajax_conciPreju.ajaxConvocadosExtSeleccionados')
                    ->with('convocadoExt', $convocadoExt);
    }

    public function actionNuevoConvocante(Request $request)
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

    public function actionNuevoConvocadoExt()
    {
        return view('ajax_conciPreju.ajaxNuevoConvocadoExt');
    }

    public function actionElegirBarrioConvocante(Request $request)
    {
    	$listaBarrios = DB::table('territorios')
                        ->get();

        return view('ajax_conciPreju.ajaxBarrioConvocante')
            ->with('listaBarrios', $listaBarrios);
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

            return $solicitante->idSolicitante;
        }
    }

    public function actionValidarGuardarConvocadoExt(Request $request)
    {
        $validarConvocadoExt = DB::table('juriconvocadosexternos')
            ->where('nombreConvocadoExterno', '=', $request->input('nombreConvocadoExterno'))
            ->get();

        if (count($validarConvocadoExt) > 0) 
        {
            return 0;// nombre repetido
        } 
        else
        {
            $convocadoExt   = new ConvocadoExterno;
            $convocadoExt->nombreConvocadoExterno       = $request->input('nombreConvocadoExterno');
            $convocadoExt->direccionConvocadoExterno    = $request->input('direccionConvocadoExterno');
            $convocadoExt->telefonoConvocadoExterno     = $request->input('telefonoConvocadoExterno');
            $convocadoExt->save();

            return $convocadoExt->idConvocadoExterno;
        }
    }

    public function actionEditarConvocante(Request $request)
    {
    	$convocante = DB::table('solicitantes')
                    ->where('idSolicitante', '=', $request->input('idConvocante'))
                    ->get();

        $listaTipoDocumentos = DB::table('tiposidentificacion')
            ->orderBy('idTipoIdentificacion', 'asc')
            ->pluck('nombreTipoIdentificacion', 'idTipoIdentificacion');

        $listaDepartamentos = DB::table('departamentos')
                            ->get();

        $listaBarrios = DB::table('territorios')
                        ->get();

        return view('ajax_conciPreju.ajaxEditarConvocante')
                    ->with('listaDepartamentos', $listaDepartamentos)
                    ->with('listaTipoDocumentos', $listaTipoDocumentos)
                    ->with('convocante', $convocante)
                    ->with('listaBarrios', $listaBarrios);
    }

    public function actionEditarConvocadoExt(Request $request)
    {
        $convocadoExt = DB::table('juriconvocadosexternos')
                    ->where('idConvocadoExterno', '=', $request->input('idConvocadoExt'))
                    ->get();

        return view('ajax_conciPreju.ajaxEditarConvocadoExt')
                    ->with('convocadoExt', $convocadoExt);
    }

    public function actionvalidarEditarConvocante(Request $request)
    {
    	$validarCorreoNoRepetido = DB::table('solicitantes')
            ->where('correoSolicitante', '=', $request->input('correoConvocanteEditar'))
            ->where('correoSolicitante', '!=', '')
            ->where('idSolicitante', '!=', $request->input('idConvocante'))
            ->get();

        $validarDocumentoRepetido = DB::table('solicitantes')
            ->where('documentoSolicitante', '=', $request->input('documentoConvocanteNuevoEditar'))
            ->where('documentoSolicitante', '!=', '')
            ->where('idSolicitante', '!=', $request->input('idConvocante'))
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
            $solicitante = DB::table('solicitantes')
                            ->select('idSolicitante','documentoSolicitante', 'nombreSolicitante', 'correoSolicitante', 'telefonoSolicitante', 'direccionSolicitante', 'tiposidentificacion_idTipoIdentificacion', 'ciudades_idCiudad', 'subterritorios_idSubTerritorio', 'celularSolicitante')                       
                             ->where('idSolicitante', $request->input('idConvocante'))
                             ->first();  

            //Guarda el log
            $antes = json_encode($solicitante);
            $array = array(
                'documentoSolicitante' => $request->input('documentoConvocanteNuevoEditar'),
                'nombreSolicitante' => $request->input('nombreConvocanteEditar'),
                'correoSolicitante' => $request->input('correoConvocanteEditar'),
                'telefonoSolicitante' => $request->input('telefonoConvocanteEditar'),
                'direccionSolicitante' => $request->input('direccionConvocanteEditar'),
                'tiposidentificacion_idTipoIdentificacion' => $request->input('selecTipoDocumentoEditar'),
                'ciudades_idCiudad' => $request->input('selectCiudadConvocanteEditar'),
                'subterritorios_idSubTerritorio' => $request->input('selectBarrioConvocanteEditar'),
                'celularSolicitante' => $request->input('celularConvocanteEditar')
            );

            $despues = json_encode($array);
            $detalle = "Antes: ".$antes.".  Después: ".$despues;
            Util::guardarLogGed(92, $detalle, NULL);//92 Modifica solicitante desde LITIGO

            DB::table('solicitantes')
                    ->where('idSolicitante', $request->input('idConvocante'))
                    ->update($array);

            return 0; // Convocante modificado
        }
    }

    public function actionValidarEditarConvocadoExt(Request $request)
    {
        $validarConvocadoExt = DB::table('juriconvocadosexternos')
            ->where('nombreConvocadoExterno', '=', $request->input('nombreConvocadoExternoEditar'))
            ->where('idConvocadoExterno', '!=', $request->input('idConvocadoExt'))
            ->get();

        if (count($validarConvocadoExt) > 0) 
        {
            return 0;// nombre repetido
        } 
        else
        {
            DB::table('juriconvocadosexternos')
                    ->where('idConvocadoExterno', $request->input('idConvocadoExt'))
                    ->update([
                            'nombreConvocadoExterno'       => $request->input('nombreConvocadoExternoEditar'),
                            'direccionConvocadoExterno'    => $request->input('direccionConvocadoExternoEditar'),
                            'telefonoConvocadoExterno'     => $request->input('telefonoConvocadoExternoEditar')]);

            return 1;
        }
    }

    public function actionValidarGuardarRadicado(Request $request)
    {
        $idUsuario = Session::get('idUsuario');
        $idResponsableRadicación = Util::idResponsable($idUsuario);
        $datosResponsable = Util::datosResponsable($idUsuario);

        //Buscar los responsables del reparto
        $resposanblesReparto = DB::table('juriresponsables')
            ->select('idResponsable', 'usuarios_idUsuario')
            ->join('usuarios', 'juriresponsables.usuarios_idUsuario', '=', 'usuarios.idUsuario')
            ->where('juriroles_idRol', '=', 2)// rol de reparto
            ->where('juripuntosatencion_idPuntoAtencion', '=', $datosResponsable->juripuntosatencion_idPuntoAtencion)//punto de atención para radicar y perfil de reparto
            ->get();
            
        if(count($resposanblesReparto) == 0)
        {   
            return 1;// no hay responsables de reparto
        }
        //#Buscar los responsables del reparto

        $vectorConvocantes   = json_decode($request->input('jsonConvocantes'), true);
        $vectorConvocadosInt = json_decode($request->input('jsonConvocadosInt'), true);
        $vectorConvocadosExt = json_decode($request->input('jsonConvocadosExt'), true);
        $vectorAbogados      = json_decode($request->input('jsonAbogados'), true);

        //Cuantía
        $vectorSelectUnidadMonetaria = json_decode($request->input('jsonSelectUnidadMonetaria'), true);
        $vectorValor                 = json_decode($request->input('jsonValor'), true);
        $vectorValorPesos            = json_decode($request->input('jsonValorPesos'), true);

        $radicado = new Radicado;
        $radicado->vigenciaRadicado                          = date('Y');
        $radicado->juriestadosradicados_idEstadoRadicado     = 1; // pendiente
        $radicado->juriacciones_idAccion                     = $request->input('sentidoConvocante');
        $radicado->jurimedioscontrol_idMediosControl         = $request->input('selectMedioControl');
        $radicado->fechaNotificacion                         = $request->input('fechaNotifi');
        $radicado->descripcionHechos                         = $request->input('descripcionHechos');
        $radicado->juritipoprocesos_idTipoProceso            = $request->input('idTipoProceso');
        $radicado->juritemas_idTema                          = $request->input('selectTema');
        $radicado->asunto                                    = $request->input('asunto');
        $radicado->save();

        if($request->input('selectUnidadMonetaria') !='')
        {
            for ($i = 0; $i < count($vectorSelectUnidadMonetaria); $i++) 
            {
                $cuantia = new CuantiaRadicado;
                $cuantia->unidadMonetaria                     = $vectorSelectUnidadMonetaria[$i];
                $cuantia->valor                               = $vectorValor[$i];
                $cuantia->valorPesos                          = str_replace(".","",$vectorValorPesos[$i]);
                $cuantia->juriradicados_vigenciaRadicado      = date('Y');
                $cuantia->juriradicados_idRadicado            = $radicado->idRadicado;
                $cuantia->save();
            }
        }

        for($i=0; $i < count($vectorAbogados); $i++)
        {
            $abogadoInvolucrado = new Involucrado;
            $abogadoInvolucrado->juritipoinvolucrados_idTipoInvolucrado      = 2;// abogado demandante
            $abogadoInvolucrado->juriabogados_idAbogado  = $vectorAbogados[$i];
            $abogadoInvolucrado->juriradicados_vigenciaRadicado  = date('Y');
            $abogadoInvolucrado->juriradicados_idRadicado  = $radicado->idRadicado;
            $abogadoInvolucrado->save();
        }

        $demandantesPersonas = "";
        for($i=0; $i < count($vectorConvocantes); $i++)
        {
            $convocanteInvolucrado = new Involucrado;
            $convocanteInvolucrado->juritipoinvolucrados_idTipoInvolucrado      = 4;// Convocante
            $convocanteInvolucrado->solicitantes_idSolicitante  = $vectorConvocantes[$i];
            $convocanteInvolucrado->juriradicados_vigenciaRadicado  = date('Y');
            $convocanteInvolucrado->juriradicados_idRadicado  = $radicado->idRadicado;
            $convocanteInvolucrado->save();

            $persona = DB::table('solicitantes')
                ->select('nombreSolicitante')
                ->where('idSolicitante', '=', $vectorConvocantes[$i])
                ->get();
            $demandantesPersonas .= $persona[0]->nombreSolicitante.",";
        }

        $demandadosPersonas = "";
        for($i=0; $i < count($vectorConvocadosInt); $i++)
        {
            $convocadoInvolucrado = new Involucrado;
            $convocadoInvolucrado->juritipoinvolucrados_idTipoInvolucrado      = 5;// Convocado Int
            $convocadoInvolucrado->dependencias_idDependencia  = $vectorConvocadosInt[$i];
            $convocadoInvolucrado->juriradicados_vigenciaRadicado  = date('Y');
            $convocadoInvolucrado->juriradicados_idRadicado  = $radicado->idRadicado;
            $convocadoInvolucrado->save();

            $dependencia = DB::table('dependencias')
                ->select('nombreDependencia')
                ->where('idDependencia', '=', $vectorConvocadosInt[$i])
                ->get();
            $demandadosPersonas .= $dependencia[0]->nombreDependencia.",";
        }

        for($i=0; $i < count($vectorConvocadosExt); $i++)
        {
            $convocadoExtInvolucrado = new Involucrado;
            $convocadoExtInvolucrado->juritipoinvolucrados_idTipoInvolucrado      = 6;// Convocado Externo
            $convocadoExtInvolucrado->juriconvocadosexternos_idConvocadoExterno  = $vectorConvocadosExt[$i];
            $convocadoExtInvolucrado->juriradicados_vigenciaRadicado  = date('Y');
            $convocadoExtInvolucrado->juriradicados_idRadicado  = $radicado->idRadicado;
            $convocadoExtInvolucrado->save();
        }

        //Estado etapa inicial
        $comentarioEstado = "Se realiza la radicación del proceso ".date('Y')."-".$radicado->idRadicado;
        $estadoEtapa = new EstadoEtapa;
        $estadoEtapa->fechaInicioEstado                        = date("Y-m-d H:i:s");
        $estadoEtapa->fechaFinalEstado                         = date("Y-m-d H:i:s");
        $estadoEtapa->juritipoestadosetapas_idTipoEstadoEtapa  = 2;// Gestionado-Terminado
        $estadoEtapa->juriradicados_vigenciaRadicado           = date('Y');
        $estadoEtapa->juriradicados_idRadicado                 = $radicado->idRadicado;
        $estadoEtapa->comentarioEstadoEtapa                    = $comentarioEstado;
        $estadoEtapa->juriresponsables_idResponsable           = $idResponsableRadicación;
        $estadoEtapa->juritiposestados_idTipoEstado            = 1;
        $estadoEtapa->save();
        Util::guardarObservacion(date("Y-m-d H:i:s"), date("Y-m-d H:i:s"), 2, date('Y'), $radicado->idRadicado,
                                $comentarioEstado, $idResponsableRadicación, 1, $estadoEtapa->idEstadoEtapa, 1);
        //#Estado etapa inicial

        //Etapa siguiente a la radicación
        for($i=0; $i < count($resposanblesReparto); $i++)
        {
            $estadoEtapa = new EstadoEtapa;
            $estadoEtapa->fechaInicioEstado                        = date("Y-m-d H:i:s");
            $estadoEtapa->juritipoestadosetapas_idTipoEstadoEtapa  = 1;// Actual estado
            $estadoEtapa->juriradicados_vigenciaRadicado           = date('Y');
            $estadoEtapa->juriradicados_idRadicado                 = $radicado->idRadicado;
            $estadoEtapa->juriresponsables_idResponsable           = $resposanblesReparto[$i]->idResponsable;
            $estadoEtapa->juritiposestados_idTipoEstado            = 2;
            $estadoEtapa->save();
            Util::guardarObservacion(date("Y-m-d H:i:s"), Null, 1, date('Y'), $radicado->idRadicado,
                                    '', $resposanblesReparto[$i]->idResponsable, 2, $estadoEtapa->idEstadoEtapa, 2);
        }
        //# Etapa siguiente a la radicación

        $observacion = "Radica un nuevo proceso";
        Util::guardarLog($observacion, date('Y'), $radicado->idRadicado, 3);

        return response()->json([
            'idRadicado'               => $radicado->idRadicado,
            'vigenciaRadicado'         => date('Y'),
            'resposanblesReparto'      => $resposanblesReparto,
        ]);
    }

    public function actionInformacionPdf($vigenciaRadicado, $idRadicado)
    {
        $entidad = Entidad::find(1);

        $informacionPdf = DB::table('juriradicados')
                    ->join('juriacciones', 'juriradicados.juriacciones_idAccion', '=', 'juriacciones.idAccion')
                    ->join('jurimedioscontrol', 'juriradicados.jurimedioscontrol_idMediosControl', '=', 'jurimedioscontrol.idMediosControl')
                    ->join('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                    ->leftJoin('juriautoridadconoce', 'juriradicados.juriautoridadconoce_idAutoridadConoce', '=', 'juriautoridadconoce.idAutoridadConoce')
                    ->where('vigenciaRadicado', '=', $vigenciaRadicado)
                    ->where('idRadicado', '=', $idRadicado)
                    ->get();

        $cuantias = DB::table('juricuantiaradicado')
                    ->where('juriradicados_vigenciaRadicado', '=', $vigenciaRadicado)
                    ->where('juriradicados_idRadicado', '=', $idRadicado)
                    ->get();

        $convocantes = DB::table('juriinvolucrados')
                    ->join('solicitantes', 'juriinvolucrados.solicitantes_idSolicitante', '=', 'solicitantes.idSolicitante')
                    ->where('juritipoinvolucrados_idTipoInvolucrado', '=', 4)//convocante
                    ->where('juriradicados_vigenciaRadicado', '=', $vigenciaRadicado)
                    ->where('juriradicados_idRadicado', '=', $idRadicado)
                    ->get();

        $convocadosInt = DB::table('juriinvolucrados')
                    ->join('dependencias', 'juriinvolucrados.dependencias_idDependencia', '=', 'dependencias.idDependencia')
                    ->where('juritipoinvolucrados_idTipoInvolucrado', '=', 5)//convocados internos
                    ->where('juriradicados_vigenciaRadicado', '=', $vigenciaRadicado)
                    ->where('juriradicados_idRadicado', '=', $idRadicado)
                    ->get();

        $convocadosExt = DB::table('juriinvolucrados')
                    ->join('juriconvocadosexternos', 'juriinvolucrados.juriconvocadosexternos_idConvocadoExterno', '=', 'juriconvocadosexternos.idConvocadoExterno')
                    ->where('juritipoinvolucrados_idTipoInvolucrado', '=', 6)//convocados externos
                    ->where('juriradicados_vigenciaRadicado', '=', $vigenciaRadicado)
                    ->where('juriradicados_idRadicado', '=', $idRadicado)
                    ->get();

        $pdf = PDF::loadView('conciPreju.pdfInformacion', array('vigenciaRadicado' => $vigenciaRadicado, 'idRadicado' => $idRadicado, 'informacionPdf' => $informacionPdf, 'cuantias' => $cuantias, 'convocantes' => $convocantes, 'convocadosInt' => $convocadosInt, 'convocadosExt' => $convocadosExt, 'entidad' => $entidad));
        return $pdf->stream('Radicado'.$vigenciaRadicado.'-'.$idRadicado.'.pdf');
    }

    public function actionIniciarDropzoneRadica(Request $request)
    {
        return view("ajax_conciPreju.ajaxDrozoneRadica");
    }

    public function actionUploadArchivoRadicacion(Request $request)
    {
        $idUsuario = Session::get('idUsuario');
        $idResponsableRadicación = Util::idResponsable($idUsuario);

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
            $archivo->juriresponsables_idResponsable    = $idResponsableRadicación;
            $archivo->save();

            return 1;// subió correctamente
        }
        else
        {
            return 2;// no subió
        }
    }

    public function actionNuevoAbogado(Request $request)
    {
        $listaTipoDocumentos = DB::table('tiposidentificacion')
            ->orderBy('idTipoIdentificacion', 'asc')
            ->pluck('nombreTipoIdentificacion', 'idTipoIdentificacion');

        return view('ajax_conciPreju.ajaxNuevoAbogado')
                    ->with('listaTipoDocumentos', $listaTipoDocumentos);
    }

    public function actionSeleccioneAbogado(Request $request)
    {
        $abogados = json_decode($request->input('jsonAbogados'), true);

        $abogado = DB::table('juriabogados')
                    ->leftJoin('tiposidentificacion', 'juriabogados.tiposidentificacion_idTipoIdentificacion', '=', 'tiposidentificacion.idTipoIdentificacion')
                    ->whereIn('idAbogado', $abogados)
                    ->get();

        return view('ajax_conciPreju.ajaxAbogadosSeleccionados')
                    ->with('abogado', $abogado);
    }

    public function actionValidarGuardarAbogado(Request $request)
    {
        $validarDocumentoRepetido = DB::table('juriabogados')
            ->where('documentoAbogado', '=', $request->input('documentoAbogado'))
            ->get();

        if (count($validarDocumentoRepetido) > 0) 
        {
            return 0;// documento repetido
        }
        else
        {
            $abogado   = new Abogado;
            $abogado->documentoAbogado           = $request->input('documentoAbogado');
            $abogado->nombreAbogado              = $request->input('nombreAbogado');
            $abogado->tarjetaAbogado             = $request->input('tarjetaAbogado');
            $abogado->tiposidentificacion_idTipoIdentificacion   = $request->input('selecTipoDocumentoAbogado');
            $abogado->save();

            return $abogado->idAbogado;
        }
    }

    public function actionBusquedaAbogadoDemandante(Request $request)
    {
        $q = "+".preg_replace( '/\s(\w+)/', ' +\\1', $request->input('criterioAbogado'));

        $abogados = Abogado::whereRaw("MATCH(nombreAbogado) AGAINST(? IN BOOLEAN MODE)", array($q))
            ->orWhere("documentoAbogado", $request->input('criterioAbogado'))
            ->orderBy(DB::raw('documentoAbogado+nombreAbogado'), 'asc')
            ->get();

        return view("ajax_conciPreju.ajaxBusquedaAbogadoDemandante")
            ->with("abogados", $abogados)
            ->with("criterioAbogado", $q);
    }

    public function actionEditarAbogado(Request $request)
    {
        $abogado = DB::table('juriabogados')
                    ->where('idAbogado', '=', $request->input('idAbogado'))
                    ->get();

        $listaTipoDocumentos = DB::table('tiposidentificacion')
            ->orderBy('idTipoIdentificacion', 'asc')
            ->pluck('nombreTipoIdentificacion', 'idTipoIdentificacion');

        return view('ajax_conciPreju.ajaxEditarAbogado')
                    ->with('listaTipoDocumentos', $listaTipoDocumentos)
                    ->with('abogado', $abogado);
    }

    public function actionValidarEditarAbogado(Request $request)
    {
        $validarDocumentoRepetido = DB::table('juriabogados')
            ->where('documentoAbogado', '=', $request->input('documentoAbogado'))
            ->where('idAbogado', '!=', $request->input('idAbogado'))
            ->get();

        if (count($validarDocumentoRepetido) > 0) 
        {
            return 0;// documento repetido
        }
        else
        {
            DB::table('juriabogados')
                    ->where('idAbogado', $request->input('idAbogado'))
                    ->update([
                            'documentoAbogado' => $request->input('documentoAbogadoDemandanteEditar'),
                            'nombreAbogado' => $request->input('nombreAbogadoEditar'),
                            'tarjetaAbogado' => $request->input('tarjetaAbogadoEditar'),
                            'tiposidentificacion_idTipoIdentificacion' => $request->input('selecTipoDocumentoAbogadoEditar')]);

            return 1; // abogado modificado
        }
    }
}