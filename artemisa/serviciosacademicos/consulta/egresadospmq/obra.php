<?php require_once('../../Connections/egresado.php');session_start();?>
<style type="text/css">
<!--
.style1 {
	font-family: Tahoma;
	font-size: x-small;
}
.style2 {
	font-size: small;
	font-weight: bold;
}
.style7 {font-size: x-small}
.style4 {font-size: x-small; font-weight: bold; }
-->
</style>

<link href="file:///D|/Mis%20documentos/universidad/home/links.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Estilo1 {
	font-size: xx-small;
	font-weight: bold;
}
-->
</style>
<td width="300">    <form action="obra.php" method="post" name="form1" class="style1">
   <h6 align="center" class="style2 style7">VINCULOS EMPRESA SALUD </h6>
    <div align="center">
     <?php
       		
 	   $base= "select * from docente where numerodocumento = '".$_SESSION['numerodocumento']."'";
       $sol=mysql_db_query($database_conexion,$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol); 
	   if(! $row)
	   {
	     echo "La Informaciòn Basica es Requerida";
		 echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=docente.php'>";
	   }
   else   
		 do
		{  ?>
<?php echo "<h3>",$row['nombresdocente'],"&nbsp;&nbsp;",$row['apellidosdocente'],"&nbsp;&nbsp;&nbsp;",$row['numerodocumento'],"</h3>";?>
<?php }while ($row=mysql_fetch_array($sol)); 
    
	
	   $base= "select * from autoria
	           where numerodocumento = '".$_SESSION['numerodocumento']."'";
       $sol=mysql_db_query($database_conexion,$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol); 
	   
	    if (! $row)
	  {
	    echo"";
	  }
	  else
	  { ?>  
  <table width="500" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">     
  <tr>
  <td bgcolor="#C6CFD0" width="223"><div align="center"><span class="style4">Instituci&oacute;n</span></div></td>
  <td bgcolor="#C6CFD0" width="223"><div align="center"><span class="style4">Observaci&oacute;n</span></div></td>
 </tr>
<?php do{  ?>
   
     <p align="center"></p>
	     <tr>
		   <td width="223">
	       <div align="center"><?php echo $row['nombreautoria'];?></div></td>
           <td width="261">
           <div align="center"><?php echo $row['referenciaautoria'];?>&nbsp;</div></td>
		 </tr>           
    <?php }while ($row=mysql_fetch_array($sol)); }?>
 </table>
   <br>
   <div align="center">
     <table width="500" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
            <tr>
              <td width="173" bgcolor="#C6CFD0"><span class="style4">-&gt; Instituci&oacute;n: </span></td>
                  <td width="311"><input name="nombreautoria" type="text" id="nombreautoria" value="<?php echo $_POST['nombreautoria'];?>" size="50"></td>
            </tr>
            <tr>
              <td bgcolor="#C6CFD0"><span class="style4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Observaci&oacute;n: </span></td>
              <td><input name="referenciaautoria" type="text" id="referenciaautoria" value="<?php echo $_POST['referenciaautoria'];?>" size="50"></td>
            </tr>
      </table>
     <p><br> 
         <input type="submit" name="Submit" value="Grabar">
</p>
     <p align="right" class="Estilo1"><a href="cuestionario.php">Continuar &gt;&gt; </a></p>
   </div>
</div>
    </form>   
<?php
if ($_POST['Submit'])
{ 	
   if ($_POST['nombreautoria'] == "")
   {
     echo '<script language="JavaScript">alert("Los Campos con -> son requeridos")</script>';	
   }  
else 
     {
     require_once('capturaobra.php');
     }
}
    ?>
            