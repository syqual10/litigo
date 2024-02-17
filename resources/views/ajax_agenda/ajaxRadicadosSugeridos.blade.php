<div class="row">
	@if(count($radicadoSugeridos) > 0)
		@foreach($radicadoSugeridos as $radicadoAugerido)
			<div class="col-sm-4">
				<span class="url text-success">
					<a href="javascript:void(0);" onclick="seleccionarSugerido('{{$radicadoAugerido->vigenciaRadicado}}', {{$radicadoAugerido->idRadicado}});">
						{{substr($radicadoAugerido->codigoProceso, 0, 12)}}
					</a>
				</span>
			</div>

			<div class="col-sm-8">
				<span class="url text-success">
					{{$radicadoAugerido->nombreJuzgado}}
				</span>
			</div>
		@endforeach
	@endif
</div>