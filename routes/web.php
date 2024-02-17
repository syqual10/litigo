<?php
//Comentario develop
if (version_compare(PHP_VERSION, '7.2.0', '>=')) {
	// Ignores notices and reports all other kinds... and warnings
	error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED);
	// error_reporting(E_ALL ^ E_WARNING); // Maybe this is enough
}

//Define la zona horaria exacta para cada pais.
date_default_timezone_set('America/Bogota');
setlocale(LC_TIME, 'spanish');
ini_set('max_execution_time', 0); //300 seconds = 5 minutes
ini_set("session.cookie_lifetime","14800");
ini_set("session.gc_maxlifetime","14800");

use SQ10\Models\Involucrado;
use SQ10\Models\Solicitante;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use SQ10\helpers\Util as Util;

/*
if(version_compare(PHP_VERSION, '7.2.0', '>=')) {
  error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
}*/


Route::get('/', function () {
  return redirect('/login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');



Route::group(['middleware' => 'auth'], function()
{
  Route::get('/juridica/verArchivoPdf/{idArchivo}/{vigenciaRadicado}/{idRadicado}', 'JuridicaController@actionVerArchivoPdf');
  Route::get('/juridica/verArchivoMigradoPdf/{consecutivo}', 'JuridicaController@actionVerArchivoMigradoPdf');
  Route::get('/juridica/descargarArchivo/{idArchivo}', 'JuridicaController@actionDescargarArchivo');
  Route::get('/juridica/descargarArchivoMigrado/{consecutivo}', 'JuridicaController@actionDescargarArchivoMigrado');
  Route::post('/juridica/instanciasProceso', 'JuridicaController@actionInstanciasProceso');
  Route::post('/juridica/etapasInstancia', 'JuridicaController@actionEtapasInstancia');
  Route::post('/juridica/actuacionesEtapa', 'JuridicaController@actionActuacionesEtapa');
  Route::post('/juridica/expedienteDigital', 'JuridicaController@actionExpedienteDigital');
  Route::post('/juridica/expedienteDigitalMigrados', 'JuridicaController@expedienteDigitalMigrados');
  Route::get('/juridica/descargarPoder/{vector}', 'JuridicaController@actionDescargarPoder');
  Route::post('/juridica/cambiarPass', 'JuridicaController@actionCambiarPass');
  Route::post('/juridica/validarNuevaPass', 'JuridicaController@actionValidarNuevaPass');
  Route::post('/juridica/actualizarPerfil', 'JuridicaController@actionActualizarPerfil');
  Route::post('/juridica/validarModificarUsuario', 'JuridicaController@actionValidarModificarUsuario');
  Route::post('/juridica/buscarProceso', 'JuridicaController@actionBuscarProceso');
  Route::post('/juridica/buscadorProcesos', 'JuridicaController@actionBuscadorProcesos');
  Route::post('/juridica/tareasInformativas', 'JuridicaController@actionTareasInformativas');
  Route::post('/juridica/nuevoArchivo', 'JuridicaController@actionNuevoArchivo');
  Route::post('/juridica/uploadNuevoArchivo', 'JuridicaController@actionUploadNuevoArchivo');
  Route::post('/juridica/archivosIniciales', 'JuridicaController@actionArchivosIniciales');
  Route::post('/juridica/repartoInterno', 'JuridicaController@actionRepartoInterno');
  Route::post('/juridica/validarGuardarRespInterno', 'JuridicaController@actionValidarGuardarRespInterno');
  Route::post('/juridica/validarEliminarArchivoCausa', 'JuridicaController@actionValidarEliminarArchivoCausa');
  Route::post('/juridica/cuantiasRadicado', 'JuridicaController@actionCuantiasRadicado');
  Route::post('/juridica/nuevaCuantia', 'JuridicaController@actionNuevaCuantia');
  Route::post('/juridica/validarGuardarCuantia', 'JuridicaController@actionValidarGuardarCuantia');
  Route::post('/juridica/nuevaDependenciaProceso', 'JuridicaController@actionNuevaDependenciaProceso');
  Route::post('/juridica/validarGuardarInvolucradoDepen', 'JuridicaController@actionValidarGuardarInvolucradoDepen');
  Route::post('/juridica/nuevoExterno', 'JuridicaController@actionNuevoExterno');
  Route::post('/juridica/validarGuardarNuevoExt', 'JuridicaController@actionValidarGuardarNuevoExt');
  Route::post('/juridica/editarExt', 'JuridicaController@actionEditarExt');
  Route::post('/juridica/validarEditarExt', 'JuridicaController@actionValidarEditarExt');
  Route::post('/juridica/validarEliminarAccionante', 'JuridicaController@actionValidarEliminarAccionante');
  Route::post('/juridica/nuevoAbogadoExt', 'JuridicaController@actionNuevoAbogadoExt');
  Route::post('/juridica/validarGuardarAbogadoExt', 'JuridicaController@actionValidarGuardarAbogadoExt');
  Route::post('/juridica/editarAbogadoExt', 'JuridicaController@actionEditarAbogadoExt');
  Route::post('/juridica/validarEditarAbogadoExt', 'JuridicaController@actionValidarEditarAbogadoExt');
  Route::post('/juridica/validarEliminarAbogadoExt', 'JuridicaController@actionValidarEliminarAbogadoExt');
  Route::get('/juridica/caratula/{vector}', 'JuridicaController@actionCaratula');
  Route::get('/juridica/buscar', 'JuridicaController@actionBuscar');
  Route::post('/juridica/agregarApoderado', 'JuridicaController@actionAgregarApoderado');
  Route::post('/juridica/validarGuardarApoderadoNuevo', 'JuridicaController@actionValidarGuardarApoderadoNuevo');
  Route::post('/juridica/searchTema', 'JuridicaController@actionSearchTema');
  Route::post('/juridica/actuacionesProceso', 'JuridicaController@actionActuacionesProceso');
  Route::post('/juridica/validarEliminarCuantia', 'JuridicaController@actionValidarEliminarCuantia');
  Route::post('/juridica/nodalAsociarProceso', 'JuridicaController@actionModalAsociarProceso');
  Route::post('/juridica/asociarProceso', 'JuridicaController@actionAsociarProceso');
  Route::post('/juridica/trasladarAccionante', 'JuridicaController@actionTrasladarAccionante');
});

//CL 20 A CR 21-30 OFICINA 503

Route::group(['middleware' => 'auth'], function()
{
  Route::post('/home/editarFoto', 'HomeController@actionEditarFoto');
  Route::post('/home/subirFoto', 'HomeController@actionSubirFoto');
  Route::post('/home/validarGuardarPosteo', 'HomeController@actionValidarGuardarPosteo');
  Route::post('/home/posteos', 'HomeController@actionPosteos');
  Route::post('/home/validarGuardarRepost', 'HomeController@actionValidarGuardarRepost');
  Route::post('/home/mostrarTodosRepost', 'HomeController@actionMostrarTodosRepost');
  Route::post('/home/modificarPost', 'HomeController@actionModificarPost');
  Route::post('/home/validarEditarPost', 'HomeController@actionValidarEditarPost');
  Route::post('/home/validarEliminarPost', 'HomeController@actionValidarEliminarPost');
  Route::post('/home/subirArchivoPost', 'HomeController@actionSubirArchivoPost');
  Route::post('/home/uploadArchivoPost', 'HomeController@actionUploadArchivoPost');
  Route::post('/home/loadMorePost', 'HomeController@actionLoadMorePost');
  Route::get('/home/descargarArchivoPost/{idArchivo}', 'HomeController@actionDescargarArchivoPost');
  Route::post('/home/tareasPendientes', 'HomeController@actionTareasPendientes');
  Route::post('/home/estadoAgendaTarea', 'HomeController@actionEstadoAgendaTarea');
});

Route::group(['middleware' => 'auth'], function()
{
  Route::get('/cargos/index', 'CargoController@actionIndexcargos');
  Route::post('/cargos/agregarCargo', 'CargoController@actionAgregarCargo');
  Route::post('/cargos/tablaCargos', 'CargoController@actionTablaCargos');
  Route::post('/cargos/validarGuardarCargo', 'CargoController@actionValidarGuardarCargo');
  Route::post('/cargos/editarCargo', 'CargoController@actionEditarCargo');
  Route::post('/cargos/validarEditarCargo', 'CargoController@actionValidarEditarCargo');
  Route::post('/cargos/validarEliminarCargo', 'CargoController@actionValidarEliminarCargo');
});

Route::group(['middleware' => 'auth'], function()
{
  Route::get('/dependencias/index', 'DependenciaController@actionIndexdependencias');
  Route::post('/dependencias/tablaDependencias', 'DependenciaController@actionTablaDependencias');
  Route::post('/dependencias/agregarDependencia', 'DependenciaController@actionAgregarDependencia');
  Route::post('/dependencias/validarGuardarDependencia', 'DependenciaController@actionValidarGuardarDependencia');
  Route::post('/dependencias/editarDependencia', 'DependenciaController@actionEditarDependencia');
  Route::post('/dependencias/validarEditarDependencia', 'DependenciaController@actionValidarEditarDependencia');
  Route::post('/dependencias/validarEliminarDependencia', 'DependenciaController@actionValidarEliminarDependencia');
});

Route::group(['middleware' => 'auth'], function()
{
  Route::get('/usuarios/index', 'UsuarioController@actionIndexusuarios');
  Route::post('/usuarios/tablaUsuarios', 'UsuarioController@actionTablaUsuarios');
  Route::post('/usuarios/agregarUsuario', 'UsuarioController@actionAgregarUsuario');
  Route::post('/usuarios/validarGuardarUsuario', 'UsuarioController@actionValidarGuardarUsuario');
  Route::post('/usuarios/editarUsuario', 'UsuarioController@actionEditarUsuario');
  Route::post('/usuarios/validarEditarUsuario', 'UsuarioController@actionValidarEditarUsuario');
  Route::post('/usuarios/validarDesactivarUsuario', 'UsuarioController@actionValidarDesactivarUsuario');
  Route::post('/usuarios/validarRestablcerPass', 'UsuarioController@actionValidarRestablcerPass');
  Route::post('/usuarios/cargarCiudad', 'UsuarioController@actionCargarCiudad');
  Route::post('/usuarios/cargarCiudadEditar', 'UsuarioController@actionCargarCiudadEditar');
});


Route::group(['middleware' => 'auth'], function()
{
  Route::get('/accionesDefensa/index', 'AccionDefensaController@actionIndexaccionesDefensa');
  Route::post('/accionesDefensa/tablaAccionDefensa', 'AccionDefensaController@actionTablaAccionDefensa');
  Route::post('/accionesDefensa/agregarAccionDefensa', 'AccionDefensaController@actionAgregarAccionDefensa');
  Route::post('/accionesDefensa/validarGuardarAccionDefensa', 'AccionDefensaController@actionValidarGuardarAccionDefensa');
  Route::post('/accionesDefensa/editarAccionDefensa', 'AccionDefensaController@actionEditarAccionDefensa');
  Route::post('/accionesDefensa/validarEditarAccionDefensa', 'AccionDefensaController@actionValidarEditarAccionDefensa');
  Route::post('/accionesDefensa/validarEliminarAccionDefensa', 'AccionDefensaController@actionValidarEliminarAccionDefensa');
});

Route::group(['middleware' => 'auth'], function()
{
  Route::get('/estadosRadicado/index', 'EstadosRadicadoController@actionIndexestadosRadicado');
  Route::post('/estadosRadicado/tablaEstadoRadicado', 'EstadosRadicadoController@actionTablaEstadosRadicado');
  Route::post('/estadosRadicado/agregarEstadoRadicado', 'EstadosRadicadoController@actionAgregarEstadosRadicado');
  Route::post('/estadosRadicado/validarGuardarEstadoRadicado', 'EstadosRadicadoController@actionValidarGuardarEstadosRadicado');
  Route::post('/estadosRadicado/editarEstadoRadicado', 'EstadosRadicadoController@actionEditarEstadosRadicado');
  Route::post('/estadosRadicado/validarEditarEstadoRadicado', 'EstadosRadicadoController@actionValidarEditarEstadosRadicado');
  Route::post('/estadosRadicado/validarEliminarEstadoRadicado', 'EstadosRadicadoController@actionValidarEliminarEstadosRadicado');
});

Route::group(['middleware' => 'auth'], function()
{
  Route::get('/perfiles/index', 'PerfilController@actionIndexperfil');
  Route::post('/perfiles/tablaPerfiles', 'PerfilController@actionTablaPerfiles');
  Route::post('/perfiles/agregarPerfil', 'PerfilController@actionAgregarPerfiles');
  Route::post('/perfiles/validarGuardarPerfil', 'PerfilController@actionValidarGuardarPerfiles');
  Route::post('/perfiles/editarPerfil', 'PerfilController@actionEditarPerfiles');
  Route::post('/perfiles/validarEditarPerfil', 'PerfilController@actionValidarEditarPerfiles');
  Route::post('/perfiles/validarEliminarPerfil', 'PerfilController@actionValidarEliminarPerfiles');
});

Route::group(['middleware' => 'auth'], function()
{
  Route::get('/temas/index', 'TemaController@actionIndextema');
  Route::post('/temas/tablaTemas', 'TemaController@actionTablaTemas');
  Route::post('/temas/agregarTema', 'TemaController@actionAgregarTemas');
  Route::post('/temas/validarGuardarTema', 'TemaController@actionValidarGuardarTema');
  Route::post('/temas/editarTema', 'TemaController@actionEditarTema');
  Route::post('/temas/validarEditarTema', 'TemaController@actionValidarEditarTema');
  Route::post('/temas/validarEliminarTema', 'TemaController@actionValidarEliminarTema');
  Route::get('/temas/masivo', 'TemaController@actionMasivo');
  Route::post('/temas/traer-radicados', 'TemaController@actionTraerRadicados');
  Route::post('/temas/establecer-tema-masivo', 'TemaController@actionEstablecerTemaMasivo');
});

Route::group(['middleware' => 'auth'], function()
{
  Route::get('/causas/index', 'CausaController@actionIndexcausa');
  Route::post('/causas/tablaCausa', 'CausaController@actionTablaCausa');
  Route::post('/causas/agregarCausa', 'CausaController@actionAgregarCausa');
  Route::post('/causas/validarGuardarCausa', 'CausaController@actionValidarGuardarCausa');
  Route::post('/causas/editarCausa', 'CausaController@actionEditarCausa');
  Route::post('/causas/validarEditarCausa', 'CausaController@actionValidarEditarCausa');
  Route::post('/causas/validarEliminarCausa', 'CausaController@actionValidarEliminarCausa');
});

Route::group(['middleware' => 'auth'], function()
{
  Route::get('/tipoBitacoras/index', 'TipoBitacoraController@actionIndextipoBitacora');
  Route::post('/tipoBitacoras/tablaTipoBitacora', 'TipoBitacoraController@actionTablaTipoBitacora');
  Route::post('/tipoBitacoras/agregarTipoBitacora', 'TipoBitacoraController@actionAgregarTipoBitacora');
  Route::post('/tipoBitacoras/validarGuardarTipoBitacora', 'TipoBitacoraController@actionValidarGuardarTipoBitacora');
  Route::post('/tipoBitacoras/editarTipoBitacora', 'TipoBitacoraController@actionEditarTipoBitacora');
  Route::post('/tipoBitacoras/validarEditarTipoBitacora', 'TipoBitacoraController@actionValidarEditarTipoBitacora');
  Route::post('/tipoBitacoras/validarEliminarTipoBitacora', 'TipoBitacoraController@actionValidarEliminarTipoBitacora');
});

Route::group(['middleware' => 'auth'], function()
{
  Route::get('/estadosEtapas/index', 'TipoEstadoEtapaController@actionIndextipoestadoEtapa');
  Route::post('/estadosEtapas/tablaTipoEstadoEtapa', 'TipoEstadoEtapaController@actionTablaTipoEstadoEtapa');
  Route::post('/estadosEtapas/agregartipoEstadoEtapa', 'TipoEstadoEtapaController@actionAgregarTipoEstadoEtapa');
  Route::post('/estadosEtapas/validarGuardarTipoEstadoEtapa', 'TipoEstadoEtapaController@actionValidarGuardarTipoEstadoEtapa');
  Route::post('/estadosEtapas/editartipoEstadoEtapa', 'TipoEstadoEtapaController@actionEditarTipoEstadoEtapa');
  Route::post('/estadosEtapas/validarEditarTipoEstadoEtapa', 'TipoEstadoEtapaController@actionValidarEditarTipoEstadoEtapa');
  Route::post('/estadosEtapas/validarEliminarTipoEstadoEtapa', 'TipoEstadoEtapaController@actionValidarEliminarTipoEstadoEtapa');
});

Route::group(['middleware' => 'auth'], function()
{
  Route::get('/tiposProcesos/index', 'TipoProcesoController@actionIndextipoproceso');
  Route::post('/tiposProcesos/tablaTipoProcesos', 'TipoProcesoController@actionTablaTipoProcesos');
  Route::post('/tiposProcesos/agregarTipoProceso', 'TipoProcesoController@actionAgregarTipoProceso');
  Route::post('/tiposProcesos/validarGuardarTipoProceso', 'TipoProcesoController@actionValidarGuardarTipoProceso');
  Route::post('/tiposProcesos/editarTipoProceso', 'TipoProcesoController@actionEditarTipoProceso');
  Route::post('/tiposProcesos/validarEditarTipoProceso', 'TipoProcesoController@actionValidarEditarTipoProceso');
  Route::post('/tiposProcesos/validarEliminarTipoProceso', 'TipoProcesoController@actionValidarEliminarTipoProceso');
});

Route::group(['middleware' => 'auth'], function()
{
  Route::get('/configurarProceso/index/{tipoProceso}', 'ConfigurarController@actionIndexConfigurar');
  Route::post('/configurarProceso/isntanciasTipoProceso', 'ConfigurarController@actionIsntanciasTipoProceso');
  Route::post('/configurarProceso/agregarInstancia', 'ConfigurarController@actionAgregarInstancia');
  Route::post('/configurarProceso/validarGuardarInstancia', 'ConfigurarController@actionValidarGuardarInstancia');
  Route::post('/configurarProceso/editarInstancia', 'ConfigurarController@actionEditarInstancia');
  Route::post('/configurarProceso/validarEditarInstancia', 'ConfigurarController@actionValidarEditarInstancia');
  Route::post('/configurarProceso/validarEliminarInstancia', 'ConfigurarController@actionValidarEliminarInstancia');
  Route::post('/configurarProceso/etapasInstancia', 'ConfigurarController@actionEtapasInstancia');
  Route::post('/configurarProceso/agregarEtapa', 'ConfigurarController@actionAgregarEtapa');
  Route::post('/configurarProceso/validarGuardarEtapaInstancia', 'ConfigurarController@actionValidarGuardarEtapaInstancia');
  Route::post('/configurarProceso/editarEtapa', 'ConfigurarController@actionEditarEtapa');
  Route::post('/configurarProceso/validarEditarEtapaInstancia', 'ConfigurarController@actionValidarEditarEtapaInstancia');
  Route::post('/configurarProceso/validarEliminarEtapa', 'ConfigurarController@actionValidarEliminarEtapa');
  Route::post('/configurarProceso/agregarPasoPadre', 'ConfigurarController@actionAgregarPasoPadre');
  Route::post('/configurarProceso/validarGuardarPaso', 'ConfigurarController@actionValidarGuardarPaso');
  Route::post('/configurarProceso/pasosPadre', 'ConfigurarController@actionPasosPadre');
  Route::post('/configurarProceso/editarPasoPadre', 'ConfigurarController@actionEditarPasoPadre');
  Route::post('/configurarProceso/validarEditarPaso', 'ConfigurarController@actionValidarEditarPaso');
  Route::post('/configurarProceso/validarEstadoPaso', 'ConfigurarController@actionValidarEstadoPaso');
  Route::post('/configurarProceso/agregarPasoHijo', 'ConfigurarController@actionAgregarPasoHijo');
  Route::post('/configurarProceso/pasosHijo', 'ConfigurarController@actionPasosHijo');
  Route::post('/configurarProceso/editarPasoHijo', 'ConfigurarController@actionEditarPasoHijo');
  Route::post('/configurarProceso/validarOrdenaPadre', 'ConfigurarController@actionValidarOrdenaPadre');
  Route::post('/configurarProceso/validarOrdenaHijo', 'ConfigurarController@actionValidarOrdenaHijo');
  Route::post('/configurarProceso/tiposActuaciones', 'ConfigurarController@actionTiposActuaciones');
  Route::post('/configurarProceso/agregarTipoActuacion', 'ConfigurarController@actionAgregarTipoActuacion');
  Route::post('/configurarProceso/validarGuardarTipoActuacion', 'ConfigurarController@actionValidarGuardarTipoActuacion');
  Route::post('/configurarProceso/editarTipoActuacion', 'ConfigurarController@actionEditarTipoActuacion');
  Route::post('/configurarProceso/validarEditarTipoActuacion', 'ConfigurarController@actionValidarEditarTipoActuacion');
  Route::post('/configurarProceso/validarEstadoTipoActuacion', 'ConfigurarController@actionValidarEstadoTipoActuacion');
  Route::post('/configurarProceso/modulosTiposProceso', 'ConfigurarController@actionModulosTiposProceso');
  Route::post('/configurarProceso/estadoModulo', 'ConfigurarController@actionEstadoModulo');
});

Route::group(['middleware' => 'auth'], function()
{
  Route::get('/tiposImpactos/index', 'TipoImpactoController@actionIndextipoimpacto');
  Route::post('/tiposImpactos/tablaImpactos', 'TipoImpactoController@actionTablaImpactos');
  Route::post('/tiposImpactos/agregarImpacto', 'TipoImpactoController@actionAgregarImpacto');
  Route::post('/tiposImpactos/validarGuardarImpacto', 'TipoImpactoController@actionValidarGuardarImpacto');
  Route::post('/tiposImpactos/editarImpacto', 'TipoImpactoController@actionEditarImpacto');
  Route::post('/tiposImpactos/validarEditarImpacto', 'TipoImpactoController@actionValidarEditarImpacto');
});

Route::group(['middleware' => 'auth'], function()
{
  Route::get('/tiposActosAdmin/index', 'TipoActoAdministrativoController@actionIndextipoacto');
  Route::post('/tiposActosAdmin/tablaTiposActos', 'TipoActoAdministrativoController@actionTablaTiposActos');
  Route::post('/tiposActosAdmin/agregarTipoActoAdministrativo', 'TipoActoAdministrativoController@actionAgregarTipoActoAdministrativo');
  Route::post('/tiposActosAdmin/validarGuardarTipoActo', 'TipoActoAdministrativoController@actionValidarGuardarTipoActo');
  Route::post('/tiposActosAdmin/editarTipoActo', 'TipoActoAdministrativoController@actionEditarTipoActo');
  Route::post('/tiposActosAdmin/validarEditarTipoActo', 'TipoActoAdministrativoController@actionValidarEditarTipoActo');
  Route::post('/tiposActosAdmin/validarEliminarTipoActo', 'TipoActoAdministrativoController@actionValidarEliminarTipoActo');
});

Route::group(['middleware' => 'auth'], function()
{
  Route::get('/mediosControl/index', 'MedioControlController@actionIndexmedioControl');
  Route::post('/mediosControl/tablaMediosControl', 'MedioControlController@actionTablaMediosControl');
  Route::post('/mediosControl/agregarMediosControl', 'MedioControlController@actionAgregarMediosControl');
  Route::post('/mediosControl/validarGuardarMedioControl', 'MedioControlController@actionValidarGuardarMedioControl');
  Route::post('/mediosControl/editarMedioControl', 'MedioControlController@actionEditarMedioControl');
  Route::post('/mediosControl/validarEditarMedioControl', 'MedioControlController@actionValidarEditarMedioControl');
  Route::post('/mediosControl/validarEliminarMedioControl', 'MedioControlController@actionValidarEliminarMedioControl');
});

Route::group(['middleware' => 'auth'], function()
{
  Route::get('/autoridades/index', 'AutoridadController@actionIndexautoridad');
  Route::post('/autoridades/tablaAutoridades', 'AutoridadController@actionTablaAutoridades');
  Route::post('/autoridades/agregarAutoridad', 'AutoridadController@actionAgregarAutoridad');
  Route::post('/autoridades/validarGuardarAutoridad', 'AutoridadController@actionValidarGuardarAutoridad');
  Route::post('/autoridades/editarAutoridad', 'AutoridadController@actionEditarAutoridad');
  Route::post('/autoridades/validarModificarAutoridad', 'AutoridadController@actionValidarModificarAutoridad');
  Route::post('/autoridades/validarEliminarAutoridad', 'AutoridadController@actionValidarEliminarAutoridad');
});

Route::group(['middleware' => 'auth'], function()
{
  Route::get('/ipc/index', 'IPCController@actionIndexIpc');
  Route::post('/ipc/tablaIpc', 'IPCController@actionTablaIPC');
  Route::post('/ipc/agregarIPC', 'IPCController@actionAgregarIPC');
  Route::post('/ipc/validarGuardarIpc', 'IPCController@actionValidarGuardarIpc');
  Route::post('/ipc/editarIPC', 'IPCController@actioneditarIPC');
  Route::post('/ipc/validarEditarIpc', 'IPCController@actionValidarEditarIpc');
  Route::post('/ipc/validarEliminarIPC', 'IPCController@actionValidarEliminarIPC');
});

Route::group(['middleware' => 'auth'], function()
{
  Route::get('/demandas/index', 'DemandaController@actionIndexDemandas');
});

Route::group(['middleware' => 'auth'], function()
{
  Route::get('/mis-procesos/index/{tablaConsolidado}/{tipoProceso}/{idResponsable}', 'MisProcesosController@actionindexmisprocesos');
  Route::post('/mis-procesos/consolidado', 'MisProcesosController@actionConsolidado');
  Route::post('/mis-procesos/tablaProcesosConsolidado', 'MisProcesosController@actionTablaProcesosConsolidado');
});

Route::group(['middleware' => 'auth'], function()
{
  Route::get('/proceso-judic/index/{idTipoProceso}', 'ProcesoJudicialController@actionIndex');
  Route::post('/proceso-judic/cargarJuzgado', 'ProcesoJudicialController@actionCargarJuzgado');
  Route::post('/proceso-judic/busquedaDemandante', 'ProcesoJudicialController@actionBusquedaDemandante');
  Route::post('/proceso-judic/seleccioneDemandante', 'ProcesoJudicialController@actionSeleccioneDemandante');
  Route::post('/proceso-judic/nuevoDemandante', 'ProcesoJudicialController@actionNuevoDemandante');
  Route::post('/proceso-judic/elegirBarrioDemandante', 'ProcesoJudicialController@actionElegirBarrioDemandante');
  Route::post('/proceso-judic/elegirBarrioDemandanteEditar', 'ProcesoJudicialController@actionElegirBarrioDemandanteEditar');
  Route::post('/proceso-judic/validarGuardarDemandante', 'ProcesoJudicialController@actionValidarGuardarDemandante');
  Route::post('/proceso-judic/editarDemandante', 'ProcesoJudicialController@actionEditarDemandante');
  Route::post('/proceso-judic/validarEditarDemandante', 'ProcesoJudicialController@actionValidarEditarDemandante');
  Route::post('/proceso-judic/searchDependencia', 'ProcesoJudicialController@actionSearchDependencia');
  Route::post('/proceso-judic/seleccioneDemandado', 'ProcesoJudicialController@actionSeleccioneDemandado');
  Route::post('/proceso-judic/nuevoDemandando', 'ProcesoJudicialController@actionNuevoDemandando');
  Route::post('/proceso-judic/elegirBarrioDemandado', 'ProcesoJudicialController@actionElegirBarrioDemandado');
  Route::post('/proceso-judic/elegirBarrioDemandadoEditar', 'ProcesoJudicialController@actionElegirBarrioDemandadoEditar');
  Route::post('/proceso-judic/validarGuardarDemandado', 'ProcesoJudicialController@actionValidarGuardarDemandado');
  Route::post('/proceso-judic/editarDemandado', 'ProcesoJudicialController@actionEditarDemandado');
  Route::post('/proceso-judic/validarEditarDemandado', 'ProcesoJudicialController@actionValidarEditarDemandado');
  Route::post('/proceso-judic/validarGuardarRadicado', 'ProcesoJudicialController@actionValidarGuardarRadicado');
  Route::post('/proceso-judic/opcionesPostRadicado', 'ProcesoJudicialController@actionOpcionesPostRadicado');
  Route::get('/proceso-judic/informacionPdf/{vigenciaRadicado}/{idRadicado}', 'ProcesoJudicialController@actionInformacionPdf');
  Route::post('/proceso-judic/nuevoAbogado', 'ProcesoJudicialController@actionNuevoAbogado');
  Route::post('/proceso-judic/validarGuardarAbogado', 'ProcesoJudicialController@actionValidarGuardarAbogado');
  Route::post('/proceso-judic/busquedaAbogadoDemandante', 'ProcesoJudicialController@actionBusquedaAbogadoDemandante');
  Route::post('/proceso-judic/seleccioneAbogado', 'ProcesoJudicialController@actionSeleccioneAbogado');
  Route::post('/proceso-judic/editarAbogado', 'ProcesoJudicialController@actionEditarAbogado');
  Route::post('/proceso-judic/validarEditarAbogado', 'ProcesoJudicialController@actionValidarEditarAbogado');
  Route::post('/proceso-judic/temas', 'ProcesoJudicialController@actionTemas');
  Route::post('/proceso-judic/mediosControl', 'ProcesoJudicialController@actionMediosControl');
  Route::post('/proceso-judic/agregarTema', 'ProcesoJudicialController@actionAgregarTemas');
  Route::post('/proceso-judic/validarGuardarTema', 'ProcesoJudicialController@actionValidarGuardarTema');
  Route::post('/proceso-judic/cambiarVigenciaProceso', 'ProcesoJudicialController@actionCambiarVigenciaProceso');
  Route::post('/proceso-judic/iniciarDropzoneRadica', 'ProcesoJudicialController@actionIniciarDropzoneRadica');
  Route::post('/proceso-judic/uploadArchivoRadicacion', 'ProcesoJudicialController@actionUploadArchivoRadicacion');
  Route::post('/proceso-judic/nuevaEntidadExt', 'ProcesoJudicialController@actionNuevaEntidadExt');
  Route::post('/proceso-judic/validarGuardarEntidadExt', 'ProcesoJudicialController@actionValidarGuardarEntidadExt');
  Route::post('/proceso-judic/seleccioneEntidadExt', 'ProcesoJudicialController@actionSeleccioneEntidadExt');
  Route::post('/proceso-judic/busquedaEntidadExt', 'ProcesoJudicialController@actionBusquedaEntidadExt');
  Route::post('/proceso-judic/editarEntidadExt', 'ProcesoJudicialController@actionEditarEntidadExt');
  Route::post('/proceso-judic/validarEditarEntidadExt', 'ProcesoJudicialController@actionValidarEditarEntidadExt');
  Route::post('/proceso-judic/datosAnterioresConci', 'ProcesoJudicialController@actionDatosAnterioresConci');
});

Route::group(['middleware' => 'auth'], function()
{
  Route::get('/concil-prej/index/{idTipoProceso}', 'ConciliaPrejuController@actionIndex');
  Route::post('/concil-prej/busquedaConvocante', 'ConciliaPrejuController@actionBusquedaConvocante');
  Route::post('/concil-prej/seleccioneConvocante', 'ConciliaPrejuController@actionSeleccioneConvocante');
  Route::post('/concil-prej/nuevoConvocante', 'ConciliaPrejuController@actionNuevoConvocante');
  Route::post('/concil-prej/elegirBarrioConvocante', 'ConciliaPrejuController@actionElegirBarrioConvocante');
  Route::post('/concil-prej/validarGuardarConvocante', 'ConciliaPrejuController@actionValidarGuardarConvocante');
  Route::post('/concil-prej/editarConvocante', 'ConciliaPrejuController@actionEditarConvocante');
  Route::post('/concil-prej/validarEditarConvocante', 'ConciliaPrejuController@actionvalidarEditarConvocante');
  Route::post('/concil-prej/busquedaConvocadoInt', 'ConciliaPrejuController@actionBusquedaConvocadoInt');
  Route::post('/concil-prej/seleccioneConvocadoInt', 'ConciliaPrejuController@actionSeleccioneConvocadoInt');
  Route::post('/concil-prej/busquedaConvocadoExt', 'ConciliaPrejuController@actionBusquedaConvocadoExt');
  Route::post('/concil-prej/seleccioneConvocadoExt', 'ConciliaPrejuController@actionSeleccioneConvocadoExt');
  Route::post('/concil-prej/nuevoConvocadoExt', 'ConciliaPrejuController@actionNuevoConvocadoExt');
  Route::post('/concil-prej/validarGuardarConvocadoExt', 'ConciliaPrejuController@actionValidarGuardarConvocadoExt');
  Route::post('/concil-prej/editarConvocadoExt', 'ConciliaPrejuController@actionEditarConvocadoExt');
  Route::post('/concil-prej/validarEditarConvocadoExt', 'ConciliaPrejuController@actionValidarEditarConvocadoExt');
  Route::post('/concil-prej/validarGuardarRadicado', 'ConciliaPrejuController@actionValidarGuardarRadicado');
  Route::get('/concil-prej/informacionPdf/{vigenciaRadicado}/{idRadicado}', 'ConciliaPrejuController@actionInformacionPdf');
  Route::post('/concil-prej/iniciarDropzoneRadica', 'ConciliaPrejuController@actionIniciarDropzoneRadica');
  Route::post('/concil-prej/uploadArchivoRadicacion', 'ConciliaPrejuController@actionUploadArchivoRadicacion');
  Route::post('/concil-prej/nuevoAbogado', 'ConciliaPrejuController@actionNuevoAbogado');
  Route::post('/concil-prej/seleccioneAbogado', 'ConciliaPrejuController@actionSeleccioneAbogado');
  Route::post('/concil-prej/validarGuardarAbogado', 'ConciliaPrejuController@actionValidarGuardarAbogado');
  Route::post('/concil-prej/busquedaAbogadoDemandante', 'ConciliaPrejuController@actionBusquedaAbogadoDemandante');
  Route::post('/concil-prej/editarAbogado', 'ConciliaPrejuController@actionEditarAbogado');
  Route::post('/concil-prej/validarEditarAbogado', 'ConciliaPrejuController@actionValidarEditarAbogado');
});

Route::group(['middleware' => 'auth'], function()
{
  Route::get('/tutelas/index/{idTipoProceso}', 'TutelaController@actionIndex');
  Route::post('/tutelas/busquedaAccionante', 'TutelaController@actionBusquedaAccionante');
  Route::post('/tutelas/seleccioneAccionante', 'TutelaController@actionSeleccioneAccionante');
  Route::post('/tutelas/nuevoAccionante', 'TutelaController@actionNuevoAccionante');
  Route::post('/tutelas/elegirBarrioAccionante', 'TutelaController@actionElegirBarrioAccionante');
  Route::post('/tutelas/validarGuardarAccionante', 'TutelaController@actionValidarGuardarAccionante');
  Route::post('/tutelas/editarAccionante', 'TutelaController@actionEditarAccionante');
  Route::post('/tutelas/elegirBarrioAccionanteEditar', 'TutelaController@actionElegirBarrioAccionanteEditar');
  Route::post('/tutelas/validarEditarAccionante', 'TutelaController@actionValidarEditarAccionante');
  Route::post('/tutelas/busquedaAccionadoInt', 'TutelaController@actionBusquedaAccionadoInt');
  Route::post('/tutelas/seleccioneAccionadoInt', 'TutelaController@actionSeleccioneAccionadoInt');
  Route::post('/tutelas/busquedaAccionadoExt', 'TutelaController@actionBusquedaAccionadoExt');
  Route::post('/tutelas/seleccioneAccionadoExt', 'TutelaController@actionSeleccioneAccionadoExt');
  Route::post('/tutelas/editarAccionadoExt', 'TutelaController@actionEditarAccionadoExt');
  Route::post('/tutelas/nuevoAccionadoExt', 'TutelaController@actionNuevoAccionadoExt');
  Route::post('/tutelas/validarGuardarAccionadoExt', 'TutelaController@actionValidarGuardarAccionadoExt');
  Route::post('/tutelas/validarEditarAccionadoExt', 'TutelaController@actionValidarEditarAccionadoExt');
  Route::post('/tutelas/temas', 'TutelaController@actionTemas');
  Route::post('/tutelas/agregarTema', 'TutelaController@actionAgregarTema');
  Route::post('/tutelas/validarGuardarTema', 'TutelaController@actionValidarGuardarTema');
  Route::post('/tutelas/validarGuardarRadicado', 'TutelaController@actionValidarGuardarRadicado');
  Route::post('/tutelas/cargarJuzgado', 'TutelaController@actionCargarJuzgado');
  Route::get('/tutelas/informacionPdf/{vigenciaRadicado}/{idRadicado}', 'TutelaController@actionInformacionPdf');
  Route::post('/tutelas/iniciarDropzoneRadica', 'TutelaController@actionIniciarDropzoneRadica');
  Route::post('/tutelas/uploadArchivoRadicacion', 'TutelaController@actionUploadArchivoRadicacion');
  Route::post('/tutelas/plazoPersonalizado', 'TutelaController@actionPlazoPersonalizado');
});

Route::group(['middleware' => 'auth'], function()
{
  Route::get('/reportes/index/{reporte}', 'ReporteController@actionIndexReportes');
  Route::post('/reportes/reporteTabla', 'ReporteController@actionReporteTabla');
  Route::get('/reportes/reporteExcel/{vector}', 'ReporteController@actionReporteExcel');

  Route::get('reportes/crear-reporte', 'ReporteController@actionCrearReporte');
  Route::get('/reportes/crear-reporte-excel/{vector}', 'ReporteController@actionCrearReporteExcel');
  Route::get('/reportes/formulario-crear-reportes', 'ReporteController@actionFormularioCrearReportes');
  

  
  
});

Route::group(['middleware' => 'auth'], function()
{
  Route::get('/reparto/index/{idEstadoEtapa}', 'RepartoController@actionIndexReparto');
  Route::post('/reparto/validarGuardarReparto', 'RepartoController@actionValidarGuardarReparto');
  Route::post('/reparto/validarAsignarReparto', 'RepartoController@actionValidarAsignarReparto');
});

Route::group(['middleware' => 'auth'], function()
{
  Route::get('/actuacionConci-prej/index/{idEstadoEtapa}', 'ActuacionConciPrejuController@actionIndexActuacionConciPreju');
  Route::post('/actuacionConci-prej/pasosAbogado', 'ActuacionConciPrejuController@actionPasosAbogado');
  Route::post('/actuacionConci-prej/marcarPaso', 'ActuacionConciPrejuController@actionMarcarPaso');
  Route::post('/actuacionConci-prej/modalMarcarPaso', 'ActuacionConciPrejuController@actionModalMarcarPaso');
  Route::post('/actuacionConci-prej/agregarConvocante', 'ActuacionConciPrejuController@actionAgregarConvocante');
  Route::post('/actuacionConci-prej/validarGuardarConvocante', 'ActuacionConciPrejuController@actionValidarGuardarConvocante');
  Route::post('/actuacionConci-prej/convocantes', 'ActuacionConciPrejuController@actionConvocantes');
  Route::post('/actuacionConci-prej/modificarDatosGenerales', 'ActuacionConciPrejuController@actionModificarDatosGenerales');
  Route::post('/actuacionConci-prej/validarEditarDatosGenerales', 'ActuacionConciPrejuController@actionValidarEditarDatosGenerales');
  Route::post('/actuacionConci-prej/involucradoProceso', 'ActuacionConciPrejuController@actionInvolucradoProceso');
  Route::post('/actuacionConci-prej/validarEliminarConvocante', 'ActuacionConciPrejuController@actionValidarEliminarConvocante');
  Route::post('/actuacionConci-prej/convocadosInternos', 'ActuacionConciPrejuController@actionConvocadosInternos');
  Route::post('/actuacionConci-prej/validarRemoverConvocadoInt', 'ActuacionConciPrejuController@actionValidarRemoverConvocadoInt');
  Route::post('/actuacionConci-prej/accionadosExternos', 'ActuacionConciPrejuController@actionAccionadosExternos');
  Route::post('/actuacionConci-prej/abogadosExternos', 'ActuacionConciPrejuController@actionAbogadosExternos');
});

Route::group(['middleware' => 'auth'], function()
{
  Route::get('/actuacionProc-judi/index/{idEstadoEtapa}', 'ActuacionProceJudiController@actionIndexActuacionProceJudi');
  Route::post('/actuacionProc-judi/pasosAbogado', 'ActuacionProceJudiController@actionPasosAbogado');
  Route::post('/actuacionProc-judi/marcarPaso', 'ActuacionProceJudiController@actionMarcarPaso');
  Route::post('/actuacionProc-judi/modalMarcarPaso', 'ActuacionProceJudiController@actionModalMarcarPaso');
  Route::post('/actuacionProc-judi/nuevoDemandante', 'ActuacionProceJudiController@actionNuevoDemandante');
  Route::post('/actuacionProc-judi/validarGuardarDemandante', 'ActuacionProceJudiController@actionValidarGuardarDemandante');
  Route::post('/actuacionProc-judi/demandantes', 'ActuacionProceJudiController@actionDemandantes');
  Route::post('/actuacionProc-judi/involucradoProceso', 'ActuacionProceJudiController@actionInvolucradoProceso');
  Route::post('/actuacionProc-judi/validarEliminarDemandante', 'ActuacionProceJudiController@actionValidarEliminarDemandante');
  Route::post('/actuacionProc-judi/demandados', 'ActuacionProceJudiController@actionDemandados');
  Route::post('/actuacionProc-judi/validarRemoverDemandado', 'ActuacionProceJudiController@actionValidarRemoverDemandado');
  Route::post('/actuacionProc-judi/accionadosExternos', 'ActuacionProceJudiController@actionAccionadosExternos');
  Route::post('/actuacionProc-judi/abogadosExternos', 'ActuacionProceJudiController@actionAbogadosExternos');
  Route::post('/actuacionProc-judi/modificarDatosGenerales', 'ActuacionProceJudiController@actionModificarDatosGenerales');
  Route::post('/actuacionProc-judi/validarEditarDatosGenerales', 'ActuacionProceJudiController@actionValidarEditarDatosGenerales');
});

Route::group(['middleware' => 'auth'], function()
{
  Route::get('/actuacionTutelas/index/{idEstadoEtapa}', 'ActuacionTutelasController@actionIndexActuacionTutelas');
  Route::post('/actuacionTutelas/pasosAbogado', 'ActuacionTutelasController@actionPasosAbogado');
  Route::post('/actuacionTutelas/marcarPaso', 'ActuacionTutelasController@actionMarcarPaso');
  Route::post('/actuacionTutelas/modalMarcarPaso', 'ActuacionTutelasController@actionModalMarcarPaso');
  Route::post('/actuacionTutelas/nuevoAccionante', 'ActuacionTutelasController@actionNuevoAccionante');
  Route::post('/actuacionTutelas/validarGuardarAccionante', 'ActuacionTutelasController@actionValidarGuardarAccionante');
  Route::post('/actuacionTutelas/accionantes', 'ActuacionTutelasController@actionAccionantes');
  Route::post('/actuacionTutelas/involucradoProceso', 'ActuacionTutelasController@actionInvolucradoProceso');
  Route::post('/actuacionTutelas/validarEliminarAccionante', 'ActuacionTutelasController@actionValidarEliminarAccionante');
  Route::post('/actuacionTutelas/accionadosInternos', 'ActuacionTutelasController@actionAccionadosInternos');
  Route::post('/actuacionTutelas/validarRemoverAccionadoInt', 'ActuacionTutelasController@actionValidarRemoverAccionadoInt');
  Route::post('/actuacionTutelas/accionadosExternos', 'ActuacionTutelasController@actionAccionadosExternos');
  Route::post('/actuacionTutelas/modificarDatosGenerales', 'ActuacionTutelasController@actionModificarDatosGenerales');
  Route::post('/actuacionTutelas/validarEditarDatosGenerales', 'ActuacionTutelasController@actionValidarEditarDatosGenerales');
});

Route::group(['middleware' => 'auth'], function()
{
  Route::get('/actuacionesProcesales/index/{idEstadoEtapa}/', 'ActuacionProcesalController@actionIndexActuProcesal');
  Route::post('/actuacionesProcesales/instanciasProceso', 'ActuacionProcesalController@actionInstanciasProceso');
  Route::post('/actuacionesProcesales/etapasInstancia', 'ActuacionProcesalController@actionEtapasInstancia');
  Route::post('/actuacionesProcesales/agregarActuacion', 'ActuacionProcesalController@actionAgregarActuacion');
  Route::post('/actuacionesProcesales/validarGuardarActuProce', 'ActuacionProcesalController@actionValidarGuardarActuProce');
  Route::post('/actuacionesProcesales/uploadArchivoActuacion', 'ActuacionProcesalController@actionUploadArchivoActuacion');
  Route::post('/actuacionesProcesales/actuacionesEtapa', 'ActuacionProcesalController@actionactuacionesEtapa');
  Route::post('/actuacionesProcesales/validarEliminarArchivo', 'ActuacionProcesalController@actionValidarEliminarArchivo');
  Route::post('/actuacionesProcesales/validarEliminarActuacion', 'ActuacionProcesalController@actionValidarEliminarActuacion');
  Route::post('/actuacionesProcesales/configuracionTipoActuacion', 'ActuacionProcesalController@actionConfiguracionTipoActuacion');
  Route::post('/actuacionesProcesales/agregarTipoFallo', 'ActuacionProcesalController@actionAgregarTipoFallo');
  Route::post('/actuacionesProcesales/tipoActuacionSeleccionada', 'ActuacionProcesalController@actionTipoActuacionSeleccionada');
  Route::post('/actuacionesProcesales/editarActuacion', 'ActuacionProcesalController@actionEditarActuacion');
  Route::post('/actuacionesProcesales/validarEditarActuacion', 'ActuacionProcesalController@actionValidarEditarActuacion');
});

Route::group(['middleware' => 'auth'], function()
{  
  Route::get('/proviCalifica/index/{idEstadoEtapa}/', 'ProviCalificaController@actionIndexPoviCalifica');
  Route::post('/proviCalifica/cuantiasRadicado', 'ProviCalificaController@actionCuantiasRadicado');
  Route::post('/proviCalifica/validarGuardarCuantia', 'ProviCalificaController@actionValidarGuardarCuantia');
  Route::post('/proviCalifica/tablaCuantias', 'ProviCalificaController@actionTablaCuantias');
  Route::post('/proviCalifica/validarEliminarCuantia', 'ProviCalificaController@actionValidarEliminarCuantia');
  Route::post('/proviCalifica/valorIpcInicial', 'ProviCalificaController@actionValorIpcInicial');
  Route::post('/proviCalifica/valorIpcFinal', 'ProviCalificaController@actionValorIpcFinal');
  Route::post('/proviCalifica/calcularIPC', 'ProviCalificaController@actionCalcularIPC');
  Route::post('/proviCalifica/validarGuardarCalificacion', 'ProviCalificaController@actionValidarGuardarCalificacion');
  Route::post('/proviCalifica/pretensiones', 'ProviCalificaController@actionPretensiones');
  Route::post('/proviCalifica/descripcionCriterio', 'ProviCalificaController@actionDescripcionCriterio');
});

Route::group(['middleware' => 'auth'], function()
{  
  Route::get('/valoraFallo/index/{idEstadoEtapa}/', 'ValoraFalloController@actionValoraFallo');
  Route::post('/valoraFallo/cargarValoracionesFallo', 'ValoraFalloController@actionCargarValoracionesFallo');
  Route::post('/valoraFallo/cargarValoracionFallo', 'ValoraFalloController@actionCargarValoracionFallo');
  Route::post('/valoraFallo/seleccionaRango', 'ValoraFalloController@actionSeleccionaRango');
  Route::post('/valoraFallo/guardarValoracionFallo', 'ValoraFalloController@actionGuardarValoracionFallo');
  Route::get('/valoraFallo/pdfValoracion/{idValoracion}', 'ValoraFalloController@actionPdfValoracion');
  Route::post('/valoraFallo/editarValoracion', 'ValoraFalloController@actionEditarValoracion');
  Route::post('/valoraFallo/modificarValoracionFallo', 'ValoraFalloController@actionModificarValoracionFallo');
  Route::post('/valoraFallo/eliminarValoracion', 'ValoraFalloController@actionEliminarValoracionFallo');  
});

Route::group(['middleware' => 'auth'], function()
{
  Route::get('/buzon/index/', 'BuzonController@actionIndexBuzon');
  Route::post('/buzon/buzonProcesos', 'BuzonController@actionBuzonProcesos');
  Route::post('/buzon/buzonSiguAnte', 'BuzonController@actionBuzonSiguAnte');
  Route::post('/buzon/cantidadBuzon', 'BuzonController@actionCantidadBuzon');
  Route::post('/buzon/misReportes', 'BuzonController@actionMisReportes');
  Route::post('/buzon/validarMisReportes', 'BuzonController@actionValidarMisReportes');
  Route::get('/buzon/miReporteExcel/{vector}', 'BuzonController@actionMiReporteExcel');
  Route::post('/buzon/ultimosLeidos', 'BuzonController@actionUltimosLeidos');
  Route::post('/buzon/buzonActuaciones', 'BuzonController@actionBuzonActuaciones');
  Route::post('/buzon/removerActuacionBuzon', 'BuzonController@actionRemoverActuacionBuzon');
  Route::post('/buzon/trasladarMisProcesos', 'BuzonController@actionTrasladarMisProcesos');
});

Route::group(['middleware' => 'auth'], function()
{
  Route::get('/agenda/index/', 'AgendaController@actionIndexAgenda');
  Route::get('/agendaUsuario/{idResponsable}/{nombre}', 'AgendaController@actionAgendaUsuario');
  Route::post('/agenda/agregarAgenda', 'AgendaController@actionAgregarAgenda');
  Route::post('/agenda/validarGuardarAgenda', 'AgendaController@actionValidarGuardarAgenda');
  Route::post('/agenda/cambiarVigenciaProceso', 'AgendaController@actionCambiarVigenciaProceso');
  Route::post('/agenda/mostrarEditarAgenda', 'AgendaController@actionMostrarEditarAgenda');
  Route::post('/agenda/validarEditarAgenda', 'AgendaController@actioValidarEditarAgenda');
  Route::post('/agenda/editarFechaAgenda', 'AgendaController@actioEditarFechaAgenda');
  Route::post('/agenda/validarEliminarAgenda', 'AgendaController@actioValidarEliminarAgenda');
  Route::get('/agenda/exportarAgenda/{idResponsable}/{fechaRango}', 'AgendaController@actionExportarAgenda');
  Route::post('/agenda/agendaUsuarios', 'AgendaController@actioAgendaUsuarios');
  Route::post('/agenda/buscarProcesoAgenda', 'AgendaController@actioBuscarProcesoAgenda');
  Route::post('/agenda/seleccionarSugerido', 'AgendaController@actioSeleccionarSugerido');
  Route::post('/agenda/usuariosAgenda', 'AgendaController@actioUsuariosAgenda');
});

Route::group(['middleware' => 'auth'], function()
{
  Route::get('/responsables/index/', 'ResponsableController@actionIndexResponsable');
  Route::post('/responsables/tablaResponsables', 'ResponsableController@actioTablaResponsables');
  Route::post('/responsables/agregarResponsable', 'ResponsableController@actioAgregarResponsable');
  Route::post('/responsables/validarGuardarResponsable', 'ResponsableController@actioValidarGuardarResponsable');
  Route::post('/responsables/editarResponsable', 'ResponsableController@actioEditarResponsable');
  Route::post('/responsables/validarEditarResponsable', 'ResponsableController@actioValidarEditarResponsable');
  Route::post('/responsables/validarEstadoResponsable', 'ResponsableController@actioValidarEstadoResponsable');
  Route::post('/responsables/agregarRespInternos', 'ResponsableController@actioAgregarRespInternos');
  Route::post('/responsables/tablaResponsablesInternos', 'ResponsableController@actioTablaResponsablesInternos');
  Route::post('/responsables/validarGuardarRespInt', 'ResponsableController@actioValidarGuardarRespInt');
  Route::post('/responsables/validarElimiarRespInt', 'ResponsableController@actioValidarElimiarRespInt');
});

Route::group(['middleware' => 'auth'], function()
{
  Route::get('/oficio/index/', 'OficioController@actionIndexOficio');
  Route::post('/oficio/tablaOficios/', 'OficioController@actionTablaOficios');
  Route::post('/oficio/agregarOficio/', 'OficioController@actionAgregarOficio');
  Route::get('/oficio/generarOficio/{vector}', 'OficioController@actionGenerarOficio'); 
  Route::post('/oficio/vigenciaRadicados/', 'OficioController@actionVigenciaRadicados');
  Route::post('/oficio/involucradosRadicado/', 'OficioController@actionInvolucradosRadicado');
  Route::post('/oficio/radicarArco/', 'OficioController@actionRadicarArco');
  Route::post('/oficio/implicadoOficio/', 'OficioController@actionImplicadoOficio');
});

Route::group(['middleware' => 'auth'], function()
{
  Route::get('/despachado/index/', 'DespachoController@actionIndexDespacho');
  Route::post('/despachado/despachos/', 'DespachoController@actionDespachos');
  Route::get('/despachado/pdf/{fechaDespachado}/{seleccionados}/{seleccionadosIDS}', 'DespachoController@actionPdf');
});

Route::group(['middleware' => 'auth'], function()
{
  Route::get('/terminados/index/', 'TerminadoController@actionIndex');
  Route::post('/terminados/terminados/', 'TerminadoController@actionTerminados');
  Route::post('/terminados/estadoArchivaProceso', 'TerminadoController@actionArchivaProceso');
});

Route::group(['middleware' => 'auth'], function()
{
  Route::get('/apoderados/index/', 'ApoderadoController@actionIndex');
  Route::post('/apoderados/buscarProcesoApoderado', 'ApoderadoController@actionBuscarProcesoApoderado');
  Route::post('/apoderados/apoderadosRadicado', 'ApoderadoController@actionApoderadosRadicado');
  Route::post('/apoderados/validarEliminarApoderado', 'ApoderadoController@actionValidarEliminarApoderado');
  Route::post('/apoderados/agregarApoderado', 'ApoderadoController@actionAgregarApoderado');
  Route::post('/apoderados/validarGuardarNuevoApoderado', 'ApoderadoController@actionValidarGuardarNuevoApoderado');
  
});

Route::group(['middleware' => 'auth'], function()
{
  Route::get('/puntoatencion/index/', 'PuntoAtencionController@actionIndex');
  Route::post('/puntoatencion/puntosAtencion/', 'PuntoAtencionController@actionPuntosAtencion');
  Route::post('/puntoatencion/agregarPuntoAtencion', 'PuntoAtencionController@actionAgregarPuntoAtencion');
  Route::post('/puntoatencion/validarGuardarPunto', 'PuntoAtencionController@actionValidarGuardarPunto');
  Route::post('/puntoatencion/editarPunto', 'PuntoAtencionController@actionEditarPunto');
  Route::post('/puntoatencion/validarEditarPunto', 'PuntoAtencionController@actionValidarEditarPunto');
  Route::post('/puntoatencion/validarEliminarPunto', 'PuntoAtencionController@actionValidarEliminarPunto');
});

Route::group(['middleware' => 'auth'], function()
{
  Route::get('/juzgados/index', 'JuridicaController@actionJuzgados');
  Route::post('/juzgados/tabla', 'JuridicaController@actionTablaJuzgados');
  Route::post('/juzgados/create', 'JuridicaController@actionCreateJuzgados');
  Route::post('/juzgados/update', 'JuridicaController@actionUpdateJuzgados');
  Route::post('/juzgados/executeupdate', 'JuridicaController@actionExecuteUpdateJuzgados');
  Route::post('/juzgados/ciudades', 'JuridicaController@actionCiudad');
  Route::post('/juzgados/validarGuardarJuzgado', 'JuridicaController@actionValidarGuardarJuzgado');
  Route::post('/juzgados/validarEditarJuzgado', 'JuridicaController@actionValidarEditarJuzgado');
});

//Punto 4
//SELECT nombreMedioControl, count(*) FROM jurimedioscontrol GROUP BY nombreMedioControl HAVING COUNT(*)>1

//SELECT nombreTema, count(*) FROM juritemas GROUP BY nombreTema HAVING COUNT(*)>1

Route::get('/repetidos-medios-control', function(){

  $i = 1;
  //Medios de control repetidos (Aparecen mas de una vez en la tabla jurimedioscontrol)
  $repetidas = DB::table('jurimedioscontrol')
                ->select('nombreMedioControl', 'idMediosControl', DB::raw('count(*)'))
               ->groupBy('nombreMedioControl')
             ->havingRaw('COUNT(*) > ?',[1])
                   ->get();

  //Recorre las palabras repetidas una a una
  foreach ($repetidas as $repetida) 
  {
    //Nombre medio control
    echo "<h3>".$i.". ".$repetida->nombreMedioControl."</h3><br>";

    //Busca todas las apariciones de la palabra repetida
    $medios = DB::table('jurimedioscontrol')
                ->where('nombreMedioControl', $repetida->nombreMedioControl) 
                  ->get();

    //Guarda el id de la primera aparición de la palabra repetida
    $primero = $medios[0]->idMediosControl;

    $j = 1;
    //Recorre los medios repetidos
    foreach ($medios as $medio) 
    {    
      echo $medio->nombreMedioControl." ".$medio->idMediosControl."<br>";

      //Busca el total de idMediosControl en la tabla radicados
      $radicados = DB::table('juriradicados')
                     ->where('jurimedioscontrol_idMediosControl', $medio->idMediosControl)
                     ->count();
      
      //Actualiza la tabla juriradicados con el primer idMediosControl
      DB::table('juriradicados')
        ->where('jurimedioscontrol_idMediosControl', $medio->idMediosControl)
       ->update(['jurimedioscontrol_idMediosControl' => $primero]);

      echo $radicados." medios actualizados al idMediosControl: ".$primero;

      //Borra el medio de control a excepción del primero 
      if ($j > 1) 
      { 
        DB::table('jurimedioscontrol')
          ->where('idMediosControl', $medio->idMediosControl) 
        ->delete();

        echo "<h4>".$medio->idMediosControl." NO es el primero: ".$primero." BORRAR!</h4>";
      }
      else
      {
        echo "<h4>".$medio->idMediosControl." SI es el primero: ".$primero." NO BORRAR!</h4>";
      }

      $j++;
    }
    echo "<hr>";
    $i++;
  }
});


Route::get('/repetidos-temas', function(){

  $i = 1;
  //Temas repetidos (Aparecen mas de una vez en la tabla juritemas)
  $repetidas = DB::table('juritemas')
                ->select('nombreTema', 'idTema', DB::raw('count(*)'))
               ->groupBy('nombreTema')
             ->havingRaw('COUNT(*) > ?',[1])
                   ->get();

  //Recorre las palabras repetidas una a una
  foreach ($repetidas as $repetida) 
  {
    //Nombre medio control
    echo "<h3>".$i.". ".$repetida->nombreTema."</h3><br>";

    //Busca todas las apariciones de la palabra repetida
    $temas = DB::table('juritemas')
                ->where('nombreTema', $repetida->nombreTema) 
                  ->get();

    //Guarda el id de la primera aparición de la palabra repetida
    $primero = $temas[0]->idTema;

    $j = 1;
    //Recorre los temas repetidos
    foreach ($temas as $tema) 
    {    
      echo $tema->nombreTema." ".$tema->idTema."<br>";

      //Busca el total de idTema en la tabla radicados
      $radicados = DB::table('juriradicados')
                     ->where('juritemas_idTema', $tema->idTema)
                     ->count();
      
      //Actualiza la tabla juriradicados con el primer idTema
      
      DB::table('juriradicados')
        ->where('juritemas_idTema', $tema->idTema)
       ->update(['juritemas_idTema' => $primero]);

      echo $radicados." temas actualizados al idTema: ".$primero;

      //Borra el tema a excepción del primero 
      if ($j > 1) 
      { 
        
        DB::table('juritemas')
          ->where('idTema', $tema->idTema) 
         ->delete();

        echo "<h4>".$tema->idTema." NO es el primero: ".$primero." BORRAR!</h4>";
      }
      else
      {
        echo "<h4>".$tema->idTema." SI es el primero: ".$primero." NO BORRAR!</h4>";
      }

      $j++;
    }
    echo "<hr>";
    $i++;
  }
});

Route::get('/temas', function () {
  
  $temas =  DB::table('juriradicados')
             ->select('vigenciaRadicado', 'idRadicado', 'nombreTema')
               ->join('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
                ->get();

  foreach ($temas as $tema) 
  {
    DB::table('juriradicados')
      ->where('vigenciaRadicado', '=', $tema->vigenciaRadicado)
      ->where('idRadicado', '=', $tema->idRadicado)
      ->update(["asunto" => $tema->nombreTema]);

    echo $tema->vigenciaRadicado."-".$tema->idRadicado." => ".$tema->nombreTema."<br>";
  }

});

Route::get('/radicados-codigo-corregir', function () {
  
  $radicados =  DB::table('juriradicados')
                ->where('vigenciaRadicado', 2023)
                ->take(1000)
                ->get();

  foreach ($radicados as $radicado) 
  {
    if(strlen($radicado->codigoProceso) > 23){
      echo $radicado->vigenciaRadicado."-".$radicado->idRadicado." => ".$radicado->codigoProceso."<br>";
    }
    /*DB::table('juriradicados')
      ->where('vigenciaRadicado', '=', $radicado->vigenciaRadicado)
      ->where('idRadicado', '=', $radicado->idRadicado)
      ->update(["asunto" => $radicado->nombreTema]);*/
 
  }

});

//UPDATE `juriradicados` SET `jurimedioscontrol_idMediosControl`= 25 WHERE `jurimedioscontrol_idMediosControl`= 6;
//UPDATE `juriradicados` SET `juritemas_idTema`= 244 WHERE `juritemas_idTema`= 247;

/*
1. En la tabla juriradicados, agregar una columna llamada asunto
2. Ejecutar la ruta temas para actualizar la columna asunto
3. Asingar el valor NULL a todos los registros de la columna juritemas_idTema con el siguiente sql: update juriradicados set juritemas_idTema = null
4. Renombrar tabla juritemas a juritemas_old
5. Importar tabla nueva: juritemas


*/

Route::get('/radicados-corregir-codigo', function () {
  
  $radicados =  DB::table('juriradicados')
                ->where('vigenciaRadicado', 2022)
                ->whereNotNull('codigoProceso')
                //->take(1000)
                ->get();

  foreach ($radicados as $radicado) 
  {
    if(strlen($radicado->codigoProceso) < 23){
      echo $radicado->vigenciaRadicado."-".$radicado->idRadicado." => ".$radicado->codigoProceso."<br>";
    }
  }

});

Route::get('/medios-de-control-mayuscula', function () {
  
  $medios =  DB::table('juritemas')
                ->get();

  foreach ($medios as $medio) 
  {
    DB::table('juritemas')
    ->where('idTema', $medio->idTema)
    ->update(['nombreTema' => strtoupper($medio->nombreTema)]);
  }

});

Route::get('/repetidos-usuarios', function(){

  $i = 1;
  //Temas repetidos (Aparecen mas de una vez en la tabla juritemas)
  $repetidas = DB::table('juriresponsables')
                ->select('idResponsable', 'usuarios_idUsuario', DB::raw('count(*)'))
               ->groupBy('usuarios_idUsuario')
             ->havingRaw('COUNT(*) > ?',[1])
                   ->get();

        dd($repetidas);

        return;

  //Recorre las palabras repetidas una a una
  /*foreach ($repetidas as $repetida) 
  {
    //Nombre medio control
    echo "<h3>".$i.". ".$repetida->nombreTema."</h3><br>";

    //Busca todas las apariciones de la palabra repetida
    $temas = DB::table('juritemas')
                ->where('nombreTema', $repetida->nombreTema) 
                  ->get();

    //Guarda el id de la primera aparición de la palabra repetida
    $primero = $temas[0]->idTema;

    $j = 1;
    //Recorre los temas repetidos
    foreach ($temas as $tema) 
    {    
      echo $tema->nombreTema." ".$tema->idTema."<br>";

      //Busca el total de idTema en la tabla radicados
      $radicados = DB::table('juriradicados')
                     ->where('juritemas_idTema', $tema->idTema)
                     ->count();
      
      //Actualiza la tabla juriradicados con el primer idTema
      
      DB::table('juriradicados')
        ->where('juritemas_idTema', $tema->idTema)
       ->update(['juritemas_idTema' => $primero]);

      echo $radicados." temas actualizados al idTema: ".$primero;

      //Borra el tema a excepción del primero 
      if ($j > 1) 
      { 
        
        DB::table('juritemas')
          ->where('idTema', $tema->idTema) 
         ->delete();

        echo "<h4>".$tema->idTema." NO es el primero: ".$primero." BORRAR!</h4>";
      }
      else
      {
        echo "<h4>".$tema->idTema." SI es el primero: ".$primero." NO BORRAR!</h4>";
      }

      $j++;
    }
    echo "<hr>";
    $i++;
  }*/
});