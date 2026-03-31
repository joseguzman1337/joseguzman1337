<?php
include_once("../variables.php");
include($rutaTemplate."template.php");
$user=$utils->getUser();
$login=$user["idusuario"];
$dateHoy=date('Y-m-d H:i:s');
$texto=$_POST['menuEditor'];
echo $texto;
$db = getBD();
    //$plantillaInsertSql="INSERT into `plantillaGenericaEducacionContinuada` (`plantilla`, `fecha_creacion`, `usuario_creacion`, `fecha_modificacion`, `usuario_modificacion`) VALUES ('$texto', '$dateHoy', '$login', '$dateHoy', '$login');";
    //$db->Execute($plantillaInsertSql);
?>
