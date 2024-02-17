<div class="modal-body">
  <form class="smart-form">
    <div class="row">
      <div class="form-wrap">
        <div class="form-group">
          <div class="col-sm-6">
            <label class="label pull-left">Nombre</label>
            <input type="text" id="nombreNuevoExternoEdit" name="nombreNuevoExternoEdit" class="form-control" placeholder="Nombre" value="{{$externo[0]->nombreConvocadoExterno}}">
          </div>

          <div class="col-sm-6">
            <label class="label pull-left">Dirección</label>
            <input type="text" id="direccionNuevoExternoEdit" name="direccionNuevoExternoEdit" class="form-control" placeholder="Dirección" value="{{$externo[0]->direccionConvocadoExterno}}">
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="form-wrap">
        <div class="form-group">
          <div class="col-sm-6">
            <label class="label pull-left">Teléfono</label>
            <input type="number" id="telefonoNuevoExternoEdit" name="telefonoNuevoExternoEdit" class="form-control" placeholder="Teléfono" value="{{$externo[0]->telefonoConvocadoExterno}}">
          </div>
        </div>
      </div>
    </div>
  </form>
</div>

<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
  <button class="btn btn-success btn-editar-nuevoExt"><i class="icon-rocket"></i> <a id="eventUrl" style="color:#fff; text-decoration:none;" onclick="validarEditarExt({{$externo[0]->idConvocadoExterno}}, {{$tipoInvolucrado}});">Modificar</a></button>
</div>