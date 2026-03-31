<?php
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

//session_start();
$rutaJS = '../../sic/librerias/js/';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
        <link rel="stylesheet" href="<?php echo $rutaJS; ?>jquery-ui/css/ui-lightness/jquery-ui-3.6.0.custom.css" />
        <!--<link rel="stylesheet" href="<?php echo $rutaJS; ?>>ajaxfileupload/ajaxfileupload.css" />-->
        <title> DOCUMENTACION ESTUDIANTE</title>
        <script src="<?php echo $rutaJS; ?>jquery-3.6.0.js" type="text/javascript"></script>
        <script src="<?php echo $rutaJS; ?>jquery.layout.js"></script>
        <script src="<?php echo $rutaJS; ?>jquery.lightbox-0.5.min.js"></script>
        <script src="<?php echo $rutaJS; ?>jquery.maxlength-min.js" type="text/javascript"></script>
        <script src="<?php echo $rutaJS; ?>jquery-treeview/lib/jquery.cookie.js" type="text/javascript"></script>
        <script src="<?php echo $rutaJS; ?>jquery-treeview/jquery.treeview.js" type="text/javascript"></script>
        <script src="<?php echo $rutaJS; ?>ajaxfileupload/ajaxfileupload.js" type="text/javascript"></script>
        <script src="<?php echo $rutaJS; ?>jquery-ui/js/jquery-ui-3.6.0.custom.min.js" type="text/javascript"></script>
        <link rel="stylesheet" href="jquery.windows-engine.css" />
        <!--<script src="<?php echo $rutaJS; ?>jquery-windows/jquery.windows-engine.js" type="text/javascript"></script>-->
        <script src="funcioneslistadocumentacion.js" type="text/javascript"></script>
        <script type="text/javascript" src="jquery.windows-engine.js"></script>
        <script language="javascript">
            function enviar()
            {
                form1.action="";
                document.form1.submit();

            }
            function enviarmodalidad(){

                var codigocarrera=document.getElementById("codigocarrera");
                var formulario=document.getElementById("form1");
                //alert(form1.action);
                formulario.action="";
                //alert(form1.action);
                if(codigocarrera!=null)
                    codigocarrera.value="";
                formulario.submit();
            }
            function enviarcarrera(){

                var codigoperiodo=document.getElementById("codigoperiodo");
                var formulario=document.getElementById("form1");
                //document.getElementById("tr0")
                //alert("Entro numerodocumento="+numerodocumento);
                formulario.action="";
                if(codigoperiodo!=null)
                    codigoperiodo.value="";
                formulario.submit();
            }
        </script>
    </head>
    <body>
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

        $usuario = $formulario->datos_usuario();

        echo "<form id=\"form1\" name=\"form1\" action=\"listadodocentesfacultad.php\" method=\"post\"  >
<input type=\"hidden\" name=\"AnularOK\" value=\"\">
	<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"100%\">";
        $formulario->dibujar_fila_titulo('DOCUMENTACION DIGITAL', 'labelresaltado', "6", "align='center'");


        $condicion = " codigomodalidadacademica in ('200','300','501') order by pesomodalidadacademica";
        $formulario->filatmp = $objetobase->recuperar_datos_tabla_fila("modalidadacademica m", "m.codigomodalidadacademica", "m.nombremodalidadacademica", $condicion);
        $formulario->filatmp[""] = "Seleccionar";
        $campo = 'menu_fila';
        $parametros = "'codigomodalidadacademica','" . $_POST['codigomodalidadacademica'] . "','onchange=enviarmodalidad();'";
        $formulario->dibujar_campo($campo, $parametros, "Modalidad", "tdtitulogris", 'codigomodalidadacademica', '');

       // if ($usuario["idusuario"] == 4186 || $usuario["idusuario"] == 17937 || $usuario["idusuario"] == 18134) {
            $condicion = " codigomodalidadacademica='" . $_POST['codigomodalidadacademica'] . "'
							and now()  between fechainiciocarrera and fechavencimientocarrera
							and c.codigocarrera not in (124,134,119,427)
							order by nombrecarrera2";
            $formulario->filatmp = $objetobase->recuperar_datos_tabla_fila("carrera c", "codigocarrera", "nombrecarrera", $condicion, " , replace(c.nombrecarrera,' ','') nombrecarrera2", 0);
            $formulario->filatmp[""] = "Seleccionar";
      /* else {
            $tabla = "carrera c, usuariofacultad uf, usuario u,usuariodependencia ud";
            $condicion = " ((c.codigocarrera=uf.codigofacultad
					and u.idusuario='" . $usuario["idusuario"] . "'
					and uf.usuario=u.usuario)
					or (c.codigocarrera=ud.codigodependencia
					and u.idusuario='" . $usuario["idusuario"] . "'
					and ud.usuario=u.usuario))
					and c.codigomodalidadacademica='" . $_POST['codigomodalidadacademica'] . "'
					order by nombrecarrera2
					";
            //$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila($tabla,"c.codigocarrera","c.nombrecarrera",$condicion," , replace(c.nombrecarrera,' ','') nombrecarrera2",1);

            $formulario->filatmp[" "] = "Seleccionar";
            $query = "select c.codigocarrera,  c.nombrecarrera , replace(c.nombrecarrera,' ','') nombrecarrera2 from carrera c, usuariofacultad uf, usuario u where (c.codigocarrera=uf.codigofacultad and u.idusuario='" . $usuario["idusuario"] . "'  and uf.usuario=u.usuario)
				and c.codigocarrera not in (124,134,119,427)
				and c.codigomodalidadacademica='" . $_POST['codigomodalidadacademica'] . "'

				union

				select c.codigocarrera,  c.nombrecarrera , replace(c.nombrecarrera,' ','') nombrecarrera2 from carrera c, usuariodependencia ud, usuario u where (c.codigocarrera=ud.codigodependencia and u.idusuario='" . $usuario["idusuario"] . "' and ud.usuario=u.usuario)
				and c.codigocarrera not in (124,134,119,427)
				and c.codigomodalidadacademica='" . $_POST['codigomodalidadacademica'] . "'
				order by nombrecarrera2
				";
            $resultado = $objetobase->conexion->query($query);
            while ($rowcarreras = $resultado->fetchRow()) {
                $formulario->filatmp[$rowcarreras["codigocarrera"]] = $rowcarreras["nombrecarrera"];
            }
        }*/
        $campo = 'menu_fila';
        $parametros = "'codigocarrera','" . $_POST['codigocarrera'] . "',''";
        $formulario->dibujar_campo($campo, $parametros, "Carrera", "tdtitulogris", 'codigocarrera', 'requerido');
        unset($formulario->filatmp);

        $condicion = " 1=1 order by codigoperiodo desc";
        $formulario->filatmp = $objetobase->recuperar_datos_tabla_fila("periodo", "codigoperiodo", "codigoperiodo", $condicion, "", 0, 0);
        //$formulario->filatmp[""]="Seleccionar";

        $codigoperiodo = $_SESSION['codigoperiodosesion'];
        if (!isset($_REQUEST['codigoperiodo']))
            $codigoperiodo = "";
        else
            $codigoperiodo=$_REQUEST['codigoperiodo'];
        $campo = 'menu_fila';
        $parametros = "'codigoperiodo','" . $codigoperiodo . "','onchange=enviarperiodo();'";
        $formulario->dibujar_campo($campo, $parametros, "Periodo", "tdtitulogris", 'codigoperiodo', '');

        $campo = "boton_tipo";
        $parametros = "'submit','Enviar','Enviar',''";
        //$formulario->dibujar_campo($tipo, $parametros, $titulo, $estilo_titulo, $idtitulo);
        $formulario->dibujar_campo($campo, $parametros, "Enviar", "tdtitulogris", 'Enviar', '');

        echo "</table>";
        echo "</form>";
        ?>
    </body>
</html>