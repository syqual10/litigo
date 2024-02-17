@php use 
	SQ10\helpers\Util as Util; 
@endphp
<style>
	.tabla-info small{
		color:#0aa699 !important;
	}
</style>
<div class="row">
	<div class="col-sm-6">
		<div class="page">
			<div class="page__demo">
				<div class="main-container page__container">					
					@if (count($estadosEtapas) > 0)	
						<!-- línea de tiempo -->
						<div class="timeline">													
							@php
								$cont = 0;
								$vigenciaGrupo = "";
							@endphp

							@foreach ($estadosEtapas as $estadoEtapa)
								@php
									$vigenciaEtapa = date('Y', strtotime($estadoEtapa->fechaInicioEstado));

									$ultimoUsuario = Util::ultimoResponsableRadicado($proceso[0]->vigenciaRadicado, $proceso[0]->idRadicado);
								@endphp
								
									@if ($cont == 0)
										@php
											$vigenciaGrupo = $vigenciaEtapa;
										@endphp		
										<!-- grupo -->
										<div class="timeline__group">								
											<!-- año -->
											<span class="timeline__year">{{$vigenciaGrupo}}</span>
											<!-- #año -->
									@else
										@if ($vigenciaGrupo != $vigenciaEtapa)
											@php
												$vigenciaGrupo = $vigenciaEtapa;
											@endphp

											</div>
											<!-- #grupo -->

											<!-- grupo -->
											<div class="timeline__group">
												<!-- año -->
												<span class="timeline__year">{{$vigenciaGrupo}}</span>
												<!-- #año -->
										@endif																				
									@endif									
								
									<!-- fila -->
									<div class="timeline__box">								
										<!-- fecha -->
										<div class="timeline__date">
											<span class="timeline__day">
												{{date('d', strtotime($estadoEtapa->fechaInicioEstado))}}
											</span>
											<span class="timeline__month">
												{{substr(utf8_encode(strftime("%B", strtotime($estadoEtapa->fechaInicioEstado))), 0, 3)}} 													
											</span>
										</div>
										<!-- #fecha -->								
										<!-- contenido -->
										<div class="timeline__post">
											<div class="timeline__content row">
												<div class="sl-left col-sm-1">
													@php 
														$nombre_fichero = '../public/juriArch/entidad/usuarios/'.$estadoEtapa->documentoUsuario.'.jpg' 
													@endphp 
													
													@if (file_exists($nombre_fichero))
														<img src="{{ asset('juriArch/entidad/usuarios/'.$estadoEtapa->documentoUsuario.'.jpg')}}" class="img-circle"> 
													@else
														<img src="{{ asset('img/avatar-profile.png')}}" class="img-circle"> 
													@endif
												</div>
												<div class="sl-right col-sm-10">
													<span class="user-lt">
														@php
															$principal = 0;
														@endphp

														@if($proceso[0]->juriresponsables_idResponsable_titular == '')
															@if($ultimoUsuario[0]->idResponsable == $estadoEtapa->juriresponsables_idResponsable)
																@php
																	$principal = 1;
																@endphp
										                        <strong>PRINCIPAL :</strong>
										                    @endif
										                @else
										                	@if($proceso[0]->juriresponsables_idResponsable_titular == $estadoEtapa->juriresponsables_idResponsable)
										                		@php
																	$principal = 1;
																@endphp
									                        	<strong>PRINCIPAL :</strong>
									                    	@endif
														@endif

														@if($principal == 1)
															<strong><span>{{$estadoEtapa->nombresUsuario}} -</span></strong>
														@else
															{{$estadoEtapa->nombresUsuario}} -
														@endif
													</span>
													<span class="sl-date">
														{{ucfirst(utf8_encode(strftime("%A %d de %B de %Y", strtotime($estadoEtapa->fechaInicioEstado))))." ".date('h:i A', strtotime($estadoEtapa->fechaInicioEstado))}}
													</span>
													<p class="etapa-lt">{{strtoupper($estadoEtapa->nombreTipoEstado)}}</p>
													<p class="sl-text">{{$estadoEtapa->comentarioEstadoEtapa}}</p>
												</div>
											</div>
										</div>
										<!-- #contenido -->
									</div>
									<!-- #fila -->	
									@if($cont == count($estadosEtapas)-1)	
										</div>
										<!-- #grupo -->
									@endif
								@php
									$cont++;
								@endphp
							@endforeach									
						
						</div>							
						<!-- #línea de tiempo -->
					@else
						<p class="alert alert-info">
							<i class="fa fa-warning fa-fw fa-2x"></i><strong> No es posible mostrar una línea de tiempo</strong> 
							<br> No se encontrarón estados para este proceso
						</p>
					@endif
				</div>
			</div>
		</div>
	</div>
	<div class="col-sm-6" style="background: #fff;border: 1px solid #ddd;">
		@php 
			if($proceso[0]->idTipoProcesos == 1) { 
				$ruta = 'actuacionProc-judi/index/'; 
			} else if($proceso[0]->idTipoProcesos == 2) { 
				$ruta = 'actuacionConci-prej/index/'; 
			} else if($proceso[0]->idTipoProcesos == 3) { 
				$ruta = 'actuacionTutelas/index/';
		  } 
		@endphp
		<br>
		@if (count($estadosEtapas) > 0)
		  	<div class="row">
				<div class="col-sm-3">
					<a href="{{asset($ruta.$estadosEtapas[count($estadosEtapas)-1]->idEstadoEtapa)}}" class="btn btn-default btn-block" style="margin-bottom:10px"><i class="fa fa-eye"></i> Ver este proceso</a>
				</div>
			</div>
		@endif

		<table class="table table-striped table-forum tabla-info">
			<tbody>
				@php
					$fallos = Util::sentidoFallo($proceso[0]->vigenciaRadicado, $proceso[0]->idRadicado);
				@endphp

				<tr>
					<td class="text-center" style="width: 40px;"><i class="fa fa-hashtag fa-2x text-muted"></i></td>
					<td>
						<h4>
							{{$proceso[0]->idRadicado."-".$proceso[0]->vigenciaRadicado}}						
							<small>Número de Radicado Interno </small>
						</h4>
					</td>
				</tr>

				@if($proceso[0]->radicadoPadre != null)
					<tr>
						<td class="text-center" style="width: 40px;"><i class="fa fa-hashtag fa-2x text-muted"></i></td>
						<td>
							<h4>
								{{$proceso[0]->radicadoPadre}}							
								<small>Radicados Asociados:</small>
							</h4>
						</td>
					</tr>
				@endif


				@if($proceso[0]->radicadoHijo != null)
					<tr>
						<td class="text-center" style="width: 40px;"><i class="fa fa-hashtag fa-2x text-muted"></i></td>
						<td>
							<h4>
								{{$proceso[0]->radicadoHijo}}							
								<small>Radicados Asociados</small>
							</h4>
						</td>
					</tr>
				@endif

				<tr>
					<td class="text-center" style="width: 40px;"><i class="fa fa-hashtag fa-2x text-muted"></i></td>
					<td>
						<h4>
							{{ucfirst(utf8_encode(strftime("%A %d de %B de %Y", strtotime($proceso[0]->fechaRadicado))))}}						
							<small>Fecha de radicado</small>
						</h4>
					</td>
				</tr>

				<tr>
					<td class="text-center" style="width: 40px;"><i class="fa fa-hashtag fa-2x text-muted"></i></td>
					<td>
						<h4>
							{{$proceso[0]->nombreTipoProceso}}						
							<small>Tipo de proceso</small>
						</h4>
					</td>
				</tr>

				<tr>
					<td class="text-center" style="width: 40px;"><i class="fa fa-university fa-2x text-muted"></i></td>
					<td>
						<h4>
							@if($proceso[0]->codigoProceso !='')
								{{$proceso[0]->nombreJuzgado}}
							@else
								No Registrado
							@endif
							<small>Juzgado</small>
						</h4>
					</td>
				</tr>

				<tr>
					<td class="text-center" style="width: 40px;"><i class="fa fa-barcode fa-2x text-muted"></i></td>
					<td>
						<h4>
							@if($proceso[0]->radicadoJuzgado !='')
								{{$proceso[0]->radicadoJuzgado}}
							@else
								No Registrado
							@endif
							<small>Radicado del juzgado</small>
						</h4>
					</td>
				</tr>

				<tr>
					<td class="text-center" style="width: 40px;"><i class="fa fa-barcode fa-2x text-muted"></i></td>
					<td>
						<h4>
							{{Util::ultimoTipoActuacion($proceso[0]->vigenciaRadicado, $proceso[0]->idRadicado)}}						
							<small>Última actuación</small>
						</h4>
					</td>
				</tr>

				<tr>
					<td class="text-center" style="width: 40px;"><i class="fa fa-barcode fa-2x text-muted"></i></td>
					<td>
						<h4>

							@if(count($fallos) > 0)
								@foreach($fallos as $fallo)
									<strong>{{$fallo->nombreActuacion}}</strong> : {{$fallo->nombreTipoFallo}} - </br>
								@endforeach
							@endif
						
							<small>Fallos</small>
						</h4>
					</td>
				</tr>

				<tr>
					<td class="text-center" style="width: 40px;"><i class="fa fa-user-plus fa-2x text-muted"></i></td>
					<td>
						<h4>
							@if (count($estadosEtapas) > 0)
								
									@php
										//Monica lo pidio asi pero cotacio dice que no 
										//$apoderados = Util::apoderadosRadicado($proceso[0]->vigenciaRadicado, $proceso[0]->idRadicado);
										$apoderados = Util::apoderadosActivosRadicado($proceso[0]->vigenciaRadicado, $proceso[0]->idRadicado);	
									@endphp

									@if(count($apoderados) > 0)
										@foreach($apoderados as $apoderado)
											@if($proceso[0]->juriresponsables_idResponsable_titular == '')
												@if($ultimoUsuario[0]->idResponsable == $apoderado->idResponsable)
							                        <strong>PRINCIPAL1 :</strong>
							                    @endif
							                @else
							                	@if($proceso[0]->juriresponsables_idResponsable_titular == $apoderado->idResponsable)
						                        	<strong>PRINCIPAL2 :</strong>
						                    	@endif
											@endif
											{{$apoderado->nombresUsuario}} -
											</br>
										@endforeach
									@endif
								
							@endif
							<small>Apoderado del proceso</small>
						</h4>
					</td>
				</tr>

				<tr>
					<td class="text-center" style="width: 40px;"><i class="fa fa-lightbulb-o fa-2x text-muted"></i></td>
					<td>
						<h4>
							{{Util::dependenciaDemandada($proceso[0]->vigenciaRadicado, $proceso[0]->idRadicado, $proceso[0]->idTipoProcesos)}}						
							<small>Dependencias Afectadas</small>
						</h4>
					</td>
				</tr>

				<tr>
					<td class="text-center" style="width: 40px;"><i class="fa fa-user-plus fa-2x text-muted"></i></td>
					<td>
						<h4>
							@if (count($estadosEtapas) > 0)
								
									@php
										$apoderadosHistorico = Util::apoderadosRadicado($proceso[0]->vigenciaRadicado, $proceso[0]->idRadicado);
									@endphp

									@if(count($apoderadosHistorico) > 0)
										@foreach($apoderadosHistorico as $apoderado)
											@if($proceso[0]->juriresponsables_idResponsable_titular == '')
												@if($ultimoUsuario[0]->idResponsable == $apoderado->idResponsable)
							                        <strong>PRINCIPAL1 :</strong>
							                    @endif
							                @else
							                	@if($proceso[0]->juriresponsables_idResponsable_titular == $apoderado->idResponsable)
						                        	<strong>PRINCIPAL2 :</strong>
						                    	@endif
											@endif
											{{$apoderado->nombresUsuario}} -
											</br>
										@endforeach
									@endif
								
							@endif
							<small>Historico apoderados</small>
						</h4>
					</td>
				</tr>

				<tr>
					<td class="text-center" style="width: 40px;"><i class="fa fa-hashtag fa-2x text-muted"></i></td>
					<td>
						<h4> 
							{{Util::personaDemandante($proceso[0]->vigenciaRadicado, $proceso[0]->idRadicado, $proceso[0]->idTipoProcesos)}}						
							<small>Demandantes - Convocantes - Accionantes</small>
						</h4>
					</td>
				</tr>

				<tr>
					<td class="text-center" style="width: 40px;"><i class="fa fa-quote-left fa-2x text-muted"></i></td>
					<td>
						<h4>
							@if($proceso[0]->codigoProceso !='')
								{{$proceso[0]->nombreTema}}
							@else
								No Registrado
							@endif
							<small>Tema</small>
						</h4>
					</td>
				</tr>

				<tr>
					<td class="text-center" style="width: 40px;"><i class="fa fa-quote-left fa-2x text-muted"></i></td>
					<td>
						<h4>
							@if($proceso[0]->codigoProceso !='')
								{{$proceso[0]->asunto}}
							@else
								No Registrado
							@endif
							<small>Asunto</small>
						</h4>
					</td>
				</tr>

				<tr>
					<td class="text-center" style="width: 40px;"><i class="fa fa-exchange fa-2x text-muted"></i></td>
					<td>
						<h4>
							{{$proceso[0]->nombreMedioControl}}						
							<small>Medio de control</small>
						</h4>
					</td>
				</tr>

				
				<tr>
					<td class="text-center" style="width: 40px;"><i class="fa fa-lightbulb-o fa-2x text-muted"></i></td>
					<td>
						<h4>
							{{$proceso[0]->nombreEstadoRadicado}}						
							<small>Estado del proceso</small>
						</h4>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>