<?php

session_start();

$rutaado = ("../../serviciosacademicos/funciones/adodb/");
require_once("../../serviciosacademicos/Connections/salaado-pear.php");
require_once("../../serviciosacademicos/funciones/clases/formulario/clase_formulario.php");
require_once("../../serviciosacademicos/funciones/phpmailer/class.phpmailer.php");
require_once("../../serviciosacademicos/funciones/validaciones/validaciongenerica.php");
require_once("../../serviciosacademicos/funciones/sala_genericas/FuncionesCadena.php");
require_once("../../serviciosacademicos/funciones/sala_genericas/FuncionesFecha.php");
require_once("../../serviciosacademicos/funciones/sala_genericas/FuncionesSeguridad.php");
require_once("../../serviciosacademicos/funciones/sala_genericas/FuncionesMatematica.php");
require_once("../../serviciosacademicos/funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../serviciosacademicos/funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../../serviciosacademicos/funciones/sala_genericas/securimage/securimage.php");
require_once("correoactivacioncuenta.php");
require_once("constantesactivacion.php");
$formulario = new formulariobaseestudiante($sala, "form1", "post", "", "true");
$formulario->rutaraiz = "../../serviciosacademicos/funciones/sala_genericas/";
$objetobase = new BaseDeDatosGeneral($sala);

$clavesha = hash('sha256',$_POST['clave']);
if (isset($_REQUEST["ingresar"])) {
    $condicion = " and eg.idestudiantegeneral=up.idestudiantegeneral
        and eg.emailestudiantegeneral='" . $_POST['usuario'] . "'
            and up.claveusuariopreinscripcion='" . $clavesha . "'";
    $tablas = "usuariopreinscripcion up,estudiantegeneral eg";
    if ($datosestudiante = $objetobase->recuperar_datos_tabla($tablas, "1", "1", $condicion, "", 0)) {
        $_SESSION['inscripcionactiva']=1;
        echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=../../serviciosacademicos/consulta/prematricula/inscripcionestudiante/formulariopreinscripcion.php?documentoingreso=" . $datosestudiante['numerodocumento'] . "'>";
    } else {
        $mensaje = "Usuario o clave incorrectos";
        alerta_javascript($mensaje);
        echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=" . ENLACEINGRESOASPIRANTE . "'>";
    }
}
?>