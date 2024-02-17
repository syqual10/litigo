<div class="modal-body">
	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-3">
					<label class="control-label pull-right">Responsables:</label>
				</div>
				<div class="col-sm-6">
					{{ 
	            		Form::select('selectRespInt', $listaResponsables, null, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectRespInt', 'style' => 'margin-bottom:8px;', 'multiple'])
	        		}}
				</div>
			</div>
		</div>
	</div>

	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		<button class="btn btn-success btn-guardar-respInt"><i class="icon-rocket"></i> <a id="eventUrl" style="color:#fff; text-decoration:none;" onclick="validarGuardarRespInt({{$idResponsable}});">Guardar</a></button>
	</div>
	<hr>
	<div id="resultadoTablaRespInt">
		<!--TABLA RESPONSABLES INTERNOS-->
	</div>
</div>