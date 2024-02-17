<div class="logo-container full-screen-table-demo">
    <div class="logo"><img src="{{ asset('img/litigo-1.png') }}"></div>
</div>
<div class="fresh-table full-screen-table toolbar-color-blue">
    <table id="fresh-table" class="table tabla-fresh">
        <thead>
            <tr>
                <th data-sortable="true">Nombre</th>
                <th data-sortable="true">Etapa</th>
                <th data-sortable="true">Fecha aportado</th>
                <th data-sortable="true">Usuario</th>
                <th data-sortable="true"></th>
            </tr>
        </thead>
        <tbody>
            @if(count($expedienteDigital) > 0)
                @foreach($expedienteDigital as $archivo)
                    <tr>
                        @php 
                            $partes = explode("_", $archivo->nombreArchivo);
                            $nombre = substr($archivo->nombreArchivo,strlen($partes[0])+1);
                        @endphp
                        <td style="width:10%">{{$nombre}}</td>
                        <td style="width:30%">{{$archivo->nombreEtapa}}</td>
                        <td style="width:20%">{{ucfirst(utf8_encode(strftime("%A %d de %B de %Y", strtotime($archivo->fechaAportado))))}}</td>
                        <td style="width:30%">{{$archivo->nombresUsuario}}</td>
                        <td style="width:10%">
                            @if($archivo->extensionArchivo == 'pdf')
                                <a style="cursor:pointer; text-decoration:none !important;" onclick="verArchivoPdf({{$archivo->idArchivo}}, {{$vigenciaRadicado}}, {{$idRadicado}});">
                            @else
                                <a style="cursor:pointer; text-decoration:none !important;" href="{{ asset('juridica/descargarArchivo/'.$archivo->idArchivo) }}">
                            @endif
                            <img src="{{ asset("assets/images/".$archivo->extensionArchivo.".png") }}" width="26" style="padding:0; margin-right:8px;">
                            <h5 style="font-size:10px;">
                            {{ $nombre }}
                            </h5>
                            </a>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>