<div class="modal-body">
  <form class="smart-form">
    <div class="row">
      <div class="form-wrap">
        <div class="form-group">
          <div class="col-sm-6">
            <label class="label pull-left">Número de documento</label>
            <input type="number" id="documentoAccionanteNuevo" name="documentoAccionanteNuevo" class="form-control" placeholder="Número de documento" onBlur="involucradoProceso(7);">
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
            <label class="label pull-left">Nombre Accionante</label>
            <input type="text" id="nombreAccionante" name="nombreAccionante" class="form-control" placeholder="Nombre Accionante">
          </div>

          <div class="col-sm-6">
            <label class="label pull-left">Correo Accionante</label>
            <input type="text" id="correoAccionante" name="correoAccionante" class="form-control" placeholder="Correo Accionante">
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="form-wrap">
        <div class="form-group">
          <div class="col-sm-6">
            <label class="label pull-left">Teléfono Accionante</label>
            <input type="number" id="telefonoAccionante" name="telefonoAccionante" class="form-control" placeholder="Teléfono Accionante">
          </div>

          <div class="col-sm-6">
            <label class="label pull-left">Celular Accionante</label>
            <input type="number" id="celularAccionante" name="celularAccionante" class="form-control" placeholder="Celular Accionante">
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="form-wrap">
        <div class="form-group">
          <div class="col-sm-6">
            <label class="label pull-left">Dirección Accionante</label>
            <input type="text" id="direccionAccionante" name="direccionAccionante" class="form-control" placeholder="Dirección Accionante">
          </div>

          <div class="col-sm-6">
            <label class="label">Ciudad:</label> 
            <select data-placeholder="Seleccionar Ciudad.." class="select2" tabindex="8" id="selectCiudadAccionante" name="selectCiudadAccionante" onchange="elegirBarrioAccionante(this.value);">
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
          <div class="col-sm-6" id="resultadoBarrioAccionante">
            
          </div>
        </div>
      </div>
    </div>
  </form>
</div>

<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
  <button class="btn btn-success btn-guardar-Accionante"><i class="icon-rocket"></i> <a id="eventUrl" style="color:#fff; text-decoration:none;" onclick="validarGuardarAccionante();">Guardar</a></button>
</div>