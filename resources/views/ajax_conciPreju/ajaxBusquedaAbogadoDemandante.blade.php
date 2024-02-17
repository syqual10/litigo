<br>
@if(count($abogados) > 0)
	@if(count($abogados) == 1)
		<h1 class="font-md"> Resultado de la búsqueda para <span class="semi-bold">{{$criterioAbogado}}</span>
			<small class="text-danger"> &nbsp;&nbsp;(1 resultado)</small>
		</h1>
	@else
		<h1 class="font-md"> Resultado de la búsqueda para <span class="semi-bold">{{$criterioAbogado}}</span>
			<small class="text-danger"> &nbsp;&nbsp;({{count($abogados)}} resultados)</small>
		</h1>
	@endif
	
	@foreach($abogados as $abogado)
		<div class="search-results clearfix smart-form">
			<h4><i class="fa fa-plus-square txt-color-blue"></i>&nbsp;<a href="javascript:void(0);" onclick="seleccioneAbogado('{{$abogado->idAbogado}}');">{{$abogado->nombreAbogado}}</a></h4>
			<div>
				<div class="url text-success">
					@if($abogado->documentoAbogado != "") 
						{{$abogado->documentoAbogado}} 
					@else
						<span class="text-muted">Sin documento registrado</span>
					@endif
					<i class="fa fa-caret-down"></i>
				</div>
				<p class="description">
					@if($abogado->documentoAbogado != "") 
						{{$abogado->tarjetaAbogado}}
					@else
						<span class="text-muted">Tarjeta abogado</span>
					@endif					
				</p>
			</div>
		</div>
	@endforeach			
@else
	<h1 class="font-md"> Resultado de la búsqueda para <span class="semi-bold">{{$criterioAbogado}}</span>
		<small class="text-danger"> &nbsp;&nbsp;(0 resultados)</small>
	</h1>
@endif