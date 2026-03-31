<?php

function getTemplateAdmitidos($nombre,$programa)
{
    setlocale(LC_TIME, "spanish");
    $html = '
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="format-detection" content="telephone=no" />
    <title></title>
    <style type="text/css">
                @media only screen and (max-width: 500px){
                        .footer_mailing_UEB{
                                width: 100%;
                                margin-bottom: 20px;
                        }
                        .columna{
                                width:100% !important;
                                margin: 0 auto 10px !important;
                                border: none !important;
                                text-align: center !important;
                                float: none !important;
                                align-content: center;
                                /* es lo mismo que align en las tablas pero en CSS */
                        }
                }
    </style>
</head>
<body>
    <!-- inicio del contenedor general -->
    <table cellpadding="30" cellspacing="0" align="center" border="0" width="100%" height="auto" bgcolor="#FAFAFA">
        <tr>
            <td align="center" valign="top">
                <!-- inicio del contenedor del mailing franja blanca -->
                <!--[if mso]>
                    <center>
                    <table bgcolor="#f4f4f4" style="font-family: \'Helvetica\',sans-serif; border-collapse: collapse;"><tr bgcolor="#f4f4f4"><td width="600" bgcolor="#f4f4f4" style="font-family: \'Helvetica\',sans-serif; border-collapse: collapse;">
                <![endif]-->
                <!-- inicio del contenedor del mailing franja blanca -->
                <div style="max-width:600px; margin:0 auto;">
                    <table cellpadding="0" cellspacing="0" border="0" width="100%" bgcolor="#ffffff">
                        <tbody>
                            <tr>
                                <td>
                                    <!--head -->
                                    <table cellpadding="0" cellspacing="0" border="0" align="center" height="auto" width="100%">
                                        <tbody>
                                            <tr>
                                                <td>
	                                                <table align="right" cellpadding="0" cellspacing="0" border="0">
	                                                	<tbody>
	                                                		<tr>
	                                                			<td><img src="http://www.uelbosque.edu.co/sites/default/files/comunica/mailings-2019/O-01101-carta-adminitos/head.png" style="display: block;" width="100%" height="auto" alt="Universidad El Bosque"/></td>
	                                                		</tr>
	                                                	</tbody>
	                                                </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <table cellpadding="30" cellspacing="0" border="0" align="center" height="auto" width="100%">
                                        <tbody>
                                            <tr>
                                                <td>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
<table align="center" cellpadding="0" cellspacing="0" border="0" width="84%" class="columna" >
	                                                	<tbody>
	                                                		<tr>
	                                                			<td align="left" style="color: #3F4826;font: 17px/22px Helvetica, sans-serif;">

Bogot&aacute;, ' . strftime("%d de %B de %Y") . '
                                                </td>
	                                                		</tr>
	                                                	</tbody>
	                                                </table>
                                    <table cellpadding="30" cellspacing="0" border="0" align="center" height="auto" width="100%">
                                        <tbody>
                                            <tr>
                                                <td>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                      <table align="center" cellpadding="0" cellspacing="0" border="0" width="84%" class="columna" >
	                                                	<tbody>
	                                                		<tr>
	                                                			<td align="left" style="color: #3F4826;font: 17px/22px Helvetica, sans-serif; text-align:justify;">

<b>Apreciado(a) ' . utf8_decode($nombre) . ':</b> <br/><br/>
En nombre de la Universidad El Bosque, me complace informarte que has sido admitido en nuestra instituci&oacute;n en el programa de '.$programa.', una de las mejores universidades del pa&iacute;s reconocida por su enfoque biopsicosocial y cultural y su alta calidad acad&eacute;mica.
    ¡Nos enorgullece tenerte con nosotros!<br/>
Junto a ti ser&aacute;n casi 13.000 estudiantes que conforman un espacio desde el cual podr&aacute;s alcanzar tu proyecto de vida y ponerle un t&iacute;tulo a tu historia personal. Al finalizar tu proceso de matr&iacute;cula, formar&aacute;s parte de una comunidad que busca contribuir al desarrollo de nuestro pa&iacute;s y aportar valor al entorno y la sociedad a partir de un modelo de formaci&oacute;n que te permitir&aacute; convertirte en un profesional emprendedor y exitoso.<br/>
Tu crecimiento acad&eacute;mico y personal es una tarea de todos los miembros de nuestra universidad; por eso, nuestro m&aacute;ximo esfuerzo se concentrar&aacute; en ofrecerte las condiciones propias para que desarrolles habilidades, principios, aptitudes, conocimientos y valores enraizados en nuestra cultura de la vida, su calidad y su sentido. <br/>
Sabemos que este 2020 trajo consigo circunstancias inesperadas y que pudo ser un año difícil para muchos; por ello, buscando que desarrolles tu formaci&oacute;n de la mejor manera, queremos asegurarte que continuaremos otorg&aacute;ndote la mejor educaci&oacute;n gracias a nuestras novedosas aulas multiprop&oacute;sito, nuestra inmensa capacidad tecnol&oacute;gica, el gran equipo de docentes que te acompañar&aacute; de inicio a fin y los espacios diseñados para ti, los cuales son bioseguros y cumplen con todas las normas necesarias para que, dado el momento, podamos encontrarnos contigo en nuestras instalaciones de Usaqu&eacute;n y Ch&iacute;a. Mientras esto sucede, te invito a conocer la Universidad haciendo clic <a href="http://360.perspectiva360.com/el-bosque/">aquí</a>. </br>
Desde ya cuentas con el respaldo de una Instituci&oacute;n con Acreditaci&oacute;n de Alta Calidad, certificaci&oacute;n que nos ubica en un selecto grupo donde no m&aacute;s del 19 % de instituciones de educación superior cuentan con esta certificaci&oacute;n por parte del Ministerio de Educaci&oacute;n Nacional, lo cual te da la posibilidad de tener beneficios durante tu formaci&oacute;n y recibir otros adicionales luego, como egresado. </br>
Estamos seguros de que tomar&aacute;s la mejor decisi&oacute;n para tu futuro profesional, por lo que te damos la bienvenida y auguramos a partir de este momento &eacute;xitos en el camino que has elegido junto a nosotros.

                                                </td>
	                                                		</tr>
	                                                	</tbody>
	                                                </table>
                                                      <table cellpadding="10" cellspacing="0" border="0" align="center" height="auto" width="100%">
                                        <tbody>
                                            <tr>
                                                <td>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                                                                          <table align="center" cellpadding="0" cellspacing="0" border="0" width="84%" class="columna" >
	                                                	<tbody>
	                                                		<tr>
	                                                			<td align="left" style="color: #3F4826;font: 17px/22px Helvetica, sans-serif; text-align:justify;">

<b>¡Bienvenido(a) a la Universidad El Bosque! </b>
                                                </td>
	                                                		</tr>
	                                                	</tbody>
	                                                </table>
                                                          <table cellpadding="10" cellspacing="0" border="0" align="center" height="auto" width="100%">
                                        <tbody>
                                            <tr>
                                                <td>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                                                                              <table align="center" cellpadding="10" cellspacing="0" border="0" width="87%" class="columna" >
	                                                	<tbody>
                                                        <tr>
                                                        <td align="left" style="color: #3F4826;font: 17px/22px Helvetica, sans-serif; text-align:justify;">
                                                        Cordialmente,  
                                                        </td>
                                                        </tr>
	                                                		<tr>
	                                                			<td>

<img src="http://www.unbosque.edu.co/sites/default/files/comunica/mailings2021/Firma-Dra-Rangel.png" style="display: block;" width="30%" height="auto" alt="Universidad El Bosque"/>


                                                </td>
                                                </tr>
                                                <tr>
                                                <td align="left" style="color: #3F4826;font: 12px/17px Helvetica, sans-serif;">
                                              <b>  María Clara Rangel Galvis </b>
                                                <br/>
                                                Rectora de la Universidad El Bosque
                                                </td>
                                                </tr>

	                                                		
	                                                	</tbody>
	                                                </table>
    <table align="center" cellpadding="0" cellspacing="0" border="0" width="84%" class="columna" >
	                                                	<tbody>
	                                                		<tr>
	                                                			<td align="center" style="color: #3F4826;font: 12px/17px Helvetica, sans-serif;">

Por una cultura de la vida, su calidad y su sentido <br/>
Transversal 9A Bis No. 132 - 55  |  Bogot&aacute; - Colombia <br/>
 PBX (571) 648 90 00 Fax 6252030 <br/>
www.unbosque.edu.co
                                                </td>
	                                                		</tr>
	                                                	</tbody>
	                                                </table>
                                    <table cellpadding="10" cellspacing="0" border="0" align="center" height="auto" width="100%">
                                        <tbody>
                                            <tr>
                                                <td>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table align="center" cellpadding="10" cellspacing="0" border="0" width="87%" class="columna" >
	                                                	<tbody>
	                                                		<tr>
	                                                			<td>
<img src="http://www.uelbosque.edu.co/sites/default/files/comunica/mailings-2019/O-01101-carta-adminitos/footer.png" style="display: block;" width="100%" height="auto" alt="Universidad El Bosque"/>
                                                				</td>
	                                                		</tr>
	                                                	</tbody>
	                                                </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </td>
        </tr>
    </table>
</body>
</html>
';
    return $html;
}

?>