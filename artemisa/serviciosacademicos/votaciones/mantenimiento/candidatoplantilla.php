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
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="../../estilos/sala.css">
<style type="text/css">@import url(../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../funciones/calendario_nuevo/calendar-setup.js"></script>
<script type="text/javascript" src="../../funciones/clases/formulario/globo.js"></script>
<script type="text/javascript" src="../../funciones/sala_genericas/ajax/requestxml.js"></script>
<script type="text/javascript" src="consultacandidato.js"></script>

<script LANGUAGE="JavaScript">
function regresarGET()
{
	//history.back();
	document.location.href="<?php echo 'menumantenimientovotaciones.php';?>";
}

</script>
<style type="text/css">
<!--
#Layer1 {
	position:absolute;
	left:500px;
	top:25px;
	width:228px;
	height:89px;
	z-index:1;
}
-->
</style>
</head>
<body>
<?php
//print_r($_SESSION);
$fechahoy=date("Y-m-d H:i:s");
$formulario=new formulariobaseestudiante($sala,'form1','post','','true');
$objetobase=new BaseDeDatosGeneral($sala);

$usuario=$formulario->datos_usuario();
$ip=$formulario->GetIP();


?>
<form name="form1" action="candidatoplantilla.php" method="POST" >
<input type="hidden" name="AnularOK" value="">
	<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="750">
<?php

		$fechainscripcioncandidatodetalleplantillavotacion=date("d/m/Y");
		if(isset($_GET['iddetalleplantillavotacion'])){
		$datos=$objetobase->recuperar_datos_tabla("detalleplantillavotacion","iddetalleplantillavotacion",$_GET['iddetalleplantillavotacion'],'','',0);
		$condicion="and tp.idplantillavotacion=p.idplantillavotacion";
		$datostipoplantillavotacion=$objetobase->recuperar_datos_tabla("detalleplantillavotacion tp, plantillavotacion p","tp.iddetalleplantillavotacion",$_GET['iddetalleplantillavotacion'],$condicion,', p.idtipoplantillavotacion idtipo',0);
		$idtipoplantillavotacion=$datostipoplantillavotacion['idtipo'];
		$idplantillavotacion=$datos['idplantillavotacion'];
		$idcandidatovotacion=$datos['idcandidatovotacion'];
		$idcargo=$datos['idcargo'];
		$datoscandidatovotacion=$objetobase->recuperar_datos_tabla("candidatovotacion c","idcandidatovotacion",$idcandidatovotacion,'','',0);
		$idtipocandidatodetalleplantillavotacion=$datoscandidatovotacion['idtipocandidatodetalleplantillavotacion'];
		$fechainscripcioncandidatodetalleplantillavotacion=formato_fecha_defecto($datos['fechainscripcioncandidatodetalleplantillavotacion']);
		$resumenpropuestascandidatodetalleplantillavotacion=$datos['resumenpropuestascandidatodetalleplantillavotacion'];

		}
		else{
		$idtipoplantillavotacion=$_POST['idtipoplantillavotacion'];
		$idplantillavotacion=$_POST['idplantillavotacion'];
		$idtipocandidatodetalleplantillavotacion=$_POST['idtipocandidatodetalleplantillavotacion'];
		$idcandidatovotacion=$_POST['idcandidatovotacion'];
		if(isset($_POST['fechainscripcioncandidatodetalleplantillavotacion']))
		$fechainscripcioncandidatodetalleplantillavotacion=$_POST['fechainscripcioncandidatodetalleplantillavotacion'];
		$resumenpropuestascandidatodetalleplantillavotacion=$_POST['resumenpropuestascandidatodetalleplantillavotacion'];

		$imagencandidatotxt=$_POST['imagencandidatotxt'];
		}


		if(isset($idcandidatovotacion)&&$idcandidatovotacion!=''){
		$datosplantillavotacion=$objetobase->recuperar_datos_tabla("candidatovotacion","idcandidatovotacion",$idcandidatovotacion,'','',0);
		$datosplantillavotacionplantilla=$objetobase->recuperar_datos_tabla("plantillavotacion","idplantillavotacion",$idplantillavotacion,'','',0);
		$numerodocumentocandidatovotacion=$datosplantillavotacion['numerodocumentocandidatovotacion'];
		$nombrescandidatovotacion=$datosplantillavotacion['nombrescandidatovotacion'];
		$apellidoscandidatovotacion=$datosplantillavotacion['apellidoscandidatovotacion'];
		$telefonocandidatovotacion=$datosplantillavotacion['telefonocandidatovotacion'];
		$celularcandidatovotacion=$datosplantillavotacion['celularcandidatovotacion'];
		$direccioncandidatovotacion=$datosplantillavotacion['direccioncandidatovotacion'];
		$numerotarjetoncandidatovotacion=$datosplantillavotacion['numerotarjetoncandidatovotacion'];
		
		if(isset($_POST["idvotacion"])&&trim($_POST["idvotacion"])!='')
			$idvotacion=$_POST["idvotacion"];
		else
			$idvotacion=$datosplantillavotacionplantilla["idvotacion"];

		$rutaarchivofotocandidatovotacion=$datosplantillavotacion['rutaarchivofotocandidatovotacion'];

		$datoscarrera=$objetobase->recuperar_datos_tabla("carrera c","c.codigocarrera",$datosplantillavotacionplantilla['codigocarrera'],"",'',0);

		$codigomodalidadacademica=$datoscarrera["codigomodalidadacademica"];
		$codigocarrera=$datoscarrera["codigocarrera"];
		}
		else
		{
		$numerodocumentocandidatovotacion=$_POST['numerodocumentocandidatovotacion'];
		$nombrescandidatovotacion=$_POST['nombrescandidatovotacion'];
		$apellidoscandidatovotacion=$_POST['apellidoscandidatovotacion'];
		$telefonocandidatovotacion=$_POST['telefonocandidatovotacion'];
		$celularcandidatovotacion=$_POST['celularcandidatovotacion'];
		$direccioncandidatovotacion=$_POST['direccioncandidatovotacion'];
		$numerotarjetoncandidatovotacion=$_POST['numerotarjetoncandidatovotacion'];
		$idvotacion=$_POST["idvotacion"];
		$rutaarchivofotocandidatovotacion=$_POST['rutaarchivofotocandidatovotacion'];
		$codigomodalidadacademica=$_POST["codigomodalidadacademica"];
		$codigocarrera=$_POST["codigocarrera"];

		}
/*
echo "datoscandidatovotacion<pre>";
print_r($datoscandidatovotacion);
echo "</pre>";
*/
	$archivo1="../../../imagenes/estudiantes/".$datoscandidatovotacion["numerodocumentocandidatovotacion"].".jpg";
	$archivo2="../../../imagenes/estudiantes/".$datoscandidatovotacion["numerodocumentocandidatovotacion"].".JPG";
 
	if(is_file($archivo1)){
		$imagencandidatotxt=$archivo1;
		$archivoencontrado=1;
	}
	else if(is_file($archivo2)){
		$imagencandidatotxt=$archivo2;
		$archivoencontrado=1;
	}

//echo $imagencandidatotxt."<br>";

if($archivoencontrado)
echo "<div id='Layer1'><img id='imagencandidato' src='".$imagencandidatotxt."' width='90' height='125' /></div>";
else
echo "<div id='Layer1'><img id='imagencandidato' src='../../../imagenes/desconocido.jpg' width='90' height='125' /></div>";

			$conboton=0;
			$formulario->dibujar_fila_titulo('Candidato de Votación','labelresaltado');
			$condicion="";
			$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("tipocandidatodetalleplantillavotacion","idtipocandidatodetalleplantillavotacion","nombretipocandidatodetalleplantillavotacion",$condicion,"",0);
			//$formulario->filatmp[""]="Seleccionar";
			$menu="menu_fila"; $parametrosmenu="'idtipocandidatodetalleplantillavotacion','".$idtipocandidatodetalleplantillavotacion."',''";
			$formulario->dibujar_campo($menu,$parametrosmenu,"Tipos de candidato","tdtitulogris","idtipocandidatodetalleplantillavotacion",'requerido');
			
			
			$campos[0]="boton_tipo"; $parametros[0]="'text','numerodocumentocandidatovotacion','".$numerodocumentocandidatovotacion."','maxlength=\"15\"'";
			$campos[1]="boton_tipo"; $parametros[1]="'button','Buscar','Buscar','onclick=busquedaXmlFormulario();'";
			

		  	$formulario->dibujar_campos($campos,$parametros,"Documento","tdtitulogris",'numerodocumentocandidatovotacion','requerido');
	
			/*$campo="boton_tipo"; $parametros="'text','numerotarjetoncandidatovotacion','".$numerotarjetoncandidatovotacion."','maxlength=\"5\"'";
		  	$formulario->dibujar_campo($campo,$parametros,"Tarjeton","tdtitulogris",'numerotarjetoncandidatovotacion','requerido');*/

			
			$formulario->boton_tipo('hidden','imagencandidatotxt',$imagencandidatotxt,'');
			$formulario->boton_tipo('hidden','idplantillavotacion',$idplantillavotacion,'');

		
			$campo="boton_tipo"; $parametros="'text','nombrescandidatovotacion','".$nombrescandidatovotacion."',''";
		  	$formulario->dibujar_campo($campo,$parametros,"Nombres","tdtitulogris",'nombrescandidatovotacion','requerido');

			$campo="boton_tipo"; $parametros="'text','apellidoscandidatovotacion','".$apellidoscandidatovotacion."',''";
		  	$formulario->dibujar_campo($campo,$parametros,"Apellidos","tdtitulogris",'apellidoscandidatovotacion','requerido');


			
			/*$campo="boton_tipo"; $parametros="'text','rutaarchivofotocandidatovotacion','".$rutaarchivofotocandidatovotacion."',''";
		  	$formulario->dibujar_campo($campo,$parametros,"Ruta de imagen","tdtitulogris",'rutaarchivofotocandidatovotacion','requerido');*/

			$campo="boton_tipo"; $parametros="'text','telefonocandidatovotacion','".$telefonocandidatovotacion."','maxlength=\"10\"'";
		  	$formulario->dibujar_campo($campo,$parametros,"Telefono fijo","tdtitulogris",'telefonocandidatovotacion','');
	
			$campo="boton_tipo"; $parametros="'text','celularcandidatovotacion','".$celularcandidatovotacion."','maxlength=\"10\"'";
		  	$formulario->dibujar_campo($campo,$parametros,"Celular","tdtitulogris",'celularcandidatovotacion','');

			$campo="boton_tipo"; $parametros="'text','direccioncandidatovotacion','".$direccioncandidatovotacion."',''";
		  	$formulario->dibujar_campo($campo,$parametros,"Direccion","tdtitulogris",'direccioncandidatovotacion','');
			
			
			$formulario->dibujar_fila_titulo('Detalle de la plantilla','labelresaltado');
			
			$condicion=" codigoestado like '1%'";
			$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("votacion","idvotacion","nombrevotacion",$condicion,"",0);
			$formulario->filatmp[""]="Seleccionar";
			$menu="menu_fila"; $parametrosmenu="'idvotacion','".$idvotacion."','onchange=form1.submit();'";
			$formulario->dibujar_campo($menu,$parametrosmenu,"Votacion","tdtitulogris","idvotacion",'requerido');

			$condicion="";
			$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("tipoplantillavotacion","idtipoplantillavotacion","nombretipoplantillavotacion",$condicion,"",0);
			$formulario->filatmp[""]="Seleccionar";
			$menu="menu_fila"; $parametrosmenu="'idtipoplantillavotacion','".$idtipoplantillavotacion."','onchange=form1.submit();'";
			$formulario->dibujar_campo($menu,$parametrosmenu,"Tipos de plantilla","tdtitulogris","idtipoplantillavotacion",'requerido');


			if(isset($idtipoplantillavotacion)&&$idtipoplantillavotacion!='')
			{



/*				$condicion="p.idtipoplantillavotacion=".$idtipoplantillavotacion."
								and p.idvotacion=v.idvotacion
								and v.codigoestado like '1%'
								and p.codigoestado like '1%'
								and v.idvotacion=".$idvotacion."";
//								and '$fechahoy' < v.fechainiciovotacion 

//$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("plantillavotacion p,votacion v","idplantillavotacion","nombreplantillavotacion",$condicion,"",0);*/

/*echo "datosplantillavotacionplantilla<pre>";
print_r($datosplantillavotacionplantilla);
echo "</pre>";*/

$plantillasTabla=$objetobase->recuperar_datos_tabla_fila("nombreplantillavotacion","idnombreplantillavotacion","nombreplantillavotacion");
foreach($plantillasTabla as $plantilla){
	$plantillas["".$plantilla]=$plantilla;
}
//echo "<pre>";var_dump($plantillas);
$plantillastmp=$plantillas;
foreach($plantillastmp as $llave=>$campo){
	$pos=strpos($datosplantillavotacionplantilla['nombreplantillavotacion'],$campo);
	if (!($pos === false)) {
		//echo "ENTRO 1<BR>";
		$nombreplantillavotacion=$campo;
	}
	//echo $campo."<br>";
}
$formulario->filatmp=$plantillas;



					//if(){
						$formulario->filatmp[""]="Seleccionar";
						$menu="menu_fila";
						$parametrosmenu="'nombreplantillavotacion','".$nombreplantillavotacion."',''";
						$formulario->dibujar_campo($menu,$parametrosmenu,"Plantillas","tdtitulogris","nombreplantillavotacion",'requerido');

						if(isset($idtipocandidatodetalleplantillavotacion)&&$idtipocandidatodetalleplantillavotacion!='')
						{

if($idtipoplantillavotacion=='3'){
			$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("modalidadacademica","codigomodalidadacademica","nombremodalidadacademica");
			$formulario->filatmp[""]="Seleccionar";
			$campo='menu_fila'; $parametros="'codigomodalidadacademica','".$codigomodalidadacademica."','onChange=\"form1.submit();\"'";
			$formulario->dibujar_campo($campo,$parametros,"Modalidad","tdtitulogris",'codigomodalidadacademica','requerido',0);

			if(isset($codigomodalidadacademica)&&$codigomodalidadacademica!=''){
			//echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=".$REQUEST_URI.">";
			$condicion=" c.codigomodalidadacademica=".$codigomodalidadacademica.
						" ". 
					   " order by nombrecarrera2";
			$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("carrera c","c.codigocarrera","c.nombrecarrera",$condicion,', replace(c.nombrecarrera,\' \',\'\') nombrecarrera2');
			//$formulario->filatmp[""]="Seleccionar";
			$campo='menu_fila'; $parametros="'codigocarrera','".$codigocarrera."','onChange=\"enviarmenu(\'codigocarrera\');\"'";
			$formulario->dibujar_campo($campo,$parametros,"Carrera","tdtitulogris",'codigocarrera','requerido','',1);
			}

}

							$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("cargo c","idcargo","nombrecargo",' idcargo<>1 and codigoestado like \'1%\' order by prioridadcargo',"",0,1);
							//$formulario->filatmp[""]="Seleccionar";
							$menu="menu_fila"; $parametrosmenu="'idcargo','".$idcargo."',''";
							$formulario->dibujar_campo($menu,$parametrosmenu,"Cargo","tdtitulogris","idcargo",'requerido');
							
							
							$campo = "campo_fecha"; $parametros ="'text','fechainscripcioncandidatodetalleplantillavotacion','".$fechainscripcioncandidatodetalleplantillavotacion."','onKeyUp = \"this.value=formateafecha(this.value);\" $funcionfechainicial'";
				  			$formulario->dibujar_campo($campo,$parametros,"Fecha de inscripcion","tdtitulogris",'fechainscripcioncandidatodetalleplantillavotacion','requerido');

							$campo="memo"; $parametros="'resumenpropuestascandidatodetalleplantillavotacion','estudiantenovedadarp',70,8,'','','',''";
							$formulario->dibujar_campo($campo,$parametros,"Observacion","tdtitulogris",'resumenpropuestascandidatodetalleplantillavotacion');
							$formulario->cambiar_valor_campo('resumenpropuestascandidatodetalleplantillavotacion',$resumenpropuestascandidatodetalleplantillavotacion);


							if((isset($_GET['iddetalleplantillavotacion'])||(isset($_POST['modificar'])))&&(!isset($_REQUEST['Modificar']))){
								$parametrobotonenviar[$conboton]="'submit','Modificar','Modificar'";
								$boton[$conboton]='boton_tipo';
								$formulario->boton_tipo('hidden','idcandidatovotacion',$idcandidatovotacion);
								
								if(isset($_POST['iddetalleplantillavotacion']))
								$_GET['iddetalleplantillavotacion']=$_POST['iddetalleplantillavotacion'];
								
								$formulario->boton_tipo('hidden','iddetalleplantillavotacion',$_GET['iddetalleplantillavotacion']);
								$formulario->boton_tipo('hidden','modificar',1);

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
						}						
					/*}
					else{
						$formulario->dibujar_fila_titulo('No Hay Plantillas en Votaciones Vigentes','labelresaltado');
					}*/
				}


		$parametrobotonenviar[$conboton]="'Listado','listadocandidatoplantilla.php','codigoperiodo=".$codigoperiodo."&link_origen= ".$_GET['link_origen']."',700,600,5,50,'yes','yes','no','yes','yes'";
		$boton[$conboton]='boton_ventana_emergente';
		$conboton++;
		$parametrobotonenviar[$conboton]="'button','Regresar','Regresar','onclick=\'regresarGET();\''";
		$boton[$conboton]='boton_tipo';
		$formulario->dibujar_campos($boton,$parametrobotonenviar,"","tdtitulogris",'Enviar','',0);

if(isset($_REQUEST['Enviar'])){
	if($formulario->valida_formulario()){
		if(isset($_POST['codigocarrera'])&&trim($_POST['codigocarrera'])!='')
			$fila3["codigocarrera"]=$_POST['codigocarrera'];
		else
			$fila3["codigocarrera"]='1';

		$tabla="candidatovotacion";
		$fila['numerodocumentocandidatovotacion']=$_POST['numerodocumentocandidatovotacion'];
		$fila['nombrescandidatovotacion']=ltrim(rtrim($_POST['nombrescandidatovotacion']));
		$fila['apellidoscandidatovotacion']=ltrim(rtrim($_POST['apellidoscandidatovotacion']));
		$fila['telefonocandidatovotacion']=$_POST['telefonocandidatovotacion'];
		$fila['celularcandidatovotacion']=$_POST['celularcandidatovotacion'];
		$fila['direccioncandidatovotacion']=$_POST['direccioncandidatovotacion'];

		/*$condicionplantilla=" idtipoplantillavotacion='".$_POST["idtipoplantillavotacion"]."'".
					" and idvotacion='".$_POST["idvotacion"]."'".
					" and codigocarrera='".$fila3["codigocarrera"]."'".
					" and codigoestado='100'".
					" group by codigocarrera";
		$datoscuentaplantillas=$objetobase->recuperar_datos_tabla("plantillavotacion","codigoestado","100"," and ".$condicionplantilla,",count(distinct idplantillavotacion) cuenta",0);*/
		/*if($_POST['idcargo']=='3')
			$cuenta=$datoscuentaplantillas['cuenta'];
		else
			$cuenta=$datoscuentaplantillas['cuenta']+1;*/

		$con=0;
		foreach($plantillas as $llave=>$valor)
		{
			$con++;
			if($valor==$_POST['nombreplantillavotacion']){
				$cuenta=$con;
			}
		}

		$fila['numerotarjetoncandidatovotacion']="0".$cuenta;
		$fila['codigoestado']=100;
		$fila['rutaarchivofotocandidatovotacion']="../../imagenes/estudiantes/";
		
		$fila['idtipocandidatodetalleplantillavotacion']=$_POST['idtipocandidatodetalleplantillavotacion'];
		$condicionactualiza="numerodocumentocandidatovotacion='".$fila['numerodocumentocandidatovotacion']."'".
								" and idtipocandidatodetalleplantillavotacion=".$fila['idtipocandidatodetalleplantillavotacion'];
		$objetobase->insertar_fila_bd($tabla,$fila,0,$condicionactualiza);
		$tabla="plantillavotacion";	
		$fila3["idtipoplantillavotacion"]=$_POST['idtipoplantillavotacion'];
		$fila3["idvotacion"]=$_POST['idvotacion'];

		switch($_POST['idtipocandidatodetalleplantillavotacion']){
			case '1':
				$fila3["iddestinoplantillavotacion"]="3";	
			break;
			case '2':
				$fila3["iddestinoplantillavotacion"]="2";	
			break;
			case '3':
				$fila3["iddestinoplantillavotacion"]="1";	
			break;
		}
		

		$fila3["resumenplantillavotacion"]="";
		$datoscarrera=$objetobase->recuperar_datos_tabla("carrera","codigocarrera",$_POST['codigocarrera'],"","",0);

		$fila3["nombreplantillavotacion"]=$_POST["nombreplantillavotacion"]." ".$datoscarrera['nombrecarrera'];
		$fila3["codigoestado"]="100";


		
		$condicionactualiza=" idtipoplantillavotacion='".$fila3["idtipoplantillavotacion"]."'".
					" and idvotacion='".$fila3["idvotacion"]."'".
					" and codigocarrera='".$fila3["codigocarrera"]."'".
					" and nombreplantillavotacion='".$fila3["nombreplantillavotacion"]."'";

		$objetobase->insertar_fila_bd($tabla,$fila3,0,$condicionactualiza);

		$datosplantillavotacion=$objetobase->recuperar_datos_tabla("plantillavotacion","codigoestado","100"," and ".$condicionactualiza,"",0);




		$tabla="detalleplantillavotacion";

		$datoscandidato=$objetobase->recuperar_datos_tabla("candidatovotacion","numerodocumentocandidatovotacion",$fila['numerodocumentocandidatovotacion'],' and codigoestado like \'1%\' group by codigoestado',' ,max(idcandidatovotacion)',0);
		$fila2['idcandidatovotacion']=$datoscandidato['idcandidatovotacion'];
		$fila2['fechainscripcioncandidatodetalleplantillavotacion']=formato_fecha_mysql($_POST['fechainscripcioncandidatodetalleplantillavotacion']);
		$fila2['resumenpropuestascandidatodetalleplantillavotacion']=$_POST['resumenpropuestascandidatodetalleplantillavotacion'];
		$fila2['idplantillavotacion']=$datosplantillavotacion['idplantillavotacion'];
		$fila2['idcargo']=$_POST['idcargo'];
		$fila2['codigoestado']=100;
		$condicionactualiza=" idcandidatovotacion=".$fila2['idcandidatovotacion'].
								" and idplantillavotacion=".$fila2['idplantillavotacion'].
								" and idcargo=".$fila2['idcargo'];
		//alerta_javascript($_POST['resumenpropuestascandidatodetalleplantillavotacion']);
		$objetobase->insertar_fila_bd($tabla,$fila2,0,$condicionactualiza);

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
		//$fila['direccioncandidatovotacion']=$_POST['direccioncandidatovotacion'];
		//$fila['numerotarjetoncandidatovotacion']=$_POST['numerotarjetoncandidatovotacion'];
		$con=0;
		foreach($plantillas as $llave=>$valor)
		{
			$con++;
			if($valor==$_POST['nombreplantillavotacion']){
				$cuenta=$con;
			}
		}

		$fila['numerotarjetoncandidatovotacion']="0".$cuenta;
	
		//$fila['codigoestado']=100;
		//$fila['rutaarchivofotocandidatovotacion']='../../imagenes/estudiantes/';
		$fila['rutaarchivofotocandidatovotacion']="../../imagenes/estudiantes/";

		$fila['idtipocandidatodetalleplantillavotacion']=$_POST['idtipocandidatodetalleplantillavotacion'];
		$objetobase->actualizar_fila_bd($tabla,$fila,$nombreidtabla,$idtabla);



		$tabla="plantillavotacion";	
		$fila3["idtipoplantillavotacion"]=$_POST['idtipoplantillavotacion'];
		$fila3["idvotacion"]=$_POST['idvotacion'];

		switch($_POST['idtipocandidatodetalleplantillavotacion']){
			case '1':
				$fila3["iddestinoplantillavotacion"]="3";	
			break;
			case '2':
				$fila3["iddestinoplantillavotacion"]="2";	
			break;
			case '3':
				$fila3["iddestinoplantillavotacion"]="1";	
			break;
		}
		

		$fila3["resumenplantillavotacion"]="";
		$datoscarrera=$objetobase->recuperar_datos_tabla("carrera","codigocarrera",$_POST['codigocarrera'],"","",0);

		$fila3["nombreplantillavotacion"]=$_POST["nombreplantillavotacion"]." ".$datoscarrera['nombrecarrera'];
		$fila3["codigoestado"]="100";
		if(isset($_POST['codigocarrera'])&&trim($_POST['codigocarrera'])!='')
			$fila3["codigocarrera"]=$_POST['codigocarrera'];
		else
			$fila3["codigocarrera"]='1';

		$condicionactualiza=" idtipoplantillavotacion='".$fila3["idtipoplantillavotacion"]."'".
					" and idvotacion='".$fila3["idvotacion"]."'".
					" and codigocarrera='".$fila3["codigocarrera"]."'".
					" and nombreplantillavotacion='".$fila3["nombreplantillavotacion"]."'";

				

		$objetobase->insertar_fila_bd($tabla,$fila3,0,$condicionactualiza);


		$datosplantillavotacion=$objetobase->recuperar_datos_tabla("plantillavotacion","codigoestado","100"," and ".$condicionactualiza,"",0);


		$tabla="detalleplantillavotacion";
		$nombreidtabla="iddetalleplantillavotacion";
		$idtabla=$_POST['iddetalleplantillavotacion'];
		$fila2['idcandidatovotacion']=$_POST['idcandidatovotacion'];
		$fila2['fechainscripcioncandidatodetalleplantillavotacion']=formato_fecha_mysql($_POST['fechainscripcioncandidatodetalleplantillavotacion']);
		$fila2['resumenpropuestascandidatodetalleplantillavotacion']=$_POST['resumenpropuestascandidatodetalleplantillavotacion'];
		$fila2['idplantillavotacion']=$datosplantillavotacion['idplantillavotacion'];
		$fila2['idcargo']=$_POST['idcargo'];
		//$fila['codigoestado']=100;
		$objetobase->actualizar_fila_bd($tabla,$fila2,$nombreidtabla,$idtabla);
	
		
		echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=$REQUEST_URI'>";
	
	}
}
if(isset($_REQUEST['Anular'])){
	$tabla="detalleplantillavotacion";
	$fila['codigoestado']=200;
	$nombreidtabla="iddetalleplantillavotacion";
	$idtabla=$_POST['iddetalleplantillavotacion'];
	$objetobase->actualizar_fila_bd($tabla,$fila,$nombreidtabla,$idtabla);
	
	$tabla="candidatovotacion";
	$fila['codigoestado']=200;
	$nombreidtabla="idcandidatovotacion";
	$idtabla=$_POST['idcandidatovotacion'];
	$objetobase->actualizar_fila_bd($tabla,$fila,$nombreidtabla,$idtabla);
	//echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=$REQUEST_URI'>";
	echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=$REQUEST_URI'>";
}		

?>

  </table>
</form>
</body>
</html>