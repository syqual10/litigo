@php
    $vigenciaActual = date('Y');
@endphp
<div class="modal-body">

    <div class="row" id="ajax-demandantes">
        <div class="row" style="margin-bottom: 15px;" >
            <input id="idRadicado" name="idRadicado" type="hidden" value={{$idRadicado}}>
            <input id="vigenciaRadicado" name="vigenciaRadicado" type="hidden" value={{$vigenciaRadicado}}>

            <div class="row">
                <div class="col-sm-10">
                    <label class="pull-right">Agregar nuevo radicado juzgado:</label>
                </div>
                <div class="col-sm-2">
                    <span class="onoffswitch pull-left">
                        <input type="checkbox" name="start_interval" class="onoffswitch-checkbox" id="inputCamposAsociar" onchange="visualizarCamposAsociar()">
                        <label class="onoffswitch-label" for="inputCamposAsociar">
                            <span class="onoffswitch-inner" data-swchon-text="SI" data-swchoff-text="NO"></span>
                            <span class="onoffswitch-switch"></span>
                        </label>
                    </span>
                </div>
            </div>
            <div id="camposRadicado">

                <!-- Vigencia radicados -->
                <div id="divVigenciaBuscar" >
                    <div class="col-sm-2">
                        <select id="vigenciaProcesoBuscar" class="form-control">
                            <option value='{{ $vigenciaActual }}'>{{ $vigenciaActual }}</option>
                                <?php 
                                for ($i=2003; $i<=$vigenciaActual; $i++) 
                                {
                                    echo "<option value='$i'>$i</option>";
                                }  
                                ?>
                        </select>
                    </div>
                </div>
                <!-- # Vigencia radicados -->
                <div id="divRadicadoSyqual">    
                    <div class="col-sm-2">                                    
                        <input id="criterioBusqueda" class="form-control pull-right" type="text" name="param" placeholder="Radicado..">                                                                                
                    </div>
                    <div class="col-sm-2">
                        <button onclick="asociarProceso(0);" class="btn btn-success pull-left btn-block">
                            <i class="fa fa-check"></i> Asociar
                        </button>
                    </div>
                </div>

            </div>
            <div id="camposJuzgado" style="display: none">

                <div id="divRadicadoSyqual">    
                    <div class="col-sm-4">                                    
                        <input id="criterioBusqueda2" class="form-control pull-right" type="number" name="param" placeholder="Juzgado..">                                                                                
                    </div>
                    <div class="col-sm-2">
                        <button onclick="asociarProceso(1);" class="btn btn-success pull-left btn-block">
                            <i class="fa fa-check"></i> Asociar
                        </button>
                    </div>
                </div>     

            </div>
        </div>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    </div>
    
</div>