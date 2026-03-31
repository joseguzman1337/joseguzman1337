<?
$pageName = "estadisticas1";
require_once "../common/includes.php";
require_once "metodos_estadisticas.php";
SessionHandler :: validar_nivel_acceso(ROL__USUARIO);
$usuario = SessionHandler :: getUsuario();
$id_usuario = $usuario["Id"];
require_once "../layouts/top_layout_admin.php";

global $IdiomaSitio;
$Mensajes = Comienzo($pageName, $IdiomaSitio);

if (!isset ($AnioFinal))
	$AnioFinal = date("Y");
if (!isset ($Anio))
	$Anio = date("Y");

if (!isset ($TipoGrafico))
	$TipoGrafico = 2;
if (!isset ($Titulo))
	$Titulo = 2;
if (!isset ($Modalidad))
	$Modalidad = 2;
if (!isset ($Caja))
	$Caja = 0;
?> 

<style type="text/css">
<!--

.style11 {color: #006699; font-family: Arial, Helvetica, sans-serif; font-size: 11px; }
.style28 {color: #FFFFFF}
.style43 {
	font-family: verdana;
	font-size: 10px;
	color: #000000;
}
.style49 {font-family: verdana; font-size: 11px; color: #006599; }
.style54 {font-family: verdana; font-size: 10px; color: #000000; }
.style55 {
	font-size: 11px;
	color: #000000;
	font-family: Verdana;
}
.style63 {
	font-size: 11px;
	font-family: Arial, Helvetica, sans-serif;
}
.style66 {color: #FFFFFF}
.style23 {
	color: #000000;
	font-size: 11px;
	font-family: verdana;
}
-->
</style>

<?


$expresion = "SELECT Apellido,Nombres,EMail,Codigo_Pais,Codigo_Institucion,Codigo_Dependencia";
$expresion = $expresion . ",Direccion,Codigo_Categoria,Telefonos,Codigo_Unidad,Codigo_Localidad,Login,Password,Comentarios,";
$expresion = $expresion . "Codigo_FormaEntrega,Personal,Bibliotecario,Staff,Orden_Staff,Cargo ";
$expresion = $expresion . "FROM usuarios WHERE usuarios.Id =" . $id_usuario;
$result = mysql_query($expresion);
echo mysql_error();
$rowg = mysql_fetch_row($result);

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
			$row[$rowg[0] - $Anio +1][$rowg[1]] += $rowg[2];
			$row[$rowg[0] - $Anio +1][13] += $rowg[2];
			$Suma_Total[$rowg[1]] += $rowg[2];
		} else {
			$row[$rowg[0] - $Anio +1][13] += $rowg[2];

		}

		$Total_General += $rowg[2];
	}
}

function Armar_Instruccion($dedonde, $id_usuario) {
	global $Anio;
	global $AnioFinal;
	global $TPed;
	global $Caja;

	$Instruccion = "SELECT YEAR(Fecha_Alta_Pedido) AS p, MONTH(Fecha_Alta_Pedido) AS m, COUNT(*) ";
	if ($dedonde == 1) {
		$Instruccion .= "FROM pedhist ";
	} else {
		$Instruccion .= "FROM pedidos ";
	}

	$Instruccion .= "WHERE YEAR(Fecha_Alta_Pedido)>=" . $Anio . " AND YEAR(Fecha_Alta_Pedido)<=" . $AnioFinal;
	$Instruccion .= " AND Tipo_Pedido=" . TIPO_PEDIDO__BUSQUEDA . " AND Codigo_Usuario=" . $id_usuario;
	if ($Caja == ESTADO__ENTREGADO_IMPRESO || $Caja == ESTADO__CANCELADO) {
		if ($dedonde == 1) {
			$Instruccion .= " AND Estado=" . $Caja;
		} else {
			$Instruccion .= " AND Estado=" . ESTADO__RECIBIDO;
		}
	}
	$Instruccion .= " GROUP BY p,m";
	return $Instruccion;
}

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

$Total_General = 0;
$Instruccion = Armar_Instruccion(1, $id_usuario);
$result = mysql_query($Instruccion);
echo mysql_error();
Calcular();
mysql_free_result($result);

if ($Caja != ESTADO__CANCELADO) {
	$Instruccion = Armar_Instruccion(2, $id_usuario);
	$result = mysql_query($Instruccion);
	echo mysql_error();
	Calcular();
	mysql_free_result($result);
}

for ($i = 1; $i <= $filas; $i++) {
	$Suma_Total[13] += $row[$i][13];
}

// Calculo los porcentajes
for ($i = 1; $i <= 13; $i++) {
	if ($Total_General > 0) {
		$porcentaje[$i] = (100 * $Suma_Total[$i]) / $Total_General;
	}
}
?>


<form method="POST" action="us_pedinic.php">

<table border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td valign="top" bgcolor="#E4E4E4"><table width="100%"  border="0" cellpadding="0" cellspacing="0" class="style43">
                  <tr>
                    <td height="20" colspan="2" align="left" bgcolor="#006599" class="style45"><img src="../images/square-lb.gif" width="8" height="8" border="0"> <span class="style28"><? echo $Mensajes["tf-12"]."&nbsp;"; if ($Modalidad == 1) {echo $Mensajes["ec-11"];}else{echo $Mensajes["ec-1"];  }?></span></td>
                  </tr>
                  <tr>
                    <td height="15" colspan="2" align="left" class="style45"><br>
                    <table width="97%"  border="0" align="center" cellpadding="1" cellspacing="0" class="table-form">
                    <tr>
                        <th>
                        	<div align="right"><? echo $Mensajes["tf-1"];?></div>
                        </th>
                        <td width="179" align="left">
							<input class="style43" type="text" name="Anio" size="10"  value="<? echo $Anio; ?>" />
							<input type="hidden" name="TPed" value="<? echo $TPed; ?>" />
							<input type="hidden" name="id_usuario" value="<? echo $id_usuario; ?>" />
						</td>
                        <th>
                        	<div align="right"><? echo $Mensajes["tf-2"];?></div>
                        </th>
                        <td width="179" align="left">
                        	<input class="style54" type="text" name="AnioFinal" size="10"  value="<? echo $AnioFinal; ?>" />
                        </td>
                    </tr>
                    <tr>
                        <th>
                        	<div align="right"><? echo $Mensajes["tf-3"];?></div>
                        </th>
                        <td width="179" align="left">
						 	<select class="style54" size="1" name="Modalidad" style="width:170px">
							 	<option <? if ($Modalidad!=1) { echo "selected"; } ?> value="2"><? echo $Mensajes["tit-2"];?></option>
							 	<option <? if ($Modalidad==1) { echo "selected"; } ?> value="1"><? echo $Mensajes["tit-1"];?></option>
							</select>
						</td>
                        <th>
                        	<div align="right"><? echo $Mensajes["tf-6"];?></div>
                        </th>
                        <td width="179" align="left">
							<select size="1" class="style54" name="TipoGrafico" style="width:170px">
						 		<option <? if ($TipoGrafico==1) { echo "selected"; } ?> value="1"><? echo $Mensajes["otg-1"];?> </option>
						 		<option <? if ($TipoGrafico!=1) { echo "selected"; } ?> value="2"><? echo $Mensajes["otg-2"];?></option>
						 	</select>
					    </td>
                    </tr>
                    <tr>
                        <th>
                        	<div align="right"><? echo $Mensajes["tf-5"];?></div>
                        </th>
                        <td width="179" align="left">
							<select class="style54" size="1" name="Caja" style="width:170px">
						 		<option <? if ($Caja==0) { echo "selected"; } ?> value="0"><? echo $Mensajes["ec-30"]?></option>
						 		<option <? if ($Caja==ESTADO__ENTREGADO_IMPRESO) { echo "selected"; } ?> value="<? echo ESTADO__ENTREGADO_IMPRESO; ?>"><? echo $Mensajes["ec-28"]?></option>
						 		<option <? if ($Caja==ESTADO__CANCELADO) { echo "selected"; } ?> value="<? echo ESTADO__CANCELADO; ?>"><? echo $Mensajes["ec-29"]?> </option>				
                        	</select>
                        </td>
                        <td align="right" class="style43"><div align="right"></div></td>
                        <td width="179" align="left">&nbsp;</td>
                    </tr>
                    <tr valign="middle">
                        <td colspan="4" class="style43">         
                        	<div align="center">
                        		<input type="submit" value="<? echo $Mensajes["bot-1"]?>" name="B1" class="style43">               
                        	</div>
                        </td>
                    </tr>
                    </table>                      
                      <hr></td>
                  </tr>

				
				 
                  <tr valign="top">
                    <td colspan="2" align="left" class="style45">
                      <div align="left">
                        <p><span class="style54"><img src="../images/sa6.gif" width="8" height="10"><?


switch ($Caja) {
	case ESTADO__ENTREGADO_IMPRESO :
		$Titulo = $Mensajes["ec-28"];
		break;
	case ESTADO__CANCELADO :
		$Titulo = $Mensajes["ec-29"];
		break;
	default :
		$Titulo = $Mensajes["ec-30"];
		break;
}

echo $Titulo . "&nbsp;";
if ($Modalidad == 1) {
	echo $Mensajes["ec-11"];
} else {
	echo $Mensajes["ec-1"];
}
?> <? echo $Mensajes["tf-4"];?>.</span></p>
                        </div>                      
                      <table width="97%"  border="0" align="center" cellpadding="1" cellspacing="1" bordercolor="#CCCCCC" class="style43">
                        <tr bordercolor="#CCCCCC" bgcolor="#006699" class="style28">
                          <td align="right"><span class="style66"><? echo $Mensajes["ec-1"];?></span></td>
						  <?


if ($Modalidad == 1) {

	for ($i = 1; $i <= 12; $i++) {
?>
							  <td align="center"><span class="style66"><?


		$mes = TraduccionesUtils :: Traducir_Mes($i, $VectorIdioma, true);
		echo $mes;
?></span></td><?


	}
}
?>
						
					
                          <td align="center" class="style28"><? echo $Mensajes["ec-2"];?> </td>
                        </tr>
					   <?


for ($i = 1; $i <= $filas; $i++) {
?> 
					   <tr bordercolor="#CCCCCC">
						<td align="right" bgcolor="#CCCCCC"><? echo $Anio+$i-1; ?>&nbsp;&nbsp;</td>
						
						<?


	if ($Modalidad == 1) {
		for ($j = 1; $j <= 13; $j++) {
?>
								<td align="center" bgcolor="#ECECEC"><? echo $row[$i][$j];?></td>
							<?


		}
	} else {
?> 
						<td align="center" bgcolor="#ECECEC"><? echo $row[$i][13]; ?></td>
					     <?


	}

}
?>
					   <tr bordercolor="#CCCCCC">
                          <td align="right" bgcolor="#CCCCCC"><? echo $Mensajes["ec-3"];?></td>
					   <?


if ($Modalidad == 1) {
	for ($i = 1; $i <= 12; $i++) {
?>    
						<td align="center"  bgcolor="#ECECEC"><? echo $Suma_Total[$i]; ?></td>
					   <?


	}
}
?>
                         <td align="center"  bgcolor="#ECECEC"><? echo $Total_General; ?></td>
                    
					<tr bordercolor="#CCCCCC">
                          <td align="right" bgcolor="#CCCCCC"><? echo $Mensajes["ec-4"];?></td>
					  <?


if ($Modalidad == 1) {
	for ($i = 1; $i <= 12; $i++) {
?>     
						<td  align="center" bgcolor="#ECECEC"><? echo number_format($porcentaje[$i],2)."%"; ?></td>
					<?


	}
}
?> 
					  <td  align="center" bgcolor="#ECECEC"><? echo number_format($porcentaje[13],2)."%"; ?></td> 

                        
                        </tr>
                      </table>                      
                      <br>
                      <hr></td>
                    </tr>
				   


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



                  <tr valign="top">
                    <td colspan="2" align="left" class="style45"><p class="style54"><img src="../images/sa6.gif" width="8" height="10"> <? echo $Mensajes["ec-12"]?> </p>
                      <table width="97%"  border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                          <td>&nbsp;</td>
                        </tr>
                      </table>                      
                      <div align="right"><br>
                      </div>
                      <div align="center">
					  <?


// Calculo el tamaño del gráfico de acuerdo a la cantidad
// de series a presentar

if ($Modalidad == 1) {
	$alto = 650;
	$ancho = 300;
} else {
	$alto = 400;
	$ancho = 300;
}

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
						<? echo retornar_valores($Modalidad); ?>
						<param name=chartTitle value="<? echo $Titulo; ?>">
						<? echo retornar_labels($Modalidad); ?>
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
									  
					  
					  
					  
					  
					  </div></td>
                  </tr>
                </table>                  </td>
              </tr>
            </table>
<?


	$pageName = "estadisticas1";
	require_once "../layouts/base_layout_admin.php";
?>
