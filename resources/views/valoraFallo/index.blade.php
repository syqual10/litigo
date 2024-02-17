@extends('layouts.master')
@section('cabecera')
    <link rel="stylesheet" href="{{ asset('css/gauge.css') }}">
@endsection

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
        <li>Inicio</li><li>Valoración Probabilidad Fallo en Contra</li>
    </ol>
    <!-- end breadcrumb -->
</div>
<!-- END RIBBON -->

<input  type="hidden"  value="{{$proceso[0]->juriradicados_vigenciaRadicado}}" id="vigenciaRadicado">
<input  type="hidden"  value="{{$proceso[0]->juriradicados_idRadicado}}" id="idRadicado">
 <input type="hidden"  value="{{$proceso[0]->juritipoprocesos_idTipoProceso}}" id="idTipoProceso">
 <input type="hidden"  value="{{$idEstadoEtapa}}" id="idEstadoEtapa">

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
                        <h2>Proceso {{$proceso[0]->juriradicados_vigenciaRadicado."-".$proceso[0]->juriradicados_idRadicado}}<strong><i> Valoración del Riesgo</i></strong></h2>  
                    </header>
                    <!-- widget div-->
                    <div role="content">
                        <!-- widget content -->
                        <div class="widget-body"> 
		         			<div class="mt-3">
                                <div class="row">
                                    <div class="col-sm-9">
                                        <h3 class="tit-step"><strong>VALORACIÓN DE LA PROBABILIDAD DE FALLOS JUDICIALES </strong> EN CONTRA DE LA ENTIDAD</h3> 
                                    </div>
                                    <div class="col-sm-3">
                                        <button class="btn btn-success pull-right" onclick="cargarValoracionesFallo()"> Ver valoraciones del proceso</button>
                                    </div>
                                </div>
                                
                                <hr>
    					        <div id="ajax-valoraciones"></div>
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

<!-- DESCRIPCIÓN-->
<div class="modal fade"  id="modalDescripcion" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title" id="myModalLabel">Criterio</h5>
            </div>
            <div id="resultadoDescripcion">
              <!-- CONTENIDO AJAX -->
            </div>
        </div>
    </div>
</div>
<!--# DESCRIPCIÓN -->

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

<!--# EDITAR DEPENDENCIA-->
@endsection
@section('scriptsFin')
<script src="{{asset('js/js_valoracionFallo/valoracionFallo.js?v=1')}}"></script>
<script type="text/javascript">
    $(window).on('load', function() { 
        cargarValoracionesFallo();
    });
</script>
@stop