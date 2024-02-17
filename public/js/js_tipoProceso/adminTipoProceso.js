var base_url = $('meta[name="base_url"]').attr('content'); 
var id_usuario = $('meta[name="id_usuario"]').attr('content'); 

function tablaTipoProcesos()
{
  var ruta = base_url +'/'+ 'tiposProcesos/tablaTipoProcesos';

  $.ajax({                
    url:   ruta,
    type:  'post',
    beforeSend: function(){      
      cargaLoader('Consultando los tipos de proceso.  Un momento por favor..');
    },
    success:  function (responseText) {
      ocultaLoader();
      $("#resultadoTablaTipoProceso").html(responseText);
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

function agregarTipoProceso()
{
  $('#modalAgregarTipoProceso').modal('show');

  var ruta = base_url +'/'+ 'tiposProcesos/agregarTipoProceso';

  $.ajax({                
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoAgregarTipoProceso").html(responseText);
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

function validarGuardarTipoProceso()
{
  var nombreTipoProceso = $("#nombreTipoProceso").val();
  var ordenTipoProceso = $("#ordenTipoProceso").val();

  if(nombreTipoProceso == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe ingresar el nombre del tipo proceso",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(ordenTipoProceso == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe ingresar el orden del tipo proceso",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  var ruta = base_url +'/'+ 'tiposProcesos/validarGuardarTipoProceso';

  var parametros = {  
    "nombreTipoProceso" : nombreTipoProceso,
    "ordenTipoProceso": ordenTipoProceso
  };
  
  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',
    beforeSend: function(){    
      cargaLoader('Guardando el tipo de proceso.  Un momento por favor..');    
      $('.btn-guardar-tipoProceso').html('<span class="fa fa-spinner fa-spin"></span> Procesando...');
      $('.btn-guardar-tipoProceso').css({ 'pointer-events': 'none' });
    },
    success:  function (responseText) {
      ocultaLoader();
      $('#modalAgregarTipoProceso').modal('hide');
      tablaTipoProcesos();
      swal("Guardado!", "El tipo de proceso ha guardado exitosamente.", "success"); 
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

function editarTipoProceso(idTipoProceso)
{
  $('#modalEditarTipoProceso').modal('show');

  var ruta = base_url +'/'+ 'tiposProcesos/editarTipoProceso';

  var parametros = {  
    "idTipoProceso" : idTipoProceso
  };

  $.ajax({                
    data:  parametros,          
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoEditarTipoProceso").html(responseText);
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

function validarEditarTipoProceso(idTipoProceso)
{
  var nombreTipoProcesoEditar = $("#nombreTipoProcesoEditar").val();
  var ordenTipoProcesoEditar = $("#ordenTipoProcesoEditar").val();

  if(nombreTipoProcesoEditar == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe ingresar el nombre del tipo de proceso",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(ordenTipoProcesoEditar == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe ingresar el orden del tipo de proceso",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  var ruta = base_url +'/'+ 'tiposProcesos/validarEditarTipoProceso';

  var parametros = {  
    "idTipoProceso" : idTipoProceso,
    "nombreTipoProcesoEditar" : nombreTipoProcesoEditar,
    "ordenTipoProcesoEditar": ordenTipoProcesoEditar
  };

  $.ajax({                
    data:  parametros,          
    url:   ruta,
    type:  'post',
    beforeSend: function(){ 
      cargaLoader('Modificando el tipo de proceso.  Un momento por favor..');        
      $('.btn-editar-tipoProceso').html('<span class="fa fa-spinner fa-spin"></span> Procesando...');
      $('.btn-editar-tipoProceso').css({ 'pointer-events': 'none' });
    },
    success:  function (responseText) {
      ocultaLoader();
      $('#modalEditarTipoProceso').modal('hide');
      swal("Modificado!", "El tipo de proceso ha sido modificado.", "success"); 
      tablaTipoProcesos();
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

function eliminarTipoProceso(idTipoProceso)
{
  swal({   
    title: "Está seguro de eliminar el tipo de proceso?",   
    text: "Se eliminará el tipo de proceso de la base de datos!",   
    type: "warning",   
    showCancelButton: true,   
    confirmButtonColor: "#f8b32d",   
    confirmButtonText: "Sí, eliminarlo!",   
    closeOnConfirm: false 
  }, function(){   
    validarEliminarTipoProceso(idTipoProceso);
  });
}

function validarEliminarTipoProceso(idTipoProceso)
{
  var ruta = base_url +'/'+ 'tiposProcesos/validarEliminarTipoProceso';

  var parametros = {  
    "idTipoProceso" : idTipoProceso
  };

  $.ajax({                
    data:  parametros,          
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      if(responseText == 1)
      {
        swal("Eliminado!", "El tipo de proceso ha sido eliminado.", "success"); 
        tablaTipoProcesos();
      }
      else
      {
        swal({   
          title: "No se puede eliminar el tipo de proceso!",   
          text: "El tipo de proceso es utilizado por al menos un radicado",   
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