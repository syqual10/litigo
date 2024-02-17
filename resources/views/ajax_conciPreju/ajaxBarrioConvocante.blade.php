<label class="control-label pull-left">Barrio o Vereda:</label> 
<select data-placeholder="Seleccionar Ciudad.." class="select2" tabindex="8" id="selectBarrioConvocante" name="selectBarrioConvocante">
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
          <option value="{{$barrio->idSubTerritorio}}">{{$barrio->nombreSubTerritorio}}</option>
        @endforeach              
        </optgroup>              
      @endforeach 
    @else
      No hay barrios o comunas
    @endif   
</select>