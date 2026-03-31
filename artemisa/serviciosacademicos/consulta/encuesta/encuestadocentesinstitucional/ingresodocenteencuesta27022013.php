<?php
session_start();
$rutaado = ("../../../funciones/adodb/");

require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("funcionentradaencuesta.php");
unset($_SESSION['tmptipovotante']);
$fechahoy = date("Y-m-d H:i:s");
$formulario = new formulariobaseestudiante($sala, 'form1', 'post', '', 'true');
$objetobase = new BaseDeDatosGeneral($sala);
?>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
<script type="text/javascript" src="../../../funciones/sala_genericas/funciones_javascript.js"></script>
<style type="text/css">@import url(../../../funciones/calendario_nuevo/calendar-win2k-1.css);body {
        margin-left: 0px;
        margin-top: 0px;
        background-color: #EDF0D5;
    }
</style>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-setup.js"></script>
<script type="text/javascript" src="../../../funciones/clases/formulario/globo.js"></script>
<script type="text/javascript">
    if (document.location.protocol == "https:"){
        var direccion=document.location.href;
        var ssl=(direccion.replace(/https/, "http"));
        document.location.href=ssl;
    }
    function enviar(){
        var formulario=document.getElementById("form1");
        formulario.action="";
        formulario.submit();

    }
    function enviarmenu()
    {

        var formulario=document.getElementById("form1");
        formulario.action="";
        formulario.submit();
    }
</script>
<table width="755" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
        <td bgcolor="#8AB200" valign="center"><img src="../../../../imagenes/noticias_logo.gif" width="755" height="71"></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td><form id="form1" name="form1" action="" method="POST" >
                <input type="hidden" name="AnularOK" value="">
                <table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="750">

                    <?php
                    $formulario->dibujar_fila_titulo('<b>PROCESO DE AUTOEVALUACI&Oacute;N INSTITUCIONAL Y DE PROGRAMAS</b><br>Instrumentos de evaluación', 'labelresaltado', "2", "align='center'");



                    //$formulario->filatmp["1"]="Egresado";
                    if ($_GET["encuestado"] == "director") {
                        $formulario->dibujar_fila_titulo('Los datos que se solicitan a continuaci&oacute;n
                            sirven para verificar que quienes diligencian la herramienta hagan parte de la
                            comunidad acad&eacutemica. Los resultados se manejar&aacute;n de manera global y la
                            informaci&oacute;;n por usted suministrada ser&aacute; absolutamente CONFIDENCIAL.
                            Para diligenciar, por favor utilice s&oacute;lo navegadores Internet Explorer y Mozilla.
                            Gracias', 'tdtituloencuestadescripcion', "2", "align='left'", "td");
                        $formulario->filatmp["700"] = "Directivo";
                    } else {
                        /*$formulario->dibujar_fila_titulo('Este cuestionario tiene como fin obtener informaci&oacute;n
                            actualizada sobre algunos aspectos de la Universidad y de los programas
                            acad&eacutemicos. A continuaci&oacute;n encontrar&aacute; una serie de frases o
                            afirmaciones para que usted responda marcando con una (X) sobre el lugar que
                            m&aacute;s se aproxime o aleje de la respuesta formulada y que usted considere la m&aacute;s adecuada,
                            teniendo en cuenta su opini&oacute;n, conocimiento o experiencia.
                            <br>  Recuerde que no hay respuestas malas o buenas. Gracias por su participaci&oacute;n.', 'tdtituloencuestadescripcion', "2", "align='left'", "td");*/
                        $formulario->dibujar_fila_titulo('<b>Para acceder a la encuesta usted deber&aacute; incluir sus datos
                            de identificaci&oacute;n, esto nos permitir&aacute; corroborar solamente que es miembro de la comunidad universitaria (Docente, Egresado,Estudiante, Administrativo)
                            , pero los datos que  diligencia son enviados a un servidor que codifica
                            la informaci&oacute;n y la arroja de manera global, de tal forma que NO se relacionar&aacute;
                            su nombre con lo que haya respondido.
                            Esto asegura la confidencialidad del diligenciamiento.<br>
                            Una vez envíe la información anterior, se abrirá en el sistema la respectiva encuesta. Durante el diligenciamiento de ésta deberá dar click en el botón seguir (si el sistema se lo pide) hasta que aparezca el botón finalizar.
Cuando haga click en el botón finalizar, habrá terminado la evaluación.</b>', 'tdtituloencuestadescripcion', "2", "align='left'", "td");


                        $formulario->filatmp["500"] = "Docente";
                        //$formulario->filatmp["700"] = "Directivo";
                        //$formulario->filatmp["501"]="Docentes Educacion continuada";
                        //$formulario->filatmp["800"]="Director Division Departamento";
                        //$formulario->filatmp["400"]="Administrativos";
                        $formulario->filatmp["610"] = "Egresados";
                        //$formulario->filatmp["620"]="Estudiantes Postgrado";
                        //$formulario->filatmp["630"]="Educacion Continuada";
                        //$formulario->filatmp["660"]="Graduandos";
                        //$formulario->filatmp["900"]="Padres de Familia";
                        //$formulario->filatmp["501"]="Docentes Educacion continuada";
                        //$formulario->filatmp["502"]="Coordinadores Educacion continuada";
                        //$formulario->filatmp["640"]="Estudiantes En Practica";
                        //$formulario->filatmp["670"]="Estudiantes De Colegio";
                        $formulario->filatmp[""] = "Seleccionar";
                    }

                    $menu = "menu_fila";
                    $parametrosmenu = "'tipousuario','" . $_REQUEST['tipousuario'] . "','onchange=enviar();'";
                    $formulario->dibujar_campo($menu, $parametrosmenu, "Tipo de Encuestado", "tdtitulogris", "tipousuario", 'requerido');


                    $campo = "boton_tipo";
                    $parametros = "'text','nombreegresado','" . $_POST['nombreegresado'] . "',''";
                    $formulario->dibujar_campo($campo, $parametros, "Nombres", "tdtitulogris", 'nombreegresado', 'requerido');

                    $campo = "boton_tipo";
                    $parametros = "'text','apellidoegresado','" . $_POST['apellidoegresado'] . "',''";
                    $formulario->dibujar_campo($campo, $parametros, "Apellidos", "tdtitulogris", 'apellidoegresado', 'requerido');

                    $titulodocumento = "N&uacute;mero de documento";
                    $campo = "boton_tipo";
                    $parametros = "'text','numerodocumento','" . $_POST['numerodocumento'] . "',''";
                    $formulario->dibujar_campo($campo, $parametros, $titulodocumento, "tdtitulogris", 'numerodocumento', 'requerido');

                    /* $formulario->filatmp = $objetobase->recuperar_datos_tabla_fila("modalidadacademica f", "codigomodalidadacademica", "nombremodalidadacademica", "");
                      $formulario->filatmp["todos"] = "*Todos*";
                      $formulario->filatmp[""] = "Seleccionar";
                      $campo = 'menu_fila';
                      $parametros = "'codigomodalidadacademica','" . $_POST['codigomodalidadacademica'] . "','onchange=enviarmenu();'";
                      $formulario->dibujar_campo($campo, $parametros, "Modalidad Acad&eacutemica", "tdtitulogris", 'codigomodalidadacademica', ''); */

                    if ($_REQUEST['tipousuario'] == "500") {
                        $formulario->dibujar_fila_titulo('En caso de que usted sea docente de m&aacute;s de un programa,
                            por favor seleccione aquel en el que tiene un mayor n&uacute;mero de horas
                            laborales asignadas. Solo puede diligenciarse un instrumento por docente.<b>Tenga en cuenta que una vez seleccione un programa e ingrese , no podra diligenciar el instrumento para otro programa </b>  ', 'tdtituloencuestadescripcion', "2", "align='left'", "td");
                       /* $modalidades = "( c.codigomodalidadacademica in ('200','300')) and c.codigocarrera in (71,25,38,53,58,61,62,72,52,57,31,29,15,16,19,20,17,333,66,299,43,54,301,297,32,56,77,64,40,24,35,47)
                            and now() between fechainiciocarrera and fechavencimientocarrera";*/
                            $modalidades = "( c.codigomodalidadacademica in ('200','300')) and c.codigocarrera in (125)
                            and now() between fechainiciocarrera and fechavencimientocarrera";
                    }
                    if ($_REQUEST['tipousuario'] == "610") {
                        /*$formulario->dibujar_fila_titulo('En caso de que usted sea egresado de m&aacute;s de un programa,
                            por favor seleccione aquel que quiera evaluar. Solo puede diligenciarse un instrumento por egresado.<b>Tenga en cuenta que una vez seleccione un programa e ingrese , no podra diligenciar el instrumento para otro programa </b>  ', 'tdtituloencuestadescripcion', "2", "align='left'", "td");*/
                        $formulario->dibujar_fila_titulo('En caso de que usted sea egresado de m&aacute;s de un programa,
                            por favor seleccione aquel o aquellos que quiera evaluar.', 'tdtituloencuestadescripcion', "2", "align='left'", "td");
                        $modalidades = "( c.codigomodalidadacademica in ('200','300')) and c.codigocarrera in (125,93,90)
                            and now() between fechainiciocarrera and fechavencimientocarrera";
                        /*$modalidades = "( c.codigomodalidadacademica in ('200','300')) and c.codigocarrera in (71,25,38,53,58,61,62,72,52,57,31,29,15,16,19,20,17,333,66,299,43,54,301,297,32,56,77,64,40,24,35,47)
                            and now() between fechainiciocarrera and fechavencimientocarrera";*/
                    }
                    if ($_REQUEST['tipousuario'] == "400") {
                        $formulario->dibujar_fila_titulo('<b>Tenga en cuenta que una vez seleccione una dependencia e ingrese , no podra diligenciar el instrumento para otra dependencia </b>  ', 'tdtituloencuestadescripcion', "2", "align='left'", "td");
                        $modalidades = " ( c.codigomodalidadacademica in  ('200')
                            and now() between fechainiciocarrera and fechavencimientocarrera )
and codigocarrera not in (1,2,156,124,119,134,496,484,483,417,492) or  
(c.codigomodalidadacademica like '5%' and codigocarrera not in (1,2,156,124,119,134,496,484,483,417,492)  ) 
or codigocarrera in (3) 
 ";
                    }
                    if ($_REQUEST['tipousuario'] == "700") {
                        $formulario->dibujar_fila_titulo('<b>Tenga en cuenta que una vez seleccione una dependencia e ingrese , no podra diligenciar el instrumento para otra dependencia </b>  ', 'tdtituloencuestadescripcion', "2", "align='left'", "td");
                        $modalidades = " ( c.codigomodalidadacademica in ('200')) and now() between fechainiciocarrera and fechavencimientocarrera";
                    }
if (isset($_REQUEST['tipousuario']) && trim($_REQUEST['tipousuario'])!='' && trim($_REQUEST['tipousuario'])!='620') {
                    $condicion1 = " $modalidades
				and (c.codigocarrera not in (7,560,554))
				
				order by c.nombrecarrera";
                    $formulario->filatmp = $objetobase->recuperar_datos_tabla_fila("carrera c", "codigocarrera", "nombrecarrera", $condicion1, '', 0);
                    // $formulario->filatmp["todos"] = "*Todos*";
                      if ($_REQUEST['tipousuario'] == "400") {
                    $formulario->filatmp["417"] = "FACULTAD DE CIENCIAS";
                    $formulario->filatmp["561"] = "CENTRO DE DISEÑO";
                    $escojer="Dependencia a la que pertenece";
                      }
                      else{
                          $escojer="Programa al que pertenece";
                      }
                    $formulario->filatmp[""] = "Seleccionar";

                    $campo = 'menu_fila';
                    $parametros = "'codigocarrera','" . $_POST['codigocarrera'] . "','onchange=enviarmenu();'";
                    $formulario->dibujar_campo($campo, $parametros, $escojer, "tdtitulogris", 'codigocarrera', 'requerido');
}

                    $conboton = 0;
                    $parametrobotonenviar[$conboton] = "'submit','Enviar','Enviar',''";
                    $boton[$conboton] = 'boton_tipo';
                    $conboton++;
                    $formulario->dibujar_campos($boton, $parametrobotonenviar, "", "tdtitulogris", 'Enviar', '', 0);


                    $mensaje = "En caso de que no pueda ingresar por favor envie un correo con una cuenta institucional con datos personales (nombre completo , numero de documento) a la direccion <a href='mailto:autoevaluacioninstitucional@unbosque.edu.co'>autoevaluacioninstitucional@unbosque.edu.co</a>";

//$formulario->dibujar_fila_titulo($mensaje,'tdtituloencuestadescripcion',"2","align='left'","td");


                    if (isset($_REQUEST['Enviar'])) {

                        $_POST["numerodocumento"] = str_replace(",", "", trim($_POST["numerodocumento"]));
                        $_POST["numerodocumento"] = str_replace(".", "", $_POST["numerodocumento"]);

                        $arraynombreegresado = explode(" ", trim($_POST['nombreegresado']));
                        $arrayapellidoegresado = explode(" ", trim($_POST['apellidoegresado']));

                        $arraycodigomodalidadacademica = explode(" ", trim($_POST['codigomodalidadacademica']));
                        $arraycarrera = explode(" ", trim($_POST['codigocarrera']));


                        $siga = 0;

//echo "<BR>TIPOUSUARIO=".$_POST["tipousuario"];
                        switch ($_POST["tipousuario"]) {

                            case "500":

                                $siga = validaEntradaEncuesta(
                                                $_POST['nombreegresado'],
                                                $_POST['apellidoegresado'],
                                                "td.nombredocente",
                                                "td.apellidodocente",
                                                "materia m,docente d,grupo g,tmpdocentescompletopersonal td,horario h",
                                                "td.numerodocumento",
                                                $_POST["numerodocumento"],
                                                $objetobase,
                                                "and m.codigomateria=g.codigomateria and g.idgrupo=h.idgrupo
and g.numerodocumento=d.numerodocumento 
and m.codigocarrera=125 
and td.numerodocumento=g.numerodocumento 
and td.numerodocumento=d.numerodocumento
group by td.numerodocumento");
                                break;
                            case "610":

                              /*  $siga = validaEntradaEncuesta(
                                                $_POST['nombreegresado'],
                                                $_POST['apellidoegresado'],
                                                "nombresegresado",
                                                "apellidosegresado",
                                                "egresado",
                                                "numerodocumento",
                                                $_POST["numerodocumento"],
                                                $objetobase,
                                                "");*/
                                
                                   $siga = validaEntradaEncuesta(
                                                $_POST['nombreegresado'],
                                                $_POST['apellidoegresado'],
                                                "nombresestudiantegeneral",
                                                "apellidosestudiantegeneral",
                                                "estudiante e, estudiantegeneral eg",
                                                "eg.numerodocumento",
                                                $_POST["numerodocumento"],
                                                $objetobase,
                                                " and eg.idestudiantegeneral=e.idestudiantegeneral and e.codigosituacioncarreraestudiante in ('104','400')");
                                break;
                            case "400":

                                $siga = validaEntradaEncuesta(
                                                $_POST['nombreegresado'],
                                                $_POST['apellidoegresado'],
                                                "nombrecompleto",
                                                "nombrecompleto",
                                                "tmplistadopersonal",
                                                "documento",
                                                $_POST["numerodocumento"],
                                                $objetobase,
                                                "");
                                break;
                            case "620":
                                $siga = validaEntradaEncuesta(
                                                $_POST['nombreegresado'],
                                                $_POST['apellidoegresado'],
                                                "nombresestudiantegeneral",
                                                "apellidosestudiantegeneral",
                                                "estudiante e, carrera c, estudiantegeneral eg",
                                                "eg.numerodocumento",
                                                $_POST["numerodocumento"],
                                                $objetobase,
                                                "and eg.idestudiantegeneral=e.idestudiantegeneral AND c.codigocarrera=e.codigocarrera and c.codigomodalidadacademica in ('300') and codigocarrera in(125,90,93)");
                                break;
                            case "700":

                                $siga = validaEntradaEncuesta(
                                                $_POST['nombreegresado'],
                                                $_POST['apellidoegresado'],
                                                "nombresdirectivo",
                                                "apellidosdirectivo",
                                                "directivo",
                                                "numerodocumentodirectivo",
                                                $_POST["numerodocumento"],
                                                $objetobase,
                                                "");
                                break;
                            default:
                                alerta_javascript("Por favor seleccione Tipo de encuestado");
                                break;
                        }

                        if ($siga) {
                            if ($formulario->valida_formulario()) {
                                switch ($_POST["tipousuario"]) {

                                    case "500":
                                        $tabla = "respuestainstitucionaldocente20122";
                                        $condicion = " and codigoperiodo='20122'";
                                        $datosrespuestadocente = $objetobase->recuperar_datos_tabla($tabla, "numerodocumento", $_POST["numerodocumento"], $condicion, "", 1);

                                        if (!isset($datosrespuestadocente["codigocarrera"])) {
                                            echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=../encuestadocentesinstitucional20122/encuestadocente.php?idencuesta=75&codigocarrera=" . $_POST['codigocarrera'] . "&idusuario=" . $_POST["numerodocumento"] . "'>";
                                        } else {
                                            if ($datosrespuestadocente["codigocarrera"] != $_POST["codigocarrera"]) {
                                                $condicion = "";
                                                $datoscarrera = $objetobase->recuperar_datos_tabla("carrera", "codigocarrera", $datosrespuestadocente["codigocarrera"], $condicion);

                                                alerta_javascript("Es necesario que seleccione el programa " . $datoscarrera["nombrecarrera"] . " que escogio en un comienzo");
                                            } else {

                                                echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=../encuestadocentesinstitucional20122/encuestadocente.php?idencuesta=75&codigocarrera=" . $_POST['codigocarrera'] . "&idusuario=" . $_POST["numerodocumento"] . "'>";
                                            }
                                        }
                                        break;
                                    case "610":
                                       
					$datosrespuestadocente = $objetobase->recuperar_datos_tabla("estudiante join estudiantegeneral using(idestudiantegeneral)", "numerodocumento", $_POST["numerodocumento"], " and codigocarrera=".$_POST['codigocarrera'], "", 0);

                                        if (isset($datosrespuestadocente["codigocarrera"])) {
                                        	echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=../encuestaegresadosposgrado20122/encuestaegresado.php?idencuesta=76&codigocarrera=" . $_POST['codigocarrera'] . "&idusuario=" . $_POST["numerodocumento"].".".$_POST['codigocarrera'] . "'>";
                                           // echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=encuestadocente.php?idencuesta=49&codigocarrera=" . $_POST['codigocarrera'] . "&idusuario=" . $_POST["numerodocumento"] . "'>";
                                        } else {
                                        	alerta_javascript("Por favor seleccione un programa que usted haya cursado.");
                                        }
                                        break;
                                    case "400":


                                        $tabla = "respuestainstitucionaladministrativo";
                                        $condicion = " and codigoperiodo='20111'";
                                        $datosrespuestadocente = $objetobase->recuperar_datos_tabla($tabla, "numerodocumento", $_POST["numerodocumento"], $condicion, "", 0);

                                        if (!isset($datosrespuestadocente["codigocarrera"])) {
                                             echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=../encuestaadministrativoinstitucional/encuestaadministrativo.php?idencuesta=53&codigocarrera=" . $_POST['codigocarrera'] . "&idusuario=" . $_POST["numerodocumento"] . "'>";
                                           // echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=encuestadocente.php?idencuesta=49&codigocarrera=" . $_POST['codigocarrera'] . "&idusuario=" . $_POST["numerodocumento"] . "'>";
                                        } else {
                                            if ($datosrespuestadocente["codigocarrera"] != $_POST["codigocarrera"]) {
                                                $condicion = "";
                                                $datoscarrera = $objetobase->recuperar_datos_tabla("carrera", "codigocarrera", $datosrespuestadocente["codigocarrera"], $condicion);

                                                alerta_javascript("Es necesario que seleccione el programa o dependencia " . $datoscarrera["nombrecarrera"] . " que escogio en un comienzo");
                                            } else {
                                             echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=../encuestaadministrativoinstitucional/encuestaadministrativo.php?idencuesta=53&codigocarrera=" . $_POST['codigocarrera'] . "&idusuario=" . $_POST["numerodocumento"] . "'>";
                                             //   echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=encuestadocente.php?idencuesta=49&codigocarrera=" . $_POST['codigocarrera'] . "&idusuario=" . $_POST["numerodocumento"] . "'>";
                                            }
                                        }

                                    break;
                                    case "620":
					$condicion ="	and eg.idestudiantegeneral=e.idestudiantegeneral 
							AND c.codigocarrera=e.codigocarrera 
							and c.codigomodalidadacademica in ('300')";
					if($datosnombrespostgrado=$objetobase->recuperar_datos_tabla("estudiante e, carrera c, estudiantegeneral eg","eg.numerodocumento",$_REQUEST['numerodocumento'],$condicion,'',0)) {
					    $codigocarrera=$datosnombrespostgrado['codigocarrera'];
					    $idusuario=$datosnombrespostgrado['idestudiantegeneral'];
					    echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=../encuestaestudiantesposgrado20122/encuestaestudiantespostgrado.php?idencuesta=68&idusuario=".$idusuario."&codigotipousuario=".$_REQUEST["tipousuario"]."&codigocarrera=$codigocarrera&aux_redireccion=true'>";
					} else {
                                                alerta_javascript("No es posible habilitarlo para diligenciar la encuesta.");
					}
                                    break;
                                    case "700":
                                        $tabla = "respuestadirectivos";
                                        $condicion = " and codigoperiodo='20112'";
                                        $datosrespuestadocente = $objetobase->recuperar_datos_tabla($tabla, "numerodocumento", $_POST["numerodocumento"], $condicion, "", 0);

                                        if (!isset($datosrespuestadocente["codigocarrera"])) {
                                            echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=../encuestadirectivos/encuestadirectivos.php?idencuesta=58&codigocarrera=" . $_POST['codigocarrera'] . "&idusuario=" . $_POST["numerodocumento"] . "'>";
                                        } else {
                                            if ($datosrespuestadocente["codigocarrera"] != $_POST["codigocarrera"]) {
                                                $condicion = "";
                                                $datoscarrera = $objetobase->recuperar_datos_tabla("carrera", "codigocarrera", $datosrespuestadocente["codigocarrera"], $condicion);

                                                alerta_javascript("Es necesario que seleccione el programa " . $datoscarrera["nombrecarrera"] . " que escogio en un comienzo");
                                            } else {
                                            	echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=../encuestadirectivos/encuestadirectivos.php?idencuesta=58&codigocarrera=" . $_POST['codigocarrera'] . "&idusuario=" . $_POST["numerodocumento"] . "'>";
                                            }
                                        }
                                        break;
                                }
                            }
                        }
                    }
                    ?>

                </table>
            </form></td>
    </tr>
</table>

