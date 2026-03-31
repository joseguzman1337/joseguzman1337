<?php require_once('../../Connections/conexion.php'); ?>
<?php require_once('../../Connections/conexion.php'); error_reporting(0)?>
<?php //Unserialize 
$array = base64_decode($_GET['turtle']);
//echo $array?>
<?php date_default_timezone_set('America/Bogota');?>
<?php
ini_set("session.cookie_lifetime","7200");
ini_set("session.gc_maxlifetime","7200");

if (!isset($_SESSION)) {
  session_start();
}

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
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
}
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

$IdEval_CObtieneCamposEvaluado = "-1";
if (isset($_GET['IdEvalDes'])) {
  $IdEval_CObtieneCamposEvaluado = $_GET['IdEvalDes'];
}
mysql_select_db($database_conexion, $conexion);
$query_CObtieneCamposEvaluado = sprintf("SELECT *,  UPPER(JefCol) AS JEFCOL, UPPER(NombCol) AS NOMBCOL,  P1 AS NoP1, P2 AS NoP2, P3 AS NoP3, P4 AS NoP4, P5 AS NoP5, P6 AS NoP6,  IF(P1 BETWEEN 0 AND 44,'INSATISFACTORIO', IF(P1 BETWEEN 45 AND 59,'MINIMO NECESARIO', IF(P1 BETWEEN 60 AND 84,'BUENO -  POR ENCIMA DEL ESTANDAR', IF(P1 BETWEEN 85 AND 95,'ALTO', IF(P1 BETWEEN 96 AND 100,'EXCELENTE', 'No calificada o mal calificada'))))) AS RESP1, IF(P2 BETWEEN 0 AND 44,'INSATISFACTORIO', IF(P2 BETWEEN 45 AND 59,'MINIMO NECESARIO', IF(P2 BETWEEN 60 AND 84,'BUENO -  POR ENCIMA DEL ESTANDAR', IF(P2 BETWEEN 85 AND 95,'ALTO', IF(P2 BETWEEN 96 AND 100,'EXCELENTE', 'No calificada o mal calificada'))))) AS RESP2, IF(P3 BETWEEN 0 AND 44,'INSATISFACTORIO', IF(P3 BETWEEN 45 AND 59,'MINIMO NECESARIO', IF(P3 BETWEEN 60 AND 84,'BUENO -  POR ENCIMA DEL ESTANDAR', IF(P3 BETWEEN 85 AND 95,'ALTO', IF(P3 BETWEEN 96 AND 100,'EXCELENTE', 'No calificada o mal calificada'))))) AS RESP3, IF(P4 BETWEEN 0 AND 44,'INSATISFACTORIO', IF(P4 BETWEEN 45 AND 59,'MINIMO NECESARIO', IF(P4 BETWEEN 60 AND 84,'BUENO -  POR ENCIMA DEL ESTANDAR', IF(P4 BETWEEN 85 AND 95,'ALTO', IF(P4 BETWEEN 96 AND 100,'EXCELENTE', 'No calificada o mal calificada'))))) AS RESP4, IF(P5 BETWEEN 0 AND 44,'INSATISFACTORIO', IF(P5 BETWEEN 45 AND 59,'MINIMO NECESARIO', IF(P5 BETWEEN 60 AND 84,'BUENO -  POR ENCIMA DEL ESTANDAR', IF(P5 BETWEEN 85 AND 95,'ALTO', IF(P5 BETWEEN 96 AND 100,'EXCELENTE', 'No calificada o mal calificada'))))) AS RESP5, IF(P6 BETWEEN 0 AND 44,'INSATISFACTORIO', IF(P6 BETWEEN 45 AND 59,'MINIMO NECESARIO', IF(P6 BETWEEN 60 AND 84,'BUENO -  POR ENCIMA DEL ESTANDAR', IF(P6 BETWEEN 85 AND 95,'ALTO', IF(P6 BETWEEN 96 AND 100,'EXCELENTE', 'No calificada o mal calificada'))))) AS RESP6, ROUND(((P1+P2+P3+P4+P5+P6)/6),1)AS TOTAL, IF(FORMAT((P1+P2+P3+P4+P5+P6),1)/6 BETWEEN 0 AND 44,'INSATISFACTORIO', IF(FORMAT((P1+P2+P3+P4+P5+P6),1)/6 BETWEEN 45 AND 59,'MINIMO NECESARIO', IF(FORMAT((P1+P2+P3+P4+P5+P6),1)/6 BETWEEN 60 AND 84,'BUENO -  POR ENCIMA DEL ESTANDAR', IF(FORMAT((P1+P2+P3+P4+P5+P6),1)/6 BETWEEN 85 AND 95,'ALTO', IF(FORMAT((P1+P2+P3+P4+P5+P6),1)/6 BETWEEN 96 AND 100,'EXCELENTE', 'Falta calificar alguna habilidad'))))) AS RESPTOTAL FROM nuevo_tevaldes_todo_nivel WHERE IdEvalDes=%s", GetSQLValueString($IdEval_CObtieneCamposEvaluado, "int"));
$CObtieneCamposEvaluado = mysql_query($query_CObtieneCamposEvaluado, $conexion) or die(mysql_error());
$row_CObtieneCamposEvaluado = mysql_fetch_assoc($CObtieneCamposEvaluado);
$totalRows_CObtieneCamposEvaluado = mysql_num_rows($CObtieneCamposEvaluado);
//var_dump($query_CObtieneCamposEvaluado);

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE nuevo_tevaldes_todo_nivel SET NombCol=%s, JefCol=%s, FechEval=%s, FechaHora=%s, Periodo=%s, IdColab=%s, CCJefeCol=%s, CargoCol=%s, CargoJefe=%s, DeptoCol=%s, RangoCol=%s, ObjetivoDelCargo=%s, ColabFunciona=%s, ColabFuncionaSentim=%s, JefeFunciona=%s, JefeFuncionaSentim=%s, ColabNoFunciona=%s, ColabNoFuncionaSentim=%s, JefeNoFunciona=%s, JefeNOFuncionaSentim=%s, ColabPandemia=%s, ColabPandemiaSentim=%s, JefePandemia=%s, JefePandemiaSentim=%s, P1=%s, P1OBS=%s, P2=%s, P2OBS=%s, P3=%s, P3OBS=%s, P4=%s, P4OBS=%s, P5=%s, P5OBS=%s, P6=%s, P6OBS=%s, MejoraObjetivos=%s, MejoraResultados=%s, MejoraAcciones=%s, PlanPersonalObjet=%s, PlanPersonalAcciones=%s, ColabNecFortResLab=%s, JefeNecFortResLab=%s, ColabComenzarHacer=%s, JefeComenzarHacer=%s, ColabContinuarHacer=%s, JefeContinuarHacer=%s, ColabDejarDeHacer=%s, JefeDejarDeHacer=%s, ColabQueTeLLevas=%s, JefeQueTeLLevas=%s, Evaluador=%s, FirmaEvaluador=%s, Evaluado=%s, FirmaEvaluado=%s, JefeTH=%s WHERE IdEvalDes=%s",
                       GetSQLValueString($_POST['NombCol'], "text"),
                       GetSQLValueString($_POST['JefCol'], "text"),
                       GetSQLValueString($_POST['FechEval'], "date"),
                       GetSQLValueString($_POST['FechaHora'], "date"),
                       GetSQLValueString($_POST['Periodo'], "text"),
                       GetSQLValueString($_POST['IdColab'], "int"),
                       GetSQLValueString($_POST['CCJefeCol'], "int"),
                       GetSQLValueString($_POST['CargoCol'], "text"),
                       GetSQLValueString($_POST['CargoJefe'], "text"),
                       GetSQLValueString($_POST['DeptoCol'], "text"),
                       GetSQLValueString($_POST['RangoCol'], "text"),
                       GetSQLValueString($_POST['ObjetivoDelCargo'], "text"),
                       GetSQLValueString($_POST['ColabFunciona'], "text"),
                       GetSQLValueString($_POST['ColabFuncionaSentim'], "text"),
                       GetSQLValueString($_POST['JefeFunciona'], "text"),
                       GetSQLValueString($_POST['JefeFuncionaSentim'], "text"),
                       GetSQLValueString($_POST['ColabNoFunciona'], "text"),
                       GetSQLValueString($_POST['ColabNoFuncionaSentim'], "text"),
                       GetSQLValueString($_POST['JefeNoFunciona'], "text"),
                       GetSQLValueString($_POST['JefeNOFuncionaSentim'], "text"),
                       GetSQLValueString($_POST['ColabPandemia'], "text"),
                       GetSQLValueString($_POST['ColabPandemiaSentim'], "text"),
                       GetSQLValueString($_POST['JefePandemia'], "text"),
                       GetSQLValueString($_POST['JefePandemiaSentim'], "text"),
                       GetSQLValueString($_POST['P1'], "int"),
                       GetSQLValueString($_POST['P1OBS'], "text"),
                       GetSQLValueString($_POST['P2'], "int"),
                       GetSQLValueString($_POST['P2OBS'], "text"),
                       GetSQLValueString($_POST['P3'], "int"),
                       GetSQLValueString($_POST['P3OBS'], "text"),
                       GetSQLValueString($_POST['P4'], "int"),
                       GetSQLValueString($_POST['P4OBS'], "text"),
                       GetSQLValueString($_POST['P5'], "int"),
                       GetSQLValueString($_POST['P5OBS'], "text"),
                       GetSQLValueString($_POST['P6'], "int"),
                       GetSQLValueString($_POST['P6OBS'], "text"),
                       GetSQLValueString($_POST['MejoraObjetivos'], "text"),
                       GetSQLValueString($_POST['MejoraResultados'], "text"),
                       GetSQLValueString($_POST['MejoraAcciones'], "text"),
                       GetSQLValueString($_POST['PlanPersonalObjet'], "text"),
                       GetSQLValueString($_POST['PlanPersonalAcciones'], "text"),
                       GetSQLValueString($_POST['ColabNecFortResLab'], "text"),
                       GetSQLValueString($_POST['JefeNecFortResLab'], "text"),
                       GetSQLValueString($_POST['ColabComenzarHacer'], "text"),
                       GetSQLValueString($_POST['JefeComenzarHacer'], "text"),
                       GetSQLValueString($_POST['ColabContinuarHacer'], "text"),
                       GetSQLValueString($_POST['JefeContinuarHacer'], "text"),
                       GetSQLValueString($_POST['ColabDejarDeHacer'], "text"),
                       GetSQLValueString($_POST['JefeDejarDeHacer'], "text"),
                       GetSQLValueString($_POST['ColabQueTeLLevas'], "text"),
                       GetSQLValueString($_POST['JefeQueTeLLevas'], "text"),
                       GetSQLValueString($_POST['Evaluador'], "text"),
                       GetSQLValueString($_POST['FirmaEvaluador'], "text"),
                       GetSQLValueString($_POST['Evaluado'], "text"),
                       GetSQLValueString($_POST['FirmaEvaluado'], "text"),
                       GetSQLValueString($_POST['JefeTH'], "text"),
                       GetSQLValueString($_POST['IdEvalDes'], "int"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($updateSQL, $conexion) or die(mysql_error());

	  
  $insertGoTo = "Nuevo_EvalDes_VerActualizar_TODO_NIVEL.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
	$insertGoTo .= "#Secciones";
  header(sprintf("Location: %s", $insertGoTo));
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Evaluación Desempe&ntilde;o</title>
<script type="text/JavaScript">
<!--
function MM_popupMsg(msg) { //v1.0
  alert(msg);
}
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script>
<link href="../../ESTILSOGC.css" rel="stylesheet" type="text/css" />

<style type="text/css" media="print">
.noimprimir {
	display:none;
}
</style>


</head>

<body>
<div align="center">
  <table width="838" border="0">
    <tr>
      <td width="155" height="72" bgcolor="#7BC142"><div align="center" class="Estilo22"><img src="../../IMAGENES/BOSQUEDPTOTH2.png" alt="as" width="250" height="97" /></div></td>
      <td width="673" bgcolor="#7BC142"><div align="center" class="Estilo22">EVALUACI&Oacute;N PARA EL DESARROLLO<br />
      COLABORADORES A T&Eacute;RMINO FIJO E INDEFINIDO </div></td>
    </tr>
  </table>
  <table width="838" border="0">
    <tr>
      <td width="832" bgcolor="#8CC63F"><div align="center" class="Estilo22">DEPARTAMENTO DE TALENTO HUMANO - CONSTRUYENDO UN MEJOR EQUIPO </div></td>
    </tr>
  </table>
  <br />
    <label></label>
  <label></label>
  <label></label>
  <label></label>
</div>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <div align="right">
    <table border="1" align="center" style="border-collapse:collapse">
      <tr valign="baseline">
        <td align="right" nowrap="nowrap" bgcolor="#FFFFFF" class="Estilo28"><span class="Estilo33">
          <input name="Periodo" type="hidden" id="Periodo" value="<?php echo $row_CObtieneCamposEvaluado['Periodo']; ?>" />
          <input name="NombCol" type="hidden" id="NombCol" value="<?php echo $row_CObtieneCamposEvaluado['NombCol']; ?>" />
          Colaborador Evaluado:&nbsp;
          <label for="textfield"></label>
        </span></td>
        <td colspan="2" align="right" nowrap="nowrap" bgcolor="#FFFFFF" class="Estilo28"><div align="left"><span class="Estilo33"><?php echo $row_CObtieneCamposEvaluado['NOMBCOL']; ?></span></div></td>
      </tr>
      <tr valign="baseline">
        <td align="right" valign="bottom" nowrap="nowrap" bgcolor="#FFFFFF" class="Estilo28"><span class="Estilo33">
          <input name="CCJefeCol" type="hidden" id="CCJefeCol" value="<?php echo $row_CObtieneCamposEvaluado['CCJefeCol']; ?>" />
          <input name="IdColab" type="hidden" id="IdColab" value="<?php echo $row_CObtieneCamposEvaluado['IdColab']; ?>" />
        C&eacute;dula:&nbsp;</span></td>
        <td colspan="2" align="right" valign="bottom" bgcolor="#FFFFFF" class="Estilo28"><div align="left"><span class="Estilo33"><?php echo $row_CObtieneCamposEvaluado['IdColab']; ?></span></div></td>
      </tr>
      <tr valign="baseline">
        <td align="right" valign="bottom" nowrap="nowrap" bgcolor="#FFFFFF" class="Estilo28"><span class="Estilo33">
<input name="FechaHora" type="hidden" id="FechaHora" value="<?php echo $row_CObtieneCamposEvaluado['FechaHora']; ?>" />
<input name="CargoCol" type="hidden" id="CargoCol" value="<?php echo $row_CObtieneCamposEvaluado['CargoCol']; ?>" />
Cargo</span></td>
        <td colspan="2" align="right" valign="bottom" bgcolor="#FFFFFF" class="Estilo4"><div align="left" class="Estilo28"><span class="Estilo33"><?php echo $row_CObtieneCamposEvaluado['CargoCol']; ?></span></div></td>
      </tr>
      <tr valign="baseline">
        <td align="right" valign="bottom" nowrap="nowrap" bgcolor="#FFFFFF" class="Estilo28"><span class="Estilo33">
<input name="JefCol" type="hidden" id="JefCol" value="<?php echo $row_CObtieneCamposEvaluado['JefCol']; ?>" />
Evaluador:&nbsp;</span></td>
        <td colspan="2" align="right" valign="bottom" bgcolor="#FFFFFF" class="Estilo28"><div align="center" class="Estilo28">
          <div align="left"><span class="Estilo33"><?php echo $row_CObtieneCamposEvaluado['JEFCOL']; ?></span></div>
        </div>
          <div align="left"></div></td>
      </tr>
      <tr valign="baseline" class="Estilo28">
        <td align="right" valign="bottom" nowrap="nowrap" bgcolor="#FFFFFF" class="Estilo28"><span class="Estilo33">
<input name="CargoJefe" type="hidden" id="CargoJefe" value="<?php echo $row_CObtieneCamposEvaluado['CargoJefe']; ?>" />
Cargo Evaluador:</span></td>
        <td colspan="2" align="right" valign="bottom" nowrap="nowrap" bgcolor="#FFFFFF" class="Estilo4"><div align="left" class="Estilo28"><span class="Estilo33"><?php echo $row_CObtieneCamposEvaluado['CargoJefe']; ?></span></div></td>
      </tr>
      <tr valign="baseline">
        <td align="right" valign="bottom" nowrap="nowrap" bgcolor="#FFFFFF" class="Estilo28"><span class="Estilo33">
<input name="FechEval" type="hidden" id="FechEval" value="<?php echo $row_CObtieneCamposEvaluado['FechEval']; ?>" />
<input name="RangoCol" type="hidden" id="RangoCol" value="<?php echo $row_CObtieneCamposEvaluado['RangoCol']; ?>" />
Fecha evaluaci&oacute;n:&nbsp; </span></td>
        <td colspan="2" align="right" valign="bottom" nowrap="nowrap" bgcolor="#FFFFFF" class="Estilo28"><div align="left"><span class="Estilo33"><?php echo $row_CObtieneCamposEvaluado['FechEval']; ?><br />
        </span></div></td>
      </tr>
    </table>
    <p>&nbsp;</p>
    <table width="754" border="1" align="center" style="border-collapse:collapse">
      <tr valign="baseline" class="noimprimir">
        <td colspan="2" align="right" valign="bottom" nowrap="nowrap" bgcolor="#FFFFFF" class="Estilo4"><p align="center" class="Estilo39mediano"><br />
          Estimado jefe, por favor lea atentamente las instrucciones</p>
          <p align="center" class="Estilo39"><u><a name="Secciones" id="Secciones"></a>Tenga en cuenta que el tiempo de actividad de la p&aacute;gina tiene un l&iacute;mite de 30 minutos. </u></p>
          <p align="center" class="Estilo4"><u>Para extenderlo debe guardar peri&oacute;dicamente y guardar cada secci&oacute;n al terminarla</u>.</p>
          <p align="center" class="Estilo39">Antes de diligenciar la evaluaci&oacute;n, por favor vea el siguiente video</p>
          <p align="center" class="Estilo39"><a href="https://drive.google.com/file/d/1Qgx9DXlFcYe42DZV86uYbrPbtMdjkMwu/view" target="new"><img src="CAMARA.jpg" width="70" height="70" /></a></p>
          <p align="center" class="Estilo4">&nbsp;</p>
          <p align="center" class="Estilo39">La evaluaci&oacute;n consta de 4 secciones&nbsp;a las que puede desplazarse presionando <span class="Estilo42">Ir</span></p>
          <table width="263" border="1" align="center" cellpadding="1" cellspacing="1" class="Estilo39" style="border-collapse:collapse">
            <tr>
              <th height="30" colspan="4" scope="col">SECCIONES</th>
            </tr>
            <tr>
              <th width="21" scope="col">1-</th>
              <td width="193" height="30" colspan="2" scope="col"><div align="left" class="Estilo33"> MIRANDO</div></td>
              <th width="26" scope="col"><div align="center"><a href="#Mira">Ir</a></div></th>
            </tr>
            <tr>
              <th scope="col">2-</th>
              <th height="30" colspan="2" scope="col"><div align="left" class="Estilo33"> DESCUBRIENDO</div></th>
              <th nowrap="nowrap" scope="col"><div align="center"><a href="#Desc">Ir</a></div></th>
            </tr>
            <tr>
              <th valign="middle" scope="col"> 3-</th>
              <th height="30" colspan="2" scope="col"><div align="left" class="Estilo33">NUESTRO FUTURO</div></th>
              <th scope="col"><div align="center"><a href="#Futur">Ir</a></div></th>
            </tr>
            <tr>
              <th scope="col"> 4-</th>
              <th height="30" colspan="2" scope="col"><div align="left" class="Estilo33">MI RUTA</div></th>
              <th scope="col"><div align="center"><a href="#Ruta">Ir</a></div></th>
            </tr>
            <tr>
              <th height="30" colspan="4" nowrap="nowrap" scope="col"><div align="center"><span class="Estilo40">Al terminar de evaluar guarde como PDF: </span></div>
                <span class="Estilo40">
                  <label></label>
                </span>
                <div align="center"><span class="Estilo40"><img src="GUARDAR.jpg" width="49" height="49" onclick="window.print()"/></span></div>
              </th>
            </tr>
            <tr>
              <th height="30" colspan="4" nowrap="nowrap" scope="col">Evaluar a otro colaborador<br />
                <img src="TRABAJADOR.jpg" width="55" height="55" onclick="MM_goToURL('parent','NuevoCListadoEvaluados.php?turtle=<?php echo $_GET['turtle']; ?>');return document.MM_returnValue" /><br /></th>
            </tr>
            <tr>
              <th height="30" colspan="4" scope="col">Ver colaboradores  evaluados<br />
                <img src="EVALUADOS.jpg" alt="" width="49" height="49" onclick="MM_goToURL('parent','NuevoCListadoYAEvaluados.php?turtle=<?php echo $_GET['turtle']; ?>');return document.MM_returnValue" /><br /></th>
            </tr>
          </table>
          <p>&nbsp;</p>
          <p align="center" class="Estilo4"><span class="Estilo42 Estilo44">Muchas Gracias por su amable colaboraci&oacute;n </span></p>
          <p align="center" class="EstiloIrPrincipio">&nbsp;</p></td>
      </tr>
      <tr valign="baseline">
        <td colspan="2" align="right" valign="bottom" bgcolor="#E3F2D0" class="Estilo39"><div align="center" class="Estilo39mediano"><a name="Mira" id="Mira"></a><br />
          &nbsp; 1 - MIRANDO<br />
          <a href="#Secciones" class="EstiloIrPrincipio">Volver al inicio</a><br />
        </div></td>
      </tr>
      <tr valign="baseline">
        <td width="80" align="right" valign="bottom" nowrap="nowrap" bgcolor="#E9F3DA" class="Estilo26"><div align="left" class="Estilo24"><span class="Estilo39">
          <input name="Periodo2" type="hidden" class="Campos" id="Periodo" value="<?php echo $row_CObtieneCamposEvaluado['Periodo']; ?>"/>
          <label for="textfield3"></label>
          <input name="CargoCol2" type="hidden" id="CargoCol" value="<?php echo $row_Colaboradores['CarCol']; ?>" />
          <input name="CargoJefe2" type="hidden" id="CargoJefe" value="<?php echo $row_Colaboradores['CargoJefeCol']; ?>" />
        </span></div>
          <span class="Estilo39">
            <input name="DeptoCol" type="hidden" id="DeptoCol" value="<?php echo $row_Colaboradores['DepCol']; ?>" />
            <input name="RangoCol2" type="hidden" id="RangoCol" value="<?php echo $row_Colaboradores['RangoCol']; ?>" />
          </span></td>
        <td align="right" valign="bottom" nowrap="nowrap" bgcolor="#E9F3DA" class="Estilo24"><div align="center" class="Estilo39">COLABORADOR
          <input name="ObjetivoDelCargo" type="hidden" class="Estilo26" id="ObjetivoDelCargo" value="<?php echo $row_CObtieneCamposEvaluado['ObjetivoDelCargo']; ?>" size="100" //campo &iquest;cu&aacute;l es="es" el="el" objetivo="objetivo" del="del" cargo?:="cargo?:"  />
        </div></td>
      </tr>
      <tr valign="baseline">
        <td valign="middle" nowrap="nowrap" class="Estilo39"><div align="left" class="Estilo24">En este a&ntilde;o: &iquest;Qu&eacute; ha facilitado su desempe&ntilde;o?</div></td>
        <td align="right" valign="bottom" nowrap="nowrap" bgcolor="#FFFFFF" class="Estilo4"><div align="left">
          <textarea name="ColabFunciona" cols="100" rows="5" class="Estilo26" id="ColabFunciona" ><?php echo $row_CObtieneCamposEvaluado['ColabFunciona']; ?></textarea>
          <input name="JefeFunciona" type="hidden" class="Estilo26" id="JefeFunciona" value="<?php echo $row_CObtieneCamposEvaluado['JefeFunciona']; ?>" size="50" //campo para="para" el="el" jefe="jefe" />
        </div></td>
      </tr>
      <tr valign="baseline">
        <td valign="middle" nowrap="nowrap" class="Estilo39"><div align="left" class="Estilo24">En este a&ntilde;o: &iquest;Qu&eacute; ha afectado su desempe&ntilde;o?</div></td>
        <td align="right" valign="bottom" nowrap="nowrap" bgcolor="#FFFFFF" class="Estilo4"><div align="left">
          <textarea name="ColabFuncionaSentim" cols="100" rows="5" class="Estilo26" id="ColabFuncionaSentim"><?php echo $row_CObtieneCamposEvaluado['ColabFuncionaSentim']; ?></textarea>
          <input name="JefeFuncionaSentim" type="hidden" class="Estilo26" id="JefeFuncionaSentim" value="<?php echo $row_CObtieneCamposEvaluado['JefeFuncionaSentim']; ?>" size="50" />
          <input name="ColabNoFunciona" type="hidden" class="Estilo26" id="ColabNoFunciona" value="<?php echo $row_CObtieneCamposEvaluado['ColabNoFunciona']; ?>" size="50" //funcionario - hasta="hasta" el="el" momento="momento" &iquest;qu&eacute; no="no" est&aacute;="est&aacute;" funcionando="funcionando" en="en" su="su" trabajo?="trabajo?"/>
          <input name="JefeNoFunciona" type="hidden" class="Estilo26" id="JefeNoFunciona" value="<?php echo $row_CObtieneCamposEvaluado['JefeNoFunciona']; ?>" size="50" //jefe - hasta="hasta" el="el" momento="momento" &iquest;qu&eacute; no="no" est&aacute;="est&aacute;" funcionando="funcionando" en="en" su="su" trabajo?="trabajo?" />
          <input name="ColabNoFuncionaSentim" type="hidden" class="Estilo26" id="ColabNoFuncionaSentim" value="<?php echo $row_CObtieneCamposEvaluado['ColabNoFuncionaSentim']; ?>" size="50" //funcionario - &iquest;cu&aacute;les son="son" tus="tus" sentimientos="sentimientos" con="con" lo="lo" que="que" no="no" est&aacute;="est&aacute;" funcionando?="funcionando?" />
          <input name="JefeNOFuncionaSentim" type="hidden" class="Estilo26" id="JefeNOFuncionaSentim" value="<?php echo $row_CObtieneCamposEvaluado['JefeNOFuncionaSentim']; ?>" size="50" //jefe - &iquest;cu&aacute;les son="son" tus="tus" sentimientos="sentimientos" con="con" lo="lo" que="que" no="no" est&aacute;="est&aacute;" funcionando?="funcionando?" />
        </div></td>
      </tr>
      <tr valign="baseline">
        <td valign="middle" nowrap="nowrap" class="Estilo39"><div align="left" class="Estilo24"><strong>&iquest;C&oacute;mo ha sido    el trabajo en pandemia?</strong></div></td>
        <td align="right" valign="bottom" nowrap="nowrap" bgcolor="#FFFFFF" class="Estilo4"><div align="left">
          <textarea name="ColabPandemia" cols="100" rows="5" class="Estilo26" id="ColabPandemia" ><?php echo $row_CObtieneCamposEvaluado['ColabPandemia']; ?></textarea>
          <input name="JefePandemia" type="hidden" class="Estilo26" id="JefePandemia" value="<?php echo $row_CObtieneCamposEvaluado['JefePandemia']; ?>" size="50" />
          <br />
          <input name="ColabPandemiaSentim" type="hidden" class="Estilo26" id="ColabPandemiaSentim" value="<?php echo $row_CObtieneCamposEvaluado['ColabPandemiaSentim']; ?>" size="50" // funcionario -  &iquest;cu&aacute;les son="son" tus="tus" sentimientos="sentimientos" durante="durante" pandemia?="pandemia?"/>
          <input name="JefePandemiaSentim" type="hidden" class="Estilo26" id="JefePandemiaSentim" value="<?php echo $row_CObtieneCamposEvaluado['JefePandemiaSentim']; ?>" size="50" jefe="jefe" -  &iquest;cu&aacute;les son="son" tus="tus" sentimientos="sentimientos" durante="durante" pandemia?="pandemia?" />
        </div></td>
      </tr>
      <tr valign="baseline" class="noimprimir">
        <td colspan="2" align="right" valign="bottom" nowrap="nowrap" bgcolor="#FFFFFF" class="Estilo4"><span class="Estilo26"><span class="Estilo40">
          <input name="submit2" type="submit" class="Estilo4" onclick="MM_popupMsg('Estimado jefe:\r\rLa informaci&oacute;n se ha guardado correctamente. \r\rPuede continuar con otra secci&oacute;n o si desea realizar otra evaluaci&oacute;n, presione el bot&oacute;n EVALUAR A OTRO COLABORADOR al principio o al final de esta p&aacute;gina.\r\rDe lo contrario, simplemente salga de la p&aacute;gina.\r\rMuchas gracias por su colaboraci&oacute;n para construir un mejor equipo.\r\rDirecci&oacute;n de Talento Humano')" value="GUARDAR" />
          <br />
          <br />
          <a href="#Secciones" class="EstiloIrPrincipio">Volver al inicio</a><br />
        </span></span></td>
      </tr>
    </table>
    <p><br />
  </p>
    <div align="center"><br />
      <br />
    </div>
  </div>
  <table width="100%" border="1" align="center" bordercolor="#003300" bgcolor="#FFFFFF" style="border-collapse:collapse">
    <tr height="20">
      <td colspan="8" bordercolor="#003300" bgcolor="#EAF2F2" class="Estilo28"><div align="center"><span class="Estilo39mediano"><a name="Desc" id="Desc"></a><br />
        2 - DESCUBRIENDO</span><br />
        <span class="Estilo39mediano"><span class="Estilo4"><span class="Estilo26"><span class="Estilo40"><a href="#Secciones" class="EstiloIrPrincipio"></a></span></span></span></span><br />
      </div></td>
    </tr class="noimprimir">
    <tr height="20">
      <td colspan="8" bordercolor="#003300" bgcolor="#FFFFFF" class="Estilo28"><p align="center"><strong>En seguida encontrar&aacute; una serie de habilidades. Por favor aseg&uacute;rese de calificarlas todas para que el sistema pueda realizar las validaciones correspondientes. Los resultados los puede observar al final de esta tabla luego de guardar. </strong></p>
        <p align="center"><strong>Escala de  valoraci&oacute;n: </strong></p>
        <p align="center" class="Estilo39"><strong>Insatisfactorio (0-44) - 2. M&iacute;nimo necesario (45-59) - 3. Bueno (60-84)- 4 Alto (85-95) - 5 Excelente (96-100)</strong></p></td>
    </tr>
    <tr height="20">
      <td colspan="8" bordercolor="#003300" bgcolor="#EAF2F2" class="Estilo4"><div align="center" class="Estilo25 Estilo26">
        <input name="NombCol" type="hidden" class="Estilo33" style="text-align:center" value="<?php echo $row_CObtieneCamposEvaluado['NombCol']; ?>" size="60" />
        <input name="JefCol" type="hidden" class="Estilo4" style="text-align:center" value="<?php echo $row_CObtieneCamposEvaluado['JefCol']; ?>" size="60" />
        <span class="Estilo45">
          <input name="FechEval" type="hidden" class="Estilo4" style="text-align:center"  value="<?php echo $row_CObtieneCamposEvaluado['FechEval']; ?>" size="32" />
          <span class="Estilo46"><br />
            <a name="HG" id="HG"></a><br />
            </span></span><span class="Estilo39mediano">HABILIDADES</span><br />
        <a href="#Secciones" class="EstiloIrPrincipio"></a></div></td>
    </tr>
    <tr height="20">
      <td width="46%" height="20" colspan="2" bordercolor="#003300" bgcolor="#FFFFFF" class="Estilo24">&nbsp;</td>
      <td width="80" class="Estilo40"><div align="center">Insatisfactorio</div></td>
      <td width="80" class="Estilo40"><div align="center">M&iacute;nimo <br />
        necesario</div></td>
      <td width="80" class="Estilo40"><div align="center">Bueno, <br />
        por encima <br />
        del estandar</div></td>
      <td width="80" class="Estilo40"><div align="center">Alto</div></td>
      <td width="80" class="Estilo40"><div align="center">Excelente</div></td>
      <td width="21%" align="center" valign="middle" bgcolor="#FFFFFF" class="Estilo24"><div align="center">Observaciones</div></td>
    </tr>
    <tr height="20">
      <td height="20" colspan="2" bordercolor="#003300" bgcolor="#FFFFFF" class="Estilo24">&nbsp;</td>
      <td width="80" nowrap="nowrap" class="Estilo40"><div align="center">0-44</div></td>
      <td width="80" nowrap="nowrap" class="Estilo40"><div align="center">45-59</div></td>
      <td width="80" nowrap="nowrap" class="Estilo40"><div align="center">60-84</div></td>
      <td width="80" nowrap="nowrap" class="Estilo40"><div align="center">85-95</div></td>
      <td nowrap="nowrap" class="Estilo40"><div align="center">96-100</div></td>
      <td align="center" valign="middle" bgcolor="#FFFFFF" class="Estilo24">&nbsp;</td>
    </tr>
    <tr height="20">
      <td height="20" colspan="2" bordercolor="#003300" bgcolor="#FFFFFF" class="Estilo24">&nbsp;</td>
      <td colspan="5" class="Estilo40"><div align="center" class="Estilo39">Escriba el valor que usted considere para cada competencia</div></td>
      <td align="center" valign="middle" bgcolor="#FFFFFF" class="Estilo24">&nbsp;</td>
    </tr>
    <tr height="20">
      <td width="285" class="Estilo24">Adaptabilidad    al grupo de trabajo y otras &aacute;reas</td>
      <td width="400" class="Estilo24">Se relaciona de forma adecuada    con el grupo de trabajo. (Jefe, si tiene colaboradores a cargo y otros    trabajadores del &aacute;rea) y otras &aacute;reas</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFFF" class="Estilo24"><label for="textfield2"></label>
        <div align="center">
          <input name="P1" type="text" class="Estilo39mediano" id="P1" style="text-align:center" value="<?php echo $row_CObtieneCamposEvaluado['P1']; ?>" autocomplete="off" size="5" />
        </div></td>
      <td align="center" valign="middle" bgcolor="#FFFFFF" class="Estilo24"><label for="textfield"></label>
        <div align="center">
          <textarea name="P1OBS" cols="40" rows="3" class="Estilo26" id="P1OBS"><?php echo $row_CObtieneCamposEvaluado['P1OBS']; ?></textarea>
        </div></td>
    </tr>
    <tr height="20">
      <td width="285" class="Estilo24">Calidad    en el trabajo</td>
      <td width="400" class="Estilo24">Posee amplios conocimientos para    el desempe&ntilde;o de las funciones. Tiene la capacidad de comprender de forma    sist&eacute;mica los aspectos complejos de sus responsabilidades de cargo y    ejecutarlos de manera adecuada.</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFFF" class="Estilo24"><div align="center">
        <input name="P2" type="text" class="Estilo39mediano" id="P2" style="text-align:center" value="<?php echo $row_CObtieneCamposEvaluado['P2']; ?>" autocomplete="off" size="5" />
      </div></td>
      <td align="center" valign="middle" bgcolor="#FFFFFF" class="Estilo24"><div align="center">
        <textarea name="P2OBS" cols="40" rows="3" class="Estilo26"  id="P2OBS"><?php echo $row_CObtieneCamposEvaluado['P2OBS']; ?></textarea>
      </div></td>
    </tr>
    <tr height="20">
      <td width="285" class="Estilo24">Compromiso    organizacional</td>
      <td width="400" class="Estilo24">Es flexible, logra prevenir y    superar obst&aacute;culos que interfieren con la consecuci&oacute;n de los mismos.       De igual forma evita generar reprocesos (errores) dentro de sus funciones.</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFFF" class="Estilo24"><div align="center">
        <input name="P3" type="text" class="Estilo39mediano" id="P3" style="text-align:center" value="<?php echo $row_CObtieneCamposEvaluado['P3']; ?>" autocomplete="off" size="5" />
      </div></td>
      <td align="center" valign="middle" bgcolor="#FFFFFF" class="Estilo24"><div align="center">
        <textarea name="P3OBS" cols="40" rows="3" class="Estilo26"  id="P3OBS"><?php echo $row_CObtieneCamposEvaluado['P3OBS']; ?></textarea>
      </div></td>
    </tr>
    <tr height="20">
      <td width="285" class="Estilo24">Empoderamiento    de cargo</td>
      <td width="400" class="Estilo24">Cumplir con los compromisos    pactados de forma oportuna.</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFFF" class="Estilo24"><div align="center">
        <input name="P4" type="text" class="Estilo39mediano" id="P4" style="text-align:center" value="<?php echo $row_CObtieneCamposEvaluado['P4']; ?>" autocomplete="off" size="5" />
      </div></td>
      <td align="center" valign="middle" bgcolor="#FFFFFF" class="Estilo24"><div align="center">
        <textarea name="P4OBS" cols="40" rows="3" class="Estilo26"  id="P4OBS"><?php echo $row_CObtieneCamposEvaluado['P4OBS']; ?></textarea>
      </div></td>
    </tr>
    <tr height="20">
      <td width="285" class="Estilo24">Proactividad    e innovaci&oacute;n</td>
      <td width="400" class="Estilo24">Habilidad para tomar la    iniciativa y emprender acciones, responsabiliz&aacute;ndose de la soluci&oacute;n a los    problemas que se presentan y anticip&aacute;ndose a los dem&aacute;s. Implica dialogar,    actuar, resolver o tomar decisiones sin necesidad de recibir directrices.</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFFF" class="Estilo24"><div align="center">
        <input name="P5" type="text" class="Estilo39mediano" id="P5" style="text-align:center" value="<?php echo $row_CObtieneCamposEvaluado['P5']; ?>" autocomplete="off" size="5" />
      </div></td>
      <td align="center" valign="middle" bgcolor="#FFFFFF" class="Estilo24"><div align="center">
        <textarea name="P5OBS" cols="40" rows="3" class="Estilo26"  id="P5OBS"><?php echo $row_CObtieneCamposEvaluado['P5OBS']; ?></textarea>
      </div></td>
    </tr>
    <tr height="20">
      <td width="285" class="Estilo24">Liderazgo</td>
      <td width="400" class="Estilo24">Habilidad para orientar e    influir en otra u otras personas a trav&eacute;s de una interacci&oacute;n directa con el    fin de alcanzar unos objetivos determinados. ---Capacidad para generar    compromiso y lograr el respaldo de sus superiores con vistas a enfrentar con    &eacute;xito los desaf&iacute;os de la organizaci&oacute;n. Capacidad para asegurar una adecuada    conducci&oacute;n de personas, desarrollar el talento, y lograr y mantener un clima    organizacional arm&oacute;nico y desafiante</td>
      <td colspan="5" align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFFF" class="Estilo24"><div align="center">
        <input name="P6" type="text" class="Estilo39mediano" id="P6" style="text-align:center" value="<?php echo $row_CObtieneCamposEvaluado['P6']; ?>" autocomplete="off" size="5" />
      </div></td>
      <td align="center" valign="middle" bgcolor="#FFFFFF" class="Estilo24"><div align="center">
        <textarea name="P6OBS" cols="40" rows="3" class="Estilo26"  id="P6OBS"><?php echo $row_CObtieneCamposEvaluado['P6OBS']; ?></textarea>
      </div></td>
    </tr>
    <tr class="noimprimir">
      <td height="20" colspan="8" bordercolor="#003300" bgcolor="#FFFFFF" class="Estilo24"><div align="center"><span class="Estilo40"> <br />
        </span><span class="Estilo40">
          <input name="submit6" type="submit" class="Estilo4" onclick="MM_popupMsg('Estimado jefe:\r\rLa informaci&oacute;n se ha guardado correctamente. \r\rPuede continuar con otra secci&oacute;n o si desea realizar otra evaluaci&oacute;n, presione el bot&oacute;n EVALUAR A OTRO COLABORADOR al principio de esta p&aacute;gina.\r\rDe lo contrario, simplemente salga de la p&aacute;gina.\r\rMuchas gracias por su colaboraci&oacute;n para construir un mejor equipo.\r\rDirecci&oacute;n de Talento Humano')" value="GUARDAR" />
          </span><br />
        <br />
        <a href="#Secciones" class="EstiloIrPrincipio">Volver al inicio</a><br />
        <br />
      </div></td>
    </tr>
    <tr>
      <td height="20" colspan="8" bordercolor="#003300" bgcolor="#FFFFFF" class="Estilo24"><div align="left">
        <p align="center"><br />
          <span class="Estilo39mediano">RESULTADOS HABILIDADES </span></p>
        <table border="1" align="center" style="border-collapse:collapse">
          <tr align="center">
            <td valign="top">Adaptabilidad    al grupo de trabajo y otras &aacute;reas</td>
            <td valign="top">Calidad en el    trabajo</td>
            <td valign="top">Compromiso    organizacional</td>
            <td valign="top">Empoderamiento de    cargo</td>
            <td valign="top">Proactividad e    innovaci&oacute;n</td>
            <td valign="top">Liderazgo</td>
            <th valign="top" class="Estilo28" scope="col">TOTAL</th>
          </tr>
          <tr>
            <th scope="row"><span class="Estilo39"><?php echo $row_CObtieneCamposEvaluado['NoP1']; ?></span></th>
            <td align="center" valign="middle"><span class="Estilo39"><?php echo $row_CObtieneCamposEvaluado['NoP2']; ?></span></td>
            <td align="center" valign="middle"><span class="Estilo39"><?php echo $row_CObtieneCamposEvaluado['NoP3']; ?></span></td>
            <td align="center" valign="middle"><span class="Estilo39"><?php echo $row_CObtieneCamposEvaluado['NoP4']; ?></span></td>
            <td align="center" valign="middle"><span class="Estilo39"><?php echo $row_CObtieneCamposEvaluado['NoP5']; ?></span></td>
            <td align="center" valign="middle"><span class="Estilo39"><?php echo $row_CObtieneCamposEvaluado['NoP6']; ?></span></td>
            <td align="center" valign="middle" class="Estilo39mediano"><?php echo $row_CObtieneCamposEvaluado['TOTAL']; ?></td>
          </tr>
          <tr align="center" class="Estilo39pequeno">
            <td scope="row"><?php echo $row_CObtieneCamposEvaluado['RESP1']; ?></td>
            <td valign="middle"><?php echo $row_CObtieneCamposEvaluado['RESP2']; ?></td>
            <td valign="middle"><?php echo $row_CObtieneCamposEvaluado['RESP3']; ?></td>
            <td valign="middle"><?php echo $row_CObtieneCamposEvaluado['RESP4']; ?></td>
            <td valign="middle"><?php echo $row_CObtieneCamposEvaluado['RESP5']; ?></td>
            <td valign="middle"><?php echo $row_CObtieneCamposEvaluado['RESP6']; ?></td>
            <td valign="middle" class="Estilo39mediano"><?php echo $row_CObtieneCamposEvaluado['RESPTOTAL']; ?></td>
          </tr>
        </table>
        <p><br />
        </p>
      </div>
        <div align="left"></div>
        <div align="center"></div>
        <div align="left"></div>
        <div align="center"></div>
        <div align="left"></div>
        <div align="center"></div></td>
    </tr>
    <tr>
      <td height="20" colspan="8" bordercolor="#003300" bgcolor="#EAF2F2" class="Estilo28"><div align="center"><span class="Estilo39mediano"><a name="Futur" id="Futur"></a><br />
        3 - NUESTRO FUTURO</span><br />
        <span class="Estilo39mediano"><a href="#Secciones" class="EstiloIrPrincipio"></a></span><br />
      </div></td>
    </tr>
    <tr>
      <td height="20" colspan="8" bordercolor="#003300" bgcolor="#FFFFFF" class="Estilo28"><table border="1" align="center" cellpadding="1" cellspacing="1" style="border-collapse:collapse">
        <tr>
          <th class="Estilo39" scope="col">&nbsp;</th>
          <th class="Estilo39" scope="col">Objetivos</th>
        </tr>
        <tr>
          <th class="Estilo24" scope="col">Dados los resultados, &iquest;Cu&aacute;les son los objetivos que se deben alcanzar?</th>
          <th align="center" scope="col"><div align="center">
            <textarea name="MejoraObjetivos" cols="100" rows="5" class="Estilo26"><?php echo $row_CObtieneCamposEvaluado['MejoraObjetivos']; ?></textarea>
            <input name="MejoraResultados" type="hidden" class="Estilo26" value="<?php echo $row_CObtieneCamposEvaluado['MejoraResultados']; ?>" size="50" //titulo de="de" columna="columna" - resultados="resultados"/>
            <input name="MejoraAcciones" type="hidden" class="Estilo26" value="<?php echo $row_CObtieneCamposEvaluado['MejoraAcciones']; ?>" size="50" // titulo de="de" columna="columna"  - acciones="acciones"/>
            <input name="PlanPersonalAcciones" type="hidden" class="Estilo26" value="<?php echo $row_CObtieneCamposEvaluado['PlanPersonalAcciones']; ?>" size="50" esta="esta" oculto="oculto" si="si" el="el" empleado="empleado" sigue="sigue" //campo columna="columna" resultados="resultados" linea="linea" plan="plan" accion="accion"  />
          </div></th>
        </tr>
        <tr>
          <th scope="col"><table cellspacing="0" cellpadding="0">
            <tr>
              <td nowrap="nowrap"><p class="Estilo24">&iquest;C&oacute;mo va a alcanzar&nbsp;los objetivos planteados?</p></td>
            </tr>
          </table></th>
          <th align="center" scope="col"><div align="center">
            <textarea name="PlanPersonalObjet" cols="100" rows="5" class="Estilo26"><?php echo $row_CObtieneCamposEvaluado['PlanPersonalObjet']; ?></textarea>
          </div></th>
        </tr>
        <tr class="noimprimir">
          <th colspan="2" scope="col"><span class="Estilo40">
            <input name="submit7" type="submit" class="Estilo4" onclick="MM_popupMsg('Estimado jefe:\r\rLa informaci&oacute;n se ha guardado correctamente. \r\rPuede continuar con otra secci&oacute;n o si desea realizar otra evaluaci&oacute;n, presione el bot&oacute;n EVALUAR A OTRO COLABORADOR al principio o al final de esta p&aacute;gina.\r\rDe lo contrario, simplemente salga de la p&aacute;gina.\r\rMuchas gracias por su colaboraci&oacute;n para construir un mejor equipo.\r\rDirecci&oacute;n de Talento Humano')" value="GUARDAR" />
            <br />
            <br />
            <a href="#Secciones" class="EstiloIrPrincipio">Volver al inicio</a></span></th>
        </tr>
      </table>
        <br />
      <br /></td>
    </tr>
    <tr class="noimprimir">
      <td height="20" colspan="8" bordercolor="#003300" bgcolor="#EAF2F2" class="Estilo28"><div align="center"><span class="Estilo39mediano"><a name="Ruta" id="Ruta"></a><br />
        4 - MI RUTA</span><br />
        <span class="Estilo39mediano"><br />
        </span></div></td>
    </tr>
    <tr>
      <td height="20" colspan="8" bordercolor="#003300" bgcolor="#FFFFFF" class="Estilo28"><div align="center"> <br />
          <table border="1" align="center" style="border-collapse:collapse">
            <tr>
              <th class="Estilo39" scope="col">&nbsp;</th>
              <th class="Estilo39" scope="col">Colaborador</th>
              <th class="Estilo39" scope="col">Jefe</th>
            </tr>
            <tr>
              <th class="Estilo39" scope="col"><div align="left" class="Estilo24">&iquest;Qu&eacute; necesita para fortalecer sus resultados laborales?</div></th>
              <th scope="col"><textarea name="ColabNecFortResLab" cols="50" rows="5" class="Estilo26"><?php echo $row_CObtieneCamposEvaluado['ColabNecFortResLab']; ?></textarea>
                <input name="ColabComenzarHacer" type="hidden" class="Estilo26" value="<?php echo $row_CObtieneCamposEvaluado['ColabComenzarHacer']; ?>" size="50" colaborador="colaborador" - &iquest;qu&eacute; hay="hay" que="que" comenzar="comenzar" a="a" hacer?="hacer?"/>
                <input name="JefeComenzarHacer" type="hidden" class="Estilo26" value="<?php echo $row_CObtieneCamposEvaluado['JefeComenzarHacer']; ?>" size="50" jefe="jefe" - &iquest;qu&eacute; hay="hay" que="que" comenzar="comenzar" a="a" hacer?="hacer?" />
                <input name="ColabContinuarHacer" type="hidden" class="Estilo26" value="<?php echo $row_CObtieneCamposEvaluado['ColabContinuarHacer']; ?>" size="50" &iquest;qu&eacute; hay="hay" que="que" continuar="continuar" haciendo?="haciendo?"/>
                <input name="JefeContinuarHacer" type="hidden" class="Estilo26" value="<?php echo $row_CObtieneCamposEvaluado['JefeContinuarHacer']; ?>" size="50" &iquest;qu&eacute; hay="hay" que="que" continuar="continuar" haciendo?="haciendo?"/></th>
              <th scope="col"><textarea name="JefeNecFortResLab" cols="50" rows="5" class="Estilo26"><?php echo $row_CObtieneCamposEvaluado['JefeNecFortResLab']; ?></textarea></th>
            </tr>
            <tr>
              <th class="Estilo39" scope="col"><div align="left" class="Estilo24">&iquest;Qu&eacute; hay que dejar de hacer?</div></th>
              <th scope="col"><textarea name="ColabDejarDeHacer" cols="50" rows="5" class="Estilo26"><?php echo $row_CObtieneCamposEvaluado['ColabDejarDeHacer']; ?></textarea>
                <input name="ColabQueTeLLevas" type="hidden" class="Estilo26" value="<?php echo $row_CObtieneCamposEvaluado['ColabQueTeLLevas']; ?>" size="50" // jefe &iquest;Qu&eacute; te="te" llevas="llevas" de="de" esta="esta" conversaci&oacute;n?="conversaci&oacute;n?"/>
                <input name="JefeQueTeLLevas" type="hidden" class="Estilo26" value="<?php echo $row_CObtieneCamposEvaluado['JefeQueTeLLevas']; ?>" size="50" // Jefe - &iquest;Qu&eacute; te="te" llevas="llevas" de="de" esta="esta" conversaci&oacute;n?="conversaci&oacute;n?" /></th>
              <th scope="col"><textarea name="JefeDejarDeHacer" cols="50" rows="5" class="Estilo26"><?php echo $row_CObtieneCamposEvaluado['JefeDejarDeHacer']; ?></textarea></th>
            </tr>
            <tr class="noimprimir">
              <th colspan="3" class="Estilo39" scope="col"><span class="Estilo40">
                <input name="submit" type="submit" class="Estilo4" onclick="MM_popupMsg('Estimado jefe:\r\rLa informaci&oacute;n se ha guardado correctamente. \r\rPuede continuar con otra secci&oacute;n o si desea realizar otra evaluaci&oacute;n, presione el bot&oacute;n EVALUAR A OTRO COLABORADOR al principio o al final de esta p&aacute;gina.\r\rDe lo contrario, simplemente salga de la p&aacute;gina.\r\rMuchas gracias por su colaboraci&oacute;n para construir un mejor equipo.\r\rDirecci&oacute;n de Talento Humano')" value="GUARDAR" />
                <span class="Estilo39mediano"><a href="#Secciones" class="EstiloIrPrincipio"><br />
                  <br />
                  Volver al inicio</a></span></span></th>
            </tr>
          </table>
          <p class="Estilo39mediano">&nbsp;</p>
      </div></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="70%" border="1" align="center" style="border-collapse:collapse">
    <tr>
      <td width="33%" height="38" bordercolor="#596221" bgcolor="#FFFFFF" class="Estilo4">&nbsp;</td>
      <td colspan="2" bordercolor="#596221" bgcolor="#FFFFFF" class="Estilo39"><div align="center">APRUEBA LA EVALUACI&Oacute;N<br />
        <span class="Estilo4">Aprobar significa lo mismo que la firma<br />
        </span></div></td>
    </tr>
    <tr>
      <td height="63" align="center" valign="middle" bordercolor="#596221" bgcolor="#FFFFFF" class="Estilo4">&nbsp;</td>
      <td width="33%" align="center" valign="middle" bordercolor="#596221" bgcolor="#FFFFFF" class="Estilo4"><p> <span class="Estilo39">
        <input  <?php if (!(strcmp($row_CObtieneCamposEvaluado['FirmaEvaluador'],"SI"))) {echo "checked=\"checked\"";} ?> type="radio" name="FirmaEvaluador"  value="SI"   />
        SI
        <input  <?php if (!(strcmp($row_CObtieneCamposEvaluado['FirmaEvaluador'],"NO"))) {echo "checked=\"checked\"";} ?> type="radio" name="FirmaEvaluador" value="NO"  />
        NO </span></p></td>
      <td width="34%" align="center" valign="middle" bordercolor="#596221" bgcolor="#FFFFFF" class="Estilo4"><span class="Estilo39">
        <input  <?php if (!(strcmp($row_CObtieneCamposEvaluado['FirmaEvaluado'],"SI"))) {echo "checked=\"checked\"";} ?> type="radio" name="FirmaEvaluado" value="SI"    />
        SI
        <input  <?php if (!(strcmp($row_CObtieneCamposEvaluado['FirmaEvaluado'],"NO"))) {echo "checked=\"checked\"";} ?> type="radio" name="FirmaEvaluado" value="NO"   />
        NO</span></td>
    </tr>
    <tr class="Estilo28">
      <td bordercolor="#596221" bgcolor="#FFFFFF" class="Estilo4"><div align="center" class="Estilo28">Jefe de Talento Humano </div></td>
      <td bordercolor="#596221" bgcolor="#FFFFFF" class="Estilo4"><div align="center" class="Estilo28">Nombre del evaluador</div></td>
      <td bordercolor="#596221" bgcolor="#FFFFFF" class="Estilo4"><div align="center" class="Estilo28">Nombre del evaluado </div></td>
    </tr>
    <tr>
      <td bordercolor="#596221" bgcolor="#FFFFEC" class="Estilo33"><input name="JefeTH" type="text" class="Estilo39pequeno" style="text-align:center" value="SANDRA PATRICIA SARMIENTO GARZON" size="42" /></td>
      <td bordercolor="#596221" bgcolor="#FFFFEC" class="Estilo4"><input name="Evaluador" type="text" class="Estilo39pequeno" style="text-align:center" value="<?php echo $row_CObtieneCamposEvaluado['JEFCOL']; ?>" size="42" /></td>
      <td bordercolor="#596221" bgcolor="#FFFFEC" class="Estilo4"><input name="Evaluado" type="text" class="Estilo39pequeno" style="text-align:center" value="<?php echo $row_CObtieneCamposEvaluado['NOMBCOL']; ?>" size="42" /></td>
    </tr>
    <tr class="noimprimir">
      <td colspan="3" bordercolor="#596221" bgcolor="#FFFFEC" class="Estilo33"><div align="center">
        <p><span class="Estilo40"><br />
          </span><span class="Estilo40">
            <input name="submit3" type="submit" class="Estilo4" onclick="MM_popupMsg('Estimado jefe:\r\rLa informaci&oacute;n se ha guardado correctamente. \r\rPuede continuar con otra secci&oacute;n o si desea realizar otra evaluaci&oacute;n, presione el bot&oacute;n EVALUAR A OTRO COLABORADOR al principio de esta p&aacute;gina.\r\rDe lo contrario, simplemente salga de la p&aacute;gina.\r\rMuchas gracias por su colaboraci&oacute;n para construir un mejor equipo.\r\rDirecci&oacute;n de Talento Humano')" value="GUARDAR" />
          </span></p>
        <p><br />
          <a href="#Secciones" class="EstiloIrPrincipio">Volver al inicio</a><br />
        </p>
      </div></td>
    </tr>
  </table>
  <p align="center">
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

mysql_free_result($CObtieneCamposEvaluado);
?>

