<?php

session_start;
	include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
	
	include_once(realpath(dirname(__FILE__))."/../variables.php");
    include($rutaTemplate."template.php");
    $db = writeHeader("Imprimir Documentos Educación Continuada",TRUE);
    
    $utils = Utils::getInstance();

?>

	<div id="contenido">
        <h4>Imprimir Documentos Educación Continuada</h4>
         <form action="save.php" method="post" id="form_test" name="myform">
                 <span class="mandatory">* Son campos obligatorios</span>
                    <fieldset>  
                        <legend>Información del estudiante</legend>
                        <label for="nombre" class="grid-2-12">Número de documento: <span class="mandatory">(*)</span></label>
                        <input type="text" class="grid-2-12 required" id="documento" minlength="1" name="documento" maxlength="15" tabindex="1" autocomplete="off" value="" />
               
                        <input type="button" id="buscarCursos" value="Consultar" class="first small" />
                        
                        <div class="vacio"></div>
                        <div id="respuesta"></div>
                    </fieldset>
                 
                 <div id="boton" style="display:none;"><input type="submit" value="Generar PDF" class="first submitButton" /></div>
         </form>
        </div>
    </div>  
<script type="text/javascript">
       $(':submit').click(function(event) {
            event.preventDefault();
            var valido= validateForm("#form_test");
            /*
            if(valido){ 
                var estudiante = $("#documento").val();
                var grupo= $("#grupo").val();
                popup_carga('../certificados/imprimirPDF.php?grupo='+grupo+'&estudiante='+estudiante+'&duplicado=1');  
            }
            */
           if(valido){
               var estudiante = $("#documento").val();
               var grupo= $("#grupo").val();
               var ver = "";
               <?php if(!$utils->esAdministrador($db,$_SESSION['MM_Username'])) { ?>
                   ver = "&ver=1";
               <?php } ?>
               popup_carga("../certificados/imprimirPlantilla.php?id="+$("#plantilla").val()+'&estudiante='+estudiante+'&grupo='+grupo+ver);
           }
        });   
        
        $('#buscarCursos').click(function() {
                if($("#documento").val()!=""){
                        $.ajax({
                            dataType: 'json',
                            type: 'POST',
                            url: '../searches/consultarCursosEstudiante.php',
                            data: { documento: $("#documento").val() },                
                            success:function(data){
                                $('#respuesta').html(data.html);
                                if(data.button){
                                    $('#boton').attr('style', 'display:block;');
                                } else {
                                    $('#boton').attr('style', 'display:none;');
                                }
                            },
                            error: function(data,error,errorThrown){alert(error + errorThrown);}
                        }); 
                } else {
                    alert("Debe introducir el número de documento del estudiante.");
                }
        });

</script>
<?php writeFooter(); ?>
