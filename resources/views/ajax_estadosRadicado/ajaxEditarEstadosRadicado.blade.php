<div class="modal-body">	
	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-3">
					<label class="control-label pull-right">Nombre Estado Radicado</label>
				</div>
				<div class="col-sm-6">
					<input type="text" id="nombreEstadoRadicadoEditar" name="nombreEstadoRadicadoEditar" class="form-control" placeholder="Nombre Estado Radicado" value="{{$estadosRadicado[0]->nombreEstadoRadicado}}">
				</div>
			</div>
		</div>
	</div>

	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		<button class="btn btn-success btn-editar-estadoRadicado"><i class="zmdi zmdi-edit"></i> <a id="eventUrl" style="color:#fff; text-decoration:none;" onclick="validarEditarEstadoRadicado({{$estadosRadicado[0]->idEstadoRadicado}});">Modificar</a></button>
	</div>
</div>