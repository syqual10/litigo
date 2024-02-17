<div class="modal-body">
	<!-- Row -->
	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-3">
					<label class="control-label pull-right">Nombre del medio de control</label>
				</div>
				<div class="col-sm-6">
					<input type="text" id="nombreMedioControlEditar" name="nombreMedioControlEditar" class="form-control" placeholder="Nombre del medio de control" value="{{$medioControl[0]->nombreMedioControl}}">
				</div>
			</div>
		</div>
	</div>
	<!-- /Row -->

	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		<button class="btn btn-success btn-editar-medioControl"><i class="zmdi zmdi-edit"></i> <a id="eventUrl" style="color:#fff; text-decoration:none;" onclick="validarEditarMedioControl({{$medioControl[0]->idMediosControl}});">Modificar</a></button>
	</div>
</div>