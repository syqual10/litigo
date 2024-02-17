<div class="modal-body">
	<!-- Row -->
	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-3">
					<label class="control-label pull-right">Juzgado:</label>
				</div>
				<div class="col-sm-6">
					{{ 
	            		Form::select('selectJuzgado', $juzgados, $proceso[0]->jurijuzgados_idJuzgado, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectJuzgado', 'style' => 'margin-bottom:8px;'])
	        		}}
				</div>
			</div>
		</div>
	</div>

	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-3">
					<label class="control-label pull-right">Radicado Juzgado:</label>
				</div>
				<div class="col-sm-6">
					<input type="text" id="radicadoJuzgado"  name="param" placeholder="Radicado del juzgado" class="form-control" value="{{$proceso[0]->radicadoJuzgado}}" >
				</div>
			</div>
		</div>
	</div>

	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-3">
					<label class="control-label pull-right">Medio de Control:</label>
				</div>
				<div class="col-sm-6">
					{{ 
	            		Form::select('selectMedioControl', $mediosControl, $proceso[0]->jurimedioscontrol_idMediosControl, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectMedioControl', 'style' => 'margin-bottom:8px;'])
	        		}}
				</div>
			</div>
		</div>
	</div>

	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-3">
					<label class="control-label pull-right">Tema:</label>
				</div>
				<div class="col-sm-6">
					{{ 
	            		Form::select('selectTema', $temas, $proceso[0]->juritemas_idTema, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectTema', 'style' => 'margin-bottom:8px;'])
	        		}}
				</div>
			</div>
		</div>
	</div>


	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		<button class="btn btn-success btn-editar-datosG"><i class="icon-rocket"></i> <a id="eventUrl" style="color:#fff; text-decoration:none;" onclick="validarEditarDatosGenerales();">Modificar</a></button>
	</div>
</div>