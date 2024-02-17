<div class="modal-body">
	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-3">
					<label class="control-label pull-right">Responsables:</label>
				</div>
				<div class="col-sm-6">
					{{ 
	            		Form::select('selectResponsable', $listaResponsables, null, ['class' => 'form-control', 'class' => 'select2', 'multiple', 'id'=>'selectResponsable', 'style' => 'margin-bottom:8px;'])
	        		}}
				</div>
			</div>
		</div>
	</div>

	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		<button class="btn btn-success btn-guardar-apoderado-nuevo"><i class="icon-rocket"></i> <a id="eventUrl" style="color:#fff; text-decoration:none;" onclick="validarGuardarApoderadoNuevo();">Guardar</a></button>
	</div>
</div>