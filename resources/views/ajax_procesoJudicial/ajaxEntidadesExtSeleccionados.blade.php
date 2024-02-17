<div class="row" style="padding-left:20px">
	@if(count($entidadExt) > 0)	
		@foreach($entidadExt as $entidadExterna)
			<div class="col-sm-12" id="tablaEntidadesExt_{{$entidadExterna->idConvocadoExterno}}">
				<h1 style="color:#21c2f8">
					<span class="semi-bold">
						@if($entidadExterna->nombreConvocadoExterno != "") 
							{{$entidadExterna->nombreConvocadoExterno}}
						@else
							<span class="text-muted">Sin datos registrados</span>
						@endif
					</span>
					<br>
					<small> 
						@if($entidadExterna->direccionConvocadoExterno != "") 
							{{$entidadExterna->direccionConvocadoExterno}}
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
								@if($entidadExterna->telefonoConvocadoExterno != "") 
									{{$entidadExterna->telefonoConvocadoExterno}} 
								@else
									Sin datos
								@endif						
							</span> 
						</p>
					</li>
				</ul>
				<br>		
				<a href="javascript:void(0);" class="btn btn-default btn-xs" onclick="editarEntidadExt({{$entidadExterna->idConvocadoExterno}})"><i class="fa fa-edit"></i> Modificar Información</a>
				<a href="javascript:void(0);" class="btn btn-default btn-xs" onclick="removerEntidadExt({{$entidadExterna->idConvocadoExterno}})"><i class="fa fa-trash"></i> Remover Entidad Externa</a>
				<hr>
			</div>
		@endforeach
	@else
		<br>
		<div class="col-sm-12">
			<p class="alert alert-info">
		        <i class="fa fa-warning fa-fw fa-2x"></i><strong>Atención!</strong> 
		        No se encontraron datos de la entidad externa.
		    </p>
		</div>
	@endif
</div>