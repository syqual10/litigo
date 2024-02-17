@if(count($cuantias) > 0)
  <div style="margin:20px 12px 0 2px;float:left; width:100%; box-shadow:0 0 3px #aaa; height:auto;color:#666;">
    <div style="width:100%; padding:3px; float:left; background:#1ca8dd; color:#fff; font-size:20px; text-align:center;">
      Resúmen económico de la demanda
    </div>
    <div style="width:100%; padding:0px; float:left;">
      <div style="width:100%;float:left;background:#efefef;">
        <span style="float:left; text-align:left;padding:10px;width:30%;color:#888;font-weight:600;">
          Unidad monetaria
        </span>
        <span style="font-weight:600;float:left;padding:10px ;width:30%;color:#888;text-align:right;">
          Valor unidad monetaria
        </span>
        <span style="font-weight:600;float:left;padding:10px ;width:30%;color:#888;text-align:right;">
          Valor en pesos
        </span>
      </div>

      <div style="width:100%;float:left;">
        @php
          $total=0;
        @endphp
        @foreach($cuantias as $cuantia)
          <span style="float:left; text-align:left;padding:10px;width:30%;color:#888;">
            @if($cuantia->unidadMonetaria == 1)
              @if($responsable->permiso == 1)
                <button class="btn btn-xs btn-primary btn-rounded" onclick="removerCuantia({{$cuantia->idCuantia}})"><i class="fa fa-trash"></i> Remover</button>
              @endif
              Salarios
            @else
              @if($responsable->permiso == 1)
                <button class="btn btn-xs btn-primary btn-rounded" onclick="removerCuantia({{$cuantia->idCuantia}})"><i class="fa fa-trash"></i> Remover</button>
              @endif
              En pesos
            @endif
          </span>
          @if($cuantia->unidadMonetaria == 1)
            <span style="font-weight:normal;float:left;padding:10px ;width:30%;color:#888;text-align:right;">
              {{$cuantia->valor}}
            </span>
          @else
            <span style="font-weight:normal;float:left;padding:10px ;width:30%;color:#888;text-align:right;">
              $ {{$cuantia->valor}}
            </span>
          @endif
          <span style="font-weight:normal;float:left;padding:10px ;width:30%;color:#888;text-align:right;">
            $ {{number_format((float)$cuantia->valorPesos), 0, ',', '.'}}
          </span>
          @php
            $total += $cuantia->valorPesos;
          @endphp
        @endforeach
      </div>
      <div style="width:100%;float:left; background:#fff;">
        <span style="font-weight:600;float:right;padding:10px 0px;width:40%;color:#666;text-align:center;">
          Total : $ {{number_format((float)$total), 0, ',', '.'}}
        </span>
      </div>
    </div>
  </div>
@else
  <p class="alert alert-info">
    <i class="fa fa-warning fa-fw fa-2x"></i><strong>Atención!</strong>
    No se encontrarón cuantías registradas
  </p>
@endif