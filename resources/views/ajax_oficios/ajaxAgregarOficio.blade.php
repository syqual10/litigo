<div class="modal-body">

	<div class="row">
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-6">
					<label class="control-label pull-right">El oficio está relacionado con un proceso?:</label>
				</div>
				<div class="col-sm-2">
					<span class="onoffswitch pull-left">
						<input type="checkbox" name="start_interval" class="onoffswitch-checkbox" id="relacionadoProceso" onchange="relacionadoProceso();">
						<label class="onoffswitch-label" for="relacionadoProceso">
							<span class="onoffswitch-inner" data-swchon-text="SI" data-swchoff-text="NO"></span>
							<span class="onoffswitch-switch"></span>
						</label>
					</span>
				</div>
			</div>
		</div>
	</div>

	<div id="divProceso" style="display:none">
		<div class="row" style="border: 1px solid #ddd;padding: 0 5px 12px;margin: 0 10px;">
			<div class="form-wrap">
				<div class="form-group">
					<div class="col-sm-3">
						<label class="control-label pull-right">Vigencia</label>
					</div>
					<div class="col-sm-2">
						<select class="form-control pull-left" id="vigenciaRadicado" onchange="vigenciaRadicados(this.value);">
							<option value='{{ $vigenciaActual }}'>{{ $vigenciaActual }}</option>
								<?php 
								for ($i=2018; $i<=$vigenciaActual; $i++) 
								{
									echo "<option value='$i'>$i</option>";
								}  
							?>
						</select>
					</div>

					<div class="col-sm-2">
						<label class="control-label pull-right">Proceso</label>
					</div>
					<div class="col-sm-3">
						<div id="resultadoRadicadosVig">
							{{ 
								Form::select('selectRadicado', $listaRadicados, null, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectRadicado', 'style' => 'margin-bottom:8px;', 'onchange' => 'involucradosRadicado(this.value)'])
							}}
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row" style="border: 1px dotted #ddd;padding: 0 5px 12px;margin: 5px 10px;" >
			<div class="form-wrap">
				<div class="form-group" id="resultadoInvolucrados">
					
				</div>
			</div>
		</div>
	</div>

	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-3">
					<label class="control-label pull-right">Destinatario</label>
				</div>
				<div class="col-sm-6">
					<input type="text" id="destinatario" name="destinatario" class="form-control" placeholder="Destinatario">
				</div>
			</div>
		</div>
	</div>

	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-3">
					<label class="control-label pull-right">Dirección</label>
				</div>
				<div class="col-sm-6">
					<input type="text" id="direccion" name="direccion" class="form-control" placeholder="Dirección">
				</div>
			</div>
		</div>
	</div>
	<!-- /Row -->

	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-3">
					<label class="control-label pull-right">Asunto</label>
				</div>
				<div class="col-sm-6">
					<textarea class="form-control" rows="5" id="asunto" name="asunto"></textarea>
				</div>
			</div>
		</div>
	</div>

	<div class="row" style="margin-bottom: 15px;" >
	    <div class="form-wrap">
	        <div class="form-group">
	            <div class="col-sm-3">
	                <label class="control-label pull-right">Ciudad:</label>
	            </div>
	            <div class="col-sm-6" id="resultadoCiudadOficio">
					<select data-placeholder="Seleccionar Ciudad.." class="select2" tabindex="8" id="ciudadOficio" name="ciudad">
		            <option value=""></option>
		              	@if(count($listaDeptos) > 0)
		                	@foreach ($listaDeptos as $dep)
		                  		<optgroup label="{{$dep->nombreDepartamento}}">
				                    @php 
					                    $ciudades = DB::table('ciudades')
						                    ->where('departamentos_idDepartamento', '=', $dep->idDepartamento)
						                    ->get();
				                    @endphp
				                  	@foreach ($ciudades as $ciudad)
				                    	<option value="{{$ciudad->idCiudad}}" >{{$ciudad->nombreCiudad}}</option>
				                  	@endforeach              
		                  		</optgroup>              
		                	@endforeach 
		              	@else
		                	No hay departamentos
		             	@endif   
		        	</select>
	            </div>
	        </div>
	    </div>
	</div>

	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		<button class="btn btn-success btn-guardar-dependencia"><i class="icon-rocket"></i> <a id="eventUrl" style="color:#fff; text-decoration:none;" onclick="validarGuardarOficio('{{$arco}}');">Guardar</a></button>
	</div>
</div>