<select data-placeholder="Seleccionar Ciudad.." class="select2" tabindex="8" id="ciudadOficio" name="ciudad">
<option value=""></option>
  	@if(count($listaDeptos) > 0)
    	@foreach ($listaDeptos as $dep)
      		<optgroup label="{{$dep->nombreDepartamento}}">
                @php 
                    $ciudades = DB::table('ciudades')
	                    ->where('departamentos_idDepartamento', '=', $dep->idDepartamento)
	                    ->get();
                @endphp
              	@foreach ($ciudades as $ciudad)
                	@if($ciudad->idCiudad == $idCiudad)
              			<option value="{{$ciudad->idCiudad}}" selected>{{$ciudad->nombreCiudad}}</option>
              		@else
              			<option value="{{$ciudad->idCiudad}}" >{{$ciudad->nombreCiudad}}</option>
              		@endif
              	@endforeach              
      		</optgroup>              
    	@endforeach 
  	@else
    	No hay departamentos
 	@endif   
</select>