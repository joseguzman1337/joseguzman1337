<?php
// Siempre va a existir una prematricula por periodo o semestre
class prematricula
{
        // Variables 
        var $idprematricula;
        var $fechaprematricula;
        var $codigoestudiante;
        var $codigoperiodo;
        var $codigoestadoprematricula;
        var $observacionprematricula;
        var $semestreprematricula;

		// This is the constructor for this class: la funciòn inicializa unicamente un registro
        // Initialize all your default variables here
        function prematricula($idprematricula = '', $codigoperiodo = '', $codigoestudiante = '')
        {
				global $db;
				if($idprematricula == '')
				{
					if($codigoperiodo != '' && $codigoestudiante != '')
					{
						$query_prematricula = "SELECT idprematricula, fechaprematricula, codigoestudiante, 
						codigoperiodo, codigoestadoprematricula, observacionprematricula, semestreprematricula 
						FROM prematricula
						where codigoperiodo = '$codigoperiodo'
						and codigoestudiante = '$codigoestudiante'";
					}
				}
				else
				{
					$query_prematricula = "SELECT idprematricula, fechaprematricula, codigoestudiante, 
					codigoperiodo, codigoestadoprematricula, observacionprematricula, semestreprematricula 
					FROM prematricula
					where idprematricula = '$idprematricula'";
				}
				$prematricula = $db->Execute($query_prematricula);
				$totalRows_prematricula = $prematricula->RecordCount();
				$row_prematricula = $prematricula->FetchRow(); 

                $this->setIdprematricula($row_prematricula['idprematricula']);
                $this->setFechaprematricula($row_prematricula['fechaprematricula']);
                $this->setCodigoestudiante($row_prematricula['codigoestudiante']);
                $this->setCodigoperiodo($row_prematricula['codigoperiodo']);
                $this->setCodigoestadoprematricula($row_prematricula['codigoestadoprematricula']);
                $this->setObservacionprematricula($row_prematricula['observacionprematricula']);
                $this->setSemestreprematricula($row_prematricula['semestreprematricula']);
        }	
			
        /**
        * @return returns value of variable $idprematricula
        * @desc getIdprematricula : Getting value for variable $idprematricula
        */
        function getIdprematricula()
        {
                return $this->idprematricula;
        }

        /**
        * @param param : value to be saved in variable $idprematricula
        * @desc setIdprematricula : Setting value for $idprematricula
        */
        function setIdprematricula($value)
        {
                $this->idprematricula = $value;
        }

        /**
        * @return returns value of variable $fechaprematricula
        * @desc getFechaprematricula : Getting value for variable $fechaprematricula
        */
        function getFechaprematricula()
        {
                return $this->fechaprematricula;
        }

        /**
        * @param param : value to be saved in variable $fechaprematricula
        * @desc setFechaprematricula : Setting value for $fechaprematricula
        */
        function setFechaprematricula($value)
        {
                $this->fechaprematricula = $value;
        }

        /**
        * @return returns value of variable $codigoestudiante
        * @desc getCodigoestudiante : Getting value for variable $codigoestudiante
        */
        function getCodigoestudiante()
        {
                return $this->codigoestudiante;
        }

        /**
        * @param param : value to be saved in variable $codigoestudiante
        * @desc setCodigoestudiante : Setting value for $codigoestudiante
        */
        function setCodigoestudiante($value)
        {
                $this->codigoestudiante = $value;
        }

        /**
        * @return returns value of variable $codigoperiodo
        * @desc getCodigoperiodo : Getting value for variable $codigoperiodo
        */
        function getCodigoperiodo()
        {
                return $this->codigoperiodo;
        }

        /**
        * @param param : value to be saved in variable $codigoperiodo
        * @desc setCodigoperiodo : Setting value for $codigoperiodo
        */
        function setCodigoperiodo($value)
        {
                $this->codigoperiodo = $value;
        }

        /**
        * @return returns value of variable $codigoestadoprematricula
        * @desc getCodigoestadoprematricula : Getting value for variable $codigoestadoprematricula
        */
        function getCodigoestadoprematricula()
        {
                return $this->codigoestadoprematricula;
        }

        /**
        * @param param : value to be saved in variable $codigoestadoprematricula
        * @desc setCodigoestadoprematricula : Setting value for $codigoestadoprematricula
        */
        function setCodigoestadoprematricula($value)
        {
                $this->codigoestadoprematricula = $value;
        }

        /**
        * @return returns value of variable $observacionprematricula
        * @desc getObservacionprematricula : Getting value for variable $observacionprematricula
        */
        function getObservacionprematricula()
        {
                return $this->observacionprematricula;
        }

        /**
        * @param param : value to be saved in variable $observacionprematricula
        * @desc setObservacionprematricula : Setting value for $observacionprematricula
        */
        function setObservacionprematricula($value)
        {
                $this->observacionprematricula = $value;
        }

        /**
        * @return returns value of variable $semestreprematricula
        * @desc getSemestreprematricula : Getting value for variable $semestreprematricula
        */
        function getSemestreprematricula()
        {
                return $this->semestreprematricula;
        }

        /**
        * @param param : value to be saved in variable $semestreprematricula
        * @desc setSemestreprematricula : Setting value for $semestreprematricula
        */
        function setSemestreprematricula($value)
        {
                $this->semestreprematricula = $value;
        }

        // This is the destructor for this class
        // Do whatever needs to be done when object no longer needs to be used
        function __destruct()
        {

        }

        // This function will clear all the values of variables in this class
        function emptyInfo()
        {

                $this->setIdprematricula("");
                $this->setFechaprematricula("");
                $this->setCodigoestudiante("");
                $this->setCodigoperiodo("");
                $this->setCodigoestadoprematricula("");
                $this->setObservacionprematricula("");
                $this->setSemestreprematricula("");
        }

} 
?>