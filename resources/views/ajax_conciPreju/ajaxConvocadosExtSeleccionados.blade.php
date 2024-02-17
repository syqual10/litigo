<div class="row" style="padding-left:20px">
	@if(count($convocadoExt) > 0)	
		@foreach($convocadoExt as $convocadoExterno)
			<div class="col-sm-12" id="tablaConvocadosExt_{{$convocadoExterno->idConvocadoExterno}}">
				<h1 style="color:#21c2f8">
					<span class="semi-bold">
						@if($convocadoExterno->nombreConvocadoExterno != "") 
							{{$convocadoExterno->nombreConvocadoExterno}}
						@else
							<span class="text-muted">Sin datos registrados</span>
						@endif
					</span>
					<br>
					<small> 
						@if($convocadoExterno->direccionConvocadoExterno != "") 
							{{$convocadoExterno->direccionConvocadoExterno}}
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
								@if($convocadoExterno->telefonoConvocadoExterno != "") 
									{{$convocadoExterno->telefonoConvocadoExterno}} 
								@else
									Sin datos
								@endif						
							</span> 
						</p>
					</li>
				</ul>
				<br>		
				<a href="javascript:void(0);" class="btn btn-default btn-xs" onclick="editarConvocadoExt({{$convocadoExterno->idConvocadoExterno}})"><i class="fa fa-edit"></i> Modificar Información</a>
				<a href="javascript:void(0);" class="btn btn-default btn-xs" onclick="removerConvocadoExt({{$convocadoExterno->idConvocadoExterno}})"><i class="fa fa-trash"></i> Remover Convocado Externo</a>
				<hr>
			</div>
		@endforeach
	@else
		<br>
		<div class="col-sm-12">
			<p class="alert alert-info">
		        <i class="fa fa-warning fa-fw fa-2x"></i><strong>Atención!</strong> 
		        No se encontraron datos del convocado externo.
		    </p>
		</div>
	@endif
</div>