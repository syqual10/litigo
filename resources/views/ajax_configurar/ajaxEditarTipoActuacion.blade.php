<div class="modal-body">	
	<!-- Row -->
	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-3">
					<label class="control-label pull-right">Nombre tipo actuación</label>
				</div>
				<div class="col-sm-6">
					<input type="text" id="nombreTipoActuacionEditar" name="nombreTipoActuacionEditar" class="form-control" placeholder="Nombre tipo de actuación" value="{{$tipoActuacion[0]->nombreActuacion}}">
				</div>
			</div>
		</div>
	</div>

	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-3">
					<label class="control-label pull-right">¿Finaliza proceso?</label>
				</div>
				<div class="col-sm-6">
		      		<select name="selectFinalizaEditar" class="form-control" id="selectFinalizaEditar">
			            <option value="">Seleccione</option>
			            @if($tipoActuacion[0]->tipoActuacionFinaliza == 1)
			            	<option value="1" selected>Sí</option>
			            	<option value="0">No</option>
			            @else
			            	<option value="1">Sí</option>
			            	<option value="0" selected>No</option>
			            @endif
		          	</select>
				</div>
			</div>
		</div>
	</div>

	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-3">
					<label class="control-label pull-right">Fallo?</label>
				</div>
				<div class="col-sm-6">
		      		<select name="selectFalloEditar" class="form-control" id="selectFalloEditar">
			            <option value="">Seleccione</option>
			            @if($tipoActuacion[0]->tipoFallo == 1)
			            	<option value="1" selected>Sí</option>
			            	<option value="0">No</option>
			            @else
			            	<option value="1">Sí</option>
			            	<option value="0" selected>No</option>
			            @endif
		          	</select>
				</div>
			</div>
		</div>
	</div>

	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		<button class="btn btn-success btn-editar-tipoActuacion"><i class="icon-rocket"></i> <a id="eventUrl" style="color:#fff; text-decoration:none;" onclick="validarEditarTipoActuacion({{$tipoActuacion[0]->idTipoActuacion}});">Modificar</a></button>
	</div>
</div>