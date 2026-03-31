<?php require_once('../../Connections/conexion.php'); error_reporting(0)?>
<?php
date_default_timezone_set('America/Bogota');

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
$VAR1_CObtieneCamposEvaluado = "-1";
if (isset($_GET['NombCol'])) {
  $VAR1_CObtieneCamposEvaluado = (get_magic_quotes_gpc()) ? $_GET['NombCol'] : addslashes($_GET['NombCol']);
}
$VAR2_CObtieneCamposEvaluado = "-1";
if (isset($_GET['JefCol'])) {
  $VAR2_CObtieneCamposEvaluado = (get_magic_quotes_gpc()) ? $_GET['JefCol'] : addslashes($_GET['JefCol']);
}
$VAR3_CObtieneCamposEvaluado = "-1";
if (isset($_GET['date'])) {
  $VAR3_CObtieneCamposEvaluado = (get_magic_quotes_gpc()) ? $_GET['date'] : addslashes($_GET['date']);
}
$VAR4_CObtieneCamposEvaluado = "-1";
if (isset($_GET['IdColab'])) {
  $VAR4_CObtieneCamposEvaluado = (get_magic_quotes_gpc()) ? $_GET['IdColab'] : addslashes($_GET['IdColab']);
}
mysql_select_db($database_conexion, $conexion);
$query_CObtieneCamposEvaluado = sprintf("SELECT *, ROUND(((((P1)*100/5+(P2)*100/5+(P3)*100/5+(P4)*100/5+(P5)*100/5))/5),0) AS 'Habilidades y Destrezas',    ROUND((((P6)*100/5+(P7)*100/5+(P8)*100/5+(P9)*100/5)/4),0) AS 'Calidad de la gestión',   ROUND((((P10)*100/5+(P11)*100/5+(P12)*100/5+(P13)*100/5+(P14)*100/5+(P15)*100/5+(P16)*100/5)/7),0) AS 'Facilitadores de Desempeño',   ROUND((((P17)*100/5+(P18)*100/5+(P19)*100/5+(P20)*100/5)/4),0) AS 'Compromiso Institucional',   ROUND((((P1)*100/5+(P2)*100/5+(P3)*100/5+(P4)*100/5+ (P5)*100/5+(P6)*100/5 +(P7)*100/5+ (P8)*100/5 +(P9)*100/5+(P10)*100/5+(P11)*100/5+(P12)*100/5+(P13)*100/5+(P14)*100/5 + (P15)*100/5+(P16)*100/5+(P17)*100/5+(P18)*100/5+(P19)*100/5+(P20)*100/5)/20),0) AS TOTAL FROM nuevo_tevaldes_estrategico_tacticos WHERE nuevo_tevaldes_estrategico_tacticos.NombCol = '%s' AND nuevo_tevaldes_estrategico_tacticos.JefCol ='%s' AND nuevo_tevaldes_estrategico_tacticos.FechEval ='%s' AND nuevo_tevaldes_estrategico_tacticos.IdColab ='%s' ", $VAR1_CObtieneCamposEvaluado,$VAR2_CObtieneCamposEvaluado,$VAR3_CObtieneCamposEvaluado,$VAR4_CObtieneCamposEvaluado);
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
  $insertSQL = sprintf("INSERT INTO nuevo_tevaldes_estrategico_tacticos (NombCol, JefCol, FechEval, IdColab) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_GET['NombCol'], "text"),
                       GetSQLValueString($_GET['JefCol'], "text"),
                       GetSQLValueString(date('Y-m-d'), "date"),
					   GetSQLValueString($_GET['IdColab'], "text"));
  //var_dump($insertSQL);
  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
  
  $insertGoTo = "Nuevo_EvalDes_Estrategico_Tacticos.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));

} else {
	if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
	  $updateSQL = sprintf("UPDATE nuevo_tevaldes_estrategico_tacticos SET NombCol=%s, JefCol=%s, FechEval=%s, IdColab=%s, P1=%s, P2=%s, P3=%s, P4=%s, P5=%s, P6=%s, P7=%s, P8=%s, P9=%s, P10=%s, P11=%s, P12=%s, P13=%s, P14=%s, P15=%s, P16=%s, P17=%s, P18=%s, P19=%s, P20=%s, PlMeFort=%s, PlMeAsMe=%s, PlMePlMe=%s, PlMePlAc=%s, CoGePeTf=%s, NeceCapac=%s, Evaluador=%s, Evaluado=%s, JefeTH=%s WHERE IdEvalDes=%s",
						   GetSQLValueString($_POST['NombCol'], "text"),
						   GetSQLValueString($_POST['JefCol'], "text"),
						   GetSQLValueString($_POST['FechEval'], "date"),
						   GetSQLValueString($_POST['IdColab'], "int"),
						   GetSQLValueString($_POST['P1'], "int"),
						   GetSQLValueString($_POST['P2'], "int"),
						   GetSQLValueString($_POST['P3'], "int"),
						   GetSQLValueString($_POST['P4'], "int"),
						   GetSQLValueString($_POST['P5'], "int"),
						   GetSQLValueString($_POST['P6'], "int"),
						   GetSQLValueString($_POST['P7'], "int"),
						   GetSQLValueString($_POST['P8'], "int"),
						   GetSQLValueString($_POST['P9'], "int"),
						   GetSQLValueString($_POST['P10'], "int"),
						   GetSQLValueString($_POST['P11'], "int"),
						   GetSQLValueString($_POST['P12'], "int"),
						   GetSQLValueString($_POST['P13'], "int"),
						   GetSQLValueString($_POST['P14'], "int"),
						   GetSQLValueString($_POST['P15'], "int"),
						   GetSQLValueString($_POST['P16'], "int"),
						   GetSQLValueString($_POST['P17'], "int"),
						   GetSQLValueString($_POST['P18'], "int"),
						   GetSQLValueString($_POST['P19'], "int"),
						   GetSQLValueString($_POST['P20'], "int"),
						   GetSQLValueString($_POST['PlMeFort'], "text"),
						   GetSQLValueString($_POST['PlMeAsMe'], "text"),
						   GetSQLValueString($_POST['PlMePlMe'], "text"),
						   GetSQLValueString($_POST['PlMePlAc'], "text"),
						   GetSQLValueString($_POST['CoGePeTf'], "text"),
						   GetSQLValueString($_POST['NeceCapac'], "text"),
						   GetSQLValueString($_POST['Evaluador'], "text"),
						   GetSQLValueString($_POST['Evaluado'], "text"),
						   GetSQLValueString($_POST['JefeTH'], "text"),
						   GetSQLValueString($_POST['IdEvalDes'], "int"));
  	 // echo $updateSQL;
	  mysql_select_db($database_conexion, $conexion);
	  $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());
	  
  $insertGoTo = "Nuevo_EvalDes_Estrategico_Tacticos.php";
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
$query_Recordset1 = "SELECT ROUND((((AVG(P1)*100/3+AVG(P2)*100/3+AVG(P3)*100/3+AVG(P4)*100/3+AVG(P5)*100/3)+AVG(P6)*100/3 +AVG(P7)*100/3)/7),0) AS xx,  ROUND(((AVG(P8)*100/3+AVG(P9)*100/3+AVG(P10)*100/3+AVG(P11)*100/3)/4),0) AS yy FROM nuevo_tevaldes_estrategico_tacticos ";
$Recordset1 = mysql_query($query_Recordset1, $conexion) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Evaluacion Desempe&ntilde;o</title>
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
.Estilo42 {color: #CC3366; font-size: 18px; }
-->
</style>
<link href="../../ESTILSOGC.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.Estilo44 {font-size: 14px}
.Estilo45 {color: #FFFFFF}
.Estilo46 {font-weight: bold; font-size: 18px; font-family: Tahoma;}
-->
</style>
</head>

<body>
<div align="center">
  <table width="838" border="0">
    <tr>
      <td width="155" height="72" bgcolor="#7BC142"><div align="center" class="Estilo22"><img src="../../IMAGENES/BOSQUEDPTOTH2.png" alt="as" width="250" height="97" onclick="print()" /></div></td>
      <td width="673" bgcolor="#7BC142"><div align="center" class="Estilo4 Estilo45">EVALUACI&Oacute;N DE DESEMPE&Ntilde;O <br />
      COLABORADORES ESTRAT&Eacute;GICOS A T&Eacute;RMINO FIJO E INDEFINIDO </div></td>
    </tr>
  </table>
  <table width="838" border="0">
    <tr>
      <td width="832" bgcolor="#8CC63F"><div align="center" class="Estilo4 Estilo45">DEPARTAMENTO DE TALENTO HUMANO - CONSTRUYENDO UN MEJOR EQUIPO </div></td>
    </tr>
  </table>
  <br />
  <table width="754" align="center">
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#FFFFFF" class="Estilo4">Colaborador Evaluado:&nbsp; </td>
      <td align="right" nowrap="nowrap" bgcolor="#FFFFFF" class="Estilo4"><div align="left"><?php echo $row_CObtieneCamposEvaluado['NombCol']; ?>
        </div>      </tr>
    <tr valign="baseline">
      <td align="right" valign="bottom" nowrap="nowrap" bgcolor="#FFFFFF" class="Estilo4">C&eacute;dula:&nbsp;</td>
      <td align="right" valign="bottom" bgcolor="#FFFFFF" class="Estilo4"><div align="left"><?php echo $row_CObtieneCamposEvaluado['IdColab']; ?></div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="bottom" nowrap="nowrap" bgcolor="#FFFFFF" class="Estilo4">Evaluador:&nbsp;</td>
      <td align="right" valign="bottom" bgcolor="#FFFFFF" class="Estilo4"><div align="center" class="Estilo28">
        <div align="left"><?php echo $row_CObtieneCamposEvaluado['JefCol']; ?></div>
      </div>
      <div align="left"></div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="bottom" nowrap="nowrap" bgcolor="#FFFFFF" class="Estilo4">Fecha evaluaci&oacute;n:&nbsp; </td>
      <td align="right" valign="bottom" nowrap="nowrap" bgcolor="#FFFFFF" class="Estilo4"><div align="left"><?php echo $row_CObtieneCamposEvaluado['FechEval']; ?><br />
      </div></td>
    </tr>
    <tr valign="baseline">
      <td align="right" valign="bottom" nowrap="nowrap" bgcolor="#FFFFFF" class="Estilo4">&nbsp;</td>
      <td align="right" valign="bottom" nowrap="nowrap" bgcolor="#FFFFFF" class="Estilo4">&nbsp;</td>
    </tr>
  </table>
  <br />
  <table border="1" align="center" cellspacing="1" bordercolor="#C9E6B0">
    <tr>
      <td colspan="5" bgcolor="#FFFFFF" class="Estilo4"><div align="center">RESULTADOS</div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFEC" class="Estilo39"><div align="center">&nbsp;Habilidades de gesti&oacute;n </div></td>
      <td bgcolor="#FFFFEC" class="Estilo39"><div align="center">&nbsp;Calidad de la gesti&oacute;n&nbsp; </div></td>
      <td bgcolor="#FFFFEC" class="Estilo39"><div align="center">&nbsp;Facilitadores de Desempe&ntilde;o</div></td>
      <td bgcolor="#FFFFEC" class="Estilo39"><div align="center">&nbsp;Compromiso insttiucional </div></td>
      <td bgcolor="#FFFFEC" class="Estilo39"><div align="center" class="Estilo30">TOTAL</div></td>
    </tr>
    <tr>
      <td bgcolor="#FFFFEC"><div align="center">
          <input name="textfield" type="text" style="text-align:center" class="Estilo33" value="<?php echo $row_CObtieneCamposEvaluado['Habilidades y Destrezas']; ?>%" size="5" />
      </div></td>
      <td bgcolor="#FFFFEC"><div align="center">
          <input name="textfield2" type="text" style="text-align:center" class="Estilo33" value="<?php echo $row_CObtieneCamposEvaluado['Calidad de la gestión']; ?>%" size="5" />
      </div></td>
      <td bgcolor="#FFFFEC"><div align="center">
          <input name="textfield3" type="text" style="text-align:center" class="Estilo33" value="<?php echo $row_CObtieneCamposEvaluado['Facilitadores de Desempeño']; ?>%" size="5" />
      </div></td>
      <td bgcolor="#FFFFEC"><div align="center">
          <input name="textfield4" type="text" style="text-align:center" class="Estilo33" value="<?php echo $row_CObtieneCamposEvaluado['Compromiso Institucional']; ?>%" size="5" />
      </div></td>
      <td bgcolor="#FFFFEC"><div align="center">
          <input name="textfield42" type="text" style="text-align:center" class="Estilo28" value="<?php echo $row_CObtieneCamposEvaluado['TOTAL']; ?>%" size="5" />
      </div></td>
    </tr>
  </table>
  <br />
</div>
<br />
    <label></label>
<label></label>
<label></label>
<label></label>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
      <table width="795" border="2" align="center" bordercolor="#003300" bgcolor="#FFFFEC">
    <tr height="20">
      <td colspan="6" bordercolor="#003300" bgcolor="#FFFFFF" class="Estilo28"><p align="center"><strong>Escala de  valoraci&oacute;n: </strong></p>
      <p align="center"><strong>1-Insuficiente - 2. Deficiente - 3. Regular - 4 Bueno - 5 Excelente</strong></p></td>
    </tr>
    <tr height="20">
      <td colspan="6" bordercolor="#003300" bgcolor="#8CC63F" class="Estilo4"><div align="center" class="Estilo25 Estilo26">
        <input name="NombCol" type="hidden" class="Estilo33" style="text-align:center" value="<?php echo $row_CObtieneCamposEvaluado['NombCol']; ?>" size="60" />
        <input name="JefCol" type="hidden" class="Estilo4" style="text-align:center" value="<?php echo $row_CObtieneCamposEvaluado['JefCol']; ?>" size="60" />
        <span class="Estilo45">
        <input name="FechEval" type="hidden" class="Estilo4" style="text-align:center"  value=<?php echo $row_CObtieneCamposEvaluado['FechEval']; ?> size="32" />
        <span class="Estilo46">HABILIDADES DE GESTI&Oacute;N </span></span></div></td>
    </tr>
    
    <tr height="20">
      <td height="20" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24">&nbsp;</td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24">1</td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24">2</td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24">3</td>
      <td align="center" valign="middle" bgcolor="#FFFFEC" class="Estilo24">4</td>
      <td align="center" valign="middle" bgcolor="#FFFFEC" class="Estilo24">5</td>
    </tr>
    <tr height="20">
      <td height="20" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24"><p>CAPACIDAD PARA  GESTIONAR PROYECTOS</p>
        <p>Habilidad para  crear y mantener un proyecto desde su inicio hasta su culminaci&oacute;n, teniendo en cuenta sus fases, metas y  prioridades para la consecusion de los objetivos propuestos</p></td>
      <td width="21" align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24">
        
        <div align="center">
          <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P1'],"1"))) {echo "checked=\"checked\"";} ?> name="P1" type="radio" value="1" />
        </div></td>
      <td width="20" align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24">
        
        <div align="center">
          <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P1'],"2"))) {echo "checked=\"checked\"";} ?> name="P1" type="radio" value="2" />
        </div></td>
      <td width="23" align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24">
        
        <div align="center">
          <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P1'],"3"))) {echo "checked=\"checked\"";} ?> name="P1" type="radio" value="3" />
        </div></td>
      <td width="23" align="center" valign="middle" bgcolor="#FFFFEC" class="Estilo24">
        
        <div align="center">
          <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P1'],"4"))) {echo "checked=\"checked\"";} ?> name="P1" type="radio" value="4" />
        </div></td>
      <td width="23" align="center" valign="middle" bgcolor="#FFFFEC" class="Estilo24">
        
        <div align="center">
          <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P1'],"5"))) {echo "checked=\"checked\"";} ?> name="P1" type="radio" value="5" />
        </div></td></tr>
    <tr height="20">
      <td height="20" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24"><div align="left">
        <p>ORIENTACI&Oacute;N A RESULTADOS</p>
        <p>Disposici&oacute;n constante para alcanzar o superar resultados  concretos, medibles, cuantificables y verificables mediante el cumplimiento  oportuno de las responsabilidades asociadas a su cargo.</p>
      </div></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24">
        <div align="center">
          <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P2'],"1"))) {echo "checked=\"checked\"";} ?> name="P2" type="radio" value="1" />
        </div></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24">
        <div align="center">
          <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P2'],"2"))) {echo "checked=\"checked\"";} ?> name="P2" type="radio" value="2" />
        </div></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24">
        <div align="center">
          <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P2'],"3"))) {echo "checked=\"checked\"";} ?> name="P2" type="radio" value="3" />
        </div></td>
      <td align="center" valign="middle" bgcolor="#FFFFEC" class="Estilo24">
        <div align="center">
          <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P2'],"4"))) {echo "checked=\"checked\"";} ?> name="P2" type="radio" value="4" />
        </div></td>
      <td align="center" valign="middle" bgcolor="#FFFFEC" class="Estilo24">
        <div align="center">
          <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P2'],"5"))) {echo "checked=\"checked\"";} ?> name="P2" type="radio" value="5" />
        </div></td></tr>
    <tr height="20">
      <td height="20" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24"><p>USO DE  HERRAMIENTAS TECNOLOGICAS</p>
        <p>Capacidad para  seleccionar y utilizar de forma pertinenete, responsable y eficiente, las  herramientas tecnologicas que facilitan y agilizan el desarrollo de las  funciones propias del cargo.</p></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24">
        <div align="center">
          <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P3'],"1"))) {echo "checked=\"checked\"";} ?> name="P3" type="radio" value="1" />
        </div></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24">
        <div align="center">
          <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P3'],"2"))) {echo "checked=\"checked\"";} ?> name="P3" type="radio" value="2" />
        </div></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24">
        <div align="center">
          <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P3'],"3"))) {echo "checked=\"checked\"";} ?> name="P3" type="radio" value="3" />
        </div></td>
      <td align="center" valign="middle" bgcolor="#FFFFEC" class="Estilo24">
        <div align="center">
          <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P3'],"4"))) {echo "checked=\"checked\"";} ?> name="P3" type="radio" value="4" />
        </div></td>
      <td align="center" valign="middle" bgcolor="#FFFFEC" class="Estilo24">
        <div align="center">
          <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P3'],"5"))) {echo "checked=\"checked\"";} ?> name="P3" type="radio" value="5" />
        </div></td></tr>
    <tr height="20">
      <td height="20" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24"><p>EXPERTICIA  PROFESIONAL</p>
        <p>Capacidad para  aplicar el conocimiento profesional en la resolucion de problemas y transferido  a su entorno laboral</p>      </td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P4'],"1"))) {echo "checked=\"checked\"";} ?> name="P4" type="radio" value="1" />
      </div></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P4'],"2"))) {echo "checked=\"checked\"";} ?> name="P4" type="radio" value="2" />
      </div></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P4'],"3"))) {echo "checked=\"checked\"";} ?> name="P4" type="radio" value="3" />
      </div></td>
      <td align="center" valign="middle" bgcolor="#FFFFEC" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P4'],"4"))) {echo "checked=\"checked\"";} ?> name="P4" type="radio" value="4" />
      </div></td>
      <td align="center" valign="middle" bgcolor="#FFFFEC" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P4'],"5"))) {echo "checked=\"checked\"";} ?> name="P4" type="radio" value="5" />
      </div></td>
    </tr>
    <tr height="20">
      <td height="20" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24"><p>CAPACIDAD DE  PLANEACI&Oacute;N Y ORGANIZACI&Oacute;N</p>
        <p>Capacidad de  fijar metas y prioridades a la hora de realizar una tarea o un proyecto,  desarrollando acciones, plazos y recursos que se deben utilizar</p></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P5'],"1"))) {echo "checked=\"checked\"";} ?> name="P5" type="radio" value="1" />
      </div></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P5'],"2"))) {echo "checked=\"checked\"";} ?> name="P5" type="radio" value="2" />
      </div></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P5'],"3"))) {echo "checked=\"checked\"";} ?> name="P5" type="radio" value="3" />
      </div></td>
      <td align="center" valign="middle" bgcolor="#FFFFEC" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P5'],"4"))) {echo "checked=\"checked\"";} ?> name="P5" type="radio" value="4" />
      </div></td>
      <td align="center" valign="middle" bgcolor="#FFFFEC" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P5'],"5"))) {echo "checked=\"checked\"";} ?> name="P5" type="radio" value="5" />
      </div></td>
    </tr>
    <tr height="20">
      <td height="20" colspan="6" bordercolor="#003300" bgcolor="#8CC63F" class="Estilo24"><div align="center" class="Estilo28 Estilo45">CALIDAD DE LA GESTI&Oacute;N</div></td>
      </tr>
    <tr height="20">
      <td height="20" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24"><div align="justify">
        <p>TOMA DE DECISIONES</p>
        <p>Capacidad para elegir  entre varias opciones o situaciones aquellas que resultan m&aacute;s favorables a la instituci&oacute;n, de manera eficiente y eficaz para solucionar  problemas o atender situaciones complejas, comprometi&eacute;ndose con acciones concretas y consecuentes con la  decisi&oacute;n.</p>
        </div></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24"><input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P6'],"1"))) {echo "checked=\"checked\"";} ?> name="P6" type="radio" value="1" /></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24"><input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P6'],"2"))) {echo "checked=\"checked\"";} ?> name="P6" type="radio" value="2" /></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24"><input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P6'],"3"))) {echo "checked=\"checked\"";} ?> name="P6" type="radio" value="3" /></td>
      <td align="center" valign="middle" bgcolor="#FFFFEC" class="Estilo24"><input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P6'],"4"))) {echo "checked=\"checked\"";} ?> name="P6" type="radio" value="4" /></td>
      <td align="center" valign="middle" bgcolor="#FFFFEC" class="Estilo24"><input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P6'],"5"))) {echo "checked=\"checked\"";} ?> name="P6" type="radio" value="5" /></td>
    </tr>
    <tr height="20">
      <td height="20" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24"><strong>INICIATIVA</strong><br />
        <br />
        <p>Capacidad para  proponer y desarrollar ideas que permitan mejorar los procesos de la  Dependencia frente a la naturaleza de la Universidad.</p></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24"><input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P7'],"1"))) {echo "checked=\"checked\"";} ?> name="P7" type="radio" value="1" /></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24"><input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P7'],"2"))) {echo "checked=\"checked\"";} ?> name="P7" type="radio" value="2" /></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24"><input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P7'],"3"))) {echo "checked=\"checked\"";} ?> name="P7" type="radio" value="3" /></td>
      <td align="center" valign="middle" bgcolor="#FFFFEC" class="Estilo24"><input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P7'],"4"))) {echo "checked=\"checked\"";} ?> name="P7" type="radio" value="4" /></td>
      <td align="center" valign="middle" bgcolor="#FFFFEC" class="Estilo24"><input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P7'],"5"))) {echo "checked=\"checked\"";} ?> name="P7" type="radio" value="5" /></td>
    </tr>
    <tr>
      <td height="20" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24"><strong>MANEJO  DE LA INFORMACI&Oacute;N Y CONFIDENCIALIDAD<br />
        <br /></strong>
        <p>Capacidad de  administrar la informaci&oacute;n propia del que hacer  diario con sentido de responsabilidad.</p></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P8'],"1"))) {echo "checked=\"checked\"";} ?> name="P8" type="radio" value="1" />
      </div></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P8'],"2"))) {echo "checked=\"checked\"";} ?> name="P8" type="radio" value="2" />
      </div></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P8'],"3"))) {echo "checked=\"checked\"";} ?> name="P8" type="radio" value="3" />
      </div></td>
      <td align="center" valign="middle" bgcolor="#FFFFEC" class="Estilo24"><div align="center">
          <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P8'],"4"))) {echo "checked=\"checked\"";} ?> name="P8" type="radio" value="4" />
      </div></td>
      <td align="center" valign="middle" bgcolor="#FFFFEC" class="Estilo24"><div align="center">
          <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P8'],"5"))) {echo "checked=\"checked\"";} ?> name="P8" type="radio" value="5" />
      </div></td>
    </tr>
    <tr>
      <td height="20" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24"><p><strong>ORDEN  Y CALIDAD</strong><br />
          <br />
          Preocupaci&oacute;n constante por el mantenimiento y control del  orden en los procesos que desarrolla, orientado al logro de los objetivos bajo  est&aacute;ndares adecuados de calidad.</p>      </td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P9'],"1"))) {echo "checked=\"checked\"";} ?> name="P9" type="radio" value="1" />
      </div></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P9'],"2"))) {echo "checked=\"checked\"";} ?> name="P9" type="radio" value="2" />
      </div></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P9'],"3"))) {echo "checked=\"checked\"";} ?> name="P9" type="radio" value="3" />
      </div></td>
      <td align="center" valign="middle" bgcolor="#FFFFEC" class="Estilo24"><div align="center">
          <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P9'],"4"))) {echo "checked=\"checked\"";} ?> name="P9" type="radio" value="4" />
      </div></td>
      <td align="center" valign="middle" bgcolor="#FFFFEC" class="Estilo24"><div align="center">
          <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P9'],"5"))) {echo "checked=\"checked\"";} ?> name="P9" type="radio" value="5" />
      </div></td>
    </tr>
    <tr>
      <td height="20" colspan="6" bordercolor="#003300" bgcolor="#8CC63F" class="Estilo24"><p align="center" class="Estilo28 Estilo45">FACILITADORES DE  DESEMPE&Ntilde;O</p></td>
      </tr>
    <tr>
      <td height="20" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24"><strong>CONOCIMIENTOS  T&Eacute;CNICOS RELACIONADOS CON EL PERFIL Y CON EL CARGO</strong><br />
      <p>Dominio de  habilidades y destrezas requeridas,&nbsp;  traducida en la buena utilizaci&oacute;n de t&eacute;cnicas y  procedimientos&nbsp; en el desempe&ntilde;o del cargo.</p></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P10'],"1"))) {echo "checked=\"checked\"";} ?> name="P10" type="radio" value="1" />
</div></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P10'],"2"))) {echo "checked=\"checked\"";} ?> name="P10" type="radio" value="2" />
</div></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P10'],"3"))) {echo "checked=\"checked\"";} ?> name="P10" type="radio" value="3" />
      </div></td>
      <td align="center" valign="middle" bgcolor="#FFFFEC" class="Estilo24"><div align="center">
          <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P10'],"4"))) {echo "checked=\"checked\"";} ?> name="P10" type="radio" value="4" />
      </div></td>
      <td align="center" valign="middle" bgcolor="#FFFFEC" class="Estilo24"><div align="center">
          <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P10'],"5"))) {echo "checked=\"checked\"";} ?> name="P10" type="radio" value="5" />
      </div></td>
    </tr>
    <tr>
      <td height="20" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24"><strong>CUMPLIMIENTO  OPORTUNO DE TAREAS ASIGNADAS</strong><br />
      <p>Realizaci&oacute;n y entrega de los trabajos a tiempo, teniendo en  cuenta los requerimientos del servicio y la organizaci&oacute;n del mismo.</p></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P11'],"1"))) {echo "checked=\"checked\"";} ?> name="P11" type="radio" value="1" />
      </div></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P11'],"2"))) {echo "checked=\"checked\"";} ?> name="P11" type="radio" value="2" />
</div></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P11'],"3"))) {echo "checked=\"checked\"";} ?> name="P11" type="radio" value="3" />
      </div></td>
      <td align="center" valign="middle" bgcolor="#FFFFEC" class="Estilo24"><div align="center">
          <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P11'],"4"))) {echo "checked=\"checked\"";} ?> name="P11" type="radio" value="4" />
      </div></td>
      <td align="center" valign="middle" bgcolor="#FFFFEC" class="Estilo24"><div align="center">
          <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P11'],"5"))) {echo "checked=\"checked\"";} ?> name="P11" type="radio" value="5" />
      </div></td>
    </tr>
    <tr height="20">
      <td height="20" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24"><p><strong>DISPOSICI&Oacute;N  PARA EL TRABAJO<br />
        <br /></strong>Actitud positiva  relacionada con las actividades diarias a desarrollar.</p>      </td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P12'],"1"))) {echo "checked=\"checked\"";} ?> name="P12" type="radio" value="1" />
      </div></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P12'],"2"))) {echo "checked=\"checked\"";} ?> name="P12" type="radio" value="2" />
      </div></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P12'],"3"))) {echo "checked=\"checked\"";} ?> name="P12" type="radio" value="3" />
      </div></td>
      <td align="center" valign="middle" bgcolor="#FFFFEC" class="Estilo24"><div align="center">
          <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P12'],"4"))) {echo "checked=\"checked\"";} ?> name="P12" type="radio" value="4" />
      </div></td>
      <td align="center" valign="middle" bgcolor="#FFFFEC" class="Estilo24"><div align="center">
          <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P12'],"5"))) {echo "checked=\"checked\"";} ?> name="P12" type="radio" value="5" />
      </div></td>
    </tr>
    <tr height="20">
      <td height="20" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24"><strong>TRABAJO  EN EQUIPO</strong><br />
        <br />
        <p>Capacidad de integraci&oacute;n con el equipo de trabajo, aportando  conocimientos, ideas y experiencias, con el fin de definir objetivos,  establecer roles y responsabilidades para el cumplimiento de &eacute;stos.</p></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P13'],"1"))) {echo "checked=\"checked\"";} ?> name="P13" type="radio" value="1" />
      </div></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P13'],"2"))) {echo "checked=\"checked\"";} ?> name="P13" type="radio" value="2" />
      </div></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P13'],"3"))) {echo "checked=\"checked\"";} ?> name="P13" type="radio" value="3" />
      </div></td>
      <td align="center" valign="middle" bgcolor="#FFFFEC" class="Estilo24"><div align="center">
          <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P13'],"4"))) {echo "checked=\"checked\"";} ?> name="P13" type="radio" value="4" />
      </div></td>
      <td align="center" valign="middle" bgcolor="#FFFFEC" class="Estilo24"><div align="center">
          <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P13'],"5"))) {echo "checked=\"checked\"";} ?> name="P13" type="radio" value="5" />
      </div></td>
    </tr>
    <tr height="20">
      <td height="20" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24"><strong>ATENCI&Oacute;N  AL USUARIO</strong><br />
      <p>Realizar un  servicio id&oacute;neo en el desarrollo de las  responsabilidades, satisfaciendo los requerimientos de los usuarios.</p></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P14'],"1"))) {echo "checked=\"checked\"";} ?> name="P14" type="radio" value="1" />
      </div></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P14'],"2"))) {echo "checked=\"checked\"";} ?> name="P14" type="radio" value="2" />
      </div></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P14'],"3"))) {echo "checked=\"checked\"";} ?> name="P14" type="radio" value="3" />
      </div></td>
      <td align="center" valign="middle" bgcolor="#FFFFEC" class="Estilo24"><div align="center">
          <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P14'],"4"))) {echo "checked=\"checked\"";} ?> name="P14" type="radio" value="4" />
      </div></td>
      <td align="center" valign="middle" bgcolor="#FFFFEC" class="Estilo24"><div align="center">
          <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P14'],"5"))) {echo "checked=\"checked\"";} ?> name="P14" type="radio" value="5" />
      </div></td>
    </tr>
    <tr height="20">
      <td height="20" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24"><strong>RELACIONES  INTERPERSONALES</strong><br />
      <p>Capacidad de  integraci&oacute;n, interacci&oacute;n, buen trato y respeto por los seres humanos.</p></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P15'],"1"))) {echo "checked=\"checked\"";} ?> name="P15" type="radio" value="1" />
      </div></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P15'],"2"))) {echo "checked=\"checked\"";} ?> name="P15" type="radio" value="2" />
      </div></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P15'],"3"))) {echo "checked=\"checked\"";} ?> name="P15" type="radio" value="3" />
      </div></td>
      <td align="center" valign="middle" bgcolor="#FFFFEC" class="Estilo24"><div align="center">
          <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P15'],"4"))) {echo "checked=\"checked\"";} ?> name="P15" type="radio" value="4" />
      </div></td>
      <td align="center" valign="middle" bgcolor="#FFFFEC" class="Estilo24"><div align="center">
          <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P15'],"5"))) {echo "checked=\"checked\"";} ?> name="P15" type="radio" value="5" />
      </div></td>
    </tr>
    <tr>
      <td valign="baseline" bgcolor="#FFFFEC" class="Estilo24"><strong>HABILIDADES  COMUNICATIVAS</strong><br />
        <br />
        <p>Capacidad para  establecer comunciaciones con diferentes tipos de personas y en diferentes  contextos, haciendo uso de la empat&iacute;a, la diplomacia y la asertividad. Incluye la capacidad para escuchar  activamente, asimilar informaci&oacute;n y para argumentar las  ideas usando datos que permitan llegar a acuerdos v&aacute;lidos.</p></td>
      <td height="20" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P16'],"1"))) {echo "checked=\"checked\"";} ?> name="P16" type="radio" value="1" />
      </div></td>
      <td height="20" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P16'],"2"))) {echo "checked=\"checked\"";} ?> name="P16" type="radio" value="2" />
      </div></td>
      <td height="20" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P16'],"3"))) {echo "checked=\"checked\"";} ?> name="P16" type="radio" value="3" />
      </div></td>
      <td bgcolor="#FFFFEC" class="Estilo24"><div align="center">
          <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P16'],"4"))) {echo "checked=\"checked\"";} ?> name="P16" type="radio" value="4" />
      </div></td>
      <td bgcolor="#FFFFEC" class="Estilo24"><div align="center">
          <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P16'],"5"))) {echo "checked=\"checked\"";} ?> name="P16" type="radio" value="5" />
      </div></td>
    </tr>
    <tr>
      <td height="20" colspan="6" valign="baseline" bgcolor="#8CC63F"><p align="center" class="Estilo28 Estilo45">COMPROMISO  INSTITUCIONAL</p></td>
      </tr>
    <tr>
      <td valign="baseline" bgcolor="#FFFFEC" class="Estilo24"><div align="justify"><strong>COMPROMISO  INSTITUCIONAL<br /></strong>
        <p>Asumir a partir  del comportamiento socio laboral, los valores de la Universidad, orientando los  propios intereses hacia las necesidades, prioridades y objetivos de la misma..</p>
        </div></td>
      <td height="20" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P17'],"1"))) {echo "checked=\"checked\"";} ?> name="P17" type="radio" value="1" />
      </div></td>
      <td height="20" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P17'],"2"))) {echo "checked=\"checked\"";} ?> name="P17" type="radio" value="2" />
      </div></td>
      <td height="20" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P17'],"3"))) {echo "checked=\"checked\"";} ?> name="P17" type="radio" value="3" />
      </div></td>
      <td bgcolor="#FFFFEC" class="Estilo24"><div align="center">
          <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P17'],"4"))) {echo "checked=\"checked\"";} ?> name="P17" type="radio" value="4" />
      </div></td>
      <td bgcolor="#FFFFEC" class="Estilo24"><div align="center">
          <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P17'],"5"))) {echo "checked=\"checked\"";} ?> name="P17" type="radio" value="5" />
      </div></td>
    </tr>
    <tr>
      <td valign="baseline" bgcolor="#FFFFEC" class="Estilo24"><div align="justify"><strong>SENTIDO  DE PERTENENCIA</strong><br />
        <p>Muestra  compromiso con los objetivos de la Universidad y orgullo de pertenecer a ella.</p>
      </div></td>
      <td height="20" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P18'],"1"))) {echo "checked=\"checked\"";} ?> name="P18" type="radio" value="1" />
      </div></td>
      <td height="20" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P18'],"2"))) {echo "checked=\"checked\"";} ?> name="P18" type="radio" value="2" />
      </div></td>
      <td height="20" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24"><div align="center">
        <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P18'],"3"))) {echo "checked=\"checked\"";} ?> name="P18" type="radio" value="3" />
      </div></td>
      <td bgcolor="#FFFFEC" class="Estilo24"><div align="center">
          <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P18'],"4"))) {echo "checked=\"checked\"";} ?> name="P18" type="radio" value="4" />
      </div></td>
      <td bgcolor="#FFFFEC" class="Estilo24"><div align="center">
          <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P18'],"5"))) {echo "checked=\"checked\"";} ?> name="P18" type="radio" value="5" />
      </div></td>
    </tr>
    <tr>
      <td valign="baseline" bgcolor="#FFFFEC" class="Estilo24"><div align="justify"><strong>CONCIENCIA  ORGANIZACIONAL</strong><br />
        <br />
        <p>Identificaci&oacute;n y cumplimiento de pol&iacute;ticas y normas de la Universidad.</p>
        </div></td>
      <td height="20" bgcolor="#FFFFEC" class="Estilo24"><div align="center">
          <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P19'],"1"))) {echo "checked=\"checked\"";} ?> name="P19" type="radio" value="1" />
      </div></td>
      <td height="20" bgcolor="#FFFFEC" class="Estilo24"><div align="center">
          <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P19'],"2"))) {echo "checked=\"checked\"";} ?> name="P19" type="radio" value="2" />
      </div></td>
      <td height="20" bgcolor="#FFFFEC" class="Estilo24"><div align="center">
          <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P19'],"3"))) {echo "checked=\"checked\"";} ?> name="P19" type="radio" value="3" />
      </div></td>
      <td bgcolor="#FFFFEC" class="Estilo24"><div align="center">
          <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P19'],"4"))) {echo "checked=\"checked\"";} ?> name="P19" type="radio" value="4" />
      </div></td>
      <td bgcolor="#FFFFEC" class="Estilo24"><div align="center">
          <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P19'],"5"))) {echo "checked=\"checked\"";} ?> name="P19" type="radio" value="5" />
      </div></td>
    </tr>
    <tr>
      <td valign="baseline" bgcolor="#FFFFEC" class="Estilo24"><div align="justify"><strong>RESPONSABILIDAD  POR LOS BIENES DE LA UNIVERSIDAD</strong><br />
          <br />
          Manejo y mantenimiento de los equipos, implementos  de trabajo y suministros necesarios para el desempe&ntilde;o de su labor, conservando su buen estado y preservando los bienes de la  Universidad.</div></td>
      <td height="20" bgcolor="#FFFFEC" class="Estilo24"><div align="center">
          <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P20'],"1"))) {echo "checked=\"checked\"";} ?> name="P20" type="radio" value="1" />
      </div></td>
      <td height="20" bgcolor="#FFFFEC" class="Estilo24"><div align="center">
          <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P20'],"2"))) {echo "checked=\"checked\"";} ?> name="P20" type="radio" value="2" />
      </div></td>
      <td height="20" bgcolor="#FFFFEC" class="Estilo24"><div align="center">
          <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P20'],"3"))) {echo "checked=\"checked\"";} ?> name="P20" type="radio" value="3" />
      </div></td>
      <td bgcolor="#FFFFEC" class="Estilo24"><div align="center">
          <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P20'],"4"))) {echo "checked=\"checked\"";} ?> name="P20" type="radio" value="4" />
      </div></td>
      <td bgcolor="#FFFFEC" class="Estilo24"><div align="center">
          <input <?php if (!(strcmp($row_CObtieneCamposEvaluado['P20'],"5"))) {echo "checked=\"checked\"";} ?> name="P20" type="radio" value="5" />
      </div></td>
    </tr>
    <tr>
      <td height="20" colspan="6" bordercolor="#003300" bgcolor="#FFFFEC" class="Estilo24"><div align="left"></div>        <div align="left"></div>        <div align="center"></div>        <div align="left"></div>        <div align="center"></div>        <div align="left"></div>        <div align="center"></div></td>
    </tr>
    <tr>
      <td height="20" colspan="6" bordercolor="#003300" bgcolor="#8CC63F" class="Estilo28"><div align="center" class="Estilo45">PLAN DE MEJORAMIENTO</div></td>
    </tr>
    <tr>
      <td height="20" colspan="6" bordercolor="#596221" bgcolor="#FFFFEC" class="Estilo24"><div align="center">FORTALEZAS<br />
          <textarea name="PlMeFort" cols="100" rows="4" class="Estilo24"><?php echo $row_CObtieneCamposEvaluado['PlMeFort']; ?></textarea>
      </div></td>
    </tr>
    <tr>
      <td height="20" colspan="6" bordercolor="#596221" bgcolor="#FFFFEC" class="Estilo24"><div align="center">ASPECTOS POR MEJORAR<br />
          <textarea name="PlMeAsMe" cols="100" rows="4" class="Estilo24"><?php echo $row_CObtieneCamposEvaluado['PlMeAsMe']; ?></textarea>
      </div></td>
    </tr>
    <tr>
      <td height="20" colspan="6" bordercolor="#596221" bgcolor="#FFFFEC" class="Estilo24"><div align="center">COMPROMISOS ADQUIRIDOS POR EL COLABORADOR PARA EL PLAN DE MEJORAMIENTO<br />
          <textarea name="PlMePlMe" cols="100" rows="4" class="Estilo24"><?php echo $row_CObtieneCamposEvaluado['PlMePlMe']; ?></textarea>
      </div></td>
    </tr>
    <tr>
      <td height="20" colspan="6" bordercolor="#596221" bgcolor="#FFFFEC" class="Estilo24"><div align="center">PLAZO ACORDADO PARA EL PLAN DE MEJORAMIENTO<br />
          <textarea name="PlMePlAc" cols="100" rows="4" class="Estilo24"><?php echo $row_CObtieneCamposEvaluado['PlMePlAc']; ?></textarea>
          <input name="CoGePeTf" type="hidden" class="Estilo24" value="<?php echo $row_CObtieneCamposEvaluado['CoGePeTf']; ?>"//esta oculto si el empleado sigue />
      </div></td>
    </tr>
    <tr>
      <td height="20" colspan="6" bordercolor="#596221" bgcolor="#FFFFEC" class="Estilo24"><p align="center">NECESIDADES DE CAPACITACI&Oacute;N <br />
        <textarea name="NeceCapac" cols="100" rows="4" class="Estilo24"><?php echo $row_CObtieneCamposEvaluado['NeceCapac']; ?></textarea>
          <br />
        </p>      </td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="70%" border="1" align="center">
    
    <tr>
      <td height="64" bordercolor="#596221" bgcolor="#FFFFEC" class="Estilo4">&nbsp;</td>
      <td bordercolor="#596221" bgcolor="#FFFFEC" class="Estilo4">&nbsp;</td>
      <td bordercolor="#596221" bgcolor="#FFFFEC" class="Estilo4">&nbsp;</td>
    </tr>
    <tr>
      <td width="33%" bordercolor="#596221" bgcolor="#FFFFEC" class="Estilo4"><div align="center">Jefe de Talento Humano </div></td>
      <td width="33%" bordercolor="#596221" bgcolor="#FFFFEC" class="Estilo4"><div align="center">Nombre del evaluador</div></td>
      <td width="34%" bordercolor="#596221" bgcolor="#FFFFEC" class="Estilo4"><div align="center">Nombre del evaluado </div></td>
    </tr>
    <tr>
      <td bordercolor="#596221" bgcolor="#FFFFEC" class="Estilo33"><input name="JefeTH" type="text" class="Estilo4" style="text-align:center" value="SANDRA PATRICIA SARMIENTO GARZON" size="42" /></td>
      <td bordercolor="#596221" bgcolor="#FFFFEC" class="Estilo4">
      <input name="Evaluador" type="text" class="Estilo4" style="text-align:center" value="<?php echo $row_CObtieneCamposEvaluado['JefCol']; ?>" size="42" />      </td>
      <td bordercolor="#596221" bgcolor="#FFFFEC" class="Estilo4">
      <input name="Evaluado" type="text" class="Estilo4" style="text-align:center" value="<?php echo $row_CObtieneCamposEvaluado['NombCol']; ?>" size="42" />      </td>
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

mysql_free_result($CObtieneCamposEvaluado);
?>

