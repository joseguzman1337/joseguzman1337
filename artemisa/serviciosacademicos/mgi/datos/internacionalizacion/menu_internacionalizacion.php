<?php

if(isset($_POST['modalidad'])){

require_once("../templates/template.php");
$db = writeHeader("Internacionalizacion",TRUE);
$utils = new Utils_datos();

$parametros="";

	if (isset ($_POST['nombres']) && $_POST['nombres']!=''){
        
        $parametros .=" and eg.nombresestudiantegeneral like '%".$_POST['nombres']."%'" ;
        }
        if (isset ($_POST['apellidos']) && $_POST['apellidos']!=''){
        
        $parametros .=" and eg.apellidosestudiantegeneral like '%".$_POST['apellidos']."%'";
        }
        if (isset ($_POST['numerodocumento']) && $_POST['numerodocumento']!='' && !ereg("^[a-zA-Z0-9 ]+$",$_POST['numerodocumento'])){
        
        $parametros .=" and eg.numerodocumento = ".$_POST['numerodocumento'];
        }
        if (isset ($_POST['modalidad']) && $_POST['modalidad']!='' && $_POST['modalidad']!='todos'){
        
        $parametros .=" and c.codigomodalidadacademicasic = ".$_POST['modalidad'];
        }
        if (isset ($_POST['carrera']) && $_POST['carrera']!='' && $_POST['carrera']!='todasc'){
        
        $parametros .=" and e.codigocarrera = ".$_POST['carrera'];
        }        
        
        
        $query_estudiante = "SELECT e.codigoestudiante, eg.nombresestudiantegeneral, eg.apellidosestudiantegeneral, eg.numerodocumento, c.nombrecarrera, e.codigoperiodo
        FROM estudiante e, estudiantegeneral eg, carrera c
        where
        e.idestudiantegeneral=eg.idestudiantegeneral
        and e.codigocarrera=c.codigocarrera        
        $parametros
        order by eg.apellidosestudiantegeneral, eg.nombresestudiantegeneral, c.nombrecarrera";
        $estudiante= $db->Execute($query_estudiante);
        $totalRows_estudiante = $estudiante->RecordCount();
        $row_estudiante = $estudiante->FetchRow();
        
        
        if ($totalRows_estudiante >0){ ?>
        
            <table align="left" id="estructuraReporte" class="previewReport" style="text-align:left;clear:both;margin: 10px 0px;width:100%">
	      <thead>            
		<tr class="dataColumns">
		  <th class="column" colspan="4"><span>ESTUDIANTES</span></th>                    
                </tr>
                <tr class="dataColumns">
                    <th align="center">Documento</th>
                    <th align="center">Apellidos</th>
                    <th align="center">Nombres</th>                    
                    <th align="center">Carrera</th>                   
                </tr>                
              </thead>
              <tbody>
                <?php                  
                do { ?>                
                <tr class="contentColumns" class="row">
                    <TD align="left" class="column"><a href="ingresa_info.php?codigoestudiante=<?php echo $row_estudiante['codigoestudiante'].'&nombres='.$row_estudiante['nombresestudiantegeneral'].'&apellidos='.$row_estudiante['apellidosestudiantegeneral']?>"><?php echo $row_estudiante['numerodocumento']; ?></a></TD>
                    <TD class="column" align="left"><?php echo $row_estudiante['apellidosestudiantegeneral']; ?></TD>
                    <TD class="column" align="left"><?php echo $row_estudiante['nombresestudiantegeneral']; ?></TD>                    
                    <TD class="column" align="left"><?php echo $row_estudiante['nombrecarrera']; ?></TD>
                </tr>
                <?php 
                } while($row_estudiante = $estudiante->FetchRow());
                ?>
              </tbody>  
            </table>     
        <?php
        }
        else { ?>       
            <label class="grid-2-12">NO EXISTEN DATOS PARA LA BUSQUEDA</label>
        <?php    
        }
exit();
}

 session_start();
if(!isset($_SESSION['MM_Username'])){
$_SESSION['MM_Username']="equipomgi";
}

require_once("../templates/template.php");

$db = writeHeader("Internacionalizacion",TRUE);

$utils = new Utils_datos();
?>
<form action="" method="post" id="form_int" class="report">
	<span class="mandatory">* Son campos obligatorios</span>
	<fieldset>  
		<legend>Internacionalización</legend>
		<div class=""><span style="font-style:italic; font-size:20px"><p>Busqueda de Estudiante</p></span></div>
		
		<label for="nombres" class="grid-2-12">Nombre: </label>		
		<input type="text" class="grid-4-12" minlength="1" name="nombres" id="nombres" title="Nombres" tabindex="1" autocomplete="off" />
		
		<label for="apellidos" class="grid-2-12">Apellidos: </label>
		<input type="text" class="grid-4-12" minlength="1" name="apellidos" id="apellidos" title="Apellidos" tabindex="1" autocomplete="off" />
		
		<label for="numerodocumento" class="grid-2-12">Documento: </label>
		<input type="text" class="grid-4-12  number" minlength="1" name="numerodocumento" id="numerodocumento" title="Documento" maxlength="12	" tabindex="1" autocomplete="off" />
		
		<label for="modalidad" class="grid-2-12">Modalidad Academica: <span class="mandatory">(*)</span></label>		
		
		<?php
		$query_tipomodalidad = "select nombremodalidadacademicasic, codigomodalidadacademicasic from modalidadacademicasic where codigomodalidadacademicasic not in('000',100,101,400)";
		$tipomodalidad = $db->Execute($query_tipomodalidad);
		$totalRows_tipomodalidad = $tipomodalidad->RecordCount();
		?>		
		<select name="modalidad" id="modalidad" style='font-size:0.8em' class="required">
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
		
		<label for="carrera" class="grid-2-12">Programa Academico: <span class="mandatory">(*)</span></label>		
		<select id="carrera" name="carrera" style='font-size:0.8em'>
		<option value="todasc"></option>
		</select>
		
	 
	<input type="submit" value="Consultar" class="first small"/>
        <img src="../../images/ajax-loader.gif" style="display:none;clear:both;margin:20px auto;" id="loading"/>	
		<div id='tableDiv'></div>
	</fieldset>
</form>
<script type="text/javascript">
	$(':submit').click(function(event) {
		event.preventDefault();
		var valido= validateForm("#form_int");
		if(valido){
			sendForm();
		}
	});
	function sendForm(){
            $('#tableDiv').html("");
            $("#loading").css("display","block");
		$.ajax({
				type: 'POST',
				url: 'menu_internacionalizacion.php',
				async: false,
				data: $('#form_int').serialize(),                
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
