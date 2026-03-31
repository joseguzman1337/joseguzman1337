<?php
function writeForm($edit, $db, $id = "") {
    $data = array();
    $action = "save";
    $utils = new Utils_datos();
    $periodos = $utils->getPeriodosFechasReporte($db,false);
    if($edit&&$id!=""){
        $data = $utils->getDataEntity("reporte",$id);  
        $action = "update";
    }

?>
<div id="form"> 
    <form action="save.php" method="post" id="form_test" class="medium">
            <input type="hidden" name="entity" value="reporte" />
            <input type="hidden" name="action" value="<?php echo $action; ?>" />
            <input type="hidden" name="estado_definicion_reporte" value="1" />
            <?php
            if($edit&&$id!=""){
                echo '<input type="hidden" name="idsiq_reporte" value="'.$id.'">';
            }
            ?>
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset>   
                <legend>Reporte</legend>
                <label for="nombre" class="grid-2-12">Nombre: <span class="mandatory">(*)</span></label>
                <input type="text"  class="grid-7-12 required" minlength="2" name="nombre" id="nombre" title="Nombre del Reporte" maxlength="250" tabindex="1" autocomplete="off" value="<?php if($edit){ echo $data['nombre']; } ?>" />
            
                <label for="descripcion" class="grid-2-12">Descripción:</label>
                <textarea class="grid-7-12" name="descripcion" id="descripcion" maxlength="700" autocomplete="off"><?php if($edit){ echo $data['descripcion']; } ?></textarea>
                
                <div style="position:relative;top:10px;">
                                <label for="nombre" class="grid-2-12">Rango de Tiempo: <span class="mandatory">(*)</span></label>
                                <select id="opcionesFecha" name="periodoFecha">
                                <?php while($row = $periodos->FetchRow()){ ?>
                                    <option value="<?php echo $row["idsiq_periodoFechaReporte"]; ?>" <?php if(($edit&&$row["idsiq_periodoFechaReporte"]==$data['periodoFecha'])){ ?>selected="selected"<?php } ?>><?php echo $row["nombre"]; ?></option>
                                <?php  } ?>
                                    <option value="" <?php if($data['periodoFecha']==null){ ?>selected="selected"<?php } ?>>Personalizado</option>
                                </select>
                            
                                <div id="personalizado" <?php if($data['periodoFecha']!=null){ ?>style="display:none;"<?php } ?>>
                                    <select id="opcionesFechaPersonalizado">
                                        <option value="1" <?php if($data['fecha_final']==null && $data['fecha_inicial']!=null) { ?>selected="selected"<?php } ?>>Después de</option>
                                        <option value="2" <?php if($data['fecha_final']!=null && $data['fecha_inicial']==null) { ?>selected="selected"<?php } ?>>Antes de</option>
                                        <option value="3" <?php if($data['fecha_final']!=null && $data['fecha_inicial']!=null) { ?>selected="selected"<?php } ?>>Entre 2 fechas</option>
                                    </select>  
                                    
                                    <input type="text"  class="grid-2-12" name="fecha_inicial" id="fecha_inicial" title="Fecha Inicial" maxlength="20" tabindex="1" autocomplete="off" readonly="readonly" value="<?php if($id!="" && $id!=null && $data['fecha_inicial']!=null){ echo $data['fecha_inicial']; } ?>" />

                                    <input type="text"  class="grid-2-12" name="fecha_final" id="fecha_final" title="Fecha Final" maxlength="20" tabindex="1" autocomplete="off" readonly="readonly" value="<?php if($id!="" && $id!=null && $data['fecha_final']!=null){ echo $data['fecha_final']; } ?>" />
                                </div>
                            </div>
                
            </fieldset>            
            
            <input type="submit" value="Siguiente >" class="next" />
            <?php /*if($edit){ ?><input type="submit" value="Guardar cambios" class="first" />
            <?php } else { ?><input type="submit" value="Crear reporte" class="first" /> <?php }*/ ?>
        </form>
</div>

<script type="text/javascript">
    
                $(':submit').click(function(event) {
                    event.preventDefault();
                    var valido= validateForm("#form_test");
                    if($( "#opcionesFecha" ).val()==""){
                                    if($( "#opcionesFechaPersonalizado" ).val()=="1"){
                                        if($("#fecha_inicial").val()==""){
                                            valido = false;
                                            $("#fecha_inicial").addClass('error');
                                            $("#fecha_inicial").effect("pulsate", { times:3 }, 500);
                                        }
                                    } else if($( "#opcionesFechaPersonalizado" ).val()=="2"){                                        
                                        if($("#fecha_final").val()==""){
                                            valido = false;
                                            $("#fecha_final").addClass('error');
                                            $("#fecha_final").effect("pulsate", { times:3 }, 500);
                                        }
                                    } else if($( "#opcionesFechaPersonalizado" ).val()=="3"){                                         
                                        if($("#fecha_inicial").val()==""){
                                            valido = false;
                                            $("#fecha_inicial").addClass('error');
                                            $("#fecha_inicial").effect("pulsate", { times:3 }, 500);
                                        }                                
                                        if($("#fecha_final").val()==""){
                                            valido = false;
                                            $("#fecha_final").addClass('error');
                                            $("#fecha_final").effect("pulsate", { times:3 }, 500);
                                        }
                                        
                                        if(valido){
                                            d1=$("#fecha_final").val().split("-"); //año-mes-dia
                                            d2=$("#fecha_inicial").val().split("-");
                                            date1=new Date(d1[0], d1[1], d1[2]);
                                            date2=new Date(d2[0], d2[1], d2[2]);

                                            if(date1<=date2){
                                                valido = false;
                                                $("#fecha_final").addClass('error');
                                                $("#fecha_final").effect("pulsate", { times:3 }, 500);
                                                $("#fecha_inicial").addClass('error');
                                                $("#fecha_inicial").effect("pulsate", { times:3 }, 500);
                                            }
                                        }
                                    }   
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
                                 window.location.href="form4.php?edit=1&id="+<?php echo $id; ?>; 
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
                    $( "#fecha_inicial" ).datepicker({
                        defaultDate: "+1d",
                        changeMonth: true,
                        dateFormat: "yy-mm-dd",
                        minDate: "-30Y",                        
                        maxDate: '+0d'
                        }
                    );
                    $( "#fecha_final" ).datepicker({
                        defaultDate: "+1d",
                        changeMonth: true,
                        dateFormat: "yy-mm-dd",
                        minDate: "-30Y",                                               
                        maxDate: '+1Y'
                        }
                    );
                    $( "#ui-datepicker-div" ).show();
                });
                
         $(document).ready(function() {
               $('#ui-datepicker-div').hide();
               visibleDates();
          });
          
          $("#opcionesFecha").bind('change',function(){

                if($( "#opcionesFecha" ).val()==""){
                    $("#personalizado").attr('style', 'display: block;');
                } else {
                    $("#fecha_inicial").val("");
                    $("#fecha_final").val("");   
                    $("#personalizado").attr('style', 'display: none;');
                }
            });
            
            
          $("#opcionesFechaPersonalizado").bind('change',function(){
              visibleDates();
            });
            
            function visibleDates(){
                $("#fecha_inicial").removeClass('error');
                $("#fecha_final").removeClass('error');
                if($( "#opcionesFechaPersonalizado" ).val()=="1"){
                    $("#fecha_inicial").attr('style', 'display: block;');
                    $("#fecha_final").attr('style', 'display: none;');
                    $("#fecha_final").val("");                    
                } else if($( "#opcionesFechaPersonalizado" ).val()=="2"){
                    $("#fecha_inicial").attr('style', 'display: none;');
                    $("#fecha_final").attr('style', 'display: block;');
                    $("#fecha_inicial").val("");
                } else if($( "#opcionesFechaPersonalizado" ).val()=="3"){
                    $("#fecha_inicial").attr('style', 'display: block;');
                    $("#fecha_final").attr('style', 'display: block;');
                }                 
            }
            
            $("#fecha_inicial").bind('change',function(){
              $("#fecha_inicial").removeClass('error');
            });
            
            $("#fecha_final").bind('change',function(){
              $("#fecha_final").removeClass('error');
            });
  </script>
<?php } ?>
