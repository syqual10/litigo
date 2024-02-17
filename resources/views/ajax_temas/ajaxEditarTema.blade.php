<div class="modal-body">
	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-3">
					<label class="control-label pull-right">Nombre Tema</label>
				</div>
				<div class="col-sm-6">
					<input type="text" id="nombreTemaEditar" name="nombreTemaEditar" class="form-control" placeholder="Nombre Tema" value="{{$tema[0]->nombreTema}}">
				</div>
			</div>
		</div>
	</div>

	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		<button class="btn btn-success btn-editar-tema"><i class="zmdi zmdi-edit"></i> <a id="eventUrl" style="color:#fff; text-decoration:none;" onclick="validarEditarTema({{$tema[0]->idTema}});">Modificar</a></button>
	</div>
</div>