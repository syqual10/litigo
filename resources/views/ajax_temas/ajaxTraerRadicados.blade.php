@php
    use SQ10\helpers\Util as Util;
@endphp

             
@if (count($radicados) > 0)
    <br>
    <fieldset>
        <div class="row">
            <div class="col-sm-4">
                <div class="row">
                    <div class="col-sm-2">
                        <span class="pasos">1</span>
                    </div>
                    <div class="col-sm-10">
                        <label class="pull-left" style="font-weight: 600">Seleccione el tema que va a establecer.  Si requiere agregar temas nuevos, se recomienda que estos no sean específicos para cada demanda.  Piense en temas generales que puedan ser compartidos por múltiples demandas.  Por ej: <strong>"Deslizamientos", "Obras de Estabilidad", "Programa Colombia Mayor"</strong>, etc.  Esto permitirá agrupar las demandas y construir reportes mas acertados:</label>                    
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-12" id="resultadoTemas">
                        <!--AJAX CARGA LOS TEMAS-->
                    </div>
                </div>
            </div>

            <div class="col-sm-4" style="border-left: 3px solid #20c2f8;">
                <div class="row">
                    <div class="col-sm-2">
                        <span class="pasos">2</span>
                    </div>
                    <div class="col-sm-10">
                        <label class="pull-left" style="font-weight: 600"> En la tabla inferior aparecen <u>{{count($radicados)}}</u> procesos que cumplen con el criterio de búsqueda. Seleccione los procesos a los que les desea establecer el tema.  Haga clic en la última columna sobre el selector <u>"Establecer tema"</u>:</label>                    
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-12" style="text-align: center">
                        <img src="{{asset('img/sel.png')}}" style="margin-top:10px">
                    </div>
                </div>
            </div>
            <div class="col-sm-4" style="border-left: 3px solid #20c2f8;">
                <div class="row">
                    <div class="col-sm-2">
                        <span class="pasos">3</span>
                    </div>
                    <div class="col-sm-10">
                        <label class="pull-left" style="font-weight: 600">Cuando haya seleccionado los procesos, finalmente haga clic en el siguiente botón para aplicar el tema masivamente a los seleccionados:</label>                    
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-12" style="text-align: center">
                        <br>
                        <button class="btn btn-danger" onclick="establecerTemaMasivo();"><i class="fa fa-check-square"></i> Aplicar tema a los procesos seleccionados</button>
                    </div>
                </div>
            </div>
        </div>
    </fieldset>

    <hr>

    <div class="inbox-nav-bar no-content-padding">
        <div class="page-title txt-color-blueDark hidden-tablet h1" style="width:auto !important"><i class="fa fa-fw fa-check"></i> 
            Temas demandas  
        </div>

        <a href="javascript:void(0);" id="compose-mail-mini" class="btn btn-primary pull-right hidden-desktop visible-tablet"> <strong><i class="fa fa-file fa-lg"></i></strong> </a>

        <div class="btn-group pull-right inbox-paging">
            <a href="javascript:void(0);" onclick="marcarTodo();" class="btn btn-default btn-sm">
                <strong><i class="fa fa-check-square-o"></i> Todo</strong>
            </a>
            <a href="javascript:void(0);" onclick="desmarcarTodo();" class="btn btn-default btn-sm">
                <strong><i class="fa fa-square-o"></i> Nada</strong>
            </a>
        </div>
        <span class="pull-right">
            Se encontraron 
            @if(count($radicados) == 1)
                <strong>{{count($radicados)}} Proceso</strong>
            @elseif(count($radicados) > 0)
                <strong>{{count($radicados)}} Procesos</strong>
            @else
                <strong>0 Procesos</strong>
            @endif
        </span>
    </div>

    <form id="f1">
        <table class="table table-hover table-bordered">
            <thead>
                <tr style="background: #0aa699">
                    <th style="width:5%">Radicado</th>
                    <th style="width:8%">Tipo Proceso</th>
                    <th style="width:22%">Juzgado</th>
                    <th style="width:10%">Código Proceso</th>
                    <th style="width:35%">Descripción Hechos</th>
                    <th style="width:10%">Tema</th>
                    <th style="width:10%"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($radicados as $radicado)
                    @php
                        $rad = $radicado->vigenciaRadicado."-".$radicado->idRadicado;
                    @endphp
                    <tr>
                        <td><small class="label label-danger" style="font-size: 0.9em;">{{$rad}}</small></td>
                        <td>{{$radicado->nombreTipoProceso}}</td>
                        <td>{{$radicado->nombreJuzgado}}</td>
                        <td><strong>{{$radicado->codigoProceso}}</strong>
                            <br>
                            {{$radicado->radicadoJuzgado}}
                        </td>
                        <td><p class="hechos" >{{$radicado->descripcionHechos}}</p></td>
                        <td><small class="label label-danger" style="font-size: 0.9em;">{{$radicado->nombreTema}}</small></td>
                        <td>	
                            <div class="checkbox">
                                <label>
                                    <input id="rad_{{$rad}}" type="checkbox" class="checkbox style-3 selector" name='seleccion[]' value="{{$rad}}">
                                    <span>Establecer tema</span>
                                </label>
                            </div>
                        </td>                                                       
                    </tr>
                @endforeach
            </tbody>
        </table>
    </form>
@else
    <div class="alert alert-white alert-dismissible">
        <h4><i class="icon fa fa-info-circle"></i> <b> Atención</b></h4>
        No se encontraron procesos que cumplan con el criterio de búsqueda.
    </div>
@endif