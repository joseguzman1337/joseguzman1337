<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
session_start();
ini_set('memory_limit', '64M');
ini_set('max_execution_time','90');
?>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
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
require_once("funciones/obtener_datos.php");
require_once("../../../funciones/clases/motorv2/motor.php");

require_once("DatosOrdenePagoReporte_class.php");   $C_DatosPagosReporte = new DatosOrdenPagoReporte();
?>
<?php
$codigoperiodo=$_SESSION['codigoperiodoinf'];
$codigoconcepto=$_SESSION['codigoconceptoinf'];
$codigocarrera=$_SESSION['codigocarrerainf'];
$codigomodalidadacademica=$_SESSION['codigomodalidadacademicainf'];

if(!empty($codigoperiodo) and !empty($codigoconcepto) and !empty($codigocarrera) and !empty($codigomodalidadacademica)){
	setlocale(LC_MONETARY, 'en_US');
	$fechahoy=date("Y-m-d H:i:s");
	$objeto_descuento = new InformeDescuentos($sala,$codigoperiodo,false);
	$array_carreras=$objeto_descuento->LeerCarreras($codigomodalidadacademica,$codigocarrera);	
	$array_interno=$objeto_descuento->LeerEstudiantesDescuento($codigoperiodo,$array_carreras,$codigoconcepto);
    $num = count($array_interno);
    for($i=0;$i<$num;$i++){
        if($array_interno[$i]['codigoconcepto']==151 || $array_interno[$i]['codigoconcepto']=='151'){
            $OtherData = $C_DatosPagosReporte->ValorPagado($array_interno[$i]['numeroordenpago'],$array_interno[$i]['numerodocumento'],$array_interno[$i]['codigoestudiante'],'../../../EspacioFisico/');
            
            //$ValorCohorte = $C_DatosPagosReporte->ValorMatriculaCohorte($codigocarrera,$array_interno[$i]['codigoperiodo'],$array_interno[$i]['semestre'],'../../../EspacioFisico/');
            
            $array_interno[$i]['PagoRealizado']       = $OtherData['PagoRealizado'];
            $array_interno[$i]['Valorfechaordenpago'] = $OtherData['valorfechaordenpago'];
            $array_interno[$i]['Porcentaje']          = $OtherData['porcentaje'];
            $array_interno[$i]['FechapagoRealizado']  = $OtherData['fechapagorealizado'];
            $array_interno[$i]['FechapagoOportuno']   = $OtherData['fechapagoOportuno'];
            $array_interno[$i]['ValormatriculaCohorte']        = $array_interno[$i]['valordetallecohorte'];
            $array_interno[$i]['ValormitadmatriculaCohorte']   = $array_interno[$i]['valordetallecohorte']/2;
            $array_interno[$i]['CreditosMatriculados']         = $C_DatosPagosReporte->CreditosMatriculados($array_interno[$i]['numeroordenpago'],'../../../EspacioFisico/');
            $array_interno[$i]['MaxCreditos']         = $C_DatosPagosReporte->MaxCreditosEstudiante($array_interno[$i]['codigoestudiante'],$array_interno[$i]['semestre'],'../../../EspacioFisico/'); 
            $array_interno[$i]['TipoPagoRealizado']   = $OtherData['TipoPagoRealizado'];
        }
    }
    
   // echo '<pre>';print_r($array_interno);die;

	$motor = new matriz($array_interno,"Informe Ordenes de Pago","descuentos.php","si","si","menu.php","",false,"si","../../../",false);
	$motor->botonRecargar=false;
	$motor->mostrar();
}
else{
	echo "<h1>Variables perdidas!. No se puede continuar</h1>";
}
?>
