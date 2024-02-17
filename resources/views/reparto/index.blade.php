@extends('layouts.master')
@section('cabecera')
<style type="text/css">
#iframeDiagrama 
{
  min-height:680px;
  margin-bottom: 5px;
  -webkit-box-shadow: 0px 0px 5px -2px rgba(0,0,0,0.75);
  -moz-box-shadow: 0px 0px 5px -2px rgba(0,0,0,0.75);
  box-shadow: 0px 0px 5px -2px rgba(0,0,0,0.75);
  border-radius:4px;
  border:1px solid #c4c4c4;
}
</style>
@endsection

@section('contenido')
@php
    use SQ10\helpers\Util as Util;
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
        <li>Inicio</li><li>Procesos</li><li>Reparto</li>
    </ol>
    <!-- end breadcrumb -->
</div>
<!-- END RIBBON -->

<!-- MAIN CONTENT -->
<div id="content">              
    <!-- widget grid -->
    <section id="widget-grid" class="">
        <input type="hidden" id="idEstadoEtapa" value="{{$proceso[0]->idEstadoEtapa}}">
        <input type="hidden" id="vigenciaRadicado" value="{{$proceso[0]->vigenciaRadicado}}">
        <input type="hidden" id="idRadicado" value="{{$proceso[0]->idRadicado}}">
        <input type="hidden" id="apoderadoProceso">
        <!-- row -->
        <div class="row">
            <!-- NEW WIDGET START -->
            <article class="col-sm-12">
                <div class="jarviswidget jarviswidget-color-blue" role="widget">
                    <header role="heading">
                        <h2>Reparto <strong><i>de procesos</i></strong></h2>
                    </header>
                    <!-- widget div-->
                    <div role="content">
                        <!-- widget content -->
                        <div class="widget-body">
                            <!-- row -->
                            <div class="row">
                                <div class="col-sm-4 col-xs-12">
                                    <div class="product-content product-wrap clearfix product-deatil">
                                        @if($proceso[0]->nombreJuzgado !='')
                                            <div class="row">           
                                                <div class="col-sm-12 col-xs-12">
                                                    <h2 class="name">{{$proceso[0]->nombreJuzgado}}</h2>
                                                    <hr>
                                                    <h3 class="price-container">
                                                        <small>Radicado Juzgado</small>
                                                        <span style="font-weight:bold;font-size:0.7em;color:#21c2f8">{{substr($proceso[0]->codigoProceso, 0, 16)}}</span>               
                                                        <span style="font-weight:bold;font-size:1.5em;color:#21c2f8">{{substr($proceso[0]->codigoProceso, 16, 5)}}</span>               
                                                    </h3>
                                                    <div class="certified">
                                                        <ul>
                                                            <li><a href="javascript:void(0);">Vigencia<span>{{substr($proceso[0]->codigoProceso, 12, 4)}}</span></a></li>
                                                            <li><a href="javascript:void(0);">Ciudad<span>{{$ciudad[0]->nombreCiudad}} | {{$ciudad[0]->nombreDepartamento}}</span></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="row">           
                                            <div class="col-sm-12 col-xs-12">
                                                <hr>
                                                <h3 class="price-container">
                                                    <small>Radicado litíGo</small>
                                                    <span style="font-weight:bold;font-size:1.5em;color:#21c2f8">{{$proceso[0]->idRadicado."-".$proceso[0]->vigenciaRadicado}}</span>               
                                                </h3>
                                            
                                                <div class="certified">
                                                    <ul>
                                                        <li><a href="javascript:void(0);">Vigencia<span>{{$proceso[0]->vigenciaRadicado}}</span></a></li>
                                                        <li><a href="javascript:void(0);">Medio de control<span>{{$proceso[0]->nombreMedioControl}}</span></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">           
                                            <div class="col-sm-12 col-xs-12">
                                                <hr>
                                                <h3 class="price-container">
                                                    <small>Abogados Para Reparto</small>
                                                </h3>
                                            
                                                <div class="certified">
                                                    <div id="resultadoAbogadosAsigandos">
                                                        <!--AJAX QUE CARGAN LOS ABOGADOS QUE SE VAN SELECCIONADO-->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- SuperBox -->
                                <div class="superbox col-sm-8">
                                    <h3 class="tit-step"><strong>Abogados Activos</strong> - Seleccione el abogado que se encargará del caso</h3><br>
                                    <hr><br>
                                    @if(count($abogados) > 0)
                                        @foreach($abogados as $abogado)
                                            @php
                                                $foto = '../public/juriArch/entidad/usuarios/'.$abogado->documentoUsuario.'.jpg';

                                                if(file_exists($foto)) 
                                                {
                                                    $foto = asset('juriArch/entidad/usuarios/'.$abogado->documentoUsuario.'.jpg');
                                                }
                                                else
                                                {
                                                    $foto = asset('img/avatar-profile.png');
                                                }
                                            @endphp
                                            <div class="superbox-list">
                                                <a href="#">
                                                    <span style="width:94%;padding:5px;background:#0000009c;position:absolute;bottom:0px;font-size:0.8em;color:#fff;min-height:40px">{{$abogado->nombresUsuario}}</span>
                                                    <img src="{{$foto}}" data-img="{{$foto}}" data-projud="{{Util::cantidadTipoProcesoReparto(2, $abogado->idResponsable)}}" data-conpre="{{Util::cantidadTipoProcesoReparto(1, $abogado->idResponsable)}}" data-idEstadoEtapa="{{$proceso[0]->idEstadoEtapa}}" data-idResponsable="{{$abogado->idResponsable}}" data-nombresUsuario="{{$abogado->nombresUsuario}}" data-idUsuario="{{$abogado->idUsuario}}" data-juriradicadosvigenciaRadicado="{{$proceso[0]->juriradicados_vigenciaRadicado}}" data-juriradicadosidRadicado="{{$proceso[0]->juriradicados_idRadicado}}" title="{{$abogado->nombresUsuario}}" class="superbox-img">
                                                </a>
                                            </div>
                                        @endforeach
                                    @else
                                        <p class="alert alert-info">
                                            <i class="fa fa-warning fa-fw fa-2x"></i><strong>Atención!</strong> 
                                            No se encontrarón abogados asignados
                                        </p>
                                    @endif
                                    <div class="superbox-float"></div>
                                </div>
                                <!-- /SuperBox -->    
                                <div class="superbox-show" style="height:300px; display: none"></div>
                            </div>
                        </div>
                        <!-- end widget content -->
                    </div>
                    <!-- end widget div -->
                </div>
                <!-- end widget -->
            </article>
            <!-- WIDGET END -->
        </div>
        <!-- end row -->
    </section>
    <!-- end widget grid -->
</div>
<!-- END MAIN CONTENT -->
@endsection
@section('scriptsFin')
    <script src="{{asset('js/plugin/superbox/superbox.min.js')}}"></script>
    <script src="{{asset('js/js_reparto/reparto.js?v=5')}}"></script>
    <script>
    $(document).ready(function() {                      
        $('.superbox').SuperBox();        
    });
    </script>
@stop