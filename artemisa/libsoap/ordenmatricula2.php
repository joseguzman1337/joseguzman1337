<?php
session_start();
require_once('../../../Connections/sala2.php' );
require_once("../../funciones/funcionip.php");
require('../../../libsoap/class.getBank.php');

mysql_select_db($database_sala, $sala);

$codigoperiodo = $_SESSION['codigoperiodosesion'];

require("actualizarmatriculados.php");
if(!isset($_SESSION['codigo']))
{
?>
<style type="text/css">
<!--
.Estilo1 {font-weight: bold}
-->
</style>

	<script language="javascript">
	alert("Por seguridad su sesion ha sido cerrada, por favor reinicie.");
</script>

<?php
}
$codigoestudiante = $_SESSION['codigo'];
$odenpago = $_GET['ordenpago'];
session_register ("ordenpago");
$query_pazysalvo = "select p.idpazysalvoestudiante
from pazysalvoestudiante p, detallepazysalvoestudiante d, estudiante e
where e.codigoestudiante = '$codigoestudiante'
and p.idpazysalvoestudiante = d.idpazysalvoestudiante
and d.codigoestadopazysalvoestudiante like '1%'
and e.idestudiantegeneral = p.idestudiantegeneral";
$pazysalvo = mysql_db_query($database_sala,$query_pazysalvo) or die("$query_pazysalvo");
$totalRows_pazysalvo = mysql_num_rows($pazysalvo);
$row_pazysalvo = mysql_fetch_array($pazysalvo);
/*$pagina = $_SERVER['HTTP_REFERER'];
$inicio_pagina = strpos ($pagina, "?");
$dir = substr ($pagina, $inicio_pagina);
echo $dir;
*/
?>
<style type="text/css">
<!--
.Estilo1 {
	font-family: tahoma;
	font-size: x-small;
}
.Estilo2 {font-size: x-small}
.Estilo16 {
	font-size: 14px;
	font-weight: bold;
}
.Estilo17 {font-size: 16px}
.Estilo18 {
	color: #FFFFFF;
	font-weight: bold;
}
.Estilo19 {
	font-size: xx-small;
	font-weight: bold;
}
.Estilo20 {font-size: xx-small}
.Estilo21 {font-size: 12px}
-->
</style>
<?php
if(isset($_GET['porpagar']))
{
	$ordenpago = $_GET['ordenpago']."&porpagar";
}
else
{
	$ordenpago = $_GET['ordenpago'];
}
//echo $ordenpago; 
?>
<form name="form1" method="post" action="ordenmatricula2.php<?php echo "?ordenpago=$ordenpago&programausadopor=".$_GET['programausadopor'].""; ?>">
<div align="center">
<?php
if($_GET['programausadopor'] == "creditoycartera")
{
	if($totalRows_pazysalvo != "")
	{
?>
<input type="button" onClick="<?php 
	echo "window.open('../avisopazysalvoestudiante.php?prema','miventana','width=800,height=400,top=200,left=150')";
	?>" value="ESTUDIANTE CON DEUDA">
<?php
	}
}
?>

<p class="Estilo1 Estilo2 Estilo4 Estilo7 Estilo1"><strong>ORDEN MATRICULA</strong></p>
<span class="Estilo1 Estilo4 Estilo1">
<?php
//echo '<input type="hidden" name="ordenpago" value="'.$ordenpago.'">';
if ($_POST['terminar'])
{
	echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=matriculaautomaticaordenmatricula.php'>";
	//session_unregister('codigo');
	session_unregister('materias');
	exit();
}
if ($_POST['horarios'])
{
	echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=horariosseleccionados.php'>";
	exit();
}
if ($_POST['credito'])
{
	echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=solicitudcredito.php?ordenpago=$ordenpago'>";
	exit();
}
/*if ($_POST['cancelar'])
{
	$_POST['anular'] = false;
	$_POST['seguro'] = false;
	echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=ordenmatricula2.php".$dir."'>";
	exit();
}*/  
if ($_POST['anular'] == true)
{// 1 anular

?>
 &nbsp;
 </span>
<p class="Estilo1 Estilo4 Estilo1">&nbsp;</p>
    <table width="350" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
      <tr>
        <td  bgcolor="#607766"  class="Estilo1 Estilo4 Estilo1"> 
        <div align="center" class="Estilo18">UNIVERSIDAD EL BOSQUE            </div></td>
   </tr>
   <tr>
        <td  bgcolor="#C5D5D6" class="Estilo1 Estilo4 Estilo1"> 
          <div align="center">
            <p><font color="#000000"><strong>ESTA SEGURO DE ANULAR 
              ESTA <br>ORDEN DE PAGO ? </strong></font></p>
          </div>
          <div align="center"> 
            <p>              <input name="seguro" type="submit" id="seguro" value="Aceptar">
&nbsp;&nbsp;&nbsp; 
              <input name="cancelar" type="button" id="cancelar2" value="Cancelar" onClick="history.go(-1)">    
            </p>
        </div></td>
   </tr>
 </table>  
 <p class="Estilo1 Estilo4 Estilo1">&nbsp;&nbsp;
<?php
exit ();
}// 1 anular
if ($_POST['seguro'] == true)
{	   
?>      
  </p>
</div>
<span class="Estilo1 Estilo4 Estilo1">
<?php  
	$numerodeorden = $_GET['ordenpago'];
	//echo "EL n : $numerodeorden";
	$base1="update ordenpago set  codigoestadoordenpago = 20, fechaentregaordenpago = '".date("Y-m-d",time())."' 
	where codigoestudiante ='$codigoestudiante'
	and numeroordenpago = $numerodeorden"; 
	$sol1=mysql_db_query($database_sala,$base1) or die("$base1");	
	
	$query_seldetalleprematriculaorden = "select idprematricula, codigomateria, idgrupo, codigomateriaelectiva, codigotipodetalleprematricula, numeroordenpago
	from detalleprematricula 
	WHERE numeroordenpago = '$numerodeorden'";
	$seldetalleprematriculaorden = mysql_query($query_seldetalleprematriculaorden,$sala) or die("$query_seldetalleprematriculaorden"); 
	//$row_seldetalleprematriculacambiogrupo = mysql_fetch_array($seldetalleprematriculacambiogrupo);
	$totalRows_seldetalleprematriculaorden = mysql_num_rows($seldetalleprematriculaorden);
	if($totalRows_seldetalleprematriculaorden != "")
	{
		while($row_seldetalleprematriculaorden = mysql_fetch_array($seldetalleprematriculaorden))
		{
			$query_inslogdetalleprematricula = "INSERT INTO logdetalleprematricula(idprematricula, codigomateria, codigomateriaelectiva, codigoestadodetalleprematricula, codigotipodetalleprematricula, idgrupo, numeroordenpago, fechalogfechadetalleprematricula, usuario, ip) 
			VALUES('".$row_seldetalleprematriculaorden['idprematricula']."','".$row_seldetalleprematriculaorden['codigomateria']."','".$row_seldetalleprematriculaorden['codigomateriaelectiva']."','20','".$row_seldetalleprematriculaorden['codigotipodetalleprematricula']."','".$row_seldetalleprematriculaorden['idgrupo']."','".$row_seldetalleprematriculaorden['numeroordenpago']."','".date("Y-m-d H:i:s",time())."','".$_SESSION['MM_Username']."','".tomarip()."')"; 
			$inslogdetalleprematricula = mysql_query($query_inslogdetalleprematricula, $sala) or die("$query_inslogdetalleprematricula");		
		}
	}
	
	$base3="UPDATE detalleprematricula SET codigoestadodetalleprematricula = '20' 
	WHERE numeroordenpago = '$numerodeorden'"; 
	//echo "<br> $base3 <br>";
	$sol3=mysql_db_query($database_sala,$base3) or die("$base3");	
	
	/******************* CALCULO DEL SEMESTRE Y CREDITOS TOMADOS DE DETALLEPLANESTUDIO ****************************************/
	// 1. Selecciona las materias que tiene en detalleprematricula, sin electivas
	$usarcondetalleprematricula = true;
	require('calculocreditossemestre.php');
		
	$query_updprematricula = "UPDATE prematricula p 
	SET p.semestreprematricula='$semestrecalculado'
	WHERE p.codigoestudiante = '$codigoestudiante'
	and p.codigoperiodo = '$codigoperido'";
	//echo "<br>$query_updprematricula";
	$updprematricula = mysql_query($query_updprematricula,$sala) or die(mysql_error()); 
		
	/******************** FIN DE CALCULO SEMESTRE Y CREDITOS ***************************************/
	
	// Actualiza los matriculados de todos los grupos
	$base2="select idgrupo 
	from detalleprematricula d
	where d.numeroordenpago = '$numerodeorden'"; 
	$sol2=mysql_db_query($database_sala,$base2) or die(mysql_error());	
	while($row_sol2=mysql_fetch_array($sol2))
	{
		$idgrupo = $row_sol2['idgrupo'];
		actualizarmatriculados($idgrupo, $codigoperiodo, $codigocarrera, $sala);			
	}
	
	//echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=prematricula.php'>";
	//exit();
	echo '<script language="javascript">
	location.reload("matriculaautomaticaordenmatricula.php?programausadopor='.$_GET['programausadopor'].'");
	</script>';
}
/////////////////////////////////////////////////  valores
$query_prematriculaestudiante= "SELECT p.idprematricula, o.numeroordenpago, o.fechaordenpago, 
e.numerocohorte, e.codigocarrera, p.semestreprematricula, e.codigoperiodo,
concat(eg.nombresestudiantegeneral,' ',eg.apellidosestudiantegeneral) as nombre, c.nombrecarrera, 
e.codigotipoestudiante, e.codigoestudiante, eg.numerodocumento
FROM prematricula p, estudiante e, carrera c, ordenpago o, estudiantegeneral eg
WHERE p.codigoestudiante = '$codigoestudiante'
AND o.numeroordenpago = '".$_GET['ordenpago']."'
AND e.codigoestudiante  = p.codigoestudiante
AND e.codigocarrera=c.codigocarrera 
AND p.idprematricula = o.idprematricula
and eg.idestudiantegeneral = e.idestudiantegeneral";
       
$prematriculaestudiante=mysql_db_query($database_sala,$query_prematriculaestudiante) or die("$query_prematriculaestudiante".mysql_error());
$totalRows_prematriculaestudiante = mysql_num_rows($prematriculaestudiante);
$row_prematriculaestudiante = mysql_fetch_array($prematriculaestudiante);
?>
</span>
  <table width="631" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
    <tr bgcolor="#C5D5D6"> 
      <td width="117" class="Estilo1 Estilo4 Estilo1"> <div align="center" class="Estilo19 Estilo20">No. Orden</div></td>
      <td width="229" class="Estilo1 Estilo4 Estilo1"> <div align="center" class="Estilo19">No.Prematricula</div></td>
      <td width="261" class="Estilo1 Estilo4 Estilo1"> <div align="center" class="Estilo19">Carrera 
      </div></td>
    </tr>
    <tr> 
      <td class="Estilo1 Estilo4 Estilo1"><div align="center"><span class="Estilo6"><?php echo $row_prematriculaestudiante['numeroordenpago'];?></span></div></td>
      <td class="Estilo1 Estilo4 Estilo1"><div align="center"><?php echo $row_prematriculaestudiante['idprematricula'];?></div></td>
      <td class="Estilo1 Estilo4 Estilo1"><div align="center"><span class="Estilo6"><?php echo $row_prematriculaestudiante['nombrecarrera'];?></span></div></td>
    </tr>
    <tr bgcolor="#C5D5D6"> 
      <td class="Estilo1 Estilo4 Estilo1"> <div align="center" class="Estilo20"><strong>Fecha </strong></div></td>
      <td class="Estilo1 Estilo4 Estilo1"><div align="center" class="Estilo20"><strong>Documento</strong></div></td>
      <td class="Estilo1 Estilo4 Estilo1"> <div align="center" class="Estilo20"><strong>Nombre 
      Estudiante </strong></div></td>
    </tr>
    <tr> 
      <td class="Estilo1 Estilo4 Estilo1"><div align="center"><span class="Estilo6"><?php echo $row_prematriculaestudiante['fechaordenpago'];?></span></div></td>
      <td class="Estilo1 Estilo4 Estilo1"><div align="center"><span class="Estilo6"><?php echo $row_prematriculaestudiante['numerodocumento'];?></span></div></td>
      <td class="Estilo1 Estilo4 Estilo1"><div align="center"><span class="Estilo6"><?php echo $row_prematriculaestudiante['nombre'];?></span></div></td>
    </tr>
    <tr bordercolor="#336633"> 
      <td colspan="3" class="Estilo1 Estilo4 Estilo1"> <div align="center"><strong>DETALLE 
          MATRICULA </strong></div></td>
	 </tr>
    <tr bgcolor="#C5D5D6"> 
      <td class="Estilo1 Estilo4 Estilo1"> <div align="center" class="Estilo20"><strong>C&oacute;digo 
      del Concepto </strong></div></td>
      <td class="Estilo1 Estilo4 Estilo1"> <div align="center" class="Estilo20"><strong>Concepto</strong></div></td>
      <td class="Estilo1 Estilo4 Estilo1"> <div align="center" class="Estilo20"><strong>Valor</strong></div></td>
    </tr>
  </table>
  <span class="Estilo4 Estilo1">
<?php 
$banderadeudas = 0; 
$deuda="SELECT * 
FROM detalleordenpago d,concepto c,tipoconcepto t
WHERE d.numeroordenpago = '".$row_prematriculaestudiante['numeroordenpago']."'
AND d.codigoconcepto = c.codigoconcepto
AND c.codigotipoconcepto = t.codigotipoconcepto";	
$query=mysql_db_query($database_sala,$deuda);     
$solucion=mysql_fetch_array($query);  
$fechaconpecuniarios = false;
do
{  
	if($solucion['codigotipodetalleordenpago'] == '2' )//&& $solucion['codigotipoconcepto'] == '01')
	{
		$banderadeudas = 1;
	}	
	if($solucion['codigotipodetalleordenpago'] == '3' )//&& $solucion['codigotipoconcepto'] == '01')
	{
		$fechaconpecuniarios = true;
	}
?>
  </span>
  <table width="631" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
    <tr>
    <td width="117" class="Estilo4 Estilo1"><div align="center"><span class="Estilo6"><strong><strong><?php echo $solucion['codigoconcepto'];?></strong></strong></span></div></td>
    <td width="229" class="Estilo4 Estilo1"><div align="left"><span class="Estilo6"><strong><?php echo $solucion['nombreconcepto'];
	if($solucion['codigotipoconcepto'] == 01)
	{
		echo "(+)";
	}	
	if($solucion['codigotipoconcepto'] == 02)
	{
		echo "(-)";
	}
?>
	<span class="Estilo8 Estilo20"> </span></strong></span></div></td>
    <td width="261" class="Estilo4 Estilo1"><div align="center"><span class="Estilo6">$&nbsp;&nbsp;<?php echo number_format($solucion['valorconcepto'],2);?></span></div></td>
  </tr>
</table>	 
  <span class="Estilo4 Estilo1">
<?php	 
}
while ($solucion=mysql_fetch_array($query));
?>
  </span>
  <table width="631" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
    <tr bordercolor="#006600"> 
      <td colspan="4" class="Estilo4 Estilo1"> 
        <div align="center"><strong>FECHAS DE PAGO</strong></div></td>
  </tr>
  <tr bgcolor="#C5D5D6">
      <td width="232" class="Estilo4 Estilo1">
<div align="center"><strong>Tipo de Matricula </strong></div></td>
      <td width="200" class="Estilo4 Estilo1">
<div align="center"><strong>Paguese Hasta </strong></div></td>      
      <td width="175" class="Estilo4 Estilo1">
<div align="center"><strong>Total a Pagar </strong></div></td>
  </tr>
</table>
  <span class="Estilo1">
<?php 
$ordendepago = $_GET['ordenpago'];
$fecha="select distinct f.fechaordenpago, f.porcentajefechaordenpago, d.nombredetallefechafinanciera, f.valorfechaordenpago
from fechaordenpago f, detallefechafinanciera d
where f.fechaordenpago = d.fechadetallefechafinanciera
and f.porcentajefechaordenpago = d.porcentajedetallefechafinanciera
and f.numeroordenpago = '$ordendepago'
order by f.porcentajefechaordenpago";					
//echo "$fecha <br>";
$queryfechas=mysql_db_query($database_sala,$fecha);     
$fechas=mysql_fetch_array($queryfechas);
if($fechas == "")
{
	$fecha="select distinct f.fechaordenpago, f.porcentajefechaordenpago, f.valorfechaordenpago
	from fechaordenpago f
	where f.numeroordenpago = '$ordendepago'
	order by f.porcentajefechaordenpago";					
	//echo "$fecha <br>";
	$queryfechas=mysql_db_query($database_sala,$fecha);     
	$fechas=mysql_fetch_array($queryfechas);
	$fechas['nombredetallefechafinanciera'] = "Pago 1";
}
do
{
?>
  </span>
  <table width="631" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#FF9900">
    <tr>
    <td width="232" class="Estilo4 Estilo1"><div align="center"><span class="Estilo6"><?php echo $fechas['nombredetallefechafinanciera'];?></span></div></td>
    <td width="200" class="Estilo4 Estilo1"><div align="center"><span class="Estilo6"><?php echo $fechas['fechaordenpago'];?></span></div></td>
    <td width="175" class="Estilo4 Estilo1"><div align="center"><span class="Estilo6">$&nbsp;<?php echo number_format($fechas['valorfechaordenpago'],2);?></span></div></td>
  </tr>
</table>  
<?php
	$contadorfechas ++;
}
while($fechas=mysql_fetch_array($queryfechas));
?>
  <table width="631" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
    <tr>
      <td colspan="4" class="Estilo4 Estilo1"> 
        <div align="center"><strong>CUENTAS BANCARIAS </strong></div></td>
    </tr>
    <tr bgcolor="#C5D5D6">
      <td width="145" class="Estilo4 Estilo1"><div align="center"><strong>C&oacute;digo Banco </strong></div></td>
      <td width="295" class="Estilo4 Estilo1"><div align="center"><strong>Nombre Banco </strong></div></td>
      <td width="169" class="Estilo4 Estilo1"><div align="center"><strong>Cuenta Banco </strong></div></td>
    </tr>
  </table>
<?php
$banco="SELECT *
FROM cuentabanco c,banco b
WHERE c.codigocarrera = '".$row_prematriculaestudiante['codigocarrera']."'
AND c.codigobanco = b.codigobanco
AND c.codigoperiodo = '".$_SESSION['codigoperiodosesion']."'
order by 4 desc";
$banco5=mysql_db_query($database_sala,$banco);     
$bancos=mysql_fetch_array($banco5);

if(! $bancos)
{
	$banco="SELECT *
	FROM cuentabanco c, banco b
	WHERE  c.codigobanco = b.codigobanco
	AND c.codigoperiodo = '".$_SESSION['codigoperiodosesion']."'
	AND codigocarrera = '1'
	order by 4 desc";	
	$banco5=mysql_db_query($database_sala,$banco);     
 	$bancos=mysql_fetch_array($banco5); 
}
//echo "<br>$banco";	

do
{
?>
  </span>
  <table width="631" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#FF9900">
    <tr>
    <td width="146" class="Estilo4 Estilo1 Estilo8  Estilo12"><div align="center"><span class="Estilo6"><?php echo $bancos['codigobanco'];?></span></div></td>
    <td width="295" class="Estilo4 Estilo1 Estilo8  Estilo12"><div align="center"><span class="Estilo6"><?php echo $bancos['nombrebanco'];?></span></div></td>
    <td width="168" class="Estilo4 Estilo1 Estilo8  Estilo12"><div align="center"><span class="Estilo6"><?php echo $bancos['numerocuentabanco'];?> </span></div></td>   
  </tr>
</table>
<?php
}
while($bancos=mysql_fetch_array($banco5));
?>
  <table width="631" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
    <tr>
      <td bordercolor="#006600" class="Estilo4 Estilo1"> 
        <div align="center">
          <p><strong> NOTA:&nbsp;&nbsp;
<?php
if($banderadeudas == 1)
{
	echo "ANTES DE RECLAMAR SU ORDEN DE PAGO DIRIJASE A EL DEPARTAMENTO DE CRÉDITO Y CARTERA";
}
else
{
	echo "DIRIJASE A EL DEPARTAMENTO DE CRÉDITO Y CARTERA Y RECLAME SU ORDEN DE PAGO";
//echo "DIRIJASE A SU FACULTAD Y RECLAME SU ORDEN DE PAGO EL DIA &nbsp;",$row2['fechainicialentregaordenpago'] ;
}
?>
</strong></p>
          <p class="Estilo16 Estilo17"> DOCUMENTO NO VALIDO PARA PAGO</p>
          <p class="Estilo16 Estilo21"><font color="RED">Le recomendamos cambiar su clave de correo por su seguridad.</font></p>
        </div></td>
    </tr>
</table>
<p align="center" class="Estilo1">
<?php
if($_GET['programausadopor'] == "creditoycartera")
{
	if($_GET['imprimeorden'] == "02" && $totalRows_pazysalvo != "")
	{
		//echo "No se le imprime orden de pago debido a que solicito crédito y tiene deuda";
?>
<input name="imprimir" type="button" id="imprimir" value="Imprimir" onClick="alert('No se le imprime orden de pago debido a que solicito crédito y tiene deuda')">&nbsp;&nbsp;&nbsp;&nbsp; 
<?php
	}
	else if($_GET['imprimeorden'] == "02")
	{
		//echo "No se le imprime orden de pago debido a que solicito crédito";
?>
<input name="imprimir" type="button" id="imprimir" value="Imprimir" onClick="alert('No se le imprime orden de pago debido a que solicito crédito')">&nbsp;&nbsp;&nbsp;&nbsp; 
<?php
	}
	else if($totalRows_pazysalvo != "")
	{
		//echo "Impre ".$_GET['imprimeorden']."<br>";
		//echo "No se le imprime orden de pago debido a que tiene deuda";
?>
<input name="imprimir" type="button" id="imprimir" value="Imprimir" onClick="alert('No se le imprime orden de pago debido a que tiene deuda')">&nbsp;&nbsp;&nbsp;&nbsp; 
<?php
	}
	else 
	{
		//echo "Permitido"; 
?>
<input name="imprimir" type="button" id="imprimir" value="Imprimir" onClick="window.location.reload('impresion.php<?php echo "?ordenpago=$ordenpago&programausadopor=".$_GET['programausadopor']."&estudiante=".$_GET['estudiante'].""; ?>')">&nbsp;&nbsp;&nbsp;&nbsp; 
<?php
	}
}
else
{
?> 
<input name="imprimir" type="button" id="imprimir" value="Imprimir" onClick="window.print()">&nbsp;&nbsp; 
<?php
}
?>
<input name="regresar" type="button" id="imprimir" value="Regresar" onClick="window.location.reload('matriculaautomaticaordenmatricula.php<?php echo "?programausadopor=".$_GET['programausadopor'].""; ?>')">&nbsp;&nbsp; &nbsp;&nbsp;
<?php
//echo "<br>".$_GET['programausadopor'];
$anularorden = true;
if(isset($_GET['porpagar']))
{
	if($_GET['programausadopor'] == "estudiante" || $_GET['programausadopor'] == "facultad")
	{
		//Cuenta el numero de ordenes mayores anuladas despues de la fecha activa de la prematricula
		if($_GET['programausadopor'] == "estudiante")
		{
			$fecha= "select * from fechaacademica f 
			where f.codigocarrera = '".$row_prematriculaestudiante['codigocarrera']."'
			and f.codigoperiodo = '".$_SESSION['codigoperiodosesion']."'";
			$db=mysql_query($fecha, $sala) or die("$fecha");
			$total = mysql_num_rows($db);
			$resultado=mysql_fetch_array($db);
			
			$query_selordenanulada="select numeroordenpago 
			from ordenpago 
			where codigoestadoordenpago like '2%' 
			and fechaentregaordenpago >= '".$resultado['fechainicialprematricula']."' 
			and codigoestudiante = '".$row_prematriculaestudiante['codigoestudiante']."'"; 
			$selordenanulada = mysql_db_query($database_sala,$query_selordenanulada) or die("$query_selordenanulada");	
			if($totalRows_selordenanulada >= 5)
			{
				$anularorden = false;
			}
			$query_selorden="select numeroordenpago, codigocopiaordenpago 
			from ordenpago 
			where codigoestadoordenpago like '1%' 
			and fechaentregaordenpago >= '".$resultado['fechainicialprematricula']."' 
			and codigoestudiante = '".$row_prematriculaestudiante['codigoestudiante']."'"; 
			$selorden = mysql_db_query($database_sala,$query_selorden) or die("$query_selorden");	
			while($row_selorden = mysql_fetch_array($selorden))
			{
				if($row_selorden['codigocopiaordenpago'] == 200)
				{
					$anularorden = false;
				}
			}			
		} 
		/*echo date("Y-m-d",time());
		echo "<br>";
		echo $row9['fechaordenpago'];*/
		if($_GET['programausadopor'] != "estudianterestringido")
		{
			if($_GET['programausadopor'] != "creditoycartera")
			{
				if($_GET['programausadopor'] == "estudiante")
				{
					echo '<script language="javascript">
					alert("Tiene '.$totalRows_selorden.' ordenes anuladas, recuerde que maximo puede anular cinco");
					</script>';
					if($anularorden)
					{
?> 
 <input name="anular" type="submit" id="anular" value="Anular Orden de Matricula">
 
<?php				
					}
				}
				else
				{
?>
 <input name="anular" type="submit" id="anular" value="Anular Orden de Matricula">
<?php		
				}
			}
		}
	}
}
?>
</p>
 <p align="center" class="Estilo1">&nbsp;</p>
</form>
<?php
 if ($_GET['i'] == 1){
?>
<form name="form2" method="post" action="../../../libsoap/class.sendws.php">
  <?php getBankList() ?>
  <input name="txtValor" type="hidden" value="<?= $_GET['valor'] ?>">
  <input name="txtReference1" type="hidden" value="<?= $_GET['ordenpago'] ?>">
  <input name="txtReference2" type="hidden" value="<?= $row_prematriculaestudiante['numerodocumento'] ?>">
  <input type="submit" name="enviar" value="Pagar">
</form>
<?php
}
?>

