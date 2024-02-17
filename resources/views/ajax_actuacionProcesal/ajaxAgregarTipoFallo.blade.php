<div class="col-sm-2">
	<label class="control-label pull-right">Sentido del fallo</label>
</div>
<div class="col-sm-4">
	{{
		Form::select('selectTipoFallo', $tiposFallos, null, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'id'=>'selectTipoFallo', 'class' => 'select2', 'style' => 'margin-bottom:8px;'])
	}}
</div>