<?php 
	session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/normalize.css">
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/font-page.css">        
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/bootstrap.min.css">
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/bootstrap.css">
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/general.css">     
        <script type="text/javascript" src="../../../../assets/js/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" src="../../../../assets/js/bootstrap.js"></script>
        
        
        <!--<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">-->
        <title>Re-envio de ordenes de pago a PS</title>
		<!--<link rel="stylesheet" type="text/css" href="../mgi/css/themes/smoothness/jquery-ui-1.8.4.custom.css" media="screen" /> --> 
        <!--<link rel="stylesheet" type="text/css" href="../mgi/css/styleOrdenes.css" media="screen" />-->
        
<!--        <script type="text/javascript" language="javascript" src="../mgi/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../mgi/js/jquery-ui-1.8.21.custom.min.js"></script>-->
		<script type="text/javascript" language="javascript" src="../mgi/js/functions.js"></script>
    </head>
    <body>
        <div id="pageContainer" class="wrapper" align="center">
			<h1>Envio de Ordenes de Pago a PeopleSoft</h1>
			
			<ul id="menu" class="menu-wrapper">
				<li id="envioOrdenPS" class="btn btn-fill-green-XL">Enviar Orden de Pago</li>
				<li id="envioOrdenesPS" class="btn btn-fill-green-XL">Enviar Ordenes de Pago</li>
			</ul>
			
			<form id="formEnvioOrden" method="post">
				<?php include("_formEnviarOrden.php"); ?>
			</form>
			<div id="resultado">
			</div>
		</div>		
		
		<script type="text/javascript">
			$(document).on('click', '#formEnvioOrden button', function(e) {
				e.preventDefault();
				var valido= validateForm("#formEnvioOrden");
				if(valido){
					enviarForm();
				}
			});					
			
			$(document).on('click', '#menu #envioOrdenPS', function(e) {
				$('#formEnvioOrden').load('_formEnviarOrden.php');
                $('#menu #envioOrdenPS').addClass('menu-selected');
                $('#menu #envioOrdenesPS').removeClass('menu-selected');
			});	
			
			$(document).on('click', '#menu #envioOrdenesPS', function(e) {
				$('#formEnvioOrden').load('_formEnviarOrdenes.php');
                $('#menu #envioOrdenesPS').addClass('menu-selected');
                $('#menu #envioOrdenPS').removeClass('menu-selected');
			});
			
			function enviarForm(){
                    $('button').css("display","none");
                    $("#loading").css("display","block");
					
					if($('#action').val()=="envioOrdenes"){						
						var data = new FormData();
						jQuery.each($('#file')[0].files, function(i, file) {
							data.append('file', file);
						});
						
						$.ajax({
							url: 'processOrdenesPs.php',
							data: data,
							cache: false,
							contentType: false,
							processData: false,
							type: 'POST',
							success: function(data){
								alert(data);
							}
						});
					} else {
						$.ajax({
							dataType: 'json',
							type: 'POST',
							url: 'processOrdenesPs.php',
							data: $('#formEnvioOrden').serialize(),                
							success:function(data){
								if (data.success == true){
									alert(data.message);
								}
								else{ 
									alert(data.message);
									//$('#msg-error').html('<p>' + data.message + '</p>');
									//$('#msg-error').addClass('msg-error');
								}
								$('button').css("display","block");
								$("#loading").css("display","none");
							},
							error: function(data,error,errorThrown){alert(error + errorThrown);}
						}); 
					}					
                }

		</script>
	</body>
</html>
