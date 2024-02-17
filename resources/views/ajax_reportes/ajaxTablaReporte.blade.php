@php
    use SQ10\helpers\Util as Util;
@endphp

<input type="hidden" value="{{$fechaInicial}}" id="fechaInicialSeleccionada">
<input type="hidden" value="{{$fechaFinal}}" id="fechaFinalSeleccionada">

<ul id="myTab3" class="nav nav-tabs tabs-pull-right bordered">
    <li class="active">
        <a href="#l1" data-toggle="tab" aria-expanded="true">Gráfica</a>
    </li>
    <li class="pull-right">
        <a href="#l2" data-toggle="tab" aria-expanded="false">Tabla de Datos</a>
    </li>
</ul>
<div id="myTabContent3" class="tab-content padding-10">
    <!-- Gráfica -->
    <div class="tab-pane fade active in" id="l1">
        @if($tipoReporte == 1)<!--tipos de medios de control-->
            <input type="hidden" id="ingresadasEne" value="{{$ingresadasEne}}">
            <input type="hidden" id="ingresadasFeb" value="{{$ingresadasFeb}}">
            <input type="hidden" id="ingresadasMar" value="{{$ingresadasMar}}">
            <input type="hidden" id="ingresadasAbr" value="{{$ingresadasAbr}}">
            <input type="hidden" id="ingresadasMay" value="{{$ingresadasMay}}">
            <input type="hidden" id="ingresadasJun" value="{{$ingresadasJun}}">
            <input type="hidden" id="ingresadasJul" value="{{$ingresadasJul}}">
            <input type="hidden" id="ingresadasAgo" value="{{$ingresadasAgo}}">
            <input type="hidden" id="ingresadasSep" value="{{$ingresadasSep}}">
            <input type="hidden" id="ingresadasOct" value="{{$ingresadasOct}}">
            <input type="hidden" id="ingresadasNov" value="{{$ingresadasNov}}">
            <input type="hidden" id="ingresadasDic" value="{{$ingresadasDic}}">
            <input type="hidden" id="totalMediosControl" value="{{$totalMediosControl}}">

            <div class="row">
                <div>
                    <div class="widget-body no-padding">
                        <div id="tiposProceso" class="chart no-padding"></div>
                    </div>
                    <!-- end widget content -->
                </div>
            </div>
        @endif<!--tipos de medios de control-->

        @if($tipoReporte == 2)<!--Acciones-->
            <input type="hidden" id="acciones" value="{{$acciones}}">
            <div class="row">
                <div>
                    <div class="widget-body no-padding">
                        <div id="graficoAcciones" class="chart no-padding"></div>
                    </div>
                    <!-- end widget content -->
                </div>
            </div>
        @endif<!--Acciones-->

        @if($tipoReporte == 3)<!--Usuarios-->
            <input type="hidden" id="usuarios" value="{{$usuarios}}">

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="panel panel-default card-view panel-refresh">
                        <div class="refresh-container">
                            <div class="la-anim-1"></div>
                        </div>
                        <div class="panel-wrapper collapse in">
                            <div id="graficoUsuarios" class="morris-chart"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div>
                    <div class="widget-body no-padding">
                        <h4>Activos en la bandeja de:</h4>
                        <div id="bar-graph" class="chart no-padding"></div>
                    </div>
                    <!-- end widget content -->
                </div>
            </div>
        @endif<!--Usuarios-->

        @if($tipoReporte == 4)<!--Estado radicados-->
            <input type="hidden" id="estadoRadicados" value="{{$estadoRadicados}}">
            <div class="row">
                <div>
                    <div class="widget-body no-padding">
                        <div id="graficaEstadoRadicados" class="chart no-padding"></div>
                    </div>
                    <!-- end widget content -->
                </div>
            </div>                             
        @endif<!--Estado radicados--> 

        @if($tipoReporte == 5)<!--Abogados demandantes-->
            <input type="hidden" id="abogadosDemandantes" value="{{$abogadosDemandantes}}">
            <div class="row">
                <div>
                    <div class="widget-body no-padding">
                        <div id="graficoAbogadosDemandantes" class="chart no-padding"></div>
                    </div>
                    <!-- end widget content -->
                </div>
            </div>
        @endif<!--Abogados demandantes-->

        @if($tipoReporte == 6)<!--Solicitantes-->
            <input type="hidden" id="solicitantes" value="{{$solicitantes}}">

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                    <div class="panel panel-default card-view panel-refresh">
                        <div class="refresh-container">
                            <div class="la-anim-1"></div>
                        </div>
                        <div class="panel-wrapper collapse in">
                            <div id="graficoSolicitantes" class="morris-chart"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div>
                    <div class="widget-body no-padding">
                        <h4>Radicados del demandante:</h4>
                        <div id="bar-graph-graficoSolicitantes" class="chart no-padding"></div>
                    </div>
                    <!-- end widget content -->
                </div>
            </div>
        @endif<!--Solicitantes-->

        @if($tipoReporte == 7)<!--Juzgados-->
            <input type="hidden" id="juzgados" value="{{$juzgados}}">
            <div class="row">
                <div>
                    <div class="widget-body no-padding">
                        <div id="graficaJuzgados" class="chart no-padding"></div>
                    </div>
                    <!-- end widget content -->
                </div>
            </div>                             
        @endif<!--Juzgados--> 

        @if($tipoReporte == 8)<!--Secretarías-->
            <input type="hidden" id="secretarias" value="{{$secretarias}}">
            <div class="row">
                <div>
                    <div class="widget-body no-padding">
                        <div id="graficoSecretarias" class="chart no-padding"></div>
                    </div>
                    <!-- end widget content -->
                </div>
            </div>   
        @endif<!--Secretarías-->

        @if($tipoReporte == 9)<!--Tipos Actuaciones-->
            <input type="hidden" id="tiposActuacion" value="{{$tiposActuacion}}">
            <div class="row">
                <div>
                    <div class="widget-body no-padding">
                        <div id="graficoTiposActuacion" class="chart no-padding"></div>
                    </div>
                    <!-- end widget content -->
                </div>
            </div>   
        @endif<!--Tipos Actuaciones-->
    </div>
    <!-- #Gráfica -->

    <!-- Tabla de Datos -->
    <div class="tab-pane fade" id="l2">
        <!--TABLA-->        
        <div class="widget-body">
            <div class="logo-container full-screen-table-demo">
                <div class="logo"><img src="{{ asset('img/litigo-1.png') }}"></div>
            </div>
            <div class="fresh-table full-screen-table toolbar-color-blue">
                <table id="fresh-table" class="table tabla-fresh">
                    <thead>
                        <tr>
                            <th data-sortable="true">Radicado</th>
                            <th data-sortable="true">Fecha Radicado</th>
                            <th data-sortable="true">Tipo de proceso</th>
                            <th data-sortable="true">Tema</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($reportes) > 0)
                            @foreach($reportes as $reporte)
                            <tr>
                                <td style="width: 10%">{{$reporte->vigenciaRadicado."-".$reporte->idRadicado}}</td>
                                <td style="width: 10%">{{ucfirst(utf8_encode(strftime("%d de %B de %Y", strtotime($reporte->fechaRadicado))))}} {{ date('h:i A', strtotime($reporte->fechaRadicado))}}</td>
                                <td style="width: 10%">{{$reporte->nombreTipoProceso}}</td>
                                <td style="width: 15%">{{$reporte->nombreTema}}</td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <!--TABLA-->
    </div>
    <!-- Tabla de Datos -->
</div>

<!-- REPORTE tiposProceso -->
<script type="text/javascript">
    var ingresadasEne = $("#ingresadasEne").val();
    var ingresadasFeb = $("#ingresadasFeb").val();
    var ingresadasMar = $("#ingresadasMar").val();
    var ingresadasAbr = $("#ingresadasAbr").val();
    var ingresadasMay = $("#ingresadasMay").val();
    var ingresadasJun = $("#ingresadasJun").val();
    var ingresadasJul = $("#ingresadasJul").val();
    var ingresadasAgo = $("#ingresadasAgo").val();
    var ingresadasSep = $("#ingresadasSep").val();
    var ingresadasOct = $("#ingresadasOct").val();
    var ingresadasNov = $("#ingresadasNov").val();
    var ingresadasDic = $("#ingresadasDic").val();
    var totalTipoProceso = $("#totalTipoProceso").val();

    if( $('#tiposProceso').length > 0 )
    {
        var day_data = [{
            "elapsed" : "Ene",
            "Procesos" : ingresadasEne
        }, {
            "elapsed" : "Feb",
            "Procesos" : ingresadasFeb
        }, {
            "elapsed" : "Mar",
            "Procesos" : ingresadasMar
        }, {
            "elapsed" : "Abr",
            "Procesos" : ingresadasAbr
        }, {
            "elapsed" : "May",
            "Procesos" : ingresadasMay
        },  {
            "elapsed" : "Jun",
            "Procesos" : ingresadasJun
        }, {
            "elapsed" : "Jul",
            "Procesos" : ingresadasJul
        }, {
            "elapsed" : "Ago",
            "Procesos" : ingresadasAgo
        }, {
            "elapsed" : "Sep",
            "Procesos" : ingresadasSep
        }, {
            "elapsed" : "Oct",
            "Procesos" : ingresadasOct
        }, {
            "elapsed" : "Nov",
            "Procesos" : ingresadasNov
        }, {
            "elapsed" : "Dic",
            "Procesos" : ingresadasDic
        }];
        Morris.Line({
            element : 'tiposProceso',
            data : day_data,
            xkey : 'elapsed',
            ykeys : ['Procesos'],
            labels : ['Procesos'],
            parseTime : false
        });
    }
</script>
<!--# REPORTE tiposProceso -->

<!-- REPORTE acciones -->
<script type="text/javascript">
    var acciones = $("#acciones").val();
    pageSetUp();
    // donut
    if ($('#graficoAcciones').length) 
    {
        Morris.Donut({
            element : 'graficoAcciones',
            data : [ <?php
                        foreach ($acciones as $accion) 
                        {
                            $totalAccion = DB::table('juriradicados')
                               ->whereBetween(DB::raw('substr(fechaRadicado, -19, 10)'),
                                array($fechaInicial, $fechaFinal))
                               ->where('juriacciones_idAccion','=',$accion->idAccion)
                               ->count();

                            echo "{
                                    value : '".$totalAccion."',
                                    label : '".$accion->nombreAccion."'
                                }".',';
                        }
                    ?>],
            formatter : function(x) {
                return x + " Procesos"
            }
        });
    }
</script>
<!--# REPORTE acciones -->

<!-- REPORTE usuarios -->
<script type="text/javascript">
    var usuarios = $("#usuarios").val();
    if ($('#bar-graph').length > 0) 
    {
        Morris.Bar({
            element : 'bar-graph',
            data : [<?php
                        foreach ($usuarios as $usuario) 
                        {
                            $procesosActivos = DB::table('juriradicados')
                                ->join('juriestadosetapas', function ($join) {
                                    $join->on('juriradicados.vigenciaRadicado', '=', 'juriestadosetapas.juriradicados_vigenciaRadicado')
                                    ->on('juriradicados.idRadicado', '=', 'juriestadosetapas.juriradicados_idRadicado');
                                })
                                ->join('juriresponsables', 'juriestadosetapas.juriresponsables_idResponsable', '=', 'juriresponsables.idResponsable')
                                ->join('usuarios', 'juriresponsables.usuarios_idUsuario', '=', 'usuarios.idUsuario')
                                ->whereBetween(DB::raw('substr(fechaRadicado, -19, 10)'),
                                array($fechaInicial, $fechaFinal))
                                ->where('juritipoestadosetapas_idTipoEstadoEtapa', '=', 1)//1 actual en estado etapa
                                ->where('idUsuario', '=', $usuario->usuarios_idUsuario)
                                ->count();

                            echo "{
                                    Funcionario : '".$usuario->nombresUsuario."',
                                    Procesos : '".$procesosActivos."'
                                }".',';
                        }
                    ?>],
            xkey : 'Funcionario',
            ykeys : ['Procesos'],
            labels : ['Procesos'],
            barColors : function(row, series, type) {
                if (type === 'bar') {
                    var red = Math.ceil(150 * row.y / this.ymax);
                    return 'rgb(' + red + ',0,0)';
                } else {
                    return '#000';
                }
            }
        });
    }
</script>
<!--# REPORTE usuarios -->

<!-- REPORTE estado de radicados -->
<script type="text/javascript">
    var estadoRadicados = $("#estadoRadicados").val();
    if( $('#graficaEstadoRadicados').length > 0 )
    {
        var day_data = [<?php
                            foreach ($estadoRadicados as $estado) 
                            {
                                $estadoRadicado = DB::table('juriradicados')
                                    ->whereBetween(DB::raw('substr(fechaRadicado, -19, 10)'),
                                    array($fechaInicial, $fechaFinal))
                                   ->where('vigenciaRadicado', '=', date('Y'))
                                   ->where('juriestadosradicados_idEstadoRadicado','=',$estado->idEstadoRadicado)
                                   ->count();

                                echo "{
                                        elapsed : '".$estado->nombreEstadoRadicado."',
                                        Procesos : '".$estadoRadicado."'
                                    }".',';
                            }
                        ?>];
        Morris.Line({
            element : 'graficaEstadoRadicados',
            data : day_data,
            xkey : 'elapsed',
            ykeys : ['Procesos'],
            labels : ['Procesos'],
            parseTime : false
        });
    }
</script>
<!-- # REPORTE estado de radicados -->

<!-- REPORTE abogados demandantes -->
<script type="text/javascript">
    var abogadosDemandantes = $("#abogadosDemandantes").val();
    pageSetUp();
    // donut
    if ($('#graficoAbogadosDemandantes').length) 
    {
        Morris.Donut({
            element : 'graficoAbogadosDemandantes',
            data : [ <?php
                        foreach ($abogadosDemandantes as $abogadoDemandante) 
                        {
                            $totalAbogado = DB::table('juriradicados')
                                ->join('juriinvolucrados', function ($join) {
                                    $join->on('juriradicados.vigenciaRadicado', '=', 'juriinvolucrados.juriradicados_vigenciaRadicado')
                                    ->on('juriradicados.idRadicado', '=', 'juriinvolucrados.juriradicados_idRadicado');
                                })
                                ->whereBetween(DB::raw('substr(fechaRadicado, -19, 10)'),
                                array($fechaInicial, $fechaFinal))
                                ->where('juriabogados_idAbogado','=',$abogadoDemandante->idAbogado)
                                ->count();

                            echo "{
                                    value : '".$totalAbogado."',
                                    label : '".$abogadoDemandante->nombreAbogado."'
                                }".',';
                        }
                    ?>],
            formatter : function(x) {
                return x + " Procesos"
            }
        });
    }
</script>
<!--# REPORTE abogados demandantes -->

<!-- REPORTE solicitantes -->
<script type="text/javascript">
    var solicitantes = $("#solicitantes").val();
    if ($('#bar-graph-graficoSolicitantes').length > 0) 
    {
        Morris.Bar({
            element : 'bar-graph-graficoSolicitantes',
            data : [<?php
                        foreach ($solicitantes as $solicitante) 
                        {
                            $procesosActivos = DB::table('juriradicados')
                                ->join('juriinvolucrados', function ($join) {
                                    $join->on('juriradicados.vigenciaRadicado', '=', 'juriinvolucrados.juriradicados_vigenciaRadicado')
                                    ->on('juriradicados.idRadicado', '=', 'juriinvolucrados.juriradicados_idRadicado');
                                })
                                ->join('solicitantes', 'juriinvolucrados.solicitantes_idSolicitante', '=', 'solicitantes.idSolicitante')
                                ->whereBetween(DB::raw('substr(fechaRadicado, -19, 10)'),
                                array($fechaInicial, $fechaFinal))
                                ->where('idSolicitante', '=', $solicitante->idSolicitante)
                                ->count();

                            echo "{
                                    Demandante : '".$solicitante->nombreSolicitante."',
                                    Procesos : '".$procesosActivos."'
                                }".',';
                        }
                    ?>],
            xkey : 'Demandante',
            ykeys : ['Procesos'],
            labels : ['Procesos'],
            barColors : function(row, series, type) {
                if (type === 'bar') {
                    var red = Math.ceil(150 * row.y / this.ymax);
                    return 'rgb(' + red + ',0,0)';
                } else {
                    return '#000';
                }
            }
        });
    }
</script>
<!--# REPORTE solicitantes -->

<!-- REPORTE Juzgados -->
<script type="text/javascript">
    var juzgados = $("#juzgados").val();
    if( $('#graficaJuzgados').length > 0 )
    {
        var day_data = [<?php
                            foreach ($juzgados as $juzgado) 
                            {
                                $juz = DB::table('juriradicados')
                                    ->join('jurijuzgados', 'juriradicados.jurijuzgados_idJuzgado', '=', 'jurijuzgados.idJuzgado')
                                    ->whereBetween(DB::raw('substr(fechaRadicado, -19, 10)'),
                                    array($fechaInicial, $fechaFinal))
                                   ->where('idJuzgado','=',$juzgado->idJuzgado)
                                   ->count();

                                echo "{
                                        elapsed : '".$juzgado->nombreJuzgado."',
                                        Procesos : '".$juz."'
                                    }".',';
                            }
                        ?>];
        Morris.Line({
            element : 'graficaJuzgados',
            data : day_data,
            xkey : 'elapsed',
            ykeys : ['Procesos'],
            labels : ['Procesos'],
            parseTime : false
        });
    }
</script>
<!-- # REPORTE Juzgados -->

<!-- REPORTE Secretarías -->
<script type="text/javascript">
    var secretarias = $("#secretarias").val();
    if( $('#graficoSecretarias').length > 0 )
    {
        var day_data = [<?php
                            foreach ($secretarias as $secretaria) 
                            {
                                $totalSecretaria = DB::table('juriradicados')
                                    ->join('juriinvolucrados', function ($join) {
                                        $join->on('juriradicados.vigenciaRadicado', '=', 'juriinvolucrados.juriradicados_vigenciaRadicado')
                                        ->on('juriradicados.idRadicado', '=', 'juriinvolucrados.juriradicados_idRadicado');
                                    })
                                   ->join('dependencias', 'juriinvolucrados.dependencias_idDependencia', '=', 'dependencias.idDependencia')
                                   ->whereBetween(DB::raw('substr(fechaRadicado, -19, 10)'),
                                    array($fechaInicial, $fechaFinal))
                                   ->where('idDependencia', '=', $secretaria->idDependencia)
                                   ->count();

                                echo "{
                                        elapsed : '".$secretaria->nombreDependencia."',
                                        Procesos : '".$totalSecretaria."'
                                    }".',';
                            }
                        ?>];
        Morris.Line({
            element : 'graficoSecretarias',
            data : day_data,
            xkey : 'elapsed',
            ykeys : ['Procesos'],
            labels : ['Procesos'],
            parseTime : false
        });
    }
</script>
<!--# REPORTE Secretarías -->

<!-- REPORTE Tipos Actuación -->
<script type="text/javascript">
    
</script>
<!-- # REPORTE Tipos Actuación -->