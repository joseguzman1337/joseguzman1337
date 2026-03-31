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
-->
</style>
<?php
//echo ini_get('include_path');
ini_set("include_path", ".:/usr/share/pear_");
//error_reporting(2048);
//@session_start();
require_once(realpath(dirname(__FILE__)).'/../funciones/validacion.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/conexion/conexion.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/pear/PEAR.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/pear/DB.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/pear/DB/DataObject.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/gui/combo_valida_get.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/clases/autenticacion/redirect.php'); 


//DB_DataObject::debugLevel(5);

$config = parse_ini_file('../funciones/conexion/basedatos.ini',TRUE);
foreach($config as $class=>$values) {
	$options = &PEAR::getStaticProperty($class,'options');
	$options = $values;
}
$validaciongeneral=true;	
//PEAR::setErrorHandling(PEAR_ERROR_PRINT);
PEAR::setErrorHandling(PEAR_ERROR_CALLBACK, 'error_handler');
function error_handler(&$obj) {
$msg = $obj->getMessage();
$code = $obj->getCode();
$info = $obj->getUserInfo();
echo $msg,' ',$code,"<br>";
if ($info) {
print htmlspecialchars($info);
} 
}

?>
<?php
echo '
<script language="Javascript">
function recargar() 
{
	window.location.reload("detallecohorte_listado.php?idcohorte='.$_GET['idcohorte'].'");
}
</script>'
?>

<?php
$query_detallecohorte="select dc.iddetallecohorte,dc.semestredetallecohorte,c.nombreconcepto,dc.valordetallecohorte from detallecohorte dc, concepto c
where dc.codigoconcepto=c.codigoconcepto and dc.idcohorte='".$_GET['idcohorte']." order by dc.semestredetallecohorte'
";
//echo $query_detallecohorte;
$detallecohorte=$sala->query($query_detallecohorte);

?>
<form name="form1" method="post" action="">
<p align="center" class="Estilo3">Detalle de Cohortes </p>
<br>
<table width="60%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="2">
      <tr bgcolor="#CCDADD" class="Estilo2">
        <td colspan="3" bgcolor="#CCDADD"><div align="center"></div>          <div align="center"><?php echo $_GET['nombrecarrera']?></div></td>
        </tr>
      <tr bgcolor="#CCDADD" class="Estilo2">
        <td bgcolor="#CCDADD"><div align="center">Semestre detalle cohorte </div></td>
        <td><div align="center">Concepto</div></td>
        <td><div align="center">Valor detalle cohorte</div></td>
        </tr>
      <?php while(@$row_detallecohorte=$detallecohorte->fetchRow()){ ?>
      <tr class="Estilo1">
        <td nowrap><div align="center"><a href="detallecohorte.php" onclick="abrir('detallecohorte_detalle.php?nombrecarrera=<?php echo $_GET['nombrecarrera']?>&iddetallecohorte=<?php echo $row_detallecohorte['iddetallecohorte']?>','Editardetallecohorte','width=660,height=250,top=50,left=50,scrollbars=yes');return false"><?php echo $row_detallecohorte['semestredetallecohorte']?></a></div></td>
        <td nowrap><div align="center"><?php echo $row_detallecohorte['nombreconcepto']?></div></td>
        <td nowrap><div align="center"><?php echo $row_detallecohorte['valordetallecohorte']?></div></td>
        </tr>
      <?php } ?>
	  <tr bgcolor="#CCDADD" class="Estilo1">
        <td colspan="3"><div align="center">
          <input name="nuevodetallecohorte" type="submit" id="nuevodetallecohorte" onclick="abrir('detallecohorte_nuevo.php?idcohorte=<?php echo $_GET['idcohorte']?>&nombrecarrera=<?php echo $_GET['nombrecarrera']?>','miventana','width=600,height=200,top=200,left=150,scrollbars=yes');return false" value="Nuevo detalle cohorte"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <input name="Regresar" type="submit" id="Regresar" value="Regresar">
        </div></td>
        </tr>
      
    </table></td>
  </tr>
</table>

</form>
<?php
if(isset($_POST['Regresar']))
{
?>
	<script language='javascript'>window.location.reload('cohorte_listado.php?codigoperiodo=<?php echo $_GET['codigoperiodo'];?>');</script>";
<?php }
?>