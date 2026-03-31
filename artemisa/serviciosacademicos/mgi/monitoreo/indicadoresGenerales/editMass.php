<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    include_once("../variables.php");
    include($rutaTemplate."template.php");
    $db = writeHeader("Editar Detalle de Indicadores",TRUE,$proyectoMonitoreo);

    include("./menu.php");
    writeMenu(0);
    
    $utils = new Utils_monitoreo();
    $action="dontProcess";

    $id = str_replace('row_','',$_REQUEST["id"]);
    $data = $utils->getDataEntity("indicadorGenerico", $id);  
    $numIndicadores = $utils->getDataNonEntity($db,"COUNT('idsiq_indicador') as num", "siq_indicador","codigoestado = '100' AND idIndicadorGenerico='".$data["idsiq_indicadorGenerico"]."'");

    //$indicadorInstitucional = $utils->getAllComplex($db,"idsiq_indicador", "siq_indicador i","codigoestado = '100' AND discriminacion='1' AND idIndicadorGenerico='".$id."'",true);
    //$indicadoresFacultades = $utils->getAllComplex($db,"idsiq_indicador,nombrefacultad", "siq_indicador i, facultad f","codigoestado = '100' AND discriminacion='2' AND idIndicadorGenerico='".$id."' AND idFacultad=codigofacultad ORDER BY nombrefacultad");
    //$indicadoresProgramas = $utils->getAllComplex($db,"idsiq_indicador,nombrecarrera", "siq_indicador i, carrera c","codigoestado = '100' AND discriminacion='3' AND idIndicadorGenerico='".$id."' AND idCarrera=codigocarrera ORDER BY nombrecarrera");


?>

        <div id="contenido">
            <h2>Editar Indicadores de Gestión</h2>
            <div id="form"> 
                <form action="save.php" method="post" id="form_test">
                        <input type="hidden" name="entity" value="indicadorGenerico" />
                        <?php
                        if($id!=""){
                            echo '<input type="hidden" name="idsiq_indicadorGenerico" value="'.$id.'">';
                        } 
                        ?>
                        <input type="hidden" name="action" value="<?php echo $action; ?>" />
                        <input type="hidden" name="action2" value="editarDetalleInd" />
                        
                        <fieldset>   
                            <legend>Información del Indicador</legend>
                            <label style="margin-left:30px;">Indicador: </label>
                            <p><?php echo $data["nombre"]; ?></p>                          
                        </fieldset>
                        
   <?php if($numIndicadores["num"]>0) { ?>                     
                        <fieldset id="indicadoresDetalle">   
                            <legend>Detalle de los Indicadores de Gestión</legend> 
                            <p style="margin-left:30px;">Se van a actualizar un total de <?php echo $numIndicadores["num"]; ?> indicadores.</p> 
                            
                            <?php if($data['idTipo']==3) { ?>
                                <label for="inexistente" id="labelInexistente" class="grid-2-12">¿Es soportado por un documento?: <span class="mandatory">(*)</span></label>
                                <?php writeYesNoSelect("inexistente",$data['inexistente']); ?>
                            <?php } else { ?>
                                 <input type="hidden" name="inexistente" value="0" />
                            <?php }   ?>

                            <label for="es_objeto_analisis" class="grid-2-12">¿Tiene documento de análisis?: <span class="mandatory">(*)</span></label>
                            <?php writeYesNoSelect("es_objeto_analisis",$data['es_objeto_analisis']); ?>

                            <label for="tiene_anexo" class="grid-2-12">¿Tiene anexo?: <span class="mandatory">(*)</span></label>
                            <?php writeYesNoSelect("tiene_anexo",$data['tiene_anexo']); ?>
                            
                        </fieldset>           
                        
                        <input type="submit" value="Actualizar indicadores en masivo" class="first small" />
<?php } else { echo "<p>No hay indicadores de gestión para editar</p>"; } ?>                        
                </form>
            </div>
        </div>

<script type="text/javascript">
    
    $(':submit').click(function(event) { 
                    event.preventDefault();                    
                        sendForm();
                });
                
                function sendForm(){
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: 'process.php',
                        data: $('#form_test').serialize(),                
                        success:function(data){
                            if (data.success == true){
                                alert("Se han editado los indicadores de gestión de forma correcta.");
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
