<?php
mysql_select_db($database_conexion, $conexion);
$query_encuesta = "SELECT e.idencuesta,i.iditemsencuesta,i.nombreitemsencuesta
					FROM encuesta e,detalleencuesta d,itemsencuesta i,carreraencuesta cen
					WHERE e.idencuesta = d.idencuesta
					AND cen.codigocarrera = '".$row['codigocarrera']."'
					AND cen.idencuesta = e.idencuesta
					AND d.iditemsencuesta = i.iditemsencuesta
					AND codigoestadoencuesta LIKE '1%'
					AND codigoestadoitemsencuesta LIKE '1%'
					AND codigotipoitemsencuesta LIKE '1%'
					ORDER BY 2";
$encuesta = mysql_query($query_encuesta, $conexion) or die(mysql_error());
$row_encuesta = mysql_fetch_assoc($encuesta);
$totalRows_encuesta = mysql_num_rows($encuesta);

mysql_select_db($database_conexion, $conexion);
$query_encuesta1 = "SELECT e.idencuesta,i.iditemsencuesta,i.nombreitemsencuesta
					FROM encuesta e,detalleencuesta d,itemsencuesta i,carreraencuesta cen 
					WHERE e.idencuesta = d.idencuesta
					AND cen.codigocarrera = '".$row['codigocarrera']."'
					AND cen.idencuesta = e.idencuesta
					AND d.iditemsencuesta = i.iditemsencuesta
					AND codigoestadoencuesta LIKE '1%'
					AND codigoestadoitemsencuesta LIKE '1%'
					AND codigotipoitemsencuesta LIKE '2%'
					ORDER BY 2";
$encuesta1 = mysql_query($query_encuesta1, $conexion) or die(mysql_error());
$row_encuesta1 = mysql_fetch_assoc($encuesta1);
$totalRows_encuesta1 = mysql_num_rows($encuesta1);

$sql = "insert into respuestaencuesta(numerodocumento,idencuesta,fecharespuestaencuesta)";
$sql.= "VALUES('".$_SESSION['numerodocumento']."','".$row_encuesta['idencuesta']."','".date("Y-m-d G:i:s",time())."')"; 
$result = mysql_query($sql,$conexion);

$numeroid=mysql_insert_id();
$j= 1;
$i=1;
do {
$sql2 = "insert into detallerespuestaencuesta(idrespuestaencuesta,iditemsencuesta,codigovaloracionencuesta)";
$sql2.= "VALUES('".$numeroid."','".$row_encuesta['iditemsencuesta']."','".$_POST['valor'.$j]."')"; 
$result2 = mysql_query($sql2,$conexion);
$j++;
}while($row_encuesta = mysql_fetch_assoc($encuesta));

do {
$sql3 = "insert into detallerespuestaencuesta(idrespuestaencuesta,iditemsencuesta,respuestapreguntaabierta)";
$sql3.= "VALUES('".$numeroid."','".$row_encuesta1['iditemsencuesta']."','".$_POST['respuesta'.$i]."')"; 
echo $sql3;
$result3 = mysql_query($sql3,$conexion);
$i++;
}while($row_encuesta1 = mysql_fetch_assoc($encuesta1));
echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=vistaprevia.php'>";
?>