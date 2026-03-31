<script language="JavaScript" src="../funciones/calendario/javascripts.js"></script><script language="JavaScript" src="../funciones/calendario/javascripts.js"></script>
<script language="javascript">
	function enviar()
		{
			document.form1.submit();
		}
</script>
<script language="Javascript">
function abrir(pagina,ventana,parametros) {
	window.open(pagina,ventana,parametros);
}
</script>

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
  session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
//print_r($_POST);
//echo ini_get('include_path');
ini_set("include_path", ".:/usr/share/pear_");
//error_reporting(2048);
//@session_start();
require_once(realpath(dirname(__FILE__)).'/../funciones/validacion.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/conexion/conexion.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/pear/PEAR.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/pear/DB.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/pear/DB/DataObject.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/gui/combo_valida_post.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/validaciones/validaciongenerica.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/validaciones/validardosfechas.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/clases/autenticacion/redirect.php');

//DB_DataObject::debugLevel(5);

$config = parse_ini_file('../funciones/conexion/basedatos.ini',TRUE);
$config['DB_DataObject']['database']="mysql://".$username_sala.":".$password_sala."@".$hostname_sala."/".$database_sala;
foreach($config as $class=>$values) {
	$options = &PEAR::getStaticProperty($class,'options');
	$options = $values;
}
$validaciongeneral=true;	
$mensajegeneral='Los campos marcados con *, no han sido correctamente diligenciados\n';
?>
<?php

$cuentabanco=DB_DataObject::factory('cuentabanco');
$cuentabanco->get('','*');
?>
<p align="center" class="Estilo3">CUENTA BANCO - LISTADO </p>
<table width="50%" border="1" align="center" bordercolor="#000000">
  <tr>
    <td><table width="100%" border="0" cellpadding="2" cellspacing="0">
      <tr bgcolor="#CCDADD" class="Estilo2">
        <td><div align="center" class="Estilo2">ID</div></td>
        <td><div align="center">N&uacute;mero de cuenta </div></td>
        <td><div align="center">Periodo</div></td>
        <td><div align="center">Banco</div></td>
        <td><div align="center">Carrera</div></td>
      </tr>
      <?php do{
  $carreracuentabanco = $cuentabanco->getLink('codigocarrera','carrera','codigocarrera');
  //print_r($carreracuentabanco);
  $encontrado = false;
  $ultimo = false;
	do {
			if($ultimo){
					$encontrado = true;		
				}
			if ($carreracuentabanco->codigocarrera==$cuentabanco->codigocarrera){
				$encontrado = true;			
			}
			if(!$encontrado){if(!$carreracuentabanco->fetch()){
					//toca matarlo porque no hay mas filas
					$ultimo = true;		
				}}
	} while (!$encontrado);
  $bancocuentabanco = $cuentabanco->getLink('codigobanco','banco','codigobanco');
  
  $encontrado = false;
  $ultimo = false;
	do {
			if($ultimo){
					$encontrado = true;		
				}
			if ($bancocuentabanco->codigobanco==$cuentabanco->codigobanco){
				$encontrado = true;			
			}
			if(!$encontrado){if(!$bancocuentabanco->fetch()){
					//toca matarlo porque no hay mas filas
					$ultimo = true;		
				}}
	} while (!$encontrado);
  ?>
      <tr class="Estilo1">
        <td><div align="center"><a href="fechafinanciera_detalle.php" onclick="abrir('cuentabanco_detalle.php?idcuentabanco=<?php echo $cuentabanco->idcuentabanco?>','Editardetallecuentabanco','width=750,height=250,top=50,left=50,scrollbars=yes');return false"><?php echo $cuentabanco->idcuentabanco?></a></div></td>
        <td><div align="center"><?php echo $cuentabanco->numerocuentabanco?></div></td>
        <td><div align="center"><?php echo $cuentabanco->codigoperiodo?></div></td>
        <td><div align="center"><?php echo $bancocuentabanco->nombrebanco?></div></td>
        <td><div align="center"><?php echo $carreracuentabanco->nombrecarrera;?></div></td>
      </tr>
        <?php }while ($cuentabanco->fetch()); ?>
      <tr bgcolor="#CCDADD" class="Estilo1">
        <td colspan="5"><div align="center">
          <input name="Nuevo" type="submit" id="Nuevo" value="Nuevo Cuenta Banco" onclick="abrir('cuentabanco_nuevo.php','nuevodetallefechafinanciera','width=750,height=250,top=200,left=150,scrollbars=yes');return false">
        </div></td>
        </tr>

    </table></td>
  </tr>
</table>
<script language="Javascript">
function recargar() 
{ 
	window.location.reload("cuentabanco_listado.php?");
}
</script>