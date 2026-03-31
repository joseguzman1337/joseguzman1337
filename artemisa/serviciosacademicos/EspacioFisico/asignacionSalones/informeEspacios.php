<?php
// echo "<pre>"; print_r($_REQUEST);
include("../templates/template.php");
$db = getBD();

/**
* Clase para realizar la consulta de salones ocupados y libres en el día o dentro de un rago de horas.
*/
class InformeEspacios
{
	private $listaSalonesOcupados;
	private $querySalonOcupado;
	public function __construct() {}
	function salonesOcupados($fecha){
		$this->querySalonOcupado = "SELECT ce1.Nombre as ubicacion, ce.ClasificacionEspaciosId, ce.Nombre as Espacio,ts.nombretiposalon ,ce.CapacidadEstudiantes,ce.AccesoDiscapacitados,ae.FechaAsignacion, ae.HoraInicio, ae.HoraFin
		FROM AsignacionEspacios ae 
		INNER JOIN ClasificacionEspacios ce ON ce.ClasificacionEspaciosId = ae.ClasificacionEspaciosId
		INNER JOIN tiposalon ts ON ts.codigotiposalon=ce.codigotiposalon
		INNER JOIN ClasificacionEspacios ce1 ON ce.ClasificacionEspacionPadreId = ce1.ClasificacionEspaciosId
		where ae.FechaAsignacion='".$fecha."' 
		AND ae.HoraInicio >= '06:00:00'
		AND ae.HoraFin <=  '22:00:00'  
		ORDER BY ce.Nombre, ae.HoraInicio
		";
		$ejecutaQuerySalonOcupado = mysql_query($this->querySalonOcupado);
		while ($row = mysql_fetch_object($ejecutaQuerySalonOcupado)) {
			$this->listaSalonesOcupados[$fecha][] = array(
				'Ubicacion' => $row->ubicacion
				,'Nombre' => $row->Espacio
				,'tipoSalon' => $row->nombretiposalon
				,'capacidadEstudiantes' => $row->CapacidadEstudiantes
				,'accesoDiscapacitados' => $row->AccesoDiscapacitados
				,'horaInicio' => $row->HoraInicio
				,'horaFin' => $row->HoraFin
				);
		}
	}
	function retornarListaSalonesOcupados(){
		echo json_encode($this->listaSalonesOcupados);
	}
}
$informeEspacios1 = new InformeEspacios();
foreach ($_REQUEST['Fechas'] as $key => $value) {
	$informeEspacios1->salonesOcupados($value);
}
$informeEspacios1->retornarListaSalonesOcupados();
unset($informeEspacios1);

?>