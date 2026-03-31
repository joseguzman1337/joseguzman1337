<?php
session_start();
$ruta="../../../funciones/";
require_once('../../../funciones/ordenpago/claseordenpago.php');
//require_once('../../../funciones/ordenpago/Cimpresionescyc.php');
require_once('../../../Connections/sala2.php'); 	
//require('../../../../libsoap/class.getBank.php');
mysql_select_db($database_sala, $sala);

$_GET['codigoestudiante'] = '32217';
$_GET['codigoperiodo'] = '20071';
$_GET['numeroordenpago'] = '1066807';


?>
<html>
<head>
<title>Orden de PAgo</title>
<link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
<?php
if(isset($_GET['pse']))
{
?>
<script language="javascript">
function NoAtras(){
history.go(1)
}
</script>
<?php
}
?>
</head>
<script language="javascript">
function recargar(dir)
{
	window.location.reload(dir);
	//history.go();
}
</script>
<body <?php if(isset($_GET['pse'])){?>onLoad="NoAtras()"<?php } ?>>
<form name="form2" method="post" action="../../../../libsoap/class.sendws.php" onSubmit="return disableForm(this);" target="_parent">
<?php
$orden = new Ordenpago($sala, $_GET['codigoestudiante'], $_GET['codigoperiodo'], $_GET['numeroordenpago']);
if(!$orden->existe_conexionsap())
{
	//echo "Se cayo la pinche conexion";
?>
<script language="javascript">
function recargar(dir)
{
	alert("Se ha caido la conexion a sap");
	//history.go();
}
</script>
<?php
}
$orden->visualizar_ordenpago("ORDEN DE PAGO");
if(isset($_GET['pse']))
{
	$orden->visualizar_notasordenpago("<br>Le recomendamos cambiar su clave de correo por su seguridad");
	$orden->visualizar_ordenpagopse();
}
else
{
	$orden->visualizar_notasordenpago("
NOTA: DIRIJASE A EL DEPARTAMENTO DE CRÉDITO Y CARTERA Y RECLAME SU ORDEN DE PAGO
<p> DOCUMENTO NO VALIDO PARA PAGO</p>
<p>Le recomendamos cambiar su clave de correo por su seguridad.</p>
	");
}
?>
</form>
<?php
/*$query_permisoimpresion = "SELECT u.idrol, u.usuario FROM usuariorol u, permisorolboton p, menuboton m WHERE u.idrol = p.idrol AND p.idmenuboton = '28' and m.idmenuboton = p.idmenuboton and m.codigoestadomenuboton = '01' and u.usuario = '".$_SESSION['MM_Username']."'";*/

$query_permisoimpresion = "select rol.idrol, u.usuario from usuariorol rol, permisorolboton p, menuboton m, usuario u, UsuarioTipo ut WHERE rol.idrol = p.idrol
AND p.idmenuboton = '28'
and m.idmenuboton = p.idmenuboton
and m.codigoestadomenuboton = '01'
and u.usuario ='".$_SESSION['MM_Username']."'
and ut.UsuarioId = u.idusuario
and ut.CodigoTipoUsuario = rol.idusuariotipo";
//echo $query_permisoimpresion;
$permisoimpresion = mysql_query($query_permisoimpresion, $sala) or die("$query_permisoimpresion".mysql_error());
$totalRows_permisoimpresion = mysql_num_rows($permisoimpresion);
$row_permisoimpresion = mysql_fetch_assoc($permisoimpresion);
if($totalRows_permisoimpresion != "")
{
	$orden->visualizar_impresionordenpago($_GET['ipimpresora']);
}

$query_seldocumento = "SELECT eg.numerodocumento 
from estudiantegeneral eg, estudiante e
where eg.idestudiantegeneral = e.idestudiantegeneral
and e.codigoestudiante = '".$_GET['codigoestudiante']."'";
//echo $query_permisoimpresion;
$seldocumento = mysql_query($query_seldocumento, $sala) or die("$query_seldocumento".mysql_error());
$totalRows_seldocumento = mysql_num_rows($seldocumento);
$row_seldocumento = mysql_fetch_assoc($seldocumento);

if($_SESSION['MM_Username'] == "estudiante" || $_SESSION['MM_Username'] == "estudianterestringido")
{
?>
<font color="#800000" class="Estilo2"><a href="../../../../libsoap/ayudapse/AyudaPSE.htm" id="aparencialinknaranja">NUEVO SISTEMA DE PAGO PSE</a></font><br><br>
<?php
}
?>
<p>
<form>
<input type="button" value="Regresar" onClick="history.go(-1)">
<?php
// Validación si esta orden puede ser eliminada
// Para validar la orden se requiere que esta tenga concepto de matricula, y que se la orden más reciente en cuanto a matriculas
// Es decir que si hay varias ordenes, aca solo se van a anular las que tengan conceptos de matricula, las demás no se toman en cuenta

// Si el usuario tiene permiso para imprimir ordemes lo deja
// En el menu de opciones el id de la impresion en el menu es el 31

// Los permisos toca asignarlos por boton
// Si tiene permiso para el boton 26 puede anular ordenes de pago
/*$query_permisoanulacion = "SELECT u.idrol, u.usuario FROM usuariorol u, permisorolboton p, menuboton m WHERE u.idrol = p.idrol AND p.idmenuboton = '27' and m.idmenuboton = p.idmenuboton and m.codigoestadomenuboton = '01' and u.usuario = '".$_SESSION['MM_Username']."'";*/
    
$query_permisoanulacion = "select rol.idrol, u.usuario from usuariorol rol, permisorolboton p, menuboton m, usuario u, UsuarioTipo ut WHERE rol.idrol = p.idrol
AND p.idmenuboton = '27' and m.idmenuboton = p.idmenuboton and m.codigoestadomenuboton = '01'
and u.usuario ='".$_SESSION['MM_Username']."' and ut.UsuarioId = u.idusuario and ut.CodigoTipoUsuario = rol.idusuariotipo";
    
$permisoanulacion = mysql_query($query_permisoanulacion, $sala) or die("$query_permisoanulacion".mysql_error());
$totalRows_permisoanulacion = mysql_num_rows($permisoanulacion);
$row_permisoanulacion = mysql_fetch_assoc($permisoanulacion);
if($totalRows_permisoanulacion != "")
{
	if($orden->valida_anulacionordenmatricula())
	{
        ?>
        <input type="button" value="Anular Orden de Pago" onClick="anularoorden()">
        <?php
	}
}

$orden->imprimir_ordenpdf($ruta."ordenpago/", $nombre="Imprimir orden para pago en bancos");
?>
<!-- <a href="<?php echo $ruta."ordenpago/pagarpse.php?numeroordenpago=".$_GET['numeroordenpago']."&codigoestudiante=$this->codigoestudiante&codigoperiodo=$this->codigoperiodo"; ?>">PagarPse</a> -->


<input type="submit" value="Crear Orden" name="crear">

<?php
if (isset($_POST['crear']))
  { 
   $ordenjoda = new Ordenpago($sala, $codigoestudiante, $codigoperiodo, $numeroordenpago, $idprematricula=1, $fechaentregaordenpago=0, $codigoestadoordenpago=70);
  }
?>
</form>

</p>

</body>
</html>
<script language="javascript">
	function anularoorden()
	{
		if(confirm("¿Esta seguro de anular esta orden de pago?"))
		{
			//window.open('editardocente.php".$dirini."&grupo1=".$codigogrupo."&idgrupo1=".$idgrupo."','miventana','width=500,height=400,left=150,top=100,scrollbars=yes')
			window.open("anularordenprematricula.php<?php echo "?numeroordenpago=".$_GET['numeroordenpago']."&codigoestudiante=".$_GET['codigoestudiante']."&codigoperiodo=".$_GET['codigoperiodo']."&documentoingreso=".$row_seldocumento['numerodocumento']."";?>","miventana","width=500,height=400,left=150,top=100,scrollbars=yes");
		}
	}
</script>