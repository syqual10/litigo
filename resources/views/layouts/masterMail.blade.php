@php
$pathBanner = public_path().'//assets/images/banner.png';
$path11 = public_path().'//assets/images/img11.png';
$path12 = public_path().'//assets/images/img12.png';
$path13 = public_path().'//assets/images/img13.png';
$path16 = public_path().'//assets/images/img16.jpg';
@endphp
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//ES" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title>@section('titulo') Jurídica @show</title>
        <style type="text/css">
            /* ----- Custom Font Import ----- */
            @import url(https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic&subset=latin,latin-ext);

            /* ----- Text Styles ----- */
            table{
                font-family: 'Lato', Arial, sans-serif;
                -webkit-font-smoothing: antialiased;
                -moz-font-smoothing: antialiased;
                font-smoothing: antialiased;
            }

            @media only screen and (max-width: 700px){
                /* ----- Base styles ----- */
                .full-width-container{
                    padding: 0 !important;
                }

                .container{
                    width: 100% !important;
                }

                /* ----- Header ----- */
                .header td{
                    padding: 30px 15px 30px 15px !important;
                }

                /* ----- Projects list ----- */
                .projects-list{
                    display: block !important;
                }

                .projects-list tr{
                    display: block !important;
                }

                .projects-list td{
                    display: block !important;
                }

                .projects-list tbody{
                    display: block !important;
                }

                .projects-list img{
                    margin: 0 auto 25px auto;
                }

                /* ----- Half block ----- */
                .half-block{
                    display: block !important;
                }

                .half-block tr{
                    display: block !important;
                }

                .half-block td{
                    display: block !important;
                }

                .half-block__image{
                    width: 100% !important;
                    background-size: cover;
                }

                .half-block__content{
                    width: 100% !important;
                    box-sizing: border-box;
                    padding: 25px 15px 25px 15px !important;
                }

                /* ----- Hero subheader ----- */
                .hero-subheader__title{
                    padding: 80px 15px 15px 15px !important;
                    font-size: 35px !important;
                }

                .hero-subheader__content{
                    padding: 0 15px 90px 15px !important;
                }

                /* ----- Title block ----- */
                .title-block{
                    padding: 0 15px 0 15px;
                }

                /* ----- Paragraph block ----- */
                .paragraph-block__content{
                    padding: 25px 15px 18px 15px !important;
                }

                /* ----- Info bullets ----- */
                .info-bullets{
                    display: block !important;
                }

                .info-bullets tr{
                    display: block !important;
                }

                .info-bullets td{
                    display: block !important;
                }

                .info-bullets tbody{
                    display: block;
                }

                .info-bullets__icon{
                    text-align: center;
                    padding: 0 0 15px 0 !important;
                }

                .info-bullets__content{
                    text-align: center;
                }

                .info-bullets__block{
                    padding: 25px !important;
                }

                /* ----- CTA block ----- */
                .cta-block__title{
                    padding: 35px 15px 0 15px !important;
                }

                .cta-block__content{
                    padding: 20px 15px 27px 15px !important;
                }

                .cta-block__button{
                    padding: 0 15px 0 15px !important;
                }
            }


            #tablaAgendaEmail {
                font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
                border-collapse: collapse;
                width: 100%;
            }

            #tablaAgendaEmail td, #tablaAgendaEmail th {
            border: 1px solid #ddd;
            padding: 8px;
            }

            #tablaAgendaEmail tr:nth-child(even){background-color: #f2f2f2;}

            #tablaAgendaEmail tr:hover {background-color: #ddd;}

            #tablaAgendaEmail th {
                padding-top: 9px;
                padding-bottom: 9px;
                text-align: left;
                background-color: #015CAB;
                color: white;
            }
        </style>

        <!--[if gte mso 9]><xml>
            <o:OfficeDocumentSettings>
                <o:AllowPNG/>
                <o:PixelsPerInch>96</o:PixelsPerInch>
            </o:OfficeDocumentSettings>
        </xml><![endif]-->
    </head>

    <body style="padding: 0; margin: 0;" bgcolor="#eeeeee">
        <span style="color:transparent !important; overflow:hidden !important; display:none !important; line-height:0px !important; height:0 !important; opacity:0 !important; visibility:hidden !important; width:0 !important; mso-hide:all;">Tenemos un mensaje importante relacionado con un proceso - </span>

        <!-- / Full width container -->
        <table class="full-width-container" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" bgcolor="#eeeeee" style="width: 100%; height: 100%; padding: 30px 0 30px 0;">
            <tr>
                <td align="center" valign="top">
                    <!-- / 700px container -->
                    <table class="container" border="0" cellpadding="0" cellspacing="0" width="700" bgcolor="#ffffff" style="width: 700px;">
                        <tr>
                            <td align="center" valign="top">                                
                                <!-- / Projects list -->
                                <table class="container projects-list" border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>                                        
                                        <td>
                                            <a href="#">
                                                <img src="<?php echo $message->embed($pathBanner); ?>" width="100%" height="auto" border="0" style="display: block;">
                                            </a>
                                        </td>
                                    </tr>                                               
                                </table>
                                <!-- /// Projects list -->

                                <!-- / CTA Block -->
                                <table class="container cta-block" border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td align="center" valign="top">
                                            @yield('contenido')                                            
                                        </td>
                                    </tr>
                                </table>
                                <!-- /// CTA Block -->

                                <!-- / Divider -->
                                <table class="container" border="0" cellpadding="0" cellspacing="0" width="100%" style="padding-top: 25px;" align="center">
                                    <tr>
                                        <td align="center">
                                            <table class="container" border="0" cellpadding="0" cellspacing="0" width="620" align="center" style="border-bottom: solid 1px #eeeeee; width: 620px;">
                                                <tr>
                                                    <td align="center">&nbsp;</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                                <!-- /// Divider -->

                                <!-- / Footer -->
                                <table class="container" border="0" cellpadding="0" cellspacing="0" width="100%" align="center">
                                    <tr>
                                        <td align="center">
                                            <table class="container" border="0" cellpadding="0" cellspacing="0" width="620" align="center" style="border-top: 1px solid #eeeeee; width: 620px;">
                                                <tr>
                                                    <td style="text-align: center; padding: 50px 0 10px 0;">
                                                        <a href="#" style="font-size: 28px; text-decoration: none; color: #d5d5d5;">litíGo</a>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td align="middle">
                                                        <table width="60" height="2" border="0" cellpadding="0" cellspacing="0" style="width: 60px; height: 2px;">
                                                            <tr>
                                                                <td align="middle" width="60" height="2" style="background-color: #eeeeee; width: 60px; height: 2px; font-size: 1px;"><img src="<?php echo $message->embed($path16); ?>"></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td style="color: #d5d5d5; text-align: center; font-size: 15px; padding: 10px 0 60px 0; line-height: 22px;">&copy; 2019 <a href="https://syqual10.com/" target="_blank" style="text-decoration: none; border-bottom: 1px solid #d5d5d5; color: #d5d5d5;">Un producto de SyQual 10 S.A.S</a>. <br />Todos los Derechos Reservados.</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                                <!-- /// Footer -->
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>