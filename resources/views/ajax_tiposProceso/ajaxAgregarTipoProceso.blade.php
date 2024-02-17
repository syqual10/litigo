<!-- Row -->
<div class="row" style="margin-bottom: 15px;" >
	<div class="form-wrap">
		<div class="form-group">
			<div class="col-sm-3">
				<label class="control-label pull-right">Nombre Tipo Proceso</label>
			</div>
			<div class="col-sm-6">
				<input type="text" id="nombreTipoProceso" name="nombreTipoProceso" class="form-control" placeholder="Nombre Tipo Proceso">
			</div>
		</div>
	</div>
</div>

<div class="row" style="margin-bottom: 15px;" >
	<div class="form-wrap">
		<div class="form-group">
			<div class="col-sm-3">
				<label class="control-label pull-right">Orden Tipo Proceso</label>
			</div>
			<div class="col-sm-6">
				<input type="number" id="ordenTipoProceso" name="ordenTipoProceso" class="form-control" placeholder="Orden Tipo Proceso">
			</div>
		</div>
	</div>
</div>
<!-- /Row -->

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	<button class="btn btn-success btn-guardar-tipoProceso"><i class="icon-rocket"></i> <a id="eventUrl" style="color:#fff; text-decoration:none;" onclick="validarGuardarTipoProceso();">Guardar</a></button>
</div>