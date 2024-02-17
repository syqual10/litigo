<div class="modal-body">
  <form class="smart-form">
    <div class="row">
      <div class="form-wrap">
        <div class="form-group">
          <div class="col-sm-6">
            <label class="label pull-left">Nombre</label>
            <input type="text" id="nombreConvocadoExternoEditar" name="nombreConvocadoExternoEditar" class="form-control" placeholder="Nombre" value="{{$convocadoExt[0]->nombreConvocadoExterno}}">
          </div>

          <div class="col-sm-6">
            <label class="label pull-left">Dirección</label>
            <input type="text" id="direccionConvocadoExternoEditar" name="direccionConvocadoExternoEditar" class="form-control" placeholder="Dirección" value="{{$convocadoExt[0]->direccionConvocadoExterno}}">
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="form-wrap">
        <div class="form-group">
          <div class="col-sm-6">
            <label class="label pull-left">Teléfono</label>
            <input type="number" id="telefonoConvocadoExternoEditar" name="telefonoConvocadoExternoEditar" class="form-control" placeholder="Teléfono" value="{{$convocadoExt[0]->telefonoConvocadoExterno}}">
          </div>
        </div>
      </div>
    </div>
  </form>
</div>

<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
  <button class="btn btn-success btn-editar-convocadoExt"><i class="icon-rocket"></i> <a id="eventUrl" style="color:#fff; text-decoration:none;" onclick="validarEditarConvocadoExt({{$convocadoExt[0]->idConvocadoExterno}});">Modificar</a></button>
</div>