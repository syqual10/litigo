<style>
	.label{
		color:#000;
	}
</style>
<h6><strong>{{$paso->queHacePaso}}</strong></h6>
<p class="note">
	<strong>Paso 1.1</strong> {{$paso->comoHacePaso}}
</p>
<br>
<label class="label">Fecha en la que se realizó el paso:</label>
<input type="text" id="fechaPaso" name="fechaPaso" class="form-control datepicker" data-dateformat="yyyy-mm-dd" style="width:50%">

<label class="label">Observación relacionada con el paso realizado:</label>
<textarea name="comentarioPaso" id="comentarioPaso" rows="2" class="form-control" placeholder="Si lo requiere escriba una breve observación"></textarea>
<br>
<div class="row">
	<div class="col-sm-9">		
		<button class="btn btn-default btn-xs pull-right" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
	</div>
	<div class="col-sm-3">		
		<button class="btn btn-success btn-xs pull-right" onclick="marcarPaso({{$paso->idPaso.', '.$accion}})"><i class="fa fa-save"></i> Guardar</button>
	</div>
</div>