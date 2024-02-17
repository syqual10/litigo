@if(count($abogados) > 0)
  @foreach($abogados as $abogado)
    <div class="row" style="padding-left:20px">
      <div class="col-sm-12">
        <h1 style="color:#21c2f8">
          <span class="semi-bold">{{$abogado->nombreAbogado}}</span>
          <br>
          <small>{{$abogado->nombreTipoIdentificacion." ".$abogado->documentoAbogado}}</small>
        </h1>
        <ul class="list-unstyled">
          <li>
            <p class="text-muted">
              <i class="fa fa-credit-card"></i>&nbsp;&nbsp;
              <span class="txt-color-darken">TP: {{$abogado->tarjetaAbogado}}</span>
            </p>
          </li>
        </ul>
        @if($responsable == 1)
          <button class="btn btn-xs btn-danger btn-rounded" onclick="removerAbogadoExt({{$abogado->idInvolucrado}}, 2)"><i class="fa fa-trash"></i> Remover</button>

          <button class="btn btn-xs btn-primary btn-rounded" onclick="editarAbogadoExt({{$abogado->idAbogado}}, 2)"><i class="fa fa-edit"></i> Editar</button>
        @endif
        <hr>
      </div>
    </div>
  @endforeach
@else
  <p class="alert alert-info">
    <i class="fa fa-warning fa-fw fa-2x"></i><strong>Atención!</strong>
    No se encontrarón abogados apoderados registrados
  </p>
@endif