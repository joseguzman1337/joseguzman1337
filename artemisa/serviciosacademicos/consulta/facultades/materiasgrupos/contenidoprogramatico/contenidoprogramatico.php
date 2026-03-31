<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
session_start();
?>
<link rel="stylesheet" type="text/css" href="../../../../estilos/sala.css">

<script LANGUAGE="JavaScript">
    function  ventanaprincipal(pagina){
        opener.focus();
        opener.location.href=pagina.href;
        window.close();
        return false;
    }
    function reCarga(){
        document.location.href="<?php echo '../matriculas/menu.php'; ?>";

    }
    function regresarGET()
    {
        document.location.href="<?php echo '../matriculas/menu.php'; ?>";
    }
    function enviarmenu()
    {
        form1.action="";
        form1.submit();
    }
</script>
<?php
$rutaado = ("../../../../funciones/adodb/");
require_once("../../../../funciones/clases/motorv2/motor.php");
require_once("../../../../Connections/salaado-pear.php");
require_once("../../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../../../funciones/sala_genericas/FuncionesMatriz.php");
require_once("../../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");

$objetobase = new BaseDeDatosGeneral($sala);
$formulario = new formulariobaseestudiante($sala, 'form2', 'post', '', 'true');

echo "<form name=\"form1\" action=\"listadodetalledesercion.php\" method=\"post\"  >
<input type=\"hidden\" name=\"AnularOK\" value=\"\">
	<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\">";
$datos_usuario = $formulario->datos_usuario();
$numerodocumento = $datos_usuario["numerodocumento"];
unset($formulario->filatmp);
$formulario->dibujar_fila_titulo('Formato Institucional de SYLLABUS', 'labelresaltado', "2", "align='center'");
$condicion = " g.codigomateria=m.codigomateria
     and g.codigoperiodo='" . $_SESSION["codigoperiodosesion"] . "'
         and g.numerodocumento='" . $numerodocumento . "'";
$formulario->filatmp = $objetobase->recuperar_datos_tabla_fila("materia m,grupo g", "m.codigomateria", "m.nombremateria", $condicion, "", 0);
/*echo "<pre>";
print_r($formulario->filatmp);
echo "</pre>";*/
$formulario->filatmp[""] = "Seleccionar";
$campo = 'menu_fila';
$parametros = "'codigomateria','" . $_POST['codigomateria'] . "','onchange=enviarmenu();'";
$formulario->dibujar_campo($campo, $parametros, "Materia", "tdtitulogris", 'codigomateria', '');

if(isset($_POST['codigomateria'])&&trim($_POST['codigomateria'])!=''){
$condicion=" and f.codigofacultad=c.codigofacultad
    and c.codigocarrera=m.codigocarrera
    ";
$datoscarreramateria=$objetobase->recuperar_datos_tabla("materia m,carrera c,facultad f", "m.codigomateria", $_POST['codigomateria'], $condicion, "", 0);


$fila["Facultad"] = "";
$fila[$datoscarreramateria["nombrefacultad"]] = "";
$formulario->dibujar_filas_texto($fila, 'tdtitulogris', '', "colspan=1", "colspan=1");
unset($fila);
$fila["Programa"] = "";
$fila[$datoscarreramateria["nombrecarrera"]] = "";
$formulario->dibujar_filas_texto($fila, 'tdtitulogris', '', "colspan=1", "colspan=1");
unset($fila);
$fila["Código Asignatura"] = "";
$fila[$datoscarreramateria["codigomateria"]] = "";
$formulario->dibujar_filas_texto($fila, 'tdtitulogris', '', "colspan=1", "colspan=1");

}
echo "</table></form>";
?>
