<div class="widget-body">                                 
    <!--CONTENT-->
    <section id="widget-grid" class="">
		<div class="row">
			<article class="col-sm-12 col-md-12 col-lg-6">
				<div class="jarviswidget jarviswidget-color-blue" id="wid-id-4" data-widget-editbutton="false" data-widget-colorbutton="false">
					<div>
						<div class="jarviswidget-editbox">
							<div>
								<label>Title:</label>
								<input type="text" />
							</div>
						</div>
						<div class="widget-body no-padding smart-form">
							<!-- content goes here -->
							<ul id="sortable1" class="todo">
								@if(count($pasos) > 0)
									@foreach($pasos as $pasoPadre)
										@php
											$arrayPasosPendientes = array();
											$pasosHijos = DB::table('juripasos')
		                                        ->where('juripasos_idPaso', '=', $pasoPadre->idPaso)
		                                        ->orderBy('ordenPaso', 'asc')
		                                        ->get();

		                                    if(count($pasosHijos) > 0)
        									{
        										foreach ($pasosHijos as $pasoHijo)
            									{
            										$pasosPendientes = DB::table('juripasosproceso')
					                                    ->where('juripasos_idPaso', '=', $pasoHijo->idPaso)
					                                    ->where('juriradicados_vigenciaRadicado', '=', $vigenciaRadicado)
					                                    ->where('juriradicados_idRadicado', '=', $idRadicado)
					                                    ->get();

					                                if(count($pasosPendientes) == 0)//sino esta en la tabla de pasos del radicado, se agrega a los pendientes
                									{
                										$datos = array('idPaso'           => $pasoHijo->idPaso,
									                                   'textoPaso'        => $pasoHijo->textoPaso,
									                               	   'ordenPaso'        => $pasoHijo->ordenPaso);

									                    array_push($arrayPasosPendientes, $datos);
                									}
            									}
        									}
										@endphp
											<h5 class="todo-group-title"><i class="fa fa-warning"></i> {{$pasoPadre->ordenPaso.". ".$pasoPadre->textoPaso}} (<small class="num-of-tasks">{{count($arrayPasosPendientes)}}</small>)</h5>
											@if(count($arrayPasosPendientes) > 0)
												@foreach($arrayPasosPendientes as $pasoPendiente)
													<li>
														<span class="handle"> 
															@if($responsable == 1)
																<label class="checkbox">
																	<input type="checkbox" name="checkbox-inline" onchange="modalMarcarPaso({{$pasoPendiente['idPaso']}}, 1);">
																	<i></i> 
																</label> 
															@endif
														</span>
														<p style="height: 8px !important">
															<strong>{{$pasoPadre->ordenPaso.".".$pasoPendiente['ordenPaso']." ".$pasoPendiente['textoPaso']}}</strong>.</span>
														</p>											
													</li>
												@endforeach
											@endif
									@endforeach
								@endif
							</ul>

							<h5 class="todo-group-title"><i class="fa fa-check"></i> Pasos completados (<small class="num-of-tasks">{{count($arrayPasosCompletados)}}</small>)</h5>
							<ul id="sortable3" class="todo">
								@if(count($arrayPasosCompletados) > 0)
									@foreach($arrayPasosCompletados as $pasoCompletado)
										<li class="complete"> 
											<span class="handle" > <label class="checkbox state-disabled">
												@if($responsable == 1)
													<input type="checkbox" name="checkbox-inline" checked="checked" onchange="marcarPaso({{$pasoCompletado['idPaso']}}, 0);">
													<i></i> </label> 
												@endif
											</span>
											<p style="height: 8px !important">
												<strong>{{$pasoCompletado['textoPaso']}}</strong></span>
												<span class="date">{{ucfirst(utf8_encode(strftime("%A %d de %B de %Y", strtotime($pasoCompletado['fechaPasoProceso']))))}}</span>
											</p>
											<strong>{{$pasoCompletado['comentarioPaso']}}</strong>
										</li>
									@endforeach
								@endif
							</ul>
							<!-- end content -->
						</div>
					</div>
				</div>
			</article>
		</div>
	</section>
    <!--#CONTENT -->
</div>