<?php
    header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");

require_once('../Connections/salasiq.php');
$rutaado = "../funciones/adodb/";
require_once('../Connections/salaado.php');

if($_REQUEST['id']){    
    require_once '../class/ManagerEntity.php';
    $entity = new ManagerEntity("convenio");

    $entity->sql_where = "idsiq_convenio = ".str_replace('row_','',$_REQUEST['id'])."";

    //$entity->debug = true;
    $data = $entity->getData();
    $data = $data[0];

    // print_r($data);
    if($data['idsiq_institucionconvenio']>0){
        $entity2 = new ManagerEntity("institucionconvenio");
        $entity2->sql_where = "idsiq_institucionconvenio = ".$data['idsiq_institucionconvenio'];
        $data2 = $entity2->getData();
        $data2 = $data2[0];
    }
    
}
?>	
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <title>Convenios</title>     
   </head>   

    <body>
        <form action="save.php" method="post" id="form_test">
            <input type="hidden" name="entity" value="convenio" />
            <input type="hidden" name="codigoestado" id="codigoestado" value="100" />
            <?php
            if($data['idsiq_convenio']!="")
                echo '<input type="hidden" name="idsiq_convenio" value="'.$data['idsiq_convenio'].'">';
            ?>
            <input type="hidden" name="idsiq_institucionconvenio" id="idsiq_institucionconvenio" value="<?php echo $data['idsiq_institucionconvenio'];?>" />
            <fieldset>
                <legend>Información del Convenio</legend>                
                <table border="0">                    
                    <tbody>
                        <tr>
                            <td><label for="nombreconvenio"><span style="color:red; font-size:9px">(*)</span>Nombre del Convenio:</label></td>
                            <td><input type="text" name="nombreconvenio" id="nombreconvenio" title="Nombre del Convenio" maxlength="120" tabindex="1" placeholder="Nombre del Convenio" autocomplete="off" value="<?php echo $data['nombreconvenio']?>" />
                            </td>
                            <td width="10%"></td>
                            <td><label for="codigoconvenio"><span style="color:red; font-size:9px">(*)</span>Codigo Convenio:</label></td>
                            <td><input type="text" name="codigoconvenio" id="codigoconvenio" title="Codigo del Convenio" maxlength="4" tabindex="2" placeholder="Codigo del Convenio" autocomplete="off" value="<?php echo $data['codigoconvenio']?>" /></td>
                        </tr>
                        <tr>
                            <td><label for="idsiq_tipoconvenio">Tipo de Convenio:</label></td>
                            <td><?php
                                $query_tipo_convenio = "SELECT nombretipoconvenio,idsiq_tipoconvenio FROM siq_tipoconvenio where codigoestado = 100 order by 1";
                                $reg_tipoconve = $db->Execute ($query_tipo_convenio);
                                echo $reg_tipoconve->GetMenu2('idsiq_tipoconvenio',$data['idsiq_tipoconvenio'],false,false,1,' tabindex="3" ');
                            ?></td>
                            <td width="10%"></td>
                            <td><label for="idpais">Pais:</label></td>
                            <td><?php
                                $query_pais = "SELECT nombrepais,idpais FROM pais where codigoestado = 100 ";
                                $reg_pais = $db->Execute ($query_pais);
                                echo $reg_pais->GetMenu2('idpais',$data['idpais'],false,false,1,' tabindex="4" onchange="fechafin()" ');
                            ?></td>                            
                        </tr>
                        <tr>
                            <td><label for="direccion"><span style="color:red; font-size:9px">(*)</span>Instituci&oacute;n:</label></td>
                            <td>
                                <input type="text" name="nombreinstitucion" id="nombreinstitucion" title="Instituci&oacute;n" tabindex="5" placeholder="Instituci&oacute;n" autocomplete="off" value="<?php echo $data2['nombreinstitucion']?>" readonly/>
                            </td>
                            <td width="10%"><span><img id="remotejsonp" src="img/iconoLupa.png" width="15px" heigth="15px"/></span></td>
                        </tr>
                        <tr>
                        <td><label for="fechainicio"><span style="color:red; font-size:9px">(*)</span>Fecha de Inicio</label></td>
                        <td><input type="text" name="fechainicio" size="12" id="fechainicio" title="Fecha Inicio" maxlength="12" tabindex="7" placeholder="Fecha Inicio" autocomplete="off" value="<?php echo $data['fechainicio']?>"/></td>
                            <td width="10%"></td>
                        <td><label for=""><span style="color:red; font-size:9px">(*)</span>Fecha Fin</label></td>
                        <td><input type="text" name="fechafin" size="12" id="fechafin" title="Fecha Fin" maxlength="12" placeholder="Fecha Fin" tabindex="8"  autocomplete="off" value="<?php echo $data['fechafin']?>"/></td>
                        </tr>
                        <tr>
                            
                            <td><label for="idsiq_duracionconvenio">Duraci&oacute;n:</label></td>
                            <td colspan="3">                                
                                <span>
                                <input type="button" value="Duración" id="calculate" name="calculate">
                                <input type="text" name="idsiq_duracionconvenio" size="2" id="idsiq_duracionconvenio" title="Duración" maxlength="12"  placeholder="Duración" tabindex="8"  autocomplete="off" value="<?php echo $data['idsiq_duracionconvenio']?>"/>
                                <div id="cant" name="cant" style=" width: 50px;">
                                    <?php 
                                    if (!empty($data['idsiq_duracionconvenio'])){
                                        if($data['idsiq_duracionconvenio']==1){
                                            echo "Año";
                                        }else if(($data['idsiq_duracionconvenio']>100) or ($data['idsiq_duracionconvenio']==0)){
                                            echo "Indefinido";
                                        }else{
                                            echo "Años";
                                        }
                                    }
                                    
                                    ?>
                                </div>
                                </span>
                                    <?php
                                //$query_duracion = "SELECT nombreduracion,idsiq_duracionconvenio FROM siq_duracionconvenio order by idsiq_duracionconvenio";
                                //$reg_duracion = $db->Execute ($query_duracion);
                                //echo $reg_duracion->GetMenu2('idsiq_duracionconvenio',$data['idsiq_duracionconvenio'],false,false,1,' tabindex="6" ');
                            ?>
                                
                            </select></td>                            

                        </tr>
                        <tr>
                            <td><label for="valorcontraprestacion">Valor Contraprestaci&oacute;n:</label></td>                            
                            <td><textarea id="valorcontraprestacion" name="valorcontraprestacion" title="Valor Contraprestaci&oacute;n" tabindex="9" placeholder="Valor Contraprestaci&oacute;n" autocomplete="off" cols="30"><?php echo $data['valorcontraprestacion']?></textarea></td>
                           <td width="10%"></td>
                            <td><label for="idsiq_contraprestacion">Tipo de Contrapretaci&oacute;n:</label> </td>
                            <td><?php
                                $query_tipo_contraprestacion = "SELECT nombretipocontraprestacion,idsiq_contraprestacion FROM siq_contraprestacion order by idsiq_contraprestacion";
                                $reg_tipocontr = $db->Execute ($query_tipo_contraprestacion);
                                echo $reg_tipocontr->GetMenu2('idsiq_contraprestacion',$data['idsiq_contraprestacion'],false,false,1,' tabindex="10"  ');
                            ?></td>                            
                        </tr>
                        <tr>
                            <td><label for="renovacionautomatica">Tiene Renovaci&oacute;n Autom&aacute;tica?:</label> </td>
                            <td colspan="4">
                                <span>
                                Automatica<input type="radio" name="renovacionautomatica" id="renovacionautomatica" title=" Renovaci&oacute;n Autom&aacute;tica" tabindex="11" placeholder=" Renovaci&oacute;n Autom&aacute;tica" autocomplete="off" value="1" <?php if($data['renovacionautomatica']==1) echo "checked"; ?>  />
                                Por Escrito<input type="radio" name="renovacionautomatica" id="renovacionautomatica" title=" Renovaci&oacute;n por Escrito" tabindex="11" placeholder=" Renovaci&oacute;n Autom&aacute;tica" autocomplete="off" value="2" <?php if($data['renovacionautomatica']==2) echo "checked"; ?>  />
                                Por Evaluación<input type="radio" name="renovacionautomatica" id="renovacionautomatica" title=" Renovaci&oacute;n por Evaluación" tabindex="11" placeholder=" Renovaci&oacute;n Autom&aacute;tica" autocomplete="off" value="3" <?php if($data['renovacionautomatica']==3) echo "checked"; ?>  />
                                </span>
                            </td>
                          </tr>
                          <tr>
			    <td><label for="tienepoliza">Tiene Poliza?</label></td>
			      <td>
				  <input type="checkbox" name="tienepoliza" id="tienepoliza" title="Tiene Poliza" tabindex="7" placeholder="Tiene Poliza" autocomplete="off" value="1" <?php if($data['tienepoliza']==1) echo "checked"; ?>  />
			      </td>
			  </tr>
			  <tr>
			  <td><label for="afiliacionarp">Afiliación ARP:</label></td>
			    <td>
				<input type="checkbox" name="afiliacionarp" id="afiliacionarp" title="Afiliación ARP" tabindex="8" placeholder="Afiliación ARP" autocomplete="off" value="1" <?php if($data['afiliacionarp']==1) echo "checked"; ?>  />
			    </td>
			    <td></td>
			    <td><label for="afiliacionsss">Afiliación SGSSS:</label></td>
			    <td>
				<input type="checkbox" name="afiliacionsss" id="afiliacionsss" title="Afiliación SSS" tabindex="9" placeholder="Afiliación SSS" autocomplete="off" value="1" <?php if($data['afiliacionsss']==1) echo "checked"; ?>  />
			    </td>
			</tr>
                          
                        <tr>
                            <td><label for="portafolioservicio">Alcance del Convenio:</label></td>
                            <td colspan="8"><textarea id="portafolioservicio" name="portafolioservicio" title="Portafolio de Servicios" tabindex="12" placeholder="Portafolio de Servicios" autocomplete="off" cols="80"><?php echo $data['portafolioservicio']?></textarea></td>
                        </tr>
                        <tr>
			    <td><label for="objetogeneralconvenio">Objeto General del Convenio:</label></td>
			    <td colspan="4"><textarea name="objetogeneralconvenio" cols="80" rows="4" id="objetogeneralconvenio"  tabindex="18" placeholder="Objeto General del Convenio"><?php echo $data['objetogeneralconvenio']?></textarea>
			</tr>
			<tr>
			    <td><label for="clausulaterminacion">Clausula Terminacion</label></td>
			    <td colspan="4">
				<textarea name="clausulaterminacion" cols="80" rows="4" wrap="PHYSICAL" id="clausulaterminacion" tabindex="19" placeholder="Clausula Terminación"><?php echo $data['clausulaterminacion']?></textarea>
			    </td>
			</tr>
                    </tbody>
                </table> 
            </fieldset>
            <span style="color:red; font-size:9px">* Son campos obligatorios</span>
        </form>
        <?php       
        if($_REQUEST['id']){            
//            echo '<div style="alignment-adjust: central;">
//            <a href="detalleconlistar.php?id='.str_replace('row_','',$_REQUEST['id']).'">Detalle del convenio</a>
//            </div>';
//            echo '<div style="alignment-adjust: central;">
//            <a href="anexolistar.php?id='.str_replace('row_','',$_REQUEST['id']).'">Anexos del Convenio</a>
//            </div>';
        }        
        ?>
        
        <div id="searh">
        </div>
        
    </body>
    <script>
              
         function Popup(){ 
            if (window.showModalDialog){
                var iddata = window.showModalDialog("lookupInstitucion.php","name","dialogWidth:555px;dialogHeight:250px");
            } else {
            iddata = window.open('lookupInstitucion.php','name','height=255,width=250,toolbar=no,directories=no,status=no,continued from previous linemenubar=no,scrollbars=no,resizable=no ,modal=yes');
            }
            $("#nombreinstitucion").val(iddata.value);
            var objHidden = document.getElementById("idsiq_institucionconvenio");            
            objHidden.value = iddata.id.substring(4,iddata.id.length);             
        }
        
       
                     
        $("#remotejsonp").click( function (){
            Popup();
            return false;            
        });
        
         

        $(document).ready(function() {
        $("#fechainicio").datepicker({ 
            changeMonth: true,
            changeYear: true,
            yearRange: '1910:3000',
            showOn: "button",
            buttonImage: "../css/themes/smoothness/images/calendar.gif",
            buttonImageOnly: true,
            dateFormat: "yy-mm-dd"
        });
       
        $("#fechafin").datepicker({ 
            changeMonth: true,
            changeYear: true,
           yearRange: '1910:3000',
            showOn: "button",
            buttonImage: "../css/themes/smoothness/images/calendar.gif",
            buttonImageOnly: true,
            dateFormat: "yy-mm-dd"
        }
        );
        });
        
        $("#calculate").click( function (){
           var fecha1  = document.getElementById('fechainicio').value;
	   var fecha2  = document.getElementById('fechafin').value;
          // alert(fecha1+'=>'+fecha2)
           var Dato_Fecha_1 = fecha1.split('-');
	   var Dato_Fecha_2 = fecha2.split('-');
           var sAno0 = Dato_Fecha_1[0];  
           var sMes0 = Dato_Fecha_1[1];  
	   var sDia0 = Dato_Fecha_1[2];  
	  
	   var sAno1 = Dato_Fecha_2[0];  
           var sMes1 = Dato_Fecha_2[1];  
	   var sDia1 = Dato_Fecha_2[2]; 
           //alert(sDia0+'-'+sDia1);
           if (sAno0>sAno1){
               alert('La fecha final debe ser mayor a la inicial');
           }else{
               if (sAno0==sAno1){
                   if(sMes0 == sMes1){
                       
                       if(sDia0 == sDia1){
                           alert('La fecha final debe ser mayor a la inicial');
                       }else if(sDia0 < sDia1){
                           alert('La duración minima del convenio es un año');
                       }else{
                           alert('La duración minima del convenio es un año');
                       }
                   }
               }else{
                   
                   var totalAno=sAno1-sAno0;
                   if (totalAno>100){
                    $("#idsiq_duracionconvenio").val(0);   
                    $("#cant").html("Indefinido");
                   }else{
                    $("#idsiq_duracionconvenio").val(totalAno);
                     $('#idsiq_duracionconvenio').attr('readonly',true);
                    if (totalAno>1){
                        $("#cant").html("Años");
                    }else{
                        $("#cant").html("Año");
                    }
                   }
               }
           }
           
     
        });
        </script> 
</html>