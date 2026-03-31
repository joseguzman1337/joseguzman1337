<?php require_once('Connections/conexion.php'); error_reporting(0)?>
<?php require_once('Connections/conexion.php'); ?>
<?php
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO tevaldes (NombCol, JefCol, FechEval, CaGeCaTr, CaGeCoTr, CaGeInic, CaGeDiAp, CaGeOrTR, CaGeMaIn, CaGeAtCl, FaDeCuOp, FaDeCoop, FaDeComu, FaDeAdap, CoInPaAc, CoInSePe, CoInCoOr, CoInPrPe, PlMeFort, PlMeAsMe, PlMePlMe, PlMePlAc, CoGePeTf, Evaluador, Evaluado, JefeTH) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['NombCol'], "text"),
                       GetSQLValueString($_POST['JefCol'], "text"),
                       GetSQLValueString($_POST['FechEval'], "date"),
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
                       GetSQLValueString($_POST['PlMeFort'], "text"),
                       GetSQLValueString($_POST['PlMeAsMe'], "text"),
                       GetSQLValueString($_POST['PlMePlMe'], "text"),
                       GetSQLValueString($_POST['PlMePlAc'], "text"),
                       GetSQLValueString($_POST['CoGePeTf'], "text"),
                       GetSQLValueString($_POST['Evaluador'], "text"),
                       GetSQLValueString($_POST['Evaluado'], "text"),
                       GetSQLValueString($_POST['JefeTH'], "text"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
}

mysql_select_db($database_conexion, $conexion);
$query_Colaboradores = "SELECT * FROM tlistacol ORDER BY NombCol ASC";
$Colaboradores = mysql_query($query_Colaboradores, $conexion) or die(mysql_error());
$row_Colaboradores = mysql_fetch_assoc($Colaboradores);
$totalRows_Colaboradores = mysql_num_rows($Colaboradores);

mysql_select_db($database_conexion, $conexion);
$query_Jefes = "SELECT tjefdep.JefDepen FROM tjefdep";
$Jefes = mysql_query($query_Jefes, $conexion) or die(mysql_error());
$row_Jefes = mysql_fetch_assoc($Jefes);
$totalRows_Jefes = mysql_num_rows($Jefes);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
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
<script type="text/JavaScript">
<!--
function MM_popupMsg(msg) { //v1.0
  alert(msg);
}
//-->
</script>
</head>

<body>
<table width="838" border="0">
  <tr>
    <td width="155" height="72" bgcolor="#98BD0D"><div align="center" class="Estilo22"><img src="IMAGENES/LOGOBOSQUETH.jpg" alt="as" width="138" height="62" /></div></td>
    <td width="673" bgcolor="#98BD0D"><div align="center" class="Estilo4">EVALUACI&Oacute;N DE DESEMPE&Ntilde;O <br />
      COLABORADORES A T&Eacute;RMINO FIJO E INDEFINIDO </div></td>
  </tr>
</table>
<table width="838" border="0">
  <tr>
    <td width="832" bgcolor="#FFB112"><div align="center" class="Estilo4">DEPARTAMENTO DE TALENTO HUMANO - CONSTRUYENDO UN MEJOR EQUIPO </div></td>
  </tr>
</table>
<p>&nbsp;</p>
<table width="840" border="0">
  <tr>
    <td><div align="center">
      <p class="Estilo4">Estimado jefe, para comenzar escoja el colaborador que va a evaluar<br /> 
        y luego su nombre como evaluador.<br />
        <br />
        Al escojer el evaluado observar&aacute; en la misma linea toda la informaci&oacute;n relacionada con su contrato. </p>
      <p class="Estilo4"><span class="Estilo42">Al finalizar, deber&aacute; confirmar el nombre del evaluado y el suyo, previa revisi&oacute;n con el evaluado.<br />
          <u>Tenga en cuenta que una vez enviada la evaluaci&oacute;n no podr&aacute; ser corregida</u>. Muchas Gracias</span> <br />
      </p>
      </div></td>
  </tr>
</table>
<p>&nbsp;</p>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table>
    <tr valign="baseline">
      <td align="right" nowrap="nowrap" bgcolor="#FFFFCC" class="Estilo4"><label>
        <div align="left" onchange="[Evaluado]=[NombCol}">Nombre del colaborador evaluado <br />
              <select name="NombCol">
            <option value="No selecciono al colaborador">Presione click aqui para seleccionar al colaborador</option>
            <?php
do {  
?>
            <option value="<?php echo $row_Colaboradores['NombCol']?>"><?php echo $row_Colaboradores['TodCampos']?></option>
            <?php
} while ($row_Colaboradores = mysql_fetch_assoc($Colaboradores));
  $rows = mysql_num_rows($Colaboradores);
  if($rows > 0) {
      mysql_data_seek($Colaboradores, 0);
	  $row_Colaboradores = mysql_fetch_assoc($Colaboradores);
  }
?>
          </select>
        </div>
      </label></td>
      <td align="right" nowrap="nowrap" bgcolor="#FFFFCC" class="Estilo4"><div align="left"></div></td>
    </tr>
    <tr valign="baseline">
      <td colspan="2" align="right" valign="bottom" nowrap="nowrap" bgcolor="#FFFFCC" class="Estilo4"><label>
          <div align="left">Nombre del evaluador (jefe inmediato) <br />
              <select name="JefCol">
            <option value="No selecciono">Seleccione su nombre</option>
            <?php
do {  
?>
            <option value="<?php echo $row_Jefes['JefDepen']?>"><?php echo $row_Jefes['JefDepen']?></option>
            <?php
} while ($row_Jefes = mysql_fetch_assoc($Jefes));
  $rows = mysql_num_rows($Jefes);
  if($rows > 0) {
      mysql_data_seek($Jefes, 0);
	  $row_Jefes = mysql_fetch_assoc($Jefes);
  }
?>
            </select>
          </div>
      </label></td>
    </tr>
    <tr valign="baseline">
      <td colspan="2" align="right" valign="bottom" nowrap="nowrap" bgcolor="#FFFFCC" class="Estilo4"><div align="left"><br />
        Fecha de evaluaci&oacute;n<span class="Estilo24"> (a&ntilde;o-mes-dia. Ej: 2010-08-02 - no olvide los guiones)</span><br />
            <input type="text" name="FechEval" value="" size="32" />
      </div></td>
    </tr>
  </table>
  <p>
    <label></label>
    <label></label>
    <label></label>
    <label></label>
  </p>
  <table width="795" border="2" bordercolor="#003300" bgcolor="#FFFF99">
    <tr height="20">
      <td colspan="7" bordercolor="#003300" bgcolor="#FFB112" class="Estilo4"><div align="center" class="Estilo25 Estilo26">Calidad de la gesti&oacute;n: Considere el desempe&ntilde;o obtenido por el empleado en su labor.</div></td>
    </tr>
    
    <tr height="20">
      <td width="195" height="20" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">CALIDAD    DEL TRABAJO<br />
      Eficacia y eficiencia, en la realizaci&oacute;n normal de las    tareas, teniendo un inter&eacute;s por obtener &oacute;ptimos resultados</div></td>
      <td width="180" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Requiere una permanente    supervisi&oacute;n y en general comete muchos errores</div></td>
      <td width="21" align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24">
        
        <div align="center">
          <input name="CaGeCaTr" type="radio" value="1" />
        </div></td>
      <td width="145" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Comete algunos    errores y la calidad es regular</div></td>
      <td width="20" align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24">
        
        <div align="center">
          <input name="CaGeCaTr" type="radio" value="2" />
        </div></td>
      <td width="163" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">La precisi&oacute;n de    su trabajo permite utilizarlo con confianza</div></td>
      <td width="23" align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24">
        <div align="center">
          <input name="CaGeCaTr" type="radio" value="3" />
      </div></td>
    </tr>
    <tr height="20">
      <td height="20" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">CONOCIMIENTO    DEL TRABAJO<br />
      Se preocupa por investigar y comprender las tareas y    funciones, aplicando las t&eacute;cnicas y m&eacute;todos pertinentes para realizarlas</div></td>
      <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">No muestra ning&uacute;n inter&eacute;s en    conocer mejor su trabajo</div></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="center">
        <input name="CaGeCoTr" type="radio" value="1" />
      </div></td>
      <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Se preocupa poco    por actualizar su conocimiento de tareas y m&eacute;todos</div></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="center">
        <input name="CaGeCoTr" type="radio" value="2" />
      </div></td>
      <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Esta al d&iacute;a con    el conocimiento requerido para hacer efectivamente su trabajo</div></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="center">
        <input name="CaGeCoTr" type="radio" value="3" />
      </div></td>
    </tr>
    <tr height="20">
      <td height="20" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">INICIATIVA<br />
      Encuentra soluciones r&aacute;pidas y mejores a los problemas    de su trabajo con el fin de agilizarlo y ser productivo</div></td>
      <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">No busca soluciones y muestra    mucha pasividad para hallarlas</div></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="center">
        <input name="CaGeInic" type="radio" value="1" />
      </div></td>
      <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Casi siempre    necesita orientaci&oacute;n para hallar las soluciones pertinentes</div></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="center">
        <input name="CaGeInic" type="radio" value="2" />
      </div></td>
      <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Genera    frecuentemente soluciones pr&aacute;cticas y efectivas para lograr productividad</div></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="center">
        <input name="CaGeInic" type="radio" value="3" />
      </div></td>
    </tr>
    <tr height="20">
      <td height="20" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">DISPOSICI&Oacute;N    PARA APRENDER<br />
      Receptividad para adquirir nuevos conocimientos y    adaptarse a nuevos procedimientos</div></td>
      <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">No se preocupa por adquirir nuevos    conocimientos&nbsp; a pesar que se le    transmiten detalladamente</div></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><input name="CaGeDiAp" type="radio" value="1" /></td>
      <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Se le debe    motivar para que adquiera nuevos conocimientos y muestra resistencia</div></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><input name="CaGeDiAp" type="radio" value="2" /></td>
      <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Muestra un alto    inter&eacute;s en nuevos conocimientos y reacciona positivamente a los nuevos    procedimientos</div></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><input name="CaGeDiAp" type="radio" value="3" /></td>
    </tr>
    <tr height="20">
      <td height="20" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">ORGANIZACI&Oacute;N    EN EL TRABAJO<br />
      Capacidad para determinar y coordinar las acciones    necesarias para realizar efectivamente el trabajo</div></td>
      <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">No tiene orden ni m&eacute;todo para    realizar su trabajo</div></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><input name="CaGeOrTR" type="radio" value="1" /></td>
      <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Muestra    dificultades para planear y realizar ordenadamente su trabajo</div></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><input name="CaGeOrTR" type="radio" value="2" /></td>
      <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Planea y realiza    su trabajo ordenada y efectivamente</div></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><input name="CaGeOrTR" type="radio" value="3" /></td>
    </tr>
    <tr height="20">
      <td height="20" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">MANEJO DE    INFORMACI&Oacute;N CON CONFIDENCIALIDAD<br />
      Es prudente con la informaci&oacute;n que maneja y la    transmite a las instancias pertinentes</div></td>
      <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Divulga la informaci&oacute;n    indiscriminadamente llevando a la desconfianza de los dem&aacute;s</div></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><input name="CaGeMaIn" type="radio" value="1" /></td>
      <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">En ciertos casos    es imprudente con la divulgaci&oacute;n de informaci&oacute;n</div></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><input name="CaGeMaIn" type="radio" value="2" /></td>
      <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Muestra alta    confiabilidad en el manejo de la informaci&oacute;n</div></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><input name="CaGeMaIn" type="radio" value="3" /></td>
    </tr>
    <tr height="20">
      <td height="20" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">ATENCI&Oacute;N    AL CLIENTE<br />
      Muestra cordialidad, efectividad y disposici&oacute;n para    atender a los dem&aacute;s</div></td>
      <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Es negligente y desatento en la    atenci&oacute;n de los dem&aacute;s</div></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><input name="CaGeAtCl" type="radio" value="1" /></td>
      <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Le falta un poco    de amabilidad y diligencia al atender a los dem&aacute;s</div></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><input name="CaGeAtCl" type="radio" value="2" /></td>
      <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Brinda una    respuesta amable y efectiva al atender a los dem&aacute;s</div></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><input name="CaGeAtCl" type="radio" value="3" /></td>
    </tr>
    
    <tr>
      <td height="20" colspan="7" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left"></div>        <div align="left"></div>        <div align="center"></div>        <div align="left"></div>        <div align="center"></div>        <div align="left"></div>        <div align="center"></div></td>
    </tr>
    <tr>
      <td height="20" colspan="7" bordercolor="#003300" bgcolor="#FFB112" class="Estilo28"><div align="center">Facilitadores de desempe&ntilde;o: Considere aquellas caracter&iacute;sticas individuales que posee el empleado para facilitar el buen desempe&ntilde;o laboral dentro y fuera del cargo.</div></td>
    </tr>
    <tr>
      <td height="20" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">CUMPLIMIENTO    OPORTUNO DE TAREAS ASIGNADAS Y PUNTUALIDAD<br />
        Responsabilidad, dedicaci&oacute;n y puntualidad en las tareas    y los horarios</div></td>
      <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Con frecuencia se retarda y pierde    tiempo en su trabajo</div></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="center">
        <input name="FaDeCuOp" type="radio" value="1" />
      </div></td>
      <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Rara vez incumple    con sus tareas o sus horarios</div></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="center">
        <input name="FaDeCuOp" type="radio" value="2" />
      </div></td>
      <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Es ejemplo de    puntualidad y cumplimiento de tareas</div></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="center">
        <input name="FaDeCuOp" type="radio" value="3" />
      </div></td>
    </tr>
    <tr>
      <td height="20" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">COOPERACI&Oacute;N<br />
        Disposici&oacute;n de colaborar con los dem&aacute;s, aunque no sea    parte de sus obligaciones, aportando al trabajo en equipo</div></td>
      <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">No colabora ni ayuda a los dem&aacute;s y    pone obst&aacute;culos para hacerlo</div></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="center">
        <input name="FaDeCoop" type="radio" value="1" />
      </div></td>
      <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Algunas    veces&nbsp; colabora con actividades que no    corresponden a su trabajo</div></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="center">
        <input name="FaDeCoop" type="radio" value="2" />
      </div></td>
      <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Siempre esta    dispuesto a colaborar, incluso si debe hacer esfuerzos extra</div></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="center">
        <input name="FaDeCoop" type="radio" value="3" />
      </div></td>
    </tr>
    <tr>
      <td height="20" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">COMUNICACI&Oacute;N<br />
        Establece canales de comunicaci&oacute;n con las personas para    lograr efectividad en el trabajo y se relaciona socialmente con los dem&aacute;s</div></td>
      <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Es una persona aislada, prefiere    no hablar con los dem&aacute;s y se muestra pasiva en la relaci&oacute;n social</div></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="center">
        <input name="FaDeComu" type="radio" value="1" />
</div></td>
      <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Establece    contacto con los dem&aacute;s para lo que es estrictamente necesario</div></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="center">
        <input name="FaDeComu" type="radio" value="2" />
</div></td>
      <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Establece    excelentes canales de comunicaci&oacute;n tanto laborales como sociales</div></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="center">
        <input name="FaDeComu" type="radio" value="3" />
      </div></td>
    </tr>
    <tr>
      <td height="20" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">ADAPTABILIDAD<br />
        Capacidad de aceptar los cambios y trabajar para que    tengan &eacute;xito</div></td>
      <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Muestra resistencia ante los    cambios y no colabora para su &eacute;xito</div></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="center">
        <input name="FaDeAdap" type="radio" value="1" />
      </div></td>
      <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Muestra    aceptaci&oacute;n de los cambios pero no colabora para su &eacute;xito</div></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="center">
        <input name="FaDeAdap" type="radio" value="2" />
</div></td>
      <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Acepta los    cambios y genera estrategias para que tengan &eacute;xito</div></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="center">
        <input name="FaDeAdap" type="radio" value="3" />
      </div></td>
    </tr>
    <tr>
      <td height="20" colspan="7" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left"></div>        <div align="left"></div>        <div align="center"></div>        <div align="left"></div>        <div align="center"></div>        <div align="left"></div>        <div align="center"></div></td>
    </tr>
    <tr>
      <td height="20" colspan="7" bordercolor="#003300" bgcolor="#FFB112" class="Estilo24"><div align="center" class="Estilo30">Compromiso Institucional: Considere la participaci&oacute;n del empleado en diferentes actividades de la Universidad. </div>
      <div align="left"></div>        <div align="center"></div>        <div align="left"></div>        <div align="center"></div>        <div align="left"></div>        <div align="center"></div></td>
    </tr>
    <tr height="20">
      <td height="20" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">PARTICIPACI&Oacute;N    EN ACTIVIDADES<br />
      Se integra y participa en los eventos de la    Universidad&nbsp;</div></td>
      <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Muestra desinter&eacute;s ante las&nbsp; actividades de la Universidad y en general    no asiste</div></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="center">
        <input name="CoInPaAc" type="radio" value="1" />
      </div></td>
      <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Rara vez asiste a    las actividades de la Universidad o no participa mucho</div></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="center">
        <input name="CoInPaAc" type="radio" value="2" />
      </div></td>
      <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">En general asiste    y disfruta las actividades de la Universidad</div></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="center">
        <input name="CoInPaAc" type="radio" value="3" />
      </div></td>
    </tr>
    <tr height="20">
      <td height="20" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">SENTIDO DE    PERTENENCIA<br />
      Muestra compromiso con los objetivos de la Universidad    y orgullo de pertenecer a ella</div></td>
      <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Su comportamiento revela falta de    inter&eacute;s en la Universidad, sus objetivos y sus procesos</div></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="center">
        <input name="CoInSePe" type="radio" value="1" />
      </div></td>
      <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Hace pocos    esfuerzos por lograr la mejora de la Universidad</div></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="center">
        <input name="CoInSePe" type="radio" value="2" />
      </div></td>
      <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Hace de la    Universidad parte de su vida y lo disfruta</div></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="center">
        <input name="CoInSePe" type="radio" value="3" />
      </div></td>
    </tr>
    <tr height="20">
      <td height="20" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">CONCIENCIA    ORGANIZACIONAL<br />
      Identificaci&oacute;n y cumplimiento de pol&iacute;ticas y normas de    la Universidad</div></td>
      <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Hace las cosas como quiere sin    respetar reglamentos ni pol&iacute;ticas</div></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="center">
        <input name="CoInCoOr" type="radio" value="1" />
      </div></td>
      <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Presenta    dificultades en el cumplimiento de normas y pol&iacute;ticas</div></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="center">
        <input name="CoInCoOr" type="radio" value="2" />
      </div></td>
      <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Cumple a    cabalidad las normas y pol&iacute;ticas</div></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="center">
        <input name="CoInCoOr" type="radio" value="3" />
      </div></td>
    </tr>
    <tr height="20">
      <td height="20" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24">&nbsp;
        <div align="left">PRESENTACI&Oacute;N PERSONAL<br />
      Imagen personal que denota cuidado, pulcritud y manejo    adecuado del uniforme y la dotaci&oacute;n</div></td>
      <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">En general presenta una imagen    descuidada en la vestimenta y su arreglo personal</div></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="center">
        <input name="CoInPrPe" type="radio" value="1" />
      </div></td>
      <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">En algunos casos    descuida su imagen y el uso del uniforme</div></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="center">
        <input name="CoInPrPe" type="radio" value="2" />
      </div></td>
      <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Siempre est&aacute; en    &oacute;ptimas condiciones de presentaci&oacute;n y utiliza adecuadamente el uniforme</div></td>
      <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="center">
        <input name="CoInPrPe" type="radio" value="3" />
      </div></td>
    </tr>
    
    <tr>
      <td height="20" colspan="7" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left"></div>        <div align="left"></div>        <div align="center"></div>        <div align="left"></div>        <div align="center"></div>        <div align="left"></div>        <div align="center"></div></td>
    </tr>
    <tr>
      <td height="20" colspan="7" bordercolor="#003300" bgcolor="#FFB112" class="Estilo28"><div align="center">PLAN DE MEJORAMIENTO</div></td>
    </tr>
    <tr>
      <td height="20" colspan="7" bordercolor="#596221" bgcolor="#FFFFCC" class="Estilo24"><div align="center">FORTALEZAS<br />
          <textarea name="PlMeFort" cols="100" rows="4"></textarea>
      </div></td>
    </tr>
    <tr>
      <td height="20" colspan="7" bordercolor="#596221" bgcolor="#FFFFCC" class="Estilo24"><div align="center">ASPECTOS POR MEJORAR<br />
          <textarea name="PlMeAsMe" cols="100" rows="4"></textarea>
      </div></td>
    </tr>
    <tr>
      <td height="20" colspan="7" bordercolor="#596221" bgcolor="#FFFFCC" class="Estilo24"><div align="center">COMPROMISOS ADQUIRIDOS POR EL COLABORADOR PARA EL PLAN DE MEJORAMIENTO<br />
          <textarea name="PlMePlMe" cols="100" rows="4"></textarea>
      </div></td>
    </tr>
    <tr>
      <td height="20" colspan="7" bordercolor="#596221" bgcolor="#FFFFCC" class="Estilo24"><div align="center">PLAZO ACORDADO PARA EL PLAN DE MEJORAMIENTO<br />
          <textarea name="PlMePlAc" cols="100" rows="4"></textarea>
      </div></td>
    </tr>
    <tr>
      <td height="20" colspan="7" bordercolor="#596221" bgcolor="#FFFFCC" class="Estilo24"><div align="center">SI EST&Aacute; EVALUANDO UNA PERSONA <span class="Estilo40">CONTRATADA A T&Eacute;RMINO FIJO</span> , SEG&Uacute;N USTED &iquest;ESTA PERSONA DEBE O NO SER CONTRATADA PARA CONTINUAR LABORANDO EN LA INSTITUCI&Oacute;N?. EN CASO DE SER NEGATIVA SU RESPUESTA, EXPLIQUE POR FAVOR EL MOTIVO DE ESTA DECISI&Oacute;N<br />
          <textarea name="CoGePeTf" cols="100" rows="5"></textarea>
      </div></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="797" border="1">
    <tr>
      <td colspan="3" bordercolor="#596221" bgcolor="#FFFFCC"><div align="center"> <span class="Estilo28">Por favor confirme los nombres del evaluador y del evaluado. Luego imprima la evaluaci&oacute;n para firmarla y por &uacute;ltimo presione el bot&oacute;n &quot;enviar evaluaci&oacute;n&quot; </span><br />
          <span class="Estilo39">La confirmaci&oacute;n significa que las diferentes partes de esta evaluaci&oacute;n han sido discutidas con el evaluado y no necesariamente significa que el evaluado est&aacute; de acuerdo con los resultados. <br />
El colaborador puede solicitar revisi&oacute;n al siguiente nivel jer&aacute;rquico o a la Direcci&oacute;n de Talento Humano</span></div></td>
    </tr>
    <tr>
      <td height="64" bordercolor="#596221" bgcolor="#FFFFCC" class="Estilo4">&nbsp;</td>
      <td bordercolor="#596221" bgcolor="#FFFFCC" class="Estilo4">&nbsp;</td>
      <td bordercolor="#596221" bgcolor="#FFFFCC" class="Estilo4">&nbsp;</td>
    </tr>
    <tr>
      <td width="239" bordercolor="#596221" bgcolor="#FFFFCC" class="Estilo4"><div align="center">Jefe de Talento Humano </div></td>
      <td width="208" bordercolor="#596221" bgcolor="#FFFFCC" class="Estilo4"><div align="center">Nombre del evaluador</div></td>
      <td width="328" bordercolor="#596221" bgcolor="#FFFFCC" class="Estilo4"><div align="center">Nombre del evaluado </div></td>
    </tr>
    <tr>
      <td bordercolor="#596221" bgcolor="#FFFFCC" class="Estilo33"><input name="JefeTH" type="text" class="Estilo4" value="SANDRA PATRICIA SARMIENTO GARZON" size="42" /></td>
      <td bordercolor="#596221" bgcolor="#FFFFCC" class="Estilo4"><select name="Evaluador">
        <option value="No selecciono">Seleccione su nombre</option>
        <?php
do {  
?>
        <option value="<?php echo $row_Jefes['JefDepen']?>"><?php echo $row_Jefes['JefDepen']?></option>
        <?php
} while ($row_Jefes = mysql_fetch_assoc($Jefes));
  $rows = mysql_num_rows($Jefes);
  if($rows > 0) {
      mysql_data_seek($Jefes, 0);
	  $row_Jefes = mysql_fetch_assoc($Jefes);
  }
?>
      </select></td>
      <td bordercolor="#596221" bgcolor="#FFFFCC" class="Estilo4"><select name="Evaluado">
        <option value="No selecciono al colaborador">Presione click aqui para seleccionar al colaborador</option>
        <?php
do {  
?>
        <option value="<?php echo $row_Colaboradores['NombCol']?>"><?php echo $row_Colaboradores['NombCol']?></option>
        <?php
} while ($row_Colaboradores = mysql_fetch_assoc($Colaboradores));
  $rows = mysql_num_rows($Colaboradores);
  if($rows > 0) {
      mysql_data_seek($Colaboradores, 0);
	  $row_Colaboradores = mysql_fetch_assoc($Colaboradores);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td colspan="3" bordercolor="#596221" bgcolor="#FFFFCC" class="Estilo33"><p align="center" class="Estilo40">Por favor revise que no haya dejado nada sin contestar. <br />
      Muchas gracias por su colaboraci&oacute;n en la construcci&oacute;n de un mejor equipo</p>      </td>
    </tr>
    <tr>
      <td colspan="3" bgcolor="#FFFFCC" class="Estilo33"><div align="center">
        <input name="submit" type="submit" onclick="MM_popupMsg('Estimado jefe:\rLa evaluaci&oacute;n ha sido enviada exitosamente. En seguida ver&aacute; un formato en blanco por si requiere hacer otra evaluaci&oacute;n. De lo contrario pase a otra p&aacute;gina o salga de internet.\r\rMuchas gracias por su colaboraci&oacute;n para construir un mejor equipo\r\rDepartamento de Talento Humano')" value="Enviar Evaluaci&oacute;n" />
      </div></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <p>
    <input type="hidden" name="MM_insert" value="form1">
</p>
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Colaboradores);

mysql_free_result($Jefes);
?>

