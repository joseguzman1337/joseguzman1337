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

.Estilo25 {font-size: 11px}

.Estilo26 {font-family: Verdana, Arial, Helvetica, sans-serif;

	font-size: 10px;

	font-weight: bold;

	color: #000000;

}

.Estilo6 {	font-family: Verdana, Arial, Helvetica, sans-serif;

	font-size: 10px;

}

.Estilo27 {font-size: 4px}

.Estilo28 {color: #000000}

.Estilo29 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; color: #000000; }

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

            <td width="55"><a href="http://www.unbosque.edu.co/" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Inicio','','imagenes/aspirantes_inicioover.gif',1)"><img src="imagenes/aspirantes_inicio.gif" name="Inicio" width="55" height="16" border="0"></a></td>

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

            <td width="107"><a href="http://www.unbosque.edu.co/files/Archivos/Folleto_Financiacion.doc" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Financiacion','','imagenes/aspirantes_apoyofinancieroover.gif',1)"><img src="imagenes/aspirantes_apoyofinanciero.gif" name="Financiacion" width="107" height="16" border="0"></a></td>

          </tr>

        </table></td>

      </tr>

      <tr>

        <td height="323" valign="top">

		<table width="755"  border="0" align="center" cellpadding="0" cellspacing="0">

          <tr>

            <td width="80%" valign="top" bgcolor="#F5F3EF"><table width="95%"  border="0" align="center" cellpadding="0" cellspacing="0">

               <tr>

                 <td height="10"><div align="right"></div></td>

               </tr>

               <tr>

                 <td height="4"><div align="right"><span class="Estilo27"><span class="Estilo6"><img src="imagenes/bienvenida.jpg" width="263" height="40"></span></span></div></td>

               </tr>

               <tr>

                 <td>&nbsp;</td>

               </tr>

               <tr>

                 <td><div align="justify"><span class="Estilo6">En &eacute;sta p&aacute;gina encontrar&aacute;s &nbsp;toda la informaci&oacute;n necesaria para tu ingreso a la Universidad. Adem&aacute;s, puedes contar con alguien que te oriente de manera personalizada en la l&iacute;nea de Atenci&oacute;n al Aspirante (6489080). </span></div></td>

               </tr>

               <tr>

                 <td>&nbsp;</td>

               </tr>

               <tr>

                 <td><span class="Estilo6"><span class="Estilo26"><a href="porqueestudiarenUB.php"><img src="imagenes/1.gif" width="248" height="29" border="0"></a></span></span></td>

               </tr>

               <tr>

                 <td><span class="Estilo6"><span class="Estilo26"><a href="quediferenciaprogramas.php"><img src="imagenes/7.gif" width="248" height="29" border="0"></a></span></span></td>

               </tr>

               <tr>

                 <td><span class="Estilo6"><span class="Estilo26"><a href="porqueestudiarunacarreraenUB.php"><img src="imagenes/2.gif" width="248" height="29" border="0"></a></span></span></td>

               </tr>

               <tr>

                 <td><p align="justify" class="Estilo15 Estilo16 Estilo28">Tenemos una reconocida trayectoria con programas acad&eacute;micos de pregrado y postgrado, certificados y acreditados ante el Ministerio de Educaci&oacute;n Nacional. </p>

                   <p align="justify" class="Estilo29">Nuestros egresados tienen un gran prestigio tanto a nivel Nacional como internacional. Estas son algunas de sus caracter&iacute;sticas: </p>

                   <p align="justify" class="Estilo29"><strong>Administraci&oacute;n <br>

                     </strong>En el momento que termines la carrera podr&aacute;s participar en los sectores p&uacute;blico y privado, desde la perspectiva de la alta gerencia, creando empresas y desarrollando actividades de consultor&iacute;a e investigaci&oacute;n. <br>

                     <br>

                     <strong>Ingenier&iacute;a Industrial <br>

                     </strong>Ser&aacute;s un profesional integro que podr&aacute;s participar en un entorno tecnol&oacute;gico y social, fundamentados en las ciencias de la ingenier&iacute;a, para poder ser un gran l&iacute;der y empresario capaz de crear y dirigir empresas productivas y competitivas, en todo tipo de &aacute;reas. <br>

                     <br>

                     <strong>Ingenier&iacute;a Electr&oacute;nica <br>

                     </strong>Como ingeniero electr&oacute;nico de la Universidad el Bosque podr&aacute;s desempe&ntilde;arte en las siguientes &aacute;reas: telecomunicaciones, automatismos, bioingenier&iacute;a, teleinform&aacute;tica y administraci&oacute;n. As&iacute; podr&aacute;s ser bastante competitivo en el &aacute;rea que desees trabajar. <br>

                     <strong><br>

  Ingenier&iacute;a Ambiental</strong> <strong><br>

  </strong>Podr&aacute;s abarcar todos los problemas ecol&oacute;gicos a trav&eacute;s de criterios anal&iacute;ticos y racionales que ense&ntilde;a la ingenier&iacute;a, colaborando con la normalizaci&oacute;n ambiental tanto en grande como peque&ntilde;a empresa, dando un gran aporte social a la comunidad. <br>

  <br>

  <strong>Ingenier&iacute;a Sistemas</strong> <strong><br>

  </strong>Con base en tu formaci&oacute;n como Ingeniero, sobresaldr&aacute;s en el &aacute;mbito profesional como integrador de soluciones tecnol&oacute;gicas a todo nivel, Gerente de Proyectos con capacidades necesarias de liderazgo y podr&aacute;s conformar equipos de trabajo y planeaci&oacute;n tecnol&oacute;gica. Con esto obtendr&aacute;s un valor agregado en tu campo de desarrollo humano y profesional. <br>

  <br>

  <strong>Biolog&iacute;a <br>

  </strong>Estar&aacute;s capacitado en los aspectos investigativos, tecnol&oacute;gicos, cient&iacute;ficos y sociales de la Biolog&iacute;a ; en el manejo y conservaci&oacute;n de los eco sistemas ; en la direcci&oacute;n y gesti&oacute;n de proyectos de Biotecnolog&iacute;a; en la administraci&oacute;n de los recursos naturales y en las soluciones ambientales para el mejoramiento de la calidad de vida de las comunidades. <br>

  <br>

  <strong>Dise&ntilde;o Industrial</strong><br>

  El dise&ntilde;ador Industrial de la universidad El Bosque tendr&aacute; competencias para desarrollar estrategias de configuraci&oacute;n, formalizar, producir y gestionar proyectos con sentido social vincul&aacute;ndose al sector productivo. <br>

  <br>

  <strong>Psicolog&iacute;a</strong> <strong><br>

  </strong>Te distinguir&aacute;s como egresado por los enfoques que manejaras como <strong>cient&iacute;fico </strong>, <strong>profesional </strong>y <strong>ciudadano responsable </strong>, con los m&aacute;s elevados valores &eacute;ticos y humanistas. <br>

  <br>

  <strong>Enfermer&iacute;a</strong> <strong><br>

  </strong>Ser&aacute;s un Profesional preparado para brindar servicios de enfermer&iacute;a a nivel cl&iacute;nico, comunitario, acad&eacute;mico, comercial, empresarial, industrial; tendr&aacute;s la capacidad para gestionar, liderar y ejecutar proyectos sociales y de car&aacute;cter cient&iacute;fico en el &aacute;rea de la salud. <br>

  <br>

  <strong>Medicina</strong> <strong><br>

</strong>Ser&aacute;s un m&eacute;dico cirujano con un profundo sentido &eacute;tico y humano, de excelentes condiciones acad&eacute;micas y s&oacute;lidos conocimientos cient&iacute;ficos, de actitud cr&iacute;tica e investigativa, capaz de enfrentar y resolver los problemas sanitarios de la poblaci&oacute;n colombiana, desde una visi&oacute;n integral de la salud y la enfermedad que contemple sus aspectos biol&oacute;gicos, psicol&oacute;gicos y sociales. </p>

                   <div align="justify" class="Estilo28">

                     <p><span class="Estilo6"> <strong>Odontolog&iacute;a <br>

                       </strong>Tendr&aacute;s la capacidad de desempe&ntilde;arte en el sector gubernamental, empresarial y cl&iacute;nico. <br>

                       <br>

                       Marcar&aacute;s la diferencia en calidad, tecnolog&iacute;a, trabajo cl&iacute;nico, hospitalario y comunitario, siendo un profesional l&iacute;der con alta comprensi&oacute;n de la realidad nacional e internacional. Reconociendo el papel de lo human&iacute;stico y bio&eacute;tico en los avances t&eacute;cnicos y cient&iacute;ficos actuales, podr&aacute;s transformar el conocimiento y mejorar la calidad de vida de quienes te rodean. <br>

                       <strong><br>

    Artes Esc&eacute;nicas <br>

                       </strong>Aqu&iacute; podr&aacute;s demostrar tus habilidades y aptitudes en actuaci&oacute;n o direcci&oacute;n de los espect&aacute;culos teatrales: concibi&eacute;ndolos, desarroll&aacute;ndolos, llev&aacute;ndolos a escenas y confront&aacute;ndolos con el p&uacute;blico. El programa te dar&aacute; la posiblidad de apropiarte de conceptos est&eacute;ticos y t&eacute;cnicos inherentes a tu rol como creador del arte teatral. </span></p>

                     <p class="Estilo6"><strong>Artes Pl&aacute;sticas <br>

                     </strong>Estar&aacute;s capacitado para proyectarte en la creaci&oacute;n pl&aacute;stica, la investigaci&oacute;n del arte y la gesti&oacute;n de proyectos culturales y pedag&oacute;gicos, reconociendo el contexto situacional que vive el pa&iacute;s. </p>

                     <p><span class="Estilo6"> <strong>Formaci&oacute;n M&uacute;sical <br>

                       </strong>Ser&aacute;s competitivo en campos de creaci&oacute;n musical, investigaci&oacute;n y gesti&oacute;n. Tendr&aacute;s un alto desempe&ntilde;o musical en cualquiera de nuestros &eacute;nfasis existentes. &nbsp; <strong><br>

                       <br>

    Licenciatura en Pedagog&iacute;a Infantil <br>

                                            </strong>Cuando te grad&uacute;es de la licenciatura, podr&aacute;s realizarte como un docente dinamizador, transformador reflexivo y constructor de conocimiento que asuma su quehacer como una totalidad entre lo subjetivo, objetivo, te&oacute;rico y pr&aacute;ctico.</span></p>

                   </div></td>

               </tr>

               <tr>

                 <td>&nbsp;</td>

               </tr>

               <tr>

                 <td><span class="Estilo6"><span class="Estilo26"><a href="comoingresaraUB.php"><img src="imagenes/4.gif" width="248" height="29" border="0"></a></span></span></td>

               </tr>

               <tr>

                 <td><span class="Estilo6"><span class="Estilo26"><a href="enlaUquienseocupabienestar.php"><img src="imagenes/3.gif" width="248" height="29" border="0"></a></span></span></td>

               </tr>

               <tr>

                 <td><span class="Estilo6"><span class="Estilo26"><span class="Estilo25"><a href="quebeneficiosofreceUB.php"><img src="imagenes/5.gif" width="248" height="29" border="0"></a></span></span></span></td>

               </tr>

               <tr>

                 <td>&nbsp;</td>

               </tr>

               <tr>

                 <td>&nbsp;</td>

               </tr>

             </table>                </td>

            <td width="20%" valign="top" bgcolor="#475138">

				<div align="center">

              <p>                <span class="Estilo21"><strong><span class="Estilo23"><img src="imagenes/imagenedificio.jpg" width="152" height="189"><br>

                        <span class="Estilo24"><a href="https://artemisa.unbosque.edu.co/aspirantes/enlinea.php?interesado"><img src="imagenes/uno.gif" width="165" height="20" border="0"></a><br>

                        </span><a href="https://artemisa.unbosque.edu.co/aspirantes/enlinea.php"><img src="imagenes/dos.gif" width="165" height="20" border="0"></a><br>

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

</body>

</html>

