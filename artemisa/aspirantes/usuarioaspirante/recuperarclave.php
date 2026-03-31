<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $rutaado = ("../../serviciosacademicos/funciones/adodb/");
    require_once("../../serviciosacademicos/Connections/salaado-pear.php");
    require_once("../../serviciosacademicos/funciones/clases/formulario/clase_formulario.php");
    require_once("../../serviciosacademicos/funciones/phpmailer/class.phpmailer.php");
    require_once("../../serviciosacademicos/funciones/validaciones/validaciongenerica.php");
    require_once("../../serviciosacademicos/funciones/sala_genericas/FuncionesCadena.php");
    require_once("../../serviciosacademicos/funciones/sala_genericas/FuncionesFecha.php");
    require_once("../../serviciosacademicos/funciones/sala_genericas/FuncionesSeguridad.php");
    require_once("../../serviciosacademicos/funciones/sala_genericas/FuncionesMatematica.php");
    require_once("../../serviciosacademicos/funciones/sala_genericas/formulariobaseestudiante.php");
    require_once("../../serviciosacademicos/funciones/sala_genericas/clasebasesdedatosgeneral.php");
    require_once("../../serviciosacademicos/funciones/sala_genericas/securimage/securimage.php");
    require_once("correoactivacioncuenta.php");
    require_once("constantesactivacion.php");
    require_once("localization.php");
    $lang = "es-es";
    if(isset($_GET["lang"])&&$_GET["lang"]!=""){
        $lang = $_GET["lang"];
    }
    $formulario = new formulariobaseestudiante($sala, "form1", "post", "", "true");
    $formulario->rutaraiz = "../../serviciosacademicos/funciones/sala_genericas/";
    $objetobase = new BaseDeDatosGeneral($sala);
    $securimage = new Securimage();


    $horaactual = mktime();
    $horaregistro = $_GET['ta'];
    $activarclave = 0;

    if (isset($_GET['id']) && trim($_GET['ta']) != '') {
        if (($horaactual - $horaregistro) < TIEMPOACTIVACION) {
            $activarclave = 1;
        } else {
            $mensaje = localize("Su periodo de tiempo para recuperar la contraseña a expirado",$lang).",
                \\n ".localize("Recuerde que tiene un dia para utilizar el enlace que llega en su correo",$lang).",
                \\n ".localize("puede volver a intentarlo",$lang);
            alerta_javascript($mensaje);
            echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=" . ENLACEINGRESOASPIRANTE . "'>";
        }
    }
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
    <head>
        <link type="text/css" rel="stylesheet" href="../../assets/css/normalize.css">
        <link type="text/css" rel="stylesheet" href="../../assets/css/font-page.css">
        <link type="text/css" rel="stylesheet" href="../../assets/css/font-awesome.css">
        <link type="text/css" rel="stylesheet" href="../../assets/css/bootstrap.css">
        <link type="text/css" rel="stylesheet" href="../../assets/css/general.css">
        <link type="text/css" rel="stylesheet" href="../../assets/css/chosen.css">
        <link type="text/css" rel="stylesheet" href="../../assets/css/custom.css">
        <link type="text/css" rel="stylesheet" href="../../assets/css/bootstrap.css?v=1">
        <script type="text/javascript" src="../../assets/js/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" src="../../assets/js/bootstrap.js"></script>
        <script src="../../assets/js/moment.min.js?v=1"></script>
        <script src="../../assets/js/bootstrap-datetimepicker.min.js?v=1"></script>
        <script src="../../assets/js/bootstrap-datetimepicker.es.js?v=1"></script>
        <script src="../../assets/js/calendar_format.js?v=1"></script>
        <script type="text/javascript" src="../../assets/js/bootbox.min.js"></script>
        <script type="text/javascript" src="../../assets/js/jquery.validate.min.js"></script>

        <script type="text/javascript" src="../../serviciosacademicos/funciones/sala_genericas/funciones_javascript.js"></script>
        <link rel="stylesheet" type="text/css" href="../../funciones/calendario_nuevo/calendar-win2k-1.css">
        <script type="text/javascript" src="../../serviciosacademicos/funciones/calendario_nuevo/calendar.js"></script>
        <script type="text/javascript" src="../../serviciosacademicos/funciones/calendario_nuevo/calendar-es.js"></script>
        <script type="text/javascript" src="../../serviciosacademicos/funciones/calendario_nuevo/calendar-setup.js"></script>
        <script type="text/javascript" src="../../serviciosacademicos/funciones/clases/formulario/globo.js"></script>
        <title>Servicios Academicos</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <script LANGUAGE="JavaScript">
            function capLock(e){
                //var char;
                kc=e.keyCode?e.keyCode:e.which;
                sk=e.shiftKey?e.shiftKey:((kc==16)?true:false);

                if(((kc>=65&&kc<=90)&&!sk)||((kc>=97&&kc<=122)&&sk)){
                    //alert("Entro a mayusculas");
                    var caracter = kc + 32;
                    charreturn = String.fromCharCode(kc);
                }
                else{
                    //alert("Entro a minusculas");
                    //var caracter = kc - 32;
                    charreturn = String.fromCharCode(kc);
                }
                return charreturn;
            }
            function evitaCopiaEmail(evento,obj){
                //alert(evento);
                evento = (!evento) ? window.event : evento;
                var keycaracter=null;
                var caracter="";

                if (evento!=null){
                    if(evento.charCode!=0&&evento.charCode!=null){
                        keycaracter = evento.charCode;
                        caracter=String.fromCharCode(keycaracter);
                    }
                    else{
                        keycaracter = evento.keyCode;
                        caracter=capLock(evento);
                    }

                }
                if(window.event){
                    // evento=window.event;
                    //
                    if(evento.charCode!=0&&evento.charCode!=null){
                        keycaracter = evento.charCode;
                        caracter=String.fromCharCode(keycaracter);
                    }
                    else{
                        keycaracter = evento.keyCode;
                        caracter=capLock(evento);
                        //alert("charcode="+capLock(evento)+" keyCode="+evento.keyCode+" key="+key);
                    }
                }

                //alert("key="+keycaracter+"\ncaracter="+caracter);
                if(keycaracter==17||keycaracter==16){
                    obj.value='';

                    return false;

                }
                else{
                    return true;
                }

            }
            function validaLargoClave(obj){
                // alert('Entro');
                if(obj.value.length<6){
                    alert("<?php echo localize('Clave debe contener mas de 6 caracteres',$lang); ?>");
                    obj.value='';
                    obj.focus();
                }
            }
        </script>
    </head>
        <body>
        <nav class="navbar">
            <a href="http://www.uelbosque.edu.co" title="Inicio" rel="home">
                <img src="../admisiones/logo-uelbosque.png" alt="Inicio">
            </a>
        </nav>
        <div class="container">
            <div class="row centered-form">
                <div class="panel-body form-group">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <h1>Recuperación de clave</h1>
                        </div>
                    </div>
            <?php
            echo "<form name=\"form1\" id=\"form1\" action=\"\" method=\"post\"  >
            <input type=\"hidden\" name=\"AnularOK\" value=\"\">
                <table border=\"1\" cellpadding\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\">";
            $deshabilitarcorreo = "";
            if ($activarclave) {
                $deshabilitarcorreo = "readonly=yes";
                $correo = $_GET['correo'];
                $campo = 'boton_tipo';
                $formulario->boton_tipo('hidden', 'idestudiantegeneral', $_GET['id'], '');
            }

            $formulario->dibujar_fila_titulo(localize('Recuperacion de clave',$lang), 'labelresaltado', "2", "align='center'");
            $formulario->dibujar_fila_titulo(localize('Ingrese su correo personal',$lang), 'labelresaltado', "2", "align='left'");
            $campo = 'boton_tipo';
            $parametros = "'textfield','correo','" . $correo . "','" . $deshabilitarcorreo . "'";
            $formulario->dibujar_campo($campo, $parametros, localize("E-mail",$lang), "tdtitulogris", 'correo', 'email');
            if (!$activarclave) {
                $conboton = 0;
                $parametrobotonenviar[$conboton] = "'submit','Enviar',".localize('Enviar',$lang).",''";
                $boton[$conboton] = 'boton_tipo';
                $conboton++;
                $formulario->dibujar_campos($boton, $parametrobotonenviar, "", "tdtitulogris", 'Enviar');
            }



            if ($activarclave) {
                $campo = 'boton_tipo';
                $parametros = "'password','clave','" . $clave . "','onchange=\"return validaLargoClave(this);\"'";
                $formulario->dibujar_campo($campo, $parametros, localize("Clave",$lang), "tdtitulogris", 'clave', 'requerido');

                $campo = 'boton_tipo';
                $parametros = "'password','confirmarclave','" . $confirmarclave . "','onchange=\"return validaLargoClave(this);\"'";
                $formulario->dibujar_campo($campo, $parametros, localize("Confirmar Clave",$lang), "tdtitulogris", 'confirmarclave', 'requerido');
                $conboton = 0;
                $parametrobotonenviar[$conboton] = "'submit','Modificar','Modificar Clave',''";
                $boton[$conboton] = 'boton_tipo';
                $conboton++;
                $formulario->dibujar_campos($boton, $parametrobotonenviar, "", "tdtitulogris", 'Enviar');
            }

            echo "</table>";
            echo "</form>";

            if (isset($_REQUEST['Enviar'])) {
                enviaCorreoRecuperacion($objetobase, $_POST['correo'],$lang);
            }
            if (isset($_REQUEST['Modificar'])) {
                $sigue = 1;
                $mensajealerta = localize('Algunos campos no han sido correctamente diligenciados',$lang).":";
                if (!$formulario->valida_formularioLocalizado($lang)) {
                    $sigue = 0;
                }
                if ($_POST['clave'] != $_POST['confirmarclave']) {
                    $sigue = 0;
                    $mensajealerta.="\\n-".localize('No coincide la confirmación de la clave',$lang)." ";
                }
                if ($sigue) {
                    $tabla = "usuariopreinscripcion";
                    $fila['idestudiantegeneral'] = $_POST['idestudiantegeneral'];
                    $fila['usuariopreinscripcion'] = $_POST['correo'];
                    //$fila['claveusuariopreinscripcion'] = md5($_POST['clave']);
                    $fila['claveusuariopreinscripcion'] = hash('sha256', $_POST['clave']);
                    $fila['fechavencimientoclaveusuariopresinscripcion'] = '2099-12-31';
                    $fila['fechavencimientousuariopresinscripcion'] = '2099-12-31';
                    $condicion = " idestudiantegeneral=" . $fila['idestudiantegeneral'];
                    $objetobase->insertar_fila_bd($tabla, $fila, 0, $condicion);
                    $mensaje = localize("Su clave ha sido actualizada exitosamente",$lang).",\\n ".localize("puede ingresar en la siguiente pagina",$lang);
                    alerta_javascript($mensaje);
                    echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=" . ENLACEINGRESOASPIRANTE . "'>";
                } else {
                    alerta_javascript($mensajealerta);
                }
            }
            ?>
        </div>
    </body>
</html>