<?php
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION); 
     
    session_start();
    require_once('../../Connections/sala2.php');
	$rutaado = "../../funciones/adodb/";
    require_once('../../Connections/salaado.php');
	
	$doc_id=$_GET["doc"];
	$id=$_GET["archivo"];
	$SQL_VF='SELECT  
	
							descripcion,nombre_archivo
						
							FROM 
							
							siq_archivo_documento
							
							WHERE
							
							siq_documento_id="'.$doc_id.'"
							AND
							codigoestado=100
							AND
							idsiq_archivodocumento="'.$id.'"';
			
		if($Result_VF=&$db->Execute($SQL_VF)===false){
				$a_vectt['val']			='FALSE';
				$a_vectt['descrip']		='Error en el SQl de los Version final...<br>'.$SQL_VF;
				echo json_encode($a_vectt);
				exit;
			}
 ?>
     <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <style type="text/css" title="currentStyle">
                @import "../css/normalize.css";
                @import "../../css/demo_page.css";
                @import "../../css/demo_table_jui.css";
                @import "../../css/themes/smoothness/jquery-ui-1.8.4.custom.css";
    </style>
    <script type="text/javascript" src="../js/ajax.js">/*TODAS LAS FUCNIONES DE AJAX*/</script>
    <script src="../js/jquery_ui/js/jquery.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="../js/jquery_ui/js/jquery-ui.custom.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
    <link rel="stylesheet" rev="stylesheet" href="../js/jquery_ui/css/ui-lightness/jquery-ui.custom.css" media="all" />
    <?php if(is_file("../css/Style_Bosque.css")) { ?>
        <link rel="stylesheet" href="../css/Style_Bosque.css" type="text/css" />
		<?php } ?>
		<style>
			#principal{
				margin: 20px 40px;
			}
			label{
				display:block;
				margin-bottom:5px;
			}
			textarea{
				width:100%;
				height:100px;
				border: 1px solid #ccc;
				padding:5px;
				margin-bottom:10px;
			}
			a{
				display: inline-block;
				margin-left:20px;
				color: red;
				font-weight:bold;
				text-decoration:underline;
			}
		</style>
		</head>
	<body>
		<div id="principal">
		<h4><?php echo $Result_VF->fields["nombre_archivo"]; ?></h4>
		<form method="POST" action="processDocumento.php">
			<input type="hidden" name="doc_id" value="<?php echo $doc_id; ?>" />
			<input type="hidden" name="archivo_id" value="<?php echo $id; ?>" />
			<input type="hidden" name="action" value="editarDocumento" />
			<input type="hidden" name="url" value="<?php echo htmlspecialchars($_SERVER["HTTP_REFERER"]); ?>" />
			<label>Descripción:</label>
			<textarea name="descripcion"><?php echo $Result_VF->fields["descripcion"]; ?></textarea>
			<input type="submit" value="Guardar"/>
			<a href="<?php echo htmlspecialchars($_SERVER["HTTP_REFERER"]); ?>">Cancelar</a>
		</form>
	</div>
 </body>
 </html>