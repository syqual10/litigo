<div class="modal-body">	
	<!-- Row -->
	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-2">
					<label class="control-label pull-right">Documento</label>
				</div>
				<div class="col-sm-4">
					<input type="number" id="documentoUsuario" name="documentoUsuario" class="form-control" placeholder="Documento" value="{{$usuario->documentoUsuario}}" readonly>
				</div>

				<div class="col-sm-2">
					<label class="control-label pull-right">Nombre</label>
				</div>
				<div class="col-sm-4">
					<input type="text" id="nombreUsuario" name="nombreUsuario" class="form-control" placeholder="Nombre" value="{{$usuario->nombresUsuario}}" readonly>
				</div>
			</div>
		</div>
	</div>

	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-2">
					<label class="control-label pull-right">Celular</label>
				</div>
				<div class="col-sm-4">
					<input type="text" id="celularUsuario" name="celularUsuario" class="form-control" placeholder="Celular" value="{{$usuario->celularUsuario}}">
				</div>

				<div class="col-sm-2">
					<label class="control-label pull-right">E-mail</label>
				</div>
				<div class="col-sm-4">
					<input type="text" id="emailUsuario" name="emailUsuario" class="form-control" placeholder="E-mail" value="{{$usuario->emailUsuario}}">
				</div>
			</div>
		</div>
	</div>
	<!-- /Row -->

	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-2">
					<label class="control-label pull-right">Notificación Correo</label>
				</div>
				<div class="col-sm-4">
					<span class="onoffswitch pull-left">
						@if($responsable[0]->notifiCorreo == 1)
							<input type="checkbox" name="start_intervalPerfilCorreo" class="onoffswitch-checkbox" id="notificacionCorreo" checked>
						@else
							<input type="checkbox" name="start_intervalPerfilCorreo" class="onoffswitch-checkbox" id="notificacionCorreo">
						@endif
	                    <label class="onoffswitch-label" for="notificacionCorreo">
	                        <span class="onoffswitch-inner" data-swchon-text="SI" data-swchoff-text="NO"></span>
	                        <span class="onoffswitch-switch"></span>
	                    </label>
	                </span>
				</div>

				<div class="col-sm-2">
					<label class="control-label pull-right">Notificación SMS</label>
				</div>
				<div class="col-sm-4">
					<span class="onoffswitch pull-left">
						@if($responsable[0]->notifiSms == 1)
							<input type="checkbox" name="start_intervalPerfilSms" class="onoffswitch-checkbox" id="notificacionSms" checked>
						@else
							<input type="checkbox" name="start_intervalPerfilSms" class="onoffswitch-checkbox" id="notificacionSms">
						@endif
	                    <label class="onoffswitch-label" for="notificacionSms">
	                        <span class="onoffswitch-inner" data-swchon-text="SI" data-swchoff-text="NO"></span>
	                        <span class="onoffswitch-switch"></span>
	                    </label>
	                </span>
				</div>
			</div>
		</div>
	</div>

	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		<button class="btn btn-primary btn-modificar-usuario"><i class="icon-rocket"></i> <a id="eventUrl" style="color:#fff; text-decoration:none;" onclick="validarModificarUsuario();">Modificar</a></button>
	</div>
</div>