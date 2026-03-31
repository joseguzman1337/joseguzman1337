<?php
    include_once("../variables.php");
    include($rutaTemplate."template.php");
    $db = writeHeader("Añadir fecha de vencimiento a un indicador", TRUE,$proyectoMonitoreo);
    
    include("./menu.php");
    writeMenu(0);
    
    $monitoreo = array();
    $action = "save";
    $action2 = "save";
    $edit=false;
    $utils = new Utils_monitoreo();
    
    $id = str_replace('row_','',$_REQUEST["id"]);
        
    $indicador = $utils->getDataEntity("indicador", $id); 
      $indicadorGenerico = $utils->getDataEntity("indicadorGenerico", $indicador["idIndicadorGenerico"]); 
       $discriminacion = $utils->getDataEntity("discriminacionIndicador", $indicador["discriminacion"]);   
       $entity = array();
        if($discriminacion["idsiq_discriminacionIndicador"]==1){
            $entity["nombre"] = $discriminacion["nombre"];
        } else if($discriminacion["idsiq_discriminacionIndicador"]==2){
            $facultad = $utils->getDataNonEntity($db,"nombrefacultad","facultad","codigofacultad='".$indicador["idFacultad"]."'");
            $entity["nombre"] = $facultad["nombrefacultad"];           
        } else if($discriminacion["idsiq_discriminacionIndicador"]==3){
            $carrera = $utils->getDataNonEntity($db,"nombrecarrera","carrera","codigocarrera='".$indicador["idCarrera"]."'");
            $entity["nombre"] = $carrera["nombrecarrera"];  
        } 
    
    $data = $utils->getDataEntityJoin("relacionIndicadorMonitoreo","idIndicador",$id);  
    $tipos = $utils->getActives($db,"periodicidad,idsiq_periodicidad", "periodicidad","periodicidad");
    
    if($data["idsiq_relacionIndicadorMonitoreo"]!=""){      
        $action2 = "update";
        $monitoreo = $utils->getDataActiveEntity("monitoreo", $data["idMonitoreo"]); 
        $tipos = $utils->getAll($db,"periodicidad,idsiq_periodicidad", "periodicidad","periodicidad");
        
        if($monitoreo["idsiq_monitoreo"]!=""){       
            $action = "update";
            $edit = true;
        }
    } 

?>
 <div id="contenido">
            <h2>Gestionar Vencimiento del Indicador</h2>
            <div id="form"> 
                <form action="save.php" method="post" id="form_test">
                        <input type="hidden" name="entity" value="monitoreo" />
                        <input type="hidden" name="entity2" value="relacionIndicadorMonitoreo" />
                        <input type="hidden" name="action" value="<?php echo $action; ?>" />   
                        <input type="hidden" name="action2" value="<?php echo $action2; ?>" />          
                        <?php
                        if($edit){
                            echo '<input type="hidden" name="idsiq_monitoreo" value="'.$monitoreo["idsiq_monitoreo"].'">';
                        } if($action2=="update") {
                            echo '<input type="hidden" name="idsiq_relacionIndicadorMonitoreo" value="'.$data["idsiq_relacionIndicadorMonitoreo"].'">';                            
                        }
                        ?>
                        <span class="mandatory">* Son campos obligatorios</span>                        
                        <fieldset>   
                            <legend>Información del Indicador</legend>
                            <label class="grid-2-12">Indicador: </label>
                            <p><?php echo $indicadorGenerico["nombre"]." ( ".$entity["nombre"]." )"; ?></p>        
                            <input type="hidden" name="idIndicador" value="<?php echo $indicador["idsiq_indicador"]; ?>" />                   
                        </fieldset>
                        <fieldset>   
                            <legend>Vencimiento del Indicador</legend>
                            <label for="nombre" class="grid-2-12">Fecha de vencimiento: <span class="mandatory">(*)</span></label>
                            <input type="text"  class="grid-2-12 required" name="fecha_prox_monitoreo" id="fecha_prox_monitoreo" title="Fecha de Vencimiento" maxlength="20" tabindex="1" autocomplete="off" readonly="readonly" value="<?php if($edit){ echo $monitoreo['fecha_prox_monitoreo']; } ?>" />

                            <label for="nombre" class="grid-2-12">Periodicidad: </label>
                            <?php  echo $tipos->GetMenu2('idPeriodicidad',$monitoreo['idPeriodicidad'],true,false,1,'id="idPeriodicidad" class="grid-2-12"'); ?>
                        </fieldset>

                        <?php if($edit){ ?><input type="submit" value="Guardar cambios" class="first" /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="index.php" class="cancel">Cancelar</a>
                        <?php } else { ?><input type="submit" value="Registrar fecha de vencimiento" class="first" /> <?php } ?>
                    </form>
            </div>
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
                
                
                $(function() {
                    $( "#fecha_prox_monitoreo" ).datepicker({
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