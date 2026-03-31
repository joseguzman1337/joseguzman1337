<?php
	include_once("../variables.php");
        include("../templates/template.php");
        $db=  writeHeader("wiii un certificado",TRUE);
        $imagenSelectSql="SELECT * FROM sala.parametrizacionEducacionContinuada where nombreCampo='imagenEncabezado';";
$imagenSelectRow = $db->GetRow($imagenSelectSql);
$rutaImagen=$imagenSelectRow['valor'];
    ?>
<!DOCTYPE html>
<html>

<body id="tryit">


	


<script type="text/javascript" src="../tinyMCE/js/tinymce/tinymce.min.js"></script>

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





<div class="demo_content">
<div id="view">



<form id="todo" method="post" action="pruebaPDF.php">

    <input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
            
        

        <div class="editable" style="width:100%">
                <p align="center" >Blah blah blah la facultad de aglo.</br> y la division de la otra</p> 


        </div>

        <div class="editable" style="width:100%">
                <p align="center" >Otorgan el presente documento a:</p>
        </div>

        <h1 align="center" >PEPITO PEREZ</h1>

        <p align="center" >CC.631.</p>

        <div class="editable" style="width:100%">
                <p align="center" >QUIEN ASISTIO A :</p>
        </div>
        <h1 align="center" >CURSO DE PRUEBA</h1>
     <table width=100% style="border: none">
        <tr align="center" >
            <td style="border: none"><p align="center" >--------------------------------- </br> Dr. Prueba pruebita </br> Director del programa de prueba </br> Instituto colombiano de pruebas</p></td>
                        <td style="border: none"><p align="center" >----------------------------- </br> Dr. Prueba pruebita </br> Director del programa de prueba </br> Instituto colombiano de pruebas</p></td>
                <td style="border: none"><p align="center" >---------------------------------- </br> Dr. Prueba pruebita </br> Director del programa de prueba </br> Instituto colombiano de pruebas</p></td>
        </tr>


    </table>
   
</form>
</div>
 <div><a class="btn submitbtn" id="submitbtn" href="#"><span>Submit</span></a></div>
		<br class="clr" />

</div>

		
		




</body>


<script type="text/javascript">
$('#submitbtn').click(function(e){
	e.preventDefault(); 
        
        $("#datos_a_enviar").val( $("<div>").append( $("#todo").eq(0).clone()).html());
        //document.getElementById("todo").innerHTML;
        //document.getElementById("datos_a_enviar").value="hola";
     $("#todo").submit();

	// the editor id is the same id of your textarea, default "content" in case your textarea does not have an id
        //tinymce.get('your_editor_id').execCommand('mceInsertContent', false, "Test");


	//tinyMCE.activeEditor.execCommand('mceInsertContent', true, "Whatever text");
	
	//inserta una nueva linea al final
	//tinyMCE.activeEditor.dom.add(tinyMCE.activeEditor.getBody(), 'p', {title : 'my title'}, 'Some content');
        
        
        
	//var asuntox=document.getElementById('correoPromocionalAsunto').value;
        //tinyMCE.activeEditor.selection.setContent(asuntox);
	
	// Sets the HTML contents of the activeEditor editor
        
        //tinyMCE.activeEditor.setContent(tinyMCE.activeEditor.getContent({format : 'raw'})+'some html');
});
</script>
</html>
<?php  writeFooter(); ?>