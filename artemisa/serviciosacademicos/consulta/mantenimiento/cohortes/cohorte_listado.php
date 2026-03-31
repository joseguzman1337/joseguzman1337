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
<script language="Javascript">
function recargar() 
{
	window.location.reload("cohorte_listado.php");
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
$fechahoy=date("Y-m-d H:i:s");
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
/* PEAR::setErrorHandling(PEAR_ERROR_CALLBACK, 'error_handler');
function error_handler(&$obj) {
$msg = $obj->getMessage();
$code = $obj->getCode();
$info = $obj->getUserInfo();
echo $msg,' ',$code,"<br>";
if ($info) {
print htmlspecialchars($info);
} 
}
 */
?>


<?php
$periodo = DB_DataObject::factory('periodo');
$periodo->whereADD('codigoestadoperiodo=1');
$periodo->get('','*');

if(isset($_GET['codigoperiodo'])){

echo '<script language="Javascript">
function recargar() 
{
	window.location.reload("cohorte_listado.php?codigoperiodo='.$_GET['codigoperiodo'].'");
}
</script>';

$query_cohortes="SELECT ch.idcohorte,ch.numerocohorte,c.nombrecarrera,ch.codigoperiodo,ec.nombreestadocohorte,ch.codigoperiodoinicial,ch.codigoperiodofinal FROM
cohorte ch, carrera c, estadocohorte ec WHERE
ch.codigocarrera=c.codigocarrera AND
ch.codigoestadocohorte=ec.codigoestadocohorte and
ch.codigoperiodo='".$_GET['codigoperiodo']."' and
ch.codigoestadocohorte='01'
order by c.nombrecarrera asc, ch.numerocohorte asc
";
//echo $query_cohortes;
}
$cohortes=$sala->query($query_cohortes);
?>
<form name="form1" method="get" action="">
<p align="center" class="Estilo3">Carreras con cohortes asignados al periodo vigente </p>
<table width="70%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <td><table width="100%" border="0" align="center" cellpadding="2">
      <tr>
        <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Seleccione el periodo </div></td>
        <td colspan="5" bgcolor="#FEF7ED" class="Estilo2"><div align="center">
            <?php combo_valida_get("codigoperiodo","periodo","codigoperiodo","codigoperiodo",'onChange="enviar()"',"codigoperiodo >= '".$periodo->codigoperiodo."'","","","si","Periodo") ?>
        </div></td>
      </tr>
    </table></td>
  </tr>
</table>
<br>
<table width="70%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="2">
      <tr bgcolor="#CCDADD" class="Estilo2">
        <td bgcolor="#CCDADD"><div align="center">No. Cohorte </div></td>
        <td><div align="center">Carrera Cohorte </div></td>
        <td><div align="center">Periodo de aplicaci&oacute;n </div></td>
        <td bgcolor="#CCDADD"><div align="center">Estado</div></td>
        <td><div align="center">Periodo inicial </div></td>
        <td><div align="center">Periodo final</div></td>
        <td bgcolor="#CCDADD"><div align="center">Detalle Cohorte </div></td>
      </tr>
      <?php while(@$row_cohortes=$cohortes->fetchRow()){ ?>
      <tr class="Estilo1">
        <td nowrap><div align="center"><?php echo $row_cohortes['numerocohorte']?></div></td>
        <td nowrap><div align="center"><a href="cohorte_detalle.php?idcohorte=<?php echo $row_cohortes['idcohorte']?>" onclick="abrir('cohorte_detalle.php?idcohorte=<?php echo $row_cohortes['idcohorte']?>','Editarcohorte','width=660,height=250,top=50,left=50,scrollbars=yes');return false"><?php echo $row_cohortes['nombrecarrera']?></a></div></td>
        <td nowrap><div align="center"><?php echo $row_cohortes['codigoperiodo']?></div></td>
        <td nowrap><div align="center"><?php echo $row_cohortes['nombreestadocohorte']?></div></td>
        <td nowrap><div align="center"><?php echo $row_cohortes['codigoperiodoinicial']?></div></td>
        <td nowrap><div align="center"><?php echo $row_cohortes['codigoperiodofinal']?></div></td>
        <td nowrap><div align="center"><a href="detallecohorte_listado.php?codigoperiodo=<?php echo $_GET['codigoperiodo']?>&nombrecarrera=<?php echo $row_cohortes['nombrecarrera']?>&idcohorte=<?php echo $row_cohortes['idcohorte']?>">Detalle</a></div></td>
      </tr>
      <?php } ?>
	  <tr bgcolor="#CCDADD" class="Estilo1">
        <td colspan="7"><div align="center">
          <input name="nuevocohorte" type="submit" id="nuevocohorte" onclick="abrir('cohorte_nuevo.php?codigoperiodo=<?php echo $_GET['codigoperiodo']?>','nuevocohorte','width=800,height=300,top=200,left=150,scrollbars=yes');return false" value="Nuevo cohorte"/>
        </div></td>
        </tr>
      
    </table></td>
  </tr>
</table>

</form>

