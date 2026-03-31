<?php
session_start();
 if(!isset ($_SESSION['MM_Username'])){

    echo "No tiene permiso para acceder a esta opción";
    exit();
}

    $ruta = "../";
    while (!is_file($ruta.'Connections/sala2.php'))
    {
        $ruta = $ruta."../";
    } 
    require_once($ruta.'Connections/sala2.php');
    $rutaado = $ruta."funciones/adodb/";
    require_once($ruta.'Connections/salaado.php');
    
?>
<html>
    <body>
 <?php  if( (isset($_REQUEST["codigofacultad"]) && $_REQUEST["codigofacultad"]!="")){ 
    $queryperiodo = "select codigoperiodo from periodo where now() between fechainicioperiodo and fechavencimientoperiodo";
    $periodo = $db->GetRow($queryperiodo);
    $codigoperiodo = $periodo["codigoperiodo"];
    include_once('../estadisticas/matriculasnew/funciones/obtener_datos.php');
    $datos_estadistica=new obtener_datos_matriculas($db,$codigoperiodo);
    $matriculados = $datos_estadistica->obtener_total_matriculados($_REQUEST["codigoprograma"],'arreglo');
      include_once('./functionsHorarios.php');
      //var_dump($_REQUEST);
      //echo $_REQUEST["codigoprograma"];
      //print_r($matriculados);
      $html = "";
      ?>
    <span style="display: inline-block;">
        <table CELLPADDING="10" id="tableResult">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Estudiante</th>
                    <th>Código</th>
                    <th>Documento</th>
                    <th>Horario</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
       <?php $contador=1;
      foreach($matriculados as $matriculado){
          $materiasMatriculadas = getMateriasMatriculadas($matriculado["codigoestudiante"],$codigoperiodo,$db);
              $horasOcupadas = array();
              $cruce = false;
              $datosCruce= array();
          if(count($materiasMatriculadas)>0){
              //toca verificar si tiene cruce de horario
              foreach($materiasMatriculadas as $materia){
                  $horario = getHorarioGrupo($materia["idgrupo"],$db);
         /*if($matriculado["codigoestudiante"]==35019){
                            echo "<br/><br/><pre>";print_r($materia);
                            echo "<br/><br/><pre>";print_r($horario);
                            echo "<br/><br/><pre>";print_r($horasOcupadas);
                          }*/
                  foreach($horario as $hora){
                    $start = explode(":", $hora['horainicial']);
                    $start_hour = $start[0];
                    $start_minute = $start[1];
                    $inicial = $start_hour.":".$start_minute;

                    $end = explode(":", $hora['horafinal']);
                    $end_hour = $end[0];
                    $end_minute = $end[1];
                    $final = $end_hour.":".$end_minute;
                    $cont = 0;
                      foreach($horasOcupadas[$hora["codigodia"]]["ini"] as $horasLlenas){
                          $result = intersectCheck($horasLlenas, $inicial, $horasOcupadas[$hora["codigodia"]]["fin"][$cont], $final);
                          if($matriculado["codigoestudiante"]==35019){
                            echo $result;
                          }
                          if(!$result){
                              $cruce = true;
                              $datosCruce[] = array("dia"=> $horasOcupadas[$hora["codigodia"]]["nombre"], 
                                  "horario1" => $horasLlenas." a ".$horasOcupadas[$hora["codigodia"]]["fin"][$cont], 
                                  "materia2" => $materia["nombremateria"], 
                                  "materia1" => $horasOcupadas[$hora["codigodia"]]["materia"][$cont], 
                                  "horario2" => $inicial." a ".$final);
                          }
                          $cont++;
                      }
                    $horasOcupadas[$hora["codigodia"]]["nombre"] = $hora["nombredia"];
                    $horasOcupadas[$hora["codigodia"]]["codigo"] = $hora["codigodia"];
                    
                    $start = explode(":", $hora['horainicial']);
                    $start_hour = $start[0];
                    $start_minute = $start[1];
                    $horasOcupadas[$hora["codigodia"]]["ini"][] = $inicial;
                    $horasOcupadas[$hora["codigodia"]]["materia"][] = $materia["nombremateria"];

                    $end = explode(":", $hora['horafinal']);
                    $end_hour = $end[0];
                    $end_minute = $end[1];
                    $horasOcupadas[$hora["codigodia"]]["fin"][] = $final;
                  }
              }
              if($cruce){
                  $datos = "";
                  foreach($datosCruce as $dato1){
                      $datos .= $dato1["dia"]."<br/>".$dato1["materia1"]."<br/>".$dato1["horario1"]."<br/>".$dato1["materia2"]."<br/>".$dato1["horario2"]."<br/><br/>";
                  }
                  
                  $estudiante = getDatosEsutdiante($matriculado["codigoestudiante"],$db);
                  
                    $html .="<tr>";
                    $html .="<td>".$contador."</td>";$contador++;
                    $html .="<td>".$estudiante["nombresestudiantegeneral"]." ".$estudiante["apellidosestudiantegeneral"]."</td>";
                    $html .="<td>".$matriculado["codigoestudiante"]."</td>";
                    $html .="<td>".$estudiante["numerodocumento"]."</td>";
                    $html .="<td>".$datos."</td>";
                    $html .="<td><a href='redirectHorario.php?codigoestudiante=".$matriculado["codigoestudiante"]."' target='_blank'>Ver Horario</a></td>";
                    $html .="</tr>";
              }
         }
          
      }
        if($html === "") {
             echo "<td colspan='6' style='text-align:center' >No se encontraron estudiantes con cruce de horario.</td>";
        } else {
            echo $html;
        }
?>
            </tbody>
            </table>
        <div style="height:10px;clear:both;"></div>
        <button type="button" style="margin-bottom:10px;float:right;clear:both;" onclick="exportarExcel()">Exportar a Excel</button>
       
    </span>
<script type="text/javascript">
    $(document).ready(function() {
        $('#formInformeCamapania').remove();
        var htmlText = '<form  action="../facultades/registro_graduados/carta_egresados/imprimirReporteElectivasPendientes.php" method="post" id="formInformeCamapania" style="z-index: -1;  width:100%">';
        htmlText = htmlText + '<input type="hidden" id="datos_a_enviar" name="datos_a_enviar" /></form>';
        $( "#ganancia" ).before( htmlText );
    });
	function exportarExcel(){
            $("#datos_a_enviar").val( $("<div>").append( $("#tableResult").eq(0).clone()).html());
            $("#formInformeCamapania").submit();
	}
</script>
   <?php } else {
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Cruce de Horarios</title>
        <link rel="stylesheet" href="../../css/themes/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" /> 
        
        <script type="text/javascript" language="javascript" src="../../mgi/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../../mgi/js/jquery-ui-1.8.21.custom.min.js"></script> 
        <style>
            table
            {
                border-collapse:collapse;
            }
            table,th, td
            {
                border: 1px solid black;
            }
            th{
                background-color:#C5D5AA;
            }
            th.category{
                background-color: #FEF7ED;
                text-align:center;
            }
            select {
                background: transparent;
                width: 268px;
                padding: 5px;
                font-size: 14px;
                line-height: 1;
                border: 1px solid #779999;
                border-radius: 0;
                -webkit-appearance: none;
            }
            button,input[type="submit"]{
                -moz-box-shadow: 0px 10px 14px -7px #3e7327;
                -webkit-box-shadow: 0px 10px 14px -7px #3e7327;
                box-shadow: 0px 10px 14px -7px #3e7327;
                cursor: pointer;
                background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #77b55a), color-stop(1, #72b352));
                background:-moz-linear-gradient(top, #77b55a 5%, #72b352 100%);
                background:-webkit-linear-gradient(top, #77b55a 5%, #72b352 100%);
                background:-o-linear-gradient(top, #77b55a 5%, #72b352 100%);
                background:-ms-linear-gradient(top, #77b55a 5%, #72b352 100%);
                background:linear-gradient(to bottom, #77b55a 5%, #72b352 100%);
                filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#77b55a', endColorstr='#72b352',GradientType=0);

                background-color:#77b55a;

                -moz-border-radius:4px;
                -webkit-border-radius:4px;
                border-radius:4px;

                border:1px solid #4b8f29;

                display:inline-block;
                color:#ffffff;
                font-family:arial;
                font-size:13px;
                font-weight:bold;
                padding:6px 12px;
                text-decoration:none;

                text-shadow:0px 1px 0px #5b8a3c;

            }
        
    button:hover,input[type="submit"]:hover {
        
        background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #72b352), color-stop(1, #77b55a));
        background:-moz-linear-gradient(top, #72b352 5%, #77b55a 100%);
        background:-webkit-linear-gradient(top, #72b352 5%, #77b55a 100%);
        background:-o-linear-gradient(top, #72b352 5%, #77b55a 100%);
        background:-ms-linear-gradient(top, #72b352 5%, #77b55a 100%);
        background:linear-gradient(to bottom, #72b352 5%, #77b55a 100%);
        filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#72b352', endColorstr='#77b55a',GradientType=0);
        
        background-color:#72b352;
    }
    button:active,input[type="submit"]:active {
        position:relative;
        top:1px;
    }
    
    .fixedLabel{
          display: inline-block;
            margin-right: 5px;
            text-align: right;
            width: 80px;
    }
        </style>
    </head>
    <body>
<form action="" method="post" id="ganancia" class="report">
    <h3>Reporte de Estudiantes con Cruce de Horarios</h3>
    
	<fieldset style="min-width: 800px;border:0;">  
		<label for="facultad" class="fixedLabel">Modalidad: </label>		
		
		<?php
                    $query = "SELECT * FROM modalidadacademica  where codigoestado=100 ORDER BY nombremodalidadacademica";
                    $tipomodalidad = $db->Execute($query);
		?>		
		<select name="codigofacultad" id="modalidad" style='font-size:0.8em'>
		<?php while($row_tipomodalidad = $tipomodalidad->FetchRow()) {
		?>
                    <option value="<?php echo $row_tipomodalidad['codigomodalidadacademica']?>">
                    <?php echo $row_tipomodalidad['nombremodalidadacademica']; ?>
                    </option>
		<?php
		}
		?>
		</select>	
                
                <div style="height:15px;" class="vacio"></div>
                
                <label for="programa" class="fixedLabel">Programa: </label>
                <select name="codigoprograma" id="programa" style='font-size:0.8em'>
                    <option value=""></option>
                </select>	
		
	
	<input type="submit" value="Consultar" style="margin: 0px 0px 10px 15px;" />	
        <img src="../../mgi/images/ajax-loader.gif" style="display:none;clear:both;margin:20px auto;" id="loading"/>
		<div id='tableDiv'></div>
	</fieldset>
</form>
<script type="text/javascript">
    $(document).ready(function() {
        getCarreras();
    });
    
    
	$(':submit').click(function(event) {
		event.preventDefault();
		sendForm();
	});
	function sendForm(){
            $('#tableDiv').html("");
            $("#loading").css("display","block");
		$.ajax({
				type: 'GET',
				url: './reporteCruceHorarios.php',
				async: false,
				data: $('#ganancia').serialize(),                
				success:function(data){	
                                    $("#loading").css("display","none");				
					$('#tableDiv').html(data);					
					
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
		});           
	}
        
        $(document).on('change', "#modalidad", function(){
              getCarreras();
        });
        
        function getCarreras(){
                    $("#programa").html("");
                    $("#programa").css("width","auto");   
                        
                    if($('#modalidad').val()!=""){
                        var mod = $('#modalidad').val();
                            $.ajax({
                                dataType: 'json',
                                type: 'POST',
                                url: './lookForCareersByModalidad.php',
                                data: { facultad: mod },     
                                success:function(data){
                                     var html = '<option value="" selected></option>';
                                     var i = 0;
                                        while(data.length>i){
                                            html = html + '<option value="'+data[i]["value"]+'" >'+data[i]["label"]+'</option>';
                                            i = i + 1;
                                        }                                    
                            
                                        $("#programa").html(html);
                                        $("#programa").css("width","500px");                                      
                                },
                                error: function(data,error,errorThrown){alert(error + errorThrown);}
                            });  
                    }
                }
        
</script>
    <?php } ?>
    </body>
    </html>
