<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Editar Materia</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<?php 
require_once('../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
require_once('../../../Connections/salaado.php'); 
require_once('../../../funciones/clases/autenticacion/redirect.php'); 
if (isset($_GET['materia']))
 {
  $nombremateria = $_GET['materia'];
  $materiacompleta = explode(" ", $_GET['materia']);
  $_GET['materia'] = $materiacompleta[0];
 }

$query_materia = "SELECT  m.*,l.nombrelineaacademica,i.nombreindicadorgrupomateria,t.nombretipomateria,e.nombreindicadoretiquetamateria,tc.nombretipocalificacionmateria
FROM materia m,lineaacademica l,indicadorgrupomateria i,tipomateria t,indicadoretiquetamateria e,tipocalificacionmateria tc
WHERE m.codigolineaacademica = l.codigolineaacademica
AND  m.codigoindicadorgrupomateria = i.codigoindicadorgrupomateria
AND t.codigotipomateria = m.codigotipomateria
AND e.codigoindicadoretiquetamateria = m.codigoindicadoretiquetamateria 
AND tc.codigotipocalificacionmateria =m.codigotipocalificacionmateria
and m.codigomateria = '".$_GET['materia']."'";						
$materia =  $db->Execute($query_materia);
$row_materia = $materia->FetchRow();
$totalRows_materia = $materia->RecordCount();

$query_modalidadmateria = "SELECT  *
from modalidadmateria mm";						
$modalidadmateria = $db->Execute($query_modalidadmateria);
$row_modalidadmateria = $modalidadmateria->FetchRow();
$totalRows_modalidadmateria = $modalidadmateria->RecordCount();

?>
 <form name="form1" method="post" action="">
 <input name="materia" type="hidden" value="<?php echo $_GET['materia']; ?>">
<link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
<body>
 <p align="center">ACTUALIZAR LA MATERIA <br> <?php echo $nombremateria; ?></p>
<table align="center"  width="90%" bordercolor="#E9E9E9" border="1" cellpadding="1" cellspacing="0">
<tr>
 <td id="tdtitulogris" bordercolordark="#E97914" >Modalidad Materia *</td>
 <td bordercolorlight="#E97914">
    <select name="modalidad"> 
	   <option value="0" <?php if (!(strcmp("0", $row_materia['codigomodalidadmateria']))) {echo "SELECTED";} ?>>Seleccionar</option>
<?php
       
   	   do 
		{  
?>
          <option value="<?php echo $row_modalidadmateria['codigomodalidadmateria']?>"<?php if (!(strcmp($row_modalidadmateria['codigomodalidadmateria'], $row_materia['codigomodalidadmateria']))) {echo "SELECTED";} ?>><?php echo $row_modalidadmateria['nombremodalidadmateria']?></option>
<?php	  
        }while($row_modalidadmateria = $modalidadmateria->FetchRow());
?>
         </select></td>
</tr>
<tr>
 <td id="tdtitulogris" bordercolordark="#E97914">Nota Mínima Aprobatoria *</td>
 <td bordercolorlight="#E97914"><input name="notaaprobatoria" type="text" value="<?php echo $row_materia['notaminimaaprobatoria']; ?>" size="1" maxlength="3"></td>
</tr>
<tr>
 <td id="tdtitulogris" bordercolordark="#E97914">Nota Mínima Habilitación *</td>
 <td bordercolorlight="#E97914"><input name="notahabilitacion" type="text" value="<?php echo $row_materia['notaminimahabilitacion']; ?>" size="1" maxlength="3"></td>
</tr>
<tr>
 <td id="tdtitulogris" bordercolordark="#E97914">Número Semanas *</td>
 <td bordercolorlight="#E97914"><input name="numerosemanas" type="text" value="<?php echo $row_materia['numerosemana']; ?>" size="1" maxlength="3"></td>
</tr>
<tr>
 <td id="tdtitulogris" bordercolordark="#E97914">Número Horas Semanales *</td>
 <td bordercolorlight="#E97914"><input name="numerohoras" type="text" value="<?php echo $row_materia['numerohorassemanales']; ?>" size="1" maxlength="3"></td>
</tr>
<tr>
 <td id="tdtitulogris" bordercolordark="#E97914">Porcentaje Fallas Teoría *</td>
 <td bordercolorlight="#E97914"><input name="teoria" type="text" value="<?php echo $row_materia['porcentajefallasteoriamodalidadmateria']; ?>" size="1" maxlength="3"></td>
</tr>
<tr>
 <td id="tdtitulogris" bordercolordark="#E97914">Porcentaje Fallas Práctica *</td>
 <td  bordercolorlight="#E97914"><input name="practica" type="text" value="<?php echo $row_materia['porcentajefallaspracticamodalidadmateria']; ?>" size="1" maxlength="3"></td>
</tr>

<tr>
 <td id="tdtitulogris" bordercolordark="#E97914">Línea Académica *</td>
 <td  bordercolorlight="#E97914"><?php echo $row_materia['nombrelineaacademica'];?></td>
</tr>

<tr>
 <td id="tdtitulogris" bordercolordark="#E97914">Grupo Materia *</td>
 <td  bordercolorlight="#E97914"><?php echo $row_materia['nombreindicadorgrupomateria'];?></td>
</tr>

<tr>
 <td id="tdtitulogris" bordercolordark="#E97914">Tipo Materia *</td>
 <td  bordercolorlight="#E97914"><?php echo $row_materia['nombretipomateria'];?></td>
</tr>

<tr>
 <td id="tdtitulogris" bordercolordark="#E97914">Etiqueta Materia *</td>
 <td  bordercolorlight="#E97914"><?php echo $row_materia['nombreindicadoretiquetamateria'];?></td>
</tr>

<tr>
 <td id="tdtitulogris" bordercolordark="#E97914">Tipo Calificación Materia *</td>
 <td  bordercolorlight="#E97914"><?php echo $row_materia['nombretipocalificacionmateria'];?></td>
</tr>
</table>
<div align="center"><br>
    <input type="submit" name="Submit" value="Actualizar">
</div>
</body>
<?php 
 if ($_POST['Submit'])
  {
    if ($_POST['modalidad'] == 0)	             
	{echo '<script language="JavaScript">alert("Los Campos con * son Obligatrios");</script>';  exit(); } else
	if ((!eregi("^[0-5]{1,1}\.[0-9]{1,2}$", $_POST['notaaprobatoria'])) or ($_POST['notaaprobatoria'] > 5))	
	{ echo '<script language="JavaScript">alert("Las notas van en formato numerico separado por Punto (.)");</script>';  exit(); } else
	if ((!eregi("^[0-5]{1,1}\.[0-9]{1,2}$", $_POST['notahabilitacion'])) or ($_POST['notahabilitacion'] > 5))	 
	{ echo '<script language="JavaScript">alert("Las notas van en formato numerico separado por Punto (.)");</script>';  exit(); } else
	if (!eregi("^[0-9]{1,15}$", $_POST['numerosemanas']))	     
	{ echo '<script language="JavaScript">alert("El número de semanas debe digitarse en formato numérico");</script>';   exit(); } else
	if (!eregi("^[0-9]{1,15}$", $_POST['numerohoras'] ))	     
	{ echo '<script language="JavaScript">alert("El número de horas semanales debe digitarse en formato numérico");</script>';  exit(); } else
	if (!eregi("^[0-9]{1,15}$", $_POST['teoria'] ))	             
	{ echo '<script language="JavaScript">alert("Los porcentajes deben digitarse en formato numérico");</script>';  exit(); } else
	if (!eregi("^[0-9]{1,15}$", $_POST['practica'] ) )	         
	{ echo '<script language="JavaScript">alert("Los porcentajes deben digitarse en formato numérico");</script>';  exit(); } else
    {
	  $updateSQL = "UPDATE materia 
      SET 
	  codigomodalidadmateria = '".$_POST['modalidad']."', 
      notaminimaaprobatoria  = '".$_POST['notaaprobatoria']."',
	  notaminimahabilitacion = '".$_POST['notahabilitacion']."',	 		 
	  numerosemana           = '".$_POST['numerosemanas']."',		 
	  numerohorassemanales   = '".$_POST['numerohoras']."',		 
	  porcentajefallasteoriamodalidadmateria   = '".$_POST['teoria']."',		 
	  porcentajefallaspracticamodalidadmateria = '".$_POST['practica']."'		 
	  WHERE codigomateria = '".$_POST['materia']."'
	  ";		
	  $Result1 = $db->Execute($updateSQL);
	 // echo $updateSQL; 
	 echo '<script language="JavaScript">window.close();</script>';
    }  
  }
?>
</form>
</html>
