<?php require_once('../../../../Connections/conexion.php');session_start();?>

<?php
mysql_select_db($database_conexion, $conexion);
$query_Recordset1 = "SELECT * FROM idioma ORDER BY idioma.codigoidioma";
$Recordset1 = mysql_query($query_Recordset1, $conexion) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold;}
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
.Estilo4 {color: #FF0000}
-->
</style>
<link href="file:///D|/Mis%20documentos/universidad/home/links.css" rel="stylesheet" type="text/css">
<form name="form1" method="post" action="idioma.php">
  <div align="center" class="style1">
    <h6 align="center" class="Estilo3"><strong>IDIOMAS</strong></h6>
    <p align="center" class="Estilo2">
      <?php
       		
 	   $base= "select * from docente where numerodocumento = '".$_SESSION['numerodocumento']."'";
       $sol=mysql_db_query($database_conexion,$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol); 
        if (! $row){
		 echo "La información básica es obligatoria";
		 echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=docente.php'>";
		}  
	  else   
		 do
		{  ?>
      <?php echo "<font size='2' face='Tahoma'><strong>",$row['nombresdocente'],"&nbsp;&nbsp;",$row['apellidosdocente'],"&nbsp;&nbsp;&nbsp;",$row['numerodocumento'],"";?>
      <?php }while ($row=mysql_fetch_array($sol)); 
    
	
	  $base= "select * from lengua,idioma where ((numerodocumento = '".$_SESSION['numerodocumento']."')and(lengua.codigoidioma=idioma.codigoidioma))";
       $sol=mysql_db_query($database_conexion,$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol); 
	   
	    if (! $row)
	  {
	    echo"";
	  }
	  else
	  {?>
	      <br>&nbsp;</br>
<table width="700" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
      <tr class="style1">
        <td bgcolor="#C5D5D6"><div align="center" class="Estilo2">Idioma</div></td>
		     <td bgcolor="#C5D5D6"><div align="center" class="Estilo2">Nivel de conversaci&oacute;n</div></td>
		     <td bgcolor="#C5D5D6"><div align="center" class="Estilo2">Nivel de lectura </div></td>
			 <td bgcolor="#C5D5D6"><div align="center" class="Estilo2">Nivel de redacci&oacute;n</div></td>
        <td width="70" bgcolor="#C5D5D6"><div align="center" class="Estilo2">&nbsp;</div></td>
      </tr>
<?php       
		 do{?>   
        <td><div align="center" class="Estilo1"><?php echo $row['nombreidioma'];?></div></td>
        <td><div align="center" class="Estilo1"><?php echo $row['hablalengua'];?></div></td>
        <td><div align="center" class="Estilo1"><?php echo $row['leelengua'];?></div></td>
        <td><div align="center" class="Estilo1"><?php echo $row['escribelengua'];?></div></td>
        <td width="70"><div align="center" class="Estilo1"><?php echo "<a href='modificaridioma.php?modificar=".$row['idlengua']."'>MODIFICAR</a>" ?></div></td>
         </tr>
		<?php }while ($row=mysql_fetch_array($sol)); }?>
    </table>
   
      <?php
	   
   if (($_POST['codigoidioma'] == "")or($_POST['hablalengua'] == "") or ($_POST['leelengua'] == "")or ($_POST['escribelengua'] == ""))
   {
     echo  "<h5>Recuerde que los campos con <span class='Estilo4'>*</span> son obligatorios</h5>";
   }
else 
     {
     require_once('capturaidioma.php');
	 exit();
     }

    ?>
     </p>
    <table width="310" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
      <tr>
        <td width="173" bgcolor="#C5D5D6" class="Estilo2">&nbsp; Idioma<span class="Estilo4"> *</span></td>
        <td width="121" class="Estilo1"><select name="codigoidioma" id="codigoidioma">
            <option value="""" <?php if (!(strcmp("", $_POST['codigoidioma']))) {echo "SELECTED";} ?>>Seleccionar</option>
            <?php
do {  
?>
            <option value="<?php echo $row_Recordset1['codigoidioma']?>"<?php if (!(strcmp($row_Recordset1['codigoidioma'], $_POST['codigoidioma']))) {echo "SELECTED";} ?>><?php echo $row_Recordset1['nombreidioma']?></option>
            <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
        </select>
  
  </td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo2">&nbsp; Nivel de conversaci&oacute;n<strong><span class="Estilo4"> *</span></strong></td>
        <td class="Estilo1">
        <select name="hablalengua" id="select3">
          <option value="" <?php if (!(strcmp("", $_POST['hablalengua']))) {echo "SELECTED";} ?>>Seleccionar</option>
          <option value="Nulo" <?php if (!(strcmp("Nulo", $_POST['hablalengua']))) {echo "SELECTED";} ?>>Nulo</option>
          <option value="Basico" <?php if (!(strcmp("Basico", $_POST['hablalengua']))) {echo "SELECTED";} ?>>Basico</option>
          <option value="Intermedio" <?php if (!(strcmp("Intermedio", $_POST['hablalengua']))) {echo "SELECTED";} ?>>Intermedio</option>
          <option value="Avanzado" <?php if (!(strcmp("Avanzado", $_POST['hablalengua']))) {echo "SELECTED";} ?>>Avanzado</option>
          <option value="Dominio Completo" <?php if (!(strcmp("Dominio Completo", $_POST['hablalengua']))) {echo "SELECTED";} ?>>Dominio Completo</option>
        </select>
</span></span></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo2">&nbsp; Nivel de lectura<strong><span class="Estilo4"> *</span></strong></td>
        <td class="Estilo1">
          <select name="leelengua" id="leelengua">
            <option value="" <?php if (!(strcmp("", $_POST['leelengua']))) {echo "SELECTED";} ?>>Seleccionar</option>
            <option value="Nulo" <?php if (!(strcmp("Nulo", $_POST['leelengua']))) {echo "SELECTED";} ?>>Nulo</option>
            <option value="Basico" <?php if (!(strcmp("Basico", $_POST['leelengua']))) {echo "SELECTED";} ?>>Basico</option>
            <option value="Intermedio" <?php if (!(strcmp("Intermedio", $_POST['leelengua']))) {echo "SELECTED";} ?>>Intermedio</option>
            <option value="Avanzado" <?php if (!(strcmp("Avanzado", $_POST['leelengua']))) {echo "SELECTED";} ?>>Avanzado</option>
            <option value="Dominio Completo" <?php if (!(strcmp("Dominio Completo", $_POST['leelengua']))) {echo "SELECTED";} ?>>Dominio Completo</option>
          </select>
        </span></span></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo2">&nbsp;  Nivel de redacci&oacute;n<strong><span class="Estilo4"> *</span></strong></td>
        <td class="Estilo1">
          <select name="escribelengua" id="escribelengua">
            <option value="" <?php if (!(strcmp("", $_POST['escribelengua']))) {echo "SELECTED";} ?>>Seleccionar</option>
            <option value="Nulo" <?php if (!(strcmp("Nulo", $_POST['escribelengua']))) {echo "SELECTED";} ?>>Nulo</option>
            <option value="Basico" <?php if (!(strcmp("Basico", $_POST['escribelengua']))) {echo "SELECTED";} ?>>Basico</option>
            <option value="Intermedio" <?php if (!(strcmp("Intermedio", $_POST['escribelengua']))) {echo "SELECTED";} ?>>Intermedio</option>
            <option value="Avanzado" <?php if (!(strcmp("Avanzado", $_POST['escribelengua']))) {echo "SELECTED";} ?>>Avanzado</option>
            <option value="Dominio Completo" <?php if (!(strcmp("Dominio Completo", $_POST['escribelengua']))) {echo "SELECTED";} ?>>Dominio Completo</option>
          </select>
        </span></span></td>
      </tr>
    </table>
    <p class="Estilo1">
      <input type="submit" name="Submit" value="Grabar">
</p>
    <p align="right" class="Estilo2"><a href="obra.php">Continuar >></a></p>
  </div>
</form>


<?php
mysql_free_result($Recordset1);
?>
