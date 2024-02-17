<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="dominio" content="{{Config::get('app.NODE_DOMINIO')}}">
    <meta name="puerto" content="{{Config::get('app.NODE_PUERTO')}}">
    <!-- Favicon icon -->
    <link rel="icon" href="{{ asset('favicon.png') }}">
    <title>.: Agenda SyQual 10 :.</title>
    <!-- Bootstrap Core CSS -->
    <link href="{{asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">    
    <!-- FullCalendar -->
    <link href="{{asset('assets/plugins/calendar/dist/fullcalendar.css')}}" rel='stylesheet' />
    <!-- toast CSS -->
    <link href="{{asset('assets/plugins/toast-master/css/jquery.toast.css')}}" rel="stylesheet">
    <!--alerts CSS -->
    <link href="{{asset('assets/plugins/sweetalert/sweetalert-v3.css')}}" rel="stylesheet" type="text/css">
    <!-- Custom CSS -->
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="{{asset('css/colors/blue.css')}}" id="theme" rel="stylesheet">
    <link href="{{ asset('assets/plugins/switchery/dist/switchery.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/chosen.css') }}" rel="stylesheet">
    <style type="text/css">
    .numqueja{
        background: #fff;
        color: #000;
        font-weight: bold;
        border-radius: 5px;
        padding: 0px 3px;
        font-size: 0.85em;
    }
    .pull-right{
        float:right !important;
    }
    .sweet-alert{
        top:15% !important;
    }    
    </style>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <div class="row">
            <input type="hidden" id="selectUsuarioAgenda" value="{{$idResponsable}}">
            <div class="col-md-12">
                <h4 class="card-title m-t-10">{{$nombreFuncionario}}</h4>
                <hr>
                <div id="calendar"></div>
            </div>
        </div>
        <!-- BEGIN MODAL -->
        <!-- Modal -->
        <div class="modal fade none-border" id="modalAgenda"  role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document" style="width:60%;">
                <div class="modal-content">           
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>                        
                        <h5 class="modal-title" id="myModalLabel">Programación de eventos</h5>                        
                    </div>
                    <!-- resultadoAgenda -->
                    <div id="resultadoAgenda">
                        <!-- CARGA AJAX -->
                    </div>
                    <!-- #resultadoAgenda -->
                </div>
            </div>
        </div>

        <div id="modalOpcionesAgenda" class="modal fade">
            <div class="modal-dialog modal-lg" style="width:60%;">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> <span class="sr-only">Cerrar</span></button>                        
                        <h5 id="modalTitle" class="modal-title"></h5>                        
                    </div>
                    <div id="modalBody" class="modal-body">
                        <input type="hidden" id="idAgendaOpciones" >
                        <div id="descripcion"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-danger" onclick="borrarAgenda();">Eliminar</button>
                        <button type="button" class="btn btn-warning" onclick="mostrarEditarAgenda();">Modificar</button>
                        <div id="divVerOpcionesAgenda">
                            <button class="btn btn-success"><a id="eventUrl" target="_blank" style="color:#fff; text-decoration:none;">Ver este proceso</a></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
    </div>
    <!-- START PRELOADS -->
    <audio id="audio-alert" src="{{asset('audio/alert.mp3')}}" preload="auto"></audio>
    <audio id="audio-fail" src="{{asset('audio/fail.mp3')}}" preload="auto"></audio>
    <script type="text/javascript">
    /* PLAY SOUND FUNCTION */
    function playAudio(file){
        if(file === 'alert')
            document.getElementById('audio-alert').play();

        if(file === 'fail')
            document.getElementById('audio-fail').play();    
    }
    </script>

    <!-- Calendar JavaScript -->
    <!-- jQuery Version 1.11.1 -->
    <script src="{{asset('assets/plugins/jquery/jquery.js')}}"></script>
    <script src="{{asset('assets/plugins/bootstrap/js/popper.min.js')}}"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="{{asset('assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
    
    <!-- FullCalendar -->
    <script src="{{asset('assets/plugins/moment/min/moment.min.js')}}"></script>
    <script src="{{asset('assets/plugins/calendar/dist/fullcalendar.min.js')}}"></script>
    <script src="{{asset('assets/plugins/calendar/dist/locale-all.js')}}"></script>
    <script src="{{asset('assets/plugins/toast-master/js/jquery.toast.js')}}"></script>
    <script src="{{asset('js/toastr.js')}}"></script>
    <script src="{{asset('assets/plugins/sweetalert/sweetalert.min.js')}}"></script>
    <script src="{{ asset('assets/plugins/switchery/dist/switchery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/chosen.jquery.js') }}"></script>
    <script src="{{Config::get('app.NODE_DOMINIO')}}:{{Config::get('app.NODE_PUERTO')}}/socket.io/socket.io.js"></script>  
    <script src="{{ asset('realtime/listens_realtime.js?v=5') }}"></script>

    <script>
        $(document).ready(function() {
            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay,listDay,listWeek,listMonth'
                },
                locale: 'es',
                navLinks: true, // can click day/week names to navigate views
                <?php 
                    ?>
                        businessHours: [ // specify an array instead
                            {
                                dow: [ 1, 2, 3, 4, 5], // lunes a domingo
                                start: '7:00', // 7am
                                end: '18:00' // 6pm
                            },
                            {
                                dow: [ 5 ], // viernes
                                start: '07:00', // 7am
                                end: '17:00' // 5pm
                            }
                        ],
                        weekNumbers: false,
                        minTime: "7:00:00",
                        maxTime: "18:00:00",
                        weekends: false,
                    <?php 
                ?>

                defaultView: 'agendaWeek',
                slotLabelFormat:"hh:mm a", 
                slotDuration: '00:30:00',
                axisFormat: "hh:mm a",
                //defaultDate: '2016-01-12',
                editable: true,
                allDaySlot: false,
                eventLimit: true, // allow "more" link when too many events
                selectable: true,
                selectHelper: true,             
                columnFormat: 'dddd D MMM', // like 'Monday', for day views
     
                select: function(start, end) { // Nuevo evento
                    //$('#modalAgenda #start').val(moment(start).format('YYYY-MM-DD HH:mm:ss'));
                    //$('#modalAgenda #end').val(moment(end).format('YYYY-MM-DD HH:mm:ss'));

                    var fechaInicio = moment(start).format('YYYY-MM-DD HH:mm:ss');
                    var fechaFinal = moment(end).format('YYYY-MM-DD HH:mm:ss');               

                    //Llamado Ajax ------
                    agregarAgenda(fechaInicio, fechaFinal);
                    //-------------------
                },
                eventRender: function(event, element) { // Editar evento (Doble clic)
                    element.find('.fc-title').html(event.title);
                    element.find('.fc-list-item-title').html(event.title);

                    element.bind('dblclick', function() {
                        //Llamado Ajax ------
                        //mostrarEditarAgenda(event.id);
                        //-------------------
                    });
                },
                eventDrop: function(event, delta, revertFunc) { // si changement de position

                    editarFechaAgenda(event);

                },
                eventResize: function(event,dayDelta,minuteDelta,revertFunc) { // si changement de longueur

                    editarFechaAgenda(event);

                },
                eventClick:  function(event, jsEvent, view) {
                    $('#idAgendaOpciones').val(event.id);   

                    <?php if (count($agendaUsuario) > 0) { ?>

                        <?php if ($agendaUsuario[0]->agendaPersonal == 1) { ?>

                        $('#modalTitle').html("Agenda Personal ");

                        <?php }else{ ?>

                        $('#modalTitle').html("Número del sistema interno: " + event.vigProceso + "-" + event.idProceso);
                            var ruta = "{{URL::to('insp/verQueja/')}}";
                            $('#eventUrl').attr('href', ruta + "/"+ event.vigProceso + "/" + event.idProceso + "/0");

                        <?php } ?>

                    <?php } ?>

                       $('#descripcion').html(event.description);
                        $("#divVerOpcionesAgenda").css("display", "block");
                        $('#modalOpcionesAgenda').modal();
                 
                },   
                
                events: [
                <?php foreach($agendaUsuario as $agenda): 
                
                    $inicio = explode(" ", $agenda->fechaInicioAgenda);
                    $fin = explode(" ", $agenda->fechaFinAgenda);
                    if($inicio[1] == '00:00:00')
                    {
                        $inicio = $inicio[0];
                    }
                    else
                    {
                        $inicio = $agenda->fechaInicioAgenda;
                    }
                    if($fin[1] == '00:00:00')
                    {
                        $fin = $fin[0];
                    }
                    else
                    {
                        $fin = $agenda->fechaFinAgenda;
                    }
                ?>
                    {
                        id: '<?php echo $agenda->Id; ?>',

                        <?php if ($agenda->radicadoJuzgado == '') { ?>
                            <?php if ($agenda->agendaPersonal == 1) { ?>
                                title: '<?php echo "<span class=numqueja>"."Agenda Personal".$agenda->agendaPersonal."</span>"?>',
                            <?php }else{ ?>
                                    title: '<?php echo "<span class=numqueja>"."Sin radicado del juzgado"."</span>"?>',
                            <?php } ?>
                        <?php } ?>

                        <?php if ($agenda->radicadoJuzgado != '') { ?>
                            title: '<?php echo "<span class=numqueja>".$agenda->radicadoJuzgado."</span>"?>',
                        <?php } ?>

                        description: "<?php echo trim(preg_replace('/\s+/', ' ', $agenda->asuntoAgenda)); ?>",
                        start: '<?php echo $inicio; ?>',
                        end: '<?php echo $fin; ?>',
                        color: '<?php echo $agenda->color; ?>',
                        vigProceso: '<?php echo $agenda->vigenciaRadicado; ?>',
                        idProceso: '<?php echo $agenda->idRadicado; ?>',                    
                    },
                <?php endforeach; ?>
                ],
                timeFormat: 'hh:mm a'

            });        
        });

        function ocultarDivAgendaRadicado(){
            if ($('#DivAgendaRadicado').is(':visible')) {
                $('#DivAgendaRadicado').hide();
            } else {
                $('#DivAgendaRadicado').show();
            }
        }

        function agregarAgenda(fechaInicio, fechaFinal) 
        {   
            var selectUsuarioAgenda = $('#selectUsuarioAgenda').val();
            $('#modalAgenda').modal('show');

            var ruta = "{{URL::to('agenda/agregarAgenda/')}}";
            var loader = '<img src="{{ asset("assets/images/loader.gif") }}">';
            
            var parametros = {    
                "fechaInicio" : fechaInicio,
                "fechaFinal" : fechaFinal,
                "selectUsuarioAgenda": selectUsuarioAgenda
            };

            $.ajax({                
                data:  parametros,
                url:   ruta,
                type:  'post',            
                beforeSend: function(){      
                    $('#resultadoAgenda').html('<p style="margin-top:10px; width:100%; text-align:center;">'+loader+'</p>');
                },
                success:  function (responseText) 
                { 
                   $("#resultadoAgenda").html(responseText);
                   $('.chosen-select').chosen();
                   //Repara chosen
                   fixChoosen();
                    var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
                    $('.js-switch').each(function() {
                        new Switchery($(this)[0], $(this).data());
                    });
                },
                error: function(responseText)
                {
                  alert("369");
                }
            }); 
        }

        function validarGuardarAgendaPersonal(){

            var asuntoAgenda = $('#asuntoAgenda').val();
            var fechaInicioAg = $('#fechaInicioAg').val();
            var fechaFinalAg = $('#fechaFinalAg').val();

            if(asuntoAgenda == "")
            {
                swal("Oops", "Ingrese el asunto", "error");    
                playAudio('fail');
                $("#asuntoAgenda").focus();
                return false;
            }
            $('#modalAgenda').modal('hide');


            //Petición Ajax
            var ruta = "{{URL::to('agenda/validarGuardarAgenda/')}}";

            var parametros = {
                asuntoAgenda,
                fechaInicioAg,
                fechaFinalAg,
                "personal": 1
            };

            $.ajax({                
                data:  parametros,
                url:   ruta,
                type:  'post',
                success:  function (responseText) 
                { 
                        playAudio('alert');
                        //Agrega el evento ----------------------------------
                        var newEvent = {
                            id: responseText.idAgenda,
                            start: fechaInicioAg,
                            end: fechaFinalAg,
                            title: "<span class=numqueja> Agenda Personal </span>",
                            description: asuntoAgenda,
                            color: 'yellow',
                        };
                        $('#calendar').fullCalendar('renderEvent', newEvent, true);
                        //---------------------------------------------------
                        $.toast({
                            heading: 'Agendado correctamente',
                            text: 'Se reprogramó la fecha en la agenda',
                            position: 'top-right',
                            loaderBg:'#ff6849',
                            icon: 'success',
                            hideAfter: 2800, 
                            stack: 6
                        });
                    
                },
                error: function(responseText)
                {
                  $.toast({
                        heading: 'Atención',
                        text: 'Problemas de conexión a Internet',
                        position: 'top-right',
                        loaderBg:'#ff6849',
                        icon: 'success',
                        hideAfter: 2800, 
                        stack: 6
                    });
                }
            }); 
        }

        

        function validarGuardarAgenda()
        { 

            if($("#agendaPersonal").is(':checked'))
            {
              validarGuardarAgendaPersonal();
              return;
            }

            var radicadoJuzgado = $('#radicadoJuzgado').val(); 
            var vigenciaProceso = $('#vigenciaProceso').val(); 
            var selectProceso = $('#selectProceso').val();
            var fechaInicioAg = $('#fechaInicioAg').val();
            var fechaFinalAg = $('#fechaFinalAg').val();
            var colorAgenda = $('#colorAgenda').val();
            var asuntoAgenda = $('#asuntoAgenda').val();
            var selectUsuarioAgenda = $('#selectUsuarioAgenda').val();
            var selectTipoNotifi = $('#selectTipoNotifi').val();
            var diasAntes = $('#diasAntes').val();
            var usauriosNotificar = $("#usuariosNotificar").chosen().val();
            var selectTipoAgenda = $('#selectTipoAgenda').val();

            if(selectTipoAgenda == '')
            {
                swal("Oops", "Seleccione una forma de agendar", "error");    
                playAudio('fail');
                return false;
            }

            if(selectTipoAgenda == 1)//radicado del juzgado
            {
                if(radicadoJuzgado == "")
                {
                    swal("Oops", "Ingrese el radicado del juzgado", "error");    
                    playAudio('fail');
                    return false;
                }

                if(radicadoJuzgado.length < 9 && selectProceso == '')
                {
                    swal("Oops", "Ingrese un radicado correcto para buscar", "error");    
                    playAudio('fail');
                    return false;
                }
            }
            
            if(selectProceso === undefined || selectProceso == '')
            {
                swal("Oops", "Por favor seleccione un radicado sugerido para agendar", "error");    
                playAudio('fail');
                return false;
            }

            if($("#usauriosAgendaOtros").is(':checked'))
            {
                if(usauriosNotificar == null)
                {
                    swal("Oops", "Seleccione al menos un usuario a notificar", "error");    
                    playAudio('fail');
                    return false;
                }
            }

            if($("#agendaCritica").is(':checked'))
            {
              var agendaCritica = 1;
              var colorAgenda = '#FF0000';// color rojo por ser importante el evento
            }
            else
            {
              var agendaCritica = 0;
            }

            if($("#notificacionAgenda").is(':checked'))
            {
                if(selectTipoNotifi == 0)
                {
                    swal("Oops", "Seleccione el tipo de notificación", "error");    
                    playAudio('fail');
                    return false;
                }

                if(diasAntes == '' || diasAntes == 0)
                {
                    swal("Oops", "Ingrese los días para recibirir la notificación", "error");    
                    playAudio('fail');
                    return false;
                }
            }
            else
            {
              var selectTipoNotifi = 0;
              var diasAntes = 0;
            }

            if(colorAgenda == "0")
            {
                swal("Oops", "Seleccione el color para la agenda", "error");    
                playAudio('fail');
                $("#colorAgenda").focus();
                return false;
            }

            if(asuntoAgenda == "")
            {
                swal("Oops", "Ingrese el asunto", "error");    
                playAudio('fail');
                $("#asuntoAgenda").focus();
                return false;
            }

            $('#modalAgenda').modal('hide');

            var jsonUsuariosNotificar = JSON.stringify(usauriosNotificar);

            //Petición Ajax
            var ruta = "{{URL::to('agenda/validarGuardarAgenda/')}}";

            var parametros = {
                "vigenciaProceso" : vigenciaProceso,
                "selectProceso" : selectProceso,
                "fechaInicioAg" : fechaInicioAg,
                "fechaFinalAg" : fechaFinalAg,
                "colorAgenda" : colorAgenda,
                "asuntoAgenda": asuntoAgenda,
                "agendaCritica": agendaCritica,
                "selectUsuarioAgenda": selectUsuarioAgenda,
                "selectTipoNotifi": selectTipoNotifi,
                "diasAntes": diasAntes,
                "jsonUsuariosNotificar": jsonUsuariosNotificar,
                "personal": 0
            };

            $.ajax({                
                data:  parametros,
                url:   ruta,
                type:  'post',
                success:  function (responseText) 
                { 
                    if(responseText == 0)
                    {
                        swal("Oops", "La fecha de la agenda es menor a la fecha actual", "error"); 
                        return false;
                    }
                    else
                    { 
                        socket.emit("server_nuevaAgenda", {idUsuarioAgenda: responseText.selectUsuarioAgenda, mensaje: "Le fue asignada una nueva agenda en el proceso: " + responseText.vigenciaRadicado + "-" + responseText.idRadicado + ", por favor revise su agenda."});

                        playAudio('alert');
                        //Agrega el evento ----------------------------------
                        var newEvent = {
                            id: responseText.idAgenda,
                            start: fechaInicioAg,
                            end: fechaFinalAg,
                            title: "<span class=numqueja>Proceso: " + vigenciaProceso + "-" + selectProceso + "</span>",
                            description: asuntoAgenda,
                            color: colorAgenda,
                            vigProceso: vigenciaProceso,
                            idProceso: selectProceso,
                        };
                        $('#calendar').fullCalendar('renderEvent', newEvent, true);
                        //---------------------------------------------------
                        $.toast({
                            heading: 'Agendado correctamente',
                            text: 'Se reprogramó la fecha en la agenda',
                            position: 'top-right',
                            loaderBg:'#ff6849',
                            icon: 'success',
                            hideAfter: 2800, 
                            stack: 6
                        });
                    }
                },
                error: function(responseText)
                {
                  $.toast({
                        heading: 'Atención',
                        text: 'Problemas de conexión a Internet',
                        position: 'top-right',
                        loaderBg:'#ff6849',
                        icon: 'success',
                        hideAfter: 2800, 
                        stack: 6
                    });
                }
            }); 
        }

        function cambiarVigenciaProceso(vigencia)
        {
          var selectUsuarioAgenda = $('#selectUsuarioAgenda').val();

          var ruta = "{{URL::to('agenda/cambiarVigenciaProceso/')}}";  

          var parametros = {    
            "vigencia" : vigencia,
            "selectUsuarioAgenda": selectUsuarioAgenda
          };

          $.ajax({                
              data:  parametros,
              url:   ruta,
              type:  'post',
              success:  function (responseText) 
              {
                $("#resultadoVigenciaProceso").html(responseText);
                $('.chosen-select').chosen();
              },
              error: function(responseText)
              {
                $.toast({
                    heading: 'Atención',
                    text: 'Problemas de conexión a Internet',
                    position: 'top-right',
                    loaderBg:'#ff6849',
                    icon: 'success',
                    hideAfter: 2800, 
                    stack: 6
                });
              }
          }); 
        }

        function mostrarEditarAgenda() 
        {   
            var idAgenda = $('#idAgendaOpciones').val();        

            $('#modalOpcionesAgenda').modal('hide');
            $('#modalAgenda').modal('show');

            var ruta = "{{URL::to('agenda/mostrarEditarAgenda/')}}";
            var loader = '<img src="{{ asset("assets/images/loader.gif") }}">';

            var parametros = {    
                "idAgenda" : idAgenda
            };

            $.ajax({                
                data:  parametros,
                url:   ruta,
                type:  'post',            
                beforeSend: function(){      
                  $('#resultadoAgenda').html('<p style="margin-top:10px; width:100%; text-align:center;">'+loader+'</p>');
                },
                success:  function (responseText) 
                { 
                    $("#resultadoAgenda").html(responseText);
                    var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
                    $('.js-switch').each(function() {
                        new Switchery($(this)[0], $(this).data());
                    });
                },
                error: function(responseText)
                {
                  alert("365");
                }
            }); 
        }

        function validarEditarAgenda(idAgenda)
        { 
            var agendaPersonal      = $('#agendaPersonal').val();
            var fechaFinAgenda      = $('#fechaFinAgenda').val();
            var colorAgendaEditar   = $('#colorAgendaEditar').val();
            var asuntoAgendaEditar  = $('#asuntoAgendaEditar').val();
            var vigenciaRadicado    = $('#vigenciaRadicado').val();
            var idRadicado          = $('#idRadicado').val();
            var fechaInicioAgenda   = $('#fechaInicioAgenda').val();
            var selectTipoNotifiEditar = $('#selectTipoNotifiEditar').val();
            var diasAntesEditar     = $('#diasAntesEditar').val();

            if($("#notificacionAgendaEditar").is(':checked'))
            {
                if(selectTipoNotifiEditar == 0)
                {
                    swal("Oops", "Seleccione el tipo de notificación", "error");    
                    playAudio('fail');
                    return false;
                }

                if(diasAntesEditar == '' || diasAntesEditar == 0)
                {
                    swal("Oops", "Ingrese los días para recibirir la notificación", "error");    
                    playAudio('fail');
                    return false;
                }
            }
            else
            {
              var selectTipoNotifiEditar = 0;
              var diasAntesEditar = 0;
            }
          
            if(asuntoAgendaEditar == "")
            {
                swal("Oops", "Ingrese el asunto", "error");    
                playAudio('fail');
                $("#asuntoAgendaEditar").focus();
                return false;
            }

            if($("#agendaCriticaEditar").is(':checked'))
            {
              var agendaCriticaEditar = 1;
              var colorAgendaEditar = '#FF0000';// color rojo por ser importante el evento
            }
            else
            {
              var agendaCriticaEditar = 0;
            }       
          
            //Petición Ajax
            var ruta = "{{URL::to('agenda/validarEditarAgenda/')}}";

            var parametros = { 
                "agendaCriticaEditar" : agendaCriticaEditar,   
                "colorAgendaEditar" : colorAgendaEditar,
                "asuntoAgendaEditar" : asuntoAgendaEditar,
                "idAgenda": idAgenda,
                "selectTipoNotifiEditar": selectTipoNotifiEditar,
                "diasAntesEditar": diasAntesEditar
            };

            $.ajax({                
                data:  parametros,
                url:   ruta,
                type:  'post',
            success:  function (responseText) 
            {
                var proceso = "";
                if (agendaPersonal == 1){
                    proceso = "Agenda Personal"
                }else{
                    proceso = "<span class=numqueja>Proceso: " + vigenciaRadicado + "-" + idRadicado + "</span>" 
                }
                var newEvent = {
                    id: idAgenda,
                    start: fechaInicioAgenda,
                    end: fechaFinAgenda,
                    title: proceso ,
                    description: asuntoAgendaEditar,
                    color: colorAgendaEditar,
                    vigProceso: vigenciaRadicado,
                    idProceso: idRadicado,
                };
                playAudio('alert');

                //Agrega el evento ----------------------------------
     

                $('#calendar').fullCalendar('removeEvents', [idAgenda]);
                $('#calendar').fullCalendar('renderEvent', newEvent, true);         
                //$('#calendar').fullCalendar('rerenderEvents');
                //---------------------------------------------------

                $.toast({
                    heading: 'Modificado correctamente',
                    text: 'Se modificaron los datos del evento',
                    position: 'top-right',
                    loaderBg:'#ff6849',
                    icon: 'success',
                    hideAfter: 2800, 
                    stack: 6
                });
                $('#modalAgenda').modal('hide');
            },
            error: function(responseText)
            {
              $.toast({
                    heading: 'Atención',
                    text: 'Problemas de conexión a Internet',
                    position: 'top-right',
                    loaderBg:'#ff6849',
                    icon: 'success',
                    hideAfter: 2800, 
                    stack: 6
                });
            }
          }); 
        }
        
        function editarFechaAgenda(event)
        {       
            start = event.start.format('YYYY-MM-DD HH:mm:ss');
            if(event.end)
            {
                end = event.end.format('YYYY-MM-DD HH:mm:ss');
            }
            else
            {
                end = start;
            }
            
            id =  event.id;

            var parametros = {  
                "idAgenda"    : id,
                "fechaInicioAgenda" : start,
                "fechaFinAgenda"   : end
            };

            ruta = "{{URL::to('agenda/editarFechaAgenda/')}}";

            $.ajax({
             url : ruta, 
             type: "POST",
             data: parametros,
             success: function(responseText) { 
                socket.emit("server_nuevaAgenda", {idUsuarioAgenda: responseText.selectUsuarioAgenda, mensaje: "Se reprogramó la agenda del proceso: " + responseText.vigenciaRadicado + "-" + responseText.idRadicado + ", por favor revise su agenda."});

                playAudio('alert');
                $.toast({
                    heading: 'Cambio en la Agenda',
                    text: 'Se reprogramó la fecha en la agenda',
                    position: 'top-right',
                    loaderBg:'#ff6849',
                    icon: 'success',
                    hideAfter: 2800, 
                    stack: 6
                  });  
                }
            });
        }

        function borrarAgenda()
        {
            var idAgenda = $('#idAgendaOpciones').val();

            swal({
                title: "Está seguro de eliminar el evento?",   
                text: "Se eliminará el evento de la base de datos!",   
                type: "warning",   
                showCancelButton: true,   
                confirmButtonColor: "#f8b32d",   
                confirmButtonText: "Sí, eliminarlo!",   
                closeOnConfirm: false 
            }, function(){   
                validarEliminarAgenda(idAgenda);
            });
        }

        function validarEliminarAgenda(idAgenda)
        {
            var ruta = "{{URL::to('agenda/validarEliminarAgenda/')}}";

            var parametros = {    
                "idAgenda" : idAgenda
            };

            $.ajax({                
                data:  parametros,
                url:   ruta,
                type:  'post',            
                success:  function (responseText) 
                { 
                    $('#calendar').fullCalendar('removeEvents', [idAgenda]);
                    $('#calendar').fullCalendar('rerenderEvents');

                    $('#modalOpcionesAgenda').modal('hide');
                    swal("Eliminado!", "El evento ha sido eliminada.", "success"); 
                },
                error: function(responseText)
                {
                  alert("723");
                }
            }); 
        }

        function ocultarColor()
        {
            if($("#agendaCritica").is(':checked'))
            {
                $("#divColores").css("display", "none");
            }
            else
            {
                $("#divColores").css("display", "block");
            }
        }

        function ocultarColorEditar()
        {
            if($("#agendaCriticaEditar").is(':checked'))
            {
                $("#divColoresEditar").css("display", "none");
            }
            else
            {
                $("#divColoresEditar").css("display", "block");
            }
        }

        function showTipoTiempo()
        {
            if($("#notificacionAgenda").is(':checked'))
            {
                $("#divTiempoNotifi").css("display", "block");
            }
            else
            {
                $("#divTiempoNotifi").css("display", "none");
            }
        }

        function showTipoTiempoEditar()
        {
            if($("#notificacionAgendaEditar").is(':checked'))
            {
                $("#divTiempoNotifiEditar").css("display", "block");
            }
            else
            {
                $("#divTiempoNotifiEditar").css("display", "none");
            }
        }

        function fixChoosen() 
        {
           var els = jQuery(".chosen-select");
           els.on("chosen:showing_dropdown", function () {
              $(this).parents("div").css("overflow", "visible");
           });
           els.on("chosen:hiding_dropdown", function () {
              var $parent = $(this).parents("div");

              // See if we need to reset the overflow or not.
              var noOtherExpanded = $('.chosen-with-drop', $parent).length == 0;
              if (noOtherExpanded)
                 $parent.css("overflow", "");
           });
        }

        function buscarProcesoAgenda(input)
        {   
            var num = input.value.replace(/\./g,'');
            if(isNaN(num))
            {
                swal("Oops", "Sólo se permiten números", "error");    
                playAudio('fail');
                $('#radicadoJuzgado').val('');
                return false;
            }

            var radicadoJuzgado = $('#radicadoJuzgado').val();
            var selectUsuarioAgenda = $('#selectUsuarioAgenda').val();

            if(radicadoJuzgado.length > 6 && radicadoJuzgado.length < 10)
            {
                var ruta = "{{URL::to('agenda/buscarProcesoAgenda/')}}";  

                var parametros = {    
                    "radicadoJuzgado"    : radicadoJuzgado,
                    "selectUsuarioAgenda": selectUsuarioAgenda
                };

                $.ajax({                
                    data:  parametros,
                    url:   ruta,
                    type:  'post',
                    success:  function (responseText) 
                    {
                        $("#resultadoSugeridos").html(responseText);
                    },
                    error: function(responseText)
                    {
                        $.toast({
                            heading: 'Atención',
                            text: 'Problemas de conexión a Internet',
                            position: 'top-right',
                            loaderBg:'#ff6849',
                            icon: 'success',
                            hideAfter: 2800, 
                            stack: 6
                        });
                    }
                }); 
            }
        }

        function format(input)
        {
          var num = input.value.replace(/\./g,'');
          if(isNaN(num))
          {
            swal("Oops", "Sólo se permiten números", "error");    
            playAudio('fail');
            $('#radicadoJuzgado').val('');
            return false;
          }
        }

        function seleccionarSugerido(vigenciaRadicado, idRadicado)
        {
            var ruta = "{{URL::to('agenda/seleccionarSugerido/')}}";  

            var parametros = {    
                "vigenciaRadicado" : vigenciaRadicado,
                "idRadicado"       : idRadicado
            };

            $.ajax({                
                data:  parametros,
                url:   ruta,
                type:  'post',
                success:  function (responseText) 
                {
                    $("#divProcesoAgenda").html(responseText);
                },
                error: function(responseText)
                {
                    $.toast({
                        heading: 'Atención',
                        text: 'Problemas de conexión a Internet',
                        position: 'top-right',
                        loaderBg:'#ff6849',
                        icon: 'success',
                        hideAfter: 2800, 
                        stack: 6
                    });
                }
            }); 
        }

        function usuariosAgenda()
        {
            if($("#usauriosAgendaOtros").is(':checked'))
            {
                $("#divLabelOtrosUser").css("display", "block");

                var ruta = "{{URL::to('agenda/usuariosAgenda/')}}";  

                $.ajax({                
                    url:   ruta,
                    type:  'post',
                    success:  function (responseText) 
                    {
                        $("#resultadoOtrosUsuariosAgenda").html(responseText);
                        $('.chosen-select').chosen();
                        //Repara chosen
                        fixChoosen();
                    },
                    error: function(responseText)
                    {
                        $.toast({
                            heading: 'Atención',
                            text: 'Problemas de conexión a Internet',
                            position: 'top-right',
                            loaderBg:'#ff6849',
                            icon: 'success',
                            hideAfter: 2800, 
                            stack: 6
                        });
                    }
                }); 
            }
            else
            {
                $("#resultadoOtrosUsuariosAgenda").empty();
                $("#divLabelOtrosUser").css("display", "none");
            }
        }

        function tipoAgenda(idTipoAgenda)
        {
            if(idTipoAgenda == 1)//radicado del juzgado
            {
                $("#divRadicadoJuzgado").css("display", "block");
                $("#divProcesoInternos").css("display", "none");  
            }

            if(idTipoAgenda == 2)//radicado interno
            {
                $("#divRadicadoJuzgado").css("display", "none");
                $("#divProcesoInternos").css("display", "block"); 
            }
        }
    </script>
</body>
</html>