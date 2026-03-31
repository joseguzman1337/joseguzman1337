<?php
include_once($ruta."funciones/funciontiempo.php");
class estadocuenta
{ 

        // Variables 
        var $idestadocuenta;
        var $idtipoestadocuenta;
        var $idtipofechacorteestadocuenta;
        var $fechacorteestadocuenta;
        var $diasvencimientosolicitudestadocuenta;
        var $codigoestado;
		
		// Variables de otras tablas que son necesarias para la funcionalidad
		var $codigoestudiante;
		
		function estadocuenta($codigoestudiante)
		{
			global $db;
			$this->codigoestudiante = $codigoestudiante;
			$query_estadocuenta = "select ec.idestadocuenta, ec.idtipoestadocuenta, ec.idtipofechacorteestadocuenta, ec.fechacorteestadocuenta, ec.diasvencimientosolicitudestadocuenta, ec.codigoestado
			from estadocuenta ec, estudiante e, estudianteestadocuenta eec
			where eec.idestudiantegeneral = e.idestudiantegeneral
			and e.codigoestudiante = '$this->codigoestudiante'
			and ec.idestadocuenta = eec.idestadocuenta
			and ec.codigoestado like '1%'
			and eec.codigoestado like '1%'";
			$estadocuentas = $db->Execute($query_estadocuenta);
			//print_r($db);
			$totalRows_estadocuenta = $estadocuentas->RecordCount();
			if($totalRows_estadocuenta == '')
			{
				$query_estadocuenta = "SELECT idestadocuenta, idtipoestadocuenta, idtipofechacorteestadocuenta, fechacorteestadocuenta, diasvencimientosolicitudestadocuenta, codigoestado 
			    FROM estadocuenta
				where codigoestado like '1%'";
				$estadocuentas = $db->Execute($query_estadocuenta);
				$totalRows_estadocuenta = $estadocuentas->RecordCount();
			}
			$row_estadocuenta = $estadocuentas->FetchRow(); 
			$this->idestadocuenta = $row_estadocuenta['idestadocuenta'];
			$this->idtipoestadocuenta = $row_estadocuenta['idtipoestadocuenta'];
			$this->idtipofechacorteestadocuenta = $row_estadocuenta['idtipofechacorteestadocuenta'];
			$this->fechacorteestadocuenta = $row_estadocuenta['fechacorteestadocuenta'];
			$this->diasvencimientosolicitudestadocuenta = $row_estadocuenta['diasvencimientosolicitudestadocuenta'];
			$this->codigoestado = $row_estadocuenta['codigoestado'];
		}
        
		function guardarEstudianteestadocuenta($respuesta, $observacion,$valordeuda,$valorafavor)
		{
			global $db;
			$query_upd = "update estudianteestadocuenta ee, estudiante e
			set codigoestado = '200'
			where e.codigoestudiante = '$this->codigoestudiante'
			and ee.idestudiantegeneral = e.idestudiantegeneral
			and ee.codigoestado = '100'";
			$upd = $db->Execute($query_upd);
			$query_ins = "INSERT INTO estudianteestadocuenta(idestudianteestadocuenta, idestadocuenta, idestudiantegeneral, respuestaestudianteestadocuenta, fechaestudianteestadocuenta, observacionestudianteestadocuenta, valordeuda, saldoafavor,codigoestado) 
			select 0 as idestudianteestadocuenta, '$this->idestadocuenta' as idestadocuenta, idestudiantegeneral, '$respuesta' as respuestaestudianteestadocuenta, now() as fechaestudianteestadocuenta, '$observacion' as observacionestudianteestadocuenta, '$valordeuda' as valordeuda, '$valorafavor' as saldoafavor, '100' as codigoestado
			from estudiante 
			where codigoestudiante = '$this->codigoestudiante'";
			$ins = $db->Execute($query_ins);
		}
		
		/**
        * @return returns value true or false de acuerdo a si tiene estado de cuenta activa o no
        * @desc tieneEstadocuentaactiva : Mira si tiene estado de cuenta activa para el estudiante
        */
        function tieneEstadocuentaactiva()
        {
				global $db;
				// Mira si el estudiante tiene estado de cuenta activa
				$query_estadocuenta = "select eec.idestudianteestadocuenta, eec.idestadocuenta, 
				eec.idestudiantegeneral, eec.respuestaestudianteestadocuenta, eec.fechaestudianteestadocuenta, 
				eec.observacionestudianteestadocuenta, eec.codigoestado 
				from estadocuenta ec, estudiante e, estudianteestadocuenta eec
				where eec.idestudiantegeneral = e.idestudiantegeneral
				and e.codigoestudiante = '$this->codigoestudiante'
				and ec.idestadocuenta = eec.idestadocuenta
				and ec.codigoestado like '1%'
				and eec.codigoestado like '1%'";
				$estadocuenta = $db->Execute($query_estadocuenta);
				$totalRows_estadocuenta = $estadocuenta->RecordCount();
				$row_estadocuenta = $estadocuenta->FetchRow(); 
				if($totalRows_estadocuenta == "")
				{
					return false;
				}
				// Calcula el número de días desde la fechaestudianteestadocuenta hasta la fecha de hoy
				//echo $row_estadocuenta['fechaestudianteestadocuenta'];
				$dias = restarfecha(date("Y-m-d H:i:s"), $row_estadocuenta['fechaestudianteestadocuenta']);
				//echo $dias;
				if($dias >= 0)
				{
					if($dias >= $this->diasvencimientosolicitudestadocuenta)
					{
						return false;
					}
				}
                return true;
        }

		/**
        * @param param : value to be saved in variable $idestadocuenta
        * @desc get : Setting value for $idestadocuenta
        */
        function getTipoestadocuenta()
        {
               	global $db;
				// Mira si el estudiante tiene estado de cuenta activa
				$query_tipoestadocuenta = "SELECT idtipoestadocuenta, nombretipoestadocuenta, codigoestado 
				FROM tipoestadocuenta
				where idtipoestadocuenta = '$this->idtipoestadocuenta'";
				$tipoestadocuenta = $db->Execute($query_tipoestadocuenta);
				$totalRows_tipoestadocuenta = $tipoestadocuenta->RecordCount();
				$row_tipoestadocuenta = $tipoestadocuenta->FetchRow(); 
				return $row_tipoestadocuenta['nombretipoestadocuenta']; 
        }
		
		/**
        * @param param : value to be saved in variable $idestadocuenta
        * @desc get : Setting value for $idestadocuenta
        */
        function getTipofechacorteestadocuenta()
        {
               	global $db;
				// Mira si el estudiante tiene estado de cuenta activa
				$query_tipofechacorteestadocuenta = "SELECT idtipofechacorteestadocuenta, nombretipofechacorteestadocuenta, codigoestado 
			    FROM tipofechacorteestadocuenta
				where idtipofechacorteestadocuenta = '$this->idtipofechacorteestadocuenta'";
				$tipofechacorteestadocuenta = $db->Execute($query_tipofechacorteestadocuenta);
				$totalRows_tipofechacorteestadocuenta = $tipofechacorteestadocuenta->RecordCount();
				$row_tipofechacorteestadocuenta = $tipofechacorteestadocuenta->FetchRow(); 
				return $row_tipofechacorteestadocuenta['nombretipofechacorteestadocuenta']; 
        }
		
			
		/**
        * @return returns value of variable $idestadocuenta
        * @desc getIdestadocuenta : Getting value for variable $idestadocuenta
        */
        function getIdestadocuenta()
        {
                return $this->idestadocuenta;
        }

        /**
        * @param param : value to be saved in variable $idestadocuenta
        * @desc setIdestadocuenta : Setting value for $idestadocuenta
        */
        function setIdestadocuenta($value)
        {
                $this->idestadocuenta = $value;
        }

        /**
        * @return returns value of variable $idtipoestadocuenta
        * @desc getIdtipoestadocuenta : Getting value for variable $idtipoestadocuenta
        */
        function getIdtipoestadocuenta()
        {
				// Si el tipoestadocuenta es 100 se le debe mostrar al estudiante las deudas vencidas
				// Si es 200 se le deben mostrar las deudas que estan por vencersen
				// Si es 300 se le deben mostrar todas las deudas
                return $this->idtipoestadocuenta;
        }

        /**
        * @param param : value to be saved in variable $idtipoestadocuenta
        * @desc setIdtipoestadocuenta : Setting value for $idtipoestadocuenta
        */
        function setIdtipoestadocuenta($value)
        {
                $this->idtipoestadocuenta = $value;
        }

        /**
        * @return returns value of variable $idtipofechacorteestadocuenta
        * @desc getIdtipofechacorteestadocuenta : Getting value for variable $idtipofechacorteestadocuenta
        */
        function getIdtipofechacorteestadocuenta()
        {
                return $this->idtipofechacorteestadocuenta;
        }

        /**
        * @param param : value to be saved in variable $idtipofechacorteestadocuenta
        * @desc setIdtipofechacorteestadocuenta : Setting value for $idtipofechacorteestadocuenta
        */
        function setIdtipofechacorteestadocuenta($value)
        {
                $this->idtipofechacorteestadocuenta = $value;
        }

        /**
        * @return returns value of variable $fechacorteestadocuenta
        * @desc getFechacorteestadocuenta : Getting value for variable $fechacorteestadocuenta
        */
        function getFechacorteestadocuenta()
        {
                return $this->fechacorteestadocuenta;
        }

        /**
        * @param param : value to be saved in variable $fechacorteestadocuenta
        * @desc setFechacorteestadocuenta : Setting value for $fechacorteestadocuenta
        */
        function setFechacorteestadocuenta($value)
        {
                $this->fechacorteestadocuenta = $value;
        }

        /**
        * @return returns value of variable $diasvencimientosolicitudestadoencuesta
        * @desc getDiasvencimientosolicitudestadoencuesta : Getting value for variable $diasvencimientosolicitudestadoencuesta
        */
        function getDiasvencimientosolicitudestadoencuesta()
        {
                return $this->diasvencimientosolicitudestadoencuesta;
        }

        /**
        * @param param : value to be saved in variable $diasvencimientosolicitudestadoencuesta
        * @desc setDiasvencimientosolicitudestadoencuesta : Setting value for $diasvencimientosolicitudestadoencuesta
        */
        function setDiasvencimientosolicitudestadoencuesta($value)
        {
                $this->diasvencimientosolicitudestadoencuesta = $value;
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

                $this->setIdestadocuenta("");
                $this->setIdtipoestadocuenta("");
                $this->setIdtipofechacorteestadocuenta("");
                $this->setFechacorteestadocuenta("");
                $this->setDiasvencimientosolicitudestadoencuesta("");
                $this->setCodigoestado("");
        }

        // This is the destructor for this class
        // Do whatever needs to be done when object no longer needs to be used
        function __destruct()
        {

        }

        // This function will clear all the values of variables in this class
        function emptyInfo()
        {

                $this->setIdestadocuenta("");
                $this->setIdtipoestadocuenta("");
                $this->setIdtipofechacorteestadocuenta("");
                $this->setFechacorteestadocuenta("");
                $this->setDiasvencimientosolicitudestadoencuesta("");
                $this->setCodigoestado("");
        }

} 

?> 
