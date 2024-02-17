@if(count($todosReposts) > 0)
	@foreach($todosReposts as $todoRepost)
	    <li class="message message-reply">
	    	@php
        		$imgRePost = '../public/juriArch/entidad/usuarios/'.$todoRepost->documentoUsuario.'.jpg';

				if(file_exists($imgRePost)) 
				{
				    $imgRePost = asset('juriArch/entidad/usuarios/'.$todoRepost->documentoUsuario.'.jpg');
				}
				else
				{
				    $imgRePost = asset('img/avatar-profile.png');
				}
        	@endphp
            <img src="{{$imgRePost}}" width="35" height="35" class="online" alt="">
	        <div id="resultadoModificarPost_{{$todoRepost->idPosteo}}">
	        	<span class="message-text"> <a href="#" class="username">{{$todoRepost->nombresUsuario}}</a> {{$todoRepost->post}} <i class="txt-color-orange"></i> </span>
	        </div>

	        <ul class="list-inline font-xs">
	            <li>
	                <a href="#" class="text-muted">{{ucfirst(utf8_encode(strftime("%A %d de %B de %Y", strtotime($todoRepost->fechaPosteo))))}} - {{ date('h:i A', strtotime($todoRepost->fechaPosteo))}} </a>
	            </li>
	            @if($todoRepost->juriresponsables_idResponsable == $idResponsable)
		            <li>
		                <a style="cursor: pointer;" onclick="modificarPost({{$todoRepost->idPosteo}}, {{$idPost}});" class="text-primary">Editar</a>
		            </li>
		            <li>
		                <a style="cursor: pointer;" onclick="borrarPost({{$todoRepost->idPosteo}}, {{$todoRepost->juriposteos_idPosteo}});" class="text-danger">Borrar</a>
		            </li>
		        @endif
	        </ul>
	    </li>
	@endforeach
@endif