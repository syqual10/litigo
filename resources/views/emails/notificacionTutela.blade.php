@extends('layouts.masterMail')
@section('contenido')
    <table class="container" border="0" cellpadding="0" cellspacing="0" widlabel="620" style="widlabel: 620px; margin:30px;">
        <tr>
            <td class="cta-block__title" style="padding: 35px 0 0 7px; font-size: 26px; text-align: left;">Hola {{$arreglo['nombreUsuario']}}, hoy {{$arreglo['fechaVence']}} se vence la siguiente tutela</td>
        </tr>


        <tr>
            <td class="cta-block__content" style="padding: 10px 0 7px 0; font-size: 16px; line-height: 27px; color: #969696; text-align: left;"><label style="font-weight:bold";>Radicado del juzgado</label> <br> {{$arreglo['radicadoJuzgado']}}</td>
        </tr>

        <tr>
    		<td class="cta-block__content" style="padding: 10px 0 7px 0; font-size: 16px; line-height: 27px; color: #969696; text-align: left;"><label style="font-weight:bold";>Juzgado</label> <br> {{$arreglo['juzgado']}}</td>
    	</tr>

        <td class="cta-block__content" style="padding: 10px 0 7px 0; font-size: 16px; line-height: 27px; color: #969696; text-align: left;"><label style="font-weight:bold";>Tema</label> <br> {{$arreglo['tema']}}</td>

        <tr>
            <td class="cta-block__title" style="padding: 35px 0 0 7px; font-size: 26px; text-align: left;">Radicado interno del sistema {{$arreglo['idRadicado']}} - {{$arreglo['vigenciaRadicado']}}</td>
        </tr>
    </table>
@endsection