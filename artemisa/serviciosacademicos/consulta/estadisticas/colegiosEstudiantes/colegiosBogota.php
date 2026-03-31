<?php
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

// this starts the session 
 //session_start(); 
        
    require_once('Utils.php');
    $utils = Utils::getInstance();
    $years = $utils->getYears();
    $datosCarreras = $utils->getCarrerasPregrado();
    
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!--<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">-->
        <title>Estudiantes provenientes de colegios de Bogotá</title>
        <link rel="stylesheet" href="../../../mgi/css/normalize.css" type="text/css" />  
        <link rel="stylesheet" href="../../../css/themes/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" /> 
        <link rel="stylesheet" href="../../../mgi/css/style.css" type="text/css"  media="screen, projection" /> 
        <link rel="stylesheet" href="css/style.css" type="text/css"  media="screen, projection" /> 
        
        <script type="text/javascript" language="javascript" src="../../../mgi/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../../../mgi/js/jquery-ui-1.8.21.custom.min.js"></script>   
    </head>
    <body>
        <div id="pageContainer">
            <h4>Estudiantes provenientes de colegios de Bogotá</h4>
            <table>
                <thead>
                    <tr>
                        <th rowspan="2">Año</th>
                        <th colspan="3">Número de estudiantes de colegios oficiales de Bogotá</th>
                        <th colspan="3">Número de estudiantes de colegios privados de Bogotá</th>
                        <th colspan="3">Total</th>
                        <th rowspan="2">Estudiantes sin definir</th>
                        <th rowspan="2">Inscritos (No Bogotá)</th>
                    </tr>
                    <tr>
                        <th>Inscritos</th>
                        <th>Admitidos</th>
                        <th>Matriculados</th>
                        <th>Inscritos</th>
                        <th>Admitidos</th>
                        <th>Matriculados</th>
                        <th>Inscritos</th>
                        <th>Admitidos</th>
                        <th>Matriculados</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($years as $year) { 
                        $estadisticas = $utils->calcularColegios($year,$datosCarreras["total"],$datosCarreras["carreras"]); 
                        //var_dump($estadisticas); ?>
                        <tr>
                            <td class="center"><?php echo $year; ?></td>
                            <td class="center"><?php echo $estadisticas["inscritos"]["inscritosOficial"]; ?></td>
                            <td class="center"><?php echo $estadisticas["admitidos"]["admitidosOficial"]; ?></td>
                            <td class="center"><?php echo $estadisticas["matriculados"]["matOficial"]; ?></td>
                            <td class="center"><?php echo $estadisticas["inscritos"]["inscritosPrivado"]; ?></td>
                            <td class="center"><?php echo $estadisticas["admitidos"]["admitidosPrivado"]; ?></td>
                            <td class="center"><?php echo $estadisticas["matriculados"]["matPrivado"]; ?></td>
                            <td class="center"><?php echo ($estadisticas["inscritos"]["inscritosPrivado"] + $estadisticas["inscritos"]["inscritosOficial"]); ?></td>
                            <td class="center"><?php echo ($estadisticas["admitidos"]["admitidosOficial"] + $estadisticas["admitidos"]["admitidosPrivado"]); ?></td>
                            <td class="center"><?php echo ($estadisticas["matriculados"]["matPrivado"]+$estadisticas["matriculados"]["matOficial"]); ?></td>
                            <td class="center"><a href="estudiantesSinColegio.php?year=<?php echo $year; ?>"><?php echo $estadisticas["inscritos"]["inscritosSinDefinir"]; ?></a></td>
                            <td class="center"><?php echo $estadisticas["inscritos"]["inscritosNoBogota"]; ?></td>
                        </tr>                    
                        <?php  } ?>
                </tbody>
            </table>
            </div>
    </body>
</html>
