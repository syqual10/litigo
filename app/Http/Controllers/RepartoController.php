<?php
namespace SQ10\Http\Controllers;

use DB;
use Excel;
use Illuminate\Http\Request;
use Session;
use SQ10\Models\Usuario;
use SQ10\Models\EstadoEtapa;
use SQ10\helpers\Util as Util;

class RepartoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function actionIndexReparto($idEstadoEtapa)
    {
        $proceso = DB::table('juriradicados')
                ->join('juriestadosetapas', function ($join) {
                    $join->on('juriradicados.vigenciaRadicado', '=', 'juriestadosetapas.juriradicados_vigenciaRadicado')
                    ->on('juriradicados.idRadicado', '=', 'juriestadosetapas.juriradicados_idRadicado');
                })
                ->leftJoin('jurijuzgados', 'juriradicados.jurijuzgados_idJuzgado', '=', 'jurijuzgados.idJuzgado')
                ->leftJoin('jurimedioscontrol', 'juriradicados.jurimedioscontrol_idMediosControl', '=', 'jurimedioscontrol.idMediosControl')
                ->where('idEstadoEtapa', '=', $idEstadoEtapa)
                ->get();

        if(count($proceso) > 0)
        {
            $idCiudad = substr($proceso[0]->codigoProceso, 0, 5);
        }
        else
        {
            $idCiudad = 0;
        }
        
        $ciudad = DB::table('juriciudades')
                    ->join('juridepartamentos', 'juriciudades.departamentos_idDepartamento', 'juridepartamentos.idDepartamento')
                    ->where('idCiudad', '=', $idCiudad)
                    ->get();

        $abogados = DB::table('juriresponsables')
                    ->join('usuarios', 'juriresponsables.usuarios_idUsuario', 'usuarios.idUsuario')
                    ->where('juriperfiles_idPerfil', '=', 3)// 3 de abogados
                    ->where('estadoResponsable', '=', 1)
                    ->get();

        return view('reparto/index')
                ->with('proceso', $proceso)
                ->with('ciudad', $ciudad)
                ->with('abogados', $abogados);
    }

    public function actionValidarGuardarReparto(Request $request)
    {
        $asignados = json_decode($request->input('jsonReparto'), true);

        $asignado = DB::table('juriresponsables')
                    ->join('usuarios', 'juriresponsables.usuarios_idUsuario', '=', 'usuarios.idUsuario')
                    ->leftJoin('dependencias', 'usuarios.dependencias_idDependencia', '=', 'dependencias.idDependencia')
                    ->whereIn('idResponsable', $asignados)
                    ->get();

        return view('ajax_reparto.ajaxAsignadosReparto')
                    ->with('asignado', $asignado)
                    ->with('totalAsignados', count($asignados));
    }

    public function actionValidarAsignarReparto(Request $request)
    {
        $idUsuario = Session::get('idUsuario');
        $idResponsableActual = Util::idResponsable($idUsuario);
        $vectorAsignados   = json_decode($request->input('jsonAsignados'), true);

        $estadoActual = EstadoEtapa::find($request->input('idEstadoEtapa'));
        $comentarioReparto = "Se realiza el reparto correspondiente a :";

        DB::table('juriestadosetapas')
                ->where('idEstadoEtapa', $request->input('idEstadoEtapa'))
                ->update([
                    'fechaFinalEstado' => date("Y-m-d H:i:s"),
                    'comentarioEstadoEtapa' => $comentarioReparto,
                    'juritipoestadosetapas_idTipoEstadoEtapa' => 2]);//gestionado

        DB::table('juriestadosetapas')
            ->where('juriradicados_vigenciaRadicado', '=', $estadoActual->juriradicados_vigenciaRadicado)
            ->where('juriradicados_idRadicado', '=', $estadoActual->juriradicados_idRadicado)
            ->where('juritipoestadosetapas_idTipoEstadoEtapa', '=', 1)// los otros que están pendientes, en el caso que hayan más personas asignadas al reparto
            ->delete();

        Util::modificarObservacion($estadoActual->juriradicados_vigenciaRadicado, $estadoActual->juriradicados_idRadicado, $comentarioReparto);

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
                    ->select('nombreTipoProceso', 'descripcionHechos', 'idTipoProcesos', 'radicadoJuzgado',
                             'nombreJuzgado', 'nombreMedioControl', 'nombreTema')
                    ->join('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                    ->leftJoin('jurijuzgados', 'juriradicados.jurijuzgados_idJuzgado', '=', 'jurijuzgados.idJuzgado')
                    ->leftJoin('jurimedioscontrol', 'juriradicados.jurimedioscontrol_idMediosControl', '=', 'jurimedioscontrol.idMediosControl')
                    ->leftJoin('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
                    ->where('vigenciaRadicado', '=', $estadoActual->juriradicados_vigenciaRadicado)
                    ->where('idRadicado', '=', $estadoActual->juriradicados_idRadicado)
                    ->get();

            $nombreProceso      = "";
            $descHechos         = "";
            $idTipoProceso      = "";
            $radicadoJuzgado    = "";
            $nombreJuzgado      = "";
            $nombreMedioControl = "";
            $nombreTema         = "";
            if(count($proceso) > 0)
            {
                $nombreProceso        = $proceso[0]->nombreTipoProceso;
                $descHechos           = $proceso[0]->descripcionHechos;
                $idTipoProceso        = $proceso[0]->idTipoProcesos;
                $radicadoJuzgado      = $proceso[0]->radicadoJuzgado;
                $nombreJuzgado        = $proceso[0]->nombreJuzgado;
                $nombreMedioControl   = $proceso[0]->nombreMedioControl;
                $nombreTema           = $proceso[0]->nombreTema;
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
                ->select('emailUsuario', 'celularUsuario', 'nombresUsuario')
                ->join('usuarios', 'juriresponsables.usuarios_idUsuario', '=', 'usuarios.idUsuario')
                ->where('idResponsable', '=', $vectorAsignados[$i])
                ->get();

            $data = array('idRadicado'              => $estadoActual->juriradicados_idRadicado, 
                          'vigenciaRadicado'        => $estadoActual->juriradicados_vigenciaRadicado, 
                          'nombreTipoProceso'       => $nombreProceso,
                          'causasHechos'            => $descHechos,
                          'radicadoJuzgado'         => $radicadoJuzgado,
                          'nombreJuzgado'           => $nombreJuzgado,
                          'nombreMedioControl'      => $nombreMedioControl,
                          'nombreTema'              => $nombreTema,
                          'usuarioActual'           => $usuario->nombresUsuario,
                          'rutaEmail'               => $rutaEmail);

            if(count($emailUsuario) > 0)
            {
                //#ENVIAR EMAIL
                Util::enviarEmail($data, $emailUsuario[0]->emailUsuario, $clase, $estadoActual->juriradicados_vigenciaRadicado, $estadoActual->juriradicados_idRadicado);
                //#ENVIAR EMAIL

                //## ENVIAR SMS CON PLAZO DE LA TUTELA
                if($idTipoProceso == 3)
                {
                    $plazoTutela = DB::table('juriplazoradicado')
                                    ->where('radicados_vigenciaRadicado', '=', $estadoActual->juriradicados_vigenciaRadicado)
                                    ->where('radicados_idRadicado', '=', $estadoActual->juriradicados_idRadicado)
                                    ->get();

                    if($emailUsuario[0]->celularUsuario !='' && count($plazoTutela) > 0)
                    {
                        $tipoPlazo = "Días";
                        if($plazoTutela[0]->tipoPlazo == 2)
                        {
                            $tipoPlazo = "Horas";
                        }

                        $tipoTiempo = "Hábiles";
                        if($plazoTutela[0]->tipoTiempo == 2)
                        {
                            $tipoTiempo = "Calendario";
                        }

                        $plazo = $plazoTutela[0]->cantidadPlazo." ".$tipoPlazo." ".$tipoTiempo;

                        $expresion = '/^[3][0-9]{9}+$/';
                        if(preg_match($expresion, $emailUsuario[0]->celularUsuario))
                        {
                            $nombreUsu = explode(" ", $emailUsuario[0]->nombresUsuario);

                            $mensaje = "Hola ".$nombreUsu[0].", se le asignó una tutela con un plazo de  ".$plazo.", Radicado Juzgado ".$radicadoJuzgado.", Juzgado ".$nombreJuzgado.", Radicado litígo: ".$estadoActual->juriradicados_vigenciaRadicado."-".$estadoActual->juriradicados_idRadicado;

                            Util::enviarSms($emailUsuario[0]->celularUsuario, $mensaje);
                        }
                    }   
                }
                //## ENVIAR SMS CON PLAZO DE LA TUTELA
            }
        }

        DB::table('juriradicados')
                ->where('vigenciaRadicado', $estadoActual->juriradicados_vigenciaRadicado)
                ->where('idRadicado', $estadoActual->juriradicados_idRadicado)
                ->update([
                    'juriresponsables_idResponsable_titular' => $request->input('apoderadoProceso')]);
                
        $observacion = "Realiza el reparto";
        Util::guardarLog($observacion, $estadoActual->juriradicados_vigenciaRadicado, $estadoActual->juriradicados_idRadicado, 4);

        return;
    }
}