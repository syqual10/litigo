
use SQ10\Models\FalloRadicado;
use SQ10\Models\Tema;
use SQ10\Models\MedioControl;
use SQ10\Models\Involucrado;
use SQ10\Models\Solicitante;
use SQ10\Models\CuantiaRadicado;
use SQ10\Models\ActuacionProcesal;
use SQ10\Models\ActuacionResponsable;
use SQ10\Models\Juzgado;

Route::get('/prueba', function () {
  /*
  $instancias = DB::table('instancia')
                    ->where('consecutivo', '=', 1)
                    ->get();

  foreach ($instancias as $instancia) 
  {
    $proceso = DB::table('juriradicados')
                  ->select('vigenciaRadicado', 'idRadicado')
                  ->where('mzlConsecutivo', '=', $instancia->consecutivo)
                  ->get();


    if(count($proceso) > 0)
    {
      $actuProcesal   = new ActuacionProcesal;
      $actuProcesal->fechaActuacion             = $instancia->fecha_sentencia;
      $actuProcesal->comentarioActuacion        = $instancia->cumplimiento;
      $actuProcesal->juritiposactuaciones_idTipoActuacion  = 44;
      $actuProcesal->juriresponsables_idResponsable        = 112;
      $actuProcesal->juriradicados_vigenciaRadicado        = $proceso[0]->vigenciaRadicado;
      $actuProcesal->juriradicados_idRadicado              = $proceso[0]->idRadicado;
      $actuProcesal->save();

      $actuFallo   = new FalloRadicado;
      $actuFallo->juriradicados_vigenciaRadicado  = $proceso[0]->vigenciaRadicado;
      $actuFallo->juriradicados_idRadicado        = $proceso[0]->idRadicado;
      $actuFallo->juritiposfallos_idTipoFallo     = $instancia->id_decision;
      $actuFallo->juriactuaciones_idActuacion     = $actuProcesal->idActuacion;
      $actuFallo->save();
    }
  }*/
  
  /*
  $procesos = DB::table('juriradicados')
                    ->where('juritemas_idTema', '=', Null)
                    ->get();

                    echo count($procesos);


  foreach ($procesos as $proceso) 
  {
    $radi_viejo = DB::table('demandas')
                    ->where('consecutivo', '=', $proceso->mzlConsecutivo)
                    ->get();

    if(count($radi_viejo) > 0)
    {
       if($radi_viejo[0]->tema != '')
       {
          $tema  = new Tema;
          $tema->nombreTema= $radi_viejo[0]->tema;
          $tema->save();

          DB::table('juriradicados')
                    ->where('vigenciaRadicado', $proceso->vigenciaRadicado)
                    ->where('idRadicado', $proceso->idRadicado)
                    ->update([
                            'juritemas_idTema' => $tema->idTema]);
       }
    }
  }
  */
  
  /*
  $procesos = DB::table('juriradicados')
                    ->where('jurimedioscontrol_idMediosControl', '=', Null)
                    ->get();

                    //echo count($procesos);

  foreach ($procesos as $proceso) 
  {
    $radi_viejo = DB::table('demandas')
                    ->where('consecutivo', '=', $proceso->mzlConsecutivo)
                    ->get();

    if(count($radi_viejo) > 0)
    {
       if($radi_viejo[0]->id_proceso != '' && $radi_viejo[0]->id_proceso != 0)
       {
         $proceso_viejo = DB::table('clase_proceso')
                    ->where('id_proceso', '=', $radi_viejo[0]->id_proceso)
                    ->get();

          if(count($proceso_viejo) > 0)
          {
            $medioControl  = new MedioControl;
            $medioControl->nombreMedioControl = $proceso_viejo[0]->nom_proceso;
            $medioControl->save();

            DB::table('juriradicados')
                    ->where('vigenciaRadicado', $proceso->vigenciaRadicado)
                    ->where('idRadicado', $proceso->idRadicado)
                    ->update([
                            'jurimedioscontrol_idMediosControl' => $medioControl->idMediosControl]);
          }
       }
    }
  }
  */
  
  /*
  $procesos = DB::table('juriradicados')
                    ->get();

                    //echo count($procesos);return;

  foreach ($procesos as $proceso) 
  {
    $radi_viejo = DB::table('datos_basicos')
                    ->where('consecutivo', '=', $proceso->mzlConsecutivo)
                    ->get();

    if(count($radi_viejo) > 0)
    {
       if($radi_viejo[0]->id_dependencia != '' && $radi_viejo[0]->id_dependencia != 0)
       {
         $proceso_viejo = DB::table('dependencia')
                    ->where('id_dependencia', '=', $radi_viejo[0]->id_dependencia)
                    ->get();

          if(count($proceso_viejo) > 0)
          {
            $depen_nueva = DB::table('dependencias')
                          ->where('nombreDependencia', 'LIKE', '%'.$proceso_viejo[0]->nom_dependencia.'%')
                          ->get();

            if(count($depen_nueva) > 0)
            {
              $tipo = 3;

              if($proceso->juritipoprocesos_idTipoProceso = 2)
              {
                $tipo = 5;
              }

              if($proceso->juritipoprocesos_idTipoProceso = 3)
              {
                $tipo = 8;
              }

              $demandadoInvolucrado = new Involucrado;
              $demandadoInvolucrado->juritipoinvolucrados_idTipoInvolucrado = $tipo;
              $demandadoInvolucrado->dependencias_idDependencia  = $depen_nueva[0]->idDependencia;
              $demandadoInvolucrado->juriradicados_vigenciaRadicado  = $proceso->vigenciaRadicado;
              $demandadoInvolucrado->juriradicados_idRadicado  = $proceso->idRadicado;
              $demandadoInvolucrado->save();
            }             
          }
       }
    }
  }
  */
  
  /*
  $procesos = DB::table('juriradicados')
                    ->get();

                    //echo count($procesos);return;

  foreach ($procesos as $proceso) 
  {
    $radi_viejo = DB::table('d_demandantes')
                    ->where('num_demanda', '=', $proceso->mzlConsecutivo)
                    ->get();

    if(count($radi_viejo) > 0)
    {
      $proceso_viejo = DB::table('demandantes')
                ->where('id_demandante', '=', $radi_viejo[0]->id_demandante)
                ->get();

      if(count($proceso_viejo) > 0)
      {
        $solicitante = DB::table('solicitantes')
                      ->where('documentoSolicitante', '=', $proceso_viejo[0]->documento)
                      ->get();

        $tipo = 1;

        if($proceso->juritipoprocesos_idTipoProceso = 2)
        {
          $tipo = 4;
        }

        if($proceso->juritipoprocesos_idTipoProceso = 3)
        {
          $tipo = 7;
        }

        if(count($solicitante) > 0)
        {
          $demandanteInvolucrado = new Involucrado;
          $demandanteInvolucrado->juritipoinvolucrados_idTipoInvolucrado = $tipo;
          $demandanteInvolucrado->solicitantes_idSolicitante  = $solicitante[0]->idSolicitante;
          $demandanteInvolucrado->juriradicados_vigenciaRadicado  = $proceso->vigenciaRadicado;
          $demandanteInvolucrado->juriradicados_idRadicado  = $proceso->idRadicado;
          $demandanteInvolucrado->save();
        }
        else
        {
          $solicitante   = new Solicitante;
          $solicitante->documentoSolicitante   = $proceso_viejo[0]->documento;
          $solicitante->nombreSolicitante    = $proceso_viejo[0]->nom_demandante;
          $solicitante->creadoVentanilla   = 1; //0 Creado en ventanilla
          $solicitante->tiposidentificacion_idTipoIdentificacion = 1;
          $solicitante->ciudades_idCiudad      = 339;
          $solicitante->save();

          $demandanteInvolucrado = new Involucrado;
          $demandanteInvolucrado->juritipoinvolucrados_idTipoInvolucrado = $tipo;
          $demandanteInvolucrado->solicitantes_idSolicitante  = $solicitante->idSolicitante;
          $demandanteInvolucrado->juriradicados_vigenciaRadicado  = $proceso->vigenciaRadicado;
          $demandanteInvolucrado->juriradicados_idRadicado  = $proceso->idRadicado;
          $demandanteInvolucrado->save();
        }
      }
    }
  }
   */
  
  /*
  $procesos = DB::table('juriradicados')
                    ->get();

                    //echo count($procesos);return;

  foreach ($procesos as $proceso) 
  {
    $radi_viejo = DB::table('datos_basicos')
                    ->where('consecutivo', '=', $proceso->mzlConsecutivo)
                    ->get();

    if(count($radi_viejo) > 0)
    {
      if($radi_viejo[0]->cuantia != '')
      {
        $cuantia = new CuantiaRadicado;
        $cuantia->unidadMonetaria                     = 2;
        $cuantia->valor                               = $radi_viejo[0]->cuantia;
        $cuantia->valorPesos                          = $radi_viejo[0]->cuantia;
        $cuantia->juriradicados_vigenciaRadicado      = $proceso->vigenciaRadicado;
        $cuantia->juriradicados_idRadicado            = $proceso->idRadicado;
        $cuantia->save();
      }
    }
  }
  */

  $procesos = DB::table('juriradicados')
                    ->get();

                    //echo count($procesos);return;

  foreach ($procesos as $proceso) 
  {
    $radi_viejo = DB::table('historial')
                    ->where('consecutivo', '=', $proceso->mzlConsecutivo)
                    ->get();

    if(count($radi_viejo) > 0)
    {
      foreach ($radi_viejo as $radicado) 
      {
        $actuProcesal   = new ActuacionProcesal;
        $actuProcesal->jurietapas_idEtapa                        = 1;
        $actuProcesal->fechaActuacion                            = $radicado->fecha_acto;
        $actuProcesal->comentarioActuacion                       = $radicado->anotacion;
        $actuProcesal->juritiposactuaciones_idTipoActuacion      = 36;
        $actuProcesal->juriradicados_vigenciaRadicado            = $proceso->vigenciaRadicado;
        $actuProcesal->juriradicados_idRadicado                  = $proceso->idRadicado;
        $actuProcesal->save(); 
      }
    }
  }
 
  echo "string8";return;
});

Route::get('/prueba2', function () {
  $procesos = DB::table('juriradicados')
                    ->get();

  foreach ($procesos as $proceso)
  {
    $radi_viejo = DB::table('demandas')
                    ->where('consecutivo', '=', $proceso->mzlConsecutivo)
                    ->get();

    if(count($radi_viejo) > 0)
    {
      $estadoviejo = DB::table('estado')
                    ->where('id_estado', '=', $radi_viejo[0]->id_estado)
                    ->get();

      if(count($estadoviejo) > 0)
      {
        if($estadoviejo[0]->id_estado == 1 || $estadoviejo[0]->id_estado == 3 || $estadoviejo[0]->id_estado == 10 || $estadoviejo[0]->id_estado == 12 || $estadoviejo[0]->id_estado == 13)
        {
           $estado = 2;
        }
        else if($estadoviejo[0]->id_estado == 2)
        {
          $estado = 3;
        }
        else
        {
          $estado = 1;
        }

        DB::table('juriradicados')
                    ->where('vigenciaRadicado', $proceso->vigenciaRadicado)
                    ->where('idRadicado', $proceso->idRadicado)
                    ->update([
                            'juriestadosradicados_idEstadoRadicado' => $estado]);
      }
    }
  }
  echo "string6";return;
});

Route::get('/prueba4', function () {
  $actuaciones = DB::table('juriactuaciones')
                    ->where('fechaActuacion', '=', '0000-00-00')
                    ->where('comentarioActuacion', '=', '')
                    ->get();

    
   foreach ($actuaciones as $actuacion) {
     ActuacionProcesal::where('idActuacion', '=', $actuacion->idActuacion)->delete();
     // FalloRadicado::where('juriactuaciones_idActuacion', '=', $actuacion->idActuacion)->delete();
   }

   echo "string2";return;
});

Route::get('/prueba6', function () {
  $radicados = DB::table('juriradicados')
                    ->where('juritipoprocesos_idTipoProceso', '=', 2)
                    ->get();
  
  foreach ($radicados as $radicado) 
  {
    $agendas = DB::table('juriagendas')
                    ->where('juriradicados_idRadicado', '=', $radicado->idRadicado)
                    ->where('juriradicados_vigenciaRadicado', '=', $radicado->vigenciaRadicado)
                    ->where('juriresponsables_idResponsable', '=', 100)
                    ->whereBetween(DB::raw('substr(fechaInicioAgenda, -19, 10)'),
                     array('2019-06-01', '2019-08-31'))
                    ->get();

    if(count($agendas) > 0)
    {
      echo $agendas[0]->juriradicados_idRadicado."-".$agendas[0]->juriradicados_vigenciaRadicado." AGENDA ".$agendas[0]->fechaInicioAgenda."<br>";
    }
  }
});

Route::get('/prueba7', function () {
  $radicados = DB::table('juriradicados')
                    ->get();

  foreach ($radicados as $radicado)
  {
    $fallos = DB::table('jurifalloradicado')
                      ->where('jurifalloradicado.juriradicados_idRadicado', '=', $radicado->idRadicado)
                      ->where('jurifalloradicado.juriradicados_vigenciaRadicado', '=', $radicado->vigenciaRadicado)
                      ->get();

    if(count($fallos) > 2)
    {
      FalloRadicado::where('idFalloRadicado', '=', $fallos[0]->idFalloRadicado)->delete();
      echo "string";return;
    }
  }
});

Route::get('/prueba8', function () {
  $actuacionesEliminar = DB::table('juriactuaciones')
                    ->where('fechaRegistro', '<', '2019-04-01 00-00-00')
                    ->get();

  //echo count($actuacionesEliminar);return;
  $i = 0;
  foreach ($actuacionesEliminar as $actuacion) 
  {
    $archivos = DB::table('juriarchivos')
                    ->where('juriradicados_vigenciaRadicado', '=', $actuacion->juriradicados_vigenciaRadicado)
                    ->where('juriradicados_idRadicado', '=', $actuacion->juriradicados_idRadicado)
                    ->count();

     if($archivos > 0){
      DB::table('juriarchivos')
                    ->where('juriradicados_vigenciaRadicado', $actuacion->juriradicados_vigenciaRadicado)
                    ->where('juriradicados_idRadicado', $actuacion->juriradicados_idRadicado)
                    ->update(['juriactuaciones_idActuacion' => Null]);

       echo $actuacion->juriradicados_vigenciaRadicado."-".$actuacion->juriradicados_idRadicado."<br>";
     }
  }
});

Route::get('/prueba10', function () {

  $instancias_old = DB::table('instancia')
                    ->where('fecha_sentencia', '!=', '0000-00-00')
                    ->orWhere('resumen', '!=', '')
                    ->orWhere('cumplimiento', '!=', '')
                    ->orWhere('num_radicacion', '!=', '')
                    ->orWhere('id_decision', '!=', 4)
                    ->get();

  echo count($instancias_old);
  return;
                    });



Route::get('/instancias-bk2', function () {

  $instancias_old = DB::table('instancia')
                    ->where('fecha_sentencia', '!=', '0000-00-00')
                    ->orWhere('resumen', '!=', '')
                    ->orWhere('cumplimiento', '!=', '')
                    ->orWhere('num_radicacion', '!=', '')
                    //->orWhere('id_decision', '!=', 4)
                    //->take(2000)
                    ->get();

  //echo count($instancias_old);return;

  $i = 0;
  foreach ($instancias_old as $actuacion) 
  {
    $i++;
    $tipoActuacion = 0;
    $tipoFallo = 0;

    $radicados = DB::table('juriradicados')
                    ->where('mzlConsecutivo', '=', $actuacion->consecutivo)
                    ->get();

    if(count($radicados) > 0)
    {

      if($actuacion->id_instancia == 1)
      {
        $tipoActuacion = 44;
      }
      else
      {
        $tipoActuacion = 48;
      }


      $actuProcesal   = new ActuacionProcesal;
      $actuProcesal->fechaActuacion                      = $actuacion->fecha_sentencia;
      $actuProcesal->comentarioActuacion                 = $actuacion->resumen." ".$actuacion->cumplimiento." ".$actuacion->num_radicacion;
      $actuProcesal->juriresponsables_idResponsable      = 6;
      $actuProcesal->juriradicados_vigenciaRadicado      = $radicados[0]->vigenciaRadicado;
      $actuProcesal->juriradicados_idRadicado            = $radicados[0]->idRadicado;
      $actuProcesal->fechaRegistro                       = $actuacion->fecha_sentencia;
      $actuProcesal->mzlConsecutivo                      = $actuacion->consecutivo;
      $actuProcesal->juritiposactuaciones_idTipoActuacion  = $tipoActuacion;
      $actuProcesal->save();
      

      switch ($actuacion->id_decision) {
        case '1':
          $tipoFallo = 5;
          break;
        case '2':
          $tipoFallo = 6;
          break;
        case '3':
          $tipoFallo = 7;
          break;
        case '4':
          $tipoFallo = 8;
          break;
        case '5':
          $tipoFallo = 9;
          break;
        case '6':
          $tipoFallo = 10;
          break;
        case '7':
          $tipoFallo =11;
          break;
        case '8':
          $tipoFallo = 12;
          break;
        case '9':
          $tipoFallo = 13;
          break;
        case '10':
          $tipoFallo = 14;
          break;
        case '11':
          $tipoFallo = 15;
          break;
        case '12':
          $tipoFallo = 16;
          break;
        case '13':
          $tipoFallo = 17;
          break;
        case '14':
          $tipoFallo = 18;
          break;
        case '15':
          $tipoFallo = 19;
          break;
        case '16':
          $tipoFallo = 20;
          break;
        case '17':
          $tipoFallo = 21;
          break;
        case '18':
          $tipoFallo = 22;
          break;
        case '19':
          $tipoFallo = 23;
          break;
        case '20':
          $tipoFallo = 24;
          break;
        case '21':
          $tipoFallo = 25;
          break;
      }

      $actuFallo   = new FalloRadicado;
      $actuFallo->juriradicados_vigenciaRadicado  = $radicados[0]->vigenciaRadicado;
      $actuFallo->juriradicados_idRadicado        = $radicados[0]->idRadicado;
      $actuFallo->juritiposfallos_idTipoFallo     = $tipoFallo;
      $actuFallo->juriactuaciones_idActuacion     = $actuProcesal->idActuacion;
      $actuFallo->save();

      $actuResponsable  = new ActuacionResponsable;
      $actuResponsable->juriactuaciones_idActuacion               = $actuProcesal->idActuacion;
      $actuResponsable->juriresponsables_idResponsable_apoderado  = 6;
      $actuResponsable->save();

      echo $i.' => actuProcesal: '.$actuProcesal->idActuacion.", actuFallo: ".$actuFallo->idFalloRadicado.", actuResponsable:".$actuResponsable->idActuacionResponsable.". => id_decision antes: ".$actuacion->id_decision." tipoFallo después: ".$tipoFallo."</br>";
       
      /*
      $actuFallo   = new FalloRadicado;
      $actuFallo->juriradicados_vigenciaRadicado  = $request->input('vigenciaRadicado');
      $actuFallo->juriradicados_idRadicado        = $request->input('idRadicado');
      $actuFallo->juritiposfallos_idTipoFallo     = $request->input('selectTipoFallo');
      $actuFallo->juriactuaciones_idActuacion     = $actuProcesal->idActuacion;
      $actuFallo->save();*/
    }
  }
});



Route::get('/juzgados-bk3', function () {

  $datos_basicos = DB::table('datos_basicos2')
  ->join('juzgados', 'datos_basicos2.id_juzgado', 'juzgados.id_juzgado')
  ->groupBy('datos_basicos2.id_juzgado')
  ->orderBy('nom_juzgado', 'asc')
  ->get();


  $i = 0;

  foreach ($datos_basicos as $datos) 
  {
    $juzgado = new Juzgado;
    $juzgado->codigoUnicoJuzgado = 'Mig.';
    $juzgado->nombreJuzgado = "Mig. ".$datos->nom_juzgado;
    $juzgado->activoJuzgado = 0;
    $juzgado->save();

    DB::table('datos_basicos2')
                    ->where('id_juzgado', $datos->id_juzgado)
                    ->update(['idJuzgadoNuevo' => $juzgado->idJuzgado]);


    $i++;

    //$idJuzgadoNuevo = ?
    echo $i.". Anterior: ".$datos->id_juzgado.", Nuevo: ".$juzgado->idJuzgado.". ".$datos->nom_juzgado."<br>";

/*
    DB::table('juriradicados')
                    ->where('mzlConsecutivo', $datos->consecutivo)
                    ->update([
                            'jurijuzgados_idJuzgado' => $idJuzgadoNuevo]);

                            */

  }
});

Route::get('/juzgados-radicados', function () {

  $datos_basicos = DB::table('datos_basicos2')
  ->get();


  $i = 0;

  foreach ($datos_basicos as $datos) 
  {
    DB::table('juriradicados')
                    ->where('mzlConsecutivo', $datos->consecutivo)
                    ->update(['jurijuzgados_idJuzgado' => $datos->idJuzgadoNuevo]);

    $i++;

    echo $i." ".$datos->consecutivo.", Nuevo: ".$datos->idJuzgadoNuevo."<br>";

  }
});


Route::get('/demandantes-juriinvolucrados', function () {

  $radicados = DB::table('juriradicados')
  ->get();


  $i = 0;
  $total = 0;

  foreach ($radicados as $radicado) 
  {
    //Buscar que haya al menos un involucrado
    $involucrados = DB::table('juriinvolucrados')
    ->where('juriradicados_vigenciaRadicado', $radicado->vigenciaRadicado)
    ->where('juriradicados_idRadicado', $radicado->idRadicado)
    ->whereIn('juritipoinvolucrados_idTipoInvolucrado', [1,4,7])
  ->get();

  if(count($involucrados) == 0)
  {
     echo $i." No tiene demandante: ".$radicado->vigenciaRadicado."-".$radicado->idRadicado."<br>";
  }

























  //Buscar con el consecutivo en la tabla pivote d_demandantes
  foreach ($involucrados as $involucrado) 
  {
    $d_demandantes = DB::table('d_demandantes')
    ->join('demandantes', 'd_demandantes.id_demandante', 'demandantes.id_demandante')
    ->where('num_demanda', $involucrado->mzlConsecutivo)
    ->get();


   //Si encontró el demandante..
   if(count($d_demandantes) > 0)
   {
     //Consulta los solicitantes de jurídica
     $d_solicitantes = DB::table('solicitantes')
    ->join('demandantes', 'd_demandantes.id_demandante', 'demandantes.id_demandante')
    ->where('num_demanda', $involucrado->mzlConsecutivo)
    ->get();
   }


  }

  



    $i++;

    //echo $i." ".$radicado->vigenciaRadicado."-".$radicado->idRadicado."<br>";

  }

  echo "total: ".$total;
});




use SQ10\Models\FalloRadicado;
use SQ10\Models\Tema;
use SQ10\Models\MedioControl;
use SQ10\Models\Involucrado;
use SQ10\Models\Solicitante;
use SQ10\Models\CuantiaRadicado;
use SQ10\Models\ActuacionProcesal;
use SQ10\Models\ActuacionResponsable;
use SQ10\Models\Juzgado;

Route::get('/cambiar-activo-fallos3', function () {

  
  $juriactuaciones = DB::table('juriactuaciones')
          ->where('fechaActuacion','>','2019-04-01')
          ->get();


  foreach ($juriactuaciones as $actuacion) 
  {
    
    DB::table('jurifalloradicado')
                    ->where('jurifalloradicado.juriactuaciones_idActuacion', '=', $actuacion->idActuacion)
                    ->update(['activo' => 1]);

  }


 



});


->where('jurifalloradicado.activo','=', 1)



Route::get('/cambio-codigo-radicados', function () {

  $radicados = DB::table('juriradicados')
  ->where('mzlConsecutivo', '!=', Null)
  ->where('mzlConsecutivo', '>=', 10164)
  ->get();
//echo count($radicados); return;
  $i = 0;
  foreach ($radicados as $radicado) 
  {

DB::table('juriradicados')
                      ->where('vigenciaRadicado', $radicado->vigenciaRadicado)
                      ->where('idRadicado', $radicado->idRadicado)
                      ->update(['radicadoJuzgado' => $radicado->codigoProceso]);

    $i++;

    echo $i." ".$radicado->mzlConsecutivo.", Viejo: ".$radicado->radicadoJuzgado.", Nuevo: ".$radicado->codigoProceso."<br>";

  }

});


Route::get('/instancias-bk2-20191115', function () {

  $instancias_old = DB::table('instancia')
                    ->where('fecha_sentencia', '!=', '0000-00-00')
                    ->orWhere('resumen', '!=', '')
                    ->orWhere('cumplimiento', '!=', '')
                    ->orWhere('num_radicacion', '!=', '')
                    //->take(2000)
                    ->get();

  //echo count($instancias_old);return;

  $i = 0;
  foreach ($instancias_old as $actuacion) 
  {
    $i++;
    $tipoActuacion = 0;
    $tipoFallo = 0;

    $radicados = DB::table('juriradicados')
                    ->where('mzlConsecutivo', '=', $actuacion->consecutivo)
                    ->get();

    if(count($radicados) > 0)
    {

      if($actuacion->id_instancia == 1)
      {
        $tipoActuacion = 44;
      }
      else
      {
        $tipoActuacion = 48;
      }


      $actuProcesal   = new ActuacionProcesal;
      $actuProcesal->fechaActuacion                      = $actuacion->fecha_sentencia;
      $actuProcesal->comentarioActuacion                 = $actuacion->resumen." ".$actuacion->cumplimiento." ".$actuacion->num_radicacion;
      $actuProcesal->juriresponsables_idResponsable      = 6;
      $actuProcesal->juriradicados_vigenciaRadicado      = $radicados[0]->vigenciaRadicado;
      $actuProcesal->juriradicados_idRadicado            = $radicados[0]->idRadicado;
      $actuProcesal->fechaRegistro                       = $actuacion->fecha_sentencia;
      $actuProcesal->mzlConsecutivo                      = $actuacion->consecutivo;
      $actuProcesal->juritiposactuaciones_idTipoActuacion  = $tipoActuacion;
      $actuProcesal->save();
      

      switch ($actuacion->id_decision) {
        case '0':
          $tipoFallo = 26;
          break;
        case '1':
          $tipoFallo = 5;
          break;
        case '2':
          $tipoFallo = 6;
          break;
        case '3':
          $tipoFallo = 7;
          break;
        case '4':
          $tipoFallo = 8;
          break;
        case '5':
          $tipoFallo = 9;
          break;
        case '6':
          $tipoFallo = 10;
          break;
        case '7':
          $tipoFallo =11;
          break;
        case '8':
          $tipoFallo = 12;
          break;
        case '9':
          $tipoFallo = 13;
          break;
        case '10':
          $tipoFallo = 14;
          break;
        case '11':
          $tipoFallo = 15;
          break;
        case '12':
          $tipoFallo = 16;
          break;
        case '13':
          $tipoFallo = 17;
          break;
        case '14':
          $tipoFallo = 18;
          break;
        case '15':
          $tipoFallo = 19;
          break;
        case '16':
          $tipoFallo = 20;
          break;
        case '17':
          $tipoFallo = 21;
          break;
        case '18':
          $tipoFallo = 22;
          break;
        case '19':
          $tipoFallo = 23;
          break;
        case '20':
          $tipoFallo = 24;
          break;
        case '21':
          $tipoFallo = 25;
          break;
      }

      $actuFallo   = new FalloRadicado;
      $actuFallo->juriradicados_vigenciaRadicado  = $radicados[0]->vigenciaRadicado;
      $actuFallo->juriradicados_idRadicado        = $radicados[0]->idRadicado;
      $actuFallo->juritiposfallos_idTipoFallo     = $tipoFallo;
      $actuFallo->juriactuaciones_idActuacion     = $actuProcesal->idActuacion;
      $actuFallo->save();

      $actuResponsable  = new ActuacionResponsable;
      $actuResponsable->juriactuaciones_idActuacion               = $actuProcesal->idActuacion;
      $actuResponsable->juriresponsables_idResponsable_apoderado  = 6;
      $actuResponsable->save();

      echo $i.' => actuProcesal: '.$actuProcesal->idActuacion.", actuFallo: ".$actuFallo->idFalloRadicado.", actuResponsable:".$actuResponsable->idActuacionResponsable.". => id_decision antes: ".$actuacion->id_decision." tipoFallo después: ".$tipoFallo."</br>";
       
      /*
      $actuFallo   = new FalloRadicado;
      $actuFallo->juriradicados_vigenciaRadicado  = $request->input('vigenciaRadicado');
      $actuFallo->juriradicados_idRadicado        = $request->input('idRadicado');
      $actuFallo->juritiposfallos_idTipoFallo     = $request->input('selectTipoFallo');
      $actuFallo->juriactuaciones_idActuacion     = $actuProcesal->idActuacion;
      $actuFallo->save();*/
    }
  }
});


Route::get('/demandantes-juriinvolucrados', function () {

  $radicados = DB::table('juriradicados')
  ->get();


  $i = 0;
  $total = 0;

  foreach ($radicados as $radicado) 
  {
    //Buscar que haya al menos un involucrado
    $involucrados = DB::table('juriinvolucrados')
    ->where('juriradicados_vigenciaRadicado', $radicado->vigenciaRadicado)
    ->where('juriradicados_idRadicado', $radicado->idRadicado)
    ->whereIn('juritipoinvolucrados_idTipoInvolucrado', [1,4,7])
  ->get();

  if(count($involucrados) == 0)
  {
     echo $i." No tiene demandante: ".$radicado->vigenciaRadicado."-".$radicado->idRadicado."<br>";
  }



  //Buscar con el consecutivo en la tabla pivote d_demandantes
  foreach ($involucrados as $involucrado) 
  {
    $d_demandantes = DB::table('d_demandantes')
    ->join('demandantes', 'd_demandantes.id_demandante', 'demandantes.id_demandante')
    ->where('num_demanda', $involucrado->mzlConsecutivo)
    ->get();


   //Si encontró el demandante..
   if(count($d_demandantes) > 0)
   {
     //Consulta los solicitantes de jurídica
     $d_solicitantes = DB::table('solicitantes')
    ->join('demandantes', 'd_demandantes.id_demandante', 'demandantes.id_demandante')
    ->where('num_demanda', $involucrado->mzlConsecutivo)
    ->get();
   }


  }

    $i++;

    //echo $i." ".$radicado->vigenciaRadicado."-".$radicado->idRadicado."<br>";

  }

  echo "total: ".$total;
});



Route::get('/correccion-demandantes-juriinvolucrados', function () {


//busco todas los demandas viejas 
$radicados = DB::table('juriradicados')
  ->where('mzlConsecutivo', '!=', Null)
  ->get();


foreach ($radicados as $radicado) 
{
  // 1 = Demandante
  // 4 = Convocante
  // 7 = Accionante

  //declaro variable que almacenara el idSolicitante
  $idSolicitante = 0;
  $crearNuevo = 0;

  //eliminar los involucrados con el idTipoInvolucrado = [1,4,7]
  $involucrados = DB::table('juriinvolucrados')
      ->where('juriradicados_vigenciaRadicado', $radicado->vigenciaRadicado)
      ->where('juriradicados_idRadicado', $radicado->idRadicado)
      ->whereIn('juritipoinvolucrados_idTipoInvolucrado', [1,4,7])
      ->delete();

  //busco los demandantes
  $d_demandantes = DB::table('d_demandantes')
      ->join('demandantes', 'd_demandantes.id_demandante', 'demandantes.id_demandante')
      ->where('num_demanda', $radicado->mzlConsecutivo)
      ->get();


 //Si encontró el demandante..
 if(count($d_demandantes) > 0)
 {
      foreach ($d_demandantes as $demandante) 
      {
          //Si el documento es vacio
          if(demandante->documento!="")
          {
              //Si la longitud del documento es mayor a 8
              if(strlen(demandante->documento) >= 8)
              {
                  //Consulta los solicitantes
                  $solicitantes = DB::table('solicitantes')
                      ->where('documentoSolicitante',demandante->documento)
                      ->get();

                  if(count($solicitantes) > 0)
                  {
                      $idSolicitante = $solicitantes[0]->idSolicitante;
                  }
                  else 
                  {
                      $crearNuevo = 1;
                  }
              }
              else 
              {
                  $crearNuevo = 1;
              }
          }
          else 
          {
              $crearNuevo = 1;
          }
              
          //Si hay que crearlo
          if($crearNuevo == 1) 
          {
              $solicitante = new Solicitante;
              $solicitante->documentoSolicitante   = $demandante->documento;
              $solicitante->nombreSolicitante    = $demandante->nom_demandante;
              $solicitante->password = 'mig';
              $solicitante->creadoVentanilla   = 0; //Creado en ventanilla
              $solicitante->tiposidentificacion_idTipoIdentificacion = 1;
              $solicitante->ciudades_idCiudad = 339;
              $solicitante->save();

              $idSolicitante = $solicitante->idSolicitante;
          }
         

          $demandanteInvolucrado = new Involucrado;
          $demandanteInvolucrado->juritipoinvolucrados_idTipoInvolucrado = 1; //revisar como seria 1 o 4 o 8
          $demandanteInvolucrado->solicitantes_idSolicitante  = $idSolicitante;
          $demandanteInvolucrado->juriradicados_vigenciaRadicado  = $radicado->vigenciaRadicado;
          $demandanteInvolucrado->juriradicados_idRadicado  = $radicado->idRadicado;
          $demandanteInvolucrado->save();
      }
  }

});



Route::get('/correccion-demandantes', function () {

//busco todas los demandas viejas 
$radicados = DB::table('juriradicados')
  ->where('mzlConsecutivo', '!=', Null)
  ->get();
$i=1;
foreach ($radicados as $radicado) 
{
  // 1 = Demandante
  // 4 = Convocante
  // 7 = Accionante

   //1 Proceso judicial

        $tipoInvolucrado = 1;//1 Demandante

        if($radicado->juritipoprocesos_idTipoProceso == 2)//2 Conciliación Prejudicial
        {
          $tipoInvolucrado = 4;//4 Convocante
        }

        if($radicado->juritipoprocesos_idTipoProceso == 3)//3 Tutelas
        {
          $tipoInvolucrado = 7;//7 Accionante
        }

  //eliminar los involucrados con el idTipoInvolucrado = [1,4,7]
  $involucrados = DB::table('juriinvolucrados')
      ->where('juriradicados_vigenciaRadicado', $radicado->vigenciaRadicado)
      ->where('juriradicados_idRadicado', $radicado->idRadicado)
      ->where('fechaMigrado', '!=', Null)
        ->update(['juritipoinvolucrados_idTipoInvolucrado' => $tipoInvolucrado]);
      

echo "Fila: ".$i.".  Proceso: ".$radicado->vigenciaRadicado."-".$radicado->idRadicado.". TipoProceso: ".$radicado->juritipoprocesos_idTipoProceso.". TipoInvolucradoNuevo: ".$tipoInvolucrado."<br>";
 $i++;

}

});