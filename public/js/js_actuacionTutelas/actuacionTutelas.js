var base_url = $('meta[name="base_url"]').attr('content'); 
var id_usuario = $('meta[name="id_usuario"]').attr('content'); 
var ciud_ope = $('meta[name="ciud_ope"]').attr('content'); 

function pasosAbogado()
{
  var vigenciaRadicado = $("#vigenciaRadicado").val();
  var idRadicado = $("#idRadicado").val();
  var idTipoProceso = $("#idTipoProceso").val();

  var ruta = base_url +'/'+ 'actuacionTutelas/pasosAbogado';

  var parametros = {  
    "vigenciaRadicado" : vigenciaRadicado,
    "idRadicado" : idRadicado,
    "idTipoProceso": idTipoProceso
  };
  
  $.ajax({                
    data:  parametros,               
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoPasosAbogado").html(responseText);
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

function modalMarcarPaso(idPaso, accion)
{
  $('#modalMarcarPaso').modal('show');
  var ruta = base_url +'/'+ 'actuacionTutelas/modalMarcarPaso';

  var parametros = {  
    "idPaso" : idPaso,
    "accion" : accion
  };
  
  $.ajax({                
    data:  parametros,               
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoMarcarPaso").html(responseText);
      $('.datepicker').datepicker({
          format: "yyyy-mm-dd",
          todayBtn: "linked",
          autoclose: true,
          todayHighlight: true
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

function marcarPaso(idPaso, accion)
{
  //si acción es 1 se esta completando el paso
  //si acción es 0 se esta quitando de completado a pendiente nuevamente

  var vigenciaRadicado = $("#vigenciaRadicado").val();
  var idRadicado = $("#idRadicado").val();
  var comentarioPaso = $("#comentarioPaso").val();
  var fechaPaso = $("#fechaPaso").val();

  if(fechaPaso == "" && accion == 1)
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe ingresar la fecha que realizó el paso",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }
  else if(fechaPaso !="" && accion == 1)
  {
    var parts = fechaPaso.split('/');
    var fechaPaso = parts[2] + '-' + parts[0] + '-' + parts[1];
  }

  var ruta = base_url +'/'+ 'actuacionTutelas/marcarPaso';

  var parametros = {  
    "vigenciaRadicado" : vigenciaRadicado,
    "idRadicado" : idRadicado,
    "idPaso": idPaso,
    "accion": accion,
    "comentarioPaso": comentarioPaso,
    "fechaPaso": fechaPaso
  };
  
  $.ajax({                
    data:  parametros,               
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      pasosAbogado();
      $('#modalMarcarPaso').modal('hide');
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

function nuevoAccionante()
{
  $('#modalAgregarAccionante').modal(
    {
     show: true,
     keyboard: false,
     backdrop: 'static'
    }
  ); 

  var ruta = base_url +'/'+ 'actuacionTutelas/nuevoAccionante';  

  $.ajax({                
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoAgregarAccionante").html(responseText);
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

function validarGuardarAccionante()
{
  var vigenciaRadicado = $("#vigenciaRadicado").val();
  var idRadicado = $("#idRadicado").val();
  var documentoAccionanteNuevo = $("#documentoAccionanteNuevo").val();
  var selecTipoDocumento = $("#selecTipoDocumento").val();
  var nombreAccionante = $("#nombreAccionante").val();
  var correoAccionante = $("#correoAccionante").val();
  var telefonoAccionante = $("#telefonoAccionante").val();
  var celularAccionante = $("#celularAccionante").val();
  var direccionAccionante = $("#direccionAccionante").val();
  var selectCiudadAccionante = $("#selectCiudadAccionante").val();
  var selectBarrioAccionante = $("#selectBarrioAccionante").val();

  if(nombreAccionante == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Ingrese el nombre del Accionante",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  var reg= /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/; 
  if(correoAccionante !='')
  {
    if (!reg.test(correoAccionante)) 
    { 
      swal({   
        title: "Campo sin diligenciar!",   
        text: "Ingrese un correo correcto para el Accionante",   
        confirmButtonColor: "#f33923",   
      });
      return false;
    }
  }

  if(celularAccionante !='')
  {
    var expresionRegular1 =/^[3]([0-9]+){9}$/;//<--- con esto vamos a validar el numero-->
    if(!expresionRegular1.test(celularAccionante))
    {
      swal({   
        title: "Campo sin diligenciar!",   
        text: "Ingrese un número de celular correcto para el Accionante",   
        confirmButtonColor: "#f33923",   
      });
      return false;
    }
  }

  var ruta = base_url +'/'+ 'actuacionTutelas/validarGuardarAccionante';

  var parametros = {  
    "documentoAccionanteNuevo" : documentoAccionanteNuevo,
    "selecTipoDocumento" : selecTipoDocumento,
    "nombreAccionante" : nombreAccionante,
    "correoAccionante" : correoAccionante,
    "telefonoAccionante": telefonoAccionante,
    "celularAccionante" : celularAccionante,
    "direccionAccionante" : direccionAccionante,
    "selectCiudadAccionante" : selectCiudadAccionante,
    "selectBarrioAccionante" : selectBarrioAccionante,
    "vigenciaRadicado": vigenciaRadicado,
    "idRadicado": idRadicado
  };
  
  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',
    beforeSend: function(){      
      cargaLoader('Guardando Accionante. Un momento por favor..');
      $('.btn-guardar-Accionante').html('<span class="fa fa-spinner fa-spin"></span> Procesando...');
      $('.btn-guardar-Accionante').css({ 'pointer-events': 'none' });
    },
    success:  function (responseText) {
      ocultaLoader();
      if(responseText == 1)// correo repetido
      {
        swal({   
          title: "Atención!",   
          text: "El correo ya se encuentra registrado",   
          confirmButtonColor: "#f33923",   
        });
        $('.btn-guardar-Accionante').html('<span class="fa fa-save"></span> Guardar');
        $('.btn-guardar-Accionante').css({ 'pointer-events': 'auto' });
        return false;
      }
      else if(responseText == 2)// documento repetido
      {
        swal({   
          title: "Atención!",   
          text: "El Accionante ya se encuentra registrado",   
          confirmButtonColor: "#f33923",   
        });
        $('.btn-guardar-Accionante').html('<span class="fa fa-save"></span> Guardar');
        $('.btn-guardar-Accionante').css({ 'pointer-events': 'auto' });
        return false;
      }
      else
      {
        $('#modalAgregarAccionante').modal('hide');
        accionantes();
        swal("Guardado!", "El Accionante ha sido guardado exitosamente.", "success"); 
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

function accionantes()
{
  var vigenciaRadicado = $("#vigenciaRadicado").val();
  var idRadicado = $("#idRadicado").val();
  var responsable = $("#responsable").val();

  var ruta = base_url +'/'+ 'actuacionTutelas/accionantes';

  var parametros = {  
    "vigenciaRadicado": vigenciaRadicado,
    "idRadicado": idRadicado,
    "responsable":responsable
  };
  
  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoAccionantes").html(responseText);
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

function involucradoProceso(tipoInvolucrado)
{
  var vigenciaRadicado = $("#vigenciaRadicado").val();
  var idRadicado = $("#idRadicado").val();
  var documentoAccionanteNuevo = $("#documentoAccionanteNuevo").val();
  var nombreNuevoExterno = $("#nombreNuevoExterno").val();

  if(documentoAccionanteNuevo === undefined)
  {
    documentoAccionanteNuevo = ''
  }

  if(nombreNuevoExterno === undefined)
  {
    nombreNuevoExterno = ''
  }

  if(documentoAccionanteNuevo != '' || nombreNuevoExterno !='')
  {
    var ruta = base_url +'/'+ 'actuacionTutelas/involucradoProceso';  

    var parametros = {  
      "vigenciaRadicado"        : vigenciaRadicado,
      "idRadicado"              : idRadicado,
      "tipoInvolucrado"         : tipoInvolucrado,
      "documentoAccionanteNuevo": documentoAccionanteNuevo,
      "nombreNuevoExterno"      : nombreNuevoExterno
    };
    
    $.ajax({                
      data:  parametros,                  
      url:   ruta,
      type:  'post',
      success:  function (responseText) {
        if(responseText == 1)
        {
          swal({   
              title: "Atención: ",
              text: "Ya se encuentra registrada, y fue agregada al proceso",   
              type: "success",   
              confirmButtonColor: "#23b5e6",   
              confirmButtonText: "OK",   
          }, function(isConfirm){   
              if (isConfirm) 
              {  
                if(tipoInvolucrado == 7)//accionantes
                {
                  $('#modalAgregarAccionante').modal('hide'); 
                  accionantes();
                }
                else if(tipoInvolucrado == 9)//entidad externa
                {
                  $('#modalNuevoExterno').modal('hide'); 
                  accionadosExternos(tipoInvolucrado);
                }
              }
          });   
        }
        else if(responseText == 2)
        {
          if(tipoInvolucrado == 7)//accionantes
          {
            swal("Atención", "Persona ya se encuentra agregada al proceso", "error");
            $('#modalAgregarAccionante').modal('hide'); 
            return false;
          }
          else if(tipoInvolucrado == 9)//externo
          {
            swal("Atención", "Entidad externa ya se encuentra agregada al proceso", "error");
            $('#modalNuevoExterno').modal('hide'); 
            return false;
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
}


function editarAccionante(idAccionante)
{
  $('#modalEditarAccionante').modal(
    {
     show: true,
     keyboard: false,
     backdrop: 'static'
    }
  ); 

  var ruta = base_url +'/'+ 'tutelas/editarAccionante';  

  var parametros = {  
    "idAccionante" : idAccionante
  };
  
  $.ajax({                
    data:  parametros,          
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoEditarAccionante").html(responseText);
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

function validarEditarAccionante(idAccionante)
{
  var ciudadOperacion = ciud_ope;
  var documentoAccionanteNuevoEditar = $("#documentoAccionanteNuevoEditar").val();
  var selecTipoDocumentoEditar = $("#selecTipoDocumentoEditar").val();
  var nombreAccionanteEditar = $("#nombreAccionanteEditar").val();
  var correoAccionanteEditar = $("#correoAccionanteEditar").val();
  var telefonoAccionanteEditar = $("#telefonoAccionanteEditar").val();
  var celularAccionanteEditar = $("#celularAccionanteEditar").val();
  var direccionAccionanteEditar = $("#direccionAccionanteEditar").val();
  var selectCiudadAccionanteEditar = $("#selectCiudadAccionanteEditar").val();
  var selectBarrioAccionanteEditar = $("#selectBarrioAccionanteEditar").val();

  if(nombreAccionanteEditar == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Ingrese el nombre del Accionante",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  var reg= /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/; 
  if(correoAccionanteEditar !='')
  {
    if (!reg.test(correoAccionanteEditar)) 
    { 
      swal({   
        title: "Campo sin diligenciar!",   
        text: "Ingrese un correo correcto para el Accionante",   
        confirmButtonColor: "#f33923",   
      });
      return false;
    }
  }

  if(celularAccionanteEditar !='')
  {
    var expresionRegular1 =/^[3]([0-9]+){9}$/;//<--- con esto vamos a validar el numero-->
    if(!expresionRegular1.test(celularAccionanteEditar))
    {
      swal({   
        title: "Campo sin diligenciar!",   
        text: "Ingrese un número de celular correcto para el Accionante",   
        confirmButtonColor: "#f33923",   
      });
      return false;
    }
  }

  var ruta = base_url +'/'+ 'tutelas/validarEditarAccionante';

  var parametros = {  
    "idAccionante": idAccionante,
    "documentoAccionanteNuevoEditar" : documentoAccionanteNuevoEditar,
    "selecTipoDocumentoEditar" : selecTipoDocumentoEditar,
    "nombreAccionanteEditar" : nombreAccionanteEditar,
    "correoAccionanteEditar" : correoAccionanteEditar,
    "telefonoAccionanteEditar": telefonoAccionanteEditar,
    "celularAccionanteEditar" : celularAccionanteEditar,
    "direccionAccionanteEditar" : direccionAccionanteEditar,
    "selectCiudadAccionanteEditar" : selectCiudadAccionanteEditar,
    "selectBarrioAccionanteEditar" : selectBarrioAccionanteEditar
  };
  
  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',
    beforeSend: function(){  
      cargaLoader('Modificando Accionante.  Un momento por favor..');    
      $('.btn-editar-Accionante').html('<span class="fa fa-spinner fa-spin"></span> Procesando...');
      $('.btn-editar-Accionante').css({ 'pointer-events': 'none' });
    },
    success:  function (responseText) {
      ocultaLoader();
      if(responseText == 1)// correo repetido
      {
        swal({   
          title: "Atención!",   
          text: "El correo ya se encuentra registrado",   
          confirmButtonColor: "#f33923",   
        });
        $('.btn-editar-Accionante').html('<span class="fa fa-save"></span> Modificado');
        $('.btn-editar-Accionante').css({ 'pointer-events': 'auto' });
        return false;
      }
      else if(responseText == 2)// documento repetido
      {
        swal({   
          title: "Atención!",   
          text: "El Accionante ya se encuentra registrado",   
          confirmButtonColor: "#f33923",   
        });
        $('.btn-editar-Accionante').html('<span class="fa fa-save"></span> Modificado');
        $('.btn-editar-Accionante').css({ 'pointer-events': 'auto' });
        return false;
      }
      else
      {
        $('#modalEditarAccionante').modal('hide');
        swal("Modificado!", "El Accionante ha sido modidicado exitosamente.", "success"); 
        accionantes();
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

function elegirBarrioAccionanteEditar(idCiudad, idAccionante)
{
  var ciudadOperacion = ciud_ope;
  
  if(idCiudad == ciudadOperacion )//339 id de Manizales en la tabla ciudades, si es la de operación
  {
    var ruta = base_url +'/'+ 'tutelas/elegirBarrioAccionanteEditar';   

    var parametros = {
      "idAccionante": idAccionante,
      "ciudadOperacion": ciudadOperacion// es la ciudad de operación, guarda el barrio
    };

    $("#resultadoBarrioAccionanteEditar").css("display", "block");

    $.ajax({                
      data: parametros,                
      url:   ruta,
      type:  'post',
      beforeSend: function(){      
        cargaLoader('Cargando territorios.  Un momento por favor..');
      },
      success:  function (responseText) {
        ocultaLoader();
        $("#resultadoBarrioAccionanteEditar").html(responseText);
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
  else
  {
    $("#resultadoBarrioAccionanteEditar").css("display", "none");
    $("#selectBarrioAccionanteEditar").val(0);
  }
}

function removerAccionante(idInvolucrado)
{
  swal({   
    title: "Está seguro de eliminar el accionante?",   
    text: "Se eliminará el accionante de la base de datos!",   
    type: "warning",   
    showCancelButton: true,   
    confirmButtonColor: "#f8b32d",   
    confirmButtonText: "Sí, eliminar!",   
    closeOnConfirm: false 
  }, function(){   
    validarEliminarAccionante(idInvolucrado);
  });
}

function validarEliminarAccionante(idInvolucrado)
{
  var vigenciaRadicado = $("#vigenciaRadicado").val();
  var idRadicado = $("#idRadicado").val();

  var ruta = base_url +'/'+ 'actuacionTutelas/validarEliminarAccionante';   

  var parametros = {
    "idInvolucrado": idInvolucrado,
    "vigenciaRadicado": vigenciaRadicado,
    "idRadicado": idRadicado
  };

  $.ajax({                
    data: parametros,                
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      if(responseText == 0)
      {
        swal({   
          title: "Atención!",   
          text: "El proceso no puede estar sin accionantes",   
          confirmButtonColor: "#f33923",   
          });
        return false;
      }
      else
      {
        swal("Eliminado!", "El Accionante ha sido eliminado exitosamente.", "success"); 
        accionantes();
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

function accionadosInternos()
{
  var vigenciaRadicado = $("#vigenciaRadicado").val();
  var idRadicado = $("#idRadicado").val();
  var responsable = $("#responsable").val();

  var ruta = base_url +'/'+ 'actuacionTutelas/accionadosInternos';

  var parametros = {  
    "vigenciaRadicado": vigenciaRadicado,
    "idRadicado": idRadicado,
    "responsable":responsable
  };
  
  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoAccionadosInternos").html(responseText);
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

function removerAccionadoInt(idInvolucrado)
{
  swal({   
    title: "Está seguro de eliminar el accionado interno?",   
    text: "Se eliminará el accionado interno de la base de datos!",   
    type: "warning",   
    showCancelButton: true,   
    confirmButtonColor: "#f8b32d",   
    confirmButtonText: "Sí, eliminar!",   
    closeOnConfirm: false 
  }, function(){   
    validarRemoverAccionadoInt(idInvolucrado);
  });
}

function validarRemoverAccionadoInt(idInvolucrado)
{
  var vigenciaRadicado = $("#vigenciaRadicado").val();
  var idRadicado = $("#idRadicado").val();

  var ruta = base_url +'/'+ 'actuacionTutelas/validarRemoverAccionadoInt';   

  var parametros = {
    "idInvolucrado": idInvolucrado,
    "vigenciaRadicado": vigenciaRadicado,
    "idRadicado": idRadicado
  };

  $.ajax({                
    data: parametros,                
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      if(responseText == 0)
      {
        swal({   
          title: "Atención!",   
          text: "El proceso no puede estar sin accionados internos",   
          confirmButtonColor: "#f33923",   
          });
        return false;
      }
      else
      {
        swal("Eliminado!", "El Accionado Interno ha sido eliminado exitosamente.", "success"); 
        accionadosInternos();
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

function accionadosExternos(tipoInvolucrado)
{
  var vigenciaRadicado = $("#vigenciaRadicado").val();
  var idRadicado = $("#idRadicado").val();
  var responsable = $("#responsable").val();

  var ruta = base_url +'/'+ 'actuacionTutelas/accionadosExternos';

  var parametros = {  
    "vigenciaRadicado": vigenciaRadicado,
    "idRadicado": idRadicado,
    "responsable":responsable,
    "tipoInvolucrado": tipoInvolucrado
  };
  
  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoAccionadoExterno").html(responseText);
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

function modificarDatosGenerales()
{
  $('#modalEditarDatos').modal('show');

  var vigenciaRadicado = $("#vigenciaRadicado").val();
  var idRadicado = $("#idRadicado").val();

  var ruta = base_url +'/'+ 'actuacionTutelas/modificarDatosGenerales';

  var parametros = {  
    "vigenciaRadicado" : vigenciaRadicado,
    "idRadicado" : idRadicado
  };
  
  $.ajax({                
    data:  parametros,               
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoEditarDatos").html(responseText);
      $("#radicadoJuzgado").mask("9999-99999");
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


function validarEditarDatosGenerales()
{
  var vigenciaRadicado   = $("#vigenciaRadicado").val();
  var idRadicado         = $("#idRadicado").val();

  var selectJuzgado      = $("#selectJuzgado").val();
  var radicadoJuzgado    = $("#radicadoJuzgado").val();
  var selectTema         = $("#selectTema").val();

  var textoJuzgado       = $("#selectJuzgado option:selected").text();
  var textoTema          = $("#selectTema option:selected").text();

  if(selectJuzgado == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Seleccione el juzgado",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(radicadoJuzgado == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Ingrese el radicado del juzgado",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(radicadoJuzgado.length < 9 || radicadoJuzgado.length > 23 )
  {
    swal({   
      title: "Atención!",   
      text: "El radicado del juzgado no tiene una longitud permitida",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(selectTema == '')
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Seleccione el tema",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }


  var ruta = base_url +'/'+ 'actuacionTutelas/validarEditarDatosGenerales';  

  var parametros = {  
    "vigenciaRadicado"   : vigenciaRadicado,
    "idRadicado"         : idRadicado,
    "selectJuzgado"      : selectJuzgado,
    "radicadoJuzgado"    : radicadoJuzgado,
    "selectTema"         : selectTema
  };
  
  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',
    beforeSend: function(){      
      cargaLoader('Modificando datos. Un momento por favor..');
      $('.btn-editar-datosG').html('<span class="fa fa-spinner fa-spin"></span> Procesando...');
      $('.btn-editar-datosG').css({ 'pointer-events': 'none' });
    },
    success:  function (responseText) {
      ocultaLoader();
      swal("Modificados!", "Datos moficados correctamente.", "success"); 
      $('#modalEditarDatos').modal('hide');
      $("#textoNombreJuzgado").text(textoJuzgado);
      $("#textoCodigoProceso").text(responseText.codigoProceso);
      $("#textoTema").text(textoTema);
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