<div class="modal-body">
  	<div class="row">
		<div class="col-sm-12">
			<form action="#" class="dropzone" id="dropzoneNuevoArchivo">
				<div class="fallback">
					<input name="file" type="file" multiple  id="archivoNuevo" />
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
  <button class="btn btn-success btn-guardar-nuevoArchivo"><i class="icon-rocket"></i> <a id="eventUrl" style="color:#fff; text-decoration:none;" onclick="validarGuardarNuevoArchivo();">Guardar</a></button>
</div>