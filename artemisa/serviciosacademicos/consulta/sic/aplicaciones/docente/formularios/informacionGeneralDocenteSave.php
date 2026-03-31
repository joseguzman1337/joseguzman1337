<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
include_once("includes/connection.php");
$db =& connection::getInstance();
$success=true;
if($_REQUEST["opc"]=="ip") {
	$cadena="UPDATE docente
		 SET	 apellidodocente='".$_REQUEST['apellidodocente']."'
			,nombredocente='".$_REQUEST['nombredocente']."'
			,tipodocumento='".$_REQUEST['tipodocumento']."'
			,numerodocumento='".$_REQUEST['numerodocumento']."'
			,emaildocente='".$_REQUEST['emaildocente']."'
			,usuarioskypedocente='".$_REQUEST['usuarioskypedocente']."'
			,perfilfacebookdocente='".$_REQUEST['perfilfacebookdocente']."'
			,codigogenero='".$_REQUEST['codigogenero']."'
			,fechanacimientodocente='".$_REQUEST['fechanacimientodocente']."'
			,idestadocivil='".$_REQUEST['idestadocivil']."'
			,direcciondocente='".$_REQUEST['direcciondocente']."'
			,idciudadresidencia='".$_REQUEST['idciudadresidencia']."'
			,telefonoresidenciadocente='".$_REQUEST['telefonoresidenciadocente']."'
			,numerocelulardocente='".$_REQUEST['numerocelulardocente']."'
			,profesion='".$_REQUEST['profesion']."'
			,numerotarjetaprofesionaldocente='".$_REQUEST['numerotarjetaprofesionaldocente']."'
			,fechaexpediciontarjetaprofesionaldocente='".$_REQUEST['fechaexpediciontarjetaprofesionaldocente']."'
			,nombreempresapropiadocente='".$_REQUEST['nombreempresapropiadocente']."'
			,fechaprimercontratodocente='".$_REQUEST['fechaprimercontratodocente']."'
			,modalidadocente='".$_REQUEST['modalidadocente']."'
			,idciudadnacimiento='".$_REQUEST['idciudadnacimiento']."'
		 WHERE iddocente=".$_SESSION["sissic_iddocente"];
	if(!$db->exec($cadena))
		$sucess=false;
	$cadena="UPDATE nucleofamiliadocente SET cantidadnucleofamiliadocente=".(($_REQUEST['checkpadre'])?1:0)." WHERE idnucleofamiliadocente=".$_REQUEST['padre'];
	if(!$db->exec($cadena))
		$sucess=false;
	$cadena="UPDATE nucleofamiliadocente SET cantidadnucleofamiliadocente=".(($_REQUEST['checkmadre'])?1:0)." WHERE idnucleofamiliadocente=".$_REQUEST['madre'];
	if(!$db->exec($cadena))
		$sucess=false;
	$cadena="UPDATE nucleofamiliadocente SET cantidadnucleofamiliadocente=".(($_REQUEST['checkhermanos'])?1:0)." WHERE idnucleofamiliadocente=".$_REQUEST['hermanos'];
	if(!$db->exec($cadena))
		$sucess=false;
	$cadena="UPDATE nucleofamiliadocente SET cantidadnucleofamiliadocente=".(($_REQUEST['checkesposo'])?1:0)." WHERE idnucleofamiliadocente=".$_REQUEST['esposo'];
	if(!$db->exec($cadena))
		$sucess=false;
	$cadena="UPDATE nucleofamiliadocente SET cantidadnucleofamiliadocente=".$_REQUEST['nrohijos']." WHERE idnucleofamiliadocente=".$_REQUEST['hijos'];
	if(!$db->exec($cadena))
		$sucess=false;
	if($success)
		echo "<script>alert('¡¡ La información se ha actualizado correctamente. !!');location.href='?opc=".$_REQUEST["opc"]."';</script>";
	else
		echo "<script>alert('¡¡ Ocurrio un error al actualizar la información. !!');location.href='?opc=".$_REQUEST["opc"]."';</script>";
}
if ($_REQUEST["opc"]=="dp") {
	if(trim($_REQUEST["bilinguismo"]))
		$db->exec("insert into desarrolloprofesoral (iddocente,items,descripcionitem) values (".$_SESSION["sissic_iddocente"].",'Bilinguismo','".trim($_REQUEST["bilinguismo"])."')");
	if(trim($_REQUEST["aprendizaje"]))
		$db->exec("insert into desarrolloprofesoral (iddocente,items,descripcionitem) values (".$_SESSION["sissic_iddocente"].",'Aprendizaje significativo : Disenado integrado curso','".trim($_REQUEST["aprendizaje"])."')");
	if(trim($_REQUEST["capacitaciontics"]))
		$db->exec("insert into desarrolloprofesoral (iddocente,items,descripcionitem) values (".$_SESSION["sissic_iddocente"].",'Capacitacion en TICS','".trim($_REQUEST["capacitaciontics"])."')");
	if(trim($_REQUEST["capacitacionsistemasref"]))
		$db->exec("insert into desarrolloprofesoral (iddocente,items,descripcionitem) values (".$_SESSION["sissic_iddocente"].",'Capacitacion en sistemas de referenciacion','".trim($_REQUEST["capacitacionsistemasref"])."')");
	if(trim($_REQUEST["estudiospostgrados"]))
		$db->exec("insert into desarrolloprofesoral (iddocente,items,descripcionitem) values (".$_SESSION["sissic_iddocente"].",'Estudios de postgrados','".trim($_REQUEST["estudiospostgrados"])."')");
	if(trim($_REQUEST["otroscursos"]))
		$db->exec("insert into desarrolloprofesoral (iddocente,items,descripcionitem) values (".$_SESSION["sissic_iddocente"].",'Otros cursos','".trim($_REQUEST["otroscursos"])."')");
	echo "<script>alert('¡¡ La información se ha actualizado correctamente. !!');location.href='?opc=".$_REQUEST["opc"]."&acc=list';</script>";
}
if ($_REQUEST["opc"]=="pu") {
	if ($_REQUEST["acc"]=="edit") {
		if($_REQUEST["tipoparticipacion"]==400) {
			$cadena="delete from participacionuniversitariadocente where codigoperiodo='".$_SESSION["codigoperiodosesion"]."' and iddocente= '".$_SESSION["sissic_iddocente"]."' and codigoestado like '1%' and codigotipoconsejouniversidad <> '400'";
			if(!$db->exec($cadena))
				$sucess=false;
			//echo $cadena."<br>";
			if(isset($tipo)) {
				foreach ($_REQUEST["tipo"] as &$valor) {
					$cadena="insert into participacionuniversitariadocente (iddocente,codigoperiodo,codigotipoconsejouniversidad,codigotipoparticipacionuniversitaria,codigoestado) values (".$_SESSION["sissic_iddocente"].",".$_SESSION["codigoperiodosesion"].",".$valor.",400,100)";
					if(!$db->exec($cadena))
						$sucess=false;
					//echo $cadena."<br>";
				}
			}
		} else {
			$cadena="UPDATE participacionuniversitariadocente SET nombreparticipacionuniversitariadocente='".$_REQUEST["descripcion"]."' where idparticipacionuniversitariadocente=".$_REQUEST["id"];
			if(!$db->exec($cadena))
				$sucess=false;
		}
		if($success)
			echo "<script>alert('¡¡ La información se ha actualizado correctamente. !!');location.href='?opc=".$_REQUEST["opc"]."&acc=list';</script>";
		else
			echo "<script>alert('¡¡ Ocurrio un error al actualizar la información. !!');location.href='?opc=".$_REQUEST["opc"]."&acc=list';</script>";
	}
	if ($_REQUEST["acc"]=="new") {
		if($_REQUEST["tipoparticipacion"]==400) {
			if(isset($tipo)) {
				foreach ($_REQUEST["tipo"] as &$valor) {
					$cadena="insert into participacionuniversitariadocente (iddocente,codigoperiodo,codigotipoconsejouniversidad,codigotipoparticipacionuniversitaria,codigoestado) values (".$_SESSION["sissic_iddocente"].",".$_SESSION["codigoperiodosesion"].",".$valor.",400,100)";
					//echo $cadena."<br>";
					if(!$db->exec($cadena))
						$sucess=false;
				}
			}
		} else {
			$cadena="INSERT INTO participacionuniversitariadocente (iddocente,codigoperiodo,codigotipoconsejouniversidad,codigotipoparticipacionuniversitaria,nombreparticipacionuniversitariadocente,codigoestado) VALUES (".$_SESSION["sissic_iddocente"].",'".$_SESSION["codigoperiodosesion"]."',400,".$_REQUEST["tipoparticipacion"].",'".$_REQUEST["descripcion"]."',100)";
			if(!$db->exec($cadena))
				$sucess=false;
		}
		if($success)
			echo "<script>alert('¡¡ La información se ha ingresado correctamente. !!');location.href='?opc=".$_REQUEST["opc"]."&acc=list';</script>";
		else
			echo "<script>alert('¡¡ Ocurrio un error al ingresar la información. !!');location.href='?opc=".$_REQUEST["opc"]."&acc=list';</script>";
	}
}
if ($_REQUEST["opc"]=="aluli") {
	if ($_REQUEST["acc"]=="new") {
		$cadena="insert into lineainvestigaciondocente (iddocente,codigoperiodo,idlineainvestigacion,numerohoraslineainvestigaciondocente,fechaingresolineainvestigacion,codigoestado,nombre_proyecto,actividad_desarrollada,tipo_proyecto) values ('".$_SESSION["sissic_iddocente"]."','".$_SESSION["codigoperiodosesion"]."',".$_REQUEST["idlineainvestigacion"].",".$_REQUEST["numerohoraslineainvestigaciondocente"].",'".$_REQUEST["fechaingresolineainvestigacion"]."',100,'".$_REQUEST["nombre_proyecto"]."','".$_REQUEST["actividad_desarrollada"]."'";
		if(isset($_REQUEST["tipo_proyecto"]))
			$cadena.=",'".$_REQUEST["tipo_proyecto"]."'";
		else
			$cadena.=",NULL";
		$cadena.=")";
		if(!$db->exec($cadena))
			$sucess=false;
		if($success)
			echo "<script>alert('¡¡ La información se ha ingresado correctamente. !!');location.href='?opc=".$_REQUEST["opc"]."&acc=list';</script>";
		else
			echo "<script>alert('¡¡ Ocurrio un error al ingresar la información. !!');location.href='?opc=".$_REQUEST["opc"]."&acc=list';</script>";
	} 
	if ($_REQUEST["acc"]=="edit") {
		$cadena="update lineainvestigaciondocente set iddocente='".$_SESSION["sissic_iddocente"]."',codigoperiodo='".$_SESSION["codigoperiodosesion"]."',idlineainvestigacion=".$_REQUEST["idlineainvestigacion"].",numerohoraslineainvestigaciondocente=".$_REQUEST["numerohoraslineainvestigaciondocente"].",fechaingresolineainvestigacion='".$_REQUEST["fechaingresolineainvestigacion"]."',codigoestado=100,nombre_proyecto='".$_REQUEST["nombre_proyecto"]."',actividad_desarrollada='".$_REQUEST["actividad_desarrollada"]."',tipo_proyecto=";
		if(isset($_REQUEST["tipo_proyecto"]))
			$cadena.="'".$_REQUEST["tipo_proyecto"]."'";
		else
			$cadena.="NULL";
		$cadena.=" where idlineainvestigaciondocente=".$_REQUEST["id"];
		if(!$db->exec($cadena))
			$sucess=false;
		if($success)
			echo "<script>alert('¡¡ La información se ha actualizado correctamente. !!');location.href='?opc=".$_REQUEST["opc"]."&acc=list';</script>";
		else
			echo "<script>alert('¡¡ Ocurrio un error al actualizar la información. !!');location.href='?opc=".$_REQUEST["opc"]."&acc=list';</script>";
	}
} 
if ($_REQUEST["opc"]=="alupsoagaa") {
	if ($_REQUEST["acc"]=="new") {
		if($_REQUEST["codigotipoactividadlaboral"]==300)
			$cadena="insert into proyeccionsocialdocente (iddocente,actividad_a_desarrollar,codigoestado,nombre_proyecto,numero_horas_semana) values ('".$_SESSION["sissic_iddocente"]."','".$_REQUEST["actividad"]."',100,'".$_REQUEST["proyecto"]."',".$_REQUEST["horas"].")";
		if($_REQUEST["codigotipoactividadlaboral"]==400 || $_REQUEST["codigotipoactividadlaboral"]==500) {
			$tabla=($_REQUEST["codigotipoactividadlaboral"]==400)?"orientacionacademicadocente":"gestionacademincadocente";
			$cadena="insert into ".$tabla." (iddocente,actividad_desarrollada,codigoestado,numero_horas_semana) values ('".$_SESSION["sissic_iddocente"]."','".$_REQUEST["actividad"]."',100,".$_REQUEST["horas"].")";
		}
		if(!$db->exec($cadena))
			$sucess=false;
		if($success)
			echo "<script>alert('¡¡ La información se ha ingresado correctamente. !!');location.href='?opc=".$_REQUEST["opc"]."&acc=list';</script>";
		else
			echo "<script>alert('¡¡ Ocurrio un error al ingresar la información. !!');location.href='?opc=".$_REQUEST["opc"]."&acc=list';</script>";
	} 
	if ($_REQUEST["acc"]=="edit") {
		if($_REQUEST["codigotipoactividadlaboral"]==300)
			$cadena="update proyeccionsocialdocente set iddocente='".$_SESSION["sissic_iddocente"]."',actividad_a_desarrollar='".$_REQUEST["actividad"]."',codigoestado=100,nombre_proyecto='".$_REQUEST["proyecto"]."',numero_horas_semana=".$_REQUEST["horas"]." where idproyeccionsocialdocente=".$_REQUEST["id"];
		if($_REQUEST["codigotipoactividadlaboral"]==400 || $_REQUEST["codigotipoactividadlaboral"]==500) {
			$tabla=($_REQUEST["codigotipoactividadlaboral"]==400)?"orientacionacademicadocente":"gestionacademincadocente";
			$campo=($_REQUEST["codigotipoactividadlaboral"]==400)?"idorientacionacademicadocente":"idgestionacademincadocente";
			$cadena="update ".$tabla." set iddocente='".$_SESSION["sissic_iddocente"]."',actividad_desarrollada='".$_REQUEST["actividad"]."',codigoestado=100,numero_horas_semana=".$_REQUEST["horas"]." where ".$campo."=".$_REQUEST["id"];
		}
		if(!$db->exec($cadena))
			$sucess=false;
		if($success)
			echo "<script>alert('¡¡ La información se ha actualizado correctamente. !!');location.href='?opc=".$_REQUEST["opc"]."&acc=list';</script>";
		else
			echo "<script>alert('¡¡ Ocurrio un error al actualizar la información. !!');location.href='?opc=".$_REQUEST["opc"]."&acc=list';</script>";
	} 
} 
if ($_REQUEST["opc"]=="fafddi") {
	if ($_REQUEST["acc"]=="new") {
		$cadena="insert into nivelacademicodocente (iddocente,idnucleobasicoareaconocimiento,codigotiponivelacademico,fechafinalnivelacademicodocente,idpais,codigoestado,titulonivelacademicodocente,codigotipofinanciacion,codigotipocapacitacion,codigotipoformacion,institucionnivelacademicodocente,encursonivelacademicodocente) values (".$_SESSION["sissic_iddocente"].",".$_REQUEST["idnucleobasicoareaconocimiento"].",'".$_REQUEST["codigotiponivelacademico"]."','".$_REQUEST["fechafinalnivelacademicodocente"]."',".$_REQUEST["idpais"].",100,'".$_REQUEST["titulonivelacademicodocente"]."','".$_REQUEST["codigotipofinanciacion"]."','".$_REQUEST["codigotipocapacitacion"]."',".$_REQUEST["tf"].",'".$_REQUEST["institucionnivelacademicodocente"]."'";
		if($_REQUEST["codigotiponivelacademico"]==101 || $_REQUEST["codigotiponivelacademico"]==102 || $_REQUEST["codigotiponivelacademico"]==103 || $_REQUEST["codigotiponivelacademico"]==104 || $_REQUEST["codigotiponivelacademico"]==105 || $_REQUEST["codigotiponivelacademico"]==106 || $_REQUEST["codigotiponivelacademico"]==107 || $_REQUEST["codigotiponivelacademico"]==108)
			$cadena.=",".$_REQUEST["encursonivelacademicodocente"];
		else
			$cadena.=",NULL";
		$cadena.=")";
		if(!$db->exec($cadena))
			$sucess=false;
		if($success)
			echo "<script>alert('¡¡ La información se ha ingresado correctamente. !!');location.href='?opc=".$_REQUEST["opc"]."&acc=list&tf=".$_REQUEST["tf"]."';</script>";
		else
			echo "<script>alert('¡¡ Ocurrio un error al ingresar la información. !!');location.href='?opc=".$_REQUEST["opc"]."&acc=list&tf=".$_REQUEST["tf"]."';</script>";
	} 
	if ($_REQUEST["acc"]=="edit") {
		$cadena="update nivelacademicodocente set iddocente=".$_SESSION["sissic_iddocente"].",idnucleobasicoareaconocimiento=".$_REQUEST["idnucleobasicoareaconocimiento"].",codigotiponivelacademico='".$_REQUEST["codigotiponivelacademico"]."',fechafinalnivelacademicodocente='".$_REQUEST["fechafinalnivelacademicodocente"]."',idpais=".$_REQUEST["idpais"].",codigoestado=100,titulonivelacademicodocente='".$_REQUEST["titulonivelacademicodocente"]."',codigotipofinanciacion='".$_REQUEST["codigotipofinanciacion"]."',codigotipocapacitacion='".$_REQUEST["codigotipocapacitacion"]."',codigotipoformacion=".$_REQUEST["tf"].",institucionnivelacademicodocente='".$_REQUEST["institucionnivelacademicodocente"]."'";
		if($_REQUEST["codigotiponivelacademico"]==101 || $_REQUEST["codigotiponivelacademico"]==102 || $_REQUEST["codigotiponivelacademico"]==103 || $_REQUEST["codigotiponivelacademico"]==104 || $_REQUEST["codigotiponivelacademico"]==105 || $_REQUEST["codigotiponivelacademico"]==106 || $_REQUEST["codigotiponivelacademico"]==107 || $_REQUEST["codigotiponivelacademico"]==108)
			$cadena.=",encursonivelacademicodocente=".$_REQUEST["encursonivelacademicodocente"];
		else
			$cadena.=",encursonivelacademicodocente=NULL";
		$cadena.=" where idnivelacademicodocente=".$_REQUEST["id"];
		if(!$db->exec($cadena))
			$sucess=false;
		if($success)
			echo "<script>alert('¡¡ La información se ha actualizado correctamente. !!');location.href='?opc=".$_REQUEST["opc"]."&acc=list&tf=".$_REQUEST["tf"]."';</script>";
		else
			echo "<script>alert('¡¡ Ocurrio un error al actualizar la información. !!');location.href='?opc=".$_REQUEST["opc"]."&acc=list&tf=".$_REQUEST["tf"]."';</script>";
	} 
}
if ($_REQUEST["opc"]=="fafgi") {
	//print_r($_REQUEST);
	if ($_REQUEST["acc"]=="new") {
		//$cadena="insert into idiomadocente (ididioma,iddocente,codigoestado) values (".$_REQUEST["ididioma"].",".$_SESSION["sissic_iddocente"].",'100')";
		$db->exec("insert into idiomadocente (ididioma,iddocente,codigoestado) values (".$_REQUEST["ididioma"].",".$_SESSION["sissic_iddocente"].",'100')");
		$ididiomadocenteInsert=mysql_insert_id();
		foreach ($_REQUEST["idindicadornivelidioma"] as $clave => $valor) {
			//$cadena3="insert into detalleidiomadocente (ididiomadocente,idtipomanejoidioma,idindicadornivelidioma,codigoestado) values (".$_REQUEST["id"].",".$clave.",'".$valor."','100')";
			$db->exec("insert into detalleidiomadocente (ididiomadocente,idtipomanejoidioma,idindicadornivelidioma,codigoestado) values (".$ididiomadocenteInsert.",".$clave.",'".$valor."',100)");
			//echo $cadena3."<br>";
		}
		echo "<script>alert('¡¡ La información se ha ingresado correctamente. !!');location.href='?opc=".$_REQUEST["opc"]."&acc=list';</script>";
	} 
	if ($_REQUEST["acc"]=="edit") {
		//$cadena="update idiomadocente set ididioma=".$_REQUEST["ididioma"].",iddocente=".$_SESSION["sissic_iddocente"].",codigoestado='100' where ididiomadocente=".$_REQUEST["id"];
		$db->exec("update idiomadocente set ididioma=".$_REQUEST["ididioma"].",iddocente=".$_SESSION["sissic_iddocente"].",codigoestado='100' where ididiomadocente=".$_REQUEST["id"]);
		//echo $cadena."<br>";
		//$cadena2="delete from detalleidiomadocente where ididiomadocente=".$_REQUEST["id"];
		$db->exec("delete from detalleidiomadocente where ididiomadocente=".$_REQUEST["id"]);
		//echo $cadena2."<br><br>";
		foreach ($_REQUEST["idindicadornivelidioma"] as $clave => $valor) {
			//$cadena3="insert into detalleidiomadocente (ididiomadocente,idtipomanejoidioma,idindicadornivelidioma,codigoestado) values (".$_REQUEST["id"].",".$clave.",'".$valor."','100')";
			$db->exec("insert into detalleidiomadocente (ididiomadocente,idtipomanejoidioma,idindicadornivelidioma,codigoestado) values (".$_REQUEST["id"].",".$clave.",'".$valor."',100)");
			//echo $cadena3."<br>";
		}
		echo "<script>alert('¡¡ La información se ha actualizado correctamente. !!');location.href='?opc=".$_REQUEST["opc"]."&acc=list';</script>";
	} 
} 
if ($_REQUEST["opc"]=="fafgmt") {
	$cadena="delete from tecnologiainformaciondocente where iddocente=".$_SESSION["sissic_iddocente"];
	$db->exec($cadena);
	foreach($_REQUEST["seleccion"] as $vlr) {
		$cadena="insert into tecnologiainformaciondocente (iddocente,codigotipotecnologiainformacion,codigoestado) values (".$_SESSION["sissic_iddocente"].",".$vlr.",100)";
		if(!$db->exec($cadena))
			$sucess=false;
	}
	if($success)
		echo "<script>alert('¡¡ La información se ha ingresado correctamente. !!');location.href='?opc=".$_REQUEST["opc"]."';</script>";
	else
		echo "<script>alert('¡¡ Ocurrio un error al ingresar la información. !!');location.href='?opc=".$_REQUEST["opc"]."';</script>";
}
if ($_REQUEST["opc"]=="el") {
	if ($_REQUEST["acc"]=="new") {
		if($_REQUEST["tipoexperiencia"]==100)
			$cadena="insert into experiencialaboraldocente (iddetallenucleobasicoareaconocimiento,idprofesion,nombreinstitucionexperiencialaboraldocente,fechainicioexperiencialaboraldocente,fechafinalexperiencialaboraldocente,horadedicacionexperiencialaboraldocente,iddocente,codigotipoexperiencialaboraldocente,codigoestado) values (".$_REQUEST["areaconocimiento"].",620,'".$_REQUEST["nombreinstitucionexperiencialaboraldocente"]."','".$_REQUEST["fechainicioexperiencialaboraldocente"]."','".$_REQUEST["fechafinalexperiencialaboraldocente"]."',".$_REQUEST["horadedicacionexperiencialaboraldocente"].",".$_SESSION["sissic_iddocente"].",'".$_REQUEST["tipoexperiencia"]."','100')";
		if($_REQUEST["tipoexperiencia"]==200)
			$cadena="insert into experiencialaboraldocente (cargoexperiencialaboraldocente,tipocontratoexperiencialaboraldocente,idprofesion,nombreinstitucionexperiencialaboraldocente,fechainicioexperiencialaboraldocente,fechafinalexperiencialaboraldocente,horadedicacionexperiencialaboraldocente,iddocente,codigotipoexperiencialaboraldocente,codigoestado) values ('".$_REQUEST["cargoexperiencialaboraldocente"]."','".$_REQUEST["tipocontratoexperiencialaboraldocente"]."',".$_REQUEST["actividadlaboral"].",'".$_REQUEST["nombreinstitucionexperiencialaboraldocente"]."','".$_REQUEST["fechainicioexperiencialaboraldocente"]."','".$_REQUEST["fechafinalexperiencialaboraldocente"]."',".$_REQUEST["horadedicacionexperiencialaboraldocente"].",".$_SESSION["sissic_iddocente"].",'".$_REQUEST["tipoexperiencia"]."','100')";
		if(!$db->exec($cadena))
			$sucess=false;
		if($success)
			echo "<script>alert('¡¡ La información se ha ingresado correctamente. !!');location.href='?opc=".$_REQUEST["opc"]."&acc=list';</script>";
		else
			echo "<script>alert('¡¡ Ocurrio un error al ingresar la información. !!');location.href='?opc=".$_REQUEST["opc"]."&acc=list';</script>";
	} 
	if ($_REQUEST["acc"]=="edit") {
		if($_REQUEST["tipoexperiencia"]==100)
			$cadena="update experiencialaboraldocente set iddetallenucleobasicoareaconocimiento=".$_REQUEST["areaconocimiento"].",idprofesion=620,nombreinstitucionexperiencialaboraldocente='".$_REQUEST["nombreinstitucionexperiencialaboraldocente"]."',fechainicioexperiencialaboraldocente='".$_REQUEST["fechainicioexperiencialaboraldocente"]."',fechafinalexperiencialaboraldocente='".$_REQUEST["fechafinalexperiencialaboraldocente"]."',horadedicacionexperiencialaboraldocente=".$_REQUEST["horadedicacionexperiencialaboraldocente"].",iddocente=".$_SESSION["sissic_iddocente"].",codigotipoexperiencialaboraldocente='".$_REQUEST["tipoexperiencia"]."',codigoestado=100 where idexperiencialaboraldocente=".$_REQUEST["id"];
		if($_REQUEST["tipoexperiencia"]==200)
			$cadena="update experiencialaboraldocente set cargoexperiencialaboraldocente='".$_REQUEST["cargoexperiencialaboraldocente"]."',tipocontratoexperiencialaboraldocente='".$_REQUEST["tipocontratoexperiencialaboraldocente"]."',idprofesion=".$_REQUEST["actividadlaboral"].",nombreinstitucionexperiencialaboraldocente='".$_REQUEST["nombreinstitucionexperiencialaboraldocente"]."',fechainicioexperiencialaboraldocente='".$_REQUEST["fechainicioexperiencialaboraldocente"]."',fechafinalexperiencialaboraldocente='".$_REQUEST["fechafinalexperiencialaboraldocente"]."',horadedicacionexperiencialaboraldocente=".$_REQUEST["horadedicacionexperiencialaboraldocente"].",iddocente=".$_SESSION["sissic_iddocente"].",codigotipoexperiencialaboraldocente='".$_REQUEST["tipoexperiencia"]."',codigoestado=100 where idexperiencialaboraldocente=".$_REQUEST["id"];
		if(!$db->exec($cadena))
			$sucess=false;
		if($success)
			echo "<script>alert('¡¡ La información se ha actualizado correctamente. !!');location.href='?opc=".$_REQUEST["opc"]."&acc=list';</script>";
		else
			echo "<script>alert('¡¡ Ocurrio un error al actualizar la información. !!');location.href='?opc=".$_REQUEST["opc"]."&acc=list';</script>";
	} 
} 
if ($_REQUEST["opc"]=="pa") {
	if ($_REQUEST["acc"]=="new") {
		$cadena="insert into produccionintelectualdocente (iddocente,nombreproduccionintelectualdocente,tituloproduccionintelectualdocente,fechapublicacionproduccionintelectualdocente,esindexadaproduccionintelectualdocente,numeroproduccionintelectualdocente,codigotipoproduccionintelectual,codigoestado) values (".$_SESSION["sissic_iddocente"];
		if($_REQUEST["tipoproduccion"]=='100' || $_REQUEST["tipoproduccion"]=='101')
			$cadena.=",'".$_REQUEST["nombrerevista"]."','".$_REQUEST["tituloarticulo"]."','".$_REQUEST["fechapublicacion"]."',".$_REQUEST["revistaindexada"].",'".$_REQUEST["issn"]."'";
		if($_REQUEST["tipoproduccion"]=='200')
			$cadena.=",'".$_REQUEST["nombrelibro"]."','','".$_REQUEST["fechapublicacion"]."',NULL,'".$_REQUEST["isbn"]."'";
		if($_REQUEST["tipoproduccion"]=='201')
			$cadena.=",'".$_REQUEST["nombrelibro"]."','".$_REQUEST["nombrecapitulo"]."','".$_REQUEST["fechapublicacion"]."',NULL,'".$_REQUEST["isbn"]."'";
		if($_REQUEST["tipoproduccion"]=='300')
			$cadena.=",'".$_REQUEST["nombreponencia"]."','".$_REQUEST["mediopublicacion"]."','".$_REQUEST["fechapublicacion"]."',NULL,NULL";
		if($_REQUEST["tipoproduccion"]=='400')
			$cadena.=",'".$_REQUEST["nombreproductoartistico"]."','".$_REQUEST["tituloespecifico"]."','".$_REQUEST["fechapublicacion"]."',NULL,'".$_REQUEST["numeroidentificacionproductoartistico"]."'";
		if($_REQUEST["tipoproduccion"]=='401')
			$cadena.=",'".$_REQUEST["nombreproductoartisticomusical"]."','".$_REQUEST["tituloespecifico"]."','".$_REQUEST["fechapublicacion"]."',NULL,'".$_REQUEST["numeroidentificacionproductoartisticomusical"]."'";
		if($_REQUEST["tipoproduccion"]=='402')
			$cadena.=",'".$_REQUEST["nombreresena"]."','".$_REQUEST["tituloespecifico"]."','".$_REQUEST["fechapublicacion"]."',NULL,'".$_REQUEST["numeroidentificacionresena"]."'";
		if($_REQUEST["tipoproduccion"]=='500')
			$cadena.=",'".$_REQUEST["nombreproyecto"]."','".$_REQUEST["tituloespecifico"]."','".$_REQUEST["fechapublicacion"]."',NULL,'".$_REQUEST["numeroidentificacionproyecto"]."'";
		if($_REQUEST["tipoproduccion"]=='600')
			$cadena.=",'".$_REQUEST["nombrematerial"]."','','',NULL,NULL";
		$cadena.=",'".$_REQUEST["tipoproduccion"]."',100)";
		//echo $cadena;exit;
		if(!$db->exec($cadena))
			$sucess=false;
		if($success)
			echo "<script>alert('¡¡ La información se ha ingresado correctamente. !!');location.href='?opc=".$_REQUEST["opc"]."&acc=list';</script>";
		else
			echo "<script>alert('¡¡ Ocurrio un error al ingresar la información. !!');location.href='?opc=".$_REQUEST["opc"]."&acc=list';</script>";
		//print_r($_REQUEST);
	}
	if ($_REQUEST["acc"]=="edit") {
		$cadena="update produccionintelectualdocente set iddocente=".$_SESSION["sissic_iddocente"];
		if($_REQUEST["tipoproduccion"]=='100' || $_REQUEST["tipoproduccion"]=='101')
			$cadena.=",nombreproduccionintelectualdocente='".$_REQUEST["nombrerevista"]."',tituloproduccionintelectualdocente='".$_REQUEST["tituloarticulo"]."',fechapublicacionproduccionintelectualdocente='".$_REQUEST["fechapublicacion"]."',esindexadaproduccionintelectualdocente=".$_REQUEST["revistaindexada"].",numeroproduccionintelectualdocente='".$_REQUEST["issn"]."'";
		if($_REQUEST["tipoproduccion"]=='200')
			$cadena.=",nombreproduccionintelectualdocente='".$_REQUEST["nombrelibro"]."',tituloproduccionintelectualdocente='',fechapublicacionproduccionintelectualdocente='".$_REQUEST["fechapublicacion"]."',esindexadaproduccionintelectualdocente=NULL,numeroproduccionintelectualdocente='".$_REQUEST["isbn"]."'";
		if($_REQUEST["tipoproduccion"]=='201')
			$cadena.=",nombreproduccionintelectualdocente='".$_REQUEST["nombrelibro"]."',tituloproduccionintelectualdocente='".$_REQUEST["nombrecapitulo"]."',fechapublicacionproduccionintelectualdocente='".$_REQUEST["fechapublicacion"]."',esindexadaproduccionintelectualdocente=NULL,numeroproduccionintelectualdocente='".$_REQUEST["isbn"]."'";
		if($_REQUEST["tipoproduccion"]=='300')
			$cadena.=",nombreproduccionintelectualdocente='".$_REQUEST["nombreponencia"]."',tituloproduccionintelectualdocente='".$_REQUEST["mediopublicacion"]."',fechapublicacionproduccionintelectualdocente='".$_REQUEST["fechapublicacion"]."',esindexadaproduccionintelectualdocente=NULL,numeroproduccionintelectualdocente=NULL";
		if($_REQUEST["tipoproduccion"]=='400')
			$cadena.=",nombreproduccionintelectualdocente='".$_REQUEST["nombreproductoartistico"]."',tituloproduccionintelectualdocente='".$_REQUEST["tituloespecifico"]."',fechapublicacionproduccionintelectualdocente='".$_REQUEST["fechapublicacion"]."',esindexadaproduccionintelectualdocente=NULL,numeroproduccionintelectualdocente='".$_REQUEST["numeroidentificacionproductoartistico"]."'";
		if($_REQUEST["tipoproduccion"]=='401')
			$cadena.=",nombreproduccionintelectualdocente='".$_REQUEST["nombreproductoartisticomusical"]."',tituloproduccionintelectualdocente='".$_REQUEST["tituloespecifico"]."',fechapublicacionproduccionintelectualdocente='".$_REQUEST["fechapublicacion"]."',esindexadaproduccionintelectualdocente=NULL,numeroproduccionintelectualdocente='".$_REQUEST["numeroidentificacionproductoartisticomusical"]."'";
		if($_REQUEST["tipoproduccion"]=='402')
			$cadena.=",nombreproduccionintelectualdocente='".$_REQUEST["nombreresena"]."',tituloproduccionintelectualdocente='".$_REQUEST["tituloespecifico"]."',fechapublicacionproduccionintelectualdocente='".$_REQUEST["fechapublicacion"]."',esindexadaproduccionintelectualdocente=NULL,numeroproduccionintelectualdocente='".$_REQUEST["numeroidentificacionresena"]."'";
		if($_REQUEST["tipoproduccion"]=='500')
			$cadena.=",nombreproduccionintelectualdocente='".$_REQUEST["nombreproyecto"]."',tituloproduccionintelectualdocente='".$_REQUEST["tituloespecifico"]."',fechapublicacionproduccionintelectualdocente='".$_REQUEST["fechapublicacion"]."',esindexadaproduccionintelectualdocente=NULL,numeroproduccionintelectualdocente='".$_REQUEST["numeroidentificacionproyecto"]."'";
		if($_REQUEST["tipoproduccion"]=='600')
			$cadena.=",nombreproduccionintelectualdocente='".$_REQUEST["nombrematerial"]."',tituloproduccionintelectualdocente='',fechapublicacionproduccionintelectualdocente='',esindexadaproduccionintelectualdocente=NULL,numeroproduccionintelectualdocente=NULL";
		$cadena.=",codigotipoproduccionintelectual='".$_REQUEST["tipoproduccion"]."',codigoestado=100";
		$cadena.=" where idproduccionintelectualdocente=".$_REQUEST["id"];
		if(!$db->exec($cadena))
			$sucess=false;
		if($success)
			echo "<script>alert('¡¡ La información se ha actualizado correctamente. !!');location.href='?opc=".$_REQUEST["opc"]."&acc=list';</script>";
		else
			echo "<script>alert('¡¡ Ocurrio un error al actualizar la información. !!');location.href='?opc=".$_REQUEST["opc"]."&acc=list';</script>";
	}
}
if ($_REQUEST["opc"]=="e") {
	if ($_REQUEST["acc"]=="new") {
		$cadena="insert into estimulodocente (iddocente,tituloestimulodocente,entidadestimulodocente,fechaestimulodocente,idpaisestimulodocente,iddepartamentoestimulodocente,idciudadestimulodocente,codigotipoparticipacionestimulodocente,codigotipoestimulodocente,codigoestado) values (".$_SESSION["sissic_iddocente"];
		if($_REQUEST["tipoestimulo"]=='100')
			$cadena.=",'".$_REQUEST["nombreprograma"]."','".$_REQUEST["institucionentidad"]."','".$_REQUEST["fechaparticipacion"]."',1,216,2000,400";
		if($_REQUEST["tipoestimulo"]=='201' || $_REQUEST["tipoestimulo"]=='202' || $_REQUEST["tipoestimulo"]=='203')
			$cadena.=",'".$_REQUEST["nombreevento"]."','".$_REQUEST["institucionentidad"]."','".$_REQUEST["fechaparticipacion"]."',".$_REQUEST["idpaisestimulodocente"].",".$_REQUEST["iddepartamentoestimulodocente"].",".$_REQUEST["idciudadestimulodocente"].",'".$_REQUEST["tipoparticipacion"]."'";
		if($_REQUEST["tipoestimulo"]=='300')
			$cadena.=",'".$_REQUEST["tituloestimulo"]."','".$_REQUEST["institucionentidad"]."','".$_REQUEST["fechaparticipacion"]."',".$_REQUEST["idpaisestimulodocente"].",".$_REQUEST["iddepartamentoestimulodocente"].",".$_REQUEST["idciudadestimulodocente"].",'".$_REQUEST["tipoparticipacion"]."'";
		$cadena.=",'".$_REQUEST["tipoestimulo"]."',100)";
		if(!$db->exec($cadena))
			$sucess=false;
		if($success)
			echo "<script>alert('¡¡ La información se ha ingresado correctamente. !!');location.href='?opc=".$_REQUEST["opc"]."&acc=list';</script>";
		else
			echo "<script>alert('¡¡ Ocurrio un error al ingresar la información. !!');location.href='?opc=".$_REQUEST["opc"]."&acc=list';</script>";
	}
	if ($_REQUEST["acc"]=="edit") {
		$cadena="update estimulodocente set iddocente=".$_SESSION["sissic_iddocente"];
		if($_REQUEST["tipoestimulo"]=='100')
			$cadena.=",tituloestimulodocente='".$_REQUEST["nombreprograma"]."',entidadestimulodocente='".$_REQUEST["institucionentidad"]."',fechaestimulodocente='".$_REQUEST["fechaparticipacion"]."',idpaisestimulodocente=1,iddepartamentoestimulodocente=216,idciudadestimulodocente=2000,codigotipoparticipacionestimulodocente=400";
		if($_REQUEST["tipoestimulo"]=='201' || $_REQUEST["tipoestimulo"]=='202' || $_REQUEST["tipoestimulo"]=='203')
			$cadena.=",tituloestimulodocente='".$_REQUEST["nombreevento"]."',entidadestimulodocente='".$_REQUEST["institucionentidad"]."',fechaestimulodocente='".$_REQUEST["fechaparticipacion"]."',idpaisestimulodocente=".$_REQUEST["idpaisestimulodocente"].",iddepartamentoestimulodocente=".$_REQUEST["iddepartamentoestimulodocente"].",idciudadestimulodocente=".$_REQUEST["idciudadestimulodocente"].",codigotipoparticipacionestimulodocente='".$_REQUEST["tipoparticipacion"]."'";
		if($_REQUEST["tipoestimulo"]=='300')
			$cadena.=",tituloestimulodocente='".$_REQUEST["tituloestimulo"]."',entidadestimulodocente='".$_REQUEST["institucionentidad"]."',fechaestimulodocente='".$_REQUEST["fechaparticipacion"]."',idpaisestimulodocente=".$_REQUEST["idpaisestimulodocente"].",iddepartamentoestimulodocente=".$_REQUEST["iddepartamentoestimulodocente"].",idciudadestimulodocente=".$_REQUEST["idciudadestimulodocente"].",codigotipoparticipacionestimulodocente='".$_REQUEST["tipoparticipacion"]."'";
		$cadena.=",codigotipoestimulodocente='".$_REQUEST["tipoestimulo"]."',codigoestado=100";
		$cadena.=" where idestimulodocente=".$_REQUEST["id"];
		if(!$db->exec($cadena))
			$sucess=false;
		if($success)
			echo "<script>alert('¡¡ La información se ha actualizado correctamente. !!');location.href='?opc=".$_REQUEST["opc"]."&acc=list';</script>";
		else
			echo "<script>alert('¡¡ Ocurrio un error al actualizar la información. !!');location.href='?opc=".$_REQUEST["opc"]."&acc=list';</script>";
	}
}
if ($_REQUEST["opc"]=="r") {
	if ($_REQUEST["acc"]=="new") {
		$cadena="insert into reconocimientodocente (iddocente,tiporeconocimientodocente,otorgareconocimientodocente,idpaisreconocimientodocente,iddepartamentoreconocimientodocente,idciudadreconocimientodocente,fechareconocimientodocente,codigoestado) values (".$_SESSION["sissic_iddocente"].",'".$_REQUEST["tiporeconocimientodocente"]."','".$_REQUEST["otorgareconocimientodocente"]."',".$_REQUEST["idpaisreconocimientodocente"].",".$_REQUEST["iddepartamentoreconocimientodocente"].",".$_REQUEST["idciudadreconocimientodocente"].",'".$_REQUEST["fechareconocimientodocente"]."',100)";
		if(!$db->exec($cadena))
			$sucess=false;
		if($success)
			echo "<script>alert('¡¡ La información se ha ingresado correctamente. !!');location.href='?opc=".$_REQUEST["opc"]."&acc=list';</script>";
		else
			echo "<script>alert('¡¡ Ocurrio un error al ingresar la información. !!');location.href='?opc=".$_REQUEST["opc"]."&acc=list';</script>";
	} 
	if ($_REQUEST["acc"]=="edit") {
		$cadena="update reconocimientodocente set iddocente=".$_SESSION["sissic_iddocente"].",tiporeconocimientodocente='".$_REQUEST["tiporeconocimientodocente"]."',otorgareconocimientodocente='".$_REQUEST["otorgareconocimientodocente"]."',idpaisreconocimientodocente=".$_REQUEST["idpaisreconocimientodocente"].",iddepartamentoreconocimientodocente=".$_REQUEST["iddepartamentoreconocimientodocente"].",idciudadreconocimientodocente=".$_REQUEST["idciudadreconocimientodocente"].",fechareconocimientodocente='".$_REQUEST["fechareconocimientodocente"]."',codigoestado=100 where idreconocimientodocente=".$_REQUEST["id"];
		if(!$db->exec($cadena))
			$sucess=false;
		if($success)
			echo "<script>alert('¡¡ La información se ha actualizado correctamente. !!');location.href='?opc=".$_REQUEST["opc"]."&acc=list';</script>";
		else
			echo "<script>alert('¡¡ Ocurrio un error al actualizar la información. !!');location.href='?opc=".$_REQUEST["opc"]."&acc=list';</script>";
	}
}
if ($_REQUEST["opc"]=="ga") {
	if ($_REQUEST["acc"]=="new") {
		$cadena="insert into asociaciondocente (iddocente,nombreasociaciondocente,codigotipoasociaciondocente,fechaingresoasociaciondocente,fechaterminacionasociaciondocente,codigoestado) values (".$_SESSION["sissic_iddocente"].",'".$_REQUEST["nombreasociaciondocente"]."','".$_REQUEST["codigotipoasociaciondocente"]."','".$_REQUEST["fechaingresoasociaciondocente"]."','".$_REQUEST["fechaterminacionasociaciondocente"]."','100')";
		if(!$db->exec($cadena))
			$sucess=false;
		if($success)
			echo "<script>alert('¡¡ La información se ha ingresado correctamente. !!');location.href='?opc=".$_REQUEST["opc"]."&acc=list';</script>";
		else
			echo "<script>alert('¡¡ Ocurrio un error al ingresar la información. !!');location.href='?opc=".$_REQUEST["opc"]."&acc=list';</script>";
	} 
	if ($_REQUEST["acc"]=="edit") {
		$cadena="update asociaciondocente set iddocente=".$_SESSION["sissic_iddocente"].",nombreasociaciondocente='".$_REQUEST["nombreasociaciondocente"]."',codigotipoasociaciondocente='".$_REQUEST["codigotipoasociaciondocente"]."',fechaingresoasociaciondocente='".$_REQUEST["fechaingresoasociaciondocente"]."',fechaterminacionasociaciondocente='".$_REQUEST["fechaterminacionasociaciondocente"]."',codigoestado='100' where idasociaciondocente=".$_REQUEST["id"];
		if(!$db->exec($cadena))
			$sucess=false;
		if($success)
			echo "<script>alert('¡¡ La información se ha actualizado correctamente. !!');location.href='?opc=".$_REQUEST["opc"]."&acc=list';</script>";
		else
			echo "<script>alert('¡¡ Ocurrio un error al actualizar la información. !!');location.href='?opc=".$_REQUEST["opc"]."&acc=list';</script>";
	} 
}
?>
