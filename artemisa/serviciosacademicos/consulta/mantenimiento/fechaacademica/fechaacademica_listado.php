<?php 
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION); 
?>
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
	window.location.reload("fechaacademica_listado.php");
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

require_once('../../../funciones/clases/autenticacion/redirect.php');
ini_set("include_path", ".:/usr/share/pear_");
//error_reporting(2048);
//@session_start();
require_once(realpath(dirname(__FILE__)).'/../funciones/validacion.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/conexion/conexion.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/pear/PEAR.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/pear/DB.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/pear/DB/DataObject.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/gui/combo_valida_get.php');

//DB_DataObject::debugLevel(5);

$config = parse_ini_file('../funciones/conexion/basedatos.ini',TRUE);
foreach($config as $class=>$values) {
	$options = &PEAR::getStaticProperty($class,'options');
	$options = $values;
}
$validaciongeneral=true;	

?>
<?php
$periodo = DB_DataObject::factory('periodo');
//selecciona periodo activo
$periodo->whereADD('codigoestadoperiodo=1');
$periodo->get('','*');

$query_fechaacademica="select fa.idfechaacademica,fa.codigoperiodo,c.nombrecarrera,fa.fechacortenotas,fa.fechacargaacademica,fa.fechainicialprematricula,fa.fechafinalprematricula,fa.fechainicialentregaordenpago,fa.fechafinalentregaordenpago
from fechaacademica fa,carrera c
where
fa.codigocarrera=c.codigocarrera and
fa.codigoperiodo='".$_GET['codigoperiodo']."' order by c.nombrecarrera asc
";
//echo ($query_fechaacademica);
$fechaacademica=$sala->query($query_fechaacademica);
//$row_fechaacademica=$fechacademica->fetchRow();
//print_r($row_fechaacademica);
?>
<p align="center" class="Estilo3">FECHA ACADEMICA - CARRERAS CON FECHA ACADEMICA PARAMETRIZADA <br>
  <br>
</p>
<form name="form1" action="" method="get">
  <table width="50%"  border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <td><table width="100%" border="0" cellpadding="2" cellspacing="0">
          <tr bgcolor="#CCDADD" class="Estilo2">
            <td bgcolor="#CCDADD"><div align="center">Periodo</div></td>
            <td bgcolor="#FEF7ED"><div align="left">
                <?php $validacion['codigoperiodo']=combo_valida_get("codigoperiodo","periodo","codigoperiodo","codigoperiodo",'onChange="enviar()"',"","codigoperiodo desc","si","Periodo")?>
            </div></td>
          </tr>
      </table></td>
    </tr>
  </table>
  <br>
  <table width="80%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <td><table width="100%" border="0" cellpadding="2" cellspacing="0">
      <tr bgcolor="#CCDADD" class="Estilo2">
        <td bgcolor="#CCDADD"><div align="center">Periodo</div></td>
        <td bgcolor="#CCDADD"><div align="center">Carrera</div></td>
        <td><div align="center">Fecha de corte notas </div></td>
        <td bgcolor="#CCDADD"><div align="center">Fecha carga acad&eacute;mica</div></td>
        <td><div align="center">Fecha inicial prematr&iacute;cula </div></td>
        <td><div align="center">Fecha final prematr&iacute;cula </div></td>
        <td bgcolor="#CCDADD"><div align="center">Fecha inicial entrega orden pago </div></td>
        <td bgcolor="#CCDADD"><div align="center">Fecha final entrega orden pago </div></td>
      </tr>
      <?php while($row_fechaacademica=$fechaacademica->fetchRow()){?>
      <tr class="Estilo1">
        <td><div align="center"><?php echo $row_fechaacademica['codigoperiodo']?></div></td>
        <td><div align="center"><a href="fechaacademica_detalle.php?nombrecarrera=<?php echo $row_fechaacademica['nombrecarrera']?>&idfechaacademica=<?php echo $row_fechaacademica['idfechaacademica']?>" onclick="abrir('fechaacademica_detalle.php?nombrecarrera=<?php echo $row_fechaacademica['nombrecarrera']?>&idfechaacademica=<?php echo $row_fechaacademica['idfechaacademica']?>','Editarfechaacademica','width=800,height=250,top=50,left=50,scrollbars=yes');return false"><?php echo $row_fechaacademica['nombrecarrera']?></a></div></td>
        <td><div align="center"><?php echo $row_fechaacademica['fechacortenotas']?></div></td>
        <td><div align="center"><?php echo $row_fechaacademica['fechacargaacademica']?></div></td>
        <td><div align="center"><?php echo $row_fechaacademica['fechainicialprematricula']?></div></td>
        <td><div align="center"><?php echo $row_fechaacademica['fechafinalprematricula']?></div></td>
        <td><div align="center"><?php echo $row_fechaacademica['fechainicialentregaordenpago']?></div></td>
        <td><div align="center"><?php echo $row_fechaacademica['fechafinalentregaordenpago']?></div></td>
      </tr>
      <?php } ?>
      <tr bgcolor="#CCDADD" class="Estilo1">
        <td colspan="8"><div align="center">
            <input name="nuevo" type="submit" id="nuevo"  value="Nueva fecha acad&eacute;mica"/>
        </div></td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
<?php 
if(isset($_GET['nuevo']))
{
	foreach ($validacion as $key => $valor){if($valor['valido']==0){$mensajegeneral=$mensajegeneral.'\n'.$valor['mensaje'];$validaciongeneral=false;}}
	if($validaciongeneral==true)
	{ ?>
		<script language="javascript">abrir('fechaacademica_nuevo.php?codigoperiodo=<?php echo $_GET['codigoperiodo']?>','nuevofechacademica','width=800,height=250,top=200,left=150,scrollbars=yes');</script>
	<?php }
	else
	{
		echo "<script language='javascript'>alert('".$mensajegeneral."');</script>";
	}
}
?>