@php
  use SQ10\helpers\Util as Util;
@endphp

<div class="logo-container full-screen-table-demo">
<div class="logo"><img src="{{ asset('img/litigo-1.png') }}"></div>
</div>
<div class="fresh-table full-screen-table toolbar-color-blue">
	@if(!isset($noAgregar))
		@if($ver == 1)
			<div class="bars pull-right">
				<button id="alertBtn" class="btn btn-default btn-tabla" onclick="agregarActuacion({{$idEtapa}});"> Agregar una actuación a esta etapa</button>
			</div>
		@endif
	@endif
	<table id="tablaActuaciones_{{$idEtapa}}" class="table tabla-fresh table-bordered" style="font-size:0.84em">
		<thead>
			<tr>
				<th data-sortable="true">Fecha Actuación</th>
				<th data-sortable="true">Despacho Judicial</th>
				<th data-sortable="true">Actuación</th>
				<th data-sortable="true">Observación</th>
				<th data-sortable="true">Archivo</th>
				<th data-sortable="true">Usuario</th>
				<th data-sortable="true"></th>
				@if(!isset($noAccion))
					<th data-sortable="true"></th>
					<th data-sortable="true"></th>
				@endif
			</tr>
		</thead>
		<tbody>
			@if(count($actuacionesEtapa) > 0)
				@foreach($actuacionesEtapa as $actuacionEtapa)
					<tr>
						<td style="width:10%">
							{{ucfirst(utf8_encode(strftime("%A %d de %B de %Y", strtotime($actuacionEtapa->fechaActuacion))))}}
						</td>
						@if($actuacionEtapa->nombreJuzgado != '')
							<td style="width:25%">{{$actuacionEtapa->nombreJuzgado}}</td>
						@elseif($actuacionEtapa->nombreAutoridadConoce != '')
							<td style="width:25%">{{$actuacionEtapa->nombreAutoridadConoce}}</td>
						@else
							<td style="width:25%"></td>
						@endif
						<td style="width:20%">{{$actuacionEtapa->nombreActuacion}}</td>
						<td style="width:30%">{{$actuacionEtapa->comentarioActuacion}}</td>
						<td style="width:5%">
							@php
								$archivosActuacion = DB::table('juriarchivos')
									->where('juriactuaciones_idActuacion', '=', $actuacionEtapa->idActuacion)
									->get();
							@endphp
							@if(count($archivosActuacion) > 0)
								@foreach($archivosActuacion as $archivoActuacion)
									@php
										$partes = explode("_", $archivoActuacion->nombreArchivo);
										$nombre = substr($archivoActuacion->nombreArchivo,strlen($partes[0])+1);
									@endphp									
									
									@if($archivoActuacion->extensionArchivo == 'pdf')
										<a style="cursor:pointer; text-decoration:none !important;" onclick="verArchivoPdf({{$archivoActuacion->idArchivo}}, {{$archivoActuacion->juriradicados_vigenciaRadicado}}, {{$archivoActuacion->juriradicados_idRadicado}});">
									@else
										<a style="cursor:pointer; text-decoration:none !important;" href="{{ asset('juridica/descargarArchivo/'.$archivoActuacion->idArchivo) }}">
									@endif
										<img src="{{ asset("assets/images/".$archivoActuacion->extensionArchivo.".png") }}" style="max-width:24px" title="{{ $nombre }}">
									</a>
								@endforeach								
							@endif
						</td>

						<td style="width:5%">
							{{$actuacionEtapa->nombresUsuario}}
						</td>

						<td style="width:5%">
							@if(count($archivosActuacion) > 0)
								@foreach($archivosActuacion as $archivoActuacion)
									@if(!isset($noAccion))
										@php
											$responsableArchivo = Util::responsableArchivo($archivoActuacion->idArchivo, $idResponsable);
										@endphp
										@if($responsableArchivo > 0)
											<button class="btn btn-xs btn-danger btn-rounded pull-left" onclick="eliminarArchivo({{$archivoActuacion->idArchivo}}, {{$actuacionEtapa->jurietapas_idEtapa}})"><i class="fa fa-trash"></i> Eliminar Archivo</button>
										@endif
									@endif
								@endforeach
							@endif
						</td>

						@if(!isset($noAccion))
							<td style="width:5%">
								<button class="btn btn-xs btn-danger btn-rounded pull-left" onclick="eliminarActuacion({{$actuacionEtapa->idActuacion}}, {{$actuacionEtapa->jurietapas_idEtapa}})"><i class="fa fa-trash"></i> Eliminar Actuación</button>
							</td>

							<td style="width:5%">
								<button class="btn btn-xs btn-danger btn-rounded pull-left" onclick="editarActuacion({{$actuacionEtapa->idActuacion}}, {{$actuacionEtapa->jurietapas_idEtapa}})"><i class="fa fa-edit"></i> Editar Actuación</button>
							</td>
						@endif
					</tr>
				@endforeach
			@endif
		</tbody>
	</table>
</div>