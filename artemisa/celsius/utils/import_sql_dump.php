<?php
/**
 * Script para importacion de dumps en mysql. 
 */

//desactiva el limite de tiempo. Probablemente la importacion tarde mas que el tiempo de timeout por default
set_time_limit(0);
require_once "../exceptions/DB_Exception.php";
require_once "../exceptions/Application_Exception.php";

/*
//Codigo para pruebas
mysql_connect("localhost", "root", "root");
mysql_select_db("celsiusNT");

$incicio = microtime();
$import_file = "./instalador/sql/celsiusNT_datos_iniciales_instalacion.sql";
$errores = importSQLFile($import_file);
var_dump($errores);
echo "<br>tardo. " . (microtime() - $incicio);
*/


/**
 * Importa el contenido del archivo especificado por el parametro $import_file en mysql.
 * Utiliza la conexion actual, por ende previamente se debera haber ejecutado mysql_connect y 
 * mysql_selectdb.
 * @param string $import_file El path al archivo que contiene el dump
 * @param string $charset_of_file? La codificacion de los datos del archivo. Por default toma latin1
 * @return mixed TRUE si la ejecucion fue exitosa o false si se ejecutaron todos las sentencia del dump, pero sin embargo quedaron datos en el archivo.
 * @throws ApplicationException En caso de producirse algun error con el archivo del dump.
 * @throws DB_Exception En caso de producirse algun error de bases de datos mientras intenta ejecutar las sentencias del dump 
 * @access public 
 */
function importSQLFile($import_file, $charset_of_file = 'latin1') {
	global $import_handle, $max_sql_len, $executed_queries, $sql_query, $sql_query_disabled,
	$complete_query, $go_sql, $finished,$read_multiply, $read_limit, $buffer, $sql, $start_pos, $offset;
	
	if (!file_exists($import_file)) {
		return new Application_Exception("El archivo '$import_file' no existe.");
	}
	
	if (!is_readable($import_file)) {
		return new Application_Exception("No se puede leer el archivo '$import_file'. Revise que los permisos sean correctos");
	}
	$import_handle = @ fopen($import_file, 'r');
	if (!$import_handle) {
		return new Application_Exception("Error inesperado. Se genero un problema al acceder al archivo '$import_file'");
	}
	
	$result = mysql_query('SET NAMES \'' . $charset_of_file . '\'');
	if ($result === FALSE) // execution failed
		return new DB_Exception("Se produjo un error al tratar de cambiar el charset de la conexion con mysql.<br/>",mysql_error(),mysql_errno());
					
	$max_sql_len = 0;
	$executed_queries = 0;
	$sql_query = '';
	$sql_query_disabled = FALSE;
	$complete_query = '';
	$go_sql = FALSE;
	$finished = false;
	$read_multiply = 1;
	$read_limit = getReadLimit();
	$buffer = '';
	$sql = '';
	$start_pos = 0;
	$offset = 0;
	
	$i = 0;
	$len = null;
	while (!($finished && $i >= $len)) {
		$data = PMA_importGetNextChunk();
		if ($data === FALSE) {
			// subtract data we didn't handle yet and stop processing
			$offset -= strlen($buffer);
			break;
		}
		elseif ($data === TRUE) {
			// Handle rest of buffer
		} else {
			// Append new data to buffer
			$buffer .= $data;
			// Do not parse string when we're not at the end and don't have ; inside
			if ((strpos($buffer, ';') === FALSE) && !$finished) {
				continue;
			}
		}
		// Current length of our buffer
		$len = strlen($buffer);
		// Grab some SQL queries out of it
		while ($i < $len) {
			// Find first interesting character, several strpos seem to be faster than simple loop in php:
			while (($i < $len) && (strpos('\'";#-/', $buffer[$i]) === FALSE)) {
				$i++;
			}

			if ($i == $len)
				break;
			/* Codigo alternativo. El anterior anda mejor
			$oi = $i;
			$p1 = strpos($buffer, '\'', $i);
			if ($p1 === FALSE) {
				$p1 = 2147483647;
			}
			$p2 = strpos($buffer, '"', $i);
			if ($p2 === FALSE) {
				$p2 = 2147483647;
			}
			$p3 = strpos($buffer, ';', $i);
			if ($p3 === FALSE) {
				$p3 = 2147483647;
			}
			$p4 = strpos($buffer, '#', $i);
			if ($p4 === FALSE) {
				$p4 = 2147483647;
			}
			$p5 = strpos($buffer, '--', $i);
			if ($p5 === FALSE) {
				$p5 = 2147483647;
			}
			$p6 = strpos($buffer, '/*', $i);
			if ($p6 === FALSE) {
				$p6 = 2147483647;
			}
			$p7 = strpos($buffer, '`', $i);
			if ($p7 === FALSE) {
				$p7 = 2147483647;
			}
			$i = min($p1, $p2, $p3, $p4, $p5, $p6, $p7);
			if ($i == 2147483647) {
				$i = $oi;
				if (!$finished) {
					break;
				}
				// at the end there might be some whitespace...
				if (trim($buffer) == '') {
					$buffer = '';
					$len = 0;
					break;
				}
				// We hit end of query, go there!
				$i = strlen($buffer) - 1;
			}*/

			// Grab current character
			$ch = $buffer[$i];

			// Quotes
			if (strpos('\'"`', $ch) !== FALSE) {
				$quote = $ch;
				$endq = FALSE;
				while (!$endq) {
					// Find next quote
					$pos = strpos($buffer, $quote, $i +1);
					// No quote? Too short string
					if ($pos === FALSE) {
						// We hit end of string => unclosed quote, but we handle it as end of query
						if ($finished) {
							$endq = TRUE;
							$i = $len -1;
						}
						break;
					}
					// Was not the quote escaped?
					$j = $pos -1;
					while ($buffer[$j] == '\\')
						$j--;
					// Even count means it was not escaped
					$endq = (((($pos -1) - $j) % 2) == 0);
					// Skip the string
					$i = $pos;
				}
				if (!$endq) {
					break;
				}
				$i++;
				// Aren't we at the end?
				if ($finished && $i == $len) {
					$i--;
				} else {
					continue;
				}
			}

			// Not enough data to decide
			if ((($i == ($len -1) && ($ch == '-' || $ch == '/')) || ($i == ($len -2) && (($ch == '-' && $buffer[$i +1] == '-') || ($ch == '/' && $buffer[$i +1] == '*')))) && !$finished) {
				break;
			}

			// Comments
			if ($ch == '#' || ($i < ($len -1) && $ch == '-' && $buffer[$i +1] == '-' && (($i < ($len -2)) || ($i == ($len -1) && $finished))) || ($i < ($len -1) && $ch == '/' && $buffer[$i +1] == '*')) {
				// Copy current string to SQL
				if ($start_pos != $i) {
					$sql .= substr($buffer, $start_pos, $i - $start_pos);
				}
				// Skip the rest
				$i = strpos($buffer, $ch == '/' ? '*/' : "\n", $i);

				// didn't we hit end of string?
				if ($i === FALSE) {
					if ($finished) {
						$i = $len -1;
					} else {
						break;
					}
				}
				// Skip *
				if ($ch == '/') {
					$i++;
				}
				// Skip last char
				$i++;
				// Next query part will start here 
				$start_pos = $i;
				// Aren't we at the end?
				if ($i == $len) {
					$i--;
				} else {
					continue;
				}
			}

			// End of SQL
			if ($ch == ';' || ($finished && ($i == $len -1))) {
				$tmp_sql = $sql;
				if ($start_pos < $len) {
					$tmp_sql .= substr($buffer, $start_pos, $i - $start_pos +1);
				}
				// Do not try to execute empty SQL
				if (!preg_match('/^([\s]*;)*$/', trim($tmp_sql))) {
					$sql = $tmp_sql;
					$res = PMA_importRunQuery($sql, substr($buffer, 0, $i +1));
					if (is_a($res,"Celsius_Exception"))
						return $res;
					$buffer = substr($buffer, $i +1);
					// Reset parser:
					$len = strlen($buffer);
					$sql = '';
					$i = 0;
					$start_pos = 0;
					// Any chance we will get a complete query?
					if ((strpos($buffer, ';') === FALSE) && !$finished) {
						break;
					}
				} else {
					$i++;
					$start_pos = $i;
				}
			}
		} // End of parser loop
	} // End of import loop
	// Commit any possible data in buffers
	$res = PMA_importRunQuery('', substr($buffer, 0, $len));
	if (is_a($res,"Celsius_Exception"))
		return $res;
	$res = PMA_importRunQuery();
	if (is_a($res,"Celsius_Exception"))
		return $res;
	fclose($import_handle);
	return $finished;
	
}

/***************************************AUX************************************/

/**
 * Devuelve el maximo en bytes que debe ser usados para la lectura de archivos
 * @access private
 */
function getReadLimit() {

	// We can not read all at once, otherwise we can run out of memory
	$memory_limit = trim(@ ini_get('memory_limit'));
	// 2 MB as default
	if (empty ($memory_limit)) {
		$memory_limit = 2 * 1024 * 1024;
	}
	// In case no memory limit we work on 10MB chunks
	if ($memory_limit = -1) {
		$memory_limit = 10 * 1024 * 1024;
	}

	// Calculate value of the limit
	if (strtolower(substr($memory_limit, -1)) == 'm') {
		$memory_limit = (int) substr($memory_limit, 0, -1) * 1024 * 1024;
	}
	elseif (strtolower(substr($memory_limit, -1)) == 'k') {
		$memory_limit = (int) substr($memory_limit, 0, -1) * 1024;
	}
	elseif (strtolower(substr($memory_limit, -1)) == 'g') {
		$memory_limit = (int) substr($memory_limit, 0, -1) * 1024 * 1024 * 1024;
	} else {
		$memory_limit = (int) $memory_limit;
	}

	$read_limit = $memory_limit / 4; // Just to be sure, there might be lot of memory needed for uncompression
	return $read_limit;
}

/**
 *  Returns next part of imported file/buffer
 *
 *  @param  integer size of buffer to read (this is maximal size function will return)
 *  @return string part of file/buffer
 *  @access private
 */
function PMA_importGetNextChunk($size = 32768) {
	global $finished, $import_handle, $offset, $read_multiply, $read_limit;

	// Add some progression while reading large amount of data
	if ($read_multiply <= 8) {
		$size *= $read_multiply;
	} else {
		$size *= 8;
	}
	$read_multiply++;

	// We can not read too much
	if ($size > $read_limit) 
		$size = $read_limit;
	
	if ($finished) 
		return TRUE;
	
	$result = fread($import_handle, $size);
	$finished = feof($import_handle);

	$offset += $size;

	return $result;

}

/**
 *  Runs query inside import buffer. This is needed to allow displaying
 *  of last SELECT or SHOW results and simmilar nice stuff.
 *
 *  @param  string query to run
 *  @param  string query to display, this might be commented
 *  @access private
 */
function PMA_importRunQuery($sql = '', $full = '') {

	global $import_run_buffer, $go_sql, $complete_query, $sql_query, $finished, $executed_queries, $max_sql_len, $read_multiply, $sql_query_disabled;

	$read_multiply = 1;
	if (isset ($import_run_buffer)) {

		if (!empty ($import_run_buffer['sql']) && trim($import_run_buffer['sql']) != '') {
			$max_sql_len = max($max_sql_len, strlen($import_run_buffer['sql']));
			if (!$sql_query_disabled) {
				$sql_query .= $import_run_buffer['full'];
			}
			$executed_queries++;

			if ($finished && empty ($sql) && ((!empty ($import_run_buffer['sql']) && preg_match('/^[\s]*(SELECT|SHOW)/i', $import_run_buffer['sql'])) || ($executed_queries == 1))) {
				$go_sql = TRUE;
				if (!$sql_query_disabled) {
					$complete_query = $sql_query;
				} else {
					$complete_query = '';
				}
				$sql_query = $import_run_buffer['sql'];
			} else {
				$result = mysql_query($import_run_buffer['sql']);
				if ($result === FALSE) // execution failed
					return new DB_Exception("Se produjo un error al ejecutar la sentencia sql <br/><pre>".$import_run_buffer['sql']."</pre><br/>",mysql_error(),mysql_errno());
					
				//logging
				//echo "Se ejecuto el query :"; var_dump($import_run_buffer['sql']); echo "<br>";
				//flush();
			}
		} // end non empty query
		elseif (!empty ($import_run_buffer['full'])) {
			if ($go_sql) {
				$complete_query .= $import_run_buffer['full'];

			} else {
				if (!$sql_query_disabled) {
					$sql_query .= $import_run_buffer['full'];
				}
			}
		}
		// check length of query unless we decided to pass it to sql.php
		if (!$go_sql) {
			if (strlen($sql_query) > 10000 || $executed_queries > 10 || $max_sql_len > 500) {
				$sql_query = '';
				$sql_query_disabled = TRUE;
			}
		}
		// end do query 
	} // end buffer exists

	// Do we have something to push into buffer?
	if (!empty ($sql) || !empty ($full)) {
		$import_run_buffer = array (
			'sql' => $sql,
			'full' => $full
		);
	} else {
		unset ($GLOBALS['import_run_buffer']);
	}
}

?>