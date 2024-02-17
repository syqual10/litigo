var base_url = $('meta[name="base_url"]').attr('content'); 
var id_usuario = $('meta[name="id_usuario"]').attr('content'); 

let pagina = 0;
function buzonProcesos(sentido)
{
  if(sentido != undefined){
    if(sentido == 1){
      pagina = parseInt(pagina + 1);
    } else{
      pagina = pagina == 0 ? 0 : parseInt(pagina - 1);
    }
  }
  var ruta = base_url +'/'+ 'buzon/buzonProcesos';
  console.log(pagina);
  $.ajax({                
    url:   ruta,
    data: {pagina},
    type:  'post',
    beforeSend: function(){      
      cargaLoader('Cargando sus procesos pendientes.  Un momento por favor..');
    },
    success:  function (responseText) {
      ocultaLoader();
      $("#resultadoBuzonProcesos").html(responseText['vista']);
      $("#cantidadRadicados").html(responseText['cantidad']);
      $("#totalRadicados").html(responseText['total']);
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

/* LA FUNCIÓN QUE TRAE LOS SIGUIENTES 30 O ANTERIORES 30 PROCESOS DEL BUZÓN */

function buzonSiguAnte(sigAnte)
{
  /*sigAnte es 0 trae anteriores 30  */
  /*sigAnte es 1 trae siguientes 30  */
  var minidEstadoEtapa = $("#minidEstadoEtapa").val();
  var maxidEstadoEtapa = $("#maxidEstadoEtapa").val();

  var ruta = base_url +'/'+ 'buzon/buzonSiguAnte';

  var parametros = {  
    "sigAnte" : sigAnte,
    "minidEstadoEtapa" : minidEstadoEtapa,
    "minidEstadoEtapa2" : $("#minidEstadoEtapa2").val(),
    "maxidEstadoEtapa" : maxidEstadoEtapa
  };

  console.log('Parametros', parametros)
  
  $.ajax({                
    data:  parametros,                   
    url:   ruta,
    type:  'post',
    beforeSend: function(){      
      cargaLoader('Cargando sus procesos pendientes.  Un momento por favor..');
    },
    success:  function (responseText) {
      ocultaLoader();
      if(responseText == 0)// no hay hacía atrás
      {
        swal({   
          title: "Atención!",   
          text: "No hay más procesos pendientes hacía atrás",   
          confirmButtonColor: "#f33923",   
        });
        return false;
      }
      else if(responseText == 1)// no hay hacía adelante
      {
        swal({   
          title: "Atención!",   
          text: "No hay más procesos pendientes hacía adelante",   
          confirmButtonColor: "#f33923",   
        });
        return false;
      }
      else
      {
        $("#resultadoBuzonProcesos").html(responseText);
        if(sigAnte == 1)
        {
          $("#minidEstadoEtapa2").val(minidEstadoEtapa);
        }
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

function misReportes(tipoReporte)
{
  /*
  1 Terminados
  2 Enviados
  3 Cancelados
  */

  $('#modalMisReportes').modal('show');

  var ruta = base_url +'/'+ 'buzon/misReportes';

  var parametros = {  
    "tipoReporte" : tipoReporte
  };
  
  $.ajax({                
    data:  parametros,                   
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoMisReportes").html(responseText);
      $('.input-daterange-datepicker').daterangepicker({
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-info',
        cancelClass: 'btn-default',
        locale: {
            format: 'YYYY/MM/DD' // --------Here
        },
      });
      if(tipoReporte == 1)
      {
        $('#labelMisReportes').text("Terminados");
      }
      else if(tipoReporte == 2)
      {
        $('#labelMisReportes').text("Enviados");
      }
      else if(tipoReporte == 3)
      {
        $('#labelMisReportes').text("Cancelados");
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

$(document).on('click', '.applyBtn', function () {
  /*
    1 Terminados
    2 Enviados
    3 Cancelados
  */
  var tipoReporte = $("#tipoReporte").val();

  var rangoFecha = $("#rangoFecha").val();
  rangoFecha = rangoFecha.split("-");

  var ruta = base_url +'/'+ 'buzon/validarMisReportes';
  var loader = '<img src="'+base_url+'/img/loader.gif">';

  var parametros = {  
    "tipoReporte" : tipoReporte,
    "fechaInicial":rangoFecha[0],
    "fechaFinal":rangoFecha[1]
  };
  
  $.ajax({                
    data:  parametros,                    
    url:   ruta,
    type:  'post',
    beforeSend: function(){      
      cargaLoader('Consultando la base de datos.  Un momento por favor..');
    },
    success:  function (responseText) {
      ocultaLoader(); 
      $("#resultadoBuzonProcesos").html(responseText);
      $('.tabla-fresh').bootstrapTable();
      $('#modalMisReportes').modal('hide');
      miReporteExcel();
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
});

function miReporteExcel()
{ 
  /*
    1 Terminados
    2 Enviados
    3 Cancelados
  */
  var tipoReporte = $("#tipoReporte").val();

  var fechaInicial = $("#fechaInicialSeleccionada").val();
  var fechaFinal = $("#fechaFinalSeleccionada").val();

  var parametros = {
    "tipoReporte" : tipoReporte, 
    "fechaInicial": fechaInicial,
    "fechaFinal": fechaFinal
  };

  var vector = JSON.stringify(parametros); 
  var rutaRedirect = base_url +'/'+ 'buzon/miReporteExcel'; 
  window.location.href = rutaRedirect+"/"+vector;
}

function ultimosLeidos()
{
  var ruta = base_url +'/'+ 'buzon/ultimosLeidos';

  $.ajax({                
    url:   ruta,
    type:  'post',
    beforeSend: function(){      
      cargaLoader('Cargando los últimos leídos.  Un momento por favor..');
    },
    success:  function (responseText) {
      ocultaLoader();
      $("#resultadoBuzonProcesos").html(responseText);
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

function buzonActuaciones()
{
  var ruta = base_url +'/'+ 'buzon/buzonActuaciones';

  $.ajax({                
    url:   ruta,
    type:  'post',
    beforeSend: function(){      
      cargaLoader('Cargando las actuaciones.  Un momento por favor..');
    },
    success:  function (responseText) {
      ocultaLoader();
      $("#resultadoBuzonProcesos").html(responseText);
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

function removerActuacionBuzon(idActuacion)
{
    $("#remover").val(1);
    var ruta = base_url +'/'+ 'buzon/removerActuacionBuzon';

    var parametros = {  
      "idActuacion" : idActuacion
    };
  
    $.ajax({                
      data:  parametros,                
      url:   ruta,
      type:  'post',
      success:  function (responseText) {
        $("#textoPendientesActuaciones").text("("+responseText+")");
        buzonActuaciones();
        swal("Guardado!", "Actuación removida del buzón exitosamente.", "success"); 
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

function trasladarMisProcesos(idEstado)
{
    $("#remover").val(1);
    var ruta = base_url +'/'+ 'buzon/trasladarMisProcesos';

    var parametros = {  
      "idEstado" : idEstado
    };
  
    $.ajax({                
      data:  parametros,                
      url:   ruta,
      type:  'post',
      success:  function (responseText) {
        $("#textoPendientes").text("("+responseText+")");
        $("#textoPendientesMaster").text(responseText);
        buzonProcesos();
        swal("Guardado!", "Procesos se traslado a MIS PROCESOS.", "success"); 
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