var base_url = $('meta[name="base_url"]').attr('content');
var id_usuario = $('meta[name="id_usuario"]').attr('content');


function instanciasProceso()
{
  var idTipoProceso = $("#idTipoProceso").val();

  var ruta = base_url +'/'+ 'actuacionesProcesales/instanciasProceso';

  var parametros = {
    "idTipoProceso" : idTipoProceso
  };

  $.ajax({
    data:  parametros,
    url:   ruta,
    type:  'post',
    beforeSend: function(){
      cargaLoader('Cargando instancias del proceso.  Un momento por favor..');
    },
    success:  function (responseText) {
      ocultaLoader();
      $("#resultadoInstanciasProceso").html(responseText.vista);
      etapasInstancia(responseText.instanciaInicial)
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

function etapasInstancia(idInstancia)
{
  var ruta = base_url +'/'+ 'actuacionesProcesales/etapasInstancia';

  var parametros = {
    "idInstancia" : idInstancia
  };

  $.ajax({
    data:  parametros,
    url:   ruta,
    type:  'post',
    beforeSend: function(){
      cargaLoader('Cargando etapas del proceso.  Un momento por favor..');
    },
    success:  function (responseText) {
      ocultaLoader();
      $("#resultadoEtapasInstancia_"+idInstancia).html(responseText.vista);
      actuacionesEtapa(responseText.etapaInicial);
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

function actuacionesEtapa(idEtapa)
{
  var vigenciaRadicado = $("#vigenciaRadicado").val();
  var idRadicado = $("#idRadicado").val();

  var ruta = base_url +'/'+ 'actuacionesProcesales/actuacionesEtapa';
  var loader = '<img src="'+base_url+'/img/loader.gif">';

  var parametros = {
    "idEtapa": idEtapa,
    "vigenciaRadicado": vigenciaRadicado,
    "idRadicado":idRadicado,
    "ver": 1
  };

  $.ajax({
    data:  parametros,
    url:   ruta,
    type:  'post',
    beforeSend: function(){
      $("#resultadoActuaciones_"+idEtapa).html("<img src='"+loader+"' style='margin-top:30px; width:40px'");
    },
    success:  function (responseText) {
      $("#resultadoActuaciones_"+idEtapa).html(responseText);      
      $('#tablaActuaciones_'+idEtapa).bootstrapTable();
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

function agregarActuacion(idEtapa)
{
  $('#modalAgregarActuacion').modal('show');

  var idTipoProceso = $("#idTipoProceso").val();
  var vigenciaRadicado = $("#vigenciaRadicado").val();
  var idRadicado = $("#idRadicado").val();

  var ruta = base_url +'/'+ 'actuacionesProcesales/agregarActuacion';
  var loader = '<img src="'+base_url+'/img/loader.gif">';

  var rutaArchivo = base_url +'/'+ 'actuacionesProcesales/uploadArchivoActuacion';

  var parametros = {
    "idEtapa" : idEtapa,
    "idTipoProceso": idTipoProceso,
    "vigenciaRadicado": vigenciaRadicado,
    "idRadicado": idRadicado
  };

  $.ajax({
    data:  parametros,
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoAgregarActuacion").html(responseText);
      $('.datepicker').datepicker({
        dateFormat: "yy-mm-dd",
        todayBtn: "linked",
      });
      $(".select2").select2({ width: '100%' });
      Dropzone.autoDiscover = false;
      var myDropzonePost = new Dropzone("#dropzoneActuacion",{
        autoProcessQueue: false,
        url: rutaArchivo,
        addRemoveLinks: true,
        maxFiles: 10,
        parallelUploads: 10,
        init: function (){
          // Update selector to match your button
          this.on('sending', function(file, xhr, formData)
          {
            var idActuacion = $("#idActuacion").val();
            // Append all form inputs to the formData Dropzone will POST
            var data = $('#dropzoneActuacion').serializeArray();
            formData.append("vigenciaRadicado",vigenciaRadicado);
            formData.append("idRadicado",idRadicado);
            formData.append("idActuacion",idActuacion);
          });
        },
        queuecomplete: function (file) {

            var tipoFinaliza = $('#tipoFinaliza').val();
            var idResponsable = $('#idResponsable').val();

            $('#modalAgregarActuacion').modal('hide');

            if(tipoFinaliza == 0)// no finaliza proceso
            {
              swal("Guardado!", "La actuación ha sido guardada exitosamente.", "success");
              setTimeout(function () {
                actuacionesEtapa(idEtapa);
              }, 1000);
            }
            else// finaliza el proceso
            {
              swal("Finalizado!", "El proceso ha finalizado.", "success");
              var rutaRedirect = base_url +'/'+ 'mis-procesos/index/0/0/'+idResponsable;
              setTimeout(function(){  window.location.href = rutaRedirect; }, 1000);
            }
        },
        error: function(file, message) {
          swal ( "Oops" ,  "Ocurrio algun error, Contacte al administrador!" ,  "error" )
        }
      });
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

function configuracionTipoActuacion(idEtapa, tipoProceso)
{
  var selectTipoActuacion = $("#selectTipoActuacion").val();

  if(selectTipoActuacion == "")
  {
    swal({
      title: "Campo sin diligenciar!",
      text: "Seleccione el tipo de actuacion",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  var ruta = base_url +'/'+ 'actuacionesProcesales/configuracionTipoActuacion';

  var parametros = {
    "selectTipoActuacion" : selectTipoActuacion,
  };

  $.ajax({
    data:  parametros,
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      if(responseText.tipoFinal == 1)// es para finalizar el proceso
      {
        swal({
            title: "¿Está seguro de terminar el proceso?",   
            text: "El tipo de actuación seleccionado termina el proceso!",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#f8b32d",   
            confirmButtonText: "Sí, terminarlo!",   
            closeOnConfirm: false 
        }, function(){   
            validarGuardarActuProce(idEtapa, tipoProceso, 1, 0);//es para finalizar
        });
      }
      else if(responseText.tipoFallo == 1)// es para el fallo
      {
        validarGuardarActuProce(idEtapa, tipoProceso, 0, 1);// es tipo fallo
      }
      else
      {
        validarGuardarActuProce(idEtapa, tipoProceso, 0, 0);// es historial normal
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

function agregarTipoFallo(idTipoActuacion)
{
  var ruta = base_url +'/'+ 'actuacionesProcesales/agregarTipoFallo';

  var parametros = {
    "idTipoActuacion": idTipoActuacion
  };

  $.ajax({
    data:  parametros,
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      if(responseText.tipoFallo == 1)
      {
        $("#resultadoTipoFallo").html(responseText.vista);
        $(".select2").select2({ width: '100%' });
      }
      else
      {
        $("#resultadoTipoFallo").empty();
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

function validarGuardarActuProce(idEtapa, tipoProceso, finaliza, fallo)
{
  var selectJuzgado = $("#selectJuzgado").val();
  var selectTipoActuacion = $("#selectTipoActuacion").val();
  var fechaActuProce = $("#fechaActuProce").val();
  var comentarioActuacion = $("#comentarioActuacion").val();
  var vigenciaRadicado = $("#vigenciaRadicado").val();
  var idRadicado = $("#idRadicado").val();
  var idEstadoEtapa = $("#idEstadoEtapa").val();
  var selectTipoFallo = $("#selectTipoFallo").val();

  if(selectJuzgado == "")
  {
    swal({
      title: "Campo sin diligenciar!",
      text: "Seleccione el despacho",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  if(selectTipoActuacion == "")
  {
    swal({
      title: "Campo sin diligenciar!",
      text: "Seleccione el tipo de actuacion",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  if(fechaActuProce == "")
  {
    swal({
      title: "Campo sin diligenciar!",
      text: "Seleccione la fecha de actuación",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  if(comentarioActuacion == "")
  {
    swal({
      title: "Campo sin diligenciar!",
      text: "Ingrese un comentario",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  if(fallo == 1)
  {
    if(selectTipoFallo == "")
    {
      swal({
        title: "Campo sin diligenciar!",
        text: "Seleccione el sentido del fallo",
        confirmButtonColor: "#f33923",
      });
      return false;
    }
  }

  var ruta = base_url +'/'+ 'actuacionesProcesales/validarGuardarActuProce';

  var parametros = {
    "idEtapa": idEtapa,
    "selectTipoActuacion" : selectTipoActuacion,
    "selectJuzgado": selectJuzgado,
    "fechaActuProce": fechaActuProce,
    "comentarioActuacion": comentarioActuacion,
    "vigenciaRadicado":vigenciaRadicado,
    "idRadicado": idRadicado,
    "idEstadoEtapa":idEstadoEtapa,
    "fallo": fallo,
    "selectTipoFallo": selectTipoFallo,
    "tipoProceso": tipoProceso
  };

  $.ajax({
    data:  parametros,
    url:   ruta,
    type:  'post',
    beforeSend: function(){
      $('.btn-guardar-actuPro').html('<span class="fa fa-spinner fa-spin"></span> Procesando...');
      $('.btn-guardar-actuPro').css({ 'pointer-events': 'none' });
    },
    success:  function (responseText) {
      $("#idActuacion").val(responseText.idActuacion);
      $('#tipoFinaliza').val(responseText.tipoFinaliza);
      $('#idResponsable').val(responseText.idResponsable);
      var myDropzone = Dropzone.forElement("#dropzoneActuacion");
      myDropzone.processQueue();
      if(Object.keys(myDropzone.files).length == 0){
        $('#modalAgregarActuacion').modal('hide');

        if(responseText.tipoFinaliza == 0)// no finaliza proceso
        {
          swal("Guardado!", "La actuación ha sido guardada exitosamente.", "success");
          setTimeout(function () {
            actuacionesEtapa(idEtapa);
          }, 1000);
        }
        else// finaliza el proceso
        {
          swal("Finalizado!", "El proceso ha finalizado.", "success");
          var rutaRedirect = base_url +'/'+ 'mis-procesos/index/0/0/'+responseText.idResponsable;
          setTimeout(function(){  window.location.href = rutaRedirect; }, 1000);
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

function eliminarArchivo(idArchivo, idEtapa)
{
  swal({
    title: "Está seguro de eliminar el archivo?",
    text: "Se eliminará el arhivo de la base de datos!",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#f8b32d",
    confirmButtonText: "Sí, eliminarlo!",
    closeOnConfirm: false
  }, function(){
    validarEliminarArchivo(idArchivo, idEtapa);
  });
}

function validarEliminarArchivo(idArchivo, idEtapa)
{
  var ruta = base_url +'/'+ 'actuacionesProcesales/validarEliminarArchivo';

  var parametros = {
    "idArchivo": idArchivo
  };

  $.ajax({
    data:  parametros,
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      swal("Eliminado!", "El archivo ha sido eliminado de la base de datos.", "success");
      actuacionesEtapa(idEtapa);
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

function eliminarActuacion(idActuacion, idEtapa)
{
  swal({
    title: "Está seguro de eliminar la actuación?",
    text: "Se eliminará la actuación y sus archivos de la base de datos!",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#f8b32d",
    confirmButtonText: "Sí, eliminarlo!",
    closeOnConfirm: false
  }, function(){
    validarEliminarActuacion(idActuacion, idEtapa);
  });
}

function validarEliminarActuacion(idActuacion, idEtapa)
{
  var ruta = base_url +'/'+ 'actuacionesProcesales/validarEliminarActuacion';

  var parametros = {
    "idActuacion": idActuacion
  };

  $.ajax({
    data:  parametros,
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      swal("Eliminada!", "La actuación ha sido eliminada con sus archivos.", "success");
      actuacionesEtapa(idEtapa);
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

function tipoActuacionSeleccionada(idTipoEstadoActuacion)
{
  var idTipoProceso = $("#idTipoProceso").val();

  var ruta = base_url +'/'+ 'actuacionesProcesales/tipoActuacionSeleccionada';

  var parametros = {
    "idTipoEstadoActuacion": idTipoEstadoActuacion,
    "idTipoProceso": idTipoProceso
  };

  $.ajax({
    data:  parametros,
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoTipoActuación").html(responseText);
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

function editarActuacion(idActuacion, idEtapa)
{
  $('#modalEditarActuacion').modal('show');

  var vigenciaRadicado = $("#vigenciaRadicado").val();
  var idRadicado = $("#idRadicado").val();

  var ruta = base_url +'/'+ 'actuacionesProcesales/editarActuacion';
  var rutaArchivo = base_url +'/'+ 'actuacionesProcesales/uploadArchivoActuacion';

  var parametros = {
    "idActuacion": idActuacion,
    "idEtapa": idEtapa
  };

  $.ajax({
    data:  parametros,
    url:   ruta,
    type:  'post',
    beforeSend: function(){
      cargaLoader('Editar actuación.  Un momento por favor..');
    },
    success:  function (responseText) {
      ocultaLoader();
      $("#resultadoEditarActuacion").html(responseText);
      $(".select2").select2({ width: '100%' });
      $('.datepicker').datepicker({
        dateFormat: "yy-mm-dd",
        todayBtn: "linked",
      });
      Dropzone.autoDiscover = false;
      var myDropzonePost = new Dropzone("#dropzoneActuacionEdit",
      {
        autoProcessQueue: false,
        url: rutaArchivo,
        addRemoveLinks: true,
        maxFiles: 10,
        parallelUploads: 10,
        init: function (){
          // Update selector to match your button
          this.on('sending', function(file, xhr, formData)
          {
            // Append all form inputs to the formData Dropzone will POST
            var data = $('#dropzoneActuacionEdit').serializeArray();
            formData.append("vigenciaRadicado",vigenciaRadicado);
            formData.append("idRadicado",idRadicado);
            formData.append("idActuacion",idActuacion);
          });
        },
        queuecomplete: function (file) {
          $('#modalEditarActuacion').modal('hide');
          swal("Guardado!", "La actuación ha sido Modificada exitosamente.", "success");
            setTimeout(function () {
              actuacionesEtapa(idEtapa);
          }, 1000);
        },
        error: function(file, message) {
          swal ( "Oops" ,  "Ocurrio algun error, Contacte al administrador!" ,  "error" )
        }
      });
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

function validarEditarActuacion(idActuacion, idEtapa, tipoProceso)
{
  var selectJuzgadoEdit = $("#selectJuzgadoEdit").val();
  var fechaActuProceEdit = $("#fechaActuProceEdit").val();
  var comentarioActuacionEdit = $("#comentarioActuacionEdit").val();

  if(selectJuzgadoEdit == "")
  {
    swal({
      title: "Campo sin diligenciar!",
      text: "Seleccione el despacho",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  if(fechaActuProceEdit == "")
  {
    swal({
      title: "Campo sin diligenciar!",
      text: "Seleccione la fecha de actuación",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  if(comentarioActuacionEdit == "")
  {
    swal({
      title: "Campo sin diligenciar!",
      text: "Ingrese un comentario",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  var ruta = base_url +'/'+ 'actuacionesProcesales/validarEditarActuacion';

  var parametros = {
    "idActuacion": idActuacion,
    "selectJuzgadoEdit" : selectJuzgadoEdit,
    "fechaActuProceEdit": fechaActuProceEdit,
    "comentarioActuacionEdit": comentarioActuacionEdit,
    "tipoProceso": tipoProceso
  };

  $.ajax({
    data:  parametros,
    url:   ruta,
    type:  'post',
    beforeSend: function(){
      $('.btn-editar-actuPro').html('<span class="fa fa-spinner fa-spin"></span> Procesando...');
      $('.btn-editar-actuPro').css({ 'pointer-events': 'none' });
    },
    success:  function (responseText) {
      var myDropzone = Dropzone.forElement("#dropzoneActuacionEdit");
      myDropzone.processQueue();
      if(Object.keys(myDropzone.files).length == 0){
        $('#modalEditarActuacion').modal('hide');
        swal("Guardado!", "La actuación ha sido Modificada exitosamente.", "success");
          setTimeout(function () {
            actuacionesEtapa(idEtapa);
        }, 1000);
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