<div class="row" style="margin-bottom: 15px;" >
  <div class="form-wrap">
    <div class="form-group">
      <div class="col-sm-6">
        <label class="control-label pull-left">Número de documento</label>
        <input type="number" id="documentoDemandadoNuevo" name="documentoDemandadoNuevo" class="form-control" placeholder="Número de documento">
      </div>

      <div class="col-sm-6">
        <label class="control-label pull-left">Tipo de Documento</label>
        {{ 
          Form::select('selecTipoDocumentoDemandado', $listaTipoDocumentos, null, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selecTipoDocumentoDemandado', 'style' => 'margin-bottom:8px;'])
        }}
      </div>
    </div>
  </div>
</div>

<div class="row" style="margin-top:8px;">
  <div class="form-wrap">
    <div class="form-group">
      <div class="col-sm-6">
        <label class="control-label pull-left">Nombre Demandado</label>
        <input type="text" id="nombreDemandado" name="nombreDemandado" class="form-control" placeholder="Nombre Demandado">
      </div>

      <div class="col-sm-6">
        <label class="control-label pull-left">Correo Demandado</label>
        <input type="text" id="correoDemandado" name="correoDemandado" class="form-control" placeholder="Correo Demandado">
      </div>
    </div>
  </div>
</div>

<div class="row" style="margin-top:8px;">
  <div class="form-wrap">
    <div class="form-group">
      <div class="col-sm-6">
        <label class="control-label pull-left">Teléfono Demandado</label>
        <input type="number" id="telefonoDemandado" name="telefonoDemandado" class="form-control" placeholder="Teléfono Demandado">
      </div>

      <div class="col-sm-6">
        <label class="control-label pull-left">Celular Demandado</label>
        <input type="number" id="celularDemandado" name="celularDemandado" class="form-control" placeholder="Celular Demandado">
      </div>
    </div>
  </div>
</div>

<div class="row" style="margin-top:8px;">
  <div class="form-wrap">
    <div class="form-group">
      <div class="col-sm-6">
        <label class="control-label pull-left">Dirección Demandado</label>
        <input type="text" id="direccionDemandado" name="direccionDemandado" class="form-control" placeholder="Dirección Demandado">
      </div>

      <div class="col-sm-6">
        <label class="control-label pull-left">Ciudad:</label> 
        <select data-placeholder="Seleccionar Ciudad.." class="select2" tabindex="8" id="selectCiudadDemandado" name="selectCiudadDemandado" onchange="elegirBarrioDemandado(this.value);">
          <option value=""></option>
            @if(count($listaDepartamentos) > 0)
              @foreach ($listaDepartamentos as $dep)
                <optgroup label="{{$dep->nombreDepartamento}}">
                  @php 
                      $ciudades = DB::table('ciudades')
                      ->where('departamentos_idDepartamento', '=', $dep->idDepartamento)
                      ->get();
                  @endphp
                @foreach ($ciudades as $ciudad)
                  <option value="{{$ciudad->idCiudad}}" >{{$ciudad->nombreCiudad}}</option>
                @endforeach              
                </optgroup>              
              @endforeach 
            @else
              No hay departamentos
            @endif   
        </select>
      </div>
    </div>
  </div>
</div>

<div class="row" style="margin-top:8px;">
  <div class="form-wrap">
    <div class="form-group">
      <div class="col-sm-6" id="resultadoBarrioDemandado">
        
      </div>
    </div>
  </div>
</div>

<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
  <button class="btn btn-success btn-guardar-demandado"><i class="icon-rocket"></i> <a id="eventUrl" style="color:#fff; text-decoration:none;" onclick="validarGuardarDemandado();">Guardar</a></button>
</div>