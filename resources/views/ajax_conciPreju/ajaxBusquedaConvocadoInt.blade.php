<br>
@if(count($convocados) > 0)
	@if(count($convocados) == 1)
		<h1 class="font-md"> Resultado de la búsqueda para <span class="semi-bold">{{$criterioConvocadoInt}}</span>
			<small class="text-danger"> &nbsp;&nbsp;(1 resultado)</small>
		</h1>
	@else
		<h1 class="font-md"> Resultado de la búsqueda para <span class="semi-bold">{{$criterioConvocadoInt}}</span>
			<small class="text-danger"> &nbsp;&nbsp;({{count($convocados)}} resultados)</small>
		</h1>
	@endif
	
	@foreach($convocados as $convocado)
		<div class="search-results clearfix smart-form">
			<h4><i class="fa fa-plus-square txt-color-blue"></i>&nbsp;<a href="javascript:void(0);" onclick="seleccioneConvocadoInt('{{$convocado->idDependencia}}');">{{$convocado->nombreDependencia}}</a></h4>
			<div>
				<div class="url text-success">
					@if($convocado->codigoDependencia != "") 
						{{$convocado->codigoDependencia}} 
					@else
						<span class="text-muted">Sin código registrado</span>
					@endif
					<i class="fa fa-caret-down"></i>
				</div>
			</div>
		</div>
	@endforeach			
@else
	<h1 class="font-md"> Resultado de la búsqueda para <span class="semi-bold">{{$criterioConvocadoInt}}</span>
		<small class="text-danger"> &nbsp;&nbsp;(0 resultados)</small>
	</h1>
@endif