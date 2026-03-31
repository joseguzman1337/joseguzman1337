<?php
class respuesta
{ 

        // Variables 
        var $idrespuesta;
        var $idpregunta;
        var $nombrerespuesta;
        var $idtiporespuesta;
        var $codigoestado;
		var $encuestaactiva=0;
		function respuesta($idrespuesta)
		{
			global $db;
			$query_respuesta = "SELECT idrespuesta, idpregunta, nombrerespuesta, idtiporespuesta, codigoestado 
			FROM respuesta
			where idrespuesta = '$idrespuesta'
			and codigoestado like '1%'";
			
			$respuesta = $db->Execute($query_respuesta);
			$totalRows_respuesta = $respuesta->RecordCount();
			$row_respuesta = $respuesta->FetchRow(); 
			
		 	$this->idrespuesta=$row_respuesta['idrespuesta'];
			$this->idpregunta=$row_respuesta['idpregunta'];
			$this->nombrerespuesta=$row_respuesta['nombrerespuesta'];
			$this->idtiporespuesta=$row_respuesta['idtiporespuesta'];
			$this->codigoestado=$row_respuesta['codigoestado'];
			
		}

        /**
        * @return returns value of variable $idrespuesta
        * @desc getIdrespuesta : Getting value for variable $idrespuesta
        */
        function getIdrespuesta()
        {
                return $this->idrespuesta;
        }

        /**
        * @param param : value to be saved in variable $idrespuesta
        * @desc setIdrespuesta : Setting value for $idrespuesta
        */
        function setIdrespuesta($value)
        {
                $this->idrespuesta = $value;
        }

        /**
        * @return returns value of variable $idpregunta
        * @desc getIdpregunta : Getting value for variable $idpregunta
        */
        function getIdpregunta()
        {
                return $this->idpregunta;
        }

        /**
        * @param param : value to be saved in variable $idpregunta
        * @desc setIdpregunta : Setting value for $idpregunta
        */
        function setIdpregunta($value)
        {
                $this->idpregunta = $value;
        }

        /**
        * @return returns value of variable $nombrerespuesta
        * @desc getNombrerespuesta : Getting value for variable $nombrerespuesta
        */
        function getNombrerespuesta()
        {
                return $this->nombrerespuesta;
        }

        /**
        * @param param : value to be saved in variable $nombrerespuesta
        * @desc setNombrerespuesta : Setting value for $nombrerespuesta
        */
        function setNombrerespuesta($value)
        {
                $this->nombrerespuesta = $value;
        }

        /**
        * @return returns value of variable $idtiporespuesta
        * @desc getIdtiporespuesta : Getting value for variable $idtiporespuesta
        */
        function getIdtiporespuesta()
        {
                return $this->idtiporespuesta;
        }

        /**
        * @param param : value to be saved in variable $idtiporespuesta
        * @desc setIdtiporespuesta : Setting value for $idtiporespuesta
        */
        function setIdtiporespuesta($value)
        {
                $this->idtiporespuesta = $value;
        }

        /**
        * @return returns value of variable $codigoestado
        * @desc getCodigoestado : Getting value for variable $codigoestado
        */
        function getCodigoestado()
        {
                return $this->codigoestado;
        }

        /**
        * @param param : value to be saved in variable $codigoestado
        * @desc setCodigoestado : Setting value for $codigoestado
        */
        function setCodigoestado($value)
        {
                $this->codigoestado = $value;
        }

        // This is the constructor for this class
        // Initialize all your default variables here
        function __construct()
        {

                $this->setIdrespuesta("");
                $this->setIdpregunta("");
                $this->setNombrerespuesta("");
                $this->setIdtiporespuesta("");
                $this->setCodigoestado("");
        }

	    // This function will clear all the values of variables in this class
        function emptyInfo()
        {

                $this->setIdrespuesta("");
                $this->setIdpregunta("");
                $this->setNombrerespuesta("");
                $this->setIdtiporespuesta("");
                $this->setCodigoestado("");
        }

} 

class pregunta
{ 
		// Variables 
        var $idpregunta;
        var $idtipopregunta;
        var $idencuesta;
        var $nombrepregunta;
        var $codigoestado;
		
		var $respuestas;

		function pregunta($idpregunta)
		{
			global $db;
			$query_pregunta = "SELECT idpregunta, idtipopregunta, idencuesta, nombrepregunta, codigoestado 
			FROM pregunta
			where idpregunta = '$idpregunta'
			and codigoestado like '1%'";
			
			$pregunta = $db->Execute($query_pregunta);
			$totalRows_encuesta = $pregunta->RecordCount();
			$row_pregunta = $pregunta->FetchRow(); 
			
		 	$this->idpregunta=$row_pregunta['idpregunta'];
			$this->idtipopregunta=$row_pregunta['idtipopregunta'];
			$this->idencuesta=$row_pregunta['idencuesta'];
			$this->nombrepregunta=$row_pregunta['nombrepregunta'];
			$this->codigoestado=$row_pregunta['codigoestado'];
			
			$this->setRespuestas();
		}

		/**
        * @return returns value of variable $idencuesta
        * @desc getIdencuesta : Getting value for variable $idencuesta
        */
        function getRespuestas()
        {
			return $this->respuestas;
        }

        /**
        * @param param : value to be saved in variable $idencuesta
        * @desc setIdencuesta : Setting value for $idencuesta
        */
        function setRespuestas()
        {
            global $db;
			$query_respuestas = "SELECT idrespuesta, idpregunta, nombrerespuesta, idtiporespuesta, codigoestado 
			FROM respuesta
			where idpregunta = '$this->idpregunta'
			and codigoestado like '1%'";
			
			$respuestas = $db->Execute($query_respuestas);
			$totalRows_respuestas = $respuestas->RecordCount();
			while($row_respuestas = $respuestas->FetchRow()) :
				$respuesta = new respuesta($row_respuestas['idrespuesta']); 
				//print_r($respuesta);
        		$this->respuestas[] = $respuesta;
			endwhile;
        }
		
        /**
        * @return returns value of variable $idpregunta
        * @desc getIdpregunta : Getting value for variable $idpregunta
        */
        function getIdpregunta()
        {
                return $this->idpregunta;
        }

        /**
        * @param param : value to be saved in variable $idpregunta
        * @desc setIdpregunta : Setting value for $idpregunta
        */
        function setIdpregunta($value)
        {
                $this->idpregunta = $value;
        }

        /**
        * @return returns value of variable $idtipopregunta
        * @desc getIdtipopregunta : Getting value for variable $idtipopregunta
        */
        function getIdtipopregunta()
        {
                return $this->idtipopregunta;
        }

        /**
        * @param param : value to be saved in variable $idtipopregunta
        * @desc setIdtipopregunta : Setting value for $idtipopregunta
        */
        function setIdtipopregunta($value)
        {
                $this->idtipopregunta = $value;
        }

        /**
        * @return returns value of variable $idencuesta
        * @desc getIdencuesta : Getting value for variable $idencuesta
        */
        function getIdencuesta()
        {
                return $this->idencuesta;
        }

        /**
        * @param param : value to be saved in variable $idencuesta
        * @desc setIdencuesta : Setting value for $idencuesta
        */
        function setIdencuesta($value)
        {
                $this->idencuesta = $value;
        }

        /**
        * @return returns value of variable $nombrepregunta
        * @desc getNombrepregunta : Getting value for variable $nombrepregunta
        */
        function getNombrepregunta()
        {
                return $this->nombrepregunta;
        }

        /**
        * @param param : value to be saved in variable $nombrepregunta
        * @desc setNombrepregunta : Setting value for $nombrepregunta
        */
        function setNombrepregunta($value)
        {
                $this->nombrepregunta = $value;
        }

        /**
        * @return returns value of variable $codigoestado
        * @desc getCodigoestado : Getting value for variable $codigoestado
        */
        function getCodigoestado()
        {
                return $this->codigoestado;
        }

        /**
        * @param param : value to be saved in variable $codigoestado
        * @desc setCodigoestado : Setting value for $codigoestado
        */
        function setCodigoestado($value)
        {
                $this->codigoestado = $value;
        }

        // This is the destructor for this class
        // Do whatever needs to be done when object no longer needs to be used
        function __destruct()
        {

        }

        // This function will clear all the values of variables in this class
        function emptyInfo()
        {

                $this->setIdpregunta("");
                $this->setIdtipopregunta("");
                $this->setIdencuesta("");
                $this->setNombrepregunta("");
                $this->setCodigoestado("");
        }

} 

class encuesta
{
        // Variables de la tabla encuesta
        var $idencuesta;
        var $nombreencuesta;
        var $fechainicioencuesta;
        var $fechafinalencuesta;
        var $informacionencuesta;
        var $fechacreacionencuesta;
        var $codigoestado;
		var $preguntas;
		
		// Variables de otras tablas
		var $codigoestudiante;
		
		function encuesta($idencuesta, $codigoestudiante)
		{
			global $db;
			if($idencuesta == '')
			{
				// Selecciona la encuesta activa
				$query_encuesta = "SELECT idencuesta, nombreencuesta, fechainicioencuesta, fechafinalencuesta, informacionencuesta, fechacreacionencuesta, codigoestado 
				FROM encuesta 
				where fechainicioencuesta <= now()
				and fechafinalencuesta >= now() 
				and codigoestado like '1%' 
				limit 1";
				//echo "$query_encuesta";
				
				$encuesta = $db->Execute($query_encuesta);
				$totalRows_encuesta = $encuesta->RecordCount();
				$row_encuesta = $encuesta->FetchRow(); 
				if($totalRows_encuesta >0)
					$this->encuestaactiva=1;
				
			}
			else
			{
				$query_encuesta = "SELECT idencuesta, nombreencuesta, fechainicioencuesta, fechafinalencuesta, informacionencuesta, fechacreacionencuesta, codigoestado 
				FROM encuesta
				where idencuesta = '$idencuesta'
				and codigoestado like '1%'";
				
				$encuesta = $db->Execute($query_encuesta);
				$totalRows_encuesta = $encuesta->RecordCount();
				$row_encuesta = $encuesta->FetchRow(); 
			}
		 	$this->idencuesta=$row_encuesta['idencuesta'];
			$this->nombreencuesta=$row_encuesta['nombreencuesta'];
			$this->fechainicioencuesta=$row_encuesta['fechainicioencuesta'];
			$this->fechafinalencuesta=$row_encuesta['fechafinalencuesta'];
			$this->informacionencuesta=$row_encuesta['informacionencuesta'];
			$this->fechacreacionencuesta=$row_encuesta['fechacreacionencuesta'];
			$this->codigoestado=$row_encuesta['codigoestado'];
			$this->codigoestudiante=$codigoestudiante;
			
			$this->setPreguntas();
		}
		
		function diligencio_encuesta()
		{
			global $db;
			$query_encuestaestudiante = "SELECT iddetalleencuesta, idencuesta, codigoestudiante, fechainiciodetalleencuesta, fechafinaldetalleencuesta, codigoestado 
			FROM detalleencuesta
			where idencuesta = '$this->idencuesta'
			and codigoestudiante = '$this->codigoestudiante'
			and codigoestado like '1%'";
			
			$encuestaestudiante = $db->Execute($query_encuestaestudiante);
			$totalRows_encuestaestudiante = $encuestaestudiante->RecordCount();
			$row_encuestaestudiante = $encuestaestudiante->FetchRow(); 
			if($totalRows_encuestaestudiante <= 0)
			{
				return false;
			}
			return $row_encuestaestudiante['iddetalleencuesta'];
		}
		
		function insertarRespuestas($respuestas, $fechainiciodetalleencuesta)
		{
			global $db;
			if($iddetalleencuesta = $this->diligencio_encuesta())
			{
				$query_upddetalleencuesta = "UPDATE detalleencuesta 
				SET fechainiciodetalleencuesta='$fechainiciodetalleencuesta', fechafinaldetalleencuesta='now()'
				WHERE iddetalleencuesta = '$iddetalleencuesta'";
			
				$upddetalleencuesta = $db->Execute($query_upddetalleencuesta);
			}
			else
			{
				$query_insdetalleencuesta = "INSERT INTO detalleencuesta(iddetalleencuesta, idencuesta, codigoestudiante, fechainiciodetalleencuesta, fechafinaldetalleencuesta, codigoestado) 
				VALUES(0, $this->idencuesta, $this->codigoestudiante, '$fechainiciodetalleencuesta', now(), '100')";
				
				$insdetalleencuesta = $db->Execute($query_insdetalleencuesta);
				$iddetalleencuesta = $db->Insert_ID();
			}
			foreach($respuestas as $idrespuesta => $valorrespuetasencuesta)
			{
				if($idrespuestasencuesta = $this->existe_respuesta($idrespuesta))
				{
					$query_updrespuestasencuesta = "UPDATE respuestasencuesta 
					SET valorrespuetasencuesta='$valorrespuetasencuesta'
					WHERE idrespuestasencuesta = '$idrespuestasencuesta'";
				
					$updrespuestasencuesta = $db->Execute($query_updrespuestasencuesta);
				}
				else
				{
					$query_insrespuestasencuesta = "INSERT INTO respuestasencuesta(idrespuestasencuesta, idrespuesta, iddetalleencuesta, valorrespuetasencuesta, codigoestado) 
					VALUES(0, $idrespuesta, $iddetalleencuesta, $valorrespuetasencuesta, '100')";
				
					$insrespuestasencuesta = $db->Execute($query_insrespuestasencuesta);					
				}
			}
		}
		
		function existe_respuesta($idrespuesta)
		{
			global $db;
			$query_respuesta = "SELECT r.idrespuestasencuesta 
			FROM detalleencuesta d, respuestasencuesta r
			where d.codigoestudiante = '$this->codigoestudiante'
			and d.idencuesta = '$this->idencuesta'
			and r.idrespuesta = '$this->idrespuesta'
			and d.iddetalleencuesta = r.iddetalleencuesta
			and d.codigoestado like '1%'
			and r.codigoestado like '1%'";
			
			$respuesta = $db->Execute($query_respuesta);
			$totalRows_respuesta = $respuesta->RecordCount();
			$row_respuesta = $respuesta->FetchRow(); 
			if($totalRows_respuesta <= 0)
			{
				return false;
			}
			return $row_respuesta['idrespuestasencuesta'];
		}
		
		function visualizar($ruta = '')
		{
			require($ruta.'visualizarencuesta.php');
		}
		
		/**
        * @return returns value of variable $idencuesta
        * @desc getIdencuesta : Getting value for variable $idencuesta
        */
        function getPreguntas()
        {
			return $this->preguntas;
        }

        /**
        * @param param : value to be saved in variable $idencuesta
        * @desc setIdencuesta : Setting value for $idencuesta
        */
        function setPreguntas()
        {
            global $db;
			$query_preguntas = "SELECT idpregunta, idtipopregunta, idencuesta, nombrepregunta, codigoestado 
		    FROM pregunta
			where idencuesta = '$this->idencuesta'
			and codigoestado like '1%'";
			
			$preguntas = $db->Execute($query_preguntas);
			$totalRows_preguntas = $preguntas->RecordCount();
			while($row_preguntas = $preguntas->FetchRow()) :
				$pregunta = new pregunta($row_preguntas['idpregunta']); 
				//print_r($pregunta);
        		$this->preguntas[] = $pregunta;
			endwhile;
        }

		/**
        * @return returns value of variable $idencuesta
        * @desc getIdencuesta : Getting value for variable $idencuesta
        */
        function getCodigoestudiante()
        {
                return $this->codigoestudiante;
        }

        /**
        * @param param : value to be saved in variable $idencuesta
        * @desc setIdencuesta : Setting value for $idencuesta
        */
        function setCodigoestudiante($value)
        {
                $this->codigoestudiante = $value;
        }

        /**
        * @return returns value of variable $idencuesta
        * @desc getIdencuesta : Getting value for variable $idencuesta
        */
        function getIdencuesta()
        {
                return $this->idencuesta;
        }

        /**
        * @param param : value to be saved in variable $idencuesta
        * @desc setIdencuesta : Setting value for $idencuesta
        */
        function setIdencuesta($value)
        {
                $this->idencuesta = $value;
        }

        /**
        * @return returns value of variable $nombreencuesta
        * @desc getNombreencuesta : Getting value for variable $nombreencuesta
        */
        function getNombreencuesta()
        {
                return $this->nombreencuesta;
        }

        /**
        * @param param : value to be saved in variable $nombreencuesta
        * @desc setNombreencuesta : Setting value for $nombreencuesta
        */
        function setNombreencuesta($value)
        {
                $this->nombreencuesta = $value;
        }

        /**
        * @return returns value of variable $fechainicioencuesta
        * @desc getFechainicioencuesta : Getting value for variable $fechainicioencuesta
        */
        function getFechainicioencuesta()
        {
                return $this->fechainicioencuesta;
        }

        /**
        * @param param : value to be saved in variable $fechainicioencuesta
        * @desc setFechainicioencuesta : Setting value for $fechainicioencuesta
        */
        function setFechainicioencuesta($value)
        {
                $this->fechainicioencuesta = $value;
        }

        /**
        * @return returns value of variable $fechafinalencuesta
        * @desc getFechafinalencuesta : Getting value for variable $fechafinalencuesta
        */
        function getFechafinalencuesta()
        {
                return $this->fechafinalencuesta;
        }

        /**
        * @param param : value to be saved in variable $fechafinalencuesta
        * @desc setFechafinalencuesta : Setting value for $fechafinalencuesta
        */
        function setFechafinalencuesta($value)
        {
                $this->fechafinalencuesta = $value;
        }

        /**
        * @return returns value of variable $informacionencuesta
        * @desc getInformacionencuesta : Getting value for variable $informacionencuesta
        */
        function getInformacionencuesta()
        {
                return $this->informacionencuesta;
        }

        /**
        * @param param : value to be saved in variable $informacionencuesta
        * @desc setInformacionencuesta : Setting value for $informacionencuesta
        */
        function setInformacionencuesta($value)
        {
                $this->informacionencuesta = $value;
        }

        /**
        * @return returns value of variable $fechacreacionencuesta
        * @desc getFechacreacionencuesta : Getting value for variable $fechacreacionencuesta
        */
        function getFechacreacionencuesta()
        {
                return $this->fechacreacionencuesta;
        }

        /**
        * @param param : value to be saved in variable $fechacreacionencuesta
        * @desc setFechacreacionencuesta : Setting value for $fechacreacionencuesta
        */
        function setFechacreacionencuesta($value)
        {
                $this->fechacreacionencuesta = $value;
        }

        /**
        * @return returns value of variable $codigoestado
        * @desc getCodigoestado : Getting value for variable $codigoestado
        */
        function getCodigoestado()
        {
                return $this->codigoestado;
        }

        /**
        * @param param : value to be saved in variable $codigoestado
        * @desc setCodigoestado : Setting value for $codigoestado
        */
        function setCodigoestado($value)
        {
                $this->codigoestado = $value;
        }

        // This is the destructor for this class
        // Do whatever needs to be done when object no longer needs to be used
        function __destruct()
        {

        }

        // This function will clear all the values of variables in this class
        function emptyInfo()
        {

                $this->setIdencuesta("");
                $this->setNombreencuesta("");
                $this->setFechainicioencuesta("");
                $this->setFechafinalencuesta("");
                $this->setInformacionencuesta("");
                $this->setFechacreacionencuesta("");
                $this->setCodigoestado("");
        }

} 

?> 