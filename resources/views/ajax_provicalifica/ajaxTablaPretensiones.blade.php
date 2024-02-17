@if(count($calificaciones) > 0)
    <div class="dtt">
        <table  class="display projects-table table table-striped table-bordered table-hover dataTable no-footer">
            <thead>
                <tr>
                    <th>Fecha de actualización</th>
                    <th>Criterio 1</th>
                    <th>Criterio 2</th>
                    <th>Criterio 3</th>
                    <th>Criterio 4</th>
                    <th>Probabilidad de condena según abogado</th>
                    <th>Probabilidad de perder el caso</th>
                    <th>Registro de pretensión</th>
                    <th>Provisión Contable</th>
                </tr>
            </thead>            
            <tbody>
                @foreach($calificaciones as $calificacion)
                    <tr>
                        <td width="11%">{{ucfirst(utf8_encode(strftime("%A %d de %B de %Y", strtotime($calificacion->fechaActualizacion))))}}</td>
                        <td width="11%">{{$calificacion->criterio1}}</td>
                        <td width="11%">{{$calificacion->criterio2}}</td>
                        <td width="11%">{{$calificacion->criterio3}}</td>
                        <td width="11%">{{$calificacion->criterio4}}</td>
                        <td width="11%">% {{$calificacion->probabilidadCondena}}</td>
                        <td width="11%">{{$calificacion->nombrePerderCaso}}</td>
                        <td width="11%">{{$calificacion->nombreRegistroPretension}}</td>
                        <td width="11%">$ {{number_format((float)$calificacion->provisionContable, 0, ',', '.')}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <p class="alert alert-info">
    <i class="fa fa-warning fa-fw fa-2x"></i><strong>Atención!</strong>
    No se encontrarón causas registradas
    </p>
@endif