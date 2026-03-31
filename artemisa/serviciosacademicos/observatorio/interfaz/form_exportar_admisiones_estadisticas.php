<?php
//error_reporting(E_ALL);
//ini_set("display_errors", 1);

//include("../../ReportesAuditoria/templates/mainjson.php");
//include("../../ReportesAuditoria/templates/MenuReportes.php");

include('../templates/templateObservatorio.php');
//require_once('../ManagerEntity.php');
 /* if (!empty($_REQUEST['id'])){
    $entity = new ManagerEntity("metas_admisiones");
    $entity->sql_where = "idobs_metas_admisiones= ".str_replace('row_','',$_REQUEST['id'])."";
    $entity->debug = true;
    $data = $entity->getData();
    $data =$data[0];
    //print_r($data);
  }*/
$db=writeHeader('Exportar <br> Admisiones',true,'Admisiones',1);

?>
<style>
    #customers th {
    background-color: #A7C942;
    color: #FFFFFF;
    font-size: 1.4em;
    padding-bottom: 4px;
    padding-top: 5px;
    text-align: left;
}
#customers td, #customers th {
    border: 1px solid #98BF21;
    font-size: 1.2em;
    padding: 3px 7px 2px;
}
</style>
<script type="text/javascript">
  
   $(document).ready(function(){ 
               //$(".numeric").numeric();
               jQuery("select[name='codigomodalidadacademica']").change(function(){displayCarrera();});  
               jQuery("select[name='codigoperiodo']").change(function(){displayCarrera();}); 
   
               
     });
   
    

 function displayCarrera(){
        var ajaxLoader = "<img src='../img/ajax-loader.gif' alt='loading...' />";           
        var optionValue = jQuery("select[name='codigomodalidadacademica']").val(); 
        //alert(optionValue);
        if (optionValue==200){
            jQuery("#pregrado").css('display', '');     
            jQuery("#postgrado").css('display', 'none');  
        }else{
             jQuery("#pregrado").css('display', 'none');     
            jQuery("#postgrado").css('display', '');  
        }    
        

            
    }    

</script>
     <form action="process_metas_export.php" method="post" id="form_test" enctype="multipart/form-data">
        <input type="hidden" name="entity" id="entity" value="admisiones_estadisticas">
        <input type="hidden" name="codigoestado" id="codigoestado" value="100" />
        <div id="container" style="margin-left: 70px;">
            <div id="tabs">
                    <table border="0" width="100%" class="CSSTableGenerator">
                        <tbody>
                            <tr>
                                <td><label class="titulo_label"><span style="color:red; font-size:9px">(*)</span>Modalidad Acad&eacute;mica:</label></td>
                                <td>
                                    <?php
                                        $query_programa = "SELECT '' as nombremodalidadacademica, '' as codigomodalidadacademica UNION SELECT nombremodalidadacademica, codigomodalidadacademica FROM modalidadacademica where codigomodalidadacademica in (200,300)";
                                        $reg_programa =$db->Execute($query_programa);
                                        echo $reg_programa->GetMenu2('codigomodalidadacademica',$modalidad,false,false,1,' id="codigomodalidadacademica"  style="width:295px;"');
                                 ?>
                                </td>
                                <td><label class="titulo_label"><span style="color:red; font-size:9px">(*)</span>Periodo Acad&eacute;mico:</label> </td>
                                    <td><?php
                                             $query_tipo_periodo = "SELECT nombreperiodo, codigoperiodo FROM periodo order by codigoperiodo desc";
                                             $reg_tipoper = $db->Execute ($query_tipo_periodo);
                                             echo $reg_tipoper->GetMenu2('codigoperiodo',$perio,false,false,1,'  tabindex="17" id="codigoperiodo" ');
                                        ?>
                                   </td>
                            </tr>
                            <tr>
                                <td><label class="titulo_label">Plantilla:</label></td>
                                <td colspan="3">
                                    <div id="pregrado" style=" display: none">
                                        <a href="../plantillas/admisiones_estadisticas.cvs" target="_blank">Descargar</a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><label class="titulo_label">Subir Archivo Plano (.csv)</label></td>
                                <td colspan="3">
                                    <div>
                                        <input type="file" name="archivos[]" id="archivos"  />
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                       <div id="cargados">
                                        <!-- Aqui van los archivos cargados -->
                                      </div>
                                </td>
                            </tr>
                        <tr>
                                <td colspan="4">
                                      <button class="submit" type="submit" tabindex="3">Guardar</button>
                                        &nbsp;&nbsp;
                                        <a href="listar_admisiones_estadisticas.php" class="submit" tabindex="4">Regreso al men&uacute;</a>  
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
  </form>
<script type="text/javascript">
      
     
                $(':submit').click(function(event) {
                    event.preventDefault();
                   // document.getElementById("descripcion").innerHTML = $.trim(nicEditors.findEditor('descripcion').getContent());
                     if(validar()){  
                        sendForm()
                     } 
                });
                
                function validar(){
                    
                    var i=0
                      if($.trim($("#codigomodalidadacademica").val())=='') {
                            alert('Indique la modalidad academico ');
                            $('#codigomodalidadacademica').css('border-color','#F00');
                            $('#codigomodalidadacademica').effect("pulsate", {times:3}, 500);
                             return false;
                        }else if($.trim($("#codigoperiodo").val())=='') {
                            alert('Indique el periodo');
                            $('#codigoperiodo').css('border-color','#F00');
                            $('#codigoperiodo').effect("pulsate", {times:3}, 500);
                             return false;
                        }else if($.trim($("#archivos").val())=='') {
                            alert('Suba un archivo plano');
                            $('#archivos').css('border-color','#F00');
                            $('#archivos').effect("pulsate", {times:3}, 500);
                             return false;
                        }else{
                            return true;
                        }     
                }
                
                function sendForm(){
                     var archivos = document.getElementById("archivos");//Damos el valor del input tipo file
                    var archivo = archivos.files; //Obtenemos el valor del input (los arcchivos) en modo de arreglo
                    //El objeto FormData nos permite crear un formulario pasandole clave/valor para poder enviarlo, este tipo de objeto ya tiene la propiedad multipart/form-data para poder subir archivos
                    var data = new FormData();
                    //Como no sabemos cuantos archivos subira el usuario, iteramos la variable y al
                    //objeto de FormData con el metodo "append" le pasamos calve/valor, usamos el indice "i" para
                    //que no se repita, si no lo usamos solo tendra el valor de la ultima iteracion
                    for(i=0; i<archivo.length; i++){
                      data.append('archivo'+i,archivo[i]);
                    }
                    var periodo=jQuery("select[name='codigoperiodo']").val(); 
                    var modalidad=jQuery("select[name='codigomodalidadacademica']").val(); 
                     var tabla=$("#entity").val();
                     var estado=$("#codigoestado").val();
                    data.append('periodo',periodo);
                    data.append('modalidad',modalidad);
                    data.append('entity',tabla);
                    data.append('estado',estado);
                     $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        contentType:false,
                        url: 'process_metas_export_admisiones.php',
                        data: data,
                        processData:false,
                        cache:false,
                        success:function(data){
                            if (data.success == true){
                                alert(data.message);
                                $(location).attr('href','listar_admisiones_estadisticas.php');
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

