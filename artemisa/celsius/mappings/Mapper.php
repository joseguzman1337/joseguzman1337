<?php
require_once "MappingParser.php";

/*
 *
 */
class Mapper{
	
	var $tableNameMappings;
	// = array("paises" => "paises");
	var $tableColumnsMappings;
	// = array("paises" => array("nombre_pais" => "nombre", "abreviatura" => "iso3166"));
	
	 function mapper(){
		
		//inicializa los arrays de mapeos
		$parser = new MappingParser();
		$parser->init(pathinfo( __FILE__, PATHINFO_DIRNAME )."/mappings.xml");
		$this->tableNameMappings = $parser->tableNameMappings;
		$this->tableColumnsMappings = $parser->tableColumnsMappings;
		}
	
	/**
	 * Transforma un vector de datos en una estructura local a 
	 * la estructura remota del directorio
	 * @param String localTableName el nombre de la tabla local
	 * @param Array arrayOfLocalFields Un vector asociativo 
	 * con los nombres de las columnas locales y el valor de cada una
	 */
	 function mapLocalToRemoteElement($localTableName, $arrayOfLocalFields){
		$arrayOfRemoteFields = array();
		$localRemoteTableColumnsMapping = $this->getLocalToRemoteTableColumnsMapping($localTableName);
		foreach ($arrayOfLocalFields as $localFieldName => $fieldValue){
			$arrayOfRemoteFields[$localRemoteTableColumnsMapping[$localFieldName]] = $fieldValue; 
		}
		return $arrayOfRemoteFields;
	}
	
	 function mapRemoteToLocalTableColumns($remoteTableName, $remoteTableColumns){
		$localTableColumns =$this->getRemoteToLocalTableColumnsMapping($remoteTableName);
		$localColumns = array();
		foreach ($remoteTableColumns as $remoteColumn){
			if (trim($remoteColumn) == "*")
				$localColumns[] = "*";
			else
				$localColumns[] = $localTableColumns[$remoteColumn];
		}
		return $localColumns;
	}
	
	function mapRemoteToLocalTableNames($remoteTableNames){
		$localTableNames = array();
		foreach ($remoteTableNames as $remoteTableName){
			$localTableNames[]=$this->getLocalTableName($remoteTableName);
		}
		return $localTableNames;
	}
	
	 function getRemoteTableName($localTableName){
		return array_search($localTableName, $this->tableNameMappings);
	}
	
	 function getLocalTableName($remoteTableName){
		return $this->tableNameMappings[$remoteTableName];
	}
	
	 function getLocalToRemoteTableColumnsMapping($localTableName){
		$remoteTableName =$this->getRemoteTableName($localTableName);
		return array_flip($this->tableColumnsMappings[$remoteTableName]);
	}
	
	 function getRemoteToLocalTableColumnsMapping($remoteTableName){
		return $this->tableColumnsMappings[$remoteTableName];
	}
	
	 function getLocalColumnName($remoteTableName,$remoteColumnName){
		return $this->tableColumnsMappings[$remoteTableName][$remoteColumnName];
	}
}

?>
