<div class="row" style="padding-left:20px">
	@if(count($accionadoInt) > 0)	
		@foreach($accionadoInt as $accionadoIntDependencia)
			<div class="col-sm-12" id="tablaAccionadosInt_{{$accionadoIntDependencia->idDependencia}}">
				<h1 style="color:#21c2f8">
					<span class="semi-bold">
						@if($accionadoIntDependencia->nombreDependencia != "") 
							{{$accionadoIntDependencia->nombreDependencia}}
						@else
							<span class="text-muted">Sin datos registrados</span>
						@endif
					</span>
					<br>
					<small> 
						@if($accionadoIntDependencia->codigoDependencia != "") 
							Código: {{$accionadoIntDependencia->codigoDependencia}}
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
								@if($accionadoIntDependencia->propositoDependencia != "") 
									{{$accionadoIntDependencia->propositoDependencia}} 
								@else
									<span class="text-muted">Sin propósito registrados</span>
								@endif						
							</span> 
						</p>
					</li>
				</ul>
				<br>
				<a href="javascript:void(0);" class="btn btn-default btn-xs" onclick="removerAccionadoInt({{$accionadoIntDependencia->idDependencia}})"><i class="fa fa-trash"></i> Remover Demandante</a>
				<hr>
			</div>
		@endforeach
	@else
		<br>
		<div class="col-sm-12">
			<p class="alert alert-info">
		        <i class="fa fa-warning fa-fw fa-2x"></i><strong>Atención!</strong> 
		        No se encontraron datos del demandado.
		    </p>
		</div>
	@endif
</div>