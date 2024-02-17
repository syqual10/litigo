<div class="logo-container full-screen-table-demo">
  <div class="logo"><img src="{{ asset('img/litigo-1.png') }}"></div>
</div>
<div class="fresh-table full-screen-table toolbar-color-blue">
  <div class="toolbar">
      <button id="alertBtn" class="btn btn-default" onclick="agregarDependencia();">Agregar una dependencia</button>
  </div>
  
  <table id="fresh-table" class="table tabla-fresh">
    <thead>
      <th style="width:90%" data-sortable="true">Nombre</th>
      <th style="width:5%"></th>
      <th style="width:5%"></th>
    </thead>
    <tbody>
        @if(count($dependencias) > 0)
          @foreach($dependencias as $dependencia)
            <tr>
              <td style="width:90%">{{$dependencia->nombreDependencia}}</td>
              <td style="width:5%">
                  <button class="btn btn-xs btn-primary btn-rounded" onclick="editarDependencia({{$dependencia->idDependencia}})"><i class="fa fa-edit"></i> Editar</button>
              </td>
              <td style="width:5%">
                  <button class="btn btn-xs btn-danger btn-rounded" onclick="eliminarDependencia({{$dependencia->idDependencia}})"><i class="fa fa-trash"></i> Eliminar</button>
              </td>
            </tr>
          @endforeach
        @endif
    </tbody>
  </table>
</div>
