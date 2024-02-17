<br>
@if(count($solicitantes) > 0)
	@if(count($solicitantes) == 1)
		<h1 class="font-md"> Resultado de la búsqueda para <span class="semi-bold">{{$criterioDemandante}}</span>
			<small class="text-danger"> &nbsp;&nbsp;(1 resultado)</small>
		</h1>
	@else
		<h1 class="font-md"> Resultado de la búsqueda para <span class="semi-bold">{{$criterioDemandante}}</span>
			<small class="text-danger"> &nbsp;&nbsp;({{count($solicitantes)}} resultados)</small>
		</h1>
	@endif
	
	@foreach($solicitantes as $solicitante)
		<div class="search-results clearfix smart-form">
			<h4><i class="fa fa-plus-square txt-color-blue"></i>&nbsp;<a href="javascript:void(0);" onclick="seleccioneDemandante('{{$solicitante->idSolicitante}}');">{{$solicitante->nombreSolicitante}}</a></h4>
			<div>
				<div class="url text-success">
					@if($solicitante->documentoSolicitante != "") 
						{{$solicitante->documentoSolicitante}} 
					@else
						<span class="text-muted">Sin documento registrado</span>
					@endif
					<i class="fa fa-caret-down"></i>
				</div>
				<p class="description">
					@if($solicitante->documentoSolicitante != "") 
						{{$solicitante->direccionSolicitante}}
					@else
						<span class="text-muted">Sin dirección registrada</span>
					@endif					
				</p>
			</div>
		</div>
	@endforeach			
@else
	<h1 class="font-md"> Resultado de la búsqueda para <span class="semi-bold">{{$criterioDemandante}}</span>
		<small class="text-danger"> &nbsp;&nbsp;(0 resultados)</small>
	</h1>
@endif