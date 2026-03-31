<?php
    session_start();
    include_once('../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION); 
    
$query_selplan = "select p.idplanestudio
from planestudio p
where p.codigocarrera = '".$_SESSION['codigofacultad']."'
and p.codigoestadoplanestudio = '100'";
$selplan = mysql_query($query_selplan, $sala) or die("$query_selplan");
$row_selplan = mysql_fetch_assoc($selplan);
$idplanestudio = $row_selplan['idplanestudio'];
if($_GET['asignacion'] == "primeravez")
{
	// Código para saber el nombre del periodo
	$query_insplan = "INSERT INTO planestudioestudiante(idplanestudio, codigoestudiante, fechaasignacionplanestudioestudiante, fechainicioplanestudioestudiante, fechavencimientoplanestudioestudiante, codigoestadoplanestudioestudiante) 
    VALUES('$idplanestudio', '".$_GET['estudiante']."', '".date("Y-m-d",time())."', '".date("Y-m-d",time())."', '2999-12-31', '100')";
	$insplan = mysql_query($query_insplan, $sala) or die("$query_insplan");
?>
<script language="javascript">
	alert("Asignó plan de estudio por primera vez");
</script>
<?php
	require("visualizarplanestudioestudiante.php");
}
else if($_GET['asignacion'] == "otravez")
{
?>
<script language="javascript">
	alert("Asignó nuevo plan de estudio al estudiante");
</script>
<?php
	require("visualizarplanestudioestudiante.php");
}
?>