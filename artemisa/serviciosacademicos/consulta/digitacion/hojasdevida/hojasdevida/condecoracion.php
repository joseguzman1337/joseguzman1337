<?php require_once('../../../../Connections/conexion.php');session_start();?>
<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
.Estilo3 {font-family: Tahoma; font-size: 14px; }
.Estilo4 {font-family: Tahoma; font-size: 12px; font-weight: bold; color: #FF0000}
-->
</style>
<form name="form1" method="post" action="condecoracion.php">
<div align="center">
  <h6>  <span class="Estilo3">CONDECORACIONES</span></h6>
    <p class="Estilo2">
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
	  $base= "select * from condecoracion,tipocondecoracion where ((numerodocumento = '".$_SESSION['numerodocumento']."')and(condecoracion.codigotipocondecoracion=tipocondecoracion.tipocondecoracion))";
       $sol=mysql_db_query($database_conexion,$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol); 
	   
	    if (! $row)
	  {
	    echo"";
	  }
	  else
	  {  ?>
	      </span><br>
	      &nbsp;<table width="700" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
      <tr class="style1">
             <td bgcolor="#C5D5D6"><div align="center" class="Estilo1"><strong>Tipo</strong></div></td>
		     <td bgcolor="#C5D5D6"><div align="center" class="Estilo2">Nombre</div></td>
		     <td bgcolor="#C5D5D6"><div align="center" class="Estilo2">Instituci&oacute;n</div></td>
        <td width="70" bgcolor="#C5D5D6"><div align="center" class="Estilo2">&nbsp;</div></td>
      </tr>
<?php        
		 do{  ?>     
      <td class="Estilo1"><div align="center" class="style1"><?php echo $row['nombretipocondecoracion'];?></div></td>
          <td class="Estilo1"><div align="center" class="style1"><?php echo $row['nombrecondecoracion'];?></div></td>
          <td class="Estilo1"><div align="center" class="style1"><?php echo $row['institucioncondecoracion'];?></div><div align="center" class="style1"></div></td>
	    <td width="70" class="Estilo1"><div align="center" class="style1"><?php echo "<a href='modificarcondecoracion.php?modificar=".$row['idcondecoracion']."'>MODIFICAR</a>" ?></div></td>
		  </tr>
		  <?php }while ($row=mysql_fetch_array($sol)); }?>
		  </table>
          <?php
mysql_select_db($database_conexion, $conexion);
$query_Recordset1 = "SELECT * FROM tipocondecoracion ORDER BY tipocondecoracion.tipocondecoracion";
$Recordset1 = mysql_query($query_Recordset1, $conexion) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
        
      <span class="style1">
      <?php
	
   if (($_POST['nombrecondecoracion'] == "")or($_POST['institucioncondecoracion'] == "") or ($_POST['codigotipocondecoracion'] == 0))
   {
     echo  "<h5>Recuerde que los campos con <span class='Estilo4'>*</span> son obligatorios</h5>";
   }

else 
     {
     require_once('capturacondecoracion.php');
	 exit();
     }

    ?>
    </span>      </p>
    <table width="430" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo2">&nbsp; Nombre del Premio<span class="Estilo4"> *</span></strong></td>
        <td width="240" class="style1"><input name="nombrecondecoracion" type="text" id="nombrecondecoracion" value="<?php echo $_POST['nombrecondecoracion'];?>" size="40"></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo2">&nbsp; Conferido por<span class="Estilo4"> *</span></td>
        <td class="style1"><input name="institucioncondecoracion" type="text" id="institucioncondecoracion" value="<?php echo $_POST['institucioncondecoracion'];?>" size="40"></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo2">&nbsp; Tipo de Premio<span class="Estilo4"> * </span></td>
        <td class="style1"><select name="codigotipocondecoracion" id="codigotipocondecoracion">
          <option value="value" <?php if (!(strcmp("value", $_POST['codigotipocondecoracion']))) {echo "SELECTED";} ?>>Seleccionar</option>
          <?php
do {  
?>
          <option value="<?php echo $row_Recordset1['tipocondecoracion']?>"<?php if (!(strcmp($row_Recordset1['tipocondecoracion'], $_POST['codigotipocondecoracion']))) {echo "SELECTED";} ?>><?php echo $row_Recordset1['nombretipocondecoracion']?></option>
          <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
        </select></td>
      </tr>
    </table>
    <p>
      <span class="style1">
      <input type="submit" name="Submit" value="Grabar">
    </span></p>
  </div>
</form>
<?php
mysql_free_result($Recordset1);
?>
