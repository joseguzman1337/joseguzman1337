<?php
error_reporting(E_ALL);
ini_set('display_errors', '0');

   include("../templates/templateObservatorio.php");
   $db =writeHeader("Observatorio",true,"PAE");
   
   if (!empty($_REQUEST['id'])){
    $entity = new ManagerEntity("causas");
    $entity->sql_where = "idobs_causas= ".str_replace('row_','',$_REQUEST['id'])."";
   // $entity->debug = true;
    $data = $entity->getData();
    $data =$data[0];
    //print_r($data);
  }
  
?>
    <script type="text/javascript">
    
	$(document).ready(function(){
 		$('#tabs').smartTab({
                    selected: 0,
                    autoHeight:true,
                    autoProgress: false,
                    stopOnFocus:true,
                    transitionEffect:'vSlide'})
        });  
        
    
    </script>
    
    <form action="save.php" method="post" id="form_test">
         <input type="hidden" name="entity" id="entity" value="causas">
        <input type="hidden" name="codigoestado" id="codigoestado" value="100" />
        <input type="hidden" name="idobs_causas" id="idobs_causas" value="<?php echo $data['idobs_causas'] ?>">
        <div id="container" style="margin-left: 70px;">
        <div id="tabs">
                <ul>
                <li ><div class="stepNumber">1</div><a href="#tabs-1"><span class="stepDesc">Tipo<br />Riesgo</span></a></li>
                <li ><div class="stepNumber">2</div><a href="#tabs-2"><span class="stepDesc">Datos<br />Riesgo</span></a></li>
                </ul>
                <div id="tabs-1">
                    <table border="0" width="100%" class="CSSTableGenerator">
                        <tr>
                            <td><label class="titulo_label"><span style="color:red; font-size:9px">(*)</span>Tipo:</label></td>
                            <td><?php 
                                   $query_dec = "SELECT nombretipocausas, idobs_tipocausas FROM obs_tipocausas  where codigoestado='100' ";
                                   $reg_dec =$db->Execute($query_dec);
                                   echo $reg_dec->GetMenu2('idobs_tipocausas', $data['idobs_tipocausas'], true,false,1,' id="idobs_tipocausas"  style="width:150px;"');
                            ?></td>
                        </tr>
                    </table>
                    <br>
                    <br>
                </div>
              <div id="tabs-2">
                      <table border="0"  class="CSSTableGenerator">
                        <tbody>
                            <tr>
                                <td><label class="titulo_label"><span style="color:red; font-size:9px">(*)</span>Nombre:</label></td>
                                <td colspan="4">
                                    <input type="text" name="nombrecausas" id="nombrecausas" title="Nombre" maxlength="120" placeholder="Nombre" tabindex="1" value="<?php echo $data['nombrecausas']?>" />
                                </td>
                            </tr>
                            <tr>
                                <td><label class="titulo_label">Descripci&oacute;n:</label></td>
                                <td colspan="4">
                                    <div id="nombre1">
                                        <textarea style="height: 50px;" cols="90" id="descripcioncausas" tabindex="2" name="descripcioncausas"><?php echo $data['descripcioncausas']; ?></textarea>
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
            <a href="listar_causas.php" class="submit" tabindex="4">Regreso al menú</a>
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
                    if($.trim($("#idobs_tipocausas").val())=='') {
                                alert("Debe escoger el tipo de causa");
                                $('#idobs_tipocausas').css('border-color','#F00');
                                $('#idobs_tipocausas').effect("pulsate", {times:3}, 500);
                                $("#idobs_tipocausas").focus();
                                return false;
                        }else if($.trim($("#nombrecausas").val())=='') {
                                alert("Debe digitar el nombre");
                                $('#nombrecausas').css('border-color','#F00');
                                $('#nombrecausas').effect("pulsate", {times:3}, 500);
                                $("#nombrecausas").focus();
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
                                $(location).attr('href','listar_causas.php');
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

