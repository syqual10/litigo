var base_url = $('meta[name="base_url"]').attr('content');
var id_usuario = $('meta[name="id_usuario"]').attr('content');

function consolidado(idResponsable)
{
  var ruta = base_url +'/'+ 'mis-procesos/consolidado';

  var parametros = {
    "idResponsable" : idResponsable
  };

  $.ajax({
    data:  parametros,
    url:   ruta,
    type:  'post',
    beforeSend: function(){
      cargaLoader('Cargando el consolidado de sus procesos.  Un momento por favor..');
    },
    success:  function (responseText) {
      ocultaLoader();
      $("#ajax-consolidado").html(responseText);
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

function tablaProcesosConsolidado(idTipoProceso, idResponsable)
{
  var ruta = base_url +'/'+ 'mis-procesos/tablaProcesosConsolidado';

  var parametros = {
    "idTipoProceso" : idTipoProceso,
    "idResponsable" : idResponsable
  };

  $.ajax({
    data:  parametros,
    url:   ruta,
    type:  'post',
    beforeSend: function(){
      cargaLoader('Consultando los procesos.  Un momento por favor..');
    },
    success:  function (responseText) {
      ocultaLoader();
      $("#ajax-consolidado").html(responseText);
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
