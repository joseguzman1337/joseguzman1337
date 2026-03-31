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
$fechahoy=date("Y-m-d");
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
foreach($config as $class=>$values) {
	$options = &PEAR::getStaticProperty($class,'options');
	$options = $values;
}
$validaciongeneral=true;	
$mensajegeneral='Los campos marcados con *, no han sido correctamente diligenciados\n';
?>
<?php
$fechahoy=date("Y-m-d");
//DB_DataObject::debugLevel(5);
//DB_DataObject::debugLevel(5);
$descuentoestudianteeducacioncontinuada=DB_DataObject::factory('descuentoestudianteeducacioncontinuada');
//$estudiante=DB_DataObject::factory('estudiante');
if(isset($_GET['codigoestudiante']))
{
	$descuentoestudianteeducacioncontinuada->whereAdd("codigoestudiante='".$_GET['codigoestudiante']."'");
}	
$descuentoestudianteeducacioncontinuada->whereAdd("fechahastadescuentoestudianteeducacioncontinuada>='".$fechahoy."'"); //fechadesdedescuentoestudianteeducacioncontinuada<='".$fechahoy."' and 
$descuentoestudianteeducacioncontinuada->get('','*');

?>
<form name="form1" action="" method="get">
<p align="center" class="Estilo3">DESCUENTO ESTUDIANTES EDUCACION CONTINUADA - LISTADO
  <input type="hidden" name="aplicacion" value="<?php echo $_GET['aplicacion']?>">
  <input type="hidden" name="codigoestudiante" value="<?php echo $_GET['codigoestudiante']?>">
</p>

<table width="100%" border="1" align="center" bordercolor="#000000">
  <tr>
    <td><table width="100%" border="0" align="center">
      <tr bgcolor="#CCDADD" class="Estilo2">
        <td><div align="center">ID</div></td>
        <td><div align="center">Fecha</div></td>
        <td><div align="center">Estudiante</div></td>
        <td><div align="center">Documento</div></td>
        <td><div align="center">Descripción</div></td>
        <td><div align="center">Descuento</div></td>
        <td bgcolor="#CCDADD"><div align="center">Porcentaje/valor descuento </div></td>
        <td bgcolor="#CCDADD"><div align="center">Aplica</div></td>
        <td><div align="center">Fecha Desde </div></td>
        <td><div align="center">Fecha Hasta </div></td>
        <td bgcolor="#CCDADD"><div align="center">Directivo autoriza </div></td>
      </tr>
      <?php 
	  if($descuentoestudianteeducacioncontinuada->codigoestudiante!=""){//print_r($descuentoestudianteeducacioncontinuada);
	  do{
		//DB_DataObject::debugLevel(5);
	    $idestudiantegeneral=$descuentoestudianteeducacioncontinuada->getlink('codigoestudiante','estudiante','codigoestudiante');
		//DB_DataObject::debugLevel(0);
	   $nombreestudiante=$idestudiantegeneral->getlink('idestudiantegeneral','estudiantegeneral','idestudiantegeneral');
	   $tipodescuentoeducacioncontinuada=$descuentoestudianteeducacioncontinuada->getLink('iddescuentoeducacioncontinuada','descuentoeducacioncontinuada','iddescuentoeducacioncontinuada');
	   $nombretipodescuentoeducacioncontinuada=$tipodescuentoeducacioncontinuada->getLink('codigotipodescuentoeducacioncontinuada','tipodescuentoeducacioncontinuada','codigotipodescuentoeducacioncontinuada');
	   $nombredirectivo=$descuentoestudianteeducacioncontinuada->getLink('iddirectivo','directivo','iddirectivo');
	  ?>
      <tr class="Estilo1">
        <td><div align="center"><?php echo $descuentoestudianteeducacioncontinuada->iddescuentoestudianteeducacioncontinuada?></div></td>
        <td><div align="center"><?php echo $descuentoestudianteeducacioncontinuada->fechadescuentoestudianteeducacioncontinuada?></div></td>
        <td><div align="center"><?php echo $nombreestudiante->apellidosestudiantegeneral,' ',$nombreestudiante->nombresestudiantegeneral?></div></td>
        <td><div align="center"><?php echo $nombreestudiante->numerodocumento?></div></td>
        <td><div align="center"><a href="descuentoestudianteeducacioncontinuada_detalle.php" onclick="abrir('descuentoestudianteeducacioncontinuada_detalle.php?iddescuentoestudianteeducacioncontinuada=<?php echo $descuentoestudianteeducacioncontinuada->iddescuentoestudianteeducacioncontinuada?>','Editardetalledescuentoeducacioncontinuada','width=600,height=250,top=50,left=50,scrollbars=yes');return false"><?php echo $descuentoestudianteeducacioncontinuada->descripciondescuentoestudianteeducacioncontinuada?></a></div></td>
        <td><div align="center"><?php echo $tipodescuentoeducacioncontinuada->nombredescuentoeducacioncontinuada?></div></td>
        <td><div align="center"><?php echo $tipodescuentoeducacioncontinuada->porcentajedescuentoeducacioncontinuada?></div></td>
        <td><div align="center"><?php echo $nombretipodescuentoeducacioncontinuada->nombredescuentoeducacioncontinuada?></div></td>
        <td><div align="center"><?php echo $descuentoestudianteeducacioncontinuada->fechadesdedescuentoestudianteeducacioncontinuada?></div></td>
        <td><div align="center"><?php echo $descuentoestudianteeducacioncontinuada->fechahastadescuentoestudianteeducacioncontinuada?></div></td>
        <td><div align="center"><?php echo $nombredirectivo->apellidosdirectivo,' ',$nombredirectivo->nombresdirectivo?></div></td>
      </tr>
      <?php } while($descuentoestudianteeducacioncontinuada->fetch());}?>
      <tr bgcolor="#CCDADD">
        <td colspan="11"><div align="center">
            <input name="Nuevo" type="submit" id="Nuevo" value="Nuevo descuento" onclick="abrir('descuentoestudianteeducacioncontinuada_nuevo.php?codigoestudiante=<?php echo $_GET['codigoestudiante']?>','Nuevodescuentoestudianteeducacioncontinuada','width=600,height=250,top=50,left=50,scrollbars=yes');return false">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <?php if(isset($_GET['aplicacion'])){?>
			<input name="Regresar" type="submit" id="Regresar" value="Regresar">
			<?php } ?>
</div></td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
<?php if(isset($_GET['codigoestudiante'])){?>
<script language="javascript">
function recargar()
{
	window.location.reload('descuentoestudianteeducacioncontinuada_listado.php?aplicacion=<?php echo $_GET['aplicacion']?>&codigoestudiante=<?php echo $_GET['codigoestudiante']?>');
}
</script>
<?php } 
else{ ?>
<script language="javascript">
function recargar()
{
	window.location.reload('descuentoestudianteeducacioncontinuada_listado.php?aplicacion=<?php echo $_GET['aplicacion']?>');
}
</script>
<?php } ?>
<?php 
if(isset($_GET['Regresar']))
{
	if($_GET['aplicacion']=='si')
	{
		echo '<script language="Javascript">window.location.reload("menu.php");</script>';
	}
	else
	{
		echo '<script language="Javascript">window.location.reload("../../prematricula/matriculaautomaticaordenmatricula.php");</script>';
	}
	
}
?>
