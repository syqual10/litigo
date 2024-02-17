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
					<input type="text" id="distrito" name="distrito" class="form-control" placeholder="Distrito">
					<!--<select class="select2 form-control" onchange="ciudades($(this).find(':selected').data('id'), 'circuito')">
						@foreach($departamentos as $departamento)
						<option data-id="{{$departamento->idDepartamento}}" value="{{$departamento->nombreDepartamento}}">{{$departamento->nombreDepartamento}}</option>
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
					<label class="control-label pull-right">Circuito:</label>
				</div>
				<div class="col-sm-6">
					<input type="text" id="circuito" name="circuito" class="form-control" placeholder="Circuito">
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
					<select class="select2 form-control" id="departamento" onchange="ciudades($(this).find(':selected').data('id'), 'municipio')">
						<option value=""></option>
						@foreach($departamentos as $departamento)
						<option data-id="{{$departamento->idDepartamento}}" value="{{$departamento->nombreDepartamento}}">{{$departamento->nombreDepartamento}}</option>
						@endforeach
					</select>
				</div>
			</div>
		</div>
	</div>

    <div class="row municipio" style="margin-bottom: 15px;">
	
	</div>

    <div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-3">
					<label class="control-label pull-right">Código Unico:</label>
				</div>
				<div class="col-sm-6">
                    <input type="text" id="codigo" name="codigo" class="form-control" placeholder="Nombre Dependencia">
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
                <input type="text" id="nombreJuzgado" name="nombreJuzgado" class="form-control" placeholder="Nombre Dependencia">
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
                <input type="text" id="correo" name="correo" class="form-control" placeholder="Nombre Dependencia">
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
                    <input type="text" id="direccion" name="direccion" class="form-control" placeholder="Nombre Dependencia">
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
                    <input type="text" id="telefono" name="telefono" class="form-control" placeholder="Nombre Dependencia">
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
					<input type="text" id="horario" name="horario" class="form-control" placeholder="Ejemplo: 8:00 a.m. - 1:00 p.m. y 2:00 p.m. a 5:00 p.m.">
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
                    <select data-placeholder="Seleccionar Area" class="select2" tabindex="8" id="area" name="area">
                        <option value=""></option>
                        <option value="JUDICIAL">JUDICIAL</option>
                        <option value="ADMINISTRATIVA">ADMINISTRATIVA</option>
                        <option value="DESCONGESTIÓN">DESCONGESTIÓN</option>
                    </select>
				</div>
			</div>
		</div>
	</div>

	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		<button class="btn btn-success btn-guardar-juzgado"><i class="icon-rocket"></i> <a id="eventUrl" style="color:#fff; text-decoration:none;" onclick="validarGuardarJuzgado();">Agregar</a></button>
	</div>
</div>