<?php

require_once(realpath(dirname(__FILE__)."/../../../sala/config/Configuration.php"));
$Configuration = Configuration::getInstance();

if($Configuration->getEntorno()=="local"||$Configuration->getEntorno()=="pruebas"){
    @error_reporting(1023); // NOT FOR PRODUCTION SERVERS!
   // @ini_set('display_errors', '1'); // NOT FOR PRODUCTION SERVERS!
    require_once(PATH_ROOT.'/kint/Kint.class.php');
}

require_once(PATH_SITE.'/lib/Factory.php');

$db = Factory::createDbo();

$SQL_ciudad = "SELECT
    c.codigosapciudad,
    d.nombredepartamento,
    c.nombreciudad
    FROM ciudad c 
    INNER JOIN departamento d ON c.iddepartamento = d.iddepartamento
    WHERE c.codigoestado = '100'
    AND d.iddepartamento <> 216
    ORDER BY d.nombredepartamento ";
$datosCiudad = $db->GetAll($SQL_ciudad);


// obtiene $variablecarrera del url usando GET

if (isset($_REQUEST['carrera'])) {
    $variablecarrera = $_REQUEST['carrera'];    
}

// inicio la variable $sqlcarrera como vacía
$sqlcarrera= "";

if(isset($variablecarrera)){
    $sqlcarrera= " and c.codigocarrera= '".$variablecarrera."'";
}

// código la información de las carreras

$SQL_careras = "SELECT c.codigocarrera, c.nombrecarrera, "
            ." SUBSTRING(c.nombrecarrera, 1,12) AS 'carrera' "
        ." FROM carrera c "
        ." WHERE "
        ." c.codigomodalidadacademica = '400' AND c.fechavencimientocarrera > now() "
        ." AND c.codigocarrera <> '1343' AND c.codigofacultad <> '110' "
        ." ".$sqlcarrera." "
        ." GROUP BY carrera, c.codigofacultad, c.fechavencimientocarrera "
        ." ORDER BY c.nombrecarrera, carrera";
$datosCarerra = $db->GetAll($SQL_careras);
$contadorCarerras = count($datosCarerra);

?>

<!DOCTYPE html>
<html>
<head>  
    <meta charset="UTF-8">
    <?php
    echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/normalize.css");
    echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/font-page.css");
    echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/font-awesome.css");
    echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/bootstrap.css");
    echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/general.css");
    echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/chosen.css");
    echo Factory::printImportJsCss("css",HTTP_ROOT."/serviciosacademicos/consulta/interfacesinfusion/assets/css/formularioEdCon.css");

    echo Factory::printImportJsCss("js",HTTP_ROOT."/assets/js/jquery-3.6.0.min.js");
    echo Factory::printImportJsCss("js",HTTP_ROOT."/assets/js/chosen.jquery.min.js");
    echo Factory::printImportJsCss("js",HTTP_ROOT."/assets/js/bootstrap.js"); 
    echo Factory::printImportJsCss("js",HTTP_ROOT."/assets/js/jquery.validate.min.js"); 
    echo Factory::printImportJsCss("js",HTTP_ROOT."/assets/js/triggerChosen.js"); 
    echo Factory::printImportJsCss("js",HTTP_ROOT."/assets/js/bootbox.min.js");     
    echo Factory::printImportJsCss("js",HTTP_ROOT."/serviciosacademicos/consulta/interfacesinfusion/assets/js/formularioEdCon.js"); 
        ?>    
</head>

<body>
    <div class="container">
        <div class="container-body">
            <div class="panel">
                <div class="panel-body">
                    <form id="formec" name="formec" class="form-horizontal">
                        <div class="form-group">
                            <input type="text" class="form-control" id="Nombres" name="Nombres" placeholder="Nombres" />
                            <input type="text" class="form-control" id="Apellidos" name="Apellidos" placeholder="Apellidos" />
                            <input type="email" class="form-control" id="Email" name="Email" placeholder="Correo Electrónico" />
                            <select id="Ciudad" type="text" id="Ciudad" name="Ciudad" class="chosen-select form-control"  required="true">
                                <option value='' selected hidden>Seleccione Ciudad</option>
                                <?php
                                foreach($datosCiudad as $Ciudades){
                                    ?>
                                    <option value = " <?php echo $Ciudades['codigosapciudad']; ?> "><?php echo $Ciudades['nombredepartamento'] . " - " . $Ciudades['nombreciudad']; ?></option> 
                                    <?php
                                }
                                ?>
                            </select>
                            <input type="text" class="form-control" id="Telefono" name="Telefono" placeholder="Teléfono" />

                                <?php
                                if($contadorCarerras> 2){
                                    ?>
                                   <select id="Programa" type="text" id="Programa" name="Programa" class="chosen-select form-control" required="true">
                                        <option value='' selected hidden>Seleccione Programa</option>
                                        <?php
                                        foreach ($datosCarerra as $Carreras) {
                                            ?>
                                            <option value = "<?php echo $Carreras['codigocarrera']; ?>"><?php echo $Carreras['nombrecarrera']; ?></option> 
                                            <?php
                                        } 
                                        ?>
                                    </select>
                                    <?php
                                }else{                                    
                                    ?>
                                <input type="hidden" name="Programa" value ="<?php echo $_GET['carrera']; ?>">
                                <input type="text" class="seleccionado" value ="<?php echo $datosCarerra[0]['nombrecarrera']; ?> " readonly="true">
                                <?php                                
                                }
                                ?>
                            
                            <input class="form-check-input" type="checkbox" name="valida" id="valida" >
                            <label class="form-check-label" for="defaultCheck1">
                              Autorizo a la Universidad El Bosque para el envío de Información
                              <a class= "text-primary" download="Prueba-UBosque" href="http://www.uelbosque.edu.co/sites/default/files/documentos/politica_privacidad_informacion_pagina_web_universidad_el_bosque.pdf" target="_blank">Términos y condiciones</a>
                            </label>
                            <br>
                            <div style="width:100%;display:flex;justify-content:center;margin:10px 0 10px 0">
                                    <input type="submit" class="btn btn-default" id="btnenviar" value="Enviar" style="font-size: 13px;"/>

                            </div>                            
                            <input type="hidden" name="FechaInicio" value="Fecha de ingreso" />
                            <input type="hidden" name="Origen" value="Organico" />
                        </div>
                    </form>
                   </div>
            </div>
        </div>
    </div>
</body>
</html> 
