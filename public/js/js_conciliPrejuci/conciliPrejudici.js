var base_url = $('meta[name="base_url"]').attr('content'); 
var id_usuario = $('meta[name="id_usuario"]').attr('content'); 
var ciud_ope = $('meta[name="ciud_ope"]').attr('content'); 

var vectorConvocantes   = [];
var vectorConvocadosInt = [];
var vectorConvocadosExt = [];
var vectorAbogados      = [];

$('#documentoConvocante').keyup(function(e) {
  clearTimeout($.data(this, 'timer'));
  if (e.keyCode == 32)//32 espacio
    searchConvocante(true, 0);
  else
    $(this).data('timer', setTimeout(searchConvocante, 500));
});

$('#nombreConvocadoInt').keyup(function(e) {
  clearTimeout($.data(this, 'timer'));
  if (e.keyCode == 32)//32 espacio
    searchConvocadoInt(true, 0);
  else
    $(this).data('timer', setTimeout(searchConvocadoInt, 500));
});

$('#nombreConvocadoExt').keyup(function(e) {
  clearTimeout($.data(this, 'timer'));
  if (e.keyCode == 32)//32 espacio
    searchConvocadoExt(true, 0);
  else
    $(this).data('timer', setTimeout(searchConvocadoExt, 500));
});

function searchConvocante(force) 
{
  var search_string = $("#documentoConvocante").val(); 
  if (!force && search_string.length < 5) return;

  if(search_string == '')
  {
      limpiarConvocante();
  }
  else
  {   
    var ruta = base_url +'/'+ 'concil-prej/busquedaConvocante';
    var parametros = {
      "criterioConvocante": search_string
    };

    $.ajax({
      data: parametros,
      url: ruta,
      type: 'post',
      success: function (responseText) {
        $("#searchresConvocante").html(responseText);
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

function searchConvocadoInt(force)
{
  var search_string = $("#nombreConvocadoInt").val(); 
  if (!force && search_string.length < 5) return;

  if(search_string == '')
  {
      limpiarConvocadoInt();
  }
  else
  {   
    var ruta = base_url +'/'+ 'concil-prej/busquedaConvocadoInt';
    var parametros = {
      "criterioConvocadoInt": search_string
    };

    $.ajax({
      data: parametros,
      url: ruta,
      type: 'post',
      success: function (responseText) {
        $("#searchresConvocadoInt").html(responseText);
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

function searchConvocadoExt(force)
{
  var search_string = $("#nombreConvocadoExt").val(); 
  if (!force && search_string.length < 5) return;

  if(search_string == '')
  {
      limpiarConvocadoExt();
  }
  else
  {   
    var ruta = base_url +'/'+ 'concil-prej/busquedaConvocadoExt';
    var parametros = {
      "criterioConvocadoExt": search_string
    };

    $.ajax({
      data: parametros,
      url: ruta,
      type: 'post',
      success: function (responseText) {
        $("#searchresConvocadoExt").html(responseText);
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

function limpiarConvocante()
{    
  $("#searchresConvocante").html('');
  $("#documentoConvocante").val("");
}

function limpiarConvocadoInt()
{
  $("#searchresConvocadoInt").html('');
  $("#nombreConvocadoInt").val("");
}

function limpiarConvocadoExt()
{
  $("#searchresConvocadoExt").html('');
  $("#nombreConvocadoExt").val("");
}

function seleccioneConvocante(idConvocante)
{
  vectorConvocantes.push(idConvocante);
  vectorConvocantes = $.unique(vectorConvocantes);
  var jsonConvocantes = JSON.stringify(vectorConvocantes); 

  var ruta = base_url +'/'+ 'concil-prej/seleccioneConvocante';  

  var parametros = {
    "idConvocante" : idConvocante,
    "jsonConvocantes": jsonConvocantes
  };
  
  $.ajax({                
    data:  parametros,               
    url:   ruta,
    type:  'post',
    beforeSend: function(){      
      cargaLoader('Seleccionando Convocante.  Un momento por favor..');
    },
    success:  function (responseText) {
      ocultaLoader();
      $("#resultadoConvocantesSeleccionados").html(responseText);
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

function seleccioneConvocadoInt(idConvocadoInt)
{
  vectorConvocadosInt.push(idConvocadoInt);
  vectorConvocadosInt = $.unique(vectorConvocadosInt);
  var jsonConvocadosInt = JSON.stringify(vectorConvocadosInt); 

  var ruta = base_url +'/'+ 'concil-prej/seleccioneConvocadoInt';
  

  var parametros = {
    "idConvocadoInt" : idConvocadoInt,
    "jsonConvocadosInt" : jsonConvocadosInt
  };
  
  $.ajax({                
    data:  parametros,               
    url:   ruta,
    type:  'post',
    beforeSend: function(){      
      cargaLoader('Seleccionando convocado interno.  Un momento por favor..');
    },
    success:  function (responseText) {
      ocultaLoader();
      $("#resultadoConvocadoIntSeleccionados").html(responseText);
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

function seleccioneConvocadoExt(idConvocadoExt)
{
  vectorConvocadosExt.push(idConvocadoExt);
  vectorConvocadosExt = $.unique(vectorConvocadosExt);
  var jsonConvocadosExt = JSON.stringify(vectorConvocadosExt); 

  var ruta = base_url +'/'+ 'concil-prej/seleccioneConvocadoExt';
  

  var parametros = {
    "idConvocadoExt" : idConvocadoExt,
    "jsonConvocadosExt" : jsonConvocadosExt
  };
  
  $.ajax({                
    data:  parametros,               
    url:   ruta,
    type:  'post',
    beforeSend: function(){      
      cargaLoader('Seleccionando convocado externo.  Un momento por favor..');
    },
    success:  function (responseText) {
      ocultaLoader();
      $("#resultadoConvocadoExtsSeleccionados").html(responseText);
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

function removerConvocante(idConvocante)
{
  $('div#tablaConvocantes_'+idConvocante).remove();

  vectorConvocantes = $.grep(vectorConvocantes, function(value) {
    return value != idConvocante;
  });
  vectorConvocantes = $.unique(vectorConvocantes);
}

function removerConvocadoInt(idConvocadoInt)
{
  $('div#tablaConvocadosInt_'+idConvocadoInt).remove();

  vectorConvocadosInt = $.grep(vectorConvocadosInt, function(value) {
    return value != idConvocadoInt;
  });
  vectorConvocadosInt = $.unique(vectorConvocadosInt);
}

function removerConvocadoExt(idConvocadoExt)
{
  $('div#tablaConvocadosExt_'+idConvocadoExt).remove();

  vectorConvocadosExt = $.grep(vectorConvocadosExt, function(value) {
    return value != idConvocadoExt;
  });
  vectorConvocadosExt = $.unique(vectorConvocadosExt);
}

function nuevoConvocante()
{
  $('#modalAgregarConvocante').modal(
    {
     show: true,
     keyboard: false,
     backdrop: 'static'
    }
  ); 

  var ruta = base_url +'/'+ 'concil-prej/nuevoConvocante';  

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

function nuevoConvocadoExt()
{
  $('#modalAgregarConvocadoExt').modal(
    {
     show: true,
     keyboard: false,
     backdrop: 'static'
    }
  ); 

  var ruta = base_url +'/'+ 'concil-prej/nuevoConvocadoExt';  

  $.ajax({                
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoAgregarConvocadoExt").html(responseText);
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

function elegirBarrioConvocante(idCiudad)
{
  var ciudadOperacion = ciud_ope;
  
  if(idCiudad == ciudadOperacion )//339 id de Manizales en la tabla ciudades, si es la de operación
  {
    var ruta = base_url +'/'+ 'concil-prej/elegirBarrioConvocante';    

    var parametros = {
      "ciudadOperacion": ciudadOperacion// es la ciudad de operación, guarda el barrio
    };

    $("#resultadoBarrioConvocante").css("display", "block");

    $.ajax({                
      data: parametros,                
      url:   ruta,
      type:  'post',
      beforeSend: function(){      
        cargaLoader('Consultando territorios.  Un momento por favor..');
      },
      success:  function (responseText) {
        ocultaLoader();
        $("#resultadoBarrioConvocante").html(responseText);
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
    $("#resultadoBarrioConvocante").css("display", "none");
    $("#selectBarrioConvocante").val(0);
  }
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

function validarGuardarConvocante()
{
  var ciudadOperacion = ciud_ope;
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

  var ruta = base_url +'/'+ 'concil-prej/validarGuardarConvocante';

  var parametros = {  
    "documentoConvocanteNuevo" : documentoConvocanteNuevo,
    "selecTipoDocumento" : selecTipoDocumento,
    "nombreConvocante" : nombreConvocante,
    "correoConvocante" : correoConvocante,
    "telefonoConvocante": telefonoConvocante,
    "celularConvocante" : celularConvocante,
    "direccionConvocante" : direccionConvocante,
    "selectCiudadConvocante" : selectCiudadConvocante,
    "selectBarrioConvocante" : selectBarrioConvocante
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
        seleccioneConvocante(responseText);
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

function validarGuardarConvocadoExt()
{
  var nombreConvocadoExterno = $("#nombreConvocadoExterno").val();
  var direccionConvocadoExterno = $("#direccionConvocadoExterno").val();
  var telefonoConvocadoExterno = $("#telefonoConvocadoExterno").val();

  if(nombreConvocadoExterno == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe ingresar el nombre del convocado externo",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  var ruta = base_url +'/'+ 'concil-prej/validarGuardarConvocadoExt';

  var parametros = {  
    "nombreConvocadoExterno" : nombreConvocadoExterno,
    "direccionConvocadoExterno" : direccionConvocadoExterno,
    "telefonoConvocadoExterno" : telefonoConvocadoExterno
  };
  
  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',
    beforeSend: function(){      
      cargaLoader('Guardando convocado externo. Un momento por favor..');
      $('.btn-guardar-convocadoExt').html('<span class="fa fa-spinner fa-spin"></span> Procesando...');
      $('.btn-guardar-convocadoExt').css({ 'pointer-events': 'none' });
    },
    success:  function (responseText) {
      ocultaLoader();
      if(responseText == 0)// nombre repetido
      {
        swal({   
          title: "Atención!",   
          text: "El convocado externo ya se encuentra registrado",   
          confirmButtonColor: "#f33923",   
        });
        $('.btn-guardar-convocadoExt').html('<span class="fa fa-save"></span> Guardar');
        $('.btn-guardar-convocadoExt').css({ 'pointer-events': 'auto' });
        return false;
      }
      else
      {
        $('#modalAgregarConvocadoExt').modal('hide');
        seleccioneConvocadoExt(responseText);
        swal("Guardado!", "El convocado externo ha sido guardado exitosamente.", "success"); 
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

function editarConvocadoExt(idConvocadoExt)
{
  $('#modalEditarConvocadoExt').modal(
    {
     show: true,
     keyboard: false,
     backdrop: 'static'
    }
  ); 

  var ruta = base_url +'/'+ 'concil-prej/editarConvocadoExt';  

  var parametros = {  
    "idConvocadoExt" : idConvocadoExt
  };
  
  $.ajax({                
    data:  parametros,          
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoEditarConvocadoExt").html(responseText);
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
        seleccioneConvocante(idConvocante);
        swal("Modificado!", "El Convocante ha sido modidicado exitosamente.", "success"); 
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

function validarEditarConvocadoExt(idConvocadoExt)
{
  var nombreConvocadoExternoEditar = $("#nombreConvocadoExternoEditar").val();
  var direccionConvocadoExternoEditar = $("#direccionConvocadoExternoEditar").val();
  var telefonoConvocadoExternoEditar = $("#telefonoConvocadoExternoEditar").val();

  if(nombreConvocadoExternoEditar == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe ingresar el nombre del convocado externo",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  var ruta = base_url +'/'+ 'concil-prej/validarEditarConvocadoExt';

  var parametros = {  
    "idConvocadoExt" : idConvocadoExt,
    "nombreConvocadoExternoEditar" : nombreConvocadoExternoEditar,
    "direccionConvocadoExternoEditar" : direccionConvocadoExternoEditar,
    "telefonoConvocadoExternoEditar" : telefonoConvocadoExternoEditar
  };
  
  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',
    beforeSend: function(){      
      cargaLoader('Modificando convocado externo. Un momento por favor..');
      $('.btn-editar-convocadoExt').html('<span class="fa fa-spinner fa-spin"></span> Procesando...');
      $('.btn-editar-convocadoExt').css({ 'pointer-events': 'none' });
    },
    success:  function (responseText) {
      ocultaLoader();
      if(responseText == 0)// nombre repetido
      {
        swal({   
          title: "Atención!",   
          text: "El convocado externo ya se encuentra registrado",   
          confirmButtonColor: "#f33923",   
        });
        $('.btn-guardar-convocadoExt').html('<span class="fa fa-save"></span> Guardar');
        $('.btn-guardar-convocadoExt').css({ 'pointer-events': 'auto' });
        return false;
      }
      else
      {
        $('#modalEditarConvocadoExt').modal('hide');
        seleccioneConvocadoExt(idConvocadoExt);
        swal("Modificado!", "El convocado externo ha sido modificado exitosamente.", "success"); 
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

function iniciarDropzoneRadica()
{
  var ruta = base_url +'/'+ 'concil-prej/iniciarDropzoneRadica';

  var rutaArchivoRadica = base_url +'/'+ 'concil-prej/uploadArchivoRadicacion';

  $.ajax({
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoArchivoRadica").html(responseText);
      Dropzone.autoDiscover = false;
      var myDropzonePostRadica = new Dropzone("#dropzoneRadicarConci",{
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
            var data = $('#dropzoneRadicarConci').serializeArray();
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
              var rutaRedirect = base_url +'/'+ 'concil-prej/index/'+idTipoProceso;
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
                var rutaRedirect = base_url +'/'+ 'concil-prej/index/'+idTipoProceso;
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

function validarGuardarRadicado()
{
  var idTipoProceso = $("#idTipoProceso").val();
  var sentidoConvocante = $('input[name=sentidoConvocante]:checked').val();   
  var selectMedioControl = $("#selectMedioControl").val();
  var asunto = $("#asunto").val();
  var fechaNotifi = $("#fechaNotifi").val();
  var descripcionHechos = $("#descripcionHechos").val();
  var selectTema = $("#selectTema").val();
  var jsonAbogados = JSON.stringify(vectorAbogados);

  if(selectMedioControl == '')
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Ingrese la clase de proceso",   
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

  if(vectorConvocantes.length == 0)
  {
    swal({   
      title: "Atención!",   
      text: "No hay Convocantes seleccionados",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }
  var jsonConvocantes = JSON.stringify(vectorConvocantes);

  if(vectorConvocadosInt.length == 0)
  {
    swal({   
      title: "Atención!",   
      text: "No hay demandados seleccionados",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(selectTema == '')
  {
    swal({   
      title: "Atención!",   
      text: "Seleccione el tema",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  var jsonConvocadosInt = JSON.stringify(vectorConvocadosInt);

  var jsonConvocadosExt = JSON.stringify(vectorConvocadosExt);

  if(descripcionHechos == '')
  {
    swal({   
      title: "Atención!",   
      text: "Ingrese una descripción de los hechos",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  /* CUANTÍAS*/
  var selectUnidadMonetaria  = [];// 1 salarios 2 pesos
  var valor                  = [];//valor en pesos o valor en salarios
  var valorPesos             = [];//valor consolidado en salarios o pesos

  var campoSelectUnidadMonetaria;
  var campoValor;
  var campoValorPesos;

  $("#tablaCuantias tbody tr").each(function (index) 
  {
    $(this).children("td").each(function (indexCuantia) 
    {
        switch (indexCuantia) 
        {
            case 1: campoSelectUnidadMonetaria = $(this).text();
                    break;
            case 2: campoValor                 = $(this).text();
                    break;
            case 3: campoValorPesos         = $(this).text();
                    break;
        }
    })
    
    selectUnidadMonetaria.push(campoSelectUnidadMonetaria);
    valor.push(campoValor);
    valorPesos.push(campoValorPesos);
  });
  var jsonSelectUnidadMonetaria = JSON.stringify(selectUnidadMonetaria);
  var jsonValor                 = JSON.stringify(valor);
  var jsonValorPesos            = JSON.stringify(valorPesos);
  /* CUANTÍAS*/

  var ruta = base_url +'/'+ 'concil-prej/validarGuardarRadicado';

  var parametros = {  
    idTipoProceso,
    sentidoConvocante,
    selectMedioControl,
    asunto,
    fechaNotifi,
    jsonConvocantes,
    jsonConvocadosInt,
    jsonConvocadosExt,
    descripcionHechos,
    selectUnidadMonetaria,
    jsonSelectUnidadMonetaria,
    jsonValor,
    jsonValorPesos,
    selectTema,
    jsonAbogados
  };
  
  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',
    beforeSend: function(){  
      cargaLoader('Guardando la demanda y generando radicado.  Un momento por favor..');    
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
        var myDropzone = Dropzone.forElement("#dropzoneRadicarConci");
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
              var rutaRedirect = base_url +'/'+ 'concil-prej/index/'+idTipoProceso;
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

  var rutaRedirect = base_url +'/'+ 'concil-prej/informacionPdf';
  document.getElementById("framePdfInformacion").src = rutaRedirect +"/"+ vigenciaRadicado+"/"+ idRadicado;
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

function validarAgregarCuantia()
{
  $(".no-records-found").remove();
  var selectUnidadMonetaria = $("#selectUnidadMonetaria").val();// 1 salarios - 2 en pesos
  var valor = $("#valor").val();// valor en pesos
  var valorSalarios = $("#valorSalarios").val();// # de salarios
  var valorPesos = $("#valorPesos").val();// valor que cálcula en pesos o salrios readonly
  var valorUnidadMonetaria = ''; // la cantidad de salarios o el valor en pesos
  
  var unidadMonetaria  = '';
  var valorSeleccionado = '';
  valorPesos   = valorPesos.replace("$", "");

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
    unidadMonetaria = "Salaraios Mínimos";
    valorSeleccionado = valorSalarios;

    if(valorSalarios == '')
    {
      swal({   
        title: "Campo sin diligenciar!",   
        text: "Ingresar el número de salarios",   
        confirmButtonColor: "#f33923",   
      });
      return false;
    }
    else
    {
      valorUnidadMonetaria = valorSalarios;
    }
  }

  if(selectUnidadMonetaria == 2)// VALOR EN PESOS
  {
    unidadMonetaria = "Valor en pesos";
    valorSeleccionado = valor;

    if(valor == '')
    {
      swal({   
        title: "Campo sin diligenciar!",   
        text: "Ingresar el valor en pesos",   
        confirmButtonColor: "#f33923",   
      });
      return false;
    }
    else
    {
      valorUnidadMonetaria = valor;
    }
  }

  var tds = $("#tablaCuantias tr:first th").length;

  // Obtenemos el total de columnas (tr) del id "tabla"
  var trs=$("#tablaCuantias tr").length;
  var nuevaFila="<tr>";

  nuevaFila+='<td>'+unidadMonetaria+'</td>';
  nuevaFila+='<td style="display:none;">'+selectUnidadMonetaria+'</td>';
  nuevaFila+='<td>'+valorSeleccionado+'</td>';
  nuevaFila+='<td>'+valorPesos+'</td>';
  nuevaFila+='<td style="padding:0;"><button type="button" onclick="quitarFilaCuantia($(this));"><i class="fa fa-trash"></i></button></td>';

  nuevaFila+="</tr>";
  $("#tablaCuantias").append(nuevaFila);  

  $("#valor").val('');// valor en pesos
  $("#valorSalarios").val('');// # de salarios
}

function quitarFilaCuantia(row)
{
  row.closest('tr').remove();
  var nFilas = $("#tablaCuantias tr").length;
}

function nuevoAbogado()
{
  $('#modalAgregarAbogadoDemandante').modal(
    {
     show: true,
     keyboard: false,
     backdrop: 'static'
    }
  ); 

  var ruta = base_url +'/'+ 'concil-prej/nuevoAbogado';  

  $.ajax({                
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoAgregarAbogadoDemandante").html(responseText);
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

function seleccioneAbogado(idAbogado)
{
  vectorAbogados.push(idAbogado);
  vectorAbogados = $.unique(vectorAbogados);
  var jsonAbogados = JSON.stringify(vectorAbogados); 

  var ruta = base_url +'/'+ 'concil-prej/seleccioneAbogado';  

  var parametros = {
    "idAbogado" : idAbogado,
    "jsonAbogados": jsonAbogados
  };
  
  $.ajax({                
    data:  parametros,               
    url:   ruta,
    type:  'post',
    beforeSend: function(){      
      cargaLoader('Seleccionando abogado.  Un momento por favor..');
    },
    success:  function (responseText) {
      ocultaLoader();
      $("#resultadoAbogadosSeleccionados").html(responseText);
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

function validarGuardarAbogado()
{
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

  var ruta = base_url +'/'+ 'concil-prej/validarGuardarAbogado';

  var parametros = {  
    "documentoAbogado" : documentoAbogado,
    "selecTipoDocumentoAbogado" : selecTipoDocumentoAbogado,
    "nombreAbogado" : nombreAbogado,
    "tarjetaAbogado" : tarjetaAbogado
  };
  
  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',
    beforeSend: function(){      
      cargaLoader('Guardando abogado. Un momento por favor..');
      $('.btn-guardar-abogado').html('<span class="fa fa-spinner fa-spin"></span> Procesando...');
      $('.btn-guardar-abogado').css({ 'pointer-events': 'none' });
    },
    success:  function (responseText) {
      ocultaLoader();
      if(responseText == 0)// documento repetido
      {
        swal({   
          title: "Atención!",   
          text: "El abogado ya se encuentra registrado",   
          confirmButtonColor: "#f33923",   
        });
        $('.btn-guardar-abogado').html('<span class="fa fa-save"></span> Guardar');
        $('.btn-guardar-abogado').css({ 'pointer-events': 'auto' });
        return false;
      }
      else
      {
        $('#modalAgregarAbogadoDemandante').modal('hide');
        seleccioneAbogado(responseText);
        swal("Guardado!", "El abogado ha sido guardado exitosamente.", "success"); 
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

$('#documentoAbogado').keyup(function(e) {
  clearTimeout($.data(this, 'timer'));
  if (e.keyCode == 32)//32 espacio
    searchAbogadoDemandante(true, 0);
  else
    $(this).data('timer', setTimeout(searchAbogadoDemandante, 500));
});

function searchAbogadoDemandante(force)
{
  var search_string = $("#documentoAbogado").val(); 
  if (!force && search_string.length < 5) return;

  if(search_string == '')
  {
      limpiarAbogadoDemandante();
  }
  else
  {   
    var ruta = base_url +'/'+ 'concil-prej/busquedaAbogadoDemandante';
    var parametros = {
      "criterioAbogado": search_string
    };

    $.ajax({
      data: parametros,
      url: ruta,
      type: 'post',
      success: function (responseText) {
        $("#searchresAbogado").html(responseText);
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

function limpiarAbogadoDemandante()
{    
  $("#searchresAbogado").html('');
  $("#documentoAbogado").val("");
}

function editarAbogado(idAbogado)
{
  $('#modalEditarAbogadoDemandante').modal(
    {
     show: true,
     keyboard: false,
     backdrop: 'static'
    }
  ); 

  var ruta = base_url +'/'+ 'concil-prej/editarAbogado';  

  var parametros = {  
    "idAbogado" : idAbogado
  };
  
  $.ajax({                
    data:  parametros,          
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoEditarAbogadoDemandandante").html(responseText);
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

function validarEditarAbogado(idAbogado)
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

  var ruta = base_url +'/'+ 'concil-prej/validarEditarAbogado';

  var parametros = {  
    "idAbogado": idAbogado,
    "documentoAbogadoDemandanteEditar" : documentoAbogadoDemandanteEditar,
    "selecTipoDocumentoAbogadoEditar" : selecTipoDocumentoAbogadoEditar,
    "nombreAbogadoEditar" : nombreAbogadoEditar,
    "tarjetaAbogadoEditar" : tarjetaAbogadoEditar
  };
  
  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',
    beforeSend: function(){  
      cargaLoader('Modificando abogado.  Un momento por favor..');    
      $('.btn-editar-abogado').html('<span class="fa fa-spinner fa-spin"></span> Procesando...');
      $('.btn-editar-abogado').css({ 'pointer-events': 'none' });
    },
    success:  function (responseText) {
      ocultaLoader();
      if(responseText == 0)// documento repetido
      {
        swal({   
          title: "Atención!",   
          text: "El abogado ya se encuentra registrado",   
          confirmButtonColor: "#f33923",   
        });
        $('.btn-editar-abogado').html('<span class="fa fa-save"></span> Modificado');
        $('.btn-editar-abogado').css({ 'pointer-events': 'auto' });
        return false;
      }
      else
      {
        $('#modalEditarAbogadoDemandante').modal('hide');
        seleccioneAbogado(idAbogado);
        swal("Modificado!", "El abogado ha sido modidicado exitosamente.", "success"); 
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

function removerAbogado(idAbogado)
{
  $('div#tablaAbogados_'+idAbogado).remove();

  vectorAbogados = $.grep(vectorAbogados, function(value) {
    return value != idAbogado;
  });
  vectorAbogados = $.unique(vectorAbogados);
}
