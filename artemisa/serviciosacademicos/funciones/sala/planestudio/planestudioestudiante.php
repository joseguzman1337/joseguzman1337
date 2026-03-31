<?php
class planestudioestudiante
{

	// Variables
	var $idplanestudio;
	var $codigoestudiante;
	var $fechaasignacionplanestudioestudiante;
	var $fechainicioplanestudioestudiante;
	var $fechavencimientoplanestudioestudiante;
	var $codigoestadoplanestudioestudiante;
	var $idlineaenfasisplanestudio;

	// This is the constructor for this class
	// Initialize all your default variables here
	function planestudioestudiante($codigoestudiante)
	{
		global $db;

		$query = "SELECT idplanestudio, codigoestudiante, fechaasignacionplanestudioestudiante, fechainicioplanestudioestudiante, fechavencimientoplanestudioestudiante, codigoestadoplanestudioestudiante 
		FROM planestudioestudiante
		where codigoestudiante = '$codigoestudiante'
		and codigoestadoplanestudioestudiante like '1%'";
		$rta = $db->Execute($query);
		$totalRows_rta = $rta->RecordCount();
		$row_rta = $rta->FetchRow();

		$this->idplanestudio = $row_rta['idplanestudio'];
		$this->codigoestudiante = $row_rta['codigoestudiante'];
		$this->fechaasignacionplanestudioestudiante = $row_rta['fechaasignacionplanestudioestudiante'];
		$this->fechainicioplanestudioestudiante = $row_rta['fechainicioplanestudioestudiante'];
		$this->fechavencimientoplanestudioestudiante = $row_rta['fechavencimientoplanestudioestudiante'];
		$this->codigoestadoplanestudioestudiante = $row_rta['codigoestadoplanestudioestudiante'];
		$this->idlineaenfasisplanestudio = $this->getIdlineaenfasisplanestudio();
	}
	
	/**
	 * @return returns value of variable $idplanestudio
	 * @desc getIdlineaenfasis : Getting value for variable $idplanestudio
	 */
	function getIdlineaenfasisplanestudio()
	{
		global $db;
		$query = "SELECT idplanestudio, idlineaenfasisplanestudio, codigoestudiante, fechaasignacionfechainiciolineaenfasisestudiante, fechainiciolineaenfasisestudiante, fechavencimientolineaenfasisestudiante 
		FROM lineaenfasisestudiante
		where codigoestudiante = '$this->codigoestudiante'
		and now() between fechainiciolineaenfasisestudiante and fechavencimientolineaenfasisestudiante";
		$rta = $db->Execute($query);
		$totalRows_rta = $rta->RecordCount();
		$row_rta = $rta->FetchRow();
		return $row_rta['idlineaenfasisplanestudio']; 
	}
	
	/**
	 * @return returns value of variable $idplanestudio
	 * @desc getIdplanestudio : Getting value for variable $idplanestudio
	 */
	function getIdplanestudio()
	{
		return $this->idplanestudio;
	}

	/**
	 * @param param : value to be saved in variable $idplanestudio
	 * @desc setIdplanestudio : Setting value for $idplanestudio
	 */
	function setIdplanestudio($value)
	{
		$this->idplanestudio = $value;
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
	 * @return returns value of variable $fechaasignacionplanestudioestudiante
	 * @desc getFechaasignacionplanestudioestudiante : Getting value for variable $fechaasignacionplanestudioestudiante
	 */
	function getFechaasignacionplanestudioestudiante()
	{
		return $this->fechaasignacionplanestudioestudiante;
	}

	/**
	 * @param param : value to be saved in variable $fechaasignacionplanestudioestudiante
	 * @desc setFechaasignacionplanestudioestudiante : Setting value for $fechaasignacionplanestudioestudiante
	 */
	function setFechaasignacionplanestudioestudiante($value)
	{
		$this->fechaasignacionplanestudioestudiante = $value;
	}

	/**
	 * @return returns value of variable $fechainicioplanestudioestudiante
	 * @desc getFechainicioplanestudioestudiante : Getting value for variable $fechainicioplanestudioestudiante
	 */
	function getFechainicioplanestudioestudiante()
	{
		return $this->fechainicioplanestudioestudiante;
	}

	/**
	 * @param param : value to be saved in variable $fechainicioplanestudioestudiante
	 * @desc setFechainicioplanestudioestudiante : Setting value for $fechainicioplanestudioestudiante
	 */
	function setFechainicioplanestudioestudiante($value)
	{
		$this->fechainicioplanestudioestudiante = $value;
	}

	/**
	 * @return returns value of variable $fechavencimientoplanestudioestudiante
	 * @desc getFechavencimientoplanestudioestudiante : Getting value for variable $fechavencimientoplanestudioestudiante
	 */
	function getFechavencimientoplanestudioestudiante()
	{
		return $this->fechavencimientoplanestudioestudiante;
	}

	/**
	 * @param param : value to be saved in variable $fechavencimientoplanestudioestudiante
	 * @desc setFechavencimientoplanestudioestudiante : Setting value for $fechavencimientoplanestudioestudiante
	 */
	function setFechavencimientoplanestudioestudiante($value)
	{
		$this->fechavencimientoplanestudioestudiante = $value;
	}

	/**
	 * @return returns value of variable $codigoestadoplanestudioestudiante
	 * @desc getCodigoestadoplanestudioestudiante : Getting value for variable $codigoestadoplanestudioestudiante
	 */
	function getCodigoestadoplanestudioestudiante()
	{
		return $this->codigoestadoplanestudioestudiante;
	}

	/**
	 * @param param : value to be saved in variable $codigoestadoplanestudioestudiante
	 * @desc setCodigoestadoplanestudioestudiante : Setting value for $codigoestadoplanestudioestudiante
	 */
	function setCodigoestadoplanestudioestudiante($value)
	{
		$this->codigoestadoplanestudioestudiante = $value;
	}
}

?>