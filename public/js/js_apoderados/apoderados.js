var base_url = $('meta[name="base_url"]').attr('content'); 
var id_usuario = $('meta[name="id_usuario"]').attr('content'); 

function buscarProcesoApoderado()
{
  var selectMetodoBusquedaApoderado = $("#selectMetodoBusquedaApoderado").val();
  var vigenciaProcesoBuscarApoderado = $("#vigenciaProcesoBuscarApoderado").val();
  var metodoBusqueda = $('#selectMetodoBusquedaApoderado').val();
  var criterioBusquedaApoderado = 0;
  if(metodoBusqueda == 1){
    criterioBusquedaApoderado = $("#criterioBusquedaApoderado").val();
  }else{
    criterioBusquedaApoderado = $("#criterioBusquedaJuz").val();
  }

 

  if(selectMetodoBusquedaApoderado == 0)
  {
    swal({
      title: "Campo sin diligenciar!",
      text: "Seleccione un método de búsqueda",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  if(criterioBusquedaApoderado == 0)
  {
    swal({
      title: "Campo sin diligenciar!",
      text: "Ingrese el radicado o juzgado",
      confirmButtonColor: "#f33923",
    });
    return false;
  }


  var ruta = base_url +'/'+ 'apoderados/buscarProcesoApoderado';

  var parametros = {
    "selectMetodoBusquedaApoderado" : selectMetodoBusquedaApoderado,
    "vigenciaProcesoBuscarApoderado": vigenciaProcesoBuscarApoderado,
    "criterioBusquedaApoderado": criterioBusquedaApoderado
  };

  $.ajax({
    data:  parametros,           
    url:   ruta,
    type:  'post',
    beforeSend: function(){  
      cargaLoader('Consultando procesos..');
    },
    success:  function (responseText) {
      ocultaLoader();
      $("#ajax-procesos-encontrados").html(responseText);
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

function vigenciaRadicadoApoderado(idTipoBusqueda){
  if(idTipoBusqueda == 1)
  {
    $("#divRadicadoSyqualApoderado").css("display","block");
    $("#divRadicadoJuzgado").css("display","none");
  }
  else
  {
    $("#divRadicadoSyqualApoderado").css("display","none");
    $("#divRadicadoJuzgado").css("display","block");
  }
}

function apoderadosRadicado(vigenciaRadicado, idRadicado)
{
  $('#modalApoderados').modal('show');

  var ruta = base_url +'/'+ 'apoderados/apoderadosRadicado';

  var parametros = {
    "vigenciaRadicado" : vigenciaRadicado,
    "idRadicado": idRadicado
  };

  $.ajax({
    data:  parametros,           
    url:   ruta,
    type:  'post',
    beforeSend: function(){  
      cargaLoader('Consultando apoderados..');
    },
    success:  function (responseText) {
      ocultaLoader();
      $("#ajax-apoderados").html(responseText);
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

function eliminarApoderado(idEstadoEtapa, idRadicado, vigenciaRadicado)
{
  swal({
    title: "Está seguro de eliminar el apoderado del radicado?",
    text: "Se eliminará el apoderado del radicado!",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#f8b32d",
    confirmButtonText: "Sí, eliminarlo!",
    closeOnConfirm: true
  }, function(){
    validarEliminarApoderado(idEstadoEtapa, vigenciaRadicado, idRadicado);
  });
}

function agregarApoderado(vigenciaRadicado, idRadicado)
{
  $('#modalApoderados').modal('show');

  var ruta = base_url +'/'+ 'apoderados/agregarApoderado';

  var parametros = {
    "vigenciaRadicado" : vigenciaRadicado,
    "idRadicado": idRadicado
  };

  $.ajax({
    data:  parametros,           
    url:   ruta,
    type:  'post',
    beforeSend: function(){  
      cargaLoader('Consultando apoderados..');
    },
    success:  function (responseText) {
      ocultaLoader();
      $("#ajax-apoderados").html(responseText);
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

function validarEliminarApoderado(idEstadoEtapa, vigenciaRadicado, idRadicado)
{
  var ruta = base_url +'/'+ 'apoderados/validarEliminarApoderado';

  var parametros = {
    "idEstadoEtapa": idEstadoEtapa,
    "vigenciaRadicado": vigenciaRadicado,
    "idRadicado": idRadicado
  };

  $.ajax({
    data:  parametros,           
    url:   ruta,
    type:  'post',
    beforeSend: function(){  
      cargaLoader('Eliminando apoderado..');
    },
    success:  function (responseText) {
      buscarProcesoApoderado();
      $('#modalApoderados').modal('hide');
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

function validarGuardarNuevoApoderado(vigenciaRadicado, idRadicado)
{
  var ruta = base_url +'/'+ 'apoderados/validarGuardarNuevoApoderado';

  var selectApoderadoNuevo = $("#selectApoderadoNuevo").val();
  var selectPrincipal = $("#selectPrincipal").val();
  var comentarioApoderado = $("#comentarioApoderado").val();

  if(selectApoderadoNuevo == '')
  {
    swal({
      title: "Campo sin diligenciar!",
      text: "Seleccione un apoderado",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  if(selectPrincipal == 0)
  {
    swal({
      title: "Campo sin diligenciar!",
      text: "Seleccione si debe ser apoderado principal o no",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  if(comentarioApoderado == '')
  {
    swal({
      title: "Campo sin diligenciar!",
      text: "Ingrese una breve descripción",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  var parametros = {
    "vigenciaRadicado": vigenciaRadicado,
    "idRadicado": idRadicado,
    "selectApoderadoNuevo": selectApoderadoNuevo,
    "selectPrincipal": selectPrincipal,
    "comentarioApoderado": comentarioApoderado
  };

  $.ajax({
    data:  parametros,           
    url:   ruta,
    type:  'post',
    beforeSend: function(){  
      cargaLoader('Eliminando apoderado..');
    },
    success:  function (responseText) {
      buscarProcesoApoderado();
      $('#modalApoderados').modal('hide');
      swal("Guardado!", "El responsable ha sido asigando exitosamente.", "success");
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