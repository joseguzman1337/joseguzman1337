<?php
$rutaado=("../../../funciones/adodb/");
require_once("../../../funciones/clases/debug/SADebug.php");
require_once("../../../funciones/clases/phpmailer/class.phpmailer.php");
require_once("../../../Connections/salaado-pear.php");
require_once("funciones/datos_mail.php");

?>


<?php
$prueba=new ObtenerDatosMail($sala,1,2,true);
$prueba->Construir_correo("castroabraham@unbosque.edu.co","Abraaham");
?>