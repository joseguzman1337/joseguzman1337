<?php
	include_once("variables.php");
        include("templates/template.php");
        $db=getBD();
        $imagenSelectSql="SELECT * FROM sala.parametrizacionEducacionContinuada where nombreCampo='imagenEncabezado';";
$imagenSelectRow = $db->GetRow($imagenSelectSql);
$rutaImagen=$imagenSelectRow['valor'];
    ?>
<!DOCTYPE html>
<html>

<body id="tryit">


	


<script type="text/javascript" src="tinyMCE/js/tinymce/tinymce.min.js"></script>

<script type="text/javascript">
tinymce.init({
	selector: "h1.editable",
	inline: true,
	toolbar: "undo redo",
	menubar: false,
	autosave_ask_before_unload: false
});

tinymce.init({
	selector: "div.editable",
        language : 'es',
	inline: true,
	plugins: [
		"advlist autolink lists link image charmap print preview anchor",
		"searchreplace visualblocks code fullscreen",
		"insertdatetime media table contextmenu paste"
	],
	toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
	autosave_ask_before_unload: true
});



</script>

</script>



<div class="demo_content">
<div id="view">


<form method="post" action="dump.php">

	<table>
            <tr>
                <img src="<?php $rutaImagen ?>" alt="Smiley face" height="42" width="42">
            </tr>
		<tr align="center" valign="middle">
			<div class="editable" style="width:100%">
				<p align="center" >Blah blah blah la facultad de la mierda.</br> y la division de la paja</p> 
				
				
			</div>
		</tr>
		<tr>
			<div class="editable" style="width:100%">
				<p align="center" >Otorgan el presente mierdito este a el pendejo.</p>
			</div>
		</tr>
		<tr>
			<h1 align="center" >SUPER PENDEJO.</h1>
		</tr>
		<tr>
			<p align="center" >CC.631.</p>
		</tr>
		<tr>
			<div class="editable" style="width:100%">
				<p align="center" >Quien le dio el culo al profesor en:</p>
			</div>
		</tr>
		<tr>
			<h1 align="center" >CURSO DE PENDEJERA EXCESIVA.</h1>
		</tr>
		<div><a class="btn submitbtn" id="submitbtn" href="#"><span>Submit</span></a></div>
		<br class="clr" />

	<table>
</form>
</div>


</div>

		
		




</body>

<script type="text/javascript" language="javascript" src="../mgi/js/jquery.js"></script>
<script type="text/javascript">
$('#submitbtn').click(function(e){
	e.preventDefault(); 
	// the editor id is the same id of your textarea, default "content" in case your textarea does not have an id
//tinymce.get('your_editor_id').execCommand('mceInsertContent', false, "Test");


	//tinyMCE.activeEditor.execCommand('mceInsertContent', true, "Whatever text");
	
	//inserta una nueva linea al final
	//tinyMCE.activeEditor.dom.add(tinyMCE.activeEditor.getBody(), 'p', {title : 'my title'}, 'Some content');
        
        
        
	//var asuntox=document.getElementById('correoPromocionalAsunto').value;
        //tinyMCE.activeEditor.selection.setContent(asuntox);
	
	// Sets the HTML contents of the activeEditor editor
tinyMCE.activeEditor.setContent(tinyMCE.activeEditor.getContent({format : 'raw'})+'some html');
});
</script>
</html>
