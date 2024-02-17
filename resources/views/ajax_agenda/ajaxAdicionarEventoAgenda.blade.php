<div class="modal-body">


	<div class="row" style="margin-bottom:7px;">
		<div class="col-sm-3">
		<label class="pull-right"><b>¿Agenda personal?</b></label>
		</div>
		<div class="col-sm-1">
		<input type="checkbox" class="js-switch" data-size="small" data-color="#009efb" id="agendaPersonal" onchange="ocultarDivAgendaRadicado();" />
		</div>
		<div class="col-sm-7">
		<code class="pull-left">Marque esta opción si la Agenda es personal</code>
		</div>
	</div>

	<!-- Se oculta si seleccion Agenda personal -->
	<div id="DivAgendaRadicado">
		<div class="row" style="margin-bottom:10px;">
			<div class="col-sm-3">
				<label class="pull-right"><b>Tipo:</b></label>
			</div>
			<div class="col-sm-6">
				<select name="selectTipoAgenda" class="form-control" id="selectTipoAgenda" onchange="tipoAgenda(this.value);">
					<option value="0">Agendar por</option>
					<option value="1">Radicado del juzgado</option>
					<option value="2">Radicado Interno</option>
				</select>
			</div>
		</div>

		<fieldset style="margin-bottom: 15px;">
			<div class="row" style="margin-bottom:7px;">
			<div class="col-sm-3">
				<label class="pull-right"><b>Crítico:</b></label>
			</div>
			<div class="col-sm-1">
				<input type="checkbox" class="js-switch" data-size="small" data-color="#009efb" id="agendaCritica" onchange="ocultarColor();" />
			</div>
			<div class="col-sm-7">
				<code class="pull-left">Marque esta opción si la el evento es muy importante</code>
			</div>
			</div>

			<div class="row" style="margin-bottom:7px;">
			<div class="col-sm-3">
				<label class="pull-right"><b>¿Notificación?:</b></label>
			</div>
			<div class="col-sm-1">
				<input type="checkbox" class="js-switch" data-size="small" data-color="#009efb" id="notificacionAgenda" onchange="showTipoTiempo();" />
			</div>
			<div class="col-sm-7">
				<code class="pull-left">Marque esta opción si desea recibir una alerta sobre éste proceso</code>
			</div>
			</div>

			<div class="row" style="margin-bottom:7px;">
				<div class="col-sm-3">
					<label class="pull-right"><b>Notificar a:</b></label>
				</div>
				<div class="col-sm-1">
					<input type="checkbox" class="js-switch" data-size="small" data-color="#009efb" id="usauriosAgendaOtros" onchange="usuariosAgenda();" />
				</div>
				<div class="col-sm-7">
					<code class="pull-left">Marque esta opción para enviar notificación a otras personas sobre ésta agenda</code>
				</div>
			</div>

			<div class="row" style="margin-bottom:10px;margin-top:10px;">
				<div class="col-sm-3" id="divLabelOtrosUser" style="display: none;">
					<label class="pull-right"><b>Usuarios Notificados:</b></label>
				</div>
				<div class="col-sm-9">
					<div id="resultadoOtrosUsuariosAgenda">
						<!--AJAX SUGERIDOS-->
					</div>
				</div>
			</div>

			<div id="divTiempoNotifi" style="display: none;">
				<div class="row" style="margin-bottom:7px;">
					<div class="col-sm-3">
						<label class="pull-right"><b>Tipo:</b></label>
					</div>
					<div class="col-sm-3">
						<select name="selectTipoNotifi" class="form-control" id="selectTipoNotifi">
							<option value="0">Seleccione</option>
							<option value="1">Correo</option>
							<option value="2">SMS</option>
						</select>
					</div>
			
					<div class="col-sm-3">
						<input type="number" id="diasAntes" name="diasAntes" class="form-control" placeholder="Días Antes">
					</div>
				</div>
			</div>

			<div id="divRadicadoJuzgado" style="display: none;">
				<div class="row" style="margin-bottom:10px;margin-top:10px;">
					<div class="col-sm-3">
						<label class="pull-right"><b>Radicado Juzgado:</b></label>
					</div>
					<div class="col-sm-3">
						<input type="text" id="radicadoJuzgado" name="radicadoJuzgado" class="form-control" placeholder="Radicado Juzgado" maxlength="9" onchange="format(this)" onkeyup="buscarProcesoAgenda(this);">
					</div>
				</div>

				<div class="row" style="margin-bottom:10px;margin-top:10px;">
					<div class="col-sm-3">
						<label class="pull-right"><b>Procesos Sugeridos:</b></label>
					</div>
					<div class="col-sm-9">
						<div id="resultadoSugeridos">
							<!--AJAX SUGERIDOS-->
						</div>
					</div>
				</div>

				<div id="divProcesoAgenda">
				
				</div >
			</div>

			<div id="divProcesoInternos" style="display: none;">
				<div class="row" style="margin-bottom: 8px;"> 
					<div class="col-sm-3">
					<label class="pull-right"><b>Queja:</b></label>   
					</div> 
					<div class="col-sm-3">
						<select class="form-control pull-left" id="vigenciaProceso" onchange="cambiarVigenciaProceso(this.value);">
						<option value='{{ $vigenciaActual }}'>{{ $vigenciaActual }}</option>
							<?php 
								for ($i=2003; $i<=$vigenciaActual; $i++) 
								{
								echo "<option value='$i'>$i</option>";
								}  
						?>
						</select>
					</div>       

					<div class="col-sm-5" id="resultadoVigenciaProceso">
						<select data-placeholder="Número Proceso.." style="width:300px;" class="chosen-select" tabindex="8" id="selectProceso" name="selectProceso">
							<option value=""></option>
							@if(count($listaProcesosUsuario) > 0)
							@foreach ($listaProcesosUsuario as $list_pro)
								<option value="{{$list_pro->juriradicados_idRadicado}}">{{$list_pro->juriradicados_idRadicado}}</option>   
							@endforeach              
							@else
								No hay procesos
							@endif   
						</select>
					</div>
				</div>
			</div>
		</fieldset>

		<div id="divColores">
			<div class="row">
			<div class="col-sm-3">
				<label class="pull-right"><b>Color:</b></label>
			</div>
			<div class="col-sm-8">
				<div class="form-group">
				<select name="colorAgenda" class="form-control" id="colorAgenda">
					<option value="0">Seleccione</option>
					<option style="color:#0071c5;" value="#0071c5">&#9724; Azul Oscuro</option>
					<option style="color:#40E0D0;" value="#40E0D0">&#9724; Turquesa</option>
					<option style="color:#008000;" value="#008000">&#9724; Verde</option>                       
					<option style="color:#FFD700;" value="#FFD700">&#9724; Amarillo</option>
					<option style="color:#FF8C00;" value="#FF8C00">&#9724; Naranja</option>
					<option style="color:#000;" value="#000">&#9724; Negro</option>
				</select>
				</div>
			</div>
			</div>
		</div>
	</div>
	<!--# Se oculta si seleccion Agenda personal -->

	<div class="row"> 
	  <div class="col-sm-3">  
	    <div class="form-group pull-right">
	      <label><b>Asunto:</b></label>           
	    </div>  
	  </div>
	  <div class="col-sm-8">
	    <textarea rows="5" class="form-control" id="asuntoAgenda"></textarea>
	  </div>
	</div>
</div>
<input type="hidden" id="fechaInicioAg" value="{{$fechaInicio}}">
<input type="hidden" id="fechaFinalAg" value="{{$fechaFinal}}"> 
<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
  <button type="submit" class="btn btn-primary" onclick="validarGuardarAgenda();">Agendar</button>
</div>