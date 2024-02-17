var base_url = $('meta[name="base_url"]').attr('content'); 
var id_usuario = $('meta[name="id_usuario"]').attr('content'); 


function cuantiasRadicado()
{
  var vigenciaRadicado = $("#vigenciaRadicado").val();
  var idRadicado = $("#idRadicado").val();

  var ruta = base_url +'/'+ 'proviCalifica/cuantiasRadicado';

  var parametros = {  
    "vigenciaRadicado" : vigenciaRadicado,
    "idRadicado" : idRadicado
  };

  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',
    beforeSend: function(){      
      cargaLoader('Consultando las cuantías.  Un momento por favor..');
    },
    success:  function (responseText) {
      ocultaLoader();
      $("#resultadoCuantiaRadicado").html(responseText);
      tablaCuantias();
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

function tablaCuantias()
{
  var vigenciaRadicado = $("#vigenciaRadicado").val();
  var idRadicado = $("#idRadicado").val();

  var ruta = base_url +'/'+ 'proviCalifica/tablaCuantias';

  var parametros = {  
    "vigenciaRadicado" : vigenciaRadicado,
    "idRadicado": idRadicado
  };

  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoTablaCuantias").html(responseText);
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

function validarGuardarCuantia()
{
  var vigenciaRadicado = $("#vigenciaRadicado").val();
  var idRadicado = $("#idRadicado").val();
  var selectUnidadMonetaria = $("#selectUnidadMonetaria").val();// 1 salarios - 2 en pesos
  var valor = $("#valor").val();// valor en pesos
  var valorSalarios = $("#valorSalarios").val();// # de salarios
  var valorPesos = $("#valorPesos").val();// valor que cálcula en pesos o salrios readonly
  var valorUnidadMonetaria = ''; // la cantidad de salarios o el valor en pesos

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

  var ruta = base_url +'/'+ 'proviCalifica/validarGuardarCuantia';

  var parametros = {  
    "selectUnidadMonetaria" : selectUnidadMonetaria,
    "valorUnidadMonetaria" : valorUnidadMonetaria,
    "valorPesos" : valorPesos,
    "vigenciaRadicado" : vigenciaRadicado,
    "idRadicado": idRadicado
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
      tablaCuantias();
      swal("Guardada!", "La cuantía ha sido guardada exitosamente.", "success"); 
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

function eliminarCuantia(idCuantia)
{
  swal({   
    title: "Está seguro de eliminar la cuantía?",   
    text: "Se eliminará la cuantía de la base de datos!",   
    type: "warning",   
    showCancelButton: true,   
    confirmButtonColor: "#f8b32d",   
    confirmButtonText: "Sí, elimiarla!",   
    closeOnConfirm: false 
  }, function(){   
    validarEliminarCuantia(idCuantia);
  });
}

function validarEliminarCuantia(idCuantia)
{
  var ruta = base_url +'/'+ 'proviCalifica/validarEliminarCuantia';

  var parametros = {  
    "idCuantia" : idCuantia
  };

  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      tablaCuantias();
      swal("Eliminada!", "La cuantía ha sido eliminada exitosamente.", "success"); 
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

function valorIpcInicial()
{
  var selectVigenciaInicialIpc = $("#selectVigenciaInicialIpc").val();
  var selectMesInicialIpc = $("#selectMesInicialIpc").val();

  var ruta = base_url +'/'+ 'proviCalifica/valorIpcInicial';

  var parametros = {  
    "selectMesInicialIpc" : selectMesInicialIpc,
    "selectVigenciaInicialIpc" : selectVigenciaInicialIpc
  };
  
  if(selectMesInicialIpc != '' && selectVigenciaInicialIpc !='')
  {
    $.ajax({                
      data:  parametros,                  
      url:   ruta,
      type:  'post',
      success:  function (responseText) {
        if(responseText != 0)
        {
          $("#ipcInicial").val(responseText);
        }
        else
        {
          swal({   
            title: "Atención!",   
            text: "No se encontro IPC inicial",   
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
}

function valorIpcFinal()
{
  var selectVigenciaFinalIpc = $("#selectVigenciaFinalIpc").val();
  var selectMesFinalIpc = $("#selectMesFinalIpc").val();

  var ruta = base_url +'/'+ 'proviCalifica/valorIpcFinal';
  
  var parametros = {  
    "selectMesFinalIpc" : selectMesFinalIpc,
    "selectVigenciaFinalIpc" : selectVigenciaFinalIpc
  };
  
  if(selectMesFinalIpc != '' && selectVigenciaFinalIpc !='')
  {
    $.ajax({                
      data:  parametros,                  
      url:   ruta,
      type:  'post',
      success:  function (responseText) {
        if(responseText != 0)
        {
          $("#ipcFinal").val(responseText);
        }
        else
        {
          swal({   
            title: "Atención!",   
            text: "No se encontro IPC final",   
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
}

function calcularIPC()
{
  var porcentajeCondena = $("#porcentajeCondena").val();

  var vigenciaRadicado = $("#vigenciaRadicado").val();
  var idRadicado = $("#idRadicado").val();

  var valorCalcular = $("#valorCalcular").val();
  var ipcInicial = $("#ipcInicial").val();
  var ipcFinal = $("#ipcFinal").val();

  if(ipcInicial == '')
  {
    swal({   
      title: "Atención!",   
      text: "Seleccione la vigencia y el mes IPC inicial",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(ipcFinal == '')
  {
    swal({   
      title: "Atención!",   
      text: "Seleccione la vigencia y el mes IPC final",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(valorCalcular == '')
  {
    swal({   
      title: "Atención!",   
      text: "Ingrese el valor que desea calcular",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(porcentajeCondena == '')
  {
    swal({   
      title: "Atención!",   
      text: "Ingrese el porcentaje de la condena",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(porcentajeCondena < 0)
  {
    swal({   
      title: "Atención!",   
      text: "El porcentaje de condena debe ser mayor a 0",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(porcentajeCondena > 500)
  {
    swal({   
      title: "Atención!",   
      text: "El porcentaje de condena debe ser menor a 500",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  var ruta = base_url +'/'+ 'proviCalifica/calcularIPC';
  
  var parametros = {  
    "ipcInicial" : ipcInicial,
    "ipcFinal" : ipcFinal,
    "valorCalcular" : valorCalcular,
    "porcentajeCondena": porcentajeCondena,
    "vigenciaRadicado":vigenciaRadicado,
    "idRadicado":idRadicado
  };
  
  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#valorCalculado").val(responseText);
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

function valorRangoCriterio(tipoCalificacion, idCriterio)
{
  var valorRango = 0;

  if(tipoCalificacion == 1)//alta
  {
    valorRango = $("#tipoAlto").val();
  }

  if(tipoCalificacion == 2)// medio alta
  {
    valorRango = $("#tipoMedioAlto").val();
  }

  if(tipoCalificacion == 3)//medio baja
  {
    valorRango = $("#tipoMedioBajo").val();
  }

  if(tipoCalificacion == 4)//baja
  {
    valorRango = $("#tipoBajo").val();
  }

  //#########

  if(idCriterio == 1)
  {
    $("#valorRangoCriterio1").val(valorRango);
  }
  else if(idCriterio == 2)
  {
    $("#valorRangoCriterio2").val(valorRango);
  }
  else if(idCriterio == 3)
  {
    $("#valorRangoCriterio3").val(valorRango);
  }
  else if(idCriterio == 4)
  {
    $("#valorRangoCriterio4").val(valorRango);
  }
}

function calcularYearsFallo()
{
  var fechaActualizacion = $("#fechaActualizacion").val();
  var selectVigenciaFinalIpc = $("#selectVigenciaFinalIpc option:selected").text();

  if(selectVigenciaFinalIpc == '')
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Por favor seleccione el año potencial del fallo",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  var parts = fechaActualizacion.split('/');
  var yearActualizacion = parts[2];

  $("#yearsFallo").val(selectVigenciaFinalIpc - yearActualizacion);
}

function validarGuardarCalificacion()
{
  var vigenciaRadicado = $("#vigenciaRadicado").val();
  var idRadicado = $("#idRadicado").val();

  var fechaActualizacion = $("#fechaActualizacion").val();
  var yearsFallo         = $("#yearsFallo").val();
  var selectCriterio1 = $("#selectCriterio1").val();
  var selectCriterio2 = $("#selectCriterio2").val();
  var selectCriterio3 = $("#selectCriterio3").val();
  var selectCriterio4 = $("#selectCriterio4").val();

  var porcentajeCondena = $("#porcentajeCondena").val();

  var valorCriterio1  = $("#valorCriterio1").val();
  var valorCriterio2  = $("#valorCriterio2").val();
  var valorCriterio3  = $("#valorCriterio3").val();
  var valorCriterio4  = $("#valorCriterio4").val();
  
  var valorRangoCriterio1  = $("#valorRangoCriterio1").val();
  var valorRangoCriterio2  = $("#valorRangoCriterio2").val();
  var valorRangoCriterio3  = $("#valorRangoCriterio3").val();
  var valorRangoCriterio4  = $("#valorRangoCriterio4").val();

  var tipoAlto       = $("#tipoAlto").val();
  var tipoMedioAlto  = $("#tipoMedioAlto").val();
  var tipoMedioBajo  = $("#tipoMedioBajo").val();
  var tipoBajo       = $("#tipoBajo").val();

  var valorIndexado = $("#valorCalculado").val();

  if(fechaActualizacion == '')
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Ingrese la fecha de actualización",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }
  else
  {
    var parts = fechaActualizacion.split('/');
    var fechaActualizacion = parts[2] + '-' + parts[0] + '-' + parts[1];
  }

  if(selectCriterio1 == '')
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Seleccione el criterio 1",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }
  
  if(selectCriterio2 == '')
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Seleccione el criterio 2",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(selectCriterio3 == '')
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Seleccione el criterio 3",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(selectCriterio4 == '')
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Seleccione el criterio 4",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(valorCriterio1 == '')
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Ingrese el valor ponderado del criterio 1",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(valorCriterio2 == '')
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Ingrese el valor ponderado del criterio 2",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(valorCriterio3 == '')
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Ingrese el valor ponderado del criterio 3",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(valorCriterio4 == '')
  {
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Ingrese el valor ponderado del criterio 4",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  var sumaValorCriterio = parseInt(valorCriterio1) + parseInt(valorCriterio2) + parseInt(valorCriterio3) + parseInt(valorCriterio4);

  if(sumaValorCriterio < 100)
  {
    swal({   
      title: "Atención!",   
      text: "La suma ponderada de los criterios es menor a 100%",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(sumaValorCriterio > 100)
  {
    swal({   
      title: "Atención!",   
      text: "La suma ponderada de los criterios es mayor a 100%",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(tipoAlto < 0 || tipoAlto > 100)
  {
    swal({   
      title: "Atención!",   
      text: "La cuantificación del rango alto debe estar entre 0 y 100",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(tipoMedioAlto < 0)
  {
    swal({   
      title: "Atención!",   
      text: "La cuantificación del rango medio alto debe estar entre 0 y 100",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(tipoMedioBajo < 0)
  {
    swal({   
      title: "Atención!",   
      text: "La cuantificación del rango medio bajo debe estar entre 0 y 100",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(tipoBajo < 0)
  {
    swal({   
      title: "Atención!",   
      text: "La cuantificación del rango bajo debe estar entre 0 y 100",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  var ruta = base_url +'/'+ 'proviCalifica/validarGuardarCalificacion';
  
  var parametros = {  
    "fechaActualizacion" : fechaActualizacion,
    "yearsFallo": yearsFallo,
    "selectCriterio1" : selectCriterio1,
    "selectCriterio2" : selectCriterio2,
    "selectCriterio3" : selectCriterio3,
    "selectCriterio4" : selectCriterio4,
    "porcentajeCondena": porcentajeCondena,
    "valorCriterio1": valorCriterio1,
    "valorCriterio2": valorCriterio2,
    "valorCriterio3": valorCriterio3,
    "valorCriterio4": valorCriterio4,
    "valorRangoCriterio1": valorRangoCriterio1,
    "valorRangoCriterio2": valorRangoCriterio2,
    "valorRangoCriterio3": valorRangoCriterio3,
    "valorRangoCriterio4": valorRangoCriterio4,
    "valorIndexado": valorIndexado,
    "vigenciaRadicado":vigenciaRadicado,
    "idRadicado":idRadicado
  };
  
  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',
    beforeSend: function(){    
      $('.btn-guardar-calificacion').html('<span class="fa fa-spinner fa-spin"></span> Procesando...');
      $('.btn-guardar-calificacion').css({ 'pointer-events': 'none' });
    },
    success:  function (responseText) {
      swal("Guardada!", "La califiación ha sido guardada exitosamente, por favor dirigirse al último paso.", "success"); 
      $('.btn-guardar-calificacion').html('<span class="fa fa-save"></span> Guardar');
      $('.btn-guardar-calificacion').css({ 'pointer-events': 'auto' });
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

function descripcionCriterio(idCriterio)
{
  $('#modalDescripcion').modal('show');

  var ruta = base_url +'/'+ 'proviCalifica/descripcionCriterio';

  var parametros = {  
    "idCriterio":idCriterio
  };
  
  $.ajax({                
    data:  parametros,                 
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoDescripcion").html(responseText);
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