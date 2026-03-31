<?php

session_start();
 if(!isset ($_SESSION['MM_Username'])){

    echo "No ha iniciado sesión en SALA.";
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
    include_once('./functions.php');

   ?>

  <?php  if(isset($_REQUEST["modalidad"]) && $_REQUEST["modalidad"]!=""){ 
      ?>
    <div style="display: inline-block;">
        <button type="button" style="margin-bottom:10px;float:right;clear:both;" onclick="exportarPlano()">Generar archivo de texto</button>
        <div style="height:1px;clear:both;"></div>
        <table CELLPADDING="10" id="tableResult">
            <thead>
                <tr>
                    <th>Número</th>
                    <th>Cédula</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Nivel Educativo (Inicial)</th>
                    <th>Filiación Política (Código)</th>
                    <th>Dirección de Residencia</th>
                    <th>Teléfono fijo</th>
                    <th>Celular</th>
                    <th>E-Mail</th>
                    <th>Tipo Documento</th>
                    <th>Lugar de Expedición</th>
                    <th>Lugar de Nacimiento</th>
                    <th>Nombre Carrera</th>
                    <th>Edad</th>
                    <th>Nivel Educativo</th>
                    <th>Filiación Política</th>
                </tr>
            </thead>
            <tbody>
       <?php 
       //obtener estudiantes por graduarse
       $estudiantes = getEstudiantesJurados($_REQUEST["modalidad"],$_REQUEST["codigoperiodo"],$db);
            
            echo $estudiantes["html"]; 
?>
            </tbody>
            </table>
      
    </div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#formInformeEstudiantes').remove();
        var htmlText = '<form  action="./downloadTXT.php" method="post" id="formInformeEstudiantes" style="z-index: -1;  width:100%">';
        //htmlText = htmlText + '<input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />';
        htmlText = htmlText + '<input type="hidden" name="modalidad" value="<?php echo base64_encode(serialize($_REQUEST["modalidad"])); ?>" />';
        htmlText = htmlText + '<input type="hidden" name="codigoperiodo" value="<?php echo $_REQUEST["codigoperiodo"]; ?>" />';
        htmlText = htmlText + '<input type="hidden" id="datos_a_enviar" name="datos_a_enviar" /></form>';
        $( "#reporte" ).before( htmlText );
    });
	function exportarPlano(){
            //$("#datos_a_enviar").val('<?php echo $estudiantes["encoded"]; ?>');
            alert("Tenga en cuenta que este proceso puede demorar varios minutos.");
            $("#formInformeEstudiantes").submit();
	}
</script>
   <?php } else {
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Estudiantes Posibles Jurados</title>
        <link rel="stylesheet" href="../../css/themes/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" /> 
        
        <script type="text/javascript" language="javascript" src="../../mgi/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../../mgi/js/jquery-ui-1.8.21.custom.min.js"></script> 
        <script type="text/javascript" language="javascript" src="../../js/functionsUtil.js"></script> 
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
    }
        
        .checklist li{
            padding: 5px;
        }
    
    ul.checklist {
            height: auto;
            border: 1px solid #A17C04;
            color: #000;
            font-family: Tahoma,Geneva,Arial,sans-serif;
            font-size: 0.9em;
            max-height: 200px;
            width:60%;
            min-width:600px;
            height:auto;
            list-style: none outside none;
            overflow: auto;
            padding: 0;
            margin: 5px 0;
        }
        
        .alt {
            background: none repeat scroll 0 0 #F8F6ED;
        }
        
        ul.checklist li:hover {
            background: none repeat scroll 0 0 #EFE9D4;
            color: #A05A04;
        }
        
        h3{
            margin: 15px 0 10px;
        }
        </style>
    </head>
    <body>
<form action="" method="post" id="reporte" class="report">
    <h3>Estudiantes para Jurados de Votación</h3>
	<fieldset style="min-width: 800px;border:0;">  
            <?php $periodo = getPeriodo($db);
            $modalidades = getModalidades($db); ?>
                
                <label for="facultad" class="fixedLabel">Periodo: </label>
                <span><?php echo $periodo["nombreperiodo"]; ?></span>
                <input type="hidden" value="<?php echo $periodo["codigoperiodo"]; ?>" name="codigoperiodo" />
                <div class="vacio"></div>
                
		<label for="facultad" class="fixedLabel">Modalidad(es): </label>
                
                <ul class="checklist">
                    <?php $clase = true;
                    while($row = $modalidades->FetchRow()){ ?>
                    <li <?php if($clase) { ?>class="alt"<?php } $clase=!$clase; ?>><input type="checkbox" name="modalidad[]" value="<?php echo $row["codigomodalidadacademicasic"]; ?>"> <?php echo $row["nombremodalidadacademicasic"]; ?></li>
                    <?php } ?>
                </ul>	
                
                <input type="submit" value="Consultar" style="margin: 10px 0 0;" />
                
    <p>Nota: No se tienen en cuenta estudiantes de las <a href="#" onclick="javascript:openPopUp('./verEspecializaciones.php'); return false;">carreras Medico-Quirúrgica</a>. Tampoco se cuentan 
        estudiantes con discapacidades motoras. Ni extranjeros. Ni personas mayores a 60 años.</p>	
		
	
		
        <img src="../../mgi/images/ajax-loader.gif" style="display:none;clear:both;margin:20px auto;" id="loading"/>
		<div id='tableDiv'></div>
	</fieldset>
</form>
<script type="text/javascript">   
    //cuando le hace click al li entonces lo selecciona
    $(function() {
        var enCheckbox = false;
        $("ul.checklist li").click(function() {   
            if(!enCheckbox){
                var $check = $(this).children('input[type=checkbox]');
                $check.prop("checked", !$check.is(':checked'));
            }
            enCheckbox = false;
        });
        
        $("ul.checklist li input").click(function() {   
            enCheckbox = true;
        });
    });
    
	$(':submit').click(function(event) {
		event.preventDefault();
                var atLeastOneIsChecked = $('input:checkbox').is(':checked');
                if(atLeastOneIsChecked){
                    sendForm();
                } else {
                    alert("Por favor seleccione al menos una modalidad.");
                }
	});
        
	function sendForm(){
            $('#tableDiv').html("");
            $("#loading").css("display","block");
		$.ajax({
				type: 'GET',
				url: './reporteEstudiantes.php',
				async: false,
				data: $('#reporte').serialize(),                
				success:function(data){	
                                    $("#loading").css("display","none");				
					$('#tableDiv').html(data);					
					
				},
				error: function(data,error,errorThrown){alert(error + errorThrown);}
		});           
	}
        
</script>
    <?php } ?>
</body>
</html>