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
        <li>Inicio</li><li>Provisión</li><li>Contable</li>
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
                        <h2>Calificación del Riesgo <strong><i>y Provisión Contable</i></strong></h2>  
                    </header>
                    <!-- widget div-->
                    <div role="content">
                        <!-- widget content -->
                        <div class="widget-body"> 
		         			<div class="container mt-3">
							  	<h2>Calificación del Riesgo y Provisión Contable</h2>
							  	<br>
							  	<!-- Nav tabs -->
							  	<ul class="nav nav-tabs">
								    <li class="nav-item">
								      <a class="nav-link active" data-toggle="tab" href="#home" onclick="cuantiasRadicado();">Determinar el valor de las pretensiones</a>
								    </li>
								    <li class="nav-item">
								      <a class="nav-link" data-toggle="tab" href="#menu1">Ajustar el valor de las pretensiones</a>
								    </li>
								    <li class="nav-item">
								      <a class="nav-link" data-toggle="tab" href="#menu2">Calcular el riesgo de condena</a>
								    </li>
								    <li class="nav-item">
								      <a class="nav-link" data-toggle="tab" href="#menu3" onclick="pretensiones();">Registrar el valor de pretensiones</a>
								    </li>
							  	</ul>

						  		<!-- Tab panes -->
						  		<div class="tab-content">
								    <div id="home" class="container tab-pane active"><br>
								      <h3 class="tit-step"><strong>Cuantía del Radicado </strong> - Datos de la Cuantía</h3> 
                                      <hr>
								      <div id="resultadoCuantiaRadicado"></div>
								    </div>
								    <div id="menu1" class="container tab-pane fade"><br>
								        <h3 class="tit-step"><strong>Ajuste del Valor </strong> de las pretensiones</h3>

    								    <div class="row" style="margin-bottom: 5px;" >
                                            <div class="form-wrap">
                                                <div class="form-group">
                                                    <div class="col-sm-3">
                                                        <label class="control-label pull-right">Porcentaje ajuste de condena (0% - 500%)</label>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <input type="number" id="porcentajeCondena" name="porcentajeCondena" class="form-control" placeholder="%">
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label class="control-label pull-right">Vigencia admisión de la demanda</label>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        {{ 
                                                            Form::select('selectVigenciaInicialIpc', $listaVigencias, null, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectVigenciaInicialIpc', 'style' => 'margin-bottom:8px;', 'onchange' => 'valorIpcInicial()'])
                                                        }}
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>                                        

                                        <div class="row" style="margin-bottom: 5px;" >
                                            <div class="form-wrap">
                                                <div class="form-group">
                                                    <div class="col-sm-3">
                                                        <label class="control-label pull-right">Mes admisión de la demanda</label>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        {{ 
                                                            Form::select('selectMesInicialIpc', $listaMeses, null, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectMesInicialIpc', 'style' => 'margin-bottom:8px;' , 'onchange' => 'valorIpcInicial()'])
                                                        }}
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label class="control-label pull-right">Vigencia potencial del fallo</label>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        {{ 
                                                            Form::select('selectVigenciaFinalIpc', $listaVigencias, null, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectVigenciaFinalIpc', 'style' => 'margin-bottom:8px;', 'onchange' => 'valorIpcFinal()'])
                                                        }}
                                                    </div>                                                   
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row" style="margin-bottom: 5px;" >
                                            <div class="form-wrap">
                                                <div class="form-group">
                                                    <div class="col-sm-3">
                                                        <label class="control-label pull-right">Mes potencial del fallo</label>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        {{ 
                                                            Form::select('selectMesFinalIpc', $listaMeses, null, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectMesFinalIpc', 'style' => 'margin-bottom:8px;', 'onchange' => 'valorIpcFinal()'])
                                                        }}
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label class="control-label pull-right">Fecha de calificación:</label>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <input type="text" id="fechaActualizacion" name="fechaActualizacion" class="form-control datepicker" data-dateformat="yyyy-mm-dd" style="width:50%" onchange="calcularYearsFallo();">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row" style="margin-bottom: 5px;" >
                                            <div class="form-wrap">
                                                <div class="form-group">
                                                    <div class="col-sm-3">
                                                        <label class="control-label pull-right">IPC inicial</label>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <input type="text" id="ipcInicial" name="ipcInicial" class="form-control" placeholder="IPC inicial" readonly>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label class="control-label pull-right">IPC final</label>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <input type="text" id="ipcFinal" name="ipcFinal" class="form-control" placeholder="IPC final" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row" style="margin-bottom: 5px;" >
                                            <div class="form-wrap">
                                                <div class="form-group">
                                                    <div class="col-sm-3">
                                                        <label class="control-label pull-right">Años para el fallo:</label>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <input type="text" id="yearsFallo" name="yearsFallo" class="form-control" readonly>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <label class="control-label pull-right">Valor Calculado</label>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <input type="text" id="valorCalculado" name="valorCalculado" class="form-control" placeholder="Valor a calcular" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>                                      
                                        <button class="btn btn-success pull-right"><i class="icon-rocket"></i> <a id="eventUrl" style="color:#fff; text-decoration:none;" onclick="calcularIPC();"> <i class="fa fa-calculator"></i> Calcular</a></button>
                                        <br>
								    </div>
								    <div id="menu2" class="container tab-pane fade"><br>
								        <h3 class="tit-step"><strong>Calcular el riesgo </strong> de Condena</h3>
                                        <hr>								      
                                        <span>La cuantificación de cada rango de calificación del riesgo es un valor entre 0 y 100, el cual es sugerido por parte de la ANDJE, y puede modificarlo si lo considera necesario:
                                        </span>
                                        <hr>
                                        <div class="table-responsive" style="text-align: center !important">                            
                                            <table class="table" style="width: 30%; color:#333">
                                                <tbody>
                                                   <tr class="danger">
                                                        <td><label class="control-label pull-right">Alto</label></td>
                                                        <td>
                                                            <input type="number" id="tipoAlto" value="{{$valorTipoCalificaciones[0]->valorTipoCalificacion}}">
                                                        </td>
                                                    </tr>
                                                    <tr class="warning">
                                                        <td><label class="control-label pull-right">Medio Alto</label></td>
                                                        <td>
                                                            <input type="number" id="tipoMedioAlto" value="{{$valorTipoCalificaciones[1]->valorTipoCalificacion}}">
                                                        </td>
                                                    </tr>
                                                    <tr  class="info">
                                                        <td><label class="control-label pull-right">Medio Bajo</label></td>
                                                        <td>
                                                            <input type="number" id="tipoMedioBajo" value="{{$valorTipoCalificaciones[2]->valorTipoCalificacion}}">
                                                        </td>
                                                    </tr>
                                                    <tr  class="success">
                                                        <td><label class="control-label pull-right">Bajo</label></td>
                                                        <td>
                                                            <input type="number" id="tipoBajo" value="{{$valorTipoCalificaciones[3]->valorTipoCalificacion}}">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>                            
                                        </div>
                                        <table width="100%" class="table table-hover table-bordered"> 
                                            <tr>
                                                <td>
                                                    <label class="control-label pull-right">{{$criterios[0]->nombreCriterio}}</label>
                                                </td>
                                                <td>
                                                    {{ 
                                                        Form::select('selectCriterio1', $listaTipoCalificaciones, null, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectCriterio1', 'style' => 'margin-bottom:8px;', 'onchange' => 'valorRangoCriterio(this.value, 1)'])
                                                    }}

                                                </td>
                                                <td>
                                                    <input type="text" id="valorCriterio1" value="{{$criterios[0]->criterioSugerido}}">
                                                    <input type="hidden" id="valorRangoCriterio1">
                                                </td>
                                                <td width="20px">
                                                    <a href="#" id="algo" style="color:#2251d5;"  onMouseOver="this.style.color='#000', descripcionCriterio({{$criterios[0]->idCriterio}});" onMouseOut="this.style.color='#2251d5'"><i class="fa fa-question-circle" style="font-size:1.5em; margin-left:8px;"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="control-label pull-right">{{$criterios[1]->nombreCriterio}}</label>
                                                </td>
                                                <td>
                                                    {{ 
                                                        Form::select('selectCriterio2', $listaTipoCalificaciones, null, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectCriterio2', 'style' => 'margin-bottom:8px;', 'onchange' => 'valorRangoCriterio(this.value, 2)'])
                                                    }}
                                                </td>
                                                <td>
                                                    <input type="text" id="valorCriterio2" value="{{$criterios[1]->criterioSugerido}}">
                                                    <input type="hidden" id="valorRangoCriterio2">
                                                </td>
                                                <td>
                                                    <a href="#" id="algo" style="color:#2251d5;"  onMouseOver="this.style.color='#000', descripcionCriterio({{$criterios[1]->idCriterio}});" onMouseOut="this.style.color='#2251d5'"><i class="fa fa-question-circle" style="font-size:1.5em; margin-left:8px;"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="control-label pull-right">{{$criterios[2]->nombreCriterio}}</label>
                                                </td>
                                                <td>
                                                    {{ 
                                                        Form::select('selectCriterio3', $listaTipoCalificaciones, null, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectCriterio3', 'style' => 'margin-bottom:8px;', 'onchange' => 'valorRangoCriterio(this.value, 3)'])
                                                    }}
                                                </td>
                                                <td>
                                                    <input type="text" id="valorCriterio3" value="{{$criterios[2]->criterioSugerido}}">
                                                    <input type="hidden" id="valorRangoCriterio3">
                                                </td>
                                                <td>
                                                    <a href="#" id="algo" style="color:#2251d5;"  onMouseOver="this.style.color='#000', descripcionCriterio({{$criterios[2]->idCriterio}});" onMouseOut="this.style.color='#2251d5'"><i class="fa fa-question-circle" style="font-size:1.5em; margin-left:8px;"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="control-label pull-right">{{$criterios[3]->nombreCriterio}}</label>
                                                </td>
                                                <td>
                                                    {{ 
                                                        Form::select('selectCriterio4', $listaTipoCalificaciones, null, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectCriterio4', 'style' => 'margin-bottom:8px;', 'onchange' => 'valorRangoCriterio(this.value, 4)'])
                                                    }}
                                                </td>
                                                <td>
                                                    <input type="text" id="valorCriterio4" value="{{$criterios[3]->criterioSugerido}}">
                                                    <input type="hidden" id="valorRangoCriterio4">
                                                </td>
                                                <td>
                                                    <a href="#" id="algo" style="color:#2251d5;"  onMouseOver="this.style.color='#000', descripcionCriterio({{$criterios[3]->idCriterio}});" onMouseOut="this.style.color='#2251d5'"><i class="fa fa-question-circle" style="font-size:1.5em; margin-left:8px;"></i></a>
                                                </td>
                                            </tr>                                            
                                        </table>
                                        <hr>
                                        <button class="btn btn-success btn-guardar-calificacion pull-right"><i class="icon-rocket"></i> <a id="eventUrl" style="color:#fff; text-decoration:none;" onclick="validarGuardarCalificacion();"> <i class="fa fa-plus-circle"></i> Agregar</a></button>
								    </div>
								    <div id="menu3" class="container tab-pane fade"><br>
								      <h3>Paso 1 4</h3>
								      <div id="resultadoValorPretensiones"></div>
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

<!--# EDITAR DEPENDENCIA-->
@endsection
@section('scriptsFin')
    <script src="{{asset('js/js_provision/provision.js')}}"></script>
    </script>
    <script type="text/javascript">
        $(".select2").select2({ width: '100%' });
        $('.datepicker').datepicker({
            format: "yyyy-mm-dd",
            todayBtn: "linked",
            autoclose: true,
            todayHighlight: true
        });

        $(window).on('load', function() { 
          cuantiasRadicado();
        });
    </script>
@stop