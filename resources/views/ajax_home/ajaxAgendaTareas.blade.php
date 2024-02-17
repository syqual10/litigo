<div class="row">
	<div class="col-sm-11">
		<!-- widget grid -->
		<section id="widget-grid" style="margin-left:10px">
			<!-- row -->
			<div class="row">
				<!-- NEW WIDGET START -->
				<article class="col-sm-12">
					<div class="jarviswidget jarviswidget-color-blue" role="widget">
						<header role="heading">
							<h2>Tareas <strong><i>para hoy</i></strong></h2>	
						</header>
						<!-- widget div-->
						<div role="content">							
							<!-- widget content -->
							<div class="widget-body">
								@if (count($tareas) > 0)
						     		<div class="progress-group" style="margin: 0; font-weight: bold">
									    <span class="progress-text">Cumplimiento</span>
									    <span class="progress-number">{{round($porcentaje, 1)}}%</span>
									    <div class="progress sm" style="margin: 5px 0;">
											@if($porcentaje <= 50)
												<div class="progress-bar progress-bar-red" style="width: {{round($porcentaje, 1)}}%"></div>
											@elseif($porcentaje > 50 && $porcentaje < 100)
												<div class="progress-bar progress-bar-yellow" style="width: {{round($porcentaje, 1)}}%"></div>
											@elseif($porcentaje >= 100)
												<div class="progress-bar progress-bar-green" style="width: {{round($porcentaje, 1)}}%"></div>
											@endif
									    </div>
									</div>
								@endif
								<hr>
								<div class="box-body direct-chat-messages">
									@if (count($tareas) > 0)
										<table id="tabla-agda">	
											@foreach ($tareas as $tarea)
												<tr>
										            <td style="width:10%">
										                <small class="label label-warning" style="font-size: 0.9em;">
										            		<i class="fa fa-clock-o"></i>
										                	{{date("g:i a", strtotime(substr($tarea['fechaInicioAgenda'], -8, 8)))}}
										                </small>
										            </td>
										            <td style="width:80%">	
										            	<div class="inputGroup">  	
		  													@if ($tarea['agendaFinalizada'] == 1)
											            		<input type="checkbox" value="{{$tarea['Id']}}" id="chk-{{$tarea['Id']}}" class="strikethrough" onchange="estadoAgendaTarea(this.value, 0)" checked>
											            		<label for="chk-{{$tarea['Id']}}">{{$tarea['asuntoAgenda']}}</label>
											            	@else
																<input type="checkbox" value="{{$tarea['Id']}}" id="chk-{{$tarea['Id']}}" class="strikethrough" onchange="estadoAgendaTarea(this.value, 1)">
											            		<label for="chk-{{$tarea['Id']}}">{{$tarea['asuntoAgenda']}}</label>
											            	@endif
										            	</div>
										          	</td>
										          	<td style="width:10%">	
										                @if($tarea['juriradicados_idRadicado'] !='')
											          		<a href="{{asset($tarea['ruta'])}}">
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
								    	<div class="alert alert-white alert-dismissible">
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