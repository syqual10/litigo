<br>
@if(count($pasosPadre) > 0)
    @foreach($pasosPadre as $pasoPadre)
        @php
            $pasosHijos = DB::table('juripasos')
                ->where('juripasos_idPaso', '=', $pasoPadre->idPaso)
                ->orderBy('ordenPaso', 'asc')
                ->get();
        @endphp

        <h6>{{$pasoPadre->textoPaso}}</h6>
        @if(count($pasosHijos) > 0)
            <div class="dtt">
                <table class="display projects-table table table-striped table-bordered table-hover dataTable no-footer">
                    <thead>
                        <tr>
                            <th width="80%">¿Qué hace?</th>
                            <th width="10%"></th>
                            <th width="10%"></th>
                        </tr>
                    </thead>
                </table>

                <ul class="todo-list2" id="sortableHijo_{{$pasoPadre->idPaso}}">
                    @foreach($pasosHijos as $pasoHijo)
                        <li class="list-box2" value="{{ $pasoHijo->idPaso }}" style="cursor:move">
                            <table width="100%">
                                <tbody>
                                    <tr class="fila-pasos">
                                        <td onMouseUp="arrastraHijo({{$pasoPadre->idPaso}});" width="80%">{{$pasoHijo->textoPaso}}</td>
                                        <td onMouseUp="arrastraHijo({{$pasoPadre->idPaso}});" width="10%">
                                            <button class="btn btn-xs btn-primary btn-rounded" onclick="editarPasoHijo({{$pasoHijo->idPaso}})"><i class="fa fa-edit"></i> Editar</button>
                                        </td>

                                        @if($pasoPadre->pasoActivo == 1)
                                            <td onMouseUp="arrastraHijo({{$pasoPadre->idPaso}});" width="10%">
                                                <button class="btn btn-xs btn-danger btn-rounded" onclick="estadoPaso({{$pasoHijo->idPaso}}, 0, 0)"><i class="fa fa-trash"></i> Desactivar</button>
                                            </td>
                                        @else
                                            <td onMouseUp="arrastraHijo({{$pasoPadre->idPaso}});" width="10%">
                                                <button class="btn btn-xs btn-danger btn-rounded" onclick="estadoPaso({{$pasoHijo->idPaso}}, 1, 0)"><i class="fa fa-trash"></i> Activar</button>
                                            </td>
                                        @endif
                                    </tr>
                                </tbody>
                            </table>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    @endforeach
@else
    <p class="alert alert-info">
        <i class="fa fa-warning fa-fw fa-2x"></i><strong>Atención!</strong> 
        No se encontrarón pasos padres registrados
    </p>
@endif