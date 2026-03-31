<?php 
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
require("../../Connections/sala2.php");
session_start();
mysql_select_db($database_sala, $sala);   
//echo $_SESSION['codigo'],"session";
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold;}
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
-->
</style>
<head>
<title>Untitled Document</title>

 


<meta http-equiv="Content-Type" conterequire("../../Connections/sala2.php");nt="text/html; charset=utf-8">
<link href="../../Documents%20and%20Settings/Administrador.ORACLE9I/Application%20Data/SSH/temp/estilo3.css" rel="stylesheet" type="text/css">
</head>

<body>
<?php 
$codigoest = $_SESSION['codigo'];
//$scodigomateria=$_SESSION['codigomateria'];
//$scodigodocente=$_SESSION['numerodocumento'];
//$sidgrupo=$_SESSION['idgrupo'];

$scodigomateria=$_GET['jklm'];
$scodigodocente=$_GET['erty'];
$sidgrupo =$_GET['oiyp'];
//$codigoest=$_GET['wzff'];


//echo $scodigodocente,"cedula";
//echo $codigoest,"codigoestudiante";
//echo $scodigomateria,"codigomateria";
//echo $sidgrupo,"grupo";
if(!(isset ($codigoest)))
{
//$codigoest=$_POST['siguiente'] ;
//$ceduladoc=$_POST['cedula'];

}
else
{
//echo "si paso ceduladoc";
}

   $sql1="SELECT DISTINCT 
  estudiante.codigocarrera,
  estudiante.codigoestudiante,
  estudiantegeneral.nombresestudiantegeneral,
  estudiantegeneral.apellidosestudiantegeneral,
  carrera.nombrecarrera
FROM
 estudiante
 INNER JOIN estudiantedocumento ON (estudiante.idestudiantegeneral=estudiantedocumento.idestudiantegeneral)
 INNER JOIN estudiantegeneral ON (estudiantedocumento.idestudiantegeneral=estudiantegeneral.idestudiantegeneral)
 INNER JOIN carrera ON (estudiante.codigocarrera=carrera.codigocarrera)
 INNER JOIN prematricula ON (prematricula.codigoestudiante=estudiante.codigoestudiante)
 INNER JOIN detalleprematricula ON (detalleprematricula.idprematricula=prematricula.idprematricula)
WHERE
  (estudiante.codigoestudiante = '$codigoest')";
	  $resultado=mysql_query($sql1,$sala) or die("$sql1 <br><b>".mysql_error()."<b>");
     //$filaest=mysql_fetch_array($resultado);
	 $filaest = mysql_fetch_assoc($resultado);
	
	   $doce="SELECT DISTINCT nombredocente,apellidodocente
FROM docente
WHERE numerodocumento='$scodigodocente'";
	  $rdoc=mysql_query($doce,$sala) or die("$sql1".mysql_error());
     $tdoc=mysql_fetch_assoc($rdoc); 
		  ?>
<font size="2" face="Tahoma"><strong><em> </em></strong></font><font size="2">&nbsp; 
</font><font size="2" face="Tahoma"><strong><em> </em></strong></font> 
<table width="687" border="0" align="center" cellpadding="2" cellspacing="2">
  <tr>
    <td height="24"><font color="#0066CC" size="4"><strong><?php //echo  $filaest['nombresestudiantegeneral']; ?> <?php //echo  $filaest['apellidosestudiantegeneral']; ?></strong></font></td>
    <td><font color="#0066CC" size="4"><strong><?php //echo  $filaest['codigoestudiante']; ?></strong></font></td>
  </tr>
  <tr>
    <td><font color="#0066CC" size="4"><div class="Estilo2"><?php echo  $filaest['nombrecarrera']; ?></div></td>
    <td><font color="#0066CC" size="4"><div class="Estilo2"><?php echo  $tdoc['nombredocente'];?> <?php echo  $tdoc['apellidodocente'];?></div></td>
  </tr>
</table>
<table width="693" border="1" align="center">
  <tr>
    <td width="683" height="98" bgcolor="#ffffff"> 
      <table width="684" border="1">
      <tr>
          <td width="222" height="46" bgcolor="#fef7ed"> 
            <div class="Estilo1">Conteste la preguntas al frente de cada una de ellas </div></td>
        <td width="446" bgcolor="#C5D5D6"><div class="Estilo1">Conteste las preguntas de cada uno de los criterios </div></td>
      </tr>
    </table>
      <div class="Estilo1"><strong>Nota:</strong><br>
      Las observaciones son obligatorias.<br>
    Si tiene un docente sin definir, en observaci&oacute;nes escriba el nombre del docente que eval&uacute;a.</div></td>
  </tr>
</table>
<p>&nbsp;</p>
<form action="evaluodocente.php" method="post" name="enviar" class="estilo3" id="enviar">
  <div align="center"><font size="2" face="Tahoma"><strong><em> 
  
</em></strong></font><font size="2"> </font><font size="2" face="Tahoma"><strong><em> 
    </em></strong></font><font size="2" face="Tahoma"><strong><em> 
    <input name="scodigomateria" type="hidden" id="scodigomateria2" value="<?php echo $scodigomateria ?>">
    <input name="scodigodocente" type="hidden" id="scodigodocente4" value="<?php echo $scodigodocente ?>">
    <input name="sidgrupo" type="hidden" id="sidgrupo3" value="<?php echo $sidgrupo ?>">
</em></strong></font><font size="2" face="Tahoma"><strong><em> </em></strong></font> 
    <table width="685" border="1" cellspacing="2" cellpadding="2">
      <tr> 
        <td><table width="673" height="144" border="1" align="right" cellpadding="2" cellspacing="2">
            <tr bgcolor="#ffffff"> 
              <td colspan="3" class="estilo2"><em><strong>1ASPECTO: ASIGNATURA</strong></em></td>
            </tr>
            <tr> 
              <td width="136" height="116" bgcolor="#fef7ed"><p class="estilo2"><font size="2" face="Tahoma"><strong>PREGUNTA:</strong><br>
                  El aprendizaje logrado en el curso es bueno?</font></p>
                <p>&nbsp;              </p></td>
              <td width="75" bgcolor="#fef7ed"><table width="75" height="105" border="0" align="center">
                  <tr>
                    <td width="69"><div align="center"><font size="1" face="Tahoma">Total acuerdo</font> </div></td>
                  </tr>
                  <tr>
                    <td><div align="center">
                      <input type="radio" name="resp1" value="t">
</div></td>
                  </tr>
                  <tr>
                    <td><div align="center"><font size="1" face="Tahoma">De acuerdo</font> 
                    </div></td>
                  </tr>
                  <tr>
                    <td><div align="center">
                      <input type="radio" name="resp1" value="a">
</div></td>
                  </tr>
                  <tr>
                    <td><font size="1" face="Tahoma">Parcialmente de Acuerdo</font></td>
                  </tr>
                  <tr>
                    <td><div align="center">
                      <input type="radio" name="resp1" value="p">
                    </div></td>
                  </tr>
                  <tr>
                    <td><font size="1" face="Tahoma">Desacuerdo</font></td>
                  </tr>
                  <tr>
                    <td><div align="center">
                      <input type="radio" name="resp1" value="d">
                    </div></td>
                  </tr>
                </table>
              <div align="right"></div></td>
              <td width="433" bgcolor="#FFFFFF"><table width="433" border="0">
                <tr bgcolor="#C5D5D6">
                  <td width="317"><div align="justify"><span class="estilo2"><font size="2" face="Tahoma">Cumplimiento de los objetivos y el programa de la asignatura</font></span></div></td>
                  <td width="98"><div align="center">
                    <select name="respa1" id="respa1">
                        <option value="0" style="color:#FF3300 "selected>SELECCIONE</option>
                        <option value="e">EXCELENTE</option>
                        <option value="b">BUENO</option>
                        <option value="r">REGULAR</option>
                        <option value="d">DEFICIENTE</option>
                        <option value="n">NO APLICA</option>
                    </select>
                  </div></td>
                </tr>
                <tr bgcolor="#FEF7ED">
                  <td><div align="justify"><span class="estilo2"><font size="2" face="Tahoma">Aporte de la asignatura en nuevos conocimientos y habilidades para la formaci&oacute;n</font></span></div></td>
                  <td><div align="center">
                    <select name="respb1" id="respb1">
                        <option value="0" style="color:#FF3300 "selected>SELECCIONE</option>
                        <option value="e">EXCELENTE</option>
                        <option value="b">BUENO</option>
                        <option value="r">REGULAR</option>
                        <option value="d">DEFICIENTE</option>
                        <option value="n">NO APLICA</option>
                    </select>
                  </div></td>
                </tr>
                <tr bgcolor="#C5D5D6">
                  <td><div align="justify"><span class="estilo2"><font size="2" face="Tahoma">Contribuci&oacute;n de la asignatura al desarrollo de las competencias para el desempe&ntilde;o del profesional </font></span></div></td>
                  <td><div align="center">
                    <select name="respc1" id="respc1">
                      <option value="0" style="color:#FF3300 "selected>SELECCIONE</option>
                      <option value="e">EXCELENTE</option>
                      <option value="b">BUENO</option>
                      <option value="r">REGULAR</option>
                      <option value="d">DEFICIENTE</option>
                      <option value="n">NO APLICA</option>
                    </select>
</div></td>
                </tr>
              </table>                
              </td>
            </tr>
          </table></td>
      </tr>
      <tr> 
        <td><table width="673" height="144" border="1" align="right" cellpadding="2" cellspacing="2">
          <tr bgcolor="#ffffff">
            <td colspan="3" class="estilo2"><em><strong>2 ASPECTO: CUMPLIMIENTO DE LOS PLANES DE TRABAJO</strong></em></td>
          </tr>
          <tr>
            <td width="136" height="116" bgcolor="#fef7ed"><p align="left" class="estilo2"><font size="2" face="Tahoma"><strong>PREGUNTA:</strong><br>
        El docente cumple con el plan de trabajo propuesto para el desarrollo de la asignatura?</font></p>
                <p>&nbsp; </p></td>
            <td width="75" bgcolor="#fef7ed"><table width="75" height="105" border="0" align="center">
              <tr>
                <td width="69"><div align="center"><font size="1" face="Tahoma">Total acuerdo</font> </div></td>
              </tr>
              <tr>
                <td><div align="center">
                    <input type="radio" name="resp2" value="t">
                </div></td>
              </tr>
              <tr>
                <td><div align="center"><font size="1" face="Tahoma">De acuerdo</font> </div></td>
              </tr>
              <tr>
                <td><div align="center">
                  <input type="radio" name="resp2" value="a">
</div></td>
              </tr>
              <tr>
                <td><font size="1" face="Tahoma">Parcialmente de Acuerdo</font></td>
              </tr>
              <tr>
                <td><div align="center">
                  <input type="radio" name="resp2" value="p">
                </div></td>
              </tr>
              <tr>
                <td><font size="1" face="Tahoma">Desacuerdo</font></td>
              </tr>
              <tr>
                <td><div align="center">
                  <input type="radio" name="resp2" value="d">
</div></td>
              </tr>
            </table>
            <div align="right"></div></td>
            <td width="433" bgcolor="#FFFFFF"><table width="433" border="0">
                <tr bgcolor="#C5D5D6">
                  <td width="317"><div align="left"><span class="estilo2"><font size="2" face="Tahoma">Entrega formalmente el programa y reglas establecidas al comenzar el semestre.</font></span></div></td>
                  <td width="98"><div align="center">
                      <select name="respa2" id="respa2">
                        <option value="0" style="color:#FF3300 "selected>SELECCIONE</option>
                        <option value="e">EXCELENTE</option>
                        <option value="b">BUENO</option>
                        <option value="r">REGULAR</option>
                        <option value="d">DEFICIENTE</option>
                        <option value="n">NO APLICA</option>
                      </select>
                  </div></td>
                </tr>
                <tr bgcolor="#FEF7ED">
                  <td><div align="left"><span class="estilo2"><font size="2" face="Tahoma">Produce documentos y materiales para el desarrollo de la asignatura.</font></span></div></td>
                  <td><div align="center">
                      <select name="respb2" id="respb2">
                        <option value="0" style="color:#FF3300 "selected>SELECCIONE</option>
                        <option value="e">EXCELENTE</option>
                        <option value="b">BUENO</option>
                        <option value="r">REGULAR</option>
                        <option value="d">DEFICIENTE</option>
                        <option value="n">NO APLICA</option>
                      </select>
                  </div></td>
                </tr>
                <tr bgcolor="#C5D5D6">
                  <td><div align="left"><span class="estilo2"><font size="2" face="Tahoma">Cumple con los temas y objetivos del contenido de la asignatura.</font></span></div></td>
                  <td><div align="center">
                      <select name="respc2" id="respc2">
                        <option value="0" style="color:#FF3300 "selected>SELECCIONE</option>
                        <option value="e">EXCELENTE</option>
                        <option value="b">BUENO</option>
                        <option value="r">REGULAR</option>
                        <option value="d">DEFICIENTE</option>
                        <option value="n">NO APLICA</option>
                      </select>
                  </div></td>
                </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr> 
        <td><table width="673" height="144" border="1" align="right" cellpadding="2" cellspacing="2">
          <tr bgcolor="#ffffff">
            <td colspan="3" class="estilo2"><em><strong>3 ASPECTO: DESTREZAS  PEDAGÓGICA</strong></em></td>
          </tr>
          <tr>
            <td width="136" height="116" bgcolor="#fef7ed"><p align="left" class="estilo2"><font size="2" face="Tahoma"><strong>PREGUNTA:</strong><br>
        Las destrezas pedag&oacute;gicas del docente son las adecuadas para el desarrollo de la asignatura?</font></p>
                <p>&nbsp; </p></td>
            <td width="75" bgcolor="#fef7ed"><table width="75" height="105" border="0" align="center">
              <tr>
                <td width="69"><div align="center"><font size="1" face="Tahoma">Total acuerdo</font> </div></td>
              </tr>
              <tr>
                <td><div align="center">
                    <input type="radio" name="resp3" value="t">
                </div></td>
              </tr>
              <tr>
                <td><div align="center"><font size="1" face="Tahoma">De acuerdo</font> </div></td>
              </tr>
              <tr>
                <td><div align="center">
                  <input type="radio" name="resp3" value="a">
</div></td>
              </tr>
              <tr>
                <td><font size="1" face="Tahoma">Parcialmente de Acuerdo</font></td>
              </tr>
              <tr>
                <td><div align="center">
                    <input type="radio" name="resp3" value="p">
                </div></td>
              </tr>
              <tr>
                <td><font size="1" face="Tahoma">Desacuerdo</font></td>
              </tr>
              <tr>
                <td><div align="center">
                    <input type="radio" name="resp3" value="d">
                </div></td>
              </tr>
            </table>
            <div align="right"></div></td>
            <td width="433" bgcolor="#FFFFFF"><table width="433" border="0">
                <tr bgcolor="#C5D5D6">
                  <td width="317"><div align="left"><span class="estilo2"><font size="2" face="Tahoma">Domina los temas de la asignatura.</font></span></div></td>
                  <td width="98"><div align="center">
                      <select name="respa3" id="respa3">
                        <option value="0" style="color:#FF3300 "selected>SELECCIONE</option>
                        <option value="e">EXCELENTE</option>
                        <option value="b">BUENO</option>
                        <option value="r">REGULAR</option>
                        <option value="d">DEFICIENTE</option>
                        <option value="n">NO APLICA</option>
                      </select>
                  </div></td>
                </tr>
                <tr bgcolor="#FEF7ED">
                  <td><div align="left"><span class="estilo2"><font size="2" face="Tahoma">Tiene un adecuado manejo y control del Grupo.</font></span></div></td>
                  <td><div align="center">
                      <select name="respb3" id="respb3">
                        <option value="0" style="color:#FF3300 "selected>SELECCIONE</option>
                        <option value="e">EXCELENTE</option>
                        <option value="b">BUENO</option>
                        <option value="r">REGULAR</option>
                        <option value="d">DEFICIENTE</option>
                        <option value="n">NO APLICA</option>
                      </select>
                  </div></td>
                </tr>
                <tr bgcolor="#C5D5D6">
                  <td><div align="left"><span class="estilo2"><font size="2" face="Tahoma">Tiene orden, claridad y coherencia en los temas tratados.</font></span></div></td>
                  <td><div align="center">
                      <select name="respc3" id="respc3">
                        <option value="0" style="color:#FF3300 "selected>SELECCIONE</option>
                        <option value="e">EXCELENTE</option>
                        <option value="b">BUENO</option>
                        <option value="r">REGULAR</option>
                        <option value="d">DEFICIENTE</option>
                        <option value="n">NO APLICA</option>
                      </select>
                  </div></td>
                </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr> 
        <td><table width="673" height="144" border="1" align="right" cellpadding="2" cellspacing="2">
          <tr bgcolor="#ffffff">
            <td colspan="3" class="estilo2"><em><strong>4 PUNTUALIDAD EN COMPROMISOS ACAD&Eacute;MICOS</strong></em></td>
          </tr>
          <tr>
            <td width="136" height="116" bgcolor="#fef7ed"><p align="left" class="estilo2"><font size="2" face="Tahoma"><strong>PREGUNTA:<BR></strong>El docente cumple con las actividades acad&eacute;micas definidas?</font></p>
              <p>&nbsp; </p></td>
            <td width="75" bgcolor="#fef7ed"><table width="75" height="105" border="0" align="center">
              <tr>
                <td width="69"><div align="center"><font size="1" face="Tahoma">Total acuerdo</font> </div></td>
              </tr>
              <tr>
                <td><div align="center">
                    <input type="radio" name="resp4" value="t">
                </div></td>
              </tr>
              <tr>
                <td><div align="center"><font size="1" face="Tahoma">De acuerdo</font> </div></td>
              </tr>
              <tr>
                <td><div align="center">
                    <input type="radio" name="resp4" value="a">
                </div></td>
              </tr>
              <tr>
                <td><font size="1" face="Tahoma">Parcialmente de Acuerdo</font></td>
              </tr>
              <tr>
                <td><div align="center">
                    <input type="radio" name="resp4" value="p">
                </div></td>
              </tr>
              <tr>
                <td><font size="1" face="Tahoma">Desacuerdo</font></td>
              </tr>
              <tr>
                <td><div align="center">
                    <input type="radio" name="resp4" value="d">
                </div></td>
              </tr>
            </table>
            <div align="right"></div></td>
            <td width="433" bgcolor="#FFFFFF"><table width="433" border="0">
                <tr bgcolor="#C5D5D6">
                  <td width="317"><div align="left"><span class="estilo2"><font size="2" face="Tahoma">Asiste a las clases programadas del semestre.</font></span></div></td>
                  <td width="98"><div align="center">
                      <select name="respa4" id="respa4">
                        <option value="0" style="color:#FF3300 "selected>SELECCIONE</option>
                        <option value="e">EXCELENTE</option>
                        <option value="b">BUENO</option>
                        <option value="r">REGULAR</option>
                        <option value="d">DEFICIENTE</option>
                        <option value="n">NO APLICA</option>
                      </select>
                  </div></td>
                </tr>
                <tr bgcolor="#FEF7ED">
                  <td><div align="left"><span class="estilo2"><font size="2" face="Tahoma">Es facil de localizar y cumple los horarios establecidos para las tutor&iacute;as o asesor&iacute;as.</font></span></div></td>
                  <td><div align="center">
                      <select name="respb4" id="respb4">
                        <option value="0" style="color:#FF3300 "selected>SELECCIONE</option>
                        <option value="e">EXCELENTE</option>
                        <option value="b">BUENO</option>
                        <option value="r">REGULAR</option>
                        <option value="d">DEFICIENTE</option>
                        <option value="n">NO APLICA</option>
                      </select>
                  </div></td>
                </tr>
                <tr bgcolor="#C5D5D6">
                  <td><div align="left"><span class="estilo2"><font size="2" face="Tahoma">Inicia y termina las clases a las horas establecidas.</font></span></div></td>
                  <td><div align="center">
                      <select name="respc4" id="respc4">
                        <option value="0" style="color:#FF3300 "selected>SELECCIONE</option>
                        <option value="e">EXCELENTE</option>
                        <option value="b">BUENO</option>
                        <option value="r">REGULAR</option>
                        <option value="d">DEFICIENTE</option>
                        <option value="n">NO APLICA</option>
                      </select>
                  </div></td>
                </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr> 
        <td><table width="673" height="144" border="1" align="right" cellpadding="2" cellspacing="2">
          <tr bgcolor="#ffffff">
            <td colspan="3" class="estilo2"><em><strong>5 ASPECTO: RELACIONES INTERPERSONALES</strong></em></td>
          </tr>
          <tr>
            <td width="136" height="116" bgcolor="#fef7ed"><p align="left" class="estilo2"><font size="2" face="Tahoma"><strong>PREGUNTA:<BR></strong>La relaci&oacute;n personal establecida entre los estudiantes y el docente, es adecuada para el desarrollo de la asignatura?</font></p>
                <p>&nbsp; </p></td>
            <td width="75" bgcolor="#fef7ed"><div align="right">
              <table width="75" height="105" border="0" align="center">
                <tr>
                  <td width="69"><div align="center"><font size="1" face="Tahoma">Total acuerdo</font> </div></td>
                </tr>
                <tr>
                  <td><div align="center">
                    <input type="radio" name="resp5" value="t">
</div></td>
                </tr>
                <tr>
                  <td><div align="center"><font size="1" face="Tahoma">De acuerdo</font> </div></td>
                </tr>
                <tr>
                  <td><div align="center">
                    <input type="radio" name="resp5" value="a">
</div></td>
                </tr>
                <tr>
                  <td><font size="1" face="Tahoma">Parcialmente de Acuerdo</font></td>
                </tr>
                <tr>
                  <td><div align="center">
                      <input type="radio" name="resp5" value="p">
                  </div></td>
                </tr>
                <tr>
                  <td><font size="1" face="Tahoma">Desacuerdo</font></td>
                </tr>
                <tr>
                  <td><div align="center">
                      <input type="radio" name="resp5" value="d">
                  </div></td>
                </tr>
              </table>
            </div></td>
            <td width="433" bgcolor="#FFFFFF"><table width="433" border="0">
                <tr bgcolor="#C5D5D6">
                  <td width="317"><div align="left"><span class="estilo2"><font size="2" face="Tahoma">Manifiesta respecto y tolerancia con los estudiantes.</font></span></div></td>
                  <td width="98"><div align="center">
                      <select name="respa5" id="respa5">
                        <option value="0" style="color:#FF3300 "selected>SELECCIONE</option>
                        <option value="e">EXCELENTE</option>
                        <option value="b">BUENO</option>
                        <option value="r">REGULAR</option>
                        <option value="d">DEFICIENTE</option>
                        <option value="n">NO APLICA</option>
                      </select>
                  </div></td>
                </tr>
                <tr bgcolor="#FEF7ED">
                  <td><div align="left"><span class="estilo2"><font size="2" face="Tahoma">Establece las pautas para el trabajo en grupo desde el comienzo de semestre.</font></span></div></td>
                  <td><div align="center">
                      <select name="respb5" id="respb5">
                        <option value="0" style="color:#FF3300 "selected>SELECCIONE</option>
                        <option value="e">EXCELENTE</option>
                        <option value="b">BUENO</option>
                        <option value="r">REGULAR</option>
                        <option value="d">DEFICIENTE</option>
                        <option value="n">NO APLICA</option>
                      </select>
                  </div></td>
                </tr>
                <tr bgcolor="#C5D5D6">
                  <td><div align="left"><span class="estilo2"><font size="2" face="Tahoma">Promueve la participaci&oacute;n de equipos de trabajo en encuentros acad&eacute;micos con la comunidad acad&eacute;mica dentro y fuera de la universidad.</font></span></div></td>
                  <td><div align="center">
                      <select name="respc5" id="respc5">
                        <option value="0" style="color:#FF3300 "selected>SELECCIONE</option>
                        <option value="e">EXCELENTE</option>
                        <option value="b">BUENO</option>
                        <option value="r">REGULAR</option>
                        <option value="d">DEFICIENTE</option>
                        <option value="n">NO APLICA</option>
                      </select>
                  </div></td>
                </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr> 
        <td><table width="673" height="144" border="1" align="right" cellpadding="2" cellspacing="2">
          <tr bgcolor="#ffffff">
            <td colspan="3" class="estilo2"><em><strong>6 ASPECTO: APOYO AL TRABAJO DE LOS ESTUDIANTES</strong></em></td>
          </tr>
          <tr>
            <td width="136" height="116" bgcolor="#fef7ed"><p align="left" class="estilo2"><font size="2" face="Tahoma"><strong>PREGUNTA:<BR></strong>El estudiante encuentra el apoyo necesario por parte del docente en su proceso de aprendizaje?</font></p>
              <p>&nbsp; </p></td>
            <td width="75" bgcolor="#fef7ed"><table width="75" height="105" border="0" align="center">
              <tr>
                <td width="69"><div align="center"><font size="1" face="Tahoma">Total acuerdo</font> </div></td>
              </tr>
              <tr>
                <td><div align="center">
                    <input type="radio" name="resp6" value="t">
                </div></td>
              </tr>
              <tr>
                <td><div align="center"><font size="1" face="Tahoma">De acuerdo</font> </div></td>
              </tr>
              <tr>
                <td><div align="center">
                    <input type="radio" name="resp6" value="a">
                </div></td>
              </tr>
              <tr>
                <td><font size="1" face="Tahoma">Parcialmente de Acuerdo</font></td>
              </tr>
              <tr>
                <td><div align="center">
                    <input type="radio" name="resp6" value="p">
                </div></td>
              </tr>
              <tr>
                <td><font size="1" face="Tahoma">Desacuerdo</font></td>
              </tr>
              <tr>
                <td><div align="center">
                    <input type="radio" name="resp6" value="d">
                </div></td>
              </tr>
            </table>
            <div align="right"></div></td>
            <td width="433" bgcolor="#FFFFFF"><table width="433" border="0">
                <tr bgcolor="#C5D5D6">
                  <td width="317"><div align="left"><span class="estilo2"><font size="2" face="Tahoma">Realiza actividades y promueve espacios adicionales que ayuden al estudiante a comprender los temas de la asignatura.</span></div></td>
                  <td width="98"><div align="center">
                      <select name="respa6" id="respa6">
                        <option value="0" style="color:#FF3300 "selected>SELECCIONE</option>
                        <option value="e">EXCELENTE</option>
                        <option value="b">BUENO</option>
                        <option value="r">REGULAR</option>
                        <option value="d">DEFICIENTE</option>
                        <option value="n">NO APLICA</option>
                      </select>
                  </div></td>
                </tr>
                <tr bgcolor="#FEF7ED">
                  <td><div align="left"><span class="estilo2"><font size="2" face="Tahoma">Hace seguimiento al trabajo individual del estudiante.</span></div></td>
                  <td><div align="center">
                      <select name="respb6" id="respb6">
                        <option value="0" style="color:#FF3300 "selected>SELECCIONE</option>
                        <option value="e">EXCELENTE</option>
                        <option value="b">BUENO</option>
                        <option value="r">REGULAR</option>
                        <option value="d">DEFICIENTE</option>
                        <option value="n">NO APLICA</option>
                      </select>
                  </div></td>
                </tr>
                <tr bgcolor="#C5D5D6">
                  <td><div align="left"><span class="estilo2"> Resuelve adecuadamente las inquietudes presentadas por los estudiantes.</span></div></td>
                  <td><div align="center">
                      <select name="respc6" id="respc6">
                        <option value="0" style="color:#FF3300 "selected>SELECCIONE</option>
                        <option value="e">EXCELENTE</option>
                        <option value="b">BUENO</option>
                        <option value="r">REGULAR</option>
                        <option value="d">DEFICIENTE</option>
                        <option value="n">NO APLICA</option>
                      </select>
                  </div></td>
                </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr> 
        <td><table width="673" height="144" border="1" align="right" cellpadding="2" cellspacing="2">
          <tr bgcolor="#ffffff">
            <td colspan="3" class="estilo2"><em><strong>7 ASPECTO: APOYO A LA INVESTIGACIÓN</strong></em></td>
          </tr>
          <tr>
            <td width="136" height="116" bgcolor="#fef7ed"><p align="left" class="estilo2"><font size="2" face="Tahoma"><strong>PREGUNTA:</strong><br>
        El docente promociona de la formaci&oacute;n investigativa?</font></p>
                <p>&nbsp; </p></td>
            <td width="75" bgcolor="#fef7ed"><table width="75" height="105" border="0" align="center">
              <tr>
                <td width="69"><div align="center"><font size="1" face="Tahoma">Total acuerdo</font> </div></td>
              </tr>
              <tr>
                <td><div align="center">
                  <input type="radio" name="resp7" value="t">
</div></td>
              </tr>
              <tr>
                <td><div align="center"><font size="1" face="Tahoma">De acuerdo</font> </div></td>
              </tr>
              <tr>
                <td><div align="center">
                    <input type="radio" name="resp7" value="a">
                </div></td>
              </tr>
              <tr>
                <td><font size="1" face="Tahoma">Parcialmente de Acuerdo</font></td>
              </tr>
              <tr>
                <td><div align="center">
                    <input type="radio" name="resp7" value="p">
                </div></td>
              </tr>
              <tr>
                <td><font size="1" face="Tahoma">Desacuerdo</font></td>
              </tr>
              <tr>
                <td><div align="center">
                    <input type="radio" name="resp7" value="d">
                </div></td>
              </tr>
            </table>
            <div align="right"></div></td>
            <td width="433" bgcolor="#FFFFFF"><table width="433" border="0">
                <tr bgcolor="#C5D5D6">
                  <td width="317"><div align="left"><span class="estilo2"><font size="2" face="Tahoma">Genera espacios en sus asignaturas para investigar y profundizar sobre diferentes temas.</span></div></td>
                  <td width="98"><div align="center">
                      <select name="respa7" id="respa7">
                        <option value="0" style="color:#FF3300 "selected>SELECCIONE</option>
                        <option value="e">EXCELENTE</option>
                        <option value="b">BUENO</option>
                        <option value="r">REGULAR</option>
                        <option value="d">DEFICIENTE</option>
                        <option value="n">NO APLICA</option>
                      </select>
                  </div></td>
                </tr>
                <tr bgcolor="#FEF7ED">
                  <td><div align="left"><span class="estilo2"><font size="2" face="Tahoma">Actualiza los contenidos de las asignaturas a partir de nuevas investigaciones y conceptos.</span></div></td>
                  <td><div align="center">
                      <select name="respb7" id="respb7">
                        <option value="0" style="color:#FF3300 "selected>SELECCIONE</option>
                        <option value="e">EXCELENTE</option>
                        <option value="b">BUENO</option>
                        <option value="r">REGULAR</option>
                        <option value="d">DEFICIENTE</option>
                        <option value="n">NO APLICA</option>
                      </select>
                  </div></td>
                </tr>
                <tr bgcolor="#C5D5D6">
                  <td><div align="left"><span class="estilo2"><font size="2" face="Tahoma">Desarrolla proyectos de investigaci&oacute;n conjuntos con otras disciplinas.</span></div></td>
                  <td><div align="center">
                      <select name="respc7" id="respc7">
                        <option value="0" style="color:#FF3300 "selected>SELECCIONE</option>
                        <option value="e">EXCELENTE</option>
                        <option value="b">BUENO</option>
                        <option value="r">REGULAR</option>
                        <option value="d">DEFICIENTE</option>
                        <option value="n">NO APLICA</option>
                      </select>
                  </div></td>
                </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr> 
        <td><table width="673" height="144" border="1" align="right" cellpadding="2" cellspacing="2">
          <tr bgcolor="#ffffff">
            <td colspan="3" class="estilo2"><em><strong>8 ASPECTO: EVALUACIÓN DEL  APRENDIZAJE </strong></em></td>
          </tr>
          <tr>
            <td width="136" height="116" bgcolor="#fef7ed"><p align="left" class="estilo2"><font size="2" face="Tahoma"><strong>PREGUNTA:</strong><br>
        El sistema de evaluaci&oacute;n aplicado promueve la formaci&oacute;n profesional?</font></p>
                <p>&nbsp; </p></td>
            <td width="75" bgcolor="#fef7ed"><table width="75" height="105" border="0" align="center">
              <tr>
                <td width="69"><div align="center"><font size="1" face="Tahoma">Total acuerdo</font> </div></td>
              </tr>
              <tr>
                <td><div align="center">
                    <input type="radio" name="resp8" value="t">
                </div></td>
              </tr>
              <tr>
                <td><div align="center"><font size="1" face="Tahoma">De acuerdo</font> </div></td>
              </tr>
              <tr>
                <td><div align="center">
                    <input type="radio" name="resp8" value="a">
                </div></td>
              </tr>
              <tr>
                <td><font size="1" face="Tahoma">Parcialmente de Acuerdo</font></td>
              </tr>
              <tr>
                <td><div align="center">
                  <input type="radio" name="resp8" value="p">
</div></td>
              </tr>
              <tr>
                <td><font size="1" face="Tahoma">Desacuerdo</font></td>
              </tr>
              <tr>
                <td><div align="center">
                    <input type="radio" name="resp8" value="d">
                </div></td>
              </tr>
            </table>
            <div align="right"></div></td>
            <td width="433" bgcolor="#FFFFFF"><table width="433" border="0">
                <tr bgcolor="#C5D5D6">
                  <td width="317"><div align="left"><span class="estilo2"><font size="2" face="Tahoma">Las evaluaciones corresponden a los temas cubiertos dentro de la asignatura.</span></div></td>
                  <td width="98"><div align="center">
                      <select name="respa8" id="respa8">
                        <option value="0" style="color:#FF3300 "selected>SELECCIONE</option>
                        <option value="e">EXCELENTE</option>
                        <option value="b">BUENO</option>
                        <option value="r">REGULAR</option>
                        <option value="d">DEFICIENTE</option>
                        <option value="n">NO APLICA</option>
                      </select>
                  </div></td>
                </tr>
                <tr bgcolor="#FEF7ED">
                  <td><div align="left"><span class="estilo2"><font size="2" face="Tahoma">Realiza retroalimentaci&oacute;n a los estudiantes en su proceso de evaluaci&oacute;n.</span></div></td>
                  <td><div align="center">
                      <select name="respb8" id="respb8">
                        <option value="0" style="color:#FF3300 "selected>SELECCIONE</option>
                        <option value="e">EXCELENTE</option>
                        <option value="b">BUENO</option>
                        <option value="r">REGULAR</option>
                        <option value="d">DEFICIENTE</option>
                        <option value="n">NO APLICA</option>
                      </select>
                  </div></td>
                </tr>
                <tr bgcolor="#C5D5D6">
                  <td><div align="left"><span class="estilo2"><font size="2" face="Tahoma">Las notas de las evaluaciones se entregan oportunamente.</span></div></td>
                  <td><div align="center">
                      <select name="respc8" id="respc8">
                        <option value="0" style="color:#FF3300 "selected>SELECCIONE</option>
                        <option value="e">EXCELENTE</option>
                        <option value="b">BUENO</option>
                        <option value="r">REGULAR</option>
                        <option value="d">DEFICIENTE</option>
                        <option value="n">NO APLICA</option>
                      </select>
                  </div></td>
                </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr> 
        <td><table width="673" height="144" border="1" align="right" cellpadding="2" cellspacing="2">
          <tr bgcolor="#ffffff">
            <td colspan="3" class="estilo2"><em><strong>9 ASPECTO: RECURSOS</strong></em></td>
          </tr>
          <tr>
            <td width="136" height="116" bgcolor="#fef7ed"><p align="left" class="estilo2"><font size="2" face="Tahoma"><strong>PREGUNTA:</strong><br>
        Para el desarrollo de la asignatura se cuenta con los recursos necesarios?</font></p>
                <p>&nbsp; </p></td>
            <td width="75" bgcolor="#fef7ed"><table width="75" height="105" border="0" align="center">
              <tr>
                <td width="69"><div align="center"><font size="1" face="Tahoma">Total acuerdo</font> </div></td>
              </tr>
              <tr>
                <td><div align="center">
                    <input type="radio" name="resp9" value="t">
                </div></td>
              </tr>
              <tr>
                <td><div align="center"><font size="1" face="Tahoma">De acuerdo</font> </div></td>
              </tr>
              <tr>
                <td><div align="center">
                    <input type="radio" name="resp9" value="a">
                </div></td>
              </tr>
              <tr>
                <td><font size="1" face="Tahoma">Parcialmente de Acuerdo</font></td>
              </tr>
              <tr>
                <td><div align="center">
                    <input type="radio" name="resp9" value="p">
                </div></td>
              </tr>
              <tr>
                <td><font size="1" face="Tahoma">Desacuerdo</font></td>
              </tr>
              <tr>
                <td><div align="center">
                  <input type="radio" name="resp9" value="d">
</div></td>
              </tr>
            </table>
            <div align="right"></div></td>
            <td width="433" bgcolor="#FFFFFF"><table width="433" border="0">
                <tr bgcolor="#C5D5D6">
                  <td width="317"><div align="left"><span class="estilo2"><font size="2" face="Tahoma">Utilizaci&oacute;n de alg&uacute;n tipo de ayudas did&aacute;cticas o audiovisuales.</span></div></td>
                  <td width="98"><div align="center">
                      <select name="respa9" id="respa9">
                        <option value="0" style="color:#FF3300 "selected>SELECCIONE</option>
                        <option value="e">EXCELENTE</option>
                        <option value="b">BUENO</option>
                        <option value="r">REGULAR</option>
                        <option value="d">DEFICIENTE</option>
                        <option value="n">NO APLICA</option>
                      </select>
                  </div></td>
                </tr>
                <tr bgcolor="#FEF7ED">
                  <td><div align="left"><span class="estilo2"><font size="2" face="Tahoma">Utilizaci&oacute;n de recursos bibliogr&aacute;ficos, lecturas y material impreso.</span></div></td>
                  <td><div align="center">
                      <select name="respb9" id="respb9">
                        <option value="0" style="color:#FF3300 "selected>SELECCIONE</option>
                        <option value="e">EXCELENTE</option>
                        <option value="b">BUENO</option>
                        <option value="r">REGULAR</option>
                        <option value="d">DEFICIENTE</option>
                        <option value="n">NO APLICA</option>
                      </select>
                  </div></td>
                </tr>
                <tr bgcolor="#C5D5D6">
                  <td><div align="left"><span class="estilo2"><font size="2" face="Tahoma">Utilizaci&oacute;n de recursos Inform&aacute;ticos.</span></div></td>
                  <td><div align="center">
                      <select name="respc9" id="respc9">
                        <option value="0" style="color:#FF3300 "selected>SELECCIONE</option>
                        <option value="e">EXCELENTE</option>
                        <option value="b">BUENO</option>
                        <option value="r">REGULAR</option>
                        <option value="d">DEFICIENTE</option>
                        <option value="n">NO APLICA</option>
                      </select>
                  </div></td>
                </tr>
                <tr bgcolor="#C5D5D6">
                  <td><div align="left"><span class="estilo2"><font size="2" face="Tahoma">Adecuada orientaci&oacute;n para la utilizaci&oacute;n de los recursos bibliogr&aacute;ficos e inform&aacute;ticos.</td>
                  <td><select name="respd9" id="respd9">
                    <option value="0" style="color:#FF3300 "selected>SELECCIONE</option>
                    <option value="e">EXCELENTE</option>
                    <option value="b">BUENO</option>
                    <option value="r">REGULAR</option>
                    <option value="d">DEFICIENTE</option>
                    <option value="n">NO APLICA</option>
                  </select></td>
                </tr>
                <tr bgcolor="#C5D5D6">
                  <td><div align="left"><span class="estilo2"><font size="2" face="Tahoma">Adecuada distribuci&oacute;n de salones de clase, laboratorios y salas de inform&aacute;tica.</td>
                  <td><select name="respe9" id="respe9">
                    <option value="0" style="color:#FF3300 "selected>SELECCIONE</option>
                    <option value="e">EXCELENTE</option>
                    <option value="b">BUENO</option>
                    <option value="r">REGULAR</option>
                    <option value="d">DEFICIENTE</option>
                    <option value="n">NO APLICA</option>
                  </select></td>
                </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
	  
      <tr bgcolor="#fef7ed"> 
        <td colspan="2"><textarea name="respac" cols="80" id="respac"></textarea></td>
    </tr>
    </table>
  <font size="2" face="Tahoma"><strong><em> </em></strong></font> </div>
  <p align="center"> 
    <input name="enviar" type="submit" id="enviar" value="enviar">
  </p>
</form>
<p>&nbsp;</p>
<p>&nbsp;</p></body>
</html>
