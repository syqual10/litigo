<section class="col-sm-4">
    <label class="label">Tema de la Demanda:</label>
    {{
        Form::select('selectTema', $listaTemas, $idTemaSeleccionado, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectTema', 'style' => 'margin-bottom:8px;width:250px !important'])
    }}
    <input type="hidden" id="coincidenciaJuzgado">
    <a class="btn btn-success btn-xs btn-block" onclick="agregarTema()" href="javascript:void(0);" style="margin-top:6px">Nuevo Tema</a>
</section>
