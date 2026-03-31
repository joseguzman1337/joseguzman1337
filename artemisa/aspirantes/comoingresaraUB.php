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

	color: #FF9813;

	text-decoration: none;

}

a:visited {

	color: #FF9813;

	text-decoration: none;

}

a:hover {

	text-decoration: underline;

	color: #FF9813;

}

a:active {

	text-decoration: none;

	color: #FF9813;

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

.Estilo14 {	color: #FFB84C;

	font-weight: bold;

}

.Estilo30 {color: #666666;

	font-weight: bold;

}

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

                 <td><span class="Estilo6"><span class="Estilo26"><a href="comoingresaraUB.php"><img src="imagenes/4.gif" width="248" height="29" border="0"></a></span></span></td>

               </tr>

               <tr>

                 <td><p align="justify" class="Estilo6"><span class="Estilo26">El proceso es sencillo... </span><strong><br>

                   </strong><strong><br>

                 </strong>Si ya elegiste tu carrera, debes iniciar el proceso de inscripci&oacute;n diligenciando del formulario. Existen dos alternativas. </p>

                   <p align="left" class="Estilo6"><strong>1. Presencial: <br>

  - </strong>Te acercas a Atenci&oacute;n del Usuario <br>

  - Registrar&aacute;n tus datos <br>

  - Recibir&aacute;s un n&uacute;mero de orden pago <br>

  - Te diriges a tesorer&iacute;a o a los bancos autorizados<br>

  - Cancelas $ 60.000 y obtienes el formulario<br>

  - Diligencias el formulario <br>

  - Lo entregas en Atenci&oacute;n del Usuario<br>

  <span class="Estilo30"><span class="Estilo14">Si perteneces a Medicina, Odontolog&iacute;a, Psicolog&iacute;a o Artes, tendr&aacute;s que presentar un examen o prueba. </span><br>

  </span>- Se comunican contigo para citarte a pruebas y/o entrevistas <br>

  - Presentas los documentos requeridos. <br>

  <strong>y listo: eres un nuevo estudiante de la Universidad El Bosque. </strong></p>

                   <p class="Estilo6"><strong>2. Virtual <br>

                     </strong>- Click en Inicia Inscripci&oacute;n<br>

  - Diligencias informaci&oacute;n del aspirantes<br>

  - Pago Derechos de Inscripci&oacute;n <strong><br>

  - <br>

  </strong> - Formulario Preinscripci&oacute;n <br>

  - Diligencias el formulario <br>

  - Recibes el n&uacute;mero de orden de pago <br>

  - Puedes cancelar en l&iacute;nea o imprimes el formato <br>

  - Si lo imprimiste, cancelas en tesorer&iacute;a o en los bancos autorizados el valor de $60.000<br>

  <span class="Estilo14">Si perteneces a Medicina, Odontolog&iacute;a, Psicolog&iacute;a o Artes, tendr&aacute;s que presentar un examen o prueba. </span><br>

  - Se comunican contigo para citarte a pruebas y/o entrevistas <br>

  - Presentas los documentos requeridos <br>

  <strong>y listo: eres un nuevo estudiante de la Universidad El Bosque. </strong></p>

                   <p class="Estilo6"><strong>La l&iacute;nea de atenci&oacute;n al aspirante est&aacute; a tu servicio para asesorarte en este proceso: CONT&Aacute;CTANOS. </strong></p>

                   <p class="Estilo6"><strong>U. Administrativa Atenci&oacute;n al Usuario <br>

                     </strong>L&iacute;nea de Atenci&oacute;n al Aspirante: PBX. 6489080 / 6489000 Ext. 599-375 <br>

                     <a href="mailto:atencionalusuario@unbosque.edu.co">atencionalusuario@unbosque.edu.co</a></p>

                   <p class="Estilo6">O si quieres comun&iacute;cate directamente con la Facultad que has elegido, escribe un mail y con gusto ser&aacute;n atendidas tus inquietudes.<br>

                       <br>

  Administraci&oacute;n de Empresas <a href="mailto:administracion.empresas@unbosque.edu.co">administracion.empresas@unbosque.edu.co </a><br>

  Artes <a href="mailto:artes@unbosque.edu.co">artes@unbosque.edu.co </a><br>

  Biolog&iacute;a <a href="mailto:biologia@unbosque.edu.co">biologia@unbosque.edu.co </a><br>

  Curso B&aacute;sico <a href="mailto:curso.basico@unbosque.edu.co">curso.basico@unbosque.edu.co </a><br>

  Dise&ntilde;o Industrial <a href="mailto:disenoindustrial@unbosque.edu.co">disenoindustrial@unbosque.edu.co </a><br>

  Educaci&oacute;n <a href="mailto:educacion@unbosque.edu.co">educacion@unbosque.edu.co </a><br>

  Enfermer&iacute;a <a href="mailto:enfermeria@unbosque.edu.co">enfermeria@unbosque.edu.co </a><br>

  Ingenier&iacute;a Ambiental <a href="mailto:secretaria.ambiental@unbosque.edu.co">ambiental@unbosque.edu.co </a><br>

  Ingenier&iacute;a de Sistemas <a href="mailto:ingenieria.sistemas@unbosque.edu.co">ingenieria.sistemas@unbosque.edu.co </a><br>

  Ingenier&iacute;a Industrial <a href="mailto:industrial@unbosque.edu.co">industrial@unbosque.edu.co </a><br>

  Ingenier&iacute;a Electr&oacute;nica <a href="mailto:secretaria.electronica@unbosque.edu.co">secretaria.electronica@unbosque.edu.co </a><br>

  Psicolog&iacute;a <a href="mailto:psicologia@unbosque.edu.co">psicologia@unbosque.edu.co </a><br>

  Medicina <a href="mailto:medicina@unbosque.edu.co">medicina@unbosque.edu.co </a><br>

  Odontolog&iacute;a <a href="mailto:odontologia@unbosque.edu.co">odontologia@unbosque.edu.co </a><br>

                   </p>                   </td>

               </tr>

               <tr>

                 <td>&nbsp;</td>

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

