<?php
namespace SQ10\Http\Controllers;

use DB;
use Excel;
use Illuminate\Http\Request;
use Session;
use SQ10\Models\Entidad;
use SQ10\Models\Responsable;
use SQ10\Models\ResponsableInterno;

class ResponsableController extends Controller
{
  	public function __construct()
    {
        $this->middleware('auth');
    }

    public function actionIndexResponsable()
    {
        return view('responsables/index');
    }

    public function actioTablaResponsables(Request $request)
    {
        $responsables = DB::table('juriresponsables')
                ->select('juriroles.nombreRol', 'juriperfiles.nombrePerfil', 'usuarios.nombresUsuario', 'juriresponsables.idResponsable', 'juriresponsables.estadoResponsable', 'juriresponsables.generarOficios', 'nombreDependencia', 'nombreCargo' ,'documentoUsuario')
                ->join('usuarios'    , 'juriresponsables.usuarios_idUsuario', 'usuarios.idUsuario')
                ->join('cargos', 'usuarios.cargos_idcargo', '=', 'cargos.idCargo')
	            ->join('dependencias', 'usuarios.dependencias_idDependencia', '=', 'dependencias.idDependencia')
                ->join('juriperfiles', 'juriresponsables.juriperfiles_idPerfil', 'juriperfiles.idPerfil')
                ->join('juriroles'   , 'juriresponsables.juriroles_idRol', 'juriroles.idRol')
                ->orderBy('usuarios.nombresUsuario', 'asc')
                ->get();

        return view('ajax_responsables.ajaxTablaResponsables')
                    ->with('responsables', $responsables);  
    }

    public function actioAgregarResponsable(Request $request)
    {
        $listaUsuarios = DB::table('usuarios')
            ->where('activoUsuario', '=', 1)
            ->orderBy('idUsuario', 'asc')
            ->pluck('nombresUsuario', 'idUsuario');

        $listaRoles = DB::table('juriroles')
            ->orderBy('idRol', 'asc')
            ->pluck('nombreRol', 'idRol');

        $listaPerfiles = DB::table('juriperfiles')
            ->orderBy('idPerfil', 'asc')
            ->pluck('nombrePerfil', 'idPerfil');

        $listaPuntosAtencion = DB::table('juripuntosatencion')
            ->orderBy('idPuntoAtencion', 'asc')
            ->pluck('nombrePuntoAtencion', 'idPuntoAtencion');

        return view('ajax_responsables.ajaxAgregarResponsable')
                    ->with('listaUsuarios', $listaUsuarios)
                    ->with('listaRoles', $listaRoles)
                    ->with('listaPerfiles', $listaPerfiles)
                    ->with('listaPuntosAtencion', $listaPuntosAtencion);
    }

    public function actioValidarGuardarResponsable(Request $request)
    {
        $responsableExiste = DB::table('juriresponsables')
        ->where('usuarios_idUsuario', '=', $request->input('selectUsuario'))
        ->count();

        if($responsableExiste == 0){
            $responsable  = new Responsable;
            $responsable->usuarios_idUsuario                  = $request->input('selectUsuario');
            $responsable->juriroles_idRol                     = $request->input('selectRol');
            $responsable->juriperfiles_idPerfil               = $request->input('selectPerfil');
            $responsable->generarOficios                      = $request->input('selectOficios');
            $responsable->juripuntosatencion_idPuntoAtencion  = $request->input('selectPunto');
            $responsable->save();
            echo "Aqui debe crearlo";
            return 1;
        } else{
            echo "No lo creo ya existe";
            return 2;
        }
    }

    public function actioEditarResponsable(Request $request)
    {
        $responsable = DB::table('juriresponsables')
                ->select('juriroles.idRol', 'juriperfiles.idPerfil', 'usuarios.idUsuario', 'idResponsable', 'juriresponsables.generarOficios', 'juripuntosatencion_idPuntoAtencion')
                ->where('idResponsable', '=', $request->input('idResponsable'))
                ->join('usuarios'    , 'juriresponsables.usuarios_idUsuario', 'usuarios.idUsuario')
                ->join('juriperfiles', 'juriresponsables.juriperfiles_idPerfil', 'juriperfiles.idPerfil')
                ->join('juriroles'   , 'juriresponsables.juriroles_idRol', 'juriroles.idRol')
                ->orderBy('usuarios.nombresUsuario', 'asc')
                ->get();

        $listaUsuarios = DB::table('usuarios')
            ->orderBy('idUsuario', 'asc')
            ->pluck('nombresUsuario', 'idUsuario');

        $listaRoles = DB::table('juriroles')
            ->orderBy('idRol', 'asc')
            ->pluck('nombreRol', 'idRol');

        $listaPerfiles = DB::table('juriperfiles')
            ->orderBy('idPerfil', 'asc')
            ->pluck('nombrePerfil', 'idPerfil');

        $listaPuntosAtencion = DB::table('juripuntosatencion')
            ->orderBy('idPuntoAtencion', 'asc')
            ->pluck('nombrePuntoAtencion', 'idPuntoAtencion');

        return view('ajax_responsables.ajaxEditarResponsable')
                    ->with('listaUsuarios', $listaUsuarios)
                    ->with('listaRoles', $listaRoles)
                    ->with('listaPerfiles', $listaPerfiles)
                    ->with('responsable', $responsable)
                    ->with('listaPuntosAtencion', $listaPuntosAtencion);
    }

    public function actioValidarEditarResponsable(Request $request)
    {
        DB::table('juriresponsables')
                ->where('idResponsable', $request->input('idResponsable'))
                ->update([
                    'usuarios_idUsuario'                 => $request->input('selectUsuarioEditar'),
                    'juriroles_idRol'                    => $request->input('selectRolEditar'),
                    'juriperfiles_idPerfil'              => $request->input('selectPerfilEditar'),
                    'generarOficios'                     => $request->input('selectOficiosEditar'),
                    'juripuntosatencion_idPuntoAtencion' => $request->input('selectPuntoEditar')]);

        return 1; // se modifico el responsable
    }

    public function actioValidarEstadoResponsable(Request $request)
    {   
        $responsable = DB::table('juriestadosetapas')
                ->where('juriresponsables_idResponsable', '=', $request->input('idResponsable'))
                ->where('juritipoestadosetapas_idTipoEstadoEtapa', '=', 1)// tipo estado activo
                ->count();

        
        if($responsable == 0 || $request->input('estadoResponsable') == 1)// sin procesos para poder activar o desactivar
        {
            DB::table('juriresponsables')
                    ->where('idResponsable', $request->input('idResponsable'))
                    ->update([
                        'estadoResponsable'     => $request->input('estadoResponsable')]);
        }
        else
        {
            return 0; // el responsable no puede ser desactivado, proceso abiertos
        }


        if($request->input('estadoResponsable') == 0)// desactivar
        {
            return 1;
        }
        else if($request->input('estadoResponsable') == 1)// activar
        {
            return 2;
        }
    }

    public function actioAgregarRespInternos(Request $request)
    {
        $listaResponsables = DB::table('juriresponsables')
                            ->join('usuarios' , 'juriresponsables.usuarios_idUsuario', 'usuarios.idUsuario')
                             ->where('estadoResponsable', '=', 1)
                            ->where('idResponsable', '!=', $request->input('idResponsable'))
                            ->orderBy('idResponsable', 'asc')
                            ->pluck('nombresUsuario', 'idResponsable');

        return view('ajax_responsables.ajaxAgregarRepartoInterno')
                    ->with('listaResponsables', $listaResponsables)
                    ->with('idResponsable', $request->input('idResponsable'));
    }

    public function actioTablaResponsablesInternos(Request $request)
    {
        $resopnsablesInt = DB::table('juriresposanblesinternos')
                            ->join('juriresponsables' , 'juriresposanblesinternos.juriresponsables_idResponsable_interno', 'juriresponsables.idResponsable')
                            ->join('usuarios' , 'juriresponsables.usuarios_idUsuario', 'usuarios.idUsuario')
                            ->where('juriresponsables_idResponsable', '=', $request->input('idResponsable'))
                            ->get();

        return view('ajax_responsables.ajaxTablaRespInternos')
                    ->with('resopnsablesInt', $resopnsablesInt)
                    ->with('idResponsable', $request->input('idResponsable'));
    }

    public function actioValidarGuardarRespInt(Request $request)
    {
        $vectorRespInt = json_decode($request->input('jsonSelectRespInt'), true);
        $noAgregadas = "";
        $canNoAgregadas = 0;

        for($i=0; $i < count($vectorRespInt); $i++)
        {
            if($vectorRespInt[$i] != '')
            {
                $responsableExiste = DB::table('juriresposanblesinternos')
                                    ->select('nombresUsuario')
                                    ->join('juriresponsables' , 'juriresposanblesinternos.juriresponsables_idResponsable_interno', 'juriresponsables.idResponsable')
                                    ->join('usuarios' , 'juriresponsables.usuarios_idUsuario', 'usuarios.idUsuario')
                                    ->where('juriresponsables_idResponsable', '=', $request->input('idResponsable'))
                                    ->where('juriresponsables_idResponsable_interno', '=', $vectorRespInt[$i])
                                    ->get();

                if(count($responsableExiste) == 0)
                {
                    $respInt = new ResponsableInterno;
                    $respInt->juriresponsables_idResponsable          = $request->input('idResponsable');
                    $respInt->juriresponsables_idResponsable_interno  = $vectorRespInt[$i];
                    $respInt->save();
                }
                else
                {
                    $canNoAgregadas = 1;

                    $noAgregadas .= $responsableExiste[0]->nombresUsuario.",";
                }
            }
        }

        return response()->json(['canNoAgregadas'    => $canNoAgregadas,
                                 'noAgregadas'       => $noAgregadas,
                                ]);
    }

    public function actioValidarElimiarRespInt(Request $request)
    {
        ResponsableInterno::where('idResponsableInterno', '=', $request->input('idRespInt'))->delete();

        return;
    }
}