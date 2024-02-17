@extends('layouts.masterError')
@section('contenido')
<div class='_404'>403</div>
<hr>
<div class='_1'>NO TIENE AUTORIZACIÓN</div>
<div class='_2'>PARA ACCEDER A ESTA SECCIÓN</div>
<a class='btn' href='#' onclick="history.go(-1);return false;">VOLVER ATRÁS</a>
@endsection