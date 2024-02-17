@extends('layouts.master')
@section('cabecera')
  <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('css/actuacion.css') }}">
  <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('css/misProcesos.css') }}">
@endsection
@section('contenido')
@php
  use SQ10\helpers\Util as Util;
@endphp
  <!-- RIBBON -->
  <input type="hidden" id="tablaConsolidado" value="{{$tablaConsolidado}}">
  <input type="hidden" id="tipoProceso" value="{{$tipoProceso}}">
  <input type="hidden" id="idResponsable" value="{{$idResponsable}}">
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
      <li>Inicio</li><li>Defensa Judicial</li><li>Mis Procesos</li>
    </ol>
    <!-- end breadcrumb -->
  </div>
  <!-- END RIBBON -->

  <!-- MAIN CONTENT -->
  <div id="content">
    <div class="bootstrap snippet">
      <div class="row">
        <!-- BEGIN USER PROFILE -->
        <div class="col-md-12">
          <div class="grid profile">
            <div class="grid-header grid-header-green">
              <div class="col-xs-2">
                @php
                $foto = '../public/juriArch/entidad/usuarios/'.Auth::user()->documentoUsuario.'.jpg';
                if(file_exists($foto))
                {
                    $fotoAbogado = asset('juriArch/entidad/usuarios/'.Auth::user()->documentoUsuario.'.jpg');
                }
                else
                {
                    $fotoAbogado = asset('img/avatar-profile.png');
                }
                @endphp
                <img src="{{$fotoAbogado}}" class="img-circle" alt="">
              </div>
              <div class="col-xs-7">
                <h3> MIS PROCESOS</h3>
                @php
                $usuario = Util::datosResponsable2($idResponsable);
                @endphp
                <p class="abogado">{{$usuario->nombresUsuario}}</p>
                <p>Gestión de procesos a cargo </p>
              </div>
            </div>
            <div class="grid-body" id="ajax-consolidado" style="min-height:450px">
              <!-- ajax -->
            </div>
          </div>
        </div>
        <!-- END USER PROFILE -->
      </div>
    </div>
  </div>
    <!-- END MAIN CONTENT -->
  @endsection
  @section('scriptsFin')
    <script src="{{asset('js/js_misProcesos/misProcesos.js?v=2')}}"></script>
    <script type="text/javascript">
    $(window).on('load', function() {
      var tablaConsolidado = $("#tablaConsolidado").val();
      var tipoProceso = $("#tipoProceso").val();
      var idResponsable = $("#idResponsable").val();
      if(tablaConsolidado == 0)
      {
        consolidado(idResponsable);
      }
      else
      {
        tablaProcesosConsolidado(tipoProceso, idResponsable);
      }
    });
    </script>
  </script>
  @stop