<?php //print_r($_POST)?>
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
require_once(realpath(dirname(__FILE__)).'/../funciones/gui/campotexto_valida_post.php');
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
$cuentabanco->get('',$_GET['idcuentabanco']);
?>
<form name="form1" action="" method="post">
<p align="center" class="Estilo3"> CUENTA BANCO - EDITAR </p>
<table width="100%" border="1" align="center" bordercolor="#000000">
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td bgcolor="#CCDADD" class="Estilo2"><div align="center">N&uacute;mero cuenta banco </div></td>
        <td bgcolor="#FEF7ED"><div align="left">
            <?php $validacion['numerocuentabanco']=campotexto_valida_post("numerocuentabanco","requerido","Cuenta Banco","20") ?>
        </div></td>
      </tr>
      <tr>
        <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Periodo</div></td>
        <td bgcolor="#FEF7ED"><?php $validacion['codigoperiodo']=combo_valida_post("codigoperiodo","Periodo","codigoperiodo","codigoperiodo","","","codigoperiodo desc","si","Periodo")?>
	</td>
      </tr>
      <tr>
        <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Banco</div></td>
        <td bgcolor="#FEF7ED"><?php $validacion['codigobanco']=combo_valida_post("codigobanco","banco","codigobanco","nombrebanco","","","","si","Banco")?></td>
      </tr>
      <tr>
        <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Carrera</div></td>
        <td bgcolor="#FEF7ED"><?php $validacion['codigocarrera']=combo_valida_post("codigocarrera","carrera","codigocarrera","nombrecarrera","","","nombrecarrera asc","si","Carrera")?></td>
      </tr>
      <tr bgcolor="#CCDADD">
        <td colspan="2"><div align="center">
          <input name="Enviar" type="submit" id="Enviar" value="Enviar">
		  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <input name="Eliminar" type="submit" id="Eliminar" value="Eliminar">		  
        </div></td>
        </tr>
    </table></td>
  </tr>
</table>
</form>
<?php
if(isset($_POST['Enviar']))
{
	//print_r($validacion['codigobanco']);
	foreach ($validacion as $key => $valor){if($valor['valido']==0){$mensajegeneral=$mensajegeneral.'\n'.$valor['mensaje'];$validaciongeneral=false;}}
	if($validaciongeneral==true)
	{
		$cuentabanco->numerocuentabanco=$_POST['numerocuentabanco'];
		$cuentabanco->codigoperiodo=$_POST['codigoperiodo'];
		$cuentabanco->codigocarrera=$_POST['codigocarrera'];
		$cuentabanco->codigobanco=$_POST['codigobanco'];
		$insertar=$cuentabanco->insert();
		if($insertar)
		{
			echo "<script language='javascript'>alert('Datos modificados correctamente');</script>";
			echo '<script language="javascript">window.close();</script>';
			echo '<script language="javascript">window.opener.recargar();</script>';
		}
	}
	else
	{
		echo "<script language='javascript'>alert('".$mensajegeneral."');</script>";
	}
}
?>
