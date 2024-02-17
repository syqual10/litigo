<div class="modal-body">
	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-3">
					<label class="control-label pull-right">Usuario:</label>
				</div>
				<div class="col-sm-6">
					{{ 
	            		Form::select('selectUsuario', $listaUsuarios, null, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectUsuario', 'style' => 'margin-bottom:8px;'])
	        		}}
				</div>
			</div>
		</div>
	</div>

	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-3">
					<label class="control-label pull-right">Rol:</label>
				</div>
				<div class="col-sm-6">
					{{ 
	            		Form::select('selectRol', $listaRoles, null, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectRol', 'style' => 'margin-bottom:8px;'])
	        		}}
				</div>
			</div>
		</div>
	</div>

	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-3">
					<label class="control-label pull-right">Perfil:</label>
				</div>
				<div class="col-sm-6">
					{{ 
	            		Form::select('selectPerfil', $listaPerfiles, null, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectPerfil', 'style' => 'margin-bottom:8px;'])
	        		}}
				</div>
			</div>
		</div>
	</div>


	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-3">
					<label class="control-label pull-right">Punto de atención:</label>
				</div>
				<div class="col-sm-6">
					{{ 
	            		Form::select('selectPunto', $listaPuntosAtencion, null, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectPunto', 'style' => 'margin-bottom:8px;'])
	        		}}
				</div>
			</div>
		</div>
	</div>

	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-3">
					<label class="control-label pull-right">Generar oficios:</label>
				</div>
				<div class="col-sm-6">
					<select class="form-control" id="selectOficios">
						<option value="0">No se le permite generar oficios</option>
						<option value="1">Sí se le permite generar oficios</option>
					</select>
				</div>
			</div>
		</div>
	</div>

	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		<button class="btn btn-success btn-guardar-responsable"><i class="icon-rocket"></i> <a id="eventUrl" style="color:#fff; text-decoration:none;" onclick="validarGuardarResponsable();">Guardar</a></button>
	</div>
</div>