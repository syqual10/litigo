@php
  use SQ10\helpers\Util as Util;
@endphp

<html>
	<head>
	  <title>Reporte Radicados xxxx</title>
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

	    @if(count($reportes) > 0)
	      	<table>                       
		        <tr>
		          
			      	<th width="30" style="background-color:#05529F; color:#FFF; text-align:center;">Número Interno del sistema</th>
			      	<th width="30" style="background-color:#05529F; color:#FFF; text-align:center;">Fecha Radicado</th>
			      	<th width="30" style="background-color:#05529F; color:#FFF; text-align:center;">Estado Radicado</th>
			      	<th width="30" style="background-color:#05529F; color:#FFF; text-align:center;">Código Proceso</th>
			      	<th width="30" style="background-color:#05529F; color:#FFF; text-align:center;">Radicado del juzgado</th>
			      	<th width="30" style="background-color:#05529F; color:#FFF; text-align:center;">Tipo de proceso</th>
			      	<th width="30" style="background-color:#05529F; color:#FFF; text-align:center;">Medio de control</th>
			      	<th width="30" style="background-color:#05529F; color:#FFF; text-align:center;">Apoderado</th>
			      	<th width="30" style="background-color:#05529F; color:#FFF; text-align:center;">Dependencia afectada</th>
			      	<th width="40" style="background-color:#05529F; color:#FFF; text-align:center;">Juzgado</th>
			      	<th width="40" style="background-color:#05529F; color:#FFF; text-align:center;">Demandantes</th>
			      	<th width="40" style="background-color:#05529F; color:#FFF; text-align:center;">Tema</th>
			      	<th width="40" style="background-color:#05529F; color:#FFF; text-align:center;">Cuantías</th>
			      	<th width="40" style="background-color:#05529F; color:#FFF; text-align:center;">Último estado</th>
			      	<th width="40" style="background-color:#05529F; color:#FFF; text-align:center;">Sentido del fallo 1 instancia</th>
			      	<th width="40" style="background-color:#05529F; color:#FFF; text-align:center;">Fecha sentencia 1 instancia</th>
			      	<th width="40" style="background-color:#05529F; color:#FFF; text-align:center;">Sentido del fallo 2 instancia</th>
	                <th width="40" style="background-color:#05529F; color:#FFF; text-align:center;">Fecha sentencia 2 instancia</th>
	                 <th width="40" style="background-color:#05529F; color:#FFF; text-align:center;">Entidades Externas</th
	                 <th width="40" style="background-color:#05529F; color:#FFF; text-align:center;">Valor</th>
	                <th width="40" style="background-color:#05529F; color:#FFF; text-align:center;">Probabilidad</th>
		        </tr>
		        @foreach($reportes as $reporte)
			      	<tr>
			      	    @php
							$apoderados = Util::apoderadosRadicado($reporte->vigenciaRadicado, $reporte->idRadicado);

							$dependenciaAfectada = Util::dependenciaDemandada($reporte->vigenciaRadicado, $reporte->idRadicado, $reporte->idTipoProcesos);

							$personaDemandante = Util::personaDemandante($reporte->vigenciaRadicado, $reporte->idRadicado, $reporte->idTipoProcesos);

							$cuantia = Util::cuantiasRadicado($reporte->vigenciaRadicado, $reporte->idRadicado);

							$estado = Util::estadoActuacion($reporte->vigenciaRadicado, $reporte->idRadicado);

							$sentidos = Util::sentidoFallo($reporte->vigenciaRadicado, $reporte->idRadicado);
						@endphp

			        	<td>{{$reporte->vigenciaRadicado."-".$reporte->idRadicado}}</td>
						<td>{{date("d/m/Y h:i A", strtotime($reporte->fechaRadicado));}}</td>
			        	<td>{{$reporte->nombreEstadoRadicado}}</td>
			        	<td>#{{$reporte->codigoProceso}}</td>
			        	<td>{{$reporte->radicadoJuzgado}}</td>
			        	<td>{{$reporte->nombreTipoProceso}}</td>
			        	<td>{{$reporte->nombreMedioControl}}</td>
			        	<td>
							@if(count($apoderados) > 0)
								{{$apoderados[count($apoderados)-1]->nombresUsuario}}
							@endif
						</td>
						<td>
							{{$dependenciaAfectada}}
						</td>
						
						<td>{{$reporte->nombreJuzgado}} </td>
						<td>
                        	{{$personaDemandante}}
                        </td>
                        <td>{{$reporte->nombreTema}}</td>
                        <td>{{$cuantia}}</td>
                        <td>{{$estado}}</td>
                        
                        @if(count($sentidos) > 0)
	                        <td>{{$sentidos[0]->nombreTipoFallo}}</td>
							<td>{{date("d/m/Y", strtotime($sentidos[0]->fechaActuacion));}}</td>
				      	@else
				      	    <td></td>
				      	    <td></td>
                        @endif

                        @if(count($sentidos) > 1)
	                        <td>{{$sentidos[1]->nombreTipoFallo}}</td>
							<td>{{date("d/m/Y", strtotime($sentidos[1]->fechaActuacion));}}</td>
                        @else

				      	    <td></td>
				      	    <td></td>


                        @endif

                         @php
                           $valoracion  = DB::table('valoracion')->where('consecutivo', $reporte->mzlConsecutivo)
                                             ->sum('valor');

                            $probabilidad = '';                 

                            if($valoracion >= 1 && $valoracion <= 10 )
                            {
                                $probabilidad = 'Baja';
                            }         
                            else if($valoracion >= 11 && $valoracion <= 50 )
                            {
                                $probabilidad = 'Media';
                            }
                            else if($valoracion >= 51 && $valoracion <= 100 )
                            {
                                $probabilidad = 'Alta';
                            }  


                            $accionados  = DB::table('juriinvolucrados')
                                        ->select('nombreConvocadoExterno')
                                        ->join('juriconvocadosexternos', 'juriinvolucrados.juriconvocadosexternos_idConvocadoExterno', '=', 'juriconvocadosexternos.idConvocadoExterno')
                                       ->where('juriradicados_vigenciaRadicado', '=', $reporte->vigenciaRadicado)
                                       ->where('juriradicados_idRadicado', '=', $reporte->idRadicado)
                                       ->where('juritipoinvolucrados_idTipoInvolucrado', '=', 6)
                                       ->get();

                                     


	

                        @endphp

                            <td>
                            	@if(count($accionados)>0)
                                  @foreach($accionados as $item)
                                      {{ $item->nombreConvocadoExterno."  "  }}
                                  @endforeach
                            	@endif
                            </td>

	                        <td>
	                           @if($valoracion != 0)
	                               {{$valoracion}}
	                           @endif
	                        </td>
	                        <td>{{$probabilidad}}</td>
	                      
			      	</tr>
		        @endforeach
	      	</table>
	    @endif
	</body>
</html>