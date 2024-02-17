<div class="modal-body">	
	<!-- Row -->
    <div class="row">
        <div class="form-wrap">
            <div class="form-group">
                <div class="col-sm-3">
                    <label class="control-label pull-right">Cómo se hace?:</label>
                </div>
                <div class="col-sm-6">
                  <textarea rows="5" class="form-control" id="textoPasoHijo"></textarea>
                </div>
            </div>
        </div>
    </div>  

    <div class="row" style="margin-bottom: 15px;" >
        <div class="form-wrap">
            <div class="form-group">
                <div class="col-sm-3">
                    <label class="control-label pull-right">Paso Padre:</label>
                </div>
                <div class="col-sm-6">
                    {{ 
                        Form::select('selectPasoPadre', $listaPasoPadre, null, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectPasoPadre', 'style' => 'margin-bottom:8px;'])
                    }}
                </div>
            </div>
        </div>
    </div>

	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		<button class="btn btn-success btn-guardar-paso"><i class="icon-rocket"></i> <a id="eventUrl" style="color:#fff; text-decoration:none;" onclick="validarGuardarPaso(0);">Guardar</a></button>
	</div>
</div>