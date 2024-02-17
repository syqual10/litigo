<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Despachos</title>
		<link rel="stylesheet" href="">
		<style>
		body{
			font-size:12px;
	        font-family: Arial, Helvetica, Verdana, serif;
	    }
		
		#cabezote
		{
			width: 100%;
			border-collapse:collapse;
		}
		#cabezote tr td
		{
			border: 1px solid #c3c3c3;
		}
.datagrid table {
    border-collapse: collapse;
    text-align: left;
    width: 100%;
}

.datagrid {
    font: normal 12px/150% Arial, Helvetica, sans-serif;
    background: #fff;
    overflow: hidden;
    border: 1px solid #072E58;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    border-radius: 3px;
}

.datagrid table td,
.datagrid table th {
    padding: 3px 10px;
}

.datagrid table thead th {
    background-color: #215263;
    color: #FFFFFF;
    font-size: 11px;
    font-weight: bold;
    border-left: 1px solid #0070A8;
}

.datagrid table thead th:first-child {
    border: none;
}

.datagrid table tbody td {
    color: #000000;
    font-size: 10px;
    border-bottom: 2px solid #E1EEF4;
    font-weight: normal;
}

.datagrid table tbody .alt td {
    background: #E1EEF4;
    color: #000000;
}

.datagrid table tbody td:first-child {
    border-left: none;
}

.datagrid table tbody tr:last-child td {
    border-bottom: none;
}
				
		

		@page { margin: 40px 52px 60px 52px; }          
	        .footer { position: fixed; left: 0px; bottom: -160px; right: 10px; height: 165px;}
	        .footer .copia {color:gray;}
	        .footer .page:after { content: counter(page, decimal);}
	          
	        .copiaCont { 
	            position: fixed; top: 10px; left: 1260px;
	            width: 780px;

	            -webkit-transform: rotate(90deg);
	            -moz-transform: rotate(90deg);
	            -o-transform: rotate(90deg);
	            writing-mode: lr-tb;
	            
	        }
	        .copiaCont .copiaC {color:Crimson;}
	        .copiaCont .copiaC2 {color:#000; font-weight: bold;}

	        #paginaPrincipal{
	            vertical-align:middle;
	            text-align: center;
	            margin-top: 200px;
	        }

	        hr {
	          page-break-after: always;
	          border: 0;
	          margin: 0;
	          padding: 0;
	        }	
		</style>
	</head>
	<body>
		<div class="copiaCont" style="font-size:12px;">
	    	<div> 
		    	<span class="copiaC">ANEXOS DEL GED
		            <span class="copiaC2"> - Impreso el {{ ucfirst(utf8_encode(strftime("%A %d de %B de %Y", strtotime(date('Y-m-d'))))) }} por {{ $usuario->nombresUsuario }}</span>
		        </span> 
	    	</div>
	    </div>

	    <div class="footer">
	        <div align="center" style="font-size:12px;"> 
	            <span class="copia">litíGo ® - Gestión Jurídica
	                <br> www.syqual10.com</span> 
	        </div>
	        <div align="right" class="page" style="font-size:12px;">Pag. </div>
	    </div>

		<table id="cabezote"> 
			<tr>
			    <td rowspan="4" style="text-align: center;width:15%"></td>
			    <td style="text-align: center;width:70%;font-weight:bold">ALCALDÍA DE MANIZALES</td>
			    <td rowspan="4" style="text-align: center;width:15%"><img src="img/litigo.png" style="height:32px;"></td>
			</tr>	
			<tr>
			    <td style="text-align: center;width:80%">Secretaria Jurídica</td>
			</tr>

			<tr>
			    <td style="text-align: center;width:80%;font-weight:bold">
			    	Constancia de entrega de procesos judiciales y tutelas
			    </td>
			</tr>

		</table>
		@if (count($anexosDespacho) > 0)
			<div class="datagrid">
				<table>
					<thead>
						<tr>
		                    <th class="text-center" width="5%">Radicado</th>
		                    <th class="text-center" width="10%">Rad Juzgado</th>
		                    <th class="text-center" width="10%">Tipo</th>
		                    <th class="text-center" width="5%">F. Actuación</th>
		                    <th class="text-center" width="15%">Despacho Judicial</th>
		                    <th class="text-center" width="20%">Usuario al que se remite</th>
		                    <th class="text-center" width="15%">Observación Actuación</th>
		                    <th width="20%">Firma de Recibido</th>
		                </tr>
					</thead>
					<tbody>
						@php
							$fila = 0;
						@endphp

						@foreach ($anexosDespacho as $despacho)
							@if ($fila % 2 )
								<tr class="alt">
							@else
								<tr>
							@endif
								<td>{{ $despacho["radicado"] }}</td>					
								<td>{{ $despacho["radicadoJuzgado"] }}</td>
								<td>{{ $despacho["tipoProceso"] }}</td>
								<td>{{ $fechaDes }}</td>
								<td>{{ $despacho["remitente"] }}</td>
								<td>{{ $despacho["destinatario"] }}</td>
								@if($despacho["reparto"] == 0)<!--ACTUACIONES-->
									<td>{{ $despacho["observacion"] }}</td>
								@endif
								<td></td>
							</tr>
							@php
								$fila++;
							@endphp
						@endforeach				
					</tbody>
				</table>
			</div>
		@endif
	</body>
</html>