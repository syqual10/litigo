<div class="modal-body">
	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-2">
					<label class="control-label pull-right">Funcionarios:</label>
				</div>
				<div class="col-sm-5">
					{{ 
		        		Form::select('selectExportarAgenda', $responsables, null, ['placeholder' => 'Todos', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectExportarAgenda', 'style' => 'margin-bottom:8px;'])
		    		}}
				</div>
			</div>
		</div>
	</div>

	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-2">
					<label class="control-label pull-right">Rango de fechas:</label>
				</div>
				<div class="col-sm-5">
                	<input id="rangoFecha" class="form-control input-daterange-datepicker" type="text" name="daterange" value="{{date('m-d-Y')}}-{{date('m-d-Y')}}"/>
                </div>
			</div>
		</div>
	</div>
</div>