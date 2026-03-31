<?php
$pageName= "contactenos";
require "../layouts/top_layout_admin.php";

global $IdiomaSitio;
$Mensajes = Comienzo ($pageName,$IdiomaSitio);
?>
<script language="JavaScript" type="text/javascript">
	function verifyEmail(checkEmail){
		if ((checkEmail.indexOf('@') < 0) || ((checkEmail.charAt(checkEmail.length-4) != '.') && (checkEmail.charAt(checkEmail.length-3) != '.'))){
			alert('<?= $Mensajes["warning.emailInvalido"];?>');
  			return false;
		}else{
  			return true;
		}
	}
	
	function evaluarcampo(c){
 		if (c.value == ''){
     		alert('<?= $Mensajes["warning.faltaCampo"]." ";?>'+ c.name);
     		c.focus();
     		return false;
   		}
   		return true;
	}
	
	function verificar(){
    	return ((evaluarcampo(document.forms.form1.nombre))
      		&&  (evaluarcampo(document.forms.form1.email))
      		&&  (verifyEmail(document.forms.form1.email.value))
      		&&  (evaluarcampo(document.forms.form1.subject))
      		&&  (evaluarcampo(document.forms.form1.texto)))
    }
</script>
<br>
<table class="table-form" align="center" width="80%" cellpadding="3">
    <tr>
    	<td class="table-form-top-blue"><?= $Mensajes["ec-1"];?> Celsius</td>
    </tr>
    <? if (empty($enviar)){ ?>
    	<tr>
    		<td>
				<blockquote>
	    			<?=$Mensajes["ec-2"];
	    			   $conf= new Configuracion;?> 
	    			<a href="mailto:<? echo $conf->getMailContacto(); ?>"><? echo $conf->getMailContacto();?></a> 
	    			<? echo $Mensajes["ec-3"]?>
    			</blockquote>
    		</td>
    	</tr>
    	<tr>
    		<td>
	    		<form name="form1" action="contactenos.php" onsubmit="return verificar();">
		    	<table class="table-form" align="center" cellpadding="3">
		    		<tr>
			           	<th><?=$Mensajes["ec-4"]?></th>
			           	<td>
			           		<input type="text" name="nombre" size="33"/>
			           	</td>
			        </tr>
			        <tr>
			        	<th><?=$Mensajes["ec-5"]?></th>
			            <td>
			            	<input type="text" name="email" size="33"/>
			            </td>
					</tr>
			        <tr>
			        	<th><?=$Mensajes["ec-6"]?></th>
			            <td>
			            	<input type="text" name="subject" size="33"/>
			            </td>
					</tr>
			        <tr>
			        	<th><?=$Mensajes["ec-7"]?></th>
			            <td>
			            	<textarea name="texto" cols="30" rows="5" ></textarea>
			            </td>
					</tr>
			        <tr>
			        	<th>&nbsp;</th>
						<td>
			            	<input type="submit" name="enviar" value="<?=$Mensajes["bot-1"]?>" />							
			                <input type="reset" value="<?echo $Mensajes["bot-2"]?>" />
			            </td>
					</tr>
				</table>
		        </form>
			</td>
		</tr>   
    <?}else{?>
    <tr>
    	<td>
			<?
			$fecha = getDate();
            $fechaFormateada = " ".$fecha['month']." ".$fecha['mday'].", ".$fecha['year'];
            $text = $nombre.' escribio el '.$fechaFormateada.': '.$texto;
            $conf= new Configuracion;
            $dest = $conf->getMailContacto();
            mail($dest,$subject,$text,'From:'.$email);
            echo $Mensajes["ec-8"];
            ?>
         </td>
     </tr>       
    <?}?>
</table>
<? require "../layouts/base_layout_admin.php";?> 