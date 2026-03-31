<?php
function writeForm($edit, $id="") {
    $data = array();
    $action = "save";
    if($edit){
        $action = "update";
        if($id!=""){    
            $utils = new Utils_numericos();
            $data = $utils->getDataEntity("funcion", $id);            
            //var_dump($data);
           // die();
        }
    }
?>
<div id="form"> 
    <div id="msg-error"></div>
    
    <form action="save.php" method="post" id="form_test" >
            <input type="hidden" name="entity" value="funcion" />
            <input type="hidden" name="action" value="<?php echo $action; ?>" />
            <?php
            if($edit&&$id!=""){
                echo '<input type="hidden" name="idsiq_funcion" value="'.$id.'">';
            }
            ?>
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset>   
                <legend>Información de la Función</legend>
                <label for="nombre" class="grid-2-12">Nombre de la Función: <span class="mandatory">(*)</span></label>
                <input type="text"  class="grid-5-12" required   name="nombre" id="nombre" title="Nombre del Función" maxlength="120" tabindex="1" autocomplete="off" value="<?php if(!empty($edit)){ echo $data['nombre']; } ?>" />
            </fieldset>
            
            <?php if($edit){ ?><input type="submit" value="Guardar cambios" class="first" />
            <?php } else { ?><input type="submit" value="Registrar función" class="first" /> <?php } ?>
        </form>
</div>

<script type="text/javascript">
    $(':submit').click(function(event) {
        //var buttonName = $(this).attr('name');

        //if (buttonName.indexOf('edit') >= 0) {
            //confirm("some text") logic...
        //}
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
              //data[0] = "funcion" 
              //  data[1] = "lelelele" 
//                //data[2] = "todos"     
//                for (i=0;i<3;i++){ 
//   	document.write("Posición " + i + " del array: " + data[i]) 
//   	document.write("<br>") 
//        if(i=3){
//            break; 
//           document.write("Pare") 
//            }        
//                } 
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
<?php } ?>
