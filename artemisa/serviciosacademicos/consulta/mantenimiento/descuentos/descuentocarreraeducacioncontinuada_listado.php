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
require_once(realpath(dirname(__FILE__)).'/../funciones/gui/combo_valida_get.php');

$config = parse_ini_file('../funciones/conexion/basedatos.ini',TRUE);
foreach($config as $class=>$values) {
	$options = &PEAR::getStaticProperty($class,'options');
	$options = $values;
}
$validaciongeneral=true;	
$mensajegeneral='Los campos marcados con *, no han sido correctamente diligenciados\n';
?>
<?php
//DB_DataObject::debugLevel(5);
//print_r($_GET);
$fechahoy=date("Y-m-d");
$descuentocarreraeducacioncontinuada=DB_DataObject::factory('descuentocarreraeducacioncontinuada');
$descuentocarreraeducacioncontinuada->whereAdd("fechahastadescuentocarreraeducacioncontinuada>='".$fechahoy."'"); //fechadesdedescuentocarreraeducacioncontinuada<='".$fechahoy."' and 
$descuentocarreraeducacioncontinuada->get('codigocarrera',$_GET['codigocarrera']);
//$descuentocarreraeducacioncontinuada->get('','*');
?>
<form name="form1" method="get" action="">
  <p align="center" class="Estilo3">DESCUENTO CARRERA EDUCACION CONTINUADA - LISTADO </p>
  <table width="90%"  border="1" align="center" bordercolor="#000000">
    <tr>
      <td><table width="100%" border="0" align="center" cellpadding="2" cellspacing="2">
        <tr>
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Modalidad Acad&eacute;mica </div></td>
          <td bgcolor="#FEF7ED"><?php $validacion['codigomodalidadacademica']=combo_valida_get("codigomodalidadacademica","modalidadacademica","codigomodalidadacademica","nombremodalidadacademica",'onChange=enviar()',"","","si","Modalidadacademica")?></td>
        </tr>
        <tr>
          <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Carrera</div></td>
          <td bgcolor="#FEF7ED"><?php $validacion['codigocarrera']=combo_valida_get("codigocarrera","carrera","codigocarrera","nombrecarrera","onChange=enviar()","codigomodalidadacademica='".$_GET['codigomodalidadacademica']."' and fechainiciocarrera <= '".$fechahoy."' and fechavencimientocarrera >= '".$fechahoy."'","nombrecarrera asc","si","Carrera")?>
            <div align="center"></div></td>
        </tr>
        <tr bgcolor="#CCDADD">
          <td colspan="2" class="Estilo2"><div align="center">
            <input name="Regresar" type="submit" id="Regresar" value="Regresar">
          </div></td>
          </tr>
      </table></td>
    </tr>
  </table>
  <br>  
  <?php if(isset($_GET['codigocarrera'])){?>
  <table width="90%"  border="1" align="center" bordercolor="#000000">
    <tr>
      <td><table width="100%"  border="0" align="center">
        <tr bgcolor="#CCDADD" class="Estilo2">
          <td><div align="center">ID</div></td>
          <td><div align="center">Descripci&oacute;n</div></td>
          <td><div align="center">Carrera</div></td>
          <td><div align="center">Fecha desde </div></td>
          <td><div align="center">Fecha hasta </div></td>
          <td><div align="center">Usuario</div></td>
          <td><div align="center">IP</div></td>
          <td><div align="center">Directivo</div></td>
        </tr>
        <?php do{ 
			if($descuentocarreraeducacioncontinuada->iddescuentocarreraeducacioncontinuada!=""){
			$nombrecarrera=$descuentocarreraeducacioncontinuada->getlink('codigocarrera','carrera','codigocarrera');
			$nombreusuario=$descuentocarreraeducacioncontinuada->getlink('idusuario','usuario','idusuario');
			$nombredirectivo=$descuentocarreraeducacioncontinuada->getlink('iddirectivo','directivo','iddirectivo');}
		?>
		<tr class="Estilo1">
          <td>
            <div align="center"><a href="descuentocarreraeducacioncontinuada_detalle.php" onclick="abrir('descuentocarreraeducacioncontinuada_detalle.php?iddescuentocarreraeducacioncontinuada=<?php echo $descuentocarreraeducacioncontinuada->iddescuentocarreraeducacioncontinuada?>','Detalledescuentocarreraeducacioncontinuada','width=800,height=310,top=50,left=50,scrollbars=yes');return false"><?php echo $descuentocarreraeducacioncontinuada->iddescuentocarreraeducacioncontinuada?></a></div></td>
          <td>
            <div align="center"><?php echo $descuentocarreraeducacioncontinuada->descripciondescuentocarreraeducacioncontinuada?></div></td>
          <td><div align="center"><?php if($descuentocarreraeducacioncontinuada->iddescuentocarreraeducacioncontinuada!=''){echo $nombrecarrera->nombrecarrera;}?></div></td>
          <td><div align="center"><?php echo $descuentocarreraeducacioncontinuada->fechadesdedescuentocarreraeducacioncontinuada?></div></td>
          <td><div align="center"><?php echo $descuentocarreraeducacioncontinuada->fechahastadescuentocarreraeducacioncontinuada?></div></td>
          <td><div align="center"><?php echo $nombreusuario->usuario?></div></td>
          <td><div align="center"><?php echo $descuentocarreraeducacioncontinuada->ip?></div></td>
          <td><div align="center"><?php echo $nombredirectivo->apellidosdirectivo,' ',$nombredirectivo->nombresdirectivo?></div></td>
        </tr>
        <?php } while($descuentocarreraeducacioncontinuada->fetch());?>
		<tr bgcolor="#CCDADD">
          <td colspan="8"><div align="center">
            <input name="Nuevo" type="submit" id="Nuevo" value="Asociar descuento a carrera" onclick="abrir('descuentocarreraeducacioncontinuada_nuevo.php?codigocarrera=<?php echo $_GET['codigocarrera']?>','Nuevodescuentocarreraeducacioncontinuada','width=550,height=300,top=50,left=50,scrollbars=yes');return false">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input name="Regresar" type="submit" id="Regresar" value="Regresar">			
          </div></td>
          </tr>
      </table></td>
    </tr>
  </table>
  <?php } ?>
  <p>&nbsp;</p>
</form>
<script language="Javascript">
function recargar() 
{ 
	window.location.reload("descuentocarreraeducacioncontinuada_listado.php?codigomodalidadacademica=<?php echo $_GET['codigomodalidadacademica']?>&codigocarrera=<?php echo $_GET['codigocarrera']?>")
}
</script>
<?php 
if(isset($_GET['Regresar']))
{
	echo '<script language="Javascript">window.location.reload("menu.php");</script>';
	
}
?>
