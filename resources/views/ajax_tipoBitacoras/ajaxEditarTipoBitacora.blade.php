<div class="modal-body">	
	<!-- Row -->
	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-3">
					<label class="control-label pull-right">Nombre Tipo Bitácora</label>
				</div>
				<div class="col-sm-6">
					<input type="text" id="nombreTipoBitacoraEditar" name="nombreTipoBitacoraEditar" class="form-control" placeholder="Nombre Tipo Bitácora" value="{{$tipoBitacora[0]->nombreTipoBitacora}}">
				</div>
			</div>
		</div>
	</div>
	<!-- /Row -->

	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		<button class="btn btn-success btn-editar-tipoBitacora"><i class="zmdi zmdi-edit"></i> <a id="eventUrl" style="color:#fff; text-decoration:none;" onclick="validarEditarTipoBitacora({{$tipoBitacora[0]->idTipoBitacora}});">Modificar</a></button>
	</div>
</div>