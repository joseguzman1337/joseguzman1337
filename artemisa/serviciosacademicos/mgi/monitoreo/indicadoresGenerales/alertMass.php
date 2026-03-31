<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

    include_once("../variables.php");
    include($rutaTemplate."template.php");
    $db = writeHeader("Editar Definición de un Indicador",TRUE,$proyectoMonitoreo);

    include("./menu.php");
    writeMenu(0);
    
    $utils = new Utils_monitoreo();
    $action="dontProcess";

    $id = str_replace('row_','',$_REQUEST["id"]);
    $data = $utils->getDataEntity("indicadorGenerico", $id);  
    $disc = $utils->getActives($db,"nombre,idsiq_discriminacionIndicador", "discriminacionIndicador","","ASC","siq_",true);
    $indicadorInstitucional = $utils->getAllComplex($db,"idsiq_indicador", "siq_indicador i","codigoestado = '100' AND discriminacion='1' AND idIndicadorGenerico='".$id."'",true);    
    $indicadoresProgramas = $utils->getAllComplex($db,"idsiq_indicador,nombrecarrera", "siq_indicador i, carrera c","codigoestado = '100' AND discriminacion='3' AND idIndicadorGenerico='".$id."' AND idCarrera=codigocarrera ORDER BY nombrecarrera");
    $tiposAlertas = $utils->getActives($db,"nombre,idsiq_tipoAlerta", "tipoAlerta","","ASC");
    $tiposPeriodicidades = $utils->getAllComplex($db,"periodicidad,idsiq_periodicidad", "siq_periodicidad","codigoestado = '100' AND aplica_alerta = '1' ORDER BY periodicidad");

?>

<div id="contenido">
            <h2>Asignar Alerta a Indicadores de Gestión</h2>
            <div id="form"> 
                <form action="save.php" method="post" id="form_test">
                        <input type="hidden" name="entity" value="indicador" />
                        <input type="hidden" name="action" value="<?php echo $action; ?>" />
                        <input type="hidden" name="action2" value="asignarAlerta" />
                        
                        <fieldset>   
                            <legend>Información del Indicador</legend>
                            <label style="margin-left:30px;">Indicador: </label>
                            <p><?php echo $data["nombre"]; ?></p>                          
                        </fieldset>
                        
                        
                        <fieldset id="indicadoresDetalle">   
                            <legend>Información de Indicadores de Gestión</legend> 
                                                    
                            <p style="float:right;margin-right:30px;width:450px;"><em>Nota: Los indicadores deshabilitados no tienen fecha de vencimiento asignada por lo cual no se
                                        les puede asignar una alerta.</em></p>
                            
                            <input type="checkbox" name="indicador" id="indicadores-all" value="si" /> Seleccionar todos<br/>
                            <?php if(count($indicadorInstitucional)>0){ 
                                  $monitoreo = $utils->getDataNonEntity($db,"idsiq_relacionIndicadorMonitoreo", "siq_relacionIndicadorMonitoreo", "idIndicador='".$indicadorInstitucional["0"]['idsiq_indicador']."' AND codigoestado='100'");   ?>
                                <h4 class="toggler" style="margin-top:10px;">Ver Indicador <?php echo $disc["0"]["nombre"]; ?></h4>
                                <div class="toggle" style="display: none;">
                                    <p>
                                    <input type="checkbox" name="indicadores[]" value="<?php echo $monitoreo['idsiq_relacionIndicadorMonitoreo']; ?>" <?php if(count($monitoreo)==0){ echo "disabled='true'";} ?> /> <?php echo $disc["0"]["nombre"]; ?><br/>
                                    </p>
                                </div>
                            <?php } ?>
                            <?php if($indicadoresProgramas->_numOfRows>0){ ?>    
                                <h4 class="toggler">Ver Indicadores <?php echo $disc["1"]["nombre"]; ?></h4>
                                <div class="toggle" style="display: none;">
                                    <p><?php 
                                    while($row = $indicadoresProgramas->FetchRow()){ 
                                        $monitoreo = $utils->getDataNonEntity($db,"idsiq_relacionIndicadorMonitoreo", "siq_relacionIndicadorMonitoreo", "idIndicador='".$row['idsiq_indicador']."' AND codigoestado='100'");                                          
                                    ?>
                                    <input type="checkbox" name="indicadores[]" value="<?php echo $monitoreo['idsiq_relacionIndicadorMonitoreo']; ?>" <?php if(count($monitoreo)==0){ echo "disabled='true'";} ?>/> <?php echo $row['nombrecarrera']; ?><br/>
                                    <?php } ?></p>
                                </div>
                            <?php } ?> 
                        </fieldset>  
                        
                        <fieldset>   
                            <legend>Información de la Alerta</legend>
                            <label style="margin-left:20px;text-align:right;width:100px;">Alerta: <span class="mandatory">(*)</span></label>
                            <?php  echo $tiposAlertas->GetMenu2('idAlerta',null,false,false,1,'id="idAlerta" class="grid-8-12"'); ?>   
                            <label style="margin-left:20px;text-align:right;width:100px;">Periodicidad: <span class="mandatory">(*)</span></label>         
                            <?php  echo $tiposPeriodicidades->GetMenu2('idPeriodicidad',null,false,false,1,'id="idPeriodicidad" class="grid-4-12"'); ?>      
                        </fieldset>
                        
                        <input type="submit" value="Asignar alerta a indicadores seleccionados" class="first small" />
                </form>
            </div>
        </div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#indicadoresDetalle h4').each(function() {
            var tis = $(this), state = true, answer = tis.next('div').slideUp();
            tis.click(function() {
                state = !state;
                answer.slideToggle(state);
                tis.toggleClass('active',state);
            });
        });
    });    
    
    $(function() {
        $( "#indicadores-all" ).click(function() {
            if($(this).is(":checked")){
                $('#indicadoresDetalle input:checkbox:not(:disabled)').attr('checked','checked');
            } else {
                $('#indicadoresDetalle input:checkbox').removeAttr('checked');
            }
        });
    });
    
    $(':submit').click(function(event) { 
                    event.preventDefault();
                    //var valido= validateForm("#form_test");
                   var checked = $("#indicadoresDetalle input:checked").length > 0;
                    if (checked){                      
                        sendForm();
                    }  else {
                        alert("Debe seleccionar al menos 1 indicador para inactivar.");
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
                                 alert("La alerta se ha asignado de forma exitosa");
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

</script>

<?php writeFooter(); ?>
