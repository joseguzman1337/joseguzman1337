<?php

require_once('../../../Connections/sala2.php');
mysql_select_db($database_sala, $sala);
session_start();
require_once('seguridadmateriasgrupos.php');
 

function limpiaCadena($cadena) {
    $cadena = str_replace("\'","[NEWLINE]",$cadena);
    $cadena=preg_replace('/[^(\x20-\x7F)]*/','',$cadena);      
    $cadena = str_replace("[NEWLINE]","\n",$cadena);
    $cadena= (ereg_replace("''", '', $cadena));
    $cadena= (ereg_replace("'", '', $cadena));
    return $cadena;
}
$campus =htmlentities($_POST['campus']);

$idgrupo = htmlentities($_POST['grupo']);
$idgrupo  = limpiaCadena($idgrupo);
//echo $idgrupo.'<br>';

$usuario = htmlentities($_POST['usuario']);
$usuario = limpiaCadena($usuario);

$codigocarrera = htmlentities($_POST['carrera']);
$codigocarrera  = limpiaCadena($codigocarrera);

$fechaini = htmlentities($_POST['fechaini']);
$fechaini = limpiaCadena($fechaini);

$fechafin = htmlentities($_POST['fechafin']);
$fechafin = limpiaCadena($fechafin);

$Observacion = htmlentities($_POST['observacion']);
$Observacion  = limpiaCadena($Observacion);
 
$usuarioconsulta = "select idusuario from usuario where usuario = '".trim($usuario)."'";
$datosusuario = mysql_query($usuarioconsulta, $sala);
$row_usuario = mysql_fetch_assoc($datosusuario);
$usuarioid= $row_usuario['idusuario']; 

$sqlhorario = "select h.codigodia, h.horainicial, h.horafinal, h.codigotiposalon from horario h where h.idgrupo= '".trim($idgrupo)."' order by h.codigodia";
$datoshorario = mysql_query($sqlhorario, $sala);
//echo $sqlhorario.'<br>';                       
$total_rows_horario2 = mysql_num_rows($datoshorario); 
while($row_horario2 = mysql_fetch_assoc($datoshorario))
{
    $dias[] = $row_horario2['codigodia'];
    $C_horario[] = $row_horario2['codigodia'].'::'.$row_horario2['horainicial'].'::'.$row_horario2['horafinal'];
}

include_once("../../../EspacioFisico/Solicitud/SolicitudEspacio_class.php");  $SolicitudEspacio= new SolicitudEspacio();
include_once("../../../EspacioFisico/Solicitud/festivos.php");  $festivos= new festivos();
$Datafechas = $SolicitudEspacio->FechasFuturas('35', trim($fechaini), trim($fechafin),$dias);

$fechapadre = date("Y-m-d H:i:s");
$sqlsolicitudpadre= "INSERT INTO SolicitudPadre (UsuarioCreacion, UsuarioUltimaModificacion,  FechaCreacion, FechaUltimaModificacion,  CodigoEstado) VALUES ('".$usuarioid."', '".$usuarioid."', '".$fechapadre."', '".$fechapadre."', '100')";
//echo $sqlsolicitudpadre.'<br>';
$insertpadre = mysql_query($sqlsolicitudpadre, $sala);
$idpadre=mysql_insert_id();

$solicitudes = array();
$i =0; 
$solicitudes['idpadre']= $idpadre;

$sqlhorario = "select h.codigodia, h.horainicial, h.horafinal, h.codigotiposalon from horario h where h.idgrupo= '".trim($idgrupo)."' order by h.codigodia";
$datoshorario = mysql_query($sqlhorario, $sala);
//echo $sqlhorario.'<br>';                       
$total_rows_horario = mysql_num_rows($datoshorario); 

if($total_rows_horario!= 0)
{
    while($row_horario = mysql_fetch_assoc($datoshorario))
    {                                  
        $sqlinsertsolicitudespacios = "INSERT INTO SolicitudAsignacionEspacios (AccesoDiscapacitados, FechaInicio, FechaFinal, idsiq_periodicidad, ClasificacionEspaciosId, codigoestado, UsuarioCreacion, UsuarioUltimaModificacion, FechaCreacion, FechaUltimaModificacion, codigodia, observaciones, Estatus, codigomodalidadacademica, codigocarrera) VALUES ('0', '".trim($fechaini)."', '".trim($fechafin)."', '35', '".$campus."', '100', '".$usuarioid."', '".$usuarioid."','".$fechapadre."', '".$fechapadre."', '".$row_horario['codigodia']."', '".$Observacion."', '3', '001', '".trim($codigocarrera)."')";
         //echo $sqlinsertsolicitudespacios.'<br>'; 
        $solicitudespacios = mysql_query($sqlinsertsolicitudespacios, $sala);                
        $idsolicitudespacios =mysql_insert_id();
        $solicitudes['solicitud'.$i] =$idsolicitudespacios;
        
        $Solicitud_Dia[$row_horario['codigodia']][$row_horario['horainicial']]=$idsolicitudespacios;
       
        
        $sqlinserttiposalon = "INSERT INTO SolicitudAsignacionEspaciostiposalon (SolicitudAsignacionEspacioId, codigotiposalon) VALUES ('".$idsolicitudespacios."', '".$row_horario['codigotiposalon']."')";
        $tiposalon= mysql_query($sqlinserttiposalon, $sala);
        //echo $sqlinserttiposalon.'<br>';
                              
        $sqlasociacionsolicitud = "INSERT INTO AsociacionSolicitud (SolicitudPadreId, SolicitudAsignacionEspaciosId) VALUES ('".$idpadre."', '".$idsolicitudespacios."')";
        $idasociacion= mysql_query($sqlasociacionsolicitud, $sala);
        //echo $sqlasociacionsolicitud.'<br>';
       
        $sqlinsertsolicitudespaciogrupo = "INSERT INTO SolicitudEspacioGrupos (SolicitudAsignacionEspacioId, idgrupo) VALUES ('".$idsolicitudespacios."', '".trim($idgrupo)."')";
       mysql_query($sqlinsertsolicitudespaciogrupo, $sala);
        //echo $sqlinsertsolicitudespaciogrupo.'<br>';
          
       $i++;
    }
             
       for($d=0; $d<count($dias); $d++){
            $_DataHorario = explode('::',$C_horario[$d]);
            
            $H_1 = $_DataHorario[1];
            $H_2 = $_DataHorario[2];
            
            $S_Hijo = $Solicitud_Dia[$dias[$d]][$H_1];
             
             
           for($i=0; $i< count($Datafechas[$d]);$i++){
                
            $c_fecha = explode("-", $Datafechas[$d][$i]);
            
                $result_festivo = $festivos->esFestivo($c_fecha[2],$c_fecha[1], $c_fecha[0]);
                if($result_festivo === FALSE)
                {
                  $sqlfechas = "select AsignacionEspaciosId from AsignacionEspacios where FechaAsignacion= '".$Datafechas[$d][$i]."' and HoraInicio = '".$row_horario['horainicial']."' and HoraFin= '".$row_horario['horafinal']."' and SolicitudAsignacionEspacioId = '".$idsolicitudespacios."'";
                  //echo $sqlfechas.'<br>';
                   $resultvalor= mysql_query($sqlfechas, $sala); 
                   $total_rows_resultvalor = mysql_num_rows($resultvalor);
                   if($total_rows_resultvalor['AsignacionEspaciosId'] == null)
                   {
                      $sqlasignacionespacio = "INSERT INTO AsignacionEspacios (FechaAsignacion, SolicitudAsignacionEspacioId, codigoestado, UsuarioCreacion, UsuarioUltimaModificacion, FechaCreacion, FechaultimaModificacion, ClasificacionEspaciosId, HoraInicio, HoraFin, EstadoAsignacionEspacio, Observaciones, Modificado, Enviado, FechaAsignacionAntigua) VALUES ('".trim($Datafechas[$d][$i])."', '".$S_Hijo."', '100', '".$usuarioid."', '".$usuarioid."', '".$fechapadre."', '".$fechapadre."', '212', '".$H_1."', '".$H_2."', '1', NULL, '0', '0', NULL)";
                      
        $idasociacion= mysql_query($sqlasignacionespacio, $sala);
        //echo $sqlasignacionespacio.'<br>';
                   } 
                } 
           }//for                   
       } //for    
}
echo json_encode($solicitudes); 
//echo $idpadre;
?>