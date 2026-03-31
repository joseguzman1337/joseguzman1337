<?php  
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
require('../../../Connections/sala2.php'); 
$rutaado = "../../../funciones/adodb/";
require_once('../../../Connections/salaado.php'); 
@@session_start();
$_SESSION['modulosesion'] = "informacionidiomas";
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
						    FROM estudianteidioma e,idioma i
							WHERE e.idestudianteidioma = '".$_GET['id']."'
							and e.ididioma = i.ididioma								 
							";			  
$datosgrabados = $db->Execute($query_datosgrabados);
$totalRows_datosgrabados = $datosgrabados->RecordCount();
$row_datosgrabados = $datosgrabados->FetchRow();

$porcentajeidioma = ($row_datosgrabados['porcentajeleeestudianteidioma'] + $row_datosgrabados['porcentajehablaestudianteidioma'] + $row_datosgrabados['porcentajeescribeestudianteidioma']) / 3;
?> 
<p>EDITAR</p>
      <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
      <tr id="trtitulogris">
        <td>Nombre:</td>
        <td>Nivel</td>
        <!-- <td>Lee:</td>
        <td>Habla:</td>
        <td>Escribe:</td>
        <td>Descripción:</td>
         -->
      </tr> 	
	  <tr>
        <td width="50%"><?php echo $row_datosgrabados['nombreidioma'] ;?></td>
        <td width="50%">Básico <input type="radio" name="nivelidioma" value="20" <?php if($porcentajeidioma <= 30) echo "checked"; ?>> 
            &nbsp;&nbsp;&nbsp;Intermedio <input type="radio" name="nivelidioma" value="60" <?php if($porcentajeidioma > 30 && $porcentaje <= 70) echo "checked"; ?>> 
            &nbsp;&nbsp;&nbsp;Avanzado <input type="radio" name="nivelidioma" value="90" <?php if($porcentajeidioma > 70) echo "checked"; ?>>
            <?php 
            if($row_datosgrabados['ididioma'] == 10)
            { 
            echo " ¿Cuál?: ";?>
            <input type="hidden" name="ididioma" value="<?php echo $row_datosgrabados['ididioma'];?>">
            <input name="descripcion" type="text" id="descripcion" size="20" maxlength="100" value="<?php echo $row_datosgrabados['descripcionestudianteidioma']; ?>">
           <?php
			}
            ?>
            </td>
        <!-- <td width="13%" ><input name="lee" type="text" id="lee" size="1" maxlength="3" value="<?php if (isset($row_datosgrabados['porcentajeleeestudianteidioma'])) echo $row_datosgrabados['porcentajeleeestudianteidioma']; else echo $_POST['lee']; ?>">%</td>
        <td width="13%" ><input name="habla" type="text" id="habla" size="1" maxlength="3" value="<?php if (isset($row_datosgrabados['porcentajehablaestudianteidioma'])) echo $row_datosgrabados['porcentajehablaestudianteidioma']; else echo $_POST['habla']; ?>">%</td>
        <td width="13%" ><input name="escribe" type="text" id="escribe" size="1" maxlength="3" value="<?php if (isset($row_datosgrabados['porcentajeescribeestudianteidioma'])) echo $row_datosgrabados['porcentajeescribeestudianteidioma']; else echo $_POST['escribe']; ?>">%</td>
        <td width="22%" ><input name="descripcion" type="text" id="descripcion" size="40" maxlength="100" value="<?php if (isset($row_datosgrabados['descripcionestudianteidioma'])) echo $row_datosgrabados['descripcionestudianteidioma']; else echo $_POST['descripcion']; ?>"></td>
         -->      
      </tr>
  </table>
<?php
$banderagrabar = 0;
if (isset($_POST['grabado']))
 {		 
	   //if (( (!eregi("^[0-9]{1,15}$", $_POST['lee']) or !eregi("^[0-9]{1,15}$", $_POST['habla']) or !eregi("^[0-9]{1,15}$", $_POST['escribe']) or $_POST['lee'] > 100 or $_POST['habla'] > 100 or $_POST['escribe'] > 100)))
		 if (( (!eregi("^[0-9]{1,15}$", $_POST['nivelidioma']) or !eregi("^[0-9]{1,15}$", $_POST['nivelidioma']) or !eregi("^[0-9]{1,15}$", $_POST['nivelidioma']) or $_POST['nivelidioma'] > 100 or $_POST['nivelidioma'] > 100 or $_POST['nivelidioma'] > 100)))
		 {
		    echo '<script language="JavaScript">alert("Debe digitar todos los porcentajes del idioma seleccionado"); history.go(-1);</script>';		  
	        $banderagrabar = 1;
		  }	   
	  else
	   if ($banderagrabar == 0)
	   {
		    /*$base="update estudianteidioma 
		    set  porcentajeleeestudianteidioma = '".$_POST['lee']."',
		    porcentajeescribeestudianteidioma = '".$_POST['escribe']."',	
			porcentajehablaestudianteidioma = '".$_POST['habla']."',
		    descripcionestudianteidioma = '".$_POST['descripcion']."'		
		    WHERE idestudianteidioma  = '".$_POST['id']."'";*/
	   		if($_POST['descripcion'] == "" && $_POST['ididioma'] == 10)
	  		{
	  			echo '<script language="JavaScript">alert("Debe digitar el nombre del otro idioma");</script>';
	  		}
	  		else
	  		{
		   		$base="update estudianteidioma 
			    set  porcentajeleeestudianteidioma = '".$_POST['nivelidioma']."',
			    porcentajeescribeestudianteidioma = '".$_POST['nivelidioma']."',	
				porcentajehablaestudianteidioma = '".$_POST['nivelidioma']."',
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