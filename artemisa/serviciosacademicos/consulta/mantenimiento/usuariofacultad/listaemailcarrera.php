<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION); 
/* echo "_GET<pre>";
  print_r($_GET);
  echo "</pre>";
  echo "_POST<pre>";
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
        document.location.href="<?php echo 'menuemailcarrera.php'; ?>";
    }
    function regresarGET()
    {
        document.location.href="<?php echo 'menuemailcarrera.php'; ?>";
    }
    -->
</script>
<?php
//ini_set('max_execution_time','10');
$objetoldap = new claseldap(SERVIDORLDAP, CLAVELDAP, PUERTOLDAP, CADENAADMINLDAP, "", RAIZDIRECTORIO);
$objetoldap->ConexionAdmin();
//require_once('../../../funciones/clases/autenticacion/redirect.php');
if ($_REQUEST['codigomodalidadacademica'] != $_SESSION['codigomodalidadacademicaemailcarrera'] && (trim($_REQUEST['codigomodalidadacademica']) != ''))
    $_SESSION['codigomodalidadacademicaemailcarrera'] = $_REQUEST['codigomodalidadacademica'];

if ($_REQUEST['tipousuario'] != $_SESSION['tipousuarioemailcarrera'] && (trim($_REQUEST['tipousuario']) != ''))
    $_SESSION['tipousuarioemailcarrera'] = $_REQUEST['tipousuario'];

/* if($_REQUEST['tipousuario']!=$_SESSION['tipousuariolistacorreo']&&(trim($_REQUEST['tipousuario'])!=''))
  $_SESSION['tipousuariolistacorreo']=$_REQUEST['tipousuario']; */


$codigomodalidadacademica = $_SESSION['codigomodalidadacademicaemailcarrera'];
$tipousuario = $_SESSION['tipousuarioemailcarrera'];
$codigoperiodo = $_SESSION['codigoperiodosesion'];
//$codigoperiodo = "20102";
//$formulario = new formulariobaseestudiante($sala, 'form1', 'post', '', 'true');
$objetobase = new BaseDeDatosGeneral($sala);
$objusuario = new Usuario($objetobase, $objetoldap);
//echo "<br>1)".date("Y-m-d H:i:s");
$tabla = "carreraemail c , carrera ca, tipousuario tp";
$nombreidtabla = "tp.codigotipousuario";
$idtabla = $_SESSION['tipousuarioemailcarrera'];
if($codigomodalidadacademica!='todos'&&trim($codigomodalidadacademica)!='')
    $condicion="  and ca.codigomodalidadacademica='" . $codigomodalidadacademica . "'" ;
else
    $condicion="";
$condicion .= " and ca.codigocarrera= c.codigocarrera" .
        " and tp.codigotipousuario=c.codigotipousuario";
$resultado = $objetobase->recuperar_resultado_tabla($tabla, $nombreidtabla, $idtabla, $condicion,"",0);
$i=0;
while($rowemailcarrera=$resultado->fetchRow()){
    $datosemaillist[$i]["Lista_de_Correo"]=$rowemailcarrera['emailcarreraemail']."@unbosque.edu.co";
    $datosemaillist[$i]["Carrera"]=$rowemailcarrera['nombrecarrera'];
    //$datosemaillist[$i]["Tipo_Usuario"]=$rowemailcarrera['nombretipousuario'];
    $i++;
    $nombretipousuario=$rowemailcarrera['nombretipousuario'];
}
$datosmodalidad = $objetobase->recuperar_datos_tabla('modalidadacademica', 'codigomodalidadacademica', $codigomodalidadacademica, "", "", 0);

echo "<table width='400'><tr><td align='center'><h3>LISTAS DE CORREO " . $nombretipousuario . "  EN  " . $datosmodalidad["nombremodalidadacademica"] . " </h3></td></tr><tr><td>";

$motor = new matriz($datosemaillist, "listausuarios", "listacorreo.php", 'si', 'si', 'menulistacorreo.php', 'listacorreo.php', true, "si", "../../../");
//$motor->agregarllave_drilldown('iddetallehorarioprematricula','listadohorarioprematricula.php','horarioprematricula.php','','iddetallehorarioprematricula',"",'','','','','onclick= "return ventanaprincipal(this)"');
//$motor->agregar_llaves_totales('total_estudiante',"","","totales","","","","Totales");
//$motor->agregar_llaves_totales('total_docente',"","","totales","","","","Totales");
//$motor->agregar_llaves_totales('total_usuario',"","","totales","","","","Totales");
//$tabla->botonRecargar = false;
unset($_GET);
$motor->mostrar();
echo "</td></tr></table>";
?>
