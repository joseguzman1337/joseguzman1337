<?php
die('Solo se usa para generacion del instalador');

/**
 * Archivo auxiliar que se usa para calcular las diferencias entre 2 BDD
 * El instalador no los usa directamente, pero se sirve para generar los 
 * scripts de la carpeta sql/
 */
function diffBDD($dbname1, $dbname2){
	mysql_select_db($dbname1);
	
	$resultTablas = mysql_query("SHOW TABLES");
	$tablas_16=array();
	while ($rowTabla = mysql_fetch_row($resultTablas)){
		$tableName = strtolower($rowTabla[0]);
		
		$tablas_16[$tableName]=array();
		
		$resultInfoTabla = mysql_query("DESCRIBE ".$rowTabla[0]);
		while ($rowColumna = mysql_fetch_assoc($resultInfoTabla)){
			$tablas_16[$tableName][]=$rowColumna["Field"];
		}
	}
	
	mysql_select_db($dbname2);
	
	$resultTablas = mysql_query("SHOW TABLES");
	$tablas_16_nt=array();
	while ($rowTabla = mysql_fetch_row($resultTablas)){
		$tableName = strtolower($rowTabla[0]);
		$tablas_16_nt[$tableName]=array();
		
		$resultInfoTabla = mysql_query("DESCRIBE ".$rowTabla[0]);
		while ($rowColumna = mysql_fetch_assoc($resultInfoTabla)){
			$tablas_16_nt[$tableName][]=$rowColumna["Field"];
		}
	}
	
	//calculo la interseccion de las tablas
	$tablas_Comunes=array();
	$tablas_Nuevas = array();
	foreach($tablas_16_nt as $tablaIName => $tablaICols){
		if (empty($tablas_16[$tablaIName]))
			$tablas_Nuevas[$tablaIName] = $tablaICols;
		else{
			$diff = array_diff($tablaICols,$tablas_16[$tablaIName]);
			if (count($diff) > 0)
				$tablas_Comunes[$tablaIName] = $diff;
		}
		
	}
	echo "Las tablas agregadas (cuyos datos deben ir en celsiusNT_datos_iniciales.sql) en CelsiusNT son:<br><pre>";
	var_export($tablas_Nuevas);
	echo "</pre><br>";
	
	echo "Las columnas agregadas (cuyos datos deben ir en actualizacion_16_a_NT.sql) en CelsiusNT son:<br><pre>";
	var_export($tablas_Comunes);
	echo "</pre>";
	
	foreach($tablas_Comunes as $tablasI => $colsI){
		echo "UPDATE $tablasI SET ".implode(" = '', ",$colsI)." = '';<br>";
	}
	
}

mysql_connect("localhost", "root", "root");
diffBDD("CelsiusVieja", "celsiusOriginal");

?>