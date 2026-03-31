<?php
$query_estadoegreso = "select codigoestudiante from estudiante e
where (e.codigosituacioncarreraestudiante='104' or e.codigosituacioncarreraestudiante='400')
and codigoestudiante='$codigoestudiante'";
$estadoegreso = mysql_query($query_estadoegreso,$sala);
$totalRows_estadoegreso = mysql_num_rows($estadoegreso);
$row_estadoegreso = mysql_fetch_array($estadoegreso);
//print_r($row_estadoegreso);
//echo $query_estadoegreso;
?>