<div class="modal-body">	
	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-2">
					<label class="control-label pull-left">Tipo de identificación</label>
				</div>
				<div class="col-sm-4">
					{{ 
	            		Form::select('selectTipoIdentificacionEditar', $listaTipoIdentificacion, $usuario[0]->tiposidentificacion_idTipoIdentificacion, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'class' => 'select2','id'=>'selectTipoIdentificacionEditar', 'style' => 'margin-bottom:8px;'])
	        		}}
				</div>

				<div class="col-sm-2">
					<label class="control-label">Lugar de expedición</label>
				</div>
				<div class="col-sm-4">
					<input type="text" id="lugarExpedicionEditar" name="lugarExpedicionEditar" class="form-control" placeholder="Lugar de expedición" value="{{$usuario[0]->expedicionSolicitante}}">
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
					<input type="text" id="documentoUsuarioEditar" name="documentoUsuarioEditar" class="form-control" placeholder="Documento Usuario" onkeypress="return justNumbers(event);" onBlur="copiar();" value="{{$usuario[0]->documentoUsuario}}">
				</div>

				<div class="col-sm-2">
					<label class="control-label">Login</label>
				</div>
				<div class="col-sm-4">
					<input type="text" id="loginUsuarioEditar" name="loginUsuarioEditar" class="form-control" placeholder="Login" style="text-transform:lowercase;" readonly value="{{$usuario[0]->loginUsuario}}">
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
					<input type="text" id="nombreUsuarioEditar" name="nombreUsuarioEditar" class="form-control" placeholder="Nombre Usuario" value="{{$usuario[0]->nombresUsuario}}">
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
					<input type="email" id="emailUsuarioEditar" name="emailUsuarioEditar" class="form-control" placeholder="Email Usuario" style="text-transform:lowercase;" value="{{$usuario[0]->emailUsuario}}">
				</div>

				<div class="col-sm-2">
					<label class="control-label">Celular</label>
				</div>
				<div class="col-sm-4">
					<input type="text" id="celularUsuarioEditar" name="celularUsuarioEditar" class="form-control" placeholder="Celular" value="{{$usuario[0]->celularUsuario}}">
				</div>
			</div>
		</div>
	</div>

	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-2">
					<label class="control-label pull-left">Dependencia</label>
				</div>
				<div class="col-sm-4">
					{{ 
	            		Form::select('selectDependenciaEditar', $listaDependencias, $usuario[0]->dependencias_idDependencia, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectDependenciaEditar', 'style' => 'margin-bottom:8px;'])
	        		}}
				</div>

				<div class="col-sm-2">
					<label class="control-label">Cargo</label>
				</div>
				<div class="col-sm-4">
					{{ 
	            		Form::select('selectCargosEditar', $listaCargos, $usuario[0]->cargos_idCargo, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectCargosEditar', 'style' => 'margin-bottom:8px;'])
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
	            		Form::select('selectDepartamentosEditar', $listaDepartamentos, $usuario[0]->idDepartamento, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectDepartamentosEditar', 'style' => 'margin-bottom:8px;' , 'onchange' => 'cargarCiudadEditar(this.value)'])
	        		}}
				</div>

				<div id="resultadoCargarCiudadEditar">
					<div class="col-sm-2">
						<label class="control-label pull-left">Ciudad</label>
					</div>
					<div class="col-sm-4">
						{{ 
							Form::select('selectCiudadEditar', $listaCiudades, $usuario[0]->ciudades_idCiudad, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectCiudadEditar', 'style' => 'margin-bottom:8px;'])
						}}
					</div>
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
	            		Form::select('selectRolEditar', $listaRoles, $usuario[0]->roles_idRol, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectRolEditar', 'style' => 'margin-bottom:8px;'])
	        		}}
				</div>
			</div>
		</div>
	</div>

	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		<button class="btn btn-success btn-editar-usuario"><i class="zmdi zmdi-edit"></i> <a id="eventUrl" style="color:#fff; text-decoration:none;" onclick="validarEditarUsuario({{$usuario[0]->idUsuario}});">Modificar</a></button>
	</div>
</div>