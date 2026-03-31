<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
      
require_once('../../../Connections/sala2.php');
session_start();
$direccion = "editarestudiante.php";

     mysql_select_db($database_sala, $sala);
	$query_jornadas = "SELECT * FROM jornada";
	$jornadas = mysql_query($query_jornadas, $sala) or die(mysql_error());
	$row_jornadas = mysql_fetch_assoc($jornadas);
	$totalRows_jornadas = mysql_num_rows($jornadas);
	
	
	 mysql_select_db($database_sala, $sala);
	$query_calendario = "SELECT * FROM calendarioestudiante";
	$calendario = mysql_query($query_calendario, $sala) or die(mysql_error());
	$row_calendario = mysql_fetch_assoc($calendario);
	$totalRows_calendario = mysql_num_rows($calendario);
	
	$query_selgenero = "select codigogenero, nombregenero
	                    from genero";
	$selgenero = mysql_query($query_selgenero, $sala) or die("$query_selgenero");
	$totalRows_selgenero = mysql_num_rows($selgenero);
	$row_selgenero = mysql_fetch_assoc($selgenero);
	
	 mysql_select_db($database_sala, $sala);
	$query_zona = "SELECT * FROM zona";
	$zona = mysql_query($query_zona, $sala) or die(mysql_error());
	$row_zona = mysql_fetch_assoc($zona);
	$totalRows_zona = mysql_num_rows($zona);
	
	 mysql_select_db($database_sala, $sala);
	$query_tipoinstitucion = "SELECT * FROM tipoinstitucioneducativa";
	$tipoinstitucion = mysql_query($query_tipoinstitucion, $sala) or die(mysql_error());
	$row_tipoinstitucion = mysql_fetch_assoc($tipoinstitucion);
	$totalRows_tipoinstitucion = mysql_num_rows($tipoinstitucion);
	
	 mysql_select_db($database_sala, $sala);
	$query_naturaleza = "SELECT * FROM naturaleza";
	$naturaleza = mysql_query($query_naturaleza, $sala) or die(mysql_error());
	$row_naturaleza = mysql_fetch_assoc($naturaleza);
	$totalRows_naturaleza = mysql_num_rows($naturaleza);
	
	 mysql_select_db($database_sala, $sala);
	$query_idioma = "SELECT * FROM idiomainstitucioneducativa";
	$idioma = mysql_query($query_idioma, $sala) or die(mysql_error());
	$row_idioma = mysql_fetch_assoc($idioma);
	$totalRows_idioma = mysql_num_rows($idioma);

?>
<style type="text/css">
<!--
.Estilo1 {font-family: tahoma}
.Estilo3 {
	font-size: xx-small;
	font-weight: bold;
}
.Estilo4 {font-family: tahoma; font-size: xx-small; font-weight: bold; }
.Estilo5 {font-family: tahoma; font-weight: bold; }
-->
</style>

<form name="f1" action="editarestudiantecolegionuevo.php" method="POST" onSubmit="return validar(this)">
  <p align="center" class="Estilo5">INGRESAR COLEGIO </p>
  <table width="65%"  border="1" align="center" cellpadding="1" bordercolor="#003333">
    <tr>
      <td width="8%" class="Estilo4" bgcolor="#C5D5D6">Nombre*</td>
      <td colspan="3" class="Estilo1"><input name="nombre" type="text" size="30"></td>
      <td class="Estilo4" bgcolor="#C5D5D6">Pais*</td>
      <td colspan="3" class="Estilo1"><input name="pais" type="text" size="30"></td>
    </tr>
    <tr>
      <td class="Estilo4" bgcolor="#C5D5D6">Municipio*</td>
      <td colspan="3" class="Estilo1"><input name="municipio" type="text" size="30"></td>
      <td class="Estilo4" bgcolor="#C5D5D6">Depto*</td>
      <td colspan="3" class="Estilo1"><input name="departamento" type="text" size="30"></td>
    </tr>
    <tr>
      <td class="Estilo4" bgcolor="#C5D5D6">Direcci&oacute;n*</td>
      <td colspan="3" class="Estilo1"> <input name="direccion" type="text" size="30"></td>
      <td width="7%" class="Estilo4" bgcolor="#C5D5D6">Telefono1*</td>
      <td width="15%" class="Estilo1"> <input name="telefono1" type="text" size="15"></td>
      <td width="7%" class="Estilo4" bgcolor="#C5D5D6">Telefono2</td>
      <td width="24%" class="Estilo1"> <input name="telefono2" type="text" size="15"></td>
    </tr>
    <tr>
      <td class="Estilo4" bgcolor="#C5D5D6">Jornada*</td>
      <td width="2%" class="Estilo1"><span class="Estilo3">
        <select name="jornada" id="select10">
			<option value="0" selected>Seleccionar</option>			
<?php
	do 
	{ 		
?>
      <option value="<?php echo $row_jornadas['codigojornada']?>"<?php if (!(strcmp($row_jornadas['codigojornada'], $_POST['jornada']))) {echo "SELECTED";} ?>><?php echo $row_jornadas['nombrejornada']?></option>
<?php		
	} while ($row_jornadas = mysql_fetch_assoc($jornadas));
	$rows = mysql_num_rows($jornadas);
	if($rows > 0) 
	{
		mysql_data_seek($jornadas, 0);
		$row_jornadas = mysql_fetch_assoc($jornadas);
	}
?>
        </select>
      </span></td>
      <td width="17%" class="Estilo4"  bgcolor="#C5D5D6">Calendario*</td>
      <td width="20%" class="Estilo4"> <select name="calendario" id="select2">     
<?php
do {  
?>
      <option value="<?php echo $row_calendario['codigocalendarioestudiante']?>"<?php if (!(strcmp($row_calendario['codigocalendarioestudiante'], $_POST['calendario']))) {echo "SELECTED";} ?>><?php echo $row_calendario['nombrecalendarioestudiante']?></option>
      <?php
} while ($row_calendario = mysql_fetch_assoc($calendario));
  $rows = mysql_num_rows($calendario);
  if($rows > 0) {
      mysql_data_seek($calendario, 0);
	  $row_calendario = mysql_fetch_assoc($calendario);
  }
?>
    </select>
</td>
      <td colspan="2" class="Estilo4" bgcolor="#C5D5D6">Tipo Instituci&oacute;n* </td>
      <td colspan="2" class="Estilo4"><select name="tipoinstitucion" id="select10">
        <option value="0" selected>Seleccionar</option>
        <?php
	do 
	{ 		
?>
        <option value="<?php echo $row_tipoinstitucion['codigotipoinstitucioneducativa']?>"<?php if (!(strcmp($row_tipoinstitucion['codigotipoinstitucioneducativa'], $_POST['tipoinstitucion']))) {echo "SELECTED";} ?>><?php echo $row_tipoinstitucion['nombretipoinstitucioneducativa']?></option>
        <?php		
	} while ($row_tipoinstitucion = mysql_fetch_assoc($tipoinstitucion));
	$rows = mysql_num_rows($tipoinstitucion);
	if($rows > 0) 
	{
		mysql_data_seek($tipoinstitucion, 0);
		$row_tipoinstitucion = mysql_fetch_assoc($tipoinstitucion);
	}
?>
      </select></td>
    </tr>
    <tr>
      <td class="Estilo4" bgcolor="#C5D5D6"> Bilingue</td>
      <td colspan="3" class="Estilo4"><select name="idioma" id="select10">
			<option value="0" selected>Seleccionar</option>			
<?php
	do 
	{ 		
?>
      <option value="<?php echo $row_idioma['codigoidiomainstitucioneducativa']?>"<?php if (!(strcmp($row_idioma['codigoidiomainstitucioneducativa'], $_POST['idioma']))) {echo "SELECTED";} ?>><?php echo $row_idioma['nombreidiomainstitucioneducativa']?></option>
<?php		
	} while ($row_idioma = mysql_fetch_assoc($idioma));
	$rows = mysql_num_rows($idioma);
	if($rows > 0) 
	{
		mysql_data_seek($idioma, 0);
		$row_idioma = mysql_fetch_assoc($idioma);
	}
?>
        </select></td>
      <td class="Estilo4" bgcolor="#C5D5D6">Genero*</td>
      <td class="Estilo4"><select name="genero" id="select10">
			<option value="0" selected>Seleccionar</option>			
<?php
	do 
	{ 		
?>
     <option value="<?php echo $row_selgenero['codigogenero']?>"<?php if (!(strcmp($row_selgenero['codigogenero'], $_POST['genero']))) {echo "SELECTED";} ?>><?php echo $row_selgenero['nombregenero']?></option>	
<?php		
	} while ($row_selgenero = mysql_fetch_assoc($selgenero));
	$rows = mysql_num_rows($selgenero);
	if($rows > 0) 
	{
		mysql_data_seek($selgenero, 0);
		$row_selgenero = mysql_fetch_assoc($selgenero);
	}
?>
        </select></td>
      <td class="Estilo4" bgcolor="#C5D5D6">Zona*</td>
      <td class="Estilo1"><select name="zona" id="select10">
			<option value="0" selected>Seleccionar</option>			
<?php
	do 
	{ 		
?>
      <option value="<?php echo $row_zona['codigozona']?>"<?php if (!(strcmp($row_zona['codigozona'], $_POST['zona']))) {echo "SELECTED";} ?>><?php echo $row_zona['nombrezona']?></option>
<?php		
	} while ($row_zona = mysql_fetch_assoc($zona));
	$rows = mysql_num_rows($zona);
	if($rows > 0) 
	{
		mysql_data_seek($zona, 0);
		$row_zona = mysql_fetch_assoc($zona);
	}
?>
        </select></td>
    </tr>
	<tr>
      <td class="Estilo4" bgcolor="#C5D5D6">Localizaci&oacute;n</td>
      <td colspan="3" class="Estilo1"><input name="localizacion" type="text" size="30"></td>
      <td class="Estilo4" bgcolor="#C5D5D6">Fax</td>
      <td class="Estilo1"><input name="fax" type="text" size="15"></td>
      <td class="Estilo4" bgcolor="#C5D5D6">A.A</td>
      <td class="Estilo1"><input name="aa" type="text" size="15"></td>
    </tr>
	<tr>
      <td class="Estilo4" bgcolor="#C5D5D6">Representante*</td>
      <td colspan="3" class="Estilo1"><input name="representante" type="text" size="30"></td>
      <td colspan="3" class="Estilo4" bgcolor="#C5D5D6">Naturaleza*</td>
      <td class="Estilo4"><select name="naturaleza" id="select10">
        <option value="0" selected>Seleccionar</option>
        <?php
	do 
	{ 		
?>
        <option value="<?php echo $row_naturaleza['codigonaturaleza']?>"<?php if (!(strcmp($row_naturaleza['codigonaturaleza'], $_POST['naturaleza']))) {echo "SELECTED";} ?>><?php echo $row_naturaleza['nombrenaturaleza']?></option>
        <?php		
	} while ($row_naturaleza = mysql_fetch_assoc($naturaleza));
	$rows = mysql_num_rows($naturaleza);
	if($rows > 0) 
	{
		mysql_data_seek($naturaleza, 0);
		$row_naturaleza = mysql_fetch_assoc($naturaleza);
	}
?>
      </select></td>
    </tr>
	<tr>
      <td class="Estilo4" bgcolor="#C5D5D6">Email</td>
      <td colspan="3" class="Estilo1"><input name="email" type="text" size="30"></td>
      <td colspan="2" bgcolor="#C5D5D6" class="Estilo4">Direcci&oacute;n electronica </td>
      <td colspan="2" class="Estilo4"><input name="direccionelectronica" type="text" size="26"></td>
    </tr>
  </table> 
  <p align="center">
    <input type="submit" name="guardar" value="Guardar">
  </p>
  <?php
   
  if ($_POST['guardar'])
   {
     $query_solicitud = "SELECT	*
				         FROM institucioneducativa
				         WHERE nombreinstitucioneducativa = '".$_POST['nombre']."'
					     and paisinstitucioneducativa = '".$_POST['pais']."'
						 ";
					// echo $query_solicitud;
		$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
        $solicitud = mysql_fetch_assoc($res_solicitud);
       if ($solicitud <> "")
	     {
		    echo '<script language="javascript">alert("Colegio ya Existe")</script>'; 
	        echo '<script language="javascript">history.go(-1)</script>';		 
		 }
       else
	    if ($_POST['nombre'] == "")
		{
		  echo '<script language="javascript">alert("El Nombre del Colegio es Requerido")</script>'; 
	      echo '<script language="javascript">history.go(-1)</script>';	
		}
       else
	    if ($_POST['pais'] == "")
		{
		  echo '<script language="javascript">alert("El Pais es Requerido")</script>'; 
	      echo '<script language="javascript">history.go(-1)</script>';	
		}
       else
	    if ($_POST['municipio'] == "")
		{
		  echo '<script language="javascript">alert("El Municipio es Requerido")</script>'; 
	      echo '<script language="javascript">history.go(-1)</script>';	
		}
	   else
	    if ($_POST['departamento'] == "")
		{
		  echo '<script language="javascript">alert("El Departamento es Requerido")</script>'; 
	      echo '<script language="javascript">history.go(-1)</script>';	
		}
	   else
	    if ($_POST['direccion'] == "")
		{
		  echo '<script language="javascript">alert("La Dirección es Requerida")</script>'; 
	      echo '<script language="javascript">history.go(-1)</script>';	
		}
		else
	    if ($_POST['telefono1'] == "")
		{
		  echo '<script language="javascript">alert("El Telefono es Requerido")</script>'; 
	      echo '<script language="javascript">history.go(-1)</script>';	
		}
       else
	    if ($_POST['jornada'] == 0)
		{
		  echo '<script language="javascript">alert("La Jornada es Requerida")</script>'; 
	      echo '<script language="javascript">history.go(-1)</script>';	
		}
	   else
	    if ($_POST['calendario'] == 0)
		{
		  echo '<script language="javascript">alert("El Calendario es Requerido")</script>'; 
	      echo '<script language="javascript">history.go(-1)</script>';	
		}
	   else
	    if ($_POST['tipoinstitucion'] == 0)
		{
		  echo '<script language="javascript">alert("El Tipo de Institución es Requerida")</script>'; 
	      echo '<script language="javascript">history.go(-1)</script>';	
		}
	  else
	    if ($_POST['idioma'] == 0)
		{
		  echo '<script language="javascript">alert("El Colegio es Bilingue ?")</script>'; 
	      echo '<script language="javascript">history.go(-1)</script>';	
		}
	  else
	    if ($_POST['genero'] == 0)
		{
		  echo '<script language="javascript">alert("ElGenero es Requerido")</script>'; 
	      echo '<script language="javascript">history.go(-1)</script>';	
		}
	  else
	    if ($_POST['zona'] == 0)
		{
		  echo '<script language="javascript">alert("La Zona es Requerida")</script>'; 
	      echo '<script language="javascript">history.go(-1)</script>';	
		}
	  else
	    if ($_POST['representante'] == "")
		{
		  echo '<script language="javascript">alert("El Nombre del Representante Legal es Requerido")</script>'; 
	      echo '<script language="javascript">history.go(-1)</script>';	
		}
	   else
	    if ($_POST['naturaleza'] == 0)
		{
		  echo '<script language="javascript">alert("La Naturaleza es Requerida")</script>'; 
	      echo '<script language="javascript">history.go(-1)</script>';	
		}
	  else
	   {
	      $sql = "insert into institucioneducativa(nombrecortoinstitucioneducativa,nombreinstitucioneducativa,codigojornada,paisinstitucioneducativa,municipioinstitucioneducativa,departamentoinstitucioneducativa,direccioninstitucioneducativa,telefono1,telefono2,codigocalendarioestudiante,codigotipoinstitucioneducativa,codigoidiomainstitucioneducativa,codigoestadoinstitucioneducativa,codigogenero,tarifainstitucioneducativa,codigozona,localizacioninstitucioneducativa,numerofaxinstitucioneducativa,apartadoaereoinstitucioneducativa,cdaneinstitucioneducativa,representateinstitucioneducativa,codigonaturaleza,personajuridicainstitucioneducativa,emailinstitucioneducativa,httpnstitucioneducativa)";
	      $sql.= "VALUES('".$_POST['nombre']."','".$_POST['nombre']."','".$_POST['jornada']."','".$_POST['pais']."','".$_POST['municipio']."','".$_POST['departamento']."','".$_POST['direccion']."','".$_POST['telefono1']."','".$_POST['telefono2']."','".$_POST['calendario']."','".$_POST['tipoinstitucion']."','".$_POST['idioma']."','100','".$_POST['genero']."','0','".$_POST['zona']."','".$_POST['localizacion']."','".$_POST['fax']."','".$_POST['aa']."','0','".$_POST['representante']."','".$_POST['naturaleza']."','0','".$_POST['email']."','".$_POST['direccionelectronica']."')"; 
	     $result = mysql_query($sql,$sala);    
	      echo "<script language='javascript'>
		  window.opener.recargar('".$direccion."');
		  window.opener.focus();
		  window.close();
		  </script>";
	   
	   }
  
   }  
  ?>  
</form>
