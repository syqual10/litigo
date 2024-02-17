var base_url = $('meta[name="base_url"]').attr('content'); 
var id_usuario = $('meta[name="id_usuario"]').attr('content'); 
var ciud_ope = $('meta[name="ciud_ope"]').attr('content'); 

var vectorAccionantes   = [];
var vectorAccionadosInt = [];
var vectorAccionadosExt = [];

function cargarJuzgado(conoceCodigo)
{
  // 0 No conoce el código
  // 1 conoce el código
  if(conoceCodigo == 1)
  {
    var selectJuzgados = '';
    var vigRadJuzgado = '';
  }
  else
  {
    var selectJuzgados = $("#selectJuzgados").val()
    var vigRadJuzgado = $("#vigRadJuzgado").val()
  }

  var ruta = base_url +'/'+ 'tutelas/cargarJuzgado';
  
  var codigoProceso = $('#codigoProceso').val();

  var parametros = {
    "codigoProceso" : codigoProceso,
    "conoceCodigo": conoceCodigo,
    "selectJuzgados": selectJuzgados,
    "vigRadJuzgado": vigRadJuzgado
  };
  
  $.ajax({                
    data:  parametros,               
    url:   ruta,
    type:  'post',
    beforeSend: function(){      
      cargaLoader('Consultando los juzgados.  Un momento por favor..');
    },
    success:  function (responseText) {
      ocultaLoader();
      if(responseText.codigoExiste == 0)// código ya registrado
      {
        swal({   
          title: "Atención!",   
          text: "El código del proceso ya se encuentra registrado en el radicado "+responseText.vigenciaRadicado+"-"+responseText.idRadicado,   
          confirmButtonColor: "#f33923",   
        });
        return false;
      }
      else if(responseText == 2)// no encuentra juzgado
      {
        swal({   
          title: "Atención!",   
          text: "No se encuentra coincidencia con algún juzgado",   
          confirmButtonColor: "#f33923",   
        });
        $('#ajax-cargarJuzgado').html('');
        $("#coincidenciaJuzgado").val(0);//encontró coincidencia
        return false;
      }
      else
      {
        $("#ajax-cargarJuzgado").html(responseText.vistaCodigoJuz);
        $("#coincidenciaJuzgado").val(1);//Si encontró coincidencia
        if(conoceCodigo == 0)// no conoce el código llena el campo código proceso
        {
          $("#codigoProceso").val(responseText.codigoProceso);
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

$('#documentoAccionante').keyup(function(e) {
  clearTimeout($.data(this, 'timer'));
  if (e.keyCode == 32)//32 espacio
    searchAccionante(true, 0);
  else
    $(this).data('timer', setTimeout(searchAccionante, 500));
});

$('#nombreAccionadoInt').keyup(function(e) {
  clearTimeout($.data(this, 'timer'));
  if (e.keyCode == 32)//32 espacio
    searchAccionadoInt(true, 0);
  else
    $(this).data('timer', setTimeout(searchAccionadoInt, 500));
});

$('#nombreAccionadoExt').keyup(function(e) {
  clearTimeout($.data(this, 'timer'));
  if (e.keyCode == 32)//32 espacio
    searchAccionadoExt(true, 0);
  else
    $(this).data('timer', setTimeout(searchAccionadoExt, 500));
});


function searchAccionante(force) 
{
  var search_string = $("#documentoAccionante").val(); 
  if (!force && search_string.length < 5) return;

  if(search_string == '')
  {
      limpiarAccionante();
  }
  else
  {   
    var ruta = base_url +'/'+ 'tutelas/busquedaAccionante';
    var parametros = {
      "criterioAccionante": search_string
    };

    $.ajax({
      data: parametros,
      url: ruta,
      type: 'post',
      success: function (responseText) {
        $("#searchresAccionante").html(responseText);
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

function searchAccionadoInt(force)
{
  var search_string = $("#nombreAccionadoInt").val(); 
  if (!force && search_string.length < 5) return;

  if(search_string == '')
  {
      limpiarAccionadoInt();
  }
  else
  {   
    var ruta = base_url +'/'+ 'tutelas/busquedaAccionadoInt';
    var parametros = {
      "criterioAccionadoInt": search_string
    };

    $.ajax({
      data: parametros,
      url: ruta,
      type: 'post',
      success: function (responseText) {
        $("#searchresAccionadoInt").html(responseText);
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

function searchAccionadoExt(force)
{
  var search_string = $("#nombreAccionadoExt").val(); 
  if (!force && search_string.length < 5) return;

  if(search_string == '')
  {
      limpiarAccionadoExt();
  }
  else
  {   
    var ruta = base_url +'/'+ 'tutelas/busquedaAccionadoExt';
    var parametros = {
      "criterioAccionadoExt": search_string
    };

    $.ajax({
      data: parametros,
      url: ruta,
      type: 'post',
      success: function (responseText) {
        $("#searchresAccionadoExt").html(responseText);
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

function limpiarAccionante()
{    
  $("#searchresAccionante").html('');
  $("#documentoAccionante").val("");
}

function limpiarAccionadoInt()
{
  $("#searchresAccionadoInt").html('');
  $("#nombreAccionadoInt").val("");
}

function limpiarAccionadoExt()
{
  $("#searchresAccionadoExt").html('');
  $("#nombreAccionadoExt").val("");
}

function seleccioneAccionante(idAccionante)
{
  vectorAccionantes.push(idAccionante);
  vectorAccionantes = $.unique(vectorAccionantes);
  var jsonAccionantes = JSON.stringify(vectorAccionantes); 

  var ruta = base_url +'/'+ 'tutelas/seleccioneAccionante';  

  var parametros = {
    "idAccionante" : idAccionante,
    "jsonAccionantes": jsonAccionantes
  };
  
  $.ajax({                
    data:  parametros,               
    url:   ruta,
    type:  'post',
    beforeSend: function(){      
      cargaLoader('Seleccionando Accionante.  Un momento por favor..');
    },
    success:  function (responseText) {
      ocultaLoader();
      $("#resultadoAccionantesSeleccionados").html(responseText);
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

function seleccioneAccionadoExt(idAccionadoExt)
{
  vectorAccionadosExt.push(idAccionadoExt);
  vectorAccionadosExt = $.unique(vectorAccionadosExt);
  var jsonAccionadoExt = JSON.stringify(vectorAccionadosExt); 

  var ruta = base_url +'/'+ 'tutelas/seleccioneAccionadoExt';
  

  var parametros = {
    "idAccionadoExt" : idAccionadoExt,
    "jsonAccionadoExt" : jsonAccionadoExt
  };
  
  $.ajax({                
    data:  parametros,               
    url:   ruta,
    type:  'post',
    beforeSend: function(){      
      cargaLoader('Seleccionando accionado externo.  Un momento por favor..');
    },
    success:  function (responseText) {
      ocultaLoader();
      $("#resultadoAccionadoExtsSeleccionados").html(responseText);
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

function seleccioneAccionadoInt(idAccionadoInt)
{
  vectorAccionadosInt.push(idAccionadoInt);
  vectorAccionadosInt = $.unique(vectorAccionadosInt);
  var jsonAccionadosInt = JSON.stringify(vectorAccionadosInt); 

  var ruta = base_url +'/'+ 'tutelas/seleccioneAccionadoInt';
  

  var parametros = {
    "idAccionadoInt" : idAccionadoInt,
    "jsonAccionadosInt" : jsonAccionadosInt
  };
  
  $.ajax({                
    data:  parametros,               
    url:   ruta,
    type:  'post',
    beforeSend: function(){      
      cargaLoader('Seleccionando accionado interno.  Un momento por favor..');
    },
    success:  function (responseText) {
      ocultaLoader();
      $("#resultadoAccionadosIntSeleccionados").html(responseText);
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

function removerAccionante(idAccionante)
{
  $('div#tablaAccionantes_'+idAccionante).remove();

  vectorAccionantes = $.grep(vectorAccionantes, function(value) {
    return value != idAccionante;
  });
  vectorAccionantes = $.unique(vectorAccionantes);
}

function removerAccionadoInt(idAccionadoInt)
{
  $('div#tablaAccionadosInt_'+idAccionadoInt).remove();

  vectorAccionadosInt = $.grep(vectorAccionadosInt, function(value) {
    return value != idAccionadoInt;
  });
  vectorAccionadosInt = $.unique(vectorAccionadosInt);
}

function removerAccionadoExt(idAccionadoExt)
{
  $('div#tablaAccionadosExt_'+idAccionadoExt).remove();

  vectorAccionadosExt = $.grep(vectorAccionadosExt, function(value) {
    return value != idAccionadoExt;
  });
  vectorAccionadosExt = $.unique(vectorAccionadosExt);
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

  var ruta = base_url +'/'+ 'tutelas/nuevoAccionante';  

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

function nuevoAccionadoExt()
{
  $('#modalAgregarAccionadoExt').modal(
    {
     show: true,
     keyboard: false,
     backdrop: 'static'
    }
  ); 

  var ruta = base_url +'/'+ 'tutelas/nuevoAccionadoExt';  

  $.ajax({                
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoAgregarAccionadoExt").html(responseText);
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

function elegirBarrioAccionante(idCiudad)
{
  var ciudadOperacion = ciud_ope;
  
  if(idCiudad == ciudadOperacion )//339 id de Manizales en la tabla ciudades, si es la de operación
  {
    var ruta = base_url +'/'+ 'tutelas/elegirBarrioAccionante';    

    var parametros = {
      "ciudadOperacion": ciudadOperacion// es la ciudad de operación, guarda el barrio
    };

    $("#resultadoBarrioAccionante").css("display", "block");

    $.ajax({                
      data: parametros,                
      url:   ruta,
      type:  'post',
      beforeSend: function(){      
        cargaLoader('Consultando territorios.  Un momento por favor..');
      },
      success:  function (responseText) {
        ocultaLoader();
        $("#resultadoBarrioAccionante").html(responseText);
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
    $("#resultadoBarrioAccionante").css("display", "none");
    $("#selectBarrioAccionante").val(0);
  }
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

function validarGuardarAccionante()
{
  var ciudadOperacion = ciud_ope;
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

  var ruta = base_url +'/'+ 'tutelas/validarGuardarAccionante';

  var parametros = {  
    "documentoAccionanteNuevo" : documentoAccionanteNuevo,
    "selecTipoDocumento" : selecTipoDocumento,
    "nombreAccionante" : nombreAccionante,
    "correoAccionante" : correoAccionante,
    "telefonoAccionante": telefonoAccionante,
    "celularAccionante" : celularAccionante,
    "direccionAccionante" : direccionAccionante,
    "selectCiudadAccionante" : selectCiudadAccionante,
    "selectBarrioAccionante" : selectBarrioAccionante
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
        seleccioneAccionante(responseText);
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

function validarGuardarAccionadoExt()
{
  var nombreAccionadoExterno = $("#nombreAccionadoExterno").val();
  var direccionAccionadoExterno = $("#direccionAccionadoExterno").val();
  var telefonoAccionadoExterno = $("#telefonoAccionadoExterno").val();

  if(nombreAccionadoExterno == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe ingresar el nombre del Accionado externo",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  var ruta = base_url +'/'+ 'tutelas/validarGuardarAccionadoExt';

  var parametros = {  
    "nombreAccionadoExterno" : nombreAccionadoExterno,
    "direccionAccionadoExterno" : direccionAccionadoExterno,
    "telefonoAccionadoExterno" : telefonoAccionadoExterno
  };
  
  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',
    beforeSend: function(){      
      cargaLoader('Guardando accionado externo. Un momento por favor..');
      $('.btn-guardar-accionadoExt').html('<span class="fa fa-spinner fa-spin"></span> Procesando...');
      $('.btn-guardar-accionadoExt').css({ 'pointer-events': 'none' });
    },
    success:  function (responseText) {
      ocultaLoader();
      if(responseText == 0)// nombre repetido
      {
        swal({   
          title: "Atención!",   
          text: "El accionado externo ya se encuentra registrado",   
          confirmButtonColor: "#f33923",   
        });
        $('.btn-guardar-accionadoExt').html('<span class="fa fa-save"></span> Guardar');
        $('.btn-guardar-accionadoExt').css({ 'pointer-events': 'auto' });
        return false;
      }
      else
      {
        $('#modalAgregarAccionadoExt').modal('hide');
        seleccioneAccionadoExt(responseText);
        swal("Guardado!", "El accionado externo ha sido guardado exitosamente.", "success"); 
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

function editarAccionadoExt(idAccionadoExt)
{
  $('#modalEditarAccionadoExt').modal(
    {
     show: true,
     keyboard: false,
     backdrop: 'static'
    }
  ); 

  var ruta = base_url +'/'+ 'tutelas/editarAccionadoExt';  

  var parametros = {  
    "idAccionadoExt" : idAccionadoExt
  };
  
  $.ajax({                
    data:  parametros,          
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoAccionadoConvocadoExt").html(responseText);
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
        seleccioneAccionante(idAccionante);
        swal("Modificado!", "El Accionante ha sido modidicado exitosamente.", "success"); 
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

function validarEditarAccionadoExt(idAccionadoExt)
{
  var nombreAccionadoExternoEditar = $("#nombreAccionadoExternoEditar").val();
  var direccionAccionadoExternoEditar = $("#direccionAccionadoExternoEditar").val();
  var telefonoAccionadoExternoEditar = $("#telefonoAccionadoExternoEditar").val();

  if(nombreAccionadoExternoEditar == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe ingresar el nombre del convocado externo",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  var ruta = base_url +'/'+ 'tutelas/validarEditarAccionadoExt';

  var parametros = {  
    "idAccionadoExt" : idAccionadoExt,
    "nombreAccionadoExternoEditar" : nombreAccionadoExternoEditar,
    "direccionAccionadoExternoEditar" : direccionAccionadoExternoEditar,
    "telefonoAccionadoExternoEditar" : telefonoAccionadoExternoEditar
  };
  
  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',
    beforeSend: function(){      
      cargaLoader('Guardando accionado externo. Un momento por favor..');
      $('.btn-editar-accionadoExt').html('<span class="fa fa-spinner fa-spin"></span> Procesando...');
      $('.btn-editar-accionadoExt').css({ 'pointer-events': 'none' });
    },
    success:  function (responseText) {
      ocultaLoader();
      if(responseText == 0)// nombre repetido
      {
        swal({   
          title: "Atención!",   
          text: "El accionado externo ya se encuentra registrado",   
          confirmButtonColor: "#f33923",   
        });
        $('.btn-guardar-accionadoExt').html('<span class="fa fa-save"></span> Guardar');
        $('.btn-guardar-accionadoExt').css({ 'pointer-events': 'auto' });
        return false;
      }
      else
      {
        $('#modalEditarAccionadoExt').modal('hide');
        seleccioneAccionadoExt(idAccionadoExt);
        swal("Modificado!", "El accionado externo ha sido modificado exitosamente.", "success"); 
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

function validarGuardarRadicado()
{
  var idTipoProceso = $("#idTipoProceso").val();
  var coincidenciaJuzgado = $("#coincidenciaJuzgado").val();
  var codigoProceso = $("#codigoProceso").val();
  var selectTema = $("#selectTema").val();
  var asunto = $("#asunto").val();
  var fechaNotifi = $("#fechaNotifi").val();
  var descripcionHechos = $("#descripcionHechos").val();
  var idJuzgado = $("#idJuzgado").val();
  var tipoPlazo = '';
  var tipoTiempo = '';
  var cantidadPlazo = '';

  if(coincidenciaJuzgado == 0)
  {
    swal({   
      title: "Atención!",   
      text: "No se encontró coincidencia con ningún juzgado",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(codigoProceso == '')
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Ingrese el código del proceso",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if (asunto == "") {
    swal({
      title: "Campo sin diligenciar!",
      text: "Ingrese el asunto del proceso",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  if(selectTema == '')
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Ingrese el tema del proceso",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(vectorAccionantes.length == 0)
  {
    swal({   
      title: "Atención!",   
      text: "No hay Accionantes seleccionados",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }
  var jsonAccionantes = JSON.stringify(vectorAccionantes);

  if(vectorAccionadosInt.length == 0)
  {
    swal({   
      title: "Atención!",   
      text: "No hay demandados seleccionados",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }
  var jsonAccionadosInt = JSON.stringify(vectorAccionadosInt);

  var jsonAccionadosExt = JSON.stringify(vectorAccionadosExt);

  if(descripcionHechos == '')
  {
    swal({   
      title: "Atención!",   
      text: "Ingrese una descripción de los hechos",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if($("#plazoPersonalizado").is(':checked'))
  {
    tipoPlazo = $("#selectTipoPlazo").val();
    tipoTiempo = $("#selectTipoTiempo").val();
    cantidadPlazo = $("#cantidad").val();

    if(tipoPlazo == 0)
    {
      swal({   
        title: "Atención!",   
        text: "Seleccione el tipo de plazo",   
        confirmButtonColor: "#f33923",   
      });
      return false;
    }

    if(tipoTiempo == 0)
    {
      swal({   
        title: "Atención!",   
        text: "Seleccione el tipo de tiempo",   
        confirmButtonColor: "#f33923",   
      });
      return false;
    }

    if(cantidadPlazo == '' || cantidadPlazo < 1)
    {
      swal({   
        title: "Atención!",   
        text: "Ingrese la cantidad del plazo",   
        confirmButtonColor: "#f33923",   
      });
      return false;
    }
  }
  
  var ruta = base_url +'/'+ 'tutelas/validarGuardarRadicado';

  var parametros = {  
    idTipoProceso,
    selectTema,
    jsonAccionantes,
    jsonAccionadosInt,
    jsonAccionadosExt,
    fechaNotifi,
    codigoProceso,
    asunto,
    descripcionHechos,
    idJuzgado,
    tipoPlazo,
    tipoTiempo,
    cantidadPlazo
  };
  
  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',
    beforeSend: function(){  
      cargaLoader('Guardando la tutela y generando radicado.  Un momento por favor..');    
      $('.buttonFinish').html('<span class="fa fa-spinner fa-spin"></span> Procesando...');
      $('.buttonFinish').css({ 'pointer-events': 'none' });
    },
    success:  function (responseText) {
      ocultaLoader();
      if(responseText == 1)
      {
        swal({   
          title: "Atención!",   
          text: "No hay responsables asignados al reparto",   
          confirmButtonColor: "#f33923",   
        });
        $('.buttonFinish').html('Terminar');
        $(".buttonFinish").prop("disabled", true);
        return false;
      }
      else if(responseText == 1)
      {
        swal({   
          title: "Atención!",   
          text: "No se pudo mover el archivo",   
          confirmButtonColor: "#f33923",   
        });
      }
      else
      {
        $("#idRadicadoIni").val(responseText.idRadicado);
        $("#vigenciaRadicadoIni").val(responseText.vigenciaRadicado);

        var responsablesSiguiente = JSON.parse(JSON.stringify(responseText.resposanblesReparto));

        if(responsablesSiguiente.length > 0)
        {
          for(var i = 0; i < responsablesSiguiente.length; i++)
          {  
            socket.emit("server_nuevoEnBuzon", {idUsuarioSiguiente: responsablesSiguiente[i]['usuarios_idUsuario'], mensaje: "Le fue asignado el radicado: " + responseText.vigenciaRadicado + "-" + responseText.idRadicado + ", por favor revise su buzón."});
          } 
        }
        $('.buttonFinish').html('Terminar');
        $(".buttonFinish").prop("disabled", true);

        var myDropzone = Dropzone.forElement("#dropzoneRadicarProcesoTutelas");
        myDropzone.processQueue();

        if(Object.keys(myDropzone.files).length == 0){
        
          swal({   
            title: "Radicado: " + responseText.vigenciaRadicado + "-" + responseText.idRadicado,   
            text: "Seleccione una de las opciones",   
            type: "success",   
            showCancelButton: true,   
            confirmButtonColor: "#23b5e6",   
            confirmButtonText: "Generar el Rótulo de Carpeta",   
            cancelButtonText: "Radicar un nuevo proceso",   
            closeOnConfirm: true,   
            closeOnCancel: true 
          }, function(isConfirm){   
            if (isConfirm) 
            {   
              generarCaratula(responseText.vigenciaRadicado, responseText.idRadicado);
            } 
            else 
            {   
              var rutaRedirect = base_url +'/'+ 'tutelas/index/'+idTipoProceso;
              setTimeout(function(){  window.location.href = rutaRedirect; }, 1000); 
            } 
          });
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

function informacionPdf(vigenciaRadicado, idRadicado)
{
  $('#modalPdfInformacion').modal(
    {
     show: true,
     keyboard: false,
     backdrop: 'static'
    }
  ); 

  var rutaRedirect = base_url +'/'+ 'tutelas/informacionPdf';
  document.getElementById("framePdfInformacion").src = rutaRedirect +"/"+ vigenciaRadicado+"/"+ idRadicado;
}

function conoceCodigoProceso()
{
  if($("#infoCodigoProceso").is(':checked'))
  {
    $("#divCodigoCompleto").css("display", "block");
    $("#divJuzgados").css("display", "none");
  }
  else
  {
    $("#divCodigoCompleto").css("display", "none");
    $("#divJuzgados").css("display", "block");
  }
}

function iniciarDropzoneRadica()
{
  var ruta = base_url +'/'+ 'tutelas/iniciarDropzoneRadica';

  var rutaArchivoRadica = base_url +'/'+ 'tutelas/uploadArchivoRadicacion';

  $.ajax({
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoArchivoRadica").html(responseText);
      Dropzone.autoDiscover = false;
      var myDropzonePostRadica = new Dropzone("#dropzoneRadicarProcesoTutelas",{
        autoProcessQueue: false,
        url: rutaArchivoRadica,
        addRemoveLinks: true,
        maxFiles: 10,
        parallelUploads: 10,
        init: function (){
          // Update selector to match your button
          this.on('sending', function(file, xhr, formData)
          {
            var vigenciaRadicado = $("#vigenciaRadicadoIni").val();
            var idRadicado = $("#idRadicadoIni").val();
            // Append all form inputs to the formData Dropzone will POST
            var data = $('#dropzoneRadicarProcesoTutelas').serializeArray();
            formData.append("vigenciaRadicado",vigenciaRadicado);
            formData.append("idRadicado",idRadicado);
          });
        },
        queuecomplete: function (file) {
          var vigenciaRadicado = $("#vigenciaRadicadoIni").val();
          var idRadicado = $("#idRadicadoIni").val();
          var idTipoProceso = $("#idTipoProceso").val();
          swal({   
            title: "Radicado: " + vigenciaRadicado + "-" + idRadicado,   
            text: "Seleccione una de las opciones",   
            type: "success",   
            showCancelButton: true,   
            confirmButtonColor: "#23b5e6",   
            confirmButtonText: "Generar el Rótulo de Carpeta",   
            cancelButtonText: "Radicar un nuevo proceso",   
            closeOnConfirm: true,   
            closeOnCancel: true 
          }, function(isConfirm){   
            if (isConfirm) 
            {   
              generarCaratula(vigenciaRadicado, idRadicado);
            } 
            else 
            {   
              var rutaRedirect = base_url +'/'+ 'tutelas/index/'+idTipoProceso;
              setTimeout(function(){  window.location.href = rutaRedirect; }, 1000); 
            } 
          });
        },
        error: function(file, message) {

          var vigenciaRadicado = $("#vigenciaRadicadoIni").val();
          var idRadicado = $("#idRadicadoIni").val();
          var idTipoProceso = $("#idTipoProceso").val();

          swal({
            title: "Ocurrio un Error con los archivos contacte al administrador!",
            text: "Radicado: " + vigenciaRadicado + "-" + idRadicado,
            type: "error"
            },function(){   
              var rutaRedirect = base_url +'/'+ 'tutelas/index/'+idTipoProceso;
              setTimeout(function(){  window.location.href = rutaRedirect; }, 1000); 
            }
          );
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

function mantenerMask()
{
  var maskJuzgado = $("#codigoProceso").val();
  $("#maskHidden").val(maskJuzgado);
}

function keepMask()
{
  var codigoProceso = 23;
  var caracter='';
  var maskHidden = $("#maskHidden").val();
  maskHiddenR = maskHidden.replace(/X|-/g,'');
  var faltantes = codigoProceso - maskHiddenR.length;
  if(maskHiddenR.length > 0)
  {
    for(var i = 0; i < faltantes; i++)
    {
      caracter+='0';
    }
  }
  $("#codigoProceso").val(maskHiddenR+caracter);
}

function plazoPersonalizado()
{
  if($("#plazoPersonalizado").is(':checked'))
  {
    $("#resultadoPlazoPersonalizado").css("display", "block");

    var ruta = base_url +'/'+ 'tutelas/plazoPersonalizado';

    $.ajax({                
      url:   ruta,
      type:  'post',
      success:  function (responseText) {
        $("#resultadoPlazoPersonalizado").html(responseText);
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
    $("#resultadoPlazoPersonalizado").css("display", "none");
  }
}