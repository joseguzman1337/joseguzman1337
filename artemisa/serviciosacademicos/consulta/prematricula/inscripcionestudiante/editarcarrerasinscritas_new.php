<?php  
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
require('../../../Connections/sala2.php'); 
$rutaado = "../../../funciones/adodb/";
require_once('../../../Connections/salaado.php'); 
@@session_start();

$_SESSION['modulosesion'] = "informacionsegundaopcion";
$direccion = "carrerasinscritas.php";
$fecha = date("Y-m-d G:i:s",time());

//print_r($_REQUEST);
//exit();
$query_data = "SELECT eg.*,c.nombrecarrera,m.nombremodalidadacademica,ci.nombreciudad,m.codigomodalidadacademica,i.idinscripcion,c.codigocarrera
FROM estudiantegeneral eg,inscripcion i,estudiantecarrerainscripcion e,carrera c,modalidadacademica m,ciudad ci
WHERE numerodocumento = '".$_REQUEST['numerodocumento']."'
AND eg.idestudiantegeneral = i.idestudiantegeneral
AND eg.idciudadnacimiento = ci.idciudad
AND i.idinscripcion = e.idinscripcion
AND e.codigocarrera = c.codigocarrera
AND m.codigomodalidadacademica = i.codigomodalidadacademica 
AND e.idnumeroopcion = '1'
and i.codigoestado like '1%'
and i.idinscripcion = '".$_REQUEST['idinscripcion']."'"; 
$data = $db->Execute($query_data);
$totalRows_data = $data->RecordCount();
$row_data = $data->FetchRow();
/*
 * Caso 106584.
 * Modificado por Luis Dario Gualteros C <castroluisd@unbosque.edu.co> 
 * Se adiciona la validación AND codigocarrera <> '1 Y 10' ya que la opción todas las carreras y Medicina 
 * No pueden ser segunda opción de ninguna carrera.
 * Modificado 24 de Octubre 2018.
*/
   $query_car = "SELECT nombrecarrera,codigocarrera 
    FROM carrera 
    WHERE codigomodalidadacademica = '".$row_data['codigomodalidadacademica']."'
    AND fechavencimientocarrera > '".$fecha."'
    AND codigocarrera NOT IN ('".$row_data['codigocarrera']."','1')
    ORDER BY 1";		
//End Caso 106584.
$car = $db->Execute($query_car);
$totalRows_car = $car->RecordCount();
$row_car = $car->FetchRow();
			
$query_datosgrabados = "SELECT * 
						FROM estudiantecarrerainscripcion e
						WHERE e.idestudiantecarrerainscripcion = '".$_GET['id']."'
					    ";			  
$datosgrabados = $db->Execute($query_datosgrabados);
$totalRows_datosgrabados = $datosgrabados->RecordCount();
$row_datosgrabados = $datosgrabados->FetchRow();
?>
<html>
<head>
<title>.:Carreras Inscritas:.</title>
<link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
<script language="JavaScript" src="calendario/javascripts.js"></script>
</head>
<body>
<p>EDITAR</p>
<form name="inscripcion" method="post" action="">
	<table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
			<tr id="trtitulogris">
	<td colspan="2">Carrera</td>	  
	<?php 
	 $cuentamedio = 1;
	?> 
	 <tr>
          <td width="70%">
		      <select name="carrera" id="especializacion" onChange="enviar()">
           <option value="0" <?php if (!(strcmp("0", $row_datosgrabados['codigocarrera']))) {echo "SELECTED";} ?>>Seleccionar</option>
 <?php
             do {  
?>
              <option value="<?php echo $row_car['codigocarrera']?>"<?php if (!(strcmp($row_car['codigocarrera'], $row_datosgrabados['codigocarrera']))) {echo "SELECTED";} ?>><?php echo $row_car['nombrecarrera']?></option>
<?php
				} while ($row_car = $car->FetchRow());
?>
          </select>
	   </td>
     </tr>       
</table>
<?php
$banderagrabar = 0;
if (isset($_POST['grabado']))
 {		
	   if ($_POST['carrera'] == 0)
	    {
		  echo '<script language="JavaScript">alert("Debe seleccionar una Carrera"); history.go(-1);</script>';		
		  $indicador = 1;
		}	
	else
	 if ($indicador == 0)
	 {  
	    $base="update estudiantecarrerainscripcion
	    set codigocarrera = '".$_POST['carrera']."'	   
	    WHERE idestudiantecarrerainscripcion = '".$_POST['id']."'";	 
	    $sol=mysql_db_query($database_sala,$base);		
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
<!-- <input type="button" value="Cerrar" onClick="window.close()">  -->
<!-- <a onClick="grabar()" style="cursor: pointer"><img src="../../../../imagenes/guardar.gif" width="25" height="25" alt="Guardar"></a> -->
   <input type="hidden" name="grabado" value="grabado">   
   <input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>"> 

</form>