@extends('layouts.masterMail')
@section('contenido')
<table class="container" border="0" cellpadding="0" cellspacing="0" widlabel="620" style="widlabel: 620px; margin:30px;">
    @if(isset($arreglo['radicadoJuzgado']))
        @if($arreglo['radicadoJuzgado'] !='')
            <tr>
                <td class="cta-block__title" style="padding: 35px 0 0 7px; font-size: 26px; text-align: left;">Radicado del juzgado {{$arreglo['radicadoJuzgado']}}</td>
            </tr>
        @endif
    @endif
  

    <tr>
        <td class="cta-block__title" style="padding: 35px 0 0 7px; font-size: 26px; text-align: left;">Proceso Interno del sistema {{$arreglo['vigenciaRadicado']}}-{{$arreglo['idRadicado']}} Asignado</td>
    </tr>

    @if(isset($arreglo['nombreJuzgado']))
        @if($arreglo['nombreJuzgado'] !='')
            <tr>
                <td class="cta-block__content" style="padding: 10px 0 7px 0; font-size: 16px; line-height: 27px; color: #969696; text-align: left;"><label style="font-weight:bold";>Juzgado</label> <br> {{$arreglo['nombreJuzgado']}}</td>
            </tr>
        @endif
    @endif

    <tr>
        <td class="cta-block__content" style="padding: 10px 0 7px 0; font-size: 16px; line-height: 27px; color: #969696; text-align: left;"><label style="font-weight:bold";>Nombre proceso</label> <br> {{$arreglo['nombreTipoProceso']}}</td>
    </tr>

    @if(isset($arreglo['nombreMedioControl']))
        @if($arreglo['nombreMedioControl'] !='')
            <td class="cta-block__content" style="padding: 10px 0 7px 0; font-size: 16px; line-height: 27px; color: #969696; text-align: left;"><label style="font-weight:bold";>Medio de control</label> <br> {{$arreglo['nombreMedioControl']}}</td>
        @endif
    @endif

    @if(isset($arreglo['demandantes']))
        <tr>
            <td class="cta-block__content" style="padding: 10px 0 7px 0; font-size: 16px; line-height: 27px; color: #969696; text-align: left;"><label style="font-weight:bold";>Demandantes</label> <br> {{$arreglo['demandantes']}}</td>
        </tr>
    @endif

    @if(isset($arreglo['demandados']))
        <tr>
            <td class="cta-block__content" style="padding: 10px 0 17px 0; font-size: 16px; line-height: 27px; color: #969696; text-align: left;"><label style="font-weight:bold";>Demandados</label> <br> {{$arreglo['demandados']}}</td>
        </tr>
    @endif

    <tr>
        <td class="cta-block__content" style="padding: 10px 0 7px 0; font-size: 16px; line-height: 27px; color: #969696; text-align: left;"><label style="font-weight:bold";>Descripción de los hechos</label> <br> {{$arreglo['causasHechos']}}</td>
    </tr>

    @if(isset($arreglo['nombreTema']))
        @if($arreglo['nombreTema'] !='')
            <td class="cta-block__content" style="padding: 10px 0 7px 0; font-size: 16px; line-height: 27px; color: #969696; text-align: left;"><label style="font-weight:bold";>Tema</label> <br> {{$arreglo['nombreTema']}}</td>
        @endif
    @endif

    @if(isset($arreglo['rutaEmail']))
        <tr>
            <td align="center">
                <table class="container" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="cta-block__button" widlabel="300" align="center" style="widlabel: 300px;">
                            <a href="https://www.syqual10.com/juridica/{{$arreglo['rutaEmail']}}" style="border: 3px solid #eeeeee; color: #969696; text-decoration: none; padding: 15px 45px; text-transform: uppercase; display: block; text-align: center; font-size: 16px;">Ver en el Sistema</a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    @endif
</table>
@endsection