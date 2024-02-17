<div class="row" style="padding-left:20px">
	@if(count($demandante) > 0)	
		@foreach($demandante as $demandantePersona)
			<div class="col-sm-12" id="tablaDemandantes_{{$demandantePersona->idSolicitante}}">
				<h1 style="color:#21c2f8">
					<span class="semi-bold">
						@if($demandantePersona->nombreSolicitante != "") 
							{{$demandantePersona->nombreSolicitante}}
						@else
							<span class="text-muted">Sin datos registrados</span>
						@endif
					</span>
					<br>
					<small> 
						@if($demandantePersona->documentoSolicitante != "") 
							{{$demandantePersona->nombreTipoIdentificacion}} {{$demandantePersona->documentoSolicitante}}
						@else
							<span class="text-muted">Sin datos registrados</span>
						@endif				
					</small>
				</h1>

				<ul class="list-unstyled">
					<li>
						<p class="text-muted">
							<i class="fa fa-map-marker"></i>&nbsp;&nbsp;
							<span class="txt-color-darken">
								@if($demandantePersona->direccionSolicitante != "") 
									{{$demandantePersona->direccionSolicitante." | ".$demandantePersona->nombreCiudad." | ".$demandantePersona->nombreDepartamento}} 
								@else
									Sin datos
								@endif						
							</span> 
						</p>
					</li>
					<li>
						<p class="text-muted">
							<i class="fa fa-phone"></i>&nbsp;&nbsp;
							<span class="txt-color-darken">
								@if($demandantePersona->telefonoSolicitante != "") 
									{{$demandantePersona->telefonoSolicitante}}
								@else
									<span class="text-muted">Sin datos registrados</span>
								@endif						
							</span> 
						</p>
					</li>
					<li>
						<p class="text-muted">
							<i class="fa fa-mobile-phone"></i>&nbsp;&nbsp;
							<span class="txt-color-darken">
								@if($demandantePersona->celularSolicitante != "") 
									{{$demandantePersona->celularSolicitante}}
								@else
									<span class="text-muted">Sin datos registrados</span>
								@endif						
							</span> 
						</p>
					</li>
					<li>
						<p class="text-muted">
							<i class="fa fa-envelope"></i>&nbsp;&nbsp;					
							@if($demandantePersona->correoSolicitante != "") 
								<a href="mailto:{{$demandantePersona->correoSolicitante}}">
									{{$demandantePersona->correoSolicitante}}
								</a>
							@else
								<span class="text-muted">Sin datos registrados</span>
							@endif						
						</p>
					</li>
				</ul>
				<br>		
				<a href="javascript:void(0);" class="btn btn-default btn-xs" onclick="editarDemandante({{$demandantePersona->idSolicitante}})"><i class="fa fa-edit"></i> Modificar Información</a>
				<a href="javascript:void(0);" class="btn btn-default btn-xs" onclick="removerDemandante({{$demandantePersona->idSolicitante}})"><i class="fa fa-trash"></i> Remover Demandante</a>
				<hr>
			</div>
		@endforeach
	@else
		<br>
		<div class="col-sm-12">
			<p class="alert alert-info">
		        <i class="fa fa-warning fa-fw fa-2x"></i><strong>Atención!</strong> 
		        No se encontraron datos del demandante.
		    </p>
		</div>
	@endif
</div>