<?php require_once('../../../../Connections/conexion.php');session_start();?>
<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold;}
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
-->
</style>
<link href="file:///D|/Mis%20documentos/universidad/home/links.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Estilo4 {color: #FF0000}
-->
</style><form name="form1" method="post" action="investigacion.php">
<div align="center">
  <h6 align="center" class="Estilo3"><strong>INVESTIGACIONES O INVENTOS </strong></h6>
  <p class="Estilo1">
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
    
	  $base= "select * from investigacion,tipoinvestigacion where ((numerodocumento = '".$_SESSION['numerodocumento']."')and(investigacion.codigotipoinvestigacion=tipoinvestigacion.codigotipoinvestigacion)) ";
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
             <td bgcolor="#C5D5D6"><div align="center" class="Estilo1"><strong>Tipo</strong></div></td>
		     <td bgcolor="#C5D5D6"><div align="center" class="Estilo2">Titulo</div></td>
		     <td bgcolor="#C5D5D6"><div align="center" class="Estilo2">Instituci&oacute;n</div></td>
		     <td bgcolor="#C5D5D6"><div align="center" class="Estilo2"> Financiamiento </div></td>
		     <td bgcolor="#C5D5D6"><div align="center" class="Estilo2">Tiempo</div></td>
		     <td bgcolor="#C5D5D6"><div align="center" class="Estilo2">Lider</div></td>
			 <td bgcolor="#C5D5D6"><div align="center" class="Estilo2">Investigadores</div></td>
			 <td width="70" bgcolor="#C5D5D6"><div align="center" class="Estilo2">&nbsp;</div></td>
      </tr>
<?php 	   
		 do{  ?>
      <tr class="Estilo1">
	  <td class="Estilo1"><div align="center"><?php echo $row['nombretipoinvestigacion'];?>&nbsp;</div></td>
      <td class="Estilo1"><div align="center"><?php echo $row['tituloinvestigacion'];?>&nbsp;</div></td>
      <td class="Estilo1"><div align="center"><?php echo $row['institucioninvestigacion'];?>&nbsp;</div></td>
      <td class="Estilo1"><div align="center"><?php echo $row['entidadfinanciamientoinvestigacion'];?>&nbsp;</div></td>
      <td class="Estilo1"><div align="center"><?php echo $row['unidadtiempoinvestigacion'];?>&nbsp;<?php echo $row['tiempoinvestigacion'];?></div></td>
      <td class="Estilo1"><div align="center"><?php echo $row['liderinvestigacion'];?>&nbsp;</div></td>
      <td class="Estilo1"><div align="center"><?php echo $row['cantidadinvestigadores'];?>&nbsp;</div></td>
      <td class="Estilo1"><div align="center"><?php echo "<a href='modificarinvestigacion.php?modificar=".$row['idinvestigacion']."'>MODIFICAR</a>" ?></div></td>
      <?php }while ($row=mysql_fetch_array($sol)); }?>
    </table>
	  <?php
mysql_select_db($database_conexion, $conexion);
$query_Recordset1 = "SELECT * FROM tipoinvestigacion";
$Recordset1 = mysql_query($query_Recordset1, $conexion) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>   
 
  <p align="center" class="style1">
      <span class="Estilo2">
      <?php
   if (($_POST['tituloinvestigacion'] == "") or ($_POST['unidadtiempoinvestigacion'] == "")or ($_POST['tiempoinvestigacion'] == "")or ($_POST['liderinvestigacion'] == "")or ($_POST['cantidadinvestigadores'] == "")or ($_POST['codigotipoinvestigacion'] == 0))
   {
     echo  "<h5>Recuerde que los campos con <span class='Estilo4'>*</span> son obligatorios</h5>";
   }
else 
     {
     require_once('capturainvestigacion.php');
	 exit();
     }

    ?>
    </span><span class="Estilo2">      </span> </p>
    <table width="500" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo2"><strong>&nbsp; T&iacute;tulo Investigaci&oacute;n o Invento <span class="Estilo4">*</span></strong></td>
        <td width="240" class="Estilo1"><input name="tituloinvestigacion" type="text" id="tituloinvestigacion" value="<?php echo $_POST['tituloinvestigacion'];?>" size="40"></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo2">&nbsp; Instituci&oacute;n</td>
        <td class="Estilo1"><input name="institucioninvestigacion" type="text" id="institucioninvestigacion" value="<?php echo $_POST['institucioninvestigacion'];?>" size="40"></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo2">&nbsp; Entidad de Financiamiento</td>
        <td class="Estilo1"><input name="entidadfinanciamientoinvestigacion" type="text" id="entidadfinanciamientoinvestigacion" value="<?php echo $_POST['entidadfinanciamientoinvestigacion'];?>" size="40"></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo2">&nbsp; Tiempo Investigaci&oacute;n o Invento<span class="Estilo4">*</span></strong></strong></td>
        <td class="Estilo1"><input name="unidadtiempoinvestigacion" type="text" id="unidadtiempoinvestigacion" value="<?php echo $_POST['unidadtiempoinvestigacion'];?>" size="1">
          <select name="tiempoinvestigacion" id="tiempoinvestigacion">
            <option value="" <?php if (!(strcmp("", $_POST['tiempoinvestigacion']))) {echo "SELECTED";} ?>>Seleccionar</option>
            <option value="Horas" <?php if (!(strcmp("Horas", $_POST['tiempoinvestigacion']))) {echo "SELECTED";} ?>>Horas</option>
            <option value="Dias" <?php if (!(strcmp("Dias", $_POST['tiempoinvestigacion']))) {echo "SELECTED";} ?>>Dias</option>
            <option value="Semanas" <?php if (!(strcmp("Semanas", $_POST['tiempoinvestigacion']))) {echo "SELECTED";} ?>>Semanas</option>
            <option value="Meses" <?php if (!(strcmp("Meses", $_POST['tiempoinvestigacion']))) {echo "SELECTED";} ?>>Meses</option>
            <option value="A&ntilde;os"Años <?php if (!(strcmp("Años", $_POST['tiempoinvestigacion']))) {echo "SELECTED";} ?>>A&ntilde;os</option>
        </select></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo2">&nbsp; L&iacute;der Investigaci&oacute;n o Invento<strong> <span class="Estilo4">*</span></strong></strong></td>
        <td class="Estilo1"><input name="liderinvestigacion" type="text" id="liderinvestigacion" value="<?php echo $_POST['liderinvestigacion'];?>" size="40"></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo2">&nbsp; Cantidad de Investigadores<strong> <span class="Estilo4">*</span></strong></strong></td>
        <td class="Estilo1"><input name="cantidadinvestigadores" type="text" id="cantidadinvestigadores" value="<?php echo $_POST['cantidadinvestigadores'];?>" size="8"></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo2">&nbsp; Tipo de Investigaci&oacute;n o Invento<strong> <span class="Estilo4">*</span></strong></strong></td>
        <td class="Estilo1"><select name="codigotipoinvestigacion" id="codigotipoinvestigacion">
          <option value="value" <?php if (!(strcmp("value", $_POST['codigotipoinvestigacion']))) {echo "SELECTED";} ?>>Seleccionar</option>
          <?php
do {  
?>
          <option value="<?php echo $row_Recordset1['codigotipoinvestigacion']?>"<?php if (!(strcmp($row_Recordset1['codigotipoinvestigacion'], $_POST['codigotipoinvestigacion']))) {echo "SELECTED";} ?>><?php echo $row_Recordset1['nombretipoinvestigacion']?></option>
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
    <p class="style1">
      <input type="submit" name="Submit" value="Grabar">
</p>
    <p align="right" class="style1"><strong><span class="style7"> <span class="Estilo8"><a href="idioma.php">Continuar >></a></span></span></strong></p>
</div>
</form>
<?php
mysql_free_result($Recordset1);
?>
