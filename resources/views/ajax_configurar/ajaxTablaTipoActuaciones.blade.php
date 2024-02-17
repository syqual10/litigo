<div class="logo-container full-screen-table-demo">
    <div class="logo"><img src="{{ asset('img/litigo-1.png') }}"></div>
</div>
<div class="fresh-table full-screen-table toolbar-color-blue">
    <div class="bars pull-right">
        <button id="alertBtn" class="btn btn-default btn-tabla" onclick="agregarTipoActuacion();">Agregar un tipo de actuación</button>
    </div>
    <table id="fresh-table" class="table tabla-fresh">
        <thead>
            <tr>
                <th data-sortable="true">Nombre</th>
                <th data-sortable="true">Estado</th>
                <th data-sortable="true">¿Finaliza?</th>
                <th data-sortable="true"></th>
                <th data-sortable="true"></th>
            </tr>
        </thead>
        <tbody>
            @if(count($tipoActuaciones) > 0)
                @foreach($tipoActuaciones as $tipoActuacion)
                    <tr>
                        <td style="width:50%">{{$tipoActuacion->nombreActuacion}}</td>

                        @if($tipoActuacion->activo == 1)
                            <td style="width:20%">Activo</td>
                        @else
                            <td style="width:20%">Desactivado</td>
                        @endif

                        @if($tipoActuacion->tipoActuacionFinaliza == 1)
                            <td style="width:10%">Sí</td>
                        @else
                            <td style="width:10%">No</td>
                        @endif

                        <td style="width:10%">
                            <button class="btn btn-xs btn-primary btn-rounded" onclick="editarTipoActuacion({{$tipoActuacion->idTipoActuacion}})"><i class="fa fa-edit"></i> Editar</button>
                        </td>

                        @if($tipoActuacion->activo == 1)
                            <td style="width:10%">
                                <button class="btn btn-xs btn-danger btn-rounded" onclick="estadoTipoActuacion({{$tipoActuacion->idTipoActuacion}}, 0)" style="min-width:90px"><i class="fa fa-trash"></i> Desactivar</button>
                            </td>
                        @else
                            <td style="width:10%">
                                <button class="btn btn-xs btn-success btn-rounded" onclick="estadoTipoActuacion({{$tipoActuacion->idTipoActuacion}}, 1)" style="min-width:90px"><i class="fa fa-check-circle"></i> Activar</button>
                            </td>
                        @endif
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>