<?php
session_start;
	include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
	
	
function writeForm($edit, $id="", $db) {
    $data = array();
    $action = "save";
    $utils = Utils::getInstance();
    $tiposDoc = $utils->getActives($db,"nombredocumento,tipodocumento","documento","nombredocumento");
    $generos = $utils->getAll($db,"nombregenero,codigogenero","genero","","nombregenero");
    if($edit){
        $action = "update";
        if($id!=""){    
            $data = $utils->getDataEntity("docenteEducacionContinuada", $id,"iddocenteEducacionContinuada");   
            $ciudad = $utils->getDataEntity("ciudad", $data["idciudadresidencia"],"idciudad");  
        }
    }

?>
<div id="form"> 
    <div id="msg-error"></div>
    
    <form action="save.php" method="post" id="form_test">
            <input type="hidden" name="entity" value="docenteEducacionContinuada" />
            <input type="hidden" name="action" value="<?php echo $action; ?>" />
            <?php
            if($edit&&$id!=""){
                echo '<input type="hidden" name="iddocenteEducacionContinuada" value="'.$id.'">';
            }
            ?>
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset>   
                <legend>Información del Docente</legend>
                <label for="apellidodocente" class="grid-2-12">Apellidos: <span class="mandatory">(*)</span></label>
                <input type="text"  class="grid-5-12 required" name="apellidodocente" id="apellidodocente" title="Apellidos del Docente" maxlength="200" tabindex="1" autocomplete="off" value="<?php if($edit){ echo $data['apellidodocente']; } ?>" />
            
                <label for="nombredocente" class="grid-2-12">Nombre(s): <span class="mandatory">(*)</span></label>
                <input type="text"  class="grid-5-12 required" minlength="2" name="nombredocente" id="nombredocente" title="nombredocente" maxlength="120" tabindex="1" autocomplete="off" value="<?php if($edit){ echo $data['nombredocente']; } ?>" />
            
                <label for="codigogenero" class="grid-2-12">Género: <span class="mandatory">(*)</span></label>
                <?php echo $generos->GetMenu2('codigogenero',$data['codigogenero'],false,false,1,'id="codigogenero" class="required"'); ?>
            
                <label for="tipodocumento" class="grid-2-12">Tipo documento: <span class="mandatory">(*)</span></label>
                <?php
                // tipodocumento es el nombre del select, el data es el que esta elegido de la lista, 
                //primer false que no se deje una opción en blanco, segundo false que no deje elegir múltiples opciones
                //el 1 es si es un listbox o un select, 
                echo $tiposDoc->GetMenu2('tipodocumento',$data['tipodocumento'],false,false,1,'id="tipodocumento" class="required"'); ?>
            
                <label for="numerodocumento" class="grid-2-12">Documento: <span class="mandatory">(*)</span></label>
                <input type="text"  class="grid-3-12 required number" minlength="2" name="numerodocumento" id="numerodocumento" title="numerodocumento" maxlength="120" tabindex="1" autocomplete="off" value="<?php if($edit){ echo $data['numerodocumento']; } ?>" />
            
                <label for="emaildocente" class="grid-2-12">E-mail: <span class="mandatory">(*)</span></label>
                <input type="text"  class="grid-5-12 required" minlength="2" name="emaildocente" id="emaildocente" title="emaildocente" maxlength="200" tabindex="1" autocomplete="off" value="<?php if($edit){ echo $data['emaildocente']; } ?>" />
            
                <label for="ciudad" class="grid-2-12">Ciudad de residencia: <span class="mandatory">(*)</span></label>
		<input type="text"  class="grid-3-12 required" minlength="2" name="ciudad" id="ciudad" title="ciudad" maxlength="150" tabindex="1" autocomplete="off" value="<?php if($edit){ echo $ciudad['nombreciudad']; } ?>" />
		<input type="hidden"  class="grid-3-12" minlength="2" name="idciudadresidencia" id="idciudadresidencia" maxlength="12" tabindex="1" autocomplete="off" value="<?php if($edit){ echo $data['idciudadresidencia']; } ?>" />
                <input type="hidden"  class="grid-3-12" minlength="2" name="tmp_ciudad" id="tmp_ciudad" value="<?php if($edit){ echo $ciudad['nombreciudad']; } ?>" />
                
				<label for="profesion" class="grid-2-12">Profesión: <span class="mandatory">(*)</span></label>
                <input type="text"  class="grid-6-12 required" minlength="2" name="profesion" id="profesion" title="profesion" maxlength="250" tabindex="1" autocomplete="off" value="<?php if($edit){ echo $data['profesion']; } ?>" />
                
				<label for="direcciondocente" class="grid-2-12">Especialidad: </label>
                <input type="text"  class="grid-6-12" minlength="2" name="especialidad" id="especialidad" title="especialidad" maxlength="250" tabindex="1" autocomplete="off" value="<?php if($edit){ echo $data['especialidad']; } ?>" />
                
                <label for="direcciondocente" class="grid-2-12">Dirección: </label>
                <input type="text"  class="grid-5-12" minlength="2" name="direcciondocente" id="direcciondocente" title="direcciondocente" maxlength="120" tabindex="1" autocomplete="off" value="<?php if($edit){ echo $data['direcciondocente']; } ?>" />
                   
                <label for="telefonoresidenciadocente" class="grid-2-12">Teléfono: </label>
                <input type="text"  class="grid-3-12 number" minlength="2" name="telefonoresidenciadocente" id="telefonoresidenciadocente" title="telefonoresidenciadocente" maxlength="120" tabindex="1" autocomplete="off" value="<?php if($edit){ echo $data['telefonoresidenciadocente']; } ?>" />
                 
                <label for="numerocelulardocente" class="grid-2-12">Celular: <span class="mandatory">(*)</span></label>
                <input type="text"  class="grid-3-12 number required" minlength="2" name="numerocelulardocente" id="numerocelulardocente" title="numerocelulardocente" maxlength="120" tabindex="1" autocomplete="off" value="<?php if($edit){ echo $data['numerocelulardocente']; } ?>" />
                
            </fieldset>
            
            <?php if($edit){ ?><input type="submit" value="Guardar cambios" class="first" />
            <?php } else { ?><input type="submit" value="Registrar docente" class="first" /> <?php } ?>
        </form>
</div>

<script type="text/javascript">
    $(':submit').click(function(event) {
        event.preventDefault();
        var valido= validateForm("#form_test");
        
        if(valido){      
            sendForm();
        }
    });
    
    function sendForm(){
         $.ajax({
            dataType: 'json',
            type: 'POST',
            url: 'process.php',
            data: $('#form_test').serialize(),                
            success:function(data){
                if (data.success == true){
                    alert(data.message);
                    window.location.href="index.php";
                }
                else{                        
                    $('#msg-error').html('<p>' + data.message + '</p>');
                    $('#msg-error').addClass('msg-error');
                }
            },
            error: function(data,error,errorThrown){alert(error + errorThrown);}
         });            
    }
    
    $(document).ready(function(){
                    $('#ciudad').autocomplete({
                        source: function( request, response ) {
                            $.ajax({
                                url: "../searches/lookForCiudades.php",
                                dataType: "json",
                                data: {
                                    term: request.term
                                },
                                success: function( data ) {
                                    response( $.map( data, function( item ) {
                                        return {
                                            label: item.label,
                                            value: item.value,
                                            id: item.id
                                        }
                                    }));
                                }
                            });
                        },
                        minLength: 2,
                        selectFirst: false,
                        open: function(event, ui) {
                            var maxWidth = $('#form_test').width()-400;  
                            var width = $(this).autocomplete("widget").width();
                            if(width>maxWidth){
                                $(".ui-autocomplete.ui-menu").width(maxWidth);                                 
                            }
                            $('#tmp_ciudad').val($('#ciudad').val());
                        },
                        select: function( event, ui ) {
                            //alert(ui.item.id);
                            if(ui.item.value=="null"){
                                event.preventDefault();
                                $('#ciudad').val($('#tmp_ciudad').val());
                            }
                            $('#idciudadresidencia').val(ui.item.id);
                        }                
                    });
                    
                });
</script>
<?php } ?>
