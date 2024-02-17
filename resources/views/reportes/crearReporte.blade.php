@extends('layouts.master')
@section('cabecera')
<link rel="stylesheet" href="{{asset('css/pickmeup.css')}}" type="text/css">
<link rel="stylesheet" href="{{asset('css/sortable-theme.css?v=2')}}" type="text/css" />
<style>
	.col-form-label {
		font-weight: 600;
	}
</style>
@endsection
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
        <li>crear reportes</li>
    </ol>
    <!-- end breadcrumb -->
</div>
<!-- END RIBBON -->

<!-- MAIN CONTENT -->
<div id="content">				
	<!-- widget grid -->
	<section id="widget-grid" class="">
		<!-- row -->
		<div class="row">
			<!-- NEW WIDGET START -->
			<article class="col-sm-12">
				<div class="jarviswidget jarviswidget-color-blue" role="widget">
					<header role="heading">
						<h2>Crear <strong><i>Reporte</i></strong></h2>
					</header>

					<!-- widget div-->
					<div role="content">
                        <!-- widget content -->
						<div class="widget-body">
                            
                            <div id="formularioCrearReporte"></div>
                            
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
<script src="{{asset('js/jquery.pickmeup.js')}}"></script>
<script src="{{asset('js/Sortable.js?v=1')}}"></script>
<script src="{{asset('js/js_reportes/reportes.js?v='.rand(1,1000))}}"></script>
<script>
    $(window).on('load', function() {
        formularioCrearReportes();
    });
</script>
@endsection