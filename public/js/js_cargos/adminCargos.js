var base_url = $('meta[name="base_url"]').attr('content'); 
var id_usuario = $('meta[name="id_usuario"]').attr('content'); 


function tablaCargos()
{
  var ruta = base_url +'/'+ 'cargos/tablaCargos';
  $.ajax({                
    url:   ruta,
    type:  'post',
    beforeSend: function(){      
      cargaLoader('Consultando los cargos.  Un momento por favor..');
    },
    success:  function (responseText) {
      ocultaLoader();        
      $("#resultadoTablaCargos").html(responseText);
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

function agregarCargo()
{
  $('#modalAgregarCargo').modal('show');
  var ruta = base_url +'/'+ 'cargos/agregarCargo';
  $.ajax({                
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoAgregarCargo").html(responseText);
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

function validarGuardarCargo()
{
  var codigoCargo = $("#codigoCargo").val();
  var nombreCargo = $("#nombreCargo").val();

  if(nombreCargo == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe ingresar el nombre del cargo",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  var ruta = base_url +'/'+ 'cargos/validarGuardarCargo';

  var parametros = {  
    "codigoCargo" : codigoCargo,
    "nombreCargo" : nombreCargo
  };
  
  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',
    beforeSend: function(){  
      cargaLoader('Guardando el cargo.  Un momento por favor..');    
      $('.btn-guardar-cargo').html('<span class="fa fa-spinner fa-spin"></span> Procesando...');
      $('.btn-guardar-cargo').css({ 'pointer-events': 'none' });
    },
    success:  function (responseText) {
      ocultaLoader();
      $('#modalAgregarCargo').modal('hide');
      tablaCargos();
      swal("Guardado!", "El cargo ha sido guardado exitosamente.", "success"); 
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

function editarCargo(idCargo)
{
  $('#modalEditarCargo').modal('show');
  var ruta = base_url +'/'+ 'cargos/editarCargo';
  var parametros = {  
    "idCargo" : idCargo
  };

  $.ajax({                
    data:  parametros,          
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoEditarCargo").html(responseText);
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

function validarEditarCargo(idCargo)
{
  var codigoCargoEditar = $("#codigoCargoEditar").val();
  var nombreCargoEditar = $("#nombreCargoEditar").val();

  if(nombreCargoEditar == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe ingresar el nombre del cargo",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  var ruta = base_url +'/'+ 'cargos/validarEditarCargo';

  var loader = '<img src="'+base_url+'/img/loader.gif">';

  var parametros = {  
    "idCargo" : idCargo,
    "codigoCargoEditar" : codigoCargoEditar,
    "nombreCargoEditar" : nombreCargoEditar
  };

  $.ajax({                
    data:  parametros,          
    url:   ruta,
    type:  'post',
    beforeSend: function(){   
      cargaLoader('Modificando el cargo.  Un momento por favor..');   
      $('.btn-editar-cargo').html('<span class="fa fa-spinner fa-spin"></span> Procesando...');
      $('.btn-editar-cargo').css({ 'pointer-events': 'none' });
    },
    success:  function (responseText) {
      ocultaLoader();
      $('#modalEditarCargo').modal('hide');
      swal("Modificado!", "El cargo ha sido modificado.", "success"); 
      tablaCargos();
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

function eliminarCargo(idCargo)
{
  swal({   
    title: "Está seguro de eliminar el cargo?",   
    text: "Se eliminará el cargo de la base de datos!",   
    type: "warning",   
    showCancelButton: true,   
    confirmButtonColor: "#f8b32d",   
    confirmButtonText: "Sí, eliminarlo!",   
    closeOnConfirm: false 
  }, function(){   
    validarEliminarCargo(idCargo);
  });
}

function validarEliminarCargo(idCargo)
{
  var ruta = base_url +'/'+ 'cargos/validarEliminarCargo';

  var loader = '<img src="'+base_url+'/img/loader.gif">';

  var parametros = {  
    "idCargo" : idCargo
  };

  $.ajax({                
    data:  parametros,          
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      if(responseText == 1)
      {
        swal("Eliminado!", "El cargo ha sido eliminado.", "success"); 
        tablaCargos();
      }
      else
      {
        swal({   
          title: "No se puede eliminar el cargo!",   
          text: "El cargo es utilizado por al menos un usuario",   
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