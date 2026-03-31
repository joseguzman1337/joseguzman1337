<?php

    // this starts the session 
    session_start();
	$_SESSION["colFirmas"] = $_REQUEST["cols"];
	$_SESSION["rowFirmas"] = $_REQUEST["filas"];
    
    include_once("../variables.php");
    include($rutaTemplate."template.php");
    $db = writeHeader("Asociar una firma",TRUE);
    $id = $_REQUEST["id"];
    $utils = Utils::getInstance(); 
	$action = "save";
	$dato = array();
    if($id!="" && $id!=null){          
        $edit = true;
		$action = "update";
		$dato = $utils->getDataEntityActive("detalleFirmasPlantillaCursoEducacionContinuada", $id,"iddetalleFirmasPlantillaCursoEducacionContinuada");
		$firma = $utils->getDataEntityActive("firmaEscaneadaEducacionContinuada", $dato["idFirma"],"idfirmaEscaneadaEducacionContinuada");
    }
?>

<div id="contenido">
    <div id="formAscFirma">
    <form action="process.php" method="post" id="firmaForm" name="firmaForm" >
        <input type="hidden" name="idPlantilla" id="idPlantilla" value="<?php echo $_REQUEST["idP"]; ?>" />
	<input type="hidden" name="orden" id="orden" value="<?php echo $_REQUEST["columna"]; ?>" />
	<input type="hidden" name="numFila" id="fila" value="<?php echo $_REQUEST["fila"]; ?>" />
	<input type="hidden" name="action" id="action" value="asociarFirma" />
	<input type="hidden" name="actionF" id="actionF" value="<?php echo $action; ?>" />
        <?php
            if($edit&&$id!=""){
                    echo '<input type="hidden" name="iddetalleFirmasPlantillaCursoEducacionContinuada" value="'.$id.'">';
             }
        ?>
        
        <span class="mandatory">* Son campos obligatorios</span>
        <fieldset> 
             <legend>Elegir Firma</legend>
             
             <label for="nombre" style="width:190px;">Buscar firma por nombre:</label>                 
             <input type="text"  class="grid-7-12" minlength="2" name="firmaNombre" id="firmaNombre" title="Nombre del dueño de la firma" maxlength="120" tabindex="1" autocomplete="off" value="" />             
        </fieldset>
        
        <fieldset>   
             <legend>Detalle de la firma seleccionada</legend>
             <label for="nombre" class="grid-3-12">Firma seleccionada: <span class="mandatory">(*)</span></label>
             <span id="nombreDato"><?php if($edit){ echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$firma['nombre']; } ?></span>         
             <input type="hidden" name="idFirma" id="idFirma" value="<?php if($edit){ echo $dato["idFirma"]; } ?>" class="required" /> 
             
             <div id="firmaDatos">
				<?php if($edit){ ?>
                 <!-- cargo -->
                 <label class='grid-3-12'>Cargo:</label>
				 <span style='display:inline-block;margin-top:8px;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $firma['cargo']; ?></span><div class='vacio'></div>
                 <!-- unidad -->
				 <label class='grid-3-12'>Unidad/Organización:</label>
                 <span style='display:inline-block;margin-top:4px;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $firma['unidad']; ?></span><div class='vacio'></div>
                 <!-- imagen firma de ancho 350px max -->
                 <label class='grid-3-12'>Firma:</label><img src='<?php echo $firma["ubicacionFirmaEscaneada"]; ?>' style='max-width:350px;max-height:100px;margin-left: 10px;' />
				 <?php } ?>
             </div>
                   
       </fieldset> 
        
        <?php if($edit){ ?><input type="submit" value="Guardar cambios" class="first" style="margin-left:20px" />
                <?php } else { ?><input type="submit" value="Asociar firma al certificado" class="first" style="margin-left:20px" /> <?php } ?>
    </form>
    </div>
</div>

<script type="text/javascript">
                $(':submit').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#firmaForm");
                    console.log();
                    if(valido){
                        sendForm();
                    } else {
                        alert("Debe seleccionar una firma");
                    }
                });

                function sendForm(){
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: 'process.php',
                        data: $('#firmaForm').serialize(),                
                        success:function(data){
                            if (data.success == true){
                                    window.opener.windowClose();
                                    window.close();       
                            }
                            else{      
								alert(data.message);
                                //$('#msg-error').html('<p>' + data.message + '</p>');
                                //$('#msg-error').addClass('msg-error');
                            }
                        },
                        error: function(data,error,errorThrown){alert(error + errorThrown);}
                    });            
                }     
            
            $(document).ready(function() {
                $('#firmaNombre').autocomplete({
                        source: function( request, response ) {
                            $.ajax({
                                url: "../searches/lookForFirmas.php",
                                dataType: "json",
                                data: {
                                    term: request.term,
                                    data: $("#firmaNombre").val()
                                },
                                success: function( data ) {
                                    response( $.map( data, function( item ) {
                                        return {
                                            label: item.label,
                                            value: item.value,
                                            id: item.id,
                                            unidad: item.unidad,
                                            ubicacion: item.ubicacion,
                                            cargo: item.cargo
                                        }
                                    }));
                                }
                            });
                        },
                        minLength: 2,
                        selectFirst: false,
                        open: function(event, ui) {
                            var maxWidth = $('#formAscFirma').width()-100;  
                            var width = $(this).autocomplete("widget").width();
                            if(width>maxWidth){
                                $(".ui-autocomplete.ui-menu").width(maxWidth);                                 
                            }
                        },
                        select: function( event, ui ) {
                            //alert(ui.item.id);
                            $('#nombreDato').html("&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+ui.item.value);
                            $('#idFirma').val(ui.item.id);
                            var html = "<label class='grid-3-12'>Cargo:</label><span style='display:inline-block;margin-top:8px;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+ui.item.cargo+"</span><div class='vacio'></div>";
                            html = html + "<label class='grid-3-12'>Unidad/Organización:</label><span style='display:inline-block;margin-top:4px;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+ui.item.unidad+"</span><div class='vacio'></div>";
                            html = html + "<label class='grid-3-12'>Firma:</label><img src='"+ui.item.ubicacion+"' style='max-width:350px;max-height:100px;margin-left: 10px;' />";
                            $('#firmaDatos').html(html);
                        }                
                    });
                    
                });
                
                $('#firmaNombre').bind("change", function(){
                    if($('#firmaNombre').val()==""){
                        resetData();
                    }
               });
               
               function resetData(){
                   $('#nombreDato').html("");
                   $('#idFirma').val("");
                   $('#firmaDatos').html("");            
               }               
              
  </script>

<?php writeFooter(); ?>