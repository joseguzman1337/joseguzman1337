<?php
session_start();
$rutaado = ("../../../funciones/adodb/");

require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../../funciones/sala_genericas/encuestav2/MostrarEncuesta.php");
require_once("../../../funciones/sala_genericas/encuestav2/ConsultaEncuesta.php");
require_once("../../../funciones/sala_genericas/encuestav2/ValidaEncuesta.php");
//require_once("seleccionmateria.php");
ini_set('max_execution_time','6000');

unset($_SESSION['tmptipovotante']);
$fechahoy = date("Y-m-d H:i:s");
$idencuesta = '48';
$formulario = new formulariobaseestudiante($sala, 'form1', 'post', '', 'true');
$objetobase = new BaseDeDatosGeneral($sala);
$objvalidaautoevaluacion = new ValidaEncuesta($objetobase, '20111', '1');
$objvalidaautoevaluacion->setIdEncuesta($idencuesta);
$tabla = "respuestainstitucional";
$objvalidaautoevaluacion->setTablaRespuesta($tabla);

if (!$objvalidaautoevaluacion->encuentraEstudianteEncuestaBienestar($_GET['idusuario'])) {
    echo "<script type='text/javascript'>parent.continuar();</script>";
}
//if($objvalidaautoevaluacion->encuestaCarreraActiva()){
//}
//if(isset($_POST["codigomateria"])&&$_POST["codigomateria"]!='') {
$objconsultaencuesta = new ConsultaEncuesta($objetobase, $formulario);

$objconsultaencuesta->setTablaRespuesta($tabla);
//$idusuarioencuesta=encuentrausuarioencuesta($codigoestudiante,$codigomateria);
$_SESSION["codigoestudiante_autoenfermeria"] = $_GET["codigoestudiante"];
$_SESSION["codigomateria_autoenfermeria"] = $_POST["codigomateria"];
$idusuarioencuesta = $_GET['idusuario'];
$objmostrarencuesta = new MostrarEncuesta($idusuarioencuesta, $objetobase, $formulario, $objconsultaencuesta);

/* $condicion=" now() between e.fechainicioencuesta and e.fechafinalencuesta";
  $condicion.=" and em.idencuesta=e.idencuesta and em.codigomateria='".$_POST["codigomateria"]."'";
  $datosencuestamateria=$objetobase->recuperar_datos_tabla("encuesta e,encuestamateria em","e.codigocarrera",8," and ".$condicion,"",0);
 */


//}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>

        <link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
        <script type="text/javascript" src="../../../funciones/javascript/funciones_javascript.js"></script>
        <style type="text/css">@import url(../../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
        <script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar.js"></script>
        <script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-es.js"></script>
        <script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-setup.js"></script>
        <script type="text/javascript" src="../../../funciones/clases/formulario/globo.js"></script>
        <link rel="stylesheet" href="../../../funciones/sala_genericas/ajax/tab/css/tab-view.css" type="text/css" media="screen">
        <script type="text/javascript" src="../../../funciones/sala_genericas/ajax/tab/js/ajax.js"></script>


        <script type="text/javascript" src="../../../funciones/sala_genericas/ajax/tab/js/tab-view.js"></script>
        <script type="text/javascript" src="../../../funciones/sala_genericas/ajax/requestxml.js"></script>
        <script type="text/javascript" src="funciones.js"></script>
        <script LANGUAGE="JavaScript">

        </script>
    </head>
    <body>
    <center>
<?php
$objmostrarencuesta->setIdEncuesta($idencuesta);
$condicion = " and t.idestudiantegeneral=eg.idestudiantegeneral ";
//$resultadousuarioencuesta = $objetobase->recuperar_resultado_tabla("tmpestudianteencuestabienestar t,estudiantegeneral eg", "1", "1", $condicion, "", 0);
$i = 0;
$j = 0;
$condicion =" and o.numeroordenpago=d.numeroordenpago
					and eg.idestudiantegeneral=e.idestudiantegeneral
						AND e.codigoestudiante=pr.codigoestudiante
						AND pr.codigoperiodo='20111'
						AND e.codigoestudiante=o.codigoestudiante
						AND c.codigocarrera=e.codigocarrera
						AND d.codigoconcepto=co.codigoconcepto
						AND co.cuentaoperacionprincipal=151
						AND o.codigoperiodo='20111'
						AND o.codigoestadoordenpago LIKE '4%'
						AND c.codigomodalidadacademica like '2%'
						AND e.codigoperiodo='20111'
						";

$resultadousuarioencuesta=$objetobase->recuperar_resultado_tabla("ordenpago o, detalleordenpago d, estudiante e, carrera c, concepto co, prematricula pr,estudiantegeneral eg","c.codigomodalidadacademica",'200',$condicion,'',1);

while ($rowusuarioencuesta = $resultadousuarioencuesta->fetchRow()) {
   
$usuarioencuesta[] = $rowusuarioencuesta['idestudiantegeneral'];
//$rowusuarioencuesta['idestudiantegeneral']="63903";
$objvalidaautoevaluacion->setUsuario($rowusuarioencuesta['idestudiantegeneral']);
$preguntasfacultades = $objvalidaautoevaluacion->validaPreguntasFaltantes();
    /* echo "<pre>";
      print_r($preguntasfacultades);
      echo "</pre>"; */
    if (!is_array($preguntasfacultades) ||
            (count($preguntasfacultades) < 1)) {
        // alerta_javascript('Ha finalizado la encuesta,\n Gracias por su colaboracion');
       //  echo ($i++).")".$rowusuarioencuesta['idestudiantegeneral']."-".$rowusuarioencuesta['numerodocumento']."<br>";
        //echo "<script type='text/javascript'>parent.continuar();</script>";
        $i++;
         $usuariorespuesta[] = $rowusuarioencuesta['idestudiantegeneral'];
      //  exit();
        //echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=../../educacioncontinuada/certificadoymemorias.php?documento=" . $datosasistente['documentoasistente'] . "&iddiploma=" . $datosasistente['iddiploma'] . "'>";
    } else {
        // alerta_javascript('No ha finalizado la encuesta');
         $j++;
        //echo ($j++).")".$rowusuarioencuesta['idestudiantegeneral']."<br>";
        //echo ($j++) . ")" . $rowusuarioencuesta['idestudiantegeneral'] . "-" . $rowusuarioencuesta['numerodocumento'] . "-faltan " . count($preguntasfacultades) . " preguntas<br>";
    }
}
/*echo "usuariorespuesta<pre>";
print_r($usuariorespuesta);
echo "</pre>";*/
//exit();
//$usuariorespuesta[] = "74282602";
$objmostrarencuesta->objconsultaencuesta->setArregloUsuario($usuariorespuesta);
$objmostrarencuesta->iniciarEncuestaUsuario();
$objmostrarencuesta->imprimirResultadosEncuesta($tituloinicial = "", $cadenaparametros, $tablasadicionales);

echo "Estudiantes que resolvieron completamente la encuesta " . $i;
echo "<br>Estudiantes que faltan " . $j;
//$objmostrarencuesta->objconsultaencuesta->setArregloUsuario($usuarioencuesta);
?>
    </center>
</body>
</html>