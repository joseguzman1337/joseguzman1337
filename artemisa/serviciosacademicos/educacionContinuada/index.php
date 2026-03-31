<?php
session_start();
//error_reporting(E_ALL);
//ini_set('display_errors', '0');
include("templates/template.php");
$db = getBD();
$utils = Utils::getInstance(); 
$categorias = $utils->getCategoriasMenu($db);
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Sistema Educación Continuada</title>
		<meta name="description" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link rel="stylesheet" href="css/normalize.css">
		<link rel="stylesheet" href="css/main.css">
		<script type="text/javascript" src="../mgi/js/jquery.min.js"></script>
		<script type="text/javascript" src="../mgi/js/jquery-ui-1.8.21.custom.min.js"></script>
		<script type="text/javascript">
			
			function expandirMenu(id){
				$( id ).toggle();
			}
		</script>
		

	</head>
	<body id="mando">
		<!--[if lt IE 7]>
			<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
		<![endif]-->

		<!-- Add your site or application content here -->
		<div id="encabezado">
			<div class="cajon">
				<h1>Sistema Educación Continuada</h1>
			</div>
		</div>

		<div id="grueso">
			<div class="cajon">
			<?php $contador=0;foreach($categorias as $cat) { $contador++;
				$enlaces = $utils->getEnlacesMenuCategoria($db, $cat["idmoduloEducacionContinuada"]);
				/*if($contador===1){ ?>
				<ul class="programa">
				<?php }*/ ?>
							<!--<li class="bloque col1">-->
							<li class="bloque col3">
								<a href="javascript:expandirMenu('#menuEC-<?php echo $cat["idmoduloEducacionContinuada"]; ?>');" class="nivel1a"><?php echo $cat["modulo"]; ?><div class="colapsable"></div></a>
								
								<div id="menuEC-<?php echo $cat["idmoduloEducacionContinuada"]; ?>" style="display:none;" class="contenedor">
									<ul>
										<?php foreach($enlaces as $enlace) { ?>
                                            <li>
                                               <a href="../<?php echo $enlace["url"]; ?>" ><?php echo $enlace["modulo"]; ?> </a>
                                            </li>
										<?php } ?>
									</ul>
								</div>
							</li>
							<?php /*if($contador===3){ $contador = 0; ?>
				</ul>
			<?php }*/ } 
			if(count($categorias)===0){ echo "<li style='text-align:center;'>No tienes permisos asignados.</li>";
				} /*else if($contador!=3) { echo "</ul>"; } */ ?>
			</div>
		</div>
	</body>
</html>