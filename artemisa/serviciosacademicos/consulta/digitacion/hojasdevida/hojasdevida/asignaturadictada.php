<?php require_once('../../../../Connections/conexion.php');session_start();?>
<link href="file:///D|/Mis%20documentos/universidad/home/links.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Estilo1 {font-size: 14px; font-family: Tahoma;}
.Estilo2 {font-size: 12px; font-family: Tahoma; }
.Estilo3 {color: #FF0000}
-->
</style>
<body class="Estilo2"><form action="asignaturadictada.php" method="post" name="form1" class="style1">
 
 <h6 align="center" class="Estilo1">ACTIVIDADES OTRAS UNIVERSIDADES </h6>
 <div align="center">
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
    
	
	  $base= "select * from asignaturahistoriallaboral where numerodocumento = '".$_SESSION['numerodocumento']."'";
       $sol=mysql_db_query($database_conexion,$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol); 
	   
	    if (! $row)
	  {
	    echo"";
	  }
	  else
	  { ?>
	      <br>&nbsp;</br>
    <table width="700" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
      <tr class="style1">
        <td bgcolor="#C5D5D6"><div align="center" class="Estilo2"><strong>Instituci&oacute;n</strong></div></td>
		     <td bgcolor="#C5D5D6"><div align="center" class="Estilo2"><strong>Facultad</strong></div></td>
		     <td bgcolor="#C5D5D6"><div align="center" class="Estilo2"><strong>Asignatura</strong></div></td>
        <td bgcolor="#C5D5D6"><div align="center" class="Estilo2">&nbsp;</div></td>
      </tr>
<?php 	   
		 do{  ?>
	      <td><div align="center" class="Estilo2"><?php echo $row['institucionasignaturahistoriallaboral'];?></div></td>
          <td><div align="center" class="Estilo2"><?php echo $row['nombrefacultadasignaturahistoriallaboral'];?></div></td>
          <td><div align="center" class="Estilo2"><?php echo $row['nombreasignaturahistoriallaboral'];?></div></td>
          <td><div align="center" class="Estilo2"><?php echo "<a href='modificarasignaturahistoriallaboral.php?modificar=".$row['idasignaturahistoriallaboral']."'>MODIFICAR</a>" ?></div></td>
          </tr>
		  <?php }while ($row=mysql_fetch_array($sol)); }?>
	</table>
        <?php
   if (($_POST['institucionasignaturahistoriallaboral'] == "")or ($_POST['nombrefacultadasignaturahistoriallaboral'] == "")or ($_POST['nombreasignaturahistoriallaboral'] == ""))
   {
     echo  "<h5>Recuerde que los campos con <span class='Estilo3'>*</span> son obligatorios</h5>";
   }
else 
     {
	 
     require_once('capturaasignaturadictada.php');
     }

    ?>
      </p> 
      <table width="440" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
        <tr>
          <td bgcolor="#C5D5D6" class="Estilo2"><strong>&nbsp; Instituci&oacute;n <span class="Estilo3">*</span></strong></td>
          <td width="240"><input name="institucionasignaturahistoriallaboral" type="text" id="institucionasignaturahistoriallaboral" value="<?php echo $_POST['institucionasignaturahistoriallaboral'];?>" size="40"></td>
        </tr>
        <tr>
          <td bgcolor="#C5D5D6" class="Estilo2"><strong>&nbsp; Nombre de la Facultad<strong> <span class="Estilo3">*</span></strong></strong></td>
          <td><input name="nombrefacultadasignaturahistoriallaboral" type="text" id="nombrefacultadasignaturahistoriallaboral" value="<?php echo $_POST['nombrefacultadasignaturahistoriallaboral'];?>" size="40"></td>
        </tr>
        <tr>
          <td bgcolor="#C5D5D6" class="Estilo2"><strong>&nbsp; Nombre Asignatura<strong> <span class="Estilo3">*</span></strong></strong></td>
          <td><input name="nombreasignaturahistoriallaboral" type="text" id="nombreasignaturahistoriallaboral" value="<?php echo $_POST['nombreasignaturahistoriallaboral'];?>" size="40"></td>
        </tr>
    </table>
      <div align="right"></div>
      <p>
        <input type="submit" name="Submit" value="Grabar">
    </p>
      <p align="right"><strong><span class="style7"><span class="Estilo8"><a href="cursodictado.php">Continuar >></a></span></span></strong></p>
 </div>
</form>
