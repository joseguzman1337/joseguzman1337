<?php
include ('../../Connections/egresado.php');
session_start();
$GLOBALS['numerodocumento'];
if ($_SESSION['numerodocumento'] <> "")
  {
   echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=docente1.php'>";  
   exit();
  }
?>
<style type="text/css">
<!--
.Estilo2 {
	font-family: Tahoma;
	font-size: x-small;
}
.style7 {font-size: x-small}
.style5 {	font-size: small;
	font-weight: bold;
}
.Estilo9 {
	font-family: Tahoma;
	font-size: x-small;
}
.Estilo10 {font-size: x-small; font-weight: bold; font-family: Tahoma; }
.Estilo11 {font-size: x-small; font-weight: bold; }
.Estilo12 {
	font-size: large;
	font-weight: bold;
	font-family: Tahoma;
}
.Estilo13 {font-size: small}
.Estilo14 {font-size: 10px}
-->
</style>
<form name="form1" method="post" action="docente.php">
  <div align="center">
    <p><span class="Estilo10">INFORMACI&Oacute;N BASICA </span></p>
    <p class="Estilo2">
  
<?php

mysql_select_db($database_conexion, $conexion);
$query_Recordset1 = "SELECT * FROM tipodocumento";
$Recordset1 = mysql_query($query_Recordset1, $conexion) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_conexion, $conexion);
$query_modalidad = "SELECT * FROM modalidadacademica order by 1";
$modalidad = mysql_query($query_modalidad, $conexion) or die(mysql_error());
$row_modalidad = mysql_fetch_assoc($modalidad);
$totalRows_modalidad = mysql_num_rows($modalidad);

if ($_POST['modalidad'] <> "")
 {
mysql_select_db($database_conexion, $conexion);
		$query_car = "SELECT nombrecarrera,codigocarrera 
						FROM carrera 
						where codigomodalidadacademica = '".$_POST['modalidad']."'
						order by 1";		
		$car = mysql_query($query_car, $conexion) or die(mysql_error());
		$row_car = mysql_fetch_assoc($car);
		$totalRows_car = mysql_num_rows($car);
 }
?>
<script language="javascript">
function enviar()
			{
				document.form1.submit();

			}
</script>
</p>
  </div>
   <div align="center" class="Estilo9">
    <table width="543" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
      <tr bgcolor="#C6CFD0">
        <td colspan="2"><div align="left"><span class="Estilo11">Informaci&oacute;n B&aacute;sica</span></div></td>
      </tr>
      <tr>
        <td width="234" bgcolor="#C6CFD0"><div align="left" class="Estilo12 style7 style7 style7 style7 style7 style7 style7  style7 style7 style7 Estilo13"><span class="Estilo11"><strong>-&gt; </strong>Tipo de  Identificaci&oacute;n: </span> </div></td>
        <td width="283"><div align="left">
            <select name="codigotipodocumento" id="codigotipodocumento">
              <option value="value" <?php if (!(strcmp("value", $_POST['codigotipodocumento']))) {echo "SELECTED";} ?>>Seleccionar</option>
<?php
do {  
?>
              <option value="<?php echo $row_Recordset1['codigotipodocumento']?>"<?php if (!(strcmp($row_Recordset1['codigotipodocumento'], $_POST['codigotipodocumento']))) {echo "SELECTED";} ?>><?php echo $row_Recordset1['nombretipodocumento']?></option>
<?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
            </select>
        </div></td>
      </tr>
      <tr>
        <td bgcolor="#C6CFD0"><div align="left" class="Estilo11"><strong>-&gt; </strong>N&uacute;mero de Identificaci&oacute;n: </div></td>
        <td><div align="left">
            <input name="numerodocumento" type="text" id="numerodocumento" value="<?php echo $_POST['numerodocumento'];?>">
            <span class="Estilo14">Sin puntos ni espacios</span></div></td>
      </tr>  
	  <?php 
	    if ($_POST['numerodocumento'] == "") 
		   {		  
		     echo "<br>";
			echo "<td colspan='2'><p align='center'><input type='submit' name='Submit2' value='Continuar'></p><td>";
	        exit();
		   }
		else 
		  {
		      mysql_select_db($database_conexion, $conexion);
          $query_Recordset10 = "SELECT * FROM docente
		                        where numerodocumento = '". $_POST['numerodocumento']."'";
          $Recordset10= mysql_query($query_Recordset10, $conexion) or die(mysql_error());
          $row_Recordset10 = mysql_fetch_assoc($Recordset10);		
		   if ($row_Recordset10 <> "")
	          {
			     $_SESSION['numerodocumento']= $_POST['numerodocumento'];  
                 echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=docente1.php'>";
			     exit();
			  }	  
		     else
			  {// else 1
	  ?>  
	  <tr>
        <td bgcolor="#C6CFD0"><div align="left" class="Estilo11"><strong>-&gt; </strong>Nombres:</div></td>
        <td><div align="left">
            <input name="nombresdocente" type="text" id="nombresdocente" value="<?php echo $_POST['nombresdocente'];?>" size="40">
        </div></td>
      </tr>
      <tr>
        <td bgcolor="#C6CFD0"><span class="Estilo11"><strong>-&gt; </strong>Apellidos:</span></td>
        <td><input name="apellidosdocente" type="text" id="apellidosdocente" value="<?php echo $_POST['apellidosdocente'];?>" size="40"></td>
      </tr>

      <tr>
        <td bgcolor="#C6CFD0"><div align="left" class="Estilo11"><strong>-&gt; </strong>G&eacute;nero:</div></td>
        <td><div align="left">
            <select name="sexodocente" id="sexodocente">
              <option value="" <?php if (!(strcmp("", $_POST['sexodocente']))) {echo "SELECTED";} ?>>Seleccionar</option>
              <option value="F" <?php if (!(strcmp("F", $_POST['sexodocente']))) {echo "SELECTED";} ?>>Femenino</option>
              <option value="M" <?php if (!(strcmp("M", $_POST['sexodocente']))) {echo "SELECTED";} ?>>Masculino</option>
            </select>
        </div></td>
      </tr>
    </table>
    <br>
  </div>
  <div align="center" class="Estilo9">
        <table width="545" border="1" cellpadding="1" cellspacing="2" bordercolor="#003333">
          <tr bgcolor="#C6CFD0">
            <td colspan="2"><span class="Estilo11">Informaci&oacute;n Personal</span></td>
          </tr>
          <tr>
            <td width="231" bgcolor="#C6CFD0"><span class="Estilo11"><strong>-&gt; </strong>Fecha de Nacimiento: </span></td>
            <td width="288">DD
              <input name="dia" type="text" id="dia" value="<?php echo $_POST['dia'];?>" size="1" maxlength="2">
  MM
  <input name="mes" type="text" id="mes" value="<?php echo $_POST['mes'];?>" size="1" maxlength="2">
  AAAA
  <input name="ano" type="text" id="ano" value="<?php echo $_POST['ano'];?>" size="2"></td>
          </tr>
          <tr>
            <td bgcolor="#C6CFD0"><span class="Estilo11"><strong>-&gt; </strong>Lugar de Nacimiento: </span></td>
            <td><input name="lugarnacimientodocente" type="text" id="lugarnacimientodocente" value="<?php echo $_POST['lugarnacimientodocente'];?>" size="40"></td>
          </tr>
          <tr>
            <td bgcolor="#C6CFD0"><span class="Estilo11"> <strong>&nbsp;&nbsp;&nbsp;&nbsp; </strong>C&oacute;digo Postal: </span></td>
            <td><input name="codigopostaldocente" type="text" id="codigopostaldocente" value="<?php echo $_POST['codigopostaldocente'];?>"></td>
          </tr>
          <tr>
            <td bgcolor="#C6CFD0"><span class="Estilo11"><strong>-&gt; </strong> Direcci&oacute;n:</span></td>
            <td><input name="direcciondocente" type="text" id="direcciondocente" value="<?php echo $_POST['direcciondocente'];?>" size="40"></td>
          </tr>
          <tr>
            <td bgcolor="#C6CFD0"><span class="Estilo11"><strong>-&gt; </strong> Ciudad : </span></td>
            <td><input name="ciudaddocente" type="text" id="ciudaddocente" value="<?php echo $_POST['ciudaddocente'];?>" size="40"></td>
          </tr>
          <tr>
            <td bgcolor="#C6CFD0"><span class="Estilo11"><strong>-&gt; </strong> E - mail: </span></td>
            <td><input name="emaildocente" type="text" id="emaildocente" value="<?php echo $_POST['emaildocente'];?>" size="40"></td>
          </tr>
          <tr>
            <td bgcolor="#C6CFD0"><span class="Estilo11"><strong>-&gt; Tel&eacute;fono Casa:</strong></span></td>
            <td><input name="telefonodocente" type="text" id="telefonodocente" value="<?php echo $_POST['telefonodocente'];?>"></td>
          </tr>
          <tr>
            <td bgcolor="#C6CFD0"><span class="Estilo11"><strong>-&gt; Tel&eacute;fono Oficina:</strong></span></td>
            <td><input name="telefonodocente2" type="text" id="telefonodocente2" value="<?php echo $_POST['telefonodocente2'] ?>"></td>
          </tr>
          <tr>
            <td bgcolor="#C6CFD0"><span class="Estilo11"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Celular:</strong> </span></td>
            <td><input name="celulardocente" type="text" id="celulardocente" value="<?php echo $_POST['celulardocente'] ?>"></td>
          </tr>
          <tr>
            <td bgcolor="#C6CFD0"><span class="Estilo11"><strong>&nbsp;&nbsp;&nbsp; </strong> &nbsp;&nbsp;Fax: </span></td>
            <td><input name="faxdocente" type="text" id="faxdocente" value="<?php echo $_POST['faxdocente'];?>"></td>
          </tr>
          <tr>
            <td bgcolor="#C6CFD0">-&gt;<span class="Estilo11">&nbsp;</span><span class="Estilo11">Modalidad 


Acad&eacute;mica:</span></td>
            <td><select name="modalidad" id="modalidad" onChange="enviar()">
              <option value="0" <?php if (!(strcmp("0", $_POST['modalidad']))) {echo "SELECTED";} ?>>Seleccionar</option>
              <?php
do {  
?>
              <option value="<?php echo $row_modalidad['codigomodalidadacademica']?>"<?php if (!(strcmp($row_modalidad['codigomodalidadacademica'], $_POST['modalidad']))) {echo "SELECTED";} ?>><?php echo $row_modalidad['nombremodalidadacademica']?></option>
              <?php
} while ($row_modalidad = mysql_fetch_assoc($modalidad));
  $rows = mysql_num_rows($modalidad);
  if($rows > 0) {
      mysql_data_seek($car, 0);
	  $row_modalidad = mysql_fetch_assoc($modalidad);
  }
?>
            </select></td>
          </tr>
          <tr>
            <td bgcolor="#C6CFD0"><span class="Estilo11"><strong> &nbsp;<strong>-&gt;</strong> Programa &oacute; Especializaci&oacute;n:</strong></span></td>
            <td><select name="especializacion" id="especializacion">
              <option value="0" <?php if (!(strcmp("0", $_POST['especializacion']))) {echo "SELECTED";} ?>>Seleccionar</option>
              <?php
do {  
?>
              <option value="<?php echo $row_car['codigocarrera']?>"<?php if (!(strcmp($row_car['codigocarrera'], $_POST['especializacion']))) {echo "SELECTED";} ?>><?php echo $row_car['nombrecarrera']?></option>
<?php
} while ($row_car = mysql_fetch_assoc($car));
  $rows = mysql_num_rows($car);
  if($rows > 0) {
      mysql_data_seek($car, 0);
	  $row_car = mysql_fetch_assoc($car);
  }
?>
            </select></td>
          </tr>
    </table>
  </div>
  <p align="center" class="Estilo9">
    <input type="submit" name="Submit" value="Grabar">
  </p>
</form>
<span class="Estilo2">
<?php
if ($_POST['Submit'])
{ 
 
 if (!eregi("^[0-9]{1,15}$", $_POST['numerodocumento']))
		{
		echo '<script language="JavaScript">alert("Número de documento Incorrecto")</script>';	
        }
 else 
 if (($_POST['codigotipodocumento'] == 0)or($_POST['numerodocumento'] == "") or ($_POST['nombresdocente'] == "")or ($_POST['apellidosdocente'] == "")or ($_POST['sexodocente'] == "")or  ($_POST['lugarnacimientodocente'] == "")or ($_POST['direcciondocente'] == "")or ($_POST['ciudaddocente'] == "")or ($_POST['emaildocente'] == "")or ($_POST['telefonodocente'] == "")or ($_POST['telefonodocente2'] == "")or($_POST['especializacion'] == 0))
   {
    echo '<script language="JavaScript">alert("Los campos con -> son requeridos")</script>';			
   }	
   else 

 if ((!( checkdate($_POST['mes'],$_POST['dia'],$_POST['ano']))) or ($_POST['ano'] >  date("Y",time())) or ($_POST['ano'] < 1900)) {

      echo '<script language="JavaScript">alert("La Fecha Digitada es incorrecta")</script>';			
}  
   
else 
     {	 
     require_once('capturadocente.php');
     }
}

  }//else 1
 }
?>
</span>