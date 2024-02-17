<div class="modal-body">	
	<!-- Row -->
	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-3">
					<label class="control-label pull-right">Nombre tipo actuación</label>
				</div>
				<div class="col-sm-6">
					<input type="text" id="nombreTipoActuacion" name="nombreTipoActuacion" class="form-control" placeholder="Nombre tipo de actuación">
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
		      		<select name="selectFinaliza" class="form-control" id="selectFinaliza">
			            <option value="">Seleccione</option>
			            <option value="1">Sí</option>
			            <option value="0">No</option>
		          	</select>
				</div>
			</div>
		</div>
	</div>

	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-3">
					<label class="control-label pull-right">¿Fallo?</label>
				</div>
				<div class="col-sm-6">
		      		<select name="selectFallo" class="form-control" id="selectFallo">
			            <option value="">Seleccione</option>
			            <option value="1">Sí</option>
			            <option value="0">No</option>
		          	</select>
				</div>
			</div>
		</div>
	</div>

	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		<button class="btn btn-success btn-guardar-tipoActuacion"><i class="icon-rocket"></i> <a id="eventUrl" style="color:#fff; text-decoration:none;" onclick="validarGuardarTipoActuacion();">Guardar</a></button>
	</div>
</div>