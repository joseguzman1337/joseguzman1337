<?php
    include("../templates/template.php");
    $text = "Crear Nuevo";
    $edit = false;
    if(isset($_REQUEST["edit"])){
        $text = "Editar";
    }
    $db = writeHeader($text." Reporte",TRUE);
    
    include("./menu.php");
    writeMenu(2);
    
?>
   <link rel="stylesheet" href="../../css/jquery.tooltip.css" />
    <script type="text/javascript" language="javascript" src="../../js/jquery.tooltip.js"></script>     
        <div id="contenido">
            <h2><?php echo $text; ?> Reporte - Paso 3</h2>
            <?php 
                $data = array();
                $action = "";
                $id = $_REQUEST["id"];
                $utils = new Utils_datos();
                $graficas = $utils->getGraficasReporte($db,false);
                $periodos = $utils->getPeriodosFechasReporte($db,false);
                if($id!="" && $id!=null){
                    $data = $utils->getDataEntity("reporte",$id);  
                    $action = "update";                    
                    $edit = true;
                }
            ?>
            <div id="form"> 
                <form action="save.php" method="post" id="form_test" >
                        <input type="hidden" name="entity" value="reporte" />
                        <input type="hidden" name="action" value="<?php echo $action; ?>" />
                        <input type="hidden" name="estado_definicion_reporte" value="3" />
                        <?php
                        if($id!="" && $id!=null ){
                            echo '<input type="hidden" name="idsiq_reporte" value="'.$id.'">';
                        }
                        ?>
                        <span class="mandatory">* Son campos obligatorios</span>
                        <fieldset>   
                            <legend>Reporte</legend>
                            
                            <label for="grafica" style="margin-bottom:10px;margin-right:10px;width:210px;">¿Debe generar alguna gráfica?</label>
                            
                            <div class="box graficas">
                                <div class="radioGroup"><input type="radio" name="tipo_grafica" value="NULL" <?php if(!$edit || ($edit&&$data['tipo_grafica']==NULL)){ ?>checked<?php } ?>> Ninguna</div>
                            <?php $contador=1; while($row = $graficas->FetchRow()){ ?>
                                <div class="radioGroup"><input type="radio" name="tipo_grafica" value="<?php echo $row["idsiq_graficaReporte"]; ?>" <?php if(($edit&&$row["idsiq_graficaReporte"]==$data['tipo_grafica'])){ ?>checked<?php } ?> > 
                                    <?php echo $row["nombre"]; ?> <a href="#imagen<?php echo $contador; ?>" style="display:inline-block;margin-left:0px;text-decoration:none" id="buttonHelp<?php echo $contador; ?>"><img src="../../images/help.png" name="image" width="16" height="16" alt="ver imagen de ejemplo" /></a>
                                </div>    
                                    <div id="imagen<?php echo $contador; ?>" style="display:none;">
                                                <img src="../../images/<?php echo $row["nombre_imagen"]; ?>" alt="<?php echo $row["nombre"]; ?>" width="500">
                                        </div>
                                    <script type="text/javascript">
                                        $('#buttonHelp<?php echo $contador; ?>').tooltip({ 
                                            delay: 0, 
                                            showURL: false, 
                                            bodyHandler: function() {                         
                                                return $($(this).attr("href")).html();
                                            } 
                                        });
                                    </script> 
                                
                                <!---<img src="../../images/<?php //echo $row["nombre_imagen"]; ?>" alt="<?php //echo $row["nombre"]; ?>" width="400"><br/>
                                <div id="dialog-imagen<?php //echo $contador; ?>" title="Seleccionar Programas">
                                    <img src="../../images/<?php //echo $row["nombre_imagen"]; ?>" alt="<?php //echo $row["nombre"]; ?>" width="400">
                                </div>-->
                            <?php  $contador = $contador + 1;} ?>
                            </div>
                            
                            <div style="position:relative;top:10px;">
                                <label for="nombre"  style="margin-bottom:10px;width:210px;">Rango de Tiempo: <span class="mandatory">(*)</span></label>
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
                        
                        <input type="button" value="< Anterior" class="previous" id="previous" />
                        <input type="submit" value="Siguiente >" class="next" />
                        <?php /*if($edit){ ?><input type="submit" value="Guardar cambios" class="first" />
                        <?php } else { ?><input type="submit" value="Crear reporte" class="first" /> <?php }*/ ?>
                    </form>
            </div>
           
        </div>

            <script type="text/javascript">
                $("#previous").click(function() {
                    var paso2 = true;
                    <?php if($data["plantilla_reporte"]==0){ ?>
                        paso2 = false;
                    <?php } ?>
                    
                    if(paso2){                    
                        window.location.href="editar.php?step=2&id=row_"+<?php echo $id; ?>;
                    } else {
                        window.location.href="editar.php?step=1&id=row_"+<?php echo $id; ?>;
                    }                    
                });
                
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
                                            <?php if($edit&&$id!=""){ ?>
                                                window.location.href="form4.php?edit=1&id="+<?php echo $id; ?>;                                 
                                            <?php } else { ?>
                                                window.location.href="form4.php?id="+<?php echo $id; ?>;
                                            <?php } ?>
                                        }
                                        else{                        
                                            $('#msg-error').html('<p>' + data.message + '</p>');
                                            $('#msg-error').addClass('msg-error');
                                        }
                                    },
                                    error: function(data,error,errorThrown){alert(error + errorThrown);}
                                });            
                            }
                            
     function popup_carga(url){        
        
            var centerWidth = (window.screen.width - 850) / 2;
            var centerHeight = (window.screen.height - 700) / 2;
    
          var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=850, height=700, top="+centerHeight+", left="+centerWidth;
          var mypopup = window.open(url,"",opciones);
          //Para que me refresque la página apenas se cierre el popup
          //mypopup.onunload = windowClose;​
          
          //para poner la ventana en frente
          window.focus();
          mypopup.focus();
          
          //Para saber cuando me cierran el popup, que me recargue la ventana con los botones
          //var timer = setInterval(function() {   
          //      if(mypopup.closed) {  
          //          clearInterval(timer);  
                    //alert('closed');  
          //          windowClose();
          //      }  
          //}, 400);  
          
      }
      
      function windowClose() {
            window.location.reload();
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

<?php writeFooter(); ?>
