@extends('layouts.master')
@section('cabecera')
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
        <li>Inicio</li><li>Demandas</li><li>Radicar Conciliación Prejudicial</li>
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
                        <h2><strong>Radicación</strong> <i>de Conciliaciones Prejudiciales</i></h2>  
                    </header>
                    <!-- widget div-->
                    <div role="content">
                        <!-- widget content -->
                        <div class="widget-body">
                           <div class="row">
                                <div id="wizard-1" novalidate="novalidate" class="smart-form">
                                    <div id="bootstrap-wizard-1" class="col-sm-12">
                                        <div class="form-bootstrapWizard">
                                            <ul class="bootstrapWizard form-wizard">
                                                <li class="active" data-target="#step1">
                                                    <a href="#tab1" data-toggle="tab"> <span class="step">1</span> <span class="title">Datos del Proceso</span> </a>
                                                </li>
                                                <li data-target="#step2">
                                                    <a href="#tab2" data-toggle="tab"> <span class="step">2</span> <span class="title">Convocantes</span> </a>
                                                </li>
                                                <li data-target="#step3">
                                                    <a href="#tab3" data-toggle="tab"> <span class="step">3</span> <span class="title">Convocados Internos</span> </a>
                                                </li>
                                                <li data-target="#step4">
                                                    <a href="#tab4" data-toggle="tab"> <span class="step">4</span> <span class="title">Convocados Externos</span> </a>
                                                </li>
                                                <li data-target="#step5">
                                                    <a href="#tab5" data-toggle="tab"> <span class="step">5</span> <span class="title">Abogados Externos</span> </a>
                                                </li>
                                                <li data-target="#step6">
                                                    <a href="#tab6" data-toggle="tab"> <span class="step">6</span> <span class="title">Cuantías</span> </a>
                                                </li>
                                                <li data-target="#step7">
                                                    <a href="#tab7" data-toggle="tab"> <span class="step">7</span> <span class="title">Causas y hechos</span> </a>
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
                                                                <h3 class="tit-step"><strong>Conciliación Prejudicial</strong> - Datos básicos del proceso</h3> 
                                                                <br>
                                                                <div class="row" style="padding-left: 30px">
                                                                    <section class="col-sm-3">
                                                                        <label class="label">Sentido:</label> 
                                                                        @foreach($acciones as $i=>$accion)
                                                                            @php
                                                                                if($i == 0)
                                                                                {
                                                                                    $check = 'checked';
                                                                                }
                                                                                else
                                                                                {
                                                                                    $check = '';
                                                                                }
                                                                            @endphp
                                                                            <label class="radio">
                                                                                <input type="radio" name="sentidoConvocante" id="sentidoConvocante" value="{{$accion->idAccion}}" {{$check}}>
                                                                                <i></i>{{$accion->nombreAccion}}
                                                                            </label>      
                                                                        @endforeach                          
                                                                    </section>

                                                                    <section class="col-sm-4">
                                                                        <label class="label">Medio de control:</label>                   
                                                                        {{
                                                                            Form::select('selectMedioControl', $listaMediosControl, null, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectMedioControl', 'style' => 'margin-bottom:8px;width:250px !important'])
                                                                        }}
                                                                    </section>

                                                                    <section class="col-sm-4">
                                                                        <label class="label">Fecha de Notificación:</label>
                                                                        <input type="text" id="fechaNotifi" name="fechaNotifi" placeholder="Seleccione fecha de notificación" class="form-control datepicker" data-dateformat="yy-mm-dd">
                                                                    </section>
                                                                    <input type="hidden" id="fechaNotifi" value="{{date('Y-m-d')}}">
                                                                </div>
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

                                            <!-- Convocantes -->
                                            <div class="tab-pane" id="tab2">
                                                <hr>
                                                <div class="row"> 
                                                    <div class="col-sm-6" style="height:500px; overflow-y: scroll; border-bottom: 1px solid #ddd; border-right: 1px solid #ddd;">
                                                        <fieldset> 
                                                            <h3 class="tit-step"><strong>Convocantes</strong> - Datos de los convocantes</h3> 
                                                            <br>
                                                            <div class="row ">
                                                                <div class="col-sm-8">
                                                                  <input class="form-control search-mod" placeholder="Identificación o nombre del convocante" name="q" value="" type="searchConvocante" id="documentoConvocante" autocomplete="off">
                                                                </div> 
                                                                <div class="col-sm-3">
                                                                  <a class="btn btn-success btn-xs" id="btnNuevoConvocante" onclick="nuevoConvocante()" href="javascript:void(0);">Crear Nuevo</a>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                        <div class="row" style="border-top: 1px solid #ddd; padding:0 30px;">
                                                            <div id="searchresConvocante" class="searchresConvocante"></div>
                                                        </div>                                                    
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div id="resultadoConvocantesSeleccionados">  
                                                            <!-- CARGA AJAX -->
                                                        </div>
                                                    </div>
                                                </div>    
                                            </div>
                                            <!-- #Convocantes -->

                                            <!-- Convocados Internos-->
                                            <div class="tab-pane" id="tab3">
                                                <hr>
                                                <div class="row"> 
                                                    <div class="col-sm-6" style="height:500px; overflow-y: scroll; border-bottom: 1px solid #ddd; border-right: 1px solid #ddd;">
                                                        <fieldset> 
                                                            <h3 class="tit-step"><strong>Convocados Internos </strong> - Datos de los convocados internos</h3> 
                                                            <br>
                                                            <div class="row ">
                                                                <div class="col-sm-8">
                                                                  <input class="form-control search-mod" placeholder="Nombre del convocado interno" name="q" value="" type="searchConvocadoInt" id="nombreConvocadoInt" autocomplete="off">
                                                                </div> 
                                                            </div>
                                                        </fieldset>
                                                        <div class="row" style="border-top: 1px solid #ddd; padding:0 30px;">
                                                            <div id="searchresConvocadoInt" class="searchresConvocadoInt"></div>
                                                        </div>                                                    
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div id="resultadoConvocadoIntSeleccionados">  
                                                            <!-- CARGA AJAX -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- #Convocados Internos -->

                                            <!-- Convocados Externos -->
                                            <div class="tab-pane" id="tab4">
                                                <hr>
                                                <div class="row"> 
                                                    <div class="col-sm-6" style="height:500px; overflow-y: scroll; border-bottom: 1px solid #ddd; border-right: 1px solid #ddd;">
                                                        <fieldset> 
                                                            <h3 class="tit-step"><strong>Convocados Externos</strong> - Datos de los convocados externos</h3> 
                                                            <br>
                                                            <div class="row ">
                                                                <div class="col-sm-8">
                                                                  <input class="form-control search-mod" placeholder="Nombre del convocado externo" name="q" value="" type="searchConvocadoExt" id="nombreConvocadoExt" autocomplete="off">
                                                                </div> 
                                                                <div class="col-sm-3">
                                                                  <a class="btn btn-success btn-xs" id="btnNuevoConvocadoExt" onclick="nuevoConvocadoExt()" href="javascript:void(0);">Crear Nuevo</a>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                        <div class="row" style="border-top: 1px solid #ddd; padding:0 30px;">
                                                            <div id="searchresConvocadoExt" class="searchresConvocadoExt"></div>
                                                        </div>                                                    
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div id="resultadoConvocadoExtsSeleccionados">  
                                                            <!-- CARGA AJAX -->
                                                        </div>
                                                    </div>
                                                </div>    
                                            </div>
                                            <!-- Convocados Externos -->

                                            <!-- Abogados Externos -->
                                            <div class="tab-pane" id="tab5">
                                                <hr>
                                                <div class="row">
                                                    <div class="col-sm-6" style="height:500px; overflow-y: scroll; border-bottom: 1px solid #ddd; border-right: 1px solid #ddd;">
                                                        <fieldset>
                                                            <h3 class="tit-step"><strong>Abogados</strong> - Datos de los apoderados</h3>
                                                            <br>
                                                            <div class="row ">
                                                                <div class="col-sm-8">
                                                                  <input class="form-control search-mod" placeholder="Identificación o nombre del abogado" name="q" value="" type="searchAbogado" id="documentoAbogado" autocomplete="off">
                                                                </div>
                                                                <div class="col-sm-3">
                                                                  <a class="btn btn-success btn-xs" id="btnNuevoAbogado" onclick="nuevoAbogado()" href="javascript:void(0);">Crear Nuevo</a>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                        <div class="row" style="border-top: 1px solid #ddd; padding:0 30px;">
                                                            <div id="searchresAbogado" class="searchresAbogado"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div id="resultadoAbogadosSeleccionados">
                                                            <!-- CARGA AJAX -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Abogados Externos -->

                                            <!-- Cuantías de radicado -->
                                            <div class="tab-pane" id="tab6">
                                                <hr>
                                                <div class="row"> 
                                                    <div class="col-sm-12">
                                                        <fieldset> 
                                                            <h3 class="tit-step"><strong>Cuantías </strong> - Cuantías del radicado</h3> 
                                                            <br>

                                                            <div class="row">         
                                                                <section class="col-sm-3">
                                                                    <label class="label">Unidad Monetaria:</label>
                                                                        <select class="form-control select2" id="selectUnidadMonetaria" name="selectUnidadMonetaria" onchange="seleccionUnidadMonetaria(this.value);" style="width:250px">
                                                                        <option value="0">Seleccione Unidad Monetaria</option>
                                                                        <option value="1">Salarios mínimos</option>
                                                                        <option value="2">Pesos</option>
                                                                    </select>
                                                                </section>

                                                                <section class="col-sm-3">
                                                                    <div id="divPesos" style="display: none;">
                                                                        <label class="label">Valor:</label> 
                                                                        <input type="text" id="valor" name="valor" class="form-control" placeholder="Valor" onkeyup="format(this)" onchange="format(this)" onkeypress="return justNumbers(event);" onBlur="copiar();">
                                                                    </div>

                                                                    <div id="divSalariosMinimos" style="display: none;">
                                                                        <label class="label">Salarios Mínimos</label>
                                                                        <input type="hidden" name="slv" id="slv" value="{{$slv}}">
                                                                        <input type="text" id="valorSalarios" name="valorSalarios" class="form-control" placeholder="Salarios Mínimos" onkeyup="format(this)" onchange="format(this)" oninput="salarioAPesos(this);">
                                                                    </div>
                                                                </section>

                                                                <div id="divValores" style="display: none;">
                                                                    <section class="col-sm-3">    
                                                                        <label class="label">Valor en pesos</label>
                                                                        <input type="text" id="valorPesos" name="valorPesos" class="form-control" placeholder="Valor en pesos" readonly> 
                                                                    </section>
                                                                    <section class="col-sm-1">
                                                                        <label class="label">&nbsp;</label>
                                                                        <a id="eventUrl" class="btn btn-success btn-xs btn-guardar-cuantia" style="color:#fff; text-decoration:none;" onclick="validarAgregarCuantia();">
                                                                            <i class="fa fa-dollar"></i> Agregar Cuantía
                                                                        </a>
                                                                    </section>
                                                                </div>

                                                                <div class="fresh-table full-screen-table toolbar-color-blue" style="margin-top: 110px;">
                                                                    <table id="tablaCuantias" class="table tabla-fresh">
                                                                        <thead>
                                                                            <tr>
                                                                                <th data-sortable="true">Unidad Monetaria</th>
                                                                                <th data-visible="false">select unidad monetaria</th>
                                                                                <th data-sortable="true">Valor</th>
                                                                                <th data-sortable="true">Valor en pesos</th>
                                                                                <th data-sortable="true">Eliminar</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <!-- CONTENIDO -->              
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- # Cuantías de radicado -->

                                            <!-- Causas y hechos de la demanda -->
                                            <div class="tab-pane" id="tab7">
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
                                                        </fieldset>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <a id="eventUrl" class="btn btn-primary buttonFinish pull-right" style="color:#fff; text-decoration:none;" onclick="validarGuardarRadicado();">
                                                            <i class="fa fa-save"></i> Guardar Conciliación Prejudicial
                                                        </a>
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

<!-- NUEVO Convocante-->
<div class="modal fade" id="modalAgregarConvocante" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">                
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title" id="myLargeModalLabel"><i class="fa fa-money"></i> Nuevo Convocante</h5>
            </div>
            <div id="resultadoAgregarConvocante">
              <!-- CONTENIDO AJAX -->
            </div>
        </div>
    </div>
</div>
<!--# NUEVO Convocante-->


<!-- EDITAR Convocante-->
<div class="modal fade"  id="modalEditarConvocante" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myLargeModalLabel"><i class="fa fa-money"></i> Editar Convocante</h4>
            </div>
            <div class="modal-body" style="padding: 10px 30px 4px 30px;">  
                <div id="resultadoEditarConvocante">
                  <!-- CONTENIDO AJAX -->
                </div>
            </div>
        </div>
    </div>
</div>
<!--# EDITAR Convocante-->

<!-- NUEVO CONVOCADO EXTERNO-->
<div class="modal fade" id="modalAgregarConvocadoExt" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">                
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title" id="myLargeModalLabel"><i class="fa fa-money"></i> Nuevo Convocado Externo</h5>
            </div>
            <div id="resultadoAgregarConvocadoExt">
              <!-- CONTENIDO AJAX -->
            </div>
        </div>
    </div>
</div>
<!--# NUEVO CONVOCADO EXTERNO-->


<!-- EDITAR CONVOCADO EXTERNO-->
<div class="modal fade"  id="modalEditarConvocadoExt" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myLargeModalLabel"><i class="fa fa-money"></i> Editar Convocado Externo</h4>
            </div>
            <div class="modal-body" style="padding: 10px 30px 4px 30px;">  
                <div id="resultadoEditarConvocadoExt">
                  <!-- CONTENIDO AJAX -->
                </div>
            </div>
        </div>
    </div>
</div>
<!--# EDITAR CONVOCADO EXTERNO-->

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

<!-- NUEVO ABOGADO DEMANDANTE-->
<div class="modal fade"  id="modalAgregarAbogadoDemandante" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myLargeModalLabel"><i class="fa fa-money"></i> Nuevo Abogado Demandante</h4>
            </div>
            <div class="modal-body" style="padding: 10px 30px 4px 30px;">
                <div id="resultadoAgregarAbogadoDemandante">
                  <!-- CONTENIDO AJAX -->
                </div>
            </div>
        </div>
    </div>
</div>
<!--# NUEVO ABOGADO DEMANDANTE-->

<!-- EDITAR ABOGADO DEMANDANTE-->
<div class="modal fade"  id="modalEditarAbogadoDemandante" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myLargeModalLabel"><i class="fa fa-money"></i> Editar Abogado Demandante</h4>
            </div>
            <div class="modal-body" style="padding: 10px 30px 4px 30px;">
                <div id="resultadoEditarAbogadoDemandandante">
                  <!-- CONTENIDO AJAX -->
                </div>
            </div>
        </div>
    </div>
</div>
<!--# EDITAR ABOGADO DEMANDANTE-->

<button onclick="abrirVentana()">Abrir ventana</button>

@endsection
@section('scriptsFin')
<!-- PAGE RELATED PLUGIN(S) -->
<script src="{{asset('js/plugin/bootstrap-wizard/jquery.bootstrap.wizard.min.js')}}"></script>
<script src="{{asset('js/plugin/fuelux/wizard/wizard.min.js')}}"></script>
<script src="{{asset('js/js_conciliPrejuci/conciliPrejudici.js?v='.rand(1,1000))}}"></script>
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
    $('#tablaCuantias').bootstrapTable();
    temas(0);
});

$( document ).ready(function() {
    iniciarDropzoneRadica();
});
</script>
@stop