<label for="selectTema" class="col-sm-3 control-label">Número del radicado Syqual</label>
<div class="col-sm-6">
    {{
        Form::select('selectRadicado', $listaRadicadosEntidad, null, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectRadicado', 'style' => 'margin-bottom:8px;'])
    }}
</div>