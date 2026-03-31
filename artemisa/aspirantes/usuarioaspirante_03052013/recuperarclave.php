<?php
session_start();

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
$formulario = new formulariobaseestudiante($sala, "form1", "post", "", "true");
$formulario->rutaraiz = "../../serviciosacademicos/funciones/sala_genericas/";
$objetobase = new BaseDeDatosGeneral($sala);
$securimage = new Securimage();


$horaactual = mktime();
$horaregistro = $_GET['ta'];
$activarclave = 0;
//echo "if (($horaactual - $horaregistro) > ".TIEMPOACTIVACION.") {";
if (isset($_GET['id']) && trim($_GET['ta']) != '') {
    if (($horaactual - $horaregistro) < TIEMPOACTIVACION) {
        // echo "HABER SI SALE ESTO ?";
        $activarclave = 1;
    } else {
        $mensaje = "Su periodo de tiempo para recuperar la contraseña a expirado ,\\n Recuerde que tiene un dia para utilizar el enlace que llega en su cooreo,\\n puede volver a intentarlo";
        alerta_javascript($mensaje);
        echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=" . ENLACEINGRESOASPIRANTE . "'>";
    }
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
    <head>

        <link rel="stylesheet" type="text/css" href="../../serviciosacademicos/estilos/sala.css">
        <link rel="stylesheet" href="../../serviciosacademicos/funciones/sala_genericas/ajax/ajaxtoolltip/css/ajax-tooltip.css" media="screen" type="text/css">
        <link rel="stylesheet" href="../../serviciosacademicos/funciones/sala_genericas/ajax/ajaxtoolltip/css/ajax-tooltip-demo.css" media="screen" type="text/css">

        <script type="text/javascript" src="../../serviciosacademicos/funciones/sala_genericas/funciones_javascript.js"></script>
        <style type="text/css">

            #ajax_tooltipObj .ajax_tooltip_arrow{	/* Left div for the small arrow */
                                                  background-image:url('../../serviciosacademicos/funciones/sala_genericas/ajax/ajaxtoolltip/images/arrow.gif');
                                                  width:20px;
                                                  position:absolute;
                                                  left:0px;
                                                  top:0px;
                                                  background-repeat:no-repeat;
                                                  background-position:left;
                                                  z-index:1000005;
                                                  height:60px;
            }
        </style>

        <script type="text/javascript" src="../../serviciosacademicos/funciones/sala_genericas/ajax/ajaxtoolltip/js/ajax-dynamic-content.js"></script>
        <script type="text/javascript" src="../../serviciosacademicos/funciones/sala_genericas/ajax/ajaxtoolltip/js/ajax.js"></script>
        <script type="text/javascript" src="../../serviciosacademicos/funciones/sala_genericas/ajax/ajaxtoolltip/js/ajax-tooltip.js"></script>

        <style type="text/css">@import url(../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
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
                    alert('Clave debe contener mas de 6 caracteres');
                    obj.value='';
                    obj.focus();
                }
            }
        </script>
    </head>
    <body>
<?php
echo "<form name=\"form1\" id=\"form1\" action=\"\" method=\"post\"  >
<input type=\"hidden\" name=\"AnularOK\" value=\"\">
	<table border=\"1\" cellpadding\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\">";
$formulario->dibujar_fila_titulo("<img src='../../imagenes/noticias_logo.gif'>", 'labelresaltado', "2", "align='center'");
$deshabilitarcorreo = "";
if ($activarclave) {
    $deshabilitarcorreo = "readonly=yes";
    $correo = $_GET['correo'];
    $campo = 'boton_tipo';
    $formulario->boton_tipo('hidden', 'idestudiantegeneral', $_GET['id'], '');
}

$formulario->dibujar_fila_titulo('Recuperacion de clave', 'labelresaltado', "2", "align='center'");

$formulario->dibujar_fila_titulo('Ingrese su correo personal', 'labelresaltado', "2", "align='left'");
$campo = 'boton_tipo';
$parametros = "'textfield','correo','" . $correo . "','" . $deshabilitarcorreo . "'";
$formulario->dibujar_campo($campo, $parametros, "E-mail", "tdtitulogris", 'correo', 'email');
if (!$activarclave) {
    $conboton = 0;
    $parametrobotonenviar[$conboton] = "'submit','Enviar','Enviar',''";
    $boton[$conboton] = 'boton_tipo';
    $conboton++;
    $formulario->dibujar_campos($boton, $parametrobotonenviar, "", "tdtitulogris", 'Enviar');
}



if ($activarclave) {
    $campo = 'boton_tipo';
    $parametros = "'password','clave','" . $clave . "','onchange=\"return validaLargoClave(this);\"'";
    $formulario->dibujar_campo($campo, $parametros, "Clave", "tdtitulogris", 'clave', 'requerido');

    $campo = 'boton_tipo';
    $parametros = "'password','confirmarclave','" . $confirmarclave . "','onchange=\"return validaLargoClave(this);\"'";
    $formulario->dibujar_campo($campo, $parametros, "Confirmar Clave", "tdtitulogris", 'confirmarclave', 'requerido');
    $conboton = 0;
    $parametrobotonenviar[$conboton] = "'submit','Modificar','Modificar Clave',''";
    $boton[$conboton] = 'boton_tipo';
    $conboton++;
    $formulario->dibujar_campos($boton, $parametrobotonenviar, "", "tdtitulogris", 'Enviar');
}

echo "</table>";
echo "</form>";

if (isset($_REQUEST['Enviar'])) {
    enviaCorreoRecuperacion($objetobase, $_POST['correo']);
}
if (isset($_REQUEST['Modificar'])) {
    $sigue = 1;
    $mensajealerta = "Algunos campos no han sido correctamente diligenciados:";
    if (!$formulario->valida_formulario()) {
        $sigue = 0;
    }
    if ($_POST['clave'] != $_POST['confirmarclave']) {
        $sigue = 0;
        $mensajealerta.="\\n-No coincide la confirmación de la clave ";
    }
    if ($sigue) {
        $tabla = "usuariopreinscripcion";
        $fila['idestudiantegeneral'] = $_POST['idestudiantegeneral'];
        $fila['usuariopreinscripcion'] = $_POST['correo'];
        //$fila['claveusuariopreinscripcion'] = md5($_POST['clave']);
        $fila['claveusuariopreinscripcion'] = md5($_POST['clave']);
        $fila['fechavencimientoclaveusuariopresinscripcion'] = '2099-12-31';
        $fila['fechavencimientousuariopresinscripcion'] = '2099-12-31';
        $condicion = " idestudiantegeneral=" . $fila['idestudiantegeneral'];
        $objetobase->insertar_fila_bd($tabla, $fila, 0, $condicion);
        $mensaje = "Su clave ha sido actualizada exitosamente,\\n puede ingresar en la siguiente pagina";
        alerta_javascript($mensaje);
        echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=" . ENLACEINGRESOASPIRANTE . "'>";
    } else {
        alerta_javascript($mensajealerta);
    }
}
?>

    </body>
</html>