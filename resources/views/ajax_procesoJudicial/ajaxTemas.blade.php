<section class="col-sm-10">
    <label class="label">Tema: Representa la razón principal por la cual se redacta el documento</label>
    {{
        Form::select('selectTema', $listaTemas, $idTemaSeleccionado, ['placeholder' => 'Seleccione el tema', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectTema', 'style' => 'margin-bottom:8px;width:250px !important'])
    }}
</section>
<div class="col-sm-2">
	<br>
	<a class="btn btn-success btn-xs btn-block" onclick="agregarTema()" href="javascript:void(0);" style="margin-top:6px"> <i class="fa fa-plus"></i> Nuevo</a>
</div>
<hr>
<div class="row" style="display: none">
	<div class="col-sm-11">
		<div class="alert alert-danger" style="margin-top: 20px">
			Si requiere agregar temas nuevos, se recomienda que estos no sean específicos para cada demanda.  Piense en temas generales que puedan ser compartidos por múltiples demandas.  Por ej: <strong>"Deslizamientos", "Obras de Estabilidad", "Programa Colombia Mayor"</strong>, etc.  Esto permitirá agrupar las demandas y construir reportes mas acertados.
		</div>
	</div>
</div>
