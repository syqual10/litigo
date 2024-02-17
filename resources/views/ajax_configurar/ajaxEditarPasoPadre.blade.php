<div class="modal-body">	
	<!-- Row -->
    <div class="row">
        <div class="form-wrap">
            <div class="form-group">
                <div class="col-sm-3">
                    <label class="control-label pull-right">¿Qué hace?:</label>
                </div>
                <div class="col-sm-6">
                  <textarea rows="5" class="form-control" id="textoPasoPadreEditar">{{$paso[0]->textoPaso}}</textarea>
                </div>
            </div>
        </div>
    </div>  

	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		<button class="btn btn-success btn-editar-paso"><i class="icon-rocket"></i> <a id="eventUrl" style="color:#fff; text-decoration:none;" onclick="validarEditarPaso({{$paso[0]->idPaso}}, 1);">Modificar</a></button>
	</div>
</div>