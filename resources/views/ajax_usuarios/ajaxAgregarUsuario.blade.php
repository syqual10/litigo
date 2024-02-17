<div class="modal-body">	
	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-2">
					<label class="control-label pull-left">Tipo de identificación:</label>
				</div>
				<div class="col-sm-4">
					{{ 
	            		Form::select('selectTipoIdentificacion', $listaTipoIdentificacion, null, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'class' => 'select2','id'=>'selectTipoIdentificacion', 'style' => 'margin-bottom:8px;'])
	        		}}
				</div>

				<div class="col-sm-2">
					<label class="control-label">Lugar de expedición</label>
				</div>
				<div class="col-sm-4">
					<input type="text" id="lugarExpedicion" name="lugarExpedicion" class="form-control" placeholder="Lugar de expedición">
				</div>
			</div>
		</div>
	</div>

	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-2">
					<label class="control-label pull-left">Documento</label>
				</div>
				<div class="col-sm-4">
					<input type="text" id="documentoUsuario" name="documentoUsuario" class="form-control" placeholder="Documento Usuario" onkeypress="return justNumbers(event);" onBlur="copiar();">
				</div>

				<div class="col-sm-2">
					<label class="control-label">Login</label>
				</div>
				<div class="col-sm-4">
					<input type="text" id="loginUsuario" name="loginUsuario" class="form-control" placeholder="Login" style="text-transform:lowercase;" readonly>
				</div>
			</div>
		</div>
	</div>

	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-2">
					<label class="control-label pull-left">Nombres</label>
				</div>
				<div class="col-sm-4">
					<input type="text" id="nombreUsuario" name="nombreUsuario" class="form-control" placeholder="Nombre Usuario">
				</div>

				<div class="col-sm-2">
					<label class="control-label">Apellidos</label>
				</div>
				<div class="col-sm-4">
					<input type="text" id="apellidoUsuario" name="apellidoUsuario" class="form-control" placeholder="Apellidos">
				</div>
			</div>
		</div>
	</div>

	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-2">
					<label class="control-label pull-left">Email</label>
				</div>
				<div class="col-sm-4">
					<input type="email" id="emailUsuario" name="emailUsuario" class="form-control" placeholder="Email Usuario" style="text-transform:lowercase;">
				</div>

				<div class="col-sm-2">
					<label class="control-label">Celular</label>
				</div>
				<div class="col-sm-4">
					<input type="text" id="celularUsuario" name="celularUsuario" class="form-control" placeholder="Celular">
				</div>
			</div>
		</div>
	</div>

	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-2">
					<label class="control-label pull-left">Dependencias:</label>
				</div>
				<div class="col-sm-4">
					{{ 
	            		Form::select('selectDependencia', $listaDependencias, null, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectDependencia', 'style' => 'margin-bottom:8px;'])
	        		}}
				</div>

				<div class="col-sm-2">
					<label class="control-label">Cargos:</label>
				</div>
				<div class="col-sm-4">
					{{ 
	            		Form::select('selectCargos', $listaCargos, null, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectCargos', 'style' => 'margin-bottom:8px;'])
	        		}}
				</div>
			</div>
		</div>
	</div>

	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-2">
					<label class="control-label pull-left">Departamento</label>
				</div>
				<div class="col-sm-4">
					{{ 
	            		Form::select('selectDepartamentos', $listaDepartamentos, null, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectDepartamentos', 'style' => 'margin-bottom:8px;' , 'onchange' => 'cargarCiudad(this.value)'])
	        		}}
				</div>

				<div id="resultadoCargarCiudad">
					<!-- CARGA AJAX -->    
				</div> 
			</div>
		</div>
	</div>

	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-2">
					<label class="control-label pull-left">Rol</label>
				</div>
				<div class="col-sm-4">
					{{ 
	            		Form::select('selectRol', $listaRoles, null, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectRol', 'style' => 'margin-bottom:8px;'])
	        		}}
				</div>
			</div>
		</div>
	</div>

	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		<button class="btn btn-success btn-guardar-usuario"><i class="icon-rocket"></i> <a id="eventUrl" style="color:#fff; text-decoration:none;" onclick="validarGuardarUsuario();">Guardar</a></button>
	</div>
</div>