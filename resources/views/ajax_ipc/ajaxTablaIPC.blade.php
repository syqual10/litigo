<div class="logo-container full-screen-table-demo">
    <div class="logo"><img src="{{ asset('img/litigo-1.png') }}"></div>
</div>
<div class="fresh-table full-screen-table toolbar-color-blue">
    <div class="toolbar">
        <button id="alertBtn" class="btn btn-default" onclick="agregarIPC();">Agregar IPC</button>
    </div>
    <table id="fresh-table" class="table tabla-fresh">
        <thead>
            <tr>
                <th data-sortable="true">Vigencia</th>
                <th data-sortable="true">Mes</th>
                <th data-sortable="true">Valor</th>
                <th data-sortable="true"></th>
                <th data-sortable="true"></th>
            </tr>
        </thead>
        <tbody>
            @if(count($ipcs) > 0)
                @foreach($ipcs as $ipc)
                    <tr>
                        <td style="width:30%">{{$ipc->vigenciaIndice}}</td>
                        <td style="width:30%">{{$ipc->nombreMes}}</td>
                        <td style="width:30%">{{$ipc->valorIndice}}</td>
                        <td style="width:5%">
                            <button class="btn btn-xs btn-primary btn-rounded" onclick="editarIPC({{$ipc->idIndice}})"> <i class="fa fa-edit"></i> Editar</button>                            
                        </td>

                        <td style="width:5%">
                            <button class="btn btn-xs btn-danger btn-rounded" onclick="eliminarIPC({{$ipc->idIndice}})"><i class="fa fa-trash"></i> Eliminar</button>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>