<?php
//error_reporting(2047);//print_r($_GET);
?>
<script language="Javascript">
function abrir(pagina,ventana,parametros) {
	window.open(pagina,ventana,parametros);
}
</script>
<script language="javascript">
function enviar()
{
	document.form1.submit()
}
</script>

<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 11px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
.Estilo4 {color: #FF0000}
.Estilo5 {font-family: Tahoma; font-size: 12px}
.verdoso {background-color: #CCDADD;font-family: Tahoma; font-size: 12px; font-weight: bold;}
.amarrillento {background-color: #FEF7ED;font-family: Tahoma; font-size: 11px}
-->
</style>
<?php
//echo ini_get('include_path');
ini_set("include_path", ".:/usr/share/pear_");
//error_reporting(2048);
require_once('../funciones/validacion.php');
require_once('../funciones/conexion/conexion.php');
require_once('../funciones/pear/PEAR.php');
require_once('../funciones/pear/DB.php');
require_once('../funciones/pear/DB/DataObject.php');
require_once('../funciones/gui/combo_valida_get.php');
require_once('../../../funciones/clases/autenticacion/redirect.php');
//DB_DataObject::debugLevel(5);

$config = parse_ini_file('../funciones/conexion/basedatos.ini',TRUE);
foreach($config as $class=>$values) {
	$options = &PEAR::getStaticProperty($class,'options');
	$options = $values;
}
?>
<?php
$fechahoy=date("Y-m-d H:i:s");
//$valoreducacioncontinuada=DB_DataObject::factory('valoreducacioncontinuada');
//$valoreducacioncontinuada->whereAdd("fechainiciovaloreducacioncontinuada <= '".$fechahoy."' and fechafinalvaloreducacioncontinuada >= '".$fechahoy."'");
if(isset($_GET['codigocarrera']) && $_GET['codigocarrera']!="")
{

$query_valeducon = "select * from valoreducacioncontinuada v
join carrera c on c.codigocarrera=v.codigocarrera
join concepto co on co.codigoconcepto=v.codigoconcepto
where v.codigocarrera = '".$_GET['codigocarrera']."'
and v.fechainiciovaloreducacioncontinuada <= '".$fechahoy."' and v.fechafinalvaloreducacioncontinuada >= '".$fechahoy."'";
$valeducon = $sala->query($query_valeducon);
$totalRows_valeducon= $valeducon->numRows();
$row_valeducon = $valeducon->fetchRow();
	//DB_DataObject::debugLevel(5);
	//$valoreducacioncontinuada->whereAdd("codigocarrera='".$_GET['codigocarrera']."'");
	//$valoreducacioncontinuada->get('','*');
}
?>
<form name="form1" method="get" action="">
  <p align="center" class="Estilo3">VALOR EDUCACION CONTINUADA - LISTADO </p>
  <table width="70%"  border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <td><table width="100%"  border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td width="22%" class="verdoso">Modalidad acad&eacute;mica </td>
          <td width="78%" class="amarrillento"><?php $validacion['codigomodalidadacademica']=combo_valida_get("codigomodalidadacademica","modalidadacademica","codigomodalidadacademica","nombremodalidadacademica","onchange=enviar()","","nombremodalidadacademica asc","si","Modalidad acad&eacute;mica")?></td>
        </tr>
        <tr>
          <td class="verdoso">Carrera</td>
          <td class="amarrillento"><?php $validacion['codigocarrera']=combo_valida_get("codigocarrera","carrera","codigocarrera","nombrecarrera","onchange=enviar()","fechainiciocarrera <= '".$fechahoy."' and fechavencimientocarrera >= '".$fechahoy."' and codigomodalidadacademica='".$_GET['codigomodalidadacademica']."'","nombrecarrera asc","si","Carrera")?></td>
        </tr>
      </table></td>
    </tr>
  </table>
  <br>
  <table width="70%"  border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <td><table width="100%" cellpadding="2" cellspacing="2">
        <tr class="verdoso">
          <td><div align="center">ID</div></td>
          <td><div align="center">Nombre</div></td>
          <td><div align="center">Carrera</div></td>
          <td><div align="center">Concepto</div></td>
          <td><div align="center">Precio</div></td>
          <td><div align="center">Fecha inicio </div></td>
          <td><div align="center">Fecha Final</div></td>
        </tr>
        <?php if(isset($_GET['codigocarrera']) and $totalRows_valeducon!=""){
	do{
	?>
        <tr class="amarrillento">
          <td><div align="center"><a href="valoreducacioncontinuada_detalle.php?nombrecarrera=<?php echo $row_valeducon['nombrecarrera']; ?>&idvaloreducacioncontinuada=<?php echo $row_valeducon['idvaloreducacioncontinuada']; ?>" onclick="abrir('valoreducacioncontinuada_detalle.php?nombrecarrera=<?php echo $row_valeducon['nombrecarrera'];?>&idvaloreducacioncontinuada=<?php echo $row_valeducon['idvaloreducacioncontinuada'];?>','Editarvaloreducacioncontinuada','width=450,height=300,top=50,left=50,scrollbars=yes');return false"><?php echo $row_valeducon['idvaloreducacioncontinuada'];?></a></div></td>
          <td><div align="center"><?php echo $row_valeducon['nombrevaloreducacioncontinuada']; ?></div></td>
          <td><div align="center"><?php echo $row_valeducon['nombrecarrera']; ?></div></td>
          <td><div align="center"><?php echo $row_valeducon['nombreconcepto']; ?></div></td>
          <td><div align="center"><?php echo $row_valeducon['preciovaloreducacioncontinuada']; ?></div></td>
          <td><div align="center"><?php echo $row_valeducon['fechainiciovaloreducacioncontinuada']; ?></div></td>
          <td><div align="center"><?php echo $row_valeducon['fechafinalvaloreducacioncontinuada']; ?></div></td>
        </tr>
          <?php } while($row_valeducon = $valeducon->fetchRow());}?>
        <tr class="verdoso">
          <td colspan="7"><div align="center">
            <input name="Nuevo valor" type="submit" id="Nuevo valor" value="Nuevo" onclick="abrir('valoreducacioncontinuada_nuevo.php?codigomodalidadacademica=<?php echo $_GET['codigomodalidadacademica']?>','Nuevovaloreducacioncontinuada','width=600,height=350,top=50,left=50,scrollbars=yes');return false">
          </div></td>
          </tr>

      </table></td>
    </tr>
  </table>
</form>
<script language="Javascript">
function recargar() 
{ 
	window.location.reload("valoreducacioncontinuada_listado.php?codigomodalidadacademica=<?php echo $_GET['codigomodalidadacademica']?>&codigocarrera=<?php echo $_GET['codigocarrera']?>");
}
</script>
