<?php
session_start();
 include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
?>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
<script language="javascript">
    function NuevoGET()
    {
        document.location.href="<?php echo 'formulariousuario.php'; ?>";
    }

    function regresarGET()
    {
        document.location.href="<?php echo 'busquedaformulariousuario.php'; ?>";
    }
    /*function enviar()
    {
        form1.action="";
        document.form1.submit();

    }
   /*function enviarmodalidad(){

        var codigocarrera=document.getElementById("codigocarrera");
        //document.getElementById("tr0")
        form1.action="";
        if(codigocarrera!=null)
            codigocarrera.value="";
        form1.submit();
    }*/

</script>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
<link rel="stylesheet" type="text/css" href="../../../funciones/sala_genericas/ajax/suggest/suggest.css">
<script type="text/javascript" src="../../../funciones/javascript/funciones_javascript.js"></script>
<style type="text/css">@import url(../../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-setup.js"></script>
<script type="text/javascript" src="../../../funciones/clases/formulario/globo.js"></script>
<script type="text/javascript" src="../../../funciones/sala_genericas/ajax/suggest/suggest.js"></script>

<?php
$rutaado = ("../../../funciones/adodb/");
require_once('../../../Connections/salaado-pear.php');
require_once("../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../funciones/validaciones/validaciongenerica.php");
require_once("../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once('../../../funciones/sala_genericas/FuncionesFecha.php');
require_once('../../../funciones/sala_genericas/FuncionesMatriz.php');
require_once('../../../funciones/sala_genericas/FuncionesSeguridad.php');
require_once('../../../funciones/sala_genericas/clasebasesdedatosgeneral.php');


$formulario=new formulariobaseestudiante($sala,'form1','post','','true');
$objetobase=new BaseDeDatosGeneral($sala);
$usuario=$formulario->datos_usuario();

echo "<form name='form1' action='listadoformulariousuario.php' method='POST' >
<input type='hidden' name='AnularOK' value=''>
	<table border='1' cellpadding='1' cellspacing='0' bordercolor='#E9E9E9' width='750'>";

if (isset($_GET['idusuario'])) {
    $datosplantillausuario = $objetobase->recuperar_datos_tabla("usuario", "idusuario", $_GET['idusuario'], '', '', 0);
    $usuario = $datosplantillausuario['usuario'];
    $numerodocumento = $datosplantillausuario['numerodocumento'];
    $apellidos = $datosplantillausuario['apellidos'];
    $nombres = $datosplantillausuario['nombres'];
   
}

$conboton = 0;
$formulario->dibujar_fila_titulo('Usuario', 'labelresaltado');
$condicion = "";
$campo = "boton_tipo";
$parametros = "'text','usuario','','maxlength=\"15\"'";
$formulario->dibujar_campo($campo, $parametros, "Usuario", "tdtitulogris", 'usuario', '');
$campo = "boton_tipo";
$parametros = "'text','numerodocumento','" . $numerodocumento . "','maxlength=\"15\"'";
$formulario->dibujar_campo($campo, $parametros, "Número Documento", "tdtitulogris", 'numerodocumento', '');
$campo = "boton_tipo";
$parametros = "'text','apellidos','" . $apellidos . "','maxlength=\"15\"'";
$formulario->dibujar_campo($campo, $parametros, "Apellidos", "tdtitulogris", 'apellidos', '');
$campo = "boton_tipo";
$parametros = "'text','nombres','" . $nombres . "','maxlength=\"15\"'";
$formulario->dibujar_campo($campo, $parametros, "Nombres", "tdtitulogris", 'nombres', '');
$campo = "boton_tipo";
$parametrobotonenviar[$conboton] = "'submit','Enviar','Enviar',' onclick=\'enviartarGET();\''";
$boton[$conboton] = 'boton_tipo';
$conboton++;
$parametrobotonenviar[$conboton] = "'button','Nuevo','Nuevo',' onclick=\'NuevoGET();\''";
$boton[$conboton] = 'boton_tipo';
$conboton++;
$parametrobotonenviar[$conboton] = "'button','Regresar','Regresar','onclick=\'regresarGET();\''";
$boton[$conboton] = 'boton_tipo';
$formulario->dibujar_campos($boton, $parametrobotonenviar, "", "tdtitulogris", 'Enviar', '', 0);
$formulario->boton_tipo('hidden','formulario','1','');
?>