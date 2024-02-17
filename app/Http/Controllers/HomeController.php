<?php

namespace SQ10\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DB;
use Session;
use SQ10\Models\Post;
use SQ10\Models\Archivo;
use SQ10\Models\Usuario;
use SQ10\helpers\Util as Util;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $idUsuario = Session::get('idUsuario');
        $rolUsuario = Auth::user()->roles_idRol;
        $idResponsable = Util::idResponsable($idUsuario);

        $procesosPendientes = DB::table('juriestadosetapas')
                            ->where('juriresponsables_idResponsable', '=', $idResponsable)
                            ->where('juritipoestadosetapas_idTipoEstadoEtapa', '=', 1)// pendiente
                            ->get();

        $sumaCuantia = 0;
        if(count($procesosPendientes) > 0)
        {
            foreach ($procesosPendientes as $procesoPendiente) 
            {
                $cuantias = DB::table('juricuantiaradicado')
                                ->where('juriradicados_vigenciaRadicado', '=', $procesoPendiente->juriradicados_vigenciaRadicado)
                                ->where('juriradicados_idRadicado', '=', $procesoPendiente->juriradicados_idRadicado)
                                ->sum('valorPesos');

                if(count($cuantias) > 0)
                {
                    $sumaCuantia = $sumaCuantia + $cuantias;
                }
            }
        }

        $actuacionesProcesales = DB::table('juriactuaciones')
                            ->where('juriresponsables_idResponsable', '=', $idResponsable)
                            ->count();

        $usuarioJuridica = DB::table('juriresponsables')
                ->where('usuarios_idUsuario', '=', $idUsuario)
                ->count();

        if($usuarioJuridica > 0 || $rolUsuario == 1)
        {
            return view('home')
                    ->with('procesosPendientes', $procesosPendientes)
                    ->with('actuacionesProcesales', $actuacionesProcesales)
                    ->with('sumaCuantia', $sumaCuantia);
        }
        else
        {
            return view('denegado');
        }
    }

    public function actionEditarFoto(Request $request)
    {
        return view('ajax_home.ajaxEditarFoto');  
    }

    public function actionDescargarArchivoPost($idArchivo)
    {
        //Se busca el archivo
        $archivo = Archivo::find($idArchivo);

        $rutaArchivo = "juriArch/posteos/".utf8_decode($archivo->nombreArchivo); 

        header("Content-type: application/octet-stream");
        header("Content-Disposition: attachment; filename=\"$archivo->nombreArchivo\"\n");
        $fp=fopen("$rutaArchivo", "r");
        fpassthru($fp);
    }

    public function actionSubirFoto(Request $request)
    {
        $documentoUsuario = Auth::user()->documentoUsuario;
        $rutaArchivo = 'juriArch/entidad/usuarios/'.utf8_decode($documentoUsuario).".jpg"; //Ruta completa a la imagen a borrar

        if(file_exists($rutaArchivo))
        {
            unlink($rutaArchivo);
        }

        //El nombre temporal del archivo en el que se guarda el archivo cargado en el servidor
        $temporalFile = isset($_FILES['file']['tmp_name']) ? $_FILES['file']['tmp_name'] : null;
        //Nombre del archivo
        $fileName = isset($_FILES['file']['name']) ? $_FILES['file']['name'] : null;
        $fileName = Util::replace_specials_characters($fileName);
        //Extensión Archivo
        $trozos  = explode(".", $fileName);
        $fileExt = end($trozos);

        $newFileName = $documentoUsuario.".jpg";

        //$radicado = 1;
        //$vigencia = 2018;

        //$path = "/juriArch/archivos/".$radicado."-".$vigencia."/";
        $path = "/juriArch/entidad/usuarios/";

        //Si no exite la carpeta la crea
        // if (!file_exists(public_path() . $path)) 
        // {
        //     mkdir(public_path() . $path, 0777, true);
        // }
        
        //Si el archivo se copió correctamente en el servidor
        if (move_uploaded_file($temporalFile, public_path() . $path . utf8_decode($newFileName))) 
        {
            return 1;// subió correctamente
        }
        else
        {
            return 2;// no subió
        }
    }

    public function actionPosteos(Request $request)
    {
        $idUsuario = Session::get('idUsuario');
        $idResponsable = Util::idResponsable($idUsuario);

        $posteos = DB::table('juriposteos')
                    ->join('juriresponsables', 'juriposteos.juriresponsables_idResponsable', '=', 'juriresponsables.idResponsable')
                    ->join('usuarios', 'juriresponsables.usuarios_idUsuario', '=', 'usuarios.idUsuario')
                    ->where('juriposteos_idPosteo', '=', NULL)
                    ->skip(0)
                    ->take(10)
                    ->orderBy('fechaPosteo', 'DESC')
                    ->get();

        return view('ajax_home.ajaxPosteos')
                    ->with('posteos', json_decode($posteos, true))
                    ->with('idResponsable', $idResponsable);
    }

    public function actionLoadMorePost(Request $request)
    {
        if($request->input('ultimoPost') != '')
        {
            $idUsuario = Session::get('idUsuario');
            $idResponsable = Util::idResponsable($idUsuario);
            
            $posteos = DB::table('juriposteos')
                        ->join('juriresponsables', 'juriposteos.juriresponsables_idResponsable', '=', 'juriresponsables.idResponsable')
                        ->join('usuarios', 'juriresponsables.usuarios_idUsuario', '=', 'usuarios.idUsuario')
                        ->where('juriposteos_idPosteo', '=', NULL)
                        ->where('idPosteo', '<', $request->input('ultimoPost'))
                        ->skip(0)
                        ->take(10)
                        ->orderBy('fechaPosteo', 'DESC')
                        ->get();

            $posteos = json_decode($posteos, true);

            if(count($posteos) > 0 )
            {
                foreach($posteos as $key => $posteo)
                {
                    $idUltimoPost[$key] = $posteo['idPosteo'];
                }
                $minPost = min($idUltimoPost);

                return response()->json([
                    'vistaPostInfinito'  => view('ajax_home.ajaxPostInfinito')
                        ->with('posteos', $posteos)
                        ->with('idResponsable', $idResponsable)
                        ->render(),
                    'ultimoPost'      => $minPost
                ]);
            }
            else
            {
                return 0;
            }
        }
        else
        {
            return 1;
        }
    }

    public function actionValidarGuardarPosteo(Request $request)
    {
        $idUsuario = Session::get('idUsuario');
        $usuarios = Usuario::find($idUsuario);
        $idResponsable = Util::idResponsable($idUsuario);

        $post = new Post;
        $post->juriresponsables_idResponsable = $idResponsable;
        $post->post = $request->input('posteo');
        $post->save();

        return response()->json([
                'idResponsable'   => $idResponsable,
                'nombresUsuario'  => $usuarios->nombresUsuario
            ]);
    }

    public function actionUploadArchivoPost(Request $request)
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
        $path = "/juriArch/posteos/";  

        //Si no exite la carpeta la crea
        if (!file_exists(public_path() . $path)) 
        {
            mkdir(public_path() . $path, 0777, true);
        }
        
        //Si el archivo se copió correctamente en el servidor
        if (move_uploaded_file($temporalFile, public_path() . $path . utf8_decode($newFileName))) 
        {
            $archivoPost = new Archivo;
            $archivoPost->nombreArchivo                     = $newFileName;
            $archivoPost->extensionArchivo                  = $fileExt;
            $archivoPost->juriresponsables_idResponsable    = $idResponsable;
            $archivoPost->save();
            $idArchivoLast = $archivoPost->idArchivo;

            $post = Post::orderBy('idPosteo', 'desc')->first();

            DB::table('juriarchivos')
                ->where('idArchivo', $idArchivoLast)
                ->update([
                    'juriposteos_idPosteo' => $post->idPosteo]);

            return 1;// subió correctamente
        }
        else
        {
            return 2;// no subió
        }
    }

    public function actionValidarGuardarRepost(Request $request)
    {
        $idUsuario = Session::get('idUsuario');
        $usuarios = Usuario::find($idUsuario);
        $idResponsable = Util::idResponsable($idUsuario);

        $post = new Post;
        $post->juriresponsables_idResponsable = $idResponsable;
        $post->post                           = $request->input('rePost');
        $post->juriposteos_idPosteo           = $request->input('idPost');
        $post->save();

        return response()->json([
            'idResponsable'   => $idResponsable,
            'nombresUsuario'  => $usuarios->nombresUsuario
        ]);
    }

    public function actionMostrarTodosRepost(Request $request)
    {
        $idUsuario = Session::get('idUsuario');
        $idResponsable = Util::idResponsable($idUsuario);

        $todosReposts = DB::table('juriposteos')
            ->join('juriresponsables', 'juriposteos.juriresponsables_idResponsable', '=', 'juriresponsables.idResponsable')
            ->join('usuarios', 'juriresponsables.usuarios_idUsuario', '=', 'usuarios.idUsuario')
            ->where('juriposteos_idPosteo', '=', $request->input('idPost'))
            ->orderBy('fechaPosteo', 'DESC')
            ->get();

        return view('ajax_home.ajaxTodosReposts')
                    ->with('todosReposts', $todosReposts)
                    ->with('idResponsable', $idResponsable)
                    ->with('idPost', $request->input('idPost'));
    }

    public function actionModificarPost(Request $request)
    {
        $post = DB::table('juriposteos')
            ->where('idPosteo', '=', $request->input('idPost'))
            ->get();

        return view('ajax_home.ajaxModificarPost')
                    ->with('post', $post)
                    ->with('idPost', $request->input('idPost'));
    }

    public function actionValidarEditarPost(Request $request)
    {
        DB::table('juriposteos')
            ->where('idPosteo', $request->input('idPost'))
            ->update([
                'post' => $request->input('postModificar')]);

        return;
    }

    public function actionValidarEliminarPost(Request $request)
    {
        $posteos = DB::table('juriposteos')
            ->where('idPosteo', '=', $request->input('idPost'))
            ->get();

        if($posteos[0]->juriposteos_idPosteo == '')
        {
            $posteosHijos = DB::table('juriposteos')
                ->where('juriposteos_idPosteo', '=', $request->input('idPost'))
                ->get();

            foreach ($posteosHijos as $posteoHijo) 
            {
                $archivosHijos = DB::table('juriarchivos')
                    ->where('juriposteos_idPosteo', '=', $posteoHijo->idPosteo)
                    ->get();

                if(count($archivosHijos) > 0)
                {
                    //Se procede a quitar del servidor
                    $rutaArchivoPost= 'juriArch/posteos/'.utf8_decode($archivosHijos[0]->nombreArchivo); //Ruta completa a la imagen a borrar
                    // 1. Borra el archivo del servidor
                    unlink($rutaArchivoPost); 
                    Archivo::where('idArchivo', '=', $archivosHijos[0]->idArchivo)->delete();
                }
            }
            Post::where('juriposteos_idPosteo', '=', $request->input('idPost'))->delete();


            $archivoPost = DB::table('juriarchivos')
                ->where('juriposteos_idPosteo', '=', $request->input('idPost'))
                ->get();

            if(count($archivoPost) > 0)
            {
                //Se procede a quitar del servidor
                $rutaArchivoPost= 'juriArch/posteos/'.utf8_decode($archivoPost[0]->nombreArchivo); //Ruta completa a la imagen a borrar
                // 1. Borra el archivo del servidor
                unlink($rutaArchivoPost); 
                Archivo::where('idArchivo', '=', $archivoPost[0]->idArchivo)->delete();
            }
            Post::where('idPosteo', '=', $request->input('idPost'))->delete();

            return response()->json([
                'respuesta'  => 0,
            ]);
        }
        else
        {
            $archivoPost = DB::table('juriarchivos')
                ->where('juriposteos_idPosteo', '=', $request->input('idPost'))
                ->get();

            if(count($archivoPost) > 0)
            {
                $archivo = Archivo::find($archivoPost[0]->idArchivo);
                //Se procede a quitar del servidor
                $rutaArchivoPost= 'juriArch/posteos/'.utf8_decode($archivo->nombreArchivo); //Ruta completa a la imagen a borrar
                // 1. Borra el archivo del servidor
                unlink($rutaArchivoPost); 
            }
            Archivo::where('juriposteos_idPosteo', '=', $request->input('idPost'))->delete();

            Post::where('idPosteo', '=', $request->input('idPost'))->delete();

            $todosRePosts = DB::table('juriposteos')
                ->where('juriposteos_idPosteo', '=', $posteos[0]->juriposteos_idPosteo)
                ->count();

            return response()->json([
                'respuesta'  => 1,
                'cantidadRepost'  => $todosRePosts,
            ]);
        }
    }

    public function actionSubirArchivoPost(Request $request)
    {
        return view('ajax_home.ajaxSurbirArchivoPost');
    }

    public function actionTareasPendientes(Request $request)
    {
        $idUsuario = Session::get('idUsuario');
        $idResponsable = Util::idResponsable($idUsuario);
        $diaHoy = date('Y-m-d');

        $tareasAgenda = array();

        $agendas = DB::table('juriagendas')
            ->where('juriresponsables_idResponsable', '=', $idResponsable)
            ->where(DB::raw('substr(fechaInicioAgenda, -19, 10)'), '=', $diaHoy)
            ->get();

        if(count($agendas) > 0)
        {
            foreach ($agendas as $agenda)
            {
                $idEstadoEtapa = DB::table('juriestadosetapas')
                    ->select('idEstadoEtapa', 'juritipoprocesos_idTipoProceso')
                    ->join('juriradicados', function ($join) {
                        $join->on('juriestadosetapas.juriradicados_idRadicado', '=', 'juriradicados.idRadicado')
                            ->on('juriestadosetapas.juriradicados_vigenciaRadicado', '=', 'juriradicados.vigenciaRadicado');
                    })
                    ->where('juriestadosetapas.juriradicados_vigenciaRadicado', '=', $agenda->juriradicados_vigenciaRadicado)
                    ->where('juriestadosetapas.juriradicados_idRadicado', '=', $agenda->juriradicados_idRadicado)
                    ->orderby('idEstadoEtapa','desc')
                    ->take(1)// último registro en estado etapa
                    ->get();

                if(count($idEstadoEtapa) > 0)
                {
                    if($idEstadoEtapa[0]->juritipoprocesos_idTipoProceso == 1)
                    {
                        $rutaProceso = 'actuacionProc-judi/index/'.$idEstadoEtapa[0]->idEstadoEtapa;
                    }
                    else if($idEstadoEtapa[0]->juritipoprocesos_idTipoProceso == 2)
                    {
                        $rutaProceso = 'actuacionConci-prej/index/'.$idEstadoEtapa[0]->idEstadoEtapa;
                    }
                    else if($idEstadoEtapa[0]->juritipoprocesos_idTipoProceso == 3)
                    {
                        $rutaProceso = 'actuacionTutelas/index/'.$idEstadoEtapa[0]->idEstadoEtapa;
                    }

                    $juriradicados_vigenciaRadicado = $agenda->juriradicados_vigenciaRadicado;
                    $juriradicados_idRadicado       = $agenda->juriradicados_idRadicado;
                    $idEstadoEtapa                  = $idEstadoEtapa[0]->idEstadoEtapa;
                    $ruta                           = $rutaProceso;
                }
                else
                {
                    $juriradicados_vigenciaRadicado = '';
                    $juriradicados_idRadicado       = '';
                    $idEstadoEtapa                  = '';
                    $ruta                           = '';
                }

                $datos = array('agendaFinalizada'               => $agenda->agendaFinalizada,
                               'fechaInicioAgenda'              => $agenda->fechaInicioAgenda,
                               'asuntoAgenda'                   => $agenda->asuntoAgenda,
                               'juriradicados_vigenciaRadicado' => $juriradicados_vigenciaRadicado,
                               'juriradicados_idRadicado'       => $juriradicados_idRadicado,
                               'idEstadoEtapa'                  => $idEstadoEtapa,
                               'ruta'                           => $ruta,
                               'Id'                             => $agenda->Id);

                array_push($tareasAgenda, $datos);
            }
        }

        $cumplidas = DB::table('juriagendas')
            ->where('juriresponsables_idResponsable', '=', $idResponsable)
            ->where(DB::raw('substr(fechaInicioAgenda, -19, 10)'), '=', $diaHoy)
            ->where('agendaFinalizada', '=', 1)
            ->get();

        if(count($cumplidas) > 0) 
        {
            $porcentaje = (count($cumplidas) / count($tareasAgenda)) * 100;
        }
        else
        {
            $porcentaje = 0;
        }

        return view('ajax_home.ajaxAgendaTareas')
                    ->with('tareas', $tareasAgenda)
                    ->with('porcentaje', $porcentaje);
    }
    
    public function actionEstadoAgendaTarea(Request $request)
    {
        DB::table('juriagendas')
                ->where('Id', $request->input('idAgenda'))
                ->update([
                    'agendaFinalizada' => $request->input('accion')]);

        return; // se modificó el estado de la tarea
    }
}