<br>
@if(count($temas) > 0)
	@if(count($temas) == 1)
		<h1 class="font-md"> Resultado de la búsqueda para <span class="semi-bold">{{$criterioTema}}</span>
			<small class="text-danger"> &nbsp;&nbsp;(1 resultado)</small>
		</h1>
	@else
		<h1 class="font-md"> Resultado de la búsqueda para <span class="semi-bold">{{$criterioTema}}</span>
			<small class="text-danger"> &nbsp;&nbsp;({{count($temas)}} resultados)</small>
		</h1>
	@endif
	
	@foreach($temas as $tema)
		<div class="search-results clearfix smart-form">
			<h9>
				<i class="fa fa-plus-square txt-color-blue"></i>&nbsp;
				<a href="javascript:void(0);" onclick="seleccioneTema('{{$tema->nombreTema}}', {{$tema->idTema}});">{{$tema->nombreTema}}</a>
			</h9>
		</div>
	@endforeach			
@else
	<h1 class="font-md"> Resultado de la búsqueda para <span class="semi-bold">{{$criterioTema}}</span>
		<small class="text-danger"> &nbsp;&nbsp;(0 resultados)</small>
	</h1>
@endif