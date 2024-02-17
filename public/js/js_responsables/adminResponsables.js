var base_url = $('meta[name="base_url"]').attr('content'); 
var id_usuario = $('meta[name="id_usuario"]').attr('content'); 

function tablaResponsables()
{
  var ruta = base_url +'/'+ 'responsables/tablaResponsables';

  $.ajax({                
    url:   ruta,
    type:  'post',
    beforeSend: function(){      
      cargaLoader('Consultando los responsables.  Un momento por favor..');
    },
    success:  function (responseText) {
      ocultaLoader();
      $("#resultadoTablaResponsables").html(responseText);
      $('#fresh-table-responsables').bootstrapTable();
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

function agregarResponsable()
{
  $('#modalAgregarResponsable').modal('show');

  var ruta = base_url +'/'+ 'responsables/agregarResponsable';

  $.ajax({                
    url:   ruta,
    type:  'post',
    beforeSend: function(){      
      cargaLoader('Agregar Responsable.  Un momento por favor..');
    },
    success:  function (responseText) {
      ocultaLoader();
      $("#resultadoAgregarResponsable").html(responseText);
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

function validarGuardarResponsable()
{
  var selectUsuario = $("#selectUsuario").val();
  var selectRol     = $("#selectRol").val();
  var selectPerfil  = $("#selectPerfil").val();
  var selectOficios = $("#selectOficios").val();
  var selectPunto   = $("#selectPunto").val();

  if(selectUsuario == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe seleccionar el usuario",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(selectRol == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe seleccionar el rol",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(selectPerfil == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe seleccionar el perfil",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  var ruta = base_url +'/'+ 'responsables/validarGuardarResponsable';

  var parametros = {  
    "selectUsuario" : selectUsuario,
    "selectRol"     : selectRol,
    "selectPerfil"  : selectPerfil,
    "selectOficios" : selectOficios,
    "selectPunto"   : selectPunto
  };
  
  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',
    beforeSend: function(){    
      cargaLoader('Guardando el responsable.  Un momento por favor..');  
      $('.btn-guardar-responsable').html('<span class="fa fa-spinner fa-spin"></span> Procesando...');
      $('.btn-guardar-responsable').css({ 'pointer-events': 'none' });
    },
    success:  function (responseText) {
      if(responseText == 1){
        ocultaLoader();
        $('#modalAgregarResponsable').modal('hide');
        tablaResponsables();
        swal("Guardado!", "El responsable ha sido guardado exitosamente.", "success");
      } else{
        ocultaLoader();
        $('#modalAgregarResponsable').modal('hide');
        swal("Error!", "El responsable ya existe.", "error");
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

function editarResponsable(idResponsable)
{
  $('#modalEditarResponsable').modal('show');

  var ruta = base_url +'/'+ 'responsables/editarResponsable';

  var parametros = {  
    "idResponsable" : idResponsable
  };

  $.ajax({                
    data:  parametros,          
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoEditarResponsable").html(responseText);
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

function validarEditarResponsable(idResponsable)
{
  var selectUsuarioEditar = $("#selectUsuarioEditar").val();
  var selectRolEditar     = $("#selectRolEditar").val();
  var selectPerfilEditar  = $("#selectPerfilEditar").val();
  var selectOficiosEditar = $("#selectOficiosEditar").val();
  var selectPuntoEditar   = $("#selectPuntoEditar").val();

  if(selectUsuarioEditar == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Seleccione el usuario",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(selectRolEditar == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Seleccione el rol",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(selectPerfilEditar == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Seleccione el perfil",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  var ruta = base_url +'/'+ 'responsables/validarEditarResponsable';

  var parametros = {  
    "idResponsable"       : idResponsable,
    "selectUsuarioEditar" : selectUsuarioEditar,
    "selectRolEditar"     : selectRolEditar,
    "selectPerfilEditar"  : selectPerfilEditar,
    "selectOficiosEditar" : selectOficiosEditar,
    "selectPuntoEditar"   : selectPuntoEditar
  };
  
  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',
    beforeSend: function(){   
      cargaLoader('Modificando la dependencia.  Un momento por favor..');   
      $('.btn-editar-responsable').html('<span class="fa fa-spinner fa-spin"></span> Procesando...');
      $('.btn-editar-responsable').css({ 'pointer-events': 'none' });
    },
    success:  function (responseText) {
      ocultaLoader();
      $('#modalEditarResponsable').modal('hide');
      tablaResponsables();
      swal("Modificada!", "El responsable se modificó exitosamente.", "success"); 
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

function desactivarResponsable(idResponsable, estadoResponsable)
{ 
  if(estadoResponsable == 0)// desactivar
  {
    swal({   
        title: "Está seguro de desactivar el responsable?",   
        text: "Se desactivará el responsable de la base de datos!",   
        type: "warning",   
        showCancelButton: true,   
        confirmButtonColor: "#f8b32d",   
        confirmButtonText: "Sí, desactivarlo!",   
        closeOnConfirm: false 
      }, function(){
        validarEstadoResponsable(idResponsable, estadoResponsable);
      });
    }
    else// activar
    {
      swal({   
        title: "Está seguro de activar el responsable?",   
        text: "El responsable se agregará a la base de datos!",   
        type: "warning",   
        showCancelButton: true,   
        confirmButtonColor: "#f8b32d",   
        confirmButtonText: "Sí, activarlo!",   
        closeOnConfirm: false 
      }, function(){
        validarEstadoResponsable(idResponsable, estadoResponsable);
      });
    }
}

function validarEstadoResponsable(idResponsable, estadoResponsable)
{
  var ruta = base_url +'/'+ 'responsables/validarEstadoResponsable';

  var parametros = {  
    "idResponsable" : idResponsable,
    "estadoResponsable": estadoResponsable
  };

  $.ajax({                
    data:  parametros,          
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      if(responseText == 0)
      {
        swal({   
          title: "No se puede desactivar el responsable!",   
          text: "El responsable tiene procesos activos",    
          confirmButtonColor: "#f33923",   
        });
        return false;
      }
      else if(responseText == 1)
      {
        swal("Desactivado!", "El responsable ha sido desactivado en la base de datos.", "success"); 
        tablaResponsables();
      }
      else
      {
        swal("Activado!", "El responsable ha sido activado en la base de datos.", "success"); 
        tablaResponsables();
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

function agregarRespInternos(idResponsable)
{
  $('#modalAgregarInternos').modal('show');

  var ruta = base_url +'/'+ 'responsables/agregarRespInternos';

  var parametros = {  
    "idResponsable" : idResponsable,
  };
  
  $.ajax({                
    data:  parametros,                 
    url:   ruta,
    type:  'post',
    beforeSend: function(){      
      cargaLoader('Consultando responsables.  Un momento por favor..');
    },
    success:  function (responseText) {
      ocultaLoader();
      $("#resultadoAgregarInternos").html(responseText);
      $(".select2").select2({ width: '100%' });
      tablaResponsablesInternos(idResponsable);
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

function tablaResponsablesInternos(idResponsable)
{
  var ruta = base_url +'/'+ 'responsables/tablaResponsablesInternos';

  var parametros = {  
    "idResponsable" : idResponsable,
  };
  
  $.ajax({                
    data:  parametros,                 
    url:   ruta,
    type:  'post',
    beforeSend: function(){      
      cargaLoader('Consultando responsables internos.  Un momento por favor..');
    },
    success:  function (responseText) {
      ocultaLoader();
      $("#resultadoTablaRespInt").html(responseText);
      $('#tablaRespInt').bootstrapTable();
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

function validarGuardarRespInt(idResponsable)
{
  var selectRespInt = $("#selectRespInt").val();

  if(selectRespInt == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Seleccione al menos un resopnsable interno",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  var jsonSelectRespInt = JSON.stringify(selectRespInt);

  var ruta = base_url +'/'+ 'responsables/validarGuardarRespInt';

  var parametros = {  
    "idResponsable" : idResponsable,
    "jsonSelectRespInt" : jsonSelectRespInt
  };
  
  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',
    beforeSend: function(){    
      cargaLoader('Guardando responsables internos.  Un momento por favor..');
    },
    success:  function (responseText) {
      if(responseText.canNoAgregadas == 0)
      {
        swal("Guardado!", "El responsable interno ha sido guardado exitosamente.", "success"); 
      }
      else
      {
        swal({   
          title: "Atención!",   
          text: "Todas las personas fueron agregadas excepto "+responseText.noAgregadas,   
          confirmButtonColor: "#f33923",   
        });
      }
      tablaResponsablesInternos(idResponsable);
      tablaResponsables();
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

function eliminarRespoInt(idResponsable, idRespInt)
{
  swal({
    title: "Está seguro de eliminar el responsable interno?",
    text: "Se eliminará el responsable interno de la base de datos!",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#f8b32d",
    confirmButtonText: "Sí, eliminar!",
    closeOnConfirm: false
  }, function(){
    validarElimiarRespInt(idResponsable, idRespInt);
  });
}

function validarElimiarRespInt(idResponsable, idRespInt)
{
  var ruta = base_url +'/'+ 'responsables/validarElimiarRespInt';

  var parametros = {  
    "idRespInt" : idRespInt,
  };
  
  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      swal("Guardado!", "El responsable interno ha sido eliminado.", "success"); 
      tablaResponsablesInternos(idResponsable);
      tablaResponsables();
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