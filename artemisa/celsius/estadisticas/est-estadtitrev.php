<?
$pageName = "estadisticas1";
require_once "../common/includes.php";

require "../layouts/top_layout_admin.php";

// Estas funciones son específicas de cálculo
// mas abajo están las específicas de graficación
function Calcular() {
	global $result;
	global $Suma_Total;
	global $Total_General;
	global $Anio;
	global $row;
	global $nivelcompleto;
	global $SumaAnios;
	global $SumaPaises;

	$filacorrecta = 1;
	while ($rowg = mysql_fetch_row($result)) {
		// Si $rowg[3]==0 implica que son  	Pedidos Cancelados
		// que no llegaron a pedirse a ningun país
		$row[$filacorrecta][0] = $rowg[0];
		@$row[$filacorrecta][1] += $rowg[1];
		$SumaAnios[1] += $rowg[1];
		@$SumaPaises[$filacorrecta] += $rowg[1];
		$Total_General += $rowg[1];
		$filacorrecta += 1;
	
	$nivelcompleto = $filacorrecta;
	}

}

function Armar_Instruccion($dedonde) {
	global $TPed;
	global $Anio;
	global $AnioFinal;
	global $Caja;
	global $Titulo;
	global $Pagina;

	$Instruccion = "SELECT titulo_revista,COUNT(*) as cantidad ";
	$Instruccion .= "FROM pedhist ";
	$Instruccion .= "WHERE YEAR(Fecha_Alta_Pedido)>=" . $Anio . " AND YEAR(Fecha_Alta_Pedido)<=" . $AnioFinal;
	$Instruccion .= " AND Tipo_Pedido=" . $TPed . " AND Tipo_Material=1";

	if ($Caja == ESTADO__ENTREGADO_IMPRESO || $Caja == ESTADO__CANCELADO) {
		$Instruccion .= " AND Estado=" . $Caja;
	}

	if ($Titulo != "") {
		$Instruccion .= " AND Titulo_Revista LIKE '" . $Titulo . "%'";
	}

	$Limite = $Pagina +100;
	if ($dedonde) {
		$Instruccion .= " GROUP BY titulo_revista ORDER BY cantidad DESC,titulo_revista ASC LIMIT " . $Pagina . "," . $Limite;
	} else {
		$Instruccion .= " GROUP BY titulo_revista ORDER BY cantidad DESC,titulo_revista";
	}

	return $Instruccion;
}
global $IdiomaSitio;
$Mensajes = Comienzo($pageName, $IdiomaSitio);

if (!isset ($Caja))
	$Caja = 0;
if (!isset ($anterior))
	$anterior = "";
if (!isset ($siguiente))
	$siguiente = "";

$columnastope = 1;
for ($filas = 1; $filas <= 100; $filas++) {
	for ($columnas = 1; $columnas <= $columnastope; $columnas++) {
		$row[$filas][$columnas] = 0;
	}
}

// Inicializo otros totales la Suma por paises
// los porcentajes por Países y las Sumas por Columnas, es decir años
for ($filas = 1; $filas <= 100; $filas++) {
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

// Voy a calcular la cantidad total de pedidos historicos 
// de PP en ese período de tiempo para que los valores de
// porcentajes sean reales
$Instruccion = "SELECT COUNT(*) FROM pedhist WHERE Tipo_Material=1";
$Instruccion .= " AND YEAR(Fecha_Alta_Pedido)>=" . $Anio . " AND YEAR(Fecha_Alta_Pedido)<=" . $AnioFinal;
if ($Caja == ESTADO__ENTREGADO_IMPRESO || $Caja == ESTADO__CANCELADO) {
	$Instruccion .= " AND Estado=" . $Caja;
}

$result = mysql_query($Instruccion);
$cantidad = mysql_fetch_row($result);

$nivelcompleto = 0;
$Instruccion = Armar_Instruccion(1);
$result = mysql_query($Instruccion);

echo mysql_error();
Calcular();
mysql_free_result($result);

// Calculo los porcentajes
for ($i = 1; $i <= $nivelcompleto; $i++) {
	if (!empty ($SumaPaises[$i]) and ($SumaPaises[$i] > 0)) {
		$PorcentajePaises[$i] = (100 * $SumaPaises[$i]) / $cantidad[0];
	}
}

for ($i = 1; $i <= $columnastope; $i++) {
	if ($SumaAnios[$i] > 0) {
		$PorcentajeAnios[$i] = (100 * $SumaAnios[$i]) / $cantidad[0];
	}
}

// Modificación introducida 03-09-2002
// Para permitir buscar mas de los primeros 100
// cuento la cantidad total de revistas
// así se si tengo que presentar un paso a siguiente

$Instruccion = Armar_Instruccion(0);
$result2 = mysql_query($Instruccion);
if (mysql_num_rows($result2) > $Pagina +100) {
	$Limite = $Pagina +100;
	$vinculo = "<a href='est-estadtitrev.php?Pagina=" . $Limite . "&Anio=" . $Anio . "&AnioFinal=" . $AnioFinal . "&TPed=" . $TPed;
	if ($Caja != "") {
		$vinculo .= "&Caja=" . $Caja;
	}
	if ($Titulo != "") {
		$vinculo .= "&Titulo=" . $Titulo;
	}
	$siguiente = $vinculo . "'>Pagina siguiente</a>";

}

if ($Pagina != 0) {
	$Limite = $Pagina -100;
	$vinculo = "<a href='est-estadtitrev.php?Pagina=" . $Limite . "&Anio=" . $Anio . "&AnioFinal=" . $AnioFinal . "&TPed=" . $TPed;
	if ($Caja != "") {
		$vinculo .= "&Caja=" . $Caja;
	}
	if ($Titulo != "") {
		$vinculo .= "&Titulo=" . $Titulo;
	}
	$anterior = $vinculo . "'>Pagina anterior</a>";
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
  
<table width="760" border="0" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="5">
      <tr bgcolor="#EFEFEF">
        <td bgcolor="#E4E4E4">
            <div align="center">
              <center>
<table width="576" border="0" style="margin-bottom: 0; margin-top:0; border-collapse:collapse" bordercolor="#111111" cellpadding="0" cellspacing="0">
              <tr>
                <td valign="top" bgcolor="#E4E4E4">
				<form method="POST" action="est-estadtitrev.php">
<table width="100%"  border="0" cellpadding="0" cellspacing="0" class="table-form">
                  <tr>
                    <td height="20" colspan="2" align="left" bgcolor="#006599" class="style45"><img src="../images/square-lb.gif" width="8" height="8" border="0"> <span class="style28"><? echo $Mensajes["ec-39"]?></span></td>
                  </tr>
                  <tr>
                    <td height="15" colspan="2" align="left" class="style45"><br>                      
                    <table width="97%"  border="0" align="center" cellpadding="1" cellspacing="0" class="table-form"> 
                    <tr>
                        <th width="130">
                        	<div align="right"><? echo $Mensajes["tf-1"];?> </div>
                        </th>
                        <td width="179" align="left">
                        	<input name="Anio" value="<? echo $Anio; ?>" type="text" class="style43">
                        	<input type="hidden" name="TPed" value="<? echo $TPed; ?>">                        
                        </td>
                    </tr>
                    <tr>
					 	<th width="130">
					 		<div align="right"><? echo $Mensajes["tf-2"];?></div>
					 	</th>
                        <td width="179" align="left">
                        	<input name="AnioFinal"  value="<? echo $AnioFinal; ?>" type="text" class="style54">
                        </td>
					</tr>
					<tr>
                        <th width="130">
                        	<div align="right"><? echo $Mensajes["ec-38"];?></div>
                        </th>
                        <td width="179" align="left">
                        	<input name="Titulo"  value="<? echo $Titulo; ?>" size="40" type="text" class="style54" style="width:200px">
						</td>
                    </tr>
                    <tr>
                        <th width="130">
                        	<div align="right"><? echo $Mensajes["tf-5"]?></div>
                        </th>
                        <td width="179" align="left">
                        	<select name="Caja" class="style54" size="1" style="width:200px">
                        		<option <? if ($Caja==0) { echo "selected"; } ?> value="0"><? echo $Mensajes["ec-30"]; ?></option>
                        		<option <? if ($Caja==ESTADO__ENTREGADO_IMPRESO) { echo "selected"; } ?> value="<? echo ESTADO__ENTREGADO_IMPRESO; ?>"><? echo $Mensajes["ec-28"]; ?></option>
                        		<option <? if ($Caja==ESTADO__CANCELADO) { echo "selected"; } ?> value="<? echo ESTADO__CANCELADO; ?>"><? echo $Mensajes["ec-29"]; ?></option>
                        	</select>
                        </td>
                    </tr>
                    <tr valign="middle">
                        <td colspan="4" class="style43">
                        	<div align="center">
                            	<input name="B1" type="submit" class="style43" value="<? echo $Mensajes["bot-1"]?>">
                          	</div>
                        </td>
                    </tr>
                    </table>
					 <input type="hidden" name=Pagina value="0">
                    </form>
                      <hr></td>
                  </tr>
				  </table>
                  <tr valign="top">
                    <td colspan="2" align="left" class="style45">
                      <div align="left">
                        <p><span class="style54"><img src="../images/sa6.gif" width="8" height="10"><? echo $Mensajes["ec-39"]?>
        <?

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

$buffer = '';
$Titulo .= " - " . $Mensajes["ec-27"];
?>
</span></p>
</div>

  
  <table border="0" width="80%" align="center">
  <tr>
   <td width="20%" height="13"><font face="MS Sans Serif" size="1" color="#FFFFFF"><? echo $anterior;?></font></td>
   <td width="60%">&nbsp;</td>
   <td width="20%" height="13"><font face="MS Sans Serif" size="1" color="#FFFFFF"><? echo $siguiente;?></font></td>
  </tr>
  </table>
  <table width="97%"  border="0" align="center" cellpadding="1" cellspacing="1" bordercolor="#CCCCCC" class="style43">
  <tr bordercolor="#CCCCCC" bgcolor="#006699" class="style28">
       <td align="right" class="style28"><span class="style66"><? echo $Mensajes["ec-40"];?></span></td>	
       <td align="right" class="style28"><span class="style66"><? echo $Mensajes["ec-41"];?></span></td>	
	   <td align="right" class="style28"><span class="style66"><? echo $Mensajes["ec-42"];?></span></td>	
  </tr>     

<?
$descuento = 0;
for ($i = 1; $i <= $nivelcompleto; $i++) {
	if ((!empty ($SumaPaises[$i])) and ($SumaPaises[$i] > 0)) {?>
   	<tr>
   		<td align="right" bgcolor="#ECECEC">
   			<span class="style54"><? echo $row[$i][0]; ?>&nbsp;</span>
   		</td>
    	<td align="right" bgcolor="#ECECEC">
    		<span class="style54"><? echo $SumaPaises[$i]; ?></span>
    	</td>
		<td align="right" bgcolor="#ECECEC">
			<span class="style54"><? echo number_format($PorcentajePaises[$i],2)."%"; ?></span>
		</td>
  </tr>
  <?}
}
?>
 
<tr>
    <td align="right" bgcolor="#CCCCCC" ><span class="style54">&nbsp;<? echo $Mensajes["ec-3"]; ?></font></td>
  	 <td align="right" bgcolor="#CCCCCC"><span class="style54"><? echo $Total_General." / ".$cantidad[0]; ?></font></td>  
	<td align="right" bgcolor="#CCCCCC"><span class="style54"><?


if ($cantidad[0] > 0) {
	$porcentaje = 100 * $Total_General / $cantidad[0];
} else {
	$porcentaje = 0;
};
echo number_format($porcentaje, 2) . "% / 100%";
?></font></td>   
  </tr>
</table> 
</td>
</tr>
</table><td width="150" valign="top" bgcolor="#E4E4E4"><div align="center" class="style11">
          <table width="100%" bgcolor="#ececec">
            <tr>
              <td valign="top" class="style28"><div align="center"><img src="../images/image001.jpg" width="150" height="118" border="0"><br>
                <span class="style54"><a href="main-estadisticas.php"><? echo $Mensajes["h-1"];?></a></span></div>                <div align="center" class="style55"></div></td>
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