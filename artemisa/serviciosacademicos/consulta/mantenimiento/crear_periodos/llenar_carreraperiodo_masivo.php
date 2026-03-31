<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
//print_r($_POST);
//error_reporting(2047);
ini_set("include_path", ".:/usr/share/pear_");
require_once(realpath(dirname(__FILE__)).'/../funciones/validacion.php');
require_once(realpath(dirname(__FILE__)).'/../../../Connections/sala2.php');
require_once realpath(dirname(__FILE__)).'/../funciones/pear/PEAR.php';
require_once realpath(dirname(__FILE__)).'/../funciones/pear/DB.php';
require_once realpath(dirname(__FILE__)).'/../funciones/pear/DB/DataObject.php';
require_once realpath(dirname(__FILE__)).'/../funciones/combo.php';
//require_once('calendario/calendario.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/funcionip.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/clases/autenticacion/redirect.php');
$fechasubperiodo=date("Y-m-d H:i:s");
$ip=tomarip();

$config = parse_ini_file('../funciones/conexion/basedatos.ini',TRUE);
$config['DB_DataObject']['database']="mysql://".$username_sala.":".$password_sala."@".$hostname_sala."/".$database_sala;
foreach($config as $class=>$values) {
	$options = &PEAR::getStaticProperty($class,'options');
	$options = $values;
}

?>

<?php
	$usuario_sesion=$_SESSION['MM_Username'];
	$usuario = DB_DataObject::factory('usuario');
	$usuario->get('usuario',$usuario_sesion);
	$carrera = DB_DataObject::factory('carrera');
	$carreraperiodo1 = DB_DataObject::factory('carreraperiodo');
	$carreraperiodo2 = DB_DataObject::factory('carreraperiodo');
	$subperiodo1 = DB_DataObject::factory('subperiodo');
	$subperiodo2 = DB_DataObject::factory('subperiodo');

	$carrera->query("select * FROM {$carrera->__table} where modalidadacademica <>'500' ");
	$carrera->get('','*');
	do
	{
		$carreraperiodo1->codigocarrera=$carrera->codigocarrera;
		$carreraperiodo1->codigoperiodo=$periodonuevo1->codigoperiodo;
		$carreraperiodo1->codigoestado='100';
		$carreraperiodo1_insertar=$carreraperiodo1->insert();
		$idcarreraperiodo1=mysql_insert_id();
		//echo "<h1>",$idcarreraperiodo1+1,"</h1>";
		$subperiodo1->idcarreraperiodo=$idcarreraperiodo1;
		$subperiodo1->nombresubperiodo='SUBPERIODO BASE';
		$subperiodo1->fechasubperiodo=$fechasubperiodo;
		$subperiodo1->fechainicioacademicosubperiodo=$_POST['fechainicioprimerperiodo'];
		$subperiodo1->fechafinalacademicosubperiodo=$_POST['fechavencimientoprimerperiodo'];
		$subperiodo1->fechainiciofinancierosubperiodo=$_POST['fechainicioprimerperiodo'];
		$subperiodo1->fechafinalfinancierosubperiodo=$_POST['fechavencimientoprimerperiodo'];
		$subperiodo1->numerosubperiodo='1';
		$subperiodo1->idtiposubperiodo='9';
		$subperiodo1->codigoestadosubperiodo='100';
		$subperiodo1->idusuario=$usuario->idusuario;
		$subperiodo1->ip=$ip;
		//DB_DataObject::debugLevel(5);
		$subperiodo1_insertar=$subperiodo1->insert();
		//DB_DataObject::debugLevel(0);
		
		$carreraperiodo2->codigocarrera=$carrera->codigocarrera;
		$carreraperiodo2->codigoperiodo=$periodonuevo2->codigoperiodo;
		$carreraperiodo2->codigoestado='100';
		$carreraperiodo2_insertar=$carreraperiodo2->insert();
		$idcarreraperiodo2=mysql_insert_id();
 		$subperiodo2->idcarreraperiodo=$idcarreraperiodo2;
		$subperiodo2->nombresubperiodo='SUBPERIODO BASE';
		$subperiodo2->fechasubperiodo=$fechasubperiodo;
		$subperiodo2->fechainicioacademicosubperiodo=$_POST['fechainiciosegundoperiodo'];
		$subperiodo2->fechafinalacademicosubperiodo=$_POST['fechavencimientosegundoperiodo'];
		$subperiodo2->fechainiciofinancierosubperiodo=$_POST['fechainiciosegundoperiodo'];
		$subperiodo2->fechafinalfinancierosubperiodo=$_POST['fechavencimientosegundoperiodo'];
		$subperiodo2->numerosubperiodo='1';
		$subperiodo2->idtiposubperiodo='9';
		$subperiodo2->codigoestadosubperiodo='100';
		$subperiodo2->idusuario=$usuario->idusuario;
		$subperiodo2->ip=$ip;
		//DB_DataObject::debugLevel(5);
		//print_r($subperiodo2);
		$subperiodo2_insertar=$subperiodo2->insert(); 
		//DB_DataObject::debugLevel(0);

		//echo "<h1>",$idcarreraperiodo2+1,"</h1>";
	}
	while ($carrera->fetch());
	
	if($carreraperiodo1_insertar and $carreraperiodo2_insertar)
		{
		  	echo "<script language='javascript'>alert('Periodos y asociaciones de periodos creados a la carrera creados correctamente');</script>";
		  	echo "<script language='javascript'>window.location.reload('menu.php');</script>"; 
		}
?>