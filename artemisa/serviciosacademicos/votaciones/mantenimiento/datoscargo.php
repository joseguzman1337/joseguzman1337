<?php 
 session_start();
 $rol=$_SESSION['rol'];
//$_SESSION['MM_Username']='admintecnologia';
//print_r($_SESSION);
$rutaado=("../../funciones/adodb/");
//require_once("../../funciones/clases/debug/SADebug.php");
require_once("../../Connections/salaado-pear.php");
require_once("../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
$objetobase=new BaseDeDatosGeneral($sala);
?>
<?php

//Creo el objeto $json para codificar datos mas adelante
require_once('../../../pruebas/json.php');
$json = new Services_JSON();
$datos = array();

		$query="select * from cargo where codigoestado like '1%' order by idcargo";
		$operacion=$objetobase->conexion->query($query);
		//$this->conexion->SetFetchMode(ADODB_FETCH_NUM);
		while($row_operacion=$operacion->fetchRow()){
		$datos[]=$row_operacion;
		}
/*$link = mysql_connect('localhost', 'root', '');

mysql_select_db('sala');

$query = 'SELECT idcargo FROM cargo order by idcargo';
$result = mysql_query($query) ;

$datos = array();

//lleno el array $datos con el resultado de la consulta a MySQL:
while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
   $datos[]=$line;
}*/

print $json->encode($datos);

//mysql_free_result($result);
//mysql_close($link);
		
		//if($imprimir)
		//echo $query;
		//return $operacion;

//print $json->encode($datos);

?>