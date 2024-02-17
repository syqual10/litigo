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
        <li>Inicio</li><li>Configuración</li><li>Autoridad Conocedora</li>
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
                        <h2>Administración <strong><i>Autoridad Conocedora</i></strong></h2>  
                    </header>
                    <!-- widget div-->
                    <div role="content">
                        <!-- widget content -->
                        <div class="widget-body">                                
                            <div id="resultadoTablaAutoridadConocedora" class="cont-ajax">
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

<!-- AGREGAR autoridad conocedora-->
<div class="modal fade"  id="modalAgregarAutoridadConocedora"  role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">                
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title" id="myLargeModalLabel"> Agregar Autoridad Conocedora</h5>
            </div>
            <div id="resultadoAgregarAutoridadConocedora">
              <!-- CONTENIDO AJAX -->
            </div>
        </div>
    </div>
</div>
<!--# AGREGAR autoridad conocedora-->

<!-- EDITAR autoridad conocedora-->
<div class="modal fade"  id="modalEditarAutoridadConocedora"  role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">                
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title" id="myLargeModalLabel"> Editar Autoridad Conocedora</h5>
            </div>
            <div id="resultadoEditarAutoridadConocedora">
              <!-- CONTENIDO AJAX -->
            </div>
        </div>
    </div>
</div>
<!--# EDITAR autoridad conocedora-->

@endsection
@section('scriptsFin')
    <script src="{{asset('js/js_autoridadConocedora/adminAutoridad.js')}}"></script>

    <script type="text/javascript">
        $(window).on('load', function() { 
          tablaAutoridades();
        });
    </script>
    </script>
@stop