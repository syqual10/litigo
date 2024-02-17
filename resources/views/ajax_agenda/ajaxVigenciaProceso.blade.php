<select data-placeholder="Número Proceso.." style="width:300px;" class="chosen-select" tabindex="8" id="selectProceso" name="selectProceso">
	<option value=""></option>
	@if(count($listaProcesosUsuario) > 0)
		@foreach ($listaProcesosUsuario as $proceso)
			<option value="{{$proceso->juriradicados_idRadicado}}">{{$proceso->juriradicados_idRadicado}}</option>   
		@endforeach              
	@else
		No hay procesos
	@endif   
</select>