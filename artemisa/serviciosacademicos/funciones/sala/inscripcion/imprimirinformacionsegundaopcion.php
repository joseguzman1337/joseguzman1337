<?php$codigoinscripcion = $_SESSION['numerodocumentosesion']; $fecha = date("Y-m-d G:i:s",time());

$query_data = "SELECT eg.*,c.nombrecarrera,m.nombremodalidadacademica,ci.nombreciudad,m.codigomodalidadacademica,i.idinscripcion,c.codigocarrera
FROM estudiantegeneral eg,inscripcion i,estudiantecarrerainscripcion e,carrera c,modalidadacademica m,ciudad ci
WHERE numerodocumento = '".$this->estudiantegeneral->numerodocumento."'
AND eg.idestudiantegeneral = i.idestudiantegeneral
AND eg.idciudadnacimiento = ci.idciudad
AND i.idinscripcion = e.idinscripcion
AND e.codigocarrera = c.codigocarrera
AND m.codigomodalidadacademica = i.codigomodalidadacademica 
AND e.idnumeroopcion = '1'
and i.codigoestado like '1%'
and i.idinscripcion = '".$this->idinscripcion."'"; 
$data = $db->Execute($query_data);
$totalRows_data = $data->RecordCount();
$row_data = $data->FetchRow();
$query_car = "SELECT nombrecarrera,codigocarrera 
FROM carrera 
where codigomodalidadacademica = '".$this->codigomodalidadacademica."'
AND fechavencimientocarrera > '".$fecha."'
and codigocarrera <> '".$row_data['codigocarrera']."'
order by 1";		//echo $query_car;//exit();$car = $db->Execute($query_car);$totalRows_car = $car->RecordCount();$row_car = $car->FetchRow();
// vista previa	   $query_periodo = "select * 
from periodo p,carreraperiodo cwhere p.codigoperiodo = c.codigoperiodoand c.codigocarrera = '".$row_data['codigocarrera']."'and p.codigoestadoperiodo like '1' order by p.codigoperiodo";$periodo = $db->Execute($query_periodo);$totalRows_periodo = $periodo->RecordCount();$row_periodo = $periodo->FetchRow();
$query_datosgrabados = "SELECT idnumeroopcion, c.nombrecarrera, m.nombremodalidadacademica, c.codigocarrera,
e.idinscripcion , e.idestudiantecarrerainscripcionFROM estudiantecarrerainscripcion e,carrera c,modalidadacademica mWHERE e.idestudiantegeneral = '".$this->estudiantegeneral->idestudiantegeneral."'and m.codigomodalidadacademica = c.codigomodalidadacademica								and e.codigocarrera = c.codigocarreraand e.codigoestado like '1%'and e.idinscripcion = '".$this->idinscripcion."'order by idnumeroopcion";			  //echo $query_data; $datosgrabados = $db->Execute($query_datosgrabados);$totalRows_datosgrabados = $datosgrabados->RecordCount();$row_datosgrabados = $datosgrabados->FetchRow();
$row_datosgrabados = $datosgrabados->FetchRow();
if ($row_datosgrabados <> ""){ 
?>			   <table width="670px" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">                <tr id="trtitulogris">					<td>Opción</td>					<td>Carrera</td>					                   <td>Modalidad</td>                </tr><?php 			    	do
	{ 
?>			        <tr>                     <td><?php echo $row_datosgrabados['idnumeroopcion'] - 1;?></td>					 <td><?php echo $row_datosgrabados['nombrecarrera'];?></td>                      <td><?php echo $row_datosgrabados['nombremodalidadacademica'];?></td>		         </tr>			   <?php  	}
	while($row_datosgrabados = $datosgrabados->FetchRow());?>    </table> <?php}else if(!isset($_POST['inicial']) && !isset($_GET['inicial'])) {		   ?><!-- <tr><td>Sin datos diligenciados</td></tr> --><?php}	     	      //if(isset($_POST['inicial']) or isset($_GET['inicial'])) ?>