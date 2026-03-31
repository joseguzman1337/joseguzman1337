<?php
session_start();
$rutaado=("../serviciosacademicos/funciones/adodb/");

//require_once("../serviciosacademicos/Connections/salaado-pear.php");
require_once('../serviciosacademicos/Connections/snies_conexion_postgresql.php');
require_once("../serviciosacademicos/funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../serviciosacademicos/funciones/sala_genericas/FuncionesCadena.php");
require_once("../serviciosacademicos/funciones/sala_genericas/FuncionesFecha.php");
require_once("../serviciosacademicos/funciones/clases/formulario/clase_formulario.php");
require_once("../serviciosacademicos/funciones/sala_genericas/formulariobaseestudiante.php");

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>

        <link rel="stylesheet" type="text/css" href="../serviciosacademicos/estilos/sala.css">
        <script type="text/javascript" src="../serviciosacademicos/funciones/javascript/funciones_javascript.js"></script>
        <style type="text/css">@import url(../serviciosacademicos/funciones/calendario_nuevo/calendar-win2k-1.css);</style>
        <script type="text/javascript" src="../serviciosacademicos/funciones/calendario_nuevo/calendar.js"></script>
        <script type="text/javascript" src="../serviciosacademicos/funciones/calendario_nuevo/calendar-es.js"></script>
        <script type="text/javascript" src="../serviciosacademicos/funciones/calendario_nuevo/calendar-setup.js"></script>
        <script type="text/javascript" src="../serviciosacademicos/funciones/clases/formulario/globo.js"></script>
        <link rel="stylesheet" href="../serviciosacademicos/funciones/sala_genericas/ajax/tab/css/tab-view.css" type="text/css" media="screen">
        <script type="text/javascript" src="../serviciosacademicos/funciones/sala_genericas/ajax/tab/js/ajax.js"></script>

        <script type="text/javascript" src="../serviciosacademicos/funciones/sala_genericas/ajax/tab/js/tab-view.js"></script>
        <script type="text/javascript" src="../serviciosacademicos/funciones/sala_genericas/ajax/requestxml.js"></script>
        <script LANGUAGE="JavaScript">
            function enviarnbccode(obj){
                var params="curso_code="+obj.name+"&nbc_code="+obj.value;
                process("actualizarnbcsnies.php",params);

            }
        </script>
        <?php

        echo "<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"900\">";
        echo "	<form id=\"form1\" name=\"form1\" action=\"\" method=\"post\"  enctype=\"multipart/form-data\"  >
		<input type=\"hidden\" name=\"AnularOK\" value=\"\">";


        $fechahoy=date("Y-m-d H:i:s");
        $formulario=new formulariobaseestudiante($snies_conexion,'form1','post','','true');
        $objetobase=new BaseDeDatosGeneral($snies_conexion);
        //$usuario=$formulario->datos_usuario();
        $formulario->dibujar_fila_titulo('ACTUALIZAR NBC DE CARRERA','labelresaltado',"2","align='center'");

        //$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("carrera", "codigocarrera", "nombrecarrera", "  codigomodalidadacademica like '2%' order by nombrecarrera" );
        //$formulario->filatmp[""]="Seleccionar";

        if($usuario["idusuario"]==4186) {
            //codigomodalidadacademica='".$_SESSION['admisiones_codigomodalidadacademica']."'
            $condicion="now()  between fechainiciocarrera and fechavencimientocarrera
			order by nombrecarrera2";
            $formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("carrera c","codigocarrera","nombrecarrera",$condicion," , replace(c.nombrecarrera,' ','') nombrecarrera2",0);
            $formulario->filatmp[""]="Seleccionar";
        }
        else {
            $condicion=" nivel_code='01'
                and estado_prog_code='01'
               order by prog_nombre";
            $formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("programa","pro_consecutivo","prog_nombre",$condicion,"",0);
            $formulario->filatmp[""]="Seleccionar";
        }
        $menu="menu_fila";
        $parametrosmenu="'codigocarrera','".$_POST['codigocarrera']."','onchange=\'enviar();\''";
        $formulario->dibujar_campo($menu,$parametrosmenu,"Carrera","tdtitulogris","codigocarrera","requerido");


if(isset($_POST['codigocarrera'])&&trim($_POST['codigocarrera'])!=''){
        $condicion=" and p.pro_consecutivo=pc.pro_consecutivo
                and pc.ies_code=p.ies_code
                and c.curso_code=pc.cod_curso
                order by c.curso_nombre";
        $tablas="plan_estudios p, plan_estudios_curso pc, curso c";
        $resultmaterias=$objetobase->recuperar_resultado_tabla($tablas, "p.pro_consecutivo", $_POST['codigocarrera'], $condicion,"",0);

        while($rowmateria=$resultmaterias->fetchRow()) {

        /*echo "<pre>";
        print_r($rowmateria);
        echo "</pre>";*/
            $condicion="";
            $formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("nbc","nbc_code","nbc_descr",$condicion);
            $formulario->filatmp[""]="Seleccionar";
            $menu="menu_fila";
            //$condicion.=" and em.idencuesta=e.idencuesta and em.codigomateria='".$rowmateria["codigomateria"]."'";
            $datoscursomateria=$objetobase->recuperar_datos_tabla("curso","curso_code",$rowmateria["cod_curso"],"","",0);

            $parametrosmenu="'".$datoscursomateria["curso_code"]."','".$datoscursomateria["nbc_code"]."','onchange=\'enviarnbccode(this);\''";
            $formulario->dibujar_campo($menu,$parametrosmenu,$datoscursomateria["curso_nombre"],"tdtitulogris","nbc_code","requerido");

        }
}
        echo "</form></table>";
        ?>
    </body>
</html>