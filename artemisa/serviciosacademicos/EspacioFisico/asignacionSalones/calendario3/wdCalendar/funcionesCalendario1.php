<?php
require_once("../../../templates/template.php");
$db = getBD();
// var_dump($db);
// echo "<pre>"; print_r($_REQUEST);

/**
* 
*/
class ActualizarEvento
{
	private $a_vectt;
	var $arregloActualizar = array();
	function __construct()
	{
		if ($_REQUEST['datetimepicker1']==$_REQUEST['datetimepicker2']) {
			$a_vectt['val']     = false;
            $a_vectt['descrip']	='Fechas iguales.';
            echo json_encode($a_vectt);
            exit;
		}elseif($_REQUEST['datetimepicker1']>$_REQUEST['datetimepicker2']){
			$a_vectt['val']     = false;
            $a_vectt['descrip']	='La hora inicial no puede ser mayor a la hora final.';
            echo json_encode($a_vectt);
            exit;
		}else{
			$this->arregloActualizar['fecha'] = $_REQUEST['datetimepickerfecha'];
			$this->arregloActualizar['tipoSalon'] = $_REQUEST['listaTipoSalon'];
			$this->arregloActualizar['accesoDiscapacitados'] = $_REQUEST['accesoDiscapacitados'];
			$this->arregloActualizar['HoraInicio'] = $_REQUEST['datetimepicker1'].':00';
			$this->arregloActualizar['HoraFin'] = $_REQUEST['datetimepicker2'].':00';
			$this->arregloActualizar['accesoDiscapacitados'] = $_REQUEST['accesoDiscapacitados'];
			$this->arregloActualizar['codigoSalon'] = $_REQUEST['codSalon'];
			if (!isset($_REQUEST['EspacioCheck'])) {
				$this->arregloActualizar['codigoSalon'] = $_REQUEST['codSalon'];
			}else{
				foreach ($_REQUEST['EspacioCheck'] as $key => $value) {
					if (empty($value)) {
						continue;
					}
					$this->arregloActualizar['codigoSalon'] = $value;
				}
			}
			$this->arregloActualizar['SolicitudAsignacionEspacioId'] = $_REQUEST['SolicitudAsignacionEspacioId'];
			$this->arregloActualizar['idEvento'] = $_REQUEST['idEvento'];
		}
	}
	function actualiza($db){
		$verificaDisponibilidad = "SELECT * FROM (
                SELECT ae.AsignacionEspaciosId 
                	,ae.FechaAsignacion as fecha 
                    ,ae.HoraInicio as horainicio 
                    ,ae.HoraFin as horafinal 
                    ,g.nombregrupo as grupos
                    ,ce.Nombre as Salon
                    ,g.maximogrupo
                    ,ce.ClasificacionEspaciosId
                    ,ts.codigotiposalon
                    ,sae.AccesoDiscapacitados
                    ,ae.SolicitudAsignacionEspacioId,
                    sae,codigomodalidadacademica
                    FROM AsignacionEspacios ae 
                    INNER JOIN SolicitudAsignacionEspacios sae ON ae.SolicitudAsignacionEspacioId = sae.SolicitudAsignacionEspacioId 
                    INNER JOIN ClasificacionEspacios ce ON ce.ClasificacionEspaciosId=ae.ClasificacionEspaciosId 
                    INNER JOIN tiposalon ts ON ce.codigotiposalon=ts.codigotiposalon and ts.codigoestado=100 
                    INNER JOIN SolicitudEspacioGrupos seg ON seg.SolicitudAsignacionEspacioId=sae.SolicitudAsignacionEspacioId
                    INNER JOIN grupo g ON g.idgrupo=seg.idgrupo
                    WHERE ce.ClasificacionEspaciosId = ".$this->arregloActualizar['codigoSalon']."

                ) eventos
                WHERE '".$this->arregloActualizar['fecha']." ".$this->arregloActualizar['HoraInicio']."' <> CONCAT(fecha,' ',horafinal) 
                and '".$this->arregloActualizar['fecha']." ".$this->arregloActualizar['HoraFin']."' <> CONCAT(fecha,' ',horainicio) 
                and (
                ('".$this->arregloActualizar['fecha']." ".$this->arregloActualizar['HoraInicio']."' BETWEEN CAST(CONCAT(fecha,' ',horainicio) AS DATETIME) AND CAST(CONCAT(fecha,' ',horafinal) AS DATETIME)) 
                OR ('".$this->arregloActualizar['fecha']." ".$this->arregloActualizar['HoraFin']."' BETWEEN CAST(CONCAT(fecha,' ',horainicio) AS DATETIME) and CAST(CONCAT(fecha,' ',horafinal) AS DATETIME) )
                OR  (CAST(CONCAT(fecha,' ',horainicio) AS DATETIME)  BETWEEN '".$this->arregloActualizar['fecha']." ".$this->arregloActualizar['HoraInicio']."'  AND '".$this->arregloActualizar['fecha']." ".$this->arregloActualizar['HoraFin']."'  ) 
                OR (CAST(CONCAT(fecha,' ',horafinal) AS DATETIME)  BETWEEN '".$this->arregloActualizar['fecha']." ".$this->arregloActualizar['HoraInicio']."'  AND '".$this->arregloActualizar['fecha']." ".$this->arregloActualizar['HoraFin']."'  )
                )";
		
		
		if($ejecutaVerificaDisponibilidad=&$db->Execute($verificaDisponibilidad)===false){
		 	echo 'Error en el SQL ....<br><br>'.$verificaDisponibilidad;die;
		 }

		if($ejecutaVerificaDisponibilidad->EOF){
            $validaDomingofecha = 0;
            if(($ejecutaVerificaDisponibilidad->fields['codigomodalidadacademica']=='001') || ($ejecutaVerificaDisponibilidad->fields['codigomodalidadacademica']==001)){
                $validaDomingofecha = 1;
            }
            
            if($validaDomingofecha==1){
                include_once('../../../Solicitud/AsignacionSalon.php');                           $C_AsignacionSalon = new AsignacionSalon();

                $DomingoTrue = $C_AsignacionSalon->DiasSemana($this->arregloActualizar['fecha']);
                
                if(($DomingoTrue!=7) || ($DomingoTrue!='7')){

                    $queryActualizarEvento = "UPDATE AsignacionEspacios ae 
                                          SET    ae.FechaAsignacion = '".$this->arregloActualizar['fecha']."', 
                                                 ae.HoraInicio='".$this->arregloActualizar['HoraInicio']."', 
                                                 ae.HoraFin='".$this->arregloActualizar['HoraFin']."', 
                                                 ae.ClasificacionEspaciosId = ".$this->arregloActualizar['codigoSalon'].",
                                                 ae.EstadoAsignacionEspacio=1,
                                                 ae.Modificado=1,
                                                 ae.FechaultimaModificacion=NOW()
                                          WHERE ae.AsignacionEspaciosId = ".$this->arregloActualizar['idEvento']." ";	
                    $ejecutarQueryActualizarEvento = mysql_query($queryActualizarEvento);
                }//diferente de domingo    
            }else{
                $queryActualizarEvento = "UPDATE AsignacionEspacios ae 
			                          SET    ae.FechaAsignacion = '".$this->arregloActualizar['fecha']."', 
                                             ae.HoraInicio='".$this->arregloActualizar['HoraInicio']."', 
                                             ae.HoraFin='".$this->arregloActualizar['HoraFin']."', 
                                             ae.ClasificacionEspaciosId = ".$this->arregloActualizar['codigoSalon'].",
                                             ae.EstadoAsignacionEspacio=1,
                                             ae.Modificado=1,
                                             ae.FechaultimaModificacion=NOW()
			                          WHERE ae.AsignacionEspaciosId = ".$this->arregloActualizar['idEvento']." ";	
			    $ejecutarQueryActualizarEvento = mysql_query($queryActualizarEvento);
            }

			$this->ret['val']			=true;
            $this->ret['descrip']		='Se ha Actualizado Correctamente...';
            $this->ret['Data']        =rand();
		}else{

			$this->ret['val']			=false;
            $this->ret['descrip']		='Error al actualizar el evento. "Oprima el botón "Buscar Espacios" para tratar de encontrar espacio disponible en la fecha y hora señalada."';
            $this->ret['Data']        =rand();
		}
        echo json_encode($this->ret);
	}
	function eliminar(){
		$queryEliminarEvento = "UPDATE AsignacionEspacios ae SET ae.codigoestado=200, ae.FechaultimaModificacion=NOW(),Modificado=1 WHERE ae.AsignacionEspaciosId  = ".$this->arregloActualizar['idEvento']."";
		$ejecutarQueryEliminarEvento = mysql_query($queryEliminarEvento);


		$this->ret['val']			=true;
        $this->ret['descrip']		='Se ha Eliminado Correctamente...';
        $this->ret['Data']        =rand();

        echo json_encode($this->ret);
	}
	function verArreglo(){
		var_dump($this->arregloActualizar);
	}
}
$actualizarEvento = new ActualizarEvento;
if ($_REQUEST['accion']==='eliminar') {
	$actualizarEvento->eliminar();
}
if($_REQUEST['accion']==='actualizar'){
	$actualizarEvento->actualiza($db);
}
unset($actualizarEvento);
?>
