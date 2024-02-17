<div class="modal-body">	
	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-3">
					<label class="control-label pull-right">Nombre Perfil</label>
				</div>
				<div class="col-sm-6">
					<input type="text" id="nombrePerfilEditar" name="nombrePerfilEditar" class="form-control" placeholder="Nombre Perfil" value="{{$perfil[0]->nombrePerfil}}">
				</div>
			</div>
		</div>
	</div>

	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		<button class="btn btn-success btn-editar-perfil"><i class="zmdi zmdi-edit"></i> <a id="eventUrl" style="color:#fff; text-decoration:none;" onclick="validarEditarPerfil({{$perfil[0]->idPerfil}});">Modificar</a></button>
	</div>
</div>