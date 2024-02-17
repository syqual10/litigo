@php
    use SQ10\helpers\Util as Util;
@endphp

                @foreach($juzgados as $juzgado)
                    <tr style="background: {{$juzgado->activoJuzgado == 1 ? 'rgba(33,194,248,.3)' : 'rgb(248,33,33,.3)' }}">
                        <td style="width:7%">{{$juzgado->jurisdiccionJuzgado}}</td>
                        <td style="width:7%">{{$juzgado->distritoJuzgado}}</td>
                        <td style="width:7%">{{$juzgado->circuitoJuzgado}}</td>
                        <td style="width:7%">{{$juzgado->departamentoJuzgado}}</td>
                        <td style="width:7%">{{$juzgado->municipioJuzgado}}</td>
                        <td style="width:7%">{{$juzgado->codigoUnicoJuzgado}}</td>
                        <td style="width:40%">{{$juzgado->nombreJuzgado}}</td>
                        <td style="width:8%">
                            @if ($juzgado->activoJuzgado == 1)
                                Activo
                            @else
                                Inactivo
                            @endif
                        </td>
                        <td style="width:5%">
                            <button class="btn btn-xs btn-primary btn-rounded" onclick="editarJuzgado({{$juzgado->idJuzgado}})"><i class="fa fa-edit"></i> Editar</button>
                        </td>
                        <td style="width:5%">
                            @if($juzgado->activoJuzgado == 0)
                                
                                    <button class="btn btn-xs btn-danger btn-rounded" onclick="desactivarJuzgado({{$juzgado->idJuzgado}}, 1)"><i class="fa fa-trash"></i> Activar</button>
                            @else
                                    <button class="btn btn-xs btn-danger btn-rounded" onclick="desactivarJuzgado({{$juzgado->idJuzgado}}, 0)"><i class="fa fa-trash"></i> Desactivar</button>
                                
                            @endif
                        </td>
                    </tr>
                @endforeach
        