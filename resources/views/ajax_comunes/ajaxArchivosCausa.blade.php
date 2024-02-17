@php
  use SQ10\helpers\Util as Util;
@endphp

@if(count($archivosCausas) > 0)
  @foreach($archivosCausas as $archivoCausa)
    @php
      $partes = explode("_", $archivoCausa->nombreArchivo);
      $nombre = substr($archivoCausa->nombreArchivo,strlen($partes[0])+1);
      $responsableArchivo = Util::responsableArchivo($archivoCausa->idArchivo, $idResponsable);
    @endphp
    @if(Session::get('idUsuario') == 1 || Session::get('idUsuario') == 112)
      <button class="btn btn-xs btn-danger btn-rounded" onclick="eliminarArchivoCausa({{$archivoCausa->idArchivo}})"><i class="fa fa-trash"></i> Eliminar</button>
    @endif
    @if($archivoCausa->extensionArchivo == 'pdf')
      <a style="cursor:pointer; text-decoration:none !important;" onclick="verArchivoPdf({{$archivoCausa->idArchivo}}, {{$vigenciaRadicado}}, {{$idRadicado}});">
    @else
      <a style="cursor:pointer; text-decoration:none !important;" href="{{ asset('juridica/descargarArchivo/'.$archivoCausa->idArchivo) }}">
    @endif
      <img src="{{ asset("assets/images/".$archivoCausa->extensionArchivo.".png") }}" width="26" style="padding:0; margin-right:8px;">
      <h5 style="font-size:10px;">
        {{ $nombre }}
      </h5>
      </a>
  @endforeach
@endif