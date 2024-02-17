<div class="modal-body">	
	<div>
		<table>
			<thead>
				<tr>
					<th data-sortable="true">Nombre</th>
					<th data-sortable="true"></th>
				</tr>
			</thead>
			<tbody>
				@if(count($apoderados) > 0)
					@foreach($apoderados as $apoderado)
						<tr>
							<td style="width:10%">
                              	<strong>{{$apoderado->nombresUsuario}}</strong>
							</td>

	                        <td style="width:5%">
	                            <button class="btn btn-xs btn-danger btn-rounded" onclick="eliminarApoderado({{$apoderado->idEstadoEtapa}}, {{$idRadicado}}, {{$vigenciaRadicado}})"><i class="fa fa-trash"></i> Eliminar apoderado</button>
	                        </td>
						</tr>
					@endforeach
				@endif
			</tbody>
		</table>
	</div>
</div>