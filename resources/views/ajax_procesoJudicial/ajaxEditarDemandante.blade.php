<div class="modal-body">
  <div class="row" style="margin-bottom: 15px;" >
    <div class="form-wrap">
      <div class="form-group">
        <div class="col-sm-6">
          <label class="control-label pull-left">Número de documento</label>
          <input type="number" id="documentoDemandanteNuevoEditar" name="documentoDemandanteNuevoEditar" class="form-control" placeholder="Número de documento" value="{{$demandante[0]->documentoSolicitante}}">
        </div>
        <div class="col-sm-6">
          <label class="control-label pull-left">Tipo de Documento</label>
          {{ 
            Form::select('selecTipoDocumentoEditar', $listaTipoDocumentos, $demandante[0]->tiposidentificacion_idTipoIdentificacion, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selecTipoDocumentoEditar', 'style' => 'margin-bottom:8px;'])
          }}
        </div>
      </div>
    </div>
  </div>

  <div class="row" style="margin-top:8px;">
    <div class="form-wrap">
      <div class="form-group">
        <div class="col-sm-6">
          <label class="control-label pull-left">Nombre Demandante</label>
          <input type="text" id="nombreDemandanteEditar" name="nombreDemandanteEditar" class="form-control" placeholder="Nombre Demandante" value="{{$demandante[0]->nombreSolicitante}}">
        </div>

        <div class="col-sm-6">
          <label class="control-label pull-left">Correo Demandante</label>
          <input type="text" id="correoDemandanteEditar" name="correoDemandanteEditar" class="form-control" placeholder="Correo Demandante" value="{{$demandante[0]->correoSolicitante}}">
        </div>
      </div>
    </div>
  </div>

  <div class="row" style="margin-top:8px;">
    <div class="form-wrap">
      <div class="form-group">
        <div class="col-sm-6">
          <label class="control-label pull-left">Teléfono Demandante</label>
          <input type="number" id="telefonoDemandanteEditar" name="telefonoDemandanteEditar" class="form-control" placeholder="Teléfono Demandante" value="{{$demandante[0]->telefonoSolicitante}}">
        </div>

        <div class="col-sm-6">
          <label class="control-label pull-left">Celular Demandante</label>
          <input type="number" id="celularDemandanteEditar" name="celularDemandanteEditar" class="form-control" placeholder="Celular Demandante" value="{{$demandante[0]->celularSolicitante}}">
        </div>
      </div>
    </div>
  </div>

  <div class="row" style="margin-top:8px;">
    <div class="form-wrap">
      <div class="form-group">
        <div class="col-sm-6">
          <label class="control-label pull-left">Dirección Demandante</label>
          <input type="text" id="direccionDemandanteEditar" name="direccionDemandanteEditar" class="form-control" placeholder="Dirección Demandante" value="{{$demandante[0]->direccionSolicitante}}">
        </div>

        <div class="col-sm-6">
          <label class="control-label pull-left">Ciudad:</label> 
          <select data-placeholder="Seleccionar Ciudad.." class="select2" tabindex="8" id="selectCiudadDemandanteEditar" name="selectCiudadDemandanteEditar" onchange="elegirBarrioDemandanteEditar(this.value, {{$demandante[0]->idSolicitante}});">
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
                      @if($ciudad->idCiudad == $demandante[0]->ciudades_idCiudad)
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
        <div class="col-sm-6" id="resultadoBarrioDemandanteEditar">
          <label class="control-label pull-left">Barrio o Vereda:</label> 
          <select data-placeholder="Seleccionar Ciudad.." class="select2" tabindex="8" id="selectBarrioDemandanteEditar" name="selectBarrioDemandanteEditar">
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
                    @if($barrio->idSubTerritorio == $demandante[0]->subterritorios_idSubTerritorio)
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
  <button class="btn btn-success btn-editar-demandante"><i class="zmdi zmdi-edit"></i> <a id="eventUrl" style="color:#fff; text-decoration:none;" onclick="validarEditarDemandante({{$demandante[0]->idSolicitante}});">Modificar</a></button>
</div>