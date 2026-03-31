<?php
//error_reporting(E_ALL);
//ini_set("display_errors", 1);

//include("../../ReportesAuditoria/templates/mainjson.php");
//include("../../ReportesAuditoria/templates/MenuReportes.php");

include('../templates/templateObservatorio.php');
$db=writeHeader('Metas Admisiones',true,'Admisiones',1,'Metas admisiones');

 include("funciones.php");
 $fun = new Observatorio();
 $roles=$fun->roles_permi($db,$_SESSION['MM_Username'],'Metas admisiones'); 

$sql_dat="select * from obs_metas_admisiones where idobs_metas_admisiones= ".str_replace('row_','',$_REQUEST['id'])." ";
$reg_dat =$db->Execute($sql_dat);
//print_r($reg_dat);
//$perio=$reg_dat->codigoperiodo;
$dis='';
foreach($reg_dat as $pr){
  $perio=$pr['codigoperiodo'];
  $modalidad=$pr['codigomodalidadacademica'];
  $dis="disabled";
}

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
               jQuery("select[name='codigomodalidadacademica']").change(function(){displayCarrera4();});                 
               jQuery("select[name='codigoperiodo']").change(function(){displayCarrera4();});  
    });
   
    /*bkLib.onDomLoaded(function() {
                   bkLib.onDomLoaded(nicEditors.allTextAreas);
    });*/

</script>
    <form action="save.php" method="post" id="form_test">
        <input type="hidden" name="idobs_metas_admisiones" id="idobs_metas_admisiones" value="<?php echo $data['idobs_metas_admisiones'] ?>">
        <input type="hidden" name="entity" id="entity" value="metas_admisiones">
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
                                             $query_tipo_periodo = "SELECT '' as nombreperiodo, '' as codigoperiodo UNION SELECT nombreperiodo, codigoperiodo FROM periodo where codigoperiodo>='20061' order by codigoperiodo desc";
                                             $reg_tipoper = $db->Execute ($query_tipo_periodo);
                                             echo $reg_tipoper->GetMenu2('codigoperiodo',$perio,false,false,1,' '.$dis.' tabindex="17" id="codigoperiodo" ');
                                        ?>
                                   </td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                     <div  id="carreraAjax" style="display: none;"> 
                                    
                                     </div>
                                <div  id="carreraAjax2" > 
                                <?php
                                if (!empty($perio)){
                                    $query_programa = "SELECT ma.idobs_metas_admisiones, m.nombremodalidadacademica, c.nombrecarrera, 
                                                    ma.meta, ma.codigoperiodo, ma.codigoestado, ma.fechacreacion
                                                    FROM obs_metas_admisiones as ma
                                                    inner join modalidadacademica as m on (m.codigomodalidadacademica=ma.codigomodalidadacademica)
                                                    inner join carrera as c on (c.codigocarrera=ma.codigocarrera)
                                                    where ma.codigoperiodo='".$perio."' ";
                                    $data_in =$db->Execute($query_programa);
                                ?>
                                    <table border="0" width="100%" class="CSSTableGenerator">
                                    <tr>
                                        <td><center><b>PROGRAMAS</b></center></td>
                                        <td><center><b>METAS</b></center></td>
                                    </tr>
                                    <?php
                                        $j=0;
                                        foreach($data_in as $dt){
                                             $nombre=$dt['nombrecarrera'];
                                             $cod=$dt['codigocarrera'];
                                             $meta=$dt['meta'];
                                             $idobs=$dt['idobs_metas_admisiones'];
                                            ?>
                                                <tr>
                                                    <td><input type="hidden" name="idobs_metas_admisiones1[]" id="idobs_metas_admisiones1_<?php echo $j ?>" value="<?php echo $idobs ?>" />
                                                        <input type="hidden" name="codigocarrera1[]" id="codigocarrera1_<?php echo $j ?>" value="<?php echo $cod ?>" /><?php echo  $nombre; ?></td>
                                                    <td><input type="text" name="meta1[]" id="meta1_<?php echo $j ?>" class="numeric" title="Meta" maxlength="5" placeholder="Meta" tabindex="1" value="<?php echo  $meta; ?>" /></td>
                                                </tr>
                                            <?php
                                            $j++;
                                        }
                                    ?>
                                </table>   
                                     <?php
                                     }
                                 ?>
                                </div>
                            </td>
                            </tr>
                            <tr>
                                <td colspan="4">
                                      <!-- <div class="derecha">-->
                                      <?php if ($roles['editar']==1){?>
                                            <button class="submit" type="submit" tabindex="3">Guardar</button>
                                      <?php } ?>
                                            &nbsp;&nbsp;
                                            <a href="listar_metas_admisiones.php" class="submit" tabindex="4">Regreso al menú</a>
                                       <!-- </div><!-- End demo -->
                                </td>
                            </tr>    
                        </tbody>
                    </table>
            </div>                    
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
                        }else{
                            return true;
                        }     
                }
                
                function sendForm(){
                     $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: 'process_metas.php',
                        data: $('#form_test').serialize(),                
                        success:function(data){
                            if (data.success == true){
                                alert(data.message);
                                $(location).attr('href','listar_metas_admisiones.php');
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

