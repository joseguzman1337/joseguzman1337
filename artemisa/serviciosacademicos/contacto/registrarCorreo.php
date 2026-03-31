<?php
//include ('../mgi/templates/template.php');
//include("../mgi/autoevaluacion/interfaz/phpcaptcha/Captcha_html.php");
//<meta http-equiv="refresh" content="0; URL=../mgi/autoevaluacion/interfaz/phpcaptcha/Captcha_html.php?instrumento=138">
if(isset($_REQUEST['acepta'])){
	?>
	<frameset cols="100%,*,">
		<frame src="../mgi/autoevaluacion/interfaz/phpcaptcha/registraCorreo.php?acepta=<?php echo $_GET['acepta']; ?>&cod=<?php echo $_GET['cod']; ?>">
		
	</frameset>
<?php
}else{
?>
<frameset cols="100%,*,">
    <frame src="../mgi/autoevaluacion/interfaz/phpcaptcha/registraCorreo.php">
    
</frameset>
<?php } ?>