<?php
class planestudio
{
	// Variables
	var $idplanestudio;
	var $nombreplanestudio;
	var $codigocarrera;
	var $responsableplanestudio;
	var $cargoresponsableplanestudio;
	var $numeroautorizacionplanestudio;
	var $cantidadsemestresplanestudio;
	var $fechacreacionplanestudio;
	var $fechainioplanestudio;
	var $fechavencimientoplanestudio;
	var $codigoestadoplanestudio;
	var $codigotipocantidadelectivalibre;
	var $cantidadelectivalibre;

	// This is the constructor for this class
	// Initialize all your default variables here
	function planestudio($idplanestudio)
	{
		global $db;

		$query = "SELECT idplanestudio, nombreplanestudio, codigocarrera, responsableplanestudio, cargoresponsableplanestudio, numeroautorizacionplanestudio, cantidadsemestresplanestudio, fechacreacionplanestudio, fechainioplanestudio, fechavencimientoplanestudio, codigoestadoplanestudio, codigotipocantidadelectivalibre, cantidadelectivalibre 
		FROM planestudio
		where idplanestudio = '$idplanestudio'";
		$rta = $db->Execute($query);
		$totalRows_rta = $rta->RecordCount();
		$row_rta = $rta->FetchRow();
		$this->idplanestudio = $row_rta['idplanestudio'];
		$this->nombreplanestudio = $row_rta['nombreplanestudio'];
		$this->codigocarrera = $row_rta['codigocarrera'];
		$this->responsableplanestudio = $row_rta['responsableplanestudio'];
		$this->cargoresponsableplanestudio = $row_rta['cargoresponsableplanestudio'];
		$this->numeroautorizacionplanestudio = $row_rta['numeroautorizacionplanestudio'];
		$this->cantidadsemestresplanestudio = $row_rta['cantidadsemestresplanestudio'];
		$this->fechacreacionplanestudio = $row_rta['fechacreacionplanestudio'];
		$this->fechainioplanestudio = $row_rta['fechainioplanestudio'];
		$this->fechavencimientoplanestudio = $row_rta['fechavencimientoplanestudio'];
		$this->codigoestadoplanestudio = $row_rta['codigoestadoplanestudio'];
		$this->codigotipocantidadelectivalibre = $row_rta['codigotipocantidadelectivalibre'];
		$this->cantidadelectivalibre = $row_rta['cantidadelectivalibre'];
	}

	/**
	 * @return muestra el plan de estudios
	 * @desc muestraplanestudio : Muestra el plan de estudios
	 */
	function mostrarPlanEstudio()
	{
?>
<p>PLAN DE ESTUDIO</p>
<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="100%">
  <tr id="trtitulogris">
  	<td>Nº Plan Estudio</td>
	<td>Nombre</td>
	<td>Fecha</td>
  </tr>
  <tr>
	<td><?php echo $this->idplanestudio; ?></td>
	<td>	 <?php echo $this->nombreplanestudio; ?>	  </td>
	<td><?php echo ereg_replace("[0-9]+:[0-9]+:[0-9]+","",$this->fechacreacionplanestudio); ?></td>
  </tr>
  <tr id="trtitulogris">
  	<td colspan="2">Nombre Encargado</td> 
  	<td>Cargo</td>
  </tr>
  <tr>
	<td  colspan="2"><?php echo $this->responsableplanestudio; ?>	
	  </td>
	<td><?php echo $this->cargoresponsableplanestudio; ?>	
	  </td>
  </tr>
  <tr id="trtitulogris">
  	<td>Nº Semestres</td>
  	<td>Carrera</td>
	<td>Autorización Nº</td>
  </tr>
  <tr>
  	<td><?php echo $this->cantidadsemestresplanestudio; ?></td>
	<td><?php echo $this->getNombreCarrera(); ?></td>
	<td><?php echo $this->numeroautorizacionplanestudio; ?></td>
  </tr>
 <tr>
	<td id="tdtitulogris">Fecha de Inicio</td>
	<td id="tdtitulogris">Fecha de Vencimiento</td>
	<td rowspan="2">&nbsp;</td>
  </tr>
  <tr>
	<td><?php echo ereg_replace("[0-9]+:[0-9]+:[0-9]+","",$this->fechainioplanestudio); ?></td>
	<td><?php echo ereg_replace("[0-9]+:[0-9]+:[0-9]+","",$this->fechavencimientoplanestudio); ?></td>
  </tr>
</table>
<?php
	}
	
	
	/**
	 * @return returns value of variable $idplanestudio
	 * @desc getNombreCarrera : Trae el nombre de la carrera
	 */
	function getNombreCarrera()
	{
		global $db;
		$query = "SELECT nombrecarrera 
		FROM carrera
		where codigocarrera = '$this->codigocarrera'";
		$rta = $db->Execute($query);
		$totalRows_rta = $rta->RecordCount();
		$row_rta = $rta->FetchRow();
		
		return $row_rta['nombrecarrera'];;
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
	 * @return returns value of variable $nombreplanestudio
	 * @desc getNombreplanestudio : Getting value for variable $nombreplanestudio
	 */
	function getNombreplanestudio()
	{
		return $this->nombreplanestudio;
	}

	/**
	 * @param param : value to be saved in variable $nombreplanestudio
	 * @desc setNombreplanestudio : Setting value for $nombreplanestudio
	 */
	function setNombreplanestudio($value)
	{
		$this->nombreplanestudio = $value;
	}

	/**
	 * @return returns value of variable $codigocarrera
	 * @desc getCodigocarrera : Getting value for variable $codigocarrera
	 */
	function getCodigocarrera()
	{
		return $this->codigocarrera;
	}

	/**
	 * @param param : value to be saved in variable $codigocarrera
	 * @desc setCodigocarrera : Setting value for $codigocarrera
	 */
	function setCodigocarrera($value)
	{
		$this->codigocarrera = $value;
	}

	/**
	 * @return returns value of variable $responsableplanestudio
	 * @desc getResponsableplanestudio : Getting value for variable $responsableplanestudio
	 */
	function getResponsableplanestudio()
	{
		return $this->responsableplanestudio;
	}

	/**
	 * @param param : value to be saved in variable $responsableplanestudio
	 * @desc setResponsableplanestudio : Setting value for $responsableplanestudio
	 */
	function setResponsableplanestudio($value)
	{
		$this->responsableplanestudio = $value;
	}

	/**
	 * @return returns value of variable $cargoresponsableplanestudio
	 * @desc getCargoresponsableplanestudio : Getting value for variable $cargoresponsableplanestudio
	 */
	function getCargoresponsableplanestudio()
	{
		return $this->cargoresponsableplanestudio;
	}

	/**
	 * @param param : value to be saved in variable $cargoresponsableplanestudio
	 * @desc setCargoresponsableplanestudio : Setting value for $cargoresponsableplanestudio
	 */
	function setCargoresponsableplanestudio($value)
	{
		$this->cargoresponsableplanestudio = $value;
	}

	/**
	 * @return returns value of variable $numeroautorizacionplanestudio
	 * @desc getNumeroautorizacionplanestudio : Getting value for variable $numeroautorizacionplanestudio
	 */
	function getNumeroautorizacionplanestudio()
	{
		return $this->numeroautorizacionplanestudio;
	}

	/**
	 * @param param : value to be saved in variable $numeroautorizacionplanestudio
	 * @desc setNumeroautorizacionplanestudio : Setting value for $numeroautorizacionplanestudio
	 */
	function setNumeroautorizacionplanestudio($value)
	{
		$this->numeroautorizacionplanestudio = $value;
	}

	/**
	 * @return returns value of variable $cantidadsemestresplanestudio
	 * @desc getCantidadsemestresplanestudio : Getting value for variable $cantidadsemestresplanestudio
	 */
	function getCantidadsemestresplanestudio()
	{
		return $this->cantidadsemestresplanestudio;
	}

	/**
	 * @param param : value to be saved in variable $cantidadsemestresplanestudio
	 * @desc setCantidadsemestresplanestudio : Setting value for $cantidadsemestresplanestudio
	 */
	function setCantidadsemestresplanestudio($value)
	{
		$this->cantidadsemestresplanestudio = $value;
	}

	/**
	 * @return returns value of variable $fechacreacionplanestudio
	 * @desc getFechacreacionplanestudio : Getting value for variable $fechacreacionplanestudio
	 */
	function getFechacreacionplanestudio()
	{
		return $this->fechacreacionplanestudio;
	}

	/**
	 * @param param : value to be saved in variable $fechacreacionplanestudio
	 * @desc setFechacreacionplanestudio : Setting value for $fechacreacionplanestudio
	 */
	function setFechacreacionplanestudio($value)
	{
		$this->fechacreacionplanestudio = $value;
	}

	/**
	 * @return returns value of variable $fechainioplanestudio
	 * @desc getFechainioplanestudio : Getting value for variable $fechainioplanestudio
	 */
	function getFechainioplanestudio()
	{
		return $this->fechainioplanestudio;
	}

	/**
	 * @param param : value to be saved in variable $fechainioplanestudio
	 * @desc setFechainioplanestudio : Setting value for $fechainioplanestudio
	 */
	function setFechainioplanestudio($value)
	{
		$this->fechainioplanestudio = $value;
	}

	/**
	 * @return returns value of variable $fechavencimientoplanestudio
	 * @desc getFechavencimientoplanestudio : Getting value for variable $fechavencimientoplanestudio
	 */
	function getFechavencimientoplanestudio()
	{
		return $this->fechavencimientoplanestudio;
	}

	/**
	 * @param param : value to be saved in variable $fechavencimientoplanestudio
	 * @desc setFechavencimientoplanestudio : Setting value for $fechavencimientoplanestudio
	 */
	function setFechavencimientoplanestudio($value)
	{
		$this->fechavencimientoplanestudio = $value;
	}

	/**
	 * @return returns value of variable $codigoestadoplanestudio
	 * @desc getCodigoestadoplanestudio : Getting value for variable $codigoestadoplanestudio
	 */
	function getCodigoestadoplanestudio()
	{
		return $this->codigoestadoplanestudio;
	}

	/**
	 * @param param : value to be saved in variable $codigoestadoplanestudio
	 * @desc setCodigoestadoplanestudio : Setting value for $codigoestadoplanestudio
	 */
	function setCodigoestadoplanestudio($value)
	{
		$this->codigoestadoplanestudio = $value;
	}

	/**
	 * @return returns value of variable $codigotipocantidadelectivalibre
	 * @desc getCodigotipocantidadelectivalibre : Getting value for variable $codigotipocantidadelectivalibre
	 */
	function getCodigotipocantidadelectivalibre()
	{
		return $this->codigotipocantidadelectivalibre;
	}

	/**
	 * @param param : value to be saved in variable $codigotipocantidadelectivalibre
	 * @desc setCodigotipocantidadelectivalibre : Setting value for $codigotipocantidadelectivalibre
	 */
	function setCodigotipocantidadelectivalibre($value)
	{
		$this->codigotipocantidadelectivalibre = $value;
	}

	/**
	 * @return returns value of variable $cantidadelectivalibre
	 * @desc getCantidadelectivalibre : Getting value for variable $cantidadelectivalibre
	 */
	function getCantidadelectivalibre()
	{
		return $this->cantidadelectivalibre;
	}

	/**
	 * @param param : value to be saved in variable $cantidadelectivalibre
	 * @desc setCantidadelectivalibre : Setting value for $cantidadelectivalibre
	 */
	function setCantidadelectivalibre($value)
	{
		$this->cantidadelectivalibre = $value;
	}
}

?>