<?php
//error_reporting(E_ALL);
//ini_set("display_errors", 1);

include('../templates/templateObservatorio.php');
$db=writeHeader('Estadisticas <br> Admisiones',true,'Admisiones',1);
  $fec='';
  if (!empty($_REQUEST['id'])){
    $entity = new ManagerEntity("admisiones_estadisticas");
    $entity->sql_where = "idobs_admisiones_estadisticas=".str_replace('row_','',$_REQUEST['id'])."";
    //$entity->debug = true;
    $data = $entity->getData();
    $data =$data[0];
    $fec=$data['fecha_crear'];
   // print_r($data);
  }
  
  if (empty($fec)){
      $fec=date('Y-m-d');
  }
  


?>
<style type="text/css">
.botonExcel{cursor:pointer;}
</style>
<script type="text/javascript" src="../js/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
  
   $(document).ready(function(){  
             // jQuery("select[name='codigomodalidadacademica']").change(function(){displayCarreraM();}); 
             //  jQuery("select[name='codigoperiodo']").change(function(){displayCarreraM();}); 
               var idd=$("#idobs_admisiones_estadisticas1").val() 
               if (idd!=''){
                   displayCarreraM();
               }
                
                
    });


   
  

 function displayCarreraM(){
        var ajaxLoader = "<img src='../img/ajax-loader.gif' alt='loading...' />";           
        var optionValue = jQuery("select[name='codigomodalidadacademica']").val();
        var optionPeriodo = jQuery("select[name='codigoperiodo']").val();
        var fecha1=$("#fecha").val();
        //alert(fecha1)
          
                          
        if (optionValue!='' && optionPeriodo!=''){
            $('#carreraAjax2').html('<blink>Cargando...</blink>');
            $('#carreraAjax').html('<blink>Cargando...</blink>');
            jQuery("#carreraAjax")
                .load('generacarreramatriz.php', {id: optionValue, periodo:optionPeriodo, status: 1, fecha:fecha1}, function(response){					
                    if(response) {
                        jQuery("#carreraAjax").css('display', '');     
                        jQuery("#carreraAjax2").css('display', 'none');                    
                    } else {                    
                        jQuery("#carreraAjax").css('display', 'none'); 
                        jQuery("#carreraAjax2").css('display', '');                    
                    }
                });    
        }else{
         alert('Falta un dato para la busqueda, por favor seleccione la modalidad el periodo'); 
        }
    } 
    
    
   
</script>
<style>
 #customers1 th {
    border: 1px solid #98BF21;
    color: #ffffff;
    background-color: #339900;
    font-weight: bold;
}
#customers1 {
    border-collapse: collapse;
    font-family: "Trebuchet MS",Arial,Helvetica,sans-serif;
    font-size: 11px;
}
 #customers1 td {
    border: 1px solid #98BF21;
}
</style>
    <form action="ficheroExcel.php" method="post" id="form_test">
        <input type="hidden" name="idobs_admisiones_estadisticas1" id="idobs_admisiones_estadisticas1" value="<?php echo $data['idobs_admisiones_estadisticas'] ?>">
         <input type="hidden" name="entity" id="entity" value="admisiones_estadisticas">
        <input type="hidden" name="codigoestado" id="codigoestado" value="100" />
        <input type="hidden" name="fecha" id="fecha" value="<?php echo $fec ?>" /> 
        <div id="container" style="margin-left: 70px;">
            <div id="tabs" style=" width: 1200px">
                    <table border="0"  class="CSSTableGenerator">
                        <tbody>
                        
                            <tr>
                                <td><label class="titulo_label"><span style="color:red; font-size:9px">(*)</span>Modalidad Academica:</label></td>
                                <td>
                                    <?php
                                        $query_programa = "SELECT '' as nombremodalidadacademica, '' as codigomodalidadacademica UNION SELECT nombremodalidadacademica, codigomodalidadacademica FROM modalidadacademica where codigomodalidadacademica in (200,300)";
                                        $reg_programa =$db->Execute($query_programa);
                                        echo $reg_programa->GetMenu2('codigomodalidadacademica',$data['codigomodalidadacademica'],false,false,1,' id="codigomodalidadacademica"  style="width:150px;"');
                                 ?>
                                </td>
                                <td><label class="titulo_label">Periodo Académico:</label> </td>
                                    <td><?php
                                             $query_tipo_periodo = "SELECT nombreperiodo, codigoperiodo FROM periodo order by codigoperiodo desc";
                                             $reg_tipoper = $db->Execute ($query_tipo_periodo);
                                             echo $reg_tipoper->GetMenu2('codigoperiodo',$data['codigoperiodo'],false,false,1,' tabindex="17" id="codigoperiodo" ');
                                        ?>
                                   </td>
                                   <td><button class="submit" type="button" tabindex="3" onclick="displayCarreraM()">Buscar</button></td>
                            </tr>
                           </tbody>
                    </table>
                <br>
            
                         <div  id="carreraAjax" style="display: none; "> 

                          </div>
                          <div  id="carreraAjax2" >

                           </div>
                  <table border="0" >
                        <tbody>
                            <tr>
                                <td colspan="4">
                                    <br><br>
                                   <!--  <button class="submit" type="submit" tabindex="3">Guardar</button>-->
                                    &nbsp;&nbsp;
                                    <a href="listar_causas_psicosociales.php" class="submit" tabindex="4">Regreso al menú</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
            </div><!-- End demo -->
    </div>  
  </form>
<script type="text/javascript">
      
     
                $(':submit').click(function(event) {
                    event.preventDefault();
                   // document.getElementById("descripcion").innerHTML = $.trim(nicEditors.findEditor('descripcion').getContent());
                    // if(validar()){  
                        sendForm()
                     //} 
                });
                
                function validar(){
                    if($.trim($("#codigoperiodo").val())=='') {
                                alert("El periodo no debe estar vacio");
                                $("#codigoperiodo").focus();
                                return false;
                        }else if($.trim($("#modalidadacademica").val())=='') {
                                alert("La modalidad academica no debe estar vacio");
                                $("#modalidadacademica").focus();
                                return false;
                        }else{
                            return true;
                        }     
                }
                
                function sendForm(){
                     $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: 'process_admisiones.php',
                        data: $('#form_test').serialize(),                
                        success:function(data){
                            if (data.success == true){
                                alert(data.message);
                                //$(location).attr('href','listar_causas_psicosociales.php');
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

