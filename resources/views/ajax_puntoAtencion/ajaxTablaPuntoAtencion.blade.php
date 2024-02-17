@php
    use SQ10\helpers\Util as Util;
@endphp

<div class="logo-container full-screen-table-demo">
    <div class="logo"><img src="{{ asset('img/litigo-1.png') }}"></div>
</div>
<div class="fresh-table full-screen-table toolbar-color-blue">
    <div class="toolbar">
        <button id="alertBtn" class="btn btn-default" onclick="agregarPuntoAtencion();">Agregar un punto de atención</button>
    </div>
    
    <table id="fresh-table" class="table tabla-fresh">
        <thead>
            <tr>
                <th data-sortable="true">Nombre</th>
                <th data-sortable="true">Dirección</th>
                <th data-sortable="true"></th>
                <th data-sortable="true"></th>
            </tr>
        </thead>
        <tbody>
            @if(count($puntosAtencion) > 0)
                @foreach($puntosAtencion as $punto)
                    <tr>
                        <td style="width:40%">{{$punto->nombrePuntoAtencion}}</td>
                        <td style="width:40%">{{$punto->direccionPuntoAtencion}}</td>
                        <td style="width:5%">
                            <button class="btn btn-xs btn-primary btn-rounded" onclick="editarPunto({{$punto->idPuntoAtencion}})"><i class="fa fa-edit"></i> Editar</button>
                        </td>
                        <td style="width:5%">
                            <button class="btn btn-xs btn-danger btn-rounded" onclick="eliminarPunto({{$punto->idPuntoAtencion}})"><i class="fa fa-trash"></i> Eliminar</button>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>