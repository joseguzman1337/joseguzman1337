<?php
//$db->debug = true;
$query_idiomaestudiante = "SELECT *
FROM estudiantemediocomunicacion e
WHERE  e.idestudiantegeneral = '".$this->estudiantegeneral->idestudiantegeneral."'
and e.idinscripcion = '".$this->idinscripcion."'
and e.codigoestadoestudiantemediocomunicacion like '1%'
ORDER BY 2";
$idiomaestudiante = $db->Execute($query_idiomaestudiante);
$totalRows_idiomaestudiante = $idiomaestudiante->RecordCount();
$row_idiomaestudiante = $idiomaestudiante->FetchRow();

$sinmediodecomunicacion = "codigomediocomunicacion <> ".$row_idiomaestudiante['codigomediocomunicacion'];
if ($row_idiomaestudiante <> "")
{		
	do
	{
		$sinmediodecomunicacion = $sinmediodecomunicacion ." and codigomediocomunicacion <> ".$row_idiomaestudiante['codigomediocomunicacion'];
		//echo $sinidioma ,"<br>";
	}
	while($row_idiomaestudiante = $idiomaestudiante->FetchRow());
	$query_mediocomunicacion = "select *
	from mediocomunicacion
	where ($sinmediodecomunicacion)
	order by 2";
	$mediocomunicacion = $db->Execute($query_mediocomunicacion);
	$totalRows_mediocomunicacion = $mediocomunicacion->RecordCount();
	$row_mediocomunicacion = $mediocomunicacion->FetchRow();
}
else
{
   	$query_mediocomunicacion = "select *
	from mediocomunicacion
	order by 2";
	$mediocomunicacion = $db->Execute($query_mediocomunicacion);
	$totalRows_mediocomunicacion = $mediocomunicacion->RecordCount();
	$row_mediocomunicacion = $mediocomunicacion->FetchRow();
}

$query_datosgrabados = "SELECT * FROM estudiantemediocomunicacion e,mediocomunicacion mWHERE e.idestudiantegeneral = '".$this->estudiantegeneral->idestudiantegeneral."'
and e.idinscripcion = '".$this->idinscripcion."'and e.codigomediocomunicacion = m.codigomediocomunicacionand e.codigoestadoestudiantemediocomunicacion like '1%'order by nombremediocomunicacion";			  //echo $query_data; $datosgrabados = $db->Execute($query_datosgrabados);$totalRows_datosgrabados = $datosgrabados->RecordCount();$row_datosgrabados = $datosgrabados->FetchRow();if ($row_datosgrabados <> ""){ 
?>			   <table width="670px" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">	                <tr id="trtitulogris">					<td >Medio de comunicaci&oacute;n </td>					<td>Descripción</td>
                </tr><?php 	do
	{ 
?>			        <tr>                     <td><?php echo $row_datosgrabados['nombremediocomunicacion'];?></td>					 <td><?php echo $row_datosgrabados['observacionestudiantemediocomunicacion'];?></td>
                 </tr>			   			    <?php  				  
	}
	while($row_datosgrabados = $datosgrabados->FetchRow());?>	    </table> <?php
}	      ?>