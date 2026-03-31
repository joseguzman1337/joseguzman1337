<?php
session_start();
$rutaado = ("../../../funciones/adodb/");

require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../funciones/sala_genericas/formulariobaseestudiante.php");
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
                    $formulario->dibujar_fila_titulo('FORTALECIMIENTO DE LA PARTICIPACIÓN EN REDES ACADÉMICAS INTERNACIONALES', 'labelresaltado', "2", "align='center'");



                    //$formulario->filatmp["1"]="Egresado";
                    if ($_GET["encuestado"] == "director") {
                        $formulario->dibujar_fila_titulo('Los datos que se solicitan a continuaci&oacute;n sirven para verificar que quienes diligencian la herramienta hagan parte de la comunidad académica. Los resultados se manejarán de manera global y la informaci&oacute;n por usted suministrada será absolutamente CONFIDENCIAL. Para diligenciar, por favor utilice sólo navegadores Internet Explorer y Mozilla. Gracias', 'tdtituloencuestadescripcion', "2", "align='left'", "td");
                        $formulario->filatmp["700"] = "Directivo";
                    } else {
                        $formulario->dibujar_fila_titulo('Los datos que se solicitan a continuaci&oacute;n sirven para verificar que quienes diligencian la herramienta hagan parte de la comunidad académica. Los resultados se manejarán de manera global y la informaci&oacute;n por usted suministrada será absolutamente CONFIDENCIAL. Para diligenciar, por favor utilice sólo navegadores Internet Explorer y Mozilla. Gracias', 'tdtituloencuestadescripcion', "2", "align='left'", "td");
                        $formulario->filatmp["500"] = "Docente";
                        $formulario->filatmp["700"] = "Directivo";
                        //  $formulario->filatmp["501"]="Docentes Educacion continuada";
                        //$formulario->filatmp["800"]="Director Division Departamento";
                        //$formulario->filatmp["400"]="Administrativos";
                        //$formulario->filatmp["610"]="Egresados";
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

                    $titulodocumento = "Número de documento";
                    $campo = "boton_tipo";
                    $parametros = "'text','numerodocumento','" . $_POST['numerodocumento'] . "',''";
                    $formulario->dibujar_campo($campo, $parametros, $titulodocumento, "tdtitulogris", 'numerodocumento', 'requerido');

                    $formulario->filatmp = $objetobase->recuperar_datos_tabla_fila("modalidadacademica f", "codigomodalidadacademica", "nombremodalidadacademica", "");
                    $formulario->filatmp["todos"] = "*Todos*";
                    $formulario->filatmp[""] = "Seleccionar";
                    $campo = 'menu_fila';
                    $parametros = "'codigomodalidadacademica','" . $_POST['codigomodalidadacademica'] . "','onchange=enviarmenu();'";
                    $formulario->dibujar_campo($campo, $parametros, "Modalidad Académica", "tdtitulogris", 'codigomodalidadacademica', '');

                    	$condicion1="c.codigomodalidadacademica='".$_POST['codigomodalidadacademica']."'
				and c.codigocarrera <> 13
				and now() between fechainiciocarrera and fechavencimientocarrera
				order by c.nombrecarrera";
                    $formulario->filatmp = $objetobase->recuperar_datos_tabla_fila("carrera c", "codigocarrera", "nombrecarrera", $condicion1, '', 0);
                    $formulario->filatmp["todos"] = "*Todos*";
                    $formulario->filatmp[""] = "Seleccionar";
                    $campo = 'menu_fila';
                    $parametros = "'codigocarrera','" . $_POST['codigocarrera'] . "','onchange=enviarmenu();'";
                    $formulario->dibujar_campo($campo, $parametros, "Carrera", "tdtitulogris", 'codigocarrera', '');


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
                                if (count($arraynombreegresado) > 0) {
                                    $condicion.=" and (";
                                    for ($i = 0; $i < count($arraynombreegresado); $i++) {
                                        if (strlen($arraynombreegresado[$i]) >= 3) {
                                            $siga = 1;
                                            if ($i == 0)
                                                $condicion.="nombredocente like '%" . $arraynombreegresado[$i] . "%'";
                                            else
                                                $condicion.=" or nombredocente like '%" . $arraynombreegresado[$i] . "%'";
                                        }else {
                                            $siga = 0;
                                        }
                                    }
                                    $condicion.=")";
                                } else {
                                    $siga = 0;
                                }

                                if (!$siga) {
                                    alerta_javascript("Nombre de Docente no corresponde con el documento");
                                    exit();
                                }
                               // $condicion .=" and carrera <> ".$_POST['codigocarrera']."";

                                if ($datosnombresegresado = $objetobase->recuperar_datos_tabla("docente", "numerodocumento", $_POST['numerodocumento'], $condicion, '', 0))
                                    $siga = 1;
                                else {
                                    $siga = 0;
                                }

                                if (!$siga) {
                                    alerta_javascript("Nombre de Docente no corresponde con el documento");
                                    exit();
                                }

                                $condicion = "";
                                if (count($arrayapellidoegresado) > 0) {
                                    $siga = 1;
                                    $condicion = " and (";
                                    for ($i = 0; $i < count($arrayapellidoegresado); $i++) {
                                        if (strlen($arrayapellidoegresado[$i]) >= 3) {
                                            if ($i == 0)
                                                $condicion.="apellidodocente like '%" . $arrayapellidoegresado[$i] . "%'";
                                            else
                                                $condicion.=" or apellidodocente like '%" . $arrayapellidoegresado[$i] . "%'";
                                        }
                                        else {
                                            $siga = 0;
                                        }
                                    }
                                    $condicion.=")";
                                } else {
                                    $siga = 0;
                                }

                                if (!$siga) {
                                    alerta_javascript("Apellido  de Docente no corresponde con el documento");
                                    exit();
                                }
                               // $condicion .="  and carrera1 <> 'ADMINISTRACION'";
                                if ($datosapellidosegresado = $objetobase->recuperar_datos_tabla("docente", "numerodocumento", $_POST['numerodocumento'], $condicion, '', 0))
                                    $siga = 1;
                                else {
                                    alerta_javascript("Apellido de Docente no corresponde con el documento ");
                                    $siga = 0;
                                    exit();
                                }



                                break;

                            case "700":

                                  if (count($arraynombreegresado) > 0) {
                                    $condicion.=" and (";
                                    for ($i = 0; $i < count($arraynombreegresado); $i++) {
                                        if (strlen($arraynombreegresado[$i]) >= 3) {
                                            $siga = 1;
                                            if ($i == 0)
                                                $condicion.="nombresdirectivo like '%" . $arraynombreegresado[$i] . "%'";
                                            else
                                                $condicion.=" or nombresdirectivo like '%" . $arraynombreegresado[$i] . "%'";
                                        }else {
                                            $siga = 0;
                                        }
                                    }
                                    $condicion.=")";
                                } else {
                                    $siga = 0;
                                }

                                if (!$siga) {
                                    alerta_javascript("Nombre de Directivo no corresponde con el documento");
                                    exit();
                                }
                               // $condicion .=" and carrera <> ".$_POST['codigocarrera']."";

                                if ($datosnombresegresado = $objetobase->recuperar_datos_tabla("directivo", "numerodocumentodirectivo", $_POST['numerodocumento'], $condicion, '', 0))
                                    $siga = 1;
                                else {
                                    $siga = 0;
                                }

                                if (!$siga) {
                                    alerta_javascript("Nombre de Directivo no corresponde con el documento");
                                    exit();
                                }

                                $condicion = "";
                                if (count($arrayapellidoegresado) > 0) {
                                    $siga = 1;
                                    $condicion = " and (";
                                    for ($i = 0; $i < count($arrayapellidoegresado); $i++) {
                                        if (strlen($arrayapellidoegresado[$i]) >= 3) {
                                            if ($i == 0)
                                                $condicion.="apellidosdirectivo like '%" . $arrayapellidoegresado[$i] . "%'";
                                            else
                                                $condicion.=" or apellidosdirectivo like '%" . $arrayapellidoegresado[$i] . "%'";
                                        }
                                        else {
                                            $siga = 0;
                                        }
                                    }
                                    $condicion.=")";
                                } else {
                                    $siga = 0;
                                }

                                if (!$siga) {
                                    alerta_javascript("Apellido  de Directivo no corresponde con el documento");
                                    exit();
                                }
                               // $condicion .="  and carrera1 <> 'ADMINISTRACION'";
                                if ($datosapellidosegresado = $objetobase->recuperar_datos_tabla("directivo", "numerodocumentodirectivo", $_POST['numerodocumento'], $condicion, '', 0))
                                    $siga = 1;
                                else {
                                    alerta_javascript("Apellido de Directivo no corresponde con el documento ");
                                    $siga = 0;
                                    exit();
                                }


                                break;

                            default:
                                alerta_javascript("Por favor seleccione Tipo de encuestado");
                                break;
                        }

                        if ($siga) {

                        $tabla="tmpdocentedirectivoencuesta";
        $fila["numerodocumento"] =  $_POST['numerodocumento'];
        $fila["idencuesta"] = '46';
        $fila["codigocarrera"] = $_POST['codigocarrera'];
        $fila["fechaingreso"] = date("Y-m-d H:i:s");
        /*  echo "<pre>";
          print_r($fila);
          echo "<pre>"; */
        $condicionactualiza = " numerodocumento='" . $fila["numerodocumento"] . "'";
        // echo "<pre>";
        $objetobase->insertar_fila_bd($tabla, $fila, 0, $condicionactualiza);


                             echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=encuestainternacionalizacion.php?idencuesta=46&idusuario=" . $_POST["numerodocumento"] . "&codigotipousuario=" . $_POST["tipousuario"] . "'>";
                        }
                         /*   if ($formulario->valida_formulario()) {


                              echo  $query_selencuesta = "SELECT idencuesta
            FROM encuesta
            where now() between fechainicioencuesta and fechafinalencuesta
		and codigotipousuario = '" . $_POST["tipousuario"] . "'";
                                //echo "$query_selperiodo<br>";
                                $selencuesta = $objetobase->conexion->query($query_selencuesta);
                                $totalRows_selencuesta = $selencuesta->numRows();
                                if ($totalRows_selencuesta > 0) {
                                    $query_selrespuestas = "SELECT r.numerodocumento
			FROM encuesta e,encuestapregunta ep,respuestainternacionalizacion r
			where r.numerodocumento = '" . $_POST["numerodocumento"] . "'
			and r.codigoestado like '1%'
			and e.idencuesta= ep.idencuesta
			and r.idencuestapregunta=ep.idencuestapregunta
			and e.codigotipousuario = '" . $_POST["tipousuario"] . "'
			limit 1";
                                    //echo "$query_selperiodo<br>";
                                    $selrespuestas = $objetobase->conexion->query($query_selrespuestas);
                                    $totalRows_selrespuestas = $selrespuestas->numRows();
                                    if ($totalRows_selrespuestas == 0) {
                                        $diligenciarencuesta = true;
                                    } else {
                                        $query_selrespuestas = "SELECT r.numerodocumento
			FROM respuestainternacionalizacion r,encuesta e,encuestapregunta ep,pregunta p
			where r.numerodocumento = '" . $_POST["numerodocumento"] . "'
				and r.codigoestado like '1%'
			and e.idencuesta= ep.idencuesta
			and p.idpregunta=ep.idpregunta
			and r.idencuestapregunta=ep.idencuestapregunta
			and e.codigotipousuario = '" . $_POST["tipousuario"] . "'
			and (r.valorrespuestainternacionalizacion = ''
			or r.valorrespuestainternacionalizacion is  null)
			and p.idtipopregunta <> '201'
			limit 1";
                                        //echo "$query_selperiodo<br>";
                                        $selrespuestas = $objetobase->conexion->query($query_selrespuestas);
                                        $totalRows_selrespuestas = $selrespuestas->numRows();
                                        if ($totalRows_selrespuestas > 0)
                                            $diligenciarencuesta = true;
                                        else
                                            $completoencuesta=true;
                                    }
                                    //exit();
                                    //$row_selencuesta = $selencuesta->fetchRow()
                                }

                                if ($diligenciarencuesta) {
                                    echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=encuestainternacionalizacion.php?idusuario=" . $_POST["numerodocumento"] . "&codigotipousuario=" . $_POST["tipousuario"] . "'>";
                                } else {
                                    if ($completoencuesta) {
                                        if ($_POST["tipousuario"] != "900")
                                            alerta_javascript("Usted ya diligencio toda la encuesta \\n Gracias por su colaboracion, sus respuestas son utiles para el mejoramiento de nuestra Institucion");
                                        else
                                            echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=encuestainternacionalizacion.php?idusuario=" . $_POST["numerodocumento"] . "&codigotipousuario=" . $_POST["tipousuario"] . "'>";
                                    }
                                    else
                                        alerta_javascript("No tiene permiso para  diligenciar la encuesta ");
                                }
                            }
                            else {
                                alerta_javascript("Es necesario diligenciar todos los campos");
                            }*/
                    }
                    ?>

                </table>
            </form></td>
    </tr>
</table>

