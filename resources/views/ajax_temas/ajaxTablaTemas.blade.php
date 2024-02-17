<div class="logo-container full-screen-table-demo">
    <div class="logo"><img src="{{ asset('img/litigo-1.png') }}"></div>
</div>
<div class="fresh-table full-screen-table toolbar-color-blue">
    <div class="toolbar">
        <button id="alertBtn" class="btn btn-default" onclick="agregarTema();">Agregar tema</button>
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
        @if(count($temas) > 0)
            @foreach($temas as $tema)
                <tr>
                    <td style="width:90%">{{$tema->nombreTema}}</td>
                    <td style="width:5%">
                        <button class="btn btn-xs btn-primary btn-rounded" onclick="editarTema({{$tema->idTema}})"><i class="fa fa-edit"></i> Editar</button>
                    </td>
                    <td style="width:5%">
                        <button class="btn btn-xs btn-danger btn-rounded" onclick="eliminarTema({{$tema->idTema}})"><i class="fa fa-trash"></i> Eliminar</button>
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
</div>