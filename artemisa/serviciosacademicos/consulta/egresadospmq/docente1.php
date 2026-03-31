<?php require_once('../../Connections/egresado.php');session_start();?>
<style type="text/css">
<!--
.style5 {font-size: small;
	font-weight: bold;
}
.Estilo1 {font-family: tahoma}
.Estilo2 {font-size: x-small}
.Estilo4 {font-size: small; font-weight: bold; font-family: Tahoma; }
.Estilo5 {
	font-size: xx-small;
	font-family: Tahoma;
	font-weight: bold;
}
-->
</style>

<link href="file:///D|/Mis%20documentos/universidad/home/links.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Estilo6 {font-size: x-small; font-weight: bold; font-family: Tahoma; }
.Estilo11 {font-size: x-small; font-weight: bold; }
-->
</style>
<form name="form1" method="post" action="">
  <p align="center"><span class="Estilo6">INFORMACI&Oacute;N BASICA </span></p>
  <div align="center">
<?php       		
 	   $base1= "select * from carreraegresado c,carrera ca 
	           where c.numerodocumento = '".$_SESSION['numerodocumento']."'			  
			   and c.codigocarrera = ca.codigocarrera";
       $sol1=mysql_db_query($database_conexion,$base1);
	   $totalRows1 = mysql_num_rows($sol1);
       $row1=mysql_fetch_array($sol1);    
	   
	   $base= "select * from docente d
	           where d.numerodocumento = '".$_SESSION['numerodocumento']."'
			  ";
       $sol=mysql_db_query($database_conexion,$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol); 
 if (! $row)
	  {
	   echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=docente.php'>";
	   exit();
	  }
else
    {
	    echo "<h3>",$row['nombresdocente'],"&nbsp;&nbsp;",$row['apellidosdocente'],"&nbsp;&nbsp;&nbsp;",$row['numerodocumento'],"</h3>";
	
?>
  </h6>
   <div align="center" class="Estilo2">
       <table width="540" border="1" align="center" cellpadding="1" cellspacing="2" bordercolor="#003333">
         <tr>
           <td width="215" bgcolor="#C6CFD0"><span class="Estilo2 Estilo1 Estilo4"><strong><span class="Estilo2">-&gt; Sexo:</span><br>
           </strong></span></td>
           <td width="299">
           <div align="center"><?php echo $row['sexodocente'];?>&nbsp;</div></td>
         </tr>
         <tr>
           <td bgcolor="#C6CFD0"><span class="Estilo2 Estilo1 Estilo6"><strong>-&gt; Nacimiento:</strong></span></td>
           <td>
           <div align="center"><?php echo $row['fechanacimientodocente'];?>&nbsp;</div></td>
         </tr>
         <tr>
           <td bgcolor="#C6CFD0"><span class="Estilo2 Estilo1 Estilo6"><strong>-&gt; Lugar:</strong></span></td>
           <td>
           <div align="center"><?php echo $row['lugarnacimientodocente'];?>&nbsp;</div></td>
         </tr>
         <tr>
           <td bgcolor="#C6CFD0"><span class="Estilo2 Estilo1 Estilo6"><strong>-&gt; Tel&eacute;fono Casa:</strong></span></td>
           <td>
           <div align="center"><?php echo $row['telefonodocente'];?>&nbsp;</div></td>
         </tr>
         <tr>
           <td bgcolor="#C6CFD0"><span class="Estilo2 Estilo1 Estilo6"><strong>-&gt; Tel&eacute;fono Oficina:</strong></span></td>
           <td>
           <div align="center"><?php echo $row['telefonodocente2'];?>&nbsp;</div></td>
         </tr>
         <tr>
           <td bgcolor="#C6CFD0"><span class="Estilo2 Estilo1 Estilo6"><strong>-&gt; Celular:</strong></span></td>
           <td>
           <div align="center"><?php echo $row['celulardocente'];?>&nbsp;</div></td>
         </tr>
         <tr>
           <td bgcolor="#C6CFD0"><span class="Estilo2 Estilo1 Estilo6"><strong> -&gt;&nbsp;C&oacute;digo Postal: </strong></span></td>
           <td>
           <div align="center"><?php echo $row['codigopostaldocente'];?>&nbsp;</div></td>
         </tr>
         <tr>
           <td bgcolor="#C6CFD0"><span class="Estilo2 Estilo1 Estilo6"><strong>-&gt; Direcci&oacute;n:</strong></span></td>
           <td>
           <div align="center"><?php echo $row['direcciondocente'];?>&nbsp;</div></td>
         </tr>
         <tr>
           <td bgcolor="#C6CFD0"><span class="Estilo2 Estilo1 Estilo6"><strong>-&gt; Ciudad:</strong></span></td>
           <td>
           <div align="center"><?php echo $row['ciudaddocente'];?>&nbsp;</div></td>
         </tr>
         <tr>
           <td bgcolor="#C6CFD0"><span class="Estilo2 Estilo1 Estilo6"><strong>-&gt; E-mail:</strong></span></td>
           <td>
           <div align="center"><?php echo $row['emaildocente'];?>&nbsp;</div></td>
         </tr>
         <tr>
           <td bgcolor="#C6CFD0"><span class="Estilo2 Estilo1 Estilo6"><strong>-&gt;&nbsp;Fax:</strong></span></td>
           <td>
           <div align="center"><?php echo $row['faxdocente'];?></div></td>
         </tr>
         <tr>
           <td bgcolor="#C6CFD0"><span class="Estilo2 Estilo1 Estilo6"><strong>-&gt;&nbsp;<span class="Estilo11"><strong>&nbsp;Nombre Especializaci&oacute;n</strong></span>:</strong></span></td>
           <td>
           <div align="center"><?php echo $row1['nombrecarrera'];?>&nbsp;</div></td>
         </tr> 
<?php }?>
</table>
  <p align="right"><a href="academica.php" target="_self" class="Estilo5">Continuar >></a></p>
</form>
