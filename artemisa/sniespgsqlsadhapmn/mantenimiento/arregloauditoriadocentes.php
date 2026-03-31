<?php
	//error_reporting(0);
	ini_set('memory_limit', '128M');
	ini_set('max_execution_time','216000');
	$rutaado=("../../serviciosacademicos/funciones/adodb_mod/");
	require_once('../../serviciosacademicos/Connections/salaado-pear.php');
	require_once('../../serviciosacademicos/Connections/snies_conexion_postgresql.php');
	

	$rutaado=("../../serviciosacademicos/funciones/adodb/");
	require_once("../../serviciosacademicos/funciones/clases/debug/SADebug.php");
	require_once("../../serviciosacademicos/Connections/salaado-pear.php");
	require_once("../../serviciosacademicos/funciones/sala_genericas/FuncionesCadena.php");
	require_once("../../serviciosacademicos/funciones/sala_genericas/FuncionesFecha.php");
	require_once("../../serviciosacademicos/funciones/sala_genericas/clasebasesdedatosgeneral.php");

function encontrartipodocumento($tipodocumento){

	switch($tipodocumento){
		case '1':
			$tipodocumentosnies='CC';
		break;
		case '2':
			$tipodocumentosnies='TI';
		break;
		case '3':
			$tipodocumentosnies='CE';
		break;
		case '5':
			$tipodocumentosnies='RC';
		break;
		case '6':
			$tipodocumentosnies='CC';
		break;
		case '7':
			$tipodocumentosnies='CC';
		break;
		default:
			$tipodocumentosnies='CC';
		break;


	}
return $tipodocumentosnies;
	
}

$annio="2010";
$periodo="01";

$snies_conexion->debug=false;
$objetobasesnies=new BaseDeDatosGeneral($snies_conexion);

$objetobasesala=new BaseDeDatosGeneral($sala);

$resultado=$objetobasesala->recuperar_resultado_tabla("tmpdocentesauditoria","annio",$annio,"","",0);
$noencontrodh=0;
$noencontrod=0;
while($rowdocentes=$resultado->fetchRow()){

$condicion=" and ne.nivel_code=d.nivel_est_code";

	if($datosdocente=$objetobasesnies->recuperar_datos_tabla("docente d,nivel_estudio ne","codigo_unico",$rowdocentes["numerodocumento"],$condicion,"",0)){

		$datosnuevonivel=$objetobasesnies->recuperar_datos_tabla("nivel_estudio ne","ne.nivel_descr",$rowdocentes["nivel"],"","",0);

		if($rowdocentes["nivel"]=="BACHILLER"){
			$datosnuevonivel['nivel_code']='09';
			$datosnuevonivel['nivel_descr']='DIPLOMADO';
		
		}
		if($datosdocente['nivel_descr']!=$datosnuevonivel['nivel_descr']){
unset($fila);
	
			echo "<br>ENCONTRO DOCENTE CODIGO_UNICO=".$datosdocente['codigo_unico']." NIVEL=".$datosdocente['nivel_descr']." NUEVO NIVEL=".$datosnuevonivel['nivel_code']."-".$datosnuevonivel['nivel_descr'];
			$tabla="docente";
			$fila["nivel_est_code"]=$datosnuevonivel['nivel_code'];
			$nombreidtabla="codigo_unico";
			$idtabla="'".$datosdocente['codigo_unico']."'";
			$condicion="";
			$objetobasesnies->actualizar_fila_bd($tabla,$fila,$nombreidtabla,$idtabla,$condicion,1);

		}

	}
	else{

unset($fila);

echo "<br>NO ENCONTRO DOCENTE CODIGO_UNICO=".$rowdocentes['numerodocumento'];
		$datosnuevonivel=$objetobasesnies->recuperar_datos_tabla("nivel_estudio ne","ne.nivel_descr",$rowdocentes["nivel"],"","",0);

		$condicion=" and t.idciudadnacimiento=c.idciudad and
		 d.iddepartamento=t.iddepartamentonacimiento and
		p.idpais=t.idpaisnacimiento and t.idestadocivil=ec.idestadocivil";
		unset($datosdocente);
		if(!$datosdocente=$objetobasesala->recuperar_datos_tabla("docente t,ciudad c,departamento d, pais p,estadocivil ec","t.numerodocumento",$rowdocentes['numerodocumento'],$condicion,"",1)){
			$datosdocente['fechanacimientodocente']="1970-01-01";
			$datosdocente['codigosappais']="CO";
			$datosdocente['codigosapdepartamento']="11";
			$datosdocente['codigosapciudad']="11001";
			if($rowdocentes['genero']=='F')
			$datosdocente["codigogenero"]="100";
			else
			$datosdocente["codigogenero"]="200";
			$datosdocente['emaildocente']="";
			$datosdocente['codigosniesestadocivil']='01';
			$datosdocente['telefonoresidenciadocente']='0';

		}
		

		//$datostmpdocente=$objetobasesala->recuperar_datos_tabla("tmpdocentescompletopersonal as t","t.numerodocumento",$rowdocentes['numerodocumento'],"","",1);

	if(!$participante=$objetobasesnies->recuperar_datos_tabla("participante","codigo_unico",$rowdocentes["numerodocumento"],"","",0)){

		$tabla='participante';
		$fila['ies_code']='1729';
		$fila['primer_apellido']=$rowdocentes['apellido1'];
		$fila['segundo_apellido']=$rowdocentes['apellido2'];
		$fila['primer_nombre']=$rowdocentes['nombre1'];
		$fila['segundo_nombre']=$rowdocentes['nombre2'];
		if($datosdocente['fechanacimientodocente']=="0000-00-00")
			$datosdocente['fechanacimientodocente']="1970-01-01";
		
		$fila['fecha_nacim']=$datosdocente['fechanacimientodocente'];
		$fila['pais_ln']=$datosdocente['codigosappais'];
		$fila['departamento_ln']=$datosdocente['codigosapdepartamento'];
		$fila['municipio_ln']=$datosdocente["codigosapciudad"];
		if($datosdocente["codigogenero"]=="200")
			$fila['genero_code']='01';
		else
			$fila['genero_code']='02';
		$fila['email']=$datosdocente['emaildocente'];
		$fila['est_civil_code']=$datosdocente['codigosniesestadocivil'];
		$fila['tipo_doc_unico']=encontrartipodocumento($rowdocentes['tipodocumento']);
		$fila['codigo_unico']=$rowdocentes['numerodocumento'];
		$fila['codigo_id_ant']=null;
		$fila['pais_tel']=57;
		$fila['area_tel']=1;
		$fila['numero_tel']=$datosdocente['telefonoresidenciadocente'];
		$condicionactualiza=" and codigo_unico='".$fila['codigo_unico']."'
					and tipo_doc_unico='".$fila['tipo_doc_unico']."'";
		echo "<pre>";
		$objetobasesnies->insertar_fila_bd($tabla,$fila,1,"");
		echo "</pre>";
		
	}

unset($fila);


	if(isset($datosdocente['fechaprimercontratodocente'])&&trim($datosdocente['fechaprimercontratodocente'])!=''&&$datosdocente['fechaprimercontratodocente']!='0000-00-00')
	{
		$fila["fecha_ingreso"]=$datosdocente['fechaprimercontratodocente'];
	}
	else{
		$fila["fecha_ingreso"]="2009-06-01";
	}
		$tabla="docente";
		$fila['ies_code']='1729';
		$fila['codigo_unico']=$rowdocentes['numerodocumento'];
		$fila["tipo_doc_unico"]=encontrartipodocumento($rowdocentes['tipodocumento']);		
		$fila["nivel_est_code"]=$datosnuevonivel['nivel_code'];
		//$fila["fecha_ingreso"]=$datosdocente['fechaprimercontratodocente'];
		$condicionactualiza=" and codigo_unico='".$fila['codigo_unico']."'";
	
		echo "<pre>";
		$objetobasesnies->insertar_fila_bd($tabla,$fila,1,$condicionactualiza);
		echo "</pre>";

		$noencontrod++;
		
	
	}

	$condicion=" and d.annio='".$rowdocentes['annio']."' and d.semestre='".$rowdocentes['periodo']."'
			and dd.identificacion=d.dedicacion";

	//Encuentra docentes en tabla docente_h y actualiza dedicacion en docente_h y docente_unidad
	if($datosdocenteh=$objetobasesnies->recuperar_datos_tabla("docente_h as d, dedicacion_docente as dd","d.codigo_unico",$rowdocentes["numerodocumento"],$condicion,"",0)){

		$datosnuevadedicacion=$objetobasesnies->recuperar_datos_tabla("dedicacion_docente as dd","dd.valor", ucwords(strtolower($rowdocentes["tiempo"])),"","",0);




		

		if($datosdocenteh['valor']!=$datosnuevadedicacion['valor']){
			echo "<br>ENCONTRO DOCENTE_H CODIGO_UNICO=".$datosdocenteh['codigo_unico']." dedicacion=".$datosdocenteh['valor']." nueva dedicacion=".$datosnuevadedicacion['identificacion']."-".$datosnuevadedicacion['valor'];
unset($fila);
			$tabla="docente_h";
			$fila["dedicacion"]=$datosnuevadedicacion['identificacion'];
			$nombreidtabla="codigo_unico";
			$idtabla="'".$datosdocenteh['codigo_unico']."'";
			$condicion=" and annio='".$rowdocentes['annio']."' and semestre='".$rowdocentes['periodo']."'";

			$objetobasesnies->actualizar_fila_bd($tabla,$fila,$nombreidtabla,$idtabla,$condicion,1);
unset($fila);
			$tabla="docente_unidad";
			$fila["dedicacion"]=$datosnuevadedicacion['identificacion'];
			$nombreidtabla="codigo_unico";
			$idtabla="'".$datosdocenteh['codigo_unico']."'";
			$condicion="";
			$objetobasesnies->actualizar_fila_bd($tabla,$fila,$nombreidtabla,$idtabla,$condicion,1);

		}

	}
	else{

		$datosnuevadedicacion=$objetobasesnies->recuperar_datos_tabla("dedicacion_docente as dd","dd.valor", ucwords(strtolower($rowdocentes["tiempo"])),"","",0);



unset($fila);
		$tabla="docente_h";
		$fila['ies_code']='1729';
		$fila['codigo_unico']=$rowdocentes['numerodocumento'];
		$fila['annio']=$rowdocentes['annio'];
		$fila['semestre']=$rowdocentes['periodo'];
		$fila["dedicacion"]=$datosnuevadedicacion['identificacion'];
		$fila['cod_uni_org']='UB';
		$fila['tipo_contrato']="02";
		$fila['porcentaje_docencia']="0";
		$fila['porcentaje_investigacion']="0";
		$fila['porcentaje_administrativa']="0";
		$fila['porcentaje_bienestar']="0";
		$fila['porcentaje_edu_no_formal_ycont']="0";
		$fila['porcentaje_proy_progr_remun']="0";
		$fila['porcentaje_proy_no_remun']="0";
		$fila['premios_semestre_nal']="0";
		$fila['libros_publ_texto_calificados']="0";
		$fila["tipo_doc_unico"]=encontrartipodocumento($rowdocentes['tipodocumento']);		
		$fila['porcentaje_otras_actividades']="0";
		$fila['libros_pub_investigacion']="0";
		$fila['libros_pub_texto']="0";
		$fila['reportes_investigacion']="0";
		$fila['patentes_obtenidas_semestre']="0";
		$fila['premios_semestre_internal']="0";
		//$fila['duracion_en_horas']="0";
		$condicionactualiza=" and codigo_unico='".$fila['codigo_unico']."'
					and annio='".$fila['annio']."'
					and semestre='".$fila['semestre']."' 
					and tipo_doc_unico='".$fila['tipo_doc_unico']."'";
				
		$objetobasesnies->insertar_fila_bd($tabla,$fila,0,$condicionactualiza);
unset($fila);
		$tabla='docente_unidad';
		$filados['ies_code']='1729';
		$filados['codigo_unico']=$rowdocentes['numerodocumento'];
		$filados['cod_unid_org']='UB';
		$filados['dedicacion']=$datosnuevadedicacion['identificacion'];
		$filados['tipo_doc_unico']=encontrartipodocumento($rowdocentes['tipodocumento']);	
		$condicionactualiza=" and codigo_unico='".$filados['codigo_unico']."'
					and tipo_doc_unico='".$filados['tipo_doc_unico']."'";
				
		$objetobasesnies->insertar_fila_bd($tabla,$filados,0,$condicionactualiza);

		$noencontrodh++;
		//echo "<br>NO ENCONTRO DOCENTE_H CODIGO_UNICO=".$rowdocentes['numerodocumento'];
	
	}

}
echo "<h1>DOCENTES NO ENCONTRADOS=".$noencontrod." DOCENTES_H NO ENCONTRADOS =".$noencontrodh." </h1>";


$resultado=$objetobasesnies->recuperar_resultado_tabla("docente_h","annio",$annio," and semestre='".$periodo."'","",1);
while($rowdocentessnies=$resultado->fetchRow()){

if(!$datosdocenteauditoria=$objetobasesala->recuperar_datos_tabla("tmpdocentesauditoria","numerodocumento",$rowdocentessnies['codigo_unico']," and annio='".$rowdocentessnies['annio']."' and periodo='".$rowdocentessnies['semestre']."'","",0)){

	echo "<br>NO ENCONTRO DOCENTE AUDITORIA CODIGO_UNICO=".$rowdocentessnies['codigo_unico'];
	$objetobasesnies->conexion->query("delete from docente_h where annio='".$annio."' and semestre='".$periodo."' and codigo_unico='".$rowdocentessnies['codigo_unico']."'");
	
}

}


?>