<?php
    // this starts the session 
    session_start();
 
    require_once("../templates/template.php");
    $db = writeHeader("Seleccionar categorías",TRUE);
    
    $_SESSION['columnas']=$_REQUEST["columnas"];
    
    $action = "save";
    $edit = false;
    $id = $_REQUEST["id"];
    $utils = new Utils_datos();
    $reporte = $utils->getDataEntity("reporte",$_REQUEST["idReporte"]);
    if($id!="" && $id!=null){  
        $data = $utils->getDataEntity("detalleReporte",$id);
        $dato = $utils->getDataEntity("data",$data["idDato"]);
         
        //var_dump($data);
        //var_dump($reporte);
        //var_dump($dato);
        //var_dump("<br/><br/>");
        $categoriasExcluidas = $utils->getDataEntityByQuery("categoriasExcluidas","idDetalleReporte",$data["idsiq_detalleReporte"]);
        $categoriasExcluidasArreglo = array();
        if($categoriasExcluidas!=NULL){
            //buscar categorías exluidas y si hay entonces si poner el edit
            $action = "update";        
            $edit = true;
            
            $categoriasExcluidasArreglo = explode(";", $categoriasExcluidas["categoriasExcluidas"]);
            //var_dump($categoriasExcluidasArreglo);
        }
        
        $catData = explode( '.', $data["filtro"]);
        $catData = $catData[count($catData)-1];
        $dataCat = $utils->getDataEntityByAlias("data",$catData);
        $cat = $utils->getDataEntity("categoriaData",$dataCat["categoria"]);
        
        //var_dump($dataCat);
        $categorias = $utils->getDataValue($db,$dataCat,$cat);  
        
        function isChecked($value){
            global $categoriasExcluidasArreglo;
            $checked = false;
            $num = count($categoriasExcluidasArreglo);
            for($i=0; $i < $num&&!$checked; $i++){
                if($value == $categoriasExcluidasArreglo[$i]){
                    $checked = true;
                }        
            }
            return $checked;
        } 
        
        
    }
?>
<div id="contenido">
      <h2 style="margin-top:0px">Seleccione las categorías que desea <b>excluir</b> del reporte</h2>
      <div id="form"> 
            <form action="save.php" method="post" id="form_test" >
                <input type="hidden" name="entity" value="categoriasExcluidas" />
                <input type="hidden" name="idDetalleReporte" value="<?php echo $data["idsiq_detalleReporte"]; ?>" />
                <input type="hidden" name="action" value="<?php echo $action; ?>" />
                
                <?php
                if($edit&&$id!=""){
                    echo '<input type="hidden" name="idsiq_categoriasExcluidas" value="'.$categoriasExcluidas["idsiq_categoriasExcluidas"].'">';
                }
                ?>
                <span class="mandatory">* Son campos obligatorios</span>
                
                <fieldset>   
                    <legend>Categorías excluidas</legend>
                    <?php $numVC = count($categorias);    

                    for($j=0; $j < $numVC; $j++) { ?>
                        <input type="checkbox" name="categorias[]" value="<?php echo $categorias[$j]["value"]; ?>" 
                            <?php if(isChecked($categorias[$j]["value"])==true){ ?>checked="true"<?php } ?>> <?php echo $categorias[$j]["label"]; ?><br/>
                     <?php } ?>
                </fieldset> 
                
                <?php if($edit){ ?><input type="submit" value="Guardar cambios" class="first" style="margin-left:20px" />
                <?php } else { ?><input type="submit" value="Excluir categorías del reporte" class="first" style="margin-left:20px" /> <?php } ?>
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
                                    window.opener.windowClose();
                                    window.close();       
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
