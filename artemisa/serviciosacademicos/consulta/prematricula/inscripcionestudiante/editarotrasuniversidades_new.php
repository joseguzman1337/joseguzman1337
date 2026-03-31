<?php  
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
require('../../../Connections/sala2.php'); 
$rutaado = "../../../funciones/adodb/";
require_once('../../../Connections/salaado.php'); 

$direccion = "otrasuniversidades.php"; 

session_start();
$_SESSION['modulosesion'] = "informacionotrasu";
?>
<html>
<head>
<title>.:Otras U:.</title>
<link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
<script language="JavaScript" src="calendario/javascripts.js"></script>
</head>
<body>
<form name="inscripcion" method="post" action="">
<?php
//$db->debug=true;
$query_datosgrabados = "SELECT * 
FROM estudianteuniversidad e
WHERE e.idestudianteuniversidad = '".$_GET['id']."'
and e.codigoestado like '1%'
and e.idinscripcion = '".$_SESSION['inscripcionsession']."'";			  
//echo $query_data; 
$datosgrabados = $db->Execute($query_datosgrabados);
$totalRows_datosgrabados = $datosgrabados->RecordCount();
$row_datosgrabados = $datosgrabados->FetchRow();
?>
<table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">	
	<tr id="trtitulogris">
          <td colspan="3">EDITAR</td>
    </tr>
		 <tr id="trtitulogris">
          <td>Instituci&oacute;n:</td>
          <td>Programa:</td>
	      <td>Año Presentación:</td>
    </tr>
		<tr>
          <td>
            <input type="text" name="institucion" size="30" value="<?php if (isset($row_datosgrabados['institucioneducativaestudianteuniversidad'])) echo $row_datosgrabados['institucioneducativaestudianteuniversidad']; else  echo $_POST['institucion'];?>">
	      </td>
          <td >
            <input type="text" name="programa" size="30" value="<?php  if (isset($row_datosgrabados['programaacademicoestudianteuniversidad'])) echo $row_datosgrabados['programaacademicoestudianteuniversidad']; else echo $_POST['programa'];?>">
          </td>
		  <td ><input name="ano" type="text" id="ano" size="2" maxlength="4" value="<?php if (isset($row_datosgrabados['anoestudianteuniversidad'])) echo $row_datosgrabados['anoestudianteuniversidad']; else echo $_POST['ano'];?>"></td>
	</tr>        
 </table>
<?php
if (isset($_POST['grabado']))
 {		
	$banderagrabar = 0;    
	 if ((!ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*))*$",$_POST['institucion'])) or $_POST['institucion'] == "")
	    {
		  echo '<script language="JavaScript">alert("Digite la institución"); history.go(-1);</script>';		
		 $banderagrabar = 1;
		}	
	else
	if ((!ereg("^([a-zA-ZáéíóúüñÁÉÍÓÚÑÜ]+([A-Za-záéíóúüñÁÉÍÓÚÑÜ]*|( [A-Za-záéíóúüñÁÉÍÓÚÑÜ]+)*))*$",$_POST['programa'])) or $_POST['programa'] == "")
	 {   
		 echo '<script language="JavaScript">alert("Digite el programa"); history.go(-1);</script>';		
		$banderagrabar = 1;	
		
	 }
	else
	if ((!eregi("^[0-9]{1,15}$", $_POST['ano']) or $_POST['ano'] > date("Y")) and $_POST['ano'] <> "")
	  {
	    echo '<script language="JavaScript">alert("Año Incorrecto")</script>';		
		$banderagrabar = 1;
	  }      
   else
    if ($banderagrabar == 0)
	  {
           $base="update estudianteuniversidad 
		   set institucioneducativaestudianteuniversidad = '".$_POST['institucion']."',
		   programaacademicoestudianteuniversidad = '".$_POST['programa']."',
		   anoestudianteuniversidad = '".$_POST['ano']."'
		   WHERE idestudianteuniversidad = '".$_POST['id']."'";	  
		 // echo $base;
		   $sol = $db->Execute($base);		
		   
		   echo "<script language='javascript'>
			window.location.href='formulariodeinscripcion.php?".$_SESSION['fppal']."#ancla".$_SESSION['modulosesion']."';
			/*window.opener.recargar('$direccion');
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
<br><br>

 <!--    <a onClick="grabar()" style="cursor: pointer"><img src="../../../../imagenes/guardar.gif" width="25" height="25" alt="Guardar"></a> -->
 <input type="button" value="Enviar" onClick="grabar()">
   <input type="hidden" name="grabado" value="grabado">   
   <input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>"> 
 
</form>