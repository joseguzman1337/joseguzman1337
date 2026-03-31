<?php
require_once('../../../../Connections/sala2.php');
require_once("../../../../funciones/validacion.php");
require_once("../../../../funciones/errores_plandeestudio.php");
require("../funcionesequivalencias.php");
require("./funciones.php");

mysql_select_db($database_sala, $sala);
session_start();
//require_once('seguridadplandeestudio.php');
if(isset($_GET['planestudio']))
{
	$idplanestudio = $_GET['planestudio'];
	// Para las materias que no son lineas de enfasis
	$idlineaenfasis = 1;
	$estaEnenfasis = "no";
	$idlineamodificar = 1;
}
$formulariovalido = 1;
?>
<html>
<head>
<title>Reporte por materias por semestre</title>

<style type="text/css">
<!--
.Estilo1 {
	font-family: Tahoma;
	font-size: x-small;
}
.Estilo2 {
	font-family: sans-serif;
	font-size: 9px;
	text-align: center;
}
.Estilo3 {
	font-family: sans-serif;
	font-size: 9px;
	width: 9px;
}

table table div{
    font-size: 8px;
    width:100%;font-weight: bold;
}
-->
</style>

<script language="javascript">
function recargar(dir)
{
	window.location.href="reporteporsemestre.php?"+dir;
	//history.go();
}
</script>
<script type="text/javascript" language="javascript" src="../../../../mgi/js/jquery.js"></script>
<script type="text/javascript" language="javascript" src="../../../../mgi/js/jquery-ui-1.8.21.custom.min.js"></script> 

<?php
echo'<script language="javascript">
function recargar2(dir)
{
	//alert("Va a hacer algo");
	window.location.href="../../materiasgrupos/detallesmateria.php"+dir+"&planestudio='.$idplanestudio.'&visualizado";
}
</script>';
?>
</head>
<body>
<div align="center" >

<?php
// Selecciona toda la informacion del plan de estudio
$query_planestudio = getQueryPlanEstudio($idplanestudio);
$planestudio = mysql_query($query_planestudio, $sala) or die("$query_planestudio");
$row_planestudio = mysql_fetch_assoc($planestudio);
$totalRows_planestudio = mysql_num_rows($planestudio);
if(!isset($_GET['tipodereferencia']) && !isset($_POST['tipodereferencia']))
{
        $reporteporsemestre = true;   

        $queryperiodo = "select codigoperiodo from periodo where now() between fechainicioperiodo and fechavencimientoperiodo";
        $codperiodo = mysql_query($queryperiodo, $sala) or die("$queryperiodo");
        $row_periodo = mysql_fetch_assoc($codperiodo);
        $codigoperiodo = $row_periodo["codigoperiodo"];
        
	require_once("pensumseleccionreferencia.php");
}?>
</div>

<form action="convertToPdf.php" name="myFormPDF" method="post" target="MYPOPUPPDF">
<input id="htmlText" type="hidden" value="" name="html">
</form>
    
<form action="../../registro_graduados/carta_egresados/imprimirReporteElectivasPendientes.php" name="myFormExcel" id="myFormExcel" method="post">
<input id="htmlText2" type="hidden" value="" name="datos_a_enviar">
</form>
</body>

<script language="javascript">
//Mueve las opciones seleccionadas en listaFuente a listaDestino
function regresarinicio()
{
	window.location.href="planestudiomodalidad.php"
}

function limpiarinicio(texto)
{
	if(texto.value == "aaaa-mm-dd")
		texto.value = "";
}

function limpiarvencimiento(texto)
{
	if(texto.value == "2999-12-31")
		texto.value = "";
}

function iniciarinicio(texto)
{
	if(texto.value == "")
		texto.value = "aaaa-mm-dd";
}

function iniciarvencimiento(texto)
{
	if(texto.value == "")
		texto.value = "2999-12-31";
}
function habilitar(campo)
{
	var entro = false;
	for (i = 0; i < campo.length; i++)
	{
		campo[i].disabled = false;
		entro = true;
	}
	if(!entro)
	{
		f1.habilita.disabled = false;
	}
}


function exportarPDF(){
        //var archivos = new Array();
        var html = $("#tableDiv").html();
        $("#htmlText").val(html);
        //popup_carga("./convertToPdf.php?reporte=&usuario=&html="+html);
        var centerWidth = (window.screen.width - 850) / 2;
        var centerHeight = (window.screen.height - 700) / 2;
        var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=850, height=700, top="+centerHeight+", left="+centerWidth;
        var mypopup = window.open("","MYPOPUPPDF",opciones);
        //win = window.open('','myWin','toolbars=0');
        document.myFormPDF.target='MYPOPUPPDF';
        document.myFormPDF.submit();
}

function esxportarExcel(){        
        //$("#htmlText2").val($("#tableDiv").append( $("table").eq(1).clone()).html());
        $("#htmlText2").val($("#tableDiv").html());
        document.myFormExcel.submit();
}

</script>
</html>
