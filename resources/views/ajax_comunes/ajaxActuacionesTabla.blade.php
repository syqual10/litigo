<div class="logo-container full-screen-table-demo">
    <div class="logo"><img src="{{ asset('img/litigo-1.png') }}"></div>
</div>
<div class="fresh-table full-screen-table toolbar-color-blue">
    <table id="fresh-table" class="table tabla-fresh">
        <thead>
            <tr>
                <th data-sortable="true">Fecha de la actuación</th>
                <th data-sortable="true">Actuación</th>
                <th data-sortable="true">Usuario</th>
                <th data-sortable="true">Sentido del fallo</th>
                <th data-sortable="true">Observación</th>
            </tr>
        </thead>
        <tbody>
            @if(count($actuacionesEtapa) > 0)
                @foreach($actuacionesEtapa as $actuacion)
                    @php
                        $sentido = DB::table('jurifalloradicado')
                            ->join('juritiposfallos', 'jurifalloradicado.juritiposfallos_idTipoFallo', '=', 'juritiposfallos.idTipoFallo')
                            ->where('juriactuaciones_idActuacion', '=', $actuacion->idActuacion)
                            ->where('jurifalloradicado.activo','=', 1)
                            ->get();
                    @endphp
                    <tr>
                        <td style="width:20%">
                            {{ucfirst(utf8_encode(strftime("%A %d de %B de %Y", strtotime($actuacion->fechaActuacion))))}}
                        </td>
                        <td style="width:20%">{{$actuacion->nombreActuacion}}</td>
                        <td style="width:20%">{{$actuacion->nombresUsuario}}</td>
                        <td style="width:20%">
                            @if(count($sentido) > 0)
                                {{$sentido[0]->nombreTipoFallo}}
                            @endif
                        </td>
                        <td style="width:20%">{{$actuacion->comentarioActuacion}}</td>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>