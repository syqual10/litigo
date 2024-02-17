<div class="modal-body">
	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-3">
					<label class="control-label pull-right">Apoderado:</label>
				</div>
				<div class="col-sm-6">
					{{ 
	            		Form::select('selectApoderadoNuevo', $listaApoderados, null, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectApoderadoNuevo', 'style' => 'margin-bottom:8px;'])
	        		}}
				</div>
			</div>
		</div>
	</div>

	<div class="row" style="margin-bottom:7px;">
		<div class="col-sm-3">
			<label class="control-label pull-right">Apoderado Principal:</label>
		</div>
		<div class="col-sm-6">
			<select name="selectPrincipal" class="form-control" id="selectPrincipal">
				<option value="0">Seleccione</option>
				<option value="1">Si</option>
				<option value="2">No</option>
			</select>
		</div>
	</div>

	<div class="row" style="margin-bottom:7px;">
		<div class="col-sm-3">
			<label class="control-label pull-right">Comentario:</label>
		</div>
		<div class="col-sm-6">
			<textarea name="comentarioApoderado" id="comentarioApoderado" rows="5" class="form-control" placeholder="Breve observación"></textarea>
		</div>
	</div>

	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		<button class="btn btn-success btn-guardar-dependencia"><i class="icon-rocket"></i> <a id="eventUrl" style="color:#fff; text-decoration:none;" onclick="validarGuardarNuevoApoderado({{$vigenciaRadicado}}, {{$idRadicado}});">Guardar</a></button>
	</div>
</div>