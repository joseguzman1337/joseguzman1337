<?php 


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
    $entity2 = new ManagerEntity("detalle_convenio");
    $entity2->sql_where = "idsiq_detalle_convenio = ".$datagrupocon['idsiq_detalle_convenio']."";
    $data2 = $entity2->getData();
    $datacon = $data2[0];
    
    $entity3 = new ManagerEntity("especialidad");
    $entity3->sql_where = "idsiq_especialidad = ".$datacon['idsiq_especialidad']."";
    $data3 = $entity3->getData();
    $especialidad = $data3[0];    
    $entity4 = new ManagerEntity("docente");
    $entity4->prefix="";
    $entity4->sql_where = "iddocente = ".$datagrupocon['iddocente']."";
    $data4 = $entity4->getData();
    $docente = $data4[0];
    
    $entity5 = new ManagerEntity("convenio");    
    $entity5->sql_where = "idsiq_convenio = ".$datacon['idsiq_convenio']."";
    $data5 = $entity5->getData();
    $convenio = $data5[0];    
    
    $entity6 = new ManagerEntity("institucionconvenio");
    $entity6->sql_where = "idsiq_institucionconvenio = ".$convenio['idsiq_institucionconvenio']."";
    $data6 = $entity6->getData();
    $insitu = $data6[0];
    
    $entity7 = new ManagerEntity("estudiantegrupo");
    $entity7->sql_where = "idsiq_grupoconvenio = ".$datagrupocon['idsiq_grupoconvenio']."";
    $data7 = $entity7->getData();
    
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<?
header( 'Content-type: text/html; charset=ISO-8859-1' );
?>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
        <title>Calificacion Grupo Convenio</title>
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
                    var optionValue = jQuery("select[name='idgrupo']").val();
                    var idsiq_grupoconvenio = $("#idsiq_grupoconvenio").val();
                    if(optionValue == null){
                        jQuery("#grupoAjax").css('display', 'none');
                        $("#select1").load('generaestudiante.php?id=0&codigoperiodo=0');
                        $("#select2").load('generaestudianteregistro.php?id=0&codigoperiodo=0');
                    }else{
                        $("#select1").load('generaestudiante.php?id='+optionValue+'&codigoperiodo='+idperido);
                        $("#select2").load('generaestudianteregistro.php?id='+optionValue+'&codigoperiodo='+idperido);
                    }                    
                }else{
                    jQuery("#grupoAjax").css('display', 'none');
                }
            });           
       }
       function displayCarrera(){
           $("#select1").load('generaestudiante.php?id=0&codigoperiodo=0');
           $("#select2").load('generaestudianteregistro.php?id=0&codigoperiodo=0');
           $("#idgrupo").load('generagrupo.php?id=0&codigoperiodo=0');
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
        $(document).ready(function() {
            jQuery("#guardar").click(function(){enviar_post();});            
        });
        
        function enviar_post(){
//            alert('hol');
            var idgrupo = $("#idgrupo").find(':selected').val();
//            if(confirm('Esta Seguro de realiza esta Accion?')){
//                $("#select2 option").attr("selected","selected");
//                var idsperfilv = $("#select2").val();
//                if(idsperfilv==null){
//                    alert('No ha seleccionado nigun grupo de estudiantes');
//                }else{                    
//                    if(idsperfilv.length > <?php echo $datagrupocon['numeroparticipante'];?>){
//                        alert('El numero de Participantes se ha exedido');
//                    }else{
                        var entityv = $("#entity").val();
                        var idgrupov = $("#idgrupo").val();
                        var idsiq_grupoconveniov = $("#idsiq_grupoconvenio").val();                        
                        $.ajax({
                            dataType: 'json',
                            type: 'POST',
                            url: 'processnota.php',
                            data: $('#formes').serialize()+'&idgrupo='+idgrupo ,
                            //contentType: "application/x-www-form-urlencoded;charset=UTF-8",
                            success:function(data){
                            alert("Informacion Actualizada Satisfactoriamente!");
                            },
                            error: function(data,error){} 
                        });                    
//                    }                        
//                }             
//            }
        }
              
        </script>
    </head>
    <body id="dt_example">
        <div id="container">            
            <h1>Calificaci&oacute;n Grupos Convenio</h1>
            <div class="demo_jui">
                
	<div id="content">
		<div id="tabs">			
			<div id="tabs-2">
                            <form action="form.php" target="submitFrame" style="border: none;" method='post'>
                                <input type="hidden" name="codigoperiodo" id="codigoperiodo" value="<?php echo $datagrupocon['codigoperiodo'];?>">
                                
                                
                                <table border="1" style="color:#4E6CA3;">
                                    <thead>
                                        <tr>
                                            <th colspan="3">Estudiantes Grupo</th>
                                            <th colspan="2">Fecha</th>
                                            <th><?php echo date("Y-m-d H:i:s");?></th>                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Codigo</td>
                                            <td>Grupo de Practica</td>
                                            <td>PRACTICA</td>
                                            <td colspan="2">Especialidad</td>
                                            <td>Facultad</td>                                            
                                        </tr>
                                        <tr>
                                            <td><?php echo $datagrupocon['idsiq_grupoconvenio']?></td>
                                            <td><?php echo $datagrupocon['codigogrupo']?></td>
                                            <td>PRACTICA</td>
                                            <td colspan="2"><?php echo $especialidad['nombreespecialidad'];?></td>
                                            <td><?php 
                                            $query_carrera="select distinct nombrecarrera from siq_estudiantegrupo a inner join estudiante b on a.codigoestudiante = b.codigoestudiante
                                            inner join carrera c on b.codigocarrera = c.codigocarrera where idsiq_grupoconvenio = 9;";
                                            $reg_carrera =$db->Execute($query_carrera); 
                                            echo $reg_carrera->fields[0];
                                            ?>
                                            </td>
                                        </tr>
                                        <tr>                                            
                                            <td colspan="3">Docente</td>
                                            <td colspan="3"><?php echo $docente['nombredocente']."  ".$docente['apellidodocente'];?></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">Instituci&oacute;n</td>
                                            <td colspan="3"><?php echo $insitu['nombreinstitucion'];?></td>
                                        </tr>                                        
                                    </tbody>
                                </table>                                    
                               <div class="demo_jui2">
                                       <table border ="1" style="color:#4E6CA3;">
                                           <tr>
                                               <td>Corte</td>
                                               <td>Fecha Inicial</td>
                                               <td>Fecha Final</td>
                                               <td>Porcentaje%</td>
                                           </tr>
                                           <?php
                                            $entity10 = new ManagerEntity("corte");                                            
                                            $entity10->sql_where = "idsiq_grupoconvenio = ".$datagrupocon['idsiq_grupoconvenio']." and codigoestado = 100";  
                                            $entity10->sql_orderby = " 1";
                                            $data10 = $entity10->getData();
                                            if (is_array($data10) and count($data10)>0){
                                                $totalpercent=0;
                                                foreach ($data10 as $rows2){                                                    
                                                    echo '<tr>
                                                    <td>'.$rows2['numerocorte'].'</td>
                                                    <td>'.$rows2['fechainicio'].'</td>
                                                    <td>'.$rows2['fechafin'].'</td>
                                                    <td>'.$rows2['peso'].' %</td>
                                                    </tr>';
                                                    $totalpercent +=$rows2['peso'];
                                                }                                                
                                            }else{
                                                echo "No se han parametrizado los cortes academicos, no se puede registrar informacion";
                                                exit();
                                            }
                                           ?>
                                           <tr>
                                               <td></td>
                                               <td></td>
                                               <td></td>
                                               <td><?php echo $totalpercent;?>%</td>
                                           </tr>
                                       </table>                                       
                                </div>
                            </form>
                                <form id='formes' action="form.php" name="formes" style="border: none;" method='post'>  
                                <input type="hidden" name="entity" id="entity" value="nota">
                                <input type="hidden" name="grupo" id="grupo" value="true">
                                <input type="hidden" name="idsiq_grupoconvenio" id="idsiq_grupoconvenio" value="<?php echo $_REQUEST['idsiq_grupoconvenio'];?>">
                                <table border="1" style="color: #4E6CA3;">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Documento</th>
                                            <th>Apellidos</th>
                                            <th>Nombres</th>
                                            <?php 
                                            foreach ($data10 as $rows2){                                                    
                                                echo '<th>Nota</th>
                                            <th>FAT</th>
                                            <th>FAP</th>';                                                
                                            }
                                            ?>                                            
                                            <th>Nota Final</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $i=1;
                                        if (is_array($data7)){
                                            $entitynote = new ManagerEntity("nota");
                                            foreach ($data7 as $row){
                                                $entity8 = new ManagerEntity("estudiante");
                                                $entity8->prefix ="";
                                                $entity8->sql_where = "codigoestudiante = ".$row['codigoestudiante']."";
                                                $data8 = $entity8->getData();
                                                $dataestud= $data8[0];
                                                $entity9 = new ManagerEntity("estudiantegeneral");
                                                $entity9->prefix ="";
                                                $entity9->sql_where = "idestudiantegeneral = ".$dataestud['idestudiantegeneral']."";
                                                $data9 = $entity9->getData();
                                                $dataestudg= $data9[0];
                                                echo '<tr>
                                                <td>'.$i.'</td>
                                                <td>'.$dataestudg['numerodocumento'].'</td>
                                                <td>'.$dataestudg['nombresestudiantegeneral'].'</td>
                                                <td>'.$dataestudg['apellidosestudiantegeneral'].'</td>';
                                                $totalpercent=0;                                                
                                                foreach ($data10 as $rows2){                                                    
                                                    $entitynote->sql_where = "idsiq_corte = ".$rows2['idsiq_corte']." and codigoestudiante = '".$row['codigoestudiante']."'";
                                                    $datanote = $entitynote->getData();
                                                    $datanote = $datanote[0];
                                                    $nota=0;
                                                    $fallat=0;
                                                    $fallap=0;
                                                    if($datanote['nota']<>"")$nota=$datanote['nota'];
                                                    if($datanote['numerofallasteorica']<>"")$fallat=$datanote['numerofallasteorica'];
                                                    if($datanote['numerofallaspractica']<>"")$fallap=$datanote['numerofallaspractica'];
                                                    echo '<td><input type="text" id="nota'.$rows2['idsiq_corte'].'['.$row['codigoestudiante'].']" name="nota'.$rows2['idsiq_corte'].'['.$row['codigoestudiante'].']" value="'.$nota.'" size="3" maxlength="3"/></td>
                                                    <td><input type="text" id="numerofallaspractica'.$rows2['idsiq_corte'].'['.$row['codigoestudiante'].']" name="numerofallaspractica'.$rows2['idsiq_corte'].'['.$row['codigoestudiante'].']" size="3" maxlength="3" value="'.$fallat.'"/></td>
                                                    <td><input type="text" id="numerofallasteorica'.$rows2['idsiq_corte'].'['.$row['codigoestudiante'].']" name="numerofallasteorica'.$rows2['idsiq_corte'].'['.$row['codigoestudiante'].']" size="3" maxlength="3"  value="'.$fallap.'"/></td>                                                    
                                                    ';                                                    
                                                }
                                                echo "<td>0</td>";
                                                $i++;                         
                                                echo '<tr>';
                                            }                                            
                                        }                                        
                                        ?>
                                        <tr><td colspan="4"><input type="button" id="guardar" name="guardar" value="Guardar"></td></tr>
                                    </tbody>
                                </table>
     			    </form>
                            
			</div>		               
	</div> 	
</div>   
                
                
            </div>
        </div>            
        <div id="dialog">
        </div>
    </body>
</html>