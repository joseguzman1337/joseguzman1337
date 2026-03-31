<?php
require_once('../../../Connections/sala2.php' );
mysql_select_db($database_sala, $sala);

$query_deudas = "SELECT COUNT(*) AS cuneta,p.codigoestudiante,idplanestudio
FROM planestudioestudiante p
WHERE codigoestadoplanestudioestudiante LIKE '1%'
GROUP by 2
HAVING cuneta >= 2 
ORDER BY 2";	
//echo $query_deudas;
$deudas=mysql_query($query_deudas,$sala);
$totalRows_deudas = mysql_num_rows($deudas);
$row_deudas = mysql_fetch_assoc($deudas);
do{

    $query_error = "select *
	FROM planestudioestudiante
	WHERE codigoestudiante = '".$row_deudas['codigoestudiante']."'
	AND codigoestadoplanestudioestudiante LIKE '1%'";	
	echo "$query_error <br><br><br>";
	$error=mysql_query($query_error,$sala);
	$totalRows_error = mysql_num_rows($error);
    $row_error = mysql_fetch_assoc($error);
    if ($totalRows_error >= 2)
	{
	   do{
	    if ($row_error['idplanestudio'] == 1)
		 {
			$query_nota = "UPDATE planestudioestudiante
			set codigoestadoplanestudioestudiante = 200		
			where idplanestudio = '".$row_error['idplanestudio']."'
			AND codigoestudiante = '".$row_error['codigoestudiante']."'";
			echo "$query_nota <br><br>";
		    $nota=mysql_db_query($database_sala,$query_nota);
	     }
	  }while($row_error = mysql_fetch_assoc($error));
	}  
}while($row_deudas = mysql_fetch_assoc($deudas));



?>