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
/* echo "_SESSION<pre>";
  print_r($_SESSION);
  echo "</pre>"; */
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
            var ctrltecla=0;
            var teclapaste=0;

            function presionaTeclas(evento,obj){
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
                //alert("keypress="+keycaracter+"\ncaracter="+caracter);
                if(keycaracter==17||keycaracter==16){
                    ctrltecla=1;
                    alert("key="+keycaracter+"\ncaracter="+caracter);
                }
                if(keycaracter==118||keycaracter==86||keycaracter==45){
                    teclapaste=1;
                    //alert("keypaste="+keycaracter+"\ncaracter="+caracter);
                }
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
                /*if((keycaracter==17||keycaracter==16)&&teclapaste==1){
                    alert("keyup="+keycaracter+"\ncaracter="+caracter);
                    teclapaste=0;
                }*/
                if((keycaracter==17||keycaracter==16)&&teclapaste==1){
                    //alert("keyup="+keycaracter+"\ncaracter="+caracter);
                    obj.value='';
                    ctrltecla=0;
                    teclapaste=0;
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
	<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\">";
        $idtrato = $_POST['idtrato'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $documento = $_POST['documento'];
        $tipodocumento = $_POST['tipodocumento'];
        $correo = $_POST['correo'];
        $confirmacorreo = $_POST['confirmacorreo'];
        $fechanacimiento = $_POST['fechanacimiento'];
        $codigogenero = $_POST['codigogenero'];
        $telefonoresidencia = $_POST['telefonoresidencia'];
        $telefonooficina = $_POST['telefonooficina'];
        $telefonoresidencia = $_POST['telefonoresidencia'];
        $celular = $_POST['celular'];


        $formulario->dibujar_fila_titulo("<img src='../../imagenes/noticias_logo.gif'>", 'labelresaltado', "2", "align='center'");
        $formulario->dibujar_fila_titulo('Registro Usuario Aspirante Paso Uno', 'labelresaltado', "2", "align='center'");
        if (!$_GET['completado']) {
            $formulario->dibujar_fila_titulo('Datos Basicos', 'labelresaltado', "2", "align='left'");
            $formulario->filatmp = $objetobase->recuperar_datos_tabla_fila("trato", "idtrato", "nombretrato", ' 1=1 order by nombretrato', '', 0);
            $formulario->filatmp[""] = "Seleccionar";
            $campo = 'menu_fila';
            $parametros = "'idtrato','" . $idtrato . "',''";
            $formulario->dibujar_campo($campo, $parametros, "Trato", "tdtitulogris", 'idtrato', 'requerido');

            $campo = 'boton_tipo';
            $parametros = "'textfield','nombre','" . $nombre . "',''";
            $formulario->dibujar_campo($campo, $parametros, "Nombres", "tdtitulogris", 'nombre', 'requerido');
            $campo = 'boton_tipo';
            $parametros = "'textfield','apellido','" . $apellido . "',''";
            $formulario->dibujar_campo($campo, $parametros, "Apellidos", "tdtitulogris", 'apellido', 'requerido');
            $campo = 'boton_tipo';
            $parametros = "'textfield','documento','" . $documento . "',''";
            $formulario->dibujar_campo($campo, $parametros, "Documento", "tdtitulogris", 'documento', 'numero');

            $formulario->filatmp = $objetobase->recuperar_datos_tabla_fila("documento", "tipodocumento", "nombredocumento", ' 1=1 order by nombredocumento', '', 0);
            $formulario->filatmp[""] = "Seleccionar";
            $campo = 'menu_fila';
            $parametros = "'tipodocumento','" . $tipodocumento . "',''";
            $formulario->dibujar_campo($campo, $parametros, "Tipo de documento", "tdtitulogris", 'tipodocumento', 'requerido');

            $campo = 'campo_fecha';
            $parametros = "'textfield','fechanacimiento','" . $fechanacimiento . "','onKeyUp = \"this.value=formateafecha(this.value);\"'";
            $formulario->dibujar_campo($campo, $parametros, "Fecha de nacimiento(dd/mm/aaaa)", "tdtitulogris", 'fechanacimiento', 'fechanacimiento');

            $formulario->filatmp = $objetobase->recuperar_datos_tabla_fila("genero", "codigogenero", "nombregenero", ' 1=1 order by nombregenero', '', 0);
            $formulario->filatmp[""] = "Seleccionar";
            $campo = 'menu_fila';
            $parametros = "'codigogenero','" . $codigogenero . "',''";
            $formulario->dibujar_campo($campo, $parametros, "Genero", "tdtitulogris", 'codigogenero', 'requerido');

            $campo = 'boton_tipo';
            $parametros = "'textfield','telefonoresidencia','" . $telefonoresidencia . "',''";
            $formulario->dibujar_campo($campo, $parametros, "Telefono de residencia", "tdtitulogris", 'telefonoresidencia', 'requerido');

           /* $campo = 'boton_tipo';
            $parametros = "'textfield','telefonooficina','" . $telefonooficina . "',''";
            $formulario->dibujar_campo($campo, $parametros, "Telefono de oficina", "tdtitulogris", 'telefonooficina', '');
*/
            $campo = 'boton_tipo';
            $parametros = "'textfield','celular','" . $celular . "',''";
            $formulario->dibujar_campo($campo, $parametros, "Celular", "tdtitulogris", 'celular', '');


            $formulario->dibujar_fila_titulo('Informacion de su cuenta de usuario', 'labelresaltado', "2", "align='left'");

           $mensaje = "Por favor verifique que su E-mail este escrito correctamente" .
                    " ya que no podra completar su registro si presenta algún error ";

            $formulario->dibujar_fila_titulo($mensaje, 'tdtitulogris', "2", "align='left'", "td");


            $campo = 'boton_tipo';
            $parametros = "'textfield','correo','" . $correo . "',''";
            $formulario->dibujar_campo($campo, $parametros, "E-mail", "tdtitulogris", 'correo', 'email');

 
            $campo = 'boton_tipo';
            $parametros = "'textfield','confirmacorreo','" . $confirmacorreo . "','onkeypress=\"presionaTeclas(event,this)\" onkeyup=\"return evitaCopiaEmail(event,this);\"  oncontextmenu=\"return false;\"'";
            $formulario->dibujar_campo($campo, $parametros, "Confirmar E-mail", "tdtitulogris", 'confirmacorreo', 'email');


            $mensaje = "Su nombre de usuario es la dirección de correo electrónico " .
                    "que acaba de ingresar";


            $formulario->dibujar_fila_titulo($mensaje, 'tdtitulogris', "2", "align='left'", "td");


            $campo = 'boton_tipo';
            $parametros = "'password','clave','" . $clave . "','onchange=\"return validaLargoClave(this);\"'";
            $formulario->dibujar_campo($campo, $parametros, "Clave", "tdtitulogris", 'clave', 'requerido');

           $mensaje = "La clave debe tener mínimo 6 caracteres ";

            $formulario->dibujar_fila_titulo($mensaje, 'tdtitulogris', "2", "align='left'", "td");

            $campo = 'boton_tipo';
            $parametros = "'password','confirmarclave','" . $confirmarclave . "','onchange=\"return validaLargoClave(this);\"'";
            $formulario->dibujar_campo($campo, $parametros, "Confirmar Clave", "tdtitulogris", 'confirmarclave', 'requerido');

            $campo = 'captcha';
            $parametros = "'clavecaptcha','" . $clavecaptcha . "',''";
            $formulario->dibujar_campo($campo, $parametros, "Digitar codigo de la imagen", "tdtitulogris", 'clavecaptcha', 'requerido');



            $conboton = 0;
            $parametrobotonenviar[$conboton] = "'submit','Enviar','Enviar',''";
            $boton[$conboton] = 'boton_tipo';
            $conboton++;
            $formulario->dibujar_campos($boton, $parametrobotonenviar, "", "tdtitulogris", 'Enviar');
        } else {
            $mensaje = "<br><br>Revise su correo personal inscrito en el " .
                    "anterior formulario para continuar con el proceso de inscripción," .
                    " es posible que el mensaje llegue a su bandeja de correo no deseado" .
                    "<br><br><b>Gracias por su amable colaboración</b>";
            $formulario->dibujar_fila_titulo($mensaje, 'tdtituloencuestadescripcion', "2", "align='center'");
        }

        echo "</table>";
        echo "</form>";
        if (isset($_REQUEST['Enviar'])) {
            $sigue = 1;
            $mensajealerta = "Algunos campos no han sido correctamente diligenciados:";
            if (!$formulario->valida_formulario()) {
                $sigue = 0;
            }
            if ($securimage->check($_POST['clavecaptcha']) == false) {
                $mensajealerta.="\\n-Es necesario digitar el mismo codigo de la imagen";
                $sigue = 0;
            }
            if ($_POST['correo'] != $_POST['confirmacorreo']) {
                $sigue = 0;
                $mensajealerta.="\\n-No coincide la confirmación del correo";
            }
            if ($_POST['clave'] != $_POST['confirmarclave']) {
                $sigue = 0;
                $mensajealerta.="\\n-No coincide la confirmación de la clave ";
            }
            if ($datoscorreo = $objetobase->recuperar_datos_tabla("estudiantegeneral", "emailestudiantegeneral", $_POST['correo'])) {
                $sigue = 0;
                $mensajealerta.="\\n-Direccion de correo " . $_POST['correo'] . "  ya se encuentra registrado actualmente";
            }


            if ($sigue) {
                $tabla = "estudianteinscripciontemporal";
                $fila["idtrato"] = $_POST['idtrato'];
                $fila["nombres" . $tabla] = strtoupper($_POST['nombre']);
                $fila["apellidos" . $tabla] = strtoupper($_POST['apellido']);
                $fila["correo" . $tabla] = $_POST['correo'];
                //$fila["clave" . $tabla] = md5($_POST['clave']);
                $fila["clave" . $tabla] = hash('sha256', $_POST['clave']);
                $fila["tipodocumento"] = $_POST['tipodocumento'];
                $fila["documento" . $tabla] = $_POST['documento'];
                $fila["codigogenero"] = $_POST['codigogenero'];
                $fila["fechanacimiento" . $tabla] = formato_fecha_mysql($_POST['fechanacimiento']);
                $fila["telefonoresidencia" . $tabla] = $_POST['telefonoresidencia'];
                $fila["telefonooficina" . $tabla] = '0';
                $fila["celular" . $tabla] = $_POST['celular'];



                $fila["codigoestado"] = "200";
                $condicion = " tipodocumento=" . $_POST['tipodocumento'] .
                        " and documento" . $tabla . "=" . $_POST['documento'];
                $objetobase->insertar_fila_bd($tabla, $fila, $imprimir, $condicion);
                enviaCorreoActivacion($objetobase, $_POST['tipodocumento'], $_POST['documento'], $_POST['clave']);
                $mensaje = "Felicitaciones ya completo el paso uno" .
                        "\\n revise su correo " . $_POST['correo'] .
                        " para continuar con el proceso de inscripción";

                alerta_javascript($mensaje);
                echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=registrarpasouno.php?completado=1'>";
            } else {
                alerta_javascript($mensajealerta);
            }
        }
        ?>

    </body>
</html>