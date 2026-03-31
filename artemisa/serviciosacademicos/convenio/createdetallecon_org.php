<?php
//header( 'Content-type: text/html; charset=ISO-8859-1' );
//error_reporting(0);
require_once('../Connections/salasiq.php');

$rutaado = "../funciones/adodb/";
require_once('../Connections/salaado.php');

if($_REQUEST['id']){    
    require_once '../class/ManagerEntity.php';
    $entity = new ManagerEntity("detalle_convenio");
    $entity->sql_where = "idsiq_detalle_convenio = ".str_replace('row_','',$_REQUEST['id'])."";
    //$entity->debug = true;
    $data = $entity->getData();
    $data = $data[0];
    //print_r($data);
}
//echo $_REQUEST['idsiq_convenio'];
if($_REQUEST['idsiq_convenio']){    
    require_once '../class/ManagerEntity.php';
    $entity2 = new ManagerEntity("convenio");
    $entity2->sql_where = "idsiq_convenio = ".$_REQUEST['idsiq_convenio']."";
    $entity->debug = true;
    $data2 = $entity2->getData();
    $data2 = $data2[0];
   // print_r($data2);
}

?>	
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <title>Convenios</title>  
        <script>
        
        $.ajaxSetup({ cache:false });
        
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
                
                        function Popup(){ 
            if (window.showModalDialog) {
                var iddata = window.showModalDialog("lookupEspecialidad.php","name","dialogWidth:555px;dialogHeight:250px");
            } else {
            iddata = window.open('lookupEspecialidad.php','name','height=255,width=250,toolbar=no,directories=no,status=no,continued from previous linemenubar=no,scrollbars=no,resizable=no ,modal=yes');
            }
             $("#nombreespecilidad").val(iddata.value);
             $("#idsiq_especialidad").val(iddata.id);
            }

            $("#remotejsonp").click( function (){
                Popup();
                return false;            
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
            <input type="hidden" id="idsiq_especialidad" name="idsiq_especialidad" value="<?php echo $data['idsiq_especialidad']?>">
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
        <tr>
            <td><label for="id_siq_especialidades"><span style="color:red; font-size:9px">(*)</span>Especialidad:</label></td>
            <td>
               <input type="text" name="nombreespecilidad" id="nombreespecilidad" title="Especialidad" placeholder="Especialidad" tabindex="3" autocomplete="off" value="<?php echo $data2['id_siq_especialidades']?>" readonly/>
            </td>
               <td width="10%"><span><img id="remotejsonp" src="img/iconoLupa.png" width="15px" heigth="15px"/></span></td>
            
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
            <td><label for="afiliacionsss">Afiliación SSS:</label></td>
            <td>
                <input type="checkbox" name="afiliacionsss" id="afiliacionsss" title="Afiliación SSS" tabindex="9" placeholder="Afiliación SSS" autocomplete="off" value="1" <?php if($data['afiliacionsss']==1) echo "checked"; ?>  />
            </td>
        </tr>
        <tr>
            <td><label for="codigosnies">Código Snies:</label></td>
            <td><input type="text" name="codigosnies" id="codigosnies" title="Códigos Snies" maxlength="120" tabindex="10" placeholder="Códigos Snies" autocomplete="off" value="<?php echo $data['codigosnies']?>" /></td>
            <td></td>
            <td><label for="nombreprograma">Nombre Programa:</label> </td>
            <td><input type="text" name="nombreprograma" id="nombreprograma" title="Nombre Programa" tabindex="11" maxlength="120" placeholder="Nombre Programa" autocomplete="off" value="<?php echo $data['codigosnies']?>" /></td>
        </tr>
        <tr>
            <td><label for="numeroregcalificado">Número Reg Calificado:</label> </td>
            <td><input type="text" name="numeroregcalificado" id="numeroregcalificado" title="Número Reg Calificado" tabindex="12" maxlength="120" placeholder="Número Reg Calificado" autocomplete="off" value="<?php echo $data['numeroregcalificado']?>" /></td>
            <td></td>
            <td><label for="nivel">Nivel:</label> </td>
            <td><input type="text" name="nivel" id="nivel" title="Nivel" maxlength="120" placeholder="Nivel" tabindex="13" autocomplete="off" value="<?php echo $data['nivel']?>" /></td>
        </tr>
        <tr>
            <td><label for="aniosprograma">Años Programa:</label></td>
            <td><input type="text" name="aniosprograma" id="aniosprograma" title="Años Programa" maxlength="120" tabindex="14" placeholder="Años Programa" autocomplete="off" value="<?php echo $data['aniosprograma']?>" /></td>
            <td></td>
            <td><label for="idciudad">Ciudad:</label></td>
            <td>
                 <?php
                     $query_tipo_ciudad = "SELECT nombreciudad, idciudad FROM ciudad order by 1";
                     $reg_tipociudad = $db->Execute($query_tipo_ciudad);
                     echo $reg_tipociudad->GetMenu2('idciudad',$data['idciudad'],false,false,1,' tabindex="15" ');
                ?>
            </td>
        </tr>
        <tr>
            <td><label for="idsiq_convenio">Convenio:</label> </td>
            <td><input type="text" name="nom_convenio" id="nom_convenio" title="Convenio" maxlength="120" tabindex="16" placeholder="Convenio" autocomplete="off" readonly value="<?php echo $data2['nombreconvenio']?>" /></td>
            <td></td>
            <td><label for="codigoperiodo">Periodo Académico:</label> </td>
            <td><?php
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
            <span style="color:red; font-size:9px">* Son campos obligatorios</span>
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


