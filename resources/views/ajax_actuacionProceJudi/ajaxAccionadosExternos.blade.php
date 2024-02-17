@if(count($accionadosExt) > 0)
  @foreach($accionadosExt as $accionadoExt)
    <div class="row" style="padding-left:20px">
      <div class="col-sm-12">
        <h1 style="color:#21c2f8">
          <span class="semi-bold">{{$accionadoExt->nombreConvocadoExterno}}</span>
          <br>
          <small>{{$accionadoExt->direccionConvocadoExterno}}</small>
        </h1>
        <ul class="list-unstyled">
          <li>
            <p class="text-muted">
              <i class="fa fa-credit-card"></i>&nbsp;&nbsp;
              <span class="txt-color-darken">TP: {{$accionadoExt->telefonoConvocadoExterno}}</span>
            </p>
          </li>
        </ul>
        @if($responsable == 1)
          <button class="btn btn-xs btn-danger btn-rounded" onclick="removerExt({{$accionadoExt->idInvolucrado}}, {{$tipoInvolucrado}})"><i class="fa fa-trash"></i> Remover</button>

          <button class="btn btn-xs btn-primary btn-rounded" onclick="editarExt({{$accionadoExt->idConvocadoExterno}}, {{$tipoInvolucrado}})"><i class="fa fa-edit"></i> Editar</button>
        @endif
        <hr>
      </div>
    </div>
  @endforeach
@else
  <p class="alert alert-info">
    <i class="fa fa-warning fa-fw fa-2x"></i><strong>Atención!</strong>
    No se encontrarón Accionados externos registrados
  </p>
@endif