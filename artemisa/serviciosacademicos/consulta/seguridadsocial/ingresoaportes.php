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
function validacionprocesoactivo($fechadeingreso,$objetobase,$idproceso,$imprimir=0){
$condicion=" and d.codigoestado like '1%'
			and '".formato_fecha_mysql($fechadeingreso)."' between d.fechainiciodetalleproceso and d.fechafinaldetalleproceso ";
	if($datos=$objetobase->recuperar_datos_tabla("detalleproceso d","d.idproceso",$idproceso,$condicion,'',$imprimir))
		return true;
	return false;
}
function validar_ingreso_vigente($idestudiantegeneral,$objetobase,$fechahoy){
		
		$fechahoy=formato_fecha_mysql(formato_fecha_defecto($fechahoy));

		$condicion="es.idestudiantegeneral=en.idestudiantegeneral and 
					en.idnovedadarp=no.idnovedadarp and
					en.codigoestado like '1%' and
					no.codigotiponovedadarp like '1%' and
					no.codigotipoaplicacionnovedadarp like '1%' and
					no.codigoestado like '1%' and
					('$fechahoy' between no.fechainicionovedadarp and no.fechafinalnovedadarp) and	
					('$fechahoy' between en.fechainicioestudiantenovedadarp and en.fechafinalestudiantenovedadarp)
					and es.idestudiantegeneral=".$idestudiantegeneral;
		$datosvalidarnovedad=$objetobase->recuperar_datos_tabla_fila("estudiantegeneral es, estudiantenovedadarp en, novedadarp no","no.idnovedadarp","no.nombrecortonovedadarp",$condicion,'',0);
		$i=0;
		if((isset($datosvalidarnovedad))&&($datosvalidarnovedad!=""))
		while (list ($clave, $val) = each ($datosvalidarnovedad)) {
			$i++;
		}
		$vigente=0;
		if($i>0){
		$vigente=1;
		}
		return $vigente;
}
function validar_novedad_tae($objetobase,$clave,$fechahoy,$idestudiantegeneral,$mensaje=0){
//El intervalo en el que no debe aparecer esta novedad es dentro  de los dos meses a partir de la
//fecha de inicio de la novedad
				//Encuentra una fecha de inicio si hay una TAE vigente
				$condicion=" and idestudiantegeneral=".$idestudiantegeneral.
						   " and ('$fechahoy' between es.fechainicioestudiantenovedadarp and es.fechafinalestudiantenovedadarp)";
				$datosnovedad=$objetobase->recuperar_datos_tabla("estudiantenovedadarp es","es.idestudiantenovedadarp",$clave,$condicion,'',0);
				$fechainicionovedad=$datosnovedad['fechainicioestudiantenovedadarp'];
				//$fechainicionovedad="2006-12-27";
				//alerta_javascript($fechainicionovedad);
				$fechanovedad=vector_fecha(formato_fecha_defecto($fechainicionovedad));
				$fechasiguiente=mes_siguiente($fechanovedad['mes'],$fechanovedad['anio']);
				//alerta_javascript($fechasiguiente["anio"]."<---->".$fechasiguiente["mes"]);	
				$no_dias=final_mes(agregarceros($fechasiguiente["mes"],2),$fechasiguiente["anio"]);
				$fechafinal=$no_dias."/".agregarceros($fechasiguiente["mes"],2)."/".$fechasiguiente["anio"];
				$fechaactual=formato_fecha_defecto($fechahoy);
				//$fechaactual="01/03/2007";
				if($mensaje)
				alerta_javascript($fechaactual."<-->".$fechafinal);
				$diferencia=diferencia_fechas($fechaactual,$fechafinal,"dias");
				//alerta_javascript($diferencia);
				if($diferencia>=1)
				$siga=1;
				else
				$siga=0;
	return $siga;
}
function validar_listado_novedades($idestudiantegeneral,$objetobase,$fechahoy,$novedadingresoexiste,$idestudiantenovedadarp='')
{
		$fechahoy=formato_fecha_mysql(formato_fecha_defecto($fechahoy));
		$condicion="es.idestudiantegeneral=en.idestudiantegeneral and 
					en.idnovedadarp=no.idnovedadarp and
					en.codigoestado like '1%' and
					no.codigoestado like '1%' and
					('$fechahoy' between no.fechainicionovedadarp and no.fechafinalnovedadarp) and
					('$fechahoy' between en.fechainicioestudiantenovedadarp and en.fechafinalestudiantenovedadarp)
					and es.idestudiantegeneral=".$idestudiantegeneral;
		$datosvalidarnovedad=$objetobase->recuperar_datos_tabla_fila("estudiantegeneral es, estudiantenovedadarp en, novedadarp no","en.idestudiantenovedadarp","no.nombrecortonovedadarp",$condicion,'',0);
		$datosestudiantenovedad=$objetobase->recuperar_datos_tabla("estudiantenovedadarp es","es.idestudiantenovedadarp",$idestudiantenovedadarp,'');
		$i=0;
		$novedadingresoarpexiste=0;
		if($idestudiantenovedadarp!='')
			$condicionvalidacionnovedad=" and idnovedadarp=".$datosestudiantenovedad['idnovedadarp'];
		else{
			if((isset($datosvalidarnovedad))&&($datosvalidarnovedad!=""))
			while (list ($clave, $val) = each ($datosvalidarnovedad)) {
				
				$siga=1;
				if($val=="TAE"){
				$siga=validar_novedad_tae($objetobase,$clave,$fechahoy,$idestudiantegeneral);
				}
				if($siga){
					if($i>0){
						
						$valores .= ",'".$val."'";
					}
					else{
						$valores .= "'".$val."'";
					}
				$i++;
				}
				//echo "if($val=='TAE'){";

			}
			
		if($i>0)
		$condicionvalidacionnovedad=" and nombrecortonovedadarp not in ($valores,'TDE','000')";
		else 
		$condicionvalidacionnovedad=" and nombrecortonovedadarp not in ('TDE','000')";
		
		if(!$novedadingresoexiste)
		$condicionvalidacionnovedad=" and nombrecortonovedadarp in ('ING')";
		else
		$condicionvalidacionnovedad.=" and nombrecortonovedadarp not in ('ING')";
		}
		
		$condicionvalidacionnovedad;

	return $condicionvalidacionnovedad;
	
}

function recuperar_datos($idestudiantenovedadarp,$objetobase){
$condicion="idestudiantenovedadarp=".$idestudiantenovedadarp;
$datosestudiantenovedadarp=$objetobase->recuperar_datos_tabla("estudiantenovedadarp es","es.idestudiantenovedadarp",$idestudiantenovedadarp,'','',0);
return $datosestudiantenovedadarp;
}
function validar_estudiante_postgrado($objetobase,$codigoestudiante){

$condicion= "
AND e.codigocarrera = c.codigocarrera
AND c.codigomodalidadacademica=ma.codigomodalidadacademica
AND ma.codigomodalidadacademica=300";
$datosestudiante=$objetobase->recuperar_datos_tabla("estudiante e, modalidadacademica ma, carrera c","e.codigoestudiante",$codigoestudiante,$condicion,'',0);
if(!(isset($datosestudiante['idestudiantegeneral'])&&($datosestudiante['idestudiantegeneral']!='')))
{
alerta_javascript("A este estudiante no se le debe registrar seguridad social");
echo "<script LANGUAGE=\"JavaScript\">
history.back();
</script>";
}
}
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
	document.location.href="<?php 
	if(isset($_GET['link_origen'])&&($_GET['link_origen']!=''))
	echo $_GET['link_origen'];
	else
	echo '../prematricula/matriculaautomaticaordenmatricula.php';?>";
}
function cambiefechafinal(obj){
form1.fechafinal.value=obj.value;
}
function enviar(){
form1.submit();
}
//quitarFrame()
</script>
<link rel="stylesheet" type="text/css" href="../../estilos/sala.css">
<script type="text/javascript" src="../../funciones/sala_genericas/funciones_javascript.js"></script>
<style type="text/css">@import url(../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../funciones/calendario_nuevo/calendar-setup.js"></script>
<script type="text/javascript" src="../../funciones/clases/formulario/globo.js"></script>


<?php
//print_r($_SESSION);
$fechahoy=date("Y-m-d H:i:s");

$formulario=new formulariobaseestudiante($sala,'form1','post','','true');
$formulario2=new formulariobaseestudiante($sala,'form1','post','','true');
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
$formulario2->agregar_tablas('estudiantegeneral','idestudiantegeneral');
$formulario->agregar_tablas('estudiante','codigoestudiante');


$usuario=$formulario->datos_usuario();
$ip=$formulario->GetIP();
//echo "LINK_ORIGEN=".$_GET['link_origen'];
if(isset($_GET['codigoestudiante']) and $_GET['codigoestudiante']!="")
{


		$row_estudiante=$formulario->datos_estudiante_noprematricula($_GET['codigoestudiante']);
		$formulario->cargar('codigoestudiante', $_GET['codigoestudiante']);
		$formulario2->cargar('idestudiantegeneral',$formulario->array_datos_cargados['estudiante']->idestudiantegeneral);
		
	//solo carga un id de la tabla hijo, porque no hay varios seguimientos
	//muestra flechas si aplica
	$maximo=count($_SESSION['array_flechas_tabla_padre_hijo']);
	if($maximo == 1)
	{
	}
	//carga las tablas de manera distintiva, porque hay varios seguimientos
	elseif($maximo >1)
	{
	}
	$formulario->cambiar_estado('estudiante','codigotipoestudiante',200,"<script language='javascript'>window.location.reload('".$_GET['link_origen']."')</script>");


}

?>
<form name="form1" action="ingresoaportes.php?codigoestudiante=<?php echo $_GET['codigoestudiante'] ?>&link_origen=<?php echo $_GET['link_origen'] ?>" method="POST" >
<input type="hidden" name="AnularOK" value="">
	<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="750">
	<?php 
	$formulario->dibujar_fila_titulo('APORTES SEGURIDAD SOCIAL EPS ARP','labelresaltado',"2","align='center'");

	$formulario->dibujar_fila_titulo('Datos Generales','labelresaltado');?>
	<tr>
	<td colspan="2">
	<?php 	
	$formulario2->dibujar_tabla_informacion_estudiante(puntos(3),"#003333","Estilo1","Estilo2","#CCCCCC");
	?>	
	</td>
	</tr>
    <?php 
	if(isset($_GET['codigoestudiante'])){
	$codigoestudiante=$_GET['codigoestudiante'];
	}

		validar_estudiante_postgrado($objetobase,$codigoestudiante);
		$formulario->dibujar_fila_titulo('Datos Opcionales','labelresaltado');

		if(isset($_GET['idestudiantenovedadarp'])){
		$datosestudiantenovedadarp=recuperar_datos($_GET['idestudiantenovedadarp'],$objetobase);
		$datosnovedadarp=$objetobase->recuperar_datos_tabla("novedadarp","idnovedadarp",$datosestudiantenovedadarp['idnovedadarp']);
		$codigotipoaplicacionnovedadarp=$datosnovedadarp['codigotipoaplicacionnovedadarp'];
		$idnovedadarp=$datosestudiantenovedadarp['idnovedadarp'];
		$epsnueva=$datosestudiantenovedadarp['idempresasalud'];
		$fechafinal=$datosestudiantenovedadarp['fechafinalestudiantenovedadarp'];
		$escogertipoarp=$datosestudiantenovedadarp['idempresasalud'];
		$fechaingreso=formato_fecha_defecto($datosestudiantenovedadarp['fechaestudiantenovedadarp']);
		$fechainicio=formato_fecha_defecto($datosestudiantenovedadarp['fechainicioestudiantenovedadarp']);
		$fechafinal=formato_fecha_defecto($datosestudiantenovedadarp['fechafinalestudiantenovedadarp']);
		$documentonovedadarp=$datosestudiantenovedadarp['numerodocumentonovedadarp'];
		$observacionnovedad=$datosestudiantenovedadarp['observacionnovedadarp'];
		$idestudiantedocumento=$datosestudiantenovedadarp['idestudiantedocumento'];
		}		
		else{
		$datosnovedadarp=$objetobase->recuperar_datos_tabla("novedadarp","idnovedadarp",$_POST['idnovedadarp']);
		$idnovedadarp=$_POST['idnovedadarp'];
		$codigotipoaplicacionnovedadarp=$_POST['codigotipoaplicacionnovedadarp'];
		$epsnueva=$_POST['epsnueva'];
		$escogertipoarp=$_POST['escogertipoarp'];
		$fechaingreso=date("d/m/Y");
		$idestudiantedocumento=$_POST['idestudiantedocumento'];

		}

		//Validar que si no se ha ingresado no salgan mas novedades mas que ING y INGARP
		//PENDIENTE MUY PENDIENTE
		//$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("novedadarp","idnovedadarp","nombrenovedadarp");
		
		//Validacion de novedades que esten vigentes no apareceran en listado de opcion
		$novedadingresoexiste=0;
		if(!isset($_GET['idestudiantenovedadarp']))
		$novedadingresoexiste=validar_ingreso_vigente($formulario->array_datos_cargados['estudiante']->idestudiantegeneral,$objetobase,$fechahoy);
		$condicionvalidacionnovedad=validar_listado_novedades($formulario->array_datos_cargados['estudiante']->idestudiantegeneral,$objetobase,$fechahoy,$novedadingresoexiste,$_GET['idestudiantenovedadarp']);

	
		//menu de tipo de novedad
		$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("tipoaplicacionnovedadarp","codigotipoaplicacionnovedadarp","nombretipoaplicacionnovedadarp","");
		$formulario->filatmp[""]="Seleccionar";
		$menu="menu_fila"; $parametrosmenu="'codigotipoaplicacionnovedadarp','".$codigotipoaplicacionnovedadarp."','onchange=\'form1.idnovedadarp.value=\"\"; enviar();\''";
		$formulario->dibujar_campo($menu,$parametrosmenu,"Tipos de novedades","tdtitulogris","codigotiponovedadarp");
		
		
		//menu de novedades
		$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("novedadarp","idnovedadarp","nombrenovedadarp","codigoestado like '1%' and codigotipoaplicacionnovedadarp='".$codigotipoaplicacionnovedadarp."'".$condicionvalidacionnovedad,"",0);
		$formulario->filatmp[""]="Seleccionar";
		$menu="menu_fila"; $parametrosmenu="'idnovedadarp','".$idnovedadarp."','onchange=\'enviar();\''";
		$formulario->dibujar_campo($menu,$parametrosmenu,"NOVEDADES","tdtitulogris","idnovedadarp");
		$conboton=0;

		if(isset($idnovedadarp)&&($idnovedadarp!="")){
			
				 switch($datosnovedadarp['codigotiponovedadarp']){
	  
				  case "100":
				  	$formulario->dibujar_fila_titulo('Datos de la EPS','labelresaltado');

				  	$condicion="em.codigotipoempresasalud=100 and em.idempresasalud = ea.idempresasalud and
								es.idestudiantegeneral=ea.idestudiantegeneral and
								('$fechahoy' between ea.fechainicioestudiantearp and ea.fechafinalestudiantearp) and
								es.idestudiantegeneral=".$formulario->array_datos_cargados['estudiante']->idestudiantegeneral;
					//$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("empresasalud em ,estudiantegeneral es, estudiantearp ea","em.idempresasalud","em.nombreempresasalud",$condicion);
					//$campo='menu_fila'; $parametros="'epsanterior','','disabled'";
					//$formulario->dibujar_campo($campo,$parametros,"EPS anterior","tdtitulogris",'codigotipoeps','');
					$condicion="em.codigotipoempresasalud = t.codigotipoempresasalud and t.nombretipoempresasalud like 'EPS%' order by nombreempresasalud";
			  		$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("empresasalud em, tipoempresasalud t","em.idempresasalud","em.nombreempresasalud",$condicion);
					$campo='menu_fila'; $parametros="'epsnueva','".$epsnueva."',''";
					$formulario->dibujar_campo($campo,$parametros,"EPS Nueva","tdtitulogris",'epsnueva','');
					
					//$campo="memo"; $parametros="'observacioneps','estudiantenovedadarp',70,8,'','','',''";
					//$formulario->dibujar_campo($campo,$parametros,"Observacion","tdtitulogris",'observacioneps');
					if(!isset($fechafinal))
					$fechafinal="01/01/2099";
					$desabilitafechafinal=1;
		
					
				  break;

				  case "101" :
				  	$formulario->dibujar_fila_titulo('Datos de la EPS','labelresaltado');
				  	$condicion="ti.nombretipoempresasalud like 'EPS%'
								and em.codigotipoempresasalud=ti.codigotipoempresasalud
								and em.idempresasalud = en.idempresasalud and
								es.idestudiantegeneral=en.idestudiantegeneral and
								en.codigoestado like '1%' and
								no.codigotiponovedadarp like '1%' and
								no.idnovedadarp = en.idnovedadarp and
								('$fechahoy' between en.fechainicioestudiantenovedadarp and en.fechafinalestudiantenovedadarp) and
								es.idestudiantegeneral=".$formulario->array_datos_cargados['estudiante']->idestudiantegeneral;
					$tablas="novedadarp no, estudiantenovedadarp en ,estudiantegeneral es, empresasalud em, tipoempresasalud ti";
					$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila($tablas,"en.idestudiantenovedadarp","em.nombreempresasalud",$condicion);
					$campo='menu_fila'; $parametros="'epsanterior','','readonly'";
					$formulario->dibujar_campo($campo,$parametros,"EPS anterior","tdtitulogris",'codigotipoeps','');
					$condicion="ti.nombretipoempresasalud like 'EPS%' 
								and em.codigotipoempresasalud=ti.codigotipoempresasalud
								order by nombreempresasalud";
			  		$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("empresasalud em, tipoempresasalud ti","idempresasalud","nombreempresasalud",$condicion);
					$campo='menu_fila'; $parametros="'epsnueva','".$epsnueva."',''";
					$formulario->dibujar_campo($campo,$parametros,"EPS Nueva","tdtitulogris",'epsnueva','');
					//if(!isset($fechainicio))
					//$fechainicio=date("d")."/".date("m")."/".date("Y");
					
					//if(!isset($fechafinal))
					//$fechafinal=final_mes(date("m")+1)."/".agregarceros((date("m")+1),2)."/".date("Y");
					if(!isset($fechafinal)||($fechafinal==""))
					$fechafinal="01/01/2099";
					
					$desabilitafechafinal=1;
				  break;
				  		
				  case "102" :
				  	/*$condicion="ti.nombretipoempresasalud like '%ERP%'
								and em.codigotipoempresasalud=ti.codigotipoempresasalud 
								and em.idempresasalud = ea.idempresasalud and
								es.idestudiantegeneral=ea.idestudiantegeneral and
								es.idestudiantegeneral=".$formulario->array_datos_cargados['estudiante']->idestudiantegeneral;
					$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("empresasalud em ,estudiantegeneral es, estudiantearp ea, tipoempresasalud ti","em.idempresasalud","em.nombreempresasalud",$condicion);
					$campo='menu_fila'; $parametros="'arpanterior','','disabled'";
					$formulario->dibujar_campo($campo,$parametros,"ARP Anterior","tdtitulogris",'codigotipoeps','');*/
					$condicion="ti.nombretipoempresasalud like '%ERP%' and
								em.codigotipoempresasalud=ti.codigotipoempresasalud";
			  		$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("empresasalud em, tipoempresasalud ti","idempresasalud","nombreempresasalud",$condicion);
					$campo='menu_fila'; $parametros="'arpnueva','".$escogertipoarp."',''";
					$formulario->dibujar_campo($campo,$parametros,"ARP Nueva","tdtitulogris",'arpnueva','');
				  break;
				  
				  case "200":
					if(!isset($fechafinal)||($fechafinal==""))
					$fechafinal="01/01/2099";
					$desabilitafechafinal=1;
					//$funcionfechainicial="onchange=cambiefechafinal(this)";
				  break;

				 }

    		  	  $formulario->dibujar_fila_titulo('Datos generales de la novedad','labelresaltado');
				  $campo="boton_tipo"; $parametros="'hidden','fechaingreso','".$fechaingreso."'";
				  $formulario->boton_tipo('hidden','fechaingreso',$fechaingreso);
				 
				  if(!isset($fechainicio))
				  $fechainicio=date("d/m/Y");
				  
				  $campo = "campo_fecha"; $parametros ="'text','fechainicio','".$fechainicio."','onKeyUp = \"this.value=formateafecha(this.value);\" $funcionfechainicial'";
				  $formulario->dibujar_campo($campo,$parametros,"Fecha de inicio","tdtitulogris",'fechainicio','requerido');
				  if(($desabilitafechafinal)&&(!isset($_GET['idestudiantenovedadarp']))){
				  $campo="boton_tipo"; $parametros="'text','fechafinal','".$fechafinal."','readonly'";
				  $formulario->dibujar_campo($campo,$parametros,"Fecha Final","tdtitulogris",'fechafinal','requerido');
				  }
				  else{
				  $campo="campo_fecha"; $parametros="'text','fechafinal','".$fechafinal."','onKeyUp = \"this.value=formateafecha(this.value);\" '";
				  $formulario->dibujar_campo($campo,$parametros,"Fecha Final","tdtitulogris",'fechafinal','requerido');
				  }
				
				  $campo="boton_tipo"; $parametros="'text','documentonovedadarp','".$documentonovedadarp."',''";
				  $formulario->dibujar_campo($campo,$parametros,"Referencia de Documento","tdtitulogris",'fechafinal','');

					$condicion="  ed.idestudiantegeneral=".$formulario->array_datos_cargados['estudiante']->idestudiantegeneral."";
			  		$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("estudiantedocumento ed","ed.idestudiantedocumento","ed.numerodocumento",$condicion);
					$campo='menu_fila'; $parametros="'idestudiantedocumento','".$idestudiantedocumento."',''";
					$formulario->dibujar_campo($campo,$parametros,"Documento Estudiante","tdtitulogris",'epsnueva','');
				  
				  $campo="memo"; $parametros="'observacionnovedad','estudiantenovedadarp',70,8,'','','',''";
			      $formulario->dibujar_campo($campo,$parametros,"Observacion","tdtitulogris",'observacionnovedad');
				  $formulario->cambiar_valor_campo('observacionnovedad',$observacionnovedad);
				  
					
					if(isset($_GET['idestudiantenovedadarp'])){
					$parametrobotonenviar[$conboton]="'submit','Modificar','Modificar'";
					$boton[$conboton]='boton_tipo';
					$conboton++;
					$parametrobotonenviar[$conboton]="'submit','Anular','Anular'";
					$boton[$conboton]='boton_tipo';
					$formulario->boton_tipo('hidden','idestudiantenovedadarp',$_GET['idestudiantenovedadarp']);

					}
					else{
					$parametrobotonenviar[$conboton]="'submit','Enviar','Enviar'";
					$boton[$conboton]='boton_tipo';
					}
				//$conboton++;
				//$parametrobotonenviar[$conboton]="'Listado_General','listadocierreaportes.php','codigoestudiante=".$_GET['codigoestudiante']."',800,600,20,150,'yes','yes','no','yes','yes'";
				//$boton[$conboton]='boton_ventana_emergente';

					if(($maximo >=1)&&(!isset($_GET['nuevo']))){	
						$parametrobotonenviar[$conboton]="'submit','Anular','Anular'";
						$boton[$conboton]='boton_tipo';
					}
	
			$conboton++;
		}
						//$parametrobotonenviar[$conboton]="'Masivos','marcomasivoasignacionaportes.php','codigoestudiante=".$_GET['codigoestudiante']."',800,600,50,150,'yes','yes','no','no','yes'";
						//$boton[$conboton]='boton_ventana_emergente';
						//$conboton++;}

						$parametrobotonenviar[$conboton]="'Listado','listadoaportesseguimiento.php','codigoestudiante=".$_GET['codigoestudiante']."&link_origen= ".$_GET['link_origen']."',900,300,5,5,'yes','yes','no','yes','yes'";
						$boton[$conboton]='boton_ventana_emergente';
						$conboton++;
						$parametrobotonenviar[$conboton]="'button','Regresar','Regresar','onclick=\'regresarGET();\''";
						$boton[$conboton]='boton_tipo';
						$formulario->dibujar_campos($boton,$parametrobotonenviar,"","tdtitulogris",'Enviar');

/****************************//////////////////////////////////////////////*****************************/
// Seccion De actualizacion de base de datos
			
if(isset($_REQUEST['Enviar'])){
			if($formulario->valida_formulario()){
			$fecha_inicio_mes=inicio_mes_fecha($_POST['fechaingreso']);
				if(validacionprocesoactivo($_POST['fechainicio'],$objetobase,4,0)){
					if(validar_diferencia_fechas($_POST['fechainicio'],$_POST['fechafinal'])){
						$tabla="estudiantenovedadarp";
						//Fila de Ingreso de novedad 
						$fila["idestudiantegeneral"]=$formulario->array_datos_cargados['estudiante']->idestudiantegeneral;
						$fila["idnovedadarp"]=$_POST['idnovedadarp'];
						$fila["fechaestudiantenovedadarp"]=formato_fecha_mysql($_POST['fechaingreso']);
						$fila["fechainicioestudiantenovedadarp"]=formato_fecha_mysql($_POST['fechainicio']);
						//$mesinicio=$_POST['fechainicio'][3].$_POST['fechainicio'][4];
						$fila["fechafinalestudiantenovedadarp"]=formato_fecha_mysql($_POST['fechafinal']);
						//$mesfinal=$_POST['fechafinal'][3].$_POST['fechafinal'][4];
						$fila["observacionnovedadarp"]=$_POST['observacionnovedad'];
						$fila["codigoestado"]=100;
						$fila["numerodocumentonovedadarp"]=$_POST['documentonovedadarp'];
						$fila["idestudiantenovedadarporigen"]=0;
						$fila["idempresasalud"]=1;
						$fila["idestudiantedocumento"]=$_POST['idestudiantedocumento'];

						//Diferenciacion de distintos ingresos por novedad
						switch($datosnovedadarp['codigotiponovedadarp']){
			
						  case "100":
						  //Ingreso de primera vez de la eps
  							$condicion="and en.codigoestado like '1%' and 
										no.idnovedadarp = en.idnovedadarp and 
										no.codigotiponovedadarp like '2%' and
										no.codigotipoaplicacionnovedadarp like '1%' and
										('".$fechahoy."' between en.fechainicioestudiantenovedadarp and en.fechafinalestudiantenovedadarp)";
								$datosnovedadvigente=$objetobase->recuperar_datos_tabla("estudiantenovedadarp en, novedadarp no","en.idestudiantegeneral",$formulario->array_datos_cargados['estudiante']->idestudiantegeneral,$condicion,', en.fechainicioestudiantenovedadarp inicionovedadarp',0);
								
								 $idtablavencida=$datosnovedadvigente['idestudiantenovedadarp'];
								 $fechainiciovencida=$datosnovedadvigente['inicionovedadarp'];
								 if(isset($idtablavencida)&&($idtablavencida!=''))
									$fila["idestudiantenovedadarporigen"]=$idtablavencida;
								$fechainiciovector=vector_fecha($_POST['fechainicio']);
								$filavencida['fechafinalestudiantenovedadarp']=formato_fecha_mysql(agregarceros(($fechainiciovector["dia"]-1),2)."/".agregarceros($fechainiciovector["mes"],2)."/".$fechainiciovector["anio"]);

							 if((isset($_POST['epsnueva']))&&($_POST['epsnueva']!="")){
								$fila["idempresasalud"]=$_POST['epsnueva'];
							}
							$finalmes=final_mes_fecha(date("d/m/Y"));	
							
							if(!validar_diferencia_fechas($_POST['fechainicio'],$finalmes)){

								alerta_javascript("fecha de inicio de ingreso no \\n puede ser mayor o igual al final del mes en curso<".$_POST['fechainicio'].">"); 
								}
									else{
									$objetobase->insertar_fila_bd($tabla,$fila);
									if(isset($idtablavencida)&&($idtablavencida!=''))
									$objetobase->actualizar_fila_bd($tabla,$filavencida,'idestudiantenovedadarp',$idtablavencida);
									}
						  break;		
						
						  case "101" :
							//Ingreso de nueva relacion de estudiante con empresa de salud
							//creacion de nuevo registro y  establecimiento de vencimiento de 
							//anterior empresa de salud
							
							$condicion="and en.codigoestado like '1%' and 
										no.idnovedadarp = en.idnovedadarp and 
										no.codigotiponovedadarp like '1%' and
										no.codigotipoaplicacionnovedadarp like '1%' and
										('".$fechahoy."' between en.fechainicioestudiantenovedadarp and en.fechafinalestudiantenovedadarp)";
							
								$fila["idempresasalud"]=$_POST['epsnueva'];
							
								$datosnovedadvigente=$objetobase->recuperar_datos_tabla("estudiantenovedadarp en, novedadarp no","en.idestudiantegeneral",$formulario->array_datos_cargados['estudiante']->idestudiantegeneral,$condicion,', en.fechainicioestudiantenovedadarp inicionovedadarp',0);
								 $idtablavencida=$datosnovedadvigente['idestudiantenovedadarp'];
								 $fechainiciovencida=$datosnovedadvigente['inicionovedadarp'];
								$fila["idestudiantenovedadarporigen"]=$idtablavencida;
								$fechainiciovector=vector_fecha($_POST['fechainicio']);
								
								$filavencida['fechafinalestudiantenovedadarp']=formato_fecha_mysql(agregarceros(($fechainiciovector["dia"]-1),2)."/".agregarceros($fechainiciovector["mes"],2)."/".$fechainiciovector["anio"]);
								//echo "if(",$fila["fechainicioestudiantenovedadarp"]."==$fechainiciovencida){";
								if(!validar_diferencia_fechas(formato_fecha_defecto($fechainiciovencida),formato_fecha_defecto($fila["fechainicioestudiantenovedadarp"]))){
								alerta_javascript("fecha de cambio de la EPS es igual o menor al anterior cambio <".$fechainiciovencida).">"; 
								}
								else{
								$objetobase->actualizar_fila_bd($tabla,$filavencida,'idestudiantenovedadarp',$idtablavencida);
								$objetobase->insertar_fila_bd($tabla,$fila);
								}
								
								break;
							  case "200" :
								$condicion="and en.codigoestado like '1%' and 
											no.idnovedadarp = en.idnovedadarp and 
											no.codigotiponovedadarp like '1%' and
											no.codigotipoaplicacionnovedadarp like '1%' and
											('".$fechahoy."' between en.fechainicioestudiantenovedadarp and en.fechafinalestudiantenovedadarp)";
							
								//$fila["idempresasalud"]=$_POST['epsnueva'];
							
								$datosnovedadvigente=$objetobase->recuperar_datos_tabla("estudiantenovedadarp en, novedadarp no","en.idestudiantegeneral",$formulario->array_datos_cargados['estudiante']->idestudiantegeneral,$condicion,', en.fechainicioestudiantenovedadarp inicionovedadarp',0);
								 $idtablavencida=$datosnovedadvigente['idestudiantenovedadarp'];
								 $fechainiciovencida=$datosnovedadvigente['inicionovedadarp'];
								$fila["idestudiantenovedadarporigen"]=$idtablavencida;
								$fechainiciovector=vector_fecha($_POST['fechainicio']);
								
								$filavencida['fechafinalestudiantenovedadarp']=formato_fecha_mysql(agregarceros(($fechainiciovector["dia"]-1),2)."/".agregarceros($fechainiciovector["mes"],2)."/".$fechainiciovector["anio"]);
								//echo "if(",$fila["fechainicioestudiantenovedadarp"]."==$fechainiciovencida){";
								if(!validar_diferencia_fechas(formato_fecha_defecto($fechainiciovencida),formato_fecha_defecto($fila["fechainicioestudiantenovedadarp"]),0)){
									alerta_javascript("fecha de cambio de la EPS ".$fila["fechainicioestudiantenovedadarp"]." es igual o menor al anterior cambio <".$fechainiciovencida).">"; 
								}
								else{
									$objetobase->actualizar_fila_bd($tabla,$filavencida,'idestudiantenovedadarp',$idtablavencida);
									$objetobase->insertar_fila_bd($tabla,$fila);
								}
								break;
							default:
									//ingreso de novedades con fechas de inicio y final
									// se crea un registro por cada nuevo mes que este dentro del rango de las
									// fecha de inicio y final
									/*$cuantosmesesnovedad=diferencia_fechas($_POST['fechainicio'],$_POST['fechafinal'],"meses");
									$fechaini=vector_fecha($_POST['fechainicio']); $fechafin=vector_fecha($_POST['fechafinal']);
									$fila["idempresasalud"]=1;
									//Proceso para rangode mas de un mes
									if($cuantosmesesnovedad>1){
										$fila["fechainicioestudiantenovedadarp"]	= formato_fecha_mysql($_POST['fechainicio']);
										$fila["fechafinalestudiantenovedadarp"]	= formato_fecha_mysql(final_mes_fecha($_POST['fechainicio']));
										$objetobase->insertar_fila_bd($tabla,$fila);
			
										$messiguiente=$fechaini["mes"];
										$aniosiguiente=$fechaini["anio"];
										for($i=1;$i<($cuantosmesesnovedad-1);$i++){
											$siguiente = mes_siguiente($messiguiente,$aniosiguiente);
											echo "01/".agregarceros($siguiente["mes"],2)."/".$siguiente["anio"]."<--->";
											echo final_mes_fecha("01/".agregarceros($siguiente["mes"],2)."/".$siguiente["anio"])."<br>";
											$fila["fechainicioestudiantenovedadarp"]	= formato_fecha_mysql("01/".agregarceros($siguiente["mes"],2)."/".$siguiente["anio"]);
											$fila["fechafinalestudiantenovedadarp"]	= formato_fecha_mysql(final_mes_fecha("01/".agregarceros($siguiente["mes"],2)."/".$siguiente["anio"]));
											$messiguiente=$siguiente["mes"];
											$aniosiguiente=$siguiente["anio"];
											$objetobase->insertar_fila_bd($tabla,$fila);
			
										}
			
										$fila["fechainicioestudiantenovedadarp"]	= formato_fecha_mysql("01/".agregarceros($fechafin["mes"],2)."/".$fechafin["anio"]);
										$fila["fechafinalestudiantenovedadarp"]	= formato_fecha_mysql($_POST['fechafinal']);
										$objetobase->insertar_fila_bd($tabla,$fila);
			
									}
									else{*/
									//Proceso para rango dentro del mismo mes
										$fila["fechainicioestudiantenovedadarp"]=formato_fecha_mysql($_POST['fechainicio']);
										$fila["fechafinalestudiantenovedadarp"]=formato_fecha_mysql($_POST['fechafinal']);
										
										$condicionactualiza="idestudiantegeneral=".$fila['idestudiantegeneral'].
															" and fechainicioestudiantenovedadarp='".$fila["fechainicioestudiantenovedadarp"].
															"' and fechafinalestudiantenovedadarp='".$fila["fechafinalestudiantenovedadarp"].
															"' and codigoestado='".$fila["codigoestado"].
															"' and idnovedadarp='".$fila["idnovedadarp"]."'";
	
										$objetobase->insertar_fila_bd($tabla,$fila,0,$condicionactualiza);
									//}
			
								break;
					 
						}
		  
						echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=$REQUEST_URI'>";
						//echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=$REQUEST_URI'>";
						//$formulario->actualizar_fila_bd($tabla,$filaactualizar,$nombreidtabla,$idtabla);
						}
						else
						{
									alerta_javascript("fecha de inicio <".$_POST['fechainicio']."> no puede ser \\n mayor o igual a la fecha final <".$_POST['fechafinal'].">"); 
			
						}
					
			                          }
			else
			{
						alerta_javascript("fecha de la novedad no puede ser \\n ingresada anterior al inicio del mes en curso <".$fechainiciovencida.">"); 

			}
		}
	}

	if(isset($_REQUEST['Anular']))
	{
			$tabla="estudiantenovedadarp";
			$filaanular['codigoestado']='200';
			$nombreidtabla="idestudiantenovedadarp";
			$idtabla=$_POST['idestudiantenovedadarp'];
					
					switch($datosnovedadarp['codigotiponovedadarp']){
					  case "101" :
							//Ingreso de nueva relacion de estudiante con empresa de salud
							//creacion de nuevo registro y  establecimiento de vencimiento de 
							//anterior empresa de salud
							$datosnovedad=$objetobase->recuperar_datos_tabla("estudiantenovedadarp en","en.idestudiantenovedadarp",$idtabla,'','',0);
							$datosnovedadvigente=$objetobase->recuperar_datos_tabla("estudiantenovedadarp en","en.idestudiantenovedadarp",$datosnovedad['idestudiantenovedadarporigen'],'','',0);
     						$idtablavencida=$datosnovedadvigente['idestudiantenovedadarp'];
							$filavencida['fechafinalestudiantenovedadarp']=$datosnovedad['fechafinalestudiantenovedadarp'];
							$objetobase->actualizar_fila_bd($tabla,$filavencida,'idestudiantenovedadarp',$idtablavencida);
					  case "200" :
							//Ingreso de nueva relacion de estudiante con empresa de salud
							//creacion de nuevo registro y  establecimiento de vencimiento de 
							//anterior empresa de salud
							$datosnovedad=$objetobase->recuperar_datos_tabla("estudiantenovedadarp en","en.idestudiantenovedadarp",$idtabla,'','',0);
							$datosnovedadvigente=$objetobase->recuperar_datos_tabla("estudiantenovedadarp en","en.idestudiantenovedadarp",$datosnovedad['idestudiantenovedadarporigen'],'','',0);
     						$idtablavencida=$datosnovedadvigente['idestudiantenovedadarp'];
							$filavencida['fechafinalestudiantenovedadarp']=formato_fecha_mysql("01/01/2099");
							$objetobase->actualizar_fila_bd($tabla,$filavencida,'idestudiantenovedadarp',$idtablavencida);
							
							
					break;
			}

			$objetobase->actualizar_fila_bd($tabla,$filaanular,$nombreidtabla,$idtabla);
			echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=$REQUEST_URI'>";
	}
	
	if(isset($_REQUEST['Modificar'])){
			$fecha_inicio_mes=inicio_mes_fecha($_POST['fechaingreso']);
				if(validacionprocesoactivo($_POST['fechainicio'],$objetobase,4,0)){
					if(validar_diferencia_fechas($_POST['fechainicio'],$_POST['fechafinal'])){

						$tabla="estudiantenovedadarp";
						$idtabla=$_POST['idestudiantenovedadarp'];
			
						//Diferenciacion de distintos ingresos por novedad
						switch($datosnovedadarp['codigotiponovedadarp']){
			
							  case "101" :
							//Ingreso de nueva relacion de estudiante con empresa de salud
							//creacion de nuevo registro y  establecimiento de vencimiento de 
							//anterior empresa de salud
							
							$condicion="";
								//$fila["idempresasalud"]=$_POST['epsnueva'];
								$datosnovedad=$objetobase->recuperar_datos_tabla("estudiantenovedadarp en","en.idestudiantenovedadarp",$idtabla,'','',0);
								$datosnovedadvigente=$objetobase->recuperar_datos_tabla("estudiantenovedadarp en","en.idestudiantenovedadarp",$datosnovedad['idestudiantenovedadarporigen'],'','',0);
								 $idtablavencida=$datosnovedadvigente['idestudiantenovedadarp'];
								 $fechainiciovencida=$datosnovedadvigente['inicionovedadarp'];
			
								$fechainiciovector=vector_fecha($_POST['fechainicio']);
								
								$filavencida['fechafinalestudiantenovedadarp']=formato_fecha_mysql(agregarceros(($fechainiciovector["dia"]-1),2)."/".agregarceros($fechainiciovector["mes"],2)."/".$fechainiciovector["anio"]);
								//echo "if(",$fila["fechainicioestudiantenovedadarp"]."==$fechainiciovencida){";
								
								if(!validar_diferencia_fechas($fechainiciovencida,$fila["fechainicioestudiantenovedadarp"])){
								alerta_javascript("fecha de cambio de la EPS ".$fila["fechainicioestudiantenovedadarp"]." es igual\n al anterior cambio <".$fechainiciovencida.">"); 
								}
								else{
								$objetobase->actualizar_fila_bd($tabla,$filavencida,'idestudiantenovedadarp',$idtablavencida);
								//$objetobase->insertar_fila_bd($tabla,$fila);
								}
								
								break;
						}
			
						$formulario->valida_formulario();
						//Fila de Ingreso de novedad 
						$fila["idestudiantegeneral"]=$formulario->array_datos_cargados['estudiante']->idestudiantegeneral;
						$fila["idnovedadarp"]=$_POST['idnovedadarp'];
						$fila["fechaestudiantenovedadarp"]=formato_fecha_mysql($_POST['fechaingreso']);
						$fila["fechainicioestudiantenovedadarp"]=formato_fecha_mysql($_POST['fechainicio']);
						//$mesinicio=$_POST['fechainicio'][3].$_POST['fechainicio'][4];
						$fila["fechafinalestudiantenovedadarp"]=formato_fecha_mysql($_POST['fechafinal']);
						//$mesfinal=$_POST['fechafinal'][3].$_POST['fechafinal'][4];
						$fila["observacionnovedadarp"]=$_POST['observacionnovedad'];
						$fila["codigoestado"]=100;
						$fila["numerodocumentonovedadarp"]=$_POST['documentonovedadarp'];
						$fila["idestudiantedocumento"]=$_POST['idestudiantedocumento'];
						  //Ingreso de primera vez de la eps
						if((isset($_POST['epsnueva']))&&($_POST['epsnueva']!="")){
							$fila["idempresasalud"]=$_POST['epsnueva'];
						}
						if((isset($_POST['arpnueva']))&&($_POST['arpnueva']!="")){
							$fila["idempresasalud"]=$_POST['arpnueva'];
						}

						$nombreidtabla="idestudiantenovedadarp";
						
						$objetobase->actualizar_fila_bd($tabla,$fila,$nombreidtabla,$idtabla);
						echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=$REQUEST_URI'>";
						
					}
					else
					{
							alerta_javascript("fecha de inicio <".$_POST['fechainicio']."> no puede ser \\n mayor o igual a la fecha final <".$_POST['fechafinal'].">"); 
							echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=$REQUEST_URI'>";
					}

		}
		else
		{
			alerta_javascript("fecha de la novedad no puede ser \\n ingresada anterior al inicio del mes en curso <".$fechainiciovencida.">"); 
		}
	}
	
?>

  </table>
</form>
