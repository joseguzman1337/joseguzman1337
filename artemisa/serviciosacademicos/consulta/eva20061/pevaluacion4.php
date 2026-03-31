<?php
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
      
include("pconexionbase.php");
session_start();
/*echo "_SESSION<pre>";
print_r($_SESSION);
echo "</pre>";*/
//$GLOBALS['codigomateria'];
//$GLOBALS['numerodocumento'];
//$GLOBALS['idgrupo'];
//session_register("codigomateria");
//session_register("numerodocumento");
//session_register("idgrupo");
mysql_select_db($database_sala, $sala);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<style type="text/css">
<!--
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold;}
.Estilo5 {font-family: Tahoma; font-size: 16px; font-weight: bold; color: #0033CC}
.Estilo7 {font-family: Tahoma; font-size: 12px; font-weight: bold; color: #FF0000; }
-->
</style>
<head>
<title>Universidad el Bosque</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_reloadPage(init) {  //reloads the window if Nav4 resized
  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {
    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}
  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();
}
MM_reloadPage(true);
//-->
</script>
</head>

<body>
<p>
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
<?php
$codigoest=$_SESSION['codigo'];


 $sql1="SELECT DISTINCT
  estudiante.codigocarrera,
  estudiante.codigoestudiante,
  estudiantegeneral.nombresestudiantegeneral,
  estudiantegeneral.apellidosestudiantegeneral,
estudiantegeneral.numerodocumento,
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
	 $codigocarrera=$row_datosgrabados['codigocarrera'];
	 
	
	 ?>
</p>
<div align="center"> </div>
<table width="689" border="0" align="center" cellpadding="2" cellspacing="2">
  <tr> 
    <td width="669"><div class="Estilo5">
        <div align="center">EVALUACI&Oacute;N DEL DESARROLLO DE LAS ASIGNATURAS 
        </div>
      </div></td>
  </tr>
  <tr> 
    <td><div class="Estilo5">
        <div align="center">POR PARTE DE LOS ESTUDIANTES 2010-02</div>
      </div></td>
  </tr>
</table>
<table width="687" border="0" align="center" cellpadding="2" cellspacing="2">
  <tr> 
    <td height="24"><font color="#0066CC" size="4"><strong><?php// echo  $row_datosgrabados['nombresestudiantegeneral']; ?> <?php //echo  $row_datosgrabados['apellidosestudiantegeneral']; ?>
      </strong></font></td>
    <td><font color="#0066CC" size="4"><strong><?php //echo  $row_datosgrabados['codigoestudiante']; ?></strong></font></td>
  </tr>
  <tr> 
    <td><font color="#0066CC" size="4"><div class="Estilo2"><?php echo  $row_datosgrabados['nombrecarrera']; ?></div></td>
    <td class="Estilo7">eval&uacute;e todos los docentes de contrario no podr&aacute; realizar algunos de sus tramites . </td>
  </tr>
</table>
<form name="form1" method="get"  action="fpinsercion2.php">
  <table width="680" border="1" align="center" cellpadding="2" cellspacing="2" bgcolor="#F2F2F2">
    <tr> 
      <td width="376" height="29" bgcolor="#C5D5D6"><div class="Estilo2">MATERIAS 
        </div></td>
      <td width="377" bgcolor="#C5D5D6"><div class="Estilo2">DOCENTES</div></td>
    </tr>
    <tr> 
      <td height="0" colspan="2"> <font size="2"> 
        <?php 
	 	  //$resultado=mysql_query("SELECT h.nombredocente,h.codigodocente,j.nombremateria FROM docentes h,materia j WHERE h.codigodocente = 10256646",$conexion);
	  	  //$resultado=mysql_query("SELECT nombredocente FROM docentes where nombredocente = 'SIN PROFESOR'",$conexion);
		  //$resultado=mysql_query("SELECT nombremateria,nombredocente FROM materia,docentes where nombredocente = 'SIN PROFESOR'",$conexion);
		  //$resultado=mysql_query("SELECT nombremateria,nombredocente,a.codigoestudiante FROM materia,docentes,estudiante a where a.codigoestudiante = '0017001'",$conexion);
		  
		  //$resultado=mysql_query("SELECT t1.nombremateria, t2.codigoestudiante FROM materia t1, estudiantemateria t2 WHERE t1.codigomateria = 'AB91001' and t2.codigoestudiante = '$codigoest'",$conexion);
        $materiassinevaluar=0;
        $materiasevaluadas=0;
          $resultado="SELECT dc.nombredocente, dc.apellidodocente, m.codigomateria,m.nombremateria, g.idgrupo,j.nombrecarrera,g.matriculadosgrupo,m.codigomateria,dc.numerodocumento

FROM prematricula p, detalleprematricula d, grupo g, docente dc, materia m, carrera j

WHERE p.idprematricula=d.idprematricula

AND p.codigoestudiante='$codigoest'

AND d.codigoestadodetalleprematricula='30'

AND g.idgrupo=d.idgrupo
and g.codigoperiodo = '20102'
AND dc.numerodocumento=g.numerodocumento

AND m.codigomateria=g.codigomateria

AND j.codigocarrera=m.codigocarrera
and dc.numerodocumento <> 1";

           //$filapru=mysql_fetch_array($resultado)
		   $fila = mysql_query($resultado,$sala) or die("$resultado".mysql_error());
                         
		  while ($row_fila1 = mysql_fetch_assoc($fila))
		  {
		  $codigitom=$row_fila1['codigomateria'];
		  $codigitonu=$row_fila1['numerodocumento'];
		  $codigitoid=$row_fila1['idgrupo'];
		  
		 /*  $contador++;
		  echo "$contador<br>";*/
		//$_SESSION['codigomateria'] = $row_fila1['codigomateria'];
		//$_SESSION['numerodocumento'] = $row_fila1['numerodocumento'];
		//$_SESSION['idgrupo'] = $row_fila1['idgrupo'];
		$resresul="SELECT codigomateria, codigoestudiante, codigodocente,evaluado,idgrupo,codigoperiodo
FROM respuestas WHERE codigoestudiante='$codigoest' and codigomateria='$codigitom' and codigodocente='$codigitonu' and evaluado='1' and idgrupo='$codigitoid' and codigoperiodo='20102'";

//echo $resresul;
           //$filapru=mysql_fetch_array($resultado)
		   $resfila = mysql_query($resresul,$sala) or die("$resresul".mysql_error());
		
		 if ($resfila = mysql_fetch_assoc($resfila))
		 {

                $materiasevaluadas++;
		 ?>
		 <input name="codigopregunta" type="hidden" value="1">
        </font><font size="2" face="Tahoma"><strong><em> 
        
        </em></strong></font><font size="2">&nbsp; </font><font size="2" face="Tahoma"><strong><em> 
        
        
        </em></strong></font> 
        <table width="667" height="16" border="1" cellpadding="2" cellspacing="2" bgcolor="#F2F2F2">
          <tr> 
            <td width="150" height="10" bgcolor="#FFFFFF"><strong><font size="1" face="Tahoma"><?php echo $row_fila1['nombremateria'] ?></font></strong></td>
            <td width="140" height="10" bgcolor="#FFFFFF"><span class="Estilo7">EVALUADO</span> </td>
          </tr>
        </table>
        <font size="2"> 
		
		<?php
		}
		else {
                    $materiassinevaluar++;

	 ?>		 
		 
		 
		 
		<input name="codigopregunta" type="hidden" value="1">
        </font><font size="2" face="Tahoma"><strong><em> 
        
        </em></strong></font><font size="2">&nbsp; </font><font size="2" face="Tahoma"><strong><em> 
        
        
        </em></strong></font> 
        <table width="667" height="16" border="1" cellpadding="2" cellspacing="2" bgcolor="#F2F2F2">
          <tr> 
            <td width="150" height="10" bgcolor="#FFFFFF"><strong><font size="1" face="Tahoma"><?php echo $row_fila1['nombremateria'] ?></font></strong></td>
            <td width="140" height="10" bgcolor="#FFFFFF"><strong><font size="1" face="Tahoma"><a href="fpinsercion2.php?erty=<?php echo $row_fila1['numerodocumento']?>&oiyp=<?php echo $row_fila1['idgrupo']?>&jklm=<?php echo $row_fila1['codigomateria']?>"><?php echo $row_fila1['nombredocente']?></a><a href="fpinsercion2.php?erty=<?php echo $row_fila1['numerodocumento']?>&oiyp=<?php echo $row_fila1['idgrupo']?>&jklm=<?php echo $row_fila1['codigomateria']?>"> <?php echo $row_fila1['apellidodocente']?></a></font></strong></td>
          </tr>
        </table>
        <font size="2"> 
        <?php } ?>
		 <?php }
                 if($materiassinevaluar==0&&
                        isset( $_SESSION["entradadirectaevafacultad"])){
                            echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=../facultades/creacionestudiante/estudiante.php?codigocreado=".$row_datosgrabados["numerodocumento"]."&sinestadocuenta'>";
                            unset($_SESSION["entradadirectaevafacultad"]);
                 }
                 ?>
        </font></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <p align="center">&nbsp; </p>
</form>
<p>&nbsp;</p>
<?php 
$conta=0;
$insercion2rp10=$_POST['resp10'] ;
if(isset($_POST['grabar']))
{
	foreach($_POST as $llavepost => $valorpost)
	{
		if(ereg("resp",$llavepost))
		 {
			$conta++;
		}

	}
	if(($conta<10) || ($insercion2rp10 == ""))
	{
		//echo "hola";
		//echo $conta;
		echo '<script>alert("FALTA LLENAR ALGUN CAMPO"); history.go(-1);exit;</script>';
		
	}
	else
	{		 
		 $qwe="SELECT evaluof FROM evafacultad WHERE codigoestudiante='$codigoest' AND codigoperiodo='20102'";

           //$filapru=mysql_fetch_array($resultado)
		   $afila = mysql_query($qwe, $sala) or die("$qwe".mysql_error());
                         
		  $sssq = mysql_fetch_assoc($afila);
	 //$res=mysql_query($ffev,$conexion);
     //$aff=mysql_fetch_array($res);
	$vvf=$sssq['evaluof'];
	//echo "$vvf";
	
		
		$insercion2rp1=$_POST['resp1'] ;
		$insercion2rp2=$_POST['resp2'] ;
		 $insercion2rp3=$_POST['resp3'] ;
		 $insercion2rp4=$_POST['resp4'] ;
		 $insercion2rp5=$_POST['resp5'] ;
		 $insercion2rp6=$_POST['resp6'] ;
		 $insercion2rp7=$_POST['resp7'] ;
		 $insercion2rp8=$_POST['resp8'] ;
		 $insercion2rp9=$_POST['resp9'] ;
		 $insercion2rp10=$_POST['resp10'] ;
		   //echo " la cuarta".$_POST['resp4']."<br>";
		  
		 /*echo "$insercion2rp1";
		  echo "$insercion2rp2";
		  echo "$insercion2rp3";
		  echo "$insercion2rp4";
		  echo "$insercion2rp5";
		  echo "$insercion2rp6";
		  echo "$insercion2rp7";
		  echo "$insercion2rp8";
		  echo "$insercion2rp9";
		  echo "$insercion2rp10";
		*/
		
	   
	  
	 
	
	 
if(!(isset($vvf)))
{
$das="INSERT INTO evafacultad values('$codigoest','$insercion2rp1','$insercion2rp2','$insercion2rp3','$insercion2rp4','$insercion2rp5','$insercion2rp6','$insercion2rp7','$insercion2rp8','$insercion2rp9','$insercion2rp10','$codigocarrera',1,'20102')"; 
mysql_query($das,$sala);
}
else
{
echo "USTED YA HABIA EVALUADO LA FACULTAD";
}
?>	
<?php 	}?>
<?php }?>
 

</body>
</html>
