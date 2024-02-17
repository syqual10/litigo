<div class="modal-body">
	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-2">
					<label class="control-label pull-right">Despacho</label>
				</div>
				<div class="col-sm-10">
					{{
						Form::select('selectJuzgadoEdit', $despachos, $despacho, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'id'=>'selectJuzgadoEdit', 'class' => 'select2', 'style' => 'margin-bottom:8px;'])
					}}
				</div>				
			</div>
		</div>
	</div>

	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-2">
					<label class="control-label pull-right">Fecha actuación</label>
				</div>
				<div class="col-sm-4">
					<input type="text" id="fechaActuProceEdit" name="fechaActuProceEdit" placeholder="Seleccione fecha de notificación" class="form-control datepicker" data-dateformat="yy-mm-dd" readonly style="cursor:pointer" value="{{$actuacion[0]->fechaActuacion}}">
				</div>
			</div>
		</div>
	</div>

	<label class="label">Comentario de la actuación:</label>
	<textarea name="comentarioActuacion" id="comentarioActuacionEdit" rows="2" class="form-control" placeholder="Observación">{{$actuacion[0]->comentarioActuacion}}</textarea>

	<div class="row">
		<div class="col-sm-12">
			<form action="#" class="dropzone" id="dropzoneActuacionEdit">
				<div class="fallback">
					<input name="file" type="file" multiple  id="archivoActuacionEdit" />
				</div>
			</form>
		</div>
	</div>
</p>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	<a id="botonArchivoActuacion" onclick="validarEditarActuacion({{$idActuacion}}, {{$idEtapa}}, {{$tipoProceso}});" class="btn btn-sm btn-success pull-right btn-editar-actuPro">
		Modificar Actuación
	</a>
</div>