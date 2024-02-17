var criterioBusqueda    = document.getElementById("criterioBusqueda");
var criterioBusquedaJuz = document.getElementById("criterioBusquedaJuz");

criterioBusqueda.addEventListener("keyup", function(event) 
{
  if (event.keyCode === 13) 
  {
    event.preventDefault();
    buscadorProcesos();
  }
});

criterioBusquedaJuz.addEventListener("keyup", function(event) 
{
  if (event.keyCode === 13) 
  {
    event.preventDefault();
    buscadorProcesos();
  }
});


function buscarProceso(metodo, vigencia, idRadicado)
{
  /*
    selectMetodoBusqueda es 1 radicado interno
    selectMetodoBusqueda es 2 documento demandante
    selectMetodoBusqueda es 3 nombre demandante
    selectMetodoBusqueda es 4 tema
    selectMetodoBusqueda es 5 radicado juzgado
    selectMetodoBusqueda es 6 radicado anterior
  */

  if(metodo != undefined)
  {
    var selectMetodoBusqueda = metodo;
  }
  else
  {
    var selectMetodoBusqueda = $("#selectMetodoBusqueda").val();
  }

  if(vigencia != undefined)
  {
    var vigenciaProcesoBuscar = vigencia;
  }
  else
  {
    var vigenciaProcesoBuscar = $("#vigenciaProcesoBuscar").val();
  }

  if(idRadicado != undefined)
  {
    var criterioBusqueda = idRadicado;
  }
  else
  {
    var criterioBusqueda = $("#criterioBusqueda").val();
  }
  
  var criterioBusquedaJuz = $("#criterioBusquedaJuz").val();
  if(selectMetodoBusqueda == 0)
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Seleccione un método de búsqueda",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(selectMetodoBusqueda !=5 && criterioBusqueda == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Ingrese el criterio de búsqueda",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(selectMetodoBusqueda == 5 && criterioBusquedaJuz == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Ingrese el radicado del juzgado",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  var ruta = base_url +'/'+ 'juridica/buscarProceso';

  var parametros = {
    "vigenciaProcesoBuscar" : vigenciaProcesoBuscar,
    "selectMetodoBusqueda": selectMetodoBusqueda,
    "criterioBusqueda" : criterioBusqueda,
    "criterioBusquedaJuz" : criterioBusquedaJuz,
  };

  $.ajax({
    data:  parametros,              
    url:   ruta,
    type:  'post',
    beforeSend: function(){      
      cargaLoader('Consultando la información.  Un momento por favor..');
    },
    success:  function (responseText) {
      ocultaLoader();
      if(responseText == 0)
      {
        if(selectMetodoBusqueda == 1)
        {
          swal({   
            title: "Atención!",   
            text: "No se encuentra información con el proceso "+vigenciaProcesoBuscar+"-"+criterioBusqueda,   
            confirmButtonColor: "#f33923",   
          });
          return false;
        }
        else
        {
          swal({   
            title: "Atención!",   
            text: "No se encuentra información con el criterio de búsqueda "+criterioBusqueda,   
            confirmButtonColor: "#f33923",   
          });
          return false;
        }
      }
      else
      {
        if(selectMetodoBusqueda == 1)
        {
          $("#labelBuscar").text("Proceso " + vigenciaProcesoBuscar + "-" + criterioBusqueda);
        }
        else
        {
          $("#labelBuscar").text("Procesos " + criterioBusqueda); 
        }
        $("#ajax-buscarProceso").html(responseText);
        $('.tabla-fresh').bootstrapTable();
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

function buscadorProcesos()
{
  /*
    selectMetodoBusqueda es 1 radicado interno
    selectMetodoBusqueda es 2 documento demandante
    selectMetodoBusqueda es 3 nombre demandante
    selectMetodoBusqueda es 4 tema
    selectMetodoBusqueda es 5 radicado juzgado
    selectMetodoBusqueda es 6 radicado anterior
  */
 
  var selectMetodoBusqueda = $("#selectMetodoBusqueda").val();
  var vigenciaProcesoBuscar = $("#vigenciaProcesoBuscar").val();
  var criterioBusqueda = $("#criterioBusqueda").val(); 
  var criterioBusquedaJuz = $("#criterioBusquedaJuz").val();

  if(selectMetodoBusqueda == 0)
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Seleccione un método de búsqueda",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(selectMetodoBusqueda != 5 && criterioBusqueda == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Ingrese el criterio de búsqueda",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(selectMetodoBusqueda == 5 && criterioBusquedaJuz == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Ingrese el radicado del juzgado",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  var ruta = base_url +'/'+ 'juridica/buscadorProcesos';

  var parametros = {
    "vigenciaProcesoBuscar" : vigenciaProcesoBuscar,
    "selectMetodoBusqueda": selectMetodoBusqueda,
    "criterioBusqueda" : criterioBusqueda,
    "criterioBusquedaJuz" : criterioBusquedaJuz,
  };

  $.ajax({
    data:  parametros,              
    url:   ruta,
    type:  'post',
    beforeSend: function(){      
      cargaLoader('Consultando la información.  Un momento por favor..');
    },
    success:  function (responseText) {
      ocultaLoader();
      if(responseText == 0)
      {
        if(selectMetodoBusqueda == 1)
        {
          swal({   
            title: "Atención!",   
            text: "No se encuentra información con el proceso "+vigenciaProcesoBuscar+"-"+criterioBusqueda,   
            confirmButtonColor: "#f33923",   
          });
          return false;
        }
        else
        {
          swal({   
            title: "Atención!",   
            text: "No se encuentra información con el criterio de búsqueda "+criterioBusqueda,   
            confirmButtonColor: "#f33923",   
          });
          return false;
        }
      }
      else
      {
        if(selectMetodoBusqueda == 1)
        {
          $("#labelBuscar").text("Proceso " + vigenciaProcesoBuscar + "-" + criterioBusqueda);
        }
        else
        {
          $("#labelBuscar").text("Procesos " + criterioBusqueda); 
        }
        $("#ajax-buscarProceso").html(responseText);
        $('.tabla-fresh').bootstrapTable();
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