<div class="row" style="padding-left:20px">
	@if(count($convocante) > 0)	
		@foreach($convocante as $convocantePersona)
			<div class="col-sm-12" id="tablaConvocantes_{{$convocantePersona->idSolicitante}}">
				<h1 style="color:#21c2f8">
					<span class="semi-bold">
						@if($convocantePersona->nombreSolicitante != "") 
							{{$convocantePersona->nombreSolicitante}}
						@else
							<span class="text-muted">Sin datos registrados</span>
						@endif
					</span>
					<br>
					<small> 
						@if($convocantePersona->documentoSolicitante != "") 
							{{$convocantePersona->nombreTipoIdentificacion}} {{$convocantePersona->documentoSolicitante}}
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
								@if($convocantePersona->direccionSolicitante != "") 
									{{$convocantePersona->direccionSolicitante." | ".$convocantePersona->nombreCiudad." | ".$convocantePersona->nombreDepartamento}} 
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
								@if($convocantePersona->telefonoSolicitante != "") 
									{{$convocantePersona->telefonoSolicitante}}
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
								@if($convocantePersona->celularSolicitante != "") 
									{{$convocantePersona->celularSolicitante}}
								@else
									<span class="text-muted">Sin datos registrados</span>
								@endif						
							</span> 
						</p>
					</li>
					<li>
						<p class="text-muted">
							<i class="fa fa-envelope"></i>&nbsp;&nbsp;					
							@if($convocantePersona->correoSolicitante != "") 
								<a href="mailto:{{$convocantePersona->correoSolicitante}}">
									{{$convocantePersona->correoSolicitante}}
								</a>
							@else
								<span class="text-muted">Sin datos registrados</span>
							@endif						
						</p>
					</li>
				</ul>
				<br>		
				<a href="javascript:void(0);" class="btn btn-default btn-xs" onclick="editarConvocante({{$convocantePersona->idSolicitante}})"><i class="fa fa-edit"></i> Modificar Información</a>
				<a href="javascript:void(0);" class="btn btn-default btn-xs" onclick="removerConvocante({{$convocantePersona->idSolicitante}})"><i class="fa fa-trash"></i> Remover Convocante</a>
				<hr>
			</div>
		@endforeach
	@else
		<br>
		<div class="col-sm-12">
			<p class="alert alert-info">
		        <i class="fa fa-warning fa-fw fa-2x"></i><strong>Atención!</strong> 
		        No se encontraron datos del convocante.
		    </p>
		</div>
	@endif
</div>