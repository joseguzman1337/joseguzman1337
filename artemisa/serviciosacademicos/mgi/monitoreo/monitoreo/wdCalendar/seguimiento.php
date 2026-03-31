<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    include_once("../../variables.php");
    include($rutaTemplateCalendar."template.php");
    $db = writeHeader("Registrar seguimiento para un indicador",TRUE,$proyectoMonitoreo,"../../../","dialog");
       $utils = new Utils_monitoreo();
       $api = new API_Monitoreo();
       
       if(isset($_REQUEST["id"]) && $_REQUEST["id"]!=""){
           $id = $_REQUEST["id"];
       } else {
           $rel = $api->getRelacionIndicadorMonitoreo($_REQUEST["idIndicador"]);
           if($rel==null){
               echo "<p style='margin:5px 10px;color:red'>Este indicador no tiene fecha de vencimiento asignada, por lo cual, no tiene porque hacerse un monitoreo.</p>";
               die();
           }
           $actividad = $api->getActividadActualizarActiva($rel["idMonitoreo"]);
           $id = $actividad["idsiq_actividadActualizar"];
       }
    
    $indicadorG = $utils->getDataEntity("indicadorGenerico", $_REQUEST["indicadorG"]);
    $data = $utils->getDataEntity("indicador", $_REQUEST["idIndicador"]);
    $discriminacion = $utils->getDataEntity("discriminacionIndicador", $data["discriminacion"]); 
    $nombre = $indicadorG["nombre"];
       if($discriminacion["idsiq_discriminacionIndicador"]==1){
           $nombre = $nombre." - ".$discriminacion["nombre"];
       } else if($discriminacion["idsiq_discriminacionIndicador"]==3){
           $carrera = $utils->getDataNonEntity($db,"nombrecarrera","carrera","codigocarrera='".$data["idCarrera"]."'");
           $nombre = $nombre." - ".$carrera["nombrecarrera"];  
       }   
    $action = "dontProcess";
    $realAction = "seguimiento";
    
?>
<div id="form" style="margin: 0 5px;"> 
    <form action="save.php" method="post" id="form_test">
            <input type="hidden" name="entity" value="seguimientoIndicador" />
            <input type="hidden" name="action" value="<?php echo $action; ?>" />
            <input type="hidden" name="realAction" value="<?php echo $realAction; ?>" />
    
   <fieldset>   
              <legend>Información del Indicador</legend>
              <label style="margin-left:30px;">Indicador: </label>
              <p><?php echo $nombre; ?></p>                          
    </fieldset>
     
    <fieldset>   
              <legend>Información del Seguimiento</legend>
              <label class="grid-2-12">Comentarios: <span class="mandatory">(*)</span></label>
              <textarea title="Comentario" id="comentario" name="comentario" class="grid-10-12 required"></textarea>  
              
              <label class="grid-2-12">Próximo seguimiento: </label>
              <input type="text"  class="grid-2-12" name="fecha_prox_seguimiento" id="fecha_prox_seguimiento" title="Fecha del próximo seguimiento" maxlength="20" tabindex="1" autocomplete="off" readonly="readonly" value="" />
               <input type="hidden" name="idActualizacion" value="<?php echo $id; ?>" />   
              <input type="hidden" name="idIndicador" value="<?php echo $_REQUEST["idIndicador"]; ?>" />                   
    </fieldset>    
            
     <input type="submit" value="Registrar seguimiento" class="first" /> 
     
     <button type="button" onClick="backAway()" class="cancel" style="margin-left: 15px;">Cancelar</button>
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
                                 backAway();
                            }
                            else{                        
                                $('#msg-error').html('<p>' + data.message + '</p>');
                                $('#msg-error').addClass('msg-error');
                            }
                        },
                        error: function(data,error,errorThrown){alert(error + errorThrown);}
                    });            
                }



<?php if(isset($_REQUEST["close"]) && $_REQUEST["close"]==true){ ?>
function backAway(){
        alert("Se ha hecho el seguimiento de forma exitosa.");
        window.close();
}
       <?php } else { ?>

function backAway(){
        if (document.referrer) { //alternatively, window.history.length == 0
            history.back();
            //window.open(document.referrer,'_self');
        } else {
            history.go(-1);
        }
    }
        <?php } ?>
    
                    $(function() {
                    $( "#fecha_prox_seguimiento" ).datepicker({
                        defaultDate: "+1d",
                        changeMonth: true,
                        dateFormat: "yy-mm-dd",
                        minDate: "+1d"
                        }
                    );
                    $( "#ui-datepicker-div" ).show();
                });
                
                $(document).ready(function() {
                    $('#ui-datepicker-div').hide();
                });
</script>
<?php writeFooter(); ?>