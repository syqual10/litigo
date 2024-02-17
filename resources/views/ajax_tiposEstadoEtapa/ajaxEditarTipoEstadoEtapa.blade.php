<div class="modal-body">
	<!-- Row -->
	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-3">
					<label class="control-label pull-right">Nombre Tipo Estado Etapa</label>
				</div>
				<div class="col-sm-6">
					<input type="text" id="nombreTipoEstadoEtapaEditar" name="nombreTipoEstadoEtapaEditar" class="form-control" placeholder="Nombre Tipo Estado Etapa" value="{{$tipoEstadoEtapa[0]->nombreTipoEstadoEtapa}}">
				</div>
			</div>
		</div>
	</div>
	<!-- /Row -->

	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		<button class="btn btn-success btn-editar-tipoEstadoEtapa"><i class="zmdi zmdi-edit"></i> <a id="eventUrl" style="color:#fff; text-decoration:none;" onclick="validarEditarTipoEstadoEtapa({{$tipoEstadoEtapa[0]->idTipoEstadoEtapa}});">Modificar</a></button>
	</div>
</div>