<br>
@if(count($pasosPadre) > 0)
    <div class="dtt">
        <table class="table table-striped table-bordered table-hover dataTable no-footer">
            <thead>
                <tr>
                    <th width="60%">¿Qué hace?</th>
                    <th width="20%">Tipo de proceso</th>
                    <th width="10%"></th>
                    <th width="10%"></th>
                </tr>
            </thead>
        </table>
       
        <ul class="todo-list2" id="sortablePadre">
            @foreach($pasosPadre as $pasoPadre)
                <li class="list-box2" value="{{ $pasoPadre->idPaso }}" style="cursor:move">
                    <table width="100%" border="1">
                        <tbody>
                            <tr class="fila-pasos">
                                <td onMouseUp="arrastraPadre();" width="60%">{{$pasoPadre->textoPaso}}</td>
                                <td onMouseUp="arrastraPadre();" width="20%">{{$pasoPadre->nombreTipoProceso}}</td>
                                <td onMouseUp="arrastraPadre();">
                                    <button class="btn btn-xs btn-primary btn-rounded" onclick="editarPasoPadre({{$pasoPadre->idPaso}})"><i class="fa fa-edit"></i> Editar</button>
                                </td>

                                @if($pasoPadre->pasoActivo == 1)
                                    <td onMouseUp="arrastraPadre();" width="10%">
                                        <button class="btn btn-xs btn-danger btn-rounded" onclick="estadoPaso({{$pasoPadre->idPaso}}, 0, 1)"><i class="fa fa-trash"></i> Desactivar</button>
                                    </td>
                                @else
                                    <td onMouseUp="arrastraPadre();" width="10%">
                                        <button class="btn btn-xs btn-danger btn-rounded" onclick="estadoPaso({{$pasoPadre->idPaso}}, 1, 1)"><i class="fa fa-trash"></i> Activar</button>
                                    </td>
                                @endif
                            </tr>
                        </tbody>
                    </table>
                </li>
            @endforeach
        </ul>
    </div>
@else
    <p class="alert alert-info">
        <i class="fa fa-warning fa-fw fa-2x"></i><strong>Atención!</strong> 
        No se encontrarón pasos padres registrados
    </p>
@endif