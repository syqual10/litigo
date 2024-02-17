@php
    use SQ10\helpers\Util as Util;
@endphp
<div class="inbox-nav-bar no-content-padding">
    <div class="page-title txt-color-blueDark hidden-tablet h1" style="width:auto !important"><i class="fa fa-fw fa-calendar"></i> 
        {{ucfirst(utf8_encode(strftime("%A %d de %B de %Y", strtotime($fechaDespacho))))}} &nbsp;   
    </div>


    <a href="javascript:void(0);" id="compose-mail-mini" class="btn btn-primary pull-right hidden-desktop visible-tablet"> <strong><i class="fa fa-file fa-lg"></i></strong> </a>

    <div class="btn-group pull-right inbox-paging">
        <a href="javascript:void(0);" onclick="marcarTodo();" class="btn btn-default btn-sm">
            <strong><i class="fa fa-check-square-o"></i> Todo</strong>
        </a>
        <a href="javascript:void(0);" onclick="desmarcarTodo();" class="btn btn-default btn-sm">
            <strong><i class="fa fa-square-o"></i> Nada</strong>
        </a>
        <a href="javascript:void(0);" onclick="pdfDespachados();" class="btn btn-danger btn-sm">
            <strong><i class="fa fa-file-pdf-o"></i> Generar Planilla</strong>
        </a>
    </div>
    <span class="pull-right">
        Se encontraron 
        @if(count($despachos) == 1)
        <strong>{{count($despachos)}} Anexo</strong>
        @elseif(count($despachos) > 0)
        <strong>{{count($despachos)}} Anexos</strong>
        @else
            <strong>0 Anexos</strong>
        @endif

        @if($selectTipoDespacho == 1)
            Repartos
        @else
            Actuaciones
        @endif
    </span>

</div>

<form id="f1">
    <div class="logo-container full-screen-table-demo">
        <div class="logo"><img src="{{ asset('img/litigo-1.png') }}"></div>
    </div>
    <div class="fresh-table full-screen-table toolbar-color-blue" style="font-size:0.9em">
        <table id="fresh-table-despacho" class="table tabla-fresh">
            <thead>
                <tr>
                    <th data-sortable="true">Radicado</th>
                    <th data-sortable="true">Rad Juzgado</th>
                    <th data-sortable="true">Tipo Proceso</th>
                    <th data-sortable="true">Persona Remitente</th>
                    <th data-sortable="true">Entidad Remitente</th>
                    <th data-sortable="true">Usuario al que se remite</th>
                    <th data-sortable="true">Dependencia</th>
                    <th data-sortable="true"></th>
                </tr>
            </thead>
            <tbody>
            @if(count($despachos) > 0)
                @foreach($despachos as $despacho)
                    <tr>
                        <td style="width:10%">{{$despacho['vigenciaRadicado']."-".$despacho['idRadicado']}}</td>

                        <td style="width:10%">
                            {{$despacho['radicadoJuzgado']}}
                        </td>

                        <td style="width:10%">
                            {{$despacho['nombreTipoProceso']}}
                        </td>

                        <td style="width:10%"><strong>{{Util::personaDemandante($despacho['vigenciaRadicado'], $despacho['idRadicado'], $despacho['idTipoProceso'])}}</strong></td>

                        <td style="width:15%">{{$despacho['nombreJuzgado']}}</td>

                        <td style="width:20%">
                            @if($despacho['idEstadoEtapa'] != 0)
                                <strong>{{Util::ultimoUsuarioRadicado($despacho['idEstadoEtapa'])}}</strong>
                            @else
                               @php
                                    $usuSeRemite = Util::datosResponsable($despacho['idUsuario'])->nombresUsuario;
                                @endphp
                                <strong>
                                {{$usuSeRemite}}</strong>
                            @endif
                        </td>

                        <td style="width:10%">
                            <strong>
                                @if($despacho['idEstadoEtapa'] != 0)
                                    {{Util::datosUltimoUsuarioRadicado($despacho['idEstadoEtapa'])->nombreDependencia}}
                                @else
                                    @php
                                        $depSeRemite = Util::datosResponsable($despacho['idUsuario'])->nombreDependencia;
                                    @endphp
                                    {{$depSeRemite}}
                                @endif
                            </strong>
                        </td>

                        <td style="width:15%">
                            <div class="checkbox">
                                <label>
                                    @if($despacho['idEstadoEtapa'] != 0)
                                        <input type="checkbox" class="checkbox style-3 selector" name='seleccion[]' value="{{$despacho['idEstadoEtapa']}}">
                                    @else
                                        <input id="{{$despacho['idActuacionResponsable']}}" type="checkbox" class="checkbox style-3 selector" name='seleccion[]' value="{{$despacho['idActuacion']}}">
                                    @endif
                                    <span>Incluir</span>
                                </label>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
</form>