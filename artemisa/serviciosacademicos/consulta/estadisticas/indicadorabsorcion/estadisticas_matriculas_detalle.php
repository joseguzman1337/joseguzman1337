<?php
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

//session_start();
//require_once('../../../funciones/clases/autenticacion/redirect.php');
ini_set('memory_limit', '128M');
ini_set('max_execution_time','216000');
//print_r($_GET);
//exit();
error_reporting(0);
?>
<?php
$rutaado=("../../../funciones/adodb/");
require_once('../../../Connections/salaado-pear.php');
require_once("funciones/obtener_datos.php");
?>
<?php
//print_r($_REQUEST);
//print_r($_SERVER);
$_SESSION['sesion_linkorigen'] = "link_origen=".$_REQUEST['link_origen']."&codigocarrera=".$_GET['codigocarrera']."&codigoperiodo=".$_GET['codigoperiodo']."&codigoprocesovidaestudiante=".$_REQUEST['codigoprocesovidaestudiante']."&descriptor=".$_GET['descriptor']."";
//exit();
$_SESSION['codigocarrera_reporte']=$_GET['codigocarrera'];
$_SESSION['descriptor_reporte']=$_GET['descriptor'];
$_SESSION['codigoperiodo_reporte']=$_GET['codigoperiodo'];
$_SESSION['sesioncodigoprocesovidaestudiante'] = $_REQUEST['codigoprocesovidaestudiante'];

$contador=0;
$carrera="SELECT c.nombrecarrera from carrera c WHERE c.codigocarrera='".$_SESSION['codigocarrera_reporte']."'";
$operacion_carrera=$sala->query($carrera);
$row_carrera=$operacion_carrera->fetchRow();
$nombrecarrera=strtoupper($row_carrera['nombrecarrera']);

$datos_matriculas=new obtener_datos_matriculas($sala,$_SESSION['codigoperiodo_reporte']);
//para los recursivos



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

//print_r($_SESSION['descriptor_reporte']);
switch ($_SESSION['descriptor_reporte']) {
    case 'Inscritos':
        $contador=0;
        $array_codigosestudiante=$datos_matriculas->ObtenerInscritos($_SESSION['codigoperiodo_reporte'],$_SESSION['codigocarrera_reporte'],153,'arreglo');
        if(is_array($array_codigosestudiante)) {
            foreach ($array_codigosestudiante as $llave => $valor) {
                $datos_estudiantes[$contador]=$datos_matriculas->obtener_datos_estudiante_noprematricula($valor['codigoestudiante']);
                $datos_estudiantes[$contador]['institucion_egreso']=$datos_matriculas->obtener_colegio_estudiante($valor['codigoestudiante'],$datos_estudiantes[$contador]["codigomodalidadacademica"]);
                unset($datos_estudiantes[$contador]["codigomodalidadacademica"]);
                $contador++;
            }
        }
        else {
            echo '<script language="javascript">alert("No hay datos para mostrar")</script>';
            echo '<script language="javascript">window.location.href="tabla_estadisticas_matriculas.php";</script>';
        }
        $_SESSION['titulo']='INSCRITOS 2 '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];
        break;
    case 'subtotal_Inscritos':
        $contador=0;
        foreach ($carreras as $llave => $valor) {
            //echo "ENTRO Inscritos_Evaluados? ".$valor['codigocarrera'];
            $array_codigosestudiante=$datos_matriculas->ObtenerInscritos($_SESSION['codigoperiodo_reporte'],$valor['codigocarrera'],153,'arreglo');
            //echo "<pre>".print_r($array_codigosestudiante)."</pre>";
            if(is_array($array_codigosestudiante)) {
                foreach ($array_codigosestudiante as $llave => $valor) {
                    $datos_estudiantes[$contador]=$datos_matriculas->obtener_datos_estudiante_noprematricula($valor['codigoestudiante']);
                    $datos_estudiantes[$contador]['institucion_egreso']=$datos_matriculas->obtener_colegio_estudiante($valor['codigoestudiante'],$datos_estudiantes[$contador]["codigomodalidadacademica"]);
                    unset($datos_estudiantes[$contador]["codigomodalidadacademica"]);
                    $contador++;
                }
            }

        }
        if(!is_array($datos_estudiantes)) {
            echo '<script language="javascript">alert("No hay datos para mostrar")</script>';
            echo '<script language="javascript">window.location.href="tabla_estadisticas_matriculas.php";</script>';
        }
        $_SESSION['titulo']='INSCRITOS 2 '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];
        break;
    
    case 'Inscritos_Admitidos':
        $contador=0;
        $array_codigosestudiante=$datos_matriculas->ObtenerAdmitidos($_SESSION['codigoperiodo_reporte'],$_SESSION['codigocarrera_reporte'],153,'arreglo');
        if(is_array($array_codigosestudiante)) {
            foreach ($array_codigosestudiante as $llave => $valor) {
                $datos_estudiantes[$contador]=$datos_matriculas->obtener_datos_estudiante_noprematricula($valor['codigoestudiante']);
                $datos_estudiantes[$contador]['institucion_egreso']=$datos_matriculas->obtener_colegio_estudiante($valor['codigoestudiante'],$datos_estudiantes[$contador]["codigomodalidadacademica"]);
                unset($datos_estudiantes[$contador]["codigomodalidadacademica"]);
                $contador++;
            }
        }
        else {
            echo '<script language="javascript">alert("No hay datos para mostrar")</script>';
            echo '<script language="javascript">window.location.href="tabla_estadisticas_matriculas.php";</script>';
        }
        $_SESSION['titulo']='ADMITIDOS 2 '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];
        break;
    case 'subtotal_Inscritos_Admitidos':
        $contador=0;
        foreach ($carreras as $llave => $valor) {
            //echo "ENTRO Inscritos_Evaluados? ".$valor['codigocarrera'];
            $array_codigosestudiante=$datos_matriculas->ObtenerAdmitidos($_SESSION['codigoperiodo_reporte'],$valor['codigocarrera'],153,'arreglo');
            //echo "<pre>".print_r($array_codigosestudiante)."</pre>";
            if(is_array($array_codigosestudiante)) {
                foreach ($array_codigosestudiante as $llave => $valor) {
                    $datos_estudiantes[$contador]=$datos_matriculas->obtener_datos_estudiante_noprematricula($valor['codigoestudiante']);
                    $datos_estudiantes[$contador]['institucion_egreso']=$datos_matriculas->obtener_colegio_estudiante($valor['codigoestudiante'],$datos_estudiantes[$contador]["codigomodalidadacademica"]);
                    unset($datos_estudiantes[$contador]["codigomodalidadacademica"]);
                    $contador++;
                }
            }

        }
        if(!is_array($datos_estudiantes)) {
            echo '<script language="javascript">alert("No hay datos para mostrar")</script>';
            echo '<script language="javascript">window.location.href="tabla_estadisticas_matriculas.php";</script>';
        }
        $_SESSION['titulo']='ADMITIDOS 2 '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];
        break;
    case 'Admitidos_Matriculados':
        $contador=0;
        $array_codigosestudiante=$datos_matriculas->ObtenerMatriculados($_SESSION['codigocarrera_reporte'],'arreglo');
        if(is_array($array_codigosestudiante)) {
            foreach ($array_codigosestudiante as $llave => $valor) {
                $datos_estudiantes[$contador]=$datos_matriculas->obtener_datos_estudiante_noprematricula($valor['codigoestudiante']);
                $datos_estudiantes[$contador]['institucion_egreso']=$datos_matriculas->obtener_colegio_estudiante($valor['codigoestudiante'],$datos_estudiantes[$contador]["codigomodalidadacademica"]);
                unset($datos_estudiantes[$contador]["codigomodalidadacademica"]);
                $contador++;
            }
        }
        else {
            echo '<script language="javascript">alert("No hay datos para mostrar")</script>';
            echo '<script language="javascript">window.location.href="tabla_estadisticas_matriculas.php";</script>';
        }
        $_SESSION['titulo']='MATRICULADOS 2 '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];
        break;
    case 'subtotal_Admitidos_Matriculados':
        $contador=0;
        foreach ($carreras as $llave => $valor) {
            //echo "ENTRO Inscritos_Evaluados? ".$valor['codigocarrera'];
            $array_codigosestudiante=$datos_matriculas->ObtenerMatriculados($valor['codigocarrera'],'arreglo');
            //echo "<pre>".print_r($array_codigosestudiante)."</pre>";
            if(is_array($array_codigosestudiante)) {
                foreach ($array_codigosestudiante as $llave => $valor) {
                    $datos_estudiantes[$contador]=$datos_matriculas->obtener_datos_estudiante_noprematricula($valor['codigoestudiante']);
                    $datos_estudiantes[$contador]['institucion_egreso']=$datos_matriculas->obtener_colegio_estudiante($valor['codigoestudiante'],$datos_estudiantes[$contador]["codigomodalidadacademica"]);
                    unset($datos_estudiantes[$contador]["codigomodalidadacademica"]);
                    $contador++;
                }
            }

        }
        if(!is_array($datos_estudiantes)) {
            echo '<script language="javascript">alert("No hay datos para mostrar")</script>';
            echo '<script language="javascript">window.location.href="tabla_estadisticas_matriculas.php";</script>';
        }
        $_SESSION['titulo']='MATRICULADOS 2 '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];
        break;
}

//echo "<pre>"; print_r($_SESSION); echo "</pre>";
//echo "<pre>"; print_r($datos_estudiantes); echo "</pre>";
//exit();
unset($_SESSION['array_sesion']);
$_SESSION['array_sesion']=$datos_estudiantes;
//echo $_SESSION['descriptor_reporte'];
//echo "<pre>"; print_r($_SESSION['array_sesion']); echo "</pre>";
//exit();
if(is_array($_SESSION['array_sesion'])) {
    echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=tabla_estadisticas_matriculas_detalle.php'>";
}
?>
