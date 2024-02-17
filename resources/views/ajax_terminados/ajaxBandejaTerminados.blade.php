@php
    use SQ10\helpers\Util as Util;
@endphp
<div class="row">
    <div class="col-sm-11">
        <!-- widget grid -->
        <section id="widget-grid" style="margin-left:10px">
            <!-- row -->
            <div class="row">
                <!-- NEW WIDGET START -->
                <article class="col-sm-12">
                    <div class="jarviswidget jarviswidget-color-blue" role="widget">
                        <header role="heading">
                        <h2>{{ count($terminados) }} Procesos <strong><i>terminados el año {{ $fechaTerminado }} </i></strong></h2>	
                        </header>
                        <!-- widget div-->
                        <div role="content">							
                            <!-- widget content -->
                            <div class="widget-body">
                                @if (count($terminados) > 0)
                                        <div class="progress-group" style="margin: 0; font-weight: bold">
                                        <span class="progress-text">Archivados</span>
                                        <span class="progress-number">{{round($porcentaje, 1)}}%</span>
                                        <div class="progress sm" style="margin: 5px 0;">
                                            @if($porcentaje <= 50)
                                                <div class="progress-bar progress-bar-red" style="width: {{round($porcentaje, 1)}}%"></div>
                                            @elseif($porcentaje > 50 && $porcentaje < 100)
                                                <div class="progress-bar progress-bar-yellow" style="width: {{round($porcentaje, 1)}}%"></div>
                                            @elseif($porcentaje >= 100)
                                                <div class="progress-bar progress-bar-green" style="width: {{round($porcentaje, 1)}}%"></div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                                <hr>
                                <div class="box-body direct-chat-messages">
                                    @if (count($terminados) > 0)
                                        <table id="tabla-agda">	
                                            @foreach ($terminados as $terminado)
                                                <tr>
                                                    <td style="width:5%">
                                                        <small class="label label-warning" style="font-size: 0.9em;">
                                                            {{$terminado->vigenciaRadicado."-".$terminado->idRadicado}}
                                                        </small>
                                                        hola{{$terminado->idEstadoEtapa}}
                                                    </td>

                                                    <td style="width:10%">
                                                        {{$terminado->nombreTipoProceso}}
                                                    </td>
                                
                                                    @php
                                                        $apoderado = Util::datosEstadoEtapa($terminado->idEstadoEtapa)
                                                    @endphp
                                                    <td style="width:25%">
                                                        <strong>
                                                            @if(count($apoderado) > 0)
                                                                {{$apoderado[0]->nombresUsuario}} <br>
                                                            @endif
                                                        </strong>
                                                    </td>

                                                    <td style="width:25%">
                                                        <strong>
                                                            @if(count($apoderado) > 0)
                                                                {{ucfirst(utf8_encode(strftime("%A %d de %B de %Y", strtotime($apoderado[0]->fechaFinalEstado))))}}
                                                            @endif
                                                        </strong>
                                                    </td>
                            
                                                    <td style="width:10%">{{$terminado->nombreJuzgado}}</td>
                            
                                                    <td style="width:25%">	
                                                        <div class="inputGroup">  	
                                                            @if ($terminado->archivado == 1)
                                                                <input type="checkbox" value="{{$terminado->vigenciaRadicado."-".$terminado->idRadicado}}" id="chk-{{$terminado->vigenciaRadicado."-".$terminado->idRadicado}}" class="strikethrough" onchange="estadoArchivaProceso(this.value, 0)" checked>
                                                                <label for="chk-{{$terminado->vigenciaRadicado."-".$terminado->idRadicado}}" style="min-height:36px">{{$terminado->radicadoJuzgado}}</label>
                                                            @else
                                                                <input type="checkbox" value="{{$terminado->vigenciaRadicado."-".$terminado->idRadicado}}" id="chk-{{$terminado->vigenciaRadicado."-".$terminado->idRadicado}}" class="strikethrough" onchange="estadoArchivaProceso(this.value, 1)">
                                                                <label for="chk-{{$terminado->vigenciaRadicado."-".$terminado->idRadicado}}" style="min-height:36px">{{$terminado->radicadoJuzgado}}</label>
                                                            @endif
                                                        </div>
                                                    </td>                                                       
                                                </tr>
                                            @endforeach
                                        </table>
                                    @else
                                        <div class="alert alert-white alert-dismissible">
                                            <h4><i class="icon fa fa-info-circle"></i> <b> Atención</b></h4>
                                            No se encontraron procesos terminados en esta fecha.
                                        </div>
                                    @endif
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
</div>