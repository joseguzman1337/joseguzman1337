<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
//error_reporting(E_ALL);
// ini_set("display_errors", 1);
 
   include("../../templates/templateAutoevaluacion.php");
   $db =writeHeader("Instrumento",true,"Autoevaluacion");
   
 /*  if (!empty($_REQUEST['id_instrumento'])){
    $entity = new ManagerEntity("Ainstrumentoconfiguracion");
    $entity->sql_where = "idsiq_Ainstrumentoconfiguracion = ".str_replace('row_','',$_REQUEST['id_instrumento'])."";
   //  $entity->debug = true;
    $data = $entity->getData();
    $data =$data[0];
    
    
    $entity1 = new ManagerEntity("Apublicoobjetivo");
    $entity1->sql_where = "idsiq_Ainstrumentoconfiguracion = ".str_replace('row_','',$_REQUEST['id_instrumento'])."";
   //  $entity->debug = true;
    $data1 = $entity1->getData();
    $data1 =$data1[0];
    
    
   }
   $id_in=str_replace('row_','',$_REQUEST['id_instrumento']);*/
  
?>
  

    <form action="process_file.php" method="post" id="form_test" enctype="multipart/form-data">
        <input type="hidden" name="idsiq_Apublicoobjetivo" id="idsiq_Apublicoobjetivo" value="<?php echo $_REQUEST['idsiq_Apublicoobjetivo'] ?>">
        <input type="hidden" name="entity" id="entity" value="Apublicoobjetivocsv">
        <input type="hidden" name="codigoestado" id="codigoestado" value="100" />
        <fieldset>
                <legend>Cargar Archivo</legend>
            <table border="0">
                <tr>
                    <td>
                        Descargar Plantilla ejemplo
                    </td>
                    <td>
                        <a href="../plantilla/plantilla_ejemplo.csv" target="_blank">Descargar</a>
                    </td>   
                </tr>
                <tr>
                    <td><br></td>
                </tr>

                <tr>
                    <!--<form action="process_file.php" method="post" id="form_test" enctype="multipart/form-data">   -->
                    <td>Archivo a Cargar</td>
                    <td> <input type="file" name="files" id="files" /> 
                    </td>
                    <!--</form>-->
                </tr>
                <tr>
                    <td colspan="2">
                        <br>
                        <div class="derecha">
                        <button class="submit" type="submit">Siguiente</button>
                    </div>
                    </td>
                </tr>
            </table>
            </fieldset>
</form>
<script type="text/javascript">
             /*  $(':submit').click(function(event) {
                    nicEditors.findEditor('nombre').saveContent();
                     var id=$("#id_id").val();
                     var order = $("#sortable2").sortable('toArray');
                     $("#totalsecciones").val(order);
                     var veri=$("#aprobada").val();
                    event.preventDefault();
                    var valido= validateForm("#form_test");
                   // alert(valido+'->ok')
                    if(valido){
                      if (veri==2){
                          sendForm();
                      } else{
                           var id_instrumento = $("#idsiq_Ainstrumentoconfiguracion").val();
                           $(location).attr('href','instrumento.php?id_instrumento='+id_instrumento+'&secc=1');
                      }
                   }
                });
                
                function senFormcsv(id){
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: 'process_file.php?idsiq_Apublicoobjetivo='+id+'&entity=Apublicoobjetivocsv',
                        data: $('#form_test').serialize(),                
                        success:function(data){
                            if (data.success == true){
                                alert(data.message);
                            }
                            else{                        
                                $('#msg-error').html('<p>' + data.message + '</p>');
                                $('#msg-error').addClass('msg-error');
                            }
                        },
                        error: function(data,error,errorThrown){alert(error + errorThrown);}
                    }); 
                }
                
                function sendForm(){
                     $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: 'process.php',
                        data: $('#form_test').serialize(),                
                        success:function(data){
                            if (data.success == true){
                                alert(data.message);
                                 if($("#csv1").is(':checked')) { 
                                    var caracteristicas = "height=700,width=800,scrollTo,resizable=1,scrollbars=1,location=0";
                                    window.open('cargar_archivo.php', 'Popup', caracteristicas);
                                    return false;
                                }else{
                                    alert('No hay Datos externos')
                                }
                                
                                //var id_instrumento = $("#idsiq_Ainstrumentoconfiguracion").val();
                              //  $(location).attr('href','instrumento_usuarios.php?id_instrumento='+id_instrumento+'&secc=1');
                                //$(location).attr('href','instrumento.php?id_instrumento='+id_instrumento+'&secc=1');
                            }
                            else{                        
                                $('#msg-error').html('<p>' + data.message + '</p>');
                                $('#msg-error').addClass('msg-error');
                            }
                        },
                        error: function(data,error,errorThrown){alert(error + errorThrown);}
                    }); 
             }*/
                
                
</script>
    
<?php    writeFooter();
        ?>  

