@if(count($cuantias) > 0)
    <div class="dtt">
        <table class="display projects-table table table-striped table-bordered table-hover dataTable no-footer">
            <thead>
                <tr>
                    <th>Unidad Monetaria</th>
                    <th>Valor Unidad Monetaria</th>
                    <th>Valor en pesos</th>
                    <th></th>
                </tr>
            </thead>            
            <tbody>
                @foreach($cuantias as $cuantia)
                    <tr>
                        @if($cuantia->unidadMonetaria == 1)
                            <td width="25%">Salarios Mínimos</td>
                        @else
                            <td width="25%">Pesos</td>
                        @endif

                        <td width="25%">{{$cuantia->valor}}</td>
                        <td width="25%">
                            <span class="pull-right" style="font-weight: bold">
                                $ {{number_format((float)$cuantia->valorPesos, 0, ',', '.')}}</td>
                            </span>
                        <td width="25%">
                            <button class="btn btn-xs btn-danger btn-rounded" onclick="eliminarCuantia({{$cuantia->idCuantia}})"><i class="fa fa-trash"></i> Eliminar</button>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3">
                        <span class="pull-right" style="font-weight: bold">
                            $ {{number_format((float)$sumaCuantias, 0, ',', '.')}}
                        </span>
                    </td>
                    <td></td>
                </tr>
                <input type="hidden" value="{{$sumaCuantias}}" id="valorCalcular">
            </tbody>
        </table>
    </div>
@else
    <p class="alert alert-info">
        <i class="fa fa-warning fa-fw fa-2x"></i><strong>Atención!</strong> 
        No se encontrarón cuantías registradas
    </p>
@endif