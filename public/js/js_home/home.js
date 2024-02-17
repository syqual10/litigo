var base_url = $('meta[name="base_url"]').attr('content'); 
var id_usuario = $('meta[name="id_usuario"]').attr('content'); 

function editarFoto()
{
  $('#modalEditarFoto').modal('show');
  
  var ruta = base_url +'/'+ 'home/editarFoto';

  var loader = '<img src="'+base_url+'/img/loader.gif">';

  $.ajax({
    url:   ruta,
    type:  'post',
    beforeSend: function(){      
      $('#resultadoEditarFoto').html('<p style="width:100%; text-align:center;">'+loader+'</p>');
    },
    success:  function (responseText) {
      $("#resultadoEditarFoto").html(responseText);
      $('#dropzoneFoto').dropzone({addRemoveLinks: true, maxFiles: 1});
      //$('#dropzoneFoto').dropzone({init: function() {this.on("success", function() { tablaRemoverArchivos(); });}});
    },
    error: function (responseText) {
      switch (responseText.status) 
      {
        case 500: 
          console.error('Error '+responseText.status+' '+responseText); 
        break;
        case 401:
          swal({   
            title: "Su sesión se ha desconectado",   
            text: "Por favor loguearse nuevamente!",   
            type: "warning",   
            confirmButtonColor: "#f8b32d",   
            confirmButtonText: "Entendido!"
          }, function(){   
            var rutaRedirect = base_url +'/'+ 'login';
            window.location.href = rutaRedirect;  
          });
        break;
      }
      console.log(responseText);
      return;
    }
  });
}

function validarGuardarPosteo()
{
  var posteo = $("#posteo").val();

  if(posteo == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe ingresar el texto para publicar",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  var ruta = base_url +'/'+ 'home/validarGuardarPosteo';

  var parametros = {  
    "posteo" : posteo
  };
  
  $.ajax({                
    data:  parametros,                   
    url:   ruta,
    type:  'post',
    beforeSend: function(){      
      $('.btn-guardar-post').html('<span class="fa fa-spinner fa-spin"></span> Procesando...');
      $('.btn-guardar-post').css({ 'pointer-events': 'none' });
    },
    success:  function (responseText) {         
      socket.emit("server_nuevoPost", {idResponsable: responseText.idResponsable, nombresUsuario: responseText.nombresUsuario});
      posteos();
    },
    error: function (responseText) {
      switch (responseText.status) 
      {
        case 500: 
          console.error('Error '+responseText.status+' '+responseText); 
        break;
        case 401:
          swal({   
            title: "Su sesión se ha desconectado",   
            text: "Por favor loguearse nuevamente!",   
            type: "warning",   
            confirmButtonColor: "#f8b32d",   
            confirmButtonText: "Entendido!"
          }, function(){   
            var rutaRedirect = base_url +'/'+ 'login';
            window.location.href = rutaRedirect;  
          });
        break;
      }
      console.log(responseText);
      return;
    }
  });
}

function posteos()
{
  masPosts = true;// inicializa la función para el scroll infinito

  var ruta = base_url +'/'+ 'home/posteos';

  $.ajax({                
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoPosteo").html(responseText).hide().fadeIn(800).delay(3000);
    },
    error: function (responseText) {
      switch (responseText.status) 
      {
        case 500: 
          console.error('Error '+responseText.status+' '+responseText); 
        break;
        case 401:
          swal({   
            title: "Su sesión se ha desconectado",   
            text: "Por favor loguearse nuevamente!",   
            type: "warning",   
            confirmButtonColor: "#f8b32d",   
            confirmButtonText: "Entendido!"
          }, function(){   
            var rutaRedirect = base_url +'/'+ 'login';
            window.location.href = rutaRedirect;  
          });
        break;
      }
      console.log(responseText);
      return;
    }
  });
}

function guardarRepost(e, idPost)
{
  var enterKey = 13;
  var charCode = (typeof e.which === enterKey) ? e.which : e.keyCode;

  if (charCode == enterKey)
  {
    validarGuardarRepost(idPost);
  }
}

function validarGuardarRepost(idPost)
{
  var rePost = $("#rePost_"+idPost).val();

  if(rePost == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe ingresar el texto para publicar",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  var ruta = base_url +'/'+ 'home/validarGuardarRepost';

  var parametros = {  
    "idPost": idPost,
    "rePost" : rePost
  };
  
  $.ajax({                
    data:  parametros,                   
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      //Llamado al evento ingresaUsuario, el cuál creará un nuevo socket asociado al usuario
      socket.emit("server_nuevoPost", {idResponsable: responseText.idResponsable, nombresUsuario: responseText.nombresUsuario});
      posteos();
    },
    error: function (responseText) {
      switch (responseText.status) 
      {
        case 500: 
          console.error('Error '+responseText.status+' '+responseText); 
        break;
        case 401:
          swal({   
            title: "Su sesión se ha desconectado",   
            text: "Por favor loguearse nuevamente!",   
            type: "warning",   
            confirmButtonColor: "#f8b32d",   
            confirmButtonText: "Entendido!"
          }, function(){   
            var rutaRedirect = base_url +'/'+ 'login';
            window.location.href = rutaRedirect;  
          });
        break;
      }
      console.log(responseText);
      return;
    }
  });
}

function mostrarTodosRepost(idPost)
{
  var ruta = base_url +'/'+ 'home/mostrarTodosRepost';

  var parametros = {  
    "idPost": idPost
  };
  
  $.ajax({                
    data:  parametros,                   
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoTodosReposts_"+idPost).html(responseText);
    },
    error: function (responseText) {
      switch (responseText.status) 
      {
        case 500: 
          console.error('Error '+responseText.status+' '+responseText); 
        break;
        case 401:
          swal({   
            title: "Su sesión se ha desconectado",   
            text: "Por favor loguearse nuevamente!",   
            type: "warning",   
            confirmButtonColor: "#f8b32d",   
            confirmButtonText: "Entendido!"
          }, function(){   
            var rutaRedirect = base_url +'/'+ 'login';
            window.location.href = rutaRedirect;  
          });
        break;
      }
      console.log(responseText);
      return;
    }
  });
}

function modificarPost(idPost, idPostPadre)
{
  $("#divInputPost_"+idPostPadre).css("display", "none");// esconde input para responder, ya que esta modificando comentario

  var ruta = base_url +'/'+ 'home/modificarPost';

  var parametros = {  
    "idPost": idPost
  };
  
  $.ajax({                
    data:  parametros,                   
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoModificarPost_"+idPost).html(responseText);
    },
    error: function (responseText) {
      switch (responseText.status) 
      {
        case 500: 
          console.error('Error '+responseText.status+' '+responseText); 
        break;
        case 401:
          swal({   
            title: "Su sesión se ha desconectado",   
            text: "Por favor loguearse nuevamente!",   
            type: "warning",   
            confirmButtonColor: "#f8b32d",   
            confirmButtonText: "Entendido!"
          }, function(){   
            var rutaRedirect = base_url +'/'+ 'login';
            window.location.href = rutaRedirect;  
          });
        break;
      }
      console.log(responseText);
      return;
    }
  });
}

function editarPost(e, idPost, idPostPadre)
{
  var enterKey = 13;
  var charCode = (typeof e.which === enterKey) ? e.which : e.keyCode;

  if (charCode == enterKey)
  {
    validarEditarPost(idPost, idPostPadre);
  }
}

function validarEditarPost(idPost, idPostPadre)
{
  var postModificar = $("#postModificar_"+idPost).val();

  if(postModificar == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe ingresar el texto para modificar post",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  var ruta = base_url +'/'+ 'home/validarEditarPost';

  var parametros = {  
    "idPost": idPost,
    "postModificar" : postModificar
  };
  
  $.ajax({                
    data:  parametros,                   
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      if(idPostPadre === undefined)// cuando es el padre, y se va editar
      {
        posteos();
      }
      else
      {
        mostrarTodosRepost(idPostPadre);
        $("#divInputPost_"+idPostPadre).css("display", "block");// muestra input para responder, ya que se cancela
        //el modificar del comentario
      }
    },
    error: function (responseText) {
      switch (responseText.status) 
      {
        case 500: 
          console.error('Error '+responseText.status+' '+responseText); 
        break;
        case 401:
          swal({   
            title: "Su sesión se ha desconectado",   
            text: "Por favor loguearse nuevamente!",   
            type: "warning",   
            confirmButtonColor: "#f8b32d",   
            confirmButtonText: "Entendido!"
          }, function(){   
            var rutaRedirect = base_url +'/'+ 'login';
            window.location.href = rutaRedirect;  
          });
        break;
      }
      console.log(responseText);
      return;
    }
  });
}

function borrarPost(idPost, idPostPadre)
{
  swal({   
    title: "Está seguro de eliminar el post?",   
    text: "Se eliminará de la base de datos!",   
    type: "warning",   
    showCancelButton: true,   
    confirmButtonColor: "#f8b32d",   
    confirmButtonText: "Sí, eliminarlo!",   
    closeOnConfirm: false 
  }, function(){   
    validarEliminarPost(idPost, idPostPadre);
  });
}

function validarEliminarPost(idPost, idPostPadre)
{
  var ruta = base_url +'/'+ 'home/validarEliminarPost';

  var parametros = {  
    "idPost": idPost
  };
  
  $.ajax({                
    data:  parametros,                   
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      if(responseText.respuesta == 0)// elimina todo el post
      {
        posteos();
        swal("Eliminado!", "El post ha sido eliminado exitosamente.", "success"); 
      }
      else
      {
        $("#mostrarTodosComentarios_"+idPostPadre).text("Mostrar todos los comentarios ("+responseText.cantidadRepost+")");
        mostrarTodosRepost(idPostPadre);
        swal("Eliminado!", "El comentario ha sido eliminado exitosamente.", "success"); 
      }
    },
    error: function (responseText) {
      switch (responseText.status) 
      {
        case 500: 
          console.error('Error '+responseText.status+' '+responseText); 
        break;
        case 401:
          swal({   
            title: "Su sesión se ha desconectado",   
            text: "Por favor loguearse nuevamente!",   
            type: "warning",   
            confirmButtonColor: "#f8b32d",   
            confirmButtonText: "Entendido!"
          }, function(){   
            var rutaRedirect = base_url +'/'+ 'login';
            window.location.href = rutaRedirect;  
          });
        break;
      }
      console.log(responseText);
      return;
    }
  });
}

function cancelarModificarPost(idPostPadre)
{
  if(idPostPadre === undefined)// cuando es el padre, y se va cancelar el editar editar
  {
    posteos();
  }
  else
  {
    mostrarTodosRepost(idPostPadre);
    $("#divInputPost_"+idPostPadre).css("display", "block");// muestra input para responder, ya que se cancela
    //el modificar del comentario
  }
}

function subirArchivoPost(rePost)
{
  var rutaArchivo = base_url +'/'+ 'home/uploadArchivoPost';
  var ruta = base_url +'/'+ 'home/subirArchivoPost';
  
  $.ajax({
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      if(rePost == 0)// si es un nuevo post
      {
        $("#divAddFilePost").html(responseText);
      }
      else// si es el comentario de un post
      {
        $("#divAddFileRePost_"+rePost).html(responseText); 
      }
      
      Dropzone.autoDiscover = false;
      var myDropzonePost = new Dropzone("#dropzonePost", 
      { 
        autoProcessQueue: false,
        url: rutaArchivo,
        addRemoveLinks: true,
        maxFiles: 1,
        init: function () {
          var myDropzone = this;
          // Update selector to match your button
          $("#botonArchivoPost").click(function (e) {
            e.preventDefault();
            myDropzone.processQueue();
          });


          $(".botonArchivoRePost").click().keyup(function(e)
          {
            if (e.keyCode == '13')
            {
              e.preventDefault();
              myDropzone.processQueue();
            }
          });

          this.on('sending', function(file, xhr, formData) 
          {
            // Append all form inputs to the formData Dropzone will POST
            var data = $('#dropzonePost').serializeArray();
          });
        }
      });
    },
    error: function (responseText) {
      switch (responseText.status) 
      {
        case 500: 
          console.error('Error '+responseText.status+' '+responseText); 
        break;
        case 401:
          swal({   
            title: "Su sesión se ha desconectado",   
            text: "Por favor loguearse nuevamente!",   
            type: "warning",   
            confirmButtonColor: "#f8b32d",   
            confirmButtonText: "Entendido!"
          }, function(){   
            var rutaRedirect = base_url +'/'+ 'login';
            window.location.href = rutaRedirect;  
          });
        break;
      }
      console.log(responseText);
      return;
    }
  });
}

$(window).scroll(function () 
{ 
  if ($(window).scrollTop() + $(window).height() == $(document).height()) 
  {
    loadMorePost();
  }
})

var loadMorePost = function () 
{ 
  var ultimoPost = $("#ultimoPost").val();

  var ruta = base_url +'/'+ 'home/loadMorePost';

  var parametros = {  
    "ultimoPost": ultimoPost
  };
  
  $.ajax({                
    data:  parametros,                   
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      if(responseText != 0)
      {
        $(".resultadoPostInfinito").append(responseText.vistaPostInfinito);
        $("#ultimoPost").val(responseText.ultimoPost)
      }
      else
      {
        console.log("Fin de los posts");
        return false;
      }
    },
    error: function (responseText) {
      switch (responseText.status) 
      {
        case 500: 
          console.error('Error '+responseText.status+' '+responseText); 
        break;
        case 401:
          swal({   
            title: "Su sesión se ha desconectado",   
            text: "Por favor loguearse nuevamente!",   
            type: "warning",   
            confirmButtonColor: "#f8b32d",   
            confirmButtonText: "Entendido!"
          }, function(){   
            var rutaRedirect = base_url +'/'+ 'login';
            window.location.href = rutaRedirect;  
          });
        break;
      }
      console.log(responseText);
      return;
    }
  });
}

function tareasPendientes()
{
  var ruta = base_url +'/'+ 'home/tareasPendientes';

  $.ajax({                
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoTareasPendientes").html(responseText);
    },
    error: function (responseText) {
      switch (responseText.status) 
      {
        case 500: 
          console.error('Error '+responseText.status+' '+responseText); 
        break;
        case 401:
          swal({   
            title: "Su sesión se ha desconectado",   
            text: "Por favor loguearse nuevamente!",   
            type: "warning",   
            confirmButtonColor: "#f8b32d",   
            confirmButtonText: "Entendido!"
          }, function(){   
            var rutaRedirect = base_url +'/'+ 'login';
            window.location.href = rutaRedirect;  
          });
        break;
      }
      console.log(responseText);
      return;
    }
  });
}

function estadoAgendaTarea(idAgenda, accion)
{
  // accion 1 es marcar-finalizar
  // accion 0 es desmarcar

  var ruta = base_url +'/'+ 'home/estadoAgendaTarea';

  var parametros = {  
    "idAgenda": idAgenda,
    "accion": accion
  };
  
  $.ajax({                
    data:  parametros,                   
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      tareasPendientes();
      tareasInformativas(1);
    },
    error: function (responseText) {
      switch (responseText.status) 
      {
        case 500: 
          console.error('Error '+responseText.status+' '+responseText); 
        break;
        case 401:
          swal({   
            title: "Su sesión se ha desconectado",   
            text: "Por favor loguearse nuevamente!",   
            type: "warning",   
            confirmButtonColor: "#f8b32d",   
            confirmButtonText: "Entendido!"
          }, function(){   
            var rutaRedirect = base_url +'/'+ 'login';
            window.location.href = rutaRedirect;  
          });
        break;
      }
      console.log(responseText);
      return;
    }
  });
}