@if(count($etapas) > 0)
	<div class="row">
		<div class="col-md-12">
			<div class="panel-group" id="acordeon" role="tablist" aria-multiselectable="true">
				@php
				$x=0;
				@endphp
				@foreach($etapas as $etapa)
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="heading_{{$etapa->idEtapa}}">
							<h4 class="panel-title">
								<a class="collapsed" role="button" data-toggle="collapse" data-parent="#acordeon" href="#collapse_{{$etapa->idEtapa}}" aria-expanded="false" aria-controls="collapse_{{$etapa->idEtapa}}" onclick="actuacionesEtapa({{$etapa->idEtapa}});">
									{{"Etapa ".($x+1).": ".$etapa->nombreEtapa}}
								</a>
							</h4>
						</div>
					@if ($x==0)
						<div id="collapse_{{$etapa->idEtapa}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_{{$etapa->idEtapa}}">
						@else
							<div id="collapse_{{$etapa->idEtapa}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_{{$etapa->idEtapa}}">
							@endif
							<div class="panel-body">
								<p>
									<div class="row">
										<div class="col-sm-12">
											<div id="resultadoActuaciones_{{$etapa->idEtapa}}">
												<!--AJAX PARA AGREGAR LA ACTUACIÓN-->
											</div>
										</div>
									</div>
								</p>
							</div>
						</div>
					</div>
					@php
					$x++;
					@endphp
				@endforeach
			</div>
		</div>
	</div>
@endif
