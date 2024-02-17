@php
    use SQ10\helpers\Util as Util;
@endphp

<div class="panel-heading">
    <div class="pull-left">
        <h6 class="panel-title txt-dark">Responsables Etapas</h6>
    </div>
    <div class="clearfix"></div>
</div>
<div class="panel-wrapper collapse in">
    <div class="panel-body">
        <div class="table-wrap">
            <div class="table-responsive">
                @if(count($etapas) > 0)
                    <table id="tablaResponsablesEtapa" class="table table-hover table-bordered display  pb-30" >
                        <thead>
                            <tr>
                                <th>Etapa</th>
                                <th>Número de responsables</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($etapas as $etapa)
                                <tr>
                                    <td>{{$etapa->nombreEtapa}}</td>
                                    <td>{{Util::cantidadResponsablesEtapa($etapa->idEtapa)}}</td>
                                    <td>
                                        <button class="btn btn-warning btn-rounded" onclick="agregarResponsableEtapa({{$etapa->idEtapa}})">Responsables</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <fieldset>   
                        <div style="text-align:center;" >
                            <i class="fa fa-fw fa-minus-circle icono-else"></i>
                            <p align="center" class="titulo-else">No se encontrarón responsables designados</p>
                        </div>
                    </fieldset>
                @endif
            </div>
        </div>
    </div>
</div>