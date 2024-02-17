var base_url = $('meta[name="base_url"]').attr('content'); 
var id_usuario = $('meta[name="id_usuario"]').attr('content'); 


function tablaAccionDefensa()
{
  var ruta = base_url +'/'+ 'accionesDefensa/tablaAccionDefensa';

  $.ajax({                
    url:   ruta,
    type:  'post',
    beforeSend: function(){      
      cargaLoader('Consultando las acciones de defensa.  Un momento por favor..');
    },
    success:  function (responseText) {
      ocultaLoader();
      $("#resultadoTablaAccionDefensa").html(responseText);
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

function agregarAccionDefensa()
{
	$('#modalAgregarAccionDefensa').modal('show');

  var ruta = base_url +'/'+ 'accionesDefensa/agregarAccionDefensa';

	$.ajax({                
  	url:   ruta,
  	type:  'post',
  	success:  function (responseText) {
    	$("#resultadoAgregarAccionDefensa").html(responseText);
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

function validarGuardarAccionDefensa()
{
  var nombreAccionDefensa = $("#nombreAccionDefensa").val();

  if(nombreAccionDefensa == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe el nombre de la acción de defensa",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  var ruta = base_url +'/'+ 'accionesDefensa/validarGuardarAccionDefensa';

  var parametros = {  
    "nombreAccionDefensa" : nombreAccionDefensa
  };
  
  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',
    beforeSend: function(){    
      cargaLoader('Guardando acción de defensa.  Un momento por favor..');          
      $('.btn-guardar-accionDefensa').html('<span class="fa fa-spinner fa-spin"></span> Procesando...');
      $('.btn-guardar-accionDefensa').css({ 'pointer-events': 'none' });
    },
    success:  function (responseText) {
      ocultaLoader();
      $('#modalAgregarAccionDefensa').modal('hide');
      tablaAccionDefensa();
      swal("Guardado!", "La acción de defensa ha sido guardada exitosamente.", "success"); 
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

function editarAccionDefensa(idAccionDefensa)
{
  $('#modalEditarAccionDefensa').modal('show');

  var ruta = base_url +'/'+ 'accionesDefensa/editarAccionDefensa';

  var parametros = {  
    "idAccionDefensa" : idAccionDefensa
  };

  $.ajax({                
    data:  parametros,          
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoEditarAccionDefensa").html(responseText);
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

function validarEditarAccionDefensa(idAccionDefensa)
{
  var nombreAccionDefensaEditar = $("#nombreAccionDefensaEditar").val();

  if(nombreAccionDefensaEditar == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe ingresar el nombre de la acción de defensa",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }
  var ruta = base_url +'/'+ 'accionesDefensa/validarEditarAccionDefensa';

  var parametros = {  
    "idAccionDefensa": idAccionDefensa,
    "nombreAccionDefensaEditar" : nombreAccionDefensaEditar
  };
  
  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',
    beforeSend: function(){     
      cargaLoader('Modificando acción de defensa.  Un momento por favor..');   
      $('.btn-editar-accionDefensa').html('<span class="fa fa-spinner fa-spin"></span> Procesando...');
      $('.btn-editar-accionDefensa').css({ 'pointer-events': 'none' });
    },
    success:  function (responseText) {
      ocultaLoader();
      $('#modalEditarAccionDefensa').modal('hide');
      tablaAccionDefensa();
      swal("Modificado!", "La acción de defensa ha sido modificada exitosamente.", "success"); 
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

function eliminarAccionDefensa(idAccionDefensa)
{
  swal({   
    title: "Está seguro de eliminar la acción de defensa?",   
    text: "Se eliminará la acción de defensa de la base de datos!",   
    type: "warning",   
    showCancelButton: true,   
    confirmButtonColor: "#f8b32d",   
    confirmButtonText: "Sí, eliminarlo!",   
    closeOnConfirm: false 
  }, function(){   
    validarEliminarAccionDefensa(idAccionDefensa);
  });
}

function validarEliminarAccionDefensa(idAccionDefensa)
{
  var ruta = base_url +'/'+ 'accionesDefensa/validarEliminarAccionDefensa';

  var parametros = {  
    "idAccionDefensa" : idAccionDefensa
  };

  $.ajax({                
    data:  parametros,          
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      if(responseText == 1)
      {
        swal("Eliminado!", "La acción de defensa ha sido eliminada.", "success"); 
        tablaAccionDefensa();
      }
      else
      {
        swal({   
          title: "No se puede eliminar la acción de defensa!",   
          text: "La acción de defensa esta siendo utilizada en al menos un proceso",   
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