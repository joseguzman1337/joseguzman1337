<?php
class MappingParser {

	var $tableNameMappings;
	var $tableColumnsMappings;
	var $currentTable;

	function MappingParser() {
	}

	function start_element($parser, $name, $attrs) {
		
		if ($name == "mappings") {
			$this->tableNameMappings = array ();
			$this->tableColumnsMappings = array ();
		}
		elseif ($name == "table" || $name == "column") {
			if (count($attrs) != 2)
				echo "Malformed XML, table|column elements must have 2 attributes";
			$localName = "";
			$remoteName = "";
			foreach ($attrs as $attrName => $attrValue) {
				if ($attrName == "localName")
					$localName = $attrValue;
				elseif ($attrName == "remoteName") $remoteName = $attrValue;
				else
					echo "Malformed XML, table|column elements accepts only localName and remoteName attributes";
			}

			if (!$localName || !$remoteName)
				echo "Malformed XML, attributres localName and remoteName are required for table|column element";

			if ($name == "table") {
				$this->tableNameMappings[$remoteName] = $localName;
				$this->currentTable = $remoteName;
			} else {
				if (!$this->currentTable)
					echo "Malformed XML, column elements must be inside a table element";
				$this->tableColumnsMappings[$this->currentTable][$remoteName] = $localName;
			}
		} else {
			echo "Malformed XML, element $name is not requiered";
		}
	}

	function end_element($parser, $name) {
	}

	function characters($parser, $chars) {
	}

	function init($fileName) {
		$book_parser = xml_parser_create();
		xml_parser_set_option($book_parser, XML_OPTION_CASE_FOLDING, 0);

		xml_set_object($book_parser, $this);
		xml_set_element_handler($book_parser, "start_element", "end_element");
		xml_set_character_data_handler($book_parser, "characters");


		if ($file_stream = fopen($fileName, "r")) {

			while ($data = fread($file_stream, 4096)) {

				$this_chunk_parsed = xml_parse($book_parser, $data, feof($file_stream));
				if (!$this_chunk_parsed) {
					$error_code = xml_get_error_code($book_parser);
					$error_text = xml_error_string($error_code);
					$error_line = xml_get_current_line_number($book_parser);

					$output_text = "Parsing problem at line $error_line: $error_text";
					die($output_text);
				}
			}

		} else {
			die("Can't open XML file: $fileName");
		}
		xml_parser_free($book_parser);
	}
}

?>