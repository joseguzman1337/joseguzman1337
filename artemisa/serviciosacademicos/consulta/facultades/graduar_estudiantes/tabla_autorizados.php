<?php
@session_start();
require_once('../../../Connections/sala2.php');
require_once('funciones/funcionip.php');

$fechaautorizacionregistrograduado=date("Y-m-d H:i:s");
$direccionipregistrograduado=tomarip();
$usuario=$_SESSION['MM_Username'];
?>
<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold;}
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
.Estilo4 {color: #FF0000}
-->
</style>
<?php
mysql_select_db($database_sala, $sala);
$query_idusuario="select idusuario from usuario where usuario='$usuario'";
$idusuario=mysql_query($query_idusuario, $sala) or die(mysql_error());
$row_idusuario=mysql_fetch_assoc($idusuario);
//print_r($row_idusuario);
$query_iddirectivo="select iddirectivo from directivo where idusuario='".$row_idusuario['idusuario']."'";



mysql_select_db($database_sala, $sala);
$query_resumen="SELECT eg.numerodocumento,s.nombresituacioncarreraestudiante,rg.idregistrograduado,rg.codigoestudiante,concat(eg.nombresestudiantegeneral,' ',eg.apellidosestudiantegeneral) AS nombre,
rg.numeroacuerdoregistrograduado,rg.fechaacuerdoregistrograduado, rg.responsableacuerdoregistrograduado,rg.numeroactaregistrograduado,
rg.numerodiplomaregistrograduado, rg.fechagradoregistrograduado, rg.presidioregistrograduado, rg.lugarregistrograduado, rg. observacionregistrograduado,
rg.codigoestado, rg.codigoautorizacionregistrograduado
FROM registrograduado rg, estudiantegeneral eg, estudiante e, situacioncarreraestudiante s
WHERE 
e.idestudiantegeneral=eg.idestudiantegeneral AND
e.codigoestudiante=rg.codigoestudiante AND
rg.codigoestado='100' AND
e.codigosituacioncarreraestudiante=s.codigosituacioncarreraestudiante AND
rg.codigoautorizacionregistrograduado='100'
";
$resumen = mysql_query($query_resumen, $sala) or die(mysql_error());
$row_resumen=mysql_fetch_assoc($resumen)
?>
<form name="form1" method="post" action="">
  <p align="center" class="Estilo2">LISTADO DE ESTUDIANTES CON REGISTRO DE GRADO AUTORIZADO </p>
  <table border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
    <tr>
      <td align="center" bgcolor="#FFFFFF" class="Estilo2">N&uacute;mero de Registro&nbsp; </td>
      <td align="center" bgcolor="#FFFFFF" class="Estilo2">Documento&nbsp;</td>
      <td align="center" bgcolor="#FFFFFF" class="Estilo2">Nombre&nbsp;</td>
      <td align="center" bgcolor="#FFFFFF" class="Estilo2">No. Acuerdo&nbsp;</td>
      <td align="center" bgcolor="#FFFFFF" class="Estilo2">No. Acta&nbsp;</td>
      <td align="center" bgcolor="#FFFFFF" class="Estilo2">No. Diploma&nbsp;</td>
      <td align="center" bgcolor="#FFFFFF" class="Estilo2">Estado&nbsp;</td>
      <?php 
      do {
      	$chequear="";
      	//echo $row_resumen['codigoautorizacionregistrograduado'];
      	/* if($row_resumen['codigoautorizacionregistrograduado']=='100')
      	{
      		$chequear="checked";
      	} */
      	echo '<tr>
  <td align="center" bgcolor="#FFFFFF" class="Estilo1">'.$row_resumen['idregistrograduado'].'&nbsp;</td>
  <td align="center" bgcolor="#FFFFFF" class="Estilo1">'.$row_resumen['numerodocumento'].'&nbsp;</td>
  <td align="center" bgcolor="#FFFFFF" class="Estilo1"><a href="graduar_estudiantes_ingreso.php?tablaautorizados&estudiante='.$row_resumen['codigoestudiante'].'">'.$row_resumen['nombre'].'</a>&nbsp;</td>
  <td align="center" bgcolor="#FFFFFF" class="Estilo1">'.$row_resumen['numeroacuerdoregistrograduado'].'&nbsp;</td>
  <td align="center" bgcolor="#FFFFFF" class="Estilo1">'.$row_resumen['numeroactaregistrograduado'].'&nbsp;</td>
  <td align="center" bgcolor="#FFFFFF" class="Estilo1">'.$row_resumen['numerodiplomaregistrograduado'].'&nbsp;</td>
  <td align="center" bgcolor="#FFFFFF" class="Estilo1">'.$row_resumen['nombresituacioncarreraestudiante'].'&nbsp;</td>
   </tr>
  
  ';
      }
      while ($row_resumen=mysql_fetch_assoc($resumen))
  ?>
    <tr>
      <td height="25" colspan="7" align="center" bgcolor="#FFFFFF" class="Estilo2"><input type="submit" name="Enviar" value="Enviar"></td>
  </table>
</form>
<?php 
if(isset($_POST['Enviar'])){

	foreach($_POST as $vpost => $valor)
	{
		if (ereg("sel",$vpost))
		{
			$idregistrograduado = $_POST[$vpost];
			$query_autorizar="update registrograduado set iddirectivo='".$_GET['iddirectivo']."', fechaautorizacionregistrograduado='$fechaautorizacionregistrograduado',
			codigoautorizacionregistrograduado='200' where idregistrograduado='$idregistrograduado'";
			echo $query_autorizar;
		}
	}

}



?>
