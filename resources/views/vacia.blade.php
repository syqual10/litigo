@extends('layouts.master')

@section('contenido')
<!-- Title -->
<div class="row heading-bg">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
      <h5 class="txt-dark">Título Princial Aquí</h5>
    </div>
    <!-- Breadcrumb -->
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
      <ol class="breadcrumb">
        <li><a href="{{ asset('home') }}">Inicio</a></li>
        <li class="active"><span>Nombre de la sección aquí</span></li>
      </ol>
    </div>
    <!-- /Breadcrumb -->
</div>
<!-- /Title -->

<!-- Row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default card-view pa-0">
            <div class="panel-wrapper collapse in">
                <div class="panel-body pa-0">
                    <div class="mail-box">
                        <div class="row">                                           
                            <div class="col-lg-12 col-md-8 pl-0">
                                <div class="panel panel-default border-panel card-view">
                                    <div class="panel-heading">
                                        <div class="pull-left">
                                            <h6 class="panel-title txt-dark">Título de la Sección Aquí</h6>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="panel-wrapper collapse in">
                                        <div class="panel-body">                                            
                                            <p>JEISON: Con el inspector puede sacar el código html que necesite.  La plantilla es esta: https://hencework.com/theme/goofy/full-width-light/index5.html</p>
                                            <br>
                                            JEISON: Estos son los íconos que puede utilizar: http://zavoloklom.github.io/material-design-iconic-font/icons.html
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Row -->

<!-- MODAL-->
<div class="modal fade"  id="modalAlgo" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
  	<div class="modal-dialog modal-lg">
	    <div class="modal-content">
	      	<div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myLargeModalLabel"><i class="fa fa-money"></i> Título Modal Aquí</h4>
	      	</div>
	      	<div class="modal-body" style="padding: 10px 30px 4px 30px;">  
		        <div id="ajax-algo">
		          <!-- CONTENIDO AJAX -->
		        </div>
	      	</div>
	      	<div class="modal-footer">
	        	<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	        	<button class="btn btn-success"><a id="eventUrl" style="color:#fff; text-decoration:none;" onclick="validarAlgo();">Acción Aquí</a></button>
	      	</div>
	    </div>
  	</div>
</div>
<!--# MODAL-->
@endsection
@section('scriptsFin')
  <script src="{{asset('js/js_algo/adminAlgo.js')}}"></script>
@stop