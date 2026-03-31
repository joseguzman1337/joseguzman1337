<?
$pageName="body";
require "../layouts/top_layout_admin.php"; 

global $IdiomaSitio;

$Mensajes = Comienzo ($pageName,$IdiomaSitio);
?>

<!-- inicio TABLA 3-->
<table width="760" border="0" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="2" cellspacing="0">
	<tr bgcolor="#E4E4E4">
    	<td valign="top" bgcolor="#E4E4E4" align="center">
    	
<!-- inicio TABLA 4-->
<table width="580" border="0" align="center" cellpadding="2" cellspacing="4" bgcolor="#F3F3F1">
	<tr>
    	<td width="120" align="left" valign="top" background="../images/teclado.jpg">&nbsp;</td>
        <td align="left" valign="top">
        	<p class="style2"><? echo $Mensajes["st-002"]; ?></p>
        	<p align="center" class="style4">
        		<a href="../archivos_varios/manual_usuario.pdf" target="_blank">
        			<img border="0" width="20" height="20" src="../images/files/pdf.gif">
        		</a>&nbsp;
        		<a class='style15' href="../archivos_varios/manual_usuario.pdf" target="_blank"><? echo $Mensajes["st-004"]; ?></a>
        	</p>
		</td>
	</tr>
</table>
<!-- FIN TABLA 4-->

<hr align="center" width="580" size="1" class="style3">

<!-- inicio TABLA 5-->
<table width="580" border="0" align="center" cellpadding="3" cellspacing="2" bgcolor="#F3F3F1">
	<tr bgcolor="#09B6E1">
    	<td height="20" bgcolor="#0099CC" align="left">
			<p align="left" class="style1" style="margin-top: 0; margin-bottom: 0; color: #FFFFFF;">
				<img src="../images/square-w.gif" width="8" height="8">
				<span class="style5"><? echo $Mensajes["st-001"]; ?></span>     
		</td>
	</tr>
	<?
	$noticias = $servicesFacade->getNoticias(array("Codigo_Idioma" =>$IdiomaSitio), "Fecha Desc");
	
	//se muestran a lo sumo 3 noticias
	$noticias = array_slice($noticias, 0, 3);
	foreach($noticias as $noticia){?>
    	<tr bgcolor="#F3F3F1">
        	<td align="left" class="style15">
                <span class="style3">
                	<p style="margin-left: 3px; margin-top: 0px; margin-bottom: 0px; font-size: 12px; font-family: Arial, Helvetica, sans-serif;">
                	<span style="font-size: 10px">
                		<? if (strlen($noticia["Titulo"])>100){
							$titulo = substr($noticia["Titulo"],0,100)."...";
						}else {
							$titulo = $noticia["Titulo"];
						}
						echo  strtoupper($titulo);
                        ?>.
					</span>
					<br>
				</span>
				<span class="style2">
					<p style="margin-left: 3px; margin-top: 0px; margin-bottom: 0px; font-size: 12px;font-family: Arial, Helvetica, sans-serif;">
						<span style="font-size: 10px">
							<font face="Arial"><? echo substr($noticia["Texto_Noticia"],0,270)."...";?></font>
						</span><br>
                    </p>
				</span>
			</td>
		</tr>
        <tr class="style3">
        	<td align="right" valign="middle" bgcolor="#E4E4E4">
        		<font size="1" face="Arial" class="style15"> 
        			<?= date("d/m/Y",strtotime($noticia["Fecha"]))." |";?>
                    <a class='style15' href='../noticias/mostrarNoticia.php?idNoticia=<?=$noticia["Id"]?>'>Leer m&aacute;s &gt;&gt;</a>
				</font>
			</td>
		</tr>
	<? } ?>
</table>
<!-- FIN TABLA 5-->
		
		</td>
		<td width="154" valign="top" align="center">
			<table width="100%" height="20" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#0099CC">
			<tr>
            	<td class="style5"><div align="center" class="style18"><? echo $Mensajes["st-005"]; ?></div></td>
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
            
			<table width="100%" height="60" border="0" align="center" cellpadding="0" cellspacing="2" bgcolor="#E4E4E4">
            	<tr>
                	<td height="20" bgcolor="#0080C0" class="style5" align="center">
						<table border="0" align="left" cellpadding="0" cellspacing="2">
                        <tr>
                        	<td><img src="../images/m_1_s.gif" width="14" height="11"></td>
                            <td class="style5"><a href="../mail/contactenos.php" class="style5"><? echo $Mensajes["st-009"]; ?></a> </td>
						</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td height="20" bgcolor="#006699" class="style5">
                    	<table border="0" align="left" cellpadding="0" cellspacing="2">
                        <tr>
							<td><img src="../images/home_s.gif" width="15" height="15"></td>
							<td class="style5"><? echo $Mensajes["st-010"]; ?></td>
						</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td height="150" valign="middle" bgcolor="#F3F3F1" class="style5">
						<p align="center"><a href="http://www.unlp.istec.org" target="_blank">
							<img border="0" src="../images/banner-istec.jpg" width="88" height="31">
						</a></p>
						<p align="center"><a href="http://sedici.unlp.edu.ar" target="_blank" >
							<img border="0" src="../images/webservices03.gif" width="88" height="31">
						</a></p>
						<p align="center"><a href="http://www.unlp.istec.org/prebi/" target="_blank" >
							<img border="0" src="../images/banner-prebi.jpg" width="88" height="31">
						</a></p>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<!-- FIN TABLA 3-->

<? require "../layouts/base_layout_admin.php"; ?>