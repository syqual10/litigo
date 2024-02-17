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
        .tbl-criterios {
            width:100%;
            border-collapse:collapse;
        }
        .tbl-criterios tr td, th
		{
			border: 1px solid #c3c3c3;
            text-align:center;
            padding:0 4px
		}
        .tbl-criterios tr td p{
            font-size:0.65em;
        }
        .tbl-calificacion {
            width:100%;
            border-collapse:collapse;
        }
        .tbl-calificacion tr th
		{
			border: 1px solid #c3c3c3;
            text-align:center;
            padding:0 4px;
            font-size: 0.9em;
		}
        .tbl-calificacion tr td
		{
			border: 1px solid #c3c3c3;
            text-align:center;
            padding:0 4px;
            font-size: 0.93em;
		}
        .bg {
            background: #f0f0f0;
            font-weight: bold;
        }
        .tbl-total {
            width:100%;
            border-collapse:collapse;
        }
        .tbl-total tr th
		{
			border: 1px solid #c3c3c3;
            text-align:center;
            padding:0 4px;
            font-size: 0.9em;
		}
        .tbl-total tr td
		{
			border: 1px solid #c3c3c3;
            text-align:center;
            padding:0 4px;
            font-size: 0.93em;
		}
        .x{
            font-size: 1.2em;
            font-weight: bold;
        }

		@page { margin: 40px 52px 60px 52px; }          
	        .footer { position: fixed; left: 0px; bottom: -160px; right: 10px; height: 165px;}
	        .footer .copia {color:gray;}
	      
	        #paginaPrincipal{
	            vertical-align:middle;
	            text-align: center;
	            margin-top: 200px;
	        }
		</style>
	</head>
	<body>
        @php
            use SQ10\helpers\Util as Util;
        @endphp
        @if (count($valoracion) > 0)
            <div class="footer">
                <div align="center" style="font-size:12px;"> 
                    <span class="copia">litíGo ® - Gestión Jurídica</span> 
                </div>
            </div>

            <table id="cabezote"> 
                <tr>
                    <td rowspan="3" style="text-align: center;width:15%"><img src="documentos/entidad/escudo.png" style="height:52px;"></td>
                    <td style="text-align: center;width:70%;font-weight:bold">ALCALDÍA DE MANIZALES</td>
                    <td style="text-align: center;width:15%">
                        PSI-SJM-FR-09
                    </td>
                </tr>	
                <tr>
                    <td style="text-align: center">SERVICIOS JURÍDICOS</td>
                    <td style="text-align: center">Estado Vigente</td>
                </tr>

                <tr>
                    <td style="text-align: center;font-weight:bold;font-size:0.8em">
                        VALORACIÓN DE LA PROBABILIDAD DE FALLOS JUDICIALES EN CONTRA DEL MUNICIPIO
                    </td>
                    <td style="text-align: center">Versión 1</td>
                </tr>

            </table>        
            <br>
            <table style="width:100%">
                <tr>
                    <td><strong>PROCESO RADICADO:</strong></td>
                    <td><strong>{{$valoracion[0]->codigoProceso}}</strong> (litíGo {{$valoracion[0]->vigenciaRadicado."-".$valoracion[0]->idRadicado}})</td>
                </tr>
                <tr>
                    <td><strong>TIPO DE ACCIÓN / MEDIO DE CONTROL:</strong></td>
                    <td>{{$valoracion[0]->nombreTipoProceso." / ".$valoracion[0]->nombreMedioControl}}</td>
                </tr>
                <tr>
                    <td><strong>DEMANDANTE:</strong></td>
                    <td>{{Util::personaDemandante($valoracion[0]->vigenciaRadicado, $valoracion[0]->idRadicado, $valoracion[0]->juritipoprocesos_idTipoProceso)}}</td>
                </tr>
                <tr>
                    <td><strong>VALOR DE LAS PRETENSIONES:</strong></td>
                    <td>{{Util::cuantiasRadicado($valoracion[0]->vigenciaRadicado, $valoracion[0]->idRadicado)}}</td>
                </tr>
                <tr>
                    @php
                        $apoderados = Util::apoderadosRadicado($valoracion[0]->vigenciaRadicado, $valoracion[0]->idRadicado)
                    @endphp
                    <td><strong>ABOGADO ASIGNADO:</strong></td>
                    <td>
                        @if(count($apoderados) > 0)
                            @foreach($apoderados as $apoderado)
                                {{$apoderado->nombresUsuario}} <br>
                            @endforeach
                        @endif
                    </td>
                </tr>
            </table>

            <div style="padding:3px;background:#f0f0f0;font-weight:bold;text-align:center">INTERPRETACIÓN PARA LA ASIGNACIÓN DE PORCENTAJE A CADA CRITERIO EVALUADO</div>
            <!-- Criterio 1 -->
            <div style="padding:2px;margin-top:4px;background:#fff;font-weight:bold;text-align:center;font-size:0.8em">Criterio N° 1 - Fortaleza de los planteamientos de la demanda, presentación y desarrollo</div>
            <table class="tbl-criterios">
                <tr>
                    <th style="width:33.3%">BAJA entre 0% - 3%</th>
                    <th style="width:33.3%">MEDIA entre 4% - 7%</th>
                    <th style="width:33.3%">ALTA entre 8% - 10%</th>
                </tr>
                <tr>
                    <td>
                        <p align="justify">Los planteamientos de la demanda no están bien sustentados, por lo cual el campo de acción por parte del Municipio es muy amplio</p>
                    </td>
                    <td>
                        <p align="justify">Los planteamientos de la demanda son sólidos y bien sustentados, pero existe margen de intermediación, por medio del cual se podría interponer una defensa consistente</p>
                    </td>
                    <td>
                        <p align="justify">Los planteamientos de la demanda son sólidos y bien sustentados, dejando casi inexistente el campo de acción por parte del Municipio</p>
                    </td>
                </tr>
            </table>

            <!-- Criterio 2 -->
            <div style="padding:2px;margin-top:4px;background:#fff;font-weight:bold;text-align:center;font-size:0.8em">Criterio N° 2 - Fortaleza de las excepciones propuestas al contestar la demanda</div>
            <table class="tbl-criterios">
                <tr>
                    <th style="width:33.3%">BAJA entre 0% - 4%</th>
                    <th style="width:33.3%">MEDIA entre 5% - 10%</th>
                    <th style="width:33.3%">ALTA entre 11% - 15%</th>
                </tr>
                <tr>
                    <td>
                        <p align="justify">Las excepciones presentadas, van a ser definitivas y favorables en la solución de la controversia judicial</p>
                    </td>
                    <td>
                        <p align="justify">Es posible que las excepciones presentadas con la demanda surtan el efecto esperado</p>
                    </td>
                    <td>
                        <p align="justify">Es casi seguro que las excepciones presentadas con la demanda no prosperen</p>
                    </td>
                </tr>
            </table>

            <!-- Criterio 3 -->
            <div style="padding:2px;margin-top:4px;background:#fff;font-weight:bold;text-align:center;font-size:0.8em">Criterio N° 3 - Presencia de riesgos procesales</div>
            <table class="tbl-criterios">
                <tr>
                    <th style="width:33.3%">BAJA entre 0% - 3%</th>
                    <th style="width:33.3%">MEDIA entre 4% - 7%</th>
                    <th style="width:33.3%">ALTA entre 8% - 10%</th>
                </tr>
                <tr>
                    <td>
                        <p align="justify">Los riesgos procesales son inexistentes, o inoperantes en el caso</p>
                    </td>
                    <td>
                        <p align="justify">Los riesgos procesales inmersos son válidos, aunque no suficientes para representar un peligro potencial</p>
                    </td>
                    <td>
                        <p align="justify">Los riesgos procesales inmersos en el caso tienen la suficiencia necesaria para representar un peligro potencial</p>
                    </td>
                </tr>
            </table>

            <!-- Criterio 4 -->
            <div style="padding:2px;margin-top:4px;background:#fff;font-weight:bold;text-align:center;font-size:0.8em">Criterio N° 4 - Suficiencia del material probatorio en contra del Municipio</div>
            <table class="tbl-criterios">
                <tr>
                    <th style="width:33.3%">BAJA entre 0% - 4%</th>
                    <th style="width:33.3%">MEDIA entre 5% - 10%</th>
                    <th style="width:33.3%">ALTA entre 11% - 15%</th>
                </tr>
                <tr>
                    <td>
                        <p align="justify">El material probatorio aportado por el demandante no es suficiente desde el punto de vista jurídico para la prosperidad de las pretensiones</p>
                    </td>
                    <td>
                        <p align="justify">El material probatorio aportado por el demandante es válido, desde el punto de vista jurídico, para la prosperidad de las pretensiones</p>
                    </td>
                    <td>
                        <p align="justify">El material probatorio aportado por el demandante es el suficiente desde el punto de vista jurídico para la prosperidad de las pretensiones</p>
                    </td>
                </tr>
            </table>

            <!-- Criterio 5 -->
            <div style="padding:2px;margin-top:4px;background:#fff;font-weight:bold;text-align:center;font-size:0.8em">Criterio N° 5 - Debilidad de las pruebas con que cuenta el Municipio</div>
            <table class="tbl-criterios">
                <tr>
                    <th style="width:33.3%">BAJA entre 0% - 3%</th>
                    <th style="width:33.3%">MEDIA entre 4% - 7%</th>
                    <th style="width:33.3%">ALTA entre 8% - 10%</th>
                </tr>
                <tr>
                    <td>
                        <p align="justify">Las pruebas con las que cuenta el Municipio son suficientes para una defensa exitosa</p>
                    </td>
                    <td>
                        <p align="justify">Las pruebas con las que cuenta el Municipio, no son suficientes para una segura defensa exitosa, pero servirán para interponer una posible defensa exitosa </p>
                    </td>
                    <td>
                        <p align="justify">Las pruebas con las que cuenta el Municipio no son suficientes para una defensa exitosa</p>
                    </td>
                </tr>
            </table>

            <!-- Criterio 6 -->
            <div style="padding:2px;margin-top:4px;background:#fff;font-weight:bold;text-align:center;font-size:0.8em">Criterio N° 6 - Antecedente jurisprudencial</div>
            <table class="tbl-criterios">
                <tr>
                    <th style="width:33.3%">BAJA entre 0% - 15%</th>
                    <th style="width:33.3%">MEDIA entre 16% - 30%</th>
                    <th style="width:33.3%">ALTA entre 31% - 40%</th>
                </tr>
                <tr>
                    <td>
                        <p align="justify">No existe ningún antecedente similar o jurisprundencial que permita prever un fallo en contra del Municipio</p>
                    </td>
                    <td>
                        <p align="justify">Se han presentado algunos casos similares que podran definir líneas jurisprudenciales, con el respectivo impacto negativo sobre las finanzas del Municipio</p>
                    </td>
                    <td>
                        <p align="justify">Existe suficiente jurisprudencia para un fallo adverso e inminente</p>
                    </td>
                </tr>
            </table>
            <br>
            <!-- Calificación-->
            @php
                $total = 0;
            @endphp
            <table class="tbl-calificacion">
                <tr>
                    <th class="bg" style="width:1%">N°</th>
                    <th class="bg" style="width:10%">PORCENTAJE DISPONIBLE</th>
                    <th class="bg" style="width:69%">CRITERIOS DE CALIFICACIÓN</th>
                    <th class="bg" style="width:20%">PORCENTAJE ASIGNADO</th>
                </tr>
                @foreach ($valoracion as $val)
                    <tr>
                        <td class="bg">{{$val->idCriterio}}</td>
                        <td>{{$val->topeCriterio}}%</td>
                        <td>{{$val->descripcionCriterio}}</td>
                        <td>{{$val->valorCriterio}}%</td>
                    </tr>   
                @php
                    $total += $val->valorCriterio;
                @endphp
                @endforeach
                <tr>
                    <td colspan="3" style="text-align:right;font-size: 1.1em"><strong>TOTAL</strong></td>
                    <td style="font-size: 1.1em"><strong>{{$total}}%</strong></td>
                </tr>
            </table>
            <br>
            <!-- Total puntaje -->
            <table class="tbl-total">
                <tr>
                    <th class="bg" style="width:40%">PROBABILIDAD DE FALLO EN CONTRA</th>
                    <th class="bg" style="width:20%">BAJA</th>
                    <th class="bg" style="width:20%">MEDIA</th>
                    <th class="bg" style="width:20%">ALTA</th>
                </tr>
                <tr>
                    <td class="bg">PUNTAJE</td>
                    <td>0% - 10%</td>
                    <td>11% - 50%</td>
                    <td>51% - 100%</td>
                </tr>   
                <tr>
                    <td class="bg">VALORACIÓN</td>
                    <td>
                        @if ($total >= 0 && $total <= 10)
                            <span class="x">X</span>
                        @endif
                    </td>
                    <td>
                        @if ($total >= 11 && $total <= 50)
                            <span class="x">X</span>
                        @endif
                    </td>
                    <td>
                        @if ($total >= 51 && $total <= 100)
                            <span class="x">X</span>
                        @endif
                    </td>
                </tr>   
            </table>

            <table style="width:100%;margin-top:54px">
                <tr>
                    <td style="width:50%">
                        <strong>FIRMA</strong>
                    </td>
                    <td style="width:50%">
                        <strong>FIRMA</strong>
                    </td>
                    td
                </tr>
                <tr>
                    <td><strong>NOMBRE</strong></td>
                    <td><strong>NOMBRE</strong></td>
                </tr>
                <tr>
                    <td><strong>CARGO</strong></td>
                    <td><strong>CARGO</strong></td>
                </tr>
            </table>
            <br>
            <div>
            Firmado el {{ucfirst(utf8_encode(strftime("%A %d de %B de %Y", strtotime($valoracion[0]->fechaValoracionFallo))))}} 
            </div>	
        @else
            No se encontró información del radicado
		@endif
	</body>
</html>