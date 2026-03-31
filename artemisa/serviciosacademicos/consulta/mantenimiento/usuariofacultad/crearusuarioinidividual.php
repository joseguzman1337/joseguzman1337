<?php 
session_start();
 include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
$ruta="../../../";
$rutaado=("../../../funciones/adodb/");
require_once(realpath(dirname(__FILE__)).'/../../../consulta/generacionclaves.php');

require_once(realpath(dirname(__FILE__)).'/../../../funciones/clases/motorv2/motor.php');
//require_once(realpath(dirname(__FILE__)).'/../../../Connections/salaado-pear.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/sala_genericas/clasebasesdedatosgeneral.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/sala_genericas/FuncionesCadena.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/sala_genericas/FuncionesFecha.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/clases/formulario/clase_formulario.php');
require_once(realpath(dirname(__FILE__)).'/../../../funciones/sala_genericas/formulariobaseestudiante.php');

$objetobase=new BaseDeDatosGeneral($salaobjecttmp);
$formulario=new formulariobaseestudiante($sala,'form1','post','','true');
//$objetobase->conexion->query("select usuario from usuario order by usuario desc");

?>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
<script type="text/javascript" src="../../../funciones/sala_genericas/funciones_javascript.js"></script>
<style type="text/css">@import url(../../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-setup.js"></script>
<script type="text/javascript" src="../../../funciones/clases/formulario/globo.js"></script>
<form name="form1" action="" method="POST" >
<input type="hidden" name="AnularOK" value="">
	<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="750">
<?php 
	$formulario->dibujar_fila_titulo('CREACION DE USUARIO INDIVIDUAL','labelresaltado',"2","align='center'");
    $campo="boton_tipo"; $parametros="'text','numeroordenpago','".$numeroordenpago."'";
    $formulario->dibujar_campo($campo,$parametros,"Numero de Orden Pago","tdtitulogris",'numeroordenpago','requerido');
	$parametrobotonenviar="'submit','Enviar','Enviar'";
	$boton='boton_tipo';
	$formulario->dibujar_campo($boton,$parametrobotonenviar,"","tdtitulogris",'Enviar');
	if(isset($_REQUEST['Enviar'])){
			if($formulario->valida_formulario()){
				$objetoclaveusuario=new GeneraClaveUsuario($_POST["numeroordenpago"],$salaobjecttmp);
			}
	}
?>
  </table>
</form>
