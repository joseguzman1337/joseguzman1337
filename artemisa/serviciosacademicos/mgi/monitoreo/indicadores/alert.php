<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION); 
    
    include_once("../variables.php");
    include($rutaTemplate."template.php");
    $db = writeHeader("Editar Definición de un Indicador",TRUE,$proyectoMonitoreo);

    include("./menu.php");
    writeMenu(4);
    
    $utils = new Utils_monitoreo();
    $action="dontProcess";
    $action2 = "asignarAlerta";
    $id = null;
    $monitoreo = array();
    $data = array();
    if(isset($_REQUEST["id"])){
        $id = str_replace('row_','',$_REQUEST["id"]);
        $action2 = "editarAlerta";
        
        $data = $utils->getDataEntity("alertaPeriodica", $id);  
        if($data['idMonitoreo']!=null){
            $monitoreo = $utils->getDataNonEntity($db,"idsiq_relacionIndicadorMonitoreo,idIndicador", "siq_relacionIndicadorMonitoreo", "idsiq_relacionIndicadorMonitoreo='".$data['idMonitoreo']."' AND codigoestado='100'"); 

            $indicador = $utils->getDataEntity("indicador", $monitoreo["idIndicador"]);   
                $indicadorGenerico = $utils->getDataEntity("indicadorGenerico", $indicador["idIndicadorGenerico"]); 
                $discriminacion = $utils->getDataEntity("discriminacionIndicador", $indicador["discriminacion"]); 
            if($discriminacion["idsiq_discriminacionIndicador"]==1){
                $nombre = $indicadorGenerico["nombre"]." (".$discriminacion["nombre"].")";
            } else if($discriminacion["idsiq_discriminacionIndicador"]==3){
                $carrera = $utils->getDataNonEntity($db,"nombrecarrera","carrera","codigocarrera='".$indicador["idCarrera"]."'");
                $nombre = $indicadorGenerico["nombre"]." (". $carrera["nombrecarrera"].")";  
            }         
       } else {
           $nombre = "Todos los indicadores";
       }
    }

    $tiposAlertas = $utils->getActives($db,"nombre,idsiq_tipoAlerta", "tipoAlerta","","ASC");
    $tiposPeriodicidades = $utils->getAllComplex($db,"periodicidad,idsiq_periodicidad", "siq_periodicidad","codigoestado = '100' AND aplica_alerta = '1' ORDER BY periodicidad");

?>

<div id="contenido">
            <?php if($id==null){ ?>
            <h2>Asignar Alerta</h2>
            <?php } else { echo "<h2>Editar Alerta</h2>"; } ?>
            <div id="form"> 
                <form action="save.php" method="post" id="form_test">
                        <input type="hidden" name="entity" value="indicador" />
                        <input type="hidden" name="action" value="<?php echo $action; ?>" />
                        <input type="hidden" name="action2" value="<?php echo $action2; ?>" />
                                  
                        <fieldset>   
                            <legend>Información de la Alerta</legend>
                            <label style="margin-left:20px;text-align:right;width:100px;">Alerta: <span class="mandatory">(*)</span></label>
                            <?php  echo $tiposAlertas->GetMenu2('idAlerta',$data["idTipoAlerta"],false,false,1,'id="idAlerta" class="grid-8-12"'); ?>   
                            <label style="margin-left:20px;text-align:right;width:100px;">Periodicidad: <span class="mandatory">(*)</span></label>         
                            <?php  echo $tiposPeriodicidades->GetMenu2('idPeriodicidad',$data["idPeriodicidad"],false,false,1,'id="idPeriodicidad" class="grid-4-12"'); ?>      
                        </fieldset>
                        
                        <fieldset id="indicadoresDetalle">   
                            <legend>Información del Indicador</legend>
                            <?php if($id==null){ ?>
                            <input type="checkbox" name="indicadores" id="indicadores-all" value="1" /> Todos los indicadores<br/>
                            <?php } ?>
                            
                            <label style="clear:both;margin-left:20px;margin-top:10px;text-align:right;width:100px;" class="mandatoryFlexible">Indicador: <span class="mandatory mandatoryFlexible">(*)</span></label>
                            <?php if($id==null){ ?>
                            <textarea class="grid-9-12 smaller required mandatoryFlexible" style="margin-top:10px;" name="nombreGenerico" id="nombreGenerico" title="Nombre del Indicador" tabindex="1" autocomplete="off" ></textarea>                     
                            <?php } else { echo "<p style='margin-top:10px;' class='grid-9-12'>".$nombre."</p>"; ?> <input type="hidden" name="idsiq_alertaPeriodica" value="<?php echo $id; ?>" /> <?php } ?>
                            <input type="hidden" class="grid-5-12 required" name="idsiq_monitoreo" id="idsiq_monitoreo" maxlength="250" tabindex="1" autocomplete="off" value="<?php echo $monitoreo["idsiq_relacionIndicadorMonitoreo"]; ?>" />
                        </fieldset>       
                        
                        <input type="submit" value="Asignar alerta" class="first small" />
                </form>
            </div>
        </div>

<script type="text/javascript"> 
    
    $(function() {
        $( "#indicadores-all" ).click(function() {
            if($(this).is(":checked")){
                $(".mandatoryFlexible").addClass('hidden');
                $("#nombreGenerico").removeClass('required');
                $("#idsiq_monitoreo").removeClass('required');
            } else {
                $(".mandatoryFlexible").removeClass('hidden');
                $("#nombreGenerico").addClass('required');
                $("#idsiq_monitoreo").addClass('required');
            }
        });
    });
    
    $(document).ready(function() {
                    $('#nombreGenerico').autocomplete({
                        source: function( request, response ) {
                            //console.log("aja ey");
                            $.ajax({
                                url: "../searchs/lookForIndicadorDetalle.php",
                                dataType: "json",
                                data: {
                                    term: request.term,
                                    monitoreo: true
                                },
                                success: function( data ) {
                                    response( $.map( data, function( item ) {
                                        return {
                                            label: item.label,
                                            value: item.value,
                                            id: item.id,
                                            idrelacion: item.idrelacion,
                                            idmonitoreo: item.idmonitoreo
                                        }
                                    }));
                                }
                            });
                        },
                        minLength: 2,
                        selectFirst: false,
                        open: function(event, ui) {
                            var maxWidth = $('#form_test').width()-110;  
                            var width = $(this).autocomplete("widget").width();
                            if(width>maxWidth){
                                $(".ui-autocomplete.ui-menu").width(maxWidth);                                 
                            }
                        },
                        select: function( event, ui ) {
                            //alert(ui.item.id);
                            //$('#idIndicador').val(ui.item.id);
                            if(ui.item.idrelacion!=false){
                                //$('#fecha_prox_monitoreo').val(ui.item.fecha);
                                //$('#idPeriodicidad').val(ui.item.periodicidad);
                                //$('#idsiq_relacionIndicadorMonitoreo').val(ui.item.idrelacion);
                                $('#idsiq_monitoreo').val(ui.item.idrelacion);
                            }
                        }                
                    });
                });
    
    $(':submit').click(function(event) { 
                    event.preventDefault();
                    var valido= validateForm("#form_test");
                    var checked = $("#indicadoresDetalle input:checked").length > 0;
                    if (checked || (!checked && valido)){                      
                        sendForm();
                    }  else {
                        alert("Debe elegir un indicador al cual asignar la alerta.");
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
                                 window.location.href="indexAlertas.php";
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
