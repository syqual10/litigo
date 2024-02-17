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
        <li>Inicio</li><li>Administración</li><li>Puntos de Atención</li>
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
                <div class="jarviswidget jarviswidget-color-darken" role="widget">
                    <header role="heading">
                      <h2>Administración <strong><i>de Puntos de Atención</i></strong></h2>
                    </header>
                    <!-- widget div-->
                    <div role="content">
                        <!-- widget content -->
                        <div class="widget-body">
                            <div id="resultadoPuntosAtencion" class="cont-ajax">
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

<!-- AGREGAR PUNTO-->
<div class="modal fade"  id="modalAgregarPuntoAtencion" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title" id="myModalLabel">Agregar Punto de Atención</h5>
            </div>
            <div id="resultadoAgregarPuntoAtencion">
              <!-- CONTENIDO AJAX -->
            </div>
        </div>
    </div>
</div>
<!--# AGREGAR PUNTO-->

<!-- EDITAR PUNTO-->
<div class="modal fade"  id="modalEditarPuntoAtencion" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title" id="myModalLabel">Editar Punto de Atención</h5>
            </div>
            <div id="resultadoEditarPuntoAtencion">
              <!-- CONTENIDO AJAX -->
            </div>
        </div>
    </div>
</div>
<!--# EDITAR PUNTO-->

<!-- RESPONSABLES PUNTO-->
<div class="modal fade"  id="modalResponsablesPuntoAtencion" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title" id="myModalLabel">Responsables Punto de Atención</h5>
            </div>
            <div id="resultadoResponsablesPuntoAtencion">
              <!-- CONTENIDO AJAX -->
            </div>
        </div>
    </div>
</div>
<!--# RESPONSABLES PUNTO-->
@endsection
@section('scriptsFin')
    <script src="{{asset('js/js_puntoatencion/adminPuntoAtencion.js?v=1')}}"></script>

    <script type="text/javascript">
        $(window).on('load', function() {
          puntosAtencion();
        });
    </script>
    </script>
@stop
