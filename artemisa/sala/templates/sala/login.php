<?php
defined('_JEXEC') or die ;
//echo $content;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de gestión académica en línea - SALA</title>

	<?php
		$uriBase=JURI::base();
		$base=dirname(__FILE__);
		jimport('includes.header', $base); 
		printHeaders($uriBase);
	?>
	<link href="<?php echo $uriBase;?>templates/sala/css/template_login.css" rel="stylesheet">
</head>
<body class="path-auth path-auth-token"> 
	<div class="container" id="page-auth-token-login">
		<jdoc:include type="component" />
	</div>
</body>
</html>