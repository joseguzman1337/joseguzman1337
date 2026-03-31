<?php require_once('../../Connections/egresado.php');
session_start();
?>
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
<form name="form1" method="post" action="historiallaboral.php">
  <div align="center">
    <h6 class="style1 style2 style7"><strong>HISTORIA LABORAL </strong></h6>
    <p class="style1">
      <?php
       		
 	   $base= "select * from docente 
	           where numerodocumento = '".$_SESSION['numerodocumento']."'";
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
    
	
	   $base= "select * from historiallaboral 
	           where numerodocumento = '".$_SESSION['numerodocumento']."'
			   order by 6";
       $sol=mysql_db_query($database_conexion,$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol); 
	   
	    if (! $row)
	  {
	    echo"";
	  }
	  else
	  { ?>     
      
<table width="779" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">	
 <tr>
 <td width="145" class="style1" bgcolor="#C6CFD0"><div align="center"><strong>Instituci&oacute;n</strong></div></td>	
 <td width="145" class="style1" bgcolor="#C6CFD0"><div align="center"><strong>Cargo</strong></div></td>	
 <td width="145" class="style1" bgcolor="#C6CFD0"><div align="center"><strong>Dedicaci&oacute;n</strong></div></td>
 <td width="145" class="style1" bgcolor="#C6CFD0"><div align="center"><strong> Fecha Inicio</strong></div></td>	
 <td width="145" class="style1" bgcolor="#C6CFD0"><div align="center"><strong>Fecha Final</strong></div></td>		
<td width="145" class="style1" bgcolor="#C6CFD0"><div align="center"><strong>Escalaf&oacute;n</strong></div></td>	
</tr>
<tr>
<?php
 do{  ?>
      <td width="145" class="style1">
        <div align="center"><?php echo $row['empresahistoriallaboral'];?></div></td>
          <td width="144" class="style1">
          <div align="center"><?php echo $row['cargohistoriallaboral'];?></div></td>
          <td width="154" class="style1">
          <div align="center"><?php echo $row['tiempohistoriallaboral'];?></div></td>
          <td width="110" class="style1">
          <div align="center"><?php echo $row['fechainiciohistoriallaboral'];?></div></td>
          <td width="106" class="style1">
          <div align="center"><?php
		   if ($row['fechafinalhistoriallaboral'] == 0)
		     {
			   echo "Vigente";
			 }
			else
			 {
			   echo $row['fechafinalhistoriallaboral'];
			 }
		  ?>&nbsp;</div></td>
          <td width="120" class="style1">
          <div align="center"><?php echo $row['escalafondocenciahistoriallaboral'];?>&nbsp;</div></td>
        </tr>  
     <?php }while ($row=mysql_fetch_array($sol)); }?>
</table>
<?php
//
mysql_select_db($database_conexion, $conexion);
$query_Recordset1 = "SELECT * FROM tipohistoriallaboral";
$Recordset1 = mysql_query($query_Recordset1, $conexion) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>

<span class="style1"><br></span>
    <table width="500" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
      <tr>
        <td bgcolor="#C6CFD0" class="style1"><strong>-&gt; Instituci&oacute;n:</strong></td>
        <td class="style1"><input name="empresahistoriallaboral" type="text" id="empresahistoriallaboral" value="<?php echo $_POST['empresahistoriallaboral'];?>" size="40"></td>
      </tr>
      <tr>
        <td bgcolor="#C6CFD0" class="style1"><strong>-&gt; Cargo:</strong></td>
        <td class="style1"><input name="cargohistoriallaboral" type="text" id="cargohistoriallaboral" value="<?php echo $_POST['cargohistoriallaboral'];?>" size="40"></td>
      </tr>
      <tr>
        <td bgcolor="#C6CFD0" class="style1"><strong>-&gt; Dedicaci&oacute;n:</strong></td>
        <td class="style1"><input name="tiempohistoriallaboral" type="text" id="tiempohistoriallaboral" value="<?php echo $_POST['tiempohistoriallaboral'];?>"></td>
      </tr>
      <tr>
        <td bgcolor="#C6CFD0" class="style1"><strong>-&gt; A&ntilde;o Inicio: </strong></td>
        <td class="style1"><span class="style2">
            <input name="ano" type="text" id="ano" value="<?php echo $_POST['ano'];?>" size="2">
        </span></td>
      </tr>
      <tr>
        <td bgcolor="#C6CFD0" class="style1"><strong>&nbsp;&nbsp;&nbsp;&nbsp; A&ntilde;o Final: </strong></td>
        <td class="style1"><span class="style2">
            <input name="ano2" type="text" id="ano2" value="<?php echo $_POST['ano2'];?>" size="2">
        </span></td>
      </tr>
      <tr>
        <td bgcolor="#C6CFD0" class="style1"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Escalaf&oacute;n: </strong></td>
        <td class="style1"><input name="escalafondocenciahistoriallaboral" type="text" id="escalafondocenciahistoriallaboral" value="<?php echo $_POST['escalafondocenciahistoriallaboral'];?>"> 
        Para Educador </td>
      </tr>
      <tr>
        <td bgcolor="#C6CFD0" class="style1"><strong>-&gt; Tipo de Actividad: </strong></td>
        <td class="style1"><select name="codigohistoriallaboral" id="codigohistoriallaboral">
          <option value="value" <?php if (!(strcmp("value", $_POST['codigohistoriallaboral']))) {echo "SELECTED";} ?>>Seleccionar</option>
          <?php
do {  
?>
          <option value="<?php echo $row_Recordset1['codigotipohistoriallaboral']?>"<?php if (!(strcmp($row_Recordset1['codigotipohistoriallaboral'], $_POST['codigohistoriallaboral']))) {echo "SELECTED";} ?>><?php echo $row_Recordset1['nombretipohistoriallaboral']?></option>
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
    <p align="right" class="style1"><strong><span class="style7"><span class="Estilo8"><a href="membresia.php">Continuar >></a></span></span></strong> </p>
  </div>
</form>
<?php

if ($_POST['Submit'])
{ 	
   if (($_POST['empresahistoriallaboral'] == "")or($_POST['cargohistoriallaboral'] == "") or ($_POST['tiempohistoriallaboral'] == "")or ($_POST['codigohistoriallaboral'] == 0))
   {
      echo '<script language="JavaScript">alert("Los campos con -> son requeridos")</script>';			    
   }

else
  if (($_POST['ano2'] != "")and($_POST['ano'] > $_POST['ano2']))
	 {     
	   echo '<script language="JavaScript">alert("Año de Inicio No puede ser mayor al Año Final")</script>';	
	 }
else 
   if($_POST['ano'] < 1900 or $_POST['ano'] > date("Y",time()))
    {
	   echo '<script language="JavaScript">alert("Fecha Incorrecta")</script>';	
	}     

else
     {
     require_once('capturahistoriallaboral.php');
     }
}   
mysql_free_result($Recordset1);
?>
