<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
require('../../../Connections/sala2.php'); 
$rutaado = "../../../funciones/adodb/";
require_once('../../../Connections/salaado.php'); 
@@session_start();

$direccion = "carreraspreferencia.php";
        $query_datosgrabados = "SELECT * 
								 FROM estudiantecarrerapreferencia e
								 WHERE e.idestudiantecarrerapreferencia = '".$_GET['id']."'";			  
$datosgrabados = $db->Execute($query_datosgrabados);
$totalRows_datosgrabados = $datosgrabados->RecordCount();
$row_datosgrabados = $datosgrabados->FetchRow();
?>
<html>
<head>
<title>.:Carreras Preferencia:.</title>
<link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
<script language="JavaScript" src="calendario/javascripts.js"></script>
</head>
<body>
<form name="inscripcion" method="post" action="">
<p>EDITAR</p>
<table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
        <tr id="trtitulogris">
          <td width="37%">Carrera:</td>
          <td>Descripci&oacute;n:</td>
    </tr>
        <tr>
		 <td>
		   <input name="carrera" type="text" id="carrera" size="40" maxlength="50" value="<?php if (isset ($row_datosgrabados['nombreestudiantecarrerapreferencia'])) echo $row_datosgrabados['nombreestudiantecarrerapreferencia']; else echo $_POST['carrera'];?>">
	      </td>
          <td>
            <input name="descripcion" type="text" id="descripcion" size="70" maxlength="100" value="<?php  if (isset ($row_datosgrabados['porqueestudiantecarrerapreferencia'])) echo $row_datosgrabados['porqueestudiantecarrerapreferencia']; else echo $_POST['descripcion'];?>">
          </td>
        </tr>		
</table>
<?php 
$banderagrabar = 0;
 if (isset($_POST['grabado']))
   {
     if ((!ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*))*$",$_POST['carrera']) or $_POST['carrera'] == ""))
	  {
	    echo '<script language="JavaScript">alert("Debe escribir una Carrera")</script>';		
		$banderagrabar = 1;
	  }
	 else
	   if ((!ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*))*$",$_POST['descripcion']) and $_POST['descripcion'] <> ""))
	  {
	    echo '<script language="JavaScript">alert("Digite la descripción")</script>';		
		$banderagrabar = 1;
	  }	
	else
	 if ($banderagrabar == 0)
	 {
	    $descripcion = "";
		if ($_POST['descripcion'] <> "")
		 {
		    $descripcion = $_POST['descripcion'];		 
		 }
		else
		 {
		    $descripcion = "SIN DEFINIR";	
		 }
	   $base="update estudiantecarrerapreferencia 
	   set nombreestudiantecarrerapreferencia = '".$_POST['carrera']."',
	   porqueestudiantecarrerapreferencia = '".$descripcion."'
	   WHERE idestudiantecarrerapreferencia = '".$_POST['id']."'";	 
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
<br>
<input type="button" value="Enviar" onClick="grabar()"><input type="button" value="Cerrar" onClick="window.close()">
<!-- <a onClick="grabar()" style="cursor: pointer"><img src="../../../../imagenes/guardar.gif" width="25" height="25" alt="Guardar"></a> -->
   <input type="hidden" name="grabado" value="grabado">   
   <input type="hidden" name="id" value="<?php echo $_GET['id'];?>"> 

</form>