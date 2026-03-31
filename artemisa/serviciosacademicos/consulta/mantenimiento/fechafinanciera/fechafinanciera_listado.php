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
require_once(realpath(dirname(__FILE__)).'/../funciones/gui/combo_valida_get.php');
require_once(realpath(dirname(__FILE__)).'/calendario/calendario.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/validaciones/validaciongenerica.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/validaciones/validardosfechas.php');


DB_DataObject::debugLevel(5);

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
//$periodo = DB_DataObject::factory('periodo');
//selecciona periodo activo
//$periodo->whereADD('codigoestadoperiodo=1');
//$periodo->get('','*');

$query_fechafinanciera="select ff.idfechafinanciera,ff.codigocarrera,c.nombrecarrera,ff.codigoperiodo,sp.nombresubperiodo from fechafinanciera ff, carrera c,subperiodo sp
where c.codigomodalidadacademica='".$_GET['codigomodalidadacademica']."' and c.codigocarrera=ff.codigocarrera and
ff.codigoperiodo='".$_GET['codigoperiodo']."' and ff.idsubperiodo=sp.idsubperiodo
";
//echo $query_fechafinanciera;
$fechafinanciera=$sala->query($query_fechafinanciera);

?>
<form name="form1" action="" method="get">
<p align="center" class="Estilo3">FECHA FINANCIERA - LISTADO </p>
<table width="50%" border="1" align="center" bordercolor="#000000">
  <tr>
    <td><table width="100%" border="0" cellpadding="2" cellspacing="0">
      <tr bgcolor="#CCDADD" class="Estilo2">
        <td bgcolor="#CCDADD"><div align="center">Modalidad Acad&eacute;mica </div></td>
        <td bgcolor="#FEF7ED">          <div align="left">
          <?php $validacion['codigomodalidadacademica']=combo_valida_get("codigomodalidadacademica","modalidadacademica","codigomodalidadacademica","nombremodalidadacademica",'onChange="enviar()"',"","nombremodalidadacademica","si","Modalidad académica")?>
        </div></td>
        <td bgcolor="#FEF7ED">&nbsp;</td>
      </tr>
      <tr bgcolor="#CCDADD" class="Estilo2">
        <td bgcolor="#CCDADD"><div align="center">Periodo</div></td>
        <td bgcolor="#FEF7ED"><div align="left">
          <?php $validacion['codigoperiodo']=combo_valida_get("codigoperiodo","periodo","codigoperiodo","codigoperiodo",'onChange="enviar()"',"","codigoperiodo desc","si","Periodo")?>
        </div></td>
        <td bgcolor="#FEF7ED">&nbsp;</td>
      </tr>
      <tr bgcolor="#CCDADD" class="Estilo2">
        <td bgcolor="#CCDADD"><div align="center">Carrera</div></td>
        <td><div align="center">Periodo</div></td>
        <td bgcolor="#CCDADD"><div align="center">Subperiodo</div></td>
      </tr>
      <?php while($row_fechafinanciera=$fechafinanciera->fetchRow()){?>
      <tr class="Estilo1">
        <td><div align="center"><a href="fechafinancieradetalle_listado.php?codigoperiodo=<?php echo $_GET['codigoperiodo']?>&codigomodalidadacademica=<?php echo $_GET['codigomodalidadacademica']?>&codigocarrera=<?php echo $row_fechafinanciera['codigocarrera']?>&nombrecarrera=<?php echo $row_fechafinanciera['nombrecarrera']?>&idfechafinanciera=<?php echo $row_fechafinanciera['idfechafinanciera']?>"><?php echo $row_fechafinanciera['nombrecarrera']?></a></div></td>
        <td><div align="center"><?php echo $row_fechafinanciera['codigoperiodo']?></div></td>
        <td><div align="center"><?php echo $row_fechafinanciera['nombresubperiodo']?></div></td>
      </tr>
      <?php } ?>
	  <tr class="Estilo1">
        <td colspan="3" bgcolor="#CCDADD"><div align="center">
          <input name="Nuevo" type="submit" id="Nuevo"  value="Agregar fecha financiera"/>
        </div></td>
        </tr>
     </table></td>
  </tr>
</table>
</form>
<script language="Javascript">
function recargar() 
{ 
	window.location.reload("fechafinanciera_listado.php?codigomodalidadacademica=<?php echo $_GET['codigomodalidadacademica']?>&codigoperiodo=<?php echo $_GET['codigoperiodo']?>");
}
</script>
<?php
if(isset($_GET['Nuevo']))
{
	foreach ($validacion as $key => $valor){if($valor['valido']==0){$mensajegeneral=$mensajegeneral.'\n'.$valor['mensaje'];$validaciongeneral=false;}}
	if($validaciongeneral==true)
	{ ?>
		<script language="Javascript"> abrir('fechafinanciera_nuevo.php?codigomodalidadacademica=<?php echo $_GET['codigomodalidadacademica'];?>&codigoperiodo=<?php echo $_GET['codigoperiodo']?>','nuevodetallefechafinanciera','width=700,height=150,top=200,left=150,scrollbars=yes');</script>
	<?php }
	else
	{
		echo "<script language='javascript'>alert('".$mensajegeneral."');</script>";
	}
}
?>