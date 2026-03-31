<?php 
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
?>
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

//print_r($_POST);
//echo ini_get('include_path');
ini_set("include_path", ".:/usr/share/pear_");
//error_reporting(2048);
//@session_start();
require_once(realpath(dirname(__FILE__)).'/../../../funciones/clases/autenticacion/redirect.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/validacion.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/conexion/conexion.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/pear/PEAR.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/pear/DB.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/pear/DB/DataObject.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/gui/combo_valida_post.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/gui/campotexto_valida_post.php');
require_once(realpath(dirname(__FILE__)).'/calendario/calendario.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/validaciones/validarporcentaje.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/validaciones/validaciongenerica.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/validaciones/validardosfechas.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/arreglarfecha.php');

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
$fechahoy=date("Y-m-d H:i:s");
$fechafinanciera=DB_DataObject::factory('fechafinanciera');
$periodo=DB_DataObject::factory('periodo');
$carreraperiodo=DB_DataObject::factory('carreraperiodo');
$subperiodo=DB_DataObject::factory('subperiodo');
$query_sel_carrera="select c.codigocarrera,c.nombrecarrera from carrera c where c.codigomodalidadacademica='".$_GET['codigomodalidadacademica']."' and fechainiciocarrera <= '".$fechahoy."' and fechavencimientocarrera >= '".$fechahoy."' order by c.nombrecarrera asc";
$sel_carrera=$sala->query($query_sel_carrera);

$carreraperiodo->whereADD("codigocarrera='".$_POST['codigocarrera']."' and codigoperiodo='".$_GET['codigoperiodo']."'");
$carreraperiodo->get('','*');
//DB_DataObject::debugLevel(5);
$subperiodo->whereADD("idcarreraperiodo='".$carreraperiodo->idcarreraperiodo."'");
$subperiodo->get('','*');
//print_r($subperiodo);
?>

<form name="form1" method="post" action="">
  <table width="100%"  border="1" bordercolor="#000000">
    <tr>
      <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="2">
        <tr>
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Carrera</div></td>
          <td bgcolor="#FEF7ED"><select name="codigocarrera" onChange="enviar()">
            <option value="">Seleccionar</option>
            <?php  while($row_sel_carrera=$sel_carrera->fetchRow()) {?>
            <option value="<?php echo $row_sel_carrera['codigocarrera']?>" <?php if($row_sel_carrera['codigocarrera']==$_POST['codigocarrera']){echo "selected";}?>><?php echo $row_sel_carrera['nombrecarrera']?></option>
            <?php }?>
          </select>
            <?php $validacion['codigocarrera']=validaciongenerica($_POST['codigocarrera'],"requerido","Carrera");?>
          </tr>
        <tr>
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Subperiodo</div></td>
          <td bgcolor="#FEF7ED"><select name="idsubperiodo" onChange="enviar()">
            <option value="">Seleccionar</option>
            <?php  do {?>
            <option value="<?php echo $subperiodo->idsubperiodo?>" <?php if($subperiodo->idsubperiodo==$_POST['idsubperiodo']){echo "selected";}?>><?php echo $subperiodo->nombresubperiodo?></option>
            <?php }while($subperiodo->fetch())?>
          </select>
            <?php $validacion['codigocarrera']=validaciongenerica($_POST['codigocarrera'],"requerido","Carrera");?>
        </tr>
        <tr>
          <td colspan="2" bgcolor="#CCDADD" class="Estilo2">        <div align="center">
            <input name="Enviar" type="submit" id="Enviar" value="Enviar">
          </div></td>
          </tr>
      </table></td>
    </tr>
  </table>
  </form>
<?php
if(isset($_POST['Enviar']))
{
	foreach ($validacion as $key => $valor){if($valor['valido']==0){$mensajegeneral=$mensajegeneral.'\n'.$valor['mensaje'];$validaciongeneral=false;}}
	if($validaciongeneral==true)
	{
		do{
		$fechafinanciera->codigocarrera=$_POST['codigocarrera'];
		$fechafinanciera->codigoperiodo=$_GET['codigoperiodo'];
		$fechafinanciera->codigoestado='100';
		$fechafinanciera->idsubperiodo=$_POST['idsubperiodo'];
		//DB_DataObject::debuglevel(5);
		//print_r($fechafinanciera);
		$insertar=$fechafinanciera->insert();
		//DB_DataObject::debuglevel(0);
		}
		while($subperiodo->fetch());
		if($insertar)
		{
			echo "<script language='javascript'>alert('Datos insertados correctamente');</script>";
			echo '<script language="javascript">window.close();</script>';
			echo '<script language="javascript">window.opener.recargar();</script>';
		}
		else
		{
			echo "<script language='javascript'>alert('Ya hay una fecha financiera, para esta carrera, y para este subperiodo');</script>";
		}
	}
	else
	{
		echo "<script language='javascript'>alert('".$mensajegeneral."');</script>";
	}
}
?>