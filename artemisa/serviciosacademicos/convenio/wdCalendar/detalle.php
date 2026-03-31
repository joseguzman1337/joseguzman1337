<?php
    //include($rutaTemplateCalendar."template.php");
    include_once ('../../EspacioFisico/templates/template.php');
    $db = getBD();
    //$db = writeHeader("Ver Detalle Actualización Indicador",TRUE,$proyectoMonitoreo,"../../../","dialog");
    
    $data = array();
    $user1 = array();
    $user2 = array();
    $estado = array();
    
    $responsabilidad = "";
    
    if(isset($_REQUEST["id"])){  
       //$utils = new Utils_monitoreo();
      // $api = new API_Monitoreo();
       //var_dump($_REQUEST["id"]);
       $data["RotacionEstudianteId"] = $_REQUEST["id"];
       $data["grupo"] = $_REQUEST["grupo"];
       $data["fechaegreso"] = $_REQUEST["fechaegreso"];
       $data["fechaingreso"] = $_REQUEST["fechaingreso"];
       $data["codigomateria"] = $_REQUEST["codigomateria"];
       $data["IdUbicacionInstitucion"] = $_REQUEST["IdUbicacionInstitucion"];
       $data["idsiq_convenio"] = $_REQUEST["idsiq_convenio"];
       $data["IdInstitucion"] = $_REQUEST["IdInstitucion"];
       $data["idestudiantegeneral"] = $_REQUEST["idestudiantegeneral"];
       $data["SubGrupoId"] = $_REQUEST["SubGrupoId"];
       //var_dump($_REQUEST);
      /* $actividad = $utils->getDataEntity("actividadActualizar", $data["idsiq_actividadActualizar"]);  
       $estado = $utils->getDataEntity("estadoActividadActualizar", $actividad["idEstado"]); 
       $user1 = $utils->getDataEntity("usuario", $data["usuario_creacion"],""); 
       $user2 = $utils->getDataEntity("usuario", $data["usuario_modificacion"],"");      
       $indicador = $utils->getDataEntity("indicador", $data["idsiq_indicador"]);     
       $indicadorG = $utils->getDataEntity("indicadorGenerico", $indicador["idIndicadorGenerico"]);
       $tipoIndicador = $utils->getDataEntity("tipoIndicador", $indicadorG["idTipo"]);
       $responsableActualizar = $api->getUsuarioResponsableActualizarIndicador($data["idsiq_indicador"],false,$db);
       */
       $fecha_inicio = $data["fechaingreso"];
       $fecha_fin = $data["fechaegreso"];
       //busco la actividad anterior
       
       
      /* $responsabilidad = $utils->getResponsabilidadesIndicador($db,$data["idsiq_indicador"]); 
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
            /*$tiene_documentos = true;
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
        /*      
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
          /*  $tiene_documentos = true;
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
       }*/
   }
   
   
    $sqlinstitucion = "select i.NombreInstitucion, u.NombreUbicacion from UbicacionInstituciones u join InstitucionConvenios i on i.InstitucionConvenioId = u.InstitucionConvenioId where IdUbicacionInstitucion='".$data['IdUbicacionInstitucion']."'";
    $datos = $db->GetRow($sqlinstitucion);
    
    $sqlconvenio = "select NombreConvenio from Convenios where ConvenioId = '".$data['idsiq_convenio']."'";
    $nombreconvenio = $db->GetRow($sqlconvenio);
    
    $sqlmateria = "select nombremateria from materia where codigomateria = '".$data['codigomateria']."'";
    $nombremateria = $db->GetRow($sqlmateria);
    
    $sqlrotacion = "select TotalDias, EstadoRotacionId, ServicioRotacionId, JornadaId from RotacionEstudiantes where  RotacionEstudianteId = '".$data["RotacionEstudianteId"]."'";
    $rotacion= $db->GetRow($sqlrotacion);
?>

<div id="contenido" class="monitoreoIndicador">
            <table class="detalle">
                <tr>
                    <?php if($data["SubGrupoId"] == 1){ ?>
                    <th>Estudiante:</th>
                    <td colspan="3"><?php echo $data['grupo']; ?></td>
                    <?php }else {?>
                    <th>Grupo:</th>
                    <td colspan="3"><?php 
                    $sqlnombregrupo = "select NombreSubgrupo from Subgrupos where SubgrupoId = '".$data['SubGrupoId']."'";
                    $nombregrupo = $db->GetRow($sqlnombregrupo);
                    echo $nombregrupo['NombreSubgrupo'];
                    ?></td>
                    <?php }?>
                </tr>
                <tr>
                    <th>Institución:</th>
                    <td colspan="3"><?php echo $datos['NombreInstitucion']." ".$datos['NombreUbicacion']; ?></td>
                </tr>
                <tr>
                    <th>Convenio:</th>                    
                    <td><?php echo $nombreconvenio['NombreConvenio'];?></td>
                </tr>
                <tr>
                    <th>Fecha inicial:</th>
                    <td><?php echo $data["fechaingreso"]; ?></td>
                </tr>
                <tr>
                    <th>Fecha final:</th>
                    <td><?php echo $data["fechaegreso"]; ?></td>
                </tr>
                <tr>
                    <th>Total Dias</th>
                    <td><?php echo $rotacion['TotalDias'];?></td>
                </tr>
                <tr>
                    <th>Jornada:</th>
                    <td><?php switch($rotacion['JornadaId']){ case '1':{echo 'Todo el día';}break; case '2':{echo 'Mañana';}break; case '3': {echo 'Tarde';}break;}?></td>
                </tr>
                <tr>
                    <th>Materia:</th>
                    <td><?php echo $nombremateria['nombremateria']; ?></td>                    
                </tr>
                <tr>
                    <th>Especialidad:</th>
                    <td><?php if($rotacion['ServicioRotacionId']=='0')
                    {
                        echo $nombremateria['nombremateria'];   
                    }else
                    {
                        $sqlservicio = "select NombreServicio from ServicioRotaciones where ServicioRotacionId = '".$rotacion['ServicioRotacionId']."'";
                        $servicio = $db->GetRow($sqlservicio);
                        echo $servicio['NombreServicio'];
                    } ?></td>
                </tr>
                <tr>
                    <th>Estado</th>
                    <td><?php if($rotacion['EstadoRotacionId']==1){echo 'Activo'; }else{echo 'Vencida';}?></td>
                </tr>           
            <?php 
            if($data['SubGrupoId']!= 1)
            {
                $sqlgrupo = "SELECT e.nombresestudiantegeneral, e.apellidosestudiantegeneral FROM RotacionEstudiantes r 
				inner join estudiante es on es.codigoestudiante=r.codigoestudiante 
				inner join estudiantegeneral e on e.idestudiantegeneral = es.idestudiantegeneral 
				WHERE r.SubgrupoId = '".$data['SubGrupoId']."' and r.FechaIngreso = '".$data['fechaingreso']."' and r.FechaEgreso='".$data['fechaegreso']."'";
                //echo $sqlgrupo;
                $datosgrupo = $db->execute($sqlgrupo);                
            
            ?>
            <tr>
                <td colspan="3" align='center'>
                <br />
                <br />
                <strong>INTEGRANTES:</strong>
                <br />
                    <table align='center' border='1'>
                       <tr>
                            <th>No.</th>
                            <th>Nombres</th>
                            <th>Apellidos</th>
                        </tr>
                        <?php
                        $c=1;
                            foreach($datosgrupo as $nombres)
                            {
                                ?>
                             <tr>
                                <th><?php echo $c;?></th>
                                <td><?php echo $nombres['nombresestudiantegeneral'];?></td>
                                <td><?php echo $nombres['apellidosestudiantegeneral'];?></td>
                             </tr>   
                                <?php $c++;
                            }
                        ?>
                    </table>
                </td>
            </tr>
            <?php
            }
            ?>
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
                  data: {action: "dontProcess", realAction: "revision", idIndicador: <?php echo $data["RotacionEstudianteId"]; ?>},                
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
