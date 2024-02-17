@extends('layouts.master')

@section('contenido')
@php
$foto = '../public/juriArch/entidad/usuarios/'.Auth::user()->documentoUsuario.'.jpg';

if(file_exists($foto)) 
{
    $foto = asset('juriArch/entidad/usuarios/'.Auth::user()->documentoUsuario.'.jpg');
}
else
{
    $foto = asset('img/avatar-profile.png');
}

$cargos = DB::table('cargos')
                    ->where('idCargo', '=', Auth::user()->cargos_idCargo)
                    ->get();

if(count($cargos) > 0)
{
    $cargo = $cargos[0]->nombreCargo;
}
else
{
    $cargo = "";
}
@endphp

<!-- RIBBON -->
<div id="ribbon">
    <span class="ribbon-button-alignment"> 
        <a href="{{ asset('home') }}">
            <span id="refresh" class="btn btn-ribbon" rel="tooltip" data-placement="bottom" data-original-title="Ir al inicio" data-html="true">
                <i class="fa fa-home"></i>
            </span> 
        </a>
    </span>
    <!-- breadcrumb -->
    <ol class="breadcrumb">
    <li>Inicio</li><li>Usuario</li><li>Perfil</li>
    </ol>
    <!-- end breadcrumb -->
</div>
<!-- END RIBBON -->

<div id="content">
    <!-- row -->            
    <div class="row">    
        <div class="col-sm-12">
            <div class="well well-sm">
                <div class="row">
                    <div class="col-sm-12 col-md-5 col-lg-5">
                        <div class="well well-light well-sm no-margin no-padding">    
                            <div class="row">    
                                <div class="col-sm-12">
                                    <div id="myCarousel" class="carousel fade profile-carousel">
                                        <div class="air air-top-left padding-10">
                                            <h4 class="txt-color-white font-md">{{ucfirst(utf8_encode(strftime("%A %d de %B de %Y", strtotime(date('Y-m-d')))))}}</h4>
                                        </div>
                                        <ol class="carousel-indicators">
                                            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                                            <li data-target="#myCarousel" data-slide-to="1" class=""></li>
                                            <li data-target="#myCarousel" data-slide-to="2" class=""></li>
                                        </ol>
                                        <div class="carousel-inner">
                                            <!-- Slide 1 -->
                                            <div class="item active">
                                                <img src="img/demo/s1.jpg" alt="demo user">
                                            </div>
                                            <!-- Slide 2 -->
                                            <div class="item">
                                                <img src="img/demo/s2.jpg" alt="demo user">
                                            </div>
                                            <!-- Slide 3 -->
                                            <div class="item">
                                                <img src="img/demo/m3.jpg" alt="demo user">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12">

                                    <div class="row">
                                        <div class="col-sm-4 profile-pic">
                                            <img src="{{$foto}}" alt="demo user">
                                            <div class="padding-10">
                                                <h4 class="font-md"><strong>{{count($procesosPendientes)}}</strong>
                                                <br>
                                                <small>Procesos pendientes</small></h4>
                                                <!--<br>
                                                <h4 class="font-md"><strong>{{$actuacionesProcesales}}</strong>
                                                <br>
                                                <small>Actuaciones procesales</small></h4>
                                                <br>
                                                <h4 class="font-md"><strong>$ {{number_format((float)$sumaCuantia, 0, ',', '.')}}</strong>
                                                <br>
                                                <small>Cuantía procesos pendientes</small></h4>-->
                                            </div>
                                        </div>
                                        <div class="col-sm-8">
                                            <h1>{{ Auth::user()->nombresUsuario }}</span>
                                            <br>
                                            <small>{{$cargo}}</small></h1>

                                            <ul class="list-unstyled">
                                                <li>
                                                    <p class="text-muted">
                                                        <i class="fa fa-phone"></i>&nbsp;&nbsp;<span class="txt-color-darken">{{Auth::user()->celularUsuario}}</span>
                                                    </p>
                                                </li>
                                                <li>
                                                    <p class="text-muted">
                                                        <i class="fa fa-envelope"></i>&nbsp;&nbsp;<a href="#">{{Auth::user()->emailUsuario}}</a>
                                                    </p>
                                                </li>
                                            </ul>
                                            <br>
                                            <a href="javascript:void(0);" class="btn btn-default btn-xs" onclick="editarFoto();">
                                                <i class="fa fa-picture-o"></i> Cambiar Foto
                                            </a>
                                            <br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">    
                                <div class="col-sm-12">    
                                    <hr>    
                                    <div class="padding-10">    
                                        <div id="resultadoPosteo">
                                            <!-- AJAX POSTEO-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end row -->
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-7 col-lg-7">
                        <ul class="nav nav-tabs tabs-pull-right">
                            <li style="display:none">
                                <a href="#a1" data-toggle="tab">Programación comité de conciliación</a>
                            </li>
                            <li class="active">
                                <a href="#a2" data-toggle="tab">Tareas Pendientes</a>
                            </li>
                            <li class="pull-left">
                                <span class="margin-top-10 display-inline"><i class="fa fa-user text-info"></i> Personal</span>
                            </li>
                        </ul>
                        <div class="tab-content padding-top-10">
                            <div class="tab-pane fade" id="a1">    
                                <div class="row">    
                                </div>
                            </div>
                            <div class="tab-pane fade in active" id="a2">
                                <div class="row" id="resultadoTareasPendientes">    
                                </div>
                            </div><!-- end tab -->
                        </div>
                    </div>
                </div>
            </div>
        </div>                
    </div>                
    <!-- end row -->

    <!-- EDITAR FOTO-->
    <div class="modal fade"  id="modalEditarFoto" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myLargeModalLabel"><i class="fa fa-money"></i> Editar Foto</h4>
                </div>
                <div class="modal-body" style="padding: 10px 30px 4px 30px;">  
                    <div id="resultadoEditarFoto">
                      <!-- CONTENIDO AJAX -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--# EDITAR FOTO-->
</div>
<!-- END MAIN CONTENT -->

@endsection
@section('scriptsFin')
    <script src="{{asset('js/js_home/home.js')}}"></script>
    <script type="text/javascript">
        $(window).on('load', function() { 
          posteos();
          tareasPendientes();
        });
    </script>
@stop