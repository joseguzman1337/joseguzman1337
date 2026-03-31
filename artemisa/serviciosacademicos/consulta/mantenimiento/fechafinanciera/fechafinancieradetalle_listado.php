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
<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
echo '<script language="Javascript">
function recargar() 
{
	window.location.href="fechafinancieradetalle_listado.php?codigomodalidadacademica='.$_GET['codigomodalidadacademica'].'&codigocarrera='.$_GET['codigocarrera'].'&idfechafinanciera='.$_GET['idfechafinanciera'].'";
}
</script>';
?>
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
require_once(realpath(dirname(__FILE__)).'/calendario/calendario.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/validaciones/validaciongenerica.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/validaciones/validardosfechas.php');


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
$query_detallefechafinanciera="select * from detallefechafinanciera d
join conceptodetallefechafinanciera c on c.codigoconceptodetallefechafinanciera=d.codigoconceptodetallefechafinanciera
where d.idfechafinanciera='".$_GET['idfechafinanciera']."'";
$detallefechafinanciera=$sala->query($query_detallefechafinanciera);
$row_detallefechafinanciera=$detallefechafinanciera->fetchRow();

/*$detallefechafinanciera=DB_DataObject::factory('detallefechafinanciera');
$detallefechafinanciera -> get('idfechafinanciera',$_GET['idfechafinanciera']);*/
?>
<form name="form1" method="post" action="">
<p align="center" class="Estilo3">FECHA FINANCIERA - DETALLES</p>
<table width="50%" border="1" align="center" bordercolor="#000000">
  <tr>
    <td><table width="100%" border="0" cellpadding="2" cellspacing="0">
      <tr class="Estilo2">
        <td colspan="6"><div align="center"><?php echo $_GET['nombrecarrera']?></div></td>
        </tr>
      <tr bgcolor="#CCDADD" class="Estilo2">
        <td bgcolor="#CCDADD"><div align="center">ID</div></td>
        <td><div align="center">Numero </div></td>
        <td><div align="center">Nombre</div></td>
        <td bgcolor="#CCDADD"><div align="center">Fecha</div></td>
        <td><div align="center">Porcentaje</div></td>
        <td><div align="center">Concepto</div></td>
      </tr>
      <?php do{?>
      <tr class="Estilo1">
        <td><div align="center"><a href="fechafinancieradetalle_detalle.php" onclick="abrir('fechafinancieradetalle_detalle.php?codigoperiodo=<?php echo $_GET['codigoperiodo']?>&nombrecarrera=<?php echo $_GET['nombrecarrera']?>&iddetallefechafinanciera=<?php echo $row_detallefechafinanciera['iddetallefechafinanciera'];?>','Editardetallefechafinanciera','width=400,height=250,top=50,left=50,scrollbars=yes');return false"><?php echo $row_detallefechafinanciera['iddetallefechafinanciera'];?></a></div></td>
        <td><div align="center"><?php echo $row_detallefechafinanciera['numerodetallefechafinanciera'];?></div></td>
        <td><div align="center"><?php echo $row_detallefechafinanciera['nombredetallefechafinanciera'];?></div></td>
        <td><div align="center"><?php echo $row_detallefechafinanciera['fechadetallefechafinanciera'];?></div></td>
        <td><div align="center"><?php echo $row_detallefechafinanciera['porcentajedetallefechafinanciera'];?></div></td>
        <td><div align="center"><?php echo $row_detallefechafinanciera['nombreoconceptodetallefechafinanciera'];?></div></td>
      </tr>
	   <?php } while($row_detallefechafinanciera=$detallefechafinanciera->fetchRow()); ?>
      <tr bgcolor="#CCDADD" class="Estilo1">
        <td colspan="6"><div align="center">
          <input name="nuevo" type="submit" id="nuevo" onclick="abrir('fechafinancieradetalle_nuevo.php?codigoperiodo=<?php echo $_GET['codigoperiodo']?>&codigocarrera=<?php echo $_GET['codigocarrera']?>&idfechafinanciera=<?php echo $_GET['idfechafinanciera'];?>','nuevodetallefechafinanciera','width=400,height=250,top=200,left=150,scrollbars=yes');return false" value="Agregar detalle"/>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <input name="Regresar" type="submit" id="Regresar" value="Regresar">
        </div></td>
        </tr>
     
    </table></td>
  </tr>
</table>
</form>
<?php
if(isset($_POST['Regresar'])){ ?>
<script language="javascript">
	window.location.href='fechafinanciera_listado.php?codigomodalidadacademica=<?php echo $_GET['codigomodalidadacademica']?>';
</script>
<?php } ?>

