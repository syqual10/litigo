<div class="modal-body">
  <form class="smart-form">
    <div class="row">
      <div class="form-wrap">
        <div class="form-group">
          <div class="col-sm-6">
            <label class="label pull-left">Nombre</label>
            <input type="text" id="nombreNuevoExterno" name="nombreNuevoExterno" class="form-control" placeholder="Nombre" onBlur="involucradoProceso({{$tipoInvolucrado}});">
          </div>

          <div class="col-sm-6">
            <label class="label pull-left">Dirección</label>
            <input type="text" id="direccionNuevoExterno" name="direccionNuevoExterno" class="form-control" placeholder="Dirección">
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="form-wrap">
        <div class="form-group">
          <div class="col-sm-6">
            <label class="label pull-left">Teléfono</label>
            <input type="number" id="telefonoNuevoExterno" name="telefonoNuevoExterno" class="form-control" placeholder="Teléfono">
          </div>
        </div>
      </div>
    </div>
  </form>
</div>

<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
  <button class="btn btn-success btn-guardar-nuevoExt"><i class="icon-rocket"></i> <a id="eventUrl" style="color:#fff; text-decoration:none;" onclick="validarGuardarNuevoExt({{$tipoInvolucrado}});">Guardar</a></button>
</div>