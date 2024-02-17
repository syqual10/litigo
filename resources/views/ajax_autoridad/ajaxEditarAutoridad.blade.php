<div class="modal-body">	
	<!-- Row -->
	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-3">
					<label class="control-label pull-right">Nombre Autoridad Conocedora</label>
				</div>
				<div class="col-sm-6">
					<input type="text" id="nombreAutoridadEditar" name="nombreAutoridadEditar" class="form-control" placeholder="Nombre Autoridad Conocedora" value="{{$autoridad[0]->nombreAutoridadConoce}}">
				</div>
			</div>
		</div>
	</div>

	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		<button class="btn btn-success btn-editar-autoridad"><i class="zmdi zmdi-edit"></i> <a id="eventUrl" style="color:#fff; text-decoration:none;" onclick="validarModificarAutoridad({{$autoridad[0]->idAutoridadConoce}});">Modificar</a></button>
	</div>
</div>