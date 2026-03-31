<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
 
    include_once("../variables.php");
    include($rutaTemplate."template.php");
    $db = writeHeader("Asignar Responsable a un Aspecto",TRUE,$proyectoMonitoreo);

    include("./menu.php");
    writeMenu(0);
    
    $data = array();
    $utils = new Utils_monitoreo();
    
    $edit = false;
    $relacion = array();
    if(isset($_REQUEST["idResponsable"])){
        $idR = $_REQUEST["idResponsable"];
        $edit = true;
    }
   $id = $_REQUEST["id"];
   $action = $_REQUEST["action"];
       
    if(strcmp($action,"inactivate")==0){
       $fields = array();
       $fields["idsiq_responsableAspecto"] = $id;
    
       $data = $utils->processData($_REQUEST["action"],"responsableAspecto", $fields);  
    
       $url = "detalle.php?id=".$id;
       //echo "<script>window.location.href=".$url."</script>";
       header('Location: '.$url);
       exit();
    } else if(strcmp($action,"save")==0 || strcmp($action,"update")==0){  
       $data = $utils->getDataEntity("aspecto", $id);   
       if($edit){
            $relacion = $utils->getDataEntity("responsableAspecto", $idR); 
            $user = $utils->getDataEntity("usuario", $relacion["idUsuarioResponsable"],""); 
        } 
       $tiposResponsabilidad = $utils->getActives($db,"nombre,idsiq_tipoResponsabilidad","tipoResponsabilidad");
   
?>
        
        <div id="contenido">
            <h2>Asignar Responsable a un Aspecto</h2>
            <div id="form"> 
                <div id="msg-error"></div>

                <form action="save.php" method="post" id="form_test" >
                        <input type="hidden" name="entity" value="responsableAspecto" />
                        <input type="hidden" name="action" value="<?php echo $action; ?>" />
                        <span class="mandatory">* Son campos obligatorios</span>
                        <fieldset>   
                            <legend>Información del Aspecto</legend>
                            <label class="grid-2-12">Aspecto: </label>
                            <p><?php echo $data["nombre"]; ?></p>        
                            <input type="hidden" name="idAspecto" value="<?php echo $data["idsiq_aspecto"]; ?>" />                   
                        </fieldset>
                        <fieldset>   
                            <legend>Información del Responsable</legend>
                            <label for="usuarioResponsable" class="grid-2-12">Responsable: <span class="mandatory">(*)</span></label>
                            <?php if($edit){ ?>                                
                                <p><?php echo $user["nombres"]." ".$user["apellidos"]; ?></p>        
                                <input type="hidden" name="idUsuarioResponsable" id="idUsuarioResponsable" value="<?php echo $relacion["idUsuarioResponsable"]; ?>" /> 
                                <input type="hidden" name="idsiq_responsableAspecto" value="<?php echo $relacion["idsiq_responsableAspecto"]; ?>" />
                            <?php } else { ?>
                            <input type="text"  class="grid-5-12 required" minlength="2" name="usuarioResponsable" id="usuarioResponsable" title="Nombre del Responsable" maxlength="200" tabindex="1" autocomplete="off" value=""  />
                            <input type="hidden" class="required number" name="idUsuarioResponsable" id="idUsuarioResponsable" value="" />  
                            <?php } ?>
                            
                            <label for="idTipoResponsabilidad" class="grid-2-12">Tipo de Responsabilidad: <span class="mandatory">(*)</span></label>
                            <?php
                                // idTipoResponsabilidad es el nombre del select, el data es el que esta elegido de la lista, 
                                //primer false que no se deje una opción en blanco, segundo false que no deje elegir múltiples opciones
                                //el 1 es si es un listbox o un select, 
                                echo $tiposResponsabilidad->GetMenu2('idTipoResponsabilidad',$relacion["idTipoResponsabilidad"],false,false,1,'id="idTipoResponsabilidad" class="grid-5-12"'); ?>
                        </fieldset>

                       <input type="submit" value="Asignar responsable" class="first" />
                    </form>
            </div>            
        </div>

<script type="text/javascript">
                $(':submit').click(function(event) {
                    //var buttonName = $(this).attr('name');

                    //if (buttonName.indexOf('edit') >= 0) {
                        //confirm("some text") logic...
                    //}
                    event.preventDefault();
                    var valido= validateForm("#form_test");
                    var value = $("#idUsuarioResponsable").val();
                    if( $("#idUsuarioResponsable").hasClass('required') && ($("#idUsuarioResponsable").hasClass('number') && value=="") ) {
                        $("#usuarioResponsable").addClass('error');
                        $("#usuarioResponsable").effect("pulsate", { times:3 }, 500);
                        valido=false;
                    }
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
                                <?php $url = "detalle.php?id=".$id; ?>
                                window.location.href="<?php echo $url; ?>";
                            }
                            else{                        
                                $('#msg-error').html('<p>' + data.message + '</p>');
                                $('#msg-error').addClass('msg-error');
                            }
                        },
                        error: function(data,error,errorThrown){alert(error + errorThrown);}
                    });            
                }
                
                <?php if(!$edit) { ?>
                $(document).ready(function() {
                    $('#usuarioResponsable').autocomplete({
                        source: "../lookForUsers.php",
                        minLength: 2,
                        selectFirst: false,
                        select: function( event, ui ) {
                            //alert(ui.item.id);
                            $('#idUsuarioResponsable').val(ui.item.id);
                        }                
                    });
                });
                <?php } ?>
  </script>

<?php } writeFooter(); ?>