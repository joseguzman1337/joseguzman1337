<?php
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

//session_start();

//require_once('../../../funciones/clases/autenticacion/redirect.php');
ini_set('memory_limit', '128M');
ini_set('max_execution_time','216000');
//print_r($_SESSION);
error_reporting(0);
if(isset($_GET['codigomodalidadacademica']) and isset($_GET['codigocarrera']) and isset($_GET['codigoperiodo'])) {
    $_SESSION['codigomodalidadacademica']=$_GET['codigomodalidadacademica'];
    $_SESSION['codigocarrera']=$_GET['codigocarrera'];
    $_SESSION['codigoperiodo_reporte']=$_GET['codigoperiodo'];
}
$situacioncarreraestudiante[]='Inscritos';
$situacioncarreraestudiante[]='Inscritos_Admitidos';
$situacioncarreraestudiante[]='Admitidos_Matriculados';
$situacioncarreraestudiante[]='Porcentaje_Absorcion_Inscritos_Admitidos';
$situacioncarreraestudiante[]='Porcentaje_Absorcion_Admitidos_Matriculados';

//exit();
//print_r($_GET['criteriosituacion']);
if(is_array($_GET['criteriosituacion'])) {
    $arraymenuopcion=$_GET['criteriosituacion'];
}
else {
    $arraymenuopcion=$situacioncarreraestudiante;
}
?>
<script language="Javascript">
    function abrir(pagina,ventana,parametros) {
        window.open(pagina,ventana,parametros);
    }
</script>
<script language="javascript">
    function enviar()
    {
        document.form1.submit()
    }
</script>
<?php
$rutaado=("../../../funciones/adodb/");
require_once('../../../Connections/salaado-pear.php');
require_once('funciones/funcion-barra.php');
require_once("funciones/obtener_datos.php");
?>
<?php
setlocale(LC_MONETARY, 'en_US');
$fechahoy=date("Y-m-d H:i:s");
?>
<?php
$_SESSION['sesionFecha_Proximo_Contacto']= '';
$_SESSION['sesionf_Fecha_Proximo_Contacto']='';
$_SESSION['sesionFiltrar']='';
$_SESSION['get']='';
unset($_SESSION['sesionFecha_Proximo_Contacto']);
unset($_SESSION['sesionf_Fecha_Proximo_Contacto']);
unset($_SESSION['sesionFiltrar']);
unset($_SESSION['get']);

$contador=0;
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<br>";
echo "<table width='100%'  border='0'><tr><td><div align='center'><h3>Este proceso puede demorar algunos minutos, porfavor espere...</h3></div></td></tr></table>";
echo "<div id='progress' style='position:relative;padding:0px;width:768px;height:60px;left:25px;'>";
$datos_matriculas=new obtener_datos_matriculas($sala,$_SESSION['codigoperiodo_reporte']);
if(isset($_SESSION['codigomodalidadacademica']) and isset($_SESSION['codigocarrera'])) {
    if($_SESSION['codigomodalidadacademica']=="todos" and $_SESSION['codigocarrera']=="todos") {
        $carreras=$datos_matriculas->obtener_carreras("","");
    }
    elseif($_SESSION['codigomodalidadacademica']=="todos" and $_SESSION['codigocarrera']!="todos") {
        $carreras=$datos_matriculas->obtener_carreras("",$_SESSION['codigocarrera']);
    }
    elseif($_SESSION['codigomodalidadacademica']!="todos" and $_SESSION['codigocarrera']=="todos") {
        $carreras=$datos_matriculas->obtener_carreras($_SESSION['codigomodalidadacademica'],"");
    }
    else {
        $carreras=$datos_matriculas->obtener_carreras("",$_SESSION['codigocarrera']);
    }
}
//print_r($arraymenuopcion);
//exit();
foreach ($carreras as $llave_carreras => $valor_carreras) {

    if($contador % 3==0) {
        echo '<img src="funciones/barra.gif" width="8" height="28">';
    }
    $datos_matriculas->barra();
    $array_datos[$contador]['codigocarrera']=$valor_carreras['codigocarrera'];
    $array_datos[$contador]['Centro_Beneficio']=$valor_carreras['centrobeneficio'];
    $array_datos[$contador]['Programa']=$valor_carreras['nombrecarrera'];

    if(in_array('Inscritos',$arraymenuopcion)) {
        $array_datos[$contador]['Inscritos']=$datos_matriculas->ObtenerInscritos($_SESSION['codigoperiodo_reporte'],$valor_carreras['codigocarrera'],153,'conteo');
    }
    if(in_array('Inscritos_Admitidos',$arraymenuopcion)) {
        $array_datos[$contador]['Inscritos_Admitidos']=$datos_matriculas->ObtenerAdmitidos($_SESSION['codigoperiodo_reporte'],$valor_carreras['codigocarrera'],153,'conteo');
    }
    if(in_array('Admitidos_Matriculados',$arraymenuopcion)) {
        $array_datos[$contador]['Admitidos_Matriculados']=$datos_matriculas->ObtenerMatriculados($valor_carreras['codigocarrera'],'conteo');
    }
    if(in_array('Porcentaje_Absorcion_Inscritos_Admitidos',$arraymenuopcion)) {
        $array_datos[$contador]['Porcentaje_Absorcion_Inscritos_Admitidos']=round(($datos_matriculas->ObtenerAdmitidos($_SESSION['codigoperiodo_reporte'],$valor_carreras['codigocarrera'],153,'conteo')/$datos_matriculas->ObtenerInscritos($_SESSION['codigoperiodo_reporte'],$valor_carreras['codigocarrera'],153,'conteo'))*100,2);
    }
    if(in_array('Porcentaje_Absorcion_Admitidos_Matriculados',$arraymenuopcion)) {
        $array_datos[$contador]['Porcentaje_Absorcion_Admitidos_Matriculados']=round(($datos_matriculas->ObtenerMatriculados($valor_carreras['codigocarrera'],'conteo')/$datos_matriculas->ObtenerInscritos($_SESSION['codigoperiodo_reporte'],$valor_carreras['codigocarrera'],153,'conteo'))*100,2);
    }

    $contador++;
}

echo "</div>";
if(is_array($array_datos)) {
    $_SESSION['array_estadisticas']=$array_datos;
}
//$datos_matriculas->listar($array_datos);
echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=tabla_estadisticas_matriculas.php'>";
//echo '<script language="javascript">window.location.reload("tabla_estadisticas_matriculas.php");</script>';

?>
