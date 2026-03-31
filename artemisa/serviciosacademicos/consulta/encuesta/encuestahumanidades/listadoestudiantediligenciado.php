<?php
session_start();
$rutaado=("../../../funciones/adodb/");
require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../../funciones/sala_genericas/encuesta/MostrarEncuesta.php");
require_once("../../../funciones/sala_genericas/encuesta/ConsultaEncuesta.php");
require_once("../../../funciones/sala_genericas/encuesta/ValidaEncuesta.php");
require_once("../../../funciones/clases/motorv2/motor.php");
require_once("seleccionmateria.php");
?>
<script LANGUAGE="JavaScript">
    function  ventanaprincipal(pagina){
        opener.focus();
        opener.location.href=pagina.href;
        window.close();
        return false;
    }
    function reCarga(){
        document.location.href="<?php echo 'menulistadoautoevaluacion.php';?>";
    }
    function regresarGET()
    {
        document.location.href="<?php echo 'menulistadoautoevaluacion.php';?>";
    }
</script>
<?php
$formulario=new formulariobaseestudiante($sala,'form1','post','','true');
$objetobase=new BaseDeDatosGeneral($sala);
$objconsultaencuesta=new ConsultaEncuesta($objetobase,$formulario);
$_SESSION["codigoperiodo_autoenfermeria"]=$_POST['codigoperiodo'];

if($_REQUEST['codigocarrera']!=$_SESSION['codigocarrera_autoenfermeria']&&trim($_REQUEST['codigocarrera'])!='')
    $_SESSION['codigocarrera_autoenfermeria']=$_REQUEST['codigocarrera'];

$carrera=$_SESSION['codigocarrera_autoenfermeria'];

$i=0;
$tabla="respuestaautoevaluacion";
$objconsultaencuesta->setTablaRespuesta($tabla);

$listaestudiantes=$objconsultaencuesta->listaEstudiantesEncuestaElectiva($_SESSION["codigoperiodo_autoenfermeria"]);
if(isset($listaestudiantes)) {
    foreach($listaestudiantes as $i=>$filalistaestudiantes) {
        $arrayresultado[$i]["Materias_Diligenciadas"]=$filalistaestudiantes["materiadiligenciado"];
        $arrayresultado[$i]["Materias_Inscritas"]=$filalistaestudiantes["totalmaterias"];
        $arrayresultado[$i]["Semestre"]=$filalistaestudiantes["semestre"];
        $arrayresultado[$i]["Documento"]=$filalistaestudiantes["numerodocumento"];
        $arrayresultado[$i]["Apellidos"]=$filalistaestudiantes["apellidosestudiantegeneral"];
        $arrayresultado[$i]["Nombres"]=$filalistaestudiantes["nombresestudiantegeneral"];
        $i++;
    }
}
$datoscarrera=$objetobase->recuperar_datos_tabla("carrera", "codigocarrera", $carrera);

echo "<table width='100%'><tr><td align='center'><h3>LISTADO DE ESTUDIANTES EN PROCESO DE EVALUACION ELECTIVA EN EL PERIODO ".$_SESSION['codigoperiodo_autoenfermeria']."</h3></td></tr></table>";
$motor = new matriz($arrayresultado,"HISTORIAL LINEA ENFASIS ","listadoestudiantediligenciado.php",'si','si','menudesercion.php','menudesercion.php',false,"si","../../../");
//$motor->agregarcolumna_filtro('Resumen Observacion', $array_observacion,'');
//array_flechas['llave_maestro'].'='.$this->array_flechas['valor_llave_maestro'].'&'.$this->array_flechas['llave_detalle'].'='.$_SESSION['contador_flechas'].'&link_origen='.$link_origen.'"
//$motor->agregarllave_drilldown('idcentrotrabajoarp','centrostrabajo.php','centrostrabajo.php','','idcentrotrabajoarp',"",'','','','','onclick= "return ventanaprincipal(this)"');
//$motor->agregar_llaves_totales('Total_Alumnos',"","","totales","","codigomateria","","xx",true);
//$motor->agregar_llaves_totales('Creditos_Materia',"","","totales","","codigomateria","","xx",true);
//$motor->agregar_llaves_totales('Total_Creditos_Alumnos',"","","totales","","codigomateria","","xx",true);
$tabla->botonRecargar=false;
//$motor->agregar_llaves_totales('Cotizacion_ARP',"","","totales","","codigoestudiante","","xx",true);
$motor->mostrar();
?>
