@extends('layouts.masterMail')
@section('contenido')
    <tr>
        <td class="cta-block__title" style="padding: 35px 0 0 0; font-size: 26px; text-align: center;">Procesos no leídos en el buzón, y no se han empezado a trabajar</td>
	</tr>
	<tr>
		<td class="cta-block__title" style="padding: 0; font-size: 26px; text-align: center;">{{ $arreglo['nombreUsuario']}}</td>
	</tr>

    <tr>
    	<td style="padding-top: 20px;">
	    	@if(count($arreglo['arraySinLeer']) > 0)
		    	<table style="font-size: 0.9em;" id="tablaAgendaEmail">
					<thead>
					    <tr>
					    	<th width="15%" style="text-align: center;">Radicado del Juzgado</th>
					    	<th width="15%" style="text-align: center;">Juzgado</th>
					    	<th width="15%" style="text-align: center;">Fecha de reparto al buzón</th>
					    	<th width="15%" style="text-align: center;">Tema</th>
					    	<th width="15%" style="text-align: center;">Tipo de proceso</th>
					    	<th width="15%" style="text-align: center;">Radicado Interno litígo</th>
					    	<th width="10%" style="text-align: center;">Ver en el sistema</th>
					    </tr>
				  	</thead>
					<tbody>
					    @foreach($arreglo['arraySinLeer'] as $noLeido)
					        <tr>
					        	<td class="cta-block__content"> <strong>{{$noLeido['radicadoJuzgado'] }}</strong>
					        	</td>

					        	<td class="cta-block__content"> {{$noLeido['juzgado'] }}
					        	</td>

					        	<td class="cta-block__content"> {{$noLeido['fechaReparto'] }}
					        	</td>

					        	<td class="cta-block__content"> {{$noLeido['tema'] }}
					        	</td>

					        	<td class="cta-block__content"> {{$noLeido['nombreTipoProceso']}}
					        	</td>

					        	<td class="cta-block__content"> {{$noLeido['vigenciaRadicado'] }} - {{$noLeido['idRadicado'] }}
					        	</td>

					        	<td class="cta-block__button" widlabel="300" align="center" style="widlabel: 300px;">
			                        <a href="https://www.syqual10.com/juridica/{{$noLeido['rutaEmail']}}" style="border: 3px solid #eeeeee; color: #969696; text-decoration: none; padding: 15px 45px; text-transform: uppercase; display: block; text-align: center; font-size: 16px;">Ver en el Sistema</a>
			                    </td>
					        </tr>
					    @endforeach
				    </tbody>
				</table>
	    	@endif
    	</td>
    </tr>
@endsection