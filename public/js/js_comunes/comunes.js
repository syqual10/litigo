var base_url = $('meta[name="base_url"]').attr('content'); 

function agregarTema() {
  $("#modalAgregarTema").modal("show");

  var ruta = base_url + "/" + "proceso-judic/agregarTema";

  $.ajax({
    url: ruta,
    type: "post",
    success: function (responseText) {
      $("#resultadoAgregarTema").html(responseText);
    },
    error: function (responseText) {
      error(responseText);
    },
  });
}


function validarGuardarTema() {
  var nombreTema = $("#nombreTema").val();

  if (nombreTema == "") {
    swal({
      title: "Campo sin diligenciar!",
      text: "Debe ingresar el nombre del tema",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  var ruta = base_url + "/" + "proceso-judic/validarGuardarTema";

  var parametros = {
    nombreTema: nombreTema,
  };

  $.ajax({
    data: parametros,
    url: ruta,
    type: "post",
    beforeSend: function () {
      cargaLoader("Guardando el tema.  Un momento por favor..");
      $(".btn-guardar-tema").html(
        '<span class="fa fa-spinner fa-spin"></span> Procesando...'
      );
      $(".btn-guardar-tema").css({ "pointer-events": "none" });
    },
    success: function (responseText) {
      ocultaLoader();
      $("#modalAgregarTema").modal("hide");
      if (responseText.temaRegistrado == 0) {
        swal({
          title: "Atención!",
          text: "Tema ya se encuentra registrado, y lo hemos seleccionado.",
          confirmButtonColor: "#f33923",
        });
      } else {
        swal("Guardado!", "El tema ha sido guardado exitosamente.", "success");
      }
      console.log(responseText.idTema, "idTema retornado");
      temas(responseText.idTema);
    },
    error: function (responseText) {
      error(responseText);
    },
  });
}

function temas(idTemaSeleccionado) {
  var ruta = base_url + "/" + "proceso-judic/temas";

  $.ajax({
    url: ruta,
    data: { idTemaSeleccionado },
    type: "post",
    success: function (responseText) {
      $("#resultadoTemas").html(responseText);
      $(".select2").select2({ width: "100%" });
    },
    error: function (responseText) {
      error(responseText);
    },
  });
}

function error(responseText) {
  switch (responseText.status) {
    case 500:
      const respuesta = JSON.parse(responseText.responseText);

      swal({
        title: respuesta.error.message,
        text: "Se presentó un error | " + respuesta.error.type,
        confirmButtonColor: "#f33923",
      });

      console.error("Error " + responseText.status + " " + responseText);
      break;
    case 401:
      swal(
        {
          title: "Su sesión se ha desconectado",
          text: "Por favor loguearse nuevamente!",
          type: "warning",
          confirmButtonColor: "#f8b32d",
          confirmButtonText: "Entendido!",
        },
        function () {
          var rutaRedirect = base_url + "/" + "login";
          window.location.href = rutaRedirect;
        }
      );
      break;
  }
  return;
}

function inicializarTablaReportes(nombreTabla)
{
  /* BASIC ;*/
  var responsiveHelper_dt_basic = undefined;
  var responsiveHelper_datatable_fixed_column = undefined;
  var responsiveHelper_datatable_col_reorder = undefined;
  var responsiveHelper_datatable_tabletools = undefined;

  var breakpointDefinition = {
      tablet : 1024,
      phone : 480
  };

  $('#'+nombreTabla).dataTable({
      "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+
          "t"+
          "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
      "autoWidth" : true,
      "oLanguage": {
          "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
      },
      "preDrawCallback" : function() {
          // Initialize the responsive datatables helper once.
          if (!responsiveHelper_dt_basic) {
              responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#'+nombreTabla), breakpointDefinition);
          }
      },
      "rowCallback" : function(nRow) {
          responsiveHelper_dt_basic.createExpandIcon(nRow);
      },
      "drawCallback" : function(oSettings) {
          responsiveHelper_dt_basic.respond();
      }
  });
  /* END BASIC */
}

function verArchivoPdf(idArchivo, vigenciaRadicado, idRadicado)
{ 
  //--------------GENERA PDF ------------------------------------------------
  //Carga el pdf generado
  //Lanza la modal
  $('#modalPdfGenerado').modal('show');
  //Carga el pdf en el iframe
  var rutaRedirect = base_url +'/'+ 'juridica/verArchivoPdf'; 
  document.getElementById("framePdf").src = rutaRedirect +"/"+ idArchivo+"/"+ vigenciaRadicado+"/"+ idRadicado;
  //--------------------------------------------------------------------------    
}

function verArchivoPdfMigrado(consecutivo)
{ 
  console.log('consecutivo', consecutivo)
  //--------------GENERA PDF ------------------------------------------------
  //Carga el pdf generado
  //Lanza la modal
  $('#modalPdfGenerado').modal('show');
  //Carga el pdf en el iframe
  var rutaRedirect = base_url +'/'+ 'juridica/verArchivoMigradoPdf'+"/"+ consecutivo;
  //var rutaRedirect = base_url +'/'+ 'foo';

  document.getElementById("framePdf").src = rutaRedirect;
}

function instanciasProceso(idTipoProceso, ver)
{
  var ruta = base_url +'/'+ 'juridica/instanciasProceso';

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
      etapasInstancia(responseText.instanciaInicial, ver)
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

function etapasInstancia(idInstancia, ver)
{
  var ruta = base_url +'/'+ 'juridica/etapasInstancia';

  var parametros = {
    "idInstancia" : idInstancia,
    "noAgregar": 1
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
      actuacionesEtapa(responseText.etapaInicial, ver);
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

function actuacionesEtapa(idEtapa, ver)
{
  var vigenciaRadicado = $("#vigenciaRadicado").val();
  var idRadicado = $("#idRadicado").val();

  var ruta = base_url +'/'+ 'juridica/actuacionesEtapa';

  var parametros = {
    "idEtapa": idEtapa,
    "vigenciaRadicado": vigenciaRadicado,
    "idRadicado":idRadicado,
    "ver": ver
  };

  $.ajax({
    data:  parametros,
    url:   ruta,
    type:  'post',
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

function expedienteDigital(vigenciaRadicado, idRadicado)
{
  var vigenciaRadicado = $("#vigenciaRadicado").val();
  var idRadicado = $("#idRadicado").val();
  
  var ruta = base_url +'/'+ 'juridica/expedienteDigital';

  var parametros = {
    "vigenciaRadicado": vigenciaRadicado,
    "idRadicado":idRadicado
  };

  $.ajax({
    data:  parametros,
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoExpedienteDigital").html(responseText);
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

function expedienteDigitalMigrados(mzlConsecutivo)
{
  var mzlConsecutivo = $("#mzlConsecutivo").val();
  
  var ruta = base_url +'/'+ 'juridica/expedienteDigitalMigrados';

  var parametros = {
    "mzlConsecutivo": mzlConsecutivo
  };

  $.ajax({
    data:  parametros,
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#ajax-migrados").html(responseText);
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

function descargarPoder()
{
  var idEstadoEtapa = $("#idEstadoEtapa").val();
  var vigenciaRadicado = $("#vigenciaRadicado").val();
  var idRadicado       = $("#idRadicado").val();

  var parametros = {
    "vigenciaRadicado" : vigenciaRadicado,
    "idRadicado": idRadicado,
    "idEstadoEtapa": idEstadoEtapa
  };

  var vector = JSON.stringify(parametros); 
  
  var rutaRedirect = base_url +'/'+ 'juridica/descargarPoder'; 

  window.location.href = rutaRedirect+"/"+vector;
}

function cambiarPass()
{
  $('#modalCambiarPass').modal('show');

  var ruta = base_url +'/'+ 'juridica/cambiarPass';

  $.ajax({
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoCambiarPass").html(responseText);
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

function validarNuevaPass(idUsuario, documento)
{
  var actualPass  = $("#actualPass").val();
  var nuevaPass   = $("#nuevaPass").val();
  var confirmPass = $("#confirmPass").val();

  if(actualPass == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Ingrese la actual contraseña",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(nuevaPass == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Ingrese la nueva contraseña",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(confirmPass == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Confirme la contraseña",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(nuevaPass != confirmPass)
  {
    swal({   
      title: "Atención!",   
      text: "Las contraseñas no coinciden",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(nuevaPass == documento)
  {
    swal({   
      title: "Atención!",   
      text: "La contraseña no puede ser el documento",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  var ruta = base_url +'/'+ 'juridica/validarNuevaPass';

  var parametros = {
    "idUsuario" : idUsuario,
    "nuevaPass" : nuevaPass,
    "actualPass":actualPass
  };

  $.ajax({
    data:  parametros,
    url:   ruta,
    type:  'post',
    beforeSend: function(){
      cargaLoader('Cambiando contraseña.  Un momento por favor..');
    },
    success:  function (responseText) {
      ocultaLoader();
      if(responseText == 0)
      {
        swal({   
          title: "Atención!",   
          text: "La contraseña actual no es correcta",   
          confirmButtonColor: "#f33923",   
        });
        return false;
      }
      else
      {
        swal("Guardado!", "La contraseña se cambió exitosamente.", "success"); 
        $('#modalCambiarPass').modal('hide');
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

function actualizarPerfil()
{
  $('#modalActualizarPerfil').modal('show');

  var ruta = base_url +'/'+ 'juridica/actualizarPerfil';

  $.ajax({
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoActualizarPerfil").html(responseText);
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

function validarModificarUsuario()
{
  var documentoUsuario  = $("#documentoUsuario").val();
  var nombreUsuario   = $("#nombreUsuario").val();
  var celularUsuario = $("#celularUsuario").val();
  var emailUsuario = $("#emailUsuario").val();

  if($("#notificacionCorreo").is(':checked'))
  {
    var notificacionCorreo = 1;
  }
  else
  {
    var notificacionCorreo = 0;
  }  

  if($("#notificacionSms").is(':checked'))
  {
    var notificacionSms = 1;
  }
  else
  {
    var notificacionSms = 0;
  }  
  
  if(documentoUsuario == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Ingrese el documento",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(nombreUsuario == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Ingrese el nombre",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(celularUsuario !='')
  {
    var expresionRegular1 =/^[3]([0-9]+){9}$/;//<--- con esto vamos a validar el numero-->
    if(!expresionRegular1.test(celularUsuario))
    {
      swal({   
        title: "Atención!",   
        text: "Celular incorrecto",   
        confirmButtonColor: "#f33923",   
      });
      return false;
    }
  }

  var reg= /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/; 
  if(emailUsuario !='')
    {
    if (!reg.test(emailUsuario)) 
    { 
      swal({   
        title: "Atención!",   
        text: "Correo incorrecto",   
        confirmButtonColor: "#f33923",   
      });
      return false;
    }
  }

  var ruta = base_url +'/'+ 'juridica/validarModificarUsuario';

  var parametros = {
    "documentoUsuario" : documentoUsuario,
    "nombreUsuario" : nombreUsuario,
    "celularUsuario":celularUsuario,
    "emailUsuario":emailUsuario,
    "notificacionCorreo":notificacionCorreo,
    "notificacionSms":notificacionSms
  };

  $.ajax({
    data:  parametros,
    url:   ruta,
    type:  'post',
    beforeSend: function(){
      cargaLoader('Modificando datos.  Un momento por favor..');
    },
    success:  function (responseText) {
      ocultaLoader();
      if(responseText == 0)
      {
        swal({   
          title: "Atención!",   
          text: "El documento ya se encuentra registrado",   
          confirmButtonColor: "#f33923",   
        });
        return false;
      }
      else
      {
        swal("Guardado!", "Los datos han sido modificados exitosamente.", "success"); 
        $('#modalActualizarPerfil').modal('hide');
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

function filtrarMetodoBuscar(selectMetodoBusqueda)
{
  $("#criterioBusquedaJuz").val("")
  $("#criterioBusqueda").val("")
  /*
    selectMetodoBusqueda es 1 radicado interno
    selectMetodoBusqueda es 2 documento demandante
    selectMetodoBusqueda es 3 nombre demandante
    selectMetodoBusqueda es 4 tema
    selectMetodoBusqueda es 5 radicado juzgado
    selectMetodoBusqueda es 6 radicado anterior
  */
  if(selectMetodoBusqueda == 1)
  {
    $("#divVigenciaBuscar").css("display", "block");
  }
  else
  {
    $("#divVigenciaBuscar").css("display", "none"); 
  }

  if(selectMetodoBusqueda == 5)
  {
    $("#divRadicadoJuzgado").css("display", "block");
    $("#divRadicadoSyqual").css("display", "none"); 
  }
  else
  {
    $("#divRadicadoJuzgado").css("display", "none"); 
    $("#divRadicadoSyqual").css("display", "block"); 
  }
}


function pretensiones()
{
  var vigenciaRadicado = $("#vigenciaRadicado").val();
  var idRadicado = $("#idRadicado").val();

  var ruta = base_url +'/'+ 'proviCalifica/pretensiones';
  
  var parametros = {  
    "vigenciaRadicado":vigenciaRadicado,
    "idRadicado":idRadicado
  };
  
  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoValorPretensiones").html(responseText);
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

function diaSemana() 
{
  var dias = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
  var f = new Date();

  if(dias[f.getDay()] ==  "Viernes")
  {
    return "Domingo";
  }
  else if(dias[f.getDay()] == "Sábado")
  {
    return "Lunes";
  }
  else
  {
    return dias[f.getDay()+2];  
  }
}

function tareasInformativas(parametroFecha)
{
  var ruta = base_url +'/'+ 'juridica/tareasInformativas';
  
  var parametros = {  
    "parametroFecha":parametroFecha
  };
  
  $.ajax({                
    data:  parametros,
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoTareasInformativas").html(responseText.vista);
      $("#labelHoy").text("Hoy "+"("+responseText.cantTareasH+")");
      $("#labelMañana").text("Mañana "+"("+responseText.cantTareasM+")");
      $("#labelDosDias").text(diaSemana() + "("+responseText.cantTareasDosDias+")");
       var sumaTareas = parseInt(responseText.cantTareasH)+parseInt(responseText.cantTareasM)+parseInt(responseText.cantTareasDosDias);
      $("#labelContador").text(sumaTareas);
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

function nuevoArchivo()
{
  $('#modalAgregarArchivo').modal('show');

  var ruta = base_url +'/'+ 'juridica/nuevoArchivo';

  var rutaArchivo = base_url +'/'+ 'juridica/uploadNuevoArchivo';

  $.ajax({
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoAgregarArchivo").html(responseText);
      Dropzone.autoDiscover = false;
      var myDropzonePost = new Dropzone("#dropzoneNuevoArchivo",{
        autoProcessQueue: false,
        url: rutaArchivo,
        addRemoveLinks: true,
        maxFiles: 10,
        parallelUploads: 10,
        init: function (){
          // Update selector to match your button
          this.on('sending', function(file, xhr, formData)
          {
            var vigenciaRadicado = $("#vigenciaRadicado").val();
            var idRadicado = $("#idRadicado").val();
            // Append all form inputs to the formData Dropzone will POST
            var data = $('#dropzoneNuevoArchivo').serializeArray();
            formData.append("vigenciaRadicado",vigenciaRadicado);
            formData.append("idRadicado",idRadicado);
          });
        },
        queuecomplete: function (file) {
          swal("Guardado!", "El archivo fue adjuntado correctamente.", "success");
          $('#modalAgregarArchivo').modal('hide');
          setTimeout(function () {
            archivosIniciales();
          }, 2500);
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

function validarGuardarNuevoArchivo()
{
  var myDropzone = Dropzone.forElement("#dropzoneNuevoArchivo");
  myDropzone.processQueue();
  if(Object.keys(myDropzone.files).length == 0){
    swal("Guardado!", "El archivo fue adjuntado correctamente.", "success");
    $('#modalAgregarArchivo').modal('hide');
    setTimeout(function () {
      archivosIniciales();
    }, 2500);
  }  
}

function archivosIniciales()
{
  var responsable = $("#responsable").val();
  var vigenciaRadicado = $("#vigenciaRadicado").val();
  var idRadicado = $("#idRadicado").val();

  var ruta = base_url +'/'+ 'juridica/archivosIniciales';

  var parametros = {  
    "vigenciaRadicado" : vigenciaRadicado,
    "idRadicado" : idRadicado,
    "responsable":responsable
  };
  
  $.ajax({                
    data:  parametros,               
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoArchivosIniciales").html(responseText);
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

function cargarValoracionesFalloComun(vigencia, idRadicado)
{
    var ruta = base_url +'/'+ 'valoraFallo/cargarValoracionesFallo';

    var parametros = {  
        "vigenciaRadicado" : vigenciaRadicado,
        "idRadicado" : idRadicado,
        "administrar" : 0
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

function repartoInterno()
{
  $('#modalRepartoInterno').modal('show');

  var ruta = base_url +'/'+ 'juridica/repartoInterno';

  $.ajax({
    url:   ruta,
    type:  'post',
    beforeSend: function(){
      cargaLoader('Reparto Interno.  Un momento por favor..');
    },
    success:  function (responseText) {
      ocultaLoader();
      $("#resultadoRepartoInterno").html(responseText);
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

function validarGuardarRespInterno(idResponsable)
{
  var idEstadoEtapa = $("#idEstadoEtapa").val();
  var selectRespInterno = $("#selectRespInterno").val();
  var comentarioReparto = $("#comentarioReparto").val();

  if(selectRespInterno == "")
  {
    swal({
      title: "Campo sin diligenciar!",
      text: "Seleccione el destinatario",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  if(comentarioReparto == "")
  {
    swal({
      title: "Campo sin diligenciar!",
      text: "Ingrese la observación",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  var ruta = base_url +'/'+ 'juridica/validarGuardarRespInterno';

  var parametros = {
    "idResponsable": idResponsable,
    "comentarioReparto" : comentarioReparto,
    "idEstadoEtapa": idEstadoEtapa,
    "selectRespInterno": selectRespInterno
  };

  $.ajax({
    data:  parametros,
    url:   ruta,
    type:  'post',
    beforeSend: function(){
      $('.btn-guardar-repInt').html('<span class="fa fa-spinner fa-spin"></span> Procesando...');
      $('.btn-guardar-repInt').css({ 'pointer-events': 'none' });
    },
    success:  function (responseText) {
      socket.emit("server_nuevoEnBuzon", {idUsuarioSiguiente: responseText, mensaje: "Le fue asignado el radicado: " + vigenciaRadicado + "-" + idRadicado + ", por favor revise su buzón."});
      swal("Guardado!", "Reparto interno realizado exitosamente.", "success");
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

function removerCuantia(idCuantia)
{
  swal({   
    title: "Está seguro de eliminar la cuantía?",   
    text: "Se eliminará la cuantía de la base de datos!",   
    type: "warning",   
    showCancelButton: true,   
    confirmButtonColor: "#f8b32d",   
    confirmButtonText: "Sí, eliminar!",   
    closeOnConfirm: false 
  }, function(){   
    validarEliminarCuantia(idCuantia);
  });
}

function validarEliminarCuantia(idCuantia)
{
  var ruta = base_url +'/'+ 'juridica/validarEliminarCuantia';

  var parametros = {
    "idCuantia": idCuantia
  };

  $.ajax({
    data:  parametros,
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      swal("Guardado!", "La cuantía ha sido eliminada exitosamente.", "success");
      cuantiasRadicado();
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

function eliminarArchivoCausa(idArchivo)
{
  swal({   
    title: "Está seguro de eliminar el archivo?",   
    text: "Se eliminará el archivo de la base de datos!",   
    type: "warning",   
    showCancelButton: true,   
    confirmButtonColor: "#f8b32d",   
    confirmButtonText: "Sí, eliminar!",   
    closeOnConfirm: false 
  }, function(){   
    validarEliminarArchivoCausa(idArchivo);
  });
}

function validarEliminarArchivoCausa(idArchivo)
{
  var ruta = base_url +'/'+ 'juridica/validarEliminarArchivoCausa';

  var parametros = {
    "idArchivo": idArchivo
  };

  $.ajax({
    data:  parametros,
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      swal("Guardado!", "El archivo ha sido eliminado exitosamente.", "success");
      archivosIniciales();
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

function cuantiasRadicado()
{
  var vigenciaRadicado = $("#vigenciaRadicado").val();
  var idRadicado = $("#idRadicado").val();

  var ruta = base_url +'/'+ 'juridica/cuantiasRadicado';

  var parametros = {
    "vigenciaRadicado": vigenciaRadicado,
    "idRadicado":idRadicado
  };

  $.ajax({
    data:  parametros,
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoCuantiaRadicado").html(responseText);
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

function nuevaCuantia()
{
  $('#modalAgregarCuantia').modal('show');

  var ruta = base_url +'/'+ 'juridica/nuevaCuantia';

  $.ajax({
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoAgregarCuantia").html(responseText);
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

function seleccionUnidadMonetaria(unidadMonetaria)
{
  $("#valor").val('');
  $("#valorSalarios").val('');
  $("#valorPesos").val('');

  if(unidadMonetaria == 1)// salarios mínimos
  {
    $("#divSalariosMinimos").css("display", "block"); 
    $("#divValores").css("display", "block");   
    $("#divPesos").css("display", "none");   
  }
  else if(unidadMonetaria == 2) // pesos
  {
    $("#divPesos").css("display", "block");   
    $("#divValores").css("display", "block");   
    $("#divSalariosMinimos").css("display", "none"); 
  }
  else// ninguna
  {
    $("#divPesos").css("display", "none");   
    $("#divSalariosMinimos").css("display", "none"); 
    $("#divValores").css("display", "none");   
  }
}

function format(input)
{
  var num = input.value.replace(/\./g,'');
  if(!isNaN(num))
  {
    num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
    num = num.split('').reverse().join('').replace(/^[\.]/,'');
    input.value = num;
  }
  else
  { 
    swal({   
      title: "Atención!",   
      text: "Sólo se permiten números",   
      confirmButtonColor: "#f33923",   
    });
    input.value = input.value.replace(/[^\d\.]*/g,'');
  }
}

function justNumbers(e)
{
  var keynum = window.event ? window.event.keyCode : e.which;
  if ((keynum == 8) || (keynum == 46))
    return true;

  return /\d/.test(String.fromCharCode(keynum));
}

function copiar()
{
  var valor = document.getElementById('valor').value;
  if(document.getElementById('valor').value != "")
  {
    document.getElementById('valorPesos').value = "$ "+valor;
  }
}

function salarioAPesos(input)
{
  if(document.getElementById('valorSalarios').value != "")
  {
    var slv = $("#slv").val();//salario legal vigente
    valorSalarios = document.getElementById('valorSalarios').value.replace(".", "");
    var total = slv*valorSalarios;
    total = total.toLocaleString();
    document.getElementById('valorPesos').value = "$ "+total;
  }
}

function validarGuardarCuantia()
{
  var vigenciaRadicado = $("#vigenciaRadicado").val();
  var idRadicado = $("#idRadicado").val();
  var selectUnidadMonetaria = $("#selectUnidadMonetaria").val();
  var valor = $("#valor").val();
  var valorSalarios = $("#valorSalarios").val();
  var valorPesos = $("#valorPesos").val();

  if(selectUnidadMonetaria == 0)
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Seleccione la unidad monetaria",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(selectUnidadMonetaria == 1)// SALARIOS MÍNIMOS
  {
    valor = valorSalarios;
    if(valorSalarios == '')
    {
      swal({   
        title: "Campo sin diligenciar!",   
        text: "Ingresar el número de salarios",   
        confirmButtonColor: "#f33923",   
      });
      return false;
    }
  }

  if(selectUnidadMonetaria == 2)// VALOR EN PESOS
  {
    if(valor == '')
    {
      swal({   
        title: "Campo sin diligenciar!",   
        text: "Ingresar el valor en pesos",   
        confirmButtonColor: "#f33923",   
      });
      return false;
    }
  }

  valorPesos   = valorPesos.replace("$", "");

  var ruta = base_url +'/'+ 'juridica/validarGuardarCuantia';

  var parametros = {
    "vigenciaRadicado": vigenciaRadicado,
    "idRadicado": idRadicado,
    "selectUnidadMonetaria": selectUnidadMonetaria,
    "valor" : valor,
    "valorPesos": valorPesos
  };

  $.ajax({
    data:  parametros,
    url:   ruta,
    type:  'post',
    beforeSend: function(){
      $('.btn-guardar-cuantia').html('<span class="fa fa-spinner fa-spin"></span> Procesando...');
      $('.btn-guardar-cuantia').css({ 'pointer-events': 'none' });
    },
    success:  function (responseText) {
      swal("Guardado!", "Cuantía guardada exitosamente.", "success");
      cuantiasRadicado();
      $('#modalAgregarCuantia').modal('hide');
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

function nuevaDependenciaProceso(tipoInvolucrado)
{
  $('#modalAgregarDepenProceso').modal('show');

  var ruta = base_url +'/'+ 'juridica/nuevaDependenciaProceso';

  var parametros = {
    "tipoInvolucrado" : tipoInvolucrado
  };

  $.ajax({
    data:  parametros,
    url:   ruta,
    type:  'post',
    beforeSend: function(){
      cargaLoader('Agregar dependencia al proceso.  Un momento por favor..');
    },
    success:  function (responseText) {
      ocultaLoader();
      $("#resultadoAgregarDepenProceso").html(responseText);
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

function validarGuardarInvolucradoDepen(tipoInvolucrado)
{
  var vigenciaRadicado = $("#vigenciaRadicado").val();
  var idRadicado = $("#idRadicado").val();
  var selectDepenProceso = $("#selectDepenProceso").val();
  
  if(selectDepenProceso == '')
  {
    swal({   
      title: "Atención!",   
      text: "Por favor seleccione una dependencia",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  var ruta = base_url +'/'+ 'juridica/validarGuardarInvolucradoDepen';

  var parametros = {
    "vigenciaRadicado" : vigenciaRadicado,
    "idRadicado" : idRadicado,
    "selectDepenProceso": selectDepenProceso,
    "tipoInvolucrado": tipoInvolucrado
  };

  $.ajax({
    data:  parametros,
    url:   ruta,
    type:  'post',
    beforeSend: function(){
      cargaLoader('Guardando nueva dependencia involucrada.  Un momento por favor..');
    },
    success:  function (responseText) {
      ocultaLoader();
      if(responseText == 0)
      {
        swal({   
          title: "Atención!",   
          text: "La dependencia ya se encuentra asociada al proceso",   
          confirmButtonColor: "#f33923",   
        });
        return false;
      }
      else
      {
        if(responseText == 3)
        {
          demandados();
        }

        if(responseText == 5)
        {
          convocadosInternos();
        }

        if(responseText == 8)
        {
          accionadosInternos();
        }
        swal("Guardado!", "La dependencia ha sido asociada exitosamente al proceso.", "success"); 
        $('#modalAgregarDepenProceso').modal('hide');
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

function nuevoExterno(tipoInvolucrado)
{
  $('#modalNuevoExterno').modal('show');

  var ruta = base_url +'/'+ 'juridica/nuevoExterno';

  var parametros = {
    "tipoInvolucrado" : tipoInvolucrado
  };

  $.ajax({
    data:  parametros,
    url:   ruta,
    type:  'post',
    beforeSend: function(){
      cargaLoader('Nueva Entidad Externa.  Un momento por favor..');
    },
    success:  function (responseText) {
      ocultaLoader();
      $("#resultadoNuevoExterno").html(responseText);
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

function validarGuardarNuevoExt(tipoInvolucrado)
{
  var vigenciaRadicado = $("#vigenciaRadicado").val();
  var idRadicado = $("#idRadicado").val();
  var nombreNuevoExterno = $("#nombreNuevoExterno").val();
  var direccionNuevoExterno = $("#direccionNuevoExterno").val();
  var telefonoNuevoExterno = $("#telefonoNuevoExterno").val();
  
  if(nombreNuevoExterno == '')
  {
    swal({   
      title: "Atención!",   
      text: "Por favor ingrese el nombre",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  var ruta = base_url +'/'+ 'juridica/validarGuardarNuevoExt';

  var parametros = {
    "vigenciaRadicado" : vigenciaRadicado,
    "idRadicado" : idRadicado,
    "nombreNuevoExterno": nombreNuevoExterno,
    "direccionNuevoExterno": direccionNuevoExterno,
    "telefonoNuevoExterno": telefonoNuevoExterno,
    "tipoInvolucrado": tipoInvolucrado
  };

  $.ajax({
    data:  parametros,
    url:   ruta,
    type:  'post',
    beforeSend: function(){
      $('.btn-guardar-nuevoExt').html('<span class="fa fa-spinner fa-spin"></span> Procesando...');
      $('.btn-guardar-nuevoExt').css({ 'pointer-events': 'none' });
    },
    success:  function (responseText) {
      ocultaLoader();
      accionadosExternos(tipoInvolucrado);
      swal("Guardado!", "La entidad ha sido asociada exitosamente al proceso.", "success"); 
      $('#modalNuevoExterno').modal('hide');
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

function editarExt(idExterno, tipoInvolucrado)
{
  $('#modalEditarExterno').modal('show');

  var ruta = base_url +'/'+ 'juridica/editarExt';

  var parametros = {
    "idExterno" : idExterno,
    "tipoInvolucrado": tipoInvolucrado
  };

  $.ajax({
    data:  parametros,
    url:   ruta,
    type:  'post',
    beforeSend: function(){
      cargaLoader('Nueva Entidad Externa.  Un momento por favor..');
    },
    success:  function (responseText) {
      ocultaLoader();
      $("#resultadoEditarExterno").html(responseText);
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

function validarEditarExt(idExterno, tipoInvolucrado)
{
  var nombreNuevoExternoEdit = $("#nombreNuevoExternoEdit").val();
  var direccionNuevoExternoEdit = $("#direccionNuevoExternoEdit").val();
  var telefonoNuevoExternoEdit = $("#telefonoNuevoExternoEdit").val();
  
  if(nombreNuevoExternoEdit == '')
  {
    swal({   
      title: "Atención!",   
      text: "Por favor ingrese el nombre",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  var ruta = base_url +'/'+ 'juridica/validarEditarExt';

  var parametros = {
    "idExterno": idExterno,
    "nombreNuevoExternoEdit": nombreNuevoExternoEdit,
    "direccionNuevoExternoEdit": direccionNuevoExternoEdit,
    "telefonoNuevoExternoEdit": telefonoNuevoExternoEdit
  };

  $.ajax({
    data:  parametros,
    url:   ruta,
    type:  'post',
    beforeSend: function(){
      $('.btn-editar-nuevoExt').html('<span class="fa fa-spinner fa-spin"></span> Procesando...');
      $('.btn-editar-nuevoExt').css({ 'pointer-events': 'none' });
    },
    success:  function (responseText) {
      ocultaLoader();
      accionadosExternos(tipoInvolucrado);
      swal("Guardado!", "La entidad ha sido modificada exitosamente.", "success"); 
      $('#modalEditarExterno').modal('hide');
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

function removerExt(idInvolucrado, tipoInvolucrado)
{
  swal({   
    title: "Está seguro de eliminar la entidad externa?",   
    text: "Se eliminará la entidad externa de la base de datos!",   
    type: "warning",   
    showCancelButton: true,   
    confirmButtonColor: "#f8b32d",   
    confirmButtonText: "Sí, eliminar!",   
    closeOnConfirm: false 
  }, function(){   
    validarEliminarEntidadExt(idInvolucrado, tipoInvolucrado);
  });
}

function validarEliminarEntidadExt(idInvolucrado, tipoInvolucrado)
{
  var ruta = base_url +'/'+ 'actuacionTutelas/validarEliminarAccionante';   

  var parametros = {
    "idInvolucrado": idInvolucrado
  };

  $.ajax({                
    data: parametros,                
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      swal("Eliminado!", "El Accionante ha sido eliminado exitosamente.", "success"); 
      accionadosExternos(tipoInvolucrado);
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

function nuevoAbogadoExt(tipoInvolucrado)
{
  $('#modalNuevoAbogadoEx').modal('show');

  var ruta = base_url +'/'+ 'juridica/nuevoAbogadoExt';

  var parametros = {
    "tipoInvolucrado" : tipoInvolucrado
  };

  $.ajax({
    data:  parametros,
    url:   ruta,
    type:  'post',
    beforeSend: function(){
      cargaLoader('Nuevo abogado externo.  Un momento por favor..');
    },
    success:  function (responseText) {
      ocultaLoader();
      $("#resultadoAbogadoNuevoExterno").html(responseText);
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

function validarGuardarAbogadoExt(tipoInvolucrado)
{
  var vigenciaRadicado = $("#vigenciaRadicado").val();
  var idRadicado = $("#idRadicado").val();

  var documentoAbogado = $("#documentoAbogadoDemandante").val();
  var selecTipoDocumentoAbogado = $("#selecTipoDocumentoAbogado").val();
  var nombreAbogado = $("#nombreAbogado").val();
  var tarjetaAbogado = $("#tarjetaAbogado").val();

  if(nombreAbogado == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Ingrese el nombre del abogado",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  var ruta = base_url +'/'+ 'juridica/validarGuardarAbogadoExt';

  var parametros = {  
    "documentoAbogado" : documentoAbogado,
    "selecTipoDocumentoAbogado" : selecTipoDocumentoAbogado,
    "nombreAbogado" : nombreAbogado,
    "tarjetaAbogado" : tarjetaAbogado,
    "tipoInvolucrado": tipoInvolucrado,
    "vigenciaRadicado": vigenciaRadicado,
    "idRadicado": idRadicado
  };
  
  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',
    beforeSend: function(){      
      cargaLoader('Guardando abogado. Un momento por favor..');
      $('.btn-guardar-abogadoExt').html('<span class="fa fa-spinner fa-spin"></span> Procesando...');
      $('.btn-guardar-abogadoExt').css({ 'pointer-events': 'none' });
    },
    success:  function (responseText) {
      ocultaLoader();
      abogadosExternos(tipoInvolucrado);
      swal("Guardado!", "El abogado ha sido guardado exitosamente.", "success"); 
      $('#modalNuevoAbogadoEx').modal('hide');
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

function editarAbogadoExt(idAbogadoExt, tipoInvolucrado)
{
  $('#modalEditarAbogadoExt').modal('show');

  var ruta = base_url +'/'+ 'juridica/editarAbogadoExt';

  var parametros = {
    "tipoInvolucrado" : tipoInvolucrado,
    "idAbogadoExt"    : idAbogadoExt
  };

  $.ajax({
    data:  parametros,
    url:   ruta,
    type:  'post',
    beforeSend: function(){
      cargaLoader('Nuevo abogado externo.  Un momento por favor..');
    },
    success:  function (responseText) {
      ocultaLoader();
      $("#resultadoAbogadoEditExt").html(responseText);
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

function validarEditarAbogadoExt(idAbogadoExt, tipoInvolucrado)
{
  var documentoAbogadoDemandanteEditar = $("#documentoAbogadoDemandanteEditar").val();
  var selecTipoDocumentoAbogadoEditar = $("#selecTipoDocumentoAbogadoEditar").val();
  var nombreAbogadoEditar = $("#nombreAbogadoEditar").val();
  var tarjetaAbogadoEditar = $("#tarjetaAbogadoEditar").val();

  if(documentoAbogadoDemandanteEditar == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe ingresar el documento del abogado",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(selecTipoDocumentoAbogadoEditar == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe seleccionar el tipo del documento del abogado",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(nombreAbogadoEditar == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Ingrese el nombre del abogado",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  var ruta = base_url +'/'+ 'juridica/validarEditarAbogadoExt';

  var parametros = {  
    "idAbogadoExt": idAbogadoExt,
    "documentoAbogadoDemandanteEditar": documentoAbogadoDemandanteEditar,
    "selecTipoDocumentoAbogadoEditar" : selecTipoDocumentoAbogadoEditar,
    "nombreAbogadoEditar"             : nombreAbogadoEditar,
    "tarjetaAbogadoEditar"            : tarjetaAbogadoEditar
  };
  
  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',
    beforeSend: function(){  
      $('.btn-editar-abogadoExt').html('<span class="fa fa-spinner fa-spin"></span> Procesando...');
      $('.btn-editar-abogadoExt').css({ 'pointer-events': 'none' });
    },
    success:  function (responseText) {
      if(responseText == 0)
      {
        swal({   
          title: "Atención!",   
          text: "Abogado ya se encuentra registrado",   
          confirmButtonColor: "#f33923",   
        });
        $('#modalEditarAbogadoExt').modal('hide');
        return false;
      }
      else
      {
        ocultaLoader();
        swal("Modificado!", "El abogado ha sido modidicado exitosamente.", "success"); 
        abogadosExternos(tipoInvolucrado);
        $('#modalEditarAbogadoExt').modal('hide');
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

function removerAbogadoExt(idInvolucrado, tipoInvolucrado)
{
  swal({   
    title: "Está seguro de eliminar el abogado externo?",   
    text: "Se eliminará el abogado externo de la base de datos!",   
    type: "warning",   
    showCancelButton: true,   
    confirmButtonColor: "#f8b32d",   
    confirmButtonText: "Sí, eliminar!",   
    closeOnConfirm: false 
  }, function(){   
    validarEliminarAbogadoExt(idInvolucrado, tipoInvolucrado);
  });
}

function validarEliminarAbogadoExt(idInvolucrado, tipoInvolucrado)
{
  var ruta = base_url +'/'+ 'juridica/validarEliminarAbogadoExt';   

  var parametros = {
    "idInvolucrado": idInvolucrado
  };

  $.ajax({                
    data: parametros,                
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      swal("Eliminado!", "Abogado externo ha sido eliminado exitosamente.", "success"); 
      abogadosExternos(tipoInvolucrado);
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
  
function generarCaratula(vigenciaRadicado, idRadicado)
{
  var parametros = {
    "vigenciaRadicado" : vigenciaRadicado, 
    "idRadicado" : idRadicado
  };

  var vector = JSON.stringify(parametros); 
  var rutaRedirect = base_url +'/'+ 'juridica/caratula';  
  window.location.href = rutaRedirect+"/"+vector;
}

function agregarApoderado()
{
  $('#modalAgregarApoderadoNuevo').modal('show');

  var ruta = base_url +'/'+ 'juridica/agregarApoderado';

  $.ajax({
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoAgregarApoderaoNuevo").html(responseText);
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

function validarGuardarApoderadoNuevo()
{
  var idEstadoEtapa = $("#idEstadoEtapa").val();
  var selectResponsable = $("#selectResponsable").val();
  var idTipoProceso = $("#idTipoProceso").val();

  if(selectResponsable == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe seleccionar al menos un apoderado para el reparto",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }
  var jsonResponsables = JSON.stringify(selectResponsable); 

  var ruta = base_url +'/'+ 'juridica/validarGuardarApoderadoNuevo';

  var parametros = {
    "idEstadoEtapa" : idEstadoEtapa,
    "jsonResponsables": jsonResponsables
  };

  $.ajax({
    data:  parametros,
    url:   ruta,
    type:  'post',
    beforeSend: function(){
      $('.btn-guardar-apoderado-nuevo').html('<span class="fa fa-spinner fa-spin"></span> Procesando...');
      $('.btn-guardar-apoderado-nuevo').css({ 'pointer-events': 'none' });
    },
    success:  function (responseText) {
      swal("Guardado!", "El reparto se realizó correctamente.", "success"); 
      $('#modalAgregarApoderadoNuevo').modal('hide');

      if(idTipoProceso == 1)//proceso judicial
      {
        var rutaRedirect = base_url +'/'+ 'actuacionProc-judi/index/'+idEstadoEtapa; 
      }
      else if(idTipoProceso == 2)//conciliación
      {
        var rutaRedirect = base_url +'/'+ 'actuacionTutelas/index/'+idEstadoEtapa; 
      }
      else if(idTipoProceso == 3)//tutelas
      {
        var rutaRedirect = base_url +'/'+ 'actuacionConci-prej/index/'+idEstadoEtapa; 
      }
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

function searchTema(force) 
{
  var search_string = $("#selectTema").val(); 
  if (!force && search_string.length < 5) return;

  if(search_string == '')
  {
    limpiarTema();
  }
  else
  {   
    var ruta = base_url +'/'+ 'juridica/searchTema';
    var parametros = {
      "criterioTema": search_string
    };

    $.ajax({
      data: parametros,
      url: ruta,
      type: 'post',
      success: function (responseText) {
        $("#searchesTemas").html(responseText);
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

function seleccioneTema(nombreTema, idTema)
{
  $('#selectTema').val(nombreTema)
  $("#selectTemaID").val(idTema);
}

function actuacionesProceso(vigenciaRadicado, idRadicado)
{
  var ruta = base_url +'/'+ 'juridica/actuacionesProceso';

  var parametros = {
    "vigenciaRadicado": vigenciaRadicado,
    "idRadicado":idRadicado
  };

  $.ajax({
    data:  parametros,
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoInstanciasProceso").html(responseText);
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

function modalAsociarProceso(vigenciaRadicado, idRadicado){
  $('#modalAsociarProceso').modal('show');

  var ruta = base_url +'/'+ 'juridica/nodalAsociarProceso';

  $.ajax({
    data: {vigenciaRadicado, idRadicado},
    url:   ruta,
    type:  'post',
    beforeSend: function(){
      cargaLoader('Asociar Proceso.  Un momento por favor...');
    },
    success:  function (responseText) {
      ocultaLoader();
      $("#resultadoAsociarProceso").html(responseText);
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

function visualizarCamposAsociar(){
  if($("#inputCamposAsociar").is(':checked')){
    $("#camposRadicado").css("display", "none")
    $("#camposJuzgado").css("display", "block")
  }else{
    $("#camposRadicado").css("display", "block")
    $("#camposJuzgado").css("display", "none")
  }
}

function asociarProceso(tipoProceso){

  let criterioBusqueda;
  let vigencia = $('#vigenciaProcesoBuscar').val()
  let idRadicado = $('#idRadicado').val()
  let vigenciaRadicado = $('#vigenciaRadicado').val()

  if(tipoProceso == 0){//radicado demanda
    criterioBusqueda = $('#criterioBusqueda').val()

    //validaciones
    if(criterioBusqueda == ""){
      swal({   
        title: "Campo sin diligenciar!",   
        text: "Ingrese el numero de radicado",   
        confirmButtonColor: "#f33923",   
      });
      return false;
    }

    let value = confirm("Se cerrara, El radicado : "+criterioBusqueda+"-"+vigencia+" !");

    if(!value){
      $('#modalAsociarProceso').modal('hide');
      return;
    }

  }else{//radicado juzgado
    criterioBusqueda = $('#criterioBusqueda2').val()

    //validaciones
    if(criterioBusqueda == ""){
      swal({   
        title: "Campo sin diligenciar!",   
        text: "Ingrese el numero de radicado",   
        confirmButtonColor: "#f33923",   
      });
      return false;
    }
  }

  var ruta = base_url +'/'+ 'juridica/asociarProceso';

  $.ajax({
    data: {criterioBusqueda,vigencia, tipoProceso, idRadicado, vigenciaRadicado },
    url:   ruta,
    type:  'post',
     beforeSend: function(){
      cargaLoader('Asociar Proceso.  Un momento por favor...');
    }, 
    success:  function (responseText) {
      ocultaLoader();
      if( responseText.error == 0){
        swal("Buen trabajo!", "Asociado correctamente!", "success");
        $('#ajax-demandantes').html(responseText.vista)
      }else if(responseText.error == 1){
        swal ( "Oops" ,  "El no se encontro numero de radicado!" ,  "error" )
        $('#modalAsociarProceso').modal('hide');
      }else if(responseText.error == 2){
        swal ( "Oops" ,  "Radicado juzgado exede el numero permitido!" ,  "error" )
        $('#modalAsociarProceso').modal('hide');
      }else if(responseText.error == 3){
        swal ( "Oops" ,  "no tiene permisos para realizar esta acción !" ,  "error" )
        $('#modalAsociarProceso').modal('hide');
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


function trasladarAccionante(idSolicitante, idRadicado, vigenciaRadicado){


  var ruta = base_url +'/'+ 'juridica/trasladarAccionante';

  $.ajax({
    data: {idSolicitante, idRadicado, vigenciaRadicado },
    url:   ruta,
    type:  'post',
     beforeSend: function(){
      cargaLoader('Asociando Demandantes.  Un momento por favor...');
    }, 
    success:  function (responseText) {
      ocultaLoader();
      if(responseText == 1){
        $('#'+idSolicitante).html("<p style='color: red'> Asociado  </p>")
        swal("Buen trabajo!", "Asociado correctamente!", "success");    
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