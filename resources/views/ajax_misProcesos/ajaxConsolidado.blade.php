@php
  use SQ10\helpers\Util as Util;
@endphp
@if(count($tiposProceso) > 0)
  <div class="invoice">
    <table border="0" cellspacing="0" cellpadding="0">
      <thead>
        <tr>
          <th class="text-left">PROCESOS A CARGO</th>
          <th class="text-right">PROCESOS ACTIVOS</th>
          <th class="text-center">VALOR CUANTÍAS ACTIVOS</th>
          <th class="text-right">PROCESOS FINALIZADOS</th>
        </tr>
      </thead>
      <tbody>
        @php
          $contIni  = 0;
          $contFini = 0;
        @endphp
        @foreach($tiposProceso as $tipoProceso)
          <tr>
            <td class="text-left">
              <h3>{{$tipoProceso->nombreTipoProceso}}</h3>
            </td>
            <td class="unit">
              @if(Util::cantidadTipoProceso($tipoProceso->idTipoProcesos, $idResponsable) > 0)
                <a href="#" onclick="tablaProcesosConsolidado('{{$tipoProceso->idTipoProcesos}}', '{{$idResponsable}}')" class="activos">{{Util::cantidadTipoProceso($tipoProceso->idTipoProcesos, $idResponsable)}}</a>
              @else
                <a href="#" class="activos">0</a>
              @endif
            </td>
            <td class="text-center qty">$ {{number_format((float)Util::valorTipoProceso($tipoProceso->idTipoProcesos, $idResponsable), 0, ',', '.')}}</td>
            <td class="total"><a href="#" class="finalizados">{{Util::cantidadTipoProcesoFini($tipoProceso->idTipoProcesos, $idResponsable)}}</a></td>
          </tr>
          @php
            $contIni  = $contIni  + Util::cantidadTipoProceso($tipoProceso->idTipoProcesos, $idResponsable);
            $contFini = $contFini + Util::cantidadTipoProcesoFini($tipoProceso->idTipoProcesos, $idResponsable);
          @endphp
        @endforeach
    </tbody>
    <tfoot>
      <tr>
        <td colspan="2"></td>
        <td colspan="2">ACTIVOS</td>
        <td>{{$contIni}}</td>
      </tr>
      <tr>
        <td colspan="2"></td>
        <td colspan="2">FINALIZADOS</td>
        <td>{{$contFini}}</td>
      </tr>
      <tr>
        <td colspan="2"></td>
        <td colspan="2">TOTAL</td>
        @php
          $total = $contIni +  $contFini;
        @endphp
        <td>{{$total}}</td>
      </tr>
    </tfoot>
  </table>
</div>
@endif
