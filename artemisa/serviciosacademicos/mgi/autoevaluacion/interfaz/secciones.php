<?php
   include("../../templates/templateAutoevaluacion.php");
   $db =writeHeader("Secciones",true,"Autoevaluacion");
   if(isset($_REQUEST['cat_ins'])){
        $cat_ins=$_REQUEST['cat_ins'];
   } else {
       $cat_ins="MGI";
   }
		$carrera = 1;
		$nombrecarrera="";
       if($cat_ins=="EDOCENTES"&&$_SESSION["codigofacultad"]!=1&&$_SESSION["codigofacultad"]!=156 ){
			$carrera = $_SESSION["codigofacultad"];
			$nombrecarrera = " - ".$_SESSION["nombrefacultad"];
	   } 
  if (!empty($_REQUEST['id'])){
    $entity = new ManagerEntity("Aseccion");
    $entity->sql_where = "idsiq_Aseccion = ".str_replace('row_','',$_REQUEST['id'])."";
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
        <input type="hidden" name="idsiq_Aseccion" id="idsiq_Aseccion" value="<?php echo $data['idsiq_Aseccion'] ?>">
        <input type="hidden" name="entity" id="entity" value="Aseccion">
        <input type="hidden" name="codigoestado" id="codigoestado" value="100" />
        <input type="hidden" name="cat_ins" id="cat_ins" value="<?php echo $cat_ins ?>" />
        <input type="hidden" name="codigocarrera" id="codigocarrera" value="<?php echo $carrera ?>" />
        <div id="container">
        <div class="full_width big">Secciones</div>
        <fieldset>
            <legend>Creaci&oacute;n de Secciones<?php echo $nombrecarrera; ?></legend>
                <div class="demo_jui">
                    <table border="0">
                        <tbody>
                            <tr>
                                <td><label for="titulo"><span style="color:red; font-size:9px">(*)</span>Nombre:</label></td>
                                <td colspan="4">
                                    <div id="nombre1">
                                        <textarea style="height: 50px;" cols="90" id="nombre" name="nombre"><?php echo $data['nombre']; ?></textarea>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="titulo">Descripción:</label></td>
                                <td colspan="4">
                                    <div id="nombre1">
                                        <textarea style="height: 50px;" cols="90" id="descripcion" name="descripcion"><?php echo $data['descripcion']; ?></textarea>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                   <label for="titulo">Sin Sección:</label> 
                                </td>
                                <td>
                                    <input type="checkbox" name="sin_seccion" id="sin_seccion" tabindex="6" title="sin_seccion" value="1" <?php if($data['sin_seccion']==1) echo "checked"; ?>  />
                                </td>
                            </tr>
                        </tbody>
                    </table>
            </fieldset>
                        </div>
                   <div class="derecha">
                        <button class="submit" type="submit">Guardar</button>
                        &nbsp;&nbsp;
                        <a href="seccioneslistar.php?cat_ins=<?php echo $cat_ins ?>" class="submit" >Regreso al men&uacute;</a>
                    </div><!-- End demo -->
    </div>  
  </form>
<script type="text/javascript">
       function trim(str) {
                return str.replace(/^\s+|\s+$/g,"");
        }
     
                $(':submit').click(function(event) {
                   // $.trim(nicEditors.findEditor('titulo').saveContent());
                  //  nicEditors.findEditor('ayuda').saveContent();
                  //  nicEditors.findEditor('descripcion').saveContent();
                    event.preventDefault();
                        //alert($.trim(nicEditors.findEditor('titulo').getContent()));
                            document.getElementById("nombre").innerHTML = $.trim(nicEditors.findEditor('nombre').getContent());
                            document.getElementById("descripcion").innerHTML = $.trim(nicEditors.findEditor('descripcion').getContent());
                        
                    var content = $.trim(document.getElementById("nombre").innerHTML); 
                    content = $("<div/>").html(content).text();
                    //alert(content)
                    var find = '<br>';
                    var re = new RegExp(find, 'g');
                    content = content.replace(re,"");
                    find = '<br/>';
                    re = new RegExp(find, 'g');
                    content = content.replace(re,"");
                    find = '<br />';
                    re = new RegExp(find, 'g');
                    content = content.replace(re,"\\");
                    find = ' ';
                    re = new RegExp(find, 'g');
                    content = content.replace(re,"");
                    find = '';
                    re = new RegExp(find, 'g');
                    content = content.replace(re,"");
                    find = '<br />';
                    re = new RegExp(find, 'g');
                    content = content.replace(re,"");
                    content = $.trim(content);
                    //alert(content+'zzz')
                    if(content==""){                        
                              valido = false;
                    } else {       
                            valido = true;
                    }
                        if($("#nombre").val()=='<br>') {
                                alert("El nombre no debe estar vacio");
                                $("#nombre").focus();
                                return false;
                        }else if(valido==false) {
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
                               $(location).attr('href','seccioneslistar.php?cat_ins=<?php echo $cat_ins; ?>');
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

