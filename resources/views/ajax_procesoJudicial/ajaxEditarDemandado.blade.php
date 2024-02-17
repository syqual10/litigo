<div class="row" style="margin-bottom: 15px;" >
  <div class="form-wrap">
    <div class="form-group">
      <div class="col-sm-6">
        <label class="control-label pull-left">Número de documento</label>
        <input type="number" id="documentoDemandadoNuevoEditar" name="documentoDemandadoNuevoEditar" class="form-control" placeholder="Número de documento" value="{{$demandado[0]->documentoSolicitante}}">
      </div>

      <div class="col-sm-6">
        <label class="control-label pull-left">Tipo de Documento</label>
        {{ 
          Form::select('selecTipoDocumentoEditar', $listaTipoDocumentos, $demandado[0]->tiposidentificacion_idTipoIdentificacion, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selecTipoDocumentoEditar', 'style' => 'margin-bottom:8px;'])
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
        <input type="text" id="nombreDemandadoEditar" name="nombreDemandadoEditar" class="form-control" placeholder="Nombre Demandado" value="{{$demandado[0]->nombreSolicitante}}">
      </div>

      <div class="col-sm-6">
        <label class="control-label pull-left">Correo Demandado</label>
        <input type="text" id="correoDemandadoEditar" name="correoDemandadoEditar" class="form-control" placeholder="Correo Demandado" value="{{$demandado[0]->correoSolicitante}}">
      </div>
    </div>
  </div>
</div>

<div class="row" style="margin-top:8px;">
  <div class="form-wrap">
    <div class="form-group">
      <div class="col-sm-6">
        <label class="control-label pull-left">Teléfono Demandado</label>
        <input type="number" id="telefonoDemandadoEditar" name="telefonoDemandadoEditar" class="form-control" placeholder="Teléfono Demandado" value="{{$demandado[0]->telefonoSolicitante}}">
      </div>

      <div class="col-sm-6">
        <label class="control-label pull-left">Celular Demandado</label>
        <input type="number" id="celularDemandadoEditar" name="celularDemandadoEditar" class="form-control" placeholder="Celular Demandado" value="{{$demandado[0]->celularSolicitante}}">
      </div>
    </div>
  </div>
</div>

<div class="row" style="margin-top:8px;">
  <div class="form-wrap">
    <div class="form-group">
      <div class="col-sm-6">
        <label class="control-label pull-left">Dirección Demandado</label>
        <input type="text" id="direccionDemandadoEditar" name="direccionDemandadoEditar" class="form-control" placeholder="Dirección Demandado" value="{{$demandado[0]->direccionSolicitante}}">
      </div>
      <div class="col-sm-6">
        <label class="control-label pull-left">Ciudad:</label> 
        <select data-placeholder="Seleccionar Ciudad.." class="select2" tabindex="8" id="selectCiudadDemandadoEditar" name="selectCiudadDemandadoEditar" onchange="elegirBarrioDemandadoEditar(this.value, {{$demandado[0]->idSolicitante}});">
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
                    @if($ciudad->idCiudad == $demandado[0]->ciudades_idCiudad)
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
        <div class="col-sm-6" id="resultadoBarrioDemandadoEditar">
          <label class="control-label pull-left">Barrio o Vereda:</label> 
        <select data-placeholder="Seleccionar Ciudad.." class="select2" tabindex="8" id="selectBarrioDemandadoEditar" name="selectBarrioDemandadoEditar">
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
                  @if($barrio->idSubTerritorio == $demandado[0]->subterritorios_idSubTerritorio)
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

<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
  <button class="btn btn-success btn-editar-demandado"><i class="zmdi zmdi-edit"></i> <a id="eventUrl" style="color:#fff; text-decoration:none;" onclick="validarEditarDemandado({{$demandado[0]->idSolicitante}});">Modificar</a></button>
</div>