<div class="modal-body">
	<!-- Row -->
	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-3">
					<label class="control-label pull-right">Nombre</label>
				</div>
				<div class="col-sm-6">
					<input type="text" id="nombrePuntoEditar" name="nombrePuntoEditar" class="form-control" placeholder="Nombre" value="{{$puntoAtencion[0]->nombrePuntoAtencion}}">
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
					<input type="text" id="direccionPuntoEditar" name="direccionPuntoEditar" class="form-control" placeholder="Dirección" value="{{$puntoAtencion[0]->direccionPuntoAtencion}}">
				</div>
			</div>
		</div>
	</div>


	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		<button class="btn btn-success btn-editar-punto"><i class="icon-rocket"></i> <a id="eventUrl" style="color:#fff; text-decoration:none;" onclick="validarEditarPunto({{$puntoAtencion[0]->idPuntoAtencion}});">Modificar</a></button>
	</div>
</div>