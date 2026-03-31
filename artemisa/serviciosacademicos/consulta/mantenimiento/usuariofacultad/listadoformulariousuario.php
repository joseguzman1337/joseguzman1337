<?php
if($_SERVER['REMOTE_ADDR']=="127.0.0.1" || $_SERVER['REMOTE_ADDR']=="localhost"){
	require_once("../../../../kint/Kint.class.php");
	error_reporting(0);
	ini_set('display_errors', 0);
}
session_start();
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
    function reCarga()
    {
        document.location.href="<?php echo 'busquedaformulariousuario.php'; ?>";
    }
    function regresarGET()
    {
        document.location.href="<?php echo 'busquedaformulariousuario.php'; ?>";
    }
    function enviacorreoajax(archivo,parametros){

        process(archivo,parametros);
       
        setTimeout('muestrarespuesta()',500);

       

        return false;
    }
    function muestrarespuesta(){
        if(xmlRoot!=null){
            var responseText = xmlRoot.firstChild.data;
            alert(responseText);
            
        }
        else
            setTimeout('muestrarespuesta()',500);

    }

</script>
<script type="text/javascript" src="../../../funciones/sala_genericas/ajax/requestxml.js"></script>

<?php
$rutaado = ("../../../funciones/adodb/");
require_once("../../../funciones/clases/motorv2/motor.php");
require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../../funciones/sala_genericas/FuncionesMatriz.php");
require_once("../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once( "../../../Connections/conexionldap.php");
require_once("../../../funciones/clases/autenticacion/claseldap.php");


function encuentra_array_materias($arraysesion, $objetobase, $imprimir=0) {

    $usuario = $arraysesion['formulariousuario'];
    $numerodocumento = $arraysesion['formularionumerodocumento'];
    $apellidos = $arraysesion['formularioapellidos'];
    $nombres = $arraysesion['formularionombres'];

    $query = "select distinct u.idusuario ,u.apellidos Apellidos,u.nombres Nombres, u.numerodocumento Documento, u.usuario Usuario,
    u.codigousuario Codigousuario, u.ipaccesousuario IPAccesoUsuario, t.nombretipousuario codigoTipoUsuario,eu.nombreestadousuario codigoEstadoUsuario, u.fechainiciousuario, u.fechavencimientousuario, u.fecharegistrousuario from estadousuario eu, tipousuario t, usuario u  left join logcreacionusuario l on l.idusuario=u.idusuario and l.codigoestado=100 and l.tmpclavelogcreacionusuario <> ''
    where u.numerodocumento  like '%$numerodocumento%' and  u.apellidos like '%$apellidos%'and  u.nombres like '%$nombres%'
    and  u.usuario like '%$usuario%' and eu.codigoestadousuario=u.codigoestadousuario and t.codigotipousuario=u.codigotipousuario order by Apellidos, Nombres";

    if ($imprimir)
        echo $query;

    $operacion = $objetobase->conexion->query($query);

    while ($row_operacion = $operacion->fetchRow()) {

        $objetoldap = new claseldap(SERVIDORLDAP, CLAVELDAP, PUERTOLDAP, CADENAADMINLDAP, "", RAIZDIRECTORIO);
        $objetoldap->ConexionAdmin();
        $datosuasuario = $objetoldap->DatosUsuario($row_operacion["Usuario"]);
        $row_operacion["Correo_Personal"] = $datosuasuario[0]["gacctmail"][0];
        $enviacorreoget = "numerodocumento=" . $row_operacion["Documento"] . "&usuario=" . $row_operacion["Usuario"] . "";
        $row_operacion["Envia_Correo"] = "<a href=Javascript onclick=\"return enviacorreoajax('cambioclavecorreo.php','" . $enviacorreoget . "');\">Envia Correo</a>";
        $array_interno[] = $row_operacion;
    }
    return $array_interno;
}

$objetobase = new BaseDeDatosGeneral($sala);
$formulario = new formulariobaseestudiante($sala, 'form2', 'post', '', 'true');
 
if ($_POST['formulario'] == 1) {
    if ($_REQUEST['usuario'] != $_SESSION['formulariousuario'])
        $_SESSION['formulariousuario'] = $_REQUEST['usuario'];

    if ($_REQUEST['numerodocumento'] != $_SESSION['formularionumerodocumento'])
        $_SESSION['formularionumerodocumento'] = $_REQUEST['numerodocumento'];

    if ($_REQUEST['apellidos'] != $_SESSION['formularioapellidos'])
        $_SESSION['formularioapellidos'] = $_REQUEST['apellidos'];

    if ($_REQUEST['nombres'] != $_SESSION['formularionombres'])
        $_SESSION['formularionombres'] = $_REQUEST['nombres'];
}
else {

    if ($_REQUEST['usuario'] != $_SESSION['formulariousuario'] && trim($_REQUEST['usuario']) != '')
        $_SESSION['formulariousuario'] = $_REQUEST['usuario'];

    if ($_REQUEST['numerodocumento'] != $_SESSION['formularionumerodocumento'] && trim($_REQUEST['numerodocumento']) != '')
        $_SESSION['formularionumerodocumento'] = $_REQUEST['numerodocumento'];

    if ($_REQUEST['apellidos'] != $_SESSION['formularioapellidos'] && trim($_REQUEST['apellidos']) != '')
        $_SESSION['formularioapellidos'] = $_REQUEST['apellidos'];

    if ($_REQUEST['nombres'] != $_SESSION['formularionombres'] && trim($_REQUEST['nombres']) != '')
        $_SESSION['formularionombres'] = $_REQUEST['nombres'];
}
$_SESSION['SESIONINICIADASAHDJASHER8921743'] = 1;

/*  echo "<pre>";
  print_r($_SESSION);
  echo "</pre>";
*/
if( $_SESSION['formulariousuario']. $_SESSION['formularionumerodocumento'].$_SESSION['formularioapellidos'].$_SESSION['formularionombres']==''){
    alerta_javascript("Debe diligenciar al menos un campo del formularío");
    echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=busquedaformulariousuario.php'>";
    exit ();
    
}


$datoscarrera = $objetobase->recuperar_datos_tabla('usuario', 'idusuario', $_SESSION['idusuario'], "", "", 0);
echo "<table width='400'><tr><td align='center'><h3> LISTA USUARIO    </h3></td></tr><tr><td>";

$cantidadestmparray = encuentra_array_materias($_SESSION, $objetobase, 0);

$motor = new matriz($cantidadestmparray, "usuario ", "listadoformulariousuario.php", 'si', 'si',
                'busquedaformulariousuario.php', 'listadoformulariousuario.php', true, "si", "../../../");
$motor->agregarllave_drilldown('Documento', 'listadoformulariousuario.php', 'formulariousuario.php', '', 'idusuario',
        '', 'idusuario', '', '', '', 'onclick= "return ventanaprincipal(this)"');
unset($_GET);
$motor->botonRecargar = false;
$motor->mostrar();

echo "</td></tr></table>";
?>
