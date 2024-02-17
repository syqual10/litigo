<div class="row" style="margin-bottom: 10px;" >
	<div class="form-wrap">
		<div class="form-group">
			<div class="col-sm-3">
				<label class="control-label pull-right">Nombre Etapa</label>
			</div>
			<div class="col-sm-6">
				<input type="text" id="nombreEtapaEditar" name="nombreEtapaEditar" class="form-control" placeholder="Nombre Etapa" value="{{$etapa[0]->nombreEtapa}}">
			</div>
			<div class="col-sm-3">
				<a class="btn btn-success btn-editar-etapaInstancia pull-left" id="eventUrl" onclick="validarEditarEtapaInstancia({{$etapa[0]->idEtapa}}, {{$etapa[0]->juriinstancias_idInstancia}});"><i class="fa fa-edit"></i> Modificar Etapa</a>
			</div>
		</div>
	</div>
</div>