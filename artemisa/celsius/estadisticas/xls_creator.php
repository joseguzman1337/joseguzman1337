<?
require_once "../common/includes.php";

/* 
 * Este archivo permitirá exportar consultas a una tabla xsl
 * $Instruccion contiene el query cuyo resultado se almacenará en la BD 
 * $filename contiene al archivo que se creará a partir de la consulta
 * 
*/

$path= Configuracion::getDirectorioTemporal();
if (is_a($path, "File_Exception")){
    		return $path;
}

if (file_exists($path.$filename)) {
	unlink($path.$filename);
}
$filename = "nuevo.xsl";
$Instruccion = "SELECT YEAR(Fecha_Alta_Pedido) AS p, MONTH(Fecha_Alta_Pedido) AS m, COUNT(*) FROM pedhist WHERE YEAR(Fecha_Alta_Pedido)>=2004 AND YEAR(Fecha_Alta_Pedido)<=2004 AND Tipo_Pedido=" . TIPO_PEDIDO__BUSQUEDA . " GROUP BY p,m";

$result = mysql_query($Instruccion);
echo mysql_error();
while ($row = mysql_fetch_array($result)) {
	echo "<br>";
	while (list ($clave, $val) = each($row)) {
		echo $clave . " -> " . $val . "<br>";
	}

} //fin del while
?>