<?php
    session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    ini_set('memory_limit', '64M');
    ini_set('max_execution_time', '90');
    $rutaado = ("../../../../funciones/adodb/");
    require_once('../../../../Connections/salaado-pear.php');
    require_once('../../../../funciones/clases/motorv2/motor.php');
    require_once('../../../../funciones/clases/debug/SADebug.php');
    require_once('funciones/ObtenerDatos.php');
    require_once('../../../../funciones/clases/autenticacion/redirect.php' );

    $rutaado = ("../../../../funciones/adodb/");

    require_once('../../../../funciones/sala_genericas/clasebasesdedatosgeneral.php');
    require_once("../../../../funciones/sala_genericas/FuncionesCadena.php");
    require_once("../../../../funciones/sala_genericas/FuncionesFecha.php");

    require_once("../../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
    $objetobase = new BaseDeDatosGeneral($sala);

    $fechahoy = date("Y-m-d H:i:s");
    $_SESSION['get'] = $_GET;

    $debug = false;
    if ($_GET['depurar'] == 'si') {
        $debug = true;
        $sala->debug = true;
    }

    $codigocarrera = $_SESSION['codigocarrera'];
    $codigoperiodo = $_SESSION['codigoperiodo_seleccionado'];

if ($codigocarrera == "" or $codigoperiodo == "") {
    echo "<h1>Error, se perdió la variable de sesion carrera o periodo</h1>";
}
$link_origen = $_GET['link_origen'];

$admisiones_consulta = new TablasAdmisiones($sala, $debug);

$array_subperiodo = $admisiones_consulta->LeerCarreraPeriodoSubperiodosRecibePeriodo($codigocarrera, $codigoperiodo);
$idsubperiodo = $array_subperiodo['idsubperiodo'];
$idadmision = $admisiones_consulta->LeerIdadmision($codigocarrera, $idsubperiodo);
$array_parametrizacion_admisiones = $admisiones_consulta->LeerParametrizacionPruebasAdmision($idadmision);

$array_listado_asignacion_pruebas = $_SESSION['array_listado_asignacion_pruebas'];    
$tabla = new matriz($array_listado_asignacion_pruebas, "Listado resultados de las pruebas $codigocarrera", 'listado_asigna_proceso.php', 'si', 'si', 'menuadministracionresultados.php', "calcula_listado_resultados.php?cambioestado", false, "si", "../../../../");
?>
<link rel="stylesheet" type="text/css" href="../../../../estilos/sala.css">
<script language="javascript">
    function reCarga(pagina){
        document.location.href=pagina;
    }
    function recargar(){
        document.location.href= "<?php echo 'calcula_listado_resultados.php?cambioestado&codigomodalidadacademica=' . $_GET['codigomodalidadacademica'] . '&codigocarrera=' . $_GET['codigocarrera'] . '&codigoperiodo=' . $_GET['codigoperiodo'] . '&link_origen=menu.php' ?>"
    }
</script>
<form name="admitir" method="post" action="">
    <p align="left" class="Estilo3">MENU PARAMETRIZACION ADMISIONES</p>
    <table border="1" cellpadding="1" cellspacing="0" width="60%" bordercolor="#E9E9E9">
        <tr>
            <td>Cantidad de aspirantes a admitir</td>
            <td><input type="text" name="corte" value="<?php echo $_POST['corte'] ?>">&nbsp;<input type="submit" name="Nuevo_Estado" value="Nuevo_Estado"></td>
        </tr>

        <tr>
            <td>Estado a cambiar</td>
            <td><?php $admisiones_consulta->DibujarMenuEstadoAdmision($_POST['estadoadmision']) ?></td>
        </tr>    </table>
</form>
<?php
if ($_SESSION['MM_Username'] == 'admintecnologia') {
?>
    <form name="cambiapuntaje" method="post" action="">
        <p align="left" class="Estilo3">SUBIR PUNTAJE</p>
        <table border="1" cellpadding="1" cellspacing="0" width="60%" bordercolor="#E9E9E9">
            <tr>
                <td>Columna</td>
                <td><?php $admisiones_consulta->DibujarMenuColumnas($tabla,"PUNTAJE_EXAMEN_ESCRITO_DE_CONOCIMIENTOS_GENERALES") ?></td>
            </tr>
            <tr>
                <td>Subir en puntos examen</td>
                <td> <input type="text" name="contenido" value=""></td>
            </tr>
            <tr>
                <td><input type="submit" name="Nuevo_Puntaje" value="Nuevo Puntaje"></td>
            </tr>
        </table>
    </form>
<?php
}
?>
<?php
$tabla->definir_llave_globo_general('nombre');
foreach ($array_parametrizacion_admisiones as $llave => $valor) {
    if ($valor['codigotipodetalleadmision'] <> 4) {//no calcular icfes
        $cadena_llave = "PUNTAJE_" . ereg_replace(" ", "_", $valor['nombretipodetalleadmision']);
        //	$tabla->agregarllave_drilldown($cadena_llave,'listado_resultados.php','detalleestudianteadmision.php','test','codigoestudiante',"codigotipodetalleadmision=".$valor['codigotipodetalleadmision']."",'idestudianteadmision','idestudianteadmision');
        $tabla->agregarllave_emergente($cadena_llave, 'listado_asigna_proceso.php', 'detalleestudianteadmision.php', 'test', 'codigoestudiante', "codigotipodetalleadmision=" . $valor['codigotipodetalleadmision'] . "", 300, 300, 200, 150, "yes", "yes", "no", "no", "no", 'idadmision', 'idadmision', '', '');
    }
}
//$tabla->agregarllave_emergente('nombreestadoestudianteadmision','listado_asigna_proceso.php','menuadministracionresultados.php','test','codigoestudiante',"",120,200,200,150,"yes","yes","no","no","no",'idadmision','idadmision','','');
$tabla->agregarllave_emergente('nombreestadoestudianteadmision', 'listado_asigna_horario.php', 'estudianteadmision.php', 'test', 'codigoestudiante', "", 300, 300, 200, 150, "yes", "yes", "no", "no", "no", 'idadmision', 'idadmision', '', '');

$tabla->botonRecargar = false;

if (!empty($_POST['corte'])) {
    $i = 0;
    foreach ($tabla->matriz_filtrada as $llave => $valor) {
        if ($i < $_POST['corte'])
            $nueva_matriz[] = $tabla->matriz_filtrada[$i];
        $i++;
    }
    $tabla->matriz_filtrada = $nueva_matriz;
    $i = 0;
    foreach ($tabla->matriz_recortada as $llave => $valor) {
        if ($i < $_POST['corte'])
            $nueva_matriz2[] = $tabla->matriz_recortada[$i];
        $i++;
    }
}

if ($_REQUEST['Nuevo_Estado']) {
    $i = 0;
    foreach ($tabla->matriz_filtrada as $llave => $valor) {
        $codigoestudiante = $tabla->matriz_filtrada[$i]['codigoestudiante'];
        $idadmision = $tabla->matriz_filtrada[$i]['idadmision'];
        $idinscripcion = $tabla->matriz_filtrada[$i]['idinscripcion'];
        $admisiones_consulta->CambiaEstadoAdmision($_POST['estadoadmision'], $codigoestudiante, $idadmision, $idinscripcion);
        echo '<meta http-equiv="REFRESH" content="0;URL=calcula_listado_resultados.php?cambioestado&codigomodalidadacademica=' . $_GET['codigomodalidadacademica'] . '&codigocarrera=' . $_GET['codigocarrera'] . '&codigoperiodo=' . $_GET['codigoperiodo'] . '&link_origen=menu.php"/>';

        $i++;
    }
}
if ($_SESSION['MM_Username'] == 'admintecnologia') {
    if ($_REQUEST['Nuevo_Puntaje']) {
        foreach ($tabla->matriz_filtrada as $llave => $valor) {
            echo "<br>" . $valor[$_POST['nombrecolumna']] . "+" . $_POST['contenido'];
            if (ereg("^[0-9]{0,20}$", $valor[$_POST['nombrecolumna']])) {
                $array['resultadodetalleestudianteadmision'] = $valor[$_POST['nombrecolumna']] + $_POST['contenido'];
                $array['observacionesdetalleestudianteadmision'] = "CAMBIO PUNTAJE MASIVO POR " . $_SESSION["MM_Username"]." SUBE ".$_POST['contenido']." PUNTOS";
                $array['idestudianteadmision'] = $valor['idestudianteadmision'];

                $tabla = "detalleadmision";
                $nombreidtabla = "idadmision";
                $idtabla = $valor['idadmision'];
                $condicion = " and codigotipodetalleadmision=1"
                        . " and codigoestado like '1%'";
                $datosdetalleadmision = $objetobase->recuperar_datos_tabla($tabla, $nombreidtabla, $idtabla, $condicion);
                $array['iddetalleadmision'] = $datosdetalleadmision["iddetalleadmision"];
                /* echo "<pre>";
                  print_r($datosdetalleadmision);
                  echo "</pre>"; */
                $admisiones_consulta->actualizaPuntajeExamen($array, $objetobase);
            }
        }
        echo '<meta http-equiv="REFRESH" content="0;URL=calcula_listado_resultados.php?cambioestado&codigomodalidadacademica=' . $_GET['codigomodalidadacademica'] . '&codigocarrera=' . $_GET['codigocarrera'] . '&codigoperiodo=' . $_GET['codigoperiodo'] . '&link_origen=menu.php"/>';
    }
}
//exit();
$tabla->matriz_recortada = $nueva_matriz2;
$tabla->mostrar();
?>


