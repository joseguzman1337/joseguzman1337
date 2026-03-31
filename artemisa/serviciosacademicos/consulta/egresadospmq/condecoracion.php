<?php require_once('../../Connections/egresado.php');session_start();?>
<style type="text/css">
<!--
.style1 {
	font-family: Tahoma;
	font-size: x-small;
}
.style3 {
	font-family: Tahoma;
	font-size: small;
	font-weight: bold;
}
.Estilo1 {font-family: Tahoma}
.Estilo5 {font-family: Tahoma; font-size: x-small; font-weight: bold; }
-->
</style>

<form name="form1" method="post" action="condecoracion.php">
<div align="center">
  <h6>  <span class="Estilo5">CONDECORACIONES</span></h6>
    <p class="style1">
      <?php
       		
 	   $base= "select * from docente where numerodocumento = '".$_SESSION['numerodocumento']."'";
       $sol=mysql_db_query($database_conexion,$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol); 
        if (! $row){
		 echo "La Informaciòn Basica es Requerida";
		 echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=docente.php'>";
		}
	else  
		 do
		{  ?>
      <?php echo "<h3>",$row['nombresdocente'],"&nbsp;&nbsp;",$row['apellidosdocente'],"&nbsp;&nbsp;&nbsp;",$row['numerodocumento'],"</h3>";?>
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
	  { ?>       
<table width="639" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">        
 <tr>
  <td bgcolor="#C6CFD0" width="172" class="Estilo1"><div align="center" class="style1"><strong>Tipo de Premio</strong></div></td>
   <td bgcolor="#C6CFD0" width="172" class="Estilo1"><div align="center" class="style1"><strong>Nombre del Premio</strong></div></td>
    <td bgcolor="#C6CFD0" width="172" class="Estilo1"><div align="center" class="style1"><strong>Conferido</strong></div></td>
</tr>
<?php do{  ?>
      <tr>
      <td width="172" class="Estilo1"><div align="center" class="style1"><?php echo $row['nombretipocondecoracion'];?></div></td>
      <td width="204" class="Estilo1"><div align="center" class="style1"><?php echo $row['nombrecondecoracion'];?></div></td>
      <td width="131" class="Estilo1"><div align="center" class="style1"><?php echo $row['institucioncondecoracion'];?></div><div align="center" class="style1"></div></td>
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
    </span></p>
    <table width="500" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
      <tr>
        <td width="206" bgcolor="#C6CFD0" class="style1"><strong>-&gt; Nombre del Premio: </strong></td>
        <td width="288" class="style1"><input name="nombrecondecoracion" type="text" id="nombrecondecoracion" value="<?php echo $_POST['nombrecondecoracion'];?>" size="40"></td>
      </tr>
      <tr>
        <td bgcolor="#C6CFD0" class="style1"><strong><strong>-&gt; </strong>Conferido por:</strong></td>
        <td class="style1"><input name="institucioncondecoracion" type="text" id="institucioncondecoracion" value="<?php echo $_POST['institucioncondecoracion'];?>" size="40"></td>
      </tr>
      <tr>
        <td width="192" bgcolor="#C6CFD0" class="style1"><strong><strong>-&gt; </strong>Tipo de Premio:</strong></td>
        <td width="282" class="style1"><select name="codigotipocondecoracion" id="codigotipocondecoracion">
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
  <p align="right" class="style1"><strong><span class="style7"><span class="Estilo8"><a href="obra.php">Continuar >></a></span></span></strong></p>
</form>
        
      
<?php
if ($_POST['Submit'])
{ 	
   if (($_POST['nombrecondecoracion'] == "")or($_POST['institucioncondecoracion'] == "") or ($_POST['codigotipocondecoracion'] == 0))
   {
    echo '<script language="JavaScript">alert("Los campos con -> son requeridos")</script>';	
   }

else 
     {
     require_once('capturacondecoracion.php');
     }
}
?>