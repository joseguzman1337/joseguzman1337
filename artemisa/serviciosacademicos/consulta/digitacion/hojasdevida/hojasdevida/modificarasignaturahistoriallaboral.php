<?php require_once('../../../../Connections/conexion.php');session_start();?>
<?php
       $base= "select * from asignaturahistoriallaboral where idasignaturahistoriallaboral = '".$_GET['modificar']."'";
       $sol=mysql_db_query("hojavida",$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol);       
?>

<?php
mysql_select_db($database_conexion, $conexion);
$query_Recordset1 = "SELECT * FROM tipocursodictado";
$Recordset1 = mysql_query($query_Recordset1, $conexion) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<style type="text/css">
<!--
.Estilo1 {
	font-size: 12px;
	font-family: Tahoma;
}
.Estilo2 {
	font-size: 12px;
	font-family: Tahoma;
	font-weight: bold;
}
.Estilo3 {
	font-size: 14px;
	font-family: Tahoma;
	font-weight: bold;
}
.Estilo4 {color: #FF0000}
-->
</style>
<body class="Estilo1">
<form name="form1" method="post" action="modificarasignaturahistoriallaboral.php"><div align="center">
<p class="Estilo3"><strong>MODIFICACI&Oacute;N DE DATOS</strong></p>
	<?php
    if (($_POST['institucionasignaturahistoriallaboral'] == "")or ($_POST['nombrefacultadasignaturahistoriallaboral'] == "")or ($_POST['nombreasignaturahistoriallaboral'] == ""))
   {
     echo  "<h5>Recuerde que los campos con <span class='Estilo4' align='center'>*</span> son obligatorios</h5>";
   }
else 
     {
     require_once('modificarasignaturahistoriallaboral1.php');
     exit();
	 }

    ?>
	<table width="440" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
      <tr>
        <td width="184" bgcolor="#C5D5D6" class="Estilo2">&nbsp; Instituci&oacute;n <span class="Estilo4">*</span></td>
        <td width="240" class="Estilo1"><input name="institucionasignaturahistoriallaboral" type="text" id="institucionasignaturahistoriallaboral" value="<?php echo $row['institucionasignaturahistoriallaboral'];?>" size="40"></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6"  class="Estilo2">&nbsp; Nombre de la Facultad <span class="Estilo4">*</span></td>
        <td class="Estilo1"><input name="nombrefacultadasignaturahistoriallaboral" type="text" id="nombrefacultadasignaturahistoriallaboral" value="<?php echo $row['nombrefacultadasignaturahistoriallaboral'];?>" size="40"></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6"  class="Estilo2">&nbsp; Nombre Asignatura</strong> <span class="Estilo4">*</span></td>
        <td class="Estilo1"><input name="nombreasignaturahistoriallaboral" type="text" id="nombreasignaturahistoriallaboral" value="<?php echo $row['nombreasignaturahistoriallaboral'];?>" size="40"></td>
      </tr>
    </table>
    <p class="Estilo1">
      <input name="modificar" type="hidden" value="<?php echo $_GET['modificar']; ?>">
    </p>
  </div>
  <p align="center">
    <span class="Estilo1">
    <input type="submit" name="Submit" value="Modificar">
    </span> </p>
</form>
<p>&nbsp;</p>
<?php
mysql_free_result($Recordset1);
?>
