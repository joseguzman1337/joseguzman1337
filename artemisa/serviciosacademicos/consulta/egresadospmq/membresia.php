<?php require_once('../../Connections/egresado.php');session_start(); ?>
<style type="text/css">
<!--
.style1 {
	font-family: Tahoma;
	font-size: x-small;
}
.style2 {font-size: small}
.style7 {font-size: x-small}
.Estilo8 {
	color: #003333;
	font-size: xx-small;
}
-->
</style>


<link href="file:///D|/Mis%20documentos/universidad/home/links.css" rel="stylesheet" type="text/css">
<form name="form1" method="post" action="membresia.php">
<div align="center">
  <h6 align="center" class="style1 style2 style7"><strong>SOCIEDADES Y ASOCIACIONES CIENTIFICAS </strong></h6>
  <h6 align="center" class="style1">
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
    
	
	  $base= "select * from membresia where numerodocumento = '".$_SESSION['numerodocumento']."'";
       $sol=mysql_db_query($database_conexion,$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol); 
	   
	    if (! $row)
	  {
	    echo"";
	  }
	  else
	  {?>  
	   
 <table width="400" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">     
   <tr>
     <td bgcolor="#C6CFD0" width="402" class="style1"><div align="center"><strong>Instituci&oacute;n</strong></div></td>
   </tr>  
<?php do{  ?>  
      <tr>
          <td width="402" class="style1"><div align="center"><?php echo $row['nombremembresia'];?></div></td>
      </tr>  
          <?php }while ($row=mysql_fetch_array($sol)); }?>
   
  </table>
    <span class="style1">   
	
    <br>
    <br>
    </span>
    <table width="500" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
      <tr>
        <td bgcolor="#C6CFD0" class="style1"><strong>-&gt; Instituci&oacute;n:</strong></td>
        <td class="style1"><input name="nombremembresia" type="text" id="nombremembresia" value="<?php echo $_POST['nombremembresia'];?>" size="40"></td>
      </tr>
    </table>
    
    <p class="style1">
      <input type="submit" name="Submit" value="Grabar">
</p>
    <p align="right" class="style1"><strong><span class="style7"><span class="Estilo8"><a href="condecoracion.php">Continuar >></a></span></span></strong></p>
  </div>
</form>
 <?php
if ($_POST['Submit'])
{ 		 
   if ($_POST['nombremembresia'] == "")
   {
    echo '<script language="JavaScript">alert("Los campos con -> son requeridos")</script>';	
   }
  else
   {      
     require_once('capturamembresia.php');
   }
}
?>
