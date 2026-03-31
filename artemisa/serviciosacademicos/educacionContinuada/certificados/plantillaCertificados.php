<?php
		include_once("../variables.php");
        include("../templates/template.php");
        $db=  writeHeader("Plantilla Certificado Estudiante",TRUE);
        $utils = Utils::getInstance();
		initializeCertificados();
		$utilsC = Utils_Certificados::getInstance();
        /*$imagenSelectSql="SELECT * FROM sala.parametrizacionEducacionContinuada where nombreCampo='imagenEncabezado';";
        $imagenSelectRow = $db->GetRow($imagenSelectSql);
        $rutaImagen=$imagenSelectRow['valor'];
        $nombrePrograma = "{{nombrePrograma}}";
        $intensidadPrograma = "{{intensidadPrograma}}";
        $ciudadPrograma = "{{ciudadPrograma}}";*/
		$reemplazos = array();
        if(isset($_REQUEST["curso"])&& $_REQUEST["curso"]!=""){
            $data = $utils->getDataEntity("carrera", $_REQUEST["curso"],"codigocarrera");
            if(count($data)>0){
                $dataPlantilla = $utils->getDataEntityActive("plantillaCursoEducacionContinuada", $data["codigocarrera"],"codigocarrera","");
                
                $nombrePrograma = $data["nombrecarrera"];
                
                $detalleCurso = $utils->getDataEntityActive("detalleCursoEducacionContinuada", $data["codigocarrera"], "codigocarrera"); 
                if(count($detalleCurso)>0){
                    $ciudad = $utils->getDataEntity("ciudad", $detalleCurso["ciudad"], "idciudad"); 
                    $intensidadPrograma = $detalleCurso["intensidad"];
                    $ciudadPrograma = $ciudad["nombrecortociudad"];
                }
                
                if(count($dataPlantilla)==0){
                    $dataPlantilla = $utils->getDataEntity("plantillaGenericaEducacionContinuada", 1,"idplantillaGenericaEducacionContinuada");
                    //toca generar la plantilla al curso
                    $fields = array();
                    $fields["codigocarrera"] = $data["codigocarrera"];
                    $fields["plantilla"] = $dataPlantilla["plantilla"];
                    $dataPlantilla["idplantillaCursoEducacionContinuada"] = $utils->processData("save","plantillaCursoEducacionContinuada","idplantillaCursoEducacionContinuada",$fields,false);
				}
				$decodificado = $utilsC->decodificarPlantillaHTMLEditar($dataPlantilla['plantilla'],$data["codigocarrera"],$dataPlantilla["idplantillaCursoEducacionContinuada"]);
				$dataPlantilla["plantilla"] = $decodificado["plantilla"];
				$reemplazos = $decodificado["decode"];
			}
        } else {
			$dataPlantilla = $utils->getDataEntity("plantillaGenericaEducacionContinuada", 1,"idplantillaGenericaEducacionContinuada");   
			$decodificado = $utilsC->decodificarPlantillaHTMLEditarGenerico($dataPlantilla['plantilla']);  
			$dataPlantilla["plantilla"] = $decodificado["plantilla"];
			$reemplazos = $decodificado["decode"];
		}
    ?>
	


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
	selector: "p.editable",
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
 <?php if(isset($_REQUEST["curso"])&& $_REQUEST["curso"]!=""){ ?>
	<input type="hidden" name="action"  value="saveCourse" />
	<input type="hidden" name="idplantillaCursoEducacionContinuada" value="<?php echo $dataPlantilla["idplantillaCursoEducacionContinuada"]; ?>">
<?php } ?>
    <input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
<input type="hidden" name="stringPlantilla" id="stringPlantilla" value="" />
<input type="hidden" name="idplantillaGenericaEducacionContinuada" value="1">
<input type="hidden"  class="grid-5-12 required" name="nombre" id="nombre" title="Nombre de la plantilla" maxlength="200" tabindex="1" autocomplete="off" style="visibility: hidden" value="Certificado de Programas de Educación Continuada" />
    <div id="plantilla">
        
<?php echo $dataPlantilla["plantilla"]; /*?>
<img src='../parametrizacion/images/bosque_2013-07-09.jpg' alt='logo' width="100%">



    
        

        <div class="editable" style="width:100%">
                <p align="center" style="margin: 30px 0 40px;">LA DIVISIÓN DE EDUCACIÓN CONTINUADA</p> 
        
                <p align="center" >OTORGA EL PRESENTE CERTIFICADO A:</p>
        </div>

        <h1 align="center" style="margin:30px 0 0;">{{nombreEstudiante}}</h1>

        <p align="center" style="margin:5px 0 50px;">{{tipoDocumentoCortoEstudiante}}. {{documentoEstudiante}}</p>

        <div class="editable" style="width:100%">
                <p align="center" >Quien asistió y cumplió los requisitos académicos establecidos para el:</p>
        </div>
        <h1 align="center" style="margin:20px 0 0;"><?php echo $nombrePrograma; ?></h1>
		
		<div class="editable" style="width:100%">
                <p align="center" style="margin:0px 0 10px;font-size:0.9em">Intensidad <?php echo $intensidadPrograma; ?> Horas</p> 
        </div>
        <p align="center" ><?php echo $ciudadPrograma; ?>, {{fechaGrupoPrograma}}</p>
     <table width="100%" style="border: none;width:100%">
        <tr align="center" >
            <td style="border: none"><p align="center" >--------------------------------- </br> Nombre </br> Cargo </br> Organización/Unidad</p></td>
                        <td style="border: none"><p align="center" >----------------------------- </br> Nombre </br> Cargo </br> Organización/Unidad</p></td>
                <td style="border: none"><p align="center" >---------------------------------- </br> Nombre </br> Cargo </br> Organización/Unidad</p></td>
        </tr>

    </table>
        
        <p style="text-align:right;font-size:0.8em">{{consecutivoCertificado}}</p>
   
</form><?php */ ?>
    </div>
    <input type="submit" value="Guardar cambios" class="" style="margin-bottom:10px" />
</form>
</div>
 

</div>


<script type="text/javascript">
$('#submitbtn').click(function(e){
	e.preventDefault(); 
		var valor = $.trim($("<div>").append( $("#todo").eq(0).clone()).html());
        
        $("#datos_a_enviar").val( valor );
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


$(':submit').click(function(event) {
     event.preventDefault();
	 var valorPrev = document.getElementById("plantilla").innerHTML;
	 
		<?php foreach ($reemplazos as $row){ 
				echo "$('#$row[1]').before('$row[0]');";
				echo "$('#$row[1]').remove();";
			}
		?>
		
     var valor =  $.trim(document.getElementById("plantilla").innerHTML);
     //var $valor = $(valor);  // create elements from the string, and cache them
     //$valor.find('div').removeAttr("data-mce-style");
		document.getElementById("stringPlantilla").value = valor;
		document.getElementById("plantilla").innerHTML = valorPrev;
         $.ajax({
            dataType: 'json',
            type: 'POST',
            url: 'process.php',
            data: $('#todo').serialize(),                
            success:function(data){
                if (data.success == true){
                    alert('Se han guardado los cambios de forma correcta.');
                }
                else{             
                    alert("Ocurrio un error al guardar la plantilla.");
                }
            },
            error: function(data,error,errorThrown){alert(error + errorThrown);}
         });          
    });



</script>
<?php  writeFooter(); ?>