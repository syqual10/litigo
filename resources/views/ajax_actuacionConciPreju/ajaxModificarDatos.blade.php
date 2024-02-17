<div class="modal-body">
	<!-- Row -->
	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-3">
					<label class="control-label pull-right">Procuraduría:</label>
				</div>
				<div class="col-sm-6">
					{{ 
	            		Form::select('selectProcuraduria', $procaduriaConocedora, $proceso[0]->juriautoridadconoce_idAutoridadConoce, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectProcuraduria', 'style' => 'margin-bottom:8px;'])
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

	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-3">
					<label class="control-label pull-right">Medios de control:</label>
				</div>
				<div class="col-sm-6">
					{{ 
	            		Form::select('selectMedioControl', $mediosControl, $proceso[0]->jurimedioscontrol_idMediosControl, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectMedioControl', 'style' => 'margin-bottom:8px;'])
	        		}}
				</div>
			</div>
		</div>
	</div>

	<div class="row" style="margin-bottom: 15px;">
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-3">
					<label class="control-label pull-right">Fecha Notificación</label>
				</div>
				<div class="col-sm-6">
					<input type="text" id="fechaNotifiEdit" name="fechaNotifiEdit" placeholder="Seleccione fecha de notificación" class="form-control datepicker" data-dateformat="yy-mm-dd" readonly style="cursor:pointer" value="{{$proceso[0]->fechaNotificacion}}">
				</div>
			</div>
		</div>
	</div>
	<!-- /Row -->

	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		<button class="btn btn-success btn-editar-datosG"><i class="icon-rocket"></i> <a id="eventUrl" style="color:#fff; text-decoration:none;" onclick="validarEditarDatosGenerales();">Modificar</a></button>
	</div>
</div>