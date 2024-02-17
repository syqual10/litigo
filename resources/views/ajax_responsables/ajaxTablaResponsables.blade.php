@php
    use SQ10\helpers\Util as Util;
@endphp


<div class="logo-container full-screen-table-demo">
    <div class="logo"><img src="{{ asset('img/litigo-1.png') }}"></div>
</div>
<div class="fresh-table full-screen-table toolbar-color-blue">
    <div class="toolbar">
        <button id="alertBtn" class="btn btn-default" onclick="agregarResponsable();">Agregar un responsable</button>
    </div>
    <table id="fresh-table-responsables" class="table tabla-fresh">
        <thead>
            <tr>
                <th data-sortable="true">Internos</th>
                <th data-sortable="true">Usuario</th>
                <th data-sortable="true">Documento</th>
                <th data-sortable="true">Dependencia</th>
                <th data-sortable="true">Cargo</th>
                <th data-sortable="true">Perfil</th>
                <th data-sortable="true">Rol</th>
                <th data-sortable="true">Estado</th>
                <th data-sortable="true">Generar Oficios</th>
                <th data-sortable="true"></th>
                <th data-sortable="true"></th>
            </tr>
        </thead>
        <tbody>
            @if(count($responsables) > 0)
                @foreach($responsables as $responsable)
                    <tr>
                        <td style="width:5%">
                            <button class="btn btn-xs btn-primary btn-rounded" onclick="agregarRespInternos({{$responsable->idResponsable}}, 1)"><i class="fa fa-edit"></i> {{Util::responsablesInternosResp($responsable->idResponsable)}}</button>
                        </td>
                        <td style="width:20%">{{$responsable->nombresUsuario}}</td>
                        <td style="width:20%">{{$responsable->documentoUsuario}}</td>
                        <td style="width:15%">{{$responsable->nombreDependencia}}</td>
                        <td style="width:10%">{{$responsable->nombreCargo}}</td>
                        <td style="width:10%">{{$responsable->nombrePerfil}}</td>
                        <td style="width:10%">{{$responsable->nombreRol}}</td>
                        <td style="width:10%">
                            @if ($responsable->estadoResponsable == 1)
                                Estado Activo
                            @else
                                Estado Desactivado
                            @endif
                        </td>
                        <td style="width:10%">
                            @if ($responsable->generarOficios == 1)
                                Sí Genera Oficios
                            @else
                                No Genera Oficios
                            @endif
                        </td>
                        <td style="width:5%">
                            <button class="btn btn-xs btn-primary btn-rounded" onclick="editarResponsable({{$responsable->idResponsable}})"><i class="fa fa-edit"></i> Editar</button>
                        </td>
                        @if($responsable->estadoResponsable == 0)
                            <td style="width:5%">
                                <button class="btn btn-xs btn-danger btn-rounded" onclick="desactivarResponsable({{$responsable->idResponsable}}, 1)"><i class="fa fa-trash"></i> Activar</button>
                            </td>
                        @else
                            <td style="width:5%">
                                <button class="btn btn-xs btn-danger btn-rounded" onclick="desactivarResponsable({{$responsable->idResponsable}}, 0)"><i class="fa fa-trash"></i> Desactivar</button>
                            </td>
                        @endif
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>