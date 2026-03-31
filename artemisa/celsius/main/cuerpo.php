<?
$pageName="body";
require "../layouts/top_layout_admin.php"; 

global $IdiomaSitio;
$Mensajes = Comienzo ($pageName,$IdiomaSitio);
?>
<!--
<link href="../css/celsius2007.css" rel="stylesheet" type="text/css">
<title>Prebi</title>
<link href="../css/celsius.css" rel="stylesheet" type="text/css">
-->
<!--inicio TABLA 1-->
<table bgcolor="#e4e4e4" border="0" cellpadding="2" cellspacing="0" width="760">
<tr bgcolor="#e4e4e4">
	<td bgcolor="#e4e4e4" valign="top">
    	<span align="center"><center>
                            
    	<!-- inicio TABLA textos centrales-->
    	<table width="560" border="0" align="center" cellpadding="3" cellspacing="0">
        <tr>
        	<td valign="top"><img src="../images/image-inicio.gif" width="65" height="250" hspace="2" vspace="2" align="left"></td>
            <td valign="top">
            	<!-- INICIO texto parametrizado -->
            	<?$param= $servicesFacade->getParametros();
            	  echo $param["texto"];?>
				<!-- FIN texto parametrizado -->
				
				<!-- INICIO NOTICIAS -->
				<p class="titulo"><?= $Mensajes["st-001"];?></p>
				<?$noticias = $servicesFacade->getNoticias(array("Codigo_Idioma" =>$IdiomaSitio), "Fecha Desc");
				 
				  //se muestran a lo sumo 2 noticias
				  $noticias = array_slice($noticias, 0, 2);
				  foreach($noticias as $noticia){
				  	if (strlen($noticia["Titulo"])>100){
						$titulo = substr($noticia["Titulo"],0,100)."...";
					}else {
						$titulo = $noticia["Titulo"];
					}
				    echo  "<p class='style8'>".strtoupper($titulo)."</p>";
                ?>
					<span class="style2">
						<p style="margin-left: 3px; margin-top: 0px; margin-bottom: 0px; font-size: 12px;font-family: Arial, Helvetica, sans-serif;">
							<span style="font-size: 10px">
							<font face="Arial"><? echo substr($noticia["Texto_Noticia"],0,270)."...";?></font>
							</span>
       					</p>
       					<p>
       						<span style="font-size: 10px">
       						<?= date("d/m/Y",strtotime($noticia["Fecha"]))." |";?><a class='style15' href='../noticias/mostrarNoticia.php?idNoticia=<?=$noticia["Id"]?>'>Leer m&aacute;s &gt;</a>
       						</span>
       					</p>
					</span>
	 			<?}?>
	 			<!-- FIN NOTICIAS --> 	
			</td>
        </tr>
        <tr>
            <td colspan="2">
            <!-- INICIO ACERCA DEL SITIO -->
            	<p class="titulo"><?= $Mensajes["titulo.acerca"];?></p>
                <p>
                	<span class="style2"><?= $Mensajes["st-012"];?>.</span>
                    <span class="style15"><?= $Mensajes["st_003"];?>.</span>
                </p>
            <!-- FIN ACERCA DEL SITIO -->
            </td>
        </tr>
        </table>
        <!-- fin TABLA textos centrales-->
             
        </center></span>
    </td>
    <td valign="top" width="150">
       	<div align="center">
                    
        <!-- inicio TABLA Login-->
        <table align="center" bgcolor="#0099cc" border="0" cellpadding="0" cellspacing="0" height="20" width="100%">
        <tr>
    	   	<td class="style5">
    	   	<?//TODO (Trad!))?>
         		<div class="style18" align="center">Bienvenido a Celsius </div>
           	</td>
        </tr>
        </table>
        <table width="100%" border="0" align="center" cellpadding="1" cellspacing="2" bgcolor="#E4E4E4">
				<?if (SessionHandler::getRolUsuario() == ROL__INVITADO){?>
	            	<tr>
	                	<td width="13" align="center"><img src="../images/square-lb.gif" width="8" height="8"></td>
	                    <td bgcolor="#F3F3F1" class="style2"><a href="../candidatos/agregar_candidato.php" class="style15" ><? echo $Mensajes["st-006"]; ?></a> </td>
					</tr>
					<tr>
						<td width="13" align="center"><img src="../images/square-lb.gif" width="8" height="8"></td>
						<td bgcolor="#F3F3F1" class="style2">
							<a  href="../sitio_usuario/login_usuario.php" class="style15"><? echo $Mensajes["st-007"]; ?></a>
						</td>
					</tr>
				<?}else{
					if (SessionHandler::getRolUsuario() == ROL__ADMINISTADOR){?>
						<tr>
	                		<td width="13" align="center"><img src="../images/square-lb.gif" width="8" height="8"></td>
	                    	<td bgcolor="#F3F3F1" class="style2"><a href="../sitio_usuario/sitio_administrador.php" class="style15" ><? echo "Sitio Administrador"; ?></a> </td>
						</tr>
					<?}?>
					<tr>
	                	<td width="13" align="center"><img src="../images/square-lb.gif" width="8" height="8"></td>
	                    <td bgcolor="#F3F3F1" class="style2"><a href="../sitio_usuario/sitio_usuario.php" class="style15" ><? echo "Sitio Usuario"; ?></a> </td>
					</tr>
				<?}?>
			</table>
        <table align="center" bgcolor="#e4e4e4" border="0" cellpadding="0" cellspacing="2" height="60" width="100%">
        <tr>
           	<td class="style5" bgcolor="#0080c0" height="20">
          		<div align="center">
           			<table align="left" border="0" cellpadding="0" cellspacing="2">
           			<tr>
	           			<td><img src="../images/m_1_s.gif" height="11" width="14"></td>
                    	<td class="style5"><a href="../mail/contactenos.php" class="style5"><?= $Mensajes["st-009"]; ?></a></td>
        			</tr>
        			</table>
                </div>
            </td>
        </tr>
        <tr>
            <td class="style5" bgcolor="#006699" height="20">
                <table align="left" border="0" cellpadding="0" cellspacing="2">
                <tr>
                    <td><img src="../images/home_s.gif" height="15" width="15"></td>
                    <td class="style5"><? echo $Mensajes["st-010"]; ?></td>
                </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td class="style5" bgcolor="#f3f3f1" height="150" valign="middle">
                <p align="center">
                   <a href="http://www.unlp.istec.org/" target="_blanck">
                  	  <img border="0" src="../images/banner-istec.jpg" width="88" height="31" />
                   </a>
                </p>
                <p align="center">
                   <a href="http://sedici.unlp.edu.ar/" target="_blanck">
                      <img border="0" src="../images/webservices03.gif" width="88" height="31" />
                   </a>
                </p>
                <p align="center">
                   <a href="http://www.unlp.istec.org/prebi/" target="_blanck">
                      <img border="0" src="../images/banner-prebi.jpg" width="88" height="31" />
                   </a>
                </p>
            </td>
        </tr>
    	</table>
        <!-- fin TABLA Login-->
                    
        </div>
    </td>
</tr>
</table>
<!--fin TABLA 1-->
<? require "../layouts/base_layout_admin.php"; ?>