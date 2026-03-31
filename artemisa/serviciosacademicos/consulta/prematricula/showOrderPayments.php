<?php
session_start();
include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarSesion.php');
/* END */
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);
$ruta = "../../funciones/";
require_once('../../Connections/sala2.php');
require_once('../../funciones/ordenpago/claseordenpago.php');
mysql_select_db('sala', $sala);

//definicion de ruta de acceso a visualizacion de ordenes de pago
$rutaorden = HTTP_ROOT."/serviciosacademicos/funciones/ordenpago/";
$codigoestudiante = $_REQUEST['codest'];
$codigoperiodoact = $_REQUEST['periodoAct'];
$codigoperiodopre = $_REQUEST['periodopre'];
$periodo = $_REQUEST['periodo'];


$query_selperiodoprevig = "select p.codigoperiodo from periodo p where ".
    "(p.codigoestadoperiodo like '1%' or p.codigoestadoperiodo like '3%') order by 1";
$selperiodoprevig = mysql_query($query_selperiodoprevig, $sala) or die(mysql_error());
$totalRows_selperiodoprevig = mysql_num_rows($selperiodoprevig);
$row_selperiodoprevig = mysql_fetch_assoc($selperiodoprevig);



if($totalRows_selperiodoprevig == 1){
    $codigoperiodoact = $row_selperiodoprevig['codigoperiodo'];
    $ordenesxestudiante = new Ordenesestudiante($sala, $_SESSION['codigo'], $codigoperiodoact);
    $codigoperiodopre = "";
}else{
    $codigoperiodopre = $row_selperiodoprevig['codigoperiodo'];
    $ordenesxestudiantepre = new Ordenesestudiante($sala, $_SESSION['codigo'], $codigoperiodopre);

    $row_selperiodoprevig = mysql_fetch_assoc($selperiodoprevig);

    $codigoperiodoact = $row_selperiodoprevig['codigoperiodo'];
    $ordenesxestudiante = new Ordenesestudiante($sala, $_SESSION['codigo'], $codigoperiodoact);
}

$esta_enperiodosesion = true;
if($codigoperiodoact == $_SESSION['codigoperiodosesion'] || $codigoperiodopre == $_SESSION['codigoperiodosesion']){
    $esta_enperiodosesion = false;
}else{
    $otrasordenes = new Ordenesestudiante($sala, $_SESSION['codigo'], $_SESSION['codigoperiodosesion']);
}

///// MUESTRA LAS ORDENES DEL ESTUDIANTE ///////
    if(isset($codigoperiodopre) && !empty($codigoperiodopre)){
        $ordenesxestudiantepre->mostrar_ordenespago($rutaorden,"");
    ?>
        <br>
    <?php
    }

    $ordenesxestudiante->mostrar_ordenespago($rutaorden,"");
?>
    <br>
<?php
    if($esta_enperiodosesion)
    {
        $otrasordenes->mostrar_ordenespago($rutaorden,"");
        ?>
            <br>
        <?php
    }