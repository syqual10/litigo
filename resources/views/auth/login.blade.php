<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" id="extr-page">

<!-- Mirrored from smartadmin-html.firebaseapp.com/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 08 Oct 2018 02:12:37 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->
<head>
        <meta name="robots" content="noindex">
        <meta charset="utf-8">
        <title>{{ config('app.name', 'Jurídica') }}</title>
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

        <!-- Basic Styles -->
        <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('css/font-awesome.min.css') }}">

        <!-- SmartAdmin Styles : Caution! DO NOT change the order -->
        <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('css/smartadmin-production-plugins.min.css') }}">
        <link rel="stylesheet" type="text/css" media="screen" href="{{ asset('css/smartadmin-production.min.css') }}">
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
    </head>

    <body class="animated fadeInDown">

        <header id="header">

            <div id="logo-group">
                <span id="logo"> <img src="img/litigo.png" style="height:50px"> </span>
            </div>

            <span id="extr-page-header-space"> <span class="hidden-mobile hiddex-xs">Necesita soporte? Contacte al Administrador</span> <a href="#" class="btn btn-primary">Teléfono 3223366040</a> </span>

        </header>

        <div id="main" role="main">

            <!-- MAIN CONTENT -->
            <div id="content" class="container">

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-7 col-lg-8 hidden-xs hidden-sm">
                    <!--
                        <h1 class="txt-color-primary login-header-big">litíGo | Gestión Jurídica</h1>-->
                        <div class="hero">
                            
                            <div class="pull-left login-desc-box-l">
                                <h4 class="paragraph-header">
                                    Software para la gestión administrativa de los procesos jurídicos y la defensa judicial
                                </h4>
                            </div>
                        </div>

                        <div class="row" style="display: none">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <h5 class="about-heading">El poder de la información</h5>
                                <p>
                                    Gestiona los casos y procesos judiciales de manera eficaz y oportuna.  Genera alertas, recordatorios y programa en la agenda los eventos críticos de cada proceso.  Obtiene el máximo valor de la información que te brinda litíGo.
                                </p>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                <h5 class="about-heading">Comités de Conciliación</h5>
                                <p>
                                    Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi voluptatem accusantium!
                                </p>
                            </div>
                        </div>

                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-5 col-lg-4">
                        <br>
                        <div class="well">

                            <form class="form-horizontal" method="POST" action="{{ route('login') }}" style="margin-top:40px">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('loginUsuario') ? ' has-error' : '' }}">
                            <label for="loginUsuario" class="col-md-4 control-label">Usuario:</label>

                            <div class="col-md-6">
                                <input id="loginUsuario" type="text" class="form-control" name="loginUsuario" value="{{ old('loginUsuario') }}" required autofocus>

                                @if ($errors->has('loginUsuario'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('loginUsuario') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Contraseña:</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Recuérdame
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Iniciar Sesión
                                </button>

                                <a class="btn btn-link" href="{{ route('password.request') }}" style="display: none;">
                                    Olvidó su contraseña?
                                </a>
                            </div>
                        </div>
                    </form>

                        </div>



                    </div>
                </div>
            </div>

        </div>

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

        <!-- JS TOUCH : include this plugin for mobile drag / drop touch events
        <script src="js/plugin/jquery-touch/jquery.ui.touch-punch.min.js"></script> -->

        <!-- BOOTSTRAP JS -->
        <script src="{{ asset('js/bootstrap/bootstrap.min.js') }}"></script>

        <!-- JQUERY VALIDATE -->
        <script src="{{ asset('js/plugin/jquery-validate/jquery.validate.min.js') }}"></script>

        <!-- JQUERY MASKED INPUT -->
        <script src="{{ asset('js/plugin/masked-input/jquery.maskedinput.min.js') }}"></script>

        <!--[if IE 8]>

            <h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1>

        <![endif]-->

        <!-- MAIN APP JS FILE -->
        <script src="{{ asset('js/app.min.js') }}"></script>

        <script>
            runAllForms();

            $(function() {
                // Validation
                $("#login-form").validate({
                    // Rules for form validation
                    rules : {
                        email : {
                            required : true,
                            email : true
                        },
                        password : {
                            required : true,
                            minlength : 3,
                            maxlength : 20
                        }
                    },

                    // Messages for form validation
                    messages : {
                        email : {
                            required : 'Please enter your email address',
                            email : 'Please enter a VALID email address'
                        },
                        password : {
                            required : 'Please enter your password'
                        }
                    },

                    // Do not change code below
                    errorPlacement : function(error, element) {
                        error.insertAfter(element.parent());
                    }
                });
            });
        </script>

    </body>
</html>
