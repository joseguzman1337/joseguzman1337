<?php require_once('../../Connections/egresado.php');
session_start();
?>
<style type="text/css">
<!--
.style1 {
	font-family: Tahoma;
	font-size: small;
}
.style5 {
	font-size: small;
	font-weight: bold;
}
.style7 {font-size: x-small}
.style9 {font-size: x-small; font-weight: bold; }
.style10 {font-size: xx-small}
.Estilo1 {font-family: Tahoma}
.Estilo8 {color: #003333}
.Estilo10 {font-size: small}
-->
</style>
<link href="file:///D|/Mis%20documentos/universidad/home/links.css" rel="stylesheet" type="text/css">
<body class="style1">
<form name="form1" method="post" action="academica.php">
  <div align="center">
 
    <h6 align="center" class="style5 style7 style7">FORMACI&Oacute;N ACADEMICA </h6>
    <div align="center">
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
    
         <?php echo "<h3>",$row['nombresdocente'],"  ",$row['apellidosdocente'],"   ",$row['numerodocumento'],"</h3>";?>
         
          <?php }while ($row=mysql_fetch_array($sol)); 
    
	   
	  $base= "select * from 
	         historialacademico,tipogrado 
			 where ((numerodocumento = '".$_SESSION['numerodocumento']."')
			 and(historialacademico.codigotipogrado=tipogrado.codigotipogrado))
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
      	<table width="700" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333"> 
		 <tr class="style1">
		<td width="80" class="style7" bgcolor="#C6CFD0"><div align="center" class="Estilo1"><span class="style9">Modalidad</span></div></td>
		<td width="80" class="style7" bgcolor="#C6CFD0"><div align="center" class="Estilo1"><span class="style9">Titulo</span></div></td>
		<td width="80" class="style7" bgcolor="#C6CFD0"><div align="center" class="Estilo1"><span class="style9"> Instituci&oacute;n</span></div></td>
		<td width="80" class="style7" bgcolor="#C6CFD0"><div align="center" class="Estilo1"><span class="style9">Lugar</span></div></td>
		<td width="80" class="style7" bgcolor="#C6CFD0"><div align="center" class="Estilo1"><span class="style9">Fecha</span></div></td>
		 <?php
		 do{  ?>     
          <p class="style7">
          
            <p class="style7"></p>
			    <tr class="style1">
				<td width="80" class="style7"><div align="center" class="Estilo1"><?php echo $row['nombretipogrado'];?></div></td>
                <td width="148" class="style7">
                  <div align="center" class="Estilo1"><?php echo $row['tituloobtenidohistorialacademico'];?></div></td>
                <td width="181" class="style7">
                  <div align="center" class="Estilo1"><?php echo $row['institucionhistorialacademico'];?></div></td>
                <td width="82" class="style7">
                  <div align="center" class="Estilo1"><?php echo $row['lugarhistorialacademico'];?></div></td>
                <td width="95" class="style7">
                  <div align="center" class="Estilo1"><?php echo $row['fechagradohistorialacademico'];?></div></td>
                
                <?php }while ($row=mysql_fetch_array($sol)); }
    ?>
  </table>
<?php
//
mysql_select_db($database_conexion, $conexion);
$query_Recordset1 = "SELECT * FROM tipogrado";
$Recordset1 = mysql_query($query_Recordset1, $conexion) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>      </p>
      <br>
  </div>
  <table width="500" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
      <tr>
        <td bgcolor="#C6CFD0"><span class="style9"><span class="style10">-&gt;</span> Titulo:</span></td>
        <td><input name="tituloobtenidohistorialacademico" type="text" id="tituloobtenidohistorialacademico" value="<?php echo $_POST['tituloobtenidohistorialacademico'];?>" size="40">        </td>
      </tr>
      <tr>
        <td bgcolor="#C6CFD0"><span class="style9"><span class="style10">-&gt;</span> Instituci&oacute;n: </span></td>
        <td><input name="institucionhistorialacademico" type="text" id="institucionhistorialacademico" value="<?php echo $_POST['institucionhistorialacademico'];?>" size="40"></td>
      </tr>
      <tr>
        <td bgcolor="#C6CFD0"><span class="style9"><span class="style10">-&gt;</span> Lugar: </span></td>
        <td><input name="lugarhistorialacademico" type="text" id="lugarhistorialacademico" value="<?php echo $_POST['lugarhistorialacademico'];?>" size="40"></td>
      </tr>
      <tr>
        <td bgcolor="#C6CFD0"><span class="style9"><span class="style10">-&gt;</span> A&ntilde;o : </span></td>
        <td>          <span class="Estilo10">
          <input name="ano" type="text" id="ano" value="<?php echo $_POST['ano'];?>" size="2">
</span></td>
      </tr>
      <tr>
        <td bgcolor="#C6CFD0"><span class="style9"><span class="style10">-&gt;</span>Modalidad: </span></td>
        <td><span class="style7">
          <select name="codigotipogrado" id="codigotipogrado">
            <option value="value" <?php if (!(strcmp("value", $_POST['codigotipogrado']))) {echo "SELECTED";} ?>>Seleccionar</option>
            <?php
do {  
?>
            <option value="<?php echo $row_Recordset1['codigotipogrado']?>"<?php if (!(strcmp($row_Recordset1['codigotipogrado'], $_POST['codigotipogrado']))) {echo "SELECTED";} ?>><?php echo $row_Recordset1['nombretipogrado']?></option>
            <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
          </select>
        </span></td>
      </tr>
    </table>
    <p>
      <input type="submit" name="Submit" value="Grabar">
</p>
    <p align="right"><strong><span class="style7"><span class="Estilo8 style10 style10"><a href="historiallaboral.php">Continuar >></a></span> </span></strong></p>
  </div>
</form>
<?php 	
if ($_POST['Submit'])
{ 
   if (($_POST['tituloobtenidohistorialacademico'] == "")or($_POST['institucionhistorialacademico'] == "") or ($_POST['lugarhistorialacademico'] == "")or  ($_POST['codigotipogrado'] == 0))
   {
      echo '<script language="JavaScript">alert("Los campos con -> son requeridos")</script>';			    
   }  
/* else
   	if (! checkdate($_POST['mes'],$_POST['dia'],$_POST['ano']))
	  {
       echo '<script language="JavaScript">alert("La fecha digitada es incorrecta")</script>';			
      }*/
 else 
   if($_POST['ano'] < 1900 or $_POST['ano'] > date("Y",time()))
    {
	   echo '<script language="JavaScript">alert("Año Incorrecto")</script>';			
	}      
else 
     {	
     require_once('capturaacademica.php');
     }
}
    ?>