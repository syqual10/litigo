<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>SyQual 10</title>
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('css/font-awesome.min.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
    <style type="text/css">  
    body {
        font-size:11px;
        font-family:  'Poppins', sans-serif;
        padding: 0 20px;
        color: #333;
    }

    @page { margin: 70px 32px; }          
    .footer { position: fixed; left: 0px; bottom: -160px; right: 10px; height: 165px;}
    .footer .copia {color:gray;}
    .footer .page:after { content: counter(page, decimal);}
      
    .copiaCont { 
        position: fixed; top: 390px; right: -380px;
        width: 780px;
        -webkit-transform: rotate(90deg);
        -moz-transform: rotate(90deg);
        -o-transform: rotate(90deg);
        writing-mode: lr-tb;            
    }
    .copiaC {color:Crimson;}
    .copiaC2 {color:silver;}

    #paginaPrincipal{
        vertical-align:middle;
        margin-top: 20px;
    }
    #encabezado {
        border-collapse: collapse;
        width:96%;
    }
    #radicado{
        text-align: center;
        line-height: 34px;
        font-size: 24px;
        color: #03a9f4!important;
        font-weight: bold;
    }
    #radicado-txt{
        color: rgba(0,0,0,.54);
        font-weight: 500; 
    }
    .block-content {    
        padding: 8px 8px 1px;
        width: 100%;
    }
    .block {
        margin-bottom: 2px;
        background-color: #fff;
        box-shadow: 0 1px 1px #e4e7ed;
    }
    .block-content.block-content-full {
        padding-bottom: 20px;
    }
    .text-center {
        text-align: center!important;
    }
    .py-20 {
        padding-top: 20px!important;
    }
    .mb-20, .my-20 {
        margin-bottom: 20px!important;
    }
    .font-w600 {
        font-weight: 600!important;
    }
    .font-size-h4 {
        font-size: 1.271429rem;
    }
    .text-muted {
        color: #6c757d!important;
    }
    .text-primary {
        color: #3f9ce8!important;
    }
    .titulo{
        border-color: #e4e7ed;
        padding: 4px 12px;
        text-align: center;
        margin: 16px 0 4px 0;
        border-bottom: 4px solid #333;
        color: #000;
    }
    .contenido{
        padding: 8px 16px;
    }
    hr {
      page-break-after: always;
      border: 0;
      margin: 0;
      padding: 0;
    }
    </style>
</head>
<body>
    <div class="copiaCont" style="font-size:12px;">
        <div> <span class="copiaC">{{$informacionPdf[0]->nombreMedioControl}}
                <span class="copiaC2"> - Esta información puede sufrir modificaciones debido a la dinámica del proceso</span>
              </span> 
        </div>
    </div>
    <div class="footer">
        <div align="center" style="font-size:12px;"> 
            <span class="copia">SyQual10 ® - Sistema de Gestión de la Defensa Judicial 
                <br> www.syqual10.com</span> 
        </div>
        <div align="right" class="page" style="font-size:12px;">Pag. </div>
    </div>
    
    <table id="encabezado" border="0">
        <tr>
            <td width="20%" rowspan="4">
                           
            </td>        
            <td width="60%" align="center">
                <span align="center"><span align="center">{{ strtoupper ($entidad->nombreEntidad) }}</span></span>      
            </td>
            <td width="20%" rowspan="4">
                <div id="radicado"> {{$informacionPdf[0]->vigenciaRadicado."-".$informacionPdf[0]->idRadicado}} </div>
                <div id="radicado-txt">Número de radicado </div>      
            </td>  
        </tr>    
        <tr>   
            <td align="center">
                <span align="center"><span style="color:gray;"><b>Sistema de Gestión de la Defensa Judicial</b></span></span> 
            </td>
            <td></td>
        </tr>
        <tr>
            <td align="center">
                <span align="center">Tipo de proceso : {{$informacionPdf[0]->nombreTipoProceso}}</span>
            </td>
            <td></td>
        </tr>
        <tr>
            <td align="center">
                Ficha técnica del radicado
            </td>
            <td></td>
        </tr>
    </table>
    
    <div id="paginaPrincipal">
        <div class="titulo font-size-h4 font-w600">
            DATOS BÁSICOS - {{ strtoupper($informacionPdf[0]->nombreMedioControl)}}
        </div>
        <table width="100%">
            <tr>
                <td width="50%">
                    <div class="block">    
                        <div class="block-content block-content-full">
                            <div class="text-center">
                                <div class="font-size-h4 font-w600">
                                    <div class="font-size-h4 font-w600">{{$informacionPdf[0]->nombreAccion}}</div>
                                </div>
                                <div class="text-muted">Acción</div>
                            </div>
                        </div>    
                    </div>
                </td>
                <td width="50%">
                    <div class="block">    
                        <div class="block-content block-content-full">
                            <div class="text-center">
                                <div class="font-size-h4 font-w600">Procuraduría</div>
                                <div class="text-muted">{{$informacionPdf[0]->nombreAutoridadConoce}}</div>                   
                            </div>
                        </div>    
                    </div>
                </td>
            </tr>
            <tr>
                <td width="50%">
                    <div class="block">    
                        <div class="block-content block-content-full">
                            <div class="text-center">
                                <div class="font-size-h4 font-w600">{{ucfirst(utf8_encode(strftime("%d de %B de %Y", strtotime($informacionPdf[0]->fechaNotificacion))))}} {{ date('h:i A', strtotime($informacionPdf[0]->fechaNotificacion))}}</div>
                                <div class="text-muted">Fecha de notificación</div>                   
                            </div>
                        </div>    
                    </div>                        
                </td>
                <td width="50%">
                    <div class="block">    
                        <div class="block-content block-content-full">
                            <div class="text-center">
                                <div class="font-size-h4 font-w600">{{ucfirst(utf8_encode(strftime("%d de %B de %Y", strtotime($informacionPdf[0]->fechaRadicado))))}} {{ date('h:i A', strtotime($informacionPdf[0]->fechaRadicado))}}</div>
                                <div class="text-muted">Fecha de radicado</div>                   
                            </div>
                        </div>    
                    </div>
                </td>
            </tr>
        </table>

        <div class="titulo font-size-h4 font-w600">
            HECHOS DE LA DEMANDA
        </div>
        <div class="block contenido">
            @if($informacionPdf[0]->descripcionHechos != "")
                {{$informacionPdf[0]->descripcionHechos}}
            @else
                Sin información registrada
            @endif
        </div>

        <div class="titulo font-size-h4 font-w600">
            CUANTÍAS
        </div>
        <div class="block contenido">
            @if(count($cuantias) > 0)
                <div class="dtt">
                    <table width="100%">
                        <thead>
                            <tr>
                                <th>Unidad Monetaria</th>
                                <th>Valor</th>
                                <th>Valor en pesos</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            @foreach($cuantias as $cuantia)
                                <tr>
                                    @if($cuantia->unidadMonetaria == 1)
                                        <td width="90%">Salarios Mínimos</td>
                                    @else
                                        <td width="90%">$</td>
                                    @endif
                                    <td width="90%">{{$cuantia->valor}}</td>
                                    <td width="90%">{{$cuantia->valorPesos}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <div class="titulo font-size-h4 font-w600">
            CONVOCANTE
        </div>
        <div class="block contenido">
            @if(count($convocantes) > 0)
                <div class="dtt">
                    <table width="100%">
                        <thead>
                            <tr>
                                <th>Documento</th>
                                <th>Nombre</th>
                                <th>Dirección</th>
                                <th>Celular</th>
                                <th>Correo</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            @foreach($convocantes as $convocante)
                                <tr>
                                    <td width="90%">{{$convocante->documentoSolicitante}}</td>
                                    <td width="90%">{{$convocante->nombreSolicitante}}</td>
                                    <td width="90%">{{$convocante->direccionSolicitante}}</td>
                                    <td width="90%">{{$convocante->celularSolicitante}}</td>
                                    <td width="90%">{{$convocante->correoSolicitante}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>


        <div class="titulo font-size-h4 font-w600">
            CONVOCADO EXTERNO
        </div>
        <div class="block contenido">
            @if(count($convocadosExt) > 0)
                <div class="dtt">
                    <table width="100%">
                        <thead>
                            <tr>
                                <th>Documento</th>
                                <th>Nombre</th>
                                <th>Tarjeta Abogado</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            @foreach($convocadosExt as $convocadoExt)
                                <tr>
                                    <td width="90%">{{$convocadoExt->nombreConvocadoExterno}}</td>
                                    <td width="90%">{{$convocadoExt->direccionConvocadoExterno}}</td>
                                    <td width="90%">{{$convocadoExt->telefonoConvocadoExterno}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
        
        <div class="titulo font-size-h4 font-w600">
            CONVOCADO INTERNO
        </div>
        <div class="block contenido">
            @if(count($convocadosInt) > 0)
                <div class="dtt">
                    <table width="100%">
                        <thead>
                            <tr>
                                <th>Dependencia</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            @foreach($convocadosInt as $convocadoInt)
                                <tr>
                                    <td>{{$convocadoInt->nombreDependencia}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif    
        </div>        
    </div>
</body>