var base_url = $('meta[name="base_url"]').attr("content");
var id_usuario = $('meta[name="id_usuario"]').attr("content");

function tablaTemas() {
  var ruta = base_url + "/" + "temas/tablaTemas";

  var loader = '<img src="' + base_url + '/img/loader.gif">';

  $.ajax({
    url: ruta,
    type: "post",
    beforeSend: function () {
      cargaLoader("Consultando los temas.  Un momento por favor..");
    },
    success: function (responseText) {
      ocultaLoader();
      $("#resultadoTablaTemas").html(responseText);
      $(".tabla-fresh").bootstrapTable();
    },
    error: function (responseText) {
      error(responseText);
    },
  });
}

function agregarTema() {
  $("#modalAgregarTema").modal("show");

  var ruta = base_url + "/" + "temas/agregarTema";

  $.ajax({
    url: ruta,
    type: "post",
    success: function (responseText) {
      $("#resultadoAgregarTema").html(responseText);
    },
    error: function (responseText) {
      error(responseText);
    },
  });
}

function validarGuardarTema() {
  var nombreTema = $("#nombreTema").val();

  if (nombreTema == "") {
    swal({
      title: "Campo sin diligenciar!",
      text: "Debe ingresar el nombre del tema",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  var ruta = base_url + "/" + "temas/validarGuardarTema";

  var parametros = {
    nombreTema: nombreTema,
  };

  $.ajax({
    data: parametros,
    url: ruta,
    type: "post",
    beforeSend: function () {
      cargaLoader("Guardando el tema.  Un momento por favor..");
      $(".btn-guardar-tema").html(
        '<span class="fa fa-spinner fa-spin"></span> Procesando...'
      );
      $(".btn-guardar-tema").css({ "pointer-events": "none" });
    },
    success: function (responseText) {
      ocultaLoader();
      $("#modalAgregarTema").modal("hide");
      tablaTemas();
      swal("Guardado!", "El tema ha sido guardado exitosamente.", "success");
    },
    error: function (responseText) {
      error(responseText);
    },
  });
}

function editarTema(idTema) {
  $("#modalEditarTema").modal("show");

  var ruta = base_url + "/" + "temas/editarTema";

  var parametros = {
    idTema: idTema,
  };

  $.ajax({
    data: parametros,
    url: ruta,
    type: "post",
    success: function (responseText) {
      $("#resultadoEditarTema").html(responseText);
    },
    error: function (responseText) {
      error(responseText);
    },
  });
}

function validarEditarTema(idTema) {
  var nombreTemaEditar = $("#nombreTemaEditar").val();

  if (nombreTemaEditar == "") {
    swal({
      title: "Campo sin diligenciar!",
      text: "Debe ingresar el nombre del tema",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  var ruta = base_url + "/" + "temas/validarEditarTema";

  var parametros = {
    idTema: idTema,
    nombreTemaEditar: nombreTemaEditar,
  };

  $.ajax({
    data: parametros,
    url: ruta,
    type: "post",
    beforeSend: function () {
      cargaLoader("Modificando el tema.  Un momento por favor..");
      $(".btn-editar-tema").html(
        '<span class="fa fa-spinner fa-spin"></span> Procesando...'
      );
      $(".btn-editar-tema").css({ "pointer-events": "none" });
    },
    success: function (responseText) {
      ocultaLoader();
      $("#modalEditarTema").modal("hide");
      swal("Modificado!", "El tema ha sido modificado.", "success");
      tablaTemas();
    },
    error: function (responseText) {
      error(responseText);
    },
  });
}

function eliminarTema(idTema) {
  swal(
    {
      title: "Está seguro de eliminar el tema?",
      text: "Se eliminará el tema de la base de datos!",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#f8b32d",
      confirmButtonText: "Sí, eliminarlo!",
      closeOnConfirm: false,
    },
    function () {
      validarEliminarTema(idTema);
    }
  );
}

function validarEliminarTema(idTema) {
  var ruta = base_url + "/" + "temas/validarEliminarTema";

  var parametros = {
    idTema: idTema,
  };

  $.ajax({
    data: parametros,
    url: ruta,
    type: "post",
    success: function (responseText) {
      if (responseText == 1) {
        swal("Eliminado!", "El tema ha sido eliminado.", "success");
        tablaTemas();
      } else {
        swal({
          title: "No se puede eliminar el tema!",
          text: "El tema es utilizado por al menos un proceso",
          confirmButtonColor: "#f33923",
        });
        return false;
      }
    },
    error: function (responseText) {
      error(responseText);
    },
  });
}

function traerRadicados() {
  var vigencia = $("#vigencia").val();
  var estado = $("#estado").val();
  var condicion = $("#condicion").val();
  var termino = $("#termino").val();

  var ruta = base_url + "/" + "temas/traer-radicados";

  $.ajax({
    data: { vigencia, estado, condicion, termino },
    url: ruta,
    type: "post",
    beforeSend: function () {
      cargaLoader("Consultando procesos.  Un momento por favor..");
    },
    success: function (responseText) {
      ocultaLoader();
      $("#ajax-radicados").html(responseText);
      temas(0);
    },
    error: function (responseText) {
      error(responseText);
    },
  });
}

function marcarTodo() {
  $(".checkbox input[type=checkbox]").each(function () {
    $(this).attr("checked", true);
  });
}

function desmarcarTodo() {
  $(".checkbox input[type=checkbox]").each(function () {
    $(this).attr("checked", false);
  });
}

function establecerTemaMasivo() {
  var selectTema = $("#selectTema").val();

  if (selectTema == "") {
    swal({
      title: "Seleccione el tema",
      text: "Vaya al paso 1 y seleccione el tema que se va a establecer en los procesos",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  $("#f1").submit(function () {
    return false;
  });
  //Checkbox seleccionados
  var values = new Array();

  $(".checkbox input[type=checkbox]:checked").each(function () {
    //cada elemento seleccionado
    values.push($(this).val());
  });

  if (values.length == 0) {
    swal({
      title: "No ha seleccionado ninguna fila!",
      text: "Seleccione al menos uno de los procesos haciendo clic en el selector ubicado en la última columna de cada fila.",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  var jsonSeleccionados = JSON.stringify(values);

  var ruta = base_url + "/temas/establecer-tema-masivo";

  console.log(selectTema, jsonSeleccionados);

  $.ajax({
    data: { selectTema, jsonSeleccionados },
    url: ruta,
    type: "post",
    beforeSend: function () {
      cargaLoader("Guardando tema.  Un momento por favor..");
    },
    success: function (responseText) {
      ocultaLoader();
      traerRadicados();
    },
    error: function (responseText) {
      error(responseText);
    },
  });
}
