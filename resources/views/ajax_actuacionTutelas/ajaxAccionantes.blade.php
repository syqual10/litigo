@if(count($accionantes) > 0)
  @foreach($accionantes as $accionante)
    <div class="row" style="padding-left:20px">
      <div class="col-sm-12">
        <h1 style="color:#21c2f8">
          <span class="semi-bold">{{$accionante->nombreSolicitante}}</span>
          <br>
          <small>{{$accionante->nombreTipoIdentificacion." ".$accionante->documentoSolicitante}}
          </small>
        </h1>
        <ul class="list-unstyled">
          <li>
            <p class="text-muted">
              <i class="fa fa-map-marker"></i>&nbsp;&nbsp;
              <span class="txt-color-darken">{{$accionante->direccionSolicitante}}</span>
            </p>
          </li>
          <li>
            <p class="text-muted">
              <i class="fa fa-phone"></i>&nbsp;&nbsp;
              <span class="txt-color-darken">
                <span class="text-muted">{{$accionante->telefonoSolicitante}}</span>
              </span>
            </p>
          </li>
          <li>
            <p class="text-muted">
              <i class="fa fa-mobile-phone"></i>&nbsp;&nbsp;
              <span class="txt-color-darken">{{$accionante->celularSolicitante}}</span>
            </p>
          </li>
          <li>
            <p class="text-muted">
              <i class="fa fa-envelope"></i>&nbsp;&nbsp;
              <a href="#">{{$accionante->correoSolicitante}}</a>
            </p>
          </li>
        </ul>
        @if($responsable == 1)
          <button class="btn btn-xs btn-danger btn-rounded" onclick="removerAccionante({{$accionante->idInvolucrado}})"><i class="fa fa-trash"></i> Remover</button>

          <button class="btn btn-xs btn-primary btn-rounded" onclick="editarAccionante({{$accionante->idSolicitante}})"><i class="fa fa-edit"></i> Editar</button>
        @endif
        <hr>
      </div>
    </div>
  @endforeach
@else
  <p class="alert alert-info">
  <i class="fa fa-warning fa-fw fa-2x"></i><strong>Atención!</strong>
  No se encontrarón accionantes registrados
  </p>
@endif