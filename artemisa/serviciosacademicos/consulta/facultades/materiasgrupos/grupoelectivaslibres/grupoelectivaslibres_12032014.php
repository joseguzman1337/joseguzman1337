<?php
session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
  <head>
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
        var formulario=document.getElementById("form1");
        formulario.action="";
        formulario.submit();
    }
</script>
<script type="text/javascript" src="../../../../funciones/sala_genericas/ajax/requestxml.js"></script>
  </head>
  <body>
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

echo "<form id=\"form1\" name=\"form1\" action=\"listadodetalledesercion.php\" method=\"post\"  >
<input type=\"hidden\" name=\"AnularOK\" value=\"\">
	<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\">";
$datos_usuario = $formulario->datos_usuario();
$numerodocumento = $datos_usuario["numerodocumento"];
unset($formulario->filatmp);
$formulario->dibujar_fila_titulo('Grupos de materias de electivas libres', 'labelresaltado', "2", "align='center'");
$condicion = " g.codigoperiodo='" . $_SESSION["codigoperiodosesion"] . "'
    and g.codigotipogrupomateria ='100'";
$formulario->filatmp = $objetobase->recuperar_datos_tabla_fila("grupomateria g", "g.idgrupomateria", "g.nombregrupomateria", $condicion, "", 0);
/* echo "<pre>";
  print_r($formulario->filatmp);
  echo "</pre>"; */
$formulario->filatmp[""] = "Seleccionar";
$campo = 'menu_fila';
$parametros = "'idgrupomateria','" . $_POST['idgrupomateria'] . "','onchange=enviarmenu();'";
$formulario->dibujar_campo($campo, $parametros, "Grupo Electivas", "tdtitulogris", 'idgrupomateria', '');
if (isset($_POST['idgrupomateria']) &&
        trim($_POST['idgrupomateria']) != '') {
    $_SESSION["grupoelectivas_idgrupomateria"]=$_POST['idgrupomateria'];
    $tabla = "materia m,grupomateria gm,detallegrupomateria dgm
        left join detallegrupomateria dgm2 on dgm2.codigomateria=dgm.codigomateria
        and dgm2.idgrupomateria=" . $_POST['idgrupomateria'] . "";
    $condicion = " and gm.idgrupomateria=dgm.idgrupomateria" .
            " and m.codigomateria=dgm.codigomateria" .
            " and gm.codigotipogrupomateria ='100'".
    " group by m.codigomateria".
    " order by m.nombremateria";
    $resultmateriaslibres = $objetobase->recuperar_resultado_tabla($tabla, "gm.codigoperiodo", $_SESSION["codigoperiodosesion"], $condicion, ",m.codigomateria codigomateriamateria,dgm2.idgrupomateria idgrupomaterialibre",0);
    $i=0;
    while ($rowmateriaslibres = $resultmateriaslibres->fetchRow()) {
        $arrayparametroscajax[$i]["enunciado"] = $rowmateriaslibres["nombremateria"];
        $arrayparametroscajax[$i]["nombre"] = $rowmateriaslibres["codigomateriamateria"];
        $arrayparametroscajax[$i]["valorsi"] = $_POST['idgrupomateria'];
        $arrayparametroscajax[$i]["valorno"] = 0;
        if (isset($rowmateriaslibres["idgrupomaterialibre"]) &&
                trim($rowmateriaslibres["idgrupomaterialibre"]) != '') {
            $arrayparametroscajax[$i]["check"] = "checked";
        } else {
            $arrayparametroscajax[$i]["check"] = "";
        }
        $i++;
    }
   /* echo "arrayparametroscajax<pre>";
    print_r($arrayparametroscajax);
    echo "</pre>";*/

    $formulario->dibujar_cajax_chequeos($arrayparametroscajax, "asignagrupoelectiva.php", 'labelresaltado', "");
}

echo "</table></form>";
?>
  </body>
</html>