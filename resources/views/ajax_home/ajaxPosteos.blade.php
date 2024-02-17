<div method="post" class="well padding-bottom-10" onsubmit="return false;">
    <textarea id="posteo" rows="2" class="form-control" placeholder="Algo que compartir?"></textarea>
    <div class="margin-top-10">
        <a id="botonArchivoPost" onclick="validarGuardarPosteo();" class="btn btn-sm btn-primary pull-right btn-guardar-post">
            Publicar
        </a>

		<div id="divAddFilePost">
        	<a style="cursor: pointer;" onclick="subirArchivoPost(0);" class="btn btn-link profile-link-btn" rel="tooltip" data-placement="bottom" title="Agregar un archivo"><i class="fa fa-paperclip"></i></a>
        </div>
    </div>
</div>

@if(count($posteos) > 0)
	@foreach($posteos as $key => $posteo)
        @php
        	$todosRePosts = DB::table('juriposteos')
            	->where('juriposteos_idPosteo', '=', $posteo['idPosteo'])
                ->count();

            $archivosPosts = DB::table('juriarchivos')
            	->where('juriposteos_idPosteo', '=', $posteo['idPosteo'])
                ->get();

        	$rePosts = DB::table('juriposteos')
            	->join('juriresponsables', 'juriposteos.juriresponsables_idResponsable', '=', 'juriresponsables.idResponsable')
                ->join('usuarios', 'juriresponsables.usuarios_idUsuario', '=', 'usuarios.idUsuario')
            	->where('juriposteos_idPosteo', '=', $posteo['idPosteo'])
                ->skip(0)
                ->take(2)
                ->orderBy('fechaPosteo', 'DESC')
                ->get();

            $idUltimoPost[$key] = $posteo['idPosteo'];
        @endphp
		<div class="timeline-seperator text-center"> <span>{{ucfirst(utf8_encode(strftime("%A %d de %B de %Y", strtotime($posteo['fechaPosteo']))))}} - {{ date('h:i A', strtotime($posteo['fechaPosteo']))}}</span>
		</div>

		<div class="chat-body no-padding profile-message">
		    <ul>
		        <li class="message">
		        	@php
		        		$imgPost = '../public/juriArch/entidad/usuarios/'.$posteo['documentoUsuario'].'.jpg';

						if(file_exists($imgPost)) 
						{
						    $imgPost = asset('juriArch/entidad/usuarios/'.$posteo['documentoUsuario'].'.jpg');
						}
						else
						{
						    $imgPost = asset('img/avatar-profile.png');
						}
		        	@endphp
		            <img src="{{$imgPost}}" width="50" height="50" class="online" alt="">
		            <div id="resultadoModificarPost_{{$posteo['idPosteo']}}">
		            	<span class="message-text"> <a href="#" class="username"> {{$posteo['nombresUsuario']}} </a> {{$posteo['post']}} </span>
		            </div>
		            <ul class="list-inline font-xs">
		                <li>
		                    <a style="cursor: pointer;" class="text-muted" onclick="mostrarTodosRepost({{$posteo['idPosteo']}});"><span id="mostrarTodosComentarios_{{$posteo['idPosteo']}}">Mostrar todos los comentarios ({{$todosRePosts}})</span></a>
		                </li>
		                
		                <!--ARCHIVOS DE LOS POSTS PADRES -->
			        	@if(count($archivosPosts) > 0)
			                @foreach($archivosPosts as $archivoPost)
		                		<li>
					                <a href="{{ asset('home/descargarArchivoPost/'.$archivoPost->idArchivo ) }}" tittle="Descargar archivo" class="btn btn-link profile-link-btn"><i class="fa fa-file"></i></a>
					            </li>
			                @endforeach
						@endif

		                @if($posteo['idResponsable'] == $idResponsable)
			                <li>
			                    <a style="cursor: pointer;" onclick="modificarPost({{$posteo['idPosteo']}}, {{$posteo['idPosteo']}});" class="text-primary">Editar</a>
			                </li>
			                <li>
			                    <a style="cursor: pointer;" onclick="borrarPost({{$posteo['idPosteo']}}, 0);" class="text-danger">Borrar</a>
			                </li>
			            @endif
		            </ul>
		        </li>
		        
		        <div id="resultadoTodosReposts_{{$posteo['idPosteo']}}">
			        @if(count($rePosts) > 0)
			        	@foreach($rePosts as $rePost)
			        		@php
			        			$archivosRePosts = DB::table('juriarchivos')
					            	->where('juriposteos_idPosteo', '=', $rePost->idPosteo)
					                ->get();
			        		@endphp
					        <li class="message message-reply">
					        	@php
					        		$imgRePost = '../public/juriArch/entidad/usuarios/'.$rePost->documentoUsuario.'.jpg';

									if(file_exists($imgRePost)) 
									{
									    $imgRePost = asset('juriArch/entidad/usuarios/'.$rePost->documentoUsuario.'.jpg');
									}
									else
									{
									    $imgRePost = asset('img/avatar-profile.png');
									}
					        	@endphp
						            <img src="{{$imgRePost}}" width="35" height="35" class="online" alt="">
						            <div id="resultadoModificarPost_{{$rePost->idPosteo}}">
						            	<span class="message-text "> <a href="#" class="username">{{$rePost->nombresUsuario}}</a> {{$rePost->post}} <i class="txt-color-orange"></i> </span>
						           	</div>
					            <ul class="list-inline font-xs">
					                <li>
					                    <a href="#" class="text-muted">{{ucfirst(utf8_encode(strftime("%A %d de %B de %Y", strtotime($rePost->fechaPosteo))))}} - {{ date('h:i A', strtotime($rePost->fechaPosteo))}} </a>
					                </li>
					                <!--ARCHIVOS DE LOS POSTS HIJOS -->
	        						@if(count($archivosRePosts) > 0)
						                @foreach($archivosRePosts as $archivoRePost)
						                	<li>
					                			<a href="{{ asset('home/descargarArchivoPost/'.$archivoRePost->idArchivo ) }}" tittle="Descargar archivo" class="btn btn-link profile-link-btn"><i class="fa fa-file"></i></a>
					                		</li>
						                @endforeach
									@endif  
					                @if($rePost->idResponsable == $idResponsable)
						                <li>
						                    <a style="cursor: pointer;" onclick="modificarPost({{$rePost->idPosteo}}, {{$posteo['idPosteo']}});" class="text-primary">Editar</a>
						                </li>
						                <li>
						                    <a style="cursor: pointer;" class="text-danger" onclick="borrarPost({{$rePost->idPosteo}}, {{$rePost->juriposteos_idPosteo}});">Borrar</a>
						                </li>
						            @endif
					            </ul>
					        </li>
					    @endforeach
				    @endif
				</div>
				<div id="divInputPost_{{$posteo['idPosteo']}}" style="padding:0px 22px">
			    	<input id="rePost_{{$posteo['idPosteo']}}" onkeyup="guardarRepost(event, {{$posteo['idPosteo']}})"  class="form-control input-xs botonArchivoRePost" placeholder="Escribe y presiona enter" type="text">

			    	<a style="cursor: pointer;" onclick="subirArchivoPost({{$posteo['idPosteo']}});" class="btn btn-link profile-link-btn" rel="tooltip" data-placement="bottom" title="Agregar un archivo"><i class="fa fa-paperclip"></i></a>
			    </div>

		        <div class="row">
                	<div id="divAddFileRePost_{{$posteo['idPosteo']}}">
                		<!--AJAX PARA CARGAR ARCHIVO DE UN COMENTARIO -->
                	</div>
                </div>
		    </ul>
		</div>
	@endforeach
	<div class="resultadoPostInfinito">
		<!--AJAX DEL MURO INFINITO -->
	</div>
@else
    <p class="alert alert-info">
        <i class="fa fa-warning fa-fw fa-2x"></i><strong>Atención!</strong> 
        No se encontraron posts.
    </p>
@endif

@php
	if(count($posteos) > 0)
	{
		$minpost = min($idUltimoPost);
	}
@endphp

@if(count($posteos) > 0)
	<input type="hidden" value="{{$minpost}}" id="ultimoPost"/>
@endif