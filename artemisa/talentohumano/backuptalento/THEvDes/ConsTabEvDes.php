<?php require_once('Connections/conexion.php'); ?>
<?php
mysql_select_db($database_conexion, $conexion);
$query_ConsTabEvDe = "SELECT * FROM tevaldes ORDER BY tevaldes.NombCol, tevaldes.FechEval";
$ConsTabEvDe = mysql_query($query_ConsTabEvDe, $conexion) or die(mysql_error());
$row_ConsTabEvDe = mysql_fetch_assoc($ConsTabEvDe);
$totalRows_ConsTabEvDe = mysql_num_rows($ConsTabEvDe);
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
.Estilo23 {font-family: Tahoma; color: #596221; font-weight: bold; font-size: 10px; }
.Estilo24 {font-family: Tahoma; color: #596221; font-weight: bold; font-size: 24; }
.Estilo28 {font-size: 36px}
.Estilo29 {font-size: 36}
.Estilo34 {font-family: Tahoma; color: #596221; font-weight: bold; font-size: 16; }
-->
</style>
</head>

<body>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p class="Estilo4">Tabla de evaluaciones de desempe&ntilde;o realizadas </p>
<p>&nbsp;</p>
<p>&nbsp;</p>

<table border="1" align="center" bordercolor="#003300" bgcolor="#FFFFCC">
  <tr valign="top" class="Estilo24">
    <td colspan="4"><div align="center"><span class="Estilo28"><span class="Estilo29"></span></span></div>      <div align="center"><span class="Estilo28"><span class="Estilo29"></span></span></div>      <div align="center"><span class="Estilo28"><span class="Estilo29"></span></span></div>      <div align="center"><span class="Estilo28"><span class="Estilo29"></span></span></div></td>
    <td height="71" colspan="21" class="Estilo24"><p align="center" class="Estilo29">Calidad de la gesti&oacute;n: Considera el desempe&ntilde;o obtenido por el empleado en su labor.</p></td>
    <td colspan="12"><div align="center" class="Estilo29">Facilitadores de desempe&ntilde;o: Considera aquellas caracter&iacute;sticas individuales que posee el empleado para facilitar el buen desempe&ntilde;o laboral dentro y fuera del cargo.</div></td>
    <td colspan="12"><div align="center"><span class="Estilo28"><span class="Estilo29"></span></span>Compromiso Institucional: Considera la participaci&oacute;n del empleado en diferentes actividades de la Universidad. </div>      <div align="center"><span class="Estilo28"><span class="Estilo29"></span></span></div>      <div align="center"><span class="Estilo28"><span class="Estilo29"></span></span></div>      <div align="center"><span class="Estilo28"><span class="Estilo29"></span></span></div></td>
    <td colspan="8"><div align="center"><span class="Estilo28"><span class="Estilo29"></span></span>OBSERVACIONES GENERALES </div>      <div align="center"><span class="Estilo28"><span class="Estilo29"></span></span></div>      <div align="center"><span class="Estilo28"><span class="Estilo29"></span></span></div>      <div align="center"><span class="Estilo28"><span class="Estilo29"></span></span></div>
    <div align="center"><span class="Estilo28"><span class="Estilo29"></span></span></div>      <div align="center"></div>    <div align="center"><span class="Estilo28"><span class="Estilo29"></span></span></div>    <div align="center"><span class="Estilo28"><span class="Estilo29"></span></span></div>    <div align="center"><span class="Estilo28"><span class="Estilo29"></span></span></div></td>
  </tr>
  <tr valign="top" class="Estilo23">
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td height="71" colspan="3"><div align="center">CALIDAD DEL TRABAJO<br />
    Eficacia y eficiencia, en la realizaci&oacute;n normal de las tareas, teniendo un inter&eacute;s por obtener &oacute;ptimos resultados</div></td>
    <td colspan="3"><div align="center">CONOCIMIENTO DEL TRABAJO<br />
    Se preocupa por investigar y comprender las tareas y funciones, aplicando las t&eacute;cnicas y m&eacute;todos pertinentes para realizarlas</div></td>
    <td colspan="3"><div align="center">INICIATIVA<br />
    Encuentra soluciones r&aacute;pidas y mejores a los problemas de su trabajo con el fin de agilizarlo y ser productivo</div></td>
    <td colspan="3"><div align="center">DISPOSICI&Oacute;N PARA APRENDER<br />
    Receptividad para adquirir nuevos conocimientos y adaptarse a nuevos procedimientos</div></td>
    <td colspan="3"><div align="center">ORGANIZACI&Oacute;N EN EL TRABAJO<br />
    Capacidad para determinar y coordinar las acciones necesarias para realizar efectivamente el trabajo</div></td>
    <td colspan="3"><div align="center">MANEJO DE INFORMACI&Oacute;N CON CONFIDENCIALIDAD<br />
    Es prudente con la informaci&oacute;n que maneja y la transmite a las instancias pertinentes</div></td>
    <td colspan="3"><div align="center">ATENCI&Oacute;N AL CLIENTE<br />
    Muestra cordialidad, efectividad y disposici&oacute;n para atender a los dem&aacute;s</div></td>
    <td colspan="3"><div align="center">CUMPLIMIENTO OPORTUNO DE TAREAS ASIGNADAS Y PUNTUALIDAD<br />
    Responsabilidad, dedicaci&oacute;n y puntualidad en las tareas y los horarios</div></td>
    <td colspan="3"><div align="center">COOPERACI&Oacute;N<br />
    Disposici&oacute;n de colaborar con los dem&aacute;s, aunque no sea parte de sus obligaciones, aportando al trabajo en equipo</div></td>
    <td colspan="3"><div align="center">COMUNICACI&Oacute;N<br />
    Establece canales de comunicaci&oacute;n con las personas para lograr efectividad en el trabajo y se relaciona socialmente con los dem&aacute;s</div></td>
    <td colspan="3"><div align="center">ADAPTABILIDAD<br />
    Capacidad de aceptar los cambios y trabajar para que tengan &eacute;xito</div></td>
    <td colspan="3"><div align="center">PARTICIPACI&Oacute;N EN ACTIVIDADES<br />
    Se integra y participa en los eventos de la Universidad </div></td>
    <td colspan="3"><div align="center">SENTIDO DE PERTENENCIA<br />
    Muestra compromiso con los objetivos de la Universidad y orgullo de pertenecer a ella</div></td>
    <td colspan="3"><div align="center">CONCIENCIA ORGANIZACIONAL<br />
    Identificaci&oacute;n y cumplimiento de pol&iacute;ticas y normas de la Universidad</div></td>
    <td colspan="3"> <div align="center">PRESENTACI&Oacute;N PERSONAL<br />
    Imagen personal que denota cuidado, pulcritud y manejo adecuado del uniforme y la dotaci&oacute;n</div></td>
    <td align="center" valign="middle"><div align="center">FORTALEZAS</div></td>
    <td align="center" valign="middle"><div align="center">ASPECTOS POR MEJORAR</div></td>
    <td align="center" valign="middle"><div align="center">PLAN DE MEJORAMIENTO</div></td>
    <td align="center" valign="middle"><div align="center">PLAZO ACORDADO PARA EL PLAN DE MEJORAMIENTO</div></td>
    <td align="center" valign="middle"><div align="center" class="Estilo23"><span class="Estilo24">        SI EST&Aacute; EVALUANDO UNA PERSONA CONTRATADA A T&Eacute;RMINO FIJO , SEG&Uacute;N USTED &iquest;ESTA PERSONA DEBE O NO SER CONTRATADA PARA CONTINUAR LABORANDO EN LA INSTITUCI&Oacute;N?. EN CASO DE SER NEGATIVA SU RESPUESTA, EXPLIQUE POR FAVOR EL MOTIVO DE ESTA DECISI&Oacute;N</span></div></td>
    <td valign="middle" class="Estilo4"><div align="center">CONFIMACION NOMBRE EVALUADOR </div></td>
    <td valign="middle" class="Estilo4"><div align="center">CONFIRMACI&Oacute;N NOMBRE EVALUADO </div></td>
    <td valign="middle" class="Estilo4"><div align="center">JEFE TALENTO HUMANO </div></td>
  </tr>
  <tr align="center" valign="top" class="Estilo23">
    <td nowrap="nowrap" class="Estilo34">Id Evaluaci&oacute;n </td>
    <td nowrap="nowrap" class="Estilo34">Nombre Colaborador </td>
    <td nowrap="nowrap" class="Estilo34">Nombre Jefe </td>
    <td nowrap="nowrap" class="Estilo34">Fecha Evaluaci&oacute;n </td>
    <td height="127"><div align="center">1<br />
    Requiere    una permanente supervisi&oacute;n y en general comete muchos errores</div></td>
    <td><div align="center">2<br />
    Comete algunos errores y la    calidad es regular</div></td>
    <td><div align="center">3<br />
    La precisi&oacute;n de su trabajo    permite utilizarlo con confianza</div></td>
    <td height="127">1<br />
    No    muestra ning&uacute;n inter&eacute;s en conocer mejor su trabajo</td>
    <td>2<br />
    Se preocupa poco    por actualizar su conocimiento de tareas y m&eacute;todos</td>
    <td>3<br />
    Esta al d&iacute;a con el conocimiento    requerido para hacer efectivamente su trabajo</td>
    <td height="127"><div align="center">1<br />
    No busca    soluciones y muestra mucha pasividad para hallarlas</div></td>
    <td><div align="center">2<br />
    Casi siempre    necesita orientaci&oacute;n para hallar las soluciones pertinentes</div></td>
    <td><div align="center">3<br />
    Genera frecuentemente soluciones    pr&aacute;cticas y efectivas para lograr productividad</div></td>
    <td height="127">1<br />
    No se    preocupa por adquirir nuevos conocimientos&nbsp;    a pesar que se le transmiten detalladamente</td>
    <td>2<br />
    Se le debe    motivar para que adquiera nuevos conocimientos y muestra resistencia</td>
    <td>3<br />
    Muestra un alto inter&eacute;s en nuevos    conocimientos y reacciona positivamente a los nuevos procedimientos</td>
    <td height="127">1<br />
    No tiene    orden ni m&eacute;todo para realizar su trabajo</td>
    <td>2<br />
    Muestra    dificultades para planear y realizar ordenadamente su trabajo</td>
    <td>3<br />
    Planea y realiza su trabajo    ordenada y efectivamente</td>
    <td height="127">1<br />
    Divulga    la informaci&oacute;n indiscriminadamente llevando a la desconfianza de los dem&aacute;s</td>
    <td>2<br />
    En ciertos casos    es imprudente con la divulgaci&oacute;n de informaci&oacute;n</td>
    <td>3<br />
    Muestra alta confiabilidad en el    manejo de la informaci&oacute;n</td>
    <td height="127">1<br />
    Es    negligente y desatento en la atenci&oacute;n de los dem&aacute;s</td>
    <td>2<br />
    Le falta un poco    de amabilidad y diligencia al atender a los dem&aacute;s</td>
    <td>3<br />
    Brinda una respuesta amable y    efectiva al atender a los dem&aacute;s</td>
    <td height="127">1<br />
    Con    frecuencia se retarda y pierde tiempo en su trabajo</td>
    <td>2<br />
    Rara vez incumple con sus tareas o    sus horarios</td>
    <td>3<br />
    Es ejemplo de puntualidad y    cumplimiento de tareas</td>
    <td height="127">1<br />
    No    colabora ni ayuda a los dem&aacute;s y pone obst&aacute;culos para hacerlo</td>
    <td>2<br />
    Algunas veces&nbsp; colabora con actividades que no    corresponden a su trabajo</td>
    <td>3<br />
    Siempre esta dispuesto a    colaborar, incluso si debe hacer esfuerzos extra</td>
    <td height="127">1<br />
    Es una    persona aislada, prefiere no hablar con los dem&aacute;s y se muestra pasiva en la    relaci&oacute;n social</td>
    <td>2<br />
    Establece contacto con los dem&aacute;s    para lo que es estrictamente necesario</td>
    <td>3<br />
    Establece excelentes canales de    comunicaci&oacute;n tanto laborales como sociales</td>
    <td height="127">1<br />
    Muestra    resistencia ante los cambios y no colabora para su &eacute;xito</td>
    <td>2<br />
    Muestra aceptaci&oacute;n de los cambios    pero no colabora para su &eacute;xito</td>
    <td>3<br />
    Acepta los cambios y genera    estrategias para que tengan &eacute;xito</td>
    <td height="127">1<br />
    Muestra    desinter&eacute;s ante las&nbsp; actividades de la    Universidad y en general no asiste</td>
    <td>2<br />
    Rara vez asiste a las actividades    de la Universidad o no participa mucho</td>
    <td>3<br />
    En general asiste y disfruta las    actividades de la Universidad</td>
    <td height="127">1<br />
    Su    comportamiento revela falta de inter&eacute;s en la Universidad, sus objetivos y sus    procesos</td>
    <td>2<br />
    Hace pocos esfuerzos por lograr la    mejora de la Universidad</td>
    <td>3<br />
    Hace de la Universidad parte de su    vida y lo disfruta</td>
    <td height="127">1<br />
    Hace las    cosas como quiere sin respetar reglamentos ni pol&iacute;ticas</td>
    <td>2<br />
    Presenta dificultades en el    cumplimiento de normas y pol&iacute;ticas</td>
    <td>3<br />
    Cumple a cabalidad las normas y    pol&iacute;ticas</td>
    <td height="127">1<br />
    En    general presenta una imagen descuidada en la vestimenta y su arreglo personal</td>
    <td>2<br />
    En algunos casos descuida su    imagen y el uso del uniforme</td>
    <td>3<br />
    Siempre est&aacute; en &oacute;ptimas    condiciones de presentaci&oacute;n y utiliza adecuadamente el uniforme</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td align="center" valign="middle">&nbsp;</td>
    <td valign="middle" class="Estilo4">&nbsp;</td>
    <td valign="middle" class="Estilo4">&nbsp;</td>
    <td valign="middle" class="Estilo4">&nbsp;</td>
  </tr>
  <tr>
    <td nowrap="nowrap"><div align="center">IdEvalDes</div></td>
    <td nowrap="nowrap"><div align="center">NombCol</div></td>
    <td nowrap="nowrap"><div align="center">JefCol</div></td>
    <td nowrap="nowrap"><div align="center">FechEval</div></td>
    <td colspan="3" nowrap="nowrap"><div align="center">CaGeCaTr</div></td>
    <td colspan="3" nowrap="nowrap"><div align="center">CaGeCoTr</div></td>
    <td colspan="3" nowrap="nowrap"><div align="center">CaGeInic</div></td>
    <td colspan="3" nowrap="nowrap"><div align="center">CaGeDiAp</div></td>
    <td colspan="3" nowrap="nowrap"><div align="center">CaGeOrTR</div></td>
    <td colspan="3" nowrap="nowrap"><div align="center">CaGeMaIn</div></td>
    <td colspan="3" nowrap="nowrap"><div align="center">CaGeAtCl</div></td>
    <td colspan="3" nowrap="nowrap"><div align="center">FaDeCuOp</div></td>
    <td colspan="3" nowrap="nowrap"><div align="center">FaDeCoop</div></td>
    <td colspan="3" nowrap="nowrap"><div align="center">FaDeComu</div></td>
    <td colspan="3" nowrap="nowrap"><div align="center">FaDeAdap</div></td>
    <td colspan="3" nowrap="nowrap"><div align="center">CoInPaAc</div></td>
    <td colspan="3" nowrap="nowrap"><div align="center">CoInSePe</div></td>
    <td colspan="3" nowrap="nowrap"><div align="center">CoInCoOr</div></td>
    <td colspan="3" nowrap="nowrap"><div align="center">CoInPrPe</div></td>
    <td nowrap="nowrap"><div align="center">PlMeFort</div></td>
    <td nowrap="nowrap"><div align="center">PlMeAsMe</div></td>
    <td nowrap="nowrap"><div align="center">PlMePlMe</div></td>
    <td nowrap="nowrap"><div align="center">PlMePlAc</div></td>
    <td nowrap="nowrap"><div align="center">CoGePeTf</div></td>
    <td nowrap="nowrap"><div align="center"></div></td>
    <td nowrap="nowrap"><div align="center"></div></td>
    <td nowrap="nowrap"><div align="center"></div></td>
  </tr>
  <?php do { ?>
    <tr>
      <td nowrap="nowrap"><div align="center"><?php echo $row_ConsTabEvDe['IdEvalDes']; ?></div></td>
      <td nowrap="nowrap"><div align="center"><?php echo $row_ConsTabEvDe['NombCol']; ?></div></td>
      <td nowrap="nowrap"><div align="center"><?php echo $row_ConsTabEvDe['JefCol']; ?></div></td>
      <td nowrap="nowrap"><div align="center"><?php echo $row_ConsTabEvDe['FechEval']; ?></div></td>
      <td colspan="3" nowrap="nowrap"><div align="center"><?php echo $row_ConsTabEvDe['CaGeCaTr']; ?></div></td>
      <td colspan="3" nowrap="nowrap"><div align="center"><?php echo $row_ConsTabEvDe['CaGeCoTr']; ?></div></td>
      <td colspan="3" nowrap="nowrap"><div align="center"><?php echo $row_ConsTabEvDe['CaGeInic']; ?></div></td>
      <td colspan="3" nowrap="nowrap"><div align="center"><?php echo $row_ConsTabEvDe['CaGeDiAp']; ?></div></td>
      <td colspan="3" nowrap="nowrap"><div align="center"><?php echo $row_ConsTabEvDe['CaGeOrTR']; ?></div></td>
      <td colspan="3" nowrap="nowrap"><div align="center"><?php echo $row_ConsTabEvDe['CaGeMaIn']; ?></div></td>
      <td colspan="3" nowrap="nowrap"><div align="center"><?php echo $row_ConsTabEvDe['CaGeAtCl']; ?></div></td>
      <td colspan="3" nowrap="nowrap"><div align="center"><?php echo $row_ConsTabEvDe['FaDeCuOp']; ?></div></td>
      <td colspan="3" nowrap="nowrap"><div align="center"><?php echo $row_ConsTabEvDe['FaDeCoop']; ?></div></td>
      <td colspan="3" nowrap="nowrap"><div align="center"><?php echo $row_ConsTabEvDe['FaDeComu']; ?></div></td>
      <td colspan="3" nowrap="nowrap"><div align="center"><?php echo $row_ConsTabEvDe['FaDeAdap']; ?></div></td>
      <td colspan="3" nowrap="nowrap"><div align="center"><?php echo $row_ConsTabEvDe['CoInPaAc']; ?></div></td>
      <td colspan="3" nowrap="nowrap"><div align="center"><?php echo $row_ConsTabEvDe['CoInSePe']; ?></div></td>
      <td colspan="3" nowrap="nowrap"><div align="center"><?php echo $row_ConsTabEvDe['CoInCoOr']; ?></div></td>
      <td colspan="3" nowrap="nowrap"><div align="center"><?php echo $row_ConsTabEvDe['CoInPrPe']; ?></div></td>
      <td nowrap="nowrap"><div align="center"><?php echo $row_ConsTabEvDe['PlMeFort']; ?></div></td>
      <td nowrap="nowrap"><div align="center"><?php echo $row_ConsTabEvDe['PlMeAsMe']; ?></div></td>
      <td nowrap="nowrap"><div align="center"><?php echo $row_ConsTabEvDe['PlMePlMe']; ?></div></td>
      <td nowrap="nowrap"><div align="center"><?php echo $row_ConsTabEvDe['PlMePlAc']; ?></div></td>
      <td nowrap="nowrap"><div align="center"><?php echo $row_ConsTabEvDe['CoGePeTf']; ?></div></td>
      <td nowrap="nowrap"><div align="center"><?php echo $row_ConsTabEvDe['Evaluador']; ?></div></td>
      <td nowrap="nowrap"><div align="center"><?php echo $row_ConsTabEvDe['Evaluado']; ?></div></td>
      <td nowrap="nowrap"><div align="center"><?php echo $row_ConsTabEvDe['JefeTH']; ?></div></td>
    </tr>
    <?php } while ($row_ConsTabEvDe = mysql_fetch_assoc($ConsTabEvDe)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($ConsTabEvDe);
?>
