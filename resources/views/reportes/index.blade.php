@extends('layouts.master')
@section('cabecera')

@endsection
@section('contenido')

<input type="hidden" value="{{$reporte}}" id="reporte">
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
        <li>Inicio</li><li>Reportes</li><li>{{$titulo}}</li>
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
                        <h2><strong>Reportes</strong> <i>{{$titulo}}</i></h2>  
                    </header>
                    <!-- widget div-->
                    <div role="content">
                        <!-- widget content -->
                        <div class="widget-body"> 
                            <div class="row">
                                <div class="col-md-3" style="border-right:1px dotted #ddd; background:#f0f0f0;padding:20px 10px 40px 20px">
                                    <legend>Reportes de {{$titulo}}</legend>
                                    @if($reporte == 1)<!--Medios de control-->
                                        <label class="control-label pull-left">Medios de control:</label>
                                        {{ 
                                            Form::select('selectMedioControl', $listaTipoMediosControl, null, ['placeholder' => 'Todos', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectMedioControl', 'style' => 'margin-bottom:8px;'])
                                        }}
                                    @endif<!--# tipos de procesos-->
                                    @if($reporte == 2)<!--Acciones-->          
                                        <label class="control-label pull-left">Acciones:</label>
                                        {{ 
                                            Form::select('selectAccion', $listaAcciones, null, ['placeholder' => 'Todos', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectAccion', 'style' => 'margin-bottom:8px;'])
                                        }}
                                    @endif<!--# Acciones-->
                                    @if($reporte == 3)<!--usuarios-->          
                                        <label class="control-label pull-left">Funcionarios:</label>
                                        {{ 
                                            Form::select('selectUsuario', $listaUsuarios, null, ['placeholder' => 'Todos', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectUsuario', 'style' => 'margin-bottom:8px;'])
                                        }}
                                    @endif<!--# usuarios-->
                                    @if($reporte == 4)<!--Estados radicados-->
                                        <label class="control-label pull-left">Tipo de proceso:</label>
                                        {{
                                            Form::select('selectTipoProceso', $listaProcesos, null, ['placeholder' => 'Todos', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectTipoProceso', 'style' => 'margin-bottom:8px;'])
                                        }}
                                        <hr>
                                        {{ 
                                            Form::select('selectEstadoRadicado', $listaEstadosRadicados, null, ['placeholder' => 'Todos', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectEstadoRadicado', 'style' => 'margin-bottom:8px;'])
                                        }}
                                    @endif<!--# Estados radicados-->
                                    @if($reporte == 5)<!--Abogados demandantes-->
                                        <label class="control-label pull-left">Abogados demandantes:</label>
                                        {{ 
                                            Form::select('selectAbogadoDemandante', $listaAbogadosApoderados, null, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectAbogadoDemandante', 'style' => 'margin-bottom:8px;'])
                                        }}
                                    @endif<!--# Abogados demandantes-->
                                    @if($reporte == 6)<!--Demandantes-->
                                        <label class="control-label pull-left">Demandante:</label>
                                        <input type="text" id="documentoDemandante" name="documentoDemandante" class="form-control" placeholder="Documento del demandante">
                                    @endif<!--# Demandantes-->
                                    @if($reporte == 7)<!--Juzgados-->
                                        <label class="control-label pull-left">Juzgados:</label>
                                        {{ 
                                            Form::select('selectJuzgado', $listaJuzgados, null, ['placeholder' => 'Todos', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectJuzgado', 'style' => 'margin-bottom:8px;'])
                                        }}
                                    @endif<!--# Juzgados-->
                                    @if($reporte == 8)<!--Secretarías-->
                                        <label class="control-label pull-left">Secretaría:</label>
                                        {{ 
                                            Form::select('selectSecretaria', $listaSecretarias, null, ['placeholder' => 'Todos', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectSecretaria', 'style' => 'margin-bottom:8px;'])
                                        }}
                                    @endif<!--# Secretarías-->
                                    @if($reporte == 9)<!--Tipo de actuaciones-->
                                        <label class="control-label pull-left">Tipo Actuación:</label>
                                        {{ 
                                            Form::select('selectTipoActuacion', $listaTipoActuaciones, null, ['placeholder' => 'Todos', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectTipoActuacion', 'style' => 'margin-bottom:8px;'])
                                        }}
                                    @endif<!--# Tipo de actuaciones-->
                                    @if($reporte == 11)<!--Temas-->
                                        <label class="control-label pull-left">Tema:</label>
                                        <input type="text" id="tema" name="tema" class="form-control" placeholder="Tema">
                                    @endif<!--# Temas-->
                                    @if($reporte == 12)<!--Fallos instancias-->
                                        <label class="control-label pull-left">Tipo de proceso:</label>
                                        {{
                                            Form::select('selectTipoProceso', $listaProcesos, null, ['placeholder' => 'Selecione', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectTipoProceso', 'style' => 'margin-bottom:8px;'])
                                        }}
                                        <hr>
                                        <label class="control-label pull-left">Instancia:</label>
                                            {{ 
                                                Form::select('selectTipoActuacion', $listaTipoActuaciones, null, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectTipoActuacion', 'style' => 'margin-bottom:8px;'])
                                            }}
                                    @endif<!--# Fallos instancias-->
                                    @if($reporte == 14)<!--Temas-->
                                        <label class="control-label pull-left">Asunto:</label>
                                        <input type="text" id="asunto" name="asunto" class="form-control" placeholder="Asunto">
                                    @endif
                                    <hr>  
                                    @if($reporte != 5 && $reporte != 6 && $reporte != 11)<!--DIFERENTE A REPORTE ABOGADOS DEMANDANTES Y A DEMANDANTES Y A TEMAS-->
                                        <label class="control-label mb-10 text-left">Rango de fechas</label>
                                        <input id="rangoFecha" class="form-control input-daterange-datepicker" type="text" name="daterange" value="{{date('m-d-Y')}}-{{date('m-d-Y')}}"/>
                                    @else
                                        <input type="hidden" id="rangoFecha" value="0">
                                        <button class="btn btn-success applyBtn"><i class="icon-rocket"></i> <a id="eventUrl" style="color:#fff; text-decoration:none;">Consultar</a></button>
                                    @endif
                                </div>

                                <div class="col-md-9">
                                    <div id="resultadoTablaReporte">
                                        <!-- AJAX REPORTE -->
                                        <div class="jumbotron">
                                            <h1>Centro de Reportes</h1>
                                            <p>
                                                Por favor seleccione los criterios de búsqueda en la sección izquierda para ver su resultado aquí.
                                            </p>
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
@endsection
@section('scriptsFin')    
    <script src="{{asset('js/js_reportes/reportes.js?v=14')}}"></script>
    <script type="text/javascript">
        $('.input-daterange-datepicker').daterangepicker({
            buttonClasses: ['btn', 'btn-sm'],
            applyClass: 'btn-info',
            cancelClass: 'btn-default',
            locale: {
                format: 'YYYY/MM/DD' // --------Here
            },
        });

        $(".select2").select2({ width: '100%' });
    </script>
    </script>
@stop