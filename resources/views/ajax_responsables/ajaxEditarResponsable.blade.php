<div class="modal-body">
	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-3">
					<label class="control-label pull-right">Usuario:</label>
				</div>
				<div class="col-sm-6">
					{{ 
	            		Form::select('selectUsuarioEditar', $listaUsuarios, $responsable[0]->idUsuario, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectUsuarioEditar', 'style' => 'margin-bottom:8px;'])
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
	            		Form::select('selectRolEditar', $listaRoles, $responsable[0]->idRol, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectRolEditar', 'style' => 'margin-bottom:8px;'])
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
	            		Form::select('selectPerfilEditar', $listaPerfiles, $responsable[0]->idPerfil, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectPerfilEditar', 'style' => 'margin-bottom:8px;'])
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
	            		Form::select('selectPuntoEditar', $listaPuntosAtencion, $responsable[0]->juripuntosatencion_idPuntoAtencion, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectPuntoEditar', 'style' => 'margin-bottom:8px;'])
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
					<select class="form-control" id="selectOficiosEditar">
						@if ($responsable[0]->generarOficios == 1)
							<option value="0">No se le permite generar oficios</option>		
							<option value="1" selected>Sí se le permite generar oficios</option>	
						@else
							<option value="0" selected>No se le permite generar oficios</option>	
							<option value="1">Sí se le permite generar oficios</option>	
						@endif
					</select>
				</div>
			</div>
		</div>
	</div>

	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		<button class="btn btn-success btn-editar-responsable"><i class="icon-rocket"></i> <a id="eventUrl" style="color:#fff; text-decoration:none;" onclick="validarEditarResponsable({{$responsable[0]->idResponsable}});">Modificar</a></button>
	</div>
</div>