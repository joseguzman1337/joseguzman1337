<?php
/*
function writeForm($edit, $id="") {
    $data = array();
    $action = "save";
     $utils = new Utils_numericos();
    if($edit){
        $action = "update";
        if($id!=""){    
            $utils = new Utils_numericos();
            $funcion = $utils->getActivesFuncion($db,"nombre,idsiq_funcion","funcion");
              $indicadorGenerico = $utils->getDataEntity("indicadorGenerico", $data["idIndicadorGenerico"]); 
             $data = $utils->getDataEntity("indicador", $id); 
            //var_dump($data);
           // die();
        }
    }
*/


function writeForm($edit, $db, $id = "") {
    $data = array();
    $action = "save";
    $utils = new Utils_numericos();
    if($edit&&$id!=""){
        $data = $utils->getDataEntity("indicador", $id);      
        $indicadorGenerico = $utils->getDataEntity("indicadorGenerico", $data["idIndicadorGenerico"]); 
        $tipo = $utils->getDataEntity("tipoIndicador", $indicadorGenerico["idTipo"]); 
        $action = "update";
        $discriminacion = $utils->getDataEntity("discriminacionIndicador", $data["discriminacion"]);  
         $funcion = $utils->getActivesFuncion($db,"nombre,idsiq_funcion","funcion");
         
          $SQL_info='SELECT idsiq_funcionIndicadores FROM siq_funcionIndicadores WHERE idIndicador='.$id;

           if($info=&$db->Execute($SQL_info)===false){
                echo 'Error en Información Funcion Indicador.. <br>'.$SQL_info;
		     die;
	}
         while(!$info->EOF){
                        $idsiq_funcionIndicadores =$info->fields['idsiq_funcionIndicadores'];
                        //var_dump($idsiq_funcionIndicadores);
			$info->MoveNext();
	}
        
        $funcionIndicadores = $utils->getDataEntity("funcionIndicadores", $idsiq_funcionIndicadores); 
       //echo $funcionIndicadores['idsiq_funcion'];
        //var_dump($funcion);
        if($discriminacion["idsiq_discriminacionIndicador"]==1){
            $entity["label"] = "Tipo";
            $entity["nombre"] = $discriminacion["nombre"];
        } else if($discriminacion["idsiq_discriminacionIndicador"]==2){
            $entity["label"] = $discriminacion["nombre"];
            $facultad = $utils->getDataNonEntity($db,"nombrefacultad","facultad","codigofacultad='".$data["idFacultad"]."'");
            $entity["nombre"] = $facultad["nombrefacultad"];           
        } else if($discriminacion["idsiq_discriminacionIndicador"]==3){
            $entity["label"] = $discriminacion["nombre"];
            $carrera = $utils->getDataNonEntity($db,"nombrecarrera","carrera","codigocarrera='".$data["idCarrera"]."'");
            $entity["nombre"] = $carrera["nombrecarrera"];  
        } 
    }
?>
<div id="form"> 
    <form action="save.php" method="post" id="form_test">
            <input type="hidden" name="entity" value="funcionIndicadores" />
            <input type="hidden" name="action" value="<?php echo $action; ?>" />
            
            <?php
            if($edit&&$id!=""){
               // echo '<input type="hidden" name="idIndicador" value="'.$id.'">';
            }
            ?>
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset>   
                <legend>Información del Indicador</legend>
                <label for="nombre" class="grid-2-12">Nombre del Indicador:</label>
                <span class="inputText"><?php echo $indicadorGenerico['nombre']; ?></span>
            </fieldset>            
            <?php
            if($edit&&$id!=""){
                //echo '<input type="hidden" name="idsiq_funcion" value="'.$funcionIndicadores['idsiq_funcion'].'">';
                //$idsiq_funcionIndicadores = 66;
                echo '<input type="hidden" name="idsiq_funcionIndicadores" value="'.$idsiq_funcionIndicadores.'">';
            }
            ?>
           
            <fieldset>   
                <legend>Información de la Función</legend>
                <label for="idsiq_funcion" class="grid-2-12">Nombre de la Función: <span class="mandatory">(*)</span></label>
               <!-- <input type="text"  class="grid-5-12" required  id="nombre"  name="idsiq_funcion" title="Nombre del Función" maxlength="120" tabindex="1" autocomplete="off" value="<?php #if(!empty($edit)){ echo $funcionIndicadores['idsiq_funcion']; } ?>" /> -->
                 <?php  echo $funcion->GetMenu2('idsiq_funcion',$funcionIndicadores['idsiq_funcion'],false,false,1,'id="idsiq_funcion" class="grid-5-12"'); ?>
            </fieldset>
            
            <?php if($edit){ ?><input type="submit" value="Guardar cambios" class="first" />
            <?php } else { ?><input type="submit" value="Registrar indicador" class="first" /> <?php } ?>
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
