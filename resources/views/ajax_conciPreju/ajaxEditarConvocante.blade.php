<div class="modal-body">
  <div class="row" style="margin-bottom: 15px;" >
    <div class="form-wrap">
      <div class="form-group">
        <div class="col-sm-6">
          <label class="control-label pull-left">Número de documento</label>
          <input type="number" id="documentoConvocanteNuevoEditar" name="documentoConvocanteNuevoEditar" class="form-control" placeholder="Número de documento" value="{{$convocante[0]->documentoSolicitante}}">
        </div>
        <div class="col-sm-6">
          <label class="control-label pull-left">Tipo de Documento</label>
          {{ 
            Form::select('selecTipoDocumentoEditar', $listaTipoDocumentos, $convocante[0]->tiposidentificacion_idTipoIdentificacion, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selecTipoDocumentoEditar', 'style' => 'margin-bottom:8px;'])
          }}
        </div>
      </div>
    </div>
  </div>

  <div class="row" style="margin-top:8px;">
    <div class="form-wrap">
      <div class="form-group">
        <div class="col-sm-6">
          <label class="control-label pull-left">Nombre Convocante</label>
          <input type="text" id="nombreConvocanteEditar" name="nombreConvocanteEditar" class="form-control" placeholder="Nombre Convocante" value="{{$convocante[0]->nombreSolicitante}}">
        </div>

        <div class="col-sm-6">
          <label class="control-label pull-left">Correo Convocante</label>
          <input type="text" id="correoConvocanteEditar" name="correoConvocanteEditar" class="form-control" placeholder="Correo Convocante" value="{{$convocante[0]->correoSolicitante}}">
        </div>
      </div>
    </div>
  </div>

  <div class="row" style="margin-top:8px;">
    <div class="form-wrap">
      <div class="form-group">
        <div class="col-sm-6">
          <label class="control-label pull-left">Teléfono Convocante</label>
          <input type="number" id="telefonoConvocanteEditar" name="telefonoConvocanteEditar" class="form-control" placeholder="Teléfono Convocante" value="{{$convocante[0]->telefonoSolicitante}}">
        </div>

        <div class="col-sm-6">
          <label class="control-label pull-left">Celular Convocante</label>
          <input type="number" id="celularConvocanteEditar" name="celularConvocanteEditar" class="form-control" placeholder="Celular Convocante" value="{{$convocante[0]->celularSolicitante}}">
        </div>
      </div>
    </div>
  </div>

  <div class="row" style="margin-top:8px;">
    <div class="form-wrap">
      <div class="form-group">
        <div class="col-sm-6">
          <label class="control-label pull-left">Dirección Convocante</label>
          <input type="text" id="direccionConvocanteEditar" name="direccionConvocanteEditar" class="form-control" placeholder="Dirección Convocante" value="{{$convocante[0]->direccionSolicitante}}">
        </div>

        <div class="col-sm-6">
          <label class="control-label pull-left">Ciudad:</label> 
          <select data-placeholder="Seleccionar Ciudad.." class="select2" tabindex="8" id="selectCiudadConvocanteEditar" name="selectCiudadConvocanteEditar" onchange="elegirBarrioConvocanteEditar(this.value, {{$convocante[0]->idSolicitante}});">
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
                      @if($ciudad->idCiudad == $convocante[0]->ciudades_idCiudad)
                        <option value="{{$ciudad->idCiudad}}" selected>{{$ciudad->nombreCiudad}}</option>
                      @else
                        <option value="{{$ciudad->idCiudad}}" >{{$ciudad->nombreCiudad}}</option>
                      @endif
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
        <div class="col-sm-6" id="resultadoBarrioConvocanteEditar">
          <label class="control-label pull-left">Barrio o Vereda:</label> 
          <select data-placeholder="Seleccionar Ciudad.." class="select2" tabindex="8" id="selectBarrioConvocanteEditar" name="selectBarrioConvocanteEditar">
            <option value=""></option>
              @if(count($listaBarrios) > 0)
                  @foreach ($listaBarrios as $barrio)
                    <optgroup label="{{$barrio->nombreTerritorio}}">
                      @php 
                          $listaSubBarrios = DB::table('subterritorios')
                            ->where('territorios_idTerritorio', '=', $barrio->idTerritorio)
                            ->get();
                      @endphp
                  @foreach ($listaSubBarrios as $barrio)
                    @if($barrio->idSubTerritorio == $convocante[0]->subterritorios_idSubTerritorio)
                      <option value="{{$barrio->idSubTerritorio}}" selected>{{$barrio->nombreSubTerritorio}}</option>
                    @else
                      <option value="{{$barrio->idSubTerritorio}}">{{$barrio->nombreSubTerritorio}}</option>
                    @endif
                      @endforeach              
                    </optgroup>              
                  @endforeach 
              @else
                No hay barrios o comunas
              @endif   
          </select>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
  <button class="btn btn-success btn-editar-Convocante"><i class="zmdi zmdi-edit"></i> <a id="eventUrl" style="color:#fff; text-decoration:none;" onclick="validarEditarConvocante({{$convocante[0]->idSolicitante}});">Modificar</a></button>
</div>