@php
  use SQ10\helpers\Util as Util;
@endphp

@extends('layouts.master')
  <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('css/actuacion.css') }}">
  <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('css/acordeon.css') }}">
@section('cabecera')
  <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('css/actuacion.css') }}">
  <link rel="stylesheet" href="{{ asset('css/gauge.css') }}">
  <script src="{{asset('js/js_actuacionProceJudi/actuacionProceJudi.js?v=11')}}"></script>
  <style media="screen">
  tr > td.media-left {
    width: 72px !important;
    height: 30px;
    padding: 0 10px;
    background-color: #eee;
  }
  tr > td.media-left h2{
    margin: 14px 0;
    line-height: 6px;
  }
  .table .media .media-body > span {
    color: #999;
  }
  .table .media .media-body span h4 {
    color: #777;
    font-weight: bold;
  }
  .table .media .media-body span strong {
    color: #777;
  }
  </style>
@endsection
@section('contenido')
  <!-- RIBBON -->
  <input type="hidden" value="{{$proceso[0]->juriradicados_vigenciaRadicado}}" id="vigenciaRadicado">
  <input type="hidden" value="{{$proceso[0]->juriradicados_idRadicado}}" id="idRadicado">
  <input type="hidden" value="{{$proceso[0]->juritipoprocesos_idTipoProceso}}" id="idTipoProceso">
  <input type="hidden" value="{{$proceso[0]->mzlConsecutivo}}" id="mzlConsecutivo">
  <input type="hidden" value="{{$idEstadoEtapa}}" id="idEstadoEtapa">
  <input type="hidden" value="{{$responsable}}" id="responsable">


  <!-- NUEVO DEMANDANTE-->
  <div class="modal fade" id="modalAgregarDemandante" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">                
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title" id="myLargeModalLabel"><i class="fa fa-money"></i> Nuevo Demandante</h5>
            </div>
            <div id="resultadoAgregarDemandandante">
              <!-- CONTENIDO AJAX -->
            </div>
        </div>
    </div>
</div>
<!-- NUEVO DEMANDANTE-->

<!-- EDITAR DEMANDANTE-->
<div class="modal fade" id="modalEditarDemandante" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">                
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title" id="myLargeModalLabel"><i class="fa fa-money"></i> Modificar Demandante</h5>
            </div>
            <div id="resultadoEditarDemandante">
              <!-- CONTENIDO AJAX -->
            </div>
        </div>
    </div>
</div>
<!-- EDITAR DEMANDANTE-->



  <div id="ribbon">
    <span class="ribbon-button-alignment">
      <a href="{{ asset('home') }}">
        <span id="refresh" class="btn btn-ribbon" rel="tooltip" data-placement="bottom" data-original-title="Ir al inicio" data-html="true">
          <i class="fa fa-home"></i>
        </span>
      </a>
    </span>
    <!-- breadcrumb -->
    <ol class="breadcrumb">
      <li>Inicio</li><li>Proceso</li><li>Actuación</li>
    </ol>
    <!-- end breadcrumb -->
  </div>
  <!-- END RIBBON -->

  <!-- MAIN CONTENT -->
  <div id="content">
    <div class="bootstrap snippet">
      <div class="row">
        <!-- BEGIN USER PROFILE -->
        <div class="col-md-12">
          <div class="grid profile">
            <div class="grid-header grid-header-blue">
              <div class="col-xs-2">
                @php
                  $foto = '../public/juriArch/entidad/usuarios/'.$proceso[0]->documentoUsuario.'.jpg';
                  if(file_exists($foto))
                  {
                    $fotoAbogado = asset('juriArch/entidad/usuarios/'.$proceso[0]->documentoUsuario.'.jpg');
                  }
                  else
                  {
                    $fotoAbogado = asset('img/avatar-profile.png');
                  }
                  //Monica lo pidio asi pero cotacio dice que no
                  //$apoderados = Util::apoderadosRadicado($proceso[0]->vigenciaRadicado, $proceso[0]->idRadicado);
                  $apoderados = Util::apoderadosActivosRadicado($proceso[0]->vigenciaRadicado, $proceso[0]->idRadicado);
                @endphp
                <img src="{{$fotoAbogado}}" class="img-circle" alt="">
              </div>
              <div class="col-xs-6">
                <h3> {{$proceso[0]->vigenciaRadicado."-".$proceso[0]->idRadicado}}</h3>
                <p class="abogado">
                  @if(count($apoderados) > 0)
                     @foreach($apoderados as $apoderado)
                      {{$apoderado->nombresUsuario}}
                      @if($proceso[0]->juriresponsables_idResponsable_titular == $apoderado->idResponsable)
                        <strong>: Principal</strong>
                      @endif
                      </br>
                     @endforeach
                  @endif
                </p>
                <p>Proceso asignado el {{ucfirst(utf8_encode(strftime("%A %d de %B de %Y", strtotime($proceso[0]->fechaInicioEstado))))}}</p>
                <p>Estado del proceso: {{$proceso[0]->nombreEstadoRadicado}}</p>
              </div>
              <div class="col-xs-4 text-right" style="display:block">
                <a href="{{ asset('mis-procesos/index/1/'.$proceso[0]->juritipoprocesos_idTipoProceso.'/'.$idResponsable)}}" class="btn btn-sm btn-success">
                  <i class="glyphicon glyphicon-chevron-left"></i> Volver atrás
                </a>

                @if($responsable == 1)
                  <button class="btn btn-danger btn-guardar-dependencia" onclick="repartoInterno();">
                    <i class="fa fa-users"></i> <a id="eventUrl" style="color:#fff; text-decoration:none;"> Reparto Interno</a>
                  </button>

                  <button class="btn btn-danger btn-guardar-dependencia" onclick="modalAsociarProceso({{$proceso[0]->vigenciaRadicado}} ,{{$proceso[0]->idRadicado}});">
                    <i class="fa fa-plus"></i> <a id="eventUrl" style="color:#fff; text-decoration:none;"> Asociar Tutelas </a>
                  </button>
                  
                  @if($proceso[0]->juriresponsables_idResponsable_titular == $idResponsable)
                    <button class="btn btn-primary btn-guardar-dependencia" onclick="descargarPoder();">
                      <i class="fa fa-file-word-o"></i> Descargar poder
                    </button>
                  @endif
                @endif
                
                @if($datosResponsable->juriroles_idRol == 2 || $datosResponsable->permiso == 1)
                  <button class="btn btn-danger btn-guardar-dependencia" onclick="agregarApoderado();">
                    <i class="fa fa-users"></i> <a id="eventUrl" style="color:#fff; text-decoration:none;"> Agregar apoderado</a>
                  </button>
                @endif
              </div>
            </div>
            <div class="grid-body">
              <div class="tab" role="tabpanel">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                  <li role="presentation" class="active"><a href="#Section1" aria-controls="home" role="tab" data-toggle="tab">Datos Generales</a></li>
                  <!-- 2 Actuaciones procesales -->
                  @if((in_array(2, $modulosActivos)))
                    <li role="presentation"><a href="#Section2" aria-controls="profile" role="tab" data-toggle="tab">Actuaciones Procesales</a></li>
                  @endif

                  <!-- 1 Provisión y calificación -->
                  @if((in_array(1, $modulosActivos)))
                    <li role="presentation"><a href="#Section3" onclick="pretensiones();" aria-controls="settings" role="tab" data-toggle="tab">Provisión Contable-Calificación del Riesgo</a></li>
                  @endif

                  <!-- 4 Valoración de fallos en contra -->
                  @if((in_array(4, $modulosActivos)))
                    <li role="presentation"><a href="#Section7" onclick="cargarValoracionesFalloComun({{$proceso[0]->vigenciaRadicado}}, {{$proceso[0]->idRadicado}});" aria-controls="settings" role="tab" data-toggle="tab">Valoración de fallos en contra</a></li>
                  @endif

                  <!-- 5 Comité de Conciliación -->
                  @if((in_array(5, $modulosActivos)))
                    <li role="presentation"><a href="#Section4" aria-controls="settings" role="tab" data-toggle="tab">Comité de Conciliación</a></li>
                  @endif

                  <!-- Expediente Digital -->
                  <li role="presentation"><a href="#Section5" aria-controls="settings" role="tab" data-toggle="tab">Expediente Digital</a></li>

                  <!-- 3 Archivos Migrados -->
                  @php
                    $expedientesMigradosContador = Util::expedienteDigitalMigradosContador($proceso[0]->mzlConsecutivo);
                  @endphp
                  @if($expedientesMigradosContador > 0)
                    @if((in_array(3, $modulosActivos)))
                      <li role="presentation"><a href="#Section8" aria-controls="settings" role="tab" data-toggle="tab">Archivos Migrados</a></li>
                    @endif
                  @endif

                  <!-- 6 Procedimiento -->
                  @if((in_array(6, $modulosActivos)))
                    <li role="presentation"><a href="#Section6" aria-controls="settings" role="tab" data-toggle="tab">Procedimiento</a></li>
                  @endif
                </ul>
                <!-- Tab panes -->
                <div class="tab-content" style="height:-webkit-fill-available;padding-top:20px">
                  <!-- Datos Generales -->
                  <div role="tabpanel" class="tab-pane fade in active" id="Section1">
                    <h3>Datos Generales</h3>
                    <p>
                      <div class="bootstrap snippet">
                        <div class="div">
                          <div class="col-sm-12">
                            <div class="panel-group drop-accordion" id="accordion" role="tablist" aria-multiselectable="true">
                              <!-- Datos del Proceso -->
                              <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="heading1">
                                  <h4 class="panel-title">
                                    <a class="collapse-controle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse1" aria-expanded="false" aria-controls="collapse1">
                                      Datos del Proceso
                                      <span class="expand-icon-wrap"><i class="fa expand-icon"></i></span>
                                    </a>
                                  </h4>
                                </div>
                                <div id="collapse1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading1" aria-expanded="false" style="height: 0px;">
                                  <div class="panel-body">
                                    @if($responsable == 1)
                                      <div class="row" style="padding-left:0px">
                                        <div class="col-sm-12">
                                          <button class="btn btn-xs btn-primary btn-rounded" onclick="modificarDatosGenerales()"><i class="fa fa-edit"></i> Modificar Datos</button>
                                        </div>
                                      </div>
                                    @endif
                                    <div class="row">
                                      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <table id="tableReport" class="table table-hover table-striped ">
                                          <tbody>
                                            <tr class="media" data-id="30">
                                              <td class="media-left">
                                                <h2><i class="fa fa-check-circle"></i> </h2>
                                              </td>
                                              <td class="media-body">
                                                <span>Código único del proceso:
                                                  <h4>
                                                    <span id="textoCodigoProceso">
                                                      {{$proceso[0]->codigoProceso}}
                                                    </span>
                                                  </h4>
                                                </span>
                                              </td>
                                            </tr>
                                            <tr class="media" data-id="30">
                                              <td class="media-left">
                                                <h2><i class="fa fa-check-circle"></i> </h2>
                                              </td>
                                              <td class="media-body">
                                                <span>Nombre del Proceso:<h4>
                                                  {{$proceso[0]->nombreTipoProceso}}
                                                </h4></span>
                                              </td>
                                            </tr>
                                            <tr class="media" data-id="30">
                                              <td class="media-left">
                                                <h2><i class="fa fa-check-circle"></i> </h2>
                                              </td>
                                              <td class="media-body">
                                                <span>Tema de la demanda:
                                                  <h4>
                                                    <span id="textoTema">
                                                      {{$proceso[0]->nombreTema}}
                                                    </span>
                                                  </h4>
                                                </span>
                                              </td>
                                            <tr>
                                            <tr>
                                              <td class="media-left">
                                                <h2><i class="fa fa-check-circle"></i> </h2>
                                              </td>
                                              <td class="media-body">
                                                <span>Asunto de la demanda:
                                                  <h4>
                                                    <span id="textoAsunto">
                                                      <strong>{{$proceso[0]->asunto}}</strong>
                                                    </span>
                                                  </h4>
                                                </span>
                                              </td>
                                            </tr>
                                            <tr class="media" data-id="30">
                                              <td class="media-left">
                                                <h2><i class="fa fa-check-circle"></i> </h2>
                                              </td>
                                              <td class="media-body">
                                                <span>Fecha de notificación:
                                                  <h4>
                                                    <span>
                                                      {{ucfirst(utf8_encode(strftime("%A %d de %B de %Y", strtotime($proceso[0]->fechaNotificacion))))}}
                                                    </span>
                                                  </h4>
                                                </span>
                                              </td>
                                            </tr>
                                            <tr class="media" data-id="30">
                                              <td class="media-left">
                                                <h2><i class="fa fa-check-circle"></i> </h2>
                                              </td>
                                              <td class="media-body">
                                                <span>Juzgado:
                                                  <h4>
                                                    <span id="textoNombreJuzgado">
                                                      {{$proceso[0]->nombreJuzgado}}
                                                    </span>
                                                  </h4>
                                                </span>
                                              </td>
                                            </tr>
                                            @if(count($agendas) > 0)
                                              <tr class="media" data-id="30">
                                                <td class="media-left">
                                                  <h2><i class="fa fa-check-circle"></i> </h2>
                                                </td>
                                                <td class="media-body">
                                                  @foreach($agendas as $agenda)
                                                    <span>Fecha:<h4>{{ucfirst(utf8_encode(strftime("%b %d de %Y", strtotime($agenda->fechaInicioAgenda))))}} -
                                                      {{ date('h:i A', strtotime($agenda->fechaInicioAgenda))}}</h4></span>
                                                    <span>Comentario:<h4>{{$agenda->asuntoAgenda}}</h4></span>
                                                    @if($agenda->critico == 1)
                                                      <span><h4>Agenda Crítica</h4></span>
                                                    @endif
                                                    <br>
                                                  @endforeach
                                                </td>
                                              </tr>
                                            @endif
                                          </tbody>
                                        </table>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <!-- #Datos del Proceso -->

                              <!-- Demandantes -->
                              <!--<div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="heading2">
                                  <h4 class="panel-title">
                                    <a class="collapse-controle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse2" aria-expanded="false" aria-controls="collapse2">
                                      Demandantes
                                      <span class="expand-icon-wrap"><i class="fa expand-icon"></i></span>
                                    </a>
                                  </h4>
                                </div>
                                <div id="collapse2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading2" aria-expanded="false" style="height: 0px;">
                                  <div class="panel-body">
                                    @if($responsable == 1)
                                      <div class="row" style="padding-left:20px">
                                        <div class="col-sm-12">
                                          <button class="btn btn-xs btn-primary btn-rounded" onclick="nuevoDemandante()"><i class="fa fa-save"></i> Agregar Demandante</button>
                                        </div>
                                      </div>
                                    @endif
                                    <div id="resultadoDemandantes">
                                  
                                    </div>
                                  </div>
                                </div>
                              </div>-->
                              <!-- #Demandantes -->


                              <!-- Accionantes -->
                              <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="heading2">
                                  <h4 class="panel-title">
                                    <a class="collapse-controle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse6" aria-expanded="false" aria-controls="collapse6">
                                      Accionantes
                                      <span class="expand-icon-wrap"><i class="fa expand-icon"></i></span>
                                    </a>
                                  </h4>
                                </div>
                                <div id="collapse6" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading2" aria-expanded="false" style="height: 0px;">
                                  <div class="panel-body">
                                    @if($responsable == 1)
                                      <div class="row" style="padding-left:20px">
                                        <div class="col-sm-12">
                                          <button class="btn btn-xs btn-primary btn-rounded" onclick="nuevoAccionante()"><i class="fa fa-save"></i> Agregar Accionante</button>
                                        </div>
                                      </div>
                                    @endif
                                    <div id="resultadoAccionantes">
                                    
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <!-- #Accionantes -->

                              <!-- Accionado Interno -->
                              <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="heading3">
                                  <h4 class="panel-title">
                                    <a class="collapsed collapse-controle" data-toggle="collapse" data-parent="#accordion" href="#collapse3" aria-expanded="false" aria-controls="collapse3">
                                      Accionado Interno
                                      <span class="expand-icon-wrap"><i class="fa expand-icon"></i></span>
                                    </a>
                                  </h4>
                                </div>
                                <div id="collapse3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading3" aria-expanded="false">
                                  <div class="panel-body">
                                    @if($responsable == 1)
                                      <div class="row" style="padding-left:20px">
                                        <div class="col-sm-12">
                                          <button class="btn btn-xs btn-primary btn-rounded" onclick="nuevaDependenciaProceso(8)"><i class="fa fa-save"></i> Agregar Accionado Interno</button>
                                        </div>
                                      </div>
                                    @endif
                                    <div id="resultadoAccionadosInternos"></div>
                                  </div>
                                </div>
                              </div>
                              <!-- #Accionado Interno -->

                              <!-- Accionado externo -->
                              <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="heading4">
                                  <h4 class="panel-title">
                                    <a class="collapsed collapse-controle" data-toggle="collapse" data-parent="#accordion" href="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                      Accionados externos
                                      <span class="expand-icon-wrap"><i class="fa expand-icon"></i></span>
                                    </a>
                                  </h4>
                                </div>
                                <div id="collapse4" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading4" aria-expanded="false">
                                  <div class="panel-body">
                                    @if($responsable == 1)
                                      <div class="row" style="padding-left:20px">
                                        <div class="col-sm-12">
                                          <button class="btn btn-xs btn-primary btn-rounded" onclick="nuevoExterno(9)"><i class="fa fa-save"></i> Agregar Accionado Externo</button>
                                        </div>
                                      </div>
                                    @endif
                                    <div id="resultadoAccionadoExterno"></div>
                                  </div>
                                </div>
                              </div>
                              <!-- #Abogados Apoderados -->

                              <!-- Causas y Hechos -->
                              <div class="panel panel-default">
                                <div class="panel-heading" role="tab" id="heading5">
                                  <h4 class="panel-title">
                                    <a class="collapsed collapse-controle" data-toggle="collapse" data-parent="#accordion" href="#collapse5" aria-expanded="false" aria-controls="collapse5">
                                      Causas y Hechos
                                      <span class="expand-icon-wrap"><i class="fa expand-icon"></i></span>
                                    </a>
                                  </h4>
                                </div>
                                <div id="collapse5" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading5" aria-expanded="false">
                                  <div class="panel-body">
                                    <div class="row">
                                      <div class="row" style="padding-left:15px; margin-bottom: 15px;">
                                        <div class="col-sm-12">
                                          @if($responsable == 1)
                                            <button class="btn btn-xs btn-primary btn-rounded" onclick="nuevoArchivo()"><i class="fa fa-save"></i> Agregar Archivo</button>
                                          @endif
                                        </div>
                                      </div>
                                      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <table id="tableReport" class="table table-hover table-striped ">
                                          <tbody>
                                            <tr class="media" data-id="30">
                                              <td class="media-left">
                                                
                                              </td>
                                              <td class="media-body">
                                                <span><strong>Causas y hechos:</strong><h5>{{$proceso[0]->descripcionHechos}}</h5></span>
                                              </td>
                                            </tr>

                                            <tr class="media" data-id="30">
                                              <td class="media-left">
                                                <h2><i class="fa fa-check-circle"></i> </h2>
                                              </td>
                                              <td class="media-body">
                                                <div id="resultadoArchivosIniciales"></div>
                                              </td>
                                            </tr>
                                          </tbody>
                                        </table>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <!-- #Causas y Hechos -->
                            </div>
                            <!-- /#accordion -->
                          </div>
                        </div>
                      </div>
                    </p>
                  </div>
                  <!-- #Datos Generales -->

                  <!-- Actuaciones Procesales -->
                  <div role="tabpanel" class="tab-pane fade" id="Section2">
                    <h3>Actuaciones Procesales</h3>
                    <div id="resultadoInstanciasProceso"></div>
                  </div>
                  <!-- #Actuaciones Procesales -->

                  <!-- Provisión Contable -->
                  <div role="tabpanel" class="tab-pane fade" id="Section3">
                    <h3>Provisión Contable</h3>
                    <div id="resultadoValorPretensiones"></div>
                  </div>
                  <!-- #Provisión Contable -->

                  <!-- Comité de Conciliación -->
                  <div role="tabpanel" class="tab-pane fade" id="Section4">
                    <h3>Comité de Conciliación</h3>
                    <p>
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus pretium, metus et scelerisque dignissim, ligula est imperdiet nisl, sit amet malesuada nunc felis in nisi. Nullam dapibus ligula dui, in rhoncus purus euismod nec. Duis in lacinia neque. Etiam tellus.
                    </p>
                  </div>
                  <!-- #Comité de Conciliación -->

                  <!-- Expediente Digital -->
                  <div role="tabpanel" class="tab-pane fade" id="Section5">
                    <h3>Expediente Digital</h3>
                    <div id="resultadoExpedienteDigital"></div>
                  </div>
                  <!-- #Expediente Digital -->

                  <!-- Procedimiento -->
                  <div role="tabpanel" class="tab-pane fade" id="Section6">
                    <h3>Procedimiento</h3>
                    <p>
                      <div id="resultadoPasosAbogado">
                        <!--CARGAN LOS PASOS DE LA ACTUACIÓN-->
                      </div>
                    </p>
                  </div>
                  <!-- #Procedimiento -->

                  <!-- Valoración de Fallos en Contra -->
                  <div role="tabpanel" class="tab-pane fade" id="Section7">
                    <h3>Valoración de Fallos en Contra</h3>
                    <p>
                      <div id="ajax-valoraciones">
                        <!--CARGAN LAS VALORACIONES DE LOS FALLOS EN CONTRA -->
                      </div>
                    </p>
                  </div>
                  <!-- #Valoración de Fallos en Contra -->

                  <!-- Archivos Migrados -->
                  <div role="tabpanel" class="tab-pane fade" id="Section8">
                    <h3>Archivos Migrados</h3>
                    <p>
                      <div id="ajax-migrados">
                        <!--CARGAN LOS ARCHIVOS MIGRADOS -->
                      </div>
                    </p>
                  </div>
                  <!-- #Archivos Migrados -->
                </div>
              </div>
              <br>
              @if($responsable == 1)
                <div class="row">
                  <!-- 2 Actuaciones procesales -->
                  @if((in_array(2, $modulosActivos)))
                    <div class="col-sm-4 stats">
                      <h1>Actuaciones Procesales</h1>
                      <a class="btn btn-success" href="{{ asset('actuacionesProcesales/index/'.$idEstadoEtapa) }}"><i class="fa fa-plus-circle"></i> Ingresar</a>
                    </div>
                  @endif

                  <!-- 4 Valoración de fallos en contra -->
                  @if((in_array(4, $modulosActivos)))
                    <div class="col-sm-4 stats">
                      <h1>Valoración Probabilidad Fallos en contra</h1>
                      <a class="btn btn-danger" href="{{ asset('valoraFallo/index/'.$idEstadoEtapa) }}"><i class="fa fa-plus-circle"></i> Ingresar</a>
                    </div>
                  @endif

                  <!-- 1 Provisión y calificación -->
                  @if((in_array(1, $modulosActivos)))
                    <div class="col-sm-4 stats">
                      <h1>Provisión - Calificación del riesgo</h1>
                      <a class="btn btn-info" href="{{ asset('proviCalifica/index/'.$idEstadoEtapa) }}"><i class="fa fa-dollar"></i> Ingresar</a>
                    </div>
                  @endif

                  <!-- 5 Comité de Conciliación -->
                  @if((in_array(5, $modulosActivos)))
                    <div class="col-sm-4 stats">
                      <h1>Comité de Conciliación</h1>
                      <button class="btn btn-warning"><i class="fa fa-users"></i> Ingresar</button>
                    </div>
                  @endif
                </div>
              @endif
              <br>
            </div>
          </div>
        </div>
        <!-- END USER PROFILE -->
      </div>
    </div>
  </div>
  <!-- END MAIN CONTENT -->

  <!-- AGREGAR CARGO-->
  <div class="modal fade"  id="modalMarcarPaso"  role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg" style="width:30%;top:10%;left:-33%;">
      <div class="modal-content">
        <div class="modal-body">
          <div id="resultadoMarcarPaso">
            <!-- CONTENIDO AJAX -->
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--# AGREGAR CARGO-->

    <!-- NUEVO Accionante-->
  <div class="modal fade" id="modalAgregarAccionante" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">                
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                  <h5 class="modal-title" id="myLargeModalLabel"><i class="fa fa-money"></i> Nuevo Accionante</h5>
              </div>
              <div id="resultadoAgregarAccionante">
                <!-- CONTENIDO AJAX -->
              </div>
          </div>
      </div>
  </div>
  <!-- NUEVO Accionante-->

  <!-- EDITAR Accionante-->
  <div class="modal fade" id="modalEditarAccionante" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">                
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                  <h5 class="modal-title" id="myLargeModalLabel"><i class="fa fa-money"></i> Modificar Accionante</h5>
              </div>
              <div id="resultadoEditarAccionante">
                <!-- CONTENIDO AJAX -->
              </div>
          </div>
      </div>
  </div>
  <!-- EDITAR Accionante-->

  <!-- AGREGAR ARCHIVO-->
  <div class="modal fade" id="modalAgregarArchivo" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">                
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                  <h5 class="modal-title" id="myLargeModalLabel"><i class="fa fa-money"></i> Nuevo Archivo</h5>
              </div>
              <div id="resultadoAgregarArchivo">
                <!-- CONTENIDO AJAX -->
              </div>
          </div>
      </div>
  </div>
  <!-- AGREGAR ARCHIVO-->

  <!-- MODIFICAR DATOS GENERALES-->
  <div class="modal fade" id="modalEditarDatos" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">                
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                  <h5 class="modal-title" id="myLargeModalLabel"><i class="fa fa-money"></i> Modificar datos</h5>
              </div>
              <div id="resultadoEditarDatos">
                <!-- CONTENIDO AJAX -->
              </div>
          </div>
      </div>
  </div>
  <!--# MODIFICAR DATOS GENERALES-->
@endsection
@section('scriptsFin')
  <script src="{{asset('js/js_actuacionTutelas/actuacionTutelas.js?v=15')}}"></script>

  <script type="text/javascript">
  var idTipoProceso = $("#idTipoProceso").val();
  var vigenciaRadicado = $("#vigenciaRadicado").val();
  var idRadicado = $("#idRadicado").val();
  var mzlConsecutivo = $("#mzlConsecutivo").val();

  $(window).on('load', function() {
    pasosAbogado();
    //instanciasProceso(idTipoProceso, 0);
    demandantes();
    actuacionesProceso(vigenciaRadicado, idRadicado)
    expedienteDigital(vigenciaRadicado, idRadicado);
    expedienteDigitalMigrados(mzlConsecutivo);
    archivosIniciales();
    accionantes();
    accionadosInternos();
    accionadosExternos(9);
  });

  $(function(){
    $('.panel-heading').click(function(e) {
      $('.panel-heading').removeClass('tab-collapsed');
      var collapsCrnt = $(this).find('.collapse-controle').attr('aria-expanded');
      if (collapsCrnt != 'true') {
        $(this).addClass('tab-collapsed');
      }
    });
  })
  </script>
</script>
@stop
