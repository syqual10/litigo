<div class="row" style="margin-bottom: 15px;" >
	<div class="form-wrap">
		<div class="form-group">
			<div class="row" style="margin-bottom: 15px;" >
				<div class="col-sm-1">
				</div>
				<div class="col-sm-5">
					<div class="fresh-table full-screen-table toolbar-color-blue">
					    <table id="tabla-fresh-activos" >
					        <thead>
					            <tr>
					                <th data-sortable="true">Activos nombre</th>
					                <th data-sortable="true"></th>
					            </tr>
					        </thead>
					        <tbody>
					        @if(count($activosTipoProceso) > 0)
					            @foreach($activosTipoProceso as $activo)
					                <tr>
					                    <td style="width:90%">{{$activo['nombreModuloAct']}} </td>
					                    <td style="width:5%">
	                                        <div class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input" name="activo[]" value="1-{{ $activo['idModuloActivo'] }}" >
											</div>
					                    </td>
					                </tr>
					            @endforeach
					        @endif
					        </tbody>
					    </table>
					</div>
				</div>	

				<div class="col-sm-1">
					<br>
					<br>
					<br>
					<br>
					<br>
					<a class="btn btn-success btn-block" onclick="inactivar()"> <= Activar </a>
					<br>
					<br>
					<br>
					<br>
					<br>
					<a class="btn btn-danger btn-block"  onclick="activar()"> Inactivar => </a>
				</div>
				<div class="col-sm-5">
					<div class="fresh-table full-screen-table toolbar-color-blue">
					    <table id="tabla-fresh-inactivos">
					        <thead>
					            <tr>
					                <th data-sortable="true">Inactivos Nombre</th>
					                <th data-sortable="true"></th>
					            </tr>
					        </thead>
					        <tbody>
					        @if(count($inativosTipoProceso) > 0)
					            @foreach($inativosTipoProceso as $inactivo)
					                <tr>
					                    <td style="width:90%">{{$inactivo['nombreModuloInac']}} </td>
					                    <td style="width:5%">
	                                        <div class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input" name="inactivo[]" value="0-{{ $inactivo['idModuloInactivo'] }}" >
											</div>
					                    </td>
					                </tr>
					            @endforeach
					        @endif
					        </tbody>
					    </table>
					</div>
				</div>	
			</div>
		</div>
	</div>
</div>