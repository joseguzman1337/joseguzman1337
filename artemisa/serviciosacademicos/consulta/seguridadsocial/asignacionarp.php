<?php session_start();
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
require_once("funciones/FuncionesAportes.php");

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
	document.location.href="<?php echo '../prematricula/matriculaautomaticaordenmatricula.php';?>";
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
<form name="form1" action="" method="POST" >
<input type="hidden" name="AnularOK" value="">
	<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="750">
	<?php 
		//$formulario->dibujar_fila_titulo('APORTES SEGURIDAD SOCIAL EPS ARP','labelresaltado',"2","align='center'");
		$formulario->dibujar_fila_titulo('Asignacion ARP','labelresaltado');
		

		$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("periodo","codigoperiodo","codigoperiodo");
		
		$codigoperiodo=$_SESSION['codigoperiodosesion'];
		if(isset($_POST['codigoperiodo']))
		$codigoperiodo=$_POST['codigoperiodo'];
		$campo='menu_fila'; $parametros="'codigoperiodo','".$codigoperiodo."',''";
		$formulario->dibujar_campo($campo,$parametros,"Periodo","tdtitulogris",'codigoperiodo','requerido');
		
		//$fechainicio=date("d/m/Y");

			$mesinicial["mes"]="01"; $mesinicial["anio"]="2005";
			$mesfinal["mes"]="12";  $mesfinal["anio"]="2035";
			$meshoy=date("m")."/".date("Y");
			//$formulario->filatmp=meses_anios($mesinicial,$mesfinal);
			$formulario->filatmp=listadomesesproceso($objetobase,date("d/m/Y"),4,0);
			if(isset($_POST['mescierre']))
			$meshoy=$_POST['mescierre'];
			$campo='menu_fila'; $parametros="'mescierre','".$meshoy."',''";
			$formulario->dibujar_campo($campo,$parametros,"Mes de cierre","tdtitulogris",'mescierre','');
		
		$condicion="c.codigomodalidadacademica=300";
		//if(!isset($_GET['idcarreracentrotrabajo']))
		$condicion.=" and c.codigocarrera  in (select c.codigocarrera from carrera c, carreracentrotrabajoarp cc where
					 c.codigocarrera=cc.codigocarrera and
					 cc.codigoestado like '1%')
					 order by nombrecarrera2";
		$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("carrera c","c.codigocarrera","c.nombrecarrera",$condicion,', replace(c.nombrecarrera,\' \',\'\') nombrecarrera2');
		$formulario->filatmp[""]="Seleccionar";
		if(isset($_POST['codigocarrera'])) $codigocarrera=$_POST['codigocarrera'];
		$menu="menu_fila"; $parametros="'codigocarrera','".$codigocarrera."','onchange=\'enviar();\''";
		$formulario->dibujar_campo($menu,$parametros,"Carrera","tdtitulogris","codigocarrera",'requerido');
		
		$escogertipoarp=$_POST['escogertipoarp'];
		$condicion="ti.nombretipoempresasalud like 'ERP%' and
					em.codigotipoempresasalud=ti.codigotipoempresasalud";
  		$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("empresasalud em, tipoempresasalud ti","idempresasalud","nombreempresasalud",$condicion);
		$menu='menu_fila'; $parametros="'escogertipoarp','".$escogertipoarp."',''";
  	
		$formulario->dibujar_campo($menu,$parametros,"Empresa ARP","tdtitulogris","escogertipoarp",'requerido');

				  $fechaingreso=date("d/m/Y");
				  $formulario->boton_tipo('hidden','fechaingreso',$fechaingreso);
	
				  $fechafinal="01/01/2099";
				  $formulario->boton_tipo('hidden','fechafinal',$fechafinal);
		
		$estado=$_POST['estado'];
		$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("estado","codigoestado","nombreestado",'');
		$menu='menu_fila'; $parametros="'estado','".$estado."',''";
		$formulario->dibujar_campo($menu,$parametros,"Estado","tdtitulogris","escogertipoarp",'requerido');

		$conboton=0;
		if(isset($_POST['codigocarrera'])&&$_POST['codigocarrera']!=''){
					$parametrobotonenviar[$conboton]="'submit','Enviar','Enviar'";
					$boton[$conboton]='boton_tipo';
		$conboton++;					
					}

			
						//$parametrobotonenviar[$conboton]="'button','Regresar','Regresar','onclick=\'regresarGET();\''";
						//$boton[$conboton]='boton_tipo';
						$formulario->dibujar_campos($boton,$parametrobotonenviar,"","tdtitulogris",'Enviar');


	if(isset($_REQUEST['Enviar'])){
	//$query==querylistadocierre(0,1,$_POST['codigoperiodo'],300,0);
	$query="SELECT distinct 
	e.idestudiantegeneral,
	e.codigoestudiante Codigo_Estudiante,
	d.nombrecortodocumento Tipo,
	eg.numerodocumento,
	eg.apellidosestudiantegeneral apellidos,
	eg.nombresestudiantegeneral nombres,
	c.nombrecortocarrera,
	c.codigocarrera
	FROM estudiante e, estudiantegeneral eg, 
	carrera c, modalidadacademica ma, documento d,  ordenpago op
	WHERE e.idestudiantegeneral=eg.idestudiantegeneral
	AND e.codigocarrera = c.codigocarrera
	AND c.codigocarrera =".$_POST['codigocarrera']."
	AND c.codigomodalidadacademica=ma.codigomodalidadacademica
	AND eg.tipodocumento=d.tipodocumento
	AND ma.codigomodalidadacademica=300
	AND e.codigoestudiante=op.codigoestudiante
	AND op.codigoperiodo='".$_POST['codigoperiodo']."'
	AND op.codigoestadoordenpago like '4%'
	order by apellidosestudiantegeneral,nombresestudiantegeneral
	";
	$tabla="estudiantenovedadarp";
	$operacion=$objetobase->conexion->query($query);
	$condicion="and codigoestado like '1%' 
				and '".formato_fecha_mysql("01/".$_POST['mescierre'])."' between fechainicionovedadarp and fechafinalnovedadarp";
	$novedad=$objetobase->recuperar_datos_tabla("novedadarp","nombrecortonovedadarp","INA",$condicion,"",0);

	$fecha_inicio_mes=inicio_mes_fecha($_POST['fechaingreso']);
	//if(!validar_diferencia_fechas("01/".$_POST['mescierre'],$fecha_inicio_mes)){
			$finalmes=final_mes_fecha(date("d/m/Y"));	
			//if(!validar_diferencia_fechas("01/".$_POST['mescierre'],$finalmes)){
				//alerta_javascript("fecha de inicio de ingreso no \\n puede ser mayor o igual al final del mes en curso<".$_POST['fechainicio'].">"); 
			//}
			//else{						
while ($row_operacion=$operacion->fetchRow()){
					$idtabla=$row_operacion['idestudiantegeneral'];
					//$condicion="and idnovedadarp=".$novedad['idnovedadarp'].
								//" and '".formato_fecha_mysql($_POST['fechainicio'])."' between fechainicioestudiantenovedadarp and fechafinalestudiantenovedadarp ";
					//$filaactualizar['codigoestado']=200;
					//$objetobase->actualizar_fila_bd($tabla,$filaactualizar,'idestudiantegeneral',$idtabla,$condicion);
					
					$fila["idestudiantegeneral"]=$idtabla;
					$fila["idnovedadarp"]=$novedad['idnovedadarp'];
					$fila["fechaestudiantenovedadarp"]=formato_fecha_mysql($_POST['fechaingreso']);
					$fila["fechainicioestudiantenovedadarp"]=formato_fecha_mysql("01/".$_POST['mescierre']);
					$fila["fechafinalestudiantenovedadarp"]=formato_fecha_mysql($_POST['fechafinal']);
					$fila["observacionnovedadarp"]="";
					$fila["codigoestado"]=$_POST['estado'];
					$fila["idestudiantenovedadarporigen"]=0;
					$fila["numerodocumentonovedadarp"]=0;
					$fila["idempresasalud"]=$_POST['escogertipoarp'];
				
				//Actualizacion ARP	si hay una vigente
				if($_POST['estado']==100)
				{
					$condicion="and en.codigoestado like '1%' and 
									no.idnovedadarp = en.idnovedadarp and 
									no.codigotiponovedadarp like '1%' and
									no.codigotipoaplicacionnovedadarp like '2%' and 
									 no.codigoestado like '1%' and".
									" '".formato_fecha_mysql("01/".$_POST['mescierre'])."' between no.fechainicionovedadarp and no.fechafinalnovedadarp and ".
									"('".$fila["fechaestudiantenovedadarp"]."' between en.fechainicioestudiantenovedadarp and en.fechafinalestudiantenovedadarp)";
									$datosnovedadvigente=$objetobase->recuperar_datos_tabla("estudiantenovedadarp en, novedadarp no","en.idestudiantegeneral",$fila["idestudiantegeneral"],$condicion,', en.fechainicioestudiantenovedadarp inicionovedadarp',0);
									$idtablavencida=$datosnovedadvigente['idestudiantenovedadarp'];
								$fechainiciovencida=$datosnovedadvigente['inicionovedadarp'];
								$fechainiciovencidaformato=formato_fecha_defecto($fechainiciovencida);
					
								$fechainiciovector=vector_fecha("01/".$_POST['mescierre']);
								$filavencida['fechafinalestudiantenovedadarp']=formato_fecha_mysql(agregarceros(($fechainiciovector["dia"]-1),2)."/".agregarceros($fechainiciovector["mes"],2)."/".$fechainiciovector["anio"]);
					
				if(validar_diferencia_fechas($fechainiciovencidaformato,("01/".$_POST['mescierre'])))
					if(isset($idtablavencida)&&($idtablavencida!=''))
					$objetobase->actualizar_fila_bd($tabla,$filavencida,'idestudiantenovedadarp',$idtablavencida);
				}
				//Ingreso nueva ARP
					$condicionactualiza="idestudiantegeneral=".$fila["idestudiantegeneral"].
										" and fechainicioestudiantenovedadarp='".$fila["fechainicioestudiantenovedadarp"].
										"' and idnovedadarp='".$fila["idnovedadarp"]."'";
					$objetobase->insertar_fila_bd($tabla,$fila,0,$condicionactualiza);
}

			//}
	/*}
	else{
						alerta_javascript("fecha de la novedad no puede ser \\n ingresada anterior al inicio del mes en curso <".$fechainiciovencida.">"); 	
	}*/


	
}
?>

	
  </table>
</form>