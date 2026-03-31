<?
$pageName = "estadisticas1";
require_once "../common/includes.php";
SessionHandler :: validar_nivel_acceso(ROL__USUARIO);
require_once "../layouts/top_layout_admin.php";

$usuario = SessionHandler :: getUsuario();
$id_usuario = $usuario["Id"];

global $IdiomaSitio;
$Mensajes = Comienzo($pageName, $IdiomaSitio);

if (!isset ($AnioFinal))
	$AnioFinal = date("Y");
if (!isset ($Anio))
	$Anio = date("Y");
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
$largo = 0;

function Devolver_Indice($Codigo_Revista, $vector) {
	global $largo;

	$indice = 0;

	for ($i = 1; $i <= 100; $i++) {
		if ($vector[$i][0] == $Codigo_Revista) {
			$indice = $i;
		}
	}
	if ($indice == 0) {
		$largo += 1;
		$indice = $largo;
	}
	return $indice;
}

function Asignar() {
	global $Suma_Total;
	global $row;
	global $Modalidad;
	global $result;
	global $Total_General;
	global $Anio;

	while ($rowg = mysql_fetch_row($result)) {
		// Asigno el Anio
		$i = Devolver_Indice($rowg[0], $row);
		$row[$i][0] = $rowg[0];
		$row[$i][1] = $rowg[1];
		$row[$i][2] += $rowg[2];

	}

	$Total_General += $rowg[2];

}

function Armar_Instruccion($dedonde, $id_usuario) {
	global $Anio;
	global $AnioFinal;
	global $TPed;
	global $Caja;

	$Instruccion = "SELECT Codigo_Titulo_Revista,titulos_colecciones.Nombre,COUNT(*) AS Suma ";
	if ($dedonde == 1) {
		$Instruccion .= "FROM pedhist ";
		$Instruccion .= "LEFT JOIN titulos_colecciones ON titulos_colecciones.Id=pedhist.Codigo_Titulo_Revista ";
	} else {
		$Instruccion .= "FROM pedidos ";
		$Instruccion .= "LEFT JOIN titulos_colecciones ON titulos_colecciones.Id=pedidos.Codigo_Titulo_Revista ";
	}

	$Instruccion .= "WHERE YEAR(Fecha_Alta_Pedido)>=" . $Anio . " AND YEAR(Fecha_Alta_Pedido)<=" . $AnioFinal;
	$Instruccion .= " AND Tipo_Pedido=" . TIPO_PEDIDO__BUSQUEDA . " AND Codigo_Usuario=" . $id_usuario;
	if ($Caja == ESTADO__ENTREGADO_IMPRESO || $Caja == ESTADO__CANCELADO) {
		if ($dedonde == 1) {
			$Instruccion .= " AND pedhist.Estado=" . $Caja;
		} else {
			$Instruccion .= " AND pedidos.Estado=" . ESTADO__RECIBIDO;
		}
	}
	$Instruccion .= " GROUP BY Codigo_Usuario,Codigo_Titulo_Revista";
	$Instruccion .= " ORDER BY Suma DESC";

	return $Instruccion;
}

// Completo con cero los valores de la matriz que se 
// va a usar para presentar la tabla

$filas = 100;
for ($j = 1; $j <= $filas; $j++) {
	for ($i = 0; $i <= 4; $i++) {
		$row[$j][$i] = 0;
	}
}

$Total_General = 0;
$Instruccion = Armar_Instruccion(1, $id_usuario);
$result = mysql_query($Instruccion);
echo mysql_error();
Asignar();
mysql_free_result($result);

if ($Caja != ESTADO__CANCELADO) {
	$Instruccion = Armar_Instruccion(2, $id_usuario);
	$result = mysql_query($Instruccion);
	echo mysql_error();
	Asignar();
	mysql_free_result($result);
}

for ($i = 1; $i <= $largo; $i++) {
	$Total_General += $row[$i][2];
}

// Calculo los porcentajes
$Total_Porcentajes = 0;
for ($i = 1; $i <= $largo; $i++) {
	if ($Total_General > 0) {
		$porcentajes[$i] = (100 * $row[$i][2]) / $Total_General;
		$Total_Porcentajes += $porcentajes[$i];
	}
}
?>

<form method="POST" >
<table  border="0" style="margin-bottom: 0; margin-top:0; border-collapse:collapse" bordercolor="#111111" cellpadding="0" cellspacing="0">
              <tr>
                <td valign="top" bgcolor="#E4E4E4"><table width="100%"  border="0" cellpadding="0" cellspacing="0" class="style43">
                  <tr>
                    <td height="20" colspan="2" align="left" bgcolor="#006599" class="style45"><img src="../images/square-lb.gif" width="8" height="8" border="0"> <span class="style28"><? echo $Mensajes["tf-10"];?> </span></td>
                  </tr>
                  <tr>
                    <td height="15" colspan="2" align="left" class="style45"><br>                      
                    <table width="97%"  border="0" align="center" cellpadding="1" cellspacing="0" class="table-form">
                    <tr>
                    	<th width="15%">
                    		<div align="right"><? echo $Mensajes["tf-1"]?></div>
                    	</th>
                        <td width="179" align="left">
							<input class="style43" type="text" name="Anio" size="10"  value="<? echo $Anio; ?>" />
							<input type="hidden" name="TPed" value="<? echo $TPed; ?>" />
							<input type="hidden" name="id_usuario" value="<? echo $id_usuario; ?>" />
						</td>
                        <th width="15%">
                        	<div align="right"><? echo $Mensajes["tf-2"]?></div>
                        </th>
                        <td width="179" align="left">
                        	<input class="style54" type="text" name="AnioFinal" size="10"  value="<? echo $AnioFinal; ?>" />
                        </td>
                    </tr>
                    <tr>
                        <th width="15%">
                        	<div align="right"><? echo $Mensajes["tf-5"]?></div>
                        </th>
                        <td width="179" align="left">						
							<select class="style54" size="1" name="Caja" >
						 		<option <? if ($Caja==0) { echo "selected"; } ?> value="0"><? echo $Mensajes["ec-30"]?></option>
						 		<option <? if ($Caja==ESTADO__ENTREGADO_IMPRESO) { echo "selected"; } ?> value="<? echo ESTADO__ENTREGADO_IMPRESO; ?>"><? echo $Mensajes["ec-28"]?></option>
						 		<option <? if ($Caja==ESTADO__CANCELADO) { echo "selected"; } ?> value="<? echo ESTADO__CANCELADO; ?>"><? echo $Mensajes["ec-29"]?></option>
						 	</select>
						</td>
                        <th width="15%">
                        	<div align="right"></div>
                        </th>
                        <td width="179" align="left">
                        	&nbsp;
                        </td>
                    </tr>
                    <tr valign="middle">
                        <td colspan="4" class="style43">
                        	<div align="center">
                        		<input type="submit" value="<? echo $Mensajes["bot-1"]?>" name="B1" class="style43" />
                        	</div>
                        </td>
                    </tr>
                    </table>                      
                      <hr></td>
                  </tr>
  
   
				
				 
                  <tr valign="top">
                    <td colspan="2" align="left" class="style45">
                      <div align="left">
                        <p><span class="style54"><img src="../images/sa6.gif" width="8" height="10">  <?


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

echo $Titulo;
?> - <? echo $Mensajes["ec-27"];?></span></p>
                        </div>                      
                      <table width="97%"  border="0" align="center" cellpadding="1" cellspacing="1" bordercolor="#CCCCCC" class="style43">
                        <tr bordercolor="#CCCCCC" bgcolor="#006699" class="style28">
                          <td align="right"><span class="style66"><? echo $Mensajes["ec-26"];?></span></td>				
                          <td align="center" class="style28"><? echo $Mensajes["ec-2"];?></td>
						  <td align="center" class="style28"><? echo $Mensajes["ec-4"];?></td>
                        </tr>
					    
					   
						  <?


for ($i = 1; $i <= $largo; $i++) {
?> 
						  <tr bordercolor="#CCCCCC" bgcolor="#006699" class="style28">
							<td align="right" bgcolor="#CCCCCC"><? echo $row[$i][1]; ?></td>
							<td align="right" bgcolor="#CCCCCC"><? echo $row[$i][2]; ?></td>
							<td align="right" bgcolor="#CCCCCC"><? echo number_format($porcentajes[$i],2)."%"; ?></td>
						  </tr>
						  
						  <? } ?>
						  <tr>
							<td align="right" bgcolor="#CCCCCC"><? echo $Mensajes["ec-3"];?></td>
							<td align="right" bgcolor="#CCCCCC"><? echo $Total_General; ?></b></font></td>
							<td align="right" bgcolor="#CCCCCC"><? echo number_format($Total_Porcentajes,2)."%"; ?></td>
						 </tr>
                      </table>                      
                      <br>
                      </td>
                    </tr>

                
                </table>
				</td>
              </tr>
            </table>

<?

	$pageName = "estadisticas1";
	require_once "../layouts/base_layout_admin.php";
?>
