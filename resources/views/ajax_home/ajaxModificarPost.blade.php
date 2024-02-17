<div class="row">
	<div class="col-sm-1">
	</div>
	<div class="col-sm-10">
		<input id="postModificar_{{$idPost}}" type="text" value="{{$post[0]->post}}" class="form-control input-xs pull-left" onkeyup="editarPost(event, {{$idPost}}, {{$post[0]->juriposteos_idPosteo}})">
		<a style="cursor: pointer;" onclick="cancelarModificarPost({{$post[0]->juriposteos_idPosteo}});">No Editar</a>
	</div>
</div>