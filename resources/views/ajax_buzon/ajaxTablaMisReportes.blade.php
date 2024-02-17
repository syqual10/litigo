<div class="logo-container full-screen-table-demo">
    <div class="logo"><img src="{{ asset('img/litigo-1.png') }}"></div>
</div>
<div class="fresh-table full-screen-table toolbar-color-blue">    
    <table id="fresh-table" class="table tabla-fresh">
        <thead>
            <tr>
                <th data-sortable="true">Radicado</th>
                <th data-sortable="true">Fecha Radicado</th>
                <th data-sortable="true">Tipo de proceso</th>
                <th data-sortable="true">Código del proceso</th>
                <th data-sortable="true">Fecha de notificación</th>
                <th data-sortable="true">Medio de control</th>
                <th data-sortable="true">Juzgado</th>
            </tr>
        </thead>
        <tbody>
            @if(count($reportes) > 0)
                @foreach($reportes as $reporte)
                    <tr>
                        <td style="width:10%">{{$reporte->vigenciaRadicado."-".$reporte->idRadicado}}</td>
                        <td style="width:10%">{{ucfirst(utf8_encode(strftime("%A %d de %B de %Y", strtotime($reporte->fechaRadicado))))}}</td>
                        <td style="width:20%">{{$reporte->nombreTipoProceso}}</td>
                        @if($reporte->codigoProceso != '')
                            <td style="width:10%">{{$reporte->codigoProceso}}</td>
                        @endif
                        <td style="width:10%">{{ucfirst(utf8_encode(strftime("%A %d de %B de %Y", strtotime($reporte->fechaNotificacion))))}}</td>
                        <td style="width:20%">{{$reporte->nombreMedioControl}}</td>
                        <td style="width:20%">{{$reporte->nombreJuzgado}}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>

<input type="hidden" value="{{$fechaInicialSeleccionada}}" id="fechaInicialSeleccionada">
<input type="hidden" value="{{$fechaFinalSeleccionada}}" id="fechaFinalSeleccionada">