<div class="modal-body">	
	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-2">
					<label class="control-label pull-right">Rango de fechas</label>
				</div>
				<div class="col-sm-4">
					<input id="rangoFecha" class="form-control input-daterange-datepicker" type="text" name="daterange" value="{{date('m-d-Y')}}-{{date('m-d-Y')}}"/>
				</div>
			</div>
		</div>
	</div>

	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	</div>
</div>

<input type="hidden" id="tipoReporte" value="{{$tipoReporte}}">