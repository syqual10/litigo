<div class="modal-body">
	<!-- Row -->
	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-3">
					<label class="control-label pull-right">Código Dependencia</label>
				</div>
				<div class="col-sm-6">
					<input type="text" id="codigoDependenciaEditar" name="codigoDependenciaEditar" class="form-control" placeholder="Código Dependencia" value="{{$dependencia[0]->codigoDependencia}}">
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
					<input type="text" id="nombreDependenciaEditar" name="nombreDependenciaEditar" class="form-control" placeholder="Nombre Dependencia" value="{{$dependencia[0]->nombreDependencia}}">
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
					<textarea class="form-control" rows="5" id="propositoDependenciaEditar" name="propositoDependenciaEditar">{{$dependencia[0]->propositoDependencia}}</textarea>
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
	            		Form::select('selectDependenciaEditar', $listaDependencias, $dependencia[0]->dependencias_idDependencia, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'class' => 'select2','id'=>'selectDependenciaEditar', 'style' => 'margin-bottom:8px;'])
	        		}}
				</div>
			</div>
		</div>
	</div>

	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		<button class="btn btn-success btn-editar-dependencia"><i class="zmdi zmdi-edit"></i> <a id="eventUrl" style="color:#fff; text-decoration:none;" onclick="validarEditarDependencia({{$dependencia[0]->idDependencia}});">Modificar</a></button>
	</div>
</div>