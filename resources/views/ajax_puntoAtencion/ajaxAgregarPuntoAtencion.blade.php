<div class="modal-body">
	<!-- Row -->
	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-3">
					<label class="control-label pull-right">Nombre</label>
				</div>
				<div class="col-sm-6">
					<input type="text" id="nombrePunto" name="nombrePunto" class="form-control" placeholder="Nombre">
				</div>
			</div>
		</div>
	</div>

	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-3">
					<label class="control-label pull-right">Dirección</label>
				</div>
				<div class="col-sm-6">
					<input type="text" id="direccionPunto" name="direccionPunto" class="form-control" placeholder="Dirección">
				</div>
			</div>
		</div>
	</div>


	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		<button class="btn btn-success btn-guardar-punto"><i class="icon-rocket"></i> <a id="eventUrl" style="color:#fff; text-decoration:none;" onclick="validarGuardarPunto();">Guardar</a></button>
	</div>
</div>