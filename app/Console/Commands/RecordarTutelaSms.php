<?php

namespace SQ10\Console\Commands;

use Illuminate\Console\Command;

use SQ10\helpers\Util as Util;
use DB;

class RecordarTutelaSms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recordar:tutelasms';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando que envía sms con el número de tutelas pendientes';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $responsables = DB::table('juriresponsables')
                    ->join('usuarios', 'juriresponsables.usuarios_idUsuario', '=', 'usuarios.idUsuario')
                    ->where('estadoResponsable', '=', 1)
                    ->get();

        if(count($responsables) > 0)
        {
            foreach ($responsables as $responsable) 
            {
                $cantidadTutelas  = Util::cantidadTipoProceso(3, $responsable->idResponsable);//3 son las tutelas
                if($responsable->celularUsuario !='' && $cantidadTutelas > 0)
                {
                    $expresion = '/^[3][0-9]{9}+$/';
                    if(preg_match($expresion, $responsable->celularUsuario))
                    {
                        $nombreUsu = explode(" ", $responsable->nombresUsuario);
                        

                        $mensaje = "Hola ".$nombreUsu[0].", Recuerde las ".$cantidadTutelas." Tutelas pendientes por responder, para que sus archivos de respuesta se puedan ver reflejados en el sistema de litígo.";

                        Util::enviarSms($responsable->celularUsuario, $mensaje);
                    }
                }
            }
        }
    }
}
