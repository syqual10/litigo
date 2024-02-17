<?php
namespace SQ10\Http\Controllers;

use DB;
use Excel;
use Illuminate\Http\Request;
use Session;
use SQ10\Models\Entidad;
use SQ10\Models\Tema;
use SQ10\Models\Usuario;

class TemaController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

    public function actionIndextema()
    {
        return view('temas/index');
    }

    public function actionTablaTemas(Request $request)
    {
        $temas = DB::table('juritemas')
                ->get();

        return view('ajax_temas.ajaxTablaTemas')
                    ->with('temas', $temas);  
    }

    public function actionAgregarTemas(Request $request)
    {
        return view('ajax_temas.ajaxAgregarTemas');
    }

    public function actionValidarGuardarTema(Request $request)
    {
        $tema  = new Tema;
        $tema->nombreTema=$request->input('nombreTema');
        $tema->save();

        return 1;// guarda el tema
    }

    public function actionEditarTema(Request $request)
    {
		$tema = DB::table('juritemas')
	            ->where('idTema', '=', $request->input('idTema'))
	            ->get();

	    return view('ajax_temas.ajaxEditarTema')
	            ->with('tema', $tema);  
    }

    public function actionValidarEditarTema(Request $request)
    {
        DB::table('juritemas')
                ->where('idTema', $request->input('idTema'))
                ->update([
                    'nombreTema' => $request->input('nombreTemaEditar')]);

        return 1; // se modificaron los datos del tema
    }

    public function actionValidarEliminarTema(Request $request)
    {
        $temaEnProceso = DB::table('juriradicados')
                ->where('juritemas_idTema', '=', $request->input('idTema'))
                ->count();

        if($temaEnProceso == 0)
        {
            Tema::where('idTema', '=', $request->input('idTema'))->delete();
            return 1;// eliminar tema 
        }
        else
        {
            return 2;// no se puede eliminar porque lo utiliza al menos un proceso
        }
    }

    public function actionMasivo()
    {
        return view('temas/masivo');
    }

    public function actionTraerRadicados(Request $request)
    {
        $vigencia = $request->input('vigencia');
        $estado = $request->input('estado');
        $condicion = $request->input('condicion');
        $termino = $request->input('termino');
        $q = "+".preg_replace( '/\s(\w+)/', ' +\\1', $termino);

        $radicados = DB::table('juriradicados')
                    ->leftJoin('juritipoprocesos', 'juriradicados.juritipoprocesos_idTipoProceso', '=', 'juritipoprocesos.idTipoProcesos')
                    ->leftJoin('jurijuzgados', 'juriradicados.jurijuzgados_idJuzgado', '=', 'jurijuzgados.idJuzgado')
                    ->leftJoin('juritemas', 'juriradicados.juritemas_idTema', '=', 'juritemas.idTema');

        if ($vigencia > 0) 
        {
            $radicados->where('vigenciaRadicado', $vigencia);
        }

        if ($estado > 0) 
        {
            $radicados->where('juriestadosradicados_idEstadoRadicado', $estado);
        }

        if ($condicion > 0) 
        {
            //1 Con tema, 2 Sin tema, 0 Todos
            if ($condicion == 1) 
            {
                $radicados->whereNotNull('juritemas_idTema');
            } 
            else 
            {
                $radicados->whereNull('juritemas_idTema');
            }
        }

        if ($termino != "") 
        {
            $radicados->whereRaw("MATCH(descripcionHechos) AGAINST(? IN BOOLEAN MODE)", array($q));
        }

        $result = $radicados->get();
                         
        $listaTemas = DB::table('juritemas')
                      ->orderBy('nombreTema', 'asc')
                        ->pluck('nombreTema', 'idTema');

        return view('ajax_temas.ajaxTraerRadicados')
             ->with('radicados', $result)
             ->with('listaTemas', $listaTemas);
                        
    }

    public function actionEstablecerTemaMasivo(Request $request)
    {
        $procesos = json_decode($request->input('jsonSeleccionados'), true);    
        
        if(count($procesos) > 0)
        {
            for($i = 0; $i < count($procesos); $i++)
            {    
                list($vigenciaRadicado, $idRadicado) = explode("-", $procesos[$i]);

                DB::table('juriradicados')
                  ->where('vigenciaRadicado', $vigenciaRadicado)
                  ->where('idRadicado', $idRadicado)
                 ->update(["juritemas_idTema" => $request->input('selectTema')]);            
            }
        }
    }
}