<div class="modal-body">	
	<!-- Row -->
	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-3">
					<label class="control-label pull-right">Nombre Impacto</label>
				</div>
				<div class="col-sm-6">
					<input type="text" id="nombreImpactoEditar" name="nombreImpactoEditar" class="form-control" placeholder="Nombre Impacto" value="{{$impacto[0]->nombreImpacto}}">
				</div>
			</div>
		</div>
	</div>
	<!-- /Row -->

	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		<button class="btn btn-success btn-editar-impacto"><i class="zmdi zmdi-edit"></i> <a id="eventUrl" style="color:#fff; text-decoration:none;" onclick="validarEditarImpacto({{$impacto[0]->idImpacto}});">Modificar</a></button>
	</div>
</div>