<div class="logo-container full-screen-table-demo">
  <div class="logo"><img src="{{ asset('img/litigo-1.png') }}"></div>
</div>
<div class="fresh-table full-screen-table toolbar-color-blue">
  <div class="toolbar">
      <button id="alertBtn" class="btn btn-default" onclick="agregarUsuario();">Agregar un usuario</button>
  </div>
  
  <table id="fresh-table" class="table tabla-fresh">
    <thead>
      <tr>
        <th data-sortable="true">Documento</th>
        <th data-sortable="true">Nombre</th>
        <th data-sortable="true">Cargo</th>
        <th data-sortable="true">Rol</th>
        <th></th>
        <th></th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @if(count($usuarios) > 0)
        @foreach($usuarios as $usuario)
          <tr>
            <td style="width:10%">{{$usuario->documentoUsuario}}</td>
            <td style="width:30%">{{$usuario->nombresUsuario}}</td>
            <td style="width:20%">{{$usuario->nombreCargo}}</td>
            <td style="width:15%">{{$usuario->nombreRol}}</td>
            <td style="width:5%">
                <button class="btn btn-xs btn-primary btn-rounded" onclick="editarUsuario({{$usuario->idUsuario}})"><i class="fa fa-edit"></i> Editar</button>
            </td>
            <td style="width:5%">
                <button class="btn btn-xs btn-danger btn-rounded" onclick="desactivarUsuario({{$usuario->idUsuario}})"><i class="fa fa-trash"></i> Desactivar</button>
            </td>
            <td style="width:5%">
                <button class="btn btn-xs btn-default btn-rounded" onclick="restablecerPassUsuario({{$usuario->idUsuario}}, '{{$usuario->documentoUsuario}}')"><i class="fa fa-unlock-alt"></i> Restablecer contraseña</button>
            </td>
          </tr>
        @endforeach
      @endif
    </tbody>
  </table>
</div>