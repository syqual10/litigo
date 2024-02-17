<div class="modal-body">
  <form class="smart-form">
    <div class="row">
      <div class="form-wrap">
        <div class="form-group">
          <div class="col-sm-6">
            <label class="label pull-left">Nombre</label>
            <input type="text" id="nombreEntidadExternoEditar" name="nombreEntidadExternoEditar" class="form-control" placeholder="Nombre" value="{{$entidadExt[0]->nombreConvocadoExterno}}">
          </div>

          <div class="col-sm-6">
            <label class="label pull-left">Dirección</label>
            <input type="text" id="direccionEntidadExternoEditar" name="direccionEntidadExternoEditar" class="form-control" placeholder="Dirección" value="{{$entidadExt[0]->direccionConvocadoExterno}}">
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="form-wrap">
        <div class="form-group">
          <div class="col-sm-6">
            <label class="label pull-left">Teléfono</label>
            <input type="number" id="telefonoEntidadExternoEditar" name="telefonoEntidadExternoEditar" class="form-control" placeholder="Teléfono" value="{{$entidadExt[0]->telefonoConvocadoExterno}}">
          </div>
        </div>
      </div>
    </div>
  </form>
</div>

<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
  <button class="btn btn-success btn-editar-entidadExt"><i class="icon-rocket"></i> <a id="eventUrl" style="color:#fff; text-decoration:none;" onclick="validarEditarEntidadExt({{$entidadExt[0]->idConvocadoExterno}});">Modificar</a></button>
</div>