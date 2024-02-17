<div class="modal-body">

	<div class="row" style="margin-bottom: 15px;" >
		<div class="form-wrap">
			<div class="form-group">
				<div class="col-sm-3">
					<label class="control-label pull-right">Unidad Monetaria</label>
				</div>
				<div class="col-sm-6">
				    <select class="form-control select2" id="selectUnidadMonetaria" name="selectUnidadMonetaria" onchange="seleccionUnidadMonetaria(this.value);" style="width:250px">
	                    <option value="0">Seleccione Unidad Monetaria</option>
	                    <option value="1">Salarios mínimos</option>
	                    <option value="2">Pesos</option>
	                </select>
				</div>
			</div>
		</div>
	</div>

	<div id="divPesos" style="display: none;">
		<div class="row" style="margin-bottom: 15px;" >
			<div class="form-wrap">
				<div class="form-group">
					<div class="col-sm-3">
						<label class="control-label pull-right">Valor</label>
					</div>
					<div class="col-sm-6">
					    <input type="text" id="valor" name="valor" class="form-control" placeholder="Valor" onkeyup="format(this)" onchange="format(this)" onkeypress="return justNumbers(event);" onBlur="copiar();">
					</div>
				</div>
			</div>
		</div>
	</div>


	<div id="divSalariosMinimos" style="display: none;">
		<div class="row" style="margin-bottom: 15px;" >
			<div class="form-wrap">
				<div class="form-group">
					<div class="col-sm-3">
						<label class="control-label pull-right">Salarios Mínimo</label>
					</div>
					<div class="col-sm-6">
					    <input type="hidden" name="slv" id="slv" value="{{$slv}}">
                        <input type="text" id="valorSalarios" name="valorSalarios" class="form-control" placeholder="Salarios Mínimos" onkeyup="format(this)" onchange="format(this)" oninput="salarioAPesos(this);">
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="divValores" style="display: none;">
		<div class="row" style="margin-bottom: 15px;" >
			<div class="form-wrap">
				<div class="form-group">
					<div class="col-sm-3">
						<label class="control-label pull-right">Valor en pesos</label>
					</div>
					<div class="col-sm-6">
					    <input type="text" id="valorPesos" name="valorPesos" class="form-control" placeholder="Valor en pesos" readonly> 
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		<button class="btn btn-success btn-guardar-cuantia"><i class="icon-rocket"></i> <a id="eventUrl" style="color:#fff; text-decoration:none;" onclick="validarGuardarCuantia();">Guardar</a></button>
	</div>
</div>