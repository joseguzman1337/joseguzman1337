<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
.Estilo4 {color: #FF0000}
-->
</style>
<script language="JavaScript" src="calendario/javascripts.js"></script>

<?php
ini_set("include_path", ".:/usr/share/pear_");
require_once('../funciones/validacion.php');
require_once('../../../Connections/sala2.php');
require_once '../funciones/pear/PEAR.php';
require_once '../funciones/pear/DB.php';
require_once '../funciones/pear/DB/DataObject.php';
require_once '../funciones/combo.php';
require_once '../funciones/combo_bd.php';
require_once('calendario/calendario.php');
require_once('../funciones/funcionip.php');
require_once('../funciones/arreglarfecha.php');
require_once('../funciones/conexion/conexion.php');
require_once('../funciones/funcionip.php');
$config = parse_ini_file('../funciones/conexion/basedatos.ini',TRUE);
$config['DB_DataObject']['database']="mysql://".$username_sala.":".$password_sala."@".$hostname_sala."/".$database_sala;
foreach($config as $class=>$values) {
	$options = &PEAR::getStaticProperty($class,'options');
	$options = $values;
}
session_start();
require_once('../../../funciones/clases/autenticacion/redirect.php'); 
/*$autorizaconcepto_detalle = DB_DataObject::factory('autorizaconcepto');
$autorizaconcepto_detalle->get('idautorizaconcepto',$_GET['idautorizaconcepto']);*/

$query_autorizaconcepto_detalle = "SELECT * FROM autorizaconcepto where idautorizaconcepto='".$_GET['idautorizaconcepto']."'"; 
$autorizaconcepto_detalle = $sala->query($query_autorizaconcepto_detalle);
$row_autorizaconcepto_detalle = $autorizaconcepto_detalle->fetchRow();


//print_r($autorizaconcepto_detalle);
$fechaautorizaconcepto=date("Y-m-d H:i:s");
$fechahoy=date("Y-m-d");
$ip=tomarip();
$usuario_sesion=$_SESSION['MM_Username'];

$query_usuario = "SELECT * FROM usuario where usuario='$usuario_sesion'";
$sel_usuario = $sala->query($query_usuario);
$row_usuario = $sel_usuario->fetchRow();
$usuario=$row_usuario['usuario'];

/*
$usuario= DB_DataObject::factory('usuario');
$usuario->get('usuario',$usuario_sesion);
//echo "<h1>",$usuario->idusuario,"</h1>";
//print_r($usuario);
*/

$query_tipousuario = "SELECT * from usuariofacultad where usuario = '".$usuario."'";
$tipousuario = $sala->query($query_tipousuario);
$row_tipousuario = $tipousuario->fetchRow();
$totalRows_tipousuario=$tipousuario->numRows();

$query_muestra_conceptos="SELECT distinct c.codigoconcepto, c.nombreconcepto FROM concepto c, autorizacionreferenciaconcepto arc, referenciaconcepto rc
WHERE
c.codigoreferenciaconcepto=rc.codigoreferenciaconcepto AND
rc.codigoautorizacionreferenciaconcepto=100 and c.codigoconcepto IN (SELECT c.codigoconcepto FROM autorizaconcepto ac, concepto c
WHERE 
ac.codigoestudiante='".$row_dataestudiante['codigoestudiante']."' AND
c.codigoconcepto=ac.codigoconcepto AND 
'$fechahoy' <= ac.fechavencimientoautorizaconcepto)";
//DB_DataObject::debugLevel(5);
$muestraconcepto=$sala->query($query_muestra_conceptos);
//DB_DataObject::debugLevel(0);
$row_muestraconcepto=$muestraconcepto->fetchRow();

?>



<form name="form1" method="post" action="">

<table width="600" border="2" align="center" cellpadding="2" bordercolor="#003333">
  <tr>
    <td><table width="600" border="0" align="center" cellpadding="0" bordercolor="#003333">
        <tr>
          <td colspan="4" bgcolor="#C5D5D6" class="Estilo2"><div align="center">MODIFICAR CONCEPTO </div></td>
        </tr>
        <tr>
          <td bgcolor="#C5D5D6" class="Estilo2"><div align="center">Fecha vencimiento concepto<span class="Estilo4">*</span> </div></td>
          <td class="Estilo1"><div align="center"><span class="phpmaker"><span class="style2"> <span class="Estilo2">
              <?php escribe_formulario_fecha_vacio("fechavencimientoautorizaconcepto","form1","",$row_autorizaconcepto_detalle['fechavencimientoautorizaconcepto']); ?>
          </span> </span></span> </div></td>
          <td bgcolor="#C5D5D6" class="Estilo2"><div align="center">Concepto<span class="Estilo4">*</span></div></td>
          <td bgcolor="#FFFFFF" class="Estilo2"><span class="phpmaker"><span class="style2"><?php echo $_GET['nombreconcepto']?></span></span></td>
        </tr>
        <tr>
          <td bgcolor="#C5D5D6" class="Estilo2"><div align="center">Observaci&oacute;n<span class="Estilo4">*</span></div></td>
          <td colspan="3" bgcolor="#FFFFFF" class="Estilo2"><input name="observacionautorizaconcepto" type="text" id="observacionautorizaconcepto" size="60" value="<?php echo $row_autorizaconcepto_detalle['observacionautorizaconcepto']; ?>"></td>
        </tr>
	<input type="hidden" name="codigoconcepto" value="<?php echo $row_autorizaconcepto_detalle['codigoconcepto']; ?>">
        <tr>
          <td colspan="4" bgcolor="#C5D5D6" class="Estilo2"><div align="center">
              <input name="Modificar" type="submit" id="Modificar" value="Modificar">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input name="Anular" type="submit" id="Anular" value="Anular">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <input name="Regresar" type="submit" id="Regresar" value="Regresar">
          </div></td>
        </tr>
    </table></td>
  </tr>
</table>

</form>
<?php

if(isset($_POST['Modificar']))
{



	$validaciongeneral=true;
	if($_SESSION['MM_Username']=="")
	{
		$validaciongeneral=false;
		echo '<script language="JavaScript">alert("No hay una sesión activa, no se puede ingresar datos")</script>';

	}
	$validacion['req_fechavencimientoconcepto']=validar($_POST['fechavencimientoautorizaconcepto'],"requerido",'<script language="JavaScript">alert("No seleccionado la fecha de vencimiento del concepto")</script>', true);
	
	$validacion['req_observacionautorizaconcepto']=validar($_POST['observacionautorizaconcepto'],"requerido",'<script language="JavaScript">alert("No digitado la observación")</script>', true);

	foreach ($validacion as $key => $valor)
	{
		//echo $valor;
		if($valor==0)
		{
			$validaciongeneral=false;
		}
	}
	
	if($validaciongeneral==true){

	$query_anula = "update autorizaconcepto set fechaautorizaconcepto='$fechaautorizaconcepto',fechavencimientoautorizaconcepto='".$_POST['fechavencimientoautorizaconcepto']."'
                ,idusuario='1'
                ,ip='$ip'
		,codigoestudiante='".$_GET['codigoestudiante']."'
		,codigoconcepto='".$_POST['codigoconcepto']."'
		,observacionautorizaconcepto='".$_POST['observacionautorizaconcepto']."'
                where idautorizaconcepto='".$_GET['idautorizaconcepto']."'"; 
                $sel_anula = $sala->query($query_anula);


	/*$autorizaconcepto_detalle->fechaautorizaconcepto=$fechaautorizaconcepto;
	$autorizaconcepto_detalle->fechavencimientoautorizaconcepto=$_POST['fechavencimientoautorizaconcepto'];
	$autorizaconcepto_detalle->idusuario='1';//$usuario->idusuario;
	$autorizaconcepto_detalle->ip=$ip;
	$autorizaconcepto_detalle->codigoestudiante=$row_dataestudiante['codigoestudiante'];
	$autorizaconcepto_detalle->codigoconcepto=$_POST['codigoconcepto'];
	$autorizaconcepto_detalle->observacionautorizaconcepto=$_POST['observacionautorizaconcepto'];
	//print_r($autorizaconcepto);
	//DB_DataObject::debugLevel(5);
	$actualizar=$autorizaconcepto_detalle->update();
	//DB_DataObject::debugLevel(0);*/
	if($sel_anula)
		{
			echo '<script language="JavaScript">alert("Autoriza Concepto Modificado Correctamente")</script>';
			echo '<script language="javascript">window.close();</script>';echo '<script language="javascript">window.opener.recargar();</script>';
		}
	
	}
}
?>
 <?php if(isset($_POST['Regresar'])){
			echo '<script language="javascript">window.close();</script>';echo '<script language="javascript">window.opener.recargar();</script>';
 }
?>
<?php
if(isset($_POST['Anular']))
{

	$query_anula = "update autorizaconcepto set fechavencimientoautorizaconcepto='0000-00-00'
               where idautorizaconcepto='".$_GET['idautorizaconcepto']."'"; 
                $sel_anula = $sala->query($query_anula);


	/*$autorizaconcepto_detalle->fechavencimientoautorizaconcepto='0000-00-00';
	
	$actualizar=$autorizaconcepto_detalle->update();*/

	if($sel_anula)
		{
			echo '<script language="JavaScript">alert("Autoriza Concepto Modificado Correctamente")</script>';
			echo '<script language="javascript">window.opener.recargar();</script>';
			echo '<script language="javascript">window.close();</script>';
		}
}
?>
