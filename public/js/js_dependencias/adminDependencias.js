var base_url = $('meta[name="base_url"]').attr('content');
var id_usuario = $('meta[name="id_usuario"]').attr('content');


function tablaDependencias()
{
  var ruta = base_url +'/'+ 'dependencias/tablaDependencias';

  $.ajax({
    url:   ruta,
    type:  'post',
    beforeSend: function(){
      cargaLoader('Consultando las dependencias.  Un momento por favor..');
    },
    success:  function (responseText) {
      ocultaLoader();
      $("#resultadoTablaDependencias").html(responseText);
      //$('#tablaDependencias').DataTable();
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

function agregarDependencia()
{
  $('#modalAgregarDependencia').modal('show');

  var ruta = base_url +'/'+ 'dependencias/agregarDependencia';

  $.ajax({
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoAgregarDependencia").html(responseText);
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

function validarGuardarDependencia()
{
  var codigoDependencia = $("#codigoDependencia").val();
  var nombreDependencia = $("#nombreDependencia").val();
  var propositoDependencia = $("#propositoDependencia").val();
  var selectDependencia = $("#selectDependencia").val();

  if(nombreDependencia == "")
  {
    swal({
      title: "Campo sin diligenciar!",
      text: "Debe ingresar el nombre de la dependencia",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  if(propositoDependencia == "")
  {
    swal({
      title: "Campo sin diligenciar!",
      text: "Debe ingresar el próposito de la dependencia",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  if(selectDependencia == "")
  {
    swal({
      title: "Campo sin diligenciar!",
      text: "Debe la dependencia",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  var ruta = base_url +'/'+ 'dependencias/validarGuardarDependencia';

  var parametros = {
    "codigoDependencia" : codigoDependencia,
    "nombreDependencia" : nombreDependencia,
    "propositoDependencia" : propositoDependencia,
    "selectDependencia": selectDependencia
  };

  $.ajax({
    data:  parametros,
    url:   ruta,
    type:  'post',
    beforeSend: function(){
      cargaLoader('Guardando la dependencia.  Un momento por favor..');
      $('.btn-guardar-dependencia').html('<span class="fa fa-spinner fa-spin"></span> Procesando...');
      $('.btn-guardar-dependencia').css({ 'pointer-events': 'none' });
    },
    success:  function (responseText) {
      ocultaLoader();
      $('#modalAgregarDependencia').modal('hide');
      tablaDependencias();
      swal("Guardado!", "La dependencia ha sido guardada exitosamente.", "success");
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

function editarDependencia(idDependencia)
{
  $('#modalEditarDependencia').modal('show');

  var ruta = base_url +'/'+ 'dependencias/editarDependencia';

  var parametros = {
    "idDependencia" : idDependencia
  };

  $.ajax({
    data:  parametros,
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoEditarDependencia").html(responseText);
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

function validarEditarDependencia(idDependencia)
{
  var codigoDependenciaEditar = $("#codigoDependenciaEditar").val();
  var nombreDependenciaEditar = $("#nombreDependenciaEditar").val();
  var propositoDependenciaEditar = $("#propositoDependenciaEditar").val();
  var selectDependenciaEditar = $("#selectDependenciaEditar").val();

  if(nombreDependenciaEditar == "")
  {
    swal({
      title: "Campo sin diligenciar!",
      text: "Debe ingresar el nombre de la dependencia",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  if(propositoDependenciaEditar == "")
  {
    swal({
      title: "Campo sin diligenciar!",
      text: "Debe ingresar el próposito de la dependencia",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  if(selectDependenciaEditar == "")
  {
    swal({
      title: "Campo sin diligenciar!",
      text: "Debe ingresar la dependencia",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  var ruta = base_url +'/'+ 'dependencias/validarEditarDependencia';

  var parametros = {
    "idDependencia": idDependencia,
    "codigoDependenciaEditar" : codigoDependenciaEditar,
    "nombreDependenciaEditar" : nombreDependenciaEditar,
    "propositoDependenciaEditar" : propositoDependenciaEditar,
    "selectDependenciaEditar": selectDependenciaEditar
  };

  $.ajax({
    data:  parametros,
    url:   ruta,
    type:  'post',
    beforeSend: function(){
      cargaLoader('Modificando la dependencia.  Un momento por favor..');
      $('.btn-editar-dependencia').html('<span class="fa fa-spinner fa-spin"></span> Procesando...');
      $('.btn-editar-dependencia').css({ 'pointer-events': 'none' });
    },
    success:  function (responseText) {
      ocultaLoader();
      $('#modalEditarDependencia').modal('hide');
      tablaDependencias();
      swal("Modificada!", "La dependencia ha sido modificada exitosamente.", "success");
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

function eliminarDependencia(idDependencia)
{
  swal({
    title: "Está seguro de eliminar la dependencia?",
    text: "Se eliminará la dependencia de la base de datos!",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#f8b32d",
    confirmButtonText: "Sí, eliminarlo!",
    closeOnConfirm: false
  }, function(){
    validarEliminarDependencia(idDependencia);
  });
}

function validarEliminarDependencia(idDependencia)
{
  var ruta = base_url +'/'+ 'dependencias/validarEliminarDependencia';

  var parametros = {
    "idDependencia" : idDependencia
  };

  $.ajax({
    data:  parametros,
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      if(responseText == 1)
      {
        swal("Eliminado!", "La dependencia ha sido eliminada.", "success");
        tablaDependencias();
      }
      else
      {
        swal({
          title: "No se puede eliminar la dependencia!",
          text: "La dependencia es utilizada por al menos un usuario",
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
