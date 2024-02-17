var base_url = $('meta[name="base_url"]').attr('content'); 
var id_usuario = $('meta[name="id_usuario"]').attr('content'); 

function isntanciasTipoProceso()
{
  var idTipoProceso = $("#idTipoProceso").val();

  var ruta = base_url +'/'+ 'configurarProceso/isntanciasTipoProceso';

  var parametros = {  
    "idTipoProceso" : idTipoProceso
  };
  
  $.ajax({                
    data:  parametros,                 
    url:   ruta,
    type:  'post',
    beforeSend: function(){      
      cargaLoader('Consultando las instancias del tipo de proceso.  Un momento por favor..');
    },
    success:  function (responseText) {
      ocultaLoader();
      $("#resultadoInstanciasTipoProceso").html(responseText);
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

function agregarInstancia()
{
  $('#modalAgregarInstancia').modal('show');

  var ruta = base_url +'/'+ 'configurarProceso/agregarInstancia';

  $.ajax({                
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoAgregarInstancia").html(responseText);
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

function validarGuardarInstancia()
{
  var idTipoProceso = $("#idTipoProceso").val();
  var nombreInstancia = $("#nombreInstancia").val();

  if(nombreInstancia == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe ingresar el nombre de la instancia",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  var ruta = base_url +'/'+ 'configurarProceso/validarGuardarInstancia';

  var parametros = {  
    "idTipoProceso" : idTipoProceso,
    "nombreInstancia" : nombreInstancia
  };
  
  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',
    beforeSend: function(){    
      cargaLoader('Guardando la instancia.  Un momento por favor..');  
      $('.btn-guardar-instancia').html('<span class="fa fa-spinner fa-spin"></span> Procesando...');
      $('.btn-guardar-instancia').css({ 'pointer-events': 'none' });
    },
    success:  function (responseText) {
      ocultaLoader();
      $('#modalAgregarInstancia').modal('hide');
      isntanciasTipoProceso();
      swal("Guardado!", "La instancia ha sido guardada exitosamente.", "success"); 
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

function editarInstancia(idInstancia)
{
  $('#modalEditarInstancia').modal('show');

  var ruta = base_url +'/'+ 'configurarProceso/editarInstancia';

  var parametros = {  
    "idInstancia" : idInstancia
  };
  
  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',
    beforeSend: function(){    
      cargaLoader('Cargando datos instancia.  Un momento por favor..');  
    },
    success:  function (responseText) {
      ocultaLoader();
      $("#resultadoEditarInstancia").html(responseText);
      pageSetUp();
      $('#bootstrap-wizard-1').bootstrapWizard({
        'tabClass': 'form-wizard',
        'onNext': function (tab, navigation, index) {          
            $('#bootstrap-wizard-1').find('.form-wizard').children('li').eq(index - 1).addClass(
              'complete');
            $('#bootstrap-wizard-1').find('.form-wizard').children('li').eq(index - 1).find('.step')
            .html('<i class="fa fa-check"></i>');          
        }
      });
      // fuelux wizard
      var wizard = $('.wizard').wizard();
      wizard.on('finished', function (e, data) {
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

function validarEditarInstancia(idInstancia)
{
  var idTipoProceso = $("#idTipoProceso").val();
  var nombreInstanciaEditar = $("#nombreInstanciaEditar").val();

  if(nombreInstanciaEditar == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe ingresar el nombre de la instancia",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  var ruta = base_url +'/'+ 'configurarProceso/validarEditarInstancia';

  var parametros = {  
    "idInstancia": idInstancia,
    "nombreInstanciaEditar" : nombreInstanciaEditar
  };
  
  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',
    beforeSend: function(){    
      cargaLoader('Guardando la instancia.  Un momento por favor..');  
      $('.btn-editar-instancia').html('<span class="fa fa-spinner fa-spin"></span> Procesando...');
      $('.btn-editar-instancia').css({ 'pointer-events': 'none' });
    },
    success:  function (responseText) {
      ocultaLoader();
      $('#modalEditarInstancia').modal('hide');
      isntanciasTipoProceso();
      swal("Guardado!", "La instancia ha sido modificada exitosamente.", "success"); 
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

function eliminarInstancia(idInstancia)
{
  swal({   
    title: "Está seguro de eliminar la instancia?",   
    text: "Se eliminará la instancia de la base de datos!",   
    type: "warning",   
    showCancelButton: true,   
    confirmButtonColor: "#f8b32d",   
    confirmButtonText: "Sí, eliminarla!",   
    closeOnConfirm: false 
  }, function(){   
    validarEliminarInstancia(idInstancia);
  });
}

function validarEliminarInstancia(idInstancia)
{
  var ruta = base_url +'/'+ 'configurarProceso/validarEliminarInstancia';

  var parametros = {  
    "idInstancia" : idInstancia
  };

  $.ajax({                
    data:  parametros,          
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      if(responseText == 1)
      {
        $('#modalEditarInstancia').modal('hide');
        swal("Eliminada!", "La dependencia ha sido eliminada.", "success"); 
        isntanciasTipoProceso();
      }
      else
      {
        swal({   
          title: "No se puede eliminar la instancia!",   
          text: "La instancia es utilizada por al menos una etapa",    
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

function etapasInstancia(idInstancia)
{
  var ruta = base_url +'/'+ 'configurarProceso/etapasInstancia';

  var parametros = {  
    "idInstancia" : idInstancia
  };

  $.ajax({                
    data:  parametros,          
    url:   ruta,
    type:  'post',
    beforeSend: function(){    
      cargaLoader('Etapas Instancia.  Un momento por favor..');  
    },
    success:  function (responseText) {
      ocultaLoader();
      $("#resultadoEtapasInstancia").html(responseText);
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

function agregarEtapa(idInstancia)
{
  var ruta = base_url +'/'+ 'configurarProceso/agregarEtapa';

  var parametros = {  
    "idInstancia" : idInstancia
  };

  $.ajax({                
    data:  parametros,          
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoAgregarEtapa").html(responseText);
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

function validarGuardarEtapaInstancia(idInstancia)
{
  var nombreEtapa = $("#nombreEtapa").val();

  if(nombreEtapa == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe ingresar el nombre de la etapa",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  var ruta = base_url +'/'+ 'configurarProceso/validarGuardarEtapaInstancia';

  var parametros = {  
    "idInstancia": idInstancia,
    "nombreEtapa" : nombreEtapa
  };
  
  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',
    beforeSend: function(){    
      cargaLoader('Guardando la etapa.  Un momento por favor..');  
      $('.btn-guardar-etapaInstancia').html('<span class="fa fa-spinner fa-spin"></span> Procesando...');
      $('.btn-guardar-etapaInstancia').css({ 'pointer-events': 'none' });
    },
    success:  function (responseText) {
      ocultaLoader();
      etapasInstancia(idInstancia);
      swal("Guardado!", "La etapa ha sido guardada exitosamente.", "success"); 
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

function editarEtapa(idEtapa)
{
  var ruta = base_url +'/'+ 'configurarProceso/editarEtapa';

  var parametros = {  
    "idEtapa" : idEtapa
  };

  $.ajax({                
    data:  parametros,          
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoAgregarEtapa").html(responseText);
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

function validarEditarEtapaInstancia(idEtapa, idInstancia)
{
  var nombreEtapaEditar = $("#nombreEtapaEditar").val();

  if(nombreEtapaEditar == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe ingresar el nombre de la etapa",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  var ruta = base_url +'/'+ 'configurarProceso/validarEditarEtapaInstancia';

  var parametros = {  
    "idEtapa": idEtapa,
    "nombreEtapaEditar" : nombreEtapaEditar
  };
  
  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',
    beforeSend: function(){    
      cargaLoader('Modificando la etapa.  Un momento por favor..');  
      $('.btn-editar-etapaInstancia').html('<span class="fa fa-spinner fa-spin"></span> Procesando...');
      $('.btn-editar-etapaInstancia').css({ 'pointer-events': 'none' });
    },
    success:  function (responseText) {
      ocultaLoader();
      etapasInstancia(idInstancia);
      swal("Modificado!", "La etapa ha sido modificada exitosamente.", "success"); 
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

function eliminarEtapa(idEtapa, idInstancia)
{
  swal({   
    title: "Está seguro de eliminar la etapa?",   
    text: "Se eliminará la etapa de la base de datos!",   
    type: "warning",   
    showCancelButton: true,   
    confirmButtonColor: "#f8b32d",   
    confirmButtonText: "Sí, eliminarla!",   
    closeOnConfirm: false 
  }, function(){   
    validarEliminarEtapa(idEtapa, idInstancia);
  });
}

function validarEliminarEtapa(idEtapa, idInstancia)
{
  var ruta = base_url +'/'+ 'configurarProceso/validarEliminarEtapa';

  var parametros = {  
    "idEtapa": idEtapa,
    "idInstancia" : idInstancia
  };
  
  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      if(responseText == 1)
      {
        etapasInstancia(idInstancia);
        swal("Eliminada!", "La etapa ha sido eliminada exitosamente.", "success"); 
      }
      else
      {

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

function pasosPadre()
{
  var idTipoProceso = $("#idTipoProceso").val();

  var ruta = base_url +'/'+ 'configurarProceso/pasosPadre';

  var parametros = {  
    "idTipoProceso" : idTipoProceso
  };
  
    $.ajax({                
      data:  parametros,                  
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoQueHace").html(responseText);
      $('.tabla-fresh').bootstrapTable();
      $("#sortablePadre").sortable();
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

function pasosHijo()
{
  var idTipoProceso = $("#idTipoProceso").val();

  var ruta = base_url +'/'+ 'configurarProceso/pasosHijo';

  var parametros = {  
    "idTipoProceso" : idTipoProceso
  };
  
  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoComoHace").html(responseText.vistaHijo);

      var pasosPadre = JSON.parse(JSON.stringify(responseText.pasosPadre));
      if(pasosPadre.length > 0)
      {
        for(var i = 0; i < pasosPadre.length; i++)
        {  
          $("#sortableHijo_"+pasosPadre[i]['idPaso']).sortable();
        } 
      }
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

function agregarPasoPadre()
{
  $('#modalAgregarQueHacen').modal('show');

  var ruta = base_url +'/'+ 'configurarProceso/agregarPasoPadre';

  $.ajax({                
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoAgregarQueHacen").html(responseText);
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

function agregarPasoHijo()
{
  var idTipoProceso = $("#idTipoProceso").val();

  $('#modalAgregarComoHacen').modal('show');

  var ruta = base_url +'/'+ 'configurarProceso/agregarPasoHijo';

  var parametros = {  
    "idTipoProceso" : idTipoProceso
  };
  
  $.ajax({                
    data:  parametros,                         
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoAgregarComoHacen").html(responseText);
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

function validarGuardarPaso(padreHijo)
{
  var idTipoProceso = $("#idTipoProceso").val();
  if(padreHijo == 1)//padre que se hace
  {
    var textoPaso = $("#textoPasoPadre").val();
  }
  else//hijo como se hace
  {
    var textoPaso = $("#textoPasoHijo").val();
  }
  var selectPasoPadre = $("#selectPasoPadre").val();

  if(textoPaso == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe ingresar el texto del paso",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(padreHijo == 0 && selectPasoPadre == '')
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe seleccionar el paso padre",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  var ruta = base_url +'/'+ 'configurarProceso/validarGuardarPaso';

  var parametros = {  
    "idTipoProceso" : idTipoProceso,
    "textoPaso" : textoPaso,
    "selectPasoPadre": selectPasoPadre,
    "padreHijo": padreHijo
  };
  
  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',
    beforeSend: function(){    
      cargaLoader('Guardando el paso.  Un momento por favor..');  
      $('.btn-guardar-paso').html('<span class="fa fa-spinner fa-spin"></span> Procesando...');
      $('.btn-guardar-paso').css({ 'pointer-events': 'none' });
    },
    success:  function (responseText) {
      ocultaLoader();
      if(padreHijo == 1)// que hacen, padres
      {
        $('#modalAgregarQueHacen').modal('hide');
        pasosPadre();
        swal("Guardado!", "El paso padre ha sido guardada exitosamente.", "success"); 
      }
      else
      {
        $('#modalAgregarComoHacen').modal('hide');
        pasosHijo();
        swal("Guardado!", "El paso hijo ha sido guardada exitosamente.", "success"); 
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

function editarPasoPadre(idPaso)
{
  $('#modalEditarQueHacen').modal('show');

  var ruta = base_url +'/'+ 'configurarProceso/editarPasoPadre';

  var parametros = {  
    "idPaso" : idPaso
  };
  
  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      ocultaLoader();
      $("#resultadoEditarQueHacen").html(responseText);
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

function editarPasoHijo(idPaso)
{
  var idTipoProceso = $("#idTipoProceso").val();

  $('#modalEditarComoHacen').modal('show');

  var ruta = base_url +'/'+ 'configurarProceso/editarPasoHijo';

  var parametros = {  
    "idPaso" : idPaso,
    "idTipoProceso": idTipoProceso
  };
  
  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      ocultaLoader();
      $("#resultadoComoHacenEditar").html(responseText);
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

function validarEditarPaso(idPaso, padreHijo)
{
  var selectPasoPadreEditar = $("#selectPasoPadreEditar").val();

  if(padreHijo == 1)//padre que se hace
  {
    var textoPasoEditar = $("#textoPasoPadreEditar").val();
  }
  else//hijo como se hace
  {
    var textoPasoEditar = $("#textoPasoHijoEditar").val();
  }

  if(textoPasoEditar == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe ingresar el texto del paso",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(padreHijo == 0 && selectPasoPadreEditar == '')
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe seleccionar el paso padre",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  var ruta = base_url +'/'+ 'configurarProceso/validarEditarPaso';

  var parametros = {  
    "idPaso" : idPaso,
    "padreHijo" : padreHijo,
    "textoPasoEditar" : textoPasoEditar,
    "selectPasoPadreEditar": selectPasoPadreEditar
  };
  
  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',
    beforeSend: function(){    
      cargaLoader('Guardando el paso.  Un momento por favor..');  
      $('.btn-editar-paso').html('<span class="fa fa-spinner fa-spin"></span> Procesando...');
      $('.btn-editar-paso').css({ 'pointer-events': 'none' });
    },
    success:  function (responseText) {
      ocultaLoader();
      
      if(padreHijo == 1)// que hacen, padres
      {
        $('#modalEditarQueHacen').modal('hide');
        pasosPadre();
        swal("Modificado!", "El paso padre ha sido modificado exitosamente.", "success"); 
      }
      else
      {
        $('#modalEditarComoHacen').modal('hide');
        pasosHijo();
        swal("Modificado!", "El paso hijo ha sido modificado exitosamente.", "success"); 
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


function estadoPaso(idPaso, estadoPaso, padreHijo)
{
  if(estadoPaso == 0)
      swal({   
        title: "Está seguro de desactivar el paso?",   
        text: "Se desactivara el paso de la base de datos!",   
        type: "warning",   
        showCancelButton: true,   
        confirmButtonColor: "#f8b32d",   
        confirmButtonText: "Sí, desactivarlo!",   
        closeOnConfirm: false 
        }, function(){   
        validarEstadoPaso(idPaso, estadoPaso, padreHijo);
      });
  else
  {
      swal({   
        title: "Está seguro de activar el paso?",   
        text: "Se activara el paso de la base de datos!",   
        type: "warning",   
        showCancelButton: true,   
        confirmButtonColor: "#f8b32d",   
        confirmButtonText: "Sí, activarlo!",   
        closeOnConfirm: false 
        }, function(){   
        validarEstadoPaso(idPaso, estadoPaso, padreHijo);
      });
  }
}

function validarEstadoPaso(idPaso, estadoPaso, padreHijo)
{
  var ruta = base_url +'/'+ 'configurarProceso/validarEstadoPaso';

  var parametros = {  
    "idPaso" : idPaso,
    "estadoPaso": estadoPaso
  };

  $.ajax({                
    data:  parametros,          
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      if(estadoPaso == 0)
      {
        swal("Desactivado!", "El paso ha sido desactivado.", "success"); 
        
      }
      else
      {
        swal("Activado!", "El paso ha sido activado.", "success"); 
      }

      if(padreHijo == 1)// que hacen, pasos padre
      {
        pasosPadre();
      }
      else//como hacen hijos
      {
        pasosHijo();
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

function arrastraPadre()
{
  setTimeout(function(){validarOrdenaPadre()},500); // 3000ms = 3s 
}

function validarOrdenaPadre()
{
  var pasos = $("ul#sortablePadre").sortable('toArray', { attribute: 'value' });
  var jsonPasosPadre = JSON.stringify(pasos);

  var ruta = base_url +'/'+ 'configurarProceso/validarOrdenaPadre';

  var parametros = {  
    "jsonPasosPadre": jsonPasosPadre
  };

  $.ajax({                
    data:  parametros,          
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      pasosPadre();
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

function arrastraHijo(idPaso)
{
  setTimeout(function(){validarOrdenaHijo(idPaso)},500); // 3000ms = 3s 
}

function validarOrdenaHijo(idPaso)
{
  var pasos = $("ul#sortableHijo_"+idPaso).sortable('toArray', { attribute: 'value' });
  var jsonPasosHijos = JSON.stringify(pasos);

  var ruta = base_url +'/'+ 'configurarProceso/validarOrdenaHijo';

  var parametros = {  
    "jsonPasosHijos": jsonPasosHijos
  };

  $.ajax({                
    data:  parametros,          
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      pasosHijo();
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

function tiposActuaciones()
{
  var idTipoProceso = $("#idTipoProceso").val();

  var ruta = base_url +'/'+ 'configurarProceso/tiposActuaciones';

  var parametros = {  
    "idTipoProceso": idTipoProceso
  };
  
  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      ocultaLoader();
      $("#resultadoTiposActuaciones").html(responseText);
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

function agregarTipoActuacion()
{
  $('#modalAgregarTipoActuacion').modal('show');

  var ruta = base_url +'/'+ 'configurarProceso/agregarTipoActuacion';

  $.ajax({                
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoAgregarTipoActuacion").html(responseText);
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

function validarGuardarTipoActuacion()
{
  var idTipoProceso = $("#idTipoProceso").val();
  var nombreTipoActuacion = $("#nombreTipoActuacion").val();
  var selectFinaliza = $("#selectFinaliza").val();
  var selectFallo = $("#selectFallo").val();

  if(nombreTipoActuacion == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe ingresar el nombre del tipo de actuación",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(selectFinaliza == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Seleccione si el tipo finaliza o no el proceso",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(selectFallo == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Seleccione si el tipo es fallo o no",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  var ruta = base_url +'/'+ 'configurarProceso/validarGuardarTipoActuacion';

  var parametros = {  
    "idTipoProceso" : idTipoProceso,
    "nombreTipoActuacion" : nombreTipoActuacion,
    "selectFinaliza": selectFinaliza,
    "selectFallo": selectFallo
  };
  
  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',
    beforeSend: function(){    
      cargaLoader('Guardando el tipo de actuación.  Un momento por favor..');  
      $('.btn-guardar-tipoActuacion').html('<span class="fa fa-spinner fa-spin"></span> Procesando...');
      $('.btn-guardar-tipoActuacion').css({ 'pointer-events': 'none' });
    },
    success:  function (responseText) {
      ocultaLoader();
      $('#modalAgregarTipoActuacion').modal('hide');
      tiposActuaciones();
      swal("Guardado!", "El tipo de actuación ha sido guardado exitosamente.", "success"); 
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

function editarTipoActuacion(idTipoActuacion)
{
  $('#modalEditarTipoActuacion').modal('show');

  var ruta = base_url +'/'+ 'configurarProceso/editarTipoActuacion';

  var parametros = {  
    "idTipoActuacion" : idTipoActuacion
  };
  
  $.ajax({                
    data:  parametros,                        
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoEditarTipoActuación").html(responseText);
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

function validarEditarTipoActuacion(idTipoActuacion)
{
  var nombreTipoActuacionEditar = $("#nombreTipoActuacionEditar").val();
  var selectFinalizaEditar = $("#selectFinalizaEditar").val();
  var selectFalloEditar = $("#selectFalloEditar").val();

  if(nombreTipoActuacionEditar == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe ingresar el nombre del tipo de actuación",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(selectFinalizaEditar == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Seleccione si el tipo finaliza o no el proceso",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(selectFalloEditar == "")
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Seleccione si el tipo es fallo o no",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  var ruta = base_url +'/'+ 'configurarProceso/validarEditarTipoActuacion';

  var parametros = {  
    "idTipoActuacion" : idTipoActuacion,
    "nombreTipoActuacionEditar" : nombreTipoActuacionEditar,
    "selectFinalizaEditar": selectFinalizaEditar,
    "selectFalloEditar": selectFalloEditar
  };
  
  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',
    beforeSend: function(){    
      cargaLoader('Modificando el tipo de actuación.  Un momento por favor..');  
      $('.btn-editar-tipoActuacion').html('<span class="fa fa-spinner fa-spin"></span> Procesando...');
      $('.btn-editar-tipoActuacion').css({ 'pointer-events': 'none' });
    },
    success:  function (responseText) {
      ocultaLoader();
      $('#modalEditarTipoActuacion').modal('hide');
      tiposActuaciones();
      swal("Modificado!", "El tipo de actuación ha sido modificado exitosamente.", "success"); 
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

function estadoTipoActuacion(idTipoActuacion, estado)
{
  if(estado == 0)
      swal({   
        title: "Está seguro de desactivar el tipo de actuación?",   
        text: "Se desactivara el tipo de actuación de la base de datos!",   
        type: "warning",   
        showCancelButton: true,   
        confirmButtonColor: "#f8b32d",   
        confirmButtonText: "Sí, desactivarlo!",   
        closeOnConfirm: false 
        }, function(){   
        validarEstadoTipoActuacion(idTipoActuacion, estado);
      });
  else
  {
      swal({   
        title: "Está seguro de activar el el tipo de actuación?",   
        text: "Se activara el el tipo de actuación de la base de datos!",   
        type: "warning",   
        showCancelButton: true,   
        confirmButtonColor: "#f8b32d",   
        confirmButtonText: "Sí, activarlo!",   
        closeOnConfirm: false 
        }, function(){   
        validarEstadoTipoActuacion(idTipoActuacion, estado);
      });
  }
}

function validarEstadoTipoActuacion(idTipoActuacion, estado)
{
  var ruta = base_url +'/'+ 'configurarProceso/validarEstadoTipoActuacion';

  var parametros = {  
    "idTipoActuacion" : idTipoActuacion,
    "estado" : estado
  };
  
  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      if(estado == 0)
      {
        swal("Desactivado!", "El tipo de actuación ha sido desactivado.", "success"); 
      }
      else
      {
       swal("Activado!", "El tipo de actuación ha sido activado.", "success"); 
      }
      tiposActuaciones();
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

function modulosTiposProceso()
{
  var idTipoProceso = $("#idTipoProceso").val();

  var ruta = base_url +'/'+ 'configurarProceso/modulosTiposProceso';

  var parametros = {  
    "idTipoProceso" : idTipoProceso
  };
  
  $.ajax({                
    data:  parametros,                 
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoModulos").html(responseText);
      $('#tabla-fresh-activos').bootstrapTable();
      $('#tabla-fresh-inactivos').bootstrapTable();
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

function inactivar(){
  var val = [];
  var flag = false
  var cont = 0

  $(':checkbox:checked').each(function(i){
    var temp = $(this).val();
    if(temp.length == 3){
      var validation = temp.split("-");
      if(validation[0] == 1){
        flag= true;
      }
      val[cont] = validation[1]
      cont++
    }
  });

  if(flag){
    swal("Opps!", "Seleccione solo los modulos para activar.", "error"); 
    return;
  }else{
    estadoModulo(1, val)
  }
}

function activar(){
  var val = [];
  var flag = false
  var cont = 0

  $(':checkbox:checked').each(function(i){
    var temp = $(this).val();
    if(temp.length == 3){
      var validation = temp.split("-");
      if(validation[0] == 0){
        flag= true;
      }
      val[cont] = validation[1]
      cont++
    }
  });

  if(flag){
    swal("Opps!", "Seleccione solo los modulos para inactivar.", "error"); 
    return;
  }else{
    estadoModulo(0,val)
  }
}

function estadoModulo(estadoModulo, arregloModulos)
{
  var jsonModulos = JSON.stringify(arregloModulos);
  var idTipoProceso = $("#idTipoProceso").val();

  var ruta = base_url +'/'+ 'configurarProceso/estadoModulo';

  var parametros = {  
    "estadoModulo" : estadoModulo,
    "idTipoProceso": idTipoProceso,
    jsonModulos
  };
  
  $.ajax({                
    data:  parametros,                 
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      if(estadoModulo == 1)
      {
        swal("Guardado!", "Los módulos fueron activados exitosamente.", "success"); 
      }
      else
      {
        swal("Guardado!", "Los módulos fueron inactivados.", "success");   
      }
      modulosTiposProceso();
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