<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
     
require_once('../../../../Connections/sala2.php');session_start();?>
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
-->
</style>
<form name="form1" method="post" action="consultaordenmatricula.php">
<div align="center">
<?php

if ($_POST['horarios'])
{
echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=consultahorariosseleccionados.php'>";
exit();
}
?>
<p align="center" class="Estilo1 Estilo2 Estilo4 Estilo7 Estilo1"><strong>ORDEN MATRICULA</strong></p>
<span class="Estilo1 Estilo4 Estilo1">
<?php
if ($_POST['terminar'])
{
echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=consultapre.php'>";
session_unregister('codigoestudiante');
exit();
}
?>
<?php 

/////////////////////////////////////////////////  valores  
 
      $base9= "SELECT p.idprematricula,o.numeroordenpago,e.numerocohorte,e.codigocarrera,p.semestreprematricula,e.codigoperiodo,e.nombresestudiante,e.apellidosestudiante,c.nombrecarrera,p.totalcreditossemestre,e.codigotipoestudiante,e.codigoestudiante
	           FROM prematricula p ,estudiante e,carrera c,ordenpago o
	           WHERE p.codigoestudiante = '".$_SESSION['codigoestudiante']."'
			   AND p.codigoestadoprematricula LIKE '1%'
			   AND e.codigoestudiante  = p.codigoestudiante
			   AND e.codigocarrera=c.codigocarrera 
			   AND p.idprematricula = o.idprematricula";
       
	   $sol9=mysql_db_query($database_sala,$base9);
	   $totalRows9 = mysql_num_rows($sol9);
       $row9=mysql_fetch_array($sol9);
if (!$row9)
{
echo "<p align='center'class='Estilo1 Estilo2 Estilo4 Estilo7 Estilo1'><strong>No presenta prematriculas activas</strong></p>";
echo "<META HTTP-EQUIV='Refresh' CONTENT='2; URL=consultapre.php'>";
}
else
{
?>
<?php
$base2= "SELECT cre.totalcreditossemestre,d.valordetallecohorte,e.fechainicialentregaordenpago,d.codigoconcepto 
FROM cohorte c,detallecohorte d,periodo p,creditossemestrenovasoft cre,fechaacademica e 
WHERE c.numerocohorte = '".$row9['numerocohorte']."'
AND c.codigocarrera = '".$row9['codigocarrera']."'
AND p.codigoestadoperiodo = 1
AND c.codigoperiodo = p.codigoperiodo 
AND c.codigoestadocohorte = 01
AND c.idcohorte = d.idcohorte 
AND d.semestredetallecohorte = '".$row9['semestreprematricula']."'
AND cre.semestre = '".$row9['semestreprematricula']."'
AND cre.codigocarrera = '".$row9['codigocarrera']."'
and e.codigocarrera = '".$row9['codigocarrera']."'";
 $sol2=mysql_db_query($database_sala,$base2) or die (mysql_error());
 $totalRows2= mysql_num_rows($sol2);
 $row2=mysql_fetch_array($sol2);

 /////////////////////////////////////////////////////// Calculo Valor 
   
   $porcentajecreditos=$row9['totalcreditossemestre'] * 100 / $row2['totalcreditossemestre'];	
	if ($porcentajecreditos <= 100 )
	{
	 $base3="SELECT cm.porcentajecobromatricula 
	         from cobromatricula cm 
	         where  cm.porcentajecreditosdesde <= '".$porcentajecreditos."' 
			 and cm.porcentajecreditoshasta >= '".$porcentajecreditos."'";	
	
	 $sol3=mysql_db_query($database_sala,$base3);
     $totalRows3= mysql_num_rows($sol3);
     $row3=mysql_fetch_array($sol3);  
	 }
	 else
	 {
	   $row3['porcentajecobromatricula'] = 100;
	 } 	 
	$valormatricula = $row3['porcentajecobromatricula'] * $row2['valordetallecohorte'] / 100;	  
	 
	 if ($porcentajecreditos > 100)
	 {
	  $valormatricula= $row2['valordetallecohorte'] + ($row2['valordetallecohorte'] / $row2['totalcreditossemestre'] * ( $row9['totalcreditossemestre'] - $row2['totalcreditossemestre']));
	 }
	  
?>
</span>
  <table width="631" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
    <tr bgcolor="#C5D5D6"> 
      <td width="70" class="Estilo1 Estilo4 Estilo1"> <div align="center" class="Estilo19 Estilo20">No. Orden</div></td>
      <td width="106" class="Estilo1 Estilo4 Estilo1"> <div align="center" class="Estilo19">No.Prematricula</div></td>
      <td class="Estilo1 Estilo4 Estilo1"> <div align="center" class="Estilo19">Carrera 
      </div></td>
      <td width="161" class="Estilo1 Estilo4 Estilo1"> <div align="center" class="Estilo19">Cr&eacute;ditos 
      Seleccionados </div></td>
    </tr>
    <tr> 
      <td class="Estilo1 Estilo4 Estilo1"><div align="center"><span class="Estilo6"><?php echo $row9['numeroordenpago'];?></span></div></td>
      <td class="Estilo1 Estilo4 Estilo1"><div align="center"><?php echo $row9['idprematricula'];?></div></td>
      <td class="Estilo1 Estilo4 Estilo1"><div align="center"><span class="Estilo6"><?php echo $row9['nombrecarrera'];?></span></div></td>
      <td class="Estilo1 Estilo4 Estilo1"><div align="center"><?php echo $row9['totalcreditossemestre'];?></div></td>
    </tr>
    <tr bgcolor="#C5D5D6"> 
      <td class="Estilo1 Estilo4 Estilo1"> <div align="center" class="Estilo20"><strong>Fecha </strong></div></td>
      <td class="Estilo1 Estilo4 Estilo1"><div align="center" class="Estilo20"><strong>C&oacute;digo</strong></div></td>
      <td class="Estilo1 Estilo4 Estilo1"> <div align="center" class="Estilo20"><strong>Nombre 
      Estudiante </strong></div></td>
      <td class="Estilo1 Estilo4 Estilo1"> <div align="center" class="Estilo20"><strong>Semestre 
      </strong></div></td>
    </tr>
    <tr> 
      <td class="Estilo1 Estilo4 Estilo1"><div align="center"><span class="Estilo6"><?php echo date("Y-m-d",time());?></span></div></td>
      <td class="Estilo1 Estilo4 Estilo1"><div align="center"><span class="Estilo6"><?php echo $row9['codigoestudiante'];?></span></div></td>
      <td class="Estilo1 Estilo4 Estilo1"><div align="center"><span class="Estilo6"><?php echo $row9['nombresestudiante'];?></span>&nbsp;&nbsp;<?php echo $row9['apellidosestudiante'];?></div></td>
      <td class="Estilo1 Estilo4 Estilo1"><div align="center"><?php echo $row9['semestreprematricula'];?></div></td>
    </tr>
    <tr bgcolor="#C5D5D6"> 
      <td colspan="2" class="Estilo1 Estilo4 Estilo1"> <div align="center" class="Estilo20"><strong>Valor 
      Semestre</strong></div></td>
      <td class="Estilo4 Estilo1 Estilo20"><div align="center"></div> <div align="center"><strong>Valor Cr&eacute;ditos adicionales</strong></div></td>
      <td class="Estilo1 Estilo4 Estilo1"><div align="center" class="Estilo20"><strong>Cr&eacute;ditos</strong> <strong>Semestre</strong>          </div></td>
    </tr>
    <tr bordercolor="#336633">
      <td colspan="2" class="Estilo1 Estilo4 Estilo1"><div align="center">$&nbsp;&nbsp;&nbsp;
          <?php  echo number_format($row2['valordetallecohorte'],2);?>
</div></td>
      <td class="Estilo1 Estilo4 Estilo1"><div align="center">
<?php  $valoradicional=($row2['valordetallecohorte'] / $row2['totalcreditossemestre'] * ($row9['totalcreditossemestre'] -$row2['totalcreditossemestre']));
	         if ($valoradicional < 0)
	              {
				  $valoradicional=0;				  
				  } 
 ?>
$&nbsp;&nbsp;
<?php  
	  $valoradi=round($valoradicional,0);	  
	  echo number_format($valoradi,2);?>
</div></td>
      <td class="Estilo1 Estilo4 Estilo1"><div align="center"><?php echo $row2['totalcreditossemestre'];?></div></td>
    </tr>
    <tr bordercolor="#336633"> 
      <td colspan="4" class="Estilo1 Estilo4 Estilo1"> <div align="center"><strong>DETALLE 
          MATRICULA </strong></div></td>
    </tr>
    <tr bgcolor="#C5D5D6"> 
      <td colspan="2" class="Estilo1 Estilo4 Estilo1"> <div align="center" class="Estilo20"><strong>C&oacute;digo 
      del Concepto </strong></div></td>
      <td class="Estilo1 Estilo4 Estilo1"> <div align="center" class="Estilo20"><strong>Concepto</strong></div></td>
      <td class="Estilo1 Estilo4 Estilo1"> <div align="center" class="Estilo20"><strong>Valor</strong></div></td>
    </tr>
    <tr> 
      <td colspan="2" class="Estilo1 Estilo4 Estilo1"><div align="center"><strong><?php echo $row2['codigoconcepto']; ?></strong></div></td>
      <td class="Estilo1 Estilo4 Estilo1"> <div align="center" class="Estilo20">
        <div align="left"><strong>VALOR MATRICULA <span class="Estilo8">(+)</span></strong></div>
      </div></td>
      <td class="Estilo1 Estilo4 Estilo1"><div align="center"> $&nbsp;&nbsp;&nbsp; 
<?php  
	$totalvalormatricula=round($valormatricula,0);
	 echo  number_format($totalvalormatricula,2);
	 $recargototalvalormatricula=$totalvalormatricula;?>
          </div></td>
    </tr>
  </table>
  <span class="Estilo4 Estilo1">
<?php   
   $valorpecuniario= 0;
    $deuda2="SELECT * FROM valorpecuniario v,periodo p,concepto c	         
			 WHERE v.codigoaplicapecuniario = '".$row9['codigotipoestudiante']."'
			 and p.codigoestadoperiodo = 1
			 and p.codigoperiodo = v.codigoperiodo
			 and v.codigocarrera = '".$row9['codigocarrera']."'";	
	$query2=mysql_db_query($database_sala,$deuda2);     
    $solucion2=mysql_fetch_array($query2);  
  if (! $solucion2)
    {
	  $deuda2="SELECT v.valorpecuniario,c.nombreconcepto,v.codigoconcepto 
	           FROM valorpecuniario v,periodo p,concepto c	         
			   WHERE v.codigoaplicapecuniario = '".$row9['codigotipoestudiante']."'
			   and p.codigoestadoperiodo = 1
			   and p.codigoperiodo = v.codigoperiodo
			   and c.codigoconcepto = v.codigoconcepto";	
	  $query2=mysql_db_query($database_sala,$deuda2);     
      $solucion2=mysql_fetch_array($query2);
	} 
	 do { 
	  $totalvalormatricula = $totalvalormatricula + $solucion2['valorpecuniario'];
	  $valorpecuniario = $valorpecuniario+$solucion2['valorpecuniario']
?>
  </span>
  <table width="631" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
    <tr>
    <td width="184" class="Estilo4 Estilo1"><div align="center"><span class="Estilo6"><strong><strong><?php echo $solucion2['codigoconcepto'];?></strong></strong></span></div></td>
    <td width="265" class="Estilo4 Estilo1"><div align="left"><span class="Estilo6"><strong><?php echo $solucion2['nombreconcepto'];?><span class="Estilo8 Estilo20"> (+) </span></strong></span></div></td>
    <td width="160" class="Estilo4 Estilo1"><div align="center"><span class="Estilo6">$&nbsp;&nbsp;<?php echo number_format($solucion2['valorpecuniario'],2);?></span></div></td>
  </tr>
</table>	 
  <span class="Estilo4 Estilo1">
<?php	 
	}while ($solucion2=mysql_fetch_array($query2));
?>
<?php 
    $descuento = 0;
	$deuda="SELECT * FROM descuentovsdeuda
            WHERE codigoestudiante = '".$_POST['codigo']."'
			and codigoestadodescuentovsdeuda = 01";	
	$query=mysql_db_query($database_sala,$deuda);     
    $solucion=mysql_fetch_array($query);  
 if(! $solucion)
   {

   }
 else
  {   
  do {
    $deuda1="SELECT * FROM concepto c,tipoconcepto t
             WHERE c.codigoconcepto = '".$solucion['codigoconcepto']."'
             AND c.codigotipoconcepto = t.codigotipoconcepto ORDER BY 3 desc";	
	$query1=mysql_db_query($database_sala,$deuda1);     
    $solucion1=mysql_fetch_array($query1); 
	
?>
  </span>
  <table width="631" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
    <tr>
    <td width="185" class="Estilo4 Estilo1"><div align="center"><span class="Estilo6"><strong><strong><strong><?php echo $solucion1['codigoconcepto'];?></strong></strong>
    </strong></span></div></td>
    <td width="265" class="Estilo4 Estilo1"><div align="left"><span class="Estilo6"><strong>
<?php 
	   echo $solucion1['nombreconcepto'];
	  
	   if ($solucion1['codigotipoconcepto'] == 01)
	   {
	     echo "(+)";
	   }	
	  if ($solucion1['codigotipoconcepto'] == 02)
	   {
	     echo "(-)";
	   }		  	  
?>
    </strong></span></div></td>
    <td width="159" class="Estilo4 Estilo1"><div align="center"><span class="Estilo6">$&nbsp;&nbsp;<?php echo number_format($solucion['valordescuentovsdeuda'],2);?></span></div></td>
  </tr>
</table>  
  <span class="Estilo1"><span class="Estilo4">
<?php
 if ( $solucion1['codigotipoconcepto'] == 01)
  {
    $totalvalormatricula= $totalvalormatricula + $solucion['valordescuentovsdeuda'];
    $saldo= $saldo + $solucion['valordescuentovsdeuda'];     
  }
 else 
  if ($solucion1['codigotipoconcepto'] == 02)
  {
   $totalvalormatricula= $totalvalormatricula - $solucion['valordescuentovsdeuda'];
   $descuento =  $descuento + $solucion['valordescuentovsdeuda'];  
  }
 }while ($solucion=mysql_fetch_array($query)); 
}
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
 $fecha="SELECT d.nombredetallefechafinanciera,d.fechadetallefechafinanciera,d.porcentajedetallefechafinanciera
         FROM fechafinanciera f,detallefechafinanciera d
         WHERE f.codigocarrera = '".$row9['codigocarrera']."'
         AND f.idfechafinanciera =d.idfechafinanciera
		 order by 3 asc";	
 $query5=mysql_db_query($database_sala,$fecha);     
 $fechas=mysql_fetch_array($query5);  
do{
if ($fechas['porcentajedetallefechafinanciera'] == 0)
{
 $totalconrecargo = $totalvalormatricula ; 
}
else 
{
 $conrecargo =  $recargototalvalormatricula + ($recargototalvalormatricula * $fechas['porcentajedetallefechafinanciera'] /100 ); 
 $totalconrecargo = $conrecargo + $valorpecuniario -  $descuento + $saldo;
}
?>
  </span>
  <table width="631" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#FF9900">
    <tr>
    <td width="232" class="Estilo4 Estilo1"><div align="center"><span class="Estilo6"><?php echo $fechas['nombredetallefechafinanciera'];?></span></div></td>
    <td width="200" class="Estilo4 Estilo1"><div align="center"><span class="Estilo6"><?php echo $fechas['fechadetallefechafinanciera'];?></span></div></td>
    <td width="175" class="Estilo4 Estilo1"><div align="center"><span class="Estilo6">$&nbsp;<?php echo number_format($totalconrecargo,2);?></span></div></td>
  </tr>
</table>
  
<?php
}while ($fechas=mysql_fetch_array($query5));
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
					FROM cuentabanco c,banco b,periodo p
					WHERE c.codigocarrera = '".$row9['codigocarrera']."'
					AND p.codigoestadoperiodo = 1
					AND c.codigobanco =b.codigobanco
					AND c.codigoperiodo = p.codigoperiodo";	
 $banco5=mysql_db_query($database_sala,$banco);     
 $bancos=mysql_fetch_array($banco5);

if (! $bancos)
 {
 $banco="SELECT *
					FROM cuentabanco c,banco b,periodo p
					WHERE  c.codigobanco =b.codigobanco
					AND p.codigoestadoperiodo = 1
					AND c.codigoperiodo = p.codigoperiodo
					AND codigocarrera IS NULL";	
 $banco5=mysql_db_query($database_sala,$banco);     
 $bancos=mysql_fetch_array($banco5); 
 }
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
}while ($bancos=mysql_fetch_array($banco5));
?>
  <table width="631" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
    <tr>
      <td bordercolor="#006600" class="Estilo4 Estilo1"> 
        <div align="center">
          <p><strong> NOTA:&nbsp;&nbsp;
<?php
if ($saldo > 0)
{
echo "ANTES DE RECLAMAR SU ORDEN DE PAGO DIRIJASE A EL DEPARTAMENTO DE CRÉDITO Y CARTERA";
}
else
{
echo "DIRIJASE A SU FACULTAD Y RECLAME SU ORDEN DE PAGO EL DIA &nbsp;",$row2['fechainicialentregaordenpago'] ;
}
?>
</strong></p>
          <p class="Estilo16 Estilo17"> DOCUMENTO NO VALIDO PARA PAGO</p>
        </div></td>
    </tr>
</table>
<p align="center" class="Estilo1">
  <input name="imprimir" type="button" id="imprimir" value="Imprimir" onClick="window.print()">
    &nbsp;
    <input name="horarios" type="submit" id="horarios" value="Horarios Seleccionados">
&nbsp;
<input name="terminar" type="submit" id="terminar" value="Terminar">
</p>
 <p align="center" class="Estilo1">&nbsp;</p>
<?php 
}
?>
</form>
