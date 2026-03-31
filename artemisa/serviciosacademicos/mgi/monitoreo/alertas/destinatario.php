<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

    include_once("../variables.php");
    include($rutaTemplate."template.php");
    $db = writeHeader("Asignar Destinatario",TRUE,$proyectoMonitoreo);

    include("./menu.php");
    writeMenu(0);
    
    $data = array();
    $utils = new Utils_monitoreo();
    
   $id = $_REQUEST["id"];
   $action = $_REQUEST["action"];
       
    if(strcmp($action,"inactivate")==0){
       $fields = array();
       $fields["idsiq_usuarioDestinatario"] = $id;
       $data = $utils->processData($_REQUEST["action"],"usuarioDestinatario", $fields);  
       
       exit();
    } else if(strcmp($action,"save")==0){  
       $data = $utils->getDataEntity("tipoAlerta", $id);   
   
?>
        
        <div id="contenido">
            <h2>Asignar Destinatario Personalizado a Tipo de Alerta</h2>
            <div id="form"> 
                <div id="msg-error"></div>

                <form action="save.php" method="post" id="form_test" >
                        <input type="hidden" name="entity" value="usuarioDestinatario" />
                        <input type="hidden" name="action" value="<?php echo $action; ?>" />
                        <span class="mandatory">* Son campos obligatorios</span>
                        <fieldset>   
                            <legend>Información de la Alerta</legend>
                            <label class="grid-2-12">Tipo de Alerta: </label>
                            <p><?php echo $data["nombre"]; ?></p>        
                            <input type="hidden" name="idTipoAlerta" value="<?php echo $data["idsiq_tipoAlerta"]; ?>" />                   
                        </fieldset>
                        <fieldset>   
                            <legend>Información del Destinatario</legend>
                            <label for="usuarioDestinatario" class="grid-2-12">Usuario Destinatario: <span class="mandatory">(*)</span></label>
                            <input type="text"  class="grid-5-12 required" minlength="2" name="usuarioDestinatario" id="usuarioDestinatario" title="Nombre del Destinatario" maxlength="200" tabindex="1" autocomplete="off" value=""  />
                            <input type="hidden" class="required number" name="idUsuario" id="idUsuario" value="" />                             
                        </fieldset>

                       <input type="submit" value="Asignar destinatario" class="first" />
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
                    var value = $("#idUsuario").val();
                    if( $("#idUsuario").hasClass('required') && ($("#idUsuario").hasClass('number') && value=="") ) {
                        $("#usuarioDestinatario").addClass('error');
                        $("#usuarioDestinatario").effect("pulsate", { times:3 }, 500);
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
                
                $(document).ready(function() {
                    $('#usuarioDestinatario').autocomplete({
                        source: "../lookForUsers.php",
                        minLength: 2,
                        selectFirst: false,
                        select: function( event, ui ) {
                            //alert(ui.item.id);
                            $('#idUsuario').val(ui.item.id);
                        }                
                    });
                });
  </script>

<?php } writeFooter(); ?>