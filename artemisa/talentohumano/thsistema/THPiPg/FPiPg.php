<?php require_once('../Connections/conexion.php'); error_reporting(0)?>
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
  $insertSQL = sprintf("INSERT INTO tpipg (CCEvaluado, NoEval, ApEv, FeEva, CarEva, DivCar, P1, N1, P2, N2, P3, N3, P4, N4, P5, N5, P6, N6, P7, N7, P8, N8, P9, N9, P10, N10, P11, N11, P12, N12, P13, N13, P14, N14, P15, N15, P16, N16, P17, N17, P18, N18, P19, N19, P20, N20, P21, N21, P22, N22, P23, N23, P24, N24, P25, N25, P26, N26, P27, N27, P28, N28, P29, N29, P30, N30, P31, N31, P32, N32, P33, N33, P34, N34, P35, N35, P36, N36, P37, N37, P38, N38) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['CCEvaluado'], "int"),
                       GetSQLValueString($_POST['NoEval'], "text"),
                       GetSQLValueString($_POST['ApEv'], "text"),
                       GetSQLValueString($_POST['FeEva'], "date"),
                       GetSQLValueString($_POST['CarEva'], "text"),
                       GetSQLValueString($_POST['DivCar'], "text"),
					   GetSQLValueString($_POST['P1'], "int"),
                       GetSQLValueString($_POST['N1'], "int"),
                       GetSQLValueString($_POST['P2'], "int"),
                       GetSQLValueString($_POST['N2'], "int"),
                       GetSQLValueString($_POST['P3'], "int"),
                       GetSQLValueString($_POST['N3'], "int"),
                       GetSQLValueString($_POST['P4'], "int"),
                       GetSQLValueString($_POST['N4'], "int"),
                       GetSQLValueString($_POST['P5'], "int"),
                       GetSQLValueString($_POST['N5'], "int"),
                       GetSQLValueString($_POST['P6'], "int"),
                       GetSQLValueString($_POST['N6'], "int"),
                       GetSQLValueString($_POST['P7'], "int"),
                       GetSQLValueString($_POST['N7'], "int"),
                       GetSQLValueString($_POST['P8'], "int"),
                       GetSQLValueString($_POST['N8'], "int"),
                       GetSQLValueString($_POST['P9'], "int"),
                       GetSQLValueString($_POST['N9'], "int"),
                       GetSQLValueString($_POST['P10'], "int"),
                       GetSQLValueString($_POST['N10'], "int"),
                       GetSQLValueString($_POST['P11'], "int"),
                       GetSQLValueString($_POST['N11'], "int"),
                       GetSQLValueString($_POST['P12'], "int"),
                       GetSQLValueString($_POST['N12'], "int"),
                       GetSQLValueString($_POST['P13'], "int"),
                       GetSQLValueString($_POST['N13'], "int"),
                       GetSQLValueString($_POST['P14'], "int"),
                       GetSQLValueString($_POST['N14'], "int"),
                       GetSQLValueString($_POST['P15'], "int"),
                       GetSQLValueString($_POST['N15'], "int"),
                       GetSQLValueString($_POST['P16'], "int"),
                       GetSQLValueString($_POST['N16'], "int"),
                       GetSQLValueString($_POST['P17'], "int"),
                       GetSQLValueString($_POST['N17'], "int"),
                       GetSQLValueString($_POST['P18'], "int"),
                       GetSQLValueString($_POST['N18'], "int"),
                       GetSQLValueString($_POST['P19'], "int"),
                       GetSQLValueString($_POST['N19'], "int"),
                       GetSQLValueString($_POST['P20'], "int"),
                       GetSQLValueString($_POST['N20'], "int"),
                       GetSQLValueString($_POST['P21'], "int"),
                       GetSQLValueString($_POST['N21'], "int"),
                       GetSQLValueString($_POST['P22'], "int"),
                       GetSQLValueString($_POST['N22'], "int"),
                       GetSQLValueString($_POST['P23'], "int"),
                       GetSQLValueString($_POST['N23'], "int"),
                       GetSQLValueString($_POST['P24'], "int"),
                       GetSQLValueString($_POST['N24'], "int"),
                       GetSQLValueString($_POST['P25'], "int"),
                       GetSQLValueString($_POST['N25'], "int"),
                       GetSQLValueString($_POST['P26'], "int"),
                       GetSQLValueString($_POST['N26'], "int"),
                       GetSQLValueString($_POST['P27'], "int"),
                       GetSQLValueString($_POST['N27'], "int"),
                       GetSQLValueString($_POST['P28'], "int"),
                       GetSQLValueString($_POST['N28'], "int"),
                       GetSQLValueString($_POST['P29'], "int"),
                       GetSQLValueString($_POST['N29'], "int"),
                       GetSQLValueString($_POST['P30'], "int"),
                       GetSQLValueString($_POST['N30'], "int"),
                       GetSQLValueString($_POST['P31'], "int"),
                       GetSQLValueString($_POST['N31'], "int"),
                       GetSQLValueString($_POST['P32'], "int"),
                       GetSQLValueString($_POST['N32'], "int"),
                       GetSQLValueString($_POST['P33'], "int"),
                       GetSQLValueString($_POST['N33'], "int"),
                       GetSQLValueString($_POST['P34'], "int"),
                       GetSQLValueString($_POST['N34'], "int"),
                       GetSQLValueString($_POST['P35'], "int"),
                       GetSQLValueString($_POST['N35'], "int"),
                       GetSQLValueString($_POST['P36'], "int"),
                       GetSQLValueString($_POST['N36'], "int"),
                       GetSQLValueString($_POST['P37'], "int"),
                       GetSQLValueString($_POST['N37'], "int"),
                       GetSQLValueString($_POST['P38'], "int"),
                       GetSQLValueString($_POST['N38'], "int"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<style type="text/css">
<!--
.Estilo1 {font-size: 36px}
.Estilo22 {color: #FFFFFF; font-weight: bold; }
.Estilo4 {font-family: Tahoma;
	color: #596221;
	font-weight: bold;
}
.Estilo26 {color: #FF0000}
.Estilo27 {font-size: 24px; }
.Estilo28 {font-size: 14px}
.Estilo29 {color: #FF0000; font-size: 14px; }
.Estilo30 {font-size: 36px; color: #596221; }
.Estilo32 {color: #596221; }
.Estilo34 {font-size: 24px; color: #596221; font-weight: bold; }
.Estilo35 {font-family: Tahoma}
.Estilo38 {color: #FFFFCC; font-size: 10px; }
.Estilo39 {font-size: 25px}
.Estilo40 {
	color: #FF0000;
	font-size: 25px;
	font-weight: bold;
}
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
<p>&nbsp;</p>
<table width="838" border="0">
  <tr>
    <td width="155" height="72" bgcolor="#98BD0D"><div align="center" class="Estilo22"><img src="../IMAGENES/LOGOBOSQUETH.jpg" alt="as" width="138" height="62" /></div></td>
    <td width="673" bgcolor="#98BD0D"><div align="center" class="Estilo4">
      <p>SISTEMA DE EVALUACI&Oacute;N DE CANDIDATOS<br />
        PERFIL - INVENTARIO DE PERSONALIDAD
      - P-IPG </p>
      </div></td>
  </tr>
</table>
<table width="838" border="0">
  <tr>
    <td width="832" bgcolor="#FFB112"><div align="center" class="Estilo4">DEPARTAMENTO DE TALENTO HUMANO - CONSTRUYENDO UN MEJOR EQUIPO </div></td>
  </tr>
</table>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <p>&nbsp;</p>
  <table width="840" border="1" bordercolor="#FF99FF" bgcolor="#FFFFCC">
    <tr>
      <td colspan="6" align="right" valign="baseline" nowrap="nowrap" bgcolor="#FFFFCC" class="Estilo4"><div align="center">Apreciado candidato, por favor responda la siguiente informaci&oacute;n</div></td>
    </tr>
    <tr>
      <td align="right" valign="baseline" nowrap="nowrap" class="Estilo4">C&eacute;dula:</td>
      <td valign="baseline" class="Estilo4"><input type="text" name="CCEvaluado" value="" size="32" /></td>
      <td valign="baseline" class="Estilo4">&nbsp;</td>
      <td colspan="3" valign="baseline" class="Estilo4">&nbsp;</td>
    </tr>
    <tr>
      <td align="right" valign="baseline" nowrap="nowrap" class="Estilo4">Nombres:</td>
      <td valign="baseline" class="Estilo4"><input type="text" name="NoEval" value="" size="32" /></td>
      <td valign="baseline" nowrap="nowrap" class="Estilo4"><div align="right">Apellidos:</div></td>
      <td colspan="3" valign="baseline" class="Estilo4"><input type="text" name="ApEv" value="" size="32" /></td>
    </tr>
    <tr>
      <td align="right" valign="baseline" nowrap="nowrap" class="Estilo4">Fecha Evaluaci&oacute;n :</td>
      <td valign="baseline" class="Estilo4"><input type="text" name="FeEva" value="" size="32" /></td>
      <td colspan="4" valign="baseline" nowrap="nowrap" class="Estilo4"><div align="left">a&ntilde;o-mes-dia Ej: 2010-12-03 </div></td>
    </tr>
    <tr>
      <td align="right" valign="baseline" nowrap="nowrap" class="Estilo4">Cargo al que aplica :</td>
      <td valign="baseline" class="Estilo4"><input type="text" name="CarEva" value="" size="32" /></td>
      <td valign="baseline" nowrap="nowrap" class="Estilo4"><div align="right">Divisi&oacute;n del Cargo </div></td>
      <td colspan="3" valign="baseline" class="Estilo4"><input type="text" name="DivCar" value="" size="32" /></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <table width="840" border="1" bordercolor="#FF99FF" bgcolor="#FFFFCC">

    <tr>
      <td colspan="4" class="Estilo4"><p align="justify" class="Estilo28">En esta prueba encontrar&aacute; varias descripciones de caracter&iacute;sticas personales. Dichas descripciones se agrupan en conjuntos de cuatro. </p>
        <p align="justify" class="Estilo28">Usted debe examinar cada conjunto y elegir la descripci&oacute;n a la que <span class="Estilo26">usted m&aacute;s se parece</span>, marcando el c&iacute;rculo correspondiente en la columna designada con el <span class="Estilo26">signo  + (M&aacute;s).</span></p>
        <p class="Estilo28">Despu&eacute;s, examine las otras tres descripciones del grupo y elija aquella a la que <span class="Estilo26">usted menos se parece</span>, marcando el c&iacute;rculo correspondiente en la columna designada con el <span class="Estilo26">signo  - (Menos).</span></p>
        <p class="Estilo28">No marque ninguna de las opciones restantes. Observe el ejemplo. </p></td>
    </tr>
    
    <tr>
      <td colspan="2" class="Estilo4"><div align="right">no marque nada en estas opciones, s&oacute;lo observe el ejemplo </div></td>
      <td><div align="center" class="Estilo26"><strong><span class="Estilo1">+</span></strong></div></td>
      <td><div align="center" class="Estilo26"><strong><span class="Estilo1">-</span></strong></div></td>
    </tr>
    <tr>
      <td width="168" rowspan="4" class="Estilo4"><div align="center" class="Estilo27">Ejemplo:</div></td>
      <td width="564" class="Estilo4">Tiene excelente apetito </td>
      <td class="Estilo4"><div align="center">
          <input name="a" type="radio" value="radiobutton" />
      </div></td>
      <td class="Estilo4"><div align="center">
          <input name="b" type="radio" value="radiobutton" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">Se enferma con frecuencia </td>
      <td class="Estilo4"><div align="center">
        <input name="c" type="radio" value="radiobutton" />
      </div></td>
      <td class="Estilo4"><div align="center">
        <input name="d" type="radio" value="radiobutton" checked="checked" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">Sigue una dieta balanceada </td>
      <td class="Estilo4"><div align="center">
        <input name="e" type="radio" value="radiobutton" />
      </div></td>
      <td class="Estilo4"><div align="center">
        <input name="f" type="radio" value="radiobutton" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">No hace suficiente ejercicio </td>
      <td class="Estilo4"><div align="center">
        <input name="g" type="radio" value="radiobutton" checked="checked" />
      </div></td>
      <td class="Estilo4"><div align="center">
        <input name="h" type="radio" value="radiobutton" />
      </div></td>
    </tr>
    <tr>
      <td colspan="4" class="Estilo4"><p class="Estilo28">Suponga que despu&eacute;s de leer las cuatro afirmaciones del ejemplo, decidi&oacute; que, aun cuando varias se aplican a usted, &quot;no hace suficiente ejercicio&quot; es a la que m&aacute;s se parece. Por tanto, marcar&aacute; el c&iacute;rculo correspondiente en la columna designada con el <span class="Estilo26">signo  +</span>, como se encuentra en el ejemplo.</p>
        <p class="Estilo28">Luego, examine las otras tres afirmaciones y decida cu&aacute;l es a la que usted menos se parece. Suponga que &quot;se enferma con frecuencia&quot; se le parece menos que las otras dos. Marcar&aacute; el c&iacute;rculo correspondiente en la columna designada con el <span class="Estilo26">signo -</span> como se muestra en el ejemplo.</p>
        <p class="Estilo29">Para cada grupo s&oacute;lo debe existir una marca en la columna +, y una marca en la columna -. No deben existir marcas en las dos afirmaciones restantes. <u>Tenga cuidado de no marcar + y - para la misma afirmaci&oacute;n.</u></p>
        <p class="Estilo28">En algunos casos le ser&aacute; dif&iacute;cil decidir cu&aacute;l de las afirmaciones deber&aacute; marcar. Tome las mejores decisiones que pueda. <span class="Estilo26">No existen respuestas correctas o incorrectas</span>. En cada grupo deber&aacute; marcar &uacute;nicamente dos afirmaciones en la manera en que se apliquen a usted. Aseg&uacute;rese de marcar una afirmaci&oacute;n como a la que m&aacute;s se parece y una como a la que menos se parece. Deje las dos afirmaciones restantes sin marcar. Haga lo mismo con cada grupo y no omita ninguno de ellos.</p>
        <p class="Estilo28">Ahora comience con el primer grupo.  </p>
        <p class="Estilo28">&nbsp; </p></td>
    </tr>
    
    <tr>
      <td colspan="2">&nbsp;</td>
      <td><div align="center" class="Estilo26"><strong><span class="Estilo1">+</span></strong></div></td>
      <td><div align="center" class="Estilo26"><strong><span class="Estilo1">-</span></strong></div></td>
    </tr>
    <tr>
      <td rowspan="4" bordercolor="#FF99FF" class="Estilo4"><div align="center" class="Estilo30">
          <div align="center" class="Estilo34">1</div>
      </div></td>
      <td bordercolor="#FF99FF" class="Estilo4"><div align="left">es bastante sociable </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P1" type="radio" value="1" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N1" type="radio" value="1" />
      </div></td>
    </tr>
    <tr>
      <td bordercolor="#FF99FF" class="Estilo4">le falta confianza en s&iacute; mismo(a) </td>
      <td width="40" bordercolor="#FF99FF"><div align="center">
        <input name="P1" type="radio" value="2" />
      </div></td>
      <td width="40" bordercolor="#FF99FF"><div align="center">
        <input name="N1" type="radio" value="2" />
      </div></td>
    </tr>
    <tr>
      <td bordercolor="#FF99FF" class="Estilo4">es perfeccionista con cualquier trabajo que realiza </td>
      <td width="40" bordercolor="#FF99FF"><div align="center">
        <input name="P1" type="radio" value="3" />
      </div></td>
      <td width="40" bordercolor="#FF99FF"><div align="center">
        <input name="N1" type="radio" value="3" />
      </div></td>
    </tr>
    <tr>
      <td bordercolor="#FF99FF" class="Estilo4">tiende a ser algo emocional </td>
      <td width="40" bordercolor="#FF99FF"><div align="center">
        <input name="P1" type="radio" value="4" />
      </div></td>
      <td width="40" bordercolor="#FF99FF"><div align="center">
        <input name="N1" type="radio" value="4" />
      </div></td>
    </tr>
    <tr>
      <td colspan="4" class="Estilo4"><div align="center" class="Estilo32"><span class="Estilo38">x</span></div></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td><div align="center" class="Estilo26 Estilo39"><strong>+</strong></div></td>
      <td><div align="center" class="Estilo40"><strong><span class="Estilo1">-</span></strong></div></td>
    </tr>
    <tr>
      <td rowspan="4" class="Estilo30"><div align="center" class="Estilo35"><span class="Estilo34">2</span></div></td>
      <td class="Estilo4">no le interesa estar con otras personas </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P2" type="radio" value="1" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N2" type="radio" value="1" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">se siente libre de ansiedades y tensiones </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P2" type="radio" value="2" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N2" type="radio" value="2" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">es una persona poco confiable </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P2" type="radio" value="3" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N2" type="radio" value="3" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">toma la conducci&oacute;n en las discusiones de grupo </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P2" type="radio" value="4" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N2" type="radio" value="4" />
      </div></td>
    </tr>
    <tr>
      <td colspan="4" class="Estilo4"><div align="center" class="Estilo32"><span class="Estilo38">x</span></div></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td><div align="center" class="Estilo26 Estilo39"><strong>+</strong></div></td>
      <td><div align="center" class="Estilo40"><strong><span class="Estilo1">-</span></strong></div></td>
    </tr>
    <tr>
      <td rowspan="4" class="Estilo34"><div align="center" class="Estilo35">3</div></td>
      <td class="Estilo4">act&uacute;a de manera nerviosa e inestable </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P3" type="radio" value="1" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N3" type="radio" value="1" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">tiene una gran influencia sobre los dem&aacute;s </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P3" type="radio" value="2" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N3" type="radio" value="2" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">no le gustan las reuniones sociales </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P3" type="radio" value="3" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N3" type="radio" value="3" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">es un(a) trabajador(a) muy persistente y formal </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P3" type="radio" value="4" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N3" type="radio" value="4" />
      </div></td>
    </tr>
    <tr class="Estilo34">
      <td colspan="4" class="Estilo4"><div align="center" class="Estilo32"><span class="Estilo38">x</span></div></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td><div align="center" class="Estilo26 Estilo39"><strong>+</strong></div></td>
      <td><div align="center" class="Estilo40"><strong><span class="Estilo1">-</span></strong></div></td>
    </tr>
    <tr>
      <td rowspan="4" class="Estilo34"><div align="center" class="Estilo35">4</div></td>
      <td class="Estilo4">se le facilita hacer nuevas amistades </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P4" type="radio" value="1" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N4" type="radio" value="1" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">no puede realizar la misma tarea por mucho tiempo </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P4" type="radio" value="2" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N4" type="radio" value="2" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">se f&aacute;cilmente manejado(a) por los dem&aacute;s </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P4" type="radio" value="3" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N4" type="radio" value="3" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">mantiene el autocontrol aun si est&aacute; frustrado(a) </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P4" type="radio" value="4" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N4" type="radio" value="4" />
      </div></td>
    </tr>
    <tr class="Estilo34">
      <td colspan="4" class="Estilo4"><div align="center" class="Estilo32"><span class="Estilo35"></span><span class="Estilo38">x</span></div></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td><div align="center" class="Estilo26 Estilo39"><strong>+</strong></div></td>
      <td><div align="center" class="Estilo40"><strong><span class="Estilo1">-</span></strong></div></td>
    </tr>
    <tr>
      <td rowspan="4" class="Estilo34"><div align="center" class="Estilo35">5</div></td>
      <td class="Estilo4">Es capaz de tomar decisiones importantes sin ayuda </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P5" type="radio" value="1" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N5" type="radio" value="1" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">No se relaciona f&aacute;cilmente con gente desconocida </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P5" type="radio" value="2" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N5" type="radio" value="2" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">tiende a sentirse tenso(a) o muy presionado(a) </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P5" type="radio" value="3" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N5" type="radio" value="3" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">concluye su trabajo a pesar de los problemas </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P5" type="radio" value="4" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N5" type="radio" value="4" />
      </div></td>
    </tr>
    <tr class="Estilo34">
            <td colspan="4" class="Estilo4"><div align="center" class="Estilo32"><span class="Estilo35"></span><span class="Estilo38">x</span></div></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td><div align="center" class="Estilo26 Estilo39"><strong>+</strong></div></td>
      <td><div align="center" class="Estilo40"><strong><span class="Estilo1">-</span></strong></div></td>
    </tr>
    <tr>
      <td rowspan="4" class="Estilo34"><div align="center" class="Estilo35">6</div></td>
      <td class="Estilo4">no le interesa mucho ser sociable </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P6" type="radio" value="1" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N6" type="radio" value="1" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">no toma en serio sus responsabilidades </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P6" type="radio" value="2" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N6" type="radio" value="2" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">se mantiene estable y sereno(a) </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P6" type="radio" value="3" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N6" type="radio" value="3" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">toma el mando en actividades de grupo </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P6" type="radio" value="4" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N6" type="radio" value="4" />
      </div></td>
    </tr>
    <tr class="Estilo34">
            <td colspan="4" class="Estilo4"><div align="center" class="Estilo32"><span class="Estilo35"></span><span class="Estilo38">x</span></div></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td><div align="center" class="Estilo26 Estilo39"><strong>+</strong></div></td>
      <td><div align="center" class="Estilo40"><strong><span class="Estilo1">-</span></strong></div></td>
    </tr>
    <tr>
      <td rowspan="4" class="Estilo34"><div align="center" class="Estilo35">7</div></td>
      <td class="Estilo4">es una persona en quien se puede confiar </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P7" type="radio" value="1" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N7" type="radio" value="1" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">se disgusta f&aacute;cilmente cuando las cosas van mal </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P7" type="radio" value="2" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N7" type="radio" value="2" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">no se siente muy seguro(a) de sus propias opiniones </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P7" type="radio" value="3" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N7" type="radio" value="3" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">prefiere estar cerca de la gente </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P7" type="radio" value="4" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N7" type="radio" value="4" />
      </div></td>
    </tr>
    
    <tr class="Estilo34">
      <td colspan="4" class="Estilo4"><div align="center" class="Estilo32"><span class="Estilo35"></span><span class="Estilo38">x</span></div></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td><div align="center" class="Estilo26 Estilo39"><strong>+</strong></div></td>
      <td><div align="center" class="Estilo40"><strong><span class="Estilo1">-</span></strong></div></td>
    </tr>
    <tr>
      <td rowspan="4" class="Estilo34"><div align="center" class="Estilo35">8</div></td>
      <td class="Estilo4">le resulta f&aacute;cil influir en los dem&aacute;s </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P8" type="radio" value="1" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N8" type="radio" value="1" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">termina su trabajo a pesar de los obst&aacute;culos </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P8" type="radio" value="2" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N8" type="radio" value="2" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">limita sus relaciones sociales a unos cuantos </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P8" type="radio" value="3" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N8" type="radio" value="3" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">tiende a ser una persona m&aacute;s bien nerviosa </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P8" type="radio" value="4" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N8" type="radio" value="4" />
      </div></td>
    </tr>
    <tr class="Estilo34">
      <td colspan="4" class="Estilo4"><div align="center" class="Estilo32"><span class="Estilo35"></span><span class="Estilo38">x</span></div></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td><div align="center" class="Estilo26 Estilo39"><strong>+</strong></div></td>
      <td><div align="center" class="Estilo40"><strong><span class="Estilo1">-</span></strong></div></td>
    </tr>
    <tr>
      <td rowspan="4" class="Estilo34"><div align="center" class="Estilo35">9</div></td>
      <td class="Estilo4">no hace amigos f&aacute;cilmente </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P9" type="radio" value="1" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N9" type="radio" value="1" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">toma parte activa en los asuntos del grupo </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P9" type="radio" value="2" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N9" type="radio" value="2" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">persiste en tareas rutinarias hasta concluirlas </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P9" type="radio" value="3" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N9" type="radio" value="3" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">no se encuentra emocionalmente equilibrado </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P9" type="radio" value="4" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N9" type="radio" value="4" />
      </div></td>
    </tr>
    <tr class="Estilo34">
            <td colspan="4" class="Estilo4"><div align="center" class="Estilo32"><span class="Estilo35"></span><span class="Estilo38">x</span></div></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td><div align="center" class="Estilo26 Estilo39"><strong>+</strong></div></td>
      <td><div align="center" class="Estilo40"><strong><span class="Estilo1">-</span></strong></div></td>
    </tr>
    <tr>
      <td rowspan="4" class="Estilo34"><div align="center" class="Estilo35">10</div></td>
      <td class="Estilo4">se siente seguro(a) en sus relaciones con los dem&aacute;s </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P10" type="radio" value="1" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N10" type="radio" value="1" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">sus sentimientos son heridos f&aacute;cilmente </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P10" type="radio" value="2" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N10" type="radio" value="2" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">tiene h&aacute;bitos de trabajo bien desarrollados </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P10" type="radio" value="3" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N10" type="radio" value="3" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">prefiere conservar un grupo peque&ntilde;o de amigos </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P10" type="radio" value="4" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N10" type="radio" value="4" />
      </div></td>
    </tr>
    <tr class="Estilo34">
           <td colspan="4" class="Estilo4"><div align="center" class="Estilo32"><span class="Estilo35"></span><span class="Estilo38">x</span></div></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td><div align="center" class="Estilo26 Estilo39"><strong>+</strong></div></td>
      <td><div align="center" class="Estilo40"><strong><span class="Estilo1">-</span></strong></div></td>
    </tr>
    <tr>
      <td rowspan="4" class="Estilo34"><div align="center" class="Estilo35">11</div></td>
      <td class="Estilo4">se irrita con facilidad </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P11" type="radio" value="1" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N11" type="radio" value="1" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">es capaz de manejar cualquier situaci&oacute;n </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P11" type="radio" value="2" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N11" type="radio" value="2" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">no le gusta conversar con extra&ntilde;os </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P11" type="radio" value="3" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N11" type="radio" value="3" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">es perfeccionista en el trabajo que realiza </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P11" type="radio" value="4" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N11" type="radio" value="4" />
      </div></td>
    </tr>
    <tr class="Estilo34">
      <td colspan="4" class="Estilo4"><div align="center" class="Estilo32"><span class="Estilo35"></span><span class="Estilo38">x</span></div></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td><div align="center" class="Estilo26 Estilo39"><strong>+</strong></div></td>
      <td><div align="center" class="Estilo40"><strong><span class="Estilo1">-</span></strong></div></td>
    </tr>
    <tr>
      <td rowspan="4" class="Estilo34"><div align="center" class="Estilo35">12</div></td>
      <td class="Estilo4">prefiere no discutir con los dem&aacute;s </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P12" type="radio" value="1" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N12" type="radio" value="1" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">es incapaz de mantener un horario fijo </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P12" type="radio" value="2" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N12" type="radio" value="2" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">es una persona tranquila y serena</td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P12" type="radio" value="3" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N12" type="radio" value="3" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">tiende a ser muy sociable </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P12" type="radio" value="4" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N12" type="radio" value="4" />
      </div></td>
    </tr>
    <tr class="Estilo34">
      <td colspan="4" class="Estilo4"><div align="center" class="Estilo32"><span class="Estilo35"></span><span class="Estilo38">x</span></div></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td><div align="center" class="Estilo26 Estilo39"><strong>+</strong></div></td>
      <td><div align="center" class="Estilo40"><strong><span class="Estilo1">-</span></strong></div></td>
    </tr>
    <tr>
      <td rowspan="4" class="Estilo34"><div align="center" class="Estilo35">13</div></td>
      <td class="Estilo4">se siente libre de inquietudes y preocupaciones </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P13" type="radio" value="1" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N13" type="radio" value="1" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">le falta sentido de responsabilidad </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P13" type="radio" value="2" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N13" type="radio" value="2" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">no le interesa relacionarse con el sexo opuesto</td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P13" type="radio" value="3" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N13" type="radio" value="3" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">es h&aacute;bil para tratar a otras personas </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P13" type="radio" value="4" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N13" type="radio" value="4" />
      </div></td>
    </tr>
    <tr class="Estilo34">
      <td colspan="4" class="Estilo4"><div align="center" class="Estilo32"><span class="Estilo35"></span><span class="Estilo38">x</span></div></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td><div align="center" class="Estilo26 Estilo39"><strong>+</strong></div></td>
      <td><div align="center" class="Estilo40"><strong><span class="Estilo1">-</span></strong></div></td>
    </tr>
    <tr>
      <td rowspan="4" class="Estilo34"><div align="center" class="Estilo35">14</div></td>
      <td class="Estilo4">le resulta f&aacute;cil ser amistoso(a) </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P14" type="radio" value="1" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N14" type="radio" value="1" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">prefiere que otros dirijan las actividades de grupo </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P14" type="radio" value="2" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N14" type="radio" value="2" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">parece estar siempre preocupado(a) </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P14" type="radio" value="3" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N14" type="radio" value="3" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">persevera en un trabajo a pesar de los problemas </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P14" type="radio" value="4" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N14" type="radio" value="4" />
      </div></td>
    </tr>
    <tr class="Estilo34">
      <td colspan="4" class="Estilo4"><div align="center" class="Estilo32"><span class="Estilo35"></span><span class="Estilo38">x</span></div></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td><div align="center" class="Estilo26 Estilo39"><strong>+</strong></div></td>
      <td><div align="center" class="Estilo40"><strong><span class="Estilo1">-</span></strong></div></td>
    </tr>
    <tr>
      <td rowspan="4" class="Estilo34"><div align="center" class="Estilo35">15</div></td>
      <td class="Estilo4">es capaz de cambiar las opiniones de otros </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P15" type="radio" value="1" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N15" type="radio" value="1" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">no le interesa unirse a actividades grupales </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P15" type="radio" value="2" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N15" type="radio" value="2" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">es una persona muy nerviosa </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P15" type="radio" value="3" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N15" type="radio" value="3" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">es muy persistente en el trabajo que realiza </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P15" type="radio" value="4" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N15" type="radio" value="4" />
      </div></td>
    </tr>
    <tr class="Estilo34">
      <td colspan="4" class="Estilo4"><div align="center" class="Estilo32"><span class="Estilo35"></span><span class="Estilo38">x</span></div></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td><div align="center" class="Estilo26 Estilo39"><strong>+</strong></div></td>
      <td><div align="center" class="Estilo40"><strong><span class="Estilo1">-</span></strong></div></td>
    </tr>
    <tr>
      <td rowspan="4" class="Estilo34"><div align="center" class="Estilo35">16</div></td>
      <td class="Estilo4">es calmado(a) y f&aacute;cil de tratar </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P16" type="radio" value="1" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N16" type="radio" value="1" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">no puede perseverar en el trabajo que realiza </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P16" type="radio" value="2" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N16" type="radio" value="2" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">disfruta rode&aacute;ndose de mucha gente</td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P16" type="radio" value="3" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N16" type="radio" value="3" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">no conf&iacute;a mucho en sus propias habilidades </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P16" type="radio" value="4" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N16" type="radio" value="4" />
      </div></td>
    </tr>
    <tr class="Estilo34">
      <td colspan="4" class="Estilo4"><div align="center" class="Estilo32"><span class="Estilo35"></span><span class="Estilo38">x</span></div></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td><div align="center" class="Estilo26 Estilo39"><strong>+</strong></div></td>
      <td><div align="center" class="Estilo40"><strong><span class="Estilo1">-</span></strong></div></td>
    </tr>
    <tr>
      <td rowspan="4" class="Estilo34"><div align="center" class="Estilo35">17</div></td>
      <td class="Estilo4">es una persona totalmente confiable </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P17" type="radio" value="1" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N17" type="radio" value="1" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">no le interesa la compa&ntilde;&iacute;a de la mayor&iacute;a de la gente </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P17" type="radio" value="2" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N17" type="radio" value="2" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">le resulta dif&iacute;cil relajarse </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P17" type="radio" value="3" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N17" type="radio" value="3" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">toma parte activa en las discusiones de grupo </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P17" type="radio" value="4" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N17" type="radio" value="4" />
      </div></td>
    </tr>
    <tr class="Estilo34">
      <td colspan="4" class="Estilo4"><div align="center" class="Estilo32"><span class="Estilo35"></span><span class="Estilo38">x</span></div></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td><div align="center" class="Estilo26 Estilo39"><strong>+</strong></div></td>
      <td><div align="center" class="Estilo40"><strong><span class="Estilo1">-</span></strong></div></td>
    </tr>
    <tr>
      <td rowspan="4" class="Estilo34"><div align="center" class="Estilo35">18</div></td>
      <td class="Estilo4">no se deja vencer f&aacute;cilmente por un problema </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P18" type="radio" value="1" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N18" type="radio" value="1" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">tiende a ser algo nervioso(a) </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P18" type="radio" value="2" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N18" type="radio" value="2" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">carece de seguridad en s&iacute; mismo(a)</td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P18" type="radio" value="3" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N18" type="radio" value="3" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">prefiere pasar el tiempo en compa&ntilde;&iacute;a de otros </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P18" type="radio" value="4" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N18" type="radio" value="4" />
      </div></td>
    </tr>
    <tr class="Estilo34">
      <td colspan="4" class="Estilo4"><div align="center" class="Estilo32"><span class="Estilo35"></span><span class="Estilo38">x</span></div></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td><div align="center" class="Estilo26 Estilo39"><strong>+</strong></div></td>
      <td><div align="center" class="Estilo40"><strong><span class="Estilo1">-</span></strong></div></td>
    </tr>
    <tr>
      <td rowspan="4" class="Estilo34"><div align="center" class="Estilo35">19</div></td>
      <td class="Estilo4">tiene ideas muy originales </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P19" type="radio" value="1" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N19" type="radio" value="1" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">es una persona un poco lenta y despreocupada </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P19" type="radio" value="2" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N19" type="radio" value="2" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">tiende a criticar a los dem&aacute;s </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P19" type="radio" value="3" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N19" type="radio" value="3" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">piensa mucho antes de tomar decisiones </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P19" type="radio" value="4" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N19" type="radio" value="4" />
      </div></td>
    </tr>
    <tr class="Estilo34">
      <td colspan="4" class="Estilo4"><div align="center" class="Estilo32"><span class="Estilo35"></span><span class="Estilo38">x</span></div></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td><div align="center" class="Estilo26 Estilo39"><strong>+</strong></div></td>
      <td><div align="center" class="Estilo40"><strong><span class="Estilo1">-</span></strong></div></td>
    </tr>
    <tr>
      <td rowspan="4" class="Estilo34"><div align="center" class="Estilo35">20</div></td>
      <td class="Estilo4">cree que toda la gente es esencialmente honesta </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P20" type="radio" value="1" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N20" type="radio" value="1" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">le gusta tomar con calma el trabajo o el juego </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P20" type="radio" value="2" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N20" type="radio" value="2" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">tiene una actitud muy inquisitiva </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P20" type="radio" value="3" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N20" type="radio" value="3" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">tiende a actuar impulsivamente </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P20" type="radio" value="4" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N20" type="radio" value="4" />
      </div></td>
    </tr>
    <tr class="Estilo34">
      <td colspan="4" class="Estilo4"><div align="center" class="Estilo32"><span class="Estilo35"></span><span class="Estilo38">x</span></div></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td><div align="center" class="Estilo26 Estilo39"><strong>+</strong></div></td>
      <td><div align="center" class="Estilo40"><strong><span class="Estilo1">-</span></strong></div></td>
    </tr>
    <tr>
      <td rowspan="4" class="Estilo34"><div align="center" class="Estilo35">21</div></td>
      <td class="Estilo4">es una persona muy activa </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P21" type="radio" value="1" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N21" type="radio" value="1" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">no se enoja con los dem&aacute;s </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P21" type="radio" value="2" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N21" type="radio" value="2" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">le disgusta trabajar con problemas complejos y dif&iacute;ciles </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P21" type="radio" value="3" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N21" type="radio" value="3" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">prefiere fiestas animadas a reuniones tranquilas </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P21" type="radio" value="4" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N21" type="radio" value="4" />
      </div></td>
    </tr>
    <tr class="Estilo34">
      <td colspan="4" class="Estilo4"><div align="center" class="Estilo32"><span class="Estilo35"></span><span class="Estilo38">x</span></div></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td><div align="center" class="Estilo26 Estilo39"><strong>+</strong></div></td>
      <td><div align="center" class="Estilo40"><strong><span class="Estilo1">-</span></strong></div></td>
    </tr>
    <tr>
      <td rowspan="4" class="Estilo34"><div align="center" class="Estilo35">22</div></td>
      <td class="Estilo4">disfruta las discusiones filos&oacute;ficas</td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P22" type="radio" value="1" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N22" type="radio" value="1" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">se cansa f&aacute;cilmente </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P22" type="radio" value="2" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N22" type="radio" value="2" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">piensa las cosas con mucho cuidado antes de actuar </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P22" type="radio" value="3" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N22" type="radio" value="3" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">no conf&iacute;a mucho en la gente </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P22" type="radio" value="4" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N22" type="radio" value="4" />
      </div></td>
    </tr>
    <tr class="Estilo34">
      <td colspan="4" class="Estilo4"><div align="center" class="Estilo32"><span class="Estilo35"></span><span class="Estilo38">x</span></div></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td><div align="center" class="Estilo26 Estilo39"><strong>+</strong></div></td>
      <td><div align="center" class="Estilo40"><strong><span class="Estilo1">-</span></strong></div></td>
    </tr>
    <tr>
      <td rowspan="4" class="Estilo34"><div align="center" class="Estilo35">23</div></td>
      <td class="Estilo4">le gusta trabajar principalmente con ideas </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P23" type="radio" value="1" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N23" type="radio" value="1" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">sigue un ritmo lento al realizar sus acciones </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P23" type="radio" value="2" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N23" type="radio" value="2" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">es muy cuidadoso(a) al tomar una decisi&oacute;n</td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P23" type="radio" value="3" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N23" type="radio" value="3" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">l es dif&iacute;cil llevarse bien con algunas personas </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P23" type="radio" value="4" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N23" type="radio" value="4" />
      </div></td>
    </tr>
    <tr class="Estilo34">
      <td colspan="4" class="Estilo4"><div align="center" class="Estilo32"><span class="Estilo35"></span><span class="Estilo38">x</span></div></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td><div align="center" class="Estilo26 Estilo39"><strong>+</strong></div></td>
      <td><div align="center" class="Estilo40"><strong><span class="Estilo1">-</span></strong></div></td>
    </tr>
    <tr>
      <td rowspan="4" class="Estilo34"><div align="center" class="Estilo35">24</div></td>
      <td class="Estilo4">se distingue por arriesgarse </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P24" type="radio" value="1" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N24" type="radio" value="1" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">se irrita f&aacute;cilmente con los dem&aacute;s </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P24" type="radio" value="2" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N24" type="radio" value="2" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">puede hacer mucho en poco tiempo </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P24" type="radio" value="3" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N24" type="radio" value="3" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">emplea bastante tiempo pensando en nuevas ideas </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P24" type="radio" value="4" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N24" type="radio" value="4" />
      </div></td>
    </tr>
    <tr class="Estilo34">
      <td colspan="4" class="Estilo4"><div align="center" class="Estilo32"><span class="Estilo35"></span><span class="Estilo38">x</span></div></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td><div align="center" class="Estilo26 Estilo39"><strong>+</strong></div></td>
      <td><div align="center" class="Estilo40"><strong><span class="Estilo1">-</span></strong></div></td>
    </tr>
    <tr>
      <td rowspan="4" class="Estilo34"><div align="center" class="Estilo35">25</div></td>
      <td class="Estilo4">es una persona muy paciente</td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P25" type="radio" value="1" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N25" type="radio" value="1" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">busca lo emocionante y excitante</td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P25" type="radio" value="2" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N25" type="radio" value="2" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">es capaz de trabajar durante largos lapsos </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P25" type="radio" value="3" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N25" type="radio" value="3" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">prefiere poner en pr&aacute;ctica un proyecto que planearlo </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P25" type="radio" value="4" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N25" type="radio" value="4" />
      </div></td>
    </tr>
    <tr class="Estilo34">
      <td colspan="4" class="Estilo4"><div align="center" class="Estilo32"><span class="Estilo35"></span><span class="Estilo38">x</span></div></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td><div align="center" class="Estilo26 Estilo39"><strong>+</strong></div></td>
      <td><div align="center" class="Estilo40"><strong><span class="Estilo1">-</span></strong></div></td>
    </tr>
    <tr>
      <td rowspan="4" class="Estilo34"><div align="center" class="Estilo35">26</div></td>
      <td class="Estilo4">se siente cansado(a) y fastidiado(a) al final del d&iacute;a </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P26" type="radio" value="1" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N26" type="radio" value="1" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">tiende a ser juicios apresurados</td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P26" type="radio" value="2" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N26" type="radio" value="2" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">no muestra resentimiento hacia los dem&aacute;s </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P26" type="radio" value="3" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N26" type="radio" value="3" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">tiene una gran sed de conocimientos </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P26" type="radio" value="4" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N26" type="radio" value="4" />
      </div></td>
    </tr>
    <tr class="Estilo34">
      <td colspan="4" class="Estilo4"><div align="center" class="Estilo32"><span class="Estilo35"></span><span class="Estilo38">x</span></div></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td><div align="center" class="Estilo26 Estilo39"><strong>+</strong></div></td>
      <td><div align="center" class="Estilo40"><strong><span class="Estilo1">-</span></strong></div></td>
    </tr>
    <tr>
      <td rowspan="4" class="Estilo34"><div align="center" class="Estilo35">27</div></td>
      <td class="Estilo4">no act&uacute;a impulsivamente </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P27" type="radio" value="1" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N27" type="radio" value="1" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">se irrita con los errores de los dem&aacute;s </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P27" type="radio" value="2" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N27" type="radio" value="2" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">carece de inter&eacute;s para pensar de manera cr&iacute;tica </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P27" type="radio" value="3" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N27" type="radio" value="3" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">prefiere trabajar r&aacute;pidamente </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P27" type="radio" value="4" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N27" type="radio" value="4" />
      </div></td>
    </tr>
    <tr class="Estilo34">
      <td colspan="4" class="Estilo4"><div align="center" class="Estilo32"><span class="Estilo35"></span><span class="Estilo38">x</span></div></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td><div align="center" class="Estilo26 Estilo39"><strong>+</strong></div></td>
      <td><div align="center" class="Estilo40"><strong><span class="Estilo1">-</span></strong></div></td>
    </tr>
    <tr>
      <td rowspan="4" class="Estilo34"><div align="center" class="Estilo35">28</div></td>
      <td class="Estilo4">Tiende a disgustarse mucho con la gente </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P28" type="radio" value="1" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N28" type="radio" value="1" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">le gusta estar siempre activo(a) </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P28" type="radio" value="2" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N28" type="radio" value="2" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">preferir&iacute;a no correr riesgos </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P28" type="radio" value="3" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N28" type="radio" value="3" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">prefiere el trabajo que requiere pocas ideas originales </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P28" type="radio" value="4" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N28" type="radio" value="4" />
      </div></td>
    </tr>
    <tr class="Estilo34">
      <td colspan="4" class="Estilo4"><div align="center" class="Estilo32"><span class="Estilo35"></span><span class="Estilo38">x</span></div></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td><div align="center" class="Estilo26 Estilo39"><strong>+</strong></div></td>
      <td><div align="center" class="Estilo40"><strong><span class="Estilo1">-</span></strong></div></td>
    </tr>
    <tr>
      <td rowspan="4" class="Estilo34"><div align="center" class="Estilo35">29</div></td>
      <td class="Estilo4">es una persona muy cautelosa </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P29" type="radio" value="1" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N29" type="radio" value="1" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">prefiere trabajar despacio </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P29" type="radio" value="2" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N29" type="radio" value="2" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">es muy diplom&aacute;tico(a) y discreto(a) </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P29" type="radio" value="3" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N29" type="radio" value="3" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">prefiere no ocupar su mente en pensamientos profundos </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P29" type="radio" value="4" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N29" type="radio" value="4" />
      </div></td>
    </tr>
    <tr class="Estilo34">
      <td colspan="4" class="Estilo4"><div align="center" class="Estilo32"><span class="Estilo35"></span><span class="Estilo38">x</span></div></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td><div align="center" class="Estilo26 Estilo39"><strong>+</strong></div></td>
      <td><div align="center" class="Estilo40"><strong><span class="Estilo1">-</span></strong></div></td>
    </tr>
    <tr>
      <td rowspan="4" class="Estilo34"><div align="center" class="Estilo35">30</div></td>
      <td class="Estilo4">pierde la paciencia con los dem&aacute;s r&aacute;pidamente </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P30" type="radio" value="1" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N30" type="radio" value="1" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">tiene menos resistencia que la mayor&iacute;a de la gente </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P30" type="radio" value="2" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N30" type="radio" value="2" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">tiende a ser creativo(a) y original </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P30" type="radio" value="3" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N30" type="radio" value="3" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">no le interesa mucho lo emocionante </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P30" type="radio" value="4" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N30" type="radio" value="4" />
      </div></td>
    </tr>
    <tr class="Estilo34">
      <td colspan="4" class="Estilo4"><div align="center" class="Estilo32"><span class="Estilo35"></span><span class="Estilo38">x</span></div></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td><div align="center" class="Estilo26 Estilo39"><strong>+</strong></div></td>
      <td><div align="center" class="Estilo40"><strong><span class="Estilo1">-</span></strong></div></td>
    </tr>
    <tr>
      <td rowspan="4" class="Estilo34"><div align="center" class="Estilo35">31</div></td>
      <td class="Estilo4">tiende a actuar siguiendo sus presentimientos </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P31" type="radio" value="1" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N31" type="radio" value="1" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">tiene un gran vigor y dinamismo</td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P31" type="radio" value="2" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N31" type="radio" value="2" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">no conf&iacute;a en los dem&aacute;s hasta que demuestren que son de fiar </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P31" type="radio" value="3" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N31" type="radio" value="3" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">disfruta los problemas que requieren bastante reflexi&oacute;n </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P31" type="radio" value="4" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N31" type="radio" value="4" />
      </div></td>
    </tr>
    <tr class="Estilo34">
      <td colspan="4" class="Estilo4"><div align="center" class="Estilo32"><span class="Estilo35"></span><span class="Estilo38">x</span></div></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td><div align="center" class="Estilo26 Estilo39"><strong>+</strong></div></td>
      <td><div align="center" class="Estilo40"><strong><span class="Estilo1">-</span></strong></div></td>
    </tr>
    <tr>
      <td rowspan="4" class="Estilo34"><div align="center" class="Estilo35">32</div></td>
      <td class="Estilo4">no le gusta trabajar r&aacute;pidamente </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P32" type="radio" value="1" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N32" type="radio" value="1" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">tiene mucha fe en la gente </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P32" type="radio" value="2" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N32" type="radio" value="2" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">tiende a ceder al deseo del momento </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P32" type="radio" value="3" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N32" type="radio" value="3" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">le agrada resolver problemas complicados </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P32" type="radio" value="4" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N32" type="radio" value="4" />
      </div></td>
    </tr>
    <tr class="Estilo34">
      <td colspan="4" class="Estilo4"><div align="center" class="Estilo32"><span class="Estilo35"></span><span class="Estilo38">x</span></div></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td><div align="center" class="Estilo26 Estilo39"><strong>+</strong></div></td>
      <td><div align="center" class="Estilo40"><strong><span class="Estilo1">-</span></strong></div></td>
    </tr>
    <tr>
      <td rowspan="4" class="Estilo34"><div align="center" class="Estilo35">33</div></td>
      <td class="Estilo4">es un(a) trabajador(a) muy activo(a) </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P33" type="radio" value="1" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N33" type="radio" value="1" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">acepta la cr&iacute;tica con buen &aacute;nimo </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P33" type="radio" value="2" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N33" type="radio" value="2" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">le disgustan los problemas que requieren mucho razonamiento </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P33" type="radio" value="3" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N33" type="radio" value="3" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">tiende a actuar primero y pensar despu&eacute;s </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P33" type="radio" value="4" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N33" type="radio" value="4" />
      </div></td>
    </tr>
    <tr class="Estilo34">
      <td colspan="4" class="Estilo4"><div align="center" class="Estilo32"><span class="Estilo35"></span><span class="Estilo38">x</span></div></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td><div align="center" class="Estilo26 Estilo39"><strong>+</strong></div></td>
      <td><div align="center" class="Estilo40"><strong><span class="Estilo1">-</span></strong></div></td>
    </tr>
    <tr>
      <td rowspan="4" class="Estilo34"><div align="center" class="Estilo35"><span class="Estilo32">34</span></div></td>
      <td class="Estilo4">no habla sino lo mejor sobre otras personas </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P34" type="radio" value="1" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N34" type="radio" value="1" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">es muy cauteloso(a) antes de actuar </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P34" type="radio" value="2" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N34" type="radio" value="2" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">no le interesan las discusiones que inciten a pensar </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P34" type="radio" value="3" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N34" type="radio" value="3" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">no se apresura yendo de un lugar a otro </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P34" type="radio" value="4" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N34" type="radio" value="4" />
      </div></td>
    </tr>
    <tr class="Estilo34">
      <td colspan="4" class="Estilo4"><div align="center" class="Estilo32"><span class="Estilo35"></span><span class="Estilo38">x</span></div></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td><div align="center" class="Estilo26 Estilo39"><strong>+</strong></div></td>
      <td><div align="center" class="Estilo40"><strong><span class="Estilo1">-</span></strong></div></td>
    </tr>
    <tr>
      <td rowspan="4" class="Estilo34"><div align="center" class="Estilo35">35</div></td>
      <td class="Estilo4">no tiene una mente inquisitiva </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P35" type="radio" value="1" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N35" type="radio" value="1" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">no act&uacute;a impulsivamente</td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P35" type="radio" value="2" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N35" type="radio" value="2" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">generalmente est&aacute; desbordante de energ&iacute;a </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P35" type="radio" value="3" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N35" type="radio" value="3" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">se irrita f&aacute;cilmente por las debilidades de los dem&aacute;s </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P35" type="radio" value="4" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N35" type="radio" value="4" />
      </div></td>
    </tr>
    <tr class="Estilo34">
      <td colspan="4" class="Estilo4"><div align="center" class="Estilo32"><span class="Estilo35"></span><span class="Estilo38">x</span></div></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td><div align="center" class="Estilo26 Estilo39"><strong>+</strong></div></td>
      <td><div align="center" class="Estilo40"><strong><span class="Estilo1">-</span></strong></div></td>
    </tr>
    <tr>
      <td rowspan="4" class="Estilo34"><div align="center" class="Estilo35">36</div></td>
      <td class="Estilo4">puede realizar m&aacute;s cosas que otras personas </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P36" type="radio" value="1" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N36" type="radio" value="1" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">le gusta correr riesgos s&oacute;lo por la emoci&oacute;n de hacerlo </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P36" type="radio" value="2" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N36" type="radio" value="2" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">se ofende cuando es criticado(a) </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P36" type="radio" value="3" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N36" type="radio" value="3" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">prefiere trabajar con ideas que son cosas </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P36" type="radio" value="4" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N36" type="radio" value="4" />
      </div></td>
    </tr>
    <tr class="Estilo34">
      <td colspan="4" class="Estilo4"><div align="center" class="Estilo32"><span class="Estilo35"></span><span class="Estilo38">x</span></div></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td><div align="center" class="Estilo26 Estilo39"><strong>+</strong></div></td>
      <td><div align="center" class="Estilo40"><strong><span class="Estilo1">-</span></strong></div></td>
    </tr>
    <tr>
      <td rowspan="4" class="Estilo34"><div align="center" class="Estilo35">37</div></td>
      <td class="Estilo4">conf&iacute;a mucho en las personas </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P37" type="radio" value="1" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N37" type="radio" value="1" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">prefiere desempe&ntilde;ar trabajo rutinario y simple </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P37" type="radio" value="2" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N37" type="radio" value="2" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">act&uacute;a impulsivamente </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P37" type="radio" value="3" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N37" type="radio" value="3" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">est&aacute; lleno(a) de vigor y energ&iacute;a </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P37" type="radio" value="4" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N37" type="radio" value="4" />
      </div></td>
    </tr>
    <tr class="Estilo34">
      <td colspan="4" class="Estilo4"><div align="center" class="Estilo32"><span class="Estilo35"></span><span class="Estilo38">x</span></div></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td><div align="center" class="Estilo26 Estilo39"><strong>+</strong></div></td>
      <td><div align="center" class="Estilo40"><strong><span class="Estilo1">-</span></strong></div></td>
    </tr>
    <tr>
      <td rowspan="4" class="Estilo34"><div align="center" class="Estilo35"><span class="Estilo32">38</span></div></td>
      <td class="Estilo4">toma decisiones muy r&aacute;pidamente </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P38" type="radio" value="1" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N38" type="radio" value="1" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">le simpatiza toda la gente </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P38" type="radio" value="2" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N38" type="radio" value="2" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">mantiene un ritmo vivaz en el trabajo o en el juego </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P38" type="radio" value="3" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N38" type="radio" value="3" />
      </div></td>
    </tr>
    <tr>
      <td class="Estilo4">no tiene un gran inter&eacute;s en adquirir conocimientos </td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="P38" type="radio" value="4" />
      </div></td>
      <td bordercolor="#FF99FF"><div align="center">
          <input name="N38" type="radio" value="4" />
      </div></td>
    </tr>

    <tr>
      <td colspan="4" class="Estilo4"><div align="center" class="Estilo32">
        <p>&nbsp;</p>
        <p class="Estilo34">Una vez termine, por favor presione el bot&oacute;n &quot;Enviar Evaluaci&oacute;n&quot;. </p>
      </div></td>
    </tr>

    <tr>
      <td colspan="4" class="Estilo1"><div align="center">
        <input name="submit" type="submit" onclick="MM_popupMsg('Estimado candidato:\r\rLa evaluaci&oacute;n ha sido enviada exitosamente. Por favor salga de internet. \r\rMuchas gracias por su participaci&oacute;n\r\rDepartamento de Talento Humano')" value="Enviar Evaluaci&oacute;n" />
      </div></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>
    <input type="hidden" name="MM_insert" value="form1">
  </p>
</form>
<p>&nbsp;</p>
</body>
</html>
