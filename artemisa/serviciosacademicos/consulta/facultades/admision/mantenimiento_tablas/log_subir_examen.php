<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
session_start();
require_once('../../../../funciones/clases/autenticacion/redirect.php' ); 
?>
<link rel="stylesheet" type="text/css" href="../../../../estilos/sala.css">
<script language="javascript">
function reCarga(pagina){
	document.location.href=pagina;
}
</script>
<?php
ini_set('memory_limit', '64M');
ini_set('max_execution_time','90');
$rutaado=("../../../../funciones/adodb/");
require_once('../../../../Connections/salaado-pear.php');
require_once('../../../../funciones/clases/motor/motor.php');
require_once('../../../../funciones/clases/debug/SADebug.php');
$fechahoy=date("Y-m-d H:i:s");
$_SESSION['get']=$_GET;
$logexamen=$_SESSION['log_subir_examen'];
$i=0;
foreach($logexamen as $ilogexamen => $filalogexamen){
    if(trim($filalogexamen["codigoestudiante"])==""){
        $arrayfinal[$i]["Estado"]="<img src='../../../../../aspirantes/imagenes/enlineabotones/indicadores3.gif' id='rojo'>";
    }
    else{
        $arrayfinal[$i]["Estado"]="<img src='../../../../../aspirantes/imagenes/enlineabotones/indicadores1.gif' id='rojo'>";
    }
    foreach ($filalogexamen as $llave=>$valor){
        $arrayfinal[$i][$llave]=$valor;
    }
    $i++;
}
$log = new matriz($arrayfinal,'Log de carga examenes','log_subir_examen.php','si','si','menuadministracionresultados.php','menu_subir_examen.php');
$log->mostrar();
?>
