<section class="col-sm-8">
    <label class="label">Medio de control:</label>
    {{
        Form::select('selectMedioControl', $listaMediosControl, $idMedioSeleccionado, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectMedioControl', 'style' => 'margin-bottom:8px;width:250px !important'])
    }}
</section>