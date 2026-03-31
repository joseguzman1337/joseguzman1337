<?php
// echo "<pre>"; print_r($_SESSION);
if (!isset($_SESSION)) { 
	session_start();
}else{
	die("Inicie sesión de nuevo");
}

require_once("../templates/template.php");
$db = writeHeader('bbbb',true);
require_once("./consultas_class.php");
$objeto = new ConsultarEspacios;
// echo "<pre>"; print_r($_SESSION);

if($_POST['Buscar']==1){
	$objeto->ConsultarBloque($_POST['dato']);
	exit();
}
?>
<!DOCTYPE html>
<!--[if lt IE 7 ]> <html class="ie6"> <![endif]-->
<!--[if IE 7 ]>    <html class="ie7"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie8"> <![endif]-->
<!--[if IE 9 ]>    <html class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> 
<html class=""> <!--<![endif]-->
<head>
	<meta charset="utf-8" />
	<title>Menú</title>	
	<script type="text/javascript" href="http://code.jquery.com/jquery-3.6.0.min.js"></script>
		
</head>
<body>
	<form name="formul">
		<div>
			<h1>Eventos programados</h1>
		</div>
		<div>
			<label>Sitio:</label> 
			<select name="miSelect">
			<?php 
			$consultaSedes = $objeto->ConsultarSedes();   
			echo '<pre>';print_r($consultaSedes);
			while (!$consultaSedes->EOF) { 
				?>
				<option value"<?php echo $consultaSedes->fields['ClasificacionEspaciosId']; ?>" onclick="bloques(<?php echo $consultaSedes->fields['ClasificacionEspaciosId']; ?>)" select><?php echo $consultaSedes->fields['Nombre']; ?></option>
				<?php
				$consultaSedes->MoveNext();
				}
			?>
			</select>
		</div>
	</form>
</body>
</html>
<script>
function bloques(dato){
	$.ajax({//Ajax
              type: 'POST',
              url: './consultas_class.php',
              async: false,
              dataType: 'html',
              data:({Buscar:1,dato: dato}),
              error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
              success: function(data){
                   $('#').html(data); 
            	}//data 
        }); //AJAX
	
	
}
</script>
