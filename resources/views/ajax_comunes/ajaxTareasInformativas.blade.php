<div class="row">
	<div class="col-sm-11">
		<!-- widget grid -->
		<section id="widget-grid">
			<!-- row -->
			<div class="row">
				<!-- NEW WIDGET START -->
				<article class="col-sm-11">
					<div class="jarviswidget jarviswidget-color-blue" role="widget">
						<header role="heading">
							<h2>Tareas <strong><i>para {{$texto}}</i></strong></h2>	
						</header>
						<!-- widget div-->
						<div role="content" style="width: 91.2% !important">							
							<!-- widget content -->
							<div class="widget-body">
								<div class="box-body direct-chat-messages">
									@if (count($tareas) > 0)
										<table id="tabla-agda">											
											@foreach ($tareas as $tarea)
												<tr>
										            <td style="width:10%">
										                <small class="label label-danger" style="width: 80px !important">
										            		<i class="fa fa-clock-o"></i>
										                	{{date("g:i a", strtotime(substr($tarea['fechaInicioAgenda'], -8, 8)))}}
										                </small>
										            </td>
										            <td style="width:80%">
										                <span class="text" style="margin-left: 4px; display: block;">{{$tarea['asuntoAgenda']}}</span>
										            </td>
										          	<td style="width:10%">	
										                @if($tarea['juriradicados_idRadicado'] !='')
											          		<a href="#">
											          			<small class="label label-info" style="font-size: 0.9em;">
												                	{{$tarea['juriradicados_vigenciaRadicado']."-".$tarea['juriradicados_idRadicado']}}
												                </small>
												            </a>
												        @else    
												           	<a href="#">
											          			<small class="label label-info" style="font-size: 0.9em;">
												                	Personal
												                </small>
												            </a>
												        @endif
										            </td>
										        </tr>    
							        		@endforeach							      			
							      		</table>
								    @else
								    	<div class="alert alert-info">
								          <h4><i class="icon fa fa-info"></i><b>Atención</b></h4>
								          No se encontraron tareas programadas para hoy.
								      	</div>
								    @endif
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
</div>