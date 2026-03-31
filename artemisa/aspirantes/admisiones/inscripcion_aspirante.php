<?php
    session_start();
    include('../../assets/Complementos/piepagina.php');

    $lang = "es-es";
    if(isset($_GET["lang"])&&$_GET["lang"]!="") {
        $lang = $_GET["lang"];
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Ingreso Aspirantes Universidad El Bosque</title>
        <link type="text/css" rel="stylesheet" href="../../assets/css/normalize.css">
        <link type="text/css" rel="stylesheet" href="../../assets/css/font-page.css">
        <link type="text/css" rel="stylesheet" href="../../assets/css/font-awesome.css">
        <link type="text/css" rel="stylesheet" href="../../assets/css/general.css">
        <link type="text/css" rel="stylesheet" href="../../assets/css/chosen.css">
        <link type="text/css" rel="stylesheet" href="../../assets/css/custom.css">
        <link type="text/css" rel="stylesheet" href="../../assets/css/bootstrap.css?v=1">
        <link type="text/css" rel="stylesheet" href="../../assets/css/sweetalert.css" />
        <link type="text/css" rel="stylesheet" href="../../assets/css/CenterRadarIndicator/centerIndicator.css" >

        <script type="text/javascript" src="../../assets/js/jquery-3.6.0.min.js"></script>
        <script src="../../assets/js/moment.min.js?v=1"></script>
        <script src="../../assets/js/bootstrap-datetimepicker.min.js?v=1"></script>
        <script src="../../assets/js/bootstrap-datetimepicker.es.js?v=1"></script>
        <script src="../../assets/js/calendar_format.js?v=1"></script>
        <script type="text/javascript" src="../../assets/js/bootbox.min.js"></script>
        <script type="text/javascript" src="../../assets/js/jquery.validate.min.js"></script>
        <script type="text/javascript" src="../../sala/assets/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="../../assets/js/sweetalert.min.js"></script>
        <script type="text/javascript" src="../../assets/js/spiceLoading/pace.min.js"></script>
        <script type="text/javascript" src="js/aspirantes.js"></script>
    </head>
    <body>
        <nav class="navbar">
            <a href="http://www.uelbosque.edu.co" title="Inicio" rel="home">
                <img src="logo-uelbosque.png" width="180" alt="Inicio">
            </a>
        </nav>
        <div class="container">
            <div class="row centered-form">
                <div class="panel-body form-group">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <h1>Ingreso de Aspirantes</h1>
                        </div>
                    </div>
                    <form role="form" id="ingresoAspirante" name="ingresoAspirante" method="post"
                          enctype="multipart/form-data" action="../usuarioaspirante/redireccionaingresousuario.php">
                        <div class="form-group col-xs-12 col-md-12">
                            <div class="form-group col-md-4">
                                <div class="col-xs-12">
                                    <input type="text" name="usuario" id="usuario" size="15"
                                           value="" class="form-control" autocomplete="off"
                                           placeholder="Ingrese el Usuario" required />
                                    <br>
                                    <input type="password" name="clave" id="clave" size="15"
                                            class="form-control" autocomplete="off"
                                            placeholder="Ingrese la Contraseña" />
                                    <input  type="hidden" name="ingresar" id="ingresar" value="ingresar" required/>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                            </div>
                        </div>
                        <div class="form-group col-xs-12 col-md-12">
                            <div class="form-group col-md-12">
                                <div class="col-xs-12">
                                    <input type="button" id="Ingresar" name="Ingresar"
                                           value="Ingresar" class="btn btn-fill-green-XL">
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <div class="col-xs-12">
                                    <a href="../usuarioaspirante/recuperarclave.php">¿Ha olvidado su contraseña? </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <br>
        <br>
        <?php
        $piepagina = new piepagina;
        $ruta='../../';
        echo $piepagina->Mostrar($ruta);
        ?>

<script>
        $(()=>{
                bootbox.confirm({
                    message: "Estimado aspirante: ¿Deseas continuar con tu inscripción a los programas de Contaduría Pública, Finanzas o Marketing y Transformación Digital modalidad virtual?",
                    buttons: {
                        confirm: {
                            label: 'Sí',
                            className: 'btn-success'
                        },
                        cancel: {
                            label: 'No',
                            className: 'btn-danger'
                        }
                    },
                    callback: function (result) {
                        if (result) {
                            
                            const url = window.location.href
                            const urlVirtual = url.replace('artemisa','artemisavirtual');
                                                                                    
                            window.location.href = urlVirtual
                        }
                    }
                });
        })
    </script>
    </body>
</html>