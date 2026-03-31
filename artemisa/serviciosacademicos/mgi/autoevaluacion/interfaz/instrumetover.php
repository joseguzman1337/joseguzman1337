<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
   include("../../templates/templateAutoevaluacion.php");
   $db =writeHeader("Instrumento",true,"Autoevaluacion");
  if (!empty($_REQUEST['id'])){
    $entity = new ManagerEntity("Ainstrumentover");
    $entity->sql_where = "idsiq_Ainstrumentover = ".str_replace('row_','',$_REQUEST['id'])."";
   // $entity->debug = true;
    $data = $entity->getData();
    $data =$data[0];
    //print_r($data);
  }
?>
<script type="text/javascript">
   
    bkLib.onDomLoaded(function() {
                   bkLib.onDomLoaded(nicEditors.allTextAreas);
    });


</script>
    <form action="save.php" method="post" id="form_test">
        <input type="hidden" name="idsiq_Ainstrumentover" id="idsiq_Ainstrumentover" value="<?php echo $data['idsiq_Ainstrumentover'] ?>">
        <input type="hidden" name="entity" id="entity" value="Ainstrumentover">
        <input type="hidden" name="codigoestado" id="codigoestado" value="100" />
        <div id="container">
        <div class="full_width big">Instrumento</div>
        <fieldset>
            <legend>Procesos Académicos</legend>
                <div class="demo_jui">
                    <table border="0">
                        <tbody>
                            <tr>
                                <td><label for="titulo"><span style="color:red; font-size:9px">(*)</span>Nombre:</label></td>
                                <td colspan="4">
                                    <div id="nombre1">
                                        <input type="text" name="nombre" id="nombre" value="<?php echo $data['nombre'] ?>">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="titulo">Descripcion:</label></td>
                                <td colspan="4">
                                    <div id="nombre1">
                                        <textarea style="height: 50px;" cols="90" id="descripcion" name="descripcion"><?php echo $data['descripcion']; ?></textarea>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
            </fieldset>
                        </div>
                   <div class="derecha">
                        <button class="submit" type="submit">Guardar</button>
                        &nbsp;&nbsp;
                        <a href="instrumetoverlistar.php" class="submit" >Regreso al menú</a>
                    </div><!-- End demo -->
    </div>  
  </form>
<script type="text/javascript">
      
     
                $(':submit').click(function(event) {
                   // $.trim(nicEditors.findEditor('titulo').saveContent());
                  //  nicEditors.findEditor('ayuda').saveContent();
                  //  nicEditors.findEditor('descripcion').saveContent();
                    event.preventDefault();
                        //alert($.trim(nicEditors.findEditor('titulo').getContent()));
                            //document.getElementById("nombre").innerHTML = $.trim(nicEditors.findEditor('nombre').getContent());
                            document.getElementById("descripcion").innerHTML = $.trim(nicEditors.findEditor('descripcion').getContent());
                        
                   /*      var content = $.trim(document.getElementById("nombre").innerHTML); 
                    content = $("<div/>").html(content).text();
                    var find = '<br>';
                    var re = new RegExp(find, 'g');
                    content = content.replace(re,"");
                    find = '<br/>';
                    re = new RegExp(find, 'g');
                    content = content.replace(re,"");
                    find = '<br />';
                    re = new RegExp(find, 'g');
                    content = content.replace(re,"");
                    content = $.trim(content);
                    if(content==""){                        
                              valido = false;
                    } else {       
                            valido = true;
                    }*/
                        if($("#nombre").val()=='') {
                                alert("El nombre no debe estar vacio");
                                $("#nombre").focus();
                                return false;
                        }else{
                            sendForm()
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
                                alert(data.message);
                                
                               // var tipoPreg = jQuery("select[name='idsiq_Atipopregunta'] option:selected").index();
                               // alert(data.id);
                               // $(location).attr('href','respuesta.php?id_pregunta='+data.id+'&tipo_pregunta='+tipoPreg);
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
    
<?php    writeFooter();
        ?>  

