<?php
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);
// this starts the session 
// session_start(); 
        
    require_once('Utils.php');
    $utils = Utils::getInstance();    
    $year = $_REQUEST["year"];
    $datosCarreras = $utils->getCarrerasPregrado();
    
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!--<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">-->
        <title>Estudiantes sin colegio clasificado</title>
        <link rel="stylesheet" href="../../../mgi/css/normalize.css" type="text/css" />  
        <link rel="stylesheet" href="../../../css/themes/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" /> 
        <link rel="stylesheet" href="../../../mgi/css/style.css" type="text/css"  media="screen, projection" /> 
        <link rel="stylesheet" href="css/style.css" type="text/css"  media="screen, projection" /> 
        
        <script type="text/javascript" language="javascript" src="../../../mgi/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../../../mgi/js/jquery-ui-1.8.21.custom.min.js"></script>   
    </head>
    <body>
        <div id="pageContainer">
            <h4>Estudiantes sin colegio clasificado en el año <?php echo $year; ?></h4>
            
            <a href="colegiosBogota.php" >Volver</a>
            <table style="margin-top:10px;">
                <thead>
                    <tr>
                        <th>Estudiante</th>
                        <th>Carrera</th>
                        <th>Colegio</th>
                        <th>Ciudad</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $estudiantes = $utils->getEstudiantesInscritosNoClasificados($year,$datosCarreras["total"],$datosCarreras["carreras"]); 
                    foreach ($estudiantes as $estudiante) {  
                        $carrera = $utils->getCarrera($estudiante["codigocarrera"]);
                        $datosEstudiante = $utils->getEstudiante($estudiante["extraInfo"]["idestudiantegeneral"],$estudiante["codigoestudiante"]);
                        ?>
                        <tr>
                            <td class="center"><?php echo $datosEstudiante["nombresestudiantegeneral"]." ".$datosEstudiante["apellidosestudiantegeneral"]; ?></td>
                            <td class="center"><?php echo $carrera["nombrecarrera"]; ?></td>
                            <td class="center"><?php echo $estudiante["extraInfo"]["otrainstitucioneducativaestudianteestudio"]; ?></td>
                            <td class="center"><?php echo $estudiante["extraInfo"]["ciudadinstitucioneducativa"]; ?></td>
                        </tr>                    
                        <?php  } ?>
                </tbody>
            </table>
            </div>
    </body>
</html>
