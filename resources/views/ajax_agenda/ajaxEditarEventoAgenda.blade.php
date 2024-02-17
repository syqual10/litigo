<div class="modal-body">
  	<fieldset style="margin-bottom: 15px;">
	  <input id="agendaPersonal" type="hidden" value="{{ $agenda[0]->agendaPersonal }}">

		<div style="display: {{ $agendaPersonalHide  }}">

			<div class="row" style="margin-bottom:7px;">
			<div class="col-sm-3">
				<label class="pull-right"><b>Crítico:</b></label>
			</div>
			<div class="col-sm-1">
				@if ($agenda[0]->critico == 1)
					<input type="checkbox" class="js-switch" data-size="small" data-color="#009efb" id="agendaCriticaEditar" checked onchange="ocultarColorEditar();" />
				@else
					<input type="checkbox" class="js-switch" data-size="small" data-color="#009efb" id="agendaCriticaEditar" onchange="ocultarColorEditar();"/>
				@endif
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
				<input type="checkbox" class="js-switch" data-size="small" data-color="#009efb" id="notificacionAgendaEditar" onchange="showTipoTiempoEditar();" {{$check}}/>
			</div>
			<div class="col-sm-7">
				<code class="pull-left">Marque esta opción si desea recibir una alerta sobre éste proceso</code>
			</div>
			</div>

	    </div>



	    <div id="divTiempoNotifiEditar" style="display: {{$notificacion}};">
		    <div class="row" style="margin-bottom:7px;">
			    <div class="col-sm-3">
			    	<label class="pull-right"><b>Tipo:</b></label>
			    </div>
			    <div class="col-sm-3">
		       		<select name="selectTipoNotifiEditar" class="form-control" id="selectTipoNotifiEditar">
			            <option value="0">Seleccione</option>
			            <option value="1" {{$selected1}}>Correo</option>
			            <option value="2" {{$selected2}}>SMS</option>
			        </select>
		      	</div>
		  
		      	<div class="col-sm-3">
		       		<input type="number" id="diasAntesEditar" name="diasAntesEditar" class="form-control" placeholder="Días Antes" value="{{$agenda[0]->tiempoNotificacion}}">
		      	</div>
		    </div>
	    </div>

	    @if($agenda[0]->juriradicados_idRadicado != '')
	    	<input type="hidden" value="{{$agenda[0]->juriradicados_vigenciaRadicado}}" id="vigenciaRadicado">
	    	<input type="hidden" value="{{$agenda[0]->juriradicados_idRadicado}}" id="idRadicado">

	      	<div class="row">  
		        <div class="col-sm-3">
		         	<label class="pull-right"><b>Proceso:</b></label>   
		        </div> 
		        <div class="col-sm-3">
		          	<span>Vigencia: {{$agenda[0]->juriradicados_vigenciaRadicado}}</span>
		        </div> 
		        <div class="col-sm-3">
		 			<span>Id: {{$agenda[0]->juriradicados_idRadicado}}</span>
		        </div>
	      	</div>
	    @endif
  	</fieldset>

  	<div id="divColoresEditar">
	    <div class="row">
	      <div class="col-sm-3">
	        <label class="pull-right"><b>Color:</b></label>
	      </div>
	      <div class="col-sm-8">
	        <div class="form-group">
	        <select name="colorAgendaEdit" class="form-control" id="colorAgendaEditar">
	           	<?php 
		            switch ($agenda[0]->color) 
		            {
			            case '#0071c5':
			            	echo '<option style="color:#0071c5;" value="#0071c5" selected>&#9724; Azul Oscuro</option>';
			            break;

			            case '#40E0D0':
			            	echo '<option style="color:#40E0D0;" value="#40E0D0" selected>&#9724; Turquesa</option>';
			            break;

			            case '#008000':
			            	echo '<option style="color:#008000;" value="#008000" selected>&#9724; Verde</option>';
			            break;

			            case '#FFD700':
			            	echo '<option style="color:#FFD700;" value="#FFD700" selected>&#9724; Amarillo</option>';
			            break;

			            case '#FF8C00':
			            	echo '<option style="color:#FF8C00;" value="#FF8C00" selected>&#9724; Naranja</option>';
			            break;

			            case '#FF0000':
			            	echo '<option style="color:#FF0000;" value="#FF0000" selected>&#9724; Rojo</option>';
			            break;

			            case '#000':
			            	echo '<option style="color:#000;" value="#000" selected>&#9724; Negro</option>';
			            break;
			                
			            default:
			            # code...
			            break;
		            }
	            ?>            
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
	<div class="row"> 
	  <div class="col-sm-3">  
	    <div class="form-group pull-right">
	      <label><b>Asunto:</b></label>           
	    </div>  
	  </div>
	  <div class="col-sm-8">
	    <textarea rows="5" class="form-control" id="asuntoAgendaEditar">{{$agenda[0]->asuntoAgenda}}</textarea>
	  </div>
	</div>
</div>
<input type="hidden" value="{{$agenda[0]->fechaInicioAgenda}}" id="fechaInicioAgenda">
<input type="hidden" value="{{$agenda[0]->fechaFinAgenda}}" id="fechaFinAgenda">
<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
  <button type="submit" class="btn btn-primary" onclick="validarEditarAgenda({{$agenda[0]->Id}});">Agendar</button>
</div>