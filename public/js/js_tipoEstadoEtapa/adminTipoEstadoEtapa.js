var base_url = $('meta[name="base_url"]').attr('content'); 
var id_usuario = $('meta[name="id_usuario"]').attr('content'); 


function tablaTipoEstadoEtapa()
{
  var ruta = base_url +'/'+ 'estadosEtapas/tablaTipoEstadoEtapa';

  $.ajax({                
    url:   ruta,
    type:  'post',
    beforeSend: function(){      
      cargaLoader('Consultando los tipos de estado de las etapas.  Un momento por favor..');
    },
    success:  function (responseText) {
      ocultaLoader();
      $("#resultadoTablaTipoEstadoEtapa").html(responseText);
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

function agregartipoEstadoEtapa()
{
  $('#modalAgregarTipoEstadoEtapa').modal('show');

  var ruta = base_url +'/'+ 'estadosEtapas/agregartipoEstadoEtapa';

  $.ajax({                
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoAgregarTipoEstadoEtapa").html(responseText);
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

function validarGuardarTipoEstadoEtapa()
{
  var nombreTipoEstadoEtapa = $("#nombreTipoEstadoEtapa").val();

  if(nombreTipoEstadoEtapa == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe ingresar el nombre del tipo de estado etapa",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  var ruta = base_url +'/'+ 'estadosEtapas/validarGuardarTipoEstadoEtapa';

  var parametros = {  
    "nombreTipoEstadoEtapa" : nombreTipoEstadoEtapa
  };
  
  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',
    beforeSend: function(){    
      cargaLoader('Guardando el tipo de estado de la etapa.  Un momento por favor..');    
      $('.btn-guardar-tipoEstadoEtapa').html('<span class="fa fa-spinner fa-spin"></span> Procesando...');
      $('.btn-guardar-tipoEstadoEtapa').css({ 'pointer-events': 'none' });
    },
    success:  function (responseText) {
      ocultaLoader();
      $('#modalAgregarTipoEstadoEtapa').modal('hide');
      tablaTipoEstadoEtapa();
      swal("Guardado!", "El tipo de estado etapa ha sido guardado exitosamente.", "success"); 
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

function editartipoEstadoEtapa(idTipoEstadoEtapa)
{
  $('#modalEditarTipoEstadoEtapa').modal('show');

  var ruta = base_url +'/'+ 'estadosEtapas/editartipoEstadoEtapa';

  var parametros = {  
    "idTipoEstadoEtapa" : idTipoEstadoEtapa
  };

  $.ajax({                
    data:  parametros,          
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoEditarTipoEstadoEtapa").html(responseText);
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

function validarEditarTipoEstadoEtapa(idTipoEstadoEtapa)
{
  var nombreTipoEstadoEtapaEditar = $("#nombreTipoEstadoEtapaEditar").val();

  if(nombreTipoEstadoEtapaEditar == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe ingresar el nombre del tipo estado etapa",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  var ruta = base_url +'/'+ 'estadosEtapas/validarEditarTipoEstadoEtapa';

  var parametros = {  
    "idTipoEstadoEtapa" : idTipoEstadoEtapa,
    "nombreTipoEstadoEtapaEditar" : nombreTipoEstadoEtapaEditar
  };

  $.ajax({                
    data:  parametros,          
    url:   ruta,
    type:  'post',
    beforeSend: function(){   
      cargaLoader('Modificando el tipo de estado de etapa.  Un momento por favor..');      
      $('.btn-editar-tipoEstadoEtapa').html('<span class="fa fa-spinner fa-spin"></span> Procesando...');
      $('.btn-editar-tipoEstadoEtapa').css({ 'pointer-events': 'none' });
    },
    success:  function (responseText) {
      ocultaLoader();
      $('#modalEditarTipoEstadoEtapa').modal('hide');
      swal("Modificado!", "El tipo estado etapa ha sido modificado.", "success"); 
      tablaTipoEstadoEtapa();
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

function eliminartipoEstadoEtapa(idTipoEstadoEtapa)
{
  swal({   
    title: "Está seguro de eliminar el tipo de estado etapa?",   
    text: "Se eliminará el tipo de estado etapa de la base de datos!",   
    type: "warning",   
    showCancelButton: true,   
    confirmButtonColor: "#f8b32d",   
    confirmButtonText: "Sí, eliminarlo!",   
    closeOnConfirm: false 
  }, function(){   
    validarEliminarTipoEstadoEtapa(idTipoEstadoEtapa);
  });
}

function validarEliminarTipoEstadoEtapa(idTipoEstadoEtapa)
{
  var ruta = base_url +'/'+ 'estadosEtapas/validarEliminarTipoEstadoEtapa';

  var parametros = {  
    "idTipoEstadoEtapa" : idTipoEstadoEtapa
  };

  $.ajax({                
    data:  parametros,          
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      if(responseText == 1)
      {
        swal("Eliminado!", "El tipo estado etapa ha sido eliminado.", "success"); 
        tablaTipoEstadoEtapa();
      }
      else
      {
        swal({   
          title: "No se puede eliminar el tipo estado etapa!",   
          text: "El tipo estado etapa esta siendo utilizado por al menos un proceso",   
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