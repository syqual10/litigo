var base_url = $('meta[name="base_url"]').attr('content'); 
var id_usuario = $('meta[name="id_usuario"]').attr('content'); 


function tablaMediosControl()
{
  var ruta = base_url +'/'+ 'mediosControl/tablaMediosControl';

  $.ajax({                
    url:   ruta,
    type:  'post',
    beforeSend: function(){  
      cargaLoader('Consultando los medios de control.  Un momento por favor..');    
    },
    success:  function (responseText) {
      ocultaLoader();
      $("#resultadoTablaMediosControl").html(responseText);
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

function agregarMediosControl()
{
  $('#modalAgregarMediosControl').modal('show');

  var ruta = base_url +'/'+ 'mediosControl/agregarMediosControl';

  $.ajax({                
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoAgregarMediosControl").html(responseText);
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

function validarGuardarMedioControl()
{
  var nombreMedioControl = $("#nombreMedioControl").val();

  if(nombreMedioControl == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe ingresar el nombre del medio de control",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  var ruta = base_url +'/'+ 'mediosControl/validarGuardarMedioControl';

  var parametros = {  
    "nombreMedioControl" : nombreMedioControl
  };
  
  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',
    beforeSend: function(){     
      cargaLoader('Guardando el medio de control.  Un momento por favor..');   
      $('.btn-guardar-medioControl').html('<span class="fa fa-spinner fa-spin"></span> Procesando...');
      $('.btn-guardar-medioControl').css({ 'pointer-events': 'none' });
    },
    success:  function (responseText) {
      ocultaLoader();
      $('#modalAgregarMediosControl').modal('hide');
      tablaMediosControl();
      swal("Guardado!", "El medio de control fue guardado exitosamente.", "success"); 
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

function editarMedioControl(idMedioControl)
{
  $('#modalEditarMediosControl').modal('show');

  var ruta = base_url +'/'+ 'mediosControl/editarMedioControl';

  var parametros = {  
    "idMedioControl" : idMedioControl
  };

  $.ajax({                
    data:  parametros,          
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoEditarMediosControl").html(responseText);
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

function validarEditarMedioControl(idMedioControl)
{
  var nombreMedioControlEditar = $("#nombreMedioControlEditar").val();

  if(nombreMedioControlEditar == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe ingresar el nombre del medio de control",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  var ruta = base_url +'/'+ 'mediosControl/validarEditarMedioControl';

  var parametros = {  
    "idMedioControl": idMedioControl,
    "nombreMedioControlEditar" : nombreMedioControlEditar
  };
  
  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',
    beforeSend: function(){   
      cargaLoader('Modificando el medio de control.  Un momento por favor..');      
      $('.btn-editar-medioControl').html('<span class="fa fa-spinner fa-spin"></span> Procesando...');
      $('.btn-editar-medioControl').css({ 'pointer-events': 'none' });
    },
    success:  function (responseText) {
      ocultaLoader();
      $('#modalEditarMediosControl').modal('hide');
      tablaMediosControl();
      swal("Guardado!", "El medio de control fue modificado exitosamente.", "success"); 
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

function eliminarMedioControl(idMedioControl)
{
  swal({   
    title: "Está seguro de eliminar el medio de control?",   
    text: "Se eliminará el medio de control en la base de datos!",   
    type: "warning",   
    showCancelButton: true,   
    confirmButtonColor: "#f8b32d",   
    confirmButtonText: "Sí, eliminarlo!",   
    closeOnConfirm: false 
  }, function(){   
    validarEliminarMedioControl(idMedioControl);
  });
}

function validarEliminarMedioControl(idMedioControl)
{
  var ruta = base_url +'/'+ 'mediosControl/validarEliminarMedioControl';

  var parametros = {  
    "idMedioControl" : idMedioControl
  };

  $.ajax({                
    data:  parametros,          
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      swal("Eliminado!", "El medio de control ha sido eliminado.", "success"); 
      tablaMediosControl();
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