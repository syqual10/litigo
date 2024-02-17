@if(count($accionadosInt) > 0)
  @foreach($accionadosInt as $accionadoInt)
    <div class="row" style="padding-left:20px">
      <div class="col-sm-12">
        <h1 style="color:#21c2f8">
          <span class="semi-bold">{{$accionadoInt->nombreDependencia}}</span>
          <br>
          <small>Dependencia involucrada</small>
        </h1>
        @if($responsable == 1)
          <button class="btn btn-xs btn-danger btn-rounded" onclick="removerAccionadoInt({{$accionadoInt->idInvolucrado}})"><i class="fa fa-trash"></i> Remover</button>
        @endif
        <hr>
      </div>
    </div>
  @endforeach
@else
  <p class="alert alert-info">
    <i class="fa fa-warning fa-fw fa-2x"></i><strong>Atención!</strong>
    No se encontraron accionados internos afectados
  </p>
@endif