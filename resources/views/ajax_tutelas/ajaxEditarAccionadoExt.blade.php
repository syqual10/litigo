<div class="modal-body">
  <form class="smart-form">
    <div class="row">
      <div class="form-wrap">
        <div class="form-group">
          <div class="col-sm-6">
            <label class="label pull-left">Nombre</label>
            <input type="text" id="nombreAccionadoExternoEditar" name="nombreAccionadoExternoEditar" class="form-control" placeholder="Nombre" value="{{$accionadoExt[0]->nombreConvocadoExterno}}">
          </div>

          <div class="col-sm-6">
            <label class="label pull-left">Dirección</label>
            <input type="text" id="direccionAccionadoExternoEditar" name="direccionAccionadoExternoEditar" class="form-control" placeholder="Dirección" value="{{$accionadoExt[0]->direccionConvocadoExterno}}">
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="form-wrap">
        <div class="form-group">
          <div class="col-sm-6">
            <label class="label pull-left">Teléfono</label>
            <input type="number" id="telefonoAccionadoExternoEditar" name="telefonoAccionadoExternoEditar" class="form-control" placeholder="Teléfono" value="{{$accionadoExt[0]->telefonoConvocadoExterno}}">
          </div>
        </div>
      </div>
    </div>
  </form>
</div>

<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
  <button class="btn btn-success btn-editar-accionadoExt"><i class="icon-rocket"></i> <a id="eventUrl" style="color:#fff; text-decoration:none;" onclick="validarEditarAccionadoExt({{$accionadoExt[0]->idConvocadoExterno}});">Modificar</a></button>
</div>