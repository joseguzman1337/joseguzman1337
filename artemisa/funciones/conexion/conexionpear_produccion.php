<?php
//error_reporting(2047);
ini_set("include_path", ".:/home/desarrollo2/paginas/funciones/pear/share/pear/");
//echo ini_get('include_path');
require_once ('PEAR.php');
require_once ('DB.php');
require_once ('DB/DataObject.php');

$options = &PEAR::getStaticProperty('DB_DataObject','options');

  $options = array(
    'database'         => 'mysql://emerson:kilo999@200.31.79.227/sala',
    'schema_location'  => '/home/desarrollo2/paginas/funciones/DataObjects',
    'class_location'   => '/home/desarrollo2/paginas/funciones/DataObjects',
    'require_prefix'   => '/home/desarrollo2/paginas/funciones/DataObjects',
    'class_prefix'     => 'DataObjects_',
);
/*
  $options = array(
    'database'         => 'mysql://root:@localhost/sala',
    'schema_location'  => '/home/desarrollo2/paginas/funciones/DataObjects',
    'class_location'   => '/home/desarrollo2/paginas/funciones/DataObjects',
    'require_prefix'   => '/home/desarrollo2/paginas/funciones/DataObjects',
    'class_prefix'     => 'DataObjects_',
);
*/
//print_r($options);

PEAR::setErrorHandling(PEAR_ERROR_CALLBACK, 'error_handler');
function error_handler(&$obj) 
{
	$msg = $obj->getMessage();
	$code = $obj->getCode();
	$info = $obj->getUserInfo();
	echo $msg,' ',$code,"<br>";
	if ($info) 
	{
		print htmlspecialchars($info);
	} 
}

//if(class_exists(DB)){echo "DB";}
//if(class_exists(PEAR)){echo "PEAR";}
//if(class_exists(DB_DataObject)){echo "DB_DataObject";}

/*DB*********************************************************************************/

 /*$dsn = array(
    'phptype'  => 'mysql',
    'username' => 'root',
    'password' => '',
    'hostspec' => 'localhost',
    'database' => 'sala',
); 

*/
    $dsn = array(
    'phptype'  => 'mysql',
    'username' => 'emerson',
    'password' => 'kilo999',
    'hostspec' => '200.31.79.227',
    'database' => 'sala',
);

$opciones = array(
    'debug'       => 2,
    'portability' => DB_PORTABILITY_ALL,
);

$sala =& DB::connect($dsn, $opciones);
$sala->setFetchMode(DB_FETCHMODE_ASSOC);
if (PEAR::isError($sala)) {
    die($sala->getMessage());
}
?>
