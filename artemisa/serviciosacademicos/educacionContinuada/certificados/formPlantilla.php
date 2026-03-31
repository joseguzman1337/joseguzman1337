<?php
function writeForm($edit, $db, $id="") {
    $data = array();
    $action = "save";
    $utils = Utils::getInstance();
	$campos = $utils->getAll($db,"nombre,etiqueta","campoParametrizadoPlantillaEducacionContinuada","codigoestado=100 and visible=1","nombre");
    if($edit){
        $action = "update";
        if($id!=""){    
            $data = $utils->getDataEntity("plantillaGenericaEducacionContinuada", $id,"idplantillaGenericaEducacionContinuada");   
        }
    }
	$campos = $campos->GetArray();

?>
<script type="text/javascript" src="../tinyMCE/js/tinymce/tinymce.min.js"></script>

<script type="text/javascript">

tinymce.init({
    selector: "textarea.editable",
    language : 'es',
    plugins: [
        "advlist autolink lists link image charmap print preview anchor",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime table contextmenu paste"
    ],
    toolbar: "insertfile undo redo | mybutton | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image ",
	setup: function(editor) {
        editor.addButton('mybutton', {
            type: 'menubutton',
            text: 'Campos Educación Continuada',
            icon: false,
            menu: [
				<?php 
                    for ($i = 0; $i < count($campos); $i++) {
						if($i!==(count($campos)-1)){
							echo "{text: '".$campos[$i]["nombre"]."', onclick: function() {editor.insertContent('".$campos[$i]["etiqueta"]."');}},";
						} else {
							echo "{text: '".$campos[$i]["nombre"]."', onclick: function() {editor.insertContent('".$campos[$i]["etiqueta"]."');}}";
						}
                    } ?>
            ]
        });
    }

});


</script>


<div id="form"> 
    <div id="msg-error"><?php echo $_REQUEST["mensaje"]; ?></div>
    
    <form action="save.php" method="post" id="form_test" name="signForm" >
            <input type="hidden" name="entity" value="plantillaGenericaEducacionContinuada" />
            <input type="hidden" name="action" value="<?php echo $action; ?>" />
            <input type="hidden" name="stringPlantilla" id="stringPlantilla" value="" />
            <?php
            if($edit&&$id!=""){
                echo '<input type="hidden" name="idplantillaGenericaEducacionContinuada" value="'.$id.'">';
            }
            ?>
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset style="padding-bottom:0;">   
                <legend>Información de la plantilla</legend>
                <label for="apellidodocente" class="grid-2-12">Nombre: <span class="mandatory">(*)</span></label>
                <input type="text"  class="grid-5-12 required" name="nombre" id="nombre" title="Nombre de la plantilla" maxlength="200" tabindex="1" autocomplete="off" value="<?php if($edit){ echo $data['nombre']; } ?>" />
            
                <!--<label for="nombre" class="grid-2-12">Insertar Campos: </label>
                <?php // campoDinamico es el nombre del select, el null es el que esta elegido de la lista, 
                        //primer true que se deje una opción en blanco, segundo false que no deje elegir múltiples opciones
					//el 1 es si es un listbox o un select, 
				//echo $campos->GetMenu2('campoDinamico',null,true,false,1,'id="campoDinamico" class="required"'); ?>
                
				<input type="button" value="Insertar campo" style="float:left;margin-left:15px;padding: 3px 19px 5px;" id="buttonInsert"/>
                -->
                <label for="nombre" class="grid-2-12" style="margin-right:15px;">Plantilla del Mensaje: <span class="mandatory">(*)</span></label>
                
                <div class="vacio" style="margin-bottom:20px;"></div>
				<textarea class="editable" id="plantilla" name="plantilla" style="width: 792px; height: 20em"><?php if($edit){ echo $data['plantilla']; } ?></textarea>
				<!--<textarea name="content" style="width: 792px; height: 20em"></textarea>-->
                
            </fieldset>
            
            <?php if($edit){ ?><input type="submit" value="Guardar cambios" class="" style="margin-bottom:10px" />
            <?php } else { ?><input type="submit" value="Registrar plantilla" class="" style="margin-bottom:10px" /> <?php } ?>
        </form>
</div>

<script type="text/javascript">
    $(':submit').click(function(event) {
        event.preventDefault();
        var valido= validateForm("#form_test");
        
        if(valido && tinyMCE.get('plantilla').getContent({format : 'raw'})!="" && tinyMCE.get('plantilla').getContent({format : 'raw'})!='<p><br data-mce-bogus="1"></p>'){      
            sendForm();
        }
    });
    
    function sendForm(){
        
        document.getElementById("stringPlantilla").value= tinyMCE.get('plantilla').getContent({format : 'raw'});
         $.ajax({
            dataType: 'json',
            type: 'POST',
            url: 'process.php',
            data: $('#form_test').serialize(),                
            success:function(data){
                if (data.success == true){
                    window.location.href="indexPlantillas.php";
                }
                else{             
                    alert("Ocurrio un error al guardar la plantilla.");
                }
            },
            error: function(data,error,errorThrown){alert(error + errorThrown);}
         });            
    }
	
	  /*$('#buttonInsert').click( function () {
          
              if($("#campoDinamico").val()!=""){
					tinyMCE.activeEditor.execCommand('mceInsertContent', true, $("#campoDinamico").val());
             }
       } );*/
    
</script>
<?php } ?>
