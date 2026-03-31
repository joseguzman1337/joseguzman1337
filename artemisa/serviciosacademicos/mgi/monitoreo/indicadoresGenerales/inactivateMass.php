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
    //$indicadoresFacultades = $utils->getAllComplex($db,"idsiq_indicador,nombrefacultad", "siq_indicador i, facultad f","codigoestado = '100' AND discriminacion='2' AND idIndicadorGenerico='".$id."' AND idFacultad=codigofacultad ORDER BY nombrefacultad");
    $indicadoresProgramas = $utils->getAllComplex($db,"idsiq_indicador,nombrecarrera", "siq_indicador i, carrera c","codigoestado = '100' AND discriminacion='3' AND idIndicadorGenerico='".$id."' AND idCarrera=codigocarrera ORDER BY nombrecarrera");


?>
        <div id="contenido">
            <h2>Inactivar Indicadores de Gestión</h2>
            <div id="form"> 
                <form action="save.php" method="post" id="form_test">
                        <input type="hidden" name="entity" value="indicador" />
                        <input type="hidden" name="action" value="<?php echo $action; ?>" />
                        
                        <fieldset>   
                            <legend>Información del Indicador</legend>
                            <label style="margin-left:30px;">Indicador: </label>
                            <p><?php echo $data["nombre"]; ?></p>                          
                        </fieldset>
                        
                        
                        <fieldset id="indicadoresDetalle">   
                            <legend>Información de Indicadores de Gestión</legend> 
                            <?php if(count($indicadorInstitucional)>0){ ?>
                                <h4 class="toggler">Ver Indicador <?php echo $disc["0"]["nombre"]; ?></h4>
                                <div class="toggle" style="display: none;">
                                    <p>
                                    <input type="checkbox" name="indicadores[]" value="<?php echo $indicadorInstitucional["0"]['idsiq_indicador']; ?>" /> <?php echo $disc["0"]["nombre"]; ?><br/>
                                    </p>
                                </div>
                            <?php } ?>
                            <?php /*if($indicadoresFacultades->_numOfRows>0){ ?>
                                <h4 class="toggler">Ver Indicadores <?php echo $disc["1"]["nombre"]; ?></h4>
                                <div class="toggle" style="display: none;">
                                    <p><?php 
                                    while($row = $indicadoresFacultades->FetchRow()){ 
                                    ?>
                                    <input type="checkbox" name="indicadores[]" value="<?php echo $row['idsiq_indicador']; ?>" /> <?php echo $row['nombrefacultad']; ?><br/>
                                    <?php } ?></p>
                                </div>
                            <?php }*/ ?>
                            <?php if($indicadoresProgramas->_numOfRows>0){ ?>    
                                <h4 class="toggler">Ver Indicadores <?php echo $disc["1"]["nombre"]; ?></h4>
                                <div class="toggle" style="display: none;">
                                    <p><?php 
                                    while($row = $indicadoresProgramas->FetchRow()){ 
                                    ?>
                                    <input type="checkbox" name="indicadores[]" value="<?php echo $row['idsiq_indicador']; ?>" /> <?php echo $row['nombrecarrera']; ?><br/>
                                    <?php } ?></p>
                                </div>
                            <?php } ?>  
                        </fieldset>           
                        
                        <input type="submit" value="Inactivar indicadores seleccionados" class="first small" />
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
