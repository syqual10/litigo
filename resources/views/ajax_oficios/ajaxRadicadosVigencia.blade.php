{{ 
	Form::select('selectRadicado', $listaRadicados, null, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectRadicado', 'style' => 'margin-bottom:8px;', 'onchange' => 'involucradosRadicado(this.value)'])
}}