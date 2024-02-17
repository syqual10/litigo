@if ($escala == 1)
    @php
        $color = "success";
        $titulo = "Baja";
        $texto = $criterio->bajaDescripcion;
        $minimo = $criterio->bajaMin;
        $maximo = $criterio->bajaMax;
    @endphp
@elseif($escala == 2)
    @php
        $color = "warning";
        $titulo = "Media";
        $texto = $criterio->mediaDescripcion;
        $minimo = $criterio->mediaMin;
        $maximo = $criterio->mediaMax;
    @endphp
@else
    @php
        $color = "danger";
        $titulo = "Alta";
        $texto = $criterio->altaDescripcion;
        $minimo = $criterio->altaMin;
        $maximo = $criterio->altaMax;
    @endphp
@endif

<div class="col-sm-9">
    <div class="alert alert-{{$color}} alert-block">
        <a class="close" data-dismiss="alert" href="#"></a>
    <h4 class="alert-heading" style="font-size:1.2em">Probabilidad {{$titulo." (".$minimo."% a ".$maximo."%)"}}</h4>
       Por favor indique el porcentaje exacto
    </div>
</div>
<div class="col-sm-3">
    <div class="form-group">
        <label>Probabilidad:</label>
        <input class="form-control spinner-left" data-escala="{{$escala}}" data-criterio="{{$criterio->idCriterio}}"  id="prob-{{$criterio->idCriterio}}" name="spinner" value="{{$minimo}}" type="text" min="{{$minimo}}" max="{{$maximo}}" style="font-size:1.5em;font-weight:700;color:#333;" readonly onchange="alert(0)">
    </div>
</div>