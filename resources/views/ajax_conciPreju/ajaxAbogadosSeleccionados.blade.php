<div class="row" style="padding-left:20px">
	@if(count($abogado) > 0)	
		@foreach($abogado as $abogadoPersona)
			<div class="col-sm-12" id="tablaAbogados_{{$abogadoPersona->idAbogado}}">
				<h1 style="color:#21c2f8">
					<span class="semi-bold">
						@if($abogadoPersona->nombreAbogado != "") 
							{{$abogadoPersona->nombreAbogado}}
						@else
							<span class="text-muted">Sin datos registrados</span>
						@endif
					</span>
					<br>
					<small> 
						@if($abogadoPersona->documentoAbogado != "") 
							{{$abogadoPersona->nombreTipoIdentificacion}} {{$abogadoPersona->documentoAbogado}}
						@else
							<span class="text-muted">Sin datos registrados</span>
						@endif				
					</small>
				</h1>

				<ul class="list-unstyled">
					<li>
						<p class="text-muted">
							<i class="fa fa-envelope"></i>&nbsp;&nbsp;
							<span class="txt-color-darken">
								@if($abogadoPersona->tarjetaAbogado != "") 
									{{$abogadoPersona->tarjetaAbogado}} 
								@else
									Sin datos
								@endif						
							</span> 
						</p>
					</li>
				</ul>
				<br>		
				<a href="javascript:void(0);" class="btn btn-default btn-xs" onclick="editarAbogado({{$abogadoPersona->idAbogado}})"><i class="fa fa-edit"></i> Modificar Información</a>
				<a href="javascript:void(0);" class="btn btn-default btn-xs" onclick="removerAbogado({{$abogadoPersona->idAbogado}})"><i class="fa fa-trash"></i> Remover Demandante</a>
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