<?php require_once('../../../Connections/sala2.php');
session_start(); 

if (! isset ($_SESSION['nombreprograma']))
 {?>
 <script>
   window.location.reload("../login.php");
 </script>
<?php	
 }
 else 
 if ($_SESSION['nombreprograma'] <> "menucrearnuevoestudiante.php")
{?>
 <script>
   window.location.reload("../login.php");
 </script>
<?php	
 }
?>
<?php	   
if ($_POST['guardar'])
{
                   $bases= "select * from estudiante where codigoestudiante = '".$_POST['codigo']."'";
				   $sols=mysql_db_query($database_sala,$bases);
				   $totalRowss= mysql_num_rows($sols);
				   $rows=mysql_fetch_array($sols);
				   if ($rows <> "")
				     {
					 echo '<script language="JavaScript">alert("Registro ya existe")</script>';
					 echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=crearnuevoestudiante.php'>";	        	     
	                 exit();
					 }   


			       $base= "select * from periodo where codigoestadoperiodo = 1";
				   $sol=mysql_db_query($database_sala,$base);
				   $totalRows= mysql_num_rows($sol);
				   $row=mysql_fetch_array($sol); 
	   if (!eregi("^[0-9]{1,15}$", $_POST['documento']))
		{
		echo '<script language="JavaScript">alert("El documento es Incorrecto")</script>';
        }
       else 
       if (!eregi("^[0-9]{1,15}$", $_POST['codigo']))
		{
		echo '<script language="JavaScript">alert("El código es Incorrecto")</script>';
        }
       else 
		
		if ($_POST['codigo']== "")
		{
		echo '<script language="JavaScript">alert("El Código es requerido")</script>';
        }
       else 
	   if ($_POST['carrera']== 0)
		{
		echo '<script language="JavaScript">alert("La Facultad es requerida")</script>';
        }
       else 
	   if ($_POST['jornada']== 0)
		{
		echo '<script language="JavaScript">alert("La jornada es requerida")</script>';
        }
	   else 
	   if ($_POST['semestre']== 0)
		{
		echo '<script language="JavaScript">alert("El Semestre es requerido")</script>';
        }
	   else 
	   if ($_POST['apellidos']== "")
		{
		echo '<script language="JavaScript">alert("Los Apellidos son requeridos")</script>';
        }
		else 
	   if ($_POST['nombres']== "")
		{
		echo '<script language="JavaScript">alert("Los Nombres son requeridos")</script>';
        }
       else 
	   if ($_POST['tipodocumento']== 0)
		{
		echo '<script language="JavaScript">alert("El Tipo de documento es requerido")</script>';
        }
       else 
	   if ($_POST['documento']== "")
		{
		echo '<script language="JavaScript">alert("El Número de documento requerido")</script>';
        }
		else 
	   if ($_POST['situacionestudiante']== "")
		{
		echo '<script language="JavaScript">alert("La situación del estudiante es  requerido")</script>';
        }
	  else
      if ($_POST['ciudad1']== "")
		{
		echo '<script language="JavaScript">alert("La Ciudad es  requerida")</script>';
        }
	  else
	  if ($_POST['direccion1']== "")
		{
		echo '<script language="JavaScript">alert("La Dirección es  requerida")</script>';
        }
	  else
       if ($_POST['telefono1']== "")
		{
		echo '<script language="JavaScript">alert("el número Telefonico es  requerido")</script>';
        }	 
	 else 
	 if ($_POST['expedido']== "")
		{
		echo '<script language="JavaScript">alert("Lugar donde fue Expedido el documento de identidad:")</script>';
        }
       else 
       {	   
	   $sql = "insert into estudiante(tipodocumento,numerodocumento,expedidodocumento,nombresestudiante,apellidosestudiante,codigocarrera,codigoestudiante,semestre,numerocohorte,codigotipoestudiante,codigosituacioncarreraestudiante,codigoperiodo,codigojornada,direccionresidenciaestudiante,ciudadresidenciaestudiante,telefonoresidenciaestudiante,telefono2estudiante,celularestudiante,direccioncorrespondenciaestudiante,ciudadcorrespondenciaestudiante,telefonocorrespondenciaestudiante,emailestudiante,fechacreacionestudiante)";
       $sql.= "VALUES('".$_POST['tipodocumento']."','".$_POST['documento']."','".$_POST['expedido']."','".$_POST['nombres']."','".$_POST['apellidos']."','".$_POST['carrera']."','".$_POST['codigo']."','".$_POST['semestre']."','".$_POST['cohorte']."','".$_POST['tipoestudiante']."','".$_POST['situacionestudiante']."','".$row['codigoperiodo']."','".$_POST['jornada']."','".$_POST['direccion1']."','".$_POST['ciudad1']."','".$_POST['telefono1']."','".$_POST['telefono2']."','".$_POST['celular']."','".$_POST['direccion2']."','".$_POST['ciudad2']."','".$_POST['telefono2']."','".$_POST['email']."','".date("Y-m-d G:i:s",time())."')"; 
       $result = mysql_query($sql,$sala);    
	  
	  $estudiante= "select * from estudiante
	                where codigoestudiante = '".$_POST['codigo']."'";
       $solu=mysql_db_query($database_sala,$estudiante);	   
	   $totalRow= mysql_num_rows($solu);
       $rows=mysql_fetch_array($solu);

   echo '<script language="JavaScript">alert("Estudiante Ingresado: '.$rows['apellidosestudiante'].' '.$rows['nombresestudiante'].'")</script>';  
   echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=menucrearnuevoestudiante.php'>";	        	     
   exit();	   
	   }
}

mysql_select_db($database_sala, $sala);
$query_jornadas = "SELECT * FROM jornada";
$jornadas = mysql_query($query_jornadas, $sala) or die(mysql_error());
$row_jornadas = mysql_fetch_assoc($jornadas);
$totalRows_jornadas = mysql_num_rows($jornadas);



mysql_select_db($database_sala, $sala);
$query_tipoestudiante = "SELECT * FROM tipoestudiante";
$tipoestudiante = mysql_query($query_tipoestudiante, $sala) or die(mysql_error());
$row_tipoestudiante = mysql_fetch_assoc($tipoestudiante);
$totalRows_tipoestudiante = mysql_num_rows($tipoestudiante);

mysql_select_db($database_sala, $sala);
$query_situacionestudiante = "SELECT * FROM situacioncarreraestudiante";
$situacionestudiante = mysql_query($query_situacionestudiante, $sala) or die(mysql_error());
$row_situacionestudiante = mysql_fetch_assoc($situacionestudiante);
$totalRows_situacionestudiante = mysql_num_rows($situacionestudiante);

mysql_select_db($database_sala, $sala);
$query_carreras = "SELECT codigocarrera, nombrecarrera FROM carrera order by 2 asc";
$carreras = mysql_query($query_carreras, $sala) or die(mysql_error());
$row_carreras = mysql_fetch_assoc($carreras);
$totalRows_carreras = mysql_num_rows($carreras);

mysql_select_db($database_sala, $sala);
$query_documentos = "SELECT * FROM documento";
$documentos = mysql_query($query_documentos, $sala) or die(mysql_error());
$row_documentos = mysql_fetch_assoc($documentos);
$totalRows_documentos = mysql_num_rows($documentos);
?>
<form name="form1" method="post" action="ingresoestudiante.php">
    <p align="center"><strong><font size="2" face="Tahoma">DATOS ESTUDIANTE</font></strong></p>
    <p align="center">&nbsp;</p>
    <table width="600" border="1" align="center" cellpadding="1" bordercolor="#003333">
      <tr>
        <td bgcolor="#C5D5D6" width="116"><div align="center"><font size="2" face="tahoma">C&oacute;digo*</font></div></td>
        <td colspan="2"><div align="center"><font size="2" face="tahoma">
          <input name="codigo" type="text" id="codigo" value="<?php echo $_POST['codigo']; ?>" size="12">
        </font></div></td>
        <td bgcolor="#C5D5D6" width="90"><div align="center"><font size="2" face="tahoma">Facultad*</font></div></td>
        <td colspan="4"><div align="center"><font face="tahoma"><font size="2">
          <select name="carrera" id="carrera">
            <option value="0" <?php if (!(strcmp(0, $_POST['carrera']))) {echo "SELECTED";} ?>>Seleccionar</option>
            <?php
do {  
?>
            <option value="<?php echo $row_carreras['codigocarrera']?>"<?php if (!(strcmp($row_carreras['codigocarrera'], $_POST['carrera']))) {echo "SELECTED";} ?>><?php echo $row_carreras['nombrecarrera']?></option>
            <?php
} while ($row_carreras = mysql_fetch_assoc($carreras));
  $rows = mysql_num_rows($carreras);
  if($rows > 0) {
      mysql_data_seek($carreras, 0);
	  $row_carreras = mysql_fetch_assoc($carreras);
  }
?>
          </select>
        </font></font></div></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6"><div align="center"><font size="2" face="tahoma">Apellidos*</font></div></td>
        <td colspan="3">
          <div align="center"><font size="2" face="tahoma">
          <input name="apellidos" type="text" id="apellidos" value="<?php echo $_POST['apellidos']; ?>" size="40">
        </font></div></td>
        <td bgcolor="#C5D5D6" width="90"><div align="center"><font size="2" face="tahoma">Nombres*</font></div></td>
        <td colspan="3"><div align="center"><font size="2" face="tahoma">
            <input name="nombres" type="text" id="nombres2" value="<?php echo $_POST['nombres']; ?>" size="30">
        </font></div></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6"><div align="center"><font size="2" face="tahoma">Tipo Documento*</font></div></td>
        <td colspan="2"><div align="center"><font size="2" face="tahoma">
            <select name="tipodocumento" id="select2">
              <option value="0" <?php if (!(strcmp(0, $_POST['tipodocumento']))) {echo "SELECTED";} ?>>Seleccionar</option>
              <?php
do {  
?>
              <option value="<?php echo $row_documentos['tipodocumento']?>"<?php if (!(strcmp($row_documentos['tipodocumento'], $_POST['tipodocumento']))) {echo "SELECTED";} ?>><?php echo $row_documentos['nombredocumento']?></option>
              <?php
} while ($row_documentos = mysql_fetch_assoc($documentos));
  $rows = mysql_num_rows($documentos);
  if($rows > 0) {
      mysql_data_seek($documentos, 0);
	  $row_documentos = mysql_fetch_assoc($documentos);
  }
?>
            </select>
        </font></div></td>
        <td bgcolor="#C5D5D6">
          <div align="center"><font size="2" face="tahoma">N&uacute;mero* </font></div></td>
        <td colspan="4"><div align="center"><font size="2" face="tahoma">
          <input name="documento" type="text" id="documento2" value="<?php echo $_POST['documento']; ?>" size="20">
        </font></div></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6"><div align="center"><font size="2" face="tahoma">Expedido en* </font></div></td>
        <td colspan="2"><div align="center"><font face="tahoma">
            <input name="expedido" type="text" id="expedido3" value="<?php echo $_POST['expedido']; ?>" size="25">
        </font></div></td>
        <td bgcolor="#C5D5D6"><div align="center"><font size="2" face="tahoma">Jornada*</font></div></td>
        <td><div align="center"><font size="2" face="tahoma">
            <select name="jornada" id="select10">
              <option value="0" <?php if (!(strcmp(0, $_POST['jornada']))) {echo "SELECTED";} ?>>Seleccionar</option>
              <?php
do {  
?>
              <option value="<?php echo $row_jornadas['codigojornada']?>"<?php if (!(strcmp($row_jornadas['codigojornada'], $_POST['jornada']))) {echo "SELECTED";} ?>><?php echo $row_jornadas['nombrejornada']?></option>
              <?php
} while ($row_jornadas = mysql_fetch_assoc($jornadas));
  $rows = mysql_num_rows($jornadas);
  if($rows > 0) {
      mysql_data_seek($jornadas, 0);
	  $row_jornadas = mysql_fetch_assoc($jornadas);
  }
?>
            </select>
        </font></div></td>
        <td colspan="2" bgcolor="#C5D5D6"><div align="center"><font size="2" face="tahoma">Semestre*</font></div>          <div align="center"><font face="tahoma">
        </font></div></td>
        <td><font face="tahoma">
          <select name="semestre" id="select15">
            <option value="0" <?php if (!(strcmp(0, $_POST['semestre']))) {echo "SELECTED";} ?>>Sel</option>
            <?php for ($i=1;$i<13;$i++)
			{?>
            <option value="<?php echo $i;?>"<?php if (!(strcmp($i, $_POST['semestre']))) {echo "SELECTED";} ?>><?php echo $i;?></option>
            <?php }  ?>
          </select>
        </font></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6"><div align="center"><font size="2" face="tahoma">N&uacute;mero Cohorte*</font> </div></td>
        <td width="67"><div align="center"><font size="2" face="tahoma">
            <select name="cohorte" id="select12">
              <option value="" <?php if (!(strcmp("", $_POST['cohorte']))) {echo "SELECTED";} ?>>0</option>
              <option value="1" <?php if (!(strcmp(1, $_POST['cohorte']))) {echo "SELECTED";} ?>>1</option>
              <option value="2" <?php if (!(strcmp(2, $_POST['cohorte']))) {echo "SELECTED";} ?>>2</option>
              <option value="3" <?php if (!(strcmp(3, $_POST['cohorte']))) {echo "SELECTED";} ?>>3</option>
            </select>
        </font></div></td>
        <td width="107" bgcolor="#C5D5D6"><div align="center"><font size="2" face="tahoma">Tipo Estudiante* </font></div></td>
        <td><div align="center"><font face="tahoma">
          </font><font size="2" face="tahoma">
          <select name="tipoestudiante" id="select13">
            <option value="0" <?php if (!(strcmp(0, $_POST['tipoestudiante']))) {echo "SELECTED";} ?>>Seleccionar</option>
            <?php
do {  
?>
            <option value="<?php echo $row_tipoestudiante['codigotipoestudiante']?>"<?php if (!(strcmp($row_tipoestudiante['codigotipoestudiante'], $_POST['tipoestudiante']))) {echo "SELECTED";} ?>><?php echo $row_tipoestudiante['nombretipoestudiante']?></option>
            <?php
} while ($row_tipoestudiante = mysql_fetch_assoc($tipoestudiante));
  $rows = mysql_num_rows($tipoestudiante);
  if($rows > 0) {
      mysql_data_seek($tipoestudiante, 0);
	  $row_tipoestudiante = mysql_fetch_assoc($tipoestudiante);
  }
?>
          </select>
        </font></div></td>
        <td colspan="2" bgcolor="#C5D5D6"><div align="center"><font size="2" face="tahoma">Situaci&oacute;n Estudiante * </font></div></td>
        <td colspan="2"><div align="center"><font face="tahoma">
            <select name="situacionestudiante" id="select14">
              <option value="0" <?php if (!(strcmp(0, $_POST['situacionestudiante']))) {echo "SELECTED";} ?>>Seleccionar</option>
              <?php
do {  
?>
              <option value="<?php echo $row_situacionestudiante['codigosituacioncarreraestudiante']?>"<?php if (!(strcmp($row_situacionestudiante['codigosituacioncarreraestudiante'], $_POST['situacionestudiante']))) {echo "SELECTED";} ?>><?php echo $row_situacionestudiante['nombresituacioncarreraestudiante']?></option>
              <?php
} while ($row_situacionestudiante = mysql_fetch_assoc($situacionestudiante));
  $rows = mysql_num_rows($situacionestudiante);
  if($rows > 0) {
      mysql_data_seek($situacionestudiante, 0);
	  $row_situacionestudiante = mysql_fetch_assoc($situacionestudiante);
  }
?>
            </select>
          </font><font size="2" face="tahoma">
        </font></div></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6"><div align="center"><font size="2" face="tahoma">Celular</font></div></td>
        <td colspan="2"><div align="center"><font size="2" face="tahoma">
            <input name="celular" type="text" id="celular2" value="<?php echo $_POST['celular']; ?>" size="30">
        </font></div></td>
        <td bgcolor="#C5D5D6">
          <div align="center"><font size="2" face="tahoma">E-mail </font></div></td>
        <td colspan="4"><div align="center"><font size="2" face="tahoma">
            <input name="email" type="text" id="email3" value="<?php echo $_POST['email']; ?>" size="40">
        </font></div></td>
      </tr>
      <tr>
        <td bgcolor="#C5D5D6"><div align="center"><font size="2" face="tahoma">Dir. Estudiante*</font></div></td>
        <td colspan="2"><div align="center"><font size="2" face="tahoma">
            <input name="direccion1" type="text" id="direccion12" value="<?php echo $_POST['direccion1']; ?>" size="30">
        </font></div></td>
        <td bgcolor="#C5D5D6">
          <div align="center"><font size="2" face="tahoma">Tel&eacute;fono* </font></div></td>
        <td colspan="2"><div align="center"><font size="2" face="tahoma">
            <input name="telefono1" type="text" id="telefono13" value="<?php echo $_POST['telefono1']; ?>" size="22">
        </font></div></td>
        <td width="63" bgcolor="#C5D5D6"><div align="center"><font size="2" face="tahoma">Ciudad* </font></div></td>
        <td width="138"><div align="center"><font face="tahoma">
          <input name="ciudad1" type="text" id="ciudad15" value="<?php echo $_POST['ciudad1']; ?>" size="19">
        </font></div></td>
      </tr>
      <tr>
        <td height="26" bgcolor="#C5D5D6"><div align="center"><font size="2" face="tahoma">Dir.Correspondencia</font></div></td>
        <td colspan="2"><div align="center"><font size="2" face="tahoma">
            <input name="direccion2" type="text" id="direccion22" value="<?php echo $_POST['direccion2']; ?>" size="30">
        </font></div></td>
        <td bgcolor="#C5D5D6">
          <div align="center"><font size="2" face="tahoma">Tel&eacute;fono:</font></div></td>
        <td colspan="2"><div align="center"><font size="2" face="tahoma">
            <input name="telefono2" type="text" id="telefono23" value="<?php echo $_POST['telefono2']; ?>" size="22">
</font></div></td>
        <td bgcolor="#C5D5D6"><div align="center"><font size="2" face="tahoma">Ciudad: </font></div></td>
        <td><div align="center"><font face="tahoma">
            <input name="ciudad2" type="text" id="ciudad24" value="<?php echo $_POST['ciudad2']; ?>" size="19">
        </font></div></td>
      </tr>
    </table>
    <p align="center">&nbsp;</p>
    <p align="center">
      <input name="guardar" type="submit" id="guardar" value="Guardar">
    </p>
</form>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</div>
<?php
mysql_free_result($jornadas);

mysql_free_result($documentos);

mysql_free_result($tipoestudiante);

mysql_free_result($situacionestudiante);

mysql_free_result($carreras);
?>
