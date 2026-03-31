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
<form name="form1" method="post" action="membresia.php">
<div align="center">
  <h6 align="center" class="Estilo3"><strong>SOCIEDADES Y ASOCIACIONES CIENT&Iacute;FICAS </strong></h6>
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
    
	
	  $base= "select * from membresia where numerodocumento = '".$_SESSION['numerodocumento']."'";
       $sol=mysql_db_query($database_conexion,$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol); 
	   
	    if (! $row)
	  {
	    echo"";
	  }
	  else
	  {  ?>
	      </span><br>&nbsp;
	      <table width="500" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
           <tr class="Estilo2">
             <td bgcolor="#C5D5D6"><div align="center" class="Estilo1"><strong>Instituci&oacute;n</strong></div></td>
		     <td width="70" bgcolor="#C5D5D6"><div align="center" class="Estilo2">&nbsp;</div></td>
           </tr>
<?php    
		 do{  ?>
         <tr>
		  <td class="Estilo1"><div align="center"><?php echo $row['nombremembresia'];?></div></td>
          <td width="70" class="Estilo1"><div align="center"><?php echo "<a href='modificarmembresia.php?modificar=".$row['idmembresia']."'>MODIFICAR</a>" ?></div></td>
          </tr>
		  <?php }while ($row=mysql_fetch_array($sol)); }?>
    </table>
    <span class="Estilo2">   
	 <?php
	 
   if ($_POST['nombremembresia'] == "")
   {
     echo  "<h5>Recuerde que los campos con <span class='Estilo4'>*</span> son obligatorios</h5>";
   }
else
{  
	   require_once('capturamembresia.php');
	   exit();
     }

    ?>
</span>
    <table border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
      <tr>
        <td bgcolor="#C5D5D6" class="Estilo2">&nbsp; Instituci&oacute;n <span class="Estilo4">*</span>&nbsp;</td>
        <td class="Estilo1"><input name="nombremembresia" type="text" id="nombremembresia" value="<?php echo $_POST['nombremembresia'];?>" size="40"></td>
      </tr>
    </table>
    
    <p class="style1">
      <input type="submit" name="Submit" value="Grabar">
</p>
    <p align="right"><a href="condecoracion.php" class="Estilo2">Continuar >></a></p>
  </div>
</form>

