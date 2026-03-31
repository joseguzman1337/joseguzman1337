<?php require_once('../COPIAS DEL SISTEMA/Connections/conexion.php'); ?>
<?php
mysql_select_db($database_conexion, $conexion);
$query_ConsTabEvaD = "SELECT * FROM tevaldes ORDER BY tevaldes.NombCol, tevaldes.FechEval";
$ConsTabEvaD = mysql_query($query_ConsTabEvaD, $conexion) or die(mysql_error());
$row_ConsTabEvaD = mysql_fetch_assoc($ConsTabEvaD);
$totalRows_ConsTabEvaD = mysql_num_rows($ConsTabEvaD);
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
.Estilo36 {color: #596221}
.Estilo30 {font-size: 18px}
.Estilo43 {color: #003300}
.Estilo46 {color: #003300; font-family: Tahoma; }
-->
</style>
<script type="text/JavaScript">
<!--
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script>
</head>

<body>
<table width="838" border="0">
  <tr>
    <td width="155" height="72" bgcolor="#98BD0D"><div align="center" class="Estilo22"><img src="../COPIAS DEL SISTEMA/IMAGENES/LOGOBOSQUETH.jpg" alt="as" width="138" height="62" /></div></td>
    <td width="673" bgcolor="#98BD0D"><div align="center" class="Estilo4">TABLA DE B&Uacute;SQUEDA DE EVALUACI&Oacute;N DESEMPE&Ntilde;O </div></td>
  </tr>
</table>
<table width="841" border="0">
  <tr>
    <td bgcolor="#FFB112"><div align="center" class="Estilo4">DEPARTAMENTO DE TALENTO HUMANO - CONSTRUYENDO UN MEJOR EQUIPO </div></td>
  </tr>
</table>
<p>&nbsp;</p>
<table border="1" align="left" bordercolor="#003300" bgcolor="#FFFFCC">
  <tr align="center" valign="top" class="Estilo23">
    <td valign="middle" class="Estilo24">TENGA EN CUENTA QUE EL SIGNIFICADO DE LOS VALORES ES </td>
    <td valign="middle" class="Estilo24"><div align="center">
      <p>1</p>
      <p>Deficiente</p>
    </div></td>
    <td valign="middle" class="Estilo24"><div align="center">
      <p>2</p>
      <p>Regular</p>
    </div></td>
    <td valign="middle" class="Estilo24"><div align="center">
      <p>3</p>
      <p>Aceptable</p>
    </div></td>
    <td valign="middle" class="Estilo24"><div align="center">
      <p>4</p>
      <p>Bueno</p>
    </div></td>
    <td valign="middle" class="Estilo24"><div align="center">
      <p>5</p>
      <p>Excelente</p>
    </div></td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>

<table border="0" bordercolor="#000000" bgcolor="#000000">
  <tr>
    <td colspan="5" valign="top" bordercolor="#003300" bgcolor="#FFFF99" class="Estilo24"><div align="center"><span class="Estilo28"><span class="Estilo29"></span></span>DATOS B&Aacute;SICOS </div>
        <div align="center"><span class="Estilo28"><span class="Estilo29"></span></span></div>
      <div align="center"><span class="Estilo28"><span class="Estilo29"></span></span></div>
      <div align="center"><span class="Estilo28"><span class="Estilo29"></span></span></div></td>
    <td colspan="7" bgcolor="#FFFF99"><span class="Estilo34">Calidad de la gesti&oacute;n: Considere el desempe&ntilde;o obtenido por el empleado en su labor.</span></td>
    <td colspan="4" bgcolor="#FFFF99"><span class="Estilo34">Facilitadores de desempe&ntilde;o: Considere aquellas caracter&iacute;sticas individuales que posee el empleado para facilitar el buen desempe&ntilde;o laboral dentro y fuera del cargo.</span></td>
    <td colspan="4" bgcolor="#FFFF99"><span class="Estilo34">Compromiso Institucional: Considere la participaci&oacute;n del empleado en diferentes actividades de la Universidad. </span></td>
    <td colspan="6" bgcolor="#FFFF99" class="Estilo34"><strong>Ahora por favor identifique tres responsabilidades/funciones centrales del cargo que est&aacute; evaluando y califique el desempe&ntilde;o del (la) ocupante</strong>.</td>
    <td colspan="8" valign="top" bordercolor="#003300" bgcolor="#FFFF99" class="Estilo24"><div align="center"><span class="Estilo28"><span class="Estilo29"></span></span>OBSERVACIONES GENERALES </div>
        <div align="center"><span class="Estilo28"><span class="Estilo29"></span></span></div>
      <div align="center"><span class="Estilo28"><span class="Estilo29"></span></span></div>
      <div align="center"><span class="Estilo28"><span class="Estilo29"></span></span></div>
      <div align="center"><span class="Estilo28"><span class="Estilo29"></span></span></div>
      <div align="center"></div>
      <div align="center"><span class="Estilo28"><span class="Estilo29"></span></span></div>
      <div align="center"><span class="Estilo28"><span class="Estilo29"></span></span></div>
      <div align="center"><span class="Estilo28"><span class="Estilo29"></span></span></div></td>
  </tr>
  <tr>
    <td valign="top" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo23"><div align="center">Ver Evaluaci&oacute;n </div></td>
    <td valign="top" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo23"><div align="center">Id Evaluaci&oacute;n </div></td>
    <td valign="top" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo23"><div align="center">Colaborador</div></td>
    <td valign="top" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo23"><div align="center">Jefe</div></td>
    <td valign="top" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo23"><div align="center">Fecha Evaluaci&oacute;n </div></td>
    <td align="center" valign="top" bgcolor="#FFFFCC" class="Estilo23"><span class="Estilo36">CALIDAD    DEL TRABAJO<br />
Eficacia y eficiencia, en la realizaci&oacute;n normal de las    tareas, teniendo un inter&eacute;s por obtener &oacute;ptimos resultados</span></td>
    <td align="center" valign="top" bgcolor="#FFFFCC" class="Estilo23"><span class="Estilo36">CONOCIMIENTO    DEL TRABAJO<br />
Cuenta con el conocimiento requerido para cumplir sus funciones o lo indaga cuando es necesario</span></td>
    <td align="center" valign="top" bgcolor="#FFFFCC" class="Estilo23"><span class="Estilo36">INICIATIVA<br />
Encuentra soluciones r&aacute;pidas y mejores a los problemas    de su trabajo con el fin de agilizarlo y ser productivo</span></td>
    <td align="center" valign="top" bgcolor="#FFFFCC" class="Estilo23"><span class="Estilo36">DISPOSICI&Oacute;N    PARA APRENDER<br />
Busca  adquirir el conocimiento y habilidades para realizar bien su trabajo</span></td>
    <td align="center" valign="top" bgcolor="#FFFFCC" class="Estilo23"><span class="Estilo36">ORGANIZACI&Oacute;N    EN EL TRABAJO<br />
Capacidad para identificar y ejecutar las acciones necesarias para realizar efectivamente el trabajo</span></td>
    <td align="center" valign="top" bgcolor="#FFFFCC" class="Estilo23"><span class="Estilo36">MANEJO DE    INFORMACI&Oacute;N CON CONFIDENCIALIDAD<br />
Es prudente con la informaci&oacute;n que maneja y la    transmite a las instancias pertinentes</span></td>
    <td align="center" valign="top" bgcolor="#FFFFCC" class="Estilo23"><span class="Estilo36">ATENCI&Oacute;N    AL CLIENTE<br />
Muestra cordialidad, efectividad y disposici&oacute;n para    atender a los dem&aacute;s</span></td>
    <td align="center" valign="top" bgcolor="#FFFFCC" class="Estilo23"><span class="Estilo36">CUMPLIMIENTO OPORTUNO DE SUS FUNCIONES<br />
Muestra responsabilidad en la consecucion de sus tareas y obligaciones</span></td>
    <td align="center" valign="top" bgcolor="#FFFFCC" class="Estilo23"><span class="Estilo36">COOPERACI&Oacute;N<br />
Colabora con los dem&aacute;s, aunque no sea parte de sus obligaciones, aportando al trabajo en equipo</span></td>
    <td align="center" valign="top" bgcolor="#FFFFCC" class="Estilo23"><span class="Estilo36">RELACIONES INTERPERSONALES<br />
Se relaciona con los dem&aacute;s para lograr efectividad y armon&iacute;a en el trabajo </span></td>
    <td align="center" valign="top" bgcolor="#FFFFCC" class="Estilo23"><span class="Estilo36">ADAPTABILIDAD<br />
Acepta los cambios y trabaja para que tengan &eacute;xito</span></td>
    <td align="center" valign="top" bgcolor="#FFFFCC" class="Estilo23"><span class="Estilo36">PARTICIPACI&Oacute;N<br />
Propone ideas para mejorar la forma como se realiza el trabajo</span></td>
    <td align="center" valign="top" bgcolor="#FFFFCC" class="Estilo23"><span class="Estilo36">SENTIDO DE    PERTENENCIA<br />
Muestra compromiso con los objetivos de la Universidad</span></td>
    <td align="center" valign="top" bgcolor="#FFFFCC" class="Estilo23">CONCIENCIA    ORGANIZACIONAL<br />
  Cumple las pol&iacute;ticas y normas de la Universidad (horarios, uniformes, etc)</td>
    <td align="center" valign="top" bgcolor="#FFFFCC" class="Estilo23">PRESENTACI&Oacute;N PERSONAL<br />
Se preocupa por tener una presentaci&oacute;n personal adecuada </td>
    <td valign="middle" bgcolor="#FFFFCC" class="Estilo23"><div align="center">Responsabilidad 1 </div></td>
    <td valign="middle" bgcolor="#FFFFCC" class="Estilo23"><div align="center">Puntaje </div></td>
    <td valign="middle" bgcolor="#FFFFCC" class="Estilo23"><div align="center">Responsabilidad 2 </div></td>
    <td valign="middle" bgcolor="#FFFFCC" class="Estilo23"><div align="center">Puntaje</div></td>
    <td valign="middle" bgcolor="#FFFFCC" class="Estilo23"><div align="center">Responsabilidad 3 </div></td>
    <td valign="middle" bgcolor="#FFFFCC" class="Estilo23"><div align="center">Punmtaje</div></td>
    <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo23"><div align="center">FORTALEZAS</div></td>
    <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo23"><div align="center">ASPECTOS POR MEJORAR</div></td>
    <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo23"><div align="center">PLAN DE MEJORAMIENTO</div></td>
    <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo23"><div align="center">PLAZO ACORDADO PARA EL PLAN DE MEJORAMIENTO</div></td>
    <td align="center" valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo23"><div align="center" class="Estilo23"><span class="Estilo24"> SI EST&Aacute; EVALUANDO UNA PERSONA CONTRATADA A T&Eacute;RMINO FIJO , SEG&Uacute;N USTED &iquest;ESTA PERSONA DEBE O NO SER CONTRATADA PARA CONTINUAR LABORANDO EN LA INSTITUCI&Oacute;N?. EN CASO DE SER NEGATIVA SU RESPUESTA, EXPLIQUE POR FAVOR EL MOTIVO DE ESTA DECISI&Oacute;N</span></div></td>
    <td valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo4"><div align="center">CONFIMACION NOMBRE EVALUADOR </div></td>
    <td valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo4"><div align="center">CONFIRMACI&Oacute;N NOMBRE EVALUADO </div></td>
    <td valign="middle" bordercolor="#003300" bgcolor="#FFFFCC" class="Estilo4"><div align="center">JEFE TALENTO HUMANO </div></td>
  </tr>
  
  <?php do { ?>
    <tr>
      <td bgcolor="#FFFFCC"><div align="center">
        <form id="form1" name="form1" method="get" action="CEvalDesForm2.php">
          <input name="Submit" type="submit" onclick="MM_goToURL('parent','CEvalDesForm2.php?NombCol=<?php echo $row_ConsTabEvaD['NombCol'];?>&amp;IdEvalDes=<?php echo $row_ConsTabEvaD['IdEvalDes']; ?>');return document.MM_returnValue" value="Ver Evaluaci&oacute;n" />
                </form>
        </div></td>
      <td bgcolor="#FFFFCC"><div align="center"><?php echo $row_ConsTabEvaD['IdEvalDes']; ?></div></td>
      <td nowrap="nowrap" bgcolor="#FFFFCC"><div align="center"><?php echo $row_ConsTabEvaD['NombCol']; ?></div></td>
      <td nowrap="nowrap" bgcolor="#FFFFCC"><div align="center"><?php echo $row_ConsTabEvaD['JefCol']; ?></div></td>
      <td nowrap="nowrap" bgcolor="#FFFFCC"><div align="center"><?php echo $row_ConsTabEvaD['FechEval']; ?></div></td>
      <td bgcolor="#FFFFCC"><div align="center"><?php echo $row_ConsTabEvaD['CaGeCaTr']; ?></div></td>
      <td bgcolor="#FFFFCC"><div align="center"><?php echo $row_ConsTabEvaD['CaGeCoTr']; ?></div></td>
      <td bgcolor="#FFFFCC"><div align="center"><?php echo $row_ConsTabEvaD['CaGeInic']; ?></div></td>
      <td bgcolor="#FFFFCC"><div align="center"><?php echo $row_ConsTabEvaD['CaGeDiAp']; ?></div></td>
      <td bgcolor="#FFFFCC"><div align="center"><?php echo $row_ConsTabEvaD['CaGeOrTR']; ?></div></td>
      <td bgcolor="#FFFFCC"><div align="center"><?php echo $row_ConsTabEvaD['CaGeMaIn']; ?></div></td>
      <td bgcolor="#FFFFCC"><div align="center"><?php echo $row_ConsTabEvaD['CaGeAtCl']; ?></div></td>
      <td bgcolor="#FFFFCC"><div align="center"><?php echo $row_ConsTabEvaD['FaDeCuOp']; ?></div></td>
      <td bgcolor="#FFFFCC"><div align="center"><?php echo $row_ConsTabEvaD['FaDeCoop']; ?></div></td>
      <td bgcolor="#FFFFCC"><div align="center"><?php echo $row_ConsTabEvaD['FaDeComu']; ?></div></td>
      <td bgcolor="#FFFFCC"><div align="center"><?php echo $row_ConsTabEvaD['FaDeAdap']; ?></div></td>
      <td bgcolor="#FFFFCC"><div align="center"><?php echo $row_ConsTabEvaD['CoInPaAc']; ?></div></td>
      <td bgcolor="#FFFFCC"><div align="center"><?php echo $row_ConsTabEvaD['CoInSePe']; ?></div></td>
      <td bgcolor="#FFFFCC"><div align="center"><?php echo $row_ConsTabEvaD['CoInCoOr']; ?></div></td>
      <td bgcolor="#FFFFCC"><div align="center"><?php echo $row_ConsTabEvaD['CoInPrPe']; ?></div></td>
      <td bgcolor="#FFFFCC"><div align="justify"><?php echo $row_ConsTabEvaD['RespUno']; ?></div></td>
      <td bgcolor="#FFFFCC"><div align="center"><?php echo $row_ConsTabEvaD['CaReUno']; ?></div></td>
      <td bgcolor="#FFFFCC"><div align="justify"><?php echo $row_ConsTabEvaD['RespDos']; ?></div></td>
      <td bgcolor="#FFFFCC"><div align="center"><?php echo $row_ConsTabEvaD['CaReDos']; ?></div></td>
      <td bgcolor="#FFFFCC"><div align="justify"><?php echo $row_ConsTabEvaD['RespTres']; ?></div></td>
      <td bgcolor="#FFFFCC"><div align="center"><?php echo $row_ConsTabEvaD['CaReTres']; ?></div></td>
      <td bgcolor="#FFFFCC"><div align="justify"><?php echo $row_ConsTabEvaD['PlMeFort']; ?></div></td>
      <td bgcolor="#FFFFCC"><div align="justify"><?php echo $row_ConsTabEvaD['PlMeAsMe']; ?></div></td>
      <td bgcolor="#FFFFCC"><div align="justify"><?php echo $row_ConsTabEvaD['PlMePlMe']; ?></div></td>
      <td bgcolor="#FFFFCC"><div align="justify"><?php echo $row_ConsTabEvaD['PlMePlAc']; ?></div></td>
      <td bgcolor="#FFFFCC"><div align="justify"><?php echo $row_ConsTabEvaD['CoGePeTf']; ?></div></td>
      <td bgcolor="#FFFFCC"><div align="justify"><?php echo $row_ConsTabEvaD['Evaluador']; ?></div></td>
      <td bgcolor="#FFFFCC"><div align="justify"><?php echo $row_ConsTabEvaD['Evaluado']; ?></div></td>
      <td bgcolor="#FFFFCC"><div align="justify"><?php echo $row_ConsTabEvaD['JefeTH']; ?></div></td>
    </tr>
    <?php } while ($row_ConsTabEvaD = mysql_fetch_assoc($ConsTabEvaD)); ?>
</table>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($ConsTabEvaD);
?>
