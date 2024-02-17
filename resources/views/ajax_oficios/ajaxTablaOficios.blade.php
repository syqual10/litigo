<div class="logo-container full-screen-table-demo">
    <div class="logo"><img src="{{ asset('img/litigo-1.png') }}"></div>
</div>
<div class="fresh-table full-screen-table toolbar-color-blue">
    <div class="toolbar">
        <button id="alertBtn" class="btn btn-default" onclick="agregarOficio();">Agregar Oficio</button>
    </div>
    
    <table id="fresh-table" class="table tabla-fresh">
        <thead>
            <tr>
                <th data-sortable="true">Consecutivo</th>
                <th data-sortable="true">Usuario que genera el oficio</th>
                <th data-sortable="true">Fecha</th>
                <th data-sortable="true">Destinatario</th>
                <th data-sortable="true">Asunto</th>
                <th data-sortable="true">Dirección</th>
                <th data-sortable="true">Arco</th>
            </tr>
        </thead>
        <tbody>
	        @if(count($oficios) > 0)
	            @foreach($oficios as $oficio)
	                <tr>
	                    <td style="width:10%">{{$oficio->siglasOficio."-".$oficio->idConsecutivoOficio."-".$oficio->vigenciaOficio}}</td>
	                    <td style="width:15%">{{$oficio->nombresUsuario}}</td>
	                    <td style="width:15%">{{ucfirst(utf8_encode(strftime("%A %d de %B de %Y", strtotime($oficio->fechaOficio))))}}</td>
	                    <td style="width:15%">{{$oficio->nombrePersona}}</td>
	                    <td style="width:20%">{{$oficio->asuntoOficio}}</td>
	                    <td style="width:15%">{{$oficio->direccionPersona}}</td>
	                    <td style="width:10%">
                            @if($oficio->arco !='')
                                {{$oficio->arco}}
                            @else
                                <button class="btn btn-xs btn-primary btn-rounded" onclick="radicarArco({{$oficio->idConsecutivoOficio}}, '{{$oficio->vigenciaOficio}}', '{{$oficio->nombrePersona}}', '{{$oficio->direccionPersona}}', {{$oficio->ciudades_idCiudad}})"><i class="fa fa-edit"></i> Radicar Arco</button>
                            @endif
                        </td>
	                </tr>
	            @endforeach
	        @endif
        </tbody>
    </table>
</div>