<?php
session_start();
unset($_SESSION['codigomateriariesgo']);
unset($_SESSION['codigomodalidadacademicariesgo']);
unset($_SESSION['codigocarrerariesgo']);
unset($_SESSION['codigoperiodoriesgo']);
?>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">

<script LANGUAGE="JavaScript">
    function  ventanaprincipal(pagina){
        opener.focus();
        opener.location.href=pagina.href;
        window.close();
        return false;
    }
    function reCarga(){
        document.location.href="<?php echo '../matriculas/menu.php'; ?>";

    }
    function regresarGET()
    {
        document.location.href="<?php echo '../matriculas/menu.php'; ?>";
    }
    function enviarmenu()
    {
        form1.action="";
        form1.submit();
    }
</script>
<?php
$rutaado = ("../../../funciones/adodb/");
require_once("../../../funciones/clases/motorv2/motor.php");
require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../../funciones/sala_genericas/FuncionesMatriz.php");
require_once("../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
//require_once('../../../funciones/clases/autenticacion/redirect.php' ); 

$objetobase = new BaseDeDatosGeneral($sala);
$formulario = new formulariobaseestudiante($sala, 'form2', 'post', '', 'true');
?>
<form name="form1" action="riesgossemestredetalle.php" method="post">
    <input type="hidden" name="AnularOK" value="">
    <table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="750">
        <?php
        $formulario->dibujar_fila_titulo('ESTADISTICAS RIESGOS', 'labelresaltado', "2", "align='center'");


        $formulario->filatmp = $objetobase->recuperar_datos_tabla_fila("modalidadacademica f", "codigomodalidadacademica", "nombremodalidadacademica", "");
        //$formulario->filatmp["todos"]="*Todos*";
        $formulario->filatmp[""] = "Seleccionar";
        $campo = 'menu_fila';
        $parametros = "'codigomodalidadacademica','" . $_POST['codigomodalidadacademica'] . "','onchange=enviarmenu();'";
        $formulario->dibujar_campo($campo, $parametros, "Modalidad Academica", "tdtitulogris", 'codigomodalidadacademica', '');

        //$codigofacultad="05";
        $condicion = "c.codigomodalidadacademica='" . $_POST['codigomodalidadacademica'] . "'
				order by c.nombrecarrera";
        $formulario->filatmp = $objetobase->recuperar_datos_tabla_fila("carrera c", "codigocarrera", "nombrecarrera", $condicion, '', 0);
        $formulario->filatmp["todos"] = "*Todos*";
        $formulario->filatmp[""] = "Seleccionar";
        $campo = 'menu_fila';
        $parametros = "'codigocarrera','" . $_POST['codigocarrera'] . "','onchange=enviarmenu();'";
        $formulario->dibujar_campo($campo, $parametros, "Carrera", "tdtitulogris", 'codigocarrera', '');

        $formulario->filatmp["Alto"] = "Alto";
        $formulario->filatmp["Medio"] = "Medio";
        $formulario->filatmp["Bajo"] = "Bajo";
        $formulario->filatmp["Sin Riesgo"] = "Sin Riesgo";
        $campo = 'menu_fila';
        $parametros = "'riesgo','" . $_POST['riesgo'] . "','onchange=enviarmenu();'";
        $formulario->dibujar_campo($campo, $parametros, "Riesgo", "tdtitulogris", 'riesgo', '');
        
        unset($formulario->filatmp);
        for ($i = 1; $i < 13; $i++) {
            $formulario->filatmp[$i] = $i;
        }
        $campo = 'menu_fila';
        $parametros = "'semestre','" . $_POST['semestre'] . "','onchange=enviarmenu();'";
        $formulario->dibujar_campo($campo, $parametros, "Semestre", "tdtitulogris", 'semestre', '');

        $conboton = 0;
        $parametrobotonenviar[$conboton] = "'submit','Enviar','Enviar',''";
        $boton[$conboton] = 'boton_tipo';
        $conboton++;
        $parametrobotonenviar[$conboton] = "'button','Regresar','Regresar','onclick=\'regresarGET();\''";
        $boton[$conboton] = 'boton_tipo';
        $conboton++;
        $formulario->dibujar_campos($boton, $parametrobotonenviar, "", "tdtitulogris", 'Enviar');
        ?>
