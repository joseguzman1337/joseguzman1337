<?php
session_start();
ini_set('memory_limit', '256M');
ini_set('max_execution_time','216000');
if($_SESSION['usuario']<>"admintecnologia" && $_SESSION['usuario'] <> "coordinadorsisinfo")
{

	echo "<h1>Usted no tiene permiso para ver esta página</h1>";
	echo '<script language="javascript">alert("No se puede continuar")</script>';
	echo '<script language="javascript">reCarga("menuSQL.php")</script>';
	exit();
}
$rutaado=("../../../funciones/adodb/");
require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/clases/motor/motor_mod.php");
require_once("../../../funciones/clases/debug/SADebug.php");
require_once("funciones/paginador.php");
?>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
<script type="text/javascript" src="../../../funciones/javascript/funciones_javascript.js"></script>
<style type="text/css">@import url(../../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-setup.js"></script><script type="text/javascript" src="../../../funciones/clases/formulario/globo.js"></script>

<style>
    .sa_trace_start_link, .sa_trace_start_link:hover
    {
    color: lime;
        text-decoration: none;
    }    
    .sa_trace_start 
    {        
        padding: 2px;
        text-align: center;
        background-color: black;
        font-family: helvetica, arial, sans-serif;
        font-size: 12px;
        font-weight: bold;
    }
    .sa_trace_dump 
    {
        border: solid;
        border-color: lime;
        padding: 20px;
        position: absolute;
        background-color: black;
        font-family: helvetica, arial, sans-serif;
        font-size: 12px;
        visibility: hidden;
        color: lime;        
    }
    .sa_trace_end 
    {
        font-family: helvetica, arial, sans-serif;
        font-size: 12px;
        font-weight: bold;        
    }    
    </style>    
      
      <script language="JavaScript" type="text/JavaScript">
      <!--

      function MM_toggleVisibility(objName)
      {
      	var obj = MM_findObj(objName);
      	return (obj.style.visibility == 'visible') ? 'hidden' : 'visible';
      }

      function MM_findObj(n, d) {
      	var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
      		d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
      		if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
      		for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
      		if(!x && d.getElementById) x=d.getElementById(n); return x;
      }

      function MM_changeProp(objName,x,theProp,theValue) {
      	var obj = MM_findObj(objName);
      	if (obj && (theProp.indexOf("style.")==-1 || obj.style)){
      		if (theValue == true || theValue == false)
      		eval("obj."+theProp+"="+theValue);
      		else eval("obj."+theProp+"='"+theValue+"'");
      	}
      }
      -->
    </script>      
    
<form name="form1" method="GET" action="">
<?php
ob_start();
define('ENABLE_DEBUG', true);
$link_origen=$_GET['link_origen'];
$ruta="/var/tmp/";
if($_SESSION['filasporpagina']<>"")
{
	$FilasPorPagina = $_SESSION['filasporpagina'];
}
else
{
	$FilasPorPagina=50;
}
if($_SESSION['sql']<>"")
{

	$query=stripslashes($_SESSION['sql']);
	if(ereg("UPDATE",$query) or ereg("update",$query))
	{
		echo "<h1>Usted no puede ejecutar cláusulas del tipo UPDATE</h1>";
		echo '<script language="javascript">alert("No se puede continuar")</script>';
		echo '<script language="javascript">reCarga("menuSQL.php")</script>';
		exit();
	}


	if(ereg("DELETE",$query) or ereg("delete",$query))
	{
		echo "<h1>Usted no puede ejecutar cláusulas del tipo DELETE</h1>";
		echo '<script language="javascript">alert("No se puede continuar")</script>';
		echo '<script language="javascript">reCarga("menuSQL.php")</script>';
		exit();
	}
	$count="SELECT COUNT(*) AS cant_filas";
	$subquery=split("FROM",$query);

	$query_cant_filas=$count." FROM ".$subquery[1];
	$operacionCantFilas=$sala->query($query_cant_filas);
	$row_operacionCantFilas=$operacionCantFilas->fetchRow();
	$CantidadFilasTabla=$row_operacionCantFilas['cant_filas'];

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

	$query=$query." LIMIT " . $pager->ObtenerPaginaInicio() . ", " . $FilasPorPagina;

	echo "<h3>",$query,"</h3><br>";
	$operacion=$sala->query($query);
	$row_operacion=$operacion->fetchRow();
	do
	{
		$array_interno[]=$row_operacion;
	}
	while($row_operacion=$operacion->fetchRow());
	$motor = new matriz($array_interno,$tabla,"listadoSQL.php?test","si","si","menuSQL.php");
	$motor->mostrar();
}
else
{
	echo "<h1>No ha escrito ningún query</h1>";
}
?>
</form>