<?php
    header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    
    
ini_set('display_errors', 'On');
ini_set('display_errors', 1);
require_once('../Connections/salasiq.php');

$rutaado = "../funciones/adodb/";
require_once('../Connections/salaado.php');
require_once '../class/ManagerEntity.php';

if($_REQUEST['id']){    
    $entity = new ManagerEntity("detalle_convenio");
    $entity->sql_where = "idsiq_detalle_convenio = ".str_replace('row_','',$_REQUEST['id'])."";
   // $entity->debug = true;
    $data = $entity->getData();
    $data = $data[0];
   // print_r($data);
}

if($_REQUEST['idsiq_convenio']){    
    $entity2 = new ManagerEntity("convenio");
    $entity2->sql_where = "idsiq_convenio = ".$_REQUEST['idsiq_convenio']."";
   // $entity2->debug = true;
    $data2 = $entity2->getData();
    $data2 = $data2[0];
}

?>	
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <title>Convenios</title>  
        	<script>
                    
        function compoactivo(){
            $("#codigofacultad option[value='']").attr("selected",true);
            $("#codigocarrera option[value='']").attr("selected",true);
            $("#idsiq_especialidad option[value='']").attr("selected",true);
            
            $('#idsiq_especialidad').attr('disabled',true);
            $('#codigofacultad').attr('disabled',true);
            $('#codigocarrera').attr('disabled',true);
            jQuery("#grupoAjax2").css('display', 'none');
            
            var text = $("#codigomodalidadacademica option:selected").text();
            var value = $("#codigomodalidadacademica option:selected").val();
            //alert("Selected text=" + text + " Selected value= " + value);

            if (value==200){
                   //pregrado
                 $('#codigofacultad').attr('disabled',false);
                 $('#codigocarrera').attr('disabled',false);
                 $('#idsiq_especialidad').attr('disabled',true);
            }else if (value==300){
                //postgrado
                $('#codigofacultad').attr('disabled',true);
                $('#codigocarrera').attr('disabled',true);
                $('#idsiq_especialidad').attr('disabled',false);
            }else{
                $('#idsiq_especialidad').attr('disabled',true);
                $('#codigofacultad').attr('disabled',true);
                $('#codigocarrera').attr('disabled',true);
            }
        }
        
       function displayCarrera(){
           // $("#codigocarrera").load('generacarrera_facultad.php?id=0');
           jQuery("#grupoAjax").css('display', '');
             var ajaxLoader = "<img src='img/ajax-loader.gif' alt='loading...' />";           
           var optionValue = jQuery("select[name='codigofacultad']").val();
             jQuery("#codigocarrera")
                .html(ajaxLoader)
                .load('generacarrera_facultad.php?idfacultad='+optionValue); 
                jQuery("#grupoAjax2").css('display', 'none');
       }
                    
        $.ajaxSetup({ cache:false });
        
        $(document).ready(function(){            
            jQuery("select[name='codigofacultad']").change(function(){displayCarrera();});
            jQuery("#grupoAjax").css('display', 'none');
            var value = $("#codigomodalidadacademica option:selected").val();
           
            if (value==200){
                 $('#codigofacultad').attr('disabled',false);
                 $('#codigocarrera').attr('disabled',false);
                 $('#idsiq_especialidad').attr('disabled',true);
            }else if (value==300){
                //postgrado
                $('#codigofacultad').attr('disabled',true);
                $('#codigocarrera').attr('disabled',true);
                $('#idsiq_especialidad').attr('disabled',false);
            }
            
        });
        
	$(function() {
                $('#maximoparticipantes').numeric();
                
		$( "#fechainicio" ).datepicker({
			changeMonth: true,
			changeYear: true,
                        showOn: "button",
			buttonImage: "../css/themes/smoothness/images/calendar.gif",
			buttonImageOnly: true,
                        dateFormat: 'yy-mm-dd',
                        minDate: "<?php echo $data2['fechainicio'] ?>", maxDate:"<?php echo $data2['fechafin'] ?>"
		});
                $( "#fechafin" ).datepicker({
			changeMonth: true,
			changeYear: true,
                        showOn: "button",
			buttonImage: "../css/themes/smoothness/images/calendar.gif",
			buttonImageOnly: true,
                        dateFormat: 'yy-mm-dd',
                        minDate: "<?php echo $data2['fechainicio'] ?>", maxDate:"<?php echo $data2['fechafin'] ?>"
		});
	});
	</script>
    </head>            
    <body>
        <form action="save.php" method="post" id="form_test">
            <?php
            if($data['idsiq_detalle_convenio']!="")
                echo '<input type="hidden" name="idsiq_detalle_convenio" value="'.$data['idsiq_detalle_convenio'].'">';
            ?>
            <input type="hidden" name="entity" value="detalle_convenio">
            <input type="hidden" name="idsiq_convenio" value="<?php echo $_REQUEST['idsiq_convenio']?>">
            <input type="hidden" name="codigoestado" id="codigoestado" value="100" />
            <fieldset>
                <legend>Informaci&oacute;n del Detalle - Convenio</legend>
                
       <table border="0">
    <tbody>
          <tr>
            <td><label for="numeroconvenio"><span style="color:red; font-size:9px">(*)</span>Número del Convenio:</label></td>
            <td><input type="text" name="numeroconvenio" id="numeroconvenio" title="Número del Convenio" maxlength="120" tabindex="1" placeholder="Número del Convenio" autocomplete="off" value="<?php echo $data['numeroconvenio']?>" /></td>
            <td width="5%"></td>
            <td><label for="maximoparticipantes"><span style="color:red; font-size:9px">(*)</span>Número Max Participante:</label></td>
            <td><input type="text" name="maximoparticipantes" id="maximoparticipantes" title="Número Max Participantes" tabindex="2" maxlength="120" placeholder="Número Max Participantes" autocomplete="off" value="<?php echo $data['maximoparticipantes']?>" /></td>
            <td>
        </tr>
       <!-- <tr>
            <td><label for="id_siq_especialidades"><span style="color:red; font-size:9px">(*)</span>Especialidad Clinica:</label></td>
            <td>
               <input type="text" name="nombreespecilidad" id="nombreespecilidad" title="Especialidad" placeholder="Especialidad" tabindex="3" autocomplete="off" value="<?php echo $data3['nombreespecialidad']?>" readonly/>
            </td>
               <td width="10%"><span><img id="remotejsonp" src="img/iconoLupa.png" width="15px" heigth="15px"/></span></td>
            
        </tr>-->
        <tr>
            <td><label for="modalidadacademica"><span style="color:red; font-size:9px">(*)</span>Modalidad Academica:</label></td>
            <td>
                <?php
                     $query_modalidad= "SELECT ' ' AS nombremodalidadacademica, ' ' AS codigomodalidadacademica union SELECT nombremodalidadacademica, codigomodalidadacademica FROM modalidadacademica where codigoestado=100 and codigomodalidadacademica in (200,300) ";
                     $reg_modalidad = $db->Execute($query_modalidad);
                     echo $reg_modalidad->GetMenu2('codigomodalidadacademica',$data['codigomodalidadacademica'],false,false,1,' id="codigomodalidadacademica" onchange="compoactivo();" tabindex="15"  ');
                ?>
            </td>
            <td></td>
            <td></td>
            <td></td>
         </tr>
          <tr>
            <td><label for="codigofacultad">Facultades:</td>
            <td>
                <?php
                     $query_facultad= "SELECT ' ' AS nombrefacultad, ' ' AS codigofacultad union SELECT nombrefacultad, codigofacultad FROM facultad order by codigofacultad";
                     $reg_facultad = $db->Execute($query_facultad);
                     echo $reg_facultad->GetMenu2('codigofacultad',$data['codigofacultad'],false,false,1,' id="codigofacultad" tabindex="15" ');
                ?>
            </td>
            <td></td>
            <td><label for="id_siq_especialidades">Especialidades:</td>
            <td>
                <?php
                     $query_especialidad= "SELECT ' ' AS nombreespecialidad, ' ' AS idsiq_especialidad union SELECT nombreespecialidad, idsiq_especialidad FROM siq_especialidad where codigoestado=100 order by idsiq_especialidad";
                     $reg_especialidad = $db->Execute($query_especialidad);
                     echo $reg_especialidad->GetMenu2('idsiq_especialidad',$data['idsiq_especialidad'],false,false,1,' id="idsiq_especialidad" tabindex="15"  ');
                ?>
            </td>
         </tr>
          <tr >
            <td><label for="codicarrera">Carrera:</td>
            <td>
                <div id="grupoAjax2"> 
                <?php
                  if (!empty($data['codigocarrera'])){
                     $query_carrera= "SELECT ' ' AS nombrecarrera, ' ' AS codigocarrera union SELECT nombrecarrera, codigocarrera FROM carrera ";
                     $reg_carrera = $db->Execute($query_carrera);
                     echo $reg_carrera->GetMenu2('codigocarrera',$data['codigocarrera'],false,false,1,' id="id_siq_especialidades" tabindex="15" style="width:250px;" ');
                  }
                ?>
                 </div>   
                <div id="grupoAjax"> 
                <select id="codigocarrera" name="codigocarrera" style="width:250px;">                                     
                 
                </select>
                </div>

            </td>
            <td></td>
            <td></td>
            <td>
            </td>
         </tr>
         
        <tr>
            <td><label for="fecharenovacion"><span style="color:red; font-size:9px">(*)</span>Fecha Inicio:</label></td>
            <td><input type="text" name="fechainicio" id="fechainicio" title="Fecha Renovación" maxlength="120" tabindex="4" placeholder="Fecha Inicio" autocomplete="off" value="<?php echo $data['fechainicio']?>" /></td>
            <td></td>
            <td><label for="fechafinconenio"><span style="color:red; font-size:9px">(*)</span>Fecha Fin:</label></td>
            <td><input type="text" name="fechafin" id="fechafin" title="Fecha Fin Convenion" maxlength="120" tabindex="5" placeholder="Fecha Fin" autocomplete="off" value="<?php echo $data['fechafin']?>" /></td>
         </tr>
        <tr>
            <td><label for="renovacionautomatica">Renovación Automática</label></td>
            <td>
                <input type="checkbox" name="renovacionautomatica" id="renovacionautomatica" tabindex="6" title=" Renovaci&oacute;n Autom&aacute;tica" placeholder=" Renovaci&oacute;n Autom&aacute;tica" autocomplete="off" value="1" <?php if($data['renovacionautomatica']==1) echo "checked"; ?>  />
            </td>
            <td></td>
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
            <td><label for="codigosnies">Código Snies:</label></td>
            <td><input type="text" name="codigosnies" id="codigosnies" title="Códigos Snies" maxlength="120" tabindex="10" placeholder="Códigos Snies" autocomplete="off" value="<?php echo $data['codigosnies']?>" /></td>
            <td></td>
            <td><label for="nombreprograma">Nombre Programa:</label> </td>
            <td>
                  <input type="text" name="nombreprograma" id="nombreprograma" title="Nombre Programa" tabindex="11" maxlength="120" placeholder="Nombre Programa" autocomplete="off" value="<?php echo $data['codigosnies']?>" />
            </td>
        </tr>
        <tr>
            <td><label for="numeroregcalificado">Número de la Resolución:</label> </td>
            <td><input type="text" name="numeroregcalificado" id="numeroregcalificado" title="Número Reg Calificado" tabindex="12" maxlength="120" placeholder="Número Reg Calificado" autocomplete="off" value="<?php echo $data['numeroregcalificado']?>" /></td>
            <td></td>
            <td><label for="nivel">Nivel:</label> </td>
            <td>
                                 <?php
                     $query_nivel = "SELECT nombrenivel, idsiq_nivelips FROM siq_nivelips order by nombrenivel asc";
                     $reg_nivel = $db->Execute($query_nivel);
                     echo $reg_nivel->GetMenu2('idsiq_nivelips',$data['idsiq_nivelips'],false,false,1,' tabindex="15" ');
                ?>
            </td>
        </tr>
        <tr>
            <td><label for="idsiq_convenio">Convenio:</label> </td>
            <td><input type="text" name="nom_convenio" id="nom_convenio" title="Convenio" maxlength="120" tabindex="16" placeholder="Convenio" autocomplete="off" readonly value="<?php echo $data2['nombreconvenio']?>" /></td>
            <td></td>
            <td><label for="idciudad">Ciudad:</label></td>
            <td>
                 <?php
                     $query_tipo_ciudad = "SELECT nombreciudad, idciudad FROM ciudad order by 1";
                     $reg_tipociudad = $db->Execute($query_tipo_ciudad);
                     echo $reg_tipociudad->GetMenu2('idciudad',$data['idciudad'],false,false,1,' tabindex="15" style="width:100px" ');
                ?>
            </td>
        </tr>
        <tr>
            <td><label for="codigoperiodo">Periodo Académico:</label> </td>
            <td colspan="4"><?php
                     $query_tipo_periodo = "SELECT nombreperiodo, codigoperiodo FROM periodo order by codigoestadoperiodo";
                     $reg_tipoper = $db->Execute ($query_tipo_periodo);
                     echo $reg_tipoper->GetMenu2('codigoperiodo',$data['codigoperiodo'],false,false,1,' tabindex="17" id="codigoperiodo" ');
                ?>
           </td>
        </tr>
        <tr>
             <td><label for="objetogeneralconvenio">Objeto General del Convenio:</label></td>
            <td colspan="4"><textarea name="objetogeneralconvenio" cols="40" id="objetogeneralconvenio"  tabindex="18" placeholder="Objeto General del Convenio"><?php echo $data['objetogeneralconvenio']?></textarea>
        </tr>
        <tr>
            <td><label for="clausulaterminacion">Clausula Terminacion</label></td>
            <td colspan="4">
                <textarea name="clausulaterminacion" cols="40" id="clausulaterminacion" tabindex="19" placeholder="Clausula Terminación"><?php echo $data['clausulaterminacion']?></textarea>
            </td>
        </tr>
    </tbody>
</table>
    </fieldset>
   <?php if(!empty($_REQUEST['id'])){ ?>
    <fieldset>
        <legend>Participantes</legend>
        <iframe src="../convenio/particonlistar.php?id=<?php echo str_replace('row_','',$_REQUEST['id'])?>" width="100%" height="300" frameborder="0" id='frameDemo'>
        </iframe> 
         <script>
             $("#frameDemo").contents().find("a").css("background-color","#BADA55");
         </script>
     </fieldset>   
        <?php } ?>
        </form>
    </body>
</html>


