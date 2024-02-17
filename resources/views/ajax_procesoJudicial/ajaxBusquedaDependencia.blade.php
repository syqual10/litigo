<br>
@if(count($dependencias) > 0)
	@if(count($dependencias) == 1)
		<h1 class="font-md"> Resultado de la búsqueda para <span class="semi-bold">{{$criterioDemandado}}</span>
			<small class="text-danger"> &nbsp;&nbsp;(1 resultado)</small>
		</h1>
	@else
		<h1 class="font-md"> Resultado de la búsqueda para <span class="semi-bold">{{$criterioDemandado}}</span>
			<small class="text-danger"> &nbsp;&nbsp;({{count($dependencias)}} resultados)</small>
		</h1>
	@endif
	
	@foreach($dependencias as $dependencia)
		<div class="search-results clearfix smart-form">
			<h4><i class="fa fa-plus-square txt-color-blue"></i>&nbsp;<a href="javascript:void(0);" onclick="seleccioneDemandado('{{$dependencia->idDependencia}}');">{{$dependencia->nombreDependencia}}</a></h4>
			<div>
				<div class="url text-success">
					@if($dependencia->codigoDependencia != "") 
						{{$dependencia->codigoDependencia}} 
					@else
						<span class="text-muted">Sin código registrado</span>
					@endif
					<i class="fa fa-caret-down"></i>
				</div>
			</div>
		</div>
	@endforeach			
@else
	<h1 class="font-md"> Resultado de la búsqueda para <span class="semi-bold">{{$criterioDemandado}}</span>
		<small class="text-danger"> &nbsp;&nbsp;(0 resultados)</small>
	</h1>
@endif