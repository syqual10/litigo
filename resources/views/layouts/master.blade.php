<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
@php
use SQ10\Models\Entidad;
use SQ10\helpers\Util as Util;
$carbon = new \Carbon\Carbon();
$carbon->setLocale('es');

$entidad = Entidad::find(1);
$idUsuario = Auth::user()->idUsuario;
$rolUsuario = Auth::user()->roles_idRol;
$superUsuario = Auth::user()->superUsuario;
$cargoUsuario = Auth::user()->cargos_idCargo;
$nombreUsuario = Auth::user()->nombresUsuario;
$vigenciaActual      = date('Y');
$idResponsableSession = Util::idResponsable($idUsuario);
$idsResponsableBuzon = Util::idsResponsableBuzon($idUsuario);

$cargo = DB::table('cargos')
            ->where('idCargo', '=', $cargoUsuario)
            ->get();

$foto = '../public/juriArch/entidad/usuarios/'.Auth::user()->documentoUsuario.'.jpg';

if(file_exists($foto))
{
    $foto = asset('juriArch/entidad/usuarios/'.Auth::user()->documentoUsuario.'.jpg');
}
else
{
    $foto = asset('img/avatar-profile.png');
}

$inicioSesion = DB::table('juribitacoras')
                ->where('usuarios_idUsuario', '=', $idUsuario)
                ->where('juritiposbitacoras_idTipoBitacora', '=', 1)
                ->orderBy('idBitacora', 'desc')
                ->skip(1)
                ->take(1)
                ->get();

$rolResponsable = DB::table('juriresponsables')
                ->where('idResponsable', '=', $idResponsableSession)
                ->get();

$responsables = DB::table('juriresponsables')
                ->join('usuarios', 'juriresponsables.usuarios_idUsuario', '=', 'usuarios.idUsuario')
                ->where('juriperfiles_idPerfil', '=', 3)// abogados
                ->where('estadoResponsable', '=', 1)
                ->orderBy('usuarios.nombresUsuario', 'ASC')
                ->get();

$cantidadBuzon = DB::table('juriestadosetapas')
                    ->whereIn('juriresponsables_idResponsable', $idsResponsableBuzon)
                    ->where('juritipoestadosetapas_idTipoEstadoEtapa', '=', 1)// tipo estado actual
                    ->where('leidoEstado', '=', 0)// no se ha leído
                    ->count();
@endphp
<head>
    <meta name="robots" content="noindex">
    <meta charset="utf-8">
    <meta name="base_url" content="{{ URL::to('/') }}">
    <meta name="id_usuario" content="{{ Session::get('idUsuario') }}">
    <meta name="ciud_ope" content="{{ Util::traerCiudadOperacion() }}">
    <meta name="limite_archivos" content="{{ $entidad->limiteArchivos }}">
    <meta name="dominio" content="{{Config::get('app.NODE_DOMINIO')}}">
    <meta name="puerto" content="{{Config::get('app.NODE_PUERTO')}}">
    <meta name="ruta_migracion" content="https://localhost/mnt/disks/particion3/files_demandas">
    <meta name="DOCUMENT_ROOT" content="{{$_SERVER['DOCUMENT_ROOT']}}">

    
    <title>{{ config('app.name', 'litiGo') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <!--<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">-->

    <!-- #CSS Links -->
    <!-- Fresh-table -->
    <style>
        .menu_activo{
            border-right-color: #333;
            border-left-color: #333;
            background: #fff;
            background: -moz-linear-gradient(top, #04070c 0, #2e3e57 66%);
            background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #cfcfcf), color-stop(66%, #2e3e57));
            background: -webkit-linear-gradient(top, #04070c 0, #2e3e57 66%);
            background: -o-linear-gradient(top, #04070c 0, #2e3e57 66%);
            background: -ms-linear-gradient(top, #04070c 0, #2e3e57 66%);
            background: linear-gradient(to bottom, #04070c, #2e3e57 66%);
            filter: progid: DXImageTransform.Microsoft.gradient(startColorstr='#04070C', endColorstr='#2E3E57', GradientType=0);
        }
        .noLeido{
            font-weight: bold;
        }
    </style>
    <link href="{{ asset('fresh-bootstrap-table/css/fresh-bootstrap-table.css?v=2')}}" rel="stylesheet" type="text/css"/>
    <!-- Basic Styles -->
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('css/bootstrap.min.css?v=2') }}">
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('css/font-awesome.min.css') }}">

    <!-- SmartAdmin Styles : Caution! DO NOT change the order -->
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('css/smartadmin-production-plugins.min.css?v=4') }}">
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('css/smartadmin-production.min.css?v=3') }}">
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('css/smartadmin-skins.min.css') }}">

    <!-- SmartAdmin RTL Support -->
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('css/smartadmin-rtl.min.css') }}">

    <!-- We recommend you use "your_style.css" to override SmartAdmin
         specific styles this will also ensure you retrain your customization with each SmartAdmin update.
    <link rel="stylesheet" type="text/css" media="screen" href="css/your_style.css"> -->

    <!-- Demo purpose only: goes with demo.js, you can delete this css when designing your own WebApp -->
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('css/demo.min.css') }}">

    <!-- #FAVICONS -->
    <link rel="shortcut icon" href="{{ asset('img/favicon/favicon.png') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('img/favicon/favicon.png') }}" type="image/x-icon">

    <!-- #GOOGLE FONT -->
    <link rel="stylesheet" href="{{ asset('css/fonts.googleapis.css') }}">
    <!-- SWEETALERT -->
    <link href="{{ asset('css/sweetalert.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('vendors/bower_components/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="{{asset('css/jquery.loadingModal.css')}}">
    <link href="{{ asset('vendors/bower_components/dropzone/dist/dropzone.css')}}" rel="stylesheet" type="text/css"/>
    <!-- PRETTY-CHECKBOX -->
    <link href="{{ asset('css/pretty-checkbox.min.css')}}" rel="stylesheet" type="text/css"/>     
    <style>
        #listaAbogados{
            max-height: 550px;
            overflow-y: scroll;
        }
    </style>
    @yield('cabecera')
</head>
    <!--

    TABLE OF CONTENTS.

    Use search to find needed section.

    ===================================================================

    |  01. #CSS Links                |  all CSS links and file paths  |
    |  02. #FAVICONS                 |  Favicon links and file paths  |
    |  03. #GOOGLE FONT              |  Google font link              |
    |  04. #APP SCREEN / ICONS       |  app icons, screen backdrops   |
    |  05. #BODY                     |  body tag                      |
    |  06. #HEADER                   |  header tag                    |
    |  07. #PROJECTS                 |  project lists                 |
    |  08. #TOGGLE LAYOUT BUTTONS    |  layout buttons and actions    |
    |  09. #MOBILE                   |  mobile view dropdown          |
    |  10. #SEARCH                   |  search field                  |
    |  11. #NAVIGATION               |  left panel & navigation       |
    |  12. #MAIN PANEL               |  main panel                    |
    |  13. #MAIN CONTENT             |  content holder                |
    |  14. #PAGE FOOTER              |  page footer                   |
    |  15. #SHORTCUT AREA            |  dropdown shortcuts area       |
    |  16. #PLUGINS                  |  all scripts and plugins       |

    ===================================================================

    -->

    <!-- #BODY -->
    <!-- Possible Classes

        * 'smart-style-{SKIN#}'
        * 'smart-rtl'         - Switch theme mode to RTL
        * 'menu-on-top'       - Switch to top navigation (no DOM change required)
        * 'no-menu'           - Hides the menu completely
        * 'hidden-menu'       - Hides the main menu but still accessable by hovering over left edge
        * 'fixed-header'      - Fixes the header
        * 'fixed-navigation'  - Fixes the main menu
        * 'fixed-ribbon'      - Fixes breadcrumb
        * 'fixed-page-footer' - Fixes footer
        * 'container'         - boxed layout mode (non-responsive: will not work with fixed-navigation & fixed-ribbon)
    -->
    <body class="desktop-detected menu-on-top pace-done smart-style-1 fixed-header fixed-navigation">

        <!-- #HEADER -->
        <header id="header">
            <div id="logo-group">
                <!-- PLACE YOUR LOGO HERE -->
                <span id="logo"> <img src="{{ asset('img/litigob.png') }}" alt="ligiGo"> </span>
                <!-- END LOGO PLACEHOLDER -->

                <!-- Note: The activity badge color changes when clicked and resets the number to 0
                     Suggestion: You may want to set a flag when this happens to tick off all checked messages / notifications -->
                <span id="activity" class="activity-dropdown"> <i class="fa fa-user"></i> <b class="badge" id="labelContador">  </b> </span>
                <!-- AJAX-DROPDOWN : control this dropdown height, look and feel from the LESS variable file -->
                <div class="ajax-dropdown">
                    <!-- the ID links are fetched via AJAX to the ajax container "ajax-notifications" -->
                    <div class="btn-group btn-group-justified" data-toggle="buttons">
                        <label class="btn btn-default" onclick="tareasInformativas(1);" id="labelHoy">
                            <input type="radio">
                        </label>

                        <label class="btn btn-default" onclick="tareasInformativas(2);" id="labelMañana">
                            <input type="radio">
                        </label>

                        <label class="btn btn-default" onclick="tareasInformativas(3);" id="labelDosDias">
                            <input type="radio">
                        </label>
                    </div>
                    <!-- notification content -->
                    <div class="ajax-notifications custom-scroll">
                        <div class="alert alert-transparent" id="resultadoTareasInformativas">
                            <!-- AJAX -->
                        </div>
                    </div>
                    <!-- end footer -->
                </div>
                <!-- END AJAX-DROPDOWN -->
            </div>
            <!-- #PROJECTS: projects dropdown
            <div class="project-context hidden-xs">
                <span class="label">Procesos:</span>
                <span class="project-selector dropdown-toggle" data-toggle="dropdown">Procesos Recientes <i class="fa fa-angle-down"></i></span>
                Suggestion: populate this list with fetch and push technique
                <ul class="dropdown-menu">
                    <li>
                        <a href="javascript:void(0);">Online e-merchant management system - attaching integration with the iOS</a>
                    </li>
                    <li>
                        <a href="javascript:void(0);">Notes on pipeline upgradee</a>
                    </li>
                    <li>
                        <a href="javascript:void(0);">Assesment Report for merchant account</a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="javascript:void(0);"><i class="fa fa-power-off"></i> Clear</a>
                    </li>
                </ul>
                end dropdown-menu
            </div>
            end projects dropdown -->

            <!-- #TOGGLE LAYOUT BUTTONS -->
            <!-- pulled right: nav area -->
            <div class="pull-right">

                <!-- collapse menu button -->
                <div id="hide-menu" class="btn-header pull-right">
                    <span> <a href="javascript:void(0);" data-action="toggleMenu" title="Collapse Menu"><i class="fa fa-reorder"></i></a> </span>
                </div>
                <!-- end collapse menu -->

                <!-- #MOBILE -->
                <!-- Top menu profile link : this shows only when top menu is active -->
                <ul id="mobile-profile-img" class="header-dropdown-list hidden-xs padding-5">
                    <li class="">
                        <a href="#" class="dropdown-toggle no-margin userdropdown" data-toggle="dropdown">
                            <img src="{{$foto}}" alt="John Doe" class="online" />
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li>
                                <a href="#" onclick="cambiarPass();" class="padding-10 padding-top-0 padding-bottom-0"><i class="fa fa-cog"></i> Cambiar Contraseña</a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#" onclick="actualizarPerfil();" class="padding-10 padding-top-0 padding-bottom-0"> <i class="fa fa-user"></i> <u>P</u>erfil</a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="{{ route('logout') }}" class="padding-10 padding-top-5 padding-bottom-5" data-action="userLogout">
                                    <i class="fa fa-sign-out fa-lg"></i> <strong><u>C</u>errar Sesión</strong>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>

                <!-- logout button -->
                <div id="logout" class="btn-header transparent pull-right">
                    <span> <a href="login.html" title="Sign Out" data-action="userLogout" data-logout-msg="Yxxxou can improve your security further after logging out by closing this opened browser"><i class="fa fa-sign-out"></i></a> </span>
                </div>
                <!-- end logout button -->

                <!-- search mobile button (this is hidden till mobile view port) -->
                <div id="search-mobile" class="btn-header transparent pull-right">
                    <span> <a href="javascript:void(0)" title="Search"><i class="fa fa-search"></i></a> </span>
                </div>
                <!-- end search mobile button -->

                <!-- #SEARCH -->
               

                <!-- fullscreen button -->
                <div id="fullscreen" class="btn-header transparent pull-right">
                    <span> <a href="javascript:void(0);" data-action="launchFullscreen" title="Full Screen"><i class="fa fa-arrows-alt"></i></a> </span>
                </div>
                <!-- end fullscreen button -->

                <!-- #Voice Command: Start Speech 
                <div id="speech-btn" class="btn-header transparent pull-right hidden-sm hidden-xs">
                    <div>
                        <a href="javascript:void(0)" title="Voice Command" data-action="voiceCommand"><i class="fa fa-microphone"></i></a>
                        <div class="popover bottom"><div class="arrow"></div>
                            <div class="popover-content">
                                <h4 class="vc-title">Voice command activated <br><small>Please speak clearly into the mic</small></h4>
                                <h4 class="vc-title-error text-center">
                                    <i class="fa fa-microphone-slash"></i> Voice command failed
                                    <br><small class="txt-color-red">Must <strong>"Allow"</strong> Microphone</small>
                                    <br><small class="txt-color-red">Must have <strong>Internet Connection</strong></small>
                                </h4>
                                <a href="javascript:void(0);" class="btn btn-success" onclick="commands.help()">See Commands</a>
                                <a href="javascript:void(0);" class="btn bg-color-purple txt-color-white" onclick="$('#speech-btn .popover').fadeOut(50);">Close Popup</a>
                            </div>
                        </div>
                    </div>
                </div>
                end voice command -->

                @if($rolResponsable[0]->permiso == 1)
                    <!-- multiple lang dropdown : find all flags in the flags page -->
                    <ul class="header-dropdown-list hidden-xs">
                        <li>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span> Abogados </span> <i class="fa fa-angle-down"></i> </a>
                            <ul class="dropdown-menu pull-right" id="listaAbogados">
                                @foreach($responsables as $responsable)
                                    @php
                                        $fotoAbogado = '../public/juriArch/entidad/usuarios/'.$responsable->documentoUsuario.'.jpg';
                                        if(file_exists($fotoAbogado))
                                        {
                                            $fotoAbogado = asset('juriArch/entidad/usuarios/'.$responsable->documentoUsuario.'.jpg');
                                        }
                                        else
                                        {
                                            $fotoAbogado = asset('img/avatar-profile.png');
                                        }

                                        //$nombre = ucfirst(strtolower(explode(" ", $responsable->nombresUsuario)[0]));
                                        $nombre = strtoupper($responsable->nombresUsuario);
                                    @endphp

                                    <li>
                                        <a href="{{ asset('mis-procesos/index/0/0/'.$responsable->idResponsable) }}">
                                            <img src="{{$fotoAbogado}}" class="flag flag-fr" alt="France"> {{$nombre}}
                                            <span style="font-weight:bold">{{Util::cantidadCargaAbogado($responsable->idResponsable)}}</span>
                                        </a>
                                        
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    </ul>
                    <!-- end multiple lang -->
                @endif
            </div>
            <!-- end pulled right: nav area -->
        </header>
        <!-- END HEADER -->

        <!-- #NAVIGATION -->
        <!-- Left panel : Navigation area -->
        <!-- Note: This width of the aside area can be adjusted through LESS variables -->
        <aside id="left-panel">

            <!-- User info -->
            <div class="login-info">
                <span> <!-- User image size is adjusted inside CSS, it should stay as it -->

                    <a href="javascript:void(0);" id="show-shortcut" data-action="toggleShortcut">
                        <img src="{{$foto}}" alt="me" class="online" />
                        <span>
                            {{$nombreUsuario}}
                        </span>
                        <i class="fa fa-angle-down"></i>
                    </a>

                </span>
            </div>
            <!-- end user info -->

            <nav>
                <!--
                NOTE: Notice the gaps after each icon usage <i></i>..
                Please note that these links work a bit different than
                traditional href="" links. See documentation for details.
                -->

                <ul>
                    <li class="nav-item">
                        <a href="{{ asset('home') }}" title="Dashboard"><i class="fa fa-lg fa-fw fa-home"></i> <span class="menu-item-parent">Inicio</span></a>
                    </li>
                    <li class="top-menu-invisible">
                        <a href="#"><i class="fa fa-lg fa-fw fa-cube txt-color-blue"></i> <span class="menu-item-parent">SmartAdmin Intel</span></a>
                        <ul>
                            <li class="">
                                <a href="layouts.html" title="Dashboard"><i class="fa fa-lg fa-fw fa-gear"></i> <span class="menu-item-parent">App Layouts</span></a>
                            </li>
                            <li class="">
                                <a href="skins.html" title="Dashboard"><i class="fa fa-lg fa-fw fa-picture-o"></i> <span class="menu-item-parent">Prebuilt Skins</span></a>
                            </li>
                            <li>
                                <a href="applayout.html"><i class="fa fa-cube"></i> App Settings</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ asset('buzon/index/') }}"><i class="fa fa-lg fa-fw fa-inbox"></i> <span class="menu-item-parent">Buzón</span> <span class="badge pull-right inbox-badge margin-right-13" id="textoPendientesMaster">{{$cantidadBuzon}}</span></a>
                    </li>
                    @if($rolResponsable[0]->permiso == 1 || $rolResponsable[0]->juriroles_idRol == 1)
                        <li class="nav-item">
                            <a href="{{ asset('demandas/index') }}"><i class="fa fa-lg fa-fw fa-keyboard-o"></i> <span class="menu-item-parent">Radicación</span></a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ asset('despachado/index') }}"><i class="fa fa-lg fa-fw fas fa-angle-double-right"></i> <span class="menu-item-parent">Despachados</span></a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ asset('terminados/index') }}"><i class="fa fa-lg fa-fw fas fa-flag-checkered"></i> <span class="menu-item-parent">Terminados</span></a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ asset('apoderados/index') }}"><i class="fa fa-pencil-square-o"></i> <span class="menu-item-parent">Apoderados</span></a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a href="{{ asset('mis-procesos/index/0/0/'.$idResponsableSession) }}"><i class="fa fa-lg fa-fw fa-gavel"></i> <span class="menu-item-parent">Mis Procesos</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="#"><i class="fa fa-lg fa-fw fa-bar-chart-o"></i> <span class="menu-item-parent">Reportes</span></a>
                        <ul>
                            <li>
                                <a href="{{ asset('reportes/index/1') }}">Medios de control</a>
                            </li>
                            <li>
                                <a href="{{ asset('reportes/index/2') }}">Acciones de Procesos</a>
                            </li>
                            <li>
                                <a href="{{ asset('reportes/index/3') }}">Reportes por Funcionarios</a>
                            </li>
                            <li>
                                <a href="{{ asset('reportes/index/4') }}">Estados de Procesos</a>
                            </li>
                            <li>
                                <a href="{{ asset('reportes/index/5') }}">Abogados demandantes</a>
                            </li>
                            <li>
                                <a href="{{ asset('reportes/index/6') }}">Demandantes</a>
                            </li>
                            <li>
                                <a href="{{ asset('reportes/index/7') }}">Despachos - Juzgados</a>
                            </li>
                            <li>
                                <a href="{{ asset('reportes/index/8') }}">Secretaría Vinculada</a>
                            </li>
                            <li>
                                <a href="{{ asset('reportes/index/9') }}">Tipos de actuaciones</a>
                            </li>
                            <li>
                                <a href="{{ asset('reportes/index/10') }}">Valoraciones de fallo</a>
                            </li>
                            <li>
                                <a href="{{ asset('reportes/index/11') }}">Temas</a>
                            </li>
                            <li>
                                <a href="{{ asset('reportes/index/12') }}">Fallos instancias</a>
                            </li>
                            <li>
                                <a href="{{ asset('reportes/index/13') }}">Demandas Terminadas</a>
                            </li>
                            <li>
                                <a href="{{ asset('reportes/index/14') }}">Asuntos</a>
                            </li>

                            <li>
                                <a href="{{ asset('reportes/crear-reporte') }}">Crear informe <span style="background:#61DAFB;color:#fff;padding: 1px 4px;font-size:0.8em;border-radius:4px;">Nuevo</span></a>
                            </li>
                        </ul>
                    </li>
                    @if($rolResponsable[0]->juriroles_idRol == 4 || $rolResponsable[0]->juriroles_idRol == 1 || $rolResponsable[0]->juriroles_idRol == 2)
                        @if($rolResponsable[0]->juriroles_idRol == 4)
                        <li class="nav-item">
                            <a href="#"><i class="fa fa-lg fa-fw fa-wrench"></i> <span class="menu-item-parent">Administración</span></a>
                            <ul>
                                <li>
                                    <a href="{{ asset('cargos/index') }}">Cargos</a>
                                </li>
                                <li>
                                    <a href="{{ asset('dependencias/index') }}">Dependencias</a>
                                </li>
                                <li>
                                    <a href="{{ asset('usuarios/index') }}">Usuarios</a>
                                </li>
                                <li>
                                    <a href="{{ asset('puntoatencion/index') }}">Puntos de atención</a>
                                </li>
                            </ul>
                        </li>
                        @endif
                    
                        <li class="nav-item">
                            <a href="#"><i class="fa fa-lg fa-fw fa-puzzle-piece"></i> <span class="menu-item-parent">Configuración</span></a>
                            <ul>
                                @if($rolResponsable[0]->juriroles_idRol == 4)
                                <li>
                                    <a href="{{ asset('accionesDefensa/index') }}">Acciones de defensa</a>
                                </li>
                                
                                <li>
                                    <a href="{{ asset('estadosRadicado/index') }}">Estados del radicado</a>
                                </li>
                                @endif
                                <li>
                                    <a href="{{ asset('temas/index') }}">Temas</a>
                                </li>
                                <li>
                                    <a href="{{ asset('temas/masivo') }}">Establecer Temas Masivos <span style="color:red; font-weight:600">Nuevo</span></a>
                                </li>
                                <li>
                                    <a href="{{ asset('juzgados/index') }}">Juzgados <span style="color:red; font-weight:600">Nuevo</span></a>
                                </li>
                                @if($rolResponsable[0]->juriroles_idRol == 4)
                                <li>
                                    <a href="{{ asset('causas/index') }}">Causas de los hechos</a>
                                </li>
                                <li>
                                    <a href="{{ asset('perfiles/index') }}">Perfiles</a>
                                </li>
                                <li>
                                    <a href="{{ asset('tipoBitacoras/index') }}">Tipos Bitacoras</a>
                                </li>
                                <li>
                                    <a href="{{ asset('estadosEtapas/index') }}">Estados de la etapa</a>
                                </li>
                                <li>
                                    <a href="{{ asset('responsables/index') }}">Responsables</a>
                                </li>
                                @endif
                                <li>
                                    <a href="{{ asset('tiposProcesos/index') }}">Tipos de procesos</a>
                                </li>
                                @if($rolResponsable[0]->juriroles_idRol == 4)
                                <li>
                                    <a href="{{ asset('tiposImpactos/index') }}">Impactos de procesos</a>
                                </li>
                                <li>
                                    <a href="{{ asset('tiposActosAdmin/index') }}">Actos administrativos</a>
                                </li>
                                @endif
                                <li>
                                    <a href="{{ asset('mediosControl/index') }}">Medios de control</a>
                                </li>
                                @if($rolResponsable[0]->juriroles_idRol == 4)
                                <li>
                                    <a href="{{ asset('autoridades/index') }}">Autoridades</a>
                                </li>
                                <li>
                                    <a href="{{ asset('ipc/index') }}">IPC</a>
                                </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a href="{{ asset('agenda/index') }}"><i class="fa fa-lg fa-fw fa-calendar"></i> <span class="menu-item-parent">Agenda</span></a>
                    </li>
                    
                    @if (Session::get('responsable')->generarOficios == 1)
                        <li class="nav-item">
                            <a href="{{ asset('oficio/index') }}"><i class="fa fa-lg fa-fw fa fa-file-word-o"></i> <span class="menu-item-parent">Oficios</span></a>
                        </li>                        
                    @endif
                    <li class="nav-item">
                        <a href="{{ asset('juridica/buscar') }}"><i class="fa fa-lg fa-fw fa-search"></i> <span class="menu-item-parent">Buscar</span></a>
                    </li>
                </ul>
            </nav>

            <span class="minifyme" data-action="minifyMenu">
                <i class="fa fa-arrow-circle-left hit"></i>
            </span>
        </aside>
        <!-- END NAVIGATION -->

        <!-- MAIN PANEL -->
        <div id="main" role="main">
            @yield('contenido')
        </div>
        <!-- END MAIN PANEL -->

        <!-- PAGE FOOTER -->
        <div class="page-footer">
            <div class="row">
                <div class="col-xs-12 col-sm-6">
                    <span class="txt-color-white">litíGo <span class="hidden-xs"> - Un producto de SyQual 10 S.A.S</span> © {{date('Y')}}</span>
                </div>

                @if(count($inicioSesion) > 0)
                    @php 
                        $dt = $carbon->parse($inicioSesion[0]->fechaBitacora);
                    @endphp

                    <div class="col-xs-6 col-sm-6 text-right hidden-xs">
                        <div class="txt-color-white inline-block">
                            <i class="txt-color-blueLight hidden-mobile">Último inicio de sesion <i class="fa fa-clock-o"></i> <strong>{{$dt->diffForHumans()}}</strong> </i>
                            <!--
                            <div class="btn-group dropup">
                                <button class="btn btn-xs dropdown-toggle bg-color-blue txt-color-white" data-toggle="dropdown">
                                    <i class="fa fa-link"></i> <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu pull-right text-left">
                                    <li>
                                        <div class="padding-5">
                                            <p class="txt-color-darken font-sm no-margin">Download Progress</p>
                                            <div class="progress progress-micro no-margin">
                                                <div class="progress-bar progress-bar-success" style="width: 50%;"></div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <div class="padding-5">
                                            <p class="txt-color-darken font-sm no-margin">Server Load</p>
                                            <div class="progress progress-micro no-margin">
                                                <div class="progress-bar progress-bar-success" style="width: 20%;"></div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <div class="padding-5">
                                            <p class="txt-color-darken font-sm no-margin">Memory Load <span class="text-danger">*critical*</span></p>
                                            <div class="progress progress-micro no-margin">
                                                <div class="progress-bar progress-bar-danger" style="width: 70%;"></div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <div class="padding-5">
                                            <button class="btn btn-block btn-default">refresh</button>
                                        </div>
                                    </li>
                                </ul>
                            </div>-->
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <!-- END PAGE FOOTER -->

        <!-- SHORTCUT AREA : With large tiles (activated via clicking user name tag)
        Note: These tiles are completely responsive,
        you can add as many as you like
        -->
        <div id="shortcut">
            <ul>
                <li>
                    <a href="inbox.html" class="jarvismetro-tile big-cubes bg-color-blue"> <span class="iconbox"> <i class="fa fa-envelope fa-4x"></i> <span>Mail <span class="label pull-right bg-color-darken">14</span></span> </span> </a>
                </li>
                <li>
                    <a href="calendar.html" class="jarvismetro-tile big-cubes bg-color-orangeDark"> <span class="iconbox"> <i class="fa fa-calendar fa-4x"></i> <span>Calendar</span> </span> </a>
                </li>
                <li>
                    <a href="gmap-xml.html" class="jarvismetro-tile big-cubes bg-color-purple"> <span class="iconbox"> <i class="fa fa-map-marker fa-4x"></i> <span>Maps</span> </span> </a>
                </li>
                <li>
                    <a href="invoice.html" class="jarvismetro-tile big-cubes bg-color-blueDark"> <span class="iconbox"> <i class="fa fa-book fa-4x"></i> <span>Invoice <span class="label pull-right bg-color-darken">99</span></span> </span> </a>
                </li>
                <li>
                    <a href="gallery.html" class="jarvismetro-tile big-cubes bg-color-greenLight"> <span class="iconbox"> <i class="fa fa-picture-o fa-4x"></i> <span>Gallery </span> </span> </a>
                </li>
                <li>
                    <a href="profile.html" class="jarvismetro-tile big-cubes selected bg-color-pinkDark"> <span class="iconbox"> <i class="fa fa-user fa-4x"></i> <span>My Profile </span> </span> </a>
                </li>
            </ul>
        </div>
        <!-- END SHORTCUT AREA -->

        <!--================================================== -->

        <!-- PACE LOADER - turn this on if you want ajax loading to show (caution: uses lots of memory on iDevices)-->
        <script data-pace-options='{ "restartOnRequestAfter": true }' src="{{asset('js/plugin/pace/pace.min.js')}}"></script>

        <!-- Link to Google CDN's jQuery + jQueryUI; fall back to local -->
        <script src="{{asset('js/ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js')}}"></script>
        <script>
            if (!window.jQuery) {
                document.write('<script src="{{asset("js/libs/jquery-3.2.1.min.js")}}"><\/script>');
            }
        </script>

        <script src="{{asset('js/ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js')}}"></script>
        <script>
            if (!window.jQuery.ui) {
                document.write('<script src="{{asset("js/libs/jquery-ui.min.js")}}"><\/script>');
            }
        </script>

        <!-- IMPORTANT: APP CONFIG -->
        <script src="{{ asset('js/app.config.js') }}"></script>

        <!-- JS TOUCH : include this plugin for mobile drag / drop touch events-->
        <script src="{{ asset('js/plugin/jquery-touch/jquery.ui.touch-punch.min.js') }}"></script>

        <!-- BOOTSTRAP JS -->
        <script src="{{ asset('js/bootstrap/bootstrap.min.js') }}"></script>

        <!-- CUSTOM NOTIFICATION -->
        <script src="{{ asset('js/notification/SmartNotification.min.js') }}"></script>

        <!-- JARVIS WIDGETS -->
        <script src="{{ asset('js/smartwidgets/jarvis.widget.min.js') }}"></script>

        <!-- EASY PIE CHARTS -->
        <script src="{{ asset('js/plugin/easy-pie-chart/jquery.easy-pie-chart.min.js') }}"></script>

        <!-- SPARKLINES -->
        <script src="{{ asset('js/plugin/sparkline/jquery.sparkline.min.js') }}"></script>

        <!-- JQUERY VALIDATE -->
        <script src="{{ asset('js/plugin/jquery-validate/jquery.validate.min.js') }}"></script>

        <!-- JQUERY MASKED INPUT -->
        <script src="{{ asset('js/plugin/masked-input/jquery.maskedinput.min.js') }}"></script>

        <!-- JQUERY SELECT2 INPUT -->
        <script src="{{ asset('js/plugin/select2/select2.min.js') }}"></script>

        <!-- JQUERY UI + Bootstrap Slider -->
        <script src="{{ asset('js/plugin/bootstrap-slider/bootstrap-slider.min.js') }}"></script>

        <!-- browser msie issue fix -->
        <script src="{{ asset('js/plugin/msie-fix/jquery.mb.browser.min.js') }}"></script>

        <!-- FastClick: For mobile devices -->
        <script src="{{ asset('js/plugin/fastclick/fastclick.min.js') }}"></script>

        <!--[if IE 8]>

        <h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1>

        <![endif]-->

        <!-- Demo purpose only -->
        <script src="{{ asset('js/demo.min.js') }}"></script>

        <!-- MAIN APP JS FILE -->
        <script src="{{ asset('js/app.min.js') }}"></script>

        <!-- ENHANCEMENT PLUGINS : NOT A REQUIREMENT -->
        <!-- Voice command : plugin -->
        <script src="{{ asset('js/speech/voicecommand.min.js') }}"></script>

        <!-- SmartChat UI : plugin -->
        <script src="{{ asset('js/smart-chat-ui/smart.chat.ui.min.js') }}"></script>
        <script src="{{ asset('js/smart-chat-ui/smart.chat.manager.min.js') }}"></script>

        <script src="{{ asset('js/sweetalert.min.js') }}"></script>
        <script src="{{ asset('js/sweetalert-data.js') }}"></script>

        <script src="{{ asset('vendors/bower_components/moment/min/moment.min.js')}}"></script>
        <script src="{{ asset('vendors/bower_components/moment/min/moment-with-locales.min.js')}}"></script>
        <script src="{{ asset('vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js')}}"></script>
        <script src="{{ asset('vendors/bower_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>


        <script src="{{ asset('js/plugin/datatables/dataTables.tableTools.min.js') }}"></script>
        <script src="{{ asset('js/plugin/datatables/jquery.dataTables.js') }}"></script>
        <script src="{{ asset('js/plugin/datatable-responsive/datatables.responsive.min.js') }}"></script>

        <script src="{{ asset('js/plugin/morris/raphael.min.js') }}"></script>
        <script src="{{ asset('js/plugin/morris/morris.min.js') }}"></script>
        <script src="{{ asset('js/jquery.loadingModal.js?v=1') }}"></script>


        <script src="{{ asset('vendors/bower_components/dropzone/dist/dropzone.js')}}"></script>
        <script src="{{ asset('js/dropzone-data.js')}}"></script>
        <!-- Fresh-table -->
        <script src="{{ asset('fresh-bootstrap-table/js/bootstrap-table.js')}}"></script>
        <!-- #Socket io -->
        <script src="{{Config::get('app.NODE_DOMINIO')}}:{{Config::get('app.NODE_PUERTO')}}/socket.io/socket.io.js"></script>    
        <!-- PAGE RELATED PLUGIN(S)
        <script src="..."></script>-->

        <script>
            $(document).ready(function() {
                 pageSetUp();
            });
        </script>
        <script src="{{asset('js/js_comunes/comunes.js?v='.rand(1,1000))}}"></script>
        <!-- MODAL -->
        <!-- Visor de archivos en pdf -->
        <div class="modal fade in bs-example-modal-lg" id="modalPdfGenerado">
            <div class="modal-dialog modal-lg" style="margin-top:5px; max-width:100%;">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="myLargeModalLabel"><i class="fa fa-fw fa-cloud-upload"></i> VISOR DE ARCHIVOS<h4>
                    </div>
                    <div class="modal-body">
                        <iframe id="framePdf" style="width: 100%;height: 100vh;"></iframe>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-sm-11">
                                <button type="button" class="btn btn-primary pull-right" data-dismiss="modal">Cerrar esta ventana</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- # Visor de archivos en pdf -->

        <!-- CAMBIAR PASS-->
        <div class="modal fade"  id="modalCambiarPass" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h5 class="modal-title" id="myModalLabel">Cambiar Contraseña</h5>
                    </div>
                    <div id="resultadoCambiarPass">
                      <!-- CONTENIDO AJAX -->
                    </div>
                </div>
            </div>
        </div>
        <!--# CAMBIAR PASS-->

        <!-- MODIFICAR PERFIL -->
        <div class="modal fade"  id="modalActualizarPerfil" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h5 class="modal-title" id="myModalLabel">Editar Datos</h5>
                    </div>
                    <div id="resultadoActualizarPerfil">
                      <!-- CONTENIDO AJAX -->
                    </div>
                </div>
            </div>
        </div>
        <!--# MODIFICAR PERFIL -->

        <!-- REPARTO INTERNO -->
        <div class="modal fade"  id="modalRepartoInterno" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h5 class="modal-title" id="myModalLabel">Reparto Interno</h5>
                    </div>
                    <div id="resultadoRepartoInterno">
                      <!-- CONTENIDO AJAX -->
                    </div>
                </div>
            </div>
        </div>
        <!--# REPARTO INTERNO -->


        <!-- modalAsociarProceso -->
        <div class="modal fade"  id="modalAsociarProceso" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h5 class="modal-title" id="myModalLabel">Asociar </h5>
                    </div>
                    <div id="resultadoAsociarProceso">
                      <!-- CONTENIDO AJAX -->
                    </div>
                </div>
            </div>
        </div>
        <!--# REPARTO modalAsociarProceso -->

        <!-- AGREGAR CUANTÍA NUEVA -->
        <div class="modal fade"  id="modalAgregarCuantia" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h5 class="modal-title" id="myModalLabel">Nueva Cuantía</h5>
                    </div>
                    <div id="resultadoAgregarCuantia">
                      <!-- CONTENIDO AJAX -->
                    </div>
                </div>
            </div>
        </div>
        <!-- # AGREGAR CUANTÍA NUEVA -->

        <!-- AGREGAR CUANTÍA NUEVA -->
        <div class="modal fade"  id="modalAgregarDepenProceso" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h5 class="modal-title" id="myModalLabel">Nueva Dependencia al Proceso</h5>
                    </div>
                    <div id="resultadoAgregarDepenProceso">
                      <!-- CONTENIDO AJAX -->
                    </div>
                </div>
            </div>
        </div>
        <!-- # AGREGAR CUANTÍA NUEVA -->

        <!-- AGREGAR Nuevo Externo -->
        <div class="modal fade"  id="modalNuevoExterno" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h5 class="modal-title" id="myModalLabel">Nueva Entidad Externa al Proceso</h5>
                    </div>
                    <div id="resultadoNuevoExterno">
                      <!-- CONTENIDO AJAX -->
                    </div>
                </div>
            </div>
        </div>
        <!-- # AGREGAR Nuevo Externo -->

        <!-- EDITAR Nuevo Externo -->
        <div class="modal fade"  id="modalEditarExterno" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h5 class="modal-title" id="myModalLabel">Modificar Entidad Externa al Proceso</h5>
                    </div>
                    <div id="resultadoEditarExterno">
                      <!-- CONTENIDO AJAX -->
                    </div>
                </div>
            </div>
        </div>
        <!-- # EDITAR Nuevo Externo -->

        <!-- AGREGAR NUEVO ABOGADO EXT -->
        <div class="modal fade"  id="modalNuevoAbogadoEx" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h5 class="modal-title" id="myModalLabel">Nueva Abogado Externo al Proceso</h5>
                    </div>
                    <div id="resultadoAbogadoNuevoExterno">
                      <!-- CONTENIDO AJAX -->
                    </div>
                </div>
            </div>
        </div>
        <!-- # AGREGAR NUEVO ABOGADO EXT -->

        <!-- EDITAR NUEVO ABOGADO EXT -->
        <div class="modal fade"  id="modalEditarAbogadoExt" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h5 class="modal-title" id="myModalLabel">Editar Abogado Externo al Proceso</h5>
                    </div>
                    <div id="resultadoAbogadoEditExt">
                      <!-- CONTENIDO AJAX -->
                    </div>
                </div>
            </div>
        </div>
        <!-- # EDITAR NUEVO ABOGADO EXT -->

        <!-- AGREGAR APODERADO NUEVO AL PROCESO-->
        <div class="modal fade"  id="modalAgregarApoderadoNuevo" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h5 class="modal-title" id="myModalLabel">Agregar nuevo apoderado al proceso</h5>
                    </div>
                    <div id="resultadoAgregarApoderaoNuevo">
                      <!-- CONTENIDO AJAX -->
                    </div>
                </div>
            </div>
        </div>
        <!--# AGREGAR APODERADO NUEVO AL PROCESO-->


        

        <!-- MODAL AVISO SUSPENSION DE LICENCIA -->
        <div class="modal fade" id="modalMensajeSuspension" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog" style="max-width:50%;">
            <div class="modal-content" style="background: #000;">
                <div class="modal-body">  
                    <img src="{{asset('assets/images/aviso-suspension.png')}}" style="width: 100%;"/>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-inverse" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
            </div>
        </div>
        <!-- MODAL AVISO DE SUSPENSION -->


        <!--# MODAL -->
        @yield("scriptsFin")        
        <script src="{{ asset('realtime/listens_realtime.js?v=5') }}"></script>
        <script type="text/javascript">
            $(window).on('load', function() {
                tareasInformativas(1);

                /*$('#modalMensajeSuspension').modal({
                    show: true,
                    keyboard: false,
                    backdrop: 'static'
                })*/
            });
            
    </script>
    <script>
        document.querySelectorAll(".nav-item a").forEach((link) => {
    if (link.href === window.location.href) {
        link.parentNode.classList.add("active")
        link.parentNode.classList.add("menu_activo")
    }                
});
    </script>
    </body>
</html>
