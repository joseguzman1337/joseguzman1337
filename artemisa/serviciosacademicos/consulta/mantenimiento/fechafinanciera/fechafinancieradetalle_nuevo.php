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
$detallefechafinanciera=DB_DataObject::factory('detallefechafinanciera');
$query_ultimo_detallefechanciera="SELECT MAX(dff.iddetallefechafinanciera) as iddetallefechafinanciera FROM detallefechafinanciera dff,fechafinanciera ff WHERE
ff.codigocarrera='".$_GET['codigocarrera']."' and ff.codigoperiodo = '".$_GET['codigoperiodo']."' AND
ff.idfechafinanciera=dff.idfechafinanciera";
$ultimo_detallefechanciera=$sala->query($query_ultimo_detallefechanciera);
$row_ultimo_detallefechanciera=$ultimo_detallefechanciera->fetchRow();
$consultadetallefechafinanciera=DB_DataObject::factory('detallefechafinanciera');
$consultadetallefechafinanciera->get('iddetallefechafinanciera',$row_ultimo_detallefechanciera['iddetallefechafinanciera']);

?>
<p align="center" class="Estilo3">FECHA FINANCIERA - AGREGAR DETALLE </p>
<form name="form1" method="post" action="">
<table width="100%"  border="1" align="center" bordercolor="#000000">
  <tr>
    <td><table width="100%" height="100%" border="0" align="center" cellpadding="2">
      <tr>
        <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Fecha detalle </div></td>
        <td bgcolor="#FEF7ED"><span class="phpmaker"><span class="style2"><span class="Estilo5">
          <?php escribe_formulario_fecha_vacio("fechadetallefechafinanciera","form1","",$_POST['fechadetallefechafinanciera']);
				  $validacion['fechadetallefechafinanciera']=validaciongenerica($_POST['fechadetallefechafinanciera'], "requerido", "Fecha detalle");
				  $fechadetallefechafinanciera=arreglarfecha($_POST['fechadetallefechafinanciera']);
				  if($fechadetallefechafinanciera < $consultadetallefechafinanciera->fechadetallefechafinanciera)
				  {
						echo "<style type='text/css'><!--.Estilo99{font-size: 18px;color: #FF0000;}--></style>";
						echo "<span class='Estilo99'>*</span>";
						$valido['mensaje']="La fecha detalle seleccionada, se cruza con fechas anteriores";
						$valido['valido'] = 0;
						$validacion['fechamayordetallefinanciera']=$valido;
				  }
		  ?>
          </span></span></span>
            <div align="left"></div></td>
      </tr>
      <tr>
        <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Concepto</div></td>
        <td bgcolor="#FEF7ED"><?php $validacion['codigoconceptodetallefechafinanciera']=combo_valida_post("codigoconceptodetallefechafinanciera","conceptodetallefechafinanciera","codigoconceptodetallefechafinanciera","nombreoconceptodetallefechafinanciera","","","","si","Concepto")?></td>
      </tr>
      <tr>
        <td bgcolor="#CCDADD" class="Estilo2"><div align="center">N&uacute;mero detalle</div></td>
        <td bgcolor="#FEF7ED"><?php $validacion['numerodetallefechafinanciera']=campotexto_valida_post("numerodetallefechafinanciera","numero","Número detalle","10")?>
            <div align="left"></div></td>
      </tr>
      <tr>
        <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Nombre detalle</div></td>
        <td bgcolor="#FEF7ED"><?php $validacion['nombredetallefechafinanciera']=campotexto_valida_post("nombredetallefechafinanciera","requerido","Nombre detalle","10")?>
            <div align="left"></div></td>
      </tr>
      <tr>
        <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Porcentaje</div></td>
        <td bgcolor="#FEF7ED"><?php $validacion['porcentajedetallefechafinanciera']=campotexto_valida_post("porcentajedetallefechafinanciera","requerido","Porcentaje","5","detallefechafinanciera","iddetallefechafinanciera",$_GET['iddetallefechafinanciera'],"porcentajedetallefechafinanciera");
							    $validacion['porcentaje_porcentajedetallefechafinanciera']=validarporcentaje($_POST['porcentajedetallefechafinanciera'], "decimal","No ha digitado correctamente el porcentaje");?>
            <div align="left"></div></td>
      </tr>
      <tr>
        <td colspan="2" bgcolor="#CCDADD" class="Estilo2"><div align="center">
            <input name="Enviar" type="submit" id="Enviar" value="Enviar">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input name="Regresar" type="submit" id="Regresar" value="Regresar">
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
		$detallefechafinanciera->idfechafinanciera=$_GET['idfechafinanciera'];
		$detallefechafinanciera->numerodetallefechafinanciera=$_POST['numerodetallefechafinanciera'];
		$detallefechafinanciera->nombredetallefechafinanciera=$_POST['nombredetallefechafinanciera'];
		$detallefechafinanciera->fechadetallefechafinanciera=$_POST['fechadetallefechafinanciera'];
		$detallefechafinanciera->porcentajedetallefechafinanciera=$_POST['porcentajedetallefechafinanciera'];
		$detallefechafinanciera->codigoconceptodetallefechafinanciera=$_POST['codigoconceptodetallefechafinanciera'];
		//print_r($detallefechafinanciera);
		//print_r($_POST);
		$insertar=$detallefechafinanciera->insert();
		if($insertar)
		{
			echo "<script language='javascript'>alert('Datos insertados correctamente');</script>";
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

<?php
if(isset($_POST['Regresar']))
{
	echo '<script language="javascript">window.close();</script>';
	echo '<script language="javascript">window.opener.recargar();</script>';
}
?>