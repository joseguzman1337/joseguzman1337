<?php
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
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
      include_once('./functionsEstudiantesExtranjeros.php');
   ?>

  <?php  if(isset($_REQUEST["codigomodalidad"]) && $_REQUEST["codigomodalidad"]!=""){ 
      ?>
    <span style="display: inline-block;">
        <button type="button" style="margin-bottom:10px;float:right;clear:both;" onclick="exportarExcelGeneral()">Exportar a Excel</button>
        <div style="height:1px;clear:both;"></div>
        <table CELLPADDING="10" id="tableResult">
            <thead>
                <tr>
                    <th>Programa Académico</th>
                    <th>Periodo Académico Inicio</th>
                    <th>No. Documento</th>
                    <th>Tipo de Documento</th>
                    <th>Nombres y Apellidos</th>
                    <th>Semestre</th>
                    <th>Lugar de Nacimiento</th>
                    <th>Lugar de Expedición Documento</th>
					<th>Categoria Visa</th>
					<th>Número Visa</th>
					<th>Número Permiso</th>
					<th>Tipo Permiso</th>
					<th>Fecha Expedición</th>
					<th>Fecha Vencimiento</th>
                </tr>
            </thead>
            <tbody>
       <?php 
       //obtener estudiantes por graduarse
       $estudiantes = getEstudiantesExtranjeros($db,$_REQUEST["codigomodalidad"],$_REQUEST["tipo"],$_REQUEST["codigoprograma"],$_REQUEST["codigoperiodo"]);
        $html = "";
	    while($row = $estudiantes->FetchRow()) {
			
			/*
			 * @modified David Perez <perezdavid@unbosque.edu.co>
			 * @since  Mayo 03, 2018
			 * Se añade validación en el nuevo reporte para incluir la nueva categoria
			*/
					if($row["TipoPermiso"] === '1')
						{
							$row["TipoPermiso"]='Visa';
						}if($row["TipoPermiso"] === '2'){
							$row["TipoPermiso"]='Permiso Estudio';
						}if($row["TipoPermiso"] === '3'){
							$row["TipoPermiso"]='Permiso Especial de Permanencia';
						}
					$html .= "<tr><td>".$row["nombrecarrera"]."</td>
						<td>".$row["codigoperiodo"]."</td>
						<td>".$row["numerodocumento"]."</td>
                        <td>".$row["nombrecortodocumento"]."</td>
						<td>".$row["nombre_completo"]."</td>
						<td>".$row["semestreprematricula"]."</td>
						<td>".$row["nombreciudad"]."</td>
						<td>".$row["expedidodocumento"]."</td>
						<td>".$row["CategoriaVisa"]."</td>
						<td>".$row["NumeroVisa"]."</td>
						<td>".$row["NumeroVisaT"]."</td>
						<td>".$row["TipoPermiso"]."</td>
						<td>".$row["FechaExpedicion"]."</td>
						<td>".$row["FechaVencimiento"]."</td>
                        </tr>";
        }
		
        if($html === "") {
             echo "<td colspan='7' style='text-align:center' >No se encontraron estudiantes extranjeros.</td>";
        } else {
            echo $html;
        }
?>
            </tbody>
            </table>
        
    </span>
<script type="text/javascript">
    $(document).ready(function() {
        $('#formInformeCamapania').remove();
        var htmlText = '<form action="../../utilidades/imprimirReporteExcel.php" method="post" id="formInformeCamapania" style="z-index: -1;  width:100%">';
        htmlText = htmlText + '<input type="hidden" id="datos_a_enviar" name="datos_a_enviar" /></form>';
        $( "#ganancia" ).before( htmlText );
    });
        
	function exportarExcelGeneral(){
            $("#datos_a_enviar").val( $("<div>").append( $(tableResult).eq(0).clone()).html());
            $("#formInformeCamapania").submit();
	}
</script>
   <?php } else {
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Estudiantes Extranjeros</title>
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
            width: 100px;
    }
        </style>
    </head>
    <body>
<form action="" method="post" id="ganancia" class="report">
    <h3>Reporte de Estudiantes Extranjeros</h3>
    
	<fieldset style="min-width: 800px;border:0;">  
		<label for="codigomodalidad" class="fixedLabel">Modalidad <span style="color:red">*</span>: </label>		
		
		<?php
                    $tipomodalidad = getModalidades($db);
                    $periodos = getPeriodos($db);
		?>		
		<select name="codigomodalidad" id="modalidad" style='font-size:0.8em'>
		 <option value="" selected></option>
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
				<div style="height:15px;" class="vacio"></div>
                
                <label for="codigoperiodo" class="fixedLabel">Periodo académico: </label>
                <select name="codigoperiodo" style='font-size:0.8em'>                    
					<?php while($row_tipomodalidad = $periodos->FetchRow()) {
					?>
								<option value="<?php echo $row_tipomodalidad['codigoperiodo']?>">
								<?php echo $row_tipomodalidad['codigoperiodo']; ?>
								</option>
					<?php
					}
					?>
                </select>	
				
				<div style="height:15px;" class="vacio"></div>
                
                <label for="tipo" class="fixedLabel">Tipo de Consulta: </label>
                <select name="tipo" style='font-size:0.8em'>
                    <option value="1" selected>Matriculados</option>
                    <option value="2">Graduados</option>
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
			if($('#modalidad').val()!=""){
				$('#tableDiv').html("");
				$("#loading").css("display","block");
				$.ajax({
						type: 'GET',
						url: 'estudiantesExtranjeros.php',
						async: false,
						data: $('#ganancia').serialize(),                
						success:function(data){	
							$("#loading").css("display","none");				
							$('#tableDiv').html(data);					
							
						},
						error: function(data,error,errorThrown){alert(error + errorThrown);}
			
				}); 
			} else {
				alert("Debe escoger una modalidad antes de continuar");
			}
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
                                url: '../../utilidades/modalidades_programas/lookForCareersByModalidad.php',
                                data: { modalidad: mod },     
                                success:function(data){									 
									var html = '<option value="1" selected>Todos los programas</option>';
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

