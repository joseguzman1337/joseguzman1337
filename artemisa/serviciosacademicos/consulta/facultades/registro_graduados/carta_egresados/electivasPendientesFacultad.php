<?php

    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
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

  <?php  if(isset($_REQUEST["codigofacultad"]) && $_REQUEST["codigofacultad"]!=""){ 
      include_once('./functionsElectivasPendientes.php');
      ?>
    <span style="display: inline-block;">
        <button type="button" style="margin-bottom:10px;float:right;clear:both;" onclick="exportarExcelGeneral()">Exportar Excel General</button>
        <button type="button" style="margin-bottom:10px;float:right;clear:none;margin-right:20px;" onclick="exportarExcel()">Exportar Excel Detallado</button>
        <div style="height:1px;clear:both;"></div>
        <table CELLPADDING="10" id="tableResult">
            <thead>
                <tr>
                    <th>Estudiante</th>
                    <th>Documento</th>
                    <th>Semestre</th>
                    <th>Situación Estudiante</th>
                    <th>Electivas</th>
                </tr>
            </thead>
            <tbody>
       <?php 
       //obtener estudiantes por graduarse
       $estudiantes = getEstudiantesPorGraduarse($_REQUEST["codigofacultad"],$_REQUEST["codigoprograma"],$db,$_REQUEST["semestre"],true);
        
      $planEstudio = 0;
      $numCreditos = 0;
      $html = "";
      $carrera = 0;
            $arrayCreditosPlanEstudio = array();
            $arrayCreditosEstudiante = array();
        //while ($row = $estudiantes->FetchRow()) { 
      foreach($estudiantes as $row){
            
            if($planEstudio!=$row["idplanestudio"]){
                $planEstudio = $row["idplanestudio"];
                $numCreditos = getCreditosElectivasPlanEstudio($row["codigoestudiante"],$db);
                $arrayCreditosPlanEstudio[$row["idplanestudio"]] = $numCreditos;
            }
            
            //miro a ver si el estudiante debe alguna materia
            //$materias = getMateriasDebeEstudiante($row["codigoestudiante"],$db);
			$query = getQueryMateriasElectivasCPEstudiante($row["codigoestudiante"], false);
			$materias = $db->Execute($query);
            $numAprobados = 0;
            $numCreditosPendientes = $numCreditos;
            if($numCreditosPendientes>0){
                $electivasHTML = null;
                while ($row_electivas = $materias->FetchRow()) { 
                    //echo "<pre>";print_r($row);echo "<br/><br/>";
                    $numAprobados += $row_electivas["numerocreditos"];
                    $numCreditosPendientes = $numCreditosPendientes - $row_electivas["numerocreditos"];
                    if($electivasHTML==null){
                        $electivasHTML = "<table CELLPADDING='10' width='100%' ><tr><th>Código</th><th>Asignatura</th><th>Periodo</th><th>Créditos</th><th>Nota</th></tr>";
                    }
                    $electivasHTML .= "<tr><td>".$row_electivas["codigomateria"]."</td><td>".$row_electivas["nombremateria"]."</td>
                        <td>".$row_electivas["codigoperiodo"]."</td><td>".$row_electivas["numerocreditos"]."</td>
                            <td>".$row_electivas["notadefinitiva"]."</td></tr>";
                    //echo "<xmp>".$electivasHTML."</xmp><br/><br/>";
                }
                
                /*if($numAprobados>$numCreditos){
                            $numAprobados = $numCreditos;
                } */
                 if($numCreditosPendientes<0){
                            $numCreditosPendientes = 0;
                 }
                $arrayCreditosEstudiante[$row["codigoestudiante"]] = array("pendientes"=>$numCreditosPendientes,"aprobados"=>$numAprobados);
                if($numCreditosPendientes>0){
                    if($electivasHTML==null){
                        $electivasHTML="<table CELLPADDING='10' width='100%' ><tr><th>Código</th><th>Asignatura</th><th>Periodo</th><th>Créditos</th><th>Nota</th></tr>
                            <tr><td colspan='5' style='text-align:center'>No ha aprobado ninguna electiva.</td></tr>";
                    }
                    if($carrera!=$row["codigocarrera"]){
                        $carrera=$row["codigocarrera"];
                        $html .= "<tr><th colspan='5' class='category' >".$row["nombrecarrera"]."</th></tr>";
                    }
                    //echo "<pre>";print_r($row);echo "<br/><br/>";
                    //echo "<pre>";print_r($electivasRow);echo "<br/><br/>";
                    //.$row["codigoestudiante"]." - "
                    $html .= "<tr><td>".$row["nombre"]."</td><td>".$row["numerodocumento"]."</td>
                        <td>".$row["semestre"]."</td><td>".$row["nombresituacioncarreraestudiante"]."</td>
                            <td>".$electivasHTML."</table><p>Debe ".$numCreditosPendientes." crédito(s) de electivas libres</p></td>
                        </tr>";
                }
            }
        } if($html === "") {
             echo "<td colspan='5' style='text-align:center' >No se encontraron estudiantes con electivas pendientes.</td>";
        } else {
            echo $html;
        }
?>
            </tbody>
            </table>
        <table CELLPADDING="10" id="tableResultGeneral" style="display:none;">
             <thead>
                <tr>
                    <th>Código Estudiante</th>
                    <th>Estudiante</th>
                    <th>Documento</th>
                    <th>Semestre</th>
                    <th>Situación Estudiante</th>
                    <th># Créditos electivas aprobados</th>
                    <th># Créditos electivas en curso</th>
                    <th># Créditos electivas pendientes</th>
                </tr>
            </thead>
            <tbody>
                <?php 
            //obtener estudiantes por graduarse
            $creditosAprobadosTotal= 0;
            $creditosPendientesTotal = 0;
            $creditosAprobadosTotalS= 0;
            $creditosPendientesTotalS = 0;
            $planEstudio = 0;
            $numCreditos = 0;
            $html = "";
            $carrera = 0;
            $semestre = 0;
            $numEstudiantesCumplen = 0;
            $numEstudiantesNoCumplen = 0;
             foreach($estudiantes as $row){
                    if($planEstudio!=$row["idplanestudio"] && $arrayCreditosPlanEstudio[$row["idplanestudio"]]==null){
                        $planEstudio = $row["idplanestudio"];
                        $numCreditos = intval(getCreditosElectivasPlanEstudio($row["codigoestudiante"],$db));
                        $arrayCreditosPlanEstudio[$row["idplanestudio"]] = $numCreditos;
                    } else if($arrayCreditosPlanEstudio[$row["idplanestudio"]]!=null){
                        $numCreditos = $arrayCreditosPlanEstudio[$row["idplanestudio"]];
                    }       
                    if($arrayCreditosEstudiante[$row["codigoestudiante"]]==null){
                        $materias = $db->Execute(getQueryMateriasElectivasCPEstudiante($row["codigoestudiante"],true));
                        $row_electivas = $materias->FetchRow();
                    } else {
                        $row_electivas["numerocreditos"] = $arrayCreditosEstudiante[$row["codigoestudiante"]]["aprobados"];
                    }
                    $numCreditosPendientes = $numCreditos;
                    $numCreditosAprobados = 0;
                    $row_creditos = getMateriasElectivasEnCurso($row["codigoestudiante"],$row["codigocarrera"],$db,false);
                    if($row_creditos[0]!=null && $row_creditos[0]["creditos"]!=null){
                        $numCreditosEnCurso = $row_creditos[0]["creditos"];
                    } else {
                        $numCreditosEnCurso = 0;
                    }
                    if($numCreditosPendientes>0){
 
                        if($semestre!=$row["semestre"] || $carrera!=$row["codigocarrera"]){
                            if($carrera!=$row["codigocarrera"] && $carrera!=0){
                                $semestre = 0;
                            }
                            /*var_dump($semestre);
                            var_dump($row["semestre"]);
                            var_dump($row["codigocarrera"]);
                            var_dump($carrera);                             
                            var_dump($semestre!=0 || ($carrera!=$row["codigocarrera"] && $carrera!=0)); echo "<br/><br/>";*/
                            if($semestre!=0 || ($carrera!=$row["codigocarrera"] && $carrera!=0)){ 
                                
                                //var_dump("Total de Créditos Semestre --> " . $creditosAprobadosTotalS );       echo "<br/><br/>"; 
                                $html .= "<tr><th colspan='3'>Total de Créditos Semestre</th><th> </th><th> </th>
                                    <th>".$creditosAprobadosTotalS."</th>
                                        <th>".$creditosCursoTotalS."</th>
                                            <th>".$creditosPendientesTotalS."</th></tr>"; 
                                 }
                            $semestre=$row["semestre"];         
                            $creditosPendientesTotal += $creditosPendientesTotalS;
                            $creditosAprobadosTotal += $creditosAprobadosTotalS;
                            $creditosCursoTotal += $creditosCursoTotalS;
                            $creditosAprobadosTotalS= 0;
                            $creditosPendientesTotalS = 0;
                            $creditosCursoTotalS = 0;
                        }
                        
                        $numAprobados = $row_electivas["numerocreditos"];                        
                        if($numAprobados=="" || $numAprobados==null){
                            $numAprobados = 0;
                        }
                        $numCreditosPendientes = $numCreditosPendientes - $numAprobados;
                        if($numCreditosPendientes<0){
                            $numCreditosPendientes = 0;
                            //$numAprobados = $numCreditos;
                        } 
                        //$creditosPendientesTotal += $numCreditosPendientes;
                       // $creditosAprobadosTotal += $numAprobados;
                        $numCreditosAprobados = $numAprobados;                        
                        $creditosAprobadosTotalS += $numAprobados;
                        $creditosPendientesTotalS += $numCreditosPendientes;
                        $creditosCursoTotalS+= $numCreditosEnCurso;
                        /*while ($row_electivas = $materias->FetchRow()) { 
                            $numCreditosPendientes = $numCreditosPendientes - $row_electivas["numerocreditos"];
                            $numCreditosAprobados += $row_electivas["numerocreditos"];
                        }*/

                        if($carrera!=$row["codigocarrera"]){
                            if($carrera!=0){
                                $html .= "<tr><th colspan='3'>Total de Créditos Carrera</th><th> </th><th> </th><th>".$creditosAprobadosTotal."</th>
                                    <th>".$creditosCursoTotal."</th><th>".$creditosPendientesTotal."</th></tr>";
                          }
                            $carrera=$row["codigocarrera"];
                            $numEstudiantesCumplen = 0;
                            $numEstudiantesNoCumplen = 0;
                            $creditosAprobadosTotal= 0;
                            $creditosPendientesTotal = 0;
                            $creditosCursoTotal = 0;
                            $html .= "<tr><th colspan='8' class='category' >".$row["nombrecarrera"]."</th></tr>"; 
                         }

                        if($numCreditosPendientes>0){
                            $numEstudiantesNoCumplen += 1 ;

                            $html .= "<tr><td>".$row["codigoestudiante"]."</td><td>".$row["nombre"]."</td><td>".$row["numerodocumento"]."</td>
                                <td>".$row["semestre"]."</td>
                                <td>".$row["nombresituacioncarreraestudiante"]."</td><td>".$numCreditosAprobados."</td>
                                <td>".$numCreditosEnCurso."</td><td>".$numCreditosPendientes."</td></tr>";
                         } else {
                            $html .= "<tr><td>".$row["codigoestudiante"]."</td><td>".$row["nombre"]."</td><td>".$row["numerodocumento"]."</td>
                                <td>".$row["semestre"]."</td>
                                <td>".$row["nombresituacioncarreraestudiante"]."</td><td>".$numCreditosAprobados."</td>
                                <td>".$numCreditosEnCurso."</td><td>0</td></tr>";
                             $numEstudiantesCumplen += 1; 
                             
                        }
                    }
                } 
                    if($html === "") {
                        echo "<td colspan='8' style='text-align:center' >No se encontraron estudiantes con electivas pendientes.</td>";
                    } else {
                        $html .= "<tr><th colspan='3'>Total de Créditos Semestre</th><th> </th><th> </th><th>".$creditosAprobadosTotalS."</th>
                            <th>".$creditosCursoTotalS."</th><th>".$creditosPendientesTotalS."</th></tr>";
                        $html .= "<tr><th colspan='3'>Total de Créditos Carrera</th><th> </th><th> </th><th>".($creditosAprobadosTotal+$creditosAprobadosTotalS)."</th>
                            <th>".($creditosCursoTotal+$creditosCursoTotalS)."</th><th>".($creditosPendientesTotal)."</th></tr>";
                        echo $html;
                    } 
       ?>
            </tbody>
        </table>
    </span>
<script type="text/javascript">
    $(document).ready(function() {
        $('#formInformeCamapania').remove();
        $('#formInformeGeneral').remove();
        var htmlText = '<form  action="./imprimirReporteElectivasPendientes.php" method="post" id="formInformeCamapania" style="z-index: -1;  width:100%">';
        htmlText = htmlText + '<input type="hidden" id="datos_a_enviar" name="datos_a_enviar" /></form>';
        htmlText = htmlText + '<form  action="./imprimirReporteGeneralElectivasPendientes.php" method="post" id="formInformeGeneral" style="z-index: -1;  width:100%">';
        htmlText = htmlText + '<input type="hidden" name="codigofacultad" value="<?php echo $_REQUEST["codigofacultad"]; ?>" /><input type="hidden" name="codigoprograma" value="<?php echo $_REQUEST["codigoprograma"]; ?>" /></form>';
        $( "#ganancia" ).before( htmlText );
    });
	function exportarExcel(){
            $("#datos_a_enviar").val( $("<div>").append( $("#tableResult").eq(0).clone()).html());
            $("#formInformeCamapania").submit();
	}
        
	function exportarExcelGeneral(){
            $("#datos_a_enviar").val( $("<div>").append( $("#tableResultGeneral").eq(0).clone()).html());
            $("#formInformeCamapania").submit();
            //$("#formInformeGeneral").submit();
	}
</script>
   <?php } else {
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Electivas Pendientes</title>
        <link rel="stylesheet" href="../../../../css/themes/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" /> 
        
        <script type="text/javascript" language="javascript" src="../../../../mgi/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../../../../mgi/js/jquery-ui-1.8.21.custom.min.js"></script> 
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
    <h3>Reporte de Electivas Pendientes</h3>
    
	<fieldset style="min-width: 800px;border:0;">  
		<label for="facultad" class="fixedLabel">Facultad: </label>		
		
		<?php
                    $query = "SELECT DISTINCT f.codigofacultad,f.nombrefacultad FROM facultad f 
                                        INNER JOIN carrera c on c.codigofacultad=f.codigofacultad and c.fechavencimientocarrera>NOW() 
                                        and c.codigomodalidadacademica IN (200) 
                                        INNER JOIN planestudio p ON p.codigocarrera=c.codigocarrera AND codigoestadoplanestudio!=200 
                                        INNER JOIN detalleplanestudio dp on dp.idplanestudio=p.idplanestudio AND dp.codigotipomateria=4 
                                        ORDER BY f.nombrefacultad
                                        ";
                    $tipomodalidad = $db->Execute($query);
		?>		
		<select name="codigofacultad" id="modalidad" style='font-size:0.8em'>
		<?php while($row_tipomodalidad = $tipomodalidad->FetchRow()) {
		?>
                    <option value="<?php echo $row_tipomodalidad['codigofacultad']?>">
                    <?php echo $row_tipomodalidad['nombrefacultad']; ?>
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
				
				<div style="height:15px;" class="vacio"></div>
                
                <label for="semestre" class="fixedLabel">Semestre inicial: </label>
                <select name="semestre" style='font-size:0.8em'>
                    <option value="10">10</option>
                    <option value="9">9</option>
                    <option value="8">8</option>
                    <option value="7">7</option>
                    <option value="6">6</option>
                    <option value="5">5</option>
                    <option value="4">4</option>
                    <option value="3">3</option>
                    <option value="2">2</option>
                    <option value="1">1</option>
                </select>	
		
	
	<input type="submit" value="Consultar" style="margin: 0px 0px 10px 15px;" />	
        <img src="../../../../mgi/images/ajax-loader.gif" style="display:none;clear:both;margin:20px auto;" id="loading"/>
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
				url: './electivasPendientesFacultad.php',
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
                                url: './lookForCareersByFacultad.php',
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

