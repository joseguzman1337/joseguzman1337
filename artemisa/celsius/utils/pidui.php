<script language="JavaScript" type="text/javascript">
<?
require_once "../utils/StringUtils.php";

/**
 * @param array $mostrar_elemento contiene cuales son los combos q se deben cargar
 * @param array ConditionsInstituciones? Contiene condiciones para filtrar las instituciones q se van a mostrar 
 */

if (empty($mostrar_elemento)){
	$mostrar_elemento = array("instituciones","dependencias","unidades","instancias_celsius");
} 
$servicesFacade = ServicesFacade::getInstance();
$paises = $servicesFacade->getPaises();
if (array_search("instituciones",$mostrar_elemento) !== FALSE ){
	if (empty($conditionsInstituciones))
		$conditionsInstituciones = array();
	
	$instituciones = $servicesFacade->getInstituciones($conditionsInstituciones);
	if (array_search("dependencias",$mostrar_elemento) !== FALSE ){
		$dependencias = $servicesFacade->getDependencias();
		if (array_search("unidades",$mostrar_elemento)!== FALSE ){
			$unidades = $servicesFacade->getUnidades();
			if (array_search("instancias_celsius",$mostrar_elemento)!== FALSE ){
				$instancias_celsius = $servicesFacade->getInstancias_Celsius();
			}
		}
	}
}

if (array_search("localidades",$mostrar_elemento)!== FALSE ){
	$localidades= $servicesFacade->getLocalidades();
}
?>
/*
	Se debe cargar el vector listNames e indicar los nombres de las listas
*/

	//Nombre por default de las listas del pidu
	listNames = new Array();
	listNames[0] = new Array();
	listNames[0]["paises"]="paises";
	listNames[0]["instituciones"]="instituciones";
	listNames[0]["dependencias"]="dependencias";
	listNames[0]["unidades"]="unidades";
	listNames[0]["instancias_celsius"]="id_instancia_celsius";
	listNames[0]["localidades"]="localidades";

	function getObjectByName(name){
		var items = document.getElementsByName(name);
		if (!items)
			return null;
		else
			return items.item(0);
	}
	
	function getList(listName, groupNumber){
		if (!groupNumber)
			groupNumber = 0;
		return listNames[groupNumber][listName];
	}
	
	//-------------------------------------------------------------------
	////////////////////////////////////////////////////////////////////
	///////////////////////////////Paises///////////////////////////////
	////////////////////////////////////////////////////////////////////
	
	tabla_paises = new Array;
	tabla_val_paises = new Array;
	
	<?
	//Imprime los arreglos de paises
	$cantidadPaises=count($paises);
	echo "cantidadPaises=$cantidadPaises;\n";
	for ($i=0; $i < $cantidadPaises; $i++){
		$pais = $paises[$i];
		echo "tabla_paises[".$i."]='".StringUtils::getSafeString($pais["Nombre"])."';\n";
		echo "tabla_val_paises[".$i."]=".$pais["Id"].";\n";
	}
	?>
	
	function generar_paises (idPaisSeleccionado, groupNumber){     
	    
		var paisesListName = getList("paises",groupNumber);
		var paises=getObjectByName(paisesListName);
		
		var seleccion=0;
		paises.length= cantidadPaises;
		
		for (i=0;i < cantidadPaises;i++){
			
			paises.options[i].text=tabla_paises [i];
			paises.options[i].value=tabla_val_paises [i];
	
			if (tabla_val_paises[i]==idPaisSeleccionado){
				seleccion = i;
			}
		}
		
		if (idPaisSeleccionado == 0)
			seleccion=paises.options.length;
	
		paises.options[paises.options.length] = new Option('NINGUNO',0);
		paises.selectedIndex=seleccion;
		
		if(self.generar_instituciones != null)
			generar_instituciones(0)
	}
	
	//------------------------------------------------------------------------
<?
if (isset($instituciones)){
?>
	////////////////////////////////////////////////////////////////////
	/////////////////////////// Instituciones //////////////////////////
	////////////////////////////////////////////////////////////////////
	
	tabla_instituciones = new Array;
	tabla_val_instit = new Array;
	tabla_long_instit = new Array; 
	<?
	//imprime los arreglos de instituciones
	$cantidadInstituciones=count($instituciones);
	$indicesInstituciones = array();
	for ($i=0; $i < $cantidadInstituciones; $i++){
		$institucion = $instituciones[$i];
		$idPais = $institucion["Codigo_Pais"];
		if (!isset($indicesInstituciones[$idPais])){
			$indicesInstituciones[$idPais]=0;
			echo "\n";
			echo "tabla_instituciones[".$idPais."]=new Array;\n";
			echo "tabla_val_instit[".$idPais."]=new Array;\n";            
		}
		echo "tabla_instituciones[".$idPais."][".$indicesInstituciones[$idPais]."]='".StringUtils::getSafeString($institucion["Nombre"])."';\n";
		echo "tabla_val_instit[".$idPais."][".$indicesInstituciones[$idPais]."]=".$institucion["Codigo"].";\n";

		$indicesInstituciones[$idPais]++;
	}
	
	//Reflejo las longitudes de los vectores
	while (list($key,$valor)=each($indicesInstituciones)){	
		echo "tabla_long_instit[".$key."]=".$valor.";\n";
	}
	?>
	
	function generar_instituciones(institucionSeleccionada, groupNumber){     
		var paisesListName = getList("paises",groupNumber);
		var paises=getObjectByName(paisesListName);
		
		var institucionesListName = getList("instituciones",groupNumber);
		var instituciones=getObjectByName(institucionesListName);
		
		var idPaisSeleccionado=paises.options[paises.selectedIndex].value;
		
		var cantidadInstituciones = 0;
		if (tabla_long_instit[idPaisSeleccionado]!=null)
			cantidadInstituciones = tabla_long_instit[idPaisSeleccionado];
		instituciones.length = cantidadInstituciones;
		
		var seleccion=0;
		for (i=0;i<cantidadInstituciones;i++){
			instituciones.options[i].text=tabla_instituciones[idPaisSeleccionado][i];
			instituciones.options[i].value=tabla_val_instit[idPaisSeleccionado][i];
			if (tabla_val_instit [idPaisSeleccionado][i]==institucionSeleccionada){
				seleccion= i;
			}
		}
		
		if (institucionSeleccionada == 0)
			seleccion=instituciones.options.length;
	
		instituciones.options[instituciones.options.length] = new Option('NINGUNO',0);
		instituciones.selectedIndex=seleccion;
	
		if(self.generar_dependencias != null)
			generar_dependencias(0);
	}
	//------------------------------------------------------------------------
<?
}
if (isset($dependencias)){
?>
	////////////////////////////////////////////////////////////////////
	//////////////////////////// Dependencias //////////////////////////
	////////////////////////////////////////////////////////////////////
	
	tabla_dependencias = new Array;
	tabla_val_dep = new Array;
	tabla_long_dep = new Array;
	
	<?
	//Imprime los arreglos de dependencias
	echo "\n";
	$cantidadDependencias=count($dependencias);
	$indicesDependencias = array();
	for ($i=0; $i < $cantidadDependencias; $i++){
		$dependencia = $dependencias[$i];
		$idInstitucion = $dependencia["Codigo_Institucion"];
		if (!isset($indicesDependencias[$idInstitucion])){
			$indicesDependencias[$idInstitucion]=0;
			echo "\n";
			echo "tabla_dependencias[".$idInstitucion."]=new Array;\n";
			echo "tabla_val_dep[".$idInstitucion."]=new Array;\n";            
		}
		echo "tabla_dependencias[".$idInstitucion."][".$indicesDependencias[$idInstitucion]."]='".StringUtils::getSafeString($dependencia["Nombre"])."';\n";
		echo "tabla_val_dep[".$idInstitucion."][".$indicesDependencias[$idInstitucion]."]=".$dependencia["Id"].";\n";

		$indicesDependencias[$idInstitucion]++;
	}
	
	//Reflejo las longitudes de los vectores
	while (list($key,$valor)=each($indicesDependencias)){	
		echo "tabla_long_dep[".$key."]=".$valor.";\n";
	}
	?>
	
	//------------------------------------------------------------------------

	function generar_dependencias (dependenciaSeleccionada, groupNumber){
		var institucionesListName = getList("instituciones",groupNumber);
		
		var instituciones=getObjectByName(institucionesListName);
		
		var idInstitucionSeleccionada=instituciones.options[instituciones.selectedIndex].value;
		
		var dependenciasListName = getList("dependencias",groupNumber);
		var dependencias=getObjectByName(dependenciasListName);
	
		var cantidadDependencias = 0;
		if (tabla_long_dep[idInstitucionSeleccionada]!=null)
			cantidadDependencias = tabla_long_dep[idInstitucionSeleccionada];
		dependencias.length=cantidadDependencias;
		
		var seleccion=0;
		for (i=0;i<cantidadDependencias;i++){             	
			dependencias.options[i].text=tabla_dependencias[idInstitucionSeleccionada][i];
			dependencias.options[i].value=tabla_val_dep [idInstitucionSeleccionada][i];
			if (tabla_val_dep [idInstitucionSeleccionada][i]==dependenciaSeleccionada){
				seleccion = i;
			}
		}
	
		if (dependenciaSeleccionada == 0)
			seleccion=dependencias.options.length;
	
		dependencias.options[dependencias.options.length] = new Option('NINGUNO',0);
		dependencias.selectedIndex=seleccion;
	
		if(self.generar_unidades != null)
			generar_unidades(0);
	}
	
	//------------------------------------------------------------------------
<?
}
if (isset($unidades)){
?>
	////////////////////////////////////////////////////////////////////
	/////////////////////////// Unidades ///////////////////////////////
	////////////////////////////////////////////////////////////////////
	
	tabla_unidades = new Array;
	tabla_val_unidad = new Array;
	tabla_long_unidad = new Array;
	
	<?
	//Imprime los arreglos de unidades
	echo "\n";
	$cantidadUnidades=count($unidades);
	$indicesUnidades= array();
	for ($i=0; $i < $cantidadUnidades; $i++){
		$unidad = $unidades[$i];
		$idDependencia = $unidad["Codigo_Dependencia"];
		if (!isset($indicesUnidades[$idDependencia])){
			$indicesUnidades[$idDependencia]=0;
			echo "\n";
			echo "tabla_unidades[".$idDependencia."]=new Array;\n";
			echo "tabla_val_unidad[".$idDependencia."]=new Array;\n";            
		}
		echo "tabla_unidades[".$idDependencia."][".$indicesUnidades[$idDependencia]."]='".StringUtils::getSafeString($unidad["Nombre"])."';\n";
		echo "tabla_val_unidad[".$idDependencia."][".$indicesUnidades[$idDependencia]."]=".$unidad["Id"].";\n";

		$indicesUnidades[$idDependencia]++;
	}
	
	//Reflejo las longitudes de los vectores
	while (list($key,$valor)=each($indicesUnidades)){	
		echo "tabla_long_unidad[".$key."]=".$valor.";\n";
	}
	
	?>
	//------------------------------------------------------------------------

	function generar_unidades(unidadSeleccionada, groupNumber){     
		var dependenciasListName = getList("dependencias",groupNumber);
		var dependencias=getObjectByName(dependenciasListName);
		
		var idDependenciaSeleccionada=dependencias.options[dependencias.selectedIndex].value;
		
		var unidadesListName = getList("unidades",groupNumber);
		var unidades=getObjectByName(unidadesListName);
	
		var cantidadUnidades=0;
		if (tabla_long_unidad[idDependenciaSeleccionada]!=null)
			cantidadUnidades=tabla_long_unidad[idDependenciaSeleccionada];
		unidades.length=cantidadUnidades;
		
		var seleccion=0;
		for (i=0;i<cantidadUnidades;i++){
			unidades.options[i] = new Option(tabla_unidades[idDependenciaSeleccionada][i], tabla_val_unidad [idDependenciaSeleccionada][i]);
			unidades.options[i].value = tabla_val_unidad [idDependenciaSeleccionada][i];
			if (tabla_val_unidad[idDependenciaSeleccionada][i]==unidadSeleccionada){     
				seleccion=i;
			}
		}
	
		if (unidadSeleccionada == 0)
			seleccion=unidades.options.length;
		unidades.options[unidades.options.length]=new Option('NINGUNO',0);
		unidades.selectedIndex=seleccion;
		
		if(self.generar_instancias_celsius != null)
			generar_instancias_celsius(0);
	}
	
	//------------------------------------------------------------------------
<?
}
//var_export($instancias_celsius);
if (isset($instancias_celsius)){
?>
	////////////////////////////////////////////////////////////////////
	///////////////////////// Instancias_Celsius ///////////////////////
	////////////////////////////////////////////////////////////////////
	
	tabla_instancias_unidad = new Array;
	tabla_val_instancias_unidad = new Array;
	tabla_long_instancias_unidad = new Array;
	
	tabla_instancias_dependencia = new Array;
	tabla_val_instancias_dependencia = new Array;
	tabla_long_instancias_dependencia = new Array;
	
	tabla_instancias_institucion = new Array;
	tabla_val_instancias_institucion = new Array;
	tabla_long_instancias_institucion = new Array;
	
	<?
	//Imprime los arreglos de instancias_celsius
	echo "\n";
	$cantidadInstancias=count($instancias_celsius);
	$indicesInstancias_unidad= array();
	$indicesInstancias_dependencia= array();
	$indicesInstancias_institucion= array();
	for ($i=0; $i < $cantidadInstancias; $i++){
		$instancia = $instancias_celsius[$i];
		
		//guarda las instancias q cuelgan de unidades
		$idUnidad = $instancia["id_unidad"];
		if ($idUnidad){
			if (!isset($indicesInstancias_unidad[$idUnidad])){
				$indicesInstancias_unidad[$idUnidad]=0;
				echo "\n";
				echo "tabla_instancias_unidad[".$idUnidad."]=new Array;\n";
				echo "tabla_val_instancias_unidad[".$idUnidad."]=new Array;\n";            
			}
			echo "tabla_instancias_unidad[".$idUnidad."][".$indicesInstancias_unidad[$idUnidad]."]='".$instancia["id"]."';\n";
			echo "tabla_val_instancias_unidad[".$idUnidad."][".$indicesInstancias_unidad[$idUnidad]."]='".$instancia["id"]."';\n";
			
			$indicesInstancias_unidad[$idUnidad]++;
		}
		
		//guarda las instancias q cuelgan de dependencias
		$idDependencia = $instancia["id_dependencia"];
		if ($idDependencia){
			if (!isset($indicesInstancias_dependencia[$idDependencia])){
				$indicesInstancias_dependencia[$idDependencia]=0;
				echo "\n";
				echo "tabla_instancias_dependencia[".$idDependencia."]=new Array;\n";
				echo "tabla_val_instancias_dependencia[".$idDependencia."]=new Array;\n";            
			}
			echo "tabla_instancias_dependencia[".$idDependencia."][".$indicesInstancias_dependencia[$idDependencia]."]='".$instancia["id"]."';\n";
			echo "tabla_val_instancias_dependencia[".$idDependencia."][".$indicesInstancias_dependencia[$idDependencia]."]='".$instancia["id"]."';\n";
			
			$indicesInstancias_dependencia[$idDependencia]++;
		}
		
		//guarda las instancias q cuelgan de instituciones
		$idInstitucion = $instancia["id_institucion"];
		if ($idInstitucion){
			if (!isset($indicesInstancias_institucion[$idInstitucion])){
				$indicesInstancias_institucion[$idInstitucion]=0;
				echo "\n";
				echo "tabla_instancias_institucion[".$idInstitucion."]=new Array;\n";
				echo "tabla_val_instancias_institucion[".$idInstitucion."]=new Array;\n";            
			}
			echo "tabla_instancias_institucion[".$idInstitucion."][".$indicesInstancias_institucion[$idInstitucion]."]='".$instancia["id"]."';\n";
			echo "tabla_val_instancias_institucion[".$idInstitucion."][".$indicesInstancias_institucion[$idInstitucion]."]='".$instancia["id"]."';\n";
			
			$indicesInstancias_institucion[$idInstitucion]++;
		}
	}
	
	//Reflejo las longitudes de los vectores
	while (list($key,$valor)=each($indicesInstancias_unidad)){	
		echo "tabla_long_instancias_unidad[".$key."]=".$valor.";\n";
	}
	while (list($key,$valor)=each($indicesInstancias_dependencia)){	
		echo "tabla_long_instancias_dependencia[".$key."]=".$valor.";\n";
	}
	while (list($key,$valor)=each($indicesInstancias_institucion)){	
		echo "tabla_long_instancias_institucion[".$key."]=".$valor.";\n";
	}
	?>
	
	//------------------------------------------------------------------------
	
	function generar_instancias_celsius(instanciaSeleccionada, groupNumber){
		var instanciasListName = getList("instancias_celsius",groupNumber);
		var instancias=getObjectByName(instanciasListName);
	
		var unidadesListName = getList("unidades",groupNumber);
		var unidades=getObjectByName(unidadesListName);
		
		/*alert("unidades.selectedIndex != (unidades.options.length - 1)="
		 + "(" + unidades.selectedIndex + " != (" + unidades.options.length + " - 1)=" +
		 (unidades.selectedIndex != (unidades.options.length - 1)));*/
		 
		if (unidades.selectedIndex != (unidades.options.length - 1)){
			generar_instancias_celsius_unidad(unidades,instancias,instanciaSeleccionada);
			return;
		}
		
		
		var dependenciasListName = getList("dependencias",groupNumber);
		var dependencias=getObjectByName(dependenciasListName);
		if (dependencias.selectedIndex != (dependencias.options.length - 1)){
			generar_instancias_celsius_dependencia(dependencias,instancias,instanciaSeleccionada);
			return;
		}
		
		var institucionesListName = getList("instituciones",groupNumber);
		var instituciones=getObjectByName(institucionesListName);
		
		generar_instancias_celsius_institucion(instituciones,instancias,instanciaSeleccionada);
		
	}
	
	function generar_instancias_celsius_unidad(unidades,instancias,instanciaSeleccionada){
		var seleccion=0;
	
		var idUnidadSeleccionada=unidades.options[unidades.selectedIndex].value;
			
		var cantidadInstancias=0;
		if (tabla_long_instancias_unidad[idUnidadSeleccionada]!=null)
			cantidadInstancias=tabla_long_instancias_unidad[idUnidadSeleccionada];
		instancias.length=cantidadInstancias;
		
		for (i=0;i<cantidadInstancias;i++){
			instancias.options[i] = new Option(tabla_instancias_unidad[idUnidadSeleccionada][i], tabla_val_instancias_unidad [idUnidadSeleccionada][i]);
			instancias.options[i].value = tabla_val_instancias_unidad[idUnidadSeleccionada][i];
			if (tabla_val_instancias_unidad[idUnidadSeleccionada][i]==instanciaSeleccionada){     
				seleccion=i;
			}
		}
		if (instanciaSeleccionada == 0)
			seleccion=instancias.options.length;
		instancias.options[instancias.options.length]=new Option('NINGUNA',0);
		instancias.selectedIndex=seleccion;
	}
	
	function generar_instancias_celsius_dependencia(dependencias,instancias,instanciaSeleccionada){
		var seleccion=0;
	
		var idDependenciaSeleccionada=dependencias.options[dependencias.selectedIndex].value;
			
		var cantidadInstancias=0;
		if (tabla_long_instancias_dependencia[idDependenciaSeleccionada]!=null)
			cantidadInstancias=tabla_long_instancias_dependencia[idDependenciaSeleccionada];
		instancias.length=cantidadInstancias;
		
		for (i=0;i<cantidadInstancias;i++){
			instancias.options[i] = new Option(tabla_instancias_dependencia[idDependenciaSeleccionada][i], tabla_val_instancias_dependencia [idDependenciaSeleccionada][i]);
			instancias.options[i].value = tabla_val_instancias_dependencia[idDependenciaSeleccionada][i];
			if (tabla_val_instancias_dependencia[idDependenciaSeleccionada][i]==instanciaSeleccionada){     
				seleccion=i;
			}
		}
		if (instanciaSeleccionada == 0)
			seleccion=instancias.options.length;
		instancias.options[instancias.options.length]=new Option('NINGUNA',0);
		instancias.selectedIndex=seleccion;
	}
	
	function generar_instancias_celsius_institucion(instituciones,instancias,instanciaSeleccionada){
		var seleccion=0;
	
		var idInstitucionSeleccionada=instituciones.options[instituciones.selectedIndex].value;
			
		var cantidadInstancias=0;
		if (tabla_long_instancias_institucion[idInstitucionSeleccionada]!=null)
			cantidadInstancias=tabla_long_instancias_institucion[idInstitucionSeleccionada];
		instancias.length=cantidadInstancias;
		
		
		for (i=0;i<cantidadInstancias;i++){
			instancias.options[i] = new Option(tabla_instancias_institucion[idInstitucionSeleccionada][i], tabla_val_instancias_institucion [idInstitucionSeleccionada][i]);
			instancias.options[i].value = tabla_val_instancias_institucion[idInstitucionSeleccionada][i];
			if (tabla_val_instancias_institucion[idInstitucionSeleccionada][i]==instanciaSeleccionada){     
				seleccion=i;
			}
		}
		if (instanciaSeleccionada == 0)
			seleccion=instancias.options.length;
		instancias.options[instancias.options.length]=new Option('NINGUNA',0);
		instancias.selectedIndex=seleccion;
	}
	//------------------------------------------------------------------------
	<? 
}

if (!empty($localidades)){
?>
	////////////////////////////////////////////////////////////////////
	/////////////////////////// Localidades ////////////////////////////
	////////////////////////////////////////////////////////////////////
	
	tabla_localidades = new Array;
	tabla_val_local = new Array;
	tabla_long_local = new Array; 
	<?
	//imprime los arreglos de localidades
	$cantidadLocalidades=count($localidades);
	$indicesLocalidades = array();
	for ($i=0; $i < $cantidadLocalidades; $i++){
		$localidad = $localidades[$i];
		$idPais = $localidad["Codigo_Pais"];
		if (!isset($indicesLocalidades[$idPais])){
			$indicesLocalidades[$idPais]=0;
			echo "\n";
			echo "tabla_localidades[".$idPais."]=new Array;\n";
			echo "tabla_val_local[".$idPais."]=new Array;\n";            
		}
		echo "tabla_localidades[".$idPais."][".$indicesLocalidades[$idPais]."]='".StringUtils::getSafeString($localidad["Nombre"])."';\n";
		echo "tabla_val_local[".$idPais."][".$indicesLocalidades[$idPais]."]=".$localidad["Id"].";\n";

		$indicesLocalidades[$idPais]++;
	}
	
	//Reflejo las longitudes de los vectores
	while (list($key,$valor)=each($indicesLocalidades)){	
		echo "tabla_long_local[".$key."]=".$valor.";\n";
	}
	?>
	
	function generar_localidades(localidadSeleccionada, groupNumber){     
		var paisesListName = getList("paises",groupNumber);
		var paises=getObjectByName(paisesListName);
		
		var localidadesListName = getList("localidades",groupNumber);
		
		var localidades=getObjectByName(localidadesListName);
		
		var idPaisSeleccionado=paises.options[paises.selectedIndex].value;
		
		var cantidadLocalidades = 0;
		if (tabla_long_local[idPaisSeleccionado]!=null)
			cantidadLocalidades = tabla_long_local[idPaisSeleccionado];
		localidades.length = cantidadLocalidades;
		
		var seleccion=0;
		for (i=0;i<cantidadLocalidades;i++){
			localidades.options[i].text=tabla_localidades[idPaisSeleccionado][i];
			localidades.options[i].value=tabla_val_local[idPaisSeleccionado][i];
			if (tabla_val_local [idPaisSeleccionado][i]==localidadSeleccionada){
				seleccion= i;
			}
		}
		
		if (localidadSeleccionada == 0)
			seleccion=localidades.options.length;
	
		localidades.options[localidades.options.length] = new Option('NINGUNO',0);
		localidades.selectedIndex=seleccion;
	
	}
	//------------------------------------------------------------------------
<?
}
?>
</script>
<?
/*
<script language="JavaScript" type="text/javascript">
	
	//Por ejemplo para definir mas de un conjunto de listas
	
	listNames[0] = new Array();
	listNames[0]["paises"]="id_pais0";
	listNames[0]["instituciones"]="id_institucion0";
	listNames[0]["dependencias"]="id_dependencia0";
	listNames[0]["unidades"]="id_unidad0";
	listNames[0]["instancias_celsius"]="id_instancia_celsius0";
	listNames[0]["localidades"]="id_localidad0";
	
	listNames[1] = new Array();
	listNames[1]["paises"]="id_pais1";
	listNames[1]["instituciones"]="id_institucion1";
	listNames[1]["dependencias"]="id_dependencia1";
	listNames[1]["unidades"]="id_unidad1";
	listNames[1]["instancias_celsius"]="id_instancia_celsius1";
	listNames[1]["localidades"]="id_localidad1";
</script>

	//en la invocacion de los onchange se usaria por ejemplo
	<select name="id_pais0" onchange="generar_instituciones(0,0)" size="1"/>
	
	//si hay solo un conjunto de combos se puede poner directamente sin el 2º parametro
	<select name="id_pais" onchange="generar_instituciones(0)" size="1"/>
	o sino tambien 
	<select name="id_pais" onchange="generar_instituciones(0);generar_localidades(0);" size="1"/>
*/

?>