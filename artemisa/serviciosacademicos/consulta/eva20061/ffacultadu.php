<?php
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
     
 include("pconexionbase.php");
session_start();
 mysql_select_db($database_sala, $sala);   
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 12px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold;}
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
.Estilo4 {color: #FF0000}
-->
</style>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body>

<?php
$codigoest = $_SESSION['codigo'];
//echo $codigoest;
$ttt="SELECT evaluof FROM evafacultad WHERE codigoestudiante='$codigoest' and codigoperiodo='20061'";
//echo $codigoest,"session";
           //$filapru=mysql_fetch_array($resultado)
		   $tafila = mysql_query($ttt, $sala) or die("$ttt".mysql_error());
                         
		  $tsssq = mysql_fetch_assoc($tafila);
	 //$res=mysql_query($ffev,$conexion);
     //$aff=mysql_fetch_array($res);
	$tvvf=$tsssq['evaluof'];

if(!(isset($tvvf)))
{
//echo "ejecute la evaluacion";


	
	//mysql_select_db($database_sala, $sala);
		  //lo que viene es para evitar que el usuario vuelva a evaluar
  //mysql_query("update estudiante set evaluogeneral ='10' where codigoestudiante ='$codigoest'", $conexion);
  //aqui termina
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
  $datosgrabados = mysql_query( $sql1, $sala) or die("$sql1".mysql_error());
  $row_datosgrabados = mysql_fetch_assoc($datosgrabados);
///echo $sql1;
}	 
else
{
include ("pevaluacion4.php");
exit();
}
		  ?>
<table width="687" border="0" align="center" cellpadding="2" cellspacing="2">
  <tr> 
    <td height="24"><font color="#0066CC" size="4"><strong><?php //echo  $row_datosgrabados['nombresestudiantegeneral']; ?> <?php// echo  $row_datosgrabados['apellidosestudiantegeneral']; ?>
      </strong></font></td>
    <td><font color="#0066CC" size="4"><strong><?php //echo  $row_datosgrabados['codigoestudiante']; ?></strong></font></td>
  </tr>
  <tr> 
    <td class="Estilo3"><font color="#0066CC" size="4"><strong><?php echo  $row_datosgrabados['nombrecarrera']; ?></strong></font></td>
    <td>&nbsp;</td>
  </tr>
</table>
<p> 
  
</p>
<form action="pevaluacion4.php" method="post" name="grabar" id="grabar">
  <table width="675" border="1" align="center" cellpadding="2" cellspacing="2">
    <tr bgcolor="#C5D5D6"> 
      <td height="20" colspan="2" align="center"> <input name="codigopregunta" type="hidden" value="1"> 
        <div class="Estilo2">EVALUACI&Oacute;N DE LA FACULTAD Y DE LOS RECURSOS 
          F&Iacute;SICOS Y TECNOL&Oacute;GICOS CON LOS QUE SE CUENTA 2006 - 01</div></td>
    </tr>
    <tr bgcolor="#ffffff"> 
      <td height="77" colspan="2"><span class="Estilo1">Mediante esta encuesta, 
        se pretende conocer su opini&oacute;n con relaci&oacute;n al desarrollo 
        de su Facultad. Su calificaci&oacute;n en cada uno de los &iacute;tems 
        es muy importante, y requiere de mucha responsabilidad en el momento de 
        realizarla.<br>
        Por favor, diligencie este formato tomando en cuenta las siguientes instrucciones: </font> 
        </span> <br>
        <span class="Estilo1">Eval&uacute;a la respuesta de la pregunta, bajo 
        los siguientes par&aacute;metros.</span> <br>
        <br>
        <span class="Estilo2">E. Excelente &nbsp B. Bueno &nbspD. Deficiente &nbspP. 
        P&eacute;simo</span></td>
    </tr>
    <tr bgcolor="#C5D5D6" align="center" class="Estilo2"> 
      <td width="530">PREGUNTA</td>
      <td width="169">RESPUESTA</td>
    </tr>
    <tr bgcolor="#C5D5D6" class="Estilo1"> 
      <td height="15"><font size="2" face="Tahoma">1. El estudiante siempre encuentra 
        en la Facultad una respuesta amable y oportuna a sus inquietudes por parte 
        de las directivas. </font></td>
      <td><strong><font size="1" face="Tahoma">E 
        <input type="radio" name="resp1" value="e">
        B 
        <input type="radio" name="resp1" value="b">
        D 
        <input type="radio" name="resp1" value="d">
        P 
        <input type="radio" name="resp1" value="p">
        </font></strong></td>
    </tr>
    <tr bgcolor="#C5D5D6" class="estilo1"> 
      <td width="530"><font size="2" face="Tahoma">2. La Facultad se preocupa 
        por el desempeño y bienestar de sus estudiantes en el aspecto académico, 
        personal y humano.</font></td>
      <td><strong><font size="1" face="Tahoma">E 
        <input type="radio" name="resp2" value="e">
        B 
        <input type="radio" name="resp2" value="b">
        D 
        <input type="radio" name="resp2" value="d">
        P 
        <input type="radio" name="resp2" value="p">
        </font></strong></td>
    </tr>
    <tr bgcolor="#C5D5D6" class="estilo1"> 
      <td height="15"><font size="2" face="Tahoma">3. El estudiante siempre encuentra 
        en la Facultad una respuesta amable y oportuna a sus inquietudes por parte 
        del personal administrativo</font></td>
      <td><strong><font size="1" face="Tahoma">E 
        <input type="radio" name="resp3" value="e">
        B 
        <input type="radio" name="resp3" value="b">
        D 
        <input type="radio" name="resp3" value="d">
        P 
        <input type="radio" name="resp3" value="p">
        </font></strong></td>
    </tr>
    <tr bgcolor="#C5D5D6" class="estilo1"> 
      <td height="20"><font size="2" face="Tahoma">4. Las notas son publicadas 
        a tiempo por la Facultad</font></td>
      <td><strong><font size="1" face="Tahoma">E 
        <input type="radio" name="resp4" value="e">
        B 
        <input type="radio" name="resp4" value="b">
        D 
        <input type="radio" name="resp4" value="d">
        P 
        <input type="radio" name="resp4" value="p">
        </font></strong></td>
    </tr>
    <tr bgcolor="#C5D5D6" class="estilo1"> 
      <td height="20"><font size="2" face="Tahoma">5. Los procedimientos administrativos 
        de la facultad son adecuados.</font></td>
      <td><strong><font size="1" face="Tahoma">E 
        <input type="radio" name="resp5" value="e">
        B 
        <input type="radio" name="resp5" value="b">
        D 
        <input type="radio" name="resp5" value="d">
        P 
        <input type="radio" name="resp5" value="p">
        </font></strong></td>
    </tr>
    <tr bgcolor="#C5D5D6" class="estilo1"> 
      <td height="20"><font size="2" face="Tahoma">6. La Facultad genera espacios 
        academicos que refuercen las diferentes areas de aprendizaje (Congresos, 
        Seminarios, Conferencias)</font></td>
      <td><strong><font size="1" face="Tahoma">E 
        <input type="radio" name="resp6" value="e">
        B 
        <input type="radio" name="resp6" value="b">
        D 
        <input type="radio" name="resp6" value="d">
        P 
        <input type="radio" name="resp6" value="p">
        </font></strong></td>
    </tr>
    <tr bgcolor="#C5D5D6" class="estilo1"> 
      <td><font size="2" face="Tahoma">7. El estudiante siempre encuentra los 
        recursos audiovisuales adecuados para el normal desarrollo de su actividad 
        académica.</font></td>
      <td><strong><font size="1" face="Tahoma">E 
        <input type="radio" name="resp7" value="e">
        B 
        <input type="radio" name="resp7" value="b">
        D 
        <input type="radio" name="resp7" value="d">
        P 
        <input type="radio" name="resp7" value="p">
        </font></strong></td>
    </tr>
    <tr bgcolor="#C5D5D6" class="estilo1"> 
      <td><font size="2" face="Tahoma">8. La Bibliografía de las diferentes asignaturas 
        siempre se encuentra en la Biblioteca.</font></td>
      <td><strong><font size="1" face="Tahoma">E 
        <input type="radio" name="resp8" value="e">
        B 
        <input type="radio" name="resp8" value="b">
        D 
        <input type="radio" name="resp8" value="d">
        P 
        <input type="radio" name="resp8" value="p">
        </font></strong></td>
    </tr>
    <tr bgcolor="#C5D5D6" class="estilo1"> 
      <td height="25"><font size="2" face="Tahoma">9. El acceso a las salas de 
        computo y laboratorios, es el adecuado.</font></td>
      <td><strong><font size="1" face="Tahoma">E 
        <input type="radio" name="resp9" value="e">
        B 
        <input type="radio" name="resp9" value="b">
        D 
        <input type="radio" name="resp9" value="d">
        P 
        <input type="radio" name="resp9" value="p">
        </font></strong></td>
    </tr>
    <tr bgcolor="#C5D5D6" class="estilo2"> 
      <td colspan="2"><font size="2" face="Tahoma"><strong>OBSERVACIONES: </strong></font><strong></strong></td>
    </tr>
    <tr bgcolor="#C5D5D6" class="estilo4"> 
      <td colspan="2"><textarea name="resp10" cols="80" id="resp10"></textarea></td>
    </tr>
  </table>
  <p align="center"> 
    <input name="grabar" type="submit" id="grabar" value="grabar">
  </p>

</form>

 <script language="JavaScript">
function enlaces(dir)
{
window.location.replace(dir)
}
<!--
/*
Este Script desabilita la función del click derecho del mouse para evitar la
copia de las imágenes contenidas en el documento
*/
         var message="Funcion no Disponible";
         function click(e) {
         if (document.all) {
         if (event.button==2||event.button==3) {
         alert(message);
         return false;
         }
         }
         if (document.layers) {
         if (e.which == 3) {
         alert(message);
         return false;
         }
         }
         }
         if (document.layers) {
         document.captureEvents(Event.MOUSEDOWN);
         }
         document.onmousedown=click;
// -->
</script>

<p align="center">&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p></body>
</html>
