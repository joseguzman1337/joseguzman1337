<?php
session_start();
$rol=$_SESSION['rol'];

//$_SESSION['MM_Username']='admintecnologia';
//print_r($_SESSION);
$rutaado=("../../funciones/adodb/");
require_once("../../funciones/clases/debug/SADebug.php");
require_once("../../Connections/salaado-pear.php");
require_once("../../funciones/clases/formulario/clase_formulario.php");
require_once("../../funciones/phpmailer/class.phpmailer.php");
require_once("../../funciones/validaciones/validaciongenerica.php");
require_once("../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../funciones/sala_genericas/clasebasesdedatosgeneral.php");


?>
<link rel="stylesheet" type="text/css" href="../../estilos/sala.css">
<style type="text/css">@import url(../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../funciones/calendario_nuevo/calendar-setup.js"></script>
<script type="text/javascript" src="../../funciones/clases/formulario/globo.js"></script>
<script LANGUAGE="JavaScript">
function regresarGET()
{	//history.back();
	document.location.href="<?php echo 'menumantenimientovotaciones.php';?>";}

</script>

<?php
//print_r($_SESSION);
$fechahoy=date("Y-m-d H:i:s");
$formulario=new formulariobaseestudiante($sala,'form1','post','','true');
$objetobase=new BaseDeDatosGeneral($sala);

$usuario=$formulario->datos_usuario();
$ip=$formulario->GetIP();


?>
<form name="form1" action="candidatovotacion.php" method="POST" >
<input type="hidden" name="AnularOK" value="">
	<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="750">
<?php

		if(isset($_GET['idcandidatovotacion'])){
		$datosplantillavotacion=$objetobase->recuperar_datos_tabla("candidatovotacion","idcandidatovotacion",$_GET['idcandidatovotacion'],'','',0);
		$numerodocumentocandidatovotacion=$datosplantillavotacion['numerodocumentocandidatovotacion'];
		$nombrescandidatovotacion=$datosplantillavotacion['nombrescandidatovotacion'];
		$apellidoscandidatovotacion=$datosplantillavotacion['apellidoscandidatovotacion'];
		$telefonocandidatovotacion=$datosplantillavotacion['telefonocandidatovotacion'];
		$celularcandidatovotacion=$datosplantillavotacion['celularcandidatovotacion'];
		$direccioncandidatovotacion=$datosplantillavotacion['direccioncandidatovotacion'];
		$numerotarjetoncandidatovotacion=$datosplantillavotacion['numerotarjetoncandidatovotacion'];
		$idtipocandidatodetalleplantillavotacion=$datosplantillavotacion['idtipocandidatodetalleplantillavotacion'];
		}
			$conboton=0;
			$formulario->dibujar_fila_titulo('Candidato de Votación','labelresaltado');
			$condicion="";
			$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("tipocandidatodetalleplantillavotacion","idtipocandidatodetalleplantillavotacion","nombretipocandidatodetalleplantillavotacion",$condicion,"",0);
			//$formulario->filatmp[""]="Seleccionar";
			$menu="menu_fila"; $parametrosmenu="'idtipocandidatodetalleplantillavotacion','".$idtipocandidatodetalleplantillavotacion."',''";
			$formulario->dibujar_campo($menu,$parametrosmenu,"Tipos de candidato","tdtitulogris","idtipocandidatodetalleplantillavotacion",'requerido');
			
			$campo="boton_tipo"; $parametros="'text','numerodocumentocandidatovotacion','".$numerodocumentocandidatovotacion."','maxlength=\"15\"'";
		  	$formulario->dibujar_campo($campo,$parametros,"Documento","tdtitulogris",'numerodocumentocandidatovotacion','numero');
	
			$campo="boton_tipo"; $parametros="'text','numerotarjetoncandidatovotacion','".$numerotarjetoncandidatovotacion."','maxlength=\"5\"'";
		  	$formulario->dibujar_campo($campo,$parametros,"Tarjeton","tdtitulogris",'numerotarjetoncandidatovotacion','requerido');
		
			$campo="boton_tipo"; $parametros="'text','nombrescandidatovotacion','".$nombrescandidatovotacion."',''";
		  	$formulario->dibujar_campo($campo,$parametros,"Nombres","tdtitulogris",'nombrescandidatovotacion','requerido');

			$campo="boton_tipo"; $parametros="'text','apellidoscandidatovotacion','".$apellidoscandidatovotacion."',''";
		  	$formulario->dibujar_campo($campo,$parametros,"Apellidos","tdtitulogris",'apellidoscandidatovotacion','requerido');
			
			$campo="boton_tipo"; $parametros="'text','telefonocandidatovotacion','".$telefonocandidatovotacion."','maxlength=\"10\"'";
		  	$formulario->dibujar_campo($campo,$parametros,"Telefono fijo","tdtitulogris",'telefonocandidatovotacion','');
	
			$campo="boton_tipo"; $parametros="'text','celularcandidatovotacion','".$celularcandidatovotacion."','maxlength=\"10\"'";
		  	$formulario->dibujar_campo($campo,$parametros,"Celular","tdtitulogris",'celularcandidatovotacion','');

			$campo="boton_tipo"; $parametros="'text','direccioncandidatovotacion','".$direccioncandidatovotacion."',''";
		  	$formulario->dibujar_campo($campo,$parametros,"Direccion","tdtitulogris",'direccioncandidatovotacion','');
				
				if(isset($_GET['idcandidatovotacion'])){
					$parametrobotonenviar[$conboton]="'submit','Modificar','Modificar'";
					$boton[$conboton]='boton_tipo';
					$formulario->boton_tipo('hidden','idcandidatovotacion',$_GET['idcandidatovotacion']);
					$conboton++;
					$parametrobotonenviar[$conboton]="'submit','Anular','Anular'";
					$boton[$conboton]='boton_tipo';
					$conboton++;
				}
				else{
					$parametrobotonenviar[$conboton]="'submit','Enviar','Enviar'";
					$boton[$conboton]='boton_tipo';
					$conboton++;
				}

		$parametrobotonenviar[$conboton]="'Listado','listadocandidatovotacion.php','codigoperiodo=".$codigoperiodo."&link_origen= ".$_GET['link_origen']."',700,600,5,50,'yes','yes','no','yes','yes'";
		$boton[$conboton]='boton_ventana_emergente';
		$conboton++;
		$parametrobotonenviar[$conboton]="'button','Regresar','Regresar','onclick=\'regresarGET();\''";
		$boton[$conboton]='boton_tipo';
		$formulario->dibujar_campos($boton,$parametrobotonenviar,"","tdtitulogris",'Enviar','',0);

if(isset($_REQUEST['Enviar'])){
	if($formulario->valida_formulario()){
		$tabla="candidatovotacion";
		$fila['numerodocumentocandidatovotacion']=$_POST['numerodocumentocandidatovotacion'];
		$fila['nombrescandidatovotacion']=ltrim(rtrim($_POST['nombrescandidatovotacion']));
		$fila['apellidoscandidatovotacion']=ltrim(rtrim($_POST['apellidoscandidatovotacion']));
		$fila['telefonocandidatovotacion']=$_POST['telefonocandidatovotacion'];
		$fila['celularcandidatovotacion']=$_POST['celularcandidatovotacion'];
		$fila['direccioncandidatovotacion']=$_POST['direccioncandidatovotacion'];
		$fila['numerotarjetoncandidatovotacion']=$_POST['numerotarjetoncandidatovotacion'];
		$fila['codigoestado']=100;
		$fila['rutaarchivofotocandidatovotacion']='../../imagenes/estudiantes/';
		$fila['idtipocandidatodetalleplantillavotacion']=$_POST['idtipocandidatodetalleplantillavotacion'];
		$condicionactualiza="numerodocumentocandidatovotacion=".$fila['numerodocumentocandidatovotacion'].
								" and idtipocandidatodetalleplantillavotacion=".$fila['idtipocandidatodetalleplantillavotacion'];
		$objetobase->insertar_fila_bd($tabla,$fila,0,$condicionactualiza);
		echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=$REQUEST_URI'>";
	
	}
}
if(isset($_REQUEST['Modificar'])){
	if($formulario->valida_formulario()){
		$tabla="candidatovotacion";
		$nombreidtabla="idcandidatovotacion";
		$idtabla=$_POST['idcandidatovotacion'];
		$fila['numerodocumentocandidatovotacion']=$_POST['numerodocumentocandidatovotacion'];
		$fila['nombrescandidatovotacion']=$_POST['nombrescandidatovotacion'];
		$fila['apellidoscandidatovotacion']=$_POST['apellidoscandidatovotacion'];
		$fila['telefonocandidatovotacion']=$_POST['telefonocandidatovotacion'];
		$fila['celularcandidatovotacion']=$_POST['celularcandidatovotacion'];
		$fila['direccioncandidatovotacion']=$_POST['direccioncandidatovotacion'];
		$fila['numerotarjetoncandidatovotacion']=$_POST['numerotarjetoncandidatovotacion'];
		//$fila['codigoestado']=100;
		$fila['rutaarchivofotocandidatovotacion']='../../imagenes/estudiantes/';
		$fila['idtipocandidatodetalleplantillavotacion']=$_POST['idtipocandidatodetalleplantillavotacion'];
		$objetobase->actualizar_fila_bd($tabla,$fila,$nombreidtabla,$idtabla);
		echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=$REQUEST_URI'>";
	
	}
}
if(isset($_REQUEST['Anular'])){
	$tabla="candidatovotacion";
	$fila['codigoestado']=200;
	$nombreidtabla="idcandidatovotacion";
	$idtabla=$_POST['idcandidatovotacion'];
	$objetobase->actualizar_fila_bd($tabla,$fila,$nombreidtabla,$idtabla);
	echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=$REQUEST_URI'>";
}		

?>

  </table>
</form>
