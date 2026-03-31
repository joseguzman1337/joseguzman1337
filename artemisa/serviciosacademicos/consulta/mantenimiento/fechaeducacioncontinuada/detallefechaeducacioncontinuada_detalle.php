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
require_once(realpath(dirname(__FILE__)).'/../funciones/gui/campotexto_valida_post_bd.php');
require_once(realpath(dirname(__FILE__)).'/calendario/calendario.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/arreglarfecha.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/validaciones/validaciongenerica.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/validaciones/validardosfechas.php');


//DB_DataObject::debugLevel(5);

$config = parse_ini_file('../funciones/conexion/basedatos.ini',TRUE);
foreach($config as $class=>$values) {
	$options = &PEAR::getStaticProperty($class,'options');
	$options = $values;
}
$validaciongeneral=true;	
$mensajegeneral='Los campos marcados con *, no han sido correctamente diligenciados\n';
?>
<?php
$detallefechaeducacioncontinuada=DB_DataObject::factory('detallefechaeducacioncontinuada');
$detallefechaeducacioncontinuada->get('iddetallefechaeducacioncontinuada',$_GET['iddetallefechaeducacioncontinuada']);
$anteriordetallefechaeducacioncontinuada=$_GET['iddetallefechaeducacioncontinuada']-1;
//print_r($detallefechaeducacioncontinuada);
$query_ultimo_detallefechaeducacioncontinuada="select iddetallefechaeducacioncontinuada from detallefechaeducacioncontinuada where idfechaeducacioncontinuada='".$anteriordetallefechaeducacioncontinuada."'";
//echo $query_ultimo_detallefechaeducacioncontinuada;
$ultimo_detallefechaeducacioncontinuada=$sala->query($query_ultimo_detallefechaeducacioncontinuada);
$row_ultimodetallefechaeducacioncontinuada=$ultimo_detallefechaeducacioncontinuada->fetchRow();
$consultadetallefechaeducacioncontinuada=DB_DataObject::factory('detallefechaeducacioncontinuada');
$consultadetallefechaeducacioncontinuada->get('iddetallefechaeducacioncontinuada',$row_ultimodetallefechaeducacioncontinuada['iddetallefechaeducacioncontinuada']);
//print_r($consultadetallefechaeducacioncontinuada);
//echo $detallefechaeducacioncontinuada->fechadetallefechaeducacioncontinuada;

?>
<form name="form1" method="post" action="">
  <p align="center" class="Estilo2">FECHA EDUCACION CONTINUADA - DETALLE - EDITAR</p>
  <table width="100%" border="1" align="center" bordercolor="#000000">
    <tr>
      <td><table width="100%" border="0" align="center" cellpadding="2" cellspacing="2">
        <tr bgcolor="#CCDADD" class="Estilo2">
          <td bgcolor="#CCDADD"><div align="center">Fecha</div></td>
          <td bgcolor="#FEF7ED"><span class="phpmaker"><span class="style2"><span class="Estilo5">
            <?php escribe_formulario_fecha_vacio("fechadetallefechaeducacioncontinuada","form1","",$detallefechaeducacioncontinuada->fechadetallefechaeducacioncontinuada);
				  $validacion['fechadetallefechaeducacioncontinuada']=validaciongenerica($_POST['fechadetallefechaeducacioncontinuada'], "requerido", "Fecha detalle");
				  $fechadetallefechaeducacioncontinuada=arreglarfecha($_POST['fechadetallefechaeducacioncontinuada']);
				  //echo $fechadetallefechaeducacioncontinuada;echo $consultadetallefechaeducacioncontinuada->fechadetallefechaeducacioncontinuada;
				  if($_POST['fechadetallefechaeducacioncontinuada']!=$detallefechaeducacioncontinuada->fechadetallefechaeducacioncontinuada){
					  if($fechadetallefechaeducacioncontinuada <= $consultadetallefechaeducacioncontinuada->fechadetallefechaeducacioncontinuada)
						  {
								//echo "<style type='text/css'><!--.Estilo99{font-size: 18px;color: #FF0000;}--></style>";
								//echo "<span class='Estilo99'>*</span>";
								$valido['mensaje']="La fecha seleccionada, se cruza con fechas anteriores";
								$valido['valido'] = 0;
								$validacion['fechamayordetallefecuaeducacioncontinuada']=$valido;
						  }
				 }
		  ?>
          </span></span></span></td>
        </tr>
        <tr bgcolor="#CCDADD" class="Estilo2">
          <td bgcolor="#CCDADD"><div align="center">N&uacute;mero</div></td>
          <td bgcolor="#FEF7ED"><?php $validacion['numerodetallefechaeducacioncontinuada']=campotexto_valida_post_bd("numerodetallefechaeducacioncontinuada","requerido","N&uacute;mero","10","detallefechaeducacioncontinuada","iddetallefechaeducacioncontinuada",$_GET['iddetallefechaeducacioncontinuada'],"numerodetallefechaeducacioncontinuada")?></td>
        </tr>
        <tr bgcolor="#CCDADD" class="Estilo2">
          <td bgcolor="#CCDADD"><div align="center">Nombre</div></td>
          <td bgcolor="#FEF7ED"><?php $validacion['nombredetallefechaeducacioncontinuada']=campotexto_valida_post_bd("nombredetallefechaeducacioncontinuada","requerido","Nombre","10","detallefechaeducacioncontinuada","iddetallefechaeducacioncontinuada",$_GET['iddetallefechaeducacioncontinuada'],"nombredetallefechaeducacioncontinuada")?></td>
        </tr>
        <tr bgcolor="#CCDADD" class="Estilo2">
          <td bgcolor="#CCDADD"><div align="center">Porcentaje</div></td>
          <td bgcolor="#FEF7ED"><?php $validacion['porcentajedetallefechaeducacioncontinuada']=campotexto_valida_post_bd("porcentajedetallefechaeducacioncontinuada","porcentaje","Porcentaje","10","detallefechaeducacioncontinuada","iddetallefechaeducacioncontinuada",$_GET['iddetallefechaeducacioncontinuada'],"porcentajedetallefechaeducacioncontinuada")?></td>
        </tr>
        <tr bgcolor="#CCDADD" class="Estilo2">
          <td colspan="2"><div align="center">
            <input name="Enviar" type="submit" id="Enviar" value="Enviar">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input name="Regresar" type="submit" id="Regresar" value="Regresar">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input name="Eliminar" type="submit" id="Eliminar" value="Eliminar">
</div></td>
          </tr>
      </table></td>
    </tr>
  </table>
</form>
<?php
if(isset($_POST['Regresar']))
{
	echo '<script language="javascript">window.close();</script>';
	echo '<script language="javascript">window.opener.recargar();</script>';
}
?>
<?php
if(isset($_POST['Eliminar']))
{
	$eliminar=$detallefechaeducacioncontinuada->delete();
	if($eliminar)
	{
		echo "<script language='javascript'>alert('Datos eliminados correctamente');</script>";
		echo '<script language="javascript">window.close();</script>';
		echo '<script language="javascript">window.opener.recargar();</script>';
	}
}
?>
<?php
if(isset($_POST['Enviar']))
{
	foreach ($validacion as $key => $valor){if($valor['valido']==0){$mensajegeneral=$mensajegeneral.'\n'.$valor['mensaje'];$validaciongeneral=false;}}
	if($validaciongeneral==true){
		$detallefechaeducacioncontinuada->numerodetallefechaeducacioncontinuada=$_POST['numerodetallefechaeducacioncontinuada'];
		$detallefechaeducacioncontinuada->nombredetallefechaeducacioncontinuada=$_POST['nombredetallefechaeducacioncontinuada'];
		$detallefechaeducacioncontinuada->porcentajedetallefechaeducacioncontinuada=$_POST['porcentajedetallefechaeducacioncontinuada'];
		$detallefechaeducacioncontinuada->fechadetallefechaeducacioncontinuada=$_POST['fechadetallefechaeducacioncontinuada'];
		$actualizar=$detallefechaeducacioncontinuada->update();
		if($actualizar)
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
