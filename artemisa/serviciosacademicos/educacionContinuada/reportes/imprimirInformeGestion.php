<?php
/**
 * Caso 522.
 * Ajuste validación de Sesión
 * Se incluye el archivo adaptador para tener acceso a las funciones basicas de
 * del nuevo sala si la aplicacion se corre en un entorno local o de pruebas.
 * @modified Dario Gualteros Castro <castroluisd@unbosque.edu.co>.
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @since 18 de Marzo 2019.
 */
require(realpath(dirname(__FILE__) . "/../../../sala/includes/adaptador.php"));
/**
 * El metodo Factory::validateSession($variables) hace una validacion de session activa en el sistema
 * dependiendo de los parametros que se le envíen, si determina que la session acabo redirige el sistema al login
*/
Factory::validateSession($variables);

header("Content-type: application/x-msdownload");
// el attachment es porque sino en ie no funciona
header("Content-Disposition: attachment; filename=reporte_".date('Y-m-d').".xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7">
<title>Reporte</title>


<style type="text/css">
table
{
 border-collapse: collapse;
    border-spacing: 0;
}
th, td {
border: 1px solid #000000;
    padding: 0.5em;
}
</style>
</head>
<body>
<?php

$tabla = $_POST['datos_a_enviar'];
$tabla = str_replace('\"', "", $tabla);
//$tabla=utf8_decode($tabla);

echo $tabla;
?>
</body>
</html>