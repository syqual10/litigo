var base_url = $('meta[name="base_url"]').attr('content');
var id_usuario = $('meta[name="id_usuario"]').attr('content');


function tablaUsuarios()
{
  var ruta = base_url +'/'+ 'usuarios/tablaUsuarios';

  $.ajax({
    url:   ruta,
    type:  'post',
    beforeSend: function(){
      cargaLoader('Consultando los usuarios.  Un momento por favor..');
    },
    success:  function (responseText) {
      ocultaLoader();
      $("#resultadoTablaUsuarios").html(responseText);
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

function agregarUsuario()
{
  $('#modalAgregarUsuario').modal('show');

  var ruta = base_url +'/'+ 'usuarios/agregarUsuario';

  $.ajax({
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoAgregarUsuario").html(responseText);
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

function validarGuardarUsuario()
{
  var lugarExpedicion = $("#lugarExpedicion").val();
  var documentoUsuario = $("#documentoUsuario").val();
  var loginUsuario = $("#loginUsuario").val();
  var nombreUsuario = $("#nombreUsuario").val();
  var apellidoUsuario = $("#apellidoUsuario").val();
  var emailUsuario = $("#emailUsuario").val();
  var celularUsuario = $("#celularUsuario").val();
  var selectTipoIdentificacion = $("#selectTipoIdentificacion").val();
  var selectDependencia = $("#selectDependencia").val();
  var selectCargos = $("#selectCargos").val();
  var selectDepartamentos = $("#selectDepartamentos").val();
  var selectCiudad = $("#selectCiudad").val();
  var selectRol = $("#selectRol").val();

  if(lugarExpedicion == "")
  {
    swal({
      title: "Campo sin diligenciar!",
      text: "Debe ingresar el lugar de expedición",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  if(documentoUsuario == "")
  {
    swal({
      title: "Campo sin diligenciar!",
      text: "Debe ingresar el documento del usuario",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  if(loginUsuario == "")
  {
    swal({
      title: "Campo sin diligenciar!",
      text: "Debe ingresar el login del usuario",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  if(nombreUsuario == "")
  {
    swal({
      title: "Campo sin diligenciar!",
      text: "Debe ingresar el nombre del usuario",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  if(apellidoUsuario == "")
  {
    swal({
      title: "Campo sin diligenciar!",
      text: "Debe ingresar los apellidos del usuario",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  var reg= /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
  if(emailUsuario !='')
  {
    if (!reg.test(emailUsuario))
    {
      swal({
        title: "Campo mal diligenciado!",
        text: "Correo incorrecto",
        confirmButtonColor: "#f33923",
        });
      return false;
    }
  }

  if(selectTipoIdentificacion == "")
  {
    swal({
      title: "Campo sin diligenciar!",
      text: "Seleccione el tipo de identificación",
      confirmButtonColor: "#f33923",
    });
    return false;
  }


  if(selectDependencia == "")
  {
    swal({
      title: "Campo sin diligenciar!",
      text: "Seleccione la dependencia",
      confirmButtonColor: "#f33923",
    });
    return false;
  }


  if(selectCargos == "")
  {
    swal({
      title: "Campo sin diligenciar!",
      text: "Seleccione el cargo",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  if(selectDepartamentos == "")
  {
    swal({
      title: "Campo sin diligenciar!",
      text: "Seleccione el departamento",
      confirmButtonColor: "#f33923",
    });
    return false;
  }


  if(selectCiudad == "")
  {
    swal({
      title: "Campo sin diligenciar!",
      text: "Seleccione la ciudad",
      confirmButtonColor: "#f33923",
    });
    return false;
  }


  if(selectRol == "")
  {
    swal({
      title: "Campo sin diligenciar!",
      text: "Seleccione el rol",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  var ruta = base_url +'/'+ 'usuarios/validarGuardarUsuario';

  var parametros = {
    "lugarExpedicion" : lugarExpedicion,
    "documentoUsuario" : documentoUsuario,
    "loginUsuario" : loginUsuario,
    "nombreUsuario" : nombreUsuario,
    "apellidoUsuario" : apellidoUsuario,
    "emailUsuario" : emailUsuario,
    "celularUsuario" : celularUsuario,
    "selectTipoIdentificacion" : selectTipoIdentificacion,
    "selectDependencia" : selectDependencia,
    "selectCargos" : selectCargos,
    "selectDepartamentos" : selectDepartamentos,
    "selectCiudad" : selectCiudad,
    "selectRol" : selectRol
  };

  $.ajax({
    data:  parametros,
    url:   ruta,
    type:  'post',
    beforeSend: function(){
      cargaLoader('Guardando el usuario.  Un momento por favor..');
      $('.btn-guardar-usuario').html('<span class="fa fa-spinner fa-spin"></span> Procesando...');
      $('.btn-guardar-usuario').css({ 'pointer-events': 'none' });
    },
    success:  function (responseText) {
      ocultaLoader();
      if(responseText == 1)
      {
        $('#modalAgregarUsuario').modal('hide');
        tablaUsuarios();
        swal("Guardado!", "El usuario ha sido guardado exitosamente.", "success");
      }
      else
      {
        swal({
          title: "No se puede guardar el usuario!",
          text: "El usuario ya se encuentra registrado",
          confirmButtonColor: "#f33923",
        });
        $('.btn-guardar-usuario').html('<span class="icon-rocket"></span> Guardar');
        $('.btn-guardar-usuario').css({ 'pointer-events': 'auto' });
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

function editarUsuario(idUsuario)
{
  $('#modalEditarUsuario').modal('show');

  var ruta = base_url +'/'+ 'usuarios/editarUsuario';

  var parametros = {
    "idUsuario" : idUsuario
  };

  $.ajax({
    data:  parametros,
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoEditarUsuario").html(responseText);
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

function validarEditarUsuario(idUsuario)
{
  var lugarExpedicionEditar = $("#lugarExpedicionEditar").val();
  var documentoUsuarioEditar = $("#documentoUsuarioEditar").val();
  var loginUsuarioEditar = $("#loginUsuarioEditar").val();
  var nombreUsuarioEditar = $("#nombreUsuarioEditar").val();
  var apellidoUsuarioEditar = $("#apellidoUsuarioEditar").val();
  var emailUsuarioEditar = $("#emailUsuarioEditar").val();
  var celularUsuarioEditar = $("#celularUsuarioEditar").val();
  var selectTipoIdentificacionEditar = $("#selectTipoIdentificacionEditar").val();
  var selectDependenciaEditar = $("#selectDependenciaEditar").val();
  var selectCargosEditar = $("#selectCargosEditar").val();
  var selectDepartamentosEditar = $("#selectDepartamentosEditar").val();
  var selectCiudadEditar = $("#selectCiudadEditar").val();
  var selectRolEditar = $("#selectRolEditar").val();

  if(lugarExpedicionEditar == "")
  {
    swal({
      title: "Campo sin diligenciar!",
      text: "Debe ingresar el lugar de expedición",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  if(documentoUsuarioEditar == "")
  {
    swal({
      title: "Campo sin diligenciar!",
      text: "Debe ingresar el documento del usuario",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  if(loginUsuarioEditar == "")
  {
    swal({
      title: "Campo sin diligenciar!",
      text: "Debe ingresar el login del usuario",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  if(nombreUsuarioEditar == "")
  {
    swal({
      title: "Campo sin diligenciar!",
      text: "Debe ingresar el nombre del usuario",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  if(apellidoUsuarioEditar == "")
  {
    swal({
      title: "Campo sin diligenciar!",
      text: "Debe ingresar los apellidos del usuario",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  var reg= /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
  if(emailUsuarioEditar !='')
  {
    if (!reg.test(emailUsuarioEditar))
    {
      swal({
        title: "Campo mal diligenciado!",
        text: "Correo incorrecto",
        confirmButtonColor: "#f33923",
        });
      return false;
    }
  }

  if(selectTipoIdentificacionEditar == "")
  {
    swal({
      title: "Campo sin diligenciar!",
      text: "Seleccione el tipo de identificación",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  if(selectDependenciaEditar == "")
  {
    swal({
      title: "Campo sin diligenciar!",
      text: "Seleccione la dependencia",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  if(selectCargosEditar == "")
  {
    swal({
      title: "Campo sin diligenciar!",
      text: "Seleccione el cargo",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  if(selectDepartamentosEditar == "")
  {
    swal({
      title: "Campo sin diligenciar!",
      text: "Seleccione el departamento",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  if(selectCiudadEditar == "")
  {
    swal({
      title: "Campo sin diligenciar!",
      text: "Seleccione la ciudad",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  if(selectRolEditar == "")
  {
    swal({
      title: "Campo sin diligenciar!",
      text: "Seleccione el rol",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  var ruta = base_url +'/'+ 'usuarios/validarEditarUsuario';

  var parametros = {
    "idUsuario": idUsuario,
    "lugarExpedicionEditar" : lugarExpedicionEditar,
    "documentoUsuarioEditar" : documentoUsuarioEditar,
    "loginUsuarioEditar" : loginUsuarioEditar,
    "nombreUsuarioEditar" : nombreUsuarioEditar,
    "emailUsuarioEditar" : emailUsuarioEditar,
    "celularUsuarioEditar" : celularUsuarioEditar,
    "selectTipoIdentificacionEditar" : selectTipoIdentificacionEditar,
    "selectDependenciaEditar" : selectDependenciaEditar,
    "selectCargosEditar" : selectCargosEditar,
    "selectDepartamentosEditar" : selectDepartamentosEditar,
    "selectCiudadEditar" : selectCiudadEditar,
    "selectRolEditar" : selectRolEditar
  };

  $.ajax({
    data:  parametros,
    url:   ruta,
    type:  'post',
    beforeSend: function(){
      cargaLoader('Modificando el usuario.  Un momento por favor..');
      $('.btn-editar-usuario').html('<span class="fa fa-spinner fa-spin"></span> Procesando...');
      $('.btn-editar-usuario').css({ 'pointer-events': 'none' });
    },
    success:  function (responseText) {
      ocultaLoader();
      $('#modalEditarUsuario').modal('hide');
      tablaUsuarios();
      swal("Modificado!", "El usuario ha sido modificado exitosamente.", "success");
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

function desactivarUsuario(idUsuario)
{
  swal({
    title: "Está seguro de desactivar el usuario?",
    text: "Se desactivara el usaurio de la base de datos!",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#f8b32d",
    confirmButtonText: "Sí, desactivarlo!",
    closeOnConfirm: false
  }, function(){
    validarDesactivarUsuario(idUsuario);
  });
}

function validarDesactivarUsuario(idUsuario)
{
  var ruta = base_url +'/'+ 'usuarios/validarDesactivarUsuario';

  var parametros = {
    "idUsuario" : idUsuario
  };

  $.ajax({
    data:  parametros,
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      swal("Desactivado!", "El usuario ha sido desactivado.", "success");
      tablaUsuarios();
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

function restablecerPassUsuario(idUsuario)
{
  swal({
    title: "Está seguro de restablecer la contraseña?",
    text: "Se restablecera la contraseña al usuario!",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#f8b32d",
    confirmButtonText: "Sí, restablecerla!",
    closeOnConfirm: false
  }, function(){
    validarRestablcerPass(idUsuario);
  });
}

function validarRestablcerPass(idUsuario, documentoUsuario)
{
  var ruta = base_url +'/'+ 'usuarios/validarRestablcerPass';

  var parametros = {
    "idUsuario" : idUsuario,
    "documentoUsuario": documentoUsuario
  };

  $.ajax({
    data:  parametros,
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      swal("Restablecida!", "La contraseña ha sido restablecida.", "success");
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

function justNumbers(e)
{
  var keynum = window.event ? window.event.keyCode : e.which;
  if ((keynum == 8) || (keynum == 46))
    return true;

  return /\d/.test(String.fromCharCode(keynum));
}

function copiar()
{
  var documento = document.getElementById('documentoUsuario').value;
    if(document.getElementById('documentoUsuario').value != "")
    {
      document.getElementById('loginUsuario').value = documento;
    }
}

function cargarCiudad(idDepartamento)
{
  var ruta = base_url +'/'+ 'usuarios/cargarCiudad';

  var parametros = {
      "idDepartamento": idDepartamento
  };

  $.ajax({
      data: parametros,
      url: ruta,
      type: 'post',
      beforeSend: function(){
        cargaLoader('Cargando las ciudades.  Un momento por favor..');
      },
      success: function (responseText) {
        ocultaLoader();
        $("#resultadoCargarCiudad").html(responseText);
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

function cargarCiudadEditar(idDepartamento)
{
  var ruta = base_url +'/'+ 'usuarios/cargarCiudadEditar';

  var loader = '<img src="'+base_url+'/img/loader.gif">';

  var parametros = {
      "idDepartamento": idDepartamento
  };

  $.ajax({
      data: parametros,
      url: ruta,
      type: 'post',
      beforeSend: function(){
        cargaLoader('Cargando las ciudades.  Un momento por favor..');
      },
      success: function (responseText) {
        ocultaLoader();
        $("#resultadoCargarCiudadEditar").html(responseText);
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
