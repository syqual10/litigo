<div class="modal-body">	
	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-3">
					<label class="control-label pull-right">Nombre Accion Defensa</label>
				</div>
				<div class="col-sm-6">
					<input type="text" id="nombreAccionDefensaEditar" name="nombreAccionDefensaEditar" class="form-control" placeholder="Nombre Accion Defensa" value="{{$accionDefensa[0]->nombreAccion}}">
				</div>
			</div>
		</div>
	</div>

	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		<button class="btn btn-success btn-editar-accionDefensa"><i class="zmdi zmdi-edit"></i> <a id="eventUrl" style="color:#fff; text-decoration:none;" onclick="validarEditarAccionDefensa({{$accionDefensa[0]->idAccion}});">Modificar</a></button>
	</div>
</div>