<div class="modal-body">
  <form class="smart-form">
    <div class="row">
      <div class="form-wrap">
        <div class="form-group">
          <div class="col-sm-6">
            <label class="label pull-left">Número de documento</label>
            <input type="number" id="documentoConvocanteNuevo" name="documentoConvocanteNuevo" class="form-control" placeholder="Número de documento" onBlur="involucradoProceso(4);">
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
            <label class="label pull-left">Nombre Convocante</label>
            <input type="text" id="nombreConvocante" name="nombreConvocante" class="form-control" placeholder="Nombre Convocante">
          </div>

          <div class="col-sm-6">
            <label class="label pull-left">Correo Convocante</label>
            <input type="text" id="correoConvocante" name="correoConvocante" class="form-control" placeholder="Correo Convocante">
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="form-wrap">
        <div class="form-group">
          <div class="col-sm-6">
            <label class="label pull-left">Teléfono Convocante</label>
            <input type="number" id="telefonoConvocante" name="telefonoConvocante" class="form-control" placeholder="Teléfono Convocante">
          </div>

          <div class="col-sm-6">
            <label class="label pull-left">Celular Convocante</label>
            <input type="number" id="celularConvocante" name="celularConvocante" class="form-control" placeholder="Celular Convocante">
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="form-wrap">
        <div class="form-group">
          <div class="col-sm-6">
            <label class="label pull-left">Dirección Convocante</label>
            <input type="text" id="direccionConvocante" name="direccionConvocante" class="form-control" placeholder="Dirección Convocante">
          </div>

          <div class="col-sm-6">
            <label class="label">Ciudad:</label> 
            <select data-placeholder="Seleccionar Ciudad.." class="select2" tabindex="8" id="selectCiudadConvocante" name="selectCiudadConvocante" onchange="elegirBarrioConvocante(this.value);">
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
          <div class="col-sm-6" id="resultadoBarrioConvocante">
            
          </div>
        </div>
      </div>
    </div>
  </form>
</div>

<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
  <button class="btn btn-success btn-guardar-Convocante"><i class="icon-rocket"></i> <a id="eventUrl" style="color:#fff; text-decoration:none;" onclick="validarGuardarConvocante();">Guardar</a></button>
</div>