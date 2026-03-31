<?
$pageName= "descripcion_servicio";
require "../layouts/top_layout_admin.php";
global $IdiomaSitio;
$Mensajes = Comienzo($pageName, $IdiomaSitio);
?>
<link rel="stylesheet" type="text/css" href="..css/celsiusStyles.css">
<a name="top"></a>
<!-- INICIO TABLA PRINCIPAL -->
<!--<table width="95%" class="style43" border="0" cellpadding="0" cellspacing="0" border="0">-->
<table width="100%" border="0" cellpadding="0" cellspacing="0" border="0">

<tr>
		<td bgcolor="#e4e4e4" valign="top">
			<!-- INICIO TABLA 2 -->
			<table border="0" cellpadding="6" cellspacing="6" class="style22">
          	<tr>
            	<td>
            		<!-- AREA DE INFORMACION GENERAL -->
            		<p class="titulo"><?= $Mensajes['st-001']; ?></p>
              		<p>
              			<?= $Mensajes['st-002']; ?>
              		</p>
              		
              		<!-- QUE ES EL PREBI? -->
              		<p class="titulo"><?= $Mensajes['titulo.prebi']; ?><a name="link1" id="link1"></a></p>
              		<p>
              			<?= $Mensajes['texto.prebi']; ?>
              		</p>
              		<p class="boton-up"><a href="#top" class="boton-up">Arriba</a></p>
              		
              		<!-- QUE ES EL ISTEC -->
              		<p class="titulo"><?= $Mensajes["st-006"];?><a name="link2"></a></p>
              		<p class="style15">
              			<? echo $Mensajes['st-005'];?>
              		</p>
					<p><?= $Mensajes["st-007"];?></p>
              		<p class="boton-up"><a href="#top" class="boton-up">Arriba</a></p>
              		
              		<!-- CUALES SON SUS OBJETIVOS -->
              		<p class="titulo"><?= $Mensajes["st-008"];?><a name="link3"></a></p>
              		<p><?= $Mensajes["st-009"];?></p>
              		<p class="boton-up"><a href="#top" class="boton-up">Arriba</a> </p>
              		
              		<!-- QUE PROYECTOS SUSTENTA ISTEC -->
              		<p class="titulo"><?= $Mensajes["st-010"];?><a name="link4" id="link4"></a></p>
              		<p> <?= $Mensajes["st-011"];?></p>
              		<p> * <?= $Mensajes["st-012"];?><br>
                		* <?= $Mensajes["st-013"];?><br>
                		* <?= $Mensajes["st-014"];?><br>
                		* <?= $Mensajes["st-015"];?></p>
              		<p class="boton-up"><a href="#top" class="boton-up">Arriba</a></p>
              		
              		<!-- QUIENES SON SUS MIEMBROS -->
              		<p class="titulo"><?= $Mensajes["st-016"];?><a name="link5" id="link5"></a></p>
              		<p>
              			<strong><?= $Mensajes["st-017"];?></strong><br>
		                <?= $Mensajes["p-1"];?>
		            </p>
              		<p> <strong><?= $Mensajes["st-018"];?></strong><br>
                		<?= $Mensajes["i-1"];?>
                	</p>
              		<p> <strong><?= $Mensajes["st-019"];?></strong><br>
                		<?= $Mensajes["i-2"];?>
                	</p>
              		<p> <strong><?= $Mensajes["st-23"];?></strong><br>
                		<?= $Mensajes["i-3"];?>
                	</p>
              		<p class="boton-up"><a href="#top" class="boton-up">Arriba</a></p>
              		
              		<!-- SITIOS EN AMERICA LATINA -->
              		<p class="titulo"><?= $Mensajes["link.sitios"];?><a name="link6" id="link6"></a></p>
              		<p><?= $Mensajes["mensaje.descripcion"];?>.&nbsp;&nbsp;&nbsp;<a href="http://prebi.unlp.edu.ar/usuarios/AmericaLatina.ppt"><img src="../images/files/pps.gif" border="0" /></a></p>
             		<p class="boton-up"><a href="#top" class="boton-up">Arriba</a></p>
              		
              		<!-- LOGOS PREBI/CELSIUS -->
              		<p class="titulo">Logos PrEBi / Celsius<a name="link7" id="link7"></a></p>
              		<p>A la brevedad podr&aacute; descargar aqu&iacute; los logos de PrEBi y de los distintos Celsius.</p>
              		<p class="boton-up"><a href="#top" class="boton-up">Arriba</a></p>
              		
              		<!-- STAFF DEL PREBI -->
              		<p class="titulo"><?= $Mensajes["st-021"];?><a name="link8" id="link8"></a></p>
              		<p><?= $Mensajes["st-022"];?></p>
              		<p>
              			DE GIUSTI, Marisa R.<br>
              			<span class="style15">Directora Proyectos PrEBi - SeDiCI / ISTEC Ex-Comm Directory Member</span><br>
                		ALTAVISTA, Manrique Lucio<br>
                		<span class="style15">B&uacute;squeda de Documentos</span><br>
		                NUSCH, Carlos<br>
                		<span class="style15">B&uacute;squeda de Documentos - Difusi&oacute;n</span><br>
                		SOSA, Emanuel<br>
                		<span class="style15">B&uacute;squeda de Documentos</span><br>
                		FERNANDEZ, Esteban Cristian<br>
                		<span class="style15"> B&uacute;squeda de Documentos</span><br>
                		JAQUENOD, Gustavo<br>
                		<span class="style15">B&uacute;squeda de Documentos</span><br>
                		SOBRADO, Ariel<br>
                		<span class="style15">An&aacute;lisis y Dise&ntilde;o de Sistemas</span><br>
                		LIRA, Ariel<br>
                		<span class="style15">An&aacute;lisis y Dise&ntilde;o de Sistemas</span><br>
                		VILA, Maria Marta<br>
                		<span class="style15">An&aacute;lisis y Dise&ntilde;o de Sistemas</span><br>
                		VILLARREAL, Gonzalo Luj&aacute;n<br>
                		<span class="style15">An&aacute;lisis y Dise&ntilde;o de Sistemas</span><br>
                		INAFUKU, Fernando<br>
                		<span class="style15">An&aacute;lisis y Dise&ntilde;o de Sistemas</span><br>
                		JAQUENOD, Gisele<br>
                		<span class="style15">Dise&ntilde;o Gr&aacute;fico</span>
                	</p>
              		<p class="boton-up"><a href="#top" class="boton-up">Arriba</a></p>
              				
              	</td>
            </tr>
            </table>
            <!-- FIN TABLA 2 -->
		</td>
		
		
		<td bgcolor="#e4e4e4" valign="top" width="200">
			<!-- TABLA MENU DE LA DERECHA -->
			<table cellpadding="3" cellspacing="2" bgcolor="#ececec" border="0">
			<tr>
        		<td align="center" bgcolor="#006599" class="style18">&Iacute;ndice</td>
        	</tr>
        	<tr>
        		<td class="style22">
	        		<div align="left" style="margin-top: 0pt; margin-bottom: 0pt;">
    	            	<img src="../images/arrow_A_ver1.gif" height="9" width="9" />&nbsp;<a href="#link1" class="style22">&iquest;Qu&eacute; es el PrEBi?</a>
             		</div>
            	</td>
        	</tr>
        	<tr>
	        	<td class="style22">
    	    		<div align="left" style="margin-top: 0pt; margin-bottom: 0pt;">
    	    			<img src="../images/arrow_A_ver1.gif" height="9" width="9" />&nbsp;<a href="#link2" class="style22"><?= $Mensajes["st-006"];?></a>
        			</div>
        		</td>
        	</tr>
        	<tr>
	            <td class="style22">
            		<div align="left" style="margin-top: 0pt; margin-bottom: 0pt;">
	          			<img src="../images/arrow_A_ver1.gif" height="9" width="9" />&nbsp;<a href="#link3" class="style22"><?= $Mensajes["st-008"];?></a>
               		</div>
            	</td>
        	</tr>
        	<tr>
	            <td class="style22">
	            	<div align="left" style="margin-top: 0pt; margin-bottom: 0pt;">
            			<img src="../images/arrow_A_ver1.gif" height="9" width="9" />&nbsp;<a href="#link4" class="style22"><?= $Mensajes["st-010"];?></a>
            		</div>
            	</td>
        	</tr>
        	<tr>
	            <td class="style22">
            		<div style="margin-top: 0pt; margin-bottom: 0pt;" align="left">
	                	<img src="../images/arrow_A_ver1.gif" height="9" width="9">&nbsp;<a href="#link5" class="style22"><?= $Mensajes["st-016"];?></a>
                	</div>
            	</td>
        	</tr>
        	<tr>
	        	<td class="style22">
        			<div style="margin-top: 0pt; margin-bottom: 0pt;" align="left">
	            		<img src="../images/arrow_A_ver1.gif" height="9" width="9">&nbsp;<a href="#link6" class="style22"><?= $Mensajes["link.sitios"];?></a>
             		</div>
	            </td>
        	</tr>
        	<tr>
	        	<td class="style22">
    	    		<div style="margin-top: 0pt; margin-bottom: 0pt;" align="left">
	                	<img src="../images/arrow_A_ver1.gif" height="9" width="9">&nbsp;<a href="#link7" class="style22">Logos PrEBi / Celsius</a>
                	</div>
            	</td>
        	</tr>
        	<tr>
	            <td class="style22">
            		<div style="margin-top: 0pt; margin-bottom: 0pt;" align="left">
	                	<img src="../images/arrow_A_ver1.gif" height="9" width="9">&nbsp;<a href="#link8" class="style22"><?= $Mensajes["st-021"];?></a>
             		</div>
            	</td>
        	</tr>
	        </table>
	        <!-- FIN TABLA MENU DE LA DERECHA -->
		</td>
</tr>
</table>
<!-- FIN TABLA PRINCIPAL--->
<?require "../layouts/base_layout_admin.php";?>