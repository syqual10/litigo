<div class="row" style="padding-left:20px">
	@if(count($accionante) > 0)	
		@foreach($accionante as $accionantePersona)
			<div class="col-sm-12" id="tablaAccionantes_{{$accionantePersona->idSolicitante}}">
				<h1 style="color:#21c2f8">
					<span class="semi-bold">
						@if($accionantePersona->nombreSolicitante != "") 
							{{$accionantePersona->nombreSolicitante}}
						@else
							<span class="text-muted">Sin datos registrados</span>
						@endif
					</span>
					<br>
					<small> 
						@if($accionantePersona->documentoSolicitante != "") 
							{{$accionantePersona->nombreTipoIdentificacion}} {{$accionantePersona->documentoSolicitante}}
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
								@if($accionantePersona->direccionSolicitante != "") 
									{{$accionantePersona->direccionSolicitante." | ".$accionantePersona->nombreCiudad." | ".$accionantePersona->nombreDepartamento}} 
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
								@if($accionantePersona->telefonoSolicitante != "") 
									{{$accionantePersona->telefonoSolicitante}}
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
								@if($accionantePersona->celularSolicitante != "") 
									{{$accionantePersona->celularSolicitante}}
								@else
									<span class="text-muted">Sin datos registrados</span>
								@endif						
							</span> 
						</p>
					</li>
					<li>
						<p class="text-muted">
							<i class="fa fa-envelope"></i>&nbsp;&nbsp;					
							@if($accionantePersona->correoSolicitante != "") 
								<a href="mailto:{{$accionantePersona->correoSolicitante}}">
									{{$accionantePersona->correoSolicitante}}
								</a>
							@else
								<span class="text-muted">Sin datos registrados</span>
							@endif						
						</p>
					</li>
				</ul>
				<br>		
				<a href="javascript:void(0);" class="btn btn-default btn-xs" onclick="editarAccionante({{$accionantePersona->idSolicitante}})"><i class="fa fa-edit"></i> Modificar Información</a>
				<a href="javascript:void(0);" class="btn btn-default btn-xs" onclick="removerAccionante({{$accionantePersona->idSolicitante}})"><i class="fa fa-trash"></i> Remover Accionante</a>
				<hr>
			</div>
		@endforeach
	@else
		<br>
		<div class="col-sm-12">
			<p class="alert alert-info">
		        <i class="fa fa-warning fa-fw fa-2x"></i><strong>Atención!</strong> 
		        No se encontraron datos del accionante.
		    </p>
		</div>
	@endif
</div>