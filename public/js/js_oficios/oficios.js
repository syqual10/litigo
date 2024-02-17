var base_url = $('meta[name="base_url"]').attr('content'); 
var id_usuario = $('meta[name="id_usuario"]').attr('content'); 


function tablaOficios()
{
  var ruta = base_url +'/'+ 'oficio/tablaOficios';

  $.ajax({                
    url:   ruta,
    type:  'post',
    beforeSend: function(){      
      cargaLoader('Consultando los oficios generados.  Un momento por favor..');
    },
    success:  function (responseText) {
      ocultaLoader();
      $("#resultadoTablaOficios").html(responseText);
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

function agregarOficio()
{
  $('#modalGenerarOficio').modal('show');

  var ruta = base_url +'/'+ 'oficio/agregarOficio';

  $.ajax({
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoGenerarOficio").html(responseText);
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

function validarGuardarOficio(arco)
{
  var destinatario = $("#destinatario").val();
  var direccion    = $("#direccion").val();
  var asunto       = $("#asunto").val(); 
  var ciudadOficio = $("#ciudadOficio").val();

  //Caracteres prohibidos
  destinatario = destinatario.replace("#", "No.");
  destinatario = destinatario.replace("/", "-");
  direccion    = direccion.replace("#", "No.");
  direccion    = direccion.replace("/", "-");
  asunto       = asunto.replace("#", "No.");
  asunto       = asunto.replace("/", "-");

  //Validaciones
  if(destinatario == "")
  {
    swal({
      title: "Campo sin diligenciar!",
      text: "Debe ingresar el nombre del destinatario",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  if(direccion == "" )
  {
    swal({
      title: "Campo sin diligenciar!",
      text: "Deb ingresar la dirección del destinatario",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  if(asunto == "" )
  {
    swal({
      title: "Campo sin diligenciar!",
      text: "Debe ingresar el asunto",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  if(ciudadOficio == "" || ciudadOficio == null)
  {
    swal({
      title: "Campo sin diligenciar!",
      text: "Debe seleccionar la ciudad del destinatario",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  setTimeout(tablaOficios, 3000);

  if(arco == "")
  {
    generarOficio(destinatario, direccion, ciudadOficio, asunto, 0);//0 radicarArco no
  }
  else
  {
    swal({   
      title: "Atención",   
      text: "Desea radicar automáticamente en el sistema ARCO de correspondencia?",   
      type: "success",   
      showCancelButton: true,   
      confirmButtonColor: "#23b5e6",   
      confirmButtonText: "Sí, radicar en ARCO",   
      cancelButtonText: "No, sólo generar oficio",   
      closeOnConfirm: true,   
      closeOnCancel: true 
    }, function(isConfirm){   
      if (isConfirm) 
      {   
        generarOficio(destinatario, direccion, ciudadOficio, asunto, 1);//1 radicarArco sí  
      }
      else
      {
        generarOficio(destinatario, direccion, ciudadOficio, asunto, 0);//0 radicarArco no
      } 
    }); 
  }
}

function generarOficio(destinatario, direccion, ciudad, asunto, arco)
{
  var parametros = {
    "destinatario" : destinatario, 
    "direccion" : direccion,
    "ciudad": ciudad,
    "asunto": asunto,
    "arco": arco
  };

  var vector = JSON.stringify(parametros); 
  
  var rutaRedirect = base_url +'/'+ 'oficio/generarOficio'; 
  
  window.location.href = rutaRedirect+"/"+vector;

  $('#modalGenerarOficio').modal('hide');
}

function radicarArco(idConsecutivoOficio, vigenciaOficio, nombrePersona, direccionPersona, ciudades_idCiudad)
{
  var ruta = base_url +'/'+ 'oficio/radicarArco';

  var parametros = {  
    "idConsecutivoOficio" : idConsecutivoOficio,
    "vigenciaOficio" : vigenciaOficio,
    "nombrePersona" : nombrePersona,
    "direccionPersona" : direccionPersona,
    "ciudades_idCiudad" : ciudades_idCiudad
  };
  
  $.ajax({                
    data:  parametros,               
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      swal("Guardado!", "El "+responseText+ " Fue radicado correctamente.", "success");
      tablaOficios();
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

function vigenciaRadicados(vigencia)
{
  var ruta = base_url +'/'+ 'oficio/vigenciaRadicados';

  var parametros = {  
    "vigencia" : vigencia
  };
  
  $.ajax({                
    data:  parametros,               
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoRadicadosVig").html(responseText);
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

function involucradosRadicado(idRadicado)
{
  var vigenciaRadicado = $("#vigenciaRadicado").val();
  if(idRadicado == "")
  {
    swal({
      title: "Campo sin diligenciar!",
      text: "Seleccione el proceso",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  var ruta = base_url +'/'+ 'oficio/involucradosRadicado';

  var parametros = {  
    "idRadicado" : idRadicado,
    "vigenciaRadicado":vigenciaRadicado
  };
  
  $.ajax({                
    data:  parametros,               
    url:   ruta,
    type:  'post',
    beforeSend: function(){
      cargaLoader('Consultando los involucrados.  Un momento por favor..');
    },
    success:  function (responseText) {
      ocultaLoader();
      $("#resultadoInvolucrados").html(responseText);
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

function implicadoOficio(destinatario, direccion, ciudad)
{
  $("#ciudadOficio").select2("val", "");

  $("#destinatario").val(destinatario);
  $("#direccion").val(direccion);

  if(ciudad !='')
  {
    var ruta = base_url +'/'+ 'oficio/implicadoOficio';

    var parametros = {  
      "ciudad" : ciudad
    };
    
    $.ajax({                
      data:  parametros,               
      url:   ruta,
      type:  'post',
      success:  function (responseText) {
        $("#resultadoCiudadOficio").html(responseText);
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
}

function relacionadoProceso() {
  if($("#relacionadoProceso").is(':checked'))
  {
    $("#divProceso").css("display", "block");
  }
  else
  {
    $("#divProceso").css("display", "none");
  }
}