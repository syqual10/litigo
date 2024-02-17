<div class="modal-body">	
	<!-- Row -->
	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-3">
					<label class="control-label pull-right">Actual Contraseña</label>
				</div>
				<div class="col-sm-6">
					<input type="password" id="actualPass" name="actualPass" class="form-control" placeholder="Actual Contraseña">
				</div>
			</div>
		</div>
	</div>

	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-3">
					<label class="control-label pull-right">Nueva Contraseña</label>
				</div>
				<div class="col-sm-6">
					<input type="password" id="nuevaPass" name="nuevaPass" class="form-control" placeholder="Nueva Contraseña">
				</div>
			</div>
		</div>
	</div>

	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-3">
					<label class="control-label pull-right">Confirmar Nueva Contraseña</label>
				</div>
				<div class="col-sm-6">
					<input type="password" id="confirmPass" name="confirmPass" class="form-control" placeholder="Confirmar Nueva Contraseña">
				</div>
			</div>
		</div>
	</div>
	<!-- /Row -->

	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		<button class="btn btn-primary btn-guardar-nuevaPass"><i class="icon-rocket"></i> <a id="eventUrl" style="color:#fff; text-decoration:none;" onclick="validarNuevaPass({{$idUsuario}}, {{$documento}});">Guardar</a></button>
	</div>
</div>