<br>
@if(count($convocadosExt) > 0)
	@if(count($convocadosExt) == 1)
		<h1 class="font-md"> Resultado de la búsqueda para <span class="semi-bold">{{$criterioAccionadoExt}}</span>
			<small class="text-danger"> &nbsp;&nbsp;(1 resultado)</small>
		</h1>
	@else
		<h1 class="font-md"> Resultado de la búsqueda para <span class="semi-bold">{{$criterioAccionadoExt}}</span>
			<small class="text-danger"> &nbsp;&nbsp;({{count($convocadosExt)}} resultados)</small>
		</h1>
	@endif
	
	@foreach($convocadosExt as $accionadoExt)
		<div class="search-results clearfix smart-form">
			<h4><i class="fa fa-plus-square txt-color-blue"></i>&nbsp;<a href="javascript:void(0);" onclick="seleccioneAccionadoExt('{{$accionadoExt->idConvocadoExterno}}');">{{$accionadoExt->nombreConvocadoExterno}}</a></h4>
			<div>
				<div class="url text-success">
					@if($accionadoExt->direccionConvocadoExterno != "") 
						{{$accionadoExt->direccionConvocadoExterno}} 
					@else
						<span class="text-muted">Sin dirección registrada</span>
					@endif
					<i class="fa fa-caret-down"></i>
				</div>

				<div class="url text-success">
					@if($accionadoExt->telefonoConvocadoExterno != "") 
						{{$accionadoExt->telefonoConvocadoExterno}} 
					@else
						<span class="text-muted">Sin teléfono registrada</span>
					@endif
					<i class="fa fa-caret-down"></i>
				</div>
			</div>
		</div>
	@endforeach			
@else
	<h1 class="font-md"> Resultado de la búsqueda para <span class="semi-bold">{{$criterioAccionadoExt}}</span>
		<small class="text-danger"> &nbsp;&nbsp;(0 resultados)</small>
	</h1>
@endif