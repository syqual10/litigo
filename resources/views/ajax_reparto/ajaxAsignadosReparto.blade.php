<div class="row" style="padding-left:20px">
	@if(count($asignado) > 0)	
		@foreach($asignado as $asignadoAbogado)
			<div class="col-sm-12" id="tablaAsignados_{{$asignadoAbogado->idResponsable}}">
				<h1 style="color:#21c2f8">
					<span class="semi-bold">
						{{$asignadoAbogado->nombresUsuario}}
					</span>
					<br>
					<small> 
						@if($asignadoAbogado->nombreDependencia != "") 
							{{$asignadoAbogado->nombreDependencia}}
						@else
							<span class="text-muted">Sin datos registrados</span>
						@endif				
					</small>
				</h1>
				<br>	

				<div class="row">
					<div class="col-sm-6">
						<span class="onoffswitch pull-left">
							@if($totalAsignados == 1)
								<input type="checkbox" name="start_interval" id="apoderadoCheck_{{$asignadoAbogado->idResponsable}}" class="onoffswitch-checkbox apoderadoTitular" value="{{$asignadoAbogado->idResponsable}}" checked disabled>
							@else
								<input type="checkbox" name="start_interval" id="apoderadoCheck_{{$asignadoAbogado->idResponsable}}" class="onoffswitch-checkbox apoderadoTitular" onchange="seleccionarApoderado({{$asignadoAbogado->idResponsable}})" value="{{$asignadoAbogado->idResponsable}}">
							@endif
			                <label class="onoffswitch-label" for="apoderadoCheck_{{$asignadoAbogado->idResponsable}}">
			                    <span class="onoffswitch-inner" data-swchon-text="SI" data-swchoff-text="NO"></span>
			                    <span class="onoffswitch-switch">¿Es Apoderado?</span>
			                </label>
				        </span>
			        </div>

			        <div class="col-sm-4">
			        	<a href="javascript:void(0);" class="btn btn-default btn-xs" onclick="removerAsignado({{$asignadoAbogado->idResponsable}})"><i class="fa fa-trash"></i> Remover Apoderado</a>
			        </div>
		        </div>	
				<hr>
			</div>
		@endforeach
	@else
		<br>
		<div class="col-sm-12">
			<p class="alert alert-info">
		        <i class="fa fa-warning fa-fw fa-2x"></i><strong>Atención!</strong> 
		        No se encontraron datos del asignado.
		    </p>
		</div>
	@endif
</div>
<br>
<button class="btn btn-success btn-asignar-reparto"><i class="icon-rocket"></i> <a id="eventUrl" style="color:#fff; text-decoration:none;" onclick="validarAsignarReparto();">Guardar</a></button>
