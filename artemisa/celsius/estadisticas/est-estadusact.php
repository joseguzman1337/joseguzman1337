<?
$pageName = "estadisticas1";
require_once "../common/includes.php";
require_once "metodos_estadisticas.php";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<?


function Calcular() {
	global $Suma_Total;
	global $row;
	global $Modalidad;
	global $result;
	global $Total_General;
	global $Anio;

	while ($rowg = mysql_fetch_row($result)) {
		// Asigno el Anio
		$row[$rowg[0] - $Anio +1][0] = $rowg[0];

		// Asigno lo que leo de la tabla
		// La Modalidad implica la graficacion de los
		// totales por año

		if ($Modalidad == 1) {
			$row[$rowg[0] - $Anio +1][$rowg[1]]++;
			$row[$rowg[0] - $Anio +1][13]++;
			$Suma_Total[$rowg[1]]++;
		} else {
			$row[$rowg[0] - $Anio +1][13]++;

		}

		$Total_General++;
	}
}

function Armar_Instruccion($dedonde, $Modalidad) {
	global $Anio;
	global $AnioFinal;
	global $TPed;
	global $Caja;

	if ($Modalidad == 2) {
		$Instruccion = "SELECT YEAR(Fecha_Alta_Pedido) AS p, Codigo_Usuario, COUNT(*) ";
		if ($dedonde == 1) {
			$Instruccion .= "FROM pedhist ";
		} else {
			$Instruccion .= "FROM pedidos ";
		}

		$Instruccion .= "WHERE YEAR(Fecha_Alta_Pedido)>=" . $Anio . " AND YEAR(Fecha_Alta_Pedido)<=" . $AnioFinal;
		$Instruccion .= " AND Tipo_Pedido=" . $TPed;
		$Instruccion .= " GROUP BY p,Codigo_Usuario";
	} else {
		$Instruccion = "SELECT YEAR(Fecha_Alta_Pedido) AS p, MONTH(Fecha_Alta_Pedido) AS m, Codigo_Usuario, COUNT(*) ";
		if ($dedonde == 1) {
			$Instruccion .= "FROM pedhist ";
		} else {
			$Instruccion .= "FROM pedidos ";
		}

		$Instruccion .= "WHERE YEAR(Fecha_Alta_Pedido)>=" . $Anio . " AND YEAR(Fecha_Alta_Pedido)<=" . $AnioFinal;
		$Instruccion .= " AND Tipo_Pedido=" . $TPed;
		$Instruccion .= " GROUP BY p,m,Codigo_Usuario";
	}
	return $Instruccion;
}
global $IdiomaSitio;
$Mensajes = Comienzo($pageName, $IdiomaSitio);

if (!isset ($Modalidad))
	$Modalidad = 2;
if (!isset ($Caja))
	$Caja = 0;
if (!isset ($TipoGrafico))
	$TipoGrafico = 2;

// Completo con cero los valores de la matriz que se 
// va a usar para presentar la tabla

$filas = $AnioFinal - $Anio +1;
for ($j = 1; $j <= $filas; $j++) {
	for ($i = 0; $i <= 13; $i++) {
		$row[$j][$i] = 0;
	}
}

// Estos son los totalizadores por columna
for ($i = 1; $i <= 13; $i++) {
	$porcentaje[$i] = 0;
	$Suma_Total[$i] = 0;
}

if ($Modalidad == "") {
	$Modalidad = 2;
}

$Total_General = 0;
$Instruccion = Armar_Instruccion(1, $Modalidad);
$result = mysql_query($Instruccion);
echo mysql_error();
Calcular();
mysql_free_result($result);

$Instruccion = Armar_Instruccion(2, $Modalidad);
$result = mysql_query($Instruccion);
echo mysql_error();
Calcular();
mysql_free_result($result);

for ($i = 1; $i <= $filas; $i++) {
	$Suma_Total[13] += $row[$i][13];
}

// Calculo los porcentajes
for ($i = 1; $i <= 13; $i++) {
	if ($Total_General > 0) {
		$porcentaje[$i] = (100 * $Suma_Total[$i]) / $Total_General;
	}
}
?><head>
<title>PrEBi </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
<!--
body {
	margin:0px;
	background-color: #006599;
	margin-left: 10px;
	
}
body, td, th {
	color: #000000;
}
a:link {
	color: #006599;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #006599;
}
a:hover {
	text-decoration: underline;
	color: #0099FF;
}
a:active {
	text-decoration: none;
	color: #006599;
}
.style28 {color: #FFFFFF; font-size: 11px; }
.style43 {
	font-family: verdana;
	font-size: 10px;
	color: #000000;
}
.style49 {font-family: verdana; font-size: 10px; color: #006599; }
.style54 {font-family: verdana; font-size: 10px; color: #000000; }
.style55 {
	font-size: 10px;
	color: #000000;
	font-family: Verdana;
}
.style63 {
	font-size: 9px;
	font-family: Arial, Helvetica, sans-serif;
}
.style66 {color: #FFFFFF}
-->
</style>
<base target="_self">
<link rel="stylesheet" type="text/css" href="../css/celsiusStyles.css">
</head>

<body topmargin="0">
<div align="left">
<form method="POST" action="est-estadusact.php">
  <table width="780" border="0" cellpadding="0" cellspacing="0" bordercolor="#111111" bgcolor="#EFEFEF" style="border-collapse: collapse">
  <tr>
    <td bgcolor="#E4E4E4">
      <hr color="#E4E4E4" size="1">      <div align="center"><center>
        <table width="760" border="0" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="5">
      <tr bgcolor="#EFEFEF">
        <td bgcolor="#E4E4E4">
            <div align="center">
              <center>
            <table width="750" border="0" style="margin-bottom: 0; margin-top:0; border-collapse:collapse" bordercolor="#111111" cellpadding="0" cellspacing="0">
              <tr>
                <td valign="top" bgcolor="#E4E4E4">
                <table width="100%"  border="0" cellpadding="0" cellspacing="0" class="style43">
                <tr>
                	<td height="20" colspan="2" align="left" bgcolor="#006599" class="style45">
                		<img src="../images/square-lb.gif" width="8" height="8" border="0"><span class="style28"><? echo $Mensajes["ec-43"]?></span>
                	</td>
                </tr>
                <tr>
                    <td height="15" colspan="2" align="left" class="style45"><br>
                    <table width="97%"  border="0" align="center" cellpadding="1" cellspacing="0" class="table-form">
                    <tr>
                        <th>
                        	<div align="right"><? echo $Mensajes["tf-1"];?></div>
                        </th>
                        <td width="179" align="left">
                        	<input name="Anio" type="text" class="style43" value="<? echo $Anio; ?>">
							<input type="hidden" name="TPed" value="<? echo $TPed; ?>">
						</td>
                        <th>
                        	<div align="right"><? echo $Mensajes["tf-2"];?></div>
                        </th>
                        <td width="179" align="left">
                        	<input name="AnioFinal" type="text" class="style54" value="<? echo $AnioFinal; ?>">
                        </td>
                    </tr>
                    <tr>
                        <th>
                        	<div align="right"><? echo $Mensajes["tf-3"];?></div>
                        </th>
                        <td width="179" align="left">
                        	<select name="Modalidad" class="style54" size="1" style="width:150px">
                         		<option <? if ($Modalidad==1) { echo "selected"; } ?> value="1"><? echo $Mensajes["opc-1"];?></option>
                         		<option <? if ($Modalidad!=1) { echo "selected"; } ?> value="2"><? echo $Mensajes["opc-2"];?></option>
       				     	</select>
       				    </td>
                        <th>
                        	<div align="right"><? echo $Mensajes["tf-6"];?> </div>
                        </th>
                        <td width="179" align="left">
                        	<select name="TipoGrafico" class="style54" size="1" style="width:150px">
                        		<option <? if ($TipoGrafico==1) { echo "selected"; } ?> value="1"><? echo $Mensajes["otg-1"];?></option>
                        		<option <? if ($TipoGrafico!=1) { echo "selected"; } ?> value="2"><? echo $Mensajes["otg-2"];?></option>
     						</select>
     					</td>
                    </tr>
                    <tr valign="middle">
                        <td colspan="4" class="style43">
							<div align="center">
                            	<input name="B1" type="submit" class="style43" value="<? echo $Mensajes["bot-1"];?>">
                          	</div>
                        </td>
                    </tr>
                    </table>
					</form>
                      <hr></td>
                  </tr>
      <?

$buffer = '';
$Titulo = $Mensajes["ec-44"];
?>
           <tr valign="top">
             <td colspan="2" align="left" class="style45">
             <div align="left">
             <p><span class="style54"><img src="../images/sa6.gif" width="8" height="10"><? echo $Titulo; ?>.</span></p>
             </div>
    <?

if ($Modalidad == 1) {
?>
		  <table width="97%"  border="0" align="center" cellpadding="1" cellspacing="1" bordercolor="#CCCCCC" class="style43">
    <?

} else {
?>
          <table border="0" cellpadding="1" cellspacing="1" width="30%" bordercolor="#CCCCCC" align="center" class="style43">
    <?

}
?>
		  <tr bordercolor="#CCCCCC" bgcolor="#006699" class="style28">
  		    <td align="right"><span class="style66"><? echo $Mensajes["ec-1"]; $buffer .= $Mensajes["ec-1"]; ?></span></td>
    <?

if ($Modalidad == 1) {
	for ($i = 1; $i <= 12; $i++) {
?>
	     	  <td align="center"><span class="style66"><?

		echo TraduccionesUtils :: Traducir_Mes($i, $VectorIdioma, true);
		$buffer .= "," . TraduccionesUtils :: Traducir_Mes($i, $VectorIdioma, true);
?></span></td>
    <?

	} //del for
} ///del if
?>
  			<td align="center" class="style28"><? echo $Mensajes["ec-2"]; $buffer .= ",".$Mensajes["ec-2"]; ?> </td>
                        </tr>
    <?

for ($i = 1; $i <= $filas; $i++) {
?>
                 <tr bordercolor="#CCCCCC">
                     <td align="right" bgcolor="#CCCCCC"><? echo $Anio+$i-1; $buffer .= "\n".($Anio+$i-1); ?></td>
    <?

	if ($Modalidad == 1) {
		for ($j = 1; $j <= 13; $j++) {
?>
                      <td align="center" bgcolor="#ECECEC"><? echo $row[$i][$j]; $buffer .= ','.$row[$i][$j]; ?></td>
     <?

		}
	} else {
?>
                      <td align="center" bgcolor="#ECECEC"><? echo $row[$i][13]; $buffer .= ','.$row[$i][13]; ?></td>
     <?

	}
?>
					</tr>
     <?

}
?>
					<tr bordercolor="#CCCCCC">
                       <td align="right" bgcolor="#CCCCCC"><? echo $Mensajes["ec-3"]; $buffer .= "\n ".$Mensajes["ec-32"]; ?></td>
     <?

if ($Modalidad == 1) {
	for ($i = 1; $i <= 12; $i++) {
?>
                        	  <td align="center" bgcolor="#ECECEC"><? echo $Suma_Total[$i]; $buffer .= ','.$Suma_Total[$i]; ?></td>
     <?

	} ///del for
} //del if
?>
                        <td align="center" bgcolor="#ECECEC"><? echo $Total_General; $buffer .= ','.$Total_General; ?>
                        </td>
						</tr>
                     	<tr bordercolor="#CCCCCC">
                          <td align="right" bgcolor="#CCCCCC"><? echo $Mensajes["ec-4"]; $buffer .= "\n ".$Mensajes["ec-4"]; ?></td>
     <?

if ($Modalidad == 1) {
	for ($i = 1; $i <= 12; $i++) {
?>
		                         <td align="center" bgcolor="#ECECEC"><? echo number_format($porcentaje[$i],2); $buffer .= ','.number_format($porcentaje[$i],2)."%"; ?></td>
	 <?

	} //del for
} //del if
?>
                 <td align="center" bgcolor="#ECECEC"><? echo number_format($porcentaje[13],2)."%"; $buffer .= ','.number_format($porcentaje[13],2)."%"; ?></td>
             </tr>
           </table>
           <br>
<?

function retornar_labels($Modalidad) {
	global $row;
	global $VectorIdioma;
	global $filas;

	$devuelvo = "";
	$cadena = "";
	if ($Modalidad == 1) {
		for ($j = 1; $j <= $filas; $j++) {
			$cadena .= $row[$j][0] . ",";
		}
		$cadena = substr($cadena, 0, strlen($cadena) - 1);
		$devuelvo .= "<param name=seriesLabels value=" . $cadena . ">\n";
		$cadena = "";
		for ($i = 1; $i <= 12; $i++) {
			$cadena .= TraduccionesUtils :: Traducir_Mes($i, $VectorIdioma) . ",";
		}
		$cadena = substr($cadena, 0, strlen($cadena) - 1);
		$devuelvo .= "<param name=sampleLabels value=" . $cadena . ">\n";
	} else {
		for ($j = 1; $j <= $filas; $j++) {
			$cadena .= $row[$j][0] . ",";
		}
		$cadena = substr($cadena, 0, strlen($cadena) - 1);
		$devuelvo .= "<param name=sampleLabels value=" . $cadena . ">\n";
	}
	return $devuelvo;
}

function retornar_valores($Modalidad) {
	global $filas;
	global $row;

	$devuelvo = "";
	if ($Modalidad == 1) {
		for ($j = 1; $j <= $filas; $j++) {
			$cadena = "";
			for ($i = 1; $i <= 12; $i++) {
				$cadena .= $row[$j][$i] . ",";
			}

			$indice = $j -1;
			$cadena = substr($cadena, 0, strlen($cadena) - 1);
			$devuelvo .= "<param name=sampleValues_" . $indice . " value=" . $cadena . ">";
		}
	} else {
		$cadena = "";
		for ($j = 1; $j <= $filas; $j++) {
			$cadena .= $row[$j][13] . ",";

		}
		$cadena = substr($cadena, 0, strlen($cadena) - 1);
		$devuelvo .= "<param name=sampleValues_0 value=" . $cadena . ">";
	}
	return $devuelvo;
}
?>
    <hr></td>
    </tr>
    <tr valign="top">
     <td colspan="2" align="left" class="style45"><p class="style54"><img src="../images/sa6.gif" width="8" height="10"> <? echo $Mensajes["mensaje.usuariosPorMesAnio"]; ?> </p>
        <table width="70%"  border="0" align="center" cellpadding="0" cellspacing="0">
           <tr>
            <td>		<?

// Calculo el tamaño del gráfico de acuerdo a la cantidad
// de series a presentar

if ($Modalidad == 1) {
	$alto = 580;
	$ancho = 270;
} else {
	$alto = 400;
	$ancho = 300;
}
?>

   	<table width="70%">
	 <tr> <td width="70%">

		<?


if ($TipoGrafico == 1) {
?>
		
		<applet code="com.objectplanet.gui.BarChartApplet" archive=com.objectplanet.gui.BarChartApplet.jar
		width=<? echo $alto; ?> height=<? echo $ancho; ?> name="BarChart" VIEWASTEXT>
		<param name=seriesCount value="<? if ($Modalidad==1) { echo $filas;} else { echo "1"; } ?>">
		
		<param name=sampleCount value="<? if ($Modalidad==1) { echo "12";} else { echo $filas; } ?>">
		<?

	echo retornar_valores($Modalidad);
?>
		<param name=barLabelsOn value=true>
		<param name=legendOn value=true>
		<param name=valueLinesOn value=true>
		<param name=multiColorOn value=true>
		<param name=barOutlineOff value=true>
		<param name=3DModeOn value=true>
		<param name=chartTitle value="<? echo $Titulo; ?>">
		
		<?

	echo retornar_labels($Modalidad);
?>
		
		<param name=barWidth value="0.6">
		<param name=titleFont value="Ms Sans Serif, bold, 18">
		<param name=sampleColors value="<? echo Opciones_Color()?>">
		
		<param name=multiSeriesOn value=true>
		</applet> 
		<? } else {?>
		<applet code=com.objectplanet.gui.PieChartApplet archive=com.objectplanet.gui.PieChartApplet.jar 
		   width=<? echo $alto; ?> height=<? echo $ancho; ?>>
		<param name=seriesCount value="<? if ($Modalidad==1) { echo $filas;} else { echo "1"; } ?>">
		<?

	echo retornar_valores($Modalidad);
?>
		<param name=chartTitle value="<? echo $Titulo; ?>">
		<?

	echo retornar_labels($Modalidad);
?>
		<PARAM NAME="selectionstyle" VALUE="detached">
		<PARAM NAME="detacheddistance" VALUE="0.2">
		<param name=graphInsets value="-1,-1,-1,-1">
		<param name=sampleColors value=<? echo Opciones_Color(); ?>>
		<param name=titleFont value="Ms Sans Serif, bold, 14">
		<param name=valueLabelsOn value=true>
		<param name=sampleLabelsOn value=true>
		<param name=percentLabelsOn value=true>
		<param name=pieLabelsOn value=true>
		<param name=legendOn value=true>
		<param name=3DModeOn value=true>
		<param name=sliceSeperatorOn value=true>
		</applet>
		<? } ?>

</td>
</tr>
</table>
<div align="right"><br>
</div>
<div align="center"><a href='javascript:direct_export()'><img src="/images/files/xls.jpg" width="17" height="17" border="0"></a></div></td>
</tr>
</table>
</td>
</tr>
</table>
</center>
</div>
</td>
<td width="150" valign="top" bgcolor="#E4E4E4"><div align="center" class="style11">
    <table width="100%" bgcolor="#ececec">
       <tr>
         <td valign="top" class="style28"><div align="center"><img src="../images/image001.jpg" width="150" height="118" border="0"><br>
         <span class="style54"><a href="main-estadisticas.php"><? echo $Mensajes["h-1"]; ?></a></font></span></div>                <div align="center" class="style55"></div></td>
        </tr>
          </table>
          </div>
          </td>
        </tr>
    </table>    </center>
      </div>    </td>
  </tr>
            <?php


	DibujarBarraInferior();
?>
  <tr>
    <td height="44" bgcolor="#E4E4E4"><div align="center">
      <hr>
      <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="50">&nbsp;</td>
          <td><div align="center"><a href="http://www.unlp.istec.org/prebi" target="_blank"><img src="../images/logos/logo-prebi.jpg" alt="PrEBi | UNLP" name="PrEBi | UNLP" width="100" border="0" lowsrc="../PrEBi%20:%20UNLP"></a> </div></td>
          <td width="50" class="style49"><div align="center" class="style11 style63">nmp-001</div></td>
        </tr>
      </table>
      </div></td>
  </tr>
</table>
</div>
		<form name="formExport" action="exp_est.php">
  <input type='hidden' name='datos' value='<? echo $buffer; ?>'>
  <input type='hidden' name='mifilename' value='estadusact.csv'>
  
</form>

<script>
function direct_export()
{
  document.forms.formExport.submit();
}
</script>

<div style='position:absolute;left:720;top:430'>


</div>

</body>
</html>
