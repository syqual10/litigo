<?php
namespace SQ10\Http\Controllers;

use DB;
use Excel;
use Illuminate\Http\Request;
use Session;
use SQ10\Models\IPC;
use SQ10\Models\Entidad;
use SQ10\Models\Cargo;
use SQ10\Models\Usuario;

class IPCController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function actionIndexIpc()
    {
        return view('ipc/actionIndexIpc');
    }

    public function actionTablaIPC(Request $request)
    {
        $ipcs = DB::table('juriindicesprecios')
                ->join('meses', 'juriindicesprecios.meses_idmes', 'meses.idMes')
                ->join('jurivigenciaindices', 'juriindicesprecios.jurivigenciaindices_idVigenciaIndice', 'jurivigenciaindices.idVigenciaIndice')
                ->get();

        return view('ajax_ipc.ajaxTablaIPC')
                    ->with('ipcs', $ipcs);  
    }

    public function actionAgregarIPC(Request $request)
    {
        $listaVigencias = DB::table('jurivigenciaindices')
            ->orderBy('idVigenciaIndice', 'asc')
            ->pluck('vigenciaIndice', 'idVigenciaIndice');

        $listaMeses = DB::table('meses')
            ->orderBy('idMes', 'asc')
            ->pluck('nombreMes', 'idMes');

        return view('ajax_ipc.ajaxAgregarIPC')
                    ->with('listaVigencias', $listaVigencias)
                    ->with('listaMeses', $listaMeses); 
    }

    public function actionValidarGuardarIpc(Request $request)
    {
        $ipc  = new IPC;
        $ipc->meses_idmes                           = $request->input('selectMesIpc');
        $ipc->jurivigenciaindices_idVigenciaIndice  =$request->input('selectVigenciaIpc');
        $ipc->valorIndice                           =$request->input('valorIpc');
        $ipc->save();

        return 1;// guarda ipc
    }

    public function actioneditarIPC(Request $request)
    {
        $ipc = DB::table('juriindicesprecios')
                ->where('idIndice', '=', $request->input('idIPC'))
                ->get();

        $listaVigencias = DB::table('jurivigenciaindices')
            ->orderBy('idVigenciaIndice', 'asc')
            ->pluck('vigenciaIndice', 'idVigenciaIndice');

        $listaMeses = DB::table('meses')
            ->orderBy('idMes', 'asc')
            ->pluck('nombreMes', 'idMes');

        return view('ajax_ipc.ajaxEditarIPC')
                ->with('ipc', $ipc)
                ->with('listaVigencias', $listaVigencias)
                ->with('listaMeses', $listaMeses);
    }

    public function actionValidarEditarIpc(Request $request)
    {
        DB::table('juriindicesprecios')
                ->where('idIndice', $request->input('idIPC'))
                ->update([
                    'meses_idmes'                           => $request->input('selectMesIpcEditar'),
                    'jurivigenciaindices_idVigenciaIndice'  => $request->input('selectVigenciaIpcEditar'),
                    'valorIndice'                           => $request->input('valorIpcEditar')]);

        return 1; // se modificó el ipc
    }

    public function actionValidarEliminarIPC(Request $request)
    {
        IPC::where('idIndice', '=', $request->input('idIPC'))->delete();
        return 1;// eliminar ipc 
    }
}