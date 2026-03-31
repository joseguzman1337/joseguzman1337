<?php
//print_r($_GET);
?>
<script language="Javascript">
function abrir(pagina,ventana,parametros) {
	window.open(pagina,ventana,parametros);
}
</script>
<script language="javascript">
function enviar()
{
	document.form1.submit()
}
</script>
<script language="JavaScript" src="../funciones/calendario/javascripts.js"></script><script language="JavaScript" src="../funciones/calendario/javascripts.js"></script>
<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 11px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
.Estilo4 {color: #FF0000}
.Estilo5 {font-family: Tahoma; font-size: 12px}
-->
</style>
<?php
//echo ini_get('include_path');
ini_set("include_path", ".:/usr/share/pear_");
//error_reporting(2048);
require_once('../funciones/validacion.php');
require_once('../funciones/conexion/conexion.php');
require_once('../funciones/pear/PEAR.php');
require_once('../funciones/pear/DB.php');
require_once('../funciones/pear/DB/DataObject.php');
require_once('../funciones/calendario/calendario.php');



//DB_DataObject::debugLevel(5);

$config = parse_ini_file('../funciones/conexion/basedatos.ini',TRUE);
foreach($config as $class=>$values) {
	$options = &PEAR::getStaticProperty($class,'options');
	$options = $values;
}
?>
<?php
$detallesoportetecnico=DB_DataObject::factory('detallesoportetecnico');
$soportetecnico=DB_DataObject::factory('soportetecnico');
$soportetecnico_tabla=$soportetecnico->table();
$soportetecnico_campos=array_keys($soportetecnico_tabla);
print_r($soportetecnico_campos);
?>

<select name="campos">
<?php foreach ($soportetecnico_campos as $nombre){ ?>
<option value="<?php echo $nombre?>"><?php echo $nombre?></option>
<?php } ?>
</select>