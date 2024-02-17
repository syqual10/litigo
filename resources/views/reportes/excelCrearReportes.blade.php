@php
  	use SQ10\helpers\Util as Util;
@endphp

<html>
	<head>
	  <title>Reporte Radicados </title>
	  <span>{{ucfirst(utf8_encode(strftime("%d de %B de %Y", strtotime($fechaReporte))))}}</span>
	  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	</head>

	<body>
	  	<table>
	      	<tr>
	      		<!--<td rowspan="2"><img src="../public/documentos/entidad/logo.png" width="100"/></td>    -->
	      	</tr>
	  	</table>
	  	<br> 

		<style type="text/css">
		.tg  {border-collapse:collapse;border-spacing:0;}
		.tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
		.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
		.tg .tg-yw4l{vertical-align:top}
		</style>

		<!-- 
			1 Número Interno del sistema
			2 Fecha Radicado
			3 Estado Radicado
			4 Código Proceso
			5 Radicado del juzgado
			6 Tipo de proceso
			7 Medio de control
			8 Apoderado
			9 Dependencia afectada
			10 Juzgado
			11 Demandantes
			12 Tema
			13 Cuantías
			14 Último estado
			15 Sentido del fallo 1 instancia
			16 Fecha sentencia 1 instancia
			17 Sentido del fallo 2 instancia
			18 Fecha sentencia 2 instancia
		-->

	    @if(count($reportes) > 0)
	      	<table>                     
		        <tr>
					@foreach ($columnas as $columna)
						@if ($columna == 1)
							<th width="30" style="background-color:#059f71; color:#FFF; text-align:center;">Número Interno del sistema</th>						
						@endif
						@if ($columna == 2)
							<th width="30" style="background-color:#059f71; color:#FFF; text-align:center;">Fecha Radicado</th>
						@endif
						@if ($columna == 3)
							<th width="30" style="background-color:#059f71; color:#FFF; text-align:center;">Estado Radicado</th>
						@endif
						@if ($columna == 4)
							<th width="30" style="background-color:#059f71; color:#FFF; text-align:center;">Código Proceso</th>
						@endif
						@if ($columna == 5)
							<th width="30" style="background-color:#059f71; color:#FFF; text-align:center;">Radicado del juzgado</th>
						@endif
						@if ($columna == 6)
							<th width="30" style="background-color:#059f71; color:#FFF; text-align:center;">Tipo de proceso</th>
						@endif
						@if ($columna == 7)
							<th width="30" style="background-color:#059f71; color:#FFF; text-align:center;">Medio de control</th>
						@endif
						@if ($columna == 8)
							<th width="30" style="background-color:#059f71; color:#FFF; text-align:center;">Apoderado</th>
						@endif
						@if ($columna == 9)
							<th width="30" style="background-color:#059f71; color:#FFF; text-align:center;">Dependencia afectada</th>
						@endif
						@if ($columna == 10)
							<th width="40" style="background-color:#059f71; color:#FFF; text-align:center;">Juzgado</th>
						@endif
						@if ($columna == 11)
							<th width="150" style="background-color:#059f71; color:#FFF; text-align:center;">Demandantes</th>
						@endif
						@if ($columna == 20)
							<th width="150" style="background-color:#059f71; color:#FFF; text-align:center;">Demandantes con Cedula</th>
						@endif
						@if ($columna == 12)
							<th width="40" style="background-color:#059f71; color:#FFF; text-align:center;">Tema</th>
						@endif
						@if ($columna == 13)
							<th width="40" style="background-color:#059f71; color:#FFF; text-align:center;">Cuantías</th>
						@endif
						@if ($columna == 14)
							<th width="40" style="background-color:#059f71; color:#FFF; text-align:center;">Último estado</th>
						@endif
						@if ($columna == 15)
							<th width="40" style="background-color:#059f71; color:#FFF; text-align:center;">Sentido del fallo 1 instancia</th>
						@endif
						@if ($columna == 16)
							<th width="40" style="background-color:#059f71; color:#FFF; text-align:center;">Fecha sentencia 1 instancia</th>
						@endif
						@if ($columna == 17)
							<th width="40" style="background-color:#059f71; color:#FFF; text-align:center;">Sentido del fallo 2 instancia</th>
						@endif
						@if ($columna == 18)
							<th width="40" style="background-color:#059f71; color:#FFF; text-align:center;">Fecha sentencia 2 instancia</th>
						@endif
						@if ($columna == 19)
							<th width="40" style="background-color:#059f71; color:#FFF; text-align:center;">Asunto</th>
						@endif
					@endforeach
		        </tr>
				@foreach($reportes as $reporte)
					<tr>	
						@if (in_array(15, $columnas) || in_array(16, $columnas) || in_array(17, $columnas) || in_array(18, $columnas))
							@php
								$sentidos = Util::sentidoFallo($reporte->vigenciaRadicado, $reporte->idRadicado);
							@endphp
						@endif	
						

						@foreach ($columnas as $columna)
							@if ($columna == 1)				
								<td>{{$reporte->vigenciaRadicado."-".$reporte->idRadicado}}</td>
							@endif
							@if ($columna == 2)
								<td>{{date("d/m/Y", strtotime($reporte->fechaRadicado))}}</td>
							@endif
							@if ($columna == 3)
								<td>{{$reporte->nombreEstadoRadicado}}</td>
							@endif
							@if ($columna == 4)
								<td>#{{$reporte->codigoProceso}}</td>							
							@endif
							@if ($columna == 5)
								<td>{{$reporte->radicadoJuzgado}}</td>							
							@endif
							@if ($columna == 6)
								<td>{{$reporte->nombreTipoProceso}}</td>							
							@endif
							@if ($columna == 7)
								<td>{{$reporte->nombreMedioControl}}</td>
							@endif
							@if ($columna == 8)
								@php
									$apoderados = Util::apoderadosRadicado($reporte->vigenciaRadicado, $reporte->idRadicado);
								@endphp
								<td>
									@if(count($apoderados) > 0)
										{{$apoderados[count($apoderados)-1]->nombresUsuario}}
									@endif
								</td>
							@endif
							@if ($columna == 9)
								@php
									$dependenciaAfectada = Util::dependenciaDemandada($reporte->vigenciaRadicado, $reporte->idRadicado, $reporte->idTipoProcesos);
								@endphp
								<td>{{$dependenciaAfectada}}</td>
							@endif
							@if ($columna == 10)
								<td>{{$reporte->nombreJuzgado}} </td>
							@endif
							@if ($columna == 11)
								@php
									$personaDemandante = Util::personaDemandanteSoloNombre($reporte->vigenciaRadicado, $reporte->idRadicado, $reporte->idTipoProcesos);
								@endphp
								<td>{{$personaDemandante}}</td>
							@endif
							@if ($columna == 20)
								@php
									$personaDemandanteCedula = Util::personaDemandante($reporte->vigenciaRadicado, $reporte->idRadicado, $reporte->idTipoProcesos);
								@endphp
								<td>{{$personaDemandanteCedula}}</td>
							@endif
							@if ($columna == 12)
								<td>{{$reporte->nombreTema}}</td>
							@endif
							@if ($columna == 13)
								@php
									$cuantia = Util::cuantiasRadicado($reporte->vigenciaRadicado, $reporte->idRadicado);
								@endphp
								<td>{{$cuantia}}</td>
							@endif
							@if ($columna == 14)
								@php
									$estado = Util::estadoActuacion($reporte->vigenciaRadicado, $reporte->idRadicado);
								@endphp
								<td>{{$estado}}</td>
							@endif
							@if ($columna == 15)								
								<td>
									@if(count($sentidos) > 0)
										{{$sentidos[0]->nombreTipoFallo}}
									@endif
								</td>
							@endif
							@if ($columna == 16)
								<td>
									@if(count($sentidos) > 0)
									{{date("d/m/Y", strtotime($sentidos[0]->fechaActuacion))}}
									@endif
								</td>
							@endif
							@if ($columna == 17)
								<td>
									@if(count($sentidos) > 0)
										{{$sentidos[1]->nombreTipoFallo}}
									@endif
								</td>
							@endif
							@if ($columna == 18)
								<td>
									@if(count($sentidos) > 0)
										{{date("d/m/Y", strtotime($sentidos[1]->fechaActuacion))}}
									@endif
								</td>
							@endif
							@if ($columna == 19)
								<td>
									{{$reporte->asunto}}
								</td>
							@endif
						@endforeach
					</tr>
				@endforeach
	      	</table>
		@else
			No se encontraron registros que cumplan con el criterio de búsqueda
	    @endif
	</body>
</html>