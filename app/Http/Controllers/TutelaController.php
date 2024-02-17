<?php
namespace SQ10\Http\Controllers;

use DB;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Session;
use SQ10\Models\Entidad;
use SQ10\Models\Solicitante;
use SQ10\Models\Dependencia;
use SQ10\Models\Radicado;
use SQ10\Models\ConvocadoExterno;
use SQ10\Models\Involucrado;
use SQ10\Models\EstadoEtapa;
use SQ10\Models\Archivo;
use SQ10\Models\Tema;
use SQ10\Models\Usuario;
use SQ10\Models\PlazoRadicado;
use SQ10\helpers\Util as Util;
use Barryvdh\DomPDF\Facade as PDF;

class TutelaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function actionIndex($idTipoProceso)
    {
        $slv = Util::valorParametro(28);

        $vigenciaActual = date("Y");

        $listaActosAdministrativos = DB::table('juritiposactosadministrativos')
            ->orderBy('idTipoActo', 'asc')
            ->pluck('nombreTipoActo', 'idTipoActo');

        $procaduriaConocedora = DB::table('juriautoridadconoce')
            ->orderBy('idAutoridadConoce', 'asc')
            ->pluck('nombreAutoridadConoce', 'idAutoridadConoce');

        $listaJuzgados = DB::table('jurijuzgados')
            ->orderBy('idJuzgado', 'asc')
            ->pluck('nombreJuzgado', 'idJuzgado');

        return view('tutelas/index')
            ->with('listaActosAdministrativos', $listaActosAdministrativos)
            ->with('procaduriaConocedora', $procaduriaConocedora)
            ->with('listaJuzgados', $listaJuzgados)
            ->with('slv', $slv)
            ->with('idTipoProceso', $idTipoProceso)
            ->with('vigenciaActual', $vigenciaActual);
    }

    public function actionCargarJuzgado(Request $request)
    {
        // 0 No conoce el código
        // 1 conoce el código
        if($request->input('conoceCodigo') == 1)
        {
            $codigoProceso =  str_replace("-", "", $request->input('codigoProceso'));
            
        }
        else
        {
            $juzgadoCodigo = DB::table('jurijuzgados')
                    ->where('idJuzgado', '=', $request->input('selectJuzgados'))
                    ->first();

            $vigRadJuzgado =  str_replace("-", "", $request->input('vigRadJuzgado'));

            $codigoProceso =  $juzgadoCodigo->codigoUnicoJuzgado.$vigRadJuzgado;
        }

        $codigoExiste = DB::table('juriradicados')
                        ->where('codigoProceso', '=', $codigoProceso)
                        ->get();

        if(count($codigoExiste) > 0)// código ya se encuentra registrado
        {
            return response()->json([
                'vigenciaRadicado'  => $codigoExiste[0]->vigenciaRadicado,
                'idRadicado'        => $codigoExiste[0]->idRadicado,
                'codigoExiste'      => 0,
            ]);
        }

        $idCiudad = substr($codigoProceso, 0, 5);
        $vigencia = substr($codigoProceso, 12, 4);
        $radicado = substr($codigoProceso, 16, 5);
        $idJuzgado = substr($codigoProceso, 0, 12);
        
        $ciudad = DB::table('juriciudades')
                    ->join('juridepartamentos', 'juriciudades.departamentos_idDepartamento', 'juridepartamentos.idDepartamento')
                    ->where('idCiudad', '=', $idCiudad)
                    ->first();

        $juzgado = DB::table('jurijuzgados')
                    ->where('codigoUnicoJuzgado', '=', $idJuzgado)
                    ->first();

        if(count($juzgado) > 0)
        {
            return response()->json([
                'vistaCodigoJuz'  => view('ajax_tutelas.ajaxCodigoJuzgado')
                    ->with('ciudad', $ciudad->nombreCiudad." | ".$ciudad->nombreDepartamento)  
                    ->with('vigencia', $vigencia)  
                    ->with('radicado', $radicado)  
                    ->with('juzgado', $juzgado->nombreJuzgado)
                    ->with('idJuzgado', $juzgado->idJuzgado)
                    ->with('codigoProceso', $codigoProceso)
                    ->render(),
                'codigoProceso'  => $codigoProceso,
            ]);
        }
        else
        {
            return 2; // no encuentra juzgado
        }
    }

    public function actionBusquedaAccionante(Request $request)
    {
        $q = "+".preg_replace( '/\s(\w+)/', ' +\\1', $request->input('criterioAccionante'));

        $solicitantes = Solicitante::whereRaw("MATCH(nombreSolicitante) AGAINST(? IN BOOLEAN MODE)", array($q))
            ->orWhere("documentoSolicitante", $request->input('criterioAccionante'))
            ->orderBy(DB::raw('documentoSolicitante+nombreSolicitante'), 'asc')
            ->get();

        return view("ajax_tutelas.ajaxBusquedaAccionante")
            ->with("solicitantes", $solicitantes)
            ->with("criterioAccionante", $q);
    }

    public function actionBusquedaAccionadoInt(Request $request)
    {
        $q = "+".preg_replace( '/\s(\w+)/', ' +\\1', $request->input('criterioAccionadoInt'));

        $accionadosInt = Dependencia::whereRaw("MATCH(nombreDependencia) AGAINST(? IN BOOLEAN MODE)", array($q))
            ->orderBy(DB::raw('codigoDependencia+nombreDependencia'), 'asc')
            ->get();

        return view("ajax_tutelas.ajaxBusquedaAccionadoInt")
            ->with("accionadosInt", $accionadosInt)
            ->with("criterioAccionadoInt", $q);
    }

    public function actionSeleccioneAccionante(Request $request)
    {
        $accionantes = json_decode($request->input('jsonAccionantes'), true);

        $accionante = DB::table('solicitantes')
                    ->leftJoin('tiposidentificacion', 'solicitantes.tiposidentificacion_idTipoIdentificacion', '=', 'tiposidentificacion.idTipoIdentificacion')
                    ->leftJoin('ciudades', 'solicitantes.ciudades_idCiudad', '=', 'ciudades.idCiudad')
                    ->leftJoin('departamentos', 'ciudades.departamentos_idDepartamento', '=', 'departamentos.idDepartamento')
                    ->whereIn('idSolicitante', $accionantes)
                    ->get();

        return view('ajax_tutelas.ajaxAccionantesSeleccionados')
                    ->with('accionante', $accionante);
    }

    public function actionBusquedaAccionadoExt(Request $request)
    {
        $q = "+".preg_replace( '/\s(\w+)/', ' +\\1', $request->input('criterioAccionadoExt'));

        $convocadosExt = ConvocadoExterno::whereRaw("MATCH(nombreConvocadoExterno) AGAINST(? IN BOOLEAN MODE)", array($q))
            ->orderBy(DB::raw('direccionConvocadoExterno+nombreConvocadoExterno'), 'asc')
            ->get();

        return view("ajax_tutelas.ajaxBusquedaAccionadoExt")
            ->with("convocadosExt", $convocadosExt)
            ->with("criterioAccionadoExt", $q);
    }

    public function actionSeleccioneAccionadoInt(Request $request)
    {
        $accionadosInt = json_decode($request->input('jsonAccionadosInt'), true);

        $accionadoInt = DB::table('dependencias')
                    ->whereIn('idDependencia', $accionadosInt)
                    ->get();

        return view('ajax_tutelas.ajaxAccionadosIntSeleccionados')
                    ->with('accionadoInt', $accionadoInt);
    }

    public function actionSeleccioneAccionadoExt(Request $request)
    {
        $accionadosExt = json_decode($request->input('jsonAccionadoExt'), true);

        $accionadoExt = DB::table('juriconvocadosexternos')
                    ->whereIn('idConvocadoExterno', $accionadosExt)
                    ->get();

        return view('ajax_tutelas.ajaxAccionadoExtSeleccionados')
                    ->with('accionadoExt', $accionadoExt);
    }

    public function actionNuevoAccionante(Request $request)
    {
        $listaTipoDocumentos = DB::table('tiposidentificacion')
            ->orderBy('idTipoIdentificacion', 'asc')
            ->pluck('nombreTipoIdentificacion', 'idTipoIdentificacion');

        $listaDepartamentos = DB::table('departamentos')
                            ->get();

        return view('ajax_tutelas.ajaxNuevoAccionante')
                    ->with('listaDepartamentos', $listaDepartamentos)
                    ->with('listaTipoDocumentos', $listaTipoDocumentos);
    }

    public function actionElegirBarrioAccionante(Request $request)
    {
        $listaBarrios = DB::table('territorios')
                        ->get();

        return view('ajax_tutelas.ajaxBarrioAccionante')
            ->with('listaBarrios', $listaBarrios);
    }

    public function actionElegirBarrioAccionanteEditar(Request $request)
    {
        $accionante = DB::table('solicitantes')
                    ->where('idSolicitante', '=', $request->input('idAccionante'))
                    ->get();

        $listaBarrios = DB::table('territorios')
                        ->get();

        return view('ajax_tutelas.ajaxBarrioAccionanteEditar')
            ->with('listaBarrios', $listaBarrios)
            ->with('accionante', $accionante);
    }

    public function actionValidarGuardarAccionante(Request $request)
    {
        $validarCorreoNoRepetido = [];
        if($request->input('correoDemandante') !='')
        {
            $validarCorreoNoRepetido = DB::table('solicitantes')
                ->where('correoSolicitante', '=', $request->input('correoDemandante'))
                ->get();
        }

        $validarDocumentoRepetido = DB::table('solicitantes')
            ->where('documentoSolicitante', '!=', '')
            ->where('documentoSolicitante', '=', $request->input('documentoAccionanteNuevo'))
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
            $solicitante->documentoSolicitante   = $request->input('documentoAccionanteNuevo');
            $solicitante->nombreSolicitante    = $request->input('nombreAccionante');
            $solicitante->correoSolicitante     = $request->input('correoAccionante');
            $solicitante->telefonoSolicitante   = $request->input('telefonoAccionante');
            $solicitante->direccionSolicitante    = $request->input('direccionAccionante');
            $solicitante->password    = Hash::make($request->input('documentoAccionanteNuevo'));
            $solicitante->creadoVentanilla   = 1; //0 Creado en ventanilla
            $solicitante->tiposidentificacion_idTipoIdentificacion = $request->input('selecTipoDocumento');
            $solicitante->subterritorios_idSubTerritorio  = $request->input('selectBarrioAccionante');
            $solicitante->ciudades_idCiudad      = $request->input('selectCiudadAccionante');
            $solicitante->celularSolicitante    = $request->input('celularAccionante');
            $solicitante->save();

            return $solicitante->idSolicitante;
        }
    }

    public function actionEditarAccionante(Request $request)
    {
        $accionante = DB::table('solicitantes')
                    ->where('idSolicitante', '=', $request->input('idAccionante'))
                    ->get();

        $listaTipoDocumentos = DB::table('tiposidentificacion')
            ->orderBy('idTipoIdentificacion', 'asc')
            ->pluck('nombreTipoIdentificacion', 'idTipoIdentificacion');

        $listaDepartamentos = DB::table('departamentos')
                            ->get();

        $listaBarrios = DB::table('territorios')
                        ->get();

        return view('ajax_tutelas.ajaxEditarAccionante')
                    ->with('listaDepartamentos', $listaDepartamentos)
                    ->with('listaTipoDocumentos', $listaTipoDocumentos)
                    ->with('accionante', $accionante)
                    ->with('listaBarrios', $listaBarrios);
    }

    public function actionValidarEditarAccionante(Request $request)
    {
        $validarCorreoNoRepetido = DB::table('solicitantes')
            ->where('correoSolicitante', '=', $request->input('correoAccionanteEditar'))
            ->where('correoSolicitante', '!=', '')
            ->where('idSolicitante', '!=', $request->input('idAccionante'))
            ->get();

        $validarDocumentoRepetido = DB::table('solicitantes')
            ->where('documentoSolicitante', '=', $request->input('documentoAccionanteNuevoEditar'))
            ->where('documentoSolicitante', '!=', '')
            ->where('idSolicitante', '!=', $request->input('idAccionante'))
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
                             ->where('idSolicitante', $request->input('idAccionante'))
                             ->first();  

            //Guarda el log
            $antes = json_encode($solicitante);
            $array = array(
                'documentoSolicitante' => $request->input('documentoAccionanteNuevoEditar'),
                'nombreSolicitante' => $request->input('nombreAccionanteEditar'),
                'correoSolicitante' => $request->input('correoAccionanteEditar'),
                'telefonoSolicitante' => $request->input('telefonoAccionanteEditar'),
                'direccionSolicitante' => $request->input('direccionAccionanteEditar'),
                'tiposidentificacion_idTipoIdentificacion' => $request->input('selecTipoDocumentoEditar'),
                'ciudades_idCiudad' => $request->input('selectCiudadAccionanteEditar'),
                'subterritorios_idSubTerritorio' => $request->input('selectBarrioAccionanteEditar'),
                'celularSolicitante' => $request->input('celularAccionanteEditar')
            );

            $despues = json_encode($array);
            $detalle = "Antes: ".$antes.".  Después: ".$despues;
            Util::guardarLogGed(92, $detalle, NULL);//92 Modifica solicitante desde LITIGO

            DB::table('solicitantes')
                    ->where('idSolicitante', $request->input('idAccionante'))
                    ->update($array);

            return 0; // Accionante modificado
        }
    }

    public function actionEditarAccionadoExt(Request $request)
    {
        $accionadoExt = DB::table('juriconvocadosexternos')
                    ->where('idConvocadoExterno', '=', $request->input('idAccionadoExt'))
                    ->get();

        return view('ajax_tutelas.ajaxEditarAccionadoExt')
                    ->with('accionadoExt', $accionadoExt);
    }

    public function actionNuevoAccionadoExt(Request $request)
    {
        return view('ajax_tutelas.ajaxNuevoAccionadoExt');
    }

    public function actionValidarGuardarAccionadoExt(Request $request)
    {
        $validarAccionadoExt = DB::table('juriconvocadosexternos')
            ->where('nombreConvocadoExterno', '=', $request->input('nombreAccionadoExterno'))
            ->get();

        if (count($validarAccionadoExt) > 0) 
        {
            return 0;// nombre repetido
        } 
        else
        {
            $accionadoExt   = new ConvocadoExterno;
            $accionadoExt->nombreConvocadoExterno       = $request->input('nombreAccionadoExterno');
            $accionadoExt->direccionConvocadoExterno    = $request->input('direccionAccionadoExterno');
            $accionadoExt->telefonoConvocadoExterno     = $request->input('telefonoAccionadoExterno');
            $accionadoExt->save();

            return $accionadoExt->idConvocadoExterno;
        }
    }

    public function actionValidarEditarAccionadoExt(Request $request)
    {
        $validarConvocadoExt = DB::table('juriconvocadosexternos')
            ->where('nombreConvocadoExterno', '=', $request->input('nombreAccionadoExternoEditar'))
            ->where('idConvocadoExterno', '!=', $request->input('idAccionadoExt'))
            ->get();

        if (count($validarConvocadoExt) > 0) 
        {
            return 0;// nombre repetido
        } 
        else
        {
            DB::table('juriconvocadosexternos')
                    ->where('idConvocadoExterno', $request->input('idAccionadoExt'))
                    ->update([
                            'nombreConvocadoExterno'       => $request->input('nombreAccionadoExternoEditar'),
                            'direccionConvocadoExterno'    => $request->input('direccionAccionadoExternoEditar'),
                            'telefonoConvocadoExterno'     => $request->input('telefonoAccionadoExternoEditar')]);

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

        $codigoProceso       = str_replace("-", "", $request->input('codigoProceso'));
        $vigenciaJuzgado     = substr($codigoProceso, 12, 4);
        $radicadoJuzgado     = substr($codigoProceso, 16, 5);
        $vectorAccionantes   = json_decode($request->input('jsonAccionantes'), true);
        $vectorAccionadosInt = json_decode($request->input('jsonAccionadosInt'), true);
        $vectorAccionadosExt = json_decode($request->input('jsonAccionadosExt'), true);

        $radicado = new Radicado;
        $radicado->vigenciaRadicado                          = date('Y');
        $radicado->codigoProceso                             = $codigoProceso;
        $radicado->radicadoJuzgado                           = $vigenciaJuzgado.$radicadoJuzgado;
        $radicado->juriestadosradicados_idEstadoRadicado     = 1; // pendiente
        $radicado->juritemas_idTema                          = $request->input('selectTema');
        $radicado->jurimedioscontrol_idMediosControl         = $request->input('selectMedioControl');
        $radicado->fechaNotificacion                         = $request->input('fechaNotifi');
        $radicado->descripcionHechos                         = $request->input('descripcionHechos');
        $radicado->jurijuzgados_idJuzgado                    = $request->input('idJuzgado');
        $radicado->juritipoprocesos_idTipoProceso            = $request->input('idTipoProceso');
        $radicado->asunto                                    = $request->input('asunto');
        $radicado->save();

        if($request->input('cantidadPlazo') == '')//no pusieron plazo
        {
            $tipoPlazo          = 1;
            $tipoTiempo         = 1;
            $cantidadPlazo      = 1;
            $cantidadPlazoSave  = 1;
        }
        else
        {
            $tipoPlazo         = $request->input('tipoPlazo');
            $tipoTiempo        = $request->input('tipoTiempo');
            $cantidadPlazo     = $request->input('cantidadPlazo');
            $cantidadPlazoSave = $request->input('cantidadPlazo');
        }


        if($tipoPlazo == 1)//días
        {
            $fechaRadicado          = $radicado->fechaRadicado;
            $fechaRadicado          = date_create($fechaRadicado);
            $fechaRadicado          = date_format($fechaRadicado, 'Y-m-d');
            for ($i=1; $i <= $cantidadPlazo ; $i++) 
            {
                $fechaVencimientoTutela = strtotime('+'.$i.' day', strtotime($fechaRadicado));
                $fechaVencimientoTutela = date('Y-m-d', $fechaVencimientoTutela);
                if($tipoTiempo == 1)//hábiles
                {
                    $fechasNoHabiles = DB::table('fechasnohabiles')
                                    ->where('fechaNoHabil', '=', $fechaVencimientoTutela)
                                    ->count();

                    if($fechasNoHabiles > 0)//si encuentra 
                    {
                        $cantidadPlazo++;
                    }
                }
            }
        }elseif ($tipoPlazo == 2) //horas
        {
            $fechaVencimientoTutela = null;
        }

        $plazo = new PlazoRadicado;
        $plazo->tipoPlazo                      = $tipoPlazo;
        $plazo->tipoTiempo                     = $tipoTiempo;
        $plazo->cantidadPlazo                  = $cantidadPlazoSave;
        $plazo->fechaVence                     = $fechaVencimientoTutela;
        $plazo->radicados_vigenciaRadicado     = date('Y');
        $plazo->radicados_idRadicado           = $radicado->idRadicado;
        $plazo->save();

        $demandantesPersonas = "";
        for($i=0; $i < count($vectorAccionantes); $i++)
        {
            $accionanteInvolucrado = new Involucrado;
            $accionanteInvolucrado->juritipoinvolucrados_idTipoInvolucrado      = 7;// accionante
            $accionanteInvolucrado->solicitantes_idSolicitante  = $vectorAccionantes[$i];
            $accionanteInvolucrado->juriradicados_vigenciaRadicado  = date('Y');
            $accionanteInvolucrado->juriradicados_idRadicado  = $radicado->idRadicado;
            $accionanteInvolucrado->save();

            $persona = DB::table('solicitantes')
                ->select('nombreSolicitante')
                ->where('idSolicitante', '=', $vectorAccionantes[$i])
                ->get();
            $demandantesPersonas .= $persona[0]->nombreSolicitante.",";
        }

        $demandadosPersonas = "";
        for($i=0; $i < count($vectorAccionadosInt); $i++)
        {
            $accionadoIntInvolucrado = new Involucrado;
            $accionadoIntInvolucrado->juritipoinvolucrados_idTipoInvolucrado      = 8;// accionado interno
            $accionadoIntInvolucrado->dependencias_idDependencia  = $vectorAccionadosInt[$i];
            $accionadoIntInvolucrado->juriradicados_vigenciaRadicado  = date('Y');
            $accionadoIntInvolucrado->juriradicados_idRadicado  = $radicado->idRadicado;
            $accionadoIntInvolucrado->save();

            $dependencia = DB::table('dependencias')
                ->select('nombreDependencia')
                ->where('idDependencia', '=', $vectorAccionadosInt[$i])
                ->get();
            $demandadosPersonas .= $dependencia[0]->nombreDependencia.",";
        }

        for($i=0; $i < count($vectorAccionadosExt); $i++)
        {
            $accionadoExterno = new Involucrado;
            $accionadoExterno->juritipoinvolucrados_idTipoInvolucrado     = 9;// accionado externo
            $accionadoExterno->juriconvocadosexternos_idConvocadoExterno  = $vectorAccionadosExt[$i];
            $accionadoExterno->juriradicados_vigenciaRadicado             = date('Y');
            $accionadoExterno->juriradicados_idRadicado                   = $radicado->idRadicado;
            $accionadoExterno->save();
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
                    ->join('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
                    ->join('jurimedioscontrol', 'juriradicados.jurimedioscontrol_idMediosControl', '=', 'jurimedioscontrol.idMediosControl')
                    ->join('jurijuzgados', 'juriradicados.jurijuzgados_idJuzgado', '=', 'jurijuzgados.idJuzgado')
                    ->join('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                    ->where('vigenciaRadicado', '=', $vigenciaRadicado)
                    ->where('idRadicado', '=', $idRadicado)
                    ->get();

        $demandantes = DB::table('juriinvolucrados')
                    ->join('solicitantes', 'juriinvolucrados.solicitantes_idSolicitante', '=', 'solicitantes.idSolicitante')
                    ->where('juritipoinvolucrados_idTipoInvolucrado', '=', 7)//accionante
                    ->where('juriradicados_vigenciaRadicado', '=', $vigenciaRadicado)
                    ->where('juriradicados_idRadicado', '=', $idRadicado)
                    ->get();

        $dependencias = DB::table('juriinvolucrados')
                    ->join('dependencias', 'juriinvolucrados.dependencias_idDependencia', '=', 'dependencias.idDependencia')
                    ->where('juritipoinvolucrados_idTipoInvolucrado', '=', 8)//accionado interno
                    ->where('juriradicados_vigenciaRadicado', '=', $vigenciaRadicado)
                    ->where('juriradicados_idRadicado', '=', $idRadicado)
                    ->get();

        $accionadosExt = DB::table('juriinvolucrados')
                    ->join('juriconvocadosexternos', 'juriinvolucrados.juriconvocadosexternos_idConvocadoExterno', '=', 'juriconvocadosexternos.idConvocadoExterno')
                    ->where('juritipoinvolucrados_idTipoInvolucrado', '=', 9)//accionados externos
                    ->where('juriradicados_vigenciaRadicado', '=', $vigenciaRadicado)
                    ->where('juriradicados_idRadicado', '=', $idRadicado)
                    ->get();

        $pdf = PDF::loadView('tutelas.pdfInformacion', array('vigenciaRadicado' => $vigenciaRadicado, 'idRadicado' => $idRadicado, 'informacionPdf' => $informacionPdf, 'demandantes' => $demandantes, 'dependencias' => $dependencias, 'accionadosExt' => $accionadosExt, 'entidad' => $entidad));
        return $pdf->stream('Radicado'.$vigenciaRadicado.'-'.$idRadicado.'.pdf');
    }

    public function actionTemas(Request $request)
    {
        $listaTemas = DB::table('juritemas')
            ->orderBy('idTema', 'asc')
            ->pluck('nombreTema', 'idTema'); 

        return view('ajax_tutelas.ajaxTemas')
            ->with('listaTemas', $listaTemas)
            ->with('idTemaSeleccionado', $request->input('idTemaSeleccionado'));
    }

    public function actionAgregarTema(Request $request)
    {
        return view('ajax_temas.ajaxAgregarTemas');
    }

    public function actionValidarGuardarTema(Request $request)
    {
        $tema = DB::table('juritemas')
                    ->where('nombreTema', '=', $request->input('nombreTema'))
                    ->get();

        if(count($tema) == 0)
        {
            $tema  = new Tema;
            $tema->nombreTema=$request->input('nombreTema');
            $tema->save(); 

            return $tema->idTema;// guarda el tema
        }
        else
        {
            // tema ya registrado
            return response()->json([
                'temaRegistrado'    => 0,
                'idTema'            => $tema[0]->idTema,
            ]);
        }
    }

    public function actionIniciarDropzoneRadica(Request $request)
    {
        return view("ajax_tutelas.ajaxDrozoneRadica");
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

    public function actionPlazoPersonalizado()
    {
        return view("ajax_tutelas.ajaxPlazoPersonalizado");
    }
}