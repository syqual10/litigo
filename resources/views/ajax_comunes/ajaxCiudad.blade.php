<div class="col-sm-2">
	<label class="control-label pull-left">Ciudad</label>
</div>
<div class="col-sm-4">
	{{ 
		Form::select('selectCiudad', $listaCiudad, null, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'id'=>'selectCiudad', 'style' => 'margin-bottom:8px;'])
	}}
</div>