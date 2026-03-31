<?php
session_start();
/*ini_set('display_errors', 'On');
error_reporting(E_ALL);*/
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
$formulario = new formulariobaseestudiante($sala, "form1", "post", "", "true");
$formulario->rutaraiz = "../../serviciosacademicos/funciones/sala_genericas/";
$objetobase = new BaseDeDatosGeneral($sala);
$securimage = new Securimage();
$lang = "es-es";
if(isset($_GET["lang"])&&$_GET["lang"]!=""){
    $lang = $_GET["lang"];
}
/* echo "_SESSION<pre>";
  print_r($_SESSION);
  echo "</pre>"; */
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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

        <link rel="stylesheet" type="text/css" href="../../funciones/calendario_nuevo/calendar-win2k-1.css">
        <script type="text/javascript" src="../../serviciosacademicos/funciones/calendario_nuevo/calendar.js"></script>
        <?php if ($lang==="es-es") { ?>
        <script type="text/javascript" src="../../serviciosacademicos/funciones/calendario_nuevo/calendar-es.js"></script>
        <?php } else { ?>
        <script type="text/javascript" src="../../serviciosacademicos/funciones/calendario_nuevo/calendar-<?php echo $lang; ?>.js"></script>
        <?php } ?>
        <script type="text/javascript" src="../../serviciosacademicos/funciones/calendario_nuevo/calendar-setup.js"></script>
        <script type="text/javascript" src="../../serviciosacademicos/funciones/clases/formulario/globo.js"></script>
		<!--llamado a jquery-->
		<script type="text/javascript" src="../../www/nuevosala/proyecto/serviciosacademicos/mgi/js/jquery.min.js"></script>
        <title>Servicios Academicos</title>
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

            /* borrado 04/03/2016
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
                /*if((keycaracter==17||keycaracter==16)&&teclapaste==1){
                    //alert("keyup="+keycaracter+"\ncaracter="+caracter);
                    obj.value='';
                    ctrltecla=0;
                    teclapaste=0;
                    return false;

                }
                else{
                    return true;
                }
               
            }*/
			$(function(){ $(document).on("cut copy paste","#confirmacorreo",function(e) { e.preventDefault(); }); });
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


        $formulario->dibujar_fila_titulo("<img src='../../imagenes/noticias_logo_".$lang.".png'>", 'labelresaltado', "2", "align='center'");
		$formulario->dibujar_fila_titulo(localize('Registro Usuario Aspirante Paso Uno',$lang), 'labelresaltado', "2", "align='center'");
        if (!$_GET['completado']) {
            $formulario->dibujar_fila_titulo(localize('Datos Básicos',$lang), 'labelresaltado', "2", "align='left'");
            $formulario->filatmp = $objetobase->recuperar_datos_tabla_fila("trato", "idtrato", "nombretrato", ' 1=1 order by nombretrato', '', 0);
            $formulario->filatmp[""] = localize("Seleccionar",$lang);
            $campo = 'menu_fila';
            //  $parametros = "'idtrato','" . $idtrato . "',''";
            //$formulario->dibujar_campo($campo, $parametros, "Trato", "tdtitulogris", 'idtrato', 'requerido');

            $campo = 'boton_tipo';
            $parametros = "'textfield','nombre','" . $nombre . "',''";
            $formulario->dibujar_campo($campo, $parametros, localize("Nombres",$lang), "tdtitulogris", 'nombre', 'requerido');
            $campo = 'boton_tipo';
            $parametros = "'textfield','apellido','" . $apellido . "',''";
            $formulario->dibujar_campo($campo, $parametros, localize("Apellidos",$lang), "tdtitulogris", 'apellido', 'requerido');
						
            if($lang=="es-es"){
                $formulario->filatmp = $objetobase->recuperar_datos_tabla_fila("pais", "idpais", "nombrepais", ' codigoestado like \'%1%\' order by nombrepais', '', 0);
            }
			if($idpaisnacimiento==null){
				$idpaisnacimiento = 1;
			}
            
            $campo = 'menu_fila';
            $parametros = "'idpaisnacimiento','" . $idpaisnacimiento . "',''";
            $formulario->dibujar_campo($campo, $parametros, localize("País de nacimiento",$lang), "tdtitulogris", 'idpaisnacimiento', 'requerido');
			
            $campo = 'boton_tipo';
            $parametros = "'textfield','documento','" . $documento . "',''";
            $formulario->dibujar_campo($campo, $parametros, localize("Documento",$lang), "tdtitulogris", 'documento', 'numero');

            if($lang=="es-es"){
                $formulario->filatmp = $objetobase->recuperar_datos_tabla_fila("documento", "tipodocumento", "nombredocumento", ' codigoestado like \'%1%\' order by nombredocumento', '', 0);
            } else {
                $sql = "SELECT g.tipodocumento, gt.nombredocumento FROM documento g INNER JOIN documento_traducciones gt ON gt.tipodocumento=g.tipodocumento AND lenguaje='".$lang."' AND g.codigoestado like '%1%' order by gt.nombredocumento";
                
                $rows = $sala->GetAll($sql);
                $num = count($rows);
                $resultado = array();
                for ($i = 0; $i < $num; $i++){
                    $resultado[$rows[$i]["tipodocumento"]] = $rows[$i]["nombredocumento"];
                }
                $formulario->filatmp = $resultado;
                $formulario->filatmp[""] = localize("Seleccionar",$lang);
            }
            
            $campo = 'menu_fila';
            $parametros = "'tipodocumento','" . $tipodocumento . "',''";
            $formulario->dibujar_campo($campo, $parametros, localize("Tipo de documento",$lang), "tdtitulogris", 'tipodocumento', 'requerido');

            $campo = 'campo_fecha_nacimiento';
            $parametros = "'textfield','fechanacimiento','" . $fechanacimiento . "','onKeyUp = \"this.value=formateafecha(this.value);\"'";
            $formulario->dibujar_campo($campo, $parametros, localize("Fecha de nacimiento(dd/mm/aaaa)",$lang), "tdtitulogris", 'fechanacimiento', 'fechanacimiento');

            if($lang=="es-es"){
                $formulario->filatmp = $objetobase->recuperar_datos_tabla_fila("genero", "codigogenero", "nombregenero", ' 1=1 order by nombregenero', '', 0);
            } else {
                $sql = "SELECT g.codigogenero, gt.nombregenero FROM genero g INNER JOIN genero_traducciones gt ON gt.codigogenero=g.codigogenero AND lenguaje='".$lang."' order by gt.nombregenero";
                $rows = $sala->GetAll($sql);
                $num = count($rows);
                $resultado = array();
                for ($i = 0; $i < $num; $i++){
                    $resultado[$rows[$i]["codigogenero"]] = $rows[$i]["nombregenero"];
                }
                $formulario->filatmp = $resultado;
            }
            $formulario->filatmp[""] = localize("Seleccionar",$lang);            
            $campo = 'menu_fila';
            $parametros = "'codigogenero','" . $codigogenero . "',''";
            $formulario->dibujar_campo($campo, $parametros, localize("Genero",$lang), "tdtitulogris", 'codigogenero', 'requerido');

            $campo = 'boton_tipo';
            $parametros = "'textfield','telefonoresidencia','" . $telefonoresidencia . "',''";
            $formulario->dibujar_campo($campo, $parametros, localize("Teléfono de residencia",$lang), "tdtitulogris", 'telefonoresidencia', 'requerido');

            /* $campo = 'boton_tipo';
              $parametros = "'textfield','telefonooficina','" . $telefonooficina . "',''";
              $formulario->dibujar_campo($campo, $parametros, "Telefono de oficina", "tdtitulogris", 'telefonooficina', '');
             */
            $campo = 'boton_tipo';
            $parametros = "'textfield','celular','" . $celular . "',''";
            $formulario->dibujar_campo($campo, $parametros, localize("Celular",$lang), "tdtitulogris", 'celular', '');


            $formulario->dibujar_fila_titulo(localize('Información de su cuenta de usuario',$lang), 'labelresaltado', "2", "align='left'");

            $mensaje = localize("Por favor verifique que su E-mail este escrito correctamente" .
                    " ya que no podra completar su registro si presenta algún error." .
                    " Recuerde que esta dirección tambien se utilizara para mantenerlo " .
                    " informado durante todo su proceso de inscripción",$lang);

            $formulario->dibujar_fila_titulo($mensaje, 'tdtitulogris', "2", "align='left'", "td");


            $campo = 'boton_tipo';
            $parametros = "'textfield','correo','" . $correo . "',''";
            $formulario->dibujar_campo($campo, $parametros, localize("E-mail",$lang), "tdtitulogris", 'correo', 'email');


            $campo = 'boton_tipo';
            $parametros = "'textfield','confirmacorreo','" . $confirmacorreo . "','onkeypress=\"presionaTeclas(event,this)\" onkeyup=\"return evitaCopiaEmail(event,this);\"  oncontextmenu=\"return false;\"'";
            $formulario->dibujar_campo($campo, $parametros, localize("Confirmar E-mail",$lang), "tdtitulogris", 'confirmacorreo', 'email');


            $mensaje = localize("Su nombre de usuario es la dirección de correo electrónico " .
                    "que acaba de ingresar",$lang);


            $formulario->dibujar_fila_titulo($mensaje, 'tdtitulogris', "2", "align='left'", "td");


            $campo = 'boton_tipo';
            $parametros = "'password','clave','" . $clave . "','onchange=\"return validaLargoClave(this);\"'";
            $formulario->dibujar_campo($campo, $parametros, localize("Clave",$lang), "tdtitulogris", 'clave', 'requerido');

            $mensaje = localize("La clave debe tener mínimo 6 caracteres",$lang);

            $formulario->dibujar_fila_titulo($mensaje, 'tdtitulogris', "2", "align='left'", "td");

            $campo = 'boton_tipo';
            $parametros = "'password','confirmarclave','" . $confirmarclave . "','onchange=\"return validaLargoClave(this);\"'";
            $formulario->dibujar_campo($campo, $parametros, localize("Confirmar Clave",$lang), "tdtitulogris", 'confirmarclave', 'requerido');

//            $campo = 'captcha';
//            $parametros = "'clavecaptcha','" . $clavecaptcha . "',''";
//            $formulario->dibujar_campo($campo, $parametros, "Digitar codigo de la imagen", "tdtitulogris", 'clavecaptcha', 'requerido');

            $conboton = 0;
            $parametrobotonenviar[$conboton] = "'submit','Enviar',".localize('Enviar',$lang).",''";
            $boton[$conboton] = 'boton_tipo';
            $conboton++;
            $formulario->dibujar_campos($boton, $parametrobotonenviar, "", "tdtitulogris", 'Enviar');
        } else {
            $mensaje = "<br><br>".localize("Revise su correo personal inscrito en el " .
                    "anterior formulario para continuar con el proceso de inscripción," .
                    " es posible que el mensaje llegue a su bandeja de correo no deseado",$lang) .
                    "<br><br><b>".localize("Gracias por su amable colaboración",$lang) ."</b>";
            $formulario->dibujar_fila_titulo($mensaje, 'tdtituloencuestadescripcion', "2", "align='center'");
        }
		echo "</table>";
        echo "</form>";
		
		
        if (isset($_REQUEST['Enviar'])) {
            $sigue = 1;
            $mensajealerta = localize("Algunos campos no han sido correctamente diligenciados",$lang).":";
            if (!$formulario->valida_formularioLocalizado($lang)) {
                $sigue = 0;
            }
//            if ($securimage->check($_POST['clavecaptcha']) == false) {
//                $mensajealerta.="\\n-Es necesario digitar el mismo codigo de la imagen";
//                $sigue = 0;
//            }
            if ($_POST['correo'] != $_POST['confirmacorreo']) {
                $sigue = 0;
                $mensajealerta.="\\n-".localize("No coincide la confirmación del correo",$lang)."";
            }
            if ($_POST['clave'] != $_POST['confirmarclave']) {
                $sigue = 0;
                $mensajealerta.="\\n-".localize("No coincide la confirmación de la clave",$lang)." ";
            }
			if($_POST["tipodocumento"]=="01" && $_POST["codigogenero"]=="100" && strlen($_POST["documento"])!=10 && strlen($_POST["documento"])!=8){
                $sigue = 0;
                $mensajealerta.="\\n- Por favor verificar el número de documento debido a que no tiene una longitud válida.";
			}
			if($_POST["idpaisnacimiento"]=="1" && ($_POST["tipodocumento"]=="10" || $_POST["tipodocumento"]=="11" || $_POST["tipodocumento"]=="09")){
                $sigue = 0;
                $mensajealerta.="\\n- Por favor verificar el tipo de documento debido a que no es válido para el país indicado.";
			}
			if($_POST["tipodocumento"]=="01" && $_POST["codigogenero"]=="100" && strlen($_POST["documento"])==8 && 
					(intval($_POST["documento"])<20000000 || intval($_POST["documento"])>69999999) ){
                $sigue = 0;
                $mensajealerta.="\\n- Por favor verificar el número de documento debido a que no coincide con el tipo (el valor no es válido).";
			}
			if($_POST["tipodocumento"]=="01" && $_POST["codigogenero"]=="200" && strlen($_POST["documento"])!=3 && 
			strlen($_POST["documento"])!=4 && strlen($_POST["documento"])!=5 && strlen($_POST["documento"])!=6 && strlen($_POST["documento"])!=7
			&& strlen($_POST["documento"])!=8 && strlen($_POST["documento"])!=10){
                $sigue = 0;
                $mensajealerta.="\\n- Por favor verificar el número de documento debido a que no tiene una longitud válida.";
			}
			if($_POST["tipodocumento"]=="03" && strlen($_POST["documento"])<7){
                $sigue = 0;
                $mensajealerta.="\\n- Por favor verificar el número de documento debido a que no tiene una longitud válida.";
			}
			if($_POST["tipodocumento"]=="02" && strlen($_POST["documento"])!=11 && strlen($_POST["documento"])!=10){
                $sigue = 0;
                $mensajealerta.="\\n- Por favor verificar el número de documento debido a que no coincide con el tipo.";
			}
            if ($datoscorreo = $objetobase->recuperar_datos_tabla("estudiantegeneral", "emailestudiantegeneral", $_POST['correo'])) {
                $sigue = 0;
                $mensajealerta.="\\n- ".localize("Direccion de correo",$lang). " " . $_POST['correo'] . " ".localize("ya se encuentra registrado actualmente",$lang);
            }
			$nombre = explode(" ",trim($_POST["nombre"]));
			$nombre = $nombre[0];
			$apellido = trim($_POST["apellido"]);
			//$apellido = explode(" ",$_POST["apellido"]);
			//$apellido = $apellido[0];
			
			$time = strtotime(formato_fecha_mysql($_POST["fechanacimiento"]));
			$newFECHA = date('Y-m-d',$time);

			$datosEstudiante = $sala->GetRow("SELECT emailestudiantegeneral,numerodocumento,DATE(fechanacimientoestudiantegeneral) as fecha
									FROM estudiantegeneral 
									WHERE nombresestudiantegeneral LIKE '".$nombre."%' AND apellidosestudiantegeneral LIKE '%".$apellido."%' 
									AND fechanacimientoestudiantegeneral='".$newFECHA."'");
			if(count($datosEstudiante)>0){
                $sigue = 0;
                $mensajealerta.="\\n- ".localize("ya se encuentra registrado actualmente",$lang)." con ".localize("Direccion de correo",$lang). " " . $datosEstudiante['emailestudiantegeneral'];			
			}

            if ($sigue) {
                $tabla = "estudianteinscripciontemporal";
                $fila["idtrato"] = '1';
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
                $fila["idpaisnacimiento"] = $_POST["idpaisnacimiento"];



                $fila["codigoestado"] = "200";
                $condicion = " tipodocumento=" . $_POST['tipodocumento'] .
                        " and documento" . $tabla . "=" . $_POST['documento'];
                $objetobase->insertar_fila_bd($tabla, $fila, $imprimir, $condicion);
                enviaCorreoActivacion($objetobase, $_POST['tipodocumento'], $_POST['documento'], $_POST['clave']);
                $mensaje = localize("Felicitaciones ya completo el paso 1. Genere su clave",$lang) .
                        "\\n ".localize("revise su correo",$lang) ." " . $_POST['correo'] ." ".
                        localize("para continuar con el proceso de inscripción y activar su cuenta",$lang);

                $condicion = " and tipodocumento='" . $fila["tipodocumento"] . "'" .
                        " and documentoestudianteinscripciontemporal='" . $_POST['documento'] . "'";
                $datosestudiante = $objetobase->recuperar_datos_tabla("estudianteinscripciontemporal ei", "1", "1", $condicion, "");
$mktimeactiva = mktime();
//"http://172.16.36.5/aspirantes/usuarioaspirante/registrarpasodos.php" en vez de ENLACEACTIVACION para pruebas
                $urlactivacion = ENLACEACTIVACION .
                        "?ta=" . $mktimeactiva .
                        "&id=" . $datosestudiante["idestudianteinscripciontemporal"] .
                        "&correo=" . $datosestudiante["correoestudianteinscripciontemporal"]."&lang=".$lang;

                // alerta_javascript($mensaje);
                echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=$urlactivacion'>";
            } else {
                alerta_javascript($mensajealerta);
            }
        }
        ?>

    </body>
</html>