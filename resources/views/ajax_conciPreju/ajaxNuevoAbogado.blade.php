<div class="modal-body">
  <form class="smart-form">
    <div class="row">
      <div class="form-wrap">
        <div class="form-group">
          <div class="col-sm-6">
            <label class="label pull-left">Número de documento</label>
            <input type="number" id="documentoAbogadoDemandante" name="documentoAbogadoDemandante" class="form-control" placeholder="Número de documento">
          </div>

          <div class="col-sm-6">
            <label class="label">Tipo de Documento</label>
            {{ 
              Form::select('selecTipoDocumentoAbogado', $listaTipoDocumentos, null, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selecTipoDocumentoAbogado', 'style' => 'width:280px'])
            }}
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="form-wrap">
        <div class="form-group">
          <div class="col-sm-6">
            <label class="label pull-left">Nombre Abogado</label>
            <input type="text" id="nombreAbogado" name="nombreAbogado" class="form-control" placeholder="Nombre Abogado">
          </div>

          <div class="col-sm-6">
            <label class="label pull-left">Tarjeta Abogado</label>
            <input type="text" id="tarjetaAbogado" name="tarjetaAbogado" class="form-control" placeholder="Tarjeta Abogado">
          </div>
        </div>
      </div>
    </div>
  </form>
</div>

<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
  <button class="btn btn-success btn-guardar-abogado"><i class="icon-rocket"></i> <a id="eventUrl" style="color:#fff; text-decoration:none;" onclick="validarGuardarAbogado();">Guardar</a></button>
</div>