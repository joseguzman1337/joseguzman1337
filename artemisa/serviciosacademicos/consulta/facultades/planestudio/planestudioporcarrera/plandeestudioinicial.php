<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
require_once('../../../../Connections/sala2.php');
mysql_select_db($database_sala, $sala);
require_once('../seguridadplandeestudio.php');
if(isset($_GET['nacodigocarrera']))
    $_SESSION['sesion_codigocarrera_planestudio'] = $_GET['nacodigocarrera'];
$codigocarrera = $_SESSION['sesion_codigocarrera_planestudio'];
if (!isset ($_SESSION['sesion_planestudioporcarrera'])){
    if($HTTP_SERVER_VARS['HTTP_REFERER'] != '')
        $_SERVER['HTTP_REFERER'] = $HTTP_SERVER_VARS['HTTP_REFERER'];
    $_SESSION['sesion_planestudioporcarrera'] = $_SERVER['HTTP_REFERER'];
}

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Planes de estudio en construcción</title>
<link rel="stylesheet" href="../../../../estilos/sala.css" type="text/css">
<style type="text/css">
<!--
.Estilo1 {
	font-family: Tahoma;
	font-weight: bold;
	font-size: 14px;
}
.Estilo2 {
	font-family: Tahoma;
	font-size: 12px;
}
-->
</style>
</head>

<body>
<div align="center">
<form action="plandeestudioinicial.php" name="f1" method="post">
<?php
// Se selecciona el plan de estudios de acuerdo a la fecha, es decir que en determinada fecha queda
// activo, esto se hace con la fecha del sistema
/*
echo date("Y-m-d")."<br>";
select c.nombrecarrera, p.nombreplanestudio, p.idplanestudio
from planestudio p, carrera c
where c.codigocarrera = p.codigocarrera
and c.codigocarrera = '730'//'$codigocarrera'
//and p.codigoestadoplanestudio = '101'
and p.fechainioplanestudio <= '2007-04-02'
and p.fechavencimientoplanestudio >= '2007-04-02'
*/
/*
?>
	<option value="0"><strong>No tiene planes de estudio</strong></option>
    <?php
	*/
	$query_carrera = "SELECT nombrecarrera FROM carrera where codigocarrera = '".$codigocarrera."'";
	$carrera = mysql_query($query_carrera, $sala) or die("$query_carrera");
	$row_carrera = mysql_fetch_assoc($carrera);
	$totalRows_carrera = mysql_num_rows($carrera);
	$nombreCarrera = $row_carrera['nombrecarrera'];

?>
</span>
<table width="20%"  border="0" align="center" cellpadding="3" cellspacing="3">
<TR><TD><img src="../../../../../imagenes/noticias_logo.gif" height="71" ></TD></TR></BR>
<TR><TD id="tdtitulogris" align="center"><p align="center" ><H2>PLANES DE ESTUDIO</H2></p></TD></TR>
</table>
<table width="500"  cellpadding="2" cellspacing="1" >
  <tr id="trtitulogris">
  	<td width="140" rowspan="3" id="tdtitulogris">
	<select name='identplanestudio2' size="7" style="width: 250px">
<?php
$query_planesdeestudioactivos = "select c.nombrecarrera, p.nombreplanestudio, p.idplanestudio, ep.nombrecodigoestadoplanestudio 
from planestudio p, carrera c, estadoplanestudio ep 
where c.codigocarrera = p.codigocarrera and ep.codigoestadoplanestudio=p.codigoestadoplanestudio 
and c.codigocarrera = '".$codigocarrera."' ORDER BY p.codigoestadoplanestudio,p.nombreplanestudio";

//and p.codigoestadoplanestudio = '100'";
$planesdeestudioactivos = mysql_query($query_planesdeestudioactivos, $sala) or die("$query_planesdeestudioactivos");
$totalRows_planesdeestudioactivos = mysql_num_rows($planesdeestudioactivos);
if($totalRows_planesdeestudioactivos != "")
{
	while($row_planesdeestudioactivos = mysql_fetch_assoc($planesdeestudioactivos))
	{
		$nombreCarrera = $row_planesdeestudioactivos['nombrecarrera'];
		$nombreplanestudio = $row_planesdeestudioactivos['nombreplanestudio'];
		$idplanestudio = $row_planesdeestudioactivos['idplanestudio'];
		$estado = $row_planesdeestudioactivos['nombrecodigoestadoplanestudio'];
?>
		<option value="<?php echo $idplanestudio; ?>"><?php echo $nombreplanestudio." (".$estado.")"; ?></option>
<?php
	}
}
else
{
/*
?>
	<option value="0"><strong>No tiene planes de estudio</strong></option>
<?php
	*/
	$query_carrera = "SELECT nombrecarrera FROM carrera where codigocarrera = '".$codigocarrera."'";
	$carrera = mysql_query($query_carrera, $sala) or die("$query_carrera");
	$row_carrera = mysql_fetch_assoc($carrera);
	$totalRows_carrera = mysql_num_rows($carrera);
	$nombreCarrera = $row_carrera['nombrecarrera'];
}
?>
	</select>
	</td>

  </TR>
  <tr>
  	<td align="center"><input  type="submit" name="visualizar" value="Visualizar" style="WIDTH:80px"></br></br>
            
  	<input type="submit" name="verreporte" value="Ver Reporte" style="WIDTH:80px"></br></br>


    <input  type="button" name="regresar" value="Regresar" style="WIDTH:80px" onclick="window.location.href='<?php echo $_SESSION['sesion_planestudioporcarrera']; ?>'">
    </td>
  </tr>

  <!-- <tr>
  	<td align="center"><input type="submit" name="asignar" value="Asignar" style="WIDTH:80px"></td>
  </tr> -->
  <tr>

  </tr>
</table>
</form>
</div>
<!-- <p align="center" class="Estilo1">&nbsp;
  SCRIPTS PARA PRUEBAS<br><br>
 <a href="zconstruccionplan.php?planestudio=<?php echo $row_seltotalcreditossemestre['idplanestudio']."&estudiante=".$row_iniciales['codigoestudiante'];?>">Ponerlo en construccion</a><br>
 <a href="zactivarplan.php?planestudio=<?php echo $row_seltotalcreditossemestre['idplanestudio']."&estudiante=".$row_iniciales['codigoestudiante'];?>">Activarlo</a><br>
 </p> -->
</body>
<?php
//print_r($_POST);
if(isset($_POST['identplanestudio2']))
{
	if(isset($_POST['visualizar']))
	{
		echo '<script language="javascript">
		window.location.href="materiasporsemestre.php?planestudio='.$_POST['identplanestudio2'].'&visualizado";
		</script>';
	} else if(isset($_POST['verreporte']))
	{
		echo '<script language="javascript">
		window.location.href="reporteporsemestre.php?planestudio='.$_POST['identplanestudio2'].'&visualizado";
		</script>';
	}
}
else
{
	if(isset($_POST['visualizar']) || isset($_POST['asignar']) || isset($_POST['verreporte']))
	{
		echo '<script language="javascript">
		alert("Debe seleccionar un plan de estudios del panel de la izquierda de plan de estudios activos");
		</script>';
	}
}
?>
</html>
