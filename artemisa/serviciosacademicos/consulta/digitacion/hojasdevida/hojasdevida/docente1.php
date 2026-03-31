<?php require_once('../../../../Connections/conexion.php');session_start();?>
<style type="text/css">
<!--
.Estilo13 {font-family: Tahoma; font-size: 12px; }
.Estilo14 {
	font-size: 16px;
	font-family: Tahoma;
}
-->
</style>
<body class="Estilo9"><form name="form1" method="post" action="">
  <p align="center"><span class="Estilo10 Estilo14"><strong>INFORMACI&Oacute;N B&Aacute;SICA</strong></span></p>
  <div align="center" class="Estilo9"><strong>
    <?php       		
 	   //
	   $base= "select * from docente where numerodocumento = '".$_SESSION['numerodocumento']."'";
       $sol=mysql_db_query($database_conexion,$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol); 
          
	  
		 do
		{  ?>
    <?php echo "<font size='2' face='Tahoma'>",$row['nombresdocente'],"&nbsp;&nbsp;",$row['apellidosdocente'],"&nbsp;&nbsp;&nbsp;",$row['numerodocumento'],"";
   
	 }while ($row=mysql_fetch_array($sol)); ?>
  </strong></div>
  <span class="Estilo11">
  <?php  $base= "select * from docente,escalafondocente where ((numerodocumento = '".$_SESSION['numerodocumento']."')and(escalafondocente.codigoescalafondocente=docente.codigoescalafondocente))";
       $sol=mysql_db_query($database_conexion,$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol); 
	   
	   if (! $row)
	  {
	    echo"";
	  }
	  else
	  {   
      	 do{?>
  </h6>
<table width="500" border="1" align="center" cellpadding="1" cellspacing="2" bordercolor="#003333">
         <tr>
           <td width="130" bgcolor="#C5D5D6"><span class="Estilo13"><strong>&nbsp; G&eacute;nero </strong></span></td>
           <td>
           <div align="center" class="Estilo13"><font size="2" face="Tahoma"><?php echo $row['sexodocente'];?>&nbsp;</div></td>
         </tr>
         <tr>
           <td bgcolor="#C5D5D6"><span class="Estilo13"><strong>&nbsp; Nacimiento</strong></span></td>
           <td>
           <div align="center" class="Estilo13"><font size="2" face="Tahoma"><?php echo $row['fechanacimientodocente'];?>&nbsp;</div></td>
         </tr>
         <tr>
           <td bgcolor="#C5D5D6"><span class="Estilo13"><strong>&nbsp; Lugar</strong></span></td>
           <td>
           <div align="center" class="Estilo13"><font size="2" face="Tahoma"><?php echo $row['lugarnacimientodocente'];?>&nbsp;</div></td>
         </tr>
         <tr>
           <td bgcolor="#C5D5D6"><span class="Estilo13"><strong>&nbsp; Tel&eacute;fono Casa</strong></span></td>
           <td>
           <div align="center" class="Estilo13"><font size="2" face="Tahoma"><?php echo $row['telefonodocente'];?>&nbsp;</div></td>
         </tr>
         <tr>
           <td bgcolor="#C5D5D6"><span class="Estilo13"><strong>&nbsp; Tel&eacute;fono Oficina</strong></span></td>
           <td>
           <div align="center" class="Estilo13"><font size="2" face="Tahoma"><?php echo $row['telefonodocente2'];?>&nbsp;</div></td>
         </tr>
         <tr>
           <td bgcolor="#C5D5D6"><span class="Estilo13"><strong>&nbsp; Celular</strong></span></td>
           <td>
           <div align="center" class="Estilo13"><font size="2" face="Tahoma"><?php echo $row['celulardocente'];?>&nbsp;</div></td>
         </tr>
         <tr>
           <td bgcolor="#C5D5D6"><span class="Estilo13"><strong>&nbsp; C&oacute;digo Postal</strong></span></td>
           <td>
           <div align="center" class="Estilo13"><font size="2" face="Tahoma"><?php echo $row['codigopostaldocente'];?>&nbsp;</div></td>
         </tr>
         <tr>
           <td bgcolor="#C5D5D6"><span class="Estilo13"><strong>&nbsp; Direcci&oacute;n</strong></span></td>
           <td>
           <div align="center" class="Estilo13"><font size="2" face="Tahoma"><?php echo $row['direcciondocente'];?>&nbsp;</div></td>
         </tr>
         <tr>
           <td bgcolor="#C5D5D6"><span class="Estilo13"><strong>&nbsp; Ciudad</strong></span></td>
           <td>
           <div align="center" class="Estilo13"><font size="2" face="Tahoma"><?php echo $row['ciudaddocente'];?>&nbsp;</div></td>
         </tr>
         <tr>
           <td bgcolor="#C5D5D6"><span class="Estilo13"><strong>&nbsp; E-mail</strong></span></td>
           <td>
           <div align="center" class="Estilo13"><font size="2" face="Tahoma"><?php echo $row['emaildocente'];?>&nbsp;</div></td>
         </tr>
         <tr>
           <td bgcolor="#C5D5D6"><span class="Estilo13"><strong>&nbsp; Fax</strong></span></td>
           <td>
           <div align="center" class="Estilo13"><font size="2" face="Tahoma"><?php echo $row['faxdocente'];?>&nbsp;</div></td>
         </tr>
         <tr>
           <td bgcolor="#C5D5D6"><span class="Estilo13"><strong>&nbsp; Escalaf&oacute;n</strong></span></td>
           <td>
           <div align="center" class="Estilo13"><font size="2" face="Tahoma"><?php echo $row['nombreescalafondocente'];?>&nbsp;</div></td>
         </tr>
         <tr>
           <td colspan="2"><span class="Estilo13"></span>
             <div align="center" class="Estilo13"><strong><?php echo "<a href='modificardocente.php?modificar=".$row['numerodocumento']."'>MODIFICAR DATOS PERSONALES</a>" ?></strong></div></td>
           <?php }while ($row=mysql_fetch_array($sol));}?>
</table>
        
  <p align="right"><font size="2" face="Tahoma"><strong><a href="academica.php" target="_self">Continuar >></a></strong></p>
</form>
