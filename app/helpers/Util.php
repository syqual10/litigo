<?php
namespace SQ10\helpers;

use Elibom\APIClient\ElibomClient as ElibomClient;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

use SQ10\Models\Entidad;
use SQ10\Models\Ciudad;
use SQ10\Models\Sms;
use SQ10\Models\EmailGuardado;
use SQ10\Models\Bitacora;
use SQ10\Models\BitacoraGed;
use SQ10\Models\Observacion;
use SQ10\Models\ActuacionProcesal;
use SQ10\Models\FalloRadicado;
use Session;
use DB;

class Util
{
    public static function formatearFecha($fecha)
    {
        $dias = array('','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo');
        $meses = array('','enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre');
        $dia = $dias[date('N', strtotime($fecha))]; 
        $mes = $meses[(int)substr($fecha, 5,2)]; 
        $numDia = substr($fecha, 8,2); 
        $anio = substr($fecha, 0,4);

        $final = $dia." ".$numDia." de ".$mes." de ".$anio; 

        return $final;
    }
    
    public static function traerCiudadOperacion()
    {
        $entidad = Entidad::find(1);

        if(count($entidad) > 0)
        {
            $ciudad = Ciudad::find($entidad->ciudades_idCiudad);
            $ciudadOperacion = $ciudad->idCiudad;
        }
        else
        {
            $ciudadOperacion = 0;
        }
        return $ciudadOperacion;
    } 

    public static function valorParametro($idParametro)
    {
        $valorParametro = DB::table('parametros')
            ->where('idParametro', '=', $idParametro)
            ->get();

        return  $valorParametro[0]->valorParametro;
    }

    public static function getIP()
    { 
        if (isset($_SERVER["HTTP_CLIENT_IP"]))
        {
            return $_SERVER["HTTP_CLIENT_IP"];
        }
        elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
        {
            return $_SERVER["HTTP_X_FORWARDED_FOR"];
        }
        elseif (isset($_SERVER["HTTP_X_FORWARDED"]))
        {
            return $_SERVER["HTTP_X_FORWARDED"];
        }
        elseif (isset($_SERVER["HTTP_FORWARDED_FOR"]))
        {
            return $_SERVER["HTTP_FORWARDED_FOR"];
        }
        elseif (isset($_SERVER["HTTP_FORWARDED"]))
        {
            return $_SERVER["HTTP_FORWARDED"];
        }
        else
        {
            return $_SERVER["REMOTE_ADDR"];
        } 
    }

    public static function guardarLogGed($accion, $descripcion) 
    { 
        $ip = Util::getIp();//Obtiene la ip de la máquina del usuario  

        $usuario = Session::get('idUsuario');//Obtiene el id del usuario

        $bitacora = new BitacoraGed;
        $bitacora->usuarios_idUsuario = $usuario;
        $bitacora->acciones_idAccion = $accion;
        $bitacora->descripcion = $descripcion;
        $bitacora->fecha = date("Y-m-d");//Obtiene la fecha actual
        $bitacora->hora = date('g:i a');//Obtiene la hora actual
        $bitacora->ipUsuario = $ip;
        $bitacora->save();  
    }

    public static function guardarLog($observacion, $vigenciaRadicado, $idRadicado, $tipoBitacora) 
    { 
        $ip = Util::getIp();//Obtiene la ip de la máquina del usuario             
        $idUsuario = Session::get('idUsuario');
        
        if($idUsuario !='')
        {
            $bitacora = new Bitacora;
            $bitacora->observacionBitacora = $observacion;
            $bitacora->juriradicados_vigenciaRadicado = $vigenciaRadicado;
            $bitacora->juriradicados_idRadicado = $idRadicado;
            $bitacora->juritiposbitacoras_idTipoBitacora = $tipoBitacora;
            $bitacora->usuarios_idUsuario = $idUsuario;
            $bitacora->ipUsuario = $ip;
            $bitacora->save();  
        }
    }

    public static function apoderadosRadicado($vigenciaRadicado, $idRadicado)
    {
        $apoderados = DB::table('juriestadosetapas')
                    ->select('nombresUsuario', 'nombreDependencia', 'idResponsable', 'emailUsuario', 'celularUsuario', 'datosCopiaActuacion', 'idEstadoEtapa')
                    ->join('juriresponsables', 'juriestadosetapas.juriresponsables_idResponsable', '=', 'juriresponsables.idResponsable')
                    ->join('usuarios', 'juriresponsables.usuarios_idUsuario', '=', 'usuarios.idUsuario')
                    ->leftJoin('dependencias', 'usuarios.dependencias_idDependencia', '=', 'dependencias.idDependencia')
                    ->where('juriradicados_vigenciaRadicado', '=', $vigenciaRadicado)
                    ->where('juriradicados_idRadicado', '=', $idRadicado)
                    ->where('juritiposestados_idTipoEstado', '=', 3)//actuación
                    ->get();

        return $apoderados;
    }

    public static function apoderadosActivosRadicado($vigenciaRadicado, $idRadicado)
    {
        $apoderados = DB::table('juriestadosetapas')
                    ->select('nombresUsuario', 'nombreDependencia', 'idResponsable', 'emailUsuario', 'celularUsuario', 'datosCopiaActuacion', 'idEstadoEtapa')
                    ->join('juriresponsables', 'juriestadosetapas.juriresponsables_idResponsable', '=', 'juriresponsables.idResponsable')
                    ->join('usuarios', 'juriresponsables.usuarios_idUsuario', '=', 'usuarios.idUsuario')
                    ->join('dependencias', 'usuarios.dependencias_idDependencia', '=', 'dependencias.idDependencia')
                    ->where('juriradicados_vigenciaRadicado', '=', $vigenciaRadicado)
                    ->where('juriradicados_idRadicado', '=', $idRadicado)
                    ->where('juritiposestados_idTipoEstado', '=', 3)//actuación
                    ->where('juritipoestadosetapas_idTipoEstadoEtapa', '=', 1)//activos
                    ->get();

        return $apoderados;
    }

    public static function fallos_old($vigenciaRadicado, $idRadicado, $instancia)
    {
        $nombre = "";

        $proceso = DB::table('juriactuaciones')
                    ->where('jurietapas_idEtapa', '=', 3)
                    ->where('juritiposactuaciones_idTipoActuacion', '=', $instancia)
                    ->where('juriradicados_vigenciaRadicado', '=', $vigenciaRadicado)
                    ->where('juriradicados_idRadicado', '=', $idRadicado)
                    ->get();

        if(count($proceso) > 0)
        {
            foreach ($proceso as $proce) 
            {
                $sentido = DB::table('jurifalloradicado')
                    ->join('juritiposfallos', 'jurifalloradicado.juritiposfallos_idTipoFallo', '=', 'juritiposfallos.idTipoFallo')
                    ->where('juriactuaciones_idActuacion', '=', $proce->idActuacion)
                    ->where('jurifalloradicado.activo','=', 1)
                    ->get();

                if(count($sentido) > 0)
                {
                    if($sentido[0]->nombreTipoFallo != '')
                    {
                       return $sentido[0]->nombreTipoFallo;
                    }
                }
            }
        }
        else
        {
            return  "";
        }
    }

    public static function fallos_old_fecha($vigenciaRadicado, $idRadicado, $instancia)
    {
        $nombre = "";

        $proceso = DB::table('juriactuaciones')
                    ->where('jurietapas_idEtapa', '=', 3)
                    ->where('juritiposactuaciones_idTipoActuacion', '=', $instancia)
                    ->where('juriradicados_vigenciaRadicado', '=', $vigenciaRadicado)
                    ->where('juriradicados_idRadicado', '=', $idRadicado)
                    ->get();

        if(count($proceso) > 0)
        {
            foreach ($proceso as $proce) 
            {
                $sentido = DB::table('jurifalloradicado')
                    ->join('juritiposfallos', 'jurifalloradicado.juritiposfallos_idTipoFallo', '=', 'juritiposfallos.idTipoFallo')
                    ->where('juriactuaciones_idActuacion', '=', $proce->idActuacion)
                    ->where('jurifalloradicado.activo','=', 1)
                    ->get();

                if(count($sentido) > 0)
                {
                    if($sentido[0]->nombreTipoFallo != '')
                    {
                       return $proce->fechaActuacion;
                    }
                }
            }
        }
        else
        {
            return  "";
        }
    }

    public static function datosEstadoEtapa($idEstadoEtapa)
    {
        $estadoEtapa = DB::table('juriestadosetapas')
                    ->select('nombresUsuario', 'fechaFinalEstado')
                    ->join('juriresponsables', 'juriestadosetapas.juriresponsables_idResponsable', '=', 'juriresponsables.idResponsable')
                    ->join('usuarios', 'juriresponsables.usuarios_idUsuario', '=', 'usuarios.idUsuario')
                    ->where('idEstadoEtapa', '=', $idEstadoEtapa)
                    ->get();

        return $estadoEtapa;
    }

    public static function ultimoUsuarioRadicado($idEstadoEtapa)
    {
        $nombreUsuario = DB::table('juriestadosetapas')
                ->select('nombresUsuario')
                ->join('juriresponsables', 'juriestadosetapas.juriresponsables_idResponsable', '=', 'juriresponsables.idResponsable')
                ->join('usuarios', 'juriresponsables.usuarios_idUsuario', '=', 'usuarios.idUsuario')
                ->where('idEstadoEtapa', '=', $idEstadoEtapa)
                ->get();

        if(count($nombreUsuario) > 0)
        {
            return $nombreUsuario[0]->nombresUsuario;
        }
        else
        {
            return '';
        }
    }

    public static function usuarioPorRadicado($vigenciaRadicado, $idRadicado)
    {
        $nombreUsuario = DB::table('juriestadosetapas')
                ->select('nombresUsuario')
                ->join('juriresponsables', 'juriestadosetapas.juriresponsables_idResponsable', '=', 'juriresponsables.idResponsable')
                ->join('usuarios', 'juriresponsables.usuarios_idUsuario', '=', 'usuarios.idUsuario')
                ->where('juriradicados_vigenciaRadicado', '=', $vigenciaRadicado)
                ->where('juriradicados_idRadicado', '=', $idRadicado)
                ->orderby('idEstadoEtapa','desc')
                ->take(1)// último registro en estado etapa
                ->get();

        if(count($nombreUsuario) > 0)
        {
            return $nombreUsuario[0]->nombresUsuario;
        }
        else
        {
            return '';
        }
    }

    public static function ultimoResponsableRadicado($vigenciaRadicado, $idRadicado)
    {
        $usuario = DB::table('juriestadosetapas')
                ->select('idResponsable')
                ->join('juriresponsables', 'juriestadosetapas.juriresponsables_idResponsable', '=', 'juriresponsables.idResponsable')
                ->join('usuarios', 'juriresponsables.usuarios_idUsuario', '=', 'usuarios.idUsuario')
                ->where('juriradicados_vigenciaRadicado', '=', $vigenciaRadicado)
                ->where('juriradicados_idRadicado', '=', $idRadicado)
                ->orderby('idEstadoEtapa','desc')
                ->take(1)// último registro en estado etapa
                ->get();

        return $usuario;
    }

    public static function datosUltimoUsuarioRadicado($idEstadoEtapa)
    {
        $usuario = DB::table('juriestadosetapas')
                    ->select('nombresUsuario', 'nombreDependencia', 'nombreCargo', 'documentoUsuario', 'expedicionSolicitante', 'tarjetaProfesional')
                  ->leftJoin('juriresponsables', 'juriestadosetapas.juriresponsables_idResponsable', '=', 'juriresponsables.idResponsable')
                  ->leftJoin('usuarios', 'juriresponsables.usuarios_idUsuario', '=', 'usuarios.idUsuario')
                  ->leftJoin('cargos', 'usuarios.cargos_idcargo', '=', 'cargos.idCargo')
	              ->leftJoin('dependencias', 'usuarios.dependencias_idDependencia', '=', 'dependencias.idDependencia')
                     ->where('idEstadoEtapa', '=', $idEstadoEtapa)
                   ->orderby('idEstadoEtapa','desc')
                      ->take(1)// último registro en estado etapa
                       ->first();

        return $usuario;
    }

    public static function datosUsuarioPorRadicado($vigenciaRadicado, $idRadicado)
    {
        $usuario = DB::table('juriestadosetapas')
                    ->select('nombresUsuario', 'nombreDependencia', 'nombreCargo', 'documentoUsuario', 'expedicionSolicitante', 'tarjetaProfesional')
                  ->leftJoin('juriresponsables', 'juriestadosetapas.juriresponsables_idResponsable', '=', 'juriresponsables.idResponsable')
                  ->leftJoin('usuarios', 'juriresponsables.usuarios_idUsuario', '=', 'usuarios.idUsuario')
                  ->leftJoin('cargos', 'usuarios.cargos_idcargo', '=', 'cargos.idCargo')
                  ->leftJoin('dependencias', 'usuarios.dependencias_idDependencia', '=', 'dependencias.idDependencia')
                     ->where('juriradicados_vigenciaRadicado', '=', $vigenciaRadicado)
                     ->where('juriradicados_idRadicado', '=', $idRadicado)
                   ->orderby('idEstadoEtapa','desc')
                      ->take(1)// último registro en estado etapa
                       ->first();

        return $usuario;
    }

    public function expedienteDigitalMigradosContador($contador)
    {
        $expedienteDigitalMigradoContador = DB::table('jurianexosmigrados')
                                      ->where('consecutivo', '=', $contador)
                                        ->count();

        return $expedienteDigitalMigradoContador;
    }

    public static function primerInvolucradoProceso($vigenciaRadicado, $idRadicado, $tipoProceso)
    {
        if($tipoProceso == 1)
        {
            $involucrado = DB::table('juriinvolucrados')
                ->join('solicitantes', 'juriinvolucrados.solicitantes_idSolicitante', '=', 'solicitantes.idSolicitante')
                ->where('juriradicados_vigenciaRadicado', '=', $vigenciaRadicado)
                ->where('juriradicados_idRadicado', '=', $idRadicado)
                ->where('juritipoinvolucrados_idTipoInvolucrado', '=', 1)
                ->first();
        }
        else if($tipoProceso == 2)
        {
            $involucrado = DB::table('juriinvolucrados')
                ->join('solicitantes', 'juriinvolucrados.solicitantes_idSolicitante', '=', 'solicitantes.idSolicitante')
                ->where('juriradicados_vigenciaRadicado', '=', $vigenciaRadicado)
                ->where('juriradicados_idRadicado', '=', $idRadicado)
                ->where('juritipoinvolucrados_idTipoInvolucrado', '=', 4)
                ->first();
        }
        else
        {
            $involucrado = DB::table('juriinvolucrados')
                ->join('solicitantes', 'juriinvolucrados.solicitantes_idSolicitante', '=', 'solicitantes.idSolicitante')
                ->where('juriradicados_vigenciaRadicado', '=', $vigenciaRadicado)
                ->where('juriradicados_idRadicado', '=', $idRadicado)
                ->where('juritipoinvolucrados_idTipoInvolucrado', '=', 7)
                ->first();
        }
        
        if(count($involucrado) > 0)
        {
            return $involucrado->nombreSolicitante;
        }
        else
        {
            return "";
        }
    }

    public static function idResponsable($idUsuario)
    {
        $responsable = DB::table('juriresponsables')
                ->where('usuarios_idUsuario', '=', $idUsuario)
                ->first();
        
        if(count($responsable) > 0)
        {
            return $responsable->idResponsable;
        }
        else
        {
            return 0;            
        }
    }

    public static function datosResponsable($idUsuario)
    {
        $responsable = DB::table('juriresponsables')
                ->select('generarOficios', 'idDependencia', 'permiso', 'nombresUsuario', 'nombreDependencia', 'juripuntosatencion_idPuntoAtencion', 'idResponsable')
                ->join('usuarios', 'juriresponsables.usuarios_idUsuario', '=', 'usuarios.idUsuario')
                ->leftJoin('dependencias', 'usuarios.dependencias_idDependencia', '=', 'dependencias.idDependencia')
                ->where('usuarios_idUsuario', '=', $idUsuario)
                ->first();
        
        return $responsable;
    }

    public static function datosResponsable2($idResponsable)
    {
        $responsable = DB::table('juriresponsables')
                ->select('generarOficios', 'idDependencia', 'permiso', 'nombresUsuario', 'nombreDependencia', 'juripuntosatencion_idPuntoAtencion', 'idResponsable')
                ->join('usuarios', 'juriresponsables.usuarios_idUsuario', '=', 'usuarios.idUsuario')
                ->leftJoin('dependencias', 'usuarios.dependencias_idDependencia', '=', 'dependencias.idDependencia')
                ->where('juriresponsables.idResponsable', '=', $idResponsable)
                ->first();
        
        return $responsable;
    }

    public static function idsResponsableBuzon($idUsuario)
    {
        $responsables = DB::table('juriresponsables')
                    ->where('usuarios_idUsuario', '=', $idUsuario)
                    ->get();
        
        $arrayIds = [];
        if(count($responsables) > 0)
        {
            foreach($responsables as $responsable)
            {
                $arrayIds[] = $responsable->idResponsable;
            }
        }
        return $arrayIds;
    }

    public static function traerSolicitanteBuzon($vigencia, $radicado)
    {
        $responsable = DB::table('juriinvolucrados')
                ->join('solicitantes', 'juriinvolucrados.solicitantes_idSolicitante', 'solicitantes.idSolicitante')
                ->where('juriradicados_vigenciaRadicado', '=', $vigencia)
                ->where('juriradicados_idRadicado', '=', $radicado)
                ->get();
        
        if(count($responsable) == 1)
        {
            return $responsable[0]->nombreSolicitante;
        }
        else if(count($responsable) > 1)
        {
            return $responsable[0]->nombreSolicitante." y ".count($responsable)." mas"; 
        }
        else
        {
            return "";
        }
    }

    public static function cantidadTipoProcesoReparto($idTipoProceso, $idResponsable)
    {
        $tipoProceso = DB::table('juriestadosetapas')
                ->join('juriradicados', function ($join) {
                    $join->on('juriestadosetapas.juriradicados_idRadicado', '=', 'juriradicados.idRadicado')
                        ->on('juriestadosetapas.juriradicados_vigenciaRadicado', '=', 'juriradicados.vigenciaRadicado');
                })
                ->where('juriestadosradicados_idEstadoRadicado', '=', 1)//estado pendiente
                ->where('juritipoprocesos_idTipoProceso', '=', $idTipoProceso)
                ->where('juriresponsables_idResponsable', '=', $idResponsable)
                ->count();
        
        if($tipoProceso > 0)
        {
            return $tipoProceso;
        }
        else
        {
            return 0;
        }
    }


    public static function cantidadTipoProceso($idTipoProceso, $idResponsable)
    {
        $tipoProceso = DB::table('juriestadosetapas')
                ->join('juriradicados', function ($join) {
                    $join->on('juriestadosetapas.juriradicados_idRadicado', '=', 'juriradicados.idRadicado')
                        ->on('juriestadosetapas.juriradicados_vigenciaRadicado', '=', 'juriradicados.vigenciaRadicado');
                })
                ->where('juritipoestadosetapas_idTipoEstadoEtapa', '=', 1)//estado pendiente
                //->where('leidoEstado', '=', 1)//leído desde el buzón
                ->where('juritipoprocesos_idTipoProceso', '=', $idTipoProceso)
                ->where('juriresponsables_idResponsable', '=', $idResponsable)
                ->groupBy('juriestadosetapas.juriradicados_vigenciaRadicado')
                ->groupBy('juriestadosetapas.juriradicados_idRadicado')
                ->get();
        
        if(count($tipoProceso) > 0)
        {
            return count($tipoProceso);
        }
        else
        {
            return 0;
        }
    }

    public static function cantidadCargaAbogado($idResponsable)
    {
        $carga = DB::table('juriestadosetapas')
                ->join('juriradicados', function ($join) {
                    $join->on('juriestadosetapas.juriradicados_idRadicado', '=', 'juriradicados.idRadicado')
                        ->on('juriestadosetapas.juriradicados_vigenciaRadicado', '=', 'juriradicados.vigenciaRadicado');
                })
                ->where('juritipoestadosetapas_idTipoEstadoEtapa', '=', 1)//estado pendiente
                ->where('juriresponsables_idResponsable', '=', $idResponsable)
                ->count();
        
        if($carga > 0)
        {
            return $carga;
        }
        else
        {
            return 0;
        }
    }

    public static function valorTipoProceso($idTipoProceso, $idResponsable)
    {
        $tiposProcesos = DB::table('juriestadosetapas')
                        ->select('vigenciaRadicado', 'idRadicado')
                        ->join('juriradicados', function ($join) {
                            $join->on('juriestadosetapas.juriradicados_idRadicado', '=', 'juriradicados.idRadicado')
                                ->on('juriestadosetapas.juriradicados_vigenciaRadicado', '=', 'juriradicados.vigenciaRadicado');
                        })
                        ->where('juriestadosradicados_idEstadoRadicado', '=', 1)//estado pendiente
                        //->where('leidoEstado', '=', 1)//ya leyeron por medio del buzón
                        ->where('juritipoprocesos_idTipoProceso', '=', $idTipoProceso)
                        ->where('juriresponsables_idResponsable', '=', $idResponsable)
                        ->get();
        
        if(count($tiposProcesos) > 0)
        {
            foreach ($tiposProcesos as $tipoProceso) 
            {
                $cuantiaProceso = DB::table('juricuantiaradicado')
                                ->where('juriradicados_vigenciaRadicado', '=', $tipoProceso->vigenciaRadicado)
                                ->where('juriradicados_idRadicado', '=', $tipoProceso->idRadicado)
                                ->sum('valorPesos');

                if($cuantiaProceso > 0)
                {
                    return $cuantiaProceso;
                }
                else
                {
                    return '0';
                }
            }
        }
        else
        {
            return '0';
        }
    }

    public static function cantidadTipoProcesoFini($idTipoProceso, $idResponsable)
    {
        $tipoProceso = DB::table('juriestadosetapas')
                ->join('juriradicados', function ($join) {
                    $join->on('juriestadosetapas.juriradicados_idRadicado', '=', 'juriradicados.idRadicado')
                        ->on('juriestadosetapas.juriradicados_vigenciaRadicado', '=', 'juriradicados.vigenciaRadicado');
                })
                ->where('juriestadosradicados_idEstadoRadicado', '=', 2)//estado finalizado, terminado
                ->where('juritipoprocesos_idTipoProceso', '=', $idTipoProceso)
                ->where('juriresponsables_idResponsable', '=', $idResponsable)
                ->count();
        
        if($tipoProceso > 0)
        {
            return $tipoProceso;
        }
        else
        {
            return "0";
        }
    }

    public static function responsableRadicado($vigenciaRadicado, $idRadicado, $idResponsable)
    {
        $idResponsable = DB::table('juriestadosetapas')
                ->select('juriresponsables_idResponsable')
                ->where('juriradicados_vigenciaRadicado', '=', $vigenciaRadicado)
                ->where('juriradicados_idRadicado', '=', $idRadicado)
                ->where('juriresponsables_idResponsable', '=', $idResponsable)
                ->where('juritiposestados_idTipoEstado', '=', 3)//actuación proceso
                ->get();

        if(count($idResponsable) > 0)
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }

    public static function agendasRadicado($vigenciaRadicado, $idRadicado)
    {
        $agendas = DB::table('juriagendas')
                ->where('juriradicados_vigenciaRadicado', '=', $vigenciaRadicado)
                ->where('juriradicados_idRadicado', '=', $idRadicado)
                ->get();

        return $agendas;
    }

    public static function valid_email_address($mail)
    {
        $user   = '[a-zA-Z0-9_\-\.\+\^!#\$%&*+\/\=\?\`\|\{\}~\']+';
        $domain = '(?:(?:[a-zA-Z0-9]|[a-zA-Z0-9][a-zA-Z0-9\-]*[a-zA-Z0-9])\.?)+';
        $ipv4   = '[0-9]{1,3}(\.[0-9]{1,3}){3}';
        $ipv6   = '[0-9a-fA-F]{1,4}(\:[0-9a-fA-F]{1,4}){7}';
        return preg_match("/^$user@($domain|(\[($ipv4|$ipv6)\]))$/", $mail);
    }

    public static function guardarEmail($email, $proceso, $proyecto)
    {   
        $emailGuardar = new EmailGuardado;
        $emailGuardar->email = $email;
        $emailGuardar->procesoEmail = $proceso;
        $emailGuardar->proyecto = $proyecto;
        $emailGuardar->save();
    }

    public static function enviarEmail($data, $correo, $clase, $vigenciaRadicado, $idRadicado)
    {   
        $idUsuario = Session::get('idUsuario');
        $idResponsable = Util::idResponsable($idUsuario);

        $responsable = DB::table('juriresponsables')
                    ->where('idResponsable', '=', $idResponsable)
                    ->get();

        if (Util::valid_email_address($correo) == 1 && $responsable[0]->notifiCorreo == 1)
        {
            Util::guardarEmail($correo, $vigenciaRadicado."-".$idRadicado, 3);// proyecto 3 jurídica

            Mail::to($correo, 'xxxxx')
              ->queue(new $clase($data));
        }
    }

    public static function enviarSms_2($celular, $mensaje)
    {
        $url = 'https://api.hablame.co/sms/envio/';
        $data = array(
            'cliente' => 10012277, //Numero de cliente
            'api' => 'w1KxBFJJyPrGZDCPQCm73KzpnzzYFh', //Clave API suministrada
            'numero' => '57'.$celular, //numero o numeros telefonicos a enviar el SMS (separados por una coma ,)
            'sms' => $mensaje, //Mensaje de texto a enviar
            'fecha' => '', //(campo opcional) Fecha de envio, si se envia vacio se envia inmediatamente (Ejemplo: 2017-12-31 23:59:59)
            'referencia' => 'Referenca Envio Hablame', //(campo opcional) Numero de referencio ó nombre de campaña
        );

        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context  = stream_context_create($options);
        $result = json_decode((file_get_contents($url, false, $context)), true);
        
        if ($result["resultado"]===0) 
        {
            $sms = new Sms;
            $sms->celular = $celular;
            $sms->mensaje = $mensaje;
            $sms->token = $result["sms"][1]["id"];
            $sms->proyecto = 3;//jurídica
            $sms->save();
        } 
        //print '<pre>';
        //print_r ($result);
    }

    public static function enviarSms($celular, $mensaje)
    {
        $post['to'] = array('57'.$celular);
        $post['text'] = $mensaje;
        $post['from'] = "msg";
        $user ="SyQual10S.A.S";
        $password = '#syqual10/5C';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://masivos.colombiared.com.co/Api/rest/message");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));
        curl_setopt($ch, CURLOPT_HTTPHEADER,
        array(
        "Accept: application/json",
        "Authorization: Basic ".base64_encode($user.":".$password)));
        $result = curl_exec ($ch); 
        
        $sms = new Sms;
        $sms->celular = $celular;
        $sms->mensaje = $mensaje;
        $sms->token = $result;
        $sms->proyecto = 3; //jurídica
        $sms->save(); 
    }

    public static function personaDemandante($vigenciaRadicado, $idRadicado, $idTipoProceso)
    {   
        $demandantePersona = '';

        if($idTipoProceso == 1)
        {
            $personas = DB::table('juriinvolucrados')
                    ->select('documentoSolicitante', 'nombreSolicitante')
                    ->join('solicitantes', 'juriinvolucrados.solicitantes_idSolicitante', '=', 'solicitantes.idSolicitante')
                    ->where('juritipoinvolucrados_idTipoInvolucrado', '=', 1)//demandante
                    ->where('juriradicados_vigenciaRadicado', '=', $vigenciaRadicado)
                    ->where('juriradicados_idRadicado', '=', $idRadicado)
                    ->get();
        }
        else if($idTipoProceso == 2)
        {
            $personas = DB::table('juriinvolucrados')
                    ->select('documentoSolicitante', 'nombreSolicitante')
                    ->join('solicitantes', 'juriinvolucrados.solicitantes_idSolicitante', '=', 'solicitantes.idSolicitante')
                    ->where('juritipoinvolucrados_idTipoInvolucrado', '=', 4)//convocantes
                    ->where('juriradicados_vigenciaRadicado', '=', $vigenciaRadicado)
                    ->where('juriradicados_idRadicado', '=', $idRadicado)
                    ->get();
        }
        else
        {
            $personas = DB::table('juriinvolucrados')
                    ->select('documentoSolicitante', 'nombreSolicitante')
                    ->join('solicitantes', 'juriinvolucrados.solicitantes_idSolicitante', '=', 'solicitantes.idSolicitante')
                    //->where('juritipoinvolucrados_idTipoInvolucrado', '=', 7)//accionante
                    ->whereIn('juritipoinvolucrados_idTipoInvolucrado',[7, 1])
                    ->where('juriradicados_vigenciaRadicado', '=', $vigenciaRadicado)
                    ->where('juriradicados_idRadicado', '=', $idRadicado)
                    ->get();
        }

        if(count($personas) > 0)
        {
            foreach ($personas as $persona) 
            {
                $demandantePersona.= "CC: ".$persona->documentoSolicitante." ".$persona->nombreSolicitante."- ";
                //$demandantePersona.= $persona->nombreSolicitante." - ";
            }
        }

        $demandantePersona = substr($demandantePersona, 0, -3);

        return $demandantePersona;
    }

    public static function personaDemandanteSoloNombre($vigenciaRadicado, $idRadicado, $idTipoProceso)
    {   
        $demandantePersona = '';

        if($idTipoProceso == 1)
        {
            $personas = DB::table('juriinvolucrados')
                    ->select('documentoSolicitante', 'nombreSolicitante')
                    ->join('solicitantes', 'juriinvolucrados.solicitantes_idSolicitante', '=', 'solicitantes.idSolicitante')
                    ->where('juritipoinvolucrados_idTipoInvolucrado', '=', 1)//demandante
                    ->where('juriradicados_vigenciaRadicado', '=', $vigenciaRadicado)
                    ->where('juriradicados_idRadicado', '=', $idRadicado)
                    ->get();
        }
        else if($idTipoProceso == 2)
        {
            $personas = DB::table('juriinvolucrados')
                    ->select('documentoSolicitante', 'nombreSolicitante')
                    ->join('solicitantes', 'juriinvolucrados.solicitantes_idSolicitante', '=', 'solicitantes.idSolicitante')
                    ->where('juritipoinvolucrados_idTipoInvolucrado', '=', 4)//convocantes
                    ->where('juriradicados_vigenciaRadicado', '=', $vigenciaRadicado)
                    ->where('juriradicados_idRadicado', '=', $idRadicado)
                    ->get();
        }
        else
        {
            $personas = DB::table('juriinvolucrados')
                    ->select('documentoSolicitante', 'nombreSolicitante')
                    ->join('solicitantes', 'juriinvolucrados.solicitantes_idSolicitante', '=', 'solicitantes.idSolicitante')
                    ->where('juritipoinvolucrados_idTipoInvolucrado', '=', 7)//accionante
                    ->where('juriradicados_vigenciaRadicado', '=', $vigenciaRadicado)
                    ->where('juriradicados_idRadicado', '=', $idRadicado)
                    ->get();
        }

        if(count($personas) > 0)
        {
            foreach ($personas as $persona) 
            {
                $demandantePersona.= $persona->nombreSolicitante.", ";
            }
        }

        return substr($demandantePersona, 0, -2);
    }
    

    //Retorna arreglo con los demantes y las cedulas
    public static function personaDemandanteArreglo($vigenciaRadicado, $idRadicado, $idTipoProceso)
    {   
        $demandantePersona = '';

        if($idTipoProceso == 1)
        {
            $personas = DB::table('juriinvolucrados')
                    ->select('documentoSolicitante', 'nombreSolicitante')
                    ->join('solicitantes', 'juriinvolucrados.solicitantes_idSolicitante', '=', 'solicitantes.idSolicitante')
                    ->where('juritipoinvolucrados_idTipoInvolucrado', '=', 1)//demandante
                    ->where('juriradicados_vigenciaRadicado', '=', $vigenciaRadicado)
                    ->where('juriradicados_idRadicado', '=', $idRadicado)
                    ->get();
        }
        else if($idTipoProceso == 2)
        {
            $personas = DB::table('juriinvolucrados')
                    ->select('documentoSolicitante', 'nombreSolicitante')
                    ->join('solicitantes', 'juriinvolucrados.solicitantes_idSolicitante', '=', 'solicitantes.idSolicitante')
                    ->where('juritipoinvolucrados_idTipoInvolucrado', '=', 4)//convocantes
                    ->where('juriradicados_vigenciaRadicado', '=', $vigenciaRadicado)
                    ->where('juriradicados_idRadicado', '=', $idRadicado)
                    ->get();
        }
        else
        {
            $personas = DB::table('juriinvolucrados')
                    ->select('documentoSolicitante', 'nombreSolicitante')
                    ->join('solicitantes', 'juriinvolucrados.solicitantes_idSolicitante', '=', 'solicitantes.idSolicitante')
                    ->where('juritipoinvolucrados_idTipoInvolucrado', '=', 7)//accionante
                    ->where('juriradicados_vigenciaRadicado', '=', $vigenciaRadicado)
                    ->where('juriradicados_idRadicado', '=', $idRadicado)
                    ->get();
        }

        $arreglo = [];

        if(count($personas) > 0)
        {
            foreach ($personas as $persona) 
            {
                $person = array( "cedula" => $persona->documentoSolicitante == null ? "" : $persona->documentoSolicitante, "nombre" => $persona->nombreSolicitante );
                array_push($arreglo, $person);
                $demandantePersona.= "CC: ".$persona->documentoSolicitante." ".$persona->nombreSolicitante."- ";
            }
        }

        return $arreglo;
    }

    public static function dependenciaDemandada($vigenciaRadicado, $idRadicado, $idTipoProceso)
    {   
        $dependenciaInvo = '';

        if($idTipoProceso == 1)
        {
            $dependencias = DB::table('juriinvolucrados')
                    ->select('nombreDependencia')
                    ->join('dependencias', 'juriinvolucrados.dependencias_idDependencia', '=', 'dependencias.idDependencia')
                    ->where('juritipoinvolucrados_idTipoInvolucrado', '=', 3)//demandando
                    ->where('juriradicados_vigenciaRadicado', '=', $vigenciaRadicado)
                    ->where('juriradicados_idRadicado', '=', $idRadicado)
                    ->get();
        }
        else if($idTipoProceso == 2)
        {
            $dependencias = DB::table('juriinvolucrados')
                    ->select('nombreDependencia')
                    ->join('dependencias', 'juriinvolucrados.dependencias_idDependencia', '=', 'dependencias.idDependencia')
                    ->where('juritipoinvolucrados_idTipoInvolucrado', '=', 5)//convocado Interno
                    ->where('juriradicados_vigenciaRadicado', '=', $vigenciaRadicado)
                    ->where('juriradicados_idRadicado', '=', $idRadicado)
                    ->get();
        }
        else
        {
            $dependencias = DB::table('juriinvolucrados')
                    ->select('nombreDependencia')
                    ->join('dependencias', 'juriinvolucrados.dependencias_idDependencia', '=', 'dependencias.idDependencia')
                    ->where('juritipoinvolucrados_idTipoInvolucrado', '=', 8)//accionado interno
                    ->where('juriradicados_vigenciaRadicado', '=', $vigenciaRadicado)
                    ->where('juriradicados_idRadicado', '=', $idRadicado)
                    ->get();
        }

        if(count($dependencias) > 0)
        {
            foreach ($dependencias as $dependencia) 
            {
                $dependenciaInvo.= $dependencia->nombreDependencia.", ";
            }
        }

        return $dependenciaInvo;
    }

    public static function entidadExternaDemandada($vigenciaRadicado, $idRadicado, $idTipoProceso)
    {   
        $entidadInvo = '';

        if($idTipoProceso == 1 || $idTipoProceso == 2)
        {
            $involucrados = DB::table('juriinvolucrados')
                    ->select('nombreConvocadoExterno')
                    ->join('juriconvocadosexternos', 'juriinvolucrados.juriconvocadosexternos_idConvocadoExterno', '=', 'juriconvocadosexternos.idConvocadoExterno')
                    ->where('juritipoinvolucrados_idTipoInvolucrado', '=', 6)//6 Convocados externos
                    ->where('juriradicados_vigenciaRadicado', '=', $vigenciaRadicado)
                    ->where('juriradicados_idRadicado', '=', $idRadicado)
                    ->get();
        }
        else
        {
            $involucrados = DB::table('juriinvolucrados')
                    ->select('nombreConvocadoExterno')
                    ->join('juriconvocadosexternos', 'juriinvolucrados.juriconvocadosexternos_idConvocadoExterno', '=', 'juriconvocadosexternos.idConvocadoExterno')
                    ->where('juritipoinvolucrados_idTipoInvolucrado', '=', 9)//9 Accionados externos
                    ->where('juriradicados_vigenciaRadicado', '=', $vigenciaRadicado)
                    ->where('juriradicados_idRadicado', '=', $idRadicado)
                    ->get();
        }

        if(count($involucrados) > 0)
        {
            foreach ($involucrados as $involucrado) 
            {
                $entidadInvo.= $involucrado->nombreConvocadoExterno.", ";
            }
        }

        return $entidadInvo;
    }

    public static function cuantiasRadicado($vigenciaRadicado, $idRadicado)
    {   
        $valorCuantia = '';
        $total        = 0;

        $cuantias = DB::table('juricuantiaradicado')
                    ->where('juriradicados_vigenciaRadicado', '=', $vigenciaRadicado)
                    ->where('juriradicados_idRadicado', '=', $idRadicado)
                    ->get();

        if(count($cuantias) > 0)
        {
            foreach ($cuantias as $cuantia) 
            {
                $valorCuantia.= $cuantia->valorPesos;
            }
        }

        return $valorCuantia;
    }

    public static function cuantiasRadicadoSumadas($vigenciaRadicado, $idRadicado)
    {   
        $valorCuantia = 0;
        $total        = 0;

        $cuantias = DB::table('juricuantiaradicado')
                    ->where('juriradicados_vigenciaRadicado', '=', $vigenciaRadicado)
                    ->where('juriradicados_idRadicado', '=', $idRadicado)
                    ->get();

        if(count($cuantias) > 0)
        {
            foreach ($cuantias as $cuantia) 
            {
                $valorCuantia = $valorCuantia + intval($cuantia->valorPesos);
            }
        }

        return $valorCuantia;
    }

    public static function responsablesInternosResp($idResponsable)
    {   
        $respInternos = DB::table('juriresposanblesinternos')
                    ->where('juriresponsables_idResponsable', '=', $idResponsable)
                    ->count();

        return $respInternos;
    }


    public static function estadoActuacion($vigenciaRadicado, $idRadicado)
    {   
        $estado = DB::table('juriactuaciones')
                    ->select('nombreActuacion')
                    ->join('juritiposactuaciones', 'juriactuaciones.juritiposactuaciones_idTipoActuacion', '=', 'juritiposactuaciones.idTipoActuacion')
                    ->where('juriradicados_vigenciaRadicado', '=', $vigenciaRadicado)
                    ->where('juriradicados_idRadicado', '=', $idRadicado)
                    ->orderby('fechaActuacion','desc')
                    ->take(1)// último registro
                    ->get();

        if(count($estado) > 0)
        {
            return $estado[0]->nombreActuacion;
        }
        else
        {
            return "No se han generado estados para el radicado";
        }
    }

    public static function ultimoTipoActuacion($vigenciaRadicado, $idRadicado)
    {   
        $estado = DB::table('juriactuaciones')
                    ->select('nombreActuacion')
                    ->join('juritiposactuaciones', 'juriactuaciones.juritiposactuaciones_idTipoActuacion', '=', 'juritiposactuaciones.idTipoActuacion')
                    ->where('juriradicados_vigenciaRadicado', '=', $vigenciaRadicado)
                    ->where('juriradicados_idRadicado', '=', $idRadicado)
                    ->orderby('fechaActuacion','desc')
                    ->take(1)// último registro
                    ->get();

        if(count($estado) > 0)
        {
            return $estado[0]->nombreActuacion;
        }
        else
        {
            return "No se han generado estados para el radicado";
        }
    }
    

    public static function actuacionesRadicado($vigenciaRadicado, $idRadicado)
    {   
        $actuaciones = DB::table('juriactuaciones')
                    ->select('nombreActuacion', 'fechaActuacion')
                    ->join('juritiposactuaciones', 'juriactuaciones.juritiposactuaciones_idTipoActuacion', '=', 'juritiposactuaciones.idTipoActuacion')
                    ->where('juriactuaciones.juriradicados_vigenciaRadicado', '=', $vigenciaRadicado)
                    ->where('juriactuaciones.juriradicados_idRadicado', '=', $idRadicado)
                    ->where('juritiposactuaciones.tipoFallo', '=', 0)//Todas las actuaciones menos fallo
                    ->get();

        return $actuaciones;       
    }

    public static function fallos($vigenciaRadicado, $idRadicado)
    {   
        $fallos = DB::table('juriactuaciones')
                    ->select('nombreActuacion', 'nombreTipoFallo')
                    ->join('juritiposactuaciones', 'juriactuaciones.juritiposactuaciones_idTipoActuacion', '=', 'juritiposactuaciones.idTipoActuacion')
                    ->join('jurifalloradicado', 'juriactuaciones.idActuacion', '=', 'jurifalloradicado.juriactuaciones_idActuacion')
                    ->join('juritiposfallos', 'jurifalloradicado.juritiposfallos_idTipoFallo', '=', 'juritiposfallos.idTipoFallo')
                    ->where('juriactuaciones.juriradicados_vigenciaRadicado', '=', $vigenciaRadicado)
                    ->where('juriactuaciones.juriradicados_idRadicado', '=', $idRadicado)
                    ->where('juritiposactuaciones.tipoFallo', '=', 1)//Fallos
                    ->where('jurifalloradicado.activo','=', 1)
                    ->orderBy('idActuacion', 'desc')
                    ->first();

        return $fallos;
    }

    public static function sentidoFallo($vigenciaRadicado, $idRadicado)
    {   
        $sentidosFallos = DB::table('jurifalloradicado')
                    ->select('nombreActuacion', 'nombreTipoFallo', 'fechaActuacion')
                    ->join('juriactuaciones', 'jurifalloradicado.juriactuaciones_idActuacion', '=', 'juriactuaciones.idActuacion')
                    ->join('juritiposactuaciones', 'juriactuaciones.juritiposactuaciones_idTipoActuacion', '=', 'juritiposactuaciones.idTipoActuacion')
                    ->join('juritiposfallos', 'jurifalloradicado.juritiposfallos_idTipoFallo', '=', 'juritiposfallos.idTipoFallo')
                    ->where('jurifalloradicado.juriradicados_vigenciaRadicado', '=', $vigenciaRadicado)
                    ->where('jurifalloradicado.juriradicados_idRadicado', '=', $idRadicado)
                    ->where('jurifalloradicado.activo','=', 1)
                    ->get();

        return $sentidosFallos;
    }
    


    public static function dependenciasAfectadas($vigenciaRadicado, $idRadicado)
    {   
        $dependencias = DB::table('juriinvolucrados')
                    ->select('nombreDependencia')
                    ->join('dependencias', 'juriinvolucrados.dependencias_idDependencia', '=', 'dependencias.idDependencia')
                    ->where('juriinvolucrados.juriradicados_vigenciaRadicado', '=', $vigenciaRadicado)
                    ->where('juriinvolucrados.juriradicados_idRadicado', '=', $idRadicado)
                    ->get();

        return $dependencias;
    }

    public static function cantidadInvolucrado($tipoInvolucrado, $vigenciaRadicado, $idRadicado)
    {   
        $canInvlucrados = DB::table('juriinvolucrados')
                            ->where('juritipoinvolucrados_idTipoInvolucrado', '=', $tipoInvolucrado)
                            ->where('juriradicados_vigenciaRadicado', '=', $vigenciaRadicado)
                            ->where('juriradicados_idRadicado', '=', $idRadicado)
                            ->count();

        return $canInvlucrados;       
    }

    public static function datosRadicado($vigenciaRadicado, $idRadicado)
    {   
        $radicado = DB::table('juriradicados')
                   ->leftJoin('jurimedioscontrol', 'juriradicados.jurimedioscontrol_idMediosControl', '=', 'jurimedioscontrol.idMediosControl')
                      ->where('juriradicados.vigenciaRadicado', '=', $vigenciaRadicado)
                      ->where('juriradicados.idRadicado', '=', $idRadicado)
                      ->first();

        return $radicado;       
    }

    public static function guardarObservacion($fechaIni, $fechaFini, $idTipoEstadoEtapa, $vigenciaRadicado, $idRadicado, $comentario, $idResponsable, $idTipoEstado, $idEstadoEtapa, $idTipoObservacion)
    {   
        $observacion = new Observacion;
        $observacion->fechaInicioEstado                        = $fechaIni;
        $observacion->fechaFinalEstado                         = $fechaFini;
        $observacion->comentarioEstadoEtapa                    = $comentario;
        $observacion->juritipoestadosetapas_idTipoEstadoEtapa  = $idTipoEstadoEtapa;
        $observacion->juriradicados_vigenciaRadicado           = $vigenciaRadicado;
        $observacion->juriradicados_idRadicado                 = $idRadicado;
        $observacion->juriresponsables_idResponsable           = $idResponsable;
        $observacion->juritiposestados_idTipoEstado            = $idTipoEstado;
        $observacion->juriestadosetapas_idEstadoEtapa          = $idEstadoEtapa;
        $observacion->juritipoobservaciones_idTipoObservacion  = $idTipoObservacion;
        $observacion->save();
    }

    public static function modificarObservacion($vigenciaRadicado, $idRadicado, $comentario)
    {   
        DB::table('juriobservaciones')
                ->where('juriradicados_vigenciaRadicado', $vigenciaRadicado)
                ->where('juriradicados_idRadicado', $idRadicado)
                ->where('juritipoestadosetapas_idTipoEstadoEtapa', 1)
                ->update([
                    'fechaFinalEstado' => date("Y-m-d H:i:s"),
                    'comentarioEstadoEtapa' => $comentario,
                    'juritipoestadosetapas_idTipoEstadoEtapa' => 2]);//gestionado
    }

    public static function responsableArchivo($idArchivo, $idResponsable)
    {   
        $archivo = DB::table('juriarchivos')
                    ->where('idArchivo', '=', $idArchivo)
                    ->where('juriresponsables_idResponsable', '=', $idResponsable)
                    ->get();

        return count($archivo);
    }
    
    public static function replace_specials_characters($s) 
    {
        //$s = mb_convert_encoding($s, 'UTF-8','');
        $s = preg_replace("/á|à|â|ã|ª/","a",$s);
        $s = preg_replace("/Á|À|Â|Ã/","A",$s);
        $s = preg_replace("/é|è|ê/","e",$s);
        $s = preg_replace("/É|È|Ê/","E",$s);
        $s = preg_replace("/í|ì|î/","i",$s);
        $s = preg_replace("/Í|Ì|Î/","I",$s);
        $s = preg_replace("/ó|ò|ô|õ|º/","o",$s);
        $s = preg_replace("/Ó|Ò|Ô|Õ/","O",$s);
        $s = preg_replace("/ú|ù|û/","u",$s);
        $s = preg_replace("/Ú|Ù|Û/","U",$s);
        $s = str_replace(" ","-",$s);
        $s = str_replace("ñ","n",$s);
        $s = str_replace("Ñ","N",$s);
        
        $s = preg_replace('/[^a-zA-Z0-9_.-]/', '', $s);
        return $s;
    }

    public static function cantRespPunto($idPunto)
    {
        $respPunto = DB::table('juriresponsablespunto')
                    ->where('juripuntosatencion_idPuntoAtencion', '=', $idPunto)
                    ->count();

        return $respPunto;
    }

    public static function diasTranscurridos($fechaInicial, $fechaFinal)
    {
        $dias = (strtotime($fechaFinal) - strtotime($fechaInicial))/86400;
        $dias = abs($dias); 
        $dias = floor($dias);       
        return $dias;
    }

    public static function diasTranscurridosHabiles($fechaInicial, $fechaFinal)
    {
        $dias = (strtotime($fechaFinal) - strtotime($fechaInicial))/86400;
        $dias = abs($dias); 
        $dias = floor($dias);

        $nuevaFecha = $fechaInicial;

        $festivos = 0;

        for ($i=0; $i < $dias; $i++)  
        {
            $nuevaFecha = strtotime('+1 day', strtotime($nuevaFecha));
            $nuevaFecha = date('Y-m-d', $nuevaFecha);
            
            $fechasNoHabiles = DB::table('fechasnohabiles')
                    ->where('fechaNoHabil', '=', $nuevaFecha)
                    ->count();
            
            if($fechasNoHabiles > 0)
            {
                $festivos ++;
            }
        }
        return $dias+1 - $festivos;
    }

    public static function radicadosAsociados( $vigenciaRadicado ,$idRadicado)
    {
        $radicado = DB::table('juriradicados')
                    ->where('vigenciaRadicado', '=', $vigenciaRadicado)
                    ->where('idRadicado', '=', $idRadicado)
                    ->first();
        
        if($radicado->radicadoPadre != null )
        {
            return  $radicado->radicadoPadre;
        }

        if($radicado->radicadoHijo != null )
        {
            return  $radicado->radicadoHijo;
        }

        return "No tiene radicados asociados";
    }

    public static function valoracionFallo($idRadicado, $vigenciaRadicado )
    {
        $resultado = "Sin valoración";
        $valoracion = DB::table('jurivaloracionesfallomzl')
            ->where('juriradicados_idRadicado', '=', $idRadicado)
            ->where('juriradicados_vigenciaRadicado', '=', $vigenciaRadicado)
            ->first();

        if (count($valoracion) > 0) 
        {
            $resultado = $valoracion->puntajeValoracionFallo." %";
        }    

        return  $resultado;
    }

    public static function entidadesExternas($idRadicado, $vigenciaRadicado )
    {
        $involucrados  = DB::table('juriinvolucrados')
                            ->select('nombreConvocadoExterno')
                            ->leftJoin('juriconvocadosexternos','juriinvolucrados.juriconvocadosexternos_idConvocadoExterno', "=",'juriconvocadosexternos.idConvocadoExterno') 
                            ->where('juritipoinvolucrados_idTipoInvolucrado', 6)
                            ->where('juriradicados_idRadicado',$idRadicado )
                            ->where('juriradicados_vigenciaRadicado', $vigenciaRadicado)
                            ->get();

        return  $involucrados;
    }
 
}