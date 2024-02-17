<div class="modal-body">	
	<!-- Row -->
	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-3">
					<label class="control-label pull-right">Vigencia IPC</label>
				</div>
				<div class="col-sm-6">
					{{ 
	            		Form::select('selectVigenciaIpcEditar', $listaVigencias, $ipc[0]->jurivigenciaindices_idVigenciaIndice, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectVigenciaIpcEditar', 'style' => 'margin-bottom:8px;'])
	        		}}
				</div>
			</div>
		</div>
	</div>

	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-3">
					<label class="control-label pull-right">Mes IPC</label>
				</div>
				<div class="col-sm-6">
					{{ 
	            		Form::select('selectMesIpcEditar', $listaMeses, $ipc[0]->meses_idmes, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectMesIpcEditar', 'style' => 'margin-bottom:8px;'])
	        		}}
				</div>
			</div>
		</div>
	</div>

	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-3">
					<label class="control-label pull-right">Valor IPC</label>
				</div>
				<div class="col-sm-6">
					<input type="text" id="valorIpcEditar" name="valorIpcEditar" class="form-control" placeholder="ValorIpc" value="{{$ipc[0]->valorIndice}}">
				</div>
			</div>
		</div>
	</div>

	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		<button class="btn btn-success btn-editar-ipc"><i class="icon-rocket"></i> <a id="eventUrl" style="color:#fff; text-decoration:none;" onclick="validarEditarIpc({{$ipc[0]->idIndice}});">Guardar</a></button>
	</div>
</div>