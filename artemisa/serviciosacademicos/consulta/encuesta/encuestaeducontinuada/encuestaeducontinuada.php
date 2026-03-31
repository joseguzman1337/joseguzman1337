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
//require_once("seleccionmateria.php");
unset($_SESSION['tmptipovotante']);
$fechahoy=date("Y-m-d H:i:s");
$formulario=new formulariobaseestudiante($sala,'form1','post','','true');
$objetobase=new BaseDeDatosGeneral($sala);
$datosasistente=$objetobase->recuperar_datos_tabla('asistente a, asistentediploma ad', 'a.idasistente', $_GET['idasistente'], 'and a.idasistente=ad.idasistente');
    $_SESSION["codigoperiodo_autoenfermeria"]='20101';
    $objvalidaautoevaluacion=new ValidaEncuesta($objetobase,'20101', '1');
//if($objvalidaautoevaluacion->encuestaCarreraActiva()){
    $objvalidaautoevaluacion->setidasistente($_GET['idasistente']);
    if($objvalidaautoevaluacion->validaEncuestaEducontinuada()){
        //alerta_javascript('Ha finalizado la encuesta,\n Gracias por su colaboracion');
        echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=../../educacioncontinuada/certificadoymemorias.php?documento=".$datosasistente['documentoasistente']."&iddiploma=".$datosasistente['iddiploma']."'>";
    }
//}

   
//if(isset($_POST["codigomateria"])&&$_POST["codigomateria"]!='') {
    $objconsultaencuesta=new ConsultaEncuesta($objetobase,$formulario);
    $tabla="respuestaeducacioncontinuada";
    $objconsultaencuesta->setTablaRespuesta($tabla);
//$idusuarioencuesta=encuentrausuarioencuesta($codigoestudiante,$codigomateria);
    $_SESSION["codigoestudiante_autoenfermeria"]=$_GET["codigoestudiante"];
    $_SESSION["codigomateria_autoenfermeria"]=$_POST["codigomateria"];
    $idusuarioencuesta=$_GET['idasistente'];
    $objmostrarencuesta=new MostrarEncuesta($idusuarioencuesta,$objetobase,$formulario,$objconsultaencuesta);

   /* $condicion=" now() between e.fechainicioencuesta and e.fechafinalencuesta";
    $condicion.=" and em.idencuesta=e.idencuesta and em.codigomateria='".$_POST["codigomateria"]."'";
    $datosencuestamateria=$objetobase->recuperar_datos_tabla("encuesta e,encuestamateria em","e.codigocarrera",8," and ".$condicion,"",0);
    */

    $idencuesta='43';
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
        <script LANGUAGE="JavaScript">
            function enviarrespuesta(obj,idpregunta,idusuario,idencuesta){
                var params="idpregunta="+idpregunta+"&idusuario="+idusuario+"&idencuesta="+idencuesta+"&valorrespuesta="+obj.value;
                //process("../../../funciones/sala_genericas/encuesta/actualizarespuestapregunta.php",params);
                process("actualizarencuestaeducontinuada.php",params);
                //alert("actualizarespuestapregunta.php?"+params);
                return true;
            }

            function enviarmateria(){
                //alert(pagina);

                var formulario=document.getElementById("formescogemateria");
                //formulario.action="encuestaenfermeria.php";
                //alert(formulario.action);
                formulario.submit();
                //return false;
            }

            //open("../seguridad.html" , "ventana1" , "width=290,height=200,scrollbars=NO");
            //quitarFrame()
        </script>
    </head>
    <body>
        <?php

       // seleccionmateria($_GET["codigoestudiante"],$objetobase,$formulario,$_SESSION["codigoperiodo_autoenfermeria"]);
        //if(isset($_POST["codigomateria"])&&$_POST["codigomateria"]!='') {
            $objmostrarencuesta->setIdEncuesta($idencuesta);
            $objmostrarencuesta->iniciarEncuestaUsuario();
            $objmostrarencuesta->mostrarTitulosEncuesta();
            
            $filaadicional["codigoestudiante"]=$_SESSION["codigoestudiante_autoenfermeria"];
            $filaadicional["codigomateria"]=$_SESSION["codigomateria_autoenfermeria"];
            $filaadicional["codigoperiodo"]=$_SESSION["codigoperiodo_autoenfermeria"];
            $mensajeninicial="Califique las siguientes preguntas relacionadas al evento realizado";
            echo "	<form id=\"form1\" name=\"form1\" action=\"\" method=\"post\"  >
		<input type=\"hidden\" name=\"AnularOK\" value=\"\">
		<input type=\"hidden\" name=\"idencuesta\" value=\"".$objmostrarencuesta->idencuesta."\">";

            $objmostrarencuesta->imprimirEncuesta($mensajeninicial);
            $objmostrarencuesta->ingresarTotalPreguntas($tabla,$filaadicional);
            
            $formulario->boton_tipo("hidden", "codigomateria", $_POST["codigomateria"]);
            echo "</form>";
            $mensajeexito="Ha sido para nosotros muy importante su colaboración. \\nGracias, \\nCOMITÉ ORGANIZADOR.";
            $mensajefalta="No puede continuar hasta que diligencie toda la encuesta";
            $direccionexito="encuestaeducontinuada.php?idasistente=".$_GET["idasistente"];
            $direccionfalta="encuestaeducontinuada.php?idasistente=".$_GET["idasistente"];

            $objmostrarencuesta->guardarEncuesta($mensajeexito, $mensajefalta, $direccionexito, $direccionfalta,$tabla,$filaadicional);

        //}
        ?>
        <script type="text/javascript">
            var pathruta='../../../funciones/sala_genericas/ajax/tab/';
<?php
$cadena= "var arraypestanas=Array(";
$con=0;
if(is_array($objmostrarencuesta->arraytitulospestanas))
    foreach($objmostrarencuesta->arraytitulospestanas as $i=>$row) {
        //trim(sacarpalabras(str_replace("de","",str_replace("y","",$row["nombre"])),0,1))

        if($con==0)
            $cadena.="'".substr(($con+1).". ".$row["nombre"],0,13)."...'";
        else
            $cadena.=",'".substr(($con+1).". ".$row["nombre"],0,13)."...'";

        $con++;
    }
$cadena.= ");\n";
echo $cadena;

?>
    initTabs('formularioencuesta',arraypestanas,0,760,400);

    function cambiapestana(pestana){
        //alert("pestana="+pestana);
        //initTabs('formulariohorario',arraypestanas,pestana,760,400);
        showTab('formularioencuesta',pestana);
        return false;
    }

        </script>

    </body>
</html>