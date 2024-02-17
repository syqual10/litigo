<div class="logo-container full-screen-table-demo">
    <div class="logo"><img src="{{ asset('img/litigo-1.png') }}"></div>
</div>
<div class="fresh-table full-screen-table toolbar-color-blue">
    <table id="tablaRespInt" class="table tabla-fresh">
        <thead>
            <tr>
                <th data-sortable="true">Nombre</th>
                <th data-sortable="true"></th>
                <th data-sortable="true"></th>
            </tr>
        </thead>
        <tbody>
        @if(count($resopnsablesInt) > 0)
            @foreach($resopnsablesInt as $respInt)
                <tr>
                    <td style="width:90%">{{$respInt->nombresUsuario}}</td>
                    <td style="width:5%">
                        <button class="btn btn-xs btn-danger btn-rounded" onclick="eliminarRespoInt({{$idResponsable}}, {{$respInt->idResponsableInterno}})"><i class="fa fa-trash"></i> Eliminar</button>
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
</div>