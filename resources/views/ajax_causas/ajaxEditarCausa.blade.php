<div class="modal-body">
	<!-- Row -->
	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-3">
					<label class="control-label pull-right">Nombre Causa</label>
				</div>
				<div class="col-sm-6">
					<input type="text" id="nombreCausaEditar" name="nombreCausaEditar" class="form-control" placeholder="Nombre Causa" value="{{$causa[0]->nombreCausa}}">
				</div>
			</div>
		</div>
	</div>
	<!-- /Row -->

	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		<button class="btn btn-success btn-editar-causa"><i class="zmdi zmdi-edit"></i> <a id="eventUrl" style="color:#fff; text-decoration:none;" onclick="validarEditarCausa({{$causa[0]->idCausa}});">Modificar</a></button>
	</div>
</div>