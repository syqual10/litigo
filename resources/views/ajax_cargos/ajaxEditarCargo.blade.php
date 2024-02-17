<div class="modal-body">
	<!-- Row -->
	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-3">
					<label class="control-label pull-right">Código Cargo</label>
				</div>
				<div class="col-sm-6">
					<input type="text" id="codigoCargoEditar" name="codigoCargoEditar" class="form-control" placeholder="Código Cargo" value="{{$cargo[0]->codigoCargo}}">
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
					<input type="text" id="nombreCargoEditar" name="nombreCargoEditar" class="form-control" placeholder="Nombre Cargo" value="{{$cargo[0]->nombreCargo}}">
				</div>
			</div>
		</div>
	</div>
	<!-- /Row -->

	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		<button class="btn btn-success btn-editar-cargo"><i class="zmdi zmdi-edit"></i> <a id="eventUrl" style="color:#fff; text-decoration:none;" onclick="validarEditarCargo({{$cargo[0]->idCargo}});">Modificar</a></button>
	</div>
</div>