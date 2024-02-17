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
use SQ10\Models\Involucrado;
use SQ10\Models\EstadoEtapa;
use SQ10\Models\Archivo;
use SQ10\Models\Abogado;
use SQ10\Models\LogsJuridica;
use SQ10\Models\Tema;
use SQ10\Models\Usuario;
use SQ10\Models\ConvocadoExterno;
use SQ10\Models\CuantiaRadicado;
use SQ10\helpers\Util as Util;
use Barryvdh\DomPDF\Facade as PDF;

class ProcesoJudicialController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function actionIndex($idTipoProceso)
    {
        $vigenciaActual = date("Y");

        $slv = Util::valorParametro(28);

        $listaActosAdministrativos = DB::table('juritiposactosadministrativos')
            ->orderBy('idTipoActo', 'asc')
            ->pluck('nombreTipoActo', 'idTipoActo');

        $acciones = DB::table('juriacciones')
                    ->where('juritipoprocesos_idTipoProcesos', '=', $idTipoProceso)
                    ->orderBy('idAccion', 'asc')
                    ->get();

        $listaJuzgados = DB::table('jurijuzgados')
            ->orderBy('idJuzgado', 'asc')
            ->pluck('nombreJuzgado', 'idJuzgado');

        return view('procesoJudicial/index')
            ->with('listaActosAdministrativos', $listaActosAdministrativos)
            ->with('acciones', $acciones)
            ->with('listaJuzgados', $listaJuzgados)
            ->with('idTipoProceso', $idTipoProceso)
            ->with('vigenciaActual', $vigenciaActual)
            ->with('slv', $slv);
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
                'vistaCodigoJuz'  => view('ajax_procesoJudicial.ajaxCodigoJuzgado')
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

    public function actionBusquedaDemandante(Request $request)
    {
        $q = "+".preg_replace( '/\s(\w+)/', ' +\\1', $request->input('criterioDemandante'));

        $solicitantes = Solicitante::whereRaw("MATCH(nombreSolicitante) AGAINST(? IN BOOLEAN MODE)", array($q))
            ->orWhere("documentoSolicitante", $request->input('criterioDemandante'))
            ->orderBy(DB::raw('documentoSolicitante+nombreSolicitante'), 'asc')
            ->get();

        return view("ajax_procesoJudicial.ajaxBusquedaDemandante")
            ->with("solicitantes", $solicitantes)
            ->with("criterioDemandante", $q);
    }

    public function actionBusquedaAbogadoDemandante(Request $request)
    {
        $q = "+".preg_replace( '/\s(\w+)/', ' +\\1', $request->input('criterioAbogado'));

        $abogados = Abogado::whereRaw("MATCH(nombreAbogado) AGAINST(? IN BOOLEAN MODE)", array($q))
            ->orWhere("documentoAbogado", $request->input('criterioAbogado'))
            ->orderBy(DB::raw('documentoAbogado+nombreAbogado'), 'asc')
            ->get();

        return view("ajax_procesoJudicial.ajaxBusquedaAbogadoDemandante")
            ->with("abogados", $abogados)
            ->with("criterioAbogado", $q);
    }

    public function actionSearchDependencia(Request $request)
    {
        $q = "+".preg_replace( '/\s(\w+)/', ' +\\1', $request->input('criterioDemandado'));

        $dependencias = Dependencia::whereRaw("MATCH(nombreDependencia) AGAINST(? IN BOOLEAN MODE)", array($q))
            ->orderBy(DB::raw('codigoDependencia+nombreDependencia'), 'asc')
            ->get();

        return view("ajax_procesoJudicial.ajaxBusquedaDependencia")
            ->with("dependencias", $dependencias)
            ->with("criterioDemandado", $q);
    }

    public function actionSeleccioneDemandante(Request $request)
    {
        $demandantes = json_decode($request->input('jsonDemandantes'), true);

        $demandante = DB::table('solicitantes')
                    ->leftJoin('tiposidentificacion', 'solicitantes.tiposidentificacion_idTipoIdentificacion', '=', 'tiposidentificacion.idTipoIdentificacion')
                    ->leftJoin('ciudades', 'solicitantes.ciudades_idCiudad', '=', 'ciudades.idCiudad')
                    ->leftJoin('departamentos', 'ciudades.departamentos_idDepartamento', '=', 'departamentos.idDepartamento')
                    ->whereIn('idSolicitante', $demandantes)
                    ->get();

        return view('ajax_procesoJudicial.ajaxDemandantesSeleccionados')
                    ->with('demandante', $demandante);
    }

    public function actionSeleccioneAbogado(Request $request)
    {
        $abogados = json_decode($request->input('jsonAbogados'), true);

        $abogado = DB::table('juriabogados')
                    ->leftJoin('tiposidentificacion', 'juriabogados.tiposidentificacion_idTipoIdentificacion', '=', 'tiposidentificacion.idTipoIdentificacion')
                    ->whereIn('idAbogado', $abogados)
                    ->get();

        return view('ajax_procesoJudicial.ajaxAbogadosSeleccionados')
                    ->with('abogado', $abogado);
    }

    public function actionSeleccioneDemandado(Request $request)
    {
        $demandados = json_decode($request->input('jsonDemandados'), true);

        $demandado = DB::table('dependencias')
                    ->whereIn('idDependencia', $demandados)
                    ->get();

        return view('ajax_procesoJudicial.ajaxDemandadosSeleccionados')
                    ->with('demandado', $demandado);
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

    public function actionNuevoAbogado(Request $request)
    {
        $listaTipoDocumentos = DB::table('tiposidentificacion')
            ->orderBy('idTipoIdentificacion', 'asc')
            ->pluck('nombreTipoIdentificacion', 'idTipoIdentificacion');

        return view('ajax_procesoJudicial.ajaxNuevoAbogado')
                    ->with('listaTipoDocumentos', $listaTipoDocumentos);
    }

    public function actionNuevoDemandando(Request $request)
    {
        $listaTipoDocumentos = DB::table('tiposidentificacion')
            ->orderBy('idTipoIdentificacion', 'asc')
            ->pluck('nombreTipoIdentificacion', 'idTipoIdentificacion');

        $listaDepartamentos = DB::table('departamentos')
                            ->get();

        return view('ajax_procesoJudicial.ajaxNuevoDemandado')
                    ->with('listaDepartamentos', $listaDepartamentos)
                    ->with('listaTipoDocumentos', $listaTipoDocumentos);
    }

    public function actionElegirBarrioDemandante(Request $request)
    {
        $listaBarrios = DB::table('territorios')
                        ->get();

        return view('ajax_procesoJudicial.ajaxBarrioDemandante')
            ->with('listaBarrios', $listaBarrios);
    }

    public function actionElegirBarrioDemandanteEditar(Request $request)
    {
        $demandante = DB::table('solicitantes')
                    ->where('idSolicitante', '=', $request->input('idDemandante'))
                    ->get();

        $listaBarrios = DB::table('territorios')
                        ->get();

        return view('ajax_procesoJudicial.ajaxBarrioDemandanteEditar')
            ->with('listaBarrios', $listaBarrios)
            ->with('demandante', $demandante);
    }

    public function actionElegirBarrioDemandado(Request $request)
    {
        $listaBarrios = DB::table('territorios')
                        ->get();

        return view('ajax_procesoJudicial.ajaxBarrioDemandado')
            ->with('listaBarrios', $listaBarrios);
    }

    public function actionElegirBarrioDemandadoEditar(Request $request)
    {
        $demandante = DB::table('solicitantes')
                    ->where('idSolicitante', '=', $request->input('idDemandante'))
                    ->get();

        $listaBarrios = DB::table('territorios')
                        ->get();

        return view('ajax_procesoJudicial.ajaxBarrioDemandadoEditar')
            ->with('listaBarrios', $listaBarrios)
            ->with('demandante', $demandante);
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

            return $solicitante->idSolicitante;
        }
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

    public function actionValidarGuardarDemandado(Request $request)
    {
        $validarCorreoNoRepetido = DB::table('solicitantes')
            ->where('correoSolicitante', '=', $request->input('correoDemandado'))
            ->where('correoSolicitante', '!=', '')
            ->get();

        $validarDocumentoRepetido = DB::table('solicitantes')
            ->where('documentoSolicitante', '=', $request->input('documentoDemandadoNuevo'))
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
            $solicitante->documentoSolicitante   = $request->input('documentoDemandadoNuevo');
            $solicitante->nombreSolicitante    = $request->input('nombreDemandado');
            $solicitante->correoSolicitante     = $request->input('correoDemandado');
            $solicitante->telefonoSolicitante   = $request->input('telefonoDemandado');
            $solicitante->direccionSolicitante    = $request->input('direccionDemandado');
            $solicitante->password    = Hash::make($request->input('documentoDemandadoNuevo'));
            $solicitante->creadoVentanilla   = 1; //0 Creado en ventanilla
            $solicitante->tiposidentificacion_idTipoIdentificacion = $request->input('selecTipoDocumentoDemandado');
            $solicitante->subterritorios_idSubTerritorio  = $request->input('selectBarrioDemandado');
            $solicitante->ciudades_idCiudad      = $request->input('selectCiudadDemandado');
            $solicitante->save();

            return $solicitante->idSolicitante;
        }
    }

    public function actionEditarDemandante(Request $request)
    {
        $demandante = DB::table('solicitantes')
                    ->where('idSolicitante', '=', $request->input('idDemandante'))
                    ->get();

        $listaTipoDocumentos = DB::table('tiposidentificacion')
            ->orderBy('idTipoIdentificacion', 'asc')
            ->pluck('nombreTipoIdentificacion', 'idTipoIdentificacion');

        $listaDepartamentos = DB::table('departamentos')
                            ->get();

        $listaBarrios = DB::table('territorios')
                        ->get();

        return view('ajax_procesoJudicial.ajaxEditarDemandante')
                    ->with('listaDepartamentos', $listaDepartamentos)
                    ->with('listaTipoDocumentos', $listaTipoDocumentos)
                    ->with('demandante', $demandante)
                    ->with('listaBarrios', $listaBarrios);
    }

    public function actionEditarAbogado(Request $request)
    {
        $abogado = DB::table('juriabogados')
                    ->where('idAbogado', '=', $request->input('idAbogado'))
                    ->get();

        $listaTipoDocumentos = DB::table('tiposidentificacion')
            ->orderBy('idTipoIdentificacion', 'asc')
            ->pluck('nombreTipoIdentificacion', 'idTipoIdentificacion');

        return view('ajax_procesoJudicial.ajaxEditarAbogado')
                    ->with('listaTipoDocumentos', $listaTipoDocumentos)
                    ->with('abogado', $abogado);
    }

    public function actionEditarDemandado(Request $request)
    {
        $demandado = DB::table('solicitantes')
                    ->where('idSolicitante', '=', $request->input('idDemandado'))
                    ->get();

        $listaTipoDocumentos = DB::table('tiposidentificacion')
            ->orderBy('idTipoIdentificacion', 'asc')
            ->pluck('nombreTipoIdentificacion', 'idTipoIdentificacion');

        $listaDepartamentos = DB::table('departamentos')
                            ->get();

        $listaBarrios = DB::table('territorios')
                        ->get();

        return view('ajax_procesoJudicial.ajaxEditarDemandado')
                    ->with('listaDepartamentos', $listaDepartamentos)
                    ->with('listaTipoDocumentos', $listaTipoDocumentos)
                    ->with('demandado', $demandado)
                    ->with('listaBarrios', $listaBarrios);
    }

    public function actionValidarEditarDemandante(Request $request)
    {
        $validarCorreoNoRepetido = DB::table('solicitantes')
            ->where('correoSolicitante', '=', $request->input('correoDemandanteEditar'))
            ->where('correoSolicitante', '!=', '')
            ->where('idSolicitante', '!=', $request->input('idDemandante'))
            ->get();

        $validarDocumentoRepetido = DB::table('solicitantes')
            ->where('documentoSolicitante', '=', $request->input('documentoDemandanteNuevoEditar'))
            ->where('documentoSolicitante', '!=', '')
            ->where('idSolicitante', '!=', $request->input('idDemandante'))
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
                             ->where('idSolicitante', $request->input('idDemandante'))
                             ->first();  

            //Guarda el log
            $antes = json_encode($solicitante);
            $array = array(
                'documentoSolicitante' => $request->input('documentoDemandanteNuevoEditar'),
                'nombreSolicitante' => $request->input('nombreDemandanteEditar'),
                'correoSolicitante' => $request->input('correoDemandanteEditar'),
                'telefonoSolicitante' => $request->input('telefonoDemandanteEditar'),
                'direccionSolicitante' => $request->input('direccionDemandanteEditar'),
                'tiposidentificacion_idTipoIdentificacion' => $request->input('selecTipoDocumentoEditar'),
                'ciudades_idCiudad' => $request->input('selectCiudadDemandanteEditar'),
                'subterritorios_idSubTerritorio' => $request->input('selectBarrioDemandanteEditar'),
                'celularSolicitante' => $request->input('celularDemandanteEditar')
            );

            $despues = json_encode($array);
            $detalle = "Antes: ".$antes.".  Después: ".$despues;
            Util::guardarLogGed(92, $detalle, NULL);//92 Modifica solicitante desde LITIGO


            DB::table('solicitantes')
                    ->where('idSolicitante', $request->input('idDemandante'))
                    ->update($array);
                    

                            $log = "Se modifico el solicitante ".$request->input('idDemandante')." por documento: ".$request->input('documentoDemandanteNuevoEditar').". nombreSolicitante: ".$request->input('nombreDemandanteEditar').". correoSolicitante: ".$request->input('correoDemandanteEditar').". telefonoSolicitante: ".$request->input('telefonoDemandanteEditar').". direccionSolicitante: ".$request->input('direccionDemandanteEditar').". tiposidentificacion_idTipoIdentificacion: ".$request->input('selecTipoDocumentoEditar').". ciudades_idCiudad:".$request->input('selectCiudadDemandanteEditar').". subterritorios_idSubTerritorio:".$request->input('selectBarrioDemandanteEditar')."celularSolicitante: ".$request->input('celularDemandanteEditar');

                            $logJuridica = new LogsJuridica;
                            $logJuridica->usuario = Session::get('idUsuario');
                            $logJuridica->modificacion = $log;                            
                            $logJuridica->save();

                

            return 0; // demandante modificado
        }
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

    public function actionValidarEditarDemandado(Request $request)
    {
        $validarCorreoNoRepetido = DB::table('solicitantes')
            ->where('correoSolicitante', '=', $request->input('correoDemandadoEditar'))
            ->where('correoSolicitante', '!=', '')
            ->where('idSolicitante', '!=', $request->input('idDemandado'))
            ->get();

        $validarDocumentoRepetido = DB::table('solicitantes')
            ->where('documentoSolicitante', '=', $request->input('documentoDemandadoNuevoEditar'))
            ->where('idSolicitante', '!=', $request->input('idDemandado'))
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
                             ->where('idSolicitante', $request->input('idDemandado'))
                             ->first();  

            //Guarda el log
            $antes = json_encode($solicitante);
            $array = array(
                'documentoSolicitante' => $request->input('documentoDemandadoNuevoEditar'),
                'nombreSolicitante' => $request->input('nombreDemandadoEditar'),
                'correoSolicitante' => $request->input('correoDemandadoEditar'),
                'telefonoSolicitante' => $request->input('telefonoDemandadoEditar'),
                'direccionSolicitante' => $request->input('direccionDemandadoEditar'),
                'tiposidentificacion_idTipoIdentificacion' => $request->input('selecTipoDocumentoDemandadoEditar'),
                'ciudades_idCiudad' => $request->input('selectCiudadDemandadoEditar'),
                'subterritorios_idSubTerritorio' => $request->input('selectBarrioDemandadoEditar'),
                'celularSolicitante' => $request->input('celularDemandadoEditar')
            );

            $despues = json_encode($array);
            $detalle = "Antes: ".$antes.".  Después: ".$despues;
            Util::guardarLogGed(92, $detalle, NULL);//92 Modifica solicitante desde LITIGO

            DB::table('solicitantes')
                    ->where('idSolicitante', $request->input('idDemandado'))
                    ->update($array);

            return 0; // demandado modificado
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

        $codigoProceso      =  str_replace("-", "", $request->input('codigoProceso'));
        $vigenciaJuzgado    = substr($codigoProceso, 12, 4);
        $radicadoJuzgado    = substr($codigoProceso, 16, 5);
        $vectorDemandantes  = json_decode($request->input('jsonDemandantes'), true);
        $vectorDemandados   = json_decode($request->input('jsonDemandados'), true);
        $vectorAbogados     = json_decode($request->input('jsonAbogados'), true);
        $vectorEntidadesExt = json_decode($request->input('jsonEntidadesExt'), true);

        //Cuantía
        $vectorSelectUnidadMonetaria = json_decode($request->input('jsonSelectUnidadMonetaria'), true);
        $vectorValor                 = json_decode($request->input('jsonValor'), true);
        $vectorValorPesos            = json_decode($request->input('jsonValorPesos'), true);

        $radicado = new Radicado;
        $radicado->vigenciaRadicado                          = date('Y');
        $radicado->codigoProceso                             = $codigoProceso;
        $radicado->radicadoJuzgado                           = $vigenciaJuzgado.$radicadoJuzgado;
        $radicado->juriestadosradicados_idEstadoRadicado     = 1; // pendiente
        $radicado->juriacciones_idAccion                     = $request->input('sentidoEntidad');
        $radicado->juritemas_idTema                          = $request->input('selectTema');
        $radicado->jurimedioscontrol_idMediosControl         = $request->input('selectMedioControl');
        $radicado->fechaNotificacion                         = $request->input('fechaNotifi');
        $radicado->descripcionHechos                         = $request->input('descripcionHechos');
        $radicado->jurijuzgados_idJuzgado                    = $request->input('idJuzgado');
        $radicado->juritipoprocesos_idTipoProceso            = $request->input('idTipoProceso');
        $radicado->juriradicados_vigenciaRadicado            = $request->input('vigenciaProceso');
        $radicado->juriradicados_idRadicado                  = $request->input('selectRadicado');
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

        $demandantesPersonas = "";
        for($i=0; $i < count($vectorDemandantes); $i++)
        {
            $demandanteInvolucrado = new Involucrado;
            $demandanteInvolucrado->juritipoinvolucrados_idTipoInvolucrado      = 1;// Demandante
            $demandanteInvolucrado->solicitantes_idSolicitante  = $vectorDemandantes[$i];
            $demandanteInvolucrado->juriradicados_vigenciaRadicado  = date('Y');
            $demandanteInvolucrado->juriradicados_idRadicado  = $radicado->idRadicado;
            $demandanteInvolucrado->save();

            $persona = DB::table('solicitantes')
                ->select('nombreSolicitante')
                ->where('idSolicitante', '=', $vectorDemandantes[$i])
                ->get();
            $demandantesPersonas .= $persona[0]->nombreSolicitante.",";
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

        $demandadosPersonas = "";
        for($i=0; $i < count($vectorDemandados); $i++)
        {
            $demandadoInvolucrado = new Involucrado;
            $demandadoInvolucrado->juritipoinvolucrados_idTipoInvolucrado      = 3;// Demandado
            $demandadoInvolucrado->dependencias_idDependencia  = $vectorDemandados[$i];
            $demandadoInvolucrado->juriradicados_vigenciaRadicado  = date('Y');
            $demandadoInvolucrado->juriradicados_idRadicado  = $radicado->idRadicado;
            $demandadoInvolucrado->save();

            $dependencia = DB::table('dependencias')
                ->select('nombreDependencia')
                ->where('idDependencia', '=', $vectorDemandados[$i])
                ->get();
            $demandadosPersonas .= $dependencia[0]->nombreDependencia.",";
        }

        for($i=0; $i < count($vectorEntidadesExt); $i++)
        {
            $convocadoExtInvolucrado = new Involucrado;
            $convocadoExtInvolucrado->juritipoinvolucrados_idTipoInvolucrado      = 6;// Convocado Externo
            $convocadoExtInvolucrado->juriconvocadosexternos_idConvocadoExterno  = $vectorEntidadesExt[$i];
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
                    ->join('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
                    ->join('jurimedioscontrol', 'juriradicados.jurimedioscontrol_idMediosControl', '=', 'jurimedioscontrol.idMediosControl')
                    ->join('jurijuzgados', 'juriradicados.jurijuzgados_idJuzgado', '=', 'jurijuzgados.idJuzgado')
                    ->join('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                    ->where('vigenciaRadicado', '=', $vigenciaRadicado)
                    ->where('idRadicado', '=', $idRadicado)
                    ->get();

        $cuantias = DB::table('juricuantiaradicado')
                    ->where('juriradicados_vigenciaRadicado', '=', $vigenciaRadicado)
                    ->where('juriradicados_idRadicado', '=', $idRadicado)
                    ->get();

        $demandantes = DB::table('juriinvolucrados')
                    ->join('solicitantes', 'juriinvolucrados.solicitantes_idSolicitante', '=', 'solicitantes.idSolicitante')
                    ->where('juritipoinvolucrados_idTipoInvolucrado', '=', 1)//demandante
                    ->where('juriradicados_vigenciaRadicado', '=', $vigenciaRadicado)
                    ->where('juriradicados_idRadicado', '=', $idRadicado)
                    ->get();

        $abogados = DB::table('juriinvolucrados')
                    ->join('juriabogados', 'juriinvolucrados.juriabogados_idAbogado', '=', 'juriabogados.idAbogado')
                    ->where('juritipoinvolucrados_idTipoInvolucrado', '=', 2)//abogado demandante
                    ->where('juriradicados_vigenciaRadicado', '=', $vigenciaRadicado)
                    ->where('juriradicados_idRadicado', '=', $idRadicado)
                    ->get();

        $dependencias = DB::table('juriinvolucrados')
                    ->join('dependencias', 'juriinvolucrados.dependencias_idDependencia', '=', 'dependencias.idDependencia')
                    ->where('juritipoinvolucrados_idTipoInvolucrado', '=', 3)//dependencia demandado
                    ->where('juriradicados_vigenciaRadicado', '=', $vigenciaRadicado)
                    ->where('juriradicados_idRadicado', '=', $idRadicado)
                    ->get();

        $pdf = PDF::loadView('procesoJudicial.pdfInformacion', array('vigenciaRadicado' => $vigenciaRadicado, 'idRadicado' => $idRadicado, 'informacionPdf' => $informacionPdf, 'cuantias' => $cuantias, 'demandantes' => $demandantes, 'dependencias' => $dependencias, 'abogados' => $abogados, 'entidad' => $entidad));
        return $pdf->stream('Radicado'.$vigenciaRadicado.'-'.$idRadicado.'.pdf');
    }

    public function actionTemas(Request $request)
    {
        $listaTemas = DB::table('juritemas')
            ->orderBy('nombreTema', 'asc')
            ->pluck('nombreTema', 'idTema'); 

        return view('ajax_procesoJudicial.ajaxTemas')
            ->with('listaTemas', $listaTemas)
            ->with('idTemaSeleccionado', $request->input('idTemaSeleccionado'));
    }

    public function actionMediosControl(Request $request)
    {
        $listaMediosControl = DB::table('jurimedioscontrol')
            ->orderBy('nombreMedioControl', 'asc')
            ->pluck('nombreMedioControl', 'idMediosControl');

        return view('ajax_procesoJudicial.ajaxMediosControl')
            ->with('listaMediosControl', $listaMediosControl)
            ->with('idMedioSeleccionado', $request->input('idMedioSeleccionado'));
    }

    public function actionAgregarTemas(Request $request)
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

            // guarda el tema
            return response()->json([
                'temaRegistrado'    => 1,
                'nombreTema'        => $tema->nombreTema,
                'idTema'            => $tema->idTema,
            ]);
        }
        else
        {
            // tema ya registrado
            return response()->json([
                'temaRegistrado'    => 0,
                'nombreTema'        => $tema[0]->nombreTema,
                'idTema'            => $tema[0]->idTema,
            ]);
        }
    }

    public function actionCambiarVigenciaProceso(Request $request)
    {
        $radicadosConcilia = DB::table('juriradicados')
                    ->where('vigenciaRadicado', '=', $request->input('vigencia'))
                    ->where('juritipoprocesos_idTipoProceso', '=', 2)// conciliaciones
                    ->orderBy('idRadicado', 'asc')
                    ->pluck('idRadicado', 'idRadicado');
        
        return view('ajax_procesoJudicial.ajaxProcesosConcilia')
            ->with('radicadosConcilia', $radicadosConcilia);
    }

    public function actionIniciarDropzoneRadica(Request $request)
    {
        return view("ajax_procesoJudicial.ajaxDrozoneRadica");
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

    public function actionNuevaEntidadExt(Request $request)
    {
        return view('ajax_procesoJudicial.ajaxNuevaEntidadExt');
    }

    public function actionValidarGuardarEntidadExt(Request $request)
    {
        $validarEntidadExt = DB::table('juriconvocadosexternos')
            ->where('nombreConvocadoExterno', '=', $request->input('nombreEntidadExterno'))
            ->get();

        if (count($validarEntidadExt) > 0) 
        {
            return 0;// nombre repetido
        } 
        else
        {
            $entidadExt   = new ConvocadoExterno;
            $entidadExt->nombreConvocadoExterno       = $request->input('nombreEntidadExterno');
            $entidadExt->direccionConvocadoExterno    = $request->input('direccionEntidadExterno');
            $entidadExt->telefonoConvocadoExterno     = $request->input('telefonoEntidadExterno');
            $entidadExt->save();

            return $entidadExt->idConvocadoExterno;
        }
    }

    public function actionSeleccioneEntidadExt(Request $request)
    {
        $entidadesExt = json_decode($request->input('jsonEntidadesExt'), true);

        $entidadExt = DB::table('juriconvocadosexternos')
                    ->whereIn('idConvocadoExterno', $entidadesExt)
                    ->get();

        return view('ajax_procesoJudicial.ajaxEntidadesExtSeleccionados')
                    ->with('entidadExt', $entidadExt);
    }

    public function actionBusquedaEntidadExt(Request $request)
    {
        $q = "+".preg_replace( '/\s(\w+)/', ' +\\1', $request->input('criterioEntidadExt'));

        $entidadesExt = ConvocadoExterno::whereRaw("MATCH(nombreConvocadoExterno) AGAINST(? IN BOOLEAN MODE)", array($q))
            ->orderBy(DB::raw('direccionConvocadoExterno+nombreConvocadoExterno'), 'asc')
            ->get();

        return view("ajax_procesoJudicial.ajaxBusquedaEntidadExt")
            ->with("entidadesExt", $entidadesExt)
            ->with("criterioEntidadExt", $q);
    }

    public function actionEditarEntidadExt(Request $request)
    {
        $entidadExt = DB::table('juriconvocadosexternos')
                    ->where('idConvocadoExterno', '=', $request->input('idEntidadExt'))
                    ->get();

        return view('ajax_procesoJudicial.ajaxEditarEntidadExt')
                    ->with('entidadExt', $entidadExt);
    }

    public function actionValidarEditarEntidadExt(Request $request)
    {
        $validarEntidadExt = DB::table('juriconvocadosexternos')
            ->where('nombreConvocadoExterno', '=', $request->input('nombreEntidadExternoEditar'))
            ->where('idConvocadoExterno', '!=', $request->input('idEntidadExt'))
            ->get();

        if (count($validarEntidadExt) > 0) 
        {
            return 0;// nombre repetido
        } 
        else
        {
            DB::table('juriconvocadosexternos')
                    ->where('idConvocadoExterno', $request->input('idEntidadExt'))
                    ->update([
                            'nombreConvocadoExterno'       => $request->input('nombreEntidadExternoEditar'),
                            'direccionConvocadoExterno'    => $request->input('direccionEntidadExternoEditar'),
                            'telefonoConvocadoExterno'     => $request->input('telefonoEntidadExternoEditar')]);

            return 1;
        }
    }

    public function actionDatosAnterioresConci(Request $request)
    {
        $proceso    = DB::table('juriradicados')
                        ->leftJoin('juritemas', 'juriradicados.juritemas_idTema', 'juritemas.idTema')
                        ->where('vigenciaRadicado', '=', $request->input('vigenciaProceso'))
                        ->where('idRadicado', '=', $request->input('idRadicado'))
                        ->get();

        $demandantes = DB::table('juriinvolucrados')
                        ->where('juriradicados_vigenciaRadicado', '=', $request->input('vigenciaProceso'))
                        ->where('juriradicados_idRadicado', '=', $request->input('idRadicado'))
                        ->where('juritipoinvolucrados_idTipoInvolucrado', '=', 4)
                        ->get();


        $demandados = DB::table('juriinvolucrados')
                        ->where('juriradicados_vigenciaRadicado', '=', $request->input('vigenciaProceso'))
                        ->where('juriradicados_idRadicado', '=', $request->input('idRadicado'))
                        ->where('juritipoinvolucrados_idTipoInvolucrado', '=', 5)
                        ->get();

        $entidadesExt = DB::table('juriinvolucrados')
                        ->where('juriradicados_vigenciaRadicado', '=', $request->input('vigenciaProceso'))
                        ->where('juriradicados_idRadicado', '=', $request->input('idRadicado'))
                        ->where('juritipoinvolucrados_idTipoInvolucrado', '=', 6)
                        ->get();

        $abogadosExt = DB::table('juriinvolucrados')
                        ->where('juriradicados_vigenciaRadicado', '=', $request->input('vigenciaProceso'))
                        ->where('juriradicados_idRadicado', '=', $request->input('idRadicado'))
                        ->where('juritipoinvolucrados_idTipoInvolucrado', '=', 2)
                        ->get();

        return response()->json(['demandantes'  => $demandantes,
                                 'demandados'   => $demandados,
                                 'entidadesExt' => $entidadesExt,
                                 'abogadosExt'  => $abogadosExt,
                                 'proceso'      => $proceso]);
    }
}