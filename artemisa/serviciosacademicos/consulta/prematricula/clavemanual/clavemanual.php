<?php
$rutaado=("../../../funciones/adodb/");
//require_once('../../../funciones/sala/nota/nota.php');
//require_once('../../../funciones/sala/estudiante/estudiante.php');
require_once('../../../Connections/sala2.php');
//$rutazado = "../../../funciones/zadodb/";
require_once('../../../Connections/salaado.php'); 

session_start();
if(!isset($_SESSION['MM_Username']))
{
	echo "<h3>No tiene acceso a esta opción</h3>";
}

?>
<html>
<head>
<title>Cambio de clave manual</title>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
</head>
<body>
<p>Esta aplicación funciona para casos en que la clave no ha sido enviada automáticamente al aspirante y hay que modificarse manualmente</p>
<?php
if(isset($_GET['numerodocumento']) && isset($_GET['cambiarclave']))
{
	$db->debug = true;
	$numerodocumento = $_GET['numerodocumento'];
	$clave = $_GET['clave'];
	if($_GET['clave'] != "")
	{
		$query_preins = "select up.idestudiantegeneral, up.idusuariopreinscripcion,
up.fechavencimientousuariopresinscripcion, '2008-12-01',
 cp.codigoestadoclaveusuariopreinscripcion, '100' from
 estudiantegeneral eg ,usuariopreinscripcion up
left join claveusuariopreinscripcion cp on up.idusuariopreinscripcion=cp.idusuariopreinscripcion
where  eg.idestudiantegeneral=up.idestudiantegeneral
and eg.numerodocumento = '".$numerodocumento."' order by 1 desc   ";
		$preins = $db->Execute($query_preins);
		$totalRows_preins = $preins->RecordCount();
		$row_preins = $preins->FetchRow();
		
        $clave256 = hash('sha256', $clave);
		$query_updpreins = "update usuariopreinscripcion up
		set up.claveusuariopreinscripcion = '".$clave256."',
                up.fechavencimientousuariopresinscripcion = '2009-12-01'
		where  up.idestudiantegeneral = '".$row_preins['idestudiantegeneral']."'
		 and up.idusuariopreinscripcion = '".$row_preins['idusuariopreinscripcion']."'";
		$updpreins = $db->Execute($query_updpreins);
		
		echo "<p>La clave ha sido modificada satisfactoriamente</p>";
	}
	else
	{
		echo "<p>Debe digitar una clave</p>";
		
	}
}
if(isset($_GET['rest']))
{
	$_GET['numerodocumento'] = "";
	$_GET['clave'] = "";
	$numerodocumento = $_GET['numerodocumento'];
	$clave = $_GET['clave'];
}
?>
<form action="" name="f1" method="get">
<table>
<tr id="trtitulogris">
<td>Digite el documento</td>
<td>Digite la clave</td>
</tr>
<tr>
<td><input type="text" name="numerodocumento" value="<? echo $numerodocumento ?>"></td>
<td><input type="text" name="clave" value="<? echo $clave ?>"></td>
</tr>
<tr>
<td colspan="2"><input type="submit" name="cambiarclave" value="Cambiar Clave"><input type="submit" name="rest" value="Reestablecer"></td>
</tr>
</table>
</form>
</body>
</html>

