var base_url = $('meta[name="base_url"]').attr('content'); 
var id_usuario = $('meta[name="id_usuario"]').attr('content'); 

function cargarValoracionesFallo()
{
    var vigenciaRadicado = $("#vigenciaRadicado").val();
    var idRadicado = $("#idRadicado").val();

    var ruta = base_url +'/'+ 'valoraFallo/cargarValoracionesFallo';

    var parametros = {  
        "vigenciaRadicado" : vigenciaRadicado,
        "idRadicado" : idRadicado,
        "administrar" : 1
    };

    $.ajax({                
        data:  parametros,                  
        url:   ruta,
        type:  'post',
        beforeSend: function(){      
        cargaLoader('Consultando las valoraciones.  Un momento por favor..');
        },
        success:  function (responseText) {
            ocultaLoader();
            $("#ajax-valoraciones").html(responseText);
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

function cargarValoracionFallo()
{ 
  var vigenciaRadicado = $("#vigenciaRadicado").val();
  var idRadicado = $("#idRadicado").val();

  var ruta = base_url +'/'+ 'valoraFallo/cargarValoracionFallo';

  var parametros = {  
    "vigenciaRadicado" : vigenciaRadicado,
    "idRadicado" : idRadicado
  };

  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',
    beforeSend: function(){      
      cargaLoader('Cargando los criterios.  Un momento por favor..');
    },
    success:  function (responseText) {
      ocultaLoader();
      $("#ajax-valoraciones").html(responseText);
     
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

function seleccionaRango(idCriterio, escala)
{
  var ruta = base_url +'/'+ 'valoraFallo/seleccionaRango';

  var parametros = {  
    "idCriterio" : idCriterio,
    "escala" : escala
  };

  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#ajax-rango-"+idCriterio).html(responseText);    
      $("#prob-"+idCriterio).spinner(); 
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

function guardarValoracion(cantidadCriterios)
{ 
    var vigenciaRadicado = $("#vigenciaRadicado").val();
    var idRadicado = $("#idRadicado").val();

    //Criterios
    var criterios = new Array();
    //Criterios valorados
    var valoraciones = new Array();
    //Escalas
    var escalas = new Array();
    //Cantidad evaluados
    var evaluados = 0; 

    $('.spinner-left').each(function(){
        criterios.push($(this).data("criterio"));
        valoraciones.push($(this).val());
        escalas.push($(this).data("escala"));
        evaluados++;
    });

    var total = cantidadCriterios - evaluados;

    if(total != 0)
    {
        swal({
            title: "Campo sin diligenciar!",
            text: "Faltan "+ total +" criterios por evaluar",
            confirmButtonColor: "#f33923",
        });
        return false;
    }

    var jsonCriterios = JSON.stringify(criterios);
    var jsonValoraciones = JSON.stringify(valoraciones); 
    var jsonEscalas = JSON.stringify(escalas); 

    var ruta = base_url +'/'+ 'valoraFallo/guardarValoracionFallo';

    var parametros = {  
        "vigenciaRadicado" : vigenciaRadicado,
        "idRadicado" : idRadicado,
        "jsonCriterios" : jsonCriterios,
        "jsonValoraciones" : jsonValoraciones,
        "jsonEscalas" : jsonEscalas
    };

    $.ajax({                
        data:  parametros,                  
        url:   ruta,
        type:  'post',
        beforeSend: function(){      
        cargaLoader('Guardando la valoración del fallo.  Un momento por favor..');
        },
        success:  function (responseText) {
            ocultaLoader();
            cargarValoracionesFallo();        
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

function pdfValoracion(idValoracion)
{
  $("#framePdf").contents().find("body").html('<div style="width:100%; height:100%; background:#fff; text-align:center;"><br></div>');
  $('#framePdf').attr('src','about:blank');
  //----------------------   
  //Carga el pdf generado
  //Lanza la modal
  $('#modalPdfGenerado').modal('show');

  //Carga el pdf en el iframe
  var ruta = base_url +'/'+ 'valoraFallo/pdfValoracion/';
  document.getElementById("framePdf").src= ruta+idValoracion;
}

function editarValoracion(idValoracion)
{ 
  var vigenciaRadicado = $("#vigenciaRadicado").val();
  var idRadicado = $("#idRadicado").val();

  var ruta = base_url +'/'+ 'valoraFallo/editarValoracion';

  var parametros = {  
    "idValoracion" : idValoracion
  };

  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',
    beforeSend: function(){      
      cargaLoader('Cargando los criterios.  Un momento por favor..');
    },
    success:  function (responseText) {
      ocultaLoader();
      $("#ajax-valoraciones").html(responseText);
      $(".spinner-left").spinner();
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

function modificarValoracion(cantidadCriterios, idValoracion)
{ 
    var vigenciaRadicado = $("#vigenciaRadicado").val();
    var idRadicado = $("#idRadicado").val();  
    
    //Criterios
    var criterios = new Array();
    //Criterios valorados
    var valoraciones = new Array();
    //Escalas
    var escalas = new Array();
    //Cantidad evaluados
    var evaluados = 0; 

    $('.spinner-left').each(function(){
        criterios.push($(this).data("criterio"));
        valoraciones.push($(this).val());
        escalas.push($(this).data("escala"));
        evaluados++;
    });

    var total = cantidadCriterios - evaluados;

    if(total != 0)
    {
        swal({
            title: "Campo sin diligenciar!",
            text: "Faltan "+ total +" criterios por evaluar",
            confirmButtonColor: "#f33923",
        });
        return false;
    }

    var jsonCriterios = JSON.stringify(criterios);
    var jsonValoraciones = JSON.stringify(valoraciones); 
    var jsonEscalas = JSON.stringify(escalas); 

    var ruta = base_url +'/'+ 'valoraFallo/modificarValoracionFallo';

    var parametros = {  
        "jsonCriterios" : jsonCriterios,
        "jsonValoraciones" : jsonValoraciones,
        "jsonEscalas" : jsonEscalas,
        "idValoracion" : idValoracion,
        "vigenciaRadicado" : vigenciaRadicado,
        "idRadicado" : idRadicado
    };

    $.ajax({                
        data:  parametros,                  
        url:   ruta,
        type:  'post',
        beforeSend: function(){      
        cargaLoader('Modificando la valoración del fallo.  Un momento por favor..');
        },
        success:  function (responseText) {
            ocultaLoader();
            cargarValoracionesFallo();        
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

function eliminarValoracion(idValoracion)
{
  swal({   
    title: "Está seguro de eliminar esta valoración?",   
    text: "Se eliminará la valoración de la base de datos!",   
    type: "warning",   
    showCancelButton: true,   
    confirmButtonColor: "#f8b32d",   
    confirmButtonText: "Sí, eliminar!",   
    closeOnConfirm: true 
  }, function(){   
    confirmaEliminarValoracion(idValoracion);
  });
}

function confirmaEliminarValoracion(idValoracion)
{ 
  var vigenciaRadicado = $("#vigenciaRadicado").val();
  var idRadicado = $("#idRadicado").val();

  var ruta = base_url +'/'+ 'valoraFallo/eliminarValoracion';

  var parametros = {  
    "idValoracion" : idValoracion,
    "vigenciaRadicado" : vigenciaRadicado,
    "idRadicado" : idRadicado
  };

  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      cargarValoracionesFallo(); 
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