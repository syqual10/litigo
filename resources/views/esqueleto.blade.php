@extends('layouts.master')
@section('cabecera')

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
        <li>Inicio</li><li>Sección</li><li>Subsección</li>
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
						<h2>Título <strong><i>del contenedor</i></strong></h2>
					</header>

					<!-- widget div-->
					<div role="content">
						<!-- widget content -->
						<div class="widget-body">
							Contenido aquí
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

@endsection