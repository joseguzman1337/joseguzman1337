<?php
require_once '../funciones/pear/DB.php';
require_once '../../../Connections/sala2.php';


$dsn = array(
    'phptype'  => 'mysql',
    'username' => $username_sala,
    'password' => $password_sala,
    'hostspec' => $hostname_sala,
    'database' => $database_sala,
);

$options = array(
    'debug'       => 2,
    'portability' => DB_PORTABILITY_ALL,
);

$sala =& DB::connect($dsn, $options);
$sala->setFetchMode(DB_FETCHMODE_ASSOC);
if (PEAR::isError($db)) {
    die($db->getMessage());
}
?>
