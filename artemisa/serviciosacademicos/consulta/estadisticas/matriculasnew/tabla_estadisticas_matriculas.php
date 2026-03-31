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

unset($_SESSION['sesionFecha_Proximo_Contacto']);
?>
    <meta charset="UTF-8">
    <!-- Nuevos estilos adicionados-->
    <link type="text/css" rel="stylesheet" href="../../../../assets/css/normalize.css">
    <link type="text/css" rel="stylesheet" href="../../../../assets/css/font-page.css">
    <link type="text/css" rel="stylesheet" href="../../../../assets/css/bootstrap.css">
    <link type="text/css" rel="stylesheet" href="../../../../assets/css/general.css">
<?php
    $_SESSION['get']=$_GET;
    if(!isset($_SESSION['array_estadisticas']))
    {
        echo '<script language="javascript">alert("Sesion perdida, no se puede continuar")</script>';
        exit();
    }
    require_once("../../../funciones/clases/motor/motor.php");
?>
    <script type="text/javascript" src="../../../funciones/javascript/funciones_javascript.js"></script>
<?php
$informe=new matriz($_SESSION['array_estadisticas'],"Estadísticas matrículas periodo ".$_SESSION['codigoperiodo_reporte'],"tabla_estadisticas_matriculas.php","si","no","menu.php","estadisticas_matriculas.php");
$informe->definir_llave_globo_general('Programa');
$informe->agregarllave_drilldown('Interesados','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','Interesados','codigocarrera',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."&codigoprocesovidaestudiante=100","","","","Seguimiento a alumnos interesados");
$informe->agregarllave_drilldown('Aspirantes','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','Aspirantes','codigocarrera',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."&codigoprocesovidaestudiante=101");
$informe->agregarllave_drilldown('Formularios','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','Formularios','codigocarrera',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."");
$informe->agregarllave_drilldown('a_seguir_aspirantes_vs_inscritos','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','a_seguir_aspirantes_vs_inscritos','codigocarrera',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."&codigoprocesovidaestudiante=102");
$informe->agregarllave_drilldown('Inscritos','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','Inscritos','codigocarrera',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."&codigoprocesovidaestudiante=200");
$informe->agregarllave_drilldown('Inscritos_No_Evaluados','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','Inscritos_No_Evaluados','codigocarrera',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."&codigoprocesovidaestudiante=201");
$informe->agregarllave_drilldown('Entrevistas_Programadas','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','Entrevistas_Programadas','codigocarrera',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."&codigoprocesovidaestudiante=201");

$informe->agregarllave_drilldown('Lista_en_Espera','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','Lista_en_Espera','codigocarrera',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."&codigoprocesovidaestudiante=203");
$informe->agregarllave_drilldown('Evaluados_No_Admitidos','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','Evaluados_No_Admitidos','codigocarrera',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."&codigoprocesovidaestudiante=202");

$informe->agregarllave_drilldown('Admitidos_No_Matriculados','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','Admitidos_No_Matriculados','codigocarrera',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."&codigoprocesovidaestudiante=408");
$informe->agregarllave_drilldown('Admitidos_Que_No_Ingresaron','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','Admitidos_Que_No_Ingresaron','codigocarrera',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."&codigoprocesovidaestudiante=410");

$informe->agregarllave_drilldown('Matriculados_Nuevos','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','MatriculadosNuevos','codigocarrera',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."&codigoprocesovidaestudiante=400");
$informe->agregarllave_drilldown('Matriculados_Antiguos','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','MatriculadosAntiguos','codigocarrera',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."&codigoprocesovidaestudiante=401");
//$informe->agregarllave_drilldown('Matriculados_Transferencia','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','MatriculadosTransferencia','codigocarrera',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."&codigoprocesovidaestudiante=402");
$informe->agregarllave_drilldown('Matriculados_Reintegro','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','MatriculadosReintegro','codigocarrera',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."&codigoprocesovidaestudiante=409");
$informe->agregarllave_drilldown('Total_Matriculados','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','TotalMatriculados','codigocarrera',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."&codigoprocesovidaestudiante=403");

$informe->agregarllave_drilldown('Matriculados_Repitentes_1_semestre','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','Matriculados_Repitentes_1_semestre','codigocarrera',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."&codigoprocesovidaestudiante=404");
$informe->agregarllave_drilldown('Matriculados_Transferencia_1_semestre','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','Matriculados_Transferencia_1_semestre','codigocarrera',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."&codigoprocesovidaestudiante=405");
$informe->agregarllave_drilldown('Matriculados_Reintegro_1_semestre','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','Matriculados_Reintegro_1_semestre','codigocarrera',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."&codigoprocesovidaestudiante=406");
$informe->agregarllave_drilldown('Total_Matriculados_1_semestre','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','Total_Matriculados_1_semestre','codigocarrera',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."&codigoprocesovidaestudiante=407");

$informe->agregarllave_drilldown('Prematriculados_Antiguos','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','Prematriculados_Antiguos','codigocarrera',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."&codigoprocesovidaestudiante=500");

$informe->agregarllave_drilldown('Prematriculados_Nuevos','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','Prematriculados_Nuevos','codigocarrera',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."&codigoprocesovidaestudiante=500");

$informe->agregarllave_drilldown('No_prematriculados','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','No_prematriculados','codigocarrera',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."&codigoprocesovidaestudiante=501","","","","");

$informe->agregarllave_drilldown('Estudiantes_en_Proceso_de_Financiacion','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','Estudiantes_en_Proceso_de_Financiacion','codigocarrera',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."&codigoprocesovidaestudiante=600","","","","");
$informe->agregarllave_drilldown('Desercion','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','Desercion','codigocarrera',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."&codigoprocesovidaestudiante=700","","","","");


$informe->agregar_llaves_totales('Interesados','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','subtotal_Interesados',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."&codigoprocesovidaestudiante=100",'codigocarrera','','Interesados');
$informe->agregar_llaves_totales('Aspirantes','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','subtotal_Aspirantes',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."&codigoprocesovidaestudiante=101",'codigocarrera','','Aspirantes');
$informe->agregar_llaves_totales('Inscritos','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','subtotal_Inscripciones',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."&codigoprocesovidaestudiante=200",'codigocarrera','','Inscripciones');
$informe->agregar_llaves_totales('Inscritos_No_Evaluados','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','subtotal_Inscritos_No_Evaluados',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."&codigoprocesovidaestudiante=201",'codigocarrera','','Inscritos_No_Evaluados');
$informe->agregar_llaves_totales('Entrevistas_Programadas','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','subtotal_Entrevistas_Programadas',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."&codigoprocesovidaestudiante=201",'codigocarrera','','Entrevistas_Programadas');
$informe->agregar_llaves_totales('Lista_en_Espera','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','subtotal_Lista_en_Espera',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."&codigoprocesovidaestudiante=203",'codigocarrera','','Lista_en_Espera');
$informe->agregar_llaves_totales('Evaluados_No_Admitidos','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','subtotal_Evaluados_No_Admitidos',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."&codigoprocesovidaestudiante=202",'codigocarrera','','Evaluados_No_Admitidos');

$informe->agregar_llaves_totales('Admitidos_No_Matriculados','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','subtotal_Admitidos_No_Matriculados',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."&codigoprocesovidaestudiante=408",'codigocarrera','','Admitidos_No_Matriculados');
$informe->agregar_llaves_totales('Admitidos_Que_No_Ingresaron','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','subtotal_Admitidos_Que_No_Ingresaron',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."&codigoprocesovidaestudiante=410",'codigocarrera','','Admitidos_Que_No_Ingresaron');

$informe->agregar_llaves_totales('a_seguir_aspirantes_vs_inscritos','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','subtotal_a_seguir_aspirantes_vs_inscritos',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."&codigoprocesovidaestudiante=102",'codigocarrera','','a_seguir_aspirantes_vs_inscritos');
$informe->agregar_llaves_totales('Matriculados_Nuevos','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','subtotal_MatriculadosNuevos',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."&codigoprocesovidaestudiante=400",'codigocarrera','','Matriculados_Nuevos');
$informe->agregar_llaves_totales('Matriculados_Antiguos','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','subtotal_MatriculadosAntiguos',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."&codigoprocesovidaestudiante=401",'codigocarrera','','Matriculados_Antiguos');
$informe->agregar_llaves_totales('Matriculados_Repitentes_1_semestre','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','subtotal_Matriculados_Repitentes_1_semestre',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."&codigoprocesovidaestudiante=404",'codigocarrera','','Matriculados_Repitentes_1_semestre');
//$informe->agregar_llaves_totales('Matriculados_Transferencia','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','subtotal_Matriculados_Transferencia',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."&codigoprocesovidaestudiante=402",'codigocarrera','','Matriculados_Transferencia');
$informe->agregar_llaves_totales('Matriculados_Transferencia_1_semestre','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','subtotal_Matriculados_Transferencia_1_semestre',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."&codigoprocesovidaestudiante=405",'codigocarrera','','Matriculados_Transferencia_1_semestre');
$informe->agregar_llaves_totales('Matriculados_Reintegro','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','subtotal_Matriculados_Reintegro',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."&codigoprocesovidaestudiante=409",'codigocarrera','','Matriculados_Reintegro');
$informe->agregar_llaves_totales('Matriculados_Reintegro_1_semestre','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','subtotal_Matriculados_Reintegro_1_semestre',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."&codigoprocesovidaestudiante=406",'codigocarrera','','Matriculados_Reintegro_1_semestre');
$informe->agregar_llaves_totales('Total_Matriculados','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','subtotal_Total_Matriculados',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."&codigoprocesovidaestudiante=403",'codigocarrera','','Total_Matriculados');
$informe->agregar_llaves_totales('Total_Matriculados_1_semestre','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','subtotal_Total_Matriculados_1_semestre',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."&codigoprocesovidaestudiante=407",'codigocarrera','','Total_Matriculados_1_semestre');

$informe->agregar_llaves_totales('Prematriculados_Antiguos','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','subtotal_Prematriculados_Antiguos',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."&codigoprocesovidaestudiante=500",'codigocarrera','','Prematriculados_Antiguos');

$informe->agregar_llaves_totales('Prematriculados_Nuevos','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','subtotal_Prematriculados_Nuevos',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."&codigoprocesovidaestudiante=500",'codigocarrera','','Prematriculados_Nuevos');

$informe->agregar_llaves_totales('No_prematriculados','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','subtotal_No_prematriculados',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."&codigoprocesovidaestudiante=501",'codigocarrera','','No_prematriculados');

$informe->agregar_llaves_totales('Estudiantes_en_Proceso_de_Financiacion','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','subtotal_Estudiantes_en_Proceso_de_Financiacion',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."&codigoprocesovidaestudiante=600",'codigocarrera','','Estudiantes_en_Proceso_de_Financiacion');
$informe->agregar_llaves_totales('Desercion','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','subtotal_Desercion',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."&codigoprocesovidaestudiante=700",'codigocarrera','','Desercion');
$informe->mostrar();
?>
<?php
    $matriz=$_SESSION['array_estadisticas'];
    $array_combo_columnas=array_keys($matriz[0]);
    
    function DatosColumnaParaEstadisticas($columna_nombres,$columna_valores,$matriz)
    {
        unset($_SESSION['datos_pie']);
        for ($i=0;$i<count($matriz);$i++)
        {
            $array_datos_pie[$i]=array('etiquetas'=>$array_etiquetas_pie[$i]=$matriz[$i][$columna_nombres],'valores'=>$matriz[$i][$columna_valores]);
        }
        $_SESSION['datos_pie']=$array_datos_pie;
    }
?>
    <form name="form2" method="get" action="">
        <input class="btn btn-fill-green-X" name="Grafico" type="submit" id="Grafico" value="Grafico">
        <select name="columna" id="columna">
            <option value="">Seleccionar</option>
            <?php 
            foreach ($array_combo_columnas as $llave => $valor)
            { 
            ?>
                <option value="<?php echo $valor; ?>"><?php echo $valor; ?></option>
            <?php 
            } ?>
        </select>
        <?php
        if($_GET['columna']<>"")
        {
            DatosColumnaParaEstadisticas('Programa',$_GET['columna'],$matriz);
            ?>
            <script language="javascript">window.open('pie_estadisticas_matriculas.php?datos_pie=<?php echo $datos_pie;?>&etiquetas_pie=<?php echo $datos_etiquetas_pie?>&columna=<?php echo $_GET['columna']?>')</script>
            <?php 
        } ?>
    </form>
    <table class="table" style="font-size:12px;">
        <thead>
            <tr>
                <th>Interesados</th><th>Aspirantes</th><th>Inscritos</th><th>No Prematriculados</th><th>Prematriculados</th><th>Deserción</th><th>Matriculados</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <p class="small">Personas que presentan algún tipo de interés en uno o más programas institucionales, registrados en la base de datos.</p>          
                </td>
                <td>
                    <p class="small">Orientado a ampliar la información del (los) programa(s)de interés y direccionar a uno solo. Identificar sus necesidades y alimentar la la base de datos institucional.</p>                    
                </td>
                <td>
                    <p class="small">Aspirantes que ya han cancelado derechos de inscripción y está en curso el proceso de selección correspondiente a cada programa académico.</p>                    
                </td>
                <td>
                    <p class="small">Estudiantes que en el periodo anterior estuvieron matriculados y actualmente no han generado orden de pago por concepto de matricula.</p>                    
                </td>
                <td>
                    <p class="small">Estudiantes que han realizado su proceso de prematricula, se les ha generado orden de pago que aún no han pagado o su pago no ha sido registrado en el sistema.</p>                    
                </td>
                <td>
                    <p class="small">Estudiantes matriculados en el periodo anterior que no se han graduado y que en el periodo actual no han cancelado orden de pago por concepto de matricula.</p>                                        
                </td>
                <td>
                    <p class="small">Estudiantes que han cancelado el valor de su matrícula.</p>
                </td>
            </tr>
        </tbody>
        <thead>
            <th>Seguimiento</th><th>Seguimiento</th><th>Seguimiento</th><th>Seguimiento</th><th>Seguimiento</th><th>Seguimiento</th><th>Seguimiento</th>
        </thead>
        <tbody>
            <tr>
                <td><p class="small">Orientado a ampliar la información del (los) programa(s)de interés y direccionar a uno solo. Identificar sus necesidades y alimentar la la base de datos institucional.</p></td>
                <td><p class="small">Orientado a Motivar el pago de inscripción y orientar sobre proceso de selección correspondiente.</p></td>
                <td><p class="small">Citación al proceso mencionado con parámetros y términos definidos.</p></td>
                <td><p class="small">Orientado a motivar la inscripción de asignaturas.</p></td>
                <td><p class="small">Orientado a motivar el pago de matrícula, indicando alternativas de financiación y términos.</p></td>
                <td><p class="small">Orientado a disminuir la deserción.</p></td>
                <td><p class="small">Orientado a evaluar el proceso de ingreso realizado y a indicar sobre inducción, fechas de ingreso, examen médicao y demás requisitos particulares al programa vinculado.</p></td>
            </tr>
        </tbody>
    </table>