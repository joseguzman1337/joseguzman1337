<?php
/*error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED);
ini_set('display_errors', E_ALL ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED);*/
$fechahoy=date("Y-m-d H:i:s");

require_once('../../Connections/sala2.php');
$rutaado = "../../funciones/adodb/";
require_once('../../Connections/salaado.php');
$rutaJS = "../sic/librerias/js/";
      

if(isset($_POST['modalidad']) && isset($_POST['periodo'])){	    
      $query_estudiante = "select eg.numerodocumento
	, concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral)as nombre
	, e.codigoestudiante
	, p.semestreprematricula
	, m.nombremateria
	, n.notadefinitiva
	, m.notaminimahabilitacion
	, s.nombresituacioncarreraestudiante
	from
	estudiante e
	join estudiantegeneral eg using(idestudiantegeneral)
	join carrera c using(codigocarrera)
	join situacioncarreraestudiante s using(codigosituacioncarreraestudiante)
	join prematricula p using(codigoestudiante)
	join notahistorico n using(codigoestudiante)
	join materia m using(codigomateria)
	where
	c.codigocarrera ='".$_POST['carrera']."'
	and p.codigoperiodo = '".$_POST['periodo']."'
	and n.codigoperiodo='".$_POST['periodo']."'
	and (n.notadefinitiva < '3.0' and n.notadefinitiva > '0.0')
	order by 2,5";
	$estudiante= $db->Execute($query_estudiante);
	$totalRows_estudiante = $estudiante->RecordCount();	
	      
	if($totalRows_estudiante !=0){
?>

	    <style type="text/css" title="currentStyle">
                @import "../../observatorio/data/media/css/demo_page.css";
                @import "../../observatorio/data/media/css/demo_table_jui.css";
                @import "../../observatorio/data/media/css/ColVis.css";
                @import "../../observatorio/data/media/css/TableTools.css";
                @import "../../observatorio/data/media/css/ColReorder.css";
                @import "../../observatorio/data/media/css/themes/smoothness/jquery-ui-1.8.4.custom.css";
                @import "../../observatorio/data/media/css/jquery.modal.css";                
	    </style>    
	    <script type="text/javascript" language="javascript" src="../../observatorio/data/media/js/jquery.js"></script>
	    <script type="text/javascript" charset="utf-8" src="../../observatorio/jquery/js/jquery-3.6.0.js"></script>
	    <script type="text/javascript" language="javascript" src="../../observatorio/data/media/js/jquery.dataTables.js"></script>
	    <script type="text/javascript" charset="utf-8" src="../../observatorio/data/media/js/ColVis.js"></script>
	    <script type="text/javascript" charset="utf-8" src="../../observatorio/data/media/js/ZeroClipboard.js"></script>
	    <script type="text/javascript" charset="utf-8" src="../../observatorio/data/media/js/TableTools_new.js"></script>
	    <script type="text/javascript" charset="utf-8" src="../../observatorio/data/media/js/FixedColumns.js"></script>
	    <script type="text/javascript" charset="utf-8" src="../../observatorio/data/media/js/ColReorder.js"></script>
	    <script type="text/javascript" language="javascript">
	    $(document).ready( function () {//"sDom": '<Cfrltip>',
			var oTable = $('#example_1').dataTable( {
			    "sScrollX": "100%",
			    "sScrollXInner": "100,1%",
			    "bScrollCollapse": true,
			    "bPaginate": true,
			    //"aLengthMenu": [[50], [50,  "All"]],
			    "iDisplayLength": 25,
			    "sPaginationType": "full_numbers",
			    "oColReorder": {
			    "iFixedColumns": 1
			    }
			} );
				//new FixedColumns( oTable );
                        /*new FixedColumns( oTable, {
                          "iLeftColumns": 1,
                          "iLeftWidth": 250
			} );*/
                                
                        var oTableTools = new TableTools( oTable, {
			    "buttons": [
			    "copy",
			    "csv",
			    "xls",
			    "pdf",
			    ]				
		        });
                        $('#demo').before( oTableTools.dom.container );
			} ); 
	    </script>
    
	    <div id="demo">
	      <table cellpadding="0" cellspacing="0" border="1" class="display" id="example_1">
		<thead>
		  <tr id="trtitulogris">			
			<th style="font-size:13px" >Nombre</th>
			<th style="font-size:13px" >Número Documento</th>
			<th style="font-size:13px">Codigo Estudiante</th>
			<th style="font-size:13px">Semestre</th>
			<th style="font-size:13px">Materia</th>
			<th style="font-size:13px">Nota Definitiva</th>
			<th style="font-size:13px">Nota Minima Habilitable</th>
			<th style="font-size:13px">¿Habilitable?</th>
			<th style="font-size:13px">Situación Estudiante</th>
		  </tr>
		</thead>
		<tbody>
		  <?php 
		  while($row_estudiante = $estudiante->FetchRow()) {
		  ?>
		    <tr>		      
		      <td style="font-weight: bold"><?php echo $row_estudiante['nombre']; ?></td>
		      <td style="width:5%" align="right"><?php echo $row_estudiante['numerodocumento']; ?></td>
		      <td style="width:5%" align="right"><?php echo $row_estudiante['codigoestudiante']; ?></td>
		      <td style="width:5%" align="center"><?php echo $row_estudiante['semestreprematricula']; ?></td>
		      <td><?php echo $row_estudiante['nombremateria']; ?></td>
		      <td style="width:5%" align="center"><?php echo $row_estudiante['notadefinitiva']; ?></td>
		      <td style="width:7%" align="center"><?php echo $row_estudiante['notaminimahabilitacion']; ?></td>
		      <td style="width:7%; font-style:italic" align="center"><?php if($row_estudiante['notadefinitiva'] >= $row_estudiante['notaminimahabilitacion'] && $row_estudiante['notadefinitiva'] >= '2.5'){ echo "SI"; }else{ echo "NO"; } ?></td>
		      <td style="width:10%" align="center"><?php echo $row_estudiante['nombresituacioncarreraestudiante']; ?></td>
		    </tr>
		  <?php
		  }
		  ?>
		  
		
		</tbody>
	      </table>
	   </div>
<?php
      }
      else {  
      ?>    
	    <br><fieldset style="width: 35%; -webkit-border-radius: 8px; -moz-border-radius: 8px; border-radius: 8px; border-color:#CCC; border-style: solid; border-width: 1px; background: #5D7D0E;
   text-shadow: 0 1px 1px rgba(0,0,0,.3);
    background:-moz-linear-gradient(center top , #7DB72F, #4E7D0E) repeat scroll 0 0 transparent; 
  background: -webkit-gradient(linear, left top, left bottom, from(#7DB72F), to(#4E7D0E)); ">             
            <div ><span style="font-style:italic; color:#FFFFFF;"><p>LA BUSQUEDA NO ENCUENTRA RESULTADOS PARA LOS PARAMETROS SELECCIONADOS</p></span></div>
            </fieldset>
        <?php    
        }
exit();
}


?>
<html>
    <head>
        <title>Reporte Habilitaciones</title>
        <link rel="stylesheet" href="../../estilos/sala.css" type="text/css">        
        <script src="<?php echo $rutaJS; ?>jquery-3.6.0.js" type="text/javascript"></script>        
        <script src="<?php echo $rutaJS; ?>jquery-ui/js/jquery-ui-3.6.0.custom.min.js" type="text/javascript"></script>
        <script src="../../mgi/js/functions.js" type="text/javascript"></script>        
        </head> 

<form action="" method="post" id="form_rep" class="report">

  <LABEL id="labelresaltadogrande">LISTADO ESTUDIANTES QUE PUEDEN HABILITAR</LABEL><p></p><br>
    <table  border="0"  cellpadding="3" cellspacing="3">
    
		  <?php
		  $query_periodo = "SELECT codigoperiodo, nombreperiodo from periodo order by 1 desc";
		  $periodo= $db->Execute($query_periodo);
		  $totalRows_periodo = $periodo->RecordCount();    
		  ?>	
		  
		  <tr>
                    <td  id="tdtitulogris" >Seleccione el Periodo
                        
                            <select name="periodo" id="periodo" class="required">  
                            <option value=""></option>
                            <?php while($row_periodo = $periodo->FetchRow()){?>
                            <option value="<?php echo $row_periodo['codigoperiodo'];?>">
                            
                            <?php echo $row_periodo['nombreperiodo'];?>
                            </option><?php }?>
                            </select>
                       
                    </td>
                </tr>
      
                   <tr>
                    <td  id="tdtitulogris">Seleccione la Modalidad
		      <?php
			$query_tipomodalidad = "select nombremodalidadacademicasic, codigomodalidadacademicasic from modalidadacademicasic where codigomodalidadacademicasic not in('000',100,101,400)";
			$tipomodalidad = $db->Execute($query_tipomodalidad);
			$totalRows_tipomodalidad = $tipomodalidad->RecordCount();
			?>		
			<select name="modalidad" id="modalidad" class="required">
			<option value=""></option>
			<?php while($row_tipomodalidad = $tipomodalidad->FetchRow()) {
			?>
			<option value="<?php echo $row_tipomodalidad['codigomodalidadacademicasic']?>">
			<?php echo $row_tipomodalidad['nombremodalidadacademicasic']; ?>
			</option>
			<?php
			}
			?>
			</select>
                    </td>                    
                   </tr>
                   <tr>
		    <td  id="tdtitulogris">Seleccione la Carrera
		      <select id="carrera" name="carrera" class="required">
		      
		      </select>
		    </td>
		   </tr>
		    
                   </table>	
	 
	<input type="submit" value="Consultar" class="first small"/>
        <img src="../../mgi/images/ajax-loader.gif" style="display:none;clear:both;margin:20px auto;" id="loading"/>	
		<div id='tableDiv'></div>
	
</form>
<script type="text/javascript">
	$(':submit').click(function(event) {
		event.preventDefault();
		var valido= validateForm("#form_rep");
		if(valido){
			sendForm();
		}
	});
	function sendForm(){
            $('#tableDiv').html("");
            $("#loading").css("display","block");
		$.ajax({
				type: 'POST',
				url: 'reporte_habilitaciones.php',
				async: false,
				data: $('#form_rep').serialize(),                
				success:function(data){			
                                    $("#loading").css("display","none");		
					$('#tableDiv').html(data);					
					
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
		});            
	}
	
	$(document).ready(function(){
	  $("#modalidad").change(function(){
	      $.ajax({
		url:"carreras.php",
		type: "POST",
		data:"codigomodalidadacademicasic="+$("#modalidad").val(),
		success: function(opciones){
		  $("#carrera").html(opciones);
		}
	      })
	  });
	});
	
</script>
