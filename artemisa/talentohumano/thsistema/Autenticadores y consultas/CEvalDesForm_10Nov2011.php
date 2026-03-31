<?php require_once('../Connections/conexion.php'); ?>
<?php
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_EvalDes = 1;
$pageNum_EvalDes = 0;
if (isset($_GET['pageNum_EvalDes'])) {
  $pageNum_EvalDes = $_GET['pageNum_EvalDes'];
}
$startRow_EvalDes = $pageNum_EvalDes * $maxRows_EvalDes;

$colname_EvalDes = "-1";
if (isset($_GET['CCBuscar'])) {
  $colname_EvalDes = (get_magic_quotes_gpc()) ? $_GET['CCBuscar'] : addslashes($_GET['CCBuscar']);
}
mysql_select_db($database_conexion, $conexion);
$query_EvalDes = sprintf("SELECT * FROM tevaldes WHERE NombCol = '%s' ORDER BY NombCol ASC", $colname_EvalDes);
$query_limit_EvalDes = sprintf("%s LIMIT %d, %d", $query_EvalDes, $startRow_EvalDes, $maxRows_EvalDes);
$EvalDes = mysql_query($query_limit_EvalDes, $conexion) or die(mysql_error());
$row_EvalDes = mysql_fetch_assoc($EvalDes);

if (isset($_GET['totalRows_EvalDes'])) {
  $totalRows_EvalDes = $_GET['totalRows_EvalDes'];
} else {
  $all_EvalDes = mysql_query($query_EvalDes);
  $totalRows_EvalDes = mysql_num_rows($all_EvalDes);
}
$totalPages_EvalDes = ceil($totalRows_EvalDes/$maxRows_EvalDes)-1;

$queryString_EvalDes = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_EvalDes") == false && 
        stristr($param, "totalRows_EvalDes") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_EvalDes = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_EvalDes = sprintf("&totalRows_EvalDes=%d%s", $totalRows_EvalDes, $queryString_EvalDes);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<style type="text/css">
<!--
.Estilo24 {font-family: Tahoma; color: #596221; font-weight: bold; font-size: 12px; }
.Estilo25 {	font-size: 18px;
	color: #98BD0D;
}
.Estilo26 {color: #596221}
.Estilo28 {font-family: Tahoma; color: #596221; font-weight: bold; font-size: 18px; }
.Estilo30 {font-size: 18px}
.Estilo33 {font-family: Tahoma; color: #596221; font-weight: bold; font-size: 14px; }
.Estilo39 {	color: #CC3366;
	font-weight: bold;
	font-family: Tahoma;
	font-size: 14px;
}
.Estilo4 {font-family: Tahoma;
	color: #596221;
	font-weight: bold;
}
.Estilo40 {color: #CC3366; }
.Estilo41 {color: #0000FF}
.Estilo22 {color: #FFFFFF; font-weight: bold; }
-->
</style>
</head>

<body>
<table width="838" border="0">
  <tr>
    <td width="155" height="72" bgcolor="#98BD0D"><div align="center" class="Estilo22"><img src="../IMAGENES/LOGOBOSQUETH.jpg" alt="as" width="138" height="62" /></div></td>
    <td width="673" bgcolor="#98BD0D"><div align="center" class="Estilo4">RESULTADOS EVALUACI&Oacute;N DE DESEMPE&Ntilde;O <br />
      COLABORADORES A T&Eacute;RMINO FIJO E INDEFINIDO </div></td>
  </tr>
</table>
<table width="838" border="0">
  <tr>
    <td width="832" bgcolor="#FFB112"><div align="center" class="Estilo4">DEPARTAMENTO DE TALENTO HUMANO - CONSTRUYENDO UN MEJOR EQUIPO </div></td>
  </tr>
</table>
<p><label></label>
</p>
<table width="840" border="1">
  <tr>
    <td align="center"><?php if ($pageNum_EvalDes > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_EvalDes=%d%s", $currentPage, 0, $queryString_EvalDes); ?>"><img src="First.gif" alt="A" border="0" /></a>
        <?php } // Show if not first page ?>
    </td>
    <td align="center"><?php if ($pageNum_EvalDes > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_EvalDes=%d%s", $currentPage, max(0, $pageNum_EvalDes - 1), $queryString_EvalDes); ?>"><img src="Previous.gif" alt="D" border="0" /></a>
        <?php } // Show if not first page ?>
    </td>
    <td align="center"><?php if ($pageNum_EvalDes < $totalPages_EvalDes) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_EvalDes=%d%s", $currentPage, min($totalPages_EvalDes, $pageNum_EvalDes + 1), $queryString_EvalDes); ?>"><img src="Next.gif" alt="C" border="0" /></a>
        <?php } // Show if not last page ?>
    </td>
    <td align="center"><?php if ($pageNum_EvalDes < $totalPages_EvalDes) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_EvalDes=%d%s", $currentPage, $totalPages_EvalDes, $queryString_EvalDes); ?>"><img src="Last.gif" alt="B" border="0" /></a>
        <?php } // Show if not last page ?>
    </td>
  </tr>
</table>
<p>

<table>
  <tr valign="baseline">
    <td width="543" align="right" nowrap="nowrap" bgcolor="#FFFFCC" class="Estilo4"><label>
      <div align="left" onchange="[Evaluado]=[NombCol}">Nombre del colaborador evaluado <br />
        <span class="Estilo41"><?php echo $row_EvalDes['NombCol']; ?></span></div>
    </label></td>
  </tr>
  <tr valign="baseline">
    <td align="right" valign="bottom" nowrap="nowrap" bgcolor="#FFFFCC" class="Estilo4"><div align="left">Nombre del evaluador (jefe inmediato) <br />
        <span class="Estilo41"><?php echo $row_EvalDes['JefCol']; ?></span></div>
    </label></td>
  </tr>
  <tr valign="baseline">
    <td align="right" valign="bottom" nowrap="nowrap" bgcolor="#FFFFCC" class="Estilo4"><div align="left">      Fecha de evaluaci&oacute;n<br />
        <span class="Estilo41"><?php echo $row_EvalDes['FechEval']; ?></span><br />
    </div></td>
  </tr>
</table>
<p>
  <label></label>
  <label></label>
  <label></label>
  <label></label></p>
<table width="795" border="2" bordercolor="#003300" bgcolor="#FFFF99">
  <tr height="20">
    <td colspan="7" bordercolor="#003300" bgcolor="#FFB112" class="Estilo4"><div align="center" class="Estilo25 Estilo26">Calidad de la gesti&oacute;n: Considere el desempe&ntilde;o obtenido por el empleado en su labor.</div></td>
  </tr>
  <tr height="20">
    <td width="195" height="20" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">CALIDAD    DEL TRABAJO<br />
      Eficacia y eficiencia, en la realizaci&oacute;n normal de las    tareas, teniendo un inter&eacute;s por obtener &oacute;ptimos resultados</div></td>
    <td width="180" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Requiere una permanente    supervisi&oacute;n y en general comete muchos errores</div></td>
    <td width="21" align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="center">
      <input <?php if (!(strcmp($row_EvalDes['CaGeCaTr'],"1"))) {echo "checked=\"checked\"";} ?> name="CaGeCaTr" type="radio" value="1" />
    </div></td>
    <td width="145" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Comete algunos    errores y la calidad es regular</div></td>
    <td width="20" align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="center">
      <input <?php if (!(strcmp($row_EvalDes['CaGeCaTr'],"2"))) {echo "checked=\"checked\"";} ?> name="CaGeCaTr" type="radio" value="2" />
    </div></td>
    <td width="163" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">La precisi&oacute;n de    su trabajo permite utilizarlo con confianza</div></td>
    <td width="23" align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="center">
      <input <?php if (!(strcmp($row_EvalDes['CaGeCaTr'],"3"))) {echo "checked=\"checked\"";} ?> name="CaGeCaTr" type="radio" value="3" />
    </div></td>
  </tr>
  <tr height="20">
    <td height="20" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">CONOCIMIENTO    DEL TRABAJO<br />
      Se preocupa por investigar y comprender las tareas y    funciones, aplicando las t&eacute;cnicas y m&eacute;todos pertinentes para realizarlas</div></td>
    <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">No muestra ning&uacute;n inter&eacute;s en    conocer mejor su trabajo</div></td>
    <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="center">
      <input <?php if (!(strcmp($row_EvalDes['CaGeCoTr'],"1"))) {echo "checked=\"checked\"";} ?> name="CaGeCoTr" type="radio" value="1" />
    </div></td>
    <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Se preocupa poco    por actualizar su conocimiento de tareas y m&eacute;todos</div></td>
    <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="center">
      <input <?php if (!(strcmp($row_EvalDes['CaGeCoTr'],"2"))) {echo "checked=\"checked\"";} ?> name="CaGeCoTr" type="radio" value="2" />
    </div></td>
    <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Esta al d&iacute;a con    el conocimiento requerido para hacer efectivamente su trabajo</div></td>
    <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="center">
      <input <?php if (!(strcmp($row_EvalDes['CaGeCoTr'],"3"))) {echo "checked=\"checked\"";} ?> name="CaGeCoTr" type="radio" value="3" />
    </div></td>
  </tr>
  <tr height="20">
    <td height="20" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">INICIATIVA<br />
      Encuentra soluciones r&aacute;pidas y mejores a los problemas    de su trabajo con el fin de agilizarlo y ser productivo</div></td>
    <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">No busca soluciones y muestra    mucha pasividad para hallarlas</div></td>
    <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="center">
      <input <?php if (!(strcmp($row_EvalDes['CaGeInic'],"1"))) {echo "checked=\"checked\"";} ?> name="CaGeInic" type="radio" value="1" />
    </div></td>
    <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Casi siempre    necesita orientaci&oacute;n para hallar las soluciones pertinentes</div></td>
    <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="center">
      <input <?php if (!(strcmp($row_EvalDes['CaGeInic'],"2"))) {echo "checked=\"checked\"";} ?> name="CaGeInic" type="radio" value="2" />
    </div></td>
    <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Genera    frecuentemente soluciones pr&aacute;cticas y efectivas para lograr productividad</div></td>
    <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="center">
      <input <?php if (!(strcmp($row_EvalDes['CaGeInic'],"3"))) {echo "checked=\"checked\"";} ?> name="CaGeInic" type="radio" value="3" />
    </div></td>
  </tr>
  <tr height="20">
    <td height="20" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">DISPOSICI&Oacute;N    PARA APRENDER<br />
      Receptividad para adquirir nuevos conocimientos y    adaptarse a nuevos procedimientos</div></td>
    <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">No se preocupa por adquirir nuevos    conocimientos&nbsp; a pesar que se le    transmiten detalladamente</div></td>
    <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><input <?php if (!(strcmp($row_EvalDes['CaGeDiAp'],"1"))) {echo "checked=\"checked\"";} ?> name="CaGeDiAp" type="radio" value="1" /></td>
    <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Se le debe    motivar para que adquiera nuevos conocimientos y muestra resistencia</div></td>
    <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><input <?php if (!(strcmp($row_EvalDes['CaGeDiAp'],"2"))) {echo "checked=\"checked\"";} ?> name="CaGeDiAp" type="radio" value="2" /></td>
    <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Muestra un alto    inter&eacute;s en nuevos conocimientos y reacciona positivamente a los nuevos    procedimientos</div></td>
    <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><input <?php if (!(strcmp($row_EvalDes['CaGeDiAp'],"3"))) {echo "checked=\"checked\"";} ?> name="CaGeDiAp" type="radio" value="3" /></td>
  </tr>
  <tr height="20">
    <td height="20" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">ORGANIZACI&Oacute;N    EN EL TRABAJO<br />
      Capacidad para determinar y coordinar las acciones    necesarias para realizar efectivamente el trabajo</div></td>
    <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">No tiene orden ni m&eacute;todo para    realizar su trabajo</div></td>
    <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><input <?php if (!(strcmp($row_EvalDes['CaGeOrTR'],"1"))) {echo "checked=\"checked\"";} ?> name="CaGeOrTR" type="radio" value="1" /></td>
    <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Muestra    dificultades para planear y realizar ordenadamente su trabajo</div></td>
    <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><input <?php if (!(strcmp($row_EvalDes['CaGeOrTR'],"2"))) {echo "checked=\"checked\"";} ?> name="CaGeOrTR" type="radio" value="2" /></td>
    <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Planea y realiza    su trabajo ordenada y efectivamente</div></td>
    <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><input <?php if (!(strcmp($row_EvalDes['CaGeOrTR'],"3"))) {echo "checked=\"checked\"";} ?> name="CaGeOrTR" type="radio" value="3" /></td>
  </tr>
  <tr height="20">
    <td height="20" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">MANEJO DE    INFORMACI&Oacute;N CON CONFIDENCIALIDAD<br />
      Es prudente con la informaci&oacute;n que maneja y la    transmite a las instancias pertinentes</div></td>
    <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Divulga la informaci&oacute;n    indiscriminadamente llevando a la desconfianza de los dem&aacute;s</div></td>
    <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><input <?php if (!(strcmp($row_EvalDes['CaGeMaIn'],"1"))) {echo "checked=\"checked\"";} ?> name="CaGeMaIn" type="radio" value="1" /></td>
    <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">En ciertos casos    es imprudente con la divulgaci&oacute;n de informaci&oacute;n</div></td>
    <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><input <?php if (!(strcmp($row_EvalDes['CaGeMaIn'],"2"))) {echo "checked=\"checked\"";} ?> name="CaGeMaIn" type="radio" value="2" /></td>
    <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Muestra alta    confiabilidad en el manejo de la informaci&oacute;n</div></td>
    <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><input <?php if (!(strcmp($row_EvalDes['CaGeMaIn'],"3"))) {echo "checked=\"checked\"";} ?> name="CaGeMaIn" type="radio" value="3" /></td>
  </tr>
  <tr height="20">
    <td height="20" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">ATENCI&Oacute;N    AL CLIENTE<br />
      Muestra cordialidad, efectividad y disposici&oacute;n para    atender a los dem&aacute;s</div></td>
    <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Es negligente y desatento en la    atenci&oacute;n de los dem&aacute;s</div></td>
    <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><input <?php if (!(strcmp($row_EvalDes['CaGeAtCl'],"1"))) {echo "checked=\"checked\"";} ?> name="CaGeAtCl" type="radio" value="1" /></td>
    <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Le falta un poco    de amabilidad y diligencia al atender a los dem&aacute;s</div></td>
    <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><input <?php if (!(strcmp($row_EvalDes['CaGeAtCl'],"2"))) {echo "checked=\"checked\"";} ?> name="CaGeAtCl" type="radio" value="2" /></td>
    <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Brinda una    respuesta amable y efectiva al atender a los dem&aacute;s</div></td>
    <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><input <?php if (!(strcmp($row_EvalDes['CaGeAtCl'],"3"))) {echo "checked=\"checked\"";} ?> name="CaGeAtCl" type="radio" value="3" /></td>
  </tr>
  <tr>
    <td height="20" colspan="7" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left"></div>
        <div align="left"></div>
      <div align="center"></div>
      <div align="left"></div>
      <div align="center"></div>
      <div align="left"></div>
      <div align="center"></div></td>
  </tr>
  <tr>
    <td height="20" colspan="7" bordercolor="#003300" bgcolor="#FFB112" class="Estilo28"><div align="center">Facilitadores de desempe&ntilde;o: Considere aquellas caracter&iacute;sticas individuales que posee el empleado para facilitar el buen desempe&ntilde;o laboral dentro y fuera del cargo.</div></td>
  </tr>
  <tr>
    <td height="20" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">CUMPLIMIENTO    OPORTUNO DE TAREAS ASIGNADAS Y PUNTUALIDAD<br />
      Responsabilidad, dedicaci&oacute;n y puntualidad en las tareas    y los horarios</div></td>
    <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Con frecuencia se retarda y pierde    tiempo en su trabajo</div></td>
    <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="center">
      <input <?php if (!(strcmp($row_EvalDes['FaDeCuOp'],"1"))) {echo "checked=\"checked\"";} ?> name="FaDeCuOp" type="radio" value="1" />
    </div></td>
    <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Rara vez incumple    con sus tareas o sus horarios</div></td>
    <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="center">
      <input <?php if (!(strcmp($row_EvalDes['FaDeCuOp'],"2"))) {echo "checked=\"checked\"";} ?> name="FaDeCuOp" type="radio" value="2" />
    </div></td>
    <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Es ejemplo de    puntualidad y cumplimiento de tareas</div></td>
    <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="center">
      <input <?php if (!(strcmp($row_EvalDes['FaDeCuOp'],"3"))) {echo "checked=\"checked\"";} ?> name="FaDeCuOp" type="radio" value="3" />
    </div></td>
  </tr>
  <tr>
    <td height="20" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">COOPERACI&Oacute;N<br />
      Disposici&oacute;n de colaborar con los dem&aacute;s, aunque no sea    parte de sus obligaciones, aportando al trabajo en equipo</div></td>
    <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">No colabora ni ayuda a los dem&aacute;s y    pone obst&aacute;culos para hacerlo</div></td>
    <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="center">
      <input <?php if (!(strcmp($row_EvalDes['FaDeCoop'],"1"))) {echo "checked=\"checked\"";} ?> name="FaDeCoop" type="radio" value="1" />
    </div></td>
    <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Algunas    veces&nbsp; colabora con actividades que no    corresponden a su trabajo</div></td>
    <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="center">
      <input <?php if (!(strcmp($row_EvalDes['FaDeCoop'],"2"))) {echo "checked=\"checked\"";} ?> name="FaDeCoop" type="radio" value="2" />
    </div></td>
    <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Siempre esta    dispuesto a colaborar, incluso si debe hacer esfuerzos extra</div></td>
    <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="center">
      <input <?php if (!(strcmp($row_EvalDes['FaDeCoop'],"3"))) {echo "checked=\"checked\"";} ?> name="FaDeCoop" type="radio" value="3" />
    </div></td>
  </tr>
  <tr>
    <td height="20" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">COMUNICACI&Oacute;N<br />
      Establece canales de comunicaci&oacute;n con las personas para    lograr efectividad en el trabajo y se relaciona socialmente con los dem&aacute;s</div></td>
    <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Es una persona aislada, prefiere    no hablar con los dem&aacute;s y se muestra pasiva en la relaci&oacute;n social</div></td>
    <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="center">
      <input <?php if (!(strcmp($row_EvalDes['FaDeComu'],"1"))) {echo "checked=\"checked\"";} ?> name="FaDeComu" type="radio" value="1" />
    </div></td>
    <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Establece    contacto con los dem&aacute;s para lo que es estrictamente necesario</div></td>
    <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="center">
      <input <?php if (!(strcmp($row_EvalDes['FaDeComu'],"2"))) {echo "checked=\"checked\"";} ?> name="FaDeComu" type="radio" value="2" />
    </div></td>
    <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Establece    excelentes canales de comunicaci&oacute;n tanto laborales como sociales</div></td>
    <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="center">
      <input <?php if (!(strcmp($row_EvalDes['FaDeComu'],"3"))) {echo "checked=\"checked\"";} ?> name="FaDeComu" type="radio" value="3" />
    </div></td>
  </tr>
  <tr>
    <td height="20" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">ADAPTABILIDAD<br />
      Capacidad de aceptar los cambios y trabajar para que    tengan &eacute;xito</div></td>
    <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Muestra resistencia ante los    cambios y no colabora para su &eacute;xito</div></td>
    <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="center">
      <input <?php if (!(strcmp($row_EvalDes['FaDeAdap'],"1"))) {echo "checked=\"checked\"";} ?> name="FaDeAdap" type="radio" value="1" />
    </div></td>
    <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Muestra    aceptaci&oacute;n de los cambios pero no colabora para su &eacute;xito</div></td>
    <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="center">
      <input <?php if (!(strcmp($row_EvalDes['FaDeAdap'],"2"))) {echo "checked=\"checked\"";} ?> name="FaDeAdap" type="radio" value="2" />
    </div></td>
    <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Acepta los    cambios y genera estrategias para que tengan &eacute;xito</div></td>
    <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="center">
      <input <?php if (!(strcmp($row_EvalDes['FaDeAdap'],"3"))) {echo "checked=\"checked\"";} ?> name="FaDeAdap" type="radio" value="3" />
    </div></td>
  </tr>
  <tr>
    <td height="20" colspan="7" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left"></div>
        <div align="left"></div>
      <div align="center"></div>
      <div align="left"></div>
      <div align="center"></div>
      <div align="left"></div>
      <div align="center"></div></td>
  </tr>
  <tr>
    <td height="20" colspan="7" bordercolor="#003300" bgcolor="#FFB112" class="Estilo24"><div align="center" class="Estilo30">Compromiso Institucional: Considere la participaci&oacute;n del empleado en diferentes actividades de la Universidad. </div>
        <div align="left"></div>
      <div align="center"></div>
      <div align="left"></div>
      <div align="center"></div>
      <div align="left"></div>
      <div align="center"></div></td>
  </tr>
  <tr height="20">
    <td height="20" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">PARTICIPACI&Oacute;N    EN ACTIVIDADES<br />
      Se integra y participa en los eventos de la    Universidad&nbsp;</div></td>
    <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Muestra desinter&eacute;s ante las&nbsp; actividades de la Universidad y en general    no asiste</div></td>
    <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="center">
      <input <?php if (!(strcmp($row_EvalDes['CoInPaAc'],"1"))) {echo "checked=\"checked\"";} ?> name="CoInPaAc" type="radio" value="1" />
    </div></td>
    <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Rara vez asiste a    las actividades de la Universidad o no participa mucho</div></td>
    <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="center">
      <input <?php if (!(strcmp($row_EvalDes['CoInPaAc'],"2"))) {echo "checked=\"checked\"";} ?> name="CoInPaAc" type="radio" value="2" />
    </div></td>
    <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">En general asiste    y disfruta las actividades de la Universidad</div></td>
    <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="center">
      <input <?php if (!(strcmp($row_EvalDes['CoInPaAc'],"3"))) {echo "checked=\"checked\"";} ?> name="CoInPaAc" type="radio" value="3" />
    </div></td>
  </tr>
  <tr height="20">
    <td height="20" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">SENTIDO DE    PERTENENCIA<br />
      Muestra compromiso con los objetivos de la Universidad    y orgullo de pertenecer a ella</div></td>
    <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Su comportamiento revela falta de    inter&eacute;s en la Universidad, sus objetivos y sus procesos</div></td>
    <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="center">
      <input <?php if (!(strcmp($row_EvalDes['CoInSePe'],"1"))) {echo "checked=\"checked\"";} ?> name="CoInSePe" type="radio" value="1" />
    </div></td>
    <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Hace pocos    esfuerzos por lograr la mejora de la Universidad</div></td>
    <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="center">
      <input <?php if (!(strcmp($row_EvalDes['CoInSePe'],"2"))) {echo "checked=\"checked\"";} ?> name="CoInSePe" type="radio" value="2" />
    </div></td>
    <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Hace de la    Universidad parte de su vida y lo disfruta</div></td>
    <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="center">
      <input <?php if (!(strcmp($row_EvalDes['CoInSePe'],"3"))) {echo "checked=\"checked\"";} ?> name="CoInSePe" type="radio" value="3" />
    </div></td>
  </tr>
  <tr height="20">
    <td height="20" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">CONCIENCIA    ORGANIZACIONAL<br />
      Identificaci&oacute;n y cumplimiento de pol&iacute;ticas y normas de    la Universidad</div></td>
    <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Hace las cosas como quiere sin    respetar reglamentos ni pol&iacute;ticas</div></td>
    <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="center">
      <input <?php if (!(strcmp($row_EvalDes['CoInCoOr'],"1"))) {echo "checked=\"checked\"";} ?> name="CoInCoOr" type="radio" value="1" />
    </div></td>
    <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Presenta    dificultades en el cumplimiento de normas y pol&iacute;ticas</div></td>
    <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="center">
      <input <?php if (!(strcmp($row_EvalDes['CoInCoOr'],"2"))) {echo "checked=\"checked\"";} ?> name="CoInCoOr" type="radio" value="2" />
    </div></td>
    <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Cumple a    cabalidad las normas y pol&iacute;ticas</div></td>
    <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="center">
      <input <?php if (!(strcmp($row_EvalDes['CoInCoOr'],"3"))) {echo "checked=\"checked\"";} ?> name="CoInCoOr" type="radio" value="3" />
    </div></td>
  </tr>
  <tr height="20">
    <td height="20" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24">&nbsp;
        <div align="left">PRESENTACI&Oacute;N PERSONAL<br />
          Imagen personal que denota cuidado, pulcritud y manejo    adecuado del uniforme y la dotaci&oacute;n</div></td>
    <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">En general presenta una imagen    descuidada en la vestimenta y su arreglo personal</div></td>
    <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="center">
      <input <?php if (!(strcmp($row_EvalDes['CoInPrPe'],"1"))) {echo "checked=\"checked\"";} ?> name="CoInPrPe" type="radio" value="1" />
    </div></td>
    <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">En algunos casos    descuida su imagen y el uso del uniforme</div></td>
    <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="center">
      <input <?php if (!(strcmp($row_EvalDes['CoInPrPe'],"2"))) {echo "checked=\"checked\"";} ?> name="CoInPrPe" type="radio" value="2" />
    </div></td>
    <td bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left">Siempre est&aacute; en    &oacute;ptimas condiciones de presentaci&oacute;n y utiliza adecuadamente el uniforme</div></td>
    <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="center">
      <input <?php if (!(strcmp($row_EvalDes['CoInPrPe'],"3"))) {echo "checked=\"checked\"";} ?> name="CoInPrPe" type="radio" value="3" />
    </div></td>
  </tr>
  <tr>
    <td height="20" colspan="7" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo24"><div align="left"></div>
        <div align="left"></div>
      <div align="center"></div>
      <div align="left"></div>
      <div align="center"></div>
      <div align="left"></div>
      <div align="center"></div></td>
  </tr>
  <tr>
    <td height="20" colspan="7" bordercolor="#003300" bgcolor="#FFB112" class="Estilo28"><div align="center">PLAN DE MEJORAMIENTO</div></td>
  </tr>
  <tr>
    <td height="20" colspan="7" bordercolor="#596221" bgcolor="#FFFFCC" class="Estilo24"><div align="center">
      <p>FORTALEZAS<br />
        <br />
        <span class="Estilo41"><?php echo $row_EvalDes['PlMeFort']; ?></span></p>
      </div></td>
  </tr>
  <tr>
    <td height="20" colspan="7" bordercolor="#596221" bgcolor="#FFFFCC" class="Estilo24"><div align="center">
      <p>ASPECTOS POR MEJORAR<br />
        <br />
            <span class="Estilo41"><?php echo $row_EvalDes['PlMeAsMe']; ?></span></p>
      </div></td>
  </tr>
  <tr>
    <td height="20" colspan="7" bordercolor="#596221" bgcolor="#FFFFCC" class="Estilo24"><div align="center">
      <p>COMPROMISOS ADQUIRIDOS POR EL COLABORADOR PARA EL PLAN DE MEJORAMIENTO<br />
        <br />
        &nbsp;<span class="Estilo41"><?php echo $row_EvalDes['PlMePlMe']; ?> </span></p>
      </div></td>
  </tr>
  <tr>
    <td height="20" colspan="7" bordercolor="#596221" bgcolor="#FFFFCC" class="Estilo24"><div align="center">PLAZO ACORDADO PARA EL PLAN DE MEJORAMIENTO<br />
      <br />
      <span class="Estilo41"><?php echo $row_EvalDes['PlMePlAc']; ?></span></div></td>
  </tr>
  <tr>
    <td height="20" colspan="7" bordercolor="#596221" bgcolor="#FFFFCC" class="Estilo24"><div align="center">SI EST&Aacute; EVALUANDO UNA PERSONA <span class="Estilo40">CONTRATADA A T&Eacute;RMINO FIJO</span> , SEG&Uacute;N USTED &iquest;ESTA PERSONA DEBE O NO SER CONTRATADA PARA CONTINUAR LABORANDO EN LA INSTITUCI&Oacute;N?. EN CASO DE SER NEGATIVA SU RESPUESTA, EXPLIQUE POR FAVOR EL MOTIVO DE ESTA DECISI&Oacute;N<br />
      <br />
      <span class="Estilo41"><?php echo $row_EvalDes['CoGePeTf']; ?></span></div></td>
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
    <td width="291" bordercolor="#596221" bgcolor="#FFFFCC" class="Estilo4"><div align="center">Jefe de Talento Humano </div></td>
    <td width="203" bordercolor="#596221" bgcolor="#FFFFCC" class="Estilo4"><div align="center">Nombre del evaluador</div></td>
    <td width="281" bordercolor="#596221" bgcolor="#FFFFCC" class="Estilo4"><div align="center">Nombre del evaluado </div></td>
  </tr>
  <tr>
    <td bordercolor="#596221" bgcolor="#FFFFCC" class="Estilo41"><div align="center"><?php echo $row_EvalDes['JefeTH']; ?></div></td>
    <td bordercolor="#596221" bgcolor="#FFFFCC" class="Estilo41"><div align="center" class="Estilo41"><?php echo $row_EvalDes['Evaluador']; ?></div></td>
    <td bordercolor="#596221" bgcolor="#FFFFCC" class="Estilo41"><div align="center" class="Estilo41"><?php echo $row_EvalDes['Evaluado']; ?></div></td>
  </tr>
  <tr>
    <td colspan="3" bordercolor="#596221" bgcolor="#FFFFCC" class="Estilo33"><p align="center" class="Estilo40">Por favor revise que no haya dejado nada sin contestar. <br />
      Muchas gracias por su colaboraci&oacute;n en la construcci&oacute;n de un mejor equipo</p></td>
  </tr>
</table>
<p></p>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($EvalDes);
?>
