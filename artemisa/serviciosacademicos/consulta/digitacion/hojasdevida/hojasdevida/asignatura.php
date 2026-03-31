<?php require_once('Connections/conexion.php');session_start();?>
<p align="center" class="Estilo1">
<style type="text/css">
<!--
.style1 {
	font-family: Tahoma;
	font-size: x-small;
}
.style3 {font-size: x-small}
.style4 {font-weight: bold}
.style5 {font-size: x-small; font-weight: bold; }
.style6 {
	font-size: small;
	font-weight: bold;
}
.Estilo1 {font-size: small}
-->
</style>
<style type="text/css">
<!--
.Estilo1 {font-family: tahoma}
.Estilo3 {font-family: tahoma; font-size: 12px; }
-->
</style>
<style type="text/css">
<!--
.Estilo1 {font-family: tahoma}
.Estilo2 {font-size: 10px}
.Estilo3 {font-family: tahoma; font-size: 10px; }
-->
</style>
<style type="text/css">
<!--
.style6 {font-size: x-small; font-weight: bold; }
.Estilo1 {font-family: tahoma}
.Estilo2 {font-size: x-small; font-weight: bold; font-family: tahoma; }
-->
</style>
<style type="text/css">
<!--
.Estilo2 {font-family: thahoma}
.style6 {font-size: x-small; font-weight: bold; }
.Estilo3 {font-size: 10px}
.Estilo4 {font-size: 10}
.Estilo5 {font-size: x-small}
.Estilo6 {font-size: small}
.Estilo7 {font-size: small; font-weight: bold; }
-->
</style>
<style type="text/css">
<!--
.style6 {font-size: x-small; font-weight: bold; }
.Estilo8 {font-family: tahoma}
.Estilo9 {font-size: x-small; font-weight: bold; font-family: tahoma; }
-->
</style>
<style type="text/css">
<!--
.Estilo9 {font-family: tahoma}
.Estilo10 {font-size: small}
.Estilo12 {font-size: x-small}
.Estilo13 {font-family: tahoma; font-size: x-small; }
.style6 {font-size: x-small; font-weight: bold; }
-->
</style>
<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma}
.Estilo2 {font-size: small}
.Estilo3 {font-weight: bold}
.Estilo4 {font-size: x-small}
.Estilo8 {color: #003333}
.style7 {font-size: x-small}
-->
</style>
<style type="text/css">
<!--
.Estilo1 {font-weight: bold}
.Estilo2 {font-family: tahoma}
.Estilo3 {font-size: small}
.Estilo4 {font-size: x-small}
.Estilo5 {font-family: tahoma; font-size: x-small; }
.Estilo6 {font-size: xx-small}
-->
</style>
<style type="text/css">
<!--
.Estilo1 {font-family: tahoma}
.Estilo2 {font-size: small}
-->
</style>
<style type="text/css">
<!--
.Estilo1 {font-weight: bold}
-->
</style>
<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma}
.Estilo2 {
	font-size: small;
	font-family: Tahoma;
}
.Estilo3 {font-size: large}
.Estilo4 {font-size: x-small}
.Estilo5 {font-size: small}
-->
</style>
<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma}
.Estilo2 {font-size: large}
.Estilo3 {font-size: x-small}
-->
</style>
<body class="style1 Estilo1 Estilo2 Estilo1">
<form name="form1" method="post" action="asignatura.php">
  <p align="center" class="Estilo2 style6"><strong><span class="Estilo3">FACULTAD Y ASIGNATURAS DICTADAS UNIVERSIDAD EL BOSQUE</span><br>
  </strong><span class="Estilo5"><?php
       		
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
  </span>  </p>
  <p align="center" class="style1">
    <?php echo "<h3>",$row['nombresdocente'],"&nbsp;&nbsp;",$row['apellidosdocente'],"&nbsp;&nbsp;&nbsp;",$row['numerodocumento'],"</h3>";?>
    <?php }while ($row=mysql_fetch_array($sol)); 
    
	
	    		
 	   $base= "select * from facultad,asignatura,asignaturadocente where ((asignatura.codigoasignatura = asignaturadocente.codigoasignatura) and (facultad.codigofacultad = asignaturadocente.codigofacultad)and (numerodocumento = '".$_SESSION['numerodocumento']."'))";
       $sol=mysql_db_query($database_conexion,$base);
	   $totalRows = mysql_num_rows($sol);
       $row=mysql_fetch_array($sol); 
	   
	    if (! $row)
	  {
	    echo"";
	  }
	  else
	  {   
	          
		 do{  ?>
  </p>
    <div align="center" class="Estilo1">
     <table width="828" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
       <p></p>
        <tr><td width="300">          <div align="center" class="Estilo4"><?php echo $row['nombrefacultad'];?></div></td>
            <td width="200">              <div align="center" class="Estilo4"><?php echo $row['nombreasignatura'];?></div></td>
            <td width="214"><div align="center" class="Estilo4"><?php echo $row['ubicacionasignaturadocente'];?></div></td>
            <td width="86">              <div align="center" class="Estilo4"><?php echo "<a href='modificarasignatura.php?modificar=".$row['idasignaturadocente']."'>MODIFICAR</a>" ?></div></td>
            <?php }while ($row=mysql_fetch_array($sol)); }?>
         <p align="center" class="Estilo5">    
		   <?php
mysql_select_db($database_conexion, $conexion);
$query_Recordset1 = "SELECT * FROM facultad ORDER BY facultad.nombrefacultad";
$Recordset1 = mysql_query($query_Recordset1, $conexion) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_conexion, $conexion);
$query_Recordset2 = "SELECT * FROM asignatura ORDER BY asignatura.nombreasignatura";
$Recordset2 = mysql_query($query_Recordset2, $conexion) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);
?> 
		   
         <p align="center">
      </table>
	
     <span class="Estilo5">
     <?php
   if (($_POST['codigofacultad'] == "")or ($_POST['codigoasignatura'] == "")or ($_POST['ubicacionasignaturadocente'] == ""))
   {?>
     </span>     
     <p align="right">     
       <?php     echo  "<h5>Los Campos con -> son Requeridos</h5>";
   }
else 
     {
     require_once('capturaasignatura.php');
     }

    ?>
       <br>
     </div>
    <div align="center" class="Estilo1">
        <table width="728" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
          <tr>
            <td width="373" bgcolor="#C6CFD0" class="Estilo9"><div align="center" class="style6 Estilo4 Estilo3">
              <div align="left"><strong>-&gt; Nombre de la Facultad: </strong></div>
            </div></td>
            <td width="349" class="Estilo3">              <span class="Estilo4">
              <select name="codigofacultad" id="codigofacultad">
                <option value="""" <?php if (!(strcmp("", $_POST['codigofacultad']))) {echo "SELECTED";} ?>>Seleccionar</option>
                <?php
do {  
?>
                <option value="<?php echo $row_Recordset1['codigofacultad']?>"<?php if (!(strcmp($row_Recordset1['codigofacultad'], $_POST['codigofacultad']))) {echo "SELECTED";} ?>><?php echo $row_Recordset1['nombrefacultad']?></option>
                <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
              </select>
            </span> </td>
          </tr>
          <tr>
            <td bgcolor="#C6CFD0" class="Estilo13"><span class="style6 Estilo4 Estilo3"><strong>-&gt; Nombre de la Asignatura: </strong></span></td>
            <td><strong><span class="Estilo4">
              <select name="codigoasignatura" id="codigoasignatura">
                <option value="""" <?php if (!(strcmp("", $_POST['codigoasignatura']))) {echo "SELECTED";} ?>>Seleccionar</option>
                <?php
do {  
?>
                <option value="<?php echo $row_Recordset2['codigoasignatura']?>"<?php if (!(strcmp($row_Recordset2['codigoasignatura'], $_POST['codigoasignatura']))) {echo "SELECTED";} ?>><?php echo $row_Recordset2['nombreasignatura']?></option>
                <?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
      mysql_data_seek($Recordset2, 0);
	  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
?>
              </select>
            </span></strong></td>
          </tr>
          <tr>
            <td bgcolor="#C6CFD0" class="Estilo9"><div align="center" class="style4 Estilo6 Estilo8 Estilo9 Estilo12 Estilo4 Estilo3">
              <div align="left"><span class="style6"><strong>-&gt; Lugar Actividad Unbosque:</strong></span></div>
            </div></td>
            <td><span class="Estilo4"><strong>
            <input name="ubicacionasignaturadocente" type="text" id="ubicacionasignaturadocente" value="<?php echo $_POST['ubicacionasignaturadocente'] ?>" size="40">
            </strong></span></td>
          </tr>
          <tr bgcolor="#C6CFD0">
            <td colspan="2" class="Estilo3"><div align="center" class="Estilo4"><strong><span class="style7 Estilo4 Estilo3">Una vez diligenciado el formulario haga click <a href="asignaturadictada.php">aqu&iacute;</a> para continuar </span></strong></div></td>
          </tr>
        </table>
  </div>
      <p align="center" class="Estilo3"><span class="Estilo1">
      <input type="submit" name="Submit" value="Enviar">
      </span> </p>
</form>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);
?>
