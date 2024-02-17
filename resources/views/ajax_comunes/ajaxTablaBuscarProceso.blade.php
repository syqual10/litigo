@php
    use SQ10\helpers\Util as Util;
@endphp

<div class="modal-body">	
	<div class="logo-container full-screen-table-demo">
	    <div class="logo"><img src="{{ asset('img/litigo-1.png') }}"></div>
	</div>
	<div class="fresh-table full-screen-table toolbar-color-blue">
		<table id="fresh-table" class="table tabla-fresh" data-card-view="true" data-height="650">
			<thead>
				<tr>
					<th data-sortable="true">Radicado Interno</th>
					<th data-sortable="true">Fecha de radicado</th>
					<th data-sortable="true">Tipo de proceso</th>
					<th data-sortable="true">Medio de control</th>
					<th data-sortable="true">Juzgado</th>
					<th data-sortable="true">Radicado del Juzgado</th>
					<th data-sortable="true">Última Actuación</th>
					<th data-sortable="true">Sentido del fallo</th>
					<th data-sortable="true">Apoderado del proceso</th>
					<th data-sortable="true">Dependencia Afectada</th>
					<th data-sortable="true">Historico apoderados</th>
					<th data-sortable="true">Demandantes-Convocantes-Accionantes</th>
					<th data-sortable="true">Tema</th>
					<th data-sortable="true">Asunto</th>
					<th data-sortable="true">Estado del proceso</th>
					<th data-sortable="true">Cuantías</th>
					<th data-sortable="true">Radicados Asociados</th>
				</tr>
			</thead>
			<tbody>
				@if(count($proceso) > 0)
					@foreach($proceso as $proces)
						<tr>
							@php
								$fallos = Util::sentidoFallo($proces['vigenciaRadicado'], $proces['idRadicado']);
								$apoderadosHistorico = Util::apoderadosRadicado($proces['vigenciaRadicado'], $proces['idRadicado'], $proces['idTipoProcesos']);
								$apoderados = Util::apoderadosActivosRadicado($proces['vigenciaRadicado'], $proces['idRadicado'], $proces['idTipoProcesos']);
								$ultimoUsuario = Util::ultimoResponsableRadicado($proces['vigenciaRadicado'], $proces['idRadicado']);
							@endphp

							<td style="width:8%">
								<a href="#" onclick="buscarProceso(1, {{$proces['vigenciaRadicado']}}, {{$proces['idRadicado']}});"><i class="fa fa-lg fa-fw fa-search"></i> <span class="menu-item-parent"></span></a>
								<br>
								<br>
								<a href="{{asset($proces['ruta'])}}">
									<strong>{{$proces['idRadicado']."-".$proces['vigenciaRadicado']}}</strong>
								</a>
							</td>

							<td style="width:8%">
								<a href="{{asset($proces['ruta'])}}">
									<strong> {{ucfirst(utf8_encode(strftime("%A %d de %B de %Y", strtotime($proces['fechaRadicado']))))}}</strong>
								</a>
							</td>

							<td style="width:8%">{{$proces['nombreTipoProceso']}}</td>

							<td style="width:8%">{{$proces['nombreMedioControl']}}</td>

							
							<td style="width:8%">{{$proces['nombreJuzgado']}}</td>

							<td style="width:8%">{{$proces['radicadoJuzgado']}}</td>

							<td style="width:8%">
								{{Util::ultimoTipoActuacion($proces['vigenciaRadicado'], $proces['idRadicado'])}}
							</td>

							<td style="width:8%">
								
								@if(count($fallos) > 0)

								
									@foreach($fallos as $fallo)
										<strong>{{$fallo->nombreActuacion}}</strong> : {{$fallo->nombreTipoFallo}} -  {{ $fallo->fechaActuacion }}</br>
									@endforeach
								@endif
							</td>

							<td style="width:8%">
								@php $idApoderadoPrincipal = 0; @endphp
								@foreach($apoderados as $apoderado)
									@php
										$principal = 0;
										$idApoderadoPrincipal = $apoderado->idResponsable;
									@endphp
									@if($proces['responsableTitular'] == '')
										@if($ultimoUsuario[0]->idResponsable == $apoderado->idResponsable)
											@php
												$principal = 1;
											@endphp
					                        <strong>PRINCIPAL :</strong>
					                    @endif
					                @else
					                	@if($proces['responsableTitular'] == $apoderado->idResponsable)
					                		@php
												$principal = 1;
											@endphp
				                        	<strong>PRINCIPAL :</strong>
				                    	@endif
									@endif

									@if($principal == 1)
										<strong><span>{{$apoderado->nombresUsuario}} -</span></strong>
									@else
										{{$apoderado->nombresUsuario}} -
									@endif
									</br>
								@endforeach

							</td>

							<td style="width:8%">
								{{Util::dependenciaDemandada($proces['vigenciaRadicado'], $proces['idRadicado'], $proces['idTipoProcesos'])}}
							</td>

							<td style="width:8%">

								@foreach($apoderadosHistorico as $apoderado)
									@if($apoderado->idResponsable !== $idApoderadoPrincipal)
										@php
											$principal = 0;
										@endphp
										@if($proces['responsableTitular'] == '')
											@if($ultimoUsuario[0]->idResponsable == $apoderado->idResponsable)
												@php
													$principal = 1;
												@endphp
												<strong>PRINCIPAL :</strong>
											@endif
										@else
											@if($proces['responsableTitular'] == $apoderado->idResponsable)
												@php
													$principal = 1;
												@endphp
												<strong>PRINCIPAL :</strong>
											@endif
										@endif

										@if($principal == 1)
											<strong><span>{{$apoderado->nombresUsuario}} -</span></strong>
										@else
											{{$apoderado->nombresUsuario}} -
										@endif
										</br>
									@endif
								@endforeach

							</td>

							<td style="width:8%">
								{{Util::personaDemandante($proces['vigenciaRadicado'], $proces['idRadicado'], $proces['idTipoProcesos'])}}
							</td>

							<td style="width:8%">{{$proces['nombreTema']}}</td>
							<td style="width:8%">{{$proces['asunto']}}</td>
							
							<td style="width:8%">{{$proces['nombreEstadoRadicado']}}</td>
							
							<td style="width:8%">
								{{Util::cuantiasRadicado($proces['vigenciaRadicado'], $proces['idRadicado'])}}
							</td>
							<td style="width:8%">
								{{Util::radicadosAsociados($proces['vigenciaRadicado'], $proces['idRadicado'])}}
							</td>
						</tr>
					@endforeach
				@endif
			</tbody>
		</table>
	</div>
</div>