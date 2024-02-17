@extends('layouts.master')
@section('contenido')
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
        <li>Inicio</li><li>Administración</li><li>Cargos</li>
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
                        <h2>Administración <strong><i>de Cargos</i></strong></h2> 
                    </header>
                    <!-- widget div-->
                    <div role="content">
                        <!-- widget content -->
                        <div class="widget-body">                                 
                            <div id="resultadoTablaCargos" class="cont-ajax">
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

<!-- AGREGAR CARGO-->
<div class="modal fade"  id="modalAgregarCargo"  role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title">Agregar Cargo</h5>
            </div>
            <div id="resultadoAgregarCargo">
              <!-- CONTENIDO AJAX -->
            </div>
        </div>
    </div>
</div>
<!--# AGREGAR CARGO-->

<!-- EDITAR CARGO-->
<div class="modal fade"  id="modalEditarCargo"  role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">                
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title">Editar Cargo</h5>
            </div>
            <div id="resultadoEditarCargo">
              <!-- CONTENIDO AJAX -->
            </div>
        </div>
    </div>
</div>
<!--# EDITAR CARGO-->

@endsection
@section('scriptsFin')
    <script src="{{asset('js/js_cargos/adminCargos.js')}}"></script>
    <script type="text/javascript">
        $(window).on('load', function() { 
          tablaCargos();
        });
    </script>
    </script>
@stop