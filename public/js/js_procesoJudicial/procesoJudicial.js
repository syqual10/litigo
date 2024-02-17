var base_url = $('meta[name="base_url"]').attr("content");
var id_usuario = $('meta[name="id_usuario"]').attr("content");
var ciud_ope = $('meta[name="ciud_ope"]').attr("content");

var vectorDemandantes = [];
var vectorDdemandados = [];
var vectorAbogados = [];
var vectorEntidadesExternas = [];

function cargarJuzgado(conoceCodigo) {
  // 0 No conoce el código
  // 1 conoce el código
  if (conoceCodigo == 1) {
    var selectJuzgados = "";
    var vigRadJuzgado = "";
  } else {
    var selectJuzgados = $("#selectJuzgados").val();
    var vigRadJuzgado = $("#vigRadJuzgado").val();
  }

  var ruta = base_url + "/" + "proceso-judic/cargarJuzgado";

  var codigoProceso = $("#codigoProceso").val();

  var parametros = {
    codigoProceso: codigoProceso,
    conoceCodigo: conoceCodigo,
    selectJuzgados: selectJuzgados,
    vigRadJuzgado: vigRadJuzgado,
  };

  $.ajax({
    data: parametros,
    url: ruta,
    type: "post",
    beforeSend: function () {
      cargaLoader("Consultando los juzgados.  Un momento por favor..");
    },
    success: function (responseText) {
      ocultaLoader();
      if (responseText.codigoExiste == 0) {
        // código ya registrado
        swal({
          title: "Atención!",
          text:
            "El código del proceso ya se encuentra registrado en el radicado " +
            responseText.vigenciaRadicado +
            "-" +
            responseText.idRadicado,
          confirmButtonColor: "#f33923",
        });
        return false;
      } else if (responseText == 2) {
        // no encuentra juzgado
        swal({
          title: "Atención!",
          text: "No se encuentra coincidencia con algún juzgado",
          confirmButtonColor: "#f33923",
        });
        $("#ajax-cargarJuzgado").html("");
        $("#coincidenciaJuzgado").val(0); //encontró coincidencia
        return false;
      } else {
        $("#ajax-cargarJuzgado").html(responseText.vistaCodigoJuz);
        $("#coincidenciaJuzgado").val(1); //Si encontró coincidencia
        if (conoceCodigo == 0) {
          // no conoce el código llena el campo código proceso
          $("#codigoProceso").val(responseText.codigoProceso);
        }
      }
    },
    error: function (responseText) {
      error(responseText);
    },
  });
}

$("#documentoDemandante").keyup(function (e) {
  clearTimeout($.data(this, "timer"));
  if (e.keyCode == 32)
    //32 espacio
    searchDemandante(true, 0);
  else $(this).data("timer", setTimeout(searchDemandante, 500));
});

$("#nombreDependencia").keyup(function (e) {
  clearTimeout($.data(this, "timer"));
  if (e.keyCode == 32)
    //32 espacio
    searchDependencia(true, 0);
  else $(this).data("timer", setTimeout(searchDependencia, 500));
});

$("#documentoAbogado").keyup(function (e) {
  clearTimeout($.data(this, "timer"));
  if (e.keyCode == 32)
    //32 espacio
    searchAbogadoDemandante(true, 0);
  else $(this).data("timer", setTimeout(searchAbogadoDemandante, 500));
});

$("#nombreEntidadExt").keyup(function (e) {
  clearTimeout($.data(this, "timer"));
  if (e.keyCode == 32)
    //32 espacio
    searchEntidadExt(true, 0);
  else $(this).data("timer", setTimeout(searchEntidadExt, 500));
});

function searchDemandante(force) {
  var search_string = $("#documentoDemandante").val();
  if (!force && search_string.length < 5) return;

  if (search_string == "") {
    limpiarDemandante();
  } else {
    var ruta = base_url + "/" + "proceso-judic/busquedaDemandante";
    var parametros = {
      criterioDemandante: search_string,
    };

    $.ajax({
      data: parametros,
      url: ruta,
      type: "post",
      success: function (responseText) {
        $("#searchresDemandante").html(responseText);
      },
      error: function (responseText) {
        error(responseText);
      },
    });
  }
}

function searchDependencia(force) {
  var search_string = $("#nombreDependencia").val();
  if (!force && search_string.length < 5) return;

  if (search_string == "") {
    limpiarDependenciaDemandada();
  } else {
    var ruta = base_url + "/" + "proceso-judic/searchDependencia";
    var parametros = {
      criterioDemandado: search_string,
    };

    $.ajax({
      data: parametros,
      url: ruta,
      type: "post",
      success: function (responseText) {
        $("#searchresDependencia").html(responseText);
      },
      error: function (responseText) {
        error(responseText);
      },
    });
  }
}

function searchAbogadoDemandante(force) {
  var search_string = $("#documentoAbogado").val();
  if (!force && search_string.length < 5) return;

  if (search_string == "") {
    limpiarAbogadoDemandante();
  } else {
    var ruta = base_url + "/" + "proceso-judic/busquedaAbogadoDemandante";
    var parametros = {
      criterioAbogado: search_string,
    };

    $.ajax({
      data: parametros,
      url: ruta,
      type: "post",
      success: function (responseText) {
        $("#searchresAbogado").html(responseText);
      },
      error: function (responseText) {
        error(responseText);
      },
    });
  }
}

function searchEntidadExt(force) {
  var search_string = $("#nombreEntidadExt").val();
  if (!force && search_string.length < 5) return;

  if (search_string == "") {
    limpiarEntidadExt();
  } else {
    var ruta = base_url + "/" + "proceso-judic/busquedaEntidadExt";
    var parametros = {
      criterioEntidadExt: search_string,
    };

    $.ajax({
      data: parametros,
      url: ruta,
      type: "post",
      success: function (responseText) {
        $("#searchresEntidadesExt").html(responseText);
      },
      error: function (responseText) {
        error(responseText);
      },
    });
  }
}

function limpiarDemandante() {
  $("#searchresDemandante").html("");
  $("#documentoDemandante").val("");
}

function limpiarDependenciaDemandada() {
  $("#searchresDependencia").html("");
  $("#nombreDependencia").val("");
}

function limpiarAbogadoDemandante() {
  $("#searchresAbogado").html("");
  $("#documentoAbogado").val("");
}

function limpiarEntidadExt() {
  $("#searchresEntidadesExt").html("");
  $("#nombreEntidadExt").val("");
}

function seleccioneDemandante(idDemandante) {
  vectorDemandantes.push(idDemandante);
  vectorDemandantes = $.unique(vectorDemandantes);
  var jsonDemandantes = JSON.stringify(vectorDemandantes);

  var ruta = base_url + "/" + "proceso-judic/seleccioneDemandante";

  var parametros = {
    idDemandante: idDemandante,
    jsonDemandantes: jsonDemandantes,
  };

  $.ajax({
    data: parametros,
    url: ruta,
    type: "post",
    beforeSend: function () {
      cargaLoader("Seleccionando demandante.  Un momento por favor..");
    },
    success: function (responseText) {
      ocultaLoader();
      $("#resultadoDemandantesSeleccionados").html(responseText);
    },
    error: function (responseText) {
      error(responseText);
    },
  });
}

function seleccioneAbogado(idAbogado) {
  vectorAbogados.push(idAbogado);
  vectorAbogados = $.unique(vectorAbogados);
  var jsonAbogados = JSON.stringify(vectorAbogados);

  var ruta = base_url + "/" + "proceso-judic/seleccioneAbogado";

  var parametros = {
    idAbogado: idAbogado,
    jsonAbogados: jsonAbogados,
  };

  $.ajax({
    data: parametros,
    url: ruta,
    type: "post",
    beforeSend: function () {
      cargaLoader("Seleccionando abogado.  Un momento por favor..");
    },
    success: function (responseText) {
      ocultaLoader();
      $("#resultadoAbogadosSeleccionados").html(responseText);
    },
    error: function (responseText) {
      error(responseText);
    },
  });
}

function seleccioneDemandado(idDemandado) {
  vectorDdemandados.push(idDemandado);
  vectorDdemandados = $.unique(vectorDdemandados);
  var jsonDemandados = JSON.stringify(vectorDdemandados);

  var ruta = base_url + "/" + "proceso-judic/seleccioneDemandado";

  var parametros = {
    idDemandado: idDemandado,
    jsonDemandados: jsonDemandados,
  };

  $.ajax({
    data: parametros,
    url: ruta,
    type: "post",
    beforeSend: function () {
      cargaLoader(
        "Seleccionando dependencia demandada.  Un momento por favor.."
      );
    },
    success: function (responseText) {
      ocultaLoader();
      $("#resultadoDemandandosSeleccionados").html(responseText);
    },
    error: function (responseText) {
      error(responseText);
    },
  });
}

function removerDemandante(idDemandante) {
  $("div#tablaDemandantes_" + idDemandante).remove();

  vectorDemandantes = $.grep(vectorDemandantes, function (value) {
    return value != idDemandante;
  });
  vectorDemandantes = $.unique(vectorDemandantes);
}

function removerDemandado(idDemandado) {
  $("div#tablaDemandados_" + idDemandado).remove();

  vectorDdemandados = $.grep(vectorDdemandados, function (value) {
    return value != idDemandado;
  });
  vectorDdemandados = $.unique(vectorDdemandados);
}

function removerAbogado(idAbogado) {
  $("div#tablaAbogados_" + idAbogado).remove();

  vectorAbogados = $.grep(vectorAbogados, function (value) {
    return value != idAbogado;
  });
  vectorAbogados = $.unique(vectorAbogados);
}

function nuevoDemandante() {
  $("#modalAgregarDemandante").modal({
    show: true,
    keyboard: false,
    backdrop: "static",
  });

  var ruta = base_url + "/" + "proceso-judic/nuevoDemandante";

  $.ajax({
    url: ruta,
    type: "post",
    success: function (responseText) {
      $("#resultadoAgregarDemandandante").html(responseText);
      $(".select2").select2({ width: "100%" });
    },
    error: function (responseText) {
      error(responseText);
    },
  });
}

function nuevoDemandando() {
  $("#modalAgregarDemandado").modal({
    show: true,
    keyboard: false,
    backdrop: "static",
  });

  var ruta = base_url + "/" + "proceso-judic/nuevoDemandando";

  $.ajax({
    url: ruta,
    type: "post",
    beforeSend: function () {
      cargaLoader(
        "Agregando demandante en la base de datos.  Un momento por favor.."
      );
    },
    success: function (responseText) {
      ocultaLoader();
      $("#resultadoAgregarDemandado").html(responseText);
      $(".select2").select2({ width: "100%" });
    },
    error: function (responseText) {
      error(responseText);
    },
  });
}

function nuevoAbogado() {
  $("#modalAgregarAbogadoDemandante").modal({
    show: true,
    keyboard: false,
    backdrop: "static",
  });

  var ruta = base_url + "/" + "proceso-judic/nuevoAbogado";

  $.ajax({
    url: ruta,
    type: "post",
    success: function (responseText) {
      $("#resultadoAgregarAbogadoDemandante").html(responseText);
      $(".select2").select2({ width: "100%" });
    },
    error: function (responseText) {
      error(responseText);
    },
  });
}

function elegirBarrioDemandante(idCiudad) {
  var ciudadOperacion = ciud_ope;

  if (idCiudad == ciudadOperacion) {
    //339 id de Manizales en la tabla ciudades, si es la de operación
    var ruta = base_url + "/" + "proceso-judic/elegirBarrioDemandante";

    var parametros = {
      ciudadOperacion: ciudadOperacion, // es la ciudad de operación, guarda el barrio
    };

    $("#resultadoBarrioDemandante").css("display", "block");

    $.ajax({
      data: parametros,
      url: ruta,
      type: "post",
      beforeSend: function () {
        cargaLoader("Consultando territorios.  Un momento por favor..");
      },
      success: function (responseText) {
        ocultaLoader();
        $("#resultadoBarrioDemandante").html(responseText);
        $(".select2").select2({ width: "100%" });
      },
      error: function (responseText) {
        error(responseText);
      },
    });
  } else {
    $("#resultadoBarrioDemandante").css("display", "none");
    $("#selectBarrioDemandante").val(0);
  }
}

function elegirBarrioDemandanteEditar(idCiudad, idDemandante) {
  var ciudadOperacion = ciud_ope;

  if (idCiudad == ciudadOperacion) {
    //339 id de Manizales en la tabla ciudades, si es la de operación
    var ruta = base_url + "/" + "proceso-judic/elegirBarrioDemandanteEditar";

    var parametros = {
      idDemandante: idDemandante,
      ciudadOperacion: ciudadOperacion, // es la ciudad de operación, guarda el barrio
    };

    $("#resultadoBarrioDemandanteEditar").css("display", "block");

    $.ajax({
      data: parametros,
      url: ruta,
      type: "post",
      beforeSend: function () {
        cargaLoader("Cargando territorios.  Un momento por favor..");
      },
      success: function (responseText) {
        ocultaLoader();
        $("#resultadoBarrioDemandanteEditar").html(responseText);
        $(".select2").select2({ width: "100%" });
      },
      error: function (responseText) {
        error(responseText);
      },
    });
  } else {
    $("#resultadoBarrioDemandanteEditar").css("display", "none");
    $("#selectBarrioDemandanteEditar").val(0);
  }
}

function elegirBarrioDemandado(idCiudad) {
  var ciudadOperacion = ciud_ope;

  if (idCiudad == ciudadOperacion) {
    //339 id de Manizales en la tabla ciudades, si es la de operación
    var ruta = base_url + "/" + "proceso-judic/elegirBarrioDemandado";

    var parametros = {
      ciudadOperacion: ciudadOperacion, // es la ciudad de operación, guarda el barrio
    };

    $("#resultadoBarrioDemandado").css("display", "block");

    $.ajax({
      data: parametros,
      url: ruta,
      type: "post",
      beforeSend: function () {
        cargaLoader("Cargando territorios.  Un momento por favor..");
      },
      success: function (responseText) {
        ocultaLoader();
        $("#resultadoBarrioDemandado").html(responseText);
        $(".select2").select2({ width: "100%" });
      },
      error: function (responseText) {
        error(responseText);
      },
    });
  } else {
    $("#resultadoBarrioDemandado").css("display", "none");
    $("#selectBarrioDemandado").val(0);
  }
}

function elegirBarrioDemandadoEditar(idCiudad) {
  var ciudadOperacion = ciud_ope;

  if (idCiudad == ciudadOperacion) {
    //339 id de Manizales en la tabla ciudades, si es la de operación
    var ruta = base_url + "/" + "proceso-judic/elegirBarrioDemandadoEditar";

    var parametros = {
      ciudadOperacion: ciudadOperacion, // es la ciudad de operación, guarda el barrio
    };

    $("#resultadoBarrioDemandadoEditar").css("display", "block");

    $.ajax({
      data: parametros,
      url: ruta,
      type: "post",
      beforeSend: function () {
        cargaLoader("Cargando territorios.  Un momento por favor..");
      },
      success: function (responseText) {
        ocultaLoader();
        $("#resultadoBarrioDemandadoEditar").html(responseText);
        $(".select2").select2({ width: "100%" });
      },
      error: function (responseText) {
        error(responseText);
      },
    });
  } else {
    $("#resultadoBarrioDemandadoEditar").css("display", "none");
    $("#selectBarrioDemandadoEditar").val(0);
  }
}

function validarGuardarDemandante() {
  var ciudadOperacion = ciud_ope;
  var documentoDemandanteNuevo = $("#documentoDemandanteNuevo").val();
  var selecTipoDocumento = $("#selecTipoDocumento").val();
  var nombreDemandante = $("#nombreDemandante").val();
  var correoDemandante = $("#correoDemandante").val();
  var telefonoDemandante = $("#telefonoDemandante").val();
  var celularDemandante = $("#celularDemandante").val();
  var direccionDemandante = $("#direccionDemandante").val();
  var selectCiudadDemandante = $("#selectCiudadDemandante").val();
  var selectBarrioDemandante = $("#selectBarrioDemandante").val();

  if (nombreDemandante == "") {
    swal({
      title: "Campo sin diligenciar!",
      text: "Ingrese el nombre del demandante",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  var reg = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
  if (correoDemandante != "") {
    if (!reg.test(correoDemandante)) {
      swal({
        title: "Campo sin diligenciar!",
        text: "Ingrese un correo correcto para el demandante",
        confirmButtonColor: "#f33923",
      });
      return false;
    }
  }

  if (celularDemandante != "") {
    var expresionRegular1 = /^[3]([0-9]+){9}$/; //<--- con esto vamos a validar el numero-->
    if (!expresionRegular1.test(celularDemandante)) {
      swal({
        title: "Campo sin diligenciar!",
        text: "Ingrese un número de celular correcto para el demandante",
        confirmButtonColor: "#f33923",
      });
      return false;
    }
  }

  var ruta = base_url + "/" + "proceso-judic/validarGuardarDemandante";

  var parametros = {
    documentoDemandanteNuevo: documentoDemandanteNuevo,
    selecTipoDocumento: selecTipoDocumento,
    nombreDemandante: nombreDemandante,
    correoDemandante: correoDemandante,
    telefonoDemandante: telefonoDemandante,
    celularDemandante: celularDemandante,
    direccionDemandante: direccionDemandante,
    selectCiudadDemandante: selectCiudadDemandante,
    selectBarrioDemandante: selectBarrioDemandante,
  };

  $.ajax({
    data: parametros,
    url: ruta,
    type: "post",
    beforeSend: function () {
      cargaLoader("Guardando demandante. Un momento por favor..");
      $(".btn-guardar-demandante").html(
        '<span class="fa fa-spinner fa-spin"></span> Procesando...'
      );
      $(".btn-guardar-demandante").css({ "pointer-events": "none" });
    },
    success: function (responseText) {
      ocultaLoader();
      if (responseText == 1) {
        // correo repetido
        swal({
          title: "Atención!",
          text: "El correo ya se encuentra registrado",
          confirmButtonColor: "#f33923",
        });
        $(".btn-guardar-demandante").html(
          '<span class="fa fa-save"></span> Guardar'
        );
        $(".btn-guardar-demandante").css({ "pointer-events": "auto" });
        return false;
      } else if (responseText == 2) {
        // documento repetido
        swal({
          title: "Atención!",
          text: "El demandante ya se encuentra registrado",
          confirmButtonColor: "#f33923",
        });
        $(".btn-guardar-demandante").html(
          '<span class="fa fa-save"></span> Guardar'
        );
        $(".btn-guardar-demandante").css({ "pointer-events": "auto" });
        return false;
      } else {
        $("#modalAgregarDemandante").modal("hide");
        seleccioneDemandante(responseText);
        swal(
          "Guardado!",
          "El demandante ha sido guardado exitosamente.",
          "success"
        );
      }
    },
    error: function (responseText) {
      error(responseText);
    },
  });
}

function validarGuardarAbogado() {
  var documentoAbogado = $("#documentoAbogadoDemandante").val();
  var selecTipoDocumentoAbogado = $("#selecTipoDocumentoAbogado").val();
  var nombreAbogado = $("#nombreAbogado").val();
  var tarjetaAbogado = $("#tarjetaAbogado").val();

  if (nombreAbogado == "") {
    swal({
      title: "Campo sin diligenciar!",
      text: "Ingrese el nombre del abogado",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  var ruta = base_url + "/" + "proceso-judic/validarGuardarAbogado";

  var parametros = {
    documentoAbogado: documentoAbogado,
    selecTipoDocumentoAbogado: selecTipoDocumentoAbogado,
    nombreAbogado: nombreAbogado,
    tarjetaAbogado: tarjetaAbogado,
  };

  $.ajax({
    data: parametros,
    url: ruta,
    type: "post",
    beforeSend: function () {
      cargaLoader("Guardando abogado. Un momento por favor..");
      $(".btn-guardar-abogado").html(
        '<span class="fa fa-spinner fa-spin"></span> Procesando...'
      );
      $(".btn-guardar-abogado").css({ "pointer-events": "none" });
    },
    success: function (responseText) {
      ocultaLoader();
      if (responseText == 0) {
        // documento repetido
        swal({
          title: "Atención!",
          text: "El abogado ya se encuentra registrado",
          confirmButtonColor: "#f33923",
        });
        $(".btn-guardar-abogado").html(
          '<span class="fa fa-save"></span> Guardar'
        );
        $(".btn-guardar-abogado").css({ "pointer-events": "auto" });
        return false;
      } else {
        $("#modalAgregarAbogadoDemandante").modal("hide");
        seleccioneAbogado(responseText);
        swal(
          "Guardado!",
          "El abogado ha sido guardado exitosamente.",
          "success"
        );
      }
    },
    error: function (responseText) {
      error(responseText);
    },
  });
}

function validarGuardarDemandado() {
  var ciudadOperacion = ciud_ope;
  var documentoDemandadoNuevo = $("#documentoDemandadoNuevo").val();
  var selecTipoDocumentoDemandado = $("#selecTipoDocumentoDemandado").val();
  var nombreDemandado = $("#nombreDemandado").val();
  var correoDemandado = $("#correoDemandado").val();
  var telefonoDemandado = $("#telefonoDemandado").val();
  var celularDemandado = $("#celularDemandado").val();
  var direccionDemandado = $("#direccionDemandado").val();
  var selectCiudadDemandado = $("#selectCiudadDemandado").val();
  var selectBarrioDemandado = $("#selectBarrioDemandado").val();

  if (documentoDemandadoNuevo == "") {
    swal({
      title: "Campo sin diligenciar!",
      text: "Debe ingresar el documento del demandado",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  if (selecTipoDocumentoDemandado == "") {
    swal({
      title: "Campo sin diligenciar!",
      text: "Debe seleccionar el tipo del documento del demandado",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  if (nombreDemandado == "") {
    swal({
      title: "Campo sin diligenciar!",
      text: "Ingrese el nombre del demandado",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  var reg = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
  if (correoDemandado != "") {
    if (!reg.test(correoDemandado)) {
      swal({
        title: "Campo sin diligenciar!",
        text: "Ingrese un correo correcto para el demandado",
        confirmButtonColor: "#f33923",
      });
      return false;
    }
  }

  if (celularDemandado != "") {
    var expresionRegular1 = /^[3]([0-9]+){9}$/; //<--- con esto vamos a validar el numero-->
    if (!expresionRegular1.test(celularDemandado)) {
      swal({
        title: "Campo sin diligenciar!",
        text: "Ingrese un número de celular correcto para el demandado",
        confirmButtonColor: "#f33923",
      });
      return false;
    }
  }

  if (direccionDemandado == "") {
    swal({
      title: "Campo sin diligenciar!",
      text: "Ingrese la dirección del demandado",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  if (selectCiudadDemandado == "") {
    swal({
      title: "Campo sin diligenciar!",
      text: "Ingrese la ciudad del demandado",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  if (selectCiudadDemandado == ciudadOperacion) {
    if (selectBarrioDemandado == "") {
      swal({
        title: "Campo sin diligenciar!",
        text: "Ingrese el barrio del demandado",
        confirmButtonColor: "#f33923",
      });
      return false;
    }
  }

  var ruta = base_url + "/" + "proceso-judic/validarGuardarDemandado";

  var parametros = {
    documentoDemandadoNuevo: documentoDemandadoNuevo,
    selecTipoDocumentoDemandado: selecTipoDocumentoDemandado,
    nombreDemandado: nombreDemandado,
    correoDemandado: correoDemandado,
    telefonoDemandado: telefonoDemandado,
    celularDemandado: celularDemandado,
    direccionDemandado: direccionDemandado,
    selectCiudadDemandado: selectCiudadDemandado,
    selectBarrioDemandado: selectBarrioDemandado,
  };

  $.ajax({
    data: parametros,
    url: ruta,
    type: "post",
    beforeSend: function () {
      cargaLoader("Guardando demandado.  Un momento por favor..");
      $(".btn-guardar-demandado").html(
        '<span class="fa fa-spinner fa-spin"></span> Procesando...'
      );
      $(".btn-guardar-demandado").css({ "pointer-events": "none" });
    },
    success: function (responseText) {
      ocultaLoader();
      if (responseText == 1) {
        // correo repetido
        swal({
          title: "Atención!",
          text: "El correo ya se encuentra registrado",
          confirmButtonColor: "#f33923",
        });
        $(".btn-guardar-demandado").html(
          '<span class="fa fa-save"></span> Guardar'
        );
        $(".btn-guardar-demandado").css({ "pointer-events": "auto" });
        return false;
      } else if (responseText == 2) {
        // documento repetido
        swal({
          title: "Atención!",
          text: "El demandado ya se encuentra registrado",
          confirmButtonColor: "#f33923",
        });
        $(".btn-guardar-demandado").html(
          '<span class="fa fa-save"></span> Guardar'
        );
        $(".btn-guardar-demandado").css({ "pointer-events": "auto" });
        return false;
      } else {
        $("#modalAgregarDemandado").modal("hide");
        seleccioneDemandado(responseText);
        swal(
          "Guardado!",
          "El demandado ha sido guardado exitosamente.",
          "success"
        );
      }
    },
    error: function (responseText) {
      error(responseText);
    },
  });
}

function editarDemandante(idDemandante) {
  $("#modalEditarDemandante").modal({
    show: true,
    keyboard: false,
    backdrop: "static",
  });

  var ruta = base_url + "/" + "proceso-judic/editarDemandante";

  var parametros = {
    idDemandante: idDemandante,
  };

  $.ajax({
    data: parametros,
    url: ruta,
    type: "post",
    success: function (responseText) {
      $("#resultadoEditarDemandante").html(responseText);
      $(".select2").select2({ width: "100%" });
    },
    error: function (responseText) {
      error(responseText);
    },
  });
}

function editarAbogado(idAbogado) {
  $("#modalEditarAbogadoDemandante").modal({
    show: true,
    keyboard: false,
    backdrop: "static",
  });

  var ruta = base_url + "/" + "proceso-judic/editarAbogado";

  var parametros = {
    idAbogado: idAbogado,
  };

  $.ajax({
    data: parametros,
    url: ruta,
    type: "post",
    success: function (responseText) {
      $("#resultadoEditarAbogadoDemandandante").html(responseText);
      $(".select2").select2({ width: "100%" });
    },
    error: function (responseText) {
      error(responseText);
    },
  });
}

function editarDemandado(idDemandado) {
  $("#modalEditarDemandado").modal({
    show: true,
    keyboard: false,
    backdrop: "static",
  });

  var ruta = base_url + "/" + "proceso-judic/editarDemandado";

  var parametros = {
    idDemandado: idDemandado,
  };

  $.ajax({
    data: parametros,
    url: ruta,
    type: "post",
    success: function (responseText) {
      $("#resultadoEditarDemandado").html(responseText);
      $(".select2").select2({ width: "100%" });
    },
    error: function (responseText) {
      error(responseText);
    },
  });
}

function validarEditarDemandante(idDemandante) {
  var ciudadOperacion = ciud_ope;
  var documentoDemandanteNuevoEditar = $(
    "#documentoDemandanteNuevoEditar"
  ).val();
  var selecTipoDocumentoEditar = $("#selecTipoDocumentoEditar").val();
  var nombreDemandanteEditar = $("#nombreDemandanteEditar").val();
  var correoDemandanteEditar = $("#correoDemandanteEditar").val();
  var telefonoDemandanteEditar = $("#telefonoDemandanteEditar").val();
  var celularDemandanteEditar = $("#celularDemandanteEditar").val();
  var direccionDemandanteEditar = $("#direccionDemandanteEditar").val();
  var selectCiudadDemandanteEditar = $("#selectCiudadDemandanteEditar").val();
  var selectBarrioDemandanteEditar = $("#selectBarrioDemandanteEditar").val();

  if (nombreDemandanteEditar == "") {
    swal({
      title: "Campo sin diligenciar!",
      text: "Ingrese el nombre del demandante",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  var reg = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
  if (correoDemandanteEditar != "") {
    if (!reg.test(correoDemandanteEditar)) {
      swal({
        title: "Campo sin diligenciar!",
        text: "Ingrese un correo correcto para el demandante",
        confirmButtonColor: "#f33923",
      });
      return false;
    }
  }

  if (celularDemandanteEditar != "") {
    var expresionRegular1 = /^[3]([0-9]+){9}$/; //<--- con esto vamos a validar el numero-->
    if (!expresionRegular1.test(celularDemandanteEditar)) {
      swal({
        title: "Campo sin diligenciar!",
        text: "Ingrese un número de celular correcto para el demandante",
        confirmButtonColor: "#f33923",
      });
      return false;
    }
  }

  var ruta = base_url + "/" + "proceso-judic/validarEditarDemandante";

  var parametros = {
    idDemandante: idDemandante,
    documentoDemandanteNuevoEditar: documentoDemandanteNuevoEditar,
    selecTipoDocumentoEditar: selecTipoDocumentoEditar,
    nombreDemandanteEditar: nombreDemandanteEditar,
    correoDemandanteEditar: correoDemandanteEditar,
    telefonoDemandanteEditar: telefonoDemandanteEditar,
    celularDemandanteEditar: celularDemandanteEditar,
    direccionDemandanteEditar: direccionDemandanteEditar,
    selectCiudadDemandanteEditar: selectCiudadDemandanteEditar,
    selectBarrioDemandanteEditar: selectBarrioDemandanteEditar,
  };

  $.ajax({
    data: parametros,
    url: ruta,
    type: "post",
    beforeSend: function () {
      cargaLoader("Modificando demandante.  Un momento por favor..");
      $(".btn-editar-demandante").html(
        '<span class="fa fa-spinner fa-spin"></span> Procesando...'
      );
      $(".btn-editar-demandante").css({ "pointer-events": "none" });
    },
    success: function (responseText) {
      ocultaLoader();
      if (responseText == 1) {
        // correo repetido
        swal({
          title: "Atención!",
          text: "El correo ya se encuentra registrado",
          confirmButtonColor: "#f33923",
        });
        $(".btn-editar-demandante").html(
          '<span class="fa fa-save"></span> Modificado'
        );
        $(".btn-editar-demandante").css({ "pointer-events": "auto" });
        return false;
      } else if (responseText == 2) {
        // documento repetido
        swal({
          title: "Atención!",
          text: "El demandante ya se encuentra registrado",
          confirmButtonColor: "#f33923",
        });
        $(".btn-editar-demandante").html(
          '<span class="fa fa-save"></span> Modificado'
        );
        $(".btn-editar-demandante").css({ "pointer-events": "auto" });
        return false;
      } else {
        $("#modalEditarDemandante").modal("hide");
        seleccioneDemandante(idDemandante);
        swal(
          "Modificado!",
          "El demandante ha sido modidicado exitosamente.",
          "success"
        );
      }
    },
    error: function (responseText) {
      error(responseText);
    },
  });
}

function validarEditarAbogado(idAbogado) {
  var documentoAbogadoDemandanteEditar = $(
    "#documentoAbogadoDemandanteEditar"
  ).val();
  var selecTipoDocumentoAbogadoEditar = $(
    "#selecTipoDocumentoAbogadoEditar"
  ).val();
  var nombreAbogadoEditar = $("#nombreAbogadoEditar").val();
  var tarjetaAbogadoEditar = $("#tarjetaAbogadoEditar").val();

  if (documentoAbogadoDemandanteEditar == "") {
    swal({
      title: "Campo sin diligenciar!",
      text: "Debe ingresar el documento del abogado",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  if (selecTipoDocumentoAbogadoEditar == "") {
    swal({
      title: "Campo sin diligenciar!",
      text: "Debe seleccionar el tipo del documento del abogado",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  if (nombreAbogadoEditar == "") {
    swal({
      title: "Campo sin diligenciar!",
      text: "Ingrese el nombre del abogado",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  var ruta = base_url + "/" + "proceso-judic/validarEditarAbogado";

  var parametros = {
    idAbogado: idAbogado,
    documentoAbogadoDemandanteEditar: documentoAbogadoDemandanteEditar,
    selecTipoDocumentoAbogadoEditar: selecTipoDocumentoAbogadoEditar,
    nombreAbogadoEditar: nombreAbogadoEditar,
    tarjetaAbogadoEditar: tarjetaAbogadoEditar,
  };

  $.ajax({
    data: parametros,
    url: ruta,
    type: "post",
    beforeSend: function () {
      cargaLoader("Modificando abogado.  Un momento por favor..");
      $(".btn-editar-abogado").html(
        '<span class="fa fa-spinner fa-spin"></span> Procesando...'
      );
      $(".btn-editar-abogado").css({ "pointer-events": "none" });
    },
    success: function (responseText) {
      ocultaLoader();
      if (responseText == 0) {
        // documento repetido
        swal({
          title: "Atención!",
          text: "El abogado ya se encuentra registrado",
          confirmButtonColor: "#f33923",
        });
        $(".btn-editar-abogado").html(
          '<span class="fa fa-save"></span> Modificado'
        );
        $(".btn-editar-abogado").css({ "pointer-events": "auto" });
        return false;
      } else {
        $("#modalEditarAbogadoDemandante").modal("hide");
        seleccioneAbogado(idAbogado);
        swal(
          "Modificado!",
          "El abogado ha sido modidicado exitosamente.",
          "success"
        );
      }
    },
    error: function (responseText) {
      error(responseText);
    },
  });
}

function validarEditarDemandado(idDemandado) {
  var ciudadOperacion = ciud_ope;
  var documentoDemandadoNuevoEditar = $("#documentoDemandadoNuevoEditar").val();
  var selecTipoDocumentoDemandadoEditar = $(
    "#selecTipoDocumentoDemandadoEditar"
  ).val();
  var nombreDemandadoEditar = $("#nombreDemandadoEditar").val();
  var correoDemandadoEditar = $("#correoDemandadoEditar").val();
  var telefonoDemandadoEditar = $("#telefonoDemandadoEditar").val();
  var celularDemandadoEditar = $("#celularDemandadoEditar").val();
  var direccionDemandadoEditar = $("#direccionDemandadoEditar").val();
  var selectCiudadDemandadoEditar = $("#selectCiudadDemandadoEditar").val();
  var selectBarrioDemandadoEditar = $("#selectBarrioDemandadoEditar").val();

  if (documentoDemandadoNuevoEditar == "") {
    swal({
      title: "Campo sin diligenciar!",
      text: "Debe ingresar el documento del demandado",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  if (selecTipoDocumentoDemandadoEditar == "") {
    swal({
      title: "Campo sin diligenciar!",
      text: "Debe seleccionar el tipo del documento del demandado",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  if (nombreDemandadoEditar == "") {
    swal({
      title: "Campo sin diligenciar!",
      text: "Ingrese el nombre del demandado",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  var reg = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
  if (correoDemandadoEditar != "") {
    if (!reg.test(correoDemandadoEditar)) {
      swal({
        title: "Campo sin diligenciar!",
        text: "Ingrese un correo correcto para el demandado",
        confirmButtonColor: "#f33923",
      });
      return false;
    }
  }

  if (celularDemandadoEditar != "") {
    var expresionRegular1 = /^[3]([0-9]+){9}$/; //<--- con esto vamos a validar el numero-->
    if (!expresionRegular1.test(celularDemandadoEditar)) {
      swal({
        title: "Campo sin diligenciar!",
        text: "Ingrese un número de celular correcto para el demandado",
        confirmButtonColor: "#f33923",
      });
      return false;
    }
  }

  if (direccionDemandadoEditar == "") {
    swal({
      title: "Campo sin diligenciar!",
      text: "Ingrese la dirección del demandado",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  if (selectCiudadDemandadoEditar == "") {
    swal({
      title: "Campo sin diligenciar!",
      text: "Ingrese la ciudad del demandado",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  if (selectCiudadDemandadoEditar == ciudadOperacion) {
    if (selectBarrioDemandadoEditar == "") {
      swal({
        title: "Campo sin diligenciar!",
        text: "Ingrese el barrio del demandado",
        confirmButtonColor: "#f33923",
      });
      return false;
    }
  }

  var ruta = base_url + "/" + "proceso-judic/validarEditarDemandado";

  var parametros = {
    idDemandado: idDemandado,
    documentoDemandadoNuevoEditar: documentoDemandadoNuevoEditar,
    selecTipoDocumentoDemandadoEditar: selecTipoDocumentoDemandadoEditar,
    nombreDemandadoEditar: nombreDemandadoEditar,
    correoDemandadoEditar: correoDemandadoEditar,
    telefonoDemandadoEditar: telefonoDemandadoEditar,
    celularDemandadoEditar: celularDemandadoEditar,
    direccionDemandadoEditar: direccionDemandadoEditar,
    selectCiudadDemandadoEditar: selectCiudadDemandadoEditar,
    selectBarrioDemandadoEditar: selectBarrioDemandadoEditar,
  };

  $.ajax({
    data: parametros,
    url: ruta,
    type: "post",
    beforeSend: function () {
      cargaLoader("Modificando demandado. Un momento por favor..");
      $(".btn-editar-demandado").html(
        '<span class="fa fa-spinner fa-spin"></span> Procesando...'
      );
      $(".btn-editar-demandado").css({ "pointer-events": "none" });
    },
    success: function (responseText) {
      ocultaLoader();
      if (responseText == 1) {
        // correo repetido
        swal({
          title: "Atención!",
          text: "El correo ya se encuentra registrado",
          confirmButtonColor: "#f33923",
        });
        $(".btn-editar-demandado").html(
          '<span class="fa fa-save"></span> Guardar'
        );
        $(".btn-editar-demandado").css({ "pointer-events": "auto" });
        return false;
      } else if (responseText == 2) {
        // documento repetido
        swal({
          title: "Atención!",
          text: "El demandado ya se encuentra registrado",
          confirmButtonColor: "#f33923",
        });
        $(".btn-editar-demandado").html(
          '<span class="fa fa-save"></span> Guardar'
        );
        $(".btn-editar-demandado").css({ "pointer-events": "auto" });
        return false;
      } else {
        $("#modalEditarDemandado").modal("hide");
        seleccioneDemandado(idDemandado);
        swal(
          "Guardado!",
          "El demandado ha sido guardado exitosamente.",
          "success"
        );
      }
    },
    error: function (responseText) {
      error(responseText);
    },
  });
}

function validarGuardarRadicado() {
  var idTipoProceso = $("#idTipoProceso").val();
  var sentidoEntidad = $("input[name=sentidoEntidad]:checked").val();
  var coincidenciaJuzgado = $("#coincidenciaJuzgado").val();
  var codigoProceso = $("#codigoProceso").val();
  var selectMedioControl = $("#selectMedioControl").val();
  var asunto = $("#asunto").val();
  var selectTema = $("#selectTema").val();
  var fechaNotifi = $("#fechaNotifi").val();
  var descripcionHechos = $("#descripcionHechos").val();
  var idJuzgado = $("#idJuzgado").val();
  var vigenciaProceso = $("#vigenciaProceso").val();
  var selectRadicado = $("#selectRadicadoConcilia").val();

  if (coincidenciaJuzgado == 0) {
    swal({
      title: "Atención!",
      text: "No se encontró coincidencia con ningún juzgado",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  if (codigoProceso == "") {
    swal({
      title: "Campo sin diligenciar!",
      text: "Ingrese el código del proceso",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  if (selectMedioControl == "") {
    swal({
      title: "Campo sin diligenciar!",
      text: "Seleccione el medio de control",
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

  if (selectTema == "") {
    swal({
      title: "Campo sin diligenciar!",
      text: "Ingrese el tema del proceso",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  if (vectorDemandantes.length == 0) {
    swal({
      title: "Atención!",
      text: "No hay demandantes seleccionados",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  var jsonDemandantes = JSON.stringify(vectorDemandantes);

  if (vectorDdemandados.length == 0) {
    swal({
      title: "Atención!",
      text: "No hay demandados seleccionados",
      confirmButtonColor: "#f33923",
    });
    return false;
  }
  var jsonDemandados = JSON.stringify(vectorDdemandados);

  var jsonAbogados = JSON.stringify(vectorAbogados);

  if (descripcionHechos == "") {
    swal({
      title: "Atención!",
      text: "Ingrese una descripción de los hechos",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  var jsonEntidadesExt = JSON.stringify(vectorEntidadesExternas);

  /* CUANTÍAS*/
  var selectUnidadMonetaria = []; // 1 salarios 2 pesos
  var valor = []; //valor en pesos o valor en salarios
  var valorPesos = []; //valor consolidado en salarios o pesos

  var campoSelectUnidadMonetaria;
  var campoValor;
  var campoValorPesos;

  $("#tablaCuantias tbody tr").each(function (index) {
    $(this)
      .children("td")
      .each(function (indexCuantia) {
        switch (indexCuantia) {
          case 1:
            campoSelectUnidadMonetaria = $(this).text();
            break;
          case 2:
            campoValor = $(this).text();
            break;
          case 3:
            campoValorPesos = $(this).text();
            break;
        }
      });

    selectUnidadMonetaria.push(campoSelectUnidadMonetaria);
    valor.push(campoValor);
    valorPesos.push(campoValorPesos);
  });
  var jsonSelectUnidadMonetaria = JSON.stringify(selectUnidadMonetaria);
  var jsonValor = JSON.stringify(valor);
  var jsonValorPesos = JSON.stringify(valorPesos);
  /* CUANTÍAS*/

  var ruta = base_url + "/" + "proceso-judic/validarGuardarRadicado";

  var parametros = {
    idTipoProceso,
    sentidoEntidad,
    selectMedioControl,
    selectTema,
    asunto,
    jsonDemandantes,
    jsonDemandados,
    jsonAbogados,
    fechaNotifi,
    codigoProceso,
    descripcionHechos,
    idJuzgado,
    vigenciaProceso,
    selectRadicado,
    jsonEntidadesExt,
    selectUnidadMonetaria,
    jsonSelectUnidadMonetaria,
    jsonValor,
    jsonValorPesos,
  };

  $.ajax({
    data: parametros,
    url: ruta,
    type: "post",
    beforeSend: function () {
      cargaLoader(
        "Guardando la demanda y generando radicado.  Un momento por favor.."
      );
      $(".buttonFinish").html(
        '<span class="fa fa-spinner fa-spin"></span> Procesando...'
      );
      $(".buttonFinish").css({ "pointer-events": "none" });
    },
    success: function (responseText) {
      ocultaLoader();
      if (responseText == 1) {
        swal({
          title: "Atención!",
          text: "No hay responsables asignados al reparto",
          confirmButtonColor: "#f33923",
        });
        $(".buttonFinish").html("Terminar");
        $(".buttonFinish").prop("disabled", true);
        return false;
      } else if (responseText == 1) {
        swal({
          title: "Atención!",
          text: "No se pudo mover el archivo",
          confirmButtonColor: "#f33923",
        });
      } else {
        $("#idRadicadoIni").val(responseText.idRadicado);
        $("#vigenciaRadicadoIni").val(responseText.vigenciaRadicado);

        var responsablesSiguiente = JSON.parse(
          JSON.stringify(responseText.resposanblesReparto)
        );

        if (responsablesSiguiente.length > 0) {
          for (var i = 0; i < responsablesSiguiente.length; i++) {
            socket.emit("server_nuevoEnBuzon", {
              idUsuarioSiguiente:
                responsablesSiguiente[i]["usuarios_idUsuario"],
              mensaje:
                "Le fue asignado el radicado: " +
                responseText.vigenciaRadicado +
                "-" +
                responseText.idRadicado +
                ", por favor revise su buzón.",
            });
          }
        }
        $(".buttonFinish").html("Terminar");
        $(".buttonFinish").prop("disabled", true);

        var myDropzone = Dropzone.forElement("#dropzoneRadicarProcesoJudi");
        myDropzone.processQueue();

        if (Object.keys(myDropzone.files).length == 0) {
          swal(
            {
              title:
                "Radicado: " +
                responseText.vigenciaRadicado +
                "-" +
                responseText.idRadicado,
              text: "Seleccione una de las opciones",
              type: "success",
              showCancelButton: true,
              confirmButtonColor: "#23b5e6",
              confirmButtonText: "Generar el Rótulo de Carpeta",
              cancelButtonText: "Radicar un nuevo proceso",
              closeOnConfirm: true,
              closeOnCancel: true,
            },
            function (isConfirm) {
              if (isConfirm) {
                generarCaratula(
                  responseText.vigenciaRadicado,
                  responseText.idRadicado
                );
              } else {
                var rutaRedirect =
                  base_url + "/" + "proceso-judic/index/" + idTipoProceso;
                setTimeout(function () {
                  window.location.href = rutaRedirect;
                }, 1000);
              }
            }
          );
        }
      }
    },
    error: function (responseText) {
      error(responseText);
    },
  });
}

function conoceCodigoProceso() {
  if ($("#infoCodigoProceso").is(":checked")) {
    $("#divCodigoCompleto").css("display", "block");
    $("#divJuzgados").css("display", "none");
  } else {
    $("#divCodigoCompleto").css("display", "none");
    $("#divJuzgados").css("display", "block");
  }
}

function mediosControl(idMedioSeleccionado) {
  var ruta = base_url + "/" + "proceso-judic/mediosControl";

  var parametros = {
    idMedioSeleccionado: idMedioSeleccionado,
  };

  $.ajax({
    data: parametros,
    url: ruta,
    type: "post",
    success: function (responseText) {
      $("#resultadoMedioControl").html(responseText);
      $(".select2").select2({ width: "100%" });
    },
    error: function (responseText) {
      error(responseText);
    },
  });
}

function cambiarVigenciaProceso(vigencia) {
  var ruta = base_url + "/" + "proceso-judic/cambiarVigenciaProceso";

  var parametros = {
    vigencia: vigencia,
  };

  $.ajax({
    data: parametros,
    url: ruta,
    type: "post",
    success: function (responseText) {
      $("#resultadoProcesos").html(responseText);
      $(".select2").select2({ width: "100%" });
    },
    error: function (responseText) {
      error(responseText);
    },
  });
}

function iniciarDropzoneRadica() {
  var ruta = base_url + "/" + "proceso-judic/iniciarDropzoneRadica";

  var rutaArchivoRadica =
    base_url + "/" + "proceso-judic/uploadArchivoRadicacion";

  $.ajax({
    url: ruta,
    type: "post",
    success: function (responseText) {
      $("#resultadoArchivoRadica").html(responseText);
      Dropzone.autoDiscover = false;
      var myDropzonePostRadica = new Dropzone("#dropzoneRadicarProcesoJudi", {
        autoProcessQueue: false,
        url: rutaArchivoRadica,
        addRemoveLinks: true,
        maxFiles: 10,
        parallelUploads: 10,
        init: function () {
          // Update selector to match your button
          this.on("sending", function (file, xhr, formData) {
            var vigenciaRadicado = $("#vigenciaRadicadoIni").val();
            var idRadicado = $("#idRadicadoIni").val();
            // Append all form inputs to the formData Dropzone will POST
            var data = $("#dropzoneRadicarProcesoJudi").serializeArray();
            formData.append("vigenciaRadicado", vigenciaRadicado);
            formData.append("idRadicado", idRadicado);
          });
        },
        queuecomplete: function (file) {
          var vigenciaRadicado = $("#vigenciaRadicadoIni").val();
          var idRadicado = $("#idRadicadoIni").val();
          var idTipoProceso = $("#idTipoProceso").val();

          swal(
            {
              title: "Radicado: " + vigenciaRadicado + "-" + idRadicado,
              text: "Seleccione una de las opciones",
              type: "success",
              showCancelButton: true,
              confirmButtonColor: "#23b5e6",
              confirmButtonText: "Generar el Rótulo de Carpeta",
              cancelButtonText: "Radicar un nuevo proceso",
              closeOnConfirm: true,
              closeOnCancel: true,
            },
            function (isConfirm) {
              if (isConfirm) {
                generarCaratula(vigenciaRadicado, idRadicado);
              } else {
                var rutaRedirect =
                  base_url + "/" + "proceso-judic/index/" + idTipoProceso;
                setTimeout(function () {
                  window.location.href = rutaRedirect;
                }, 1000);
              }
            }
          );
        },
        error: function (file, message) {
          var vigenciaRadicado = $("#vigenciaRadicadoIni").val();
          var idRadicado = $("#idRadicadoIni").val();
          var idTipoProceso = $("#idTipoProceso").val();

          swal(
            {
              title:
                "Ocurrio un Error con los archivos contacte al administrador!",
              text: "Radicado: " + vigenciaRadicado + "-" + idRadicado,
              type: "error",
            },
            function () {
              var rutaRedirect =
                base_url + "/" + "proceso-judic/index/" + idTipoProceso;
              setTimeout(function () {
                window.location.href = rutaRedirect;
              }, 1000);
            }
          );
        },
      });
    },
    error: function (responseText) {
      error(responseText);
    },
  });
}

function nuevaEntidadExt() {
  $("#modalAgregarEntidadExt").modal({
    show: true,
    keyboard: false,
    backdrop: "static",
  });

  var ruta = base_url + "/" + "proceso-judic/nuevaEntidadExt";

  $.ajax({
    url: ruta,
    type: "post",
    success: function (responseText) {
      $("#resultadoAgregarEntidadExt").html(responseText);
    },
    error: function (responseText) {
      error(responseText);
    },
  });
}

function validarGuardarEntidadExt() {
  var nombreEntidadExterno = $("#nombreEntidadExterno").val();
  var direccionEntidadExterno = $("#direccionEntidadExterno").val();
  var telefonoEntidadExterno = $("#telefonoEntidadExterno").val();

  if (nombreEntidadExterno == "") {
    swal({
      title: "Campo sin diligenciar!",
      text: "Debe ingresar el nombre del entidad externa",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  var ruta = base_url + "/" + "proceso-judic/validarGuardarEntidadExt";

  var parametros = {
    nombreEntidadExterno: nombreEntidadExterno,
    direccionEntidadExterno: direccionEntidadExterno,
    telefonoEntidadExterno: telefonoEntidadExterno,
  };

  $.ajax({
    data: parametros,
    url: ruta,
    type: "post",
    beforeSend: function () {
      cargaLoader("Guardando entidad externa. Un momento por favor..");
      $(".btn-guardar-entidadExt").html(
        '<span class="fa fa-spinner fa-spin"></span> Procesando...'
      );
      $(".btn-guardar-entidadExt").css({ "pointer-events": "none" });
    },
    success: function (responseText) {
      ocultaLoader();
      if (responseText == 0) {
        // nombre repetido
        swal({
          title: "Atención!",
          text: "La entidad externa ya se encuentra registrado",
          confirmButtonColor: "#f33923",
        });
        $(".btn-guardar-entidadExt").html(
          '<span class="fa fa-save"></span> Guardar'
        );
        $(".btn-guardar-entidadExt").css({ "pointer-events": "auto" });
        return false;
      } else {
        $("#modalAgregarEntidadExt").modal("hide");
        seleccioneEntidadExt(responseText);
        swal(
          "Guardado!",
          "La entidad externa ha sido guardada exitosamente.",
          "success"
        );
      }
    },
    error: function (responseText) {
      error(responseText);
    },
  });
}

function seleccioneEntidadExt(idEntidadExterna) {
  vectorEntidadesExternas.push(idEntidadExterna);
  vectorEntidadesExternas = $.unique(vectorEntidadesExternas);
  var jsonEntidadesExt = JSON.stringify(vectorEntidadesExternas);

  var ruta = base_url + "/" + "proceso-judic/seleccioneEntidadExt";

  var parametros = {
    idEntidadExterna: idEntidadExterna,
    jsonEntidadesExt: jsonEntidadesExt,
  };

  $.ajax({
    data: parametros,
    url: ruta,
    type: "post",
    beforeSend: function () {
      cargaLoader("Seleccionando entidad externa.  Un momento por favor..");
    },
    success: function (responseText) {
      ocultaLoader();
      $("#resultadoEntidadesExtSeleccionados").html(responseText);
    },
    error: function (responseText) {
      error(responseText);
    },
  });
}

function editarEntidadExt(idEntidadExt) {
  $("#modalEditarEntidadExt").modal({
    show: true,
    keyboard: false,
    backdrop: "static",
  });

  var ruta = base_url + "/" + "proceso-judic/editarEntidadExt";

  var parametros = {
    idEntidadExt: idEntidadExt,
  };

  $.ajax({
    data: parametros,
    url: ruta,
    type: "post",
    success: function (responseText) {
      $("#resultadoEditarEntidadExt").html(responseText);
    },
    error: function (responseText) {
      error(responseText);
    },
  });
}

function validarEditarEntidadExt(idEntidadExt) {
  var nombreEntidadExternoEditar = $("#nombreEntidadExternoEditar").val();
  var direccionEntidadExternoEditar = $("#direccionEntidadExternoEditar").val();
  var telefonoEntidadExternoEditar = $("#telefonoEntidadExternoEditar").val();

  if (nombreEntidadExternoEditar == "") {
    swal({
      title: "Campo sin diligenciar!",
      text: "Debe ingresar el nombre de la entidad externa",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  var ruta = base_url + "/" + "proceso-judic/validarEditarEntidadExt";

  var parametros = {
    idEntidadExt: idEntidadExt,
    nombreEntidadExternoEditar: nombreEntidadExternoEditar,
    direccionEntidadExternoEditar: direccionEntidadExternoEditar,
    telefonoEntidadExternoEditar: telefonoEntidadExternoEditar,
  };

  $.ajax({
    data: parametros,
    url: ruta,
    type: "post",
    beforeSend: function () {
      cargaLoader("Modificando entidad externa. Un momento por favor..");
      $(".btn-editar-entidadExt").html(
        '<span class="fa fa-spinner fa-spin"></span> Procesando...'
      );
      $(".btn-editar-entidadExt").css({ "pointer-events": "none" });
    },
    success: function (responseText) {
      ocultaLoader();
      if (responseText == 0) {
        // nombre repetido
        swal({
          title: "Atención!",
          text: "La entidad externa ya se encuentra registrada",
          confirmButtonColor: "#f33923",
        });
        $(".btn-guardar-entidadExt").html(
          '<span class="fa fa-save"></span> Guardar'
        );
        $(".btn-guardar-entidadExt").css({ "pointer-events": "auto" });
        return false;
      } else {
        $("#modalEditarEntidadExt").modal("hide");
        seleccioneEntidadExt(idEntidadExt);
        swal(
          "Modificado!",
          "La entidad externa ha sido modificada exitosamente.",
          "success"
        );
      }
    },
    error: function (responseText) {
      error(responseText);
    },
  });
}

function removerEntidadExt(idEntidadExt) {
  $("div#tablaEntidadesExt_" + idEntidadExt).remove();

  vectorEntidadesExternas = $.grep(vectorEntidadesExternas, function (value) {
    return value != idEntidadExt;
  });
  vectorEntidadesExternas = $.unique(vectorEntidadesExternas);
}

function datosAnterioresConci(idRadicado) {
  var vigenciaProceso = $("#vigenciaProceso").val();

  if (vigenciaProceso == "") {
    swal({
      title: "Campo sin diligenciar!",
      text: "Seleccione la vigencia del proceso",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  var ruta = base_url + "/" + "proceso-judic/datosAnterioresConci";

  var parametros = {
    idRadicado: idRadicado,
    vigenciaProceso: vigenciaProceso,
  };

  $.ajax({
    data: parametros,
    url: ruta,
    type: "post",
    beforeSend: function () {
      cargaLoader("Recuperando datos de conciliación.  Un momento por favor..");
    },
    success: function (responseText) {
      ocultaLoader();
      var proceso = responseText.proceso;
      var demandantes = responseText.demandantes;
      var demandados = responseText.demandados;
      var entidadesExt = responseText.entidadesExt;
      var abogadosExt = responseText.abogadosExt;

      temas(proceso[0]["idTema"]);
      mediosControl(proceso[0]["jurimedioscontrol_idMediosControl"]);
      $("#descripcionHechos").val(proceso[0]["descripcionHechos"]);

      for (var i = 0; i < demandantes.length; i++) {
        seleccioneDemandante(demandantes[i]["solicitantes_idSolicitante"]);
      }

      for (var i = 0; i < demandados.length; i++) {
        seleccioneDemandado(demandados[i]["dependencias_idDependencia"]);
      }

      for (var i = 0; i < entidadesExt.length; i++) {
        seleccioneEntidadExt(
          entidadesExt[i]["juriconvocadosexternos_idConvocadoExterno"]
        );
      }

      for (var i = 0; i < abogadosExt.length; i++) {
        seleccioneAbogado(abogadosExt[i]["juriabogados_idAbogado"]);
      }
    },
    error: function (responseText) {
      error(responseText);
    },
  });
}

function seleccionUnidadMonetaria(unidadMonetaria) {
  $("#valor").val("");
  $("#valorSalarios").val("");
  $("#valorPesos").val("");

  if (unidadMonetaria == 1) {
    // salarios mínimos
    $("#divSalariosMinimos").css("display", "block");
    $("#divValores").css("display", "block");
    $("#divPesos").css("display", "none");
  } else if (unidadMonetaria == 2) {
    // pesos
    $("#divPesos").css("display", "block");
    $("#divValores").css("display", "block");
    $("#divSalariosMinimos").css("display", "none");
  } // ninguna
  else {
    $("#divPesos").css("display", "none");
    $("#divSalariosMinimos").css("display", "none");
    $("#divValores").css("display", "none");
  }
}

function format(input) {
  var num = input.value.replace(/\./g, "");
  if (!isNaN(num)) {
    num = num
      .toString()
      .split("")
      .reverse()
      .join("")
      .replace(/(?=\d*\.?)(\d{3})/g, "$1.");
    num = num.split("").reverse().join("").replace(/^[\.]/, "");
    input.value = num;
  } else {
    swal({
      title: "Atención!",
      text: "Sólo se permiten números",
      confirmButtonColor: "#f33923",
    });
    input.value = input.value.replace(/[^\d\.]*/g, "");
  }
}

function justNumbers(e) {
  var keynum = window.event ? window.event.keyCode : e.which;
  if (keynum == 8 || keynum == 46) return true;

  return /\d/.test(String.fromCharCode(keynum));
}

function copiar() {
  var valor = document.getElementById("valor").value;
  if (document.getElementById("valor").value != "") {
    document.getElementById("valorPesos").value = "$ " + valor;
  }
}

function salarioAPesos(input) {
  if (document.getElementById("valorSalarios").value != "") {
    var slv = $("#slv").val(); //salario legal vigente
    valorSalarios = document
      .getElementById("valorSalarios")
      .value.replace(".", "");
    var total = slv * valorSalarios;
    total = total.toLocaleString();
    document.getElementById("valorPesos").value = "$ " + total;
  }
}

function validarAgregarCuantia() {
  $(".no-records-found").remove();
  var selectUnidadMonetaria = $("#selectUnidadMonetaria").val(); // 1 salarios - 2 en pesos
  var valor = $("#valor").val(); // valor en pesos
  var valorSalarios = $("#valorSalarios").val(); // # de salarios
  var valorPesos = $("#valorPesos").val(); // valor que cálcula en pesos o salrios readonly
  var valorUnidadMonetaria = ""; // la cantidad de salarios o el valor en pesos

  var unidadMonetaria = "";
  var valorSeleccionado = "";
  valorPesos = valorPesos.replace("$", "");

  if (selectUnidadMonetaria == 0) {
    swal({
      title: "Campo sin diligenciar!",
      text: "Seleccione la unidad monetaria",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  if (selectUnidadMonetaria == 1) {
    // SALARIOS MÍNIMOS
    unidadMonetaria = "Salaraios Mínimos";
    valorSeleccionado = valorSalarios;

    if (valorSalarios == "") {
      swal({
        title: "Campo sin diligenciar!",
        text: "Ingresar el número de salarios",
        confirmButtonColor: "#f33923",
      });
      return false;
    } else {
      valorUnidadMonetaria = valorSalarios;
    }
  }

  if (selectUnidadMonetaria == 2) {
    // VALOR EN PESOS
    unidadMonetaria = "Valor en pesos";
    valorSeleccionado = valor;

    if (valor == "") {
      swal({
        title: "Campo sin diligenciar!",
        text: "Ingresar el valor en pesos",
        confirmButtonColor: "#f33923",
      });
      return false;
    } else {
      valorUnidadMonetaria = valor;
    }
  }

  var tds = $("#tablaCuantias tr:first th").length;

  // Obtenemos el total de columnas (tr) del id "tabla"
  var trs = $("#tablaCuantias tr").length;
  var nuevaFila = "<tr>";

  nuevaFila += "<td>" + unidadMonetaria + "</td>";
  nuevaFila += '<td style="display:none;">' + selectUnidadMonetaria + "</td>";
  nuevaFila += "<td>" + valorSeleccionado + "</td>";
  nuevaFila += "<td>" + valorPesos + "</td>";
  nuevaFila +=
    '<td style="padding:0;"><button type="button" onclick="quitarFilaCuantia($(this));"><i class="fa fa-trash"></i></button></td>';

  nuevaFila += "</tr>";
  $("#tablaCuantias").append(nuevaFila);

  $("#valor").val(""); // valor en pesos
  $("#valorSalarios").val(""); // # de salarios
}

function quitarFilaCuantia(row) {
  row.closest("tr").remove();
  var nFilas = $("#tablaCuantias tr").length;
}

function mantenerMask() {
  var maskJuzgado = $("#codigoProceso").val();
  $("#maskHidden").val(maskJuzgado);
}

function keepMask() {
  var codigoProceso = 23;
  var caracter = "";
  var maskHidden = $("#maskHidden").val();
  maskHiddenR = maskHidden.replace(/X|-/g, "");
  var faltantes = codigoProceso - maskHiddenR.length;
  if (maskHiddenR.length > 0) {
    for (var i = 0; i < faltantes; i++) {
      caracter += "0";
    }
  }
  $("#codigoProceso").val(maskHiddenR + caracter);
}
