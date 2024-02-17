var base_url = $('meta[name="base_url"]').attr('content'); 
var id_usuario = $('meta[name="id_usuario"]').attr('content'); 
var ciud_ope = $('meta[name="ciud_ope"]').attr('content'); 

function pasosAbogado()
{
  var vigenciaRadicado = $("#vigenciaRadicado").val();
  var idRadicado = $("#idRadicado").val();
  var idTipoProceso = $("#idTipoProceso").val();

  var ruta = base_url +'/'+ 'actuacionConci-prej/pasosAbogado';

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
  var ruta = base_url +'/'+ 'actuacionConci-prej/modalMarcarPaso';

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

  var ruta = base_url +'/'+ 'actuacionConci-prej/marcarPaso';

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

function agregarConvocante()
{
  $('#modalAgregarConvocante').modal(
    {
     show: true,
     keyboard: false,
     backdrop: 'static'
    }
  ); 

  var ruta = base_url +'/'+ 'actuacionConci-prej/agregarConvocante';  

  $.ajax({                
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoAgregarConvocante").html(responseText);
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

function validarGuardarConvocante()
{
  var vigenciaRadicado = $("#vigenciaRadicado").val();
  var idRadicado = $("#idRadicado").val();

  var documentoConvocanteNuevo = $("#documentoConvocanteNuevo").val();
  var selecTipoDocumento = $("#selecTipoDocumento").val();
  var nombreConvocante = $("#nombreConvocante").val();
  var correoConvocante = $("#correoConvocante").val();
  var telefonoConvocante = $("#telefonoConvocante").val();
  var celularConvocante = $("#celularConvocante").val();
  var direccionConvocante = $("#direccionConvocante").val();
  var selectCiudadConvocante = $("#selectCiudadConvocante").val();
  var selectBarrioConvocante = $("#selectBarrioConvocante").val();

  if(nombreConvocante == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Ingrese el nombre del Convocante",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  var reg= /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/; 
  if(correoConvocante !='')
  {
    if (!reg.test(correoConvocante)) 
    { 
      swal({   
        title: "Campo sin diligenciar!",   
        text: "Ingrese un correo correcto para el Convocante",   
        confirmButtonColor: "#f33923",   
      });
      return false;
    }
  }

  if(celularConvocante !='')
  {
    var expresionRegular1 =/^[3]([0-9]+){9}$/;//<--- con esto vamos a validar el numero-->
    if(!expresionRegular1.test(celularConvocante))
    {
      swal({   
        title: "Campo sin diligenciar!",   
        text: "Ingrese un número de celular correcto para el Convocante",   
        confirmButtonColor: "#f33923",   
      });
      return false;
    }
  }

  var ruta = base_url +'/'+ 'actuacionConci-prej/validarGuardarConvocante';  

  var parametros = {  
    "documentoConvocanteNuevo" : documentoConvocanteNuevo,
    "selecTipoDocumento" : selecTipoDocumento,
    "nombreConvocante" : nombreConvocante,
    "correoConvocante" : correoConvocante,
    "telefonoConvocante": telefonoConvocante,
    "celularConvocante" : celularConvocante,
    "direccionConvocante" : direccionConvocante,
    "selectCiudadConvocante" : selectCiudadConvocante,
    "selectBarrioConvocante" : selectBarrioConvocante,
    "vigenciaRadicado": vigenciaRadicado,
    "idRadicado": idRadicado
  };
  
  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',
    beforeSend: function(){      
      cargaLoader('Guardando Convocante. Un momento por favor..');
      $('.btn-guardar-Convocante').html('<span class="fa fa-spinner fa-spin"></span> Procesando...');
      $('.btn-guardar-Convocante').css({ 'pointer-events': 'none' });
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
        $('.btn-guardar-Convocante').html('<span class="fa fa-save"></span> Guardar');
        $('.btn-guardar-Convocante').css({ 'pointer-events': 'auto' });
        return false;
      }
      else if(responseText == 2)// documento repetido
      {
        swal({   
          title: "Atención!",   
          text: "El Convocante ya se encuentra registrado",   
          confirmButtonColor: "#f33923",   
        });
        $('.btn-guardar-Convocante').html('<span class="fa fa-save"></span> Guardar');
        $('.btn-guardar-Convocante').css({ 'pointer-events': 'auto' });
        return false;
      }
      else
      {
        $('#modalAgregarConvocante').modal('hide');
        convocantes();
        swal("Guardado!", "El Convocante ha sido guardado exitosamente.", "success"); 
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

function convocantes()
{
  var vigenciaRadicado = $("#vigenciaRadicado").val();
  var idRadicado = $("#idRadicado").val();
  var responsable = $("#responsable").val();

  var ruta = base_url +'/'+ 'actuacionConci-prej/convocantes';

  var parametros = {  
    "vigenciaRadicado" : vigenciaRadicado,
    "idRadicado" : idRadicado,
    "responsable": responsable
  };
  
  $.ajax({                
    data:  parametros,               
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoConvocantes").html(responseText);
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

  var ruta = base_url +'/'+ 'actuacionConci-prej/modificarDatosGenerales';

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
  var vigenciaRadicado = $("#vigenciaRadicado").val();
  var idRadicado = $("#idRadicado").val();

  var selectProcuraduria = $("#selectProcuraduria").val();
  var selectMedioControl = $("#selectMedioControl").val();
  var selectTema         = $("#selectTema").val();

  var textoProcuraduria  = $("#selectProcuraduria option:selected").text();
  var textoMedioControl  = $("#selectMedioControl option:selected").text();
  var textoTema          = $("#selectTema option:selected").text();

  if(selectProcuraduria == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Seleccione la procuraduría conocedora",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(selectMedioControl == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Seleccione el medio de control",   
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

  var ruta = base_url +'/'+ 'actuacionConci-prej/validarEditarDatosGenerales';  

  var parametros = {  
    "vigenciaRadicado"   : vigenciaRadicado,
    "idRadicado"         : idRadicado,
    "selectProcuraduria" : selectProcuraduria,
    "selectMedioControl" : selectMedioControl,
    "selectTema"         : selectTema,
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
      $("#textoProcuraduria").text(textoProcuraduria);
      $("#textoMedioControl").text(textoMedioControl);
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

function involucradoProceso(tipoInvolucrado)
{
  var vigenciaRadicado = $("#vigenciaRadicado").val();
  var idRadicado = $("#idRadicado").val();
  var documentoConvocanteNuevo = $("#documentoConvocanteNuevo").val();
  var nombreNuevoExterno = $("#nombreNuevoExterno").val();
  var documentoAbogadoExt = $("#documentoAbogadoExt").val();

  if(documentoConvocanteNuevo === undefined)
  {
    documentoConvocanteNuevo = ''
  }

  if(nombreNuevoExterno === undefined)
  {
    nombreNuevoExterno = ''
  }

  if(documentoAbogadoExt === undefined)
  {
    documentoAbogadoExt = ''
  }

  if(documentoConvocanteNuevo != '' || nombreNuevoExterno !='' || documentoAbogadoExt !='')
  {
    var ruta = base_url +'/'+ 'actuacionConci-prej/involucradoProceso';  

    var parametros = {  
      "vigenciaRadicado"        : vigenciaRadicado,
      "idRadicado"              : idRadicado,
      "tipoInvolucrado"         : tipoInvolucrado,
      "documentoConvocanteNuevo": documentoConvocanteNuevo,
      "nombreNuevoExterno": nombreNuevoExterno,
      "documentoAbogadoExt": documentoAbogadoExt
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
              text: "La persona ya se encuentra registrada, y fue agregada al proceso",   
              type: "success",   
              confirmButtonColor: "#23b5e6",   
              confirmButtonText: "OK",   
          }, function(isConfirm){   
              if (isConfirm) 
              {  
                if(tipoInvolucrado == 4)//convocantes
                {
                  $('#modalAgregarConvocante').modal('hide'); 
                  convocantes();
                }
                else if(tipoInvolucrado == 6)//entidad externa
                {
                  $('#modalNuevoExterno').modal('hide'); 
                  accionadosExternos(tipoInvolucrado);
                }
                else if(tipoInvolucrado == 2)//abogado externo
                {
                  $('#modalNuevoAbogadoEx').modal('hide'); 
                  abogadosExternos(tipoInvolucrado);
                }
              }
          });   
        }
        else if(responseText == 2)
        {
          if(tipoInvolucrado == 4)//convocantes
          {
            swal("Atención", "La persona ya se encuentra agregada al proceso", "error");
            $('#modalAgregarConvocante').modal('hide'); 
            return false;
          }
          else if(tipoInvolucrado == 6)//entidad externa
          {
            swal("Atención", "Entidad externa ya se encuentra agregada al proceso", "error");
            $('#modalNuevoExterno').modal('hide'); 
            return false;
          }
          else if(tipoInvolucrado == 2)//abogado externo
          {
            swal("Atención", "Abogado externo ya se encuentra agregado al proceso", "error");
            $('#modalNuevoAbogadoEx').modal('hide'); 
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

function editarConvocante(idConvocante)
{
  $('#modalEditarConvocante').modal(
    {
     show: true,
     keyboard: false,
     backdrop: 'static'
    }
  ); 

  var ruta = base_url +'/'+ 'concil-prej/editarConvocante';  

  var parametros = {  
    "idConvocante" : idConvocante
  };
  
  $.ajax({                
    data:  parametros,          
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoEditarConvocante").html(responseText);
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

function validarEditarConvocante (idConvocante)
{
  var ciudadOperacion = ciud_ope;
  var documentoConvocanteNuevoEditar = $("#documentoConvocanteNuevoEditar").val();
  var selecTipoDocumentoEditar = $("#selecTipoDocumentoEditar").val();
  var nombreConvocanteEditar = $("#nombreConvocanteEditar").val();
  var correoConvocanteEditar = $("#correoConvocanteEditar").val();
  var telefonoConvocanteEditar = $("#telefonoConvocanteEditar").val();
  var celularConvocanteEditar = $("#celularConvocanteEditar").val();
  var direccionConvocanteEditar = $("#direccionConvocanteEditar").val();
  var selectCiudadConvocanteEditar = $("#selectCiudadConvocanteEditar").val();
  var selectBarrioConvocanteEditar = $("#selectBarrioConvocanteEditar").val();


  if(nombreConvocanteEditar == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Ingrese el nombre del Convocante",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  var reg= /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/; 
  if(correoConvocanteEditar !='')
  {
    if (!reg.test(correoConvocanteEditar)) 
    { 
      swal({   
        title: "Campo sin diligenciar!",   
        text: "Ingrese un correo correcto para el Convocante",   
        confirmButtonColor: "#f33923",   
      });
      return false;
    }
  }

  if(celularConvocanteEditar !='')
  {
    var expresionRegular1 =/^[3]([0-9]+){9}$/;//<--- con esto vamos a validar el numero-->
    if(!expresionRegular1.test(celularConvocanteEditar))
    {
      swal({   
        title: "Campo sin diligenciar!",   
        text: "Ingrese un número de celular correcto para el Convocante",   
        confirmButtonColor: "#f33923",   
      });
      return false;
    }
  }

  var ruta = base_url +'/'+ 'concil-prej/validarEditarConvocante';

  var parametros = {  
    "idConvocante": idConvocante,
    "documentoConvocanteNuevoEditar" : documentoConvocanteNuevoEditar,
    "selecTipoDocumentoEditar" : selecTipoDocumentoEditar,
    "nombreConvocanteEditar" : nombreConvocanteEditar,
    "correoConvocanteEditar" : correoConvocanteEditar,
    "telefonoConvocanteEditar": telefonoConvocanteEditar,
    "celularConvocanteEditar" : celularConvocanteEditar,
    "direccionConvocanteEditar" : direccionConvocanteEditar,
    "selectCiudadConvocanteEditar" : selectCiudadConvocanteEditar,
    "selectBarrioConvocanteEditar" : selectBarrioConvocanteEditar
  };
  
  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',
    beforeSend: function(){  
      cargaLoader('Modificando Convocante.  Un momento por favor..');    
      $('.btn-editar-Convocante').html('<span class="fa fa-spinner fa-spin"></span> Procesando...');
      $('.btn-editar-Convocante').css({ 'pointer-events': 'none' });
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
        $('.btn-editar-Convocante').html('<span class="fa fa-save"></span> Modificado');
        $('.btn-editar-Convocante').css({ 'pointer-events': 'auto' });
        return false;
      }
      else if(responseText == 2)// documento repetido
      {
        swal({   
          title: "Atención!",   
          text: "El Convocante ya se encuentra registrado",   
          confirmButtonColor: "#f33923",   
        });
        $('.btn-editar-Convocante').html('<span class="fa fa-save"></span> Modificado');
        $('.btn-editar-Convocante').css({ 'pointer-events': 'auto' });
        return false;
      }
      else
      {
        $('#modalEditarConvocante').modal('hide');
        swal("Modificado!", "El Convocante ha sido modidicado exitosamente.", "success"); 
        convocantes();
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

function elegirBarrioConvocanteEditar(idCiudad, idConvocante)
{
  var ciudadOperacion = ciud_ope;
  
  if(idCiudad == ciudadOperacion )//339 id de Manizales en la tabla ciudades, si es la de operación
  {
    var ruta = base_url +'/'+ 'concil-prej/elegirBarrioConvocanteEditar';   

    var parametros = {
      "idConvocante": idConvocante,
      "ciudadOperacion": ciudadOperacion// es la ciudad de operación, guarda el barrio
    };

    $("#resultadoBarrioConvocanteEditar").css("display", "block");

    $.ajax({                
      data: parametros,                
      url:   ruta,
      type:  'post',
      beforeSend: function(){      
        cargaLoader('Cargando territorios.  Un momento por favor..');
      },
      success:  function (responseText) {
        ocultaLoader();
        $("#resultadoBarrioConvocanteEditar").html(responseText);
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
    $("#resultadoBarrioConvocanteEditar").css("display", "none");
    $("#selectBarrioConvocanteEditar").val(0);
  }
}

function removerConvocante(idInvolucrado)
{
  swal({   
    title: "Está seguro de eliminar el convocante?",   
    text: "Se eliminará el convocante de la base de datos!",   
    type: "warning",   
    showCancelButton: true,   
    confirmButtonColor: "#f8b32d",   
    confirmButtonText: "Sí, eliminar!",   
    closeOnConfirm: false 
  }, function(){   
    validarEliminarConvocante(idInvolucrado);
  });
}

function validarEliminarConvocante(idInvolucrado)
{
  var vigenciaRadicado = $("#vigenciaRadicado").val();
  var idRadicado = $("#idRadicado").val();

  var ruta = base_url +'/'+ 'actuacionConci-prej/validarEliminarConvocante';   

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
          text: "El proceso no puede estar sin convocantes",   
          confirmButtonColor: "#f33923",   
          });
        return false;
      }
      else
      {
        swal("Eliminado!", "El Convocante ha sido eliminado exitosamente.", "success"); 
        convocantes();
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

function convocadosInternos()
{
  var vigenciaRadicado = $("#vigenciaRadicado").val();
  var idRadicado = $("#idRadicado").val();
  var responsable = $("#responsable").val();

  var ruta = base_url +'/'+ 'actuacionConci-prej/convocadosInternos';

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
      $("#resultadoConvocadosInternos").html(responseText);
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

function removerConvocadoInt(idInvolucrado)
{
  swal({   
    title: "Está seguro de eliminar el convocado interno?",   
    text: "Se eliminará el convocado interno de la base de datos!",   
    type: "warning",   
    showCancelButton: true,   
    confirmButtonColor: "#f8b32d",   
    confirmButtonText: "Sí, eliminar!",   
    closeOnConfirm: false 
  }, function(){   
    validarRemoverConvocadoInt(idInvolucrado);
  });
}

function validarRemoverConvocadoInt(idInvolucrado)
{
  var vigenciaRadicado = $("#vigenciaRadicado").val();
  var idRadicado = $("#idRadicado").val();

  var ruta = base_url +'/'+ 'actuacionConci-prej/validarRemoverConvocadoInt';   

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
          text: "El proceso no puede estar sin convocados internos",   
          confirmButtonColor: "#f33923",   
          });
        return false;
      }
      else
      {
        swal("Eliminado!", "El Convocado Interno ha sido eliminado exitosamente.", "success"); 
        convocadosInternos();
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

  var ruta = base_url +'/'+ 'actuacionConci-prej/accionadosExternos';

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
      $("#resultadoConvocadosExternos").html(responseText);
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

function abogadosExternos(tipoInvolucrado)
{
  var vigenciaRadicado = $("#vigenciaRadicado").val();
  var idRadicado = $("#idRadicado").val();
  var responsable = $("#responsable").val();

  var ruta = base_url +'/'+ 'actuacionConci-prej/abogadosExternos';

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
      $("#resultadoAbogadoExt").html(responseText);
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