<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);


$rutaado=("../../../../../funciones/adodb/");
require_once(realpath(dirname(__FILE__))."/../../../../../Connections/salaado-pear.php");
require_once(realpath(dirname(__FILE__))."/../../../../../funciones/clases/formulario/clase_formulario.php");
require_once(realpath(dirname(__FILE__))."/../../../../../funciones/phpmailer/class.phpmailer.php");
require_once(realpath(dirname(__FILE__))."/../../../../../funciones/validaciones/validaciongenerica.php");
require_once(realpath(dirname(__FILE__))."/../../../../../funciones/sala_genericas/FuncionesCadena.php");
require_once(realpath(dirname(__FILE__))."/../../../../../funciones/sala_genericas/FuncionesFecha.php");
require_once(realpath(dirname(__FILE__))."/../../../../../funciones/sala_genericas/FuncionesSeguridad.php");
require_once(realpath(dirname(__FILE__))."/../../../../../funciones/sala_genericas/FuncionesMatematica.php");
require_once(realpath(dirname(__FILE__))."/../../../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once(realpath(dirname(__FILE__))."/../../../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once(realpath(dirname(__FILE__))."/funcionvalidachequeoestudiante.php");
require_once(realpath(dirname(__FILE__))."/participacionacademica.php");
require_once(realpath(dirname(__FILE__))."/produccionintelectualestudiante.php");
require_once(realpath(dirname(__FILE__))."/participacioninvestigacion.php");
require_once(realpath(dirname(__FILE__))."/proyeccionsocialestudiante.php");
require_once(realpath(dirname(__FILE__))."/asociacionestudiante.php");
require_once(realpath(dirname(__FILE__))."/participacionbienestar.php");
require_once(realpath(dirname(__FILE__))."/participaciongobiernoestudiante.php");
require_once(realpath(dirname(__FILE__))."/participaciongestionestudiante.php");
require_once(realpath(dirname(__FILE__))."/reconocimientoestudiante.php");
$formulario=new formulariobaseestudiante($sala,"form1","post","","true");
//,'Los campos marcados con *, no han sido correctamente diligenciados:\n\n',"",false,"../../../../../funciones/sala_genericas/",0

//&$conexion,$nombre,$metodo,$accion="",$validar=false,$mensajegeneral='Los campos marcados con *, no han sido correctamente diligenciados:\n\n',$archivo_formulario="",$debug=false,$rutaraiz="../../../../",$scriptglobo=1
$formulario->rutaraiz="../../../../../funciones/sala_genericas/";


$objetobase=new BaseDeDatosGeneral($sala);


require_once('../../../../../Connections/sala2.php');
$rutaado = "../../../../../funciones/adodb/";
require_once('../../../../../Connections/salaado.php');
require_once('../../../../../funciones/sala/estudiante/estudiante.php');
require_once('../../../../../funciones/sala/inscripcion/inscripcion.php');
$ruta = "../../../../../funciones/sala/inscripcion/";

$idestudiantegeneral = $_SESSION['sissic_idestudiantegeneral'];
$estudiantegeneral = new estudiantegeneral($idestudiantegeneral);

$codigomodalidadacademica = 0;
$idsubperiodo = 0;
$idinscripcion = 0;
$inscripcion = new inscripcion($estudiantegeneral, $idsubperiodo, $idinscripcion,$codigomodalidadacademica);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
    <head>

        <link rel="stylesheet" type="text/css" href="../../../../../estilos/sala.css">
        <link rel="stylesheet" href="../../../../../funciones/sala_genericas/ajax/ajaxtoolltip/css/ajax-tooltip.css" media="screen" type="text/css">
        <link rel="stylesheet" href="../../../../../funciones/sala_genericas/ajax/ajaxtoolltip/css/ajax-tooltip-demo.css" media="screen" type="text/css">

        <script type="text/javascript" src="../../../../../funciones/sala_genericas/funciones_javascript.js"></script>
        <style type="text/css">

            #ajax_tooltipObj .ajax_tooltip_arrow{	/* Left div for the small arrow */
                                                  background-image:url('../../../../../funciones/sala_genericas/ajax/ajaxtoolltip/images/arrow.gif');
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

        <script type="text/javascript" src="../../../../../funciones/sala_genericas/ajax/ajaxtoolltip/js/ajax-dynamic-content.js"></script>
        <script type="text/javascript" src="../../../../../funciones/sala_genericas/ajax/ajaxtoolltip/js/ajax.js"></script>
        <script type="text/javascript" src="../../../../../funciones/sala_genericas/ajax/ajaxtoolltip/js/ajax-tooltip.js"></script>

        <style type="text/css">@import url(../../../../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
        <script type="text/javascript" src="../../../../../funciones/calendario_nuevo/calendar.js"></script>
        <script type="text/javascript" src="../../../../../funciones/calendario_nuevo/calendar-es.js"></script>
        <script type="text/javascript" src="../../../../../funciones/calendario_nuevo/calendar-setup.js"></script>
        <script type="text/javascript" src="../../../../../funciones/clases/formulario/globo.js"></script>
        <title>Servicios Academicos</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <script LANGUAGE="JavaScript">
            function selaprueba(obj,iditem){
                if(obj.checked==true)
                    window.parent.frames[1].cambiaEstadoAprobarImagen(true,iditem);
                else
                    window.parent.frames[1].cambiaEstadoAprobarImagen(false,iditem);
            }

            function selapruebadocente(obj,iditem){
                if(obj.checked==true)
                    window.parent.frames[1].cambiaEstadoRevisaImagen(true,iditem);
                else
                    window.parent.frames[1].cambiaEstadoRevisaImagen(false,iditem);
            }

            function calcular_edad()
            {
                var fecha = document.getElementById("fechaOK").value;
                var edad = document.getElementById("edadOK");
                //alert(fecha);
                now = new Date()
                bD = fecha.split('-');
                if(bD.length == 3)
                {
                    born = new Date(bD[0], bD[1]*1-1, bD[2]);
                    years = Math.floor((now.getTime() - born.getTime()) / (365.25 * 24 * 60 * 60 * 1000));
                }
                edad.value = years;
                return years;
            }
        </script>

    </head>
    <body>
        <?php
        echo "<form name=\"form1\" id=\"form1\" action=\"\" method=\"post\"  >
<input type=\"hidden\" name=\"AnularOK\" value=\"\">
	<table width=\"100%\" border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\">";

        //$usuario=$formulario->datos_usuario();

        //$condicion=" and d.codigoestado like '1%'";
        echo "<tr><td colspan=4>";
        $aprobarHV = false;
        $estudiantegeneral->imprimirFoto($aprobarHV);
        //muestrainformaciongeneral($objetobase,$formulario);
        echo "</td></tr>";
        $inscripcion->imprimirInformacionEstudios($aprobarHV);
        echo "<tr><td colspan=4> ";
        //nucleofamiliar($objetobase,$formulario);
        $inscripcion->imprimirOcupacionesExperiencia($aprobarHV);
        echo "</td></tr>";
        echo "<tr><td colspan=4> ";
        //contrato($objetobase,$formulario);
        $inscripcion->imprimirInformacionFinanciera($aprobarHV);
        echo "</td></tr>";
        echo "<tr><td colspan=4> ";
        //participacionuniversitaria($objetobase,$formulario);
        $inscripcion->imprimirInformacionIdiomas($aprobarHV);
        echo "</td></tr>";

        echo "<tr><td colspan=4> ";
        //actividadlaboral($objetobase,$formulario);
        $inscripcion->imprimirActividadesDestacar($aprobarHV);
        echo "</td></tr>";
        echo "<tr><td colspan=4> ";
        //lineainvestigacion($objetobase,$formulario);
        $inscripcion->imprimirInformacionFamiliar($aprobarHV);
        echo "</td></tr>";
        echo "<tr><td colspan=4> ";
        participacionacademica($objetobase,$formulario);
        echo "</td></tr>";
        echo "<tr><td colspan=4> ";
        publicaciones($objetobase,$formulario);
        echo "</td></tr>";
        echo "<tr><td colspan=4> ";
        participacioninvestigacion($objetobase,$formulario);
        echo "</td></tr>";
        echo "<tr><td colspan=4> ";
        proyeccionsocial($objetobase,$formulario);
        echo "</td></tr>";
        echo "<tr><td colspan=4> ";
        asociacionestudiante($objetobase,$formulario);
        echo "</td></tr>";
        echo "<tr><td colspan=4> ";
        participacionbienestar($objetobase,$formulario);
        echo "</td></tr>";
        echo "<tr><td colspan=4> ";
        participaciongobierno($objetobase,$formulario);
        echo "</td></tr>";
        echo "<tr><td colspan=4> ";
        participaciongestion($objetobase,$formulario);
        echo "</td></tr>";
        echo "<tr><td colspan=4> ";
        reconocimientos($objetobase,$formulario);
        echo "</td></tr>";

        echo "</table>";
        echo "</form>";
        ?>
    </body>
</html>
<script type="text/javascript">
    calcular_edad();
</script>