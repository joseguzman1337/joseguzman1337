<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../../../../../assets/Complementos/piepagina.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
        <link type="text/css" rel="stylesheet" href="../../../../../assets/css/bootstrap.css">
        <!-- pie de pagina-->
        <link type="text/css" rel="stylesheet" href="../../../../../assets/css/font-page.css">
        <link type="text/css" rel="stylesheet" href="../../../../../assets/css/font-awesome.css">
        <link type="text/css" rel="stylesheet" href="../../../../../assets/css/custom.css">
        <link type="text/css" rel="stylesheet" href="../../../../../assets/css/general.css">
        <!-- pie de pagina-->
        <!-- sweet alert-->
        <link type="text/css" rel="stylesheet" href="../../../../../assets/css/sweetalert.css" rel="stylesheet"/>
        <script type="text/javascript" src="../../../../../assets/js/sweetalert.min.js"></script>
        <!-- sweet alert-->
        <script type="text/javascript" src="../../../../../sala/assets/js/jquery-3.1.1.js"></script>
        <script type="text/javascript" src="../../../../../sala/assets/js/bootstrap.js"></script>
        <script type="text/javascript" src="../assets/consultaUsuarios.js"></script>
    </head>
<body>
<header id="header" role="banner">
    <div class="header-inner">
        <div class="header_first">
            <div class="block block-system block-system-branding-block">
                <div class="block-inner">
                    <div class="title-suffix"></div>
                    <a href="http://www.uelbosque.edu.co" title="Inicio" rel="home">
                        <img alt="Universidad El Bosque" src="../../../../../assets/ejemplos/img/logo.png">
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
<br><br><br><br>
<div class="container">
    <div class="row centered-form">
        <div class="panel-body form-group">
            <!-- formulario -->
            <div class="panel-body">
                <div class="panel widget">
                    <div class="widget-body text-center">
                        <img alt="Profile Picture" class="widget-img img-circle img-border-light"
                             src="../../../../../sala/assets/img/av2.png">
                        <h2 class="mar-no">Consulta usuario de estudiante</h2>
                    </div>
                </div>
                <form id="consultar_form" name="consultar_form" method="post" novalidate="novalidate">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Fecha de nacimiento</label>
                            <input type="date" class="form-control" id="fechanacimiento" name="fechanacimiento">
                        </div>
                        <br>
                        <div class="col-md-6">
                            <input type="text" width="15" class="form-control" id="ndocumento" name="ndocumento"
                                   placeholder="Numero documento">
                        </div>
                        <br>
                        <div class="col-xs-14">
                            <button class="btn btn-fill-green-XL" type="submit" id="consultar_btn">Consultar Datos</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- formulario -->
            <div class="row">
                <div class="div class="col-md-6"" id="resultado"></div>
            </div>
        </div>
    </div>
</div>
<?php
$piepagina = new piepagina;
$ruta='../../../../../';
echo $piepagina->Mostrar($ruta);
?>
</body>
</html>