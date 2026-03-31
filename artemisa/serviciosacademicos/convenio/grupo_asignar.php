<?php
    header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    
require_once('../Connections/salasiq.php');
$rutaado = "../funciones/adodb/";
require_once('../Connections/salaado.php');
if($_REQUEST['idsiq_grupoconvenio']){    
    require_once '../class/ManagerEntity.php';
    $entity = new ManagerEntity("grupoconvenio");
    $entity->sql_where = "idsiq_grupoconvenio = ".str_replace('row_','',$_REQUEST['idsiq_grupoconvenio'])."";
    //$entity->debug = true;
    $data = $entity->getData();
    $datagrupocon = $data[0];
}

if($_REQUEST['idsiq_grupoconvenio']){    
    require_once '../class/ManagerEntity.php';
    $entity2 = new ManagerEntity("estudiantegrupo");
    $entity2->sql_where = "idsiq_grupoconvenio = ".str_replace('row_','',$_REQUEST['idsiq_grupoconvenio'])."";
    //$entity2->debug = true;
    $data2 = $entity2->getData();
    $dataestudiante = $data2[0];
   // print_r($data2[0]);
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<?
//header( 'Content-type: text/html; charset=ISO-8859-1' );
?>
<html>
    <head>
        <title>Grupo Convenio-estudiante</title>
        <style type="text/css" title="currentStyle">
                @import "../css/demo_page.css";
                @import "../css/demo_table_jui.css";
                @import "../css/themes/smoothness/jquery-ui-1.8.4.custom.css";
        </style>
        
        <link type="text/css" href="../css/common.css"  rel="stylesheet" />
	<link type="text/css" href="../css/jquery-ui-1.7.1.custom.css" rel="stylesheet" />
	<link type="text/css" href="../css/ui.multiselect.css" rel="stylesheet" />
        <link type="text/css" href="../css/estilo.css" rel="stylesheet" />
        <link href="../css/multi-select.css" rel="stylesheet" type="text/css"/>
        <link href="../css/application.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="../js/jquery.js"></script>        
	<script type="text/javascript" src="../js/jquery-ui-1.8.21.custom.min.js"></script>        
	<script type="text/javascript" src="../js/plugins/blockUI/jquery.blockUI.js"></script>
        <script type="text/javascript" src="../js/script.js"></script>
        <script src="../js/jquery.multi-select.js" type="text/javascript"></script>        
        <script src="../js/application.js" type="text/javascript"></script>
        <script type="text/javascript" src="../js/jquery.validate.1.5.2.js"></script>
        <script type="text/javascript" language="javascript" src="../js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../js/jquery.dataTables.js"></script>
        <script type="text/javascript" language="javascript" src="../js/jquery-ui-1.8.21.custom.min.js"></script>        
        <script type="text/javascript">     
       // path of ajax-loader gif image
        
        
       function displaygrupo(){
           var optionValue = jQuery("select[name='codigocarrera']").val();
           var idperido = $("#codigoperiodo").val();
           var ajaxLoader = "<img src='img/ajax-loader.gif' alt='loading...' />";
            jQuery("#idgrupo")
            .html(ajaxLoader)
            .load('generagrupo.php', {id: optionValue, codigoperiodo: idperido}, function(response){					
                if(response){
                    jQuery("#grupoAjax").css('display', '');
                    var optionValue = jQuery("select[name='codigocarrera']").val();
                    var idsiq_grupoconvenio = $("#idsiq_grupoconvenio").val();
                    if(optionValue == null){
                        jQuery("#grupoAjax").css('display', 'none');
                        $("#select1").load('generaestudiante.php?id=0&codigoperiodo=0');
                        $("#select2").load('generaestudianteregistro.php?id=0&codigoperiodo=0');
                    }else{
                        $("#select1").load('generaestudiante.php?id='+optionValue+'&codigoperiodo='+idperido);
                        $("#select2").load('generaestudianteregistro.php?id='+optionValue+'&codigoperiodo='+idperido);
                        $("#idgrupo").load('generagrupo.php?id='+optionValue+'&codigoperiodo='+idperido);
                    }                    
                }else{
                    jQuery("#grupoAjax").css('display', 'none');
                }
            });           
       }
    function displayCarrera(){
        $("#select1").load('generaestudiante.php?id=0&codigoperiodo=0');
        $("#select2").load('generaestudianteregistro.php?id=0&codigoperiodo=0');
        //$("#idgrupo").load('generagrupo.php?id=0&codigoperiodo=0');
        jQuery("#grupoAjax").css('display', 'none');
        var ajaxLoader = "<img src='img/ajax-loader.gif' alt='loading...' />";           
        var optionValue = jQuery("select[name='codigomodalidadacademica']").val();
        jQuery("#carreraAjax").css('display', 'none');
        jQuery("#codigocarrera")
            .html(ajaxLoader)
            .load('generacarrera.php', {id: optionValue, status: 1}, function(response){					
            if(response) {
                jQuery("#carreraAjax").css('display', '');                    
            } else {                    
                jQuery("#carreraAjax").css('display', 'none');               
            }
        });           
    }
       function selectGrupo(){
           var optionValue = jQuery("select[name='idgrupo']").val();           
           var idsiq_grupoconvenio = $("#idsiq_grupoconvenio").val();
           var idperido = $("#codigoperiodo").val();
           jQuery("#select1")
            .load('generaestudiante.php', {id: optionValue, codigoperiodo: idperido}, function(response){
                if(response){
                    if(optionValue == null){
                        $("#select1").load('generaestudiante.php?id=0&codigoperiodo=0');
                        $("#select2").load('generaestudianteregistro.php?id=0&codigoperiodo=0');
                    }else{
                        $("#select1").load('generaestudiante.php?id='+optionValue+'&codigoperiodo='+idperido);
                        $("#select2").load('generaestudianteregistro.php?id='+optionValue+'&codigoperiodo='+idperido);
                    }
                }else{
                    $("#select1").load('generaestudiante.php?id=0&codigoperiodo=0');
                    $("#select2").load('generaestudianteregistro.php?id=0&codigoperiodo=0');
                }
            });
       }
        $(document).ready(function(){            
            jQuery("select[name='codigomodalidadacademica']").change(function(){displayCarrera();});
            jQuery("select[name='codigocarrera']").change(function(){displaygrupo();});
            jQuery("select[name='idgrupo']").change(function(){selectGrupo();});
        });
        
        function enviar_post(){
            var idgrupo = $("#idgrupo").find(':selected').val();
            if(confirm('Esta Seguro de realiza esta Accion?')){
                $("#select2 option").attr("selected","selected");
                var idsperfilv = $("#select2").val();
                if(idsperfilv==null){
                    alert('No ha seleccionado nigun grupo de estudiantes');
                }else{                    
                    if(idsperfilv.length > <?php echo $datagrupocon['numeroparticipante'];?>){
                        alert('El numero de Participantes se ha exedido');//saca la alerta pero los puede guardar
                    }
                        var entityv = $("#entity").val();
                        var idgrupov = $("#idgrupo").val();
                        var idsiq_grupoconveniov = $("#idsiq_grupoconvenio").val();
                        var codigocarreraV= $("#codigocarrera").val();
                        var codigomodalidadacademicaV= $("#codigomodalidadacademica").val();
                        $.ajax({
                            dataType: 'json',
                            type: 'POST',
                            url: 'processgroup.php',
                            data: {grupo: true , idsperfilv_p : idsperfilv, entity : entityv,idgrupo: idgrupov, idsiq_grupoconvenio: idsiq_grupoconveniov, codigocarrera:codigocarreraV, codigomodalidadacademica:codigomodalidadacademicaV}, //$('#formes').serialize()+'&idgrupo='+idgrupo ,
                            //contentType: "application/x-www-form-urlencoded;charset=UTF-8",
                            success:function(data){
                            alert("Informacion Actualizada Satisfactoriamente!");
                            },
                            error: function(data,error){} 
                        });                    
                                            
                }             
            }
        }
              
        </script>
    </head>
    <body id="dt_example">
        <div id="container">            
            <h1>Administraci&oacute;n Grupos Convenio- Administraci&oacute;n de Estudiantes</h1>
            <div class="demo_jui">
                <div id="wrapper"> 	
	<div id="content">		
		<div id="tabs">			
			<div id="tabs-2">
                            <form action="form.php" target="submitFrame" style="border: none;" method='post'>
                                <input type="hidden" name="codigoperiodo" id="codigoperiodo" value="<?php echo $datagrupocon['codigoperiodo'];?>">
                                <h2>Convenio:<?php
                                $sql = "select nombreconvenio,idsiq_institucionconvenio from siq_convenio a inner join siq_detalle_convenio b on a.idsiq_convenio = b.idsiq_convenio and idsiq_detalle_convenio = ".$datagrupocon['idsiq_detalle_convenio']."";
                                $covenio = $db->Execute($sql);                                                    
                                echo $covenio->fields['nombreconvenio'];?> - Codigo de Grupo:<?php echo $datagrupocon['codigogrupo'];?></h2>
                                <h2>Instituci&oacute;n : 
                                                <?php 
                                                $sql = "select nombreinstitucion from siq_institucionconvenio where idsiq_institucionconvenio = ".$covenio->fields['idsiq_institucionconvenio']."";
                                                    $institucion = $db->Execute($sql);                                                    
                                                    echo $institucion->fields['nombreinstitucion'];
                                                ?>
                               -> Periodo :<?php echo $datagrupocon['codigoperiodo'];?> - Numero de Participantes:<?php echo $datagrupocon['numeroparticipante'];?></h2>    
                               <div class="demo_jui2">                                 
                                </div>
                            </form>                            
                            <form id='formes' action="form.php" name="formes" style="border: none;" method='post'>  
                                <input type="hidden" name="entity" id="entity" value="estudiantegrupo">
                                <input type="hidden" name="grupo" id="grupo" value="true">
                                <input type="hidden" name="idsiq_grupoconvenio" id="idsiq_grupoconvenio" value="<?php echo $_REQUEST['idsiq_grupoconvenio'];?>">
                                
                                <dd>
                                    <table>
                                        <tr>
                                            <td>Programa:</td>
                                            <td colspan="2"><?php
                                        $query_programa = "SELECT '' as nombremodalidadacademica, '' as codigomodalidadacademica UNION SELECT nombremodalidadacademica, codigomodalidadacademica FROM modalidadacademica";
                                        $reg_programa =$db->Execute($query_programa);
                                        echo $reg_programa->GetMenu2('codigomodalidadacademica',$data2[0]['codigomodalidadacademica'],false,false,1,' id=codigomodalidadacademica  style="width:150px;"');
                                 ?></td>
                                        </tr>    
                                        <tr>
                                            <td>Carrera:</td>
                                            <td colspan="2">
                                               <div id="carreraAjax1"> 
                                                 <?php
                                                    $query_carrera = "SELECT '' as nombrecarrera, '' as codigocarrera UNION SELECT nombrecarrera, codigocarrera FROM carrera order by 1";
                                                    $reg_carrera =$db->Execute($query_carrera);
                                                    echo $reg_carrera->GetMenu2('codigocarrera',$data2[0]['codigocarrera'],false,false,1,' id=codigocarrera  style="width:150px;"');
                                                 ?>
                                               </div>
                                                
                                                <div  id="carreraAjax" style="display: none;"> 
                                                    <!--<select id="codigocarrera" name="codigocarrera" style="width:250px;">                                     
                                                    </select>-->
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Grupo:</td>
                                            <td colspan="2">
                                                <?php
                                               if (!empty($datagrupocon['codigoperiodo']) and !empty($data2[0]['codigocarrera'])){
                                                    $query_grupo = "select CONCAT(nombregrupo,'-',nombremateria) as nombregrupo, idgrupo  from grupo g inner join materia m on g.codigomateria = m.codigomateria
                                                     where g.codigoperiodo = '".$datagrupocon['codigoperiodo']."' and codigocarrera = ".$data2[0]['codigocarrera'].";";
                                                    //echo $query_grupo;
                                                    $query_grupo =$db->Execute($query_grupo);
                                                    echo $query_grupo->GetMenu2('idgrupo',$data2[0]['idgrupo'],false,false,1,' id=idgrupo  style="width:150px;"');
                                               }else{
                                                  echo '<div id="grupoAjax">';
                                                   echo "<select id='idgrupo' name='idgrupo' style='width:250px;'>";
                                                   echo "<select>";
                                                  echo ' </div>';
                                               }
                                              ?>
                                                <div id="grupoAjax" style="display: none;"> 
                                                    <!--<select id="idgrupo" name="idgrupo" style="width:250px;">                                     
                                                    </select>-->
                                               </div>     
                                            </td>
                                        </tr>
                                    <tr>
                                    <td>
                                    <div id="box1Group">
                                    Buscar: <input type="text" name="filter" /><button type="button" name="clear">X</button><br />
                                    <select id="select1" name="view" multiple="multiple" style="height:200px;width:200px;">
                                        <?php
                                        if (!empty($datagrupocon['codigoperiodo']) and !empty($data2[0]['idgrupo'])){
                                           $sql = "select distinct dp.idgrupo,e.codigoestudiante,apellidosestudiantegeneral, nombresestudiantegeneral
                                                from prematricula p 
                                                inner join detalleprematricula dp on p.idprematricula = dp.idprematricula
                                                inner join estudiante e on e.codigoestudiante = p.codigoestudiante
                                                inner join estudiantegeneral eg on eg.idestudiantegeneral = e.idestudiantegeneral
                                                left join siq_estudiantegrupo seg on seg.idgrupo = dp.idgrupo and seg.idgrupo and e.codigoestudiante = seg.codigoestudiante
                                                where p.codigoperiodo = ".$datagrupocon['codigoperiodo']." and codigoestadoprematricula in (10,40,41,30,11)
                                                and seg.idgrupo is null
                                                and dp.idgrupo = ".$data2[0]['idgrupo']."
                                                order by 3;";
                                                $rs= $db->Execute($sql);  
                                                 while (!$rs->EOF) {
                                                        echo '<option value="'.$rs->fields[1].'">'.$rs->fields[2]."-".$rs->fields[3].'</option>';
                                                        $rs->MoveNext();
                                                    }       
                                               }
                                        
                                        ?>
                                    </select><br/>
                                    <span class="countLabel"></span>
                                    <select name="storage" class="storageBox" style="display:none" >
                                    </select>
                                    </div>
                                    </td>
                                    <td>
                                    <button id="to2" type="button">&nbsp;>&nbsp;</button>
                                    <button id="allTo2" type="button">&nbsp;>>&nbsp;</button>
                                    <button id="allTo1" type="button">&nbsp;<<&nbsp;</button>
                                    <button id="to1" type="button">&nbsp;<&nbsp;</button>
                                    </td>
                                    <td>
                                    <div id="box2Group">
                                    Buscar: <input type="text" name="filter" /><button type="button" name="clear">X</button><br />
                                    <select id="select2" name="view" multiple="multiple" style="height:200px;width:200px;">
                                      <?php
                                        if (!empty($datagrupocon['codigoperiodo']) and !empty($data2[0]['codigocarrera'])){
                                                  $sql = "select distinct seg.idgrupo,e.codigoestudiante,apellidosestudiantegeneral, nombresestudiantegeneral 
                                                    from prematricula p 
                                                    inner join detalleprematricula dp on p.idprematricula = dp.idprematricula 
                                                    inner join estudiante e on e.codigoestudiante = p.codigoestudiante 
                                                    inner join estudiantegeneral eg on eg.idestudiantegeneral = e.idestudiantegeneral 
                                                    inner join siq_estudiantegrupo seg on e.codigoestudiante = seg.codigoestudiante 
                                                    where p.codigoperiodo = '".$datagrupocon['codigoperiodo']."'
                                                    and seg.idgrupo='".$data2[0]['idgrupo']."' order by 3";
                                                    $rs= $db->Execute($sql);        
                                                    while (!$rs->EOF) {
                                                        echo '<option value="'.$rs->fields[1].'">'.$rs->fields[2]."-".$rs->fields[3].'</option>';
                                                        $rs->MoveNext();
                                                    }       
                                               }
                                       ?>
                                    </select>
                                    <br />
                                    <span class="countLabel"></span>
                                    <select name="storage" class="storageBox" style="display:none"></select>
                                    </div>
                                    </td>
                                    </tr>
                                    </table>
                                    </dd>
                                    <dd>
                                        <input type="button" id="localSubmit" onclick="enviar_post();" name="localSubmit" value="Guardar" />
                                    </dd>                              
				</form>
			</div>
		</div>                
	</div> 	
</div>   
                
                
            </div>
        </div>            
        <div id="dialog">
        </div>
    </body>
</html>