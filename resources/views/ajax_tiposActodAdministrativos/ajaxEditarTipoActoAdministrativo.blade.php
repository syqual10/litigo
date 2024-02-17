<div class="modal-body">	
	<!-- Row -->
	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-3">
					<label class="control-label pull-right">Nombre Tipo Acto Administrativo</label>
				</div>
				<div class="col-sm-6">
					<input type="text" id="nombreTipoActoEditar" name="nombreTipoActoEditar" class="form-control" placeholder="Nombre Tipo Acto Administrativo" value="{{$tipoActo[0]->nombreTipoActo}}">
				</div>
			</div>
		</div>
	</div>
	<!-- /Row -->

	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		<button class="btn btn-success btn-editar-tipoacto"><i class="zmdi zmdi-edit"></i> <a id="eventUrl" style="color:#fff; text-decoration:none;" onclick="validarEditarTipoActo({{$tipoActo[0]->idTipoActo}});">Modificar</a></button>
	</div>
</div>