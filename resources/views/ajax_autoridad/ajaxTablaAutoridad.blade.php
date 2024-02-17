<div class="logo-container full-screen-table-demo">
    <div class="logo"><img src="{{ asset('img/litigo-1.png') }}"></div>
</div>
<div class="fresh-table full-screen-table toolbar-color-blue">
    <div class="toolbar">
        <button id="alertBtn" class="btn btn-default" onclick="agregarAutoridad();">Agregar una autoridad conocedora</button>
    </div>
    
    <table id="fresh-table" class="table tabla-fresh">
        <thead>
            <tr>
                <th data-sortable="true">Nombre</th>
                <th data-sortable="true"></th>
                <th data-sortable="true"></th>
            </tr>
        </thead>
        <tbody>
            @if(count($autoridades) > 0)
                @foreach($autoridades as $autoridad)
                    <tr>
                        <td style="width:90%">{{$autoridad->nombreAutoridadConoce}}</td>
                        <td style="width:5%">
                            <button class="btn btn-xs btn-primary btn-rounded" onclick="editarAutoridad({{$autoridad->idAutoridadConoce}})"><i class="fa fa-edit"></i> Editar</button>
                        </td>
                        <td style="width:5%">
                            <button class="btn btn-xs btn-danger btn-rounded" onclick="eliminarAutoridad({{$autoridad->idAutoridadConoce}})"><i class="fa fa-trash"></i> Eliminar</button>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>