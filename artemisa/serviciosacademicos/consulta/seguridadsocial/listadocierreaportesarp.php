<?php
session_start();
?>
<!--<link rel="stylesheet" type="text/css" href="../../sala.css">-->
<link rel="stylesheet" type="text/css" href="../../estilos/sala.css">
<script LANGUAGE="JavaScript">
function regresarGET()
{
	document.location.href="<?php echo 'menuinicialaportes.php';?>";
}
function reCarga(){
	document.location.href="<?php echo 'menuinicialaportes.php';?>";
}
function cambiaaction()
{
location.href="<?php echo 'listadocierreaportes.php';?>";
}
//quitarFrame()
</script>
<?php
$rutaado=("../../funciones/adodb/");
require_once("../../funciones/clases/debug/SADebug.php");
require_once("../../Connections/salaado-pear.php");
require_once("../../funciones/clases/formulario/clase_formulario.php");
require_once("../../funciones/phpmailer/class.phpmailer.php");
require_once("../../funciones/validaciones/validaciongenerica.php");
require_once("../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../funciones/sala_genericas/FuncionesMatriz.php");

require_once("../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../../funciones/sala_genericas/DatosGenerales.php");
require_once("../../funciones/clases/motorv2/motor.php");
require_once("funciones/FuncionesAportes.php");
function postget($fila){
	$cadena="";
	while (list ($clave, $val) = each ($fila)) {
		$cadena.=$clave."=".$val."&";
	}
return $cadena;
}
$datos_bd=new BaseDeDatosGeneral($sala);
$formulario=new formulariobaseestudiante($sala,'form2','post','','true');
//print_r($_SESSION);
echo "<form name=\"form2\" action=\"listadocierreaportesarp.php\" method=\"post\"  >
<input type=\"hidden\" name=\"AnularOK\" value=\"\">
	<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\">";
 	$formulario->dibujar_fila_titulo('APORTES SEGURIDAD SOCIAL EPS ARP','labelresaltado',"2","align='center'");

	$formulario->dibujar_fila_titulo('Datos Generales','labelresaltado');
	$mesinicial["mes"]="01"; $mesinicial["anio"]=date("Y")-1;
	$mesfinal["mes"]="12";  $mesfinal["anio"]=date("Y")+1;
	$meshoy=date("m")."/".date("Y");
	$formulario->filatmp=meses_anios($mesinicial,$mesfinal);
	//$formulario->filatmp=listadomesesproceso($datos_bd,date("d/m/Y"),4,0);
	if(isset($_POST['mescierre']))
	$meshoy=$_POST['mescierre'];
	if(isset($_GET['mescierre']))
	$meshoy=$_GET['mescierre'];
	
	$campo='menu_fila'; $parametros="'mescierre','".$meshoy."',''";
	$formulario->dibujar_campo($campo,$parametros,"Mes de cierre","tdtitulogris",'mescierre','');

	$formulario->filatmp=$datos_bd->recuperar_datos_tabla_fila("periodo","codigoperiodo","codigoperiodo","codigoperiodo=codigoperiodo order by codigoperiodo desc");
	$codigoperiodo=$_SESSION['codigoperiodosesion'];
	if(isset($_POST['codigoperiodo']))
	$codigoperiodo=$_POST['codigoperiodo'];
	if(isset($_GET['codigoperiodo']))
	$codigoperiodo=$_GET['codigoperiodo'];

	$campo='menu_fila'; $parametros="'codigoperiodo','".$codigoperiodo."',''";
	$formulario->dibujar_campo($campo,$parametros,"Periodo","tdtitulogris",'codigoperiodo','');
	
	$formulario->filatmp=$datos_bd->recuperar_datos_tabla_fila("modalidadacademica","codigomodalidadacademica","nombremodalidadacademica");
	$formulario->filatmp[""]="Seleccionar";
	if(!isset($_POST['codigomodalidadacademica']))
	$codigomodalidadacademica=300;
	else
	$codigomodalidadacademica=$_POST['codigomodalidadacademica'];

	if(isset($_GET['codigomodalidadacademica'])&&($codigomodalidadacademica==300))
	$codigomodalidadacademica=$_GET['codigomodalidadacademica'];
	
	$campo='menu_fila'; $parametros="'codigomodalidadacademica','".$codigomodalidadacademica."','onChange=\"\"enviarmenu(\'codigomodalidadacademica\');\"'";
	$formulario->dibujar_campo($campo,$parametros,"Modalidad","tdtitulogris",'codigomodalidadacademica','');

/*	if($_POST['pagoeps']) $checked="checked"; else $checked="";
	$parametros="'checkbox','pagoeps','1','$checked'";
	$campo='boton_tipo';
	$formulario->dibujar_campo($campo,$parametros,"Pago de EPS","tdtitulogris",'pagoeps');

	if($_POST['pagoarp']) $checked="checked"; else $checked="";
	$parametros="'checkbox','pagoarp','1','$checked'";
	$campo='boton_tipo';
	$formulario->dibujar_campo($campo,$parametros,"Pago de ARP","tdtitulogris",'pagoarp');
*/

	$formulario->filatmp["1"]="Si";$formulario->filatmp["2"]="No";$formulario->filatmp["0"]="NA";
 	$defecto="NA";

	if($_POST['pagoeps'])  $pagoeps=$_POST['pagoeps']; 	else $defecto;
			
	$parametros="'pagoeps','".$pagoeps."',''";
	$campo='menu_fila';
	$formulario->dibujar_campo($campo,$parametros,"Pago de EPS","tdtitulogris",'pagoeps');
	
	unset($formulario->filatmp);
	$formulario->filatmp["1"]="Si";$formulario->filatmp["2"]="No";$formulario->filatmp["0"]="NA";
 	$defecto="NA";
	if($_POST['pagoarp']) $pagoarp=$_POST['pagoarp']; else $pagoarp=$defecto;
	$parametros="'pagoarp','".$pagoarp."',''";
	$campo='menu_fila';
	$formulario->dibujar_campo($campo,$parametros,"Pago de ARP","tdtitulogris",'pagoarp');

	/*if($_POST['ingresado']) $checked="checked"; else $checked="";
	$parametros="'checkbox','ingresado','1','$checked'";
	$campo='boton_tipo';
	$formulario->dibujar_campo($campo,$parametros,"Solo Ingresados","tdtitulogris",'ingresado');
*/
	unset($formulario->filatmp);
	$formulario->filatmp["6"]="Ingresado"; $formulario->filatmp["5"]="No ingresados"; $formulario->filatmp["0"]="NA";
 	$defecto="NA";
	if($_POST['ingresado']) $ingresado=$_POST['ingresado']; else $ingresado=$defecto;
	$parametros="'ingresado','".$ingresado."',''";
	$campo='menu_fila';
	$formulario->dibujar_campo($campo,$parametros,"Ingresados","tdtitulogris",'ingresado');

	unset($formulario->filatmp);
	$formulario->filatmp=$datos_bd->recuperar_datos_tabla_fila("estadoordenpago","codigoestadoordenpago","nombreestadoordenpago"," (codigoestadoordenpago % 10) = 0");
	$formulario->filatmp["NA"]="NA";

	$defecto="40";
	if($_POST['ordenpago']) $ordenpago=$_POST['ordenpago']; else $ordenpago=$defecto;

	$parametros="'ordenpago','".$ordenpago."',''";

	$campo='menu_fila';
	$formulario->dibujar_campo($campo,$parametros,"Orden de pago","tdtitulogris",'ordenpago');


	$conboton=0;
	$parametrobotonenviar[$conboton]="'submit','Informe','Informe',''";
	$boton[$conboton]='boton_tipo';
	$conboton++;
	//ventana_emergente_submit('archivoplano.php','archivoplano','Archivo Plano','600','400','form2')
	
	$parametrobotonenviar[$conboton]="'fechaarchivoplanoarp.php','archivoplano','Archivo Plano','300','300','form2','yes'";
	$boton[$conboton]='ventana_emergente_submit';
	$conboton++;
	$parametrobotonenviar[$conboton]="'planopdfarp.php','planopdf','Archivo PDF','600','400','form2','yes'";
	$boton[$conboton]='ventana_emergente_submit';
	$conboton++;

	$parametrobotonenviar[$conboton]="'button','Regresar','Regresar','onclick=\'regresarGET();\''";
	$boton[$conboton]='boton_tipo';

	$formulario->dibujar_campos($boton,$parametrobotonenviar,"","tdtitulogris",'Enviar');
	
	//$formulario->boton_tipo('hidden','codigoperiodosesion',$_POST['codigoperiodo']);
	//echo "ESTADO ORDEN=".$ordenpago."<br>";

echo "</table>
</form>";
//echo "<table>";
//echo "</table>";


if(isset($_POST['mescierre'])){
$_SESSION['sesion_arrayinterno']=NULL;
$_SESSION['sesion_mescierre']=$_POST['mescierre'];
}
if(isset($_POST['codigoperiodo']))
$_SESSION['sesion_codigoperiodo']=$_POST['codigoperiodo'];



//print_r($_SERVER['REQUEST_URI']);
function devuelve_busqueda($codigoperiodo,$datos_bd,$sala,$mescierre,$pagoeps=1,$pagoarp=1,$ingresado=0,$codigomodalidadacademica=300){
//".$_SESSION['codigoperiodosesion']."
	$defecto="40";
	if($_POST['ordenpago']) $ordenpago=$_POST['ordenpago']; else $ordenpago=$defecto;

$query=querylistadocierrearp($_POST['pagoeps'],$_POST['pagoarp'],$_POST['codigoperiodo'],$codigomodalidadacademica,0,$ordenpago);

$operacion=$sala->query($query);
$row_operacion=$operacion->fetchRow();


$operacionuniversidad=LeerUniversidad(1,$sala);
$row_operacion_universidad=$operacionuniversidad->fetchRow();

$total=0;
do
{
	//$row_operacion['Empresa_Salud']=recuperar_empresasalud($datos_bd,$row_operacion['idestudiantegeneral'],$_POST['mescierre'])."&nbsp;";
	//echo "<---".$row_operacion['idestudiantegeneral']."---><br>";
	
	
if(isset($row_operacion['idestudiantegeneral'])||($row_operacion['idestudiantegeneral']!='')){	
		
		$condicion=" and c.codigocarrera=e.codigocarrera
		group by idestudiantegeneral";
		$datos_estudiante=$datos_bd->recuperar_datos_tabla("estudiante e, carreracentrotrabajoarp c","idestudiantegeneral",$row_operacion['idestudiantegeneral'],$condicion,', max(codigoestudiante) numeroestudiante');

		
		if(validar_estudiante_arp($mescierre,$datos_estudiante['codigoestudiante'],$datos_bd,$pagoeps,$pagoarp,$ingresado))
				if(validar_estudiante_arp($mescierre,$datos_estudiante['codigoestudiante'],$datos_bd,$pagoeps,$pagoarp,4)){

		$row_temp['codigoestudiante']=$datos_estudiante['codigoestudiante'];
		$row_operacion=InsertarColumnaFila($row_operacion,$row_temp,2);

		$datosnovedad=eps_mes($mescierre,$row_operacion['idestudiantegeneral'],$datos_bd);
		
		//$row_operacion['EPS']=$datosnovedad['nombreempresasalud']."&nbsp;";
		//$row_operacion['Codigo_EPS']=$datosnovedad['codigoempresasalud']."&nbsp;";
		if(existe_tae_vigente($mescierre,$row_operacion['idestudiantegeneral'],$datos_bd)){
		$datosnovedadtae=eps_tae($mescierre,$row_operacion['idestudiantegeneral'],$datos_bd);
		//$row_operacion['EPS_Traslado']=$datosnovedadtae['nombreempresasalud']."&nbsp;";
		//$row_operacion['Codigo_EPS_Traslado']=$datosnovedadtae['codigoempresasalud']."&nbsp;";
		}
		else{
		//$row_operacion['EPS_Traslado']="&nbsp;";
		//$row_operacion['Codigo_EPS_Traslado']="&nbsp;";
		}
		//$datos_ibc_eps=ibc_eps($mescierre,$row_operacion['codigoestudiante'],$datos_bd);
		$datos_ibc_arp=ibc_arp($mescierre,$datos_estudiante['codigoestudiante'],$datos_bd);
			
		//$row_operacion['Dias_EPS']=$datos_ibc_eps['dias_eps'];
		//$row_operacion['Codigo_Traslado_EPS']=;
		//$lapso=lapso_resultado_novedad($mescierre,$row_operacion['idestudiantegeneral'],$datos_bd,'SLN');
		if(!($datos_ina=datos_novedad_vigente($mescierre,$row_operacion['idestudiantegeneral'],$datos_bd,'INA')))
		{
			$datos_ina=datos_novedad_vigente($mescierre,$row_operacion['idestudiantegeneral'],$datos_bd,'IXA');
		}
		
		$datos_arp=$datos_bd->recuperar_datos_tabla("empresasalud","idempresasalud",$datos_ina['idempresasalud']);
		$row_operacion['ARP']=$datos_arp['nombreempresasalud']."&nbsp;";
		$row_operacion['Dias_ARP']=$datos_ibc_arp['dias_arp'];
		//dias_arp($mescierre,$row_operacion['idestudiantegeneral'],$datos_bd);
		//$datoscentrotrabajo=centrotrabajo($mescierre,$row_operacion['Codigo_Estudiante'],$datos_bd);
//		$row_operacion['Salario_basico']=round((2*$datos_ibc_arp['datoscentrotrabajo']['salariobasecotizacioncentrotrabajoarp']),-3)."&nbsp;";
		$row_operacion['Salario_basico']=roundmilss((2*$datos_ibc_arp['datoscentrotrabajo']['salariobasecotizacioncentrotrabajoarp']))."&nbsp;";

		//$row_operacion['IBC_EPS']=$datos_ibc_eps['ibc_eps']."&nbsp;";
		$row_operacion['IBC_ARP']=$datos_ibc_arp['ibc_arp']."&nbsp;";
		//$row_operacion['Tarifa_Aportes']=tarifa_aportes_eps($mescierre,$row_operacion['idestudiantegeneral'],$datos_bd);
		//$row_operacion['Cotizacion_EPS']=round(($row_operacion['Tarifa_Aportes']*$row_operacion['IBC_EPS']),-2);
		$row_operacion['Tarifa_Centro_Trabajo']=$datos_ibc_arp['datoscentrotrabajo']['porcentajecotizacionarp']."&nbsp;";
		$row_operacion['Codigo_Centro_Trabajo']=$datos_ibc_arp['datoscentrotrabajo']['codigocentrotrabajoarp']."&nbsp;";
		//$row_operacion['Cotizacion_ARP']=round(($row_operacion['Tarifa_Centro_Trabajo']*$row_operacion['IBC_ARP']),-2)."&nbsp;";
		$row_operacion['Cotizacion_ARP']=roundcienss(($row_operacion['Tarifa_Centro_Trabajo']*$row_operacion['IBC_ARP']))."&nbsp;";

		$ing=""."&nbsp;";
		if(existe_novedad_vigente_eps($mescierre,$row_operacion['idestudiantegeneral'],$datos_bd,'INA'))
		$ing="<div align='center'>X</div>";
		$row_operacion['ING']=$ing;
	
		$ing=""."&nbsp;";
		if(existe_novedad_vigente_eps($mescierre,$row_operacion['idestudiantegeneral'],$datos_bd,'REA'))
		$ing="<div align='center'>X</div>";
		$row_operacion['RET']=$ing;
	
		$tde=""."&nbsp;";	
		$tae=""."&nbsp;";		
		if($datos_tae=datos_novedad_vigente($mescierre,$row_operacion['idestudiantegeneral'],$datos_bd,'TAE')){
			$taevigente_1=validar_novedad_tae($datos_bd,$datos_tae['idestudiantenovedadarp'],formato_fecha_mysql("01/".$mescierre),$row_operacion['idestudiantegeneral'],0);
			$taevigente_2=validar_novedad_tae($datos_bd,$datos_tae['idestudiantenovedadarp'],formato_fecha_mysql(final_mes_fecha("01/".$mescierre)),$row_operacion['idestudiantegeneral'],0);
			if($taevigente_1||$taevigente_2){
				 if(!existe_tae_vigente($mescierre,$row_operacion['idestudiantegeneral'],$datos_bd)){ 
					$tde="<div align='center'>X</div>";
				}
				else{
					$tae="<div align='center'>X</div>";
				}
			}
		}
		$row_operacion['TDE']=$tde;
		$row_operacion['TAE']=$tae;	
	
		$nombrenovedad=vector_nombres_cortos_novedad(300,$sala)	;
		for($i=0;$i<count($nombrenovedad);$i++){		
		$celda="&nbsp;";
		if($datos_nvd=datos_novedad_vigente($mescierre,$row_operacion['idestudiantegeneral'],$datos_bd,$nombrenovedad[$i]))	 
			if($nombrenovedad[$i]=='IRP')
			$celda="<div align='center'>".$datos_ibc_arp['dias_irp']."</div>";
			else
			$celda="<div align='center'>X</div>";
		$row_operacion[$nombrenovedad[$i]]=$celda;
		}
	
		$array_interno[]=$row_operacion;
		/*$sumacotizacioneps+=$row_operacion['Cotizacion_EPS'];
		$sumacotizacionarp+=$row_operacion['Cotizacion_ARP'];
		$sumaibceps+=$row_operacion['IBC_EPS'];
		$sumaibcarp+=$row_operacion['IBC_ARP'];*/

		$total++;

		}
	}
}
while ($row_operacion=$operacion->fetchRow());
/*
$row_operacion['1']="";$row_operacion['2']="";$row_operacion['3']="";$row_operacion['4']="";$row_operacion['5']="";$row_operacion['6']="";
$row_operacion['7']="";$row_operacion['8']="";$row_operacion['9']="";$row_operacion['10']="";
$row_operacion['EPS']="";
$row_operacion['Codigo_EPS']="";
$row_operacion['EPS_Traslado']="";
$row_operacion['Dias_EPS']="";
$row_operacion['Codigo_EPS_Traslado']="";
$row_operacion['Dias_ARP']="";
$row_operacion['Salario_basico']="<div align='center'><b>TOTALES</b></div>";
$row_operacion['IBC_EPS']="<div align='center'><b>".$sumaibceps."</b></div>";
$row_operacion['IBC_ARP']="<div align='center'><b>".$sumaibcarp."</b></div>";
$row_operacion['Tarifa_Aportes']="";
$row_operacion['Cotizacion_EPS']="<div align='center'><b>".$sumacotizacioneps."</b></div>";
$row_operacion['Tarifa_Centro_Trabajo']="";
$row_operacion['Codigo_Centro_Trabajo']="";
$row_operacion['Cotizacion_ARP']="<div align='center'><b>".$sumacotizacionarp."</b></div>";
*/
$array_interno[]=$row_operacion;
//echo "TOTAL DE REGISTROS=".$total;

return $array_interno;
}
$datos_bd=new BaseDeDatosGeneral($sala);

if(isset($_REQUEST['Informe']))
unset($_GET['Filtrar']);


if(isset($_REQUEST['Informe'])||isset($_REQUEST['Filtrar'])||isset($_REQUEST['Exportar'])||isset($_REQUEST['Restablecer'])){
//unset($_GET['Restablecer']);
unset($_GET['Regresar']);
unset($_SESSION['url_session']);
//unset($_GET['Recargar']);
//unset($_GET['Restablecer']);
if(!isset($_SESSION['sesion_arrayinterno']))
$array_interno=devuelve_busqueda($_SESSION['sesion_codigoperiodo'],$datos_bd,$sala,$_SESSION['sesion_mescierre'],$_POST['pagoeps'],$_POST['pagoarp'],$_POST['ingresado']);

if(!isset($_SESSION['sesion_arrayinterno'])){
$_SESSION['sesion_arrayinterno']=$array_interno;
}
//unset($_GET['Exportar']);

//echo $_SERVER['PHP_SELF']."<br>";
//echo $_SERVER['REQUEST_URI']."<br>";
//echo $_SERVER['PHP_SELF']."?".$cadenapostget."<br>";
$motor = new matriz($_SESSION['sesion_arrayinterno'],'APORTES_SEGURIDAD_SOCIAL_POSTGRADO','listadocierreaportes.php','si','si','listadocierreaportes.php','',false,'si','../../');
$motor->botonRecargar=false;
$motor->botonRegresar=false;
$motor->agregarllave_drilldown('numerodocumento','listadocierreaportesarp.php','ingresoaportes.php','','codigoestudiante',"",'','','','','onclick= "return ventanaprincipal(this)"');
//$motor->agregar_llaves_totales('IBC_EPS',"","","totales","","codigoestudiante","","xx",true);
$motor->agregar_llaves_totales('IBC_ARP',"","","totales","","codigoestudiante","","xx",true);
//$motor->agregar_llaves_totales('Cotizacion_EPS',"","","totales","","codigoestudiante","","xx",true);
$motor->agregar_llaves_totales('Cotizacion_ARP',"","","totales","","codigoestudiante","","xx",true);
//$motor->agregar_llaves_totales('Salario_basico',"","","totales","","codigoestudiante","","xx",false);
//unset($_GET['Filtrar']);
$motor->jsVarios();
$motor->mostrar();
}

?>

