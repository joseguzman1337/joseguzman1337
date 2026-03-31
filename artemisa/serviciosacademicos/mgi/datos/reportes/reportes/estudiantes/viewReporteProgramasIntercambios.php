<?php 
// this starts the session 
 /*session_start(); 

    $ruta = "../";
    while (!is_file($ruta.'Connections/sala2.php'))
    {
        $ruta = $ruta."../";
    }
    require($ruta.'Connections/sala2.php');
    $rutaado = $ruta."funciones/adodb/";
    require($ruta.'Connections/salaado.php');
//var_dump($db);
    //header('Location: http://'. $_SERVER['HTTP_HOST'] .'/serviciosacademicos/mgi/datos/registroInformacion/formularios/academicos/MovilidadAcademica_html.php?actionID=ReporteDefault');
//$homepage = file_get_contents('http://'. $_SERVER['HTTP_HOST'] .'/serviciosacademicos/mgi/datos/registroInformacion/formularios/academicos/MovilidadAcademica_html.php?actionID=ReporteDefault');
//echo $homepage;*/
?>
<div class="vacio"></div>
<div id="result"></div>
<script type="text/javascript">
    $('#result').load("../registroInformacion/formularios/academicos/MovilidadAcademica_html.php?actionID=ReporteDefault");
    //window.location.replace("../registroInformacion/formularios/academicos/MovilidadAcademica_html.php?actionID=ReporteDefault");
</script>
