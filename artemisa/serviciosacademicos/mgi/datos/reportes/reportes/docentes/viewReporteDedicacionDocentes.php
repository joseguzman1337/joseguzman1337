<?php


/*ini_set('display_errors', 'On');
error_reporting(E_ALL);*/


    /*require_once("../../../templates/template.php");
    $db = getBD();
    $utils = new Utils_datos();
    
    $usuario_con=$_SESSION['MM_Username'];
    if($utils->UsuarioAprueba_FormHuerfana($db,$usuario_con)){
    $aprobacion=true;
    }*/
?>

<div id="tabs-12">
<form action="save.php" method="post" id="form_actividadesAcademicos">
            <input type="hidden" name="entity" id="entity" value="formUnidadesAcademicasActividadesAcademicos" />
            <input type="hidden" name="action" value="saveDynamic2" id="action" />
            <input type="hidden" name="actividad" value="2" id="actividad" />
            <input type="hidden" name="idsiq_formUnidadesAcademicasActividadesAcademicos" value="" id="idsiq_formUnidadesAcademicasActividadesAcademicos" />
            
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset id="numPersonas">   
                <legend>Dedicación de los Académicos por actividades</legend>              
                <div class="vacio"></div>
                <label for="nombre" class="fixedLabel">Semestre: <span class="mandatory">(*)</span></label>
                <?php $utils->getSemestresSelect($db,"codigoperiodo");  
                      //$sectores = $utils->getActives($db,"siq_tipoActividadAcademicos","nombre");
                    $categoriasPadres = $utils->getAll($db,"siq_tipoActividadAcademicos","actividadPadre=0 AND codigoestado=100","nombre"); 
                ?>
                
                <?php //$utils->pintarBotonCargar("popup_cargarDocumento(9,16,$('#form_actividadesAcademicos #codigoperiodo').val(),$('#form_actividadesAcademicos #unidadAcademica').val())","popup_verDocumentos(9,16,$('#form_actividadesAcademicos #codigoperiodo').val(),$('#form_actividadesAcademicos #unidadAcademica').val())"); ?>
                                
                <table align="center" class="formData last" width="92%" >
                    <thead>            
                        <tr class="dataColumns">
                            <th class="column" colspan="<?php if($aprobacion) echo "5"; else echo "4";?>"><span>Dedicación de los Académicos por actividades</span></th>                                    
                        </tr>
                        <tr class="dataColumns category">
                            <th class="column borderR" colspan="2"><span>Clase De Actividades</span></th> 
                            <th class="column "><span>Horas Semanales</span></th> 
                            <th class="column borderR"><span>Tiempos completos equivalentes</span></th>
                            <?php if($aprobacion) { ?>
                            <th class="column"><span>Aprobar</span></th> 
                            <?php } ?>
                        </tr>
                     </thead>
                     <tbody>
                         <?php while ($rowC = $categoriasPadres->FetchRow()) { 
                                $first = true;
                                $categorias = $utils->getAll($db,"siq_tipoActividadAcademicos","actividadPadre=".$rowC["idsiq_tipoActividadAcademicos"]." AND codigoestado=100","nombre"); 
                                while ($row = $categorias->FetchRow()) { 
                             ?>
                                <tr class="dataColumns">
                                    <?php if($first){ $first = false; ?>
                                        <td class="column borderR" rowspan="<?php echo $categorias->RecordCount(); ?>" > 
                                            <?php echo $rowC["nombre"]; ?>
                                        </td>
                                    <?php } ?>
                                    <td class="column borderR"><?php echo $row["nombre"]; ?> 
                                        <input type="hidden"  class="grid-3-12 required number" minlength="1" name="idCategory[]" id="idCategory_<?php echo $row["idsiq_tipoActividadAcademicos"]; ?>" value="<?php echo $row["idsiq_tipoActividadAcademicos"]; ?>" />
                                        <input type="hidden" name="idsiq_detalleformUnidadesAcademicasActividadesAcademicos[]" value="" id="idsiq_detalleformUnidadesAcademicasActividadesAcademicos_<?php echo $row["idsiq_tipoActividadAcademicos"]; ?>" />

                                    </td>
                                    <td class="column clear" id="numHoras_<?php echo $row["idsiq_tipoActividadAcademicos"]; ?>" style="text-align: center;"></td>
                                    <td class="column borderR clear" id="numAcademicosTCE_<?php echo $row["idsiq_tipoActividadAcademicos"]; ?>" style="text-align: center;"></td>
                                    <?php if($aprobacion){ ?>
				    <td class="column">
					<input type="hidden" value="0" name="Verificado[]" id="VerEscondido_<?php echo $row["idsiq_tipoActividadAcademicos"]; ?>" />
					<input type="checkbox"  class="grid-4-12 required number" minlength="1" name="Verificado[]" id="Verificado_<?php echo $row["idsiq_tipoActividadAcademicos"]; ?>" title="Verificado" maxlength="10" tabindex="1" autocomplete="off" value="1" />
				    </td>
				    <?php 
				    }
				    ?> 
                                </tr>
                        <?php } } ?>        
                    </tbody>
                </table>                   
                
                <div class="vacio"></div>
                <div id="msg-success" class="msg-success" style="display:none"><p>Los datos han sido guardados de forma correcta.</p></div>
            </fieldset>
            
            
        </form>
</div>

<script type="text/javascript">

var aprobacion = '<?php echo $aprobacion; ?>';
    getDataActividadesAcademicos("#form_actividadesAcademicos");
    
    function calculo(Nh,NhTCE){
      var nH1=parseFloat($("#"+Nh).val());
      var nHTCE=nH1/40;
      $("#"+NhTCE).val(nHTCE)
      
    }
        
                
                $('#form_actividadesAcademicos #codigoperiodo').bind('change', function(event) {
                    getDataActividadesAcademicos("#form_actividadesAcademicos");
                });
                
                
                
                
                
                function getDataActividadesAcademicos(formName){
                    var periodo = $(formName + ' #codigoperiodo').val();
                    var entity = $(formName + " #entity").val();
                    var actividad = $(formName + " #actividad").val();
                         $.ajax({
                            dataType: 'json',
                            type: 'POST',
                            url: '../registroInformacion/formularios/academicos/saveUnidadesAcademicas.php',
                            data: { periodo: periodo, action: "getDataDynamic2", entity: entity, joinField: "", actividad:actividad, campoPeriodo: "codigoperiodo",
                                    entityJoin: "siq_tipoActividadAcademicos", codigocarrera:0 },     
                            success:function(data){
                                if (data.success == true){
                                    for (var i=0;i<data.total;i++){                                  
                                        $(formName + " #idCategory_"+data.data[i].idCategory).val(data.data[i].idCategory);
                                        $("#idsiq_detalleformUnidadesAcademicasActividadesAcademicos_"+data.data[i].idCategory).val(data.data[i].idsiq_detalleformUnidadesAcademicasActividadesAcademicos);
                                        $(formName + " #numHoras_"+data.data[i].idCategory).html(data.data[i].numHoras);
                                        $(formName + " #numAcademicosTCE_"+data.data[i].idCategory).html(data.data[i].numAcademicosTCE);
                                        //console.log(aprobacion);
                                        if(data.data[i].Verificado=="1"){
                                           $(formName + " #Verificado_"+data.data[i].idCategory).attr("checked", true);
                                           if(aprobacion==""){
					      $(formName + " #numHoras_"+data.data[i].idCategory).attr("readonly", true).addClass("disable");
					      $(formName + " #numAcademicosTCE_"+data.data[i].idCategory).attr("readonly", true).addClass("disable");					      
                                           }
                                        }
                                        else{
					  $("#Verificado_"+data.data[i].idCategory).attr("checked", false); 
					  if(aprobacion==""){
					      $(formName + " #numHoras_"+data.data[i].idCategory).attr("readonly", false).removeClass("disable");
					      $(formName + " #numAcademicosTCE_"+data.data[i].idCategory).attr("readonly", false).removeClass("disable");					      
                                           }
                                        }
                                    }
                                    $(formName + " #action").val("updateDynamic2");
                                }else{ //alert('Orale');
                                    /*********************************************************************/
                                    
                                    $.ajax({//Ajax
                                        type: 'POST',
                                        url: './reportes/docentes/BuscarData.php',
                                        async: false,
                                        dataType: 'json',
                                        data:({periodo:periodo,entity:entity,campoPeriodo: "codigoperiodo",entityJoin: "siq_tipoActividadAcademicos"}),
                                        error:function(objeto, quepaso, otroobj){alert('Error de Conexi?n , Favor Vuelva a Intentar');},
                                        success: function(data){
                                            if(data.val==true){
                                               
                                                var num = data.Data.length;
                                                
                                                for (var i=0;i<num;i++){
                                                    
                                                    $(formName + " #numHoras_"+data.Data[i].idCategory).html(data.Data[i].numHoras);
                                                    $(formName + " #numAcademicosTCE_"+data.Data[i].idCategory).html(data.Data[i].numAcademicosTCE);
                                                    
                                                }//for
                                                
                                            }else{
                                                
                                                for (var i=0;i<11;i++){
                                                    
                                                    $('.clear').html('0');
                                                                                                        
                                                }//for    
                                                
                                            }
                                        } 
                                	}); //AJAX
                                    
                                    /**********************************************************************/
                                }
                            },
                            error: function(data,error,errorThrown){alert(error + errorThrown);}
                        }); 
                }

              
                
</script>
