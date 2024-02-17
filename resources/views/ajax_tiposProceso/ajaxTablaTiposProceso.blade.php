<div class="logo-container full-screen-table-demo">
    <div class="logo"><img src="{{ asset('img/litigo-1.png') }}"></div>
</div>
<div class="fresh-table full-screen-table toolbar-color-blue">
    <div class="toolbar">
        <button id="alertBtn" class="btn btn-default" onclick="agregarTipoProceso();">Agregar tipo proceso</button>
    </div>
    
    <table id="fresh-table" class="table tabla-fresh">
        <thead>
            <tr>
                <th data-sortable="true" width="85%" style="width:85%">Nombre</th>
                <th data-sortable="true" width="5%"></th>
                <th data-sortable="true" width="5%"></th>
                <th data-sortable="true" width="5%"></th>
            </tr>
        </thead>
        <tbody>
            @if(count($tiposProcesos) > 0)
                @foreach($tiposProcesos as $tipoProceso)
                    <tr>
                        <td style="width:85% !important">{{$tipoProceso->nombreTipoProceso}}</td>
                        <td style="width:5%">
                            <a href="{{ asset('configurarProceso/index/'.$tipoProceso->idTipoProcesos)}}" class="btn btn-xs btn-default btn-rounded"><i class="fa fa-cog"></i> Configurar</a>
                        </td>
                        <td style="width:5%">
                            <button class="btn btn-xs btn-primary btn-rounded" onclick="editarTipoProceso({{$tipoProceso->idTipoProcesos}})"><i class="fa fa-edit"></i> Editar</button>
                        </td>
                        <td style="width:5%">
                            <button class="btn btn-xs btn-danger btn-rounded" onclick="eliminarTipoProceso({{$tipoProceso->idTipoProcesos}})"><i class="fa fa-trash"></i> Eliminar</button>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>