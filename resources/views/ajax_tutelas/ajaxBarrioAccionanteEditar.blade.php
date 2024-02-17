<label class="control-label pull-left">Barrio o Vereda:</label> 
<select data-placeholder="Seleccionar Ciudad.." class="select2" tabindex="8" id="selectBarrioAccionanteEditar" name="selectBarrioAccionanteEditar">
  <option value=""></option>
    @if(count($listaBarrios) > 0)
      	@foreach ($listaBarrios as $barrio)
	        <optgroup label="{{$barrio->nombreTerritorio}}">
	      		@php 
					     $listaSubBarrios = DB::table('subterritorios')
  						    ->where('territorios_idTerritorio', '=', $barrio->idTerritorio)
          				->get();
				    @endphp
				@foreach ($listaSubBarrios as $barrio)
					@if($barrio->idSubTerritorio == $accionante[0]->subterritorios_idSubTerritorio)
						<option value="{{$barrio->idSubTerritorio}}" selected>{{$barrio->nombreSubTerritorio}}</option>
					@else
						<option value="{{$barrio->idSubTerritorio}}">{{$barrio->nombreSubTerritorio}}</option>
					@endif
		        @endforeach              
	        </optgroup>              
      	@endforeach 
    @else
      No hay barrios o comunas
    @endif   
</select>