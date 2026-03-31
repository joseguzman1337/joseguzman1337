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
}

if($_REQUEST['idsiq_convenio']){    
    require_once '../class/ManagerEntity.php';
    $entity2 = new ManagerEntity("convenio");
    $entity2->sql_where = "idsiq_convenio = ".$_REQUEST['idsiq_convenio']."";
    //$entity->debug = true;
    $data2 = $entity2->getData();
    $data2 = $data2[0];
}

if(!empty($data['codigomodalidadacademica'])){    
    $entity6 = new ManagerEntity("modalidadacademica");
    $entity6->sql_where = "codigomodalidadacademica = ".$data['codigomodalidadacademica']."";
    $entity6->debug = true;
    $data6 = $entity6->getData();
    $data6 = $data6[0];
}

if(!empty($data['idsiq_especialidad'])){    
    $entity3 = new ManagerEntity("especialidad");
    $entity3->sql_where = "idsiq_especialidad = ".$data['idsiq_especialidad']."";
    $entity3->debug = true;
    $data3 = $entity3->getData();
    $data3 = $data3[0];
}

if(!empty($data['codigofacultad'])){    
    $entity4 = new ManagerEntity("facultad");
    $entity4->sql_where = " codigofacultad = ".$data['codigofacultad']."";
    $entity4->debug = true;
    $data4 = $entity4->getData();
    $data4 = $data4[0];
}

if(!empty($data['codigocarrera'])){    
    $entity5 = new ManagerEntity("carrera");
    $entity5->sql_where = "codigocarrera = ".$data['codigocarrera']."";
    $entity5->debug = true;
    $data5 = $entity5->getData();
    $data5 = $data5[0];
}
?>	
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
        

        <title>Convenios</title>  
        	<script>
	$(function() {
		$( "#fecharenovacion" ).datepicker({
			changeMonth: true,
			changeYear: true,
                        showOn: "button",
			buttonImage: "../css/themes/smoothness/images/calendar.gif",
			buttonImageOnly: true,
                        dateFormat: 'yy-mm-dd'
		});
                $( "#fechafinconenio" ).datepicker({
			changeMonth: true,
			changeYear: true,
                        showOn: "button",
			buttonImage: "../css/themes/smoothness/images/calendar.gif",
			buttonImageOnly: true,
                        dateFormat: 'yy-mm-dd'
		});
                $( "#fechaterminacion" ).datepicker({
			changeMonth: true,
			changeYear: true,
                        showOn: "button",
			buttonImage: "../css/themes/smoothness/images/calendar.gif",
			buttonImageOnly: true,
                        dateFormat: 'yy-mm-dd'
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
            <input type="hidden" name="idsiq_convenio" value="<?php echo $data2['idsiq_convenio']?>">
            <fieldset>
                <legend>Informaci&oacute;n del Detalle - Convenio</legend>
                
       <table border="0">
    <tbody>
        <tr>
            <td><label for="numeroconvenio">Número del Convenio:</label></td>
            <td><input type="text" name="numeroconvenio" id="numeroconvenio" title="Número del Convenio" maxlength="120" placeholder="Número del Convenio" autocomplete="off" value="<?php echo $data['numeroconvenio']?>" /></td>
            <td width="5%"></td>
            <td></td>
            <td>
        </tr>
        <tr>
            
            <td><label for="fecharenovacion">Fecha Renovación:</label></td>
            <td><input type="text" name="fecharenovacion" id="fecharenovacion" title="Fecha Renovación" maxlength="120" placeholder="Fecha Renovación" autocomplete="off" value="<?php echo $data['fecharenovacion']?>" /></td>
            <td></td>
            <td><label for="fechafinconenio">Fecha Fin Convenio:</label></td>
            <td><input type="text" name="fechafinconenio" id="fechafinconenio" title="Fecha Fin Convenion" maxlength="120" placeholder="Fecha Fin Convenio" autocomplete="off" value="<?php echo $data['fechafinconenio']?>" /></td>
                
         </tr>
        <tr>
            <td><label for="fechaterminacion">Fecha Terminación:</label></td>
            <td><input type="text" name="fechaterminacion" id="fechaterminacion" title="Fecha Terminación" maxlength="120" placeholder="Fecha Terminación" autocomplete="off" value="<?php echo $data['fechaterminacion']?>" /></td>
            <td></td>
            <td><label for="clausulaterminacion">Clausula Terminacion</label></td>
            <td>
                <textarea name="clausulaterminacion" cols="40" id="clausulaterminacion" placeholder="Clausula Terminación"><?php echo $data['clausulaterminacion']?></textarea>
            </td>
        </tr>
        <tr>
            <td><label for="renovacionautomatica">Renovación Automática</label></td>
            <td>
                <select name="renovacionautomatica" id="renovacionautomatica">
                   <option value="">-Seleccione-</option>
                   <option value="1" <?php if ($data['renovacionautomatica']=='1') echo "SELECTED" ?> >Si</option>
                   <option value="0" <?php if ($data['renovacionautomatica']=='0') echo "SELECTED" ?> >No</option>
                </select> 
            </td>
            <td></td>
            <td><label for="tienepoliza">Tiene Poliza?</label></td>
            <td>
                <select name="tienepoliza" id="tienepoliza">
                    <option value="">-Seleccione-</option>
                    <option value="1" <?php if ($data['tienepoliza']=='1') echo "SELECTED" ?> >Si</option>
                    <option value="0" <?php if ($data['tienepoliza']=='0') echo "SELECTED" ?> >No</option>
                </select>                 
            </td>
        </tr>
        <tr>
           <td><label for="afiliacionarp">Afiliación ARP:</label></td>
            <td>
                <select name="afiliacionarp" id="afiliacionarp">
                   <option value="">-Seleccione-</option>
                   <option value="1" <?php if ($data['afiliacionarp']=='1') echo "SELECTED" ?> >Si</option>
                   <option value="0" <?php if ($data['afiliacionarp']=='0') echo "SELECTED" ?> >No</option>
                </select> 
            </td>
            <td></td>
            <td><label for="afiliacionsss">Afiliación SSS:</label></td>
            <td>
                <select name="afiliacionsss" id="afiliacionsss">
                   <option value="">-Seleccione-</option>
                   <option value="1" <?php if ($data['afiliacionsss']=='1') echo "SELECTED" ?> >Si</option>
                   <option value="0" <?php if ($data['afiliacionsss']=='0') echo "SELECTED" ?> >No</option>
                </select> 
            </td>
        </tr>
        <tr>
            <td><label for="codigosnies">Código Snies:</label></td>
            <td><input type="text" name="codigosnies" id="codigosnies" title="Códigos Snies" maxlength="120" placeholder="Códigos Snies" autocomplete="off" value="<?php echo $data['codigosnies']?>" /></td>
            <td></td>
            <td><label for="nombreprograma">Nombre Programa:</label> </td>
            <td><input type="text" name="nombreprograma" id="nombreprograma" title="Nombre Programa" maxlength="120" placeholder="Nombre Programa" autocomplete="off" value="<?php echo $data['codigosnies']?>" /></td>
        </tr>
        <tr>
            <td><label for="numeroregcalificado">Número Reg Calificado:</label> </td>
            <td><input type="text" name="numeroregcalificado" id="numeroregcalificado" title="Número Reg Calificado" maxlength="120" placeholder="Número Reg Calificado" autocomplete="off" value="<?php echo $data['numeroregcalificado']?>" /></td>
            <td></td>
            <td><label for="nivel">Nivel:</label> </td>
            <td><input type="text" name="nivel" id="nivel" title="Nivel" maxlength="120" placeholder="Nivel" autocomplete="off" value="<?php echo $data['nivel']?>" /></td>
        </tr>
        <tr>
            <td><label for="aniosprograma">Años Programa:</label></td>
            <td><input type="text" name="aniosprograma" id="aniosprograma" title="Años Programa" maxlength="120" placeholder="Años Programa" autocomplete="off" value="<?php echo $data['aniosprograma']?>" /></td>
            <td></td>
            <td><label for="idciudad">Ciudad:</label></td>
            <td>
                 <?php
                     $query_tipo_ciudad = "SELECT nombreciudad, idciudad FROM ciudad order by 1";
                     $reg_tipociudad = $db->Execute ($query_tipo_ciudad);
                     echo $reg_tipociudad->GetMenu2('idciudad',$data['idciudad'],false,false,1,' ');
                ?>
            </td>
        </tr>
        <tr>
            <td><label for="idsiq_convenio">Convenio:</label> </td>
            <td><input type="text" name="nom_convenio" id="nom_convenio" title="Convenio" maxlength="120" placeholder="Convenio" autocomplete="off" readonly value="<?php echo $data2['nombreconvenio']?>" /></td>
            <td></td>
            <td><label for="codigoperiodo">Código Periodo:</label> </td>
            <td><?php
                     $query_tipo_periodo = "SELECT nombreperiodo, codigoperiodo FROM periodo order by 1";
                     $reg_tipoper = $db->Execute ($query_tipo_periodo);
                     echo $reg_tipoper->GetMenu2('codigoperiodo',$data['codigoperiodo'],false,false,1,' ');
                ?>
                </td>
            
        </tr>
        <tr>
            <td><label for="idsiq_estadoconvenio">Estado Convenio:</label> </td>
            <td>
                <?php
                     $query_estado_con = "SELECT nombreestado, idsiq_estadoconvenio FROM siq_estadoconvenio order by 1";
                     $reg_estadocon = $db->Execute ($query_estado_con);
                     echo $reg_estadocon->GetMenu2('idsiq_estadoconvenio',$data['idsiq_estadoconvenio'],false,false,1,' ');
                ?>
            <td></td>
            <td><label for="objetogeneralconvenio">Objeto General del Convenio:</label></td>
            <td><textarea name="objetogeneralconvenio" cols="40" id="objetogeneralconvenio" placeholder="Objeto General del Convenio"><?php echo $data['objetogeneralconvenio']?></textarea>
        </tr>
    </tbody>
</table>
    </fieldset>
        </form>
    </body>
</html>



