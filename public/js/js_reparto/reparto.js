var base_url = $('meta[name="base_url"]').attr('content'); 
var id_usuario = $('meta[name="id_usuario"]').attr('content'); 

var vectorReparto   = [];

function asignarAbogado(idAbogado)
{
  alert(idAbogado);
}

function cerrar()
{
  $( ".superbox-close" ).click();
}

function validarGuardarReparto(idEstadoEtapa, idResponsableSiguiente, nombreAbogado, idUsuario, vigenciaRadicado, idRadicado)
{
  var found = vectorReparto.find(function(element) {
    if(element == idResponsableSiguiente)
    {
      return 1;
    }
  });

  if(found === undefined)
  {
    vectorReparto.push(idResponsableSiguiente);
    vectorReparto = $.unique(vectorReparto);
    var jsonReparto = JSON.stringify(vectorReparto); 
  }
  else
  {
    swal({
      title: "Atención!",
      text: "Abogado ya fue seleccionado",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  if(vectorReparto.length == 1)
  {
    $('#apoderadoProceso').val(idResponsableSiguiente);
  }
  else
  {
    $('#apoderadoProceso').val(''); 
  }

  var ruta = base_url +'/'+ 'reparto/validarGuardarReparto';

  var parametros = {  
    "idResponsableSiguiente": idResponsableSiguiente,
    "jsonReparto": jsonReparto
  };
  
  $.ajax({                
    data:  parametros,                 
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoAbogadosAsigandos").html(responseText);
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

function removerAsignado(idResponsable)
{
  $('div#tablaAsignados_'+idResponsable).remove();

  vectorReparto = $.grep(vectorReparto, function(value) {
    return value != idResponsable;
  });
  vectorReparto = $.unique(vectorReparto);
  if(vectorReparto.length == 1)
  {
    var responsableUltimo = $('.apoderadoTitular').val();
    $('.apoderadoTitular').prop('checked', true);
    $('.apoderadoTitular').attr("disabled", true);
    $('#apoderadoProceso').val(responsableUltimo);
  }

  if(vectorReparto.length == 0)
  {
    $('#apoderadoProceso').val('');
  }
}

function seleccionarApoderado(idResponsable)
{
  if($(".apoderadoTitular").is(':checked'))
  {
    $('.apoderadoTitular').attr("disabled", true);
    $('#apoderadoCheck_'+idResponsable).attr("disabled", false);
    $('#apoderadoProceso').val(idResponsable);
  }
  else
  {
    $('.apoderadoTitular').attr("disabled", false);
    $('#apoderadoProceso').val('');
  }
}

function validarAsignarReparto()
{
  var idEstadoEtapa    = $("#idEstadoEtapa").val();
  var vigenciaRadicado = $("#vigenciaRadicado").val();
  var idRadicado       = $("#idRadicado").val();
  var apoderadoProceso = $("#apoderadoProceso").val();

  var jsonAsignados = JSON.stringify(vectorReparto);

  var ruta = base_url +'/'+ 'reparto/validarAsignarReparto';

  if(vectorReparto.length == 0)
  {
    swal({   
      title: "Atención!",   
      text: "No hay abogados seleccionados",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(apoderadoProceso == '')
  {
    swal({   
      title: "Atención!",   
      text: "Seleccione el apoderado titular del proceso",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  var loader = '<img src="'+base_url+'/img/loader.gif">';

  var parametros = {  
    "idEstadoEtapa"    : idEstadoEtapa,
    "jsonAsignados"    : jsonAsignados,
    "apoderadoProceso" : apoderadoProceso
  };
  
  $.ajax({                
    data:  parametros,                 
    url:   ruta,
    type:  'post',
    beforeSend: function(){      
      $('.btn-asignar-reparto').html('<span class="fa fa-spinner fa-spin"></span> Procesando...');
      $('.btn-asignar-reparto').css({ 'pointer-events': 'none' });
    },
    success:  function (responseText) {
      for(var i = 0; i < vectorReparto.length; i++)
      {  
        socket.emit("server_nuevoEnBuzon", {idUsuarioSiguiente: vectorReparto[i], mensaje: "Le fue asignado el radicado: " + vigenciaRadicado + "-" + idRadicado + ", por favor revise su buzón."});
      } 
      swal("Guardado!", "El reparto se ha realizado exitosamente.", "success"); 
      var rutaRedirect = base_url +'/'+ 'buzon/index'; 
      setTimeout(function(){  window.location.href = rutaRedirect; }, 1000); 
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