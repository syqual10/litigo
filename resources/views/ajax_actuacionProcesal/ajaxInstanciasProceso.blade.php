@if(count($instancias) > 0)
		<!-- widget div-->
		<div role="content" style="margin:20px">
			<!-- widget content -->
			<div class="widget-body">
				<div class="jarviswidget" role="widget">
					<header role="heading">
						<h2 style="font-weight:bold">Instancias del proceso</h2>
						<ul class="nav nav-tabs pull-right in">
							@php
								$i=$j=0;
							@endphp
							@foreach($instancias as $instancia)
								@if ($i==0)
									<li class="active">                
										<a class="inst" data-toggle="tab" href="#hb_{{$instancia->idInstancia}}" aria-expanded="true" onclick="etapasInstancia({{$instancia->idInstancia}});"> <i class="fa fa-lg fa-gavel"></i> <span class="hidden-mobile hidden-tablet"> {{$instancia->nombreInstancia}} </span> </a>                
									</li>
								@else
									<li class="">
										<a class="inst" data-toggle="tab" href="#hb_{{$instancia->idInstancia}}" aria-expanded="false" onclick="etapasInstancia({{$instancia->idInstancia}});"> <i class="fa fa-lg fa-gavel"></i> <span class="hidden-mobile hidden-tablet"> {{$instancia->nombreInstancia}} </span> </a>
									</li>
								@endif
								@php
									$i++;
								@endphp
							@endforeach
						</ul>

						<span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span>
					</header>
	
					<!-- widget div-->
					<div role="content">                
						<div class="widget-body">
							<div class="tab-content" style="border:none">

								@foreach($instancias as $instancia)
									@if ($j==0)
										<div class="tab-pane active" id="hb_{{$instancia->idInstancia}}">
									@else
										<div class="tab-pane" id="hb_{{$instancia->idInstancia}}">
									@endif
										<h3>{{$instancia->nombreInstancia}}</h3>
											<p>
												<div id="resultadoEtapasInstancia_{{$instancia->idInstancia}}">
									  				<!-- CONTENIDO AJAX -->
												</div>
											</p>
										</div>
									@php
										$j++;
									@endphp
								@endforeach
							</div>                
						</div>
					</div>
					<!-- end widget div -->                
				</div>                                                
			</div>
			<!-- end widget content -->
		</div>
		<!-- end widget div -->
@endif
