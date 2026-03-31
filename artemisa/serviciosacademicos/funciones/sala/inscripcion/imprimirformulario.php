<?php
$query_ordenformulario = "SELECT linkinscripcionmodulo,posicioninscripcionformulario,nombreinscripcionmodulo,im.idinscripcionmodulo
FROM inscripcionformulario ip, inscripcionmodulo im
WHERE ip.idinscripcionmodulo = im.idinscripcionmodulo
AND ip.codigomodalidadacademica = '$this->codigomodalidadacademica'
AND ip.codigoestado LIKE '1%'
ORDER BY posicioninscripcionformulario";
$ordenformulario = $db->Execute($query_ordenformulario);
$totalRows_ordenformulario = $ordenformulario->RecordCount();
$cuentapasos = 0;
$ratafinal = 0;
$cuentaratas = 0;
while($row_ordenformulario = $ordenformulario->FetchRow()) {
    $idinscripcionmodulo = $row_ordenformulario['idinscripcionmodulo'];
    $cuentapasos++;
    switch($idinscripcionmodulo) {
        // Aca vienen Información del aspirante
        case 1:
            ?>
<form action="" method="post" name="informacionAspirante">
    <p><?php echo $row_ordenformulario['nombreinscripcionmodulo']; ?></p>
                <?php
                $this->estudiantegeneral->imprimir();
                //require_once("imprimirinformacionaspirante.php");
                ?>
</form>
            <?php
            break;

        case 10:
            ?>
<p><?php echo $row_ordenformulario['nombreinscripcionmodulo']; ?></p>
            <?php
            require_once("imprimirinformacionfinaciera.php");
            break;

        case 7:
            ?>
<p><?php echo $row_ordenformulario['nombreinscripcionmodulo']; ?></p>
            <?php
            require_once("imprimirinformacionfamiliar.php");
            break;

        case 2:
            ?>
<p><?php echo $row_ordenformulario['nombreinscripcionmodulo']; ?></p>
            <?php
            require_once("imprimirInformacionEstudios.php");
            break;

        case 13:
            ?>
<p><?php echo $row_ordenformulario['nombreinscripcionmodulo']; ?></p>
            <?php
            require_once("imprimirinformacionestudiossecundaria.php");
            break;
        case 14:
            ?>
<p><?php echo $row_ordenformulario['nombreinscripcionmodulo']; ?></p>
            <?php
            require_once("imprimirinformacionotrosestudios.php");
            break;
        case 8:
            ?>
<p><?php echo $row_ordenformulario['nombreinscripcionmodulo']; ?></p>
            <?php
            require_once("imprimirinformacionidiomas.php");
            break;

        case 4:
            ?>
<p><?php echo $row_ordenformulario['nombreinscripcionmodulo']; ?></p>
            <?php
            require_once("imprimirinformacionsegundaopcion.php");
            break;

        case 11:
            ?>
<p><?php echo $row_ordenformulario['nombreinscripcionmodulo']; ?></p>
            <?php
            require_once("imprimirinformacionotrasu.php");
            break;

        case 9:
            ?>
<p><?php echo $row_ordenformulario['nombreinscripcionmodulo']; ?></p>
            <?php
            require_once("imprimirinformacionmediocomunicacion.php");
            break;

        case 3:
            ?>
<p><?php echo $row_ordenformulario['nombreinscripcionmodulo']; ?></p>
            <?php
            require_once("imprimirOcupacionesExperiencia.php");
            break;
        case 12:
            ?>
<p><?php echo $row_ordenformulario['nombreinscripcionmodulo']; ?></p>
            <?php
            require_once("imprimiractividadesdestacar.php");
            break;

    }
}
?>
