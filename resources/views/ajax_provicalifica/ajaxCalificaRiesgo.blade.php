<span>La cuantificación de cada rango de calificación del riesgo es un valor entre 0 y 100, el cual es sugerido por parte de la ANDJE, y puede modificarlo si lo considera necesario.
</span>

<label class="control-label pull-right">Alto</label>
<input type="number" id="tipoAlto" value="{{$valorTipoCalificaciones[0]->valorTipoCalificacion}}">

<label class="control-label pull-right">Medio Alto</label>
<input type="number" id="tipoMedioAlto" value="{{$valorTipoCalificaciones[1]->valorTipoCalificacion}}">

<label class="control-label pull-right">Medio Bajo</label>
<input type="number" id="tipoMedioBajo" value="{{$valorTipoCalificaciones[2]->valorTipoCalificacion}}">

<label class="control-label pull-right">Bajo</label>
<input type="number" id="tipoBajo" value="{{$valorTipoCalificaciones[3]->valorTipoCalificacion}}">

<div class="row" style="margin-bottom: 15px;" >
	<div class="form-wrap">
		<div class="form-group">
			<div class="col-sm-3">
				<label class="control-label pull-right">{{$criterios[0]->nombreCriterio}}</label>
				<br>
				{{$criterios[0]->descripcionCriterio}}
			</div>
			<div class="col-sm-6">
				{{ 
            		Form::select('selectCriterio1', $listaTipoCalificaciones, null, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectCriterio1', 'style' => 'margin-bottom:8px;', 'onchange' => 'valorRangoCriterio(this.value, 1)'])
        		}}
			</div>
		</div>
	</div>
	<input type="text" id="valorCriterio1" value="{{$criterios[0]->criterioSugerido}}">
	<input type="hidden" id="valorRangoCriterio1">
</div>

<div class="row" style="margin-bottom: 15px;" >
	<div class="form-wrap">
		<div class="form-group">
			<div class="col-sm-3">
				<label class="control-label pull-right">{{$criterios[1]->nombreCriterio}}</label>
				<br>
				{{$criterios[1]->descripcionCriterio}}
			</div>
			<div class="col-sm-6">
				{{ 
            		Form::select('selectCriterio2', $listaTipoCalificaciones, null, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectCriterio2', 'style' => 'margin-bottom:8px;', 'onchange' => 'valorRangoCriterio(this.value, 2)'])
        		}}
			</div>
		</div>
	</div>
	<input type="text" id="valorCriterio2" value="{{$criterios[1]->criterioSugerido}}">
	<input type="hidden" id="valorRangoCriterio2">
</div>

<div class="row" style="margin-bottom: 15px;" >
	<div class="form-wrap">
		<div class="form-group">
			<div class="col-sm-3">
				<label class="control-label pull-right">{{$criterios[2]->nombreCriterio}}</label>
				<br>
				{{$criterios[2]->descripcionCriterio}}
			</div>
			<div class="col-sm-6">
				{{ 
            		Form::select('selectCriterio3', $listaTipoCalificaciones, null, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectCriterio3', 'style' => 'margin-bottom:8px;', 'onchange' => 'valorRangoCriterio(this.value, 3)'])
        		}}
			</div>
		</div>
	</div>
	<input type="text" id="valorCriterio3" value="{{$criterios[2]->criterioSugerido}}">
	<input type="hidden" id="valorRangoCriterio3">
</div>

<div class="row" style="margin-bottom: 15px;" >
	<div class="form-wrap">
		<div class="form-group">
			<div class="col-sm-3">
				<label class="control-label pull-right">{{$criterios[3]->nombreCriterio}}</label>
				<br>
				{{$criterios[3]->descripcionCriterio}}
			</div>
			<div class="col-sm-6">
				{{ 
            		Form::select('selectCriterio4', $listaTipoCalificaciones, null, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectCriterio4', 'style' => 'margin-bottom:8px;', 'onchange' => 'valorRangoCriterio(this.value, 4)'])
        		}}
			</div>
		</div>
	</div>
	<input type="text" id="valorCriterio4" value="{{$criterios[3]->criterioSugerido}}">
	<input type="hidden" id="valorRangoCriterio4">
</div>

<button class="btn btn-success btn-guardar-calificacion"><i class="icon-rocket"></i> <a id="eventUrl" style="color:#fff; text-decoration:none;" onclick="validarGuardarCalificacion();">Agregar</a></button>