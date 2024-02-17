@extends('layouts.master')
@section('cabecera')
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
        <li>Inicio</li><li>Temas masivos procesos</li>
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
                      <h2>Establecer Tema a Procesos</h2>
                    </header>
                    <!-- widget div-->
                    <div role="content">
                        <!-- widget content -->
                        <div class="widget-body" style="padding: 10px">
                            <div class="row" style="padding: 10px 5px 20px 5px;background:#f1eeee">
                                <div  class="col-sm-2">
                                    <label class="pull-left" style="font-weight: 600">Procesos de la vigencia:</label>
                                    <br>
                                    <select id="vigencia" class="form-control">
                                        <option value='0'>Todas las vigencias</option>
                                            <?php 
                                            for ($i=2000; $i<=$vigenciaActual; $i++) 
                                            {
                                                echo "<option value='$i'>$i</option>";
                                            }  
                                            ?>
                                    </select>
                                </div>

                                <div  class="col-sm-2">
                                    <label class="pull-left" style="font-weight: 600">Procesos en estado:</label>
                                    <br>
                                    <select id="estado" class="pull-left form-control">
                                        <option value='1' selected>En curso</option>
                                        <option value='2'>Terminados</option>
                                        <option value='3'>Cancelados</option>    
                                        <option value='0'>Todos</option>                                        
                                    </select>
                                </div>
                                <div  class="col-sm-2">
                                    <label class="pull-left" style="font-weight: 600">Sólo traer procesos:</label>
                                    <br>
                                    <select id="condicion" class="pull-left form-control">
                                        <option value='1'>Procesos con tema</option>
                                        <option value='2' selected>Procesos sin tema</option>
                                        <option value='0'>Todos</option>                                        
                                    </select>
                                </div>
                                <div  class="col-sm-2">
                                    <label class="pull-left" style="font-weight: 600">Procesos que contengan el término:</label>
                                    <br>
                                    <input type="text" id="termino" class="form-control" placeholder="Ej: Deslizamiento Cervantes" autofocus>
                                </div>
                                <div  class="col-sm-2">
                                    <br>
                                    <button class="btn btn-primary" onclick="traerRadicados()"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                            <hr> 
                            <div class="row">
                                <div id="ajax-radicados" class="cont-ajax col-sm-12">
                                    <!-- ajax -->
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

@endsection
@section('scriptsFin')
    <script src="{{asset('js/js_temas/adminTemas.js?v='.rand(1,1000))}}"></script>
    <script type="text/javascript">
        $(window).on('load', function() {
          //traerRadicados(1);
        });
    </script>
@stop
