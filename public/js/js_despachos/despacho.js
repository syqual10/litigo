var base_url = $('meta[name="base_url"]').attr("content");
var id_usuario = $('meta[name="id_usuario"]').attr("content");

function despachos() {
  var selectTipoDespacho = $("#selectTipoDespacho").val();
  var fechaDespachado = $("#fechaDespachado").val();

  if (fechaDespachado == "") {
    var fechaDespachado = $("#fechaDespachadoIni").val();
  }

  var ruta = base_url + "/" + "despachado/despachos";

  var parametros = {
    fechaDespachado: fechaDespachado,
    selectTipoDespacho: selectTipoDespacho,
  };

  $.ajax({
    data: parametros,
    url: ruta,
    type: "post",
    beforeSend: function () {
      cargaLoader("Consultando los despachos del día.  Un momento por favor..");
    },
    success: function (responseText) {
      ocultaLoader();
      $("#resultadoDespachos").html(responseText);
      //$('.tabla-fresh').bootstrapTable();
      $("#fresh-table-despacho").DataTable({
        lengthMenu: [[-1], ["Todos"]],
        order: [[6, "asc"]],
      });
    },
    error: function (responseText) {
      switch (responseText.status) {
        case 500:
          console.error("Error " + responseText.status + " " + responseText);
          break;
        case 401:
          swal(
            {
              title: "Su sesión se ha desconectado",
              text: "Por favor loguearse nuevamente!",
              type: "warning",
              confirmButtonColor: "#f8b32d",
              confirmButtonText: "Entendido!",
            },
            function () {
              var rutaRedirect = base_url + "/" + "login";
              window.location.href = rutaRedirect;
            }
          );
          break;
      }
      console.log(responseText);
      return;
    },
  });
}

function pdfDespachados() {
  var fechaDespachado = $("#fechaDespachado").val();
  //$('#framePdf').attr('src','about:blank');
  $("#framePdf")
    .contents()
    .find("body")
    .html(
      '<div style="width:100%; height:100%; background:#fff; text-align:center;"><br></div>'
    );
  $("#f1").submit(function () {
    return false;
  });
  //Checkbox seleccionados
  var values = new Array();
  var valuesID = new Array();
  $(".checkbox input[type=checkbox]:checked").each(function () {
    //cada elemento seleccionado
    values.push($(this).val());
    valuesID.push($(this).attr("id"));
  });

  if (values.length == 0) {
    swal({
      title: "Campo sin diligenciar!",
      text: "No ha seleccionado ninguna fila",
      confirmButtonColor: "#f33923",
    });
    return false;
  }

  var jsonSeleccionados = JSON.stringify(values);
  var jsonSeleccionadosIDS = JSON.stringify(valuesID);

  //----------------------
  //Carga el pdf generado
  //Lanza la modal
  $("#modalPdfGenerado").modal("show");

  //Carga el pdf en el iframe
  var ruta = base_url + "/" + "despachado/pdf/" + fechaDespachado + "/";
  document.getElementById("framePdf").src =
    ruta + jsonSeleccionados + "/" + jsonSeleccionadosIDS;
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
