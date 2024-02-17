@extends('layouts.master')
@section('cabecera')
<link href="{{ asset('css/linea-tiempo.css?v=2')}}" rel="stylesheet" type="text/css">
@endsection
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
        <li>Inicio</li><li>Buscar Procesos</li>
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
                        <h2>Buscar <strong><i>Procesos</i></strong></h2>  
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
                                        <select id="selectMetodoBusqueda" class="form-control" onchange="filtrarMetodoBuscar(this.value);" autofocus>
                                            <option value="0">Buscar por..</option>
                                            <option value="1">Radicado litíGo</option>
                                            <option value="5">Radicado Juzgado</option>
                                            <option value="2">Documento demandante</option>
                                            <option value="3">Nombre Demandante</option>
                                            <option value="4">Tema</option>                        
                                            <option value="7">Asunto</option>                        
                                            <option value="6">Radicados Anteriores</option>
                                        </select>
                                    </div>
                                    <!-- # Métodos de búsqueda --> 
                                </div>
                                
                                <!-- Vigencia radicados -->
                                <div id="divVigenciaBuscar" style="display: none;">
                                    <div class="col-sm-1">
                                        <select id="vigenciaProcesoBuscar" class="form-control">
                                            <option value='{{ $vigenciaActual }}'>{{ $vigenciaActual }}</option>
                                                <?php 
                                                for ($i=2003; $i<=$vigenciaActual; $i++) 
                                                {
                                                    echo "<option value='$i'>$i</option>";
                                                }  
                                                ?>
                                        </select>
                                    </div>
                                </div>
                                <!-- # Vigencia radicados -->

                                <div id="divRadicadoSyqual">    
                                    <div class="col-sm-2">                                    
                                        <input id="criterioBusqueda" class="form-control pull-right" type="text" name="param" placeholder="Encuentre un proceso..">                                                                                
                                    </div>
                                    <div class="col-sm-2">
                                        <button onclick="buscadorProcesos();" class="btn btn-success pull-left btn-block">
                                            <i class="fa fa-search"></i> Buscar
                                        </button>
                                    </div>
                                </div>

                                <div id="divRadicadoJuzgado" style="display: none;">
                                    <div class="col-sm-2">                         
                                        <input type="text" class="form-control pull-right"  id="criterioBusquedaJuz" data-mask="9999-99999"  name="param" placeholder="Encuentre un proceso.." class="form-control">
                                    </div>        
                                    <div class="col-sm-2">
                                        <button onclick="buscadorProcesos();" class="btn btn-success pull-left btn-block">
                                            <i class="fa fa-search"></i> Buscar
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div id="ajax-buscarProceso" class="cont-ajax">
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
@endsection
@section('scriptsFin')
    <script src="{{asset('js/js_buscar/buscar.js?v='.rand(1, 1000))}}"></script>
@stop