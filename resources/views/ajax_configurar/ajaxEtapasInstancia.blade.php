<div class="row">
    <div class="col-sm-12">
        <a href="javascript:void(0);" class="btn bg-color-greenLight txt-color-white btn-xs pull-right" onclick="agregarEtapa({{$idInstancia}});">
            <i class="fa fa-sitemap"></i> Agregar una etapa
        </a>
    </div>
</div>
<hr>
<div id="resultadoAgregarEtapa" style="margin-bottom: 15px; margin-top: 15px;">
    <!--AJAX PARA CREAR LA ETAPA DE LA INSTANCIA-->    
</div>
<div class="row">
    <div class="col-sm-12">
        @if(count($etapas) > 0)
            <div class="dtt">
                <table class="display projects-table table table-striped table-bordered table-hover dataTable no-footer">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        @foreach($etapas as $etapa)
                            <tr>
                                <td width="90%">{{$etapa->nombreEtapa}}</td>
                                <td>
                                    <a class="btn btn-xs btn-primary btn-rounded" onclick="editarEtapa({{$etapa->idEtapa}})"><i class="fa fa-edit"></i> Editar</a>
                                </td>
                                <td>
                                    <a class="btn btn-xs btn-danger btn-rounded" onclick="eliminarEtapa({{$etapa->idEtapa}}, {{$idInstancia}})"><i class="fa fa-trash"></i> Eliminar</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <hr>
            <p class="alert alert-info">
                <i class="fa fa-warning fa-fw fa-2x"></i><strong>Atención!</strong> 
                No se encontraron etapas registradas
            </p>
        @endif
    </div>
</div>
