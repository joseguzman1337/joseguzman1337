<?php$codigoinscripcion = $_SESSION['numerodocumentosesion']; 	//$db->debug = true;

$query_datosgrabados1 = "select e.presentadoestudianteotrauniversidad, e.presentadoestudianteuniversidad
from estudianteotrauniversidad e
where e.idestudiantegeneral = '".$this->estudiantegeneral->idestudiantegeneral."'
and e.codigoestado like '1%'
and e.idinscripcion = '".$this->idinscripcion."'";			  
//echo $query_data; 
$datosgrabados1 = $db->Execute($query_datosgrabados1);
$totalRows_datosgrabados1 = $datosgrabados1->RecordCount();
$row_datosgrabados1 = $datosgrabados1->FetchRow();  

$query_datosgrabados = "SELECT e.institucioneducativaestudianteuniversidad, e.programaacademicoestudianteuniversidad,
e.anoestudianteuniversidad, e.idestudianteuniversidad FROM estudianteuniversidad eWHERE e.idestudiantegeneral = '".$this->estudiantegeneral->idestudiantegeneral."'								 						 and e.codigoestado like '1%'
and e.idinscripcion = '".$this->idinscripcion."'order by anoestudianteuniversidad";			  //echo $query_data; $datosgrabados = $db->Execute($query_datosgrabados);
$totalRows_datosgrabados = $datosgrabados->RecordCount();
$row_datosgrabados = $datosgrabados->FetchRow();  	      if ($row_datosgrabados <> ""){ 
?>		     <table width="670px" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
                 <tr id="trtitulogris">					<td>Institución</td>					<td>Programa</td>					<td>Año</td>                </tr>		       <?php 			     do{ ?>			        <tr>                     <td><?php echo $row_datosgrabados['institucioneducativaestudianteuniversidad'];?>&nbsp;</td>					 <td><?php echo $row_datosgrabados['programaacademicoestudianteuniversidad'];?>&nbsp;</td>                     <td><?php echo $row_datosgrabados['anoestudianteuniversidad'];?>&nbsp;</td>					 				 </tr>			   			    <?php  				  }while($row_datosgrabados = $datosgrabados->FetchRow());			   ?>	  </table> 		   <?php}
$muestraalgo = 'style="display:none"';
if($row_datosgrabados1['presentadoestudianteotrauniversidad'] == "Si")
{
	$seleccionadoSi = " checked";
	$muestraalgo = 'style="display:"';
}
if($row_datosgrabados1['presentadoestudianteotrauniversidad'] == "No")
	$seleccionadoNo = " checked";
if($row_datosgrabados1['presentadoestudianteuniversidad'] == "Si")
	$seleccionado2Si = " checked";
if($row_datosgrabados1['presentadoestudianteuniversidad'] == "No")
	$seleccionado2No = " checked";
	
//echo "asdasd $seleccionado2Si $seleccionado2No";
?>
	<table width="670px" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
		<tr>
		<td id="tdtitulogris">¿Es la primera vez que se presenta a esta universidad? *</td>
		<td>Si <input type="radio" name="presentadoestudianteuniversidad" value="Si" <?php echo $seleccionado2Si; ?>> 
		No <input type="radio" name="presentadoestudianteuniversidad" value="No" <?php echo $seleccionado2No; ?>> </td>
		</tr>
		<tr>
		<td id="tdtitulogris">¿Se ha presentado a otras universidades? *</td>
		<td>Si <input type="radio" name="presentadoestudianteotrauniversidad" value="Si" onClick="tablaotrasu.style.display=''" <?php echo $seleccionadoSi; ?>> 
		No <input type="radio" name="presentadoestudianteotrauniversidad" value="No" onClick="tablaotrasu.style.display='none'" <?php echo $seleccionadoNo; ?>> </td>
		</tr>
	</table>
