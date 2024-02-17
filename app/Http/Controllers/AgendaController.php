<?php
namespace SQ10\Http\Controllers;

use DB;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Session;
use SQ10\Models\Agenda;
use SQ10\Models\Responsable;
use SQ10\Models\Entidad;
use SQ10\Models\UsuariosNotificarAgenda;
use SQ10\helpers\Util as Util;
use Barryvdh\DomPDF\Facade as PDF;

class AgendaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function actionIndexAgenda()
    {
    	$idUsuario = Session::get('idUsuario'); 
    	$idDependencia = Session::get('idDependencia'); 
    	$idResponsable = Util::idResponsable($idUsuario);
    	$permisoResponsable  = Responsable::find($idResponsable);

    	$agendaSesion = DB::table('juriresponsables')
			->join('usuarios', 'juriresponsables.usuarios_idUsuario', '=', 'usuarios.idUsuario')
			->where('idResponsable', '=', $idResponsable)
		    ->get();

		$responsable = 0;

		$agendasUsuario = [];
    	
		if($permisoResponsable->permiso == 1)
		{
			$responsable = 1;

			$agendasUsuario = DB::table('juriresponsables')
						->join('usuarios', 'juriresponsables.usuarios_idUsuario', '=', 'usuarios.idUsuario')
						->where('idResponsable', '!=', 1)// no cargue el admin de soporte
						->where('permiso', '!=', 1)// no cargue el admin de soporte
						->where('estadoResponsable', '=', 1)
						->where('dependencias_idDependencia', '=', $idDependencia)
					    ->get();
		}

		if($permisoResponsable->juriperfiles_idPerfil == 7)
		{
			$responsable = 1;

			$agendasUsuario = DB::table('juriresponsables')
						->join('usuarios', 'juriresponsables.usuarios_idUsuario', '=', 'usuarios.idUsuario')
						->where('idResponsable', '!=', 1)// no cargue el admin de soporte
						->where('permiso', '!=', 1)// no cargue el admin de soporte
						->where('estadoResponsable', '=', 1)
					    ->get();
		}

		if(count($agendasUsuario) == 0)
		{
			//Validar si tiene usuarios a su cargo
			$agendasUsuario = DB::table('juriresposanblesinternos')
				->join('juriresponsables', 'juriresposanblesinternos.juriresponsables_idResponsable_interno', '=', 'juriresponsables.idResponsable')
				->join('usuarios', 'juriresponsables.usuarios_idUsuario', '=', 'usuarios.idUsuario')
				->where('juriresponsables_idResponsable','=', $idResponsable)
				->select('juriresponsables.idResponsable','usuarios.nombresUsuario')
				->get();
				
			if(count($agendasUsuario) > 0){
				$responsable = 1;
			}

		}

		//return dd($agendasUsuario); 

		return view('agenda.index')
			   		->with('idResponsable', $idResponsable)
			   		->with('responsable', $responsable)
			   		->with('agendasUsuario', $agendasUsuario)
			   		->with('agendaSesion', $agendaSesion);
    }

    public function actionAgendaUsuario($idResponsable, $nombre)
	{
		$agendaUsuario = DB::table('juriagendas')
                        ->leftJoin('juriradicados', function ($leftJoin) {
                          $leftJoin->on('juriagendas.juriradicados_vigenciaRadicado', '=', 'juriradicados.vigenciaRadicado')
                          ->on('juriagendas.juriradicados_idRadicado', '=', 'juriradicados.idRadicado');
                        })
                        ->leftJoin('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                        ->leftJoin('jurijuzgados', 'juriradicados.jurijuzgados_idJuzgado', '=', 'jurijuzgados.idJuzgado')
                        ->where('juriresponsables_idResponsable', '=', $idResponsable)
						->get();

		return view('agendaUsuario')
		    	->with('agendaUsuario', $agendaUsuario)
		    	->with('nombreFuncionario', $nombre)
		    	->with('idResponsable', $idResponsable);
	}

	public function actionAgregarAgenda(Request $request)
	{
		$vigenciaActual = date('Y');
		$idUsuario = Session::get('idUsuario'); 
		$idResponsable = Util::idResponsable($idUsuario);

		$listaProcesosUsuario = DB::table('juriestadosetapas')
			->join('juriresponsables', 'juriestadosetapas.juriresponsables_idResponsable', '=', 'juriresponsables.idResponsable')
		    ->where('juriresponsables_idResponsable', '=', $request->input("selectUsuarioAgenda"))
			->where('juriradicados_vigenciaRadicado', '=', $vigenciaActual)
			->groupBy('juriestadosetapas.juriradicados_vigenciaRadicado')
            ->groupBy('juriestadosetapas.juriradicados_idRadicado')
			->orderBy('juriradicados_idRadicado', 'asc')
		    ->get();

    	return view('ajax_agenda.ajaxAdicionarEventoAgenda')
		    	->with("fechaInicio", $request->input("fechaInicio"))
		    	->with("fechaFinal", $request->input("fechaFinal"))
		    	->with('listaProcesosUsuario', $listaProcesosUsuario)
		    	->with('vigenciaActual', $vigenciaActual);
	}

	public function actionValidarGuardarAgendaPersonal(Request $request)
	{
		$idUsuario = Session::get('idUsuario');
		$idResponsable = Util::idResponsable($idUsuario);

		$agenda = new Agenda;
		$agenda->agendaPersonal                     = 1;
		$agenda->asuntoAgenda 						= $request->input("asuntoAgenda");
		$agenda->fechaInicioAgenda  				= $request->input("fechaInicioAg");
		$agenda->fechaFinAgenda 					= $request->input("fechaFinalAg");
		$agenda->color 								= 'yellow';
        $agenda->juriresponsables_idResponsable 	= $idResponsable;
        $agenda->juriresponsables_idResponsable1 	= $idResponsable;
		$agenda->save();

		return response()->json([
            'idAgenda'  			=> $agenda->id,
            'selectUsuarioAgenda'   => $idResponsable,
    	]);


	}

	public function actionValidarGuardarAgenda(Request $request)
	{
		if($request->input('personal') ==  1){
			return $this->actionValidarGuardarAgendaPersonal($request);
		}

		$idUsuario = Session::get('idUsuario');
		$idResponsable = Util::idResponsable($idUsuario);
		$dateIni = date_create($request->input("fechaInicioAg")); 
	    $dateIni = date_format($dateIni, 'Y-m-d');

	    if($dateIni < date('Y-m-d'))
	    {
	    	return 0; // error, no se puede crear agenda una fecha anterior o igual a la actual
	    }

        $agenda = new Agenda;
        $agenda->asuntoAgenda 						= $request->input("asuntoAgenda");
        $agenda->fechaInicioAgenda  				= $request->input("fechaInicioAg");
        $agenda->fechaFinAgenda 					= $request->input("fechaFinalAg");
        $agenda->color 								= $request->input("colorAgenda");
        $agenda->juriresponsables_idResponsable 	= $request->input("selectUsuarioAgenda");
        $agenda->juriresponsables_idResponsable1 	= $idResponsable;
        $agenda->critico 							= $request->input("agendaCritica");
        $agenda->notificacionAgenda 				= $request->input("selectTipoNotifi");//0 sin notificación
        //1 correo 2 sms
   		$agenda->tiempoNotificacion 				= $request->input("diasAntes");
        $agenda->juriradicados_vigenciaRadicado 	= $request->input("vigenciaProceso");
        $agenda->juriradicados_idRadicado 			= $request->input("selectProceso");
		$agenda->save();
		$idAgendaLast = $agenda->id;

		$usuarioSiguiente = DB::table('juriresponsables')
				            ->join('usuarios', 'juriresponsables.usuarios_idUsuario', '=', 'usuarios.idUsuario')
				            ->where('idResponsable', '=', $request->input("selectUsuarioAgenda"))
				            ->get();

		$vectorUsuariosNotificar = json_decode($request->input('jsonUsuariosNotificar'), true);
		for ($i = 0; $i < count($vectorUsuariosNotificar); $i++) 
        {
            $usuarioNotifica  = new UsuariosNotificarAgenda;
            $usuarioNotifica->juriresponsables_idResponsable = $idResponsable;
            $usuarioNotifica->juriagendas_Id  				 = $idAgendaLast;
            $usuarioNotifica->usuarios_idUsuario  			 = $vectorUsuariosNotificar[$i];
            $usuarioNotifica->save();
        }

		return response()->json([
            'idAgenda'  			=> $idAgendaLast,
            'selectUsuarioAgenda'   => $usuarioSiguiente[0]->usuarios_idUsuario,
            'vigenciaRadicado'  	=> $request->input("vigenciaProceso"),
            'idRadicado'  			=> $request->input("selectProceso"),
    	]);
	}

	public function actionCambiarVigenciaProceso(Request $request)
	{
		$idUsuario = Session::get('idUsuario');
		$idResponsable = Util::idResponsable($idUsuario);
		
		$listaProcesosUsuario = DB::table('juriestadosetapas')
		    ->where('juriresponsables_idResponsable', '=', $request->input("selectUsuarioAgenda"))
			->where('juriradicados_vigenciaRadicado', '=', $request->input("vigencia"))
			->groupBy('juriestadosetapas.juriradicados_vigenciaRadicado')
            ->groupBy('juriestadosetapas.juriradicados_idRadicado')
			->orderBy('juriradicados_idRadicado', 'asc')
		    ->get();

		return view('ajax_agenda.ajaxVigenciaProceso')
		    	->with('listaProcesosUsuario', $listaProcesosUsuario);
	}

	public function actionMostrarEditarAgenda(Request $request)
	{
		$notificacion   = "none" ;
		$check 			= "";
		$selected1 		= "";
		$selected2 		= "";
		$agendaPersonalHide = "none";

		$agenda = DB::table('juriagendas')
			->where('Id', '=', $request->input("idAgenda"))
			->get();
			
		if($agenda[0]->agendaPersonal == 0){
			$agendaPersonalHide = "";
		}

		if($agenda[0]->notificacionAgenda !=0)
		{
			$notificacion = "block";
			$check 		  = "checked";

			if($agenda[0]->notificacionAgenda == 1)
			{
				$selected1 	  = "selected";
			}
			else if($agenda[0]->notificacionAgenda == 2)
			{
				$selected2 	  = "selected";
			}
		}

		return view('ajax_agenda.ajaxEditarEventoAgenda')
		    	->with('agenda', $agenda)
		    	->with('notificacion', $notificacion)
		    	->with('check', $check)
				->with('selected1', $selected1)
				->with('agendaPersonalHide', $agendaPersonalHide)
		    	->with('selected2', $selected2);
	}

	public function actioValidarEditarAgenda(Request $request)
	{
    	DB::table('juriagendas')
            ->where('Id', $request->input('idAgenda'))
            ->update(['asuntoAgenda' 		=> $request->input('asuntoAgendaEditar'),
                	  'color'    	 		=> $request->input('colorAgendaEditar'),
                	  'critico'    	 		=> $request->input('agendaCriticaEditar'),
                	  'notificacionAgenda'  => $request->input('selectTipoNotifiEditar'),
                	  'tiempoNotificacion'  => $request->input('diasAntesEditar')]);

        return;
	}

	public function actioEditarFechaAgenda(Request $request)
	{
		DB::table('juriagendas')
            ->where('Id', $request->input('idAgenda'))
            ->update(['fechaInicioAgenda' => $request->input('fechaInicioAgenda'),
                	  'fechaFinAgenda'    => $request->input('fechaFinAgenda')]);


        $procesoAgenda  = DB::table('juriagendas')
				            ->where('Id', '=', $request->input("idAgenda"))
				            ->get();

        $usuarioSiguiente = DB::table('juriresponsables')
				            ->join('usuarios', 'juriresponsables.usuarios_idUsuario', '=', 'usuarios.idUsuario')
				            ->where('idResponsable', '=', $procesoAgenda[0]->juriresponsables_idResponsable)
				            ->get();

		return response()->json([
            'selectUsuarioAgenda'   => $usuarioSiguiente[0]->usuarios_idUsuario,
            'vigenciaRadicado'   	=> $procesoAgenda[0]->juriradicados_vigenciaRadicado,
            'idRadicado'  		    => $procesoAgenda[0]->juriradicados_idRadicado,
    	]);
	}

	public function actioValidarEliminarAgenda(Request $request)
	{
		UsuariosNotificarAgenda::where('juriagendas_Id', '=', $request->input('idAgenda'))->delete();
		Agenda::where('Id', '=', $request->input('idAgenda'))->delete();
		return;
	}

	public function actioAgendaUsuarios(Request $request)
	{
		$responsables = DB::table('juriresponsables')
						->join('usuarios', 'juriresponsables.usuarios_idUsuario', '=', 'usuarios.idUsuario')
						->where('idResponsable', '!=', 1)// no cargue el admin de soporte
						->where('estadoResponsable', '=', 1)
					    ->orderBy('idResponsable', 'asc')
            			->pluck('nombresUsuario', 'idResponsable');

		return view('ajax_agenda.ajaxExportarAgenda')
		    	->with('responsables', $responsables);
	}

	public function actionExportarAgenda($idResponsable, $fechaRango)
	{
		$entidad = Entidad::find(1);
		$diaHoy = date ( 'Y-m-d');

		$fecha 	    = str_replace(" ","",$fechaRango);
		$fechaTotal = explode("-",$fecha);
		$fecha1 	= $fechaTotal[0];
		$fecha2		= $fechaTotal[1];
		$fechaIni 	= str_replace(".","-",$fecha1);
		$fechaFini 	= str_replace(".","-",$fecha2);

        if($idResponsable == 0)
        {
        	$agendaExportar = DB::table('juriagendas')
                        ->leftJoin('juriradicados', function ($leftJoin) {
                          $leftJoin->on('juriagendas.juriradicados_vigenciaRadicado', '=', 'juriradicados.vigenciaRadicado')
                          ->on('juriagendas.juriradicados_idRadicado', '=', 'juriradicados.idRadicado');
                        })
                        ->join('juriresponsables', 'juriagendas.juriresponsables_idResponsable', '=', 'juriresponsables.idResponsable')
                		->join('usuarios', 'juriresponsables.usuarios_idUsuario', '=', 'usuarios.idUsuario')
                        ->leftJoin('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                        ->leftJoin('jurijuzgados', 'juriradicados.jurijuzgados_idJuzgado', '=', 'jurijuzgados.idJuzgado')
                        ->leftJoin('juriautoridadconoce', 'juriradicados.juriautoridadconoce_idAutoridadConoce', '=', 'juriautoridadconoce.idAutoridadConoce')
                        ->leftJoin('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
                        ->whereBetween(DB::raw('substr(juriagendas.fechaInicioAgenda, -19, 10)'),
                		array($fechaIni, $fechaFini))
                		->orderBy('idResponsable', 'asc')
                        ->get();

        	$responsable = "Todas";
        }
        else
        {
        	$agendaExportar = DB::table('juriagendas')
	                        ->leftJoin('juriradicados', function ($leftJoin) {
	                          $leftJoin->on('juriagendas.juriradicados_vigenciaRadicado', '=', 'juriradicados.vigenciaRadicado')
	                          ->on('juriagendas.juriradicados_idRadicado', '=', 'juriradicados.idRadicado');
	                        })
	                        ->join('juriresponsables', 'juriagendas.juriresponsables_idResponsable', '=', 'juriresponsables.idResponsable')
                			->join('usuarios', 'juriresponsables.usuarios_idUsuario', '=', 'usuarios.idUsuario')
	                        ->leftJoin('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
	                        ->leftJoin('jurijuzgados', 'juriradicados.jurijuzgados_idJuzgado', '=', 'jurijuzgados.idJuzgado')
	                        ->leftJoin('juriautoridadconoce', 'juriradicados.juriautoridadconoce_idAutoridadConoce', '=', 'juriautoridadconoce.idAutoridadConoce')
	                        ->leftJoin('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema')
	                        ->where('idResponsable', '=', $idResponsable)
                			->whereBetween(DB::raw('substr(juriagendas.fechaInicioAgenda, -19, 10)'),
                			array($fechaIni, $fechaFini))
                			->orderBy('fechaInicioAgenda', 'asc')
	                        ->get();

            if(count($agendaExportar) > 0)
            {
            	$responsable = $agendaExportar[0]->nombresUsuario;
            }
            else
            {
            	$responsable = ''	;
            }
        }

        $pdf = PDF::loadView('agenda.pdfAgenda', array('agendaExportar' => $agendaExportar, 'responsable' => $responsable, 'idResponsable' => $idResponsable, 'entidad' => $entidad));
        return $pdf->stream('Agenda'.$responsable.'.pdf');
	}

	public function actioBuscarProcesoAgenda(Request $request)
	{
		$radicadoSugeridos = DB::table('juriradicados')
								->select('vigenciaRadicado', 'idRadicado', 'codigoProceso',
								 'nombreJuzgado')
								->join('juriestadosetapas', function ($join) {
				                    $join->on('juriradicados.vigenciaRadicado', '=', 'juriestadosetapas.juriradicados_vigenciaRadicado')
				                    ->on('juriradicados.idRadicado', '=', 'juriestadosetapas.juriradicados_idRadicado');
				                })
				                ->leftJoin('jurijuzgados', 'juriradicados.jurijuzgados_idJuzgado', '=', 'jurijuzgados.idJuzgado')
				                ->where('radicadoJuzgado', 'LIKE', '%'.$request->input('radicadoJuzgado').'%')
				                ->where('juriresponsables_idResponsable', '=', $request->input('selectUsuarioAgenda'))
				                ->get();

		return view('ajax_agenda.ajaxRadicadosSugeridos')
					    	->with('radicadoSugeridos', $radicadoSugeridos);
	}

	public function actioSeleccionarSugerido(Request $request)
	{
		return view('ajax_agenda.ajaxAgendaProcesoInterno')
					    	->with('vigenciaRadicado', $request->input('vigenciaRadicado'))
					    	->with('idRadicado', $request->input('idRadicado'));
	}

	public function actioUsuariosAgenda(Request $request)
	{
		$dependencias = DB::table('dependencias')
				                ->get();

		return view('ajax_agenda.ajaxOtrosUsuariosAgenda')
					    	->with('dependencias', $dependencias);
	}
}