<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
require_once(realpath(dirname(__FILE__)).'/../../../../../Connections/sala2.php');
$rutaado = "../../../../../funciones/adodb/";
//$rutazado = "../../../funciones/zadodb/";
require_once(realpath(dirname(__FILE__)).'/../../../../../Connections/salaado.php');
require_once(realpath(dirname(__FILE__)).'/../../../../../funciones/sala/estudiante/estudiante.php');
require_once(realpath(dirname(__FILE__)).'/../../../../../funciones/sala/inscripcion/inscripcion.php');

/*echo "<pre>";
print_r($_SESSION);
echo "</pre>";*/

$ruta = "../../../../../funciones/sala/inscripcion/";

set_time_limit(900000000);

//print_r($_SERVER);
//echo $_SERVER['argv'][0];
if(!isset($_SESSION['fppal'])) {
    if($_SERVER['argv'][0] == '') {
        $_SESSION['fppal'] = $_SERVER['QUERY_STRING'];
    }
    else
        $_SESSION['fppal'] = $_SERVER['argv'][0];
}


//echo "<pre>".print_r($_REQUEST)."</pre>";
$idestudiantegeneral = $_SESSION['sissic_idestudiantegeneral'];
$estudiantegeneral = new estudiantegeneral($idestudiantegeneral);
//echo "<pre>".print_r($estudiantegeneral)."</pre>";
$codigomodalidadacademica = 0;
$idsubperiodo = 0;
$idinscripcion = 0;
$inscripcion = new inscripcion($estudiantegeneral, $idsubperiodo, $idinscripcion,$codigomodalidadacademica);
$inscripcion->archivoComienzo = "actividadesDestacar.php";

if(isset($_REQUEST['guardarinformacion'])) {
    echo "<script type='text/javascript'>
            window.parent.frames[1].cambiaEstadoImagen(true,".$_GET["idformulario"].");
    </script>";
    $inscripcion->guardarInformacionActividadesDestacar();
}
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>ACTIVIDADES A DESTACAR</title>
        <link rel="stylesheet" href="../../../../../estilos/sala.css" type="text/css">
        <script type="text/javascript">// Esta funcion recargar1 sirve para los datos de estudios
            function recargar1(codigocolegio, nombrecolegio)
            {
                document.informacion.idinstitucioneducativa.value = codigocolegio;
                document.informacion.institucioneducativa.value = nombrecolegio;
            }
        </script>
    </head>
    <body>
        <form action="" method="post" name="informacion">
            <fieldset>
                <legend>ACTIVIDADES A DESTACAR</legend>
                <?php
                $inscripcion->actividadesDestacar();
                ?>
                <table width="100%">
                    <tr>
                        <td align="left">
                            <input type="submit" name="guardarinformacion" id="guardarinformacion" value="Guardar">
                        <td>
                    </tr>
                </table>
            </fieldset>
        </form>
    </body>
</html>
