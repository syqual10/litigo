<fieldset>
    <br>
    <div class="row">
        <div class="col-sm-4">
            <div class="row">
                <div class="col-sm-2">
                    <span class="pasos">1</span>
                </div>
                <div class="col-sm-10" style="border-left: 3px solid #20c2f8;height:52px">
                    <span class="pull-left" style="font-weight: 600">Elija las columnas que desea incorporar en el reporte.  Elija al menos una columna.</span>                    
                </div>
            </div>
        </div>
    </div>
    <hr>
    <button class="btn btn-success pull-left" style="margin-left:30px" onclick="selectAllItems()">
        <i class="fa fa-check"></i> Seleccionar todos
    </button>
    <div id="shared-lists" class="row">
        <div class="col-sm-4">
            <div id="column-left" class="list-group col">
                @foreach ($columnas as $columna)
                    <div class="list-group-item item-lista tinted" id="{{$columna["id"]}}"><span style="font-weight: 600">{{$columna["columna"]}}</span></div>
                @endforeach
            </div>
        </div>
        <div class="col-sm-4">
            <div id="column-right" class="list-group col">

            </div>
        </div>
    </div>
    <hr />
    <div class="row">
        <div class="col-sm-4">
            <div class="row">
                <div class="col-sm-2">
                    <span class="pasos">2</span>
                </div>
                <div class="col-sm-10" style="border-left: 3px solid #20c2f8;height:52px">
                    <span class="pull-left" style="font-weight: 600">Seleccione los criterios de búsqueda de acuerdo a sus necesidades:</span>                    
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row" style="background:#ececec;padding:30px 10px;border:1px solid #ddd">                                
        <div class="col-sm-6">
            <div class="row">
                <div class="col-sm-3">
                    <label class="col-form-label pull-right">Tipo de proceso:</label>
                </div>
                <div class="col-sm-9">
                    {{

                        Form::select('selectTipoProceso',  $listaProcesos , 1, [ 'class' => 'form-control', 'class' => 'select2','multiple', 'id'=>'selectTipoProceso', 'style' => 'margin-bottom:8px;'])
                    }}                                     
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-3">
                    <label class="col-form-label pull-right">Estado:</label>
                </div>
                <div class="col-sm-9">
                    {{ 
                        Form::select('selectEstadoRadicado', $listaEstadosRadicados, 1, [ 'class' => 'form-control', 'class' => 'select2','multiple', 'id'=>'selectEstadoRadicado', 'style' => 'margin-bottom:8px;'])
                    }}
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-3">
                    <label class="col-form-label pull-right">Medios de Control:</label>
                </div>
                <div class="col-sm-9">
                    {{ 
                        Form::select('selectMedioControl',  $listaTipoMediosControl, null, ['placeholder' => 'Todos', 'class' => 'form-control', 'class' => 'select2','multiple', 'id'=>'selectMedioControl', 'style' => 'margin-bottom:8px;'])
                    }}
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-3">
                    <label class="col-form-label pull-right">Acciones:</label>
                </div>
                <div class="col-sm-9">
                    {{ 
                        Form::select('selectAccion', $listaAcciones, null, ['placeholder' => 'Todos', 'class' => 'form-control','multiple', 'class' => 'select2', 'id'=>'selectAccion', 'style' => 'margin-bottom:8px;'])
                    }}
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-3">
                    <label class="col-form-label pull-right">Funcionarios:</label>
                </div>
                <div class="col-sm-9">
                    {{ 
                        Form::select('selectUsuario', $listaUsuarios, null, ['placeholder' => 'Todos', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectUsuario','multiple', 'style' => 'margin-bottom:8px;'])
                    }}
                </div>
            </div>
            <br>
            <br>
            <div class="row">
                <div class="col-sm-3">
                    <label class="col-form-label pull-right">Fecha Inicial:</label>
                </div>
                <div class="col-sm-3">
                    <input id="fechaInicial" type="text" class="form-control" placeholder="Fecha Inicial"> 
                </div>
                <div class="col-sm-2">
                    <label class="col-form-label pull-right">Fecha Final:</label>
                </div>
                <div class="col-sm-3">
                    <input id="fechaFinal" type="text" class="form-control" placeholder="Fecha Final">
                </div>
            </div> 
        </div>
        <div class="col-sm-6">
            <div class="row">
                <div class="col-sm-3">
                    <label class="col-form-label pull-right">Juzgados:</label>
                </div>
                <div class="col-sm-9">
                    {{ 
                        Form::select('selectJuzgado', $listaJuzgados, null, ['placeholder' => 'Todos', 'class' => 'form-control', 'class' => 'select2','multiple', 'id'=>'selectJuzgado', 'style' => 'margin-bottom:8px;'])
                    }}
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-3">
                    <label class="col-form-label pull-right">Secretaría Vinculada:</label>
                </div>
                <div class="col-sm-9">
                    {{ 
                        Form::select('selectSecretaria', $listaSecretarias, null, ['placeholder' => 'Todos', 'class' => 'form-control', 'class' => 'select2','multiple', 'id'=>'selectSecretaria', 'style' => 'margin-bottom:8px;'])
                    }}
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-3">
                    <label class="col-form-label pull-right">Tipo de Actuación:</label>
                </div>
                <div class="col-sm-9">
                    {{ 
                        Form::select('selectTipoActuacion', $listaTipoActuaciones, null, ['placeholder' => 'Todos', 'class' => 'form-control','multiple', 'class' => 'select2', 'id'=>'selectTipoActuacion', 'style' => 'margin-bottom:8px;'])
                    }}
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-3">
                    <label class="col-form-label pull-right">Fallos Instancias:</label>
                </div>
                <div class="col-sm-9">
                    {{ 
                        Form::select('selectFalloInstancia', $listaFallosInstancias, null, ['placeholder' => 'Todos', 'class' => 'form-control','multiple', 'class' => 'select2', 'id'=>'selectFalloInstancia', 'style' => 'margin-bottom:8px;'])
                    }}
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-sm-3">
                    <label class="col-form-label pull-right">Abogados Demandantes:</label>
                </div>
                <div class="col-sm-9">
                    {{ 
                        Form::select('selectAbogadoDemandante', $listaAbogadosApoderados, null, ['placeholder' => 'Todos', 'class' => 'form-control', 'class' => 'select2','multiple', 'id'=>'selectAbogadoDemandante', 'style' => 'margin-bottom:8px;'])
                    }}
                </div>
            </div>                       
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-sm-4">
            <div class="row">
                <div class="col-sm-2">
                    <span class="pasos">3</span>
                </div>
                <div class="col-sm-10" style="border-left: 3px solid #20c2f8;height:52px">
                    <span class="pull-left" style="font-weight: 600">Haga clic en el botón "Generar Excel" para descargar el archivo con el informe solicitado:</span>                    
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-sm-4">
            <button class="btn btn-success pull-left" style="margin-left:30px" onclick="crearReporteExcel()">
                <i class="fa fa-arrow-circle-down"></i> Generar Excel
            </button>
        </div>
    </div>
</fieldset>