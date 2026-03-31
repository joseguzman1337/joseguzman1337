<?php 
require_once('../../Connections/sala2.php' );
require_once("../../funciones/funciontiempo.php");
require_once("../../funciones/validacion.php");
require_once("../../funciones/errores_plandeestudio.php");
require_once("../../funciones/funcionboton.php");

mysql_select_db($database_sala, $sala);
session_start();
require_once('seguridadprematricula.php');
//echo "Usuario".$_SESSION['codigo'];
//echo "Usuario".$_SESSION['MM_Username'];
// Selecciona el periodo activo que halla sido seleccionado por la facultad
$bloquear = false;
$codigoperiodo = $_SESSION['codigoperiodosesion'];
//echo "<h1>$codigoperiodo</h1>";
$ffechapago = 1;
$usuarioeditar = "facultad";

$usuario = $_SESSION['MM_Username'];

        
 mysql_select_db($database_sala, $sala);
//modificacion de la consulta para la tabla usuariorol y usuariotipo
$query_tipousuario="select idrol from usuariorol rol, UsuarioTipo ut, usuario u where rol.idusuariotipo = ut.CodigoTipoUsuario and u.idusuario = ut.UsuarioId
and u.usuario ='".$usuario."'";

// $query_tipousuario = "SELECT idrol FROM usuariofacultad u,usuariorol rol WHERE u.usuario = '".$usuario."' AND rol.usuario = u.usuario";
 $tipousuario = mysql_query($query_tipousuario, $sala) or die(mysql_error());
 $row_tipousuario = mysql_fetch_assoc($tipousuario);
 $totalRows_tipousuario = mysql_num_rows($tipousuario);
 //----------------------------------------------------------------------
//----------------------------------------------------------------------
$proceso = "SELECT numeroordenpago, fechaordenpago FROM ordenpago WHERE codigoestudiante = '" . $_SESSION['codigo'] . "' AND codigoestadoordenpago LIKE '5%' ORDER BY fechaordenpago DESC;";
$resultpr= mysql_db_query($database_sala,$proceso);
$row_dispr = mysql_fetch_array($resultpr);


$pagos = "SELECT numeroordenpago, fechaentregaordenpago FROM ordenpago WHERE codigoestudiante = '" . $_SESSION['codigo'] . "' AND codigoestadoordenpago LIKE '4%' ORDER BY fechaordenpago DESC;";
$resultpa = mysql_db_query($database_sala,$pagos);

// Numero de orden de pago
$query_orden = "SELECT numeroordenpago FROM ordenpago WHERE codigoestudiante = '" . $_SESSION['codigo'] . "' AND codigoestadoordenpago = '10';";
$rorden_pago = mysql_db_query($database_sala,$query_orden);
$row_orden = mysql_fetch_array($rorden_pago);

$query_valor_fecha = "SELECT DISTINCT fechaordenpago FROM fechaordenpago WHERE numeroordenpago = '" . $row_orden['numeroordenpago'] . "' AND valorfechaordenpago > 0;";
$resultv = mysql_db_query($database_sala,$query_valor_fecha);
//echo $query_valor_fecha;
$fecha = date("Ymd");
while ($row_valor_fecha = mysql_fetch_array($resultv)){
//echo $row_valor_fecha[0];
      $arrTemp = explode("-",$row_valor_fecha[0]);
      $tempFe = $arrTemp[0] . $arrTemp[1] . $arrTemp[2];
      if ($tempFe >= $fecha){
            $fecha_pago = $row_valor_fecha[0];
            break;
      } else {
        continue;
      }
}
//echo $fecha_pago;
$query_valor_pago = "SELECT valorfechaordenpago FROM fechaordenpago WHERE numeroordenpago = '" . $row_orden['numeroordenpago'] . "' AND fechaordenpago = '".$fecha_pago."';";
$resultp = mysql_db_query($database_sala,$query_valor_pago);
$row_valor_pago = mysql_fetch_array($resultp);
//--------------------------------------------------------------------------
//--------------------------------------------------------------------------

 
?>
<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
.Estilo3 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 14px; font-weight: bold; }
-->
</style>
<?php

if(!isset($_SESSION['codigo']))
{
?>

	<script language="javascript">
	alert("Por seguridad su sesion ha sido cerrada, por favor reinicie.");
</script>

<?php
}
$sinprematricula = false;
$codigoestudiante = $_SESSION['codigo'];

$query_seldocumentos = "select ed.numerodocumento, ed.fechainicioestudiantedocumento, ed.fechavencimientoestudiantedocumento, u.linkidubicacionimagen
from estudiantedocumento ed, estudiante e, ubicacionimagen u
where ed.idestudiantegeneral = e.idestudiantegeneral
and e.codigoestudiante = '$codigoestudiante'
and u.idubicacionimagen like '1%'
and u.codigoestado like '1%'
order by 2 desc";
//echo $query_seldocumentos."<br>";
$seldocumentos = mysql_query($query_seldocumentos, $sala) or die("$query_seldocumentos ".mysql_error());
$totalRows_seldocumentos = mysql_num_rows($seldocumentos);
while($row_seldocumentos = mysql_fetch_assoc($seldocumentos))
{
	$link = $row_seldocumentos['linkidubicacionimagen'];
	$imagenjpg = $row_seldocumentos['numerodocumento'].".jpg";
	$imagenJPG = $row_seldocumentos['numerodocumento'].".JPG";
	if(@imagecreatefromjpeg($link.$imagenjpg))
	{
		$linkimagen = $link.$imagenjpg;
		break;
	}
	else if(@imagecreatefromjpeg($link.$imagenJPG))
	{
		$linkimagen = $link.$imagenJPG;
		break;
	}
}
?>
<?php 
$cuentaconplandeestudio = true;
$query_selplan = "select p.idplanestudio, p.nombreplanestudio
from planestudioestudiante pe, planestudio p
where pe.idplanestudio = p.idplanestudio
and pe.codigoestudiante = '$codigoestudiante'
and pe.codigoestadoplanestudioestudiante like '1%'
and p.codigoestadoplanestudio like '1%'";
//echo "$query_horarioinicial<br>";
$selplan = mysql_db_query($database_sala,$query_selplan) or die("$query_selplan");
$totalRows_selplan = mysql_num_rows($selplan);
if($totalRows_selplan != "")
{
	$row_selplan=mysql_fetch_array($selplan);
	$idplan = $row_selplan['idplanestudio'];
	$nombreplan = $row_selplan['nombreplanestudio'];
}
else
{
	$cuentaconplandeestudio = false;
	$idplan = "0";
	$nombreplan = "Sin Asignar";
?>
<script language="javascript">
	alert("El estudiante no tiene plan de estudio activo. Debe asignarle un plan de estudio");
</script>
<?php
}

// Selecciona la cohorte del estudiante
$query_datocohorte = "select c.numerocohorte, c.codigoperiodoinicial, c.codigoperiodofinal
from cohorte c, estudiante e
where c.codigocarrera = e.codigocarrera
and c.codigoperiodo = '$codigoperiodo'
and e.codigoestudiante = '$codigoestudiante'
and e.codigoperiodo*1 between codigoperiodoinicial*1 and codigoperiodofinal*1";
//echo "$query_datocohorte<br>";
$datocohorte = mysql_db_query($database_sala,$query_datocohorte) or die("$query_datocohorte");
$totalRows_datocohorte = mysql_num_rows($datocohorte);
$row_datocohorte = mysql_fetch_array($datocohorte);
$numerocohorte = $row_datocohorte['numerocohorte'];
//exit();
$query_iniciales= "select p.idprematricula, c.nombrecarrera, p.semestreprematricula,
e.codigoestudiante, concat(eg.nombresestudiantegeneral,' ',eg.apellidosestudiantegeneral) as nombre, e.semestre,
det.valordetallecohorte, e.codigotipoestudiante, eg.numerodocumento, e.codigosituacioncarreraestudiante, e.codigocarrera
from prematricula p, estudiante e, carrera c, detallecohorte det, cohorte coh, estudiantegeneral eg
where p.codigoestudiante = e.codigoestudiante
and p.codigoperiodo = '$codigoperiodo'
and e.codigocarrera = c.codigocarrera
and (p.codigoestadoprematricula like '4%' or p.codigoestadoprematricula like '1%')
and e.codigoestudiante = '$codigoestudiante'
and coh.codigocarrera = c.codigocarrera
and coh.codigoperiodo = p.codigoperiodo
and coh.idcohorte = det.idcohorte
and det.semestredetallecohorte = p.semestreprematricula
and coh.numerocohorte = '$numerocohorte'
and e.idestudiantegeneral = eg.idestudiantegeneral";
//and dop.codigoconcepto = '151'
//echo "<br>$query_iniciales<br>";
$iniciales=mysql_db_query($database_sala,$query_iniciales) or die("$query_iniciales".mysql_error());
$totalRows_oiniciales = mysql_num_rows($iniciales);
$row_iniciales=mysql_fetch_array($iniciales);
$existeinicial = true;
//echo "flsdfkds";
if($totalRows_oiniciales == "")
{
	$query_iniciales2= "SELECT p.idprematricula, c.nombrecarrera, p.semestreprematricula, e.semestre,
	e.codigoestudiante, concat(eg.nombresestudiantegeneral,' ',eg.apellidosestudiantegeneral) AS nombre, 
	e.codigotipoestudiante, eg.numerodocumento, e.codigosituacioncarreraestudiante, e.codigocarrera
	FROM prematricula p, estudiante e, carrera c, cohorte coh, estudiantegeneral eg
	WHERE p.codigoestudiante = e.codigoestudiante
	AND p.codigoperiodo = '$codigoperiodo'
	AND e.codigocarrera = c.codigocarrera
	AND (p.codigoestadoprematricula LIKE '4%' OR p.codigoestadoprematricula LIKE '1%')
	AND e.codigoestudiante = '$codigoestudiante'
	AND coh.codigocarrera = c.codigocarrera
	AND coh.codigoperiodo = p.codigoperiodo
	and coh.numerocohorte = '$numerocohorte'
	and eg.idestudiantegeneral = e.idestudiantegeneral";
	//and dop.codigoconcepto = '151'
	//echo "<br>$query_iniciales2<br>";
	$iniciales2=mysql_db_query($database_sala,$query_iniciales2);
	$totalRows_oiniciales2 = mysql_num_rows($iniciales2);
	$row_iniciales=mysql_fetch_array($iniciales2);
	$existeinicial = false;
	$creditosadicionales = 0;
}
else
{
	$usarcondetalleprematricula = true;

	$query_seltotalcreditossemestre = "select sum(d.numerocreditosdetalleplanestudio) as totalcreditossemestre, d.idplanestudio
	from detalleplanestudio d, planestudioestudiante p
	where d.idplanestudio = p.idplanestudio
	and p.codigoestudiante = '$codigoestudiante'
	and d.semestredetalleplanestudio = '".$row_iniciales['semestreprematricula']."'
	and p.codigoestadoplanestudioestudiante like '1%'
	and d.codigotipomateria not like '4'
	and d.codigotipomateria not like '5'
	group by 2 ";
	//echo "$query_seltotalcreditossemestre<br>";
	$seltotalcreditossemestre = mysql_db_query($database_sala,$query_seltotalcreditossemestre) or die("$query_seltotalcreditossemestre");
	$totalRows_seltotalcreditossemestre = mysql_num_rows($seltotalcreditossemestre);
	$row_seltotalcreditossemestre = mysql_fetch_array($seltotalcreditossemestre);
	$totalcreditossemestre = $row_seltotalcreditossemestre['totalcreditossemestre'];
	//echo "$totalcreditossemestre";
	
	$query_seltotalcreditossemestre2 = "select sum(d.numerocreditosdetallelineaenfasisplanestudio) as totalcreditossemestre, d.idplanestudio
	from detallelineaenfasisplanestudio d, lineaenfasisestudiante l
	where d.idlineaenfasisplanestudio = l.idlineaenfasisplanestudio
	and l.codigoestudiante = '$codigoestudiante'
	and d.semestredetallelineaenfasisplanestudio = '".$row_iniciales['semestreprematricula']."'
	and d.codigotipomateria not like '4'
	group by 2 ";
	//echo "$query_horarioinicial<br>";
	$seltotalcreditossemestre2 = mysql_db_query($database_sala,$query_seltotalcreditossemestre2) or die("$query_seltotalcreditossemestre2".mysql_error());
	$totalRows_seltotalcreditossemestre2 = mysql_num_rows($seltotalcreditossemestre2);
	$row_seltotalcreditossemestre2 = mysql_fetch_array($seltotalcreditossemestre2);
	$totalcreditossemestre2 = $row_seltotalcreditossemestre2['totalcreditossemestre'];
	if($totalcreditossemestre2 == "")
	{
		$query_seltotalcreditossemestre2 = "select sum(d.numerocreditosdetalleplanestudio) as totalcreditossemestre, d.idplanestudio
		from detalleplanestudio d, planestudioestudiante p
		where d.idplanestudio = p.idplanestudio
		and p.codigoestudiante = '$codigoestudiante'
		and d.semestredetalleplanestudio = ".$row_iniciales['semestreprematricula']."
		and d.codigoestadodetalleplanestudio like '1%'
		and d.codigotipomateria like '5%'
		and p.codigoestadoplanestudioestudiante like '1%'
		group by 2";
		//echo "$query_horarioinicial<br>";
		$seltotalcreditossemestre2 = mysql_db_query($database_sala,$query_seltotalcreditossemestre2) or die("$query_seltotalcreditossemestre2".mysql_error());
		$totalRows_seltotalcreditossemestre2 = mysql_num_rows($seltotalcreditossemestre2);
		$row_seltotalcreditossemestre2 = mysql_fetch_array($seltotalcreditossemestre2);
		$totalcreditossemestre2 = $row_seltotalcreditossemestre2['totalcreditossemestre'];
	}
	if($totalcreditossemestre != "" || $totalcreditossemestre2)
	{
		$totalcreditossemestre = $totalcreditossemestre + $totalcreditossemestre2;
		$valoradicional=($row_iniciales['valordetallecohorte'] / $totalcreditossemestre * ($creditoscalculados -  $totalcreditossemestre));
	}
	else
	{
		
		$totalcreditossemestre = 0;
	}
	//echo "$valoradicional=(".$row_iniciales['maximocreditos']." / ".$row_iniciales['maximocreditos']." * (".$row_iniciales['totalcreditossemestre']." - ".$row_iniciales['maximocreditos']."))";
	if ($valoradicional < 0)
	{
		$valoradicional=0;				  
	} 
	$valoradi=round($valoradicional,0);	  
	$creditosadicionales = number_format($valoradi,2);
}


// Ya que creditossemestrenovasoft ha dejado de existir
// El total de creditos se calcula de calculocreditossemestre.php
// Calculo de los creditos del semestre
$codigocarrera = $row_iniciales['codigocarrera'];
$semestredelestudiante = $row_iniciales['semestre'];

/*$codigocarrera = 32;
$semestredelestudiante = 2;*/
//echo " $codigocarrera adad $semestredelestudiante<br>";
require_once('calculocreditossemestre.php');

?>
<form name="form1" method="post" action="matriculaautomaticaordenmatricula.php?programausadopor=<?php echo $_GET['programausadopor'];?>">
<div align="center">
<?php
if ($_POST['terminar'])
{
	echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=../central.htm'>";
	exit();
}
if ($_POST['finalizar'])
{
	echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=../creditoycartera/accesoprematricula/accesoprematricula.php'>";
	exit();
}
if ($_POST['horarios'])
{
	echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=matriculaautomaticahorariosseleccionados.php?programausadopor=".$_GET['programausadopor']."'>";
	//echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=../listadosvarios/horarioestudiante/horarioestudiante.php?programausadopor=".$_GET['programausadopor']."'>";exit();
}
if ($_POST['modificar'])
{
	echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=matriculaautomatica.php?programausadopor=".$_GET['programausadopor']."'>";
	exit();
}
if ($_POST['documentacion'])
{
	echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=../facultades/consultadocumentacionformulario.php?facultad=".$_SESSION['codigofacultad']."'&codigo=".$_SESSION['codigo']."'>";
	exit();
}
if ($_POST['estudiante'])
{
	echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=../facultades/creacionestudiante/editarestudiante.php?usuarioeditar=".$usuarioeditar."'&facultad=".$_SESSION['codigofacultad']."'&codigocreado=".$_SESSION['codigo']."'>";
	exit();
}
if ($_POST['registro'])
{	
	echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=../facultades/registromatriculas/registromatriculasformulario.php?usuarioeditar=".$usuarioeditar."&creditoscalculados=$creditoscalculados'>";
	exit();
}


if($totalRows_oiniciales != "" || $totalRows_oiniciales2 != "")
{
?>
<p class="Estilo3">DATOS  GENERALES DE LA MATRICULA </p>
<table border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
     <tr bgcolor="#C5D5D6" class="Estilo2"> 
      <td colspan="3" align="center"  class="Estilo2">Nombre Estudiante</td>
	  <td colspan="2" align="center">Documento</td>
	  <td colspan="0" rowspan="6"align="center" class="Estilo19"><img src="<?php echo $linkimagen; ?>" width="80" height="120"></td>
     </tr>
    <tr class="Estilo1"> 
      <td colspan="3" align="center"><?php echo $row_iniciales['nombre'];?></td>
  	  <td colspan="2" align="center" div><?php echo $row_iniciales['numerodocumento'];?></td>
      </tr>
  	<tr bgcolor="#C5D5D6" class="Estilo2"> 
      <td align="center">No. Prematricula</td>
      <td align="center">No. Plan de Estudio</td>
      <td align="center" colspan="3">Nombre Del Plan de Estudio</td>
	</tr>
    <tr> 
      <td class="Estilo1" align="center"><?php echo $row_iniciales['idprematricula'];?></td>
      <td class="Estilo1" align="center"><?php echo $idplan;?></td>
      <td class="Estilo1" colspan="3" align="center"><?php echo $nombreplan;?></td>
	  <!-- <td class="Estilo1 Estilo4 Estilo1" colspan="1"> <div align="center" class="Estilo19"></div></td> -->
    </tr>
   <tr bgcolor="#C5D5D6" class="Estilo2"> 
      <td align="center">Carrera</td>
      <td align="center">Semestre</td>
      <td colspan="2" align="center">Cr&eacute;ditos Semestre </td>
      <td align="center">Cr&eacute;ditos Seleccionados</td>
    </tr>
    <tr class="Estilo1"> 
      <td align="center"><?php echo $row_iniciales['nombrecarrera'];?></td>
      <td align="center"><?php echo $row_iniciales['semestreprematricula'];?></td>
      <td colspan="2" align="center"><?php if($nombreplan == "Sin Asignar"){echo "Sin Asignar";} else if($existeinicial){echo $totalcreditossemestre;} else echo "0";?></td>
	  <td align="center"><?php if($nombreplan == "Sin Asignar"){echo "Sin Asignar";} else if($existeinicial){echo $creditoscalculados;} else echo "0";?></td>
    </tr>
    <tr bgcolor="#C5D5D6" class="Estilo2"> 
      <td align="center">Fecha</td>
	  <td colspan="3"align="center">Valor Concepto Matricula</td>
      <td colspan="2" align="center">Valor Cr&eacute;ditos Adicionales</td>
    </tr>
    <tr class="Estilo1"> 
      <td align="center"><?php echo date("Y-m-d",time());?></td>
  	  <td colspan="3" align="center"><?php echo "$ ".number_format($row_iniciales['valordetallecohorte']);?></td>
      <td colspan="2" align="center"><?php echo "$ ".$creditosadicionales;?></td>
    </tr>
  </table>
</div>
<br>
<hr align="center" width="80%" size="4" color="#C5D5D6">
<table width="83%"  border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><strong>Recibos disponibles para pago: </strong></td>
    </tr>
    <tr>
      <td><table width="100%"  border="1" cellpadding="0" cellspacing="0" bordercolor="#003333">
          <tr bgcolor="#C5D5D6">
            <td width="11%" bgcolor="#C5D5D6"><div align="center" class="Estilo1 Estilo4 Estilo1"><strong> No. Orden </strong></div></td>
            <td width="13%" bgcolor="#C5D5D6"><div align="center" class="Estilo1 Estilo4 Estilo1"><strong>Valor</strong></div></td>
            <td width="16%" bgcolor="#C5D5D6"><div align="center" class="Estilo1 Estilo4 Estilo1"><strong>Fecha de Pago</strong></div></td>
            <td width="9%" bgcolor="#C5D5D6"> <div align="center" class="Estilo1 Estilo4 Estilo1"><strong>Pagar</strong></div></td>
          </tr>
          <tr>
          <?php
            if (strlen($fecha_pago > 0)){ ?>
            <td align="center"><?php echo $row_orden['numeroordenpago']; ?></td>
            <td align="center"><?php echo number_format($row_valor_pago[0],0,",","."); ?></td>
            <td align="center"><?php echo $fecha_pago; ?></td>
            <td align="center"><a href="<?php echo "ordenmatricula2.php?i=1&ordenpago=$row_orden[0]&programausadopor=".$_GET['programausadopor']."&porpagar&valor=" . $row_valor_pago[0]; ?>" target="_parent">Pagar</td>
          <?php } ?>
            </tr>
      </table></td>
    </tr>
  </table>
</div>
<hr align="center" width="80%">
<div align="center">
  <table width="83%"  border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><strong>Recibos en proceso de pago: </strong></td>
    </tr>
    <tr>
      <td><table width="100%"  border="1" cellpadding="0" cellspacing="0" bordercolor="#003333">
          <tr bgcolor="#C5D5D6">
            <td width="13%" bgcolor="#C5D5D6" class="Estilo1 Estilo4 Estilo1"><div align="center"><strong> No. Orden </strong></div></td>
            <td width="13%" bgcolor="#C5D5D6" class="Estilo1 Estilo4 Estilo1"><div align="center"><strong>Valor</strong></div></td>
          </tr>
          <tr>
            <td align="center"><?php echo $row_dispr[0]; ?></td>
            <td align="center"><?php echo $row_dispr[1]; ?></td>
          </tr>
      </table></td>
    </tr>
  </table>
</div>
<hr align="center" width="80%">
<div align="center">
  <table width="83%"  border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td><strong>Recibos cancelados: </strong></td>
    </tr>
    <tr>
      <td><table width="100%"  border="1" cellpadding="0" cellspacing="0" bordercolor="#003333">
          <tr bgcolor="#C5D5D6">
            <td align="center" width="16%" bgcolor="#C5D5D6" class="Estilo1 Estilo4 Estilo1"><strong> No. Orden </strong></td>
            <td width="12%" bgcolor="#C5D5D6" align="center" class="Estilo1 Estilo4 Estilo1"><strong>Fecha de Pago</strong></td>
          </tr>
            <?php
                while($row_dispa = mysql_fetch_array($resultpa)){ ?>
          <tr>
            <td align="center"><a href="<?php echo "ordenmatricula2.php?ordenpago=$row_dispa[0]&programausadopor=".$_GET['programausadopor']."&imprimeorden=".$row_ordenesporpagar['codigoimprimeordenpago']; ?>"><?php echo $row_dispa[0]; ?></a></td>
            <td align="center"><?php echo $row_dispa[1]; ?></td>
          </tr>
           <?php } ?>
      </table></td>
    </tr>
  </table>
<hr align="center" width="80%" size="4" color="#C5D5D6">
<?php
	/////////////////////////////////////////////////  valores  
	$query_ordenespagadas= "select o.numeroordenpago, o.fechaordenpago, o.codigoimprimeordenpago
	from ordenpago o
	where o.codigoestudiante = '$codigoestudiante'
	and o.codigoperiodo = '$codigoperiodo'
	and o.codigoestadoordenpago like '4%'
	order by 2,1 desc";
	//and dop.codigoconcepto = '151'
	//echo "<br>$query_ordenespagadas<br>";
	$ordenespagadas=mysql_db_query($database_sala,$query_ordenespagadas);
	$totalRows_ordenespagadas = mysql_num_rows($ordenespagadas);
	//$totalRows_ordenespagadas = mysql_num_rows($ordenespagadas);
	
?>
<?php
/////////////////////////////////////////////////  valores
	$query_ordenesporpagar= "select o.numeroordenpago, o.fechaordenpago, o.codigoimprimeordenpago
	from ordenpago o
	where o.codigoestudiante = '$codigoestudiante'
	and o.codigoperiodo = '$codigoperiodo'
	and o.codigoestadoordenpago like '1%'
	order by 1 DESC";
	//and dop.codigoconcepto = '151'
	//echo "$query_ordenesporpagar <br>";
	$ordenesporpagar=mysql_db_query($database_sala,$query_ordenesporpagar);
	$totalRows_ordenesporpagar = mysql_num_rows($ordenesporpagar);
?>
</table>
<?php
	}
// Viene del primer if
else
{
	$sinprematricula = true;
	$query_dataestudiante = "select c.nombrecarrera, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) as nombre, 
	eg.numerodocumento, eg.fechanacimientoestudiantegeneral, eg.expedidodocumento, e.codigojornada, e.semestre, 
	e.numerocohorte, e.codigotipoestudiante, t.nombretipoestudiante, e.codigosituacioncarreraestudiante, 
	s.nombresituacioncarreraestudiante, eg.celularestudiantegeneral, eg.emailestudiantegeneral, eg.codigogenero, 
	eg.direccionresidenciaestudiantegeneral, eg.telefonoresidenciaestudiantegeneral, eg.ciudadresidenciaestudiantegeneral, 
	eg.direccioncorrespondenciaestudiantegeneral, eg.telefonocorrespondenciaestudiantegeneral, eg.ciudadcorrespondenciaestudiantegeneral
	from estudiante e, carrera c, tipoestudiante t, situacioncarreraestudiante s, estudiantegeneral eg
	where e.codigocarrera = c.codigocarrera
	and e.codigotipoestudiante = t.codigotipoestudiante
	and e.codigosituacioncarreraestudiante = s.codigosituacioncarreraestudiante
	and e.codigoestudiante = '$codigoestudiante'
	and e.idestudiantegeneral = eg.idestudiantegeneral";
	//echo $query_dataestudiante;
	$dataestudiante = mysql_query($query_dataestudiante, $sala) or die("$query_dataestudiante".mysql_error());
	$totalRows_dataestudiante = mysql_num_rows($dataestudiante);
	$row_dataestudiante = mysql_fetch_assoc($dataestudiante);
	if(ereg("^1[0-9]{1}$",$row_dataestudiante['codigosituacioncarreraestudiante']) || ereg("^5[0-9]{1}$",$row_dataestudiante['codigosituacioncarreraestudiante']))
	{
		$bloquear = true;
	}
?>
<P align="center" class="Estilo3">NO TIENE REGISTRADAS PREMATRICULAS PARA ESTE PERIODO</P>
<p class="Estilo3">DATOS DEL ESTUDIANTE</p>
<table border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
    <tr bgcolor="#C5D5D6"> 
      <td class="Estilo2" align="center">Documento</td>
      <td colspan="2" align="center" class="Estilo2">Nombre Estudiante</td>
      <td colspan="0" rowspan="6"align="center"><img src="<?php echo $linkimagen; ?>" width="80" height="120"></td>
    </tr>
    <tr> 
      <td class="Estilo1 Estilo4 Estilo1"><div align="center"><?php echo $row_dataestudiante['numerodocumento'];?></div></td>
      <td colspan="2" class="Estilo1 Estilo4 Estilo1"><div align="center"><?php echo $row_dataestudiante['nombre'];?></div></td>
      </tr>
    <tr bgcolor="#C5D5D6" class="Estilo2"> 
      <td colspan="1" align="center">No. Plan de Estudio</td>
	  <td colspan="1" align="center">Nombre Del Plan de Estudio</td>
	  <td colspan="1" align="center">Semestre</td>
	  </tr>
    <tr class="Estilo1"> 
      <td colspan="1" align="center"><?php echo $idplan;?></td>
	  <td colspan="1" align="center"><?php echo $nombreplan;?></td>
	  <td colspan="1" align="center"><?php echo $row_dataestudiante['semestre'];?></td>
	  </tr>
    <tr bgcolor="#C5D5D6" class="Estilo2"> 
      <td align="center">Carrera</td>
      <td colspan="1" align="center">Situación</td>
	  <td align="center">Tipo</td>
    </tr>
    <tr class="Estilo1"> 
      <td align="center"><?php echo $row_dataestudiante['nombrecarrera'];?></td>
      <td align="center"><?php echo $row_dataestudiante['nombresituacioncarreraestudiante'];?></td>
      <td align="center"><?php echo $row_dataestudiante['nombretipoestudiante'];?></td>
    </tr>
  </table>
</div>
<?php
}
?>
<p align="center" class="Estilo1">
<?php
if($_GET['programausadopor'] != "creditoycartera" && $_GET['programausadopor'] != "estudianterestringido")
{
?>
<span class="Estilo2"><font color="#800000" class="Estilo2">AL MODIFICAR LA PREMATRICULA O MATRICULAR ASIGNATURAS, <BR>
SE PUEDE GENERAR UN VALOR ADICIONAL A PAGAR.</font><br>
<?php
}
?>
</p>
<br>

 <div align="center">
<?php
if($_SESSION['MM_Username'] == "estudiante" || $_SESSION['MM_Username'] == "estudianterestringido")
{
   $query_estudiante = "SELECT DISTINCT 
	  estudiantegeneral.nombresestudiantegeneral,
	  estudiantegeneral.apellidosestudiantegeneral,
	  estudiantedocumento.numerodocumento,
	  carrera.nombrecarrera,
	  estudiante.codigocarrera
	FROM
	 estudiantedocumento
	 INNER JOIN estudiantegeneral ON (estudiantedocumento.idestudiantedocumento=estudiantegeneral.idestudiantegeneral)
	 INNER JOIN estudiante ON (estudiante.idestudiantegeneral=estudiantegeneral.idestudiantegeneral)
	 INNER JOIN carrera ON (carrera.codigocarrera=estudiante.codigocarrera)
	 INNER JOIN prematricula ON (prematricula.codigoestudiante=estudiante.codigoestudiante)
	 INNER JOIN detalleprematricula ON (prematricula.idprematricula=detalleprematricula.idprematricula)
	 INNER JOIN ordenpago ON (ordenpago.idprematricula=prematricula.idprematricula)
	WHERE
	  (estudiante.codigoestudiante = '$codigoestudiante') AND 
	  (prematricula.codigoestadoprematricula = 40) AND 
	  (ordenpago.codigoestadoordenpago = 40)";
	//echo $query_estudiante;
	$estudiante = mysql_query($query_estudiante, $sala) or die("$query_estudiante");
	$totalRows_estudiante = mysql_num_rows($estudiante);
	$row_estudiante = mysql_fetch_assoc($estudiante);
    
		if ($row_estudiante <> "")
		 {
		   $query_carrera = "SELECT * from evaluacioncarrera 
							 where carrera = '".$row_estudiante['codigocarrera']."'
			  ";
			$carrera = mysql_query($query_carrera, $sala) or die("$query_estudiante");
			$totalRows_carrera = mysql_num_rows($carrera);
			$row_carrera = mysql_fetch_assoc($carrera);  
		   
		    if ($row_carrera <> "")
			 { 
?>
			   <a href="../eva/ffacultad.php"><img src="../../../imagenes/evaluacion.gif" width="50" height="50" alt="Evaluación Docente"></a>
<?php			 
			 }
		 }
}
// Boton para la generación de la orden automática
//echo "sdasdas";
if($sinprematricula)
{
	$query_selperiodo = "select p.codigoperiodo, e.nombreestadoperiodo, e.codigoestadoperiodo, p.nombreperiodo
	from periodo p, estadoperiodo e
	where p.codigoestadoperiodo = e.codigoestadoperiodo
	and p.codigoperiodo = '".$_SESSION['codigoperiodosesion']."'
	order by 1 desc";
	$selperiodo = mysql_query($query_selperiodo, $sala) or die('<script language="javascript">window.location.reload()</script>');
	$totalRows_selperiodo = mysql_num_rows($selperiodo);
	$row_selperiodo = mysql_fetch_assoc($selperiodo);
	
	//echo "<br>".$row_dataestudiante['codigotipoestudiante']." == '10' && ".$row_selperiodo['codigoestadoperiodo']." == '1'";
	if($row_dataestudiante['codigotipoestudiante'] == '10' && $row_selperiodo['codigoestadoperiodo'] == '1' && $_GET['programausadopor'] == "facultad" && $row_dataestudiante['codigosituacioncarreraestudiante'] == '300')
	{
?>
			   <a href="generarordenautomatica/generarprimersemestreindividual.php?estudiante=<?php echo $codigoestudiante;?>"><img src="../../../imagenes/ordenautomaticaindividual.gif" width="50" height="50" alt="Orden de Matricula Automática"></a>
<?php			 
	}
/*	if($row_dataestudiante['codigotipoestudiante'] == '20' && $row_selperiodo['codigoestadoperiodo'] == '1' && $_GET['programausadopor'] == "facultad" && $row_dataestudiante['codigosituacioncarreraestudiante'] == '300')
	{
?>
			   <a href="generarordenautomatica/generarprimersemestreindividual.php?estudiante=<?php echo $codigoestudiante;?>"><img src="../../../imagenes/ordenautomaticaindividual.gif" width="50" height="50" alt="Orden de Matricula Automática"></a>
<?php
	}*/
}

// Documentación
$valores['facultad'] = $_SESSION['codigofacultad'];
// Documentación y Certificados
$valores['codigo'] = $codigoestudiante;
// Mensajes
$valores['usuarioeditar'] = $usuarioeditar;
$valores['creditoscalculados'] = $creditoscalculados;
// Horarios y Prematricula
$valores['programausadopor'] = $_GET['programausadopor'];
// Consultar Historico
$valores['tipocertificado'] = "reglamento";
$valores['periodos'] = "true";
// Modificar Historico
$valores['codigoestudiante'] = $codigoestudiante;
// Boletin de Calificaciones
$valores['busqueda_codigo'] = $codigoestudiante;
// Editar Estudiante
$valores['usuarioeditar'] = $usuarioeditar;
$valores['codigocreado'] = $codigoestudiante;
crearmenubotones($_SESSION['MM_Username'], ereg_replace(".*\/","",$HTTP_SERVER_VARS['SCRIPT_NAME']), $valores, $sala);

if($_GET['programausadopor'] == "facultad")
{
?>
<!-- <a href="../facultades/creacionestudiante/editarestudiante.php?usuarioeditar=<?php echo "$usuarioeditar&facultad=".$_SESSION['codigofacultad']."'&codigocreado=".$_SESSION['codigo']."";?>"><img src="../../../imagenes/estudiante.gif" width="50" height="50" alt="Estudiante"></a>
 -->
<!-- <table bordercolor="#0000FF" border="1" cellspacing="0" width="50" height="50">
  <tr>
  	<td style="cursor:pointer">
	<a onClick="<?php echo "window.open('../facultades/mensajesestudiante.php','mensaje','width=800,height=600,top=200,left=150,scrollbars=yes')";?>">
<img src="../../../imagenes/Mensajes.gif" width="48" height="48" alt="Mensajes"></a>
  	</td>
  </tr>
</table> -->
<!-- <a href="../facultades/consultadocumentacionformulario.php?facultad=<?php echo $_SESSION['codigofacultad']."&codigo=".$_SESSION['codigo'];?>"><img src="../../../imagenes/Documentacion.gif" width="50" height="50" alt="Documentación"></a><a href="../facultades/creacionestudiante/editarestudiante.php?usuarioeditar=<?php echo "$usuarioeditar&facultad=".$_SESSION['codigofacultad']."'&codigocreado=".$_SESSION['codigo']."";?>"><img src="../../../imagenes/estudiante.gif" width="50" height="50" alt="Estudiante"></a> -->
<!-- <a href="../facultades/registromatriculas/registromatriculasformulario.php?usuarioeditar=<?php echo "$usuarioeditar&creditoscalculados=$creditoscalculados";?>"><img src="../../../imagenes/Registro.gif" width="50" height="50" alt="Registro Matricula"></a> -->
<?php
}
?>  
  <!-- <a href="matriculaautomaticahorariosseleccionados.php?programausadopor=<?php echo $_GET['programausadopor']?>"><img src="../../../imagenes/Horario.gif" width="50" height="50" alt="Horarios"></a> -->
<?php
if($_GET['programausadopor'] != "creditoycartera" && $_GET['programausadopor'] != "estudianterestringido")
{
	if(!$bloquear)
	{
      if ($row_tipousuario['idrol'] == 3)
      {
 ?>  
<!--    <a href="matriculaautomatica.php?programausadopor=<?php echo $_GET['programausadopor']?>"><img src="../../../imagenes/Prematricula.gif" width="50" height="50" alt="Prematricula"></a> -->
 <?php 
      }
?>
  
   <!-- <a href="../facultades/certificados/certificadosformulario.php?tipocertificado=reglamento&periodos=true"><img src="../../../imagenes/Historico.gif" width="50" height="50" alt="Consultar Historico"></a> -->
<?php
	}
}

if($_GET['programausadopor'] == "facultad")
{
	//echo "dsflsñd";
?>
<!-- <a href="../facultades/certificados/certificadosformularioperiodos.php?codigo=<?php echo $codigoestudiante;?>"><img src="../../../imagenes/certificado.gif" width="50" height="50" alt="Certificados"></a> -->
<!-- <a href="../facultades/boletines/consultarboletinesformulario.php?busqueda_codigo=<?php echo $codigoestudiante;?>"><img src="../../../imagenes/Boletin.gif" width="50" height="50" alt="Boletin de Calificaciones"></a> -->
 
 <?php 
   if ($row_tipousuario['idrol'] == 3)
    {
 ?> 
<!--       <a href="../facultades/modificahistoricoformulario.php?codigoestudiante=<?php echo $codigoestudiante;?>"><img src="../../../imagenes/Modificar historico.gif" width="50" height="50" alt="Modificación Historico de Notas"></a>  -->
<?php 
   }
?>
<!-- <a href="matriculaautomaticabusquedaestudiante.php"><img src="../../../imagenes/terminar.gif" width="50" height="50" alt="Terminar"></a> -->
<?php
}
if($_GET['programausadopor'] == "creditoycartera")
{	
	?>
	   <!-- <a href="matriculaautomaticabusquedaestudiante.php"><img src="../../../imagenes/terminar.gif" width="50" height="50" alt="Terminar"></a> -->
	<?php
}
?>
</div>
<?php
if(isset($_POST['ordenautomatica']))
{
	//echo "entro acam $ffechapago";
	if($ffechapago)
	{
		//echo "entro aca $fechapago";
		echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=../creditoycartera/generacionordenespago/automatriculaestudiante.php?programausadopor=".$_GET['programausadopor']."&estudiante=".$_SESSION['codigo']."&fechapago=".$fechapago."'>";
	}
}
?>

<!-- <p align="center" class="Estilo1">&nbsp;
 SCRIPTS PARA PRUEBAS<br><br>
 <a href="zanulartodo.php?prematricula=<?php echo $row_iniciales['idprematricula'];?>">Anular prematricula</a><br>
 <a href="zinsertarnotas.php?prematricula=<?php echo $row_iniciales['idprematricula']."&estudiante=".$row_iniciales['codigoestudiante'];?>">Insertar notas</a><br>
 </p> -->
 
</form>
<script language="javascript">
function terminar()
{
	window.location.reload("matriculaautomaticabusquedaestudiante.php");
}
</script>
