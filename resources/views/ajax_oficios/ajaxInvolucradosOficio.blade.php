<h6>Destinatarios Sugeridos:</h6>
<hr>
@if(count($demandante) > 0)
	<div class="row" style="margin-bottom: 15px;" >
		<div class="col-sm-3">
			<label class="control-label pull-right">Demandante:</label>
		</div>
		<div class="col-sm-6">
			<h4><i class="fa fa-plus-square txt-color-blue"></i>&nbsp;<a href="javascript:void(0);" onclick="implicadoOficio('{{$demandante[0]->nombreSolicitante}}', '{{$demandante[0]->direccionSolicitante}}', {{$demandante[0]->ciudades_idCiudad}});">{{$demandante[0]->nombreSolicitante}}</a></h4>
			<div>
				<div class="url text-success">
					@if($demandante[0]->documentoSolicitante != "") 
						{{$demandante[0]->documentoSolicitante}} 
					@else
						<span class="text-muted">Sin documento registrado</span>
					@endif
					<i class="fa fa-caret-down"></i>
				</div>
			</div>
		</div>
	</div>
@endif

@if(count($abogadoDemandante) > 0)
	<div class="row" style="margin-bottom: 15px;" >
		<div class="col-sm-3">
			<label class="control-label pull-right">Abogado Demandante:</label>
		</div>
		<div class="col-sm-6">
			<h4><i class="fa fa-plus-square txt-color-blue"></i>&nbsp;<a href="javascript:void(0);" onclick="implicadoOficio('{{$abogadoDemandante[0]->nombreAbogado}}', '', '');">{{$abogadoDemandante[0]->nombreAbogado}}</a></h4>
			<div>
				<div class="url text-success">
					@if($abogadoDemandante[0]->documentoAbogado != "") 
						{{$abogadoDemandante[0]->documentoAbogado}} 
					@else
						<span class="text-muted">Sin documento registrado</span>
					@endif
					<i class="fa fa-caret-down"></i>
				</div>
			</div>
		</div>
	</div>
@endif

@if(count($demandado) > 0)
	<div class="row" style="margin-bottom: 15px;" >
		<div class="col-sm-3">
			<label class="control-label pull-right">Demandado:</label>
		</div>
		<div class="col-sm-6">
			<h4><i class="fa fa-plus-square txt-color-blue"></i>&nbsp;<a href="javascript:void(0);" onclick="implicadoOficio('{{$demandado[0]->nombreDependencia}}', '', '');">{{$demandado[0]->nombreDependencia}}</a></h4>
			<div>
				<div class="url text-success">
					@if($demandado[0]->codigoDependencia != "") 
						{{$demandado[0]->codigoDependencia}} 
					@else
						<span class="text-muted">Sin documento registrado</span>
					@endif
					<i class="fa fa-caret-down"></i>
				</div>
			</div>
		</div>
	</div>
@endif

@if(count($convocante) > 0)
	<div class="row" style="margin-bottom: 15px;" >
		<div class="col-sm-3">
			<label class="control-label pull-right">Convocante:</label>
		</div>
		<div class="col-sm-6">
			<h4><i class="fa fa-plus-square txt-color-blue"></i>&nbsp;<a href="javascript:void(0);" onclick="implicadoOficio('{{$convocante[0]->nombreSolicitante}}', '{{$convocante[0]->direccionSolicitante}}', {{$convocante[0]->ciudades_idCiudad}});">{{$convocante[0]->nombreSolicitante}}</a></h4>
			<div>
				<div class="url text-success">
					@if($convocante[0]->documentoSolicitante != "") 
						{{$convocante[0]->documentoSolicitante}} 
					@else
						<span class="text-muted">Sin documento registrado</span>
					@endif
					<i class="fa fa-caret-down"></i>
				</div>
			</div>
		</div>
	</div>
@endif

@if(count($convocadoInterno) > 0)
	<div class="row" style="margin-bottom: 15px;" >
		<div class="col-sm-3">
			<label class="control-label pull-right">Convocado Interno:</label>
		</div>
		<div class="col-sm-6">
			<h4><i class="fa fa-plus-square txt-color-blue"></i>&nbsp;<a href="javascript:void(0);" onclick="implicadoOficio('{{$convocadoInterno[0]->nombreDependencia}}', '', '');">{{$convocadoInterno[0]->nombreDependencia}}</a></h4>
			<div>
				<div class="url text-success">
					@if($convocadoInterno[0]->codigoDependencia != "") 
						{{$convocadoInterno[0]->codigoDependencia}} 
					@else
						<span class="text-muted">Sin documento registrado</span>
					@endif
					<i class="fa fa-caret-down"></i>
				</div>
			</div>
		</div>
	</div>
@endif

@if(count($convocadoExterno) > 0)
	<div class="row" style="margin-bottom: 15px;" >
		<div class="col-sm-3">
			<label class="control-label pull-right">Convocado Externo:</label>
		</div>
		<div class="col-sm-6">
			<h4><i class="fa fa-plus-square txt-color-blue"></i>&nbsp;<a href="javascript:void(0);" onclick="implicadoOficio('{{$convocadoExterno[0]->nombreConvocadoExterno}}', '{{$convocadoExterno[0]->direccionConvocadoExterno}}', '');">{{$convocadoExterno[0]->nombreConvocadoExterno}}</a></h4>
			<div>
				<div class="url text-success">
					@if($convocadoExterno[0]->direccionConvocadoExterno != "") 
						{{$convocadoExterno[0]->direccionConvocadoExterno}} 
					@else
						<span class="text-muted">Sin documento registrado</span>
					@endif
					<i class="fa fa-caret-down"></i>
				</div>
			</div>
		</div>
	</div>
@endif

@if(count($accionante) > 0)
	<div class="row" style="margin-bottom: 15px;" >
		<div class="col-sm-3">
			<label class="control-label pull-right">Accionante:</label>
		</div>
		<div class="col-sm-6">
			<h4><i class="fa fa-plus-square txt-color-blue"></i>&nbsp;<a href="javascript:void(0);" onclick="implicadoOficio('{{$accionante[0]->nombreSolicitante}}', '{{$accionante[0]->direccionSolicitante}}', {{$accionante[0]->ciudades_idCiudad}});">{{$accionante[0]->nombreSolicitante}}</a></h4>
			<div>
				<div class="url text-success">
					@if($accionante[0]->documentoSolicitante != "") 
						{{$accionante[0]->documentoSolicitante}} 
					@else
						<span class="text-muted">Sin documento registrado</span>
					@endif
					<i class="fa fa-caret-down"></i>
				</div>
			</div>
		</div>
	</div>
@endif

@if(count($accionadoInterno) > 0)
	<div class="row" style="margin-bottom: 15px;" >
		<div class="col-sm-3">
			<label class="control-label pull-right">Accionado Interno:</label>
		</div>
		<div class="col-sm-6">
			<h4><i class="fa fa-plus-square txt-color-blue"></i>&nbsp;<a href="javascript:void(0);" onclick="implicadoOficio('{{$accionadoInterno[0]->nombreDependencia}}', '', '');">{{$accionadoInterno[0]->nombreDependencia}}</a></h4>
			<div>
				<div class="url text-success">
					@if($accionadoInterno[0]->codigoDependencia != "") 
						{{$accionadoInterno[0]->codigoDependencia}} 
					@else
						<span class="text-muted">Sin documento registrado</span>
					@endif
					<i class="fa fa-caret-down"></i>
				</div>
			</div>
		</div>
	</div>
@endif

@if(count($accionadoExterno) > 0)
	<div class="row" style="margin-bottom: 15px;" >
		<div class="col-sm-3">
			<label class="control-label pull-right">Accionado Externo:</label>
		</div>
		<div class="col-sm-6">
			<h4><i class="fa fa-plus-square txt-color-blue"></i>&nbsp;<a href="javascript:void(0);" onclick="implicadoOficio('{{$accionadoExterno[0]->nombreConvocadoExterno}}', '{{$accionadoExterno[0]->direccionConvocadoExterno}}', '');">{{$accionadoExterno[0]->nombreConvocadoExterno}}</a></h4>
			<div>
				<div class="url text-success">
					@if($accionadoExterno[0]->direccionConvocadoExterno != "") 
						{{$accionadoExterno[0]->direccionConvocadoExterno}} 
					@else
						<span class="text-muted">Sin documento registrado</span>
					@endif
					<i class="fa fa-caret-down"></i>
				</div>
			</div>
		</div>
	</div>
@endif