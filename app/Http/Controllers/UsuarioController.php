<?php
namespace SQ10\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Session;
use SQ10\Models\Entidad;
use SQ10\Models\Usuario;

class UsuarioController extends Controller
{
	public function actionIndexusuarios()
	{
		$entidad = Entidad::find(1);

		return view('usuarios.index')
			->with('entidad', $entidad);
	}

	public function actionTablaUsuarios(Request $request)
    {
        $usuarios = DB::table('usuarios')						   
	       ->join('roles', 'usuarios.roles_idRol', '=', 'roles.idRol')
	       ->join('cargos', 'usuarios.cargos_idcargo', '=', 'cargos.idCargo')
	       ->join('dependencias', 'usuarios.dependencias_idDependencia', '=', 'dependencias.idDependencia')
	       ->where('usuarios.superUsuario','=',0)
		   ->where('usuarios.activoUsuario', '=', 1)
		   ->get();

        return view('ajax_usuarios.ajaxTablaUsuarios')
                    ->with('usuarios', $usuarios);  
    }

    public function actionAgregarUsuario(Request $request)
    {
    	$entidad = Entidad::find(1);

    	//Trae todas las dependencias y las retorna en un array				   
		$listaDependencias = DB::table('dependencias')
		   ->where('superUsuario','=',0)
		   ->orderBy('nombreDependencia', 'asc')
		   ->pluck('nombreDependencia','idDependencia');
		//Trae todos los cargos y los retorna en un array	
		$listaCargos = DB::table('cargos')
			->where('superUsuario','=',0)
		    ->orderBy('nombreCargo', 'asc')
		    ->pluck('nombreCargo','idCargo');
				  		    
	    //Trae todos los roles y los retorna en un array	
	    $listaRoles = DB::table('roles')->orderBy('nombreRol', 'asc')
	   		->pluck('nombreRol','idRol');

		$dependencias = DB::table('dependencias')
		  ->where('superUsuario','=',0)
		  ->orderBy('nombreDependencia', 'asc')
		  ->get();

		$listaDepartamentos = DB::table('departamentos')
			->orderBy('nombreDepartamento', 'asc')
			->pluck('nombreDepartamento', 'idDepartamento');

		$listaTipoIdentificacion = DB::table('tiposidentificacion')
			->orderBy('idTipoIdentificacion', 'asc')
			->pluck('nombreTipoIdentificacion','idTipoIdentificacion');

	    return view('ajax_usuarios.ajaxAgregarUsuario')    	   		  
	   		   ->with('listaCargos', $listaCargos)
	   		   ->with('listaDependencias', $listaDependencias)
	   		   ->with('listaRoles', $listaRoles)
	   		   ->with('dependencias', $dependencias)
	   		   ->with('listaDepartamentos', $listaDepartamentos)
	   		   ->with('listaTipoIdentificacion', $listaTipoIdentificacion)
	   		   ->with('entidad', $entidad);
    }

    public function actionValidarGuardarUsuario(Request $request)
    {
    	$usuario = DB::table('usuarios')
	      ->where('documentoUsuario', '=', $request->input('documentoUsuario'))
	      ->count();

	    if($usuario > 0)
	    {
	    	return 0; // el usuario ya existe
	    }

		$usuario = new Usuario;
		$usuario->documentoUsuario = $request->input('documentoUsuario');
		$usuario->nombresUsuario = $request->input('nombreUsuario')." ".$request->input('apellidoUsuario');
		$usuario->loginUsuario = strtolower($request->input('loginUsuario'));
		$usuario->password = Hash::make($request->input('documentoUsuario')); 
		$usuario->emailUsuario = strtolower($request->input('emailUsuario'));
		$usuario->celularUsuario = $request->input('celularUsuario');		
		$usuario->activoUsuario = 1;
		$usuario->roles_idRol = $request->input('selectRol');				
		$usuario->dependencias_idDependencia = $request->input('selectDependencia');
		$usuario->cargos_idcargo = $request->input('selectCargos');
		$usuario->tiposidentificacion_idTipoIdentificacion = $request->input('selectTipoIdentificacion');
		$usuario->expedicionSolicitante = $request->input('lugarExpedicion');
		$usuario->ciudades_idCiudad = $request->input('selectCiudad');
		$usuario->save();

		return 1;	// guarda el usaurio	
    }

    public function actionEditarUsuario(Request $request)
    {
    	$entidad = Entidad::find(1);

    	//Trae todas las dependencias y las retorna en un array				   
		$listaDependencias = DB::table('dependencias')
		   ->where('superUsuario','=',0)
		   ->orderBy('nombreDependencia', 'asc')
		   ->pluck('nombreDependencia','idDependencia');
		//Trae todos los cargos y los retorna en un array	
		$listaCargos = DB::table('cargos')
			->where('superUsuario','=',0)
		    ->orderBy('nombreCargo', 'asc')
		    ->pluck('nombreCargo','idCargo');
				  		    
	    //Trae todos los roles y los retorna en un array	
	    $listaRoles = DB::table('roles')->orderBy('nombreRol', 'asc')
	   		->pluck('nombreRol','idRol');

		$dependencias = DB::table('dependencias')
		  ->where('superUsuario','=',0)
		  ->orderBy('nombreDependencia', 'asc')
		  ->get();

		$listaDepartamentos = DB::table('departamentos')
			->orderBy('nombreDepartamento', 'asc')
			->pluck('nombreDepartamento', 'idDepartamento');

		$listaTipoIdentificacion = DB::table('tiposidentificacion')
			->orderBy('idTipoIdentificacion', 'asc')
			->pluck('nombreTipoIdentificacion','idTipoIdentificacion');

		$listaCiudades = DB::table('ciudades')
			->orderBy('nombreCiudad', 'asc')
			->pluck('nombreCiudad', 'idCiudad');

		$usuario = DB::table('usuarios')
			->leftJoin('subterritorios', 'usuarios.subterritorios_idSubTerritorio', '=', 'subterritorios.idSubTerritorio')
			->leftJoin('territorios', 'subterritorios.territorios_idTerritorio', '=', 'territorios.idTerritorio')
			->leftJoin('ciudades', 'usuarios.ciudades_idCiudad', '=', 'ciudades.idCiudad')
			->leftJoin('departamentos', 'ciudades.departamentos_idDepartamento', '=', 'departamentos.idDepartamento')
			->where('idUsuario', '=', $request->input('idUsuario'))
			->get();

	    return view('ajax_usuarios.ajaxEditarUsuario')    	   		  
	   		   ->with('listaCargos', $listaCargos)
	   		   ->with('listaDependencias', $listaDependencias)
	   		   ->with('listaRoles', $listaRoles)
	   		   ->with('dependencias', $dependencias)
	   		   ->with('listaDepartamentos', $listaDepartamentos)
	   		   ->with('listaCiudades', $listaCiudades)
	   		   ->with('listaTipoIdentificacion', $listaTipoIdentificacion)
	   		   ->with('usuario', $usuario)
	   		   ->with('entidad', $entidad);
    }

    public function actionValidarEditarUsuario(Request $request)
    {
    	DB::table('usuarios')
			->where('idUsuario', $request->input('idUsuario'))
			->update([
				'documentoUsuario' => $request->input('documentoUsuarioEditar'),
				'nombresUsuario' => $request->input('nombreUsuarioEditar'),
				'loginUsuario' => $request->input('loginUsuarioEditar'),
				'emailUsuario' => $request->input('emailUsuarioEditar'),
				'celularUsuario' => $request->input('celularUsuarioEditar'),
				'roles_idRol' => $request->input('selectRolEditar'),
				'dependencias_idDependencia' => $request->input('selectDependenciaEditar'),
				'cargos_idCargo' => $request->input('selectCargosEditar'),
				'expedicionSolicitante' => $request->input('lugarExpedicionEditar'),
				'direccionSolicitante' => "quitar después porque no se esta enviando",
				'tiposidentificacion_idTipoIdentificacion' => $request->input('selectTipoIdentificacionEditar'),
				'ciudades_idCiudad' => $request->input('selectCiudadEditar')]);

		return 1; // modifica el usuario
    }

    public function actionValidarDesactivarUsuario(Request $request)
    {
    	DB::table('usuarios')
			->where('idUsuario', $request->input('idUsuario'))
			->update([
				'activoUsuario' => 0]);

		return 1; // usaurio desactivado
    }

    public function actionValidarRestablcerPass(Request $request)
    {
    	$usuario = Usuario::find($request->input('idUsuario'));

    	//Actualiza los datos de la contraseña
     	$usu = DB::table('usuarios')
			   	  ->where('idUsuario', '=',$request->input('idUsuario'))
	    	      ->update(array('password' => Hash::make($usuario->documentoUsuario),
	    	      				 'cambioClave' => 1));

		return 1;      	// restablece la contraseña
    }

    public function actionCargarCiudad(Request $request)
    {
		$listaCiudad = DB::table('ciudades')
			->where('departamentos_idDepartamento', '=', $request->input('idDepartamento'))
			->orderBy('idCiudad', 'asc')
			->pluck('nombreCiudad','idCiudad');

	    return view('ajax_comunes.ajaxCiudad')    	   		  
	   		   ->with('listaCiudad', $listaCiudad);
    }

    public function actionCargarCiudadEditar(Request $request)
    {
    	$listaCiudad = DB::table('ciudades')
			->where('departamentos_idDepartamento', '=', $request->input('idDepartamento'))
			->orderBy('idCiudad', 'asc')
			->pluck('nombreCiudad','idCiudad');

	    return view('ajax_comunes.ajaxCiudadEditar')    	   		  
	   		   ->with('listaCiudad', $listaCiudad);
    }
}