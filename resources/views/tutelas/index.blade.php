@extends('layouts.master')
@section('cabecera')
<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('css/dropzoneRadicar/dropzoneRadicar.css') }}">
@endsection
@section('contenido')
<!-- RIBBON -->
<input type="hidden" value="{{$idTipoProceso}}" id="idTipoProceso">
<input type="hidden" value="" id="idRadicadoIni">
<input type="hidden" value="" id="vigenciaRadicadoIni">
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
        <li>Inicio</li><li>Demandas</li><li>Radicar Tutela</li>
    </ol>
    <!-- end breadcrumb -->
</div>
<!-- END RIBBON -->
<!-- MAIN CONTENT -->
<div id="content">              
    <!-- widget grid -->
    <section id="widget-grid" class="">
        <!-- row -->
        <div class="row">
            <!-- NEW WIDGET START -->
            <article class="col-sm-12">
                <div class="jarviswidget jarviswidget-color-blue" role="widget">
                    <header role="heading">
                        <h2><strong>Radicación</strong> <i>de tutelas</i></h2>  
                    </header>
                    <!-- widget div-->
                    <div role="content">
                        <!-- widget content -->
                        <div class="widget-body">
                           <div class="row">
                                <div id="wizard-1" novalidate="novalidate" class="smart-form">
                                    <div id="bootstrap-wizard-1" class="col-sm-12">
                                        <procesodiv class="form-bootstrapWizard">
                                            <ul class="bootstrapWizard form-wizard">
                                                <li class="active" data-target="#step1">
                                                    <a href="#tab1" data-toggle="tab"> <span class="step">1</span> <span class="title">Datos del Proceso</span> </a>
                                                </li>
                                                <li data-target="#step2">
                                                    <a href="#tab2" data-toggle="tab"> <span class="step">2</span> <span class="title">Accionantes</span> </a>
                                                </li>
                                                <li data-target="#step3">
                                                    <a href="#tab3" data-toggle="tab"> <span class="step">3</span> <span class="title">Accionado Interno</span> </a>
                                                </li>
                                                <li data-target="#step4">
                                                    <a href="#tab4" data-toggle="tab"> <span class="step">4</span> <span class="title">Accionados Externos</span> </a>
                                                </li>
                                                <li data-target="#step5">
                                                    <a href="#tab5" data-toggle="tab"> <span class="step">5</span> <span class="title">Causas y hechos</span> </a>
                                                </li>
                                            </ul>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="tab-content">
                                            <!-- Datos del Proceso -->
                                            <div class="tab-pane active" id="tab1">
                                                <hr>
                                                <div class="row">                                     
                                                    <div class="col-sm-8">
                                                        <fieldset>  
                                                            <div class="row">         
                                                                <h3 class="tit-step"><strong>Tutelas</strong> - Datos básicos del proceso</h3> 
                                                                <br>
                                                                <div class="row">
                                                                    <div class="col-sm-2">
                                                                        <label class="label pull-right">Plazo Específico:</label>
                                                                    </div>
                                                                    <div class="col-sm-2">
                                                                        <span class="onoffswitch pull-left">
                                                                            <input type="checkbox" name="start_interval" class="onoffswitch-checkbox" id="plazoPersonalizado" onchange="plazoPersonalizado()">
                                                                            <label class="onoffswitch-label" for="plazoPersonalizado">
                                                                                <span class="onoffswitch-inner" data-swchon-text="SI" data-swchoff-text="NO"></span>
                                                                                <span class="onoffswitch-switch"></span>
                                                                            </label>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <hr>
                                                                <div class="row" id="resultadoPlazoPersonalizado">
                                                                    <!--RESULTADO DEL PLAZO PERSONALIZADO-->
                                                                </div>
                                                                <hr>
                                                                <section class="col-sm-8">
                                                                    <div class="row">
                                                                        <div class="col-sm-5">  
                                                                            <label class="label">Código Único del Proceso;</label>
                                                                        </div>
                                                                        <div class="col-sm-4">
                                                                            <small class="pull-right">¿Conoce los 23 digitos?</small>
                                                                        </div>
                                                                        <div class="col-sm-1">
                                                                            <span class="onoffswitch pull-left">
                                                                                <input type="checkbox" name="start_interval" class="onoffswitch-checkbox pull-left" id="infoCodigoProceso" checked onchange="conoceCodigoProceso();">
                                                                                <label class="onoffswitch-label" for="infoCodigoProceso">
                                                                                <span class="onoffswitch-inner" data-swchon-text="SI" data-swchoff-text="NO"></span>
                                                                                <span class="onoffswitch-switch"></span>
                                                                                </label>
                                                                            </span> 
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div id="divCodigoCompleto" class="row">
                                                                        <div class="col-sm-11">
                                                                            <label class="input">
                                                                                <i class="icon-append fa fa-slack"></i>
                                                                                <input type="text" data-mask="99999-99-99-999-9999-99999-99" class="form-control" id="codigoProceso" placeholder="Código del Proceso" onkeyup="mantenerMask();" onBlur="keepMask();">
                                                                                <span class="text-muted">Ej: "11001-31-05-018-2014-00568-00"</span> 
                                                                                <input type="hidden" id="maskHidden">
                                                                            </label>
                                                                        </div>
                                                                        <div class="col-sm-1">
                                                                            <input type="hidden" id="coincidenciaJuzgado">
                                                                            <a class="btn btn-success btn-xs" onclick="cargarJuzgado(1)" href="javascript:void(0);">Cargar</a>
                                                                        </div>
                                                                    </div>

                                                                    <div style="display: none;" id="divJuzgados" class="row">
                                                                        <div class="col-sm-7">
                                                                           {{
                                                                                Form::select('selectJuzgados', $listaJuzgados, null, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectJuzgados', 'style' => 'width:100% !important'])
                                                                            }} 
                                                                        </div>
                                                                        <div class="col-sm-4">
                                                                            <label class="input">
                                                                            <i class="icon-append fa fa-slack"></i>
                                                                            <input type="text" data-mask="9999-99999-99" class="form-control" id="vigRadJuzgado" placeholder="Vigencia-Radicado">
                                                                            <span class="text-muted">Ej: "2018-00568-00"</span> 
                                                                        </label>
                                                                        </div>
                                                                        <div class="col-sm-1">
                                                                            <input type="hidden" id="coincidenciaJuzgado">
                                                                        <a class="btn btn-success btn-xs" onclick="cargarJuzgado(0)" href="javascript:void(0);">Cargar</a>
                                                                        </div>
                                                                    </div>                                                   
                                                                </section>
                                                            </div>
                                                        </fieldset>

                                                        <fieldset>
                                                            <div class="row" style="padding-left: 30px">
                                                                <section class="col-sm-4">
                                                                    <label class="label">Fecha de Notificación:</label>
                                                                    <input type="text" id="fechaNotifi" name="fechaNotifi" placeholder="Seleccione fecha de notificación" class="form-control datepicker" data-dateformat="yy-mm-dd">
                                                                </section>
                                                                <input type="hidden" id="fechaNotifi" value="{{date('Y-m-d')}}">
                                                            </div>
                                                        </fieldset>

                                                        <fieldset>
                                                            <div class="row" style="padding-left: 30px">
                                                                <section class="col-sm-12">
                                                                    <label class="label">Asunto:</label>
                                                                    <input type="text" id="asunto" placeholder="Escriba el asunto" class="form-control" style="width: 100%">
                                                                </section>
                                                            </div>
                                                        </fieldset>

                                                        <fieldset>
                                                            <div class="row" style="padding-left: 30px">
                                                                <div id="resultadoTemas">
                                                                    <!--AJAX CARGA LOS TEMAS-->
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-sm-4" style="border-left:1px dotted #ddd;">
                                                        <div id="ajax-cargarJuzgado"></div>                       
                                                    </div>                                                            
                                                </div>
                                            </div>
                                            <!-- #Datos del Proceso -->

                                            <!-- ACCIONANTES -->
                                            <div class="tab-pane" id="tab2">
                                                <hr>
                                                <div class="row"> 
                                                    <div class="col-sm-6" style="height:500px; overflow-y: scroll; border-bottom: 1px solid #ddd; border-right: 1px solid #ddd;">
                                                        <fieldset> 
                                                            <h3 class="tit-step"><strong>Accionantes</strong> - Datos de los accionantes</h3> 
                                                            <br>
                                                            <div class="row ">
                                                                <div class="col-sm-8">
                                                                  <input class="form-control search-mod" placeholder="Identificación o nombre del accionante" name="q" value="" type="searchAccionante" id="documentoAccionante" autocomplete="off">
                                                                </div> 
                                                                <div class="col-sm-3">
                                                                  <a class="btn btn-success btn-xs" id="btnNuevoAccionante" onclick="nuevoAccionante()" href="javascript:void(0);">Crear Nuevo</a>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                        <div class="row" style="border-top: 1px solid #ddd; padding:0 30px;">
                                                            <div id="searchresAccionante" class="searchresAccionante"></div>
                                                        </div>                                                    
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div id="resultadoAccionantesSeleccionados">  
                                                            <!-- CARGA AJAX -->
                                                        </div>
                                                    </div>
                                                </div>    
                                            </div>
                                            <!-- #ACCIONANTES -->

                                            <!-- Accionado interno -->
                                            <div class="tab-pane" id="tab3">
                                                <hr>
                                                <div class="row"> 
                                                    <div class="col-sm-6" style="height:500px; overflow-y: scroll; border-bottom: 1px solid #ddd; border-right: 1px solid #ddd;">
                                                        <fieldset> 
                                                            <h3 class="tit-step"><strong>Accionado Interno </strong> - Datos del Accionado Interno Involucrado</h3> 
                                                            <br>
                                                            <div class="row ">
                                                                <div class="col-sm-8">
                                                                  <input class="form-control search-mod" placeholder="Nombre del accionando interno" name="q" value="" type="searchAccionadoInt" id="nombreAccionadoInt" autocomplete="off">
                                                                </div> 
                                                            </div>
                                                        </fieldset>
                                                        <div class="row" style="border-top: 1px solid #ddd; padding:0 30px;">
                                                            <div id="searchresAccionadoInt" class="searchresAccionadoInt"></div>
                                                        </div>                                                    
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div id="resultadoAccionadosIntSeleccionados">  
                                                            <!-- CARGA AJAX -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- #Accionado interno -->

                                            <!-- Accionados Externos -->
                                            <div class="tab-pane" id="tab4">
                                                <hr>
                                                <div class="row"> 
                                                    <div class="col-sm-6" style="height:500px; overflow-y: scroll; border-bottom: 1px solid #ddd; border-right: 1px solid #ddd;">
                                                        <fieldset> 
                                                            <h3 class="tit-step"><strong>Accionado Externo</strong> - Datos de los accionados externos</h3> 
                                                            <br>
                                                            <div class="row ">
                                                                <div class="col-sm-8">
                                                                  <input class="form-control search-mod" placeholder="Identificación o nombre del accionado externo" name="q" value="" type="searchAccionadoExt" id="nombreAccionadoExt" autocomplete="off">
                                                                </div> 
                                                                <div class="col-sm-3">
                                                                  <a class="btn btn-success btn-xs" id="btnNuevoaccionadoExt" onclick="nuevoAccionadoExt()" href="javascript:void(0);">Crear Nuevo</a>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                        <div class="row" style="border-top: 1px solid #ddd; padding:0 30px;">
                                                            <div id="searchresAccionadoExt" class="searchresAccionadoExt"></div>
                                                        </div>                                                    
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div id="resultadoAccionadoExtsSeleccionados">  
                                                            <!-- CARGA AJAX -->
                                                        </div>
                                                    </div>
                                                </div>    
                                            </div>
                                            <!-- Accionados Externos -->

                                            <!-- Causas y hechos de la demanda -->
                                            <div class="tab-pane" id="tab5">
                                                <hr>
                                                <div class="row"> 
                                                    <div class="col-sm-12">
                                                        <fieldset> 
                                                            <h3 class="tit-step"><strong>Causas y hechos </strong> - Datos de los hechos</h3> 
                                                            <br>
                                                            
                                                            <div id="resultadoArchivoRadica">
                                                            
                                                            </div>

                                                            <div class="row">
                                                                <div class="form-wrap">
                                                                    <div class="form-group">
                                                                        <div class="col-sm-3">
                                                                            <label class="control-label pull-right">Descripción Hechos:</label>
                                                                        </div>
                                                                        <div class="col-sm-6">
                                                                          <textarea rows="5" class="form-control" id="descripcionHechos"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div> 

                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <a id="eventUrl" class="btn btn-primary buttonFinish pull-right" style="color:#fff; text-decoration:none;" onclick="validarGuardarRadicado();">
                                                                        <i class="fa fa-save"></i> Guardar Tutela
                                                                    </a>
                                                                </div>
                                                            </div> 
                                                        </fieldset>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- #Causas y hechos de la demanda -->

                                            <div class="form-actions">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <ul class="pager wizard no-margin">
                                                            <li class="previous disabled">
                                                                <a href="javascript:void(0);" class="btn btn-lg btn-default"> Anterior </a>
                                                            </li>
                                                            <li class="next">
                                                                <a href="javascript:void(0);" class="btn btn-lg txt-color-darken"> Siguiente </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>    
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end widget content -->
                    </div>
                    <!-- end widget div -->
                </div>
                <!-- end widget -->
            </article>
            <!-- WIDGET END -->
        </div>
        <!-- end row -->
    </section>
    <!-- end widget grid -->
</div>
<!-- END MAIN CONTENT -->

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
<!--# NUEVO Accionante-->


<!-- NUEVO ACCIONADO EXTERNO-->
<div class="modal fade"  id="modalAgregarAccionadoExt" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myLargeModalLabel"><i class="fa fa-money"></i> Nuevo Accionado Externo</h4>
            </div>
            <div class="modal-body" style="padding: 10px 30px 4px 30px;">  
                <div id="resultadoAgregarAccionadoExt">
                  <!-- CONTENIDO AJAX -->
                </div>
            </div>
        </div>
    </div>
</div>
<!--# NUEVO ACCIONADO EXTERNO-->

<!-- EDITAR Accionante-->
<div class="modal fade"  id="modalEditarAccionante" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myLargeModalLabel"><i class="fa fa-money"></i> Editar Accionante</h4>                
            </div>
            <div class="modal-body" style="padding: 10px 30px 4px 30px;">  
                <div id="resultadoEditarAccionante">
                  <!-- CONTENIDO AJAX -->
                </div>
            </div>
        </div>
    </div>
</div>
<!--# EDITAR Accionante-->

<!-- EDITAR ACCIONADO EXTERNO-->
<div class="modal fade in"  id="modalEditarAccionadoExt" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myLargeModalLabel"><i class="fa fa-money"></i> Editar Accionado Externo</h4>                
            </div>
            <div class="modal-body" style="padding: 10px 30px 4px 30px;">  
                <div id="resultadoAccionadoConvocadoExt">
                  <!-- CONTENIDO AJAX -->
                </div>
            </div>
        </div>
    </div>
</div>
<!--# EDITAR ACCIONADO EXTERNO-->

<!-- OPCIONES POST RADICADO, PDF, RADICAR NUEVAMENTE-->
<div class="modal fade"  id="modalPdfInformacion" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width:90%">
        <div class="modal-content">
            <div class="modal-header" style="padding: 5px 29px;background:#21c2f8;color:#fff">
                <div class="row">
                    <div class="col-sm-9">
                        <h4 class="modal-title pull-left" id="myLargeModalLabelCuantia"><i class="fa fa-file-pdf-o"></i> Generar PDF - Ficha Técnica del Proceso</h4>
                    </div>
                    <div class="col-sm-3">
                        <a href="#" type="button" class="close pull-right" data-dismiss="modal" aria-hidden="true" style="margin-top:3px">X</a>
                    </div>
                </div>                
            </div>
            <div class="modal-body" style="padding:0px;">  
                <iframe id="framePdfInformacion" style="width: 100%;height: 100vh;"></iframe>  
            </div>
        </div>
    </div>
</div>
<!-- OPCIONES POST RADICADO, PDF, RADICAR NUEVAMENTE-->

<!-- AGREGAR TEMA-->
<div class="modal fade"  id="modalAgregarTema"  role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">                
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title" id="myLargeModalLabel">Agregar Tema</h5>
            </div>
            <div id="resultadoAgregarTema">
              <!-- CONTENIDO AJAX -->
            </div>
        </div>
    </div>
</div>
<!--# AGREGAR TEMA-->

<!-- EDITAR TEMA-->
<div class="modal fade"  id="modalEditarTema"  role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">                
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title" id="myLargeModalLabel">Editar Tema</h5>
            </div>
            <div id="resultadoEditarTema">
              <!-- CONTENIDO AJAX -->
            </div>
        </div>
    </div>
</div>
<!--# EDITAR TEMA-->

@endsection
@section('scriptsFin')
<!-- PAGE RELATED PLUGIN(S) -->
<script src="{{asset('js/plugin/bootstrap-wizard/jquery.bootstrap.wizard.min.js')}}"></script>
<script src="{{asset('js/plugin/fuelux/wizard/wizard.min.js')}}"></script>
<script src="{{asset('js/dropzoneRadicar/dropzoneRadicar.min.js')}}"></script>
<script src="{{asset('js/dropzoneRadicar/fileinputRadicar.min.js')}}"></script>
<script src="{{asset('js/js_tutelas/tutelas.js?v='.rand(1,1000))}}"></script>
<!--
<script src=" asset('vendors/bower_components/jquery/dist/jquery.min.js')}}"></script>
<script src=" asset('vendors/bower_components/ion.rangeSlider/js/ion.rangeSlider.min.js')}}"></script>
<script src=" asset('js/rangeslider-data.js')}}"></script>
<script src=" asset('js/init.js')}}"></script>-->

<script>        
// DO NOT REMOVE : GLOBAL FUNCTIONS!
$(document).ready(function() {          
    pageSetUp();
    $('#bootstrap-wizard-1').bootstrapWizard({
        'tabClass': 'form-wizard',
        'onNext': function (tab, navigation, index) {          
            $('#bootstrap-wizard-1').find('.form-wizard').children('li').eq(index - 1).addClass(
              'complete');
            $('#bootstrap-wizard-1').find('.form-wizard').children('li').eq(index - 1).find('.step')
            .html('<i class="fa fa-check"></i>');          
        }
    });
      
    // fuelux wizard
    var wizard = $('.wizard').wizard();
      
    wizard.on('finished', function (e, data) {
        //alert("submitted!");
    });
})
</script>


<script type="text/javascript">
    $(window).on('load', function() { 
        $(".select2").select2({ width: '100%' });
        temas(0);
    });

    $( document ).ready(function() {
        iniciarDropzoneRadica();
    });
</script>
@stop