<script language="Javascript">
function abrir(pagina,ventana,parametros) {
	window.open(pagina,ventana,parametros);
}
</script>
<style type="text/css">
<!--
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
.Estilo4 {color: #FF0000}
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
-->
</style>
<?php
//print_r($_POST);
ini_set("include_path", ".:/usr/share/pear_");
require_once('../funciones/conexion/conexion.php');
require_once '../funciones/pear/PEAR.php';
require_once '../funciones/pear/DB.php';
require_once('../funciones/validacion.php');
require_once '../funciones/pear/DB/DataObject.php';
require_once '../funciones/gui/combo_valida_post.php';
require_once '../funciones/gui/campotexto_valida_post.php';
require_once('../../../funciones/clases/autenticacion/redirect.php');
$config = parse_ini_file('../funciones/conexion/basedatos.ini',TRUE);
$config['DB_DataObject']['database']="mysql://".$username_sala.":".$password_sala."@".$hostname_sala."/".$database_sala;
foreach($config as $class=>$values) {
	$options = &PEAR::getStaticProperty($class,'options');
	$options = $values;
}
?>
<?php
//@session_start();
$query_periodoactivo="select codigoperiodo from periodo where codigoestadoperiodo = '1'";
$periodo_activo=$sala->query($query_periodoactivo);
$row_periodo_activo=$periodo_activo->fetchRow();
//echo $row_periodo_activo['codigoperiodo'];
$query_valorpecuniario="select vp.idvalorpecuniario,vp.codigoperiodo,vp.valorpecuniario,c.nombreconcepto,ipi.nombreindicadorprocesointernet
from valorpecuniario vp, concepto c,indicadorprocesointernet ipi
where vp.codigoconcepto=c.codigoconcepto
and codigoperiodo='".$_GET['codigoperiodo']."'
and vp.codigoindicadorprocesointernet=ipi.codigoindicadorprocesointernet
and vp.codigoestado='100'
order by c.nombreconcepto
";
$valorpecuniario=$sala->query($query_valorpecuniario);
//print_r($valorpecuniario);
?>

<form name="form1" method="post" action="">

<p align="center" class="Estilo3">Seleccionar valor pecuniario </p>
<table width="200" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <td><table width="200" border="0" align="center" cellpadding="3">
      <tr bgcolor="#CCDADD">
        <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">Periodo</div></td>
        <td nowrap class="Estilo2"><div align="center">Valor pecuniario</div></td>
        <td nowrap bgcolor="#CCDADD"><div align="center" class="Estilo2">
          <div align="center">Concepto</div>
        </div></td>
        <td nowrap bgcolor="#CCDADD" class="Estilo2"><div align="center">Indicador Proceso internet </div></td>
      </tr>
      <?php while ($row_valorpecuniario=$valorpecuniario->fetchRow()) {?>
	  <tr bgcolor="#FFFFFF">
        <td nowrap class="Estilo1"><?php echo $row_valorpecuniario['codigoperiodo'];?></td>
        <td nowrap class="Estilo1"><a href="vpecuniarioedita.php?idvalorpecuniario=<?php echo $row_valorpecuniario['idvalorpecuniario'];?>"onclick="abrir('vpecuniarioedita.php?codigoperiodo=<?php echo $_GET['codigoperiodo']?>&idvalorpecuniario=<?php echo $row_valorpecuniario['idvalorpecuniario'];?>','Editarvalorpecuniario','width=600,height=250,top=50,left=50,scrollbars=yes');return false"><?php echo $row_valorpecuniario['valorpecuniario'];?></a></td>
        <td nowrap><span class="Estilo1"><?php echo $row_valorpecuniario['nombreconcepto'];?></span></td>
        <td nowrap><div align="center" class="Estilo1"><?php echo $row_valorpecuniario['nombreindicadorprocesointernet']?></div></td>
	  </tr>
	  <?php } ?>
	  <tr bgcolor="#CCDADD">
	    <td colspan="4" nowrap class="Estilo1"><div align="center">
	      <input name="Regresar" type="submit" id="Regresar" value="Regresar">
	    </div></td>
	    </tr>
	  
    </table></td>
  </tr>
</table>
</form>
<?php if(isset($_POST['Regresar'])){
  	echo "<script language='javascript'>window.location.href='menu.php?tipo=".$_GET['tipo']."&codigoperiodo=".$_GET['codigoperiodo']."&modalidadacademica=".$_GET['modalidadacademica']."';</script>";
  }
?>

<script language="Javascript">
function recargar() 
{
	window.location.reload("vpecuniario_lista.php?modalidadacademica=<?php echo $_GET['modalidadacademica']?>&codigoperiodo=<?php echo $_GET['codigoperiodo']?>&tipo=<?php echo $_GET['tipo']?>");
}
</script>
