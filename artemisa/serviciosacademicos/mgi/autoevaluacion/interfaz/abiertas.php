<?php
  include("../../templates/templateAutoevaluacion.php");
   $db =writeHeader("Respuestas",true,"Autoevaluacion");
  $id_respuesta=$_REQUEST['idsiq_Arespuesta'];
  $id_pregunta=$_REQUEST['idsiq_Apregunta'];
  $veri=$_REQUEST['verificada'];
 // echo $tipo_pregunta.'xxx';
   if (!empty($id_pregunta)){
    $entity = new ManagerEntity("Apreguntarespuesta");
     $entity->sql_where = "idsiq_Apregunta =".$id_pregunta." and codigoestado='100' ";
    //$entity->debug = true;
    $data = $entity->getData();
    $data_aux =$data[0];
   // print_r($data_aux);
       
   }

?>
<style>
  p { margin: 8px; font-size:16px; }
  .selected { color:blue; }
  .highlight { background:yellow; }
 </style>

<link rel="stylesheet" href="../../css/styleAutoevaluacion.css" />
 <form action="save.php" method="post" id="form_test">
<div id="container">   
		<div class="demo_jui">
                    <input type="hidden" name="idsiq_Apregunta" id="idsiq_Apregunta" value="<?php echo $id_pregunta ?>">
                    <input type="hidden" name="entity" id="entity" value="Apreguntarespuesta" >
                     <input type="hidden" name="idsiq_Apreguntarespuesta" id="idsiq_Apreguntarespuesta"  value="<?php echo $data_aux['idsiq_Apreguntarespuesta']; ?>" >
                    <input type="hidden" name="codigoestado" id="codigoestado" value="100" />
                      <input type="hidden" name="texto_inicio" id="texto_inicio" value="NULL" />
                      <input type="hidden" name="texto_final" id="texto_final" value="NULL" />
                      <input type="hidden" name="multiple_respuesta" id="multiple_respuesta" value="0" />
                      <input type="hidden" name="unica_respuesta" id="unica_respuesta" value="0" />
                      <input type="hidden" name="respuesta" id="respuesta" value="0" />
                       <input type="hidden" name="valor" id="valor" value="0" />
                        <input type="hidden" name="correcta" id="correcta" value="0" />
                      <input type="hidden" name="analisis" id="analisis" value="0" />
                      <input type="hidden" name="aparejamiento" id="aparejamiento" value="0" />
                      
                     
                      Máximo de caracteres:  <input type="text" name="maximo_caracteres" id="maximo_caracteres" value="<?php if(!empty($data_aux['maximo_caracteres'])){ echo $data_aux['maximo_caracteres']; }else{ echo "0"; } ?>" />
		</div>
    
	</div>
        <div class="demo">
            <?php
                if ($veri==2){
            ?>
                <button class="submit" type="submit">Guardar</button>
                <?php
                }
                ?>  
                <button class="submit" type="submit">Cancelar</button>
            </div>
 </form>
	<script type="text/javascript" src="../../js/jquery.min.js"></script>
        <script type="text/javascript" src="../../js/jquery.numeric.js"></script>
	<script>
            //var i=1;
            $(document).ready(function(){
                  $("#maximo_caracteres").numeric();
                  var i=parseInt($("#total").val());
                  //alert($("#total").val());
                    $(document).on('click','.clsAgregarFilaL',function(){
                            var strNueva_FilaL='<tr id="'+i+'">'+
                                    '<td width="80%"><input type="text" name="num['+i+']" id="num_'+i+'" style="width: 50px;border:0;text-align:right;cursor:default" value="'+(i+1)+'" readonly >'+
                                    '<input type="hidden" name="idsiq_Arespuesta1['+i+']" id="idsiq_Arespuesta1_'+i+'" style="width: 50px" ><input type="text" name="respuesta1['+i+']" id="respuesta1_'+i+'" style="width: 400px">'+
                                    '<!--</td>'+
                                    '<td>--><input type="hidden" name="valor1['+i+']" id="valor1_'+i+'" value="0" onkeypress=\'$("#valor1_'+i+'").numeric()\' ></td>'+
                                    '<td align="right"><input type="button" value="" class="button medium clsEliminarFilaL" ></td>'+
                            '</tr>';
                             i=i+1;
                             $("#total").val(i);
                            var objTabla=$(this).parents().get(3);
                            $(objTabla).find('tbody').append(strNueva_FilaL);
                            if(!$(objTabla).find('tbody').is(':visible')){
                                    $(objTabla).find('caption').click();
                                    
                            }
                    });

                    $(document).on('click','.clsEliminarFilaL',function(){
                            
                            var objCuerpo=$(this).parents().get(2);
                                    if($(objCuerpo).find('tr').length==1){
                                            if(!confirm('Esta es el única fila de la lista ¿Desea eliminarla?')){
                                                    return;
                                            }
                                    }
                            var objFila=$(this).parents().get(1);
                            var $this = $(this);
                            var $tr = $this.closest('tr');
                            var idtr=$tr.attr('id');
                            $("#valor1_"+idtr).val('0');
                            $("#num_"+idtr).attr('readonly', 'readonly');
                            $("#respuesta1_"+idtr).attr('readonly', 'readonly');
                             $("#valor1_"+idtr).attr('readonly', 'readonly');
                            $(objFila).addClass("highlight");
                            

                            // alert($tr.attr('id'));
                                   //alert($(objCuerpo).find('tr').id())
                                   
                                    //$(objFila).remove();
                    });


            });
            
             $(':submit').click(function(event) {
                    event.preventDefault();
                    if ($("#maximo_caracteres").val()==0){
                         alert("Debe minimo 1 caracter");
                         $("#maximo_caracteres").focus();
                         return false;
                    }else{
                      sendForm();
                     // alert('Proceso realizado satisfactoriamente');
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
                                total=data.id;
                                //i=0;
                                $.each(total, function(key, value) { 
                                   $("#idsiq_Arespuesta1_"+key).val(value);
                                   //i=i+1;
                                   // alert(key + ': ' + value); 
                                });

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
