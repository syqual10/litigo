var base_url = $('meta[name="base_url"]').attr("content");
var id_usuario = $('meta[name="id_usuario"]').attr("content");

$(document).on("click", ".applyBtn", function () {
  /*
    1 Tipos de procesos
    2 Acciones
    3 Usuarios
    4 Estados radicados
    5 Abogados demandantes
    6 Demandantes
    7 Juzgados
    8 Secretaría
    9 Por tipo de actuación
  */
  var reporte = $("#reporte").val();

  /*
    Para el reporte tipo 1
  */
  var selectMedioControl = $("#selectMedioControl").val();

  /*
    Para el reporte tipo 2
  */
  var selectAccion = $("#selectAccion").val();

  /*
    Para el reporte tipo 3
  */
  var selectUsuario = $("#selectUsuario").val();

  /*
    Para el reporte tipo 4
  */
  var selectEstadoRadicado = $("#selectEstadoRadicado").val();
  var selectTipoProceso = $("#selectTipoProceso").val();
  /*
    Para el reporte tipo 5
  */
  var selectAbogadoDemandante = $("#selectAbogadoDemandante").val();

  /*
    Para el reporte tipo 6
  */
  var documentoDemandante = $("#documentoDemandante").val();

  /*
    Para el reporte tipo 11
  */
  var tema = $("#tema").val();

  var asunto = $("#asunto").val();


  if (reporte == 6 && documentoDemandante == "") {
    swal({
      title: "Atención!",
      text: "Debe ingresar el documento del demandante para la búsqueda",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  if (reporte == 5 && selectAbogadoDemandante == "") {
    swal({
      title: "Atención!",
      text: "Debe seleccionar el abogado demandante para la búsqueda",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  if (reporte == 11 && tema == "") {
    swal({
      title: "Atención!",
      text: "Debe ingresar el tema para la búsqueda",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  /*
    Para el reporte tipo 7
  */
  var selectJuzgado = $("#selectJuzgado").val();

  /*
    Para el reporte tipo 8
  */
  var selectSecretaria = $("#selectSecretaria").val();

  /*
    Para el reporte tipo 9
  */
  var selectTipoActuacion = $("#selectTipoActuacion").val();

  /*
    Para todos los reportes, rango de fechas
  */
  var rangoFecha = $("#rangoFecha").val();
  rangoFecha = rangoFecha.split("-");

  var ruta = base_url + "/" + "reportes/reporteTabla";
  var loader = '<img src="' + base_url + '/img/loader.gif">';

  var parametros = {
    reporte: reporte,
    selectMedioControl: selectMedioControl,
    selectAccion: selectAccion,
    selectUsuario: selectUsuario,
    selectEstadoRadicado: selectEstadoRadicado,
    selectTipoProceso: selectTipoProceso,
    selectAbogadoDemandante: selectAbogadoDemandante,
    documentoDemandante: documentoDemandante,
    selectJuzgado: selectJuzgado,
    selectSecretaria: selectSecretaria,
    selectTipoActuacion: selectTipoActuacion,
    tema: tema,
    asunto: asunto,
    fechaInicial: rangoFecha[0],
    fechaFinal: rangoFecha[1],
  };

  $.ajax({
    data: parametros,
    url: ruta,
    type: "post",
    beforeSend: function () {
      cargaLoader("Consultando la base de datos.  Un momento por favor..");
    },
    success: function (responseText) {
      ocultaLoader();
      $("#resultadoTablaReporte").html(responseText);
      $(".tabla-fresh").bootstrapTable();
      reporteExcel();
    },
    error: function (responseText) {
      error(responseText);
    },
  });
});

function reporteExcel() {
  /*
    1 Tipos de procesos
    2 Acciones
    3 Usuarios
    4 Estados radicados
    5 Abogados demandantes
    6 Demandantes
    7 Juzgados
    8 Secretaría
    9 Tipo de actuación
  */
  var reporte = $("#reporte").val();

  /*
  Para el reporte tipo 1
  */
  var selectMedioControl = $("#selectMedioControl").val();
  if (selectMedioControl === undefined) {
    selectMedioControl = "";
  }
  /*
  Para el reporte tipo 2
  */
  var selectAccion = $("#selectAccion").val();
  if (selectAccion === undefined) {
    selectAccion = "";
  }
  /*
  Para el reporte tipo 3
  */
  var selectUsuario = $("#selectUsuario").val();
  if (selectUsuario === undefined) {
    selectUsuario = "";
  }
  /*
  Para el reporte tipo 4
  */
  var selectEstadoRadicado = $("#selectEstadoRadicado").val();
  var selectTipoProceso = $("#selectTipoProceso").val();

  if (selectEstadoRadicado === undefined) {
    selectEstadoRadicado = "";
  }

  if (selectTipoProceso === undefined) {
    selectTipoProceso = "";
  }

  /*
  Para el reporte tipo 5
  */
  var selectAbogadoDemandante = $("#selectAbogadoDemandante").val();
  if (selectAbogadoDemandante === undefined) {
    selectAbogadoDemandante = "";
  }

  /*
  Para el reporte tipo 6
  */
  var documentoDemandante = $("#documentoDemandante").val();
  if (documentoDemandante === undefined) {
    documentoDemandante = "";
  }
  /*
  Para el reporte tipo 7
  */
  var selectJuzgado = $("#selectJuzgado").val();
  if (selectJuzgado === undefined) {
    selectJuzgado = "";
  }
  /*
  Para el reporte tipo 8
  */
  var selectSecretaria = $("#selectSecretaria").val();
  if (selectSecretaria === undefined) {
    selectSecretaria = "";
  }
  /*
    Para el reporte tipo 9
  */
  var selectTipoActuacion = $("#selectTipoActuacion").val();
  if (selectTipoActuacion === undefined) {
    selectTipoActuacion = "";
  }

  /*
  Para el reporte tipo 11
  */
  var tema = $("#tema").val();
  if (tema === undefined) {
    tema = "";
  }

  var asunto = $("#asunto").val();
  if (asunto === undefined) {
    asunto = "";
  }


  /*
    Para todos los reportes, rango de fechas
  */
  var fechaInicial = $("#fechaInicialSeleccionada").val();
  var fechaFinal = $("#fechaFinalSeleccionada").val();

  var parametros = {
    reporte: reporte,
    selectMedioControl: selectMedioControl,
    selectAccion: selectAccion,
    selectUsuario: selectUsuario,
    selectEstadoRadicado: selectEstadoRadicado,
    selectTipoProceso: selectTipoProceso,
    selectAbogadoDemandante: selectAbogadoDemandante,
    documentoDemandante: documentoDemandante,
    selectJuzgado: selectJuzgado,
    selectSecretaria: selectSecretaria,
    selectTipoActuacion: selectTipoActuacion,
    tema: tema,
    asunto: asunto,
    fechaInicial: fechaInicial,
    fechaFinal: fechaFinal,
  };

  var vector = JSON.stringify(parametros);
  var rutaRedirect = base_url + "/" + "reportes/reporteExcel";
  window.location.href = rutaRedirect + "/" + vector;
}

function validarDato(dato) {
  if (dato.length == 1 && dato[0] == "" && true) {
    dato = ["0"];
  }
  if (dato.length > 1) {
    dato = dato.filter((x) => x != "");
  }

  return dato;
}

function castDate(date) {
  var splitDate = date.split("/");
  var year = splitDate[2];
  var month = splitDate[0];
  var day = splitDate[1];

  return [year, month, day].join("-");
}

function crearReporteExcel() {
  //Columnas Seleccionadas
  columnasSeleccionadas = [];

  jQuery("#column-right div").each(function () {
    columnasSeleccionadas.push($(this).attr("id"));
  });

  var tipoProceso = $("#selectTipoProceso").val();
  var estadoRadicado = $("#selectEstadoRadicado").val();
  var medioControl = $("#selectMedioControl").val();
  var accion = $("#selectAccion").val();
  var usuario = $("#selectUsuario").val();
  var abogadoDemandante = $("#selectAbogadoDemandante").val();
  var juzgado = $("#selectJuzgado").val();
  var secretaria = $("#selectSecretaria").val();
  var tipoActuacion = $("#selectTipoActuacion").val();
  var falloInstancia = $("#selectFalloInstancia").val();
  var fechaInicial = $("#fechaInicial").val();
  var fechaFinal = $("#fechaFinal").val();

  if (columnasSeleccionadas.length == 0) {
    swal({
      title: "Atención!",
      text: "Debe selecionar al menos una columna para el informe",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  var jsonColumnas = JSON.stringify(columnasSeleccionadas);

  //validaciones
  if (tipoProceso.length > 1) {
    swal({
      title: "Atención!",
      text: "Debe selecionar solo un tipo de proceso",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  if (estadoRadicado.length > 1) {
    swal({
      title: "Atención!",
      text: "Debe selecionar solo un estado del radicado",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  if (medioControl.length == 0) {
    swal({
      title: "Atención!",
      text: "Debe selecionar el estado del radicado",
      confirmButtonColor: "#f33923",
    });
    return false;
  } else {
    medioControl = validarDato(medioControl);
  }

  if (accion.length == 0) {
    swal({
      title: "Atención!",
      text: "Debe selecionar el estado del radicado",
      confirmButtonColor: "#f33923",
    });
    return false;
  } else {
    accion = validarDato(accion);
  }

  if (usuario.length == 0) {
    swal({
      title: "Atención!",
      text: "Debe selecionar el estado del radicado",
      confirmButtonColor: "#f33923",
    });
    return false;
  } else {
    usuario = validarDato(usuario);
  }

  if (abogadoDemandante.length == 0) {
    swal({
      title: "Atención!",
      text: "Debe selecionar el estado del radicado",
      confirmButtonColor: "#f33923",
    });
    return false;
  } else {
    abogadoDemandante = validarDato(abogadoDemandante);
  }

  if (juzgado.length == 0) {
    swal({
      title: "Atención!",
      text: "Debe selecionar el juzgado",
      confirmButtonColor: "#f33923",
    });
    return false;
  } else {
    juzgado = validarDato(juzgado);
  }

  if (abogadoDemandante.length == 0) {
    swal({
      title: "Atención!",
      text: "Debe selecionar el abogado demandante",
      confirmButtonColor: "#f33923",
    });
    return false;
  } else {
    abogadoDemandante = validarDato(abogadoDemandante);
  }

  if (tipoActuacion.length == 0) {
    swal({
      title: "Atención!",
      text: "Debe selecionar el tipo de actuación",
      confirmButtonColor: "#f33923",
    });
    return false;
  } else {
    tipoActuacion = validarDato(tipoActuacion);
  }

  if (falloInstancia.length == 0) {
    swal({
      title: "Atención!",
      text: "Debe selecionar la instancia de fallo",
      confirmButtonColor: "#f33923",
    });
    return false;
  } else {
    falloInstancia = validarDato(falloInstancia);
  }

  if (fechaInicial == "") {
    swal({
      title: "Atención!",
      text: "Seleccione la fecha de inicio",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  if (fechaFinal == "") {
    swal({
      title: "Atención!",
      text: "Seleccione la fecha final",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  var parametros = {
    tipoProceso,
    estadoRadicado,
    medioControl,
    accion,
    usuario,
    abogadoDemandante,
    juzgado,
    secretaria,
    tipoActuacion,
    fechaInicial,
    fechaFinal,
    falloInstancia,
    columnasSeleccionadas,
  };

  var vector = JSON.stringify(parametros);

  var rutaRedirect = base_url + "/" + "reportes/crear-reporte-excel";
  window.location.href = rutaRedirect + "/" + vector;
}

function formularioCrearReportes() {
  var ruta = base_url + "/" + "reportes/formulario-crear-reportes";

  $.ajax({
    data: null,
    url: ruta,
    type: "get",
    beforeSend: function () {
      cargaLoader("Consultando la información.  Un momento por favor..");
    },
    success: function (responseText) {
      ocultaLoader();
      $("#formularioCrearReporte").html(responseText);
      $(".select2").select2({ width: "100%" });

      $("#fechaInicial").pickmeup({
        position: "left",
        hide_on_select: true,
        format: "Y-m-d",
      });

      $("#fechaFinal").pickmeup({
        position: "left",
        hide_on_select: true,
        format: "Y-m-d",
      });

      var columnLeft = document.getElementById("column-left");
      var columnRight = document.getElementById("column-right");

      new Sortable(columnLeft, {
        group: "shared", // set both lists to same group
        animation: 150,
        ghostClass: "blue-background-class",
      });

      new Sortable(columnRight, {
        group: "shared",
        animation: 150,
        ghostClass: "blue-background-class",
      });
    },
    error: function (responseText) {
      error(responseText);
    },
  });
}

function selectAllItems(){
  $('#column-left div').detach().appendTo($("#column-right"));
}