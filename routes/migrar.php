<?php  
use SQ10\Models\Usuario;
use SQ10\Models\Radicado;
use SQ10\Models\Solicitante;
use SQ10\Models\Involucrado;
use SQ10\Models\EstadoEtapa;
use SQ10\Models\Responsable;
use SQ10\Models\ArchivoMzl;
use SQ10\Models\ActuacionProcesal;


Route::get('/demandas', function () {

  $demandas = DB::table('demandas')
                  ->orderBy('consecutivo', 'ASC')
                  ->get();

  foreach($demandas as $demanda)
  {
    echo "<br>";
    echo "Consecutivo demanda: ".$demanda->consecutivo;
    echo "<br>";

    $datosbasicos = DB::table('datos_basicos')
    ->where('consecutivo', $demanda->consecutivo)
                      ->first();

    if(count($datosbasicos) > 0)
    {
      //vigenciaRadicado
      if($datosbasicos->fecha_notifica == NULL)
      {
        $vigencia = "0000";

        //fechaRadicado
        $fechaRadicado = "0000-00-00";
        //-------------
      }
      else
      {
        $vigencia   = substr($datosbasicos->fecha_notifica, 0, 4);

        //fechaRadicado
        $fechaRadicado = $datosbasicos->fecha_notifica;
        //-------------
      }
      //---------------

      //codigoProceso
      $codigoProceso = str_replace("-", "", $demanda->num_radicacion);
      //-------------
      
      //hechos
      $hechos = $demanda->tema." - ".$datosbasicos->hechos." - ".$datosbasicos->contestacion;
      //-------------

      //estado
      $estado = $demanda->nuevoEstadoRadicado;
      //-------------

      //mediosControl
      $medioControl = $demanda->nuevoMedioControl;
      //-------------

      //juzgado
      $juzgado = $datosbasicos->nuevoJuzgado;
      //-------------

      //juzgado
      $tipoProceso = $demanda->nuevoTipo;
      //-------------

      //consecutivo
      $consecutivo = $demanda->consecutivo;
      //-------------

      $radicado = new Radicado;
      $radicado->vigenciaRadicado                          = $vigencia;
      $radicado->fechaRadicado                             = $fechaRadicado;
      $radicado->codigoProceso                             = $codigoProceso;        
      $radicado->descripcionHechos                         = $hechos;
      $radicado->juriestadosradicados_idEstadoRadicado     = $estado;
      $radicado->juriacciones_idAccion                     = 1;
      $radicado->fechaNotificacion                         = $fechaRadicado;
      $radicado->jurimedioscontrol_idMediosControl         = $medioControl;
      $radicado->jurijuzgados_idJuzgado                    = $juzgado;
      $radicado->juritipoprocesos_idTipoProceso            = $tipoProceso;
      $radicado->mzlConsecutivo                            = $consecutivo;
      $radicado->mzlMigracion                              = 1;//Migración si
      $radicado->save();

      echo $radicado->vigenciaRadicado."-".$radicado->idRadicado."<br>";
        
    } 
    
  }
});


Route::get('/demandantes', function () {

  $demandantes = DB::table('d_demandantes')
                  ->where('num_demanda', '>', '11529')
                  //->where('num_demanda', '<=', '11600')
                  ->orderBy('num_demanda', 'ASC')
                  ->get();

  foreach($demandantes as $demandante)
  {
    echo "<br>";
    echo "Consecutivo demanda: ".$demandante->num_demanda;
    echo "<br>";
  
    $persona = DB::table('demandantes')
                    ->where('id_demandante', $demandante->id_demandante)
                    ->first();

    //Si lo encontró en la tabla de demandantes
    if(count($persona) > 0)
    {
      //Lo busca en la tabla de solicitantes de alcmanizales
      $solicitante = DB::table('solicitantes')
                    ->where('documentoSolicitante', '=', $persona->documento)
                    ->first();
      
      if(count($solicitante) > 0)
      {
        $idDemandante = $solicitante->idSolicitante;
        echo "idDemandante existe: ".$idDemandante;
        echo "<br>";
      }
      else
      {
        $solicitante   = new Solicitante;
        $solicitante->documentoSolicitante   = $persona->documento;
        $solicitante->nombreSolicitante    = $persona->nom_demandante;
        $solicitante->password    = Hash::make($persona->documento);
        $solicitante->creadoVentanilla   = 1; //0 Creado en ventanilla
        $solicitante->save();

        $idDemandante = $solicitante->idSolicitante;
        echo "idDemandante nuevo: ".$idDemandante;
        echo "<br>";
      }

      //Busca la vigencia y el radicado del proceso
      $radicado = DB::table('juriradicados')
                      ->where('mzlConsecutivo', '=', $demandante->num_demanda)
                      ->first();

      if(count($radicado) > 0)
      {
        $demandanteInvolucrado = new Involucrado;
        $demandanteInvolucrado->juritipoinvolucrados_idTipoInvolucrado      = 1;// Demandante
        $demandanteInvolucrado->solicitantes_idSolicitante  = $idDemandante;
        $demandanteInvolucrado->juriradicados_vigenciaRadicado  = $radicado->vigenciaRadicado;
        $demandanteInvolucrado->juriradicados_idRadicado  = $radicado->idRadicado;
        $demandanteInvolucrado->mzlConsecutivo  = $demandante->num_demanda;
        $demandanteInvolucrado->save();

        echo "involucrado creado: ".$demandanteInvolucrado->idInvolucrado;
        echo "<br>";
      }
    }
  }

});

Route::get('/abogados', function () {
  $abogados = DB::table('d_abogado')
                  ->orderBy('consecutivo', 'ASC')
                  ->get();

  foreach($abogados as $abogado)
  {
    echo "<br>";
    echo "Consecutivo demanda: ".$abogado->consecutivo;
    echo "<br>";
    echo "Documento abogado: ".$abogado->doc_abogado;
    echo "<br>";

    //Averigua si ya existe el responsable
    $respo = DB::table('juriresponsables')
                    ->select('idUsuario', 'idResponsable')
                    ->join('usuarios', 'juriresponsables.usuarios_idUsuario', '=', 'usuarios.idUsuario')
                    ->where('documentoUsuario', $abogado->doc_abogado)
                    ->get();

    echo $respo[0]->idResponsable;."</br>"
  }
});

Route::get('/archivos', function () {

  $archivos = DB::table('anexos')
                  ->orderBy('consecutivo', 'ASC')
                  ->get();

  foreach($archivos as $archivo)
  {
    echo "<br>";
    echo "Consecutivo demanda: ".$archivo->consecutivo;
    echo "<br>";

    //Busca la vigencia y el radicado del proceso
    $radicado = DB::table('juriradicados')
                    ->where('mzlConsecutivo', '=', $archivo->consecutivo)
                    ->first();


    if(count($radicado) > 0)
    {      
      $file = new ArchivoMzl;
      $file->nombreArchivo = $archivo->nombreArchivo;
      $file->fechaRegistro = $archivo->fechaRegistro;
      $file->juriradicados_vigenciaRadicado = $radicado->vigenciaRadicado;        
      $file->juriradicados_idRadicado = $radicado->idRadicado;
      $file->mzlConsecutivo = $archivo->consecutivo;
      $file->instancia = $archivo->instancia;
      $file->save();

      echo $file->idArchivo." => ".$file->mzlConsecutivo."<br>";
        
    } 
    
  }
});

Route::get('/juzgados', function () {
  $total =0;
  $radicados = DB::table('juriradicados')
                  ->where('jurijuzgados_idJuzgado', '!=', NULL)
                  ->get();
  
  foreach ($radicados as $radicado) 
  {
    $idJuz = $radicado->jurijuzgados_idJuzgado;

    $juzgado = DB::table('jurijuzgadosold')
                  ->where('idJuzgado', '=', $idJuz)
                  ->first();

    if(count($juzgado) > 0)
    { 
      //Busca la vigencia y el radicado del proceso
      $juzgado2 = DB::table('jurijuzgados')
                      ->where('codigoUnicoJuzgado', '=', $juzgado->codigoUnicoJuzgado)
                      ->first();

      if(count($juzgado2) > 0)
      {      
        DB::table('juriradicados')
                  ->where('jurijuzgados_idJuzgado', '=', $idJuz)
                  ->update(['nuevoJuzgado' => $juzgado2->idJuzgado]);

        echo "Encontrado en jurijuzgados:".$juzgado2->codigoUnicoJuzgado."<br>";
        $total++;
      }
      else
      {
        echo "No se encontro en jurijuzgados:".$idJuz;
      } 
    }
  }

echo "TOTAL: ".$total." de un total de radicados de ".count($radicados);
});

Route::get('/actuaciones', function () {

  $ins = 2; // <======= cambiar

  $instancias = DB::table('instancia')
                ->where('id_instancia', $ins)
                ->orderBy('consecutivo', 'ASC')
                ->get();
  
  foreach($instancias as $instancia)
  {
    echo "Consecutivo demanda: ".$instancia->consecutivo;
    echo "<br>";
    
    //Busca la vigencia y el radicado del proceso
    $radicado = DB::table('juriradicados')
                  ->where('mzlConsecutivo', '=', $instancia->consecutivo)
                  ->first();

    if(count($radicado) > 0)
    {   
      
      if($radicado->juritipoprocesos_idTipoProceso == 1)
      {
        if($ins == 1)
        {
          $etapa = 1;
        }
        else
        {
          $etapa = 4;
        }
      }
      elseif($radicado->juritipoprocesos_idTipoProceso == 2)
      {
        $etapa = 7;
      }
      elseif($radicado->juritipoprocesos_idTipoProceso == 3)
      {
        $etapa = 10;
      }
      
      $actuProcesal   = new ActuacionProcesal;
      $actuProcesal->jurietapas_idEtapa                   = $etapa;
      $actuProcesal->fechaActuacion                       = $instancia->fecha_sentencia;
      $actuProcesal->comentarioActuacion                  = $instancia->resumen;
      $actuProcesal->juritiposactuaciones_idTipoActuacion = $instancia->nuevaActuacion;
      $actuProcesal->jurijuzgados_idJuzgado               = $instancia->nuevoJuzgado;
      //$actuProcesal->juriresponsables_idResponsable       = $instancia->nuevaActuacion;
      $actuProcesal->juriradicados_vigenciaRadicado       = $radicado->vigenciaRadicado;
      $actuProcesal->juriradicados_idRadicado             = $radicado->idRadicado;
      $actuProcesal->mzlConsecutivo                          = $instancia->consecutivo;
      $actuProcesal->save();

      echo "Guarda Actuación: ".$radicado->vigenciaRadicado."-".$radicado->idRadicado."<br>";
    }   
    else
    {
      echo "No encontrado radicado vigencia: ".$instancia->consecutivo."<br>";
    }
    
    echo "==============================================<br>";

  }
});



Route::get('/actuaciones2', function () {

  $ins = 1; // <======= cambiar

  $instancias = DB::table('historial')
                ->orderBy('numero', 'ASC')
                ->get();
  
  foreach($instancias as $instancia)
  {
    echo "Consecutivo demanda: ".$instancia->consecutivo;
    echo "<br>";
    
    //Busca la vigencia y el radicado del proceso
    $radicado = DB::table('juriradicados')
                  ->where('mzlConsecutivo', '=', $instancia->consecutivo)
                  ->first();

    if(count($radicado) > 0)
    {   
      
      if($radicado->juritipoprocesos_idTipoProceso == 1)
      {
        if($ins == 1)
        {
          $etapa = 1;
        }
        else
        {
          $etapa = 4;
        }
      }
      elseif($radicado->juritipoprocesos_idTipoProceso == 2)
      {
        $etapa = 7;
      }
      elseif($radicado->juritipoprocesos_idTipoProceso == 3)
      {
        $etapa = 10;
      }
      
      $actuProcesal   = new ActuacionProcesal;
      $actuProcesal->jurietapas_idEtapa                   = $etapa;
      $actuProcesal->fechaActuacion                       = $instancia->fecha_acto;
      $actuProcesal->comentarioActuacion                  = $instancia->anotacion;
      //$actuProcesal->juritiposactuaciones_idTipoActuacion = $instancia->nuevaActuacion;
      //$actuProcesal->jurijuzgados_idJuzgado               = $instancia->nuevoJuzgado;
      //$actuProcesal->juriresponsables_idResponsable       = $instancia->nuevaActuacion;
      $actuProcesal->juriradicados_vigenciaRadicado       = $radicado->vigenciaRadicado;
      $actuProcesal->juriradicados_idRadicado             = $radicado->idRadicado;
      $actuProcesal->mzlConsecutivo                          = $instancia->consecutivo;
      $actuProcesal->save();

      echo "Guarda Actuación: ".$radicado->vigenciaRadicado."-".$radicado->idRadicado."<br>";
    }   
    else
    {
      echo "No encontrado radicado vigencia: ".$instancia->consecutivo."<br>";
    }
    
    echo "==============================================<br>";

  }
});
?>