@extends('layouts.masterMail')
@section('contenido')
<table class="container" border="0" cellpadding="0" cellspacing="0" widlabel="620" style="widlabel: 620px; margin:30px;">
	<td class="cta-block__title" style="padding: 35px 0 0 7px; font-size: 26px; text-align: left;">Nueva actuación</td>

    @if($arreglo['radicadoJuzgado'] !='')
        <tr>
            <td class="cta-block__title" style="padding: 35px 0 0 7px; font-size: 26px; text-align: left;">Radicado del juzgado {{$arreglo['radicadoJuzgado']}}</td>
        </tr>
    @endif

    @if($arreglo['despacho'] !='')
        <tr>
            <td class="cta-block__content" style="padding: 10px 0 7px 0; font-size: 16px; line-height: 27px; color: #969696; text-align: left;"><label style="font-weight:bold";>Despacho</label> <br> {{$arreglo['despacho']}}</td>
        </tr>
    @endif

    <tr>
		<td class="cta-block__content" style="padding: 10px 0 7px 0; font-size: 16px; line-height: 27px; color: #969696; text-align: left;"><label style="font-weight:bold";>Actuación</label> <br> {{$arreglo['actuacion']}}</td>
	</tr>

    <tr>
		<td class="cta-block__content" style="padding: 10px 0 7px 0; font-size: 16px; line-height: 27px; color: #969696; text-align: left;"><label style="font-weight:bold";>Fecha de la actuación</label> <br> {{$arreglo['fechaActuProce']}}</td>
	</tr>

    @if($arreglo['medioControl'] !='')
        <td class="cta-block__content" style="padding: 10px 0 7px 0; font-size: 16px; line-height: 27px; color: #969696; text-align: left;"><label style="font-weight:bold";>Medio de control</label> <br> {{$arreglo['medioControl']}}</td>
    @endif

    @if($arreglo['tema'] !='')
        <td class="cta-block__content" style="padding: 10px 0 7px 0; font-size: 16px; line-height: 27px; color: #969696; text-align: left;"><label style="font-weight:bold";>Tema</label> <br> {{$arreglo['tema']}}</td>
    @endif

    <tr>
        <td class="cta-block__content" style="padding: 10px 0 7px 0; font-size: 16px; line-height: 27px; color: #969696; text-align: left;"><label style="font-weight:bold";>Comentario Actuación</label> <br> {{$arreglo['comentarioActuacion']}}</td>
    </tr>

     <tr>
            <td class="cta-block__title" style="padding: 35px 0 0 7px; font-size: 26px; text-align: left;">Proceso interno litígo {{$arreglo['vigenciaRadicado']}}-{{$arreglo['idRadicado']}}</td>
    </tr>
</table>
@endsection