var base_url = $('meta[name="base_url"]').attr('content'); 
var id_usuario = $('meta[name="id_usuario"]').attr('content'); 


function tablaPerfiles()
{
  var ruta = base_url +'/'+ 'perfiles/tablaPerfiles';

  $.ajax({                
    url:   ruta,
    type:  'post',
    beforeSend: function(){      
      cargaLoader('Consultando los perfiles.  Un momento por favor..');
    },
    success:  function (responseText) {
      ocultaLoader();
      $("#resultadoTablaPerfiles").html(responseText);
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

function agregarPerfil()
{
  $('#modalAgregarPerfil').modal('show');

  var ruta = base_url +'/'+ 'perfiles/agregarPerfil';
  
  $.ajax({                
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoAgregarPerfil").html(responseText);
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

function validarGuardarPerfil()
{
  var nombrePerfil = $("#nombrePerfil").val();

  if(nombrePerfil == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe ingresar el nombre del perfil",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  var ruta = base_url +'/'+ 'perfiles/validarGuardarPerfil';

  var parametros = {  
    "nombrePerfil" : nombrePerfil
  };
  
  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',
    beforeSend: function(){    
      cargaLoader('Guardando el perfil.  Un momento por favor..');    
      $('.btn-guardar-perfil').html('<span class="fa fa-spinner fa-spin"></span> Procesando...');
      $('.btn-guardar-perfil').css({ 'pointer-events': 'none' });
    },
    success:  function (responseText) {
      ocultaLoader();
      $('#modalAgregarPerfil').modal('hide');
      tablaPerfiles();
      swal("Guardado!", "El perfil ha sido guardado exitosamente.", "success"); 
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

function editarPerfil(idPerfil)
{
  $('#modalEditarPerfil').modal('show');

  var ruta = base_url +'/'+ 'perfiles/editarPerfil';

  var parametros = {  
    "idPerfil" : idPerfil
  };

  $.ajax({                
    data:  parametros,          
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoEditarPerfil").html(responseText);
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

function validarEditarPerfil(idPerfil)
{
  var nombrePerfilEditar = $("#nombrePerfilEditar").val();

  if(nombrePerfilEditar == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe ingresar el nombre del perfil",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  var ruta = base_url +'/'+ 'perfiles/validarEditarPerfil';

  var parametros = {  
    "idPerfil" : idPerfil,
    "nombrePerfilEditar" : nombrePerfilEditar
  };

  $.ajax({                
    data:  parametros,          
    url:   ruta,
    type:  'post',
    beforeSend: function(){    
      cargaLoader('Modificando el perfil.  Un momento por favor..');     
      $('.btn-editar-perfil').html('<span class="fa fa-spinner fa-spin"></span> Procesando...');
      $('.btn-editar-perfil').css({ 'pointer-events': 'none' });
    },
    success:  function (responseText) {
      ocultaLoader();
      $('#modalEditarPerfil').modal('hide');
      swal("Modificado!", "El perfil ha sido modificado.", "success"); 
      tablaPerfiles();
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

function eliminarPerfil(idPerfil)
{
  swal({   
    title: "Está seguro de eliminar el perfil?",   
    text: "Se eliminará el perfil de la base de datos!",   
    type: "warning",   
    showCancelButton: true,   
    confirmButtonColor: "#f8b32d",   
    confirmButtonText: "Sí, eliminarlo!",   
    closeOnConfirm: false 
  }, function(){   
    validarEliminarPerfil(idPerfil);
  });
}

function validarEliminarPerfil(idPerfil)
{
  var ruta = base_url +'/'+ 'perfiles/validarEliminarPerfil';

  var parametros = {  
    "idPerfil" : idPerfil
  };

  $.ajax({                
    data:  parametros,          
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      if(responseText == 1)
      {
        swal("Eliminado!", "El perfil ha sido eliminado.", "success"); 
        tablaPerfiles();
      }
      else
      {
        swal({   
          title: "No se puede eliminar el perfil!",   
          text: "El perfil esta siendo utilizado por al menos un usuario",   
          confirmButtonColor: "#f33923",   
        });
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