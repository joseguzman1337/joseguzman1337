<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
session_start();
//$rol=$_SESSION['rol'];
//$_SESSION['MM_Username']='admintecnologia';
//print_r($_SESSION);
$rutaado = ("../../../../funciones/adodb/");
require_once("../../../../funciones/clases/debug/SADebug.php");
require_once("../../../../Connections/salaado-pear.php");
require_once("../../../../funciones/clases/formulario/clase_formulario.php");
//require_once("../../../../funciones/phpmailer/class.phpmailer.php");
//require_once("../../../../funciones/validaciones/validaciongenerica.php");
require_once("../../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../../funciones/sala_genericas/FuncionesFecha.php");
require_once('../../../../funciones/sala_genericas/FuncionesSeguridad.php');
require_once("../../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once('../../../../funciones/clases/autenticacion/redirect.php' );
?>
<script LANGUAGE="JavaScript">

    function quitarFrame()
    {
        if (self.parent.frames.length != 0)
            self.parent.location=document.location.href="../../../../aspirantes/aspirantes.php";

    }
    function regresarGET()
    {
        //history.back();
        document.location.href="<?php echo 'menu.php'; ?>";
    }
    function enviarpagina(){
        var pagina;
        var  formulario=document.getElementById('form1');
        pagina=formulario.menu[formulario.menu.selectedIndex].value;
        
       // alert(formulario.menu.selectedIndex);
        if(formulario.menu.selectedIndex==0){            
            document.location.href=pagina;
            return false;
        }
        else{
            //alert(formulario.action);
            formulario.action=pagina;
            formulario.submit();  
        }
        /*  */
        //return false;
    }
    //quitarFrame()
</script>
<link rel="stylesheet" type="text/css" href="../../../../estilos/sala.css">
<script type="text/javascript" src="../../../../funciones/javascript/funciones_javascript.js"></script>
<style type="text/css">@import url(../../../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../../../funciones/calendario_nuevo/calendar-setup.js"></script>
<script type="text/javascript" src="../../../../funciones/clases/formulario/globo.js"></script>


<?php
//print_r($_SESSION);
$fechahoy = date("Y-m-d H:i:s");

$formulario = new formulariobaseestudiante($sala, 'form1', 'post', '', 'true');
//$formulario2=new formulariobaseestudiante($sala,'form1','post','','true');
$objetobase = new BaseDeDatosGeneral($sala);
$idmenuopcion = 116;
if (!validaUsuarioMenuOpcion($idmenuopcion, $formulario, $objetobase)) {
    echo "<script language='javascript'>
		 	alert('Usted no tiene permiso para entrar a esta opcion');
	   		parent.location.href='https://artemisa.unbosque.edu.co/serviciosacademicos/consulta/facultades/consultafacultadesv2.htm';
	 	  </script>";
}

//echo "Entro aqui";
?>
<form name="form1" id="form1" action="" method="GET" >
    <input type="hidden" name="AnularOK" value="" onChange="">
    <table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="750">
        <?php
        $formulario->dibujar_fila_titulo('PROCESO ADMISIONES', 'labelresaltado', "2", "align='center'");
        $formulario->dibujar_fila_titulo('1. PARAMETRIZACION DE ADMISIONES', 'labelresaltado', "2", "align='center'");

        //$formulario->dibujar_fila_titulo('Datos Generales','labelresaltado');
        ?>
        <tr>
            <td colspan="2">
                <?php
                if (!isset($_SESSION['admisiones_idadmision']) || trim($_SESSION['admisiones_idadmision']) == '')
                    $_SESSION['admisiones_idadmision'] = $_GET['idadmision'];
                else
                if (isset($_GET['idadmision']) && $_SESSION['admisiones_idadmision'] != $_GET['idadmision'])
                    $_SESSION['admisiones_idadmision'] = $_GET['idadmision'];


                //$formulario->dibujar_fila_titulo('Asignacion de codigos EPS y ARP','labelresaltado');
                $codigoperiodo = $_SESSION['admisiones_codigoperiodo'];
                //$array_carreras=$datos->LeerCarreras($_SESSION['codigomodalidadacademica'],$_SESSION['codigocarrera']);
                $condicion.=" a.codigoestado=100
		AND a.codigocarrera=c.codigocarrera
		AND c.codigocarrera=cp.codigocarrera
		AND cp.codigoperiodo='$codigoperiodo'
		AND s.idsubperiodo=a.idsubperiodo
		AND s.idcarreraperiodo=cp.idcarreraperiodo
		AND c.codigocarrera='" . $_SESSION['admisiones_codigocarrera'] . "'";
                $formulario->filatmp = $objetobase->recuperar_datos_tabla_fila("admision a, carrera c, carreraperiodo cp, subperiodo s", "a.idadmision", "CONCAT(a.nombreadmision,' - ',cp.codigoperiodo) nombreadmisionperiodo", $condicion, ', replace(c.nombrecarrera,\' \',\'\') nombrecarrera2', 0, 0);
                $formulario->filatmp[""] = "Seleccionar";
                $menu = 'menu_fila';
                $parametros = "'idadmision','" . $_SESSION['admisiones_idadmision'] . "','onchange=enviar();'";
                $formulario->dibujar_campo($menu, $parametros, "Admisiones", "tdtitulogris", "idadmision", 'requerido');



                $opcionparametrizacion = "admision_listado.php?codigomodalidadacademica=" . $_SESSION['admisiones_codigomodalidadacademica'] . "&codigocarrera=" . $_SESSION['admisiones_codigocarrera'] . "&codigoperiodo=" . $_SESSION['admisiones_codigoperiodo'] . "&link_origen=menu.php";
                $formulario->filatmp[$opcionparametrizacion] = "Administracion de admisiones";
                $opcionparametrizacion = "detalleadmision_listado.php";
                $formulario->filatmp[$opcionparametrizacion] = "Pruebas de admision";
                $opcionparametrizacion = "detallesitioadmision_listado.php?codigocarrera=" . $_SESSION['admisiones_codigocarrera'];
                $formulario->filatmp[$opcionparametrizacion] = "Salones - Horarios";
                $opcionparametrizacion = "detalleadmisionlistado_listado.php";
                $formulario->filatmp[$opcionparametrizacion] = "Configuración de muestra de resultados";


                $menu = 'menu_fila';
                $parametros = "'menu','" . $menu . "',''";
                $formulario->dibujar_campo($menu, $parametros, "Opciones", "tdtitulogris", "escogertipoarp", 'requerido');
                $conboton = 0;
                $parametrobotonenviar[$conboton] = "'button','Seguir','Seguir','onClick=\"return enviarpagina();\"'";
                $boton[$conboton] = 'boton_tipo';
                $conboton++;
                $parametrobotonenviar[$conboton] = "'button','Regresar','Regresar','onclick=\'regresarGET();\''";
                $boton[$conboton] = 'boton_tipo';

                $formulario->dibujar_campos($boton, $parametrobotonenviar, "", "tdtitulogris", 'Enviar', '');
                ?>	
            </td>
        </tr>
    </table>
</form>