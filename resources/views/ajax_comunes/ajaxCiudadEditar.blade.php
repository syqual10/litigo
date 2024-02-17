<div class="col-sm-2">
	<label class="control-label pull-left">Ciudad</label>
</div>
<div class="col-sm-4">
	{{ 
		Form::select('selectCiudadEditar', $listaCiudad, null, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectCiudadEditar', 'style' => 'margin-bottom:8px;'])
	}}
</div>