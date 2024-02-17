var base_url = $('meta[name="base_url"]').attr('content'); 
var id_usuario = $('meta[name="id_usuario"]').attr('content'); 


function tablaTiposActos()
{
  var ruta = base_url +'/'+ 'tiposActosAdmin/tablaTiposActos';

  $.ajax({                
    url:   ruta,
    type:  'post',
    beforeSend: function(){      
      cargaLoader('Consultando los tipos de actos administrativos.  Un momento por favor..');
    },
    success:  function (responseText) {
      ocultaLoader();
      $("#resultadoTablaTipoActo").html(responseText);
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

function agregarTipoActoAdministrativo()
{
  $('#modalAgregarTipoActo').modal('show');

  var ruta = base_url +'/'+ 'tiposActosAdmin/agregarTipoActoAdministrativo';

  $.ajax({                
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoAgregarTipoActo").html(responseText);
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

function validarGuardarTipoActo()
{
  var nombreTipoActo = $("#nombreTipoActo").val();

  if(nombreTipoActo == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe ingresar el nombre del tipo del acto administrativo",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  var ruta = base_url +'/'+ 'tiposActosAdmin/validarGuardarTipoActo';

  var parametros = {  
    "nombreTipoActo" : nombreTipoActo
  };
  
  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',
    beforeSend: function(){  
      cargaLoader('Guardando el tipo de acto administrativo.  Un momento por favor..');      
      $('.btn-guardar-tipoacto').html('<span class="fa fa-spinner fa-spin"></span> Procesando...');
      $('.btn-guardar-tipoacto').css({ 'pointer-events': 'none' });
    },
    success:  function (responseText) {
      $('#modalAgregarTipoActo').modal('hide');
      tablaTiposActos();
      swal("Guardado!", "El tipo de acto ha sido guardado exitosamente.", "success"); 
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

function editarTipoActo(idTipoActo)
{
  $('#modalEditarTipoActo').modal('show');

  var ruta = base_url +'/'+ 'tiposActosAdmin/editarTipoActo';

  var parametros = {  
    "idTipoActo" : idTipoActo
  };

  $.ajax({                
    data:  parametros,          
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoEditarTipoActo").html(responseText);
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

function validarEditarTipoActo(idTipoActo)
{
  var nombreTipoActoEditar = $("#nombreTipoActoEditar").val();

  if(nombreTipoActoEditar == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe ingresar el nombre de la dependencia",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  var ruta = base_url +'/'+ 'tiposActosAdmin/validarEditarTipoActo';

  var parametros = {  
    "idTipoActo": idTipoActo,
    "nombreTipoActoEditar" : nombreTipoActoEditar
  };
  
  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',
    beforeSend: function(){   
      cargaLoader('Modificando el tipo de acto administrativo.  Un momento por favor..');      
      $('.btn-editar-tipoacto').html('<span class="fa fa-spinner fa-spin"></span> Procesando...');
      $('.btn-editar-tipoacto').css({ 'pointer-events': 'none' });
    },
    success:  function (responseText) {
      ocultaLoader();
      $('#modalEditarTipoActo').modal('hide');
      tablaTiposActos();
      swal("Modificada!", "El tipo de acto administrativo ha sido modificada exitosamente.", "success"); 
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

function eliminarTipoActo(idTipoActo)
{
  swal({   
    title: "Está seguro de eliminar el tipo de acto administrativo?",   
    text: "Se eliminará el tipo de acto de la base de datos!",   
    type: "warning",   
    showCancelButton: true,   
    confirmButtonColor: "#f8b32d",   
    confirmButtonText: "Sí, eliminarlo!",   
    closeOnConfirm: false 
  }, function(){   
    validarEliminarTipoActo(idTipoActo);
  });
}

function validarEliminarTipoActo(idTipoActo)
{
  var ruta = base_url +'/'+ 'tiposActosAdmin/validarEliminarTipoActo';

  var parametros = {  
    "idTipoActo" : idTipoActo
  };

  $.ajax({                
    data:  parametros,          
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      if(responseText == 1)
      {
        swal("Eliminado!", "El tipo de acto ha sido eliminado.", "success"); 
        tablaTiposActos();
      }
      else
      {
        swal({   
          title: "No se puede eliminar el tipo de acto!",   
          text: "El tipo de acto es utilizado al menos por un proceso",   
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