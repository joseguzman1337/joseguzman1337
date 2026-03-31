<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    include_once("../../variables.php");
    include($rutaTemplateCalendar."template.php");
    $db = writeHeader("Ver Detalle Actualización Indicador",TRUE,$proyectoMonitoreo,"../../../","dialog");
    
    $data = array();
    $user1 = array();
    $user2 = array();
    $estado = array();
    
    $responsabilidad = "";
    
    if(isset($_REQUEST["id"])){  
       $utils = new Utils_monitoreo();
       $api = new API_Monitoreo();
       //var_dump($_REQUEST["id"]);
       $data["idsiq_actividadActualizar"] = $_REQUEST["id"];
       $data["indicador"] = $_REQUEST["indicador"];
       $data["fecha_limite"] = $_REQUEST["limite"];
       $data["fecha_actualizacion"] = $_REQUEST["actualizacion"];
       $data["fecha_creacion"] = $_REQUEST["creacion"];
       $data["usuario_creacion"] = $_REQUEST["creador"];
       $data["fecha_modificacion"] = $_REQUEST["modificacion"];
       $data["usuario_modificacion"] = $_REQUEST["modificador"];
       $data["idsiq_indicador"] = $_REQUEST["idindicador"];
       
       $actividad = $utils->getDataEntity("actividadActualizar", $data["idsiq_actividadActualizar"]);  
       $estado = $utils->getDataEntity("estadoActividadActualizar", $actividad["idEstado"]); 
       $user1 = $utils->getDataEntity("usuario", $data["usuario_creacion"],""); 
       $user2 = $utils->getDataEntity("usuario", $data["usuario_modificacion"],"");      
       $indicador = $utils->getDataEntity("indicador", $data["idsiq_indicador"]);     
       $indicadorG = $utils->getDataEntity("indicadorGenerico", $indicador["idIndicadorGenerico"]);
       $tipoIndicador = $utils->getDataEntity("tipoIndicador", $indicadorG["idTipo"]);
       $responsableActualizar = $api->getUsuarioResponsableActualizarIndicador($data["idsiq_indicador"],false,$db);
       
       $fecha_inicio = "";
       $fecha_fin = "";
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
       $addUrl= "";
       if($fecha_inicio!=""){
           $addUrl = '&Fecha_ini='.$fecha_inicio.'&Fecha_fin='.$fecha_fin;
       } else {
           $addUrl = '&Fecha_fin='.$fecha_fin;
       }
       
       
       $responsabilidad = $utils->getResponsabilidadesIndicador($db,$data["idsiq_indicador"]); 
       $idResponsabilidades = $responsabilidad[1];
       $num = count($idResponsabilidades);
       $actualizar = false;
       $enviarRevision = false;
       $seguimiento = false;
       $calidad = false;
       for($i=0; $i < $num; $i++){
           if($idResponsabilidades[$i]=="1"){
               $actualizar = true;
           } else if($idResponsabilidades[$i]=="2"){
               $seguimiento = true;
           } else if($idResponsabilidades[$i]=="3"){
               $calidad = true;
           }
       }
       $documentosSoporte = false;
       $urlVerSoporte = "";
       $urlCargarSoporte = "";
       $tiene_documentos = false;
       //si el indicador es de percepcion o numerico existente y tiene anexo o analisis entonces tiene documentos de soporte
       if( ($indicadorG["idTipo"]==2 || ($indicadorG["idTipo"]==3 && $indicador["inexistente"]==0)) && ($indicador["tiene_anexo"]==1 || $indicador["es_objeto_analisis"]==1)){
           $documentosSoporte = true;
           $idDocumento = $utils->getDocumentoIndicador($db, $data["idsiq_indicador"]);
           if(count($idDocumento)>0){
               //if(!$calidad){
                    $urlVerSoporte = '../../../SQI_Documento/Documento_Ver.html.php?actionID=Ver&Docuemto_id='.$idDocumento[0].$addUrl;
               /*} else {
                   $urlVerSoporte = '../../../SQI_Documento/Documento_Ver.html.php?actionID=Ver&VF=1&RH=1&Docuemto_id='.$idDocumento[0];
               }*/
            $tiene_documentos = true;
            $urlCargarSoporte = '../../../SQI_Documento/Documento_Ver.html.php?actionID=Modificar_New&Docuemto_id='.$idDocumento[0].$addUrl;
           } else {           
                $urlCargarSoporte = '../../../SQI_Documento/Carga_Documento.html.php?actionID=Cargar_Documeto&indicador_id='.$data["idsiq_indicador"];
           }          
           
       }
       //si tiene de analisis o anexos tambien
       /*else if( ($indicador["tiene_anexo"]==1 || $indicador["es_objeto_analisis"]==1)){
           $documentosSoporte = true;
           $idDocumento = $utils->getDocumentoIndicador($db, $data["idsiq_indicador"]);
           if(count($idDocumento)>0){
            $urlVerSoporte = '../../../SQI_Documento/Documento_Ver.html.php?actionID=Ver&Docuemto_id='.$idDocumento[0];
            $tiene_documentos = true;
           }
           $urlCargarSoporte = '../../../SQI_Documento/Carga_Documento.html.php?actionID=Cargar_Documeto&indicador_id='.$data["idsiq_indicador"];
           
       }*/
       //var_dump($data["idsiq_indicador"]);
       
       $urlVer = "";
       $urlCargar = "";
              
       //si es documental o numerico inexistente
       if($indicadorG["idTipo"]==1 || ($indicadorG["idTipo"]==3 && $indicador["inexistente"]==1) ){
           $idDocumento = $utils->getDocumentoIndicador($db, $data["idsiq_indicador"]);
           
           if(count($idDocumento)>0){
                    $urlVer = '../../../SQI_Documento/Documento_Ver.html.php?actionID=Ver&Docuemto_id='.$idDocumento[0].$addUrl;
            /*if(!$calidad){
                   $urlVer = '../../../SQI_Documento/Documento_Ver.html.php?actionID=Ver&Docuemto_id='.$idDocumento[0];
            } else {
                   $urlVer = '../../../SQI_Documento/Documento_Ver.html.php?actionID=Ver&VF=1&RH=1&Docuemto_id='.$idDocumento[0];
            }*/
            $tiene_documentos = true;
            $urlCargar = '../../../SQI_Documento/Documento_Ver.html.php?actionID=Modificar_New&Docuemto_id='.$idDocumento[0].$addUrl;
           } else {           
                $urlCargar = '../../../SQI_Documento/Carga_Documento.html.php?actionID=Cargar_Documeto&indicador_id='.$data["idsiq_indicador"];
           }
            
       }  else if($indicadorG["idTipo"]==3){
           //numericos
           $urlVer = '../../../datos/reportes/detalle.php?idIndicador='.$data["idsiq_indicador"]."";
           $urlCargar = '../../../datos/registroInformacion/form.php?idIndicador='.$data["idsiq_indicador"];
       }  else if($indicadorG["idTipo"]==2){
           //percepción
           $urlVer = '../../percepcion/instrumentos.php?id='.$data["idsiq_indicador"]."&ver=1";
           $urlCargar = '../../percepcion/instrumentos.php?id='.$data["idsiq_indicador"]."&ver=2";
       }  
       
       $externo = false;
       if($actualizar && $actividad["idEstado"]!=2 && $indicadorG["idTipo"]==3){
           $externo = $utils->esIndicadorExterno($db, $data["idsiq_indicador"]);
           if($externo){
               $actualizar = false;
               $enviarRevision = true;
           }
       }
   }
   
?>

<div id="contenido" class="monitoreoIndicador">
        <ul id="nav" class="drop">
            <li class="level1-li" tabindex="1">
            <?php if(!$documentosSoporte){ 
                if(($tiene_documentos && $indicadorG["idTipo"]==3 && $indicador["inexistente"]==1) || ($indicadorG["idTipo"]==3 && $indicador["inexistente"]==0) || ($tiene_documentos && $indicadorG["idTipo"]==1) || $indicadorG["idTipo"]==2 ){ ?>
             <button type="button" onClick="popup_carga('<?php echo $urlVer; ?>')">Ver indicador</button>
               <?php } else { ?>
             <button type="button" onClick="alert('El indicador no tiene documentos asociados.')">Ver indicador</button>
                <?php } ?>
            </li>            
            <?php //si tiene documento de analisis o tiene anexo y no es documental me toca mandarlo a documental aparte
            } else { ?>
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
    <?php //si la actividad de actualización ya se hizo no se ve ningún boton por lo que ya no toca hacer más nada
    } if($actividad["idEstado"]!=3) { ?>
            <?php //si el boton no esta en revisión lo puede seguir actualizando
             if($actualizar && $actividad["idEstado"]!=2) { ?>
                <li class="level1-li" tabindex="1">
                    <?php if(!$documentosSoporte){ ?>
                <button type="button" onClick="popup_carga('<?php echo $urlCargar; ?>')">Actualizar indicador</button></li>            
                    <?php //si indicador no es documental pero tiene analisis o anexo me debe dejar cargarlo
                    } else{ ?>
                    Actualizar indicador 
                    <ul id="actualizarIndicador">
                        <li id="actualizarI" onClick="popup_carga('<?php echo $urlCargar; ?>')"><button type="button">Actualizar valor indicador</button></li>
                        <li id="actualizarIS"><button type="button" onClick="popup_carga('<?php echo $urlCargarSoporte; ?>')">Cargar documentos de soporte</button></li>
                    </ul>
                </li>
                <?php }  ?>
                <li class="level1-li" tabindex="1"><button type="button" onClick="enviarARevision()">Enviar indicador a revisión</button></li>
            <?php } if($enviarRevision) { ?>
                <li class="level1-li" tabindex="1"><button type="button" onClick="enviarARevision()">Enviar indicador a revisión</button></li>
            <?php } if($seguimiento) { ?>
            <li class="level1-li" tabindex="1"><button type="button" onClick="registrarSeguimiento()">Registrar seguimiento</button></li>
            <?php } //solo cuando se haya enviado a revisión puede la persona realizarla sino puede estar haciendolo sobre versiones malas
            if($actividad["idEstado"]==2 && $calidad) { ?>
                <li class="level1-li" tabindex="1"><button type="button" onClick="registrarRevision()">Registrar revisión de calidad</button></li>
            <?php } ?>
    <?php } ?>
        </ul>
    
            <table class="detalle">
                <tr>
                    <th>Indicador:</th>
                    <td colspan="3"><?php echo $data["idsiq_indicador"].". ".$data['indicador']; ?></td>
                </tr>
                <tr>
                    <th>Responsabilidad del usuario:</th>
                    <td colspan="3"><?php echo $responsabilidad[0]; ?></td>
                </tr>
                <tr>
                    <th>Responsable de actualizar el indicador:</th>
                    <td><?php echo $responsableActualizar; ?></td>
                    <th>Tipo del indicador:</th>
                    <td><?php echo $tipoIndicador["nombre"]; if($indicadorG["idTipo"]==3 && $externo){ echo " (Fuente externa)"; }?></td>
                </tr>
                <tr>
                    <th>Estado actualización:</th>
                    <td><?php echo $estado['nombre']; ?></td>
                    <th>Fecha límite para su actualización:</th>
                    <td><?php echo $data['fecha_limite']; ?></td>
                </tr>
                <?php if($actividad["idEstado"]==3) { ?>
                    <tr>
                        <th>Usuario que realizó la actualización:</th>
                        <td><?php echo $actividad['usuario_actualizacion']; ?></td>
                        <th>Fecha en que se realizó la actualización:</th>
                        <td><?php echo $actividad['fecha_actualizacion']; ?></td>
                    </tr>
                <?php } ?>
                <tr>
                    <th>Fecha creación:</th>
                    <td><?php echo $data['fecha_creacion']; ?></td>
                    <th>Usuario creador:</th>
                    <td><?php echo $user1['nombres']." ".$user1["apellidos"]; ?></td>
                </tr>
                <tr>
                    <th>Fecha modificación:</th>
                    <td><?php echo $data['fecha_modificacion']; ?></td>
                    <th>Usuario modificación:</th>
                    <td><?php echo $user2['nombres']." ".$user2["apellidos"]; ?></td>
                </tr>           
            </table>
    
            <?php include("./detalleRevision.php"); ?>
                  
            <?php include("./detalleSeguimiento.php"); ?>
        </div>

<script type="text/javascript">   
    
    $(document).ready(function() {
        $('#contenido h4').each(function() {
            var tis = $(this), state = true, answer = tis.next('div').slideUp();
            tis.click(function() {
                state = !state;
                answer.slideToggle(state);
                tis.toggleClass('active',state);
            });
        });
    });
    
    function popup_carga(url){        
        
            var centerWidth = (window.screen.width - 850) / 2;
            var centerHeight = (window.screen.height - 700) / 2;
    
          var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=850, height=700, top="+centerHeight+", left="+centerWidth;
          var mypopup = window.open(url,"",opciones);
          //Para que me refresque la página apenas se cierre el popup
          //mypopup.onunload = windowClose;​
          
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
      
      function enviarARevision(){        
            $.ajax({
                  dataType: 'json',
                  type: 'POST',
                  url: 'process.php',
                  data: {action: "dontProcess", realAction: "revision", idIndicador: <?php echo $data["idsiq_indicador"]; ?>},                
                  success:function(data){
                            if (data.success == true){
                                window.parent.ParentWindowFunction();
                                //CloseModelWindow(null,true);  
                                window.location.reload();
                                //window.location.href="index.php";
                            }
                            else{                        
                                alert( '' + data.message );
                            }
                  },
                  error: function(data,error,errorThrown){alert(error + errorThrown);}
            });         
      }
      
      function registrarSeguimiento(){
            window.location.href="seguimiento.php?id=<?php echo $data["idsiq_actividadActualizar"]; ?>&indicadorG=<?php echo $indicador["idIndicadorGenerico"]; ?>&idIndicador=<?php echo $data["idsiq_indicador"]; ?>";
      }      
      
      function registrarRevision(){
            window.location.href="calidad.php?id=<?php echo $data["idsiq_actividadActualizar"]; ?>&idIndicador=<?php echo $data["idsiq_indicador"]; ?>&indicadorG=<?php echo $indicador["idIndicadorGenerico"]; ?>";
      }
      
      function windowClose() {
            window.location.reload();
       }
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
    $('#actualizarIS').focusin(function(){
         popup_carga('<?php echo $urlCargarSoporte; ?>');  
    });
    $('#verI').focusin(function(){
         popup_carga('<?php echo $urlVer; ?>'); 
    });
    $('#actualizarI').focusin(function(){
         popup_carga('<?php echo $urlCargar; ?>'); 
    });
</script> 
<![endif]--> 
<?php writeFooter(); ?>
