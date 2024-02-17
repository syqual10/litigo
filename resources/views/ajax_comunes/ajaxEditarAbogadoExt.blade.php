<div class="modal-body">
  <form class="smart-form">
    <div class="row">
      <div class="form-wrap">
        <div class="form-group">
          <div class="col-sm-6">
            <label class="label pull-left">Número de documento</label>
            <input type="number" id="documentoAbogadoDemandanteEditar" name="documentoAbogadoDemandanteEditar" class="form-control" placeholder="Número de documento" value="{{$abogado[0]->documentoAbogado}}">
          </div>

          <div class="col-sm-6">
            <label class="label">Tipo de Documento</label>
            {{ 
              Form::select('selecTipoDocumentoAbogadoEditar', $listaTipoDocumentos, $abogado[0]->tiposidentificacion_idTipoIdentificacion, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selecTipoDocumentoAbogadoEditar', 'style' => 'width:280px'])
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
            <input type="text" id="nombreAbogadoEditar" name="nombreAbogadoEditar" class="form-control" placeholder="Nombre Abogado" value="{{$abogado[0]->nombreAbogado}}">
          </div>

          <div class="col-sm-6">
            <label class="label pull-left">Tarjeta Abogado</label>
            <input type="text" id="tarjetaAbogadoEditar" name="tarjetaAbogadoEditar" class="form-control" placeholder="Tarjeta Abogado" value="{{$abogado[0]->tarjetaAbogado}}">
          </div>
        </div>
      </div>
    </div>
  </form>
</div>

<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
  <button class="btn btn-success btn-editar-abogadoExt"><i class="icon-rocket"></i> <a id="eventUrl" style="color:#fff; text-decoration:none;" onclick="validarEditarAbogadoExt({{$abogado[0]->idAbogado}}, {{$tipoInvolucrado}});">Modificar</a></button>
</div>