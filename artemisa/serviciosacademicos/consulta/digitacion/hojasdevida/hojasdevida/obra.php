<?php require_once('../../../../Connections/conexion.php');session_start();?>
<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
.Estilo3 {font-family: Tahoma; font-size: 14px; }
.Estilo4 {font-family: Tahoma; font-size: 12px; font-weight: bold; color: #FF0000}
-->
</style>
<link href="file:///D|/Mis%20documentos/universidad/home/links.css" rel="stylesheet" type="text/css">
<td width="300">    <form action="obra.php" method="post" name="form1" class="style1">
   <h6 align="center" class="Estilo3">PUBLICACIONES</h6>
    <div align="center">
          <span class="Estilo2"><span class="Estilo2">
          <?php
       		
 	   $base= "select * from docente where numerodocumento = '".$_SESSION['numerodocumento']."'";
       $sol=mysql_db_query($database_conexion,$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol); 
	   if(! $row)
	   {
	     echo "La Información básica es obligatoria";
		 echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=docente.php'>";
	   }
   else   
		 do
		{  ?>
          <?php echo "<font size='2' face='Tahoma'><strong>",$row['nombresdocente'],"&nbsp;&nbsp;",$row['apellidosdocente'],"&nbsp;&nbsp;&nbsp;",$row['numerodocumento'],"";?>
          <?php }while ($row=mysql_fetch_array($sol)); 
	   $base= "select * from autoria,tipoautoria where ((numerodocumento = '".$_SESSION['numerodocumento']."')and(autoria.codigotipoautoria=tipoautoria.codigotipoautoria))";
       $sol=mysql_db_query($database_conexion,$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol); 
	   
	    if (! $row)
	  {
	    echo"";
	  }
	  else
	  { ?>
	      </span><br>&nbsp;
	      <table width="700" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
           <tr class="style1">
             <td bgcolor="#C5D5D6"><div align="center" class="Estilo1"><strong>Modalidad</strong></div></td>
		     <td bgcolor="#C5D5D6"><div align="center" class="Estilo2">Titulo</div></td>
		     <td bgcolor="#C5D5D6"><div align="center" class="Estilo2">Referencia</div></td>
		     <td bgcolor="#C5D5D6"><div align="center" class="Estilo2">&nbsp;</div></td>
           </tr>
<?php    
	do{  ?>
     <p align="center"></p>
	     <tr class="Estilo1"><td><div align="center"><?php echo $row['nombretipoautoria'];?>&nbsp;</div></td>
           <td><div align="center"><?php echo $row['nombreautoria'];?>&nbsp;</div></td>
           <td><div align="center"><?php echo $row['referenciaautoria'];?>&nbsp;</div></td>
         <td><div align="center"><?php echo "<a href='modificarobra.php?modificar=".$row['idautoria']."'>MODIFICAR</a>" ?></div></td>
    <?php }while ($row=mysql_fetch_array($sol)); }?>
<?php
	mysql_select_db($database_conexion, $conexion);
	$query_Recordset1 = "SELECT * FROM tipoautoria";
	$Recordset1 = mysql_query($query_Recordset1, $conexion) or die(mysql_error());
	$row_Recordset1 = mysql_fetch_assoc($Recordset1);
	$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
   </table>
   <span class="Estilo2" align="center">   <?php
   if (($_POST['nombreautoria'] == "") or ($_POST['codigotipoautoria'] == 0))
   {
     echo  "<h5>Recuerde que los campos con <span class='Estilo4'>*</span> son obligatorios</h5>";
   }  
else 
     {
     require_once('capturaobra.php');
	 exit();
     }

    ?>
   <div align="center">
     <table width="480" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
            <tr>
              <td bgcolor="#C5D5D6" class="Estilo2">&nbsp; T&iacute;tulo <span class="Estilo4">*</span></td>
                  <td width="300" class="Estilo1"><input name="nombreautoria" type="text" id="nombreautoria" value="<?php echo $_POST['nombreautoria'];?>" size="50"></td>
            </tr>
            <tr>
              <td bgcolor="#C5D5D6" class="Estilo2">&nbsp; Referencia</td>
              <td class="Estilo1"><input name="referenciaautoria" type="text" id="referenciaautoria" value="<?php echo $_POST['referenciaautoria'];?>" size="50"></td>
            </tr>
            <tr>
              <td bgcolor="#C5D5D6" class="Estilo2">&nbsp; Tipo de Publicaci&oacute;n<span class="Estilo4">*</span></td>
                  <td class="Estilo1">
                    <select name="codigotipoautoria" id="codigotipoautoria">
                      <option value="value" <?php if (!(strcmp("value", $_POST['codigotipoautoria']))) {echo "SELECTED";} ?>>Seleccionar</option>
                      <?php
do {  
?>
                      <option value="<?php echo $row_Recordset1['codigotipoautoria']?>"<?php if (!(strcmp($row_Recordset1['codigotipoautoria'], $_POST['codigotipoautoria']))) {echo "SELECTED";} ?>><?php echo $row_Recordset1['nombretipoautoria']?></option>
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
      </table>
     <p class="Estilo1"><br> 
         <input type="submit" name="Submit" value="Grabar">
</p>
     <p align="right" class="Estilo1"><a href="membresia.php" class="Estilo2">Continuar &gt;&gt; </a></p>
   </div>
</div>
    </form>    </td>
            