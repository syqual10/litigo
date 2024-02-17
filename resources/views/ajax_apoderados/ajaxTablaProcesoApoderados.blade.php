@php
    use SQ10\helpers\Util as Util;
@endphp

<div class="modal-body">	
	<div class="logo-container full-screen-table-demo">
	    <div class="logo"><img src="{{ asset('img/litigo-1.png') }}"></div>
	</div>
	<div class="fresh-table full-screen-table toolbar-color-blue">
		<table id="fresh-table" class="table tabla-fresh">
			<thead>
				<tr>
					<th data-sortable="true">Radicado Interno</th>
					<th data-sortable="true">Apoderado del proceso</th>
					<th data-sortable="true">Juzgado</th>
					<th data-sortable="true">Radicado del Juzgado</th>
					<th data-sortable="true">Tipo de proceso</th>
					<th data-sortable="true"></th>
					<th data-sortable="true"></th>
				</tr>
			</thead>
			<tbody>
				@if(count($procesos) > 0)
					@foreach($procesos as $proceso)
						@php
							$apoderados = Util::apoderadosActivosRadicado($proceso->vigenciaRadicado, $proceso->idRadicado);
							$ultimoUsuario = Util::ultimoResponsableRadicado($proceso->vigenciaRadicado, $proceso->idRadicado);
						@endphp

						<tr>
							<td style="width:10%">
                              	<strong>{{$proceso->idRadicado}}-{{$proceso->vigenciaRadicado}}</strong>
							</td>

							<td style="width:10%">
								@if(count($apoderados) > 0)
									@foreach($apoderados as $apoderado)
										@if($proceso->juriresponsables_idResponsable_titular == '')
											@if($ultimoUsuario[0]->idResponsable == $apoderado->idResponsable)
						                        <strong>PRINCIPAL :</strong>
						                    @endif
						                @else
						                	@if($proceso->juriresponsables_idResponsable_titular == $apoderado->idResponsable)
					                        	<strong>PRINCIPAL :</strong>
					                    	@endif
										@endif

										{{$apoderado->nombresUsuario}} - </br>
									@endforeach
								@endif
							</td>

							<td style="width:20%">
								{{$proceso->nombreJuzgado}}
							</td>

							<td style="width:10%">
								{{$proceso->radicadoJuzgado}}
							</td>

							<td style="width:10%">
								{{$proceso->nombreTipoProceso}}
							</td>

							<td style="width:5%">
                            	<button class="btn btn-xs btn-primary btn-rounded" onclick="apoderadosRadicado({{$proceso->vigenciaRadicado}}, {{$proceso->idRadicado}})"><i class="fa fa-edit"></i> Modificar apoderados</button>
	                        </td>
	                        <td style="width:5%">
	                            <button class="btn btn-xs btn-danger btn-rounded" onclick="agregarApoderado({{$proceso->vigenciaRadicado}}, {{$proceso->idRadicado}})"><i class="fa fa-trash"></i> Agregar apoderado</button>
	                        </td>
						</tr>
					@endforeach
				@endif
			</tbody>
		</table>
	</div>
</div>