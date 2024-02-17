<div class="logo-container full-screen-table-demo">
    <div class="logo"><img src="{{ asset('img/litigo-1.png') }}"></div>
</div>
<div class="fresh-table full-screen-table toolbar-color-blue">
    <div class="toolbar">
        <button id="alertBtn" class="btn btn-default" onclick="agregarTipoBitacora();">Agregar un tipo de bitácora</button>
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
            @if(count($tiposBitacora) > 0)
                @foreach($tiposBitacora as $tipoBitacora)
                    <tr>
                        <td style="width:90%">{{$tipoBitacora->nombreTipoBitacora}}</td>
                        <td style="width:5%">
                            <button class="btn btn-xs btn-primary btn-rounded" onclick="editarTipoBitacora({{$tipoBitacora->idTipoBitacora}})"><i class="fa fa-edit"></i> Editar</button>
                        </td>
                        <td style="width:5%">
                            <button class="btn btn-xs btn-danger btn-rounded" onclick="eliminarTipoBitacora({{$tipoBitacora->idTipoBitacora}})"><i class="fa fa-trash"></i> Eliminar</button>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>