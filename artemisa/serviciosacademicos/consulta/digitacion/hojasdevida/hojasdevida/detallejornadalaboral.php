<?php require_once('../../../../Connections/conexion.php');session_start();?>
<?php
mysql_select_db($database_conexion, $conexion);
$query_Recordset1 = "SELECT * FROM dia";
$Recordset1 = mysql_query($query_Recordset1, $conexion) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12; }
.Estilo2 {font-family: Tahoma; font-size: 14px; font-weight: bold}
.Estilo4 {color: #FF0000}
-->
</style>
<div align="center">
  <form name="form1" method="post" action="">
    <p align="center" class="Estilo2">DETALLE ACTIVIDAD<br>&nbsp;</br>
          <?php       		
 	   $base= "select * from docente where numerodocumento = '".$_SESSION['numerodocumento']."'";
       $sol=mysql_db_query($database_conexion,$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol); 
     
		 do
		{  ?>
      <?php echo "<font size='2' face='Tahoma'><strong>",$row['nombresdocente'],"&nbsp;&nbsp;",$row['apellidosdocente'],"&nbsp;&nbsp;&nbsp;",$row['numerodocumento'],"</strong>";?>
         <?php }while ($row=mysql_fetch_array($sol));   
		   $base= "select * from facultad,jornadalaboral,tipolabor 
		           where facultad.codigofacultad = jornadalaboral.codigofacultad
				   and tipolabor.codigotipolabor=jornadalaboral.codigotipolabor
				   and jornadalaboral.idjornadalaboral = '".$_GET['detalle']."'
				   ";
		   $sol=mysql_db_query($database_conexion,$base);
		   $totalRows = mysql_num_rows($sol);
		   $row=mysql_fetch_array($sol);
	   ?>
	      <br>&nbsp;</br>
    <div align="center">
      <table width="700" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
      	<tr class="style1">
       	  <td bgcolor="#C5D5D6"><div align="center" class="Estilo1"><strong>Actividad</strong></div></td>
			<td bgcolor="#C5D5D6"><div align="center" class="Estilo1"><strong>Facultad</strong></div></td>
			<td bgcolor="#C5D5D6"><div align="center" class="Estilo1"><strong>Asignatura</strong></div></td>
    	</tr>
  <?php  
	   
	   do {?>    
           <tr>
             <td><div align="center" class="Estilo1"><?php echo $row['nombretipolabor'];?></div></td>
             <td><div align="center" class="Estilo1"><?php echo $row['nombrefacultad'];?></div></td>
             <td><div align="center" class="Estilo1"><?php echo $row['codigoasignatura'];?></div></td>
      </table>
      <?php }while ($row=mysql_fetch_array($sol)); ?>
             
    <?php
       $base1= "select * from detallejornadalaboral,dia 
	            where dia.codigodia = detallejornadalaboral.codigodia
				and detallejornadalaboral.idjornadalaboral ='".$_GET['detalle']."'
				order by dia.codigodia,detallejornadalaboral.horainicialdetallejornadalaboral";
       $sol1=mysql_db_query($database_conexion,$base1);
	   $totalRows1= mysql_num_rows($sol1);
       $row1=mysql_fetch_array($sol1); 
	    if (! $row1)
	  {
	    echo"";
	  }
	  else
	  {?>
	      <br>
          <table width="700" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
      	<tr class="style1">
       	  <td width="90" bgcolor="#C5D5D6"><div align="center" class="Estilo1"><strong>Ubicaci&oacute;n</strong></div></td>
			<td width="90" bgcolor="#C5D5D6"><div align="center" class="Estilo1"><strong>D&iacute;a</strong></div></td>
		  <td width="80" bgcolor="#C5D5D6"><div align="center" class="Estilo1"><strong>Hora inicial </strong></div></td>
		  <td width="80" bgcolor="#C5D5D6"><div align="center" class="Estilo1"><strong>Hora final </strong></div></td>
			<td bgcolor="#C5D5D6"><div align="center" class="Estilo1"><strong>Observaciones</strong></div></td>
		  <td width="70" bgcolor="#C5D5D6"><div align="center" class="Estilo1"><strong>&nbsp;</strong></div></td>
    	</tr>
  <?php 	   
		do {?>            
         <tr>
           <td width="90"><div align="center" class="Estilo1"><?php echo $row1['ubicaciondetallejornadalaboral'];?></div></td>
           <td width="90"><div align="center" class="Estilo1"><?php echo $row1['nombredia'];?></div></td>
           <td width="80"><div align="center" class="Estilo1"><?php echo $row1['horainicialdetallejornadalaboral'];?> <?php echo $row1['meridianohorainicialdetallejornadalaboral'];?></div></td>
           <td width="80"><div align="center" class="Estilo1"><?php echo $row1['horafinaldetallejornadalaboral'];?> <?php echo $row1['meridianohorafinaldetallejornadalaboral'];?></div></td>
           <td><div align="center" class="Estilo1"><?php echo $row1['observaciondetallejornadalaboral'];?>&nbsp;</div></td>
           <td width="70"><div align="center" class="Estilo1"><?php echo "<a href='modificardetallejornadalaboral.php?modificar=".$row1['iddetallejornadalaboral']."'>MODIFICAR</a>"?></div></td>
         </tr>
	   <?php }while ($row1=mysql_fetch_array($sol1));}?>
	   </table>
	   <?php  
 
 if (($_POST['ubicaciondetallejornadalaboral'] == "")or($_POST['codigodia'] == ""))
   {
    echo  "<h5>Recuerde que los campos con <span class='Estilo4'>*</span> son obligatorios</h5>";
   }
else
     if (! checkdate($_POST['horainicialdetallejornadalaboral'],1,1)or(! checkdate($_POST['horafinaldetallejornadalaboral'],1,1))){ 
     echo "<h4>La hora no es correcta</h4>";
   }   
else
     if((date("h-i",strtotime($_POST['horafinaldetallejornadalaboral']))) < (date("h-i",strtotime($_POST['horainicialdetallejornadalaboral'])))and($_POST['empezar']==$_POST['terminar']))
	 {
	   echo "<h4>La hora final es mayor a la hora inicial</h4>";
	 }
else 
     {
     require_once('capturadetallejornadalaboral.php');	
	 }  
   
    ?>  
           
       </p>
         </span>
         <table border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
           <tr>
             <td bgcolor="#C5D5D6" class="Estilo1"><strong>&nbsp; Ubicaci&oacute;n (Instituci&oacute;n / Ofic. &oacute; Sal&oacute;n/ Tel&eacute;fono)<strong> <span class="Estilo4">*</span></strong></strong></td>
             <td class="Estilo1"><input name="ubicaciondetallejornadalaboral" type="text" id="ubicaciondetallejornadalaboral" value="<?php echo  $_POST['ubicaciondetallejornadalaboral'] ?>" size="40"></td>
           </tr>
           <tr>
             <td bgcolor="#C5D5D6" class="Estilo1"><strong>&nbsp; D&iacute;a<strong> <span class="Estilo4">*</span></strong></strong></td>
             <td class="Estilo1"><select name="codigodia" id="codigodia">
               <option value="" <?php if (!(strcmp("", $_POST['codigodia']))) {echo "SELECTED";} ?>>Seleccionar</option>
               <?php
do {  
?>
               <option value="<?php echo $row_Recordset1['codigodia']?>"<?php if (!(strcmp($row_Recordset1['codigodia'], $_POST['codigodia']))) {echo "SELECTED";} ?>><?php echo $row_Recordset1['nombredia']?></option>
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
           <tr>
             <td bgcolor="#C5D5D6" class="Estilo1"><strong>&nbsp; Hora inicio<strong> <span class="Estilo4">*</span></strong></strong></td>
             <td class="Estilo1"><input name="horainicialdetallejornadalaboral" type="text" id="horainicialdetallejornadalaboral" value="<?php echo  $_POST['horainicialdetallejornadalaboral'] ?> " size="3">
               <select name="empezar" id="empezar">
                 <option value="AM" <?php if (!(strcmp("AM", $_POST['empezar']))) {echo "SELECTED";} ?>>AM</option>
                 <option value="PM" <?php if (!(strcmp("PM", $_POST['empezar']))) {echo "SELECTED";} ?>>PM</option>
               </select> 
               <span class="Estilo1">HH:MM</span>  </td>
           </tr>
           <tr>
             <td bgcolor="#C5D5D6" class="Estilo1"><strong>&nbsp; Hora final<strong> <span class="Estilo4">*</span></strong></strong></td>
             <td class="Estilo1"><input name="horafinaldetallejornadalaboral" type="text" id="horafinaldetallejornadalaboral" value="<?php echo  $_POST['horafinaldetallejornadalaboral'] ?>" size="3">
               <select name="terminar" id="terminar">
                 <option value="AM" <?php if (!(strcmp("AM", $_POST['terminar']))) {echo "SELECTED";} ?>>AM</option>
                 <option value="PM" <?php if (!(strcmp("PM", $_POST['terminar']))) {echo "SELECTED";} ?>>PM</option>
               </select>
               <span class="Estilo1">HH:MM</span></td>
           </tr>
           <tr>
             <td height="30" bgcolor="#C5D5D6" class="Estilo1"><strong>&nbsp; Observaciones</strong></td>
             <td class="Estilo1">
               <input name="observaciondetallejornadalaboral" type="text" id="observaciondetallejornadalaboral" value="<?php echo  $_POST['observaciondetallejornadalaboral'] ?>" size="50">
             </td>
           </tr>
      </table>
    </div>
    <p align="center" class="Estilo1">
      <input type="submit" name="Submit" value="Grabar">
</p>
    <p class="Estilo1">
      <input name="detalle" type="hidden" value="<?php echo $_GET['detalle']; ?>">
    </span> </p>
  </form>
</div>
<span class="Estilo1">
<?php
mysql_free_result($Recordset1);
?>
</span>