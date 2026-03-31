<?php 
error_reporting(E_ALL);

ini_set('memory_limit', '16384M');
ini_set('max_execution_time', 24000);
date_default_timezone_set("America/Bogota");
?>
    
<html>
    <head>
        <title>Perdidad por plan estudios</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link type="text/css" rel="stylesheet" href="../../assets/css/normalize.css">
		<link type="text/css" rel="stylesheet" href="../../assets/css/font-page.css">
		<link type="text/css" rel="stylesheet" href="../../assets/css/font-awesome.css">
		<link type="text/css" rel="stylesheet" href="../../assets/css/bootstrap.css">
		<link type="text/css" rel="stylesheet" href="../../assets/css/general.css">
		<link type="text/css" rel="stylesheet" href="../../assets/css/chosen.css">
		<script type="text/javascript" src="../../assets/js/jquery-3.6.0.min.js"></script>
		<script type="text/javascript" src="../../assets/js/bootstrap.js"></script> 
    </head>
    <body>
        <div class="container">
            <center>
                <h2>Informe plan de estudios Perdidas</h2>
                <br>
                <div class="row">
                    <div class="col-md-3">
                        <h3>Periodo:</h3>
                    </div>
                    <div class="col-md-3">
                        <input type="text" id="periodo" name="periodo" maxlength="5" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <input class="btn btn-fill-green-XL" type="button" id="consultar" value="consultar" onclick="consultar()">
                    </div>
                    <div class="col-md-2" id="exportarbtn" style="display:none;" id="exportExcel">
                        <button class="btn btn-fill-green-XL" type="button" id="exportExcel">
                            Exportar a Excel
                        </button>
                        <form id="formInforme" method="post" action="../../assets/lib/ficheroExcel.php" align="center">
                            <input  id="datos_a_enviar" type="hidden" name="datos_a_enviar">
                        </form>
                    </div>
                </div>
                <br/>
                <div id="procesando" style="display:none">
                    <img src="../../assets/ejemplos/img/Procesando.gif" witdh="400px"><br>
                    <p>Procesando, por favor espere...</p>
                </div>
            </center>
            <div class="table-responsive" id="tabla" style="display: none">                
                <table id="dataR" class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>codigo programa</th>
                            <th>Programa Academico</th>
                            <th>Plan de estudios</th>
                            <th>codigo Materia</th>
                            <th>Materia</th>
                            <th>Tipo Materia</th>
                            <th>Cod Programa padre</th>
                            <th>Programa padre</th>
                            <th>Semestre</th>
                            <th>Total matriculados</th>
                            <th>Corte 1</th>
                            <th>%</th>
                            <th>Corte 2</th>                            
							<th>%</th>
                            <th>Corte 3</th>                            
							<th>%</th>
                            <th>Nota Final</th>                            
							<th>%</th>
                        </tr>
                    </thead>                    
                    <tbody id="dataReporte">
                    </tbody>                     
                </table>        
            </div>
        </div>
    </body>
</html>
<script>
    $('#exportExcel').click(function (e) 
    {
        $("#datos_a_enviar").val($("<div>").append($("#dataR").eq(0).clone()).html());
        $("#formInforme").submit();
        //$('#procesando').attr("style", "display:inline");
    });
    function consultar()
    {
        var periodo1 = $('#periodo').val(); 
		if(periodo1)
		{
			 $.ajax({
				dataType: 'json',
				type: 'POST',
				url: 'funciones/funciones.php',
				dataType: "html",
				data:{periodo1:periodo1, action:"ConsultarPlanEstudio"},   
				beforeSend: function() {   
					$('#procesando').attr("style", "display:inline");   
					$('#tabla').attr("style", "display:none");
				},
				success:function(data){                      
					$('#procesando').attr("style", "display:none");
					$('#dataReporte').html(data);
					$('#tabla').attr("style", "display:inline");
					$('#exportarbtn').attr("style", "display:inline");
				},
				error: function(data,error)
				{
					alert("Error en la consulta de los datos.");
				}
			});
		}else
		{
			alert("Debe seleccionar el periodo a consultar.");
		} 
    }//funtion consultar
</script>