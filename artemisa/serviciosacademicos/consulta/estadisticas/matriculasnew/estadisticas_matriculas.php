<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_WARNING);

    session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

    ini_set('memory_limit', '128M');
    ini_set('max_execution_time','216000');

    unset($_SESSION['codigocarrera']);
    error_reporting(0);

    $_SESSION['codigoperiodo_reporte']=$_GET['codigoperiodo'];
    if(isset($_GET['codigomodalidadacademica']) && isset($_GET['codigocarrera']) && isset($_GET['codigoperiodo'])){
        $_SESSION['codigomodalidadacademica']=$_GET['codigomodalidadacademica'];
    if (count($_GET['codigocarrera'])==1){
        $_SESSION['codigocarrera']=$_GET['codigocarrera'][0];

    }else{
        foreach ($_GET['codigocarrera'] as $key => $value) {
            if (!isset($_SESSION['codigocarrera'])){
                $_SESSION['codigocarrera']=$value;
            }else{
                $_SESSION['codigocarrera'].=",".$value;
            }
        }
    }
}else{
    $_SESSION['codigomodalidadacademica']=$_GET['codigomodalidadacademica'];
    $_SESSION['codigocarrera']='todos';
}
    //lista de variables
    $situacioncarreraestudiante[]='Interesados';
    $situacioncarreraestudiante[]='Aspirantes';
    $situacioncarreraestudiante[]='Inscritos';
    $situacioncarreraestudiante[]='Inscritos_No_Evaluados';
    $situacioncarreraestudiante[]='Entrevistas_Programadas';
    $situacioncarreraestudiante[]='Lista_en_Espera';
    $situacioncarreraestudiante[]='Evaluados_No_Admitidos';
    $situacioncarreraestudiante[]='Admitidos_No_Matriculados';
    $situacioncarreraestudiante[]='Admitidos_Que_No_Ingresaron';
    $situacioncarreraestudiante[]='Matriculados_Nuevos';
    $situacioncarreraestudiante[]='Matriculados_Antiguos';
    $situacioncarreraestudiante[]='Total_Matriculados';
    $situacioncarreraestudiante[]='Prematriculados_Antiguos';
    $situacioncarreraestudiante[]='Prematriculados_Nuevos';
    $situacioncarreraestudiante[]='No_prematriculados';
    $situacioncarreraestudiante[]='Estudiantes_en_Proceso_de_Financiacion';
    $situacioncarreraestudiante[]='Desercion';

    if(is_array($_GET['criteriosituacion'])) {
        $arraymenuopcion=$_GET['criteriosituacion'];
    }else {
        $arraymenuopcion=$situacioncarreraestudiante;
    }
?>
<script language="Javascript">
    function abrir(pagina,ventana,parametros) {
        window.open(pagina,ventana,parametros);
    }
</script>
<script language="javascript">
    function enviar(){
        document.form1.submit()
    }
</script>
<?php
    $rutaado=("../../../funciones/adodb/");
    require_once('../../../Connections/salaado-pear.php');
    require_once('funciones/funcion-barra.php');
    require_once("funciones/obtener_datos.php");

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
    if(isset($_SESSION['codigomodalidadacademica']) && !empty($_SESSION['codigomodalidadacademica'])
        && isset($_SESSION['codigocarrera']) && !empty($_SESSION['codigocarrera'])){
        if($_SESSION['codigomodalidadacademica']=="todos" && $_SESSION['codigocarrera']=="todos") {
            $carreras=$datos_matriculas->obtener_carreras("","");
        }
        elseif($_SESSION['codigomodalidadacademica']=="todos" && $_SESSION['codigocarrera']!="todos") {
            $carreras=$datos_matriculas->obtener_carreras("",$_SESSION['codigocarrera']);
        }
        elseif($_SESSION['codigomodalidadacademica']!="todos" && $_SESSION['codigocarrera']=="todos") {
            $carreras=$datos_matriculas->obtener_carreras($_SESSION['codigomodalidadacademica'],"");
        }
        else {
            $carreras=$datos_matriculas->obtener_carreras("",$_SESSION['codigocarrera']);
        }
    }

    foreach ($carreras as $llave_carreras => $valor_carreras) {
        if($contador % 3==0) {
            echo '<img src="funciones/barra.gif" width="8" height="28">';
        }
        $datos_matriculas->barra();
        $array_datos[$contador]['codigocarrera']=$valor_carreras['codigocarrera'];
        $array_datos[$contador]['Centro_Beneficio']=$valor_carreras['centrobeneficio'];
        $array_datos[$contador]['Programa']=$valor_carreras['nombrecarrera'];

        if(in_array('Interesados',$arraymenuopcion)){
            $array_datos[$contador]['Interesados']=$datos_matriculas->obtener_preinscripcion_estadopreinscripcionestudiante_general($valor_carreras['codigocarrera'],'conteo');
        }
        if(in_array('Aspirantes',$arraymenuopcion)) {
            $array_datos[$contador]['Aspirantes'] = $datos_matriculas->ObtenerAspirantesSinmatriculaSinPago($valor_carreras['codigocarrera'], $_SESSION['codigoperiodo_reporte'], 'conteo');
        }
        if(in_array('a_seguir_aspirantes_vs_inscritos',$arraymenuopcion)) {
            $array_datos[$contador]['a_seguir_aspirantes_vs_inscritos'] = $datos_matriculas->obtener_datos_aspirantes_vs_inscritos($_SESSION['codigoperiodo_reporte'], $valor_carreras['codigocarrera'], 'conteo');
        }
        if(in_array('Inscritos',$arraymenuopcion)) {
            $array_datos[$contador]['Inscritos'] = $datos_matriculas->ObtenerDatosCuentaOperacionPrincipalIncluyeInscritosSinPago($_SESSION['codigoperiodo_reporte'], $valor_carreras['codigocarrera'], 153, 'conteo');
        }
        if(in_array('Inscritos_No_Evaluados',$arraymenuopcion)) {
            $array_datos[$contador]['Inscritos_No_Evaluados'] = $datos_matriculas->ObtenerDatosCuentaOperacionPrincipalInscritosNoEvaluado($_SESSION['codigoperiodo_reporte'], $valor_carreras['codigocarrera'], 153, 'conteo');
        }
         if(in_array('Entrevistas_Programadas',$arraymenuopcion)) {
             $array_datos[$contador]['Entrevistas_Programadas'] = $datos_matriculas->ObtenerEntrevistasProgramadas($_SESSION['codigoperiodo_reporte'], $valor_carreras['codigocarrera'], 'conteo');
         }
        if(in_array('Lista_en_Espera',$arraymenuopcion)) {
            $array_datos[$contador]['Lista_en_Espera'] = $datos_matriculas->ObtenerDatosListaEnEspera($_SESSION['codigoperiodo_reporte'], $valor_carreras['codigocarrera'], 'conteo');
        }
        if(in_array('Evaluados_No_Admitidos',$arraymenuopcion)) {
            $array_datos[$contador]['Evaluados_No_Admitidos'] = $datos_matriculas->ObtenerDatosCuentaOperacionPrincipalEvaluadosNoAdmitidos($_SESSION['codigoperiodo_reporte'], $valor_carreras['codigocarrera'], 153, 'conteo');
        }
        if(in_array('Admitidos_No_Matriculados',$arraymenuopcion)) {
            $array_datos[$contador]['Admitidos_No_Matriculados'] = $datos_matriculas->seguimiento_inscripcionvsmatriculadosnuevos($valor_carreras['codigocarrera'], 'conteo');
        }
        if(in_array('Admitidos_Que_No_Ingresaron',$arraymenuopcion)) {
            $array_datos[$contador]['Admitidos_Que_No_Ingresaron'] = $datos_matriculas->ObtenerDatosCuentaOperacionPrincipalAdmitidosQueNoIngresaron($_SESSION['codigoperiodo_reporte'], $valor_carreras['codigocarrera'], 153, 'conteo');
        }
        if(in_array('Matriculados_Nuevos',$arraymenuopcion)) {
            $array_datos[$contador]['Matriculados_Nuevos'] = $datos_matriculas->obtener_datos_estudiantes_matriculados_nuevos($valor_carreras['codigocarrera'], 'conteo');
        }
        if(in_array('Matriculados_Antiguos',$arraymenuopcion)) {
            $array_datos[$contador]['Matriculados_Antiguos'] = $datos_matriculas->obtener_datos_estudiantes_matriculados_antiguos_tipoestudiante($valor_carreras['codigocarrera'], 20, 'conteo');
        }
        if(in_array('Matriculados_Transferencia',$arraymenuopcion)){
            $array_datos[$contador]['Matriculados_Transferencia']=$datos_matriculas->obtener_datos_estudiantes_matriculados_transferencia($valor_carreras['codigocarrera'],'conteo');
        }
        if(in_array('Matriculados_Reintegro',$arraymenuopcion)) {
            $array_datos[$contador]['Matriculados_Reintegro'] = $datos_matriculas->obtener_datos_estudiantes_reintegro($valor_carreras['codigocarrera'], 'conteo');
        }
        if(in_array('Total_Matriculados',$arraymenuopcion)) {
            $array_datos[$contador]['Total_Matriculados'] = $datos_matriculas->obtener_total_matriculados($valor_carreras['codigocarrera'], 'conteo');
        }
        if(in_array('Matriculados_Repitentes_1_semestre',$arraymenuopcion)) {
            $array_datos[$contador]['Matriculados_Repitentes_1_semestre'] = $datos_matriculas->obtener_datos_estudiantes_matriculados_repitentes($valor_carreras['codigocarrera'], 20, 'conteo');
        }
        if(in_array('Matriculados_Transferencia_1_semestre',$arraymenuopcion)){
            $array_datos[$contador]['Matriculados_Transferencia_1_semestre']=$datos_matriculas->obtener_datos_estudiantes_matriculados_transferencia_1_semestre($valor_carreras['codigocarrera'],'conteo');
        }
        if(in_array('Matriculados_Reintegro_1_semestre',$arraymenuopcion)) {
            $array_datos[$contador]['Matriculados_Reintegro_1_semestre'] = $datos_matriculas->obtener_datos_estudiantes_reintegro_1_semestre($valor_carreras['codigocarrera'], 'conteo');
        }
        if(in_array('Total_Matriculados_1_semestre',$arraymenuopcion)) {
            $array_datos[$contador]['Total_Matriculados_1_semestre'] = $datos_matriculas->obtener_total_matriculados_1_semestre($valor_carreras['codigocarrera'], 'conteo');
        }
        if(in_array('Prematriculados_Antiguos',$arraymenuopcion)) {
            $array_datos[$contador]['Prematriculados_Antiguos'] = $datos_matriculas->obtener_datos_cuentaoperacionprincipal_ordenesnopagasPremaAntiguos($_SESSION['codigoperiodo_reporte'], $valor_carreras['codigocarrera'], 151, 'conteo');
        }
         if(in_array('Prematriculados_Nuevos',$arraymenuopcion)) {
             $array_datos[$contador]['Prematriculados_Nuevos'] = $datos_matriculas->obtener_datos_cuentaoperacionprincipal_ordenesnopagasPremaNuevos($_SESSION['codigoperiodo_reporte'], $valor_carreras['codigocarrera'], 151, 'conteo', 1);
         }

        if(in_array('No_prematriculados',$arraymenuopcion)) {
            $array_datos[$contador]['No_prematriculados'] = $datos_matriculas->obtener_datos_estudiantes_noprematriculados($valor_carreras['codigocarrera'], 'conteo');
        }

        if(in_array('Estudiantes_en_Proceso_de_Financiacion',$arraymenuopcion)) {
            $array_datos[$contador]['Estudiantes_en_Proceso_de_Financiacion'] = $datos_matriculas->obtener_datos_estudiantes_financiados($valor_carreras['codigocarrera'], 'conteo');
        }

        if(in_array('Desercion',$arraymenuopcion)) {
            $array_datos[$contador]['Desercion'] = $datos_matriculas->obtener_datos_estudiantes_desercion($valor_carreras['codigocarrera'], 'conteo');
        }

        $contador++;
    }//foreach

    echo "</div>";
    if(is_array($array_datos)) {
        $_SESSION['array_estadisticas']=$array_datos;
    }
    echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=tabla_estadisticas_matriculas.php'>";

?>
