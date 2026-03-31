<?php require_once('../Connections/conexion.php'); ?><?php require_once('../Connections/conexion.php'); 

##error_reporting(0)?>
<?php
#date_default_timezone_set('America/Bogota');
#echo 'acaaa';
#print 'aca';
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

/* consulta si ya existe el evaluado y debe ir antes de comparar si va a insertar */
$colname_CObtieneCamposEvaluado = "-1";
if (isset($_GET['IdEvalDes'])) {
  $colname_CObtieneCamposEvaluado = (get_magic_quotes_gpc()) ? $_GET['IdEvalDes'] : addslashes($_GET['IdEvalDes']);
}
mysql_select_db($database_conexion, $conexion);
$query_CObtieneCamposEvaluado = sprintf("SELECT *, ROUND(((((CaGeCaTr)*100/3+(CaGeCoTr)*100/3+(CaGeInic)*100/3+(CaGeDiAp)*100/3+ (CaGeOrTR)*100/3)+(CaGeMaIn)*100/3 +(CaGeAtCl)*100/3)/7),0) AS 'Calidad de la gestion',   ROUND((((FaDeCuOp)*100/3+(FaDeCoop)*100/3+(FaDeComu)*100/3+(FaDeAdap)*100/3)/4),0) AS 'Facilitadores de desempeno',  ROUND((((CoInPaAc)*100/3+(CoInSePe)*100/3+(CoInCoOr)*100/3+(CoInPrPe)*100/3)/4),0) AS 'Compromiso Institucional',  ROUND((((CaReUno)*100/3+(CaReDos)*100/3+(CaReTres)*100/3)/3),0) AS 'Responsabilidades/funciones', ROUND((((CaGeCaTr)*100/3+(CaGeCoTr)*100/3+(CaGeInic)*100/3+(CaGeDiAp)*100/3+ (CaGeOrTR)*100/3+(CaGeMaIn)*100/3 +(CaGeAtCl)*100/3+ (FaDeCuOp)*100/3+(FaDeCoop)*100/3+(FaDeComu)*100/3+(FaDeAdap)*100/3+ (CoInPaAc)*100/3+(CoInSePe)*100/3+(CoInCoOr)*100/3+(CoInPrPe)*100/3+ (CaReUno)*100/3+(CaReDos)*100/3+(CaReTres)*100/3)/18),0) AS TOTAL FROM tevaldes WHERE tevaldes.IdEvalDes = %s", $colname_CObtieneCamposEvaluado);
#echo $query_CObtieneCamposEvaluado;
$CObtieneCamposEvaluado = mysql_query($query_CObtieneCamposEvaluado, $conexion) or die(mysql_error());
$row_CObtieneCamposEvaluado = mysql_fetch_assoc($CObtieneCamposEvaluado);
$totalRows_CObtieneCamposEvaluado = mysql_num_rows($CObtieneCamposEvaluado);
//var_dump($query_CObtieneCamposEvaluado);

//if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) { SE REEMPLAZO POR EL SIGUIENTE IF PARA OBTENER LA VARIABLES
if (
(isset($_GET["NombCol"])) && ($_GET["NombCol"] != "")
&& (isset($_GET["JefCol"])) && ($_GET["JefCol"] != "")
&& (isset($_GET["IdColab"])) && ($_GET["IdColab"] != "")
&& (isset($_GET["date"])) && ($_GET["date"] != "")
&& ($totalRows_CObtieneCamposEvaluado == 0) 
) {
  $insertSQL = sprintf("INSERT INTO tevaldes (NombCol, JefCol, FechEval, IdColab) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_GET['NombCol'], "text"),
                       GetSQLValueString($_GET['JefCol'], "text"),
                       GetSQLValueString(date('Y-m-d'), "date"),
					   GetSQLValueString($_GET['IdColab'], "text"));
  //var_dump($insertSQL);
  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
  
  $insertGoTo = "EvalDes.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));

} else {
	if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
	  $updateSQL = sprintf("UPDATE tevaldes SET NombCol=%s, JefCol=%s, FechEval=%s, IdColab=%s, CaGeCaTr=%s, CaGeCoTr=%s, CaGeInic=%s, CaGeDiAp=%s, CaGeOrTR=%s, CaGeMaIn=%s, CaGeAtCl=%s, FaDeCuOp=%s, FaDeCoop=%s, FaDeComu=%s, FaDeAdap=%s, CoInPaAc=%s, CoInSePe=%s, CoInCoOr=%s, CoInPrPe=%s, RespUno=%s, RespDos=%s, RespTres=%s, CaReUno=%s, CaReDos=%s, CaReTres=%s, PlMeFort=%s, PlMeAsMe=%s, PlMePlMe=%s, PlMePlAc=%s, CoGePeTf=%s, Evaluador=%s, Evaluado=%s, JefeTH=%s WHERE IdEvalDes=%s",
						   GetSQLValueString($_POST['NombCol'], "text"),
						   GetSQLValueString($_POST['JefCol'], "text"),
						   GetSQLValueString($_POST['FechEval'], "date"),
						   GetSQLValueString($_POST['IdColab'], "int"),
						   GetSQLValueString($_POST['CaGeCaTr'], "int"),
						   GetSQLValueString($_POST['CaGeCoTr'], "int"),
						   GetSQLValueString($_POST['CaGeInic'], "int"),
						   GetSQLValueString($_POST['CaGeDiAp'], "int"),
						   GetSQLValueString($_POST['CaGeOrTR'], "int"),
						   GetSQLValueString($_POST['CaGeMaIn'], "int"),
						   GetSQLValueString($_POST['CaGeAtCl'], "int"),
						   GetSQLValueString($_POST['FaDeCuOp'], "int"),
						   GetSQLValueString($_POST['FaDeCoop'], "int"),
						   GetSQLValueString($_POST['FaDeComu'], "int"),
						   GetSQLValueString($_POST['FaDeAdap'], "int"),
						   GetSQLValueString($_POST['CoInPaAc'], "int"),
						   GetSQLValueString($_POST['CoInSePe'], "int"),
						   GetSQLValueString($_POST['CoInCoOr'], "int"),
						   GetSQLValueString($_POST['CoInPrPe'], "int"),
						   GetSQLValueString($_POST['RespUno'], "text"),
						   GetSQLValueString($_POST['RespDos'], "text"),
						   GetSQLValueString($_POST['RespTres'], "text"),
						   GetSQLValueString($_POST['CaReUno'], "int"),
						   GetSQLValueString($_POST['CaReDos'], "int"),
						   GetSQLValueString($_POST['CaReTres'], "int"),
						   GetSQLValueString($_POST['PlMeFort'], "text"),
						   GetSQLValueString($_POST['PlMeAsMe'], "text"),
						   GetSQLValueString($_POST['PlMePlMe'], "text"),
						   GetSQLValueString($_POST['PlMePlAc'], "text"),
						   GetSQLValueString($_POST['CoGePeTf'], "text"),
						   GetSQLValueString($_POST['Evaluador'], "text"),
						   GetSQLValueString($_POST['Evaluado'], "text"),
						   GetSQLValueString($_POST['JefeTH'], "text"),
						   GetSQLValueString($_POST['IdEvalDes'], "int"));
  	  echo $updateSQL;
	  mysql_select_db($database_conexion, $conexion);
	  $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());
	  
  $insertGoTo = "EvalDes.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));

	}
}

mysql_select_db($database_conexion, $conexion);
$query_Colaboradores = "SELECT * FROM tlistacol ORDER BY NombCol ASC";
$Colaboradores = mysql_query($query_Colaboradores, $conexion) or die(mysql_error());
$row_Colaboradores = mysql_fetch_assoc($Colaboradores);
$totalRows_Colaboradores = mysql_num_rows($Colaboradores);

mysql_select_db($database_conexion, $conexion);
$query_Jefes = "SELECT JefDepen FROM tjefdep ORDER BY JefDepen ASC";
$Jefes = mysql_query($query_Jefes, $conexion) or die(mysql_error());
$row_Jefes = mysql_fetch_assoc($Jefes);
$totalRows_Jefes = mysql_num_rows($Jefes);

mysql_select_db($database_conexion, $conexion);
$query_Recordset1 = "SELECT ROUND((((AVG(CaGeCaTr)*100/3+AVG(CaGeCoTr)*100/3+AVG(CaGeInic)*100/3+AVG(CaGeDiAp)*100/3+AVG(CaGeOrTR)*100/3)+AVG(CaGeMaIn)*100/3 +AVG(CaGeAtCl)*100/3)/7),0) AS xx,  ROUND(((AVG(FaDeCuOp)*100/3+AVG(FaDeCoop)*100/3+AVG(FaDeComu)*100/3+AVG(FaDeAdap)*100/3)/4),0) AS yy FROM tevaldes ";
$Recordset1 = mysql_query($query_Recordset1, $conexion) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Evaluacion desempe&ntilde;o</title>
<style type="text/css">
<!--
.Estilo22 {color: #FFFFFF; font-weight: bold; }
.Estilo4 {font-family: Tahoma;
	color: #596221;
	font-weight: bold;
}
.Estilo24 {font-family: Tahoma; color: #596221; font-weight: bold; font-size: 12px; }
.Estilo25 {
	font-size: 18px;
	color: #98BD0D;
}
.Estilo26 {color: #596221}
.Estilo28 {font-family: Tahoma; color: #596221; font-weight: bold; font-size: 18px; }
.Estilo30 {font-size: 18px}
.Estilo33 {font-family: Tahoma; color: #596221; font-weight: bold; font-size: 14px; }
.Estilo39 {
	color: #CC3366;
	font-weight: bold;
	font-family: Tahoma;
	font-size: 14px;
}
.Estilo40 {color: #CC3366; }
-->
</style>
<link href="../ESTILSOGC.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.Estilo45 {color: #FF0000}
.Estilo46 {color: #FF0000; font-size: 24px; }
-->
</style>
</head>

<body>
<div align="center">
  <table width="838" border="0">
    <tr>
      <td width="155" height="72" bgcolor="#98BD0D"><div align="center" class="Estilo22"><img src="../IMAGENES/LOGOBOSQUETH.jpg" alt="as" width="138" height="62" onclick="print()" /></div></td>
      <td width="673" bgcolor="#98BD0D"><div align="center" class="Estilo4">EVALUACI&Oacute;N DE DESEMPE&Ntilde;O <br />
        COLABORADORES A T&Eacute;RMINO FIJO E INDEFINIDO </div></td>
    </tr>
  </table>
  <table width="838" border="0">
    <tr>
      <td width="832" bgcolor="#FFB112"><div align="center" class="Estilo4">DIRECCI&Oacute;N DE TALENTO HUMANO - CONSTRUYENDO UN MEJOR EQUIPO </div></td>
    </tr>
  </table>
  <br />
</div>
<table width="754" border="1" align="center">
  <tr valign="baseline">
    <td align="right" nowrap="nowrap" class="Estilo4">Colaborador Evaluado </td>
    <td align="right" nowrap="nowrap" class="Estilo4"><div align="center"><?php echo $row_CObtieneCamposEvaluado['NombCol']; ?> </div></td>
  </tr>
  <tr valign="baseline">
    <td align="right" valign="bottom" nowrap="nowrap" class="Estilo4">Evaluador</td>
    <td align="right" valign="bottom" class="Estilo4"><div align="center" class="Estilo28"><?php echo $row_CObtieneCamposEvaluado['JefCol']; ?></div>
        </label>
        <div align="center"></div></td>
  </tr>
  <tr valign="baseline">
    <td align="right" valign="bottom" nowrap="nowrap" class="Estilo4">Fecha evaluaci&oacute;n </td>
    <td align="right" valign="bottom" nowrap="nowrap" class="Estilo4"><div align="center"><?php echo $row_CObtieneCamposEvaluado['FechEval']; ?><br />
    </div></td>
  </tr>
</table>
<br />
<table border="1" align="center" cellspacing="1">
      <tr>
        <td colspan="5" bgcolor="#EAEAEA" class="Estilo4"><div align="center">RESULTADOS <br />
        (si alguna casilla esta vac&iacute;a, quiere decir que no respond&iacute;o alg&uacute;n &iacute;tem) </div></td>
      </tr>
      <tr>
        <td class="Estilo39"><div align="center">Calidad de la gesti&oacute;n</div></td>
        <td class="Estilo39"><div align="center">Facilitadores de desempe&ntilde;o </div></td>
        <td class="Estilo39"><div align="center"><span class="Estilo39">Compromiso Institucional</span></div></td>
        <td class="Estilo39"><div align="center">Responsabilidades /funciones</div></td>
        <td class="Estilo39"><div align="center" class="Estilo30">TOTAL</div></td>
      </tr>
      <tr>
        <td><div align="center">
            <input name="textfield" type="text" style="text-align:center" class="Estilo33" value="<?php echo $row_CObtieneCamposEvaluado['Calidad de la gestion']; ?>%" size="5" />
        </div></td>
        <td><div align="center">
          <input name="textfield2" type="text" style="text-align:center" class="Estilo33" value="<?php echo $row_CObtieneCamposEvaluado['Facilitadores de desempeno']; ?>%" size="5" />
        </div></td>
        <td><div align="center">
            <input name="textfield3" type="text" style="text-align:center" class="Estilo33" value="<?php echo $row_CObtieneCamposEvaluado['Compromiso Institucional']; ?>%" size="5" />
        </div></td>
        <td><div align="center">
            <input name="textfield4" type="text" style="text-align:center" class="Estilo33" value="<?php echo $row_CObtieneCamposEvaluado['Responsabilidades/funciones']; ?>%" size="5" />
        </div></td>
        <td><div align="center">
          <input name="textfield42" type="text" style="text-align:center" class="Estilo28" value="<?php echo $row_CObtieneCamposEvaluado['TOTAL']; ?>%" size="5" />
        </div></td>
      </tr>
</table>
    <form method="post" name="form1" action="<?php echo $editFormAction; ?>"><p><label></label>
    <label></label>
    <label></label>
    <label></label>
  </p>
  <table width="795" border="2" align="center" bordercolor="#003300">
    <tr height="20">
      <td colspan="7" bordercolor="#003300" bgcolor="#EAEAEA" class="Estilo4"><div align="center" class="Estilo25 Estilo26">
        <input name="NombCol" type="hidden" class="Estilo33" style="text-align:center" value="<?php echo $row_CObtieneCamposEvaluado['NombCol']; ?>" size="60" />
        <input name="JefCol" type="hidden" class="Estilo4" style="text-align:center" value="<?php echo $row_CObtieneCamposEvaluado['JefCol']; ?>" size="60" />
        <input name="FechEval" type="hidden" class="Estilo4" style="text-align:center"  value=<?php echo $row_CObtieneCamposEvaluado['FechEval']; ?> size="32" />
      Calidad de la gesti&oacute;n: Considere el desempe&ntilde;o obtenido por  en su labor.</div></td>
    </tr>
    
    <tr height="20">
      <td width="195" height="20" bordercolor="#003300" class="Estilo24"><div align="left">CALIDAD    DEL TRABAJO<br />
      Eficacia y eficiencia en la realizaci&oacute;n normal de las    tareas, teniendo un inter&eacute;s por obtener &oacute;ptimos resultados</div></td>
      <td width="180" bordercolor="#003300" class="Estilo24"><div align="left">Requiere una permanente    supervisi&oacute;n y en general comete muchos errores</div></td>
      <td width="21" align="center" valign="middle" bordercolor="#003300" class="Estilo24">
        
        <div align="center">
          <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['CaGeCaTr'],"1"))) {echo "checked=\"checked\"";} ?> name="CaGeCaTr" type="radio" value="1" />
      </div></td>
      <td width="145" bordercolor="#003300" class="Estilo24"><div align="left">Comete algunos    errores y la calidad es regular</div></td>
      <td width="20" align="center" valign="middle" bordercolor="#003300" class="Estilo24">
        
        <div align="center">
          <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['CaGeCaTr'],"2"))) {echo "checked=\"checked\"";} ?> name="CaGeCaTr" type="radio" value="2" />
      </div></td>
      <td width="163" bordercolor="#003300" class="Estilo24"><div align="left">La precisi&oacute;n de    su trabajo permite utilizarlo con confianza</div></td>
      <td width="23" align="center" valign="middle" bordercolor="#003300" class="Estilo24">
        <div align="center">
          <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['CaGeCaTr'],"3"))) {echo "checked=\"checked\"";} ?> name="CaGeCaTr" type="radio" value="3" />
      </div></td>
    </tr>
    <tr height="20">
      <td height="20" bordercolor="#003300" class="Estilo24"><div align="left">CONOCIMIENTO    DEL TRABAJO<br />
      Se preocupa por investigar y comprender las tareas y    funciones, aplicando las t&eacute;cnicas y m&eacute;todos pertinentes para realizarlas</div></td>
      <td bordercolor="#003300" class="Estilo24"><div align="left">No muestra ning&uacute;n inter&eacute;s en    conocer mejor su trabajo</div></td>
      <td align="center" valign="middle" bordercolor="#003300" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['CaGeCoTr'],"1"))) {echo "checked=\"checked\"";} ?> name="CaGeCoTr" type="radio" value="1" />
      </div></td>
      <td bordercolor="#003300" class="Estilo24"><div align="left">Se preocupa poco    por actualizar su conocimiento de tareas y m&eacute;todos</div></td>
      <td align="center" valign="middle" bordercolor="#003300" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['CaGeCoTr'],"2"))) {echo "checked=\"checked\"";} ?> name="CaGeCoTr" type="radio" value="2" />
      </div></td>
      <td bordercolor="#003300" class="Estilo24"><div align="left">Esta al d&iacute;a con    el conocimiento requerido para hacer efectivamente su trabajo</div></td>
      <td align="center" valign="middle" bordercolor="#003300" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['CaGeCoTr'],"3"))) {echo "checked=\"checked\"";} ?> name="CaGeCoTr" type="radio" value="3" />
      </div></td>
    </tr>
    <tr height="20">
      <td height="20" bordercolor="#003300" class="Estilo24"><div align="left">INICIATIVA<br />
      Encuentra soluciones r&aacute;pidas y mejores a los problemas    de su trabajo con el fin de agilizarlo y ser productivo</div></td>
      <td bordercolor="#003300" class="Estilo24"><div align="left">No busca soluciones y muestra    mucha pasividad para hallarlas</div></td>
      <td align="center" valign="middle" bordercolor="#003300" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['CaGeInic'],"1"))) {echo "checked=\"checked\"";} ?> name="CaGeInic" type="radio" value="1" />
      </div></td>
      <td bordercolor="#003300" class="Estilo24"><div align="left">Casi siempre    necesita orientaci&oacute;n para hallar las soluciones pertinentes</div></td>
      <td align="center" valign="middle" bordercolor="#003300" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['CaGeInic'],"2"))) {echo "checked=\"checked\"";} ?> name="CaGeInic" type="radio" value="2" />
      </div></td>
      <td bordercolor="#003300" class="Estilo24"><div align="left">Genera    frecuentemente soluciones pr&aacute;cticas y efectivas para lograr productividad</div></td>
      <td align="center" valign="middle" bordercolor="#003300" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['CaGeInic'],"3"))) {echo "checked=\"checked\"";} ?> name="CaGeInic" type="radio" value="3" />
      </div></td>
    </tr>
    <tr height="20">
      <td height="20" bordercolor="#003300" class="Estilo24"><div align="left">DISPOSICI&Oacute;N    PARA APRENDER<br />
      Receptividad para adquirir nuevos conocimientos y    adaptarse a nuevos procedimientos</div></td>
      <td bordercolor="#003300" class="Estilo24"><div align="left">No se preocupa por adquirir nuevos    conocimientos&nbsp; a pesar que se le    transmiten detalladamente</div></td>
      <td align="center" valign="middle" bordercolor="#003300" class="Estilo24"><input <?php if (!(strcmp($row_CObtieneCamposEvaluado['CaGeDiAp'],"1"))) {echo "checked=\"checked\"";} ?> name="CaGeDiAp" type="radio" value="1" /></td>
      <td bordercolor="#003300" class="Estilo24"><div align="left">Se le debe    motivar para que adquiera nuevos conocimientos y muestra resistencia</div></td>
      <td align="center" valign="middle" bordercolor="#003300" class="Estilo24"><input <?php if (!(strcmp($row_CObtieneCamposEvaluado['CaGeDiAp'],"2"))) {echo "checked=\"checked\"";} ?> name="CaGeDiAp" type="radio" value="2" /></td>
      <td bordercolor="#003300" class="Estilo24"><div align="left">Muestra un alto    inter&eacute;s en nuevos conocimientos y reacciona positivamente a los nuevos    procedimientos</div></td>
      <td align="center" valign="middle" bordercolor="#003300" class="Estilo24"><input <?php if (!(strcmp($row_CObtieneCamposEvaluado['CaGeDiAp'],"3"))) {echo "checked=\"checked\"";} ?> name="CaGeDiAp" type="radio" value="3" /></td>
    </tr>
    <tr height="20">
      <td height="20" bordercolor="#003300" class="Estilo24"><div align="left">ORGANIZACI&Oacute;N    EN EL TRABAJO<br />
      Capacidad para determinar y coordinar las acciones    necesarias para realizar efectivamente el trabajo</div></td>
      <td bordercolor="#003300" class="Estilo24"><div align="left">No tiene orden ni m&eacute;todo para    realizar su trabajo</div></td>
      <td align="center" valign="middle" bordercolor="#003300" class="Estilo24"><input <?php if (!(strcmp($row_CObtieneCamposEvaluado['CaGeOrTR'],"1"))) {echo "checked=\"checked\"";} ?> name="CaGeOrTR" type="radio" value="1" /></td>
      <td bordercolor="#003300" class="Estilo24"><div align="left">Muestra    dificultades para planear y realizar ordenadamente su trabajo</div></td>
      <td align="center" valign="middle" bordercolor="#003300" class="Estilo24"><input <?php if (!(strcmp($row_CObtieneCamposEvaluado['CaGeOrTR'],"2"))) {echo "checked=\"checked\"";} ?> name="CaGeOrTR" type="radio" value="2" /></td>
      <td bordercolor="#003300" class="Estilo24"><div align="left">Planea y realiza    su trabajo ordenada y efectivamente</div></td>
      <td align="center" valign="middle" bordercolor="#003300" class="Estilo24"><input <?php if (!(strcmp($row_CObtieneCamposEvaluado['CaGeOrTR'],"3"))) {echo "checked=\"checked\"";} ?> name="CaGeOrTR" type="radio" value="3" /></td>
    </tr>
    <tr height="20">
      <td height="20" bordercolor="#003300" class="Estilo24"><div align="left">MANEJO DE    INFORMACI&Oacute;N CON CONFIDENCIALIDAD<br />
      Es prudente con la informaci&oacute;n que maneja y la    transmite a las instancias pertinentes</div></td>
      <td bordercolor="#003300" class="Estilo24"><div align="left">Divulga la informaci&oacute;n    indiscriminadamente llevando a la desconfianza de los dem&aacute;s</div></td>
      <td align="center" valign="middle" bordercolor="#003300" class="Estilo24"><input <?php if (!(strcmp($row_CObtieneCamposEvaluado['CaGeMaIn'],"1"))) {echo "checked=\"checked\"";} ?> name="CaGeMaIn" type="radio" value="1" /></td>
      <td bordercolor="#003300" class="Estilo24"><div align="left">En ciertos casos    es imprudente con la divulgaci&oacute;n de informaci&oacute;n</div></td>
      <td align="center" valign="middle" bordercolor="#003300" class="Estilo24"><input <?php if (!(strcmp($row_CObtieneCamposEvaluado['CaGeMaIn'],"2"))) {echo "checked=\"checked\"";} ?> name="CaGeMaIn" type="radio" value="2" /></td>
      <td bordercolor="#003300" class="Estilo24"><div align="left">Muestra alta    confiabilidad en el manejo de la informaci&oacute;n</div></td>
      <td align="center" valign="middle" bordercolor="#003300" class="Estilo24"><input <?php if (!(strcmp($row_CObtieneCamposEvaluado['CaGeMaIn'],"3"))) {echo "checked=\"checked\"";} ?> name="CaGeMaIn" type="radio" value="3" /></td>
    </tr>
    <tr height="20">
      <td height="20" bordercolor="#003300" class="Estilo24"><div align="left">ATENCI&Oacute;N    AL CLIENTE<br />
      Muestra cordialidad, efectividad y disposici&oacute;n para    atender a los dem&aacute;s</div></td>
      <td bordercolor="#003300" class="Estilo24"><div align="left">Es negligente y desatento en la    atenci&oacute;n de los dem&aacute;s</div></td>
      <td align="center" valign="middle" bordercolor="#003300" class="Estilo24"><input <?php if (!(strcmp($row_CObtieneCamposEvaluado['CaGeAtCl'],"1"))) {echo "checked=\"checked\"";} ?> name="CaGeAtCl" type="radio" value="1" /></td>
      <td bordercolor="#003300" class="Estilo24"><div align="left">Le falta un poco    de amabilidad y diligencia al atender a los dem&aacute;s</div></td>
      <td align="center" valign="middle" bordercolor="#003300" class="Estilo24"><input <?php if (!(strcmp($row_CObtieneCamposEvaluado['CaGeAtCl'],"2"))) {echo "checked=\"checked\"";} ?> name="CaGeAtCl" type="radio" value="2" /></td>
      <td bordercolor="#003300" class="Estilo24"><div align="left">Brinda una    respuesta amable y efectiva al atender a los dem&aacute;s</div></td>
      <td align="center" valign="middle" bordercolor="#003300" class="Estilo24"><input <?php if (!(strcmp($row_CObtieneCamposEvaluado['CaGeAtCl'],"3"))) {echo "checked=\"checked\"";} ?> name="CaGeAtCl" type="radio" value="3" /></td>
    </tr>
    
    <tr>
      <td height="20" colspan="7" bordercolor="#003300" class="Estilo24"><div align="left"></div>        <div align="left"></div>        <div align="center"></div>        <div align="left"></div>        <div align="center"></div>        <div align="left"></div>        <div align="center"></div></td>
    </tr>
    <tr>
      <td height="20" colspan="7" bordercolor="#003300" bgcolor="#EAEAEA" class="Estilo28"><div align="center">Facilitadores de desempe&ntilde;o: Considere aquellas caracter&iacute;sticas individuales que posee el empleado para facilitar el buen desempe&ntilde;o laboral dentro y fuera del cargo.</div></td>
    </tr>
    <tr>
      <td height="20" bordercolor="#003300" class="Estilo24"><div align="left">CUMPLIMIENTO    OPORTUNO DE TAREAS ASIGNADAS Y PUNTUALIDAD<br />
      Responsabilidad, dedicaci&oacute;n y puntualidad en las tareas    y los horarios</div></td>
      <td bordercolor="#003300" class="Estilo24"><div align="left">Con frecuencia se retarda y pierde    tiempo en su trabajo</div></td>
      <td align="center" valign="middle" bordercolor="#003300" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['FaDeCuOp'],"1"))) {echo "checked=\"checked\"";} ?> name="FaDeCuOp" type="radio" value="1" />
      </div></td>
      <td bordercolor="#003300" class="Estilo24"><div align="left">Rara vez incumple    con sus tareas o sus horarios</div></td>
      <td align="center" valign="middle" bordercolor="#003300" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['FaDeCuOp'],"2"))) {echo "checked=\"checked\"";} ?> name="FaDeCuOp" type="radio" value="2" />
      </div></td>
      <td bordercolor="#003300" class="Estilo24"><div align="left">Es ejemplo de    puntualidad y cumplimiento de tareas</div></td>
      <td align="center" valign="middle" bordercolor="#003300" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['FaDeCuOp'],"3"))) {echo "checked=\"checked\"";} ?> name="FaDeCuOp" type="radio" value="3" />
      </div></td>
    </tr>
    <tr>
      <td height="20" bordercolor="#003300" class="Estilo24"><div align="left">COOPERACI&Oacute;N<br />
      Disposici&oacute;n de colaborar con los dem&aacute;s, aunque no sea    parte de sus obligaciones, aportando al trabajo en equipo</div></td>
      <td bordercolor="#003300" class="Estilo24"><div align="left">No colabora ni ayuda a los dem&aacute;s y    pone obst&aacute;culos para hacerlo</div></td>
      <td align="center" valign="middle" bordercolor="#003300" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['FaDeCoop'],"1"))) {echo "checked=\"checked\"";} ?> name="FaDeCoop" type="radio" value="1" />
      </div></td>
      <td bordercolor="#003300" class="Estilo24"><div align="left">Algunas    veces&nbsp; colabora con actividades que no    corresponden a su trabajo</div></td>
      <td align="center" valign="middle" bordercolor="#003300" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['FaDeCoop'],"2"))) {echo "checked=\"checked\"";} ?> name="FaDeCoop" type="radio" value="2" />
      </div></td>
      <td bordercolor="#003300" class="Estilo24"><div align="left">Siempre esta    dispuesto a colaborar, incluso si debe hacer esfuerzos extra</div></td>
      <td align="center" valign="middle" bordercolor="#003300" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['FaDeCoop'],"3"))) {echo "checked=\"checked\"";} ?> name="FaDeCoop" type="radio" value="3" />
      </div></td>
    </tr>
    <tr>
      <td height="20" bordercolor="#003300" class="Estilo24"><div align="left">COMUNICACI&Oacute;N<br />
      Establece canales de comunicaci&oacute;n con las personas para    lograr efectividad en el trabajo y se relaciona socialmente con los dem&aacute;s</div></td>
      <td bordercolor="#003300" class="Estilo24"><div align="left">Es una persona aislada, prefiere    no hablar con los dem&aacute;s y se muestra pasiva en la relaci&oacute;n social</div></td>
      <td align="center" valign="middle" bordercolor="#003300" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['FaDeComu'],"1"))) {echo "checked=\"checked\"";} ?> name="FaDeComu" type="radio" value="1" />
</div></td>
      <td bordercolor="#003300" class="Estilo24"><div align="left">Establece    contacto con los dem&aacute;s para lo que es estrictamente necesario</div></td>
      <td align="center" valign="middle" bordercolor="#003300" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['FaDeComu'],"2"))) {echo "checked=\"checked\"";} ?> name="FaDeComu" type="radio" value="2" />
</div></td>
      <td bordercolor="#003300" class="Estilo24"><div align="left">Establece    excelentes canales de comunicaci&oacute;n tanto laborales como sociales</div></td>
      <td align="center" valign="middle" bordercolor="#003300" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['FaDeComu'],"3"))) {echo "checked=\"checked\"";} ?> name="FaDeComu" type="radio" value="3" />
      </div></td>
    </tr>
    <tr>
      <td height="20" bordercolor="#003300" class="Estilo24"><div align="left">ADAPTABILIDAD<br />
      Capacidad de aceptar los cambios y trabajar para que    tengan &eacute;xito</div></td>
      <td bordercolor="#003300" class="Estilo24"><div align="left">Muestra resistencia ante los    cambios y no colabora para su &eacute;xito</div></td>
      <td align="center" valign="middle" bordercolor="#003300" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['FaDeAdap'],"1"))) {echo "checked=\"checked\"";} ?> name="FaDeAdap" type="radio" value="1" />
      </div></td>
      <td bordercolor="#003300" class="Estilo24"><div align="left">Muestra    aceptaci&oacute;n de los cambios pero no colabora para su &eacute;xito</div></td>
      <td align="center" valign="middle" bordercolor="#003300" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['FaDeAdap'],"2"))) {echo "checked=\"checked\"";} ?> name="FaDeAdap" type="radio" value="2" />
</div></td>
      <td bordercolor="#003300" class="Estilo24"><div align="left">Acepta los    cambios y genera estrategias para que tengan &eacute;xito</div></td>
      <td align="center" valign="middle" bordercolor="#003300" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['FaDeAdap'],"3"))) {echo "checked=\"checked\"";} ?> name="FaDeAdap" type="radio" value="3" />
      </div></td>
    </tr>
    <tr>
      <td height="20" colspan="7" bordercolor="#003300" class="Estilo24"><div align="left"></div>        <div align="left"></div>        <div align="center"></div>        <div align="left"></div>        <div align="center"></div>        <div align="left"></div>        <div align="center"></div></td>
    </tr>
    <tr>
      <td height="20" colspan="7" bordercolor="#003300" bgcolor="#EAEAEA" class="Estilo24"><div align="center" class="Estilo30">Compromiso Institucional: Considere la participaci&oacute;n del empleado en diferentes actividades de la Universidad. </div>
      <div align="left"></div>        <div align="center"></div>        <div align="left"></div>        <div align="center"></div>        <div align="left"></div>        <div align="center"></div></td>
    </tr>
    <tr height="20">
      <td height="20" bordercolor="#003300" class="Estilo24"><div align="left">PARTICIPACI&Oacute;N    EN ACTIVIDADES<br />
      Se integra y participa en los eventos de la    Universidad&nbsp;</div></td>
      <td bordercolor="#003300" class="Estilo24"><div align="left">Muestra desinter&eacute;s ante las&nbsp; actividades de la Universidad y en general    no asiste</div></td>
      <td align="center" valign="middle" bordercolor="#003300" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['CoInPaAc'],"1"))) {echo "checked=\"checked\"";} ?> name="CoInPaAc" type="radio" value="1" />
      </div></td>
      <td bordercolor="#003300" class="Estilo24"><div align="left">Rara vez asiste a    las actividades de la Universidad o no participa mucho</div></td>
      <td align="center" valign="middle" bordercolor="#003300" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['CoInPaAc'],"2"))) {echo "checked=\"checked\"";} ?> name="CoInPaAc" type="radio" value="2" />
      </div></td>
      <td bordercolor="#003300" class="Estilo24"><div align="left">En general asiste    y disfruta las actividades de la Universidad</div></td>
      <td align="center" valign="middle" bordercolor="#003300" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['CoInPaAc'],"3"))) {echo "checked=\"checked\"";} ?> name="CoInPaAc" type="radio" value="3" />
      </div></td>
    </tr>
    <tr height="20">
      <td height="20" bordercolor="#003300" class="Estilo24"><div align="left">SENTIDO DE    PERTENENCIA<br />
      Muestra compromiso con los objetivos de la Universidad    y orgullo de pertenecer a ella</div></td>
      <td bordercolor="#003300" class="Estilo24"><div align="left">Su comportamiento revela falta de    inter&eacute;s en la Universidad, sus objetivos y sus procesos</div></td>
      <td align="center" valign="middle" bordercolor="#003300" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['CoInSePe'],"1"))) {echo "checked=\"checked\"";} ?> name="CoInSePe" type="radio" value="1" />
      </div></td>
      <td bordercolor="#003300" class="Estilo24"><div align="left">Hace pocos    esfuerzos por lograr la mejora de la Universidad</div></td>
      <td align="center" valign="middle" bordercolor="#003300" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['CoInSePe'],"2"))) {echo "checked=\"checked\"";} ?> name="CoInSePe" type="radio" value="2" />
      </div></td>
      <td bordercolor="#003300" class="Estilo24"><div align="left">Hace de la    Universidad parte de su vida y lo disfruta</div></td>
      <td align="center" valign="middle" bordercolor="#003300" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['CoInSePe'],"3"))) {echo "checked=\"checked\"";} ?> name="CoInSePe" type="radio" value="3" />
      </div></td>
    </tr>
    <tr height="20">
      <td height="20" bordercolor="#003300" class="Estilo24"><div align="left">CONCIENCIA    ORGANIZACIONAL<br />
      Identificaci&oacute;n y cumplimiento de pol&iacute;ticas y normas de    la Universidad</div></td>
      <td bordercolor="#003300" class="Estilo24"><div align="left">Hace las cosas como quiere sin    respetar reglamentos ni pol&iacute;ticas</div></td>
      <td align="center" valign="middle" bordercolor="#003300" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['CoInCoOr'],"1"))) {echo "checked=\"checked\"";} ?> name="CoInCoOr" type="radio" value="1" />
      </div></td>
      <td bordercolor="#003300" class="Estilo24"><div align="left">Presenta    dificultades en el cumplimiento de normas y pol&iacute;ticas</div></td>
      <td align="center" valign="middle" bordercolor="#003300" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['CoInCoOr'],"2"))) {echo "checked=\"checked\"";} ?> name="CoInCoOr" type="radio" value="2" />
      </div></td>
      <td bordercolor="#003300" class="Estilo24"><div align="left">Cumple a    cabalidad las normas y pol&iacute;ticas</div></td>
      <td align="center" valign="middle" bordercolor="#003300" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['CoInCoOr'],"3"))) {echo "checked=\"checked\"";} ?> name="CoInCoOr" type="radio" value="3" />
      </div></td>
    </tr>
    <tr height="20">
      <td height="20" bordercolor="#003300" class="Estilo24">&nbsp;
        <div align="left">PRESENTACI&Oacute;N PERSONAL<br />
      Imagen personal que denota cuidado, pulcritud y manejo    adecuado del uniforme y la dotaci&oacute;n</div></td>
      <td bordercolor="#003300" class="Estilo24"><div align="left">En general presenta una imagen    descuidada en la vestimenta y su arreglo personal</div></td>
      <td align="center" valign="middle" bordercolor="#003300" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['CoInPrPe'],"1"))) {echo "checked=\"checked\"";} ?> name="CoInPrPe" type="radio" value="1" />
      </div></td>
      <td bordercolor="#003300" class="Estilo24"><div align="left">En algunos casos    descuida su imagen y el uso del uniforme</div></td>
      <td align="center" valign="middle" bordercolor="#003300" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['CoInPrPe'],"2"))) {echo "checked=\"checked\"";} ?> name="CoInPrPe" type="radio" value="2" />
      </div></td>
      <td bordercolor="#003300" class="Estilo24"><div align="left">Siempre est&aacute; en    &oacute;ptimas condiciones de presentaci&oacute;n y utiliza adecuadamente el uniforme</div></td>
      <td align="center" valign="middle" bordercolor="#003300" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['CoInPrPe'],"3"))) {echo "checked=\"checked\"";} ?> name="CoInPrPe" type="radio" value="3" />
      </div></td>
    </tr>
    
    <tr>
      <td height="20" colspan="7" bordercolor="#003300" class="Estilo24">&nbsp;</td>
    </tr>
    <tr>
      <td height="20" colspan="7" bordercolor="#003300" bgcolor="#EAEAEA" class="Estilo30"><div align="center"><span class="Estilo28">Ahora por favor identifique tres responsabilidades/funciones centrales del cargo que est&aacute; evaluando y califique el desempe&ntilde;o del (la) ocupante</span>.</div></td>
    </tr>
    <tr>
      <td height="20" colspan="7" bordercolor="#003300" class="Estilo24">&nbsp;</td>
    </tr>
    <tr>
      <td height="20" bordercolor="#003300" class="Estilo24"><div align="center">RESPONSABILIDAD/FUNCI&Oacute;N</div></td>
      <td height="20" colspan="6" bordercolor="#003300" class="Estilo24">&nbsp;</td>
    </tr>
    <tr>
      <td valign="baseline"><textarea name="RespUno" cols="38" rows="3" class="Estilo24"><?php echo $row_CObtieneCamposEvaluado['RespUno']; ?></textarea></td>
      <td rowspan="3" bordercolor="#003300" class="Estilo24"><div align="center">En general muestra un bajo rendimiento en esta responsabilidad </div></td>
      <td height="20" bordercolor="#003300" class="Estilo24"><input <?php if (!(strcmp($row_CObtieneCamposEvaluado['CaReUno'],"1"))) {echo "checked=\"checked\"";} ?> name="CaReUno" type="radio" value="1" /></td>
      <td rowspan="3" bordercolor="#003300" class="Estilo24"><div align="center">Cumple oportunamente con la responsabilidad o funci&oacute;n pero con mediana calidad </div></td>
      <td height="20" bordercolor="#003300" class="Estilo24"><input <?php if (!(strcmp($row_CObtieneCamposEvaluado['CaReUno'],"2"))) {echo "checked=\"checked\"";} ?> name="CaReUno" type="radio" value="2" /></td>
      <td rowspan="3" bordercolor="#003300" class="Estilo24"><div align="center">El cumplimiento de la responsabilidad o funci&oacute;n es ejemplar y confiable </div></td>
      <td height="20" bordercolor="#003300" class="Estilo24"><input <?php if (!(strcmp($row_CObtieneCamposEvaluado['CaReUno'],"3"))) {echo "checked=\"checked\"";} ?> name="CaReUno" type="radio" value="3" /></td>
    </tr>
    <tr>
      <td valign="baseline"><textarea name="RespDos" cols="38" rows="3" class="Estilo24"><?php echo $row_CObtieneCamposEvaluado['RespDos']; ?></textarea></td>
      <td height="20" bordercolor="#003300" class="Estilo24"><input <?php if (!(strcmp($row_CObtieneCamposEvaluado['CaReDos'],"1"))) {echo "checked=\"checked\"";} ?> name="CaReDos" type="radio" value="1" /></td>
      <td height="20" bordercolor="#003300" class="Estilo24"><input <?php if (!(strcmp($row_CObtieneCamposEvaluado['CaReDos'],"2"))) {echo "checked=\"checked\"";} ?> name="CaReDos" type="radio" value="2" /></td>
      <td height="20" bordercolor="#003300" class="Estilo24"><input <?php if (!(strcmp($row_CObtieneCamposEvaluado['CaReDos'],"3"))) {echo "checked=\"checked\"";} ?> name="CaReDos" type="radio" value="3" /></td>
    </tr>
    <tr>
      <td valign="baseline"><textarea name="RespTres" cols="38" rows="3" class="Estilo24"><?php echo $row_CObtieneCamposEvaluado['RespTres']; ?></textarea></td>
      <td height="20" bordercolor="#003300" class="Estilo24"><input <?php if (!(strcmp($row_CObtieneCamposEvaluado['CaReTres'],"1"))) {echo "checked=\"checked\"";} ?> name="CaReTres" type="radio" value="1" /></td>
      <td height="20" bordercolor="#003300" class="Estilo24"><input <?php if (!(strcmp($row_CObtieneCamposEvaluado['CaReTres'],"2"))) {echo "checked=\"checked\"";} ?> name="CaReTres" type="radio" value="2" /></td>
      <td height="20" bordercolor="#003300" class="Estilo24"><input <?php if (!(strcmp($row_CObtieneCamposEvaluado['CaReTres'],"3"))) {echo "checked=\"checked\"";} ?> name="CaReTres" type="radio" value="3" /></td>
    </tr>
    <tr>
      <td height="20" colspan="7" bordercolor="#003300" class="Estilo24"><div align="left"></div>        
      <div align="left"></div>        <div align="center"></div>        <div align="left"></div>        <div align="center"></div>        <div align="left"></div>        <div align="center"></div></td>
    </tr>
    <tr>
      <td height="20" colspan="7" bordercolor="#003300" bgcolor="#EAEAEA" class="Estilo28"><div align="center">PLAN DE MEJORAMIENTO</div></td>
    </tr>
    <tr>
      <td height="20" colspan="7" bordercolor="#596221" class="Estilo24"><div align="center">FORTALEZAS<br />
          <textarea name="PlMeFort" cols="100" rows="4" class="Estilo24"><?php echo $row_CObtieneCamposEvaluado['PlMeFort']; ?></textarea>
      </div></td>
    </tr>
    <tr>
      <td height="20" colspan="7" bordercolor="#596221" class="Estilo24"><div align="center">ASPECTOS POR MEJORAR<br />
          <textarea name="PlMeAsMe" cols="100" rows="4" class="Estilo24"><?php echo $row_CObtieneCamposEvaluado['PlMeAsMe']; ?></textarea>
      </div></td>
    </tr>
    <tr>
      <td height="20" colspan="7" bordercolor="#596221" class="Estilo24"><div align="center">COMPROMISOS ADQUIRIDOS POR EL COLABORADOR PARA EL PLAN DE MEJORAMIENTO<br />
          <textarea name="PlMePlMe" cols="100" rows="4" class="Estilo24"><?php echo $row_CObtieneCamposEvaluado['PlMePlMe']; ?></textarea>
      </div></td>
    </tr>
    <tr>
      <td height="20" colspan="7" bordercolor="#596221" class="Estilo24"><div align="center">PLAZO ACORDADO PARA EL PLAN DE MEJORAMIENTO<br />
          <textarea name="PlMePlAc" cols="100" rows="4" class="Estilo24"><?php echo $row_CObtieneCamposEvaluado['PlMePlAc']; ?></textarea>
      </div></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="797" border="1" align="center">
    
    <tr>
      <td height="64" bordercolor="#596221" class="Estilo4">&nbsp;</td>
      <td bordercolor="#596221" class="Estilo4">&nbsp;</td>
      <td bordercolor="#596221" class="Estilo4">&nbsp;</td>
    </tr>
    <tr>
      <td width="239" bordercolor="#596221" class="Estilo4"><div align="center">Jefe de Talento Humano </div></td>
      <td width="208" bordercolor="#596221" class="Estilo4"><div align="center">Nombre del evaluador</div></td>
      <td width="328" bordercolor="#596221" class="Estilo4"><div align="center">Nombre del evaluado </div></td>
    </tr>
    <tr>
      <td bordercolor="#596221" class="Estilo33">SANDRA PATRICIA SARMIENTO GARZON</td>
      <td bordercolor="#596221" class="Estilo4"><?php echo $row_CObtieneCamposEvaluado['JefCol']; ?></td>
      <td bordercolor="#596221" class="Estilo4"><?php echo $row_CObtieneCamposEvaluado['NombCol']; ?></td>
    </tr>
  </table>
  <p>
	<input type="hidden" name="MM_update" value="form1">
    <input name="IdColab" type="hidden" id="IdColab" value="<?php echo $row_CObtieneCamposEvaluado['IdColab']; ?>" />
    <input name="IdEvalDes" type="hidden" id="IdEvalDes" value="<?php echo $row_CObtieneCamposEvaluado['IdEvalDes']; ?>" />
  </p>
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($CObtieneCamposEvaluado);

mysql_free_result($Colaboradores);

mysql_free_result($Jefes);

mysql_free_result($Recordset1);

?>

