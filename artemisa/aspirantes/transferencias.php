<?php

@session_start();

if(isset($_SESSION))

{

	unset($_SESSION);

}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"

"http://www.w3.org/TR/html4/loose.dtd">

<html>

<head>

<title>Universidad El Bosque</title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<style type=text/css>

<!--

Body { 

scrollbar-face-color : #999999; 

scrollbar-highlight-color : #999999; 

scrollbar-3dlight-color : #999999;

scrollbar-darkshadow-color : #999999; 

scrollbar-arrow-color : #999999; 

scrollbar-shadow-color : #999999; 

scrollbar-track-color: #999999 

} 

-->

</style>

<style type="text/css">

<!--

body {

	margin-top: 0px;

	background-image: url();

	background-color: #FFD8A4;

}

a:link {

	color: #FFFFFF;

	text-decoration: none;

}

a:visited {

	color: #FFFFFF;

	text-decoration: none;

}

a:hover {

	text-decoration: underline;

	color: #FFFFFF#FFFFFF;

}

a:active {

	text-decoration: none;

	color: #FFFFFF;

}

BODY

{

	scrollbar-face-color:#FFFFFF;

	scrollbar-shadow-color:#D5D5D5;

	scrollbar-highlight-color:#FFFFFF;

	scrollbar-3dlight-color:#909090;

	scrollbar-darkshadow-color:#909090;

	scrollbar-track-color:#EFEFEF;

	scrollbar-arrow-color:#909090;

	background-color: #FFFFFF;

}

.Estilo16 {

	font-family: Verdana, Arial, Helvetica, sans-serif;

	font-size: 10px;

	color: #FFFFFF;

}

.Estilo18 {font-size: 9px}

.Estilo21 {font-size: 11px}

.Estilo23 {font-size: 11px; font-family: Verdana, Arial, Helvetica, sans-serif; }

.Estilo24 {

	font-family: Verdana, Arial, Helvetica, sans-serif;

	font-weight: bold;

	font-size: 11px;

	color: #FFFFFF;

}

.Estilo26 {font-family: Verdana, Arial, Helvetica, sans-serif}

.Estilo27 {font-size: 10px}

.Estilo28 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; }

-->

</style>

<script language="JavaScript" type="text/JavaScript">

<!--

function MM_reloadPage(init) {  //reloads the window if Nav4 resized

  if (init==true) with (navigator) {if ((appName=="Netscape")&&(parseInt(appVersion)==4)) {

    document.MM_pgW=innerWidth; document.MM_pgH=innerHeight; onresize=MM_reloadPage; }}

  else if (innerWidth!=document.MM_pgW || innerHeight!=document.MM_pgH) location.reload();

}

MM_reloadPage(true);



function MM_swapImgRestore() { //v3.0

  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;

}



function MM_preloadImages() { //v3.0

  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();

    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)

    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}

}



function MM_findObj(n, d) { //v4.01

  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {

    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}

  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];

  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);

  if(!x && d.getElementById) x=d.getElementById(n); return x;

}



function MM_swapImage() { //v3.0

  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)

   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}

}

//-->

</script>

</head>

<body onLoad="MM_preloadImages('imagenes/aspirantes_inicioover.gif','imagenes/aspirantes_pregradoover.gif','imagenes/aspirantes_postgradoover.gif','imagenes/aspirantes_maetriasover.gif','imagenes/aspirantes_doctoradoover.gif','imagenes/aspirantes_educacioncontinuadaover.gif','imagenes/aspirantes_trasferenciasover.gif','imagenes/aspirantes_apoyofinancieroover.gif')">

<table width="750" height="475" border="0" align="center" cellpadding="0" cellspacing="0">

  <tr>

    <td width="752" height="475" valign="top" bordercolor="#CCCCCC"><table width="750"  border="0" align="center" cellpadding="0" cellspacing="0">

      <tr>

        <td width="100%" height="122"><img src="imagenes/aspirantes_banner.jpg" width="755" height="125"></td>

      </tr>

      <tr>

        <td height="10" valign="top" bgcolor="#F5F3EF"><table width="755" border="0" cellspacing="0" cellpadding="0">

          <tr>

            <td width="55"><a href="http://unbosque.edu.co/" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Inicio','','imagenes/aspirantes_inicioover.gif',1)"><img src="imagenes/aspirantes_inicio.gif" name="Inicio" width="55" height="16" border="0"></a></td>

            <td width="14"><img src="imagenes/aspirantes_rayita.gif" width="14" height="16"></td>

            <td width="67"><a href="http://www.unbosque.edu.co/?q=es/PROGRAMAS" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Pregrado','','imagenes/aspirantes_pregradoover.gif',1)"><img src="imagenes/aspirantes_pregrado.gif" name="Pregrado" width="67" height="16" border="0"></a></td>

            <td width="14"><img src="imagenes/aspirantes_rayita.gif" width="14" height="16"></td>

            <td width="69"><a href="http://www.unbosque.edu.co/?q=es/programas/especializaciones" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Postgrados','','imagenes/aspirantes_postgradoover.gif',1)"><img src="imagenes/aspirantes_postgrado.gif" name="Postgrados" width="69" height="16" border="0"></a></td>

            <td width="14"><img src="imagenes/aspirantes_rayita.gif" width="14" height="16"></td>

            <td width="68"><a href="http://www.unbosque.edu.co/?q=es/programas/maestrias" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Maestrias','','imagenes/aspirantes_maetriasover.gif',1)"><img src="imagenes/aspirantes_maetrias.gif" name="Maestrias" width="68" height="16" border="0"></a></td>

            <td width="14"><img src="imagenes/aspirantes_rayita.gif" width="14" height="16"></td>

            <td width="75"><a href="http://www.bioeticaunbosque.edu.co/" target="_blank" onMouseOver="MM_swapImage('Doctorado','','imagenes/aspirantes_doctoradoover.gif',1)" onMouseOut="MM_swapImgRestore()"><img src="imagenes/aspirantes_doctorado.gif" name="Doctorado" width="75" height="16" border="0"></a></td>

            <td width="14"><img src="imagenes/aspirantes_rayita.gif" width="14" height="16"></td>

            <td width="132"><a href="http://www.unbosque.edu.co/?q=es/programas/educon/presentacion" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Edu Continuada','','imagenes/aspirantes_educacioncontinuadaover.gif',1)"><img src="imagenes/aspirantes_educacioncontinuada.gif" name="Edu Continuada" width="132" height="16" border="0"></a></td>

            <td width="14"><img src="imagenes/aspirantes_rayita.gif" width="14" height="16"></td>

            <td width="84"><a href="http://www.unbosque.edu.co/?q=es/admisiones/transferencias" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Transferencias','','imagenes/aspirantes_trasferenciasover.gif',1)"><img src="imagenes/aspirantes_trasferencias.gif" name="Transferencias" width="84" height="16" border="0"></a></td>

            <td width="14"><img src="imagenes/aspirantes_rayita.gif" width="14" height="16"></td>

            <td width="107"><a href="
http://www.unbosque.edu.co/files/Archivos/Folleto_Financiacion.doc" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Financiacion','','imagenes/aspirantes_apoyofinancieroover.gif',1)"><img src="imagenes/aspirantes_apoyofinanciero.gif" name="Financiacion" width="107" height="16" border="0"></a></td>

          </tr>

        </table></td>

      </tr>

      <tr>

        <td height="323" valign="top">

		<table width="755"  border="0" align="center" cellpadding="0" cellspacing="0">

          <tr>

            <td width="80%" valign="top" bgcolor="#F5F3EF"><table width="97%"  border="0" align="center" cellpadding="0" cellspacing="0">

              <tr>

                <td><p align="left"><span class="Estilo26"><span class="Estilo27"><strong><br>

                  Transferencias</strong>: Se denomina transferencia al proceso a trav&eacute;s del cual la Universidad admite a un aspirante proveniente de otro programa de educaci&oacute;n superior debidamente aprobado, para que pueda continuar sus estudios en otro programa del mismo nivel. </span></span>

                  <p align="justify" class="Estilo28">El estudiante que ingresa por transferencia, deber&aacute; cursar en la Universidad El Bosque como m&iacute;nimo el cincuenta por ciento (50%) del total de los cr&eacute;ditos del programa al cual se inscribe. El estudiante que aspire a ingresar por transferencia no puede haber perdido la calidad de estudiante en la instituci&oacute;n de procedencia, por razones de orden disciplinario. </p>

                  <p align="justify" class="Estilo28"><strong>Estudio de la transferencia: </strong> Corresponde al Consejo de Facultad realizar el estudio de la solicitud de transferencia y su concepto deber&aacute; remitirse al C consejo Directivo, para la decisi&oacute;n final. </p>

                  <p align="justify" class="Estilo28"><strong>Requisitos: </strong>Para la realizaci&oacute;n del estudio de transferencia, el aspirante deber&aacute; anexar la siguiente documentaci&oacute;n: </p>

                  <p align="justify" class="Estilo28">a) Certificado original de las calificaciones obtenidas y cr&eacute;ditos de las asignaturas cursadas en la instituci&oacute;n de procedencia. </p>

                  <p align="justify" class="Estilo28">b) El programa y contenido de las asignaturas cursadas, refrendado con firma y sello por la instituci&oacute;n de procedencia. </p>

                  <p align="justify" class="Estilo28">c) El certificado de buena conducta expedido por la autoridad competente de la instituci&oacute;n de procedencia. </p>

                  <p align="justify" class="Estilo28">d) Solicitud escrita y motivada para que se inicie el proceso de transferencia. </p>

                  <p align="justify" class="Estilo28">Quienes aspiren a ingresar por transferencia deber&aacute;n realizar su inscripci&oacute;n y anexar la documentaci&oacute;n respectiva, durante las fechas establecidas por cada Facultad. </p>

                  <p align="justify" class="Estilo28"><strong>Mecanismo de transferencia: </strong>El proceso de transferencia se realiza mediante la homologaci&oacute;n de asignaturas. </p>

                  <p align="justify" class="Estilo28"><strong>Homologaci&oacute;n: </strong> Se entiende por homologaci&oacute;n el acto por el cual la Universidad reconoce una asignatura cursada en otro programa de educaci&oacute;n superior, como similar a una establecida en el p&eacute;nsum acad&eacute;mico de la carrera a cursar en la universidad, dada su concordancia con el programa vigente tanto en contenido como en n&uacute;mero de cr&eacute;ditos cursados. </p>

                  <p align="justify" class="Estilo28">El estudio de la homologaci&oacute;n proceder&aacute; cuando se acrediten los siguientes requisitos, ante el Consejo de Facultad: </p>

                  <div align="justify" class="Estilo28">a) Que se haya cursado como m&iacute;nimo el ochenta por ciento (80%) del contenido program&aacute;tico de la asignatura a homologar. <br>

  b) Que la intensidad horaria sea igual o superior a la establecida en el plan de estudios del programa de la Universidad, <br>

  c) Que la calificaci&oacute;n obtenida sea igual o superior a tres punto cero (3.0). <br>

  <strong>Tomado del Reglamento Estudiantil.</strong></div>

                  </td>

              </tr>

              <tr>

                <td>&nbsp;</td>

              </tr>

              <tr>

                <td>&nbsp;</td>

              </tr>

            </table>              </td>

            <td width="20%" valign="top" bgcolor="#475138">

				<div align="center">

              <p>                <span class="Estilo21"><strong><span class="Estilo23"><img src="imagenes/imagenedificio.jpg" width="152" height="189"><br>

                        <span class="Estilo24"><a href="https://www.unbosque.edu.co/aspirantes/enlinea.php?interesado&link_origen=../../../../aspirantes/aspirantes.php"><img src="imagenes/uno.gif" width="165" height="20" border="0"></a><br>

                        </span><a href="https://www.unbosque.edu.co/aspirantes/enlinea.php"><img src="imagenes/dos.gif" width="165" height="20" border="0"></a><br>

                      </span></strong></span>

                <a href="https://www.unbosque.edu.co/aspirantes/aspirantessec.php"><br>
                </a><img src="imagenes/verde.jpg" width="152" height="61"><br>

                <br>

              </div>			</td>

          </tr>

        </table>          </td>

      </tr>

    </table></td>



  </tr>

</table>

<script type="text/javascript">

var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");

document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));

</script>

<script type="text/javascript">

var pageTracker = _gat._getTracker("UA-1974241-1");

pageTracker._setLocalRemoteServerMode();

pageTracker._initData();

pageTracker._trackPageview();

</script>

</body>

</html>

