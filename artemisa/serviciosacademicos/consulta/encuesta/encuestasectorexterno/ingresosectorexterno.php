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
                <table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="750">

                    <?php
                    $formulario->dibujar_fila_titulo('<b>PROCESO DE AUTOEVALUACI&Oacute;N INSTITUCIONAL Y DE PROGRAMAS</b><br>Instrumentos de evaluación', 'labelresaltado', "2", "align='center'");


                    $formulario->filatmp = $objetobase->recuperar_datos_tabla_fila("carrera c", "codigocarrera", "nombrecarrera", "codigocarrera in (10,11)", '', 0);
                    $campo = 'menu_fila';
                    $parametros = "'codigocarrera','" . $_POST['codigocarrera'] . "'";
                    $formulario->dibujar_campo($campo, $parametros, "Seleccione programa", "tdtitulogris", 'codigocarrera', 'requerido');

                    $conboton = 0;
                    $parametrobotonenviar[$conboton] = "'submit','Enviar','Enviar',''";
                    $boton[$conboton] = 'boton_tipo';
                    $conboton++;
                    $formulario->dibujar_campos($boton, $parametrobotonenviar, "", "tdtitulogris", 'Enviar', '', 0);
                                            

                    if (isset($_REQUEST['Enviar'])) 
		    	echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=encuestasectorexterno.php?codigocarrera=" . $_POST['codigocarrera'] . "&idusuario=" . uniqid(rand()) . "'>";

                    ?>

                </table>
            </form></td>
    </tr>
</table>

