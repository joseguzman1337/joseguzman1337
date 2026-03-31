<?php
require_once("estudiante.php");

class Cohorte{

	private $db;

	public function __construct( $db ) {
        $this->db = $db;
    }	

    private function cohortes( $codigoPeriodo , $codigoEstudiante ) {
      
        $estudiante = new Estudiante( $this->db , $codigoEstudiante ); 
        $estudiantes = $estudiante->estudiantes();
        
        $sql = "SELECT idcohorte FROM cohorte ".
        " WHERE codigocarrera =" . $estudiantes["codigocarrera"] . " ".
        " AND codigoperiodo = " . $codigoPeriodo;
        $idcohorte = $this->db->GetRow($sql);
        return $idcohorte["idcohorte"];
    }

    public function detalleCohorte( $idPrematricula, $codigoEstudiante , $codigoPeriodo ) {

        $estudiante = new Estudiante( $this->db , $codigoEstudiante); 
        $semestre = $estudiante->semetreEstudiante( $idPrematricula );
        
        $sql = "SELECT valordetallecohorte FROM detallecohorte ".
        " WHERE idcohorte = " . $this->cohortes( $codigoPeriodo , $codigoEstudiante ) . " ".
        " AND semestredetallecohorte=" . $semestre;
       
        $valorSemestre = $this->db->GetRow($sql);
        return $valorSemestre["valordetallecohorte"];
    }
}
?>
 