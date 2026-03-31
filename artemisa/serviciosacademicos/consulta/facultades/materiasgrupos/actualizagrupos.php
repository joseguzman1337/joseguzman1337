<?php require_once('../../../Connections/sala2.php'); 
      require('../../../funciones/actualizar_grupos.php');
    mysql_select_db($database_sala, $sala);
    $query_periodo = "select p.codigoperiodo, p.nombreperiodo
	from periodo p
	where codigoestadoperiodo = '1'";
	//echo "$query_periodo<br>";
	$periodo = mysql_query($query_periodo, $sala) or die(mysql_error());
	$row_periodo = mysql_fetch_assoc($periodo);
	$totalRows_periodo = mysql_num_rows($periodo);
    
	$query_grupocarrera = "select idgrupo 
	from grupo
	where codigoperiodo = '".$row_periodo['codigoperiodo']."'
	and codigoestadogrupo like '1%'";
	$grupocarrera = mysql_query($query_grupocarrera, $sala) or die(mysql_error());
	$row_grupocarrera = mysql_fetch_assoc($grupocarrera);
	$totalRows_grupocarrera = mysql_num_rows($grupocarrera);

  do{
  
    actualizargrupos($row_grupocarrera['idgrupo'] , $row_periodo['codigoperiodo'] , $sala);
    //actualizargrupos(8958 , 20071 , $sala)
  }while($row_grupocarrera = mysql_fetch_assoc($grupocarrera));
  echo "<h1>Operación Exitosa</h1>";
?>