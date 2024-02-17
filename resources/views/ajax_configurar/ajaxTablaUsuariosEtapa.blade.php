<div class="panel-wrapper collapse in">
    <div class="panel-body">
        <div class="table-wrap">
            <div class="table-responsive">
                @if(count($responsablesEtapa) > 0)
                    <table class="table table-hover table-bordered display  pb-30" >
                        <thead>
                            <tr>
                                <th>Usuario</th>
                                <th>Perfil</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($responsablesEtapa as $responsable)
                                <tr>
                                    <td>{{$responsable->nombresUsuario}}</td>
                                    <td>{{$responsable->nombrePerfil}}</td>
                                    <td>
                                        <button class="btn btn-danger btn-rounded" onclick="eliminarResponsableEtapa({{$responsable->idResponsableEtapa}}, {{$responsable->jurietapas_idEtapa}})">Remover</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <fieldset>   
                        <div style="text-align:center;" >
                            <i class="fa fa-fw fa-minus-circle icono-else"></i>
                            <p align="center" class="titulo-else">No se encontrarón responsables designados</p>
                        </div>
                    </fieldset>
                @endif
            </div>
        </div>
    </div>
</div>