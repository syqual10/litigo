var base_url = $('meta[name="base_url"]').attr('content'); 
var id_usuario = $('meta[name="id_usuario"]').attr('content'); 


function tablaEstadoRadicado()
{
  var ruta = base_url +'/'+ 'estadosRadicado/tablaEstadoRadicado';

  $.ajax({                
    url:   ruta,
    type:  'post',
    beforeSend: function(){ 
      cargaLoader('Consultando los estados radicados.  Un momento por favor..');     
    },
    success:  function (responseText) {
      ocultaLoader();
      $("#resultadoTablaEstadoRadicado").html(responseText);
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

function agregarEstadoRadicado()
{
  $('#modalAgregarEstadoRadicado').modal('show');

  var ruta = base_url +'/'+ 'estadosRadicado/agregarEstadoRadicado';

  $.ajax({                
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoAgregarEstadoRadicado").html(responseText);
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

function validarGuardarEstadoRadicado()
{
  var nombreEstadoRadicado = $("#nombreEstadoRadicado").val();

  if(nombreEstadoRadicado == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe ingresar el nombre del estado del radicado",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  var ruta = base_url +'/'+ 'estadosRadicado/validarGuardarEstadoRadicado';

  var loader = '<img src="'+base_url+'/img/loader.gif">';

  var parametros = {  
    "nombreEstadoRadicado" : nombreEstadoRadicado
  };
  
  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',
    beforeSend: function(){     
      cargaLoader('Guardando estado radicado.  Un momento por favor..');   
      $('.btn-guardar-estadoRadicado').html('<span class="fa fa-spinner fa-spin"></span> Procesando...');
      $('.btn-guardar-estadoRadicado').css({ 'pointer-events': 'none' });
    },
    success:  function (responseText) {
      ocultaLoader();
      $('#modalAgregarEstadoRadicado').modal('hide');
      tablaEstadoRadicado();
      swal("Guardado!", "El estado del radicado ha sido guardado exitosamente.", "success"); 
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

function editarEstadoRadicado(idEstadoRadicado)
{
	$('#modalEditarEstadoRadicado').modal('show');

  var ruta = base_url +'/'+ 'estadosRadicado/editarEstadoRadicado';

	var parametros = {  
    "idEstadoRadicado" : idEstadoRadicado
  };

  $.ajax({                
    data:  parametros,                 
  	url:   ruta,
  	type:  'post',
  	success:  function (responseText) {
    	$("#resultadoEditarEstadoRadicado").html(responseText);
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

function validarEditarEstadoRadicado(idEstadoRadicado)
{
  var nombreEstadoRadicadoEditar = $("#nombreEstadoRadicadoEditar").val();

  if(nombreEstadoRadicadoEditar == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe ingresar el nombre del estado del radicado",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  var ruta = base_url +'/'+ 'estadosRadicado/validarEditarEstadoRadicado';

  var parametros = {  
    "idEstadoRadicado": idEstadoRadicado,
    "nombreEstadoRadicadoEditar" : nombreEstadoRadicadoEditar
  };
  
  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',
    beforeSend: function(){  
      cargaLoader('Modificando la dependencia.  Un momento por favor..');       
      $('.btn-editar-estadoRadicado').html('<span class="fa fa-spinner fa-spin"></span> Procesando...');
      $('.btn-editar-estadoRadicado').css({ 'pointer-events': 'none' });
    },
    success:  function (responseText) {
      ocultaLoader();
      $('#modalEditarEstadoRadicado').modal('hide');
      tablaEstadoRadicado();
      swal("Modificado!", "El estado del radicado ha sido modificado exitosamente.", "success"); 
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

function eliminarEstadoRadicado(idEstadoRadicado)
{
  swal({   
    title: "Está seguro de eliminar el estado del radicado?",   
    text: "Se eliminará el estado del radicado de la base de datos!",   
    type: "warning",   
    showCancelButton: true,   
    confirmButtonColor: "#f8b32d",   
    confirmButtonText: "Sí, eliminarlo!",   
    closeOnConfirm: false 
  }, function(){   
    validarEliminarEstadoRadicado(idEstadoRadicado);
  });
}

function validarEliminarEstadoRadicado(idEstadoRadicado)
{
  var ruta = base_url +'/'+ 'estadosRadicado/validarEliminarEstadoRadicado';

  var parametros = {  
    "idEstadoRadicado" : idEstadoRadicado
  };

  $.ajax({                
    data:  parametros,          
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      if(responseText == 1)
      {
        swal("Eliminado!", "El estado del radicado ha sido eliminado.", "success"); 
        tablaEstadoRadicado();
      }
      else
      {
        swal({   
          title: "No se puede eliminar la dependencia!",   
          text: "El estado del radicado esta siendo utilizado en al menos un proceso",   
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