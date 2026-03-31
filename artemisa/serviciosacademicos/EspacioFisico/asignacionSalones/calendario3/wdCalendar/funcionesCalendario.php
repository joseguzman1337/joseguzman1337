<?php
session_start();

require_once("../../../templates/template.php");
include_once('../../../Solicitud/AsignacionSalon.php'); 
include('../../../Interfas/InterfazSolicitud_class.php');  $C_InterfazSolicitud = new InterfazSolicitud();

$db = getBD();

$SQL_User='SELECT idusuario as id, codigorol FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';

		if($Usario_id=&$db->Execute($SQL_User)===false){
				echo 'Error en el SQL Userid...<br>'.$SQL_User;
				die;
			}
		
		$userid=$Usario_id->fields['id'];
// var_dump($db);
// echo "<pre>"; print_r($_REQUEST);

/**
* Parametros Asignacion Espacios
*/
class ParametrosAsignacionEspacios
{
    var $arreglos = array();
    function __construct()
    {
        $consultaSede = "SELECT ce1.ClasificacionEspacionPadreId 
        FROM ClasificacionEspacios ce1
        WHERE ClasificacionEspaciosId= 
        (select ce.ClasificacionEspacionPadreId 
            from ClasificacionEspacios ce 
            WHERE ce.ClasificacionEspaciosId=".$_REQUEST['idTipoSalon'].")";
        $ejecutarConsultaSede = mysql_query($consultaSede);
        $rowEjecutarConsultaSede = mysql_fetch_object($ejecutarConsultaSede);

        $this->arreglos['Sede'] = $rowEjecutarConsultaSede->ClasificacionEspacionPadreId;
        $this->arreglos['tipoSalon'] = $_REQUEST['tipoSalon'];
        $this->arreglos['F_inicial'] = $_REQUEST['fecha'];
        $this->arreglos['F_final'] = $_REQUEST['fecha'];
        $this->arreglos['H_inicial'] = $_REQUEST['hi'];
        $this->arreglos['H_final'] = $_REQUEST['hf'];
        $this->arreglos['accesoDiscapacitados'] = $_REQUEST['accesoDiscapacitados'];
        $this->arreglos['cupoMaximo'] = $_REQUEST['tamanioGrupos'];
        $this->arreglos['Grupo'] = $_REQUEST['Grupo'];
        $this->arreglos['Carrera'] = $_REQUEST['Carrera'];
    }
    function obtenerArreglo(){
        return $this->arreglos;
    }
    function obtenerResultado($C_AsignacionEspacio,$db,$sede,$tipoSalon,$fechaInicial,$fechaFinal,$horaInicial,$horaFinal,$accesoDiscapacitados,$cupoMaximo,$Grupo,$Carrera,$userid,$RolEspacioFisico){
        $C_AsignacionEspacio->Disponibilidad($db,$sede,$tipoSalon,$fechaInicial,$fechaFinal,$horaInicial,$horaFinal,$accesoDiscapacitados,$cupoMaximo,1,'',$Carrera,'../../',$userid,$RolEspacioFisico);
    }}
$ParametrosAsignacionEspacios = new ParametrosAsignacionEspacios;
$filas = $ParametrosAsignacionEspacios->obtenerArreglo();
$C_AsignacionEspacio = new AsignacionSalon();

$Data = $C_InterfazSolicitud->UsuarioMenu($db,$userid);        
$RolEspacioFisico   = $Data['Data'][0]['RolEspacioFisicoId'];
     
$ParametrosAsignacionEspacios->obtenerResultado($C_AsignacionEspacio,$db,$filas['Sede'],$filas['tipoSalon'],$filas['F_inicial'],$filas['F_final'],$filas['H_inicial'],$filas['H_final'],$filas['accesoDiscapacitados'],$filas['cupoMaximo'],$filas['Grupo'],$filas['Carrera'],$userid,$RolEspacioFisico);
unset($C_AsignacionEspacio);
unset($ParametrosAsignacionEspacios);


//El siguiente script selecciona la sede correspondiente al espacio físico seleccionado.

// $consultaSede = "SELECT ce1.ClasificacionEspacionPadreId 
// FROM ClasificacionEspacios ce1
// WHERE ClasificacionEspaciosId= 
// (select ce.ClasificacionEspacionPadreId 
// from ClasificacionEspacios ce 
// WHERE ce.ClasificacionEspaciosId=".$_REQUEST['idTipoSalon'].")";
// $ejecutarConsultaSede = mysql_query($consultaSede);
// $rowEjecutarConsultaSede = mysql_fetch_object($ejecutarConsultaSede);
// $rowEjecutarConsultaSede->ClasificacionEspacionPadreId;



/**
* Consulta de salones disponibles de acuerdo a la fecha, hora inicio, hora final, tipo salon,
* Tamaño grupo, Acceso a Discapacitado
*/
// var_dump(is_file('../../../Solicitud/AsignacionEspacios'))

// include_once('../../../Solicitud/AsignacionEspacios'); $C_AsignacionEspacio = new AsignacionSalon();
/*
$db,$Sede,$TipoSalon,$F_inicial,$F_final,$H_inicial,$H_final,$Acceso,$max
*/
// $C_AsignacionEspacio->Disponibilidad($db,);

// class ConsultaSalonesDisponibles{
//     var $listaSalones = array();
//     function __construct()
//     {
//         $queryConsultaSalonesDisponibles ="SELECT ce.ClasificacionEspaciosId
//                                         , ce.Nombre  
//                                         , ce.CapacidadEstudiantes
//                                         , ce.AccesoDiscapacitados
//                                         , ce.codigotiposalon
//                                         , dce.FechaFinVigencia
//                                         ,ce.ClasificacionEspaciosId
//                                         FROM ClasificacionEspacios ce 
//                                         INNER JOIN DetalleClasificacionEspacios dce ON dce.ClasificacionEspaciosId = ce.ClasificacionEspaciosId
//                                         INNER JOIN EspaciosFisicos ef ON ef.EspaciosFisicosId = ce.EspaciosFisicosId
//                                         WHERE ef.PermitirAsignacion = 1
//                                         AND dce.FechaFinVigencia >= NOW()
//                                         AND ce.AccesoDiscapacitados >= '".$_REQUEST['accesoDiscapacitados']."'
//                                         AND ce.CapacidadEstudiantes >= ".$_REQUEST['tamanioGrupos']."";
//         if($_REQUEST['tipoSalon']!='0'){
//             $queryConsultaSalonesDisponibles = $queryConsultaSalonesDisponibles." AND ce.codigotiposalon = '".$_REQUEST['tipoSalon']."'";
//         }
//         $ConsultaConsultaSalonesDisponibles = mysql_query($queryConsultaSalonesDisponibles);
//         while ($row = mysql_fetch_object($ConsultaConsultaSalonesDisponibles)) {
//             if ($row->ClasificacionEspaciosId=='212') {
//                 continue;
//             }
//            $this->listaSalones[] = $row->ClasificacionEspaciosId;
//         }

//         $this->consultaDisponibilidadSalones($this->listaSalones);
//     }
//     function consultaDisponibilidadSalones($listaSalones){
//         // var_dump($listaSalones);
//         // $listaSaloness = array('19','20','21', '22');
//         foreach ($listaSalones as $key => $codSalon) {
//             // echo $key." = ".$codSalon."<br>";
            // $consultSalones = "SELECT * FROM (
            //                 SELECT ae.AsignacionEspaciosId 
            //                 ,ae.FechaAsignacion as fecha 
            //                 ,ae.HoraInicio as horainicio 
            //                 ,ae.HoraFin as horafinal 
            //                 ,g.nombregrupo as grupos 
            //                 ,ce.Nombre as Salon 
            //                 ,ce.ClasificacionEspaciosId
            //                 FROM AsignacionEspacios ae 
            //                 INNER JOIN ClasificacionEspacios ce ON ce.ClasificacionEspaciosId=ae.ClasificacionEspaciosId 
            //                 INNER JOIN tiposalon ts ON ce.codigotiposalon=ts.codigotiposalon and ts.codigoestado=100 
            //                 INNER JOIN SolicitudEspacioGrupos seg ON seg.SolicitudAsignacionEspacioId=sae.SolicitudAsignacionEspacioId 
            //                 INNER JOIN grupo g ON g.idgrupo=seg.idgrupo
            //                 WHERE ce.ClasificacionEspaciosId = '$codSalon'
            //                 ) eventos
            //                 WHERE '".$_REQUEST['fecha']." ".$_REQUEST['hi']."' <> CONCAT(fecha,' ',horafinal) 
            //                 and '".$_REQUEST['fecha']." ".$_REQUEST['hf']."' <> CONCAT(fecha,' ',horainicio) 
            //                 and (
            //                 ('".$_REQUEST['fecha']." ".$_REQUEST['hi']."' BETWEEN CAST(CONCAT(fecha,' ',horainicio) AS DATETIME) AND CAST(CONCAT(fecha,' ',horafinal) AS DATETIME)) 
            //                 OR ('".$_REQUEST['fecha']." ".$_REQUEST['hf']."' BETWEEN CAST(CONCAT(fecha,' ',horainicio) AS DATETIME) and CAST(CONCAT(fecha,' ',horafinal) AS DATETIME) )
            //                 OR  (CAST(CONCAT(fecha,' ',horainicio) AS DATETIME)  BETWEEN '".$_REQUEST['fecha']." ".$_REQUEST['hi']."'  AND '".$_REQUEST['fecha']." ".$_REQUEST['hf']."'  ) 
            //                 OR (CAST(CONCAT(fecha,' ',horafinal) AS DATETIME)  BETWEEN '".$_REQUEST['fecha']." ".$_REQUEST['hi']."'  AND '".$_REQUEST['fecha']." ".$_REQUEST['hf']."'  )
            //                 )";
//             $queryConsultaEvento = mysql_query($consultSalones);
//             $resultadoConsulta = mysql_fetch_row($queryConsultaEvento);
//             if(!$resultadoConsulta){

//                 $scriptNomSalon = "SELECT ce.ClasificacionEspaciosId
//                                         , ce.Nombre  
//                                         , ce.CapacidadEstudiantes
//                                         , ce.AccesoDiscapacitados
//                                         , ce.codigotiposalon
//                                         , dce.FechaFinVigencia
//                                         ,ce.ClasificacionEspaciosId
//                                         , ts.nombretiposalon
//                                         FROM ClasificacionEspacios ce  
//                                         INNER JOIN DetalleClasificacionEspacios dce ON dce.ClasificacionEspaciosId = ce.ClasificacionEspaciosId
//                                         INNER JOIN EspaciosFisicos ef ON ef.EspaciosFisicosId = ce.EspaciosFisicosId
//                                         INNER JOIN tiposalon ts ON ce.codigotiposalon = ts.codigotiposalon
//                                         WHERE ef.PermitirAsignacion = 1
//                                         AND dce.FechaFinVigencia >= NOW()
//                                         AND ce.AccesoDiscapacitados >= '".$_REQUEST['accesoDiscapacitados']."'
//                                         AND ce.CapacidadEstudiantes >= ".$_REQUEST['tamanioGrupos']."
//                                         AND ce.ClasificacionEspaciosId= '$codSalon'";
//                 // $scriptNomSalon = "SELECT * FROM ClasificacionEspacios ce WHERE ce.ClasificacionEspaciosId= '$codSalon'";
//                 $consultaNomSalon = mysql_query($scriptNomSalon);
//                 $resultadoNomSalon = mysql_fetch_row($consultaNomSalon);
//                 // echo "<pre>"; var_dump($resultadoNomSalon);
//                 ?>
<!--
//                 <input type="radio" id ="idSalon" name="idSalon" value="<?php //echo $resultadoNomSalon[0]?>">
//                 <?php 
//                     echo $resultadoNomSalon[1]

//                 ?> 
//                 <br>
//                 <?php
//             }
//         }
//     }
//     function arregloListaSalones(){
//         return $this->listaSalones;
//     }
// }

// $salonDisponible = new ConsultaSalonesDisponibles;
// unset($salonDisponible);
// $salonDisponible->arregloListaSalones();


/**
* Calcular salon disponible
*/
// class ConsultaDisponibilidadSalon
// {
    
//     function __construct()
//     {
//         $consultSalones = "SELECT * FROM (
//                         SELECT ae.AsignacionEspaciosId 
//                         ,ae.FechaAsignacion as fecha 
//                         ,sae.HoraInicio as horainicio 
//                         ,sae.HoraFin as horafinal 
//                         ,g.nombregrupo as grupos 
//                         ,ce.Nombre as Salon 
//                         FROM AsignacionEspacios ae 
//                         INNER JOIN SolicitudAsignacionEspacios sae ON ae.SolicitudAsignacionEspacioId = sae.SolicitudAsignacionEspacioId 
//                         INNER JOIN ClasificacionEspacios ce ON ce.ClasificacionEspaciosId=ae.ClasificacionEspaciosId 
//                         INNER JOIN tiposalon ts ON ce.codigotiposalon=ts.codigotiposalon and ts.codigoestado=100 
//                         INNER JOIN SolicitudEspacioGrupos seg ON seg.SolicitudAsignacionEspacioId=sae.SolicitudAsignacionEspacioId 
//                         INNER JOIN grupo g ON g.idgrupo=seg.idgrupo
//                         WHERE ce.Nombre='".$_REQUEST['Salon']."'
//                         ) eventos
//                         WHERE '".$_REQUEST['fecha']." ".$_REQUEST['hi']."' <> CONCAT(fecha,' ',horafinal) 
//                         and '".$_REQUEST['fecha']." ".$_REQUEST['hf']."' <> CONCAT(fecha,' ',horainicio) 
//                         and (
//                         ('".$_REQUEST['fecha']." ".$_REQUEST['hi']."' BETWEEN CAST(CONCAT(fecha,' ',horainicio) AS DATETIME) AND CAST(CONCAT(fecha,' ',horafinal) AS DATETIME)) 
//                         OR ('".$_REQUEST['fecha']." ".$_REQUEST['hf']."' BETWEEN CAST(CONCAT(fecha,' ',horainicio) AS DATETIME) and CAST(CONCAT(fecha,' ',horafinal) AS DATETIME) )
//                         OR  (CAST(CONCAT(fecha,' ',horainicio) AS DATETIME)  BETWEEN '".$_REQUEST['fecha']." ".$_REQUEST['hi']."'  AND '".$_REQUEST['fecha']." ".$_REQUEST['hf']."'  ) 
//                         OR (CAST(CONCAT(fecha,' ',horafinal) AS DATETIME)  BETWEEN '".$_REQUEST['fecha']." ".$_REQUEST['hi']."'  AND '".$_REQUEST['fecha']." ".$_REQUEST['hf']."'  )
//                         )";
//         $queryConsultaEvento = mysql_query($consultSalones);
//         $resultadoConsulta = mysql_fetch_row($queryConsultaEvento);
//         if(!$resultadoConsulta){
//             echo "Disponible";
//         }else{
//             echo "No Disponible";
//         }
//   }
// }
// $fecha1 = new ConsultaDisponibilidadSalon;
?>