<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
//session_start();
$rol = $_SESSION['rol'];
$rutaado = ("../../../../funciones/adodb/");
require_once("../../../../funciones/clases/debug/SADebug.php");
require_once("../../../../Connections/salaado-pear.php");
require_once("../../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../../funciones/phpmailer/class.phpmailer.php");
require_once("../../../../funciones/validaciones/validaciongenerica.php");
require_once("../../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
?>
<link rel="stylesheet" type="text/css" href="../../../../estilos/sala.css">
<style type="text/css">@import url(../../../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../../../funciones/calendario_nuevo/calendar-setup.js"></script>
<script type="text/javascript" src="../../../../funciones/clases/formulario/globo.js"></script>
<script LANGUAGE="JavaScript">

    function enviarmenu()
    {
        form1.action="";
        form1.submit();
    }

    function regresarGET()
    {
        document.location.href="<?php echo '../../../prematricula/matriculaautomaticaordenmatricula.php'; ?>";
    }


</script>

<?php
$fechahoy = date("Y-m-d H:i:s");
$formulario = new formulariobaseestudiante($sala, 'form1', 'post', '', 'true');
$objetobase = new BaseDeDatosGeneral($sala);

$usuario = $formulario->datos_usuario();
$ip = $formulario->GetIP();
?>
<form name="form1" action="formulariohorarioadmisionestudiante.php?codigoestudiante=<?php echo $_GET['codigoestudiante'] ?>" method="POST" >
    <input type="hidden" name="AnularOK" value="">
    <table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="750">
        <?php
        unset($datosplantillaestudiante);
        if (isset($_GET['codigoestudiante']) &&
                isset($_REQUEST["iddetalleadmision"]) &&
                trim($_REQUEST["iddetalleadmision"]) != '') {
            $datosplantillaestudiante = $objetobase->recuperar_datos_tabla("estudianteadmision", "codigoestudiante", $_GET['codigoestudiante'], '', '', 0);
            $detalleadmision = $datosplantillaestudiante['iddetalleadmision'];
            $detallesitioadmision = $datosplantillaestudiante['iddetallesitioadmision'];
            $fechainiciohorario = formato_fecha_defecto($datosplantillaestudiante['fechainiciohorariodetallesitioadmision']);
            $fechafinalhorario = formato_fecha_defecto($datosplantillaestudiante['fechafinalhorariodetallesitioadmision']);
            $horainicial = $datosplantillaestudiante['horainicialhorariodetallesitioadmision'];
            $horafinal = $datosplantillaestudiante['horafinalhorariodetallesitioadmision'];
            $fechadetalleestudiante = $datosplantillaestudiante['fechadetalleestudianteadmision'];

            $codigoestadoestudianteadmision = $datosplantillaestudiante['codigoestadoestudianteadmision'];
            $observacionesdetalle = $datosplantillaestudiante['observacionesdetalleestudianteadmision'];

            $query_Horario = "SELECT * FROM detalleestudianteadmision d, estudianteadmision ea,
horariodetallesitioadmision hds, estadoestudianteadmision eea,
detalleadmision da, tipodetalleadmision tda
where ea.idestudianteadmision=d.idestudianteadmision
and hds.idhorariodetallesitioadmision=d.idhorariodetallesitioadmision
and tda.codigotipodetalleadmision=da.codigotipodetalleadmision
and eea.codigoestadoestudianteadmision=d.codigoestadoestudianteadmision
and d.codigoestado like '1%' and da.codigoestado like '1%' and d.iddetalleadmision='" . $_REQUEST["iddetalleadmision"] . "' and ea.codigoestudiante='" . $_GET["codigoestudiante"] . "'  group by d.iddetalleestudianteadmision order by da.iddetalleadmision ";
            $Horario = $objetobase->conexion->query($query_Horario);
            $totalRows_Horario = $Horario->RecordCount();
            $row_Horario = $Horario->FetchRow();

            if ($totalRows_Horario > 0) {

                $codigoestadoestudianteadmision = $row_Horario['codigoestadoestudianteadmision'];
                $detalleadmision = $row_Horario['nombretipodetalleadmision'];
                $iddetallesitioadmision = $row_Horario['iddetallesitioadmision'];
                $fechainiciohorario = formato_fecha_defecto($row_Horario ['fechainiciohorariodetallesitioadmision']);
                $fechafinalhorario = formato_fecha_defecto($row_Horario['fechafinalhorariodetallesitioadmision']);
                $horainicial = $row_Horario['horainicialhorariodetallesitioadmision'];
                $horafinal = $row_Horario['horafinalhorariodetallesitioadmision'];
                $observacionesdetalle = $row_Horario['observacionesdetalleestudianteadmision'];
            } else {
                
            }
        }


        if (isset($_REQUEST['iddetalleadmision']) &&
                trim($_REQUEST['iddetalleadmision']) != '') {

            $detalleadmision = $_REQUEST['iddetalleadmision'];
            // $detallesitioadmision = $_REQUEST['iddetallesitioadmision'];
            //  $codigoestadoestudianteadmision = $_REQUEST['codigoestadoestudianteadmision'];
        }

        if (isset($_REQUEST['iddetallesitioadmision']) &&
                trim($_REQUEST['iddetallesitioadmision']) != '') {

            $detallesitioadmision = $_REQUEST['iddetallesitioadmision'];
            // $detallesitioadmision = $_REQUEST['iddetallesitioadmision'];
            //  $codigoestadoestudianteadmision = $_REQUEST['codigoestadoestudianteadmision'];
        }





        $conboton = 0;
        $formulario->dibujar_fila_titulo('HORARIO ADMISION ESTUDIANTE', 'labelresaltado');


        unset($formulario->filatmp);
        $formulario->filatmp = $objetobase->recuperar_datos_tabla_fila("periodo", "codigoperiodo", "codigoperiodo", "codigoperiodo=codigoperiodo order by codigoperiodo desc", '', 0);
        $codigoperiodo = $_SESSION['codigoperiodosesion'];
        if (isset($_POST['codigoperiodo']))
            $codigoperiodo = $_POST['codigoperiodo'];
        if (isset($_GET['codigoperiodo']))
            $codigoperiodo = $_GET['codigoperiodo'];
        $campo = 'menu_fila';
        $parametros = "'codigoperiodo','" . $codigoperiodo . "','onchange=enviarmenu();'";
        $formulario->dibujar_campo($campo, $parametros, "Periodo", "tdtitulogris", 'codigoperiodo', '');


        $datosestudiante = $objetobase->recuperar_datos_tabla("estudiante", "codigoestudiante", $_GET["codigoestudiante"], "", "", 0);
        $condicion1 = "a.codigocarrera= '" . $datosestudiante['codigocarrera'] . "' and a.idadmision=da.idadmision and cp.codigocarrera=a.codigocarrera
and cp.codigoperiodo=p.codigoperiodo  and sp.idsubperiodo=a.idsubperiodo
and sp.idcarreraperiodo=cp.idcarreraperiodo and cp.codigocarrera=a.codigocarrera and p.codigoperiodo='" . $codigoperiodo . "' 
and td.codigotipodetalleadmision=da.codigotipodetalleadmision and da.codigoestado like '1%' and a.codigoestado like '1%' group by td.nombretipodetalleadmision order by td.nombretipodetalleadmision";
        $formulario->filatmp = $objetobase->recuperar_datos_tabla_fila("detalleadmision da, admision a, carreraperiodo cp, periodo p, subperiodo sp,tipodetalleadmision td", "da.iddetalleadmision", "td.nombretipodetalleadmision", $condicion1, "", 0);
        $formulario->filatmp[""] = "Seleccionar";
        $menu = "menu_fila";
        $parametrosmenu2 = "'iddetalleadmision','" . $detalleadmision . "','onchange=enviarmenu();'";
        $formulario->dibujar_campo($menu, $parametrosmenu2, "Prueba Admision", "tdtitulogris", "iddetalleadmision", 'requerido');

        if (isset($_REQUEST['iddetalleadmision']) &&
                trim($_REQUEST['iddetalleadmision']) != '') {

            $condicion = "";
            $formulario->filatmp = $objetobase->recuperar_datos_tabla_fila("estadoestudianteadmision", "codigoestadoestudianteadmision", "nombreestadoestudianteadmision", $condicion, "", 0);
            $formulario->filatmp[""] = "Seleccionar";
            $menu = "menu_fila";
            $parametrosmenu1 = "'codigoestadoestudianteadmision','" . $codigoestadoestudianteadmision . "',''";
            $formulario->dibujar_campo($menu, $parametrosmenu1, "Estado Estudiante", "tdtitulogris", "codigoestadoestudianteadmision", 'requerido');




            $condicion2 = "a.idadmision=da.idadmision and cp.codigocarrera=a.codigocarrera
 and sp.idsubperiodo=a.idsubperiodo and sp.idcarreraperiodo=cp.idcarreraperiodo and cp.codigocarrera=" . $datosestudiante['codigocarrera'] . " and p.codigoperiodo ='" . $codigoperiodo . "'
and da.iddetalleadmision=ds.iddetalleadmision and s.codigosalon=ds.codigosalon and da.iddetalleadmision='" . $_REQUEST['iddetalleadmision'] . "'
and td.codigotipodetalleadmision=da.codigotipodetalleadmision and da.codigoestado like '1%' and a.codigoestado like '1%' group by s.codigosalon order by s.nombresalon";
            $formulario->filatmp = $objetobase->recuperar_datos_tabla_fila("detalleadmision da, admision a, carreraperiodo cp, periodo p, subperiodo sp,
tipodetalleadmision td, detallesitioadmision ds, salon s", "ds.iddetallesitioadmision", "s.nombresalon", $condicion2, "", 0);
            $formulario->filatmp[""] = "Seleccionar";
            $menu = "menu_fila";
            $parametrosmenu3 = "'iddetallesitioadmision','" . $iddetallesitioadmision . "',''";
            $formulario->dibujar_campo($menu, $parametrosmenu3, "Salón", "tdtitulogris", "iddetallesitioadmision", 'requerido');
            $campo = "campo_fecha";
            $parametros = "'text','fechainiciohorariodetallesitioadmision','" . $fechainiciohorario . "','onKeyUp = \"this.value=formateafecha(this.value);\"'";
            $formulario->dibujar_campo($campo, $parametros, "Fecha Inicio Prueba", "tdtitulogris", 'fechainiciohorariodetallesitioadmision', 'requerido');
            $campo = "campo_fecha";
            $parametros = "'text','fechafinalhorariodetallesitioadmision','" . $fechafinalhorario . "','onKeyUp = \"this.value=formateafecha(this.value);\"'";
            $formulario->dibujar_campo($campo, $parametros, "Fecha Final Prueba", "tdtitulogris", 'fechafinalhorariodetallesitioadmision', 'requerido');
            $campo = "boton_tipo";
            $parametros = "'text','horainicialhorariodetallesitioadmision','" . $horainicial . "','maxlength=\"15\"'";
            $formulario->dibujar_campo($campo, $parametros, "Hora Inicio Prueba", "tdtitulogris", 'horainicialhorariodetallesitioadmision', 'requerido');
            $campo = "boton_tipo";
            $parametros = "'text','horafinalhorariodetallesitioadmision','" . $horafinal . "','maxlength=\"15\"'";
            $formulario->dibujar_campo($campo, $parametros, "Hora Final Prueba", "tdtitulogris", 'horafinalhorariodetallesitioadmision', 'requerido');
            $campo = "boton_tipo";
            $parametros = "'text','observacionesdetalleestudianteadmision','" . $observacionesdetalle . "','maxlength=\"30\"'";
            $formulario->dibujar_campo($campo, $parametros, "Observacion", "tdtitulogris", 'observacionesdetalleestudianteadmision', 'requerido');






            if (isset($_GET['codigoestudiante'])) {

                $condicion1 = " and a.codigocarrera= '" . $datosestudiante['codigocarrera'] . "' and a.idadmision=da.idadmision and cp.codigocarrera=a.codigocarrera
and cp.codigoperiodo=p.codigoperiodo  and sp.idsubperiodo=a.idsubperiodo
and sp.idcarreraperiodo=cp.idcarreraperiodo and cp.codigocarrera=a.codigocarrera and p.codigoperiodo='" . $codigoperiodo . "' 
and td.codigotipodetalleadmision=da.codigotipodetalleadmision and da.codigoestado like '1%' and a.codigoestado like '1%' group by td.nombretipodetalleadmision order by td.nombretipodetalleadmision";
                $datosadmision = $objetobase->recuperar_datos_tabla("detalleadmision da, admision a, carreraperiodo cp, periodo p, subperiodo sp,tipodetalleadmision td", "p.codigoperiodo", $codigoperiodo, $condicion1, "", 0);
                $condicion1 = " and ea.idadmision='" . $datosadmision['idadmision'] . " '";

                if ($datosestudianteadmision = $objetobase->recuperar_datos_tabla("estudianteadmision ea", "ea.codigoestudiante", $datosestudiante["codigoestudiante"], $condicion1, "", 0)) {
                    $parametrobotonenviar[$conboton] = "'submit','Enviar','Enviar'";
                    $boton[$conboton] = 'boton_tipo';
                    $formulario->boton_tipo('hidden', 'codigoestudiante', $_GET['codigoestudiante']);
                    $conboton++;

                    $parametrobotonenviar[$conboton] = "'submit','Anular','Anular'";
                    $boton[$conboton] = 'boton_tipo';
                    $formulario->boton_tipo('hidden', 'codigoestudiante', $_GET['codigoestudiante']);
                    $conboton++;
                } else {



                    $parametrobotonenviar[$conboton] = "'submit','Enviar','Enviar'";
                    $boton[$conboton] = 'boton_tipo';
                    $formulario->boton_tipo('hidden', 'codigoestudiante', $_GET['codigoestudiante']);
                    $conboton++;
                }
            } else {
                $parametrobotonenviar[$conboton] = "'submit','Enviar','Enviar'";
                $boton[$conboton] = 'boton_tipo';
                $conboton++;
            }


            $parametrobotonenviar[$conboton] = "'button','Regresar','Regresar','onclick=\'regresarGET();\''";
            $boton[$conboton] = 'boton_tipo';
            $formulario->dibujar_campos($boton, $parametrobotonenviar, "", "tdtitulogris", 'Enviar', '', 0);
        }
        /* echo "<pre>";
          print_r($_GET['codigoestudiante']);
          echo "</pre>"; */





        if (isset($_REQUEST['Enviar'])) {
            if ($formulario->valida_formulario()) {


                $condicion1 = " and eci.idinscripcion=i.idinscripcion
and eci.idestudiantegeneral='" . $datosestudiante["idestudiantegeneral"] . "'
and eci.codigocarrera='" . $datosestudiante["codigocarrera"] . "'";
                $datosinscripcion = $objetobase->recuperar_datos_tabla("inscripcion i, estudiantecarrerainscripcion eci", "i.codigoperiodo", $codigoperiodo, $condicion1, "", 0);

                $tabla = "estudianteadmision";
                $fila["idadmision"] = $datosadmision["idadmision"];
                $fila["fechaestudianteadmision"] = date("Y-m-d");
                $fila["codigoestudiante"] = $datosestudiante["codigoestudiante"];
                $fila["idinscripcion"] = $datosinscripcion['idinscripcion'];
                $fila["codigoestado"] = '100';
                $fila["codigoestadoestudianteadmision"] = $_POST['codigoestadoestudianteadmision'];

                $condicionactualiza = " codigoestudiante='" . $fila["codigoestudiante"] . "'" .
                        " and idadmision='" . $fila["idadmision"] . "'";
                //     echo "<pre>";
                $objetobase->insertar_fila_bd($tabla, $fila, 0, $condicionactualiza);
                //   echo "</pre>";
                unset($fila);

                $tabla = "horariodetallesitioadmision";
                $fila['iddetallesitioadmision'] = $_POST['iddetallesitioadmision'];
                $fila['fechainiciohorariodetallesitioadmision'] = formato_fecha_mysql($_POST ['fechainiciohorariodetallesitioadmision']);
                $fila['fechafinalhorariodetallesitioadmision'] = formato_fecha_mysql($_POST['fechafinalhorariodetallesitioadmision']);
                $fila['horainicialhorariodetallesitioadmision'] = $_POST['horainicialhorariodetallesitioadmision'];
                $fila['horafinalhorariodetallesitioadmision'] = $_POST['horafinalhorariodetallesitioadmision'];
                $fila['intervalotiempohorariodetallesitioadmision'] = '0';
                $fila['codigoestado'] = '100';
                $fila['codigotipogeneracionhorariodetallesitioadmision'] = '200';


                $condicionactualiza = " iddetallesitioadmision='" . $fila["iddetallesitioadmision"] . "' " .
                        " and fechainiciohorariodetallesitioadmision='" . $fila["fechainiciohorariodetallesitioadmision"] . "'
                    " . " and horainicialhorariodetallesitioadmision='" . $fila["horainicialhorariodetallesitioadmision"] . "'";
                $objetobase->insertar_fila_bd($tabla, $fila, 0, $condicionactualiza);

            //    echo "if (".trim($fila["fechainiciohorariodetallesitioadmision"])." == '--//' ";
                
                if (trim($fila["fechainiciohorariodetallesitioadmision"]) == "--//" ||
                        trim($fila["fechainiciohorariodetallesitioadmision"]) == '') {
                    $fila["fechainiciohorariodetallesitioadmision"] = "0000-00-00";
                }
                if (trim($fila["horainicialhorariodetallesitioadmision"]) == "--//" ||
                        trim($fila["horainicialhorariodetallesitioadmision"]) == '') {
                    $fila["horainicialhorariodetallesitioadmision"] = "00:00:00";
                }
                
               $query_validacion1 = "SELECT idhorariodetallesitioadmision FROM horariodetallesitioadmision WHERE iddetallesitioadmision='" . $fila["iddetallesitioadmision"] . "' and fechainiciohorariodetallesitioadmision='" . $fila["fechainiciohorariodetallesitioadmision"] . "'
                     and horainicialhorariodetallesitioadmision='" . $fila["horainicialhorariodetallesitioadmision"] . "'";
                $validacion1 = $objetobase->conexion->query($query_validacion1);
                $totalRows_validacion1 = $validacion1->RecordCount();
                $row_validacion1 = $validacion1->FetchRow();

                $query_validacion2 = "select td.nombretipodetalleadmision, ea.idestudianteadmision, da.iddetalleadmision
	 from detalleadmision da, admision a, carreraperiodo cp, periodo p, subperiodo
	 sp,tipodetalleadmision td, estudiante e, estudianteadmision ea
	where a.idadmision=da.idadmision
	and a.idadmision=ea.idadmision  and e.codigoestudiante=ea.codigoestudiante
        AND ea.codigoestudiante ='" . $datosestudiante["codigoestudiante"] . "'
	and cp.codigocarrera=a.codigocarrera and cp.codigoperiodo=p.codigoperiodo
	and cp.codigoperiodo='" . $codigoperiodo . "' and sp.idsubperiodo=a.idsubperiodo
	and sp.idcarreraperiodo=cp.idcarreraperiodo and cp.codigocarrera=e.codigocarrera
        and da.iddetalleadmision='" . $_POST['iddetalleadmision'] . "'
	and p.codigoperiodo ='" . $codigoperiodo . "' and td.codigotipodetalleadmision=da.codigotipodetalleadmision
	and da.codigoestado like '1%' and a.codigoestado like '1%' group by td.nombretipodetalleadmision order by td.nombretipodetalleadmision";
                $validacion2 = $objetobase->conexion->query($query_validacion2);
                $totalRows_validacion2 = $validacion2->RecordCount();
                $row_validacion2 = $validacion2->FetchRow();

                $tabla2 = "detalleestudianteadmision";
                $fila1['fechadetalleestudianteadmision'] = date("Y-m-d");
                $fila1['idestudianteadmision'] = $row_validacion2['idestudianteadmision'];
                $fila1['iddetalleadmision'] = $_POST['iddetalleadmision'];
                $fila1['resultadodetalleestudianteadmision'] = '0';
                $fila1['idhorariodetallesitioadmision'] = $row_validacion1['idhorariodetallesitioadmision'];
                $fila1['codigoestado'] = '100';
                $fila1['codigoestadoestudianteadmision'] = $_POST['codigoestadoestudianteadmision'];
                $fila1['observacionesdetalleestudianteadmision'] = $_POST['observacionesdetalleestudianteadmision'];

                $condicionactualiza1 = " idestudianteadmision='" . $row_validacion2['idestudianteadmision'] . "'
          and iddetalleadmision='" . $fila1['iddetalleadmision'] . "'";
//ECHO "<PRE>";
                $objetobase->insertar_fila_bd($tabla2, $fila1, 0, $condicionactualiza1);
                // ECHO "</PRE>";
                // exit();
            }
        }
        if (isset($_REQUEST['Modificar'])) {

            if ($formulario->valida_formulario()) {

                $query_actualizarhorario = "SELECT *
 FROM horariodetallesitioadmision hsd,detalleestudianteadmision d
WHERE hsd.idhorariodetallesitioadmision=d.idhorariodetallesitioadmision
and hsd.codigoestado like '1%' and d.codigoestado like '1%'
and d.iddetalleestudianteadmision='" . $row_Horario['iddetalleestudianteadmision'] . "'";

                $actualizarhorario = $objetobase->conexion->Execute($query_actualizarhorario);
                $totalRows_actualizarhorario = $actualizarhorario->RecordCount();
                $actualizarhorario = $actualizarhorario->FetchRow();

                $tabla2 = "horariodetallesitioadmision";
                $nombreidtabla = "idhorariodetallesitioadmision";
                $idtabla = $actualizarhorario['idhorariodetallesitioadmision'];
                $fila2['iddetallesitioadmision'] = $_POST['iddetallesitioadmision'];
                $fila2['fechainiciohorariodetallesitioadmision'] = formato_fecha_mysql($_POST ['fechainiciohorariodetallesitioadmision']);
                $fila2['fechafinalhorariodetallesitioadmision'] = formato_fecha_mysql($_POST['fechafinalhorariodetallesitioadmision']);
                $fila2['horainicialhorariodetallesitioadmision'] = $_POST['horainicialhorariodetallesitioadmision'];
                $fila2['horafinalhorariodetallesitioadmision'] = $_POST['horafinalhorariodetallesitioadmision'];
                $fila2['intervalotiempohorariodetallesitioadmision'] = '0';
                $fila2['codigoestado'] = '100';
                $fila2['codigotipogeneracionhorariodetallesitioadmision'] = '200';
                $objetobase->actualizar_fila_bd($tabla2, $fila2, $nombreidtabla, $idtabla, "", 0);

                //echo "<br><br>";

                $tabla3 = "detalleestudianteadmision";
                $nombreidtabla1 = "iddetalleestudianteadmision";
                $idtabla1 = $actualizarhorario['iddetalleestudianteadmision'];
                $fila3['fechadetalleestudianteadmision'] = date("Y-m-d");
                $fila3['idestudianteadmision'] = $actualizarhorario['idestudianteadmision'];
                $fila3['iddetalleadmision'] = $actualizarhorario['iddetalleadmision'];
                $fila3['resultadodetalleestudianteadmision'] = '0';
                $fila3['idhorariodetallesitioadmision'] = $actualizarhorario['idhorariodetallesitioadmision'];
                $fila3['codigoestado'] = '100';
                $fila3['codigoestadoestudianteadmision'] = $_POST['codigoestadoestudianteadmision'];
                $fila3['observacionesdetalleestudianteadmision'] = $_POST['observacionesdetalleestudianteadmision'];
                $objetobase->actualizar_fila_bd($tabla3, $fila3, $nombreidtabla1, $idtabla1, "", 1);

                $URL = "formulariohorarioadmisionestudiante.php?codigoestudiante=" . $_GET['codigoestudiante'] .
                        "&iddetalleadmision=" . $actualizarhorario['iddetalleadmision'] .
                        "&iddetallesitioadmision=" . $_POST['iddetallesitioadmision'] .
                        "&codigoestadoestudianteadmision=" . $_POST['codigoestadoestudianteadmision'] . "";
                echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=$URL'>";
                //echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=$REQUEST_URI'>";
            }
        }

        if (isset($_REQUEST['Anular'])) {

            if ($formulario->valida_formulario()) {

                echo $query_actualizarhorario = "SELECT *
 FROM horariodetallesitioadmision hsd,detalleestudianteadmision d
WHERE hsd.idhorariodetallesitioadmision=d.idhorariodetallesitioadmision
and hsd.codigoestado like '1%' and d.codigoestado like '1%'
and d.iddetalleestudianteadmision='" . $row_Horario['iddetalleestudianteadmision'] . "'";

                $actualizarhorario = $objetobase->conexion->Execute($query_actualizarhorario);
                $totalRows_actualizarhorario = $actualizarhorario->RecordCount();
                $actualizarhorario = $actualizarhorario->FetchRow();

                $tabla4 = "detalleestudianteadmision";
                $nombreidtabla2 = "iddetalleestudianteadmision";
                $idtabla2 = $actualizarhorario['iddetalleestudianteadmision'];
                $fila4['codigoestado'] = '200';
                $objetobase->actualizar_fila_bd($tabla4, $fila4, $nombreidtabla2, $idtabla2, "", 0);
                echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=$REQUEST_URI'>";
            }
        }
        ?>
    </table>
</form>
