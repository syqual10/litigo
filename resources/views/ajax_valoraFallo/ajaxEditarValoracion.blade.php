@if(count($criterios) > 0)
    <style>
    .link-prob {
        color:#656667 !important;
        cursor:pointer !important;
    }
    .i-prob:hover {
        background: #f0f0f0 !important;
    }
    </style>
    <div class="row">
        @php
            $cols = 0;
        @endphp
        @foreach ($criterios as $criterio)
            
            <div class="col-sm-4">
                <div class="panel panel-default">
                    <div class="panel-body status smart-form vote">
                        <div class="who clearfix">
                            <img src="{{asset('/img/litigo-2.png')}}" width="70">
                            <span class="name"><b>{{$criterio->nombreCriterio}}</b> </span>
                            <span class="from"><b>Seleccione</b> una probabilidad</span>
                        </div>
                        <div class="image" style="height:76px !important">
                            <strong>{{$criterio->descripcionCriterio}} </strong>
                        </div>
                        <ul class="comments" style="height:295px !important">
                            <a href="javascript:void(0)" onclick="seleccionaRango({{$criterio->idCriterio}}, 1)" class="link-prob">
                                <li class="i-prob">
                                    <strong style="color:#8ac38b">PROBABILIDAD BAJA - entre {{$criterio->bajaMin."% y ".$criterio->bajaMax."%"}} </strong>
                                    <label style="cursor:pointer">{{$criterio->bajaDescripcion}} </label>
                                </li>
                            </a>
                            
                            <a href="javascript:void(0)" onclick="seleccionaRango({{$criterio->idCriterio}}, 2)" class="link-prob">
                                <li class="i-prob">
                                    <strong style="color:#dfb56c">PROBABILIDAD MEDIA - entre {{$criterio->mediaMin."% y ".$criterio->mediaMax."%"}} </strong>
                                    <label style="cursor:pointer">{{$criterio->mediaDescripcion}} </label>
                                </li>
                            </a>

                            <a href="javascript:void(0)" onclick="seleccionaRango({{$criterio->idCriterio}}, 3)" class="link-prob">
                                <li class="i-prob">
                                    <strong style="color:#953b39">PROBABILIDAD ALTA - entre {{$criterio->altaMin."% y ".$criterio->altaMax."%"}} </strong>
                                    <label style="cursor:pointer">{{$criterio->altaDescripcion}} </label>
                                </li>
                            </a>
                        </ul>
                
                        <ul class="links" style="height:113px !important">
                            <!-- ajax -->
                            <div class="row" id="ajax-rango-{{$criterio->idCriterio}}">
                                @php
                                    $calificacion = DB::table('juricalificacionesmzl')
                                                   ->leftJoin('jurivaloracionesfallomzl', 'juricalificacionesmzl.jurivaloracionesfallomzl_idValoracionFallo', '=', 'jurivaloracionesfallomzl.idValoracionFallo')
                                                   ->leftJoin('juricriteriosmzl', 'juricalificacionesmzl.juricriteriosmzl_idCriterio', '=', 'juricriteriosmzl.idCriterio')
                                                      ->where('juricalificacionesmzl.jurivaloracionesfallomzl_idValoracionFallo', '=',  $idValoracion)
                                                      ->where('juricalificacionesmzl.juricriteriosmzl_idCriterio', '=',  $criterio->idCriterio)
                                                      ->first();

                                    if ($calificacion->escala == 1)
                                    {
                                        $color = "success";
                                        $titulo = "Baja";
                                        $texto = $calificacion->bajaDescripcion;
                                        $minimo = $calificacion->bajaMin;
                                        $maximo = $calificacion->bajaMax;
                                    }
                                    elseif($calificacion->escala == 2)
                                    {
                                        $color = "warning";
                                        $titulo = "Media";
                                        $texto = $calificacion->mediaDescripcion;
                                        $minimo = $calificacion->mediaMin;
                                        $maximo = $calificacion->mediaMax;
                                    }
                                    else
                                    {
                                        $color = "danger";
                                        $titulo = "Alta";
                                        $texto = $calificacion->altaDescripcion;
                                        $minimo = $calificacion->altaMin;
                                        $maximo = $calificacion->altaMax;
                                    }
                                @endphp                                

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
                                        <input class="form-control spinner-left" data-escala="{{$calificacion->escala}}" data-criterio="{{$calificacion->idCriterio}}"  id="prob-{{$calificacion->idCriterio}}" name="spinner" value="{{$calificacion->valorCriterio}}" type="text" min="{{$minimo}}" max="{{$maximo}}" style="font-size:1.5em;font-weight:700;color:#333;" readonly onchange="alert(0)">
                                    </div>
                                </div>
                            </div>
                            <!-- # ajax -->
                        </ul>
                    </div>
                </div>
            </div>

        @endforeach
    </div>
    <div class="row">
        <div class="col-sm-12">
            <button class="btn btn-primary pull-right" onclick="modificarValoracion({{count($criterios)}}, {{$idValoracion}})"> <i class="fa fa-save"></i> Modificar esta Valoración</button>
        </div>
    </div>
@else
    <p class="alert alert-info">
        <i class="fa fa-warning fa-fw fa-2x"></i><strong>Atención!</strong> 
        No se encontrarón valoraciones para este proceso
    </p>
@endif