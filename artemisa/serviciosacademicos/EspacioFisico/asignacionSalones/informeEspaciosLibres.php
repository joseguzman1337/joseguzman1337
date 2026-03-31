<?php
// echo "<pre>"; print_r($_REQUEST);

include("../templates/template.php");

/**
* Clase para realizar la consulta de salones ocupados y libres en el día o dentro de un rago de horas.
*/
class InformeEspacios
{       
   
	private $listaSalonesOcupados;
	private $arregloBloquesSede;
	private $querySalonOcupado;
	private $arregloSalonLibres;
    private $db;
	public function __construct() {
	   $this->db = getBD();
	}
	function salonesOcupados($fecha,$hIS,$hFS,$accesoDiscapacitados){
		$this->querySalonOcupado = "SELECT ce1.Nombre as ubicacion, ce.ClasificacionEspaciosId, ce.Nombre as Espacio,ts.nombretiposalon ,ce.CapacidadEstudiantes,ce.AccesoDiscapacitados,ae.FechaAsignacion, ae.HoraInicio, ae.HoraFin
                            		FROM AsignacionEspacios ae 
                            		INNER JOIN ClasificacionEspacios ce ON ce.ClasificacionEspaciosId = ae.ClasificacionEspaciosId
                            		INNER JOIN tiposalon ts ON ts.codigotiposalon=ce.codigotiposalon
                            		INNER JOIN ClasificacionEspacios ce1 ON ce.ClasificacionEspacionPadreId = ce1.ClasificacionEspaciosId
                            		where ae.FechaAsignacion='".$fecha."' 
                            		AND ae.HoraInicio >= '".$hIS."'
                            		AND ae.HoraFin <=  '".$hFS."' 
                            		AND ce.AccesoDiscapacitados >= '".$accesoDiscapacitados."'  
                            		ORDER BY ce.Nombre, ae.HoraInicio";
		$ejecutaQuerySalonOcupado = mysql_query($this->querySalonOcupado);	
		while ($row = mysql_fetch_object($ejecutaQuerySalonOcupado)) {
			$this->listaSalonesOcupados[$fecha][$row->ClasificacionEspaciosId][] = array(
				'Ubicacion' => $row->ubicacion
				,'Nombre' => $row->Espacio
				,'codigoTipoSalon' => $row->ClasificacionEspaciosId
				,'tipoSalon' => $row->nombretiposalon
				,'capacidadEstudiantes' => $row->CapacidadEstudiantes
				,'accesoDiscapacitados' => $row->AccesoDiscapacitados
				,'horaInicio' => $row->HoraInicio
				,'horaFin' => $row->HoraFin
                ,'=(' => 'Puede llorrar'
				);
		}
	$consultaSalonesTodoElDia = "SELECT ce1.Nombre as ubicacion, ce.ClasificacionEspaciosId, ce.Nombre as Espacio,ts.nombretiposalon,ce.CapacidadEstudiantes, ce.AccesoDiscapacitados
                            		FROM AsignacionEspacios ae 
                            		INNER JOIN ClasificacionEspacios ce ON ce.ClasificacionEspaciosId = ae.ClasificacionEspaciosId
                            		INNER JOIN tiposalon ts ON ts.codigotiposalon=ce.codigotiposalon
                            		INNER JOIN ClasificacionEspacios ce1 ON ce.ClasificacionEspacionPadreId = ce1.ClasificacionEspaciosId
                            		where ce.ClasificacionEspaciosId NOT IN (
                            			SELECT ce.ClasificacionEspaciosId
                            			FROM AsignacionEspacios ae 
                            			INNER JOIN ClasificacionEspacios ce ON ce.ClasificacionEspaciosId = ae.ClasificacionEspaciosId
                            			INNER JOIN tiposalon ts ON ts.codigotiposalon=ce.codigotiposalon
                            			INNER JOIN ClasificacionEspacios ce1 ON ce.ClasificacionEspacionPadreId = ce1.ClasificacionEspaciosId
                            			where ae.FechaAsignacion='".$fecha."' 
                            			AND ae.HoraInicio >= '".$hIS."'
                            			AND ae.HoraFin <=  '".$hFS."'  
                            			ORDER BY ce.Nombre, ae.HoraInicio)";
                                        
		$ejecutaQuerySalonOcupado = mysql_query($consultaSalonesTodoElDia);
		while ($row = mysql_fetch_object($ejecutaQuerySalonOcupado)) {
			$this->arregloSalonLibres[$fecha][$row->ClasificacionEspaciosId] = array(
				'Ubicacion' => $row->ubicacion,
				'Nombre' => $row->Espacio,
				'tipoSalon' => $row->nombretiposalon,
				'capacidadEstudiantes' => $row->CapacidadEstudiantes,
				'accesoDiscapacitados' => $row->AccesoDiscapacitados,
				'horaInicio' => $hIS,
				'horaFin' => $hFS
                ,'=(' => 'Puede llorrar...2'
				);
		}
	}
	function salonesLibres($hIS,$hFS,$fecha){ 
	   echo '<pre>';print_r($this->listaSalonesOcupados[$fecha]);die;
	  	foreach ($this->listaSalonesOcupados[$fecha] as $key => $value) {
			$horaInicioSolicitud = $hIS;
			$horaFinSolicitud = $hFS;
			$control = count($value)-1;
			for ($i=0; $i < count($value); $i++) { 
			
                $diferencia = $value[$i]['horaInicio']-$horaInicioSolicitud;
               
                
				if ($diferencia == 0){
					continue;
				}else{
					$this->arregloSalonLibres[$fecha][$value[$i]['codigoTipoSalon']][] = array(
						'Ubicacion' => $value[$i]['Ubicacion']
						,'Nombre' => $value[$i]['Nombre']
						,'tipoSalon' => $value[$i]['tipoSalon']
						,'capacidadEstudiantes' => $value[$i]['capacidadEstudiantes']
						,'accesoDiscapacitados' => $value[$i]['accesoDiscapacitados']
						,'HoraInicio' => $horaInicioSolicitud
						,'HoraFin' => $value[$i]['horaInicio']
                        ,'=)' => 'aque caja......'
					);
					$horaInicioSolicitud = $value[$i]['horaFin'];
					$hf = $value['horaFin'];
					$controlFinEvento = $horaFinSolicitud - $horaInicioSolicitud;
					if ($i==$control && $controlFinEvento) {
						$this->arregloSalonLibres[$fecha][$value[$i]['codigoTipoSalon']][] = array(
						'Ubicacion' => $value[$i]['Ubicacion']
						,'Nombre' => $value[$i]['Nombre']
						,'tipoSalon' => $value[$i]['tipoSalon']
						,'capacidadEstudiantes' => $value[$i]['capacidadEstudiantes']
						,'accesoDiscapacitados' => $value[$i]['accesoDiscapacitados']
						,'HoraInicio' => $horaInicioSolicitud
						,'HoraFin' => $horaFinSolicitud
                        ,'=)' => 'aque caja'
						);
					}
				}
			}
		}
	}
	function listaSalonesPorSede(){
		$listaSedes = array(4 => 'Usaquen', 5 => 'Chia');
        //$Sedes = $this->SedesCampus();
        //echo '<pre>';print_r($Sedes);die;
		foreach ($listaSedes as $codigoSede => $NombreSede) {
			$listaBloquesPorSede = "SELECT ce.ClasificacionEspaciosId, ce.Nombre from ClasificacionEspacios ce
								WHERE  ce.ClasificacionEspacionPadreId = ".$codigoSede." ";
			$ejecutaListaBloquesPorSede = mysql_query($listaBloquesPorSede);
			while ($row1 = mysql_fetch_object($ejecutaListaBloquesPorSede)) {
				$listaSalonPorBloque = "SELECT ce.ClasificacionEspaciosId, ce.Nombre from ClasificacionEspacios ce
										WHERE  ce.ClasificacionEspacionPadreId = ".$row1->ClasificacionEspaciosId." ";
				$ejecutaListaSalonPorBloque = mysql_query($listaSalonPorBloque);
				while ($row2 = mysql_fetch_object($ejecutaListaSalonPorBloque)) {
					$this->arregloBloquesSede[$row1->ClasificacionEspaciosId][$row2->ClasificacionEspaciosId] = $row2->Nombre;
				}
			}
		}
	}
	function imprimir(){
		echo "<pre>"; print_r($this->arregloSalonLibres);
		// echo "<pre>"; print_r($this->listaSalonesOcupados);
		// echo "<pre>"; print_r($this->arregloBloquesSede);
	}
	function retornarListaSalonesLibres(){
		echo json_encode($this->arregloSalonLibres);
	}
    function SedesCampus(){
      
        $SQL='SELECT ClasificacionEspaciosId AS id, Nombre FROM ClasificacionEspacios WHERE EspaciosFisicosId =3';
        
        if($Campus=$this->db->Execute($SQL)===false){
            echo 'Error en el SQL de Campus...<br><br>'.$SQL;
            die;
        }
        if($Campus){
            echo 'entro..';
        } 
        //$C_campus = $Campus->GetArray();
        echo '<pre>';print_r($Campus);
        
        
    }//function SedesCampus
}
$informeEspacios1 = new InformeEspacios();
$horaInicioSolicitud = $_REQUEST['HoraInicio'];
$horaFinSolicitud = $_REQUEST['HoraFinal'];
$accesoDiscapacitados = $_REQUEST['AccesoDiscapacitados'];
$informeEspacios1->listaSalonesPorSede();

foreach ($_REQUEST['Fechas'] as $key => $value) {
	$informeEspacios1->salonesOcupados($value,$horaInicioSolicitud,$horaFinSolicitud,$accesoDiscapacitados);
	
	$informeEspacios1->salonesLibres($horaInicioSolicitud,$horaFinSolicitud,$value);
}
// $informeEspacios1->retornarListaSalonesLibres();
$informeEspacios1->imprimir();
unset($informeEspacios1);

function RestarHoras($horaini,$horafin)
{
	$horai=substr($horaini,0,2);
	$mini=substr($horaini,3,2);
	$segi=substr($horaini,6,2);

	$horaf=substr($horafin,0,2);
	$minf=substr($horafin,3,2);
	$segf=substr($horafin,6,2);

	$ini=((($horai*60)*60)+($mini*60)+$segi);
	$fin=((($horaf*60)*60)+($minf*60)+$segf);

	$dif=$fin-$ini;

	$difh=floor($dif/3600);
	$difm=floor(($dif-($difh*3600))/60);
	$difs=$dif-($difm*60)-($difh*3600);
	return date("H-i-s",mktime($difh,$difm,$difs));
}

?>