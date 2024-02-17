<!-- Row -->
<div class="row" style="margin-bottom: 15px;" >
	<div class="form-wrap">
		<div class="form-group">
			<div class="col-sm-3">
				<label class="control-label pull-right">Nombre Tipo Proceso</label>
			</div>
			<div class="col-sm-6">
				<input type="text" id="nombreTipoProcesoEditar" name="nombreTipoProcesoEditar" class="form-control" placeholder="Nombre Tipo Proceso" value="{{$tipoProceso[0]->nombreTipoProceso}}">
			</div>
		</div>
	</div>
</div>

<div class="row" style="margin-bottom: 15px;" >
	<div class="form-wrap">
		<div class="form-group">
			<div class="col-sm-3">
				<label class="control-label pull-right">Orden Tipo Proceso</label>
			</div>
			<div class="col-sm-6">
				<input type="text" id="ordenTipoProcesoEditar" name="ordenTipoProcesoEditar" class="form-control" placeholder="Orden Tipo Proceso" value="{{$tipoProceso[0]->ordenProceso}}">
			</div>
		</div>
	</div>
</div>
<!-- /Row -->

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	<button class="btn btn-success btn-editar-tipoProceso"><i class="zmdi zmdi-edit"></i> <a id="eventUrl" style="color:#fff; text-decoration:none;" onclick="validarEditarTipoProceso({{$tipoProceso[0]->idTipoProcesos}});">Modificar</a></button>
</div>