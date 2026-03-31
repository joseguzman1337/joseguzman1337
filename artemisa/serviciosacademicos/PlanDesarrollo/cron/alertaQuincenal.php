
<html>
<head>
	<style>
		table, td, th {    
			border: 1px solid #ddd;
			text-align: left;
		}

		table {
			border-collapse: collapse;
			width: 100%;
		}

		th, td {
			padding: 10px;
		}
	</style>
</head>
<body>
<?php
	include_once ("../funciones/funciones.php");
	$funciones = new funciones();
	echo $funciones->alertaQuincenal();
?>
</body>
</html>