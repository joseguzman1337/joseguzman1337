<?php 
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
     
require('../../../Connections/sala2.php'); 
$rutaado = "../../../funciones/adodb/";
require_once('../../../Connections/salaado.php'); 
@@session_start();
?>
<html>
<head>
<title>.:Idiomas:.</title>
<link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
<script language="JavaScript" src="calendario/javascripts.js"></script>
</head>
<body>
<form name="inscripcion" method="post" action="">
<?php
$direccion = "idiomas.php";  
$query_datosgrabados = "SELECT * 
FROM estudiantemediocomunicacion e
WHERE e.idestudiantemediocomunicacion = '".$_GET['id']."'
order by nombremediocomunicacion";			  
$datosgrabados = $db->Execute($query_datosgrabados);
$totalRows_datosgrabados = $datosgrabados->RecordCount();
$row_datosgrabados = $datosgrabados->FetchRow();
?> 
<p>EDITAR</p>
      <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
      <tr id="trtitulogris">
        <td>Nombre:</td>
        <td>Lee:</td>
        <td>Habla:</td>
        <td>Escribe:</td>
        <td>Descripción:</td>
      </tr> 	
	  <tr>
        <td width="24%" ><?php echo $row_datosgrabados['nombreidioma'] ;?></td>
        <td width="13%" ><input name="lee" type="text" id="lee" size="1" maxlength="3" value="<?php if (isset($row_datosgrabados['porcentajeleeestudianteidioma'])) echo $row_datosgrabados['porcentajeleeestudianteidioma']; else echo $_POST['lee']; ?>">%</td>
        <td width="13%" ><input name="habla" type="text" id="habla" size="1" maxlength="3" value="<?php if (isset($row_datosgrabados['porcentajehablaestudianteidioma'])) echo $row_datosgrabados['porcentajehablaestudianteidioma']; else echo $_POST['habla']; ?>">%</td>
        <td width="13%" ><input name="escribe" type="text" id="escribe" size="1" maxlength="3" value="<?php if (isset($row_datosgrabados['porcentajeescribeestudianteidioma'])) echo $row_datosgrabados['porcentajeescribeestudianteidioma']; else echo $_POST['escribe']; ?>">%</td>
        <td width="22%" ><input name="descripcion" type="text" id="descripcion" size="40" maxlength="100" value="<?php if (isset($row_datosgrabados['descripcionestudianteidioma'])) echo $row_datosgrabados['descripcionestudianteidioma']; else echo $_POST['descripcion']; ?>"></td>      
      </tr>
  </table>
<?php
$banderagrabar = 0;
if (isset($_POST['grabado']))
 {		 
	   if (( (!eregi("^[0-9]{1,15}$", $_POST['lee']) or !eregi("^[0-9]{1,15}$", $_POST['habla']) or !eregi("^[0-9]{1,15}$", $_POST['escribe']) or $_POST['lee'] > 100 or $_POST['habla'] > 100 or $_POST['escribe'] > 100)))
		  {
		    echo '<script language="JavaScript">alert("Debe digitar todos los porcentajes del idioma seleccionado"); history.go(-1);</script>';		  
	        $banderagrabar = 1;
		  }	   
	  else
	   if ($banderagrabar == 0)
	   {
		    $base="update estudianteidioma 
		    set  porcentajeleeestudianteidioma = '".$_POST['lee']."',
		    porcentajeescribeestudianteidioma = '".$_POST['escribe']."',	
			porcentajehablaestudianteidioma = '".$_POST['habla']."',
		    descripcionestudianteidioma = '".$_POST['descripcion']."'		
		    WHERE idestudianteidioma  = '".$_POST['id']."'";	 
	        $sol = $db->Execute($base);
	        
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
<br>
<input type="button" value="Enviar" onClick="grabar()">
<!-- <input type="button" value="Cerrar" onClick="window.close()"> -->
<!--    <a onClick="grabar()" style="cursor: pointer"><img src="../../../../imagenes/guardar.gif" width="25" height="25" alt="Guardar"></a> -->
   <input type="hidden" name="grabado" value="grabado">   
   <input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>"> 
 
</form>