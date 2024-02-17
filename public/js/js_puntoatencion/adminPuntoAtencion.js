var base_url = $('meta[name="base_url"]').attr('content'); 
var id_usuario = $('meta[name="id_usuario"]').attr('content'); 

function puntosAtencion()
{
  var ruta = base_url +'/'+ 'puntoatencion/puntosAtencion';

  $.ajax({                
    url:   ruta,
    type:  'post',
    beforeSend: function(){      
      cargaLoader('Consultando los puntos de atención.  Un momento por favor..');
    },
    success:  function (responseText) {
      ocultaLoader();
      $("#resultadoPuntosAtencion").html(responseText);
      $('.tabla-fresh').bootstrapTable();
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

function agregarPuntoAtencion()
{
  $('#modalAgregarPuntoAtencion').modal('show');

  var ruta = base_url +'/'+ 'puntoatencion/agregarPuntoAtencion';

  $.ajax({
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoAgregarPuntoAtencion").html(responseText);
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

function validarGuardarPunto()
{
  var nombrePunto = $("#nombrePunto").val();
  var direccionPunto = $("#direccionPunto").val();

  if(nombrePunto == "")
  {
    swal({
      title: "Campo sin diligenciar!",
      text: "Debe ingresar el nombre del punto",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  if(direccionPunto == "")
  {
    swal({
      title: "Campo sin diligenciar!",
      text: "Debe ingresar la dirección del punto",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  var ruta = base_url +'/'+ 'puntoatencion/validarGuardarPunto';

  var parametros = {
    "nombrePunto" : nombrePunto,
    "direccionPunto" : direccionPunto
  };

  $.ajax({
    data:  parametros,
    url:   ruta,
    type:  'post',
    beforeSend: function(){
      $('.btn-guardar-punto').html('<span class="fa fa-spinner fa-spin"></span> Procesando...');
      $('.btn-guardar-punto').css({ 'pointer-events': 'none' });
    },
    success:  function (responseText) {
      $('#modalAgregarPuntoAtencion').modal('hide');
      puntosAtencion();
      swal("Guardado!", "El punto de atención se guardó correctamente.", "success");
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

function editarPunto(idPunto)
{
  $('#modalEditarPuntoAtencion').modal('show');

  var ruta = base_url +'/'+ 'puntoatencion/editarPunto';

  var parametros = {
    "idPunto" : idPunto
  };

  $.ajax({
    data:  parametros,
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoEditarPuntoAtencion").html(responseText);
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

function validarEditarPunto(idPunto)
{
  var nombrePuntoEditar = $("#nombrePuntoEditar").val();
  var direccionPuntoEditar = $("#direccionPuntoEditar").val();

  if(nombrePuntoEditar == "")
  {
    swal({
      title: "Campo sin diligenciar!",
      text: "Debe ingresar el nombre del punto",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  if(direccionPuntoEditar == "")
  {
    swal({
      title: "Campo sin diligenciar!",
      text: "Debe ingresar la dirección del punto",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  var ruta = base_url +'/'+ 'puntoatencion/validarEditarPunto';

  var parametros = {
    "idPunto": idPunto,
    "nombrePuntoEditar" : nombrePuntoEditar,
    "direccionPuntoEditar" : direccionPuntoEditar
  };

  $.ajax({
    data:  parametros,
    url:   ruta,
    type:  'post',
    beforeSend: function(){
      $('.btn-editar-punto').html('<span class="fa fa-spinner fa-spin"></span> Procesando...');
      $('.btn-editar-punto').css({ 'pointer-events': 'none' });
    },
    success:  function (responseText) {
      $('#modalEditarPuntoAtencion').modal('hide');
      puntosAtencion();
      swal("Guardado!", "El punto de atención se modificó correctamente.", "success");
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

function validarEliminarResponsablePunto(idResponsablePunto)
{
  var ruta = base_url +'/'+ 'puntoatencion/validarEliminarResponsablePunto';

  var parametros = {  
    "idResponsablePunto" : idResponsablePunto
  };
  
  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      swal("Eliminado!", "El responsable ha sido removido correctamente.", "success"); 
      puntosAtencion();
      $('#modalResponsablesPuntoAtencion').modal('hide');
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

function eliminarPunto(idPunto)
{
  swal({
    title: "Está seguro de eliminar el punto de atención?",
    text: "Se eliminará el punto de atención!",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#f8b32d",
    confirmButtonText: "Sí, eliminar!",
    closeOnConfirm: false
  }, function(){
    validarEliminarPunto(idPunto);
  });
}

function validarEliminarPunto(idPunto)
{
  var ruta = base_url +'/'+ 'puntoatencion/validarEliminarPunto';

  var parametros = {  
    "idPunto" : idPunto
  };
  
  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      if(responseText == 0)
      {
        swal("Eliminado!", "El punto de atención ha sido eliminado correctamente.", "success"); 
        puntosAtencion();
      }
      else
      {
        swal({   
          title: "Atención!",   
          text: "El punto de atención todavía tiene responsables vinculados",   
          confirmButtonColor: "#f33923",   
        });
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