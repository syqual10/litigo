var base_url = $('meta[name="base_url"]').attr('content'); 
var id_usuario = $('meta[name="id_usuario"]').attr('content'); 


function tablaIpc()
{
  var ruta = base_url +'/'+ 'ipc/tablaIpc';

  $.ajax({                
    url:   ruta,
    type:  'post',
    beforeSend: function(){      
      cargaLoader('Consultando IPC.  Un momento por favor..');
    },
    success:  function (responseText) {
      ocultaLoader();
      $("#resultadoTablaIPC").html(responseText);
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

function agregarIPC()
{
  $('#modalAgregarIPC').modal('show');

  var ruta = base_url +'/'+ 'ipc/agregarIPC';

  $.ajax({                
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoAgregarIPC").html(responseText);
      $(".select2").select2({ width: '100%' });
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

function validarGuardarIpc()
{
  var selectVigenciaIpc = $("#selectVigenciaIpc").val();
  var selectMesIpc = $("#selectMesIpc").val();
  var valorIpc = $("#valorIpc").val();

  if(selectVigenciaIpc == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Seleccione la vigencia",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(selectMesIpc == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Seleccione el mes",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(valorIpc == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe ingresar el valor ipc",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }


  if(valorIpc.indexOf('.') == -1)
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Separe los decimales con un punto por favor",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  var ruta = base_url +'/'+ 'ipc/validarGuardarIpc';

  var parametros = {  
    "selectVigenciaIpc" : selectVigenciaIpc,
    "selectMesIpc" : selectMesIpc,
    "valorIpc" : valorIpc
  };
  
  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',

    success:  function (responseText) {
     
     
      tablaIpc();
      swal("Guardado!", "El ipc ha sido guardado exitosamente.", "success"); 
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

function editarIPC(idIPC)
{
  $('#modalEditarIPC').modal('show');

  var ruta = base_url +'/'+ 'ipc/editarIPC';

  var parametros = {  
    "idIPC" : idIPC
  };

  $.ajax({                
    data:  parametros,          
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoEditarIPC").html(responseText);
      $(".select2").select2({ width: '100%' });
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

function validarEditarIpc(idIPC)
{
  var selectVigenciaIpcEditar = $("#selectVigenciaIpcEditar").val();
  var selectMesIpcEditar = $("#selectMesIpcEditar").val();
  var valorIpcEditar = $("#valorIpcEditar").val();

  if(selectVigenciaIpcEditar == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Seleccione la vigencia",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(selectMesIpcEditar == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Seleccione el mes",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(valorIpcEditar == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe ingresar el valor ipc",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(valorIpcEditar.indexOf('.') == -1)
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Separe los decimales con un punto por favor",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  var ruta = base_url +'/'+ 'ipc/validarEditarIpc';

  var parametros = {  
    "idIPC": idIPC,
    "selectVigenciaIpcEditar" : selectVigenciaIpcEditar,
    "selectMesIpcEditar" : selectMesIpcEditar,
    "valorIpcEditar": valorIpcEditar
  };
  
  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',
    beforeSend: function(){   
      cargaLoader('Modificando la dependencia.  Un momento por favor..');   
      $('.btn-editar-ipc').html('<span class="fa fa-spinner fa-spin"></span> Procesando...');
      $('.btn-editar-ipc').css({ 'pointer-events': 'none' });
    },
    success:  function (responseText) {
      ocultaLoader();
      $('#modalEditarIPC').modal('hide');
      tablaIpc();
      swal("Modificado!", "El IPC ha sido modificado exitosamente exitosamente.", "success"); 
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

function eliminarIPC(idIPC)
{
  swal({   
    title: "Está seguro de eliminar el IPC?",   
    text: "Se eliminará el IPC de la base de datos!",   
    type: "warning",   
    showCancelButton: true,   
    confirmButtonColor: "#f8b32d",   
    confirmButtonText: "Sí, eliminarlo!",   
    closeOnConfirm: false 
  }, function(){   
    validarEliminarIPC(idIPC);
  });
}

function validarEliminarIPC(idIPC)
{
  var ruta = base_url +'/'+ 'ipc/validarEliminarIPC';

  var parametros = {  
    "idIPC" : idIPC
  };

  $.ajax({                
    data:  parametros,          
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      swal("Eliminado!", "El IPC ha sido eliminado de la base de datos.", "success"); 
      tablaIpc();
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