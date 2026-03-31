<?php
require_once(realpath(dirname(__FILE__)."/../../config/Configuration.php"));
require_once(__DIR__."/listado.php");
$Configuration = Configuration::getInstance();
require_once(PATH_SITE.'/lib/Factory.php');
$db = Factory::createDbo();
// obtiene $variablecarrera del url usando GET
if (isset($_REQUEST['carrera']) && !empty($_REQUEST['carrera'])) {
    $variablecarrera = $_REQUEST['carrera'];
}
// obtiene $variablelike del url usando GET
$variablelike = "";
if (isset($_REQUEST['like']) && !empty($_REQUEST['like'])) {
    $variablelike = $_REQUEST['like'];
}
// inicio la variable $sqlcarrera como vacía
$sqlcarrera= "";
if(isset($variablecarrera) && !empty($variablecarrera)){
    $sqlcarrera= " and codigocarrera= '".$variablecarrera."'";
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Interesados U Senior</title>
        <?php
        echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/normalize.css");
        echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/font-page.css");
        echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/font-awesome.css");
        echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/bootstrap.css");
        echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/general.css");
        echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/chosen.css");

        echo Factory::printImportJsCss("js",HTTP_ROOT."/assets/js/jquery-3.6.0.min.js");
        echo Factory::printImportJsCss("js",HTTP_ROOT."/assets/js/chosen.jquery.min.js");
        echo Factory::printImportJsCss("js",HTTP_ROOT."/assets/js/bootstrap.js");
        echo Factory::printImportJsCss("js",HTTP_ROOT."/assets/js/jquery.validate.min.js");
        echo Factory::printImportJsCss("js",HTTP_ROOT."/assets/js/triggerChosen.js");
        echo Factory::printImportJsCss("js",HTTP_ROOT."/assets/js/bootbox.min.js");
        echo Factory::printImportJsCss("js",HTTP_ROOT."/sala/public/assets/js/formularioEdCon.js");
        ?>
    </head>
<body>
    <div class="container">
        <div class="section col-lg-6 col-lg-offset-3">
            <form id="formec" name="formec">
                <div class="row">
                    <img src="../../../assets/icons/correo.svg">
                    <label class="lead"><strong>Quiero recibir más información</strong></label>
                </div>
                <div class="row" style="background: #D9D9D6;"><br>
                    <div style="position:relative;  width: 90%; left: 5%;">
                        <div class="form-group">
                            <label for="Nombres">Nombres:</label>
                            <input type="text" class="form-control" id="Nombres" name="Nombres" placeholder="Nombres Completos" />
                        </div>
                        <div class="form-group">
                            <label for="Apellidos">Apellidos:</label>
                            <input type="text" class="form-control" id="Apellidos" name="Apellidos" placeholder="Apellidos Completo" />
                        </div>
                        <div class="form-group">
                            <label for="Email">Email:</label>
                            <input type="email" class="form-control" id="Email" name="Email" placeholder="Correo Electrónico" />
                        </div>
                        <div class="form-group">
                            <label for="Ciudad">Ciudad:</label>
                            <?php echo listaCiudades(); ?>
                        </div>
                        <div class="form-group">
                            <label for="Telefono">Telefono:</label>
                            <input type="text" class="form-control" id="Telefono" name="Telefono" placeholder="Numero Contacto" />
                        </div>
                        <div class="form-group">
                            <label for="Programa">Programa:</label>
                            <?php echo listaCarreras($sqlcarrera, $variablelike); ?>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-11 col-md-11 col-xs-12 text-left">
                            <label class="form-check-label" for="defaultCheck1">
                                <input class="form-check-input" type="checkbox" name="valida" id="valida" >
                                Autorizo a la Universidad El Bosque para el envío de Información
                                <a class= "text-primary" download="Prueba-UBosque"
                                   href="http://www.uelbosque.edu.co/sites/default/files/documentos/politica_privacidad_informacion_pagina_web_universidad_el_bosque.pdf"
                                   target="_blank">Términos y condiciones</a>
                            </label>
                            </div>
                        </div>
                        <div class="form-group" style="width:100%;display:flex;justify-content:center;margin:10px 0 10px 0">
                            <input type="submit" class="btn btn btn-fill-green-XL" id="btnenviar" value="Enviar" style="font-size: 13px;"/>
                        </div>
                    </div>
                    <input type="hidden" name="FechaInicio" value="Fecha de ingreso" />
                    <input type="hidden" name="Origen" value="Organico" />
                </div>
            </form>
        </div>
    </div>
</body>
</html>