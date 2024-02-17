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
        <li>Inicio</li><li>Procesos Terminados</li>
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
            <article>
                <div class="jarviswidget jarviswidget-color-darken" role="widget">
                    <header role="heading">
                      <h2>Procesos <strong><i>Terminados</i></strong></h2>
                    </header>
                    <!-- widget div-->
                    <div role="content">
                        <!-- widget content -->
                        <div class="widget-body">
                            <div  class="col-sm-3">
                                <label class="label">Fecha de Notificación:</label>
                                <!--<input type="hidden" id="fechaNotifi" value="date('Y-m-d')}}">-->
                                  <!-- Vigencia radicados -->
                                <div id="divVigenciaBuscar">
                                    <div class="col-sm-4">
                                        <select id="fechaTerminado" class="form-control" onchange="terminados(1);">
                                            <option value='{{ $vigenciaActual }}'>{{ $vigenciaActual }}</option>
                                                <?php 
                                                for ($i=2004; $i<=$vigenciaActual; $i++) 
                                                {
                                                    echo "<option value='$i'>$i</option>";
                                                }  
                                                ?>
                                        </select>
                                    </div>
                                </div>
                                <!-- # Vigencia radicados -->                  

                                <input type="hidden" id="fechaTerminadoIni" name="fechaTerminadoIni" placeholder="Seleccione fecha de notificación" class="form-control datepicker" data-dateformat="yy-mm-dd" value="{{date('Y-m-d')}}">
                            </div>

                            <div id="ajax-terminados" class="cont-ajax col-sm-9">
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

<div class="modal fade in" id="modalPdfGenerado" tabindex="-1" role="dialog" aria-labelledby="defModalHead" aria-hidden="true">
    <div class="modal-dialog" style="width:98%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="defModalHead">Hemos generado este PDF</h4>
            </div>
            <div class="modal-body">               
                 <iframe id="framePdf" style="width: 100%;height: 450px;"></iframe>  
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-xs-12">
                        <button type="button" class="btn btn-primary pull-right" data-dismiss="modal">Cerrar esta ventana</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scriptsFin')
    <script src="{{asset('js/js_terminados/terminados.js?v=4')}}"></script>

    <script type="text/javascript">
        $(window).on('load', function() {
          terminados(1);
        });
    </script>
@stop
