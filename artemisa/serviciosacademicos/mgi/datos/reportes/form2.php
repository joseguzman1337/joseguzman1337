<?php
    include("../templates/template.php");
    $text = "Crear Nuevo";
    $edit = false;
    if(isset($_REQUEST["edit"])){
        $text = "Editar";
        $edit = true;
    }
    $db = writeHeader($text." Reporte",TRUE);
    
    include("./menu.php");
    writeMenu(2);
    
    function getSelectNumbers($val=null){ ?>
        <select id="columnas" class="required" name="columnas">
            <option value="1" <?php if($val==1){ echo "selected='selected'";} ?>>1</option>
            <option value="2" <?php if($val==2){ echo "selected='selected'";} ?>>2</option>
            <option value="3" <?php if($val==3){ echo "selected='selected'";} ?>>3</option>
            <option value="4" <?php if($val==4){ echo "selected='selected'";} ?>>4</option>
            <option value="5" <?php if($val==5){ echo "selected='selected'";} ?>>5</option>
            <option value="6" <?php if($val==6){ echo "selected='selected'";} ?>>6</option>
            <option value="7" <?php if($val==7){ echo "selected='selected'";} ?>>7</option>
            <option value="8" <?php if($val==8){ echo "selected='selected'";} ?>>8</option>
            <option value="9" <?php if($val==9){ echo "selected='selected'";} ?>>9</option>
            <option value="10" <?php if($val==10){ echo "selected='selected'";} ?>>10</option>
        </select> 
    <?php }
?>
        
        <div id="contenido">
            <h2><?php echo $text; ?> Reporte - Paso 2</h2>
            <?php 
                $data = array();
                $action = "";
                $id = $_REQUEST["id"];
                $utils = new Utils_datos();
                if($id!="" && $id!=null){
                    $data = $utils->getDataEntity("reporte",$id);  
                    $action = "update";
                }
            ?>
            <div id="form"> 
                <form action="save.php" method="post" id="form_test" >
                        <input type="hidden" name="entity" value="reporte" />
                        <input type="hidden" name="action" value="<?php echo $action; ?>" />
                        <input type="hidden" name="estado_definicion_reporte" value="2" />
                        <?php
                        if($id!="" && $id!=null ){
                            echo '<input type="hidden" name="idsiq_reporte" value="'.$id.'">';
                        }
                        ?>
                        <span class="mandatory">* Son campos obligatorios</span>
                        <fieldset>   
                            <legend>Reporte</legend>
                            <?php if($data["plantilla_reporte"]!=null){ 
                                    include("./layout".$data["plantilla_reporte"].".php");
                             } else { ?>
                            
                            <?php } ?>
                        </fieldset>            
                        
                        <input type="button" value="< Anterior" class="previous" id="previous" />
                        <input type="submit" value="Siguiente >" class="next" />
                    </form>
            </div>
           
        </div>

            <script type="text/javascript">
                $("#previous").click(function() {                 
                   window.location.href="editar.php?step=1&id=row_"+<?php echo $id; ?>;
                });
                
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
                                            <?php if($edit&&$id!=""){ ?>
                                                window.location.href="form3.php?edit=1&id="+<?php echo $id; ?>;                                 
                                            <?php } else { ?>
                                                window.location.href="form3.php?id="+<?php echo $id; ?>;
                                            <?php } ?>
                                        }
                                        else{                  
                                            alert("Por favor verifique la estructura del reporte.");
                                            //$('#msg-error').html('<p>' + data.message + '</p>');
                                            //$('#msg-error').addClass('msg-error');
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

            </script>

<?php writeFooter(); ?>
