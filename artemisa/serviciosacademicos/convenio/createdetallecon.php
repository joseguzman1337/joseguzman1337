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

switch($_REQUEST['actionID']){
  case 'fechafinal':{
	  $D_resolucion   = $_REQUEST['D_resolucion'].' year';
	  $fechainicio    = $_REQUEST['fechainicio'];  
	 
	  $AniosDespues = date("Y-m-d", strtotime("$fechainicio+$D_resolucion")) ;
	  
	  $menos=date("Y-m-d", strtotime("$AniosDespues-1 day"));	  
	  
	  $a_vectt['fechafin']		= $menos;
	  echo json_encode($a_vectt);
	  exit;
	  
  }exit;
                                            
}

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

            if (value==200 || value==300){
                   //pregrado
                 $('#codigofacultad').attr('disabled',false);
                 $('#codigocarrera').attr('disabled',false);
                 $('#idsiq_especialidad').attr('disabled',true);
                 $('#fechainicio').val('');
                 $('#fechafin').val('');
                 $('#renovacionautomatica').removeAttr('checked');
                 $('#tienepoliza').removeAttr('checked');
                 $('#afiliacionarp').removeAttr('checked');
                 $('#afiliacionsss').removeAttr('checked');
                 $('#codigosnies').val('');
                 $('#nombreprograma').val('');
                 $('#numeroregcalificado').val('');
                 $('#numeroregcalificadodos').val('');
                 $("#idsiq_nivelips option[value='1']").attr("selected","selected");
                 $("#idciudad option[value='2000']").attr("selected","selected");
                 $("#codigoperiodo option[value='20122']").attr("selected","selected");
                 $('#objetogeneralconvenio').val('');
                 $('#clausulaterminacion').val('');
                 $('#dato_carrera').val('');
            /*}else if (value==300){
                //postgrado
                 $('#codigofacultad').attr('disabled',true);
                 $('#codigocarrera').attr('disabled',true);
                 $('#idsiq_especialidad').attr('disabled',false);
                 $('#fechainicio').val(' ');
                 $('#fechafin').val(' ');
                 $('#renovacionautomatica').removeAttr('checked');
                 $('#tienepoliza').removeAttr('checked');
                 $('#afiliacionarp').removeAttr('checked');
                 $('#afiliacionsss').removeAttr('checked');
                 $('#codigosnies').val(' ');
                 $('#nombreprograma').val(' ');
                 $('#numeroregcalificado').val(' ');
                 $("#idsiq_nivelips option[value='1']").attr("selected","selected");
                 $("#idciudad option[value='2000']").attr("selected","selected");
                 $("#codigoperiodo option[value='20122']").attr("selected","selected");
                 $('#objetogeneralconvenio').val(' ');
                 $('#clausulaterminacion').val(' ');
                 $('#dato_carrera').val(' ');*/
            }else{
                $('#idsiq_especialidad').attr('disabled',true);
                $('#codigofacultad').attr('disabled',true);
                $('#codigocarrera').attr('disabled',true);
                       $('#fechainicio').val(' ');
                 $('#fechafin').val(' ');
                 $('#renovacionautomatica').removeAttr('checked');
                 $('#tienepoliza').removeAttr('checked');
                 $('#afiliacionarp').removeAttr('checked');
                 $('#afiliacionsss').removeAttr('checked');
                 $('#codigosnies').val(' ');
                 $('#nombreprograma').val(' ');
                 $('#numeroregcalificado').val(' ');
                 $('#numeroregcalificadodos').val(' ');
                 $("#idsiq_nivelips option[value='1']").attr("selected","selected");
                 $("#idciudad option[value='2000']").attr("selected","selected");
                 $("#codigoperiodo option[value='20122']").attr("selected","selected");
                 $('#objetogeneralconvenio').val(' ');
                 $('#clausulaterminacion').val(' ');
                 $('#dato_carrera').val(' ');
            }
        }
        
       function displayCarrera(){
           // $("#codigocarrera").load('generacarrera_facultad.php?id=0');
		var datomoda = $("#codigomodalidadacademica option:selected").val();
           jQuery("#grupoAjax").css('display', '');
             var ajaxLoader = "<img src='img/ajax-loader.gif' alt='loading...' />";           
           var optionValue = jQuery("select[name='codigofacultad']").val();
             jQuery("#codigocarrera")
                .html(ajaxLoader)
                .load('generacarrera_facultad.php?idfacultad='+optionValue+'&codigomodalidad='+datomoda); 
                jQuery("#grupoAjax2").css('display', 'none');
       }
       
       function displaydato(){
            var value_dato = $("#idsiq_especialidad option:selected").html();
              // alert('especialidad'+value_dato)
               $('#dato_carrera').val(value_dato);
       }
       
       function displaydato2(){
            var value_dato = $("#codigocarrera option:selected").html();
              // alert('carrera'+value_dato)
               $('#dato_carrera').val(value_dato);
       }
                    
        $.ajaxSetup({ cache:false });
        
        $(document).ready(function(){            
            jQuery("select[name='codigofacultad']").change(function(){displayCarrera();});
            //jQuery("select[name='idsiq_especialidad']").change(function(){displaydato();});
            jQuery("select[name='codigocarrera']").change(function(){displaydato2();});
            
            jQuery("#grupoAjax").css('display', 'none');
            var value = $("#codigomodalidadacademica option:selected").val();
           
            if (value==200 || value==300){
                 $('#codigofacultad').attr('disabled',false);
                 $('#codigocarrera').attr('disabled',false);
                 $('#idsiq_especialidad').attr('disabled',true);
            }
            
        });
        
	$(function() {
                $('#maximoparticipantes').numeric();
                $('#codigosnies').numeric();
                $('#codigo_programa').numeric();                                
                
		$( "#fechainicio" ).datepicker({
			changeMonth: true,
			changeYear: true,
			yearRange: '1980:2300',
                        showOn: "button",
			buttonImage: "../css/themes/smoothness/images/calendar.gif",
			buttonImageOnly: true,
                        dateFormat: 'yy-mm-dd',
                        //minDate: "<?php //echo $data2['fechainicio'] ?>", maxDate:"<?php //echo $data2['fechafin'] ?>"
		});
                /*$( "#fechafin" ).datepicker({
			changeMonth: true,
			changeYear: true,
                        showOn: "button",
			buttonImage: "../css/themes/smoothness/images/calendar.gif",
			buttonImageOnly: true,
                        dateFormat: 'yy-mm-dd',
                        minDate: "<?php //echo $data2['fechainicio'] ?>", maxDate:"<?php //echo $data2['fechafin'] ?>"
		});*/
	});
	
	function calcularFecha(){
	  
	  
	  var D_resolucion = $('#duracion_resolucion').val();
	  var fechainicio=$('#fechainicio').val();
	  
	  if(D_resolucion=='' || D_resolucion==0){
	    alert("Debe Digitar la cantidad de Años");
	    $("#duracion_resolucion").focus();
	    return false;
	  }
	  else if(fechainicio=='' || fechainicio==0){
	    alert("Debe digitar la fecha de inicio");
	    $("fechainicio").focus();	  
	    return false;
	  }
	  else{  
	   $.ajax({
                url: "createdetallecon.php",
                type: "GET",
                dataType: "json",
                async: false,
                data:({actionID: 'fechafinal',D_resolucion:D_resolucion,
                                            fechainicio:fechainicio}),
			  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
			  success: function(data){
					$('#fechafin').val(data.fechafin);
				}//data 
            });
          }  
            
	}//function calcularFecha
	
	
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
            <td><input type="text" name="numeroconvenio" id="numeroconvenio" title="Número del Convenio" maxlength="120" tabindex="1" placeholder="Número del Convenio" autocomplete="off" value="<?php echo $data2['codigoconvenio']?>" disabled />
	        <input type="hidden" name="numeroconvenio" value="<?php echo $data2['codigoconvenio']?>">
            </td>            
            <td><label for="maximoparticipantes"><span style="color:red; font-size:9px">(*)</span>Estudiantes 
aprobados registro calificado/Resolución del Ministerio:</label></td>
            <td><input type="text" name="maximoparticipantes" id="maximoparticipantes" title="Número Max Participantes" tabindex="2" maxlength="3" placeholder="Número Max Participantes" autocomplete="off" value="<?php echo $data['maximoparticipantes']?>" /></td>
            <td>
        </tr>
       <!-- <tr>
            <td><label for="id_siq_especialidades"><span style="color:red; font-size:9px">(*)</span>Especialidad Clinica:</label></td>
            <td>
               <input type="text" name="nombreespecilidad" id="nombreespecilidad" title="Especialidad" placeholder="Especialidad" tabindex="3" autocomplete="off" value="<?php //echo $data3['nombreespecialidad']?>" readonly/>
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
            <!--<td><label for="id_siq_especialidades">Especialidades:</td>
            <td>
                <?php
                    /* $query_especialidad= "SELECT ' ' AS nombreespecialidad, ' ' AS idsiq_especialidad union SELECT nombreespecialidad, idsiq_especialidad FROM siq_especialidad where codigoestado=100 order by idsiq_especialidad";
                     $reg_especialidad = $db->Execute($query_especialidad);
                     echo $reg_especialidad->GetMenu2('idsiq_especialidad',$data['idsiq_especialidad'],false,false,1,' id="idsiq_especialidad" tabindex="15"  ');*/
                ?>
            </td>-->
         </tr>
          <tr >
            <td><label for="codicarrera">Carrera:</td>
            <td>
                <div id="grupoAjax2"> 
                <?php
                  if (!empty($data['codigocarrera'])){		      
                     $query_carrera= "SELECT ' ' AS nombrecarrera, ' ' AS codigocarrera union SELECT nombrecarrera, codigocarrera FROM carrera where codigofacultad='".$data['codigofacultad']."' and codigomodalidadacademica='".$data['codigomodalidadacademica']."'";
                     $reg_carrera = $db->Execute($query_carrera);
                     echo $reg_carrera->GetMenu2('codigocarrera',$data['codigocarrera'],false,false,1,' id="id_siq_especialidades" tabindex="15" style="width:250px;" ');
                  }
                ?>
                 </div>   
                <div id="grupoAjax"> 
                <select id="codigocarrera" name="codigocarrera" style="width:250px;">                                     
                 
                </select>
                </div>
                <input type="hidden" name="dato_carrera" id="dato_carrera"  value="<?php echo $data['dato_carrera']?>" /></td>
            </td>
            <td>
            <td></td>
            <td>
            </td>
         </tr>
         <tr>
	  <td><label for="duracion_resolucion">Año de duración  de la resolución:</label> 
	  
	  </td>
            <td>
                <input type="text" name="duracion_resolucion" id="duracion_resolucion" title="Año de duración  de la resolución" tabindex="13" size="2" maxlength="2" placeholder="Año de duración  de la resolución" autocomplete="off" value="<?php echo $data['duracion_resolucion']?>" />
            </td>
            
            <td><label for="fecharenovacion"><span style="color:red; font-size:9px">(*)</span>Fecha Inicio:</label></td>
            <td><input type="text" name="fechainicio" id="fechainicio" title="Fecha Renovación" maxlength="120" tabindex="4" placeholder="Fecha Inicio" autocomplete="off" value="<?php echo $data['fechainicio']?>" /></td>
         </tr>
        <tr>                               
            <td><label for="idsiq_duracionconvenio">Duraci&oacute;n:</label></td>
            <td>
              <span>
	      <input type="button" value="Calculo Duración" id="calculate" name="calculate" onclick='calcularFecha()'>                                                                
	      </span>
            </td>       
            <td><label for="fechafinconenio"><span style="color:red; font-size:9px">(*)</span>Fecha Fin:</label></td>
            <td><input type="text" name="fechafin" id="fechafin" title="Fecha Fin Convenion" maxlength="120" tabindex="5" placeholder="Fecha Fin" autocomplete="off" value="<?php echo $data['fechafin']?>" readonly/></td>
         </tr>                
        <tr>
            <td><label for="codigosnies">Código Snies:</label></td>
            <td><input type="text" name="codigosnies" id="codigosnies" title="Códigos Snies" maxlength="8" tabindex="10" placeholder="Códigos Snies" autocomplete="off" value="<?php echo $data['codigosnies']?>" /></td>            
            <td><label for="codigo_programa">Código del programa:</label> </td>
            <td>
                  <input type="text" name="codigo_programa" id="codigo_programa" title="Código del programa" tabindex="11" maxlength="8" placeholder="Código del programa" autocomplete="off" value="<?php echo $data['codigo_programa']?>" />
            </td>
        </tr>         
        <tr>
            <td><label for="numeroregcalificado">Número de la Resolución:</label> </td>
            <td><input type="text" name="numeroregcalificado" id="numeroregcalificado" title="Número Reg Calificado" tabindex="12" maxlength="60" placeholder="Número Reg Calificado" autocomplete="off" value="<?php echo $data['numeroregcalificado']?>" /></td>
            <td><label for="numeroregcalificadodos">Otro Número de Resolución:</label> </td>
            <td><input type="text" name="numeroregcalificadodos" id="numeroregcalificadodos" title="Otro Número Reg Calificado" tabindex="12" maxlength="60" placeholder="Otro Número Reg Calificado" autocomplete="off" value="<?php echo $data['numeroregcalificadodos']?>" /></td>
        </tr>
        
        <tr>
            <td><label for="idsiq_convenio">Convenio:</label> </td>            
            <td><textarea id="nom_convenio" name="nom_convenio" title="Convenio" tabindex="16" placeholder="Convenio" autocomplete="off" cols="30" readonly><?php echo $data2['nombreconvenio']?></textarea></td>
            <td><label for="idciudad">Ciudad:</label></td>
            <td>
                 <?php
                     $query_tipo_ciudad = "SELECT nombreciudad, idciudad FROM ciudad order by 1";
                     $reg_tipociudad = $db->Execute($query_tipo_ciudad);
                     echo $reg_tipociudad->GetMenu2('idciudad',$data['idciudad'],false,false,1,' tabindex="15" style="width:100px" ');
                ?>
            </td>
        </tr>               
    </tbody>
</table>
    </fieldset>   
        </form>
    </body>
</html>


