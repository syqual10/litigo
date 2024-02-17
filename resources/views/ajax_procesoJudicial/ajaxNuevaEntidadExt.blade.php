<div class="modal-body">
  <form class="smart-form">
    <div class="row">
      <div class="form-wrap">
        <div class="form-group">
          <div class="col-sm-6">
            <label class="label pull-left">Nombre</label>
            <input type="text" id="nombreEntidadExterno" name="nombreEntidadExterno" class="form-control" placeholder="Nombre">
          </div>

          <div class="col-sm-6">
            <label class="label pull-left">Dirección</label>
            <input type="text" id="direccionEntidadExterno" name="direccionEntidadExterno" class="form-control" placeholder="Dirección">
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="form-wrap">
        <div class="form-group">
          <div class="col-sm-6">
            <label class="label pull-left">Teléfono</label>
            <input type="number" id="telefonoEntidadExterno" name="telefonoEntidadExterno" class="form-control" placeholder="Teléfono">
          </div>
        </div>
      </div>
    </div>
  </form>
</div>

<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
  <button class="btn btn-success btn-guardar-entidadExt"><i class="icon-rocket"></i> <a id="eventUrl" style="color:#fff; text-decoration:none;" onclick="validarGuardarEntidadExt();">Guardar</a></button>
</div>