<div class="modal-body">
	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-2">
					<label class="control-label pull-right">Despacho</label>
				</div>
				<div class="col-sm-10">
					{{
						Form::select('selectJuzgado', $despachos, $despacho, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'id'=>'selectJuzgado', 'class' => 'select2', 'style' => 'margin-bottom:8px;'])
					}}
				</div>				
			</div>
		</div>
	</div>

	<div class="row" style="margin-bottom: 15px;">
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-2">
					<label class="control-label pull-right">Clase de actuación</label>
				</div>
				<div class="col-sm-4">
					{{
						Form::select('selectActuacion', $tiposEstadosActuaciones, null, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'id'=>'selectActuacion', 'class' => 'select2', 'style' => 'margin-bottom:8px;', 'onchange' => 'tipoActuacionSeleccionada(this.value)'])
					}}
				</div>
			</div>
		</div>
	</div>
	
	<div id="resultadoTipoActuación">
		<!--AJAX TIPOS DE ACTUACIONES-->
	</div>

	<div class="row" style="margin-bottom: 15px;">
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-2">
					<label class="control-label pull-right">Fecha actuación</label>
				</div>
				<div class="col-sm-4">
					<input type="text" id="fechaActuProce" name="fechaActuProce" placeholder="Seleccione fecha de notificación" class="form-control datepicker" data-dateformat="yy-mm-dd" readonly style="cursor:pointer">
				</div>

				<div id="resultadoTipoFallo"></div>
			</div>
		</div>
	</div>


	<label class="label">Comentario de la actuación:</label>
	<textarea name="comentarioActuacion" id="comentarioActuacion" rows="2" class="form-control" placeholder="Observación"></textarea>

	<div class="row">
		<div class="col-sm-12">
			<form action="#" class="dropzone" id="dropzoneActuacion">
				<div class="fallback">
					<input name="file" type="file" multiple  id="archivoActuacion" />
				</div>
			</form>
		</div>
	</div>
</p>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	<a id="botonArchivoActuacion" onclick="configuracionTipoActuacion({{$idEtapa}}, {{$tipoProceso}});" class="btn btn-sm btn-success pull-right btn-guardar-actuPro">
		Guardar Actuación
	</a>
</div>
