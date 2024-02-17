<div class="modal-body">
	<!-- Row -->
	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-3">
					<label class="control-label pull-right">Código Dependencia</label>
				</div>
				<div class="col-sm-6">
					<input type="text" id="codigoDependencia" name="codigoDependencia" class="form-control" placeholder="Código Dependencia">
				</div>
			</div>
		</div>
	</div>

	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-3">
					<label class="control-label pull-right">Nombre Dependencia</label>
				</div>
				<div class="col-sm-6">
					<input type="text" id="nombreDependencia" name="nombreDependencia" class="form-control" placeholder="Nombre Dependencia">
				</div>
			</div>
		</div>
	</div>
	<!-- /Row -->

	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-3">
					<label class="control-label pull-right">Propósito Dependencia</label>
				</div>
				<div class="col-sm-6">
					<textarea class="form-control" rows="5" id="propositoDependencia" name="propositoDependencia"></textarea>
				</div>
			</div>
		</div>
	</div>

	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-3">
					<label class="control-label pull-right">Dependencias:</label>
				</div>
				<div class="col-sm-6">
					{{ 
	            		Form::select('selectDependencia', $listaDependencias, null, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectDependencia', 'style' => 'margin-bottom:8px;'])
	        		}}
				</div>
			</div>
		</div>
	</div>

	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		<button class="btn btn-success btn-guardar-dependencia"><i class="icon-rocket"></i> <a id="eventUrl" style="color:#fff; text-decoration:none;" onclick="validarGuardarDependencia();">Guardar</a></button>
	</div>
</div>