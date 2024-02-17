<div class="modal-body">	
	<!-- Row -->
	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-3">
					<label class="control-label pull-right">Código Cargo</label>
				</div>
				<div class="col-sm-6">
					<input type="text" id="codigoCargo" name="codigoCargo" class="form-control" placeholder="Código Cargo">
				</div>
			</div>
		</div>
	</div>

	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-3">
					<label class="control-label pull-right">Nombre Cargo</label>
				</div>
				<div class="col-sm-6">
					<input type="text" id="nombreCargo" name="nombreCargo" class="form-control" placeholder="Nombre Cargo">
				</div>
			</div>
		</div>
	</div>
	<!-- /Row -->

	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		<button class="btn btn-primary btn-guardar-cargo"><i class="icon-rocket"></i> <a id="eventUrl" style="color:#fff; text-decoration:none;" onclick="validarGuardarCargo();">Guardar</a></button>
	</div>
</div>