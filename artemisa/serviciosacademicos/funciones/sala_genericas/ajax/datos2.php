<?

//Creo el objeto $json para codificar datos mas adelante
require_once('JSON.php');
$json = new Services_JSON();


$link = mysql_connect('localhost', 'root', '');

mysql_select_db('sala');

$query = 'SELECT nombrecarrera, codigocarrera FROM carrera';
$result = mysql_query($query) ;

$datos = array();

//lleno el array $datos con el resultado de la consulta a MySQL:
while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
   $datos[]=$line;
}

print $json->encode($datos);

mysql_free_result($result);
mysql_close($link);
?>
