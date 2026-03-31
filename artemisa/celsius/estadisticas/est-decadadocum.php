<?
$pageName = "estadisticas1";
require "../layouts/top_layout_admin.php";
require_once "metodos_estadisticas.php";
// Estas funciones son específicas de cálculo
// mas abajo están las específicas de graficación

function Calcular() {
	global $result;
	global $Suma_Total;
	global $Total_General;
	global $Anio;
	global $row;
	global $SumaAnios;
	global $SumaPaises;

	while ($rowg = mysql_fetch_row($result)) {

		if ($rowg[0] >= 1 && $rowg[0] <= 13) {
			$filacorrecta = $rowg[0] + 1;
		} else {
			$filacorrecta = 1;
		}

		$row[$filacorrecta][$rowg[2] - $Anio +1] += $rowg[1];
		$SumaAnios[$rowg[2] - $Anio +1] += $rowg[1];
		$SumaPaises[$filacorrecta] += $rowg[1];
		$Total_General += $rowg[1];

	}

}

function Armar_Instruccion($dedonde) {
	global $TPed;
	global $Anio;
	global $AnioFinal;
	global $Caja;

	$Instruccion = "SELECT TRUNCATE(MOD(Anio_Revista,1900)/10,0) AS Decada,COUNT(*),YEAR(Fecha_Alta_Pedido) AS p ";
	if ($dedonde == 1) {
		$Instruccion .= "FROM pedhist ";
	} else {
		$Instruccion .= "FROM pedidos ";
	}
	$Instruccion .= "WHERE YEAR(Fecha_Alta_Pedido)>=" . $Anio . " AND YEAR(Fecha_Alta_Pedido)<=" . $AnioFinal;
	$Instruccion .= " AND Tipo_Pedido=" . $TPed . " AND Anio_Revista<>\"\"";

	if ($Caja == ESTADO__ENTREGADO_IMPRESO || $Caja == ESTADO__CANCELADO) {
		if ($dedonde == 1) {
			$Instruccion .= " AND Estado=" . $Caja;
		} else {
			$Instruccion .= " AND Estado=" . ESTADO__RECIBIDO;
		}
	}

	$Instruccion .= " GROUP BY p,Decada";

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

$row[1][0] = "1-1909";
$AnioLim = "1910";
for ($i = 2; $i <= 13; $i++) {
	$row[$i][0] = str_replace(".", "", number_format($AnioLim, 0, ".", ".") . "-" . number_format($AnioLim +9, 0, ".", "."));
	$AnioLim += 10;
}

$columnastope = $AnioFinal - $Anio +1;
for ($filas = 1; $filas <= 13; $filas++) {
	for ($columnas = 1; $columnas <= $columnastope; $columnas++) {
		$row[$filas][$columnas] = 0;
	}
}

// Inicializo otros totales la Suma por Paises
// los porcentajes por Países y las Sumas por Columnas, es decir años
for ($filas = 1; $filas <= 13; $filas++) {
	$SumaPaises[$filas] = 0;
	$PorcentajePaises[$filas] = 0;
}

for ($columnas = 1; $columnas <= $columnastope; $columnas++) {
	$SumaAnios[$columnas] = 0;
	$PorcentajeAnios[$columnas] = 0;
}

// Encabezo las columnas con los valores que corresponden a los años
$Total_General = 0;
for ($i = $Anio; $i <= $AnioFinal; $i++) {
	$row[0][$i - $Anio +1] = $i;
}

$Instruccion = Armar_Instruccion(1);
$result = mysql_query($Instruccion);
echo mysql_error();
Calcular();
mysql_free_result($result);

if ($Caja != ESTADO__CANCELADO) {
	$Instruccion = Armar_Instruccion(2);
	$result = mysql_query($Instruccion);
	echo mysql_error();
	Calcular();
	mysql_free_result($result);
}

// Calculo los porcentajes
for ($i = 1; $i <= 13; $i++) {
	if ($SumaPaises[$i] > 0) {
		$PorcentajePaises[$i] = (100 * $SumaPaises[$i]) / $Total_General;
	}
}

for ($i = 1; $i <= $columnastope; $i++) {
	if ($SumaAnios[$i] > 0) {
		$PorcentajeAnios[$i] = (100 * $SumaAnios[$i]) / $Total_General;
	}
}
?>

<head>
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
.style54 {font-family: verdana; font-size: 9px; color: #000000; }
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
<table width="760" border="0" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="5">
      <tr bgcolor="#EFEFEF">
        <td bgcolor="#E4E4E4">
            <div align="center">
            <form method="POST" action="est-decadadocum.php">
              <center>
<table width="576" border="0" style="margin-bottom: 0; margin-top:0; border-collapse:collapse" bordercolor="#111111" cellpadding="0" cellspacing="0">
              <tr>
                <td valign="top" bgcolor="#E4E4E4"><table width="100%"  border="0" cellpadding="0" cellspacing="0" class="style43">
                  <tr>
                    <td height="20" colspan="2" align="left" bgcolor="#006599" class="style45"><img src="../images/square-lb.gif" width="8" height="8" border="0"> <span class="style28"><? echo $Mensajes["tit-25"]; ?></span></td>
                  </tr>
                  <tr>
                    <td height="15" colspan="2" align="left" class="style45"><br>                      
                   	<table width="97%"  border="0" align="center" cellpadding="1" cellspacing="0" class="table-form">
                    <tr>
                        <th>
                        	<div align="right"><? echo $Mensajes["tf-1"]; ?></div>
                        </th>
                        <td width="179" align="left">
                        	<input name="Anio" value="<? echo $Anio; ?>" type="text" class="style43">
                        	<input type="hidden" name="TPed" value="<? echo $TPed; ?>">                        
                        </td>
                        <th>
                        	<div align="right"><? echo $Mensajes["tf-2"]; ?></div>
                        </th>
                        <td width="179" align="left">
                        	<input name="AnioFinal"  value="<? echo $AnioFinal; ?>" type="text" class="style54">
                        </td>
                    </tr>
                    <tr>
                        <th>
                        	<div align="right"><? echo $Mensajes["tf-3"]; ?></div>
                        </th>
                        <td width="179" align="left">
                        	<select name="Modalidad" class="style54" size="1" style="width:150px">
                         		<option <? if ($Modalidad==1) { echo "selected"; } ?> value="1"><? echo $Mensajes["opc-3"]; ?></option>
                         		<option <? if ($Modalidad!=1) { echo "selected"; } ?> value="2"><? echo $Mensajes["opc-4"]; ?></option>
                         	</select>
                        </td>
                        <th>
                        	<div align="right"><? echo $Mensajes["tf-6"]; ?></div>
                        </th>
                        <td width="179" align="left">
                        	<select name="TipoGrafico" class="style54" size="1" style="width:150px">
                           		<option <? if ($TipoGrafico==1) { echo "selected"; } ?> value="1"><? echo $Mensajes["otg-1"]; ?></option>
                           		<option <? if ($TipoGrafico!=1) { echo "selected"; } ?> value="2"><? echo $Mensajes["otg-2"]; ?></option>
                           	</select>
                       	</td>
                    </tr>
                    <tr>
                        <th>
                        	<div align="right"><? echo $Mensajes["tf-5"]; ?></div>
                        </th>
                        <td width="179" align="left">
                        	<select name="Caja" class="style54" size="1" style="width:150px">
                        		<option <? if ($Caja==0) { echo "selected"; } ?> value="0"><? echo $Mensajes["otp-1"]; ?></option>
                        		<option <? if ($Caja==ESTADO__ENTREGADO_IMPRESO) { echo "selected"; } ?> value="<? echo ESTADO__ENTREGADO_IMPRESO; ?>"><? echo $Mensajes["otp-2"]; ?></option>
                        		<option <? if ($Caja==ESTADO__CANCELADO) { echo "selected"; } ?> value="<? echo ESTADO__CANCELADO; ?>"><? echo $Mensajes["otp-3"]; ?></option>
                        	</select>
                        </td>
                        <th>
                        	&nbsp;
                        </th>
                        <td>
                        	&nbsp;
                        </td>
                    </tr>
                    <tr valign="middle">
                        <td colspan="4" class="style43">
                        	<div align="center">
                            	<input name="B1" type="submit" class="style43" value="<? echo $Mensajes["bot-1"];?>">
                          	</div
						</td>
                    </tr>
                    </table>
                    </form>
                      <hr></td>
                  </tr>
                  <tr valign="top">
                    <td colspan="2" align="left" class="style45">
                      <div align="left">
                        <p><span class="style54"><img src="../images/sa6.gif" width="8" height="10">
<?


switch ($Caja) {
	case ESTADO__ENTREGADO_IMPRESO :
		$Titulo = $Mensajes["otp-2"];
		break;
	case ESTADO__CANCELADO :
		$Titulo = $Mensajes["otp-3"];
		break;
	default :
		$Titulo = $Mensajes["otp-1"];
		break;
}
$buffer = '';
$Titulo .= " - " . $Mensajes["tit-23"];
echo $Titulo . " - " . $Mensajes["tf-4"];
?>
</span></p>
</div>
  <table width="97%"  border="0" align="center" cellpadding="1" cellspacing="1" bordercolor="#CCCCCC" class="style43">
  <tr bordercolor="#CCCCCC" bgcolor="#006699" class="style28">
       <td align="right"><span class="style66"><? echo $Mensajes["ec-25"]; $buffer .= $Mensajes["ec-25"]; ?></span></td>
         <?


if ($Modalidad == 1) {
	for ($i = 1; $i <= $columnastope; $i++) {
?>
                   <td align="center"><span class="style66"><? echo $row[0][$i]; $buffer .= ','.$row[0][$i];?></span></td>
        	<?


	}
}
?>
           <td align="center" class="style28"><? echo $Mensajes["ec-8"]; $buffer .= ','.$Mensajes["ec-8"]; ?></td>
           <td align="center" class="style28"><? echo $Mensajes["ec-4"]; $buffer .= ','.$Mensajes["ec-4"]; ?> </td>
        </tr>
          <?


$descuento = 0;
for ($i = 1; $i <= 13; $i++) {
	if ($SumaPaises[$i] > 0) {
		$buffer .= "\n";
?>
   <tr bordercolor="#CCCCCC">
                          <td align="right" bgcolor="#CCCCCC"><? echo $row[$i][0]; $buffer .= $row[$i][0]; ?>&nbsp;</a></td>
   <?


		// descuento sirve para descontar las filas de países que 
		// no voy a contar. A fines de graficar
		if ($Modalidad == 1) {
			for ($j = 1; $j <= $columnastope; $j++) {
?> 
         <td align="center" bgcolor="#ECECEC"><? echo $row[$i][$j]; $buffer .= ','.$row[$i][$j]; ?></td>
        <?


			}

		}
?>
       <td align="center" bgcolor="#ECECEC"><? echo $SumaPaises[$i]; $buffer .= ','.$SumaPaises[$i]; ?></td>
       <td align="center" bgcolor=	"#ECECEC"><? echo number_format($PorcentajePaises[$i],2); $buffer .= ','.number_format($PorcentajePaises[$i],2)."%"; ?></td>
      </tr>
        <?


	} else {
		$descuento += 1;
	}
}
?>
	

    <tr bordercolor="#CCCCCC">
         <td align="right" bgcolor="#CCCCCC"><? echo $Mensajes["ec-3"]; $buffer .= "\n".$Mensajes["ec-3"]; ?></td>
      <?


if ($Modalidad == 1) {
	for ($i = 1; $i <= $columnastope; $i++) {
?>
		<td align="center" bgcolor="#ECECEC"><? echo $SumaAnios[$i]; $buffer .= ','.$SumaAnios[$i]; ?></td>
             <?


	}
}
?>
             <td align="center" bgcolor="#ECECEC">&nbsp;<? echo $Total_General; $buffer .= ','.$Total_General; ?></td>
             <td align="center" bgcolor="#ECECEC">&nbsp;<? echo "100.00%"; $buffer .= ",100.00%";?></td>
      </tr>
      <tr bordercolor="#CCCCCC">
             <td align="right" bgcolor="#CCCCCC">&nbsp;<? echo $Mensajes["ec-4"]; $buffer .= "\n".$Mensajes["ec-4"]; ?></td>
              <?


if ($Modalidad == 1) {
	for ($i = 1; $i <= $columnastope; $i++) {
?>
                  <td align="center" bgcolor="#ECECEC"><? echo number_format($PorcentajeAnios[$i],2); $buffer .= ','.number_format($PorcentajeAnios[$i],2)."%"; ?></td>
               <?


	}
}
?>
              <td align="center" bgcolor="#ECECEC"><? echo "100.00%"; $buffer .= ",100.00%";?></td>
               <td align="center" bgcolor="#ECECEC"></td>
                                 </tr>
                      </table>
                      <br>
               <?


// Estas funciones son específicas de 
// graficación

function retornar_labels($Modalidad) {
	global $row;
	global $columnastope;
	global $VectorIdioma;
	global $Mensajes;

	if ($Modalidad == 1) {
		$cadena = "";
		for ($j = 1; $j <= $columnastope; $j++) {
			$cadena .= $row[0][$j] . ",";
		}
		$cadena = substr($cadena, 0, strlen($cadena) - 1);
		return "<param name=sampleLabels value=" . $cadena . ">";
	} else {
		return "<param name=sampleLabels value=" . $Mensajes["opc-4"] . ">";
	}

}

function retornar_series() {
	global $row;
	global $tope;
	global $SumaPaises;

	$cadena = "";
	for ($j = 1; $j <= 13; $j++) {
		if ($SumaPaises[$j] > 0) {
			$cadena .= $row[$j][0] . ",";
		}
	}
	$cadena = substr($cadena, 0, strlen($cadena) - 1);
	return "<param name=seriesLabels value=\"" . $cadena . " \">";

}

function retornar_valores($Modalidad) {
	global $row;
	global $tope;
	global $columnastope;
	global $SumaPaises;

	$valores = "";
	$indice = 0;
	for ($j = 1; $j <= 13; $j++) {
		if ($SumaPaises[$j] > 0) {
			$cadena = "";
			if ($Modalidad == 1) {
				for ($i = 1; $i <= $columnastope; $i++) {
					$cadena .= $row[$j][$i] . ",";
				}
			} else {
				$cadena = $SumaPaises[$j] . ",";
			}

			$cadena = substr($cadena, 0, strlen($cadena) - 1);
			$valores .= "<param name=sampleValues_" . $indice++ . " value=" . $cadena . ">\n";
		}
	}
	return $valores;
}
?>



                      <hr></td>
                    </tr>
                  <tr valign="top">
                    <td colspan="2" align="left" class="style45"><p class="style54"><img src="../images/sa6.gif" width="8" height="10"> Gr&aacute;fico. </p>
                    <table width="93%"  border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                          <td>		<?


// Calculo el tamaño del gráfico de acuerdo a la cantidad
// de series a presentar

$alto = 500;
$ancho = 300;

if ($TipoGrafico == 1) {
?>
		
		<applet code="com.objectplanet.gui.BarChartApplet" archive=com.objectplanet.gui.BarChartApplet.jar
		width=<? echo $alto; ?> height=<? echo $ancho; ?> name="BarChart" VIEWASTEXT>
		<param name=seriesCount value="<? echo (13 - $descuento) ?>">
		
		<param name=sampleCount value="<?  echo $columnastope;  ?>">
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


	echo retornar_series();
	echo retornar_labels($Modalidad);
?>
		
		<param name=barWidth value="0.6">
		<param name=titleFont value="Ms Sans Serif, bold, 14">
		<param name=sampleColors value="<? echo Opciones_Color()?>">
		
		<param name=multiSeriesOn value=true>
		</applet> 
		<?


} else {
?>
		<applet code=com.objectplanet.gui.PieChartApplet archive=com.objectplanet.gui.PieChartApplet.jar 
		   width=<? echo $alto; ?> height=<? echo $ancho; ?>>
		<param name=seriesCount value="<? echo (13 - $descuento); ?>">
		<?


	echo retornar_valores($Modalidad);
?>
		<param name=chartTitle value="<? echo $Titulo; ?>">
		<?


	echo retornar_series();
	echo retornar_labels($Modalidad);
?>
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
		<PARAM NAME="selectionstyle" VALUE="detached">
		<PARAM NAME="detacheddistance" VALUE="0.2">		
		</applet>
		
		<? } ?>

</td>
                        </tr>
                      </table>
                      <div align="right"><br>
                      </div>
                      <div align="center"><a href='javascript:direct_export()'><img src="../images/files/xls.jpg" width="17" height="17" border="0"></a></div></td>
                  </tr>
                </table>                  </td>
              </tr>
            </table>
              </center>
            </div>
            </td>
		<form name="formExport" action="exp_est.php">
  			<input type='hidden' name='datos' value='<? echo $buffer; ?>'>
  			<input type='hidden' name='mifilename' value='decadadocum.csv'>
		</form>

		<script>
			function direct_export()
			{
  			document.forms.formExport.submit();
			}
		</script>




        <td width="150" valign="top" bgcolor="#E4E4E4"><div align="center" class="style11">
          <table width="100%" bgcolor="#ececec">
            <tr>
              <td valign="top" class="style28"><div align="center"><img src="../images/image001.jpg" width="150" height="118" border="0"><br>
                <span class="style54"><a href="main-estadisticas.php"><? echo $Mensajes["h-2"];?></a></span></div>                <div align="center" class="style55"></div></td>
            </tr>
          </table>
          </div>
          </td>
        </tr>
    </table>   
    
<?


	$pageName = "estadisticas1";
	require "../layouts/base_layout_admin.php";
?>