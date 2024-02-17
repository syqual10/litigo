<label class="label">Radicado lítigo:</label>                   
{{
    Form::select('selectRadicadoConcilia', $radicadosConcilia, null, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectRadicadoConcilia', 'style' => 'margin-bottom:8px;width:250px !important', 'onchange' => 'datosAnterioresConci(this.value)'])
}}