<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
$rutaado=("../../../../funciones/adodb/");
require_once("../../../../Connections/salaado-pear.php");
require_once("../../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../../funciones/phpmailer/class.phpmailer.php");
require_once("../../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../../../funciones/sala_genericas/FuncionesMatriz.php");
require_once("../../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../../../../funciones/sala_genericas/DatosGenerales.php");
$fechahoy=date("Y-m-d H:i:s");

$formulario=new formulariobaseestudiante($sala,'form1','post','','true');
$objetobase=new BaseDeDatosGeneral($sala);
?>
<link rel="stylesheet" type="text/css" href="../../../../estilos/sala.css">
<link href="../../../../funciones/sala_genericas/ajax/suggest/suggest.css" type="text/css" rel="stylesheet"/>
<script type="text/javascript" src="../../../../funciones/javascript/funciones_javascript.js"></script>
<style type="text/css">@import url(../../../../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../../../funciones/calendario_nuevo/calendar-setup.js"></script>
<script type="text/javascript" src="../../../../funciones/clases/formulario/globo.js"></script>
<script type="text/javascript" src="../../../../funciones/sala_genericas/ajax/suggest/suggest.js"></script>
<form name="form1" action="interesados.php?tabla=<?php echo $_GET['tabla'] ?>&idtabla=<?php echo $_GET['idtabla'] ?>" method="POST" >
	<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="750">
	<?php 
		if(isset($_GET['tabla'])&&$_GET['tabla']!=''){
		$condicion="and e.idempresa=p.idempresa";
		$tablas="empresa e,preinscripcion p
				left join programainterespreinscripcion pip on p.idpreinscripcion= pip.idpreinscripcion
				left join programainteres pi on  pi.idprogramainteres=pip.idprogramainteres ";
		$datosinteresado=$objetobase->recuperar_datos_tabla($tablas,"p.idpreinscripcion",$_GET['idtabla'],$condicion,"",0);
		$idempresa=$datosinteresado["idempresa"];
		$nombreempresa=$datosinteresado["nombreempresa"];
		$idprogramainteres=$datosinteresado["idprogramainteres"];
		$nombreprogramainteres=$datosinteresado["nombreprogramainteres"];
		$idpreinscripcion=$datosinteresado["idpreinscripcion"];
		//$nombreprogramainteres=$datosinteresado["nombreprogramainteres"];
		}
		//$parametrossugerido[]="'".$filaconstraint[1]."','".$filaconstraint[2]."','".$tmpnombretabla."','','".$columnas2[$i]."','".$datoscamposugerido[$tmpnombretabla]."','".$filaconstraint[0]."','../../../serviciosacademicos/funciones/sala_genericas/ajax/suggest/suggest.php?keyword=','1'";
		//($tablas,$campollave,$camponombre,$condicion,$valorcampo,$valorcamponombre,$nombrecampo,$direccionsuggest,$imprimir){
		$formulario->dibujar_fila_titulo('Interesado Educacion Continuada','labelresaltado');		
		$parametros="'empresa','idempresa','nombreempresa','','".$idempresa."','".$nombreempresa."','idempresa','../../../../funciones/sala_genericas/ajax/suggest/suggest.php?keyword=','1'";
		$campo="campo_sugerido";
		$formulario->dibujar_campo($campo,$parametros,"Empresa","tdtitulogris","idempresa","requerido");	
		$parametros="'programainteres','idprogramainteres','nombreprogramainteres','','".$idprogramainteres."','".$nombreprogramainteres."','idprogramainteres','../../../../funciones/sala_genericas/ajax/suggest/suggest.php?keyword=','1'";
		$campo="campo_sugerido";
		$formulario->dibujar_campo($campo,$parametros,"Programa Interes","tdtitulogris","idprogramainteres","requerido");	
		$parametros="'preinscripcion','idpreinscripcion','idpreinscripcion','','".$idpreinscripcion."','".$idpreinscripcion."','idpreinscripcion','../../../../funciones/sala_genericas/ajax/suggest/suggest.php?keyword=','1'";
		$campo="campo_sugerido";
		$formulario->dibujar_campo($campo,$parametros,"Id Estudiante Preinscripcion","tdtitulogris","idpreinscripcion","requerido");				
					$conboton=0;
					/*if(isset($_GET['idtabla'])){
							$parametrobotonenviarv[$conboton]="'submit','Modificar','Modificar'";
							$botonv[$conboton]='boton_tipo';
							$conboton++;
					}
					else{*/
							$parametrobotonenviarv[$conboton]="'submit','Enviar','Enviar'";
							$botonv[$conboton]='boton_tipo';
							$conboton++;	
					//}
					$parametrobotonenviarv[$conboton]="'button','Cerrar','Cerrar','onclick=window.close();'";
					$botonv[$conboton]='boton_tipo';
					$formulario->dibujar_campos($botonv,$parametrobotonenviarv,"","tdtitulogris",'Enviar');


if($_REQUEST['Enviar']){
$fila['idpreinscripcion']=$_GET['idtabla'];
$fila['idprogramainteres']=$_POST['idprogramainteres'];
$fila['codigoestado']=100;
$condicionactualiza="idpreinscripcion=".$fila['idpreinscripcion']." and idprogramainteres=".$fila['idprogramainteres'];
$objetobase->insertar_fila_bd("programainterespreinscripcion",$fila,0,$condicionactualiza);
unset($fila);
$fila['idempresa']=$_POST['idempresa'];
$condicionactualiza="idpreinscripcion=".$fila['idpreinscripcion'].
					" and idprogramainteres=".$fila['idprogramainteres'];
$objetobase->actualizar_fila_bd("preinscripcion",$fila,"idpreinscripcion",$_GET['idtabla'],"",0);

}

?>
  </table>
</form>