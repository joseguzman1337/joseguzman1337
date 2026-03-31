<?php

session_start();
/*if(!isset ($_SESSION['MM_Username'])){
	echo '<blink><strong style="color:#F00; font-size:18px">No ha iniciado sesión en el sistema</strong></blink>';
	exit();
} */

$PlanTrabajo_id = $_REQUEST['PlanTrabajo_id'];
$index          = $_REQUEST['index'];
$Docente_id     = $_REQUEST['Docente_id'];

?>
<form action="DocumentoEvidencia.php" method="post" enctype="multipart/form-data" name="Principal">
    <table>
        <thead>
            <tr>
                <th>Cargar Archivo<input type="hidden" id="PlanTrabajo_id" name="PlanTrabajo_id" value="<?PHP echo $PlanTrabajo_id?>" /><input type="hidden" id="index" name="index" value="<?PHP echo $index?>" /><input type="hidden" id="Docente_id" name="Docente_id" value="<?PHP echo $Docente_id?>" /></th>
            </tr>
            <tr>
                <th>
                    <input type="file" id="file" name="file" height="80px"  size="50"/><br><span id="tipoDoc" style="color:#000; font-size:9px">10 Mb Max / Word</span>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th><input type="submit" id="CargarDoc" name="CargarDoc" value="Enviar" /></th>
            </tr>
        </tbody>
    </table>
</form>