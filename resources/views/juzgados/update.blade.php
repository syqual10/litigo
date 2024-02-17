<div class="modal-body">
	<!-- Row -->
	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-3">
					<label class="control-label pull-right">Jurisdiccion:</label>
				</div>
				<div class="col-sm-6">
                    <select data-placeholder="Seleccionar Jurisdiccion" class="select2" tabindex="8" id="jurisdiccionJuzgado" name="jurisdiccionJuzgado">
						<option value=""></option>
                        <option value="ORDINARIA">ORDINARIA</option>
                        <option value="CONTENCIOSO ADMINISTRATIVO">CONTENCIOSO ADMINISTRATIVO</option>
                        <option value="DISCIPLINARIA / N.A.">DISCIPLINARIA / N.A.</option>
                        <option value="CONSTITUCIONAL">CONSTITUCIONAL</option>
						<option value="CONSEJO SUPERIOR DE LA JUDICATURA">CONSEJO SUPERIOR DE LA JUDICATURA</option>
                    </select>
                </div>
			</div>
		</div>
	</div>

	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-3">
					<label class="control-label pull-right">Distrito:</label>
				</div>
				<div class="col-sm-6">
					<input type="text" id="distrito" name="distrito" value="{{$juzgado->distritoJuzgado}}" class="form-control" placeholder="Distrito">
				</div>
			</div>
		</div>
	</div>

	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-3">
					<label class="control-label pull-right">Circuito:</label>
				</div>
				<div class="col-sm-6">
					<input type="text" id="circuito" name="circuito" value="{{$juzgado->circuitoJuzgado}}" class="form-control" placeholder="Circuito">
					<!--<select class="select2 form-control" value="{{$juzgado->distritoJuzgado}}" onchange="ciudades($(this).find(':selected').data('id'), 'circuito')">
						@foreach($departamentos as $departamento)
							@if($departamento->nombreDepartamento == $juzgado->distritoJuzgado)
								<script>
									ciudades('{{$departamento->idDepartamento}}', 'circuito', '{{$juzgado->circuitoJuzgado}}')
								</script>
								<option data-id="{{$departamento->idDepartamento}}" value="{{$departamento->nombreDepartamento}}" selected>{{$departamento->nombreDepartamento}}</option>
							@else
								<option data-id="{{$departamento->idDepartamento}}" value="{{$departamento->nombreDepartamento}}">{{$departamento->nombreDepartamento}}</option>
							@endif
						@endforeach
					</select>-->
				</div>
			</div>
		</div>
	</div>

	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-3">
					<label class="control-label pull-right">Departamento:</label>
				</div>
				<div class="col-sm-6">
					<select id="departamento" class="select2 form-control" onchange="ciudades($(this).find(':selected').data('id'), 'municipio')">
						<option value=""></option>
						@foreach($departamentos as $departamento)
							@if($departamento->nombreDepartamento == $juzgado->departamentoJuzgado)
								<script>
									ciudades('{{$departamento->idDepartamento}}', 'municipio2', '{{$juzgado->municipioJuzgado}}')
								</script>
								<option data-id="{{$departamento->idDepartamento}}" value="{{$departamento->nombreDepartamento}}" selected>{{$departamento->nombreDepartamento}}</option>
							@else
								<option data-id="{{$departamento->idDepartamento}}" value="{{$departamento->nombreDepartamento}}">{{$departamento->nombreDepartamento}}</option>
							@endif
						@endforeach
					</select>
				</div>
			</div>
		</div>
	</div>

    <div class="row municipio2" style="margin-bottom: 15px;">
	
	</div>

    <div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-3">
					<label class="control-label pull-right">Código Unico:</label>
				</div>
				<div class="col-sm-6">
                    <input type="text" id="codigo" value="{{$juzgado->codigoUnicoJuzgado}}" name="codigo" class="form-control" placeholder="Nombre Dependencia">
				</div>
			</div>
		</div>
	</div>

	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-3">
					<label class="control-label pull-right">Nombre:</label>
				</div>
				<div class="col-sm-6">
                <input type="text" id="nombreJuzgado" name="nombreJuzgado" value="{{$juzgado->nombreJuzgado}}" class="form-control" placeholder="Nombre Dependencia">
				</div>
			</div>
		</div>
	</div>

	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-3">
					<label class="control-label pull-right">Correo:</label>
				</div>
				<div class="col-sm-6">
                <input type="text" id="correo" name="correo" value="{{$juzgado->correoJuzgado}}" class="form-control" placeholder="Nombre Dependencia">
				</div>
			</div>
		</div>
	</div>

    <div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-3">
					<label class="control-label pull-right">Direccion:</label>
				</div>
				<div class="col-sm-6">
                    <input type="text" id="direccion" name="direccion" value="{{$juzgado->direccionJuzgado}}" class="form-control" placeholder="Nombre Dependencia">
				</div>
			</div>
		</div>
	</div>

    <div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-3">
					<label class="control-label pull-right">Telefono:</label>
				</div>
				<div class="col-sm-6">
                    <input type="text" id="telefono" name="telefono" value="{{$juzgado->telefonoJuzgado}}" class="form-control" placeholder="Nombre Dependencia">
				</div>
			</div>
		</div>
	</div>

    <div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-3">
					<label class="control-label pull-right">Horario:</label>
				</div>
				<div class="col-sm-6">
					<input type="text" id="horario" name="horario" value="{{$juzgado->horarioJuzgado}}" class="form-control" placeholder="Ejemplo: 8:00 a.m. - 1:00 p.m. y 2:00 p.m. a 5:00 p.m.">
				</div>
			</div>
		</div>
	</div>

    <div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-3">
					<label class="control-label pull-right">Area:</label>
				</div>
				<div class="col-sm-6">
                    <select data-placeholder="Seleccionar Area" id="area" class="form-control" name="area">
                        <option value=""></option>
                        <option value="JUDICIAL">JUDICIAL</option>
                        <option value="ADMINISTRATIVA">ADMINISTRATIVA</option>
                        <option value="DESCONGESTIÓN">DESCONGESTIÓN</option>
                    </select>
				</div>
			</div>
		</div>
	</div>




	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-3">
					<label class="control-label pull-right">Juzgado Activo:</label>
				</div>
				<div class="col-sm-6">
					<span class="onoffswitch pull-left">
						@if($juzgado->activoJuzgado == 1)
							<input type="checkbox" name="estado" class="onoffswitch-checkbox" id="estado" checked>
						@else
							<input type="checkbox" name="estado" class="onoffswitch-checkbox" id="estado">
						@endif
	                    <label class="onoffswitch-label" for="estado">
	                        <span class="onoffswitch-inner" data-swchon-text="SI" data-swchoff-text="NO"></span>
	                        <span class="onoffswitch-switch"></span>
	                    </label>
	                </span>
				</div>
			</div>
		</div>
	</div>

















	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		<button class="btn btn-success btn-editar-juzgado"><i class="icon-rocket"></i> <a id="eventUrl" style="color:#fff; text-decoration:none;" onclick="validarEditarJuzgado({{$juzgado->idJuzgado}});">Modificar</a></button>
	</div>
</div>

<script>
	$('#area option[value="{{$juzgado->areaJuzgado}}"]').prop('selected', true)
	$('#jurisdiccionJuzgado option[value="{{$juzgado->jurisdiccionJuzgado}}"]').prop('selected', true)
</script>