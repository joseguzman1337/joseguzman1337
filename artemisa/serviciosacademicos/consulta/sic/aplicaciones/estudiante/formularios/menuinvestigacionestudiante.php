<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
function menuinvestigacionestudiante($objetobase,$formulario,$objdibujaformulario){

$nombreidtabla="idlineainvestigacionestudiante";
$idtablaget=$_GET["idlineainvestigacionestudiante"];
$idformulario=$_GET["idformulario"];
/*echo "_POST_menuinvestigaciondocente<pre>";
print_r($_POST);
echo "</pre>";*/
	if(is_array($_POST)&&count($_POST)>0){

		$codigofacultad=$_POST["codigofacultad"];
		$idgrupoinvestigacion=$_POST["idgrupoinvestigacion"];
		$idlineainvestigacion=$_POST["idlineainvestigacion"];
	}
	else{

		$idlineainvestigacion=$objdibujaformulario->recuperarValorCampo("idlineainvestigacion");
		$condicion=" and l.idgrupoinvestigacion=g.idgrupoinvestigacion";
		$datosgrupoinvestigacion=$objetobase->recuperar_datos_tabla("lineainvestigacion l,grupoinvestigacion g","l.idlineainvestigacion",$idlineainvestigacion,$condicion,'',0);
		$idgrupoinvestigacion=$datosgrupoinvestigacion["idgrupoinvestigacion"];
		$codigofacultad=$datosgrupoinvestigacion["codigofacultad"];
	}


/*Muestra los menu de seleccion dependientes pais, depatamento, ciudad*/
$condicion=" 1=1 order by nombrefacultad";
	$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("facultad f ","codigofacultad","nombrefacultad",$condicion,'',0);
	//$formulario->filatmp["0"]="*Otro*";
	$formulario->filatmp[""]="Seleccionar";	
	$campo='menu_fila'; $parametros="'codigofacultad','".$codigofacultad."','onchange=enviarfacultad(\'".$idformulario."\',\'".$nombreidtabla."\',\'".$idtablaget."\',\'".$_REQUEST["Nuevo_Registro"]."\');'";
	$formulario->dibujar_campo($campo,$parametros,"Facultad","tdtitulogris",'codigofacultad','requerido');
	//$objdibujaformulario->columnas[]="idpaisestimulodocente";


	$condicion=" g.codigofacultad='".$codigofacultad."' order by nombregrupoinvestigacion";
	$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("grupoinvestigacion g","idgrupoinvestigacion","nombregrupoinvestigacion",$condicion,'',0);
	//$formulario->filatmp["0"]="*Otro*";
	$formulario->filatmp[""]="Seleccionar";	
	$campo='menu_fila'; $parametros="'idgrupoinvestigacion','".$idgrupoinvestigacion."','onchange=enviargrupo(\'".$idformulario."\',\'".$nombreidtabla."\',\'".$idtablaget."\',\'".$_REQUEST["Nuevo_Registro"]."\');'";
	$formulario->dibujar_campo($campo,$parametros,"Grupo Investigacion ","tdtitulogris",'idgrupoinvestigacion','requerido');
	//$objdibujaformulario->columnas[]="idpaisestimulodocente";

	//if(isset($pais)&&trim($pais)!=''&&trim($pais)!='todos'){

		$condicion=" l.idgrupoinvestigacion='".$idgrupoinvestigacion."' order by
				 nombrelineainvestigacion
			";
		$formulario->filatmp=$objetobase->recuperar_datos_tabla_fila("lineainvestigacion l ","idlineainvestigacion","nombrelineainvestigacion",$condicion,'',0);
		//$formulario->filatmp["216"]="*Otro*";
		$formulario->filatmp[""]="Seleccionar";	
		$campo='menu_fila'; $parametros="'idlineainvestigacion','".$idlineainvestigacion."','onchange=enviarlinea(\'".$idformulario."\',\'".$nombreidtabla."\',\'".$idtablaget."\',\'".$_REQUEST["Nuevo_Registro"]."\');'";
		$formulario->dibujar_campo($campo,$parametros,"Linea de investigacion ","tdtitulogris",'idlineainvestigacion','requerido');
		

}
?>