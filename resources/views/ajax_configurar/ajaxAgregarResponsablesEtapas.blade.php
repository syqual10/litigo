<link href="{{ asset('css/style.css')}}" rel="stylesheet" type="text/css">
<div class="row" style="margin-bottom: 15px;" >
    <div class="form-wrap">
        <div class="form-group">
            <div class="col-sm-3">
                <label class="control-label pull-right">Etapa:</label>
            </div>
            <div class="col-sm-6">
                <h6 class="panel-title txt-dark">{{$etapa->nombreEtapa}}</h6>
            </div>
        </div>
    </div>
</div>

<div class="row" style="margin-bottom: 15px;" >
    <div class="form-wrap">
        <div class="form-group">
            <div class="col-sm-3">
                <label class="control-label pull-right">Perfil:</label>
            </div>
            <div class="col-sm-6">
                {{ 
                    Form::select('selectPerfil', $listaPerfiles, null, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectPerfil', 'style' => 'margin-bottom:8px;'])
                }}
            </div>
        </div>
    </div>
</div>

<div class="row" style="margin-bottom: 15px;" >
    <div class="form-wrap">
        <div class="form-group">
            <div class="col-sm-3">
                <label class="control-label pull-right">Responsables:</label>
            </div>
            <div class="col-sm-9">
                {{ 
                    Form::select('selectResponsables', $listaUsuarios, null, ['class' => 'form-control', 'class' => 'select2', 'multiple', 'id'=>'selectResponsables', 'style' => 'margin-bottom:8px;'])
                }}
            </div>
        </div>
    </div>
</div>

<div class="panel-heading">
    <div class="pull-left">
        <h6 class="panel-title txt-dark">Responsables {{$etapa->nombreEtapa}}</h6>
    </div>
    <div class="clearfix"></div>
</div>
<div id="resultadoUsuariosEtapa">
    <!--AJAX CARGAR TABLA RESPONSABLES -->
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    <button class="btn btn-success btn-guardar-responsablesEtapa"><i class="icon-rocket"></i> <a id="eventUrl" style="color:#fff; text-decoration:none;" onclick="validarGuardarResponsables({{$etapa->idEtapa}});">Guardar</a></button>
</div>