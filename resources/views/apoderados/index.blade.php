@extends('layouts.master')
@section('contenido')
@php
    $vigenciaActual = date('Y');
@endphp
<!-- RIBBON -->
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
        <li>Inicio</li><li>Apoderados</li>
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
                        <h2>Apoderados <strong><i>Cambiar - Agregar</i></strong></h2>  
                    </header>
                    <!-- widget div-->
                    <div role="content">
                        <!-- widget content -->
                        <div class="widget-body">    
                            <!-- #SEARCH -->
                            <div class="row">
                                <div class="col-sm-2">
                                    <!-- Métodos de búsqueda -->
                                    <div>
                                        <select id="selectMetodoBusquedaApoderado" class="form-control" onchange="vigenciaRadicadoApoderado(this.value);">
                                            <option value="0">Buscar por..</option>
                                            <option value="1">Radicado litíGo</option>
                                            <option value="2">Radicado Juzgado</option>
                                        </select>
                                    </div>
                                    <!-- # Métodos de búsqueda --> 
                                </div>

                                <div id="divRadicadoJuzgado" style="display: none;">
                                    <div class="col-sm-2">                         
                                        <input type="text" class="form-control pull-right"  id="criterioBusquedaJuz" data-mask="9999-99999"  name="param" placeholder="Encuentre un proceso.." class="form-control">
                                    </div>        
                                    <div class="col-sm-2">
                                        <button onclick="buscarProcesoApoderado();" class="btn btn-success pull-left btn-block">
                                            <i class="fa fa-search"></i> Buscar
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- Vigencia radicados -->
                                <div id="divRadicadoSyqualApoderado" style="display: none;">    
                                    <div class="col-sm-1">
                                        <select id="vigenciaProcesoBuscarApoderado" class="form-control">
                                            <option value='{{ $vigenciaActual }}'>{{ $vigenciaActual }}</option>
                                                <?php 
                                                for ($i=2003; $i<=$vigenciaActual; $i++) 
                                                {
                                                    echo "<option value='$i'>$i</option>";
                                                }  
                                                ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-2">                                    
                                        <input id="criterioBusquedaApoderado" class="form-control pull-right" type="text" name="param" placeholder="Encuentre un proceso..">                    
                                    </div>
    
                                    <div class="col-sm-2">
                                        <button onclick="buscarProcesoApoderado();" class="btn btn-success pull-left btn-block">
                                            <i class="fa fa-search"></i> Buscar
                                        </button>
                                    </div>
                                </div>
                                <!-- # Vigencia radicados -->

                               
                            </div>
                            <hr>
                            <div id="ajax-procesos-encontrados" class="cont-ajax">
                                <!-- ajax -->
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


<!-- APODERADOS-->
<div class="modal fade"  id="modalApoderados"  role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title" id="myLargeModalLabel">Apoderados</h5>
            </div>
            <div id="ajax-apoderados">
              <!-- CONTENIDO AJAX -->
            </div>
        </div>
    </div>
</div>
<!--# APODERADOS-->

@endsection
@section('scriptsFin')
    <script src="{{asset('js/js_apoderados/apoderados.js?v=7')}}"></script>
@stop
