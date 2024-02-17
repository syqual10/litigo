<?php
namespace SQ10\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Session;
use SQ10\Models\Entidad;
use SQ10\Models\Oficio;
use SQ10\Models\Ciudad;
use SQ10\helpers\Util as Util;

class OficioController extends Controller
{
  	public function __construct()
    {
        $this->middleware('auth');
    }

    public function actionIndexOficio()
    {
        return view('oficio/index');
    }

    public function actionTablaOficios(Request $request)
    {
        $idUsuario = Session::get('idUsuario');

        $oficios = DB::table('juriconsecutivosoficios')
                ->join('usuarios', 'juriconsecutivosoficios.usuarios_idUsuario', '=', 'usuarios.idUsuario')
                ->join('ciudades', 'juriconsecutivosoficios.ciudades_idCiudad', '=', 'ciudades.idCiudad')
                //->where('usuarios_idUsuario', '=', $idUsuario)
                ->get();

        return view('ajax_oficios.ajaxTablaOficios')
                    ->with('oficios', $oficios);  
    }

    public function actionAgregarOficio(Request $request)
    {
        $idUsuario = Session::get('idUsuario');
        $idResponsable = Util::idResponsable($idUsuario);
        $entidad = Entidad::find(1);
        $arco    = $entidad->ws1;

        $listaDeptos = DB::table('departamentos')
                                ->get();

        $listaRadicados = DB::table('juriestadosetapas')
            ->where('juriresponsables_idResponsable', '=', $idResponsable)
            ->where('juriradicados_vigenciaRadicado', '=', date("Y"))
            ->orderBy('juriradicados_idRadicado', 'asc')
            ->pluck('juriradicados_idRadicado', 'juriradicados_idRadicado');

        return view('ajax_oficios.ajaxAgregarOficio')
                    ->with('listaDeptos', $listaDeptos)
                    ->with('listaRadicados', $listaRadicados)
                    ->with('vigenciaActual', date("Y"))
                    ->with('arco', $arco);   
    }

    public function actionVigenciaRadicados(Request $request)
    {
        $idUsuario = Session::get('idUsuario');
        $idResponsable = Util::idResponsable($idUsuario);

        $listaRadicados = DB::table('juriestadosetapas')
            ->where('juriresponsables_idResponsable', '=', $idResponsable)
            ->where('juriradicados_vigenciaRadicado', '=', $request->input('vigencia'))
            ->orderBy('juriradicados_idRadicado', 'asc')
            ->pluck('juriradicados_idRadicado', 'juriradicados_idRadicado');

        return view('ajax_oficios.ajaxRadicadosVigencia')
                    ->with('listaRadicados', $listaRadicados);   
    }

    public function actionInvolucradosRadicado(Request $request)
    {
        $demandante = DB::table('juriinvolucrados')
                            ->join('solicitantes', 'juriinvolucrados.solicitantes_idSolicitante', '=', 'solicitantes.idSolicitante')
                            ->where('juritipoinvolucrados_idTipoInvolucrado', '=', 1)
                            ->where('juriinvolucrados.juriradicados_idRadicado', $request->input('idRadicado'))
                            ->where('juriinvolucrados.juriradicados_vigenciaRadicado', $request->input('vigenciaRadicado'))
                            ->get();

        $abogadoDemandante = DB::table('juriinvolucrados')
                            ->join('juriabogados', 'juriinvolucrados.juriabogados_idAbogado', '=', 'juriabogados.idAbogado')
                            ->where('juritipoinvolucrados_idTipoInvolucrado', '=', 2)
                            ->where('juriinvolucrados.juriradicados_idRadicado', $request->input('idRadicado'))
                            ->where('juriinvolucrados.juriradicados_vigenciaRadicado', $request->input('vigenciaRadicado'))
                            ->get();

        $demandado = DB::table('juriinvolucrados')
                            ->join('dependencias', 'juriinvolucrados.dependencias_idDependencia', '=', 'dependencias.idDependencia')
                            ->where('juritipoinvolucrados_idTipoInvolucrado', '=', 3)
                            ->where('juriinvolucrados.juriradicados_idRadicado', $request->input('idRadicado'))
                            ->where('juriinvolucrados.juriradicados_vigenciaRadicado', $request->input('vigenciaRadicado'))
                            ->get();

        $convocante = DB::table('juriinvolucrados')
                            ->join('solicitantes', 'juriinvolucrados.solicitantes_idSolicitante', '=', 'solicitantes.idSolicitante')
                            ->where('juritipoinvolucrados_idTipoInvolucrado', '=', 4)
                            ->where('juriinvolucrados.juriradicados_idRadicado', $request->input('idRadicado'))
                            ->where('juriinvolucrados.juriradicados_vigenciaRadicado', $request->input('vigenciaRadicado'))
                            ->get();

        $convocadoInterno = DB::table('juriinvolucrados')
                            ->join('dependencias', 'juriinvolucrados.dependencias_idDependencia', '=', 'dependencias.idDependencia')
                            ->where('juritipoinvolucrados_idTipoInvolucrado', '=', 5)
                            ->where('juriinvolucrados.juriradicados_idRadicado', $request->input('idRadicado'))
                            ->where('juriinvolucrados.juriradicados_vigenciaRadicado', $request->input('vigenciaRadicado'))
                            ->get();

        $convocadoExterno = DB::table('juriinvolucrados')
                            ->join('juriconvocadosexternos', 'juriinvolucrados.juriconvocadosexternos_idConvocadoExterno', '=', 'juriconvocadosexternos.idConvocadoExterno')
                            ->where('juritipoinvolucrados_idTipoInvolucrado', '=', 6)
                            ->where('juriinvolucrados.juriradicados_idRadicado', $request->input('idRadicado'))
                            ->where('juriinvolucrados.juriradicados_vigenciaRadicado', $request->input('vigenciaRadicado'))
                            ->get();

        $accionante = DB::table('juriinvolucrados')
                            ->join('solicitantes', 'juriinvolucrados.solicitantes_idSolicitante', '=', 'solicitantes.idSolicitante')
                            ->where('juritipoinvolucrados_idTipoInvolucrado', '=', 7)
                            ->where('juriinvolucrados.juriradicados_idRadicado', $request->input('idRadicado'))
                            ->where('juriinvolucrados.juriradicados_vigenciaRadicado', $request->input('vigenciaRadicado'))
                            ->get();

        $accionadoInterno = DB::table('juriinvolucrados')
                            ->join('dependencias', 'juriinvolucrados.dependencias_idDependencia', '=', 'dependencias.idDependencia')
                            ->where('juritipoinvolucrados_idTipoInvolucrado', '=', 8)
                            ->where('juriinvolucrados.juriradicados_idRadicado', $request->input('idRadicado'))
                            ->where('juriinvolucrados.juriradicados_vigenciaRadicado', $request->input('vigenciaRadicado'))
                            ->get();

        $accionadoExterno = DB::table('juriinvolucrados')
                            ->join('juriconvocadosexternos', 'juriinvolucrados.juriconvocadosexternos_idConvocadoExterno', '=', 'juriconvocadosexternos.idConvocadoExterno')
                            ->where('juritipoinvolucrados_idTipoInvolucrado', '=', 9)
                            ->where('juriinvolucrados.juriradicados_idRadicado', $request->input('idRadicado'))
                            ->where('juriinvolucrados.juriradicados_vigenciaRadicado', $request->input('vigenciaRadicado'))
                            ->get();

        return view('ajax_oficios.ajaxInvolucradosOficio')
                    ->with('demandante', $demandante)
                    ->with('abogadoDemandante', $abogadoDemandante)
                    ->with('demandado', $demandado)
                    ->with('convocante', $convocante)
                    ->with('convocadoInterno', $convocadoInterno)
                    ->with('convocadoExterno', $convocadoExterno)
                    ->with('accionante', $accionante)
                    ->with('accionadoInterno', $accionadoInterno)
                    ->with('accionadoExterno', $accionadoExterno);   
    }

    public function actionGenerarOficio($vector)
    {
        $idUsuario = Session::get('idUsuario');

        //Decodifica el vector json
        $datos     = json_decode($vector, true);
        $fechaHoy  =  ucfirst(utf8_encode(strftime("%A %d de %B de %Y", strtotime(date("Y-m-d")))));

        $usuario = DB::table('juriresponsables')
                        ->select('nombresUsuario', 'nombreCargo', 'documentoUsuario')
                        ->join('usuarios', 'juriresponsables.usuarios_idUsuario', '=', 'usuarios.idUsuario')
                        ->leftJoin('cargos', 'usuarios.cargos_idcargo', '=', 'cargos.idCargo')
                        ->where('usuarios_idUsuario', '=', $idUsuario)
                        ->get();
        //------------------------------------------------------      

        $templateWord = new \PhpOffice\PhpWord\TemplateProcessor('juriArch/Oficio General.docx');

        //---- GUARDA EL CONSECUTIVO DE LA PLANTILLA-->
        $oficio                                        = new Oficio;
        $oficio->vigenciaOficio                        = date('Y');
        $oficio->usuarios_idUsuario                    = $idUsuario;
        $oficio->ciudades_idCiudad                     = $datos['ciudad'];
        $oficio->siglasOficio                          = "SJ";
        $oficio->ipUsuario                             = Util::getIp();
        $oficio->asuntoOficio                          = $datos['asunto'];
        $oficio->nombrePersona                         = strtoupper($datos['destinatario']);
        $oficio->direccionPersona                      = $datos['direccion'];
        $oficio->save();
        $numeroOficioCompleto = "SJ"." ".$oficio->idConsecutivoOficio."-".date('Y');

        //Si se seleccionó radicar en el arco, consume el webservice:
        if ($datos['arco'] == 1) 
        {
            $entidad = Entidad::find(1);
            // Llamado POST a la api del sistema arco
            $url = $entidad->ws1;

            $data = array('numeroOficio'     => $numeroOficioCompleto,
                          'fechaOficio'      => date("Y-m-d"),
                          'destinatario'     => strtoupper($datos['destinatario']),
                          'direccion'        => $datos['direccion'],
                          'ciudad'           => $datos['ciudad'],
                          'vereda'           => 91,
                          'idDestino'        => 1,
                          'documentoUsuario' => $usuario[0]->documentoUsuario);

            $options = array('http' => array('header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                                             'method'  => 'POST',
                                             'content' => http_build_query($data)));

            $context = stream_context_create($options);
            $result  = json_decode(file_get_contents($url, false, $context));

            //Si no hubo error en la respuesta del web service
            if ($result->error == false) 
            {
                $arco = "ARCO ".$result->radicado;
            } 
            else 
            {
                $arco = "error WS arco";
            }
            //----------------------------------------------------------------------------

            DB::table('juriconsecutivosoficios')
                ->where('idConsecutivoOficio', $oficio->idConsecutivoOficio)
                ->where('vigenciaOficio', date('Y'))
                ->update([
                    'arco' => $result->radicado]);
        } 
        else 
        {
            $arco = "";
        }

        // --- Asignamos valores a la plantilla
        $ciudad = Ciudad::find($datos['ciudad']);       
        $templateWord->setValue('nombrePersona', strtoupper($datos['destinatario']));
        $templateWord->setValue('direccionPersona', $datos['direccion']);
        $templateWord->setValue('ciudad', $ciudad->nombreCiudad);      
        $templateWord->setValue('arco', $arco);
        $templateWord->setValue('nombreUsuario', $usuario[0]->nombresUsuario);
        $templateWord->setValue('cargoUsuario', $usuario[0]->nombreCargo);
        $templateWord->setValue('numeroOficioCompleto', $numeroOficioCompleto);
        $templateWord->setValue('asunto', $datos['asunto']);
        $templateWord->setValue('fechaHoy', $fechaHoy);

        // --- Se guarda el documento
        $templateWord->saveAs("Oficio".' '.$numeroOficioCompleto.'.docx');

        header("Content-Disposition: attachment; filename="."Oficio"." ".$numeroOficioCompleto.".docx; charset=iso-8859-1");
        echo file_get_contents("Oficio".' '.$numeroOficioCompleto. '.docx');
        //Elimina el archivo temporal
        Unlink("Oficio".' '.$numeroOficioCompleto.'.docx');
    }

    public function actionRadicarArco(Request $request)
    {
        $idUsuario = Session::get('idUsuario');

        $usuario = DB::table('juriresponsables')
                        ->select('nombresUsuario', 'nombreCargo', 'documentoUsuario')
                        ->join('usuarios', 'juriresponsables.usuarios_idUsuario', '=', 'usuarios.idUsuario')
                        ->leftJoin('cargos', 'usuarios.cargos_idcargo', '=', 'cargos.idCargo')
                        ->where('usuarios_idUsuario', '=', $idUsuario)
                        ->get();

        $entidad = Entidad::find(1);
        // Llamado POST a la api del sistema arco
        $url = $entidad->ws1;

        $numeroOficioCompleto = "SJ"." ".$request->input('idConsecutivoOficio')."-".$request->input('vigenciaOficio');

        $data = array('numeroOficio'     => $numeroOficioCompleto,
                      'fechaOficio'      => date("Y-m-d"),
                      'destinatario'     => strtoupper($request->input('nombrePersona')),
                      'direccion'        => $request->input('direccionPersona'),
                      'ciudad'           => $request->input('ciudades_idCiudad'),
                      'vereda'           => 91,
                      'idDestino'        => 1,
                      'documentoUsuario' => $usuario[0]->documentoUsuario);

        $options = array('http' => array('header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                                         'method'  => 'POST',
                                         'content' => http_build_query($data)));

        $context = stream_context_create($options);
        $result  = json_decode(file_get_contents($url, false, $context));

        //Si no hubo error en la respuesta del web service
        if ($result->error == false) 
        {
            $arco = "ARCO ".$result->radicado;
        } 
        else 
        {
            $arco = "error WS arco";
        }
        //----------------------------------------------------------------------------

        DB::table('juriconsecutivosoficios')
            ->where('idConsecutivoOficio', $request->input('idConsecutivoOficio'))
            ->where('vigenciaOficio', $request->input('vigenciaOficio'))
            ->update([
                'arco' => $result->radicado]);

        return $arco;
    }

    public function actionImplicadoOficio(Request $request)
    {
        $listaDeptos = DB::table('departamentos')
                        ->get();

        return view('ajax_oficios.ajaxCiudadOficio')
                    ->with('idCiudad', $request->input('ciudad'))
                    ->with('listaDeptos', $listaDeptos);   
    }
}