@extends('layouts.master')
@section('contenido')
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
        <li>Inicio</li><li>Buzón de procesos</li>
    </ol>
    <!-- end breadcrumb -->
</div>
<!-- END RIBBON -->

<!-- MAIN CONTENT -->
<div id="content">   
     <!-- botones posteriores -->
    <div class="inbox-nav-bar no-content-padding">

        <h1 class="page-title txt-color-blueDark hidden-tablet"><i class="fa fa-fw fa-inbox"></i> Buzón &nbsp;</h1>
    
        <div class="btn-group hidden-desktop visible-tablet">
            <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                Inbox <i class="fa fa-caret-down"></i>
            </button>
            <ul class="dropdown-menu pull-left">
                <li>
                    <a href="javascript:void(0);" class="inbox-load">Inbox <i class="fa fa-check"></i></a>
                </li>
                <li>
                    <a href="javascript:void(0);">Sent</a>
                </li>
                <li>
                    <a href="javascript:void(0);">Trash</a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="javascript:void(0);">Spam</a>
                </li>
            </ul>
    
        </div>
    
        <div class="inbox-checkbox-triggered">
    
            <div class="btn-group">
                <a href="javascript:void(0);" onclick="buzonProcesos();" rel="tooltip" title="" data-placement="bottom" data-original-title="Procesos Pendientes" class="btn btn-default"><strong><i class="fa fa-exclamation fa-lg text-danger"></i></strong></a>
                <a href="javascript:void(0);" onclick="misReportes(1);" rel="tooltip" title="" data-placement="bottom" data-original-title="Procesos Terminados" class="btn btn-default"><strong><i class="fa fa-check-circle-o fa-lg"></i></strong></a>
                <a href="javascript:void(0);" onclick="misReportes(2);" rel="tooltip" title="" data-placement="bottom" data-original-title="Procesos Enviados" class="btn btn-default"><strong><i class="fa fa-paper-plane fa-lg"></i></strong></a>
                <a href="javascript:void(0);" onclick="misReportes(3);" rel="tooltip" title="" data-placement="bottom" data-original-title="Procesos Cancelados" class="btn btn-default"><strong><i class="fa fa-times-circle fa-lg"></i></strong></a>
            </div>
    
        </div>
    
        <a href="javascript:void(0);" id="compose-mail-mini" class="btn btn-primary pull-right hidden-desktop visible-tablet"> <strong><i class="fa fa-file fa-lg"></i></strong> </a>
    
        <div class="btn-group pull-right inbox-paging">
            <a href="#" onclick="buzonProcesos(0);" class="btn btn-default btn-sm"><strong><i class="fa fa-chevron-left"></i></strong></a>
            <a href="#" onclick="buzonProcesos(1);" class="btn btn-default btn-sm"><strong><i class="fa fa-chevron-right"></i></strong></a>
        </div>
        <span class="pull-right"><strong id="cantidadRadicados"></strong> de  <strong id="totalRadicados">{{$cantidadBuzon}}</strong></span>    
    </div>
    <!-- #botones posteriores-->

    <div id="inbox-content" class="inbox-body no-content-padding">                
        <div class="inbox-side-bar">                
            <ul class="inbox-menu-lg">
                <li class="active">
                    <a class="inbox-load" href="javascript:void(0);" onclick="buzonProcesos();"> No leídos <span id="textoPendientes"> ({{$cantidadBuzon}}) </span></a>
                </li>
                <li>
                    <a href="#" onclick="misReportes(1);">Mis Terminados</a>
                </li>
                <li>
                    <a href="#" onclick="misReportes(2);">Mis Enviados</a>
                </li>
                <li>
                    <a href="#" onclick="misReportes(3);">Mis Cancelados</a>
                </li>
                <li>
                    <a href="#" onclick="ultimosLeidos();">Últimos leídos({{$cantidadUltimosLeidos}})</a>
                </li>
                <li>
                    <a class="inbox-load" href="javascript:void(0);" onclick="buzonActuaciones();"> Buzón actuaciones <span id="textoPendientesActuaciones"> ({{$cantActuNoLeidos}}) </span></a>
                </li>
            </ul>             
        </div>    
        <div class="table-wrap custom-scroll animated fast fadeInRight" style="min-height:450px" id="resultadoBuzonProcesos">
            <!-- ajax will fill this area -->            
        </div>                 
    </div>
</div>
<!-- END MAIN CONTENT -->

<!-- MODAL DE REPORTE BUZÓN-->
<div class="modal fade"  id="modalMisReportes" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title" id="labelMisReportes"></h5>
            </div>
            <div id="resultadoMisReportes">
              <!-- CONTENIDO AJAX -->
            </div>
        </div>
    </div>
</div>
<!-- # MODAL DE REPORTE BUZÓN-->

@endsection
@section('scriptsFin')
<script src="{{asset('js/js_buzon/buzon.js?v='.rand(0,1000))}}"></script>
<script type="text/javascript">
    $(window).on('load', function() { 
      buzonProcesos();
    });
</script>
@stop