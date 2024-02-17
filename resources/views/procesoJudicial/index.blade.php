@extends('layouts.master')
@section('cabecera')
<link rel="stylesheet" type="text/css" media="screen" href="{{ asset('css/dropzoneRadicar/dropzoneRadicar.css') }}">
@endsection
@section('contenido')
<style>
    #vigRadJuzgado::placeholder {
        color: black;
        font-weight: bold;
    }
</style>
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
        <li>Inicio</li><li>Demandas</li><li>Radicar Proceso Judicial</li>
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
                        <h2><strong>Radicación</strong> <i>de Procesos Judiciales</i></h2>
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
                                                    <a href="#tab2" data-toggle="tab"> <span class="step">2</span> <span class="title">Demandantes</span> </a>
                                                </li>
                                                <li data-target="#step3">
                                                    <a href="#tab3" data-toggle="tab"> <span class="step">3</span> <span class="title">Dependencia involucrada</span> </a>
                                                </li>
                                                <li data-target="#step4">
                                                    <a href="#tab4" data-toggle="tab"> <span class="step">4</span> <span class="title">Abogados Externos</span> </a>
                                                </li>
                                                <li data-target="#step5">
                                                    <a href="#tab5" data-toggle="tab"> <span class="step">5</span> <span class="title">Entidades Externas</span> </a>
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
                                                                <h3 class="tit-step"><strong>Proceso Judicial</strong> - Datos básicos del proceso</h3>
                                                                <br>
                                                                <hr>
                                                                <section class="col-sm-3">
                                                                    <label class="label" style="font-size: 16px;">Sentido:</label>
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
                                                                            <input type="radio" name="sentidoEntidad" id="contraEntidad" value="{{$accion->idAccion}}" {{$check}}>
                                                                            <i></i>{{$accion->nombreAccion}}
                                                                        </label>
                                                                    @endforeach
                                                                </section>

                                                                <section class="col-sm-8">
                                                                    <div class="row">
                                                                        <div class="col-sm-5">
                                                                            <label class="label" style="font-size: 16px;">Código Único del Proceso;</label>
                                                                        </div>
                                                                        <div class="col-sm-4">
                                                                            <small class="pull-right" style="font-size: 16px;">¿Conoce los 23 digitos?</small>
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

                                                                    <div style="display: none;" id="divJuzgados">
                                                                        <div class="row">
                                                                            <div class="col-sm-12">
                                                                               {{
                                                                                    Form::select('selectJuzgados', $listaJuzgados, null, ['placeholder' => 'Seleccione el juzgado o cualquier otra entidad', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectJuzgados', 'style' => 'width:100% !important'])
                                                                                }}
                                                                            </div>
                                                                        </div>

                                                                        <div class="row" style="padding-top: 8px">
                                                                            <div class="col-sm-10">
                                                                                <label class="input">
                                                                                <i class="icon-append fa fa-slack"></i>
                                                                                <input type="text" data-mask="9999-99999-99" class="form-control" id="vigRadJuzgado" placeholder="Número de radicado del juzgado o de la otra entidad">
                                                                                <span class="text-muted">Ej: "2018-00568-00"</span>
                                                                              </label>
                                                                            </div>
                                                                            <div class="col-sm-2">
                                                                                <input type="hidden" id="coincidenciaJuzgado">
                                                                            <a class="btn btn-success btn-xs" onclick="cargarJuzgado(0)" href="javascript:void(0);">Cargar</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </section>
                                                            </div>
                                                        </fieldset>

                                                        <fieldset>
                                                            <div class="row" style="padding-left: 30px">
                                                                <section class="col-sm-3">
                                                                  <label class="label">Fecha de Notificación:</label>
                                                                  <input type="text" id="fechaNotifi" name="fechaNotifi" placeholder="Seleccione fecha de notificación" class="form-control datepicker" data-dateformat="yy-mm-dd">
                                                                </section>

                                                                <section class="col-sm-9">
                                                                    <div id="resultadoMedioControl">
                                                                        <!--AJAX CARGA LOS MEDIOS DE CONTROL-->
                                                                    </div>
                                                                </section>
                                                            </div>
                                                        </fieldset>

                                                        <fieldset>
                                                            <div class="row" style="padding-left: 30px">
                                                                <section class="col-sm-12">
                                                                    <label class="label">Asunto: Breve descripción o título que señala el tema principal del contenido</label>
                                                                    <input type="text" id="asunto" placeholder="Escriba el asunto" class="form-control" style="width: 100%">
                                                                </section>
                                                            </div>
                                                        </fieldset>

                                                        <fieldset>
                                                            <div class="row" style="padding-left: 30px" id="resultadoTemas">
                                                                <!--AJAX CARGA LOS TEMAS-->
                                                            </div>
                                                        </fieldset>

                                                        <fieldset>
                                                            <div class="row" style="padding-left: 30px">
                                                                <input type="hidden" id="fechaNotifi" value="{{date('Y-m-d')}}">
                                                                <section class="col-sm-4">
                                                                    <label class="label">Vigencia:</label>
                                                                    <select class="form-control pull-left" id="vigenciaProceso" onchange="cambiarVigenciaProceso(this.value);">
                                                                    <option value=''>Seleccione</option>
                                                                        <?php
                                                                            for ($i=2016; $i<=$vigenciaActual; $i++)
                                                                            {
                                                                                echo "<option value='$i'>$i</option>";
                                                                            }
                                                                            ?>
                                                                    </select>
                                                                </section>

                                                                <section class="col-sm-4">
                                                                    <div id="resultadoProcesos">
                                                                        <!--AJAX CON RADICADOS DE LOS PROCESOS DE CONCILIACIONES-->
                                                                    </div>
                                                                </section>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-sm-4" style="border-left:1px dotted #ddd;">
                                                        <div id="ajax-cargarJuzgado"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- #Datos del Proceso -->

                                            <!-- Demandantes -->
                                            <div class="tab-pane" id="tab2">
                                                <hr>
                                                <div class="row">
                                                    <div class="col-sm-6" style="height:500px; overflow-y: scroll; border-bottom: 1px solid #ddd; border-right: 1px solid #ddd;">
                                                        <fieldset>
                                                            <h3 class="tit-step"><strong>Demandantes</strong> - Datos de los demandantes</h3>
                                                            <br>
                                                            <div class="row ">
                                                                <div class="col-sm-8">
                                                                  <input class="form-control search-mod" placeholder="Identificación o nombre del demandante" name="q" value="" type="searchDemandante" id="documentoDemandante" autocomplete="off">
                                                                </div>
                                                                <div class="col-sm-3">
                                                                  <a class="btn btn-success btn-xs" id="btnNuevoDemandante" onclick="nuevoDemandante()" href="javascript:void(0);">Crear Nuevo</a>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                        <div class="row" style="border-top: 1px solid #ddd; padding:0 30px;">
                                                            <div id="searchresDemandante" class="searchresDemandante"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div id="resultadoDemandantesSeleccionados">
                                                            <!-- CARGA AJAX -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- #Demandantes -->

                                            <!-- Dependencia Afectada -->
                                            <div class="tab-pane" id="tab3">
                                                <hr>
                                                <div class="row">
                                                    <div class="col-sm-6" style="height:500px; overflow-y: scroll; border-bottom: 1px solid #ddd; border-right: 1px solid #ddd;">
                                                        <fieldset>
                                                            <h3 class="tit-step"><strong>Dependencia Afectada </strong> - Datos de la Dependencia Involucrada</h3>
                                                            <br>
                                                            <div class="row ">
                                                                <div class="col-sm-8">
                                                                  <input class="form-control search-mod" placeholder="Nombre de la dependencia" name="q" value="" type="searchDependencia" id="nombreDependencia" autocomplete="off">
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                        <div class="row" style="border-top: 1px solid #ddd; padding:0 30px;">
                                                            <div id="searchresDependencia" class="searchresDependencia"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div id="resultadoDemandandosSeleccionados">
                                                            <!-- CARGA AJAX -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- #Dependencia Afectada -->

                                            <!-- Abogados apoderados -->
                                            <div class="tab-pane" id="tab4">
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
                                            <!-- Abpgados apoderados -->


                                            <!-- ENTIDADES EXTERNAS -->
                                            <div class="tab-pane" id="tab5">
                                                <hr>
                                                <div class="row">
                                                    <div class="col-sm-6" style="height:500px; overflow-y: scroll; border-bottom: 1px solid #ddd; border-right: 1px solid #ddd;">
                                                        <fieldset>
                                                            <h3 class="tit-step"><strong>Entidades Externas</strong> - Datos las entidades externas</h3>
                                                            <br>
                                                            <div class="row ">
                                                                <div class="col-sm-8">
                                                                  <input class="form-control search-mod" placeholder="Identificación o nombre de la entidad externa" name="q" value="" type="searchEntidadExt" id="nombreEntidadExt" autocomplete="off">
                                                                </div>
                                                                <div class="col-sm-3">
                                                                  <a class="btn btn-success btn-xs" id="btnNuevaEntidadExt" onclick="nuevaEntidadExt()" href="javascript:void(0);">Crear Nuevo</a>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                        <div class="row" style="border-top: 1px solid #ddd; padding:0 30px;">
                                                            <div id="searchresEntidadesExt" class="searchresEntidadesExt"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div id="resultadoEntidadesExtSeleccionados">
                                                            <!-- CARGA AJAX -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- ENTIDADES EXTERNAS -->

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
                                                            <i class="fa fa-save"></i> Guardar Proceso Judicial
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
<!--# NUEVO DEMANDANTE-->

<!-- NUEVO ENTIDAD EXTERNO-->
<div class="modal fade" id="modalAgregarEntidadExt" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">                
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title" id="myLargeModalLabel"><i class="fa fa-money"></i> Nueva Entidad Externa</h5>
            </div>
            <div id="resultadoAgregarEntidadExt">
              <!-- CONTENIDO AJAX -->
            </div>
        </div>
    </div>
</div>
<!--# NUEVO ENTIDAD EXTERNO-->

<!-- EDITAR ENTIDAD EXTERNO-->
<div class="modal fade" id="modalEditarEntidadExt" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">                
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title" id="myLargeModalLabel"><i class="fa fa-money"></i> Modificar Entidad Externa</h5>
            </div>
            <div id="resultadoEditarEntidadExt">
              <!-- CONTENIDO AJAX -->
            </div>
        </div>
    </div>
</div>
<!--# EDITAR ENTIDAD EXTERNO-->

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

<!-- NUEVO DEMANDADO-->
<div class="modal fade"  id="modalAgregarDemandado" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myLargeModalLabel"><i class="fa fa-money"></i> Nuevo Demandado</h4>
            </div>
            <div class="modal-body" style="padding: 10px 30px 4px 30px;">
                <div id="resultadoAgregarDemandado">
                  <!-- CONTENIDO AJAX -->
                </div>
            </div>
        </div>
    </div>
</div>
<!--# NUEVO DEMANDADO-->

<!-- EDITAR DEMANDANTE-->
<div class="modal fade"  id="modalEditarDemandante" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myLargeModalLabel"><i class="fa fa-money"></i> Editar Demandante</h4>
            </div>
            <div class="modal-body" style="padding: 10px 30px 4px 30px;">
                <div id="resultadoEditarDemandante">
                  <!-- CONTENIDO AJAX -->
                </div>
            </div>
        </div>
    </div>
</div>
<!--# EDITAR DEMANDANTE-->

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

<!-- EDITAR DEMANDADO-->
<div class="modal fade"  id="modalEditarDemandado" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myLargeModalLabel"><i class="fa fa-money"></i> Editar Demandado</h4>
            </div>
            <div class="modal-body" style="padding: 10px 30px 4px 30px;">
                <div id="resultadoEditarDemandado">
                  <!-- CONTENIDO AJAX -->
                </div>
            </div>
        </div>
    </div>
</div>
<!--# EDITAR DEMANDADO-->

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
<script src="{{asset('js/js_procesoJudicial/procesoJudicial.js')}}"></script>
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
        mediosControl(0);
        var vigenciaProceso = $("#vigenciaProceso").val()
        cambiarVigenciaProceso(vigenciaProceso);
        $('#tablaCuantias').bootstrapTable();
    });

    $( document ).ready(function() {
        iniciarDropzoneRadica();
    });
</script>
@stop
