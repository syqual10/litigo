var base_url = $('meta[name="base_url"]').attr('content'); 
var id_usuario = $('meta[name="id_usuario"]').attr('content'); 
var ciud_ope = $('meta[name="ciud_ope"]').attr('content'); 

function pasosAbogado()
{
  var vigenciaRadicado = $("#vigenciaRadicado").val();
  var idRadicado = $("#idRadicado").val();
  var idTipoProceso = $("#idTipoProceso").val();

  var ruta = base_url +'/'+ 'actuacionProc-judi/pasosAbogado';

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
  var ruta = base_url +'/'+ 'actuacionProc-judi/modalMarcarPaso';

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

  var ruta = base_url +'/'+ 'actuacionProc-judi/marcarPaso';

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

function nuevoDemandante()
{
  $('#modalAgregarDemandante').modal(
    {
     show: true,
     keyboard: false,
     backdrop: 'static'
    }
  ); 

  var ruta = base_url +'/'+ 'actuacionProc-judi/nuevoDemandante';  

  $.ajax({                
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoAgregarDemandandante").html(responseText);
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

function validarGuardarDemandante()
{
  var vigenciaRadicado = $("#vigenciaRadicado").val();
  var idRadicado = $("#idRadicado").val();
  var documentoDemandanteNuevo = $("#documentoDemandanteNuevo").val();
  var selecTipoDocumento = $("#selecTipoDocumento").val();
  var nombreDemandante = $("#nombreDemandante").val();
  var correoDemandante = $("#correoDemandante").val();
  var telefonoDemandante = $("#telefonoDemandante").val();
  var celularDemandante = $("#celularDemandante").val();
  var direccionDemandante = $("#direccionDemandante").val();
  var selectCiudadDemandante = $("#selectCiudadDemandante").val();
  var selectBarrioDemandante = $("#selectBarrioDemandante").val();

  if(nombreDemandante == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Ingrese el nombre del demandante",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  var reg= /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/; 
  if(correoDemandante !='')
  {
    if (!reg.test(correoDemandante)) 
    { 
      swal({   
        title: "Campo sin diligenciar!",   
        text: "Ingrese un correo correcto para el demandante",   
        confirmButtonColor: "#f33923",   
      });
      return false;
    }
  }

  if(celularDemandante !='')
  {
    var expresionRegular1 =/^[3]([0-9]+){9}$/;//<--- con esto vamos a validar el numero-->
    if(!expresionRegular1.test(celularDemandante))
    {
      swal({   
        title: "Campo sin diligenciar!",   
        text: "Ingrese un número de celular correcto para el demandante",   
        confirmButtonColor: "#f33923",   
      });
      return false;
    }
  }

  var ruta = base_url +'/'+ 'actuacionProc-judi/validarGuardarDemandante';

  var parametros = {  
    "documentoDemandanteNuevo" : documentoDemandanteNuevo,
    "selecTipoDocumento" : selecTipoDocumento,
    "nombreDemandante" : nombreDemandante,
    "correoDemandante" : correoDemandante,
    "telefonoDemandante": telefonoDemandante,
    "celularDemandante" : celularDemandante,
    "direccionDemandante" : direccionDemandante,
    "selectCiudadDemandante" : selectCiudadDemandante,
    "selectBarrioDemandante" : selectBarrioDemandante,
    "vigenciaRadicado": vigenciaRadicado,
    "idRadicado": idRadicado
  };
  
  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',
    beforeSend: function(){      
      cargaLoader('Guardando demandante. Un momento por favor..');
      $('.btn-guardar-demandante').html('<span class="fa fa-spinner fa-spin"></span> Procesando...');
      $('.btn-guardar-demandante').css({ 'pointer-events': 'none' });
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
        $('.btn-guardar-demandante').html('<span class="fa fa-save"></span> Guardar');
        $('.btn-guardar-demandante').css({ 'pointer-events': 'auto' });
        return false;
      }
      else if(responseText == 2)// documento repetido
      {
        swal({   
          title: "Atención!",   
          text: "El demandante ya se encuentra registrado",   
          confirmButtonColor: "#f33923",   
        });
        $('.btn-guardar-demandante').html('<span class="fa fa-save"></span> Guardar');
        $('.btn-guardar-demandante').css({ 'pointer-events': 'auto' });
        return false;
      }
      else
      {
        $('#modalAgregarDemandante').modal('hide');
        demandantes();
        swal("Guardado!", "El demandante ha sido guardado exitosamente.", "success"); 
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

function demandantes()
{
  var vigenciaRadicado = $("#vigenciaRadicado").val();
  var idRadicado = $("#idRadicado").val();
  var responsable = $("#responsable").val();

  var ruta = base_url +'/'+ 'actuacionProc-judi/demandantes';

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
      $("#resultadoDemandantes").html(responseText);
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
  var documentoDemandanteNuevo = $("#documentoDemandanteNuevo").val();
  var nombreNuevoExterno = $("#nombreNuevoExterno").val();
  var documentoAbogadoExt = $("#documentoAbogadoExt").val();
  
  if(documentoDemandanteNuevo === undefined)
  {
    documentoDemandanteNuevo = ''
  }

  if(nombreNuevoExterno === undefined)
  {
    nombreNuevoExterno = ''
  }

  if(documentoAbogadoExt === undefined)
  {
    documentoAbogadoExt = ''
  }

  if(documentoDemandanteNuevo !='' || nombreNuevoExterno !='' || documentoAbogadoExt !='')
  {
    var ruta = base_url +'/'+ 'actuacionProc-judi/involucradoProceso';  

    var parametros = {  
      "vigenciaRadicado"        : vigenciaRadicado,
      "idRadicado"              : idRadicado,
      "tipoInvolucrado"         : tipoInvolucrado,
      "documentoDemandanteNuevo": documentoDemandanteNuevo,
      "nombreNuevoExterno"      : nombreNuevoExterno,
      "documentoAbogadoExt"     : documentoAbogadoExt
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
                if(tipoInvolucrado == 1)//demandantes
                {
                  $('#modalAgregarDemandante').modal('hide'); 
                  demandantes();
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
          if(tipoInvolucrado == 1)//demandantes
          {
            swal("Atención", "La persona ya se encuentra agregada al proceso", "error");
            $('#modalAgregarDemandante').modal('hide'); 
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

function editarDemandante(idDemandante)
{
  $('#modalEditarDemandante').modal(
    {
     show: true,
     keyboard: false,
     backdrop: 'static'
    }
  ); 

  var ruta = base_url +'/'+ 'proceso-judic/editarDemandante';  

  var parametros = {  
    "idDemandante" : idDemandante
  };
  
  $.ajax({                
    data:  parametros,          
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoEditarDemandante").html(responseText);
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

function validarEditarDemandante (idDemandante)
{
  var ciudadOperacion = ciud_ope;
  var documentoDemandanteNuevoEditar = $("#documentoDemandanteNuevoEditar").val();
  var selecTipoDocumentoEditar = $("#selecTipoDocumentoEditar").val();
  var nombreDemandanteEditar = $("#nombreDemandanteEditar").val();
  var correoDemandanteEditar = $("#correoDemandanteEditar").val();
  var telefonoDemandanteEditar = $("#telefonoDemandanteEditar").val();
  var celularDemandanteEditar = $("#celularDemandanteEditar").val();
  var direccionDemandanteEditar = $("#direccionDemandanteEditar").val();
  var selectCiudadDemandanteEditar = $("#selectCiudadDemandanteEditar").val();
  var selectBarrioDemandanteEditar = $("#selectBarrioDemandanteEditar").val();

  if(nombreDemandanteEditar == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Ingrese el nombre del demandante",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  var reg= /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/; 
  if(correoDemandanteEditar !='')
  {
    if (!reg.test(correoDemandanteEditar)) 
    { 
      swal({   
        title: "Campo sin diligenciar!",   
        text: "Ingrese un correo correcto para el demandante",   
        confirmButtonColor: "#f33923",   
      });
      return false;
    }
  }

  if(celularDemandanteEditar !='')
  {
    var expresionRegular1 =/^[3]([0-9]+){9}$/;//<--- con esto vamos a validar el numero-->
    if(!expresionRegular1.test(celularDemandanteEditar))
    {
      swal({   
        title: "Campo sin diligenciar!",   
        text: "Ingrese un número de celular correcto para el demandante",   
        confirmButtonColor: "#f33923",   
      });
      return false;
    }
  }

  var ruta = base_url +'/'+ 'proceso-judic/validarEditarDemandante';

  var parametros = {  
    "idDemandante": idDemandante,
    "documentoDemandanteNuevoEditar" : documentoDemandanteNuevoEditar,
    "selecTipoDocumentoEditar" : selecTipoDocumentoEditar,
    "nombreDemandanteEditar" : nombreDemandanteEditar,
    "correoDemandanteEditar" : correoDemandanteEditar,
    "telefonoDemandanteEditar": telefonoDemandanteEditar,
    "celularDemandanteEditar" : celularDemandanteEditar,
    "direccionDemandanteEditar" : direccionDemandanteEditar,
    "selectCiudadDemandanteEditar" : selectCiudadDemandanteEditar,
    "selectBarrioDemandanteEditar" : selectBarrioDemandanteEditar
  };
  
  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',
    beforeSend: function(){  
      cargaLoader('Modificando demandante.  Un momento por favor..');    
      $('.btn-editar-demandante').html('<span class="fa fa-spinner fa-spin"></span> Procesando...');
      $('.btn-editar-demandante').css({ 'pointer-events': 'none' });
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
        $('.btn-editar-demandante').html('<span class="fa fa-save"></span> Modificado');
        $('.btn-editar-demandante').css({ 'pointer-events': 'auto' });
        return false;
      }
      else if(responseText == 2)// documento repetido
      {
        swal({   
          title: "Atención!",   
          text: "El demandante ya se encuentra registrado",   
          confirmButtonColor: "#f33923",   
        });
        $('.btn-editar-demandante').html('<span class="fa fa-save"></span> Modificado');
        $('.btn-editar-demandante').css({ 'pointer-events': 'auto' });
        return false;
      }
      else
      {
        $('#modalEditarDemandante').modal('hide');
        swal("Modificado!", "El demandante ha sido modidicado exitosamente.", "success"); 
        demandantes();
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

function elegirBarrioDemandanteEditar(idCiudad, idDemandante)
{
  var ciudadOperacion = ciud_ope;
  
  if(idCiudad == ciudadOperacion )//339 id de Manizales en la tabla ciudades, si es la de operación
  {
    var ruta = base_url +'/'+ 'proceso-judic/elegirBarrioDemandanteEditar';   

    var parametros = {
      "idDemandante": idDemandante,
      "ciudadOperacion": ciudadOperacion// es la ciudad de operación, guarda el barrio
    };

    $("#resultadoBarrioDemandanteEditar").css("display", "block");

    $.ajax({                
      data: parametros,                
      url:   ruta,
      type:  'post',
      beforeSend: function(){      
        cargaLoader('Cargando territorios.  Un momento por favor..');
      },
      success:  function (responseText) {
        ocultaLoader();
        $("#resultadoBarrioDemandanteEditar").html(responseText);
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
    $("#resultadoBarrioDemandanteEditar").css("display", "none");
    $("#selectBarrioDemandanteEditar").val(0);
  }
}

function removerDemandante(idInvolucrado)
{
  swal({   
    title: "Está seguro de eliminar el demandante?",   
    text: "Se eliminará el demandante de la base de datos!",   
    type: "warning",   
    showCancelButton: true,   
    confirmButtonColor: "#f8b32d",   
    confirmButtonText: "Sí, eliminar!",   
    closeOnConfirm: false 
  }, function(){   
    validarEliminarDemandante(idInvolucrado);
  });
}

function validarEliminarDemandante(idInvolucrado)
{
  var vigenciaRadicado = $("#vigenciaRadicado").val();
  var idRadicado = $("#idRadicado").val();

  var ruta = base_url +'/'+ 'actuacionProc-judi/validarEliminarDemandante';   

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
          text: "El proceso no puede estar sin demandantes",   
          confirmButtonColor: "#f33923",   
          });
        return false;
      }
      else
      {
        swal("Eliminado!", "El Demandante ha sido eliminado exitosamente.", "success"); 
        demandantes();
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

function demandados()
{
  var vigenciaRadicado = $("#vigenciaRadicado").val();
  var idRadicado = $("#idRadicado").val();
  var responsable = $("#responsable").val();

  var ruta = base_url +'/'+ 'actuacionProc-judi/demandados';

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
      $("#resultadoDemandados").html(responseText);
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

function removerDemandado(idInvolucrado)
{
  swal({   
    title: "Está seguro de eliminar el demandado interno?",   
    text: "Se eliminará el demandado interno de la base de datos!",   
    type: "warning",   
    showCancelButton: true,   
    confirmButtonColor: "#f8b32d",   
    confirmButtonText: "Sí, eliminar!",   
    closeOnConfirm: false 
  }, function(){   
    validarRemoverDemandado(idInvolucrado);
  });
}

function validarRemoverDemandado(idInvolucrado)
{
  var vigenciaRadicado = $("#vigenciaRadicado").val();
  var idRadicado = $("#idRadicado").val();

  var ruta = base_url +'/'+ 'actuacionProc-judi/validarRemoverDemandado';   

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
          text: "El proceso no puede estar sin demandados internos",   
          confirmButtonColor: "#f33923",   
          });
        return false;
      }
      else
      {
        swal("Eliminado!", "El Demandado Interno ha sido eliminado exitosamente.", "success"); 
        demandados();
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

  var ruta = base_url +'/'+ 'actuacionProc-judi/accionadosExternos';

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

function abogadosExternos(tipoInvolucrado)
{
  var vigenciaRadicado = $("#vigenciaRadicado").val();
  var idRadicado = $("#idRadicado").val();
  var responsable = $("#responsable").val();

  var ruta = base_url +'/'+ 'actuacionProc-judi/abogadosExternos';

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

function modificarDatosGenerales()
{
  $('#modalEditarDatos').modal('show');

  var vigenciaRadicado = $("#vigenciaRadicado").val();
  var idRadicado = $("#idRadicado").val();

  var ruta = base_url +'/'+ 'actuacionProc-judi/modificarDatosGenerales';

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
  var selectMedioControl = $("#selectMedioControl").val();
  var selectTema         = $("#selectTema").val();

  var textoJuzgado       = $("#selectJuzgado option:selected").text();
  var textoMedioControl  = $("#selectMedioControl option:selected").text();
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

  var ruta = base_url +'/'+ 'actuacionProc-judi/validarEditarDatosGenerales';  

  var parametros = {  
    "vigenciaRadicado"   : vigenciaRadicado,
    "idRadicado"         : idRadicado,
    "selectJuzgado"      : selectJuzgado,
    "radicadoJuzgado"    : radicadoJuzgado,
    "selectMedioControl" : selectMedioControl,
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

