<?php
error_reporting(E_ALL);
ini_set('display_errors', '0');

   include("../templates/templateObservatorio.php");
   $db =writeHeader("Tipo <br> Riesgos",true,"PAE",1);
   
    if (!empty($_REQUEST['id'])){
    $entity = new ManagerEntity("tipocausas");
    $entity->sql_where = "idobs_tipocausas= ".str_replace('row_','',$_REQUEST['id'])." and codigoestado=100 ";
    //$entity->debug = true;
    $data = $entity->getData();
    $data =$data[0];
    //print_r($data);
  }
  
?>
    <script type="text/javascript">
    
	$(document).ready(function(){
 		$('#tabs').smartTab({autoProgress: false,stopOnFocus:true,transitionEffect:'vSlide'});
        });  
        
    
    </script>
    
    <form action="save.php" method="post" id="form_test">
         <input type="hidden" name="entity" id="entity" value="tipocausas">
        <input type="hidden" name="codigoestado" id="codigoestado" value="100" />
        <input type="hidden" name="idobs_tipocausas" id="idobs_tipocausas" value="<?php echo $data['idobs_tipocausas'] ?>">
        <div id="container" style="margin-left: 70px;">
        <div id="tabs">
                <ul>
                <li ><div class="stepNumber">1</div><a href="#tabs-1"><span class="stepDesc">Datos<br />Riesgo</span></a></li>
                </ul>
               <div id="tabs-1">
                      <table border="0"  class="CSSTableGenerator">
                        <tbody>
                            <tr>
                                <td><label class="titulo_label"><span style="color:red; font-size:9px">(*)</span>Nombre:</label></td>
                                <td colspan="4">
                                    <input type="text" name="nombretipocausas" id="nombretipocausas" title="Nombre" maxlength="120" placeholder="Nombre" tabindex="1" value="<?php echo $data['nombretipocausas']?>" />
                                </td>
                            </tr>
                            <tr>
                                <td><label class="titulo_label">Descripci&oacute;n:</label></td>
                                <td colspan="4">
                                    <div id="nombre1">
                                        <textarea style="height: 50px;" cols="90" id="descripciontipocausas" tabindex="2" name="descripciontipocausas"><?php echo $data['descripciontipocausas']; ?></textarea>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table> 
               </div>
                
         </div>
         <div class="derecha">
            <button class="submit" type="submit" tabindex="3">Guardar</button>
            &nbsp;&nbsp;
            <a href="listar_tipocausas.php" class="submit" tabindex="4">Regreso al menú</a>
        </div><!-- End demo -->
            
   </div>
   
  </form>
<script type="text/javascript">
      
     
                $(':submit').click(function(event) {
                    event.preventDefault();
                     if(validar()){  
                        sendForm()
                     } 
                });
                
                function validar(){
                   if($.trim($("#nombretipocausas").val())=='') {
                                alert("Debe digitar el nombre");
                                $('#nombretipocausas').css('border-color','#F00');
                                $('#nombretipocausas').effect("pulsate", {times:3}, 500);
                                $("#nombretipocausas").focus();
                                return false;
                        }else{
                            return true;
                        }     
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
                                $(location).attr('href','listar_tipocausas.php');
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

