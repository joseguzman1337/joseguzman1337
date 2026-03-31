<?php
	session_start();
    include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
?>
<HTML>
	<HEAD>
		<meta charset="utf-8">		
		<link rel="stylesheet" href="../../../assets/css/bootstrap.min.css">
		<link href="../../../assets/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
		<script src="../../../assets/js/jquery.min.js"></script>
		<script src="../../../assets/js/moment.min.js"></script>
		<script src="../../../assets/js/bootstrap-datetimepicker.min.js"></script>
		<script src="../../../assets/js/bootstrap-datetimepicker.es.js"></script>
		<script type="text/javascript">
		 $( document ).ready(function() {
                $(".form_datetime").datetimepicker({
                     format: 'YYYY-MM-DD'
				});
        	});
		</script>
		<title>Reporte de Pagos</title>
	</HEAD>	
	<BODY>
		<div class="container" >			
			<form name="formulario" method="post" action="consultarpagos.php">				
				 <div class="form-group">
					 <div class="row">
						  <center><h1>REPORTE DE PAGOS</h1></center>
					 </div>
					 <br>
					 <div class="row">						 
						 <div class="col-xs-2 col-md-offset-3">
							<h4><strong>Fecha Inicial:</strong></h4>
						 </div>
						 <div class="col-xs-4 " >
							 <div class='input-group date form_datetime' >
								 <input type="text" class="form-control"  id= "fechainicio" name="fechainicio" required>							 
								 <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>	
							 </div>
						 </div>
					 </div>					 
					 <div class="row">
						  <div class="col-xs-2 col-md-offset-3">
							<h4><strong>Fecha Final:</strong></h4>
						 </div>
						 <div class="col-xs-4">
							 <div class='input-group date form_datetime' >
								 <input type="text" class="form-control" id= "fechafin"  name="fechafin" required>	
                                 <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>	
						 	</div>						 
						</div>
					</div>	
                    <br> 
					<div class="row">
						<div class="col-xs-6 col-md-offset-5">
							<input type="submit" value="Exportar"  class="btn btn-warning" >
						</div>
					</div>
				</div>				
			</form>
        </div>
    </BODY>
</HTML>
