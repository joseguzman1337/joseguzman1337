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
$_SESSION['modulosesion'] = "informacionfamiliar";
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
<p>EDITAR DATOS FAMILIARES</p>
<table width="60%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
<!--DARIO GUALTEROS SEPTIEMBRE 1 -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
          <tr>
            <td id="tdtitulogris">Parentesco:</td>
            <td>
              <select name="idtipoestudiantefamilia">
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
            <td><input type="text" name="nombresestudiantefamilia" size="25" value="<?php if (isset($row_datosgrabados['nombresestudiantefamilia'])) echo $row_datosgrabados['nombresestudiantefamilia']; else echo $_POST['nombresestudiantefamilia'];?>"></td>
           <td id="tdtitulogris">Apellidos:</td>
            <td><input type="text" name="apellidosestudiantefamilia"  size="25" value="<?php if (isset($row_datosgrabados['apellidosestudiantefamilia'])) echo $row_datosgrabados['apellidosestudiantefamilia']; else echo $_POST['apellidosestudiantefamilia'];?>"></td>
          </tr>
          <tr>
           <!--  <td id="tdtitulogris">Edad:</td>
            <td>
              <input name="edad" type="text" id="edad" size="2" maxlength="3" value="<?php if (isset($row_datosgrabados['edadestudiantefamilia'])) echo $row_datosgrabados['edadestudiantefamilia']; else echo $_POST['edad'];?>">
             </td>           
            <td id="tdtitulogris">Profesión:</td>
            <td><input type="text" name="profesion" size="25" value="<?php if (isset($row_datosgrabados['profesionestudiantefamilia'])) echo $row_datosgrabados['profesionestudiantefamilia']; else echo $_POST['profesion'];?>"></td>
            -->
            <td id="tdtitulogris">Ocupación:</td> 
            <td><input type="text" name="ocupacionestudiantefamilia" size="25" value="<?php if (isset($row_datosgrabados['ocupacionestudiantefamilia'])) echo $row_datosgrabados['ocupacionestudiantefamilia']; else echo $_POST['ocupacionestudiantefamilia'];?>">
            </td>
		 <!--  </tr>
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
            </td>  -->
            <td id="tdtitulogris">Tel&eacute;fono:</td>
             <td>
              <input name="telefonoestudiantefamilia" type="text" id="Celular4" size="25" value="<?php if (isset($row_datosgrabados['telefonoestudiantefamilia'])) echo $row_datosgrabados['telefonoestudiantefamilia']; else echo $_POST['telefonoestudiantefamilia'];?>">
            </td>
              
          <!-- </tr>
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
            </td> -->
         </tr>
         <!--
            * Caso 93750 
            * @modified Luis Dario Gualteros 
            * <castroluisd@unbosque.edu.co>
            * Se adiciona al campo E-mail de acuerdo a la solicitud de atención al usuario.
            * @since Septiembre 5 de 2017
         -->
        <tr>       
           <td id="tdtitulogris">E-mail:</td>
           <td>
              <input name="email" type="text" id="email" size="50" value="<?php if (isset($row_datosgrabados['emailestudiantefamilia'])) echo $row_datosgrabados['emailestudiantefamilia']; else echo $_POST['emailestudiantefamilia'];?>" required>
           </td>       
        </tr>
        <!--End Caso 93750 -->
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
	if ($_POST['idtipoestudiantefamilia'] == 0)
	{
		echo '<script language="JavaScript">alert("Debe elegir el parentesco")</script>';		
		$banderagrabar = 1;
	}
	else if ((!ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*))*$",$_POST['nombresestudiantefamilia']) or $_POST['nombresestudiantefamilia'] == ""))
	{
		echo '<script language="JavaScript">alert("Falta digitar el nombre")</script>';		
		$banderagrabar = 1;
	}
	else if ((!ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*))*$",$_POST['apellidosestudiantefamilia']) or $_POST['apellidosestudiantefamilia'] == ""))
	{
		echo '<script language="JavaScript">alert("Falta digitar los apellidos")</script>';		
		$banderagrabar = 1;
	}	
	/*else if (!eregi("^[0-9]{1,15}$", $_POST['edad'])  and $_POST['edad'] <> "")
	{
		echo '<script language="JavaScript">alert("Falta digitar la edad")</script>';		
		$banderagrabar = 1;
	}	
	else if ((!ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*))*$",$_POST['profesion']) and $_POST['profesion'] <> ""))
	{
		echo '<script language="JavaScript">alert("Falta digitar la profesión")</script>';		
		$banderagrabar = 1;
	}*/
	else if ((!ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*))*$",$_POST['ocupacionestudiantefamilia']) and $_POST['ocupacionestudiantefamilia'] <> ""))
	{
		echo '<script language="JavaScript">alert("Falta digitar la Ocupación")</script>';		
		$banderagrabar =1;
	} 	
	else if (!eregi("^[0-9]{1,15}$", $_POST['telefonoestudiantefamilia']) and $_POST['telefonoestudiantefamilia'] <> "" or $_POST['telefonoestudiantefamilia']=="")
	{
		echo '<script language="JavaScript">alert("Teléfono Incorrecto o vacío")</script>';		
		$banderagrabar = 1;
	}
	 /*
      * Caso 93750
      * @modified Luis Dario Gualteros 
      * <castroluisd@unbosque.edu.co>
      * Se Crea la validacioón para el campo email para qeu sea valido y no sea vacío
      * @since Septiembre 5 de 2017
     */
    else if (!eregi("^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,4})$",$_POST['email']) and $_POST['email'] <> "" or $_POST['email']=="")
	{
	     echo '<script language="JavaScript">alert("E-mail Incorrecto o vacío")</script>';		    		  
		 $banderagrabar = 1;
	} 
    // End Caso 93750
	else if ($banderagrabar == 0)
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
		$db->debug = true;
	    /*
          * Caso 93750
          * @modified Luis Dario Gualteros 
          * <castroluisd@unbosque.edu.co>
          * Se adiciona el campo email para que sea modificado en datos familiares
          * @since Septiembre 5 de 2017
        */
        $base="update estudiantefamilia
	   	set apellidosestudiantefamilia = '".$_POST['apellidosestudiantefamilia']."',
	   	nombresestudiantefamilia = '".$_POST['nombresestudiantefamilia']."',
	   	telefonoestudiantefamilia = '".$_POST['telefonoestudiantefamilia']."',
	   	idtipoestudiantefamilia = '".$_POST['idtipoestudiantefamilia']."',
	   	ocupacionestudiantefamilia = '".$_POST['ocupacionestudiantefamilia']."',
        emailestudiantefamilia = '".$_POST['email']."'
	   	WHERE idestudiantefamilia= '".$_POST['id']."'";
	   	$sol = $db->Execute($base);	 
        // End Caso 93750
	   	/* edadestudiantefamilia = '".$_POST['edad']."',
	   	direccionestudiantefamilia = '".$_POST['direccion1']."',
	   	idciudadestudiantefamilia = '".$ciudad."',
		telefono2estudiantefamilia = '".$_POST['telefono2']."',
	   	celularestudiantefamilia = '".$_POST['celular']."',
	   	emailestudiantefamilia = '".$_POST['email']."',
	   	direccioncorrespondenciaestudiantefamilia = '".$_POST['direccion2']."',
	   	profesionestudiantefamilia = '".$_POST['profesion']."',
	   	idniveleducacion = '".$nivel."'
	   	*/
	   	//exit();
	   	echo "<script language='javascript'>
	   		window.location.href='formulariodeinscripcion.php?".$_SESSION['fppal']."#ancla".$_SESSION['modulosesion']."';
			/*window.opener.recargar('".$direccion."');
			window.opener.focus();
			window.close();*/
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
<input type="button" value="Enviar" onClick="grabar()">
<a href="javascript:window.history.back();"><button>Regresar</button></a>     
   <input type="hidden" name="grabado" value="grabado">   
   <input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>"> 
</form>