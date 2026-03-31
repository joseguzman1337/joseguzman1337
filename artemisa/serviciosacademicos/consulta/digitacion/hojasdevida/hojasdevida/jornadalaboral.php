<?php require_once('../../../../Connections/conexion.php');session_start();?>
<p align="center" class="Estilo1">
<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo2 {font-family: Tahoma; font-size: 14px}
-->
</style>
<style type="text/css">
<!--
.Estilo2 {
	font-family: Tahoma;
	font-size: 14px;
}
-->
</style>
<style type="text/css">
<!--
.Estilo2 {
	font-size: 14px;
	font-family: Tahoma;
}
-->
</style>
<style type="text/css">
<!--
.Estilo2 {font-family: Tahoma}
.Estilo3 {font-size: 12px}
.Estilo4 {
	font-family: Tahoma;
	font-size: 12px;
	color: #FF0000;
}
-->
</style><body class="Estilo1">
<form name="form1" method="post" action="jornadalaboral.php">
  <p align="center" class="Estilo2"><strong>ACTIVIDADES UNBOSQUE</strong></p>
    
	<div align="center" class="Estilo1">
      
	  <?php
       		
 	   $base= "select * from docente where numerodocumento = '".$_SESSION['numerodocumento']."'";
       $sol=mysql_db_query($database_conexion,$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol); 
      if (! $row){
		 echo "La Información básica es obligatoria";
		 echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=docente.php'>";
		}  
	  else   
		 do
		{  ?>
<?php echo "<font size='2' face='Tahoma'><strong>",$row['nombresdocente'],"&nbsp;&nbsp;",$row['apellidosdocente'],"&nbsp;&nbsp;&nbsp;",$row['numerodocumento'],"";?>
		<?php }while ($row=mysql_fetch_array($sol)); 
		//and(asignatura.codigoasignatura = jornadalaboral.codigoasignatura) 
	    		
 	   $base= "select * from facultad,jornadalaboral,tipolabor 
	           where facultad.codigofacultad = jornadalaboral.codigofacultad
			   and tipolabor.codigotipolabor=jornadalaboral.codigotipolabor
			   and jornadalaboral.numerodocumento = '".$_SESSION['numerodocumento']."'
			   ";
       $sol=mysql_db_query($database_conexion,$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol); 
	   
	    if (! $row)
	  {
	    echo"";
	  }
	  else
	  { ?>
        <div align="center">        &nbsp;</br>
        </div>
  </div>
		<div align="center">
          <table width="700" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
      <tr class="style1">
        <td bgcolor="#C5D5D6"><div align="center" class="Estilo1"><strong>Actividad</strong></div></td>
        <td bgcolor="#C5D5D6"><div align="center" class="Estilo1"><strong>Facultad</strong></div></td>
        <td bgcolor="#C5D5D6"><div align="center" class="Estilo1"><strong>Asignatura</strong></div></td>
        <td bgcolor="#C5D5D6"><div align="center" class="Estilo1"><strong>&nbsp;</strong></div></td>
        <td bgcolor="#C5D5D6"><div align="center" class="Estilo1">&nbsp;</div></td>
      </tr>
  <?php 	          
		 do{  ?>
      <tr><td><div align="center" class="Estilo1"><?php echo $row['nombretipolabor'];?></div></td>
          <td><div align="center" class="Estilo1"><?php echo $row['nombrefacultad'];?></div></td>
          <td><div align="center" class="Estilo1"><?php echo $row['codigoasignatura'];?></div></td>
          <td><div align="center" class="Estilo1"><?php echo "<a href='detallejornadalaboral.php?detalle=".$row['idjornadalaboral']."'>JORNADA LABORAL</a>"?></span></div></td>
          <td><div align="center" class="Estilo1"><?php echo "<a href='modificarjornadalaboral.php?modificar=".$row['idjornadalaboral']."'>MODIFICAR</a>"?></div></td>
          <?php }while ($row=mysql_fetch_array($sol)); }?>
   	     <?php
mysql_select_db($database_conexion, $conexion);
$query_Recordset1 = "SELECT * FROM facultad ORDER BY facultad.nombrefacultad";
$Recordset1 = mysql_query($query_Recordset1, $conexion) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_conexion, $conexion);
$query_Recordset2 = "SELECT * FROM asignatura ORDER BY asignatura.nombreasignatura";
$Recordset2 = mysql_query($query_Recordset2, $conexion) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

mysql_select_db($database_conexion, $conexion);
$query_Recordset3 = "SELECT * FROM tipolabor";
$Recordset3 = mysql_query($query_Recordset3, $conexion) or die(mysql_error());
$row_Recordset3 = mysql_fetch_assoc($Recordset3);
$totalRows_Recordset3 = mysql_num_rows($Recordset3);
?>         
          </table>
          <?php
   if (($_POST['codigofacultad'] == "")or ($_POST['codigotipolabor'] == ""))
   {?>
       
          <?php echo  "<h5>Recuerde que los campos con <span class='Estilo4'>*</span> son obligatorios</h5>";
   }
else 
     {
     require_once('capturajornadalaboral.php');
	exit();
     }

    ?>
          <div align="center" class="Estilo1">
        </div>
		<table border="1" align="center" cellpadding="1" cellspacing="2" bordercolor="#003333">
          <tr>
            <td bgcolor="#C5D5D6" class="Estilo1"><strong>&nbsp; Labor o Actividad <span class="Estilo4">*</span></strong></td>
            <td  class="Estilo1"><select name="codigotipolabor" id="codigotipolabor">
                <option value="" <?php if (!(strcmp("", $_POST['codigotipolabor']))) {echo "SELECTED";} ?>>Seleccionar</option>
                <?php
do {  
?>
                <option value="<?php echo $row_Recordset3['codigotipolabor']?>"<?php if (!(strcmp($row_Recordset3['codigotipolabor'], $_POST['codigotipolabor']))) {echo "SELECTED";} ?>><?php echo $row_Recordset3['nombretipolabor']?></option>
                <?php
} while ($row_Recordset3 = mysql_fetch_assoc($Recordset3));
  $rows = mysql_num_rows($Recordset3);
  if($rows > 0) {
      mysql_data_seek($Recordset3, 0);
	  $row_Recordset3 = mysql_fetch_assoc($Recordset3);
  }
?>
            </select>
            </strong> </td>
          </tr>
          <tr>
            <td bgcolor="#C5D5D6" class="Estilo1"><strong>&nbsp; Nombre de la Facultad<strong> <span class="Estilo4">*</span></strong></strong></td>
            <td><span class="Estilo1">
              <select name="codigofacultad" id="select2">
                <option value="" <?php if (!(strcmp("", $_POST['codigofacultad']))) {echo "SELECTED";} ?>>Seleccionar</option>
                <?php
do {  
?>
                <option value="<?php echo $row_Recordset1['codigofacultad']?>"<?php if (!(strcmp($row_Recordset1['codigofacultad'], $_POST['codigofacultad']))) {echo "SELECTED";} ?>><?php echo $row_Recordset1['nombrefacultad']?></option>
                <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
              </select>
            </span>
            </strong></td>
          </tr>
          <tr>
            <td bgcolor="#C5D5D6"  class="Estilo1"><strong>&nbsp; Nombre de la Asignatura <strong> <span class="Estilo4">* </span></strong></strong></td>
            <td><span class="Estilo1">
			     <select name="codigoasignatura" id="select">
                <option value="" <?php if (!(strcmp("", $_POST['codigoasignatura']))) {echo "SELECTED";} ?>>Seleccionar</option>
                <?php
do {  
?>
                <option value="<?php echo $row_Recordset2['nombreasignatura']?>"<?php if (!(strcmp($row_Recordset2['nombreasignatura'], $_POST['codigoasignatura']))) {echo "SELECTED";} ?>><?php echo $row_Recordset2['nombreasignatura']?></option>
                <?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
      mysql_data_seek($Recordset2, 0);
	  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
?>
              </select>
            </span></td>
          </tr>
          <tr bgcolor="#C5D5D6">
            <td colspan="2" class="Estilo1"><div align="center"><strong> Una vez diligenciado el formulario contin&uacute;e con Jornada Laboral </strong>
            </div></td>
          </tr>
      </table>
  </div>
  <p align="center" class="Estilo3"><span class="Estilo1">
      <input type="submit" name="Submit" value="Grabar">
</span></p>
      <p align="right" class="Estilo1"><strong><a href="asignaturadictada.php">Continuar &gt;&gt;</a> </strong></p>
</form>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);

mysql_free_result($Recordset3);
?>
