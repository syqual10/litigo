<div class="modal-body">
	<div class="row">
		<form id="wizard-1" novalidate="novalidate" class="smart-form">
		    <div id="bootstrap-wizard-1" class="col-sm-12">
		        <div class="form-bootstrapWizard">
		            <ul class="bootstrapWizard form-wizard">
		                <li class="active" data-target="#step1">
		                    <a href="#tab1" data-toggle="tab"> <span class="step">1</span> <span class="title">Editar Instancia</span> </a>
		                </li>
		                <li data-target="#step2">
		                    <a href="#tab2" data-toggle="tab" onclick="etapasInstancia({{$instancia[0]->idInstancia}});"> <span class="step">2</span> <span class="title">Etapas de la instancia</span> </a>
		                </li>
		            </ul>
		            <div class="clearfix"></div>
		        </div>
		        <div class="tab-content">
		            <div class="tab-pane active" id="tab1">
		                <hr>
			          	<div class="row" style="margin-bottom: 15px;" >
							<div class="form-wrap">
								<div class="form-group">
									<div class="col-sm-3">
										<label class="control-label pull-right">Nombre Instancia</label>
									</div>
									<div class="col-sm-6">
										<input type="text" id="nombreInstanciaEditar" name="nombreInstanciaEditar" class="form-control" placeholder="Nombre Instancia" value="{{$instancia[0]->nombreInstancia}}">
									</div>
								</div>
								<a class="btn btn-success btn-editar-instancia" id="eventUrl" style="color:#fff; text-decoration:none;" onclick="validarEditarInstancia({{$instancia[0]->idInstancia}});"><i class="fa fa-edit"></i> Modificar</a>
								<a class="btn btn-danger" id="eventUrl" style="color:#fff; text-decoration:none;" onclick="eliminarInstancia({{$instancia[0]->idInstancia}});"><i class="fa fa-trash"></i> Eliminar</a>
							</div>
						</div>
		            </div>

		            <div class="tab-pane" id="tab2">
		               <hr>
			          	<div class="row" style="margin-bottom: 15px;" >
							<div class="form-wrap">
								<div class="col-sm-12">
									<div id="resultadoEtapasInstancia">
		                        		<!-- ajax -->
		                    		</div>
								</div>
							</div>
						</div>
		            </div>
		        </div>
		    </div>
		</form>
	</div>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-default pull-right" data-dismiss="modal"><i class="fa fa-times-circle"></i> Cerrar</button>
</div>