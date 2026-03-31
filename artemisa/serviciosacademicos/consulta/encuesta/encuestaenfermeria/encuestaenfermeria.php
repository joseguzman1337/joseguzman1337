<?php
/*
 * Ivan Dario Quintero Rios
 * Abril 25 del 2018
 */    

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
    require_once("seleccionmateria.php");
    unset($_SESSION['tmptipovotante']);

    $fechahoy=date("Y-m-d H:i:s");
    $formulario=new formulariobaseestudiante($sala,'form1','post','','true');
    $objetobase=new BaseDeDatosGeneral($sala);

    $codigoestudiante=$_REQUEST['codigoestudiante'];
    /*
    * Ivan Dario quintero Rios
    * Abril 3 del 2018
    */

    //Se valida el dato de codigoestudiante, si no existe se valida con los datos de session
    if(empty($codigoestudiante)){
        $codigoestudiante = $_SESSION['codigo'];
    }
    //Se valida el dato de codigotipousuario, si no existe se valida con los datos de session
    if(empty($_REQUEST['codigotipousuario'])){
        $codigotipousuario = $_SESSION['codigotipousuario'];
    }
    /*END*/

    $query = "SELECT codigoperiodo from periodo where codigoestadoperiodo in (3,1) ORDER BY codigoestadoperiodo DESC";
    $resultado= $objetobase->conexion->query($query);
    $rowperiodo=$resultado->fetchRow();    
?>
<input type="hidden" name="codigotipousuario" value="<?php echo $codigotipousuario; ?>">
<?php
    $_SESSION["codigoperiodo_autoenfermeria"]="".$rowperiodo["codigoperiodo"];
    $codigoperiodo=$_SESSION["codigoperiodo_autoenfermeria"];        
    $objvalidaautoevaluacion=new ValidaEncuesta($objetobase,$codigoperiodo,$codigoestudiante);    
    
    if($objvalidaautoevaluacion->validaEncuestaCompleta()){             
        $query_esactua = "select * from actualizacionusuario 
        where usuarioid='".$_SESSION['idusuario']."'
        and codigoperiodo='".$_SESSION['codigoperiodo_autoenfermeria']."'
        and tipoactualizacion=3 and estadoactualizacion=1";              
        $esactua = $objetobase->conexion->query($query_esactua);
        $totalRows_esactua = $esactua->numRows();        

        if($totalRows_esactua==""){		            
            $query_actualizaestado = "insert into actualizacionusuario (usuarioid, tipoactualizacion, id_instrumento, codigoperiodo, estadoactualizacion,userid,entrydate)
            values ('".$_SESSION['idusuario']."',3,0,'".$_SESSION['codigoperiodo_autoenfermeria']."',1,'".$_SESSION['idusuario']."',now())";            
            $actualizaestado = $objetobase->conexion->query($query_actualizaestado);
        }
        else{
            $query_actualizaestado = "update  actualizacionusuario set entrydate=now() 
            where usuarioid='".$_SESSION['idusuario']."'
            and codigoperiodo='".$_SESSION['codigoperiodo_autoenfermeria']."'
            and tipoactualizacion=3";            
            $actualizaestado = $objetobase->conexion->query($query_actualizaestado); 		
        }
        ?>
        <script type="text/javascript">
            parent.location.reload();            
        </script>
    
        <?php
        //echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=../encuestahumanidades/encuestaenfermeria.php?codigoestudiante=".$codigoestudiante."&codigotipousuario=".$codigotipousuario;
         
    }
        
    if(isset($_POST["codigomateria"])&&$_POST["codigomateria"]!='') {    
        $objconsultaencuesta=new ConsultaEncuesta($objetobase,$formulario);
        $tabla="respuestaautoevaluacion";
        $objconsultaencuesta->setTablaRespuesta($tabla);
        $_SESSION["codigoestudiante_autoenfermeria"]=$codigoestudiante;
        $_SESSION["codigomateria_autoenfermeria"]=$_POST["codigomateria"];

        $idusuarioencuesta=$codigoestudiante."_".$_POST["codigomateria"]."_".$_SESSION["codigoperiodo_autoenfermeria"];
        $objmostrarencuesta=new MostrarEncuesta($idusuarioencuesta,$objetobase,$formulario,$objconsultaencuesta);

        $datosestudiante=$objetobase->recuperar_datos_tabla("estudiante e","e.codigoestudiante",$codigoestudiante,"","",0);

        $condicion=" now() between e.fechainicioencuesta and e.fechafinalencuesta";

        $condicion.=" and em.idencuesta=e.idencuesta and em.codigomateria='".$_POST["codigomateria"]."'  and e.codigocarrera in (8,1)";
        $datosencuestamateria=$objetobase->recuperar_datos_tabla("encuesta e,encuestamateria em","1",'1'," and ".$condicion,"",0);

        $idencuesta=$datosencuestamateria["idencuesta"];
    }

?>
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
                process("actualizarencuestaenfermeria.php",params);
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
        //consulta la masterias que estas definidas para la evaluacion
        seleccionmateria($codigoestudiante,$objetobase,$formulario,$_SESSION["codigoperiodo_autoenfermeria"]);
        
        if(isset($_POST["codigomateria"])&&$_POST["codigomateria"]!='') {            
            $objmostrarencuesta->setIdEncuesta($idencuesta);
            $objmostrarencuesta->iniciarEncuestaUsuario();
            $objmostrarencuesta->mostrarTitulosEncuesta();
            
            $filaadicional["codigoestudiante"]=$_SESSION["codigoestudiante_autoenfermeria"];
            $filaadicional["codigomateria"]=$_SESSION["codigomateria_autoenfermeria"];
            $filaadicional["codigoperiodo"]=$_SESSION["codigoperiodo_autoenfermeria"];
            
            $mensajeninicial="Califique de 1 a 5 las siguientes preguntas relacionadas a la evaluacion de su asignatura";
            echo "	<form id=\"form1\" name=\"form1\" action=\"\" method=\"post\"  >
		<input type=\"hidden\" name=\"AnularOK\" value=\"\">
		<input type=\"hidden\" name=\"idencuesta\" value=\"".$objmostrarencuesta->idencuesta."\">";

            $objmostrarencuesta->imprimirEncuesta($mensajeninicial);
            $objmostrarencuesta->ingresarTotalPreguntas($tabla,$filaadicional);
            
            $formulario->boton_tipo("hidden", "codigomateria", $_POST["codigomateria"]);
            echo "</form>";
            $mensajeexito="Asignatura Evaluada,\n sus respuestas son utiles para el mejoramiento de nuestra Institución .";
            $mensajefalta="No puede continuar hasta que diligencie toda la encuesta";
            $direccionexito="encuestaenfermeria.php?codigoestudiante=".$codigoestudiante."&codigotipousuario=".$codigotipousuario;
            //$direccionfalta="encuestaenfermeria.php?codigoestudiante=".$codigoestudiante."&codigotipousuario=".$codigotipousuario;
            $direccionfalta="";

            $objmostrarencuesta->guardarEncuesta($mensajeexito, $mensajefalta, $direccionexito, $direccionfalta,$tabla,$filaadicional);

        }
        ?>
        <script type="text/javascript">
            var pathruta='../../../funciones/sala_genericas/ajax/tab/';
            <?php
            $cadena= "var arraypestanas=Array(";
            $con=0;
            if(is_array($objmostrarencuesta->arraytitulospestanas))
                foreach($objmostrarencuesta->arraytitulospestanas as $i=>$row) {

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
