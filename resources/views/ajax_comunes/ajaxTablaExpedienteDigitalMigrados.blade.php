<div style="padding:18px">
    <style>
        table, td{
            font:100% Arial, Helvetica, sans-serif; 
        }
        table{width:100%;border-collapse:collapse;margin:1em 0;}
        th, td{text-align:left;padding:.5em;border:1px solid #fff;}
        th{background:#328aa4  repeat-x;color:#fff;}
        td{background:#e5f1f4;}
        tr.even td{background:#e5f1f4;}
        tr.odd td{background:#f8fbfc;}
        th.over, tr.even th.over, tr.odd th.over{background:#4a98af;}
        th.down, tr.even th.down, tr.odd th.down{background:#bce774;}
        th.selected, tr.even th.selected, tr.odd th.selected{}
        td.over, tr.even td.over, tr.odd td.over{background:#ecfbd4;}
        td.down, tr.even td.down, tr.odd td.down{background:#bce774;color:#fff;}
        td.selected, tr.even td.selected, tr.odd td.selected{background:#bce774;color:#555;}
        td.empty, tr.odd td.empty, tr.even td.empty{background:#fff;}
    </style>
    <table class="table no-footer" cellspacing="0" cellpadding="0">	
        <thead>
            <tr>
                <th style="width:10%">Consecutivo</th>
                <th style="width:60%">Nombre del Archivo</th>
                <th style="width:20%">Fecha aportado</th>
                <th style="width:10%"></th>
            </tr>
        </thead>
        <tbody>
            @if(count($expedienteDigitalMigrado) > 0)
                @foreach($expedienteDigitalMigrado as $archivo)
                    <tr>
                        <td style="width:10%">{{$archivo->consecutivo}}</td>
                        <td style="width:10%"><strong>{{$archivo->nombreArchivo}}</strong></td>
                        <td style="width:20%">{{ucfirst(utf8_encode(strftime("%A %d de %B de %Y", strtotime($archivo->fechaRegistro))))}}</td>

                        <td style="width:10%">
                            @php
                                $extension = preg_match('/\./', $archivo->nombreArchivo) ? preg_replace('/^.*\./', '', $archivo->nombreArchivo) : '';
                            @endphp

                            @if($extension == 'pdf')
                                <a class="btn btn-xs btn-danger btn-rounded" style="cursor:pointer; text-decoration:none !important;" onclick="verArchivoPdfMigrado('{{$archivo->id}}');">
                                    <i class="fa fa-eye"></i> Ver Archivo PDF 
                            @else
                                <a class="btn btn-xs btn-danger btn-rounded" style="cursor:pointer; text-decoration:none !important;" href="{{ asset('juridica/descargarArchivoMigrado/'.$archivo->id) }}">
                                    <i class="fa fa-download"></i> Descargar Archivo
                            @endif
                            <!--<img src=" asset("assets/images/".$archivo->extensionArchivo.".png") }}" width="26" style="padding:0; margin-right:8px;">-->
                            </a>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>