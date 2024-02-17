var base_url = $('meta[name="base_url"]').attr('content'); 
var id_usuario = $('meta[name="id_usuario"]').attr('content'); 


function tablaAutoridades()
{
  var ruta = base_url +'/'+ 'autoridades/tablaAutoridades';

  $.ajax({                
    url:   ruta,
    type:  'post',
    beforeSend: function(){      
      cargaLoader('Consultando las autoridades.  Un momento por favor..');
    },
    success:  function (responseText) {
      ocultaLoader();
      $("#resultadoTablaAutoridadConocedora").html(responseText);
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

function agregarAutoridad()
{
  $('#modalAgregarAutoridadConocedora').modal('show');

  var ruta = base_url +'/'+ 'autoridades/agregarAutoridad';

  $.ajax({                
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoAgregarAutoridadConocedora").html(responseText);
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

function validarGuardarAutoridad()
{
  var nombreAutoridad = $("#nombreAutoridad").val();

  if(nombreAutoridad == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe ingresar el nombre de la autoridad",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  var ruta = base_url +'/'+ 'autoridades/validarGuardarAutoridad';

  var parametros = {  
    "nombreAutoridad" : nombreAutoridad
  };
  
  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',
    beforeSend: function(){  
      cargaLoader('Guardando la autoridad.  Un momento por favor..');      
      $('.btn-guardar-autoridad').html('<span class="fa fa-spinner fa-spin"></span> Procesando...');
      $('.btn-guardar-autoridad').css({ 'pointer-events': 'none' });
    },
    success:  function (responseText) {
      ocultaLoader();
      $('#modalAgregarAutoridadConocedora').modal('hide');
      tablaAutoridades();
      swal("Guardado!", "La autoridad ha sido guardada exitosamente.", "success"); 
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

function editarAutoridad(idAutoridad)
{
  $('#modalEditarAutoridadConocedora').modal('show');

  var ruta = base_url +'/'+ 'autoridades/editarAutoridad';

  var parametros = {  
    "idAutoridad" : idAutoridad
  };

  $.ajax({                
    data:  parametros,          
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoEditarAutoridadConocedora").html(responseText);
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

function validarModificarAutoridad(idAutoridad)
{
  var nombreAutoridadEditar = $("#nombreAutoridadEditar").val();

  if(nombreAutoridadEditar == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe ingresar el nombre de la autoridad",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  var ruta = base_url +'/'+ 'autoridades/validarModificarAutoridad';

  var parametros = {  
    "idAutoridad": idAutoridad,
    "nombreAutoridadEditar" : nombreAutoridadEditar
  };
  
  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',
    beforeSend: function(){ 
      cargaLoader('Modificando la autoridad.  Un momento por favor..');        
      $('.btn-editar-autoridad').html('<span class="fa fa-spinner fa-spin"></span> Procesando...');
      $('.btn-editar-autoridad').css({ 'pointer-events': 'none' });
    },
    success:  function (responseText) {
      ocultaLoader();
      $('#modalEditarAutoridadConocedora').modal('hide');
      tablaAutoridades();
      swal("Modificada!", "La autoridad ha sido modificada exitosamente.", "success"); 
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

function eliminarAutoridad(idAutoridad)
{
  swal({   
    title: "Está seguro de eliminar la autoridad?",   
    text: "Se eliminará la autoridad de la base de datos!",   
    type: "warning",   
    showCancelButton: true,   
    confirmButtonColor: "#f8b32d",   
    confirmButtonText: "Sí, eliminarlo!",   
    closeOnConfirm: false 
  }, function(){   
    validarEliminarAutoridad(idAutoridad);
  });
}

function validarEliminarAutoridad(idAutoridad)
{
  var ruta = base_url +'/'+ 'autoridades/validarEliminarAutoridad';

  var parametros = {  
    "idAutoridad" : idAutoridad
  };

  $.ajax({                
    data:  parametros,          
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      swal("Eliminado!", "La autoridad ha sido eliminada.", "success"); 
      tablaAutoridades();
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