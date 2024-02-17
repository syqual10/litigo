@extends('layouts.master')
@section('contenido')
<style>
  table{
    width: 100%;
  }
  table thead tr th select{
    width: 100%;
    display: block;
  }
</style>
<div id="ribbon">
    <span class="ribbon-button-alignment"> 
        <a href="{{ asset('home') }}">
            <span id="refresh" class="btn btn-ribbon" rel="tooltip" data-placement="bottom" data-original-title="Ir al inicio" data-html="true">
                <i class="fa fa-home"></i>
            </span> 
        </a>
    </span>
    <ol class="breadcrumb">
        <li>Inicio</li><li>Administración</li><li>Juzgados</li>
    </ol>
</div>

<div id="content">      
    <section id="widget-grid" class="">
        <div class="row">
            <article class="col-sm-12">
                <div class="jarviswidget jarviswidget-color-blue" role="widget">                    
                    <header role="heading">
                        <h2>Administración <strong><i>de Juzgados</i></strong></h2>  
                    </header>
                        <div class="widget-body">                                 
                            <div id="resultadoTablaJuzgados" class="cont-ajax">
                            

                            <div class="fresh-table full-screen-table toolbar-color-blue">
                                <div style="margin: 10px 0px;">
                                    <button id="alertBtn" class="btn btn-default" onclick="agregarJuzgado();">Agregar un juzgado</button>
                                </div>
                                <table class="table tabla-fresh">
                                    <thead>
                                        <tr style="color: black;">
                                            <th style="color: black;">JURISDICCIÓN</th>
                                            <th style="color: black;">DISTRITO</th>
                                            <th style="color: black;">CIRCUITO</th>
                                            <th style="color: black;">DEPARTAMENTO</th>
                                            <th style="color: black;">MUNICIPIO</th>
                                            <th style="color: black;">CÓDIGO/U</th>
                                            <th style="color: black;">NOMBRE</th>
                                            <th style="color: black;">ESTADO</th>
                                            <th style="color: black;"></th>
                                            <th style="color: black;"></th>
                                        </tr>
                                        <tr style="color: black;">
                                            <th style="color: black;">
                                              <select id="filtro_jurisdiccion" class="select2" onChange="filtroActualizar()">
                                                <option value="all">Todos</option>
                                                @foreach($jurisdiccion as $juris)
                                                  <option value="{{$juris->jurisdiccionJuzgado}}">{{$juris->jurisdiccionJuzgado}}</option>
                                                @endforeach
                                              </select>
                                            </th>
                                            <th style="color: black;">
                                              <select id="filtro_distrito" class="select2" onChange="filtroActualizar()">
                                                <option value="all">Todos</option>
                                                @foreach($distrito as $distri)
                                                  <option value="{{$distri->distritoJuzgado}}">{{$distri->distritoJuzgado}}</option>
                                                @endforeach
                                              </select>
                                            </th>
                                            <th style="color: black;">
                                              <select id="filtro_circuito" class="select2" onChange="filtroActualizar()">
                                                <option value="all">Todos</option>
                                                @foreach($circuito as $circui)
                                                  <option value="{{$circui->circuitoJuzgado}}">{{$circui->circuitoJuzgado}}</option>
                                                @endforeach
                                              </select>
                                            </th>
                                            <th style="color: black;">
                                              <select id="filtro_departamento" class="select2" onChange="filtroActualizar()">
                                                <option value="all">Todos</option>
                                                @foreach($departamentos as $departamento)
                                                  <option value="{{$departamento->departamentoJuzgado}}">{{$departamento->departamentoJuzgado}}</option>
                                                @endforeach
                                              </select>
                                            </th>
                                            <th style="color: black;">
                                              <select id="filtro_municipio" class="select2" onChange="filtroActualizar()">
                                                  <option value="all">Todos</option>
                                                  @foreach($ciudad as $ciuda)
                                                    <option value="{{$ciuda->municipioJuzgado}}">{{$ciuda->municipioJuzgado}}</option>
                                                  @endforeach
                                              </select>
                                            </th>
                                            <th style="color: black;">
                                              <input type="text" id="filtro_codigo" name="filtro_codigo" placeholder="Buscar por código" class="form-control" style="border-color: black;color: black;" onChange="filtroActualizar()">
                                            </th>
                                            <th style="color: black;">
                                              <input type="text" id="filtro_nombre" name="filtro_nombre" placeholder="Buscar por nombre" class="form-control" style="border-color: black;color: black;" onChange="filtroActualizar()">
                                            </th>
                                            <th style="color: black;">
                                              <select id="filtro_estado" class="select2" onChange="filtroActualizar()">
                                                <option value="all">Todos</option>
                                                <option value="1">Activo</option> 
                                                <option value="0">Desactivado</option>
                                              </select>
                                            </th>
                                            <th style="color: black;"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="response">

                                    </tbody>
                                  </table>
                              </div>
                            </div>
                        </div>
                </div>
            </article>
        </div>
    </section>
</div>

<div class="modal fade"  id="modalAgregarJuzgado"  role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title" id="myModalLabel">Agregar Juzgado</h5>
            </div>
            <div id="resultadoAgregarJuzgado">
              <!-- CONTENIDO AJAX -->
              <div class="modal-body">
                <div class="row" style="margin-bottom: 15px;" >
                  <div class="form-wrap">
                    <div class="form-group">
                      <div class="col-sm-3">
                        <label class="control-label pull-right">Usuario:</label>
                      </div>
                      <div class="col-sm-6">
                        {{ 
                                Form::select('selectUsuario', $listaUsuarios, null, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectUsuario', 'style' => 'margin-bottom:8px;'])
                            }}
                      </div>
                    </div>
                  </div>
                </div>
              
                <div class="row" style="margin-bottom: 15px;" >
                  <div class="form-wrap">
                    <div class="form-group">
                      <div class="col-sm-3">
                        <label class="control-label pull-right">Rol:</label>
                      </div>
                      <div class="col-sm-6">
                        {{ 
                                Form::select('selectRol', $listaRoles, null, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectRol', 'style' => 'margin-bottom:8px;'])
                            }}
                      </div>
                    </div>
                  </div>
                </div>
              
                <div class="row" style="margin-bottom: 15px;" >
                  <div class="form-wrap">
                    <div class="form-group">
                      <div class="col-sm-3">
                        <label class="control-label pull-right">Perfil:</label>
                      </div>
                      <div class="col-sm-6">
                        {{ 
                                Form::select('selectPerfil', $listaPerfiles, null, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectPerfil', 'style' => 'margin-bottom:8px;'])
                            }}
                      </div>
                    </div>
                  </div>
                </div>
              
              
                <div class="row" style="margin-bottom: 15px;" >
                  <div class="form-wrap">
                    <div class="form-group">
                      <div class="col-sm-3">
                        <label class="control-label pull-right">Punto de atención:</label>
                      </div>
                      <div class="col-sm-6">
                        {{ 
                                Form::select('selectPunto', $listaPuntosAtencion, null, ['placeholder' => 'Seleccione', 'class' => 'form-control', 'class' => 'select2', 'id'=>'selectPunto', 'style' => 'margin-bottom:8px;'])
                            }}
                      </div>
                    </div>
                  </div>
                </div>
              
                <div class="row" style="margin-bottom: 15px;" >
                  <div class="form-wrap">
                    <div class="form-group">
                      <div class="col-sm-3">
                        <label class="control-label pull-right">Generar oficios:</label>
                      </div>
                      <div class="col-sm-6">
                        <select class="form-control" id="selectOficios">
                          <option value="0">No se le permite generar oficios</option>
                          <option value="1">Sí se le permite generar oficios</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
              
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                  <button class="btn btn-success btn-guardar-juzgado"><i class="icon-rocket"></i> <a id="eventUrl" style="color:#fff; text-decoration:none;" onclick="validarGuardarJuzgado();">Guardar</a></button>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade"  id="modalEditarJuzgado"  role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">                
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title" id="myLargeModalLabel">Editar Juzgado</h5>
            </div>
            <div id="resultadoEditarJuzgado">

            </div>
        </div>
    </div>
</div>

<div class="modal fade"  id="modalAgregarInternos" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title" id="myModalLabel">Agregar resposanbles internos</h5>
            </div>
            <div id="resultadoAgregarInternos">
              
            </div>
        </div>
    </div>
</div>

@endsection
@section('scriptsFin')
<script type="text/javascript">
    $(window).on('load', function() { 
      tablaJuzgados();
    });


var inicio = 0;
var limite = 20;

function filtroActualizar(){
  inicio = 0;
  limite = 20;
  tablaJuzgados(true)
}

function tablaJuzgados(retornar){

  var filtro_jurisdiccion = $('#filtro_jurisdiccion').val();
  var filtro_distrito = $('#filtro_distrito').val();
  var filtro_circuito = $('#filtro_circuito').val();
  var filtro_departamento = $('#filtro_departamento').val();
  var filtro_municipio = $('#filtro_municipio').val();
  var filtro_estado = $('#filtro_estado').val();  
  var filtro_codigo = $('#filtro_codigo').val();  
  var filtro_nombre = $('#filtro_nombre').val();  

  var ruta = "{{URL::to('juzgados/tabla')}}";

  $.ajax({                
    url:  ruta,
    data: {
      inicio : inicio,
      limite : limite,
      filtro_jurisdiccion,
      filtro_distrito,
      filtro_circuito,
      filtro_departamento,
      filtro_municipio,
      filtro_estado,
      filtro_codigo,
      filtro_nombre
    },
    type:  'post',
    beforeSend: function(){      
      cargaLoader('Consultando los juzgados.  Un momento por favor..');
    },
    success:  function (responseText) {
      inicio+=limite;
      ocultaLoader();
      if(retornar){
        $("#response").html(responseText);
      } else{
        $("#response").append(responseText);
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
  

$(window).scroll(function() {
	if($(window).scrollTop() + $(window).height() == $(document).height()){
		tablaJuzgados();
	}
});	


function agregarJuzgado()
{
  $('#modalAgregarJuzgado').modal('show');

  var ruta = base_url +'/'+ 'juzgados/create';

  $.ajax({                
    url:   ruta,
    type:  'post',
    beforeSend: function(){      
      cargaLoader('Agregar Juzgado.  Un momento por favor..');
    },
    success:  function (responseText) {
      ocultaLoader();
      $("#resultadoAgregarJuzgado").html(responseText);
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

function validarGuardarJuzgado()
{
  var jurisdiccionJuzgado = $("#jurisdiccionJuzgado").val();
  var distrito     = $("#distrito").val();
  var circuito  = $("#circuito").val();
  var departamento = $("#departamento").val();
  var codigo   = $("#codigo").val();
  var nombreJuzgado   = $("#nombreJuzgado").val();
  var correo   = $("#correo").val();
  var direccion   = $("#direccion").val();
  var telefono   = $("#telefono").val();
  var horario   = $("#horario").val();
  var municipio   = $("#municipio").val();
  var area   = $("#area").val();

  if(jurisdiccionJuzgado == ""){
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe seleccionar la Jurisdiccion",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(distrito == ""){
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe seleccionar el Distrito",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(circuito == ""){
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe seleccionar el circuito",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(departamento == ""){
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe seleccionar el departamento",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(codigo == ""){
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe seleccionar el codigo",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(municipio == ""){
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe seleccionar el municipio",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(correo == ""){
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe seleccionar el correo",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(direccion == ""){
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe seleccionar el direccion",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(telefono == ""){
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe seleccionar el telefono",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(horario == ""){
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe seleccionar el horario",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(area == ""){
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe seleccionar el area",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  var ruta = base_url +'/'+ 'juzgados/validarGuardarJuzgado';

  var parametros = {  
    jurisdiccionJuzgado,
    distrito,
    circuito,
    departamento,
    nombreJuzgado,
    codigo,
    correo,
    direccion,
    telefono,
    horario,
    area,
    municipio
  };
  
  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',
    beforeSend: function(){    
      cargaLoader('Guardando el juzgado.  Un momento por favor..');  
      $('#eventUrl').html('<span class="fa fa-spinner fa-spin"></span> Procesando...');
      $('#eventUrl').css({ 'pointer-events': 'none' });
    },
    success:  function (responseText) {
      if(responseText == 1){
        ocultaLoader();
        $('#modalAgregarJuzgado').modal('hide');
        swal("Guardado!", "El juzgado ha sido guardado exitosamente.", "success"); 
        limite = 20;
        inicio = 0;
        tablaJuzgados(true);
      } else{
        ocultaLoader();
        swal("Error!", "Ya existe un juzgado con el codigo ingresado.", "warning"); 
        $('#eventUrl').html('Guardar');
        $('#eventUrl').css({ 'pointer-events': 'fill' });
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

function editarJuzgado(idJuzgado){
  $('#modalEditarJuzgado').modal('show');

  var ruta = base_url +'/'+ 'juzgados/update';

  var parametros = {  
    "idJuzgado" : idJuzgado
  };

  $.ajax({                
    data:  parametros,          
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $("#resultadoEditarJuzgado").html(responseText);
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

function validarEditarJuzgado(idJuzgado)
{
  var jurisdiccionJuzgado = $("#jurisdiccionJuzgado").val();
  var distrito     = $("#distrito").val();
  var circuito  = $("#circuito").val();
  var departamento = $("#departamento").val();
  var codigo   = $("#codigo").val();
  var nombreJuzgado   = $("#nombreJuzgado").val();
  var correo   = $("#correo").val();
  var direccion   = $("#direccion").val();
  var telefono   = $("#telefono").val();
  var horario   = $("#horario").val();
  var municipio   = $("#municipio2").val();
  var area   = $("#area").val();


  if($("#estado").is(':checked')){
    var estado = 1;
  }
  else{
    var estado = 0;
  } 

  if(jurisdiccionJuzgado == ""){
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe seleccionar la Jurisdiccion",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(distrito == ""){
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe seleccionar el Distrito",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(circuito == ""){
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe seleccionar el circuito",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(departamento == ""){
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe seleccionar el departamento",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(codigo == ""){
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe seleccionar el codigo",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(municipio == ""){
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe seleccionar el municipio",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(correo == ""){
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe seleccionar el correo",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(direccion == ""){
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe seleccionar el direccion",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(telefono == ""){
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe seleccionar el telefono",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(horario == ""){
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe seleccionar el horario",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  if(area == ""){
    swal({   
      title: "Campo sin diligenciar!",   
      text: "Debe seleccionar el area",   
      confirmButtonColor: "#f33923",   
    });
    return false;
  }

  var ruta = base_url +'/'+ 'juzgados/validarEditarJuzgado';

  var parametros = {  
    idJuzgado,
    jurisdiccionJuzgado,
    distrito,
    circuito,
    departamento,
    nombreJuzgado,
    codigo,
    correo,
    direccion,
    telefono,
    horario,
    area,
    municipio,
    estado
  };
  
  $.ajax({                
    data:  parametros,                  
    url:   ruta,
    type:  'post',
    beforeSend: function(){   
      cargaLoader('Modificando el juzgado.  Un momento por favor..');   
      $('.btn-editar-juzgado').html('<span class="fa fa-spinner fa-spin"></span> Procesando...');
      $('.btn-editar-juzgado').css({ 'pointer-events': 'none' });
    },
    success:  function (responseText) {
      ocultaLoader();
      $('#modalEditarJuzgado').modal('hide');
      swal("Modificada!", "El juzgado se modificó exitosamente.", "success"); 
      limite = inicio;
      inicio = 0;
      tablaJuzgados(true);
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

function desactivarJuzgado(idJuzgado, estadoJuzgado)
{ 
  if(estadoJuzgado == 0)// desactivar
  {
    swal({   
        title: "Está seguro de desactivar este juzgado?",   
        text: "Se desactivará el juzgado de la base de datos!",   
        type: "warning",   
        showCancelButton: true,   
        confirmButtonColor: "#f8b32d",   
        confirmButtonText: "Sí, desactivarlo!",   
        closeOnConfirm: false 
      }, function(){
        validarEstadoJuzgado(idJuzgado, estadoJuzgado);
      });
    }
    else// activar
    {
      swal({   
        title: "Está seguro de activar el juzgado?",   
        text: "El juzgado se agregará a la base de datos!",   
        type: "warning",   
        showCancelButton: true,   
        confirmButtonColor: "#f8b32d",   
        confirmButtonText: "Sí, activarlo!",   
        closeOnConfirm: false 
      }, function(){
        validarEstadoJuzgado(idJuzgado, estadoJuzgado);
      });
    }
}

function validarEstadoJuzgado(idJuzgado, estadoJuzgado)
{
  limite = inicio;
  inicio = 0;
  var ruta = base_url +'/'+ 'juzgados/executeupdate';

  var parametros = {  
    "idJuzgado" : idJuzgado,
    "estadoJuzgado": estadoJuzgado
  };

  $.ajax({                
    data:  parametros,          
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      if(responseText == 1){
        swal("Desactivado!", "El juzgado ha sido desactivado en la base de datos.", "success"); 
        tablaJuzgados(true);
      }
      else{
        swal("Activado!", "El juzgado ha sido activado en la base de datos.", "success"); 
        tablaJuzgados(true);
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

function ciudades(departamento, input, valor){
  console.log("DEPARTAMENTO", departamento, input, valor)
  var ruta = base_url +'/'+ 'juzgados/ciudades';
  $.ajax({                
    data:  {departamento, input, valor: valor == undefined? "nada": valor},          
    url:   ruta,
    type:  'post',
    success:  function (responseText) {
      $('.'+input).html(responseText)
    }
  });
}
    </script>
@stop