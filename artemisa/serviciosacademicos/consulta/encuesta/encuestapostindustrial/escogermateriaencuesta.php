<?php
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

//session_start();
$rutaado=("../../../funciones/adodb/");

require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../funciones/sala_genericas/formulariobaseestudiante.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>

        <link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
        <script type="text/javascript" src="../../../funciones/javascript/funciones_javascript.js"></script>
        <style type="text/css">@import url(../../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
        <script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar.js"></script>
        <script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-es.js"></script>
        <script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-setup.js"></script>
        <script type="text/javascript" src="../../../funciones/clases/formulario/globo.js"></script>
        <link rel="stylesheet" href="../../../funciones/sala_genericas/ajax/tab/css/tab-view.css" type="text/css" media="screen">
        <script type="text/javascript" src="../../../funciones/sala_genericas/ajax/tab/js/ajax.js"></script>

        <script type="text/javascript" src="../../../funciones/sala_genericas/ajax/tab/js/tab-view.js"></script>
        <script type="text/javascript" src="../../../funciones/sala_genericas/ajax/requestxml.js"></script>
        <script LANGUAGE="JavaScript">
            function enviarencuestamateria(obj){
                var params="codigomateria="+obj.name+"&idencuesta="+obj.value;
                process("actualizaencuestamateria.php",params);

            }
        </script>
        <?php

        echo "<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\">";
        echo "	<form id=\"form1\" name=\"form1\" action=\"\" method=\"post\"  enctype=\"multipart/form-data\"  >
		<input type=\"hidden\" name=\"AnularOK\" value=\"\">
		<input type=\"hidden\" name=\"idencuesta\" value=\"".$idencuestaaleatorio."\">";


        $fechahoy=date("Y-m-d H:i:s");
        $formulario=new formulariobaseestudiante($sala,'form1','post','','true');
        $objetobase=new BaseDeDatosGeneral($sala);
        $usuario=$formulario->datos_usuario();
        $formulario->dibujar_fila_titulo('Carrera ','labelresaltado',"2","align='center'");

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
            $condicion=" c.codigocarrera=uf.codigofacultad
					and u.idusuario='".$usuario["idusuario"]."'
					and uf.usuario=u.usuario
					and now()  between fechainiciocarrera and fechavencimientocarrera
					order by nombrecarrera2";
            $formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("carrera c, usuariofacultad uf, usuario u","c.codigocarrera","c.nombrecarrera",$condicion," , replace(c.nombrecarrera,' ','') nombrecarrera2",0);
            $formulario->filatmp[""]="Seleccionar";
        }
        $menu="menu_fila";
        $parametrosmenu="'codigocarrera','".$_POST['codigocarrera']."','onchange=\'enviar();\''";
        $formulario->dibujar_campo($menu,$parametrosmenu,"Carrera","tdtitulogris","codigocarrera","requerido");



        $condicion=" and p.idplanestudio=dp.idplanestudio
           and dp.codigomateria=m.codigomateria
            order by m.nombremateria";
        $tablas="materia m , planestudio p, detalleplanestudio dp";
        $resultmaterias=$objetobase->recuperar_resultado_tabla($tablas, "p.codigocarrera", $_POST['codigocarrera'], $condicion,"",0);

        while($rowmateria=$resultmaterias->fetchRow()) {

            $condicion=" now() between e.fechainicioencuesta and e.fechafinalencuesta
            and e.codigocarrera='".$_POST['codigocarrera']."'";
            $formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("encuesta e","idencuesta","nombreencuesta",$condicion);
            $formulario->filatmp[""]="Seleccionar";
            $menu="menu_fila";
            $condicion.=" and em.idencuesta=e.idencuesta and em.codigomateria='".$rowmateria["codigomateria"]."'";
            $datosencuestamateria=$objetobase->recuperar_datos_tabla("encuesta e,encuestamateria em","e.codigocarrera",$_POST['codigocarrera']," and ".$condicion,"",0);

            $parametrosmenu="'".$rowmateria["codigomateria"]."','".$datosencuestamateria["idencuesta"]."','onchange=\'enviarencuestamateria(this);\''";
            $formulario->dibujar_campo($menu,$parametrosmenu,$rowmateria["nombremateria"],"tdtitulogris","idencuesta","requerido");

        }

        echo "</form></table>";
        ?>
    </body>
</html>