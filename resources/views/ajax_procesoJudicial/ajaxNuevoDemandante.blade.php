<div class="modal-body">
  <form class="smart-form">
    <div class="row">
      <div class="form-wrap">
        <div class="form-group">
          <div class="col-sm-6">
            <label class="label pull-left">Número de documento</label>
            <input type="number" id="documentoDemandanteNuevo" name="documentoDemandanteNuevo" class="form-control" placeholder="Número de documento" onBlur="involucradoProceso(1);">
          </div>

          <div class="col-sm-6">
            <label class="label">Tipo de Documento</label>
            {{ 
              Form::select('selecTipoDocumento', $listaTipoDocumentos, null, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selecTipoDocumento', 'style' => 'width:280px'])
            }}
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="form-wrap">
        <div class="form-group">
          <div class="col-sm-6">
            <label class="label pull-left">Nombre Demandante</label>
            <input type="text" id="nombreDemandante" name="nombreDemandante" class="form-control" placeholder="Nombre Demandante">
          </div>

          <div class="col-sm-6">
            <label class="label pull-left">Correo Demandante</label>
            <input type="text" id="correoDemandante" name="correoDemandante" class="form-control" placeholder="Correo Demandante">
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="form-wrap">
        <div class="form-group">
          <div class="col-sm-6">
            <label class="label pull-left">Teléfono Demandante</label>
            <input type="number" id="telefonoDemandante" name="telefonoDemandante" class="form-control" placeholder="Teléfono Demandante">
          </div>

          <div class="col-sm-6">
            <label class="label pull-left">Celular Demandante</label>
            <input type="number" id="celularDemandante" name="celularDemandante" class="form-control" placeholder="Celular Demandante">
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="form-wrap">
        <div class="form-group">
          <div class="col-sm-6">
            <label class="label pull-left">Dirección Demandante</label>
            <input type="text" id="direccionDemandante" name="direccionDemandante" class="form-control" placeholder="Dirección Demandante">
          </div>

          <div class="col-sm-6">
            <label class="label">Ciudad:</label> 
            <select data-placeholder="Seleccionar Ciudad.." class="select2" tabindex="8" id="selectCiudadDemandante" name="selectCiudadDemandante" onchange="elegirBarrioDemandante(this.value);">
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
    <div class="row">
      <div class="form-wrap">
        <div class="form-group">
          <div class="col-sm-6" id="resultadoBarrioDemandante">
            
          </div>
        </div>
      </div>
    </div>
  </form>
</div>

<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
  <button class="btn btn-success btn-guardar-demandante"><i class="icon-rocket"></i> <a id="eventUrl" style="color:#fff; text-decoration:none;" onclick="validarGuardarDemandante();">Guardar</a></button>
</div>