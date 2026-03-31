<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION); 

  /*echo "_POST<pre>";
  print_r($_POST);
  echo "</pre>"; */
$rutaado = ("../../../funciones/adodb/");
require_once('../../../Connections/salaado-pear.php');
require_once(realpath(dirname(__FILE__))."/../../../funciones/clases/motorv2/motor.php");
require_once(realpath(dirname(__FILE__))."/../../../funciones/validaciones/validaciongenerica.php");
//require_once("../../../funciones/clases/formulario/clase_formulario.php");
//require_once("../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once(realpath(dirname(__FILE__)).'/../../../funciones/sala_genericas/FuncionesFecha.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/sala_genericas/FuncionesMatriz.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/sala_genericas/FuncionesSeguridad.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/sala_genericas/clasebasesdedatosgeneral.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/sala_genericas/tiposusuario/Usuario.php');
require_once(realpath(dirname(__FILE__))."/../../../Connections/conexionldap.php");
require_once(realpath(dirname(__FILE__))."/../../../funciones/clases/autenticacion/claseldap.php");
require_once(realpath(dirname(__FILE__))."/../../../consulta/estadisticas/matriculasnew/funciones/obtener_datos.php");
?>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
<script LANGUAGE="JavaScript">
    <!--
    function  ventanaprincipal(pagina){
        opener.focus();
        opener.location.href=pagina.href;
        window.close();
        return false;
    }
    function reCarga(enlace)
    {
        document.location.href="<?php echo 'menulistacorreo.php'; ?>";
    }
    function regresarGET()
    {
        document.location.href="<?php echo 'menulistacorreo.php'; ?>";
    }
    -->
</script>
<?php
//ini_set('max_execution_time','10');
$objetoldap = new claseldap(SERVIDORLDAP, CLAVELDAP, PUERTOLDAP, CADENAADMINLDAP, "", RAIZDIRECTORIO);
$objetoldap->ConexionAdmin();
//require_once('../../../funciones/clases/autenticacion/redirect.php');
if ($_REQUEST['codigocarrera'] != $_SESSION['codigocarreralistacorreo'] && (trim($_REQUEST['codigocarrera']) != ''))
    $_SESSION['codigocarreralistacorreo'] = $_REQUEST['codigocarrera'];

if ($_REQUEST['tipousuario'] != $_SESSION['tipousuariolistacorreo'] && (trim($_REQUEST['tipousuario']) != ''))
    $_SESSION['tipousuariolistacorreo'] = $_REQUEST['tipousuario'];

/* if($_REQUEST['tipousuario']!=$_SESSION['tipousuariolistacorreo']&&(trim($_REQUEST['tipousuario'])!=''))
  $_SESSION['tipousuariolistacorreo']=$_REQUEST['tipousuario']; */


$codigocarrera = $_SESSION['codigocarreralistacorreo'];
$tipousuario = $_SESSION['tipousuariolistacorreo'];
$codigoperiodo = $_SESSION['codigoperiodosesion'];
//$codigoperiodo = "20102";
//$formulario = new formulariobaseestudiante($sala, 'form1', 'post', '', 'true');
$objetobase = new BaseDeDatosGeneral($sala);
$objusuario = new Usuario($objetobase, $objetoldap);
//echo "<br>1)".date("Y-m-d H:i:s");

$objestadisticas = new obtener_datos_matriculas($objetobase->conexion, $codigoperiodo);
//echo "<br>2.1)".date("Y-m-d H:i:s");
$objusuario->setObjEstadisticas($objestadisticas);
$objusuario->setTipoUsuario('600');
$objusuario->setCodigoPeriodo($codigoperiodo);
//$objusuario->listaUsuarioActivo();
//echo "<br>2)".date("Y-m-d H:i:s");
$objusuario->setCacheUsuarioEstudiante($codigocarrera, $_SESSION['cacheusuarioestudiante'][$codigocarrera]);
$objusuario->setCacheUsuarioDocente($codigocarrera, $_SESSION['cacheusuariodocente'][$codigocarrera]);
//echo "<br>3)".date("Y-m-d H:i:s");
switch ($tipousuario) {

    case "estudiante":
        $datosusuario = $objusuario->listaUsuarioEstudianteMatriculado($codigocarrera);
        $_SESSION['cacheusuarioestudiante'][$codigocarrera] = $datosusuario;
        break;
    case "docente":
        $datosusuario = $objusuario->listaUsuarioDocenteActivo($codigocarrera);
        $_SESSION['cacheusuariodocente'][$codigocarrera] = $datosusuario;
        break;
    case "administrativo":
        $datosusuario = $objusuario->listaUsuarioAdministrativo($codigocarrera);
        //$_SESSION['cacheusuariodocente'][$codigocarrera]=$datosusuario;
        break;
}
//echo "<br>4)".date("Y-m-d H:i:s");
//$usuario = $formulario->datos_usuario();
//obtener_datos_matriculas($conexion, $codigoperiodo);
for ($i = 0; $i < count($datosusuario); $i++) {
    unset($datosusuario[$i]['Correo_Personal']);
    unset($datosusuario[$i]['Documento']);
}
$datoscarrera = $objetobase->recuperar_datos_tabla('carrera', 'codigocarrera', $_SESSION['codigocarreralistacorreo'], "", "", 0);

echo "<table width='400'><tr><td align='center'><h3>LISTADO USUARIOS " . strtoupper($_SESSION['tipousuariolistacorreo']) . "S  EN  " . $datoscarrera["nombrecarrera"] . " PERIODO " . $_SESSION['codigoperiodosesion'] . "</h3></td></tr><tr><td>";

$motor = new matriz($datosusuario, "listausuarios", "listacorreo.php", 'si', 'si', 'menulistacorreo.php', 'listacorreo.php', true, "si", "../../../");
//$motor->agregarllave_drilldown('iddetallehorarioprematricula','listadohorarioprematricula.php','horarioprematricula.php','','iddetallehorarioprematricula',"",'','','','','onclick= "return ventanaprincipal(this)"');
//$motor->agregar_llaves_totales('total_estudiante',"","","totales","","","","Totales");
//$motor->agregar_llaves_totales('total_docente',"","","totales","","","","Totales");
//$motor->agregar_llaves_totales('total_usuario',"","","totales","","","","Totales");
//$tabla->botonRecargar = false;
unset($_GET);
$motor->mostrar();
echo "</td></tr></table>";
?>
