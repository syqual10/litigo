var base_url = $('meta[name="base_url"]').attr('content'); 
var id_usuario = $('meta[name="id_usuario"]').attr('content'); 


function tablaTipoBitacora()
{
  var ruta = base_url +'/'+ 'tipoBitacoras/tablaTipoBitacora';

  $.ajax({                
    url:   ruta,
    type:  'post',
    beforeSend: function(){      
      cargaLoader('Consultando los tipos de bitácora.  Un momento por favor..');
    },
    success:  function (responseText) {
      ocultaLoader();
      $("#resultadoTablaTipoBitacora").html(responseText);
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

function agregarTipoBitacora()
{
  $('#modalAgregarTipoBitacora').modal('show');

  var ruta = base_url +'/'+ 'tipoBitacoras/agregarTipoBitacora';

  $.ajax({                
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoAgregarTipoBitacora").html(responseText);
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

function validarGuardarTipoBitacora()
{
  var nombreTipoBitacora = $("#nombreTipoBitacora").val();

  if(nombreTipoBitacora == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe ingresar el tipo de bitácora",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  var ruta = base_url +'/'+ 'tipoBitacoras/validarGuardarTipoBitacora';

  var parametros = {  
    "nombreTipoBitacora" : nombreTipoBitacora
  };
  
  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',
    beforeSend: function(){   
      cargaLoader('Guardando el tipo de bitácora.  Un momento por favor..');     
      $('.btn-guardar-tipoBitacora').html('<span class="fa fa-spinner fa-spin"></span> Procesando...');
      $('.btn-guardar-tipoBitacora').css({ 'pointer-events': 'none' });
    },
    success:  function (responseText) {
      ocultaLoader();
      $('#modalAgregarTipoBitacora').modal('hide');
      tablaTipoBitacora();
      swal("Guardado!", "El tipo de bitácora ha sido guardado exitosamente.", "success"); 
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

function editarTipoBitacora(idTipoBitacora)
{
  $('#modalEditarTipoBitacora').modal('show');

  var ruta = base_url +'/'+ 'tipoBitacoras/editarTipoBitacora';

  var parametros = {  
    "idTipoBitacora" : idTipoBitacora
  };

  $.ajax({                
    data:  parametros,          
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoEditarTipoBitacora").html(responseText);
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

function validarEditarTipoBitacora(idTipoBitacora)
{
  var nombreTipoBitacoraEditar = $("#nombreTipoBitacoraEditar").val();

  if(nombreTipoBitacoraEditar == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe ingresar el tipo de bitácora",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  var ruta = base_url +'/'+ 'tipoBitacoras/validarEditarTipoBitacora';

  var parametros = {  
    "idTipoBitacora" : idTipoBitacora,
    "nombreTipoBitacoraEditar" : nombreTipoBitacoraEditar
  };

  $.ajax({                
    data:  parametros,          
    url:   ruta,
    type:  'post',
    beforeSend: function(){  
      cargaLoader('Modificando el tipo de bitácora.  Un momento por favor..');       
      $('.btn-editar-tipoBitacora').html('<span class="fa fa-spinner fa-spin"></span> Procesando...');
      $('.btn-editar-tipoBitacora').css({ 'pointer-events': 'none' });
    },
    success:  function (responseText) {
      ocultaLoader();
      $('#modalEditarTipoBitacora').modal('hide');
      swal("Modificado!", "El tipo de bitácora ha sido modificado.", "success"); 
      tablaTipoBitacora();
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

function eliminarTipoBitacora(idTipoBitacora)
{
  swal({   
    title: "Está seguro de eliminar el tipo de bitácora?",   
    text: "Se eliminará el tipo de bitácora de la base de datos!",   
    type: "warning",   
    showCancelButton: true,   
    confirmButtonColor: "#f8b32d",   
    confirmButtonText: "Sí, eliminarlo!",   
    closeOnConfirm: false 
  }, function(){   
    validarEliminarTipoBitacora(idTipoBitacora);
  });
}

function validarEliminarTipoBitacora(idTipoBitacora)
{
  var ruta = base_url +'/'+ 'tipoBitacoras/validarEliminarTipoBitacora';

  var parametros = {  
    "idTipoBitacora" : idTipoBitacora
  };

  $.ajax({                
    data:  parametros,          
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      if(responseText == 1)
      {
        swal("Eliminado!", "El tipo de bitácora ha sido eliminado.", "success"); 
        tablaTipoBitacora();
      }
      else
      {
        swal({   
          title: "No se puede eliminar el tipo de bitácora!",   
          text: "El tipo de bitácora es utilizado por al menos una Bitácora",   
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