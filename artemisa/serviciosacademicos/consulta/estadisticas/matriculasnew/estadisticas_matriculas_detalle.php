<?php
    session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_WARNING);
    
    ini_set('memory_limit', '128M');
    ini_set('max_execution_time','216000');
    error_reporting(0);

    $rutaado=("../../../funciones/adodb/");
    require_once('../../../Connections/salaado-pear.php');
    require_once("funciones/obtener_datos.php");

    if(!isset($_GET['codigocarrera']) && empty($_GET['codigocarrera'])){
        $_GET['codigocarrera'] = $_SESSION['array_estadisticas']['0']['codigocarrera'];
    }

    $_SESSION['sesion_linkorigen'] = "link_origen=".$_REQUEST['link_origen']."&codigocarrera=".$_GET['codigocarrera'].
    "&codigoperiodo=".$_GET['codigoperiodo']."&codigoprocesovidaestudiante=".$_REQUEST['codigoprocesovidaestudiante'].
    "&descriptor=".$_GET['descriptor']."";

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

    if(isset($_SESSION['codigomodalidadacademica']) and !empty($_SESSION['codigocarrera'])){
        if($_SESSION['codigomodalidadacademica']=="todos" and $_SESSION['codigocarrera']=="todos"){
            $carreras=$datos_matriculas->obtener_carreras("","");
        }
        elseif($_SESSION['codigomodalidadacademica']=="todos" and $_SESSION['codigocarrera']!="todos"){
            $carreras=$datos_matriculas->obtener_carreras("",$_SESSION['codigocarrera']);
        }
        elseif($_SESSION['codigomodalidadacademica']!="todos" and $_SESSION['codigocarrera']=="todos"){
            $carreras=$datos_matriculas->obtener_carreras($_SESSION['codigomodalidadacademica'],"");
        }else{
            $carreras=$datos_matriculas->obtener_carreras("",$_SESSION['codigocarrera']);
        }
    }

    switch ($_SESSION['descriptor_reporte']){
        case 'Aspirantes':{
            $array_codigosestudiante=$datos_matriculas->ObtenerAspirantesSinmatriculaSinPago($_SESSION['codigocarrera_reporte'],$_SESSION['codigoperiodo_reporte'],'arreglo');
            if(is_array($array_codigosestudiante)){
                foreach ($array_codigosestudiante as $llave => $valor){
                    $datos_estudiantes[$contador]=$datos_matriculas->obtener_datos_estudiante_noprematricula($valor['codigoestudiante']);
                    $datocolegio=$datos_matriculas->obtener_colegio_estudiante($valor['codigoestudiante'],$datos_estudiantes[$contador]["codigomodalidadacademica"]);
                    $datos_estudiantes[$contador]['institucion_egreso']=$datocolegio['nombreinstitucioneducativa'];
                    $datos_estudiantes[$contador]['año_graduacion']=$datocolegio['anogradoestudianteestudio'];
                    $contador++;
                }
            }else {
                echo '<script language="javascript">alert("No hay datos para mostrar")</script>';
                echo '<script language="javascript">window.location.href="tabla_estadisticas_matriculas.php";</script>';
            }
            $_SESSION['titulo']='ASPIRANTES '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];        
        }
        break;
            
        case 'subtotal_Aspirantes':{
            $contador=0;
            foreach ($carreras as $llave => $valor){
                $array_codigosestudiante=$datos_matriculas->ObtenerAspirantesSinmatriculaSinPago($valor['codigocarrera'],$_SESSION['codigoperiodo_reporte'],'arreglo');
                if(is_array($array_codigosestudiante)) {
                    foreach ($array_codigosestudiante as $llave => $valor) {
                        $datos_estudiantes[$contador] = $datos_matriculas->obtener_datos_estudiante_noprematricula($valor['codigoestudiante']);
                        $datocolegio = $datos_matriculas->obtener_colegio_estudiante($valor['codigoestudiante'], $datos_estudiantes[$contador]["codigomodalidadacademica"]);
                        $datos_estudiantes[$contador]['institucion_egreso'] = $datocolegio['nombreinstitucioneducativa'];
                        $datos_estudiantes[$contador]['año_graduacion'] = $datocolegio['anogradoestudianteestudio'];
                        $contador++;
                    }//foreach
                }
            }
            $_SESSION['titulo']='ASPIRANTES '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];
        }
        break;
            
        case 'Formularios':
        {
            $array_codigosestudiante=$datos_matriculas->obtener_datos_cuentaoperacionprincipal($_SESSION['codigoperiodo_reporte'],$_SESSION['codigocarrera_reporte'],152,'arreglo');
            $_SESSION['titulo']='FORMULARIOS '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];    
        }
        break;

        case 'formulariosvsinscripcion':{
            $array_codigosestudiante=$datos_matriculas->seguimiento_formulariovsinscripcion($_SESSION['codigocarrera_reporte'],'arreglo');
            $_SESSION['titulo']='FORMULARIOS VS INSCRIPCIONES '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];
        }
        break;
            
        case 'Inscritos':
        {
            $contador=0;
            $array_codigosestudiante=$datos_matriculas->ObtenerDatosCuentaOperacionPrincipalIncluyeInscritosSinPago($_SESSION['codigoperiodo_reporte'],$_SESSION['codigocarrera_reporte'],153,'arreglo');
            if(is_array($array_codigosestudiante)) {
                foreach ($array_codigosestudiante as $llave => $valor) {

                    $datos_estudiantes[$contador]=$datos_matriculas->obtener_datos_estudiante_noprematricula($valor['codigoestudiante']);
                    $datocolegio=$datos_matriculas->obtener_colegio_estudiante($valor['codigoestudiante'],$datos_estudiantes[$contador]["codigomodalidadacademica"]);
                    $datos_estudiantes[$contador]['institucion_egreso']=$datocolegio['nombreinstitucioneducativa'];
                    $ciudadColegio= null;
                    if(isset($datocolegio['ciudadinstitucioneducativa']) && !empty($datocolegio['ciudadinstitucioneducativa'])){
                        if($datocolegio['ciudadinstitucioneducativa'] === 'SANTAFE DE'){
                            $ciudadColegio = 'BOGOTA';
                        }else if($datocolegio['ciudadinstitucioneducativa'] === 'SANTAFE DE '){
                            $ciudadColegio = 'BOGOTA';
                        }
                        else if($datocolegio['ciudadinstitucioneducativa'] === 'CHÃA'){
                            $ciudadColegio = 'CHIA';
                        }else if($datocolegio['ciudadinstitucioneducativa'] === 'BARRANQUILL'){
                            $ciudadColegio = 'BARRANQUILLA';
                        }else if($datocolegio['ciudadinstitucioneducativa'] == 'VILLAVICENC'){
                            $ciudadColegio = 'VILLAVICENCIO';
                        }else if($datocolegio['ciudadinstitucioneducativa'] === 'BogotÃ¡'){
                            $ciudadColegio = 'BOGOTA';
                        }else if($datocolegio['ciudadinstitucioneducativa'] === 'CHIQUINQUIR'){
                            $ciudadColegio = 'CHIQUINQUIRA';
                        }
                    }else{
                        $datocolegio['ciudadinstitucioneducativa'] = null;
                    }

                    if(!isset($datocolegio['colegiopertenececundinamarca']) && empty($datocolegio['colegiopertenececundinamarca'])){
                        $datocolegio['colegiopertenececundinamarca'] = null;
                    }

                    if(empty($ciudadColegio)){
                        $datos_estudiantes[$contador]['ciudad/colegio']=$datocolegio['ciudadinstitucioneducativa'];
                    }else{
                        $datos_estudiantes[$contador]['ciudad/colegio']=$ciudadColegio;
                    }

                    $datos_estudiantes[$contador]['año_graduacion']=$datocolegio['anogradoestudianteestudio'];
                    $datos_estudiantes[$contador]['pertenece_C/namarca']=$datocolegio['colegiopertenececundinamarca'];
                    $contador++;
                }
            }else {
                echo '<script language="javascript">alert("No hay datos para mostrar")</script>';
                echo '<script language="javascript">window.location.href="tabla_estadisticas_matriculas.php";</script>';
            }
            $_SESSION['titulo']='INSCRITOS '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];
        }break;

        case 'Inscritos_No_Evaluados':{
            $contador=0;
            $array_codigosestudiante=$datos_matriculas->ObtenerDatosCuentaOperacionPrincipalInscritosNoEvaluado($_SESSION['codigoperiodo_reporte'],$_SESSION['codigocarrera_reporte'],153,'arreglo');
            if(is_array($array_codigosestudiante)) {
                foreach ($array_codigosestudiante as $llave => $valor) {
                    $datos_estudiantes[$contador]=$datos_matriculas->obtener_datos_estudiante_noprematricula($valor['codigoestudiante']);
                    $datocolegio=$datos_matriculas->obtener_colegio_estudiante($valor['codigoestudiante'],$datos_estudiantes[$contador]["codigomodalidadacademica"]);
                    $datos_estudiantes[$contador]['institucion_egreso']=$datocolegio['nombreinstitucioneducativa'];
                    $datos_estudiantes[$contador]['año_graduacion']=$datocolegio['anogradoestudianteestudio'];
                    if(!isset($datocolegio['colegiopertenececundinamarca']) && empty($datocolegio['colegiopertenececundinamarca'])){
                        $datocolegio['colegiopertenececundinamarca'] = null;
                    }
                    $datos_estudiantes[$contador]['pertenece_C/namarca']=$datocolegio['colegiopertenececundinamarca'];
                    unset($datos_estudiantes[$contador]["codigomodalidadacademica"]);
                    $contador++;
                }
            }
            else {
                echo '<script language="javascript">alert("No hay datos para mostrar")</script>';
                echo '<script language="javascript">window.location.href="tabla_estadisticas_matriculas.php";</script>';
            }
            $_SESSION['titulo']='INSCRITOS NO EVALUADOS '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];
        }
        break;

        case 'Entrevistas_Programadas':{
            $contador=0;
            $array_codigosestudiante=$datos_matriculas->ObtenerEntrevistasProgramadas($_SESSION['codigoperiodo_reporte'],$_SESSION['codigocarrera_reporte'],'arreglo');
            if(is_array($array_codigosestudiante)){
                foreach ($array_codigosestudiante as $llave => $valor){
                    $datos_estudiantes[$contador]=$datos_matriculas->obtener_datos_estudiante_noprematricula_entrevista($valor['codigoestudiante']);
                    $datos_estudiantes[$contador]['Fecha_Entrevista'] = $valor['FechaEntrevista'];
                    $datos_estudiantes[$contador]['Hora_Inicio_Entrevista'] = $valor['HoraInicio'];
                    $datos_estudiantes[$contador]['Hora_Final_Entrevista'] = $valor['HoraFin'];
                    $datos_estudiantes[$contador]['usuario_creacion'] = $valor['usuario'];
                    $datos_estudiantes[$contador]['FechaCreacion'] = $valor['FechaCreacion'];
                    $datos_estudiantes[$contador]['usuario_modificacion'] = $valor['usuario_modificacion'];
                    $datos_estudiantes[$contador]['FechaUltimaModificacion'] = $valor['FechaUltimaModificacion'];
                    $datos_estudiantes[$contador]['Observacion'] = $valor['Observacion'];
                    unset($datos_estudiantes[$contador]["codigomodalidadacademica"]);
                    $contador++;
                }
            }
            else {
                echo '<script language="javascript">alert("No hay datos para mostrar")</script>';
                echo '<script language="javascript">window.location.href="tabla_estadisticas_matriculas.php";</script>';
            }
            $_SESSION['titulo']='Entrevistas Programadas '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];
        }
        break;
        
        case 'subtotal_Entrevistas_Programadas':{
            $contador=0;
            foreach ($carreras as $llave => $valor){
                $array_codigosestudiante=$datos_matriculas->ObtenerEntrevistasProgramadas($_SESSION['codigoperiodo_reporte'],$valor['codigocarrera'],'arreglo');     
                if(is_array($array_codigosestudiante)){
                    foreach ($array_codigosestudiante as $llave => $valor){
                        $datos_estudiantes[$contador]=$datos_matriculas->obtener_datos_estudiante_noprematricula_entrevista($valor['codigoestudiante']);
                        $datos_estudiantes[$contador]['Fecha_Entrevista'] = $valor['FechaEntrevista'];
                        $datos_estudiantes[$contador]['Hora_Inicio_Entrevista'] = $valor['HoraInicio'];                                        
                        $datos_estudiantes[$contador]['Hora_Final_Entrevista'] = $valor['HoraFin'];                                        
                        $datos_estudiantes[$contador]['usuario_creacion'] = $valor['usuario'];                                        
                        $datos_estudiantes[$contador]['FechaCreacion'] = $valor['FechaCreacion'];                                        
                        $datos_estudiantes[$contador]['usuario_modificacion'] = $valor['usuario_modificacion'];                                        
                        $datos_estudiantes[$contador]['FechaUltimaModificacion'] = $valor['FechaUltimaModificacion'];                                        
                        $datos_estudiantes[$contador]['Observacion'] = $valor['Observacion'];        
                        unset($datos_estudiantes[$contador]["codigomodalidadacademica"]);
                        $contador++;
                    }//foreach
                }
            }//foreach
            $_SESSION['titulo']='Entrevistas Programadas '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];    
        }break;
        
        case 'subtotal_Inscritos_No_Evaluados':{
            $contador=0;
            foreach ($carreras as $llave => $valor){
                $array_codigosestudiante=$datos_matriculas->ObtenerDatosCuentaOperacionPrincipalInscritosNoEvaluado($_SESSION['codigoperiodo_reporte'],$valor['codigocarrera'],153,'arreglo');
               if(is_array($array_codigosestudiante)){
                    foreach ($array_codigosestudiante as $llave => $valor){
                        $datos_estudiantes[$contador]=$datos_matriculas->obtener_datos_estudiante_noprematricula($valor['codigoestudiante']);
                        $datocolegio=$datos_matriculas->obtener_colegio_estudiante($valor['codigoestudiante'],$datos_estudiantes[$contador]["codigomodalidadacademica"]);
                        $datos_estudiantes[$contador]['institucion_egreso']=$datocolegio['nombreinstitucioneducativa'];
                        unset($datos_estudiantes[$contador]["codigomodalidadacademica"]);
                        $contador++;
                    }//foreach
                }
            }//foreach
            $_SESSION['titulo']='INSCRITOS NO EVALUADOS '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];    
        }break;
    
        case 'Lista_en_Espera':{
            $contador=0;
            $array_codigosestudiante=$datos_matriculas->ObtenerDatosListaEnEspera($_SESSION['codigoperiodo_reporte'],$_SESSION['codigocarrera_reporte'],'arreglo');
            if(is_array($array_codigosestudiante)) {
                foreach ($array_codigosestudiante as $llave => $valor) {
                    $datos_estudiantes[$contador]=$datos_matriculas->obtener_datos_estudiante_noprematricula($valor['codigoestudiante']);
                    $datocolegio=$datos_matriculas->obtener_colegio_estudiante($valor['codigoestudiante'],$datos_estudiantes[$contador]["codigomodalidadacademica"]);
                    $datos_estudiantes[$contador]['institucion_egreso']=$datocolegio['nombreinstitucioneducativa'];
                    unset($datos_estudiantes[$contador]["codigomodalidadacademica"]);
                    $contador++;
                }
            }else {
                echo '<script language="javascript">alert("No hay datos para mostrar")</script>';
                echo '<script language="javascript">window.location.href="tabla_estadisticas_matriculas.php";</script>';
            }
            $_SESSION['titulo']='LISTA EN ESPERA '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];    
        }break;
            
        case 'subtotal_Lista_en_Espera':{
            $contador=0;
            foreach ($carreras as $llave => $valor){
                $array_codigosestudiante=$datos_matriculas->ObtenerDatosListaEnEspera($_SESSION['codigoperiodo_reporte'],$valor['codigocarrera'],'arreglo');
                if(is_array($array_codigosestudiante)){
                    foreach ($array_codigosestudiante as $llave => $valor) {
                        $datos_estudiantes[$contador]=$datos_matriculas->obtener_datos_estudiante_noprematricula($valor['codigoestudiante']);
                        $datocolegio=$datos_matriculas->obtener_colegio_estudiante($valor['codigoestudiante'],$datos_estudiantes[$contador]["codigomodalidadacademica"]);
                        $datos_estudiantes[$contador]['institucion_egreso']=$datocolegio['nombreinstitucioneducativa'];
                        unset($datos_estudiantes[$contador]["codigomodalidadacademica"]);
                        $contador++;
                    }//foreach6
                }
            }//foreach
            $_SESSION['titulo']='LISTA EN ESPERA '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];    
        }break;

        case 'Evaluados_No_Admitidos':{
            $contador=0;
            $array_codigosestudiante=$datos_matriculas->ObtenerDatosCuentaOperacionPrincipalEvaluadosNoAdmitidos($_SESSION['codigoperiodo_reporte'],$_SESSION['codigocarrera_reporte'],153,'arreglo');
            if(is_array($array_codigosestudiante)) {
                foreach ($array_codigosestudiante as $llave => $valor) {
                    $datos_estudiantes[$contador]=$datos_matriculas->obtener_datos_estudiante_noprematricula($valor['codigoestudiante']);
                    $datocolegio=$datos_matriculas->obtener_colegio_estudiante($valor['codigoestudiante'],$datos_estudiantes[$contador]["codigomodalidadacademica"]);
                    $datos_estudiantes[$contador]['institucion_egreso']=$datocolegio['nombreinstitucioneducativa'];
                    unset($datos_estudiantes[$contador]["codigomodalidadacademica"]);
                    $contador++;
                }
            }else {
                echo '<script language="javascript">alert("No hay datos para mostrar")</script>';
                echo '<script language="javascript">window.location.href="tabla_estadisticas_matriculas.php";</script>';
            }
            $_SESSION['titulo']='EVALUADOS NO ADMITIDOS '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];
        }break;
            
        case 'subtotal_Evaluados_No_Admitidos':{
            $contador=0;
            foreach ($carreras as $llave => $valor){
                $array_codigosestudiante=$datos_matriculas->ObtenerDatosCuentaOperacionPrincipalEvaluadosNoAdmitidos($_SESSION['codigoperiodo_reporte'],$valor['codigocarrera'],153,'arreglo');
                if(is_array($array_codigosestudiante)){
                    foreach ($array_codigosestudiante as $llave => $valor){
                        $datos_estudiantes[$contador]=$datos_matriculas->obtener_datos_estudiante_noprematricula($valor['codigoestudiante']);
                        $datocolegio=$datos_matriculas->obtener_colegio_estudiante($valor['codigoestudiante'],$datos_estudiantes[$contador]["codigomodalidadacademica"]);
                        $datos_estudiantes[$contador]['institucion_egreso']=$datocolegio['nombreinstitucioneducativa'];
                        unset($datos_estudiantes[$contador]["codigomodalidadacademica"]);
                        $contador++;
                    }//foreach
                }
            }//foreach
            $_SESSION['titulo']='EVALUADOS NO ADMITIDOS '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];
        }break;

        case 'Admitidos_Que_No_Ingresaron':{
            $contador=0;
            $array_codigosestudiante=$datos_matriculas->ObtenerDatosCuentaOperacionPrincipalAdmitidosQueNoIngresaron($_SESSION['codigoperiodo_reporte'],$_SESSION['codigocarrera_reporte'],153,'arreglo');
                       
            if(is_array($array_codigosestudiante)) {
                foreach ($array_codigosestudiante as $llave => $valor) {
                    $datos_estudiantes[$contador]=$datos_matriculas->obtener_datos_estudiante_noprematricula($valor['codigoestudiante']);
                    $datocolegio=$datos_matriculas->obtener_colegio_estudiante($valor['codigoestudiante'],$datos_estudiantes[$contador]["codigomodalidadacademica"]);
                    $datos_estudiantes[$contador]['institucion_egreso']=$datocolegio['nombreinstitucioneducativa'];
                    unset($datos_estudiantes[$contador]["codigomodalidadacademica"]);
                    $contador++;
                }
            }else {
                echo '<script language="javascript">alert("No hay datos para mostrar")</script>';
                echo '<script language="javascript">window.location.href="tabla_estadisticas_matriculas.php";</script>';
            }
            $_SESSION['titulo']='ADMITIDOS QUE NO INGRESARON '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];    
        }break;
            
        case 'subtotal_Admitidos_Que_No_Ingresaron':{
            $contador=0;
            foreach ($carreras as $llave => $valor){
                $array_codigosestudiante=$datos_matriculas->ObtenerDatosCuentaOperacionPrincipalAdmitidosQueNoIngresaron($_SESSION['codigoperiodo_reporte'],$valor['codigocarrera'],153,'arreglo');
                if(is_array($array_codigosestudiante)){
                    foreach ($array_codigosestudiante as $llave => $valor){
                        $datos_estudiantes[$contador]=$datos_matriculas->obtener_datos_estudiante_noprematricula($valor['codigoestudiante']);
                        $datocolegio=$datos_matriculas->obtener_colegio_estudiante($valor['codigoestudiante'],$datos_estudiantes[$contador]["codigomodalidadacademica"]);
                        $datos_estudiantes[$contador]['institucion_egreso']=$datocolegio['nombreinstitucioneducativa'];
                        unset($datos_estudiantes[$contador]["codigomodalidadacademica"]);
                        $contador++;
                    }//foreach
                }
            }//foreach
            $_SESSION['titulo']='ADMITIDOS QUE NO INGRESARON '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];    
        }break;

        case 'subtotal_Inscripciones':{
            $contador=0;
            foreach ($carreras as $llave => $valor) {
                $array_codigosestudiante=$datos_matriculas->ObtenerDatosCuentaOperacionPrincipalIncluyeInscritosSinPago($_SESSION['codigoperiodo_reporte'],$valor['codigocarrera'],153,'arreglo');
                if(is_array($array_codigosestudiante)) {
                    foreach ($array_codigosestudiante as $llave => $valor) {
                        $datos_estudiantes[$contador]=$datos_matriculas->obtener_datos_estudiante_noprematricula($valor['codigoestudiante']);
                        $datocolegio=$datos_matriculas->obtener_colegio_estudiante($valor['codigoestudiante'],$datos_estudiantes[$contador]["codigomodalidadacademica"]);
                        $datos_estudiantes[$contador]['institucion_egreso']=$datocolegio['nombreinstitucioneducativa'];
                        $datos_estudiantes[$contador]['año_graduacion']=$datocolegio['anogradoestudianteestudio'];
                        if(!isset($datocolegio['colegiopertenececundinamarca']) && empty($datocolegio['colegiopertenececundinamarca'])){
                            $datocolegio['colegiopertenececundinamarca'] = null;
                        }
                        $datos_estudiantes[$contador]['pertenece_C/namarca']=$datocolegio['colegiopertenececundinamarca'];
                        unset($datos_estudiantes[$contador]["codigomodalidadacademica"]);
                        $contador++;
                    }
                }
            }
            $_SESSION['titulo']='INSCRITOS '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];    
        }break;
            
        case 'a_seguir_aspirantes_vs_inscritos':{
            $contador=0; {
                $array_codigosestudiante=$datos_matriculas->obtener_datos_aspirantes_vs_inscritos($_SESSION['codigoperiodo_reporte'],$_SESSION['codigocarrera_reporte'],'arreglo');
            }
            if(is_array($array_codigosestudiante)) {
                foreach ($array_codigosestudiante as $llave => $valor) {
                    $datos_estudiantes[$contador]=$datos_matriculas->obtener_datos_estudiante_noprematricula($valor['codigoestudiante']);
                    $datocolegio=$datos_matriculas->obtener_colegio_estudiante($valor['codigoestudiante'],$datos_estudiantes[$contador]["codigomodalidadacademica"]);
                    $datos_estudiantes[$contador]['institucion_egreso']=$datocolegio['nombreinstitucioneducativa'];
                    $contador++;
                }
            }
            $_SESSION['titulo']='ASPIRANTES VS INSCRITOS '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];    
        }break;
            
        case 'subtotal_a_seguir_aspirantes_vs_inscritos':{
            $contador=0;
            foreach ($carreras as $llave => $valor) {
                $array_codigosestudiante=$datos_matriculas->obtener_datos_aspirantes_vs_inscritos($_SESSION['codigoperiodo_reporte'],$valor['codigocarrera'],'arreglo');
                if(is_array($array_codigosestudiante)) {
                    foreach ($array_codigosestudiante as $llave => $valor) {
                        $datos_estudiantes[$contador]=$datos_matriculas->obtener_datos_estudiante_noprematricula($valor['codigoestudiante']);
                        $datocolegio=$datos_matriculas->obtener_colegio_estudiante($valor['codigoestudiante'],$datos_estudiantes[$contador]["codigomodalidadacademica"]);
                        $datos_estudiantes[$contador]['institucion_egreso']=$datocolegio['nombreinstitucioneducativa'];
                        $contador++;
                    }
                }
            }
            $_SESSION['titulo']='INSCRITOS '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];    
        }break;
        
        case 'Admitidos_No_Matriculados':{
            $array_codigosestudiante=$datos_matriculas->seguimiento_inscripcionvsmatriculadosnuevos($_SESSION['codigocarrera_reporte'],'arreglo');
            if(is_array($array_codigosestudiante)) {
                foreach ($array_codigosestudiante as $llave => $valor) {
                    $datos_estudiantes[$contador]=$datos_matriculas->obtener_datos_estudiante_noprematricula($valor['codigoestudiante']);
                    $datocolegio=$datos_matriculas->obtener_colegio_estudiante($valor['codigoestudiante'],$datos_estudiantes[$contador]["codigomodalidadacademica"]);
                    $datos_estudiantes[$contador]['institucion_egreso']=$datocolegio['nombreinstitucioneducativa'];
                    $datos_estudiantes[$contador]['fecha']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante'],"fecha");
                    $datos_estudiantes[$contador]['observacion']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante'],"observacion");
                    $datos_estudiantes[$contador]['dias_ultimo_seguimiento']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante']);
                    $datos_estudiantes[$contador]['dias_ultimo_seguimiento'];
                    $contador++;
                }
            }else {
                echo '<script language="javascript">alert("No hay datos para mostrar")</script>';
                echo '<script language="javascript">window.location.href="tabla_estadisticas_matriculas.php";</script>';
            }
             $_SESSION['titulo']='ADMITIDOS NO MATRICULADOS '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];

        }break;

        case 'subtotal_Admitidos_No_Matriculados':{
            $contador=0;
            foreach ($carreras as $llave => $valor) {
                $array_codigosestudiante = $datos_matriculas->seguimiento_inscripcionvsmatriculadosnuevos($valor['codigocarrera'], 'arreglo');
                if (is_array($array_codigosestudiante)) {
                    foreach ($array_codigosestudiante as $llave => $valor) {
                        if ($valor['codigoestudiante'] <> "") {
                            $datos_estudiantes[$contador] = $datos_matriculas->obtener_datos_estudiante_noprematricula($valor['codigoestudiante']);
                            $datocolegio = $datos_matriculas->obtener_colegio_estudiante($valor['codigoestudiante'], $datos_estudiantes[$contador]["codigomodalidadacademica"]);
                            $datos_estudiantes[$contador]['institucion_egreso'] = $datocolegio['nombreinstitucioneducativa'];
                            $datos_estudiantes[$contador]['fecha'] = $datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante'], "fecha");
                            $datos_estudiantes[$contador]['observacion'] = $datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante'], "observacion");
                            $datos_estudiantes[$contador]['dias_ultimo_seguimiento'] = $datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante']);
                            $contador++;
                        }
                    }
                }
            }//foreach
            $_SESSION['titulo']='ADMITIDOS NO MATRICULADOS '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];
        }
        break;

        case 'MatriculadosNuevos':{
            $contador=0;
            $retorno =0;
            $array_codigosestudiante=$datos_matriculas->obtener_datos_estudiantes_matriculados_nuevos($_SESSION['codigocarrera_reporte'],'arreglo');
            if(is_array($array_codigosestudiante)) {
                foreach ($array_codigosestudiante as $llave => $valor) {
                    $datos_estudiantes[$contador]=$datos_matriculas->obtener_datos_estudiante_noprematricula($valor['codigoestudiante']);
                    $datocolegio=$datos_matriculas->obtener_colegio_estudiante($valor['codigoestudiante'],$datos_estudiantes[$contador]["codigomodalidadacademica"]);
                    $datos_estudiantes[$contador]['institucion_egreso']=$datocolegio['nombreinstitucioneducativa'];
                    $datos_estudiantes[$contador]['año_graduacion']=$datocolegio['anogradoestudianteestudio'];
                    if(isset($datocolegio['colegiopertenececundinamarca']) && !empty($datocolegio['colegiopertenececundinamarca'])){
                        $datos_estudiantes[$contador]['pertenece_C/namarca']=$datocolegio['colegiopertenececundinamarca'];
                    }else{
                        $datos_estudiantes[$contador]['pertenece_C/namarca'] = "";
                    }

                    if(isset($datocolegio['ciudadinstitucioneducativa']) && !empty($datocolegio['ciudadinstitucioneducativa'])){
                        $datos_estudiantes[$contador]['ciudad/colegio']=$datocolegio['ciudadinstitucioneducativa'];
                    }else{
                        $datos_estudiantes[$contador]['ciudad/colegio'] ="";
                    }

                    $datos_estudiantes[$contador]['fecha']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante'],"fecha");
                    $datos_estudiantes[$contador]['observacion']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante'],"observacion");
                    $datos_estudiantes[$contador]['dias_ultimo_seguimiento']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante']);
                    $contador++;
                }//foreach
            }else{
                echo '<script language="javascript">alert("No hay datos para mostrar")</script>';
                echo '<script language="javascript">window.location.href="tabla_estadisticas_matriculas.php";</script>';
            }
            $_SESSION['titulo']='MATRICULADOS NUEVOS '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];
        }break;

        case 'subtotal_MatriculadosNuevos':{
            $contador=0;
            foreach ($carreras as $llave => $valor) {
                $array_codigosestudiante=$datos_matriculas->obtener_datos_estudiantes_matriculados_nuevos($valor['codigocarrera'],'arreglo');
                if(is_array($array_codigosestudiante)) {
                    foreach ($array_codigosestudiante as $llave => $valor) {
                        $datos_estudiantes[$contador]=$datos_matriculas->obtener_datos_estudiante_noprematricula($valor['codigoestudiante']);
                        $datocolegio=$datos_matriculas->obtener_colegio_estudiante($valor['codigoestudiante'],$datos_estudiantes[$contador]["codigomodalidadacademica"]);
                        $datos_estudiantes[$contador]['institucion_egreso']=$datocolegio['nombreinstitucioneducativa'];
                        $datos_estudiantes[$contador]['año_graduacion']=$datocolegio['anogradoestudianteestudio'];
                        if(isset($datocolegio['colegiopertenececundinamarca']) && !empty($datocolegio['colegiopertenececundinamarca'])){
                            $datos_estudiantes[$contador]['pertenece_C/namarca']=$datocolegio['colegiopertenececundinamarca'];
                        }else{
                            $datos_estudiantes[$contador]['pertenece_C/namarca']="";
                        }
                        if(isset($datocolegio['ciudadinstitucioneducativa']) && !empty($datocolegio['ciudadinstitucioneducativa'])){
                            $datos_estudiantes[$contador]['ciudad/colegio']=$datocolegio['ciudadinstitucioneducativa'];
                        }else{
                            $datos_estudiantes[$contador]['ciudad/colegio']="";
                        }

                        $datos_estudiantes[$contador]['fecha']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante'],"fecha");
                        $datos_estudiantes[$contador]['observacion']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante'],"observacion");
                        $datos_estudiantes[$contador]['dias_ultimo_seguimiento']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante']);
                        $contador++;
                    }//foreach
                }
            }//foreach
            $_SESSION['titulo']='MATRICULADOS NUEVOS '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];
        }break;

        case 'MatriculadosAntiguos':{
            $array_codigosestudiante=$datos_matriculas->obtener_datos_estudiantes_matriculados_antiguos_tipoestudiante($_SESSION['codigocarrera_reporte'],20,'arreglo');
            $_SESSION['titulo']='MATRICULADOS ANTIGUOS '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];
            if(isset($array_codigosestudiante) && !empty($array_codigosestudiante) && is_array($array_codigosestudiante)) {
                foreach ($array_codigosestudiante as $llave => $valor){
                    $datos_estudiantes[$contador]=$datos_matriculas->obtener_datos_estudiante_noprematricula($valor['codigoestudiante']);
                    $datocolegio=$datos_matriculas->obtener_colegio_estudiante($valor['codigoestudiante'],$datos_estudiantes[$contador]["codigomodalidadacademica"]);
                    $datos_estudiantes[$contador]['institucion_egreso']=$datocolegio['nombreinstitucioneducativa'];
                    $datos_estudiantes[$contador]['año_graduacion']=$datocolegio['anogradoestudianteestudio'];
                    $datos_estudiantes[$contador]['pertenece_C/namarca']=$datocolegio['colegiopertenececundinamarca'];
                    $datos_estudiantes[$contador]['fecha']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante'],"fecha");
                    $datos_estudiantes[$contador]['observacion']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante'],"observacion");
                    $datos_estudiantes[$contador]['dias_ultimo_seguimiento']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante']);
                    $contador++;
                }//foreach
            }else{
                echo '<script language="javascript">alert("No hay datos para mostrar")</script>';
                echo '<script language="javascript">window.location.href="tabla_estadisticas_matriculas.php";</script>';
            }
        }break;

        case 'subtotal_MatriculadosAntiguos':{
            $contador=0;
            foreach ($carreras as $llave => $valor) {
                $array_codigosestudiante=$datos_matriculas->obtener_datos_estudiantes_matriculados_antiguos_tipoestudiante($valor['codigocarrera'],20,'arreglo');
                if(isset($array_codigosestudiante) && !empty($array_codigosestudiante) && is_array($array_codigosestudiante)) {
                    foreach ($array_codigosestudiante as $llave => $valor) {
                        $datos_estudiantes[$contador]=$datos_matriculas->obtener_datos_estudiante_noprematricula($valor['codigoestudiante']);
                        $datocolegio=$datos_matriculas->obtener_colegio_estudiante($valor['codigoestudiante'],$datos_estudiantes[$contador]["codigomodalidadacademica"]);
                        $datos_estudiantes[$contador]['institucion_egreso']=$datocolegio['nombreinstitucioneducativa'];
                        $datos_estudiantes[$contador]['año_graduacion']=$datocolegio['anogradoestudianteestudio'];
                        $datos_estudiantes[$contador]['pertenece_C/namarca']=$datocolegio['colegiopertenececundinamarca'];
                        $datos_estudiantes[$contador]['fecha']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante'],"fecha");
                        $datos_estudiantes[$contador]['observacion']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante'],"observacion");
                        $datos_estudiantes[$contador]['dias_ultimo_seguimiento']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante']);
                        $contador++;
                    }//foreach
                }
            }//foreach
            $_SESSION['titulo']='MATRICULADOS ANTIGUOS '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];
        }
        break;

        case 'Matriculados_Repitentes_1_semestre':{
            $array_codigosestudiante=$datos_matriculas->obtener_datos_estudiantes_matriculados_repitentes($_SESSION['codigocarrera_reporte'],20,'arreglo');
            $_SESSION['titulo']='MATRICULADOS REPITENTES 1 SEMESTRE'.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];    
        }break;

        case 'subtotal_Matriculados_Repitentes_1_semestre':{
            foreach ($carreras as $llave => $valor){
                $array_codigosestudiante=$datos_matriculas->obtener_datos_estudiantes_matriculados_repitentes($valor['codigocarrera'],20,'arreglo');
                if(is_array($array_codigosestudiante)) {
                    foreach ($array_codigosestudiante as $llave => $valor) {
                        $datos_estudiantes[$contador]=$datos_matriculas->obtener_datos_estudiante_noprematricula($valor['codigoestudiante']);
                        $datocolegio=$datos_matriculas->obtener_colegio_estudiante($valor['codigoestudiante'],$datos_estudiantes[$contador]["codigomodalidadacademica"]);
                        $datos_estudiantes[$contador]['institucion_egreso']=$datocolegio['nombreinstitucioneducativa'];
                        $datos_estudiantes[$contador]['fecha']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante'],"fecha");
                        $datos_estudiantes[$contador]['observacion']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante'],"observacion");
                        $datos_estudiantes[$contador]['dias_ultimo_seguimiento']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante']);
                        $contador++;
                    }
                }
            }
            $_SESSION['titulo']='MATRICULADOS REPITENTES 1 SEMESTRE'.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];    
        }break;
            
        case 'MatriculadosTransferencia':{
            $array_codigosestudiante=$datos_matriculas->obtener_datos_estudiantes_matriculados_transferencia($_SESSION['codigocarrera_reporte'],'arreglo');
            $_SESSION['titulo']='MATRICULADOS TRANSFERENCIA '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];   
        }break;

        case 'subtotal_Matriculados_Transferencia':{
             foreach ($carreras as $llave => $valor){
                $array_codigosestudiante=$datos_matriculas->obtener_datos_estudiantes_matriculados_transferencia($valor['codigocarrera'],'arreglo');
                if(is_array($array_codigosestudiante)) {
                    foreach ($array_codigosestudiante as $llave => $valor) {
                        $datos_estudiantes[$contador]=$datos_matriculas->obtener_datos_estudiante_noprematricula($valor['codigoestudiante']);
                        $datocolegio=$datos_matriculas->obtener_colegio_estudiante($valor['codigoestudiante'],$datos_estudiantes[$contador]["codigomodalidadacademica"]);
                        $datos_estudiantes[$contador]['institucion_egreso']=$datocolegio['nombreinstitucioneducativa'];
                        $datos_estudiantes[$contador]['fecha']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante'],"fecha");
                        $datos_estudiantes[$contador]['observacion']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante'],"observacion");
                        $datos_estudiantes[$contador]['dias_ultimo_seguimiento']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante']);
                        $contador++;
                    }
                }
            }
            $_SESSION['titulo']='MATRICULADOS TRANSFERENCIA '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];
        }break;
            
        case 'Matriculados_Transferencia_1_semestre':{
            $array_codigosestudiante=$datos_matriculas->obtener_datos_estudiantes_matriculados_transferencia_1_semestre($_SESSION['codigocarrera_reporte'],'arreglo');
            $_SESSION['titulo']='MATRICULADOS TRANSFERENCIA 1 SEMESTRE'.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];    
        }
        break;

        case 'subtotal_Matriculados_Transferencia_1_semestre':{
            foreach ($carreras as $llave => $valor){
                $array_codigosestudiante=$datos_matriculas->obtener_datos_estudiantes_matriculados_transferencia_1_semestre($valor['codigocarrera'],'arreglo');
                if(is_array($array_codigosestudiante)) {
                    foreach ($array_codigosestudiante as $llave => $valor) {
                        $datos_estudiantes[$contador]=$datos_matriculas->obtener_datos_estudiante_noprematricula($valor['codigoestudiante']);
                        $datocolegio=$datos_matriculas->obtener_colegio_estudiante($valor['codigoestudiante'],$datos_estudiantes[$contador]["codigomodalidadacademica"]);
                        $datos_estudiantes[$contador]['institucion_egreso']=$datocolegio['nombreinstitucioneducativa'];
                        $datos_estudiantes[$contador]['fecha']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante'],"fecha");
                        $datos_estudiantes[$contador]['observacion']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante'],"observacion");
                        $datos_estudiantes[$contador]['dias_ultimo_seguimiento']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante']);
                        $contador++;
                    }
                }
            }
            $_SESSION['titulo']='MATRICULADOS TRANSFERENCIA 1 SEMESTRE'.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];    
        }break;
            
        case 'MatriculadosReintegro':{
            $array_codigosestudiante=$datos_matriculas->obtener_datos_estudiantes_reintegro($_SESSION['codigocarrera_reporte'],'arreglo');
            $_SESSION['titulo']='MATRICULADOS REINTEGRO '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];    
        }
        break;
            
        case 'subtotal_Matriculados_Reintegro':{
            foreach ($carreras as $llave => $valor){
                $array_codigosestudiante=$datos_matriculas->obtener_datos_estudiantes_matriculados_antiguos_tipoestudiante($valor['codigocarrera'],21,'arreglo');
                if(is_array($array_codigosestudiante)) {
                    foreach ($array_codigosestudiante as $llave => $valor) {
                        $datos_estudiantes[$contador]=$datos_matriculas->obtener_datos_estudiante_noprematricula($valor['codigoestudiante']);
                        $datocolegio=$datos_matriculas->obtener_colegio_estudiante($valor['codigoestudiante'],$datos_estudiantes[$contador]["codigomodalidadacademica"]);
                        $datos_estudiantes[$contador]['institucion_egreso']=$datocolegio['nombreinstitucioneducativa'];
                        $datos_estudiantes[$contador]['fecha']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante'],"fecha");
                        $datos_estudiantes[$contador]['observacion']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante'],"observacion");
                        $datos_estudiantes[$contador]['dias_ultimo_seguimiento']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante']);
                        $contador++;
                    }
                }
            }
            $_SESSION['titulo']='MATRICULADOS REINTEGRO '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];
        }break;

        case 'Matriculados_Reintegro_1_semestre':{
            $array_codigosestudiante=$datos_matriculas->obtener_datos_estudiantes_reintegro_1_semestre($_SESSION['codigocarrera_reporte'],21,'arreglo');
            $_SESSION['titulo']='MATRICULADOS REINTEGRO 1 SEMESTRE'.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];    
        }break;

        case 'subtotal_Matriculados_Reintegro_1_semestre':{
            foreach ($carreras as $llave => $valor) {
                $array_codigosestudiante=$datos_matriculas->obtener_datos_estudiantes_matriculados_antiguos_tipoestudiante_1_semestre($valor['codigocarrera'],21,'arreglo');
                if(is_array($array_codigosestudiante)) {
                    foreach ($array_codigosestudiante as $llave => $valor) {
                        $datos_estudiantes[$contador]=$datos_matriculas->obtener_datos_estudiante_noprematricula($valor['codigoestudiante']);
                        $datocolegio=$datos_matriculas->obtener_colegio_estudiante($valor['codigoestudiante'],$datos_estudiantes[$contador]["codigomodalidadacademica"]);
                        $datos_estudiantes[$contador]['institucion_egreso']=$datocolegio['nombreinstitucioneducativa'];
                        $datos_estudiantes[$contador]['fecha']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante'],"fecha");
                        $datos_estudiantes[$contador]['observacion']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante'],"observacion");
                        $datos_estudiantes[$contador]['dias_ultimo_seguimiento']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante']);
                        $contador++;
                    }
                }
            }
            $_SESSION['titulo']='MATRICULADOS REINTEGRO 1 SEMESTRE'.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];
        }break;
            
        case 'TotalMatriculados':{
            $array_codigosestudiante=$datos_matriculas->obtener_total_matriculados($_SESSION['codigocarrera_reporte'],'arreglo');
            if(isset($array_codigosestudiante) && !empty($array_codigosestudiante)){
                $_SESSION['titulo']='TOTAL MATRICULADOS '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];
            }else {
                echo '<script language="javascript">alert("No hay datos para mostrar")</script>';
                echo '<script language="javascript">window.location.href="tabla_estadisticas_matriculas.php";</script>';
            }
        }break;

        case 'subtotal_Total_Matriculados':{
            foreach ($carreras as $llave => $valor){
                $array_codigosestudiante=$datos_matriculas->obtener_total_matriculados($valor['codigocarrera'],'arreglo');
                if(isset($array_codigosestudiante) && !empty($array_codigosestudiante) && is_array($array_codigosestudiante)) {
                    foreach ($array_codigosestudiante as $llave => $valor) {
                        $datos_estudiantes[$contador]=$datos_matriculas->obtener_datos_estudiante_noprematricula($valor['codigoestudiante']);
                        $datos_estudiantes[$contador]['semestre']=$datos_matriculas->obtener_semestre_estudiante($valor['codigoestudiante']);
                        $datocolegio=$datos_matriculas->obtener_colegio_estudiante($valor['codigoestudiante'],$datos_estudiantes[$contador]["codigomodalidadacademica"]);
                        $datos_estudiantes[$contador]['institucion_egreso']=$datocolegio['nombreinstitucioneducativa'];
                        $datos_estudiantes[$contador]['año_graduacion']=$datocolegio['anogradoestudianteestudio'];
                        if(isset($datocolegio['colegiopertenececundinamarca']) && !empty($datocolegio['colegiopertenececundinamarca'])){
                            $datos_estudiantes[$contador]['pertenece_C/namarca']=$datocolegio['colegiopertenececundinamarca'];
                        }else{
                            $datos_estudiantes[$contador]['pertenece_C/namarca'] = "";
                        }
                        $datos_estudiantes[$contador]['fecha']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante'],"fecha");
                        $datos_estudiantes[$contador]['observacion']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante'],"observacion");
                        $datos_estudiantes[$contador]['dias_ultimo_seguimiento']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante']);
                        $datosordenes=$datos_matriculas->obtenerDatosOrdenMatricula($valor['codigoestudiante']);
                        $datos_estudiantes[$contador]['fechapagomatricula']=$datosordenes["fechapagosapordenpago"];
                        $datos_estudiantes[$contador]['valorpago']=$datosordenes["valorconcepto"];
                        $datos_estudiantes_detalle=$datos_matriculas->obtener_datos_estudiante($valor['codigoestudiante']);
                        $datos_estudiantes[$contador]['usuario']=$datos_estudiantes_detalle["usuario"];
                        $contador++;
                    }//foreach
                }
            }//foreach
            $_SESSION['titulo']='TOTAL MATRICULADOS '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];    
        }break;

        case 'Total_Matriculados_1_semestre':{
            $array_codigosestudiante=$datos_matriculas->obtener_total_matriculados_1_semestre($_SESSION['codigocarrera_reporte'],'arreglo');
            $_SESSION['titulo']='MATRICULADOS 1 SEMESTRE '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];    
        }break;

        case 'subtotal_Total_Matriculados_1_semestre':{
            foreach ($carreras as $llave => $valor) {
                $array_codigosestudiante=$datos_matriculas->obtener_total_matriculados_1_semestre($valor['codigocarrera'],'arreglo');
                if(is_array($array_codigosestudiante)) {
                    foreach ($array_codigosestudiante as $llave => $valor) {
                        $datos_estudiantes[$contador]=$datos_matriculas->obtener_datos_estudiante_noprematricula($valor['codigoestudiante']);
                        $datocolegio=$datos_matriculas->obtener_colegio_estudiante($valor['codigoestudiante'],$datos_estudiantes[$contador]["codigomodalidadacademica"]);
                        $datos_estudiantes[$contador]['institucion_egreso']=$datocolegio['nombreinstitucioneducativa'];
                        $datos_estudiantes[$contador]['fecha']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante'],"fecha");
                        $datos_estudiantes[$contador]['observacion']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante'],"observacion");
                        $datos_estudiantes[$contador]['dias_ultimo_seguimiento']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante']);
                        $contador++;
                    }
                }
            }
            $_SESSION['titulo']='MATRICULADOS 1 SEMESTRE '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];
        }break;

        case 'Prematriculados_Antiguos':{
            $array_codigosestudiante=$datos_matriculas->obtener_datos_cuentaoperacionprincipal_ordenesnopagasPremaAntiguos($_SESSION['codigoperiodo_reporte'],$_SESSION['codigocarrera_reporte'],151,'arreglo');
            if(isset($array_codigosestudiante) && !empty($array_codigosestudiante)) {
                $_SESSION['titulo'] = 'PREMATRICULADOS ANTIGUOS ' . $nombrecarrera . ' PERIODO ' . $_SESSION['codigoperiodo_reporte'];
            }else{
                echo '<script language="javascript">alert("No hay datos para mostrar")</script>';
                echo '<script language="javascript">window.location.href="tabla_estadisticas_matriculas.php";</script>';
            }
        }break;
            
        case 'subtotal_Prematriculados_Antiguos':{
            foreach ($carreras as $llave => $valor) {
                $array_codigosestudiante=$datos_matriculas->obtener_datos_cuentaoperacionprincipal_ordenesnopagasPremaAntiguos($_SESSION['codigoperiodo_reporte'],$valor['codigocarrera'],151,'arreglo');
                if(is_array($array_codigosestudiante)) {
                    foreach ($array_codigosestudiante as $llave => $valor) {
                        $datos_estudiantes[$contador]=$datos_matriculas->obtener_datos_estudiante_noprematricula($valor['codigoestudiante']);
                        $datocolegio=$datos_matriculas->obtener_colegio_estudiante($valor['codigoestudiante'],$datos_estudiantes[$contador]["codigomodalidadacademica"]);
                        $datos_estudiantes[$contador]['institucion_egreso']=$datocolegio['nombreinstitucioneducativa'];
                        $contador++;
                    }//foreach
                }
            }//foreach
            $_SESSION['titulo']='PREMATRICULADOS ANTIGUOS '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];   
        }break;

        case 'Prematriculados_Nuevos':{
            $array_codigosestudiante=$datos_matriculas->obtener_datos_cuentaoperacionprincipal_ordenesnopagasPremaNuevos($_SESSION['codigoperiodo_reporte'],$_SESSION['codigocarrera_reporte'],151,'arreglo',1);
            if(isset($array_codigosestudiante) && !empty($array_codigosestudiante)) {
                $_SESSION['titulo'] = 'PREMATRICULADOS NUEVOS ' . $nombrecarrera . ' PERIODO ' . $_SESSION['codigoperiodo_reporte'];
            }else{
                echo '<script language="javascript">alert("No hay datos para mostrar")</script>';
                echo '<script language="javascript">window.location.href="tabla_estadisticas_matriculas.php";</script>';
            }
        }break;
            
        case 'subtotal_Prematriculados_Nuevos':{
            foreach ($carreras as $llave => $valor) {
                $array_codigosestudiante=$datos_matriculas->obtener_datos_cuentaoperacionprincipal_ordenesnopagasPremaNuevos($_SESSION['codigoperiodo_reporte'],$valor['codigocarrera'],151,'arreglo',1);
                if(isset($array_codigosestudiante) && !empty($array_codigosestudiante) && is_array($array_codigosestudiante)) {
                    foreach ($array_codigosestudiante as $llave => $valor) {
                        $datos_estudiantes[$contador]=$datos_matriculas->obtener_datos_estudiante_noprematricula($valor['codigoestudiante']);
                        $datocolegio=$datos_matriculas->obtener_colegio_estudiante($valor['codigoestudiante'],$datos_estudiantes[$contador]["codigomodalidadacademica"]);
                        $datos_estudiantes[$contador]['institucion_egreso']=$datocolegio['nombreinstitucioneducativa'];
                        $contador++;
                    }//foreach
                }
            }//foreach
            $_SESSION['titulo']='PREMATRICULADOS NUEVOS '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];
        }break;

        case 'No_prematriculados':{
            $array_codigosestudiante=$datos_matriculas->obtener_datos_estudiantes_noprematriculados($_SESSION['codigocarrera_reporte'],'arreglo');
            if(is_array($array_codigosestudiante)) {
                foreach ($array_codigosestudiante as $llave => $valor) {
                    $datos_estudiantes[$contador]=$datos_matriculas->obtener_datos_estudiante_noprematricula($valor['codigoestudiante']);
                    $datocolegio=$datos_matriculas->obtener_colegio_estudiante($valor['codigoestudiante'],$datos_estudiantes[$contador]["codigomodalidadacademica"]);
                    $datos_estudiantes[$contador]['institucion_egreso']=$datocolegio['nombreinstitucioneducativa'];
                    $datos_estudiantes[$contador]['fecha']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante'],"fecha");
                    $datos_estudiantes[$contador]['observacion']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante'],"observacion");
                    $datos_estudiantes[$contador]['dias_ultimo_seguimiento']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante']);
                    $contador++;
                }
            }
            else {
                echo '<script language="javascript">alert("No hay datos para mostrar")</script>';
                echo '<script language="javascript">window.location.href="tabla_estadisticas_matriculas.php";</script>';
            }
            $_SESSION['titulo']='NO PREMATRICULADOS '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];    
        }break;

        case 'subtotal_No_prematriculados':{
            foreach ($carreras as $llave => $valor) {
                $array_codigosestudiante=$datos_matriculas->obtener_datos_estudiantes_noprematriculados($valor['codigocarrera'],'arreglo');
                if(is_array($array_codigosestudiante)) {
                    foreach ($array_codigosestudiante as $llave => $valor) {
                        $datos_estudiantes[$contador]=$datos_matriculas->obtener_datos_estudiante_noprematricula($valor['codigoestudiante']);
                        $contador++;
                    }
                }
            }
            $_SESSION['titulo']='NO PREMATRICULADOS '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];    
        }break;

        case 'Estudiantes_en_Proceso_de_Financiacion':{
            $array_codigosestudiante=$datos_matriculas->obtener_datos_estudiantes_financiados($_SESSION['codigocarrera_reporte'],'arreglo');
            if(is_array($array_codigosestudiante)) {
                foreach ($array_codigosestudiante as $llave => $valor) {
                    $datos_estudiantes[$contador]=$datos_matriculas->obtener_datos_estudiante_noprematricula($valor['codigoestudiante']);
                    $datocolegio=$datos_matriculas->obtener_colegio_estudiante($valor['codigoestudiante'],$datos_estudiantes[$contador]["codigomodalidadacademica"]);
                    $datos_estudiantes[$contador]['institucion_egreso']=$datocolegio['nombreinstitucioneducativa'];
                    $datos_estudiantes[$contador]['fecha']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante'],"fecha");
                    $datos_estudiantes[$contador]['observacion']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante'],"observacion");
                    $datos_estudiantes[$contador]['dias_ultimo_seguimiento']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante']);
                    $contador++;
                }
            }
            else {
                echo '<script language="javascript">alert("No hay datos para mostrar")</script>';
                echo '<script language="javascript">window.location.href="tabla_estadisticas_matriculas.php";</script>';
            }
            $_SESSION['titulo']='ESTUDIANTES EN PROCESO DE FINANCIACION '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];    
        }break;

        case 'subtotal_Estudiantes_en_Proceso_de_Financiacion':{
            foreach ($carreras as $llave => $valor) {
                $array_codigosestudiante=$datos_matriculas->obtener_datos_estudiantes_financiados($valor['codigocarrera'],'arreglo');
                if(is_array($array_codigosestudiante)) {
                    foreach ($array_codigosestudiante as $llave => $valor) {
                        $datos_estudiantes[$contador]=$datos_matriculas->obtener_datos_estudiante_noprematricula($valor['codigoestudiante']);
                        $datocolegio=$datos_matriculas->obtener_colegio_estudiante($valor['codigoestudiante'],$datos_estudiantes[$contador]["codigomodalidadacademica"]);
                        $datos_estudiantes[$contador]['institucion_egreso']=$datocolegio['nombreinstitucioneducativa'];
                        $datos_estudiantes[$contador]['fecha']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante'],"fecha");
                        $datos_estudiantes[$contador]['observacion']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante'],"observacion");
                        $datos_estudiantes[$contador]['dias_ultimo_seguimiento']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante']);
                        $contador++;
                    }
                }
            }
            $_SESSION['titulo']='ESTUDIANTES EN PROCESO DE FINANCIACION '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];
        }break;

        case 'Desercion':{
            $array_codigosestudiante=$datos_matriculas->obtener_datos_estudiantes_desercion($_SESSION['codigocarrera_reporte'],'arreglo');
            if(is_array($array_codigosestudiante)) {
                foreach ($array_codigosestudiante as $llave => $valor) {
                    $datos_estudiantes[$contador]=$datos_matriculas->obtener_datos_estudiante_noprematricula($valor['codigoestudiante']);
                    $datocolegio=$datos_matriculas->obtener_colegio_estudiante($valor['codigoestudiante'],$datos_estudiantes[$contador]["codigomodalidadacademica"]);
                    $datos_estudiantes[$contador]['institucion_egreso']=$datocolegio['nombreinstitucioneducativa'];
                    $datos_estudiantes[$contador]['fecha']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante'],"fecha");
                    $datos_estudiantes[$contador]['observacion']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante'],"observacion");
                    $datos_estudiantes[$contador]['dias_ultimo_seguimiento']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante']);
                    $contador++;
                }
            }else {
                echo '<script language="javascript">alert("No hay datos para mostrar")</script>';
                echo '<script language="javascript">window.location.href="tabla_estadisticas_matriculas.php";</script>';
            }
            $_SESSION['titulo']='DESERCIÓN '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];        
        }break;

        case 'subtotal_Desercion':{
            foreach ($carreras as $llave => $valor) {
                $array_codigosestudiante=$datos_matriculas->obtener_datos_estudiantes_desercion($valor['codigocarrera'],'arreglo');
                if(is_array($array_codigosestudiante)) {
                    foreach ($array_codigosestudiante as $llave => $valor) {
                        $datos_estudiantes[$contador]=$datos_matriculas->obtener_datos_estudiante_noprematricula($valor['codigoestudiante']);
                        $datocolegio=$datos_matriculas->obtener_colegio_estudiante($valor['codigoestudiante'],$datos_estudiantes[$contador]["codigomodalidadacademica"]);
                        $datos_estudiantes[$contador]['institucion_egreso']=$datocolegio['nombreinstitucioneducativa'];
                        $datos_estudiantes[$contador]['fecha']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante'],"fecha");
                        $datos_estudiantes[$contador]['observacion']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante'],"observacion");
                        $datos_estudiantes[$contador]['dias_ultimo_seguimiento']=$datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante']);
                        $contador++;
                    }
                }
            }
            $_SESSION['titulo']='DESERCIÓN '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];    
        }break;

        case 'Interesados':{
            $array_idpreinscripciones=$datos_matriculas->obtener_preinscripcion_estadopreinscripcionestudiante_general($_SESSION['codigocarrera_reporte'],'arreglo');
            if(is_array($array_idpreinscripciones)) {
                foreach ($array_idpreinscripciones as $llave => $valor) {
                    $datos_estudiantes[$contador]=$datos_matriculas->obtener_datos_estudiante_preinscripcion($valor['idpreinscripcion'],$_SESSION['codigocarrera_reporte']);
                    $contador++;
                }
            }
            else {
                echo '<script language="javascript">alert("No hay datos para mostrar")</script>';
                echo '<script language="javascript">window.location.href="tabla_estadisticas_matriculas.php";</script>';
            }
            $_SESSION['titulo']='INTERESADOS '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];    
        }break;

        case 'subtotal_Interesados':{
            foreach ($carreras as $llave => $valor) {
                $array_idpreinscripciones=$datos_matriculas->obtener_preinscripcion_estadopreinscripcionestudiante_general($valor['codigocarrera'],'arreglo');
                if(is_array($array_idpreinscripciones)) {
                    foreach ($array_idpreinscripciones as $llave => $valor) {
                        $datos_estudiantes[]=$datos_matriculas->obtener_datos_estudiante_preinscripcion($valor['idpreinscripcion'],$valor['codigocarrera']);
                    }
                }
            }
            $_SESSION['titulo']='INTERESADOS '.$nombrecarrera.' PERIODO '.$_SESSION['codigoperiodo_reporte'];
        }break;
    }//switch

    if($_SESSION['descriptor_reporte']!='subtotal_Interesados'
        and $_SESSION['descriptor_reporte']!='Interesados'
        and $_SESSION['descriptor_reporte']!="Aspirantes"
        and $_SESSION['descriptor_reporte']!="subtotal_Aspirantes"
        and $_SESSION['descriptor_reporte']!='Inscritos'
        and $_SESSION['descriptor_reporte']!='Inscritos_No_Evaluados'
        and $_SESSION['descriptor_reporte']!='subtotal_Inscritos_No_Evaluados'
        and $_SESSION['descriptor_reporte']!='Entrevistas_Programadas'
        and $_SESSION['descriptor_reporte']!='subtotal_Entrevistas_Programadas'
        and $_SESSION['descriptor_reporte']!='Lista_en_Espera'
        and $_SESSION['descriptor_reporte']!='subtotal_Lista_en_Espera'
        and $_SESSION['descriptor_reporte']!='subtotal_Inscripciones'
        and $_SESSION['descriptor_reporte']!='Evaluados_No_Admitidos'
        and $_SESSION['descriptor_reporte']!='subtotal_Evaluados_No_Admitidos'
        and $_SESSION['descriptor_reporte']!='Admitidos_No_Matriculados'
        and $_SESSION['descriptor_reporte']!='subtotal_Admitidos_No_Matriculados'
        and $_SESSION['descriptor_reporte']!='Admitidos_Que_No_Ingresaron'
        and $_SESSION['descriptor_reporte']!='subtotal_Admitidos_Que_No_Ingresaron'
        and $_SESSION['descriptor_reporte']!='inscripcionvsmatriculadosnuevos'
        and $_SESSION['descriptor_reporte']!='subtotal_a_seguir_inscripcion_vs_matriculados_nuevos'
        and $_SESSION['descriptor_reporte']!='No_prematriculados'
        and $_SESSION['descriptor_reporte']!='subtotal_MatriculadosNuevos'
        and $_SESSION['descriptor_reporte']!='subtotal_MatriculadosAntiguos'
        and $_SESSION['descriptor_reporte']!='subtotal_Total_Matriculados'       
        and $_SESSION['descriptor_reporte']!='subtotal_Prematriculados_Antiguos'
        and $_SESSION['descriptor_reporte']!='subtotal_Prematriculados_Nuevos'
        and $_SESSION['descriptor_reporte']!='subtotal_No_prematriculados'
        and $_SESSION['descriptor_reporte']!='Estudiantes_en_Proceso_de_Financiacion'
        and $_SESSION['descriptor_reporte']!='subtotal_Estudiantes_en_Proceso_de_Financiacion'
        and $_SESSION['descriptor_reporte']!='Desercion'
        and $_SESSION['descriptor_reporte']!='subtotal_Desercion'
      ){
        if(isset($array_codigosestudiante) && is_array($array_codigosestudiante)){
            $contador=0;
            foreach ($array_codigosestudiante as $llave => $valor){
                $datosnoprematricula=$datos_matriculas->obtener_datos_estudiante_noprematricula($valor['codigoestudiante']);
                $datos_estudiantes[$contador]=$datos_matriculas->obtener_datos_estudiante($valor['codigoestudiante']);
                $datocolegio=$datos_matriculas->obtener_colegio_estudiante($valor['codigoestudiante'],$datosnoprematricula["codigomodalidadacademica"]);
                if(isset($datocolegio) && !empty($datocolegio)) {
                    $datos_estudiantes[$contador]['institucion_egreso'] = $datocolegio['nombreinstitucioneducativa'];
                    $datos_estudiantes[$contador]['año_graduacion'] = $datocolegio['anogradoestudianteestudio'];
                    if(isset($datocolegio['colegiopertenececundinamarca']) && !empty($datocolegio['colegiopertenececundinamarca'])){
                        $datos_estudiantes[$contador]['pertenece_C/namarca'] = $datocolegio['colegiopertenececundinamarca'];
                    }else{
                        $datos_estudiantes[$contador]['pertenece_C/namarca'] = "";
                    }
                    if(isset($datocolegio['ciudadinstitucioneducativa']) && !empty($datocolegio['ciudadinstitucioneducativa'])) {
                        $datos_estudiantes[$contador]['ciudad/colegio'] = $datocolegio['ciudadinstitucioneducativa'];
                    }else{
                        $datos_estudiantes[$contador]['ciudad/colegio'] = "";
                    }
                }else{
                    $datos_estudiantes[$contador]['institucion_egreso'] = "";
                    $datos_estudiantes[$contador]['año_graduacion'] = "";
                    $datos_estudiantes[$contador]['pertenece_C/namarca'] = "";
                    $datos_estudiantes[$contador]['ciudad/colegio'] = "";
                }
                $datos_estudiantes[$contador]['fecha'] = $datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante'], "fecha");
                $datos_estudiantes[$contador]['observacion'] = $datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante'], "observacion");
                $datos_estudiantes[$contador]['dias_ultimo_seguimiento'] = $datos_matriculas->obtenerUltimoSeguimientoEstudiante($valor['codigoestudiante']);
                $datosordenes = $datos_matriculas->obtenerDatosOrdenMatricula($valor['codigoestudiante']);
                $datos_estudiantes[$contador]['fechapagomatricula'] = $datosordenes["fechapagosapordenpago"];
                $datos_estudiantes[$contador]['valorpago'] = $datosordenes["valorconcepto"];
                $contador++;
                }
        }else {
            echo '<script language="javascript">alert("No hay datos para mostrar")</script>';
            echo '<script language="javascript">window.location.href="tabla_estadisticas_matriculas.php");</script>';
        }
    }
    
    unset($_SESSION['array_sesion']);
    if(isset($datos_estudiantes) && !empty($datos_estudiantes)) {
        $_SESSION['array_sesion'] = $datos_estudiantes;
    }
    
    if(isset($_SESSION['array_sesion']) && is_array($_SESSION['array_sesion']))
    {
        echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=tabla_estadisticas_matriculas_detalle.php'>";
    }