var base_url = $('meta[name="base_url"]').attr('content'); 
var id_usuario = $('meta[name="id_usuario"]').attr('content'); 


function terminados(loader)
{
  var fechaTerminado = $("#fechaTerminado").val();

  var ruta = base_url +'/'+ 'terminados/terminados';

  var parametros = {
    "fechaTerminado" : fechaTerminado
  };

  $.ajax({
    data:  parametros,           
    url:   ruta,
    type:  'post',
    beforeSend: function(){  
        if(loader == 1)    
            cargaLoader('Consultando procesos terminados el día '+fechaTerminado+'.  Un momento por favor..');
    },
    success:  function (responseText) {
        if(loader == 1)    
            ocultaLoader();
      $("#ajax-terminados").html(responseText);
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

function estadoArchivaProceso(idRadicado, accion)
{
  // accion 1 es marcar-finalizar
  // accion 0 es desmarcar
  var ruta = base_url +'/'+ 'terminados/estadoArchivaProceso';

  var parametros = {  
    "idRadicado": idRadicado,
    "accion": accion
  };
  
  $.ajax({                
    data:  parametros,                   
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
        terminados(0);
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