<?php
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
header('Content-Type: text/html; charset=UTF-8');
session_start();
//print_r($_SESSION);
if(!isset($_SESSION['contadorentradasseleccionacarrera']))
$_SESSION['contadorentradasseleccionacarrera']=0;
else
$_SESSION['contadorentradasseleccionacarrera']++;

?>
<script language="javascript">
var browser = navigator.appName;
var http;
if(browser == 'Microsoft Internet Explorer') {
	http = new ActiveXObject("Microsoft.XMLHTTP");
}
else {
	http = new XMLHttpRequest();
}

function hRefCentral(url){
	if(browser == 'Microsoft Internet Explorer'){
		parent.contenidocentral.location.href(url);
	}
	else{
		parent.contenidocentral.location=url;
	}
	return true;
}

function hRefIzq(url){
	if(browser == 'Microsoft Internet Explorer'){
		parent.leftFrame.location.href(url);
	}
	else{
		parent.leftFrame.location=url;
	}
	return true;
}

function seleccionarCarrera(codigocarrera){
	document.getElementById('codigocarrera').value=codigocarrera;
	document.getElementById('seleccionaCarrera').submit();
}
</script>
<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
-->
</style>

<?php
require_once("../../Connections/sala2.php");
mysql_select_db($database_sala,$sala);
if(!empty($_GET['codigocarrera'])){
	$_SESSION['codigofacultad']=$_GET['codigocarrera'];
	$queryFacultad="SELECT * from carrera c WHERE c.codigocarrera='".$_SESSION['codigofacultad']."'";
	$opFacultad=mysql_query($queryFacultad);
	$rowFacultad=mysql_fetch_assoc($opFacultad);
	$_SESSION['nombrefacultad']=$rowFacultad['nombrecarrera'];
	/*$mensaje="Señor usuario por defecto el sistema sala le escoge una carrera\\n".
			"En el buscador de estudiante puede acceder a todos\\n".
			"Los estudiantes de las carreras a las que tiene derecho\\n".
			"Puede encontrar otras opciones que sea necesario cambiar de carrera\\n".
			"Puede encontrar la opcion 'Mis carreras' para el cambio de carrera manual";*/

	echo '<script language="javascript">
	hRefIzq("facultadeslv2.php");
	hRefCentral("central.php");

	</script>';
}
if(!isset($_GET['codigocarrera'])){
	if(isset($_POST['Filtrar']))
	$cadenasql="and c.nombrecarrera like '%".trim($_POST['f_nombre'])."%'
				and u.codigofacultad like '%".trim($_POST['f_codigo'])."%'";

 $query_difusuarios = "SELECT u.codigofacultad,c.nombrecarrera,c.codigocarrera
			                      FROM usuariofacultad u,carrera c, usuario us
								  WHERE
								  us.usuario=u.usuario
								  and us.usuario = '".$_SESSION['MM_Username']."'
								  $cadenasql
								  and u.codigofacultad = c.codigocarrera 
									and u.codigoestado like '1%' order by c.nombrecarrera ";

	//echo $query_difusuarios;

	$difusuarios = mysql_query($query_difusuarios, $sala) or die(mysql_error());
	$row_difusuarios = mysql_fetch_assoc($difusuarios);
$totalRows_difusuarios = mysql_num_rows($difusuarios);?>
	<html>
   <body>
    <strong>Seleccione Carrera</strong>

    <table border="0"  border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
	<form id="filtrarcarrera" name="filtrarcarrera" method="POST">

	  <tr bgcolor="#C5D5D6" class="Estilo2">
    <td colspan="4" align="center"><input name="Filtrar" type="submit" id="Filtrar" value="Filtrar">
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input name="Restablecer" type="submit" id="Restablecer" value="Restablecer"></td>
    </tr>

	 <tr bgcolor="#C5D5D6" class="Estilo2">
    <td align="center"> <input name="f_codigo" type="text" id="f_codigo" value="" size="29"></td>
    <td align="center"><input name="f_nombre" type="text" id="f_nombre" value=""></td>
	</tr>
	</form>

    <tr>
	<td bgcolor="#C5D5D6" class="Estilo2" align="center">Codigo</td>
	<td bgcolor="#C5D5D6" class="Estilo2" align="center">Programa</td>
	</tr>
<?php
$i=0;
do{
$i++;
if($i==$totalRows_difusuarios){
$carreradefecto=$row_difusuarios['codigocarrera'];
}
?>
	<tr>
		<td align="center"><?php echo $row_difusuarios['codigocarrera']?></td>
		<td align="left"><a href="#" onclick="seleccionarCarrera(<?php echo $row_difusuarios['codigocarrera']?>)"><?php echo $row_difusuarios['nombrecarrera']?></a></td>
	</tr>
	<?php
}
while ($row_difusuarios = mysql_fetch_assoc($difusuarios));
?>

<?php }
else{

}
?>
</table>
<form id="seleccionaCarrera" name="seleccionaCarrera" method="GET">
<input type="hidden" name="codigocarrera" id="codigocarrera" value="<?php echo $carreradefecto ?>">
<input type="hidden" name="idusuario" value="<?php echo $_GET['idusuario']?>">
</form>
<?php
if($_SESSION['contadorentradasseleccionacarrera']<=1){
?>
<script language="javascript">
	//document.getElementById('codigocarrera').value=codigocarrera;
	document.getElementById('seleccionaCarrera').submit();
</script>
<?php
}
//else
//echo "_SESSION['codigofacultad']=".$_SESSION['codigofacultad'];

?>
</body>
</html>
