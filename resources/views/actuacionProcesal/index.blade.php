@extends('layouts.master')
@section('cabecera')
  <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('css/actuacion.css') }}">
  <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('css/acordeon.css') }}">
@endsection
@section('contenido')
  @php
    if($proceso[0]->idTipoProcesos == 1)
    {
        $ruta = 'actuacionProc-judi/index/';
    }
    else if($proceso[0]->idTipoProcesos == 2)
    {
        $ruta = 'actuacionConci-prej/index/';
    }
    else if($proceso[0]->idTipoProcesos == 3)
    {
        $ruta = 'actuacionTutelas/index/';
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
      <li>Inicio</li><li>Procesos</li><li>Actuación procesal</li>
    </ol>
    <!-- end breadcrumb -->
  </div>
  <!-- END RIBBON -->

  <!-- MAIN CONTENT -->
  <input type="hidden" id="idTipoProceso" value="{{$proceso[0]->idTipoProcesos}}">
  <input type="hidden" id="vigenciaRadicado" value="{{$proceso[0]->juriradicados_vigenciaRadicado}}">
  <input type="hidden" id="idRadicado" value="{{$proceso[0]->juriradicados_idRadicado}}">
  <input type="hidden"   id="idEstadoEtapa" value="{{$proceso[0]->idEstadoEtapa}}">
  <input type="hidden" id="idActuacion" value="0">
   <input type="hidden" id="tipoFinaliza" value="0">
  <input type="hidden" id="idResponsable" value="0">

  <div id="content">   
    <div class="bootstrap snippet">
      <div class="row">
        <!-- BEGIN USER PROFILE -->
        <div class="col-md-12">
          <div class="grid profile">
            <div class="grid-header  grid-header-gray">
              <div class="col-xs-2">
                @php
                $foto = '../public/juriArch/entidad/usuarios/'.$proceso[0]->documentoUsuario.'.jpg';
                if(file_exists($foto))
                {
                  $fotoAbogado = asset('juriArch/entidad/usuarios/'.$proceso[0]->documentoUsuario.'.jpg');
                }
                else
                {
                  $fotoAbogado = asset('img/avatar-profile.png');
                }
                @endphp
                <img src="{{$fotoAbogado}}" class="img-circle" alt="">
              </div>
              <div class="col-xs-6">
                <h3> {{$proceso[0]->vigenciaRadicado."-".$proceso[0]->idRadicado}}</h3>
                <p class="abogado">ACTUACIONES PROCESALES Y EXPEDIENTE DIGITAL</p>
                <p>Proceso asignado el {{ucfirst(utf8_encode(strftime("%A %d de %B de %Y", strtotime($proceso[0]->fechaInicioEstado))))}}</p>
              </div>
              <div class="col-xs-4 text-right" style="display:block">
                <a href="{{asset($ruta.$idEstadoEtapa)}}" class="btn btn-sm btn-success">
                  <i class="glyphicon glyphicon-chevron-left"></i> Volver atrás
                </a>
              </div>
            </div>
            <div class="grid-body cont-ajax" id="resultadoInstanciasProceso">
              <!-- ajax -->
            </div>
          </div>
        </div>
        <!-- END USER PROFILE -->
      </div>
    </div>
  </div>
  <!-- END MAIN CONTENT -->
  <!-- ETAPAS INSTANCIAS-->
  <div class="modal fade"  id="modalAgregarActuacion" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h5 class="modal-title" id="myModalLabel">Agregar Actuación</h5>
        </div>
        <div id="resultadoAgregarActuacion">
          <!-- CONTENIDO AJAX -->
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade"  id="modalEditarActuacion" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h5 class="modal-title" id="myModalLabel">Editar Actuación</h5>
        </div>
        <div id="resultadoEditarActuacion">
          <!-- CONTENIDO AJAX -->
        </div>
      </div>
    </div>
  </div>
  <!--# ETAPAS INSTANCIAS-->
@endsection
@section('scriptsFin')
  <script src="{{asset('js/js_actuacionProcesal/actuacionProcesal.js?v=21')}}"></script>

  <script type="text/javascript">
  $(window).on('load', function() {
    instanciasProceso();
  });
  </script>
</script>
@stop
