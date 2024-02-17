<div class="logo-container full-screen-table-demo">
    <div class="logo"><img src="{{ asset('img/litigo-1.png') }}"></div>
</div>
<div class="fresh-table full-screen-table toolbar-color-blue">
    <div class="toolbar">
        @if ($administrar == 1)
            <button id="alertBtn" class="btn btn-default" onclick="cargarValoracionFallo();">Agregar una Valoración</button>    
        @endif
    </div>

    <table id="fresh-table" class="table tabla-fresh table-bordered" style="font-size:0.9em">
        <thead>
            <tr>
                <th>Indicador</th>
                <th>Fallo en contra</th>
                <th>Escala</th>
                <th data-sortable="true">Fecha de la valoración</th>
                <th data-sortable="true">Hora de la valoración</th>
                <th data-sortable="true">Funcionario que valoró</th>
                @if ($administrar == 1)
                    <th data-sortable="true"></th>
                @endif
            </tr>
        </thead>
        <tbody>
            @if(count($valoraciones) > 0)
                @foreach($valoraciones as $valoracion)
                    <tr>
                        <td style="width:5%">
                            <div class="progress-circle" data-progress="{{round($valoracion->puntajeValoracionFallo)}}"></div>
                        </td>
                        <td style="width:15%">
                            @if ($valoracion->puntajeValoracionFallo <= 10)
                                @php
                                    $color = "success";
                                    $titulo = "Baja";
                                    $min = 0;
                                    $max = 10;
                                @endphp
                            @elseif($valoracion->puntajeValoracionFallo >= 11 && $valoracion->puntajeValoracionFallo <= 50)
                                @php
                                    $color = "warning";
                                    $titulo = "Media";
                                    $min = 11;
                                    $max = 50;
                                @endphp
                            @elseif($valoracion->puntajeValoracionFallo >= 51 && $valoracion->puntajeValoracionFallo <= 100)
                                @php
                                    $color = "danger";
                                    $titulo = "Alta";
                                    $min = 51;
                                    $max = 100;
                                @endphp
                            @endif
                            <div class="alert alert-{{$color}} alert-block">
                                <a class="close" data-dismiss="alert" href="#"></a>
                                <h6 class="alert-heading" style="font-size:0.9em">Probabilidad {{$titulo}}</h6>
                            </div>
                        </td>
                        <td style="width:10%">
                            <strong>Entre <br> {{$min}}% y {{$max}}%</strong>
                        </td>
                        <td style="width:20%">
                            <strong>
                                <i class="fa fa-calendar"></i> {{ucfirst(utf8_encode(strftime("%A %d de %B de %Y", strtotime($valoracion->fechaValoracionFallo))))}}
                            </strong>
                        </td>
                        <td style="width:15%">
                            <i class="fa fa-clock"></i> {{ date('h:i A', strtotime($valoracion->fechaValoracionFallo))}} 
                        </td>
                        <td style="width:30%">
                            <i class="fa fa-user"></i> {{$valoracion->nombresUsuario}}
                        </td>
                        @if ($administrar == 1)
                            <td style="width:5%">
                                <button class="btn btn-xs btn-danger btn-rounded" onclick="pdfValoracion({{$valoracion->idValoracionFallo}})" style="width:103.2px;margin-bottom:8px"><i class="fa fa-file-pdf-o"></i> PDF</button>
                                <button class="btn btn-xs btn-primary btn-rounded" onclick="editarValoracion({{$valoracion->idValoracionFallo}})" style="width:103.2px;margin-bottom:8px"> <i class="fa fa-edit"></i> Editar</button>                            
                                <button class="btn btn-xs btn-primary btn-rounded" onclick="eliminarValoracion({{$valoracion->idValoracionFallo}})" style="width:103.2px;margin-bottom:8px"><i class="fa fa-trash"></i> Eliminar</button>
                            </td>
                        @endif
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>