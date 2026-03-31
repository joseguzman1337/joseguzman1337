<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION); 
?>
<STYLE>

 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
</STYLE>
<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 11px}
.verdoso {background-color: #CCDADD;font-family: Tahoma; font-size: 12px; font-weight: bold;}
.amarrillento {background-color: #FEF7ED;font-family: Tahoma; font-size: 11px}
.Estilo6 {font-size: 11px}
.Estilo5 {font-family: Tahoma; font-size: 12px; }
.Estilo7 {font-size: 11px; font-weight: bold; }
-->
</style>
<?php
@session_start();
$fechahoy=date("Y-m-d H:i:s");
require_once("datos_basicos.php");
error_reporting(2048);
//setlocale(LC_CTYPE,'es_ES');
setlocale(LC_ALL,'es_ES');
/* $query_codigoperiodo="select p.codigoperiodo from periodo p where p.codigoestadoperiodo='1'";
$bd_codigoperiodo=$sala->query($query_codigoperiodo);
$row_codigoperiodo=$bd_codigoperiodo->fetchRow();
$codigoperiodo=$row_codigoperiodo['codigoperiodo'];
 */
/* $codigoestudiante='9398';
$codigoperiodo='20052';
$numerocorte=0;*/
$estudiante = new estudiante;
$numerocorte=$_GET['numerocorte'];
$codigoestudiante=$_GET['codigoestudiante'];
$codigoperiodo=$_SESSION['codigoperiodosesion'];
$row_datos_basicos=$estudiante->obtener_datos_basicos_estudiante($codigoestudiante,$codigoperiodo,$numerocorte,$sala);
$row_materias_estudiante=$estudiante->obtener_materias_estudiante();
$row_areas_materias=$estudiante->obtener_areas_materias();
$row_datos_corte=$estudiante->obtener_datos_corte();
$row_notasestudiante=$estudiante->obtener_notas_estudiante();
$row_equivalencias=$estudiante->obtener_equivalencias_notas();
$row_universidad=$estudiante->datos_universidad();
$semestre_estudiante=$estudiante->obtener_semestre_estudiante();
$curso_estudiante=$estudiante->obtener_curso_estudiante();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Documento sin t&iacute;tulo</title>
</head>

<body>
<form name="form1" method="post" action="">
<table width="100%" border="0" align="center">
  <tr>
    <td><div align="center"><br>
          <span class="Estilo5">			<br>
		  </span>
          <H2 style="MARGIN: 0cm 0cm 0pt"><font size="2" face="Arial"><SPAN lang=ES-CO 
style="mso-ansi-language: ES-CO">COLEGIO BILING&Uuml;E DE LA UNIVERSIDAD EL BOSQUE<o:p></o:p></SPAN></font></H2>
          <P class=MsoNormal style="MARGIN: 0cm 0cm 0pt; TEXT-ALIGN: center" 
align=center><font size="2" face="Arial"><SPAN lang=ES-CO 
style="FONT-SIZE: 10pt; mso-bidi-font-size: 12.0pt">Resoluci&oacute;n 1076 del 19 de Marzo de 1999 S.E.D.<o:p></o:p></SPAN></font></P>
          <span class="Estilo5"><br>
            <?php echo $row_universidad['entidadrigeuniversidad'];?><br>
          </span></div></td>
  </tr>
</table>
<p>&nbsp;</p>
<table width="100%"  border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <td><table width="100%"  border="0">
      <tr class="Estilo6">
        <td width="14%" nowrap>NOMBRE DEL ALUMNO:</td>
        <td width="32%"><?php echo strtoupper($row_datos_basicos['nombre'])?></td>
        <td width="7%">CODIGO:</td>
        <td width="17%"><?php echo $row_datos_basicos['numerodocumento']?></td>
        <td width="6%">PERIODO:</td>
        <td width="24%"><?php echo $codigoperiodo?></td>
      </tr>
      <tr class="Estilo6">
        <td>CURSO:</td>
        <td><?php echo $curso_estudiante;?></td>
        <td>SEMESTRE:</td>
        <td><?php echo $semestre_estudiante?></td>
        <td>CORTE:</td>
        <td><?php echo $numerocorte?></td>
      </tr>
    </table></td>
  </tr>
</table>
<br>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <td><table width="100%"  border="0">
      <tr>
        <td width="36%"><table width="100%"  border="0">
            <tr>
              <td><table width="100%"  border="0">
                  <tr class="Estilo6">
                    <td><div align="center"><strong>CODIGO</strong></div></td>
                    <td><div align="center"><strong>MATERIA</strong></div></td>
                  </tr>
                  <?php foreach ($row_materias_estudiante as $clave => $valor){?>
                  <tr class="Estilo6">
                    <td><div align="center"><?php echo strtoupper($valor['codigomateria'])?></div></td>
                    <td><?php echo substr(strtoupper($valor['nombremateria']),0,25)?></td>
                    <?php } ?>
                  </tr>
              </table></td>
            </tr>
        </table></td>
        <td width="36%"><table width="100%"  border="0">
            <tr>
              <td><table width="100%"  border="0" align="center">
                  <tr>
                    <td nowrap><div align="center" class="Estilo7">AREA</div></td>
                  </tr>
                  <?php foreach($row_areas_materias as $clave => $valor){?>
              <td nowrap class="Estilo6"><?php echo substr(strtoupper($valor['nombreareaacademica']),0,35)?></td>
              <tr>
                <?php }?>
              </tr>
              </table></td>
            </tr>
        </table></td>
        <td width="28%"><table width="100%"  border="0">
            <tr>
              <td><table width="100%"  border="0">
                  <tr>
                    <td><div align="center" class="Estilo7">CRITERIO EVALUACION</div></td>
                  </tr>
                  <?php foreach($row_equivalencias as $clave_row_equivalencias=>$valor_row_equivalencias){?>
                  <tr class="Estilo6">
                    <td><div align="center"></div>
                        <div align="center">
                          <?php /* echo $valor_row_equivalencias['codigomateria']," "; */if($valor_row_equivalencias['nombrenotaequivalencia']!=""){echo $valor_row_equivalencias['nombrenotaequivalencia'];}else{echo "X&nbsp;";}?>
                      </div></td>
                    <?php } ?>
                  </tr>
              </table></td>
              <td><table width="100%"  border="0">
                  <tr class="Estilo6">
                    <td><div align="center" class="Estilo7">FT</div></td>
                    <td><div align="center" class="Estilo7">FP</div></td>
                  </tr>
                  <?php foreach ($row_notasestudiante as $clave => $valor){?>
                  <tr class="Estilo6">
                    <td><div align="center">
                        <?php if($valor['numerofallasteoria']!=""){print_r($valor['numerofallasteoria']);}else{echo "&nbsp;";}?>
                    </div></td>
                    <td><div align="center">
                        <?php if($valor['numerofallaspractica']!=""){print_r($valor['numerofallaspractica']);}else{echo "&nbsp;";}?>
                    </div></td>
                  </tr>
                  <?php } ?>
              </table></td>
            </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
<br><br>

<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <td><table width="100%"  border="0">
      <tr>
        <td class="Estilo6"><p>OBSERVACIONES:_______________________________________________________________________________________________________________________</p>
          <p>_____________________________________________________________________________________________________________________________________&nbsp; </p>
          <p>______________________________________________________________________________________________________________________________________ </p>
          <p>______________________________________________________________________________________________________________________________________ </p>
          <p></p>
          <p></p>
          <p></p>
          <p></p>
          <p></p>
          <table width="100%"  border="0">
            <tr>
              <td width="50%"><p align="center">_____________________________________</p>
                  <p align="center" class="Estilo6">FIRMA PADRE </p></td>
              <td width="50%"><p align="center">_____________________________________</p>
                  <p align="center" class="Estilo6">FIRMA DIRECTOR DE GRUPO </p></td>
            </tr>
          </table>
          <p>&nbsp;</p>
          <p></p></td>
      </tr>
    </table></td>
  </tr>
</table>
<br>
<p class="Estilo6">FECHA EXP: <?php echo $fechahoy;?></p>
</form>

</body>
</html>
<?php echo "<H1 class=SaltoDePagina> </H1>";?>
<?php
$array2=$row_notasestudiante;
$array=$row_areas_materias;
listar($array,"areas");
listar($array2,"notas");
?>