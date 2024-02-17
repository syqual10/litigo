@if(count($tiposActuaciones) > 0)
	<div class="row" style="margin-bottom: 15px;">
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-xs-offset-2 col-sm-10" style="margin-bottom:4px">
					@if($idTipoEstadoActuacion == 1)<!--TERMINADOS-->
						<div style="text-align: justify">
							<span class="label-danger" style="color:white;padding: 0 3px;border-radius:3px;">
								{{$observacionActuacion}}
							</span>
						</div>
					@elseif($idTipoEstadoActuacion == 2)<!--FALLOS-->
						<div style="text-align: justify">
							<span class="label-warning" style="color:white;padding: 0 3px;border-radius:3px;">
								{{$observacionActuacion}}
							</span>
						</div>
					@elseif($idTipoEstadoActuacion == 3)<!--ESTADOS HISTORIAL-->
						<div style="text-align: justify">
							<span class="label-success" style="color:white;padding: 0 3px;border-radius:3px;">
								{{$observacionActuacion}}
							</span>
						</div>
					@elseif($idTipoEstadoActuacion == 4)<!--CUMPLIMIENTO DEL FALLO-->
						<div style="text-align: justify">
							<span class="label-success" style="color:white;padding: 0 3px;border-radius:3px;">
								{{$observacionActuacion}}
							</span>
						</div>
					@endif
				</div>
				<div class="col-sm-2">
					<label class="control-label pull-right">Tipo de actuación</label>
				</div>
				<div class="col-sm-10">
					{{
						Form::select('selectTipoActuacion', $tiposActuaciones, null, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'id'=>'selectTipoActuacion', 'class' => 'select2', 'style' => 'margin-bottom:8px;', 'onchange' => 'agregarTipoFallo(this.value)'])
					}}
				</div>
			</div>
		</div>
	</div>
@endif	
	