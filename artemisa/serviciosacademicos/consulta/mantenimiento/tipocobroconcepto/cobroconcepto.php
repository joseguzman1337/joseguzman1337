<?php 
session_start();
 include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
$superuser = $_SESSION['MM_Username']; 

$rutaado=("../../../funciones/adodb/");
require_once("../../../funciones/clases/debug/SADebug.php");
//require_once("../../../Connections/salaado-pear.php");
require_once("../../../Connections/salaado.php");
require_once(realpath(dirname(__FILE__)).'/../../../funciones/funcionip.php');
$ip = "SIN DEFINIR";
$ip = tomarip();

$query_modalidad = "SELECT * FROM modalidadacademica
WHERE codigomodalidadacademica <> 500 order by 1";
$modalidad = $db->Execute($query_modalidad);
$totalRows_modalidad = $modalidad->RecordCount();
$row_modalidad = $modalidad->FetchRow();

$query_usuario = "SELECT idusuario 
FROM usuario
WHERE usuario = '$superuser'";
$usuario = $db->Execute($query_usuario);
$totalRows_usuario = $usuario->RecordCount();
$row_usuario = $usuario->FetchRow();

?>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
<form name="form1" action="cobroconcepto.php" method="POST">
<script LANGUAGE="JavaScript">
function enviar()
{
 form1.submit();
}
</script>
<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
 <tr>
  <td colspan="2"><label id="labelresaltado">Creación cobro por Concepto</label></td>
  </tr>
 <tr>
  <td id="tdtitulogris">Modalidad</td>
  <td>
  <select name="modalidad" id="modalidad" onChange="enviar()">
    <option value="0"<?php if (!(strcmp("0", $_POST['modalidad']))) {echo "SELECTED";} ?>>Seleccionar</option>
<?php
    do 
    {
?>
     <option value="<?php echo $row_modalidad['codigomodalidadacademica']?>" <?php if (!(strcmp($row_modalidad['codigomodalidadacademica'], $_POST['modalidad']))) {echo "SELECTED";} ?>><?php echo $row_modalidad['nombremodalidadacademica']?></option>
<?php
    }while($row_modalidad = $modalidad->FetchRow());
?>
  </select>
 </td>
 </tr>
<?php 
if (isset($_REQUEST['modalidad']))
 {

    $query_car = "SELECT DISTINCT c.nombrecarrera, c.codigocarrera
	FROM carrera c
	WHERE c.codigomodalidadacademica = '".$_REQUEST['modalidad']."'
	AND c.fechavencimientocarrera > now()
	order by 1";
	$car = $db->Execute($query_car);
	$totalRows_car = $car->RecordCount(); 

?>
<tr>
<td id="tdtitulogris">Carrera</td>
  <td>
   <select name="especializacion" id="especializacion" onChange="enviar()">
    <option value="0" <?php if (!(strcmp("0", $_POST['especializacion']))) {echo "SELECTED";} ?>>Seleccionar</option>
<?php
	while($row_car = $car->FetchRow())
	{
?>
    <option value="<?php echo $row_car['codigocarrera'];?>" <?php if (!(strcmp($row_car['codigocarrera'], $_POST['especializacion']))) {echo "SELECTED";} ?>><?php echo $row_car['nombrecarrera']; ?></option>
<?php
    } 
?>
  </select>
 </td>
 </tr>
  
<?php 
 }

if (isset($_REQUEST['especializacion']))
 {

    $query_subperiodo = "SELECT s.idsubperiodo
	FROM periodo p, carreraperiodo cp, subperiodo s
	WHERE p.codigoperiodo  = cp.codigoperiodo
	AND s.idcarreraperiodo = cp.idcarreraperiodo
	AND cp.codigocarrera = '".$_REQUEST['especializacion']."'
	AND fechainiciofinancierosubperiodo <= '".date("Y-m-d")."'
	AND fechafinalfinancierosubperiodo >= '".date("Y-m-d")."'";
	$subperiodo = $db->Execute($query_subperiodo);
	$totalRows_subperiodo = $subperiodo->RecordCount(); 

    $idsubperiodo = $row_subperiodo['idsubperiodo'];
?>
<tr>
<td id="tdtitulogris">Subperiodo</td>
  <td>
   <select name="idsubperiodo" id="especializacion">
   
<?php
	while($row_subperiodo = $subperiodo->FetchRow())
	{
?>
    <option value="<?php echo $row_subperiodo['idsubperiodo'];?>" <?php if (!(strcmp($row_subperiodo['idsubperiodo'], $_POST['idsubperiodo']))) {echo "SELECTED";} ?>><?php echo $row_subperiodo['idsubperiodo']; ?></option>
<?php
    } 
?>
  </select>
 </td>
 </tr>

<?php 

    $query_tipocobro = "SELECT *
	from tipocobroconcepto
	where codigoestado like '1%'";
	$tipocobro = $db->Execute($query_tipocobro);
	$totalRows_tipocobro = $tipocobro->RecordCount(); 
?>
<tr>
<td id="tdtitulogris">Tipo de Cobro</td>
  <td>
   <select name="tipocobroconcepto" id="tipocobroconcepto" onChange="enviar()">
    <option value="0" <?php if (!(strcmp("0", $_POST['tipocobroconcepto']))) {echo "SELECTED";} ?>>Seleccionar</option>
<?php
	while($row_tipocobro = $tipocobro->FetchRow())
	{
?>
    <option value="<?php echo $row_tipocobro['codigotipocobroconcepto'];?>" <?php if (!(strcmp($row_tipocobro['codigotipocobroconcepto'], $_POST['tipocobroconcepto']))) {echo "SELECTED";} ?>><?php echo $row_tipocobro['nombretipocobroconcepto']; ?></option>
<?php
} 
?>
  </select>
 </td>
 </tr>
<?php 
 }
?>


<?php 
if (isset($_REQUEST['tipocobroconcepto']))
 {

    $query_concepto = "select c.codigoconcepto, c.nombreconcepto, c.codigoindicadorconceptoprematricula, c.codigoindicadoraplicacobrocreditosacademicos
	from concepto c
	where c.codigoindicadoraplicacobrocreditosacademicos like '1%'
	and c.codigoestado like '1%'";
	$concepto = $db->Execute($query_concepto);
	$totalRows_concepto = $concepto->RecordCount(); 

?>
<tr>
<td id="tdtitulogris">Concepto</td>
  <td>
   <select name="codigoconcepto" id="codigoconcepto" onChange="enviar()">
    <option value="0" <?php if (!(strcmp("0", $_POST['codigoconcepto']))) {echo "SELECTED";} ?>>Seleccionar</option>
<?php
	while($row_concepto = $concepto->FetchRow())
	{
?>
    <option value="<?php echo $row_concepto['codigoconcepto'];?>" <?php if (!(strcmp($row_concepto['codigoconcepto'], $_POST['codigoconcepto']))) {echo "SELECTED";} ?>><?php echo $row_concepto['nombreconcepto']; ?></option>
<?php
    } 
?>
  </select>
 </td>
 </tr>  
<?php 
 }

if (isset($_REQUEST['codigoconcepto']))
 {
    $existe = false;
	$query_cobro = "select * 
	from cobroconcepto 
	where codigoconcepto = '".$_REQUEST['codigoconcepto']."'
	and  idsubperiodo = '".$_REQUEST['idsubperiodo']."'
	and codigotipocobroconcepto = '".$_REQUEST['tipocobroconcepto']."'
	and fechavencimientocobroconcepto >= now()
	and codigoestado like '1%'";
	$cobro = $db->Execute($query_cobro);
	$totalRows_cobro = $cobro->RecordCount(); 
	$row_cobro = $cobro->FetchRow();
    //echo $query_cobro;
    if ($row_cobro <> "")
	{
	  $existe = true; 
	}
	
?>
<tr>
  <td id="tdtitulogris">valor</td>
  <td><input type="text" name="valor" value="<?php if ($row_cobro['valorcobroconcepto'] <> "") echo $row_cobro['valorcobroconcepto']; ?>"> </td>
 </tr>  
<?php 
 }
?>
</table>
<p>

<?php
 if($existe)
  {
?>  
    <input type="submit" name="Actualizar" value="Actualizar">&nbsp;
    <input type="submit" name="Desactivar" value="Desactivar">
<?php
  }
 else
  {
?>
    <input type="submit" name="Crear" value="Crear">
<?php  
  } 
 ?>  
</p>

<?php 

if ($_REQUEST['Crear'])
 {
   if(!eregi("^[0-9]{1,15}$", $_POST['valor']) or $_POST['valor'] == "" )
	{
	 echo '<script language="JavaScript">alert("El valor debe ser númerico"); history.go(-1)</script>';
	 exit();	
	}
   
   $query_actualiza ="UPDATE cobroconcepto
   set fechavencimientocobroconcepto = '".date('Y-m-d H:i:s')."',
   codigoestado = '200'
   where idsubperiodo = '".$_REQUEST['idsubperiodo']."'   
   and codigoconcepto = '".$_REQUEST['codigoconcepto']."'";
   $actualiza = $db->Execute($query_actualiza);    
   //echo $query_actualiza;
   
   $query_crear = "INSERT INTO cobroconcepto(idcobroconcepto,nombrecobroconcepto,fecharegistrocobroconcepto,fechainiciocobroconcepto,fechavencimientocobroconcepto,idsubperiodo,codigoconcepto,codigotipocobroconcepto,valorcobroconcepto,ipregistroconcepto,idusuario,codigoestado)
   VALUES(0,'".$_REQUEST['codigoconcepto']."','".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."','2999-12-31','".$_REQUEST['idsubperiodo']."','".$_REQUEST['codigoconcepto']."','".$_REQUEST['tipocobroconcepto']."','".$_REQUEST['valor']."','$ip','".$row_usuario['idusuario']."','100')";
   $crear = $db->Execute($query_crear);
   //echo $query_crear;   
  
   echo '<script language="JavaScript">alert("Registro Insertado Correctamente");</script>';	
   echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=cobroconcepto.php'>";
 }

if ($_REQUEST['Actualizar'])
 {
   if(!eregi("^[0-9]{1,15}$", $_POST['valor']) or $_POST['valor'] == "" )
	{
	 echo '<script language="JavaScript">alert("El valor debe ser númerico"); history.go(-1)</script>';
	 exit();	
	}
  $query_actualiza ="UPDATE cobroconcepto
  set codigotipocobroconcepto = '".$_REQUEST['tipocobroconcepto']."',
  valorcobroconcepto = '".$_REQUEST['valor']."'
  where idcobroconcepto = '".$row_cobro['idcobroconcepto']."'";
  $actualiza = $db->Execute($query_actualiza);   
 //echo $query_actualiza;
  echo '<script language="JavaScript">alert("Registro Actualizado Correctamente");</script>';
  echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=cobroconcepto.php'>";
 }
 
 if ($_REQUEST['Desactivar'])
 {
   if(!eregi("^[0-9]{1,15}$", $_POST['valor']) or $_POST['valor'] == "" )
	{
	 echo '<script language="JavaScript">alert("El valor debe ser númerico"); history.go(-1)</script>';
	 exit();	
	}
   $query_actualiza ="UPDATE cobroconcepto
   set fechavencimientocobroconcepto = '".date('Y-m-d H:i:s')."',
   codigoestado = '200'
   where idcobroconcepto = '".$row_cobro['idcobroconcepto']."'";
   $actualiza = $db->Execute($query_actualiza);    
   //echo $query_actualiza;
   echo '<script language="JavaScript">alert("Registro Actualizado Correctamente");</script>';
   echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=cobroconcepto.php'>";
 }
?>
</form>