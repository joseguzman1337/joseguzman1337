<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
session_start();
if($_SESSION['MM_Username']<>'admintecnologia'){
	echo "<h1>Usted no está autorizado para ver esta página";
	exit();
}

if($_SESSION['filasporpagina']<>"")
{
	$FilasPorPagina = $_SESSION['filasporpagina'];
}
else
{
	$FilasPorPagina=50;
}
?>
<form name="formulario" id="formulario" method="GET">
<strong>Digite usuario:</strong>
<input type="text" name="usuario" value="<?php echo $_GET['usuario']?>"><br>
<input type="submit" name="Enviar" value="Enviar" id="Enviar">
</form>
<?php
$rutaado=("../../../funciones/adodb/");
require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/clases/motorv2/motor.php");
require_once("../../../funciones/clases/motorv2/paginador.php");
require_once('../../../funciones/clases/autenticacion/redirect.php');
//obtener cantidad filas
$tabla="logactividadusuario";
if(empty($_GET['usuario'])){
	$query_cant_filas="SELECT COUNT(*) AS cant_filas FROM $tabla";
}
else{
	$query_cant_filas="SELECT COUNT(*) AS cant_filas FROM $tabla INNER JOIN usuario ON usuario.idusuario = $tabla.idusuario WHERE usuario='".$_GET['usuario']."'";
}

$operacionCantFilas=$sala->query($query_cant_filas);
$row_operacionCantFilas=$operacionCantFilas->fetchRow();
$CantidadFilasTabla=$row_operacionCantFilas['cant_filas'];
echo "<br>Cantidad de filas de toda la tabla: ".$CantidadFilasTabla."<br>";
// Poner pagina por defecto
if (!isset($_GET['pagina']))
{
	$_GET['pagina'] = 1;
}
//instanciar paginador
$pager = new Paginador($FilasPorPagina, $CantidadFilasTabla,$_GET['pagina']);
//html para el paginador
echo "<table align=\"center\">\n<tr>\n";
for ($i = 1; $i <= $pager->ObtenerTotalPaginas(); $i++)
{
	echo "<td><a href=\"" . $_SERVER['PHP_SELF'] . "?pagina=$i&tabla=$tabla&link_origen=$link_origen\">";
	if ($i == $_GET['pagina'])
	{
		echo "<strong>$i</strong>";
	}
	else
	{
		echo $i;
	}
	echo "</a></td>\n";
}
echo "</tr>\n</table>\n";

if(empty($_GET['usuario'])){
	$query="SELECT usuario.usuario, $tabla.* FROM $tabla INNER JOIN usuario ON $tabla.idusuario = usuario.idusuario LIMIT " . $pager->ObtenerPaginaInicio() . ", " . $FilasPorPagina;
}
else{
	$query="SELECT usuario.usuario, $tabla.* FROM $tabla INNER JOIN usuario ON $tabla.idusuario = usuario.idusuario WHERE usuario='".$_GET['usuario']."' LIMIT " . $pager->ObtenerPaginaInicio() . ", " . $FilasPorPagina;
}

$operacion=$sala->query($query);
$row_operacion=$operacion->fetchRow();
do
{
	$array_interno[]=$row_operacion;
}
while($row_operacion=$operacion->fetchRow());
$arreglo_titulo=$array_interno;


?>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
<script type="text/javascript" src="../../../funciones/javascript/funciones_javascript.js"></script>
<style type="text/css">@import url(../../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-setup.js"></script><script type="text/javascript" src="../../../funciones/clases/formulario/globo.js"></script>
<script language="javascript">
function recargar(){
	document.getElementById('formulario').submit();
}
</script>
<?php
$informe=new matriz($arreglo_titulo,"LOG ACTIVIDAD USUARIO","logActividadUsuario.php","si","no","menu.php",'',false);
$informe->botonRegresar=false;
$informe->botonRecargar=false;
$informe->mostrarTitulo=true;
$informe->mostrar();
?>