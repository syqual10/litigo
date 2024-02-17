@extends('layouts.master')
@section('cabecera')
<link href="{{ asset('css/style.css')}}" rel="stylesheet" type="text/css">
<link href="{{ asset('css/wizard.css')}}" rel="stylesheet" type="text/css">
<link href="{{ asset('css/jquery-sortable-lists.css')}}" rel="stylesheet" type="text/css">
@section('contenido')
<input type="hidden" id="idTipoProceso" value="{{$datosTipoProceso->idTipoProcesos}}">
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
        <li>Inicio</li><li>Configuración</li><li>Configurar proceso <b>{{$datosTipoProceso->nombreTipoProceso}}</b></li>
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
                        <h2>Administración <strong><i>de tipos de procesos</i></strong></h2>  
                    </header>
                    <!-- widget div-->
                    <div role="content">
                        <!-- widget content -->
                        <div class="widget-body">
                            <div class="jarviswidget" role="widget">
                                <header role="heading">
                                    <h2>Opciones de configuración</h2>
                                    <ul class="nav nav-tabs pull-right in">                
                                        <li class="active">                
                                            <a data-toggle="tab" href="#hb1" aria-expanded="true"> <i class="fa fa-lg fa-sitemap"></i> <span class="hidden-mobile hidden-tablet"> Instancias </span> </a>                
                                        </li>
                
                                        <li class="">
                                            <a data-toggle="tab" href="#hb2" aria-expanded="false"> <i class="fa fa-lg fa-sort-amount-desc"></i> <span class="hidden-mobile hidden-tablet"> Procedimiento <span class="label bg-color-green txt-color-white"> (Paso a paso) <i class="fa fa-check-square-o"></i> </span> </span> </a>
                                        </li>
                                        
                                        <li class="">
                                            <a data-toggle="tab" href="#hb3" aria-expanded="false"> <i class="fa fa-lg fa-sort-amount-desc"></i> <span class="hidden-mobile hidden-tablet"> Tipos de actuaciones </span> </a>
                                        </li>

                                        <li class="">
                                            <a data-toggle="tab" href="#hb4" aria-expanded="false"> <i class="fa fa-lg fa-sort-amount-desc"></i> <span class="hidden-mobile hidden-tablet"> Módulos </span> </a>
                                        </li>
                                    </ul>
                                    <span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span>
                                </header>
                
                                <!-- widget div-->
                                <div role="content">                
                                    <!-- widget content -->
                                    <div class="widget-body">
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="hb1">
                                                <p>
                                                    <a href="javascript:void(0);" class="btn btn-default btn-sm" onclick="agregarInstancia();">
                                                    <i class="fa fa-sitemap"></i> Agregar una instacia
                                                    </a>
                                                    <div id="resultadoInstanciasTipoProceso" class="cont-ajax">
                                                        <!-- ajax -->
                                                    </div>
                                                </p>
                                            </div>
                                            <div class="tab-pane" id="hb2">
                                                <ul id="internal-tab-1" class="nav nav-tabs tabs-pull-left">
                                                    <li class="active">
                                                        <a href="#is2" data-toggle="tab" aria-expanded="false">¿Qué se hace?</a>
                                                    </li>
                                                    <li>
                                                        <a href="#is1" data-toggle="tab" aria-expanded="false">¿Cómo se hace?</a>
                                                    </li>                                                    
                                                </ul>
                                                <div class="tab-content padding-10">
                                                    <div class="tab-pane fade" id="is1">
                                                        <p>
                                                           <hr>
                                                           <a href="javascript:void(0);" class="btn btn-default btn-sm" onclick="agregarPasoHijo();">
                                                            <i class="fa fa-sitemap"></i> Agregar como se hace
                                                            </a>
                                                            <div id="resultadoComoHace">
                                                            
                                                            </div>
                                                        </p>
                                                    </div>
                                                    <div class="tab-pane fade in active" id="is2">
                                                        <p>
                                                            <hr>
                                                            <a href="javascript:void(0);" class="btn btn-default btn-sm" onclick="agregarPasoPadre();">
                                                            <i class="fa fa-sitemap"></i> Agregar que se hace
                                                            </a>
                                                            <div id="resultadoQueHace">
                                                            
                                                            </div>
                                                        </p>
                                                    </div>
                                                </div>                
                                            </div>
                                            <div class="tab-pane" id="hb3">
                                                <p>
                                                    <div id="resultadoTiposActuaciones" class="cont-ajax">
                                                        <!-- ajax -->
                                                    </div>
                                                </p>
                                            </div>
                                            <div class="tab-pane" id="hb4">
                                                <p>
                                                    <div id="resultadoModulos" class="cont-ajax">
                                                        
                                                    </div>
                                                </p>
                                            </div>
                                        </div>                
                                    </div>
                                    <!-- end widget content -->                
                                </div>
                                <!-- end widget div -->                
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

<!-- AGREGAR DEPENDENCIA-->
<div class="modal fade"  id="modalAgregarInstancia"  role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title" id="myModalLabel">Agregar Instancia</h5>
            </div>
            <div id="resultadoAgregarInstancia">
              <!-- CONTENIDO AJAX -->
            </div>
        </div>
    </div>
</div>
<!--# AGREGAR DEPENDENCIA-->

<!-- EDITAR DEPENDENCIA-->
<div class="modal fade"  id="modalEditarInstancia"  role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">                
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title" id="myLargeModalLabel">Editar Instancia</h5>
            </div>
            <div id="resultadoEditarInstancia">
                <!-- CONTENIDO AJAX -->
            </div>
        </div>
    </div>
</div>
<!--# EDITAR DEPENDENCIA-->

<!-- QUE SE HACEN-->
<div class="modal fade"  id="modalAgregarQueHacen"  role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">                
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title" id="myLargeModalLabel">Agregar que se hace</h5>
            </div>
            <div id="resultadoAgregarQueHacen">
                <!-- CONTENIDO AJAX -->
            </div>
        </div>
    </div>
</div>
<!--# QUE SE HACEN-->

<!-- QUE SE HACEN EDITAR-->
<div class="modal fade"  id="modalEditarQueHacen"  role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">                
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title" id="myLargeModalLabel">Editar que se hace</h5>
            </div>
            <div id="resultadoEditarQueHacen">
                <!-- CONTENIDO AJAX -->
            </div>
        </div>
    </div>
</div>
<!--# QUE SE HACEN EDITAR-->


<!-- COMO SE HACEN-->
<div class="modal fade"  id="modalAgregarComoHacen"  role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">                
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title" id="myLargeModalLabel">Agregar como se hace</h5>
            </div>
            <div id="resultadoAgregarComoHacen">
                <!-- CONTENIDO AJAX -->
            </div>
        </div>
    </div>
</div>
<!--# COMO SE HACEN-->

<!-- COMO SE HACEN EDITAR-->
<div class="modal fade"  id="modalEditarComoHacen"  role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">                
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title" id="myLargeModalLabel">Editar como se hace</h5>
            </div>
            <div id="resultadoComoHacenEditar">
                <!-- CONTENIDO AJAX -->
            </div>
        </div>
    </div>
</div>
<!--# COMO SE HACEN EDITAR-->

<!-- AGREGAR TIPO DE ACTUACION-->
<div class="modal fade"  id="modalAgregarTipoActuacion" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title" id="myModalLabel">Agregar tipo de actuación</h5>
            </div>
            <div id="resultadoAgregarTipoActuacion">
              <!-- CONTENIDO AJAX -->
            </div>
        </div>
    </div>
</div>
<!--# AGREGAR TIPO DE ACTUACION-->

<!-- EDITAR TIPO DE ACTUACION-->
<div class="modal fade"  id="modalEditarTipoActuacion" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">                
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title" id="myLargeModalLabel">Editar tipo de actuación</h5>
            </div>
            <div id="resultadoEditarTipoActuación">
                <!-- CONTENIDO AJAX -->
            </div>
        </div>
    </div>
</div>
<!--# EDITAR TIPO DE ACTUACION-->

@endsection
@section('scriptsFin')
    <script src="{{asset('js/js_configurarProceso/adminConfigurar.js?v=4')}}"></script>
    <script src="{{ asset('js/form-advance-data.js')}}"></script>
    <script src="{{asset('js/plugin/bootstrap-wizard/jquery.bootstrap.wizard.min.js')}}"></script>
    <script src="{{asset('js/plugin/fuelux/wizard/wizard.min.js')}}"></script>
    <script src="{{asset('js/jquery-sortable-lists.js')}}"></script>
    <script type="text/javascript">
        $(window).on('load', function() { 
          isntanciasTipoProceso();
          pasosPadre();
          pasosHijo();
          tiposActuaciones();
          modulosTiposProceso();
        });
    </script>
    </script>
@stop