<div class="modal-body">
	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-3">
					<label class="control-label pull-right">Funcionarios:</label>
				</div>
				<div class="col-sm-6">
					{{ 
	            		Form::select('selectRespInterno', $listaResponsablesInt, null, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectRespInterno', 'style' => 'margin-bottom:8px;'])
	        		}}
				</div>
			</div>
		</div>
	</div>

	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-3">
					<label class="control-label pull-right">Comentario:</label>
				</div>
				<div class="col-sm-6">
					<textarea name="comentarioReparto" id="comentarioReparto" rows="4" class="form-control" placeholder="Observación"></textarea>
				</div>
			</div>
		</div>
	</div>

	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		<button class="btn btn-success btn-guardar-repInt"><i class="icon-rocket"></i> <a id="eventUrl" style="color:#fff; text-decoration:none;" onclick="validarGuardarRespInterno({{$idResponsable}});">Guardar</a></button>
	</div>
</div>