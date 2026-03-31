<?php
session_start();
$rol=$_SESSION['rol'];
//$_SESSION['MM_Username']='admintecnologia';
//print_r($_SESSION);

session_start();
include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);
$rutaado=("../../../funciones/adodb/");
require_once(realpath(dirname(__FILE__))."/../../../funciones/clases/debug/SADebug.php");
require_once(realpath(dirname(__FILE__))."/../../../Connections/salaado-pear.php");
require_once(realpath(dirname(__FILE__))."/../../../funciones/clases/formulario/clase_formulario.php");
require_once(realpath(dirname(__FILE__))."/../../../funciones/phpmailer/class.phpmailer.php");
require_once(realpath(dirname(__FILE__))."/../../../funciones/validaciones/validaciongenerica.php");
require_once(realpath(dirname(__FILE__))."/../../../funciones/sala_genericas/FuncionesCadena.php");
require_once(realpath(dirname(__FILE__))."/../../../funciones/sala_genericas/FuncionesFecha.php");
require_once(realpath(dirname(__FILE__))."/../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once(realpath(dirname(__FILE__))."/../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");

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
	location.href="<?php echo '../../facultades/menuopcion.php';?>";
}
function enviarmenu(menu){
switch (menu){
	case 'codigoperiodo':
		form1.codigomodalidadacademica.value='';
		if(form1.codigocarrera!=null){
		form1.codigocarrera.value='';
		if(form1.idsubperiodo!=null)
			form1.idsubperiodo.value='';
		}
	break;
	case 'codigomodalidadacademica':
	if(form1.codigocarrera!=null){
		form1.codigocarrera.value='';
		if(form1.idsubperiodo!=null)
			form1.idsubperiodo.value='';
		}
	break;
	case 'codigocarrera':
	if(form1.idsubperiodo!=null){
		form1.idsubperiodo.value='';
		}
	break;
}
//alert("Entro");
form1.submit();
//alert("Entro");
}
//quitarFrame()
</script>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
<script type="text/javascript" src="../../../funciones/javascript/funciones_javascript.js"></script>
<style type="text/css">@import url(../../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-setup.js"></script>
<script type="text/javascript" src="../../../funciones/clases/formulario/globo.js"></script>
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
<form name="form1" action="carreragrupofechainscripcion.php" method="POST"  >
<input type="hidden" name="AnularOK" value="">

	<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="750" >
	<?php 
		$conboton=0;	

		if(isset($_GET['idcarreragrupofechainscripcion'])){
		$datosgrupofechainscripcion=$objetobase->recuperar_datos_tabla("carreragrupofechainscripcion","idcarreragrupofechainscripcion",$_GET['idcarreragrupofechainscripcion'],'','',0);
		$idcarreragrupofechainscripcion=$datosgrupofechainscripcion['idcarreragrupofechainscripcion'];
		$condicion=" and c.codigocarrera=cp.codigocarrera 
					and cp.idcarreraperiodo=s.idcarreraperiodo
					and s.idsubperiodo=".$datosgrupofechainscripcion["idsubperiodo"];
		$datoscarrera=$objetobase->recuperar_datos_tabla("carrera c, carreraperiodo cp, subperiodo s","c.codigocarrera",$datosgrupofechainscripcion['codigocarrera'],$condicion,'',0);
		$codigomodalidadacademica=$datoscarrera["codigomodalidadacademica"];
		$codigocarrera=$datosgrupofechainscripcion['codigocarrera'];
		$idsubperiodo=$datosgrupofechainscripcion["idsubperiodo"];
		$idgrupo=$datosgrupofechainscripcion["idgrupo"];
		$fechainicio=formato_fecha_defecto($datosgrupofechainscripcion["fechadesdecarreragrupofechainscripcion"]);
		$fechafinal=formato_fecha_defecto($datosgrupofechainscripcion["fechahastacarreragrupofechainscripcion"]);
		$codigoperiodo=$datoscarrera["codigoperiodo"];
		$fechainformacion=formato_fecha_defecto($datosgrupofechainscripcion["fechahastacarreragrupofechainformacion"]);
 		}		
		else{
		$codigoperiodo=$_SESSION['codigoperiodosesion'];
		if(isset($_POST['codigoperiodo']))
		$codigoperiodo=$_POST['codigoperiodo'];
		$idsubperiodo=$_POST['idsubperiodo'];
		$codigomodalidadacademica=$_POST['codigomodalidadacademica'];
		$codigocarrera=$_POST['codigocarrera'];
		if(isset($_POST['fechainicio']))
		$fechainicio=$_POST['fechainicio'];
		else
		$fechainicio=date("d/m/Y");
		}
	
		//$formulario->dibujar_fila_titulo('APORTES SEGURIDAD SOCIAL EPS ARP','labelresaltado',"2","align='center'");
		$formulario->dibujar_fila_titulo('Crear Carrera Grupo Fecha Inscripcion','labelresaltado');
		$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("periodo","codigoperiodo","codigoperiodo","codigoperiodo=codigoperiodo order by codigoperiodo desc");
		$campo='menu_fila'; $parametros="'codigoperiodo','".$codigoperiodo."','onChange=\"enviarmenu(\'codigoperiodo\');\"'";
		$formulario->dibujar_campo($campo,$parametros,"Periodo","tdtitulogris",'codigoperiodo','',0);

		//if(isset($codigoperiodo)&&$codigoperiodo!=''){
		$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("modalidadacademica","codigomodalidadacademica","nombremodalidadacademica");
		$formulario->filatmp[""]="Seleccionar";
		$campo='menu_fila'; $parametros="'codigomodalidadacademica','".$codigomodalidadacademica."','onChange=\"enviarmenu(\'codigomodalidadacademica\');\"'";
		$formulario->dibujar_campo($campo,$parametros,"Modalidad","tdtitulogris",'codigomodalidadacademica','');

		//}
		if(isset($codigomodalidadacademica)&&$codigomodalidadacademica!=''){
		//echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=".$REQUEST_URI.">";
		$condicion=" c.codigomodalidadacademica=".$codigomodalidadacademica.
				   " and cp.codigocarrera=c.codigocarrera
				   	 and cp.codigoperiodo=".$codigoperiodo.
					 " order by nombrecarrera2";


		$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("carrera c, carreraperiodo cp","c.codigocarrera","concat(c.nombrecortocarrera,'-',c.codigocarrera)",$condicion,', replace(c.nombrecarrera,\' \',\'\') nombrecarrera2',0,0);
		$formulario->filatmp[""]="Seleccionar";
		$campo='menu_fila'; $parametros="'codigocarrera','".$codigocarrera."','onChange=\"enviarmenu(\'codigocarrera\');\"'";
		$formulario->dibujar_campo($campo,$parametros,"Carrera","tdtitulogris",'codigocarrera','');
		}

		if(isset($codigocarrera)&&$codigocarrera!=''){
		//echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=".$REQUEST_URI.">";
			$condicion=" s.idcarreraperiodo=cp.idcarreraperiodo
						and cp.codigocarrera=".$codigocarrera."
				   	 	and cp.codigoperiodo=".$codigoperiodo.
						" and s.codigoestadosubperiodo like '1%'";
			$condicion2=" and idsubperiodo not in (select idsubperiodo from 
						carreragrupofechainscripcion where 
						codigocarrera=".$codigocarrera." 
						and '$fechahoy' between fechadesdecarreragrupofechainscripcion and fechahastacarreragrupofechainscripcion)";
			//if(!isset($_GET['idcarreragrupofechainscripcion']))
			//$condicion.=$condicion2;
			
			$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("subperiodo s, carreraperiodo cp","s.idsubperiodo","s.idsubperiodo",$condicion,"",0);
			$formulario->filatmp[""]="Seleccionar";
			$campo='menu_fila'; $parametros="'idsubperiodo','".$idsubperiodo."','onChange=\"form1.submit();\"'";
			$formulario->dibujar_campo($campo,$parametros,"Subperiodo","tdtitulogris",'idsubperiodo','');
			

			//if($formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("subperiodo s, carreraperiodo cp","s.idsubperiodo","s.idsubperiodo",$condicion,"",0))
			if(isset($idsubperiodo)&&$idsubperiodo!='')
			{
				$condicion="and codigocarrera=".$codigocarrera;	
						   
				if(!isset($_GET['idcarreragrupofechainscripcion']))
					if($recuperarfechainscripcion=$objetobase->recuperar_datos_tabla("carreragrupofechainscripcion","idsubperiodo",$idsubperiodo,$condicion,'',0))
						echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=".$REQUEST_URI."?idcarreragrupofechainscripcion=".$recuperarfechainscripcion['idcarreragrupofechainscripcion']."'>";

				
				$condicion=" codigoperiodo=".$codigoperiodo." 
								and '$fechahoy' between fechainiciogrupo and fechafinalgrupo
								order by idgrupo";
			
				$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("grupo g","g.idgrupo","g.nombregrupo",$condicion,"",0);
				$formulario->filatmp[""]="No requiere";
				if($idgrupo=="1") $idgrupo="";
				$campo='menu_fila'; $parametros="'idgrupo','".$idgrupo."',''";
				$formulario->dibujar_campo($campo,$parametros,"Grupo","tdtitulogris",'idgrupo','');
		
		
				$campo = "campo_fecha"; $parametros ="'text','fechainicio','".$fechainicio."','onKeyUp = \"this.value=formateafecha(this.value);\" $funcionfechainicial'";
				$formulario->dibujar_campo($campo,$parametros,"Fecha de inicio","tdtitulogris",'fechainicio','requerido');
				$campo="campo_fecha"; $parametros="'text','fechafinal','".$fechafinal."','onKeyUp = \"this.value=formateafecha(this.value);\" '";
				$formulario->dibujar_campo($campo,$parametros,"Fecha Final","tdtitulogris",'fechafinal','requerido');
				$campo="campo_fecha"; $parametros="'text','fechainformacion','".$fechainformacion."','onKeyUp = \"this.value=formateafecha(this.value);\" '";
				$formulario->dibujar_campo($campo,$parametros,"Fecha Informacion","tdtitulogris",'fechainformacion','requerido');
				
				if(isset($_GET['idcarreragrupofechainscripcion'])){
					$parametrobotonenviar[$conboton]="'submit','Modificar','Modificar'";
					$boton[$conboton]='boton_tipo';
					//$conboton++;
					//$parametrobotonenviar[$conboton]="'submit','Anular','Anular'";
					//$boton[$conboton]='boton_tipo';
					$formulario->boton_tipo('hidden','idcarreragrupofechainscripcion',$_GET['idcarreragrupofechainscripcion']);
					$conboton++;

				}
				else{
					$parametrobotonenviar[$conboton]="'submit','Enviar','Enviar'";
					$boton[$conboton]='boton_tipo';
					$conboton++;

				}
				
			}
		}

		$parametrobotonenviar[$conboton]="'Listado','listadocarreragrupoinscripcion.php','codigoperiodo=".$codigoperiodo."&link_origen= ".$_GET['link_origen']."',700,600,5,50,'yes','yes','no','yes','yes'";
		$boton[$conboton]='boton_ventana_emergente';

		//$conboton++;
		//$parametrobotonenviar[$conboton]="'button','Regresar','Regresar','onclick=\'regresarGET();\''";
		//$boton[$conboton]='boton_tipo';
		$formulario->dibujar_campos($boton,$parametrobotonenviar,"","tdtitulogris",'Enviar');

if(isset($_REQUEST['Enviar'])){
			if($formulario->valida_formulario()){
					if(validar_diferencia_fechas($_POST['fechainicio'],$_POST['fechafinal'])){
					$tabla="carreragrupofechainscripcion";
						$fila["codigocarrera"]=$_POST["codigocarrera"];
						if(isset($_POST["idgrupo"])&&$_POST["idgrupo"]!="")
						$fila["idgrupo"]=$_POST["idgrupo"];
						else
						$fila["idgrupo"]=1;
						$fila["fechacarreragrupofechainscripcion"]=date("Y-m-d");
						$fila["idsubperiodo"]=$_POST["idsubperiodo"];
						$fila["fechadesdecarreragrupofechainscripcion"]=formato_fecha_mysql($_POST["fechainicio"]);
						$fila["fechahastacarreragrupofechainscripcion"]=formato_fecha_mysql($_POST["fechafinal"]);
						$fila["fechahastacarreragrupofechainformacion"]=formato_fecha_mysql($_POST["fechainformacion"]);
						
						if(isset($usuario["idusuario"])&&$usuario["idusuario"]!='')
						$fila["idusuario"]=$usuario["idusuario"];
						else
						$fila["idusuario"]=1;
						$fila["ip"]=$ip;
						$condicionactualiza=" idgrupo=".$fila["idgrupo"].
											" and idsubperiodo=".$fila["idsubperiodo"].
											" and codigocarrera=".$fila["codigocarrera"];
						$objetobase->insertar_fila_bd($tabla,$fila,0,$condicionactualiza);
						alerta_javascript("Realizo los cambios correctamente"); 
						echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=$REQUEST_URI'>";

					}
					else
					{
						alerta_javascript("fecha de inicio <".$_POST['fechainicio']."> no puede ser \\n mayor o igual a la fecha final <".$_POST['fechafinal'].">"); 
					}
			}
}		
if(isset($_REQUEST['Modificar'])){
	if($formulario->valida_formulario()){
		if(validar_diferencia_fechas($_POST['fechainicio'],$_POST['fechafinal'])){
		$tabla="carreragrupofechainscripcion";
			$nombreidtabla="idcarreragrupofechainscripcion";
			$idtabla=$_POST['idcarreragrupofechainscripcion'];
			if(isset($_POST["idgrupo"])&&$_POST["idgrupo"]!="")
				$fila["idgrupo"]=$_POST["idgrupo"];
			else
				$fila["idgrupo"]=1;

			$fila["idsubperiodo"]=$_POST["idsubperiodo"];
			$fila["fechadesdecarreragrupofechainscripcion"]=formato_fecha_mysql($_POST["fechainicio"]);
			$fila["fechahastacarreragrupofechainscripcion"]=formato_fecha_mysql($_POST["fechafinal"]);
			$fila["fechahastacarreragrupofechainformacion"]=formato_fecha_mysql($_POST["fechainformacion"]);

			$fila["codigocarrera"]=$_POST["codigocarrera"];
			if(isset($usuario["idusuario"])&&$usuario["idusuario"]!='')
				$fila["idusuario"]=$usuario["idusuario"];
			else
				$fila["idusuario"]=1;
			$objetobase->actualizar_fila_bd($tabla,$fila,$nombreidtabla,$idtabla);
			alerta_javascript("Realizo los cambios correctamente"); 
			echo "<META HTTP-EQUIV='Refresh' CONTENT='0' URL='carreragrupofechainscripcion.php'>";
		}
		else
		{
			alerta_javascript("fecha de inicio <".$_POST['fechainicio']."> no puede ser \\n mayor o igual a la fecha final <".$_POST['fechafinal'].">"); 
			//echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=carreragrupofechainscripcion.php'>";
		}
	}
	

}		
if(isset($_REQUEST['Anular'])){
}		

	?>
		
  </table>
</form>