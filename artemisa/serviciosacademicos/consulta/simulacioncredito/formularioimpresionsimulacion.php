<?php
session_start();

$rutaado = "../../funciones/adodb/";
require_once('../../Connections/sala2.php' );
require_once('../../Connections/salaado.php' );
require_once('../../funciones/simulacioncredito/clasesimulacioncredito.php' );
require_once('../../funciones/CalcDate.php' );

$codigoestudiante = $_SESSION['codigo'];
$codigoperiodo = $_SESSION['codigoperiodosesion'];

// Creación de la clase simulacion credito
@$sc = new clasesimulaciocredito($db,$seldataestudiante->fields['nombre'],$codigoestudiante);
// Inicializar valores de condición crédito
$sc->inicializarcondicioncredito($codigoperiodo);
//$db->debug = true; 
?>
<html>
<head>
<title>Formulario Simulación</title>
</head>
<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 9px}
.Estilo2 {font-family: Tahoma; font-size: 9px; font-weight: bold; }
.Estilo3 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; }
-->
</style>
<script language="javascript">
	print();
</script>
<body>
<?php
$sc->formulariosimulacion("../../funciones/simulacioncredito/",$_GET['idsimulacioncredito']);
?>
</body>
</html>
