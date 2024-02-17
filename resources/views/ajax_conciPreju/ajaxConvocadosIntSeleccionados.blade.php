<div class="row" style="padding-left:20px">
	@if(count($convocadoInt) > 0)	
		@foreach($convocadoInt as $convocadoInterno)
			<div class="col-sm-12" id="tablaConvocadosInt_{{$convocadoInterno->idDependencia}}">
				<h1 style="color:#21c2f8">
					<span class="semi-bold">
						@if($convocadoInterno->nombreDependencia != "") 
							{{$convocadoInterno->nombreDependencia}}
						@else
							<span class="text-muted">Sin datos registrados</span>
						@endif
					</span>
					<br>
					<small> 
						@if($convocadoInterno->codigoDependencia != "") 
							Código: {{$convocadoInterno->codigoDependencia}}
						@else
							<span class="text-muted">Sin código registrado</span>
						@endif				
					</small>
				</h1>

				<ul class="list-unstyled">
					<li>
						<p class="text-muted">
							<i class="fa fa-info-circle"></i>&nbsp;&nbsp;
							<span class="txt-color-darken">
								@if($convocadoInterno->propositoDependencia != "") 
									{{$convocadoInterno->propositoDependencia}} 
								@else
									<span class="text-muted">Sin propósito registrados</span>
								@endif						
							</span> 
						</p>
					</li>
				</ul>
				<br>
				<a href="javascript:void(0);" class="btn btn-default btn-xs" onclick="removerConvocadoInt({{$convocadoInterno->idDependencia}})"><i class="fa fa-trash"></i> Remover Convocado Interno</a>
				<hr>
			</div>
		@endforeach
	@else
		<br>
		<div class="col-sm-12">
			<p class="alert alert-info">
		        <i class="fa fa-warning fa-fw fa-2x"></i><strong>Atención!</strong> 
		        No se encontraron datos del convocado interno.
		    </p>
		</div>
	@endif
</div>