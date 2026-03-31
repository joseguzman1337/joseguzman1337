<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    include_once("../../variables.php");
    include($rutaTemplateCalendar."template.php");
    $db = writeHeader("Registrar revisión de calidad para un indicador",TRUE,$proyectoMonitoreo,"../../../","dialog");
       $utils = new Utils_monitoreo();
       $api = new API_Monitoreo();
       
       if(isset($_REQUEST["id"]) && $_REQUEST["id"]!=""){
           $id = $_REQUEST["id"];
           $actividad = $utils->getDataEntity("actividadActualizar", $_REQUEST["id"]);
       } else {
           $rel = $api->getRelacionIndicadorMonitoreo($_REQUEST["idIndicador"]);
           if($rel==null){
               /*echo "<p style='margin:5px 10px;color:red'>Este indicador no tiene fecha de vencimiento asignada, por lo cual, no tiene porque hacerse un monitoreo.</p>";
               die();*/
           } else {
			$actividad = $api->getActividadActualizarActiva($rel["idMonitoreo"]);
			$id = $actividad["idsiq_actividadActualizar"];
		   }
       }
    
    $indicadorG = $utils->getDataEntity("indicadorGenerico", $_REQUEST["indicadorG"]);
    $data = $utils->getDataEntity("indicador", $_REQUEST["idIndicador"]);
    $indicador = $data;
    $discriminacion = $utils->getDataEntity("discriminacionIndicador", $data["discriminacion"]); 
    $nombre = $indicadorG["nombre"];
       if($discriminacion["idsiq_discriminacionIndicador"]==1){
           $nombre = $nombre." - ".$discriminacion["nombre"];
       } else if($discriminacion["idsiq_discriminacionIndicador"]==3){
           $carrera = $utils->getDataNonEntity($db,"nombrecarrera","carrera","codigocarrera='".$data["idCarrera"]."'");
           $nombre = $nombre." - ".$carrera["nombrecarrera"];  
       }
    $action = "dontProcess";
    $realAction = "revisionCalidad";
    
    
    $fecha_inicio = "";
       $fecha_fin = "";
		$principal=true;
   
   if(isset($_REQUEST["Doc_id"]) && $_REQUEST["Doc_id"]!=""){
       //busco la estructura de documento
        $sql = "SELECT * FROM siq_estructuradocumento WHERE idsiq_estructuradocumento='".$actividad["idMonitoreo"]."' AND codigoestado='100'";
        $row = $db->GetRow($sql);
        if(count($row)>0){
            $fecha_inicio = $row["fechainicial"];
            $fecha_fin = $row["fechafinal"];
        }
   } else {
        //busco la actividad anterior
        $sql = "SELECT * FROM siq_actividadActualizar WHERE fecha_limite<'".$actividad["fecha_limite"]."' AND idMonitoreo='".$actividad["idMonitoreo"]."' AND codigoestado='100' ORDER BY fecha_limite DESC ";
        $row = $db->GetRow($sql);
        if(count($row)>0){
            //var_dump($row);

            //tengo una actividad antes que esta
            if($row["idEstado"]==3){
                $actualizacion = strtotime($row["fecha_actualizacion"]);
                    $limite = strtotime($row["fecha_limite"]);

                    if ($limite > $actualizacion) {
                        $fecha_inicio = $row["fecha_limite"];
                    } else {
                        $fecha_inicio = $row["fecha_actualizacion"];
                    }
            } else {
                $fecha_inicio = $row["fecha_limite"];
            }
        }

        //fecha final de esta
        if($actividad["idEstado"]==3){
                $actualizacion = strtotime($actividad["fecha_actualizacion"]);
                    $limite = strtotime($actividad["fecha_limite"]);

                    if ($limite > $actualizacion) {
                        $fecha_fin = $actividad["fecha_limite"];
                    } else {
                        $fecha_fin = $actividad["fecha_actualizacion"];
                    }
        } else {
                    $hoy = strtotime(date("Y-m-d"));
                    $limite = strtotime($actividad["fecha_limite"]);

                    if ($limite > $hoy) {
                        $fecha_fin = $actividad["fecha_limite"];
                    } else {
                        $fecha_fin = date("Y-m-d");
                    }
        }
   }
       $addUrl= "";
       if($fecha_inicio!="" && $fecha_inicio!=null){
           $addUrl = '&Fecha_ini='.$fecha_inicio.'&Fecha_fin='.$fecha_fin;
       } else {
           $addUrl = '&Fecha_fin='.$fecha_fin;
       }
		$addUrl .= '&idsiq_estructuradocumento='.$_REQUEST['Doc_id'];
    
    /*
     * boton ver
     */
    $responsabilidad = $utils->getResponsabilidadesIndicador($db,$data["idsiq_indicador"]); 
       $idResponsabilidades = $responsabilidad[1];
       $num = count($idResponsabilidades);
       $calidad = false;
       for($i=0; $i < $num; $i++){
           if($idResponsabilidades[$i]=="3"){       
               $calidad = true;
           }
       }
       
       $documentosSoporte = false;
       $urlVerSoporte = "";
       $tiene_documentos = false;
       
       //si el indicador es de percepcion o numerico existente y tiene anexo o analisis entonces tiene documentos de soporte
       if( ($indicadorG["idTipo"]==2 || ($indicadorG["idTipo"]==3 && $indicador["inexistente"]==0)) && ($indicador["tiene_anexo"]==1 || $indicador["es_objeto_analisis"]==1)){
           $documentosSoporte = true;
           $idDocumento = $utils->getDocumentoIndicador($db, $data["idsiq_indicador"]);
           if(count($idDocumento)>0){
               if(!$calidad){
                   $urlVerSoporte = '../../../SQI_Documento/Documento_Ver.html.php?actionID=Ver&Docuemto_id='.$idDocumento[0].$addUrl;
               } else {
                   $urlVerSoporte = '../../../SQI_Documento/Documento_Ver.html.php?actionID=Ver&VF=1&RH=1&Docuemto_id='.$idDocumento[0].$addUrl;
               }
            $tiene_documentos = true;            
           }          
           
       }
       
       $urlVer = "";
       $urlCargar = "";
       $principal = false;
              
       //si es documental o numerico inexistente
       if($indicadorG["idTipo"]==1 || ($indicadorG["idTipo"]==3 && $indicador["inexistente"]==1) ){
           $idDocumento = $utils->getDocumentoIndicador($db, $data["idsiq_indicador"]);
           
           if(count($idDocumento)>0){
            if(!$calidad){
                   $urlVer = '../../../SQI_Documento/Documento_Ver.html.php?actionID=Ver&Docuemto_id='.$idDocumento[0].$addUrl;
            } else {
                   $urlVer = '../../../SQI_Documento/Documento_Ver.html.php?actionID=Ver&VF=1&RH=1&Docuemto_id='.$idDocumento[0].$addUrl;
            }
            $principal = true;
            $tiene_documentos = true;           
           } 
            
       }  else if($indicadorG["idTipo"]==3){
           //numericos
           //$urlVer = '../../../sign_numericos/indicadoresNumericos/documentos.php?id='.$data["idsiq_indicador"]."&ver=1";
		   $idDocumento = $utils->getDocumentoIndicador($db, $data["idsiq_indicador"]);
		   if(!$calidad){
                   $urlVer = '../../../SQI_Documento/Documento_Ver.html.php?actionID=Ver&Docuemto_id='.$idDocumento[0].$addUrl;
            } else {
                   $urlVer = '../../../SQI_Documento/Documento_Ver.html.php?actionID=Ver&VF=1&RH=1&Docuemto_id='.$idDocumento[0].$addUrl;
            }
       }  else if($indicadorG["idTipo"]==2){
           //percepción
           //$urlVer = '../../percepcion/instrumentos.php?id='.$data["idsiq_indicador"]."&ver=1";
		   $idDocumento = $utils->getDocumentoIndicador($db, $data["idsiq_indicador"]);
		   if(!$calidad){
                   $urlVer = '../../../SQI_Documento/Documento_Ver.html.php?actionID=Ver&Docuemto_id='.$idDocumento[0].$addUrl;
            } else {
                   $urlVer = '../../../SQI_Documento/Documento_Ver.html.php?actionID=Ver&VF=1&RH=1&Docuemto_id='.$idDocumento[0].$addUrl;
            }
       }  
?>
<div id="contenido" class="monitoreoIndicador">
    <?php //si la actividad de actualización ya se hizo no se ve ningún boton por lo que ya no toca hacer más nada
    if($actividad["idEstado"]!=3) { ?>
        <ul id="nav" class="drop">
            <li class="level1-li" tabindex="1">
            <?php //if(!$documentosSoporte){ 
                if(($tiene_documentos && $indicadorG["idTipo"]==3 && $indicador["inexistente"]==1) || ($indicadorG["idTipo"]==3 && $indicador["inexistente"]==0) || ($tiene_documentos && $indicadorG["idTipo"]==1) || $indicadorG["idTipo"]==2 ){ ?>
             <button type="button" onClick="popup_carga('<?php echo $urlVer; ?>')">Ver indicador</button>
               <?php } else { ?>
             <button type="button" onClick="alert('El indicador no tiene documentos asociados.')">Ver indicador</button>
                <?php } ?>
            </li>            
            <?php //si tiene documento de analisis o tiene anexo y no es documental me toca mandarlo a documental aparte
            /*} else { ?>
                Ver indicador
                <ul id="verIndicador">
		  <li id="verI"><?php if(($tiene_documentos && $indicadorG["idTipo"]==3 && $indicador["inexistente"]==1) || ($indicadorG["idTipo"]==3 && $indicador["inexistente"]==0) || ($tiene_documentos && $indicadorG["idTipo"]==1) || $indicadorG["idTipo"]==2 ){ ?>
                            <button type="button" onClick="popup_carga('<?php echo $urlVer; ?>')">Ver valor indicador</button>
                            <?php } else { ?>
                            <button type="button" onClick="alert('El indicador no tiene documentos asociados.')">Ver valor indicador</button>
                                <?php } ?></li>
                  <li id="verIS"> <?php if($tiene_documentos){ ?>
                        <button type="button" onClick="popup_carga('<?php echo $urlVerSoporte; ?>')">Ver documentos de soporte</button>
                        <?php } else { ?>
                        <button type="button" onClick="alert('El indicador no tiene documentos asociados.')">Ver documentos de soporte</button>
                        <?php } ?>                      
                  </li>
                </ul>
            </li>
               <?php } */ ?>      
        </ul>
<?php } ?>


<div id="form" style="margin: 0 5px;clear:both;"> 
    <form action="save.php" method="post" id="form_test">
            <input type="hidden" name="entity" value="revisionCalidadIndicador" />
            <input type="hidden" name="action" value="<?php echo $action; ?>" />
            <input type="hidden" name="realAction" value="<?php echo $realAction; ?>" />
     
     <fieldset>   
              <legend>Información del Indicador</legend>
              <label style="margin-left:30px;">Indicador: </label>
              <p style="display: inline-block; width: 85%;margin-bottom: 0;"><?php echo $nombre; ?></p>                          
    </fieldset>
     
     <fieldset>   
              <legend>Revisión de Calidad</legend>
              <label class="grid-2-12">Comentarios: <span class="mandatory hidden">(*)</span></label>
              <textarea title="Comentarios" id="comentarios" name="comentarios" class="grid-10-12"></textarea>  
              
              <label class="grid-2-12">Conclusión: </label>
              <input type="radio" name="aprobado" value="0" style="display:inline-block;margin-left:10px;margin-top:5px"> Rechazado
              <input type="radio" name="aprobado" value="1" checked style="display:inline-block;margin-left:10px;"> Aprobado
            
              <input type="hidden" name="idActualizacion" value="<?php echo $id; ?>" />     
              <input type="hidden" name="idIndicador" value="<?php echo $_REQUEST["idIndicador"]; ?>" />                    
    </fieldset>  
            
     <input type="submit" value="Registrar revisión de calidad" class="first" /> 
     
     <button type="button" onClick="backAway()" class="cancel" style="margin-left: 15px;">Cancelar</button>
</form>
</div>

<script type="text/javascript">
                $(':submit').click(function(event) { 
                    event.preventDefault();
                    
                    var valido= validateForm("#form_test");
                    
                    <?php if($tiene_documentos) { ?>
                        //valido que los documentos tengan version final elegida
                        if(valido){             
                                $.ajax({
                                    dataType: 'json',
                                    type: 'POST',
                                    async: false,
                                    url: "validate.php",
                                    data: {
                                        documento: <?php echo $idDocumento[0]; ?>,
                                        indicador: <?php echo $data["idsiq_indicador"]; ?>,
                                        principal: '<?php echo $principal; ?>',
                                        chequeo: $("input[name=aprobado]:checked").val()
                                    },
                                    success:function(data){ 
                                        if (data.success == true){
                                            event.preventDefault();
                                        } else {
                                            event.preventDefault();
                                            valido = false;
                                            alert(data.message);                                            
                                        }                                    
                                    },
                                    error: function(data,error){}
                                }); 
                        }
                        <?php } ?>
                    
                    if(valido){                        
                        sendForm();
                    } 
                    
                });
                
                function popup_carga(url){        
        
                        var centerWidth = (window.screen.width - 850) / 2;
                        var centerHeight = (window.screen.height - 700) / 2;

                    var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=850, height=700, top="+centerHeight+", left="+centerWidth;
                    var mypopup = window.open(url,"",opciones);
                    //Para que me refresque la página apenas se cierre el popup
                    //mypopup.onunload = windowClose;?

                    //para poner la ventana en frente
                    window.focus();
                    mypopup.focus();

                    //Para saber cuando me cierran el popup, que me recargue la ventana con los botones
                    var timer = setInterval(function() {   
                            if(mypopup.closed) {  
                                clearInterval(timer);  
                                //alert('closed');  
                                windowClose();
                            }  
                    }, 500);  

                }
                
                function sendForm(){
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: 'process.php',
                        data: $('#form_test').serialize(),                
                        success:function(data){
                            if (data.success == true){
                                <?php if(isset($_REQUEST["close"]) && $_REQUEST["close"]==true){ ?>
                                      backAway();      
                                <?php } else { ?>
                                //Para actualizar el calendario cosa que si es aceptada pase a verde de una
                                 window.parent.ParentWindowFunction();
                                 backAway();
                                 <?php } ?>
                            }
                            else{                        
                                $('#msg-error').html('<p>' + data.message + '</p>');
                                $('#msg-error').addClass('msg-error');
                            }
                        },
                        error: function(data,error,errorThrown){alert(error + errorThrown);}
                    });            
                }
                
                
       <?php if(isset($_REQUEST["close"]) && $_REQUEST["close"]==true){ ?>
                    function backAway(){
                            //alert("Se ha hecho el seguimiento de forma exitosa.");
                            window.close();
                    }
       <?php } else { ?>

                    function backAway(){
                            if (document.referrer) { //alternatively, window.history.length == 0
                                history.back();
                                //window.open(document.referrer,'_self');
                            } else {
                                history.go(-1);
                            }
                        }
        <?php } ?>
                
                $("input[name='aprobado']").change(function(){
                    if ($("input[name='aprobado']:checked").val() == '0'){
                        $(".mandatory").removeClass('hidden');
                        $("#comentarios").addClass('required');

                    }
                    else if ($("input[name='aprobado']:checked").val() == '1'){
                        $(".mandatory").addClass('hidden');
                        $("#comentarios").removeClass('required');

                    }
                });
</script>
<!--[if lte IE 10]>
<script type="text/javascript">
    $('#verIS').focusin(function(){
        <?php if($tiene_documentos){ ?>
              popup_carga('<?php echo $urlVerSoporte; ?>');
        <?php } else { ?>      
              alert('El indicador no tiene documentos asociados.');
        <?php } ?>   
    });
    $('#verI').focusin(function(){
         popup_carga('<?php echo $urlVer; ?>'); 
    });
</script> 
<![endif]--> 
<?php writeFooter(); ?>
