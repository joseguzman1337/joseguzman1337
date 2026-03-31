<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
      
require('../../../Connections/sala2.php'); 
$rutaado = "../../../funciones/adodb/";
require_once('../../../Connections/salaado.php'); 

@@session_start();
$direccion = "datosfamiliares.php";
?>
<html>
<head>
<title>.:Datos Familiares:.</title>
<link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
<script language="JavaScript" src="calendario/javascripts.js"></script>
</head>
<body>
<form name="inscripcion" method="post" action="">
<?php
$query_parentesco = "select *
from tipoestudiantefamilia
order by 2";
$parentesco = $db->Execute($query_parentesco);
$totalRows_parentesco = $parentesco->RecordCount();
$row_parentesco = $parentesco->FetchRow();

$query_niveleducacion = "select *
from niveleducacion
order by 2";
$niveleducacion = $db->Execute($query_niveleducacion);
$totalRows_niveleducacion = $niveleducacion->RecordCount();
$row_niveleducacion = $niveleducacion->FetchRow();

$query_ciudad2 = "select *
from ciudad
order by 3";
$ciudad2 = $db->Execute($query_ciudad2);
$totalRows_ciudad2 = $ciudad2->RecordCount();
$row_ciudad2 = $ciudad2->FetchRow();

$query_datosgrabados = "SELECT * 
FROM estudiantefamilia e
WHERE e.idestudiantefamilia = '".$_GET['id']."'";		
$datosgrabados = $db->Execute($query_datosgrabados);
$totalRows_datosgrabados = $datosgrabados->RecordCount();
$row_datosgrabados = $datosgrabados->FetchRow();
?>
<p>EDITAR</p>
<table width="60%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
          <tr>
            <td id="tdtitulogris">Parentesco:</td>
            <td>
              <select name="parentesco">
                <option value="0" <?php if (!(strcmp("0",$row_datosgrabados['idtipoestudiantefamilia']))) {echo "SELECTED";} ?>>Seleccionar</option>
                <?php
				do 
				{  
?>
                <option value="<?php echo $row_parentesco['idtipoestudiantefamilia']?>"<?php if (!(strcmp($row_parentesco['idtipoestudiantefamilia'],$row_datosgrabados['idtipoestudiantefamilia']))) {echo "SELECTED";} ?>><?php echo $row_parentesco['nombretipoestudiantefamilia']?></option>
                <?php	  
                } 
				while($row_parentesco = $parentesco->FetchRow());
				?>
            </select></td>
           <td id="tdtitulogris">Nombre:</td>
            <td><input type="text" name="nombres" size="25" value="<?php if (isset($row_datosgrabados['nombresestudiantefamilia'])) echo $row_datosgrabados['nombresestudiantefamilia']; else echo $_POST['nombres'];?>"></td>
           <td id="tdtitulogris">Apellidos:</td>
            <td><input type="text" name="apellidos"  size="25" value="<?php if (isset($row_datosgrabados['apellidosestudiantefamilia'])) echo $row_datosgrabados['apellidosestudiantefamilia']; else echo $_POST['apellidos'];?>"></td>
          </tr>
          <tr>
            <td id="tdtitulogris">Edad:</td>
            <td>
              <input name="edad" type="text" id="edad" size="2" maxlength="3" value="<?php if (isset($row_datosgrabados['edadestudiantefamilia'])) echo $row_datosgrabados['edadestudiantefamilia']; else echo $_POST['edad'];?>">
             </td>           
            <td id="tdtitulogris">Profesión:</td>
            <td><input type="text" name="profesion" size="25" value="<?php if (isset($row_datosgrabados['profesionestudiantefamilia'])) echo $row_datosgrabados['profesionestudiantefamilia']; else echo $_POST['profesion'];?>"></td>
            <td id="tdtitulogris">Ocupación:</td>
            <td><input type="text" name="ocupacion" size="25" value="<?php if (isset($row_datosgrabados['ocupacionestudiantefamilia'])) echo $row_datosgrabados['ocupacionestudiantefamilia']; else echo $_POST['ocupacion'];?>"></td>
		  </tr>
          <tr>
           <td id="tdtitulogris">E-mail:</td>
            <td colspan="3"><input type="text" name="email" size="40" value="<?php if (isset($row_datosgrabados['emailestudiantefamilia'])) echo $row_datosgrabados['emailestudiantefamilia']; else echo $_POST['email'];?>"></td>
            <td id="tdtitulogris">Celular:</td>
            <td><input type="text" name="celular" size="20" value="<?php if (isset($row_datosgrabados['celularestudiantefamilia'])) echo $row_datosgrabados['celularestudiantefamilia']; else echo $_POST['celular'];?>"></td>
          </tr>
          <tr>
            <td id="tdtitulogris">Ciudad:</td>
            <td>
			  <select name="ciudadfamilia">
                <option value="0" <?php if (!(strcmp("0",$row_datosgrabados['idciudadestudiantefamilia']))) {echo "SELECTED";} ?>>Seleccionar</option>
                <?php
				do 
				{  
?>
                <option value="<?php echo $row_ciudad2['idciudad']?>"<?php if (!(strcmp($row_ciudad2['idciudad'], $row_datosgrabados['idciudadestudiantefamilia']))) {echo "SELECTED";} ?>><?php echo $row_ciudad2['nombreciudad'];?></option>
                <?php				  
                } 
				while($row_ciudad2= $ciudad2->FetchRow());
				?>
              </select>
			</td>
            <td id="tdtitulogris">Direcci&oacute;n:</td>
            <td> 
                <input name="direccion1" type="text" id="direccion1" size="25" maxlength="50" value="<?php  if (isset($row_datosgrabados['direccionestudiantefamilia'])) echo $row_datosgrabados['direccionestudiantefamilia']; else echo $_POST['direccion1'];?>">
            </td>
            <td id="tdtitulogris">Tel&eacute;fono:</td>
            <td>
              <input name="telefono1" type="text" id="Celular4" size="25" value="<?php if (isset($row_datosgrabados['telefonoestudiantefamilia'])) echo $row_datosgrabados['telefonoestudiantefamilia']; else echo $_POST['telefono1'];?>">
            </td>
          </tr>
		  <tr>
            <td id="tdtitulogris">Nivel de Educaci&oacute;n:</td>
            <td>
              <select name="niveleducacion">
                <option value="0" <?php if (!(strcmp("0",$row_datosgrabados['idniveleducacion']))) {echo "SELECTED";} ?>>Seleccionar</option>
                <?php
				do 
				{
				?>
                <option value="<?php echo $row_niveleducacion['idniveleducacion']?>"<?php if (!(strcmp($row_niveleducacion['idniveleducacion'],$row_datosgrabados['idniveleducacion']))) {echo "SELECTED";} ?>><?php echo $row_niveleducacion['nombreniveleducacion'];?></option>
                <?php				  
                } 
				while($row_niveleducacion= $niveleducacion->FetchRow());
				?>
              </select></td>
            <td id="tdtitulogris">Direcci&oacute;n Correspondencia:</td>
            <td> 
              <input name="direccion2" type="text" id="direccion2" size="25"  value="<?php if (isset($row_datosgrabados['direccioncorrespondenciaestudiantefamilia'])) echo $row_datosgrabados['direccioncorrespondenciaestudiantefamilia']; else echo $_POST['direccion2']?>">
</td>
            <td id="tdtitulogris">Tel&eacute;fono 2:</td>
            <td>
              <input name="telefono2" type="text" id="telefono2" size="25" value="<?php if (isset($row_datosgrabados['telefono2estudiantefamilia'])) echo $row_datosgrabados['telefono2estudiantefamilia']; else echo $_POST['telefono2']?>">
            </td>
          </tr>
</table>
<?php 
$banderagrabar = 0;
if (isset($_POST['grabado']))
 {	 
	  $email = "^[A-z0-9\._-]+"
							."@"
							."[A-z0-9][A-z0-9-]*"
							."(\.[A-z0-9_-]+)*"
							."\.([A-z]{2,6})$";
	  if ($_POST['parentesco'] == 0)
	   {
	     echo '<script language="JavaScript">alert("Debe elegir el parentesco")</script>';		
		 $banderagrabar = 1;
	   }
	  else	  
	  if ((!ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*))*$",$_POST['nombres']) or $_POST['nombres'] == ""))
	  {
	    echo '<script language="JavaScript">alert("Falta digitar el nombre")</script>';		
		$banderagrabar = 1;
	  }
	 else
	   if ((!ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*))*$",$_POST['apellidos']) or $_POST['apellidos'] == ""))
	  {
	    echo '<script language="JavaScript">alert("Falta digitar los apellidos")</script>';		
		$banderagrabar = 1;
	  }	
	 else
	  if (!eregi("^[0-9]{1,15}$", $_POST['edad'])  and $_POST['edad'] <> "")
	  {
	    echo '<script language="JavaScript">alert("Falta digitar la edad")</script>';		
		$banderagrabar = 1;
	  }	
	 else
	   if ((!ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*))*$",$_POST['profesion']) and $_POST['profesion'] <> ""))
	  {
	    echo '<script language="JavaScript">alert("Falta digitar la profesión")</script>';		
		$banderagrabar = 1;
	  }
	 else
	   if ((!ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*))*$",$_POST['ocupacion']) and $_POST['ocupacion'] <> ""))
	  {
	    echo '<script language="JavaScript">alert("Falta digitar la Ocupación")</script>';		
		$banderagrabar =1;
	 } 	
	 else
	  if (!eregi("^[0-9]{1,15}$", $_POST['telefono1']) and $_POST['telefono1'] <> "")
	  {
	    echo '<script language="JavaScript">alert("Teléfono Incorrecto")</script>';		
		$banderagrabar = 1;
	  }
	 else
	  if (!eregi("^[0-9]{1,15}$", $_POST['telefono2']) and $_POST['telefono2'] <> "")
	  {
	    echo '<script language="JavaScript">alert("Teléfono2 Incorrecto")</script>';		
		$banderagrabar = 1;
	  }
	 else
	  if (!eregi("^[0-9]{1,15}$", $_POST['celular']) and $_POST['celular'] <> "")
	  {
	    echo '<script language="JavaScript">alert("Celular Incorrecto")</script>';		
		$banderagrabar = 1;
	  }
	else	  
	  if (!eregi($email,$_POST['email']) and $_POST['email'] <> "")
	   {
	     echo '<script language="JavaScript">alert("E-mail Incorrecto")</script>';		    		  
		 $banderagrabar = 1;
	   } 
	else
	 if ($banderagrabar == 0)
	 {	 
	   $nivel = "";
	   $ciudad = "";
	    if ($_POST['niveleducacion'] <> 0)
		 {
		   $nivel = $_POST['niveleducacion'];
		 }
		else 
		 {
		   $nivel = 1;
		 }
	   if ($_POST['ciudadfamilia'] <> 0)
		 {
		   $ciudad = $_POST['ciudadfamilia'];
		 }
		else 
		 {
		   $ciudad = 1;
		 }
	    $base="update estudiantefamilia
	   set apellidosestudiantefamilia = '".$_POST['apellidos']."',
	   nombresestudiantefamilia = '".$_POST['nombres']."',
	   edadestudiantefamilia = '".$_POST['edad']."',
	   direccionestudiantefamilia = '".$_POST['direccion1']."',
	   idciudadestudiantefamilia = '".$ciudad."',
	   telefonoestudiantefamilia = '".$_POST['telefono1']."',
	   telefono2estudiantefamilia = '".$_POST['telefono2']."',
	   celularestudiantefamilia = '".$_POST['celular']."',
	   emailestudiantefamilia = '".$_POST['email']."',
	   direccioncorrespondenciaestudiantefamilia = '".$_POST['direccion2']."',
	   idtipoestudiantefamilia = '".$_POST['parentesco']."',
	   profesionestudiantefamilia = '".$_POST['profesion']."',
	   ocupacionestudiantefamilia = '".$_POST['ocupacion']."',
	   idniveleducacion = '".$nivel."'
	   WHERE idestudiantefamilia= '".$_POST['id']."'";
	   $sol = $db->Execute($base);	 
	   
	   echo "<script language='javascript'>
			window.opener.recargar('".$direccion."');
			window.opener.focus();
			window.close();
		    </script>"; 	 
	 }
 }	
?>
<script language="javascript">
function grabar()
 {
  document.inscripcion.submit();
 }
</script>
   <!-- <a onClick="grabar()" style="cursor: pointer"><img src="../../../../imagenes/guardar.gif" width="25" height="25" alt="Guardar"></a> -->
<br>
<input type="button" value="Enviar" onClick="grabar()"><input type="button" value="Cerrar" onClick="window.close()">
   <input type="hidden" name="grabado" value="grabado">   
   <input type="hidden" name="id" value="<?php echo $_GET['id'];?>"> 

</form>