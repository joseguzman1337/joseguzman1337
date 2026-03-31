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

<script LANGUAGE="JavaScript">

function quitarFrame()
{
	if (self.parent.frames.length != 0)
	self.parent.location=document.location.href="../../../../aspirantes/aspirantes.php";

}
function regresarGET()
{
	//history.back();
	location.href="<?php echo 'menuinicialaportes.php';?>";
}
//quitarFrame()
</script>
<link rel="stylesheet" type="text/css" href="../../estilos/sala.css">
<script type="text/javascript" src="../../funciones/javascript/funciones_javascript.js"></script>
<style type="text/css">@import url(../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../funciones/calendario_nuevo/calendar-setup.js"></script>
<script type="text/javascript" src="../../funciones/clases/formulario/globo.js"></script>
<?php
//print_r($_SESSION);
$fechahoy=date("Y-m-d H:i:s");

$formulario=new formulariobaseestudiante($sala,'form1','post','','true');
$objetobase=new BaseDeDatosGeneral($sala);

if($_REQUEST['depurar']=="si")
{
	$depurar=new SADebug();
	$depurar->trace($formulario,'','');
	$formulario->depurar();
	if($_REQUEST['depurar_correo']=="si")
	{
		$depura_correo=true;
	}
	else
	{
		$depura_correo=false;
	}
}
$codigoperiodo=$formulario->carga_periodo(4);
//$formulario->agregar_tablas('estudiante','codigoestudiante');


$usuario=$formulario->datos_usuario();
$ip=$formulario->GetIP();
//echo "LINK_ORIGEN=".$_GET['link_origen'];

?>
<form name="form1" action="novedadarpextemporaneo.php" method="POST" >
<input type="hidden" name="AnularOK" value="">
	<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="750">
	<?php 
		//$formulario->dibujar_fila_titulo('APORTES SEGURIDAD SOCIAL EPS ARP','labelresaltado',"2","align='center'");
		if(isset($_GET['idestudiantenovedadarpextemporaneo'])&&trim($_GET['idestudiantenovedadarpextemporaneo'])!="")
		{
			$condicion =" and eg.idestudiantegeneral = en.idestudiantegeneral
						 and ene.idestudiantenovedadarp=en.idestudiantenovedadarp";
			$datosestudiantenovedadarpext=$objetobase->recuperar_datos_tabla("estudiantegeneral eg, estudiantenovedadarpextemporaneo ene, estudiantenovedadarp en","idestudiantenovedadarpextemporaneo",$_GET['idestudiantenovedadarpextemporaneo'],$condicion,', ene.idestudiantenovedadarp novedaddelestudiante,ene.codigoestado codigoestadonovedadext ',0);
			$numerodocumentoestudiante=$datosestudiantenovedadarpext["numerodocumento"];
			$idestudiantenovedadarp=$datosestudiantenovedadarpext["novedaddelestudiante"];
			$fechainicio=formato_fecha_defecto($datosestudiantenovedadarpext["fechainicioestudiantenovedadarpextemporaneo"]);
			$fechafinal=formato_fecha_defecto($datosestudiantenovedadarpext["fechafinalestudiantenovedadarpextemporaneo"]);
			$codigoestado=$datosestudiantenovedadarpext["codigoestadonovedadext"];
		}
		else
		{
			$numerodocumentoestudiante=$_POST['numerodocumentoestudiante'];
		}
		
		$formulario->dibujar_fila_titulo('Asignacion de novedades extemporaneas','labelresaltado');
		$parametros="'text','numerodocumentoestudiante','".$numerodocumentoestudiante."'";
		$campo='boton_tipo';
		$formulario->dibujar_campo($campo,$parametros,"Documento","tdtitulogris","numerodocumentoestudiante",'requerido');
		
		if(isset($numerodocumentoestudiante)){		
			$condicion =" n.idnovedadarp=en.idnovedadarp
						  and en.idestudiantegeneral=eg.idestudiantegeneral
						  and eg.numerodocumento = '".$numerodocumentoestudiante."'
						  and (NOW() between fechainicioestudiantenovedadarp and fechafinalestudiantenovedadarp)
						  and en.codigoestado like '1%'";
			if($formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("estudiantenovedadarp en, estudiantegeneral eg,novedadarp n","en.idestudiantenovedadarp","n.nombrenovedadarp",$condicion,'',0)){
				$formulario->filatmp[""]="Seleccionar";
				$campo='menu_fila'; $parametros="'idestudiantenovedadarp','".$idestudiantenovedadarp."',''";
				$formulario->dibujar_campo($campo,$parametros,"Novedad","tdtitulogris",'idestudiantenovedadarp','requerido');
				
				$campo = "campo_fecha"; $parametros ="'text','fechainicio','".$fechainicio."','onKeyUp = \"this.value=formateafecha(this.value);\" $funcionfechainicial'";
				$formulario->dibujar_campo($campo,$parametros,"Fecha de vigencia (Inicio)","tdtitulogris",'fechainicio','requerido');
				$campo="campo_fecha"; $parametros="'text','fechafinal','".$fechafinal."','onKeyUp = \"this.value=formateafecha(this.value);\" '";
				$formulario->dibujar_campo($campo,$parametros,"Fecha de vigencia (Final)","tdtitulogris",'fechafinal','requerido');
				
				$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("estado","codigoestado","nombreestado",'','',0);
				$campo='menu_fila'; $parametros="'codigoestado','".$codigoestado."',''";
				$formulario->dibujar_campo($campo,$parametros,"Estado","tdtitulogris",'codigoestado','requerido');
	
		}
		else{
			alerta_javascript("No hay ninguna novedad asociada a este numero de documento");
		}
			
		}
		$conboton=0;
		if(isset($_GET['idestudiantenovedadarpextemporaneo'])){
					$parametrobotonenviar[$conboton]="'submit','Modificar','Modificar'";
					$boton[$conboton]='boton_tipo';
					$conboton++;
					//$parametrobotonenviar[$conboton]="'submit','Anular','Anular'";
					//$boton[$conboton]='boton_tipo';
					//$conboton++;
					$formulario->boton_tipo('hidden','idestudiantenovedadarpextemporaneo',$_GET['idestudiantenovedadarpextemporaneo']);

					}
		else{
				//if(isset($_POST['codigocarrera'])&&$_POST['codigocarrera']!=''){
				
				if(isset($numerodocumentoestudiante)){
					$parametrobotonenviar[$conboton]="'submit','Enviar','Enviar'";
					$boton[$conboton]='boton_tipo';	
					$conboton++;
				}
				else{
					$parametrobotonenviar[$conboton]="'submit','Buscar','Buscar'";
					$boton[$conboton]='boton_tipo';	
					$conboton++;
				}
									
				//}
		}


		if(isset($numerodocumentoestudiante)){		
			$parametrobotonenviar[$conboton]="'Listado','listadonovedadarpextemporaneo.php','numerodocumento=".$numerodocumentoestudiante."',900,300,5,5,'yes','yes','no','yes','yes'";
			$boton[$conboton]='boton_ventana_emergente';
			$conboton++;
		}
				$parametrobotonenviar[$conboton]="'button','Regresar','Regresar','onclick=\'regresarGET();\''";
				$boton[$conboton]='boton_tipo';
				$conboton++;

		$formulario->dibujar_campos($boton,$parametrobotonenviar,"","tdtitulogris",'Enviar');

if(isset($_REQUEST["Enviar"])){
	if($formulario->valida_formulario()){	
		if(isset($usuario['idusuario'])&&$usuario['idusuario']!=''){
			$tabla="estudiantenovedadarpextemporaneo";
			$fila['idestudiantenovedadarp']=$_POST['idestudiantenovedadarp'];
			$fila['fechaestudiantenovedadarpextemporaneo']=$fechahoy;
			$fila['fechainicioestudiantenovedadarpextemporaneo']=formato_fecha_mysql($_POST['fechainicio']);
			$fila['fechafinalestudiantenovedadarpextemporaneo']=formato_fecha_mysql($_POST['fechafinal']);
			$fila['idusuario']=$usuario['idusuario'];
				
			$fila['codigoestado']=$_POST['codigoestado'];
			$condicion="idestudiantenovedadarp=".$fila['idestudiantenovedadarp'].
						" and fechainicioestudiantenovedadarpextemporaneo='".$fila['fechainicioestudiantenovedadarpextemporaneo']."'".
						" and fechafinalestudiantenovedadarpextemporaneo='".$fila['fechafinalestudiantenovedadarpextemporaneo']."'".
						" and codigoestado='".$fila['codigoestado']."'";
			$objetobase->insertar_fila_bd($tabla,$fila,0,$condicion);
			alerta_javascript("Datos Ingresados Correctamente");
			echo "<META HTTP-EQUIV='Refresh' CONTENT='0'>";
		}
		else{
			alerta_javascript("Usuario sin permisos, posiblemente se ha cerrado la sesion");		
		}
	}	

}
if(isset($_REQUEST["Modificar"])){

	if($formulario->valida_formulario()){	
		if(isset($usuario['idusuario'])&&$usuario['idusuario']!=''){
			$tabla="estudiantenovedadarpextemporaneo";
			$nombreidtabla="idestudiantenovedadarpextemporaneo";
			$idtabla=$_POST["idestudiantenovedadarpextemporaneo"];
			$fila['idestudiantenovedadarp']=$_POST['idestudiantenovedadarp'];
			$fila['fechainicioestudiantenovedadarpextemporaneo']=formato_fecha_mysql($_POST['fechainicio']);
			$fila['fechafinalestudiantenovedadarpextemporaneo']=formato_fecha_mysql($_POST['fechafinal']);	
			$fila['codigoestado']=$_POST['codigoestado'];
			$fila['idusuario']=$usuario['idusuario'];
			
			$objetobase->actualizar_fila_bd($tabla,$fila,$nombreidtabla,$idtabla);		
			alerta_javascript("Datos Modificados Correctamente");
			echo "<META HTTP-EQUIV='Refresh' CONTENT='0'>";
		}
		else{
			alerta_javascript("Usuario sin permisos, posiblemente se ha cerrado la sesion");
		}
		
	}	

}
	?>
  </table>
</form>