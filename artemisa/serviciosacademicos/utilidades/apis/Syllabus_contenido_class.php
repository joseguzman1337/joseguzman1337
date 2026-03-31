<?PHP 
class Syllabus_contenido{
    var $db;
    var $materia;
    var $periodo;
    function __construct($db,$materia,$periodo){ 
		$this->db      = $db;
        $this->materia = $materia;
        $this->periodo = $periodo;
	}//__construct
    function Syllabus(){
          $SQL='SELECT
                    c.idcontenidoprogramatico,
                    c.codigomateria,
                    c.urlasyllabuscontenidoprogramatico,
                    m.nombremateria
                FROM
                    contenidoprogramatico c INNER JOIN materia m ON m.codigomateria=c.codigomateria
                WHERE
                    c.codigomateria = ?
                AND c.codigoperiodo = ?
                AND c.codigoestado = 100';
        
        $variables   = array();
        $variables[] = "$this->materia";
        $variables[] = "$this->periodo";
        
        $Syllabus = $this->db->GetRow($SQL,$variables);
        
        return $Syllabus;
    }//function Syllabus
}//Syllabus_contenido
?>