<?php
function validacion_pazysalvo($codigoestudiante,$conexion){

	$query_pazysalvo = "select p.idpazysalvoestudiante, e.codigocarrera
from pazysalvoestudiante p, detallepazysalvoestudiante d, estudiante e
where e.codigoestudiante = '$codigoestudiante'
and p.idpazysalvoestudiante = d.idpazysalvoestudiante
and d.codigoestadopazysalvoestudiante like '1%'
and e.idestudiantegeneral = p.idestudiantegeneral";
	//echo $query_pazysalvo,"<br>";
	$pazysalvo = mysql_query($query_pazysalvo,$conexion) or die (mysql_error());
	$totalRows_pazysalvo = mysql_num_rows($pazysalvo);
	$row_pazysalvo = mysql_fetch_array($pazysalvo);
	if($totalRows_pazysalvo==0)
	{
		$pendientepazysalvo=false;
	}//echo $query_pazysalvo;
	else
	{
		$pendientepazysalvo=true;
	}
	//echo $totalRows_pazysalvo;
	//echo $pendiente;
	return $pendientepazysalvo;
}

?>