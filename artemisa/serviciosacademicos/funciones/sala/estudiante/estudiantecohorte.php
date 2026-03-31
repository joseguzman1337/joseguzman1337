<?php
// Crear una clase de clases para el estudiante donde se tarigan todos la informaciòn del estudiante
class estudiantecohorte
{
   		var $prematricula;

		/**
        * @return returns value of variable $codigoestudiante
        * @desc getCodigoestudiante : Getting value for variable $codigoestudiante
        */
        function getPrematricula()
        {
				global $db;
                return $this->prematricula;
        }
		
		/**
        * @param param : value to be saved in variable $codigoestudiante
        * @desc setCodigoestudiante : Setting value for $codigoestudiante
        */
        function setPrematricula($value)
        {
                $this->prematricula = $value;
        }
} 
?>