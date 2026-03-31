<?php 
/**
 * Clase encargada de registrar los log de errores
 * @author Andres Ariza <arizaandres@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @package Entidades
 * @since Enero 24, 2017
*/
class ErrorLog 
{
    /**
     * Constructor del objeto
     * @access public
	 * @param string $filename
	 * @param string $path
     * @return void
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since Enero 20, 2017
    */
	public function __construct($filename, $path) {
		 $this->path     = ($path) ? $path : "/"; 
		 $this->filename = ($filename) ? $filename : "log"; 
		 $this->date     = date("Y-m-d H:i:s"); 
		 $this->ip       = ($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 0; 
	}
	
    /**
     * Inserta en el archivo de texto los logs
     * @access public
	 * @param string $text
	 * @param boolean $dated (para agregar o no la fecha del registro)
	 * @param boolean $clear (definir si queremos eliminar el contenido anterior del fichero o si queremos ir añadiendo lineas nuevas manteniendo las anteriores)
	 * @param boolean $backup (Por si, por ejemplo, queremos guardar una copia del fichero LOG antes de sobreescribirlo con otra sesión )
     * @return int
     * @author Andres Ariza <arizaandres@unbosque.edu.co>
     * @since Enero 24, 2017
    */
	public function insert($text, $dated=false, $clear=false, $backup=false) {
		if ($dated) {
			$date   = "_" . str_replace(" ", "_", $this->date);
			$append = null;
		} else {
			 $date   = "";
			 $append = ($clear) ? null : FILE_APPEND;
			 if ($backup) {
			 	$result = (copy($this->path . $this->filename . ".log", $this->path . $this->filename . "_" . str_replace(" ", "_", $this->date) . "-backup.log")) ? 1 : 0; 
			 	$append = ($result) ? $result : FILE_APPEND;
			 }
		}; 
		$log    = $this->date . " [ip] " . $this->ip . " [text] " . $text . PHP_EOL;
		$result = (file_put_contents($this->path . $this->filename . $date . ".log", $log, $append)) ? 1 : 0;
		return $result; 
	} 
}