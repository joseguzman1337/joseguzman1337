<?
$pageName = "estadisticas1";
require_once "../common/includes.php";
require_once "metodos_estadisticas.php";
?>
<html>
<head>
<title>PrEBi</title>
</head>

<body background="../imagenes/banda.jpg">

<?


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
	global $hash;

	while ($rowg = mysql_fetch_row($result)) {
		// Si $rowg[3]==0 implica que son Pedidos Cancelados
		// que no llegaron a pedirse a ningun país

		if ($rowg[3] > 0) {

			$filacorrecta = $hash[$rowg[3]];

			$row[$filacorrecta][$rowg[0] - $Anio +1] += $rowg[2];
			$SumaAnios[$rowg[0] - $Anio +1] += $rowg[2];
			$SumaPaises[$filacorrecta] += $rowg[2];
			$Total_General += $rowg[2];
		}

	}

}

function Armar_Instruccion($dedonde) {
	global $TPed;
	global $Anio;
	global $AnioFinal;
	global $Caja;
	global $Institucion;

	$Instruccion = "SELECT YEAR(Fecha_Alta_Pedido) AS p,tab_categ_usuarios.Nombre,COUNT(*),tab_categ_usuarios.Id ";
	if ($dedonde == 1) {
		$Instruccion .= "FROM pedhist ";
		$Instruccion .= "LEFT JOIN usuarios ON usuarios.Id=pedhist.Codigo_Usuario ";
	} else {
		$Instruccion .= "FROM pedidos ";
		$Instruccion .= "LEFT JOIN usuarios ON usuarios.Id=pedidos.Codigo_Usuario ";
	}
	$Instruccion .= "LEFT JOIN tab_categ_usuarios ON tab_categ_usuarios.Id=usuarios.Codigo_Categoria ";
	$Instruccion .= "WHERE YEAR(Fecha_Alta_Pedido)>=" . $Anio . " AND YEAR(Fecha_Alta_Pedido)<=" . $AnioFinal;
	$Instruccion .= " AND Tipo_Pedido=" . $TPed;

	if ($Caja == ESTADO__ENTREGADO_IMPRESO || $Caja == ESTADO__CANCELADO) {
		if ($dedonde == 1) {
			$Instruccion .= " AND Estado=" . $Caja;
		} else {
			$Instruccion .= " AND Estado=" . ESTADO__RECIBIDO;
		}
	}

	$Instruccion .= " GROUP BY p,tab_categ_usuarios.Id";
	$Instruccion .= " ORDER BY p,tab_categ_usuarios.Nombre";

	return $Instruccion;
}

global $IdiomaSitio;
$Mensajes = Comienzo($pageName, $IdiomaSitio);
?>
<p align="center">
<br>

<form name="form1" method="POST" action="funcionusped.php">
<table border="0" width="75%" bgcolor="#666699" cellspacing="0" height="23" align="center">
  <tr>
    <td width="10%" bgcolor="#666699" valign="top" height="2">
      &nbsp;</td>
    <td width="20%" bgcolor="#666699" valign="top" height="2">
      &nbsp;</td>
    <td width="20%" bgcolor="#666699" valign="top" height="1">     
    &nbsp;     
    </td>
    <td width="20%" bgcolor="#666699" valign="top" height="1">
    &nbsp;
    </td>
    <td width="20%" bgcolor="#666699" valign="top" height="1">
    &nbsp;
    </td>
    <td width="10%" bgcolor="#666699" valign="top" height="1">
    &nbsp;
  </tr>
  <tr>
    <td width="10%" align="left" bgcolor="#666699" valign="middle" height="15">
      &nbsp;</td>
    <td width="20%" align="right" bgcolor="#666699" valign="middle" height="15">
      <font color="#FFFFCC" size="1" face="MS Sans Serif"><? echo $Mensajes["tf-1"]; ?> </font> </td>
     <td width="20%" align="left" bgcolor="#666699" valign="middle" height="15">
      <input type="text" name="Anio" size="11" style="font-family: MS Sans Serif; font-size: 10 px; font-weight: bold" value="<? echo $Anio; ?>">
      <input type="hidden" name="TPed" value="<? echo $TPed; ?>">
    </td>
    <td width="20%" align="right" bgcolor="#666699" valign="middle" height="15">
		<font face="MS Sans Serif" size="1" color="#FFFFCC"><? echo $Mensajes["tf-2"]; ?></font>
    </td>
    <td width="20%" align="left" bgcolor="#666699" valign="middle" height="15">
	       <input type="text" name="AnioFinal" size="10" style="font-family: MS Sans Serif; font-size: 10 px; font-weight: bold" value="<? echo $AnioFinal; ?>"></font>
    </td>
    <td width="10%" align="left" bgcolor="#666699" valign="middle" height="15">
      &nbsp;</td>
  </tr>
  <tr>
    <td width="10%" align="right" bgcolor="#666699" valign="middle" height="29">
      &nbsp;</td>
    <td width="20%" align="right" bgcolor="#666699" valign="middle" height="29">
      <font face="MS Sans Serif" size="1" color="#FFFFCC"><? echo $Mensajes["tf-3"]; ?></font></td>
    <td width="20%" align="left" bgcolor="#666699" valign="middle" height="29">     
     <select size="1" name="Modalidad" style="font-family: MS Sans Serif; font-size: 10 px">
     <option  value="1" <? if ($Modalidad==1) { echo "selected"; } ?>><? echo $Mensajes["opc-3"]; ?></option>
     <option value="2" <? if ($Modalidad!=1) { echo "selected"; } ?> ><? echo $Mensajes["opc-4"]; ?></option>
     </select>
    </td>
    <td width="20%" align="right" bgcolor="#666699" valign="middle" height="29">     
	     <font face="MS Sans Serif" size="1" color="#FFFFCC"><? echo $Mensajes["tf-6"]; ?></font></td>
 	</td>
    <td width="20%" align="left" bgcolor="#666699" valign="middle" height="29">     
	 <select size="1" name="TipoGrafico" style="font-family: MS Sans Serif; font-size: 10 px">
     <option <? if ($TipoGrafico==1) { echo "selected"; } ?> value="1"><? echo $Mensajes["otg-1"]; ?></option>
     <option <? if ($TipoGrafico!=1) { echo "selected"; } ?> value="2"><? echo $Mensajes["otg-2"]; ?></option>
     </select>
    </td>      
	 <td width="10%" align="right" bgcolor="#666699" valign="middle" height="29">     
		&nbsp;
    </td>    
   </tr>
   <tr>
    <td width="10%" align="left" bgcolor="#666699" valign="middle" height="29">
      &nbsp;</td>
    <td width="20%" align="right" bgcolor="#666699" valign="middle" height="29">
            <font face="MS Sans Serif" size="1" color="#FFFFCC"><? echo $Mensajes["tf-5"]; ?></font></td>
	<td width="20%" align="left" bgcolor="#666699" valign="middle" height="29">
	     <select size="1" name="Caja" style="font-family: MS Sans Serif; font-size: 10 px">
         <option <? if ($Caja==0) { echo "selected"; } ?> value="0"><? echo $Mensajes["otp-1"]; ?></option>
         <option <? if ($Caja==ESTADO__ENTREGADO_IMPRESO) { echo "selected"; } ?> value="<? echo ESTADO__ENTREGADO_IMPRESO; ?>"><? echo $Mensajes["otp-2"]; ?></option>
         <option <? if ($Caja==ESTADO__CANCELADO) { echo "selected"; } ?> value="<? echo ESTADO__CANCELADO; ?>"><? echo $Mensajes["otp-3"]; ?></option>
         </select>
    </td>
	<td width="20%" align="left" bgcolor="#666699" valign="middle" height="29">
      &nbsp;</td>
	<td width="20%" align="left" bgcolor="#666699" valign="middle" height="29">
      &nbsp;</td>
	<td width="10%" align="left" bgcolor="#666699" valign="middle" height="29">
      &nbsp;</td>
	</tr>
	<tr>
	<td width="10%" align="left" bgcolor="#666699" valign="middle" height="29">
      &nbsp;</td>
    <td width="20%" align="left" bgcolor="#666699" valign="middle" height="29">
      &nbsp;</td>
	<td width="20%" align="left" bgcolor="#666699" valign="middle" height="29">
	      <input type="submit" value="<? echo $Mensajes["bot-1"];?>" name="B1" style="font-family: MS Sans Serif; font-size: 10 px; font-weight: bold">
      </td>
	<td width="20%" align="left" bgcolor="#666699" valign="middle" height="29">
	 &nbsp;
    </td>
	<td width="30%" align="left" bgcolor="#666699" valign="top" height="29" colspan="2">	      
	     <font face="MS Sans Serif" size="1"><a href="estadus.php"><font color="#FFFFCC"><? echo $Mensajes["h-1"]; ?></font></a></font>
     </td>
	
  </tr>
   <tr>
    <td width="10%" align="left" bgcolor="#666699" valign="top" height="2">
      &nbsp;</td>
    <td width="20%" align="left" bgcolor="#666699" valign="top" height="2">
      &nbsp;</td>
    <td width="20%" align="left" bgcolor="#666699" valign="top" height="1">     
    &nbsp;     
    </td>
    <td width="20%" align="left" bgcolor="#666699" valign="top" height="1">
    &nbsp;
    </td>
    <td width="20%" align="right" bgcolor="#666699" valign="top" height="1">
    &nbsp;
    </td>
    <td width="10%" align="left" bgcolor="#666699" valign="top" height="1">
    &nbsp;
  </tr>
 </table>
</form>


<p align="center"><font face="MS Sans Serif" size="1" color="#000080"><b>
<?


// Obtengo la tabla con todos las instituciones del país seleccionado
$Instruccion = "SELECT Id,Nombre FROM tab_categ_usuarios ORDER BY Nombre";
$result = mysql_query($Instruccion);
$tope = mysql_num_rows($result);

// Genero el encabezado de la matriz con el nombre del país
// y un vector que el código de país dice donde esta en la matriz
// este pais. Necesario para mantener el orden alfabetico

for ($i = 1; $i <= $tope; $i++) {
	$resultado = mysql_fetch_row($result);
	$row[$i][0] = $resultado[1];
	$hash[$resultado[0]] = $i;
}

$columnastope = $AnioFinal - $Anio +1;
for ($filas = 1; $filas <= $tope; $filas++) {
	for ($columnas = 1; $columnas <= $columnastope; $columnas++) {
		$row[$filas][$columnas] = 0;
	}
}

// Inicializo otros totales la Suma por Paises
// los porcentajes por Países y las Sumas por Columnas, es decir años
for ($filas = 1; $filas <= $tope; $filas++) {
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
for ($i = 1; $i <= $tope; $i++) {
	if ($SumaPaises[$i] > 0) {
		$PorcentajePaises[$i] = (100 * $SumaPaises[$i]) / $Total_General;
	}
}

for ($i = 1; $i <= $columnastope; $i++) {
	if ($SumaAnios[$i] > 0) {
		$PorcentajeAnios[$i] = (100 * $SumaAnios[$i]) / $Total_General;
	}
}

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
$Titulo .= " - " . $Mensajes["tit-22"];
echo $Titulo . " - " . $Mensajes["tf-4"];
?></b></font></p>

 <table border="1" width="80%" bgcolor="#006699" align="center">
  <tr>
   <td width="5%" height="13"><font face="MS Sans Serif" size="1" color="#FFFFFF"><? echo $Mensajes["ec-23"]; $buffer .= $Mensajes["ec-23"]; ?></font></td>
   <?


if ($Modalidad == 1) {
	for ($i = 1; $i <= $columnastope; $i++) {
?>  
    <td width="5%" height="13"><font face="MS Sans Serif" size="1" color="#FFFFFF"><? echo $row[0][$i]; $buffer .= ','.$row[0][$i]; ?></font></font></td>  	  
	<?


	}
}
?>

    <td width="5%" height="13"><font face="MS Sans Serif" size="1" color="#FFFFFF"><? echo $Mensajes["ec-8"]; $buffer .= ','.$Mensajes["ec-8"]; ?></font></td>
	<td width="5%" height="13"><font face="MS Sans Serif" size="1" color="#FFFFFF"><? echo $Mensajes["ec-24"]; $buffer .= ','.$Mensajes["ec-24"]; ?></font></td>
  </tr>
  
  <td width="5%">
  <?


$descuento = 0;
for ($i = 1; $i <= $tope; $i++) {
	if ($SumaPaises[$i] > 0) {
		$buffer .= "\n";
?> 
  <tr>
    <td width="5%" height="19" align="right"><font face="MS Sans Serif" size="1" color="#FFFFCC"><? echo $row[$i][0]; $buffer .= $row[$i][0]; ?>&nbsp;</font></td>
     <?


		// descuento sirve para descontar las filas de países que 
		// no voy a contar. A fines de graficar
		if ($Modalidad == 1) {
			for ($j = 1; $j <= $columnastope; $j++) {
?> 
    <td width="5%" height="19"><font face="MS Sans Serif" size="1" color="#FFFFCC"><? echo $row[$i][$j]; $buffer .= ','.$row[$i][$j]; ?></font></td>
	<?


			}
		}
?>
	<td width="5%" height="13" bgcolor="#ffffcc"><font face="MS Sans Serif" size="1" color="#333399"><b><? echo $SumaPaises[$i]; $buffer .= ','.$SumaPaises[$i]; ?></b></font></td>
	<td width="5%" height="13" bgcolor="#ffffcc"><font face="MS Sans Serif" size="1" color="#000000"><b><? echo number_format($PorcentajePaises[$i],2)."%"; $buffer .= ','.number_format($PorcentajePaises[$i],2)."%"; ?></b></font></td>
  </tr>
  <?


	} else {
		$descuento += 1;
	}
}
?>
	
  <tr>
    <td width="5%" height="19" align="right"><font face="MS Sans Serif" size="1" color="#FFFFFF">&nbsp;<? echo $Mensajes["ec-3"]; $buffer .= "\n".$Mensajes["ec-3"]; ?></font></td>
    <?


if ($Modalidad == 1) {
	for ($i = 1; $i <= $columnastope; $i++) {
?>    
    <td width="5%" height="19"><font face="MS Sans Serif" size="1" color="#FFFFCC"><? echo $SumaAnios[$i]; $buffer .= ','.$SumaAnios[$i]; ?></font></td>
   <?


	}
}
?> 
	 <td width="5%" height="19"><font face="MS Sans Serif" size="1" color="#FFFFCC"><? echo $Total_General; $buffer .= ','.$Total_General; ?></font></td>  
	<td width="5%" height="19"><font face="MS Sans Serif" size="1" color="#FFFFCC"><? echo "100.00%"; $buffer .= ','."100.00%"; ?></font></td>   
  </tr>
  <tr>
    <td width="5%" height="19" align="right"><font face="MS Sans Serif" size="1" color="#FFFFFF">&nbsp;<? echo $Mensajes["ec-4"]; $buffer .= "\n".$Mensajes["ec-4"];  ?></font></td>
   <?


if ($Modalidad == 1) {
	for ($i = 1; $i <= $columnastope; $i++) {
?>     
    <td width="5%" height="19"><font face="MS Sans Serif" size="1" color="#FFFFCC"><? echo number_format($PorcentajeAnios[$i],2)."%"; $buffer .= ','. number_format($PorcentajeAnios[$i],2)."%"; ?></font></td>
   <?


	}
}
?> 
	<td width="5%" height="19"><font face="MS Sans Serif" size="1" color="#FFFFCC"><? echo "100.00%"; $buffer .= ','."100.00%"; ?></font></td>   
	<td width="5%" height="19"><font face="MS Sans Serif" size="1" color="#FFFFCC">&nbsp;</font></td>   
  </tr>
</table>
<br>
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
	for ($j = 1; $j <= $tope; $j++) {
		if ($SumaPaises[$j] > 0) {
			$cadena .= Primer_Palabra($row[$j][0]) . ",";
		}
	}
	$cadena = substr($cadena, 0, strlen($cadena) - 1);
	return "<param name=seriesLabels value=" . $cadena . ">";

}

function retornar_valores($Modalidad) {
	global $row;
	global $tope;
	global $columnastope;
	global $SumaPaises;

	$valores = "";
	$indice = 0;
	for ($j = 1; $j <= $tope; $j++) {
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
<table align="center">
<tr>
	<td>
		<?


// Calculo el tamaño del gráfico de acuerdo a la cantidad
// de series a presentar

$alto = 500;
$ancho = 350;
?>
		
	<table width="70%">
	 <tr> <td width="90%">
	
		<?


if ($TipoGrafico == 1) {
?>
		
		<applet code="com.objectplanet.gui.BarChartApplet" archive=com.objectplanet.gui.BarChartApplet.jar
		width=<? echo $alto; ?> height=<? echo $ancho; ?> name="BarChart" VIEWASTEXT>
		<param name=seriesCount value="<? echo ($tope - $descuento) ?>">
		
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
		<param name=seriesCount value="<? echo ($tope - $descuento); ?>">
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
 <td valign="top">
   <a href='javascript:direct_export()'><img border='no' src='../imagenes/files/xls.jpg' height='20'></a>
 </td>
 </tr>
 </table>

	</td>
</table>	
</center>
<P ALIGN="center">
    <font face="MS Sans Serif" size="1"><font color="#000080">cp:</font>npm-001</font>
</P>
</TABLE>

<form name="formExport" action="exp_est.php">
  <input type='hidden' name='datos' value='<? echo $buffer; ?>'>
  <input type='hidden' name='mifilename' value='funcionusped.csv'>
  
</form>

<script>
function direct_export()
{
  document.forms.formExport.submit();
}
</script>



</body>

