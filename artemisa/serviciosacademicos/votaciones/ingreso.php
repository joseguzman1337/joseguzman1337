<?php
/**
 * Se hace reorganizacion de codigo general
 * @modified Andres Ariza <andresariza@unbosque.edu.do>.
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @since 18 de septiembre de 2018.
 */
session_start();
$rutaado = ("../funciones/adodb/");

require_once("../Connections/salaado-pear.php");
require_once("../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../funciones/sala_genericas/FuncionesCadena.php");
require_once("../funciones/sala_genericas/FuncionesFecha.php");
require_once("../funciones/sala_genericas/FuncionesIngresoNombreTabla.php");
require_once("../funciones/clases/formulario/clase_formulario.php");
require_once("../funciones/sala_genericas/formulariobaseestudiante.php");
unset($_SESSION['tmptipovotante']);
unset($_SESSION['datosvotante']);
$fechahoy = date("Y-m-d H:i:s");
$formulario = new formulariobaseestudiante($sala, 'form1', 'post', '', 'true');
$objetobase = new BaseDeDatosGeneral($sala);


/**
 * Se setea el objeto de configuracion del nuevo sala si la aplicacion se corre en un entorno local o de pruebas se activa la visualizacion 
 * de todos los errores de php
 * @modified Andres Ariza <andresariza@unbosque.edu.do>.
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @since 18 de septiembre de 2018.
 */
$Configuration = Configuration::getInstance();
if($Configuration->getEntorno()=="local"||$Configuration->getEntorno()=="pruebas"){
    @error_reporting(1023); // NOT FOR PRODUCTION SERVERS!
    @ini_set('display_errors', '1'); // NOT FOR PRODUCTION SERVERS!
    /**
     * Se incluye la libreria Kint para hacer debug controlado de variables y objetos
     */
    require (PATH_ROOT.'/kint/Kint.class.php');
}
/**
 * Se importa el archivo encargado de las validaciones de las votaciones
 * @modified Andres Ariza <andresariza@unbosque.edu.do>.
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @since 18 de septiembre de 2018.
 */
require_once("funciones/Validaciones.php");
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Votación <?php echo date("Y"); ?></title>
        <link rel="stylesheet" type="text/css" href="../../serviciosacademicos/estilos/sala.css">
        <script type="text/javascript" src="../../serviciosacademicos/funciones/sala_genericas/funciones_javascript.js"></script>
        <link rel="stylesheet" type="text/css" href="../../serviciosacademicos/funciones/calendario_nuevo/calendar-win2k-1.css">
        <style type="text/css">
            body {
                margin-left: 0px;
                margin-top: 0px;
                background-color: #EDF0D5;
                font-family: "Source Sans Pro",sans-serif;

            }

            #pagina{
                width:765px;
                margin: 0 auto;
                background-color: #fff;
                /*border: 1px solid #394528;*/
                box-shadow: 0 0 10px 5px rgba(0, 0, 0, 0.2);
                margin-top:30px;
            }

            #header {
                background: none repeat scroll 0 0 #394528;
                display: block;
                margin: auto;
                opacity: 0.9;
                padding: 15px 35px 30px;
                color:#fff;
                border-bottom: 7px solid #88ab0c;
            }
            h1{
                font-weight:bold;
                margin:15px 0 5px;
                font-size:22px;
            }
            h4{
                font-weight:bold;
                margin:0px 0 10px;
                font-size:18px;
            }

            form{
                width:100%;
                padding: 20px 0 40px;
            }

            form #labelresaltado{
                font-size:14px;
                text-align:center;
                display:block;
                margin: 10px 0 30px;
            }

            form table{
                border-collapse:collapse;
                border:0px;
                border-color:#fff;
            }
            form table td, form table td#tdtitulogris{
                padding: 10px;
                border:0;

            }

            form table td#tdtitulogris{
                text-align: right;
                background-color: #fff;
                font-size: 12px;
                line-height: 1.1em;
                font-weight:normal;
            }

            form table td input,form table td select{
                border: 1px solid #cecece;
                box-sizing: border-box;
                font-size: 1em;
                outline: medium none;
                padding: 5px;
                width: 70%;
            }

            form table input[type="submit"]{
                background-color: #82b440;
                color: #fff;
                border-radius: 4px;
                padding: 5px 20px;
                text-align: center;
                box-shadow: 0 2px 0 #6f9a37;
                border-color:#82b440;
                font-size: 14px;
            }

            form table input[type="submit"]:hover{
                cursor:pointer;
            }

            form table input[type="submit"]:focus{
                margin-top:1px;
                margin-left:1px;
            }

            form table td img{
                margin-left:10px;position:relative;top:0;
            }

        </style>
        <script type="text/javascript" src="../../serviciosacademicos/funciones/calendario_nuevo/calendar.js"></script>
        <script type="text/javascript" src="../../serviciosacademicos/funciones/calendario_nuevo/calendar-es.js"></script>
        <script type="text/javascript" src="../../serviciosacademicos/funciones/calendario_nuevo/calendar-setup.js"></script>
        <script type="text/javascript" src="../../serviciosacademicos/funciones/clases/formulario/globo.js"></script>
        <script type="text/javascript">
            //if (document.location.protocol == "https:") {
            //    var direccion = document.location.href;
            //    var ssl = (direccion.replace(/https/, "http"));
            //    document.location.href = ssl;
           // }
        </script>
    </head>
    <body>
        <div id="pagina">

            <div id="header">
                <img width="310" src="logoU.png" alt="Universidad El Bosque">
                <?php /*/ ?><h1>Universidad El Bosque en mejoramiento continuo</h1><?php /**/ ?>
                <h1>Bienvenido a las votaciones.</h1>
                <h4>Tu eres clave. Participa!</h4>
                <h2>
                  Para acceder a la votación, diligencie el formulario a continuación:
                </h2>
            </div>

            <form name="form1" action="" method="POST" >
                <input type="hidden" name="AnularOK" value="">
                <?php $formulario->dibujar_fila_titulo('VOTACIONES ' . date('Y')." - 2020", 'labelresaltado', "2", "align='center'"); ?>
                <table border="1" cellpadding="1" cellspacing="0" width="87%">
                    <?php
                    
                    /*
                     * Se añade validacion para mostrar opciones de tipo de votante
                     * dependiendo de a quien van dirigidas las votaciones (ver tabla debase de datos llamada tipocandidatodetalleplantilla)
                     * 1. Docente
                     * 2. Estudiante
                     * 3. Egresados
                     * 4. Administrativo
                     * Andres Ariza <andresariza@unbosque.edu.do>.
                     * Universidad el Bosque - Direccion de Tecnologia.
                     * Modificado 18 de septiembre de 2018.
                     */
                    /**
                     * Caso 405
                     * @modifed Luis Dario Gualteros castro <castroluisd@unbosque.edu.co>
                     * @since 25 de febrero 2019
                     * Se añade un ciclo para indentificar los tipos de documentos y se cambia la validacion de los case
                    */
                    $formulario->filatmp[""] = "Seleccionar";
                    $tipos = Validaciones::validarTipoVotacionesDisponibles();                                        
                    if(!empty($tipos) && is_array($tipos)){                        
                        foreach($tipos as $tipo){                            
                            switch($tipo){
                                case ('1'):{
                                    $formulario->filatmp["2"] = "Docente"; 
                                    $formulario->filatmp["4"] = "Docentes sin candidato de consejo facultad";
                                    $formulario->filatmp["5"] = "Docentes Colegio";
                                    }break;
                                case ('2'):{
                                    //El estudiante debe ingresar por Sala.
                                    //$formulario->filatmp["7"] = "Estudiante";
                                    }break;
                                case ('3'):{
                                        $formulario->filatmp["1"] = "Egresado";
                                    }break;
                                case ('4'):{
                                    $formulario->filatmp["3"] = "Directivo";
                                    $formulario->filatmp["6"] = "Docentes y Administrativos"; 
                                }break; 
                            }
                        }
                    } //END MODIFICACION CASE 405.
                    
                    $menu = "menu_fila";
                    $parametrosmenu = "'idtipovotante','" . @$_POST['idtipovotante'] . "',''";
                    $formulario->dibujar_campo($menu, $parametrosmenu, "Tipo de votante", "tdtitulogris", "idtipovotante", 'requerido');


                    $campo = "boton_tipo";
                    $parametros = "'text','nombre','" . @$_POST['nombre'] . "',''";
                    $formulario->dibujar_campo($campo, $parametros, "Nombres", "tdtitulogris", 'nombre', 'requerido');

                    $campo = "boton_tipo";
                    $parametros = "'text','apellido','" . @$_POST['apellido'] . "',''";
                    $formulario->dibujar_campo($campo, $parametros, "Apellidos", "tdtitulogris", 'apellido', 'requerido');

                    $campo = "boton_tipo";
                    $parametros = "'text','numerodocumento','" . @$_POST['numerodocumento'] . "',''";
                    $formulario->dibujar_campo($campo, $parametros, "Numero de Documento", "tdtitulogris", 'numerodocumento', 'numero');

                    $conboton = 0;
                    ?>
                    <tr>

                        <td id="tdtitulogris">Ingrese el contenido de la imagen<label id="labelasterisco">*</label> <img src="../mgi/autoevaluacion/interfaz/phpcaptcha/captcha.php"/>  </td>

                        <td>            
                            <input type="text" name="captcha" id="captcha" maxlength="6" size="6"/></td>          
                    </tr>
                    <?php
                    $parametrobotonenviar[$conboton] = "'submit','Enviar','Ingresar a votar'";
                    $boton[$conboton] = 'boton_tipo';
                    $conboton++;
                    $formulario->dibujar_campos($boton, $parametrobotonenviar, "", "tdtitulogris", 'Enviar', '', 0);

                    if (isset($_REQUEST['Enviar'])) {
                        if ($formulario->valida_formulario()) {
                            if ($_POST['captcha'] == $_SESSION['cap_code']) {
                                $condicion = "";
                                switch ($_POST['idtipovotante']) {
                                    case 1:
                                        $nombre = $_POST['nombre'];
                                        $apellido = $_POST['apellido'];
                                        $numerodocumento = $_POST['numerodocumento'];
                                        $tablanombre = "nombresestudiantegeneral";
                                        $tablaapellido = "apellidosestudiantegeneral";
                                        $tabla = "estudiantegeneral t1";

                                        $condicion .= "";

                                        IngresoNombreTabla($nombre, $apellido, $numerodocumento, $tablanombre, $tablaapellido, $tabla, $condicion, $objetobase);

                                        $_SESSION['datosvotante']['tipovotante'] = 'egresado';
                                        $_SESSION['datosvotante']['numerodocumento'] = $_POST['numerodocumento'];
                                        $_SESSION['datosvotante']['estadovotante'] = 'porfuera';

                                        $query_sitestudiante = "select c.codigomodalidadacademica,c.codigocarrera
					from estudiantegeneral e, estudiante ee, carrera c 
					WHERE e.numerodocumento=$numerodocumento
					AND e.idestudiantegeneral=ee.idestudiantegeneral
					AND ee.codigocarrera=c.codigocarrera AND c.codigomodalidadacademica IN (200,300) 
					AND ee.codigosituacioncarreraestudiante=400
					limit 1 
				UNION select c.codigomodalidadacademica,c.codigocarrera from egresado e, estudiante ee, carrera c 
							where e.numerodocumento=$numerodocumento
							and e.idestudiantegeneral=ee.idestudiantegeneral
							and ee.codigocarrera=c.codigocarrera
							and ee.codigosituacioncarreraestudiante=400
							limit 1";
                                        
                                        $sitestudiante = $sala->query($query_sitestudiante);
                                        $totalRows_sitestudiante = $sitestudiante->RecordCount();
                                        $row_sitestudiante = $sitestudiante->fetchRow();
                                        if (!$row_sitestudiante['codigocarrera']) {
                                            alerta_javascript("Los datos no corresponden a un estudiante egresado");
                                            exit();
                                        }
                                        $_SESSION['datosvotante']['codigocarrera'] = $row_sitestudiante['codigocarrera'];
                                        $_SESSION['datosvotante']['modalidadacademica'] = $row_sitestudiante['codigomodalidadacademica'];
                                        
                                        /**
                                         * Se remplaza la consulta que existia hardodeada para validar si existian votaciones habilitadas
                                         * por la validacion de la informacion a travez del objeto Validaciones
                                         * @modified Andres Ariza <andresariza@unbosque.edu.do>.
                                         * @copyright Dirección de Tecnología Universidad el Bosque
                                         * @since 18 de septiembre de 2018.
                                         */
                                        $idvotacion = Validaciones::validarVotacionesDisponibles($_POST['idtipovotante']); 
                                        
                                        if (!$idvotacion) {
                                            alerta_javascript("No hay votacion vigente");
                                            exit();
                                        }
                                        $_SESSION['datosvotante']['idvotacion'] = $idvotacion;
                                        
                                        /**
                                         * Se remplaza la consulta que existia hardodeada para validar si existian votaciones del usuario
                                         * por la validacion de la informacion a travez del objeto Validaciones
                                         * @modified Andres Ariza <andresariza@unbosque.edu.do>.
                                         * @copyright Dirección de Tecnología Universidad el Bosque
                                         * @since 18 de septiembre de 2018.
                                         */
                                        $cantVotos = Validaciones::validarUsuarioExisteVotacion($_POST['numerodocumento'], $idvotacion);
                                        
                                        if ($cantVotos > 0) {
                                            alerta_javascript("Usted ya ha votado, No puede ingresar ");
                                        } else {
                                            alerta_javascript("Bienvenido a la votación");
                                            echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=datosVotacion.php'>";
                                        }
                                        break;
                                    case 2:

                                        $nombre = $_POST['nombre'];
                                        $apellido = $_POST['apellido'];
                                        $numerodocumento = $_POST['numerodocumento'];
                                        $tablanombre = "nombredocente";
                                        $tablaapellido = "apellidodocente";
                                        $tabla = "docente t1";

                                        $condicion .= " ";

                                        IngresoNombreTabla($nombre, $apellido, $numerodocumento, $tablanombre, $tablaapellido, $tabla, $condicion, $objetobase);


                                        $_SESSION['datosvotante']['tipovotante'] = 'docente';
                                        $_SESSION['datosvotante']['numerodocumento'] = $_POST['numerodocumento'];
                                        $_SESSION['datosvotante']['estadovotante'] = 'porfuera';
                                        
                                        /**
                                         * Se remplaza la consulta que existia hardodeada para validar si existian votaciones habilitadas
                                         * por la validacion de la informacion a travez del objeto Validaciones
                                         * @modified Andres Ariza <andresariza@unbosque.edu.do>.
                                         * @copyright Dirección de Tecnología Universidad el Bosque
                                         * @since 18 de septiembre de 2018.
                                         */
                                        $idvotacion = Validaciones::validarVotacionesDisponibles($_POST['idtipovotante']); 
                                        
                                        if (!$idvotacion) {
                                            alerta_javascript("No hay votacion vigente");
                                            exit();
                                        }
                                                                                
                                        $_SESSION['datosvotante']['idvotacion'] = $idvotacion;
                                        
                                        /**
                                         * Se remplaza la consulta que existia hardodeada para validar si existian votaciones del usuario
                                         * por la validacion de la informacion a travez del objeto Validaciones
                                         * @modified Andres Ariza <andresariza@unbosque.edu.do>.
                                         * @copyright Dirección de Tecnología Universidad el Bosque
                                         * @since 18 de septiembre de 2018.
                                         */
                                        $cantVotos = Validaciones::validarUsuarioExisteVotacion($_POST['numerodocumento'], $idvotacion);
                                        
                                        if ($cantVotos > 0) {
                                            alerta_javascript("Usted ya ha votado, No puede ingresar ");
                                        } else {
                                            alerta_javascript("Bienvenido a la votación");
                                            echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=datosVotacion.php'>";
                                        }

                                        break;
                                    case 3:

                                        $nombre = $_POST['nombre'];
                                        $apellido = $_POST['apellido'];
                                        $numerodocumento = $_POST['numerodocumento'];
                                        $tablanombre = "nombresdirectivo";
                                        $tablaapellido = "apellidosdirectivo";
                                        $tabla = "directivo t1";

                                        $condicion .= "";

                                        IngresoNombreTabla($nombre, $apellido, $numerodocumento, $tablanombre, $tablaapellido, $tabla, $condicion, $objetobase, "t1.numerodocumentodirectivo");

                                        $_SESSION['datosvotante']['tipovotante'] = 'directivo';
                                        $_SESSION['datosvotante']['numerodocumento'] = $_POST['numerodocumento'];
                                        $_SESSION['datosvotante']['estadovotante'] = 'porfuera';
                                        
                                        /**
                                         * Se remplaza la consulta que existia hardodeada para validar si existian votaciones habilitadas
                                         * por la validacion de la informacion a travez del objeto Validaciones
                                         * @modified Andres Ariza <andresariza@unbosque.edu.do>.
                                         * @copyright Dirección de Tecnología Universidad el Bosque
                                         * @since 18 de septiembre de 2018.
                                         */
                                        $idvotacion = Validaciones::validarVotacionesDisponibles($_POST['idtipovotante']); 
                                        
                                        if (!$idvotacion) {
                                            alerta_javascript("No hay votacion vigente");
                                            exit();
                                        }
                                        $_SESSION['datosvotante']['idvotacion'] = $idvotacion;
                                                                                
                                        /**
                                         * Se remplaza la consulta que existia hardodeada para validar si existian votaciones del usuario
                                         * por la validacion de la informacion a travez del objeto Validaciones
                                         * @modified Andres Ariza <andresariza@unbosque.edu.do>.
                                         * @copyright Dirección de Tecnología Universidad el Bosque
                                         * @since 18 de septiembre de 2018.
                                         */
                                        $cantVotos = Validaciones::validarUsuarioExisteVotacion($_POST['numerodocumento'], $idvotacion);
                                        
                                        if ($cantVotos > 0) {
                                            alerta_javascript("Usted ya ha votado, No puede ingresar ");
                                        } else {
                                            alerta_javascript("Puede continuar");
                                            echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=datosVotacion.php'>";
                                        }

                                        break;
                                    case 4:

                                        $nombre = $_POST['nombre'];
                                        $apellido = $_POST['apellido'];
                                        $numerodocumento = $_POST['numerodocumento'];
                                        $tablanombre = "nombredocente";
                                        $tablaapellido = "apellidodocente";
                                        $tabla = "docente t1";

                                        $condicion .= "";

                                        IngresoNombreTabla($nombre, $apellido, $numerodocumento, $tablanombre, $tablaapellido, $tabla, $condicion, $objetobase);

                                        $_SESSION['datosvotante']['tipovotante'] = 'directivo';
                                        $_SESSION['datosvotante']['numerodocumento'] = $_POST['numerodocumento'];
                                        $_SESSION['datosvotante']['estadovotante'] = 'porfuera';
                                        
                                        
                                        /**
                                         * Se remplaza la consulta que existia hardodeada para validar si existian votaciones habilitadas
                                         * por la validacion de la informacion a travez del objeto Validaciones
                                         * @modified Andres Ariza <andresariza@unbosque.edu.do>.
                                         * @copyright Dirección de Tecnología Universidad el Bosque
                                         * @since 18 de septiembre de 2018.
                                         */
                                        $idvotacion = Validaciones::validarVotacionesDisponibles($_POST['idtipovotante']); 
                                        
                                        if (!$idvotacion) {
                                            alerta_javascript("No hay votacion vigente");
                                            exit();
                                        }
                                        
                                        $_SESSION['datosvotante']['idvotacion'] = $idvotacion;
                                        
                                        /**
                                         * Se remplaza la consulta que existia hardodeada para validar si existian votaciones del usuario
                                         * por la validacion de la informacion a travez del objeto Validaciones
                                         * @modified Andres Ariza <andresariza@unbosque.edu.do>.
                                         * @copyright Dirección de Tecnología Universidad el Bosque
                                         * @since 18 de septiembre de 2018.
                                         */
                                        $cantVotos = Validaciones::validarUsuarioExisteVotacion($_POST['numerodocumento'], $idvotacion);
                                        
                                        if ($cantVotos > 0) {
                                            alerta_javascript("Usted ya ha votado, No puede ingresar ");
                                        } else {
                                            alerta_javascript("Puede continuar");
                                            echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=datosVotacion.php'>";
                                        }

                                        break;
                                    case 5:

                                        $nombre = $_POST['nombre'];
                                        $apellido = $_POST['apellido'];
                                        $numerodocumento = $_POST['numerodocumento'];
                                        $tablanombre = "nombres";
                                        $tablaapellido = "apellidos";
                                        $tabla = "tmppersonal2010 t1";

                                        $condicion .= " and a21 LIKE '%docente%' ";

                                        IngresoNombreTabla($nombre, $apellido, $numerodocumento, $tablanombre, $tablaapellido, $tabla, $condicion, $objetobase);

                                        $_SESSION['datosvotante']['tipovotante'] = 'directivo';
                                        $_SESSION['datosvotante']['numerodocumento'] = $_POST['numerodocumento'];
                                        $_SESSION['datosvotante']['estadovotante'] = 'porfuera';
                                        
                                        /**
                                         * Se remplaza la consulta que existia hardodeada para validar si existian votaciones habilitadas
                                         * por la validacion de la informacion a travez del objeto Validaciones
                                         * @modified Andres Ariza <andresariza@unbosque.edu.do>.
                                         * @copyright Dirección de Tecnología Universidad el Bosque
                                         * @since 18 de septiembre de 2018.
                                         */
                                        $idvotacion = Validaciones::validarVotacionesDisponibles($_POST['idtipovotante']); 
                                        
                                        if (!$idvotacion) {
                                            alerta_javascript("No hay votacion vigente");
                                            exit();
                                        }
                                        $_SESSION['datosvotante']['idvotacion'] = $idvotacion;
                                        
                                        /**
                                         * Se remplaza la consulta que existia hardodeada para validar si existian votaciones del usuario
                                         * por la validacion de la informacion a travez del objeto Validaciones
                                         * @modified Andres Ariza <andresariza@unbosque.edu.do>.
                                         * @copyright Dirección de Tecnología Universidad el Bosque
                                         * @since 18 de septiembre de 2018.
                                         */
                                        $cantVotos = Validaciones::validarUsuarioExisteVotacion($_POST['numerodocumento'], $idvotacion);
                                        
                                        if ($cantVotos > 0) {
                                            alerta_javascript("Usted ya ha votado, No puede ingresar ");
                                        } else {
                                            alerta_javascript("Bienvenido a la votación");
                                            echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=datosVotacion.php'>";
                                        }

                                        break;
                                    case 6:

                                        $nombre = $_POST['nombre'];
                                        $apellido = $_POST['apellido'];
                                        $numerodocumento = $_POST['numerodocumento'];
                                        $tablanombre = "nombresadministrativosdocentes";
                                        $tablaapellido = "apellidosadministrativosdocentes";
                                        $tabla = "administrativosdocentes t1";

                                        $condicion .= "";

                                        IngresoNombreTabla($nombre, $apellido, $numerodocumento, $tablanombre, $tablaapellido, $tabla, $condicion, $objetobase);

                                        $_SESSION['datosvotante']['tipovotante'] = 'administrativo';
                                        $_SESSION['datosvotante']['numerodocumento'] = $_POST['numerodocumento'];
                                        $_SESSION['datosvotante']['estadovotante'] = 'porfuera';
                                        
                                        /**
                                         * Se remplaza la consulta que existia hardodeada para validar si existian votaciones habilitadas
                                         * por la validacion de la informacion a travez del objeto Validaciones
                                         * @modified Andres Ariza <andresariza@unbosque.edu.do>.
                                         * @copyright Dirección de Tecnología Universidad el Bosque
                                         * @since 18 de septiembre de 2018.
                                         */
                                        $idvotacion = Validaciones::validarVotacionesDisponibles($_POST['idtipovotante']);
                                        
                                        if ($idvotacion === false) {
                                            alerta_javascript("No hay votacion vigente");
                                            exit();
                                        }
                                        $_SESSION['datosvotante']['idvotacion'] = $idvotacion;
                                        
                                        /**
                                         * Se remplaza la consulta que existia hardodeada para validar si existian votaciones del usuario
                                         * por la validacion de la informacion a travez del objeto Validaciones
                                         * @modified Andres Ariza <andresariza@unbosque.edu.do>.
                                         * @copyright Dirección de Tecnología Universidad el Bosque
                                         * @since 18 de septiembre de 2018.
                                         */
                                        $cantVotos = Validaciones::validarUsuarioExisteVotacion($_POST['numerodocumento'], $idvotacion);
                                        
                                        if ( ($cantVotos === false) || ($cantVotos > 0) ) {
                                            alerta_javascript("Usted ya ha votado, No puede ingresar ");
                                        } else {
                                            alerta_javascript("Bienvenido a la votación");
                                            echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=datosVotacion.php'>";
                                        }
                                        break;
                                }
                            } else {
                                ?>
                                <script type="text/javascript">
                                    alert("Verifique que los datos ingresados sean igual a la imagen en pantalla");
                                    history.go(-1);
                                </script>
                                <?php
                            }
                        }
                    }
                    ?>

                </table>
            </form>

        </div>
        <script languaje='javascript'>
            //alert('Votaciones Cerradas...gracias');
            //window.location.href = "http://www.uelbosque.edu.co"; 
        </script>
    </body>
</html>

