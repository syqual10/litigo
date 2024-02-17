@extends('layouts.master')

@section('contenido')
<?php 
$imagen = asset('img/loader.gif');
?>
<style type="text/css">
#iframeAgenda {
       background: url({{$imagen}}) top center no-repeat;
    }
</style>
<!-- RIBBON -->
<input type="hidden" value="{{$idResponsable}}" id="idResponsable">
<input type="hidden" value="{{$agendaSesion[0]->nombresUsuario}}" id="nombreSesion">
<div id="ribbon">
    <span class="ribbon-button-alignment"> 
        <a href="{{ asset('home') }}">
            <span id="refresh" class="btn btn-ribbon" rel="tooltip" data-placement="bottom" data-original-title="Ir al inicio" data-html="true">
                <i class="fa fa-home"></i>
            </span> 
        </a>
    </span>
    <!-- breadcrumb -->
    <ol class="breadcrumb">
        <li>Inicio</li><li>Agenda</li><li>Funcionario</li>
    </ol>
    <!-- end breadcrumb -->
</div>
<!-- END RIBBON -->


<!-- MAIN CONTENT -->
<div id="content">    
    <div class="row">
        <div class="col-md-9 align-self-center">
            @if ($responsable == 1)
                <div class="btn-group">
                    <button class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                    <strong>Seleccione un Funcionario</strong> <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        @foreach($agendasUsuario as $usuarioAgenda)
                            <li>
                                <a href="#" onclick="agendaUsuario('{{$usuarioAgenda->idResponsable}}', '{{$usuarioAgenda->nombresUsuario}}')">{{$usuarioAgenda->nombresUsuario}}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <a href="javascript:void(0);" class="btn btn-labeled btn-danger" onclick="agendaUsuarios();"> 
                    <span class="btn-label"><i class="fa fa-file-pdf-o"></i></span>Imprimir Agenda
                </a>        
            @endif
        </div>  
    </div>
    <!-- widget grid -->
    <div class="row" style="margin-top:10px">
        <section id="widget-grid">
            <!-- row -->
            <div class="row">
                <!-- NEW WIDGET START -->
                <article class="col-sm-12">
                    <div class="jarviswidget jarviswidget-color-blue" role="widget">
                        <!-- widget div-->
                        <div role="content">
                            <!-- widget content -->
                            <div class="widget-body">
                                <!-- widget content -->
                                <iframe name="contentFrame1" id="iframeAgenda" width="100%" height="1800" scrolling="yes" marginheight="	0" marginwidth="0" frameborder="0">
                                    <p>Su navegador no soporta iframes</p>
                                </iframe>
                                <!-- end widget -->
                            </div>
                            <!-- end widget content -->
                        </div>
                        <!-- end widget div -->
                    </div>
                    <!-- end widget -->
                </article>
                <!-- WIDGET END -->
            </div>
            <!-- end row -->


        </section>
    </div>
    <!-- end widget grid -->
</div>
<!-- END MAIN CONTENT -->

<!-- EXPORTAR AGENDA-->
<div class="modal fade"  id="modalExportarAgenda" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width:90%">
        <div class="modal-content">
            <div class="modal-header" style="padding: 5px 29px;background:#21c2f8;color:#fff">
                <div class="row">
                    <div class="col-sm-9">
                        <h4 class="modal-title pull-left" id="myLargeModalLabelCuantia"><i class="fa fa-file-pdf-o"></i> Generar PDF - Agenda</h4>
                    </div>
                    <div class="col-sm-3">
                        <a href="#" type="button" class="close pull-right" data-dismiss="modal" aria-hidden="true" style="margin-top:3px">X</a>
                    </div>
                </div>                
            </div>
            <div class="modal-body" style="padding:0px;">  
                <iframe id="framePdfAgenda" style="width: 100%;height: 100vh;"></iframe>  
            </div>
        </div>
    </div>
</div>
<!-- # EXPORTAR AGENDA-->

<!-- MODAL OPCIONES EXPORTAR AGENDA-->
<div class="modal fade"  id="modalUsuariosAgenda" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title" id="myLargeModalLabel">Exportar Agenda</h5>
            </div>
            <div id="resultadoExportarAgenda">
                <!-- CONTENIDO AJAX -->
            </div>
        </div>
    </div>
</div>
<!-- # MODAL OPCIONES EXPORTAR AGENDA-->

@endsection
@section('scriptsFin')
    <script type="text/javascript">
        $(window).on('load', function() { 
          agendaUsuario();
        });

	    function agendaUsuario(idResponsableParametro, nombreParametro)
		{
          if(idResponsableParametro === undefined)
          {
            var idResponsable = $("#idResponsable").val();
            var nombre = $("#nombreSesion").val();;
          }
          else
          {
            var idResponsable = idResponsableParametro;
            var nombre = nombreParametro;
          }
		  //Carga la agenda en el iframe
		  var rutaRedirect = "<?php echo URL::to('agendaUsuario/'); ?>";
		  document.getElementById("iframeAgenda").src = rutaRedirect +"/"+ idResponsable+"/"+ nombre;
		}


        function agendaUsuarios()
        {
            $('#modalUsuariosAgenda').modal('show');

            var ruta = base_url +'/'+ 'agenda/agendaUsuarios';

            $.ajax({
                url:   ruta,
                type:  'post',
                beforeSend: function(){
                  cargaLoader('Un momento por favor..');
                },
                success:  function (responseText) {
                  ocultaLoader();
                  $("#resultadoExportarAgenda").html(responseText);
                  $(".select2").select2({ width: '100%' });
                         $('.input-daterange-datepicker').daterangepicker({
            buttonClasses: ['btn', 'btn-sm'],
            applyClass: 'btn-info',
            cancelClass: 'btn-default',
            locale: {
                format: 'YYYY/MM/DD' // --------Here
            },
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

        $(document).on('click', '.applyBtn', function () 
        {
            $('#modalUsuariosAgenda').modal('hide');

            var selectExportarAgenda = $("#selectExportarAgenda").val();
            if(selectExportarAgenda == '')
            {
                selectExportarAgenda = 0;
            }

            var rangoFecha = $("#rangoFecha").val();
            var rangoDate = rangoFecha.replace(/[\/_]/g, '.');

            $('#modalExportarAgenda').modal(
                {
                 show: true,
                 keyboard: false,
                 backdrop: 'static'
                }
            ); 
            var rutaRedirect = base_url +'/'+ 'agenda/exportarAgenda';
            document.getElementById("framePdfAgenda").src = rutaRedirect +"/"+ selectExportarAgenda+"/"+ rangoDate;
        });
    </script>
    </script>
@stop