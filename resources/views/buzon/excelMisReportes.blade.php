@php
  use SQ10\helpers\Util as Util;
@endphp

<html>
	<head>
	  <title>Reporte Radicados</title>
	  <span>{{ucfirst(utf8_encode(strftime("%d de %B de %Y", strtotime($fechaReporte))))}}</span>
	  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	</head>

	<body>

		<style type="text/css">
		.tg  {border-collapse:collapse;border-spacing:0;}
		.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
		.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
		.tg .tg-yw4l{vertical-align:top}
		</style>

	    @if(count($reportes) > 0)
	      	<table>                       
		        <tr>
			      	<th width="30" style="background-color:#05529F; color:#FFF; text-align:center;">Radicado</th>
			      	<th width="30" style="background-color:#05529F; color:#FFF; text-align:center;">Fecha Radicado</th>
			      	<th width="30" style="background-color:#05529F; color:#FFF; text-align:center;">Tipo de proceso</th>
			      	<th width="30" style="background-color:#05529F; color:#FFF; text-align:center;">Código del proceso</th>
			      	<th width="40" style="background-color:#05529F; color:#FFF; text-align:center;">Fecha de notificación</th>
			      	<th width="30" style="background-color:#05529F; color:#FFF; text-align:center;">Medio de control</th>
			      	<th width="40" style="background-color:#05529F; color:#FFF; text-align:center;">Juzgado</th>
		        </tr>
		        @foreach($reportes as $reporte)
			      	<tr>
				        <td>{{$reporte->vigenciaRadicado."-".$reporte->idRadicado}}</td>
	                    <td>{{ucfirst(utf8_encode(strftime("%A %d de %B de %Y", strtotime($reporte->fechaRadicado))))}}</td>
	                    <td>{{$reporte->nombreTipoProceso}}</td>
	                    @if($reporte->codigoProceso != '')
	                    	<td>{{$reporte->codigoProceso}}</td>
	                    @endif
	                    <td>{{ucfirst(utf8_encode(strftime("%A %d de %B de %Y", strtotime($reporte->fechaNotificacion))))}}</td>
	                    <td>{{$reporte->nombreMedioControl}}</td>
	                    <td>{{$reporte->nombreJuzgado}}</td>
			      	</tr>
		        @endforeach
	      	</table>
	    @endif
	</body>
</html>