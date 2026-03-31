<?php
/*ini_set('display_errors','On'); ini_set('xdebug.max_nesting_level', 500);*/
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
        
    require_once('../../../../Connections/sala2.php');  $rutaado = "../../../../funciones/adodb/";
    require_once('../../../../Connections/salaado.php');
    require_once('guardacontenidoprograma.php');

    $fechahoy=date("Y-m-d H:i:s");
    $periodo_sql = "select codigoperiodo from periodo where codigoestadoperiodo = 1;";
    $periodo_rst = $db->GetRow($periodo_sql);
    
    $query_tipo_usuario ="SELECT u.idusuario,concat(u.apellidos,' ',u.nombres) as nombre, u.codigorol,u.numerodocumento FROM usuario u WHERE u.usuario='".$_SESSION['MM_Username']."'";
    $row_tipo_usuario = $db->GetRow($query_tipo_usuario);
    
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" href="../../../../estilos/sala.css" type="text/css">
<title>Contenido Programatico</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<!-- TinyMCE -->
<!--<script type="text/javascript" src="../../js/jquery.js"></script>-->
<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>-->
<link rel="stylesheet" href="../../../../mgi/js/jquery_ui/css/jquery-ui.css">
<style>
.ui-widget-header .ui-icon {
	background-image:url("../../../../mgi/js/jquery_ui/css/ui-lightness/images/ui-icons_222222_256x240.png");
}
</style>
<script src="../../../../mgi/js/jquery.min.js"></script>
<script src="../../../../mgi/js/jquery_ui/js/jquery-ui.js"></script>
<script type="text/javascript" src="jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
    
    function myCustomExecCommandHandler(editor_id, elm, command, user_interface, value) {                
                switch (command) {
                case "mceInsertContent":                    
                        break;
                case "mceNewDocument":
                    if(confirm('Esta Seguro de generar un formato en blanco?')){
                        var formatGeneral;
                        if (editor_id == 'observacion200'){
                            formatGeneral ='';
                            formatGeneral +='<table border="1" cellspacing="0" cellpadding="0">';
                            formatGeneral +='<tbody><tr valign="TOP" bgcolor="#d9d9d9"><td colspan="2"><p align="RIGHT">EQUIPO DOCENTE</p></td>';
                            formatGeneral +='<td><p align="CENTER">NOMBRE</p></td>';
                            formatGeneral +='<td><p align="CENTER">ESCALAF&Oacute;N DOCENTE</p></td>';
                            formatGeneral +='<td><p align="CENTER">CORREO ELECTR&Oacute;NICO</p></td>';
                            formatGeneral +='<td><p align="CENTER">ATENCI&Oacute;N A ESTUDIANTES (Lugar - D&iacute;a &ndash; Hora)</p></td>';
                            formatGeneral +='</tr><tr valign="TOP"><td colspan="2"><p align="RIGHT">Coordinador(es)</p></td>';
                            formatGeneral1 ='<td><p align="CENTER">&nbsp;</p></td>';
                            formatGeneral1 +='<td><p align="CENTER">&nbsp;</p></td>';
                            formatGeneral1 +='<td><p align="CENTER">&nbsp;</p></td>';
                            formatGeneral1 +='<td><p align="CENTER">&nbsp;</p></td>';
                            formatGeneral += formatGeneral1;
                            formatGeneral +='</tr><tr valign="TOP"><td colspan="2"><p align="RIGHT">Docente(s)</p></td>';
                            formatGeneral += formatGeneral1;
                            formatGeneral +='</tr><tr valign="TOP"><td colspan="2"><p align="RIGHT">Docente(s) laboratorio</p></td>';
                            formatGeneral += formatGeneral1;
                            formatGeneral +='</tr><tr valign="TOP"><td colspan="2"><p align="RIGHT">Asesor(es)</p></td>';
                            formatGeneral += formatGeneral1;
                            formatGeneral +='</tr><tr valign="TOP"><td colspan="2"><p align="RIGHT">Estudiante &ndash; Monitor Ad Honorem</p></td>';
                            formatGeneral += formatGeneral1;
                            formatGeneral +='</tr></tbody></table>';
                        }

                        if (editor_id == 'observacion100'){
                            formatGeneral ='<p><strong>1.Justificaci&oacute;n</strong></p>';
                            formatGeneral +='<table style="width: 100%;" border="1" cellspacing="0"><tbody><tr><td>';
                            formatGeneral +='';
                            formatGeneral +='</td></tr></tbody></table><p><strong>2.Contenidos Generales</strong></p>';
                            formatGeneral +='<table style="width: 100%;" border="1" cellspacing="0">';
                            formatGeneral +='<tbody><tr><td>';
                            formatGeneral +='<p>&nbsp;</p>';
                            formatGeneral +='</td></tr></tbody></table><p><strong>3.Objetivos de Aprendizaje</strong></p><table style="width: 100%;" border="1" cellspacing="0">';
                            formatGeneral +='<tbody><tr><td>';                            
                            formatGeneral +='<table style="width: 100%;" border="1" cellspacing="0">';
                            formatGeneral +='<tbody>';
                            formatGeneral +='<tr bgcolor="#d9d9d9"><td width="30%"><p align="RIGHT"><strong>Dimensi&oacute;n de aprendizaje significativo</strong></p></td>';
                            formatGeneral +='<td width="70%"><p><strong>Objetivos de aprendizaje</strong></p><p><strong>Los estudiantes</strong></p></td></tr>';
                            formatGeneral +='<tr><td><p align="RIGHT">Conocimiento fundamental</p></td><td><p>&nbsp;</p></td></tr>';
                            formatGeneral +='<tr><td><p align="RIGHT">Aplicaci&oacute;n</p></td><td><p>&nbsp;</p></td></tr>';
                            formatGeneral +='<tr><td><p align="RIGHT">Integraci&oacute;n</p></td><td><p>&nbsp;</p></td></tr>';
                            formatGeneral +='<tr><td><p align="RIGHT">Dimensi&oacute;n humana</p></td><td><p>&nbsp;</p></td></tr>';
                            formatGeneral +='<tr><td><p align="RIGHT">Compromiso</p></td><td><p>&nbsp;</p></td></tr>';
                            formatGeneral +='<tr><td><p align="RIGHT">Aprender a aprender</p></td><td><p>&nbsp;</p></td></tr>';
                            formatGeneral +='</tbody></table></td></tr></tbody></table>';
                        }

                         if(editor_id == 'elm1'){                             
                             formatGeneral = '<p><span><strong>4.Actividades de Aprendizaje</strong></span></p>';
                             formatGeneral += '<table style="width: 100%;" border="1" cellspacing="0"><tbody><tr><td>';
                             formatGeneral += '<p>&nbsp;</p></td></tr></tbody></table>';
                             formatGeneral += '<p><span><strong>5.Evaluaci&oacute;n y calificaci&oacute;n</strong></span></p>';
                             formatGeneral += '<table style="width: 100%;" border="1" cellspacing="0"><tbody><tr><td>';
                             formatGeneral += '<p><span>&nbsp;</span></p>';
                             formatGeneral += '</td></tr></tbody></table>';
                             formatGeneral += '<p><span><strong>6.Cronograma</strong></span></p>';
                             formatGeneral += '<table style="width: 100%;" border="1" cellspacing="0"><tbody><tr>';
                             formatGeneral += '<td><p><span>&nbsp;</span></p></td>';
                             formatGeneral += '</tr></tbody></table>';
                             formatGeneral += '<p><span>&nbsp;</span></p>';
                             formatGeneral += '<table style="width: 100%;" border="1" cellspacing="0" cellpadding="1">';
                             formatGeneral += '<tbody><tr><td bgcolor="#d9d9d9"><p><span><strong>Sesi&oacute;n</strong></span></p>';
                             formatGeneral += '</td><td bgcolor="#d9d9d9"><p><span><strong>Actividades Independiente de Aprendizaje</strong></span></p>';
                             formatGeneral += '</td><td bgcolor="#d9d9d9"><p><span><strong>Actividades Presenciales de Aprendizaje</strong></span></p>';
                             formatGeneral += '</td><td bgcolor="#d9d9d9"><p><span><strong>Tema</strong></span></p>';
                             formatGeneral += '</td></tr>';
                             var formatGeneral1 = '<tr><td><p><span style="font-size: medium;">&nbsp;</span></p></td><td><p><span style="font-size: medium;">&nbsp;</span></p></td><td><p><span style="font-size: medium;">&nbsp;</span></p></td><td><p><span style="font-size: medium;">&nbsp;</span></p></td></tr>';
                             formatGeneral += formatGeneral1 + formatGeneral1+ formatGeneral1 +formatGeneral1+ formatGeneral1;
                             formatGeneral += formatGeneral1 + formatGeneral1+ formatGeneral1 +formatGeneral1+ formatGeneral1;
                             formatGeneral += formatGeneral1 + formatGeneral1+ formatGeneral1 +formatGeneral1+ formatGeneral1;                             
                             formatGeneral += '</tbody></table>';                             
                            formatGeneral += '<p><span>&nbsp;</span></p>';
                            formatGeneral += '<p><span><strong>7.Bibliograf&iacute;a B&aacute;sica y Complementaria</strong></span></p>';
                            formatGeneral += '<table style="width: 100%;" border="1" cellspacing="0"><tbody><tr><td>';                            
                            formatGeneral += '<p>&nbsp;</p>';                            
                            formatGeneral += '</td></tr></tbody></table>';                            
                            }
                            tinyMCE.getInstanceById(editor_id).setContent('');
                                tinyMCE.getInstanceById(editor_id).execCommand('mceReplaceContent',false,formatGeneral);
                            alert('la informacion de General ha sido actualizada');
                        }
                return true;
                }
            return false; // Pass to next handler in chain
            }
	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
                skin : "o2k7",
		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups,autosave",
                language : 'es',
		// Theme options
		theme_advanced_buttons1 : "save,newdocument,help,|,cut,copy,paste,pastetext,pasteword,|,search,replace,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,",
		theme_advanced_buttons2 : "bullist,numlist,removeformat,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,code,|,insertdate,inserttime,preview,|,forecolor,backcolor,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,restoredraft",
		//theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		//theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft,visualblocks",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		content_css : "css/word.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",
                execcommand_callback : "myCustomExecCommandHandler",

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		},
                save_onsavecallback : "mysave",
                restore_content : "Guardar contenido autom/u00E1ticamente",
                plugin_preview_pageurl : 'toPdf.php?codigomateria=<?PHP echo $_REQUEST['codigomateria']?>&periodosesion=<?PHP echo $periodo_rst['codigoperiodo']?>&usuariosesion=<?PHP echo  $_SESSION['MM_Username']?>'
	});
        function mysave(){
            update_module_content();
        }
        function help(id){
             tinyMCE.getInstanceById(id).execCommand('mceHelp',false);            
        }
		function enviar(form){
			form.method = "POST";
			form.action = "plantillaWord/generarplantilla.php";
			form.submit();
		}
		
</script>
<!-- /TinyMCE -->

</head>
<body>
        <form name="form1" id="form1"  method="POST" action="" enctype="multipart/form-data">
            <input type="hidden" name="guardar_data" value="si">
            <table width="70%"  border="1"  cellpadding="3" cellspacing="3">
                <TR >
                    <td colspan="8" align="center"><img src="../../../../../imagenes/syllabus_institucional.jpg" ></td>
                </TR>
                <?php
                $query_materias="select m.codigomateria, m.nombremateria
                from materia m,grupo g
                where
                g.codigomateria=m.codigomateria
                and g.codigoperiodo='".$periodo_rst['codigoperiodo']."'
                and g.numerodocumento='".$row_tipo_usuario['numerodocumento']."'
		and g.codigoestadogrupo like '1%'
                group by codigomateria
                order by 1, 2";
                $materias = $db->Execute ($query_materias) or die("$query_materias".mysql_error());
                $total_Rows_materias = $materias->RecordCount();
				$arrayPlantilla = array();
                ?>
                
                <tr align="left" >
                    <TD id="tdtitulogris">Asignaturas
                    </TD>
                    <TD align="left" colspan="7" >
                        <select name="codigomateria" onchange="recarga()">
                            <option value="">Seleccionar
                            </option>
                            <?php while ($row_materias = $materias->FetchRow()) { ?>
                            <option value="<?php echo $row_materias['codigomateria']?>"
                                <?php if ($row_materias['codigomateria']==$_REQUEST['codigomateria']) {
                                                echo "Selected";
												$arrayPlantilla["nombremateria"]=$row_materias['nombremateria'];
                                            }?>>
                                <?php echo $row_materias['nombremateria'];
                                ?>
                            </option>
                            <?php
                            }
                            ?>
                        </select>
                    </TD>
                </tr>
                    <?php
                    if(isset($_REQUEST['codigomateria'])&& $_REQUEST['codigomateria']!=""){
            $query_pertenecemateria="SELECT m.codigomateria
			,m.nombremateria
			, m.numerohorassemanales
			, m.numerosemana
			, c.nombrecarrera
			, f.nombrefacultad
			, t.nombretipomateria
			, t.codigotipomateria
			, p.nombreplanestudio
			, p.idplanestudio
			, coalesce(d.numerocreditosdetalleplanestudio,m.numerocreditos) as numerocreditosdetalleplanestudio
			, d.semestredetalleplanestudio
			, m.porcentajeteoricamateria
			, m.porcentajepracticamateria
			FROM materia m
			left join detalleplanestudio d on m.codigomateria=d.codigomateria 
			left join planestudio p on d.idplanestudio = p.idplanestudio and p.codigoestadoplanestudio = '100' and p.codigocarrera = (select codigocarrera from materia where codigomateria='".$_REQUEST['codigomateria']."') 
			, carrera c
			, facultad f
			, tipomateria t
			where m.codigomateria='".$_REQUEST['codigomateria']."' 
			and m.codigocarrera=c.codigocarrera 
			and c.codigofacultad=f.codigofacultad 
			and m.codigotipomateria=t.codigotipomateria 
			group by semestredetalleplanestudio";
                        $pertenecemateria = $db->Execute ($query_pertenecemateria) or die("$query_pertenecemateria".mysql_error());
                        $total_Rows_pertenecemateria = $pertenecemateria->RecordCount();
                        $row_pertenecemateria=$pertenecemateria->FetchRow();
                        $horaspresencialessemestre=$row_pertenecemateria['numerohorassemanales']*$row_pertenecemateria['numerosemana'];
                        $horastotales= 48 * $row_pertenecemateria['numerocreditosdetalleplanestudio'];
                        $horastrabajoindependiente=$row_pertenecemateria['numerohorassemanales']*2;
						
                        if($total_Rows_pertenecemateria !=""){
                        ?>
                   <tr id="trtitulogris" align="left" >
                        <TD >Facultad</TD>
                        <TD align="left" colspan="7"><?php $arrayPlantilla["nombrefacultad"]=$row_pertenecemateria['nombrefacultad']; echo $row_pertenecemateria['nombrefacultad']; ?></TD>
                    </tr>
					
                    <tr id="trtitulogris" align="left" >
                        <TD id="tdtitulogris">Programa</TD>
                        <TD align="left" colspan="7"><?php $arrayPlantilla["nombrecarrera"]=$row_pertenecemateria['nombrecarrera'];  echo $row_pertenecemateria['nombrecarrera']; ?></TD>
                    </tr>
					
                    <tr id="trtitulogris" align="left" >
                        <TD id="tdtitulogris">C&oacute;digo Asignatura</TD>
                        <TD align="left" ><?php $arrayPlantilla["codigomateria"]=$row_pertenecemateria['codigomateria']; echo $row_pertenecemateria['codigomateria']; ?></TD>
                        <TD id="tdtitulogris">Periodo</TD>
                        <TD align="left" colspan="2"><?php $arrayPlantilla["codigoperiodo"]=$periodo_rst['codigoperiodo']; echo $periodo_rst['codigoperiodo']; ?></TD>
                        <TD id="tdtitulogris" colspan="2">Semestre al que corresponde la asignatura:</TD>
                        <TD align="left">
                        <?php
                        $z=0;
                        //do{
                            if($z==0)
                            { $sem.=$row_pertenecemateria['semestredetalleplanestudio'];}
                            else{
                            $sem.="; ".$row_pertenecemateria['semestredetalleplanestudio'];}
                        //    $z++;
                        //}while ($row_pertenecemateria = $pertenecemateria->FetchRow());
                        echo $sem;
						$arrayPlantilla["semestre"]=$sem;
                        ?>
                        </TD>
                    </tr>                    
                    <tr id="trtitulogris" align="left" >
                        
                        <TD id="tdtitulogris">Tipo Asignatura</TD>
                        <TD align="left" colspan="7" >
                            Obligatoria <input name="1" type="checkbox" <?php if($row_pertenecemateria['codigotipomateria']<=3){ echo "checked"; $obli="1";} ?> disabled>
                            
                            &nbsp;Electiva<input name="2" type="checkbox" <?php if($row_pertenecemateria['codigotipomateria']>=4){ echo "checked" ; $obli="2";} ?> disabled>
                        </TD>
                    </tr>
                    <tr id="trtitulogris" align="left" >
                        <TD colspan="1" id="tdtitulogris">Modalidad %</TD>
                        <TD  id="tdtitulogris" width="20%">Te&oacute;rica</TD>
                        <TD  id="tdtitulogris" width="5%"><?php $arrayPlantilla["tipomateria"]=$obli;
						$arrayPlantilla['porcentajeteoricamateria']=$row_pertenecemateria['porcentajeteoricamateria']; echo $row_pertenecemateria['porcentajeteoricamateria']; ?></TD>
                        <TD  id="tdtitulogris" >Pr&aacute;ctica</TD>
                        <TD  id="tdtitulogris" width="5%"><?php $arrayPlantilla["porcentajepracticamateria"] = $row_pertenecemateria['porcentajepracticamateria'];echo $row_pertenecemateria['porcentajepracticamateria']; ?></TD>
                        <TD  id="tdtitulogris" colspan="2" >Te&oacute;rica-Pr&aacute;ctica</TD>
                        <TD  id="tdtitulogris" width="5%">0</TD>
                    </tr>
                   <tr id="trtitulogris" align="left" >
                        <TD id="tdtitulogris">Pre-requisitos</TD>
                        <TD align="left" colspan="7">
                        <?php
                        /*
                         * Este query selecciona las materias que son prerequisito, trae las materias prerequisito
                         * en los distintos planes de estudio.
                         */
                        $query_planestudio="SELECT m.codigomateria,m.nombremateria, m.numerohorassemanales,
                        d.numerocreditosdetalleplanestudio, d.semestredetalleplanestudio, p.idplanestudio
                        FROM materia m, detalleplanestudio d, planestudio p
                        where
                        m.codigomateria='".$_REQUEST['codigomateria']."'
                        and m.codigomateria=d.codigomateria
                        and p.codigoestadoplanestudio = '100'
                        and d.idplanestudio = p.idplanestudio";
                        $planestudio = $db->Execute ($query_planestudio) or die("$query_pertenecemateria".mysql_error());
                        $total_Rows_planestudio = $planestudio->RecordCount();
                        
                        $i=0;
                        while ($row_planestudio = $planestudio->FetchRow()){
                        if($i==0)
                        { $idplanes.=$row_planestudio['idplanestudio'];}
                        else{
                        $idplanes.=",".$row_planestudio['idplanestudio'];}
                        $i++;                        
                        }
                        $idplanes = "";
                        if($idplanes == "")$idplanes =0;
                        //echo $idplanes;
                        $query_prerequisitos="select distinct codigomateriareferenciaplanestudio,nombremateria 
                            from referenciaplanestudio r inner join materia m on r.codigomateriareferenciaplanestudio = m.codigomateria
                            where codigotiporeferenciaplanestudio = 100 
                            and r.codigomateria = '".$_REQUEST['codigomateria']."';";
                        $prerequisitos = $db->Execute ($query_prerequisitos) or die("$query_prerequisitos".mysql_error());
                        $total_Rows_prerequisitos= $prerequisitos->RecordCount();
                        if($total_Rows_prerequisitos == 0){
                            echo "&nbsp;";
                        }
                        else{
                            $j=0;
                            while ($row_prerequisitos= $prerequisitos->FetchRow()){
                            if($j==0){
                                $nombrepre.=$row_prerequisitos['codigomateriareferenciaplanestudio']."-".$row_prerequisitos['nombremateria'];
                           }else{
                                $nombrepre.=", ".$row_prerequisitos['codigomateriareferenciaplanestudio']."-".$row_prerequisitos['nombremateria'];}
                                $j++;
                            }
                            echo $nombrepre;
							$arrayPlantilla["prerequisito"] = $nombrepre;
                        }
                        ?></TD>
                    </tr>
                    <tr id="trtitulogris" align="left" >
                        <td id="tdtitulogris">Co-requisitos</td>
                        <td align="left" colspan="7">
                          <?php
                         $query_corequisitos="select distinct codigomateriareferenciaplanestudio,nombremateria 
                            from referenciaplanestudio r inner join materia m on r.codigomateriareferenciaplanestudio = m.codigomateria
                            where codigotiporeferenciaplanestudio in(200,201) 
                            and r.codigomateria = '".$_REQUEST['codigomateria']."'";
                        $corequisitos = $db->Execute ($query_corequisitos) or die("$query_corequisitos".mysql_error());
                        $total_Rows_corequisitos= $corequisitos->RecordCount();
                        if($total_Rows_corequisitos == 0){
                            echo "&nbsp;";
                        }
                        else{
                            $k=0;
                            while ($row_corequisitos= $corequisitos->FetchRow()){
                            if($k==0)
                            { $nombreco.=$row_corequisitos['codigomateriareferenciaplanestudio']."-".$row_corequisitos['nombremateria'];}
                            else{
                            $nombreco.=", ".$row_corequisitos['codigomateriareferenciaplanestudio']."-".$row_corequisitos['nombremateria'];}
                            $k++;
                            }
                            echo $nombreco;
							$arrayPlantilla["corequisitos"] =$nombreco;
                        }
                        ?>

                        </td>
                    <tr id="trtitulogris" align="left" >
                        <td id="tdtitulogris">N&uacute;mero de Cr&eacute;ditos</td>
                        <td align="left" ><?php $arrayPlantilla["numerocreditosdetalleplanestudio"] = $row_pertenecemateria['numerocreditosdetalleplanestudio']; echo $row_pertenecemateria['numerocreditosdetalleplanestudio']; ?></td>
                        <td id="tdtitulogris" width="" colspan="2">Horas presenciales o sincrónicas /semana</td>
                        <td align="left" width=""  ><?php  $arrayPlantilla["numerohorassemanales"] = $row_pertenecemateria['numerohorassemanales']; echo $row_pertenecemateria['numerohorassemanales']; ?></td>
                        <td id="tdtitulogris" colspan="2">Horas presenciales o sincrónicas/semestre</td>
                        <td align="left" width="" ><?php $arrayPlantilla["horaspresencialessemestre"] = $horaspresencialessemestre;echo $horaspresencialessemestre; ?></td>
                    <?php
					
                    $query_registros="SELECT c.idcontenidoprogramatico, c.urlcontenidoprogramatico,
                    c.urlactividadescontenidoprogramatico, c.urlaarchivofinalcontenidoprogramatico,c.codigoperiodo,c.urlasyllabuscontenidoprogramatico,
                    c.horastrabajoindependiente
                    FROM contenidoprogramatico  c inner join periodo p on c.codigoperiodo = p.codigoperiodo
                    where c.codigomateria = '".$_REQUEST['codigomateria']."'
                    and p.codigoestadoperiodo = 1
                    and c.codigoestado like '1%'
		    order by fechainiciocontenidoprogramatico desc
		    limit 1";
                    $registros = $db->Execute ($query_registros) or die("$query_registros".mysql_error());
                    $total_Rows_registros= $registros->RecordCount();
                    $row_registros = $registros->FetchRow();
                    $idcontenidoprogramatico=$row_registros['idcontenidoprogramatico'];
                    /* crear el contenido programatico para el periodo*/
                    /*if(!$idcontenidoprogramatico){
                        $query_fechaperiodo = "SELECT codigoperiodo, fechainicioperiodo, fechavencimientoperiodo
                            FROM periodo
                            where codigoperiodo = '".$periodo_rst['codigoperiodo']."' ";
                            $fechaperiodo = $db->Execute ($query_fechaperiodo) or die("$query_fechaperiodo".mysql_error());
                            $total_Rows_fechaperiodo = $fechaperiodo->RecordCount();
                            $row_fechaperiodo = $fechaperiodo->FetchRow();                            
                            $db->Execute ("INSERT INTO contenidoprogramatico (`codigomateria`, `codigoperiodo`,`fechainiciocontenidoprogramatico`, `fechafincontenidoprogramatico`, `codigoestado`) VALUES (".$_REQUEST['codigomateria'].", '".$periodo_rst['codigoperiodo']."','".$row_fechaperiodo['fechainicioperiodo']."','".$row_fechaperiodo['fechavencimientoperiodo']."', '100');") or die(mysql_error());
                    }*/
                    $registros = $db->Execute ($query_registros) or die("$query_registros".mysql_error());
                    $total_Rows_registros= $registros->RecordCount();
                    $row_registros = $registros->FetchRow();
                    $idcontenidoprogramatico=$row_registros['idcontenidoprogramatico'];
                    echo "</tr>";
                    echo "<tr id='trtitulogris'><td></td><td colspan=3 align='center'>Horas Trabajo Independiente /periodo académico</td><td><input type=text name=horastrabajoindependiente size=2 maxlength=3  value=".$row_registros['horastrabajoindependiente']."></td><td colspan=3></td></tr>";
                    echo "</table>";
                    echo "<p>Diligencie la información que se encuentra desde la siguiente tabla en adelante. Se debe registrar la información en
formato de letra ARIAL 9, sin realizar modificaciones al mismo o agregar tablas adicionales. </p>";
                    //echo "<br><br>";
                    echo "<input type=hidden id='idcontenidoprogramatico' name='idcontenidoprogramatico' value='".$idcontenidoprogramatico."'>";
		      
		     // if($query_registros_anteror->RecordCount()>0){  ?>
			  
				<input type="hidden" name="arrayPlantilla2" id="arrayPlantilla2" value="<?php echo base64_encode(serialize($arrayPlantilla)) ?>"/>
				<div id="enlacesSyllabus" style="font-size:1.2em;margin:10px 0 30px;display:inline-block;width:70%">
					<a href="javascript:enviar(form1);">Descargar Formato Institucional de Asignaturas</a>
                    <!-- Caso 91192
                     * @modified Luis Dario Gualteros 
                     * <castroluisd@unbosque.edu.co>
                     * Se modifica el enlace con un nuevo Instructivo para el cargue de los Contenidos Prográmaticos
                     * y el de diligenciamineto del formato de las materias.     
                     * @since  Junio 22, 2017
                    -->
					| <a href='InstructivoDiligenciar.pdf' target="_blank" style="margin-left:10px;text-decoration:none">Instructivo para diligenciar el Formato</a>
                    | <a href='ManualCargaDocumento.pdf' target="_blank" style="margin-left:10px;text-decoration:none">Manual para el cargue del Documento</a>
                    <!--End Caso 91192-->
						<div style="float:right;">
							<a href="javascript:mostrarayuda()" style="text-decoration: none; color: #004c00;position:relative;top:-10px;">Ayuda <img src="../../../../mgi/images/help.png" width="25" style="position:relative;top:7px"/></a>
						</div>
						<div id="dialog" title="Ayuda" style="display:none;">
						  <p>El proceso para el cargue del syllabus al sistema es el siguiente:</p>
						  <ol>
							<li>Descargue el Formato Institucional de Asignaturas: este es el formato que debe diligenciar.</li>
							<li>Descargue el Instructivo Formato de Asignaturas: este es el instructivo para diligenciar el formato.</li>
							<li>Presentar el formato diligenciado en la facultad para aprobación.</li>
							<li>Cargar Formato Para la Asignatura: hacer clic en examinar y buscar el archivo en PDF con el formato diligenciado.
							<p>Nota: La justificación, el contenido general y los objetivos de aprendizaje deben ocupar máximo 2 páginas</p></li>
						  </ol>
						</div>
				</div>
				<table width="70%">
					<tr>
						<td><span style="margin-right:10px;font-size:1.2em">Formato Para la Asignatura (PDF)</span>
						<input type="file" name="archivo" id="archivo" style="font-size:1.2em"/></td>
					</tr>
					<tr>
						<td>
						<input type="hidden" name="usuario" id="usuario" value="<?php echo $_SESSION['MM_Username'] ?>"/>
						<input type="hidden" name="periodo" id="periodo" value="<?php echo $periodo_rst['codigoperiodo'] ?>"/>
						<input type="hidden" name="codigomateria" id="codigomateria" value="<?php echo $arrayPlantilla["codigomateria"] ?>"/>
						<input type="button" class="boton" onclick="guardarDocumento()" id="cargarDocumento" name="cargarDocumento" value="Cargar Documento" style="cursor:pointer;margin-left:220px;border-radius: 8px;background-color:#e58600;font-size:12px;text-shadow:none;"/></td>
					</tr>
				</table>
                        
				<div id="titulo_div" style="text-align:center;width:70%;border-top:1px solid #ccc;padding-top:10px;font-size:1.2em;margin-bottom:10px;margin-top:12px;">
				    <a href="javascript:mostrardetalle()">Ver informaci&oacute;n de Periodos Anteriores</a>
				</div>
				<?php 
                 $query_registros_anteror="SELECT * FROM contenidoprogramatico c where c.codigomateria = '".$_REQUEST['codigomateria']."' and c.codigoestado like '1%' GROUP BY c.codigoperiodo desc";                             
                //echo $query_registros_anteror;
                $query_registros_anteror = $db->Execute ($query_registros_anteror) or die("$query_registros_anteror".mysql_error());
                 
                echo '<table id=tabladetalle width="70%"  border="1"  cellpadding="3" cellspacing="3" style="display:none">';     
                echo "<tr><th>Periodo</th><th>Usuario</th><th>Syllabus</th><th>Contenido del Programa</td></tr>";
                while ($query_registros_anteror_row = $query_registros_anteror->FetchRow()) 
                {
                    echo "<tr><td>".$query_registros_anteror_row["codigoperiodo"]."</td>";                    
                    echo "<td>".$query_registros_anteror_row["usuario"]."</td>"; 
                    if($query_registros_anteror_row['urlcontenidoprogramatico'])
                    {
                        echo "<td><a href='contenidoprogramatico/".$query_registros_anteror_row["urlasyllabuscontenidoprogramatico"]."' target='_blank' >Ver Documento</a></td>";
                        echo "<td><a href='contenidoprogramatico/".$query_registros_anteror_row["urlaarchivofinalcontenidoprogramatico"]."' target='_blank' >Ver Documento</a></td>";
                    }else
                    {
                        $sqldetalle = "select iddetallecontenidoprogramatico from detallecontenidoprogramatico WHERE idcontenidoprogramatico ='".$query_registros_anteror_row["idcontenidoprogramatico"]."' limit 1";
                        $sqlDetalles = $db->Execute ($sqldetalle) or die("$sqldetalle".mysql_error());
                        $sqlDetallesdatos = $sqlDetalles->FetchRow();            
                        if($sqlDetallesdatos['iddetallecontenidoprogramatico'])
                        {
                           echo "<td><a href='toPdf.php?codigomateria=".$_REQUEST['codigomateria']."&type=1&periodosesion=".$query_registros_anteror_row["codigoperiodo"]."&usuariosesion=".$_SESSION['MM_Username']."' target='_blank' title='Syllabus' >Ver Documento</a></td>";
                           echo "<td><a href='toPdf.php?codigomateria=".$_REQUEST['codigomateria']."&type=2&periodosesion=".$query_registros_anteror_row["codigoperiodo"]."&usuariosesion=".$_SESSION['MM_Username']."' target='_blank' title='Asignatura'>Ver Documento</a></td></tr>";
                        }else
                        {
                            echo "<td>Documento no Adjunto</td>";
                            echo "<td>Documento no Adjunto</td></tr>";
                        }
                    }//else
                }//while
                echo "</table>";
			//}
                    
                    $query_registros_select="SELECT c.codigoperiodo,c.idcontenidoprogramatico FROM contenidoprogramatico c
                        where c.codigomateria = '".$_REQUEST['codigomateria']."'
                        and c.codigoestado like '1%'
                        order by fechainiciocontenidoprogramatico desc
                        limit 1";
                        $registros_select = $db->Execute ($query_registros_select) or die("$query_registros_select".mysql_error());
                        if($total_Rows_registros==0){
                            $selectotion2 = "Seleccione aqui para traer la informacion del periodo anterior";
                        }else{
                                $selectotion2 = "Presione aqui para traer la informacion del periodo anterior";
                        }
                        if($registros_select->RecordCount()>0){
                            $selectotion = $registros_select->GetMenu('codigoperiodo','Seleccione',true,false,0,'ONCHANGE="update_module_sig(this)" id=select');
                        }
						
						$selectotion2 = $selectotion2.$selectotion;
                        echo "<div style='display:none;'>".$selectotion2."";
                        echo "</div>";
						
             
                    if($total_Rows_registros ==""){
                        $query_tipocontenido="SELECT codigotipodetallecontenidoprogramatico, nombretipodetallecontenidoprogramatico
                        FROM tipodetallecontenidoprogramatico
                        where codigoestado like '1%' and codigotipodetallecontenidoprogramatico in(100,200)";
                        $tipocontenido = $db->Execute ($query_tipocontenido) or die("$query_tipocontenido".mysql_error());
                        $total_Rows_tipocontenido = $tipocontenido->RecordCount();
                        while ($row_tipocontenido = $tipocontenido->FetchRow()) { 
                        }
                    }else {
                        $query_tipocontenido="SELECT codigotipodetallecontenidoprogramatico, nombretipodetallecontenidoprogramatico
                        FROM tipodetallecontenidoprogramatico
                        where codigoestado like '1%' and codigotipodetallecontenidoprogramatico in(100,200) order by 1 desc";
                        $tipocontenido = $db->Execute ($query_tipocontenido) or die("$query_tipocontenido".mysql_error());
                        $total_Rows_tipocontenido = $tipocontenido->RecordCount();
                       /* while ($row_tipocontenido = $tipocontenido->FetchRow()) { 
                        $query_contenido="SELECT d.iddetallecontenidoprogramatico, d.codigotipodetallecontenidoprogramatico,
                        d.observaciondetallecontenidoprogramatico, t.nombretipodetallecontenidoprogramatico
                        FROM detallecontenidoprogramatico d, tipodetallecontenidoprogramatico t
                        where d.idcontenidoprogramatico='$idcontenidoprogramatico'
                        and d.codigotipodetallecontenidoprogramatico='".$row_tipocontenido['codigotipodetallecontenidoprogramatico']."'
                        and d.codigotipodetallecontenidoprogramatico=t.codigotipodetallecontenidoprogramatico
                        and d.codigoestado like '1%'
                        and t.codigoestado like '1%';";
                        $contenido = $db->Execute ($query_contenido) or die("$query_contenido".mysql_error());
                        $total_Rows_contenido = $contenido->RecordCount();
                        $row_contenido = $contenido->FetchRow();
                        
                        
                        echo '<table width="70%"  border="1"  cellpadding="3" cellspacing="3">';                        
                        echo "<tr onclick=/"javascript:help('observacion".$row_tipocontenido['codigotipodetallecontenidoprogramatico']."')  ;/"><td style='color: #F38A01; cursor: pointer;'>Para tener mayor informaci&oacute;n de como diligenciar el formato de contenidos seleccione aqui ayuda en linea &nbsp;<img src=jscripts/tiny_mce/themes/advanced/img/help.jpg title=ayuda></td></tr>";
                        
                        if ($row_tipocontenido['codigotipodetallecontenidoprogramatico'] == 200){
                            echo '<tr><td>Equipo Docente</td></tr>';
                        }
                        if ($row_tipocontenido['codigotipodetallecontenidoprogramatico'] == 100){
                            echo '<tr><td>Informaci&oacute;n General</td></tr>';
                        }
                        
                        echo '<tr><td>';
                        echo '<textarea id="observacion'.$row_tipocontenido['codigotipodetallecontenidoprogramatico'].'" name="observacion'.$row_tipocontenido['codigotipodetallecontenidoprogramatico'].'" rows="15" cols="120" style="width: 100%">';
                        echo $row_contenido['observaciondetallecontenidoprogramatico'];
                        echo '</textarea></td></tr>';
                        echo '</table>';   
                        }*/                      
                    }
                        $Query = "select * from detallecontenidoprogramatico c where idcontenidoprogramatico ='".$idcontenidoprogramatico."' and c.codigoestado like '1%' and codigotipodetallecontenidoprogramatico = 400;";
                        $contenido = $db->Execute ($Query) or die("$Query".mysql_error());
                        $total_Rows_contenido = $contenido->RecordCount();
                        $row_contenido = $contenido->FetchRow();
                    ?>
                   <!-- <table width="70%"  border="1"  cellpadding="3" cellspacing="3">
                        <tr onclick="javascript:help('elm1');"><td style='color: #F38A01; cursor: pointer;'>Para tener mayor informaci&oacute;n de como diligenciar el formato de contenidos seleccione aqui la ayuda en linea &nbsp;<img src='jscripts/tiny_mce/themes/advanced/img/help.jpg' title="ayuda"></td></tr>
                    <tr><td>Contenido del programa</td></tr>
                    <tr><td><textarea style="font-size: 10px;"id="elm1" name="observacion400" rows="15" cols="120" style="width: 100%">
                            <?php echo $row_contenido['observaciondetallecontenidoprogramatico']?>
                        </textarea></td></tr>
                    
                    </table>-->
                    <br><br>
                    <?php
                     }else{
                        echo '<script language="javascript">alert("Ocurrio un error y no se pueden mostrar los datos de la asignatura en este momento. Por favor intentelo mas tarde o reporte el caso con la facultad.")</script>';
                     }
                    }   

 ?>
                    
        </form>

	<script>
			function guardarDocumento(){
				usuario = $("#usuario").val();
				periodo = $("#periodo").val();
				codigomateria = $("#codigomateria").val();
				var datos = new FormData();
      				datos.append('archivo',$('#archivo')[0].files[0]);
					datos.append('action','guardarDocumento');
					datos.append('usuario',usuario);
					datos.append('periodo',periodo);
					datos.append('codigomateria',codigomateria);
      				$.ajax({
      					type:"post",
      					dataType:"json",
      					url:"plantillaWord/generarplantilla.php",      					
      					contentType:false,
						data:datos,
						processData:false,
						cache:false
      				}).done(function(respuesta){      					
      					alert(respuesta.mensaje); 
						//location.reload();
      				});
      				return false;
			}
            function update_module_sig(ojb,cod){
                    obj = document.getElementById(ojb.id);
                    idcontenido = document.getElementById("idcontenidoprogramatico");
                    
                    $.get("ContenidoProgramaticoAjax.php", { PeriodoContenidoProgramatico : "true", selectOption : obj.value, idcontenidoprogramatico : idcontenido.value},
                    function(data){
                        tinyMCE.getInstanceById("observacion100").setContent('');                      
                        tinyMCE.getInstanceById("observacion100").execCommand('mceReplaceContent',false,data.toString());
                    });
                }

                function update_module_content(){
                    /*$.post("ContenidoProgramaticoAjax.php", $("#form1").serialize(),function(data){
                    alert('Informacion Actualizada Satisfactoriamente!');});*/
                    
                     $.ajax({//Ajax
            		   type: 'POST',
            		   url: 'ContenidoProgramaticoAjax.php',
            		   async: false,
            		   dataType: 'json',
            		   data:$('#form1').serialize(),
                       error:function(objeto, quepaso, otroobj){alert('Error de Conexi?n , Favor Vuelva a Intentar');},
            		   success: function(data){
            					if(data.val==false){
            					   alert(data.msj);
                                   return false;
            					}else{
            					   alert(data.msj);
            					}
                         }
                       }); 
                }

		function mostrardetalle(){
         document.getElementById("tabladetalle").style.display = "";
		 document.getElementById("titulo_div").innerHTML = "<a href=javascript:ucultardetalle()>Ocultar</a></div>";
		}

		function mostrarayuda(){
			$( "#dialog" ).dialog({
				width:400});
		}
		
		function ucultardetalle(){
			document.getElementById("tabladetalle").style.display = "none";
			document.getElementById("titulo_div").innerHTML = "<a href=javascript:mostrardetalle()>Ver informaci&oacute;n de Periodos Anteriores</a></div>";
		}
        function recarga()
        {
        //document.form1.tipodoc.disabled=false;
        document.form1.submit();
        }

        function maximaLongitud(texto,maxlong) {
        var tecla, in_value, out_value;

        if (texto.value.length > maxlong) {
        in_value = texto.value;
        out_value = in_value.substring(0,maxlong);
        texto.value = out_value;
        return false;
        }
        return true;
        }
        </script>
    </body>
</html>