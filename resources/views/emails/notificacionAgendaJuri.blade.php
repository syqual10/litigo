@extends('layouts.masterMail')
@section('contenido')
    <tr>
        <td class="cta-block__title" style="padding: 35px 0 0 0; font-size: 26px; text-align: center;">Agenda del día {{ucfirst(utf8_encode(strftime("%A %d de %B de %Y", strtotime($arreglo['diaAgenda'])))) }}</td>
	</tr>
	<tr>
		<td class="cta-block__title" style="padding: 0; font-size: 26px; text-align: center;">{{ $arreglo['nombreUsuario']}}</td>
	</tr>

    <tr>
    	<td style="padding-top: 20px;">
	    	@if(count($arreglo['agendas']) > 0)
		    	<table style="font-size: 0.9em;" id="tablaAgendaEmail">
					<thead>
					    <tr>
					    	<th width="11%" style="text-align: center;">Radicado del Juzgado</th>
					    	<th width="11%" style="text-align: center;">Juzgado</th>
					    	<th width="11%" style="text-align: center;">Tipo de agenda</th>
					    	<th width="11%" style="text-align: center;">Agenda</th>
					    	<th width="11%" style="text-align: center;">Asunto</th>
					    	<th width="11%" style="text-align: center;">Tipo de proceso</th>
					    	<th width="11%" style="text-align: center;">Medio de control</th>
					    	<th width="11%" style="text-align: center;">Tema</th>
					    	<th width="11%" style="text-align: center;">Número interno del sistema</th>
					    </tr>
				  	</thead>
					<tbody>
					    @foreach($arreglo['agendas'] as $agen)
					        <tr>
					        	<td class="cta-block__content"> <strong>{{$agen->radicadoJuzgado }}</strong>
					        	</td>

					        	<td class="cta-block__content"> {{$agen->nombreJuzgado }}
					        	</td>

					        	@if($agen->critico == 1)
					            	<td class="cta-block__content" style="font-weight: bold;"> Agenda Crítica 
					            	</td>
					            @else
					            	<td class="cta-block__content" style="font-weight: bold;"> No Crítica 
					            	</td>
					            @endif

					        	<td class="cta-block__content"> {{ucfirst(utf8_encode(strftime("%b %d de %Y", strtotime($agen->fechaInicioAgenda))))}} -
                                    {{ date('h:i A', strtotime($agen->fechaInicioAgenda))}}
					        	</td>

					        	<td class="cta-block__content"> {{$agen->asuntoAgenda }}
					        	</td>

					        	<td class="cta-block__content"> {{$agen->nombreTipoProceso}}
					        	</td>

					        	<td class="cta-block__content"> {{$agen->nombreMedioControl}}
					        	</td>

					        	<td class="cta-block__content"> {{$agen->nombreTema }}
					        	</td>

					        	<td class="cta-block__content"> {{$agen->idRadicado.'-'.$agen->vigenciaRadicado}}
					        	</td>
					        </tr>
					    @endforeach
				    </tbody>
				</table>
	    	@endif
    	</td>
    </tr>
@endsection